<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.generalstressors.php');
$obj = new General_Stressors();
if($obj->deleteGSQuestion($_GET['id']))
{
	$msg = "Question Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=general_stressors&msg='.urlencode($msg));	
?>
