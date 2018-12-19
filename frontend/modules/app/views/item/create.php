<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbItem */

$this->title = 'Create Tb Item';
$this->params['breadcrumbs'][] = ['label' => 'Tb Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-item-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
