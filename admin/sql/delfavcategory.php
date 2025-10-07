<?php
session_start();
ob_start();
require_once('../config/class.mysql.php');
require_once("../classes/class.admin.php");
require_once('../classes/class.scrollingwindows.php');

$obj = new Scrolling_Windows();

$del_action_id = '161';
$admin_id = $_SESSION['admin_id'];

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$del_action_id))
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}

if($obj->deleteFavCategoryRamakant($_GET['id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?page='.$_GET['page'].'&mode=fav_categories&msg='.urlencode($msg));	
?>