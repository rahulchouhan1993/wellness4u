<?php
include('config.php');
$page_id = '37';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

if(isLoggedIn())
{
	$user_id = $_SESSION['user_id'];
	doUpdateOnline($_SESSION['user_id']);
}

$error = false;
$tr_err_name = 'none';
$tr_err_email = 'none';
$tr_err_msg = 'none';
$err_name = '';
$err_email = '';
$err_msg = '';

if(isset($_POST['btnSubmit']))	
{
	$name = strip_tags(trim($_POST['name']));
	$email = strip_tags(trim($_POST['email']));
	$msg = strip_tags(trim($_POST['msg']));
	
	if($name == '')
	{
		$error = true;
		$tr_err_name = '';
		$err_name = 'Please enter your name';
	}
	
	if($email == '')
	{
		$error = true;
		$tr_err_email = '';
		$err_email = 'Please enter your email';
	}
	elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
	{
		$error = true;
		$tr_err_email = '';
		$err_email = 'Please enter valid email';
	}
	
	if($msg == '')
	{
		$error = true;
		$tr_err_msg = '';
		$err_msg = 'Please enter your message';
	}
	
	if(!$error)
	{
		/*
		$to_email = 'info@wellnessway4u.com';
		$from_email = 'info@wellnessway4u.com';
		$from_name = $name;
		$subject = 'Contact us email from visitor';
		$message = '<p><strong>Hello Admin,</strong><p>';
		$message .= '<p>Below are the details of enquiry sent by visitors</p>';
		$message .= '<p><strong>Name:</strong> '.$name.'</p>';
		$message .= '<p><strong>Email:</strong> '.$email.'</p>';
		$message .= '<p><strong>Message:</strong> '.$msg.'</p>';
		$message .= '<p>Best Regards</p>';
		$message .= '<p>www.wellnessway4u.com</p>';
		*/
		
		list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = getEmailAutoresponderDetails('7');
			
		$to_email = $email_ar_to_email;
		
		if($email_ar_from_email == '[[USER_EMAIL]]')
		{
			$from_email = $email;
		}
		else
		{
			$from_email = $email_ar_from_email;
		}
		
		if($email_ar_from_name == '[[USER_NAME]]')
		{
			$from_name = $name;
		}
		else
		{
			$from_name = $email_ar_from_name;
		}
			
		
		$subject = $email_ar_subject;
		$message = $email_ar_body;
		
		$message = str_ireplace("[[USER_NAME]]", $name, $message);
		$message = str_ireplace("[[USER_EMAIL]]", $email, $message);
		$message = str_ireplace("[[MSG]]", $msg, $message);
		
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
		header("Location: message.php?msg=3"); 
	
	}
}
else
{
	$name = '';
	$email = '';
	$msg = '';
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
                        $('#slider3').bxSlider();
                        $('#slider4').bxSlider();
                        $('#slider5').bxSlider();
                        $('#slider6').bxSlider();

                        $('#slider_main1').bxSlider();
                        $('#slider_main2').bxSlider();
                        $('#slider_main3').bxSlider();
                        $('#slider_main4').bxSlider();
                        $('#slider_main5').bxSlider();
                        $('#slider_main6').bxSlider();
			

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

			<?php include_once('header.php');?>

			

			<table width="980" border="0" cellspacing="0" cellpadding="0">

                            <tr>
                                <td width="620" align="left" valign="top">
                                    <table width="580" align="center" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td height="40" align="left" valign="top" class="breadcrumb">
                                                <?php echo getBreadcrumbCode($page_id);?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td colspan="2" align="left" valign="top">
                                    <?php
                                    if(isLoggedIn())
                                    { 
                                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);
                                    }
                                    ?>
                                </td>
                            </tr>
                            
				<tr>

					

                 

                                    <td width="620" align="left" valign="top">

						

						

						<table width="580" border="0" align="center" cellpadding="0" cellspacing="0">

							<tr>

								<td width="250" align="left" valign="top">

									<span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br />

									<?php echo getPageContents($page_id);?>

								</td>

								<td width="330" align="left" valign="top">

									<form action="#" method="post" name="frmcontact_us" id="frmcontact_us">

									<table width="325" height="315" border="0" cellpadding="3" cellspacing="0">

										<tr>

											<td height="20" align="left" valign="bottom"  class="Header_brown"><strong>Contact Form</strong></td>

										</tr>

										<tr>

											<td height="20" align="left" valign="bottom"><strong>Full Name/Company Name:</strong></td>

										</tr>

										<tr>

											<td height="20" align="left" valign="top"><input name="name" type="text" id="name" size="40" value="<?php echo $name;?>" /></td>

										</tr>

										<tr style="display:<?php echo $tr_err_name;?>;" valign="top">

											<td align="left" class="err_msg" valign="top"><?php echo $err_name;?></td>

										</tr>

										<tr>

											<td height="20" align="left" valign="bottom"><strong>Email Address:</strong></td>

										</tr>

										<tr>

											<td height="20" align="left" valign="top"><input name="email" type="text" id="email" size="40" value="<?php echo $email;?>" /></td>

										</tr>

										<tr style="display:<?php echo $tr_err_email;?>;" valign="top">

											<td align="left" class="err_msg" valign="top"><?php echo $err_email;?></td>

										</tr>

										<tr>

											<td height="20" align="left" valign="middle"><strong>Message:</strong></td>

										</tr>

										<tr>

											<td height="110" align="left" valign="top"><textarea name="msg" id="msg" cols="30" rows="6"><?php echo $msg;?></textarea></td>

										</tr>

										<tr style="display:<?php echo $tr_err_msg;?>;" valign="top">

											<td align="left" class="err_msg" valign="top"><?php echo $err_msg;?></td>

										</tr>

										<tr>

											<td height="35" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit"/></td>

										</tr>

									</table>

									</form>

								</td>

							</tr>

						</table>
                                            <table width="580" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                    <?php echo getScrollingWindowsCodeMainContent($page_id);?>
                                    <?php echo getPageContents2($page_id);?>
                                </td>
                            </tr>
                        </table>

					</td>
                                    
                                    
                                    <td width="180" align="left" valign="top">

						<?php include_once('left_sidebar.php'); ?>

					</td>

					<td width="180" align="left" valign="top">

						<?php include_once('right_sidebar.php'); ?>

					</td>

				</tr>

			</table>

			<?php include_once('footer.php');?>

		</td>

	</tr>

</table>

</body>

</html>