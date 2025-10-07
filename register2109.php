<?php
include('config.php');
$page_id = '2';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

if(isLoggedIn())
{
	doUpdateOnline($_SESSION['user_id']);
	header("Location: edit_profile.php");
	exit(0);
}

if(get_magic_quotes_gpc())
{
	foreach($_POST as $k => $v)
	{
		$_POST[$k] = stripslashes($_POST[$k]);
	}
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





$error = false;
$tr_err_name = 'none';
$tr_err_middle_name='none';
$tr_err_last_name='none';
$tr_err_email = 'none';
$tr_err_dob = 'none';
$tr_err_height = 'none';
$tr_err_weight = 'none';
$tr_err_sex = 'none';
$tr_err_mobile = 'none';
$tr_err_country_id = 'none';
$tr_err_state_id = 'none';
$tr_err_city_id = 'none';
$tr_err_place_id = 'none';
$tr_err_food_veg_nonveg = 'none';
$tr_err_password = 'none';
$tr_err_cpassword = 'none';

$tr_beef_pork = 'none';
$err_name = '';
$err_middle_name = '';
$err_last_name = '';
$err_email = '';
$err_dob = '';
$err_height = '';
$err_weight = '';
$err_sex = '';
$err_mobile = '';
$err_country_id = '';
$err_state_id = '';
$err_city_id = '';
$err_place_id = '';
$err_food_veg_nonveg = '';
$err_password = '';
$err_cpassword = '';

if(isset($_POST['btnSubmit']))	
{
	$name = strip_tags(trim($_POST['name']));
        $middle_name = strip_tags(trim($_POST['middle_name']));
        $last_name = strip_tags(trim($_POST['last_name']));
	$email = strip_tags(trim($_POST['email']));
	$day = trim($_POST['day']);
	$month = trim($_POST['month']);
	$year = trim($_POST['year']);
	$height = strip_tags(trim($_POST['height']));
	$weight = strip_tags(trim($_POST['weight']));
	$sex = strip_tags(trim($_POST['sex']));
	$mobile = strip_tags(trim($_POST['mobile']));
	$country_id = strip_tags(trim($_POST['country_id']));
	$state_id = strip_tags(trim($_POST['state_id']));
	$city_id = strip_tags(trim($_POST['city_id']));
	$place_id = strip_tags(trim($_POST['place_id']));
	$food_veg_nonveg = strip_tags(trim($_POST['food_veg_nonveg']));
	$beef = strip_tags(trim($_POST['beef']));
	$pork = strip_tags(trim($_POST['pork']));
	$password = trim($_POST['password']);
	$cpassword = trim($_POST['cpassword']);
	
	$uid = $_POST['uid'];
    $refid = $_POST['refid'];
	
	$puid = $_POST['puid'];
    $arid = $_POST['arid'];
	
	if($name == '')
	{
		$error = true;
		$tr_err_name = '';
		$err_name = 'Please enter your name';
	}
	if($middle_name == '')
	{
		$error = true;
		$tr_err_middle_name = '';
		$err_middle_name = 'Please enter your middle name';
	}
        if($last_name == '')
	{
		$error = true;
		$tr_err_last_name = '';
		$err_last_name = 'Please enter your last name';
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
	elseif(chkEmailExists($email))
	{
		$error = true;
		$tr_err_email = '';
		$err_email = 'This email is already registered';
	}

	if( ($day == '') || ($month == '') || ($year == '') )
	{
		$error = true;
		$tr_err_dob = '';
		$err_dob = 'Please select date of birth';
	}
	elseif(!checkdate($month,$day,$year))
	{
		$error = true;
		$tr_err_dob = '';
		$err_dob = 'Please select valid date of birth';
	}
	else
	{
		$dob = $year.'-'.$month.'-'.$day;
	}	

	if($height == '')
	{
		$error = true;
		$tr_err_height = '';
		$err_height = 'Please select your height';
	}
	elseif(!is_numeric($height))
	{
		$error = true;
		$tr_err_height = '';
		$err_height = 'Please enter valid height in cm';
	}

	if($weight == '')
	{
		$error = true;
		$tr_err_weight = '';
		$err_weight = 'Please enter your weight in kgs';
	}
	elseif(!is_numeric($weight))
	{
		$error = true;
		$tr_err_weight = '';
		$err_weight = 'Please enter valid weight in kgs';
	}

	if($sex == '')
	{
		$error = true;
		$tr_err_sex = '';
		$err_sex = 'Please select your sex';
	}

	if($mobile == '')
	{
		$error = true;
		$tr_err_mobile = '';
		$err_mobile = 'Please enter your mobile no';
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

	if($food_veg_nonveg == '')
	{
		$error = true;
		$tr_err_food_veg_nonveg = '';
		$err_food_veg_nonveg = 'Please select food option';
	}
	else
	{
		if($food_veg_nonveg == 'NV')
		{
			$tr_beef_pork = '';
		}
		else
		{
			$beef = '0';
			$pork = '0';
			$tr_beef_pork = '0';
		}
	}

	if($password == '')
	{
		$error = true;
		$tr_err_password = '';
		$err_password = 'Please enter password';
	}
	elseif(!chkValidPassword($password))
	{
		$error = true;
		$tr_err_password = '';
		$err_password = 'Please enter valid Password.<br>Atleast 1 Upper case alphabate[A-Z],<br> 1 Lower case alphabate[a-z] ,<br> 1 Numeric[0-9] ,<br>  1 special characters[!@#$%^&*()-_=+,<>./?]';
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
		$signUpUser = signUpUser($name,$middle_name,$last_name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$password,$country_id);
		if($signUpUser > 0)
		{
			if($uid != '' && $refid !='' )
			{
				$tdata = array();
				$tdata['id'] = $refid;
				$tdata['uid'] = $uid;
				updatereferafriend($tdata,$email);
			}
			
			if($puid != '' && $arid !='' )
			{
				updateAdvisorsReferral($arid,$puid,$email);
			}
		
			$url = SITE_URL.'/validate_user.php?sess='.base64_encode($email).'';
			
			list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = getEmailAutoresponderDetails('1');
			
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

			
			/*$to_email = $email;
			$from_email = 'info@wellnessway4u.com';
			$from_name = 'info';
			$subject = 'Complete your Registration at Wellness Way For You -- last step';
			$message = '<p><strong>Hi '.$name.',</strong><p>';
			$message .= '<p>Just click "<a href="'.$url.'">Activate Now</a>" to complete your registration. That\'s all there is to it. </p>';
			$message .= '<p>Or Just copy and paste this url: '.$url.'</p>';
			$message .= '<p>Best Regards</p>';
			$message .= '<p>www.wellnessway4u.com</p>';*/

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
			//header("Location: message.php?msg=1&sess=".base64_encode($email).""); 

 echo "<script>window.location.href='message.php?msg=1&sess=".base64_encode($email)."'</script>";
			//$err_msg = $url;
			
		}
		else
		{
			$err_msg = 'There is some problem right now!Please try again later';
		}
	}
}
else
{
	$name = '';
        $middle_name = '';
        $last_name = '';
	$email = '';
	$dob = '';
	$height = '';
	$weight = '';
	$sex = '';
	$mobile = '';
	$place_id = '';
	$password = '';
	$cpassword = '';
	
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
  <link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">       <link href="csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />
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
			
<!--header-->
<header>
 <?php include 'topbar.php'; ?>
<?php include_once('header.php');?>
</header>
<!--header End --> 			
<!--breadcrumb--> 
  
 <div class="container"> 
    <div class="breadcrumb">
               
                    <div class="row">
                    <div class="col-md-8">	
                      <?php echo getBreadcrumbCode($page_id);?> 
                       </div>
                         <div class="col-md-4">
                         </div>
                       </div>
                </div>
            </div>
<!--breadcrumb end --> 
<!--container-->              
<div class="container">
<div class="row">	
<div class="col-md-8">	
<h4 >START!!! ... My WAY2WELLNESS Path for Holistic Well-being</h4>				
<!-- Form-->                        
<form action="<?php echo SITE_URL.'/register.php'?>" name="frmregister" id="frmregister" method="post">
                                    	<input type="hidden" name="uid" id="uid" value="<?php echo $uid; ?>" />
                                        <input type="hidden" name="refid" id="refid" value="<?php echo $refid ?>" /> 
                                        <input type="hidden" name="puid" id="puid" value="<?php echo $puid; ?>" />
                                        <input type="hidden" name="arid" id="arid" value="<?php echo $arid ?>" /> 
                                         
<table width="100%" border="0" cellspacing="4" cellpadding="2">
											<tr>
												<td  colspan="2" align="left" valign="top" class="Header_brown"><?php echo getPageTitle($page_id);?></td>
											</tr>
                                            <tr>
												<td colspan="2" align="left" class="err_msg"><?php echo $err_msg;?></td>
											</tr>
											
											<tr>

												<td width="40%" height="50" align="left" valign="bottom">First Name:</td>

												<td width="60%"  align="left" valign="bottom"><input name="name" class="form-control" type="text"  id="name"  value="<?php echo $name;?>" /></td>

											</tr>
                                                                                        <tr id="tr_err_name" style="display:<?php echo $tr_err_name;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_name"><?php echo $err_name;?></td>
											</tr>
                                                                                        <tr>

												<td width="40%" height="50" align="left" valign="bottom">Middle Name:</td>

												<td width="60%"  align="left" valign="bottom"><input name="middle_name" class="form-control" type="text"  id="middle_name"  value="<?php echo $middle_name;?>" /></td>

											</tr>
                                                                                        <tr id="tr_err_name" style="display:<?php echo $tr_err_middle_name;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_name"><?php echo $err_middle_name;?></td>
											</tr>
                                                                                        <tr>

												<td width="40%" height="50" align="left" valign="bottom">Last Name:</td>

												<td width="60%"  align="left" valign="bottom"><input name="last_name" class="form-control" type="text"  id="last_name"  value="<?php echo $last_name;?>" /></td>

											</tr>
											<tr id="tr_err_name" style="display:<?php echo $tr_err_last_name;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_name"><?php echo $err_last_name;?></td>
											</tr>
											<tr>
												<td height="50" align="left" valign="bottom">Email ID:</td>
												<td  align="left" valign="bottom"><input name="email" type="text" class="form-control"  id="email"  value="<?php echo $email;?>" /></td>
											</tr>
											<tr id="tr_err_email" style="display:<?php echo $tr_err_email;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_email"><?php echo $err_email;?></td>
											</tr>
											<tr>
												<td height="50" align="left" >DOB:</td>
												<td  align="left" valign="bottom">
<div class="row" style="margin-top:15px;">
<div class="col-xs-4">													<select name="day" id="day" class="form-control">
														<option value="">DAY</option>
													<?php
													for($i=1;$i<=31;$i++)
													{ ?>
														<option value="<?php echo $i;?>" <?php if($day == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
													<?php
													} ?>	
													</select>
</div>
<div class="col-xs-4">													<select name="month" id="month" class="form-control">
														<option value="">MONTH</option>
														<?php echo getMonthOptions($month); ?>
													</select>
</div>
<div class="col-xs-4">														<select name="year" id="year" class="form-control">
														<option value="">YEAR</option>
													<?php
													for($i=1940;$i<=2008;$i++)
													{ ?>
														<option value="<?php echo $i;?>" <?php if($year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
													<?php
													} ?>	
													</select>&nbsp;
</div>   
</div>	</td>
											</tr>
											<tr id="tr_err_dob" style="display:<?php echo $tr_err_dob;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_dob"><?php echo $err_dob;?></td>
											</tr>
											<tr>
												<td height="50" align="left" valign="bottom">Height: (cm)</td>
												<td  align="left" valign="bottom">
													<select name="height" id="height" class="form-control">
														<option value="">Select Height</option>
														<?php echo getHeightOptions($height); ?>
													</select>												
                                                </td>	
											</tr>
											<tr id="tr_err_height" style="display:<?php echo $tr_err_height;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_height"><?php echo $err_height;?></td>
											</tr>
											<tr>
												<td height="50" align="left" valign="bottom">Weight: (kg)</td>
												<td  align="left" valign="bottom">
													<select name="weight" id="weight" class="form-control">
														<option value="">Select Weight</option>
													<?php
													for($i=20;$i<=200;$i++)
													{ ?>
														<option value="<?php echo $i;?>" <?php if($weight == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?> Kgs</option>
													<?php
													} ?>	
													</select>												
                                                </td>
											</tr>
											<tr id="tr_err_weight" style="display:<?php echo $tr_err_weight;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_weight"><?php echo $err_weight;?></td>
											</tr>
											<tr>
												<td height="50" align="left" valign="bottom">Sex:</td>
												<td  align="left" valign="bottom">
        

<input type="radio" name="sex" id="sex" value="Male" <?php if($sex == "Male") { ?> checked="checked" <?php } ?> />
													Male
 <input type="radio" name="sex" id="sex" value="Female" <?php if($sex == "Female") { ?> checked="checked" <?php } ?> />
													Female
	
										</td>
											</tr>
											<tr id="tr_err_sex" style="display:<?php echo $tr_err_sex;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_sex"><?php echo $err_sex;?></td>
											</tr>
											<tr>
												<td height="50" align="left" valign="bottom">Mobile No.:</td>

												<td  align="left" valign="bottom"><input name="mobile" type="text" class="form-control"  id="mobile"  maxlength="10" value="<?php echo $mobile; ?>" /></td>
											</tr>
											<tr id="tr_err_mobile" style="display:<?php echo $tr_err_mobile;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_mobile"><?php echo $err_mobile;?></td>
											</tr>
											<tr>
                                                <td height="50" align="left" valign="bottom">Country:</td>
                                                <td align="left" valign="bottom">
                                                    <select name="country_id" id="country_id" onchange="getStateOptions('<?php echo $state_id;?>')" class="form-control">
                                                        <option value="" class="form-control">Select Country</option>
                                                        <?php echo getCountryOptions($country_id);?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="tr_err_country_id" style="display:<?php echo $tr_err_country_id;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td align="left" class="err_msg" id="err_country_id"><?php echo $err_country_id;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="bottom">State:</td>
                                                <td align="left" valign="bottom" id="tdstate">
                                                    <select name="state_id" id="state_id" onchange="getCityOptions('<?php echo $city_id;?>');" class="form-control">
                                                        <option value="" class="form-control">Select State</option>
                                                        <?php echo getStateOptions($country_id,$state_id); ?>
                                                    </select>
                                                </td>
                                            </tr>
											<tr id="tr_err_state_id" style="display:<?php echo $tr_err_state_id;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_state_id"><?php echo $err_state_id;?></td>
											</tr>
											<tr>
												<td height="50" align="left" valign="bottom">City</td>
												<td align="left" valign="bottom" id="tdcity">
													<select name="city_id" id="city_id" onchange="getPlaceOptions('<?php echo $place_id;?>');" class="form-control">
														<option value="" class="form-control">Select City</option>
														<?php echo getCityOptions($state_id,$city_id); ?>
													</select>												</td>	
											</tr>
											<tr id="tr_err_city_id" style="display:<?php echo $tr_err_city_id;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_city_id"><?php echo $err_city_id;?></td>
											</tr>
											<tr>
												<td height="50" align="left" valign="bottom">Place</td>
												<td align="left" valign="bottom" id="tdplace">
													<select name="place_id" id="place_id" class="form-control">
														<option value="" class="form-control">Select Place</option>
														<?php echo getPlaceOptions($state_id,$city_id,$place_id); ?>
													</select>												</td>	
											</tr>
											<tr id="tr_err_place_id" style="display:<?php echo $tr_err_place_id;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_place_id"><?php echo $err_place_id;?></td>
											</tr>
											<tr>
												<td align="left" valign="bottom">&nbsp;</td>
												<td align="left" valign="bottom"><?php echo getPageContents($page_id);?></td>
											</tr>
											<tr>
												<td height="50" align="left" valign="bottom">Food Option </td>
												<td align="left" valign="bottom">


													<input type="radio" name="food_veg_nonveg" id="food_veg_nonveg[]" value="V" <?php if($food_veg_nonveg == "V") { ?> 	 checked="checked" <?php } ?> onclick="toggleBeefAndPorkOption();" />Veg &nbsp;

<input type="radio" name="food_veg_nonveg" id="food_veg_nonveg[]" value="VE" <?php if($food_veg_nonveg == "VE") { ?> checked="checked" <?php } ?> onclick="toggleBeefAndPorkOption();" />Veg + Egg&nbsp;

  <input type="radio" name="food_veg_nonveg" id="food_veg_nonveg[]" value="NV" <?php if($food_veg_nonveg == "NV") { ?> checked="checked" <?php } ?> onclick="toggleBeefAndPorkOption();" />All(Veg + Non Veg)&nbsp;	
 

</td>	
											</tr>
											<tr id="tr_err_food_veg_nonveg" style="display:<?php echo $tr_err_food_veg_nonveg;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_food_veg_nonveg"><?php echo $err_food_veg_nonveg;?></td>
											</tr>
											<tr id="tr_beef_pork" style="display:<?php echo $tr_beef_pork;?>;">
												<td align="left" valign="bottom">&nbsp; </td>
												<td align="left" valign="bottom">

										<input type="checkbox" name="beef" id="beef" value="1" <?php if($beef == "1") { ?> checked="checked" <?php } ?> />Beef &nbsp;
										<input type="checkbox" name="pork" id="pork" value="1" <?php if($pork == "1") { ?> checked="checked" <?php } ?> />Pork&nbsp;												


</td>	
											</tr>
											<tr>
												<td align="left" valign="bottom">&nbsp;</td>
												<td align="left" valign="bottom">&nbsp;</td>
											</tr>
											<tr>
												<td height="50" align="left" valign="bottom"><strong>Password:</strong></td>
												<td align="left" valign="bottom"><input name="password" type="password" class="form-control"  id="password"  /></td>
											</tr>
                                            <tr>
                                            <td></td>
											  <td height="50" align="left" valign="top" class="err_msg">      
Password Atleast 1 Upper case alphabate[A-Z], 1 Lower case alphabate[a-z] , 1 Numeric[0-9] , 1 special characters[!@#$%^&*()-_=+,<>./?]  </td>
		  </tr>
											<tr id="tr_err_password" style="display:<?php echo $tr_err_password;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_password"><?php echo $err_password;?></td>
											</tr>
											<tr>
												<td height="50" align="left" valign="bottom"><strong>Confirm Password:</strong></td>
												<td align="left" valign="bottom"><input name="cpassword" type="password" class="form-control"  id="cpassword"  /></td>
											</tr>
											<tr id="tr_err_cpassword" style="display:<?php echo $tr_err_cpassword;?>;">
												<td align="right">&nbsp; </td>
												<td align="left" class="err_msg" id="err_cpassword"><?php echo $err_cpassword;?></td>
											</tr>
											<tr>
												<td align="left" valign="bottom">&nbsp;</td>
												<td align="left" valign="bottom">&nbsp;</td>
											</tr>
											<tr>
												<td  align="left" valign="top">Terms &amp; Conditions of Service:</td>
												<td align="left" valign="top">
													<p>
													By clicking  the "I accept. Create My Account" below, I certify that I have read and agree to the<a onclick="NewWindow(this.href,'name','530','290','yes');return false" href="terms_and_conditions.php" class="footer_link"> Terms & Conditions of Service</a> below and both the <a onclick="NewWindow(this.href,'name','530','290','yes');return false" href="disclaimer.php" class="footer_link"> Disclaimer Policy</a> and the <a onclick="NewWindow(this.href,'name','530','290','yes');return false" href="privacy_policy.php" class="footer_link">Privacy Policy</a>.<br /></p>
													<textarea readonly name="tos" id="tos" class="form-control" rows="6" ><?php echo strip_tags(getPageContents('27'));?></textarea>
												</td>
											</tr>
											<tr>
												<td height="60" align="left" valign="middle">&nbsp;</td>
												<td  align="left" valign="bottom"><input name="btnSubmit" type="submit" class="btn btn-primary" id="btnSubmit" value="I accept. Create my account" /></td>
											</tr>
										</table>
</form>	

<!-- End Form-->
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

<!--  Footer-->
  <footer> 
   <div class="container">
   <div class="row">
   <div class="col-md-12">	
   <?php include_once('footer.php');?>            
  </div>
  </div>
  </div>
  </footer>
  <!--  Footer-->

<!-- Bootstrap Core JavaScript -->

 <!--default footer end here-->
       <!--scripts and plugins -->
        <!--must need plugin jquery-->
        <script src="csswell/js/jquery.min.js"></script>        
        <!--bootstrap js plugin-->
        <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
        <!--easing plugin for smooth scroll-->
        <script src="csswell/js/jquery.easing.1.3.min.js" type="text/javascript"></script>
        <!--sticky header-->
        <script type="text/javascript" src="csswell/js/jquery.sticky.js"></script>
      
             <!--gmap js-->
       <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript">
            var myLatlng;
            var map;
            var marker;

            function initialize() {
                myLatlng = new google.maps.LatLng(37.397802, -121.890288);


                var mapOptions = {
                    zoom: 13,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false,
                    draggable: false
                };
                map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                var contentString = '<p style="line-height: 20px;"><strong>assan Template</strong></p><p>Vailshali, assan City, 302012</p>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: 'Marker'
                });

                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map, marker);
                });
            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>-->
</body>
</html>

