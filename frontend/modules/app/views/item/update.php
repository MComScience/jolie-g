<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbItem */

$this->title = 'Update Tb Item: ' . $model->item_id;
$this->params['breadcrumbs'][] = ['label' => 'Tb Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item_id, 'url' => ['view', 'id' => $model->item_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-item-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
