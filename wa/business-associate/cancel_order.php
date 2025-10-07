<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '18';
$view_action_id = '51';
$edit_action_id = '88';

$obj = new Admin();
$obj_comm = new commonFunctions();
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

if(!$obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
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
	$arr_order_record = $obj->getOrderDetailsByInvoice($invoice);
	if(count($arr_order_record) == 0)
	{
		header("Location: manage_orders.php");
		exit(0);
	}
	
	if(isset($_GET['ocid']) && $_GET['ocid'] != '')
	{
		$ocid = $_GET['ocid'];
		$arr_order_cart_record = $obj->getOrderCartDetailsByInvoiceAndOrderCartId($invoice,$ocid);
		if(count($arr_order_cart_record) == 0)
		{
			header("Location: manage_orders.php");
			exit(0);
		}
		else
		{
			if($arr_order_cart_record['cancel_request_sent'] == '1')
			{
				$error = true;
				$error_msg = '<p class="err_msg">Cancel request already sent for this item</p>';
			}
			else
			{
				/*
				if(!$obj->chkIfItemCaneBeCancelled($arr_order_cart_record['invoice'],$arr_order_cart_record['prod_id'],$arr_order_cart_record['order_cart_delivery_date']))
				{
					$error = true;
					$error_msg = '<p class="err_msg">This item cannot be cancelled now.</p>';
				}
				*/
			}	
		}
	}	
	else
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

$cancel_comments = '';
$cancel_parent_cat_id = '218';
$cancel_cat_id = '';
$cancel_cat_other = '';
$show_cancel_cat_other = 'none';
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo SITE_NAME;?> - Admin</title>
	<?php require_once 'head.php'; ?>
	<link href="assets/css/tokenize2.css" rel="stylesheet" />
</head>
<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">
<?php include_once('header.php');?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="panel">
				<div class="panel-body">
					<div class="row mail-header">
						<div class="col-md-6">
							<h3><?php echo $obj->getAdminActionName($edit_action_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="cancel_order" name="cancel_order" method="post"> 
						<input type="hidden" name="hdninvoice" id="hdninvoice" value="<?php echo $invoice;?>" >
						<input type="hidden" name="hdnocid" id="hdnocid" value="<?php echo $ocid;?>" >
						<p style="margin-top: 40px;">Invoice No - <?php echo $invoice;?></p>
						<p style="margin-top: 20px;">Item - <?php echo $arr_order_cart_record['prod_name'];?></p>
						<p style="margin-top: 20px;">Delivery Date - <?php echo date('d/m/Y',strtotime($arr_order_cart_record['order_cart_delivery_date']));?></p>	
						<div class="form-group">
							<label class="col-lg-2 control-label">Cancel Reason Type<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cancel_cat_id" id="cancel_cat_id" class="form-control" onchange="toggleCancelCategoryOther()">
									<?php echo $obj->getCancelReasonCategoryOption($cancel_parent_cat_id,$cancel_cat_id); ?>	
								</select>
							</div>	
							<div class="col-md-6">
								<div id="show_cancel_cat_other" style="display:<?php echo $show_cancel_cat_other?>;">
									<label>Others Reason</label><br>
									<input type="text"  name="cancel_cat_other" id="cancel_cat_other" placeholder="Enter here" value="<?php echo $cancel_cat_other;?>" class="form-control" >
								</div>	
							</div>
						</div>
						<div class="form-group" >
							<label class="col-lg-2 control-label">Any Additional Information</label>
							<div class="col-lg-10">
								<textarea name="cancel_comments" id="cancel_comments" class="form-control"><?php echo $cancel_comments;?></textarea>
							</div>	
						</div>	
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="view_order.php?invoice=<?php echo $invoice;?>"><button type="button" class="btn btn-danger rounded">Back</button></a>
								</div>
							</div>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
</div>
<?php include_once('footer.php');?>
<!--Common plugins-->
<?php require_once('script.php'); ?>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script src="admin-js/cancel-order-validator.js" type="text/javascript"></script>
</body>
</html>