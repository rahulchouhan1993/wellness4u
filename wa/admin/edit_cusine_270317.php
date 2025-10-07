<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '15';
$edit_action_id = '41';

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

$publish_show_days_of_month = 'none';
$publish_show_days_of_week = 'none';
$publish_show_single_date = 'none';
$publish_show_start_date = 'none';
$publish_show_end_date = 'none';
$delivery_show_days_of_month = 'none';
$delivery_show_days_of_week = 'none';
$delivery_show_single_date = 'none';
$delivery_show_start_date = 'none';
$delivery_show_end_date = 'none';

if(isset($_GET['token']) && $_GET['token'] != '')
{
	$cusine_id = base64_decode($_GET['token']);
	$arr_record = $obj->getCusineDetails($cusine_id);
	if(count($arr_record) == 0)
	{
		header("Location: manage_cusines.php");
		exit(0);
	}
	
	$item_id = $arr_record['item_id'];
	$cusine_image = $arr_record['cusine_image'];
	$vendor_id = $arr_record['vendor_id']; 
	
	
	$vloc_id = $arr_record['vloc_id'];
	if($vloc_id == '-1' || $vloc_id == '')
	{
		$arr_vloc_id = array('-1');	
	}
	else
	{
		$arr_vloc_id = explode(',',$vloc_id);	
	}
	
	$currency_id = $arr_record['currency_id']; 
	$cusine_price = $arr_record['cusine_price']; 
	$cusine_qty = $arr_record['cusine_qty']; 
	$serving_type_id = $arr_record['serving_type_id']; 
	$serving_size = $arr_record['serving_size']; 
	
	$arr_cat_record = $obj->getCusineAllCategory($cusine_id);
	$arr_cucat_parent_cat_id = array();
	$arr_cucat_cat_id = array();
	$arr_cucat_show = array();
	if(count($arr_cat_record)>0)
	{
		for($i=0;$i<count($arr_cat_record);$i++)
		{
			array_push($arr_cucat_parent_cat_id, $arr_cat_record[$i]['cucat_parent_cat_id']);
			array_push($arr_cucat_cat_id, $arr_cat_record[$i]['cucat_cat_id']);
			array_push($arr_cucat_show, $arr_cat_record[$i]['cucat_show']);
		}
		$cat_total_cnt = count($arr_cat_record);
		$cat_cnt = $cat_total_cnt - 1;
		
	}
	else
	{
		$cat_cnt = 0;
		$cat_total_cnt = 1;
		$arr_cucat_parent_cat_id = array('');
		$arr_cucat_cat_id = array('');
		$arr_cucat_show = array('');	
	}
	
	
	$cusine_country_id = $arr_record['cusine_country_id'];
	if($cusine_country_id == '-1' || $cusine_country_id == '')
	{
		$arr_country_id = array('-1');	
	}
	else
	{
		$arr_country_id = explode(',',$cusine_country_id);	
	}
	
	$cusine_state_id = $arr_record['cusine_state_id'];
	if($cusine_state_id == '-1' || $cusine_state_id == '')
	{
		$arr_state_id = array('-1');	
	}
	else
	{
		$arr_state_id = explode(',',$cusine_state_id);	
	}
	
	$cusine_city_id = $arr_record['cusine_city_id'];
	if($cusine_city_id == '-1' || $cusine_city_id == '')
	{
		$arr_city_id = array('-1');	
	}
	else
	{
		$arr_city_id = explode(',',$cusine_city_id);	
	}
	
	$cusine_area_id = $arr_record['cusine_area_id'];
	if($cusine_area_id == '-1' || $cusine_area_id == '')
	{
		$arr_area_id = array('-1');	
	}
	else
	{
		$arr_area_id = explode(',',$cusine_area_id);	
	}
	
	$cusine_status = $arr_record['cusine_status'];
	
	$publish_date_type = $arr_record['publish_date_type'];
	$publish_days_of_month = $arr_record['publish_days_of_month'];
	$publish_days_of_week = $arr_record['publish_days_of_week'];
	$publish_single_date = $arr_record['publish_single_date'];
	$publish_start_date = $arr_record['publish_start_date'];
	$publish_end_date = $arr_record['publish_end_date'];
	
	$delivery_date_type = $arr_record['delivery_date_type'];
	$delivery_days_of_month = $arr_record['delivery_days_of_month'];
	$delivery_days_of_week = $arr_record['delivery_days_of_week'];
	$delivery_single_date = $arr_record['delivery_single_date'];
	$delivery_start_date = $arr_record['delivery_start_date'];
	$delivery_end_date = $arr_record['delivery_end_date'];
	
	$cusine_desc_1 = $arr_record['cusine_desc_1'];
	$cusine_desc_show_1 = $arr_record['cusine_desc_show_1'];
	$cusine_desc_2 = $arr_record['cusine_desc_2'];
	$cusine_desc_show_2 = $arr_record['cusine_desc_show_2'];
	
	if($publish_date_type == 'days_of_month')
	{
		if($publish_days_of_month == '-1' || $publish_days_of_month == '')
		{
			$arr_publish_days_of_month = array('-1');	
		}
		else
		{
			$arr_publish_days_of_month = explode(',',$publish_days_of_month);	
		}
		
		$arr_publish_days_of_week = array('-1');
		$publish_single_date = '';
		$publish_start_date = '';
		$publish_end_date = '';	
		
		$publish_show_days_of_month = '';
		$publish_show_days_of_week = 'none';
		$publish_show_single_date = 'none';
		$publish_show_start_date = 'none';
		$publish_show_end_date = 'none';
	}
	elseif($publish_date_type == 'days_of_week')
	{
		if($publish_days_of_week == '-1' || $publish_days_of_week == '')
		{
			$arr_publish_days_of_week = array('-1');	
		}
		else
		{
			$arr_publish_days_of_week = explode(',',$publish_days_of_week);	
		}
		
		$arr_publish_days_of_month = array('-1');
		$publish_single_date = '';
		$publish_start_date = '';
		$publish_end_date = '';	
		
		$publish_show_days_of_month = 'none';
		$publish_show_days_of_week = '';
		$publish_show_single_date = 'none';
		$publish_show_start_date = 'none';
		$publish_show_end_date = 'none';
	}
	elseif($publish_date_type == 'single_date')
	{
		$publish_single_date = date('d-m-Y',strtotime($publish_single_date));
		
		$arr_publish_days_of_month = array('-1');
		$arr_publish_days_of_week = array('-1');
		$publish_start_date = '';
		$publish_end_date = '';	
		
		$publish_show_days_of_month = 'none';
		$publish_show_days_of_week = 'none';
		$publish_show_single_date = '';
		$publish_show_start_date = 'none';
		$publish_show_end_date = 'none';
	}
	elseif($publish_date_type == 'date_range')
	{
		$publish_start_date = date('d-m-Y',strtotime($publish_start_date));
		$publish_end_date = date('d-m-Y',strtotime($publish_end_date));
		
		$arr_publish_days_of_month = array('-1');
		$arr_publish_days_of_week = array('-1');
		$publish_single_date = '';
		
		$publish_show_days_of_month = 'none';
		$publish_show_days_of_week = 'none';
		$publish_show_single_date = 'none';
		$publish_show_start_date = '';
		$publish_show_end_date = '';
	}
	else
	{
		$arr_publish_days_of_month = array('-1');
		$arr_publish_days_of_week = array('-1');
		$publish_single_date = '';
		$publish_start_date = '';
		$publish_end_date = '';	
		
		$publish_show_days_of_month = 'none';
		$publish_show_days_of_week = 'none';
		$publish_show_single_date = 'none';
		$publish_show_start_date = 'none';
		$publish_show_end_date = 'none';
	}
	
	if($delivery_date_type == 'days_of_month')
	{
		if($delivery_days_of_month == '-1' || $delivery_days_of_month == '')
		{
			$arr_delivery_days_of_month = array('-1');	
		}
		else
		{
			$arr_delivery_days_of_month = explode(',',$delivery_days_of_month);	
		}
		
		$arr_delivery_days_of_week = array('-1');
		$delivery_single_date = '';
		$delivery_start_date = '';
		$delivery_end_date = '';	
		
		$delivery_show_days_of_month = '';
		$delivery_show_days_of_week = 'none';
		$delivery_show_single_date = 'none';
		$delivery_show_start_date = 'none';
		$delivery_show_end_date = 'none';
	}
	elseif($delivery_date_type == 'days_of_week')
	{
		if($delivery_days_of_week == '-1' || $delivery_days_of_week == '')
		{
			$arr_delivery_days_of_week = array('-1');	
		}
		else
		{
			$arr_delivery_days_of_week = explode(',',$delivery_days_of_week);	
		}
		
		$arr_delivery_days_of_month = array('-1');
		$delivery_single_date = '';
		$delivery_start_date = '';
		$delivery_end_date = '';	
		
		$delivery_show_days_of_month = 'none';
		$delivery_show_days_of_week = '';
		$delivery_show_single_date = 'none';
		$delivery_show_start_date = 'none';
		$delivery_show_end_date = 'none';
	}
	elseif($delivery_date_type == 'single_date')
	{
		$delivery_single_date = date('d-m-Y',strtotime($delivery_single_date));
		
		$arr_delivery_days_of_month = array('-1');
		$arr_delivery_days_of_week = array('-1');
		$delivery_start_date = '';
		$delivery_end_date = '';	
		
		$delivery_show_days_of_month = 'none';
		$delivery_show_days_of_week = 'none';
		$delivery_show_single_date = '';
		$delivery_show_start_date = 'none';
		$delivery_show_end_date = 'none';
	}
	elseif($delivery_date_type == 'date_range')
	{
		$delivery_start_date = date('d-m-Y',strtotime($delivery_start_date));
		$delivery_end_date = date('d-m-Y',strtotime($delivery_end_date));
		
		$arr_delivery_days_of_month = array('-1');
		$arr_delivery_days_of_week = array('-1');
		$delivery_single_date = '';
		
		$delivery_show_days_of_month = 'none';
		$delivery_show_days_of_week = 'none';
		$delivery_show_single_date = 'none';
		$delivery_show_start_date = '';
		$delivery_show_end_date = '';
	}
	else
	{
		$arr_delivery_days_of_month = array('-1');
		$arr_delivery_days_of_week = array('-1');
		$delivery_single_date = '';
		$delivery_start_date = '';
		$delivery_end_date = '';	
		
		$delivery_show_days_of_month = 'none';
		$delivery_show_days_of_week = 'none';
		$delivery_show_single_date = 'none';
		$delivery_show_start_date = 'none';
		$delivery_show_end_date = 'none';
	}

}	
else
{
	header("Location: manage_cusines.php");
	exit(0);
}	

$add_more_row_cat_str = '<div class="form-group" id="row_cat_\'+cat_cnt+\'"><label class="col-lg-2 control-label"></label><div class="col-lg-3"><select name="cucat_parent_cat_id[]" id="cucat_parent_cat_id_\'+cat_cnt+\'" onchange="getMainCategoryOptionAddMore(\'+cat_cnt+\')" class="form-control" required>'.$obj->getMainProfileOption('').'</select></div><div class="col-lg-3"><select name="cucat_cat_id[]" id="cucat_cat_id_\'+cat_cnt+\'" class="form-control" required>'.$obj->getMainCategoryOption('','').'</select></div><div class="col-lg-2"><select name="cucat_show[]" id="cucat_show_\'+cat_cnt+\'" class="form-control" required>'.$obj->getShowHideOption('').'</select></div><div class="col-lg-2"><a href="javascript:void(0);" onclick="removeRowCategory(\'+cat_cnt+\');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a></div></div>';

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
					<form role="form" class="form-horizontal" id="edit_cusine" name="edit_cusine" method="post"> 
						<input type="hidden" name="hdncusine_id" id="hdncusine_id" value="<?php echo $cusine_id;?>" >
						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">
						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">
						<input type="hidden" name="hdncusine_image" id="hdncusine_image" value="<?php echo $cusine_image;?>">
						<div class="form-group">
							<label class="col-lg-2 control-label">Item<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="item_id" id="item_id" class="form-control" required>
									<?php echo $obj->getItemOption($item_id); ?>
								</select>
							</div>
							
							
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Vendor<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="vendor_id" id="vendor_id" class="form-control" onchange="getVendorLocationOption('1','1');" required>
									<?php echo $obj->getVendorOption($vendor_id); ?>
								</select>
							</div>
						
							<label class="col-lg-2 control-label">Vendor Location<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="vloc_id" id="vloc_id" multiple="multiple" class="form-control" required>
									<?php echo $obj->getVendorLocationOption($vendor_id,$arr_vloc_id,'2','1'); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-lg-2 control-label">Serving Type<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="serving_type_id" id="serving_type_id" class="form-control" required>
									<?php echo $obj->getServingTypeOption($serving_type_id); ?>
								</select>
							</div>
						
							<label class="col-lg-2 control-label">Serving Size<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="serving_size" id="serving_size" placeholder="Serving Size" value="<?php echo $serving_size;?>" class="form-control" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-lg-2 control-label">Total Stock Quantity<span style="color:red">*</span></label>
							<div class="col-lg-2">
								<input type="text" name="cusine_qty" id="cusine_qty" placeholder="Total Stock Quantity" value="<?php echo $cusine_qty;?>" class="form-control" required>
							</div>
							
							<label class="col-lg-2 control-label">Currency<span style="color:red">*</span></label>
							<div class="col-lg-2">
								<select name="currency_id" id="currency_id" class="form-control" required>
									<?php echo $obj->getCurrencyOption($currency_id); ?>
								</select>
							</div>
						
							<label class="col-lg-2 control-label">Price<span style="color:red">*</span></label>
							<div class="col-lg-2">
								<input type="text" name="cusine_price" id="cusine_price" placeholder="Price" value="<?php echo $cusine_price;?>" class="form-control" required>
							</div>
						</div>
					<?php
					for($i=0;$i<$cat_total_cnt;$i++)
					{ ?>
						<div class="form-group" id="row_cat_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">
							<label class="col-lg-2 control-label"><?php if($i == 0) { ?><strong>Category</strong><span style="color:red">*</span><?php } ?></label>
						
							<div class="col-lg-3">
								<select name="cucat_parent_cat_id[]" id="cucat_parent_cat_id_<?php echo $i;?>" onchange="getMainCategoryOptionAddMore(<?php echo $i;?>)" class="form-control" required>
									<?php echo $obj->getMainProfileOption($arr_cucat_parent_cat_id[$i]); ?>
								</select>
							</div>
							<div class="col-lg-3">
								<select name="cucat_cat_id[]" id="cucat_cat_id_<?php echo $i;?>" class="form-control" required>
									<?php echo $obj->getMainCategoryOption($arr_cucat_parent_cat_id[$i],$arr_cucat_cat_id[$i]); ?>
								</select>
							</div>
							<div class="col-lg-2">
								<select name="cucat_show[]" id="cucat_show_<?php echo $i;?>" class="form-control" required>
									<?php echo $obj->getShowHideOption($arr_cucat_show[$i]); ?>
								</select>
							</div>
							<div class="col-lg-2">
							<?php
							if($i == 0)
							{ ?>
								<a href="javascript:void(0);" onclick="addMoreRowCategory();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>
							<?php  	
							}
							else
							{ ?>
								<a href="javascript:void(0);" onclick="removeRowCategory(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>
							<?php	
							}
							?>	
							</div>
						</div>
					<?php  	
					} ?>	
						<div class="form-group" >
							<label class="col-lg-2 control-label"><strong>Location</strong><span style="color:red">*</span></label>
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
									<?php echo $obj->getAreaOption($arr_city_id,$arr_area_id,'2','1'); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label"><strong>Date of Publish</strong><span style="color:red">*</span></label>
						
							<div class="col-lg-4">
								<select name="publish_date_type" id="publish_date_type" onchange="showHideDateDropdowns('publish')" class="form-control" required>
									<?php echo $obj->getDateTypeOption($publish_date_type); ?>
								</select>
							</div>
							<div class="col-lg-3">
								<div id="publish_show_days_of_month" style="display:<?php echo $publish_show_days_of_month;?>">
									<select name="publish_days_of_month" id="publish_days_of_month" multiple="multiple" class="form-control" required >
										<?php echo $obj->getDaysOfMonthOption($arr_publish_days_of_month,'2','1'); ?>
									</select>
								</div>	
								<div id="publish_show_days_of_week" style="display:<?php echo $publish_show_days_of_week;?>">
									<select name="publish_days_of_week" id="publish_days_of_week" multiple="multiple" class="form-control" required >
										<?php echo $obj->getDaysOfWeekOption($arr_publish_days_of_week,'2','1'); ?>
									</select>
								</div>	
								<div id="publish_show_single_date" style="display:<?php echo $publish_show_single_date;?>">
									<input type="text" name="publish_single_date" id="publish_single_date" placeholder="Select Date" value="<?php echo $publish_single_date;?>" class="form-control" required >
								</div>	
								<div id="publish_show_start_date" style="display:<?php echo $publish_show_start_date;?>">
									<input type="text" name="publish_start_date" id="publish_start_date" placeholder="Select Start Date" value="<?php echo $publish_start_date;?>" class="form-control" required >  
								</div>	
							</div>
							<div class="col-lg-3">
								<div id="publish_show_end_date" style="display:<?php echo $publish_show_end_date;?>">
									<input type="text" name="publish_end_date" id="publish_end_date" placeholder="Select End Date" value="<?php echo $publish_end_date;?>" class="form-control" required > 
								</div>	
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label"><strong>Date of Delivery</strong><span style="color:red">*</span></label>
						
							<div class="col-lg-4">
								<select name="delivery_date_type" id="delivery_date_type" onchange="showHideDateDropdowns('delivery')" class="form-control" required>
									<?php echo $obj->getDateTypeOption($delivery_date_type); ?>
								</select>
							</div>
							<div class="col-lg-3">
								<div id="delivery_show_days_of_month" style="display:<?php echo $delivery_show_days_of_month;?>">
									<select name="delivery_days_of_month" id="delivery_days_of_month" multiple="multiple" class="form-control" required >
										<?php echo $obj->getDaysOfMonthOption($arr_delivery_days_of_month,'2','1'); ?>
									</select>
								</div>	
								<div id="delivery_show_days_of_week" style="display:<?php echo $delivery_show_days_of_week;?>">
									<select name="delivery_days_of_week" id="delivery_days_of_week" multiple="multiple" class="form-control" required >
										<?php echo $obj->getDaysOfWeekOption($arr_delivery_days_of_week,'2','1'); ?>
									</select>
								</div>	
								<div id="delivery_show_single_date" style="display:<?php echo $delivery_show_single_date;?>">
									<input type="text" name="delivery_single_date" id="delivery_single_date" placeholder="Select Date" value="<?php echo $delivery_single_date;?>" class="form-control" required >
								</div>	
								<div id="delivery_show_start_date" style="display:<?php echo $delivery_show_start_date;?>">
									<input type="text" name="delivery_start_date" id="delivery_start_date" placeholder="Select Start Date" value="<?php echo $delivery_start_date;?>" class="form-control" required >  
								</div>	
							</div>
							<div class="col-lg-3">
								<div id="delivery_show_end_date" style="display:<?php echo $delivery_show_end_date;?>">
									<input type="text" name="delivery_end_date" id="delivery_end_date" placeholder="Select End Date" value="<?php echo $delivery_end_date;?>" class="form-control" required > 
								</div>	
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Cusine Description 1</label>
							<div class="col-lg-8">
								<textarea id="cusine_desc_1" name="cusine_desc_1" class="form-control"><?php echo $cusine_desc_1;?></textarea>
							</div>
							<div class="col-lg-2">
								<select name="cusine_desc_show_1" id="cusine_desc_show_1" class="form-control" required>
									<?php echo $obj->getShowHideOption($cusine_desc_show_1); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Cusine Description 2</label>
							<div class="col-lg-8">
								<textarea id="cusine_desc_2" name="cusine_desc_2" class="form-control"><?php echo $cusine_desc_2;?></textarea>
							</div>
							<div class="col-lg-2">
								<select name="cusine_desc_show_2" id="cusine_desc_show_2" class="form-control" required>
									<?php echo $obj->getShowHideOption($cusine_desc_show_2); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Cusine Image<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<?php
								if($cusine_image != '')
								{ ?>
									<img border="0" height="100" src="<?php echo SITE_URL.'/uploads/'.$cusine_image;?>" />
								<?php	
								}
								?>
								<input type="file" name="cusine_image" id="cusine_image" class="form-control" >
							</div>
						</div>			
						<div class="form-group"><label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="cusine_status" id="cusine_status" class="form-control">
									<option value="1" <?php if($cusine_status == '1'){?> selected <?php } ?>>Active</option> 
									<option value="0" <?php if($cusine_status == '0'){?> selected <?php } ?>>Inactive</option> 
								</select>
							</div>
						</div>	
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_cusines.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/edit-cusine-validator.js" type="text/javascript"></script>
<script>
$(document).ready(function()
{ 
	function getStateOption()
	{
		var country_id = $('#country_id').val();
		//alert('country_id='+country_id);	
		if(country_id == null)
		{
			$('#country_id').tokenize2().trigger('tokenize:tokens:add', ['-1', 'All Countries', true]);
			country_id = '-1';
			//return false;
		}
		//alert('country_id2='+$('#country_id').val());	
		
		//if (country_id.indexOf("-1") >= 0)
		if (country_id == '-1')
		{
			
		}
		else
		{
			var dataString ='country_id='+country_id+'&type=2&multiple=1&action=getstateoption';
			$.ajax({
				type: "POST",
				url: "ajax/remote.php",
				data: dataString,
				cache: false,      
				success: function(result)
				{
					if (country_id.indexOf("-1") >= 0)
					{
						
					}
					else
					{
						$('#state_id').tokenize2().trigger('tokenize:clear');
						$('#state_id').tokenize2().trigger('tokenize:tokens:add', ['-1', 'All States', true]);
						$('#city_id').tokenize2().trigger('tokenize:clear');
						$('#city_id').tokenize2().trigger('tokenize:tokens:add', ['-1', 'All Cities', true]);
					}
					
					$("#state_id").html(result);
					
					$('#state_id').tokenize2();
					$('#state_id').on('tokenize:tokens:add', getCityOption);
					$('#state_id').on('tokenize:tokens:remove', getCityOption);
					getCityOption();
				}
			});
		}
	}
	
	function getCityOption()
	{
		var country_id = $('#country_id').val();
		var state_id = $('#state_id').val();
		//alert('country_id='+country_id);	
				
		if(state_id == null)
		{
			$('#state_id').tokenize2().trigger('tokenize:tokens:add', ['-1', 'All States', true]);
			state_id = '-1';
			//return false;
		}
		//alert('country_id2='+$('#country_id').val());	
		
		//if (country_id.indexOf("-1") >= 0)
		if (state_id == '-1')
		{
			
		}
		else
		{
			var dataString ='country_id='+country_id+'&state_id='+state_id+'&type=2&multiple=1&action=getcityoption';
			$.ajax({
				type: "POST",
				url: "ajax/remote.php",
				data: dataString,
				cache: false,      
				success: function(result)
				{
					$('#city_id').tokenize2().trigger('tokenize:clear');
					$('#city_id').tokenize2().trigger('tokenize:tokens:add', ['-1', 'All Cities', true]);
					
					$("#city_id").html(result);
					
					$('#city_id').tokenize2();
					$('#city_id').on('tokenize:tokens:add', getAreaOption);
					$('#city_id').on('tokenize:tokens:remove', getAreaOption);
					getAreaOption();
				}
			});
		}
	}
	
	function getAreaOption()
	{
		//alert('area option');	
	}
	
	function validateVLocId()
	{
		var vloc_id = $('#vloc_id').val();
		if(vloc_id == null)
		{
			$('#vloc_id').tokenize2().trigger('tokenize:tokens:add', ['-1', 'All Locations', true]);
			$('#vloc_id').val('-1');
		}
		
	}
	
	$('#vloc_id').tokenize2();
	$('#vloc_id').on('tokenize:tokens:add', validateVLocId);
	$('#vloc_id').on('tokenize:tokens:remove', validateVLocId);
	
	$('#country_id').tokenize2();
	$('#country_id').on('tokenize:tokens:add', getStateOption);
	$('#country_id').on('tokenize:tokens:remove', getStateOption);
	
	
	$('#state_id').tokenize2();
	$('#state_id').on('tokenize:tokens:add', getCityOption);
	$('#state_id').on('tokenize:tokens:remove', getCityOption);
	
	$('#city_id').tokenize2();
	$('#city_id').on('tokenize:tokens:add', getAreaOption);
	$('#city_id').on('tokenize:tokens:remove', getAreaOption);
	
	$('#area_id').tokenize2();
	
	//$('#publish_days_of_month').tokenize2();
	//$('#publish_days_of_week').tokenize2();
	
	//$('#delivery_days_of_month').tokenize2();
	//$('#delivery_days_of_week').tokenize2();
	
	$('#btnClear').on('mousedown touchstart', function(e){
		e.preventDefault();
		$('#country_id, #state_id, #city_id, #area_id').tokenize2().trigger('tokenize:clear');
	});
	
	$('#publish_single_date').datepicker();
	$('#publish_start_date').datepicker();
	$('#publish_end_date').datepicker();
	
	$('#delivery_single_date').datepicker();
	$('#delivery_start_date').datepicker();
	$('#delivery_end_date').datepicker();
	
});

function addMoreRowCategory()
{
	var cat_cnt = parseInt($("#cat_cnt").val());
	cat_cnt = cat_cnt + 1;
	//alert("cat_cnt"+cat_cnt);
	$("#row_cat_first").after('<?php echo $add_more_row_cat_str;?>');
	$("#cat_cnt").val(cat_cnt);
	
	var cat_total_cnt = parseInt($("#cat_total_cnt").val());
	cat_total_cnt = cat_total_cnt + 1;
	$("#cat_total_cnt").val(cat_total_cnt);
}

function removeRowCategory(idval)
{
	//alert("row_cat_"+idval);
	$("#row_cat_"+idval).remove();
	
	var cat_total_cnt = parseInt($("#cat_total_cnt").val());
	cat_total_cnt = cat_total_cnt - 1;
	$("#cat_total_cnt").val(cat_total_cnt);
}
</script>

</body>
</html>