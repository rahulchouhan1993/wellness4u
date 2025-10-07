<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.dailymeals.php');
$obj = new Daily_Meals();
//if($obj->deleteDailyMealOld($_GET['id']))
if($obj->deleteDailyMeal($_GET['id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=daily_meals&msg='.urlencode($msg));	
?>
