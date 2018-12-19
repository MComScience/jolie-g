<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use homer\widgets\Icon;
use mcomscience\sweetalert2\SweetAlert2Asset;
SweetAlert2Asset::register($this);
/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tb-item-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form-item']) ?>

    <div class="form-group">
        <?= Html::activeLabel($model, 'item_name', ['class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-8">
            <?= $form->field($model, 'item_name', ['showLabels' => false])->textInput([]) ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-10 text-right">
            <?=
            Html::button(Icon::show('close') . Yii::t('frontend', 'Close'), [
                'class' => 'btn btn-default',
                'data-dismiss' => 'modal'
            ])
            ?>
            <?= Html::submitButton(Icon::show('save') . Yii::t('frontend', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs(<<<JS
var \$form = $('#form-item');
var \$btn = $('#form-item button[type="submit"]');
\$form.on('beforeSubmit', function() {
    var data = \$form.serialize();
    \$btn.button('loading');
    var dt_tbitem = jQuery('#tb-item').DataTable();
    $.ajax({
        url: \$form.attr('action'),
        type: \$form.attr('method'),
        data: data,
        success: function (response) {
            \$btn.button('reset');
            if (response.success){
                swal({
                    type: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#ajaxCrudModal').modal('hide');
                dt_tbitem.ajax.reload();
            } else {
                $.each(response.validate, function(key, val) {
                    $(\$form).yiiActiveForm('updateAttribute', key, [val]);
                });
            }
        },
        error: function(jqXHR, errMsg) {
            \$btn.button('reset');
            swal({
                type: 'error',
                title: 'Oops...',
                text: errMsg,
            });
        }
    });
    return false; // prevent default submit
});
JS
);
?>