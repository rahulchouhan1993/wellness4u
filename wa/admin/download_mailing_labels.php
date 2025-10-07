<?php
ob_start();
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '28';
$edit_action_id = '90';

$obj = new Admin();
$obj2 = new commonFunctions();
if(!$obj->isAdminLoggedIn())
{
	header("Location: login.php");
	exit(0);
}
else
{
	$admin_id = $_SESSION['admin_id'];
}

if(!$obj->chkIfAccessOfMenu($admin_id,$admin_main_menu_id))
{
	header("Location: invalid.php");
	exit(0);
}

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{
	header("Location: invalid.php");
	exit(0);
}

if(isset($_GET['runo']) && $_GET['runo'] != '')
{
	$random_unique_no = $_GET['runo'];
	$output = $obj->getMailingLabelsPdfContents($random_unique_no);
			
	$filename = 'tos_mailing_labels_'.date('dmYHis');
	include_once('../classes/class.htmltopsmaker.php');
	ob_clean();
	convert_to_pdf($filename,$output);
	exit(0);
}