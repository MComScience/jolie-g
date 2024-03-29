<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-12">
        <div class="text-center m-b-md">
            <h3><?= Yii::$app->name ?></h3>
            <small>PLEASE LOGIN TO APP</small>
        </div>
        <div class="hpanel">
            <div class="panel-body">
                <div class="hidden-xs hidden-sm">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'validateOnBlur' => false,
                        'validateOnType' => false,
                        'validateOnChange' => false,
                    ]) ?>
                    <div class="form-group">
                        <?php if ($module->debug): ?>
                            <?= $form->field($model, 'login', [
                                'inputOptions' => [
                                    'autofocus' => 'autofocus',
                                    'class' => 'form-control',
                                    'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                            ?>
                        <?php else: ?>

                            <?= $form->field($model, 'login',
                                ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1', 'placeholder' => 'ชื่อผู้ใช้งาน/อีเมล์']]
                            );
                            ?>

                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <?php if ($module->debug): ?>
                            <div class="alert alert-warning">
                                <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                            </div>
                        <?php else: ?>
                            <?= $form->field(
                                $model,
                                'password',
                                ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => 'รหัสผ่าน']])
                                ->passwordInput()
                                ->label(
                                    Yii::t('user', 'Password')
                                    . ($module->enablePasswordRecovery ?
                                        ' (' . Html::a(
                                            Yii::t('user', 'Forgot password?'),
                                            ['/user/recovery/request'],
                                            ['tabindex' => '5']
                                        )
                                        . ')' : '')
                                ) ?>
                        <?php endif ?>
                    </div>
                    <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>
                    <?= Html::submitButton(
                        Yii::t('user', 'Sign in'),
                        ['class' => 'btn btn-success btn-block', 'tabindex' => '4']
                    ) ?>
                    <?php ActiveForm::end(); ?>
                    <?php if ($module->enableConfirmation): ?>
                        <p class="text-center">
                            <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
                        </p>
                    <?php endif ?>
                    <?php if ($module->enableRegistration): ?>
                        <p class="text-center">
                            <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
                        </p>
                    <?php endif ?>
                </div>
                <p class="text-center">
                    <?php /*
                    <?= Connect::widget([
                        'baseAuthUrl' => ['/user/security/auth'],
                    ]) ?>
                    */ ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJsFile(
    'https://static.line-scdn.net/liff/edge/2/sdk.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJs(<<<JS
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};
if (/Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent)) {
    liff
    .init({
        liffId: "1552736042-KqeVvaMw",
        withLoginOnExternalBrowser: true,
    })
    .then(() => {
        if (!liff.isLoggedIn() && (liff.getOS() === 'ios' || liff.getOS() === 'android')) {
            liff.login()
        } else if(liff.isLoggedIn() && (liff.getOS() === 'ios' || liff.getOS() === 'android')) {
            liff.logout()
            setTimeout(() => {
                liff.login()
            }, 1000);
            // initializeApp()
        }
    })
    .catch((err) => {
        alert(JSON.stringify(err))
    })
}
async function initializeApp() {
	if (liff.isLoggedIn() && liff.isInClient()) {
		window.location.replace("/user/settings/profile")
	}
}
JS
);
?>
