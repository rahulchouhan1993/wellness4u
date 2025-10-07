<?php 



include('classes/config.php');



$page_id = '5';



$obj = new frontclass();



$page_data = $obj->getPageDetails($page_id);







if($obj->isLoggedIn())







{







	$obj->doUpdateOnline($_SESSION['user_id']);



        //echo "<script>window.location.href='user_dashboard.php'</script>";



	//header("Location: user_dashboard.php");



        header("Location: my_day_today.php");







}











if(isset($_GET['ref']))







{







	$ref = $_GET['ref'];







}







elseif(isset($_POST['ref']))







{







	$ref = $_POST['ref'];







}







else







{







	$ref = '';







}











if(isset($_GET['gestid']))







{







	$gestid = $_GET['gestid'];







}



else







{







	$gestid = '';







}







if(isset($_GET['uid']))



    {



            



          $uid =  base64_decode($_GET['uid']);



          //echo  $ref_id =  base64_decode($_GET['refid']);



    }



    else



    {



            $uid =  '';



    }











$ref_url = base64_decode($ref);



$tr_err_msg = 'none';







$error = false;







$err_msg = '';











if(isset($_POST['login_btn']))







{







       // echo '<pre>';



       // print_r($_POST);



       // echo '</pre>';



       // die();



	$username = trim($_POST['username']);







	$password = trim($_POST['password']);







        $gestid = $_POST['gestid'];







        



	if( ($username == '') || ($password == '') ) 







	{







		$error = true;







		$tr_err_msg = '';







		$err_msg = "Please Enter Username/Password";







	}







	elseif(!$obj->chkValidLogin($username,$password))







	{







		$error = true;







		$tr_err_msg = '';







		$err_msg = "Please Enter Valid Username/Password";







	}















	if(!$error)







	{







		if($obj->doLogin($username))







		{



                    



                        if($gestid != '')



                        {



                            $addUsersSleepQuestion = $obj->addUsersSleepQuestionByGestVivek($_SESSION['user_id'],$_SESSION['sleep_date'],$_SESSION['selected_sleep_id_arr'],$_SESSION['scale_arr'],$_SESSION['remarks_arr'],$_SESSION['my_target_arr'],$_SESSION['adviser_target_arr'],$_SESSION['pro_user_id']);



                       



                            unset($_SESSION['sleep_date']);



                            unset($_SESSION['selected_sleep_id_arr']);



                            unset($_SESSION['scale_arr']);



                            unset($_SESSION['remarks_arr']);



                            unset($_SESSION['my_target_arr']);



                            unset($_SESSION['adviser_target_arr']);



                            unset($_SESSION['pro_user_id']);



                            unset($_SESSION['gestid']);



                            



                           



                        }



                        



			if($ref == '')







			{



                                header("Location: my_day_today.php");



				//header("Location: user_dashboard.php");



                             //echo "<script>window.location.href='user_dashboard.php'</script>";







			}







			else







			{



                               



				header('location: '.SITE_URL.'/'.$ref_url);



                                //$redirect = SITE_URL."/".$ref_url;



                               // echo "<script>window.location.href='".$redirect."'</script>";







			}	







		}







		else







		{



			$error = true;



			$tr_err_msg = '';



			$err_msg = "The username or password you entered is invalid, please try again.";







		}







	}		







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



		// $city_id = strip_tags(trim($obj->getCityIdbyName($_POST['signup_city'])));

		//chnage 15-07-20

		$city_id = $_POST['signup_city'];



		$place_id = strip_tags(trim($_POST['signup_location']));



		$password = trim($_POST['signup_password']);



		$reference_id = trim($_POST['reference_id']); // added by ample 27-11-20



		$gender = trim($_POST['sex']);



		$uid = $_POST['uid'];



		$refid = $_POST['refid'];



		$puid = $_POST['puid'];



		$arid = $_POST['arid'];



		//add by ample 14-07-20

		$country_id = $_POST['country_id'];

		$state_id = $_POST['state_id'];



	



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

	//add by ample 14-07-20

	if($country_id == '')



	{



		$error = true;



		$err_msg .= '<p>Please select your country</p>';



	}

	//add by ample 14-07-20

	if($state_id == '')



	{



		$error = true;



		$err_msg .= '<p>Please select your state</p>';



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



	if(!empty($reference_id))

	{

		if(!$obj->chkValidReferenceID($reference_id))

		{

			$error = true;



			$err_msg .= '<p>Reference ID is wrong!</p>';

		}

	}



	



	if(!$error)



	{



                $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';



                $string_shuffled = str_shuffle($string);



                $otp = substr($string_shuffled, 1, 6);



       if($gestid != '')



          {



		   $signUpUser = $obj->updatesSignUpUserVivek($gestid,$name,$middle_name,$last_name,$gender,$email,$mobile,$city_id,$place_id,$password,$otp,$country_id,$state_id);



		  }



       else



          {



		   $signUpUser = $obj->signUpUser($name,$middle_name,$last_name,$gender,$email,$mobile,$city_id,$place_id,$password,$otp,$country_id,$state_id,$reference_id);



		  }



                    



                if($signUpUser > 0)



		{



                        



			if($uid != '' && $refid !='' )



			{



                                // echo 'Hiii';



                                // die();



				$tdata = array();



				$tdata['id'] = $refid;



				$tdata['uid'] = $uid;



				$obj->updatereferafriend($tdata,$email);



			}



			if(!empty($reference_id))

			{

				$obj->updatereferafriend_status($email,$reference_id);

			}



			



			if($puid != '' && $arid !='' )



			{



				$obj->updateAdvisorsReferral($arid,$puid,$email);



			}



		



                        if($obj->sendSignUpEmailToUser($email))



                        {



                            header("Location: message.php?msg=10&sess=".base64_encode($email).""); //1 is old message id







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



			//add by ample 13-07-20

			$tdata_sms = array();

			$tdata_sms['mobile_no'] = $mobile;

			

			$sms_mail_data =$obj->getEmailAutoresponderDetails('17');

			$sms_msg = $sms_mail_data['email_ar_body'];

			$sms_msg = str_ireplace("[[USER_NAME]]", $name, $sms_msg);

			$sms_msg = str_ireplace("[[USER_EMAIL]]", $email, $sms_msg);

            $sms_msg = str_ireplace("[[OTP]]", $otp, $sms_msg);



            $sms_credential=$obj->get_SMS_credential($sms_mail_data['SMS_ID']); 

			$tdata_sms['SMS_USERNAME']=$sms_credential['SMS_USERNAME'];

	        $tdata_sms['SMS_PASSWORD']=$sms_credential['SMS_PASSWORD'];

	        $tdata_sms['SMS_SENDERID']=$sms_credential['SMS_SENDERID'];

	        $tdata_sms['SMS_URL']=$sms_credential['SMS_URL'];

            $tdata_sms['sms_message'] = strip_tags($sms_msg); //add by ample 15-06-20

			$obj->sendSMS($tdata_sms);





			header("Location: message.php?msg=10&sess=".base64_encode($email).""); 







             echo "<script>window.location.href='message.php?msg=10&sess=".base64_encode($email)."'</script>"; //1 is old message id



			$err_msg = $url;                   



		}



		else



		{



			$err_msg = 'There is some problem right now!Please try again later';



		}



	}



}



























if(isset($_REQUEST['action']) && $_REQUEST['action'] =='getlocation')



    {



        



    $response=array();



    $signup_city=$_REQUEST['signup_city']!='' ? $_REQUEST['signup_city'] : '';



    //$city_id = $obj->getCityIdbyName($signup_city);

    //chnage 15-07-20

    $city_id=$signup_city;



    if($city_id!='')



        {



            $response['place_option'] = $obj->getPlaceOptions($city_id);



            $response['error'] = 0;



        }



    echo json_encode(array($response));



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



                    <div class="col-md-6">



                        <img src="uploads/LoginPage-Banner-Basketball-Transparent-Green-small.png" style="width: 100%;  height: auto;" draggable="true" data-bukket-ext-bukket-draggable="true">



                    </div>



			<div class="col-md-6">



                            



					<div id="checkout-accordion">



						<h3 data-corners="false">



							<p style="margin-top: 0px;">User Login/Signup</p>



						</h3>



						<div class="checkout-accordion-content">



                                                    <?php if($error){ ?>



                                                    <span style="color:red;"><?php echo $err_msg; ?></span>



                                                    <?php } else { ?>



                                                    <span style="color:red;">All Fields are compulsory</span>



                                                    <?php } ?>



							<div id="checkout-tabs" class="checkout-tabs">



								<ul>



									<li class="col-md-4"><a href="#checkout-login-tab">Log In</a></li>



									<li class="col-md-4"><a href="#checkout-signup-tab">Sign Up</a></li>



								</ul>



                                                                <input type="hidden" name="refid" id="refid" value="<?php echo base64_decode($_GET['refid']);?>" />  



                                                                <input type="hidden" name="ref" id="ref" value="<?php echo $ref;?>" />  



                                                                <input type="hidden" name="gestid" id="gestid" value="<?php echo base64_decode($gestid);?>" /> 



                                                                <input type="hidden" name="ref_url" id="ref_url" value="<?php echo $ref_url;?>" />



                                                                <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>" />



                                                                <input type="hidden" name="arid" id="arid" value="<?php echo base64_decode($_GET['arid']);?>" />



                                                                <input type="hidden" name="puid" id="puid" value="<?php echo base64_decode($_GET['puid']);?>" />



                                                                



                                                                <form name="frmlogin" id="frmlogin" method="post">



								<div id="checkout-login-tab">



									<input style="display:none" type="text" name="fakeusernameremembered2" />



									<input style="display:none" type="password" name="fakepasswordremembered2"/>



									<span id="err_msg_login"></span>



									<div class="form-group">



                                        <input type="text" name="username" id="username" placeholder="Email ID / Mobile Number" class="input-text-box"  autocomplete="false" required="">



									</div>



									<div class="form-group">



                                       <input type="password" name="password" id="password" placeholder="Password" class="input-text-box" autocomplete="false" required="">



									</div>



									<div class="form-group">



                                        <button type="submit" class="btn-red" name="login_btn" id="login_btn" >LOG IN</button>



                                             &nbsp;&nbsp;&nbsp;<a class="link-red" href="<?php echo SITE_URL; ?>/forgot_password.php">Forgot Password?</a>



										



									</div>	



                                                                       



								</div>



                             </form>







                             











                             <form name="frm_signup" id="frm_signup" method="post">



                                                                



								<div id="checkout-signup-tab">



									<input style="display:none" type="text" name="fakeusernameremembered" />



									<input style="display:none" type="password" name="fakepasswordremembered"/>



								  	<span id="err_msg_signup"></span>







									<div id="signup-box">



										<div class="form-group">



                                            <input required="" type="text" name="signup_first_name" id="signup_first_name" placeholder="First Name" class="input-text-box input-half-width" autocomplete="false">



                                             <input required="" type="text" name="signup_middle_name" id="signup_middle_name" placeholder="Middle Name" class="input-text-box input-half-width" autocomplete="false">



											



										</div>



                                               <div class="form-group">



                                                <input type="text" name="signup_last_name" id="signup_last_name" placeholder="Last Name" class="input-text-box input-half-width" autocomplete="false">



                                                    Gender: &nbsp;&nbsp;&nbsp;&nbsp;



                                                    <input type="radio" name="sex" id="sex" value="Male" required> 



                                                    Male &nbsp;&nbsp;&nbsp;&nbsp;



                                                    <input type="radio" name="sex" id="sex" value="Female" required>



                                                     Female



                                               </div>











										<div class="form-group">



											<input type="text" required="" name="signup_email" id="signup_email" placeholder="Email" class="input-text-box" autocomplete="false" onchange="get_referal_id()">



										</div>















										<div class="form-group">



                                            <input type="text" required="" onKeyPress="return isNumberKey(event);" maxlength="10" name="signup_mobile_no" id="signup_mobile_no" placeholder="10 digit Mobile Number" class="input-text-box" autocomplete="false">



                                        </div>





                               <div class="form-group">





								               <select required="" class="input-text-box input-half-width" name="country_id" id="country_id" onchange="getStateOption()">



								                    <?php echo $obj->getCountryOption($country_id); ?>



								                </select>





								            <select required="" class="input-text-box input-half-width" name="state_id" id="state_id" onchange="getCityOption();">



								                    <option value="">Select your state</option>



								                    <?php echo $obj->getStateOption($country_id,$state_id); ?>



								                </select>





								</div>







                                <div class="form-group">



                                   <!--  <input type="text" required="" name="signup_city" id="signup_city" placeholder="Select your city" list="capitals" class="input-text-box input-half-width" onchange="getlocation();" autocomplete="off" />



                                        <datalist id="capitals">



                                            



                                        </datalist> -->



                                        <select required="" class="input-text-box input-half-width" name="signup_city" id="signup_city" onchange="getlocation();">



								                    <option value="">Select your city</option>



								                   



								                </select>



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



								<input type="text" name="reference_id" id="reference_id" placeholder="Reference ID (Optional)" class="input-text-box input-half-width" autocomplete="false" onchange="get_reference_name()">

								<span id='reference_name' style="font-weight: 600;padding-left: 5px;font-size: 1.25em;color: yellowgreen;"></span>



								</div>







                              <div class="form-group">



                                  <hr>



                                  <span>By clicking the "I accept. Create My Account" below, I certify that I have read and agree to the <a href="terms_and_conditions.php" target="_blank" style="color:blue;">Terms & Conditions of Service </a> below and both the <a href="disclaimer.php" target="_blank" style="color:blue;">Disclaimer Policy</a> and the <a href="privacy_policy.php" target="_blank" style="color:blue;">Privacy Policy</a>.</span>



                              </div>







                                           <div class="form-group">



                                          <button type="submit" class="btn-red" name="login_signup" id="login_signup" >I accept. Create My Account</button></div>	



									</div>



										



								</div>



                              </form>























							</div>



						</div>



					</div>



				



			</div>



			<div class="col-md-2">&nbsp;</div>



			



		</div>



	</div>



</section>



<?php include_once('footer.php');?>	



<!--    <script>



       function getlocation()



       {



           var signup_city = $("#signup_city").val();



            var dataString ='signup_city='+signup_city +'&action=getlocation';



            $.ajax({



                   type: "POST",



                    url: 'login.php', 



                   data: dataString,



                   cache: false,



                   success: function(result)



                        {



                         var JSONObject = JSON.parse(result);



                         //var rslt=JSONObject[0]['status'];   



                        $('#signup_location').html(JSONObject[0]['place_option']);



                       }



              }); 



       }



       



       function isNumberKey(evt){ 



    //var e = evt || window.event;



	var charCode = (evt.which) ? evt.which : evt.keyCode



    if (charCode != 46 && charCode > 31 



	&& (charCode < 48 || charCode > 57))



        return false;



        return true;



	}



   </script> -->



    <script type="text/javascript">

    	function getStateOption()



{



var country_id = $('#country_id').val();



var state_id = $('#state_id').val();







if(country_id == null)



{



country_id = '-1';



}







if(state_id == null)



{



state_id = '-1';



}











var dataString ='country_id='+country_id+'&state_id='+state_id+'&action=getstateoption';



$.ajax({



type: "POST",



url: "remote2.php",



data: dataString,



cache: false,      



success: function(result)



{



$("#state_id").html(result);



getCityOption();



}



});



}





function getCityOption(id_val)



{



var country_id = $('#country_id').val();



var state_id = $('#state_id').val();



var city_id = $('#city_id').val();







if(country_id == null)



{



country_id = '-1';



}







if(state_id == null)



{



state_id = '-1';



}







if(city_id == null)



{



city_id = '-1';



}







var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&action=getcityoption';



$.ajax({



type: "POST",



url: "remote2.php",



data: dataString,



cache: false,      



success: function(result)



{



//alert();



$("#signup_city").html(result);



getAreaOption();



}



});



}



	function get_referal_id()

	{

		var email_id=$('#signup_email').val();



		$.ajax({

	     url:'remote.php',

	     method: 'post',

	     data: {action: 'get_referal_code',email_id:email_id},

	     //dataType: 'json',

	     success: function(response){

	        //alert(response);   

	        $('#reference_id').val(response);

	        get_reference_name();

	     }

	    }); 

	}



	function get_reference_name()

	{

		var code=$('#reference_id').val();



		$.ajax({

	     url:'remote.php',

	     method: 'post',

	     data: {action: 'get_referal_name',code:code},

	     //dataType: 'json',

	     success: function(response){

	        //alert(response);   

	        $('#reference_name').text(response);

	     }

	    }); 

	}



    </script>



    



</body>



</html>