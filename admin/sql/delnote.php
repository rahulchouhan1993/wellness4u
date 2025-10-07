<?php
ob_start();
require('../config/class.mysql.php');
require('../classes/class.library.php');   
$obj = new Library();
if($obj->Deletelibrarynote($_GET['uid']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=library&msg='.urlencode($msg));	
?>