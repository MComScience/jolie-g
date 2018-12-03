<?php

namespace frontend\modules\app\controllers;

use mcomscience\sweetalert2\SweetAlert2;
use Yii;
use frontend\modules\app\models\TbScanQr;
use frontend\modules\app\models\TbScanQrSearch;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\traits\ModelTrait;
use homer\user\models\Account;

/**
 * ScanController implements the CRUD actions for TbScanQr model.
 */
class ScanController extends Controller
{
    use ModelTrait;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TbScanQr models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TbScanQrSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbScanQr model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TbScanQr model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TbScanQr();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->qrcode_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TbScanQr model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->qrcode_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TbScanQr model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TbScanQr model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TbScanQr the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TbScanQr::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionQrcode($code)
    {
        $this->layout = '@homer/views/layouts/_landing_page';
        $account = Account::findOne(['user_id' => Yii::$app->user->id, 'provider' => 'line']);
        //$modelCheck = $this->findModelQrItem($code);
        $modelScan = TbScanQr::findOne($code);
        $dataQr = TbScanQr::find()->where(['user_id' => Yii::$app->user->id])->all();
        if ($modelScan) {
            Yii::$app->session->setFlash(SweetAlert2::TYPE_ERROR, [
                [
                    'title' => Yii::$app->name,
                    'html' => 'หมายเลข ' . $code . ' ได้ถูกสแกนไปแล้ว! <br><span class="text-danger">ไม่สามารถสแกนซ้ำได้!</span>',
                    'confirmButtonText' => 'OK',
                ],
                [
                    'callback' => new \yii\web\JsExpression("
                        function (result) {
                            // handle dismiss, result.dismiss can be 'cancel', 'overlay', 'close', and 'timer'
                            if (result.value) {
                                $(\"html, body\").animate({scrollTop: $('#qrcode').offset().top}, \"slow\");
                            }
                        }
                    "),
                ],
            ]);
            return $this->render('_form_qrcode', [
                'account' => $account,
                'dataQr' => $dataQr
            ]);
        }
        $model = new TbScanQr();
        $model->qrcode_id = $code;
        if ($model->save()) {
            Yii::$app->session->setFlash(SweetAlert2::TYPE_SUCCESS, [
                [
                    'title' => Yii::$app->name,
                    'text' => 'ระบบได้ทำการบันทึกรายการของคุณแล้ว!',
                    'confirmButtonText' => 'OK',
                ],
                [
                    'callback' => new \yii\web\JsExpression("
                        function (result) {
                            // handle dismiss, result.dismiss can be 'cancel', 'overlay', 'close', and 'timer'
                            if (result.value) {
                                $(\"html, body\").animate({scrollTop: $('#qrcode').offset().top}, \"slow\");
                            }
                        }
                    "),
                ],
            ]);
            return $this->render('_form_qrcode', [
                'account' => $account,
                'dataQr' => $dataQr
            ]);
        } else {
            throw new \Exception(Json::encode($model->errors));
        }
    }
}
