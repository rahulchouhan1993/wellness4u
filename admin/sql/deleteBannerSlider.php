<?php
ob_start();
require('../config/class.mysql.php');

require_once('../classes/class.banner.php');  
$obj = new Banner();
if($obj->deleteBannerSlider($_GET['id']))
{
	$msg = "Banner Slider Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=banner_slider&msg='.urlencode($msg));	
?>
