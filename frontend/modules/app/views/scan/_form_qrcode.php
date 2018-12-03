<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 27/11/2561
 * Time: 11:28
 */
?>
<?= \mcomscience\sweetalert2\SweetAlert2::widget(['useSessionFlash' => true]) ?>
<style>
    .landing-page .qrcode {
        color: #a7afb8;
        background: #f7f9fa;
        padding: 10px 10px;
        margin: 0px 0 20px 0;
        text-transform: uppercase;
        font-weight: 600;
    }
</style>
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
            <a href="#" class="btn btn-success btn-sm">Learn more</a>
        </div>
        <div class="heading-image animate-panel" data-child="img-animate" data-effect="fadeInRight">
            <p class="small">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
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
<section id="qrcode">
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-6 col-sm-offset-3">
                <?php if ($account): ?>
                    <?php
                        $data = $account->getDecodedData();
                        echo \yii\helpers\Html::img($data['pictureUrl'],['class' => 'img-responsive center-block img-circle','width' => '150px;']);
                    ?>
                <?php endif; ?>
                <br>
                <h2><span class="text-success"><i class="fa fa-qrcode"></i> รหัสคิวอาร์โค้ดของคุณ</span></h2>
                <p>

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