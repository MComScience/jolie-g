<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use homer\user\models\TbSex;
use kartik\select2\Select2;
use homer\user\models\TbProvince;
use homer\widgets\Icon;
/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\models\Profile $profile
 */
?>

<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>

<?php $form = ActiveForm::begin([
    //'layout' => 'horizontal',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'type' => ActiveForm::TYPE_HORIZONTAL,
    /*'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
        'labelOptions' => ['class' => 'col-lg-3 control-label'],
    ],*/
]); ?>
<div class="form-group">
    <?= Html::activeLabel($profile, 'sex_id', ['class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-6">
        <?= $form->field($profile, 'sex_id',['showLabels' => false])->radioList(ArrayHelper::map(TbSex::find()->asArray()->all(), 'sex_id', 'sex_name'), ['inline'=>true]) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($profile, 'first_name', ['class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-6">
        <?= $form->field($profile, 'first_name', [
            'showLabels' => false,
            'addon' => ['prepend' => ['content' => Icon::show('user',['framework' => Icon::PE7S])]]
        ])->textInput([
            'placeholder' => $profile->getAttributeLabel('first_name')
        ]) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($profile, 'last_name', ['class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-6">
        <?= $form->field($profile, 'last_name', [
            'showLabels' => false,
            'addon' => ['prepend' => ['content' => Icon::show('user',['framework' => Icon::PE7S])]]
        ])->textInput([
            'placeholder' => $profile->getAttributeLabel('last_name')
        ]) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($profile, 'birthday', ['class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-6">
        <?= $form->field($profile, 'birthday',[
            'showLabels' => false,
            'addon' => ['prepend' => ['content' => Icon::show('date',['framework' => Icon::PE7S])]]
        ])->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '99/99/9999',
            'options' => [
                'class' => 'form-control',
                'placeholder' => $profile->getAttributeLabel('birthday')
            ],
        ])->hint('<small class="text-danger">โปรดระบุปีเป็น พ.ศ.</small>') ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($profile, 'tel', ['class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-6">
        <?= $form->field($profile, 'tel',[
            'showLabels' => false,
            'addon' => ['prepend' => ['content' => Icon::show('phone',['framework' => Icon::PE7S])]]
        ])->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '999-999-9999',
            'options' => [
                'class' => 'form-control',
                'placeholder' => $profile->getAttributeLabel('tel')
            ],
        ]) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($profile, 'province', ['class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-6">
        <?= $form->field($profile, 'province',['showLabels' => false])->widget(Select2::classname(), [
            'language' => 'th',
            'data' => ArrayHelper::map(TbProvince::find()->asArray()->all(), 'province_id', 'province_name'),
            'options' => ['placeholder' => 'เลือกจังหวัด...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'theme' => Select2::THEME_BOOTSTRAP,
        ]); ?>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
        <?= Html::submitButton(Icon::show('save').Yii::t('user', 'Update'), ['class' => 'btn btn-block btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
