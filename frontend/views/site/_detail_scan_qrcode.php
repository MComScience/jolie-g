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
        background: url(/images/giftRecovered.png)no-repeat 80% 20% fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;

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
    }
</style>

<section>
    <div class="container rewrad-container">
        <div class="page-wrapper">

        </div>
        <div class="page-wrapper">
            <div class="campaign-item-inner campaign-user"> 
                <h2 class="font-extra-bold  text-center text-rewrad-name">
                    <p class="deepshd"> ขั้นตอนแสกน QR Code</p>
                </h2>
            </div>
            <ol style="font-size: 16pt;color: #333;" class="deepshd">
                <li>
                    เปิด Application Line
                </li>
                <li>
                    เลือก แถบ Wallet
                </li>
                <li>
                    เปิด สแกนรหัส
                </li>
                <li>
                    สแกนคิวอาร์โค้ด
                </li>
            </ol>
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
