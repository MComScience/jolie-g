<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use homer\widgets\MobileMenu;
use homer\widgets\Icon;

$this->title = 'ประกาศรายชื่อผู้โชคดี';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile("@web/css/winner.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
$this->registerCssFile("@web/css/winnerlist.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
?>
<section>
    <div class="container rewrad-container">
        <div class="page-wrapper">
            <div class="notice_wrapper ">
                <div class="notice"><h3><i class="pe-7s-gift"></i> ประกาศรายชื่อผู้โชคดี <i class="pe-7s-gift"></i></h3></div>
                <div class="notice_desc"><?php echo $model['lucky_draw_name']; ?></div>
                <div class="text-canter" style="line-height: 5px;"><i class="pe-7s-angle-down fa-2x"></i></div>
            </div>

            <div class="campaignlist-inner-wrapper">
                <?php foreach ($rewrads as $rewrad): ?>
                    <h3 class="font-extra-bold text-success text-center text-rewrad-name">
                        <span class="badge badge-pink">รางวัลที่ <?php echo $rewrad['rewards_no']; ?></span>
                    </h3>
                    <div class="campaign-item"> 

                        <!-- ชื่อของรางวัล -->
                        <div class="campaign-item-inner campaign-rewrad">  
                            <div class="inner_wrapper">
                                <div class="line_wrapper"> 
                                    <div class="icon_gift"></div> 
                                    <div class="reward_name "><?php echo $rewrad['rewards_name']; ?></div>
                                </div>
                                <div class="line_wrapper">  
                                    <div class="desc"> <?php //มูลค่า echo number_format($rewrad['cost'], 2) บาท ; ?>  จำนวน <?php echo $rewrad['rewards_amount']; ?> รางวัล</div>
                                </div>
                            </div>  

                            <!-- <div class="icon_00_bottom icon_left"></div>
                            <div class="icon_00_bottom icon_right"></div> -->
                        </div>  

                        <!-- user ที่ได้รางวัล -->
                        <?php
                        $rewradsdata = $model->getRewrads($rewrad['item_rewards_id']);
                        ?>
                        <?php foreach ($rewradsdata as $i => $data): ?>
                            <div class="campaign-item-inner campaign-user">   
                                <!-- <div class="icon_00_top icon_left "></div>
                                <div class="icon_00_top icon_right "></div> -->

                                <div class="position "><?= $i + 1 ?></div> 
                                <div class="details">
                                    <div class="name"><span class="logo_name"></span> <span class="text ">
                                            <?php echo $data['first_name'] . ' ' . $data['last_name']; ?>
                                        </span></div> 
                                    <div class="addres">
                                        <span class="logo_address"></span> 
                                        <span class="text ">
                                            <?php echo empty($data['province_name']) ? '-' : $data['province_name']; ?>
                                        </span>
                                    </div> 
                                    <div class="contact">
                                        <span class="logo_contact"></span> 
                                        <span class="text ">
                                            <?php echo $data['qrcode_id']; ?>
                                        </span>
                                    </div>  
                                </div> 
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
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
            'icon' => Icon::show('home',['class' => 'pe-2x','framework' => Icon::PE7S]),
            'url' => ['/site/scanqr'],
        ],
        [
            'label' => Yii::t('menu', 'ประกาศผลรางวัล'),
            'icon' => Icon::show('gift',['class' => 'pe-2x']),
            'url' => ['/site/award'],
            'template' => $template,
            'visible' => !Yii::$app->user->isGuest
        ],
    ],
    'options' => [
        'class' => 'hidden-lg hidden-md',
    ],
]);
?>