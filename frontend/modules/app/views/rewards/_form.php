<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use homer\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model frontend\modules\app\models\TbRewards */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .form-group {
        margin-bottom: 5px;
    }
</style>
<div class="tb-rewards-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'type' => ActiveForm::TYPE_HORIZONTAL]); ?>
    <div class="form-group">
         <div class="col-sm-10">
             <?= $form->field($model, 'rewards_group_name')->textInput() ?>
        </div>
    </div>

    <br>
    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsItemRewards[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'full_name',
            'address_line1',
            'address_line2',
            'city',
            'state',
            'postal_code',
        ],
    ]);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>
                <i class="fa fa-"></i> รางวัล
                <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</button>
            </h4>
        </div>
        <div class="panel-body">
            <div class="container-items"><!-- widgetBody -->
                <?php foreach ($modelsItemRewards as $i => $modelsItemReward): ?>
                    <div class="item panel panel-default"><!-- widgetItem -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">รางวัล</h3>
                            <div class="text-right">
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.
                            if (!$modelsItemReward->isNewRecord) {
                                echo Html::activeHiddenInput($modelsItemReward, "[{$i}]item_rewards_id");
                            }
                            ?>
                            <div class="form-group">
                                <?= Html::activeLabel($modelsItemReward, "[{$i}]rewards_no", ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-2">
                                    <?=
                                    $form->field($modelsItemReward, "[{$i}]rewards_no", ['showLabels' => false])->textInput([
                                        'placeholder' => $modelsItemReward->getAttributeLabel('rewards_no')
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group" >
                                <?= Html::activeLabel($modelsItemReward, "[{$i}]rewards_name", ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-6">
                                    <?=
                                    $form->field($modelsItemReward, "[{$i}]rewards_name", ['showLabels' => false])->textarea([
                                        'placeholder' => $modelsItemReward->getAttributeLabel('rewards_name')
                                    ]);
                                    ?>
                                </div>
                            </div>
                             <div class="form-group">
                                <?= Html::activeLabel($modelsItemReward, "[{$i}]cost", ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-4">
                                    <?=
                                    $form->field($modelsItemReward, "[{$i}]cost", ['showLabels' => false])->textInput([
                                        'placeholder' => $modelsItemReward->getAttributeLabel('cost')
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= Html::activeLabel($modelsItemReward, "[{$i}]rewards_amount", ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-2">
                                    <?=
                                    $form->field($modelsItemReward, "[{$i}]rewards_amount", ['showLabels' => false])->textInput([
                                        'placeholder' => $modelsItemReward->getAttributeLabel('rewards_amount')
                                    ]);
                                    ?>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <?= Html::activeLabel($modelsItemReward, "[{$i}]comment", ['label'=>'หมายเหตุ','class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-8">
                                    <?=
                                    $form->field($modelsItemReward, "[{$i}]comment", ['showLabels' => false])->textarea([
                                        'placeholder' => $modelsItemReward->getAttributeLabel('comment')
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div><!-- .panel -->
    <?php DynamicFormWidget::end(); ?>
    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs(<<<JS
   jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        jQuery(".dynamicform_wrapper .panel-title").each(function(index) {
            jQuery(this).html("รางวัลที่: " + (index + 1))
        });
    });         
JS
)
?>
