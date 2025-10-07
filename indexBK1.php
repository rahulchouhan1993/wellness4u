<?php

include('config.php');

$page_id = '1';

list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu,$page_contents2) = getPageDetails($page_id);



if(isLoggedIn())

{

    doUpdateOnline($_SESSION['user_id']);

}

                

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
          
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="description" content="<?php echo $meta_description;?>" />

    <meta name="keywords" content="<?php echo $meta_keywords;?>" />

    <meta name="title" content="<?php echo $meta_title;?>" />

    <meta name="google-site-verification" content="M-9MeSzvayNDYYJthEOtAprlWIb9tynp_ByMNRX6MNs" /> 

    <title><?php echo $meta_title;?></title>

    <link href="cwri.css" rel="stylesheet" type="text/css" />
 <link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">       <link href="csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />
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

			

            $('#slider1').bxSlider();

            $('#slider2').bxSlider();

            $('#slider3').bxSlider();

            $('#slider4').bxSlider();

            $('#slider5').bxSlider();

            $('#slider6').bxSlider();



            $('#slider_main1').bxSlider();

            $('#slider_main2').bxSlider();

            $('#slider_main3').bxSlider();

            $('#slider_main4').bxSlider();

            $('#slider_main5').bxSlider();

            $('#slider_main6').bxSlider();



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
<!--page_contents --> 
<div class="col-md-10">
<?php  echo $page_contents; ?>
  <!-- end page_contents -->           
   </div>
     <!-- ad left_sidebar-->

               <!-- <div class="col-md-2">	
               <?php include_once('left_sidebar.php'); ?>
              </div>-->
               <!-- ad left_sidebar end -->
                <!-- ad right_sidebar-->
               <div class="col-md-2">	
                <?php include_once('right_sidebar.php'); ?></div>
  
 <!-- ad right_sidebar end -->
   </div>
</div>         
  
            
           <!--  Footer-->
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


</html>


