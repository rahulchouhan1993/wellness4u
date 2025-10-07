<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '24';
$edit_action_id = '75';

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
	$user_id = trim($_POST['hdnuser_id']);
	$password = strip_tags(trim($_POST['password']));
	$cpassword = strip_tags(trim($_POST['cpassword']));
	
	$arr_record = $obj->getUserDetails($user_id);
	$first_name = $arr_record['first_name'];
	$last_name = $arr_record['last_name'];
	
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
		$tdata['user_id'] = $user_id;
		$tdata['password'] = $password;
		
		if($obj->updateUserPassword($tdata))
		{
			$msg = 'Password Changed Successfully!';
			header("Location: manage_users.php?msg=".urlencode($msg));
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
	$user_id = base64_decode($_GET['token']);
	$arr_record = $obj->getUserDetails($user_id);
	$first_name = $arr_record['first_name'];
	$last_name = $arr_record['last_name'];
	if(count($arr_record) == 0)
	{
		header("Location: manage_users.php");
		exit(0);
	}
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
							<h3><?php echo $obj->getAdminActionName($edit_action_id);?> - For <?php echo $first_name.' '.$last_name;?></h3>
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
						<input type="hidden" name="hdnuser_id" id="hdnuser_id" value="<?php echo $user_id;?>" >
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
</html>