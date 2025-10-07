<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.mindjumble.php');  
$obj = new Mindjumble();
if($obj->DeleteMindjumble($_GET['uid']))
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
		$mode = 'mindjumble_user_upload';
	}
	else
	{
		$mode = 'mindjumble';
	}		
header('location: ../index.php?mode='.$mode.'&msg='.urlencode($msg));	
?>