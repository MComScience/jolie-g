<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use homer\widgets\Icon;
use homer\tagsinput\Tagsinput;
use mcomscience\datatables\DataTables;
use mcomscience\sweetalert2\SweetAlert2Asset;
use mcomscience\bstable\BootstrapTable;
use yii\helpers\Url;
use kartik\widgets\Select2;

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
                    <?=
                    $form->field($model, 'product_id', [
                        'addon' => ['prepend' => ['content' => Icon::show('help1', ['framework' => Icon::PE7S])]]
                    ])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'placeholder' => 'Auto Run'
                    ])->hint('ระบบจะรันให้อัตโนมัติ')
                    ?>


                </div>

                <div class="col-sm-6">
                    <?php
                    echo $form->field($model, 'item_id')->widget(Select2::classname(), [
                        'language' => 'th',
                        'data' => yii\helpers\ArrayHelper::map(frontend\modules\app\models\TbItem::find()->all(), 'item_id', 'item_name'),
                        'options' => ['placeholder' => 'เลือกสินค้า...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-10">
                    <?=
                    $form->field($model, 'product_name', [
                        'addon' => ['prepend' => ['content' => Icon::show('note', ['framework' => Icon::PE7S])]]
                    ])->textInput([
                        'maxlength' => true,
                        'placeholder' => $model->getAttributeLabel('product_name')
                    ])
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'note')->textarea([
                        'placeholder' => 'หมายเหตุ'
                    ]);
                    ?>
                </div>
            </div>

                        <?php if (!$model->isNewRecord): ?>
                <div class="row">
                    <div class="col-sm-4">
                        <p>
                            <?php
                            echo Html::a(Icon::show('plus') . 'สร้างรหัสคิวอาร์โค้ด', ['/app/product/create-qrcode', 'product_id' => $model['product_id']], [
                                'class' => 'btn btn-success',
                                'role' => 'modal-remote'
                            ])
                            ?>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="hpanel">
                            <div class="panel-heading hbuilt">
                                <div class="panel-tools">
                                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                                </div>
                                <?= Icon::show('list-alt') . Html::encode('รายการคิวอาร์โค้ด') ?>
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
                                <?=
                                Html::button(Icon::show('trash') . 'ลบรายการที่เลือก', [
                                    'class' => 'btn btn-danger on-delete-select-all',
                                    'disabled' => true,
                                    'data-url' => \yii\helpers\Url::to(['delete-select-all']),
                                    'data-toggle' => 'tooltip',
                                    'title' => 'ลบรายการที่เลือก'
                                ])
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php endif; ?>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <?=
                    Html::a(Icon::show('close') . Yii::t('frontend', 'Close'), ['index'], [
                        'class' => 'btn btn-default',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('frontend', 'Close')
                    ])
                    ?>
                    <?=
                    Html::submitButton(Icon::show('save') . Yii::t('frontend', 'Save'), [
                        'class' => 'btn btn-success',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('frontend', 'Save')
                    ])
                    ?>
                    <?php if (!$model->isNewRecord): ?>
                        <?=
                        Html::a(Icon::show('qrcode') . Yii::t('frontend', 'Print QR Code'), ['/app/generate-qr-code/print-qr-code', 'id' => $model['product_id']], [
                            'class' => 'btn btn-info',
                            'target' => '_blank',
                            'data-pjax' => 0,
                            'data-toggle' => 'tooltip',
                            'title' => Yii::t('frontend', 'Print QR Code')
                        ])
                        ?>
            <?php endif; ?>
                </div>
            </div>

<?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<?php echo $this->render('modal'); ?>
<?php
$this->registerJsFile(
        '@web/js/product.js', [
    'depends' => [
        \yii\web\JqueryAsset::className(),
        \homer\assets\HomerAsset::className()
    ]
        ]
);
?>

