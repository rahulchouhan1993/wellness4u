<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.theams.php');   
$obj = new Theams();
if($obj->DeleteIconsVivek($_GET['id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=icons&msg='.urlencode($msg));	
?>


