<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbProduct */

$this->title = 'สร้าง คิวอาร์โค้ด';
$this->params['breadcrumbs'][] = ['label' => 'Tb Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
