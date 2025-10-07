<?php 

include('classes/config.php');

$page_id = '39';

$obj = new frontclass();

$obj2 = new Profclass();

$page_data = $obj->getPageDetails($page_id);



if($obj2->isLoggedInPro())



{

	$obj2->doUpdateOnlinePro($_SESSION['pro_user_id']);

	header("Location: ".SITE_URL."/practitioners/edit_profile_pro.php");

	exit(0);

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



if($_GET['uid']!='' && $_GET['refid']!='')



{



	$refid = base64_decode($_GET['refid']);

	$uid =  base64_decode($_GET['uid']);



}



else



{



	$refid = '';



	$uid =  '';



}



if($_GET['puid']!='' && $_GET['arid']!='')



{

	$puid = base64_decode($_GET['puid']);

	$arid =  base64_decode($_GET['arid']);      

}



else



{



	$puid = '';

	$arid =  '';     



}











$ref_url = base64_decode($ref);

$tr_err_msg = 'none';

$error = false;

$err_msg = '';



//vendorlogin

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='vendorlogin')

{

    if(isset($_POST['logBtn']))

    {



        $username = strip_tags(trim($_POST['username']));

        $password = strip_tags(trim($_POST['password']));



        if( ($username == '') || ($password == '') ) 

        {

            $error = true;

            $err_msg = "Please Enter Username/Password";



                    $tdata = array();

                    $response = array('msg'=>$err_msg,'status'=>0);

                    $tdata[] = $response;

                    //$obj->debuglog('[ajax-login] RESPONSE1: '.json_encode($tdata));

                    echo json_encode($tdata);

                    exit(0);



        }

        elseif(!$obj2->chkValidVendorLogin($username,$password))

        {

            $error = true;

            $err_msg = "Invalid Username/Password";



                    $tdata = array();

                    $response = array('msg'=>$err_msg,'status'=>0);

                    $tdata[] = $response;

                    //$obj->debuglog('[ajax-login] RESPONSE2: '.json_encode($tdata));

                    echo json_encode($tdata);

                    exit(0);

        }



        if(!$error)

        {

                    //$obj->debuglog('[ajax-login] NOT ERROR');

            if($obj2->doVendorLogin($username))

            {

                            $tdata = array();

                            $response = array('msg'=>$err_msg,'status'=>1,'refurl'=> 'wa/business-associate/index.php');

                            $tdata[] = $response;

                            //$obj->debuglog('[ajax-login] RESPONSE3: '.json_encode($tdata));

                            echo json_encode($tdata);

                            exit(0);

            }

            else

            {

                $error = true;

                $err_msg = "The username or password you entered is invalid, please try again.";



                            $tdata = array();

                            $response = array('msg'=>$err_msg,'status'=>0);

                            $tdata[] = $response;

                            //$obj->debuglog('[ajax-login] RESPONSE4: '.json_encode($tdata));

                            echo json_encode($tdata);

                            exit(0);

            }

        }		

    }

    else

    {

            echo 'Invalid access';

    }

}



if(isset($_REQUEST['action']) && $_REQUEST['action'] =='getvendoraccesssubcat')

    {

        

    $response=array();

    $va_cat_id=$_REQUEST['va_cat_id']!='' ? $_REQUEST['va_cat_id'] : '';

    

    

    if($va_cat_id!='')

        {

            $response['va_sub_cat_id'] = $obj2->getvendoraccesdropdownsub($va_cat_id,'');

            $response['error'] = 0;

        }

    echo json_encode(array($response));

    exit(0);    

    }

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='dovendorregistrationproceed')

{

	$va_cat_id = '';

        $va_sub_cat_id = '';

	if(isset($_POST['va_cat_id']) && trim($_POST['va_cat_id']) != '')

	{

		$va_cat_id = trim($_POST['va_cat_id']);

	}

	

        if(isset($_POST['va_sub_cat_id']) && trim($_POST['va_sub_cat_id']) != '')

	{

		$va_sub_cat_id = trim($_POST['va_sub_cat_id']);

	}

        

        

        if($_POST['uid']!='' && $_POST['refid']!='')

        {



                $refid = $_POST['refid'];

                $uid =  $_POST['uid'];



        }

        

        if($_POST['puid']!='' && $_POST['arid']!='')

        {



                $puid = $_POST['puid'];

                $arid = $_POST['arid'];   



        }

        

        

        

	$error = 0;

	$err_msg = '';

	$url = '';

	

	if($va_cat_id == '')

	{

		$error = 1;

		$err_msg = 'Please select your business category';

	}

        

        if($va_sub_cat_id == '')

	{

		$error = 1;

		$err_msg = 'Please select business sub category';

	}

	

	if($error == '0')

	{

		$va_id = $obj2->getVAIDFromVACATID($va_cat_id,$va_sub_cat_id);

		if($va_id > 0)

		{

                        if($uid != '' && $refid !='' )

			{

                          $url = BA_URL.'/register.php?vtoken='.base64_encode($va_id).'&uid='.base64_encode($uid).'&refid='.base64_encode($refid);	  

                        }

                        elseif($puid != '' && $arid !='' )

                        {

                            $url = BA_URL.'/register.php?vtoken='.base64_encode($va_id).'&puid='.base64_encode($puid).'&arid='.base64_encode($arid);	  

                        }

                        else

                        {

                         $url = BA_URL.'/register.php?vtoken='.base64_encode($va_id);   

                        }

                    

			

		}

		else

		{

			$error = 1;

			$err_msg = 'Invalid category';

		}

	}

	

        $response = array();

        $response['error'] = $error;

        $response['err_msg'] = $err_msg;

        $response['url'] = $url;

        

        echo json_encode(array($response));

        exit(0);   

        

	//$ret_str = $test.'::::'.$error.'::::'.$err_msg.'::::'.$url;

	//echo $ret_str;

}





?>

<!DOCTYPE html>

<html lang="en">

<head>

    

    <?php include_once('head.php');?>

</head>

<body>

<?php include_once('header.php');?>
<style>
    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-text-box {
        width: 100%;
        padding-right: 40px;
    }
    .toggle-password {
        position: absolute;
        right: 10px;
        cursor: pointer;
        font-size: 18px;
        color: #888;
    }
    .toggle-password-reg {
        position: absolute;
        right: 10px;
        cursor: pointer;
        font-size: 18px;
        color: #888;
    }
</style>

<section id="checkout">

	<div class="container">

		<div class="row">

                     <div class="col-md-6">

                        <img src="uploads/LoginPage-Banner-Basketball-Transparent-Green-small.png" style="width: 100%;  height: auto;" draggable="true" data-bukket-ext-bukket-draggable="true">

                    </div>

                    <div class="col-md-6">

                       

					<div id="checkout-accordion">

						<h3 data-corners="false">

							<p style="margin-top: 0px;">Wellness Associate Register</p>

						</h3>

						<div class="checkout-accordion-content">

							<div id="checkout-tabs" class="checkout-tabs">

								<ul>

                                                                        <li class="col-md-4"><a href="#checkout-login-tab">Log In</a></li>

									<li class="col-md-4"><a href="#checkout-signup-tab">Sign Up</a></li>

								</ul>

                                                                <form  name="admin-login-form" id="admin-login-form" method="post">

                                                                <input type="hidden" name="refid" id="refid" value="<?php echo base64_decode($_GET['refid']);?>" />  

                                                                <input type="hidden" name="ref" id="ref" value="<?php echo $ref;?>" />  

                                                                <input type="hidden" name="gestid" id="gestid" value="<?php echo base64_decode($gestid);?>" /> 

                                                                <input type="hidden" name="ref_url" id="ref_url" value="<?php echo $ref_url;?>" />

                                                                <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>" />

                                                                <input type="hidden" name="arid" id="arid" value="<?php echo base64_decode($_GET['arid']);?>" />

                                                                <input type="hidden" name="puid" id="puid" value="<?php echo base64_decode($_GET['puid']);?>" />

								<div id="checkout-login-tab">

									<input style="display:none" type="text" name="fakeusernameremembered2" />

									<input style="display:none" type="password" name="fakepasswordremembered2"/>

									<span id="err_msg_login"></span>

									<div class="form-group">

                                                                            <input type="text" name="username" id="username" placeholder="Email ID / Mobile Number" class="input-text-box"  autocomplete="false" required="">

									</div>

									<div class="form-group">

                                                                            <!-- <input type="password" name="password" id="password" placeholder="Password" class="input-text-box" autocomplete="false" required=""> -->
                                                                            <div class="password-wrapper">
																			    <input type="password" name="password" id="password" placeholder="Password" class="input-text-box" autocomplete="off" required>
																			    <span toggle="#password" class="toggle-password" onclick="togglePassword()">👁️</span>
																			</div>

									</div>

									<div class="form-group">

                                                                            <button type="button" class="btn-red" name="login_btn" id="login_btn" onclick="loginproceed(); return false;">LOG IN</button>

                                                                               &nbsp;&nbsp;&nbsp;<a class="link-red" href="<?php echo SITE_URL; ?>/prof-forgot-password.php">Forgot Password?</a>

										

									</div>	

                                                                       

								</div>

                                                                </form>

								<div id="checkout-signup-tab">

                                                                     <form name="frmlogin" id="frmlogin">

                                                                         <input type="hidden" name="refid" id="refid" value="<?php echo base64_decode($_GET['refid']);?>" />  

                                                                         <input type="hidden" name="ref" id="ref" value="<?php echo $ref;?>" />  

                                                                         <input type="hidden" name="gestid" id="gestid" value="<?php echo base64_decode($gestid);?>" /> 

                                                                         <input type="hidden" name="ref_url" id="ref_url" value="<?php echo $ref_url;?>" />

                                                                         <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>" />

                                                                         <input type="hidden" name="arid" id="arid" value="<?php echo base64_decode($_GET['arid']);?>" />

                                                                         <input type="hidden" name="puid" id="puid" value="<?php echo base64_decode($_GET['puid']);?>" />

                                                                         <input type="hidden" name="ref_url" id="ref_url" value="<?php echo $ref_url;?>" >

									<span id="err_msg_signup"></span>

									 <div id="signup-box">

                                                                            <label>Your Business category</label>

										<div class="form-group">

                                                                                    <select name="va_cat_id" id="va_cat_id" class="input-text-box" onchange="getvendoraccesssubcat();">

												<?php echo $obj2->getvendoraccesdropdownmain(''); ?>	

											</select>

										</div>

                                                                                <label>Your Business sub category</label>

                                                                                <div class="form-group">

                                                                                    <select name="va_sub_cat_id" id="va_sub_cat_id" class="input-text-box">

                                                                                        <option value="">Select</option>

                                                                                    </select>

										</div>

                                                                                <div class="form-group">

                                                                                  <hr>

                                                                                  <span>By clicking the "Proceed button" below, I certify that I have read and agree to the <a href="terms_and_conditions_adviser.php" target="_blank" style="color:blue;">Terms & Conditions of Service </a> below and both the <a href="disclaimer.php" target="_blank" style="color:blue;">Disclaimer Policy</a> and the <a href="privacy_policy.php" target="_blank" style="color:blue;">Privacy Policy</a>.</span>

                                                                              </div>

										<div class="form-group">

                                                                                    <a class="btn-red" href="javascript:doVendorRegistrationProceed()">PROCEED</a>

										</div>	

                                                                            </div>

                                                                       </form>

								</div>

							</div>

						</div>

					</div>

				

                    </div>

                    <div class="col-md-2"> <?php include_once('left_sidebar.php'); ?></div>

                   <div class="col-md-2"> <?php include_once('right_sidebar.php'); ?></div>

			

		</div>

	</div>

</section>

<?php include_once('footer.php');?>	
<script>
    function togglePassword() {
        const input = document.getElementById("password");
        const icon = document.querySelector(".toggle-password");
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "🙈"; // Eye-off icon
        } else {
            input.type = "password";
            icon.textContent = "👁️"; // Eye icon
        }
    }
</script>
   <script>

       function getvendoraccesssubcat()

       {

           var va_cat_id = $("#va_cat_id").val();

            var dataString ='va_cat_id='+va_cat_id +'&action=getvendoraccesssubcat';

            $.ajax({

                   type: "POST",

                    url: 'wa_register.php', 

                   data: dataString,

                   cache: false,

                   success: function(result)

                        {

                            //alert(result);

                         var JSONObject = JSON.parse(result);

                         //var rslt=JSONObject[0]['status'];   

                        $('#va_sub_cat_id').html(JSONObject[0]['va_sub_cat_id']);

                       }

              }); 

       }

       

function doVendorRegistrationProceed()

{

	var va_cat_id = $('#va_cat_id').val();

        var va_sub_cat_id = $('#va_sub_cat_id').val();

        var refid = $('#refid').val();

        var uid =  $('#uid').val();

        var puid = $('#puid').val();

        var arid = $('#arid').val();

	

	var error = false;

	

	if(va_cat_id == '')

	{

		$('#err_msg_signup').html('<p class="err_msg">Please select your business category.</p>');

		error = true;

                return;

	}

        

        if(va_sub_cat_id == '')

	{

		$('#err_msg_signup').html('<p class="err_msg">Please select your business sub category.</p>');

		error = true;

                return;

	}

	

	if(!error)

	{

		var dataString = 'action=dovendorregistrationproceed&va_cat_id='+escape(va_cat_id)+'&va_sub_cat_id='+escape(va_sub_cat_id)+'&refid='+refid+'&uid='+uid+'&puid='+puid+'&arid='+arid;

		$.ajax({

			type: "POST",

			url: "wa_register.php",

			data: dataString,

			cache: false,

			success: function(result)

			{

				

				//var arr_result = result.split('::::');

                                var JSONObject = JSON.parse(result);

                                //alert(JSONObject[0]['url']);

				if(JSONObject['error'] == '1')

				{

					$('#err_msg_signup').html('<p class="err_msg">'+JSONObject['err_msg']+'</p>');

				}

				else

				{

					$('#err_msg_signup').html('');

					window.location.href = JSONObject[0]['url'];

					

				}

			}

		});	

	}

}

       

       function isNumberKey(evt){  <!--Function to accept only numeric values-->

    //var e = evt || window.event;

	var charCode = (evt.which) ? evt.which : evt.keyCode

    if (charCode != 46 && charCode > 31 

	&& (charCode < 48 || charCode > 57))

        return false;

        return true;

	}

   </script>

<script>

function loginproceed()

{ 

	var formData = new FormData($('#admin-login-form')[0]); 

	formData.append("logBtn",'logBtn');

	var error = true;

        //alert('Hiiii');

        

    if(error)

	{

		jQuery.ajax({

			url: 'wa_register.php?action=vendorlogin',

			type: "POST",

			data:formData,

			processData: false,

			contentType: false,

			//beforeSend: function(){ $("#logBtn").val('Connecting...');},

			success: function(result)

			{

				//alert(result);

				var JSONObject = JSON.parse(result);

                                var rslt=JSONObject[0]['status'];

                                if(rslt==1)

				{

					window.location.href= JSONObject[0]['refurl'];  

				}

				else

				{

                                $("#err_msg_login").html('<p class="err_msg">'+JSONObject[0]['msg']+'</p>');

                                    

				}      

			}

		});

	}

}

</script> 

    

</body>

</html>