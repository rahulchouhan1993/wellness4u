<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.slidercontents.php');
$obj = new Slider_Contents();
if($obj->deleteParentsSliderContents($_GET['id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=sliders&msg='.urlencode($msg));	
?>
