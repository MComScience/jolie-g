<?php

use yii\helpers\Html;
use kartik\dialog\Dialog;
use homer\widgets\Icon;
use mcomscience\sweetalert2\SweetAlert2;
use homer\widgets\Modal;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\app\models\TbRewardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Tb Rewards';
//$this->params['breadcrumbs'][] = $this->title;
$this->title = Yii::t('menu', 'Manage Rewards');
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
                <?=
                Html::a(Icon::show('plus') . Yii::t('frontend', 'Create Rewards'), ['create'], [
                    'class' => 'btn btn-success',
                    'data-toggle' => 'tooltip',
                    'title' => Yii::t('frontend', 'บันทึกรางวัล'),
                    'role' => 'modal-remote'
                ])
                ?>
            </p>
            <div id="ajaxCrudDatatable">
                <?=
                GridView::widget([
                    'id' => 'crud-datatable',
                    'dataProvider' => $dataProvider,
                    'pjax' => true,
                    'columns' => [
//                        [
//                            'class' => '\kartik\grid\SerialColumn'
//                        ],
                        [
                            'header' => 'ชื่อชุดรางวัล',
                            'attribute' => 'rewards_group_name',
                            'group' => true,
                            'groupedRow' => true, // move grouped column to a single grouped row
                            'groupOddCssClass' => 'kv-grouped-row', // configure odd group cell css class
                            'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                            'groupFooter' => function ($model, $key, $index, $widget) { // Closure method
                                return [
                                    'mergeColumns' => [[1, 3]], // columns to merge in summary
                                    'content' => [// content to show in each summary cell
                                        1 => 'มูลค่ารวม',
                                        4 => GridView::F_SUM,
                                    ],
                                    'contentFormats' => [// content reformatting for each summary cell
                                        4 => ['format' => 'number', 'decimals' => 2],
                                    ],
                                    'contentOptions' => [// content html attributes for each summary cell
                                        1 => ['style' => 'font-variant:small-caps;text-align:right'],
                                        4 => ['style' => 'text-align:right'],
                                    ],
                                    // html attributes for group summary row
                                    'options' => ['class' => 'info table-info', 'style' => 'font-weight:bold;']
                                ];
                            },
                            'value' => function ($model, $key, $index, $widget) {
                                return $model['rewards_group_name'] . ' ' . Html::a('จับรางวัล', ['12'], ['class' => 'btn btn-success','role' => 'modal-remote']);
                            },
                            'format' => 'raw'
                        ],
                        [
                            'header' => 'รางวัลที่',
                            'headerOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'attribute' => 'rewards_no',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                        ],
                        [
                            'header' => 'รางวัล',
                            'attribute' => 'rewards_name',
                            'headerOptions' => [
                                'style' => 'text-align:center'
                            ]
                        ],
                        [
                            'header' => 'จำนวน',
                            'attribute' => 'rewards_amount',
                            'headerOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                        ],
                        [
                            'header' => 'มูลค่า',
                            'attribute' => 'cost',
                            'headerOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'contentOptions' => [
                                'style' => 'text-align:right'
                            ],
                            'format' => [
                                'decimal', 2
                            ]
                        ],
                        [
                            'class' => '\kartik\grid\ActionColumn',
                            'updateOptions' => [
                                'role' => 'modal-remote'
                            ],
                            'noWrap' => true
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>


</div>
<?php /*
  <div class="tb-rewards-index">

  <h1><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
  <?= Html::a('Create Tb Rewards', ['create'], ['class' => 'btn btn-success']) ?>
  </p>

  <?= GridView::widget([
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'columns' => [
  ['class' => 'yii\grid\SerialColumn'],

  'rewards_id',
  'rewards_group_name',
  'rewards_no',
  'rewards_name',
  'rewards_amount',
  //'cost',
  //'comment',
  //'created_at',
  //'updated_at',
  //'created_by',
  //'updated_by',

  ['class' => 'yii\grid\ActionColumn'],
  ],
  ]); ?>
  </div>
 */ ?>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",
    'options' => ['class' => 'modal', 'tabindex' => false,],
    'size' => 'modal-lg',
]);

Modal::end();
