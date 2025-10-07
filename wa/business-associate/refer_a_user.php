<?php

require_once('../classes/config.php');

require_once('../classes/vendor.php');

$admin_main_menu_id = '14';

$add_action_id = '36';

$page_id = '82';

$obj = new Vendor();

$obj2 = new commonFunctions();

if(!$obj->isVendorLoggedIn())

{

	header("Location: login.php");

	exit(0);

}

else

{

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

}



$vendor_details = $obj->getVendorUserDetails($adm_vendor_id);



if(isset($_POST['btnSubmit']))

{



    $user_name = strip_tags(trim($_POST['user_name']));

    $user_email = strip_tags(trim($_POST['user_email']));

    $msg = strip_tags(trim($_POST['content']));


	if($user_email == '')

	{

		$error = true;

		$err_msg = 'Please enter email of user';

	}

	elseif(!filter_var($user_email, FILTER_VALIDATE_EMAIL))

	{

		$error = true;

		$err_msg = 'Please enter valid email';

	}

	elseif($obj->chkIfRequestAlreadySentByAdviser($adm_vendor_id,$user_email))

	{

		$error = true;

		$err_msg = 'You have already sent request to this user.';

	}

    

    if($user_name == '')

    {

       $error = true;

       $err_msg .='<br>Please enter name of user';

    }


	if(!$error)

    {

		if($obj->chkEmailExists($user_email))

		{

			$new_user = 0;

			if($obj->chkIfUserIsAdvisersReferralsChkByUserEmail($user_email,$adm_vendor_id))

            {

                $error = true;

                $err_msg = 'User have already added to you.';

            }

		}

		else

		{

			$new_user = 1;

		}

		if(!$error)

        { 

        	$arid = $obj->addAdvisorsReferral($adm_vendor_id,$user_email,$user_name,$msg,$new_user);

			if($arid > 0)

			{

				if($new_user == 1)

				{

					$url ='https://www.wellnessway4u.com/login.php?arid='.base64_encode($arid).'&puid='.base64_encode($adm_vendor_id).'';

					$from_user = $vendor_details['vendor_name'];

					

					//list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = getEmailAutoresponderDetails('22');

	                               

	                                $mail_data = $obj->getEmailAutoresponderDetails('22');

					$to_email = $user_email;

					//$from_email = $email_ar_from_email;

	                                

	                                

	                                $from_email = $mail_data['email_ar_from_email'];

					if($mail_data['email_ar_from_name'] == '[[FROM_USER]]')

					{

						$from_name = $from_user;

					}

					else

					{

						$from_name = $mail_data['email_ar_from_name'];

					}

					

					$subject = $mail_data['email_ar_subject'];

					$subject = str_ireplace("[[FROM_USER]]", $from_user, $subject);

					$message = $mail_data['email_ar_body'];

					$message = str_ireplace("[[USER_NAME]]", $user_name, $message);

					$message = str_ireplace("[[FROM_USER]]", $from_user, $message);

					$message = str_ireplace("[[MSG]]", ucfirst(trim($tdata['message'])), $message);

					$message = str_ireplace("[[ANCHER_URL_START]]", '<a href="'.$url.'">', $message);

					$message = str_ireplace("[[ANCHER_URL_END]]", '</a>', $message);

					$message = str_ireplace("[[URL]]", $url, $message);

					

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

				else

				{

				

				}		

				//header("Location: message.php?msg=4");  // 12 is old message id

				//exit(0);

	                        $error = true;

				$err_msg = 'Message sent successfull';

			}

			else 

			{

				$error = true;

				$err_msg = 'Somthing Went Wrong Try later.';

			}

         }

    }


}



?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo SITE_NAME;?> - Business Associates</title>

	<?php require_once 'head.php'; ?>

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-sm-12">

			<div class="panel">

				<div class="panel-body">

					<div class="row mail-header">

						<div class="col-md-6">

							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>

						</div>

					</div>

					<hr>

                                        <center><div id="error_msg" style="color: red;"><?php if($error) { echo $err_msg; } ?></div></center>

					<?php echo $obj->getPageContents($page_id);  ?>

                                        <br>

                                        <form role="form" class="form-horizontal" id="add_event" name="add_event" method="post" > 

                                        <label class="col-lg-2 control-label">Email ID</label>

                                        <div class="col-lg-4">

                                            <input type="text" name="user_email" id="user_email" value="<?php echo $arr_record['user_email']; ?>" class="form-control" required>

                                        </div>

                                         <label class="col-lg-2 control-label">User Name</label>

                                        <div class="col-lg-4">

                                            <input type="text" name="user_name" id="user_name" value="<?php echo $arr_record['user_name']; ?>" class="form-control" required>

                                        </div>

                                         <br><br>

                                         <div class="form-group"><label class="col-lg-2 control-label">Message<span style="color:red">*</span></label>

                                            <div class="col-lg-10">

                                                <textarea class="form-control" id="summernote" name="content" rows="18">



                                                </textarea>

                                            </div>

                                        </div>

                                         <div class="form-group">

							<div class="col-lg-offset-3 col-lg-10">

								<div class="pull-left">

									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>

                                                                        <button class="btn btn-success rounded" type="button" style="display: none" id="loader"><img src="assets/img/fancybox_loading.gif" > processing..</button>

									

								</div>

							</div>

						</div>

                                        </form>

				</div>

			</div>

		</div>

	</div>

</div>

<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>

<script type="text/javascript" src="js/jquery.validate.min.js"></script>

<script src="js/tokenize2.js"></script>

<script>

$(document).ready(function()

{ 

 $('#summernote').summernote({

		height: "200px"

	});         

});



var postForm = function() {

	var content = $('textarea[name="content"]').html($('#summernote').code());

}

</script>

</body>

</html>