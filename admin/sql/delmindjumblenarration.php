<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.mindjumble.php');  
$obj = new Mindjumble();

$title_id = $_GET['uid'];
echo $title_id;
if($obj->DeleteMindjumbleNarration($_GET['id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}

header('location: ../index.php?mode=narration&uid='.$title_id.'&msg='.urlencode($msg));	
?>