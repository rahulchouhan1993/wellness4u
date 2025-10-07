<?php
ob_start();
include_once('../config/class.mysql.php');
include_once('../classes/class.angervent.php');
include_once('../classes/class.admin.php');

$angervent = new Angervent();

if($angervent->DeleteAngervent($_GET['uid']))
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
		$mode = 'angervent_user_upload';
	}
	else
	{
		$mode = 'angervent';
	}		
header('location: ../index.php?mode='.$mode.'&msg='.urlencode($msg));	
?>