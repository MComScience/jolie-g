<?php

use yii\helpers\Html;
use homer\widgets\Icon;
use homer\widgets\MobileMenu;

$this->title = Yii::t('app', 'ขั้นตอน แสกน คิวอาร์โค้ด');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    @media (max-width: 768px) {
        .image {
            padding-top: 12%;
        }
    }
</style>
<div class="row image">
    <div class="col-sm-12 col-xs-12">
        <?= Html::img(Yii::getAlias('@web/images/JolieG.jpg'), ['class' => 'img-responsive']) ?>
    </div>
</div>
