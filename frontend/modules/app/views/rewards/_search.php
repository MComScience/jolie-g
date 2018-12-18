<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbRewardsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tb-rewards-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'rewards_id') ?>

    <?= $form->field($model, 'rewards_group_name') ?>

    <?= $form->field($model, 'rewards_no') ?>

    <?= $form->field($model, 'rewards_name') ?>

    <?= $form->field($model, 'rewards_amount') ?>

    <?php // echo $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
