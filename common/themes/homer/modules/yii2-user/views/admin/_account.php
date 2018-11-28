<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use kartik\form\ActiveForm;
use yii\helpers\Html;
use homer\widgets\Icon;
/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 */
?>

<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>
<?php $form = ActiveForm::begin([
    //'layout' => 'horizontal',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'type' => ActiveForm::TYPE_HORIZONTAL,
    /*'fieldConfig' => [
        'horizontalCssClasses' => [
            'wrapper' => 'col-sm-9',
        ],
    ],*/
]); ?>

<?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
        <?= Html::submitButton(Icon::show('save').Yii::t('user', 'Update'), ['class' => 'btn btn-block btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
