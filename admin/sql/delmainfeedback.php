<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.feedback.php');   
$obj = new Feedback();

$id = $_GET['uid'];
$uid = $obj->get_parent_id($id);
if($obj->DeleteMainfeedback($uid))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=feedback&msg='.urlencode($msg));	
?>


