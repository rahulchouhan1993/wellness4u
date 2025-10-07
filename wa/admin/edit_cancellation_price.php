<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '7';
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

$cp_qty_parent_id = 147;

$show_cp_amount = 'none';
$show_cp_percentage = 'none';
$show_cp_cancellation_amount = 'none';
$show_cp_min_qty_id = 'none';
$show_cp_max_qty_id = 'none';

if(isset($_GET['token']) && $_GET['token'] != '')
{
	$cp_id = base64_decode($_GET['token']);
	$arr_record = $obj->getCancellationPriceDetails($cp_id);
	if(count($arr_record) == 0)
	{
		header("Location: manage_cancellation_prices.php");
		exit(0);
	}
	
	$cp_title = $arr_record['cp_title'];
	$cancellation_price = $arr_record['cancellation_price'];
	$min_cancellation_amount = $arr_record['min_cancellation_amount']; 
	$max_cancellation_amount = $arr_record['max_cancellation_amount']; 
	$cp_type = $arr_record['cp_type']; 
	$cp_percentage = $arr_record['cp_percentage']; 
	$cp_min_qty_id = $arr_record['cp_min_qty_id']; 
	$cp_min_qty_val = $arr_record['cp_min_qty_val']; 
	$cp_max_qty_id = $arr_record['cp_max_qty_id']; 
	$cp_max_qty_val = $arr_record['cp_max_qty_val']; 
	$cp_applied_on = $arr_record['cp_applied_on']; 
	$cp_effective_date = $arr_record['cp_effective_date']; 
	$cp_comments = $arr_record['cp_comments']; 
	$cp_min_hrs = $arr_record['cp_min_hrs']; 
	$cp_max_hrs = $arr_record['cp_max_hrs']; 
	
	$cp_effective_date = date('d-m-Y',strtotime($cp_effective_date));
	
	$cp_status = $arr_record['cp_status'];
	
	if($cp_type == '0')
	{
		$show_cp_amount = '';
		$show_cp_percentage = 'none';
		$show_cp_min_qty_id = 'none';
		$show_cp_max_qty_id = 'none';
		$show_cp_cancellation_amount = '';
	}
	elseif($cp_type == '1')
	{
		$show_cp_amount = 'none';
		$show_cp_percentage = '';
		$show_cp_min_qty_id = 'none';
		$show_cp_max_qty_id = 'none';
		$show_cp_cancellation_amount = '';
	}
	elseif($cp_type == '2')
	{
		$show_cp_amount = '';
		$show_cp_percentage = 'none';
		$show_cp_min_qty_id = '';
		$show_cp_max_qty_id = '';
		$show_cp_cancellation_amount = 'none';
	}
}	
else
{
	header("Location: manage_cancellation_prices.php");
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
					<form role="form" class="form-horizontal" id="edit_cancellation_price" name="edit_cancellation_price" method="post"> 
						<input type="hidden" name="hdncp_id" id="hdncp_id" value="<?php echo $cp_id;?>" >
						<div class="form-group">
							<label class="col-lg-2 control-label">Cancellation Title<span style="color:red">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="cp_title" id="cp_title" value="<?php echo $cp_title;?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Cancellation Type<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cp_type" id="cp_type" onchange="showHideCancellationQtyDropdowns(); getCancellationAppliedOnOption('1');" class="form-control" required>
									<?php echo $obj->getCancellationTypeOption($cp_type); ?>
								</select>
							</div>
						</div>	
						<div class="form-group">
							<label class="col-lg-2 control-label">Min Cancellation Hrs <span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cp_min_hrs" id="cp_min_hrs" class="form-control" required>
									<?php echo $obj->getCancellationCutOffTimeOption($cp_min_hrs); ?>
								</select>
							</div>
							<label class="col-lg-2 control-label">Max Cancellation Hrs<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cp_max_hrs" id="cp_max_hrs" class="form-control" required>
									<?php echo $obj->getCancellationCutOffTimeOption($cp_max_hrs); ?>
								</select>
							</div>
						</div>	
						<div class="form-group" id="show_cp_amount" style="display:<?php echo $show_cp_amount;?>">
							<label class="col-lg-2 control-label">Cancellation Price<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="cancellation_price" id="cancellation_price" value="<?php echo $cancellation_price?>" class="form-control">
							</div>
						</div>
						<div class="form-group" id="show_cp_percentage" style="display:<?php echo $show_cp_percentage;?>">
							<label class="col-lg-2 control-label">Cancellation Percentage<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="cp_percentage" name="cp_percentage" value="<?php echo $cp_percentage;?>" class="form-control">
							</div>
						</div>
						<div class="form-group" id="show_cp_cancellation_amount" style="display:<?php echo $show_cp_cancellation_amount;?>">
							<label class="col-lg-2 control-label">Min Cancellation Amount<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="min_cancellation_amount" id="min_cancellation_amount" value="<?php echo $min_cancellation_amount?>" class="form-control">
							</div>
							
							<label class="col-lg-2 control-label">Max Cancellation Amount<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="max_cancellation_amount" id="max_cancellation_amount" value="<?php echo $max_cancellation_amount?>" class="form-control">
							</div>
						</div>
						
						<div class="form-group" id="show_cp_min_qty_id" style="display:<?php echo $show_cp_min_qty_id;?>">
							<label class="col-lg-2 control-label">Min Cancellation Quantity <span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="cp_min_qty_val" name="cp_min_qty_val" value="<?php echo $cp_min_qty_val;?>" class="form-control">
							</div>
							<label class="col-lg-2 control-label">Min Cancellation Quantity Unit<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cp_min_qty_id" id="cp_min_qty_id" class="form-control">
									<?php echo $obj->getMainCategoryOption($cp_qty_parent_id,$cp_min_qty_id); ?>
								</select>
							</div>
						</div>	
						<div class="form-group" id="show_cp_max_qty_id" style="display:<?php echo $show_cp_max_qty_id;?>">
							<label class="col-lg-2 control-label">Max Cancellation Quantity <span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="cp_max_qty_val" name="cp_max_qty_val" value="<?php echo $cp_max_qty_val;?>" class="form-control">
							</div>
							<label class="col-lg-2 control-label">Max Cancellation Quantity Unit<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cp_max_qty_id" id="cp_max_qty_id" class="form-control">
									<?php echo $obj->getMainCategoryOption($cp_qty_parent_id,$cp_max_qty_id); ?>
								</select>
							</div>
						</div>	
						<div class="form-group" >
							<label class="col-lg-2 control-label">Cancellation Applied On<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cp_applied_on" id="cp_applied_on" class="form-control" required>
									<?php echo $obj->getCancellationAppliedOnOption($cp_type,$cp_applied_on); ?>
								</select>
							</div>		
						</div>		
						<div class="form-group" >
							<label class="col-lg-2 control-label">Effective Date<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="cp_effective_date" name="cp_effective_date" value="<?php echo $cp_effective_date;?>" class="form-control"  required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="cp_status" id="cp_status" class="form-control">
									<option value="1" <?php if($cp_status == '1'){?> selected <?php } ?>>Active</option> 
									<option value="0" <?php if($cp_status == '0'){?> selected <?php } ?>>Inactive</option> 
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Comments</label>
							<div class="col-lg-10">
								<textarea id="cp_comments" name="cp_comments" class="form-control"><?php echo $cp_comments?></textarea>
							</div>
						</div>	
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_cancellation_prices.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/edit-cancellation-price-validator.js" type="text/javascript"></script>
<script>
$(document).ready(function()
{
	$('#cp_effective_date').datepicker();
});
</script>
</body>
</html>