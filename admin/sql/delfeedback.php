<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.feedback.php');   
$obj = new Feedback();
if($obj->Deletefeedback($_GET['uid']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=feedback&msg='.urlencode($msg));	
?>


