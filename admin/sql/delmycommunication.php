<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.mycommunications.php');
$obj = new My_Communications();
if($obj->deleteMCQuestion($_GET['id']))
{
	$msg = "Question Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=my_communications&msg='.urlencode($msg));	
?>
