<?php

// include('config.php');
include('classes/config.php');
$obj = new frontclass();
$obj2 = new commonFrontclass();

$page_id = '122';
$main_page_id = $page_id;
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = $obj->getPageDetails($page_id);
$ref = base64_encode('my_rewards_scheme.php');
if(!$obj->isLoggedIn())
{
//	header("Location: login.php?ref=".$ref);
  echo "<script>window.location.href='login.php?ref=$ref'</script>";
	exit(0);
}
else
{
	$user_id = $_SESSION['user_id'];
	$obj->doUpdateOnline($_SESSION['user_id']);
}


$point_scheme=$obj2->getRewardPointsSchemes();

$bonus_scheme=$obj2->getRewardBonusSchemes();

// echo "<pre>";

// print_r($point_scheme);

// echo "<pre>";

// print_r($bonus_scheme);

// die('-sss');



?><!DOCTYPE html>
<html lang="en">
<head>
 <?php include_once('head.php');?>
</head>


<body id="boxed">
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
<div class="boxed-wrapper">
<!--header-->
<!-- <header> -->
 <?php //include 'topbar.php'; ?>
<?php include_once('header.php');?>
<!-- </header> -->

<!--header End --> 	
 <!--breadcrumb--> 

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
<!--breadcrumb end --> 
<!--container-->              
<div class="container" >
<div class="row">	
<div class="col-md-8">	
      	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td align="left" valign="top"><span class="Header_brown"><?php echo $obj->getPageTitle($page_id);?></span><br /><br /><?php echo $obj->getPageContents($page_id);?></td>
                            </tr>
                        </table>

                <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#point">Reward Points</a></li>
                <li><a data-toggle="tab" href="#bonus">Reward Bonus</a></li>

              </ul>

              <div class="tab-content">
                <div id="point" class="tab-pane fade in active">
                  <br>
                  <h3>Reward Points</h3>
                  <br>
                  <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Reward Module</th>
                          <th>Conversion</th>
                          <th>Equivalent</th>
                          <th>Cutoff</th>
                          <th>Effective Date</th>
                          <th>Closing Date</th>
                          <th>Type</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 

                        if(!empty($point_scheme))
                        { 
                          foreach ($point_scheme as $key => $value) {
                            ?>
                            <tr>
                              <td><?=$key+1;?></td>
                              <td><?=$value['page_name'];?></td>
                              <td><?=$value['reward_point_conversion_value']; echo '&nbsp'; echo $obj2->getFavCategoryName($value['reward_point_conversion_type_id']);?></td>
                              <td><?=$value['equivalent_value']; echo '&nbsp'; echo $obj2->getFavCategoryName($value['equivalent_type']); ?></td>
                              <td><?=$obj2->getFavCategoryName($value['reward_point_cutoff_type_id']); ?>
                                  
                                  <br><span>Min: <?=$value['reward_point_min_cutoff'];?></span>
                                  <br><span>Max: <?=$value['reward_point_max_cutoff'];?></span>
                              </td>
                              <td><?=date("d-m-Y", strtotime($value['reward_point_date']));?></td>
                              <td><?php
                                if($value['event_close_date']=='0000-00-00')
                                {
                                  echo 'N/A';
                                }
                                else
                                { 
                                  echo date("d-m-Y", strtotime($value['event_close_date']));
                                }
                                ?>
                                </td>
                                <td><?= $obj2->getFavCategoryName($value['reward_type']); ?></td>
                            </tr>
                            <?php
                          }
                        }
                        else
                        {
                          ?>
                          <tr><td colspan="8">No data found!</td></tr>
                          <?php
                        }

                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div id="bonus" class="tab-pane fade">
                  <br>
                  <h3>Reward Bonus</h3>
                  <br>
                  <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Reward Module</th>
                          <th>Conversion</th>
                          <th>Equivalent</th>
                          <th>Cutoff</th>
                          <th>Effective Date</th>
                          <th>Closing Date</th>
                          <th>Type</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 

                        if(!empty($bonus_scheme))
                        { 
                          foreach ($bonus_scheme as $key => $value) {
                            ?>
                            <tr>
                              <td><?=$key+1;?></td>
                              <td><?=$value['page_name'];?></td>
                              <td><?=$value['reward_bonus_conversion_value']; echo '&nbsp'; echo $obj2->getFavCategoryName($value['reward_bonus_conversion_type_id']);?></td>
                              <td><?=$value['equivalent_value']; echo '&nbsp'; echo $obj2->getFavCategoryName($value['equivalent_type']); ?></td>
                              <td><?=$obj2->getFavCategoryName($value['reward_bonus_cutoff_type_id']); ?>
                                  
                                  <br><span>Min: <?=$value['reward_bonus_min_cutoff'];?></span>
                                  <br><span>Max: <?=$value['reward_bonus_max_cutoff'];?></span>
                              </td>
                              <td><?=date("d-m-Y", strtotime($value['reward_bonus_date']));?></td>
                              <td><?php
                                if($value['event_close_date']=='0000-00-00')
                                {
                                  echo 'N/A';
                                }
                                else
                                { 
                                  echo date("d-m-Y", strtotime($value['event_close_date']));
                                }
                                ?>
                                </td>
                                <td><?= $obj2->getFavCategoryName($value['reward_type']); ?></td>
                            </tr>
                            <?php
                          }
                        }
                        else
                        {
                          ?>
                          <tr><td colspan="8">No data found!</td></tr>
                          <?php
                        }

                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

     </div>
     <div class="col-md-2"> 
        <?php include_once('left_sidebar.php'); ?>             
     </div>
     <div class="col-md-2">             
        <?php include_once('right_sidebar.php'); ?>
     </div>
     </div>
</div>

   <?php include_once('footer.php');?>            

</div>       		

    
</body>
</html>