<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbItem */

$this->title = $model->item_id;
$this->params['breadcrumbs'][] = ['label' => 'Tb Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-item-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'item_id',
            'item_name',
        ],
    ]) ?>

</div>
