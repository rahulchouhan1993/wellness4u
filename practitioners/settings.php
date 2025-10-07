<?php
require_once('../config.php');
$page_id = '90';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$ref = base64_encode($menu_link);

if(!isLoggedInPro())
{
	header("Location: ".SITE_URL."/prof_login.php?ref=".$ref);
	exit(0);
}
else
{
	doUpdateOnlinePro($_SESSION['pro_user_id']);
	$pro_user_id = $_SESSION['pro_user_id'];
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
     <link href="../csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">       <link href="../csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />
	<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="../js/commonfn.js"></script>
	<script type="text/javascript" src="../js/jquery.bxSlider.js"></script>
    <link href="../css/ticker-style.css" rel="stylesheet" type="text/css" />
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
<body id="boxed">
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
        
 <div class="boxed-wrapper">

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
                         <?php

                    if(isLoggedIn())

                    { 

                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);

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
<div class="col-md-10">	
<span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br /><br />
									<?php echo getPageContents($page_id);?>	            
</div>
<!-- ad left_sidebar-->

                <div class="col-md-2">	
               <?php include_once('left_sidebar.php'); ?>
              </div>
</div>
</div>

<!--container-->                   <!--  Footer-->
  <footer> 
   <div class="container">
   <div class="row">
   <div class="col-md-12">	
   <?php include_once('footer.php');?>            
  </div>
  </div>
  </div>
  </footer>
  <!--  Footer-->
            <!--default footer end here-->
</div><!--box wrapper end-->
        
        <!--scripts and plugins -->
        <!--must need plugin jquery-->
        <script src="../csswell/js/jquery.min.js"></script>        
        <!--bootstrap js plugin-->
        <script src="../csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
        <!--easing plugin for smooth scroll-->
        <script src="../csswell/js/jquery.easing.1.3.min.js" type="text/javascript"></script>
        <!--sticky header-->
        <script type="text/javascript" src="../csswell/js/jquery.sticky.js"></script>
        <!--flex slider plugin-->
        <script src="../csswell/js/jquery.flexslider-min.js" type="text/javascript"></script>
        <!--parallax background plugin-->
        <script src="../csswell/js/jquery.stellar.min.js" type="text/javascript"></script>
        
        <script src="../csswell/js/jquery.isotope.min.js" type="text/javascript"></script>
        <!--digit countdown plugin-->
        <script src="../csswell/js/waypoints.min.js"></script>
        <!--digit countdown plugin-->
        <script src="../csswell/js/jquery.counterup.min.js" type="text/javascript"></script>
        <!--on scroll animation-->
        <script src="../csswell/js/wow.min.js" type="text/javascript"></script> 
        <!--owl carousel slider-->
        <script src="../csswell/js/owl.carousel.min.js" type="text/javascript"></script>
        <!--popup js-->
        <script src="../csswell/js/jquery.magnific-popup.min.js" type="text/javascript"></script>
        <!--you tube player-->
        <script src="../csswell/js/jquery.mb.YTPlayer.min.js" type="text/javascript"></script>
        
        <script src="../csswell/js/jquery.imagesloaded.min.js" type="text/javascript"></script>
        <!--customizable plugin edit according to your needs-->
        <script src="../csswell/js/custom.js" type="text/javascript"></script>
        <script src="../csswell/js/isotope-custom.js" type="text/javascript"></script>
        <!--revolution slider plugins-->
        <script src="../csswell/rs-plugin/js/jquery.themepunch.tools.min.js" type="text/javascript"></script>
        <script src="../csswell/rs-plugin/js/jquery.themepunch.revolution.min.js" type="text/javascript"></script>
        <script src="../csswell/js/revolution-custom.js" type="text/javascript"></script>

    </body>

</html>