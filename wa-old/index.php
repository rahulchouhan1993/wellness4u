<?php
require_once('../classes/config.php');
require_once('../classes/vendor.php');
$admin_main_menu_id = '1';

$obj = new Vendor();
if(!$obj->isVendorLoggedIn())
{
	header("Location: login.php");
	exit(0);
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
		<div class="col-sm-12"><h3 align="center">Welcome to <?php echo SITE_NAME;?> - Business Associates Panel</h3></div>
	</div>
	<!--widget box row-->
</div><!--end container-->
<?php include_once('footer.php');?>
<!--Common plugins-->
<?php require_once('script.php'); ?>
<!--page scripts-->
<!-- Flot chart js -->
<script src="assets/plugins/flot/jquery.flot.js"></script>
<script src="assets/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="assets/plugins/flot/jquery.flot.resize.js"></script>
<script src="assets/plugins/flot/jquery.flot.pie.js"></script>
<script src="assets/plugins/flot/jquery.flot.time.js"></script>
<!--vector map-->
<script src="assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- ChartJS-->
<script src="assets/plugins/chartJs/Chart.min.js"></script>
<!--dashboard custom script-->
<script src="assets/js/dashboard.js"></script>
</body>
</html>