<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '28';
$view_action_id = '89';
$edit_action_id = '90';

$obj = new Admin();
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

if(isset($_GET['msg']) && $_GET['msg'] != '')
{
	$msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'.urldecode($_GET['msg']).'</strong></div>';
}
else
{
	$msg = '';
}

$_SESSION['arr_ml_invoice_list'] = '';
$txtsearch = '';
$item_id = '';
$vendor_id = '';
$customer_id = '';
$country_id = '';
$state_id = '';
$city_id = '';
$area_id = '';

$status = '';
$payment_status = '';
$added_date_type = '';
$added_days_of_month = '';
$added_days_of_week = '';
$added_single_date = '';
$added_start_date = '';
$added_end_date = '';

$delivery_date_type = '';
$delivery_days_of_month = '';
$delivery_days_of_week = '';
$delivery_single_date = '';
$delivery_start_date = '';
$delivery_end_date = '';

$added_show_days_of_month = 'none';
$added_show_days_of_week = 'none';
$added_show_single_date = 'none';
$added_show_start_date = 'none';
$added_show_end_date = 'none';

$delivery_show_days_of_month = 'none';
$delivery_show_days_of_week = 'none';
$delivery_show_single_date = 'none';
$delivery_show_start_date = 'none';
$delivery_show_end_date = 'none';


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
				<header class="panel-heading">
					<h2 class="panel-title"><?php echo $obj->getAdminMenuName($admin_main_menu_id);?></h2>
				</header>
				<div class="pull-right tooltip-show">
				<?php
				/*if($obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
				{ ?>
					<a href="<?php echo $obj->getAdminActionLink($add_action_id);?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $obj->getAdminActionName($add_action_id);?>" data-original-title=""><i class="fa fa-plus"></i></a>
				<?php
				}*/ ?>	
				</div>
				<div class="space-30"></div>
				<?php
				if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
				{ ?>
				<div class="search-panel">
					<div class="row" >
						<div class="col-sm-3"><strong>Search:</strong>&nbsp;<br>
							<input type="text" id="txtsearch" name="txtsearch" value="<?php echo $txtsearch;?>" class="form-control"  >
						</div>
						<div class="col-lg-3">
							<strong>Item:</strong>&nbsp;<br>
							<select name="item_id" id="item_id" class="form-control">
								<?php echo $obj->getItemOption($item_id,2); ?>
							</select>
						</div>
						<div class="col-lg-3">
							<strong>Vendor:</strong>&nbsp;<br>
							<select name="vendor_id" id="vendor_id" class="form-control" >
								<?php echo $obj->getVendorOption($vendor_id,2); ?>
							</select>
						</div>
						<div class="col-lg-3">
							<strong>User:</strong>&nbsp;<br>
							<select name="customer_id" id="customer_id" class="form-control">
								<?php echo $obj->getUsersOption($customer_id,2); ?>
							</select>
						</div>
					</div>
					<div class="row" >
						<div class="col-sm-3"><strong>Country:</strong>&nbsp;<br>
							<select name="country_id" id="country_id" class="form-control" onchange="getStateOptionCommon('2','2');">
								<?php echo $obj->getCountryOption($country_id,'2'); ?>
							</select>
						</div>
						<div class="col-sm-3"><strong>State:</strong>&nbsp;<br>
							<select name="state_id" id="state_id" class="form-control"  onchange="getCityOptionCommon('2','2');">
								<?php echo $obj->getStateOption($country_id,$state_id,'2'); ?>
							</select>
						</div>
						<div class="col-sm-3"><strong>City:</strong>&nbsp;<br>
							<select name="city_id" id="city_id" class="form-control"  onchange="getAreaOptionCommon('2','2');">
								<?php echo $obj->getCityOption($country_id,$state_id,$city_id,'2'); ?>
							</select>
						</div>
						<div class="col-sm-3"><strong>Area:</strong>&nbsp;<br>
							<select name="area_id" id="area_id" class="form-control">
								<?php echo $obj->getAreaOption($country_id,$state_id,$city_id,$area_id,'2'); ?>
							</select>
						</div>
					</div>	
					<div class="row">
						<div class="col-sm-3"><strong>Order Status:</strong>&nbsp;<br>
							<select name="status" id="status" class="form-control">
								<?php echo $obj->getOrderStatusOption($status,2); ?>
							</select>
						</div>
						<div class="col-sm-3"><strong>Payment Status:</strong>&nbsp;<br>
							<select name="payment_status" id="payment_status" class="form-control">
								<?php echo $obj->getPaymentStatusOption($payment_status,2); ?>
							</select>
						</div>
						<div class="col-lg-3">
							<strong>Order Date:</strong>&nbsp;<br>
							<input type="text" name="order_date" id="order_date" placeholder="Select Order Date" class="form-control"  >  
						</div>
						<div class="col-lg-3">
							<strong>Delivery Date:</strong>&nbsp;<br>
							<input type="text" name="delivery_date" id="delivery_date" placeholder="Select Delivery Date" class="form-control" >
						</div>
					</div>
					<div class="row" >	
						<div class="col-sm-3">
							<input type="button" id="btnsearch" name="btnsearch" value="View Mailing Orders List" class="btn btn-primary btn-search" onclick="refineSearch();">
						</div>
					</div>
				</div>
				<?php
				} ?> 
				<div class="panel-body">
					<div class="se-pre-con"></div>
					<?php
					if($msg != '')
					{ ?>
						<?php echo $msg;?>
					<?php
					} ?>  
					
					<?php
					if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
					{ ?>
					<div id="mailingorderslist"></div>
					<?php
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('footer.php');?>
<!--Common plugins-->
<?php require_once('script.php'); ?>
<script src="js/tokenize2.js"></script>
<script>

	
$(document).ready(function()
{ 
	$('#order_date').datepicker();
	$('#delivery_date').datepicker();
	<?php
	if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
	{ ?>
    var dataString ='action=mailingorderslist';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#mailingorderslist").html(result);
		}
	});
	<?php
	} ?>
}); 
	
<?php
if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
{ ?>
function change_page(page_id)  
{
	var txtsearch = $("#txtsearch").val();
	var status = $("#status").val();
	var payment_status = $("#payment_status").val();
	var item_id = $("#item_id").val();
	var vendor_id = $("#vendor_id").val();
	var customer_id = $("#customer_id").val();
	var country_id = $("#country_id").val();
	var state_id = $("#state_id").val();
	var city_id = $("#city_id").val();
	var area_id = $("#area_id").val();
	var order_date = $("#order_date").val();
	var delivery_date = $("#delivery_date").val();
	
	var dataString ='page_id='+page_id +'&txtsearch='+escape(txtsearch)+'&status='+status+'&payment_status='+payment_status+'&item_id='+item_id+'&vendor_id='+vendor_id+'&customer_id='+customer_id+'&country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&order_date='+escape(order_date)+'&delivery_date='+escape(delivery_date)+'&action=mailingorderslist';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			$(".se-pre-con ").hide();
			$("#mailingorderslist").html(result);
		}
	});
} 

function refineSearch()  
{
	var txtsearch = $("#txtsearch").val();
	var status = $("#status").val();
	var payment_status = $("#payment_status").val();
	var item_id = $("#item_id").val();
	var vendor_id = $("#vendor_id").val();
	var customer_id = $("#customer_id").val();
	var country_id = $("#country_id").val();
	var state_id = $("#state_id").val();
	var city_id = $("#city_id").val();
	var area_id = $("#area_id").val();
	var order_date = $("#order_date").val();
	var delivery_date = $("#delivery_date").val();
	
	var dataString ='txtsearch='+escape(txtsearch)+'&status='+status+'&payment_status='+payment_status+'&item_id='+item_id+'&vendor_id='+vendor_id+'&customer_id='+customer_id+'&country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&order_date='+escape(order_date)+'&delivery_date='+escape(delivery_date)+'&action=mailingorderslist';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			$(".se-pre-con ").hide();
			$("#mailingorderslist").html(result);
		}
	});
} 
<?php
} ?>

<?php

if($obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{ ?>	
function createMailingLabelList()
{
	
	var favorite = [];
	var chkbox_records = "";
	$.each($("input[name='chkbox_records[]']:checked"), function(){            
		favorite.push($(this).val());
	});
	chkbox_records = favorite.join(",");
	if(chkbox_records == "")
	{
		BootstrapDialog.show({
			title: 'Error' +" "+" "+'Response',
			message:"Please select any record"
		}); 
	}
	else
	{
		var dataString ='chkbox_records='+chkbox_records+'&action=createmailinglabellist';
		
		$.ajax({
			type: "POST",
			url: "ajax/remote.php",
			data: dataString,
			cache: false,     
			
			success: function(result)
			{
				//alert(result);		
				var JSONObject = JSON.parse(result);
				var rslt=JSONObject[0]['status'];
					
				if(rslt==1)
				{
					window.location.href="create_mailing_labels.php";  
				}
				else
				{
					BootstrapDialog.show({
						title: 'Error' +" "+" "+'Response',
						message:JSONObject[0]['msg']
					}); 
				}
			}
		});  
	}
}

<?php
}  ?>
</script>
</body>
</html>