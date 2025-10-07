<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '6';
$add_action_id = '94';

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

if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
{
	header("Location: invalid.php");
	exit(0);
}


$error = false;
$err_msg = "";
$msg = '';

$tax_name = '';
$tax_parent_cat_id = 230;
$tax_cat_id = '';
$tax_type = '';
$tax_amount = '';
$tax_percentage = '';
$tax_qty_parent_id = 147;
$tax_qty_id = '';
$tax_qty_val = '';
$tax_applied_on = '';
$tax_effective_date = '';
$tax_comments = '';

$arr_country_id = array('-1');
$arr_state_id = array('-1');
$arr_city_id = array('-1');
$arr_area_id = array('-1');

$show_tax_amount = 'none';
$show_tax_percentage = 'none';
$show_tax_qty_id = 'none';

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
							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="add_tax" name="add_tax" method="post" > 
						<div class="form-group">
							<label class="col-lg-2 control-label">Tax Name<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="tax_name" id="tax_name" value="<?php echo $tax_name?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Tax Category<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="hidden" name="tax_parent_cat_id" id="tax_parent_cat_id" value="<?php echo $tax_parent_cat_id;?>" >
								<select name="tax_cat_id" id="tax_cat_id" class="form-control" required>
									<?php echo $obj->getMainCategoryOption($tax_parent_cat_id,$tax_cat_id); ?>
								</select>
							</div>
						</div>	
						<div class="form-group">
							<label class="col-lg-2 control-label">Tax Type<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="tax_type" id="tax_type" onchange="showHideTaxQtyDropdowns()" class="form-control" required>
									<?php echo $obj->getTaxTypeOption($tax_type); ?>
								</select>
							</div>
						</div>	
						<div class="form-group" id="show_tax_amount" style="display:<?php echo $show_tax_amount;?>">
							<label class="col-lg-2 control-label">Tax Amount<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="tax_amount" name="tax_amount" value="<?php echo $tax_amount;?>" class="form-control">
							</div>
						</div>
						<div class="form-group" id="show_tax_percentage" style="display:<?php echo $show_tax_percentage;?>">
							<label class="col-lg-2 control-label">Tax Percentage<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="tax_percentage" name="tax_percentage" value="<?php echo $tax_percentage;?>" class="form-control">
							</div>
						</div>
						<div class="form-group" id="show_tax_qty_id" style="display:<?php echo $show_tax_qty_id;?>">
							<label class="col-lg-2 control-label">Tax Quantity <span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="tax_qty_val" name="tax_qty_val" value="<?php echo $tax_qty_val;?>" class="form-control">
							</div>
							<label class="col-lg-2 control-label">Tax Quantity Unit<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="tax_qty_id" id="tax_qty_id" class="form-control">
									<?php echo $obj->getMainCategoryOption($tax_qty_parent_id,$tax_qty_id); ?>
								</select>
							</div>
						</div>	
						<div class="form-group" >
							<label class="col-lg-2 control-label">Tax Applied On<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="tax_applied_on" id="tax_applied_on" class="form-control" required>
									<?php echo $obj->getTaxAppliedOnOption($tax_applied_on); ?>
								</select>
							</div>		
						</div>		
						<div class="form-group" >
							<label class="col-lg-2 control-label">Effective Date<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" id="tax_effective_date" name="tax_effective_date" value="<?php echo $tax_effective_date;?>" class="form-control"  required>
							</div>
						</div>
						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
							<div class="form-group left-label">
								<label class="col-lg-4 control-label"><strong>Tax Location Details:</strong></label>
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
								<textarea id="tax_comments" name="tax_comments" class="form-control"><?php echo $tax_comments?></textarea>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_taxes.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/add-tax-validator.js" type="text/javascript"></script>
<script>
$(document).ready(function()
{ 
	$('#tax_effective_date').datepicker();
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