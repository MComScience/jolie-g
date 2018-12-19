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

/**
 * LuckyDrawController implements the CRUD actions for TbLuckyDraw model.
 */
class LuckyDrawController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
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
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TbLuckyDraw model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($item_id = null) {
        $model = new TbLuckyDraw();
        $modelItem = ($item_id != null) ? TbItem::findOne($item_id) : new TbItem();
        $modelProduct = new TbProduct();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->lucky_draw_id]);
        }

        return $this->render('create', [
                    'model' => $model,
                    'modelItem' => $modelItem,
                    'modelProduct' => $modelProduct,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->lucky_draw_id]);
        }

        return $this->render('update', [
                    'model' => $model,
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
                        'tb_product.product_id' => $dataProduct['product_id'],
                        'tb_qr_item.allow_lucky_draw' => 1,
                        'tb_item.item_id' => $dataItem['item_id'],
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
            $qrcodeRandom = array_diff($qrcodescan, $qrcodereward);
            #รหัสคิวอาร์โค้ดก่อนสุ่มรางวัล
            $oldcoderandom = $qrcodeRandom;
            #รหัสคิวอาร์โค้ดที่เหลือหลังสุ่มรางวัล
            $newcoderandom = [];
            #รางวัลที่สุ่ม
            $rewrads = [];
            if ($qrcodeRandom) {
                foreach ($TbItemRewards as $tbItemReward) {
                    $qty = $tbItemReward['rewards_amount']; #จำนวนรางวัล
                    for ($i = 1; $i <= $qty; $i++) {#สุ่มรางวัลตามจำนวนรางวัล
                        if ($qrcodeRandom) {
                            $key = shuffle($qrcodeRandom); #สุ่มรัสคิวอาร์โค้ด
                            $userId = ArrayHelper::getValue($mapQrcodeUserId, $qrcodeRandom[$key]); #ไอดีคนที่สุ่มรางวัล
                            #เก็บข้อมูลรางวัล
                            $rewrads = ArrayHelper::merge($rewrads, [
                                        [
                                            'rewards_no' => 'รางวัลที่ ' . $tbItemReward['rewards_no'],
                                            'rewards_name' => $tbItemReward['rewards_name'],
                                            'qrcode_id' => $qrcodeRandom[$key],
                                            'tel' => ArrayHelper::getValue($mapQrcodescan, $qrcodeRandom[$key]),
                                            'fullname' => ArrayHelper::getValue($mapQrcodeFullname, $qrcodeRandom[$key])
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

            return $rewrads;
        }
    }

}
