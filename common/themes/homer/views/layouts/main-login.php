<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/11/2561
 * Time: 22:42
 */
use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use homer\assets\HomerAsset;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

AppAsset::register($this);
HomerAsset::register($this);
$action = Yii::$app->controller->action->id;
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="blank">
    <?php $this->beginBody() ?>
    <!-- Simple splash screen-->
    <div class="splash">
        <div class="color-line"></div>
        <div class="splash-title"><h1><?= Yii::$app->name; ?></h1>
            <p></p>
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>
    </div>

    <div class="color-line"></div>
    <?php if(ArrayHelper::isIn($action, ['register','resend','request'])) : ?>
    <div class="back-link">
        <a href="<?= Url::to(['/auth/login']) ?>" class="btn btn-primary">Back to Login</a>
    </div>
    <?php endif; ?>
    <?php if(ArrayHelper::isIn($action, ['login'])) : ?>
        <div class="back-link">
            <a href="<?= Url::base(true) ?>" class="btn btn-primary">Back to Dashboard</a>
        </div>
    <?php endif; ?>
    <div class="login-container">
        <?= Alert::widget() ?>
        <?= $content ?>
        <div class="row">
            <div class="col-md-12 text-center">
                Responsive WebApp <br/> 2018 Copyright MComScience.
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>