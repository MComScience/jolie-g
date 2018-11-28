<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use mcomscience\sweetalert2\SweetAlert2;
use homer\widgets\Icon;
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\SettingsForm $model
 */

$this->title = Yii::t('user', 'Account settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= SweetAlert2::widget(['useSessionFlash' => true]) ?>
<?php // $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'account-form',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    /*'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],*/
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                ]); ?>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'email', ['class' => 'col-sm-3 control-label']) ?>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'email', [
                            'showLabels' => false,
                            'addon' => ['prepend' => ['content' => Icon::show('envelope-o')]]
                        ])->textInput([
                            'placeholder' => $model->getAttributeLabel('email'),
                            'type' => 'email'
                        ]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'username', ['class' => 'col-sm-3 control-label']) ?>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'username', [
                            'showLabels' => false,
                            'addon' => ['prepend' => ['content' => Icon::show('user')]]
                        ])->textInput([
                            'placeholder' => $model->getAttributeLabel('username'),
                        ]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'new_password', ['class' => 'col-sm-3 control-label']) ?>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'new_password', [
                            'showLabels' => false,
                            'addon' => ['prepend' => ['content' => Icon::show('unlock-alt')]]
                        ])->passwordInput([
                            'placeholder' => $model->getAttributeLabel('new_password'),
                        ]) ?>
                    </div>
                </div>

                <hr/>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'current_password', ['class' => 'col-sm-3 control-label']) ?>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'current_password', [
                            'showLabels' => false,
                            'addon' => ['prepend' => ['content' => Icon::show('unlock-alt')]]
                        ])->passwordInput([
                            'placeholder' => $model->getAttributeLabel('current_password'),
                        ]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <?= Html::submitButton(Icon::show('save').Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?><br>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <?php if ($model->module->enableAccountDelete): ?>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('user', 'Delete account') ?></h3>
                </div>
                <div class="panel-body">
                    <p>
                        <?= Yii::t('user', 'Once you delete your account, there is no going back') ?>.
                        <?= Yii::t('user', 'It will be deleted forever') ?>.
                        <?= Yii::t('user', 'Please be certain') ?>.
                    </p>
                    <?= Html::a(Yii::t('user', 'Delete account'), ['delete'], [
                        'class' => 'btn btn-danger',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure? There is no going back'),
                    ]) ?>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
<?= $this->render('_mobile_menu') ?>