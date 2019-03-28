<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/11/2561
 * Time: 22:36
 */
use yii\helpers\Html;
use frontend\assets\AppAsset as FrontendAsset;
use backend\assets\AppAsset as BackendAsset;
use homer\assets\HomerAsset;

if (Yii::$app->id == 'app-frontend'){
    FrontendAsset::register($this);
}else{
    BackendAsset::register($this);
}
/* Theme Asset */
HomerAsset::register($this);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Yii::$app->name,
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => $this->title,
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->title,
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'MComScience',
]);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?php echo Html::encode(!empty($this->title) ? strtoupper($this->title).' | '.Yii::$app->name : Yii::$app->name); ?></title>
        <?php $this->head() ?>
    </head>
    <?= Html::beginTag('body',['class' => $class]); ?>
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-105362419-5"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-105362419-5');
    </script>
    <?= Html::endTag('body') ?>
    </html>
<?php $this->endPage() ?>