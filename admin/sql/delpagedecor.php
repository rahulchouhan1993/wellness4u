<?php
ob_start();
require('../config/class.mysql.php');
require_once('../classes/class.contents.php');  
$obj = new Contents();
if($obj->deletePageDecor($_GET['id']))
{
	$msg = "Page Decor Data Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=manage-page-decor&msg='.urlencode($msg));	
?>
