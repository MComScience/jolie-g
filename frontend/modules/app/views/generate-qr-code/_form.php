<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\RangeInput;
use mcomscience\sweetalert2\SweetAlert2Asset;
use homer\widgets\Icon;
use homer\widgets\Modal;
use kartik\grid\GridView;
use yii\helpers\Url;
use mcomscience\sweetalert2\SweetAlert2;

SweetAlert2Asset::register($this);
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 23/11/2561
 * Time: 15:00
 */
$this->title = 'บันทึกการตั้งค่าขนาดกระดาษ';
$action = Yii::$app->controller->action->id;

$this->registerJs('var action = ' . \yii\helpers\Json::encode($action) . ';', \yii\web\View::POS_HEAD);
?>
<?= SweetAlert2::widget(['useSessionFlash' => true]) ?>
<style>
    .form-group {
        margin-bottom: 5px;
    }

    .help-block {
        margin-bottom: 5px;
    }
</style>
<div class="hpanel">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab-1"> ตั้งค่าการพิมพ์</a></li>
        <li class=""><a data-toggle="tab" href="#tab-2">ตั้งค่าขนาดกระดาษ</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
                <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form-settings']); ?>
                <span class="badge badge-warning"><?= Icon::show('file-o') ?>ขนาดกระดาษ</span>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'setting_name', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'setting_name', ['showLabels' => false])->textInput([
                        ]); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'format_id', ['label' => 'ขนาดกระดาษ', 'class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'format_id', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map((new \yii\db\Query())
                                ->select(['concat(format_name,\' Size \', wide, \'x\',height, \'mm\') AS format_name', 'format_id'])
                                ->from('tb_paper_format')
                                ->all(), 'format_id', 'format_name'),
                            'options' => ['placeholder' => 'เลือกขนาดกระดาษ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                            'theme' => Select2::THEME_BOOTSTRAP,
                        ])->hint(Html::a(Icon::show('plus') . 'เพิ่มขนาดกระดาษ', ['create-paper-format','url' => Yii::$app->request->url], ['class' => 'btn btn-xs btn-success', 'role' => 'modal-remote'])); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'marginLeft', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'marginLeft', ['showLabels' => false])->widget(RangeInput::classname(), [
                            'options' => [
                                'placeholder' => 'Left'
                            ],
                            'html5Container' => ['style' => 'width:250px'],
                            'html5Options' => ['min' => 0, 'max' => 100],
                            'addon' => ['append' => ['content' => '&nbsp;']]
                        ])->hint('<span>ระยะจากขอบด้านซ้ายกระดาษถึงสติ๊กเกอร์</span>');
                        ?>
                    </div>
                    <?= Html::activeLabel($model, 'marginRight', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'marginRight', ['showLabels' => false])->widget(RangeInput::classname(), [
                            'options' => [
                                'placeholder' => 'Right'
                            ],
                            'html5Container' => ['style' => 'width:250px'],
                            'html5Options' => ['min' => 0, 'max' => 100],
                            'addon' => ['append' => ['content' => '&nbsp;']]
                        ])->hint('<span>ระยะจากขอบด้านขวากระดาษถึงสติ๊กเกอร์</span>');
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'marginTop', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'marginTop', ['showLabels' => false])->widget(RangeInput::classname(), [
                            'options' => ['placeholder' => 'Top'],
                            'html5Container' => ['style' => 'width:250px'],
                            'html5Options' => ['min' => 0, 'max' => 100],
                            'addon' => ['append' => ['content' => '&nbsp;']]
                        ])->hint('<span>ระยะจากขอบด้านบนกระดาษถึงสติ๊กเกอร์</span>');
                        ?>
                    </div>
                    <?= Html::activeLabel($model, 'marginBottom', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'marginBottom', ['showLabels' => false])->widget(RangeInput::classname(), [
                            'options' => ['placeholder' => 'Bottom'],
                            'html5Container' => ['style' => 'width:250px'],
                            'html5Options' => ['min' => 0, 'max' => 100],
                            'addon' => ['append' => ['content' => '&nbsp;']]
                        ])->hint('<span>ระยะจากขอบด้านล่างกระดาษถึงสติ๊กเกอร์</span>');
                        ?>
                    </div>
                </div>
                <div class="form-group" style="display: none">
                    <?= Html::activeLabel($model, 'marginHeader', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'marginHeader', ['showLabels' => false])->widget(RangeInput::classname(), [
                            'options' => ['placeholder' => 'Header'],
                            'html5Container' => ['style' => 'width:250px'],
                            'html5Options' => ['min' => 0, 'max' => 100],
                            'addon' => ['append' => ['content' => '&nbsp;']]
                        ]);
                        ?>
                    </div>
                    <?= Html::activeLabel($model, 'marginFooter', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'marginFooter', ['showLabels' => false])->widget(RangeInput::classname(), [
                            'options' => ['placeholder' => 'Footer'],
                            'html5Container' => ['style' => 'width:250px'],
                            'html5Options' => ['min' => 0, 'max' => 100],
                            'addon' => ['append' => ['content' => '&nbsp;']]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'orientation', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'orientation', ['showLabels' => false])->radioList([
                            'P' => 'PORTRAIT',
                            'L' => 'LANDSCAPE'
                        ], ['inline' => true]) ?>
                    </div>
                </div>
                <span class="badge badge-warning"><?= Icon::show('qrcode') ?>ขนาดคิวอาร์โค้ด</span>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'qrcode_size', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'qrcode_size', ['showLabels' => false])->widget(RangeInput::classname(), [
                            'options' => ['placeholder' => 'Size'],
                            'html5Container' => ['style' => 'width:250px'],
                            'html5Options' => ['min' => 1, 'max' => 10],
                            'addon' => ['append' => ['content' => '&nbsp;']]
                        ])->hint('<span></span>');
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'qr_margin_left', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'qr_margin_left', ['showLabels' => false])->widget(RangeInput::classname(), [
                            'options' => ['placeholder' => 'Left'],
                            'html5Container' => ['style' => 'width:250px'],
                            'html5Options' => ['min' => 1, 'max' => 100],
                            'addon' => ['append' => ['content' => '&nbsp;']]
                        ])->hint('<span>ระยะความห่างด้านซ้าย (px)</span>');
                        ?>
                    </div>
                    <?= Html::activeLabel($model, 'qr_margin_right', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'qr_margin_right', ['showLabels' => false])->widget(RangeInput::classname(), [
                            'options' => ['placeholder' => 'Right'],
                            'html5Container' => ['style' => 'width:250px'],
                            'html5Options' => ['min' => 1, 'max' => 100],
                            'addon' => ['append' => ['content' => '&nbsp;']]
                        ])->hint('<span>ระยะความห่างด้านขวา (px)</span>');
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'qr_margin_top', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'qr_margin_top', ['showLabels' => false])->widget(RangeInput::classname(), [
                            'options' => ['placeholder' => 'Top'],
                            'html5Container' => ['style' => 'width:250px'],
                            'html5Options' => ['min' => 1, 'max' => 100],
                            'addon' => ['append' => ['content' => '&nbsp;']]
                        ])->hint('<span>ระยะความห่างด้านบน (px)</span>');
                        ?>
                    </div>
                    <?= Html::activeLabel($model, 'qr_margin_bottom', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'qr_margin_bottom', ['showLabels' => false])->widget(RangeInput::classname(), [
                            'options' => ['placeholder' => 'Bottom'],
                            'html5Container' => ['style' => 'width:250px'],
                            'html5Options' => ['min' => 1, 'max' => 100],
                            'addon' => ['append' => ['content' => '&nbsp;']]
                        ])->hint('<span>ระยะความห่างด้านล่าง (px)</span>');
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'disableborder', ['label' => 'Border', 'class' => 'col-sm-2 control-label']) ?>
                    <div class="col-sm-2">
                        <?= $form->field($model, 'disableborder', ['showLabels' => false])->radioList([
                            1 => 'Enabled',
                            2 => 'Disabled'
                        ], ['inline' => true]) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 text-right">
                        <?php if ($action == 'create'): ?>
                            <?= Html::a(Icon::show('close') . Yii::t('frontend', 'Close'), ['index'], [
                                'class' => 'btn btn-default',
                                'data-toggle' => 'tooltip',
                                'title' => Yii::t('frontend', 'Close')
                            ]) ?>
                            <?= Html::a(Icon::show('refresh') . Yii::t('frontend', 'Reset'), ['create'], [
                                'class' => 'btn btn-danger',
                                'data-toggle' => 'tooltip',
                                'title' => Yii::t('frontend', 'Reset')
                            ]) ?>
                        <?php else: ?>
                            <?= Html::a(Icon::show('close') . Yii::t('frontend', 'Close'), ['index'], [
                                'class' => 'btn btn-default',
                                'data-toggle' => 'tooltip',
                                'title' => Yii::t('frontend', 'Close')
                            ]) ?>
                            <?= Html::a(Icon::show('refresh') .Yii::t('frontend', 'Reset'), ['update', 'id' => $model['setting_id']], [
                                'class' => 'btn btn-danger',
                                'data-toggle' => 'tooltip',
                                'title' => Yii::t('frontend', 'Reset')
                            ]) ?>
                        <?php endif; ?>
                        <?= Html::submitButton(Icon::show('qrcode') . Yii::t('frontend', 'Preview'), [
                            'class' => 'btn btn-primary',
                            'data-toggle' => 'tooltip',
                            'title' => Yii::t('frontend', 'Preview')
                        ]) ?>
                        <?= Html::button(Icon::show('save') .Yii::t('frontend', 'Save'), [
                            'class' => 'btn btn-success on-save',
                            'data-toggle' => 'tooltip',
                            'title' => Yii::t('frontend', 'Save')
                        ]) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                <?php if (Yii::$app->request->isPost): ?>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <span class="badge badge-success">Preview</span>
                        </div>
                    </div>
                    <br>
                    <?= \yii2assets\pdfjs\PdfJs::widget([
                        'url'=> Url::base().'/uploads/qrcode-preview.pdf'
                    ]); ?>
                <?php endif; ?>
            </div>
        </div>
        <div id="tab-2" class="tab-pane">
            <div class="panel-body">
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pjax' => true,
                    'panel' => [
                        'heading' => false,
                        'type' => 'success',
                        'before' => Html::a(Icon::show('plus').'เพิ่มขนาดกระดาษ', ['create-paper-format','url' => Yii::$app->request->url], [
                            'class' => 'btn btn-success btn-sm',
                            'role' => 'modal-remote',
                            'data-toggle' => 'tooltip',
                            'title' => 'เพิ่มขนาดกระดาษ'
                        ]),
                        'after' => '',
                        'footer' => ''
                    ],
                    'condensed' => true,
                    'columns' => [
                        [
                            'attribute' => 'format_name',
                        ],
                        [
                            'attribute' => 'wide',
                        ],
                        [
                            'attribute' => 'height',
                        ],
                        [
                            'class' => '\kartik\grid\ActionColumn',
                            'template' => '{update} {delete}',
                            'noWrap' => true,
                            'updateOptions' => [
                                'role' => 'modal-remote',
                                'class' => 'btn btn-sm btn-success',
                                'data-toggle' => 'tooltip',
                                'title' => Yii::t('frontend','Edit')
                            ],
                            'deleteOptions' => [
                                'class' => 'btn btn-sm btn-danger',
                                'data-toggle' => 'tooltip',
                                'title' => Yii::t('frontend','Delete')
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                //return string;
                                if ($action == 'update') {
                                    return Url::to(['update-paper-format', 'id' => $key, 'url' => Yii::$app->request->url]);
                                }
                                if ($action == 'delete') {
                                    return Url::to(['delete-paper-format', 'id' => $key, 'url' => Yii::$app->request->url]);
                                }
                            }
                        ]
                    ],
                    'responsive' => true,
                    'hover' => true
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",
    'options' => ['class' => 'modal', 'tabindex' => false,],
    'size' => 'modal-lg',
]);

Modal::end();
//Scripts
$this->registerJs(<<<JS
var \$form = $('#form-settings');
$('#form-settings button.on-save').on('click', function(){
    var data = \$form.serialize();
    $.ajax({
        url: \$form.attr('action'),
        type: \$form.attr('method'),
        data: data,
        success: function (response) {
            if (response.success){
                swal({
                    type: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });
                if(action === 'create'){
                    setTimeout(function(){
                        window.location.href = response.url;
                    },2000);
                }
            } else {
                $.each(response.validate, function(key, val) {
                    $(\$form).yiiActiveForm('updateAttribute', key, [val]);
                });
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }
        },
        error: function(jqXHR, errMsg) {
            swal({
                type: 'error',
                title: 'Oops...',
                text: errMsg,
            });
        }
    });
});

JS
);
?>

