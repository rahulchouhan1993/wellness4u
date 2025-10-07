<?php

include('config.php');

include_once('class.phpmailer.php');

$page_id = '41';

$page_title = 'Chaitanya Wellness Research Institute - Forgot Password';

$meta_keywords = 'Chaitanya Wellness Research Institute';

$meta_description = 'Chaitanya Wellness Research Institute';

$meta_title = 'Chaitanya Wellness Research Institute - Forgot Password';



if(isLoggedIn())

{

	doUpdateOnline($_SESSION['user_id']);

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

	elseif(!chkValidEmailID($email))

	{

		$error = true;

		$err_msg = "Please enter valid email address.";

	}

	

	if(!$error)

		{

		    $name = GetUserName($email);

		

			$url      = SITE_URL.'/reset_password.php?sess='.base64_encode($email).'';
			
			/*
			$to_email = $email;
			$from_email = 'info@wellnessway4u.com';
			$from_name = 'info';
			$subject = 'Reset your passwotd';
			$message = '<p><strong>Hello '.$name.'</strong><p>';
			$message .= '<p>Just click "<a href="'.$url.'">Reset Password</a>" to change your password.</p>';
			$message .= '<p>Or Just copy and paste this url: '.$url.'</p>';
			$message .= '<p>Best Regards</p>';
			$message .= '<p>www.wellnessway4u.com</p>';
			*/
			list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = getEmailAutoresponderDetails('5');
			
			$to_email = $email;
			$from_email = $email_ar_from_email;
			$from_name = $email_ar_from_name;
			$subject = $email_ar_subject;
			$message = $email_ar_body;
			
			$message = str_ireplace("[[USER_NAME]]", $name, $message);
			$message = str_ireplace("[[USER_EMAIL]]", $email, $message);
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
	
			header("Location: message.php?msg=10&sess=".base64_encode($email).""); 
		}

	

}

		

		





?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="description" content="<?php echo $meta_description;?>" />

	<meta name="keywords" content="<?php echo $meta_keywords;?>" />

	<meta name="title" content="<?php echo $meta_title;?>" />

	<title><?php echo $meta_title;?></title>

	<link href="cwri.css" rel="stylesheet" type="text/css" />

	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>

	<script type="text/JavaScript" src="js/commonfn.js"></script>

	<script type="text/javascript" src="js/jquery.bxSlider.js"></script>
    <link href="css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery.ticker.js" type="text/javascript"></script>	

	<script type="text/javascript">

		$(document).ready(function(){
		
			$('#js-news').ticker({
					controls: true,        // Whether or not to show the jQuery News Ticker controls
					 htmlFeed: true, 
					titleText: '',   // To remove the title set this to an empty String
					displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'
					direction: 'ltr'       // Ticker direction - current options are 'ltr' or 'rtl'
					
				});

			$('#slider1').bxSlider();

			$('#slider2').bxSlider();

			

			$(".QTPopup").css('display','none')

			

			$(".feedback").click(function(){

				$(".QTPopup").animate({width: 'show'}, 'slow');

			});	

		

			$(".closeBtn").click(function(){			

				$(".QTPopup").css('display', 'none');

			});

			

		});

	</script>

	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

	<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

	<script type="text/javascript">

		ddsmoothmenu.init({

		mainmenuid: "smoothmenu1", //menu DIV id

		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"

		classname: 'ddsmoothmenu', //class added to menu's outer DIV

		//customtheme: ["#1c5a80", "#18374a"],

		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]

		})

	</script>

</head>

<body>

<?php include_once('analyticstracking.php'); ?>

<?php include_once('analyticstracking_ci.php'); ?>

<?php include_once('analyticstracking_y.php'); ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

	<tr>

		<td align="center" valign="top">

			<?php include_once('header.php'); ?>

			<table width="980" border="0" cellspacing="0" cellpadding="0">

				<tr>

                   

					<td width="620" align="center" valign="top" class="Header_brown"></br>

                    	<form action="#" id="frmlogin" name="frmlogin" method="post">

                        <table width="300" border="0" cellpadding="0" cellspacing="0">

                       <tr>

                            <td width="100" height="35" align="left" valign="middle">Email Address:</td>

                            <td width="200" height="35" align="left" valign="middle"><input name="email" type="text" class="input" id="email" value="<?php echo $email;?>" size="30" /></td>

                        </tr>

                         	<tr>

                               <td>&nbsp;</td>

                              <td align="left" valign="middle" class="err_msg"><?php echo $err_msg;?></td>

                             </tr>

                            <tr>

                            <td height="35" align="left" valign="middle">&nbsp;</td>

                            <td height="35" align="left" valign="middle"><input type="submit" name="btnSubmit" id="btnSubmit" value="Send Mail" /></td>

                        </tr>

                        

                        </table>

                        

                      </form>  

                        

					</td>
                                    
                                    <td width="180" align="left" valign="top">

						<?php include_once('left_sidebar.php'); ?>

					</td>

					<td width="180" align="left" valign="top">

						<?php include_once('right_sidebar.php'); ?>

					</td>

				</tr>

			</table>

			<?php include_once('footer.php'); ?>

		</td>

	</tr>

</table>

</body>

</html>