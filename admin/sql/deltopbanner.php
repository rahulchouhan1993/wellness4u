<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.topbanner.php');
$obj = new Banner();
if($obj->DeleteBanner($_GET['banner_id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=top_banner&msg='.urlencode($msg));	
?>
