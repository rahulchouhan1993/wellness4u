<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.comment.php');   
$obj = new Comment();
if($obj->DeleteComment($_GET['uid']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=comments&msg='.urlencode($msg));	
?>


