<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbLuckyDraw */

$this->title = 'Create Tb Lucky Draw';
$this->params['breadcrumbs'][] = ['label' => 'Tb Lucky Draws', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-lucky-draw-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelItem' => $modelItem,
        'modelProduct' => $modelProduct,
    ]) ?>

</div>
