<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '4';
$add_action_id = '10';

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

if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
{
	header("Location: invalid.php");
	exit(0);
}


$error = false;
$err_msg = "";
$msg = '';

$parent_cat_id = '';
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
		<div class="col-sm-12">
			<div class="panel">
				<div class="panel-body">
					<div class="row mail-header">
						<div class="col-md-6">
							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="add_main_cat" name="add_main_cat" method="post">
						<div class="form-group"><label class="col-lg-2 control-label">Main Profile<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="parent_cat_id" id = "parent_cat_id" class="form-control">
									<option value="" >Select Main Profile</option>
									<?php echo $obj->GetParentCategory($parent_cat_id); ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Category<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="cat_name" id="cat_name" placeholder="Category" class="form-control" required>
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Category Image</label>
							<div class="col-lg-5">
								<input type="file" name="cat_image" id="cat_image" class="form-control"><br><span>(For State specialities icon prefreable size: 73px X 73 px resolution)</span>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_main_category.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/add-main-category-validator.js" type="text/javascript"></script>
</body>
</html>