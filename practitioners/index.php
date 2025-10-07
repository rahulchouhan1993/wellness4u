<?php
require_once('../config.php');
header('Location: practitioners_hub.php');
$page_id = '76';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

if(!isLoggedInPro())
{
	header("Location: ".SITE_URL."/prof_login.php");
	exit(0);
}
else
{	
	doUpdateOnlinePro($_SESSION['pro_user_id']);
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $meta_description;?>" />
	<meta name="keywords" content="<?php echo $meta_keywords;?>" />
	<meta name="title" content="<?php echo $meta_title;?>" />
	<title><?php echo $meta_title;?></title>
	<link href="../cwri.css" rel="stylesheet" type="text/css" />
     <link href="../csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />
	<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="js/commonfn.js"></script>
	<script type="text/javascript" src="../js/jquery.bxSlider.js"></script>
    <link href="css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="../js/jquery.ticker.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
		
			$('#js-news').ticker({
				controls: true,        // Whether or not to show the jQuery News Ticker controls
				 htmlFeed: true, 
				titleText: '',   // To remove the title set this to an empty String
				displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'
				direction: 'ltr'       // Ticker direction - current options are 'ltr' or 'rtl'
				
			});
			
			$(".QTPopup").css('display','none')
			
			$(".feedback").click(function(){
				$(".QTPopup").animate({width: 'show'}, 'slow');
			});	
	
			$(".closeBtn").click(function(){			
				$(".QTPopup").css('display', 'none');
			});
		});
	</script>
	<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
	<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
	<script type="text/javascript">
		ddsmoothmenu.init({
		mainmenuid: "smoothmenu1", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		//customtheme: ["#1c5a80", "#18374a"],
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
		})
	</script>


       
    </head>

  <body>
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
        
       
     <!--top-bar end here-->

      <?php include 'topbar.php'; ?>
       <?php include 'header.php'; ?>


        <?php echo getScrollingWindowsCodeMainContent($page_id);?>

 <!--rev slider start-->

           <!--full width banner-->

             <div style="float:right">
            <?php

                    if(isLoggedIn())

                    { 

                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);

                    }

                    ?></div>

<?php  echo $page_contents; ?>

<html>
<!--header-->
<header>
 <?php include 'topbar.php'; ?>
<?php include_once('header.php');?>
</header>
<!--header End --> 			
<!--breadcrumb--> 
  
 <div class="container"> 
    <div class="breadcrumb">
               
                    <div class="row">
                    <div class="col-md-8">	
                      <?php echo getBreadcrumbCode($page_id);?> 
                       </div>
                         <div class="col-md-4">
                        
                         </div>
                       </div>
                </div>
 </div>          
<!--breadcrumb end --> 
<div class="container" >
<div class="row">	
<div class="col-md-12">	

						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" valign="top">
									<span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br /><br />
									<?php echo getPageContents($page_id);?>
								</td>
							</tr>
						</table>
					
</div>
</div>
</div>
 <footer> 
   <div class="container">
   <div class="row">
   <div class="col-md-12">	
   <?php include_once('footer.php');?>            
  </div>
  </div>
  </div>
  </footer>
<!-- Bootstrap Core JavaScript -->

 <!--default footer end here-->
       <!--scripts and plugins -->
        <!--must need plugin jquery-->
        <script src="../csswell/js/jquery.min.js"></script>        
        <!--bootstrap js plugin-->
        <script src="../csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
</body>
</html>