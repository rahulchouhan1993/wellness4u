<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '1';

$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	header("Location: login.php");
	exit(0);
}
else
{
	$admin_id = $_SESSION['admin_id'];
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
	<!--widget box row-->
	<div class="row">
	<?php
	if($obj->chkIfAccessOfMenu($admin_id,$admin_main_menu_id))
	{ ?>
		<div class="col-sm-6 col-md-3 margin-b-30">
			<div class="statistic-widget-box bg-primary">
				<i class="fa fa-shopping-bag"></i>
				<div class="content overflow-hidden">
					<h1>10</h1>
					<p>New Orders</p>
				</div>
			</div><!--statistic box end-->
		</div><!--col end-->
		<div class="col-sm-6 col-md-3 margin-b-30">
			<div class="statistic-widget-box bg-danger">
				<i class="fa fa-usd"></i>
				<div class="content overflow-hidden">
					<h1>Rs 20,000</h1>
					<p>Total Revenue</p>
				</div>
			</div><!--statistic box end-->
		</div><!--col end-->
		<div class="col-sm-6 col-md-3 margin-b-30">
			<div class="statistic-widget-box bg-success">
				<i class="fa fa-users"></i>
				<div class="content overflow-hidden">
					<h1>20</h1>
					<p>New Customers</p>
				</div>
			</div><!--statistic box end-->
		</div><!--col end-->
		<div class="col-sm-6 col-md-3 margin-b-30">
			<div class="statistic-widget-box bg-info">
				<i class="fa fa-bar-chart"></i>
				<div class="content overflow-hidden">
					<h1>2</h1>
					<p>New Vendors</p>
				</div>
			</div><!--statistic box end-->
		</div><!--col end-->
	<?php
	}
	else
	{ ?>
		<div class="col-sm-12"><h3 align="center">Welcome to <?php echo SITE_NAME;?> - Admin Panel</h3></div>
	<?php	
	} ?>	
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