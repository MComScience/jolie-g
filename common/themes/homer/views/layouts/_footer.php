<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/11/2561
 * Time: 22:37
 */
?>
<!-- Footer-->
<footer class="footer" style="height: auto">
        <span class="pull-right">
            <?= \lajax\languagepicker\widgets\LanguagePicker::widget([
                'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
                'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_SMALL
            ]); ?>
        </span>
    <span class="hidden-xs hidden-sm"><?= \Yii::$app->keyStorage->get('copyright', 'Web Application Framework © 2018') ?></span>
</footer>
