<?php
include('config.php');
$page_id = '42';
$page_title = 'Chaitanya Wellness Research Institute - Reset Password';
$meta_keywords = 'Chaitanya Wellness Research Institute';
$meta_description = 'Chaitanya Wellness Research Institute';
$meta_title = 'Chaitanya Wellness Research Institute - Reset Password';

if(isLoggedIn())
{
	doUpdateOnline($_SESSION['user_id']);
}

$error = false;
$err_msg = '';
$tr_err_rpassword = 'none';
$tr_err_password= 'none';
$err_rpassword = '';
$err_password = '';

if(isset($_GET['sess']) && $_GET['sess'] != '')
{
	$sess = $_GET['sess'];
	$email = base64_decode($sess);

	if(!chkEmailExists($email))
	{
		$error = true;
		$err_msg = 'Invalid Access!';
		header('location:message.php');
		exit(0);
	}
}

if($_POST['btnSubmit'])
{
	$password = $_POST['password'];
	$rpassword = $_POST['rpassword'];
	
	if($password == '')
	{
		$error = true;
		$tr_err_password = '';
		$err_password = 'Please enter your Password';
	}
	elseif(!chkValidPassword($password))
	{
		$error = true;
		$tr_err_password = '';
		$err_password = 'Please enter valid Password.<br>Atleast 1 Upper case alphabate[A-Z],<br> 1 Lower case alphabate[a-z] ,<br> 1 Numeric[0-9] ,<br>  1 special characters[!@#$%^&*()-_=+,<>./?]';
	}

	if($rpassword == '')
	{
		$error = true;
		$tr_err_rpassword = '';
		$err_rpassword = 'Please Conform your Password';
	}
	elseif($rpassword != $password)
	{
		$error = true;
		$tr_err_rpassword = '';
		$err_rpassword = 'Please enter same confirm password';
	}

	if(!$error)
	{
		$user_id = getUserIdReset($email);
		$name = GetUserName($email);
		ResetPassword($password,$user_id);

		/*
		$to_email = $email;
		$from_email = 'info@wellnessway4u.com';
		$from_name = 'info';
		$subject = 'Your password reset successfully!';
		$message = '<p><strong>Hello '.$name.'</strong><p>';
		//$message .= '<p>Your password -: '.$password.'</p>';
		$message .= '<p>Your password reset successfully!</p>';
		$message .= '<p>Best Regards</p>';
		$message .= '<p>www.wellnessway4u.com</p>';
		*/
		list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = getEmailAutoresponderDetails('6');
			
		$to_email = $email;
		$from_email = $email_ar_from_email;
		$from_name = $email_ar_from_name;
		$subject = $email_ar_subject;
		$message = $email_ar_body;
		
		$message = str_ireplace("[[USER_NAME]]", $name, $message);
		//$message = str_ireplace("[[USER_EMAIL]]", $email, $message);
		//$message = str_ireplace("[[ANCHER_URL_START]]", '<a href="'.$url.'">', $message);
		//$message = str_ireplace("[[ANCHER_URL_END]]", '</a>', $message);
		//$message = str_ireplace("[[URL]]", $url, $message);

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
		
		header("Location: message.php?msg=11&sess=".base64_encode($email).""); 
	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                   
					<td width="620" align="center" valign="top" class="Header_brown">
                        <br />
                        <form action="#" id="frmlogin" name="frmlogin" method="post">
                            <table width="350" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="150" height="35" align="left" valign="middle">New Password:</td>
                                    <td width="200" height="35" align="left" valign="middle"><input name="password" type="password" class="input" id="password" size="30" /></td>
                                </tr>
                                <tr id="tr_err_password" style="display:<?php echo $tr_err_password;?>;">
                                    <td align="right">&nbsp; </td>
                                    <td align="left" class="err_msg" id="err_password"><?php echo $err_password;?></td>
                                </tr>
                                <tr>
                                    <td height="35" align="left" valign="middle">Re enter Password:</td>
                                    <td height="35" align="left" valign="middle"><input name="rpassword" type="password" class="input" id="rpassword" size="30" /></td>
                                </tr>
                                <tr id="tr_err_rpassword" style="display:<?php echo $tr_err_rpassword;?>;">
                                    <td align="right">&nbsp; </td>
                                    <td align="left" class="err_msg" id="err_rpassword"><?php echo $err_rpassword;?></td>
                                </tr>
                                <tr>
                                    <td height="35" align="left" valign="middle">&nbsp;</td>
                                    <td height="35" align="left" valign="middle"><input type="submit" name="btnSubmit" id="btnSubmit" value="Reset" /></td>
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