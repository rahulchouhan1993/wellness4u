<?php
require_once('../classes/config.php');
require_once('../classes/vendor.php');
$admin_main_menu_id = '1';

$obj = new Vendor();
$obj2 = new commonFunctions();
if(!$obj->isVendorLoggedIn())
{
	header("Location: login.php");
	exit(0);
}
else
{
	$adm_vendor_id = $_SESSION['adm_vendor_id'];
}

$orgpassword = $obj->getVendorCurrentPassword($adm_vendor_id);

$error = false;
$err_msg = "";
$msg = '';

$err_msg_start = '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><strong>';
$err_msg_end = '</strong><a class="alert-link" href="#"></a></div>';					  

if(isset($_POST['btnSubmit']))
{
	$opassword = strip_tags(trim($_POST['opassword']));
	$password = strip_tags(trim($_POST['password']));
	$cpassword = strip_tags(trim($_POST['cpassword']));
	
	if($opassword == '')
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter Current Password'.$err_msg_end;
	}
	elseif(md5($opassword) != $orgpassword)
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter Correct Current Password'.$err_msg_end;
	}
	
	if($password == '')
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter New Password'.$err_msg_end;
	}
	
	if($cpassword == '')
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter Confirm New Password'.$err_msg_end;
	}
	elseif($cpassword != $password)
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter Same Confirm New Password'.$err_msg_end;
	}
	
	if(!$error)
	{
		$tdata = array();
		$tdata['vendor_id'] = $adm_vendor_id;
		$tdata['vendor_password'] = $password;
		
		if($obj->updateVendorPassword($tdata))
		{
			$msg = '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Password Updated Successfully!</strong>
					</div>';
		}
		else
		{
			$error = true;
			$err_msg = $err_msg_start."Currently there is some problem.Please try again later.".$err_msg_end;
		}
	}
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
				<header class="panel-heading">
					<h2 class="panel-title">Change Password</h2>
				</header>
				<div class="panel-body">
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
						<input type="hidden" name="status" id="status" value="<?php echo $status;?>" >
						<div class="form-group">
							<label>Current Password</label>  
							<input type="password" name="opassword" id="opassword" class="form-control" value="">
						</div>
						<div class="form-group">
							<label>New Password</label>  
							<input type="password" name="password" id="password" class="form-control" value="">
						</div>
						<div class="form-group">
							<label>Confirm New Password</label>  
							<input type="password" name="cpassword" id="cpassword" class="form-control" value="">
						</div>
						<div class="form-group">
							<button type="submit" name="btnSubmit" class="btn btn-success">Save</button>
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
</body>
</html>