<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.profilecustomization.php');
$obj = new ProfileCustomization();
if($obj->deleteProfileCustomization($_GET['id']))
{
    $msg = "Record Deleted Successfully!";
}
else
{
    $msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=profile_customization&msg='.urlencode($msg));	
?>
