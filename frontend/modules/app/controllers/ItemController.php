<?php

namespace frontend\modules\app\controllers;

use Yii;
use frontend\modules\app\models\TbItem;
use frontend\modules\app\models\TbItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use mcomscience\data\DataColumn;
use mcomscience\data\ActionColumn;
use homer\widgets\Icon;
use yii\bootstrap\Html;
use yii\web\Response;
use mcomscience\sweetalert2\SweetAlert2;
use yii\filters\AccessControl;
/**
 * ItemController implements the CRUD actions for TbItem model.
 */
class ItemController extends Controller {

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
     * Lists all TbItem models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TbItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbItem model.
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
                return [
                    'title' => 'ข้อมูลสินค้า',
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
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
     * Creates a new TbItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new TbItem();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกข้อมูลสินค้า',
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load(Yii::$app->request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'title' => 'บันทึกข้อมูลสินค้า',
                    'content' => '<span class="text-success">Create success</span>',
                    'footer' => ''
                ];
            } else {
                return [
                    'success' => false,
                    'validate' => \yii\widgets\ActiveForm::validate($model),
                    'title' => 'บันทึกข้อมูลสินค้า',
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            }
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->item_id]);
            }

            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TbItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'แก้ไขข้อมูลสินค้า',
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load(Yii::$app->request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'title' => 'แก้ไขข้อมูลสินค้า',
                    'content' => '<span class="text-success">Create success</span>',
                    'footer' => ''
                ];
            } else {
                return [
                    'success' => false,
                    'validate' => \yii\widgets\ActiveForm::validate($model),
                    'title' => 'แก้ไขข้อมูลสินค้า',
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            }
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->item_id]);
            }

            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TbItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        \Yii::$app->session->setFlash(SweetAlert2::TYPE_SUCCESS, \Yii::t('frontend', 'Deleted!'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the TbItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDataItem() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $dataProvider = new ActiveDataProvider([
            'query' => TbItem::find()->orderBy('item_id desc'),
        ]);
        $columns = Yii::createObject([
                    'class' => DataColumn::className(),
                    'dataProvider' => $dataProvider,
                    'formatter' => Yii::$app->formatter,
                    'columns' => [
                        [
                            'attribute' => 'item_name',
                        ],
                        [
                            'attribute' => 'created_by',
                            'value' => function($model, $key, $index) {
                                return $model->userCreate->fullname;
                            }
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => '{update} {delete}',
                            'updateOptions' => [
                                'icon' => Icon::show('edit') . 'แก้ไข',
                                'class' => 'btn btn-sm btn-success',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'role' => 'modal-remote'
                            ],
                            'deleteOptions' => [
                                'icon' => Icon::show('trash') . 'ลบ',
                                'class' => 'btn btn-sm btn-danger',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                            ],
                        ],
                    ],
        ]);
        return ['data' => $columns->renderDataColumns()];
    }

}
