<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mcomscience\sweetalert2\SweetAlert2;
use homer\widgets\Icon;

/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbRewards */

$this->title = 'ดูข้อมูล รางวัล';
$this->params['breadcrumbs'][] = ['label' => 'Tb Rewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= SweetAlert2::widget(['useSessionFlash' => true]) ?>

<div class="hpanel hgreen">
    <div class="panel-heading hbuilt">
        <div class="panel-tools">
            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
        </div>
        <?= Icon::show('list-alt') . Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
        <div class="tb-rewards-view">

            <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => 'ชื่อชุดรางวัล',
                            'attribute' => 'rewards_group_name',
                        ],
                        [
                            'label' => 'ผู้สร้าง',
                            'attribute' => 'created_by',
                            'value' => $model->userCreate->fullname
                        ],
                         [
                            'label' => 'วันที่สร้าง',
                            'attribute' => 'updated_at',
                             'value' => Yii::$app->formatter->asDate($model['updated_at'], 'php:d/m/Y H:i:s')
                        ],
                    ],
                ])
            ?>

        </div>
        <div class="row">
            <div class="col-sm-12 text-right">
                <?= Html::a(Icon::show('close') . 'Close', ['index'], ['class' => 'btn btn-default']); ?>
            </div>
        </div>
    </div>

</div>
