<?php
require_once('../classes/config.php');
require_once('../classes/vendor.php');
$admin_main_menu_id = '27';
$add_action_id = '85';

$obj = new Vendor();
$obj2 = new commonFunctions();
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

if(!$obj->chkIfAccessOfMenuAction($adm_vendor_id,$add_action_id))
{
	header("Location: invalid.php");
	exit(0);
}


$error = false;
$err_msg = "";
$msg = '';

$discount_coupon = '';
$discount_price = '';
$min_order_amount = '';
$max_order_amount = '';

$dc_type = '';
$dc_percentage = '';
$dc_qty_parent_id = 147;
$dc_min_qty_id = '';
$dc_min_qty_val = '';
$dc_max_qty_id = '';
$dc_max_qty_val = '';
$dc_applied_on = '';


$dc_effective_date_type = '';
$arr_dc_effective_days_of_month = array('-1');
$arr_dc_effective_days_of_week = array('-1');
$dc_effective_single_date = '';
$dc_effective_start_date = '';
$dc_effective_end_date = '';

$dc_effective_show_days_of_month = 'none';
$dc_effective_show_days_of_week = 'none';
$dc_effective_show_single_date = 'none';
$dc_effective_show_start_date = 'none';
$dc_effective_show_end_date = 'none';

$dc_comments = '';
$dc_multiuser = '';
$dc_trade_discount = '0';



$arr_country_id = array('-1');
$arr_state_id = array('-1');
$arr_city_id = array('-1');
$arr_area_id = array('-1');

$show_dc_amount = 'none';
$show_dc_percentage = 'none';
$show_dc_order_amount = 'none';
$show_dc_min_qty_id = 'none';
$show_dc_max_qty_id = 'none';

?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo SITE_NAME;?> - Business Associates</title>
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
							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="add_discount_coupon" name="add_discount_coupon" method="post" > 
						<div class="form-group">
							<label class="col-lg-2 control-label">Discount Coupon<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="discount_coupon" id="discount_coupon" value="<?php echo $discount_coupon?>" class="form-control">
							</div>	
							<div class="col-lg-4">
								<button class="btn btn-primary" type="button" name="btnGenerateDiscountCoupon" id="btnGenerateDiscountCoupon" onclick="generateDiscountCoupon()">Generate Coupon</button>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Discount Type<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="dc_type" id="dc_type" onchange="showHideDiscountCouponQtyDropdowns(); getDiscountCouponAppliedOnOption('1');" class="form-control" required>
									<?php echo $obj->getDiscountCouponTypeOption($dc_type); ?>
								</select>
							</div>
						</div>	
						<div class="form-group" id="show_dc_amount" style="display:<?php echo $show_dc_amount;?>">
							<label class="col-lg-2 control-label">Discount Price<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="discount_price" id="discount_price" value="<?php echo $discount_price?>" class="form-control">
							</div>
						</div>
						<div class="form-group" id="show_dc_percentage" style="display:<?php echo $show_dc_percentage;?>">
							<label class="col-lg-2 control-label">Discount Percentage<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="dc_percentage" name="dc_percentage" value="<?php echo $dc_percentage;?>" class="form-control">
							</div>
						</div>
						<div class="form-group" id="show_dc_order_amount" style="display:<?php echo $show_dc_order_amount;?>">
							<label class="col-lg-2 control-label">Min Order Amount<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="min_order_amount" id="min_order_amount" value="<?php echo $min_order_amount?>" class="form-control">
							</div>
							
							<label class="col-lg-2 control-label">Max Order Amount<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="max_order_amount" id="max_order_amount" value="<?php echo $max_order_amount?>" class="form-control">
							</div>
						</div>
						
						<div class="form-group" id="show_dc_min_qty_id" style="display:<?php echo $show_dc_min_qty_id;?>">
							<label class="col-lg-2 control-label">Min Quantity <span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="dc_min_qty_val" name="dc_min_qty_val" value="<?php echo $dc_min_qty_val;?>" class="form-control">
							</div>
							<label class="col-lg-2 control-label">Min Quantity Unit<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="dc_min_qty_id" id="dc_min_qty_id" class="form-control">
									<?php echo $obj->getMainCategoryOption($dc_qty_parent_id,$dc_min_qty_id); ?>
								</select>
							</div>
						</div>	
						<div class="form-group" id="show_dc_max_qty_id" style="display:<?php echo $show_dc_max_qty_id;?>">
							<label class="col-lg-2 control-label">Max Quantity <span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="dc_max_qty_val" name="dc_max_qty_val" value="<?php echo $dc_max_qty_val;?>" class="form-control">
							</div>
							<label class="col-lg-2 control-label">Max Quantity Unit<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="dc_max_qty_id" id="dc_max_qty_id" class="form-control">
									<?php echo $obj->getMainCategoryOption($dc_qty_parent_id,$dc_max_qty_id); ?>
								</select>
							</div>
						</div>	
						<div class="form-group" >
							<label class="col-lg-2 control-label">Discount Applied On<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="dc_applied_on" id="dc_applied_on" class="form-control" required>
									<?php echo $obj->getDiscountCouponAppliedOnOption($dc_type,$dc_applied_on); ?>
								</select>
							</div>		
						</div>		
						<div class="form-group">
							<label class="col-lg-2 control-label">Effective Date<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="dc_effective_date_type" id="dc_effective_date_type" onchange="showHideDateDropdowns('dc_effective')" class="form-control" required>
									<?php echo $obj->getDateTypeOption($dc_effective_date_type); ?>
								</select>
							</div>
							<div class="col-lg-3">
								<div id="dc_effective_show_days_of_month" style="display:<?php echo $dc_effective_show_days_of_month;?>">
									<select name="dc_effective_days_of_month" id="dc_effective_days_of_month" multiple="multiple" class="form-control">
										<?php echo $obj->getDaysOfMonthOption($arr_dc_effective_days_of_month,'2','1'); ?>
									</select>
								</div>	
								<div id="dc_effective_show_days_of_week" style="display:<?php echo $dc_effective_show_days_of_week;?>">
									<select name="dc_effective_days_of_week" id="dc_effective_days_of_week" multiple="multiple" class="form-control">
										<?php echo $obj->getDaysOfWeekOption($arr_dc_effective_days_of_week,'2','1'); ?>
									</select>
								</div>	
								<div id="dc_effective_show_single_date" style="display:<?php echo $dc_effective_show_single_date;?>">
									<input type="text" name="dc_effective_single_date" id="dc_effective_single_date" value="<?php echo $dc_effective_single_date;?>" placeholder="Select Date" class="form-control">
								</div>	
								<div id="dc_effective_show_start_date" style="display:<?php echo $dc_effective_show_start_date;?>">
									<input type="text" name="dc_effective_start_date" id="dc_effective_start_date" value="<?php echo $dc_effective_start_date;?>" placeholder="Select Start Date" class="form-control">  
								</div>	
							</div>
							<div class="col-lg-3">
								<div id="dc_effective_show_end_date" style="display:<?php echo $dc_effective_show_end_date;?>">
									<input type="text" name="dc_effective_end_date" id="dc_effective_end_date" value="<?php echo $dc_effective_end_date;?>" placeholder="Select End Date" class="form-control"> 
								</div>	
							</div>
						</div>
						
						<div class="form-group" >
							<label class="col-lg-2 control-label">Multi User Redeamed<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="dc_multiuser" id="dc_multiuser" class="form-control" required>
									<?php echo $obj->getMultiUserRedeamedOption($dc_multiuser); ?>
								</select>
							</div>		
						</div>		
						<?php
						/*
						<div class="form-group" >
							<label class="col-lg-2 control-label">Is Trade Discount?<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="dc_trade_discount" id="dc_trade_discount" class="form-control">
									<?php echo $obj->getMultiUserRedeamedOption($dc_trade_discount); ?>
								</select>
							</div>		
						</div>		
						*/
						?>
						<input type="hidden" name="dc_trade_discount" id="dc_trade_discount" value="<?php echo $dc_trade_discount;?>">
						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
							<div class="form-group left-label">
								<label class="col-lg-4 control-label"><strong>Discount Coupon Location Details:</strong></label>
							</div>	
							<div class="form-group" >	
								<div class="col-sm-3"><strong>Country:</strong>&nbsp;<br>
									<select name="country_id" id="country_id" multiple="multiple" class="form-control" required>
										<?php echo $obj->getCountryOption($arr_country_id,'2','1'); ?>
									</select>
								</div>
								<div class="col-sm-3"><strong>State:</strong>&nbsp;<br>
									<select name="state_id" id="state_id" multiple="multiple" class="form-control" required>
										<?php echo $obj->getStateOption($arr_country_id,$arr_state_id,'2','1'); ?>
									</select>
								</div>
								<div class="col-sm-3"><strong>City:</strong>&nbsp;<br>
									<select name="city_id" id="city_id" multiple="multiple" class="form-control" required>
										<?php echo $obj->getCityOption($arr_country_id,$arr_state_id,$arr_city_id,'2','1'); ?>
									</select>
								</div>
								<div class="col-sm-3"><strong>Area:</strong>&nbsp;<br>
									<select name="area_id" id="area_id" multiple="multiple" class="form-control" required>
										<?php echo $obj->getAreaOption($arr_country_id,$arr_state_id,$arr_city_id,$arr_area_id,'2','1'); ?>
									</select>
								</div>
							</div>
						</div>	
						<div class="form-group">
							<label class="col-lg-2 control-label">Comments</label>
							<div class="col-lg-10">
								<textarea id="dc_comments" name="dc_comments" class="form-control"><?php echo $dc_comments?></textarea>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
                                                                         <button class="btn btn-success rounded" type="button" style="display: none" id="loader"><img src="assets/img/fancybox_loading.gif" > processing..</button>
									<a href="manage_discount_coupons.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/add-discount-coupon-validator.js" type="text/javascript"></script>
<script>
$(document).ready(function()
{ 
	$('#dc_effective_single_date').datepicker();
	$('#dc_effective_start_date').datepicker();
	$('#dc_effective_end_date').datepicker();
	function getStateOption()
	{
		var country_id = $('#country_id').val();
		var state_id = $('#state_id').val();
		
		if(country_id == null)
		{
			country_id = '-1';
		}
		
		if(state_id == null)
		{
			state_id = '-1';
		}
		
		
		var dataString ='country_id='+country_id+'&state_id='+state_id+'&type=2&multiple=1&action=getstateoption';
		$.ajax({
			type: "POST",
			url: "ajax/remote.php",
			data: dataString,
			cache: false,      
			success: function(result)
			{
				$("#state_id").html(result);
				getCityOption();
			}
		});
	}
	
	function getCityOption()
	{
		var country_id = $('#country_id').val();
		var state_id = $('#state_id').val();
		var city_id = $('#city_id').val();
		
		if(country_id == null)
		{
			country_id = '-1';
		}
				
		if(state_id == null)
		{
			state_id = '-1';
		}
		
		if(city_id == null)
		{
			city_id = '-1';
		}
		
		var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&type=2&multiple=1&action=getcityoption';
		$.ajax({
			type: "POST",
			url: "ajax/remote.php",
			data: dataString,
			cache: false,      
			success: function(result)
			{
				$("#city_id").html(result);
				getAreaOption();
			}
		});
	}
	
	function getAreaOption()
	{
		var country_id = $('#country_id').val();
		var state_id = $('#state_id').val();
		var city_id = $('#city_id').val();
		var area_id = $('#area_id').val();
		
		if(country_id == null)
		{
			country_id = '-1';
		}
				
		if(state_id == null)
		{
			state_id = '-1';
		}
		
		if(city_id == null)
		{
			city_id = '-1';
		}
		
		if(area_id == null)
		{
			area_id = '-1';
		}
		
		var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&type=2&multiple=1&action=getareaoption';
		$.ajax({
			type: "POST",
			url: "ajax/remote.php",
			data: dataString,
			cache: false,      
			success: function(result)
			{
				$("#area_id").html(result);
			}
		});
	}
		
	$('#country_id').on('change', function() {
		getStateOption();
	});
	
	$('#state_id').on('change', function() {
		getCityOption();
	});
	
	$('#city_id').on('change', function() {
		getAreaOption();
	});
		
});
</script>
</body>
</html>