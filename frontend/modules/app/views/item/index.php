<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;
use mcomscience\sweetalert2\SweetAlert2;
use homer\widgets\Icon;
use homer\widgets\Modal;
use mcomscience\bstable\BootstrapTable;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\app\models\TbItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Tb Items';
//$this->params['breadcrumbs'][] = $this->title;
$this->title = 'สินค้า';
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
        <div class="tb-item-index">
            <p>
               <?=
                Html::a(Icon::show('plus') . Yii::t('frontend', 'เพิ่มสินค้า'), ['create'], [
                    'class' => 'btn btn-success',
                    'data-toggle' => 'tooltip',
                  //  'title' => Yii::t('frontend', 'บันทึกสินค้า'),
                    'role' => 'modal-remote'
                ])
                ?>
            </p>
            
          
            <?php
            echo BootstrapTable::widget([
                'tableOptions' => ['id' => 'tb-item'],
                'hover' => true, // Defaults to true
                'bordered' => true, // Defaults to false
                'striped' => true, // Defaults to true
                'condensed' => true, // Defaults to true
                'beforeHeader' => [
                    [
                        'columns' => [
                            ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                            ['content' => 'ชื่อสินค้า', 'options' => ['style' => 'text-align: center;']],
                            ['content' => 'ผู้สร้าง', 'options' => ['style' => 'text-align: center;']],
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
                        "dom" => "<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
                        "ajax" => [
                            "url" => Url::base(true) . "/app/item/data-item",
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
                            ["data" => "item_name"],
                            ["data" => "created_by"],
                            ["data" => "actions", "className" => "text-center", "orderable" => false],
                        ],
                      
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>

<?php /*
  <?= GridView::widget([
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'columns' => [
  ['class' => 'yii\grid\SerialColumn'],

  'item_id',
  'item_name',
  'created_at',
  'updated_at',
  'created_by',
  //'updated_by',

  ['class' => 'yii\grid\ActionColumn'],
  ],
  ]); ?>
 */ ?>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",
    'options' => ['class' => 'modal', 'tabindex' => false,],
    'size' => 'modal-lg',
]);

Modal::end();
?>