<?php

include ('classes/config.php');

$page_id = '147';

$obj = new frontclass();

$obj2 = new commonFrontclass();

$page_data = $obj->getPageDetails($page_id);

$ref = base64_encode($page_data['menu_link']);

$error = false;

$err_msg = '';

if (!$obj->isLoggedIn())

{

    $obj->doUpdateOnline($_SESSION['user_id']);

    //echo "<script>window.location.href='user_dashboard.php'</script>";
    header("Location: login.php?ref=" . $ref);

    exit();

}
$mood_page_id=$_GET['page_id'];
$theme_data=$obj2->getThemes_resetMood($mood_page_id);
$music_data=$obj2->getMusic_resetMood($mood_page_id);
$icon_data=$obj2->getIcons_resetMood($mood_page_id);

$band_set=$obj2->getBandSettingData_resetMood($mood_page_id);

// echo "<pre>";
// print_r($music_data);
// die('-ss');


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include_once ('head.php'); ?>

    </head>

    <body>
        <?php include_once ('analyticstracking.php'); ?>
        <?php include_once ('analyticstracking_ci.php'); ?>
        <?php include_once ('analyticstracking_y.php'); ?>
        <?php include_once ('header.php'); ?>
       

            <div class="container">
                <div class="breadcrumb">
                    <div class="row">
                        <div class="col-md-8">
                            <?php echo $obj->getBreadcrumbCode($page_id); ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                                if ($obj->isLoggedIn())
                                {
                                    echo $obj->getWelcomeUserBoxCode($_SESSION['name'], $_SESSION['user_id']);
                                }
                                ?>
                        </div>
                    </div>
                </div>
                <section>
                     <!-- Carousel -->
                      <div id="homeCarousel" class="carousel slide" data-ride="carousel">
                      <!-- Indicators -->
                      <!-- <ol class="carousel-indicators">
                          <li data-target="#homeCarousel" data-slide-to="0" class="active"></li>
                          <li data-target="#homeCarousel" data-slide-to="1"></li>
                          <li data-target="#homeCarousel" data-slide-to="2"></li>
                      </ol> -->
                      <!-- Wrapper for slides -->
                      <div class="carousel-inner">

                         <?php 
                          if(!empty($theme_data))
                          {
                            foreach ($theme_data as $key => $value) {
                              ?>
                              <!-- item start -->
                              <div class="item <?=($key==0)? 'active' : '' ;?>">
                                <img src="uploads/<?=$value['image'];?>" alt="<?=strip_tags($value['icons_name']);?>">
                              </div>
                              <!-- /item-end -->
                              <?php
                            }
                          }
                         ?>
                          
                      </div>
                      <!-- Controls -->
                      <a class="left carousel-control" href="#homeCarousel" data-slide="prev">
                          <span class="glyphicon glyphicon-chevron-left"></span>
                      </a>
                      <a class="right carousel-control" href="#homeCarousel" data-slide="next">
                          <span class="glyphicon glyphicon-chevron-right"></span>
                      </a>
                    </div><!-- /carousel -->
                </section>
                <section>
                  <div id="carousel-music" class="carousel slide item-slider" data-ride="carousel">
                      <!-- Wrapper for slides -->
                      <div class="col-md-9 col-xs-9">
                      </div>
                      <div class="col-md-3 col-xs-3">
                          <!-- Controls -->
                          <div class="controls pull-right">
                              <a class="left fa fa-chevron-left btn btn-success" href="#carousel-music"
                                  data-slide="prev"></a><a class="right fa fa-chevron-right btn btn-success" href="#carousel-music"
                                      data-slide="next"></a>
                          </div>
                      </div>

                      <?php
                      $products = $music_data; // Products retreived from database

                      $is_active = true; // Only true for the first iteration
                      $j = 0;
                      ?>
                      <div class="carousel-inner">
                        <?php 
                          if(!empty($music_data))
                          {
                            foreach ($music_data as $key => $value) {
                              if($j % 4 == 0)
                              {
                                ?>
                                <div class="item<?php if ($is_active) echo ' active'?>">
                                  <div class="row">
                                <?php
                              }
                              ?>
                                  <div class="col-sm-3 col-xs-6">
                                        <div class="col-item">
                                            <div class="photo">
                                                <!-- <img src="http://placehold.it/350x260" class="img-responsive" alt="a" /> -->
                                                <?php
                                                if(!empty($value["banner"]))
                                                {
                                                  echo '<embed src="'.SITE_URL.'/uploads/'.$value["banner"].'" autostart="off" autoplay="false" loop="true" height="100px" width="100%"></embed>';
                                                }
                                                else
                                                {
                                                  echo '<img src="images/no-image.png" class="img-responsive" alt="" height="100px" />';
                                                }
                                                ?>
                                            </div>
                                            <div class="info">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5 class="feature-title">
                                                            <?=$value['topic_subject']?></h5>
                                                        <h5 class="price-text-color">
                                                            <?=$value['banner']?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              <?php
                              if((($j+1) % 4 == 0 || $j == count($music_data)-1))
                              {
                                ?>
                                  </div>
                                </div>
                                <?php
                              }
                              $j++;
                              if($is_active)
                              {
                                $is_active = false;
                              }
                            }
                          }
                        ?>
                      </div>
                    </div>
                   
                </section>
                <section>
                  <div id="carousel-icons" class="carousel slide item-slider" data-ride="carousel">
                      <!-- Wrapper for slides -->
                      <div class="col-md-9 col-xs-9">
                      </div>
                      <div class="col-md-3 col-xs-3">
                          <!-- Controls -->
                          <div class="controls pull-right">
                              <a class="left fa fa-chevron-left btn btn-success" href="#carousel-icons"
                                  data-slide="prev"></a><a class="right fa fa-chevron-right btn btn-success" href="#carousel-icons"
                                      data-slide="next"></a>
                          </div>
                      </div>

                      <?php
                      $products = $icon_data; // Products retreived from database

                      $is_active = true; // Only true for the first iteration
                      $j = 0;
                      ?>
                      <div class="carousel-inner">
                        <?php 
                          if(!empty($icon_data))
                          {
                            foreach ($icon_data as $key => $value) {
                              if($j % 4 == 0)
                              {
                                ?>
                                <div class="item<?php if ($is_active) echo ' active'?>">
                                  <div class="row">
                                <?php
                              }
                              ?>
                                  <div class="col-sm-3 col-xs-6">
                                        <div class="col-item">
                                            <div class="photo">
                                                <!-- <img src="http://placehold.it/350x260" class="img-responsive" alt="a" /> -->
                                                <?php
                                                if(!empty($value["image"]))
                                                {
                                                  echo '<img src="uploads/'.$value["image"].'" class="img-responsive" alt="" height="100px" />';
                                                }
                                                else
                                                {
                                                  echo '<img src="images/no-image.png" class="img-responsive" alt="" height="100px" />';
                                                }
                                                ?>
                                            </div>
                                            <div class="info">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5 class="feature-title">
                                                            <?=$value['icons_name']?></h5>
                                                        <h5 class="price-text-color">
                                                            <?=$value['display_name']?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              <?php
                              if((($j+1) % 4 == 0 || $j == count($icon_data)-1))
                              {
                                ?>
                                  </div>
                                </div>
                                <?php
                              }
                              $j++;
                              if($is_active)
                              {
                                $is_active = false;
                              }
                            }
                          }
                        ?>
                      </div>
                    </div>
                   
                </section>
            </div>  
        <?php include_once ('footer.php'); ?>
        <script type="text/javascript">
            $('#homeCarousel').carousel({
                interval: 3000,
                cycle: true
              }); 
            $('#carousel-music').carousel({
                interval: 3000,
                cycle: true
              });
            $('#carousel-icons').carousel({
                interval: 3000,
                cycle: true
              });
          </script>
    </body>

    </html>