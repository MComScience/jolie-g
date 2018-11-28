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
use kartik\widgets\Select2;
use homer\user\models\TbSex;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;
use homer\user\models\TbProvince;
use homer\widgets\Icon;
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\User $model
 * @var dektrium\user\models\Account $account
 */

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="text-center m-b-md">
            <h3><?= Html::encode($this->title) ?></h3>
            <small><?= Yii::$app->name ?></small>
        </div>
        <div class="hpanel">
            <div class="panel-body">
                <div class="alert alert-info">
                    <p>
                        <?= Yii::t(
                            'user',
                            'In order to finish your registration, we need you to enter following fields'
                        ) ?>:
                    </p>
                </div>
                <br>
                <?php $form = ActiveForm::begin([
                    'id' => 'connect-account-form',
                    'fieldConfig' =>[
                        'showLabels' => false,
                    ],
                ]); ?>

                <div class="form-group">
                    <?= Html::activeLabel($profile, 'sex_id', ['class' => 'col-sm-3 control-label']) ?>
                    <div class="col-sm-6">
                        <?= $form->field($profile, 'sex_id')->radioList(ArrayHelper::map(TbSex::find()->asArray()->all(), 'sex_id', 'sex_name'), ['inline'=>true]) ?>
                    </div>
                </div>

                <?= $form->field($profile, 'first_name',[
                    'addon' => ['prepend' => ['content' => Icon::show('user',['framework' => Icon::PE7S])]]
                ])->textInput([
                    'placeholder' => $profile->getAttributeLabel('first_name')
                ]) ?>

                <?= $form->field($profile, 'last_name',[
                    'addon' => ['prepend' => ['content' => Icon::show('user',['framework' => Icon::PE7S])]]
                ])->textInput([
                    'placeholder' => $profile->getAttributeLabel('last_name')
                ]) ?>

                <?= $form->field($profile, 'birthday',[
                    'addon' => ['prepend' => ['content' => Icon::show('date',['framework' => Icon::PE7S])]]
                ])->widget(MaskedInput::className(), [
                    'mask' => '99/99/9999',
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => $profile->getAttributeLabel('birthday')
                    ],
                ])->hint('<small class="text-danger">โปรดระบุปีเป็น พ.ศ.</small>') ?>

                <?= $form->field($profile, 'tel',[
                    'addon' => ['prepend' => ['content' => Icon::show('phone',['framework' => Icon::PE7S])]]
                ])->widget(MaskedInput::className(), [
                    'mask' => '999-999-9999',
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => $profile->getAttributeLabel('tel')
                    ],
                ]) ?>

                <?= $form->field($profile, 'province')->widget(Select2::classname(), [
                    'language' => 'th',
                    'data' => ArrayHelper::map(TbProvince::find()->asArray()->all(),'province_name','province_name'),
                    'options' => ['placeholder' => 'เลือกจังหวัด...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                ]); ?>

                <?= $form->field($model, 'email',[
                    'addon' => ['prepend' => ['content' => Icon::show('envelope-o')]]
                ])->textInput([
                    'placeholder' => $model->getAttributeLabel('email'),
                    'type' => 'email',
                    'maxlength' => 255
                ]) ?>

                <?= $form->field($model, 'username',[
                    'addon' => ['prepend' => ['content' => Icon::show('user',['framework' => Icon::PE7S])]]
                ])->textInput([
                    'placeholder' => $model->getAttributeLabel('username'),
                ]) ?>

                <?= Html::submitButton(Yii::t('user', 'Continue'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
                <p class="text-center">
                    <?= Html::a(
                        Yii::t(
                            'user',
                            'If you already registered, sign in and connect this account on settings page'
                        ),
                        ['/user/settings/networks']
                    ) ?>.
                </p>
            </div>
        </div>
    </div>
</div>
