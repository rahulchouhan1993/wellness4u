<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '5';
$add_action_id = '14';

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

$page_name = '';
$page_title = '';
$page_contents = '';
$meta_title = '';
$meta_keywords = '';
$meta_desc = '';
$show_in_manage_menu = '1';
$page_link = '';
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
					<form role="form" class="form-horizontal" id="add_page" name="add_page" method="post" > 
						<div class="form-group"><label class="col-lg-2 control-label">Page Name<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="page_name" id="page_name" value="<?php echo $page_name;?>" placeholder="Page Name" class="form-control" required>
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Page Heading<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<input type="text" name="page_title" id="page_title" value="<?php echo $page_title;?>" placeholder="Page Heading" class="form-control" required>
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Page Contents<span style="color:red">*</span></label>
							<div class="col-lg-8">
								<div class="summernote-theme-1">
									<div class="page_contents" id="page_contents"><?php echo $page_contents;?></div>
								</div>
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Meta Title</label>
							<div class="col-lg-8">
								<input type="text" name="meta_title" id="meta_title" value="<?php echo $meta_title;?>" placeholder="Page Title" class="form-control">
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Meta Description</label>
							<div class="col-lg-8">
								<textarea name="meta_desc" id="meta_desc" placeholder="Meta Description" class="form-control"><?php echo $meta_desc;?></textarea>
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Meta Keywords</label>
							<div class="col-lg-8">
								<textarea name="meta_keywords" id="meta_keywords" placeholder="Meta Keywords" class="form-control"><?php echo $meta_keywords;?></textarea>
							</div>
						</div>
						<div class="form-group"><label class="col-lg-2 control-label">Page Link</label>
							<div class="col-lg-5">
								<input type="text" name="page_link" id="page_link" value="<?php echo $page_link;?>" placeholder="Page Link" class="form-control" >
							</div>
						</div>						
						<div class="form-group"><label class="col-lg-2 control-label">Show in Manage Menu<span style="color:red">*</span></label>
							<div class="col-lg-5">
								<select name="show_in_manage_menu" id="show_in_manage_menu" class="form-control" required>
									<option value="1" <?php if($show_in_manage_menu == '1'){ ?> selected <?php } ?>>Yes</option>
									<option value="0" <?php if($show_in_manage_menu == '0'){ ?> selected <?php } ?>>No</option>
								</select>
							</div>
						</div>						
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
									<a href="manage_pages.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
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
<script src="admin-js/add-page-validator.js" type="text/javascript"></script>
<script>
$(document).ready(function()
{ 
	$('#page_contents').summernote();
});
</script>
</body>
</html>