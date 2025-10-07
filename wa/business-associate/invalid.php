<?php
require_once('../classes/config.php');
require_once('../classes/vendor.php');
$admin_main_menu_id = '1';

$obj = new Vendor();
if(!$obj->isVendorLoggedIn())
{
	//header("Location: login.php");
	//exit(0);
}
else
{
	$adm_vendor_id = $_SESSION['adm_vendor_id'];
}
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo SITE_NAME;?> - Business Associates</title>
	<?php require_once 'head.php'; ?>
</head>
<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">
<?php include_once('header.php');?>
<div class="container">
	<!--widget box row-->
	<div class="row">
		<div class="col-sm-12">
			<div class="alert alert-danger"><h2>Invalid Access.</h2></div>
		</div>
	</div><!--row end-->
</div><!--end container-->
<?php include_once('footer.php');?>
<!--Common plugins-->
<?php require_once('script.php'); ?>
</body>
</html>