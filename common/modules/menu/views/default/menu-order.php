<?php

use homer\widgets\nestable\Nestable;
use yii\helpers\Html;
use yii\widgets\Pjax;
use homer\widgets\Modal;
use homer\assets\BootboxAsset;
use homer\assets\ToastrAsset;
use kartik\icons\Icon;
use yii\helpers\Json;
use yii\web\View;
use yii\helpers\Url;
use kartik\grid\GridView;
use mcomscience\sweetalert2\SweetAlert2;

BootboxAsset::register($this);
ToastrAsset::register($this);

$this->title = Yii::t('frontend', "Mange Menu");
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('var baseUrl = ' . Json::encode(Url::base(true)) . ';', View::POS_HEAD);
?>
<?= SweetAlert2::widget(['useSessionFlash' => true]) ?>
<?php Pjax::begin(['id' => 'index-pjax']); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('frontend', 'Sort Menu') ?></h3>
                </div>
                <div class="panel-body">
                    <?php
                    echo Nestable::widget([
                        'type' => Nestable::TYPE_WITH_HANDLE,
                        //'query' => common\modules\user\models\Profile::find(),
                        'modelOptions' => [
                            'name' => 'name'
                        ],
                        'pluginEvents' => [
                            'change' => 'function(e) {
                                var items = $(this).nestable(\'serialize\');
                                $.ajax({
                                    type: "POST",
                                    url: baseUrl+\'/menu/default/save-menusort\',
                                    data: {items: items},
                                    success: function(data, textStatus ,jqXHR ){
                                        bootbox.alert("Change Saved!");
                                    },
                                    error: function(jqXHR, textStatus, errorThrown){
                                        bootbox.alert(errorThrown);
                                    },
                                });
                            }',
                            'dropCallback' => 'function(e) {
                                console.log(this);
                            }'
                        ],
                        'clientOptions' => [
                            'maxDepth' => 3,
                        ],
                        'items' => $items,
                        'options' => ['class' => 'dd', 'id' => 'nestable2'],
                        'handleLabel' => true,
                        'collapseAll' => true
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('frontend', 'Menu') ?></h3>
                </div>
                <div class="panel-body">
                    <?php
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'panel' => [
                            'heading' => false,
                            'type' => 'success',
                            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Create Menu', ['create'], ['class' => 'btn btn-success', 'role' => 'modal-remote']),
                            'after' => '',
                            'footer' => ''
                        ],
                        'columns' => [
                            [
                                'header' => 'ชื่อเมนู',
                                'attribute' => 'title',
                            ],
                            [
                                'header' => 'หมวดเมนู',
                                'attribute' => 'cat_title',
                            ],
                            [
                                'header' => 'ภายใต้เมนู',
                                'attribute' => 'parent',
                            ],
                            [
                                'header' => 'ลำดับที่แสดง',
                                'attribute' => 'sort',
                                'hAlign' => 'center',
                            ],
                            [
                                'header' => 'สถานะ',
                                'attribute' => 'status',
                            ],
                            [
                                'class' => '\kartik\grid\ActionColumn',
                                'noWrap' => true,
                                'template' => '{update} {delete}',
                                'updateOptions' => [
                                    'role' => 'modal-remote',
                                ],
                            ]
                        ],
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php Pjax::end(); ?>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",
    'options' => ['class' => 'modal', 'tabindex' => false,],
    'size' => 'modal-lg',
]);

Modal::end();
#Register JS
$btn = Html::a(Icon::show('plus') . ' ' . Yii::t('frontend', 'Add Menu'), ['create'], ['class' => 'btn btn-success', 'role' => 'modal-remote']);
$this->registerJs(<<<JS
dt = {
    delete: function(key){
        bootbox.confirm({
            message: "คุณมั่นใจว่าต้องการลบข้อมูลนี้?",
            callback: function (result) {
                if(result){
                    $.ajax({
                        type: "POST",
                        url: baseUrl+'/menu/default/delete-menu',
                        data: {id: key},
                        success: function(data, textStatus ,jqXHR ){
                            $.pjax.reload({container:'#index-pjax'});
                            bootbox.alert(data);
                        },
                        error: function(jqXHR, textStatus, errorThrown){
                            bootbox.alert(errorThrown);
                        },
                    });
                }
            }
        });
    }
};
JS
);
?>