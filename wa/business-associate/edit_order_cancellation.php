<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '26';
$edit_action_id = '82';

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

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
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
						//echo $obj_comm->getOrderInvoiceHtml($invoice);
						$arr_order_details = $obj_comm->getOrderDetailsByInvoice($invoice);
						?>
						<div class="form-group">
							<label class="col-lg-3 control-label" >Invoice:</label>
							<label class="col-lg-6 control-label" style="text-align:left">
								<?php echo $arr_order_details['invoice']; ?>
							</label>
						</div>	
						<hr>
						<?php
						$arr_order_cart_details = $obj->getCancellationRequestOrderCartDetailsByInvoice($invoice);
						$prod_cancel_subtotal = 0.00;
						if(count($arr_order_cart_details) > 0)
						{ ?>
						<input type="hidden" name="hdntotalitems" id="hdntotalitems" value="<?php echo count($arr_order_cart_details);?>" >
						<div class="table-responsive">
							<table id="datatable" class="table table-hover" >
								<thead>
									<tr>
										<th width="15%">Item</th>
										<th width="25%">Cancellation Reason</th>
										<th width="10%">Delivery Date</th>
										<th width="10%">Cancellation Req Date</th>
										<th width="10%">Subtotal</th>
										<th width="20%">Cancelation method</th>
										<th width="10%">Cancellation Charge</th>
									</tr>
								</thead>
								<tbody>
							<?php
							//for($i=0;$i<count($arr_order_cart_details);$i++)
							$i=0;	
							foreach($arr_order_cart_details as $record)
							{ 
								$cancellation_reason_str = '';
								if($record['cancel_cat_id'] == '221')
								{
									$cancellation_reason_str = 'Other Reason: '.$record['cancel_cat_other'];	
								}
								else
								{
									$cancellation_reason_str = $obj->getCategoryName($record['cancel_cat_id']);
								}
								
								if($record['cancel_comments'] != '')
								{
									$cancellation_reason_str .= '<br><br> Additional information: '.$record['cancel_comments'];	
								}
							?>
									<tr>
										<td><?php echo $record['prod_name'];?></td>
										<td><?php echo $cancellation_reason_str;?></td>
										<td><?php echo date('d-M-Y',strtotime($record['order_cart_delivery_date']));?></td>
										<td><?php echo date('d-M-Y H:i',strtotime($record['cancel_request_date']));?></td>
										<td><?php echo $record['prod_subtotal'];?></td>
										<td>
											<input type="hidden" name="prod_subtotal[]" id="prod_subtotal_<?php echo $i;?>" value="<?php echo $record['prod_subtotal']?>" >
											<input type="hidden" name="order_cart_id[]" id="order_cart_id_<?php echo $i;?>" value="<?php echo $record['order_cart_id']?>" >
											<select name="cp_id[]" id="cp_id_<?php echo $i;?>" class="form-control" onchange="calculateItemCancellationCharge('<?php echo $i;?>')">
												<?php echo $obj->getAppliedCancellationPriceOption($record['cancel_request_date'],$record['order_cart_delivery_date'],$record['cp_id']); ?>
											</select>
										</td>
										<td id="prod_cancel_subtotal_<?php echo $i;?>"><?php echo $record['prod_cancel_subtotal'];?></td>
									</tr>
							<?php
								if($record['prod_cancel_subtotal'] != '')
								{
									$prod_cancel_subtotal += $record['prod_cancel_subtotal'];	
								}
								$i++;	
							} ?>
								</tbody>
							</table>
						</div>
						<?php	
						}
						
						$cp_sp_amount = 0.00;
						if($arr_order_cart_details[0]['cp_sp_amount'] != '')
						{
							$cp_sp_amount = 0.00 + $arr_order_cart_details[0]['cp_sp_amount'];	
						}
						
						$cp_tax_amount = 0.00;
						if($arr_order_cart_details[0]['cp_tax_amount'] != '')
						{
							$cp_tax_amount = 0.00 + $arr_order_cart_details[0]['cp_tax_amount'];	
						}
						
						$final_cancellation_amount = $prod_cancel_subtotal + $cp_sp_amount + $cp_tax_amount;
						?>
						
						<div class="form-group">
							<label class="col-lg-3 control-label">Cancellation Shipping Amount<span style="color:red">*</span></label>
							<div class="col-lg-9">
								<input type="text" name="cp_sp_amount" id="cp_sp_amount" class="form-control" value="<?php echo $arr_order_cart_details[0]['cp_sp_amount']; ?>" onkeyup="calculateFinalCancellationCharge()">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Cancellation Tax Amount<span style="color:red">*</span></label>
							<div class="col-lg-9">
								<input type="text" name="cp_tax_amount" id="cp_tax_amount" class="form-control" value="<?php echo $arr_order_cart_details[0]['cp_tax_amount']; ?>" onkeyup="calculateFinalCancellationCharge()" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Total Cancellation Amount<span style="color:red">*</span></label>
							<div class="col-lg-9" id="total_cancellation_amount">
								<?php echo 'Rs '.$final_cancellation_amount; ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Cancellation Note<span style="color:red">*</span></label>
							<div class="col-lg-9">
								<textarea name="cancellation_note" id="cancellation_note" class="form-control"><?php echo $arr_order_cart_details[0]['cancellation_note']; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="button" onclick="doCancellationOrder();" name="btnSubmit" id="btnSubmit">Apply Cancellation</button>
									<a href="manage_order_cancellations.php"><button type="button" class="btn btn-danger rounded">Back</button></a>
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
</body>
</html>