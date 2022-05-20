<?php

use homer\widgets\MobileMenu;
use homer\widgets\Icon;

$this->title = 'สแกนคิวอาร์โค้ด';

$this->registerCssFile("@web/css/waitMe.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::class],
]);
?>

<header id="page-top">
    <div class="container">
        <div class="heading">
            <h1>
                JOLIE G อาหารเสริมเพื่อผิวสวย
            </h1>
            <span>"เราจะเป็นใครก็ได้ มันเริ่มที่ตัวเราเอง" ♥</span>
            <p class="small">
                เราเป็นคนเลือกทุกอย่างเข้าร่างกาย
                เลือกใช้ครีม เลือกน้ำหอม เลือกอาหาร เลือกทุกอย่าง
                แล้วผลลัพธ์มันก็กำหนดเราเองจากภายในสู่ภายนอก

                ทาครีมถ้าลงไปบำรุงให้ลึกถึงข้างในผิวถึงดีส่งออกมา
                กินอาหารผิวกินให้ข้างในดีทำงานเต็มที่ผิวถึงดีส่งออกมา
            </p>
            <a href="#" class="btn btn-success btn-sm">อ่านเพิ่มเติม...</a>
        </div>
        <div class="heading-image animate-panel" data-child="img-animate" data-effect="fadeInRight">
            <p class="small"></p>
            <img class="img-animate" width="180px" height="157px" src="<?= Yii::getAlias('@web/uploads/1/img1.jpg') ?>">
            <img class="img-animate" width="180px" height="157px" src="<?= Yii::getAlias('@web/uploads/1/img2.jpg') ?>">
            <img class="img-animate" width="180px" height="157px" src="<?= Yii::getAlias('@web/uploads/1/img2.jpg') ?>">
            <img class="img-animate" width="180px" height="157px" src="<?= Yii::getAlias('@web/uploads/1/img2.jpg') ?>">
            <br />
            <img class="img-animate" width="180px" height="157px" src="<?= Yii::getAlias('@web/uploads/1/img2.jpg') ?>">
            <img class="img-animate" width="180px" height="157px" src="<?= Yii::getAlias('@web/uploads/1/img2.jpg') ?>">
            <img class="img-animate" width="180px" height="157px" src="<?= Yii::getAlias('@web/uploads/1/img2.jpg') ?>">
            <img class="img-animate" width="180px" height="157px" src="<?= Yii::getAlias('@web/uploads/1/img2.jpg') ?>">
        </div>
    </div>
</header>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4 class="hotpink">สารสกัดจากโกจิเบอร์รี่</h4>
                <p>
                    ในใบโกจิเบอร์รี่ 100 กรัม จะมี<strong class="hotpink">ค่า ORAC มากถึง 25,300 หน่วย</strong> เมื่อเทียบกับลูกพลัมในอันดับสองซึ่งมีเพียง 5,770 หน่วยเท่านั้น
                </p>
                <p><a class="navy-link btn btn-sm" href="#" role="button">Learn more</a></p>
            </div>
            <div class="col-md-4">
                <h4 class="hotpink">สารสกัดจากมัลเบอร์รี่</h4>
                <p><i class="fa fa-check"></i> ช่วย<strong class="hotpink">ควบคุมน้ำตาลในเลือด</strong> ชะลอการย่อยของคาร์โบไฮเดรต</p>
                <p><i class="fa fa-check"></i> ช่วยลดคอเรสตอรอล <strong class="hotpink">ลด LDL เพิ่ม HDL</strong> และลดไขมันที่พอกตับได้ด้วย</p>
                <p><i class="fa fa-check"></i> ยับยั้งการก่อตัวของ<strong class="hotpink">เซลล์มะเร็ง</strong></p>
                <p><i class="fa fa-check"></i> <strong class="hotpink">ป้องกันความดันโลหิตสูง</strong> เพราะในมัลเบอรรี่มี Resveratrol สารที่มีคุณสมบัติควบคุมระดับความดันโลหิต ไม่น้อยเลยทีเดียว</p>
                <p><a class="navy-link btn btn-sm" href="#" role="button">Learn more</a></p>
            </div>
            <div class="col-md-4">
                <h4 class="hotpink">สารสกัด Resveratrol</h4>
                <p><i class="fa fa-check"></i> ลดการผลิต<strong class="hotpink">เม็ดสี</strong></p>
                <p><i class="fa fa-check"></i> <strong class="hotpink">เซลล์</strong>มีอายุขัยยืนยาวขึ้น</p>
                <p><i class="fa fa-check"></i> ชะลอความชรา ดู<strong class="hotpink">อ่อนเยาว์</strong></p>
                <p><a class="navy-link btn btn-sm" href="#" role="button">Learn more</a></p>
            </div>
        </div>
    </div>
</section>

<section id="qrcode">
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-6 col-sm-offset-3">

                <?php
                echo \yii\helpers\Html::img('/images/user.png', ['class' => 'img-responsive center-block img-circle', 'width' => '150px;', 'id' => 'picture']);
                ?>
                <br>
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="font-bold">เพศ:</span>
                                        </td>
                                        <td id="sex-name" class="text-left">-</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="font-bold">ชื่อ-นามสกุล:</span>
                                        </td>
                                        <td id="fullname" class="text-left">-</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="font-bold">วดป.เกิด:</span>
                                        </td>
                                        <td id="birthday" class="text-left">-</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="font-bold">เบอร์โทร:</span>
                                        </td>
                                        <td id="tel" class="text-left">-</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="font-bold">จังหวัด:</span>
                                        </td>
                                        <td id="province" class="text-left">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <h2><span class="text-success"><i class="fa fa-qrcode"></i> รหัสคิวอาร์โค้ดของฉัน</span></h2>
                <p>
                    <span id="qr-total">0</span> รายการ
                </p>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-sm-10 col-sm-offset-1">
                <p style="margin-top: 0;">
                    <button onclick="app.scanQRCode()" id="btn-scan" class="btn btn-lg btn-success"><i class="fa fa-qrcode" aria-hidden="true"></i> สแกนคิวอาร์โค้ด</button>
                </p>
                <div class="row" id="qr-list-item">

                </div>
            </div>
        </div>
    </div>
</section>
<?php
$template = '<a href="{url}" class="page-scroll"><div class="icon">{icon}</div><div class="h1">{label}</div></a>';
echo MobileMenu::widget([
    'items' => [
        [
            'label' => Yii::t('menu', 'Home'),
            'icon' => Icon::show('home', ['class' => 'pe-2x', 'framework' => Icon::PE7S]),
            'url' => ['/site/scanqr'],
        ],
        [
            'label' => Yii::t('menu', 'คิวอาร์โค้ดของฉัน'),
            'icon' => Icon::show('qrcode', ['class' => 'pe-2x']),
            'url' => '#qrcode',
            'template' => $template,
            // 'visible' => !Yii::$app->user->isGuest
        ],
        /*
        [
            'label' => Yii::t('menu', 'Lucky Draw'),
            'icon' => Icon::show('timer',['class' => 'pe-2x', 'framework' => Icon::PE7S]),
            'url' => ['/site/award'],
            'template' => $template,
            'visible' => !Yii::$app->user->isGuest
        ],*/
        [
            'label' => Yii::t('menu', 'ข้อมูลส่วนตัว'),
            'icon' => Icon::show('user', ['class' => 'pe-2x', 'framework' => Icon::PE7S]),
            'url' => ['/user/settings/profile'],
            'visible' => !Yii::$app->user->isGuest
        ],
    ],
    'options' => [
        'class' => 'hidden-lg hidden-md',
    ],
]);
?>
<?php
$this->registerJsFile(
    'https://static.line-scdn.net/liff/edge/2/sdk.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '//cdn.jsdelivr.net/npm/sweetalert2@11',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    'https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '//unpkg.com/axios/dist/axios.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/waitMe.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/liff-app.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>