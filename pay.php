<?php 
require_once('classes/config.php');
// require_once('classes/functions.php');

$obj = new frontclass();
$page_id = 4;


$arr_page_details = $obj->getFrontPageDetails($page_id);



if(!$obj->isLoggedIn())
{
	echo '<script>window.location.href="'.SITE_URL.'/messages.php"</script>';
	exit(0);
}



if($obj->chkIfCartEmpty())
{
	echo '<script>window.location.href="'.SITE_URL.'/messages.php"</script>';
	exit(0);
}

if(isset($_GET['ref']) && trim($_GET['ref']) != '')
{
	$invoice = $_GET['ref'];
}
else
{
	echo '<script>window.location.href="'.SITE_URL.'/messages.php"</script>';
	exit(0);
}



$arr_order_details = $obj->getOrderDetailsByInvoice($invoice);





if(is_array($arr_order_details) && count($arr_order_details) > 0 )
{
	
	$hashData = EBS_SECRET_KEY; //Pass your Registered Secret Key
	$account_id = EBS_ACCOUNT_ID;


	
	$address = '';
	if($arr_order_details['user_building_name'] != '')
	{
		$address .= $arr_order_details['user_building_name'].', ';	
	}
	else
	{
		$address .= '';	
	}


	
	if($arr_order_details['user_floor_no'] != '')
	{
		$address .= $arr_order_details['user_floor_no'].', ';	
	}
	else
	{
		$address .= '';	
	}
	
	if($arr_order_details['user_address'] != '')
	{
		$address .= $arr_order_details['user_address'].', ';	
	}
	else
	{
		$address .= '';	
	}
	
	  // $address='saikuroas';

	$amount = $arr_order_details['order_total_amt'];
	$bank_code = '';
	$card_brand = '';
	$channel = '0';
	$city = $arr_order_details['user_city_name'];
	$country = strtoupper(substr($arr_order_details['user_country_name'],0,3));
	$currency = 'INR';


	$description = 'Shopping cart payment';
	$display_currency = 'INR';
	$display_currency_rates = 1;
	$email = $arr_order_details['user_email'];
	$emi = '';
	$mode = EBS_MODE;
	$name = $arr_order_details['user_name'];
	$ebs_page_id = '';
	$payment_mode = '';
	$payment_option = '';
    $phone = $arr_order_details['user_mobile_no'];

    // $phone = '8655615809';
	$postal_code = $arr_order_details['user_pincode'];
	// $postal_code = '421306';

	$reference_no = $invoice;
	$return_url = SITE_URL.'/return_payment.php';
	$ship_address = $address;
 // $ship_address = 'Saikrupa housing society kolsewady';

	$ship_city = $city;
	$ship_country = $country;
	$ship_name = $name;
	$ship_phone = $phone;
	$ship_postal_code = $postal_code;
	$state = $arr_order_details['user_state_name'];
	$ship_state = $state;
	
    $hashData .= '|'.$account_id.'|'.$address.'|'.$amount.'|'.$channel.'|'.$city.'|'.$country.'|'.$currency.'|'.$description.'|'.$display_currency;
    $hashData .= '|'.$display_currency_rates.'|'.$email.'|'.$mode.'|'.$name.'|'.$phone.'|'.$postal_code.'|'.$reference_no.'|'.$return_url.'|'.$ship_address;
    $hashData .= '|'.$ship_city.'|'.$ship_country.'|'.$ship_name.'|'.$ship_phone.'|'.$ship_postal_code.'|'.$state.'|'.$ship_state;



// $hashData .= '|'.$account_id.'|'.$amount.'|'.$channel.'|'.$city.'|'.$currency.'|'.$description.'|'.$display_currency;
// $hashData .= '|'.$display_currency_rates.'|'.$email.'|'.$mode.'|'.$name.'|'.$phone.'|'.$reference_no.'|'.$return_url;
// $hashData .= '|'.$ship_city.'|'.$ship_name.'|'.$ship_phone;


  // echo "<pre>";print_r($hashData);echo "<pre>";
                // exit;

	// $hashData .= '|'.$account_id.'|'.$amount.'|'.$reference_no.'|'.$return_url.'|'.$mode.'|'.$address.'|'.$channel.'|'.$city.'|'.$country.'|'.$currency.'|'.$description.'|'.$display_currency;
	// $hashData .= '|'.$display_currency_rates.'|'.$email.'|'.$name.'|'.$phone.'|'.$postal_code.'|'.$ship_address;
	// $hashData .= '|'.$ship_city.'|'.$ship_country.'|'.$ship_name.'|'.$ship_phone.'|'.$ship_postal_code.'|'.$state.'|'.$ship_state;
	
 //    $hashData .= '|'.$account_id.'|'.$address.'|'.$amount.'|'.$channel.'|'.$city.'|'.$country.'|'.$currency.'|'.$description.'|'.$display_currency.'|'.$display_currency_rates.'|'.$email.'|'.$mode.'|'.$name.'|'.$phone.'|'.$postal_code.'|'.$reference_no.'|'.$return_url.'|'.$ship_address;
	// $hashData .= '|'.$ship_city.'|'.$ship_country.'|'.$ship_name.'|'.$ship_phone.'|'.$ship_postal_code.'|'.$state.'|'.$ship_state;
 
// $hash = $hashData."|".$account_id."|".$amount."|".$reference_no."|".$return_url."|".$mode;

// echo $hashData;
        
 // echo "<pre>";print_r($hash);echo "</pre>";

// echo "<pre>";print_r($hashData);echo "</pre>";
// exit;
		
	if (strlen($hashData) > 0) {
	       $secure_hash = strtoupper(hash("sha512",$hashData));//for SHA512
		// $secure_hash = strtoupper(hash("sha1",$hashData));//for SHA1
		// $secure_hash = strtoupper(md5($hashData));//for MD5


	}
// 	echo "<pre>";print_r($user_id );echo "</pre>";
// exit;
 
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
			<div class="col-md-12">	

			

			      	<form action="https://secure.ebs.in/pg/ma/payment/request" name="payment" method="POST">
					<input type="hidden" value="<?php echo $account_id;?>" name="account_id"/>
					<input type="hidden" value="<?php echo $address;?>" name="address"/>
					<input type="hidden" value="<?php echo $amount;?>" name="amount"/>
					<input type="hidden" value="<?php echo $bank_code;?>" name="bank_code"/>
					<input type="hidden" value="<?php echo $card_brand;?>" name="card_brand"/>
					<input type="hidden" value="<?php echo $channel;?>" name="channel"/>
					<input type="hidden" value="<?php echo $city;?>" name="city"/>
					<input type="hidden" value="<?php echo $country;?>" name="country"/>
					<input type="hidden" value="<?php echo $currency;?>" name="currency"/>
					<input type="hidden" value="<?php echo $description;?>" name="description"/>
					<input type="hidden" value="<?php echo $display_currency;?>" name="display_currency"/>
					<input type="hidden" value="<?php echo $display_currency_rates;?>" name="display_currency_rates"/>
					<input type="hidden" value="<?php echo $email;?>" name="email"/>
					<input type="hidden" value="<?php echo $emi;?>" name="emi"/>
					<input type="hidden" value="<?php echo $mode;?>" name="mode"/>
					<input type="hidden" value="<?php echo $name;?>" name="name"/>
					<input type="hidden" value="<?php echo $ebs_page_id;?>" name="page_id"/>
					<input type="hidden" value="<?php echo $payment_mode;?>" name="payment_mode"/>
					<input type="hidden" value="<?php echo $payment_option;?>" name="payment_option"/>
					<input type="hidden" value="<?php echo $phone;?>" name="phone"/>
					<input type="hidden" value="<?php echo $postal_code;?>" name="postal_code"/>
					<input type="hidden" value="<?php echo $reference_no;?>" name="reference_no"/>
					<input type="hidden" value="<?php echo $return_url; ?>" name="return_url"/>
					<input type="hidden" value="<?php echo $ship_address;?>" name="ship_address"/>
					<input type="hidden" value="<?php echo $ship_city;?>" name="ship_city"/>
					<input type="hidden" value="<?php echo $ship_country;?>" name="ship_country"/>
					<input type="hidden" value="<?php echo $ship_name;?>" name="ship_name"/>
					<input type="hidden" value="<?php echo $ship_phone;?>" name="ship_phone"/>
					<input type="hidden" value="<?php echo $ship_postal_code;?>" name="ship_postal_code"/>
					<input type="hidden" value="<?php echo $ship_state;?>" name="ship_state"/>
					<input type="hidden" value="<?php echo $state;?>" name="state"/>
					<input type="hidden" value="<?php echo $secure_hash; ?>" name="secure_hash"/>
					 <button onclick="document.payment.submit();" id="defaultOpen" style="display: none;"> SUBMIT </button>
				</form>	
			</div>
		</div>
		<div class="row">
			<div class="col-md-4"> 
			</div>
			<div class="col-md-4">
				<div style="float:left;width:100%;text-align:center;">
					<img border="0" width="200" src="<?php echo SITE_URL.'/images/loading.gif'?>">
				</div>
				<div style="float:left;width:100%;margin:20px;">
					<p class="payment_msg">Please Wait!</p>
					<p class="payment_msg">Your Payment is processing.</p>
					<p class="payment_msg">Do not refresh/reload the page</p>
				</div>
			</div>
			<div class="col-md-4">
			  <!-- <p id="defaultOpen"></p> -->
			</div>

		</div>
	</div>
</section>	


<!-- <input name="account_id" value="<?php echo $account_id;?>" type="hidden">
<input name="return_url" size="60" value="<?php echo $return_url; ?>" type="hidden">
<input name="mode" size="60" value="<?php echo $mode; ?>" type="hidden">

<input name="reference_no" value="<?php echo $order_no; ?>" type="hidden">
<input name="description" value="<?php echo $modelno; ?>" type="hidden">
<input name="name" maxlength="255" value="<?php echo $ebsuser_name; ?>" type="hidden">
<input name="address" maxlength="255" value="<?php echo $ebsuser_address; ?>" type="hidden">
<input name="city" maxlength="255" value="<?php echo $ebsuser_city; ?>" type="hidden">
<input name="state" maxlength="255" value="<?php echo $ebsuser_state; ?>" type="hidden">
<input name="postal_code" maxlength="255" value="<?php echo $ebsuser_zipcode; ?>" type="hidden">
<input name="country" maxlength="255" value="<?php echo $ebsuser_country; ?>" type="hidden">
<input name="phone" maxlength="255" value="<?php echo $ebsuser_phone; ?>" type="hidden">
<input name="email" size="60" value="<?php echo $ebsuser_email; ?>" type="hidden">
<input name="secure_hash" size="100" value="<?php echo $secure_hash; ?>" type="hidden">
<input name="amount" id="amount" readonly="" value="<?php echo $finalamount; ?>" type="hidden">  -->
<?php include_once('footer.php');?>	
</body>
</html>
<?php	
}
else
{

	echo '<script>window.location.href="'.SITE_URL.'/messages.php"</script>';
}






