<?php

namespace frontend\modules\app\controllers;

use Yii;
use frontend\modules\app\models\TbLuckyDraw;
use frontend\modules\app\models\TbLuckyDrawSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\app\models\TbItem;
use frontend\modules\app\models\TbProduct;
use yii\helpers\Json;
use frontend\modules\app\models\TbRewards;
use yii\web\Response;
use frontend\modules\app\models\TbItemRewards;
use yii\helpers\Html;
use frontend\modules\app\models\TbQrItem;
use frontend\modules\app\models\TbLuckyDarwReward;
use yii\helpers\ArrayHelper;
use frontend\modules\app\models\TbScanQr;
use yii\helpers\Url;
use mcomscience\sweetalert2\SweetAlert2;
use yii\filters\AccessControl;
use homer\widgets\Icon;

/**
 * LuckyDrawController implements the CRUD actions for TbLuckyDraw model.
 */
class LuckyDrawController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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
     * Lists all TbLuckyDraw models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TbLuckyDrawSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbLuckyDraw model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                $data = [];
                $TbLuckyDarwReward = TbLuckyDarwReward::find()->where(['lucky_draw_id' => $id])->all();
                foreach ($TbLuckyDarwReward as $luckyDarwReward) {
                    $tbItemReward = TbItemRewards::findOne($luckyDarwReward['item_rewards_id']);
                    $TbScanQr = TbScanQr::findOne($luckyDarwReward['qrcode_id']);
                    $data = ArrayHelper::merge($data, [
                                [
                                    'rewards_no' => '<span class="badge badge-success">รางวัลที่ ' . $tbItemReward['rewards_no'] . '</span>',
                                    'rewards_name' => $tbItemReward['rewards_name'],
                                    'qrcode_id' => '<i class="fa fa-qrcode"></i> ' . $luckyDarwReward['qrcode_id'],
                                    'tel' => '<i class="fa fa-phone"></i> ' . $TbScanQr->profile->tel,
                                    'fullname' => '<i class="fa fa-user"></i> ' . $TbScanQr->profile->fullname,
                                    'data' => [
                                        'item_rewards_id' => $luckyDarwReward['item_rewards_id'],
                                        'qrcode_id' => $luckyDarwReward['qrcode_id']
                                    ],
                                ]
                    ]);
                }
                return [
                    'title' => $model['lucky_draw_name'],
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                        'data' => $data,
                    ]),
                    'footer' => Html::button(Icon::show('close') . Yii::t('frontend', 'Close'), [
                        'class' => 'btn btn-default',
                        'data-dismiss' => 'modal'
                    ])
                ];
            }
        }
    }

    /**
     * Creates a new TbLuckyDraw model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TbLuckyDraw();
        $modelItem = new TbItem();
        $modelProduct = new TbProduct();
        $data = [];

        if ($model->load(Yii::$app->request->post()) && $modelItem->load(Yii::$app->request->post())) {
            
        }

        return $this->render('create', [
                    'model' => $model,
                    'modelItem' => $modelItem,
                    'modelProduct' => $modelProduct,
                    'data' => $data,
        ]);
    }

    /**
     * Updates an existing TbLuckyDraw model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->product_id = Json::decode($model->product_id);
        $modelItem = new TbItem();
        $modelProduct = new TbProduct();

        if ($model->load(Yii::$app->request->post()) && $modelItem->load(Yii::$app->request->post())) {
            $TbItem = Yii::$app->request->post('TbItem');
            $modelItem['item_id'] = $TbItem['item_id'];
        }

        $data = [];
        $TbLuckyDarwReward = TbLuckyDarwReward::find()->where(['lucky_draw_id' => $id])->all();
        foreach ($TbLuckyDarwReward as $luckyDarwReward) {
            $tbItemReward = TbItemRewards::findOne($luckyDarwReward['item_rewards_id']);
            $TbScanQr = TbScanQr::findOne($luckyDarwReward['qrcode_id']);
            $data = ArrayHelper::merge($data, [
                        [
                            'rewards_no' => '<span class="badge badge-success">รางวัลที่ ' . $tbItemReward['rewards_no'] . '</span>',
                            'rewards_name' => $tbItemReward['rewards_name'],
                            'qrcode_id' => '<i class="fa fa-qrcode"></i> ' . $luckyDarwReward['qrcode_id'],
                            'tel' => '<i class="fa fa-phone"></i> ' . $TbScanQr->profile->tel,
                            'fullname' => '<i class="fa fa-user"></i> ' . $TbScanQr->profile->fullname,
                            'data' => [
                                'item_rewards_id' => $luckyDarwReward['item_rewards_id'],
                                'qrcode_id' => $luckyDarwReward['qrcode_id']
                            ],
                        ]
            ]);
        }


        return $this->render('update', [
                    'model' => $model,
                    'modelItem' => $modelItem,
                    'modelProduct' => $modelProduct,
                    'data' => $data
        ]);
    }

    /**
     * Deletes an existing TbLuckyDraw model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        TbLuckyDarwReward::deleteAll(['lucky_draw_id' => $id]);
        \Yii::$app->session->setFlash(SweetAlert2::TYPE_SUCCESS, \Yii::t('frontend', 'Deleted!'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the TbLuckyDraw model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbLuckyDraw the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbLuckyDraw::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionRewradItem($rewards_id) {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $ItemRewards = TbItemRewards::find()->where(['rewards_id' => $rewards_id])->all();
        $li = [];
        foreach ($ItemRewards as $ItemReward) {
            $li[] = Html::tag('li', '<h4>รางวัลที่ ' . $ItemReward['rewards_no'] . '</h4> ' . $ItemReward['rewards_name'] . ' จำนวน ' . $ItemReward['rewards_amount'] . ' รางวัล มูลค่ารวม ' . (empty($ItemReward['rewards_amount']) ? '0' : number_format($ItemReward['rewards_amount'], 2)) . ' บาท');
        }
        return Html::tag('ul', implode("\n", $li));
    }

    public function actionRandomRewrad() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $dataItem = $request->post('TbItem'); #ชุดรางวัล
            $dataLuckyDraw = $request->post('TbLuckyDraw');
            $dataProduct = $request->post('TbProduct');

            #ข้อมูลรางวัล
            /*
              รางวัลที่ 1
              iphone x จำนวน 1 รางวัล มูลค่ารวม 1.00 บาท
              รางวัลที่ 2
              iphone xs จำนวน 2 รางวัล มูลค่ารวม 2.00 บาท
             */
            $TbItemRewards = TbItemRewards::find()->where(['rewards_id' => $dataLuckyDraw['rewards_id']])->all();

            #คิวอาร์โค้ดที่สแกนที่ต้องการเอามาสุ่มรางวัล
            $QrItems = (new \yii\db\Query())
                    ->select([
                        'tb_qr_item.allow_lucky_draw',
                        'tb_product.product_name',
                        'tb_item.item_name',
                        'tb_scan_qr.qrcode_id',
                        '`profile`.first_name',
                        '`profile`.last_name',
                        '`profile`.tel',
                        'CONCAT(`profile`.first_name, \' \', `profile`.last_name) as fullname',
                        'tb_scan_qr.user_id'
                    ])
                    ->from('tb_scan_qr')
                    ->innerJoin('tb_qr_item', 'tb_qr_item.qrcode_id = tb_scan_qr.qrcode_id')
                    ->innerJoin('tb_product', 'tb_product.product_id = tb_qr_item.product_id')
                    ->innerJoin('tb_item', 'tb_item.item_id = tb_product.item_id')
                    ->innerJoin('`profile`', '`profile`.user_id = tb_scan_qr.user_id')
                    ->where([
                        'tb_product.product_id' => $dataLuckyDraw['product_id'],
                        'tb_qr_item.allow_lucky_draw' => 1,
                        'tb_item.item_id' => $dataLuckyDraw['item_id'],
                    ])
                    ->all();
            #map คิวอาร์กับเบอร์โทร
            $mapQrcodescan = ArrayHelper::map($QrItems, 'qrcode_id', 'tel');
            #map คิวอาร์กับชื่อ
            $mapQrcodeFullname = ArrayHelper::map($QrItems, 'qrcode_id', 'fullname');
            #map คิวอาร์กับ ไอดี
            $mapQrcodeUserId = ArrayHelper::map($QrItems, 'qrcode_id', 'user_id');
            #รหัสคิวอาร์โค้ดที่สแกน
            $qrcodescan = ArrayHelper::getColumn($QrItems, 'qrcode_id');
            #ข้อมูลคิวอาร์โค้ดที่เคยออกรางวัลแล้ว
            $TbLuckyDarwReward = TbLuckyDarwReward::find()->all();
            #รหัสคิวอาร์โค้ดที่เคยออกรางวัลแล้ว
            $qrcodereward = ArrayHelper::getColumn($TbLuckyDarwReward, 'qrcode_id');
            #รหัสคิวอาร์โค้ดจะเอามาออกรางวัล
            $qrcodeRandom = array_values(array_diff($qrcodescan, $qrcodereward));
            #รหัสคิวอาร์โค้ดก่อนสุ่มรางวัล
            $oldcoderandom = $qrcodeRandom;
            #รหัสคิวอาร์โค้ดที่เหลือหลังสุ่มรางวัล
            $newcoderandom = [];
            #รางวัลที่สุ่ม
            $rewrads = [];
            if (is_array($qrcodeRandom) && !empty($qrcodeRandom)) {
                foreach ($TbItemRewards as $tbItemReward) {
                    $qty = $tbItemReward['rewards_amount']; #จำนวนรางวัล
                    for ($i = 1; $i <= $qty; $i++) {#สุ่มรางวัลตามจำนวนรางวัล
                        if (is_array($qrcodeRandom) && !empty($qrcodeRandom)) {
                            $key = array_rand($qrcodeRandom); #สุ่มรัสคิวอาร์โค้ด
                            if (!isset($qrcodeRandom[$key])) {
                                continue;
                            }
                            $userId = ArrayHelper::getValue($mapQrcodeUserId, $qrcodeRandom[$key]); #ไอดีคนที่สุ่มรางวัล
                            #เก็บข้อมูลรางวัล
                            $rewrads = ArrayHelper::merge($rewrads, [
                                        [
                                            'rewards_no' => '<span class="badge badge-success">รางวัลที่ ' . $tbItemReward['rewards_no'] . '</span>',
                                            'rewards_name' => $tbItemReward['rewards_name'],
                                            'qrcode_id' => '<i class="fa fa-qrcode"></i> ' . $qrcodeRandom[$key],
                                            'tel' => '<i class="fa fa-phone"></i> ' . ArrayHelper::getValue($mapQrcodescan, $qrcodeRandom[$key]),
                                            'fullname' => '<i class="fa fa-user"></i> ' . ArrayHelper::getValue($mapQrcodeFullname, $qrcodeRandom[$key]),
                                            'data' => [
                                                'item_rewards_id' => $tbItemReward['item_rewards_id'],
                                                'qrcode_id' => $qrcodeRandom[$key]
                                            ],
                                        ]
                            ]);
                            #ลบรหัสที่สุ่มได้
                            unset($qrcodeRandom[$key]);
                            #ลบรหัสคิวอาร์ของคนที่ถูกรางวัล
                            $modelTbScanQr = TbScanQr::find()->where(['user_id' => $userId])->all();
                            $qrcodeUser = ArrayHelper::getColumn($modelTbScanQr, 'qrcode_id');
                            foreach ($qrcodeRandom as $k => $qrcode) {
                                if (ArrayHelper::isIn($qrcode, $qrcodeUser)) {
                                    unset($qrcodeRandom[$k]);
                                }
                            }
                            #เก็บข้อมูลรหัสคิวอาร์โค้ดที่สุ่มรางวัล
                            //$newcoderandom = $qrcodeRandom;
                        }
                    }
                }
            }

            return [
                'rewrads' => $rewrads,
                'qrcodeRandom' => $oldcoderandom,
                'qrcodescan' => $qrcodescan,
                'QrItems' => $QrItems
            ];
        }
    }

    public function actionSaveRewrads() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $actionRequest = $request->post('action');
            $data = $request->post('TbLuckyDraw');
            if ($actionRequest == 'create') {
                $model = new TbLuckyDraw();
            } else {
                $model = TbLuckyDraw::findOne($data['lucky_draw_id']);
                TbLuckyDarwReward::deleteAll(['lucky_draw_id' => $data['lucky_draw_id']]);
            }
            $success = false;
            $rewrads = $request->post('rewrads');
            $transaction = TbLuckyDraw::getDb()->beginTransaction();
            try {
                $model->created_at = $data['created_at'];
                $model->lucky_draw_name = $data['lucky_draw_name'];
                $model->rewards_id = $data['rewards_id'];
                $model->item_id = $data['item_id'];
                $model->product_id = Json::encode($request->post('productIDs'));
                if ($model->save()) {
                    foreach ($rewrads as $rewrad) {
                        $modelRewrad = new TbLuckyDarwReward();
                        $modelRewrad->item_rewards_id = $rewrad['data']['item_rewards_id'];
                        $modelRewrad->qrcode_id = $rewrad['data']['qrcode_id'];
                        $modelRewrad->lucky_draw_id = $model['lucky_draw_id'];
                        if ($modelRewrad->save()) {
                            $success = true;
                        }
                    }
                    $transaction->commit();
                    return [
                        'success' => true,
                        'message' => 'บันทึกสำเร็จ!',
                        'url' => Url::to(['index'])
                    ];
                } else {
                    $transaction->rollBack();
                    return [
                        'success' => false,
                        'validate' => \yii\widgets\ActiveForm::validate($model)
                    ];
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
    }

}
