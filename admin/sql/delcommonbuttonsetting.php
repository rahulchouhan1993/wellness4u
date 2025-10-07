<?php
ob_start();
require('../config/class.mysql.php');
require_once('../classes/class.contents.php');  
$obj = new Contents();
if($obj->delcommonbuttonsetting($_GET['id']))
{
	$msg = "Common Button Setting Data Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=common-button-setting&msg='.urlencode($msg));	
?>
