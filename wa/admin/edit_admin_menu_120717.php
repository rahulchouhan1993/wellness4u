<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '5';
$edit_action_id = '15';

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
	$am_id = base64_decode($_GET['token']);
	$arr_record = $obj->getAdminMenuDetails($am_id);
	if(count($arr_record) == 0)
	{
		header("Location: manage_admin_menus.php");
		exit(0);
	}
	
	$am_title = $arr_record['am_title'];
	$am_link = $arr_record['am_link']; 
	$am_order = $arr_record['am_order'];
	$am_status = $arr_record['am_status'];
}	
else
{
	header("Location: manage_admin_menus.php");
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
					<form role="form" class="form-horizontal" id="edit_admin_menu" name="edit_admin_menu" method="post"> 
						<input type="hidden" name="hdnam_id" id="hdnam_id" value="<?php echo $am_id;?>" >
						<div class="form-group"><label class="col-lg-2 control-label">Menu Title<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="am_title" id="am_title" placeholder="Menu Title" class="form-control" value="<?php echo $am_title;?>" required>
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Menu Link<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="am_link" id="am_link" placeholder="Menu Link" class="form-control" value="<?php echo $am_link;?>" required>
							</div>
						</div>                                     
						<div class="form-group"><label class="col-lg-2 control-label">Menu Order<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="am_order" id="am_order" placeholder="Menu Order" class="form-control" value="<?php echo $am_order;?>" required>
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="am_status" id="am_status" class="form-control">
									<option value="1" <?php if($am_status == '1'){?> selected <?php } ?>>Active</option> 
									<option value="0" <?php if($am_status == '0'){?> selected <?php } ?>>Inactive</option> 
								</select>
							</div>
						</div>	
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_admin_menus.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/edit-admin-menu-validator.js" type="text/javascript"></script>
</body>
</html>