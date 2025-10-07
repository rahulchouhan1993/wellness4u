<?php
include('classes/config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('classes/phpmailer/src/PHPMailer.php');

$obj = new frontclass();

$email = 'ramakantyadavmca@gmail.com';
$name='Ramakant';
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


$mail = new PHPMailer();
try {
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
}
catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
?>