<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.sleeps.php');
$obj = new Sleeps();
if($obj->deleteSleepQuestion($_GET['id']))
{
	$msg = "Question Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=sleeps&msg='.urlencode($msg));	
?>
