<?php
include('config.php');
$page_id = '130';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$error = false;
$err_msg = '';
if(isset($_GET['sess']) && $_GET['sess'] != '')
{
	$sess = $_GET['sess'];
	$email = base64_decode($sess);

	if(!chkVenderEmailExists($email))
	{
		$error = true;
		$err_msg = 'Invalid Access!';
		header('location:message.php');
		exit(0);
	}
	else
	{
		if(doValiadteVenderUser($email))

		{

			$pro_user_id = getVenderUserId($email);
			$name = getVenderUserFullNameById($pro_user_id);
			$unique_id = getVenderUserUniqueId($pro_user_id);

			$err_msg = 'Welcome '.$name.'! You\'re now registered member  <a href="'.SITE_URL.'/vender_login.php">Click here to Sign In</a>';		

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
			
			list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = getEmailAutoresponderDetails('4');
			
			$to_email = $email;
			$from_email = $email_ar_from_email;
			$from_name = $email_ar_from_name;
			$subject = $email_ar_subject;
			$message = $email_ar_body;
			
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

	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

	<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
    
    <link href="css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery.ticker.js" type="text/javascript"></script>

	<script type="text/javascript">

		ddsmoothmenu.init({

		mainmenuid: "smoothmenu1", //menu DIV id

		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"

		classname: 'ddsmoothmenu', //class added to menu's outer DIV

		//customtheme: ["#1c5a80", "#18374a"],

		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]

		})

		$(document).ready(function(){
		
		$('#js-news').ticker({
					controls: true,        // Whether or not to show the jQuery News Ticker controls
					 htmlFeed: true, 
					titleText: '',   // To remove the title set this to an empty String
					displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'
					direction: 'ltr'       // Ticker direction - current options are 'ltr' or 'rtl'
					
				});

		$(".QTPopup").css('display','none')

			

			$(".feedback").click(function(){

				$(".QTPopup").animate({width: 'show'}, 'slow');

			});	

		

			$(".closeBtn").click(function(){			

				$(".QTPopup").css('display', 'none');

			});

		});	

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

					

					<td width="620" align="center" valign="top" class="Header_brown">

						

						<table width="620" border="0" cellspacing="0" cellpadding="0">

							<tr>

								<td align="center"><?php echo $err_msg;?></td>

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