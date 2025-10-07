<?php
include('config.php');
$page_id = '11';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('edit_profile.php');
if(!isLoggedIn())
{
	header("Location: login.php?ref=".$ref);
	exit(0);
}
else
{
	$user_id = $_SESSION['user_id'];
	doUpdateOnline($_SESSION['user_id']);
}

if(get_magic_quotes_gpc())
{
	foreach($_POST as $k => $v)
	{
		$_POST[$k] = stripslashes($_POST[$k]);
	}
}

$error = false;
$tr_err_name = 'none';
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
$tr_beef_pork = 'none';

$err_name = '';
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

if(isset($_POST['btnSubmit']))	
{
	$name = strip_tags(trim($_POST['name']));
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
	
	if($name == '')
	{
		$error = true;
		$tr_err_name = '';
		$err_name = 'Please enter your name';
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
			$tr_beef_pork = 'none';
		}
	}
	
	if(!$error)
	{
		$updateUser = updateUser($name,$dob,$height,$weight,$sex,$mobile,$country_id,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$user_id);
		if($updateUser)
		{
			$_SESSION['name'] = $name;
			header("Location: message.php?msg=2"); 
		}
		else
		{
			$err_msg = 'There is some problem right now!Please try again later';
		}
	}
}
else
{
	list($return,$name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$practitioner_id,$country_id) = getUserDetails($user_id);

	if(!$return)
	{
		header("Location: message.php");
		exit(0);
	}
	else
	{
		$temp = explode("-",$dob);
		$year = $temp[0];
		$month = $temp[1];
		$day = $temp[2];
		
		if($food_veg_nonveg == 'NV')
		{
			$tr_beef_pork = '';
		}
		else
		{
			$tr_beef_pork = 'none';
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
                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id'],'2','1');
                    }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td width="620" align="left" valign="top">
                        <table width="580" align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
                            <tr>
                                <td align="center" valign="middle" bgcolor="#FFFFFF" style="background-repeat:repeat-x; padding:10px;">
                                    <form action="<?php echo SITE_URL.'/edit_profile.php'?>" name="frmedit_profile" id="frmedit_profile" method="post"> 
                                        <table width="500" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td height="35" colspan="2" align="left" valign="top" class="Header_brown"><?php echo getPageTitle($page_id);?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" class="err_msg"><?php echo $err_msg;?></td>
                                            </tr>
                                            <tr>
                                                <td width="123" height="30" align="left" valign="bottom">Name:</td>
                                                <td width="377" height="30" align="left" valign="bottom"><input name="name" type="text" class="input" id="name" size="45" value="<?php echo $name;?>" /></td>
                                            </tr>
                                            <tr id="tr_err_name" style="display:<?php echo $tr_err_name;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td align="left" class="err_msg" id="err_name"><?php echo $err_name;?></td>
                                            </tr>
                                            <tr>
                                                <td height="30" align="left" valign="bottom">DOB:</td>
                                                <td height="30" align="left" valign="bottom">
                                                    <select name="day" id="day">
                                                        <option value="">DAY</option>
                                                    <?php
                                                    for($i=1;$i<=31;$i++)
                                                    { ?>
                                                        <option value="<?php echo $i;?>" <?php if($day == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                                    <?php
                                                    } ?>	
                                                    </select>
                                                    &nbsp;
                                                    <select name="month" id="month">
                                                        <option value="">MONTH</option>
                                                        <?php echo getMonthOptions($month); ?>
                                                    </select>
                                                    &nbsp;
                                                    <select name="year" id="year">
                                                        <option value="">YEAR</option>
                                                    <?php
                                                    for($i=1940;$i<=2008;$i++)
                                                    { ?>
                                                        <option value="<?php echo $i;?>" <?php if($year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                                    <?php
                                                    } ?>	
                                                    </select>
                                                    &nbsp;
                                                </td>
                                            </tr>
                                            <tr id="tr_err_dob" style="display:<?php echo $tr_err_dob;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td align="left" class="err_msg" id="err_dob"><?php echo $err_dob;?></td>
                                            </tr>
                                            <tr>
                                                <td height="30" align="left" valign="bottom">Height: (cm)</td>
                                                <td height="30" align="left" valign="bottom">
                                                    <select name="height" id="height">
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
                                                <td height="30" align="left" valign="bottom">Weight: (kg)</td>
                                                <td height="30" align="left" valign="bottom">
                                                    <select name="weight" id="weight">
                                                        <option value="">Select Weight</option>
                                                    <?php
                                                    for($i=45;$i<=200;$i++)
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
                                                <td height="30" align="left" valign="bottom">Sex:</td>
                                                <td height="30" align="left" valign="bottom">
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
                                                <td height="30" align="left" valign="bottom">Mobile No.:</td>
                                                <td height="30" align="left" valign="bottom"><input name="mobile" type="text" class="input" id="mobile" size="45" maxlength="10" value="<?php echo $mobile; ?>" /></td>
                                            </tr>
                                            <tr id="tr_err_mobile" style="display:<?php echo $tr_err_mobile;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td align="left" class="err_msg" id="err_mobile"><?php echo $err_mobile;?></td>
                                            </tr>
                                            <tr>
                                                <td height="30" align="left" valign="bottom">Country:</td>
                                                <td height="30" align="left" valign="bottom">
                                                    <select name="country_id" id="country_id" onchange="getStateOptions('<?php echo $state_id;?>')">
                                                        <option value="">Select Country</option>
                                                        <?php echo getCountryOptions($country_id);?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="tr_err_country_id" style="display:<?php echo $tr_err_country_id;?>;">
                                                <td align="right">&nbsp; </td>
                                                <td align="left" class="err_msg" id="err_country_id"><?php echo $err_country_id;?></td>
                                            </tr>
                                            <tr>
                                                <td height="30" align="left" valign="bottom">State:</td>
                                                <td height="30" align="left" valign="bottom" id="tdstate">
                                                    <select name="state_id" id="state_id" onchange="getCityOptions('<?php echo $city_id;?>');">
                                                        <option value="">Select State</option>
                                                        <?php echo getStateOptions($country_id,$state_id); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="tr_err_state_id" style="display:<?php echo $tr_err_state_id;?>;">
                                                    <td align="right">&nbsp; </td>
                                                    <td align="left" class="err_msg" id="err_state_id"><?php echo $err_state_id;?></td>
                                            </tr>
                                            <tr>
                                                    <td height="30" align="left" valign="bottom">City</td>
                                                    <td height="30" align="left" valign="bottom" id="tdcity">
                                                            <select name="city_id" id="city_id" onchange="getPlaceOptions('<?php echo $place_id;?>');">
                                                                    <option value="">Select City</option>
                                                                    <?php echo getCityOptions($state_id,$city_id); ?>
                                                            </select>												</td>	
                                            </tr>
                                            <tr id="tr_err_city_id" style="display:<?php echo $tr_err_city_id;?>;">
                                                    <td align="right">&nbsp; </td>
                                                    <td align="left" class="err_msg" id="err_city_id"><?php echo $err_city_id;?></td>
                                            </tr>
                                            <tr>
                                                    <td height="30" align="left" valign="bottom">Place</td>
                                                    <td height="30" align="left" valign="bottom" id="tdplace">
                                                            <select name="place_id" id="place_id">
                                                                    <option value="">Select Place</option>
                                                                    <?php echo getPlaceOptions($state_id,$city_id,$place_id); ?>
                                                            </select>												</td>	
                                            </tr>
                                            <tr id="tr_err_place_id" style="display:<?php echo $tr_err_place_id;?>;">
                                                    <td align="right">&nbsp; </td>
                                                    <td align="left" class="err_msg" id="err_place_id"><?php echo $err_place_id;?></td>
                                            </tr>
                                            <tr>
                                                    <td height="30" align="left" valign="bottom">&nbsp;</td>
                                                    <td height="30" align="left" valign="bottom"><?php echo getPageContents($page_id);?></td>
                                            </tr>
                                            <tr>
                                                    <td height="30" align="left" valign="bottom">Food Option </td>
                                                    <td height="30" align="left" valign="bottom">
                                                            <input type="radio" name="food_veg_nonveg" id="food_veg_nonveg[]" value="V" <?php if($food_veg_nonveg == "V") { ?> checked="checked" <?php } ?> onclick="toggleBeefAndPorkOption();" />Veg &nbsp;
                                                            <input type="radio" name="food_veg_nonveg" id="food_veg_nonveg[]" value="VE" <?php if($food_veg_nonveg == "VE") { ?> checked="checked" <?php } ?> onclick="toggleBeefAndPorkOption();" />Veg + Egg&nbsp;
                                                            <input type="radio" name="food_veg_nonveg" id="food_veg_nonveg[]" value="NV" <?php if($food_veg_nonveg == "NV") { ?> checked="checked" <?php } ?> onclick="toggleBeefAndPorkOption();" />All(Veg + Non Veg)&nbsp;
                                                    </td>	
                                            </tr>
                                            <tr id="tr_err_food_veg_nonveg" style="display:<?php echo $tr_err_food_veg_nonveg;?>;">
                                                    <td align="right">&nbsp; </td>
                                                    <td align="left" class="err_msg" id="err_food_veg_nonveg"><?php echo $err_food_veg_nonveg;?></td>
                                            </tr>
                                            <tr id="tr_beef_pork" style="display:<?php echo $tr_beef_pork;?>;">
                                                    <td height="30" align="left" valign="bottom">&nbsp; </td>
                                                    <td height="30" align="left" valign="bottom">
                                                            <input type="checkbox" name="beef" id="beef" value="1" <?php if($beef == "1") { ?> checked="checked" <?php } ?> />Beef &nbsp;
                                                            <input type="checkbox" name="pork" id="pork" value="1" <?php if($pork == "1") { ?> checked="checked" <?php } ?> />Pork &nbsp;
                                                    </td>	
                                            </tr>
                                            <tr>
                                                    <td height="30" align="left" valign="bottom">&nbsp;</td>
                                                    <td height="30" align="left" valign="bottom">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                    <td height="40" align="left" valign="middle">&nbsp;</td>
                                                    <td height="40" align="left" valign="bottom"><input name="btnSubmit" type="submit" class="button" id="btnSubmit" value="Submit" /></td>
                                            </tr>
                                        </table>
                                    </form>	
                                </td>
                            </tr>
                        </table>
                        <table width="580" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>&nbsp;</td>
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