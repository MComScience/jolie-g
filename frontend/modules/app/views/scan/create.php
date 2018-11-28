<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbScanQr */

$this->title = 'Create Tb Scan Qr';
$this->params['breadcrumbs'][] = ['label' => 'Tb Scan Qrs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-scan-qr-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
