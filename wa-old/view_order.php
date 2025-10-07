<?php
require_once('../classes/config.php');
require_once('../classes/vendor.php');
$admin_main_menu_id = '18';
$view_action_id = '51';
$edit_action_id = '52';
$cancel_action_id = '88';

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


if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$cancel_action_id))
{
	$can_cancel = true;
}
else
{
	$can_cancel = false;
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
	<?php require_once 'head.php'; ?>
	<link href="assets/css/tokenize2.css" rel="stylesheet" />
</head>
<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">
<?php include_once('header.php');?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<div class="row mail-header">
						<div class="col-md-6">
							<h3><?php echo $obj->getAdminActionName($edit_action_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="edit_order" name="edit_order" method="post"> 
						<input type="hidden" name="hdninvoice" id="hdninvoice" value="<?php echo $invoice;?>" >
						<?php
						if($can_cancel)
						{
							echo $obj_comm->getOrderInvoiceHtmlVendor($invoice,$adm_vendor_id,1,1);	
						}
						else
						{
							echo $obj_comm->getOrderInvoiceHtmlVendor($invoice,$adm_vendor_id,0,0);		
						}
						?>
							
						<hr>
						<?php
						//if($obj->chkIfAccessOfMenuAction($adm_vendor_id,$edit_action_id))
						//{ ?>
						<div class="form-group">
							<label class="col-lg-3 control-label">Order Status<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<?php echo $obj->getOrderStatusString($arr_order_record['order_status']); ?>
								<?php
								/*
								<select name="order_status" id="order_status" class="form-control">
									<?php echo $obj->getOrderStatusOption($arr_order_record['order_status']); ?>
								</select>
								*/
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Payment Status<span style="color:red">*</span></label>
							<label class="col-lg-4 control-label" style="text-align:left;"><strong><?php echo $obj->getPaymentStatusString($arr_order_record['payment_status']); ?></strone></label>
							<input type="hidden" name="payment_status" id="payment_status" value="<?php echo $arr_order_record['payment_status'];?>">
							<?php
							/*
							<div class="col-lg-4">
								<select name="payment_status" id="payment_status" class="form-control">
									<?php echo $obj->getPaymentStatusOption($arr_order_record['payment_status']); ?>
								</select>
							</div>
							*/ ?>
						</div>
						<?php
						/*
						if($arr_order_record['payment_status'] == '1')
						{ ?>
						<div class="form-group">
							<label class="col-lg-3 control-label">Payment Gateway Details:</label>
							<div class="col-lg-9">
								<p><strong>EBS TransactionID</strong> : <?php echo $arr_order_record['ebs_trans_id'];?></p>
								<p><strong>EBS PaymentID</strong> : <?php echo $arr_order_record['ebs_payment_id'];?></p>
								<p><strong>EBS ResponseCode</strong> : <?php echo $arr_order_record['ebs_response_code'];?></p>
								<p><strong>EBS ResponseMessage</strong> : <?php echo $arr_order_record['ebs_response_msg'];?></p>
								<p><strong>EBS DateCreated</strong> : <?php echo $arr_order_record['ebs_date'];?></p>
								<p><strong>EBS PaymentMethod</strong> : <?php echo $arr_order_record['ebs_payment_method'];?></p>
								<p><strong>EBS RequestID</strong> : <?php echo $arr_order_record['ebs_request_id'];?></p>
								<p><strong>EBS IsFlagged</strong> : <?php echo $arr_order_record['ebs_is_flagged'];?></p>
							</div>
						</div>
						<?php
						} ?>
						<div class="form-group">
							<label class="col-lg-3 control-label">Order Note<span style="color:red">*</span></label>
							<div class="col-lg-9">
								<textarea name="order_note" id="order_note" class="form-control"><?php echo $arr_order_record['order_note']; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Send email to User<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="send_email_to_user" id="send_email_to_user" class="form-control">
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Update Status</button>
									<a href="print_invoice.php?invoice=<?php echo $invoice;?>"><button type="button" class="btn btn-primary rounded">Print Invoice</button></a>
									<a href="manage_orders.php"><button type="button" class="btn btn-danger rounded">Back</button></a>
								</div>
							</div>
						</div>
						<?php
						*/
						//}
						//else
						//{ ?>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<a href="print_invoice.php?invoice=<?php echo $invoice;?>"><button type="button" class="btn btn-danger rounded">Print Invoice</button></a>
									<a href="manage_orders.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
								</div>
							</div>
						</div>
						<?php	
						//}
						?>
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
<script src="admin-js/view-order-validator.js" type="text/javascript"></script>
</body>
</html>