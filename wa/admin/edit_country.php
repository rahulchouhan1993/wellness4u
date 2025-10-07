<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '10';
$edit_action_id = '20';

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
$arr_selected_am_id = array();
$arr_selected_aa_id = array();

if(isset($_GET['token']) && $_GET['token'] != '')
{
	//$adm_id = $_GET['id'];
	$country_id = base64_decode($_GET['token']);
	$arr_country_record = $obj->getCountryDetails($country_id);
	if(count($arr_country_record) == 0)
	{
		header("Location: manage_country.php");
		exit(0);
	}
	
	$country_name = $arr_country_record['country_name'];
	$status = $arr_country_record['country_status'];
	
}	
else
{
	header("Location: manage_country.php");
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
					<form role="form" class="form-horizontal" id="edit_country" name="edit_country" method="post"> 
						<input type="hidden" name="country_id" id="country_id" value="<?php echo $country_id;?>" >
						<div class="form-group"><label class="col-lg-2 control-label">Country Name<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="country_name" id="country_name" placeholder="Country Name" class="form-control" value="<?php echo $country_name;?>" required>
							</div>
						</div>							
						
						<div class="form-group"><label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="country_status" id="country_status" class="form-control">
									<option value="1" <?php if($status == '1'){?> selected <?php } ?>>Active</option> 
									<option value="0" <?php if($status == '0'){?> selected <?php } ?>>Inactive</option> 
								</select>
							</div>
						</div>	
						
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_country.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/edit-country-validator.js" type="text/javascript"></script>
</body>
</html>