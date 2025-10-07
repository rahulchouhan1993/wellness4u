<?php
include('classes/config.php');
$page_id = '130';
$obj = new frontclass();
$obj2 = new Profclass();
$page_data = $obj->getPageDetails($page_id);
//list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$error = false;
$err_msg = '';
if(isset($_GET['sess']) && $_GET['sess'] != '')
{
	$sess = $_GET['sess'];
	$email = base64_decode($sess);

	if(!$obj2->chkVenderEmailExists($email))
	{
		$error = true;
		$err_msg = 'Invalid Access!';
		header('location:message.php');
		exit(0);
	}
	else
	{
		if($obj2->doValiadteVenderUser($email))

		{

			$pro_user_id = $obj2->getVenderUserId($email);
			$name = $obj2->getVenderUserFullNameById($pro_user_id);
			$unique_id = $obj2->getVenderUserUniqueId($pro_user_id);

			$err_msg = 'Welcome '.$name.'! You\'re now registered member  <a href="https://www.wellnessway4u.com/wa_register.php">Click here to Sign In</a>';		

			/*
			$to_email = $email;
			$from_email = 'info@wellnessway4u.com';
			$from_name = 'info';
			$subject = 'Welcome to Wellness Way 4 U!';
			$message = '<p><strong>Hi '.$name.',</strong><p>';
			$message .= '<p>Congrats on becoming an wellness way for you user. We\'re glad you\'ve decided to join all of us.	</p>';
			$message .= '<p>Your Username is <strong>'.$email.'</strong>	</p>';
			$message .= '<p>Your Unique Id is <strong>'.$unique_id.'</strong>	</p>';
			$message .= '<p>Best Regards</p>';
			$message .= '<p>www.wellnessway4u.com</p>';
			*/
			
                        $mail_data =$obj->getEmailAutoresponderDetails('4'); 
			$to_email = $email;
			$from_email = $mail_data['email_ar_from_email'];
			$from_name = $mail_data['email_ar_from_name'];
			$subject = $mail_data['email_ar_subject'];
			$message = $mail_data['email_ar_body'];
                        
                        
			//list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = getEmailAutoresponderDetails('4');
			
//			$to_email = $email;
//			$from_email = $email_ar_from_email;
//			$from_name = $email_ar_from_name;
//			$subject = $email_ar_subject;
//			$message = $email_ar_body;
			
			$message = str_ireplace("[[ADVISER_NAME]]", $name, $message);
			$message = str_ireplace("[[ADVISER_EMAIL]]", $email, $message);
			$message = str_ireplace("[[ADVISER_UNIQUE_ID]]", $unique_id, $message);

			

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

		}

	}

}

else

{

	$error = true;

	$err_msg = 'Invalid Access!';

	header('location:message.php');

	exit(0);

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
	     	<div class="col-md-12">
				<p><?php echo $err_msg;?></p>
			</div>
		</div>                        
	</div>   
</section>
<?php include_once('footer.php');?>
</body>
</html>