<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.dailyactivity.php');
$obj = new Daily_Activity();
if($obj->deleteDailyActivity($_GET['id']))
{
	$msg = "Activity Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=daily_activity&msg='.urlencode($msg));	
?>
