<?php 
// require_once('classes/config.php');
// require_once('classes/commonFunctions.php');
include('classes/config.php');
// $obj = new commonFunctions();
$obj = new frontclass();
// $obj2 = new frontclass2();

$page_id = 2;
$arr_page_details = $obj->getFrontPageDetails($page_id);

if($obj->isLoggedIn())
{
	$user_id = $_SESSION['user_id'];
	$obj->updateUserOnlineTimestamp($user_id);
}

if($obj->chkIfCartEmpty())
{
	echo '<script>window.location.href="'.SITE_URL.'"</script>';
	exit(0);
}



if(isset($_POST['login_signup']))	
{
        
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        // die();
    
		$gestid = $_POST['gestid'];
		$ref = $_POST['ref'];
		$name = strip_tags(trim($_POST['signup_first_name']));
		$middle_name = strip_tags(trim($_POST['signup_middle_name']));
		$last_name = strip_tags(trim($_POST['signup_last_name']));
		$email = strip_tags(trim($_POST['signup_email']));
		$mobile = strip_tags(trim($_POST['signup_mobile_no']));
		$city_id = strip_tags(trim($obj->getCityIdbyName($_POST['signup_city'])));
		$place_id = strip_tags(trim($_POST['signup_location']));
		$password = trim($_POST['signup_password']);
		$gender = trim($_POST['sex']);
		$uid = $_POST['uid'];
		$refid = $_POST['refid'];
		$puid = $_POST['puid'];
		$arid = $_POST['arid'];
	
	if($name == '')
	{
		$error = true;
		$err_msg .= '<p>Please enter your name</p>';
	}
	if($middle_name == '')
	{
		$error = true;
		$err_msg .= '<p>Please enter your middle name</p>';
	}
        if($last_name == '')
	{
		$error = true;
		$err_msg .= '<p>Please enter your last name</p>';
	}
        if($gender == '')
	{
		$error = true;
		$err_msg .= '<p>Please select your Gender</p>';
	}
	if($email == '')
	{
		$error = true;
		$err_msg .= '<p>Please enter your email</p>';
	}
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
	//elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
	{
		$error = true;
		$err_msg .= '<p>Please enter valid email</P>';
	}
	elseif($obj->chkEmailExists($email))
	{
		$error = true;
		$err_msg .= '<p>This email is already registered</p>';
	}

	if($mobile == '')
	{
		$error = true;
		$err_msg .= '<p>Please enter your mobile no</p>';
	}
        elseif($obj->chkMobileExists($mobile))
	{
		$error = true;
		$err_msg .= '<p>This mobile no is already registered</p>';
	}

	if($city_id == '')
	{
		$error = true;
		$err_msg .= '<p>Please select your city</p>';
	}

	if($place_id == '')
	{
		$error = true;
		$err_msg .= '<p>Please select your place</p>';
	}


	if($password == '')
	{
		$error = true;
		$err_msg .= '<p>Please enter password</p>';
	}
	elseif(!$obj->chkValidPassword($password))
	{
		$error = true;
		$err_msg .= '<p>Please enter valid Password.<br>Atleast 1 Upper case alphabate[A-Z],<br> 1 Lower case alphabate[a-z] ,<br> 1 Numeric[0-9] ,<br>  1 special characters[!@#$%^&*()-_=+,<>./?]</p>';
	}
	
	if(!$error)
	{
                $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $string_shuffled = str_shuffle($string);
                $otp = substr($string_shuffled, 1, 6);
       if($gestid != '')
          {
		    $signUpUser = $obj->updatesSignUpUserVivek($gestid,$name,$middle_name,$last_name,$gender,$email,$mobile,$city_id,$place_id,$password,$otp);
		  }
       else
          {
		    $signUpUser = $obj->signUpUser($name,$middle_name,$last_name,$gender,$email,$mobile,$city_id,$place_id,$password,$otp);
		  }
                    
                if($signUpUser > 0)
		{
                        
			if($uid != '' && $refid !='' )
			{
                                echo 'Hiii';
                                die();
				$tdata = array();
				$tdata['id'] = $refid;
				$tdata['uid'] = $uid;
				$obj->updatereferafriend($tdata,$email);
			}
			
			if($puid != '' && $arid !='' )
			{
				$obj->updateAdvisorsReferral($arid,$puid,$email);
			}
		
                        if($obj->sendSignUpEmailToUser($email))
                        {
                            header("Location: message.php?msg=1&sess=".base64_encode($email).""); 
                         //echo "<script>window.location.href='message.php?msg=1&sess=".base64_encode($email)."'</script>";
                        }
                       
			$url = SITE_URL.'/validate_user.php?sess='.base64_encode($email).'';
			
			//list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = $obj->getEmailAutoresponderDetails('1');
			$mail_data =$obj->getEmailAutoresponderDetails('1'); 
			$to_email = $email;
			$from_email = $mail_data['email_ar_from_email'];
			$from_name = $mail_data['email_ar_from_name'];
			$subject = $mail_data['email_ar_subject'];
			$message = $mail_data['email_ar_body'];
			
			$message = str_ireplace("[[USER_NAME]]", $name, $message);
			$message = str_ireplace("[[USER_EMAIL]]", $email, $message);
			$message = str_ireplace("[[ANCHER_URL_START]]", '<a href="'.$url.'">', $message);
			$message = str_ireplace("[[ANCHER_URL_END]]", '</a>', $message);
			$message = str_ireplace("[[URL]]", $url, $message);
                        $message = str_ireplace("[[OTP]]", $otp, $message);


			$mail = new PHPMailer();
			$mail->IsHTML(true);
			$mail->Host = "batmobile.websitewelcome.com"; // SMTP server
			$mail->From = $from_email;
			$mail->FromName = $from_name;
			$mail->AddAddress($to_email);
			$mail->Subject = $subject;
			$mail->Body = $message;
			$mail->Send();
			$mail->ClearAddresses();
			header("Location: message.php?msg=1&sess=".base64_encode($email).""); 
             echo "<script>window.location.href='message.php?msg=1&sess=".base64_encode($email)."'</script>";
			$err_msg = $url;                   
		}
		else
		{
			$err_msg = 'There is some problem right now!Please try again later';
		}
	}
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
			<div class="col-md-7 checkout-profile-box">
				<div class="checkout-title">CUSTOMER INFORMATION</div>
				<form name="frmcheckoutlogin" id="frmcheckoutlogin">
					<div id="checkout-accordion">
						<h3 data-corners="false">
							<p style="margin-top: 0px;">Step 1: Customer Profile Details</p>
						<?php
						// if($obj->isLoggedIn())
						//{ ?>
							<!-- <p class="checkout-accordion-sub"><?php echo $_SESSION['user_fullname'];?></p>
							<p class="checkout-accordion-sub"><?php echo $_SESSION['user_email'];?></p> -->
							<!-- <p class="checkout-accordion-sub"><?php echo $_SESSION['name'];?></p> -->
							<!-- <p class="checkout-accordion-sub"><?php echo $_SESSION['email'];?></p> -->
						<?php
						//} ?>					
						</h3>
						<div class="checkout-accordion-content">
						<?php
						if($obj->isLoggedIn())
						 { ?>
							<div class="checkout-loggedin">
								<table class="table table-borderless ">
								<tbody>
									<tr>
										<td class="checkout-loggedin-title">NAME</td>
										<!-- <td><?php echo $_SESSION['user_fullname'];?></td> -->
										<td><?php echo $_SESSION['name'];?></td>
									</tr>
									<tr>
										<td class="checkout-loggedin-title">EMAIL</td>
										<!-- <td><?php echo $_SESSION['user_email'];?></td> -->
										<td><?php echo $_SESSION['email'];?></td>
									</tr>
									<!-- <tr>
										<td class="checkout-loggedin-title">MOBILE NUMBER</td>
										<td><?php //echo $_SESSION['user_mobile_no'];?></td>
									</tr> -->
									<tr>
										<td></td>
										<td><a class="btn-red" href="javascript:operateAccordion(1)">NEXT</a></td>
									</tr>
								</tbody>
								</table>
							</div>
						<?php
						}
						else
						{ ?>
							<div id="checkout-tabs" class="checkout-tabs">
								<ul>
									<li class="col-md-4"><a href="#checkout-login-tab">Log In</a></li>
									<li class="col-md-4"><a href="#checkout-signup-tab">Sign Up</a></li>
									<li class="col-md-4"><a href="#checkout-guest-tab">Guest</a></li>
								</ul>
								<div id="checkout-login-tab">
									<input style="display:none" type="text" name="fakeusernameremembered2" />
									<input style="display:none" type="password" name="fakepasswordremembered2"/>
									<span id="err_msg_login"></span>
									<div class="form-group">
										<input type="text" name="email" id="email" placeholder="Email" class="input-text-box" autocomplete="false">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" placeholder="Password" class="input-text-box" autocomplete="false">
									</div>
									<div class="form-group">
										<a class="btn-red" href="javascript:doCheckoutLogIn();">LOG IN</a>&nbsp;&nbsp;&nbsp;<a class="link-red" href="<?php echo SITE_URL.'/forgot_password.php'?>">Forgot Password?</a>
									</div>	
								</div>
								<div id="checkout-signup-tab">
									<input style="display:none" type="text" name="fakeusernameremembered" />
									<input style="display:none" type="password" name="fakepasswordremembered"/>
									<span id="err_msg_signup"></span>
									<div id="signup-box">




                                       
                             <form name="frm_signup" id="frm_signup" method="post">                                  
								<!-- <div id="checkout-signup-tab"> -->
									<!-- <input style="display:none" type="text" name="fakeusernameremembered" /> -->
									<!-- <input style="display:none" type="password" name="fakepasswordremembered"/> -->
								  	<!-- <span id="err_msg_signup"></span> -->

									<!-- <div id="signup-box"> -->
										<div class="form-group">
                                            <input required="" type="text" name="signup_first_name" id="signup_first_name" placeholder="First Name" class="input-text-box input-half-width" autocomplete="false">
                                             <input required="" type="text" name="signup_middle_name" id="signup_middle_name" placeholder="Middle Name" class="input-text-box input-half-width" autocomplete="false">
											
										</div>
                                               <div class="form-group">
                                                <input type="text" name="signup_last_name" id="signup_last_name" placeholder="Last Name" class="input-text-box input-half-width" autocomplete="false">
                                                    Gender: &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="sex" id="sex" value="Male"> 
                                                    Male &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="sex" id="sex" value="Female">
                                                     Female
                                               </div>


										<div class="form-group">
											<input type="text" required="" name="signup_email" id="signup_email" placeholder="Email" class="input-text-box" autocomplete="false">
										</div>



										<div class="form-group">
                                            <input type="text" required="" onKeyPress="return isNumberKey(event);" maxlength="10" name="signup_mobile_no" id="signup_mobile_no" placeholder="10 digit Mobile Number" class="input-text-box" autocomplete="false">
                                        </div>


                                <div class="form-group">
                                    <input type="text" required="" name="signup_city" id="signup_city" placeholder="Select your city" list="capitals" class="input-text-box input-half-width" onchange="getlocation();" />
                                        <datalist id="capitals">
                                            <?php echo $obj->getCityOptions(); ?>
                                        </datalist>
<!--<input type="text" name="signup_city" id="signup_city" placeholder="City" class="input-text-box input-half-width" autocomplete="false">-->
                                        <select required="" class="input-text-box input-half-width" name="signup_location" id="signup_location">
                                            <option value="">Select your location</option>
                                        </select>

                                  </div>

								<div class="form-group">
								<input required="" type="password" name="signup_password" id="signup_password" placeholder="Password" class="input-text-box" autocomplete="false">
								  <p style="font-size: 12px; color: brown;">Password Atleast 1 Upper case alphabate[A-Z], 1 Lower case alphabate[a-z] , 1 Numeric[0-9] , 1 special characters[!@#$%^&*()-_=+,<>./?]</p>
								</div>


                              <div class="form-group">
                                  <hr>
                                  <span>By clicking the "I accept. Create My Account" below, I certify that I have read and agree to the <a href="terms_and_conditions.php" target="_blank" style="color:blue;">Terms & Conditions of Service </a> below and both the <a href="disclaimer.php" target="_blank" style="color:blue;">Disclaimer Policy</a> and the <a href="privacy_policy.php" target="_blank" style="color:blue;">Privacy Policy</a>.</span>
                              </div>

                                           <!-- <div class="form-group"> -->
                                          <!-- <button type="submit" class="btn-red" name="login_signup" id="login_signup" >I accept. Create My Account</button></div>	 -->

                                          	<div class="form-group">
										        	<a class="btn-red" href="javascript:doCheckoutSignUp()">SIGN UP</a>
										      </div>	 
									<!-- </div> -->
										
								<!-- </div> -->
                              </form>




										<!-- <div class="form-group">
											<input type="text" name="signup_first_name" id="signup_first_name" placeholder="First Name" class="input-text-box input-half-width" autocomplete="false">
											<input type="text" name="signup_last_name" id="signup_last_name" placeholder="Last Name" class="input-text-box input-half-width input-half-second-column" autocomplete="false">
										</div>
										<div class="form-group">
											<input type="text" name="signup_email" id="signup_email" placeholder="Email" class="input-text-box" autocomplete="false">
										</div>
										<div class="form-group">
											<input type="text" name="signup_mobile_no" id="signup_mobile_no" placeholder="10 digit Mobile Number" class="input-text-box" autocomplete="false">
										</div>
										<div class="form-group">
											<input type="password" name="signup_password" id="signup_password" placeholder="Password" class="input-text-box" autocomplete="false">
										</div>
										<div class="form-group">
											<a class="btn-red" href="javascript:doCheckoutSignUp()">SIGN UP</a>
										</div>	 -->



									</div>
									<div id="verify-otp-box"  style="display:none;">
										<div class="form-group">
											<p>We have sent 4 digits otp at your registered mobile number.</p>
											<p>Please enter the correct otp to proceed.</p>
										</div>
										<div class="form-group">
											<input type="text" name="user_otp" id="user_otp" placeholder="4 digits otp" class="input-text-box" autocomplete="false">
										</div>
										<div class="form-group">
											<a class="btn-red" href="javascript:doVerifyOTP()">Verify Mobile No</a>&nbsp;Or&nbsp;<a class="link-red" href="javascript:reSendOTP()">Resend OTP</a>
										</div>	
									</div>
									
								</div>
								<div id="checkout-guest-tab">
									<span id="err_msg_guest"></span>
									<div id="guest-box">
										<div class="form-group">
											<input type="text" name="guest_name" id="guest_name" placeholder="Name" class="input-text-box" autocomplete="false">
										</div>
										<div class="form-group">
											<input type="text" name="guest_email" id="guest_email" placeholder="Email" class="input-text-box" autocomplete="false">
										</div>
										<div class="form-group">
											<input type="text" name="guest_mobile" id="guest_mobile" placeholder="10 digit Mobile Number" class="input-text-box" autocomplete="false">
										</div>
										<div class="form-group">
											<a class="btn-red" href="javascript:doCheckoutSignUpGuest()">SAVE AND CONTINUE</a>
										</div>	
									</div>	
									<div id="guest-verify-otp-box"  style="display:none;">
										<div class="form-group">
											<p>We have sent 4 digits otp at your registered mobile number.</p>
											<p>Please enter the correct otp to proceed.</p>
										</div>
										<div class="form-group">
											<input type="text" name="guest_otp" id="guest_otp" placeholder="4 digits otp" class="input-text-box" autocomplete="false">
										</div>
										<div class="form-group">
											<a class="btn-red" href="javascript:doVerifyOTPGuest()">Verify Mobile No</a>&nbsp;Or&nbsp;<a class="link-red" href="javascript:reSendOTPGuest()">Resend OTP</a>
										</div>	
									</div>	
								</div>
							</div>
						<?php	
						} ?>	
							
						</div>
						<h3>
							<p style="margin-top: 0px;">Step 2: Billing/Delivery Address Details</p>
							<p class="sub"></p>
						</h3>
						<div class="checkout-accordion-content">
							<div id="checkout-delivery-box">
								<?php


								$msg_edit_details_delivery = '';
								$msg_edit_details_billing = '';
								if($obj->isLoggedIn())
								{
									$arr_user_detail = $obj->getUserDetails($user_id);
                                     // echo "<pre>";print_r($arr_user_detail);echo "</pre>";
									$delivery_name = $arr_user_detail['delivery_name'];
									$delivery_building_name = $arr_user_detail['building_name'];
									$delivery_floor_no = $arr_user_detail['floor_no'];
									$delivery_address_line1 = $arr_user_detail['address'];
									$delivery_landmark = $arr_user_detail['landmark'];
									$delivery_mobile_no = $arr_user_detail['delivery_mobile_no'];
									$delivery_pincode = $arr_user_detail['pincode'];
									
									if($delivery_building_name == '')
									{
										$msg_edit_details_delivery = '';
									}
									else
									{
										$msg_edit_details_delivery = 'You can edit your delivery address';
									}
									
									if($delivery_name == '')
									{
										$delivery_name = $arr_user_detail['first_name'];
										if($arr_user_detail['last_name'] != '')
										{
											$delivery_name .= ' '.$arr_user_detail['last_name'];	
										}
									}
									
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
									
									if($delivery_mobile_no == '')
									{
										$delivery_mobile_no = $_SESSION['user_mobile_no'];
									}
									
									$billing_name = $arr_user_detail['billing_name'];
									$billing_building_name = $arr_user_detail['billing_building_name'];
									$billing_floor_no = $arr_user_detail['billing_floor_no'];
									$billing_address_line1 = $arr_user_detail['billing_address'];
									$billing_landmark = $arr_user_detail['billing_landmark'];
									$billing_mobile_no = $arr_user_detail['billing_mobile_no'];
									$billing_pincode = $arr_user_detail['billing_pincode'];
									
									if($billing_building_name == '')
									{
										$msg_edit_details_billing = '';
									}
									else
									{
										$msg_edit_details_billing = 'You can edit your billing address';
									}
									
									if($billing_name == '')
									{
										$billing_name = $delivery_name;
									}
									
									if($arr_user_detail['billing_city_id'] == '0' || $arr_user_detail['billing_city_id'] == '' )
									{
										$billing_city_id = $delivery_city_id;
									}
									else
									{
										$billing_city_id = $arr_user_detail['billing_city_id'];	
									}
									
									if($arr_user_detail['billing_area_id'] == '0' || $arr_user_detail['billing_area_id'] == '' )
									{
										$billing_area_id = $delivery_area_id;
									}
									else
									{
										$billing_area_id = $arr_user_detail['billing_area_id'];	
									}
									
									if($billing_building_name == '')
									{
										$billing_building_name = $delivery_building_name;
									}
									
									if($billing_floor_no == '')
									{
										$billing_floor_no = $delivery_floor_no;
									}
									
									if($billing_address_line1 == '')
									{
										$billing_address_line1 = $delivery_address_line1;
									}
									
									if($billing_landmark == '')
									{
										$billing_landmark = $delivery_landmark;
									}
									
									if($billing_mobile_no == '')
									{
										$billing_mobile_no = $delivery_mobile_no;
									}
									
									if($billing_city_id == '')
									{
										$billing_city_id = $delivery_city_id;
										$billing_area_id = $delivery_area_id;
									}
									else
									{
										if($billing_city_id == $delivery_city_id)
										{
											if($billing_area_id == '')
											{
												$billing_area_id = $delivery_area_id;
											}	
										}
									}
								}
								else
								{
									$delivery_building_name = '';
									$delivery_name = '';
									$delivery_floor_no = '';
									$delivery_address_line1 = '';
									$delivery_landmark = '';
									$delivery_city_id = $topcityid;
									$delivery_area_id = $topareaid;
									$delivery_mobile_no = '';
									$delivery_pincode = '';
									
									$billing_building_name = '';
									$billing_name = '';
									$billing_floor_no = '';
									$billing_address_line1 = '';
									$billing_landmark = '';
									$billing_city_id = $topcityid;
									$billing_area_id = $topareaid;
									$billing_mobile_no = '';
									$billing_pincode = '';
								}
								
								$delivery_locationstr = $obj->getTopLocationStr($delivery_city_id,$delivery_area_id);
								$delivery_pincode = $obj->getPincodeOfArea($delivery_area_id);
								
								$billing_locationstr = $obj->getTopLocationStr($billing_city_id,$billing_area_id);
								$billing_pincode = $obj->getPincodeOfArea($billing_area_id);
								?>
								<span id="err_msg_delivery"></span>
								<ul>
									<li class="col-md-6"><a href="#checkout-delivery-tab">Delivery Details</a></li>
									<li class="col-md-6"><a href="#checkout-billing-tab">Billing Details</a></li>
								</ul>
								<div id="checkout-delivery-tab">
									<div class="form-group">
										<p class="note_msg"><?php echo $msg_edit_details_delivery;?></p>
									</div>
									<div class="form-group">
										<input type="text" name="delivery_name" id="delivery_name" placeholder="Delivery Name" value="<?php echo $delivery_name;?>" class="input-text-box" autocomplete="false">
									</div>
									<div class="form-group">
										<input type="text" name="delivery_building_name" id="delivery_building_name" placeholder="Flat number/House number,building name" value="<?php echo $delivery_building_name;?>" class="input-text-box input-half-width" autocomplete="false">
										<input type="text" name="delivery_floor_no" id="delivery_floor_no" placeholder="Floor number" value="<?php echo $delivery_floor_no;?>" class="input-text-box input-half-width input-half-second-column" autocomplete="false">
									</div>
									<div class="form-group">
										<input type="text" name="delivery_address_line1" id="delivery_address_line1" placeholder="Address line 1" value="<?php echo $delivery_address_line1;?>" class="input-text-box" autocomplete="false">
									</div>
									<div class="form-group">
										<input type="text" name="delivery_landmark" id="delivery_landmark" placeholder="Landmark" value="<?php echo $delivery_landmark;?>" class="input-text-box" autocomplete="false">
									</div>
									<div class="form-group">
										<input type="hidden" name="hdndelivery_city_id" id="hdndelivery_city_id" value="<?php echo $delivery_city_id;?>">
										<input type="hidden" name="hdndelivery_area_id" id="hdndelivery_area_id" value="<?php echo $delivery_area_id;?>">
										<a id="btnTopLocation2" href="#animatedModalLocation2">
											<input type="text" readonly name="delivery_location" id="delivery_location" placeholder="Area,City" value="<?php echo $delivery_locationstr;?>" class="input-text-box" autocomplete="false">
											<br><span class="small_note">(Click here to change your Delivery Area/City)</span>		
										</a>
										
										<div id="animatedModalLocation2" style="display:none;">
											<!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
											<div class="close_anim_model">
												<div class="close-animatedModalLocation2">X</div>
											</div>
											<div class="modal-content-loc">
												<div class="modal-content-inner">	
													<div class="row">
														<div class="col-md-12 col-sm-12">
															<h4 align="center">Select Your Location</h4>
														</div>
													</div>	
													<div class="row">
														<div class="col-md-12 col-sm-12" style="min-height:35px;">
															<span id="err_msg_deliverypopup"></span>
														</div>
													</div>	
													<div class="row" style="margin-bottom:10px;">
														<div class="col-md-12 col-sm-12">
															<select name="select_your_city2" id="select_your_city2" onchange="getDeliveryAreaOption()" multiple >
																<?php 
																// $obj_loc2 = new commonFunctions();
																echo $obj->getAllLocationsOption($delivery_city_id);	
																?>	
															</select>
														</div>
														
													</div>	
													<div class="row" style="margin-bottom:10px;">
														<div class="col-md-12 col-sm-12">
															<select name="select_your_area2" id="select_your_area2" multiple >
																<?php 
																echo $obj->getTopAreaOption($delivery_city_id,$delivery_area_id);	
																?>	
															</select>
														</div>
													</div>	
													<div class="row">	
														<div class="col-md-12 col-sm-12">
															<button type="button" name="btnSelectYourLocation2" id="btnSelectYourLocation2" onclick="setDeliveryLocation()" class="btnoval">Select</button>
														</div>	
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<input readonly type="text" name="delivery_pincode" id="delivery_pincode" placeholder="Pincode" value="<?php echo $delivery_pincode;?>" class="input-text-box" autocomplete="false">
									</div>
									<div class="form-group">
										<input type="text" name="delivery_mobile_no" id="delivery_mobile_no" placeholder="10 digit Mobile Number" value="<?php echo $delivery_mobile_no;?>" class="input-text-box" autocomplete="false">
									</div>	
									<div class="form-group">
										<a class="btn-red" href="javascript:operateAccordion(0)">BACK</a>
										<a class="btn-red" href="javascript:doCheckoutSaveDeliveryAddress()">SAVE AND CONTINUE</a>
									</div>	
								</div>

<!-- -------------------------------------------------- -->

								<div id="checkout-billing-tab">
									<span id="err_msg_billing"></span>
									<div class="form-group">
										<p class="note_msg"><?php echo $msg_edit_details_billing;?></p>
									</div>
									<div class="form-group">
										<input type="text" name="billing_name" id="billing_name" placeholder="Billing Name" value="<?php echo $billing_name;?>" class="input-text-box" autocomplete="false">
									</div>
									<div class="form-group">
										<input type="text" name="billing_building_name" id="billing_building_name" placeholder="Flat number/House number,building name" value="<?php echo $billing_building_name;?>" class="input-text-box input-half-width" autocomplete="false">
										<input type="text" name="billing_floor_no" id="billing_floor_no" placeholder="Floor number" value="<?php echo $billing_floor_no;?>" class="input-text-box input-half-width input-half-second-column" autocomplete="false">
									</div>
									<div class="form-group">
										<input type="text" name="billing_address_line1" id="billing_address_line1" placeholder="Address line 1" value="<?php echo $billing_address_line1;?>" class="input-text-box" autocomplete="false">
									</div>
									<div class="form-group">
										<input type="text" name="billing_landmark" id="billing_landmark" placeholder="Landmark" value="<?php echo $billing_landmark;?>" class="input-text-box" autocomplete="false">
									</div>
									<div class="form-group">
										<input type="hidden" name="hdnbilling_city_id" id="hdnbilling_city_id" value="<?php echo $billing_city_id;?>">
										<input type="hidden" name="hdnbilling_area_id" id="hdnbilling_area_id" value="<?php echo $billing_area_id;?>">
										<a id="btnTopLocation4" href="#animatedModalLocation4">
											<input type="text" readonly name="billing_location" id="billing_location" placeholder="Area,City" value="<?php echo $billing_locationstr;?>" class="input-text-box" autocomplete="false">
											<br><span class="small_note">(Click here to change your Billing Area/City)</span>		
										</a>	
										<div id="animatedModalLocation4" style="display:none;">
											<!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
											<div class="close_anim_model">
												<div class="close-animatedModalLocation4">X</div>
											</div>
											<div class="modal-content-loc">
												<div class="modal-content-inner">	
													<div class="row">
														<div class="col-md-12 col-sm-12">
															<h4 align="center">Select Your Location</h4>
														</div>
													</div>	
													<div class="row">
														<div class="col-md-12 col-sm-12" style="min-height:35px;">
															<span id="err_msg_billingpopup"></span>
														</div>
													</div>	
													<div class="row" style="margin-bottom:10px;">
														<div class="col-md-12 col-sm-12">
															<select name="select_your_city4" id="select_your_city4" onchange="getBillingAreaOption()" multiple >
																<?php 
																// $obj_loc2 = new commonFunctions();
																echo $obj->getAllLocationsOption($billing_city_id);	
																?>	
															</select>
														</div>
														
													</div>	
													<div class="row" style="margin-bottom:10px;">
														<div class="col-md-12 col-sm-12">
															<select name="select_your_area4" id="select_your_area4" multiple >
																<?php 
																echo $obj->getTopAreaOption($billing_city_id,$billing_area_id);	
																?>	
															</select>
														</div>
													</div>	
													<div class="row">	
														<div class="col-md-12 col-sm-12">
															<button type="button" name="btnSelectYourLocation4" id="btnSelectYourLocation4" onclick="setBillingLocation()" class="btnoval">Select</button>
														</div>	
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<input readonly type="text" name="billing_pincode" id="billing_pincode" placeholder="Pincode" value="<?php echo $billing_pincode;?>" class="input-text-box" autocomplete="false">
									</div>
									<div class="form-group">
										<input type="text" name="billing_mobile_no" id="billing_mobile_no" placeholder="10 digit Mobile Number" value="<?php echo $billing_mobile_no;?>" class="input-text-box" autocomplete="false">
									</div>	
									<div class="form-group">
										<a class="btn-red" href="javascript:operateAccordion(0)">BACK</a>
										<a class="btn-red" href="javascript:doCheckoutSaveDeliveryAddress()">SAVE AND CONTINUE</a>
									</div>	
								</div>

<!-- ---------------------------------------------- -->








							</div>
							
						</div>
						<h3>
							<p style="margin-top: 0px;">Step 3: Proceed to Payment</p>
							<p class="sub"></p>
						</h3>
						<div class="checkout-accordion-content">
							<div id="checkout-delivery-box">
								<div class="form-group">
									<a class="btn-red" href="javascript:operateAccordion(1)">BACK</a>
								<?php
								if($obj->isLoggedIn())
								{ ?>	
									<a class="btn-red" href="javascript:doCheckoutProceedToPayment()">PROCEED TO PAYMENT</a>
								<?php
								}
								else
								{ ?>
									<a class="btn-red" href="javascript:doCheckoutProceedToPayment()">PROCEED TO PAYMENT</a>
								<?php	
								} ?>									
								</div>	
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-1">&nbsp;</div>
			<div class="col-md-4 checkout-order-box">
				<div class="checkout-title">ORDER SUMMARY</div>
				<div id="checkout-cart-box" class="checkout-cart-box">
					<?php echo $obj->getSideCartBoxCheckout();?>
				</div>	
				<div class="checkout-help">
					<h4>NEED HELP WITH PLACING YOUR ORDER?</h4>
					<div class="box">
						<h6>Reach out to us on</h6>
						<a href="tel:91-8828033111">91-8828033111</a>
						<p>Lines open from 8:00 AM to 11:00 PM</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include_once('footer.php');?>	
</body>
</html>
