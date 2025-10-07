<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.contents.php');
$obj = new Contents();
if($obj->deleteDataDropdown($_GET['id']))
{
    $msg = "Record Deleted Successfully!";
    
}
else
{
    $msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=manage-data-dropdown&msg='.urlencode($msg));	
?>
