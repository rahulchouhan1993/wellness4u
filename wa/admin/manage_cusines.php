<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '27';
$view_action_id = '106';
$add_action_id = '107';
$edit_action_id = '108';
$delete_action_id = '109';

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

$txtsearch= '';
$cucat_parent_cat_id = '';
$cucat_cat_id = '';
$vendor_id = '';
$added_by_admin = '';
$added_days_of_month = '';
$added_days_of_week = '';
$added_single_date = '';
$added_start_date = '';
$added_end_date = '';

$country_id = '';
$state_id = '';
$city_id = '';
$area_id = '';
$delivery_date = '';

$added_show_days_of_month = 'none';
$added_show_days_of_week = 'none';
$added_show_single_date = 'none';
$added_show_start_date = 'none';
$added_show_end_date = 'none';
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo SITE_NAME;?> - Admin</title>
	<?php require_once 'head.php'; ?>
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
				if($obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
				{ ?>
					<a href="<?php echo $obj->getAdminActionLink($add_action_id);?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $obj->getAdminActionName($add_action_id);?>" data-original-title=""><i class="fa fa-plus"></i></a>
				<?php
				} ?>	
				</div>
				<div class="space-30"></div>
				<?php
				if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
				{ ?>
				<div class="search-panel">
					<div class="row" >
						<div class="col-sm-4"><strong>Search:</strong>&nbsp;<br>
							<input type="text" id="txtsearch" name="txtsearch" class="form-control" value="<?php echo $txtsearch;?>" >
						</div>
						<div class="col-sm-4"><strong>Main Profile:</strong>&nbsp;<br>
							<select name="cucat_parent_cat_id" id="cucat_parent_cat_id" class="form-control" onchange="getMainCategoryOptionCommon('cucat','2');" required  >
								<?php echo $obj->getMainProfileOption($cucat_parent_cat_id,'2');?>
							</select>
						</div>
						<div class="col-sm-4"><strong>Category:</strong>&nbsp;<br>
							<select name="cucat_cat_id" id="cucat_cat_id" class="form-control" required>
								<?php echo $obj->getMainCategoryOption($cucat_parent_cat_id,$cucat_cat_id,'2'); ?>
							</select>
						</div>
					</div>
					<div class="row" >
						<div class="col-sm-4"><strong>Vendor:</strong>&nbsp;<br>
							<select name="vendor_id" id="vendor_id" class="form-control" required>
								<?php echo $obj->getVendorOption($vendor_id,'2'); ?>
							</select>
						</div>
						<div class="col-sm-4"><strong>Added By Admin:</strong>&nbsp;<br>
							<select name="added_by_admin" id="added_by_admin" class="form-control" required>
								<?php echo $obj->getAdminsOption($added_by_admin,'2'); ?>
							</select>
						</div>
						<div class="col-sm-4"><strong>Status:</strong>&nbsp;<br>
							<select name="status" id="status" class="form-control">
								<option value="" >All</option>
								<option value="1">Active</option>
								<option value="0">Inactive</option>
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
						<div class="col-lg-4">
							<strong>Added Date Type:</strong>&nbsp;<br>
							<select name="added_date_type" id="added_date_type" onchange="showHideDateDropdowns('added')" class="form-control" required>
								<?php echo $obj->getDateTypeOption($added_date_type); ?>
							</select>
						</div>
						<div class="col-lg-4">
							<div id="added_show_days_of_month" style="display:<?php echo $added_show_days_of_month;?>">
								<strong>Days of Month:</strong>&nbsp;<br>
								<select name="added_days_of_month" id="added_days_of_month" class="form-control">
									<?php echo $obj->getDaysOfMonthOption($added_days_of_month,'2'); ?>
								</select>
							</div>	
							<div id="added_show_days_of_week" style="display:<?php echo $added_show_days_of_week;?>">
								<strong>Days of Week:</strong>&nbsp;<br>
								<select name="added_days_of_week" id="added_days_of_week" class="form-control">
									<?php echo $obj->getDaysOfWeekOption($added_days_of_week,'2'); ?>
								</select>
							</div>	
							<div id="added_show_single_date" style="display:<?php echo $added_show_single_date;?>">
								<strong>Single Date:</strong>&nbsp;<br>
								<input type="text" name="added_single_date" id="added_single_date" placeholder="Select Date" class="form-control" required >
							</div>	
							<div id="added_show_start_date" style="display:<?php echo $added_show_start_date;?>">
								<strong>Start Date:</strong>&nbsp;<br>
								<input type="text" name="added_start_date" id="added_start_date" placeholder="Select Start Date" class="form-control" required >  
							</div>	
						</div>
						<div class="col-lg-4">
							<div id="added_show_end_date" style="display:<?php echo $added_show_end_date;?>">
								<strong>End Date:</strong>&nbsp;<br>
								<input type="text" name="added_end_date" id="added_end_date" placeholder="Select End Date" class="form-control" required > 
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3"><strong>Delivery Date:</strong>&nbsp;<br>
							<input type="text" id="delivery_date" name="delivery_date" value="<?php echo $delivery_date;?>" class="form-control"  >
						</div>
						<div class="col-sm-3">
							<input type="button" id="btnsearch" name="btnsearch" value="Search" class="btn btn-primary btn-search" onclick="refineSearch();">
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
					<div id="cusineslist"></div>
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
<script>

	
$(document).ready(function()
{ 
	$('#added_single_date').datepicker();
	$('#added_start_date').datepicker();
	$('#added_end_date').datepicker();
	$('#delivery_date').datepicker();
	<?php
	if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
	{ ?>
    var dataString ='action=cusineslist';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			$("#cusineslist").html(result);
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
	var cucat_parent_cat_id = $("#cucat_parent_cat_id").val();
	var cucat_cat_id = $("#cucat_cat_id").val();
	var vendor_id = $("#vendor_id").val();
	var added_by_admin = $("#added_by_admin").val();
	var added_date_type = $("#added_date_type").val();
	var added_days_of_month = $("#added_days_of_month").val();
	var added_days_of_week = $("#added_days_of_week").val();
	var added_single_date = $("#added_single_date").val();
	var added_start_date = $("#added_start_date").val();
	var added_end_date = $("#added_end_date").val();
	var country_id = $("#country_id").val();
	var state_id = $("#state_id").val();
	var city_id = $("#city_id").val();
	var area_id = $("#area_id").val();
	var delivery_date = $("#delivery_date").val();
	
	var dataString ='page_id='+page_id +'&txtsearch='+escape(txtsearch)+'&status='+status+'&cucat_parent_cat_id='+cucat_parent_cat_id+'&cucat_cat_id='+cucat_cat_id+'&vendor_id='+vendor_id+'&added_by_admin='+escape(added_by_admin)+'&added_date_type='+escape(added_date_type)+'&added_days_of_month='+escape(added_days_of_month)+'&added_days_of_week='+escape(added_days_of_week)+'&added_single_date='+escape(added_single_date)+'&added_start_date='+escape(added_start_date)+'&added_end_date='+escape(added_end_date)+'&country_id='+escape(country_id)+'&state_id='+escape(state_id)+'&city_id='+escape(city_id)+'&area_id='+escape(area_id)+'&delivery_date='+escape(delivery_date)+'&action=cusineslist';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			$(".se-pre-con ").hide();
			$("#cusineslist").html(result);
		}
	});
} 

function refineSearch()  
{
	var txtsearch = $("#txtsearch").val();
	var status = $("#status").val();
	var cucat_parent_cat_id = $("#cucat_parent_cat_id").val();
	var cucat_cat_id = $("#cucat_cat_id").val();
	var vendor_id = $("#vendor_id").val();
	var added_by_admin = $("#added_by_admin").val();
	var added_date_type = $("#added_date_type").val();
	var added_days_of_month = $("#added_days_of_month").val();
	var added_days_of_week = $("#added_days_of_week").val();
	var added_single_date = $("#added_single_date").val();
	var added_start_date = $("#added_start_date").val();
	var added_end_date = $("#added_end_date").val();
	var country_id = $("#country_id").val();
	var state_id = $("#state_id").val();
	var city_id = $("#city_id").val();
	var area_id = $("#area_id").val();
	var delivery_date = $("#delivery_date").val();
	
	var dataString ='txtsearch='+escape(txtsearch)+'&status='+status+'&cucat_parent_cat_id='+cucat_parent_cat_id+'&cucat_cat_id='+cucat_cat_id+'&vendor_id='+vendor_id+'&added_by_admin='+escape(added_by_admin)+'&added_date_type='+escape(added_date_type)+'&added_days_of_month='+escape(added_days_of_month)+'&added_days_of_week='+escape(added_days_of_week)+'&added_single_date='+escape(added_single_date)+'&added_start_date='+escape(added_start_date)+'&added_end_date='+escape(added_end_date)+'&country_id='+escape(country_id)+'&state_id='+escape(state_id)+'&city_id='+escape(city_id)+'&area_id='+escape(area_id)+'&delivery_date='+escape(delivery_date)+'&action=cusineslist';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			$(".se-pre-con ").hide();
			$("#cusineslist").html(result);
		}
	});
} 
<?php
} ?>

<?php
if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))
{ ?>	
function deletemultiplecusines()
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
		var r = confirm("Are you sure to delete this record?");
		if (r == true) 
		{
			var dataString ='chkbox_records='+chkbox_records+'&action=deletemultiplecusines';
			$.ajax({
				type: "POST",
				url: "ajax/remote.php",
				data: dataString,
				cache: false,      
				success: function(result)
				{
					var JSONObject = JSON.parse(result);
					var rslt=JSONObject[0]['status'];
						
					if(rslt==1)
					{
						window.location.href="manage_cusines.php";  
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
}

<?php
} ?>
</script>
</body>
</html>