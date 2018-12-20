<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mcomscience\sweetalert2\SweetAlert2;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\app\models\TbLuckyDrawSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tb Lucky Draws';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= SweetAlert2::widget(['useSessionFlash' => true]) ?>
<div class="tb-lucky-draw-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tb Lucky Draw', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'lucky_draw_id',
            'lucky_draw_name',
            'rewards_id',
            'created_at',
            'updated_at',
            //'created_by',
            //'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
