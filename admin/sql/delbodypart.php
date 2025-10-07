<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.bodyparts.php');
$obj = new BodyParts();
if($obj->deleteBodyPart($_GET['id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=body_parts&msg='.urlencode($msg));	
?>
