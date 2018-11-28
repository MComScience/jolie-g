<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/11/2561
 * Time: 22:38
 */
use homer\widgets\Icon;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!-- Simple splash screen-->
<div class="splash">
    <div class="color-line"></div>
    <div class="splash-title">
        <h1><?= Yii::$app->name ?></h1>
        <p></p>
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
        </div>
    </div>
</div>
<!-- Header -->
<div id="header">
    <div class="color-line">
    </div>
    <a href="/">
        <div id="logo" class="light-version" style="padding: 10px 10px 18px 18px;">
        <span>
            <?= Yii::$app->name ?>
        </span>
        </div>
    </a>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary"><?= Yii::$app->name ?></span>
        </div>
        <div class="mobile-menu">
            <button type="button" class="navbar-toggle mobile-menu-toggle" data-toggle="collapse" data-target="#mobile-collapse">
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="collapse mobile-navbar" id="mobile-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <?= Html::a(Icon::show('home',['class' => 'fa-2x','framework' => Icon::PE7S]).Yii::t('menu','Home'),['/'],['title' => Yii::t('menu','Home'),'data-pjax' => '0']); ?>
                    </li>
                    <?php if(!Yii::$app->user->isGuest):?>
                        <li>
                            <?= Html::a(Icon::show('user',['class' => 'fa-2x','framework' => Icon::PE7S]).Yii::t('menu','Profile'),['/user/settings/profile'],['title' => Yii::t('menu','Profile'),'data-pjax' => '0']); ?>
                        </li>
                        <li>
                            <?= Html::a(Icon::show('sign-out',['class' => 'fa-2x']).Yii::t('menu','Logout'),['/user/security/logout'],['title' => Yii::t('menu','Logout'),'data-method' => 'post']); ?>
                        </li>
                    <?php endif; ?>
                    <?php if(Yii::$app->user->isGuest):?>
                        <li>
                            <?= Html::a(Icon::show('upload',['class' => 'pe-rotate-90 pe-2x','framework' => Icon::PE7S]).Yii::t('menu','Login'),['/user/security/login'],['title' => 'Login']); ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <?php if(!Yii::$app->user->isGuest):?>
                    <li class="dropdown" style="border-left: 1px solid #ddd;">
                        <?= Html::a(Html::tag('span',Yii::$app->user->identity->username,['style' => 'font-size:14px;']).' '.Icon::show('sign-out'),['/user/security/logout'],['title' => 'Sign Out','data-method' => 'post']); ?>
                    </li>
                <?php endif; ?>
                <?php if(Yii::$app->user->isGuest):?>
                    <li class="dropdown">
                        <?= Html::a(Icon::show('sign-in').Yii::t('menu','Login'),['/user/security/login'],['title' => 'Sign In']); ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>