<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.banner.php');
$obj = new Banner();
if($obj->DeleteBanner($_GET['banner_id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}
if(isset($_GET['ad']) && $_GET['ad'] == '1')
{		
	header('location: ../index.php?mode=adviser_banners&msg='.urlencode($msg));	
}
else
{
	header('location: ../index.php?mode=banner&msg='.urlencode($msg));		
}
?>
