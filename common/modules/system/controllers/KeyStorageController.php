<?php

namespace common\modules\system\controllers;

use common\modules\system\models\search\KeyStorageItemSearch;
use common\modules\system\models\KeyStorageItem;
use common\traits\FormAjaxValidationTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use mcomscience\sweetalert2\SweetAlert2;

/**
 * KeyStorageController implements the CRUD actions for KeyStorageItem model.
 */
class KeyStorageController extends Controller
{
    use FormAjaxValidationTrait;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all KeyStorageItem models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new KeyStorageItem();

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash(SweetAlert2::TYPE_SUCCESS, \Yii::t('backend', 'Created successfully!'));
            return $this->redirect(['index']);
        } else {
            $searchModel = new KeyStorageItemSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort = [
                'defaultOrder' => ['key' => SORT_DESC],
            ];

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing KeyStorageItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->keyStorage->removeCache($model['key']);
            \Yii::$app->session->setFlash(SweetAlert2::TYPE_SUCCESS, \Yii::t('backend', 'Updated successfully!'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing KeyStorageItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        \Yii::$app->session->setFlash(SweetAlert2::TYPE_SUCCESS, \Yii::t('backend', 'Deleted!'));
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the KeyStorageItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return KeyStorageItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KeyStorageItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
