<?php 

require_once('classes/config.php');

$obj = new frontclass();

$page_id = '3';

$page_data = $obj->getPageDetails($page_id);



if(isset($_GET['id']) && $_GET['id'] != '')

{

	$msg_id = $_GET['id'];	

}

else

{

	$msg_id = 0;	

}



if($obj->isLoggedIn())

{

	

	$obj->doUpdateOnline($_SESSION['user_id']);

}







if($msg_id == '1')

{

	$page_title = 'Error';

	$page_content = 'Sorry seat is not available for this batch';

}

elseif($msg_id == '2')

{

	$page_title = 'Error';

	$page_content = '<p>Your password reset successfully, <a href="'.SITE_URL.'/login.php">Click here</a> to login</p>';

}

elseif($msg_id == '3')

{

	$page_title = 'Error';

	$page_content = '<p>Thank you for your enquiry, We will get back to you soon.</p>';

}

elseif($msg_id == '4')

{

	$page_title = 'Error';

	$page_content = '<p>Your password changed successfully, </p>';

}

// elseif($msg_id == '5')

// {

//         $sess = $_GET['sess'];

// 	$page_title = 'Registration Success';

// 	$page_content = '<p>Thank you for Registration, Please activate your profile using otp sned on your registered mobile number using below link .</p>';

//         $page_content .= '<a href="validate_pro_user.php?sess='.$sess.'">Activate</a>';

        

        

// }



// elseif($msg_id == '6')

// {

// 	$page_title = 'Error';

// 	$page_content = '<p>Your password reset successfully, <a href="'.SITE_URL.'/wa_register.php">Click here</a> to login</p>';

// }

else

{

	$page_title = 'Error';

	$page_content = '<p class="err_msg_bold">Invalid access</p>';

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

	     	<div class="col-md-12" style="margin: 7.5px;padding: 7.5px;">
	     		<br><br>
				<p><?php echo $page_content; ?></p>

			</div>

		</div>                        

	</div>   

</section>

<?php include_once('footer.php');?>

</body>

</html>