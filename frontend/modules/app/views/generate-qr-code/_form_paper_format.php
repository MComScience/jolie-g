<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 24/11/2561
 * Time: 13:38
 */

use kartik\form\ActiveForm;
use yii\helpers\Html;
use homer\widgets\Icon;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL,'id' => 'form-paper-format']) ?>
<div class="form-group">
    <?= Html::activeLabel($model, 'format_name', ['class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-4">
        <?= $form->field($model, 'format_name', ['showLabels' => false])->textInput([]) ?>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($model, 'wide', ['class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-2">
        <?= $form->field($model, 'wide', ['showLabels' => false])->textInput([]) ?>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($model, 'height', ['class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-2">
        <?= $form->field($model, 'height', ['showLabels' => false])->textInput([]) ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12 text-right">
        <?= Html::button(Icon::show('close').'Close',['class' => 'btn btn-default','data-dismiss' => 'modal']) ?>
        <?= Html::submitButton(Icon::show('save').'Save',['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$this->registerJs(<<<JS
var \$form = $('#form-paper-format');
var \$btn = $('#form-paper-format button[type="submit"]');
\$form.on('beforeSubmit', function() {
    var data = \$form.serialize();
    \$btn.button('loading');
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
                setTimeout(function(){
                    window.location.href = response.url;
                },2000);
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
