<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbLuckyDraw */

$this->title = 'Update Tb Lucky Draw: ' . $model->lucky_draw_id;
$this->params['breadcrumbs'][] = ['label' => 'Tb Lucky Draws', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->lucky_draw_id, 'url' => ['view', 'id' => $model->lucky_draw_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-lucky-draw-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
