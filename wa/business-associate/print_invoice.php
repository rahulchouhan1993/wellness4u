<?php
require_once('../classes/config.php');
require_once('../classes/vendor.php');
$admin_main_menu_id = '18';
$view_action_id = '51';
$edit_action_id = '52';

$obj = new Vendor();
$obj_comm = new commonFunctions();
if(!$obj->isVendorLoggedIn())
{
	header("Location: login.php");
	exit(0);
}
else
{
	$adm_vendor_id = $_SESSION['adm_vendor_id'];
}

if(!$obj->chkIfAccessOfMenu($adm_vendor_id,$admin_main_menu_id))
{
	header("Location: invalid.php");
	exit(0);
}

if(!$obj->chkIfAccessOfMenuAction($adm_vendor_id,$view_action_id))
{
	header("Location: invalid.php");
	exit(0);
}
$error = false;
$err_msg = "";
$msg = '';

if(isset($_GET['invoice']) && $_GET['invoice'] != '')
{
	$invoice = $_GET['invoice'];
	$arr_order_record = $obj->getOrderDetailsByInvoiceAndVendorId($invoice,$adm_vendor_id);
	if(count($arr_order_record) == 0)
	{
		header("Location: manage_orders.php");
		exit(0);
	}
	
}	
else
{
	header("Location: manage_orders.php");
	exit(0);
}	
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo SITE_NAME;?> - Admin</title>
	<?php //require_once 'head.php'; ?>
</head>
<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">
<?php //include_once('header.php');?>
					<?php echo $obj_comm->getOrderInvoiceHtmlVendor($invoice,$adm_vendor_id);?>
					<div style="width:800px;text-align:center;margin:0 auto;">
						<button onclick="javascript:window.print();" class="no-print btn btn-primary rounded" type="button" name="btnSubmit" id="btnSubmit">Print</button>&nbsp;
						<button onclick="javascript:window.location.href='view_order.php?invoice=<?php echo $invoice;?>'" class="no-print btn btn-primary rounded" type="button" name="btnSubmit" id="btnSubmit">Back</button>
					</div>
				
<?php //include_once('footer.php');?>
<!--Common plugins-->
<?php //require_once('script.php'); ?>
</body>
</html>