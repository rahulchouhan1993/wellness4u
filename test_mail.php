<?php
//require_once 'class.phpmailer.php';
require_once 'phpmailer/PHPMailerAutoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$error = false;
$err_msg = '';

function sendmail()
{
try 
		{
    $MYEMAIL = 'ramakantyadavmca@gmail.com';
    $from_name = 'Ramakant';
    $from_email = 'ramakant@sriyaan.com';
    $from_contact = '8692991037';
    $subject = 'Contact Mail from website';
    $message_body.="<p> Contact Name : Ramakant </p>";
    $message_body.="<p> Contact Email : ramakant@gmail.com </p>";
    $message_body.="<p> Contact Number : 8692991037 </p>";
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'ostrichcrafts663@gmail.com';
    $mail->Password = 'crafts@1234';
    $mail->SetFrom($from_email, $from_name);
    $mail->addAddress($MYEMAIL);
    $mail->Subject = $subject;
    $mail->MsgHTML($message_body);
    
    if($mail->Send())
    {
        echo "Mail send ";
    }
    else
    {
        echo "Mail failed";
    }
    $mail->ClearAddresses();
   }      
    catch (Exception $e) 
    {
        echo $e->getMessage();
    }
}

sendmail();

//    $err_msg ='Message send successfull ostrichcrafts team will contact you soon.';
//    $response=array('msg'=>$err_msg,'status'=>1);
//    echo json_encode($response);
//    exit(0);    