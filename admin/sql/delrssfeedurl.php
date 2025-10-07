<?php
session_start();
ob_start();
require('../config/class.mysql.php');
require_once("../classes/class.admin.php");
require('../classes/class.rssfeedparser.php');
$obj = new FeedParser();

$del_action_id = '169';
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


if($obj->deleteRssFeedUrl($_GET['id']))
{
	$msg = "Record Deleted Successfully!";
}
else
{
	$msg = "Currently there is some problem.Please try later";
}		
header('location: ../index.php?mode=rss_feeds&msg='.urlencode($msg));	
?>
