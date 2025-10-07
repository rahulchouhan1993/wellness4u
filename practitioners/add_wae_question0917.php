<?php
require_once('../config.php');
$page_id = '76';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('practitioners/add_wae_question.php');

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

if(!chkAdviserPlanFeaturePermission($pro_user_id,'22'))
{
	header('location: wae_questions.php');
	exit(0);
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

$tr_days_of_month = 'none';
$tr_single_date = 'none';
$tr_date_range = 'none';

$arr_days_of_month = array();
$arr_state_id = array();
$arr_city_id = array();
$arr_place_id = array();
$arr_user_id = array();
$arr_min_rating = array();
$arr_max_rating = array();
$arr_interpretaion = array();
$arr_treatment = array();

$row_cnt = '1';
$row_totalRow = '1';

if(isset($_POST['btnSubmit']))
{
	$row_totalRow = trim($_POST['hdnrow_totalRow']);  
	$row_cnt = trim($_POST['hdnrow_cnt']);
	$situation = strip_tags(trim($_POST['situation']));
	$situation_font_family = trim($_POST['situation_font_family']);
	$situation_font_size = trim($_POST['situation_font_size']);
	$situation_font_color = trim($_POST['situation_font_color']);
	
	$listing_date_type = trim($_POST['listing_date_type']);
		
	foreach ($_POST['days_of_month'] as $key => $value) 
	{
		array_push($arr_days_of_month,$value);
	}
	
	$single_date = trim($_POST['single_date']);
	$start_date = trim($_POST['start_date']);
	$end_date = trim($_POST['end_date']);
	
	$country_id = trim($_POST['country_id']);
	
	foreach ($_POST['state_id'] as $key => $value) 
	{
		array_push($arr_state_id,$value);
	}
	
	foreach ($_POST['city_id'] as $key => $value) 
	{
		array_push($arr_city_id,$value);
	}
	
	foreach ($_POST['place_id'] as $key => $value) 
	{
		array_push($arr_place_id,$value);
	}
	
	foreach ($_POST['user_id'] as $key => $value) 
	{
		array_push($arr_user_id,$value);
	}
	
	
	$keywords = trim($_POST['keywords']);
	$listing_order = trim($_POST['listing_order']);
	
	foreach ($_POST['min_rating'] as $key => $value) 
	{
		array_push($arr_min_rating,$value);
	}
	
	foreach ($_POST['max_rating'] as $key => $value) 
	{
		array_push($arr_max_rating,$value);
	}
	
	foreach ($_POST['interpretaion'] as $key => $value) 
	{
		array_push($arr_interpretaion,$value);
	}
	
	foreach ($_POST['treatment'] as $key => $value) 
	{
		array_push($arr_treatment,$value);
	}
	
	if($situation == '')
	{
		$error = true;
		$err_msg = 'Please enter question';
	}
	
	if($situation_font_family == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter font family for question';
	}
	
	if($situation_font_size == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter font size for question';
	}
	
	if($listing_date_type == '')
	{
		$error = true;
		$err_msg .= '<br>Please select selection date type';
	}
	elseif($listing_date_type == 'days_of_month')
	{
		$tr_days_of_month = '';
		$tr_single_date = 'none';
		$tr_date_range = 'none';
		
		if(count($arr_days_of_month) < 1)
		{
			$error = true;
			$err_msg .= '<br>Please select days of month';
		}
		else
		{
			$days_of_month = implode(',',$arr_days_of_month);
		}	
	}
	elseif($listing_date_type == 'single_date')
	{
		$tr_days_of_month = 'none';
		$tr_single_date = '';
		$tr_date_range = 'none';
		
		if($single_date == '')
		{
			$error = true;
			$err_msg .= '<br>Please select single date';
		}	
	}
	elseif($listing_date_type == 'date_range')
	{
		$tr_days_of_month = 'none';
		$tr_single_date = 'none';
		$tr_date_range = '';
		
		if($start_date == '')
		{
			$error = true;
			$err_msg .= '<br>Please select start date';
		}
		elseif($end_date == '')
		{
			$error = true;
			$err_msg .= '<br>Please select end date';
		}
		else
		{
			if(strtotime($start_date) > strtotime($end_date))
			{
				$error = true;
				$err_msg .= '<br>Please select end date greater than start date';
			}
		}	
	}
	
	if(!$error)
	{
		if($listing_date_type == 'days_of_month')
		{
			$single_date = '';
			$start_date = '';
			$end_date = '';
		}
		elseif($listing_date_type == 'single_date')
		{
			$days_of_month = '';
			$start_date = '';
			$end_date = '';
			
			$single_date = date('Y-m-d',strtotime($single_date));
		}
		elseif($listing_date_type == 'date_range')
		{
			$days_of_month = '';
			$single_date = '';
			
			$start_date = date('Y-m-d',strtotime($start_date));
			$end_date = date('Y-m-d',strtotime($end_date));
		}
		
		if($arr_state_id[0] == '')
		{
			$str_state_id = '';
		}
		else
		{
			$str_state_id = implode(',',$arr_state_id);
		}
		
		if($arr_city_id[0] == '')
		{
			$str_city_id = '';
		}
		else
		{
			$str_city_id = implode(',',$arr_city_id);
		}
		
		if($arr_place_id[0] == '')
		{
			$str_place_id = '';
		}
		else
		{
			$str_place_id = implode(',',$arr_place_id);
		}
		
		if($arr_user_id[0] == '')
		{
			$str_user_id = '';
		}
		else
		{
			$str_user_id = implode(',',$arr_user_id);
		}
		
		if(addWAEQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$str_state_id,$str_city_id,$str_user_id,$pro_user_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$country_id,$str_place_id))
		{
			$msg = "Question Added Successfully!";
			header('location: wae_questions.php?msg='.urlencode($msg));
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}
}
else
{
	$situation = '';
	$situation_font_family = '';
	$situation_font_size = '';
	$situation_font_color = '000000';
	$listing_date_type = '';
	$days_of_month = '';
	$single_date = '';
	$start_date = '';
	$end_date = '';
	$country_id = '';
	$arr_state_id[0] = '';
	$arr_city_id[0] = '';
	$arr_place_id[0] = '';
	$arr_user_id[0] = '';
	$keywords = '';
	$listing_order = '1';
	$arr_min_rating[0] = '0';
	$arr_max_rating[0] = '0';
	$arr_interpretaion[0] = '';
	$arr_treatment[0] = '';
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
	<link href="../cwri.css" rel="stylesheet" type="text/css" />
     <link href="../csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
	<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="js/commonfn.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
	<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
    <script type="text/javascript" src="js/jscolor.js"></script>
    
    <style type="text/css">@import "../css/jquery.datepick.css";</style> 
	<script type="text/javascript" src="../js/jquery.datepick.js"></script>
    
   <link href="../css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="../js/jquery.ticker.js" type="text/javascript"></script>
    
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
			
			$('#addMoreRows').click(function() {
		
				var row_cnt = parseInt($('#hdnrow_cnt').val());
				var row_totalRow = parseInt($('#hdnrow_totalRow').val());
				
				$('#tblrow tr:#add_before_this_row').before('<tr id="row_id_1_'+row_cnt+'"><td ><strong>Rating</strong></td><td align="center"><strong>:</strong></td><td align="left"><strong>From</strong>&nbsp;<select name="min_rating[]" id="min_rating_'+row_cnt+'"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select>&nbsp;&nbsp;<strong>To</strong>&nbsp;<select name="max_rating[]" id="max_rating_'+row_cnt+'"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></td></tr><tr id="row_id_2_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr id="row_id_3_'+row_cnt+'"><td  valign="top"><strong>Interpretation</strong></td><td align="center" valign="top"><strong>:</strong></td><td align="left" valign="top"><textarea name="interpretaion[]" id="interpretaion_'+row_cnt+'" rows="5" cols="25"></textarea></td></tr><tr id="row_id_4_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr id="row_id_5_'+row_cnt+'"><td  valign="top"><strong>Treatment</strong></td><td align="center" valign="top"><strong>:</strong></td><td align="left" valign="top"><textarea name="treatment[]" id="treatment_'+row_cnt+'" rows="5" cols="25"></textarea>&nbsp;<input type="button" value="Remove Item" id="tr_row_'+row_cnt+'" name="tr_row_'+row_cnt+'" onclick="removeRows('+row_cnt+')" /></td></tr><tr id="row_id_6_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr>');	
					
				row_cnt = row_cnt + 1;       
				$('#hdnrow_cnt').val(row_cnt);
				var row_cnt = $('#hdnrow_cnt').val();
				row_totalRow = row_totalRow + 1;       
				$('#hdnrow_totalRow').val(row_totalRow);
							
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
<div class="container" >
<div class="row">	
<div class="col-md-8">	
						<table width="100%" align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
							<tr>
								<td align="center" valign="middle" bgcolor="#FFFFFF" style="background-repeat:repeat-x; padding:10px;">
									<form action="#" name="frmedit_profile" id="frmedit_profile" method="post" enctype="multipart/form-data"> 
                                    	
										<input type="hidden" name="hdnrow_cnt" id="hdnrow_cnt" value="<?php echo $row_cnt;?>" />
                                        <input type="hidden" name="hdnrow_totalRow" id="hdnrow_totalRow" value="<?php echo $row_totalRow;?>" />
                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
                                        <tbody>
                                        	<tr>
												<td colspan="3" align="left" class="err_msg"><?php echo $err_msg;?></td>
											</tr>
                                            <tr>
                                                <td width="30%"  valign="top"><strong>Question</strong></td>
                                                <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                                <td width="65%" align="left" valign="top">
                                                    <textarea name="situation" id="situation"  class="form-control" cols="25" ><?php echo $situation;?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td ><strong>Font Family - Question</strong></td>
                                                <td align="center"><strong>:</strong></td>
                                                <td align="left">
                                                    <select name="situation_font_family" id="situation_font_family"  class="form-control" >
                                                        <option value="">Select Font Family</option>
                                                        <?php echo getFontFamilyOptions($situation_font_family); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td ><strong>Font Size - Question</strong></td>
                                                <td align="center"><strong>:</strong></td>
                                                <td align="left">
                                                    <select name="situation_font_size" id="situation_font_size"  class="form-control" >
                                                        <option value="">Select Font Size</option>
                                                        <?php echo getFontSizeOptions($situation_font_size); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td ><strong>Font Color - Question</strong></td>
                                                <td align="center"><strong>:</strong></td>
                                                <td align="left"> 
                                                    <input type="text" class="color form-control"  id="situation_font_color" name="situation_font_color" value="<?php echo $situation_font_color; ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td ><strong>Date Selection Type</strong></td>
                                                <td align="center"><strong>:</strong></td>
                                                <td align="left">
                                                    <select name="listing_date_type" id="listing_date_type" onchange="toggleDateSelectionType('listing_date_type')" class="form-control" >
                                                        <option value="">Select Option</option>
                                                        <option value="days_of_month" <?php if($listing_date_type == 'days_of_month') { ?> selected="selected" <?php } ?>>Days of Month</option>
                                                        <option value="single_date" <?php if($listing_date_type == 'single_date') { ?> selected="selected" <?php } ?>>Single Date</option>
                                                        <option value="date_range" <?php if($listing_date_type == 'date_range') { ?> selected="selected" <?php } ?>>Date Range</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr id="tr_days_of_month" style="display:<?php echo $tr_days_of_month;?>">
                                                <td  valign="top"><strong>Select days of month</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left">
                                                    <select id="days_of_month" name="days_of_month[]" multiple="multiple" class="form-control" >
                                                    <?php
                                                    for($i=1;$i<=31;$i++)
                                                    { ?>
                                                        <option value="<?php echo $i;?>" <?php if (in_array($i, $arr_days_of_month)) {?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                                    <?php
                                                    } ?>	
                                                    </select>&nbsp;*<br>
                                                    You can choose more than one option by using the ctrl key.
                                                </td>
                                            </tr>
                                            <tr id="tr_single_date" style="display:<?php echo $tr_single_date;?>">
                                                <td  valign="top"><strong>Select Date</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left">
                                                    <input name="single_date" id="single_date" type="text" value="<?php echo $single_date;?>" class="form-control"   />
                                                    <script>$('#single_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                                </td>
                                            </tr>
                                            <tr id="tr_date_range" style="display:<?php echo $tr_date_range;?>">
                                                <td  valign="top"><strong>Select Date Range</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left">
   <div class="col-xs-4">                                                 <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" class="form-control" /></div> - <div class="col-xs-4"><input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" class="form-control" /></div>
                                                    <script>$('#start_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'});$('#end_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  valign="top"><strong>User</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left" valign="top">
                                                    <select multiple="multiple" name="user_id[]" id="user_id"  class="form-control" >
                                                        <option value="" <?php if (in_array('', $arr_user_id)) {?> selected="selected" <?php } ?>>All Users</option>
                                                        <?php echo getAdvisersUserOptionsMultiFront($arr_user_id,$pro_user_id); ?>
                                                    </select>&nbsp;&nbsp;<a href="javascript:void(0)" target="_self" class="body_link" onclick="viewUsersSelectionPopup()" >Select Users</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  valign="top"><strong>Keywords</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left" valign="top">
                                                    <input type="text" name="keywords" id="keywords" value="<?php echo $keywords;?>"  class="form-control" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  valign="top"><strong>Country</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left" valign="top">
                                                    <select name="country_id" id="country_id" onchange="getStateOptionsMulti();"  class="form-control" >
                                                        <option value="" >All Country</option>
                                                        <?php echo getCountryOptions($country_id); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  valign="top"><strong>State</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left" valign="top" id="tdstate">
                                                    <select multiple="multiple" name="state_id[]" id="state_id" onchange="getCityOptionsMulti();"  class="form-control" >
                                                        <option value="" <?php if (in_array('', $arr_state_id)) {?> selected="selected" <?php } ?>>All States</option>
                                                        <?php echo getStateOptionsMulti($country_id,$arr_state_id); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  valign="top"><strong>City</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left" valign="top" id="tdcity">
                                                    <select multiple="multiple" name="city_id[]" id="city_id" onchange="getPlaceOptionsMulti();"  class="form-control" >
                                                        <option value="" <?php if (in_array('', $arr_city_id)) {?> selected="selected" <?php } ?>>All Cities</option>
                                                        <?php echo getCityOptionsMulti($country_id,$arr_state_id,$arr_city_id); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  valign="top"><strong>Place</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left" valign="top" id="tdplace">
                                                    <select multiple="multiple" name="place_id[]" id="place_id"  class="form-control" >
                                                        <option value="" <?php if (in_array('', $arr_place_id)) {?> selected="selected" <?php } ?>>All Places</option>
                                                        <?php echo getPlaceOptionsMulti($country_id,$arr_state_id,$arr_city_id,$arr_place_id); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td ><strong>Order</strong></td>
                                                <td align="center"><strong>:</strong></td>
                                                <td align="left">
                                                    <select name="listing_order" id="listing_order"  class="form-control" >
                                                        <?php
                                                        for($i=1;$i<=20;$i++)
                                                        { 
                                                            if($listing_order == $i)
                                                            {
                                                                $sel = ' selected ';
                                                            }
                                                            else
                                                            {
                                                                $sel = ''; 
                                                            }
                                                        ?>
                                                        <option value="<?php echo $i;?>" <?php echo $sel;?>><?php echo $i;?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                        <?php
                                        for($i=0;$i<$row_totalRow;$i++)
                                        {  ?>
                                            <tr id="row_id_1_<?php echo $i;?>">
                                                <td ><strong>Rating</strong></td>
                                                <td align="center"><strong>:</strong></td>
                                                <td align="left">
  <div class="col-xs-2">                                                  <strong>From</strong>&nbsp;
            </div>
            <div class="col-xs-4">                                        <select  class="form-control"  name="min_rating[]" id="min_rating_<?php echo $i; ?>">
                                                    <?php
                                                    for($j=0;$j<=10;$j++)
                                                    { ?>
                                                        <option value="<?php echo $j;?>" <?php if ($arr_min_rating[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                                    <?php
                                                    } ?>	
                                                    </select>
    </div>
    <div class="col-xs-2">                                                &nbsp;&nbsp;<strong>To</strong>&nbsp;
         </div>
         <div class="col-xs-4">                                           <select  class="form-control"  name="max_rating[]" id="max_rating_<?php echo $i; ?>">
                                                    <?php
                                                    for($j=0;$j<=10;$j++)
                                                    { ?>
                                                        <option value="<?php echo $j;?>" <?php if ($arr_max_rating[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                                    <?php
                                                    } ?>	
                                                    </select>
                                                    
   </div>                                             </td>
                                            </tr>
                                            <tr id="row_id_4_<?php echo $i;?>">
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr id="row_id_5_<?php echo $i;?>">
                                                <td  valign="top"><strong>Interpretation</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left" valign="top">
                                                    <textarea name="interpretaion[]" id="interpretaion_<?php echo $i; ?>" class="form-control" cols="25"><?php echo $arr_interpretaion[$i]; ?></textarea>
                                                </td>
                                            </tr>
                                            <tr id="row_id_6_<?php echo $i;?>">
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr id="row_id_7_<?php echo $i;?>">
                                                <td  valign="top"><strong>Treatment</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left" valign="top">
                                                    <textarea name="treatment[]" id="treatment_<?php echo $i; ?>" class="form-control" cols="25"><?php echo $arr_treatment[$i]; ?></textarea>
                                                    &nbsp;
                                                    <?php
                                                    if($i > 0)
                                                    { ?>
                                                        <input type="button" value="Remove Item" id="tr_row_<?php echo $i; ?>" name="tr_row_<?php echo $i; ?>" onclick="removeRows('<?php echo $i;?>')" />
                                                    <?php } ?>
                                                 </td>
                                            </tr>
                                            <tr id="row_id_8_<?php echo $i;?>">
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                        <?php
                                        } ?>
                                            <tr id="add_before_this_row">
                                                <td  valign="top">&nbsp;</td>
                                                <td align="center" valign="top">&nbsp;</td>
                                                <td align="left" valign="top"><a href="javascript:void(0)" target="_self" class="body_link" id="addMoreRows">Add More Rating</a></td>
                                            </tr>	
                                            
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td align="left"><input type="Submit" name="btnSubmit" value="Submit" class="btn btn-primary" /></td>
                                            </tr>
                                        </tbody>
                                        </table>
									</form>	
								</td>
							</tr>
						</table>
</div>
 <div class="col-md-2">	  <?php include_once('left_sidebar.php'); ?></div>
  </div>
  <div class="col-md-2">  <?php include_once('right_sidebar.php'); ?></div>
  	</div>
 </div>
 </div>
<!--container-->                   <!--  Footer-->
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
            <!--default footer end here-->

        
        <!--scripts and plugins -->
        <!--must need plugin jquery-->
       <!-- <script src="../csswell/js/jquery.min.js"></script>   -->     
        <!--bootstrap js plugin-->
          <!--  <script src="../csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  -->         
       
    </body>

</html>