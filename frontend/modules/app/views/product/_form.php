<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use homer\widgets\Icon;
use homer\tagsinput\Tagsinput;
use mcomscience\datatables\DataTables;
use mcomscience\sweetalert2\SweetAlert2Asset;
use mcomscience\bstable\BootstrapTable;
use yii\helpers\Url;
SweetAlert2Asset::register($this);
/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbProduct */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="hpanel hgreen">
    <div class="panel-heading hbuilt">
        <div class="panel-tools">
            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
        </div>
        <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
        <div class="tb-product-form">

            <?php $form = ActiveForm::begin(['id' => 'form-product']); ?>

            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'product_id', [
                        'addon' => ['prepend' => ['content' => Icon::show('help1', ['framework' => Icon::PE7S])]]
                    ])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'placeholder' => 'Auto Run'
                    ])->hint('ระบบจะรันให้อัตโนมัติ') ?>
                </div>
                <div class="col-sm-8">
                    <?= $form->field($model, 'product_name', [
                        'addon' => ['prepend' => ['content' => Icon::show('note', ['framework' => Icon::PE7S])]]
                    ])->textInput([
                        'maxlength' => true,
                        'placeholder' => $model->getAttributeLabel('product_name')
                    ]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'qrcode_qty', [
                        'addon' => [
                            'prepend' => [
                                'content' => Html::button(Icon::show('qrcode').'สร้างรหัสคิวอาร์โค้ด',[
                                    'class' => 'btn btn-xs btn-success on-gen-qrcode',
                                    'data-toggle' => 'tooltip',
                                    'title' => 'สร้างรหัสคิวอาร์โค้ด'
                                ])
                            ],
                            'append' => [
                                'content' => Html::button('Clear', [
                                    'class'=>'btn btn-xs btn-danger on-clear',
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Clear'
                                ]),
                            ]
                        ],
                    ])->textInput([
                        'type' => 'number',
                        'maxlength' => 4,
                        'placeholder' => 'จำนวน'
                    ]) ?>
                </div>
                <div class="col-sm-8">
                    <?= $form->field($model, 'qrcode', [
                        'addon' => ['prepend' => ['content' => Html::tag('span',0,['id' => 'count-qrcode'])]]
                    ])->widget(Tagsinput::classname(), [
                        'clientOptions' => [
                            'trimValue' => true,
                            'allowDuplicates' => false,
                            'tagClass' => new \yii\web\JsExpression('function(item) {
                                switch (item.continent) {
                                    case \'primary\'   : return \'label label-primary\';
                                    case \'danger\'  : return \'label label-danger label-important\';
                                    case \'success\': return \'label label-success\';
                                    case \'default\'   : return \'label label-default\';
                                    case \'warning\'     : return \'label label-warning\';
                            }}'),
                            'itemValue' => 'value',
                            'itemText' => 'text'
                        ],
                    ]) ?>
                </div>
            </div>

            <?php if (!$model->isNewRecord): ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="hpanel">
                        <div class="panel-heading hbuilt">
                            <div class="panel-tools">
                                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                            </div>
                            <?= Icon::show('list-alt').Html::encode('รายการคิวอาร์โค้ด') ?>
                        </div>
                        <div class="panel-body">
                            <?php
                            echo BootstrapTable::widget([
                                'tableOptions' => ['id' => 'tb-qrcode'],
                                'hover' => true, // Defaults to true
                                'bordered' => true, // Defaults to false
                                'striped' => true, // Defaults to true
                                'condensed' => true, // Defaults to true
                                'beforeHeader' => [
                                    [
                                        'columns' => [
                                            ['content' => '<div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="" name="select_all" id="select-all">
                                                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
    
                                                </label>
                                            </div>', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                            ['content' => 'เลขที่คิวอาร์โค้ด', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;width: 100px;']],
                                        ],
                                    ],
                                ],
                                'datatableOptions' => [
                                    "clientOptions" => [
                                        "ajax" => [
                                            "url" => Url::base(true) . "/app/product/data-qrcode",
                                            "type" => "GET",
                                            "data" => ["product_id" => $model['product_id']],
                                        ],
                                        "responsive" => true,
                                        "autoWidth" => false,
                                        "deferRender" => true,
                                        "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                        "language" => array_merge(Yii::$app->params['datatable-language'], [
                                        ]),
                                        "pageLength" => 10,
                                        "processing" => true,
                                        "columns" => [
                                            ["data" => "checkbox", "className" => "text-center"],
                                            ["data" => "qrcode_id"],
                                            ["data" => "actions", "className" => "text-center", "orderable" => false],
                                        ],
                                        "columnDefs" => [
                                            [
                                                "targets" => 0,
                                                "orderable" => false,
                                                'searchable' => false,
                                                'className' => 'dt-body-center',
                                            ]
                                        ],
                                        "select" => [
                                            "style" => "multi"
                                        ],
                                        "initComplete" => new \yii\web\JsExpression('function(settings, json) {
                                            $(\'[data-toggle="tooltip"]\').tooltip()
                                        }')
                                    ],
                                    'clientEvents' => [
                                        'error.dt' => 'function ( e, settings, techNote, message ){
                                            e.preventDefault();
                                            swal({
                                                type: \'error\',
                                                title: \'Oops...\',
                                                text: message,
                                            })
                                        }'
                                    ]
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="panel-footer">
                            <?= Html::button(Icon::show('trash').'ลบรายการที่เลือก',[
                                'class' => 'btn btn-danger on-delete-select-all',
                                'disabled' => true,
                                'data-url' => \yii\helpers\Url::to(['delete-select-all']),
                                'data-toggle' => 'tooltip',
                                'title' => 'ลบรายการที่เลือก'
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <?= Html::a(Icon::show('close').Yii::t('frontend', 'Close'),['index'],[
                        'class' => 'btn btn-default',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('frontend', 'Close')
                    ]) ?>
                    <?= Html::submitButton(Icon::show('save').Yii::t('frontend', 'Save'), [
                        'class' => 'btn btn-success',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('frontend', 'Save')
                    ]) ?>
                    <?php if (!$model->isNewRecord): ?>
                        <?= Html::a(Icon::show('qrcode').Yii::t('frontend', 'Print QR Code'),['/app/generate-qr-code/print-qr-code','id' => $model['product_id']],[
                            'class' => 'btn btn-info',
                            'target' => '_blank',
                            'data-pjax' => 0,
                            'data-toggle' => 'tooltip',
                            'title' => Yii::t('frontend', 'Print QR Code')
                        ]) ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<?php
$this->registerJsFile(
    '@web/js/product'.(YII_DEBUG ? '.js' : '.min.js'),
    [
        'depends' => [
            \yii\web\JqueryAsset::className(),
            \homer\assets\HomerAsset::className()
        ]
    ]
);
?>

