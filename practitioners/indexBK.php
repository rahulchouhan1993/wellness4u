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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $meta_description;?>" />
	<meta name="keywords" content="<?php echo $meta_keywords;?>" />
	<meta name="title" content="<?php echo $meta_title;?>" />
	<title><?php echo $meta_title;?></title>
	<link href="../cwri.css" rel="stylesheet" type="text/css" />
	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="js/commonfn.js"></script>
	<script type="text/javascript" src="js/jquery.bxSlider.js"></script>
    <link href="css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery.ticker.js" type="text/javascript"></script>
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
	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
	<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
	<script type="text/javascript">
		ddsmoothmenu.init({
		mainmenuid: "smoothmenu1", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		//customtheme: ["#1c5a80", "#18374a"],
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
		})
	</script>

<!-- template css -->
      
    <link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- custom css (blue color by default) -->
        <link href="csswell/css/style.css" rel="stylesheet" type="text/css" media="screen">   
        <!-- font awesome for icons -->
        <link href="csswell/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- flex slider css -->
        <link href="csswell/css/flexslider.css" rel="stylesheet" type="text/css" media="screen">
        <!-- animated css  -->
        <link href="csswell/css/animate.css" rel="stylesheet" type="text/css" media="screen">
        <!--Revolution slider css-->
        <link href="csswell/rs-plugin/css/settings.css" rel="stylesheet" type="text/css" media="screen">
        <link href="csswell/css/rev-style.css" rel="stylesheet" type="text/css" media="screen">
        <!--owl carousel css-->
        <link href="csswell/css/owl.carousel.css" rel="stylesheet" type="text/css" media="screen">
        <link href="csswell/css/owl.theme.css" rel="stylesheet" type="text/css" media="screen">
        <!--mega menu -->
        <link href="csswell/css/yamm.css" rel="stylesheet" type="text/css">
        <!--popups css-->
        <link href="csswell/css/magnific-popup.css" rel="stylesheet" type="text/css">
       
    </head>

  <body id="boxed">
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
        
        <div class="boxed-wrapper">
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

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" valign="top">
			<?php include_once('header.php');?>
			<table width="980" border="0" cellspacing="0" cellpadding="0">
				<tr>
                    <td width="980" align="left" valign="top">
						<table width="940" border="0" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="left" valign="top" class="breadcrumb">
                                	<?php echo getBreadcrumbCode($page_id);?>
                                </td>
							</tr>
						</table>  
						<table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" valign="top">
									<span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br /><br />
									<?php echo getPageContents($page_id);?>
								</td>
							</tr>
						</table>
					</td>
					
				</tr>
			</table>            
		</td>
	</tr>
	<tr>
		<td align="center" valign="top" background="images/top_back.jpg" style="background-repeat: repeat-x;">&nbsp;</td>
	</tr>
</table>

 <?php include 'footer.php'; ?>
            <!--default footer end here-->
        </div><!--box wrapper end-->
        
        <!--scripts and plugins -->
        <!--must need plugin jquery-->
        <script src="csswell/js/jquery.min.js"></script>        
        <!--bootstrap js plugin-->
        <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
        <!--easing plugin for smooth scroll-->
        <script src="csswell/js/jquery.easing.1.3.min.js" type="text/javascript"></script>
        <!--sticky header-->
        <script type="text/javascript" src="csswell/js/jquery.sticky.js"></script>
        <!--flex slider plugin-->
        <script src="csswell/js/jquery.flexslider-min.js" type="text/javascript"></script>
        <!--parallax background plugin-->
        <script src="csswell/js/jquery.stellar.min.js" type="text/javascript"></script>
        
        <script src="csswell/js/jquery.isotope.min.js" type="text/javascript"></script>
        <!--digit countdown plugin-->
        <script src="csswell/js/waypoints.min.js"></script>
        <!--digit countdown plugin-->
        <script src="csswell/js/jquery.counterup.min.js" type="text/javascript"></script>
        <!--on scroll animation-->
        <script src="csswell/js/wow.min.js" type="text/javascript"></script> 
        <!--owl carousel slider-->
        <script src="csswell/js/owl.carousel.min.js" type="text/javascript"></script>
        <!--popup js-->
        <script src="csswell/js/jquery.magnific-popup.min.js" type="text/javascript"></script>
        <!--you tube player-->
        <script src="csswell/js/jquery.mb.YTPlayer.min.js" type="text/javascript"></script>
        
        <script src="csswell/js/jquery.imagesloaded.min.js" type="text/javascript"></script>
        <!--customizable plugin edit according to your needs-->
        <script src="csswell/js/custom.js" type="text/javascript"></script>
        <script src="csswell/js/isotope-custom.js" type="text/javascript"></script>
        <!--revolution slider plugins-->
        <script src="csswell/rs-plugin/js/jquery.themepunch.tools.min.js" type="text/javascript"></script>
        <script src="csswell/rs-plugin/js/jquery.themepunch.revolution.min.js" type="text/javascript"></script>
        <script src="csswell/js/revolution-custom.js" type="text/javascript"></script>

    </body>

<!-- Mirrored from www.bootstraplovers.com/templates/assan-v1.9.1/html/home-boxed.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Oct 2015 09:47:43 GMT -->
</html>