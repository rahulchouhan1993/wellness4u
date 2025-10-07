<?php
require_once('../config.php');
$page_id = '82';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$ref = base64_encode($menu_link);

if(!isLoggedInPro())
{
	header("Location: ".SITE_URL."/prof_login.php?ref=".$ref);
	exit(0);
}
else
{
	doUpdateOnlinePro($_SESSION['pro_user_id']);
	$pro_user_id = $_SESSION['pro_user_id'];
}

if(chkAdviserPlanFeaturePermission($pro_user_id,'25'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}

if(get_magic_quotes_gpc())
{
	foreach($_POST as $k => $v)
	{
		$_POST[$k] = stripslashes($_POST[$k]);
	}
}

$error = false;
$err_msg = "";

if(isset($_POST['submit']))
{
    $user_name = strip_tags(trim($_POST['user_name']));
	$user_email = strip_tags(trim($_POST['user_email']));
    $msg = strip_tags(trim($_POST['msg']));
    
	if($user_email == '')
	{
		$error = true;
		$err_msg = 'Please enter email of user';
	}
	elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $user_email))
	{
		$error = true;
		$err_msg = 'Please enter valid email';
	}
	elseif(chkIfRequestAlreadySentByAdviser($pro_user_id,$user_email))
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
		if(chkEmailExists($user_email))
		{
			$new_user = 0;
		}
		else
		{
			$new_user = 1;
		}
		
		$arid = addAdvisorsReferral($pro_user_id,$user_email,$user_name,$msg,$new_user);
		if($arid > 0)
		{
			if($new_user == 1)
			{
				$url = SITE_URL.'/register.php?arid='.base64_encode($arid).'&puid='.base64_encode($pro_user_id).'';
				$from_user = getProUserFullNameById($pro_user_id);
				
				/*
				$to_email = $user_email;
				$from_email = 'info@wellnessway4u.com';
				$from_name = getProUserFullNameById($pro_user_id);
				$subject = $from_name.' invites you to explore Wellnessway4u Ecosystem + ONLINE consultation / advisory hub on the move.';
				$body = '<p><strong>Hi '.$user_name.',</strong><p>';
				$body .= '<p>'.$from_name.' says :'.  $msg.'</p>';
				$body .= '<p> <strong>This wellness ecosystem provides a consultation / advisory hub on the move for experts –. Yes! You get it right a virtual platform loaded with tools needed to make the interactions more interactive - analysis, consultation, conversations and rewards for consistency !</strong></p>';
				$body .= '<p>Just click "<a href="'.$url.'">JOIN Now</a>" to complete your registration. That\'s all there is to it. </p>';
				$body .= '<p>Or Just copy and paste this url: '.$url.'</p>';
				$body .= '<p>Best Regards</p>';
				$body .= '<p>www.wellnessway4u.com</p>';
				//$test= $message;
				*/
				
				list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = getEmailAutoresponderDetails('9');
			
				$to_email = $user_email;
				$from_email = $email_ar_from_email;
								
				if($email_ar_from_name == '[[FROM_USER]]')
				{
					$from_name = $from_user;
				}
				else
				{
					$from_name = $email_ar_from_name;
				}
				
				$subject = $email_ar_subject;
				$subject = str_ireplace("[[FROM_USER]]", $from_user, $subject);
				
				$message = $email_ar_body;
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
			header("Location: message.php?msg=4");  //12 is old message id
			exit(0);		
		}
		else 
		{
			$error = true;
			$err_msg = 'Somthing Went Wrong Try later.';
		}
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
	<link href="../cwri.css" rel="stylesheet" type="text/css" />
	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="js/commonfn.js"></script>
	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
	<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
   
    <style type="text/css">@import "css/jquery.datepick.css";</style> 
	<script type="text/javascript" src="js/jquery.datepick.js"></script>
    
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

		$(document).ready(function() {
		
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
                        <td width="980" align="left" valign="top">
                            <table width="940" align="center" border="0" cellspacing="0" cellpadding="0">
                                <tr>
	                            <td height="40" align="left" valign="top" class="breadcrumb">
                                        <?php echo getBreadcrumbCode($page_id);?>
                                    </td>
                                </tr>
                            </table>
                            <table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="left" valign="top">
                                        <span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br /><br />
                                    <?php echo getPageContents($page_id);?>
                                    </td>
                                </tr>
                            </table>
                       	<?php
						if($page_access)
						{ ?> 
                    	<table width="940" align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
                            <tr>
                                <td align="center" valign="middle" bgcolor="#FFFFFF" style="background-repeat:repeat-x; padding:10px;">
                                	<form action='#' method="post">
                                        <table border="0" width="600" cellpadding="0" cellspacing="0">
                                        	<tr>
												<td colspan="2" align="left" class="err_msg"><?php echo $err_msg;?></td>
											</tr>
                                            <tr>
                                        		<td width="100" height="30" align="left" valign="top">Email ID :</td> 
                                        		<td width="500"  height="30" align="left" valign="top"><input style="width: 200px;" type="text" name="user_email" id="user_email" value="<?php echo $user_email; ?>"/><span style="color:red;">*</span></td>
                                        	</tr>
                                        	<tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="30" align="left" valign="top">User Name :</td> 
                                                <td height="30" align="left" valign="top"><input style="width: 200px;" type="text" name="user_name" id="user_name" value=""/><span style="color:red;">*</span></td>
                                            </tr>    
                                            <tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                        		<td height="30" align="left" valign="top">Message :</td> 
                                        		<td height="30" align="left" valign="top"><textarea rows="8" cols="30" name="msg" id="msg"></textarea><span style="color:red;">*</span></td>
                                            </tr>
                                            <tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                            	<td height="30" align="left" valign="top">&nbsp;</td>
                                        		<td height="30" align="left" valign="top"><input type="submit" name="submit" id="submit" value="Send Request" /></td> 
                                        	</tr>
                                        </table>
                                    </form>
                                </td>
                            </tr>
                   		</table>
                        <?php 
						} 
						else 
						{ ?>
							<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
								<tr align="center">
									<td height="5" class="Header_brown"><?php echo getCommonSettingValue('4');?></td>
								</tr>
							</table>
						<?php 
						} ?>
                    </td>
                </tr>
            </table>
			<?php include_once('footer.php'); ?>
        </td>
    </tr>
    <tr>
		<td align="center" valign="top" background="images/top_back.jpg" style="background-repeat: repeat-x;">&nbsp;</td>
	</tr>
</table>
</body>
</html>