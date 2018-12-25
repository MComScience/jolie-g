<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Url;

$this->title = 'ประกาศรายชื่อผู้โชคดี';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile("@web/css/winner.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
$this->registerCssFile("@web/css/winnerlist.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
?>
<style> 
    .rewrad-container {
        background: url(/images/githeader.jpg) 50% 3% no-repeat !important;
    }
</style>
<section>
    <div class="container rewrad-container">
        <div class="page-wrapper">
            <?php if ($rewrads) : ?>
                <?php foreach ($rewrads as $rewrad): ?>
                    <div class="notice_wrapper " style="background: #f5b6da;">
                        <div class="notice"><h3><i class="pe-7s-gift"></i> ประกาศรายชื่อผู้โชคดี <i class="pe-7s-gift"></i></h3></div>
                        <div class="notice_desc">
                            <?php echo $rewrad['lucky_draw_name']; ?>
                        </div>
                        <a style="background-color: #e98df5;border-color: #e98df5;" class="btn btn-info" href="<?= Url::to(['/site/rewrad-detail', 'id' => $rewrad['lucky_draw_id']]) ?>">
                            ดูรายชื่อผู้โชคดี
                            <i class="pe-7s-angle-right"></i>
                        </a>
                    </div> 
                <?php endforeach; ?>
            <?php else: ?>
                <div class="notice_wrapper " style="background: #f5b6da;">
                    <div class="notice"><h3><i class="pe-7s-gift"></i> ประกาศรายชื่อผู้โชคดี <i class="pe-7s-gift"></i></h3></div>
                    <div class="notice_desc">
                        ไม่มีผลรางวัล
                    </div>
                    
                </div> 
            <?php endif; ?>
        </div>
    </div>
</section>
