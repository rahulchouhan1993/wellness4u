<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.stressbuster.php');  
$obj = new Stressbuster();
if($obj->DeleteStressBusterBox($_GET['uid']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}
$user_uploads = $_GET['user_uploads'];

if($user_uploads == '1')
	{
		$mode = 'manage_user_uploads';
	}
	else
	{
		$mode = 'stressbuster';
	}		
header('location: ../index.php?mode='.$mode.'&msg='.urlencode($msg));	
?>
