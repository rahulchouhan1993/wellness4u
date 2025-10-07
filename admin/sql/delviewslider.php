<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.slidercontents.php');
$obj = new Slider_Contents();

$pid = $_GET['pid'];


if($obj->deleteViewSliderContents($_GET['id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=view_sliders&msg='.urlencode($msg).'&uid='.$pid.'');	
?>
