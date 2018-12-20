<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use homer\widgets\Icon;
use mcomscience\bstable\BootstrapTable;

/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbLuckyDraw */

$this->title = 'ดูข้อมูล lucky draw' . $model->lucky_draw_id;
$this->params['breadcrumbs'][] = ['label' => 'Tb Lucky Draws', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-lucky-draw-view">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'lucky_draw_name',
            [
                'label' => 'สินค้า',
                'attribute' => 'item_id',
                'value' => $model->tbItem->item_name
            ],
            [
                'label' => 'ชุดรางวัล',
                'attribute' => 'rewards_id',
                'value' => $model->tbRewards->rewards_group_name
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'created_by',
                'value' => $model->userCreate->fullname
            ],
        ],
    ])
    ?>

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
</div>
