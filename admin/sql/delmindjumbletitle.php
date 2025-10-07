<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.mindjumble.php');  
$obj = new Mindjumble();
if($obj->DeleteMindjumbleTitle($_GET['uid']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}

header('location: ../index.php?mode=title&msg='.urlencode($msg));	
?>