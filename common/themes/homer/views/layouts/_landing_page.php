<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 26/11/2561
 * Time: 20:28
 */
use yii\helpers\Html;
use yii\helpers\Url;
$themeAsset = Yii::$app->assetManager->getPublishedUrl('@homer/assets/dist');
?>
<?php $this->beginContent('@homer/views/layouts/_base.php', ['class' => 'landing-page']); ?>
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
        </div>
    </div>
</div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a
        href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse"
                    class="navbar-toggle collapsed" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= Html::a(Yii::$app->name,Url::base(true),['class' => 'navbar-brand']); ?>
            <div class="brand-desc">
                อาหารเสริมเพื่อผิวสวย
            </div>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a class="page-scroll" href="#page-top">หน้าหลัก</a></li>
                <li><a class="page-scroll" page-scroll href="#qrcode">รายการสินค้าที่สแกน </a></li>
                <li><a class="page-scroll" page-scroll href="#contact">ติดต่อเรา</a></li>
            </ul>
        </div>
    </div>
</nav>
<?= $content ?>
<section id="contact" class="bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-6 col-md-offset-3">
                <h2><span class="text-success">Contact with us</span> anytime</h2>
                <p>
                    Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes.
                </p>
            </div>
        </div>

        <div class="row text-center m-t-lg">
            <div class="col-md-4 col-md-offset-3">

                <form class="form-horizontal" role="form" method="post" action="#">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Your full name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="user@example.com" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-2 control-label">Message</label>

                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" name="message"  placeholder="Your message here..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input id="submit" name="submit" type="submit" value="Send us a message" class="btn btn-success">
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-md-3 text-left">
                <address>
                    <strong><span class="navy">Company name, Inc.</span></strong><br/>
                    601 Street name, 123<br/>
                    New York, De 34101<br/>
                    <abbr title="Phone">P:</abbr> (123) 678-8674
                </address>
                <p class="text-color">
                    Consectetur adipisicing elit. Aut eaque, totam corporis laboriosam veritatis quis ad perspiciatis, totam corporis laboriosam veritatis, consectetur adipisicing elit quos non quis ad perspiciatis, totam corporis ea,
                </p>
            </div>
        </div>


    </div>
</section>
<?php
$this->registerJs(<<<JS
$(document).ready(function () {
    // Page scrolling feature
    $('a.page-scroll').bind('click', function(event) {
        var link = $(this);
        $('html, body').stop().animate({
            scrollTop: $(link.attr('href')).offset().top - 50
        }, 500);
        event.preventDefault();
    });

    $('body').scrollspy({
        target: '.navbar-fixed-top',
        offset: 80
    });

});
JS
);
?>
<?php $this->endContent(); ?>
