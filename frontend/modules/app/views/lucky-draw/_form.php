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
use mcomscience\bstable\BootstrapTable;
use mcomscience\sweetalert2\SweetAlert2Asset;
SweetAlert2Asset::register($this);
/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbLuckyDraw */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs('var baseUrl = ' . Json::encode(Url::base(true)) . ';', View::POS_HEAD);
?>
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

            <div class="form-group">
                <?= Html::activeLabel($modelItem, 'item_id', ['label' => 'ชื่อสินค้า', 'class' => 'col-sm-2 control-label']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($modelItem, 'item_id', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($modelItem->getAllItems(), 'item_id', 'item_name'),
                        'options' => ['placeholder' => 'เลือกชื่อสินค้า...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginEvents' => [
                            "change" => "function() {
                                if(!isEmpty($(this).val())){
                                    location.replace(baseUrl + '/app/lucky-draw/create?item_id='+$(this).val());
                                }else{
                                    location.replace(baseUrl + '/app/lucky-draw/create');
                                }
                            }",
                        ]
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($model, 'created_at', ['class' => 'col-sm-2 control-label']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'created_at', ['showLabels' => false])->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Enter date ...', 'readonly' => true],
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
                        'options' => ['placeholder' => 'เลือกชื่อสินค้า...'],
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

            <div class="form-group rewrad-item" style="display: none;">
                <?= Html::activeLabel($model, 'rewards_id', ['label' => '', 'class' => 'col-sm-2 control-label']) ?>
                <div class="col-sm-10">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4>ชุดรางวัล</h4>
                        <div id="rewrad-item"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($modelProduct, 'product_id', ['label' => 'กลุ่มคิวอาร์โค้ด', 'class' => 'col-sm-2 control-label']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($modelProduct, 'product_id', ['showLabels' => false])->checkboxList(ArrayHelper::map(TbProduct::find()->where(['item_id' => $modelItem['item_id']])->all(), 'product_id', 'product_name'), ['inline' => true]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6 text-right">
                    <?= Html::submitButton('เริ่มสุ่มรางวัล', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <hr>
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
                        ],
                    ],
                ],
                'datatableOptions' => [
                    "extensions" => [
                        "buttons",
                        "responsive"
                    ],
                    "clientOptions" => [
                        "dom" => "<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
                        "data" => [],
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
                        "columns" => [
                            ["data" => "rewards_no"],
                            ["data" => "fullname"],
                            ["data" => "qrcode_id"],
                            ["data" => "rewards_name"],
                            ["data" => "tel", "className" => "text-center", "orderable" => false],
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
   }
};
var \$form = $('#form-lucky-draw');
\$form.on('beforeSubmit', function() {
    var data = \$form.serialize();
    var \$btn = $('#form-lucky-draw button[type="submit"]').button('loading'); 
    $.ajax({
        url: baseUrl+"/app/lucky-draw/random-rewrad",
        type: \$form.attr('method'),
        data: data,
        success: function (data) {
            \$btn.button('reset');
            dt_tbrewrad.rows().remove().draw();
            dt_tbrewrad.rows.add(data).draw();
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
    return false; // prevent default submit
});
JS
)
?>
