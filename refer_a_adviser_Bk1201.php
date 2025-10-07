<?php
include('config.php');
$page_id = '115';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('refer_a_adviser.php');
if(!isLoggedIn())
{
	// header("Location: login.php?ref=".$ref);
echo "<script>window.location.href='login.php?ref=$ref'</script>";
	exit(0);
}
else
{
	$user_id = $_SESSION['user_id'];
	doUpdateOnline($_SESSION['user_id']);
}

if(chkUserPlanFeaturePermission($user_id,'32'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}

$error = false;
$msg = '';

if(isset($_POST['submit']))
{
    $user_name = strip_tags(trim($_POST['user_name']));
    $user_email = strip_tags(trim($_POST['user_email']));
    $msg = strip_tags(trim($_POST['msg']));
    
    if($user_email == '')
    {
            $error = true;
            $err_msg = 'Please enter email of adviser';
    }
    elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $user_email))
    {
            $error = true;
            $err_msg = 'Please enter valid email';
    }
    elseif(chkIfRequestAlreadySentByuser($user_id,$user_email))
    {
            $error = true;
            $err_msg = 'You have already sent request to this adviser.';
    }

    if($user_name == '')
    {
       $error = true;
       $err_msg .='<br>Please enter name of adviser';
    }
	
    if(!$error)
    {
        if(chkProEmailExists($user_email))
        {
            $new_user = 0;
            if(chkIfUserIsAdvisersReferralsChkByProEmail($user_email,$user_id))
            {
                $error = true;
                $err_msg = 'You have already added adviser.';
            }
        }
        else
        {
            $new_user = 1;
        }
        
        if(!$error)
        {
            $invite_by_user = 1;
            $arid = addUsersReferral($user_id,$user_email,$user_name,$msg,$new_user,$invite_by_user);
            if($arid > 0)
            {
                    if($new_user == 1)
                    {
                            $url = SITE_URL.'/prof_register.php?arid='.base64_encode($arid).'&puid='.base64_encode($user_id).'';
                            $from_user = getUserFullNameById($user_id);

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
                    header("Location: message.php?msg=13"); 
echo "<script>window.location.href='message.php?msg=13'</script>";
                    exit(0);		
            }
            else 
            {
                    $error = true;
                    $err_msg = 'Somthing Went Wrong Try later.';
            }
        }
    }
    
    if($err_msg != '')
        {
            $err_msg = '<div class="err_msg_box"><span class="blink_me">'.$err_msg.'</span></div>';
            
         }
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $meta_description;?>" />
	<meta name="keywords" content="<?php echo $meta_keywords;?>" />
	<meta name="title" content="<?php echo $meta_title;?>" />
	<title><?php echo $meta_title;?></title>
	<link href="cwri.css" rel="stylesheet" type="text/css" />
     <link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">    
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

<header> 
<?php include 'topbar.php'; ?>
<?php include_once('header.php');?> 
</header>

<div class="container">  
    <div class="breadcrumb">
                    <div class="row">
                    <div class=" col-md-8">
                      <?php echo getBreadcrumbCode($page_id);?> 
                       </div>
                       <div class=" col-md-4">
                        <?php
                                    if(isLoggedIn())
                                    { 
                                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);
                                    }
                                    ?>
                       </div>
                       
                       </div>
                </div>
            </div>
<!--container-->
 <div class="container">
       <div class="row">
            <div class=" col-md-8"> 

                        
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
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
                    	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="100%" align="left" valign="top">
                                	
                                    <form action='#' method="post">
                                        <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                        	<tr>
												<td colspan="2" align="left" class="err_msg"><?php echo $err_msg;?></td>
											</tr>
                                            <tr>
                                        		<td width="20%" height="30" align="left" valign="top"><span style="color:red;">*</span>Email ID:</td> 
                                        		<td width="80%"  height="30" align="left" valign="top"><input class="form-control"  type="text" name="user_email" id="user_email" value="<?php echo $user_email; ?>"/></td>
                                        	</tr>

                                        	<tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="30" align="left" valign="top"><span style="color:red;">*</span>User Name:</td> 
                                                <td height="30" align="left" valign="top"><input class="form-control"  type="text" name="user_name" id="user_name" value=""/></td>
                                            </tr>    
                                            <tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                        		<td height="30" align="left" valign="top"><span style="color:red;">*</span>Message:</td> 
                                        		<td height="30" align="left" valign="top"><textarea class="form-control"  cols="30" name="msg" id="msg"><?php echo $msg;?></textarea></td>
                                            </tr>
                                            <tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                            	<td height="30" align="left" valign="top">&nbsp;</td>
                                        		<td height="30" align="left" valign="top"><input type="submit" name="submit" class="btn btn-primary" id="submit" value="Send Request" /></td> 
                                        	</tr>
                                            <tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
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
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr align="center">
                                <td height="5" class="Header_brown"><?php echo getCommonSettingValue('3');?></td>
                            </tr>
                        </table>
                        <?php 
                        } ?>
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                    <?php echo getScrollingWindowsCodeMainContent($page_id);?>
                                    <?php echo getPageContents2($page_id);?>
                                </td>
                            </tr>
                        </table>
             
  </div>                       
                                   
<!-- ad left_sidebar-->

                <div class="col-md-2">	
                <?php include_once('left_sidebar.php'); ?>
              </div>
               <!-- ad left_sidebar end -->
                <!-- ad right_sidebar-->
               <div class="col-md-2">	
                <?php include_once('right_sidebar.php'); ?></div>
  
 <!-- ad right_sidebar end -->
</div>	
</div>
<!--container--> 
<!--footer -->         
              <footer>
    <div class="container">
                    <div class="row">
                    <div class="col-md-12">	
     <?php include_once('footer.php');?>
    </div></div></div>
  </footer>    
      <!--footer end --> 
<!-- Bootstrap Core JavaScript -->

 <!--default footer end here-->
       <!--scripts and plugins -->
        <!--must need plugin jquery-->
        <script src="csswell/js/jquery.min.js"></script>        
        <!--bootstrap js plugin-->
        <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       

</body>
</html>     