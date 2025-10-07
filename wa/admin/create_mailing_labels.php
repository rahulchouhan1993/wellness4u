<?php
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

$error = false;
$err_msg = "";
$msg = '';

$ml_invoice_list_str = '';
$total_cnt = 0;

if(isset($_SESSION['arr_ml_invoice_list']) && $_SESSION['arr_ml_invoice_list'] != '')
{
	$arr_ml_invoice_list = $_SESSION['arr_ml_invoice_list'];
	$total_cnt = count($arr_ml_invoice_list);
	if(count($arr_ml_invoice_list) == 0)
	{
		header("Location: manage_mailing_labels.php");
		exit(0);
	}
	
	$ml_invoice_list_str = implode(',',$arr_ml_invoice_list);
	
}	
else
{
	header("Location: manage_mailing_labels.php");
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
					<form role="form" class="form-horizontal" id="create_mailing_labels" name="create_mailing_labels" method="post"> 
						<input type="hidden" name="hdnml_invoice_list_str" id="hdnml_invoice_list_str" value="<?php echo $ml_invoice_list_str;?>" >
						<input type="hidden" name="total_cnt" id="total_cnt" value="<?php echo $total_cnt;?>">
						
						<div class="form-group">
							<label class="col-lg-2 control-label">Mailing Labels Layout<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="ml_layout" id="ml_layout" class="form-control" required>
									<?php echo $obj->getMailingLabelLayoutOption(''); ?>
								</select>
							</div>
							
						</div>
						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
							<div class="form-group left-label">
								<label class="col-lg-4 control-label"><strong>Invoice Details:</strong></label>
							</div>
						<?php 
						for($i=0;$i<$total_cnt;$i++)
						{ 
							$arr_order_details = $obj->getOrderDetailsByInvoice($arr_ml_invoice_list[$i]);
							?>
							
							<div id="row_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
								<div class="form-group">
									<label class="col-lg-2 control-label">Invoice No:<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<input type="hidden" name="hdninvoice_no[]" id="hdninvoice_no_<?php echo $i;?>" value="<?php echo $arr_ml_invoice_list[$i];?>">
										<input readonly type="text" name="invoice_no[]" id="invoice_no_<?php echo $i;?>" class="form-control" value="<?php echo $arr_ml_invoice_list[$i];?>" required>
									</div>
									<label class="col-lg-2 control-label">Show Invoice No<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="invoice_no_show[]" id="invoice_no_show_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getShowHideOption('1'); ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label">Invoice Date:<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<input readonly type="text" name="invoice_date[]" id="invoice_date_<?php echo $i;?>" class="form-control" value="<?php echo date('d/M/Y',strtotime($arr_order_details['order_add_date']));?>" required>
									</div>
									<label class="col-lg-2 control-label">Show Invoice Date<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="invoice_date_show[]" id="invoice_date_show_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getShowHideOption('1'); ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label">Delivery Date:<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="delivery_date[]" id="delivery_date_<?php echo $i;?>" class="form-control">
											<?php echo $obj->getOrderAllDeliveryDatesOptionByInvoice($arr_ml_invoice_list[$i],''); ?>
										</select>
									</div>
									<label class="col-lg-2 control-label">Show Delivery Date<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="delivery_date_show[]" id="delivery_date_show_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getShowHideOption('0'); ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label">Seller Type:<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="seller_type[]" id="seller_type_<?php echo $i;?>" class="form-control" required onchange="toggleTOSAndVendorName('<?php echo $i;?>')">
											<?php echo $obj->getSellerTypeOption(''); ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label">Seller Name:<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<input type="text" name="tos_name[]" id="tos_name_<?php echo $i;?>" class="form-control" value="One9 World Enterprises" >
										<select name="vendor_id[]" id="vendor_id_<?php echo $i;?>" class="form-control" style="display:none;" onchange="getVendorLocationOptionMulti('<?php echo $i;?>','1','0','0');">
											<?php echo $obj->getOrderAllVendorsOptionByInvoice($arr_ml_invoice_list[$i],''); ?>
										</select>
									</div>
									<label class="col-lg-2 control-label">Show Seller Name<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="seller_name_show[]" id="seller_name_show_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getShowHideOption('0'); ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label">Seller Address:<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<input type="text" name="tos_address[]" id="tos_address_<?php echo $i;?>" class="form-control" value="A Wing, 2-Nav Santosh,B Cabin Road, Shivaji Nagar, Naupada, Thane - 400602" >
										<select name="vloc_id[]" id="vloc_id_<?php echo $i;?>" class="form-control vloc_box" style="display:none;" required>
											<?php echo $obj->getVendorLocationOption('',''); ?>
										</select>
									</div>
									<label class="col-lg-2 control-label">Show Seller Address<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="seller_address_show[]" id="seller_address_show_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getShowHideOption('0'); ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label">Seller PAN NO:<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<input type="text" name="pan_no[]" id="pan_no_<?php echo $i;?>" class="form-control" value="" >
									</div>
									<label class="col-lg-2 control-label">Show Seller PAN NO<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="pan_no_show[]" id="pan_no_show_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getShowHideOption('0'); ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label">Show Customer Name<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="customer_name_show[]" id="customer_name_show_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getShowHideOption('1'); ?>
										</select>
									</div>
									
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label">Show Customer Billing Address<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="billing_address_show[]" id="billing_address_show_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getShowHideOption('1'); ?>
										</select>
									</div>
									<label class="col-lg-2 control-label">Show Customer Delivery Address<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="delivery_address_show[]" id="delivery_address_show_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getShowHideOption('1'); ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 control-label">Show Customer Email<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="customer_email_show[]" id="customer_email_show_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getShowHideOption('1'); ?>
										</select>
									</div>
									<label class="col-lg-2 control-label">Show Customer Contact Number<span style="color:red">*</span></label>
									<div class="col-lg-4">
										<select name="customer_no_show[]" id="customer_no_show_<?php echo $i;?>" class="form-control" required>
											<?php echo $obj->getShowHideOption('1'); ?>
										</select>
									</div>
								</div>
								<?php
								/*
								<div class="form-group">
									<div class="col-lg-2">
										<a href="javascript:void(0);" onclick="removeRowLocation(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>
									</div>
								</div>
								*/ ?>
							</div>
						<?php 
						} ?>	
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Download PDF</button>
									<a href="manage_mailing_labels.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="js/tokenize2.js"></script>
<script src="admin-js/create-mailing-labels-validator.js" type="text/javascript"></script>
<script>
$(document).ready(function()
{
	
});

function removeRowLocation(idval)
{
	$("#row_loc_"+idval).remove();

	var loc_total_cnt = parseInt($("#loc_total_cnt").val());
	loc_total_cnt = loc_total_cnt - 1;
	$("#loc_total_cnt").val(loc_total_cnt);
}

</script>

</body>
</html>