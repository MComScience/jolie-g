<?php

use kartik\grid\GridView;
use mcomscience\sweetalert2\SweetAlert2;
use yii\helpers\Html;
/**
 * @var $this         yii\web\View
 * @var $searchModel  backend\modules\system\models\search\KeyStorageItemSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model        common\models\KeyStorageItem
 */

$this->title = Yii::t('backend', 'Key Storage Items');

$this->params['breadcrumbs'][] = $this->title;

?>
<?= SweetAlert2::widget(['useSessionFlash' => true]) ?>
<div class="hpanel collapsed">
    <div class="panel-heading hbuilt">
        <div class="panel-tools">
            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
        </div>
        เพิ่มรายการ
    </div>
    <div class="panel-body">
        <?php echo $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'pjax' => true,
    'panel' => [
        'heading' => false,
        'type' => 'success',
        'before' => '',
        'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Refresh Grid', ['index'], ['class' => 'btn btn-info']),
        'footer' => ''
    ],
    'options' => [
        'class' => 'grid-view table-responsive',
    ],
    'columns' => [
        [
            'class' => '\kartik\grid\SerialColumn'
        ],

        'key',
        'value',

        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{update} {delete}',
            'noWrap' => true,
        ],
    ],
]); ?>
