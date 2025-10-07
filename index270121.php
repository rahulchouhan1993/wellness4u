<?php 
include('classes/config.php');
$page_id = '1';
$obj = new frontclass();
$page_data = $obj->getPageDetails($page_id);
$ref = base64_encode($page_data['menu_link']);
$display_data=$obj->getAllIconsDisplayTypeDetails(3);

$home_banners=$obj->getHomeSliderBanners();

$band_set2=$obj->getBandSettingData(1,2);
$band_set3=$obj->getBandSettingData(1,3);
$band_set4=$obj->getBandSettingData(1,4);
$band_set5=$obj->getBandSettingData(1,5);

$home_items=$obj->getHomeWSI();

// echo "<pre>";
// print_r($home_items);
// die('-sss');

?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <?php include_once('head.php');?>
  </head>
  <body>
    <?php include_once('analyticstracking.php'); ?>
    <?php include_once('analyticstracking_ci.php'); ?>
    <?php include_once('analyticstracking_y.php'); ?>
    <?php include_once('header.php');?>

        <div class="container">
          <div class="breadcrumb">
            <div class="row">
              <div class="col-md-8">
                <?php echo $obj->getBreadcrumbCode($page_id);?>
              </div>
              <div class="col-md-4">
                <?php
                  if($obj->isLoggedIn())
                  { 
                      echo $obj->getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);
                  }
                  ?>
              </div>
            </div>
          </div>
        </div>
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
          if(!empty($home_banners))
          {
            foreach ($home_banners as $key => $value) {
              ?>
              <!-- item start -->
              <div class="item <?=($key==0)? 'active' : '' ;?>">
                <img src="uploads/<?=$value['banner_image'];?>" alt="<?=strip_tags($value['banner_title']);?>">
                        <div class="header-text">
                            <div class="col-md-12 text-left">
                                <?=$value['banner_title'];?>
                                <?=$value['banner_text_line1'];?>
                                <?=$value['banner_text_line2'];?>
                                <div class="btn-section">
                                <?php 
                                  if(!empty($value['button1']) && $value['button1_show']==1)
                                  {
                                    $btn_action='javascript:void(0)';
                                    $btn_target='';
                                    if(!empty($value['button1_url']))
                                    {
                                      $btn_action=$value['button1_url'];
                                      $btn_target='target="_blank"';
                                    }
                                    ?>
                                      <a class="btn btn-default btn-min-block" href="<?=$btn_action;?>" <?=$btn_target;?> style="font-family: <?=$value['button1_font_family']?>;font-size: <?=$value['button1_font_size']?>px;color: #<?=$value['button1_font_color']?>; background-color: #<?=$value['button1_bg_color']?>;border:unset;"><?=$value['button1'];?></a>
                                    <?php
                                  }
                                ?>
                                <?php 
                                  if(!empty($value['button2']) && $value['button2_show']==1)
                                  { 
                                    $btn_action='javascript:void(0)';
                                    $btn_target='';
                                    if(!empty($value['button2_url']))
                                    {
                                      $btn_action=$value['button2_url'];
                                      $btn_target='target="_blank"';
                                    }
                                    ?>
                                      <a class="btn btn-default btn-min-block" href="<?=$btn_action;?>" <?=$btn_target;?> style="font-family: <?=$value['button2_font_family']?>;font-size: <?=$value['button2_font_size']?>px;color: #<?=$value['button2_font_color']?>; background-color: #<?=$value['button2_bg_color']?>;border:unset;"><?=$value['button2'];?></a>
                                    <?php
                                  }
                                ?>
                              </div>
                            </div>
                        </div>
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
    <?php 
    for ($i=1; $i < 11; $i++) { 
       if($i==$band_set2['order_no'])
       {
        ?>
        <section class="home-service" style="background-color: #<?=$band_set2['bg_color'];?>;background-image: url(uploads/<?=$band_set2['bg_image'];?>);background-position: center; background-size: cover;">
          <div class="container">
              <div class="row">
                <div class="col-md-12 text-center">
                    <?=$band_set2['band_title']?>
                    <?=$band_set2['band_text']?>
                </div>
              </div>
              <div class="row">
                <?php
                  if(!empty($display_data))
                  {
                    foreach ($display_data as $key => $rec) {
                      $url ='';
                         if($rec['take_key_wellbgn_ref_num']==1)
                         {
                           $url .='&ref_num='.$rec['wellbgn_ref_num'];  
                         }
                         if($rec['take_key_fav_cat_id']==1)
                         {
                           $url .='&fav_cat_id='.$rec['fav_cat_id'];  
                         }
                         if($rec['take_key_fav_cat_type_id']==1)
                         {
                           $url .='&fav_cat_type_id='.$rec['fav_cat_type_id'];  
                         }
                         if($rec['take_key_card_name']==1)
                         {
                           $url .='&display_name='.$rec['display_name'];  
                         }
                         if($rec['take_key_comment']==1)
                         {
                           $url .='&comment='.strip_tags($rec['comment']);  
                         }
                         
                         if($rec['take_key_group_code']==1)
                         {
                           $url .='&group_id='.strip_tags($rec['group_code_id']);  
                         }
                         ?>
                         <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="service-box">
                               <a href='<?php echo $rec['link'];?>?<?php echo $url; ?>' target="_blank"><img src="uploads/<?php echo $rec['image']; ?>" title="<?php echo $rec['display_name'];?>" class="service-icon"></a>
                                <h3> <?php echo stripslashes($rec['display_name']);?></h3>
                                <p><?php echo $rec['comment'];?></p>
                            </div>
                        </div>
                         <?php
                    }
                  }
                ?>
              </div>
              <div class="btn-section text-center">
              <?php 
                  if(!empty($band_set2['button1']) && !empty($band_set2['button1_url']) && $band_set2['button1_show']==1)
                  {
                     $btn_action='javascript:void(0)';
                     $btn_target='';
                      if(!empty($band_set2['button1_url']))
                      {
                        $btn_action=$band_set2['button1_url'];
                        $btn_target='target="_blank"';
                      }
                    ?>
                      <a class="btn btn-default btn-min-block" href="<?=$btn_action;?>" <?=$btn_target;?> style="font-family: <?=$band_set2['button1_font_family']?>;font-size: <?=$band_set2['button1_font_size']?>px;color: #<?=$band_set2['button1_font_color']?>; background-color: #<?=$band_set2['button1_bg_color']?>;border:unset;"><?=$band_set2['button1'];?></a>
                    <?php
                  }
                ?>
                <?php 
                  if(!empty($band_set2['button2']) && !empty($band_set2['button2_url']) && $band_set2['button2_show']==1)
                  {
                    $btn_action='javascript:void(0)';
                    $btn_target='';
                      if(!empty($band_set2['button2_url']))
                      {
                        $btn_action=$band_set2['button2_url'];
                        $btn_target='target="_blank"';
                      }
                    ?>
                      <a class="btn btn-default btn-min-block" href="<?=$btn_action;?>" <?=$btn_target;?> style="font-family: <?=$band_set2['button2_font_family']?>;font-size: <?=$band_set2['button2_font_size']?>px;color: #<?=$band_set2['button2_font_color']?>; background-color: #<?=$band_set2['button2_bg_color']?>;border:unset;"><?=$band_set2['button2'];?></a>
                    <?php
                  }
                ?>
                <?php 
                $service_data=$obj->getAllIconsDisplayTypeDetails();
                if(count($service_data)>3)
                {
                  ?>
                  <br><br>
                  <a href="more_features.php" target="blank"><button class="btn btn-default">View More Features</button></a>
                  <?php
                }
              ?>
              </div>
          </div>
        </section>
        <?php
       }
       if($i==$band_set3['order_no'])
       {
        ?>
        <section class="home-search-section" style="background-color: #<?=$band_set3['bg_color'];?>;background-image: url(uploads/<?=$band_set3['bg_image'];?>);background-position: center; background-size: cover;">
          <div class="row">
            <div class="col-md-12 text-center">
               <?=$band_set3['band_title']?>
               <?=$band_set3['band_text']?>
                <div class="searchbar-box">
                  <div class="searchbar">
                    <form method="get" action="<?=($band_set3['data_link'])? $band_set3['data_link'] : 'my_wellness_solutions_item.php';?>">
                    <input class="search_input" type="text" name="search" placeholder="<?=($band_set3['data_content'])? $band_set3['data_content'] : 'Search...';?>">
                    <button type="submit" class="search_icon"><i class="glyphicon glyphicon-search"></i></button>
                    </form>
                  </div>
                </div>
                <div class="btn-section">
                    <?php 
                      if(!empty($band_set3['button1'])  && $band_set3['button1_show']==1)
                      {
                        $btn_action='javascript:void(0)';
                        $btn_target='';
                        if(!empty($band_set3['button1_url']))
                        {
                          $btn_action=$band_set3['button1_url'];
                          $btn_target='target="_blank"';
                        }
                        ?>
                          <a class="btn btn-default btn-min-block" href="<?=$btn_action;?>" <?=$btn_target;?> style="font-family: <?=$band_set3['button1_font_family']?>;font-size: <?=$band_set3['button1_font_size']?>px;color: #<?=$band_set3['button1_font_color']?>; background-color: #<?=$band_set3['button1_bg_color']?>;border:unset;"><?=$band_set3['button1'];?></a>
                        <?php
                      }
                    ?>
                    <?php 
                      if(!empty($band_set3['button2']) && $band_set3['button2_show']==1)
                      {
                        $btn_action='javascript:void(0)';
                        $btn_target='';
                        if(!empty($band_set3['button2_url']))
                        {
                          $btn_action=$band_set3['button2_url'];
                          $btn_target='target="_blank"';
                        }
                        ?>
                          <a class="btn btn-default btn-min-block" href="<?=$btn_action;?>" <?=$btn_target;?> style="font-family: <?=$band_set3['button2_font_family']?>;font-size: <?=$band_set3['button2_font_size']?>px;color: #<?=$band_set3['button2_font_color']?>; background-color: #<?=$band_set3['button2_bg_color']?>;border:unset;"><?=$band_set3['button2'];?></a>
                        <?php
                      }
                    ?>
                  </div>
            </div>
          </div>
        </section>
        <?php
       }
       if($i==$band_set4['order_no'])
       {
        ?>
        <section class="home-feature" style="background-color: #<?=$band_set4['bg_color'];?>;background-image: url(uploads/<?=$band_set4['bg_image'];?>);background-position: center; background-size: cover;">
          <div class="container">
              <div class="row">
                               
                  <div id="carousel-product" class="carousel slide item-slider" data-ride="carousel">
                      <!-- Wrapper for slides -->

                      <div class="col-md-9 col-xs-9">
                          <?=$band_set4['band_title']?>
                          <?=$band_set4['band_text']?>
                      </div>
                      <div class="col-md-3 col-xs-3">
                          <!-- Controls -->
                          <div class="controls pull-right">
                              <a class="left fa fa-chevron-left btn btn-success" href="#carousel-product"
                                  data-slide="prev"></a><a class="right fa fa-chevron-right btn btn-success" href="#carousel-product"
                                      data-slide="next"></a>
                          </div>
                      </div>

                      <?php
                      $products = $home_items; // Products retreived from database

                      $is_active = true; // Only true for the first iteration
                      $j = 0;
                      ?>
                      <div class="carousel-inner">
                        <?php 
                          if(!empty($home_items))
                          {
                            foreach ($home_items as $key => $value) {
                              $gallery=$obj->get_gallery_data_wellness_items($value['sol_item_id']);
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
                                                if(!empty($gallery))
                                                {
                                                  echo $obj->get_common_gallery_file($gallery[0]['banner_type'],$gallery[0]['banner']);
                                                }
                                                else
                                                {
                                                  echo '<img src="images/no-image.png" class="img-responsive" alt="" height="150px" />';
                                                }
                                                ?>
                                            </div>
                                            <div class="info">
                                                <div class="row">
                                                    <div class="price col-md-12">
                                                        <h5 class="feature-title">
                                                            <?=$value['topic_subject']?></h5>
                                                        <h5 class="price-text-color">
                                                            <?=$value['narration']?></h5>
                                                    </div>
                                                    <div class="col-md-12" style="height: 25px;">
                                                    <?php echo ((strlen($value['narration']) > 100) ? '<a href="wsi_read_more.php?type=wsi&token='.base64_encode($value["sol_item_id"]).'" target="_blank"><button class="btn btn-default btn-sm" style="padding: 2px 4px;font-size: 9px;">Read More</button></a>' : ''); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              <?php
                              if((($j+1) % 4 == 0 || $j == count($home_items)-1))
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
                      
                    <div class="btn-section text-center col-md-12" style="margin-top: 10px;margin-bottom: 10px;">
                    <?php 
                      if(!empty($band_set4['button1']) && $band_set4['button1_show']==1)
                      {
                        $btn_action='javascript:void(0)';
                        $btn_target='';
                        if(!empty($band_set4['button1_url']))
                        {
                          $btn_action=$band_set4['button1_url'];
                          $btn_target='target="_blank"';
                        }
                        ?>
                          <a class="btn btn-default btn-min-block" href="<?=$btn_action;?>" <?=$btn_target;?> style="font-family: <?=$band_set4['button1_font_family']?>;font-size: <?=$band_set4['button1_font_size']?>px;color: #<?=$band_set4['button1_font_color']?>; background-color: #<?=$band_set4['button1_bg_color']?>;border:unset;"><?=$band_set4['button1'];?></a>
                        <?php
                      }
                    ?>
                    <?php 
                      if(!empty($band_set4['button2']) && $band_set4['button2_show']==1)
                      {
                        $btn_action='javascript:void(0)';
                        $btn_target='';
                        if(!empty($band_set4['button2_url']))
                        {
                          $btn_action=$band_set4['button2_url'];
                          $btn_target='target="_blank"';
                        }
                        ?>
                          <a class="btn btn-default btn-min-block" href="<?=$btn_action;?>" <?=$btn_target;?> style="font-family: <?=$band_set4['button2_font_family']?>;font-size: <?=$band_set4['button2_font_size']?>px;color: #<?=$band_set4['button2_font_color']?>; background-color: #<?=$band_set4['button2_bg_color']?>;border:unset;"><?=$band_set4['button2'];?></a>
                        <?php
                      }
                    ?>
                  </div>
              </div>
          </div>
        </section>
        <?php
       }
       if($i==$band_set5['order_no'])
       {
        ?>
        <section class="home-common-section" style="background-color: #<?=$band_set5['bg_color'];?>;background-image: url(uploads/<?=$band_set5['bg_image'];?>);background-position: center; background-size: cover;">
          <div class="container">
              <div class="row">
                <div class="col-md-12 text-center">
                    <?=$band_set5['band_title']?>
                    <?=$band_set5['band_text']?>
                    <div class="btn-section">
                    <?php 
                        if(!empty($band_set5['button1'])  && $band_set5['button1_show']==1)
                        {
                          $btn_action='javascript:void(0)';
                          $btn_target='';
                          if(!empty($band_set5['button1_url']))
                          {
                            $btn_action=$band_set5['button1_url'];
                            $btn_target='target="_blank"';
                          }
                          ?>
                            <a class="btn btn-default btn-min-block" href="<?=$btn_action;?>" <?=$btn_target;?> style="font-family: <?=$band_set5['button1_font_family']?>;font-size: <?=$band_set5['button1_font_size']?>px;color: #<?=$band_set5['button1_font_color']?>; background-color: #<?=$band_set5['button1_bg_color']?>;border:unset;"><?=$band_set5['button1'];?></a>
                          <?php
                        }
                      ?>
                      <?php 
                        if(!empty($band_set5['button2']) && $band_set5['button2_show']==1)
                        { 
                          $btn_action='javascript:void(0)';
                          $btn_target='';
                          if(!empty($band_set5['button2_url']))
                          {
                            $btn_action=$band_set5['button2_url'];
                            $btn_target='target="_blank"';
                          }
                          ?>
                            <a class="btn btn-default btn-min-block" href="<?=$btn_action;?>" <?=$btn_target;?> style="font-family: <?=$band_set5['button2_font_family']?>;font-size: <?=$band_set5['button2_font_size']?>px;color: #<?=$band_set5['button2_font_color']?>; background-color: #<?=$band_set5['button2_bg_color']?>;border:unset;"><?=$band_set5['button2'];?></a>
                          <?php
                        }
                      ?>
                      <?php 
                    ?>
                    </div>
                </div>
              </div>
          </div>
        </section>
        <?php
       }
    }
    ?>
        
  <?php include_once('footer.php');?>
  <script type="text/javascript">
    $('#homeCarousel').carousel({
        interval: 3000,
        cycle: true
      }); 
    $('#carousel-product').carousel({
        interval: 3000,
        cycle: true
      });
  </script>
  </body>
  </html>