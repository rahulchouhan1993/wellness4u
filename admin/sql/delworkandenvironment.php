<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.workandenvironment.php');
$obj = new Work_And_Environment();
if($obj->deleteWAEQuestion($_GET['id']))
{
	$msg = "Question Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=work_and_environment&msg='.urlencode($msg));	
?>
