<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use mcomscience\sweetalert2\SweetAlert2;
use homer\widgets\Icon;
use homer\widgets\Modal;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\app\models\TbLuckyDrawSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lucky Draws';
$this->params['breadcrumbs'][] = $this->title;
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
        <div class="tb-lucky-draw-index">

            <p>
                <?=
                Html::a(Icon::show('plus') . Yii::t('frontend', 'จับ Lucky Draws'), ['create'], [
                    'class' => 'btn btn-success',
                    'data-toggle' => 'tooltip',
                    'title' => Yii::t('frontend', 'จับ Lucky Draws'),
                ])
                ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'header' => 'ชื่องวดฉลาก',
                        'attribute' => 'lucky_draw_name',
                        'headerOptions' => [
                            'style' => 'text-align:center'
                        ],
                        
                    ],
                    [
                        'header' => 'สินค้า',
                        'attribute' => 'item_id',
                        'value' => function($model, $key, $index) {
                            return $model->tbItem->item_name;
                        },
                        'headerOptions' => [
                            'style' => 'text-align:center'
                        ],
                        'contentOptions' => [
                            'style' => 'text-align:center'
                        ],
                    ],
                    [
                        'header' => 'ชุดรางวัล',
                        'attribute' => 'rewards_id',
                        'value' => function($model, $key, $index) {
                            return $model->tbRewards->rewards_group_name;
                        },
                        'headerOptions' => [
                            'style' => 'text-align:center'
                        ],        
                    ],        
                    [
                        'attribute' => 'created_at',
                        'headerOptions' => [
                            'style' => 'text-align:center'
                        ],
                         'contentOptions' => [
                            'style' => 'text-align:center'
                        ],
                    ],
                    [
                        'attribute' => 'created_by',
                        'value' => function($model, $key, $index) {
                            return $model->userCreate->fullname;
                        },
                        'headerOptions' => [
                            'style' => 'text-align:center'
                        ],
                    ],
                    [
                        'class' => '\kartik\grid\ActionColumn',
                        'noWrap' => true,
                        'viewOptions' => [
                            'icon' => Icon::show('qrcode') . 'ดูข้อมูล',
                            'class' => 'btn btn-sm btn-info',
                            'data-toggle' => 'tooltip',
                            'title' => 'ดูข้อมูล',
                            'role' => 'modal-remote'
                        ],
                        'updateOptions' => [
                            'icon' => Icon::show('pencil-square-o') . 'แก้ไข',
                            'class' => 'btn btn-sm btn-success',
                            'data-toggle' => 'tooltip',
                            'title' => 'แก้ไข'
                        ],
                        'deleteOptions' => [
                            'icon' => Icon::show('trash') . 'ลบ',
                            'class' => 'btn btn-sm btn-danger',
                            'data-toggle' => 'tooltip',
                            'title' => 'ลบ'
                        ],
                    ],
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