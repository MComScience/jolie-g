<?php

namespace frontend\modules\app\controllers;

use Yii;
use frontend\modules\app\models\TbQrItem;
use homer\widgets\Icon;
use kartik\form\ActiveForm;
use mcomscience\sweetalert2\SweetAlert2;
use frontend\modules\app\models\TbProduct;
use frontend\modules\app\models\TbProductSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mcomscience\data\DataColumn;
use mcomscience\data\ActionColumn;
use common\traits\ModelTrait;
use yii\web\Response;

/**
 * ProductController implements the CRUD actions for TbProduct model.
 */
class ProductController extends Controller {

    use ModelTrait;

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
                    'delete-qrcode' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TbProduct models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TbProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbProduct model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModelProduct($id);
        if ($request->isAjax){
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet){
                return [
                    'title' => 'เลขที่ #'.$model['product_id'],
                    'content' => $this->renderAjax('view',[
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Icon::show('close').Yii::t('frontend', 'Close'),[
                        'class' => 'btn btn-default',
                        'data-dismiss' => 'modal'
                    ])
                ];
            }
        }
    }

    /**
     * Creates a new TbProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate() {
        $model = new TbProduct();

        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->save()) {
                $postData = Yii::$app->request->post('TbProduct');
                $codeItems = empty($postData['qrcode']) ? [] : explode(",", $postData['qrcode']);
                $connection = Yii::$app->db;
                $transaction = $connection->beginTransaction();
                try {
                    foreach ($codeItems as $qrcode) {
                        $modelQr = new TbQrItem();
                        $modelQr->qrcode_id = $qrcode;
                        $modelQr->product_id = $model->product_id;
                        if (!$modelQr->save()) {
                            throw new \Exception($modelQr->errors);
                        }
                    }
                    $transaction->commit();
                    return [
                        'success' => true,
                        'message' => 'บันทึกสำเร็จ!',
                        'url' => Url::to(['update','id' =>$model['product_id']])
                    ];
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            } else {
                return [
                    'success' => false,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing TbProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $items = [];
        /* if ($model->qrItems){
          foreach ($model->qrItems as $qrcode){
          $items[] = $qrcode['qrcode_id'];
          }
          $model->qrcode = implode(',',$items);
          } */

        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->save()) {
                return [
                        'success' => true,
                        'message' => 'บันทึกสำเร็จ!',
                        'url' => Url::to(['update', 'id' => $id])
                    ];
            } else {
                return [
                    'success' => false,
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TbProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        TbQrItem::deleteAll(['product_id' => $id]);
        \Yii::$app->session->setFlash(SweetAlert2::TYPE_SUCCESS, \Yii::t('frontend', 'Deleted!'));
        return $this->redirect(['index']);
    }

    public function actionDeleteQrcode($id) {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        TbQrItem::findOne($id)->delete();

        return 'Deleted!';
    }

    public function actionDeleteSelectAll() {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        TbQrItem::deleteAll(['qrcode_id' => Yii::$app->request->post('keys')]);

        return 'Deleted!';
    }

    /**
     * Finds the TbProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TbProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

   public function actionDataProduct()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $dataProvider = new ActiveDataProvider([
            'query' => TbProduct::find()->orderBy('created_at desc'),
        ]);
        $columns = Yii::createObject([
            'class' => DataColumn::className(),
            'dataProvider' => $dataProvider,
            'formatter' => Yii::$app->formatter,
            'columns' => [
                [
                    'attribute' => 'product_id',
                ],
                [
                    'attribute' => 'item_id',
                    'value' => function($model, $key, $index){
                        return !empty($model->item) ? $model->item->item_name : '';
                    }
                ],
                [
                    'attribute' => 'product_name',
                ],
                [
                    'attribute' => 'created_at',
                    'format' => [
                        'date',
                        'php:d/m/Y H:i น.'
                    ]
                ],
                [
                    'attribute' => 'updated_at',
                ],
                [
                    'attribute' => 'created_by',
                    'value' => function($model, $key, $index){
                        return $model->userCreate->fullname;
                    }
                ],
                [
                    'attribute' => 'note',
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{view} {print} {update} {delete}',
                    'viewOptions' => [
                        'icon' => Icon::show('eye').' คิวอาร์โค้ด',
                        'class' => 'btn btn-sm btn-success',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'role' => 'modal-remote'
                    ],
                    'updateOptions' => [
                        'icon' => Icon::show('edit').'แก้ไข',
                        'class' => 'btn btn-sm btn-success',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                    ],
                    'deleteOptions' => [
                        'icon' => Icon::show('trash').'ลบ',
                        'class' => 'btn btn-sm btn-danger',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                    ],
                    'buttons' => [
                        'print' => function ($url, $model, $key) {
                            return Html::a(Icon::show('qrcode').'พิมพ์คิวอาร์โค้ด', ['/app/generate-qr-code/print-qr-code', 'id' => $model['product_id']], [
                                'target' => '_blank',
                                'data-pjax' => 0,
                                'title' => 'พิมพ์คิวอาร์โค้ด',
                                'class' => 'btn btn-sm btn-info',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                            ]);
                        }
                    ],
                ],
            ],
        ]);
        return ['data' => $columns->renderDataColumns()];
    }

    public function actionDataQrcode($product_id) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModelProduct($product_id);
        $dataProvider = new ActiveDataProvider([
            'query' => TbQrItem::find()->where(['product_id' => $product_id]),
        ]);
        $columns = Yii::createObject([
                    'class' => DataColumn::className(),
                    'dataProvider' => $dataProvider,
                    'formatter' => Yii::$app->formatter,
                    'columns' => [
                        [
                            'attribute' => 'product_id',
                        ],
                        [
                            'attribute' => 'qrcode_id',
                        ],
                        [
                            'attribute' => 'checkbox',
                            'value' => function($model, $key, $index) {
                                return '<div class="checkbox">
                            <label>
                                <input type="checkbox" value="' . $model['qrcode_id'] . '" id="' . $model['qrcode_id'] . '" name="selection[]">
                                <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                            </label>
                        </div>';
                            },
                            'format' => 'raw'
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url, $model, $key) {
                                    return Html::a(Icon::show('trash') . 'ลบ', ['delete-qrcode', 'id' => $model['qrcode_id']], [
                                                'class' => 'btn btn-sm btn-danger on-delete',
                                                'title' => 'ลบ',
                                                'data-id' => $model['qrcode_id'],
                                                'data-toggle' => 'tooltip',
                                    ]);
                                }
                            ],
                        ],
                    ],
        ]);
        return ['data' => $columns->renderDataColumns()];
    }

    public function actionCreateQrcode($product_id) {
        $request = Yii::$app->request;
        $modelProduct = $this->findModelProduct($product_id);
        $modelQr = new TbQrItem();
        if ($request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึก คิวอาร์โค้ด',
                    'content' => $this->renderAjax('_form_qrcode', [
                        'model' => $modelProduct,
                        'modelQr' => $modelQr,
                    ]),
                    'footer' => ''
                ];
            } elseif ($modelProduct->load($request->post())) {
                $dataTbProduct = Yii::$app->request->post('TbProduct');
                $dataTbQrItem = Yii::$app->request->post('TbQrItem');
                $codeItems = empty($dataTbProduct['qrcode']) ? [] : explode(",", $dataTbProduct['qrcode']);
                $transaction = TbQrItem::getDb()->beginTransaction();
                try {
                    foreach ($codeItems as $qrcode) {
                        $modelQrItem = new TbQrItem();
                        $modelQrItem->scenario = 'create';
                        $modelQrItem->qrcode_id = $qrcode;
                        $modelQrItem->product_id = $product_id;
                        if (!$modelQrItem->save()) {
                            return $modelQrItem->errors;
                        }
                    }
                    $transaction->commit();
                    return [
                        'success' => true,
                        'message' => 'บันทึกสำเร็จ!',
                    ];
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            } else {
                return [
                    'success' => false,
                    'title' => 'บันทึก คิวอาร์โค้ด',
                    'content' => $this->renderAjax('_form_qrcode', [
                        'model' => $modelProduct,
                        'modelQr' => $modelQr,
                    ]),
                    'footer' => '',
                    'validate' => \kartik\widgets\ActiveForm::validate($modelQr)
                ];
            }
        }
    }

}
