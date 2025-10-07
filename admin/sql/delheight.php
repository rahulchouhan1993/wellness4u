<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.heights.php');
$obj = new Heights();
if($obj->deleteHeight($_GET['id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=heights&msg='.urlencode($msg));	
?>
