<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use homer\widgets\Icon;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\app\models\TbScanQrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการคิวอาร์โค้ดที่สแกน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hpanel hgreen">
    <div class="panel-heading hbuilt">
        <div class="panel-tools">
            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
        </div>
        <?= Icon::show('list-alt') . Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
        <div class="tb-scan-qr-index">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pjax' => true,
                'toolbar' => [
                    [
                        'content'=> 
                            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                                'class' => 'btn btn-default', 
                                'title' => 'Reset Grid'
                            ]),
                    ],
                    '{export}',
                    '{toggleData}'
                ],
                'panel' => [
                    'heading'=>false,
                    'type'=>'success',
                    'before'=>'',
                    'after'=>'',
                    'footer'=>''
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'qrcode_id',
                    [
                        'attribute' => 'user_id',
                        'value' => function($model, $key, $index) {
                            return $model->profile ? $model->profile->first_name.' '.$model->profile->last_name : '';
                        }
                    ],
                    [
                        'header' => 'สินค้า',
                        'value' => function($model, $key, $index) {
                            return $model->qrItem ? $model->qrItem->product->product_name : '';
                        }
                    ],
                    [
                        'attribute' => 'created_at',
                        'filterType' => GridView::FILTER_DATE,
                        'filterWidgetOptions' => [
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                            ],
                            //'options' => ['readonly' => true]
                        ],
                    ],
                    'updated_at',

                    [
                        'class' => '\kartik\grid\ActionColumn',
                        'noWrap' => true,
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

