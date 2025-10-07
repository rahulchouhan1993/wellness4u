<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '17';
$view_action_id = '47';
$add_action_id = '48';
$edit_action_id = '49';
$delete_action_id = '50';

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
$country_id = '';
$state_id = '';
$city_id = '';
$area_id = '';

$added_by_admin = '';
$added_date_type = '';
$added_days_of_month = '';
$added_days_of_week = '';
$added_single_date = '';
$added_start_date = '';
$added_end_date = '';

$publish_date_type = '';
$publish_days_of_month = '';
$publish_days_of_week = '';
$publish_single_date = '';
$publish_start_date = '';
$publish_end_date = '';

$added_show_days_of_month = 'none';
$added_show_days_of_week = 'none';
$added_show_single_date = 'none';
$added_show_start_date = 'none';
$added_show_end_date = 'none';

$publish_show_days_of_month = 'none';
$publish_show_days_of_week = 'none';
$publish_show_single_date = 'none';
$publish_show_start_date = 'none';
$publish_show_end_date = 'none';

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
						<div class="col-sm-3"><strong>Search:</strong>&nbsp;<br>
							<input type="text" id="txtsearch" name="txtsearch" value="<?php echo $txtsearch;?>" class="form-control"  >
						</div>
						<div class="col-lg-3">
							<strong>Publish Date Type:</strong>&nbsp;<br>
							<select name="publish_date_type" id="publish_date_type" onchange="showHideDateDropdowns('publish')" class="form-control" required>
								<?php echo $obj->getDateTypeOption($publish_date_type); ?>
							</select>
						</div>
						<div class="col-lg-3">
							<div id="publish_show_days_of_month" style="display:<?php echo $publish_show_days_of_month;?>">
								<strong>Days of Month:</strong>&nbsp;<br>
								<select name="publish_days_of_month" id="publish_days_of_month" class="form-control">
									<?php echo $obj->getDaysOfMonthOption($publish_days_of_month,'2'); ?>
								</select>
							</div>	
							<div id="publish_show_days_of_week" style="display:<?php echo $publish_show_days_of_week;?>">
								<strong>Days of Week:</strong>&nbsp;<br>
								<select name="publish_days_of_week" id="publish_days_of_week" class="form-control">
									<?php echo $obj->getDaysOfWeekOption($publish_days_of_week,'2'); ?>
								</select>
							</div>	
							<div id="publish_show_single_date" style="display:<?php echo $publish_show_single_date;?>">
								<strong>Single Date:</strong>&nbsp;<br>
								<input type="text" name="publish_single_date" id="publish_single_date" placeholder="Select Date" class="form-control" required >
							</div>	
							<div id="publish_show_start_date" style="display:<?php echo $publish_show_start_date;?>">
								<strong>Start Date:</strong>&nbsp;<br>
								<input type="text" name="publish_start_date" id="publish_start_date" placeholder="Select Start Date" class="form-control" required >  
							</div>	
						</div>
						<div class="col-lg-3">
							<div id="publish_show_end_date" style="display:<?php echo $publish_show_end_date;?>">
								<strong>End Date:</strong>&nbsp;<br>
								<input type="text" name="publish_end_date" id="publish_end_date" placeholder="Select End Date" class="form-control" required > 
							</div>	
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
						<div class="col-lg-3"><strong>Added By Admin:</strong>&nbsp;<br>
							<select name="added_by_admin" id="added_by_admin" class="form-control" required>
								<?php echo $obj->getAdminsOption($added_by_admin,'2'); ?>
							</select>
						</div>
						<div class="col-lg-3">
							<strong>Added Date Type:</strong>&nbsp;<br>
							<select name="added_date_type" id="added_date_type" onchange="showHideDateDropdowns('added')" class="form-control" required>
								<?php echo $obj->getDateTypeOption($added_date_type); ?>
							</select>
						</div>
						<div class="col-lg-3">
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
						<div class="col-lg-3">
							<div id="added_show_end_date" style="display:<?php echo $added_show_end_date;?>">
								<strong>End Date:</strong>&nbsp;<br>
								<input type="text" name="added_end_date" id="added_end_date" placeholder="Select End Date" class="form-control" required > 
							</div>	
						</div>
					</div>
					<div class="row" >
						<div class="col-sm-3"><strong>Status:</strong>&nbsp;<br>
							<select name="status" id="status" class="form-control">
								<option value="" >All</option>
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
						</div>
					</div>
					<div class="row" >	
						
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
					<div id="bannersliderslist"></div>
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
	$('#publish_single_date').datepicker();
	$('#publish_start_date').datepicker();
	$('#publish_end_date').datepicker();
	$('#added_single_date').datepicker();
	$('#added_start_date').datepicker();
	$('#added_end_date').datepicker();
	<?php
	if($obj->chkIfAccessOfMenuAction($admin_id,$view_action_id))
	{ ?>
    var dataString ='action=bannersliderslist';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			$("#bannersliderslist").html(result);
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
	var country_id = $("#country_id").val();
	var state_id = $("#state_id").val();
	var city_id = $("#city_id").val();
	var area_id = $("#area_id").val();
	var added_by_admin = $("#added_by_admin").val();
	var added_date_type = $("#added_date_type").val();
	var added_days_of_month = $("#added_days_of_month").val();
	var added_days_of_week = $("#added_days_of_week").val();
	var added_single_date = $("#added_single_date").val();
	var added_start_date = $("#added_start_date").val();
	var added_end_date = $("#added_end_date").val();
	var publish_date_type = $("#publish_date_type").val();
	var publish_days_of_month = $("#publish_days_of_month").val();
	var publish_days_of_week = $("#publish_days_of_week").val();
	var publish_single_date = $("#publish_single_date").val();
	var publish_start_date = $("#publish_start_date").val();
	var publish_end_date = $("#publish_end_date").val();
	
	var dataString ='page_id='+page_id +'&txtsearch='+escape(txtsearch)+'&status='+status+'&country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&added_by_admin='+escape(added_by_admin)+'&added_date_type='+escape(added_date_type)+'&added_days_of_month='+escape(added_days_of_month)+'&added_days_of_week='+escape(added_days_of_week)+'&added_single_date='+escape(added_single_date)+'&added_start_date='+escape(added_start_date)+'&added_end_date='+escape(added_end_date)+'&publish_date_type='+escape(publish_date_type)+'&publish_days_of_month='+escape(publish_days_of_month)+'&publish_days_of_week='+escape(publish_days_of_week)+'&publish_single_date='+escape(publish_single_date)+'&publish_start_date='+escape(publish_start_date)+'&publish_end_date='+escape(publish_end_date)+'&action=bannersliderslist';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			$(".se-pre-con ").hide();
			$("#bannersliderslist").html(result);
		}
	});
} 

function refineSearch()  
{
	var txtsearch = $("#txtsearch").val();
	var status = $("#status").val();
	var country_id = $("#country_id").val();
	var state_id = $("#state_id").val();
	var city_id = $("#city_id").val();
	var area_id = $("#area_id").val();
	var added_by_admin = $("#added_by_admin").val();
	var added_date_type = $("#added_date_type").val();
	var added_days_of_month = $("#added_days_of_month").val();
	var added_days_of_week = $("#added_days_of_week").val();
	var added_single_date = $("#added_single_date").val();
	var added_start_date = $("#added_start_date").val();
	var added_end_date = $("#added_end_date").val();
	var publish_date_type = $("#publish_date_type").val();
	var publish_days_of_month = $("#publish_days_of_month").val();
	var publish_days_of_week = $("#publish_days_of_week").val();
	var publish_single_date = $("#publish_single_date").val();
	var publish_start_date = $("#publish_start_date").val();
	var publish_end_date = $("#publish_end_date").val();
	
	var dataString ='txtsearch='+escape(txtsearch)+'&status='+status+'&country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&added_by_admin='+escape(added_by_admin)+'&added_date_type='+escape(added_date_type)+'&added_days_of_month='+escape(added_days_of_month)+'&added_days_of_week='+escape(added_days_of_week)+'&added_single_date='+escape(added_single_date)+'&added_start_date='+escape(added_start_date)+'&added_end_date='+escape(added_end_date)+'&publish_date_type='+escape(publish_date_type)+'&publish_days_of_month='+escape(publish_days_of_month)+'&publish_days_of_week='+escape(publish_days_of_week)+'&publish_single_date='+escape(publish_single_date)+'&publish_start_date='+escape(publish_start_date)+'&publish_end_date='+escape(publish_end_date)+'&action=bannersliderslist';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			$(".se-pre-con ").hide();
			$("#bannersliderslist").html(result);
		}
	});
} 
<?php
} ?>

<?php
if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))
{ ?>	
function deletemultiplebannersliders()
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
			var dataString ='chkbox_records='+chkbox_records+'&action=deletemultiplebannersliders';
			
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
						window.location.href="manage_banner_sliders.php";  
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