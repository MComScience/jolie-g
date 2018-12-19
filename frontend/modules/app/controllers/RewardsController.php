<?php

namespace frontend\modules\app\controllers;

use Yii;
use frontend\modules\app\models\TbRewards;
use frontend\modules\app\models\TbRewardsSearch;
use frontend\modules\app\models\TbItemRewards;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use homer\widgets\Icon;
use kartik\form\ActiveForm;
use mcomscience\data\DataColumn;
use mcomscience\data\ActionColumn;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use mcomscience\sweetalert2\SweetAlert2;
/**
 * RewardsController implements the CRUD actions for TbRewards model.
 */
class RewardsController extends Controller {

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
     * Lists all TbRewards models.
     * @return mixed
     */
    public function actionIndex() {
//        $searchModel = new TbRewardsSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//

        $dataProvider = new ActiveDataProvider([
            'query' => (new \yii\db\Query())
                    ->select([
                        'tb_rewards.rewards_id',
                        'tb_rewards.rewards_group_name',
                        'tb_item_rewards.rewards_no',
                        'tb_item_rewards.rewards_name',
                        'tb_item_rewards.rewards_amount',
                        'tb_item_rewards.cost',
                        'tb_item_rewards.`comment`'
                    ])
                    ->from('tb_rewards')
                    ->join('INNER JOIN', 'tb_item_rewards', 'tb_item_rewards.rewards_id = tb_rewards.rewards_id')
                    ->orderBy('rewards_id desc'),
            'pagination' => [
                'pageSize' => 10,
            ],
            'key' => 'rewards_id',
        ]);
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbRewards model.
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
     * Creates a new TbRewards model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*
      public function actionCreate()
      {
      $model = new TbRewards();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->rewards_id]);
      }

      return $this->render('create', [
      'model' => $model,
      ]);
      }
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new TbRewards();
        $modelsItemRewards = [new TbItemRewards()];

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกรางวัล',
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        'modelsItemRewards' => (empty($modelsItemRewards)) ? [new TbItemRewards()] : $modelsItemRewards
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-success', 'type' => "submit"])
                ];
            } elseif ($model->load(Yii::$app->request->post())) {

                $modelsItemRewards = \homer\dynamicform\ModelMultiple::createMultiple(TbItemRewards::classname(), $modelsItemRewards, 'item_rewards_id');
                \homer\dynamicform\ModelMultiple::loadMultiple($modelsItemRewards, Yii::$app->request->post());

                // validate all models
                $valid = $model->validate();
                $valid = \homer\dynamicform\ModelMultiple::validateMultiple($modelsItemRewards) && $valid;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelsItemRewards as $modelsItemReward) {
                                $modelsItemReward->rewards_id = $model->rewards_id;
                                if (!($flag = $modelsItemReward->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                            return [
                                'forceReload' => '#crud-datatable-pjax',
                                'title' => "บันทึกรางวัล",
                                'content' => '<span class="text-success">Create success</span>',
                                'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"])
                            ];
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                } else {
                    return [
                        'title' => 'บันทึกรางวัล',
                        'content' => $this->renderAjax('create', [
                            'model' => $model,
                            'modelsItemRewards' => (empty($modelsItemRewards)) ? [new TbItemRewards()] : $modelsItemRewards
                        ]),
                        'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-success', 'type' => "submit"])
                    ];
                }
            } else {
                return [
                    'title' => 'บันทึกรางวัล',
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        'modelsItemRewards' => (empty($modelsItemRewards)) ? [new TbItemRewards()] : $modelsItemRewards
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-success', 'type' => "submit"])
                ];
            }
        }
    }

    /**
     * Updates an existing TbRewards model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelsItemRewards = TbItemRewards::find()->where(['rewards_id' => $id])->all();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => '',
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        'modelsItemRewards' => (empty($modelsItemRewards)) ? [new TbItemRewards()] : $modelsItemRewards
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } elseif ($model->load(Yii::$app->request->post())) {

                $oldIDs = ArrayHelper::map($modelsItemRewards, 'item_rewards_id', 'item_rewards_id');
                $modelsItemRewards = \homer\dynamicform\ModelMultiple::createMultiple(TbItemRewards::classname(), $modelsItemRewards, 'item_rewards_id');
                \homer\dynamicform\ModelMultiple::loadMultiple($modelsItemRewards, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsItemRewards, 'item_rewards_id', 'item_rewards_id')));

                // validate all models
                $valid = $model->validate();
                $valid = \homer\dynamicform\ModelMultiple::validateMultiple($modelsItemRewards) && $valid;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            if (!empty($deletedIDs)) {
                                TbItemRewards::deleteAll(['rewards_id' => $deletedIDs]);
                            }
                            foreach ($modelsItemRewards as $modelsItemReward) {
                                $modelsItemReward->rewards_id = $model->rewards_id;
                                if (!($flag = $modelsItemReward->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                            return [
                                'forceReload' => '#crud-datatable-pjax',
                                'title' => "",
                                'content' => '<span class="text-success">Create success</span>',
                                'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"])
                            ];
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                } else {
                    return [
                        'title' => '',
                        'content' => $this->renderAjax('create', [
                            'model' => $model,
                            'modelsItemRewards' => (empty($modelsItemRewards)) ? [new TbItemRewards()] : $modelsItemRewards
                        ]),
                        'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                    ];
                }
            } else {
                return [
                    'title' => '',
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        'modelsItemRewards' => (empty($modelsItemRewards)) ? [new TbItemRewards()] : $modelsItemRewards
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        }
    }

    /**
     * Deletes an existing TbRewards model.
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
     * Finds the TbRewards model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbRewards the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbRewards::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
