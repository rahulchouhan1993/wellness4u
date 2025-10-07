<?php

// include('config.php');
include('classes/config.php');
$obj = new frontclass();
$obj2 = new frontclass2();

$page_id = '153';
$main_page_id = $page_id;
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = $obj->getPageDetails($page_id);
$ref = base64_encode('my_rewards_catlog.php');
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
                    
                    <div class="" id="reward_catlog">
                    <?php 

                      echo $obj->showRewardCatlog();

                    ?>       
                  </div>
     </div>
     <div class="col-md-2">	             
        <?php include_once('right_sidebar.php'); ?>
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