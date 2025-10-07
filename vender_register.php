<?php
include('config.php');
$page_id = '128';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

if(isLoggedInVender())
{
    doUpdateOnlineVender($_SESSION['vender_user_id']);
    header("Location: ".SITE_URL."/venders/edit_profile_vender.php");
    exit(0);
}

if(get_magic_quotes_gpc())
{
    foreach($_POST as $k => $v)
    {
        $_POST[$k] = stripslashes($_POST[$k]);
    }
}

/*
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
 * 
 */

$error = false;
$tr_err_contract_person = 'none';
$tr_err_company_name = 'none';
$tr_err_contract_email = 'none';
$tr_err_contract_mobile = 'none';
$tr_err_address = 'none';
$tr_err_country_id = 'none';
$tr_err_state_id = 'none';
$tr_err_city_id = 'none';
$tr_err_place_id = 'none';
$tr_err_password = 'none';
$tr_err_cpassword = 'none';

$err_contract_person = '';
$err_company_name = '';
$err_contract_email = '';
$err_contract_mobile = '';
$err_address = '';
$err_country_id = '';
$err_state_id = '';
$err_city_id = '';
$err_place_id = '';
$err_password = '';
$err_cpassword = '';

if(isset($_POST['btnSubmit']))	
{
    $contract_person = strip_tags(trim($_POST['contract_person']));
    $contract_person_type = '0';
    $company_name = strip_tags(trim($_POST['company_name']));
    $contract_email = strip_tags(trim($_POST['contract_email']));
    $contract_mobile = strip_tags(trim($_POST['contract_mobile']));
    $address = strip_tags(trim($_POST['address']));
    $country_id = strip_tags(trim($_POST['country_id']));
    $state_id = strip_tags(trim($_POST['state_id']));
    $city_id = strip_tags(trim($_POST['city_id']));
    $place_id = strip_tags(trim($_POST['place_id']));
    $password = trim($_POST['password']);
    $cpassword = trim($_POST['cpassword']); 
	
    if($contract_person == '')
    {
        $error = true;
        $tr_err_contract_person = '';
        $err_contract_person = 'Please enter authorise person';
    }
    
    if($company_name == '')
    {
        $error = true;
        $tr_err_company_name = '';
        $err_company_name = 'Please enter company name';
    }

    if($contract_email == '')
    {
        $error = true;
        $tr_err_contract_email = '';
        $err_contract_email = 'Please enter your email';
    }
    elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $contract_email))
    {
        $error = true;
        $tr_err_contract_email = '';
        $err_contract_email = 'Please enter valid email';
    }
    elseif(chkVenderEmailExists($contract_email))
    {
        $error = true;
        $tr_err_contract_email = '';
        $err_contract_email = 'This email is already registered';
    }
	
    if($contract_mobile == '')
    {
        $error = true;
        $tr_err_contract_mobile = '';
        $err_contract_mobile = 'Please enter your mobile no';
    }
    elseif(!is_numeric($contract_mobile))
    {
        //$error = true;
        //$tr_err_contract_mobile = '';
        //$err_contract_mobile = 'Please enter valid mobile no';
    }
	
    if($address == '')
    {
        $error = true;
        $tr_err_address = '';
        $err_address = 'Please enter your address';
    }

    if($country_id == '')
    {
        $error = true;
        $tr_err_country_id = '';
        $err_country_id = 'Please select your country';
    }

    if($state_id == '')
    {
        $error = true;
        $tr_err_state_id = '';
        $err_state_id = 'Please select your state';
    }

    if($city_id == '')
    {
        $error = true;
        $tr_err_city_id = '';
        $err_city_id = 'Please select your city';
    }

    if($place_id == '')
    {
        $error = true;
        $tr_err_place_id = '';
        $err_place_id = 'Please select your place';
    }
	
    if($password == '')
    {
            $error = true;
            $tr_err_password = '';
            $err_password = 'Please enter password';
    }
    elseif(!chkValidPassword($password))
    {
            //$error = true;
            //$tr_err_password = '';
            //$err_password = 'Please enter valid Password.<br>Atleast 1 Upper case alphabate[A-Z],<br> 1 Lower case alphabate[a-z] ,<br> 1 Numeric[0-9] ,<br>  1 special characters[!@#$%^&*()-_=+,<>./?]';
    }

    if($cpassword == '')
    {
            $error = true;
            $tr_err_cpassword = '';
            $err_cpassword = 'Please enter confirm password';
    }
    elseif($cpassword != $password)
    {
            $error = true;
            $tr_err_cpassword = '';
            $err_cpassword = 'Please enter same confirm password';
    }

    if(!$error)
    {
        $signUpVenderUser = signUpVenderUser($company_name,$contract_person,$contract_person_type,$contract_email,$password,$contract_mobile,$address,$country_id,$state_id,$city_id,$place_id);
        if($signUpVenderUser > 0)
        {
            /*
            if($puid != '' && $arid !='' )
            {
                updateAdvisorsReferral($arid,$puid,$email);
            }
             * 
             */
            $url = SITE_URL.'/validate_vender_user.php.php?sess='.base64_encode($contract_email).'';

            /*
            $to_email = $email;
            $from_email = 'info@wellnessway4u.com';
            $from_name = 'info';
            $subject = 'Complete your Registration at Wellness Way For You -- last step';
            $message = '<p><strong>Hi '.$name.',</strong><p>';
            $message .= '<p>Just click "<a href="'.$url.'">Activate Now</a>" to complete your registration. That\'s all there is to it. </p>';
            $message .= '<p>Or Just copy and paste this url: '.$url.'</p>';
            $message .= '<p>Best Regards</p>';
            $message .= '<p>www.wellnessway4u.com</p>';
            */

            
            list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = getEmailAutoresponderDetails('3');

            $to_email = $contract_email;
            $from_email = $email_ar_from_email;
            $from_name = $email_ar_from_name;
            $subject = $email_ar_subject;
            $message = $email_ar_body;

            $message = str_ireplace("[[ADVISER_NAME]]", $contract_person, $message);
            $message = str_ireplace("[[ADVISER_EMAIL]]", $contract_email, $message);
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
             
            header("Location: message.php?msg=1&sess=".base64_encode($contract_email).""); 
        }
        else
        {
                $err_msg = 'There is some problem right now!Please try again later';
        }
            	
    }
}
else
{
    $contract_person = '';
    $company_name = '';
    $contract_email = '';
    $contract_mobile = '';
    $address = '';
    $country_id = '';
    $state_id = '';
    $city_id = '';
    $place_id = '';
    $password = '';
    $cpassword = '';

    /*
    if($_GET['puid']!='' && $_GET['arid']!='')
    {
            $arid = base64_decode($_GET['arid']);
            $puid =  base64_decode($_GET['puid']);

            list($email,$name) = getNameAndEmailOfAdviserReferral($arid);
    }
    else
    {
            $arid = '';
            $puid =  '';
    }
     * 
     */
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

<header> <?php include_once('header.php');?> 
</header>

<div class="container">  
    <div class="breadcrumb">
                    <div class="row">
                    <div class=" col-md-8">
                      <?php echo getBreadcrumbCode($page_id);?> 
                       </div>
                       <div class=" col-md-4">
                       </div>
                       
                       </div>
                </div>
            </div>
<!--container-->
 <div class="container">
       <div class="row">
            <div class=" col-md-8"> 
                                    <form action="#" name="frmregister" id="frmregister" method="post" enctype="multipart/form-data"> 
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0"  id="tblrow">
                                            <tr>
                                                <td height="50" colspan="2" align="left" valign="top" class="Header_brown"><?php echo getPageTitle($page_id);?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" colspan="2" align="left" valign="top"><?php echo getPageContents($page_id);?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" class="err_msg"><?php echo $err_msg;?></td>
                                            </tr>
                                            <tr>
                                                <td width="30%" height="50" align="left" valign="top">Company Name:</td>
                                                <td width="70%" height="50" align="left" valign="top"><input name="company_name" type="text" class="form-control" id="company_name" size="45"  value="<?php echo $company_name; ?>" /></td>
                                            </tr>
                                            <tr id="tr_err_company_name" style="display:<?php echo $tr_err_company_name;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_company_name"><?php echo $err_company_name;?></td>
                                            </tr>
                                            <tr>
                                                <td width="30%" height="50" align="left" valign="top">Authorise Person 	:</td>
                                                <td width="70%" height="50" align="left" valign="top"><input name="contract_person" type="text" class="form-control" id="contract_person" size="45"  value="<?php echo $contract_person; ?>" /></td>
                                            </tr>
                                            <tr id="tr_err_contract_person" style="display:<?php echo $tr_err_contract_person;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_contract_person"><?php echo $err_contract_person;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">Email ID:</td>
                                                <td height="50" align="left" valign="top"><input name="contract_email" type="text" class="form-control" id="contract_email" size="45" value="<?php echo $contract_email; ?>" /></td>
                                            </tr>
                                            <tr id="tr_err_contract_email" style="display:<?php echo $tr_err_contract_email;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_contract_email"><?php echo $err_contract_email;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">Mobile No:</td>
                                                <td height="50" align="left" valign="top"><input name="contract_mobile" type="text" class="form-control" id="contract_mobile" size="45" value="<?php echo $contract_mobile; ?>" /></td>
                                            </tr>
                                            <tr id="tr_err_contract_mobile" style="display:<?php echo $tr_err_contract_mobile;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_contract_mobile"><?php echo $err_contract_mobile;?></td>
                                            </tr>
                                            <tr>
                                                <td height="65" align="left" valign="top">Address:</td>
                                                <td height="65" align="left" valign="top"><textarea name="address" id="address" class="form-control" rows="3"><?php echo $address; ?></textarea></td>
                                            </tr>
                                            <tr id="tr_err_address" style="display:<?php echo $tr_err_address;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_address"><?php echo $err_address;?></td>
                                            </tr>
                                            <tr>
                                                <td height="10" align="left" valign="top">&nbsp;</td>
                                                <td height="10" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">Country:</td>
                                                <td height="50" align="left" valign="top">
                                                    <select class="form-control" name="country_id" id="country_id" onchange="getStateOptions('<?php echo $state_id;?>')">
                                                        <option value="">Select Country</option>
                                                        <?php echo getCountryOptions($country_id);?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="tr_err_country_id" style="display:<?php echo $tr_err_country_id;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_country_id"><?php echo $err_country_id;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">State:</td>
                                                <td height="50" align="left" valign="top" id="tdstate">
                                                    <select class="form-control" name="state_id" id="state_id" onchange="getCityOptions('<?php echo $city_id;?>');">
                                                        <option value="">Select State</option>
                                                        <?php echo getStateOptions($country_id,$state_id); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="tr_err_state_id" style="display:<?php echo $tr_err_state_id;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_state_id"><?php echo $err_state_id;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">City:</td>
                                                <td height="50" align="left" valign="top" id="tdcity">
                                                    <select class="form-control"  name="city_id" id="city_id" onchange="getPlaceOptions('<?php echo $place_id;?>');">
                                                        <option value="">Select City</option>
                                                        <?php echo getCityOptions($state_id,$city_id); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="tr_err_city_id" style="display:<?php echo $tr_err_city_id;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_city_id"><?php echo $err_city_id;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">Place:</td>
                                                <td height="50" align="left" valign="top" id="tdplace">
                                                    <select class="form-control" name="place_id" id="place_id">
                                                        <option value="">Select Place</option>
                                                        <?php echo getPlaceOptions($state_id,$city_id,$place_id); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="tr_err_place_id" style="display:<?php echo $tr_err_place_id;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_place_id"><?php echo $err_place_id;?></td>
                                            </tr>
                                            
                                            <tr>
                                                <td height="10" align="left" valign="top">&nbsp;</td>
                                                <td height="10" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top"><strong>Password:</strong></td>
                                                <td height="50" align="left" valign="top"><input name="password" type="password" class="form-control" id="password" size="45" /></td>
                                            </tr>
                                            <tr>
                                             <td></td>
                                              <td height="50"  align="left" valign="top" class="err_msg">Password Atleast 1 Upper case alphabate[A-Z], 1 Lower case alphabate[a-z] , 1 Numeric[0-9] , 1 special characters[!@#$%^&*()-_=+,<>./?] </td>
                                            </tr>
                                            <tr id="tr_err_password" style="display:<?php echo $tr_err_password;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_password"><?php echo $err_password;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top"><strong>Confirm Password:</strong></td>
                                                <td height="50" align="left" valign="top"><input name="cpassword" type="password" class="form-control" id="cpassword" size="45" /></td>
                                            </tr>
                                            <tr id="tr_err_cpassword" style="display:<?php echo $tr_err_cpassword;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td valign="top" align="left" class="err_msg" id="err_cpassword"><?php echo $err_cpassword;?></td>
                                            </tr>
                                            <tr>
                                                    <td height="50" align="left" valign="top">Terms &amp; Conditions of Service:</td>
                                                    <td height="50" align="left" valign="top">
                                                            <p>By clicking  the "I accept. Create My Account" below, I certify that I have read and agree to the<a onclick="NewWindow(this.href,'name','530','290','yes');return false" href="terms_and_conditions_adviser.php" class="footer_link"> Terms & Conditions for advisers</a> below and both the <a onclick="NewWindow(this.href,'name','530','290','yes');return false" href="disclaimer.php" class="footer_link"> Disclaimer Policy</a> and the <a onclick="NewWindow(this.href,'name','530','290','yes');return false" href="privacy_policy.php" class="footer_link">Privacy Policy</a>.<br /></p>
                                                            <textarea readonly name="tos" id="tos"  class="form-control" cols="32"><?php echo strip_tags(trim(getPageContents('79')));?></textarea>
                                                    </td>
                                            </tr>
                                            <tr>
                                              <td height="40" align="left" valign="middle">&nbsp;</td>
                                              <td height="40" align="left" valign="bottom">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                    <td height="40" align="left" valign="middle">&nbsp;</td>
                                                    <td height="40" align="left" valign="bottom"><input name="btnSubmit" type="submit" class="btn btn-primary"  id="btnSubmit" value="Create my account as a Wellness Vender "/></td>
                                            </tr>
                                              <tr>
                                              <td height="40" align="left" valign="middle">&nbsp;</td>
                                              <td height="40" align="left" valign="bottom">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </form>	
                      
     </div>
               <!-- Left side start  -->       
      <div class=" col-md-2"> 
                         <?php include_once('left_sidebar.php'); ?>
        </div>
         <!-- Right side End  -->   
         <div class=" col-md-2"> 
                         <?php include_once('right_sidebar.php'); ?>
        </div>
         <!-- Right side End  --> 
    </div>
 </div>
  <!-- End container-->                      
					

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
       <!-- <script src="csswell/js/jquery.min.js"></script>       --> 
        <!--bootstrap js plugin-->
        <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
        <!--easing plugin for smooth scroll-->
        <!--<script src="csswell/js/jquery.easing.1.3.min.js" type="text/javascript"></script>-->
        <!--sticky header-->
       <!-- <script type="text/javascript" src="csswell/js/jquery.sticky.js"></script>-->
</body>
</html>