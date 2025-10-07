<?php
include_once('classes/config.php');
$obj_comm = new commonFunctions();

$action = $_REQUEST['action'];
$test = '';
if($action == 'settoplocation')
{
	$topcityid = '';
	if(isset($_POST['topcityid']) && trim($_POST['topcityid']) != '')
	{
		$topcityid = trim($_POST['topcityid']);
	}
	
	$topareaid = '';
	if(isset($_POST['topareaid']) && trim($_POST['topareaid']) != '')
	{
		$topareaid = trim($_POST['topareaid']);
	}
	
	$error = 0;
	$err_msg = '';
	if($topcityid == '' || $topcityid == 'null')
	{
		$error = 1;
		$err_msg = 'Please enter city';
	}
	else
	{
		if($obj_comm->chkIfValidCityId($topcityid))
		{
			
			if($topareaid =='')
			{
				$_SESSION['topcityid'] = $topcityid;
				$_SESSION['topareaid'] = $topareaid;
				$toplocationstr = $obj_comm->getTopLocationStr($topcityid,$topareaid);
				$_SESSION['toplocationstr'] = $toplocationstr;	
			}
			else
			{
				if($obj_comm->chkIfValidAreaId($topareaid))
				{
					$_SESSION['topcityid'] = $topcityid;
					$_SESSION['topareaid'] = $topareaid;
					$toplocationstr = $obj_comm->getTopLocationStr($topcityid,$topareaid);
					$_SESSION['toplocationstr'] = $toplocationstr;	
				}					
				else
				{
					$error = 1;
					$err_msg = 'Invalid area';
				}
			}
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid city';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.SITE_URL;
	echo $ret_str;
}
elseif($action == 'setdeliverylocation')
{
	$deliverycityid = '';
	if(isset($_POST['deliverycityid']) && trim($_POST['deliverycityid']) != '')
	{
		$deliverycityid = trim($_POST['deliverycityid']);
	}
	
	$deliveryareaid = '';
	if(isset($_POST['deliveryareaid']) && trim($_POST['deliveryareaid']) != '')
	{
		$deliveryareaid = trim($_POST['deliveryareaid']);
	}
	
	$error = 0;
	$err_msg = '';
	$deliverylocationstr = '';
	$deliverypincode = '';
	
	if($deliverycityid == '' || $deliverycityid == 'null')
	{
		$error = 1;
		$err_msg = 'Please enter delivery city/town';
	}
	elseif($deliveryareaid == '' || $deliveryareaid == 'null')
	{
		$error = 1;
		$err_msg = 'Please enter delivery area';
	}
	else
	{
		if($obj_comm->chkIfValidCityId($deliverycityid))
		{
			if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
			{
				$topcityid = $_SESSION['topcityid'];
			}
			else
			{
				$topcityid = '0';
			}
			
			if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
			{
				$topareaid = $_SESSION['topareaid'];
			}
			else
			{
				$topareaid = '0';
			}
			
			if($deliverycityid != $topcityid)
			{
				$error = 1;
				$err_msg = 'Sorry this item(s) currently not avilable in city/town which you selected for delivery';
			}
			else
			{
				if($deliveryareaid =='')
				{
					$deliverylocationstr = $obj_comm->getTopLocationStr($deliverycityid,$deliveryareaid);
				}
				else
				{
					if($obj_comm->chkIfValidAreaId($deliveryareaid))
					{
						$deliverylocationstr = $obj_comm->getTopLocationStr($deliverycityid,$deliveryareaid);
						$deliverypincode = $obj_comm->getPincodeOfArea($deliveryareaid);
						/*
						if($topareaid != '' && $topareaid != '0' && $topareaid != '-1')
						{
							if($deliveryareaid != '' && $deliveryareaid != '0' && $deliveryareaid != $topareaid)
							{
								$error = 1;
								$err_msg = 'Sorry this item(s) currently not avilable in area of city/town which you selected for delivery';
							}
						}
						*/						
					}					
					else
					{
						$error = 1;
						$err_msg = 'Invalid area';
					}
				}
			}
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid city';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$deliverylocationstr.'::::'.$deliverypincode;
	echo $ret_str;
}
elseif($action == 'setbillinglocation')
{
	$deliverycityid = '';
	if(isset($_POST['deliverycityid']) && trim($_POST['deliverycityid']) != '')
	{
		$deliverycityid = trim($_POST['deliverycityid']);
	}
	
	$deliveryareaid = '';
	if(isset($_POST['deliveryareaid']) && trim($_POST['deliveryareaid']) != '')
	{
		$deliveryareaid = trim($_POST['deliveryareaid']);
	}
	
	$error = 0;
	$err_msg = '';
	$deliverylocationstr = '';
	$deliverypincode = '';
	
	if($deliverycityid == '' || $deliverycityid == 'null')
	{
		$error = 1;
		$err_msg = 'Please enter billing city/town';
	}
	elseif($deliveryareaid == '' || $deliveryareaid == 'null')
	{
		$error = 1;
		$err_msg = 'Please enter billing area';
	}
	else
	{
		if($obj_comm->chkIfValidCityId($deliverycityid))
		{
			if($deliveryareaid =='')
			{
				$deliverylocationstr = $obj_comm->getTopLocationStr($deliverycityid,$deliveryareaid);
			}
			else
			{
				if($obj_comm->chkIfValidAreaId($deliveryareaid))
				{
					$deliverylocationstr = $obj_comm->getTopLocationStr($deliverycityid,$deliveryareaid);
					$deliverypincode = $obj_comm->getPincodeOfArea($deliveryareaid);
				}					
				else
				{
					$error = 1;
					$err_msg = 'Invalid area';
				}
			}
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid city';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$deliverylocationstr.'::::'.$deliverypincode;
	echo $ret_str;
}
elseif($action == 'setcontactuslocation')
{
	$contactus_city_id = '';
	if(isset($_POST['contactus_city_id']) && trim($_POST['contactus_city_id']) != '')
	{
		$contactus_city_id = trim($_POST['contactus_city_id']);
	}
	
	$contactus_area_id = '';
	if(isset($_POST['contactus_area_id']) && trim($_POST['contactus_area_id']) != '')
	{
		$contactus_area_id = trim($_POST['contactus_area_id']);
	}
	
	$error = 0;
	$err_msg = '';
	$contactuslocationstr = '';
	
	
	if($contactus_city_id == '' || $contactus_city_id == 'null')
	{
		$error = 1;
		$err_msg = 'Please enter city';
	}
	else
	{
		if($obj_comm->chkIfValidCityId($contactus_city_id))
		{
			if($contactus_area_id =='')
			{
				$contactuslocationstr = $obj_comm->getTopLocationStr($contactus_city_id,$contactus_area_id);
			}
			else
			{
				if($obj_comm->chkIfValidAreaId($contactus_area_id))
				{
					$contactuslocationstr = $obj_comm->getTopLocationStr($contactus_city_id,$contactus_area_id);
				}					
				else
				{
					$error = 1;
					$err_msg = 'Invalid area';
				}
			}
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid city';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$contactuslocationstr;
	echo $ret_str;
}
elseif($action == 'gettopareaoption')
{
	$topcityid = trim($_REQUEST['topcityid']);
	$topareaid = trim($_REQUEST['topareaid']);
	    
	$data = $obj_comm->getTopAreaOption($topcityid,$topareaid);
    echo $data;
}
elseif($action=='setcurrentshowingdate')
{
	$date = '';
	if(isset($_POST['date']) && trim($_POST['date']) != '')
	{
		$date = trim($_POST['date']);
	}
	
	$regionstr = '';
	if(isset($_POST['regionstr']) && trim($_POST['regionstr']) != '')
	{
		$regionstr = trim($_POST['regionstr']);
	}
	
	$error = 0;
	$err_msg = '';
	$_SESSION['current_showing_date'] = $date;
	
	if($regionstr != '')
	{
		$returl = SITE_URL.'/cusines.php#'.$regionstr;
	}
	else
	{
		$returl = SITE_URL.'/cusines.php';	
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$returl;
	echo $ret_str;
}
elseif($action=='addtocart')
{
	$cusine_id = '';
	if(isset($_POST['cusine_id']) && trim($_POST['cusine_id']) != '')
	{
		$cusine_id = trim($_POST['cusine_id']);
	}
	
	$qty = '';
	if(isset($_POST['qty']) && trim($_POST['qty']) != '')
	{
		$qty = trim($_POST['qty']);
	}
	
	$cusine_area_id = '';
	if(isset($_POST['cusine_area_id']) && trim($_POST['cusine_area_id']) != '')
	{
		$cusine_area_id = trim($_POST['cusine_area_id']);
	}
	
	$cusine_delivery_date = '';
	if(isset($_POST['cusine_delivery_date']) && trim($_POST['cusine_delivery_date']) != '')
	{
		$cusine_delivery_date = trim($_POST['cusine_delivery_date']);
	}
	
	$error = 0;
	$err_msg = '';
	
	if($cusine_id != '')
	{
		if($qty != '')
		{
			if($obj_comm->chkIfCusineQtyAvailable($cusine_id,$qty))
			{
				if($obj_comm->addToCart($cusine_id,$qty,$cusine_area_id,$cusine_delivery_date))
				{
					$error = 0;
					$err_msg = 'Item added successfully';
				}
				else
				{
					$error = 1;
					$err_msg = 'Something went wrong, Please try again later.';
				}	
			}
			else
			{
				$error = 1;
				$err_msg = 'Sorry currently this quantity not available';
			}	
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid quantity';
		}			
	}
	else
	{
		$error = 1;
		$err_msg = 'Please select any item';
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg;
	echo $ret_str;
}
elseif($action=='getsidecartbox')
{
	$output = $obj_comm->getSideCartBox();
	$ret_str = $test.'::::'.$output;
	echo $ret_str;
}
elseif($action=='getsidecartboxcheckout')
{
	$output = $obj_comm->getSideCartBoxCheckout();
	$ret_str = $test.'::::'.$output;
	echo $ret_str;
}
elseif($action=='removefromcart')
{
	$cart_id = '';
	if(isset($_POST['cart_id']) && trim($_POST['cart_id']) != '')
	{
		$cart_id = trim($_POST['cart_id']);
	}
	
	$error = 0;
	$err_msg = '';
	
	if($cart_id != '')
	{
		if($obj_comm->removeFromCart($cart_id))
		{
			$error = 0;
			$err_msg = 'Item removed successfully';
		}
		else
		{
			$error = 1;
			$err_msg = 'Something went wrong, Please try again later.';
		}
	}
	else
	{
		$error = 1;
		$err_msg = 'Please select any item';
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg;
	echo $ret_str;
}
elseif($action=='updatecartsingleitem')
{
	$cusine_id = '';
	if(isset($_POST['cusine_id']) && trim($_POST['cusine_id']) != '')
	{
		$cusine_id = trim($_POST['cusine_id']);
	}
	
	$qty = '';
	if(isset($_POST['qty']) && trim($_POST['qty']) != '')
	{
		$qty = trim($_POST['qty']);
	}
	
	$delivery_date = '';
	if(isset($_POST['delivery_date']) && trim($_POST['delivery_date']) != '')
	{
		$delivery_date = trim($_POST['delivery_date']);
	}
	
	$error = 0;
	$err_msg = '';
	
	if($cusine_id != '')
	{
		if($qty != '')
		{
			if($obj_comm->chkIfCusineQtyAvailable($cusine_id,$qty))
			{
				if($obj_comm->updateCartSingleItem($cusine_id,$qty,$delivery_date))
				{
					$error = 0;
					$err_msg = 'Item updated successfully';
				}
				else
				{
					$error = 1;
					$err_msg = 'Something went wrong, Please try again later.';
				}	
			}
			else
			{
				$error = 1;
				$err_msg = 'Sorry currently this quantity not available';
			}	
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid quantity';
		}			
	}
	else
	{
		$error = 1;
		$err_msg = 'Please select any item';
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg;
	echo $ret_str;
}
elseif($action=='doapplydiscountcoupon')
{
	$discount_coupon = '';
	if(isset($_POST['discount_coupon']) && trim($_POST['discount_coupon']) != '')
	{
		$discount_coupon = trim($_POST['discount_coupon']);
	}
	
	$error = 0;
	$err_msg = '';
	
	if($discount_coupon != '')
	{
		if($obj_comm->chkIfValidDiscountCoupon($discount_coupon))
		{
			if($obj_comm->doApplyDiscountCoupon($discount_coupon))
			{
				$error = 0;
				$err_msg = 'coupon applied successfully';
			}
			else
			{
				$error = 1;
				$err_msg = 'Something went wrong, Please try again later.';
			}	
		}
		else
		{
			$error = 1;
			$err_msg = 'This coupon is invalid';
		}	
	}
	else
	{
		$error = 1;
		$err_msg = 'Please enter coupon';
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg;
	echo $ret_str;
}
elseif($action=='docheckoutsignup')
{
	$signup_first_name = '';
	if(isset($_POST['signup_first_name']) && trim($_POST['signup_first_name']) != '')
	{
		$signup_first_name = trim($_POST['signup_first_name']);
	}
	
	$signup_last_name = '';
	if(isset($_POST['signup_last_name']) && trim($_POST['signup_last_name']) != '')
	{
		$signup_last_name = trim($_POST['signup_last_name']);
	}
	
	$signup_email = '';
	if(isset($_POST['signup_email']) && trim($_POST['signup_email']) != '')
	{
		$signup_email = trim($_POST['signup_email']);
	}
	
	$signup_mobile_no = '';
	if(isset($_POST['signup_mobile_no']) && trim($_POST['signup_mobile_no']) != '')
	{
		$signup_mobile_no = trim($_POST['signup_mobile_no']);
	}
	
	$signup_password = '';
	if(isset($_POST['signup_password']) && trim($_POST['signup_password']) != '')
	{
		$signup_password = trim($_POST['signup_password']);
	}
	
	$error = 0;
	$err_msg = '';
	
	if($signup_first_name == '')
	{
		$error = 1;
		$err_msg = 'Please enter first name';
	}
	elseif($signup_last_name == '')
	{
		$error = 1;
		$err_msg = 'Please enter last name';
	}	
	elseif($signup_email == '')
	{
		$error = 1;
		$err_msg = 'Please enter email';
	}
	elseif(filter_var($signup_email, FILTER_VALIDATE_EMAIL) === false)
	{
		$error = 1;
		$err_msg = 'Please enter valid email';
	}
	elseif($obj_comm->chkEmailExists($signup_email))
	{
		$error = true;
		$err_msg = 'This email already registered. Please login with this account, If you forgot password <a href="'.SITE_URL.'/forgot_password.php'.'">Click here</a> to reset new password';
	}
	elseif($signup_mobile_no == '')
	{
		$error = 1;
		$err_msg = 'Please enter mobile no';
	}
	elseif($obj_comm->chkMobileNoExists($signup_mobile_no))
	{
		$error = true;
		$err_msg = 'This mobile number already registered. Please login with this account, If you forgot password <a href="'.SITE_URL.'/forgot_password.php'.'">Click here</a> to reset new password';
	}
	elseif( ( !is_numeric($signup_mobile_no) ) || ( strlen($signup_mobile_no) != 10 ) )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only';
	}
	elseif(!preg_match("/^[0-9]+$/",$signup_mobile_no)  )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only!';
	}
	elseif($signup_password == '')
	{
		$error = 1;
		$err_msg = 'Please enter password';
	}
	
	if($error == '0')
	{
		$tdata = array();
		$tdata['first_name'] = $signup_first_name;
		$tdata['last_name'] = $signup_last_name;
		$tdata['email'] = $signup_email;
		$tdata['mobile_no'] = $signup_mobile_no;
		$tdata['password'] = $signup_password;
		$tdata['user_status'] = '0';
		$tdata['is_guest_user'] = '0';
		$tdata['user_otp'] = rand(1000,9999);
				
		$user_id = $obj_comm->doCheckoutSignUp($tdata);	
		if($user_id > 0)
		{
			$tdata_sms = array();
			$tdata_sms['mobile_no'] = $signup_mobile_no;
			$tdata_sms['sms_message'] = $obj_comm->getOTPSmsText($tdata);
			$obj_comm->sendSMS($tdata_sms);
			
			$error = 0;
		}
		else
		{
			$error = 1;
			$err_msg = 'Something went wrong, Please try again later!';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg;
	echo $ret_str;
}
elseif($action=='doverifyotp')
{
	$user_otp = '';
	if(isset($_POST['user_otp']) && trim($_POST['user_otp']) != '')
	{
		$user_otp = trim($_POST['user_otp']);
	}
	
	$signup_email = '';
	if(isset($_POST['email']) && trim($_POST['email']) != '')
	{
		$signup_email = trim($_POST['email']);
	}
	
	$signup_mobile_no = '';
	if(isset($_POST['mobile_no']) && trim($_POST['mobile_no']) != '')
	{
		$signup_mobile_no = trim($_POST['mobile_no']);
	}
	
	$error = 0;
	$err_msg = '';
	
	if($user_otp == '')
	{
		$error = 1;
		$err_msg = 'Please enter 4 digits otp';
	}
	elseif($signup_email == '')
	{
		$error = 1;
		$err_msg = 'Please enter email';
	}
	elseif(filter_var($signup_email, FILTER_VALIDATE_EMAIL) === false)
	{
		$error = 1;
		$err_msg = 'Please enter valid email';
	}
	elseif(!$obj_comm->chkEmailExists($signup_email))
	{
		$error = true;
		$err_msg = 'This email not registered';
	}
	elseif($signup_mobile_no == '')
	{
		$error = 1;
		$err_msg = 'Please enter mobile no';
	}
	elseif(!$obj_comm->chkMobileNoExists($signup_mobile_no))
	{
		$error = true;
		$err_msg = 'This mobile number not registered';
	}
	elseif( ( !is_numeric($signup_mobile_no) ) || ( strlen($signup_mobile_no) != 10 ) )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only';
	}
	elseif(!preg_match("/^[0-9]+$/",$signup_mobile_no)  )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only!';
	}
	
	if($error == '0')
	{
		$tdata = array();
		$tdata['user_otp'] = $user_otp;
		$tdata['email'] = $signup_email;
		$tdata['mobile_no'] = $signup_mobile_no;
		$tdata['is_guest_user'] = '0';
				
		if($obj_comm->doVerifyOTP($tdata))
		{
			$obj_comm->sendSignUpEmailToCustomer($signup_email);
			if($obj_comm->doUserLogin($signup_email))
			{
				$error = 0;
			}
			else
			{
				$error = 1;
				$err_msg = 'Something went wrong, Please try again later.';
			}	
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid otp entry!';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg;
	echo $ret_str;
}
elseif($action=='doverifyotpforgotpassword')
{
	$user_otp = '';
	if(isset($_POST['user_otp']) && trim($_POST['user_otp']) != '')
	{
		$user_otp = trim($_POST['user_otp']);
	}
	
	$signup_mobile_no = '';
	if(isset($_POST['mobile_no']) && trim($_POST['mobile_no']) != '')
	{
		$signup_mobile_no = trim($_POST['mobile_no']);
	}
	
	$error = 0;
	$err_msg = '';
	
	if($user_otp == '')
	{
		$error = 1;
		$err_msg = 'Please enter 4 digits otp';
	}
	elseif($signup_mobile_no == '')
	{
		$error = 1;
		$err_msg = 'Please enter mobile no';
	}
	elseif( ( !is_numeric($signup_mobile_no) ) || ( strlen($signup_mobile_no) != 10 ) )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only';
	}
	elseif(!preg_match("/^[0-9]+$/",$signup_mobile_no)  )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only!';
	}
	elseif(!$obj_comm->chkMobileNoExists($signup_mobile_no))
	{
		$error = 1;
		$err_msg = 'This mobile number not registered';
	}
	
	
	if($error == '0')
	{
		$tdata = array();
		$tdata['user_otp'] = $user_otp;
		$tdata['mobile_no'] = $signup_mobile_no;
		$tdata['is_guest_user'] = '0';
				
		if($obj_comm->doVerifyOTPForgotPassword($tdata))
		{
			$error = 0;
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid otp entry!';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg;
	echo $ret_str;
}
elseif($action=='resetnewpassword')
{
	$user_otp = '';
	if(isset($_POST['user_otp']) && trim($_POST['user_otp']) != '')
	{
		$user_otp = trim($_POST['user_otp']);
	}
	
	$signup_mobile_no = '';
	if(isset($_POST['mobile_no']) && trim($_POST['mobile_no']) != '')
	{
		$signup_mobile_no = trim($_POST['mobile_no']);
	}
	
	$password = '';
	if(isset($_POST['password']) && trim($_POST['password']) != '')
	{
		$password = trim($_POST['password']);
	}
	
	$cpassword = '';
	if(isset($_POST['cpassword']) && trim($_POST['cpassword']) != '')
	{
		$cpassword = trim($_POST['cpassword']);
	}
	
	$error = 0;
	$err_msg = '';
	
	if($user_otp == '')
	{
		$error = 1;
		$err_msg = 'Please enter 4 digits otp';
	}
	elseif($signup_mobile_no == '')
	{
		$error = 1;
		$err_msg = 'Please enter mobile no';
	}
	elseif( ( !is_numeric($signup_mobile_no) ) || ( strlen($signup_mobile_no) != 10 ) )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only';
	}
	elseif(!preg_match("/^[0-9]+$/",$signup_mobile_no)  )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only!';
	}
	elseif(!$obj_comm->chkMobileNoExists($signup_mobile_no))
	{
		$error = 1;
		$err_msg = 'This mobile number not registered';
	}
	elseif($password == '')
	{
		$error = 1;
		$err_msg = 'Please enter new password';
	}
	elseif($cpassword == '')
	{
		$error = 1;
		$err_msg = 'Please enter confirm password';
	}
	elseif($password != $cpassword)
	{
		$error = 1;
		$err_msg = 'Please enter same confirm password';
	}
	
	$url = '';
	if($error == '0')
	{
		$tdata = array();
		$tdata['user_otp'] = $user_otp;
		$tdata['mobile_no'] = $signup_mobile_no;
		$tdata['password'] = $password;
		$tdata['is_guest_user'] = '0';
				
		if($obj_comm->doVerifyOTPForgotPassword($tdata))
		{
			if($obj_comm->resetUserPasswordByMobile($tdata))
			{
				$url = SITE_URL.'/messages.php?id=2';
				$error = 0;
			}
			else
			{
				$error = 1;
				$err_msg = 'Invalid otp entry!';
			}
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid otp entry!';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$url;
	echo $ret_str;
}
elseif($action=='resendotp')
{
	$signup_mobile_no = '';
	if(isset($_POST['mobile_no']) && trim($_POST['mobile_no']) != '')
	{
		$signup_mobile_no = trim($_POST['mobile_no']);
	}
		
	$error = 0;
	$err_msg = '';
	
	if($signup_mobile_no == '')
	{
		$error = 1;
		$err_msg = 'Please enter mobile no';
	}
	elseif( ( !is_numeric($signup_mobile_no) ) || ( strlen($signup_mobile_no) != 10 ) )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only';
	}
	elseif(!preg_match("/^[0-9]+$/",$signup_mobile_no)  )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only!';
	}
	elseif(!$obj_comm->chkMobileNoExists($signup_mobile_no))
	{
		$error = 1;
		$err_msg = 'This mobile number not registered';
	}
		
	if($error == '0')
	{
		$tdata = array();
		$tdata['mobile_no'] = $signup_mobile_no;
		$tdata['user_otp'] = rand(1000,9999);
				
		if($obj_comm->reSendOTP($tdata))
		{
			$tdata_sms = array();
			$tdata_sms['mobile_no'] = $signup_mobile_no;
			$tdata_sms['sms_message'] = $obj_comm->getOTPSmsText($tdata);
			$obj_comm->sendSMS($tdata_sms);
			
			$error = 0;
			$err_msg = 'New OTP sent successfully';
		}
		else
		{
			$error = 1;
			$err_msg = 'Something went wrong, Please try again later!';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg;
	echo $ret_str;
}
elseif($action=='doeditprofile')
{
	$signup_first_name = '';
	if(isset($_POST['signup_first_name']) && trim($_POST['signup_first_name']) != '')
	{
		$signup_first_name = trim($_POST['signup_first_name']);
	}
	
	$signup_last_name = '';
	if(isset($_POST['signup_last_name']) && trim($_POST['signup_last_name']) != '')
	{
		$signup_last_name = trim($_POST['signup_last_name']);
	}
	
	$signup_mobile_no = '';
	if(isset($_POST['signup_mobile_no']) && trim($_POST['signup_mobile_no']) != '')
	{
		$signup_mobile_no = trim($_POST['signup_mobile_no']);
	}
		
	$error = 0;
	$err_msg = '';
	$url = '';
	
	$user_id = $_SESSION['user_id'];
	if($user_id > 0)
	{
		if($signup_first_name == '')
		{
			$error = 1;
			$err_msg = 'Please enter first name';
		}
		elseif($signup_last_name == '')
		{
			$error = 1;
			$err_msg = 'Please enter last name';
		}	
		elseif($signup_mobile_no == '')
		{
			$error = 1;
			$err_msg = 'Please enter mobile no';
		}
		elseif( ( !is_numeric($signup_mobile_no) ) || ( strlen($signup_mobile_no) != 10 ) )
		{
			$error = 1;
			$err_msg = 'Please enter valid 10 digits numbers only';
		}
		elseif(!preg_match("/^[0-9]+$/",$signup_mobile_no)  )
		{
			$error = 1;
			$err_msg = 'Please enter valid 10 digits numbers only!';
		}
		elseif($obj_comm->chkMobileNoExists_Edit($signup_mobile_no,$user_id))
		{
			$error = true;
			$err_msg = 'This mobile number already registered';
		}
		
		
		if($error == '0')
		{
			$tdata = array();
			$tdata['first_name'] = $signup_first_name;
			$tdata['last_name'] = $signup_last_name;
			$tdata['mobile_no'] = $signup_mobile_no;
			$tdata['user_id'] = $user_id;
			
			if($obj_comm->updateUser($tdata))
			{
				$error = 0;
				$url = SITE_URL.'/my_account.php';
			}
			else
			{
				$error = 1;
				$err_msg = 'Something went wrong, Please try again later!';
			}
		}	
	}
	else
	{
		$error = 1;
		$err_msg = 'Invalid access';
	}		
	
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$url;
	echo $ret_str;
}
elseif($action=='dochangepassword')
{
	$opassword = '';
	if(isset($_POST['opassword']) && trim($_POST['opassword']) != '')
	{
		$opassword = trim($_POST['opassword']);
	}
	
	$npassword = '';
	if(isset($_POST['npassword']) && trim($_POST['npassword']) != '')
	{
		$npassword = trim($_POST['npassword']);
	}
	
	$cpassword = '';
	if(isset($_POST['cpassword']) && trim($_POST['cpassword']) != '')
	{
		$cpassword = trim($_POST['cpassword']);
	}
		
	$error = 0;
	$err_msg = '';
	$url = '';
	
	$user_id = $_SESSION['user_id'];
	if($user_id > 0)
	{
		$arr_temp_user = $obj_comm->getUserDetails($user_id);
		$vpassword = $arr_temp_user['password'];
		
		if($opassword == '')
		{
			$error = 1;
			$err_msg = 'Please enter current password';
		}
		elseif(md5($opassword) != $vpassword)
		{
			$error = 1;
			$err_msg = 'Wrong current password';
		}
		elseif($npassword == '')
		{
			$error = 1;
			$err_msg = 'Please enter new password';
		}
		elseif($cpassword == '')
		{
			$error = 1;
			$err_msg = 'Please enter confirm password';
		}		
		elseif($npassword != $cpassword)
		{
			$error = 1;
			$err_msg = 'Please enter same confirm password';
		}
				
		if($error == '0')
		{
			$tdata = array();
			$tdata['password'] = $npassword;
			$tdata['user_id'] = $user_id;
			
			if($obj_comm->changeUserPassword($tdata))
			{
				$error = 0;
				$url = SITE_URL.'/messages.php?id=4';
			}
			else
			{
				$error = 1;
				$err_msg = 'Something went wrong, Please try again later!';
			}
		}	
	}
	else
	{
		$error = 1;
		$err_msg = 'Invalid access';
	}		
	
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$url;
	echo $ret_str;
}
elseif($action=='docheckoutsignupguest')
{
	$guest_name = '';
	if(isset($_POST['guest_name']) && trim($_POST['guest_name']) != '')
	{
		$guest_name = trim($_POST['guest_name']);
	}
		
	$guest_email = '';
	if(isset($_POST['guest_email']) && trim($_POST['guest_email']) != '')
	{
		$guest_email = trim($_POST['guest_email']);
	}
	
	$guest_mobile = '';
	if(isset($_POST['guest_mobile']) && trim($_POST['guest_mobile']) != '')
	{
		$guest_mobile = trim($_POST['guest_mobile']);
	}
		
	$error = 0;
	$err_msg = '';
	
	if($guest_name == '')
	{
		$error = 1;
		$err_msg = 'Please enter first name';
	}
	elseif($guest_email == '')
	{
		$error = 1;
		$err_msg = 'Please enter email';
	}
	elseif(filter_var($guest_email, FILTER_VALIDATE_EMAIL) === false)
	{
		$error = 1;
		$err_msg = 'Please enter valid email';
	}
	elseif($obj_comm->chkEmailExists($guest_email))
	{
		$error = true;
		$err_msg = 'This email already registered. Please login with this account, If you forgot password <a href="'.SITE_URL.'/forgot_password.php'.'">Click here</a> to reset new password';
	}
	elseif($guest_mobile == '')
	{
		$error = 1;
		$err_msg = 'Please enter mobile no';
	}
	elseif( ( !is_numeric($guest_mobile) ) || ( strlen($guest_mobile) != 10 ) )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only';
	}
	elseif(!preg_match("/^[0-9]+$/",$guest_mobile)  )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only!';
	}
	elseif($obj_comm->chkMobileNoExists($guest_mobile))
	{
		$error = true;
		$err_msg = 'This mobile number already registered. Please login with this account, If you forgot password <a href="'.SITE_URL.'/forgot_password.php'.'">Click here</a> to reset new password';
	}
		
	if($error == '0')
	{
		$tdata = array();
		$arr_temp = explode(' ',$guest_name,2);
		$tdata['first_name'] = $arr_temp[0];
		if(isset($arr_temp[1]))
		{
			$tdata['last_name'] = $arr_temp[1];	
		}
		else
		{
			$tdata['last_name'] = '';
		}
		
		$tdata['email'] = $guest_email;
		$tdata['mobile_no'] = $guest_mobile;
		$tdata['password'] = rand(111111,999999);
		$tdata['user_status'] = '0';
		$tdata['is_guest_user'] = '0';
		$tdata['user_otp'] = rand(1100,9999);
		
		$user_id = $obj_comm->doCheckoutSignUp($tdata);	
		if($user_id > 0)
		{
			$error = 0;
			
			$tdata_sms = array();
			$tdata_sms['mobile_no'] = $guest_mobile;
			$tdata_sms['sms_message'] = $obj_comm->getOTPSmsText($tdata);
			$obj_comm->sendSMS($tdata_sms);
		}
		else
		{
			$error = 1;
			$err_msg = 'Something went wrong, Please try again later!';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg;
	echo $ret_str;
}
elseif($action=='docheckoutlogin')
{
	$email = '';
	if(isset($_POST['email']) && trim($_POST['email']) != '')
	{
		$email = trim($_POST['email']);
	}
	
	$password = '';
	if(isset($_POST['password']) && trim($_POST['password']) != '')
	{
		$password = trim($_POST['password']);
	}
	
	$ref_url = '';
	if(isset($_POST['ref_url']) && trim($_POST['ref_url']) != '')
	{
		$ref_url = trim($_POST['ref_url']);
	}
	
	$error = 0;
	$err_msg = '';
	
	if($email == '')
	{
		$error = 1;
		$err_msg = 'Please enter email';
	}
	elseif($password == '')
	{
		$error = 1;
		$err_msg = 'Please enter password';
	}
	
	$ref_url_go = '';
	if($error == '0')
	{
		if($obj_comm->chkValidUserLogin($email,$password))
		{
			if($obj_comm->doUserLogin($email))
			{
				$error = 0;
				if(isset($ref_url) && $ref_url != '')
				{
					$ref_url_go = urldecode(base64_decode($ref_url));
				}
				else
				{
					$ref_url_go = SITE_URL.'/my_account.php';
				} 
			}
			else
			{
				$error = 1;
				$err_msg = 'Something went wrong, Please try again later.';
			}	
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid login details';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$ref_url_go;
	echo $ret_str;
}
elseif($action=='docheckoutsavedeliveryaddress')
{
	$delivery_name = '';
	if(isset($_POST['delivery_name']) && trim($_POST['delivery_name']) != '')
	{
		$delivery_name = trim($_POST['delivery_name']);
	}
	
	$delivery_building_name = '';
	if(isset($_POST['delivery_building_name']) && trim($_POST['delivery_building_name']) != '')
	{
		$delivery_building_name = trim($_POST['delivery_building_name']);
	}
	
	$delivery_floor_no = '';
	if(isset($_POST['delivery_floor_no']) && trim($_POST['delivery_floor_no']) != '')
	{
		$delivery_floor_no = trim($_POST['delivery_floor_no']);
	}
	
	$delivery_address_line1 = '';
	if(isset($_POST['delivery_address_line1']) && trim($_POST['delivery_address_line1']) != '')
	{
		$delivery_address_line1 = trim($_POST['delivery_address_line1']);
	}
	
	$delivery_landmark = '';
	if(isset($_POST['delivery_landmark']) && trim($_POST['delivery_landmark']) != '')
	{
		$delivery_landmark = trim($_POST['delivery_landmark']);
	}
	
	$delivery_city_id = '';
	if(isset($_POST['delivery_city_id']) && trim($_POST['delivery_city_id']) != '')
	{
		$delivery_city_id = trim($_POST['delivery_city_id']);
	}
	
	$delivery_area_id = '';
	if(isset($_POST['delivery_area_id']) && trim($_POST['delivery_area_id']) != '')
	{
		$delivery_area_id = trim($_POST['delivery_area_id']);
	}
	
	$delivery_mobile_no = '';
	if(isset($_POST['delivery_mobile_no']) && trim($_POST['delivery_mobile_no']) != '')
	{
		$delivery_mobile_no = trim($_POST['delivery_mobile_no']);
	}
	
	$delivery_pincode = '';
	if(isset($_POST['delivery_pincode']) && trim($_POST['delivery_pincode']) != '')
	{
		$delivery_pincode = trim($_POST['delivery_pincode']);
	}
	
	$billing_name = '';
	if(isset($_POST['billing_name']) && trim($_POST['billing_name']) != '')
	{
		$billing_name = trim($_POST['billing_name']);
	}
	
	$billing_building_name = '';
	if(isset($_POST['billing_building_name']) && trim($_POST['billing_building_name']) != '')
	{
		$billing_building_name = trim($_POST['billing_building_name']);
	}
	
	$billing_floor_no = '';
	if(isset($_POST['billing_floor_no']) && trim($_POST['billing_floor_no']) != '')
	{
		$billing_floor_no = trim($_POST['billing_floor_no']);
	}
	
	$billing_address_line1 = '';
	if(isset($_POST['billing_address_line1']) && trim($_POST['billing_address_line1']) != '')
	{
		$billing_address_line1 = trim($_POST['billing_address_line1']);
	}
	
	$billing_landmark = '';
	if(isset($_POST['billing_landmark']) && trim($_POST['billing_landmark']) != '')
	{
		$billing_landmark = trim($_POST['billing_landmark']);
	}
	
	$billing_city_id = '';
	if(isset($_POST['billing_city_id']) && trim($_POST['billing_city_id']) != '')
	{
		$billing_city_id = trim($_POST['billing_city_id']);
	}
	
	$billing_area_id = '';
	if(isset($_POST['billing_area_id']) && trim($_POST['billing_area_id']) != '')
	{
		$billing_area_id = trim($_POST['billing_area_id']);
	}
	
	$billing_mobile_no = '';
	if(isset($_POST['billing_mobile_no']) && trim($_POST['billing_mobile_no']) != '')
	{
		$billing_mobile_no = trim($_POST['billing_mobile_no']);
	}
	
	$billing_pincode = '';
	if(isset($_POST['billing_pincode']) && trim($_POST['billing_pincode']) != '')
	{
		$billing_pincode = trim($_POST['billing_pincode']);
	}
	
	$error = 0;
	$err_msg = '';
	
	if($delivery_name == '')
	{
		$error = 1;
		$err_msg = 'Please enter delivery name.';
	}
	elseif($delivery_building_name == '')
	{
		$error = 1;
		$err_msg = 'Please enter flat number/house number, building name for delivery address.';
	}
	elseif($delivery_address_line1 == '')
	{
		$error = 1;
		$err_msg = 'Please enter address line 1 for delivery address';
	}	
	elseif($delivery_city_id == '' || $delivery_city_id == '0'  || $delivery_city_id == 'undefined'  )
	{
		$error = 1;
		$err_msg = 'Please enter delivery city/town';
	}
	elseif($delivery_area_id == '' || $delivery_area_id == '0'  || $delivery_area_id == 'undefined'  )
	{
		$error = 1;
		$err_msg = 'Please enter delivery area';
	}
	elseif($delivery_mobile_no == '')
	{
		$error = 1;
		$err_msg = 'Please enter mobile no for delivery address';
	}
	elseif( ( !is_numeric($delivery_mobile_no) ) || ( strlen($delivery_mobile_no) != 10 ) )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only for delivery address';
	}
	elseif(!preg_match("/^[0-9]+$/",$delivery_mobile_no)  )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only for delivery address!';
	}
	elseif($delivery_pincode == '')
	{
		//$error = 1;
		//$err_msg = 'Please enter pincode';
	}
	elseif($billing_name == '')
	{
		$error = 1;
		$err_msg = 'Please enter billing name.';
	}
	elseif($billing_building_name == '')
	{
		$error = 1;
		$err_msg = 'Please enter flat number/house number, building name for billing address.';
	}
	elseif($billing_address_line1 == '')
	{
		$error = 1;
		$err_msg = 'Please enter address line 1 for billing address';
	}	
	elseif($billing_city_id == '' || $billing_city_id == '0'  || $billing_city_id == 'undefined'  )
	{
		$error = 1;
		$err_msg = 'Please enter billing city/town';
	}
	elseif($billing_area_id == '' || $billing_area_id == '0'  || $billing_area_id == 'undefined'  )
	{
		$error = 1;
		$err_msg = 'Please enter billing area';
	}
	elseif($billing_mobile_no == '')
	{
		$error = 1;
		$err_msg = 'Please enter mobile no for billing address';
	}
	elseif( ( !is_numeric($billing_mobile_no) ) || ( strlen($billing_mobile_no) != 10 ) )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only for billing address';
	}
	elseif(!preg_match("/^[0-9]+$/",$billing_mobile_no)  )
	{
		$error = 1;
		$err_msg = 'Please enter valid 10 digits numbers only for billing address!';
	}
	elseif($billing_pincode == '')
	{
		//$error = 1;
		//$err_msg = 'Please enter pincode';
	}
	else
	{
		if(isset($_SESSION['topcityid']) && $_SESSION['topcityid'] != '')
		{
			$topcityid = $_SESSION['topcityid'];
		}
		else
		{
			$topcityid = '0';
		}
		
		if(isset($_SESSION['topareaid']) && $_SESSION['topareaid'] != '')
		{
			$topareaid = $_SESSION['topareaid'];
		}
		else
		{
			$topareaid = '0';
		}

		if($delivery_city_id != $topcityid)
		{
			$error = 1;
			$err_msg = 'Sorry this item(s) currently not avilable in city/town which you selected for delivery';
		}
		else
		{
			/*
			if($topareaid != '' && $topareaid != '0' && $topareaid != '-1')
			{
				if($delivery_area_id != '' && $delivery_area_id != '0' && $delivery_area_id != $topareaid)
				{
					$error = 1;
					$err_msg = 'Sorry this item(s) currently not avilable in area of city/town which you selected for delivery';
				}
			}
			*/			
		}
	}
	
	if($error == '0')
	{
		if($obj_comm->isUserLoggedIn())
		{
			$tdata = array();
			$tdata['user_id'] = $_SESSION['user_id'];
			$tdata['delivery_name'] = $delivery_name;
			$tdata['building_name'] = $delivery_building_name;
			$tdata['floor_no'] = $delivery_floor_no;
			$tdata['landmark'] = $delivery_landmark;
			$tdata['address'] = $delivery_address_line1;
			$tdata['country_id'] = $obj_comm->getCountryIdOfCityId($delivery_city_id);
			$tdata['state_id'] = $obj_comm->getStateIdOfCityId($delivery_city_id);
			$tdata['city_id'] = $delivery_city_id;
			$tdata['area_id'] = $delivery_area_id;
			$tdata['delivery_mobile_no'] = $delivery_mobile_no;
			$tdata['pincode'] = $delivery_pincode;
			$tdata['billing_name'] = $billing_name;
			$tdata['billing_building_name'] = $billing_building_name;
			$tdata['billing_floor_no'] = $billing_floor_no;
			$tdata['billing_landmark'] = $billing_landmark;
			$tdata['billing_address'] = $billing_address_line1;
			$tdata['billing_country_id'] = $obj_comm->getCountryIdOfCityId($billing_city_id);
			$tdata['billing_state_id'] = $obj_comm->getStateIdOfCityId($billing_city_id);
			$tdata['billing_city_id'] = $billing_city_id;
			$tdata['billing_area_id'] = $billing_area_id;
			$tdata['billing_mobile_no'] = $billing_mobile_no;
			$tdata['billing_pincode'] = $billing_pincode;

			if($obj_comm->updateUserAddressDetails($tdata))
			{
				$error = 0;
			}
			else
			{
				$error = 1;
				$err_msg = 'Something went wrong, Please try again later.';
			}	
		}
		else
		{
			$error = 1;
			$err_msg = 'Something went wrong, Please try again later!';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg;
	echo $ret_str;
}
elseif($action=='docheckoutproceedtopayment')
{
	$error = 0;
	$err_msg = '';
	$url = '';
	
	if($obj_comm->isUserLoggedIn())
	{
		if($obj_comm->chkIfCartEmpty())
		{
			$error = 1;
			$err_msg = 'Your cart is empty.';
		}
		else
		{
			$user_id = $_SESSION['user_id'];
			if($obj_comm->chkValidUserId($user_id))
			{
				$invoice = $obj_comm->genrateInvoiceNumber($user_id);		
				$cart_session_id = session_id();
				$arr_user_detail = $obj_comm->getUserDetails($user_id);
				$arr_cart_detail = $obj_comm->getCartDetailsBySessId($cart_session_id);
				$obj_comm->debuglog('[remote_createorder] arr_cart_detail:<pre>'.print_r($arr_cart_detail,1).'</pre>');
				
				$tdata = array();
				$tdata['invoice'] = $invoice;
				$tdata['cart_session_id'] = $cart_session_id;
				$tdata['order_status'] = 0;
				$tdata['payment_status'] = 0;
				$tdata['user_id'] = $user_id;
				$tdata['user_name'] = $arr_user_detail['first_name'].' '.$arr_user_detail['last_name'];
				$tdata['user_email'] = $arr_user_detail['email'];
				$tdata['user_mobile_no'] = $arr_user_detail['mobile_no'];
				$tdata['user_building_name'] = $arr_user_detail['building_name'];
				$tdata['user_floor_no'] = $arr_user_detail['floor_no'];
				$tdata['user_landmark'] = $arr_user_detail['landmark'];
				$tdata['user_address'] = $arr_user_detail['address'];
				$tdata['user_country_id'] = $arr_user_detail['country_id'];
				$tdata['user_country_name'] = $obj_comm->getCountryName($arr_user_detail['country_id']);
				$tdata['user_state_id'] = $arr_user_detail['state_id'];
				$tdata['user_state_name'] = $obj_comm->getStateName($arr_user_detail['state_id']);
				$tdata['user_city_id'] = $arr_user_detail['city_id'];
				$tdata['user_city_name'] = $obj_comm->getCityName($arr_user_detail['city_id']);
				$tdata['user_area_id'] = $arr_user_detail['area_id'];
				$tdata['user_area_name'] = $obj_comm->getAreaName($arr_user_detail['area_id']);
				$tdata['user_delivery_mobile_no'] = $arr_user_detail['delivery_mobile_no'];
				$tdata['user_pincode'] = $arr_user_detail['pincode'];
				$tdata['billing_building_name'] = $arr_user_detail['billing_building_name'];
				$tdata['billing_floor_no'] = $arr_user_detail['billing_floor_no'];
				$tdata['billing_landmark'] = $arr_user_detail['billing_landmark'];
				$tdata['billing_address'] = $arr_user_detail['billing_address'];
				$tdata['billing_country_id'] = $arr_user_detail['billing_country_id'];
				$tdata['billing_country_name'] = $obj_comm->getCountryName($arr_user_detail['billing_country_id']);
				$tdata['billing_state_id'] = $arr_user_detail['billing_state_id'];
				$tdata['billing_state_name'] = $obj_comm->getStateName($arr_user_detail['billing_state_id']);
				$tdata['billing_city_id'] = $arr_user_detail['billing_city_id'];
				$tdata['billing_city_name'] = $obj_comm->getCityName($arr_user_detail['billing_city_id']);
				$tdata['billing_area_id'] = $arr_user_detail['billing_area_id'];
				$tdata['billing_area_name'] = $obj_comm->getAreaName($arr_user_detail['billing_area_id']);
				$tdata['billing_mobile_no'] = $arr_user_detail['billing_mobile_no'];
				$tdata['billing_pincode'] = $arr_user_detail['billing_pincode'];
				$tdata['order_subtotal'] = $arr_cart_detail['order_subtotal'];
				$tdata['order_discount_coupon'] = $arr_cart_detail['order_discount_coupon'];
				$tdata['order_trade_discount'] = $arr_cart_detail['order_trade_discount'];
				$tdata['order_discount'] = $arr_cart_detail['order_discount'];
				$tdata['order_discount_vendor_id'] = $arr_cart_detail['order_discount_vendor_id'];
				$tdata['order_tax'] = $arr_cart_detail['order_tax'];
				$tdata['order_shipping_amt'] = $arr_cart_detail['order_shipping_amt'];
				$tdata['order_total_amt'] = $arr_cart_detail['order_total_amt'];
				
				if($arr_user_detail['delivery_name'] == '')
				{
					$arr_user_detail['delivery_name'] = $tdata['user_name'];
				}
				
				if($arr_user_detail['billing_name'] == '')
				{
					$arr_user_detail['billing_name'] = $arr_user_detail['delivery_name'];
				}
				
				$tdata['delivery_name'] = $arr_user_detail['delivery_name'];
				$tdata['billing_name'] = $arr_user_detail['billing_name'];
				
				$tdata['order_cgst_tax_amount'] = $arr_cart_detail['order_cgst_tax_amount'];
				$tdata['order_sgst_tax_amount'] = $arr_cart_detail['order_sgst_tax_amount'];
				$tdata['order_cess_tax_amount'] = $arr_cart_detail['order_cess_tax_amount'];
				$tdata['order_gst_tax_amount'] = $arr_cart_detail['order_gst_tax_amount'];
				
				$tdata['cart'] = $arr_cart_detail['cart'];
				
				if($obj_comm->createOrder($tdata))
				{
					$error = 0;
					$url = SITE_URL.'/pay.php?ref='.$invoice;		
				}
				else
				{
					$error = 1;
					$err_msg = 'Somthing went wrong. Please try again later';	
				}
			}
			else
			{
				$error = 1;
				$err_msg = 'Invalid user.';
			}
		}
	}
	else
	{
		$error = 1;
		$err_msg = 'Please login to continue.';
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$url;
	echo $ret_str;
}
elseif($action == 'dosearchforhomelisting')
{
	$topcityid = '';
	if(isset($_POST['topcityid']) && trim($_POST['topcityid']) != '')
	{
		$topcityid = trim($_POST['topcityid']);
	}
	
	$topareaid = '';
	if(isset($_POST['topareaid']) && trim($_POST['topareaid']) != '')
	{
		$topareaid = trim($_POST['topareaid']);
	}
	
	$home_list_region_id = '';
	if(isset($_POST['home_list_region_id']) && trim($_POST['home_list_region_id']) != '')
	{
		$home_list_region_id = trim($_POST['home_list_region_id']);
	}
	
	$home_list_item_id = '';
	if(isset($_POST['home_list_item_id']) && trim($_POST['home_list_item_id']) != '')
	{
		$home_list_item_id = trim($_POST['home_list_item_id']);
	}
	
	$home_list_date = '';
	if(isset($_POST['home_list_date']) && trim($_POST['home_list_date']) != '')
	{
		$home_list_date = trim($_POST['home_list_date']);
	}
	
	$error = 0;
	$err_msg = '';
	$url = SITE_URL;
	if($topcityid == '' || $topcityid == 'null')
	{
		$error = 1;
		$err_msg = 'Please enter city';
	}
	else
	{
		if($obj_comm->chkIfValidCityId($topcityid))
		{
			if($topareaid =='')
			{
				$_SESSION['topcityid'] = $topcityid;
				$_SESSION['topareaid'] = $topareaid;
				$toplocationstr = $obj_comm->getTopLocationStr($topcityid,$topareaid);
				$_SESSION['toplocationstr'] = $toplocationstr;	
				
				if($home_list_date == '' && $home_list_region_id == '' && $home_list_item_id == '')
				{
					$error = 1;
					$err_msg = 'Please make your selection to explore';
				}
				else
				{
					//echo 'home_list_date:'.$home_list_date.',home_list_region_id:'.$home_list_region_id.',home_list_item_id:'.$home_list_item_id;
					//$_SESSION['home_list_area_id'] = $topareaid;
					
					//$_SESSION['home_list_region_id'] = $home_list_region_id;	
					//$_SESSION['home_list_item_id'] = $home_list_item_id;	
					//$_SESSION['home_list_date'] = $home_list_date;	
					if($home_list_date == '')
					{
						$_SESSION['current_showing_date'] = $home_list_date;
						
						if($home_list_region_id == '')
						{
							if($home_list_item_id == '')
							{
								$error = 1;
								$err_msg = 'Please make your selection to explore';
							}
							else
							{
								$arr_delivery_date = $_SESSION['arr_delivery_date'];
								$arr_areawise_records = $_SESSION['arr_areawise_records'];
								$arr_temp_date_id = array();
								$arr_temp_area_id = array();
								
								for($i=0;$i<count($arr_delivery_date);$i++)
								{
									for($j=0;$j<count($arr_areawise_records[$i]);$j++)
									{
										//$arr_temp_area_id[$arr_delivery_date[$i]] = array();
										//echo '<br>area:'.$arr_areawise_records[$i][$j]['cusine_area_id'];
										if($arr_areawise_records[$i][$j]['region_category'] != '')
										{
											if($home_list_item_id == $arr_areawise_records[$i][$j]['item_id'])
											{
												array_push($arr_temp_date_id,$arr_delivery_date[$i]);		
												//array_push($arr_temp_area_id[$arr_delivery_date[$i]],$arr_areawise_records[$i][$j]['cusine_area_id']);	
												array_push($arr_temp_area_id,$arr_areawise_records[$i][$j]['cusine_area_id']);	
											}
										}	
									}
								}
								
								$arr_temp_date_id = array_unique($arr_temp_date_id);
								$arr_temp_date_id = array_values($arr_temp_date_id);
								
								if(count($arr_temp_date_id) > 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_date_id);
									//echo '<br></pre>';
									$error = 1;
									$err_msg = 'Please select area and date to explore.';
									
								}
								elseif(count($arr_temp_date_id) == 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_area_id);
									//echo '<br></pre>';
									
									$temp_area_str_1 = implode(',',$arr_temp_area_id);
									$arr_temp_area_id_1 = explode(',',$temp_area_str_1);
									
									$arr_temp_area_id_1 = array_unique($arr_temp_area_id_1);
									$arr_temp_area_id_1 = array_values($arr_temp_area_id_1);
									
									if(count($arr_temp_area_id_1) > 1)
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
									elseif(count($arr_temp_area_id_1) == 1)
									{
										if($arr_temp_area_id_1[0] == '-1')
										{
											$arr_temp_area_id_1[0] = '';
										}
										$_SESSION['topareaid'] = $arr_temp_area_id_1[0];
										$_SESSION['current_showing_date'] = $arr_temp_date_id[0];
										$region_name = $obj_comm->getRegionCategoryNameOfItem($home_list_item_id);
										$hash_cusine_str = strtolower($region_name);
										$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
										$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
									}
									else
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
								}
								else
								{
									$error = 1;
									$err_msg = 'Please select area and date to explore';
								}
							}
						}	
						else
						{
							if($home_list_item_id == '')
							{
								$arr_delivery_date = $_SESSION['arr_delivery_date'];
								$arr_areawise_records = $_SESSION['arr_areawise_records'];
								$arr_temp_date_id = array();
								$arr_temp_area_id = array();
								
								for($i=0;$i<count($arr_delivery_date);$i++)
								{
									for($j=0;$j<count($arr_areawise_records[$i]);$j++)
									{
										//$arr_temp_area_id[$arr_delivery_date[$i]] = array();
										//echo '<br>area:'.$arr_areawise_records[$i][$j]['cusine_area_id'];
										if($arr_areawise_records[$i][$j]['region_category'] != '')
										{
											if($home_list_region_id == $arr_areawise_records[$i][$j]['region_category_id'])
											{
												array_push($arr_temp_date_id,$arr_delivery_date[$i]);		
												//array_push($arr_temp_area_id[$arr_delivery_date[$i]],$arr_areawise_records[$i][$j]['cusine_area_id']);	
												array_push($arr_temp_area_id,$arr_areawise_records[$i][$j]['cusine_area_id']);	
											}
										}	
									}
								}
								
								$arr_temp_date_id = array_unique($arr_temp_date_id);
								$arr_temp_date_id = array_values($arr_temp_date_id);
								
								if(count($arr_temp_date_id) > 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_date_id);
									//echo '<br></pre>';
									$error = 1;
									$err_msg = 'Please select area and date to explore.';
									
								}
								elseif(count($arr_temp_date_id) == 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_area_id);
									//echo '<br></pre>';
									
									$temp_area_str_1 = implode(',',$arr_temp_area_id);
									$arr_temp_area_id_1 = explode(',',$temp_area_str_1);
									
									$arr_temp_area_id_1 = array_unique($arr_temp_area_id_1);
									$arr_temp_area_id_1 = array_values($arr_temp_area_id_1);
									
									if(count($arr_temp_area_id_1) > 1)
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
									elseif(count($arr_temp_area_id_1) == 1)
									{
										if($arr_temp_area_id_1[0] == '-1')
										{
											$arr_temp_area_id_1[0] = '';
										}
										$_SESSION['topareaid'] = $arr_temp_area_id_1[0];
										$_SESSION['current_showing_date'] = $arr_temp_date_id[0];
										$region_name = $obj_comm->getCategoryName($home_list_region_id);
										$hash_cusine_str = strtolower($region_name);
										$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
										$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
									}
									else
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
								}
								else
								{
									$error = 1;
									$err_msg = 'Please select area and date to explore';
								}
							}
							else
							{
								$arr_delivery_date = $_SESSION['arr_delivery_date'];
								$arr_areawise_records = $_SESSION['arr_areawise_records'];
								$arr_temp_date_id = array();
								$arr_temp_area_id = array();
								
								for($i=0;$i<count($arr_delivery_date);$i++)
								{
									for($j=0;$j<count($arr_areawise_records[$i]);$j++)
									{
										//$arr_temp_area_id[$arr_delivery_date[$i]] = array();
										//echo '<br>area:'.$arr_areawise_records[$i][$j]['cusine_area_id'];
										if($arr_areawise_records[$i][$j]['region_category'] != '')
										{
											if($home_list_item_id == $arr_areawise_records[$i][$j]['item_id'])
											{
												array_push($arr_temp_date_id,$arr_delivery_date[$i]);		
												//array_push($arr_temp_area_id[$arr_delivery_date[$i]],$arr_areawise_records[$i][$j]['cusine_area_id']);	
												array_push($arr_temp_area_id,$arr_areawise_records[$i][$j]['cusine_area_id']);	
											}
										}	
									}
								}
								
								$arr_temp_date_id = array_unique($arr_temp_date_id);
								$arr_temp_date_id = array_values($arr_temp_date_id);
								
								if(count($arr_temp_date_id) > 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_date_id);
									//echo '<br></pre>';
									$error = 1;
									$err_msg = 'Please select area and date to explore.';
									
								}
								elseif(count($arr_temp_date_id) == 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_area_id);
									//echo '<br></pre>';
									
									$temp_area_str_1 = implode(',',$arr_temp_area_id);
									$arr_temp_area_id_1 = explode(',',$temp_area_str_1);
									
									$arr_temp_area_id_1 = array_unique($arr_temp_area_id_1);
									$arr_temp_area_id_1 = array_values($arr_temp_area_id_1);
									
									if(count($arr_temp_area_id_1) > 1)
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
									elseif(count($arr_temp_area_id_1) == 1)
									{
										if($arr_temp_area_id_1[0] == '-1')
										{
											$arr_temp_area_id_1[0] = '';
										}
										$_SESSION['topareaid'] = $arr_temp_area_id_1[0];
										$_SESSION['current_showing_date'] = $arr_temp_date_id[0];
										$region_name = $obj_comm->getRegionCategoryNameOfItem($home_list_item_id);
										$hash_cusine_str = strtolower($region_name);
										$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
										$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
									}
									else
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
								}
								else
								{
									$error = 1;
									$err_msg = 'Please select area and date to explore';
								}
							}
						}
					}
					else
					{
						$arr_delivery_date = $_SESSION['arr_delivery_date']	;
						$_SESSION['current_showing_date'] = $arr_delivery_date[$home_list_date];
						
						if($home_list_region_id == '')
						{
							if($home_list_item_id == '')
							{
								$arr_delivery_date = $_SESSION['arr_delivery_date'];
								$arr_areawise_records = $_SESSION['arr_areawise_records'];
								$arr_temp_date_id = array();
								$arr_temp_area_id = array();
								
								for($i=0;$i<count($arr_delivery_date);$i++)
								{
									if($i == $home_list_date)
									{
										for($j=0;$j<count($arr_areawise_records[$i]);$j++)
										{
											//$arr_temp_area_id[$arr_delivery_date[$i]] = array();
											//echo '<br>area:'.$arr_areawise_records[$i][$j]['cusine_area_id'];
											if($arr_areawise_records[$i][$j]['region_category'] != '')
											{
												//if($home_list_item_id == $arr_areawise_records[$i][$j]['item_id'])
												//{
													array_push($arr_temp_date_id,$arr_delivery_date[$i]);		
													//array_push($arr_temp_area_id[$arr_delivery_date[$i]],$arr_areawise_records[$i][$j]['cusine_area_id']);	
													array_push($arr_temp_area_id,$arr_areawise_records[$i][$j]['cusine_area_id']);	
												//}
											}	
										}	
									}
									
								}
								
								$arr_temp_date_id = array_unique($arr_temp_date_id);
								$arr_temp_date_id = array_values($arr_temp_date_id);
								
								if(count($arr_temp_date_id) > 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_date_id);
									//echo '<br></pre>';
									$error = 1;
									$err_msg = 'Please select area to explore.';
									
								}
								elseif(count($arr_temp_date_id) == 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_area_id);
									//echo '<br></pre>';
									
									$temp_area_str_1 = implode(',',$arr_temp_area_id);
									$arr_temp_area_id_1 = explode(',',$temp_area_str_1);
									
									$arr_temp_area_id_1 = array_unique($arr_temp_area_id_1);
									$arr_temp_area_id_1 = array_values($arr_temp_area_id_1);
									
									if(count($arr_temp_area_id_1) > 1)
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
									elseif(count($arr_temp_area_id_1) == 1)
									{
										if($arr_temp_area_id_1[0] == '-1')
										{
											$arr_temp_area_id_1[0] = '';
										}
										$_SESSION['topareaid'] = $arr_temp_area_id_1[0];
										$_SESSION['current_showing_date'] = $arr_temp_date_id[0];
										/*
										$region_name = $obj_comm->getRegionCategoryNameOfItem($home_list_item_id);
										$hash_cusine_str = strtolower($region_name);
										$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
										$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
										*/
										$url = SITE_URL.'/cusines.php';		
									}
									else
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
								}
								else
								{
									$error = 1;
									$err_msg = 'Please select area and date to explore';
								}
							}
							else
							{
								$arr_delivery_date = $_SESSION['arr_delivery_date'];
								$arr_areawise_records = $_SESSION['arr_areawise_records'];
								$arr_temp_date_id = array();
								$arr_temp_area_id = array();
								
								for($i=0;$i<count($arr_delivery_date);$i++)
								{
									if($i == $home_list_date)
									{
										for($j=0;$j<count($arr_areawise_records[$i]);$j++)
										{
											//$arr_temp_area_id[$arr_delivery_date[$i]] = array();
											//echo '<br>area:'.$arr_areawise_records[$i][$j]['cusine_area_id'];
											if($arr_areawise_records[$i][$j]['region_category'] != '')
											{
												if($home_list_item_id == $arr_areawise_records[$i][$j]['item_id'])
												{
													array_push($arr_temp_date_id,$arr_delivery_date[$i]);		
													//array_push($arr_temp_area_id[$arr_delivery_date[$i]],$arr_areawise_records[$i][$j]['cusine_area_id']);	
													array_push($arr_temp_area_id,$arr_areawise_records[$i][$j]['cusine_area_id']);	
												}
											}	
										}	
									}
									
								}
								
								$arr_temp_date_id = array_unique($arr_temp_date_id);
								$arr_temp_date_id = array_values($arr_temp_date_id);
								
								if(count($arr_temp_date_id) > 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_date_id);
									//echo '<br></pre>';
									$error = 1;
									$err_msg = 'Please select area to explore.';
									
								}
								elseif(count($arr_temp_date_id) == 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_area_id);
									//echo '<br></pre>';
									
									$temp_area_str_1 = implode(',',$arr_temp_area_id);
									$arr_temp_area_id_1 = explode(',',$temp_area_str_1);
									
									$arr_temp_area_id_1 = array_unique($arr_temp_area_id_1);
									$arr_temp_area_id_1 = array_values($arr_temp_area_id_1);
									
									if(count($arr_temp_area_id_1) > 1)
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
									elseif(count($arr_temp_area_id_1) == 1)
									{
										if($arr_temp_area_id_1[0] == '-1')
										{
											$arr_temp_area_id_1[0] = '';
										}
										$_SESSION['topareaid'] = $arr_temp_area_id_1[0];
										$_SESSION['current_showing_date'] = $arr_temp_date_id[0];
										$region_name = $obj_comm->getRegionCategoryNameOfItem($home_list_item_id);
										$hash_cusine_str = strtolower($region_name);
										$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
										$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
									}
									else
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
								}
								else
								{
									$error = 1;
									$err_msg = 'Please select area and date to explore';
								}
							}
						}	
						else
						{
							if($home_list_item_id == '')
							{
								$arr_delivery_date = $_SESSION['arr_delivery_date'];
								$arr_areawise_records = $_SESSION['arr_areawise_records'];
								$arr_temp_date_id = array();
								$arr_temp_area_id = array();
								
								for($i=0;$i<count($arr_delivery_date);$i++)
								{
									if($i == $home_list_date)
									{
										for($j=0;$j<count($arr_areawise_records[$i]);$j++)
										{
											//$arr_temp_area_id[$arr_delivery_date[$i]] = array();
											//echo '<br>area:'.$arr_areawise_records[$i][$j]['cusine_area_id'];
											if($arr_areawise_records[$i][$j]['region_category'] != '')
											{
												if($home_list_region_id == $arr_areawise_records[$i][$j]['region_category_id'])
												{
													array_push($arr_temp_date_id,$arr_delivery_date[$i]);		
													//array_push($arr_temp_area_id[$arr_delivery_date[$i]],$arr_areawise_records[$i][$j]['cusine_area_id']);	
													array_push($arr_temp_area_id,$arr_areawise_records[$i][$j]['cusine_area_id']);	
												}
											}	
										}	
									}
									
								}
								
								$arr_temp_date_id = array_unique($arr_temp_date_id);
								$arr_temp_date_id = array_values($arr_temp_date_id);
								
								if(count($arr_temp_date_id) > 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_date_id);
									//echo '<br></pre>';
									$error = 1;
									$err_msg = 'Please select area to explore.';
									
								}
								elseif(count($arr_temp_date_id) == 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_area_id);
									//echo '<br></pre>';
									
									$temp_area_str_1 = implode(',',$arr_temp_area_id);
									$arr_temp_area_id_1 = explode(',',$temp_area_str_1);
									
									$arr_temp_area_id_1 = array_unique($arr_temp_area_id_1);
									$arr_temp_area_id_1 = array_values($arr_temp_area_id_1);
									
									if(count($arr_temp_area_id_1) > 1)
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
									elseif(count($arr_temp_area_id_1) == 1)
									{
										if($arr_temp_area_id_1[0] == '-1')
										{
											$arr_temp_area_id_1[0] = '';
										}
										$_SESSION['topareaid'] = $arr_temp_area_id_1[0];
										$_SESSION['current_showing_date'] = $arr_temp_date_id[0];
										
										$region_name = $obj_comm->getCategoryName($home_list_regoin_id);
										$hash_cusine_str = strtolower($region_name);
										$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
										$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
										
									}
									else
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
								}
								else
								{
									$error = 1;
									$err_msg = 'Please select area and date to explore';
								}
							}
							else
							{
								$arr_delivery_date = $_SESSION['arr_delivery_date'];
								$arr_areawise_records = $_SESSION['arr_areawise_records'];
								$arr_temp_date_id = array();
								$arr_temp_area_id = array();
								
								for($i=0;$i<count($arr_delivery_date);$i++)
								{
									if($i == $home_list_date)
									{
										for($j=0;$j<count($arr_areawise_records[$i]);$j++)
										{
											//$arr_temp_area_id[$arr_delivery_date[$i]] = array();
											//echo '<br>area:'.$arr_areawise_records[$i][$j]['cusine_area_id'];
											if($arr_areawise_records[$i][$j]['region_category'] != '')
											{
												if($home_list_item_id == $arr_areawise_records[$i][$j]['item_id'])
												{
													array_push($arr_temp_date_id,$arr_delivery_date[$i]);		
													//array_push($arr_temp_area_id[$arr_delivery_date[$i]],$arr_areawise_records[$i][$j]['cusine_area_id']);	
													array_push($arr_temp_area_id,$arr_areawise_records[$i][$j]['cusine_area_id']);	
												}
											}	
										}	
									}
									
								}
								
								$arr_temp_date_id = array_unique($arr_temp_date_id);
								$arr_temp_date_id = array_values($arr_temp_date_id);
								
								if(count($arr_temp_date_id) > 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_date_id);
									//echo '<br></pre>';
									$error = 1;
									$err_msg = 'Please select area to explore.';
									
								}
								elseif(count($arr_temp_date_id) == 1)
								{
									//echo '<br><pre>';
									//print_r($arr_temp_area_id);
									//echo '<br></pre>';
									
									$temp_area_str_1 = implode(',',$arr_temp_area_id);
									$arr_temp_area_id_1 = explode(',',$temp_area_str_1);
									
									$arr_temp_area_id_1 = array_unique($arr_temp_area_id_1);
									$arr_temp_area_id_1 = array_values($arr_temp_area_id_1);
									
									if(count($arr_temp_area_id_1) > 1)
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
									elseif(count($arr_temp_area_id_1) == 1)
									{
										if($arr_temp_area_id_1[0] == '-1')
										{
											$arr_temp_area_id_1[0] = '';
										}
										$_SESSION['topareaid'] = $arr_temp_area_id_1[0];
										$_SESSION['current_showing_date'] = $arr_temp_date_id[0];
										$region_name = $obj_comm->getRegionCategoryNameOfItem($home_list_item_id);
										$hash_cusine_str = strtolower($region_name);
										$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
										$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
									}
									else
									{
										$error = 1;
										$err_msg = 'Please select area to explore';	
									}
								}
								else
								{
									$error = 1;
									$err_msg = 'Please select area and date to explore';
								}
							}
						}
					}						
				}
			}
			else
			{
				if($obj_comm->chkIfValidAreaId($topareaid))
				{
					$_SESSION['topcityid'] = $topcityid;
					$_SESSION['topareaid'] = $topareaid;
					$toplocationstr = $obj_comm->getTopLocationStr($topcityid,$topareaid);
					$_SESSION['toplocationstr'] = $toplocationstr;	
					if($home_list_date == '' && $home_list_region_id == '' && $home_list_item_id == '')
					{
						$url = SITE_URL.'/cusines.php';
					}
					else
					{
						if($home_list_date == '')
						{
							//$arr_delivery_date = $_SESSION['arr_delivery_date']	;
							//$_SESSION['current_showing_date'] = $arr_delivery_date[$home_list_date];
							
							if($home_list_region_id == '')
							{
								if($home_list_item_id == '')
								{
									$url = SITE_URL.'/cusines.php';
								}
								else
								{
									$region_name = $obj_comm->getRegionCategoryNameOfItem($home_list_item_id);
									$hash_cusine_str = strtolower($region_name);
									$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
									$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
								}	
							}
							else
							{
								if($home_list_item_id == '')
								{
									$region_name = $obj_comm->getCategoryName($home_list_region_id);
									$hash_cusine_str = strtolower($region_name);
									$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
									$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
								}
								else
								{
									$region_name = $obj_comm->getRegionCategoryNameOfItem($home_list_item_id);
									$hash_cusine_str = strtolower($region_name);
									$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
									$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
								}
								
							}
						}
						else
						{
							$arr_delivery_date = $_SESSION['arr_delivery_date']	;
							$_SESSION['current_showing_date'] = $arr_delivery_date[$home_list_date];
							
							if($home_list_region_id == '')
							{
								if($home_list_item_id == '')
								{
									$url = SITE_URL.'/cusines.php';
								}
								else
								{
									$region_name = $obj_comm->getRegionCategoryNameOfItem($home_list_item_id);
									$hash_cusine_str = strtolower($region_name);
									$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
									$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
								}	
							}
							else
							{
								$region_name = $obj_comm->getCategoryName($home_list_region_id);
								$hash_cusine_str = strtolower($region_name);
								$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
								$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
							}
						}
					}
				}					
				else
				{
					$error = 1;
					$err_msg = 'Invalid area';
				}
			}	
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid city';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$url;
	echo $ret_str;
}
elseif($action == 'dosearchcusineexplore')
{
	$topcityid = '';
	if(isset($_POST['topcityid']) && trim($_POST['topcityid']) != '')
	{
		$topcityid = trim($_POST['topcityid']);
	}
	
	$home_region_speciality = '';
	if(isset($_POST['home_region_speciality']) && trim($_POST['home_region_speciality']) != '')
	{
		$home_region_speciality = trim($_POST['home_region_speciality']);
	}
	
	$home_dish_items = '';
	if(isset($_POST['home_dish_items']) && trim($_POST['home_dish_items']) != '')
	{
		$home_dish_items = trim($_POST['home_dish_items']);
	}
	
	$error = 0;
	$err_msg = '';
	$url = SITE_URL;
	$cusine_page_url = SITE_URL.'/cusines.php';		
	$hash_url_value = '';
	$_SESSION['cusinescrooltodiv'] = '';
	
	if($topcityid == '' || $topcityid == 'null')
	{
		$error = 1;
		$err_msg = 'Please enter city';
	}
	else
	{
		if($obj_comm->chkIfValidCityId($topcityid))
		{
			$topareaid = '';
			$_SESSION['topcityid'] = $topcityid;
			$_SESSION['topareaid'] = $topareaid;
			$toplocationstr = $obj_comm->getTopLocationStr($topcityid,$topareaid);
			$_SESSION['toplocationstr'] = $toplocationstr;
			
			$_SESSION['current_showing_date'] = '';	
			$_SESSION['search_region_speciality'] = $home_region_speciality;	
			$_SESSION['search_dish_items'] = $home_dish_items;	
				
			if($home_region_speciality == '')
			{
				if($home_dish_items == '')
				{
					$url = SITE_URL.'/cusines.php';		
					$hash_url_value = '';		
				}
				else
				{
					$region_id = $obj_comm->getRegionCategoryIdOfItem($home_dish_items);
					$_SESSION['search_region_speciality'] = $region_id;	
					
					$region_name = $obj_comm->getRegionCategoryNameOfItem($home_dish_items);
					$hash_cusine_str = strtolower($region_name);
					$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
					$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
					$hash_url_value = 'region'.$hash_cusine_str;		
				}
			}	
			else
			{
				if($home_dish_items == '')
				{
					$region_name = $obj_comm->getCategoryName($home_region_speciality);
					$hash_cusine_str = strtolower($region_name);
					$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
					$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
					$hash_url_value = 'region'.$hash_cusine_str;		
				}
				else
				{
					$region_name = $obj_comm->getRegionCategoryNameOfItem($home_dish_items);
					$hash_cusine_str = strtolower($region_name);
					$hash_cusine_str = str_replace(' ','-',$hash_cusine_str);
					$url = SITE_URL.'/cusines.php#region'.$hash_cusine_str;		
					$hash_url_value = 'region'.$hash_cusine_str;		
				}
			}
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid city';
		}
		
		if($hash_url_value != '')
		{
			$_SESSION['cusinescrooltodiv'] = $hash_url_value;
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$url.'::::'.$cusine_page_url.'::::'.$hash_url_value;
	echo $ret_str;
}
elseif($action == 'sethomelistareaoptions')
{
	$home_list_date = trim($_REQUEST['home_list_date']);
	$home_list_area_id = trim($_REQUEST['home_list_area_id']);
	
	$output = '<option value="">Select Area</option>';
	if(isset($_SESSION['arr_areawise_records']))
	{
		$arr_areawise_records = $_SESSION['arr_areawise_records'];
		if(is_array($arr_areawise_records) && count($arr_areawise_records) > 0)
		{
			$arr_region_id = array();
			foreach($arr_areawise_records as $kk => $vv)
			{
				//echo'<br><pre>';
				//print_r($val);
				//echo'<br></pre>';
				foreach($vv as $key => $val)
				{
					if($home_list_date == '')
					{
						//if($val['cusine_area_id'] != '-1')
						//{
							array_push($arr_region_id,$val['cusine_area_id']);	
						//}	
					}
					else
					{
						if($kk == $home_list_date)
						{
							//if($val['cusine_area_id'] != '-1')
							//{
								array_push($arr_region_id,$val['cusine_area_id']);	
							//}	
						}
							
					}
				}	
			}
			
			if(count($arr_region_id) > 0 )
			{
				$temp_area_str = implode(',',$arr_region_id);
				
				$arr_area_id = explode(',',$temp_area_str);
				
				$arr_area_id = array_unique($arr_area_id);
				$arr_area_id = array_values($arr_area_id);
				
				if(count($arr_area_id) > 0 )
				{
					for($i=0;$i<count($arr_area_id);$i++)
					{ 
						if($arr_area_id[$i] != '-1')
						{
							if($home_list_area_id == $arr_area_id[$i])
							{
								$selected = ' selected ';
							}
							else
							{
								$selected = '';
							}
							
							$output .= '<option value="'.$arr_area_id[$i].'" '.$selected.'>'.$obj_comm->getAreaName($arr_area_id[$i]).'</option>';	
						}
						else
						{
							if($home_list_area_id == $arr_area_id[$i])
							{
								$selected = ' selected ';
							}
							else
							{
								$selected = '';
							}
							
							$output .= '<option value="'.$arr_area_id[$i].'" '.$selected.'>All Areas</option>';	
						}
						
					}	
				}
			}	
		}
	}
	echo $output;
}
elseif($action == 'sethomelistregionoptions')
{
	$home_list_date = trim($_REQUEST['home_list_date']);
	$home_list_area_id = trim($_REQUEST['home_list_area_id']);
	$home_list_region_id = trim($_REQUEST['home_list_region_id']);
	
	$output = '<option value="">Select Regional Speciality</option>';
	if(isset($_SESSION['arr_areawise_records']))
	{
		$arr_areawise_records = $_SESSION['arr_areawise_records'];
		if(is_array($arr_areawise_records) && count($arr_areawise_records) > 0)
		{
			$arr_region_id = array();
			foreach($arr_areawise_records as $kk => $vv)
			{
				//echo'<br><pre>';
				//print_r($val);
				//echo'<br></pre>';
				foreach($vv as $key => $val)
				{
					if($home_list_date == '')
					{
						$go_ahead = true;
					}
					elseif($kk == $home_list_date)
					{
						$go_ahead = true;
					}
					
					if($go_ahead)
					{
						if($home_list_area_id == '')
						{
							array_push($arr_region_id,$val['region_category_id']);	
						}
						else
						{
							//if($val['cusine_area_id'] != '-1')
							//{
								$temp_a_str = explode(',',$val['cusine_area_id']);	
								if(in_array($home_list_area_id,$temp_a_str))
								{
									array_push($arr_region_id,$val['region_category_id']);	
								}
							//}	
						}
					}	
				}	
			}
			
			if(count($arr_region_id) > 0)
			{
				$arr_region_id = array_unique($arr_region_id);
				$arr_region_id = array_values($arr_region_id);
				
				for($i=0;$i<count($arr_region_id);$i++)
				{ 
					if($home_list_region_id == $arr_region_id[$i])
					{
						$selected = ' selected ';
					}
					else
					{
						$selected = '';
					}
					
					$output .= '<option value="'.$arr_region_id[$i].'" '.$selected.'>'.$obj_comm->getCategoryName($arr_region_id[$i]).'</option>';
				
				}	
			}
			
		}
	}
	    
	echo $output;
}
elseif($action == 'sethomelistitemoptions')
{
	$home_list_date = trim($_REQUEST['home_list_date']);
	$home_list_area_id = trim($_REQUEST['home_list_area_id']);
	$home_list_region_id = trim($_REQUEST['home_list_region_id']);
	$home_list_item_id = trim($_REQUEST['home_list_item_id']);
	
	$output = '<option value="">Select Dish</option>';
	if(isset($_SESSION['arr_areawise_records']))
	{
		$arr_areawise_records = $_SESSION['arr_areawise_records'];
		if(is_array($arr_areawise_records) && count($arr_areawise_records) > 0)
		{
			$arr_region_id = array();
			foreach($arr_areawise_records as $kk => $vv)
			{
				foreach($vv as $key => $val)
				{
					if($home_list_date == '')
					{
						$go_ahead = true;
					}
					elseif($kk == $home_list_date)
					{
						$go_ahead = true;
					}
					
					if($go_ahead)
					{
						if($home_list_area_id == '')
						{
							if($home_list_region_id == '')
							{
								array_push($arr_region_id,$val['item_id']);	
							}
							else
							{
								if($home_list_region_id == $val['region_category_id'])
								{
									array_push($arr_region_id,$val['item_id']);	
								}	
							}
						}
						else
						{
							//if($val['cusine_area_id'] != '-1')
							//{
								$temp_a_str = explode(',',$val['cusine_area_id']);	
								if(in_array($home_list_area_id,$temp_a_str))
								{
									if($home_list_region_id == '')
									{
										array_push($arr_region_id,$val['item_id']);	
									}
									else
									{
										if($home_list_region_id == $val['region_category_id'])
										{
											array_push($arr_region_id,$val['item_id']);	
										}	
									}
								}
							//}	
						}	
					}
				}	
			}
			
			if(count($arr_region_id) > 0)
			{
				$arr_region_id = array_unique($arr_region_id);
				$arr_region_id = array_values($arr_region_id);
				
				for($i=0;$i<count($arr_region_id);$i++)
				{ 
					if($home_list_item_id == $arr_region_id[$i])
					{
						$selected = ' selected ';
					}
					else
					{
						$selected = '';
					}
					
					$output .= '<option value="'.$arr_region_id[$i].'" '.$selected.'>'.$obj_comm->getItemName($arr_region_id[$i]).'</option>';
				}	
			}
		}
	}
	    
	echo $output;
}
elseif($action == 'sethomeallpublisheditemoptions')
{
	$home_region_speciality = trim($_REQUEST['home_region_speciality']);
	$home_dish_items = trim($_REQUEST['home_dish_items']);
	
	$output = '<option value="">Select Dish</option>';
	if(isset($_SESSION['arr_home_all_published_items']))
	{
		$arr_home_all_published_items = $_SESSION['arr_home_all_published_items'];
		if(is_array($arr_home_all_published_items) && count($arr_home_all_published_items) > 0)
		{
			$arr_home_dish_items = array();
			foreach($arr_home_all_published_items as $key => $val)
			{
				if($home_region_speciality == '')
				{
					$arr_home_dish_items[$val['item_id']] = $val['cusine_name'];
				}
				else
				{
					if($home_region_speciality == $val['region_category_id'])
					{
						$arr_home_dish_items[$val['item_id']] = $val['cusine_name'];
					}	
				}
			}	
			
			
			if(count($arr_home_dish_items) > 0)
			{
				array_unique($arr_home_dish_items, SORT_REGULAR);
				asort($arr_home_dish_items);
				
				foreach($arr_home_dish_items as $r_key => $r_val)
				{ 
					if($home_dish_items == $r_key)
					{
						$selected = ' selected ';
					}
					else
					{
						$selected = '';
					}
					
					$output .= '<option value="'.$r_key.'" '.$selected.'>'.$r_val.'</option>';
				}	
			}
		}
	}
	    
	echo $output;
}
elseif($action == 'openingredientpopup')
{
	$item_id = trim($_REQUEST['item_id']);
	
	$output = ' <div class="row">
					<div class="col-md-12 col-sm-12">
						<h4 align="center">Ingredients('.$obj_comm->getItemName($item_id).')</h4>
					</div>
				</div>	
				<div class="row" style="margin-bottom:10px;">
					<div class="col-md-12 col-sm-12 ingredient_list_box" >';
	$temp_ing_str = $obj_comm->getCommaSeperatedIngredientsOfItem($item_id);	
	if($temp_ing_str != '')
	{
		$output .= '<ul>';
		$arr_temp = explode(',',$temp_ing_str);
		for($i=0;$i<count($arr_temp);$i++)
		{
			$output .= '<li>'.$arr_temp[$i].'</li>';
		}
		$output .= '</ul>';
	}
	else
	{
		$output .= '<p class="err_msg_bold">No Ingredients Available!</p>';
		$output .= '<p class="err_msg_bold">No Ingredients Available!</p>';
	}
	
	
	
	$output .= '	</div>
				</div>';
	    
	echo $output;
}
elseif($action == 'getcontactuscategoryoption')
{
	$contactus_parent_cat_id = trim($_REQUEST['contactus_parent_cat_id']);
	$contactus_cat_id = trim($_REQUEST['contactus_cat_id']);
	    
	$data = $obj_comm->getContactUsCategoryOption($contactus_parent_cat_id,$contactus_cat_id);
    echo $data;
}
elseif($action=='docontactus')
{
	$contactus_city_id = '';
	if(isset($_POST['contactus_city_id']) && trim($_POST['contactus_city_id']) != '')
	{
		$contactus_city_id = trim($_POST['contactus_city_id']);
	}
	
	$contactus_area_id = '';
	if(isset($_POST['contactus_area_id']) && trim($_POST['contactus_area_id']) != '')
	{
		$contactus_area_id = trim($_POST['contactus_area_id']);
	}
	
	$contactus_name = '';
	if(isset($_POST['contactus_name']) && trim($_POST['contactus_name']) != '')
	{
		$contactus_name = trim($_POST['contactus_name']);
	}
	
	$contactus_email = '';
	if(isset($_POST['contactus_email']) && trim($_POST['contactus_email']) != '')
	{
		$contactus_email = trim($_POST['contactus_email']);
	}
	
	$contactus_contact_no = '';
	if(isset($_POST['contactus_contact_no']) && trim($_POST['contactus_contact_no']) != '')
	{
		$contactus_contact_no = trim($_POST['contactus_contact_no']);
	}
	
	$contactus_parent_cat_id = '';
	if(isset($_POST['contactus_parent_cat_id']) && trim($_POST['contactus_parent_cat_id']) != '')
	{
		$contactus_parent_cat_id = trim($_POST['contactus_parent_cat_id']);
	}
	
	$contactus_parent_cat_other = '';
	if(isset($_POST['contactus_parent_cat_other']) && trim($_POST['contactus_parent_cat_other']) != '')
	{
		$contactus_parent_cat_other = trim($_POST['contactus_parent_cat_other']);
	}
	
	$contactus_cat_id = '';
	if(isset($_POST['contactus_cat_id']) && trim($_POST['contactus_cat_id']) != '')
	{
		$contactus_cat_id = trim($_POST['contactus_cat_id']);
	}
	
	$contactus_cat_other = '';
	if(isset($_POST['contactus_cat_other']) && trim($_POST['contactus_cat_other']) != '')
	{
		$contactus_cat_other = trim($_POST['contactus_cat_other']);
	}
	
	$contactus_speciality_id = '';
	if(isset($_POST['contactus_speciality_id']) && trim($_POST['contactus_speciality_id']) != '')
	{
		$contactus_speciality_id = trim($_POST['contactus_speciality_id']);
	}
	
	$contactus_speciality_other = '';
	if(isset($_POST['contactus_speciality_other']) && trim($_POST['contactus_speciality_other']) != '')
	{
		$contactus_speciality_other = trim($_POST['contactus_speciality_other']);
	}
	
	$contactus_item_id = '';
	if(isset($_POST['contactus_item_id']) && trim($_POST['contactus_item_id']) != '')
	{
		$contactus_item_id = trim($_POST['contactus_item_id']);
	}
	
	$contactus_item_other = '';
	if(isset($_POST['contactus_item_other']) && trim($_POST['contactus_item_other']) != '')
	{
		$contactus_item_other = trim($_POST['contactus_item_other']);
	}
	
	$contactus_no_of_people = '';
	if(isset($_POST['contactus_no_of_people']) && trim($_POST['contactus_no_of_people']) != '')
	{
		$contactus_no_of_people = trim($_POST['contactus_no_of_people']);
	}
	
	$contactus_comments = '';
	if(isset($_POST['contactus_comments']) && trim($_POST['contactus_comments']) != '')
	{
		$contactus_comments = trim($_POST['contactus_comments']);
	}
		
	$error = 0;
	$err_msg = '';
	$url = '';
	
	if($contactus_parent_cat_id == '')
	{
		$error = 1;
		$err_msg = 'Please select enquiry type';
	}
	elseif($contactus_name == '')
	{
		$error = 1;
		$err_msg = 'Please enter your name';
	}
	elseif($contactus_email == '')
	{
		$error = 1;
		$err_msg = 'Please enter your email';
	}
	elseif(filter_var($contactus_email, FILTER_VALIDATE_EMAIL) === false)
	{
		$error = 1;
		$err_msg = 'Please enter valid email';
	}	
	elseif($contactus_contact_no == '')
	{
		$error = 1;
		$err_msg = 'Please enter your contact no';
	}
	elseif( ( !is_numeric($contactus_contact_no) ) )
	{
		$error = 1;
		$err_msg = 'Please enter valid contact numbers';
	}
	elseif($contactus_city_id == '')
	{
		$error = 1;
		$err_msg = 'Please enter your location';
	}
	
	
	if($error == '0')
	{
		$tdata = array();
		$tdata['contactus_city_id'] = $contactus_city_id;
		$tdata['contactus_area_id'] = $contactus_area_id;
		$tdata['contactus_name'] = $contactus_name;
		$tdata['contactus_email'] = $contactus_email;
		$tdata['contactus_contact_no'] = $contactus_contact_no;
		$tdata['contactus_parent_cat_id'] = $contactus_parent_cat_id;
		$tdata['contactus_parent_cat_other'] = $contactus_parent_cat_other;
		$tdata['contactus_cat_id'] = $contactus_cat_id;
		$tdata['contactus_cat_other'] = $contactus_cat_other;
		$tdata['contactus_speciality_id'] = $contactus_speciality_id;
		$tdata['contactus_speciality_other'] = $contactus_speciality_other;
		$tdata['contactus_item_id'] = $contactus_item_id;
		$tdata['contactus_item_other'] = $contactus_item_other;
		$tdata['contactus_no_of_people'] = $contactus_no_of_people;
		$tdata['contactus_comments'] = $contactus_comments;
		
		
		if($obj_comm->isUserLoggedIn())
		{
			$user_id = $_SESSION['user_id'];
		}
		else
		{
			$user_id = 0;
		}
		
		$tdata['user_id'] = $user_id;
		$tdata['cu_status'] = 1;
		
		if($obj_comm->doContactUs($tdata))
		{
			$obj_comm->sendContactUsEmailToCustomer($tdata);
			
			$error = 0;
			$url = SITE_URL.'/messages.php?id=3';
		}
		else
		{
			$error = 1;
			$err_msg = 'Something went wrong, Please try again later!';
		}
	}	
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$url;
	echo $ret_str;
}
elseif($action == 'getitemoptionspecialitywise')
{
	$speciality = trim($_REQUEST['speciality']);
	$item_id = trim($_REQUEST['item_id']);
	
	if($speciality == '')
	{
		$arr_speciality = array();
	}
	else
	{
		$arr_speciality = explode(',',$speciality);
	}
	
	if($item_id == '')
	{
		$arr_item_id = array();
	}
	else
	{
		$arr_item_id = explode(',',$item_id);
	}
	    
	$data = $obj_comm->getItemOptionSpecialityWise($arr_speciality,$arr_item_id,1,1);
    echo $data;
}
elseif($action=='docancelitem')
{
	$invoice = '';
	if(isset($_POST['invoice']) && trim($_POST['invoice']) != '')
	{
		$invoice = trim($_POST['invoice']);
	}
	
	$ocid = '';
	if(isset($_POST['ocid']) && trim($_POST['ocid']) != '')
	{
		$ocid = trim($_POST['ocid']);
	}
	
	$cancel_cat_id = '';
	if(isset($_POST['cancel_cat_id']) && trim($_POST['cancel_cat_id']) != '')
	{
		$cancel_cat_id = trim($_POST['cancel_cat_id']);
	}
	
	$cancel_cat_other = '';
	if(isset($_POST['cancel_cat_other']) && trim($_POST['cancel_cat_other']) != '')
	{
		$cancel_cat_other = trim($_POST['cancel_cat_other']);
	}
	
	$cancel_comments = '';
	if(isset($_POST['cancel_comments']) && trim($_POST['cancel_comments']) != '')
	{
		$cancel_comments = trim($_POST['cancel_comments']);
	}
	
	$error = 0;
	$err_msg = '';
	$url = '';
	
	if($obj_comm->isUserLoggedIn())
	{
		$user_id = $_SESSION['user_id'];
	}
	else
	{
		$user_id = 0;
	}
	
	if($invoice == '')
	{
		$error = 1;
		$err_msg = 'Please enter invoice';
	}
	elseif($ocid == '')
	{
		$error = 1;
		$err_msg = 'Please enter item';
	}
	elseif($cancel_cat_id == '')
	{
		$error = 1;
		$err_msg = 'Please select cancel reason';
	}
	elseif($cancel_cat_id == '221')
	{
		if($cancel_cat_other == '')
		{
			$error = 1;
			$err_msg = 'Please enter other cancel reason';
		}
	}	
	
	if($error == '0')
	{
		$arr_order_record = $obj_comm->getOrderDetailsByInvoiceAndUserId($invoice,$user_id);
		if(count($arr_order_record) == 0)
		{
			$error = 1;
			$err_msg = 'Invalid Invoice';
		}	
		else
		{
			$arr_order_cart_record = $obj_comm->getOrderCartDetailsByInvoiceAndUserId($invoice,$user_id,$ocid);
			if(count($arr_order_cart_record) == 0)
			{
				$error = 1;
				$err_msg = 'Invalid Invoice Item';
			}
			else
			{
				if($arr_order_cart_record['cancel_request_sent'] == '1')
				{
					$error = 1;
					$err_msg = 'Cancel request already sent for this item';
				}
				else
				{
					if(!$obj_comm->chkIfItemCaneBeCancelled($arr_order_cart_record['invoice'],$arr_order_cart_record['prod_id'],$arr_order_cart_record['order_cart_delivery_date']))
					{
						$error = 1;
						$err_msg = 'This item cannot be cancelled now.';
					}
				}
			}
		}
	}
	
	if($error == '0')
	{
		$tdata = array();
		$tdata['invoice'] = $invoice;
		$tdata['order_cart_id'] = $ocid;
		$tdata['cancel_cat_id'] = $cancel_cat_id;
		$tdata['cancel_cat_other'] = $cancel_cat_other;
		$tdata['cancel_comments'] = $cancel_comments;
		$tdata['cancel_request_sent'] = 1;
		$tdata['cancel_request_by_admin'] = 0;
		$tdata['cancel_request_by_admin_id'] = 0;
		$tdata['user_id'] = $user_id;
		
		if($obj_comm->doCancelItem($tdata))
		{
			//$obj_comm->sendContactUsEmailToCustomer($tdata);
			$error = 0;
			$url = SITE_URL.'/view_order.php?invoice='.$invoice;
		}
		else
		{
			$error = 1;
			$err_msg = 'Something went wrong, Please try again later!';
		}
	}	
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$url;
	echo $ret_str;
}
elseif($action=='dovendorregistrationproceed')
{
	$va_cat_id = '';
	if(isset($_POST['va_cat_id']) && trim($_POST['va_cat_id']) != '')
	{
		$va_cat_id = trim($_POST['va_cat_id']);
	}
	
	$error = 0;
	$err_msg = '';
	$url = '';
	
	if($va_cat_id == '')
	{
		$error = 1;
		$err_msg = 'Please select category';
	}
	
	if($error == '0')
	{
		$va_id = $obj_comm->getVAIDFromVACATID($va_cat_id);
		if($va_id > 0)
		{
			$url = BA_URL.'/register.php?vtoken='.base64_encode($va_id);	
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid category';
		}
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$url;
	echo $ret_str;
}