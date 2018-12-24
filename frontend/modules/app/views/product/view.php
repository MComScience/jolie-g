<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mcomscience\bstable\BootstrapTable;
use yii\helpers\Url;
use homer\widgets\Icon;

/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbProduct */

$this->title = $model->product_id;
$this->params['breadcrumbs'][] = ['label' => 'Tb Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-product-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'product_id',
            [
                'attribute' => 'item_id',
                'value' => !empty($model->item) ? $model->item->item_name : ''
            ],
            'product_name',
            'created_at',
            'updated_at',
        ],
    ])
    ?>

    <div class="hpanel">
        <div class="panel-heading hbuilt">
            <?= Icon::show('list-alt') . Html::encode('รายการคิวอาร์โค้ด') ?>
        </div>
        <div class="panel-body">
            <?php
            echo BootstrapTable::widget([
                'tableOptions' => ['id' => 'tb-qrcode'],
                'hover' => true, // Defaults to true
                'bordered' => true, // Defaults to false
                'striped' => true, // Defaults to true
                'condensed' => true, // Defaults to true
                'beforeHeader' => [
                    [
                        'columns' => [
                            ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                            ['content' => 'เลขคิวอาร์โค้ด', 'options' => ['style' => 'text-align: center;']],
                        ],
                    ],
                ],
                'datatableOptions' => [
                    "clientOptions" => [
                        "ajax" => [
                            "url" => Url::base(true) . "/app/product/data-qrcode",
                            "type" => "GET",
                            "data" => ["product_id" => $model['product_id']],
                        ],
                        "responsive" => true,
                        "autoWidth" => false,
                        "deferRender" => true,
                        "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        "language" => array_merge(Yii::$app->params['datatable-language'], [
                        ]),
                        "pageLength" => 10,
                        "processing" => true,
                        "columns" => [
                            ["data" => "index", "className" => "text-center"],
                            ["data" => "qrcode_id"]
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
