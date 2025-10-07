<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.bodyparts.php');
$obj = new BodyParts();
if($obj->deleteMainSymptomRamakant($_GET['id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?page='.$_GET['page'].'&mode=main_symptoms&msg='.urlencode($msg));	
?>
