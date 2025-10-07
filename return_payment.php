<?php 
require_once('classes/config.php');
// require_once('classes/commonFunctions.php');

$obj = new frontclass();
$page_id = 5;
$arr_page_details = $obj->getFrontPageDetails($page_id);

$stringData = '[RETURN_PAYPAL] _REQUEST:'.print_r($_REQUEST,1);
$obj->debuglogpayment($stringData);

if($obj->isLoggedIn())
{
	$user_id = $_SESSION['user_id'];
	$obj->updateUserOnlineTimestamp($user_id);
}
else
{
	echo '<script>window.location.href="'.SITE_URL.'/messages.php"</script>';
	exit(0);
}

$secret_key = EBS_SECRET_KEY; // Pass Your Registered Secret Key from EBS secure Portal
//$account_id = EBS_ACCOUNT_ID;

$error = false;
$err_msg = '';


if(isset($_REQUEST))
{
	$response = $_REQUEST;
	$invoice = $response['MerchantRefNo'];	
	
	$arr_order_details = $obj->getOrderDetailsByInvoice($invoice);
	if(is_array($arr_order_details) && count($arr_order_details) > 0 )
	{
		$tdata = array();
		$tdata['invoice'] = $invoice;			
		if($response['ResponseCode'] == '0')
		{
			$tdata['order_status'] = '1';		
			$tdata['payment_status'] = '1';		
		}
		else
		{
			$tdata['order_status'] = '2';		
			$tdata['payment_status'] = '0';		
		}
		
		if(isset($response['TransactionID']))
		{
			$tdata['ebs_trans_id'] = $response['TransactionID'];		
		}
		else
		{
			$tdata['ebs_trans_id'] = '';		
		}
		
		if(isset($response['PaymentID']))
		{
			$tdata['ebs_payment_id'] = $response['PaymentID'];		
		}
		else
		{
			$tdata['ebs_payment_id'] = '';		
		}
		
		if(isset($response['ResponseCode']))
		{
			$tdata['ebs_response_code'] = $response['ResponseCode'];		
		}
		else
		{
			$tdata['ebs_response_code'] = '';		
		}
		
		if(isset($response['ResponseMessage']))
		{
			$tdata['ebs_response_msg'] = $response['ResponseMessage'];		
		}
		else
		{
			$tdata['ebs_response_msg'] = '';		
		}
		
		if(isset($response['DateCreated']))
		{
			$tdata['ebs_date'] = $response['DateCreated'];		
		}
		else
		{
			$tdata['ebs_date'] = '';		
		}
		
		if(isset($response['PaymentMethod']))
		{
			$tdata['ebs_payment_method'] = $response['PaymentMethod'];		
		}
		else
		{
			$tdata['ebs_payment_method'] = '';		
		}
		
		if(isset($response['RequestID']))
		{
			$tdata['ebs_request_id'] = $response['RequestID'];		
		}
		else
		{
			$tdata['ebs_request_id'] = '';		
		}
		
		if(isset($response['SecureHash']))
		{
			$tdata['ebs_secure_hash'] = $response['SecureHash'];		
		}
		else
		{
			$tdata['ebs_secure_hash'] = '';		
		}
		
		if(isset($response['IsFlagged']))
		{
			$tdata['ebs_is_flagged'] = $response['IsFlagged'];		
		}
		else
		{
			$tdata['ebs_is_flagged'] = '';		
		}
		
		if($obj->updateOrderPaymentStatus($tdata))
		{
			$sh = $response['SecureHash'];	
			$params = $secret_key;
			ksort($response);
			foreach ($response as $key => $value)
			{
				if (strlen($value) > 0 and $key!='SecureHash') 
				{
					$params .= '|'.$value;
				}
			}
						
		//$hashValue = strtoupper(md5($params));//for MD5
		//$hashValue = strtoupper(hash("sha1",$params));//for SHA1
			$hashValue = strtoupper(hash("sha512",$params));// for SHA512
			if($sh!=$hashValue)
			{
				//$error = true;
				//$err_msg = '<center><h3 class="err_msg_bold">Hash validation Failed!</h3></center>';
			}
			
			if($tdata['ebs_response_code'] == '0')
			{
				$obj->updateProdQtyAfterOrderPlaced($invoice);
				$obj->removeAllItemsFromCart();
				$obj->sendInvoiceEmailToCustomer($invoice);
								
				$err_msg = '<center><h3 class="succ_msg_bold">Your Order Successfully Completed!</h3></center>';
			}			
			else
			{
				$error = true;
				$err_msg = '<center><h3 class="err_msg_bold">Your payment is failed!</h3></center>';
			}
			
			// SENDSMS TO CUSTOMER - ORDER - START
			$tdata_sms = array();
			$tdata_sms['mobile_no'] = $arr_order_details['user_mobile_no'];
			$tdata_sms['sms_message'] = $obj->getOrderSmsText($tdata);
			$obj->sendSMS($tdata_sms);
			// SENDSMS TO CUSTOMER - ORDER - END
			
			// SENDSMS TO ADMIN - ORDER - START
			$tdata_sms_admin = array();
			$tdata_sms_admin['mobile_no'] = '8828033111';
			$tdata_sms_admin['sms_message'] = $obj->getOrderSmsTextAdmin($tdata);
			$obj->sendSMS($tdata_sms_admin);
			// SENDSMS TO ADMIN - ORDER - END
			
			// SENDSMS TO VENDOR - ORDER - START
			$arr_temp_vendor_id = $obj->getUniqueVendorIdsOfInvoice($tdata['invoice']);
			if(count($arr_temp_vendor_id) > 0)
			{
				for($vi=0;$vi<count($arr_temp_vendor_id);$vi++)
				{
					$tdata['vendor_id'] = $arr_temp_vendor_id[$vi];
					$tdata_sms_vendor = array();
					$tdata_sms_vendor['mobile_no'] = $obj->getVendorContactNumber($arr_temp_vendor_id[$vi]);
					$tdata_sms_vendor['sms_message'] = $obj->getOrderSmsTextVendor($tdata);
					$obj->sendSMS($tdata_sms_vendor);		
				}
				
			}
			// SENDSMS TO VENDOR - ORDER - END
					
		}
		else
		{
			$error = true;
			$err_msg = '<center><h3 class="err_msg_bold">Somthing went wrong! Please contact support.</h3></center>';
		}
	}
	else
	{
		$error = true;
		$err_msg = '<center><h3 class="err_msg_bold">Invalid Invoice !</h3></center>';
	}
}
else
{
	$error = true;
	$err_msg = '<center><h3 class="err_msg_bold">Invalid access !</h3></center>';
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once('head.php');?>
</head>
<body>
<?php include_once('header.php');?>
<section id="checkout">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
			
			</div>
	     	<div class="col-md-6">
				<p><?php echo $err_msg;?></p>
			</div>
			<div class="col-md-3">
			
			</div>
		</div>                        
	</div>   
</section>
<?php include_once('footer.php');?>
</body>
</html>