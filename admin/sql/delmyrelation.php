<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.myrelations.php');
$obj = new My_Relations();
if($obj->deleteMRQuestion($_GET['id']))
{
	$msg = "Question Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=my_relations&msg='.urlencode($msg));	
?>
