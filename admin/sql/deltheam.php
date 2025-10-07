<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.theams.php');   
$obj = new Theams();
if($obj->Deletetheam($_GET['uid']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=theams&msg='.urlencode($msg));	
?>


