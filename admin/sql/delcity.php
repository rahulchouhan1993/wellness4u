<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.places.php');
$obj = new Places();
if($obj->deleteCity($_GET['id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=cities&msg='.urlencode($msg));	
?>
