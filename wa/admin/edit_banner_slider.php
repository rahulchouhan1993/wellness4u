<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '17';
$edit_action_id = '49';

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

if(isset($_GET['token']) && $_GET['token'] != '')
{
	$banner_id = base64_decode($_GET['token']);
	$arr_record = $obj->getBannerSliderDetails($banner_id);
	if(count($arr_record) == 0)
	{
		header("Location: manage_banner_sliders.php");
		exit(0);
	}
	
	$banner_title = $arr_record['banner_title'];
	$banner_title_font_family = $arr_record['banner_title_font_family'];
	$banner_title_font_size = $arr_record['banner_title_font_size'];
	$banner_title_font_color = $arr_record['banner_title_font_color'];
	$banner_image = $arr_record['banner_image'];
	$banner_text_line1 = $arr_record['banner_text_line1']; 
	$banner_text_line1_font_family = $arr_record['banner_text_line1_font_family'];
	$banner_text_line1_font_size = $arr_record['banner_text_line1_font_size'];
	$banner_text_line1_font_color = $arr_record['banner_text_line1_font_color'];
	$banner_text_line2 = $arr_record['banner_text_line2']; 
	$banner_text_line2_font_family = $arr_record['banner_text_line2_font_family'];
	$banner_text_line2_font_size = $arr_record['banner_text_line2_font_size'];
	$banner_text_line2_font_color = $arr_record['banner_text_line2_font_color'];
	$banner_order = $arr_record['banner_order']; 
	
	$banner_country_id = $arr_record['banner_country_id'];
	if($banner_country_id == '-1' || $banner_country_id == '')
	{
		$arr_country_id = array('-1');	
	}
	else
	{
		$arr_country_id = explode(',',$banner_country_id);	
	}
	
	$banner_state_id = $arr_record['banner_state_id'];
	if($banner_state_id == '-1' || $banner_state_id == '')
	{
		$arr_state_id = array('-1');	
	}
	else
	{
		$arr_state_id = explode(',',$banner_state_id);	
	}
	
	$banner_city_id = $arr_record['banner_city_id'];
	if($banner_city_id == '-1' || $banner_city_id == '')
	{
		$arr_city_id = array('-1');	
	}
	else
	{
		$arr_city_id = explode(',',$banner_city_id);	
	}
	
	$banner_area_id = $arr_record['banner_area_id'];
	if($banner_area_id == '-1' || $banner_area_id == '')
	{
		$arr_area_id = array('-1');	
	}
	else
	{
		$arr_area_id = explode(',',$banner_area_id);	
	}
	
	$banner_status = $arr_record['banner_status'];
	
	$publish_date_type = $arr_record['banner_publish_date_type'];
	$publish_days_of_month = $arr_record['banner_publish_days_of_month'];
	$publish_days_of_week = $arr_record['banner_publish_days_of_week'];
	$publish_single_date = $arr_record['banner_publish_single_date'];
	$publish_start_date = $arr_record['banner_publish_start_date'];
	$publish_end_date = $arr_record['banner_publish_end_date'];
	
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
}	
else
{
	header("Location: manage_banner_sliders.php");
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
					<form role="form" class="form-horizontal" id="edit_banner_slider" name="edit_banner_slider" method="post"> 
						<input type="hidden" name="hdnbanner_id" id="hdnbanner_id" value="<?php echo $banner_id;?>" >
						<input type="hidden" name="hdnbanner_image" id="hdnbanner_image" value="<?php echo $banner_image;?>">
						<div class="form-group">
							<label class="col-lg-2 control-label">Banner Title<span style="color:red">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="banner_title" id="banner_title" value="<?php echo $banner_title?>" class="form-control" required>
							</div>
						
							
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Font Family</label>
							<div class="col-lg-2">
								<select name="banner_title_font_family" id="banner_title_font_family" class="form-control">
									<?php echo $obj->getFontFamilyOptions($banner_title_font_family); ?>	
								</select>
							</div>
						
							<label class="col-lg-2 control-label">Font Size</label>
							<div class="col-lg-2">
								<select name="banner_title_font_size" id="banner_title_font_size" class="form-control">
									<?php echo $obj->getFontSizeOptions($banner_title_font_size); ?>	
								</select>
							</div>
							
							<label class="col-lg-2 control-label">Font Color</label>
							<div class="col-lg-2">
								<input type="text" class="color" id="banner_title_font_color" name="banner_title_font_color" value="<?php echo $banner_title_font_color; ?>" class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Banner Text Line1</label>
							<div class="col-lg-10">
								<input type="text" name="banner_text_line1" id="banner_text_line1" value="<?php echo $banner_text_line1?>" class="form-control">
							</div>
						
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Font Family</label>
							<div class="col-lg-2">
								<select name="banner_text_line1_font_family" id="banner_text_line1_font_family" class="form-control">
									<?php echo $obj->getFontFamilyOptions($banner_text_line1_font_family); ?>	
								</select>
							</div>
						
							<label class="col-lg-2 control-label">Font Size</label>
							<div class="col-lg-2">
								<select name="banner_text_line1_font_size" id="banner_text_line1_font_size" class="form-control">
									<?php echo $obj->getFontSizeOptions($banner_text_line1_font_size); ?>	
								</select>
							</div>
							
							<label class="col-lg-2 control-label">Font Color</label>
							<div class="col-lg-2">
								<input type="text" class="color" id="banner_text_line1_font_color" name="banner_text_line1_font_color" value="<?php echo $banner_text_line1_font_color; ?>" class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Banner Text Line2</label>
							<div class="col-lg-10">
								<input type="text" name="banner_text_line2" id="banner_text_line2" value="<?php echo $banner_text_line2?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Font Family</label>
							<div class="col-lg-2">
								<select name="banner_text_line2_font_family" id="banner_text_line2_font_family" class="form-control">
									<?php echo $obj->getFontFamilyOptions($banner_text_line2_font_family); ?>	
								</select>
							</div>
						
							<label class="col-lg-2 control-label">Font Size</label>
							<div class="col-lg-2">
								<select name="banner_text_line2_font_size" id="banner_text_line2_font_size" class="form-control">
									<?php echo $obj->getFontSizeOptions($banner_text_line2_font_size); ?>	
								</select>
							</div>
							
							<label class="col-lg-2 control-label">Font Color</label>
							<div class="col-lg-2">
								<input type="text" class="color" id="banner_text_line2_font_color" name="banner_text_line2_font_color" value="<?php echo $banner_text_line2_font_color; ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Banner Image<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<?php
								if($banner_image != '')
								{ ?>
									<img border="0" height="100" src="<?php echo SITE_URL.'/uploads/'.$banner_image;?>" title="<?php echo $banner_image;?>" alt="<?php echo $banner_image;?>" />
								<?php	
								}
								?>
								<input type="file" name="banner_image" id="banner_image" class="form-control" ><br><span>(Recommanded size 1160px X 178px)</span>
							</div>
							
							<label class="col-lg-2 control-label">Banner Order<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="banner_order" id="banner_order" value="<?php echo $banner_order?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="banner_status" id="banner_status" class="form-control">
									<option value="1" <?php if($banner_status == '1'){?> selected <?php } ?>>Active</option> 
									<option value="0" <?php if($banner_status == '0'){?> selected <?php } ?>>Inactive</option> 
								</select>
							</div>
						</div>					
						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
							<div class="form-group left-label">
								<label class="col-lg-4 control-label"><strong>Banner Location Details:</strong></label>
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
							
						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
							<div class="form-group left-label">
								<label class="col-lg-4 control-label"><strong>Banner Publish Date Details:</strong></label>
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
										<input type="text" name="publish_single_date" id="publish_single_date" value="<?php echo $publish_single_date;?>" placeholder="Select Date" class="form-control" required >
									</div>	
									<div id="publish_show_start_date" style="display:<?php echo $publish_show_start_date;?>">
										<input type="text" name="publish_start_date" id="publish_start_date" value="<?php echo $publish_start_date;?>" placeholder="Select Start Date" class="form-control" required >  
									</div>	
								</div>
								<div class="col-lg-3">
									<div id="publish_show_end_date" style="display:<?php echo $publish_show_end_date;?>">
										<input type="text" name="publish_end_date" id="publish_end_date" value="<?php echo $publish_end_date;?>" placeholder="Select End Date" class="form-control" required > 
									</div>	
								</div>
							</div>
						</div>	
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_banner_sliders.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/edit-banner-slider-validator.js" type="text/javascript"></script>
<script src="js/jscolor.js" type="text/javascript"></script>
<script>
$(document).ready(function()
{
	
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
	
	$('#publish_single_date').datepicker();
	$('#publish_start_date').datepicker();
	$('#publish_end_date').datepicker();
	
});


</script>

</body>
</html>