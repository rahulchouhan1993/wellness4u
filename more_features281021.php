<?php 
include('classes/config.php');
$page_id = '188';
$obj = new frontclass();
$page_data = $obj->getPageDetails($page_id);
$ref = base64_encode($page_data['menu_link']);
$display_data=$obj->getAllIconsDisplayTypeDetails();

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
                
                     <div class="col-md-10" style="text-align: center;">

                          <!--for get page icon 22-04-20- V241021 -->
                         <?php echo $obj->getPageIcon($page_id);?>
                        <span class="Header_brown"><?php echo $page_data['page_title'];?></span><br /><br />
                        <?php echo $obj->getPageContents($page_id);?>
                        <br><p></p> <br><p></p> <br><p></p> <br>
                     
                         <div  class="col-md-8" >
                          <?php echo $obj->getScrollingWindowsCodeMainContent($page_id);?>
                            <?php echo $obj->getPageContents2($page_id);?> 
                        </div> 
                      </div>                    
                 
		<div class="col-md-2"> <?php include_once('left_sidebar.php'); ?></div>
		<div class="col-md-2"><?php include_once('right_sidebar.php'); ?></div>
     </div>
                   
    <section class="home-service">
      <div class="container">
            <?php
              if(!empty($display_data))
              {
                ?>
                <div class="row">
                <?php
                foreach ($display_data as $key => $rec) {
                  $key=$key+1;
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

                     if($key%3==0)
                     {
                       ?>
                        </div>
                        <div class="row">
                       <?php
                     }
                }
                ?>
                </div>
                <?php
              }
            ?>
      </div>

    </section>
  <?php include_once('footer.php');?>
  </body>
  </html>