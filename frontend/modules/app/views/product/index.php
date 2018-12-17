<?php

use kartik\dialog\Dialog;
use yii\helpers\Html;
use homer\widgets\Icon;
use mcomscience\sweetalert2\SweetAlert2;
use mcomscience\bstable\BootstrapTable;
use yii\helpers\Url;
use homer\widgets\Modal;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\app\models\TbProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Manage Product');
$this->params['breadcrumbs'][] = $this->title;
echo Dialog::widget(['overrideYiiConfirm' => true]);
?>
<?= SweetAlert2::widget(['useSessionFlash' => true]) ?>
<div class="hpanel hgreen">
    <div class="panel-heading hbuilt">
        <div class="panel-tools">
            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
        </div>
        <?= Icon::show('list-alt') . Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
        <div class="tb-product-index">
            <p>
                <?= Html::a(Icon::show('plus') . Yii::t('frontend', 'Create Product'), ['create'], [
                    'class' => 'btn btn-success',
                    'data-toggle' => 'tooltip',
                    'title' => Yii::t('frontend', 'Create Product')
                ]) ?>
            </p>

            <?php
            echo BootstrapTable::widget([
                'tableOptions' => ['id' => 'tb-product'],
                'hover' => true, // Defaults to true
                'bordered' => true, // Defaults to false
                'striped' => true, // Defaults to true
                'condensed' => true, // Defaults to true
                'beforeHeader' => [
                    [
                        'columns' => [
                            ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                            ['content' => 'เลขที่สินค้า', 'options' => ['style' => 'text-align: center;']],
                            ['content' => 'ชื่อสินค้า', 'options' => ['style' => 'text-align: center;']],
                            ['content' => 'วันที่บันทึก', 'options' => ['style' => 'text-align: center;']],
                            ['content' => 'วันที่แก้ไข', 'options' => ['style' => 'text-align: center;']],
                            ['content' => 'ผู้บันทึก', 'options' => ['style' => 'text-align: center;']],
                            ['content' => 'หมายเหตุ', 'options' => ['style' => 'text-align: center;']],
                            ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;']],
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
                        "ajax" => [
                            "url" => Url::base(true) . "/app/product/data-product",
                            "type" => "GET",
                        ],
                        "responsive" => true,
                        "autoWidth" => false,
                        "deferRender" => true,
                        "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        "language" => array_merge(Yii::$app->params['datatable-language'], [
                            "sLengthMenu" => "_MENU_",
                        ]),
                        "pageLength" => 10,
                        "processing" => true,
                        "columns" => [
                            ["data" => "index", "className" => "text-center"],
                            ["data" => "product_id"],
                            ["data" => "product_name"],
                            ["data" => "created_at", "type" => "date-uk"],
                            ["data" => "updated_at", "type" => "date-uk"],
                            ["data" => "created_by"],
                            ["data" => "note"],
                            ["data" => "actions", "className" => "text-center", "orderable" => false],
                        ],
                        "buttons" => [
                            [
                                'text' => Icon::show('refresh').'Reload',
                                'init' => new \yii\web\JsExpression('function ( dt, node, config ) {
                                    $(node).removeClass("dt-button").addClass("btn btn-info btn-outline");
                                }'),
                                'action' => new \yii\web\JsExpression('function ( e, dt, node, config ) {
                                    dt.ajax.reload();
                                }'),
                            ],
                            [
                                'extend' => 'excel',
                                'text' => Icon::show('file-excel-o').'Excel',
                                'init' => new \yii\web\JsExpression('function ( dt, node, config ) {
                                    $(node).removeClass("dt-button").addClass("btn btn-info btn-outline");
                                }'),
                            ],
                        ],
                        "initComplete" => new \yii\web\JsExpression('function(settings, json) {
                            $(\'[data-toggle="tooltip"]\').tooltip()
                        }')
                    ],
                    'clientEvents' => [
                        'error.dt' => 'function ( e, settings, techNote, message ){
                            e.preventDefault();
                            swal({
                                type: \'error\',
                                title: \'Oops...\',
                                text: message,
                            })
                        }'
                    ]
                ],
            ]);
            ?>
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
?>