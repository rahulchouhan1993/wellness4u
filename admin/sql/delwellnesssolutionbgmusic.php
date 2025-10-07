<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.solutions.php');
$obj = new Solutions();
if($obj->deleteMWSBGMusic($_GET['id']))
{
    $msg = "Record Deleted Successfully!";
}
else
{
    $msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=wellness_solution_bg_music&msg='.urlencode($msg));	
?>
