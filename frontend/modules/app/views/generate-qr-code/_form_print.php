<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 25/11/2561
 * Time: 21:33
 */

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\RangeInput;
use mcomscience\sweetalert2\SweetAlert2Asset;
use homer\widgets\Icon;
use frontend\modules\app\models\TbQrcodeSettings;
use mcomscience\datatables\DataTables;
use yii\helpers\Json;
use yii\web\View;
use yii\helpers\Url;
use kartik\popover\PopoverX;

SweetAlert2Asset::register($this);

$this->title = 'พิมพ์คิวอาร์โค้ด';

$action = Yii::$app->controller->action->id;

$this->registerJs('var action = ' . Json::encode($action) . ';', View::POS_HEAD);
$this->registerJs('var baseUrl = ' . Json::encode(Url::base(true)) . ';', View::POS_HEAD);
$this->registerJs('var selection = ' . Json::encode($selection) . ';', View::POS_HEAD);
?>
    <style>
        .form-group {
            margin-bottom: 5px;
        }

        .help-block {
            margin-bottom: 5px;
        }
        .popover{
            max-width: 100%;
        }
    </style>
    <div class="hpanel">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-1"><?= $this->title ?></a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'form-print']); ?>
                    <?php
                    echo PopoverX::widget([
                        'header' => 'ขั้นตอนการพิมพ์',
                        'placement' => PopoverX::ALIGN_RIGHT,
                        'content' => '<div class="alert alert-warning" role="alert">
                            <ol><li>เลือกแบบการพิมพ์ตามแบบที่ตั้งค่าไว้</li><li>เลือกรายการคิวอาร์โค้ดที่ต้องการพิมพ์</li><li>กด "Preview" เพื่อดูตัวอย่าง</li><li>กด "พิมพ์"</li></ol>
                            </div>',
                        'toggleButton' => ['label' => '(คลิกที่นี่) เพื่อดูขั้นตอนการพิมพ์', 'class' => 'btn btn-xs btn-warning'],
                    ]);
                    ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <?= $form->field($modelProduct, 'product_id', [
                                'addon' => ['prepend' => ['content' => Icon::show('help1', ['framework' => Icon::PE7S])]]
                            ])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'placeholder' => 'Auto Run'
                            ]) ?>
                        </div>
                        <div class="col-sm-8">
                            <?= $form->field($modelProduct, 'product_name', [
                                'addon' => ['prepend' => ['content' => Icon::show('note', ['framework' => Icon::PE7S])]]
                            ])->textInput([
                                'maxlength' => true,
                                'placeholder' => $modelProduct->getAttributeLabel('product_name'),
                                'readonly' => true,
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <?= $form->field($modelPrint, 'setting_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TbQrcodeSettings::find()->all(), 'setting_id', 'setting_name'),
                                'options' => ['placeholder' => 'เลือกแบบการพิมพ์...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'pluginEvents' => [
                                    "change" => "function() {
                                    if(!isEmpty($(this).val())){
                                        location.replace(baseUrl + '/app/generate-qr-code/print-qr-code?id={$modelProduct->product_id}&setting_id='+$(this).val());
                                    }else{
                                        location.replace(baseUrl + '/app/generate-qr-code/print-qr-code?id={$modelProduct->product_id}');
                                    }
                                }",
                                ],
                            ])->label('เลือกแบบการพิมพ์'); ?>
                        </div>
                        <div class="col-sm-8" style="display: none;">
                            <?= $form->field($modelProduct, 'selection',['showLabels' => false])->textarea([
                                'value' => implode('&', $selection),
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="hpanel collapsed">
                                <div class="panel-heading hbuilt">
                                    <div class="panel-tools">
                                        <a class="showhide">คลิกที่นี่เพื่อตั้งค่าเพิ่มเติม <i class="fa fa-chevron-up"></i></a>
                                    </div>
                                    <span class="label label-success">
                                    <?= Html::encode('ตั้งค่าการพิมพ์เพิ่มเติม') ?>
                                </span>
                                </div>
                                <div class="panel-body">
                                    <span class="badge badge-warning"><?= Icon::show('file-o') ?>ขนาดกระดาษ</span>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?= $form->field($modelPrint, 'format_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map((new \yii\db\Query())
                                                    ->select(['concat(format_name,\' Size \', wide, \'x\',height, \'mm\') AS format_name', 'format_id'])
                                                    ->from('tb_paper_format')
                                                    ->all(), 'format_id', 'format_name'),
                                                'options' => ['placeholder' => 'เลือกขนาดกระดาษ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                            ])->label('ขนาดกระดาษ'); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?=
                                            $form->field($modelPrint, 'marginLeft')->widget(RangeInput::classname(), [
                                                'options' => [
                                                    'placeholder' => 'Left'
                                                ],
                                                'html5Container' => ['style' => 'width:250px'],
                                                'html5Options' => ['min' => 0, 'max' => 100],
                                                'addon' => ['append' => ['content' => '&nbsp;']]
                                            ])->hint('<span>ระยะจากขอบด้านซ้ายกระดาษถึงสติ๊กเกอร์</span>');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?=
                                            $form->field($modelPrint, 'marginRight')->widget(RangeInput::classname(), [
                                                'options' => [
                                                    'placeholder' => 'Right'
                                                ],
                                                'html5Container' => ['style' => 'width:250px'],
                                                'html5Options' => ['min' => 0, 'max' => 100],
                                                'addon' => ['append' => ['content' => '&nbsp;']]
                                            ])->hint('<span>ระยะจากขอบด้านขวากระดาษถึงสติ๊กเกอร์</span>');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?=
                                            $form->field($modelPrint, 'marginTop')->widget(RangeInput::classname(), [
                                                'options' => ['placeholder' => 'Top'],
                                                'html5Container' => ['style' => 'width:250px'],
                                                'html5Options' => ['min' => 0, 'max' => 100],
                                                'addon' => ['append' => ['content' => '&nbsp;']]
                                            ])->hint('<span>ระยะจากขอบด้านบนกระดาษถึงสติ๊กเกอร์</span>');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?=
                                            $form->field($modelPrint, 'marginBottom')->widget(RangeInput::classname(), [
                                                'options' => ['placeholder' => 'Bottom'],
                                                'html5Container' => ['style' => 'width:250px'],
                                                'html5Options' => ['min' => 0, 'max' => 100],
                                                'addon' => ['append' => ['content' => '&nbsp;']]
                                            ])->hint('<span>ระยะจากขอบด้านล่างกระดาษถึงสติ๊กเกอร์</span>');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($modelPrint, 'orientation')->radioList([
                                                'P' => 'PORTRAIT',
                                                'L' => 'LANDSCAPE'
                                            ], ['inline' => true]) ?>
                                        </div>
                                    </div>
                                    <span class="badge badge-warning"><?= Icon::show('qrcode') ?>ขนาดคิวอาร์โค้ด</span>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?=
                                            $form->field($modelPrint, 'qrcode_size')->widget(RangeInput::classname(), [
                                                'options' => ['placeholder' => 'Size'],
                                                'html5Container' => ['style' => 'width:250px'],
                                                'html5Options' => ['min' => 1, 'max' => 10],
                                                'addon' => ['append' => ['content' => '&nbsp;']]
                                            ])->hint('<span></span>');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?=
                                            $form->field($modelPrint, 'qr_margin_left')->widget(RangeInput::classname(), [
                                                'options' => ['placeholder' => 'Left'],
                                                'html5Container' => ['style' => 'width:250px'],
                                                'html5Options' => ['min' => 1, 'max' => 100],
                                                'addon' => ['append' => ['content' => '&nbsp;']]
                                            ])->hint('<span>ระยะความห่างด้านซ้าย (px)</span>');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?=
                                            $form->field($modelPrint, 'qr_margin_right')->widget(RangeInput::classname(), [
                                                'options' => ['placeholder' => 'Right'],
                                                'html5Container' => ['style' => 'width:250px'],
                                                'html5Options' => ['min' => 1, 'max' => 100],
                                                'addon' => ['append' => ['content' => '&nbsp;']]
                                            ])->hint('<span>ระยะความห่างด้านขวา (px)</span>');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?=
                                            $form->field($modelPrint, 'qr_margin_top')->widget(RangeInput::classname(), [
                                                'options' => ['placeholder' => 'Top'],
                                                'html5Container' => ['style' => 'width:250px'],
                                                'html5Options' => ['min' => 1, 'max' => 100],
                                                'addon' => ['append' => ['content' => '&nbsp;']]
                                            ])->hint('<span>ระยะความห่างด้านบน (px)</span>');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?=
                                            $form->field($modelPrint, 'qr_margin_bottom')->widget(RangeInput::classname(), [
                                                'options' => ['placeholder' => 'Bottom'],
                                                'html5Container' => ['style' => 'width:250px'],
                                                'html5Options' => ['min' => 1, 'max' => 100],
                                                'addon' => ['append' => ['content' => '&nbsp;']]
                                            ])->hint('<span>ระยะความห่างด้านล่าง (px)</span>');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($modelPrint, 'disableborder')->radioList([
                                                1 => 'Enabled',
                                                2 => 'Disabled'
                                            ], ['inline' => true])->label('Border') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="hpanel">
                                <div class="panel-heading hbuilt">
                                    <div class="panel-tools">
                                        <a class="showhide">ซ่อน/แสดง <i class="fa fa-chevron-up"></i></a>
                                    </div>
                                    <?= Icon::show('list-alt') . Html::encode('รายการคิวอาร์โค้ด') ?>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover table-condensed table-bordered" id="tb-qrcode">
                                        <thead>
                                        <tr>
                                            <th>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" value="" name="select_all"
                                                               id="select-all">
                                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>

                                                    </label>
                                                </div>
                                            </th>
                                            <th><?= Html::encode('#') ?></th>
                                            <th><?= Html::encode('QR Code') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($modelProduct->qrItems as $i => $qrItem): ?>
                                            <tr>
                                                <td width="35px" class="text-center">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"
                                                                   value="<?= $qrItem['qrcode_id'] ?>"
                                                                   id="<?= $qrItem['qrcode_id'] ?>"
                                                                   name="selection[]">
                                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>

                                                        </label>
                                                    </div>
                                                </td>
                                                <td width="35px" class="text-center"><?= $i + 1 ?></td>
                                                <td><?= $qrItem['qrcode_id']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-footer">
                                    <?= Html::a(Icon::show('close') . Yii::t('frontend', 'Close'), false, [
                                        'class' => 'btn btn-default',
                                        'onclick' => 'return window.top.close();',
                                        'data-toggle' => 'tooltip',
                                        'title' => Yii::t('frontend', 'Close')
                                    ]) ?>
                                    <?= Html::a(Icon::show('refresh').'Clear',[Yii::$app->request->url],[
                                        'class' => 'btn btn-danger',
                                        'data-toggle' => 'tooltip',
                                        'title' => Yii::t('frontend', 'Clear')
                                    ]) ?>
                                    <?= Html::submitButton(Icon::show('qrcode') . 'PREVIEW', [
                                        'class' => 'btn btn-primary',
                                        'disabled' => $modelPrint->isNewRecord,
                                        'data-toggle' => 'tooltip',
                                        'title' => Yii::t('frontend', 'Preview')
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <?php if (Yii::$app->request->isPost): ?>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4 text-right">
                            </div>
                            <div class="col-sm-4 text-center">
                                <span class="badge badge-success">Preview</span>
                            </div>
                            <div class="col-sm-4 text-right">
                                <?= Html::button(Icon::show('print') . ' พิมพ์', [
                                    'class' => 'btn btn-info btn-sm on-print',
                                    'disabled' => count($selection) <= 0,
                                    'data-url' => '/uploads/'.$modelProduct['product_id'].'.pdf',
                                ]) ?>
                            </div>
                        </div>
                        <br>
                        <?= \yii2assets\pdfjs\PdfJs::widget([
                            'url'=> Url::base().'/uploads/'.$modelProduct['product_id'].'.pdf',
                            'buttons'=>[
                                'presentationMode' => false,
                                'openFile' => false,
                                'print' => false,
                                'download' => false,
                                'viewBookmark' => false,
                                'secondaryToolbarToggle' => false
                            ]
                        ]); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php
echo DataTables::widget([
    'options' => [
        'id' => 'tb-qrcode',
    ],
    'clientOptions' => [
        "deferRender" => true,
        "responsive" => true,
        "autoWidth" => false,
        "ordering" => false,
        "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "language" => [
            "lengthMenu" => " _MENU_ ",
            "url" => 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Thai.json'
        ],
        "columnDefs" => [
            ["targets" => 0, "orderable" => false, 'searchable' => false, 'className' => 'dt-body-center']
        ],
    ],
]);


$this->registerJsFile(
    '@web/js/print-qrcode'.(YII_DEBUG ? '.js' : '.min.js'),
    [
        'depends' => [
            \yii\web\JqueryAsset::className(),
            \homer\assets\HomerAsset::className()
        ]
    ]
);

$this->registerJs(<<<JS
isEmpty = function (v) {
    return v === undefined || v === null || v.length === 0;
}
JS
);
?>