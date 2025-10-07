<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.angervent.php');  
$angervent = new Angervent();
if($angervent->DeleteAngerVentMusic($_GET['uid']))
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
		$mode = 'angervent_user_uploads';
	}
	else
	{
		$mode = 'manage_anger_vent_bk_music';
	}		
header('location: ../index.php?mode='.$mode.'&msg='.urlencode($msg));	
?>