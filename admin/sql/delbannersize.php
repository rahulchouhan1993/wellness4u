<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.banner.php');
$obj = new Banner();
if($obj->deleteBannerSizeMaster($_GET['id']))
{
    $msg = "Record Deleted Successfully!";
}
else
{
    $msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=banner_size_master&msg='.urlencode($msg));	
?>
