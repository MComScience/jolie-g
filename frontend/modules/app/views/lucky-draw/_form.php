<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use homer\widgets\Icon;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use frontend\modules\app\models\TbProduct;
use yii\helpers\Json;
use yii\web\View;
use yii\helpers\Url;
use frontend\modules\app\models\TbRewards;
use frontend\modules\app\models\TbItemRewards;
use mcomscience\bstable\BootstrapTable;
use mcomscience\sweetalert2\SweetAlert2Asset;

SweetAlert2Asset::register($this);
/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbLuckyDraw */
/* @var $form yii\widgets\ActiveForm */
$action = Yii::$app->controller->action->id;
$this->registerJs('var baseUrl = ' . Json::encode(Url::base(true)) . ';', View::POS_HEAD);
$this->registerJs('var action = ' . Json::encode($action) . ';', View::POS_HEAD);
$ItemRewards = TbItemRewards::find()->where(['rewards_id' => $model['rewards_id']])->all();
$list = [0 => 'ไม่จำกัดช่วงเวลา', 1 => 'กำหนดช่วงเวลาจับฉลาก'];
?>
<style>
    @media (min-width: 768px) {
        .form-inline .form-group, .form-inline .form-control {
            vertical-align: middle;
        }
        .checkbox label:after, 
        .radio label:after {
            content: '';
            display: table;
            clear: both;
        }

        .checkbox .cr,
        .radio .cr {
            position: relative;
            display: inline-block;
            border: 1px solid #a9a9a9;
            border-radius: .25em;
            width: 1.3em;
            height: 1.3em;
            float: left;
            margin-right: .5em;
        }

        .radio .cr {
            border-radius: 50%;
        }

        .checkbox .cr .cr-icon,
        .radio .cr .cr-icon {
            position: absolute;
            font-size: .8em;
            line-height: 0;
            top: 50%;
            left: 20%;
        }

        .radio .cr .cr-icon {
            margin-left: 0.04em;
        }

        .checkbox label input[type="checkbox"],
        .radio label input[type="radio"] {
            display: none;
        }

        .checkbox label input[type="checkbox"] + .cr > .cr-icon,
        .radio label input[type="radio"] + .cr > .cr-icon {
            transform: scale(3) rotateZ(-20deg);
            opacity: 0;
            transition: all .3s ease-in;
        }

        .checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
        .radio label input[type="radio"]:checked + .cr > .cr-icon {
            transform: scale(1) rotateZ(0deg);
            opacity: 1;
        }

        .checkbox label input[type="checkbox"]:disabled + .cr,
        .radio label input[type="radio"]:disabled + .cr {
            opacity: .5;
        }
    }
</style>
<div class="hpanel hgreen">
    <div class="panel-heading hbuilt">
        <div class="panel-tools">
            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
        </div>
        <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
        <div class="tb-lucky-draw-form">

            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form-lucky-draw']); ?>

            <?= Html::activeHiddenInput($model, 'lucky_draw_id') ?>

            <div class="form-group">
                <?= Html::activeLabel($model, 'created_at', ['class' => 'col-sm-2 control-label']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'created_at', ['showLabels' => false])->widget(DatePicker::classname(), [
                        'options' => [
                            'placeholder' => 'เลือกวันที่...',
                            'readonly' => true,
                            'value' => (empty($model['created_at'])) ? Yii::$app->formatter->asDate('now', 'php:d/m/Y') : $model['created_at'],
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd/mm/yyyy',
                            'todayHighlight' => true,
                            'todayBtn' => true,
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($model, 'lucky_draw_name', ['class' => 'col-sm-2 control-label']) ?>
                <div class="col-sm-4">
                    <?= $form->field($model, 'lucky_draw_name', ['showLabels' => false])->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($model, 'rewards_id', ['label' => 'ชื่อชุดรางวัล', 'class' => 'col-sm-2 control-label']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'rewards_id', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbRewards::find()->asArray()->all(), 'rewards_id', 'rewards_group_name'),
                        'options' => ['placeholder' => 'ชื่อชุดรางวัล...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginEvents' => [
                            "change" => "function() {
                                if(!isEmpty($(this).val())){
                                    Rewrad.loadRewradItem($(this).val());
                                }else{
                                    $('.rewrad-item').hide();
                                }
                            }",
                        ]
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($model, 'item_id', ['label' => 'ชื่อสินค้า', 'class' => 'col-sm-2 control-label']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'item_id', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($modelItem->getAllItems(), 'item_id', 'item_name'),
                        'options' => ['placeholder' => 'เลือกชื่อสินค้า...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginEvents' => [
                            "change" => "function() {
                                if(!isEmpty($(this).val())){
                                    $('#form-lucky-draw').yiiActiveForm('validate', true);
                                    //location.replace(baseUrl + '/app/lucky-draw/create?item_id='+$(this).val());
                                }else{
                                    location.replace(baseUrl + '/app/lucky-draw/create');
                                }
                            }",
                        ]
                    ]);
                    ?>
                </div>
            </div>

            <?php
            if(empty($model['lucky_draw_condition'])){
                $model['lucky_draw_condition'] = 0;
            }
            ?>
            <div class="form-group">
                <?= Html::activeLabel($model, 'lucky_draw_condition', ['label' => 'เงื่อนไขการจับฉลาก', 'class' => 'col-sm-2 control-label']) ?>
                <div class="col-sm-4">
                    <?= $form->field($model, 'lucky_draw_condition', ['showLabels' => false])->radioList($list, ['inline' => true]); ?>
                </div>
            </div>

            <div class="form-group allow_lucky_draw" style="<?= $model['lucky_draw_condition'] == 1 ? '' : 'display: none' ?>">
                <?= Html::activeLabel($model, 'begin_date', ['label' => 'เลือกช่วงเวลา', 'class' => 'col-sm-2 control-label']) ?>
                <div class="col-sm-4">
                    <?=
                        $form->field($model, 'begin_date', ['showLabels' => false])->widget(DatePicker::classname(), [
                            'type' => DatePicker::TYPE_RANGE,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd/mm/yyyy',
                                'todayHighlight' => true,
                            ],
                            'attribute' => 'begin_date',
                            'attribute2' => 'end_date',
                            'separator' => 'ถึง',
                            'options' => ['placeholder' => 'วันที่เริ่ม','readonly' => true],
                            'options2' => ['placeholder' => 'วันที่สิ้นสุด','readonly' => true],
                        ])->hint('<span class="text-danger">Notice! หากไม่กำหนดเวลาจะถือว่า ไม่จำกัดวันเวลา</span>');
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($model, 'product_id', ['label' => 'กลุ่มคิวอาร์โค้ด', 'class' => 'col-sm-2 control-label']) ?>
                <div class="col-sm-10">
                    <?=
                    $form->field($model, 'product_id', ['showLabels' => false])->checkboxList(ArrayHelper::map(TbProduct::find()->where(['item_id' => $model['item_id']])->all(), 'product_id', 'product_name'), [
                        'inline' => true,
                        'item' => function($index, $label, $name, $checked, $value) {

                            $return = '<div class="checkbox" style="display: inline-block;"><label style="padding-left: 5px;">';
                            $return .= Html::checkbox($name,$checked,['value' =>$value]);
                            $return .= '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>';
                            $return .= ucwords($label);
                            $return .= '</label></div>';

                            return $return;
                        }
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2"></div>
                <div class="col-sm-6">
                    <?= Html::a('Close', ['/app/lucky-draw/index'], ['class' => 'btn btn-default']); ?>
                    <?php if ($model->isNewRecord) : ?>
                        <?= Html::a('Reset', ['/app/lucky-draw/create'], ['class' => 'btn btn-danger']); ?>
                    <?php else: ?>
                        <?= Html::a('Reset', ['/app/lucky-draw/update', 'id' => $model['lucky_draw_id']], ['class' => 'btn btn-danger']); ?>
                    <?php endif; ?>
                    <?= Html::a('จับผลรางวัล', false, ['class' => 'btn btn-success', 'data-loading-text' => 'รอสักครู่...', 'onclick' => 'Rewrad.onSubmit(this)']) ?>
                    <?= Html::a('บันทึกผลรางวัล', false, ['class' => 'btn btn-primary', 'onclick' => 'Rewrad.onSave(this)']) ?>
                </div>
            </div>
            <hr>
            <div class="form-group rewrad-item" style="<?= empty($model['rewards_id']) ? 'display: none;' : '' ?>">
                <?= Html::activeLabel($model, 'rewards_id', ['label' => '', 'class' => 'col-sm-2 control-label']) ?>
                <div class="col-sm-8">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4>ชุดรางวัล</h4>
                        <?php
                        echo '<ul id="rewrad-item">';
                        foreach ($ItemRewards as $key => $ItemReward) {
                            echo Html::tag('li', '<h4>รางวัลที่ ' . $ItemReward['rewards_no'] . '</h4> ' . $ItemReward['rewards_name'] . ' จำนวน ' . $ItemReward['rewards_amount'] . ' รางวัล มูลค่ารวม ' . (empty($ItemReward['rewards_amount']) ? '0' : number_format($ItemReward['rewards_amount'], 2)) . ' บาท');
                        }
                        echo '</ul>';
                        ?>
                    </div>
                </div>
            </div>

            <?php
            echo BootstrapTable::widget([
                'tableOptions' => ['id' => 'tb-rewrad'],
                'hover' => true, // Defaults to true
                'bordered' => true, // Defaults to false
                'striped' => true, // Defaults to true
                'condensed' => true, // Defaults to true
                'beforeHeader' => [
                    [
                        'columns' => [
                            ['content' => 'รางวัลที่', 'options' => ['style' => 'text-align: center;']],
                            ['content' => 'ชื่อ', 'options' => ['style' => 'text-align: center;']],
                            ['content' => 'QR Code', 'options' => ['style' => 'text-align: center;']],
                            ['content' => 'รางวัล', 'options' => ['style' => 'text-align: center;']],
                            ['content' => 'เบอร์โทร', 'options' => ['style' => 'text-align: center;']],
                            ['content' => 'data', 'options' => ['style' => 'text-align: center;']],
                        ],
                    ],
                ],
                'datatableOptions' => [
                    "extensions" => [
                        "buttons",
                        "responsive"
                    ],
                    "clientOptions" => [
                        "dom" => "<'row'<'col-sm-6'lB><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
                        "data" => $data,
                        "responsive" => true,
                        "autoWidth" => false,
                        "deferRender" => true,
                        "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        "language" => array_merge(Yii::$app->params['datatable-language'], [
                            "sLengthMenu" => "_MENU_",
                        ]),
                        "ordering" => false,
                        "pageLength" => 10,
                        "processing" => true,
                        "columnDefs" => [
                            ["visible" => false, "targets" => 5]
                        ],
                        "columns" => [
                            ["data" => "rewards_no", "className" => "text-center"],
                            ["data" => "fullname"],
                            ["data" => "qrcode_id"],
                            ["data" => "rewards_name"],
                            ["data" => "tel", "className" => "text-center", "orderable" => false],
                            ["data" => "data"],
                        ],
                        "buttons" => [
                            [
                                'title' => 'ผลรางวัล',
                                'extend' => 'excel',
                                'text' => Icon::show('file-excel-o') . 'Excel',
                                'init' => new \yii\web\JsExpression('function ( dt, node, config ) {
                                    $(node).removeClass("dt-button").addClass("btn btn-sm btn-info btn-outline");
                                }'),
                            ],
                        ],
                    ],
                ],
            ]);
            ?>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<?php
$this->registerJs(<<<JS
isEmpty = function (v) {
    return v === undefined || v === null || v.length === 0;
}
        
Rewrad = {
   loadRewradItem: function(rewards_id){
        $('.rewrad-item').show();
        $.ajax({
            method: "GET",
            url: baseUrl+"/app/lucky-draw/rewrad-item",
            data: {rewards_id: rewards_id},
            dataType: "json",
            success: function(response){
                $('#rewrad-item').html(response);
            },
            error: function( jqXHR, textStatus, errorThrown){
                swal({
                    type: 'error',
                    title: 'Oops...',
                    text: errorThrown,
                });
            }
      });
    },
    onSubmit: function(elm){
        var \$form = $('#form-lucky-draw');
        var \$data = \$form.serialize();
        var \$btn = $(elm).button('loading'); 
        $.ajax({
            url: baseUrl+"/app/lucky-draw/random-rewrad",
            type: \$form.attr('method'),
            data: \$data,
            success: function (response) {
                \$btn.button('reset');
                dt_tbrewrad.rows().remove().draw();
                dt_tbrewrad.rows.add(response.rewrads).draw();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal({
                    type: 'error',
                    title: 'Oops...',
                    text: errorThrown,
                });
                \$btn.button('reset');
            }
        });
    },
    onSave: function(){
        var \$form = $('#form-lucky-draw');
        var \$data = {};
            \$form.serializeArray().map(function(x){\$data[x.name] = x.value;});
        var productIDs = $("#form-lucky-draw input:checkbox:checked").map(function(){
            return $(this).val();
        }).toArray();
        var rows = dt_tbrewrad.rows().data();
        var rewrads = [];
        if(rows.length === 0){
            swal({
                type: 'warning',
                title: 'ไม่พบผลรางวัล',
                text: 'กรุณาจับผลรางวัล',
            });
        }else{
            dt_tbrewrad.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                var rowdata = this.data();
                rewrads.push(rowdata);
            } );
            swal({
                title: 'ยืนยัน?',
                text: '',
                html: '<small class="text-danger" style="font-size: 13px;">กด Enter เพื่อยืนยัน / กด Esc เพื่อยกเลิก</small',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'บันทึก',
                cancelButtonText: 'ยกเลิก',
                allowOutsideClick: false,
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve, reject) {
                        $.ajax({
                            method: "POST",
                            url: baseUrl + '/app/lucky-draw/save-rewrads',
                            dataType: "json",
                            data: $.extend( \$data, {rewrads: rewrads, action: action,productIDs: productIDs} ),
                            success: function (response) {
                                if(response.success){
                                    swal({
                                        type: 'success',
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    setTimeout(function () {
                                        window.location.href = response.url;
                                    }, 2000);
                                }else{
                                    $.each(response.validate, function(key, val) {
                                        $(\$form).yiiActiveForm('updateAttribute', key, [val]);
                                    });
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                swal({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: errorThrown,
                                });
                            }
                        });
                    });
                },
            }).then((result) => {
                if (result.value) { //Confirm
                    
                }else{
                    swal.close();
                }
            });
        }
    }
};

$('#form-lucky-draw input[name="TbLuckyDraw[lucky_draw_condition]"]').on('change', function(){
    var elm = $('#form-lucky-draw .allow_lucky_draw');
    if($(this).val() == 0){
        elm.hide();
    }else{
        elm.show();
    }
});
JS
)
?>
