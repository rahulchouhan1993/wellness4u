<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '2';
$edit_action_id = '3';

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
	$adm_id = trim($_POST['hdnadm_id']);
	$password = strip_tags(trim($_POST['password']));
	$cpassword = strip_tags(trim($_POST['cpassword']));
	
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
		$tdata['admin_id'] = $adm_id;
		$tdata['password'] = $password;
		
		if($obj->updateAdminPassword($tdata))
		{
			$msg = 'Password Changed Successfully!';
			header("Location: manage_admins.php?msg=".urlencode($msg));
			exit(0);
		}
		else
		{
			$error = true;
			$err_msg = $err_msg_start."Currently there is some problem.Please try again later.".$err_msg_end;
		}
	}
}
elseif(isset($_GET['id']) && $_GET['id'] != '')
{
	$adm_id = $_GET['id'];
	$arr_user_record = $obj->getAdminUserDetails($adm_id);
	if(count($arr_user_record) == 0)
	{
		header("Location: manage_admins.php");
		exit(0);
	}
}	
else
{
	header("Location: manage_admins.php");
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
				<header class="panel-heading">
					<h2 class="panel-title">Change Admin Password</h2>
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
						<input type="hidden" name="hdnadm_id" id="hdnadm_id" value="<?php echo $adm_id;?>" >
						<div class="form-group">
							<label>Password</label>  
							<input type="password" name="password" id="password" class="form-control" value="">
						</div>
						<div class="form-group">
							<label>Confirm Password</label>  
							<input type="password" name="cpassword" id="cpassword" class="form-control" value="">
						</div>
						<div class="form-group">
							<button type="submit" name="btnSubmit" class="btn btn-success">Save</button>&nbsp;
							<button type="button" name="btnBack" class="btn btn-danger" onclick="window.location.href='manage_admins.php';">Cancel</button>
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