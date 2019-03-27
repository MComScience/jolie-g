<?php

use yii\helpers\Html;
use homer\widgets\Icon;
use homer\widgets\MobileMenu;

$this->title = Yii::t('app', 'ขั้นตอน แสกน คิวอาร์โค้ด');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile("@web/css/scan-qrcode.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
?>
<style> 
    body { 
        background: url(/images/recoveredresize.png) no-repeat fixed bottom right transparent; 
        /*        -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;*/
        background-repeat: no-repeat;
        background-size: 100% 100%;
        height: 100vh;
        margin: 3px auto 0;
        position: relative;
    }
    section{
        border-bottom: 0px !important;
    }
    .landing-page p {
        color: #333;
    }
    .deepshd {
        letter-spacing: .1em;
        text-shadow:  2px 2px 2px #ece3e3;
        font-size: 16pt;
        color: #333;
    }
    .headerhd{
        letter-spacing: .1em;
        text-shadow:  2px 2px 2px #ece3e3;
    }
    @media (min-width: 768px ) {
        .deepshd {
            font-size: 28pt;
            margin-left: 15%;
        }
        .text-rewrad-name {
            margin-top: 30px !important;
            font-size: 28pt;
        }
    }
</style>

<section>
    <div class="container rewrad-container">
        <div class="page-wrapper">

        </div>
        <div class="page-wrapper">
            <div class="campaign-item-inner campaign-user"> 
                <h2 class="font-extra-bold  text-center text-rewrad-name">
                    <p class="headerhd"> ขั้นตอนสแกน QR Code</p>
                </h2>
            </div>
            <ol style="" class="deepshd">
                <li>
                    เปิดแอพพลิเคชั่น Line ในมือถือของคุณ  <?= Html::img(Yii::getAlias('@web/images/btn_line_base.png'), ['class' => 'img-responsive']) ?>
                </li>
                <li>
                    ไปที่เมนู Wallet แล้วเลือกไอคอน สแกนรหัส หรือ Code reader ตามภาพ<?= Html::img(Yii::getAlias('@web/images/Wallet.jpg'), ['class' => 'img-responsive', 'style' => 'width:50%']) ?>
                </li>
                <li>
                    สแกนคิวอาร์โค้ด ข้างกล่องสินค้า
                </li>
                <li> 
                    เปิดผลการสแกน <?= Html::img(Yii::getAlias('@web/images/scan-result.jpg'), ['class' => 'img-responsive', 'style' => 'width:50%']) ?>

                </li>
            </ol>
            <h4 class="text-center">เงื่อนไขการสแกนคิวอาร์โค้ด!</h4>
            <ul>
                <li>
                    1 คิวอาร์โค้ดสามารถ สแกนได้เพียง 1 ครั้ง เท่านั้น ไม่สามารถสแกนซ้ำได้
                </li>
            </ul>
            <?php /*
              <div class="page-wrapper">
              <div class="heading">
              <div class="row">
              <p style="font-size: 16pt; color: #808080;">
              <img src="<?= Yii::getAlias('@web/images/scanphone.png') ?>" alt="" width="100px" height="100px">
              ขั้นตอนการแสกน QR Code
              </p>
              </div>
              </div>
              <div class="content">
              <div class="row">
              <div class="col-md-6">
              <p style="font-size: 14pt; color: #808080;">
              1. เปิด Application Line
              </p>
              <p style="font-size: 14pt; color: #808080;">
              2. เลือก แถบ Wallet
              </p>
              <p style="font-size: 14pt; color: #808080;">
              3. เปิด สแกนรหัส
              </p>
              <p style="font-size: 14pt; color: #808080;">
              4. สแกนคิวอาร์โค้ด
              </p>
              </div>
              </div>
              </div>

              </div>
             */ ?>

        </div>
    </div>
</section>
