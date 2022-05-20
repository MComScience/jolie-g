<?php

namespace frontend\modules\v1\controllers;

use common\filters\auth\HttpBearerAuth;
use frontend\modules\app\models\TbScanQr;
use homer\user\models\Account;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\httpclient\Client;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class UserController extends ActiveController
{
    public $modelClass = 'homer\user\models\User';

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actions()
    {
        return [];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],

        ];

        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
                'view' => ['get'],
                'create' => ['post'],
                'update' => ['put'],
                'delete' => ['delete'],
                'login' => ['post'],
                'me' => ['get', 'post'],
                'save-qrcode' => ['POST'],
                'qrcode-list' => ['GET']
            ],
        ];

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = [
            'options',
            'login',
            'signup',
            'confirm',
            'password-reset-request',
            'password-reset-token-verification',
            'password-reset',
            'me',
            'save-qrcode',
            'qrcode-list'
        ];

        // setup access
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'create', 'update', 'delete'], //only be applied to
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'view', 'create', 'update', 'delete'],
                    'roles' => ['admin', '@'],
                ],
                [
                    'allow' => true,
                    'actions' => ['me', 'save-qrcode', 'qrcode-list'],
                    'roles' => ['?']
                ]
            ],
        ];

        return $behaviors;
    }

    /**
     * Return logged in user information
     *
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionMe()
    {
        $params = Yii::$app->request->queryParams;
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->addHeaders(['content-type' => 'application/x-www-form-urlencoded'])
            ->setUrl('https://api.line.me/oauth2/v2.1/verify')
            ->setData([
                'id_token' => $params['id_token'],
                'client_id' => '1583157145'
            ])
            ->send();
        if ($response->isOk) {
            $decoded = $response->data;
            $account = Account::findOne(['client_id' => $decoded['sub'], 'provider' => 'line']);
            return [
                'decoded' => $decoded,
                'account' => $account,
                'user' => $account->user,
                'profile' => [
                    'sex_name' => ArrayHelper::getValue($account, 'user.profile.tbSex.sex_name', ''),
                    'first_name' => ArrayHelper::getValue($account, 'user.profile.first_name', ''),
                    'last_name' => ArrayHelper::getValue($account, 'user.profile.last_name', ''),
                    'birthday' => ArrayHelper::getValue($account, 'user.profile.birthday', ''),
                    'tel' => ArrayHelper::getValue($account, 'user.profile.tel', ''),
                    'province_name' => ArrayHelper::getValue($account, 'user.profile.tbProvince.province_name', ''),
                ]
            ];
        } else {
            throw new HttpException($response->statusCode, $response->data['error_description']);
        }
    }

    public function actionSaveQrcode()
    {
        $body = Yii::$app->request->bodyParams;
        $account = Account::findOne(['user_id' => $body['user_id'], 'provider' => 'line']);
        $modelScan = TbScanQr::findOne($body['code']);
        if ($modelScan) {
            throw new HttpException(422, $body['code'].' ได้ถูกสแกนไปแล้ว ไม่สามารถสแกนซ้ำได้!');
        } else {
            $model = new TbScanQr();
            $model->qrcode_id = $body['code'];
            $model->user_id = $body['user_id'];
            if ($model->save()) {
                $qr_items = TbScanQr::find()->where(['user_id' => $body['user_id']])->orderBy('created_at desc')->all();
                return [
                    'account' => $account,
                    'qr_items' => $qr_items,
                ];
            } else {
                throw new HttpException(422, Json::encode($model->errors));
            }
        }
    }

    public function actionQrcodeList($userId) {
        $qr_items = TbScanQr::find()->where(['user_id' => $userId])->orderBy('created_at desc')->all();
        return $qr_items;
    }
}
