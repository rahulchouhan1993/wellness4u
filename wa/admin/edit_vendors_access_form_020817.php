<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '29';
$edit_action_id = '97';

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
$vafm_id = '';

if(isset($_GET['va_id']) && $_GET['va_id'] != '')
{
	$va_id = trim($_GET['va_id']);
	$arr_record = $obj->getVendorsAccessDetails($va_id);
	if(count($arr_record) == 0)
	{
		header("Location: manage_vendors_access.php");
		exit(0);
	}
	else
	{
		if(isset($_GET['vaf_id']) && $_GET['vaf_id'] != '')
		{
			$vaf_id = trim($_GET['vaf_id']);
			if($obj->chkValidVendorAccessForm($va_id,$vaf_id))
			{
				$arr_vaf_record = $obj->getVendorsAccessFormDetails($vaf_id);
				if(count($arr_vaf_record) == 0)
				{
					header("Location: manage_vendors_access_forms.php?va_id=".$va_id);
					exit(0);
				}
				else
				{
					$vafm_id = $arr_vaf_record['vafm_id'];
					$vaf_status = $arr_vaf_record['vaf_status'];
				}
			}
			else
			{
				header("Location: manage_vendors_access_forms.php?va_id=".$va_id);
				exit(0);
			}	
		}	
		else
		{
			header("Location: manage_vendors_access_forms.php?va_id=".$va_id);
			exit(0);
		}	
	}
}	
else
{
	header("Location: manage_vendors_access.php");
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
					<form role="form" class="form-horizontal" id="edit_vendors_access_form" name="edit_vendors_access_form" method="post"> 
						<input type="hidden" name="hdnva_id" id="hdnva_id" value="<?php echo $va_id;?>" >
						<input type="hidden" name="hdnvaf_id" id="hdnvaf_id" value="<?php echo $vaf_id;?>" >
						<div class="form-group">
							<div class="col-lg-12"><p style="font-weight:bold;">Fields with <span style="color:red">*</span> are mandatory to show.</p></div>
						</div>	
						<div class="form-group">
							<label class="col-lg-2 control-label">Form<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="vafm_id" id="vafm_id" class="form-control" onchange="getVendorAccessFormCode();" required>
									<?php echo $obj->getVendorAccessFormOption($va_id,$vafm_id); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Status</label>
							<div class="col-lg-4">
								<?php echo $obj->getSelectFieldCode('vaf_status','vaf_status',$obj->getStatusOption($vaf_status),'form-control','','','','1');?>
							</div>
						</div>	
						<div id="vendor_access_form" >
							<?php echo $obj->getVendorAccessFormCode($va_id,$vafm_id);?>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_vendors_access_forms.php?va_id=<?php echo $va_id;?>"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/edit-vendors-access-form-validator.js" type="text/javascript"></script>
</body>
</html>