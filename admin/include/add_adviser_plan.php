<?php
require_once('config/class.mysql.php');
require_once('classes/class.subscriptions.php');  
require_once('classes/class.places.php');

$obj = new Subscriptions();
$obj2 = new Places();

$add_action_id = '181';

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

$trlocation = 'none';

$arr_state_id = array();
$arr_city_id = array();
$arr_place_id = array();

$arr_apa_id = array();
$arr_apa_name = array();
$arr_apa_value = array();
$arr_apc_id = array();
$arr_apc_value = array();
$arr_apa_readonly = array();

if(isset($_POST['btnSubmit']))
{
	$ap_name = trim($_POST['ap_name']);
	$ap_start_date = trim($_POST['ap_start_date']);
	$ap_end_date = trim($_POST['ap_end_date']);
	$apct_id = trim($_POST['apct_id']);
	$ap_months_duration = trim($_POST['ap_months_duration']);
	$ap_amount = trim($_POST['ap_amount']);
	$ap_currency = trim($_POST['ap_currency']);
	$ap_default = trim($_POST['ap_default']);
	$ap_criteria_from = trim($_POST['ap_criteria_from']);
	$ap_criteria_to = trim($_POST['ap_criteria_to']);
	$country_id = trim($_POST['country_id']);
	$ap_show = trim($_POST['ap_show']);
	
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
	
	foreach ($_POST['hdnapa_id'] as $key => $value) 
	{
		array_push($arr_apa_id,$value);
	}
	
	foreach ($_POST['hdnapa_name'] as $key => $value) 
	{
		array_push($arr_apa_name,$value);
	}
	
	foreach ($_POST['hdnapa_readonly'] as $key => $value) 
	{
		array_push($arr_apa_readonly,$value);
	}
	
	for($i=0;$i<count($arr_apa_id);$i++)
	{
		if(isset($_POST['apa_value_'.$i]))
		{
			array_push($arr_apa_value , $_POST['apa_value_'.$i]);
		}
		else
		{
			array_push($arr_apa_value , '');
		}	
		
		if(isset($_POST['apc_id_'.$i]))
		{
			array_push($arr_apc_id , $_POST['apc_id_'.$i]);
		}
		else
		{
			array_push($arr_apc_id , '');
		}	
		
		if(isset($_POST['apc_value_'.$i]))
		{
			array_push($arr_apc_value , $_POST['apc_value_'.$i]);
		}
		else
		{
			array_push($arr_apc_value , '');
		}	
	}
	
	if($apct_id == '1')
	{
		$trlocation = '';
	}
	
	
	if($ap_name == "")
	{
		$error = true;
		$err_msg = "Please enter plan name.";
	}
	
	if($ap_start_date == '')
	{
		$error = true;
		$err_msg .= '<br>Please select plan start date';
	}
	elseif($ap_end_date == '')
	{
		$error = true;
		$err_msg .= '<br>Please select plan end date';
	}
	else
	{
		if(strtotime($ap_start_date) > strtotime($ap_end_date))
		{
			$error = true;
			$err_msg .= '<br>Please select end date greater than start date';
		}
	}	
	
	if($ap_months_duration == "" || $ap_months_duration == "0")
	{
		$error = true;
		$err_msg .= "<br>Please select plan duration.";
	}
	
	if($ap_amount == "")
	{
		$error = true;
		$err_msg .= "<br>Please enter amount.";
	}
	elseif(!is_numeric($ap_amount))
	{
		$error = true;
		$err_msg .= "<br>Please enter valid amount.";
	}
	
	if($ap_currency == "")
	{
		$error = true;
		$err_msg .= "<br>Please select currency.";
	}
	
	if(!$error)
	{
		$temp_def_pid = $obj->getAdviserDefaultPlanId();
		if($temp_def_pid == '0' )
		{
			if($ap_default != '1')
			{
				$error = true;
				$err_msg .= "<br>Currently there is no default plan. So please select this plan as default plan.";
			}		
		}
	}
	
	if(!$error)
	{
		if($ap_start_date != '')
		{
			$ap_start_date = date('Y-m-d',strtotime($ap_start_date));
		}
				
		if($ap_end_date != '')
		{
			$ap_end_date = date('Y-m-d',strtotime($ap_end_date));
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
	
		if($obj->addAdviserPlan($ap_name,$ap_months_duration,$ap_amount,$ap_currency,$ap_default,$arr_apa_id,$arr_apa_value,$arr_apc_id,$arr_apc_value,$ap_start_date,$ap_end_date,$apct_id,$country_id,$str_state_id,$str_city_id,$str_place_id,$ap_criteria_from,$ap_criteria_to,$ap_show))
		{
			$msg = "Record Added Successfully!";
			header('location: index.php?mode=adviser_plans&msg='.urlencode($msg));
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
	$ap_name = '';
	$ap_start_date = '';
	$ap_end_date = '';
	$apct_id = '';
	$ap_months_duration = '';
	$ap_amount = '';
	$ap_currency = '';
	$ap_default = '';
	$ap_criteria_from = 'All';
	$ap_criteria_to = 'All';
	$ap_show = '1';
	$country_id = '';
	$arr_state_id[0] = '';
	$arr_city_id[0] = '';
	$arr_place_id[0] = '';
	
	list($arr_apa_id,$arr_apa_name,$arr_apa_value,$arr_apa_readonly,$arr_apc_id,$arr_apc_value) = $obj->getAdviserPlanAttributesNames();
}
?>
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
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Adviser Plan</td>
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
							<form action="#" method="post" name="frmedit_banner" id="frmedit_banner" enctype="multipart/form-data" >
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblbanner">
							<tbody>
								<tr>
									<td width="30%" align="right"><strong>Plan Name</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="65%" align="left">
                                    	<input type="text" name="ap_name" id="ap_name" value="<?php echo $ap_name;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                
                                <tr>
									<td align="right" valign="top"><strong>Plan Start Date</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                    	<input name="ap_start_date" id="ap_start_date" type="text" value="<?php echo $ap_start_date;?>" style="width:200px;"  />
										<script>$('#ap_start_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'});</script>
                                    </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Plan End Date</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                    	<input name="ap_end_date" id="ap_end_date" type="text" value="<?php echo $ap_end_date;?>" style="width:200px;"  />
										<script>$('#ap_end_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'});</script>
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Category Type</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="apct_id" id="apct_id" style="width:200px;" onchange="toggleTrLocations();">
											<option value="">All</option>
                                            <?php echo $obj->getAdviserPlansCategoryTypeOptions($apct_id); ?>
                                        </select>
                                   	</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td align="right" valign="top"><strong>Country</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                        <select name="country_id" id="country_id" onchange="getStateOptionsMulti();" style="width:200px;">
											<option value="" >All Country</option>
											<?php echo $obj2->getCountryOptions($country_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td align="right" valign="top"><strong>State</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top" id="tdstate">
                                        <select multiple="multiple" name="state_id[]" id="state_id" onchange="getCityOptionsMulti();" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_state_id)) {?> selected="selected" <?php } ?>>All States</option>
											<?php echo $obj2->getStateOptionsMulti($country_id,$arr_state_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td align="right" valign="top"><strong>City</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top" id="tdcity">
                                        <select multiple="multiple" name="city_id[]" id="city_id" onchange="getPlaceOptionsMulti();" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_city_id)) {?> selected="selected" <?php } ?>>All Cities</option>
											<?php echo $obj2->getCityOptionsMulti($country_id,$arr_state_id,$arr_city_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td align="right" valign="top"><strong>Place</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top" id="tdplace">
                                        <select multiple="multiple" name="place_id[]" id="place_id" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_place_id)) {?> selected="selected" <?php } ?>>All Places</option>
											<?php echo $obj2->getPlaceOptionsMulti($country_id,$arr_state_id,$arr_city_id,$arr_place_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Category Criteria From</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                    	<input name="ap_criteria_from" id="ap_criteria_from" type="text" value="<?php echo $ap_criteria_from;?>" style="width:200px;"  />
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Category Criteria To</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                    	<input name="ap_criteria_to" id="ap_criteria_to" type="text" value="<?php echo $ap_criteria_to;?>" style="width:200px;"  />
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Duration</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="ap_months_duration" id="ap_months_duration" style="width:200px;">
											<?php
											for($i=1;$i<=60;$i++)
											{ 
												if($ap_months_duration == $i)
												{
													$sel = ' selected ';
												}
												else
												{
													$sel = ''; 
												}
											?>
                                            <option value="<?php echo $i;?>" <?php echo $sel;?>><?php echo $i;?> Months</option>
                                            <?php
											} ?>
                                        </select>
                                   	</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Amount</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<input type="text" name="ap_amount" id="ap_amount" value="<?php echo $ap_amount;?>" style="width:200px;" >
		                           	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Currency</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="ap_currency" id="ap_currency" style="width:200px;">
											<option value="">Select Currency</option>
                                            <?php echo $obj->getCurrencyOptions($ap_currency); ?>
                                        </select>
                                   	</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                
								<tr>
									<td align="right"><strong>Default Plan</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input type="checkbox" name="ap_default" id="ap_default" value="1" <?php if($ap_default == '1'){?> checked="checked" <?php }?> onclick="confirmAdviserDefaultPlan('')"   ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Show In List</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select id="ap_show" name="ap_show">
                                            <option value="1" <?php if($ap_show == '1'){ ?> selected <?php } ?>>Yes</option>
                                            <option value="0" <?php if($ap_show == '0'){ ?> selected <?php } ?>>No</option>
                                        </select>
                                    </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"></td>
									<td align="center"></td>
									<td align="left"><strong>Plan Features</strong></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <?php
								for($i=0;$i<count($arr_apa_id);$i++)
								{ 	
								?>
                                <tr>
									<td align="right"><strong><?php echo $arr_apa_name[$i];?></strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<input type="hidden" name="hdnapa_id[]" id="hdnapa_id_<?php echo $i;?>" value="<?php echo $arr_apa_id[$i]?>"  />
                                        <input type="hidden" name="hdnapa_name[]" id="hdnapa_name_<?php echo $i;?>" value="<?php echo $arr_apa_name[$i]?>"  />
                                        <input type="hidden" name="hdnapa_readonly[]" id="hdnapa_readonly_<?php echo $i;?>" value="<?php echo $arr_apa_readonly[$i]?>"  />
                                    	<table align="left" border="0" width="100%" cellpadding="0" cellspacing="0">
                                        	<tr>
                                            	<td width="10%" align="left"><input class="chkbxapaid" type="checkbox" name="apa_value_<?php echo $i;?>" id="apa_value_<?php echo $i;?>" value="1" <?php if($arr_apa_value[$i] == '1'){?> checked="checked" <?php }?>  <?php if($arr_apa_readonly[$i] == 'readonly' && $ap_default == ''){?> onclick="return false" <?php }?>  ></td>
                                                <td width="40%" align="left">
                                                	<?php if($arr_apa_readonly[$i] == 'readonly' && $ap_default == ''){?>
                                                    <select class="selapaid" name="apc_id_<?php echo $i;?>" id="apc_id_<?php echo $i;?>" style="width:200px;" disabled="disabled"   >
                                                        <option value="">Select Criteria</option>
                                                        <?php echo $obj->getAdviserCriteriaOptions($arr_apc_id[$i]); ?>
                                                    </select>
                                                    <input type="hidden" name="apc_id_<?php echo $i;?>" id="apc_id_<?php echo $i;?>" value="<?php echo $arr_apc_id[$i]?>"  />
                                                    <?php } else {?>
                                                    
                                                    <select name="apc_id_<?php echo $i;?>" id="apc_id_<?php echo $i;?>" style="width:200px;" >
                                                        <option value="">Select Criteria</option>
                                                        <?php echo $obj->getAdviserCriteriaOptions($arr_apc_id[$i]); ?>
                                                    </select>
                                                     <?php } ?>
                                                </td>
                                                <td width="50%" align="left"><input type="text" name="apc_value_<?php echo $i;?>" id="apc_value_<?php echo $i;?>" value="<?php echo $arr_apc_value[$i]; ?>" ></td>
                                            </tr>    
                                   		</table> 
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <?php
								} ?>
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