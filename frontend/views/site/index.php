<?php

use homer\widgets\MobileMenu;
use homer\widgets\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\View;
/* @var $this yii\web\View */

$this->title = Yii::t('frontend', 'Home');
$themeAsset = Yii::$app->assetManager->getPublishedUrl('@homer/assets/dist');
$qrcodes = [];
if ($dataQr){
    $qrcodes = ArrayHelper::getColumn($dataQr, 'qrcode_id');
}
$this->registerJs('var restaurants = '.Json::encode($qrcodes).';',View::POS_HEAD);
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
            <img class="img-animate" width="180px" height="157px"
                 src="https://scontent.fbkk7-2.fna.fbcdn.net/v/t1.0-9/46709247_579127029195406_4319334299032616960_n.jpg?_nc_cat=106&_nc_ht=scontent.fbkk7-2.fna&oh=9ade43ff5801518efce623f89b3a7a2e&oe=5CAD66C2">
            <img class="img-animate" width="180px" height="157px"
                 src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
            <img class="img-animate" width="180px" height="157px"
                 src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
            <img class="img-animate" width="180px" height="157px"
                 src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
            <br/>
            <img class="img-animate" width="180px" height="157px"
                 src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
            <img class="img-animate" width="180px" height="157px"
                 src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
            <img class="img-animate" width="180px" height="157px"
                 src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
            <img class="img-animate" width="180px" height="157px"
                 src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
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
<?php if ($account): ?>
<section id="qrcode">
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-6 col-sm-offset-3">
                    <?php
                    $data = $account->getDecodedData();
                    echo \yii\helpers\Html::img($data['pictureUrl'],['class' => 'img-responsive center-block img-circle','width' => '150px;']);
                    ?>
                <br>
                <h2><span class="text-success"><i class="fa fa-qrcode"></i> รหัสคิวอาร์โค้ดของฉัน</span></h2>
                <p>
                    <?= count($dataQr) ?> รายการ
                </p>
            </div>
        </div>

        <div class="row text-center m-t-lg">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="row">
                    <?php foreach ($dataQr as $model): ?>
                        <div class="col-sm-2">
                            <div class="qrcode"><i class="fa fa-qrcode"></i> <?= $model['qrcode_id']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php if (!Yii::$app->user->isGuest) : ?>
<section id="luckydraw">
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-6 col-sm-offset-3">
                <h2><span class="text-success">ลุ้นรางวัล</span></h2>
                <p>

                </p>
            </div>
        </div>

        <div class="row text-center m-t-lg">
            <div class="col-sm-10 col-sm-offset-1">
                <div id="wheelcanvasOuter" style="position: relative; height:300px; width: 300px; margin:0 auto;">
                    <canvas id="wheelcanvas" style="position: absolute; left: 0; top: 0; z-index: 0;" width="300" height="300">

                    </canvas>
                    <canvas id="wheelcanvastop" style="position: absolute; left: 0; top: 0; z-index: 1;" width="300" height="300" onclick="spin();" onmousedown="wheelMouseDown(event);" onmousemove="wheelMouseMove(event);" onmouseup="wheelMouseUp(event); spin();" onmouseout="wheelMouseUp(event);">
                    </canvas>
                </div>

                <audio id="wheelAudio" preload="auto">
                    <source src="/sounds/WheelDecideFX1_Soft_Short.ogg" type="audio/ogg">
                    <source src="/sounds/WheelDecideFX1_Soft_Short.mp3" type="audio/mpeg">
                </audio>
                <audio id="wheelAudio2">
                    <source src="/sounds/WheelDecideFX1_Soft_Short.ogg" type="audio/ogg">
                    <source src="/sounds/WheelDecideFX1_Soft_Short.mp3" type="audio/mpeg">
                </audio>
                <audio id="wheelAudio3">
                    <source src="/sounds/WheelDecideFX1_Soft_Short.ogg" type="audio/ogg">
                    <source src="/sounds/WheelDecideFX1_Soft_Short.mp3" type="audio/mpeg">
                </audio>
                <audio id="wheelAudioFinal" preload="auto">
                    <source src="/sounds/wd-sound-fx-end.ogg" type="audio/ogg">
                    <source src="/sounds/wd-sound-fx-end.mp3" type="audio/mpeg">
                </audio>
                <br>
                <div class="row">
                    <div  class="col-md-4 col-md-offset-4">
                        <img src="images/wd-audio-on.png" id="mutebutton" onclick="toggleMute(this);" value="Mute" /> <br/><br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php
$template = '<a href="{url}" class="page-scroll"><div class="icon">{icon}</div><div class="h1">{label}</div></a>';
echo MobileMenu::widget([
    'items' => [
        [
            'label' => Yii::t('menu', 'Home'),
            'icon' => Icon::show('home',['class' => 'pe-2x','framework' => Icon::PE7S]),
            'url' => ['/site/index'],
        ],
        [
            'label' => Yii::t('menu', 'คิวอาร์โค้ดของฉัน'),
            'icon' => Icon::show('qrcode',['class' => 'pe-2x']),
            'url' => '#qrcode',
            'template' => $template,
            'visible' => !Yii::$app->user->isGuest
        ],
        [
            'label' => Yii::t('menu', 'Lucky Draw'),
            'icon' => Icon::show('timer',['class' => 'pe-2x', 'framework' => Icon::PE7S]),
            'url' => '#luckydraw',
            'template' => $template,
            'visible' => !Yii::$app->user->isGuest
        ],
        [
            'label' => Yii::t('menu', 'ข้อมูลส่วนตัว'),
            'icon' => Icon::show('user',['class' => 'pe-2x','framework' => Icon::PE7S]),
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
    '@web/js/wheel-lucky.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/wheel.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
