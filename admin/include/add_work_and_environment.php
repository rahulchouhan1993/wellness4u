<?php
require_once('config/class.mysql.php');
require_once('classes/class.workandenvironment.php');
require_once('classes/class.places.php');

$obj = new Work_And_Environment();
$obj2 = new Places();

$add_action_id = '27';

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$add_action_id))
{	
	header("Location: index.php?mode=invalid");
	exit(0);
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
	
	$practitioner_id = trim($_POST['practitioner_id']);
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
		
		if($obj->addQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$str_state_id,$str_city_id,$str_user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$country_id,$str_place_id))
		{
			$msg = "Question Added Successfully!";
			header('location: index.php?mode=work_and_environment&msg='.urlencode($msg));
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
	$practitioner_id = '';
	$keywords = '';
	$listing_order = '1';
	$arr_min_rating[0] = '0';
	$arr_max_rating[0] = '0';
	$arr_interpretaion[0] = '';
	$arr_treatment[0] = '';
}	
?>
<script type="text/javascript" src="js/jscolor.js"></script>
<script type="text/javascript"> 
	$(document).ready(function() {
		$('#addMoreRows').click(function() {
		
			var row_cnt = parseInt($('#hdnrow_cnt').val());
			var row_totalRow = parseInt($('#hdnrow_totalRow').val());
			
			$('#tblrow tr:#add_before_this_row').before('<tr id="row_id_1_'+row_cnt+'"><td align="right"><strong>Rating</strong></td><td align="center"><strong>:</strong></td><td align="left"><strong>From</strong>&nbsp;<select name="min_rating[]" id="min_rating_'+row_cnt+'"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select>&nbsp;&nbsp;<strong>To</strong>&nbsp;<select name="max_rating[]" id="max_rating_'+row_cnt+'"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></td></tr><tr id="row_id_2_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr id="row_id_3_'+row_cnt+'"><td align="right" valign="top"><strong>Interpretation</strong></td><td align="center" valign="top"><strong>:</strong></td><td align="left" valign="top"><textarea name="interpretaion[]" id="interpretaion_'+row_cnt+'" rows="5" cols="25"></textarea></td></tr><tr id="row_id_4_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr id="row_id_5_'+row_cnt+'"><td align="right" valign="top"><strong>Treatment</strong></td><td align="center" valign="top"><strong>:</strong></td><td align="left" valign="top"><textarea name="treatment[]" id="treatment_'+row_cnt+'" rows="5" cols="25"></textarea>&nbsp;<input type="button" value="Remove Item" id="tr_row_'+row_cnt+'" name="tr_row_'+row_cnt+'" onclick="removeRows('+row_cnt+')" /></td></tr><tr id="row_id_6_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr>');	
				
			row_cnt = row_cnt + 1;       
			$('#hdnrow_cnt').val(row_cnt);
			var row_cnt = $('#hdnrow_cnt').val();
			row_totalRow = row_totalRow + 1;       
			$('#hdnrow_totalRow').val(row_totalRow);
						
		});
	});
</script>
<div id="central_part_contents">
	<div id="notification_contents">
	<?php
	if($error)
	{
	?>
		<table class="notification-border-e" id="notification" align="center" border="0" width="97%" cellpadding="1" cellspacing="1">
		<tbody>
			<tr>
				<td class="notification-body-e">
					<table border="0" width="100%" cellpadding="0" cellspacing="6">
					<tbody>
						<tr>
							<td><img src="images/notification_icon_e.gif" alt="" border="0" width="12" height="10"></td>
							<td width="100%">
								<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td class="notification-title-E">Error</td>
									</tr>
								</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td class="notification-body-e"><?php echo $err_msg; ?></td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>
		</tbody>
		</table>
	<?php
	}
	?>
<!--notification_contents-->
	</div>	
	<table border="0" width="97%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Work &amp; Environment Question</td>
						<td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">
				<tbody>
					<tr>
						<td class="mainbox-body">
							<form action="#" method="post" name="frmadd_sleep" id="frmadd_sleep" enctype="multipart/form-data" >
                            <input type="hidden" name="hdnrow_cnt" id="hdnrow_cnt" value="<?php echo $row_cnt;?>" />
							<input type="hidden" name="hdnrow_totalRow" id="hdnrow_totalRow" value="<?php echo $row_totalRow;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
							<tbody>
                            	<tr>
									<td width="30%" align="right" valign="top"><strong>Question</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="65%" align="left" valign="top">
										<textarea name="situation" id="situation" rows="5" cols="25" ><?php echo $situation;?></textarea>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Font Family - Question</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="situation_font_family" id="situation_font_family" style="width:200px;">
											<option value="">Select Font Family</option>
		                                   	<?php echo $obj->getFontFamilyOptions($situation_font_family); ?>
                                        </select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Font Size - Question</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="situation_font_size" id="situation_font_size" style="width:200px;">
											<option value="">Select Font Size</option>
		                                   	<?php echo $obj->getFontSizeOptions($situation_font_size); ?>
                                        </select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Font Color - Question</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <input type="text" class="color"  id="situation_font_color" name="situation_font_color" value="<?php echo $situation_font_color; ?>"/>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Date Selection Type</strong></td>
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
									<td align="right" valign="top"><strong>Select days of month</strong></td>
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
									<td align="right" valign="top"><strong>Select Date</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                    	<input name="single_date" id="single_date" type="text" value="<?php echo $single_date;?>" style="width:200px;"  />
                                        <script>$('#single_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                    </td>
								</tr>
                                <tr id="tr_date_range" style="display:<?php echo $tr_date_range;?>">
									<td align="right" valign="top"><strong>Select Date Range</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                    	<input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:200px;"  /> - <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:200px;"  />
                                        <script>$('#start_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'});$('#end_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Practitioner</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                        <select name="practitioner_id" id="practitioner_id" onchange="getAdvisersUserOptionsMulti();" style="width:200px;">
											<option value="">All Practitioner</option>
                                            <?php echo $obj2->getProUsersOptions($practitioner_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>User</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                        <div id="tduser">	
                                            <select multiple="multiple" name="user_id[]" id="user_id" style="width:200px;">
                                                <option value="" <?php if (in_array('', $arr_user_id)) {?> selected="selected" <?php } ?>>All Users</option>
                                                <?php echo $obj2->getAdvisersUserOptionsMulti($arr_user_id,$practitioner_id); ?>
                                            </select>
                                        </div>&nbsp;&nbsp;<a href="javascript:void(0)" target="_self" class="body_link" onclick="viewUsersSelectionPopup()" >Select Users</a>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Keywords</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                        <input type="text" name="keywords" id="keywords" value="<?php echo $keywords;?>">
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Country</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                        <select name="country_id" id="country_id" onchange="getStateOptionsMulti();" style="width:200px;">
											<option value="" >All Country</option>
											<?php echo $obj2->getCountryOptions($country_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>State</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top" id="tdstate">
                                        <select multiple="multiple" name="state_id[]" id="state_id" onchange="getCityOptionsMulti();" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_state_id)) {?> selected="selected" <?php } ?>>All States</option>
											<?php echo $obj2->getStateOptionsMulti($country_id,$arr_state_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>City</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top" id="tdcity">
                                        <select multiple="multiple" name="city_id[]" id="city_id" onchange="getPlaceOptionsMulti();" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_city_id)) {?> selected="selected" <?php } ?>>All Cities</option>
											<?php echo $obj2->getCityOptionsMulti($country_id,$arr_state_id,$arr_city_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Place</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top" id="tdplace">
                                        <select multiple="multiple" name="place_id[]" id="place_id" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_place_id)) {?> selected="selected" <?php } ?>>All Places</option>
											<?php echo $obj2->getPlaceOptionsMulti($country_id,$arr_state_id,$arr_city_id,$arr_place_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Order</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="listing_order" id="listing_order" style="width:200px;">
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
									<td align="right"><strong>Rating</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<strong>From</strong>&nbsp;
										<select name="min_rating[]" id="min_rating_<?php echo $i; ?>">
										<?php
										for($j=0;$j<=10;$j++)
										{ ?>
											<option value="<?php echo $j;?>" <?php if ($arr_min_rating[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
										<?php
										} ?>	
                                        </select>
                                        &nbsp;&nbsp;<strong>To</strong>&nbsp;
                                        <select name="max_rating[]" id="max_rating_<?php echo $i; ?>">
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
									<td align="right" valign="top"><strong>Interpretation</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
										<textarea name="interpretaion[]" id="interpretaion_<?php echo $i; ?>" rows="5" cols="25"><?php echo $arr_interpretaion[$i]; ?></textarea>
									</td>
								</tr>
								<tr id="row_id_6_<?php echo $i;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr id="row_id_7_<?php echo $i;?>">
									<td align="right" valign="top"><strong>Treatment</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
										<textarea name="treatment[]" id="treatment_<?php echo $i; ?>" rows="5" cols="25"><?php echo $arr_treatment[$i]; ?></textarea>
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
                                    <td align="right" valign="top">&nbsp;</td>
                            	    <td align="center" valign="top">&nbsp;</td>
                                    <td align="left" valign="top"><a href="javascript:void(0)" target="_self" class="body_link" id="addMoreRows">Add More Rating</a></td>
                                </tr>	
                                
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td align="left"><input type="Submit" name="btnSubmit" value="Submit" /></td>
								</tr>
							</tbody>
							</table>
							</form>
						</td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
	</tbody>
	</table>
	<br>
</div>