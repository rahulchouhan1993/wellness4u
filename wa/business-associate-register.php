<?php 
require_once('classes/config.php');

$obj = new commonFunctions();
$page_id = 6;
$arr_page_details = $obj->getFrontPageDetails($page_id);

if(isset($_GET['ref_url']) && $_GET['ref_url'] != '')
{
	$ref_url = $_GET['ref_url'];
	$register_ref_url = '?ref_url='.$ref_url;
}
else
{
	$ref_url = '';
	$register_ref_url = '';
}
/*
if($obj->isUserLoggedIn())
{
	if(isset($ref_url) && $ref_url != '')
	{
		$ref_url_go = urldecode(base64_decode($ref_url));
		echo '<script>window.location.href="'.$ref_url_go.'"</script>';
		exit(0);
	}
	else
	{
		echo '<script>window.location.href="'.SITE_URL.'/my_account.php"</script>';
		exit(0);
	}
}
*/
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
			<div class="col-md-2">&nbsp;</div>
			<div class="col-md-8">
				<form name="frmlogin" id="frmlogin">
					<input type="hidden" name="ref_url" id="ref_url" value="<?php echo $ref_url;?>" >
					<div id="checkout-accordion">
						<h3 data-corners="false">
							<p style="margin-top: 0px;">Business Associate Register</p>
						</h3>
						<div class="checkout-accordion-content">
							<div id="checkout-tabs" class="checkout-tabs">
								<ul>
									<li class="col-md-4"><a href="#checkout-signup-tab">Sign Up</a></li>
								</ul>
								<div id="checkout-signup-tab">
									<span id="err_msg_signup"></span>
									<div id="signup-box">
										<div class="form-group">
											<select name="va_cat_id" id="va_cat_id" class="input-text-box">
												<?php echo $obj->getVendorAccessCategoryOption(''); ?>	
											</select>
										</div>
										<div class="form-group">
											<a class="btn-red" href="javascript:doVendorRegistrationProceed()">PROCEED</a>
										</div>	
									</div>
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
