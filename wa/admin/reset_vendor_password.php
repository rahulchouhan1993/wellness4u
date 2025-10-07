<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '16';
$edit_action_id = '99';

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

$err_msg_start = '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><strong>';
$err_msg_end = '</strong><a class="alert-link" href="#"></a></div>';					  

if(isset($_POST['btnSubmit']))
{
	$vendor_id = trim($_POST['hdnvendor_id']);
	$password = strip_tags(trim($_POST['password']));
	$cpassword = strip_tags(trim($_POST['cpassword']));
	
	$arr_record = $obj->getVendorDetails($vendor_id);
	$vendor_name = stripslashes($arr_record['vendor_name']);
	
	if($password == '')
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter Password'.$err_msg_end;
	}
	
	if($cpassword == '')
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter Confirm Password'.$err_msg_end;
	}
	elseif($cpassword != $password)
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter Same Confirm Password'.$err_msg_end;
	}
	
	if(!$error)
	{
		$tdata = array();
		$tdata['vendor_id'] = $vendor_id;
		$tdata['vendor_password'] = $password;
		
		if($obj->updateVendorPassword($tdata))
		{
			$msg = 'Password Changed Successfully!';
			header("Location: manage_vendors.php?msg=".urlencode($msg));
			exit(0);
		}
		else
		{
			$error = true;
			$err_msg = $err_msg_start."Currently there is some problem.Please try again later.".$err_msg_end;
		}
	}
}
elseif(isset($_GET['token']) && $_GET['token'] != '')
{
	$vendor_id = base64_decode($_GET['token']);
	$arr_record = $obj->getVendorDetails($vendor_id);
	if(count($arr_record) == 0)
	{
		//echo '111111111111111111';
		header("Location: manage_vendors.php");
		exit(0);
	}
	$vendor_name = stripslashes($arr_record['vendor_name']);
}	
else
{
	//echo '22222222222222222222';
	header("Location: manage_vendors.php");
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
							<h3><?php echo $obj->getAdminActionName($edit_action_id);?> - For <?php echo $vendor_name;?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<?php
					if($msg != '')
					{ ?>
						<p class=""><?php echo $msg;?></p>
					<?php
					} ?>  
					<?php
					if($error)
					{ ?>
						<p class="err_msg"><?php echo $err_msg;?><br /><br /></p>
						<div class="clear"></div>
					<?php
					} ?>  
					<form method="post" role="form">
						<input type="hidden" name="hdnvendor_id" id="hdnvendor_id" value="<?php echo $vendor_id;?>" >
						<div class="form-group">
							<label>Password</label>  
							<input type="password" name="password" id="password" class="form-control" value="">
						</div>
						<div class="form-group">
							<label>Confirm Password</label>  
							<input type="password" name="cpassword" id="cpassword" class="form-control" value="">
						</div>	
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_vendors.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
</html>