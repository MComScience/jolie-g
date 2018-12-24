<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use homer\tagsinput\Tagsinput;
use homer\widgets\Icon;
use kartik\widgets\DatePicker;

?>
<?php $formqr = ActiveForm::begin(['id' => 'form-qrcode']); ?>
<div class="row">
    <div class="col-sm-6">
        
        <?=
        $formqr->field($model, 'qrcode_qty', [
            'addon' => [
                'prepend' => [
                    'content' => Html::button(Icon::show('qrcode') . 'สร้างรหัสคิวอาร์โค้ด', [
                        'class' => 'btn btn-xs btn-success on-gen-qrcode',
                        'data-toggle' => 'tooltip',
                        'title' => 'สร้างรหัสคิวอาร์โค้ด'
                    ])
                ],
                'append' => [
                    'content' => Html::button('Clear', [
                        'class' => 'btn btn-xs btn-danger on-clear',
                        'data-toggle' => 'tooltip',
                        'title' => 'Clear'
                    ]),
                ]
            ],
        ])->textInput([
            'type' => 'number',
            'maxlength' => 4,
            'placeholder' => 'จำนวน'
        ])->label('จำนวนคิวอาร์โค้ด')
        ?>
        
    </div>
    <div class="col-sm-6">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>ขั้นตอนการสร้างคิวอาร์โค้ด!</strong>
            <ol>
                <li>เลือกเงื่อนไชจับฉลาก</li>
                <li>กรอกจำนวนคิวอาร์โค้ดที่ต้องการ</li>
                <li>คลิกที่ปุ่ม "สร้างรหัสคิวอาร์โค้ด"</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?=
        $formqr->field($model, 'qrcode', [
            'addon' => ['prepend' => ['content' => Html::tag('span', 0, ['id' => 'count-qrcode'])]]
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
        ])
        ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 text-right">
        <?= Html::button(Icon::show('close').'Close',['class' => 'btn btn-default','data-dismiss' => 'modal']);?>
        <?= Html::submitButton(Icon::show('save').'Save',['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$this->registerJs(<<<JS
// variable
var \$elmqrcode = $('#tbproduct-qrcode'),
    \$elmqrcode_qty = $('#tbproduct-qrcode_qty'),
    \$elmcount = $('#count-qrcode'),
    \$formqr = $('#form-qrcode'),
    \$keys = [];
        
var product = {
    isEmpty: function (v) {
        return v === undefined || v === null || v.length === 0;
    },
    setCount: function () {
        var count = \$elmqrcode.tagsinput('items').length;
        \$elmcount.html(count);
        \$elmqrcode_qty.val(count);
    }
};
        
// create qrcode number
$('button.on-gen-qrcode').on('click', function (e) {
    e.preventDefault();
    var x = \$elmqrcode_qty.val();
    if (product.isEmpty(x)) { // if qty is empty
        swal({
            type: 'warning',
            title: 'Oops...',
            text: 'กรุณากรอกจำนวน'
        });
        return false;
    }
    \$elmqrcode.tagsinput('removeAll');
    for (var i = 0; i < x; i++) {
        \$elmqrcode.tagsinput('add', {
            value: Math.floor(Math.random() * (999999999999 - 100000000001)) + 100000000001,
            text: Math.floor(Math.random() * (999999999999 - 100000000001)) + 100000000001,
            continent: 'success'
        });
    }
});
// clear qrcode
$('button.on-clear').on('click', function (e) {
    \$elmqrcode.tagsinput('removeAll');
    product.setCount();
});
// tag input events
\$elmqrcode.on('itemAdded', function () {
    product.setCount();
});
\$elmqrcode.on('itemRemoved', function () {
    product.setCount();
});
        
// form event
\$formqr.on('beforeSubmit', function () {
    var data = \$formqr.serialize();
    var \$table = $('#tb-qrcode').DataTable();
    var \$btn = $('button[type="submit"]').button('loading');
    $.ajax({
        url: \$formqr.attr('action'),
        type: \$formqr.attr('method'),
        data: data,
        success: function (response) {
            // Implement successful
            if (response.success) {
                swal({
                    type: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#ajaxCrudModal').modal('hide');
                $('#ajaxCrudModal .modal-body').html('');
                \$table.ajax.reload();
                \$btn.button('reset');
            } else {
                \$btn.button('reset');
                $.each(response.validate, function (key, val) {
                    $(\$formqr).yiiActiveForm('updateAttribute', key, [val]);
                });
                $("html, body").animate({scrollTop: 0}, "slow");
            }
        },
        error: function (jqXHR, errMsg) {
            \$btn.button('reset');
            swal({
                type: 'error',
                title: 'Oops...',
                text: errMsg
            });
        }
    });
    return false; // prevent default submit
});
        
$('#form-qrcode input[name="TbQrItem[allow_lucky_draw]"]').on('change', function(){
    if($(this).val() == 0){
        $('.allow_lucky_draw').hide();
    }else{
        $('.allow_lucky_draw').show();
    }
});
JS
);
?>