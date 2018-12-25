<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile("@web/css/winner.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
$this->registerCssFile("@web/css/winnerlist.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);

?>
<section>
    <div class="container">
        <div class="page-wrapper">
            
            <img src="https://singha.buzzebees.com/Images/Draw/bg2.png" class="img-fluid img_line"> 

            <div class="notice_wrapper ">
                <div class="notice"><h3><i class="pe-7s-gift"></i> ประกาศรายชื่อผู้โชคดี <i class="pe-7s-gift"></i></h3></div>
                <div class="notice_desc">ประจำเดือน มีนาคม 2561</div>
                <div class="text-canter" style="line-height: 5px;"><i class="pe-7s-angle-down fa-2x"></i></div>
            </div>

            <div class="campaignlist-inner-wrapper">
                <h3 class="font-extra-bold text-success text-center text-rewrad-name">
                    รางวัลที่ 1
                </h3>
                <div class="campaign-item"> 
                    
                    <!-- ชื่อของรางวัล -->
                    <div class="campaign-item-inner campaign-rewrad">  
                        <div class="inner_wrapper">
                            <div class="line_wrapper"> 
                                <div class="icon_gift"></div> 
                                <div class="reward_name ">เสือยืด Supreme</div>
                            </div>
                            <div class="line_wrapper">  
                                <div class="desc">มูลค่า 35,000  บาท  (จำนวน 1 รางวัล)</div>
                            </div>
                        </div>  
                        
                        <!-- <div class="icon_00_bottom icon_left"></div>
                        <div class="icon_00_bottom icon_right"></div> -->
                    </div>  
                    
                    <!-- user ที่ได้รางวัล -->
                    <div class="campaign-item-inner campaign-user">   
                        <!-- <div class="icon_00_top icon_left "></div>
                        <div class="icon_00_top icon_right "></div> -->

                        <div class="position ">1</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">ธนชัย มะลิวงษ์</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">กรุงเทพฯ</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">084-522-xxxx</span></div>  
                        </div> 
                    </div>
                </div>

                <h3 class="font-extra-bold  text-success text-center text-rewrad-name">
                    รางวัลที่ 2
                </h3>
                <div class="campaign-item "> 
                    
                    <!-- ชื่อของรางวัล -->
                    <div class="campaign-item-inner campaign-rewrad">  
                        <div class="inner_wrapper">
                            <div class="line_wrapper"> 
                                <div class="icon_gift"></div> 
                                <div class="reward_name ">Huawei 10 Pro Mate</div>
                            </div>
                            <div class="line_wrapper">  
                                <div class="desc " >มูลค่า 27,900 บาท (จำนวน 1 รางวัล)</div>
                            </div>
                        </div>  
                        
                        <!-- <div class="icon_00_bottom icon_left"></div>
                        <div class="icon_00_bottom icon_right"></div> -->
                    </div>  
                    
                    <!-- user ที่ได้รางวัล -->
                    <div class="campaign-item-inner campaign-user " >   
                        <!-- <div class="icon_00_top icon_left " ></div>
                        <div class="icon_00_top icon_right " ></div> -->

                        <div class="position ">1</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">อดินันท์ รอแม</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">ภูเก็ต</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">080-892-xxxx</span></div>  
                        </div> 
                    </div> 
                </div>

                <h3 class="font-extra-bold  text-success text-center text-rewrad-name">
                    รางวัลที่ 3
                </h3>
                <div class="campaign-item "> 
                    
                    <!-- ชื่อของรางวัล -->
                    <div class="campaign-item-inner campaign-rewrad">  
                        <div class="inner_wrapper">
                            <div class="line_wrapper"> 
                                <div class="icon_gift"></div> 
                                <div class="reward_name " >iPad Pro (10.5 นิ้ว)</div>
                            </div>
                            <div class="line_wrapper">  
                                <div class="desc " >มูลค่า 24,900 บาท (จำนวน 1 รางวัล)</div>
                            </div>
                        </div>  
                        
                        <!-- <div class="icon_00_bottom icon_left"></div>
                        <div class="icon_00_bottom icon_right"></div> -->
                    </div>  
                    
                    <!-- user ที่ได้รางวัล -->
                    <div class="campaign-item-inner campaign-user " >   
                        <!-- <div class="icon_00_top icon_left " ></div>
                        <div class="icon_00_top icon_right " ></div> -->

                        <div class="position ">1</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">สายฝน ติยะบุตร</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text "> บึงกาฬ</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">061-570-xxxx</span></div>  
                        </div> 
                    </div> 
                </div>
                
                <h3 class="font-extra-bold  text-success text-center text-rewrad-name">
                    รางวัลที่ 4
                </h3>
                <div class="campaign-item " > 
                    
                    <!-- ชื่อของรางวัล -->
                    <div class="campaign-item-inner campaign-rewrad">  
                        <div class="inner_wrapper">
                            <div class="line_wrapper"> 
                                <div class="icon_gift"></div> 
                                <div class="reward_name " >PlayStation 4</div>
                            </div>
                            <div class="line_wrapper">  
                                <div class="desc " >มูลค่า 15,590  บาท(จำนวน 1 รางวัล)</div>
                            </div>
                        </div>  
                        
                        <!-- <div class="icon_00_bottom icon_left"></div>
                        <div class="icon_00_bottom icon_right"></div> -->
                    </div>  
                    
                    <!-- user ที่ได้รางวัล -->
                    <div class="campaign-item-inner campaign-user " >   
                        <!-- <div class="icon_00_top icon_left " ></div>
                        <div class="icon_00_top icon_right " ></div> -->

                        <div class="position ">1</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">ธนกร ยังเจิมจันทร์</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">กรุงเทพฯ</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">085-269-xxxx</span></div>  
                        </div> 
                    </div> 
                </div>

                <h3 class="font-extra-bold  text-success text-center text-rewrad-name">
                    รางวัลที่ 5
                </h3>
                <div class="campaign-item " > 
                    
                    <!-- ชื่อของรางวัล -->
                    <div class="campaign-item-inner campaign-rewrad">  
                        <div class="inner_wrapper">
                            <div class="line_wrapper"> 
                                <div class="icon_gift"></div> 
                                <div class="reward_name " >Drone DJI Spark</div>
                            </div>
                            <div class="line_wrapper">  
                                <div class="desc " >มูลค่า 15,490  บาท (จำนวน 1 รางวัล)</div>
                            </div>
                        </div>  
                        
                        <!-- <div class="icon_00_bottom icon_left"></div>
                        <div class="icon_00_bottom icon_right"></div> -->
                    </div>  
                    
                    <!-- user ที่ได้รางวัล -->
                    <div class="campaign-item-inner campaign-user " >   
                        <!-- <div class="icon_00_top icon_left " ></div>
                        <div class="icon_00_top icon_right " ></div> -->

                        <div class="position ">1</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">อนุชา แก้วสุวรรณ</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">นครราชสีมา</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">098-194-xxxx</span></div>  
                        </div> 
                    </div> 
                </div>

                <h3 class="font-extra-bold  text-success text-center text-rewrad-name">
                    รางวัลที่ 6
                </h3>
                <div class="campaign-item "> 
                    
                    <!-- ชื่อของรางวัล -->
                    <div class="campaign-item-inner campaign-rewrad">  
                        <div class="inner_wrapper">
                            <div class="line_wrapper"> 
                                <div class="icon_gift"></div> 
                                <div class="reward_name " >Apple Watch Series 3</div>
                            </div>
                            <div class="line_wrapper">  
                                <div class="desc " >มูลค่า 11,900 บาท (จำนวน 1 รางวัล)</div>
                            </div>
                        </div>  
                        
                        <!-- <div class="icon_00_bottom icon_left"></div>
                        <div class="icon_00_bottom icon_right"></div> -->
                    </div>  
                    
                    <!-- user ที่ได้รางวัล -->
                    <div class="campaign-item-inner campaign-user " >   
                        <!-- <div class="icon_00_top icon_left " ></div>
                        <div class="icon_00_top icon_right " ></div> -->

                        <div class="position ">1</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">วัชระ สายปิง</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">กรุงเทพ</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">091-576-xxxx</span></div>  
                        </div> 
                    </div> 
                </div>
                
                <h3 class="font-extra-bold  text-success text-center text-rewrad-name">
                    รางวัลที่ 7
                </h3>
                <div class="campaign-item " > 
                    
                    <!-- ชื่อของรางวัล -->
                    <div class="campaign-item-inner campaign-rewrad">  
                        <div class="inner_wrapper">
                            <div class="line_wrapper"> 
                                <div class="icon_gift"></div> 
                                <div class="reward_name " >SAMSUMG TV HD LED (32")</div>
                            </div>
                            <div class="line_wrapper">  
                                <div class="desc " >มูลค่า 9,490 บาท  (จำนวน 1 รางวัล)</div>
                            </div>
                        </div>  
                        
                        <!-- <div class="icon_00_bottom icon_left"></div>
                        <div class="icon_00_bottom icon_right"></div> -->
                    </div>  
                    
                    <!-- user ที่ได้รางวัล -->
                    <div class="campaign-item-inner campaign-user " >   
                        <!-- <div class="icon_00_top icon_left " ></div>
                        <div class="icon_00_top icon_right " ></div> -->

                        <div class="position ">1</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">วัชราภรณ์ วรรณชู</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">กรุงเทพฯ</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">063-119-xxxx</span></div>  
                        </div> 
                    </div> 
                </div>
                
                <h3 class="font-extra-bold  text-success text-center text-rewrad-name">
                    รางวัลที่ 8
                </h3>
                <div class="campaign-item " > 
                    
                    <!-- ชื่อของรางวัล -->
                    <div class="campaign-item-inner campaign-rewrad">  
                        <div class="inner_wrapper">
                            <div class="line_wrapper"> 
                                <div class="icon_gift"></div> 
                                <div class="reward_name " >Supreme Power Bank</div>
                            </div>
                            <div class="line_wrapper">  
                                <div class="desc " >มูลค่า 8,500 บาท (จำนวน 2 รางวัล)</div>
                            </div>
                        </div>  
                        
                        <!-- <div class="icon_00_bottom icon_left"></div>
                        <div class="icon_00_bottom icon_right"></div> -->
                    </div>  
                    
                    <!-- user ที่ได้รางวัล -->
                    <div class="campaign-item-inner campaign-user " >   
                        <!-- <div class="icon_00_top icon_left " ></div>
                        <div class="icon_00_top icon_right " ></div> -->

                        <div class="position ">1</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">Phakawan sruprajam</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">จันทบุรี</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">095-532-xxxx</span></div>  
                        </div> 
                    </div>
                    
                    <div class="campaign-item-inner campaign-user " >   
                        <div class="position ">2</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">นิรันดร์ ยิ้มย่อง</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">กรุงเทพฯ</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">084-011-xxxx</span></div>  
                        </div> 
                    </div> 
                </div>
                
                <h3 class="font-extra-bold  text-success text-center text-rewrad-name">
                    รางวัลที่ 9
                </h3>
                <div class="campaign-item " > 
                    
                    <!-- ชื่อของรางวัล -->
                    <div class="campaign-item-inner campaign-rewrad">  
                        <div class="inner_wrapper">
                            <div class="line_wrapper"> 
                                <div class="icon_gift"></div> 
                                <div class="reward_name " >Bearbrick Nike SB</div>
                            </div>
                            <div class="line_wrapper">  
                                <div class="desc " >มูลค่า 4,850 บาท (จำนวน 2 รางวัล)</div>
                            </div>
                        </div>  
                        
                        <!-- <div class="icon_00_bottom icon_left"></div>
                        <div class="icon_00_bottom icon_right"></div> -->
                    </div>  
                    
                    <!-- user ที่ได้รางวัล -->
                    <div class="campaign-item-inner campaign-user " >   
                        <!-- <div class="icon_00_top icon_left " ></div>
                        <div class="icon_00_top icon_right " ></div> -->

                        <div class="position ">1</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">เกศมณี โสภาศรี</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text "> กรุงเทพฯ</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">087-715-xxxx</span></div>  
                        </div> 
                    </div><div class="campaign-item-inner campaign-user " >   
                        
                        

                        <div class="position ">2</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">สุพิชฌาย์ จันทร์พุฒ</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">ตาก</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">086-337-xxxx</span></div>  
                        </div> 
                    </div> 
                </div>
                
                <h3 class="font-extra-bold  text-success text-center text-rewrad-name">
                    รางวัลที่ 10
                </h3>
                <div class="campaign-item "> 
                    
                    <!-- ชื่อของรางวัล -->
                    <div class="campaign-item-inner campaign-rewrad">  
                        <div class="inner_wrapper">
                            <div class="line_wrapper"> 
                                <div class="icon_gift"></div> 
                                <div class="reward_name " >Kylie Cosmetic Gift Card</div>
                            </div>
                            <div class="line_wrapper">  
                                <div class="desc " >มูลค่า 3,300 บาท(จำนวน 2 รางวัล)</div>
                            </div>
                        </div>  
                        
                        <!-- <div class="icon_00_bottom icon_left"></div>
                        <div class="icon_00_bottom icon_right"></div> -->
                    </div>  
                    
                    <!-- user ที่ได้รางวัล -->
                    <div class="campaign-item-inner campaign-user " >   
                        <!-- <div class="icon_00_top icon_left " ></div>
                        <div class="icon_00_top icon_right " ></div> -->

                        <div class="position ">1</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">ศิโรรัตน์ นิ้วทอง</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">หนองคาย</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">093-468-xxxx</span></div>  
                        </div> 
                    </div>
                    
                    <div class="campaign-item-inner campaign-user ">
                        <div class="position ">2</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">สิริธัญญ์ เจริญวัย</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">เชียงราย</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">083-063-xxxx</span></div>  
                        </div> 
                    </div> 
                </div>
                
                <h3 class="font-extra-bold  text-success text-center text-rewrad-name">
                    รางวัลที่ 11
                </h3>
                <div class="campaign-item " > 
                    
                    <!-- ชื่อของรางวัล -->
                    <div class="campaign-item-inner campaign-rewrad">  
                        <div class="inner_wrapper">
                            <div class="line_wrapper"> 
                                <div class="icon_gift"></div> 
                                <div class="reward_name " >Anti Social Culb Cap</div>
                            </div>
                            <div class="line_wrapper">  
                                <div class="desc " >มูลค่า 3,000 บาท (จำนวน 2 รางวัล)</div>
                            </div>
                        </div>  
                        
                        <!-- <div class="icon_00_bottom icon_left"></div>
                        <div class="icon_00_bottom icon_right"></div> -->
                    </div>  
                    
                    <!-- user ที่ได้รางวัล -->
                    <div class="campaign-item-inner campaign-user " >   
                        <!-- <div class="icon_00_top icon_left " ></div>
                        <div class="icon_00_top icon_right " ></div> -->

                        <div class="position ">1</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">Tnanporn Rahanthai</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">อ่างทอง</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">093-885-xxxx</span></div>  
                        </div> 
                    </div>
                    
                    <div class="campaign-item-inner campaign-user ">
                        <div class="position ">2</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">กัญญาพัชร์ ทรวงโพธิ์</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">นครราชสีมา</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">064-728-xxxx</span></div>  
                        </div> 
                    </div> 
                </div>
                
                <h3 class="font-extra-bold  text-success text-center text-rewrad-name">
                    รางวัลที่ 12
                </h3>
                <div class="campaign-item " > 
                    
                    <!-- ชื่อของรางวัล -->
                    <div class="campaign-item-inner campaign-rewrad">  
                        <div class="inner_wrapper">
                            <div class="line_wrapper"> 
                                <div class="icon_gift"></div> 
                                <div class="reward_name " >เสื้อสโมสรเชลซี</div>
                            </div>
                            <div class="line_wrapper">  
                                <div class="desc " > (จำนวน 1 รางวัล)</div>
                            </div>
                        </div>  
                        
                        <!-- <div class="icon_00_bottom icon_left"></div>
                        <div class="icon_00_bottom icon_right"></div> -->
                    </div>  
                    
                    <!-- user ที่ได้รางวัล -->
                    <div class="campaign-item-inner campaign-user " >   
                        <!-- <div class="icon_00_top icon_left " ></div>
                        <div class="icon_00_top icon_right " ></div> -->

                        <div class="position ">1</div> 
                        <div class="details">
                            <div class="name"><span class="logo_name"></span> <span class="text ">วลิน เมืองแมน</span></div> 
                            <div class="addres"><span class="logo_address"></span> <span class="text ">สุราษร์ธานี</span></div> 
                            <div class="contact"><span class="logo_contact"></span> <span class="text ">081-535-xxxx</span></div>  
                        </div> 
                    </div> 
                </div>
            </div>   
        </div>
    </div>
</section>
