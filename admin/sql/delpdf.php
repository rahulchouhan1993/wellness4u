<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.stressbuster.php');  
$obj = new Stressbuster();
if($obj->DeletePDF($_GET['uid']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=manage_pdf&msg='.urlencode($msg));	
?>
