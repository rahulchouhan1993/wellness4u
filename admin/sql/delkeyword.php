<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.keywords.php');
$obj = new Keywords();
if($obj->deleteKeyword($_GET['id']))
{
    $msg = "Record Deleted Successfully!";
}
else
{
    $msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=keywords_master&msg='.urlencode($msg));	
?>
