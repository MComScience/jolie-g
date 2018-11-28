<?php
use yii\helpers\Html;
use homer\widgets\Icon;
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\User $user
 */
?>
<div class="form-group">
    <?= Html::activeLabel($user, 'email', ['class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-6">
        <?= $form->field($user, 'email', [
            'showLabels' => false,
            'addon' => ['prepend' => ['content' => Icon::show('envelope-o')]]
        ])->textInput([
            'placeholder' => $user->getAttributeLabel('email'),
            'type' => 'email',
            'maxlength' => 255
        ]) ?>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($user, 'username', ['class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-6">
        <?= $form->field($user, 'username', [
            'showLabels' => false,
            'addon' => ['prepend' => ['content' => Icon::show('user')]]
        ])->textInput([
            'placeholder' => $user->getAttributeLabel('username'),
            'maxlength' => 255
        ]) ?>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($user, 'password', ['class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-6">
        <?= $form->field($user, 'password', [
            'showLabels' => false,
            'addon' => ['prepend' => ['content' => Icon::show('unlock-alt')]]
        ])->passwordInput([
            'placeholder' => $user->getAttributeLabel('password'),
        ]) ?>
    </div>
</div>
