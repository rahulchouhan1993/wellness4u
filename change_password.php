<?php 
// require_once('classes/config.php');
// require_once('classes/commonFunctions.php');
include('classes/config.php');

// $obj = new commonFunctions();
$obj = new frontclass();
$obj2 = new frontclass2();
$page_id = 21;
$arr_page_details = $obj->getFrontPageDetails($page_id);

if($obj->isLoggedIn())
{
	$user_id = $_SESSION['user_id'];
	$obj->updateUserOnlineTimestamp($user_id);
}
else
{
	echo '<script>window.location.href="'.SITE_URL.'/login.php"</script>';
	exit(0);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php');?>
</head>
<body>
<?php include_once('header.php');?>
<section id="checkout">
	<div class="container">
		<div class="row">
			<div class="col-md-2 myaccount-box">
				<?php echo $obj->getSideLoggedinMenu($page_id);?>
			</div>
			<div class="col-md-8">
				<form name="frmcheckoutlogin" id="frmcheckoutlogin">
					<div id="checkout-accordion">
						<h3 data-corners="false">
							<p style="margin-top: 0px;">Change Password</p>
						</h3>
						<div class="checkout-accordion-content">
							<div class="checkout-loggedin">
								<input style="display:none" type="text" name="fakeusernameremembered" />
								<input style="display:none" type="password" name="fakepasswordremembered"/>
								<span id="err_msg_signup"></span>
								<div class="form-group">
									<input type="password" name="opassword" id="opassword" value="" placeholder="Enter Current Password" class="input-text-box" autocomplete="false">
								</div>
								<div class="form-group">
									<input type="password" name="npassword" id="npassword" value="" placeholder="Enter New Password" class="input-text-box" autocomplete="false">
								</div>
								<div class="form-group">
									<input type="password" name="cpassword" id="cpassword" value="" placeholder="Enter Confirm Password" class="input-text-box" autocomplete="false">
								</div>
								<div class="form-group">
									<a class="btn-red" href="javascript:doChangePassword()">UPDATE</a>
								</div>
							</div>
						</div>
						
					</div>
				</form>
			</div>
			<div class="col-md-2">&nbsp;</div>
		</div>
	</div>
</section>
<?php include_once('footer.php');?>	
</body>
</html>
