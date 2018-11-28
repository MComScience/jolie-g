<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbProduct */

$this->title = 'รายการสินค้า: ' . $model->product_id;
$this->params['breadcrumbs'][] = ['label' => 'Tb Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_id, 'url' => ['view', 'id' => $model->product_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-product-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
