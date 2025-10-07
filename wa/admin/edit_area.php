<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '13';
$edit_action_id = '33';

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

if(isset($_GET['token']) && $_GET['token'] != '')
{
	//$adm_id = $_GET['id'];
	$area_id = base64_decode($_GET['token']);
	$arr_area_record = $obj->getAreaDetails($area_id);
	if(count($arr_area_record) == 0)
	{
		header("Location: manage_area.php");
		exit(0);
	}
	
	$country_id = $arr_area_record['country_id'];
	$state_id = $arr_area_record['state_id'];
	$city_id = $arr_area_record['city_id'];
	$area_name = $arr_area_record['area_name'];
	$area_pincode = $arr_area_record['area_pincode'];
	$status = $arr_area_record['area_status'];
	
}	
else
{
	header("Location: manage_area.php");
	exit(0);
}	
$arr_am_records = $obj->getAllMenuAccess(); 
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
				<div class="panel-body">
					<div class="row mail-header">
						<div class="col-md-6">
							<h3><?php echo $obj->getAdminActionName($edit_action_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="edit_area" name="edit_area" method="post"> 
						<input type="hidden" name="area_id" id="area_id" value="<?php echo $area_id;?>" >
						
						<div class="form-group"><label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="country_id" id = "country_id" class="form-control" onchange="getstate();">
									<option value="" >Select Country</option>
									<?php echo $obj->GetCountry($country_id); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">State<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="state_id" id = "state_id" class="form-control" onchange="getcity();">
									<?php echo $obj->GetState($state_id,$country_id); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">City<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="city_id" id = "city_id" class="form-control">
									<?php echo $obj->GetCity($state_id,$country_id,$city_id); ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-lg-2 control-label">Area Name<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="area_name" id="area_name" placeholder="Area Name" class="form-control" value="<?php echo $area_name;?>" required>
							</div>
						</div>							
						
						<div class="form-group"><label class="col-lg-2 control-label">Area Pincode<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="area_pincode" id="area_pincode" placeholder="Area Pincode" class="form-control" value="<?php echo $area_pincode;?>" required>
							</div>
						</div>	
						
						<div class="form-group"><label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="area_status" id="area_status" class="form-control">
									<option value="1" <?php if($status == '1'){?> selected <?php } ?>>Active</option> 
									<option value="0" <?php if($status == '0'){?> selected <?php } ?>>Inactive</option> 
								</select>
							</div>
						</div>	
						
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_area.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<!-- iCheck -->
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script src="admin-js/edit-area-validator.js" type="text/javascript"></script>
<script>
function getcity()
	{
		var country = $('#country_id').val();
		var state = $('#state_id').val();
		var city = $('#city_id').val();
		
		var dataString ='country='+country+'&state='+state+'&city='+city+'&action=getcity';
        $.ajax({
       type: "POST",
       url: "ajax/remote.php",
       data: dataString,
       cache: false,      
        success: function(result)
            {
               $("#city_id").html(result);
            }
         }); 
         
	}
	
	function getstate()
	{
		var country = $('#country_id').val();
		var state = $('#state_id').val();
		
		var dataString ='country='+country+'&state='+state+'&action=getstate';
        $.ajax({
       type: "POST",
       url: "ajax/remote.php",
       data: dataString,
       cache: false,      
        success: function(result)
            {
               $("#state_id").html(result);
            }
         }); 
         getcity();
	}
</script>
</body>
</html>