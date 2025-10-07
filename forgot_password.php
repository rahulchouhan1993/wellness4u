<?php 



include('classes/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('classes/phpmailer/src/PHPMailer.php');
include('classes/phpmailer/src/SMTP.php');
include('classes/phpmailer/src/Exception.php');

$obj = new frontclass();



$page_id = '41';



$page_data = $obj->getPageDetails($page_id);











if($obj->isLoggedIn())







{







	$obj->doUpdateOnline($_SESSION['user_id']);



        







}







$error = false;



$err_msg = '';



if(isset($_POST['btnSubmit']))







{     



	$email = trim($_POST['email']);



	if($email == '') 







	{







		$error = true;



		$err_msg = "Please enter email address.";



	}



	elseif(!$obj->chkValidEmailID($email))



	{



		$error = true;



		$err_msg = "Please enter valid email address.";



	}







	if(!$error)







		{



            



                        $name = $obj->GetUserName($email);



			$url      = SITE_URL.'/reset_password.php?sess='.base64_encode($email).'';







			$mail_data =$obj->getEmailAutoresponderDetails('5'); 







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



                        //$message = str_ireplace("[[OTP]]", $url, $message);







			// $mail = new PHPMailer();



			// $mail->IsHTML(true);



			// $mail->Host = "batmobile.websitewelcome.com"; // SMTP server



			// $mail->From = $from_email;



			// $mail->FromName = $from_name;



			// $mail->AddAddress($to_email);



			// $mail->Subject = $subject;



			// $mail->Body = $message;



			// $mail->Send();



			// $mail->ClearAddresses();



			$mail = new PHPMailer(true);
			$mail->isSMTP();
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;
			$mail->Username = "wellnessway4u@gmail.com"; // replace
			$mail->Password = "ilukxkfhjpbnzwxt"; // replace
			$mail->SMTPSecure = "tls"; 
			$mail->Port = 587;
			// $mail->SMTPDebug = 0;
			// $mail->Debugoutput = 'html';
			
			$mail->setFrom($from_email, $from_name);
    		$mail->addAddress($to_email);
			
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body    = $message;
			$mail->send();
			// if(!$mail->send()) {
			//     echo 'Mailer Error: ' . $mail->ErrorInfo;
			// } else {
			//     echo 'Message sent';
			// }



			header("Location: message.php?msg=11&sess=".base64_encode($email)."");  //10 is old message id







		}







}







if(isset($_REQUEST['action']) && $_REQUEST['action'] =='resendotp')



    {



        



    $response=array();



    



    $choice = $_REQUEST['choice'];



    



    if($choice == 'Mail')



    {



       $error = false;



       $response=array();



       $email = trim($_POST['email_mobile']);



	if($email == '') 







	{



                $response['err_msg'] = "Please enter email address.";



                $response['error'] = 1;



                $response['otp_type'] = "Mail";



                $error = true;



		echo json_encode(array($response));



                exit(0); 



	}



	elseif(!$obj->chkValidEmailID($email))



	{



                $response['err_msg'] = "Please enter valid email address.";



                $response['error'] = 1;



                $response['otp_type'] = "Mail";



                $error = true;



		echo json_encode(array($response));



                exit(0); 



	}







	if(!$error)







		{



            



                        $name = $obj->GetUserName($email);



			$url      = SITE_URL.'/reset_password.php?sess='.base64_encode($email).'';







			$mail_data =$obj->getEmailAutoresponderDetails('5'); 







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







			// $mail = new PHPMailer();



			// $mail->IsHTML(true);



			// $mail->Host = "batmobile.websitewelcome.com"; // SMTP server



			// $mail->From = $from_email;



			// $mail->FromName = $from_name;



			// $mail->AddAddress($to_email);



			// $mail->Subject = $subject;



			// $mail->Body = $message;



			// $mail->Send();



			// $mail->ClearAddresses();

			$mail = new PHPMailer(true);
			$mail->isSMTP();
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;
			$mail->Username = "wellnessway4u@gmail.com"; // replace
			$mail->Password = "ilukxkfhjpbnzwxt"; // replace
			$mail->SMTPSecure = "tls"; 
			$mail->Port = 587;
			// $mail->SMTPDebug = 0;
			// $mail->Debugoutput = 'html';
			
			$mail->setFrom($from_email, $from_name);
    		$mail->addAddress($to_email);
			
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body    = $message;
			$mail->send();

			// if(!$mail->send()) {
			//     echo 'Mailer Error: ' . $mail->ErrorInfo;
			// } else {
			//     echo 'Message sent';
			// }







                        $response['err_msg'] = "success";



                        $response['error'] = 0;



                        $response['otp_type'] = "Mail";



                        $response['send_to_page_data'] = base64_encode($email);



                        $error = true;



                        echo json_encode(array($response));



                        exit(0); 



                        



			//header("Location: message.php?msg=10&sess=".base64_encode($email).""); 







		} 



        



    }



    



    if($choice == 'Mobile')



    {



      

        



        $signup_mobile_no = '';



        if(isset($_POST['email_mobile']) && trim($_POST['email_mobile']) != '')



	{



		$signup_mobile_no = trim($_POST['email_mobile']);



	}



       	



	$error = false;



	$err_msg = '';



        



        if($signup_mobile_no == '')



	{		



                $response['err_msg'] = "Please enter mobile no";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = true;



		echo json_encode(array($response));



                exit(0); 



	}



	elseif( ( !is_numeric($signup_mobile_no) ) || ( strlen($signup_mobile_no) != 10 ) )



	{



		



                $response['err_msg'] = "Please enter valid 10 digits numbers only";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = true;



		echo json_encode(array($response));



                exit(0); 



	}



	elseif(!preg_match("/^[0-9]+$/",$signup_mobile_no)  )



	{		



                $response['err_msg'] = "Please enter valid 10 digits numbers only!";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = true;



		echo json_encode(array($response));



                exit(0); 



                



	}



	elseif(!$obj->chkMobileExists($signup_mobile_no))



	{



	



                $response['err_msg'] = "This mobile number not registered";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = true;



		echo json_encode(array($response));



                exit(0); 



	}



        



        if(!$error)



	{



		$tdata = array();



		$tdata['mobile_no'] = $signup_mobile_no;



		$tdata['user_otp'] = rand(1000,9999);



				



		if($obj->reSendOTP($tdata))



		{



			$tdata_sms = array();



			$tdata_sms['mobile_no'] = $signup_mobile_no;



			// $tdata_sms['sms_message'] = $obj->getOTPSmsText($tdata); //comment by ample 15-06-20

			// $obj->sendSMS($tdata_sms);



			//added by ample 15-06-20

			$email = $obj->getUserEmailByMobile($signup_mobile_no);

			$name = $obj->GetUserName($email);    	

			$url      = SITE_URL.'/reset_password.php?sess='.base64_encode($email).'';

			$mail_data =$obj->getEmailAutoresponderDetails('14'); 

			$to_email = $email;

			$from_email = $mail_data['email_ar_from_email'];

			$from_name = $mail_data['email_ar_from_name'];

			$subject = $mail_data['email_ar_subject'];

			$message = $mail_data['email_ar_body'];

			$message = str_ireplace("[[USER_NAME]]", $name, $message);

			$message = str_ireplace("[[USER_EMAIL]]", $email, $message);

			$message = str_ireplace("[[OTP]]", $tdata['user_otp'], $message);

			$message = str_ireplace("[[URL]]", $url, $message);

			// $mail = new PHPMailer();

			// $mail->IsHTML(true);

			// $mail->Host = "batmobile.websitewelcome.com"; // SMTP server

			// $mail->From = $from_email;

			// $mail->FromName = $from_name;

			// $mail->AddAddress($to_email);

			// $mail->Subject = $subject;

			// $mail->Body = $message;

			// $mail->Send();

			// $mail->ClearAddresses();

			$mail = new PHPMailer(true);
			$mail->isSMTP();
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;
			$mail->Username = "wellnessway4u@gmail.com"; // replace
			$mail->Password = "ilukxkfhjpbnzwxt"; // replace
			$mail->SMTPSecure = "tls"; 
			$mail->Port = 587;
			// $mail->SMTPDebug = 0;
			// $mail->Debugoutput = 'html';
			
			$mail->setFrom($from_email, $from_name);
    		$mail->addAddress($to_email);
			
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body    = $message;

			$mail->send();

			// if(!$mail->send()) {
			//     echo 'Mailer Error: ' . $mail->ErrorInfo;
			// } else {
			//     echo 'Message sent';
			// }



			//add by ample 11-07-20

			$sms_credential=$obj->get_SMS_credential($mail_data['SMS_ID']); 

			$tdata_sms['SMS_USERNAME']=$sms_credential['SMS_USERNAME'];

	        $tdata_sms['SMS_PASSWORD']=$sms_credential['SMS_PASSWORD'];

	        $tdata_sms['SMS_SENDERID']=$sms_credential['SMS_SENDERID'];

	        $tdata_sms['SMS_URL']=$sms_credential['SMS_URL'];

	        //add by ample 11-07-20



			$tdata_sms['sms_message'] = strip_tags($message); //add by ample 15-06-20

			$obj->sendSMS($tdata_sms);



		

                        $response['err_msg'] = "New OTP sent successfully";



                        $response['error'] = 0;



                        $response['otp_type'] = "Mobile";



                        $error = true;



                        echo json_encode(array($response));



                        exit(0);



		}



		else



		{



			



                        $response['err_msg'] = "Something went wrong, Please try again later!";



                        $response['error'] = 1;



                        $response['otp_type'] = "Mobile";



                        $error = true;



                        echo json_encode(array($response));



                        exit(0);



		}



	}



        



        



    } 



    



    



    }











 if(isset($_REQUEST['action']) && $_REQUEST['action'] =='doverifyotpforgotpassword')



    {



        



    $response=array();



        $user_otp = '';



	if(isset($_POST['user_otp']) && trim($_POST['user_otp']) != '')



	{



		$user_otp = trim($_POST['user_otp']);



	}



	



	$signup_mobile_no = '';



	if(isset($_POST['email_mobile']) && trim($_POST['email_mobile']) != '')



	{



		$signup_mobile_no = trim($_POST['email_mobile']);



	}



	



	$error = 0;



	$err_msg = '';



        



        if($user_otp == '')



	{		



                $response['err_msg'] = "Please enter 4 digits otp";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = true;



		echo json_encode(array($response));



                exit(0);



	}



	elseif($signup_mobile_no == '')



	{



	



                $response['err_msg'] = "Please enter mobile no";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = true;



		echo json_encode(array($response));



                exit(0);



	}



	elseif( ( !is_numeric($signup_mobile_no) ) || ( strlen($signup_mobile_no) != 10 ) )



	{



		



                $response['err_msg'] = "Please enter valid 10 digits numbers only";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = true;



		echo json_encode(array($response));



                exit(0);



	}



	elseif(!preg_match("/^[0-9]+$/",$signup_mobile_no)  )



	{



		



                $response['err_msg'] = "Please enter valid 10 digits numbers only!";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = true;



		echo json_encode(array($response));



                exit(0);



                



	}



	elseif(!$obj->chkMobileNoExists($signup_mobile_no))



	{



		



                $response['err_msg'] = "This mobile number not registered";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = true;



		echo json_encode(array($response));



                exit(0);



	}



        



        if($error == '0')



	{



		$tdata = array();



		$tdata['user_otp'] = $user_otp;



		$tdata['mobile_no'] = $signup_mobile_no;



		



		if($obj->doVerifyOTPForgotPassword($tdata))



		{



			$response['err_msg'] = "success";



                        $response['error'] = 0;



                        $response['otp_type'] = "Mobile";



                        $error = true;



                        echo json_encode(array($response));



                        exit(0);



		}



		else



		{



                        $response['err_msg'] = "Invalid otp entry!";



                        $response['error'] = 1;



                        $response['otp_type'] = "Mobile";



                        $error = true;



                        echo json_encode(array($response));



                        exit(0);



		}



	}



        



        



    }   



  



if(isset($_REQUEST['action']) && $_REQUEST['action'] =='resetnewpassword')



    {



        



        //print_r($_REQUEST);



    



        $response=array();



        $user_otp = '';



	if(isset($_POST['user_otp']) && trim($_POST['user_otp']) != '')



	{



		$user_otp = trim($_POST['user_otp']);



	}



	



	$signup_mobile_no = '';



	if(isset($_POST['email_mobile']) && trim($_POST['email_mobile']) != '')



	{



		$signup_mobile_no = trim($_POST['email_mobile']);



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



		



                $response['err_msg'] = "Please enter 4 digits otp";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = 1;



                echo json_encode(array($response));



                exit(0);



	}



	elseif($signup_mobile_no == '')



	{



		



                $response['err_msg'] = "Please enter mobile no";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = 1;



                echo json_encode(array($response));



                exit(0);



	}



	elseif( ( !is_numeric($signup_mobile_no) ) || ( strlen($signup_mobile_no) != 10 ) )



	{



		



                $response['err_msg'] = "Please enter valid 10 digits numbers only";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = 1;



                echo json_encode(array($response));



                exit(0);



                



	}



	elseif(!preg_match("/^[0-9]+$/",$signup_mobile_no)  )



	{



		



                $response['err_msg'] = "Please enter valid 10 digits numbers only!";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = 1;



                echo json_encode(array($response));



                exit(0);



                



	}



	elseif(!$obj->chkMobileNoExists($signup_mobile_no))



	{



		



                $response['err_msg'] = "This mobile number not registered";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = 1;



                echo json_encode(array($response));



                exit(0);



                



	}



	elseif($password == '')



	{



		



                $response['err_msg'] = "Please enter new password";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = 1;



                echo json_encode(array($response));



                exit(0);



                



	}



	elseif($cpassword == '')



	{



		



                $response['err_msg'] = "Please enter confirm password";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = 1;



                echo json_encode(array($response));



                exit(0);



                



	}



	elseif($password != $cpassword)



	{



		



                $response['err_msg'] = "Please enter same confirm password";



                $response['error'] = 1;



                $response['otp_type'] = "Mobile";



                $error = 1;



                echo json_encode(array($response));



                exit(0);



                



	}



	



	$url = '';



	if($error == '0')



	{



		$tdata = array();



		$tdata['user_otp'] = $user_otp;



		$tdata['mobile_no'] = $signup_mobile_no;



		$tdata['password'] = $password;



				



		if($obj->doVerifyOTPForgotPassword($tdata))



		{



			if($obj->resetUserPasswordByMobile($tdata))



			{



				//$url = SITE_URL.'/messages.php?id=2';

				//change ample 03-06-20

				$url = SITE_URL.'/message.php?msg=3';



                                $response['err_msg'] = "success";



                                $response['error'] = 0;



                                $response['otp_type'] = "Mobile";



                                $response['url'] = $url;



                                $error = 0;



                                echo json_encode(array($response));



                                exit(0);



                                



                                



			}



			else



			{



				



                                $response['err_msg'] = "Invalid otp entry!";



                                $response['error'] = 1;



                                $response['otp_type'] = "Mobile";



                                $error = 1;



                                echo json_encode(array($response));



                                exit(0);



                                



			}



		}



		else



		{



			$response['err_msg'] = "Invalid otp entry!";



                        $response['error'] = 1;



                        $response['otp_type'] = "Mobile";



                        $error = 1;



                        echo json_encode(array($response));



                        exit(0);



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



<?php include_once('header-new.php');?>



<section id="checkout">



	<div class="container">



		<div class="row">



			<div class="col-md-8">



                            <form name="frmlogin" id="frmlogin" method="post">



					<input type="hidden" name="ref_url" id="ref_url" value="<?php echo $ref_url;?>" >



					<div id="checkout-accordion">



						<h3 data-corners="false">



							<p style="margin-top: 0px;">Forgot Password</p>



						</h3>



						<div class="checkout-accordion-content">



							<div id="checkout-tabs" class="checkout-tabs">



								<?php if($error){ ?>



                                                                <span style="color:red;"><?php echo $err_msg; ?></span>



                                                                <?php } ?>



                                                                       <div id="checkout-login-tab">



									<span id="err_msg_login"></span>



									<div id="forgot-box">



										<div class="form-group">



											<input type="text" name="email_mobile" id="email_mobile" placeholder="Enter your email id Or mobile number" class="input-text-box" value="<?php echo $email;?>" autocomplete="false">



										</div>



                                                                                <div class="form-group">



                                                                                    Select your choice <input type="radio" name="otp_choice" id="otp_choice" checked="" value="Mobile" required=""> Mobile



                                                                                    &nbsp;&nbsp;&nbsp; <input type="radio" name="otp_choice" id="otp_choice"  value="Mail" required=""> Email



                                                                                    



										</div>



										<div class="form-group">



                                                                                            <a class="btn-red" href="javascript:sendOTPForgotPassword();">Send Mail / OTP on Mobile</a>



                                                                                        <!--<button type="submit" class="btn-red" name="btnSubmit" id="btnSubmit" >Send Mail / OTP on Mobile</button>-->



										</div>



									</div>



                                                                        <div id="verify-otp-box"  style="display:none;">



										<div class="form-group">



											<!-- <p>We have sent 4 digits otp at your registered mobile number.</p>

											<p>Please enter the correct otp to proceed.</p> -->



										<?php 

											//change by ample 15-06-20

											echo $obj->print_message('25');

										?>



										</div>



										<div class="form-group">



											<input type="text" name="user_otp" id="user_otp" placeholder="4 digits otp" class="input-text-box" autocomplete="false">



										</div>



										<div class="form-group">



											<a class="btn-red" href="javascript:doVerifyOTPForgotPassword()">Verify OTP</a>&nbsp;Or&nbsp;<a class="link-red" href="javascript:reSendOTPForgorPassword()">Resend OTP</a>



										</div>	



									</div>



                                                                        <div id="forgot-password-box"  style="display:none;">



										<div class="form-group">



											<input type="password" name="password" id="password" placeholder="New Password" class="input-text-box" autocomplete="false">



										</div>



										<div class="form-group">



											<input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" class="input-text-box" autocomplete="false">



										</div>



										<div class="form-group">



											<a class="btn-red" href="javascript:resetNewPassword()">Reset Password</a>



										</div>	



									</div>



									



								</div>



							</div>



						</div>



					</div>



				</form>



			</div>



                        <div class="col-md-2"> <?php include_once('left_sidebar.php'); ?></div>



			<div class="col-md-2"><?php include_once('right_sidebar.php'); ?></div>



			



		</div>



	</div>



</section>



<?php include_once('footer.php');?>	



    



<script>



function sendOTPForgotPassword()



    {



	var email_mobile = $('#email_mobile').val();



        var choice =$('input[name=otp_choice]:checked', '#frmlogin').val();





        var error = false;



        



	if(email_mobile == '')



	{



		$('#err_msg_login').html('<p class="err_msg">Please enter email or mobile no.</p>');



		error = true;



	}



	



        if(choice == '')



	{           



		$('#err_msg_login').html('<p class="err_msg">Please select choice.</p>');



		error = true;



	}



        



	if(!error)



	{



		var dataString = 'action=resendotp&choice='+escape(choice)+'&email_mobile='+email_mobile;



		$.ajax({



			type: "POST",



			url: "forgot_password.php",



			data: dataString,



			cache: false,



			success: function(result)



			{



                                    //alert(result);



                                   // return false;



                                   var JSONObject = JSON.parse(result);



                                   var error = JSONObject[0]['error'];



                                   var otp_type = JSONObject[0]['otp_type'];



                                   



                                   if(error === 0)



                                   {



                                      



                                      if(otp_type == "Mail")



                                      {



                                          window.location.href = 'message.php?msg=11&sess='+JSONObject[0]['send_to_page_data'];  // 10 is old message id



                                      }



                                      



                                    if(otp_type == "Mobile")



                                    {



                                        $('#err_msg_login').html('');



					$('#forgot-box').hide();



					$('#verify-otp-box').show();



                                    }



                                      



                                   }



                                   else



                                   {



                                     $('#err_msg_login').html('<p class="err_msg">'+JSONObject[0]['err_msg']+'</p>');  



                                   }



                                    



                                



				



			}



		});	



	}



}







function reSendOTPForgorPassword()



{



	var email_mobile = $('#email_mobile').val();



	var choice = "Mobile";



	var error = false;



	//alert('test');



	if(!error)



	{



		var dataString = 'action=resendotp&choice='+escape(choice)+'&email_mobile='+email_mobile;



		$.ajax({



			type: "POST",



			url: "forgot_password.php",



			data: dataString,



			cache: false,



			success: function(result)



			{	



				// alert(result);



				// return false;



				var JSONObject = JSON.parse(result);



                                var error = JSONObject[0]['error'];



				if(error === 1)



				{



					$('#err_msg_login').html('<p class="err_msg">'+JSONObject[0]['err_msg']+'</p>');



				}



				else



				{



					$('#err_msg_login').html('<p class="err_msg">'+JSONObject[0]['err_msg']+'</p>');



				}



			}



		});	



	}



}







function doVerifyOTPForgotPassword()



{



	var user_otp = $('#user_otp').val();



	var email_mobile = $('#email_mobile').val();



	



	var error = false;



	



	if(user_otp == '')



	{



		$('#err_msg_login').html('<p class="err_msg">Please enter otp.</p>');



		error = true;



	}



	



	if(!error)



	{



		var dataString = 'action=doverifyotpforgotpassword&user_otp='+escape(user_otp)+'&email_mobile='+escape(email_mobile);



		$.ajax({



			type: "POST",



			url: "forgot_password.php",



			data: dataString,



			cache: false,



			success: function(result)



			{



				//alert(result);



				var JSONObject = JSON.parse(result);



                                var error = JSONObject[0]['error'];



				if(error == '1')



				{



					$('#err_msg_login').html('<p class="err_msg">'+JSONObject[0]['err_msg']+'</p>');



				}



				else



				{



					$('#err_msg_login').html('');



					$('#forgot-box').hide();



					$('#verify-otp-box').hide();



					$('#forgot-password-box').show();



				}



			}



		});	



	}



}







function resetNewPassword()



{



	var user_otp = $('#user_otp').val();



	var email_mobile = $('#email_mobile').val();



	var password = $('#password').val();



	var cpassword = $('#cpassword').val();



	



	var error = false;



	



	if(user_otp == '')



	{



		$('#err_msg_login').html('<p class="err_msg">Please enter otp.</p>');



		error = true;



	}



	



	if(!error)



	{



		var dataString = 'action=resetnewpassword&user_otp='+escape(user_otp)+'&email_mobile='+escape(email_mobile)+'&password='+escape(password)+'&cpassword='+escape(cpassword);



		$.ajax({



			type: "POST",



			url: "forgot_password.php",



			data: dataString,



			cache: false,



			success: function(result)



			{



                                //alert(result);



				var JSONObject = JSON.parse(result);



                                var error = JSONObject[0]['error'];



				if(error == '1')



				{



					$('#err_msg_login').html('<p class="err_msg">'+JSONObject[0]['err_msg']+'</p>');



				}



				else



				{



					$('#err_msg_login').html('');



					window.location.href = JSONObject[0]['url'];



				}



			}



		});	



	}



}







    </script>



</body>



</html>



