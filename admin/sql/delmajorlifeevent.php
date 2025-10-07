<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.majorlifeevents.php');
$obj = new Major_Life_Events();
if($obj->deleteMLEQuestion($_GET['id']))
{
	$msg = "Question Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=majorlifeevents&msg='.urlencode($msg));	
?>
