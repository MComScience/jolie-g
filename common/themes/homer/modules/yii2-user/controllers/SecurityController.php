<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/11/2561
 * Time: 22:00
 */
namespace homer\user\controllers;

use dektrium\user\controllers\SecurityController as BaseSecurityController;
use dektrium\user\models\LoginForm;

class SecurityController extends BaseSecurityController
{
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }
        $session = \Yii::$app->session;
        $key = 'app-menus';
        if ($session->has($key)){
            $session->remove($key);
        }

        /** @var LoginForm $model */
        $model = \Yii::createObject(LoginForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);


        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);
            return $this->goBack();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
}