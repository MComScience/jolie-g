<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use homer\widgets\Icon;
use mcomscience\sweetalert2\SweetAlert2;
/* @var $this yii\web\View */
$this->title = Yii::t('frontend', 'Print Setting');
?>
<?= SweetAlert2::widget(['useSessionFlash' => true]) ?>
<div class="hpanel hblue">
    <div class="panel-heading hbuilt">
        <div class="panel-tools">
            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
        </div>
        <?= $this->title ?>
    </div>
    <div class="panel-body">
        <p>
            <?= Html::a(Icon::show('plus').' บันทึกการตั้งค่า',['/app/generate-qr-code/create'],[
                'class' => 'btn btn-success',
                'data-pjax' => 0,
                'data-toggle' => 'tooltip',
                'title' => 'บันทึกการตั้งค่า'
            ]) ?>
        </p>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => [
                [
                    'attribute' => 'setting_name',
                ],
                [
                    'attribute' => 'format_id',
                    'value' => function($model, $key, $index){
                        return $model->tbPaperFormat->format_name;
                    }
                ],
                [
                    'attribute' => 'marginLeft',
                ],
                [
                    'attribute' => 'marginRight',
                ],
                [
                    'attribute' => 'marginTop',
                ],
                [
                    'attribute' => 'marginBottom',
                ],
                [
                    'attribute' => 'marginHeader',
                ],
                [
                    'attribute' => 'marginFooter',
                ],
                [
                    'attribute' => 'orientation',
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    //'template' => '{update} {delete}',
                    'noWrap' => true,
                    'viewOptions' => [
                        'icon' => Icon::show('qrcode').'ดูตัวอย่าง',
                        'target' => '_blank',
                        'class' => 'btn btn-sm btn-info',
                        'data-toggle' => 'tooltip',
                        'title' => 'ดูตัวอย่าง'
                    ],
                    'updateOptions' => [
                        'icon' => Icon::show('pencil-square-o').'แก้ไข',
                        'class' => 'btn btn-sm btn-success',
                        'data-toggle' => 'tooltip',
                        'title' => 'แก้ไข'
                    ],
                    'deleteOptions' => [
                        'icon' => Icon::show('trash').'ลบ',
                        'class' => 'btn btn-sm btn-danger',
                        'data-toggle' => 'tooltip',
                        'title' => 'ลบ'
                    ],
                ]
            ],
        ])
        ?>
    </div>
</div>