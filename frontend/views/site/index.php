<?php

use homer\widgets\MobileMenu;
use kartik\icons\Icon;

/* @var $this yii\web\View */

$this->title = Yii::t('frontend', 'Home');
$themeAsset = Yii::$app->assetManager->getPublishedUrl('@homer/assets/dist');
?>
<?php /*
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
            <img class="img-animate" width="180px" height="157px" src="https://scontent.fbkk7-2.fna.fbcdn.net/v/t1.0-9/46709247_579127029195406_4319334299032616960_n.jpg?_nc_cat=106&_nc_ht=scontent.fbkk7-2.fna&oh=9ade43ff5801518efce623f89b3a7a2e&oe=5CAD66C2">
            <img class="img-animate" width="180px" height="157px" src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
            <img class="img-animate" width="180px" height="157px" src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
            <img class="img-animate" width="180px" height="157px" src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
            <br/>
            <img class="img-animate" width="180px" height="157px" src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
            <img class="img-animate" width="180px" height="157px" src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
            <img class="img-animate" width="180px" height="157px" src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
            <img class="img-animate" width="180px" height="157px" src="https://scontent.fbkk7-3.fna.fbcdn.net/v/t1.0-9/39162688_524210898020353_6421778948576772096_n.jpg?_nc_cat=103&_nc_ht=scontent.fbkk7-3.fna&oh=4317ce3e32011425d9f78a2218c20f7b&oe=5C6FD8BC">
        </div>
    </div>
</header>

<section id="team">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-6 col-md-offset-3">
                <h2><span class="text-success">Our team </span>support you</h2>
                <p>
                    Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes.
                </p>
            </div>
        </div>

        <div class="row m-t-lg text-center">
            <div class="col-sm-4">
                <div class="team-member">
                    <img src="<?=$themeAsset?>/images/a2.jpg" class="img-circle img-small" alt="">
                    <h4><span>User</span> name</h4>
                    <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus. </p>

                </div>
            </div>
            <div class="col-sm-4">
                <div class="team-member">
                    <img src="<?=$themeAsset?>/images/a5.jpg" class="img-circle" alt="">
                    <h4><span>User</span> name</h4>
                    <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.</p>

                </div>
            </div>
            <div class="col-sm-4">
                <div class="team-member">
                    <img src="<?=$themeAsset?>/images/a3.jpg" class="img-circle img-small" alt="">
                    <h4><span>User</span> name</h4>
                    <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.</p>

                </div>
            </div>
        </div>
        <div class="row m-t-lg text-center">
            <div class="col-sm-4">
                <div class="team-member">
                    <img src="<?=$themeAsset?>/images/a7.jpg" class="img-circle img-small" alt="">
                    <h4><span>User</span> name</h4>
                    <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus. </p>

                </div>
            </div>
            <div class="col-sm-4">
                <div class="team-member">
                    <img src="<?=$themeAsset?>/images/a8.jpg" class="img-circle" alt="">
                    <h4><span>User</span> name</h4>
                    <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.</p>

                </div>
            </div>
            <div class="col-sm-4">
                <div class="team-member">
                    <img src="<?=$themeAsset?>/images/a9.jpg" class="img-circle img-small" alt="">
                    <h4><span>User</span> name</h4>
                    <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.</p>

                </div>
            </div>
        </div>

    </div>
</section>
<section id="features2" class="bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <h2><span class="text-success">Special icons </span>for your app</h2>
                <p>Lorem Ipsum available, but the majority have suffered alteration euismod. </p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="pe-7s-airplay text-success icon-big"></i></h4>
                <strong>Lorem Ipsum available</strong>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
            </div>
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="pe-7s-science text-success icon-big"></i></h4>
                <strong>Lorem Ipsum available</strong>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
            </div>
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="pe-7s-display1 text-success icon-big"></i></h4>
                <strong>Lorem Ipsum available</strong>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
            </div>
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="pe-7s-cloud-upload text-success icon-big"></i></h4>
                <strong>Lorem Ipsum available</strong>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="pe-7s-global text-success icon-big"></i></h4>
                <strong>Lorem Ipsum available</strong>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
            </div>
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="pe-7s-battery text-success icon-big"></i></h4>
                <strong>Lorem Ipsum available</strong>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
            </div>
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="pe-7s-users text-success icon-big"></i></h4>
                <strong>Lorem Ipsum available</strong>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
            </div>
            <div class="col-md-3">
                <h4 class="m-t-lg"><i class="pe-7s-ticket text-success icon-big"></i></h4>
                <strong>Lorem Ipsum available</strong>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
            </div>
        </div>

    </div>
</section>
*/?>