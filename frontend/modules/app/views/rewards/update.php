<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbRewards */

$this->title = 'Update Tb Rewards: ' . $model->rewards_id;
$this->params['breadcrumbs'][] = ['label' => 'Tb Rewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rewards_id, 'url' => ['view', 'id' => $model->rewards_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-rewards-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelsItemRewards' => $modelsItemRewards
    ]) ?>

</div>
