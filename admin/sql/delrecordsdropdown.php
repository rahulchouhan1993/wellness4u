<?php
ob_start();
require('../config/class.mysql.php');
require_once('../classes/class.contents.php');  
$obj = new Contents();
if($obj->deleteRecordDropdown($_GET['id']))
{
	$msg = "Report Costomisation Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=report_customisation&msg='.urlencode($msg));	
?>
