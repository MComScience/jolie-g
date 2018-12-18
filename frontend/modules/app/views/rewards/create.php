<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbRewards */
$this->title = Yii::t('frontend', 'Create Rewards');
$this->params['breadcrumbs'][] = ['label' => 'Tb Rewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-rewards-create">
    
    <?= $this->render('_form', [
        'model' => $model,
        'modelsItemRewards' => $modelsItemRewards
    ]) ?>

</div>
