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

<!-- <link href="css/ticker-style.css" rel="stylesheet" type="text/css" /> -->



<link rel="stylesheet" href="cwri.css" />

<link href="csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />

<!-- <style type="text/css">@import "css/jquery.datepick.css";</style>  -->





<link href="css/jquery.simpleTicker.css" rel="stylesheet">





<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />





<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- <link rel="stylesheet" href="https://cdn.rawgit.com/jackmoore/colorbox/master/example1/colorbox.css"> -->

<link rel="stylesheet" href="css/colorbox.css">



<link rel="stylesheet" href="w_js/datepicker/css/bootstrap-datepicker.css">



	 <link rel="stylesheet" href="admin/css/fastselect.min.css">

	 <script src="w_js/jquery-1.12.4.min.js"></script>

<!-- <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" -->

         <!-- rel = "stylesheet"> -->

  <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->

  <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->

<!--  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous"> -->