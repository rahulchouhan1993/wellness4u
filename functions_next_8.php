<?php
function getEarlierDocumentRefOptions($banner_client_id,$old_document_ref_no)
{
    global $link;
    $option_str = '';

    $sql = "SELECT * FROM `tblbannercontracts` WHERE `banner_client_id` = '".$banner_client_id."' AND `banner_cont_deleted` = '0' ORDER BY banner_contract_no ASC";
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        while($row = mysql_fetch_array($result))
        {
            if($row['banner_contract_no'] == $old_document_ref_no)
            {
                $selected = ' selected ';
            }
            else
            {
                $selected = '';
            }
            $option_str .= '<option value="'.$row['banner_contract_no'].'" '.$selected.' >'.stripslashes($row['banner_contract_no']).'</option>';
        }	 
    }

    return $option_str;
}
function viewUserPlans($user_id,$upct_id = '')
{
	global $link;
	$output = '';
	
	$cr_up_id = getUserCurrentRequestedPlanId($user_id);
	
	$user_default_id = getUserDefaultPlanId();
	$user_default_name = getUserPlanName($user_default_id);
	
	$now = date('Y-m-d');
	
	$output .= '<div id="idviewuserplans">';
	$output .= '	<table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td align="left" valign="top">
								<strong>Category</strong>:&nbsp;<select name="upct_id" id="upct_id" style="width:200px;" onchange="viewUserPlans();">
									<option value="">All Categories</option>
									'.getUserPlansCategoryTypeOptions($upct_id).'
								</select>
							</td>
						</tr>
					</table>
					<table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td align="left" valign="top" height="30">&nbsp;</td>
						</tr>
					</table>';
	
	$arr_category = array();
	if($upct_id == '')
	{
		//$sql_cat = "SELECT DISTINCT `apct_id` FROM `tbladviserplans` WHERE `ap_status` = '1' AND `ap_deleted` = '0' AND `ap_start_date` <= '".$now."' AND `ap_end_date` >= '".$now."'  ORDER BY apct_id ASC";
		$arr_category[] = '0';
		$sql_cat = "SELECT `apct_id` FROM `tbladviserplancategorytype` WHERE `show_for_user` = '1' AND `apct_status` = '1' AND `apct_deleted` = '0' ORDER BY apct_category_type ASC";
		
		//echo '<br>'.$sql_cat;
		$result_cat = mysql_query($sql_cat,$link);
		if( ($result_cat) && (mysql_num_rows($result_cat) > 0) )
		{
			while($row_cat = mysql_fetch_array($result_cat))
			{
				$arr_category[] = $row_cat['apct_id'];
			}
		}	
	}
	else
	{
		//$sql_cat = "SELECT DISTINCT `apct_id` FROM `tbladviserplans` WHERE `apct_id` = '".$apct_id."' AND `ap_status` = '1' AND `ap_deleted` = '0' AND `ap_start_date` <= '".$now."' AND `ap_end_date` >= '".$now."'  ORDER BY apct_id ASC";
		$arr_category[] = $upct_id;
	}
	//echo'<br><pre>';
	//print_r($arr_category,1);
	//echo'<br></pre>';		
	
	for($m=0;$m<count($arr_category);$m++)
	{
		$categogry_name = getAdviserPlansCategoryName($arr_category[$m]);
		$output .= '<table cellpadding="5" cellspacing="1" width="940" align="center" border="0" bgcolor="#333333">
						<tr>
							<td align="left" valign="middle" height="30" bgcolor="#F6F6F6"><strong>Category</strong>:&nbsp;'.$categogry_name.'</td>
						</tr>
					</table>
					<table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td align="left" valign="top" height="20">&nbsp;</td>
						</tr>
					</table>';
		
		$arr_record = array();
		
		$sql = "SELECT * FROM `tbluserplans` WHERE `upct_id` = '".$arr_category[$m]."' AND `up_status` = '1' AND `up_show` = '1' AND `up_deleted` = '0' AND `up_start_date` <= '".$now."' AND `up_end_date` >= '".$now."'  ORDER BY up_default DESC , up_name ASC";
		//echo '<br>'.$sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			while($row = mysql_fetch_array($result))
			{
				if($row['up_default'] == '0')
				{
					$country_id = $row['country_id'];
					$str_state_id = $row['state_id'];
					$str_city_id = $row['city_id'];
					$str_place_id = $row['place_id'];
					if(chkUserForLocationCriteria($user_id,$country_id,$str_state_id,$str_city_id,$str_place_id))
					{
						$arr_record[] = $row;
					}
				}	
			}
		}	
			
		$total_plans = count($arr_record);
		$total_column = $total_plans + 1;
		$total_plan_column = $total_plans - 1;
			
			
		$output .= '<table cellpadding="5" cellspacing="1" width="940" align="center" border="0" bgcolor="#333333">';
		
		$output .= '	<tr>
							<td width="200" bgcolor="#F6F6F6" height="30" align="left" valign="middle"><strong>Plan Name</strong></td>
							<td bgcolor="#EBEBEB" height="30" align="center" valign="middle"><strong>'.$user_default_name.'</strong></td>';
						if($total_plans > 0)
						{	
							for($i=0;$i<$total_plans;$i++)
							{
		$output .= '		<td bgcolor="#FFFFFF" height="30" align="center" valign="middle">'.stripslashes($arr_record[$i]['up_name']).'</td>';
							}
						}	
		$output .= '	</tr>';
			
		$output .= '	<tr>
							<td bgcolor="#F6F6F6" height="30" align="left" valign="middle"><strong>Duration</strong></td>
							<td bgcolor="#EBEBEB" height="30" align="center" valign="middle"><strong>Unlimited</strong></td>';
						if($total_plans > 0)
						{	
							for($i=0;$i<$total_plans;$i++)
							{
		$output .= '		<td bgcolor="#FFFFFF" height="30" align="center" valign="middle">'.stripslashes($arr_record[$i]['up_months_duration']).'Mon</td>';
							}
						}	
		$output .= '	</tr>';
		
		$output .= '	<tr>
							<td bgcolor="#F6F6F6" height="30" align="left" valign="middle"><strong>Amount</strong></td>
							<td bgcolor="#EBEBEB" height="30" align="center" valign="middle"><strong>Free</strong></td>';
						if($total_plans > 0)
						{	
							for($i=0;$i<$total_plans;$i++)
							{
		$output .= '		<td bgcolor="#FFFFFF" height="30" align="center" valign="middle">'.stripslashes($arr_record[$i]['up_amount']).' '.stripslashes($arr_record[$i]['up_currency']).'</td>';
							}
						}	
		$output .= '	</tr>';
						
		$sql2 = "SELECT * FROM `tbladviserplanatributes` WHERE apa_status = '1' AND `show_for_user` = '1' ORDER BY apa_name ASC ";
		$result2 = mysql_query($sql2,$link);
		if( ($result2) && (mysql_num_rows($result2) > 0) )
		{
			$arr_record2 = array();
			while($row2 = mysql_fetch_array($result2))
			{
				if(chkIfUserPlanAtributeNeedToShow($row2['apa_id']))
				{
					$arr_record2[] = $row2;
				}
			}
			
				
			for($i=0;$i<count($arr_record2);$i++)
			{
			$output .= '<tr>
							<td bgcolor="#F6F6F6" height="30" align="left" valign="middle"><strong>'.stripslashes($arr_record2[$i]['apa_name']).'</strong></td>';
						
				$sql3 = "SELECT tupd.* , tapc.apc_criteria FROM `tbluserplandetails` AS tupd LEFT JOIN `tbladviserplancriteria` AS tapc ON tupd.upc_id = tapc.apc_id WHERE tupd.up_id = '".$user_default_id."' AND tupd.upa_id = '".$arr_record2[$i]['apa_id']."' AND tupd.upd_status = '1' AND tupd.upd_deleted = '0'";
				$result3 = mysql_query($sql3,$link);
				if( ($result3) && (mysql_num_rows($result3) > 0) )
				{
					$row3 = mysql_fetch_array($result3);
					if($row3['upa_value'] == '1')
					{
						$upa_value = 'Yes';
						
						if($row3['upc_id'] != '0')
						{
							$upc_value = '<br>'.$row3['apc_criteria'].': '.$row3['upc_value'].'';
						}
						else
						{
							$upc_value = '';
						}	
					}
					else
					{
						$upa_value = 'No';
						$upc_value = '';
					}
				}	
				else
				{
					$upa_value = 'No';
					$upc_value = '';
				}
			$output .= '	<td bgcolor="#EBEBEB" height="30" align="center" valign="middle"><strong>'.$upa_value.' '.$upc_value.'</strong></td>';	
					
					
				if($total_plans > 0)
				{	
					for($k=0;$k<count($arr_record);$k++)
					{
						$sql3 = "SELECT tupd.* , tapc.apc_criteria FROM `tbluserplandetails` AS tupd LEFT JOIN `tbladviserplancriteria` AS tapc ON tupd.upc_id = tapc.apc_id WHERE tupd.up_id = '".$arr_record[$k]['up_id']."' AND tupd.upa_id = '".$arr_record2[$i]['apa_id']."' AND tupd.upd_status = '1' AND tupd.upd_deleted = '0'";
						$result3 = mysql_query($sql3,$link);
						if( ($result3) && (mysql_num_rows($result3) > 0) )
						{
							$row3 = mysql_fetch_array($result3);
							if($row3['upa_value'] == '1')
							{
								$upa_value = 'Yes';
								
								if($row3['upc_id'] != '0')
								{
									$upc_value = '<br>'.$row3['apc_criteria'].': '.$row3['upc_value'].'';
								}
								else
								{
									$upc_value = '';
								}	
							}
							else
							{
								$upa_value = 'No';
								$upc_value = '';
							}
						}
						else
						{	
							$upa_value = 'No';
							$upc_value = '';
						}	
				$output .= '	<td bgcolor="#FFFFFF" height="30" align="center" valign="middle">'.$upa_value.' '.$upc_value.'</td>';	
					}
				}		
			$output .= '</tr>';	
			}
		}
			
		if($cr_up_id == '0' || chkIfUserPlanIsExpired($user_id))
		{
			$btn_action = '<input type="button" name="btnSendUserPlanRequest" id="btnSendUserPlanRequest" value="Select" onclick="sendUserPlanRequest()">';
		}
		else
		{
			$btn_action = '';
		}
			
		$output .= '	<tr>
							<td bgcolor="#F6F6F6" height="30" align="center" valign="middle">'.$btn_action.'</td>
							<td bgcolor="#EBEBEB" height="30" align="center" valign="middle">&nbsp;</td>';
		if($total_plans > 0)
		{	
			for($i=0;$i<$total_plans;$i++)
			{
				if($cr_up_id == $arr_record[$i]['up_id'])
				{
					$up_id_checked = ' checked="checked" ';
				}
				else
				{
					$up_id_checked = '';
				}	
				$output .= '<td bgcolor="#FFFFFF" height="30" align="center" valign="top"><input type="radio" name="select_up_id" id="select_up_id_'.$i.'" value="'.$arr_record[$i]['up_id'].'" '.$up_id_checked.'>&nbsp;</td>';
			}
		}
		$output .= '	</tr>';
			
		$output .= '</table>
					<table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td align="left" valign="top" height="30">&nbsp;</td>
						</tr>
					</table>';
	}
	$output .= '</div>';	
	return $output;
}
function getSleepQuestionDetails($sleep_id,$practitioner_id)
{
	global $link;
	$arr_min_rating = array();
	$arr_max_rating = array();
	$arr_interpretaion = array();
	$arr_treatment = array();
	
	$sql = "SELECT * FROM `tblsleeps` WHERE `sleep_id` = '".$sleep_id."' AND `practitioner_id` = '".$practitioner_id."' AND `practitioner_id` > '0' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
		$situation_font_family = stripslashes($row['situation_font_family']);
		$situation_font_size = stripslashes($row['situation_font_size']);
		$situation_font_color = stripslashes($row['situation_font_color']);
		$listing_date_type = stripslashes($row['listing_date_type']);
		$days_of_month = stripslashes($row['days_of_month']);
		$single_date = stripslashes($row['single_date']);
		$start_date = stripslashes($row['start_date']);
		$end_date = stripslashes($row['end_date']);
		$country_id = stripslashes($row['country_id']);
		$state_id = stripslashes($row['state_id']);
		$city_id = stripslashes($row['city_id']);
		$place_id = stripslashes($row['place_id']);
		$user_id = stripslashes($row['user_id']);
		$practitioner_id = stripslashes($row['practitioner_id']);
		$keywords = stripslashes($row['keywords']);
		$listing_order = stripslashes($row['listing_order']);
		$status = stripslashes($row['status']);
		
		$sql2 = "SELECT * FROM `tblemotionstreatments` WHERE `situation_id` = '".$sleep_id."' AND `et_type` = 'sleep' ORDER BY `et_id`";
		$result2 = mysql_query($sql2,$link);
		if( ($result2) && (mysql_num_rows($result2) > 0) )
		{
			while($row2 = mysql_fetch_array($result2))
			{
				array_push($arr_min_rating , $row2['min_rating']);
				array_push($arr_max_rating , $row2['max_rating']);
				array_push($arr_interpretaion , stripslashes($row2['interpretaion']));
				array_push($arr_treatment , stripslashes($row2['treatment']));
			}
		}
	}
	return array($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$state_id,$city_id,$place_id,$user_id,$practitioner_id,$keywords,$listing_order,$status,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment);
}

function getAddictionQuestionDetails($adct_id,$practitioner_id)
{
	global $link;
	$arr_min_rating = array();
	$arr_max_rating = array();
	$arr_interpretaion = array();
	$arr_treatment = array();
	
	$sql = "SELECT * FROM `tbladdictions` WHERE `adct_id` = '".$adct_id."' AND `practitioner_id` = '".$practitioner_id."' AND `practitioner_id` > '0' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
		$situation_font_family = stripslashes($row['situation_font_family']);
		$situation_font_size = stripslashes($row['situation_font_size']);
		$situation_font_color = stripslashes($row['situation_font_color']);
		$listing_date_type = stripslashes($row['listing_date_type']);
		$days_of_month = stripslashes($row['days_of_month']);
		$single_date = stripslashes($row['single_date']);
		$start_date = stripslashes($row['start_date']);
		$end_date = stripslashes($row['end_date']);
		$country_id = stripslashes($row['country_id']);
		$state_id = stripslashes($row['state_id']);
		$city_id = stripslashes($row['city_id']);
		$place_id = stripslashes($row['place_id']);
		$user_id = stripslashes($row['user_id']);
		$practitioner_id = stripslashes($row['practitioner_id']);
		$keywords = stripslashes($row['keywords']);
		$listing_order = stripslashes($row['listing_order']);
		$status = stripslashes($row['status']);
		
		$sql2 = "SELECT * FROM `tblemotionstreatments` WHERE `situation_id` = '".$adct_id."' AND `et_type` = 'addiction' ORDER BY `et_id`";
		$result2 = mysql_query($sql2,$link);
		if( ($result2) && (mysql_num_rows($result2) > 0) )
		{
			while($row2 = mysql_fetch_array($result2))
			{
				array_push($arr_min_rating , $row2['min_rating']);
				array_push($arr_max_rating , $row2['max_rating']);
				array_push($arr_interpretaion , stripslashes($row2['interpretaion']));
				array_push($arr_treatment , stripslashes($row2['treatment']));
			}
		}
	}
	return array($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$state_id,$city_id,$place_id,$user_id,$practitioner_id,$keywords,$listing_order,$status,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment);
}

function getWAEQuestionDetails($wae_id,$practitioner_id)
{
	global $link;
	$arr_min_rating = array();
	$arr_max_rating = array();
	$arr_interpretaion = array();
	$arr_treatment = array();
	
	$sql = "SELECT * FROM `tblworkandenvironments` WHERE `wae_id` = '".$wae_id."' AND `practitioner_id` = '".$practitioner_id."' AND `practitioner_id` > '0' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
		$situation_font_family = stripslashes($row['situation_font_family']);
		$situation_font_size = stripslashes($row['situation_font_size']);
		$situation_font_color = stripslashes($row['situation_font_color']);
		$listing_date_type = stripslashes($row['listing_date_type']);
		$days_of_month = stripslashes($row['days_of_month']);
		$single_date = stripslashes($row['single_date']);
		$start_date = stripslashes($row['start_date']);
		$end_date = stripslashes($row['end_date']);
		$country_id = stripslashes($row['country_id']);
		$state_id = stripslashes($row['state_id']);
		$city_id = stripslashes($row['city_id']);
		$place_id = stripslashes($row['place_id']);
		$user_id = stripslashes($row['user_id']);
		$practitioner_id = stripslashes($row['practitioner_id']);
		$keywords = stripslashes($row['keywords']);
		$listing_order = stripslashes($row['listing_order']);
		$status = stripslashes($row['status']);
		
		$sql2 = "SELECT * FROM `tblemotionstreatments` WHERE `situation_id` = '".$wae_id."' AND `et_type` = 'workandenvironments' ORDER BY `et_id`";
		$result2 = mysql_query($sql2,$link);
		if( ($result2) && (mysql_num_rows($result2) > 0) )
		{
			while($row2 = mysql_fetch_array($result2))
			{
				array_push($arr_min_rating , $row2['min_rating']);
				array_push($arr_max_rating , $row2['max_rating']);
				array_push($arr_interpretaion , stripslashes($row2['interpretaion']));
				array_push($arr_treatment , stripslashes($row2['treatment']));
			}
		}
	}
	return array($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$state_id,$city_id,$place_id,$user_id,$practitioner_id,$keywords,$listing_order,$status,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment);
}

function getGSQuestionDetails($gs_id,$practitioner_id)
{
	global $link;
	$arr_min_rating = array();
	$arr_max_rating = array();
	$arr_interpretaion = array();
	$arr_treatment = array();
	
	$sql = "SELECT * FROM `tblgeneralstressors` WHERE `gs_id` = '".$gs_id."' AND `practitioner_id` = '".$practitioner_id."' AND `practitioner_id` > '0' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
		$situation_font_family = stripslashes($row['situation_font_family']);
		$situation_font_size = stripslashes($row['situation_font_size']);
		$situation_font_color = stripslashes($row['situation_font_color']);
		$listing_date_type = stripslashes($row['listing_date_type']);
		$days_of_month = stripslashes($row['days_of_month']);
		$single_date = stripslashes($row['single_date']);
		$start_date = stripslashes($row['start_date']);
		$end_date = stripslashes($row['end_date']);
		$country_id = stripslashes($row['country_id']);
		$state_id = stripslashes($row['state_id']);
		$city_id = stripslashes($row['city_id']);
		$place_id = stripslashes($row['place_id']);
		$user_id = stripslashes($row['user_id']);
		$practitioner_id = stripslashes($row['practitioner_id']);
		$keywords = stripslashes($row['keywords']);
		$listing_order = stripslashes($row['listing_order']);
		$status = stripslashes($row['status']);
		
		$sql2 = "SELECT * FROM `tblemotionstreatments` WHERE `situation_id` = '".$gs_id."' AND `et_type` = 'generalstressors' ORDER BY `et_id`";
		$result2 = mysql_query($sql2,$link);
		if( ($result2) && (mysql_num_rows($result2) > 0) )
		{
			while($row2 = mysql_fetch_array($result2))
			{
				array_push($arr_min_rating , $row2['min_rating']);
				array_push($arr_max_rating , $row2['max_rating']);
				array_push($arr_interpretaion , stripslashes($row2['interpretaion']));
				array_push($arr_treatment , stripslashes($row2['treatment']));
			}
		}
	}
	return array($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$state_id,$city_id,$place_id,$user_id,$practitioner_id,$keywords,$listing_order,$status,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment);
}

function getMCQuestionDetails($mc_id,$practitioner_id)
{
	global $link;
	$arr_min_rating = array();
	$arr_max_rating = array();
	$arr_interpretaion = array();
	$arr_treatment = array();
	
	$sql = "SELECT * FROM `tblmycommunications` WHERE `mc_id` = '".$mc_id."' AND `practitioner_id` = '".$practitioner_id."' AND `practitioner_id` > '0' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
		$situation_font_family = stripslashes($row['situation_font_family']);
		$situation_font_size = stripslashes($row['situation_font_size']);
		$situation_font_color = stripslashes($row['situation_font_color']);
		$listing_date_type = stripslashes($row['listing_date_type']);
		$days_of_month = stripslashes($row['days_of_month']);
		$single_date = stripslashes($row['single_date']);
		$start_date = stripslashes($row['start_date']);
		$end_date = stripslashes($row['end_date']);
		$country_id = stripslashes($row['country_id']);
		$state_id = stripslashes($row['state_id']);
		$city_id = stripslashes($row['city_id']);
		$place_id = stripslashes($row['place_id']);
		$user_id = stripslashes($row['user_id']);
		$practitioner_id = stripslashes($row['practitioner_id']);
		$keywords = stripslashes($row['keywords']);
		$listing_order = stripslashes($row['listing_order']);
		$status = stripslashes($row['status']);
		
		$sql2 = "SELECT * FROM `tblemotionstreatments` WHERE `situation_id` = '".$mc_id."' AND `et_type` = 'mycommunications' ORDER BY `et_id`";
		$result2 = mysql_query($sql2,$link);
		if( ($result2) && (mysql_num_rows($result2) > 0) )
		{
			while($row2 = mysql_fetch_array($result2))
			{
				array_push($arr_min_rating , $row2['min_rating']);
				array_push($arr_max_rating , $row2['max_rating']);
				array_push($arr_interpretaion , stripslashes($row2['interpretaion']));
				array_push($arr_treatment , stripslashes($row2['treatment']));
			}
		}
	}
	return array($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$state_id,$city_id,$place_id,$user_id,$practitioner_id,$keywords,$listing_order,$status,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment);
}

function getMRQuestionDetails($mr_id,$practitioner_id)
{
	global $link;
	$arr_min_rating = array();
	$arr_max_rating = array();
	$arr_interpretaion = array();
	$arr_treatment = array();
	
	$sql = "SELECT * FROM `tblmyrelations` WHERE `mr_id` = '".$mr_id."' AND `practitioner_id` = '".$practitioner_id."' AND `practitioner_id` > '0' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
		$situation_font_family = stripslashes($row['situation_font_family']);
		$situation_font_size = stripslashes($row['situation_font_size']);
		$situation_font_color = stripslashes($row['situation_font_color']);
		$listing_date_type = stripslashes($row['listing_date_type']);
		$days_of_month = stripslashes($row['days_of_month']);
		$single_date = stripslashes($row['single_date']);
		$start_date = stripslashes($row['start_date']);
		$end_date = stripslashes($row['end_date']);
		$country_id = stripslashes($row['country_id']);
		$state_id = stripslashes($row['state_id']);
		$city_id = stripslashes($row['city_id']);
		$place_id = stripslashes($row['place_id']);
		$user_id = stripslashes($row['user_id']);
		$practitioner_id = stripslashes($row['practitioner_id']);
		$keywords = stripslashes($row['keywords']);
		$listing_order = stripslashes($row['listing_order']);
		$status = stripslashes($row['status']);
		
		$sql2 = "SELECT * FROM `tblemotionstreatments` WHERE `situation_id` = '".$mr_id."' AND `et_type` = 'myrelations' ORDER BY `et_id`";
		$result2 = mysql_query($sql2,$link);
		if( ($result2) && (mysql_num_rows($result2) > 0) )
		{
			while($row2 = mysql_fetch_array($result2))
			{
				array_push($arr_min_rating , $row2['min_rating']);
				array_push($arr_max_rating , $row2['max_rating']);
				array_push($arr_interpretaion , stripslashes($row2['interpretaion']));
				array_push($arr_treatment , stripslashes($row2['treatment']));
			}
		}
	}
	return array($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$state_id,$city_id,$place_id,$user_id,$practitioner_id,$keywords,$listing_order,$status,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment);
}

function getMLEQuestionDetails($mle_id,$practitioner_id)
{
	global $link;
	$arr_min_rating = array();
	$arr_max_rating = array();
	$arr_interpretaion = array();
	$arr_treatment = array();
	
	$sql = "SELECT * FROM `tblmajorlifeevents` WHERE `mle_id` = '".$mle_id."' AND `practitioner_id` = '".$practitioner_id."' AND `practitioner_id` > '0' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
		$situation_font_family = stripslashes($row['situation_font_family']);
		$situation_font_size = stripslashes($row['situation_font_size']);
		$situation_font_color = stripslashes($row['situation_font_color']);
		$listing_date_type = stripslashes($row['listing_date_type']);
		$days_of_month = stripslashes($row['days_of_month']);
		$single_date = stripslashes($row['single_date']);
		$start_date = stripslashes($row['start_date']);
		$end_date = stripslashes($row['end_date']);
		$country_id = stripslashes($row['country_id']);
		$state_id = stripslashes($row['state_id']);
		$city_id = stripslashes($row['city_id']);
		$place_id = stripslashes($row['place_id']);
		$user_id = stripslashes($row['user_id']);
		$practitioner_id = stripslashes($row['practitioner_id']);
		$keywords = stripslashes($row['keywords']);
		$listing_order = stripslashes($row['listing_order']);
		$status = stripslashes($row['status']);
		
		$sql2 = "SELECT * FROM `tblemotionstreatments` WHERE `situation_id` = '".$mle_id."' AND `et_type` = 'majorlifeevents' ORDER BY `et_id`";
		$result2 = mysql_query($sql2,$link);
		if( ($result2) && (mysql_num_rows($result2) > 0) )
		{
			while($row2 = mysql_fetch_array($result2))
			{
				array_push($arr_min_rating , $row2['min_rating']);
				array_push($arr_max_rating , $row2['max_rating']);
				array_push($arr_interpretaion , stripslashes($row2['interpretaion']));
				array_push($arr_treatment , stripslashes($row2['treatment']));
			}
		}
	}
	return array($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$state_id,$city_id,$place_id,$user_id,$practitioner_id,$keywords,$listing_order,$status,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment);
}

function updateSleepQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$str_state_id,$str_city_id,$str_place_id,$str_user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$status,$sleep_id)
{
	global $link;
	$return = false;
			
	$sql = "UPDATE `tblsleeps` SET `situation` = '".addslashes($situation)."' , `situation_font_family` = '".addslashes($situation_font_family)."' , `situation_font_size` = '".addslashes($situation_font_size)."' , `situation_font_color` = '".addslashes($situation_font_color)."' , `listing_date_type` = '".addslashes($listing_date_type)."' , `days_of_month` = '".addslashes($days_of_month)."' , `single_date` = '".addslashes($single_date)."' , `start_date` = '".addslashes($start_date)."' , `end_date` = '".addslashes($end_date)."' , `country_id` = '".addslashes($country_id)."'  , `state_id` = '".addslashes($str_state_id)."' , `city_id` = '".addslashes($str_city_id)."'  , `place_id` = '".addslashes($str_place_id)."' , `user_id` = '".addslashes($str_user_id)."' , `keywords` = '".addslashes($keywords)."' , `listing_order` = '".addslashes($listing_order)."' , `status` = '".addslashes($status)."'  WHERE `sleep_id` = '".$sleep_id."' AND `practitioner_id` = '".$practitioner_id."' ";
	//echo '<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = $sleep_id;
		$del_sql1 = "DELETE FROM `tblemotionstreatments` WHERE `situation_id` = '".$situation_id."'  AND `et_type` = 'sleep' "; 
		$result = mysql_query($del_sql1,$link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('sleep','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function updateAddictionQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$str_state_id,$str_city_id,$str_place_id,$str_user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$status,$adct_id)
{
	global $link;
	$return = false;
			
	$sql = "UPDATE `tbladdictions` SET `situation` = '".addslashes($situation)."' , `situation_font_family` = '".addslashes($situation_font_family)."' , `situation_font_size` = '".addslashes($situation_font_size)."' , `situation_font_color` = '".addslashes($situation_font_color)."' , `listing_date_type` = '".addslashes($listing_date_type)."' , `days_of_month` = '".addslashes($days_of_month)."' , `single_date` = '".addslashes($single_date)."' , `start_date` = '".addslashes($start_date)."' , `end_date` = '".addslashes($end_date)."' , `country_id` = '".addslashes($country_id)."'  , `state_id` = '".addslashes($str_state_id)."' , `city_id` = '".addslashes($str_city_id)."'  , `place_id` = '".addslashes($str_place_id)."' , `user_id` = '".addslashes($str_user_id)."' , `keywords` = '".addslashes($keywords)."' , `listing_order` = '".addslashes($listing_order)."' , `status` = '".addslashes($status)."'  WHERE `adct_id` = '".$adct_id."' AND `practitioner_id` = '".$practitioner_id."' ";
	//echo '<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = $adct_id;
		$del_sql1 = "DELETE FROM `tblemotionstreatments` WHERE `situation_id` = '".$situation_id."'  AND `et_type` = 'addiction' "; 
		$result = mysql_query($del_sql1,$link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('addiction','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function updateWAEQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$str_state_id,$str_city_id,$str_place_id,$str_user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$status,$wae_id)
{
	global $link;
	$return = false;
			
	$sql = "UPDATE `tblworkandenvironments` SET `situation` = '".addslashes($situation)."' , `situation_font_family` = '".addslashes($situation_font_family)."' , `situation_font_size` = '".addslashes($situation_font_size)."' , `situation_font_color` = '".addslashes($situation_font_color)."' , `listing_date_type` = '".addslashes($listing_date_type)."' , `days_of_month` = '".addslashes($days_of_month)."' , `single_date` = '".addslashes($single_date)."' , `start_date` = '".addslashes($start_date)."' , `end_date` = '".addslashes($end_date)."' , `country_id` = '".addslashes($country_id)."'  , `state_id` = '".addslashes($str_state_id)."' , `city_id` = '".addslashes($str_city_id)."'  , `place_id` = '".addslashes($str_place_id)."' , `user_id` = '".addslashes($str_user_id)."' , `keywords` = '".addslashes($keywords)."' , `listing_order` = '".addslashes($listing_order)."' , `status` = '".addslashes($status)."'  WHERE `wae_id` = '".$wae_id."' AND `practitioner_id` = '".$practitioner_id."' ";
	//echo '<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = $wae_id;
		$del_sql1 = "DELETE FROM `tblemotionstreatments` WHERE `situation_id` = '".$situation_id."'  AND `et_type` = 'workandenvironments' "; 
		$result = mysql_query($del_sql1,$link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('workandenvironments','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function updateGSQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$str_state_id,$str_city_id,$str_place_id,$str_user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$status,$gs_id)
{
	global $link;
	$return = false;
			
	$sql = "UPDATE `tblgeneralstressors` SET `situation` = '".addslashes($situation)."' , `situation_font_family` = '".addslashes($situation_font_family)."' , `situation_font_size` = '".addslashes($situation_font_size)."' , `situation_font_color` = '".addslashes($situation_font_color)."' , `listing_date_type` = '".addslashes($listing_date_type)."' , `days_of_month` = '".addslashes($days_of_month)."' , `single_date` = '".addslashes($single_date)."' , `start_date` = '".addslashes($start_date)."' , `end_date` = '".addslashes($end_date)."' , `country_id` = '".addslashes($country_id)."'  , `state_id` = '".addslashes($str_state_id)."' , `city_id` = '".addslashes($str_city_id)."'  , `place_id` = '".addslashes($str_place_id)."' , `user_id` = '".addslashes($str_user_id)."' , `keywords` = '".addslashes($keywords)."' , `listing_order` = '".addslashes($listing_order)."' , `status` = '".addslashes($status)."'  WHERE `gs_id` = '".$gs_id."' AND `practitioner_id` = '".$practitioner_id."' ";
	//echo '<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = $gs_id;
		$del_sql1 = "DELETE FROM `tblemotionstreatments` WHERE `situation_id` = '".$situation_id."'  AND `et_type` = 'generalstressors' "; 
		$result = mysql_query($del_sql1,$link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('generalstressors','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function updateMCQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$str_state_id,$str_city_id,$str_place_id,$str_user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$status,$mc_id)
{
	global $link;
	$return = false;
			
	$sql = "UPDATE `tblmycommunications` SET `situation` = '".addslashes($situation)."' , `situation_font_family` = '".addslashes($situation_font_family)."' , `situation_font_size` = '".addslashes($situation_font_size)."' , `situation_font_color` = '".addslashes($situation_font_color)."' , `listing_date_type` = '".addslashes($listing_date_type)."' , `days_of_month` = '".addslashes($days_of_month)."' , `single_date` = '".addslashes($single_date)."' , `start_date` = '".addslashes($start_date)."' , `end_date` = '".addslashes($end_date)."' , `country_id` = '".addslashes($country_id)."'  , `state_id` = '".addslashes($str_state_id)."' , `city_id` = '".addslashes($str_city_id)."'  , `place_id` = '".addslashes($str_place_id)."' , `user_id` = '".addslashes($str_user_id)."' , `keywords` = '".addslashes($keywords)."' , `listing_order` = '".addslashes($listing_order)."' , `status` = '".addslashes($status)."'  WHERE `mc_id` = '".$mc_id."' AND `practitioner_id` = '".$practitioner_id."' ";
	//echo '<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = $mc_id;
		$del_sql1 = "DELETE FROM `tblemotionstreatments` WHERE `situation_id` = '".$situation_id."'  AND `et_type` = 'mycommunications' "; 
		$result = mysql_query($del_sql1,$link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('mycommunications','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function updateMRQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$str_state_id,$str_city_id,$str_place_id,$str_user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$status,$mr_id)
{
	global $link;
	$return = false;
			
	$sql = "UPDATE `tblmyrelations` SET `situation` = '".addslashes($situation)."' , `situation_font_family` = '".addslashes($situation_font_family)."' , `situation_font_size` = '".addslashes($situation_font_size)."' , `situation_font_color` = '".addslashes($situation_font_color)."' , `listing_date_type` = '".addslashes($listing_date_type)."' , `days_of_month` = '".addslashes($days_of_month)."' , `single_date` = '".addslashes($single_date)."' , `start_date` = '".addslashes($start_date)."' , `end_date` = '".addslashes($end_date)."' , `country_id` = '".addslashes($country_id)."'  , `state_id` = '".addslashes($str_state_id)."' , `city_id` = '".addslashes($str_city_id)."'  , `place_id` = '".addslashes($str_place_id)."' , `user_id` = '".addslashes($str_user_id)."' , `keywords` = '".addslashes($keywords)."' , `listing_order` = '".addslashes($listing_order)."' , `status` = '".addslashes($status)."'  WHERE `mr_id` = '".$mr_id."' AND `practitioner_id` = '".$practitioner_id."' ";
	//echo '<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = $mr_id;
		$del_sql1 = "DELETE FROM `tblemotionstreatments` WHERE `situation_id` = '".$situation_id."'  AND `et_type` = 'myrelations' "; 
		$result = mysql_query($del_sql1,$link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('myrelations','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function updateMLEQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$str_state_id,$str_city_id,$str_place_id,$str_user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$status,$mle_id)
{
	global $link;
	$return = false;
			
	$sql = "UPDATE `tblmajorlifeevents` SET `situation` = '".addslashes($situation)."' , `situation_font_family` = '".addslashes($situation_font_family)."' , `situation_font_size` = '".addslashes($situation_font_size)."' , `situation_font_color` = '".addslashes($situation_font_color)."' , `listing_date_type` = '".addslashes($listing_date_type)."' , `days_of_month` = '".addslashes($days_of_month)."' , `single_date` = '".addslashes($single_date)."' , `start_date` = '".addslashes($start_date)."' , `end_date` = '".addslashes($end_date)."' , `country_id` = '".addslashes($country_id)."'  , `state_id` = '".addslashes($state_id)."' , `city_id` = '".addslashes($city_id)."'  , `place_id` = '".addslashes($place_id)."' , `user_id` = '".addslashes($user_id)."' , `keywords` = '".addslashes($keywords)."' , `listing_order` = '".addslashes($listing_order)."' , `status` = '".addslashes($status)."'  WHERE `mle_id` = '".$mle_id."' AND `practitioner_id` = '".$practitioner_id."' ";
	//echo '<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = $mle_id;
		$del_sql1 = "DELETE FROM `tblemotionstreatments` WHERE `situation_id` = '".$situation_id."'  AND `et_type` = 'majorlifeevents' "; 
		$result = mysql_query($del_sql1,$link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('majorlifeevents','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function addSleepQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$state_id,$city_id,$user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$country_id,$place_id)
{
	global $link;
	$return = false;
			
	$sql = "INSERT INTO `tblsleeps` (`situation`,`situation_font_family`,`situation_font_size`,`situation_font_color`,`listing_date_type`,`days_of_month`,`single_date`,`start_date`,`end_date`,`country_id`,`state_id`,`city_id`,`place_id`,`user_id`,`practitioner_id`,`keywords`,`listing_order`,`status`) VALUES ('".addslashes($situation)."','".addslashes($situation_font_family)."','".addslashes($situation_font_size)."','".addslashes($situation_font_color)."','".addslashes($listing_date_type)."','".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($user_id)."','".addslashes($practitioner_id)."','".addslashes($keywords)."','".addslashes($listing_order)."','1')";

	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = mysql_insert_id($link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('sleep','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function addAddictionQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$state_id,$city_id,$user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$country_id,$place_id)
{
	global $link;
	$return = false;
			
	$sql = "INSERT INTO `tbladdictions` (`situation`,`situation_font_family`,`situation_font_size`,`situation_font_color`,`listing_date_type`,`days_of_month`,`single_date`,`start_date`,`end_date`,`country_id`,`state_id`,`city_id`,`place_id`,`user_id`,`practitioner_id`,`keywords`,`listing_order`,`status`) VALUES ('".addslashes($situation)."','".addslashes($situation_font_family)."','".addslashes($situation_font_size)."','".addslashes($situation_font_color)."','".addslashes($listing_date_type)."','".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($user_id)."','".addslashes($practitioner_id)."','".addslashes($keywords)."','".addslashes($listing_order)."','1')";
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = mysql_insert_id($link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('addiction','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function addWAEQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$state_id,$city_id,$user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$country_id,$place_id)
{
	global $link;
	$return = false;
			
	$sql = "INSERT INTO `tblworkandenvironments` (`situation`,`situation_font_family`,`situation_font_size`,`situation_font_color`,`listing_date_type`,`days_of_month`,`single_date`,`start_date`,`end_date`,`country_id`,`state_id`,`city_id`,`place_id`,`user_id`,`practitioner_id`,`keywords`,`listing_order`,`status`) VALUES ('".addslashes($situation)."','".addslashes($situation_font_family)."','".addslashes($situation_font_size)."','".addslashes($situation_font_color)."','".addslashes($listing_date_type)."','".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($user_id)."','".addslashes($practitioner_id)."','".addslashes($keywords)."','".addslashes($listing_order)."','1')";
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = mysql_insert_id($link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('workandenvironments','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function addGSQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$state_id,$city_id,$user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$country_id,$place_id)
{
	global $link;
	$return = false;
			
	$sql = "INSERT INTO `tblgeneralstressors` (`situation`,`situation_font_family`,`situation_font_size`,`situation_font_color`,`listing_date_type`,`days_of_month`,`single_date`,`start_date`,`end_date`,`country_id`,`state_id`,`city_id`,`place_id`,`user_id`,`practitioner_id`,`keywords`,`listing_order`,`status`) VALUES ('".addslashes($situation)."','".addslashes($situation_font_family)."','".addslashes($situation_font_size)."','".addslashes($situation_font_color)."','".addslashes($listing_date_type)."','".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($user_id)."','".addslashes($practitioner_id)."','".addslashes($keywords)."','".addslashes($listing_order)."','1')";
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = mysql_insert_id($link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('generalstressors','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function addMCQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$state_id,$city_id,$user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$country_id,$place_id)
{
	global $link;
	$return = false;
			
	$sql = "INSERT INTO `tblmycommunications` (`situation`,`situation_font_family`,`situation_font_size`,`situation_font_color`,`listing_date_type`,`days_of_month`,`single_date`,`start_date`,`end_date`,`country_id`,`state_id`,`city_id`,`place_id`,`user_id`,`practitioner_id`,`keywords`,`listing_order`,`status`) VALUES ('".addslashes($situation)."','".addslashes($situation_font_family)."','".addslashes($situation_font_size)."','".addslashes($situation_font_color)."','".addslashes($listing_date_type)."','".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($user_id)."','".addslashes($practitioner_id)."','".addslashes($keywords)."','".addslashes($listing_order)."','1')";
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = mysql_insert_id($link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('mycommunications','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function addMRQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$state_id,$city_id,$user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$country_id,$place_id)
{
	global $link;
	$return = false;
			
	$sql = "INSERT INTO `tblmyrelations` (`situation`,`situation_font_family`,`situation_font_size`,`situation_font_color`,`listing_date_type`,`days_of_month`,`single_date`,`start_date`,`end_date`,`country_id`,`state_id`,`city_id`,`place_id`,`user_id`,`practitioner_id`,`keywords`,`listing_order`,`status`) VALUES ('".addslashes($situation)."','".addslashes($situation_font_family)."','".addslashes($situation_font_size)."','".addslashes($situation_font_color)."','".addslashes($listing_date_type)."','".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($user_id)."','".addslashes($practitioner_id)."','".addslashes($keywords)."','".addslashes($listing_order)."','1')";
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = mysql_insert_id($link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('myrelations','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}

function addMLEQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$state_id,$city_id,$user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$country_id,$place_id)
{
	global $link;
	$return = false;
			
	$sql = "INSERT INTO `tblmajorlifeevents` (`situation`,`situation_font_family`,`situation_font_size`,`situation_font_color`,`listing_date_type`,`days_of_month`,`single_date`,`start_date`,`end_date`,`country_id`,`state_id`,`city_id`,`place_id`,`user_id`,`practitioner_id`,`keywords`,`listing_order`,`status`) VALUES ('".addslashes($situation)."','".addslashes($situation_font_family)."','".addslashes($situation_font_size)."','".addslashes($situation_font_color)."','".addslashes($listing_date_type)."','".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($user_id)."','".addslashes($practitioner_id)."','".addslashes($keywords)."','".addslashes($listing_order)."','1')";
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
		$situation_id = mysql_insert_id($link);
		for($i=0;$i<count($arr_min_rating);$i++)
		{
			$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('majorlifeevents','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
			$result = mysql_query($sql2,$link);
		}	
	}
	return $return;
}
	
function getFontFamilyOptions($font_family)
{
	$option_str = '';		
	
	$arr_font_family = array('Tahoma','Verdana','Arial Black','Comic Sans MS','Lucida Console','Palatino Linotype','MS Sans Serif4','System','Georgia1','Impact','Courier');
	sort($arr_font_family);
	
		for($i=0;$i<count($arr_font_family);$i++)
		{
			if($arr_font_family[$i] == $font_family)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			
			
			$option_str .= '<option value="'.$arr_font_family[$i].'" '.$sel.'>'.$arr_font_family[$i].'</option>';
		}
	
	return $option_str;
}

function getFontSizeOptions($font_size)
{
	$option_str = '';		
	
	$arr_font_size = array('8','9','10','11','12','13','14','16','18','20','22','24','28','30','32');
	sort($arr_font_size);
	
		for($i=0;$i<count($arr_font_size);$i++)
		{
			if($arr_font_size[$i] == $font_size)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			
			
			$option_str .= '<option value="'.$arr_font_size[$i].'" '.$sel.'>'.$arr_font_size[$i].'px</option>';
		}
	
	return $option_str;
}
function getAllSleepQuestionsList($practitioner_id)
{
	global $link;
	$sql = "SELECT * FROM `tblsleeps` WHERE `practitioner_id` = '".$practitioner_id."' ORDER BY `listing_order` ASC , `sleep_add_date` DESC";	
	$output = '';		
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$i = 1;
		while($row = mysql_fetch_array($result))
		{
			if($row['status'] == '1')
			{
				$status = 'Active';
			}
			else
			{
				$status = 'Inactive';
			}
			
			if($row['listing_date_type'] == 'days_of_month')
			{
				$date_type = 'Days of Month';
				$date_value = stripslashes($row['days_of_month']);
			}
			elseif($row['listing_date_type'] == 'single_date')
			{
				$date_type = 'Single Date';
				$date_value = date('d-m-Y',strtotime($row['single_date']));
			}
			elseif($row['listing_date_type'] == 'date_range')
			{
				$date_type = 'Date Range';
				$date_value = date('d-m-Y',strtotime($row['start_date'])).' - '.date('d-m-Y',strtotime($row['end_date']));
			}
			
			$output .= '<tr class="manage-row">';
			$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
			$output .= '<td height="30" align="center"><strong>'.stripslashes($row['situation']).'</strong></td>';
			$output .= '<td height="30" align="center">'.$date_type.'</td>';
			$output .= '<td height="30" align="center">'.$date_value.'</td>';
			$output .= '<td height="30" align="center">'.$status.'</td>';
			$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['sleep_add_date'])).'</td>';
			$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
			$output .= '<td align="center" nowrap="nowrap">';
					
			$output .= '<a href="edit_sleep_question.php?id='.$row['sleep_id'].'" ><img src = "images/edit.png" width="10" border="0"></a>';
						
			$output .= '</td>';
			$output .= '</tr>';
			$i++;
		}
	}
	else
	{
		$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';
	}
	return $output;
}

function getAllAddictionQuestionsList($practitioner_id)
{
	global $link;
	$sql = "SELECT * FROM `tbladdictions` WHERE `practitioner_id` = '".$practitioner_id."' ORDER BY `listing_order` ASC , `adct_add_date` DESC";	
	$output = '';		
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$i = 1;
		while($row = mysql_fetch_array($result))
		{
			if($row['status'] == '1')
			{
				$status = 'Active';
			}
			else
			{
				$status = 'Inactive';
			}
			
			if($row['listing_date_type'] == 'days_of_month')
			{
				$date_type = 'Days of Month';
				$date_value = stripslashes($row['days_of_month']);
			}
			elseif($row['listing_date_type'] == 'single_date')
			{
				$date_type = 'Single Date';
				$date_value = date('d-m-Y',strtotime($row['single_date']));
			}
			elseif($row['listing_date_type'] == 'date_range')
			{
				$date_type = 'Date Range';
				$date_value = date('d-m-Y',strtotime($row['start_date'])).' - '.date('d-m-Y',strtotime($row['end_date']));
			}
			
			$output .= '<tr class="manage-row">';
			$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
			$output .= '<td height="30" align="center"><strong>'.stripslashes($row['situation']).'</strong></td>';
			$output .= '<td height="30" align="center">'.$date_type.'</td>';
			$output .= '<td height="30" align="center">'.$date_value.'</td>';
			$output .= '<td height="30" align="center">'.$status.'</td>';
			$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['adct_add_date'])).'</td>';
			$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
			$output .= '<td align="center" nowrap="nowrap">';
					
			$output .= '<a href="edit_addiction_question.php?id='.$row['adct_id'].'" ><img src = "images/edit.png" width="10" border="0"></a>';
						
			$output .= '</td>';
			$output .= '</tr>';
			$i++;
		}
	}
	else
	{
		$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';
	}
	return $output;
}

function getAllWAEQuestionsList($practitioner_id)
{
	global $link;
	$sql = "SELECT * FROM `tblworkandenvironments` WHERE `practitioner_id` = '".$practitioner_id."' ORDER BY `listing_order` ASC , `wae_add_date` DESC";	
	$output = '';		
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$i = 1;
		while($row = mysql_fetch_array($result))
		{
			if($row['status'] == '1')
			{
				$status = 'Active';
			}
			else
			{
				$status = 'Inactive';
			}
			
			if($row['listing_date_type'] == 'days_of_month')
			{
				$date_type = 'Days of Month';
				$date_value = stripslashes($row['days_of_month']);
			}
			elseif($row['listing_date_type'] == 'single_date')
			{
				$date_type = 'Single Date';
				$date_value = date('d-m-Y',strtotime($row['single_date']));
			}
			elseif($row['listing_date_type'] == 'date_range')
			{
				$date_type = 'Date Range';
				$date_value = date('d-m-Y',strtotime($row['start_date'])).' - '.date('d-m-Y',strtotime($row['end_date']));
			}
			
			$output .= '<tr class="manage-row">';
			$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
			$output .= '<td height="30" align="center"><strong>'.stripslashes($row['situation']).'</strong></td>';
			$output .= '<td height="30" align="center">'.$date_type.'</td>';
			$output .= '<td height="30" align="center">'.$date_value.'</td>';
			$output .= '<td height="30" align="center">'.$status.'</td>';
			$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['wae_add_date'])).'</td>';
			$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
			$output .= '<td align="center" nowrap="nowrap">';
					
			$output .= '<a href="edit_wae_question.php?id='.$row['wae_id'].'" ><img src = "images/edit.png" width="10" border="0"></a>';
						
			$output .= '</td>';
			$output .= '</tr>';
			$i++;
		}
	}
	else
	{
		$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';
	}
	return $output;
}

function getAllGSQuestionsList($practitioner_id)
{
	global $link;
	$sql = "SELECT * FROM `tblgeneralstressors` WHERE `practitioner_id` = '".$practitioner_id."' ORDER BY `listing_order` ASC , `gs_add_date` DESC";	
	$output = '';		
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$i = 1;
		while($row = mysql_fetch_array($result))
		{
			if($row['status'] == '1')
			{
				$status = 'Active';
			}
			else
			{
				$status = 'Inactive';
			}
			
			if($row['listing_date_type'] == 'days_of_month')
			{
				$date_type = 'Days of Month';
				$date_value = stripslashes($row['days_of_month']);
			}
			elseif($row['listing_date_type'] == 'single_date')
			{
				$date_type = 'Single Date';
				$date_value = date('d-m-Y',strtotime($row['single_date']));
			}
			elseif($row['listing_date_type'] == 'date_range')
			{
				$date_type = 'Date Range';
				$date_value = date('d-m-Y',strtotime($row['start_date'])).' - '.date('d-m-Y',strtotime($row['end_date']));
			}
			
			$output .= '<tr class="manage-row">';
			$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
			$output .= '<td height="30" align="center"><strong>'.stripslashes($row['situation']).'</strong></td>';
			$output .= '<td height="30" align="center">'.$date_type.'</td>';
			$output .= '<td height="30" align="center">'.$date_value.'</td>';
			$output .= '<td height="30" align="center">'.$status.'</td>';
			$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['gs_add_date'])).'</td>';
			$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
			$output .= '<td align="center" nowrap="nowrap">';
					
			$output .= '<a href="edit_gs_question.php?id='.$row['gs_id'].'" ><img src = "images/edit.png" width="10" border="0"></a>';
						
			$output .= '</td>';
			$output .= '</tr>';
			$i++;
		}
	}
	else
	{
		$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';
	}
	return $output;
}

function getAllMCQuestionsList($practitioner_id)
{
	global $link;
	$sql = "SELECT * FROM `tblmycommunications` WHERE `practitioner_id` = '".$practitioner_id."' ORDER BY `listing_order` ASC , `mc_add_date` DESC";	
	$output = '';		
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$i = 1;
		while($row = mysql_fetch_array($result))
		{
			if($row['status'] == '1')
			{
				$status = 'Active';
			}
			else
			{
				$status = 'Inactive';
			}
			
			if($row['listing_date_type'] == 'days_of_month')
			{
				$date_type = 'Days of Month';
				$date_value = stripslashes($row['days_of_month']);
			}
			elseif($row['listing_date_type'] == 'single_date')
			{
				$date_type = 'Single Date';
				$date_value = date('d-m-Y',strtotime($row['single_date']));
			}
			elseif($row['listing_date_type'] == 'date_range')
			{
				$date_type = 'Date Range';
				$date_value = date('d-m-Y',strtotime($row['start_date'])).' - '.date('d-m-Y',strtotime($row['end_date']));
			}
			
			$output .= '<tr class="manage-row">';
			$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
			$output .= '<td height="30" align="center"><strong>'.stripslashes($row['situation']).'</strong></td>';
			$output .= '<td height="30" align="center">'.$date_type.'</td>';
			$output .= '<td height="30" align="center">'.$date_value.'</td>';
			$output .= '<td height="30" align="center">'.$status.'</td>';
			$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['mc_add_date'])).'</td>';
			$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
			$output .= '<td align="center" nowrap="nowrap">';
					
			$output .= '<a href="edit_mc_question.php?id='.$row['mc_id'].'" ><img src = "images/edit.png" width="10" border="0"></a>';
						
			$output .= '</td>';
			$output .= '</tr>';
			$i++;
		}
	}
	else
	{
		$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';
	}
	return $output;
}

function getAllMRQuestionsList($practitioner_id)
{
	global $link;
	$sql = "SELECT * FROM `tblmyrelations` WHERE `practitioner_id` = '".$practitioner_id."' ORDER BY `listing_order` ASC , `mr_add_date` DESC";	
	$output = '';		
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$i = 1;
		while($row = mysql_fetch_array($result))
		{
			if($row['status'] == '1')
			{
				$status = 'Active';
			}
			else
			{
				$status = 'Inactive';
			}
			
			if($row['listing_date_type'] == 'days_of_month')
			{
				$date_type = 'Days of Month';
				$date_value = stripslashes($row['days_of_month']);
			}
			elseif($row['listing_date_type'] == 'single_date')
			{
				$date_type = 'Single Date';
				$date_value = date('d-m-Y',strtotime($row['single_date']));
			}
			elseif($row['listing_date_type'] == 'date_range')
			{
				$date_type = 'Date Range';
				$date_value = date('d-m-Y',strtotime($row['start_date'])).' - '.date('d-m-Y',strtotime($row['end_date']));
			}
			
			$output .= '<tr class="manage-row">';
			$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
			$output .= '<td height="30" align="center"><strong>'.stripslashes($row['situation']).'</strong></td>';
			$output .= '<td height="30" align="center">'.$date_type.'</td>';
			$output .= '<td height="30" align="center">'.$date_value.'</td>';
			$output .= '<td height="30" align="center">'.$status.'</td>';
			$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['mr_add_date'])).'</td>';
			$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
			$output .= '<td align="center" nowrap="nowrap">';
					
			$output .= '<a href="edit_mr_question.php?id='.$row['mr_id'].'" ><img src = "images/edit.png" width="10" border="0"></a>';
						
			$output .= '</td>';
			$output .= '</tr>';
			$i++;
		}
	}
	else
	{
		$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';
	}
	return $output;
}

function getAllMLEQuestionsList($practitioner_id)
{
	global $link;
	$sql = "SELECT * FROM `tblmajorlifeevents` WHERE `practitioner_id` = '".$practitioner_id."' ORDER BY `listing_order` ASC , `mle_add_date` DESC";	
	$output = '';		
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$i = 1;
		while($row = mysql_fetch_array($result))
		{
			if($row['status'] == '1')
			{
				$status = 'Active';
			}
			else
			{
				$status = 'Inactive';
			}
			
			if($row['listing_date_type'] == 'days_of_month')
			{
				$date_type = 'Days of Month';
				$date_value = stripslashes($row['days_of_month']);
			}
			elseif($row['listing_date_type'] == 'single_date')
			{
				$date_type = 'Single Date';
				$date_value = date('d-m-Y',strtotime($row['single_date']));
			}
			elseif($row['listing_date_type'] == 'date_range')
			{
				$date_type = 'Date Range';
				$date_value = date('d-m-Y',strtotime($row['start_date'])).' - '.date('d-m-Y',strtotime($row['end_date']));
			}
			
			$output .= '<tr class="manage-row">';
			$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
			$output .= '<td height="30" align="center"><strong>'.stripslashes($row['situation']).'</strong></td>';
			$output .= '<td height="30" align="center">'.$date_type.'</td>';
			$output .= '<td height="30" align="center">'.$date_value.'</td>';
			$output .= '<td height="30" align="center">'.$status.'</td>';
			$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['mle_add_date'])).'</td>';
			$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
			$output .= '<td align="center" nowrap="nowrap">';
					
			$output .= '<a href="edit_mle_question.php?id='.$row['mle_id'].'" ><img src = "images/edit.png" width="10" border="0"></a>';
						
			$output .= '</td>';
			$output .= '</tr>';
			$i++;
		}
	}
	else
	{
		$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';
	}
	return $output;
}
	

function updateUserPro($name,$dob,$sex,$mobile,$address,$country_id,$state_id,$city_id,$place_id,$reg_no,$issued_by,$scan_image,$membership,$membership_no,$membership_image,$service_clinic_name,$service_location,$service_location_country_id,$service_location_state_id,$service_location_city_id,$service_location_place_id,$service_rendered,$service_notes,$referred_by,$ref_name,$specify,$pro_user_id)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tblprofusers` SET  `name` = '".addslashes($name)."' , `dob` = '".$dob."' , `sex` = '".$sex."' , `mobile` = '".addslashes($mobile)."' , `address` = '".addslashes($address)."'  , `country_id` = '".addslashes($country_id)."'  , `state_id` = '".$state_id."', `city_id` = '".$city_id."', `place_id` = '".addslashes($place_id)."', `reg_no` = '".addslashes($reg_no)."' , `issued_by` = '".addslashes($issued_by)."' , `scan_image` = '".addslashes($scan_image)."' , `membership` = '".addslashes($membership)."' , `membership_no` = '".addslashes($membership_no)."' , `membership_image` = '".addslashes($membership_image)."' , `service_clinic_name` = '".addslashes($service_clinic_name)."' , `service_location` = '".addslashes($service_location)."' , `service_location_country_id` = '".addslashes($service_location_country_id)."' , `service_location_state_id` = '".addslashes($service_location_state_id)."' , `service_location_city_id` = '".addslashes($service_location_city_id)."' , `service_location_place_id` = '".addslashes($service_location_place_id)."' , `service_rendered` = '".addslashes($service_rendered)."' , `service_notes` = '".addslashes($service_notes)."' , `referred_by` = '".addslashes($referred_by)."' , `ref_name` = '".addslashes($ref_name)."' , `specify` = '".addslashes($specify)."'  WHERE `pro_user_id` = '".$pro_user_id."'";
	//echo"<br>Testkk: sql = ".$sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
	}
	return $return;
}

function updateUserVender($company_name,$contract_person,$contract_mobile,$address,$country_id,$state_id,$city_id,$place_id,$contract_id)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tblcontracts` SET  `company_name` = '".addslashes($company_name)."' , `contract_person` = '".addslashes($contract_person)."' , `contract_mobile` = '".addslashes($contract_mobile)."' , `address` = '".addslashes($address)."'  , `country_id` = '".addslashes($country_id)."'  , `state_id` = '".$state_id."', `city_id` = '".$city_id."', `place_id` = '".addslashes($place_id)."'  WHERE `contract_id` = '".$contract_id."'";
	//echo"<br>Testkk: sql = ".$sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
	}
	return $return;
}

function getUserDetailsPro($pro_user_id)
{
	global $link;
	$return = false;
	$name = '';
	$email = '';
	$dob = '';
	$sex = '';
	$mobile = '';
	$address = '';
	$country_id = '';
	$state_id = '';
	$city_id = '';
	$place_id = '';
	$reg_no = '';
	$issued_by = '';
	$scan_image = '';
	$membership = '';
	$membership_no = '';
	$membership_image = '';
	$service_clinic_name = '';
	$service_location = '';
	$service_location_country_id = '';
	$service_location_state_id = '';
	$service_location_city_id = '';
	$service_location_place_id = '';
	$service_rendered = '';
	$service_notes = '';
	$referred_by = '';
	$ref_name = '';
	$specify = '';
		
		
	$sql = "SELECT * FROM `tblprofusers` WHERE `pro_user_id` = '".$pro_user_id."' ";
	//echo'<br>'.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$return = true;
		$name = stripslashes($row['name']);
		$email = $row['email'];
		$dob = $row['dob'];
		$sex = $row['sex'];
		$mobile = stripslashes($row['mobile']);
		$address = stripslashes($row['address']);
		$country_id = $row['country_id'];
		$state_id = $row['state_id'];
		$city_id = $row['city_id'];
		$place_id = $row['place_id'];
		$reg_no = stripslashes($row['reg_no']);
		$issued_by = stripslashes($row['issued_by']);
		$scan_image = stripslashes($row['scan_image']);
		$membership = stripslashes($row['membership']);
		$membership_no = stripslashes($row['membership_no']);
		$membership_image = stripslashes($row['membership_image']);
		$service_clinic_name = stripslashes($row['service_clinic_name']);
		$service_location = stripslashes($row['service_location']);
		$service_location_country_id = stripslashes($row['service_location_country_id']);
		$service_location_state_id = stripslashes($row['service_location_state_id']);
		$service_location_city_id = stripslashes($row['service_location_city_id']);
		$service_location_place_id = stripslashes($row['service_location_place_id']);
		$service_rendered = stripslashes($row['service_rendered']);
		$service_notes = stripslashes($row['service_notes']);
		$referred_by = stripslashes($row['referred_by']);
		$ref_name = stripslashes($row['ref_name']);
		$specify = stripslashes($row['specify']);
	}
	return array($return,$name,$email,$dob,$sex,$mobile,$address,$country_id,$state_id,$city_id,$place_id,$reg_no,$issued_by,$scan_image,$membership,$membership_no,$membership_image,$service_clinic_name,$service_location,$service_location_country_id,$service_location_state_id,$service_location_city_id,$service_location_place_id,$service_rendered,$service_notes,$referred_by,$ref_name,$specify);
}

function getUserDetailsVender($contract_id)
{
	global $link;
	$return = false;
	$contract_person = '';
        $company_name = '';
        $contract_email = '';
        $contract_mobile = '';
        $address = '';
        $country_id = '';
        $state_id = '';
        $city_id = '';
        $place_id = '';
		
		
	$sql = "SELECT * FROM `tblcontracts` WHERE `contract_id` = '".$contract_id."' ";
	//echo'<br>'.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $return = true;
            $contract_person = stripslashes($row['contract_person']);
            $company_name = stripslashes($row['company_name']);
            $contract_email = $row['contract_email'];
            $contract_mobile = stripslashes($row['contract_mobile']);
            $address = stripslashes($row['address']);
            $country_id = $row['country_id'];
            $state_id = $row['state_id'];
            $city_id = $row['city_id'];
            $place_id = $row['place_id'];
	}
	return array($return,$contract_person,$company_name,$contract_email,$contract_mobile,$address,$country_id,$state_id,$city_id,$place_id);
}

function doLoginPro($email)
{
	global $link;
	$return = false;
	
	$pro_user_id = getProUserId($email);
	$name = getProUserFullNameById($pro_user_id);
		
	if($pro_user_id > 0)
	{
		$return = true;	
		$_SESSION['pro_user_id'] = $pro_user_id;
		$_SESSION['pro_name'] = $name;
		$_SESSION['pro_email'] = $email;
	}	
	return $return;
}

function doLoginProVivek($email)
{
	global $link;
	$return = false;
	
//	$pro_user_id = getProUserId($email);
//	$name = getProUserFullNameById($pro_user_id);
        
        $pro_user_id = getProUserIdVivek($email);
	$name = getProUserFullNameByIdVivek($pro_user_id);
		
	if($pro_user_id > 0)
	{
		$return = true;	
		$_SESSION['pro_user_id'] = $pro_user_id;
		$_SESSION['pro_name'] = $name;
		$_SESSION['pro_email'] = $email;
	}	
	return $return;
}

function doLoginVender($email)
{
	global $link;
	$return = false;
	
	$contract_id = getVenderUserId($email);
	$name = getVenderUserFullNameById($contract_id);
		
	if($contract_id > 0)
	{
		$return = true;	
		$_SESSION['vender_user_id'] = $contract_id;
		$_SESSION['vender_name'] = $name;
		$_SESSION['vender_email'] = $email;
	}	
	return $return;
}

function chkValidLoginPro($email,$password)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tblprofusers` WHERE `email` = '".$email."' AND `password` = '".md5($password)."' AND `status` = '1' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}

function chkValidLoginProVivek($email,$password)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tbl_profusers` WHERE `email` = '".$email."' AND `password` = '".md5($password)."' AND `status` = '1' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}

function chkValidLoginVender($email,$password)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tblcontracts` WHERE `contract_email` = '".$email."' AND `password` = '".md5($password)."' AND `contract_status` = '1' ";
	//echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $return = true;
	}
	return $return;
}

function getStateOptions($country_id,$state_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblstates` WHERE `country_id` = '".$country_id."' ORDER BY `state` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			if($row['state_id'] == $state_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['state_id'].'" '.$sel.'>'.stripslashes($row['state']).'</option>';
		}
	}
	return $option_str;
}

function genrateProUserUniqueId($user_id)
{
	$unique_id = '';
	
	$strlen_user_id = strlen($user_id);
	
	if($strlen_user_id == 1)
	{
		$unique_id = 'WP10000000'.$user_id;
	} 
	elseif($strlen_user_id == 2)
	{
		$unique_id = 'WP1000000'.$user_id;
	}
	elseif($strlen_user_id == 3)
	{
		$unique_id = 'WP100000'.$user_id;
	}
	elseif($strlen_user_id == 4)
	{
		$unique_id = 'WP10000'.$user_id;
	}
	elseif($strlen_user_id == 5)
	{
		$unique_id = 'WP1000'.$user_id;
	}
	elseif($strlen_user_id == 6)
	{
		$unique_id = 'WP100'.$user_id;
	}
	elseif($strlen_user_id == 7)
	{
		$unique_id = 'WP10'.$user_id;
	}
	else
	{
		$unique_id = 'WP1'.$user_id;
	}
	 
	return $unique_id;	
}

function genrateVenderUserUniqueId($user_id)
{
	$unique_id = '';
	
	$strlen_user_id = strlen($user_id);
	
	if($strlen_user_id == 1)
	{
		$unique_id = 'WV10000000'.$user_id;
	} 
	elseif($strlen_user_id == 2)
	{
		$unique_id = 'WV1000000'.$user_id;
	}
	elseif($strlen_user_id == 3)
	{
		$unique_id = 'WV100000'.$user_id;
	}
	elseif($strlen_user_id == 4)
	{
		$unique_id = 'WV10000'.$user_id;
	}
	elseif($strlen_user_id == 5)
	{
		$unique_id = 'WV1000'.$user_id;
	}
	elseif($strlen_user_id == 6)
	{
		$unique_id = 'WV100'.$user_id;
	}
	elseif($strlen_user_id == 7)
	{
		$unique_id = 'WV10'.$user_id;
	}
	else
	{
		$unique_id = 'WV1'.$user_id;
	}
	 
	return $unique_id;	
}

function debuglog($stringData)
{
	$logFile = "debuglog_".date("Y-m-d").".txt";
	$fh = fopen($logFile, 'a');
	fwrite($fh, "\n\n----------------------------------------------------\nDEBUG_START - time: ".date("Y-m-d H:i:s")."\n".$stringData."\nDEBUG_END - time: ".date("Y-m-d H:i:s")."\n----------------------------------------------------\n\n");
	fclose($fh);	
}

function signUpProUser($name,$email,$password,$dob,$sex,$mobile,$address,$country_id,$state_id,$city_id,$place_id,$reg_no,$issued_by,$scan_image,$membership,$membership_no,$membership_image,$service_clinic_name,$service_location,$service_location_country_id,$service_location_state_id,$service_location_city_id,$service_location_place_id,$service_rendered,$service_notes,$referred_by,$ref_name,$specify)
{
	global $link;
	$return = 0;
	$now = time();
	
	$sql = "INSERT INTO `tblprofusers` (`name`,`email`,`password`,`dob`,`sex`,`mobile`,`address`,`country_id`,`state_id`,`city_id`,`place_id`,`reg_no`,`issued_by`,`scan_image`,`membership`,`membership_no`,`membership_image`,`service_clinic_name`,`service_location`,`service_location_country_id`,`service_location_state_id`,`service_location_city_id`,`service_location_place_id`,`service_rendered`,`service_notes`,`referred_by`,`ref_name`,`specify`,`status`) VALUES ('".addslashes($name)."','".addslashes($email)."','".md5($password)."','".$dob."','".$sex."','".addslashes($mobile)."','".addslashes($address)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($reg_no)."','".addslashes($issued_by)."','".addslashes($scan_image)."','".addslashes($membership)."','".addslashes($membership_no)."','".addslashes($membership_image)."','".addslashes($service_clinic_name)."','".addslashes($service_location)."','".addslashes($service_location_country_id)."','".addslashes($service_location_state_id)."','".addslashes($service_location_city_id)."','".addslashes($service_location_place_id)."','".addslashes($service_rendered)."','".addslashes($service_notes)."','".addslashes($referred_by)."','".addslashes($ref_name)."','".addslashes($specify)."','0')";
	//echo '<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$pro_user_id = mysql_insert_id($link);
		$pro_unique_id = genrateProUserUniqueId($pro_user_id);
		$sql2 = "UPDATE `tblprofusers` SET `pro_unique_id` = '".$pro_unique_id."' WHERE `pro_user_id` = '".$pro_user_id."'";
		//echo '<br>Testkk: sql2 = '.$sql2;
		$result2 = mysql_query($sql2,$link);
		if($result2)
		{	
			$return = $pro_user_id;
		}
	}
	else
	{
		//$stringData = 'Error No - '.mysql_errno($link) . " , Error " . mysql_error($link).' , sql = '.$sql; 
		//debuglog($stringData);
	}	
	return $return;
}

function signUpVenderUser($company_name,$contract_person,$contract_person_type,$contract_email,$password,$contract_mobile,$address,$country_id,$state_id,$city_id,$place_id)
{
	global $link;
	$return = 0;
	$updated_on_date = date('Y-m-d H:i:s');
	
	$sql = "INSERT INTO `tblcontracts` (`contract_person`,`company_name`,`contract_person_type`,`contract_email`,`address`,"
                        . "`country_id`,`state_id`,`city_id`,`place_id`,`contract_mobile`,`contract_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`,`password`) "
                        . "VALUES ('".addslashes($contract_person)."','".addslashes($company_name)."','".addslashes($contract_person_type)."',"
                        . "'".addslashes($contract_email)."','".addslashes($address)."','".addslashes($country_id)."','".addslashes($state_id)."',"
                        . "'".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($contract_mobile)."','0','0','0','".$updated_on_date."','".md5($password)."')";
	//echo '<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$contract_id = mysql_insert_id($link);
		$vender_unique_id = genrateVenderUserUniqueId($contract_id);
		$sql2 = "UPDATE `tblcontracts` SET `vender_unique_id` = '".$vender_unique_id."' WHERE `contract_id` = '".$contract_id."'";
		//echo '<br>Testkk: sql2 = '.$sql2;
		$result2 = mysql_query($sql2,$link);
		if($result2)
		{	
                    $return = $contract_id;
		}
	}
	else
	{
		//$stringData = 'Error No - '.mysql_errno($link) . " , Error " . mysql_error($link).' , sql = '.$sql; 
		//debuglog($stringData);
	}	
	return $return;
}

function chkProEmailExists($email)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tblprofusers` WHERE `email` = '".$email."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}

function chkVenderEmailExists($email)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tblcontracts` WHERE `contract_email` = '".$email."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $return = true;
	}
	return $return;
}

function doValiadteProUser($email)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tblprofusers` SET `status` = '1' WHERE `email` = '".$email."'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
	}
	return $return;
}

function doValiadteVenderUser($email)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tblcontracts` SET `contract_status` = '1' WHERE `contract_email` = '".$email."'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
	}
	return $return;
}

function getProUserId($email)
{
	global $link;
	$pro_user_id = 0;
	
	$sql = "SELECT * FROM `tblprofusers` WHERE `email` = '".$email."' AND `status` = '1'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$pro_user_id = $row['pro_user_id'];
	}
	return $pro_user_id;
}

function getProUserIdVivek($email)
{
	global $link;
	$pro_user_id = 0;
	
	$sql = "SELECT * FROM `tbl_profusers` WHERE `email` = '".$email."' AND `status` = '1'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$pro_user_id = $row['pro_user_id'];
	}
	return $pro_user_id;
}

function getVenderUserId($email)
{
	global $link;
	$contract_id = 0;
	
	$sql = "SELECT * FROM `tblcontracts` WHERE `contract_email` = '".$email."' AND `contract_status` = '1'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$contract_id = $row['contract_id'];
	}
	return $contract_id;
}

function getProUserFullNameById($pro_user_id)
{
	global $link;
	$return = false;
	$name = '';
	
	$sql = "SELECT * FROM `tblprofusers` WHERE `pro_user_id` = '".$pro_user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$return = true;
		$name = stripslashes($row['name']);
	}
	return $name;
}

function getProUserFullNameByIdVivek($pro_user_id)
{
	global $link;
	$return = false;
	$name = '';
	
	$sql = "SELECT * FROM `tbl_profusers` WHERE `pro_user_id` = '".$pro_user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$return = true;
		$name = stripslashes($row['username']);
	}
	return $name;
}


function getVenderUserFullNameById($pro_user_id)
{
	global $link;
	$return = false;
	$name = '';
	
	$sql = "SELECT * FROM `tblcontracts` WHERE `contract_id` = '".$pro_user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$return = true;
		$name = stripslashes($row['company_name']);
	}
	return $name;
}

function doUpdateOnlinePro($pro_user_id)
{
	global $link;
	$now = time();
	$return = false;
	
	if($pro_user_id > 0)
	{
            $sql = "UPDATE `tblprofusers` SET `online_timestamp` = '".$now."' WHERE `pro_user_id` = '".$pro_user_id."'";
            $result = mysql_query($sql,$link);
            if($result)
            {
                $return = true;	
            }
	}	
	return $return;
}

function chkValidProUserId($pro_user_id)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tbl_profusers` WHERE `pro_user_id` = '".$pro_user_id."' AND `status` = '1'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}
//function chkValidProUserId($pro_user_id)
//{
//	global $link;
//	$return = false;
//	
//	$sql = "SELECT * FROM `tblprofusers` WHERE `pro_user_id` = '".$pro_user_id."' AND `status` = '1'";
//	$result = mysql_query($sql,$link);
//	if( ($result) && (mysql_num_rows($result) > 0) )
//	{
//		$return = true;
//	}
//	return $return;
//}

function isLoggedInPro()
{
	global $link;
	$return = false;
	if( isset($_SESSION['pro_user_id']) && ($_SESSION['pro_user_id'] > 0) && ($_SESSION['pro_user_id'] != '') )
	{
		$return = chkValidProUserId($_SESSION['pro_user_id']);	
	}
	return $return;
}

function doUpdateOnlineVender($vender_user_id)
{
	global $link;
	$now = time();
	$return = false;
	
	if($vender_user_id > 0)
	{
            $sql = "UPDATE `tblcontracts` SET `online_timestamp` = '".$now."' WHERE `contract_id` = '".$vender_user_id."'";
            $result = mysql_query($sql,$link);
            if($result)
            {
                $return = true;	
            }
	}	
	return $return;
}

function chkValidVenderUserId($vender_user_id)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tblcontracts` WHERE `contract_id` = '".$vender_user_id."' AND `contract_status` = '1'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $return = true;
	}
	return $return;
}

function isLoggedInVender()
{
	global $link;
	$return = false;
	if( isset($_SESSION['vender_user_id']) && ($_SESSION['vender_user_id'] > 0) && ($_SESSION['vender_user_id'] != '') )
	{
		$return = chkValidProUserId($_SESSION['vender_user_id']);	
	}
	return $return;
}

function chkIfUserIsAdvisersReferrals($pro_user_id,$user_id)
{
	global $link;
	$return = false;
	
	$user_email = getUserEmailById($user_id);
        $pro_user_email = getProUserEmailById($pro_user_id);
	//$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `request_status` = '1'";
        $sql = "SELECT * FROM `tbladviserreferrals` WHERE (`pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `request_status` = '1' AND `invite_by_user` = '0') OR (`pro_user_id` = '".$user_id."' AND `user_email` = '".$pro_user_email."' AND `request_status` = '1' AND `invite_by_user` = '1')";
	//echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}

	return $return;
}

function chkIfUserIsAdvisersReferralsChkByProEmail($pro_user_email,$user_id)
{
	global $link;
	$return = false;
	
        $pro_user_id = getProUserId($pro_user_email);
	$user_email = getUserEmailById($user_id);
	$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `request_status` = '1'";
	//echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}

	return $return;
}

function chkAdviserForLocationCriteria($pro_user_id,$country_id,$str_state_id,$str_city_id,$str_place_id)
{
	$add_to_record = false;
	$chk_next = false;
	
	list($return,$name,$email,$dob,$sex,$mobile,$address,$user_country_id,$state_id,$city_id,$place_id,$reg_no,$issued_by,$scan_image,$membership,$membership_no,$membership_image,$service_clinic_name,$service_location,$service_location_country_id,$service_location_state_id,$service_location_city_id,$service_location_place_id,$service_rendered,$service_notes,$referred_by,$ref_name,$specify) = getUserDetailsPro($pro_user_id);
	
	if($return)
	{
		if($country_id == '0')
		{
			$chk_next = true;
		}
		elseif($country_id == $user_country_id)
		{
			$chk_next = true;
		}
		else
		{
			$chk_next = false;
		}
		
		
		if($chk_next)
		{
			if($str_state_id == '')
			{
				$chk_next = true;
			}
			else
			{
				$arr_state_id = array();
				$pos1 = strpos($str_state_id, ',');
				if ($pos1 !== false) 
				{
					$arr_state_id = explode(',',$str_state_id);
				}
				else
				{
					array_push($arr_state_id , $str_state_id);
				}
				
				if(in_array($state_id,$arr_state_id) || $arr_state_id[0] == '')
				{
					$chk_next = true;
				}
				else
				{
					$chk_next = false;
				}	
			}
		}	
			
		if($chk_next)
		{
			if($str_city_id == '')
			{
				$chk_next = true;
			}
			else
			{
				$arr_city_id = array();
				$pos2 = strpos($str_city_id, ',');
				if ($pos2 !== false) 
				{
					$arr_city_id = explode(',',$str_city_id);
				}
				else
				{
					array_push($arr_city_id , $str_city_id);
				}
				
				if(in_array($city_id,$arr_city_id) || $arr_city_id[0] == '')
				{
					$chk_next = true;
				}
				else
				{
					$chk_next = false;
				}	
			}
		}	
		
		if($chk_next)
		{
			if($str_place_id == '')
			{
				$chk_next = true;
			}
			else
			{
				$arr_place_id = array();
				$pos3 = strpos($str_place_id, ',');
				if ($pos3 !== false) 
				{
					$arr_place_id = explode(',',$str_place_id);
				}
				else
				{
					array_push($arr_place_id , $str_place_id);
				}
				
				if(in_array($place_id,$arr_place_id) || $arr_place_id[0] == '')
				{
					$chk_next = true;
				}
				else
				{
					$chk_next = false;
				}	
			}
		}		
			
		if($chk_next)
		{
			$add_to_record = true;
		}
	}		
	return $add_to_record;
}
function chkUserForLocationCriteria($user_id,$country_id,$str_state_id,$str_city_id,$str_place_id)
{
	$add_to_record = false;
	$chk_next = false;
	
	list($return,$name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$user_practitioner_id,$user_country_id) = getUserDetails($user_id);
	
	if($return)
	{
		if($country_id == '0')
		{
			$chk_next = true;
		}
		elseif($country_id == $user_country_id)
		{
			$chk_next = true;
		}
		else
		{
			$chk_next = false;
		}
		
		
		if($chk_next)
		{
			if($str_state_id == '')
			{
				$chk_next = true;
			}
			else
			{
				$arr_state_id = array();
				$pos1 = strpos($str_state_id, ',');
				if ($pos1 !== false) 
				{
					$arr_state_id = explode(',',$str_state_id);
				}
				else
				{
					array_push($arr_state_id , $str_state_id);
				}
				
				if(in_array($state_id,$arr_state_id) || $arr_state_id[0] == '')
				{
					$chk_next = true;
				}
				else
				{
					$chk_next = false;
				}	
			}
		}	
			
		if($chk_next)
		{
			if($str_city_id == '')
			{
				$chk_next = true;
			}
			else
			{
				$arr_city_id = array();
				$pos2 = strpos($str_city_id, ',');
				if ($pos2 !== false) 
				{
					$arr_city_id = explode(',',$str_city_id);
				}
				else
				{
					array_push($arr_city_id , $str_city_id);
				}
				
				if(in_array($city_id,$arr_city_id) || $arr_city_id[0] == '')
				{
					$chk_next = true;
				}
				else
				{
					$chk_next = false;
				}	
			}
		}	
		
		if($chk_next)
		{
			if($str_place_id == '')
			{
				$chk_next = true;
			}
			else
			{
				$arr_place_id = array();
				$pos3 = strpos($str_place_id, ',');
				if ($pos3 !== false) 
				{
					$arr_place_id = explode(',',$str_place_id);
				}
				else
				{
					array_push($arr_place_id , $str_place_id);
				}
				
				if(in_array($place_id,$arr_place_id) || $arr_place_id[0] == '')
				{
					$chk_next = true;
				}
				else
				{
					$chk_next = false;
				}	
			}
		}		
			
		if($chk_next)
		{
			$add_to_record = true;
		}
	}		
	return $add_to_record;
}
function chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id)
{
	$add_to_record = false;
	$chk_next = false;
	//echo '<br>33333333333333333';
	list($return,$name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$user_practitioner_id,$user_country_id) = getUserDetails($user_id);
	
	if($return)
	{
            
		if($practitioner_id == '' || $practitioner_id == '0')
		{
			$chk_next = true;
		}
		else
		{
                    //echo '<br>else222222222';
			if($str_user_id == '')
			{
				if(chkIfUserIsAdvisersReferrals($practitioner_id,$user_id))
				{
					$chk_next = true;
				}
			}
			else
			{
                            
				$arr_user_id = array();
				$pos4 = strpos($str_user_id, ',');
				if ($pos4 !== false) 
				{
					$arr_user_id = explode(',',$str_user_id);
				}
				else
				{
					array_push($arr_user_id , $str_user_id);
				}
				
				if(in_array($user_id,$arr_user_id) || $arr_user_id[0] == '')
				{
					if(chkIfUserIsAdvisersReferrals($practitioner_id,$user_id))
					{
						$chk_next = true;
					}
				}
			}		
		}
		
		if($chk_next)
		{
			if($country_id == '0')
			{
				$chk_next = true;
			}
			elseif($country_id == $user_country_id)
			{
				$chk_next = true;
			}
			else
			{
				$chk_next = false;
			}
		}
		
		if($chk_next)
		{
			if($str_state_id == '')
			{
				$chk_next = true;
			}
			else
			{
				$arr_state_id = array();
				$pos1 = strpos($str_state_id, ',');
				if ($pos1 !== false) 
				{
					$arr_state_id = explode(',',$str_state_id);
				}
				else
				{
					array_push($arr_state_id , $str_state_id);
				}
				
				if(in_array($state_id,$arr_state_id) || $arr_state_id[0] == '')
				{
					$chk_next = true;
				}
				else
				{
					$chk_next = false;
				}	
			}
		}	
			
		if($chk_next)
		{
			if($str_city_id == '')
			{
				$chk_next = true;
			}
			else
			{
				$arr_city_id = array();
				$pos2 = strpos($str_city_id, ',');
				if ($pos2 !== false) 
				{
					$arr_city_id = explode(',',$str_city_id);
				}
				else
				{
					array_push($arr_city_id , $str_city_id);
				}
				
				if(in_array($city_id,$arr_city_id) || $arr_city_id[0] == '')
				{
					$chk_next = true;
				}
				else
				{
					$chk_next = false;
				}	
			}
		}	
		
		if($chk_next)
		{
			if($str_place_id == '')
			{
				$chk_next = true;
			}
			else
			{
				$arr_place_id = array();
				$pos3 = strpos($str_place_id, ',');
				if ($pos3 !== false) 
				{
					$arr_place_id = explode(',',$str_place_id);
				}
				else
				{
					array_push($arr_place_id , $str_place_id);
				}
				
				if(in_array($place_id,$arr_place_id) || $arr_place_id[0] == '')
				{
					$chk_next = true;
				}
				else
				{
					$chk_next = false;
				}	
			}
		}		
			
		if($chk_next)
		{
			$add_to_record = true;
		}
	}		
	return $add_to_record;
}
function getSleepQuestions($user_id,$sleep_date,$pro_user_id) 
{
	global $link;
	$return = false;
	$arr_sleep_id = array();
	$arr_situation = array();
	$arr_situation_font_family = array();
	$arr_situation_font_size = array();
	$arr_situation_font_color = array();
	
	$today_day = date('j',strtotime($sleep_date));
	$today_date = date('Y-m-d',strtotime($sleep_date));
	
	if($pro_user_id != '')
	{
		if($pro_user_id == '999999999')
		{
			$sql_str_pro = " AND ( `practitioner_id` = '0' ) ";
		}
		else
		{
			$sql_str_pro = " AND ( `practitioner_id` = '".$pro_user_id."' ) ";
		}
		
		$sql = "SELECT * FROM `tblsleeps` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `listing_order` ASC , `sleep_add_date` DESC ";
		//echo '<br>'.$sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$return = true;
			while ($row = mysql_fetch_assoc($result)) 
			{
				$practitioner_id = $row['practitioner_id'];
				$str_user_id = $row['user_id'];
				$country_id = $row['country_id'];
				$str_state_id = $row['state_id'];
				$str_city_id = $row['city_id'];
				$str_place_id = $row['place_id'];
				
				$add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
				
				if($add_to_record)
				{
					array_push($arr_sleep_id , $row['sleep_id']);
					array_push($arr_situation , stripslashes($row['situation']));
					array_push($arr_situation_font_family , stripslashes($row['situation_font_family']));
					array_push($arr_situation_font_size , stripslashes($row['situation_font_size']));
					array_push($arr_situation_font_color , stripslashes($row['situation_font_color']));
				}	
			}
		}
	}		
	return array($arr_sleep_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color);	
}

function getAdctQuestions($user_id,$adct_date,$pro_user_id) 
{
	global $link;
	$return = false;
	$arr_adct_id = array();
	$arr_situation = array();
	$arr_situation_font_family = array();
	$arr_situation_font_size = array();
	$arr_situation_font_color = array();
	
	$today_day = date('j',strtotime($adct_date));
	$today_date = date('Y-m-d',strtotime($adct_date));
	
	if($pro_user_id != '')
	{
		if($pro_user_id == '999999999')
		{
			$sql_str_pro = " AND ( `practitioner_id` = '0' ) ";
		}
		else
		{
			$sql_str_pro = " AND ( `practitioner_id` = '".$pro_user_id."' ) ";
		}
		
		$sql = "SELECT * FROM `tbladdictions` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `listing_order` ASC , `adct_add_date` DESC ";
		//echo '<br>'.$sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$return = true;
			while ($row = mysql_fetch_assoc($result)) 
			{
				$practitioner_id = $row['practitioner_id'];
				$str_user_id = $row['user_id'];
				$country_id = $row['country_id'];
				$str_state_id = $row['state_id'];
				$str_city_id = $row['city_id'];
				$str_place_id = $row['place_id'];
				
				$add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
				
				if($add_to_record)
				{
					array_push($arr_adct_id , $row['adct_id']);
					array_push($arr_situation , stripslashes($row['situation']));
					array_push($arr_situation_font_family , stripslashes($row['situation_font_family']));
					array_push($arr_situation_font_size , stripslashes($row['situation_font_size']));
					array_push($arr_situation_font_color , stripslashes($row['situation_font_color']));
				}	
			}
		}
	}	
	return array($arr_adct_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color);	
}

function getWAEQuestions($user_id,$wae_date,$pro_user_id) 
{
	global $link;
	$return = false;
	$arr_wae_id = array();
	$arr_situation = array();
	$arr_situation_font_family = array();
	$arr_situation_font_size = array();
	$arr_situation_font_color = array();
	
	$today_day = date('j',strtotime($wae_date));
	$today_date = date('Y-m-d',strtotime($wae_date));
	
	if($pro_user_id != '')
	{
		if($pro_user_id == '999999999')
		{
			$sql_str_pro = " AND ( `practitioner_id` = '0' ) ";
		}
		else
		{
			$sql_str_pro = " AND ( `practitioner_id` = '".$pro_user_id."' ) ";
		}
		
		$sql = "SELECT * FROM `tblworkandenvironments` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `listing_order` ASC , `wae_add_date` DESC ";
		//echo '<br>'.$sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$return = true;
			while ($row = mysql_fetch_assoc($result)) 
			{
				$practitioner_id = $row['practitioner_id'];
				$str_user_id = $row['user_id'];
				$country_id = $row['country_id'];
				$str_state_id = $row['state_id'];
				$str_city_id = $row['city_id'];
				$str_place_id = $row['place_id'];
				
				$add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
				
				if($add_to_record)
				{
					array_push($arr_wae_id , $row['wae_id']);
					array_push($arr_situation , stripslashes($row['situation']));
					array_push($arr_situation_font_family , stripslashes($row['situation_font_family']));
					array_push($arr_situation_font_size , stripslashes($row['situation_font_size']));
					array_push($arr_situation_font_color , stripslashes($row['situation_font_color']));
				}	
			}
		}
	}	
	return array($arr_wae_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color);	
}

function getGSQuestions($user_id,$gs_date,$pro_user_id) 
{
	global $link;
	$return = false;
	$arr_gs_id = array();
	$arr_situation = array();
	$arr_situation_font_family = array();
	$arr_situation_font_size = array();
	$arr_situation_font_color = array();
	
	$today_day = date('j',strtotime($gs_date));
	$today_date = date('Y-m-d',strtotime($gs_date));
	
	if($pro_user_id != '')
	{
		if($pro_user_id == '999999999')
		{
			$sql_str_pro = " AND ( `practitioner_id` = '0' ) ";
		}
		else
		{
			$sql_str_pro = " AND ( `practitioner_id` = '".$pro_user_id."' ) ";
		}
		
		$sql = "SELECT * FROM `tblgeneralstressors` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `listing_order` ASC , `gs_add_date` DESC ";
		//echo '<br>'.$sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$return = true;
			while ($row = mysql_fetch_assoc($result)) 
			{
				$practitioner_id = $row['practitioner_id'];
				$str_user_id = $row['user_id'];
				$country_id = $row['country_id'];
				$str_state_id = $row['state_id'];
				$str_city_id = $row['city_id'];
				$str_place_id = $row['place_id'];
				
				$add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
				
				if($add_to_record)
				{
					array_push($arr_gs_id , $row['gs_id']);
					array_push($arr_situation , stripslashes($row['situation']));
					array_push($arr_situation_font_family , stripslashes($row['situation_font_family']));
					array_push($arr_situation_font_size , stripslashes($row['situation_font_size']));
					array_push($arr_situation_font_color , stripslashes($row['situation_font_color']));
				}	
			}
		}
	}	
	return array($arr_gs_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color);	
}

function getMCQuestions($user_id,$mc_date,$pro_user_id) 
{
	global $link;
	$return = false;
	$arr_mc_id = array();
	$arr_situation = array();
	$arr_situation_font_family = array();
	$arr_situation_font_size = array();
	$arr_situation_font_color = array();
	
	$today_day = date('j',strtotime($mc_date));
	$today_date = date('Y-m-d',strtotime($mc_date));
	
	if($pro_user_id != '')
	{
		if($pro_user_id == '999999999')
		{
			$sql_str_pro = " AND ( `practitioner_id` = '0' ) ";
		}
		else
		{
			$sql_str_pro = " AND ( `practitioner_id` = '".$pro_user_id."' ) ";
		}
		
		$sql = "SELECT * FROM `tblmycommunications` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro."  ORDER BY `listing_order` ASC , `mc_add_date` DESC ";
		//echo '<br>'.$sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$return = true;
			while ($row = mysql_fetch_assoc($result)) 
			{
				$practitioner_id = $row['practitioner_id'];
				$str_user_id = $row['user_id'];
				$country_id = $row['country_id'];
				$str_state_id = $row['state_id'];
				$str_city_id = $row['city_id'];
				$str_place_id = $row['place_id'];
				
				$add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
				
				if($add_to_record)
				{
					array_push($arr_mc_id , $row['mc_id']);
					array_push($arr_situation , stripslashes($row['situation']));
					array_push($arr_situation_font_family , stripslashes($row['situation_font_family']));
					array_push($arr_situation_font_size , stripslashes($row['situation_font_size']));
					array_push($arr_situation_font_color , stripslashes($row['situation_font_color']));
				}	
			}
		}
	}	
	return array($arr_mc_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color);	
}

function getMRQuestions($user_id,$mr_date,$pro_user_id) 
{
	global $link;
	$return = false;
	$arr_mr_id = array();
	$arr_situation = array();
	$arr_situation_font_family = array();
	$arr_situation_font_size = array();
	$arr_situation_font_color = array();
	
	$today_day = date('j',strtotime($mr_date));
	$today_date = date('Y-m-d',strtotime($mr_date));
	
	if($pro_user_id != '')
	{
		if($pro_user_id == '999999999')
		{
			$sql_str_pro = " AND ( `practitioner_id` = '0' ) ";
		}
		else
		{
			$sql_str_pro = " AND ( `practitioner_id` = '".$pro_user_id."' ) ";
		}
		
		$sql = "SELECT * FROM `tblmyrelations` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `listing_order` ASC , `mr_add_date` DESC ";
		//echo '<br>'.$sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$return = true;
			while ($row = mysql_fetch_assoc($result)) 
			{
				$practitioner_id = $row['practitioner_id'];
				$str_user_id = $row['user_id'];
				$country_id = $row['country_id'];
				$str_state_id = $row['state_id'];
				$str_city_id = $row['city_id'];
				$str_place_id = $row['place_id'];
				
				$add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
				
				if($add_to_record)
				{
					array_push($arr_mr_id , $row['mr_id']);
					array_push($arr_situation , stripslashes($row['situation']));
					array_push($arr_situation_font_family , stripslashes($row['situation_font_family']));
					array_push($arr_situation_font_size , stripslashes($row['situation_font_size']));
					array_push($arr_situation_font_color , stripslashes($row['situation_font_color']));
				}	
			}
		}
	}	
	return array($arr_mr_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color);	
}
function getMLEQuestions($user_id,$mle_date,$pro_user_id) 
{
	global $link;
	$return = false;
	$arr_mle_id = array();
	$arr_situation = array();
	$arr_situation_font_family = array();
	$arr_situation_font_size = array();
	$arr_situation_font_color = array();
	
	$today_day = date('j',strtotime($mle_date));
	$today_date = date('Y-m-d',strtotime($mle_date));
	
	if($pro_user_id != '')
	{
		if($pro_user_id == '999999999')
		{
			$sql_str_pro = " AND ( `practitioner_id` = '0' ) ";
		}
		else
		{
			$sql_str_pro = " AND ( `practitioner_id` = '".$pro_user_id."' ) ";
		}
		
		$sql = "SELECT * FROM `tblmajorlifeevents` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `listing_order` ASC , `mle_add_date` DESC ";
		//echo '<br>'.$sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$return = true;
			while ($row = mysql_fetch_assoc($result)) 
			{
				$practitioner_id = $row['practitioner_id'];
				$str_user_id = $row['user_id'];
				$country_id = $row['country_id'];
				$str_state_id = $row['state_id'];
				$str_city_id = $row['city_id'];
				$str_place_id = $row['place_id'];
				
				$add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
				
				if($add_to_record)
				{
					array_push($arr_mle_id , $row['mle_id']);
					array_push($arr_situation , stripslashes($row['situation']));
					array_push($arr_situation_font_family , stripslashes($row['situation_font_family']));
					array_push($arr_situation_font_size , stripslashes($row['situation_font_size']));
					array_push($arr_situation_font_color , stripslashes($row['situation_font_color']));
				}	
			}
		}
	}	
	return array($arr_mle_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color);	
}

function getPlaceOptionsMulti($country_id,$arr_state_id,$arr_city_id,$arr_place_id)
{
	global $link;
	$option_str = '';
	
	if(count($arr_city_id) > 0)
	{
		if($country_id == '' || $country_id == '0')
		{
			$str_sql_country_id = "";
		}
		else
		{
			$str_sql_country_id = " AND `country_id` = '".$country_id."' ";
		}
		
		if($arr_state_id[0] == '')
		{
			$str_sql_state_id = "";
		}
		else
		{
			$str_state_id = implode(',',$arr_state_id);
			$str_sql_state_id = " AND `state_id` IN (".$str_state_id.") ";
		}
				
		if($arr_city_id[0] == '')
		{
			$str_sql_city_id = "";
		}
		else
		{
			$str_city_id = implode(',',$arr_city_id);
			$str_sql_city_id = " AND `city_id` IN (".$str_city_id.") ";
		}
		
		$sql = "SELECT * FROM `tblplaces` WHERE 1  ".$str_sql_country_id." ".$str_sql_state_id."  ".$str_sql_city_id." ORDER BY `place` ASC";
		//echo $sql;	
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			while($row = mysql_fetch_array($result) ) 
			{
				if(in_array($row['place_id'],$arr_place_id))
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				$option_str .= '<option value="'.$row['place_id'].'" '.$sel.'>'.stripslashes($row['place']).'</option>';
			}
		}
	}	
	return $option_str;
}
function getCityOptionsMulti($country_id,$arr_state_id,$arr_city_id)
{
	global $link;
	$option_str = '';
	
	if(count($arr_state_id) > 0)
	{
		if($country_id == '' || $country_id == '0')
		{
			$str_sql_country_id = "";
		}
		else
		{
			$str_sql_country_id = " AND `country_id` = '".$country_id."' ";
		}
		
		if($arr_state_id[0] == '')
		{
			$str_sql_state_id = "";
		}
		else
		{
			$str_state_id = implode(',',$arr_state_id);
			$str_sql_state_id = " AND `state_id` IN (".$str_state_id.") ";
		}
		
		$sql = "SELECT * FROM `tblcities` WHERE 1  ".$str_sql_country_id." ".$str_sql_state_id." ORDER BY `city` ASC";
		//echo $sql;	
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			while($row = mysql_fetch_array($result) ) 
			{
				if(in_array($row['city_id'],$arr_city_id))
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				$option_str .= '<option value="'.$row['city_id'].'" '.$sel.'>'.stripslashes($row['city']).'</option>';
			}
		}
	}	
	return $option_str;
}
function getStateOptionsMulti($country_id,$arr_state_id)
{
	global $link;
	$option_str = '';
	
	if($country_id == '' || $country_id == '0')
	{		
		$sql = "SELECT * FROM `tblstates` ORDER BY `state` ASC";
	}
	else
	{
		$sql = "SELECT * FROM `tblstates` WHERE `country_id` = '".$country_id."' ORDER BY `state` ASC";
	}	
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			if(in_array($row['state_id'],$arr_state_id))
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['state_id'].'" '.$sel.'>'.$row['state'].'</option>';
		}
	}
	return $option_str;
}
	
function getDestinationOptions($destination_id,$country_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tbldestinations` WHERE `country_id` = '".$country_id."' AND `destination_status` = '1' AND `destination_deleted` = '0' ORDER BY `destination` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			if($row['destination_id'] == $destination_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['destination_id'].'" '.$sel.'>'.stripslashes($row['destination']).'</option>';
		}
	}
	return $option_str;
}

function getCountryOptions($country_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblcountry` ORDER BY `country_name` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			if($row['country_id'] == $country_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['country_id'].'" '.$sel.'>'.stripslashes($row['country_name']).'</option>';
		}
	}
	return $option_str;
}

function getUserRegistrationDateByEmail($email)
{
	global $link;
	$user_add_date = '';
		
    $sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."'";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$user_add_date = date('d/m/Y h:i:s A',stripslashes($row['user_add_date']));
		
	}
       
	return $user_add_date;
}

//
//function added on 5/2/14 by Ramakant
//
//
function addreferafriend($tdata)
{	
	global $link;
	$id = 0;
	  
	$sql = "INSERT INTO `tblreferal` (`email_id` ,`user_id`, `name` ,`message`,`status`) 
			VALUES ('".addslashes($tdata['email'])."','".addslashes($tdata['user_id'])."','".addslashes($tdata['user_name'])."','".addslashes($tdata['message'])."','0')";
	
	$result = mysql_query($sql,$link);
	if($result)
	{
		$id = mysql_insert_id($link);
	}
		
	return $id;  	
   
}
function is_user($email)
{
      global $link;
    $temp_arr=array();
    $sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."'";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		if(mysql_num_rows($result) >= 1)
                {
                    return true;
                }
                else
                {
                    return false;
                } 
	}
       

}
function is_refered($email)
{
    global $link;
    $sql = "SELECT * FROM `tblreferal` WHERE `email_id` = '".$email."'";
	 
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            return true;
	}
        else
        {
            return false;
        }
        
        

}
 
function updatereferafriend($tdata,$email)
{	
	global $link;
	$return = false;
	$sql = "UPDATE `tblreferal` set `status` = '1' WHERE id = '".$tdata['id']."' AND `user_id` = '".$tdata['uid']."' AND `email_id` = '".$email."'";
	 
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
	 
}
function get_all_refered($user_id)
{
    global $link;
	$temp_arr = array();
    
    $sql = "SELECT * FROM `tblreferal` WHERE `user_id` = '".$user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_assoc($result))
		{
			$temp_arr[] = $row;
		}
	}
	return $temp_arr;
}


function ViewUserReferral($user_id,$start_date,$end_date)
  	{
				
		list($arr_email_id,$arr_status,$arr_date,$arr_user_name) = View_user_referral($user_id,$start_date,$end_date);
		
		$output .='<table border="0" width="100%" cellpadding="7" cellspacing="1">
						<tr class="manage-header">
							<td width="10%" class="manage-header" align="center">Sno</td>
							<td width="20%" class="manage-header" align="center">User Name</td>
							<td width="20%" class="manage-header" align="center">Referred Email ID</td>
							<td width="20%" class="manage-header" align="center">Invitation Sent Date</td>
                            <td width="20%" class="manage-header" align="center">Accepted Date</td>
							<td width="10%" class="manage-header" align="center">Status</td>
						</tr>';
						
					for($i=0,$j=1;$i<count($arr_email_id);$i++,$j++)
                                        {   
						if($arr_status[$i] == 1)
						{
							$status = 'Registered';
						}
						else
						{
							$status = 'Pending';
						}
					
                                                $output .='<tr class="manage-row">
						 <td align="center">'.$j.'</td>
						 <td align="center">'.$arr_user_name[$i].'</td>
						 <td align="center">'.$arr_email_id[$i].'</td>
						 <td align="center">'.date('d/m/Y h:i:s A',strtotime($arr_date[$i])).'</td>
						 <td align="center">'.getUserRegistrationDateByEmail($arr_email_id[$i]).'</td>
						 <td align="center">'.$status.'</td>';
                                               $output .='</tr>';
                                          }
					   if(count($arr_email_id) == '0')
					   {
                                                $output .='<tr class="manage-row" height="20">
						  <td align="center" colspan="6">No Records Found</td>  
                                                     </tr>';
					   }		   
								
			$output .='</table>';
	 
	return $output;
}

function getMealTimeChart($user_id,$start_date,$end_date,$permission_type = '0',$pro_user_id = '0',$scale_range = '',$start_scale_value = '',$end_scale_value = '',$report_module = '',$module_keyword = '',$module_criteria = '',$criteria_scale_range = '',$start_criteria_scale_value = '',$end_criteria_scale_value = '') 
{
	global $link;
	$return = false;
	$arr_records = array();
	
        
        if($module_criteria == '4')
        {
            if($criteria_scale_range == '1')
            {
                $sql_str_report_module_criteria = " AND `meal_time` < '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '2')
            {
                $sql_str_report_module_criteria = " AND `meal_time` > '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '3')
            {
                $sql_str_report_module_criteria = " AND `meal_time` <= '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '4')
            {
                $sql_str_report_module_criteria = " AND `meal_time` >= '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '5')
            {
                $sql_str_report_module_criteria = " AND `meal_time` = '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '6')
            {
                $sql_str_report_module_criteria = " AND `meal_time` >= '".$start_criteria_scale_value."' AND `meal_time` <= '".$end_criteria_scale_value."'";
            }
            else
            {
                $sql_str_report_module_criteria = "";
            }
        }
        elseif($module_criteria == '7')
        {
            if($criteria_scale_range == '5')
            {
                $sql_str_report_module_criteria = " AND DAYOFWEEK(meal_date) = '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '6')
            {
                $sql_str_report_module_criteria = " AND DAYOFWEEK(meal_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(meal_date) <= '".$end_criteria_scale_value."' ";
            }
            else
            {
                $sql_str_report_module_criteria = "";
            }
        }
        else
        {
            $sql_str_report_module_criteria = "";
        }
	
	$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' ".$sql_str_report_module_criteria." ORDER BY `meal_date` DESC ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while ($row = mysql_fetch_assoc($result)) 
            {
                $sql2 = "SELECT * FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` = '".$row['meal_date']."' ".$sql_str_report_module_criteria." ORDER BY `user_meal_id` ASC ";
                //echo "<br>".$sql2;
                $result2 = mysql_query($sql2,$link);
                if( ($result2) && (mysql_num_rows($result2) > 0) )
                {
                    $total_meal_entry = 0;
                    $return = true;
                    while ($row2 = mysql_fetch_assoc($result2)) 
                    {
                        $total_meal_entry++;
                        if($row2['meal_type'] == 'breakfast')
                        {
                            $arr_records[$row['meal_date']]['breakfast_time'] = $row2['meal_time'];
                        }
                        elseif($row2['meal_type'] == 'brunch')
                        {
                            $arr_records[$row['meal_date']]['brunch_time'] = $row2['meal_time'];
                        }
                        elseif($row2['meal_type'] == 'lunch')
                        {
                            $arr_records[$row['meal_date']]['lunch_time'] = $row2['meal_time'];
                        }
                        elseif($row2['meal_type'] == 'snacks')
                        {
                            $arr_records[$row['meal_date']]['snacks_time'] = $row2['meal_time'];
                        }
                        elseif($row2['meal_type'] == 'dinner')
                        {
                            $arr_records[$row['meal_date']]['dinner_time'] = $row2['meal_time'];
                        }	
                    }
                    $arr_records[$row['meal_date']]['total_entry_per_day'] = $total_meal_entry;
                }
            }
	}
	
	return array($return,$arr_records);	
}

function getMealTimeChartHTML($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$output = '';
	list($return,$arr_date,$arr_brunch_time,$arr_lunch_time,$arr_snacks_time,$arr_dinner_time,$arr_breakfast_time,$total_meal_entry)= getMealTimeChart($user_id,$start_date,$end_date);
	if( ($return) && ( count($arr_date) > 0 ) )
	{
		$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Meal Time Chart</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="150" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong>to </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="140" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>Name</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getUserFullNameById($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getUserUniqueId($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>Age</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getAgeOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>Height</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getHeightOfUser($user_id). ' cms</td>
							<td height="30" align="left" valign="middle"><strong>Weight</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getWeightOfUser($user_id). ' Kgs</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>BMI</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getBMIOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>BMI Observations</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getBMRObservationOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong><strong>No of days</strong></strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.count($arr_date).'</td>
							<td height="30" align="left" valign="middle"><strong>Total Meals Entry</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.$total_meal_entry.'</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>	
							<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
					
		$output .= '<table width="1150" height="30" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
						<tr>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">SNo</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date/Days</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Breakfast</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Brunch</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Lunch</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Snacks</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Dinner</td>
						</tr>	';	
					for($i=0,$j=1;$i<count($arr_date);$i++,$j++)
					{
					
					if($arr_breakfast_time[$arr_date[$i]]=='')
						{
						 $breakfast_time='NA';
						}
						else
						{
						 $breakfast_time=$arr_breakfast_time[$arr_date[$i]];
						}
						if($arr_brunch_time[$arr_date[$i]]=='')
						{
						 $brunch_time='NA';
						 }
						else
						{
						 $brunch_time=$arr_brunch_time[$arr_date[$i]];
						 }
						
						if($arr_lunch_time[$arr_date[$i]]=='')
						{
						 $lunch_time='NA';
						 }
						else
						{ 
						$lunch_time=$arr_lunch_time[$arr_date[$i]];
						}
						
						if($arr_snacks_time[$arr_date[$i]]=='')
						{ 
						$snacks_time='NA';
						}
						else
						{
						 $snacks_time=$arr_snacks_time[$arr_date[$i]];
						 }
						
						if($arr_dinner_time[$arr_date[$i]]=='')
						{ 
						$dinner_time='NA';
						}
						else
						{
						$dinner_time=$arr_dinner_time[$arr_date[$i]];
						}
					
		$output .= '	<tr>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$j.'</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($arr_date[$i])).'<br />('.date("l",strtotime($arr_date[$i])).')</td>
								<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$breakfast_time.'</td>
								<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$brunch_time.'</td>
								<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$lunch_time.'</td>
								<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$snacks_time.'</td>
								<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$dinner_time.'</td>
						</tr>';
					}
		$output .= '</table>';			 
					
		$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Users Note:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Things i would like to change:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>

						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Benefits  I noticed from the changes:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>

						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
					</tbody>
					</table>';					            				
	}
	return $output;	
}

function getAngerVentIntensityReport($user_id,$start_date,$end_date)
{
	global $link;
	
	$uavb_return = false;
	$arr_uavb_date = array();
	$arr_intensity_scale_1 = array();
	$arr_intensity_scale_1_image = array();
	$arr_intensity_scale_2 = array();
	$arr_intensity_scale_2_image = array();
	$arr_comment_box = array();
	
	$start_date .= ' 00:00:00';
	$end_date .= ' 23:59:59';
	
	$sql = "SELECT * FROM `tbluseravb` WHERE `user_id` = '".$user_id."' AND uavb_add_date >= '".$start_date."' AND uavb_add_date <= '".$end_date."' ORDER BY `uavb_add_date` ASC ";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			if( ($row['intensity_scale_1'] > 0) || ($row['intensity_scale_2'] > 0) )
			{
				$uavb_return = true;
				array_push($arr_uavb_date,$row['uavb_add_date']);
				array_push($arr_intensity_scale_1,getScaleValue($row['intensity_scale_1']));
				array_push($arr_intensity_scale_1_image,getScaleImage($row['intensity_scale_1']));
				array_push($arr_intensity_scale_2,getScaleValue($row['intensity_scale_2']));
				array_push($arr_intensity_scale_2_image,getScaleImage($row['intensity_scale_2'])); 
				array_push($arr_comment_box, $row['user_stressed']);
			}	
		}
	}		
	return array($uavb_return,$arr_uavb_date,$arr_intensity_scale_1,$arr_intensity_scale_1_image,$arr_intensity_scale_2,$arr_intensity_scale_2_image,$arr_comment_box);
}

function getAngerVentIntensityReportHTML($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$output = '';
	list($uavb_return,$arr_uavb_date,$arr_intensity_scale_1,$arr_intensity_scale_1_image,$arr_intensity_scale_2,$arr_intensity_scale_2_image,$arr_comment_box)= getAngerVentIntensityReport($user_id,$start_date,$end_date);
	if( ($uavb_return) && ( count($arr_uavb_date) > 0 ) )
	{
		$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td colspan="9" height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Angervent Intensity Report</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="150" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong>to </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="140" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>Name</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getUserFullNameById($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getUserUniqueId($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>Age</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getAgeOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>Height</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getHeightOfUser($user_id). ' cms</td>
							<td height="30" align="left" valign="middle"><strong>Weight</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getWeightOfUser($user_id). ' Kgs</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>BMI</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getBMIOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>BMI Observations</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getBMRObservationOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left" colspan="12"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
					
		$output .= '<table width="1150" border="1" cellpadding="0" cellspacing="3" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
						<tr>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date/Days</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">First Scale</td>
							<td height="50" colspan="4" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Slider</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Last Scale</td>
							<td height="50" colspan="7" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Slider</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Comment</td>
						</tr>	';	
					for($i=0,$j=1;$i<count($arr_uavb_date);$i++,$j++)
					{
		$output .= '	<tr>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y h:i:s",strtotime($arr_uavb_date[$i])). '( '.date("l",strtotime($arr_uavb_date[$i])).')</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_intensity_scale_1[$i].'</td>
							<td height="50" colspan="4" align="center" valign="middle" bgcolor="#FFFFFF">
							<img src="'.SITE_URL.'/images/'.$arr_intensity_scale_1_image[$i].'" width="320" height="30" border="0" /></td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_intensity_scale_2[$i].'</td>
							<td height="50" colspan="7" align="center" valign="middle" bgcolor="#FFFFFF"><img src="'.SITE_URL.'/images/'.$arr_intensity_scale_2_image[$i].'" width="320" height="30" border="0" /></td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_comment_box[$i].'</td>
						</tr>';
					}
		$output .= '</table>';			 
					
		$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left" height="30" colspan="15" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Users Note:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" colspan="15" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Things i would like to change:</strong></td>
						</tr>
						<tr>	
							<td align="left" colspan="15" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" colspan="15" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>

						<tr>	
							<td align="left" colspan="15" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" colspan="15" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" colspan="15" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" colspan="15" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Benefits  I noticed from the changes:</strong></td>
						</tr>
						<tr>	
							<td align="left" colspan="15" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" colspan="15" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>

						<tr>	
							<td align="left" colspan="15" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" colspan="15" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" colspan="15" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
					</tbody>
					</table>';					            				
	}
	return $output;	
}

function getStressBusterIntensityReport($user_id,$start_date,$end_date)
{
	global $link;
	
	$usbb_return = false;
	$arr_usbb_date = array();
	$arr_intensity_scale_1 = array();
	$arr_intensity_scale_1_image = array();
	$arr_intensity_scale_2 = array();
	$arr_intensity_scale_2_image = array();
	$arr_comment_box = array();
	
	$start_date .= ' 00:00:00';
	$end_date .= ' 23:59:59';
	
	$sql = "SELECT * FROM `tbluserssbb` WHERE `user_id` = '".$user_id."' AND usbb_add_date >= '".$start_date."' AND usbb_add_date <= '".$end_date."' ORDER BY `usbb_add_date` ASC ";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			if( ($row['intensity_scale_1'] > 0) || ($row['intensity_scale_2'] > 0) )
			{
				$usbb_return = true;
				array_push($arr_usbb_date,$row['usbb_add_date']);
				array_push($arr_intensity_scale_1,getScaleValue($row['intensity_scale_1']));
				array_push($arr_intensity_scale_1_image,getScaleImage($row['intensity_scale_1']));
				array_push($arr_intensity_scale_2,getScaleValue($row['intensity_scale_2']));
				array_push($arr_intensity_scale_2_image,getScaleImage($row['intensity_scale_2']));
				array_push($arr_comment_box, $row['user_stressed']);
			}	
		}
	}		
	return array($usbb_return,$arr_usbb_date,$arr_intensity_scale_1,$arr_intensity_scale_1_image,$arr_intensity_scale_2,$arr_intensity_scale_2_image,$arr_comment_box);
}

function getStressBusterIntensityReportHTML($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$output = '';
	list($usbb_return,$arr_usbb_date,$arr_intensity_scale_1,$arr_intensity_scale_1_image,$arr_intensity_scale_2,$arr_intensity_scale_2_image)= getStressBusterIntensityReport($user_id,$start_date,$end_date);
	if( ($usbb_return) && ( count($arr_usbb_date) > 0 ) )
	{
		$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td height="50" align="center" colspan="12" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Stressbuster Intensity Report</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="150" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong>to </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="140" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>Name</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getUserFullNameById($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getUserUniqueId($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>Age</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getAgeOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>Height</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getHeightOfUser($user_id). ' cms</td>
							<td height="30" align="left" valign="middle"><strong>Weight</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getWeightOfUser($user_id). ' Kgs</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>BMI</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getBMIOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>BMI Observations</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getBMRObservationOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td colspan="12" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left" colspan="12"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
					
		$output .= '<table width="1150" border="1" cellpadding="0" cellspacing="3" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
						<tr>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date/Days</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">First Scale</td>
							<td height="50" colspan="4" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">slider</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Last Scale</td>
							<td height="50" colspan="7" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">slider</td>
							<td height="50"  colspan="2"align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Comment</td>
						</tr>	';	
					for($i=0,$j=1;$i<count($arr_usbb_date);$i++,$j++)
					{
		$output .= '	<tr>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y h:i:s",strtotime($arr_usbb_date[$i])). '( '.date("l",strtotime($arr_usbb_date[$i])).')</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_intensity_scale_1[$i].'</td>
							<td height="50" colspan="4" align="center" valign="middle" bgcolor="#FFFFFF">
							<img src="'.SITE_URL.'/images/'.$arr_intensity_scale_1_image[$i].'" width="320" height="30" border="0" /></td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_intensity_scale_2[$i].'</td>
							<td height="50" colspan="7" align="center" valign="middle" bgcolor="#FFFFFF">
							<img src="'.SITE_URL.'/images/'.$arr_intensity_scale_2_image[$i].'" width="320" height="30" border="0" /></td>
							<td height="50" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_comment_box[$i].'</td>
						</tr>';
					}
		$output .= '</table>';			 
					
		$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left" height="30" colspan="16" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Users Note:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" colspan="16" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Things i would like to change:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" colspan="16" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" colspan="16" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>

						<tr>	 
							<td align="left" height="30" colspan="16" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" colspan="16" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" colspan="16" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" colspan="16" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Benefits  I noticed from the changes:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" colspan="16" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" colspan="16" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>

						<tr>	
							<td align="left" height="30" colspan="16" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" colspan="16" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" colspan="16" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
					</tbody>
					</table>';					            				
	}
	return $output;	
}
?>