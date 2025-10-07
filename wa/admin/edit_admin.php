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
$arr_selected_am_id = array();
$arr_selected_aa_id = array();

if(isset($_GET['token']) && $_GET['token'] != '')
{
	//$adm_id = $_GET['id'];
	$adm_id = base64_decode($_GET['token']);
	$arr_user_record = $obj->getAdminUserDetails($adm_id);
	if(count($arr_user_record) == 0)
	{
		header("Location: manage_admins.php");
		exit(0);
	}
	
	$username = $arr_user_record['username'];
	$email = $arr_user_record['email']; 
	$fname = $arr_user_record['fname'];
	$lname = $arr_user_record['lname'];
	$contact_no = $arr_user_record['contact_no'];
	$status = $arr_user_record['status'];
	$am_id = $arr_user_record['am_id'];
	$aa_id = $arr_user_record['aa_id'];
	
	if($am_id == '')
	{
		$arr_selected_am_id = array();
	}
	else
	{
		$arr_selected_am_id = explode(',',$am_id);	
	}
	
	if($aa_id == '')
	{
		$arr_selected_aa_id = array();
	}
	else
	{
		$arr_selected_aa_id = explode(',',$aa_id);	
	}
}	
else
{
	header("Location: manage_admins.php");
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
					<form role="form" class="form-horizontal" id="edit_admin" name="edit_admin" method="post"> 
						<input type="hidden" name="hdnadm_id" id="hdnadm_id" value="<?php echo $adm_id;?>" >
						<div class="form-group"><label class="col-lg-2 control-label">User Name<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="username" id="username" placeholder="Username" class="form-control" value="<?php echo $username;?>" required>
							</div>
						</div>							
						<div class="form-group"><label class="col-lg-2 control-label">Email<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="email" id="email" placeholder="Email" class="form-control" value="<?php echo $email;?>" required >
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">First Name<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="fname" id="fname" placeholder="First Name" class="form-control" value="<?php echo $fname;?>" required>
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Last Name<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="lname" id="lname" placeholder="Last Name" class="form-control" value="<?php echo $lname;?>" required>
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="contact_no" id="contact_no" placeholder="Contact Number" class="form-control" value="<?php echo $contact_no;?>" required>
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="status" id="status" class="form-control">
									<option value="1" <?php if($status == '1'){?> selected <?php } ?>>Active</option> 
									<option value="0" <?php if($status == '0'){?> selected <?php } ?>>Inactive</option> 
								</select>
							</div>
						</div>	
						<div class="form-group"><label class="col-lg-2 control-label">Menu Access<span style="color:red">*</span></label>
							<div class="col-lg-5">
							<?php
							foreach($arr_am_records as $key => $am_record)
							{
								if(in_array($am_record['am_id'],$arr_selected_am_id ))
								{
									$checked = ' checked="checked" ';
								}
								else
								{
									$checked = '';
								}									
							?>
								<div class="i-checks"><label> <input name="am_id[]" id="menu_<?php echo $am_record['am_id']; ?>" type="checkbox" onClick="ShowOrHideCheckBox('<?php echo $am_record['am_id']; ?>');" value="<?php echo $am_record['am_id'];?>" <?php echo $checked;?> > <i></i><?php echo $am_record['am_title'];?></label></div>
							<?php 
								$arr_aa_records = $obj->getAllMenuActionsAccess($am_record['am_id']);	
								foreach($arr_aa_records as $action_key => $aa_record)
								{
									if(in_array($aa_record['aa_id'],$arr_selected_aa_id ))
									{
										$checked_aa = ' checked="checked" ';
									}
									else
									{
										$checked_aa = '';
									}	

									if(in_array($am_record['am_id'],$arr_selected_am_id ))
									{	 
										$disable_aa = '';
									}	
									else
									{ 
									 $disable_aa = ' disabled="disabled" ';
									} 	
								?>
									<div class="i-checks" style="margin-left:30px;"><label> <input name="aa_id[]" id="permissions_<?php echo $am_record['am_id']; ?>_<?php echo $aa_record['aa_id']; ?>" type="checkbox" class="group_<?php echo $am_record['am_id']; ?>" onclick="HideCheckBox('<?php echo $am_record['am_id']; ?>')" <?php echo $disable_aa ?>  value="<?php echo $aa_record['aa_id'];?>" <?php echo $checked_aa;?> > <i></i><?php echo $aa_record['aa_title'];?></label></div>
								<?php 
								} 
							} ?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_admins.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/edit-admin-validator.js" type="text/javascript"></script>
</body>
</html>