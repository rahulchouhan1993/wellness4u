<?php 
// require_once('classes/config.php');
// require_once('classes/commonFunctions.php');
include('classes/config.php');

// $obj = new commonFunctions();
$obj = new frontclass();
$obj2 = new frontclass2();

$page_id = 7;
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
					<div>
						<h3 data-corners="false">
							<p style="margin-top: 0px;">Profile Details</p>
						</h3>
						<div>
							<div class="checkout-loggedin">
								<table class="table table-borderless ">
								<tbody>
									<tr>
										<td class="checkout-loggedin-title">NAME</td>
										<td><?php echo $_SESSION['name'];?></td>
									</tr>
									<tr>
										<td class="checkout-loggedin-title">EMAIL</td>
										<td><?php echo $_SESSION['email'];?></td>
									</tr>
									<!-- <tr>
										<td class="checkout-loggedin-title">MOBILE NUMBER</td>
										<td><?php //echo $_SESSION['user_mobile_no'];?></td>
									</tr> -->
									<tr>
										<td></td>
										<td><a class="btn-red" href="<?php echo SITE_URL.'/edit_profile.php';?>">EDIT PROFILE</a></td>
									</tr>
								</tbody>
								</table>
							</div>
						</div>
						<h3>
							<p style="margin-top: 0px;">Delivery Address Details</p>
						</h3>
						<div>
							<div>
								
								<input style="display:none" type="text" name="fakeusernameremembered" />
								<input style="display:none" type="password" name="fakepasswordremembered"/>
								<?php
								$arr_user_detail = $obj->getUserDetails($user_id);
								$delivery_building_name = $arr_user_detail['building_name'];
								$delivery_floor_no = $arr_user_detail['floor_no'];
								$delivery_address_line1 = $arr_user_detail['address'];
								$delivery_landmark = $arr_user_detail['landmark'];
								$delivery_mobile_no = $arr_user_detail['delivery_mobile_no'];
								$delivery_pincode = $arr_user_detail['pincode'];
								
								if($arr_user_detail['city_id'] == '0' || $arr_user_detail['city_id'] == '' )
								{
									$delivery_city_id = $topcityid;
								}
								else
								{
									$delivery_city_id = $arr_user_detail['city_id'];	
								}
								
								if($arr_user_detail['area_id'] == '0' || $arr_user_detail['area_id'] == '' )
								{
									$delivery_area_id = $topareaid;
								}
								else
								{
									$delivery_area_id = $arr_user_detail['area_id'];	
								}
								
								$delivery_locationstr = $obj->getTopLocationStr($delivery_city_id,$delivery_area_id);
								?>
								
								<?php if($delivery_building_name != ''){?><p><?php echo $delivery_building_name.', '.$delivery_floor_no;?><br></p><?php } ?>
								<?php if($delivery_address_line1 != ''){?><p><?php echo $delivery_address_line1;?></p><?php } ?>
								<?php if($delivery_locationstr != ''){?><p><?php echo $delivery_locationstr;?></p><?php } ?>
								<?php if($delivery_pincode != ''){?><p>Pincode:<?php echo $delivery_pincode;?></p><?php } ?>
								<?php if($delivery_mobile_no != ''){?><p>Mobile:<?php echo $delivery_mobile_no;?></p><?php } ?>
								<?php if($delivery_landmark != ''){?><p>Landmark:<?php echo $delivery_landmark;?></p><?php } ?>
								
							</div>
						</div>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</section>
<?php include_once('footer.php');?>	
</body>
</html>
