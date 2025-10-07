<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.solutions.php');
$obj = new Solutions();
if($obj->deleteSolutionItem($_GET['id']))
{
    $msg = "Record Deleted Successfully!";
}
else
{
    $msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?page='.$_GET['page'].'&mode=wellness_solution_items&msg='.urlencode($msg));	
?>
