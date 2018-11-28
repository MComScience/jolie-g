<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbScanQr */

$this->title = 'Update Tb Scan Qr: ' . $model->qrcode_id;
$this->params['breadcrumbs'][] = ['label' => 'Tb Scan Qrs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->qrcode_id, 'url' => ['view', 'id' => $model->qrcode_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-scan-qr-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
