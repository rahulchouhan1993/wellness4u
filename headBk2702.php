<?php
if(isset($page_data['meta_title']) && $page_data['meta_title'] != '')
{
	$meta_title = $page_data['meta_title'];
}
else
{
	$meta_title = SITE_NAME;
}

if(isset($page_data['meta_keywords']) && $page_data['meta_keywords'] != '')
{
	$meta_keywords = $page_data['meta_keywords'];
}
else
{
	$meta_keywords = SITE_NAME;
}

if(isset($page_data['meta_desc']) && $page_data['meta_desc'] != '')
{
	$meta_desc = $page_data['meta_desc'];
}
else
{
	$meta_desc = SITE_NAME;
}
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $meta_desc; ?>" />
<meta name="keywords" content="<?php echo $meta_keywords; ?>" />
<meta name="title" content="<?php echo $meta_title; ?>" />
<link rel="canonical"https://www.wellnessway4u.com/" />
<title><?php echo $meta_title;?></title>

<link rel="icon" href="images/cwri_logo.png" sizes="16x16">
<!-- google font -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> 
<!-- google font -->
<link rel="stylesheet" href="w_css/bootstrap.min.css">
<link rel="stylesheet" href="w_css/font-awesome.min.css">
<link rel="stylesheet" href="w_css/animated.css" media="all">
<link rel="stylesheet" href="w_css/slick.css" media="all">
<link rel="stylesheet" href="w_css/jquery-ui.css" media="all">
<link rel="stylesheet" href="w_css/style.css?v=<?php echo time();?>">
<link rel="stylesheet" href="w_css/responsive.css">
<link rel="stylesheet" href="w_css/tokenize2.css" />


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



            $(".QTPopup").css('display','none');

            $(".feedback").click(function(){
                
                alert('hiiiii');
                
                $(".QTPopup").animate({width: 'show'}, 'slow');

            });	

            $(".closeBtn").click(function(){			

                $(".QTPopup").css('display', 'none');

            });

        });

    </script>