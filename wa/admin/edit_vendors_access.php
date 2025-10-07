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
	//$va_id = $_GET['id'];
	$va_id = base64_decode($_GET['token']);
	$arr_user_record = $obj->getVendorsAccessDetails($va_id);
	if(count($arr_user_record) == 0)
	{
		header("Location: manage_vendors_access.php");
		exit(0);
	}
	
	$va_cat_id = $arr_user_record['va_cat_id'];
        $va_sub_cat_id = $arr_user_record['va_sub_cat_id'];
	$va_name = stripslashes($arr_user_record['va_name']); 
	$va_status = $arr_user_record['va_status'];
	$am_id = $arr_user_record['va_am_id'];
	$aa_id = $arr_user_record['va_aa_id'];
	
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
	header("Location: manage_vendors_access.php");
	exit(0);
}	
$arr_am_records = $obj->getAllMenuAccess(1); 
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
					<form role="form" class="form-horizontal" id="edit_vendors_access" name="edit_vendors_access" method="post"> 
						<?php echo $obj->getInputFieldCode('hdnva_id','hdnva_id',$va_id,'hidden');?>
                                                <input type="hidden" name="hdn_va_cat_id" id="hdn_va_cat_id" value="<?php echo $va_cat_id; ?>">
                                                <input type="hidden" name="hdn_va_sub_cat_id" id="hdn_va_sub_cat_id" value="<?php echo $va_sub_cat_id; ?>">
                                            
                                                <div class="form-group">
							<label class="col-lg-2 control-label">Profile Category<span style="color:red">*</span></label>
							<div class="col-lg-5">
                                                            <select name="va_cat_id" class="form-control" id="va_cat_id" disabled="" >
                                                            <option value="">All Type</option>	
                                                            <?php echo $obj->getFavCategoryTypeOptions($va_cat_id);?>
                                                            </select>
							</div>
						</div>
                                            
						<div class="form-group">
							<label class="col-lg-2 control-label">Business Associates Category<span style="color:red">*</span></label>
							<div class="col-lg-5">
                                                            <select name="va_sub_cat_id" class="form-control" id="va_sub_cat_id" disabled="" >
                                                            <option value="">All Type</option>	
                                                            <?php echo $obj->getFavCatBYProfileId($va_cat_id,$va_sub_cat_id);?>
                                                            </select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Title<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<?php echo $obj->getInputFieldCode('va_name','va_name',$va_name,'text','Title','form-control','','1');?>
							</div>
						</div>                                        
						<div class="form-group">
							<label class="col-lg-2 control-label">Status</label>
							<div class="col-lg-5">
								<?php echo $obj->getSelectFieldCode('va_status','va_status',$obj->getStatusOption($va_status),'form-control','','','','1');?>
							</div>
						</div>	
						<div class="form-group">
							<label class="col-lg-2 control-label">Menu Access<span style="color:red">*</span></label>
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
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_vendors_access.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/edit-vendors-access-validator.js" type="text/javascript"></script>
</body>
</html>