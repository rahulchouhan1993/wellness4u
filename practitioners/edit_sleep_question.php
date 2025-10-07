<?php
require_once('../config.php');
$page_id = '76';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('practitioners/sleep_questions.php');

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

if(!chkAdviserPlanFeaturePermission($pro_user_id,'23'))
{
	header('location: sleep_questions.php');
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
	$sleep_id = $_POST['hdnsleep_id'];
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
	
	$status = strip_tags(trim($_POST['status']));
	
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
		
		if(updateSleepQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$str_state_id,$str_city_id,$str_place_id,$str_user_id,$pro_user_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$status,$sleep_id))
		{
			$msg = "Question Updated Successfully!";
			header('location: sleep_questions.php?msg='.urlencode($msg));
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
	$sleep_id = $_GET['id'];
	list($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$state_id,$city_id,$place_id,$user_id,$practitioner_id,$keywords,$listing_order,$status,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment) = getSleepQuestionDetails($sleep_id,$pro_user_id);
	
	if($situation == '')
	{
		header('location: sleep_questions.php');	
	}
	
	$row_cnt = count($arr_min_rating);
	$row_totalRow = count($arr_min_rating);
	
	if(count($arr_min_rating) > 0)
	{
		$row_cnt = count($arr_min_rating);
		$row_totalRow = count($arr_min_rating);
	}
	else
	{
		$row_cnt = 1;
		$row_totalRow = 1;
	}
	
	if($situation_font_color == '')
	{
		$situation_font_color = '000000';
	}	
	
	if($listing_date_type == 'days_of_month')
	{
		$tr_days_of_month = '';
		$tr_single_date = 'none';
		$tr_date_range = 'none';
		
		$single_date = '';
		$start_date = '';
		$end_date = '';
		
		$pos = strpos($days_of_month, ',');
		if ($pos !== false) 
		{
			$arr_days_of_month = explode(',',$days_of_month);
		}
		else
		{
			array_push($arr_days_of_month , $days_of_month);
		}
	}
	elseif($listing_date_type == 'single_date')
	{
		$tr_days_of_month = 'none';
		$tr_single_date = '';
		$tr_date_range = 'none';
		
		$days_of_month = '';
		$start_date = '';
		$end_date = '';
		
		$single_date = date('d-m-Y',strtotime($single_date));
	}
	elseif($listing_date_type == 'date_range')
	{
		$tr_days_of_month = 'none';
		$tr_single_date = 'none';
		$tr_date_range = '';
		
		$days_of_month = '';
		$single_date = '';
		
		$start_date = date('d-m-Y',strtotime($start_date));
		$end_date = date('d-m-Y',strtotime($end_date));
	}
	
	if($state_id == '')
	{
		$arr_state_id[0] = '';
	}
	else
	{
		$pos1 = strpos($state_id, ',');
		if ($pos1 !== false) 
		{
			$arr_state_id = explode(',',$state_id);
		}
		else
		{
			array_push($arr_state_id , $state_id);
		}
	}
	
	if($city_id == '')
	{
		$arr_city_id[0] = '';
	}
	else
	{
		$pos2 = strpos($city_id, ',');
		if ($pos2 !== false) 
		{
			$arr_city_id = explode(',',$city_id);
		}
		else
		{
			array_push($arr_city_id , $city_id);
		}
	}
	
	if($place_id == '')
	{
		$arr_place_id[0] = '';
	}
	else
	{
		$pos3 = strpos($place_id, ',');
		if ($pos3 !== false) 
		{
			$arr_place_id = explode(',',$place_id);
		}
		else
		{
			array_push($arr_place_id , $place_id);
		}
	}
	
	if($user_id == '')
	{
		$arr_user_id[0] = '';
	}
	else
	{
		$pos3 = strpos($user_id, ',');
		if ($pos3 !== false) 
		{
			$arr_user_id = explode(',',$user_id);
		}
		else
		{
			array_push($arr_user_id , $user_id);
		}
	}
}	
?><!DOCTYPE html>
<html lang="en">
<head>
<?php include_once('head.php'); ?>
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
                                    	<input type="hidden" name="hdnsleep_id" id="hdnsleep_id" value="<?php echo $sleep_id;?>" />
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
                                                    <textarea class="form-control" name="situation" id="situation" rows="5" cols="25" ><?php echo $situation;?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  valign="top"><strong>Status</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left" valign="top"><select class="form-control" style="width:200px;" id="status" name="status">
                                                                                <option value="1" <?php if($status == '1'){ ?> selected <?php } ?>>Active</option>
                                                                                <option value="0" <?php if($status == '0'){ ?> selected <?php } ?>>Inactive</option>
                                                                                </select></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td ><strong>Font Family - Question</strong></td>
                                                <td align="center"><strong>:</strong></td>
                                                <td align="left">
                                                    <select name="situation_font_family" id="situation_font_family" class="form-control" style="width:200px;">
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
                                                    <select name="situation_font_size" id="situation_font_size" class="form-control" style="width:200px;">
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
                                                    <input type="text" class="form-control color" style="width:200px;" id="situation_font_color" name="situation_font_color" value="<?php echo $situation_font_color; ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td ><strong>Date Selection Type</strong></td>
                                                <td align="center"><strong>:</strong></td>
                                                <td align="left">
                                                    <select name="listing_date_type" id="listing_date_type" onchange="toggleDateSelectionType('listing_date_type')" style="width:200px;">
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
                                                    <select id="days_of_month" name="days_of_month[]" multiple="multiple" style="width:200px;">
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
                                                    <input name="single_date" id="single_date" type="text" value="<?php echo $single_date;?>" class="form-control" style="width:200px;"  />
                                                    <script>$('#single_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                                </td>
                                            </tr>
                                            <tr id="tr_date_range" style="display:<?php echo $tr_date_range;?>">
                                                <td  valign="top"><strong>Select Date Range</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left">
                                                    <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>"  class="form-control"  style="width:200px; display:inline;"  /> - <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" class="form-control"  style="width:200px; display:inline;"   />
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
                                                    <select  class="form-control"  style="width:200px; display:inline;"  multiple="multiple" name="user_id[]" id="user_id">
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
                                                    <input  class="form-control"  style="width:200px; display:inline;" type="text" name="keywords" id="keywords" value="<?php echo $keywords;?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  valign="top"><strong>Country</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left" valign="top">
                                                    <select name="country_id" id="country_id" onchange="getStateOptionsMulti();"  class="form-control"  style="width:200px; display:inline;">
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
                                                    <select multiple="multiple" name="state_id[]" id="state_id" onchange="getCityOptionsMulti();"  class="form-control"  style="width:200px; display:inline;">
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
                                                    <select multiple="multiple" name="city_id[]" id="city_id" onchange="getPlaceOptionsMulti();" class="form-control"  style="width:200px; display:inline;">
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
                                                    <select multiple="multiple" name="place_id[]" id="place_id" style="width:200px;">
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
                                                    <select name="listing_order" id="listing_order"  class="form-control"  style="width:200px; display:inline;">
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
                                                    <strong>From</strong>&nbsp;
                                                    <select  class="form-control"  style="width:100px; display:inline;" name="min_rating[]" id="min_rating_<?php echo $i; ?>">
                                                    <?php
                                                    for($j=0;$j<=10;$j++)
                                                    { ?>
                                                        <option value="<?php echo $j;?>" <?php if ($arr_min_rating[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                                    <?php
                                                    } ?>	
                                                    </select>
                                                    &nbsp;&nbsp;<strong>To</strong>&nbsp;
                                                    <select class="form-control"  style="width:100px; display:inline;" name="max_rating[]" id="max_rating_<?php echo $i; ?>">
                                                    <?php
                                                    for($j=0;$j<=10;$j++)
                                                    { ?>
                                                        <option value="<?php echo $j;?>" <?php if ($arr_max_rating[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                                    <?php
                                                    } ?>	
                                                    </select>
                                                    
                                                </td>
                                            </tr>
                                            <tr id="row_id_4_<?php echo $i;?>">
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr id="row_id_5_<?php echo $i;?>">
                                                <td  valign="top"><strong>Interpretation</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left" valign="top">
                                                    <textarea class="form-control"  style="width:200px; display:inline;" name="interpretaion[]" id="interpretaion_<?php echo $i; ?>" rows="5" cols="25"><?php echo $arr_interpretaion[$i]; ?></textarea>
                                                </td>
                                            </tr>
                                            <tr id="row_id_6_<?php echo $i;?>">
                                                <td colspan="3" align="center">&nbsp;</td>
                                            </tr>
                                            <tr id="row_id_7_<?php echo $i;?>">
                                                <td  valign="top"><strong>Treatment</strong></td>
                                                <td align="center" valign="top"><strong>:</strong></td>
                                                <td align="left" valign="top">
                                                    <textarea class="form-control"  style="width:200px; display:inline;" name="treatment[]" id="treatment_<?php echo $i; ?>" rows="5" cols="25"><?php echo $arr_treatment[$i]; ?></textarea>
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
      <!--  <script src="../csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> -->      
       
    </body>

</html>