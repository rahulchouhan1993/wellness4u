<?php
if(isset($arr_page_details['meta_title']) && $arr_page_details['meta_title'] != '')
{
	$meta_title = $arr_page_details['meta_title'];
}
else
{
	$meta_title = SITE_NAME;
}

if(isset($arr_page_details['meta_keywords']) && $arr_page_details['meta_keywords'] != '')
{
	$meta_keywords = $arr_page_details['meta_keywords'];
}
else
{
	$meta_keywords = SITE_NAME;
}

if(isset($arr_page_details['meta_desc']) && $arr_page_details['meta_desc'] != '')
{
	$meta_desc = $arr_page_details['meta_desc'];
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
<title><?php echo $meta_title;?></title>

<link rel="icon" href="<?php echo SITE_URL;?>/images/icon.png">
<!-- google font -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> 
<!-- google font -->
<link rel="stylesheet" href="../w_css/bootstrap.min.css">
<link rel="stylesheet" href="../w_css/font-awesome.min.css">
<link rel="stylesheet" href="../w_css/animated.css" media="all">
<link rel="stylesheet" href="../w_css/slick.css" media="all">
<link rel="stylesheet" href="../w_css/jquery-ui.css" media="all">
<link rel="stylesheet" href="../w_css/style.css?v=<?php echo time();?>">
<link rel="stylesheet" href="../w_css/responsive.css">
<link rel="stylesheet" href="../w_css/tokenize2.css" />
