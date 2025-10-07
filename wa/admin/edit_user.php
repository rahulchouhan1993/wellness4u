<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '24';
$edit_action_id = '73';

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
	$user_id = base64_decode($_GET['token']);
	$arr_record = $obj->getUserDetails($user_id);
	if(count($arr_record) == 0)
	{
		header("Location: manage_users.php");
		exit(0);
	}
	
	$first_name = $arr_record['first_name'];
	$last_name = $arr_record['last_name'];
	$email = $arr_record['email'];
	$mobile_no = $arr_record['mobile_no'];
	$building_name = $arr_record['building_name'];
	$floor_no = $arr_record['floor_no'];
	$landmark = $arr_record['landmark'];
	$address = $arr_record['address'];
	$country_id = $arr_record['country_id'];
	$state_id = $arr_record['state_id'];
	$city_id = $arr_record['city_id'];
	$area_id = $arr_record['area_id'];
	$user_status = $arr_record['user_status'];
	$user_blocked = $arr_record['user_blocked'];
	
}	
else
{
	header("Location: manage_users.php");
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
					<form role="form" class="form-horizontal" id="edit_user" name="edit_user" method="post"> 
						<input type="hidden" name="hdnuser_id" id="hdnuser_id" value="<?php echo $user_id;?>" >
						<div class="form-group">
							<label class="col-lg-2 control-label">First Name<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="first_name" id="first_name" value="<?php echo $first_name;?>" placeholder="First Name" class="form-control" required>
							</div>
							<label class="col-lg-2 control-label">Last Name</label>
							<div class="col-lg-4">
								<input type="text" name="last_name" id="last_name" value="<?php echo $last_name;?>" placeholder="Last Name" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Email<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="email" id="email" value="<?php echo $email;?>" placeholder="Email" class="form-control" required>
							</div>
							
							<label class="col-lg-2 control-label">Mobile No<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="mobile_no" id="mobile_no" value="<?php echo $mobile_no;?>" placeholder="Mobile No" class="form-control" required>
							</div>
						</div>
						<div class="form-group" >	
							<label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="country_id" id="country_id" onchange="getStateOptionCommon('1','')" class="form-control" required>
									<?php echo $obj->getCountryOption($country_id); ?>
								</select>
							</div>
							<label class="col-lg-2 control-label">State<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="state_id" id="state_id" onchange="getCityOptionCommon('1','')" class="form-control" required>
									<?php echo $obj->getStateOption($country_id,$state_id); ?>
								</select>
							</div>
						</div>
						<div class="form-group">	
							<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="city_id" id="city_id" onchange="getAreaOptionCommon('1','')" class="form-control" required>
									<?php echo $obj->getCityOption($country_id,$state_id,$city_id); ?>
								</select>
							</div>
							<label class="col-lg-2 control-label">Area</label>
							<div class="col-lg-4">
								<select name="area_id" id="area_id" class="form-control">
									<?php echo $obj->getAreaOption($country_id,$state_id,$city_id,$area_id); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Building Name</label>
							<div class="col-lg-4">
								<input type="text" name="building_name" id="building_name" value="<?php echo $building_name;?>" placeholder="Building Name" class="form-control">
							</div>
							<label class="col-lg-2 control-label">Floor No</label>
							<div class="col-lg-4">
								<input type="text" name="floor_no" id="floor_no" value="<?php echo $floor_no;?>" placeholder="Floor No" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Landmark</label>
							<div class="col-lg-4">
								<input type="text" name="landmark" id="landmark" value="<?php echo $landmark;?>" placeholder="Landmark" class="form-control">
							</div>
							<label class="col-lg-2 control-label">Address</label>
							<div class="col-lg-4">
								<input type="text" name="address" id="address" value="<?php echo $address;?>" placeholder="Address" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">OTP Status<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="user_status" id="user_status" class="form-control">
									<option value="1" <?php if($user_status == '1'){?> selected <?php } ?>>Active</option> 
									<option value="0" <?php if($user_status == '0'){?> selected <?php } ?>>Inactive</option> 
								</select>
							</div>
							<label class="col-lg-2 control-label">Blocked<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="user_blocked" id="user_blocked" class="form-control">
									<option value="1" <?php if($user_blocked == '1'){?> selected <?php } ?>>Yes</option> 
									<option value="0" <?php if($user_blocked == '0'){?> selected <?php } ?>>No</option> 
								</select>
							</div>
						</div>
						
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_users.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/edit-user-validator.js" type="text/javascript"></script>
<script src="js/tokenize2.js"></script></body>
</html>