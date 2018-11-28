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
use dektrium\user\helpers\Timezone;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use mcomscience\sweetalert2\SweetAlert2;
use kartik\select2\Select2;
use homer\user\models\TbSex;
use homer\user\models\TbProvince;
use yii\web\JsExpression;
use trntv\filekit\widget\Upload;
use homer\widgets\Icon;
use homer\bootstraptoggle\BootstrapToggle;
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $model
 */

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .input-group-addon i{
        color: #3498db;
    }
    .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px !important; }
    .toggle.ios .toggle-handle { border-radius: 20px !important; }
</style>
<?= SweetAlert2::widget(['useSessionFlash' => true]) ?>
<?php // $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

    <div class="row">
        <div class="col-md-3">
            <?= $this->render('_menu') ?>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Html::encode($this->title) ?>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'profile-form',
                        //'options' => ['class' => 'form-horizontal'],
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        //'fieldConfig' => ['showLabels' => false],
                        /*'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                            'labelOptions' => ['class' => 'col-lg-3 control-label'],
                        ],*/
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'validateOnBlur' => false,
                    ]); ?>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'avatar', ['label' => '&nbsp;','class' => 'col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label']) ?>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <?= $form->field($model, 'avatar', ['showLabels' => false])->widget(Upload::classname(), [
                                'url' => ['upload-avatar'],
                                'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'sex_id', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'sex_id',['showLabels' => false])->widget(BootstrapToggle::className(),[
                                'clientOptions' => [
                                    'on' => Icon::show('mars').'ชาย',
                                    'off' => Icon::show('venus').'หญิง',
                                    'onstyle' => 'success',
                                    'offstyle' => 'info',
                                    //'style' => 'ios',
                                    'width' => 120
                                ],
                                'options' => ['label' => false],
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'first_name', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'first_name', [
                                'showLabels' => false,
                                'addon' => ['prepend' => ['content' => Icon::show('user',['framework' => Icon::PE7S])]]
                            ])->textInput([
                                'placeholder' => $model->getAttributeLabel('first_name')
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'last_name', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'last_name', [
                                'showLabels' => false,
                                'addon' => ['prepend' => ['content' => Icon::show('user',['framework' => Icon::PE7S])]]
                            ])->textInput([
                                'placeholder' => $model->getAttributeLabel('last_name')
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'birthday', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'birthday',[
                                'showLabels' => false,
                                'addon' => ['prepend' => ['content' => Icon::show('date',['framework' => Icon::PE7S])]]
                            ])->widget(\yii\widgets\MaskedInput::className(), [
                                'mask' => '99/99/9999',
                                'options' => [
                                    'class' => 'form-control',
                                    'placeholder' => $model->getAttributeLabel('birthday')
                                ],
                            ])->hint('<small class="text-danger">โปรดระบุปีเป็น พ.ศ.</small>') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'tel', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'tel',[
                                'showLabels' => false,
                                'addon' => ['prepend' => ['content' => Icon::show('phone',['framework' => Icon::PE7S])]]
                            ])->widget(\yii\widgets\MaskedInput::className(), [
                                'mask' => '999-999-9999',
                                'options' => [
                                    'class' => 'form-control',
                                    'placeholder' => $model->getAttributeLabel('tel')
                                ],
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'province', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'province',['showLabels' => false])->widget(Select2::classname(), [
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



                    <?php /* $form
                    ->field($model, 'timezone')
                    ->dropDownList(
                        ArrayHelper::map(
                            Timezone::getAll(),
                            'timezone',
                            'name'
                        )
                    );*/ ?>

                    <?php /* $form
                    ->field($model, 'gravatar_email')
                    ->hint(Html::a(Yii::t('user', 'Change your avatar at Gravatar.com'), 'http://gravatar.com'))*/ ?>

                    <?php // $form->field($model, 'bio')->textarea() ?>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <?= Html::submitButton(Icon::show('save').Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
                            <br>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

<?= $this->render('_mobile_menu') ?>