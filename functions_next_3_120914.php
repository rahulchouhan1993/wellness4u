<?php
function getUserTypeSelectedEmailList($ult_id,$country_id,$arr_state_id,$arr_city_id,$arr_place_id,$arr_selected_user_id,$arr_selected_adviser_id,$arr_ap_id,$arr_up_id)
{
	global $link;
	$output = '';
		
	if($ult_id == '1')
	{
		$sql = "SELECT * FROM `tblusers` WHERE `status` = '1' ORDER BY `name` ASC";
	}
	elseif($ult_id == '2')
	{
		$sql = "SELECT * FROM `tblprofusers` WHERE `status` = '1' ORDER BY `name` ASC";
	}
	elseif($ult_id == '3')
	{
		if(count($arr_up_id) > 0 && $arr_up_id[0] != '')
		{
			$str_up_id = implode(',',$arr_up_id);
			
			$sql = "SELECT tu.* FROM `tbluserplanrequests` AS tupr LEFT JOIN `tblusers` AS tu ON tupr.user_id = tu.user_id LEFT JOIN `tbluserplans` AS tup ON tupr.up_id = tup.up_id WHERE tup.up_id IN (".$str_up_id.") ORDER BY tu.name ASC";
		}
		else
		{
			$sql = "SELECT * FROM `tblusers` WHERE `status` = '1' ORDER BY `name` ASC";
		}
	}
	elseif($ult_id == '4')
	{
		if(count($arr_ap_id) > 0 && $arr_ap_id[0] != '')
		{
			$str_ap_id = implode(',',$arr_ap_id);
			
			$sql = "SELECT tpu.* FROM `tbladviserplanrequests` AS tapr LEFT JOIN `tblprofusers` AS tpu ON tapr.pro_user_id = tpu.pro_user_id LEFT JOIN `tbladviserplans` AS tap ON tapr.ap_id = tap.ap_id WHERE tap.ap_id IN (".$str_ap_id.") ORDER BY tpu.name ASC";
		}
		else
		{
			$sql = "SELECT * FROM `tblprofusers` WHERE `status` = '1' ORDER BY `name` ASC";
		}
	}
	elseif($ult_id == '5')
	{
		if($country_id == '')
		{
			$sql_str_country_id = '';
		}
		else
		{
			$sql_str_country_id = " AND `country_id` = '".$country_id."' ";
		}
		
		if(count($arr_state_id) > 0 && $arr_state_id[0] != '')
		{
			$str_state_id = implode(',',$arr_state_id);
			$sql_str_state_id = " AND `state_id` IN (".$str_state_id.") ";
		}
		else
		{
			$sql_str_state_id = '';	
		}
		
		if(count($arr_city_id) > 0  && $arr_city_id[0] != '')
		{
			if(count($arr_city_id) == 1)
			{
				$str_city_id = $arr_city_id[0];
			}
			else
			{
				$str_city_id = implode(',',$arr_city_id);
			}
			
			$sql_str_city_id = " AND `city_id` IN (".$str_city_id.") ";
		}
		else
		{
			$sql_str_city_id = '';	
		}
		
		if(count($arr_place_id) > 0 && $arr_place_id[0] != '')
		{
			$str_place_id = implode(',',$arr_place_id);
			$sql_str_place_id = " AND `place_id` IN (".$str_place_id.") ";
		}
		else
		{
			$sql_str_place_id = '';	
		}
		
		$sql = "SELECT * FROM `tblusers` WHERE `status` = '1' ".$sql_str_country_id." ".$sql_str_state_id." ".$sql_str_city_id." ".$sql_str_place_id." ORDER BY `name` ASC";
	}
	elseif($ult_id == '6')
	{
		if($country_id == '')
		{
			$sql_str_country_id = '';
		}
		else
		{
			$sql_str_country_id = " AND `country_id` = '".$country_id."' ";
		}
		
		if(count($arr_state_id) > 0 && $arr_state_id[0] != '')
		{
			$str_state_id = implode(',',$arr_state_id);
			$sql_str_state_id = " AND `state_id` IN (".$str_state_id.") ";
		}
		else
		{
			$sql_str_state_id = '';	
		}
		
		if(count($arr_city_id) > 0 && $arr_city_id[0] != '')
		{
			$str_city_id = implode(',',$arr_city_id);
			$sql_str_city_id = " AND `city_id` IN (".$str_city_id.") ";
		}
		else
		{
			$sql_str_city_id = '';	
		}
		
		if(count($arr_place_id) > 0 && $arr_place_id[0] != '')
		{
			$str_place_id = implode(',',$arr_place_id);
			$sql_str_place_id = " AND `place_id` IN (".$str_place_id.") ";
		}
		else
		{
			$sql_str_place_id = '';	
		}
	
		$sql = "SELECT * FROM `tblprofusers` WHERE `status` = '1' ".$sql_str_country_id." ".$sql_str_state_id." ".$sql_str_city_id." ".$sql_str_place_id." ORDER BY `name` ASC";
	}
	else
	{
		$sql = "";
	}
	
	//$output .= $sql;
	if($sql != "")
	{
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$output .= '<div style="width:400px;float:left;margin-bottom:20px;">
							<input type="checkbox" name="all_selected_user_id" id="all_selected_user_id" value="1" onclick="toggleCheckBoxes(\'selected_user_id\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
						</div>';
			$output .= '<div style="width:400px;height:350px;float:left;overflow:scroll;">';
			$output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
			$i = 1;
			while($row = mysql_fetch_array($result) ) 
			{
				if($ult_id == '2' || $ult_id == '4' || $ult_id == '6')
				{
					$record_user_id = $row['pro_user_id'];
					$record_name = stripslashes($row['name']);
					$record_email = stripslashes($row['email']);
					
					if(in_array($record_user_id,$arr_selected_adviser_id) )
					{
						$selected = ' checked ';
					}
					else
					{
						$selected = '';
					}
				}	
				else
				{
					$record_user_id = $row['user_id'];
					$record_name = stripslashes($row['name']);
					$record_email = stripslashes($row['email']);	
					
					if(in_array($record_user_id,$arr_selected_user_id))
					{
						$selected = ' checked ';
					}
					else
					{
						$selected = '';
					}
				}
				
				$output .= '<li style="padding:0px;width:380px;float:left;"><input type="checkbox" '.$selected.' name="selected_user_id" id="selected_user_id_'.$i.'" value="'.$record_user_id.'" onclick="getSelectedUserListIds();" />&nbsp;<strong>'.$record_name.'&nbsp;&nbsp;('.$record_email.')</strong></li>';
				$i++;
			}
			$output .= '</div>';
		}
	}
	return $output;
}
function getBulkEmailCampaignDetails($email_ar_id)
{
	global $link;
	$email_ar_subject = '';
	$email_ar_from_name = 'Info';
	$email_ar_from_email = 'info@wellnessway4u.com';
	$email_ar_to_email = '';
	$email_ar_body = '';
	
	$sql = "SELECT * FROM `tblautoresponders` WHERE `email_ar_id` = '".$email_ar_id."' ";
	//echo '<br>'.$sql.'<br>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$email_ar_subject = stripslashes($row['email_ar_subject']);
		$email_ar_from_name = stripslashes($row['email_ar_from_name']);
		$email_ar_from_email = stripslashes($row['email_ar_from_email']);
		$email_ar_to_email = stripslashes($row['email_ar_to_email']);
		$email_ar_body = stripslashes($row['email_ar_body']);
	}
		
	return array($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body);
}
function getEmailAutoresponderDetails($email_action_id)
{
	global $link;
	$email_ar_subject = '';
	$email_ar_from_name = '';
	$email_ar_from_email = '';
	$email_ar_to_email = '';
	$email_ar_body = '';
	
	$sql = "SELECT * FROM `tblautoresponders` WHERE `email_action_id` = '".$email_action_id."' AND `email_ar_status` = '1' AND `email_ar_deleted` = '0' ORDER BY `email_ar_add_date` DESC LIMIT 1 ";
	//echo '<br>'.$sql.'<br>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$email_ar_subject = stripslashes($row['email_ar_subject']);
		$email_ar_from_name = stripslashes($row['email_ar_from_name']);
		$email_ar_from_email = stripslashes($row['email_ar_from_email']);
		$email_ar_to_email = stripslashes($row['email_ar_to_email']);
		$email_ar_body = stripslashes($row['email_ar_body']);
	}
		
	return array($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body);
}
function getEachMealPerDayDateListOptions($user_id,$start_date,$end_date,$date)
{
	global $link;
	$option_str = '';
	
	$sql = "SELECT DISTINCT(meal_date) FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` >= '".date('Y-m-d',strtotime($start_date))."' AND `meal_date` <= '".date('Y-m-d',strtotime($end_date))."' ORDER BY `meal_date` DESC ";
	//echo "<br>".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
		while ($row = mysql_fetch_assoc($result)) 
		{
			if($row['meal_date'] == $date)
			{
				$selected = ' selected ';
			}
			else
			{
				$selected = '';
			}
			$option_str .= '<option value="'.$row['meal_date'].'" '.$selected.' >'.date('d-m-Y',strtotime($row['meal_date'])).'</option>';
		}
	}
	return $option_str;
}
function getUserDefaultPlanId()
{
	global $link;
	$up_id = 0; 
	
	$sql = "SELECT * FROM `tbluserplans` WHERE `up_default` = '1' AND `up_status` = '1' AND `up_deleted` = '0' ORDER BY `up_add_date` DESC LIMIT 1";
	//echo '<br>'.$sql.'<br>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$up_id = $row['up_id'];
	}
		
	return $up_id;
}
function getAdviserDefaultPlanId()
{
	global $link;
	$ap_id = 0; 
	
	$sql = "SELECT * FROM `tbladviserplans` WHERE `ap_default` = '1' AND `ap_status` = '1' AND `ap_deleted` = '0' ORDER BY `ap_add_date` DESC LIMIT 1";
	//echo '<br>'.$sql.'<br>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$ap_id = $row['ap_id'];
	}
		
	return $ap_id;
}
function getAdviserCurrentActivatedPlanId($pro_user_id)
{
	global $link;
	$ap_id = 0; 
	
	$sql = "SELECT * FROM `tbladviserplanrequests` WHERE `pro_user_id` = '".$pro_user_id."' AND `apr_status` = '1' ORDER BY `apr_add_date` DESC LIMIT 1";
	//echo '<br>'.$sql.'<br>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$ap_id = $row['ap_id'];
	}
	else
	{
		$ap_id = getAdviserDefaultPlanId();
	}
	
	return $ap_id;
}
function getUserCurrentActivatedPlanId($user_id)
{
	global $link;
	$up_id = 0; 
	
	$sql = "SELECT * FROM `tbluserplanrequests` WHERE `user_id` = '".$user_id."' AND `upr_status` = '1' ORDER BY `upr_add_date` DESC LIMIT 1";
	//echo '<br>'.$sql.'<br>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$up_id = $row['up_id'];
	}
	else
	{
		$up_id = getUserDefaultPlanId();
	}
	
	return $up_id;
}
function chkIfPageEnableForScrollingBar($page_id)
{
	global $link;
	$return = false;
			
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."' AND `show_in_manage_menu` = '1' AND `show_in_list` = '1' ORDER BY `menu_title` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}
function getCommonSettingValue($cs_id)
{
	global $link;
	
	$cs_value = '';
			
	$sql = "SELECT * FROM `tblcommonsettings` WHERE `cs_id` = '".$cs_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_assoc($result);
		$cs_value = stripslashes($row['cs_value']);
	}
	return $cs_value;
}
function getScrollingBarCode($page_id)
{
	global $link;
	$output = '';
	$arr_records = array();
	
	$today_day = date('j');
	$today_date = date('Y-m-d');
	
	if(chkIfPageEnableForScrollingBar($page_id))
	{
	
		$sql = "SELECT * FROM `tblscrollingbars` WHERE ( (`sb_listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', sb_days_of_month) ) OR (`sb_listing_date_type` = 'single_date' AND `sb_single_date` = '".$today_date."') OR (`sb_listing_date_type` = 'date_range' AND `sb_start_date` <= '".$today_date."' AND `sb_end_date` >= '".$today_date."') ) AND ( `sb_status` = '1' ) AND ( `sb_deleted` = '0' ) ORDER BY `sb_order` ASC , `sb_add_date` DESC ";
		//echo '<br>sql = '.$sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			while ($row = mysql_fetch_assoc($result)) 
			{
				$show = false;
				$temp_page_id = stripslashes($row['page_id']);
				if($temp_page_id == '')
				{
					$show = true;
				}
				else
				{
					$arr_temp_pg_id = explode(',',$temp_page_id);
					if(in_array($page_id,$arr_temp_pg_id))
					{
						$show = true;
					}
				}
				
				if($show)
				{
					$arr_records[] = $row;
				}
			}
			
			//echo '<br><pre>';
			//print_r($arr_records);
			//echo '<br></pre>';
			
			if(count($arr_records) > 0)
			{
			
				$sb_bg_color = getCommonSettingValue('1');
				$sb_border_color = getCommonSettingValue('2');
				
				$output .= '<style>.ticker-wrapper.has-js {background-color: #'.$sb_bg_color.'; border:1px solid #'.$sb_border_color.'} .ticker {background-color: #'.$sb_bg_color.';} .ticker-swipe {background-color: #'.$sb_bg_color.';}</style>';
				
				
				$output .= '<table width="960" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="960" align="left" valign="top">';
							
				$output .= ' 	<ul id="js-news" class="js-hidden">';
				
				
				//while ($row = mysql_fetch_assoc($result)) 
				foreach($arr_records as $key => $row )
				{
					$sb_id = $row['sb_id'];
					$sb_content = stripslashes($row['sb_content']);
					$sb_content_font_family = stripslashes($row['sb_content_font_family']);
					$sb_content_font_size = stripslashes($row['sb_content_font_size']);
					$sb_content_font_color = stripslashes($row['sb_content_font_color']);
					$sb_show_content_credit = stripslashes($row['sb_show_content_credit']);
					$sb_content_credit_link = stripslashes($row['sb_content_credit_link']);
					$sb_content_credit_name = stripslashes($row['sb_content_credit_name']);
					
					$sb_content_style = '';
					if($sb_content_font_family != '')
					{
						$sb_content_style = 'font-family:'.$sb_content_font_family.';';
					}
					
					if($sb_content_font_size != '')
					{
						$sb_content_style .= 'font-size:'.$sb_content_font_size.'px;';
					}
					
					if($sb_content_font_color != '')
					{
						$sb_content_style .= 'color:#'.$sb_content_font_color.';';
					}
		
					if($row['sb_content_image'] != '')
					{
						$sb_content_image = '<img border="0" height="30" src="'.SITE_URL.'/uploads/'.stripslashes($row['sb_content_image']).'" />';
						$sb_content_image = '';		
					}
					else
					{
						$sb_content_image = '';	
					}
					
					
					if($sb_show_content_credit == '1' )
					{
						if($sb_content_credit_name != '')
						{
							$sb_content_credit = '&nbsp;&nbsp;---&nbsp;&nbsp;<a href="'.$sb_content_credit_link.'" target="_blank">'.$sb_content_credit_name.'</a>&nbsp;&nbsp;&nbsp;&nbsp;';
						}
						else
						{
							$sb_content_credit = '';
						}	
					}
					else
					{
						$sb_content_credit = '';
					}	
						
					$output .= '<li class="news-item"><a href="#" style="'.$sb_content_style.'">'.$sb_content.' &nbsp;&nbsp;'.$sb_content_image.'</a> &nbsp;&nbsp;<span>'.$sb_content_credit.'</span></li>';
				}
				
				$output .= '</ul>';
				$output .= ' </td>
						</tr>
					</table>   
					<table width="960" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="10"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>   ';
			}
		}
	}
	return $output;	
}
function chkIfUserPlanAtributeNeedToShow($upa_id)
{
	global $link;
	$return = false;
	
	$now = date('Y-m-d');
	
	$sql = "SELECT * FROM `tbluserplans` WHERE `up_status` = '1' AND `up_deleted` = '0' AND `up_show` = '1' AND `up_start_date` <= '".$now."' AND (`up_end_date` >= '".$now."' OR `up_end_date` = '0000-00-00') ORDER BY up_default DESC , up_name ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$str_up_id = '';
		while($row = mysql_fetch_array($result))
		{
			$str_up_id .= $row['up_id'].',';
		}
		
		if($str_up_id != '')
		{
			$str_up_id = substr($str_up_id,0,-1);
			$sql2 = "SELECT * FROM `tbluserplandetails` WHERE `upa_id` = '".$upa_id."' AND `up_id` IN (".$str_up_id.") AND `upd_status` = '1' AND `upd_deleted` = '0' ";
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['upa_value'] != '')
					{
						$return = true;
					}	
				}	
			}
		}			
	}
	return $return;
}

function chkIfAdviserPlanAtributeNeedToShow($apa_id)
{
	global $link;
	$return = false;
	
	$now = date('Y-m-d');
	
	$sql = "SELECT * FROM `tbladviserplans` WHERE `ap_status` = '1' AND `ap_deleted` = '0' AND `ap_show` = '1' AND `ap_start_date` <= '".$now."' AND (`ap_end_date` >= '".$now."' OR `ap_end_date` = '0000-00-00') ORDER BY ap_default DESC , ap_name ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$str_ap_id = '';
		while($row = mysql_fetch_array($result))
		{
			$str_ap_id .= $row['ap_id'].',';
		}
		
		if($str_ap_id != '')
		{
			$str_ap_id = substr($str_ap_id,0,-1);
			$sql2 = "SELECT * FROM `tbladviserplandetails` WHERE `apa_id` = '".$apa_id."' AND `ap_id` IN (".$str_ap_id.") AND `apd_status` = '1' AND `apd_deleted` = '0' ";
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['apa_value'] != '')
					{
						$return = true;
					}	
				}	
			}
		}			
	}
	
	
	
	return $return;
}

function getAllUserSubscriptionPlansList($user_id)
{
	global $link;
	$sql = "SELECT tupr.* , tup.up_name , tup.up_months_duration FROM `tbluserplanrequests` AS tupr LEFT JOIN `tbluserplans` AS tup ON tupr.up_id = tup.up_id WHERE tupr.user_id = '".$user_id."' ORDER BY tupr.upr_add_date DESC";
	$output = '';		
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$i = 1;
		while($row = mysql_fetch_array($result))
		{
			if($row['upr_status'] == '1')
			{
				$status = 'Active';
			}
			elseif($row['upr_status'] == '2')
			{
				$status = 'Reject';
			}
			elseif($row['upr_status'] == '3')
			{
				$status = 'Inactive';
			}
			else
			{
				$status = 'Pending';
			}
			
			$time_upr_add_date = strtotime($row['upr_add_date']);
			$time_upr_add_date = $time_upr_add_date + 19800;
			$upr_add_date = date('d-M-Y',$time_upr_add_date);
			
			if(strtotime($row['uup_start_date']) == '')
			{
				$uup_start_date = '';
			}
			else
			{
				$time_uup_start_date = strtotime($row['uup_start_date']);
				$time_uup_start_date = $time_uup_start_date + 19800;
				$uup_start_date = date('d-M-Y',$time_uup_start_date);
			}
			
			if(strtotime($row['uup_end_date']) == '')
			{
				$uup_end_date = '';
			}
			else
			{
				$time_uup_end_date = strtotime($row['uup_end_date']);
				$time_uup_end_date = $time_uup_end_date + 19800;
				$uup_end_date = date('d-M-Y',$time_uup_end_date);
			}
			
			$output .= '<tr class="manage-row">';
			$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
			$output .= '<td height="30" align="center">'.stripslashes($row['up_name']).'</td>';
			$output .= '<td height="30" align="center">'.$status.'</td>';
			$output .= '<td height="30" align="center">'.$upr_add_date.'</td>';
			$output .= '<td height="30" align="center">'.stripslashes($row['up_months_duration']).' Months</td>';
			$output .= '<td height="30" align="center">'.$uup_start_date.'</td>';
			$output .= '<td height="30" align="center">'.$uup_end_date.'</td>';
			//$output .= '<td align="center" nowrap="nowrap">';
					
			//$output .= '<a href="edit_banner.php?id='.$row['ab_id'].'" ><img src = "images/edit.png" width="10" border="0"></a>';
						
			//$output .= '</td>';
			$output .= '</tr>';
			$i++;
		}
	}
	else
	{
		$output = '<tr class="manage-row" height="20"><td colspan="7" align="center">Currently No Subscription Plan</td></tr>';
	}
	return $output;
}
function sendUserPlanRequest($user_id,$up_id)
{
	global $link;
	$return = false;
	$sql = "INSERT INTO `tbluserplanrequests`(`user_id`,`up_id`) VALUES ('".addslashes($user_id)."','".addslashes($up_id)."')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
	}
	
	return $return;
}
function chkIfUserPlanRequestAlreadySent($user_id)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tbluserplanrequests` WHERE `user_id` = '".$user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	
	return $return;
}
function chkIfUserPlanIsExpired($user_id)
{
	global $link;
	$return = true; 
	
	$sql = "SELECT * FROM `tbluserplanrequests` WHERE `user_id` = '".$user_id."' AND `upr_status` != '2' ORDER BY `upr_add_date` DESC LIMIT 1";
	//echo '<br>'.$sql.'<br>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$upr_status = $row['upr_status'];
		$up_start_date = $row['uup_start_date'];
		$up_end_date = $row['uup_end_date'];
		$time_up_end_date = strtotime($up_end_date);
		$now = time();
		
		if($upr_status == '1')
		{
			if($time_up_end_date >= $now)
			{
				$return = false; 
			}
				
		}
		
	}
	
	return $return;
}
function getUserCurrentRequestedPlanId($user_id)
{
	global $link;
	$up_id = 0; 
	
	$sql = "SELECT * FROM `tbluserplanrequests` WHERE `user_id` = '".$user_id."' AND `upr_status` != '2' ORDER BY `upr_add_date` DESC LIMIT 1";
	//echo '<br>'.$sql.'<br>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$up_id = $row['up_id'];
	}
	
	return $up_id;
}
function getAllAdviserSubscriptionPlansList($pro_user_id)
{
	global $link;
	$sql = "SELECT tapr.* , tap.ap_name , tap.ap_months_duration FROM `tbladviserplanrequests` AS tapr LEFT JOIN `tbladviserplans` AS tap ON tapr.ap_id = tap.ap_id WHERE tapr.pro_user_id = '".$pro_user_id."' ORDER BY tapr.apr_add_date DESC";
	$output = '';		
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$i = 1;
		while($row = mysql_fetch_array($result))
		{
			if($row['apr_status'] == '1')
			{
				$status = 'Active';
			}
			elseif($row['apr_status'] == '2')
			{
				$status = 'Reject';
			}
			elseif($row['apr_status'] == '3')
			{
				$status = 'Inactive';
			}
			else
			{
				$status = 'Pending';
			}
			
			$time_apr_add_date = strtotime($row['apr_add_date']);
			$time_apr_add_date = $time_apr_add_date + 19800;
			$apr_add_date = date('d-M-Y',$time_apr_add_date);
			
			if(strtotime($row['uap_start_date']) == '')
			{
				$uap_start_date = '';
			}
			else
			{
				$time_uap_start_date = strtotime($row['uap_start_date']);
				$time_uap_start_date = $time_uap_start_date + 19800;
				$uap_start_date = date('d-M-Y',$time_uap_start_date);
			}
			
			if(strtotime($row['uap_end_date']) == '')
			{
				$uap_end_date = '';
			}
			else
			{
				$time_uap_end_date = strtotime($row['uap_end_date']);
				$time_uap_end_date = $time_uap_end_date + 19800;
				$uap_end_date = date('d-M-Y',$time_uap_end_date);
			}
			
			$output .= '<tr class="manage-row">';
			$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
			$output .= '<td height="30" align="center">'.stripslashes($row['ap_name']).'</td>';
			$output .= '<td height="30" align="center">'.$status.'</td>';
			$output .= '<td height="30" align="center">'.$apr_add_date.'</td>';
			$output .= '<td height="30" align="center">'.stripslashes($row['ap_months_duration']).' Months</td>';
			$output .= '<td height="30" align="center">'.$uap_start_date.'</td>';
			$output .= '<td height="30" align="center">'.$uap_end_date.'</td>';
			//$output .= '<td align="center" nowrap="nowrap">';
					
			//$output .= '<a href="edit_banner.php?id='.$row['ab_id'].'" ><img src = "images/edit.png" width="10" border="0"></a>';
						
			//$output .= '</td>';
			$output .= '</tr>';
			$i++;
		}
	}
	else
	{
		$output = '<tr class="manage-row" height="20"><td colspan="7" align="center">Currently No Subscription Plan</td></tr>';
	}
	return $output;
}
function getAdviserRequestStatusAndArId($pro_user_id,$user_id)
{
	global $link;
	$request_status = chkIfUserIsAdvisersReferrals($pro_user_id,$user_id);
	$ar_id = '';	
	
	$user_email = getUserEmailById($user_id);
	$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND ( `request_status` = '1' || `request_status` = '3' ) ORDER BY `ar_id` DESC LIMIT 1";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$ar_id = $row['ar_id'];
	}
	
	return array($ar_id,$request_status);
}
function getAdviserStatusActivationsRecords($ar_id,$pro_user_id)
{
	global $link;
	$arr_record = array();
	
	$sql = "SELECT * FROM `tbladviseractivation` WHERE `ar_id` = '".$ar_id."' AND `pro_user_id` = '".$pro_user_id."' ORDER BY aa_add_date DESC";
	//echo '<br>'.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			$arr_record[] = $row;
		}
	}	
	return $arr_record;
}		
function getReportTypeName($report_id)
{
	global $link;
	$output = 'My Query';
	
	
	$sql = "SELECT * FROM `tblusersreports` WHERE `report_id`  = '".$report_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_assoc($result);
		$output = stripslashes($row['report_name']); 
	}	
	return $output;
}
function getImageAndColorCodeOfAdviserTheme($practitioner_id)
{
	global $link;
	$color_code = '#339900'; 
	$image = '';
	
	$today_day = date('j');
	
	$sql = "SELECT * FROM `tbltheams` WHERE `practitioner_id` = '".$practitioner_id."' AND `status` = '1' AND FIND_IN_SET('".$today_day."', day) ORDER BY RAND() limit 1";
	//echo '<br>'.$sql.'<br>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$image = SITE_URL."/uploads/".stripslashes($row['image']);
		$color_code = "#".stripslashes($row['color_code']);
	}
	
	return array($image,$color_code);
}
function chkIfAdviserPlanRequestAlreadySent($pro_user_id)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tbladviserplanrequests` WHERE `pro_user_id` = '".$pro_user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	
	return $return;
}
function sendAdviserPlanRequest($pro_user_id,$ap_id)
{
	global $link;
	$return = false;
	$sql = "INSERT INTO `tbladviserplanrequests`(`pro_user_id`,`ap_id`) VALUES ('".addslashes($pro_user_id)."','".addslashes($ap_id)."')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
	}
	
	return $return;
}
function getAdviserCurrentRequestedPlanId($pro_user_id)
{
	global $link;
	$ap_id = 0; 
	
	$sql = "SELECT * FROM `tbladviserplanrequests` WHERE `pro_user_id` = '".$pro_user_id."' AND `apr_status` != '2' ORDER BY `apr_add_date` DESC LIMIT 1";
	//echo '<br>'.$sql.'<br>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$ap_id = $row['ap_id'];
	}
	
	return $ap_id;
}
function chkIfAdviserPlanIsExpired($pro_user_id)
{
	global $link;
	$return = true; 
	
	$sql = "SELECT * FROM `tbladviserplanrequests` WHERE `pro_user_id` = '".$pro_user_id."' AND `apr_status` != '2' ORDER BY `apr_add_date` DESC LIMIT 1";
	//echo '<br>'.$sql.'<br>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$apr_status = $row['apr_status'];
		$ap_start_date = $row['uap_start_date'];
		$ap_end_date = $row['uap_end_date'];
		$time_ap_end_date = strtotime($ap_end_date);
		$now = time();
		//echo '<br>ap_end_date = '.$ap_end_date;
		//echo '<br>time_ap_end_date = '.$time_ap_end_date;
		//echo '<br>now = '.$now;
		if($apr_status == '1')
		{
			if($time_ap_end_date >= $now)
			{
				$return = false; 
			}
				
		}
		
	}
	
	return $return;
}

function getAdviserPlansCategoryTypeOptions($apct_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_status` = '1' AND `apct_deleted` = '0' AND `show_for_adviser` = '1' ORDER BY `apct_category_type` ASC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result)) 
		{
			if($row['apct_id'] == $apct_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['apct_id'].'" '.$sel.'>'.$row['apct_category_type'].'</option>';
		}
	}
	return $option_str;
}

function getUserPlansCategoryTypeOptions($apct_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_status` = '1' AND `apct_deleted` = '0' AND `show_for_user` = '1' ORDER BY `apct_category_type` ASC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result)) 
		{
			if($row['apct_id'] == $apct_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['apct_id'].'" '.$sel.'>'.$row['apct_category_type'].'</option>';
		}
	}
	return $option_str;
}

function getAdviserPlansCategoryName($apct_id)
{
	global $link;
	$name = 'All';		
	
	$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_id` = '".$apct_id."' ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result); 
		$name = $row['apct_category_type'];
	}
	return $name;
}
function getAdviserPlanName($ap_id)
{
	global $link;
	$name = '';		
	
	$sql = "SELECT * FROM `tbladviserplans` WHERE `ap_id` = '".$ap_id."' ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result); 
		$name = stripslashes($row['ap_name']);
	}
	return $name;
}
function getUserPlanName($up_id)
{
	global $link;
	$name = '';		
	
	$sql = "SELECT * FROM `tbluserplans` WHERE `up_id` = '".$up_id."' ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result); 
		$name = stripslashes($row['up_name']);
	}
	return $name;
}
function viewAdviserPlans($pro_user_id,$apct_id = '')
{
	global $link;
	$output = '';
	
	$cr_ap_id = getAdviserCurrentRequestedPlanId($pro_user_id);
	
	$adviser_default_id = getAdviserDefaultPlanId();
	$adviser_default_name = getAdviserPlanName($adviser_default_id);
	
	$now = date('Y-m-d');
	
	$output .= '<div id="idviewadviserplans">';
	$output .= '	<table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td align="left" valign="top">
								<strong>Category</strong>:&nbsp;<select name="apct_id" id="apct_id" style="width:200px;" onchange="viewAdviserPlans();">
									<option value="">All Categories</option>
									'.getAdviserPlansCategoryTypeOptions($apct_id).'
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
	if($apct_id == '')
	{
		//$sql_cat = "SELECT DISTINCT `apct_id` FROM `tbladviserplans` WHERE `ap_status` = '1' AND `ap_deleted` = '0' AND `ap_start_date` <= '".$now."' AND `ap_end_date` >= '".$now."'  ORDER BY apct_id ASC";
		$arr_category[] = '0';
		$sql_cat = "SELECT `apct_id` FROM `tbladviserplancategorytype` WHERE `show_for_adviser` = '1' AND `apct_status` = '1' AND `apct_deleted` = '0' ORDER BY apct_category_type ASC";
		
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
		$arr_category[] = $apct_id;
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
		
		$sql = "SELECT * FROM `tbladviserplans` WHERE `apct_id` = '".$arr_category[$m]."' AND `ap_status` = '1' AND `ap_show` = '1' AND `ap_deleted` = '0' AND `ap_start_date` <= '".$now."' AND `ap_end_date` >= '".$now."'  ORDER BY ap_default DESC , ap_name ASC";
		//echo '<br>'.$sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			while($row = mysql_fetch_array($result))
			{
				if($row['ap_default'] == '0')
				{
					$country_id = $row['country_id'];
					$str_state_id = $row['state_id'];
					$str_city_id = $row['city_id'];
					$str_place_id = $row['place_id'];
					if(chkAdviserForLocationCriteria($pro_user_id,$country_id,$str_state_id,$str_city_id,$str_place_id))
					{
						$arr_record[] = $row;
					}
				}	
			}
		}	
			
		$total_plans = count($arr_record);
		$total_column = $total_plans + 1;
		$total_plan_column = $total_plans - 1;
			
			
		$output .= '<table cellpadding="5" cellspacing="1" width="100%" align="center" border="0" bgcolor="#333333">';
		
		$output .= '	<tr>
							<td width="200" bgcolor="#F6F6F6" height="30" align="left" valign="middle"><strong>Plan Name</strong></td>
							<td width="180" bgcolor="#EBEBEB" height="30" align="center" valign="middle"><strong>'.$adviser_default_name.'</strong></td>';
						if($total_plans > 0)
						{	
							for($i=0;$i<$total_plans;$i++)
							{
		$output .= '		<td bgcolor="#FFFFFF" height="30" align="center" valign="middle">'.stripslashes($arr_record[$i]['ap_name']).'</td>';
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
		$output .= '		<td bgcolor="#FFFFFF" height="30" align="center" valign="middle">'.stripslashes($arr_record[$i]['ap_months_duration']).'Mon</td>';
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
		$output .= '		<td bgcolor="#FFFFFF" height="30" align="center" valign="middle">'.stripslashes($arr_record[$i]['ap_amount']).' '.stripslashes($arr_record[$i]['ap_currency']).'</td>';
							}
						}	
		$output .= '	</tr>';
						
		$sql2 = "SELECT * FROM `tbladviserplanatributes` WHERE apa_status = '1' AND `show_for_adviser` = '1' ORDER BY apa_name ASC ";
		$result2 = mysql_query($sql2,$link);
		if( ($result2) && (mysql_num_rows($result2) > 0) )
		{
			$arr_record2 = array();
			while($row2 = mysql_fetch_array($result2))
			{
				if(chkIfAdviserPlanAtributeNeedToShow($row2['apa_id']))
				{
					$arr_record2[] = $row2;
				}
			}
			
				
			for($i=0;$i<count($arr_record2);$i++)
			{
			$output .= '<tr>
							<td bgcolor="#F6F6F6" height="30" align="left" valign="middle"><strong>'.stripslashes($arr_record2[$i]['apa_name']).'</strong></td>';
						
				$sql3 = "SELECT tapd.* , tapc.apc_criteria FROM `tbladviserplandetails` AS tapd LEFT JOIN `tbladviserplancriteria` AS tapc ON tapd.apc_id = tapc.apc_id WHERE tapd.ap_id = '".$adviser_default_id."' AND tapd.apa_id = '".$arr_record2[$i]['apa_id']."' AND tapd.apd_status = '1' AND tapd.apd_deleted = '0'";
				$result3 = mysql_query($sql3,$link);
				if( ($result3) && (mysql_num_rows($result3) > 0) )
				{
					$row3 = mysql_fetch_array($result3);
					if($row3['apa_value'] == '1')
					{
						$apa_value = 'Yes';
						
						if($row3['apc_id'] != '0')
						{
							$apc_value = '<br>'.$row3['apc_criteria'].': '.$row3['apc_value'].'';
						}
						else
						{
							$apc_value = '';
						}	
					}
					else
					{
						$apa_value = 'No';
						$apc_value = '';
					}
				}	
				else
				{
					$apa_value = 'No';
					$apc_value = '';
				}
			$output .= '	<td bgcolor="#EBEBEB" height="30" align="center" valign="middle"><strong>'.$apa_value.' '.$apc_value.'</strong></td>';	
					
					
				if($total_plans > 0)
				{	
					for($k=0;$k<count($arr_record);$k++)
					{
						$sql3 = "SELECT tapd.* , tapc.apc_criteria FROM `tbladviserplandetails` AS tapd LEFT JOIN `tbladviserplancriteria` AS tapc ON tapd.apc_id = tapc.apc_id WHERE tapd.ap_id = '".$arr_record[$k]['ap_id']."' AND tapd.apa_id = '".$arr_record2[$i]['apa_id']."' AND tapd.apd_status = '1' AND tapd.apd_deleted = '0'";
						$result3 = mysql_query($sql3,$link);
						if( ($result3) && (mysql_num_rows($result3) > 0) )
						{
							$row3 = mysql_fetch_array($result3);
							if($row3['apa_value'] == '1')
							{
								$apa_value = 'Yes';
								
								if($row3['apc_id'] != '0')
								{
									$apc_value = '<br>'.$row3['apc_criteria'].': '.$row3['apc_value'].'';
								}
								else
								{
									$apc_value = '';
								}	
							}
							else
							{
								$apa_value = 'No';
								$apc_value = '';
							}
						}
						else
						{	
							$apa_value = 'No';
							$apc_value = '';
						}	
				$output .= '	<td bgcolor="#FFFFFF" height="30" align="center" valign="middle">'.$apa_value.' '.$apc_value.'</td>';	
					}
				}		
			$output .= '</tr>';	
			}
		}
			
		if($cr_ap_id == '0' || chkIfAdviserPlanIsExpired($pro_user_id))
		{
			$btn_action = '<input type="button" name="btnSendAdviserPlanRequest" id="btnSendAdviserPlanRequest" value="Select" onclick="sendAdviserPlanRequest()">';
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
				if($cr_ap_id == $arr_record[$i]['ap_id'])
				{
					$ap_id_checked = ' checked="checked" ';
				}
				else
				{
					$ap_id_checked = '';
				}	
				$output .= '<td bgcolor="#FFFFFF" height="30" align="center" valign="middle"><input type="radio" name="select_ap_id" id="select_ap_id_'.$i.'" value="'.$arr_record[$i]['ap_id'].'" '.$ap_id_checked.'>&nbsp;</td>';
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
function getAdiverPlanId($pro_user_id)
{
	global $link;
	$ap_id = '0';
	
	$sql = "SELECT * FROM `tblprofusers` WHERE `pro_user_id` = '".$pro_user_id."' ";	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$ap_id = stripslashes($row['ap_id']);
		
	}	
	return $ap_id;
}
function chkAdviserPlanFeaturePermission($pro_user_id,$apa_id)
{
	global $link;
	$return = false;
	
	$default_ap_id = getAdviserDefaultPlanId();
	
	$sql = "SELECT * FROM `tbladviserplandetails` AS tapd LEFT JOIN `tbladviserplans` AS tap ON tapd.ap_id = tap.ap_id WHERE tapd.ap_id = '".$default_ap_id."' AND tap.ap_default = '1' AND tap.ap_status = '1' AND tap.ap_deleted = '0' AND tapd.apa_id = '".$apa_id."' AND tapd.apd_status = '1'  AND tapd.apd_deleted = '0' AND tapd.apa_value = '1' ";
	//echo '<br>sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	else
	{
		$user_ap_id = getAdviserCurrentActivatedPlanId($pro_user_id);
		if($user_ap_id > 0)
		{
			$sql2 = "SELECT * FROM `tbladviserplandetails` AS tapd LEFT JOIN `tbladviserplans` AS tap ON tapd.ap_id = tap.ap_id WHERE tapd.ap_id = '".$user_ap_id."' AND tap.ap_status = '1' AND tap.ap_deleted = '0' AND tapd.apa_id = '".$apa_id."' AND tapd.apd_status = '1'  AND tapd.apd_deleted = '0' AND tapd.apa_value = '1' ";
			//echo '<br>sql2 = '.$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$return = true;
			}
		}
	}	
	return $return;
}
function chkUserPlanFeaturePermission($user_id,$upa_id)
{
	global $link;
	$return = false;
	
	$default_up_id = getUserDefaultPlanId();
	
	$sql = "SELECT * FROM `tbluserplandetails` AS tupd LEFT JOIN `tbluserplans` AS tup ON tupd.up_id = tup.up_id WHERE tupd.up_id = '".$default_up_id."' AND tup.up_default = '1' AND tup.up_status = '1' AND tup.up_deleted = '0' AND tupd.upa_id = '".$upa_id."' AND tupd.upd_status = '1'  AND tupd.upd_deleted = '0' AND tupd.upa_value = '1' ";
	//echo '<br>sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	else
	{
		$user_up_id = getUserCurrentActivatedPlanId($user_id);
		if($user_up_id > 0)
		{
			$sql2 = "SELECT * FROM `tbluserplandetails` AS tupd LEFT JOIN `tbluserplans` AS tup ON tupd.up_id = tup.up_id WHERE tupd.up_id = '".$user_up_id."' AND tup.up_status = '1' AND tup.up_deleted = '0' AND tupd.upa_id = '".$upa_id."' AND tupd.upd_status = '1'  AND tupd.upd_deleted = '0' AND tupd.upa_value = '1' ";
			//echo '<br>sql2 = '.$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$return = true;
			}
		}
	}	
	return $return;
}
function chkAdviserHasPlan($pro_user_id)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM tblprofusers AS tpu LEFT JOIN tbladviserplans AS tap ON tpu.ap_id = tap.ap_id WHERE tpu.pro_user_id = '".$pro_user_id."' AND tap.ap_status = '1' AND tap.ap_deleted = '0' AND tpu.ap_id > 0 ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	
	return $return;
}
function getAdviserTopBanner($pro_user_id)
{
	global $link;
	$banner = '';
	
	$sql = "SELECT * FROM `tbladviserbanners` WHERE `pro_user_id` = '".$pro_user_id."' AND `ab_status` = '1' ORDER BY RAND() limit 1";	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$banner = stripslashes($row['banner']);
		
	}	
	return $banner;
}

function getAdviserBannerDetails($ab_id,$pro_user_id)
{
	global $link;
	$image = '';
	$status = '';
	
			
	$sql = "SELECT * FROM `tbladviserbanners` WHERE `ab_id` = '".$ab_id."' AND `pro_user_id` = '".$pro_user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$image = stripslashes($row['banner']);
		$status = stripslashes($row['ab_status']);
	}
	return array($image,$status);
}
function updateAdviserBanner($pro_user_id,$image,$ab_id,$new_banner)
{
	global $link;
	$return = false;
	if($new_banner)
	{
		$sql = "UPDATE `tbladviserbanners` SET `banner` = '".addslashes($image)."' , `ab_status` = '0' WHERE `ab_id` = '".$ab_id."' AND `pro_user_id` = '".$pro_user_id."'";
	}
	else
	{
		$sql = "UPDATE `tbladviserbanners` SET `banner` = '".addslashes($image)."' WHERE `ab_id` = '".$ab_id."' AND `pro_user_id` = '".$pro_user_id."'";
	}
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
	}
	
	return $return;
}
function addAdviserBanner($pro_user_id,$image)
{
	global $link;
	$return = false;
	$sql = "INSERT INTO `tbladviserbanners`(`pro_user_id`,`banner`,`ab_status`) VALUES ('".addslashes($pro_user_id)."','".addslashes($image)."','0')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
	}
	
	return $return;
}
function chkIfAdviserCanAddMoreBanner($pro_user_id)
{
	global $link;
	$return = false;
	
	$plan_id = getAdviserCurrentActivatedPlanId($pro_user_id);
	$count = 1;
	
	if(chkAdviserPlanFeaturePermission($pro_user_id,'15'))
	{
		//if(chkAdviserPlanFeaturePermission($pro_user_id,'1'))
		//{
			$sql = "SELECT * FROM `tbladviserplandetails` WHERE `ap_id` = '".$plan_id."' AND `apa_id` = '15' AND `apd_status` = '1' AND `apd_deleted` = '0' ORDER BY apd_add_date DESC LIMIT 1";
			$result = mysql_query($sql,$link);
			if( ($result) && (mysql_num_rows($result) > 0) )
			{
				$row = mysql_fetch_array($result);
				$apc_id = stripslashes($row['apc_id']);
				$apc_value = stripslashes($row['apc_value']);
				
				if($apc_id == '1' || $apc_id == '3')
				{
					if($apc_value != '')
					{
						$count = $apc_value;
					}	
				}
			}
		//}
		
		$sql = "SELECT * FROM `tbladviserbanners` WHERE `pro_user_id` = '".$pro_user_id."' ORDER BY ab_add_date DESC";
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			if(mysql_num_rows($result) < $count)
			{
				$return = true;
			}
		}
		else
		{
			$return = true;
		}
	}
	return $return;
}
function getAllAdviserBannersList($pro_user_id)
{
	global $link;
	$sql = "SELECT * FROM `tbladviserbanners` WHERE `pro_user_id` = '".$pro_user_id."' ORDER BY ab_add_date DESC";
	$output = '';		
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$i = 1;
		while($row = mysql_fetch_array($result))
		{
			if($row['ab_status'] == '1')
			{
				$status = 'Active';
			}
			else
			{
				$status = 'Inactive';
			}
			
			$theme_str = '<img border="0" width="100" src="'.SITE_URL.'/uploads/'.stripslashes($row['banner']).'" >';
			
			$output .= '<tr class="manage-row">';
			$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
			$output .= '<td height="30" align="center">'.$theme_str.'</td>';
			$output .= '<td height="30" align="center">'.$status.'</td>';
			$output .= '<td align="center" nowrap="nowrap">';
					
			$output .= '<a href="edit_banner.php?id='.$row['ab_id'].'" ><img src = "images/edit.png" width="10" border="0"></a>';
						
			$output .= '</td>';
			$output .= '</tr>';
			$i++;
		}
	}
	else
	{
		$output = '<tr class="manage-row" height="20"><td colspan="4" align="center">NO RECORDS FOUND</td></tr>';
	}
	return $output;
}
function getUserPlanRefinedReportsIds($user_id,$str_report_id,$str_permission_type)
{
	global $link;
	$return_str_report_id = '';	
	$return_permission_type = '';
	
	if($str_report_id != '')
	{	
		$arr_report_id = explode(',',$str_report_id); 
		$arr_permission_type = explode(',',$str_permission_type);	
		
		for($i=0;$i<count($arr_report_id);$i++)
		{
			$sql = "SELECT * FROM `tbladviserplanatributes` WHERE `ref_report_id` = '".$arr_report_id[$i]."' AND `apa_status` = '1' AND `show_for_user` = '1' ORDER BY `apa_id` DESC LIMIT 1";
			//echo $sql;
			$result = mysql_query($sql,$link);
			if( ($result) && (mysql_num_rows($result) > 0) )
			{
				$row = mysql_fetch_array($result);
				$temp_apa_id = $row['apa_id'];
				if(chkUserPlanFeaturePermission($user_id,$temp_apa_id))
				{
					$return_str_report_id .= $arr_report_id[$i].',';	
					$return_permission_type .= $arr_permission_type[$i].',';
				}
			}
		}
		
		$return_str_report_id = substr($return_str_report_id,0,-1);	
		$return_permission_type = substr($return_permission_type,0,-1);	
	}
	return array($return_str_report_id,$return_permission_type);
}
function getUserAcceptedReportId($user_id,$pro_user_id)
{
	global $link;
	$str_report_id = '';	
	$str_permission_type = '';	
	
	$user_email = getUserEmailById($user_id);
	$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `request_status` = '1' ORDER BY `ar_id` DESC LIMIT 1";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$str_report_id = $row['report_id'];
		$str_permission_type = $row['permission_type'];
		
		list($str_report_id,$str_permission_type) = getUserPlanRefinedReportsIds($user_id,$str_report_id,$str_permission_type);
	}
	
	return array($str_report_id,$str_permission_type);
}
function getUserAcceptedReportsOptions($user_id,$pro_user_id,$report_id)
{
	global $link;
	$option_str = '';
	list($str_report_id,$str_permission_type) = getUserAcceptedReportId($user_id,$pro_user_id);
	if($str_report_id != '')
	{	
		$arr_report_id = explode(',',$str_report_id); 
		$arr_permission_type = explode(',',$str_permission_type);
		
		for($i=0;$i<count($arr_report_id);$i++)
		{ 
			$sql = "SELECT * FROM `tblusersreports` WHERE report_id = '".$arr_report_id[$i]."' ORDER BY `report_name` ASC";
			//echo $sql;
			$result = mysql_query($sql,$link);
			if( ($result) && (mysql_num_rows($result) > 0) )
			{
				while($row = mysql_fetch_array($result) ) 
				{
					if($report_id == $row['report_id'].'_1')
					{
						$sel1 = '';
						$sel2 = ' selected ';
					}
					elseif($report_id == $row['report_id'].'_0')
					{
						$sel1 = ' selected ';
						$sel2 = '';
					}	
					else
					{
						$sel1 = '';
						$sel2 = '';
					}	
					
					if($arr_permission_type[$i] == '2')
					{	
						$option_str .= '<option value="'.$row['report_id'].'_0" '.$sel1.'>'.stripslashes($row['report_name']).' (Standard Set)</option>';
					}
					elseif($arr_permission_type[$i] == '3')
					{	
						$option_str .= '<option value="'.$row['report_id'].'_1" '.$sel2.'>'.stripslashes($row['report_name']).' (Adviser Set)</option>';
					}	
					else
					{	
						$option_str .= '<option value="'.$row['report_id'].'_0" '.$sel1.'>'.stripslashes($row['report_name']).' (Standard Set)</option>';
						$option_str .= '<option value="'.$row['report_id'].'_1" '.$sel2.'>'.stripslashes($row['report_name']).' (Adviser Set)</option>';
					}
				}
			}
		}
	}
	return $option_str;
}
function showLocationPopup($country_id,$state_id,$city_id,$place_id,$idval)
{
	global $link;
	$output = '';
    
	$output .= '<table cellpadding="0" cellspacing="0" width="100%" align="center" border="0">
					<tr>
						<td width="40%" height="30" align="right" valign="top">&nbsp;</td>
						<td width="5%" height="30" align="center" valign="top">&nbsp;</td>
						<td width="55%" height="30" align="left" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td height="30" align="right" valign="top"><strong>Country</strong></td>
						<td height="30" align="center" valign="top"><strong>:</strong></td>
						<td height="30" align="left" valign="top">
							<select name="popup_country_id" id="popup_country_id" onchange="getStateOptionsPopup(\''.$state_id.'\')" style="width:200px;">
								<option value="">Select Country</option>
								'.getCountryOptions($country_id).'
							</select>
						</td>
					</tr>
					<tr>
						<td height="30" align="right" colspan="3" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td height="30" align="right" valign="top"><strong>State</strong></td>
						<td height="30" align="center" valign="top"><strong>:</strong></td>
						<td height="30" align="left" valign="top" id="tdpopupstate">
							<select name="popup_state_id" id="popup_state_id" onchange="getCityOptionsPopup(\''.$city_id.'\')" style="width:200px;">
								<option value="">Select State</option>
								'.getStateOptions($country_id,$state_id).'
							</select>
						</td>
					</tr>
					<tr>
						<td height="30" align="right" colspan="3" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td height="30" align="right" valign="top"><strong>City</strong></td>
						<td height="30" align="center" valign="top"><strong>:</strong></td>
						<td height="30" align="left" valign="top" id="tdpopupcity">
							<select name="popup_city_id" id="popup_city_id" onchange="getPlaceOptionsPopup(\''.$place_id.'\')" style="width:200px;">
								<option value="">Select City</option>
								'.getCityOptions($state_id,$city_id).'
							</select>
						</td>
					</tr>
					<tr>
						<td height="30" align="right" colspan="3" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td height="30" align="right" valign="top"><strong>Place</strong></td>
						<td height="30" align="center" valign="top"><strong>:</strong></td>
						<td height="30" align="left" valign="top" id="tdpopupplace">
							<select name="popup_place_id" id="popup_place_id" style="width:200px;">
								<option value="">Select Place</option>
								'.getPlaceOptions($state_id,$city_id,$place_id).'
							</select>
						</td>
					</tr>
					<tr>
						<td height="30" align="right" colspan="3" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td height="30" align="center" colspan="3" valign="top"><input type="button" name="btnselectpopuplocation" id="btnselectpopuplocation" value="Select" onclick="selectPopupLocation(\''.$idval.'\');" /></td>
					</tr>'; 
	$output .= '</table>';
	return $output;
}
function getReportTypeNameString($str_report_id,$str_permission_type)
{
	global $link;
	$output = '';
	
	if($str_report_id != '')
	{
	
		$arr_temp_report_id = explode(',',$str_report_id);
		$arr_temp_permission_type = explode(',',$str_permission_type);
		
		for($i=0;$i<count($arr_temp_report_id);$i++)
		{
			$sql = "SELECT * FROM `tblusersreports` WHERE `report_id`  = '".$arr_temp_report_id[$i]."'";
			$result = mysql_query($sql,$link);
			if( ($result) && (mysql_num_rows($result) > 0) )
			{
				$row = mysql_fetch_assoc($result);
				if($arr_temp_permission_type[$i] == '2')
				{
					$temp_permission_type = 'Standard Set';
				}
				elseif($arr_temp_permission_type[$i] == '3')
				{
					$temp_permission_type = 'Adviser Set';
				}	
				else
				{
					$temp_permission_type = 'Both Set';
				}
				$output .= $row['report_name'].'('.$temp_permission_type.'), '; 
			}
			
		}	
		$output = substr($output,0,-2);
	}	
	return $output;
}
function getAdviserReportsPermissions($user_id,$pro_user_id,$ar_id)
{
	global $link;
	$temp_arr = array();
    
    $sql = "SELECT * FROM `tbladviserreportpermission` WHERE `user_id` = '".$user_id."' AND `pro_user_id` = '".$pro_user_id."' AND `ar_id` = '".$ar_id."' ORDER BY `arp_add_date` DESC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_assoc($result))
		{
			$temp_arr[] = $row;
			//echo '<br><br><pre>';
			//print_r($row);
			//echo '<br></pre>';
		}
	}
	return $temp_arr;
}
function setUserQueryRead($aq_id,$user_id,$user_read)
{
	global $link;
	$return = false;
	$sql = "UPDATE `tbladviserqueries` SET `user_read` = '".$user_read."' WHERE `aq_id` = '".$aq_id."' AND `user_id` = '".$user_id."'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}

function setAdviserQueryRead($aq_id,$pro_user_id,$pro_user_read)
{
	global $link;
	$return = false;
	$sql = "UPDATE `tbladviserqueries` SET `pro_user_read` = '".$pro_user_read."' WHERE `aq_id` = '".$aq_id."' AND `pro_user_id` = '".$pro_user_id."'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}

function getCountryName($country_id)
{
	global $link;
	$country_name = '';		
	
	$sql = "SELECT * FROM `tblcountry` WHERE `country_id` = '".$country_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$country_name = stripslashes($row['country_name']);	 
	}
	return $country_name;
}

function getStateName($state_id)
{
	global $link;
	$state = '';		
	
	$sql = "SELECT * FROM `tblstates` WHERE `state_id` = '".$state_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$state = stripslashes($row['state']);	 
	}
	return $state;
}

function getCityName($city_id)
{
	global $link;
	$city = '';		
	
	$sql = "SELECT * FROM `tblcities` WHERE `city_id` = '".$city_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$city = stripslashes($row['city']);	 
	}
	return $city;
}

function getPlaceName($place_id)
{
	global $link;
	$place = '';		
	
	$sql = "SELECT * FROM `tblplaces` WHERE `place_id` = '".$place_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$place = stripslashes($row['place']);	 
	}
	return $place;
}

function chkValidPassword($password) 
{
	$r1='/[A-Z]/';  //Uppercase
	$r2='/[a-z]/';  //lowercase
	$r3='/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'
	$r4='/[0-9]/';  //numbers
	
	if(preg_match_all($r1,$password, $o)<1) return false;
	if(preg_match_all($r2,$password, $o)<1) return false;
	if(preg_match_all($r3,$password, $o)<1) return false;
	if(preg_match_all($r4,$password, $o)<1) return false;
	
	//preg_match_all($r4,$password, $o);
	//echo'<br><pre>';
	//print_r($o);
	//echo'<br></pre>'; 
	
	if(strlen($password)<6) return false;
	
	return true;
}

function getAllAdviserQueriesByID($id)
{
  	global $link;
	$temp_arr = array();
	
	$str_feedback_id = getAllConvarsationIdAdviserQuery($id);
	
	$sql = "SELECT * FROM `tbladviserqueries` WHERE  `aq_id` IN (".$str_feedback_id.") ORDER BY `aq_add_date` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{	
		while($row = mysql_fetch_assoc($result) ) 
		{	
			$temp_arr[] = $row;
		}
	}
	return $temp_arr;
}

function getAllConvarsationIdAdviserQuery($id)
{
	$main_parent_id = getMainParantIdAdviserQuery($id);
	$str_feedback_id = getRecursiveAdviserQueryId($main_parent_id,$main_parent_id);
	return $str_feedback_id;
}

function getMainParantIdAdviserQuery($id)
{
	global $link;
	
	$sql = "SELECT * FROM `tbladviserqueries` WHERE `aq_id` = '".$id."' ORDER BY `aq_add_date` DESC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{	
		$row = mysql_fetch_array($result);
		$parent_feedback_id = $row['parent_aq_id'];
		if($parent_feedback_id == 0)
		{
			return $id;
		}
		else
		{
			return getMainParantIdAdviserQuery($parent_feedback_id);
		}
	}
	else
	{
		return 0;
	}
}

function getRecursiveAdviserQueryId($main_parent_id,$return)
{
	global $link;
	$sql = "SELECT * FROM `tbladviserqueries` WHERE `parent_aq_id` = '".$main_parent_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{	
		while($row = mysql_fetch_array($result) ) 
		{	
			$temp_feedback_id = $row['aq_id'];
			if($return == '')
			{
				$return .= getRecursiveAdviserQueryId($temp_feedback_id,$main_parent_id).',';
			}
			else
			{
				$return .= ','.getRecursiveAdviserQueryId($temp_feedback_id,$main_parent_id);
			}	
		}
	}
	else
	{
		$return .= ','.$main_parent_id;
	}
	return $return;
}

function getAdviserQueryDetails($aq_id)
{
	global $link;
	$temp_arr = array();
	
	$sql = "SELECT * FROM `tbladviserqueries` WHERE `aq_id` = '".$aq_id."' ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_assoc($result);
		$temp_arr[] = $row;
	}
	return $temp_arr;
}
function chk_valid_user_query_id($id,$user_id)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tbladviserqueries` WHERE `aq_id` = '".$id."' AND `user_id` = '".$user_id."' ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}

function chk_valid_adviser_query_id($id,$pro_user_id)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tbladviserqueries` WHERE `aq_id` = '".$id."' AND `pro_user_id` = '".$pro_user_id."' ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}


function getAdvisersUserOptions($user_id,$pro_user_id)
{
	global $link;
	$option_str = '';	
	//$email = getUserEmailById($user_id);	
		
	$sql = "SELECT * FROM `tbladviserreferrals` AS tar LEFT JOIN `tblusers` AS tpu ON tar.user_email = tpu.email  WHERE tar.pro_user_id = '".$pro_user_id."' AND tar.request_status = '1' ORDER BY tpu.name ASC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			 
			if($row['user_id'] == $user_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['user_id'].'" '.$sel.'>'.stripslashes($row['name']).'</option>';
			
		}
	}
	return $option_str;
}

function getAdvisersUserOptionsMulti($arr_user_id,$practitioner_id)
{
	global $link;
	$option_str = '';
	if($practitioner_id == '')
	{
		$sql = "SELECT * FROM `tblusers` WHERE `status` = '1' ORDER BY `name` ASC";
	}
	else
	{
		$sql = "SELECT * FROM `tbladviserreferrals` AS tar LEFT JOIN `tblusers` AS tpu ON tar.user_email = tpu.email  WHERE tar.pro_user_id = '".$practitioner_id."' AND tar.request_status = '1' ORDER BY tpu.name ASC";
	}
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			if(in_array($row['user_id'],$arr_user_id))
			{
				$selected = ' selected ';
			}
			else
			{
				$selected = '';
			}
			$option_str .= '<option value="'.$row['user_id'].'" '.$selected.' >'.stripslashes($row['name']).'</option>';
		}
	}
	return $option_str;
}

function getAdvisersUserOptionsMultiFront($arr_user_id,$practitioner_id)
{
	global $link;
	$option_str = '';
	
	//$sql = "SELECT * FROM `tblusers` WHERE FIND_IN_SET('".$practitioner_id."', practitioner_id)  ORDER BY `name` ASC";
	$sql = "SELECT * FROM `tbladviserreferrals` AS tar LEFT JOIN `tblusers` AS tpu ON tar.user_email = tpu.email  WHERE tar.pro_user_id = '".$practitioner_id."' AND tar.request_status = '1' ORDER BY tpu.name ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			if(in_array($row['user_id'],$arr_user_id))
			{
				$selected = ' selected ';
			}
			else
			{
				$selected = '';
			}
			$option_str .= '<option value="'.$row['user_id'].'" '.$selected.' >'.stripslashes($row['name']).'</option>';
		}
	}
	return $option_str;
}

function viewUsersSelectionPopup($practitioner_id,$arr_user_id)
{
	global $link;
	$output = '';
	
	if($practitioner_id == '')
	{
		$sql = "SELECT * FROM `tblusers` WHERE `status` = '1' ORDER BY `name` ASC";
	}
	else
	{
		$sql = "SELECT * FROM `tbladviserreferrals` AS tar LEFT JOIN `tblusers` AS tpu ON tar.user_email = tpu.email  WHERE tar.pro_user_id = '".$practitioner_id."' AND tar.request_status = '1' ORDER BY tpu.name ASC";
	}
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$output .= '<form id="frmselectusers" name="frmselectusers"><div style="width:1080px;float:left;padding-left:50px; margin-bottom:20px;"><input type="checkbox" name="all_selected_user_id" id="all_selected_user_id" value="1" onclick="toggleCheckBoxes(\'selected_user_id\');" />&nbsp;<strong>Select All</strong>&nbsp;&nbsp;<input type="button" name="btnSetSelectedUsers" id="btnSetSelectedUsers" onclick="SetSelectedUsers();" value="Select"></div>';
		$output .= '<div style="width:1080px;height:550px;float:left;overflow:scroll;">';
		$output .= '	<ul style="list-style:none;">';
		$i = 1;
		while($row = mysql_fetch_array($result) ) 
		{
			if(in_array($row['user_id'],$arr_user_id) || $arr_user_id[0] == '')
			{
				$selected = ' checked ';
			}
			else
			{
				$selected = '';
			}
			
			$output .= '<li style="padding:10px;width:300px;float:left;"><input type="checkbox" '.$selected.' name="selected_user_id" id="selected_user_id_'.$i.'" value="'.$row['user_id'].'" />&nbsp;<strong>'.stripslashes($row['name']).'&nbsp;&nbsp;('.stripslashes($row['unique_id']).')</strong></li>';
			$i++;
		}
		$output .= '</div></form>';
		
	}
	return $output;
}

function getAllAdviserUserQueries($pro_user_id,$user_id,$pg_id,$start_date,$end_date,$search_keywords)
{
    global $link;
	$temp_arr = array();
    
    if($user_id != '')
	{
		$str_sql_user_id = " AND `user_id` = '".$user_id."' ";
	}
	else
	{
		$str_sql_user_id = '';
	}
	
	if($pg_id != '')
	{
		$arr_temp = explode('_',$pg_id);
		$temp_page_id = $arr_temp[0];
		$temp_permission_type = $arr_temp[1];
		
		$str_sql_pg_id = " AND `page_id` = '".$temp_page_id."' AND `permission_type` = '".$temp_permission_type."' ";
	}
	else
	{
		$str_sql_pg_id = '';
	}
	
	if($search_keywords != '')
	{
		$str_sql_search_keywords = " AND ( `query` LIKE '%".$search_keywords."%' OR `aq_user_unique_id` LIKE '%".$search_keywords."%' )";
	}
	else
	{
		$str_sql_search_keywords = '';
	}
	
	$sql = "SELECT * FROM `tbladviserqueries` WHERE  `pro_user_id` = '".$pro_user_id."' AND `parent_aq_id` = '0' AND `from_user` = '1' AND DATE(aq_add_date) >= '".date('Y-m-d',strtotime($start_date))."' AND DATE(aq_add_date) <= '".date('Y-m-d',strtotime($end_date))."' ".$str_sql_user_id." ".$str_sql_pg_id."  ".$str_sql_search_keywords."  ORDER BY `aq_add_date` DESC";
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

function getUsersAllAdviserQueries($user_id,$pro_user_id,$pg_id,$start_date,$end_date,$search_keywords)
{
	global $link;
	$arr_aq_id = array(); 
	$arr_aq_user_unique_id = array(); 
	$arr_page_id = array(); 
	$arr_permission_type = array(); 
	$arr_user_id = array();
	$arr_name = array(); 
	$arr_email = array();
	$arr_feedback = array();
	$arr_pro_user_id = array();
	$arr_feedback_add_date = array();
	$arr_user_read = array();
	$arr_pro_user_read = array();
	
	if($pro_user_id != '')
	{
		$str_sql_pro_user_id = " AND `pro_user_id` = '".$pro_user_id."' ";
	}
	else
	{
		$str_sql_pro_user_id = '';
	}
	
	if($pg_id != '')
	{
		$arr_temp = explode('_',$pg_id);
		$temp_page_id = $arr_temp[0];
		$temp_permission_type = $arr_temp[1];
		
		$str_sql_pg_id = " AND `page_id` = '".$temp_page_id."' AND `permission_type` = '".$temp_permission_type."' ";
	}
	else
	{
		$str_sql_pg_id = '';
	}
	
	if($search_keywords != '')
	{
		$str_sql_search_keywords = " AND ( `query` LIKE '%".$search_keywords."%' OR `aq_user_unique_id` LIKE '%".$search_keywords."%' )";
	}
	else
	{
		$str_sql_search_keywords = '';
	}
	
	
	$sql = "SELECT * FROM `tbladviserqueries` WHERE  `user_id` = '".$user_id."' AND `parent_aq_id` = '0' AND `from_user` = '1' AND DATE(aq_add_date) >= '".date('Y-m-d',strtotime($start_date))."' AND DATE(aq_add_date) <= '".date('Y-m-d',strtotime($end_date))."' ".$str_sql_pro_user_id." ".$str_sql_pg_id." ".$str_sql_search_keywords."  ORDER BY `aq_add_date` DESC";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			 
			array_push($arr_aq_id , stripslashes($row['aq_id']));
			array_push($arr_aq_user_unique_id , stripslashes($row['aq_user_unique_id']));
			array_push($arr_page_id , stripslashes($row['page_id']));
			array_push($arr_permission_type , stripslashes($row['permission_type']));
			array_push($arr_user_id , stripslashes($row['user_id']));
			array_push($arr_name , stripslashes($row['user_name']));
			array_push($arr_email , stripslashes($row['user_email']));
			array_push($arr_feedback , stripslashes($row['query']));
			array_push($arr_feedback_add_date , stripslashes($row['aq_add_date']));
			array_push($arr_pro_user_id , stripslashes($row['pro_user_id']));
			array_push($arr_user_read , stripslashes($row['user_read']));
			array_push($arr_pro_user_read , stripslashes($row['pro_user_read']));
								
		}	
	}
	return array($arr_aq_id,$arr_aq_user_unique_id,$arr_page_id,$arr_permission_type,$arr_user_id,$arr_name,$arr_email,$arr_feedback,$arr_feedback_add_date,$arr_pro_user_id,$arr_user_read,$arr_pro_user_read);
}
function getUserAqUniqueId($user_id)
{
	global $link;
	$return = '';
	
	$name = getUserFullNameById($user_id);
	if($name != '')
	{
		$str_name = strtoupper(substr($name,0,4));
		
		$sql = "SELECT * FROM `tbladviserqueries` WHERE `user_id` = '".$user_id."' AND `from_user` = '1' ";
		//echo $sql;
		$result = mysql_query($sql,$link);
		if( ($result) )
		{
			$num_rows = mysql_num_rows($result) + 1;
			
			if(strlen($num_rows) == 1)
			{
				$num_rows = '0000'.$num_rows;
			}
			elseif(strlen($num_rows) == 2)
			{
				$num_rows = '000'.$num_rows;
			}
			elseif(strlen($num_rows) == 3)
			{
				$num_rows = '00'.$num_rows;
			}
			elseif(strlen($num_rows) == 4)
			{
				$num_rows = '0'.$num_rows;
			}
			else
			{
				$num_rows = $num_rows;
			}
			$return = $str_name.$num_rows;
		}
	}
	return $return;
}
function getProUserAqUniqueId($pro_user_id)
{
	global $link;
	$return = '';
	
	$name = getProUserFullNameById($pro_user_id);
	if($name != '')
	{
		$str_name = strtoupper(substr($name,0,4));
		
		$sql = "SELECT * FROM `tbladviserqueries` WHERE `pro_user_id` = '".$pro_user_id."' AND `from_user` = '0' ";
		//echo $sql;
		$result = mysql_query($sql,$link);
		if( ($result) )
		{
			$num_rows = mysql_num_rows($result) + 1;
			
			if(strlen($num_rows) == 1)
			{
				$num_rows = '0000'.$num_rows;
			}
			elseif(strlen($num_rows) == 2)
			{
				$num_rows = '000'.$num_rows;
			}
			elseif(strlen($num_rows) == 3)
			{
				$num_rows = '00'.$num_rows;
			}
			elseif(strlen($num_rows) == 4)
			{
				$num_rows = '0'.$num_rows;
			}
			else
			{
				$num_rows = $num_rows;
			}
			$return = $str_name.$num_rows;
		}
	}
	return $return;
}
function addAdviserQuery($parent_aq_id,$page_id,$user_id,$name,$email,$pro_user_id,$from_user,$query)
{
	global $link;
	$return = false;
	
	if($page_id == '')
	{
		$temp_page_id = '0';
		$temp_permission_type = '0';
	}	
	else
	{
		$arr_temp = explode('_',$page_id);
		$temp_page_id = $arr_temp[0];
		$temp_permission_type = $arr_temp[1];
	}
	
	if($from_user == '1')
	{
		$aq_user_unique_id = getUserAqUniqueId($user_id);
	}
	else
	{
		$aq_user_unique_id = getProUserAqUniqueId($pro_user_id);	
	}	
	

	$sql = "INSERT INTO `tbladviserqueries`(`parent_aq_id`,`aq_user_unique_id`,`page_id`,`permission_type`,`user_id`,`user_name`,`user_email`,`pro_user_id`,`query`,`from_user`,`aq_status`) VALUES ('".addslashes($parent_aq_id)."','".addslashes($aq_user_unique_id)."','".addslashes($temp_page_id)."','".addslashes($temp_permission_type)."','".addslashes($user_id)."','".addslashes($name)."','".addslashes($email)."','".addslashes($pro_user_id)."','".addslashes($query)."','".addslashes($from_user)."','1')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
	}
	
	return $return;
}	
function getUsersAdviserOptions($user_id,$pro_user_id)
{
	global $link;
	$option_str = '';	
	$email = getUserEmailById($user_id);	
		
	$sql = "SELECT * FROM `tbladviserreferrals` AS tar LEFT JOIN `tblprofusers` AS tpu ON tar.pro_user_id = tpu.pro_user_id  WHERE tar.user_email = '".$email."' AND tar.request_status = '1' ORDER BY tpu.name ASC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			 
			if($row['pro_user_id'] == $pro_user_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['pro_user_id'].'" '.$sel.'>'.stripslashes($row['name']).'</option>';
			
		}
	}
	return $option_str;
}

function getUsersAllAdviserOptions($user_id,$pro_user_id)
{
	global $link;
	$option_str = '';	
	$email = getUserEmailById($user_id);	
		
	$sql = "SELECT * FROM `tbladviserreferrals` AS tar LEFT JOIN `tblprofusers` AS tpu ON tar.pro_user_id = tpu.pro_user_id  WHERE tar.user_email = '".$email."' ORDER BY tpu.name ASC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			 
			if($row['pro_user_id'] == $pro_user_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['pro_user_id'].'" '.$sel.'>'.stripslashes($row['name']).'</option>';
			
		}
	}
	return $option_str;
}
function getAdviserQueryPageOptions($page_id,$user_id,$pro_user_id,$show_all)
{
	global $link;
	$option_str = '';
	
	if($page_id == '0_0')
	{
		$sel = ' selected ';
	}
	else
	{
		$sel = '';
	}		
	$option_str .= '<option value="0_0" '.$sel.'>My Query</option>';	
	
	list($str_report_id,$str_permission_type) = getUserAcceptedReportId($user_id,$pro_user_id);
	if($str_report_id != '')
	{	
		$arr_report_id = explode(',',$str_report_id); 
		$arr_permission_type = explode(',',$str_permission_type);
		
		for($i=0;$i<count($arr_report_id);$i++)
		{ 
			$sql = "SELECT * FROM `tblusersreports` WHERE report_id = '".$arr_report_id[$i]."' ORDER BY `report_name` ASC";
			//echo $sql;
			$result = mysql_query($sql,$link);
			if( ($result) && (mysql_num_rows($result) > 0) )
			{
				while($row = mysql_fetch_array($result) ) 
				{
					if($page_id == $row['report_id'].'_1')
					{
						$sel1 = '';
						$sel2 = ' selected ';
					}
					elseif($page_id == $row['report_id'].'_0')
					{
						$sel1 = ' selected ';
						$sel2 = '';
					}	
					else
					{
						$sel1 = '';
						$sel2 = '';
					}	
					
					if($arr_permission_type[$i] == '2')
					{	
						$option_str .= '<option value="'.$row['report_id'].'_0" '.$sel1.'>'.stripslashes($row['report_name']).' (Standard Set)</option>';
					}
					elseif($arr_permission_type[$i] == '3')
					{	
						$option_str .= '<option value="'.$row['report_id'].'_1" '.$sel2.'>'.stripslashes($row['report_name']).' (Adviser Set)</option>';
					}	
					else
					{	
						$option_str .= '<option value="'.$row['report_id'].'_0" '.$sel1.'>'.stripslashes($row['report_name']).' (Standard Set)</option>';
						$option_str .= '<option value="'.$row['report_id'].'_1" '.$sel2.'>'.stripslashes($row['report_name']).' (Adviser Set)</option>';
					}
				}
			}
		}
	}
	elseif($show_all == '1')
	{
		$sql = "SELECT * FROM `tblusersreports` ORDER BY `report_name` ASC";
		//echo $sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			while($row = mysql_fetch_array($result) ) 
			{
			
				$sql2 = "SELECT * FROM `tbladviserplanatributes` WHERE `ref_report_id` = '".$row['report_id']."' AND `apa_status` = '1' AND `show_for_user` = '1' ORDER BY `apa_id` DESC LIMIT 1";
				//echo $sql;
				$result2 = mysql_query($sql2,$link);
				if( ($result2) && (mysql_num_rows($result2) > 0) )
				{
					$row2 = mysql_fetch_array($result2);
					$temp_apa_id = $row2['apa_id'];
					if(chkUserPlanFeaturePermission($user_id,$temp_apa_id))
					{
						if($page_id == $row['report_id'].'_1')
						{
							$sel1 = '';
							$sel2 = ' selected ';
						}
						elseif($page_id == $row['report_id'].'_0')
						{
							$sel1 = ' selected ';
							$sel2 = '';
						}
						else
						{
							$sel1 = '';
							$sel2 = '';
						}	
						
						$option_str .= '<option value="'.$row['report_id'].'_0" '.$sel1.'>'.stripslashes($row['report_name']).' (Standard Set)</option>';
						$option_str .= '<option value="'.$row['report_id'].'_1" '.$sel2.'>'.stripslashes($row['report_name']).' (Adviser Set)</option>';
					}
				}
			}
		}
	}		
		
		
	return $option_str;
}
function getUserQueryPageOptions($page_id,$user_id,$pro_user_id)
{
	global $link;
	$option_str = '';
	
	if($page_id == '0_0')
	{
		$sel = ' selected ';
	}
	else
	{
		$sel = '';
	}		
	$option_str .= '<option value="0_0" '.$sel.'>My Query</option>';	
	
	list($str_report_id,$str_permission_type) = getUserAcceptedReportId($user_id,$pro_user_id);
	if($str_report_id != '')
	{	
		$arr_report_id = explode(',',$str_report_id); 
		$arr_permission_type = explode(',',$str_permission_type);
		
		for($i=0;$i<count($arr_report_id);$i++)
		{ 
			$sql = "SELECT * FROM `tblusersreports` WHERE report_id = '".$arr_report_id[$i]."' ORDER BY `report_name` ASC";
			//echo $sql;
			$result = mysql_query($sql,$link);
			if( ($result) && (mysql_num_rows($result) > 0) )
			{
				while($row = mysql_fetch_array($result) ) 
				{
					if($page_id == $row['report_id'].'_1')
					{
						$sel1 = '';
						$sel2 = ' selected ';
					}
					elseif($page_id == $row['report_id'].'_0')
					{
						$sel1 = ' selected ';
						$sel2 = '';
					}	
					else
					{
						$sel1 = '';
						$sel2 = '';
					}	
					
					if($arr_permission_type[$i] == '2')
					{	
						$option_str .= '<option value="'.$row['report_id'].'_0" '.$sel1.'>'.stripslashes($row['report_name']).' (Standard Set)</option>';
					}
					elseif($arr_permission_type[$i] == '3')
					{	
						$option_str .= '<option value="'.$row['report_id'].'_1" '.$sel2.'>'.stripslashes($row['report_name']).' (Adviser Set)</option>';
					}	
					else
					{	
						$option_str .= '<option value="'.$row['report_id'].'_0" '.$sel1.'>'.stripslashes($row['report_name']).' (Standard Set)</option>';
						$option_str .= '<option value="'.$row['report_id'].'_1" '.$sel2.'>'.stripslashes($row['report_name']).' (Adviser Set)</option>';
					}
				}
			}
		}
	}
	else
	{
		$sql = "SELECT * FROM `tblusersreports` ORDER BY `report_name` ASC";
		//echo $sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			while($row = mysql_fetch_array($result) ) 
			{
				if($page_id == $row['report_id'].'_1')
				{
					$sel1 = '';
					$sel2 = ' selected ';
				}
				elseif($page_id == $row['report_id'].'_0')
				{
					$sel1 = ' selected ';
					$sel2 = '';
				}
				else
				{
					$sel1 = '';
					$sel2 = '';
				}	
				
				$option_str .= '<option value="'.$row['report_id'].'_0" '.$sel1.'>'.stripslashes($row['report_name']).' (Standard Set)</option>';
				$option_str .= '<option value="'.$row['report_id'].'_1" '.$sel2.'>'.stripslashes($row['report_name']).' (Adviser Set)</option>';
				
				
			}
		}
	}			
		
		
	return $option_str;
}
function showUserQueryPopup($pro_user_id,$parent_aq_id)
{
	global $link;
	$output = '';
	
	
	$readonly = ' readonly ';
	$temp_page_id = '';
	$temp_pro_user_id = '';
	
	if($parent_aq_id == '' || $parent_aq_id == '0'  || $parent_aq_id == 0)
	{
		$readonly2 = '';
		$parent_aq_id = '0';
	}
	else
	{
		$query_data = getAdviserQueryDetails($parent_aq_id);
		$temp_page_id = $query_data[0]['page_id'];
		$temp_user_id = $query_data[0]['user_id'];
		$name = $query_data[0]['user_name'];
		$email = $query_data[0]['user_email'];
		$temp_query = $query_data[0]['query'];
		$readonly2 = ' readonly ';
		
		$output .= '<br><br>
				<form id="frmadviserquery" name="frmadviserquery" method="post" action="#" enctype="multipart/form-data">
					<input type="hidden" name="hdnparent_aq_id" id="hdnparent_aq_id" value="'.$parent_aq_id.'" />
					<input type="hidden" name="hdntemp_pro_user_id" id="hdntemp_pro_user_id" value="'.$pro_user_id.'" />
					<input type="hidden" name="hdntemp_user_id" id="hdntemp_user_id" value="'.$temp_user_id.'" />
					<input type="hidden" name="hdntemp_page_id" id="hdntemp_page_id" value="'.$temp_page_id.'" />
					<input type="hidden" name="hdnname" id="hdnname" value="'.$name.'" />
					<input type="hidden" name="hdnemail" id="hdnemail" value="'.$email.'" />
					<input type="hidden" name="hdnfrom_user" id="from_user" value="0" />
					<table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">
						<tr>
							<td width="60%" height="40" align="left" valign="top">Reference:</td>
							<td width="40%" height="40" align="left" valign="top">'.getReportTypeName($temp_page_id).'</td>
						</tr>
						<tr>
							<td width="60%" height="40" align="left" valign="top">Name:</td>
							<td width="40%" height="40" align="left" valign="top">'.$name.'</td>
						</tr>
						<tr>
							<td width="60%" height="40" align="left" valign="top">Email:</td>
							<td width="40%" height="40" align="left" valign="top">'.$email.'</td>
						</tr>
						<tr>
							<td width="60%" height="110" align="left" valign="top">Query:</td>
							<td width="40%" height="110" align="left" valign="top">'.$temp_query.'</td>
						</tr>
						<tr>
							<td width="60%" height="110" align="left" valign="top">Reply:</td>
							<td width="40%" height="110" align="left" valign="top">
							<textarea  cols="30" rows="5" type="text" id="feedback" name="feedback"></textarea>
							</td>
						</tr>
						<tr>
							<td width="60%" height="40" align="left" valign="middle">&nbsp;</td>
							<td width="40%" height="40" align="left" valign="middle">
							<input name="submit" type="button" class="button" id="submit" value="Submit"  onclick="replyUserQuery()"/>
							</td>
						</tr>   
					</table>
				</form>';
	}
	
	
	return $output;
}
function showAdviserQueryPopup($user_id,$parent_aq_id)
{
	global $link;
	$output = '';
	
	$name = getUserFullNameById($user_id);
	$email = getUserEmailById($user_id);
	$readonly = ' readonly ';
	
	$temp_pro_user_id = '';
	
	if($parent_aq_id == '' || $parent_aq_id == '0'  || $parent_aq_id == 0)
	{
		$readonly2 = '';
		$parent_aq_id = '0';
		$temp_page_id = '';
	}
	else
	{
		$query_data = getAdviserQueryDetails($parent_aq_id);
		$temp_pro_user_id = $query_data[0]['pro_user_id'];
		$temp_page_id = $query_data[0]['page_id'].'_'.$query_data[0]['permission_type'];
		$readonly2 = ' readonly ';
	}
	$output .= '<br><br>
				<form id="frmadviserquery" name="frmadviserquery" method="post" action="#" enctype="multipart/form-data">
					<input type="hidden" name="hdnparent_aq_id" id="hdnparent_aq_id" value="'.$parent_aq_id.'" />
					<input type="hidden" name="hdnname" id="hdnname" value="'.$name.'" />
					<input type="hidden" name="hdnemail" id="hdnemail" value="'.$email.'" />
					<table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">';
	
	if($parent_aq_id == '0')
	{
	$output .= '		<tr>
							<td width="60%" height="40" align="left" valign="top">Adviser:</td>
							<td width="40%" height="40" align="left" valign="top">
								<select id="temp_pro_user_id" name="temp_pro_user_id" '.$readonly2.' onchange="getAdviserQueryPageOptions('.$user_id.',\''.$readonly2.'\',\'temp_pro_user_id\',\'temp_page_id\')" style="width:150px;">
									<option value="">Select Adviser</option>
									'.getUsersAdviserOptions($user_id,$temp_pro_user_id).'
								</select>
							</td>
						</tr>
						<tr>
							<td width="60%" height="40" align="left" valign="top">Reference:</td>
							<td width="40%" height="40" align="left" valign="top" id="idreference">
								<select id="temp_page_id" name="temp_page_id" '.$readonly2.' style="width:150px;">
									<option value="">Select Reference</option>
									'.getAdviserQueryPageOptions($temp_page_id,$user_id,$temp_pro_user_id,'0').'
								</select>
							</td>
						</tr>';
		}
		else
		{
			$output .= '<tr>
							<td width="60%" height="40" align="left" valign="top">Adviser:</td>
							<td width="40%" height="40" align="left" valign="top">'.getProUserFullNameById($temp_pro_user_id).'
								<input type="hidden" id="temp_pro_user_id" name="temp_pro_user_id" value="'.$temp_pro_user_id.'" >
							</td>
						</tr>
						<tr>
							<td width="60%" height="40" align="left" valign="top">Reference:</td>
							<td width="40%" height="40" align="left" valign="top" id="idreference">'.getReportTypeName($temp_page_id).'
								<input type="hidden" id="temp_page_id" name="temp_page_id" value="'.$temp_page_id.'">
							</td>
						</tr>';
		
		}				
		
		/*
		$output .= '	<tr>
							<td width="60%" height="40" align="left" valign="top">Name:</td>
							<td width="40%" height="40" align="left" valign="top">
								<input type="text" id="name" name="name" '.$readonly.' value="'.$name.'"/>
							</td>
						</tr>';
						
		$output .= '	<tr>
							<td width="60%" height="40" align="left" valign="top">Email:</td>
							<td width="40%" height="40" align="left" valign="top">
								<input type="text" id="email" name="email" '.$readonly.' value="'.$email.'"/>
							</td>
						</tr>';
		*/				
		$output .= '	<tr>
							<td width="60%" height="110" align="left" valign="top">Query:</td>
							<td width="40%" height="110" align="left" valign="top">
							<textarea  cols="30" rows="5" type="text" id="feedback" name="feedback"></textarea>
							</td>
						</tr>
						<tr>
							<td width="60%" height="40" align="left" valign="middle">&nbsp;</td>
							<td width="40%" height="40" align="left" valign="middle">
							<input name="submit" type="button" class="button" id="submit" value="Submit"  onclick="addAdviserQuery()"/>
							</td>
						</tr>   
					</table>
				</form>';
	
	return $output;
}

function chkIfAdviserRequestDateisUpdated($pro_user_id,$user_id)
{
	global $link;
	$return = true;
	
	$user_email = getUserEmailById($user_id);
	$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `request_accept_date` = '0000-00-00 00:00:00'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = false;
	}

	return $return;
}

function doAcceptAdviserInvitation($ar_id,$report_id,$user_id,$pro_user_id,$permission_type)
{
	global $link;
	$return = false;
	
	if(chkIfAdviserRequestDateisUpdated($pro_user_id,$user_id))
	{
		$sql = "UPDATE `tbladviserreferrals` SET `request_status` = '1' , `report_id` = '".$report_id."' , `permission_type` = '".$permission_type."' WHERE `ar_id` = '".$ar_id."'";
	}
	else
	{
		$sql = "UPDATE `tbladviserreferrals` SET `request_accept_date` = NOW() , `request_status` = '1' , `report_id` = '".$report_id."' , `permission_type` = '".$permission_type."' WHERE `ar_id` = '".$ar_id."'";
	}
	
	
	$result = mysql_query($sql,$link);
	if($result)
	{
		$sql2 = "INSERT INTO `tbladviserreportpermission`(`ar_id`,`user_id`,`pro_user_id`,`report_id`,`permission_type`) VALUES('".$ar_id."','".$user_id."','".$pro_user_id."','".$report_id."','".$permission_type."')";
		$result2 = mysql_query($sql2,$link);
		if($result2)
		{
			
			$return = true;
		}
	}
	return $return;
	 
}

function declineAdviserInvitation($ar_id,$user_id,$pro_user_id)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tbladviserreferrals` SET `request_accept_date` = NOW() , `request_status` = '2' WHERE `ar_id` = '".$ar_id."' AND `pro_user_id` = '".$pro_user_id."'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}

function deactivateAdviserInvitation($ar_id,$user_id,$pro_user_id,$status_reason)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tbladviserreferrals` SET `request_status` = '3' WHERE `ar_id` = '".$ar_id."' AND `pro_user_id` = '".$pro_user_id."'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$sql2 = "INSERT INTO `tbladviseractivation`(`ar_id`,`user_id`,`pro_user_id`,`aa_status`,`aa_status_reason`) VALUES('".$ar_id."','".$user_id."','".$pro_user_id."','3','".addslashes($status_reason)."')";
		$result2 = mysql_query($sql2,$link);
		if($result2)
		{
			
			$return = true;
		}
	}
	return $return;
}

function activateAdviserInvitation($ar_id,$user_id,$pro_user_id,$status_reason)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tbladviserreferrals` SET `request_status` = '1' WHERE `ar_id` = '".$ar_id."' AND `pro_user_id` = '".$pro_user_id."'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$sql2 = "INSERT INTO `tbladviseractivation`(`ar_id`,`user_id`,`pro_user_id`,`aa_status`,`aa_status_reason`) VALUES('".$ar_id."','".$user_id."','".$pro_user_id."','1','".addslashes($status_reason)."')";
		$result2 = mysql_query($sql2,$link);
		if($result2)
		{
			
			$return = true;
		}
	}
	return $return;
}

function chkReportTypePermissionForAdviser($ar_id,$report_id)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tbladviserreferrals` WHERE `ar_id` = '".$ar_id."' AND `report_id` != '' AND FIND_IN_SET('".$report_id."', report_id)";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	
	return $return;
}
function getPermissionTypeForAdviserReport($ar_id,$report_id)
{
	global $link;
	$return = '1';
	
	if(chkReportTypePermissionForAdviser($ar_id,$report_id))
	{
		$sql = "SELECT * FROM `tbladviserreferrals` WHERE `ar_id` = '".$ar_id."' ";
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$row = mysql_fetch_assoc($result);
			$str_report_id = stripslashes($row['report_id']);
			$str_permission_type = stripslashes($row['permission_type']);
			
			if($str_permission_type != '')
			{
				$arr_ri = explode(',',$str_report_id);
				$arr_pt = explode(',',$str_permission_type);
				
				$key = array_search($report_id, $arr_ri);
				if($key !== FALSE )
				{
					if(isset($arr_pt[$key]))
					{
						$return = $arr_pt[$key];
					}
				} 
			}
			
		}
	}
		
	return $return;
}
function showAcceptInvitationPopup($user_id,$ar_id,$pro_user_id)
{
	global $link;
	$output = '';
	$output .= '<div style="margin-top:15px;width:520px;height:400px;overflow:scroll;">';
	$output .= '	<table width="500" border="0" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
					<tbody>
						<tr>
							<td height="30" colspan="2" align="left" valign="middle"><strong>I authorise Chaitanya Wellness (www.wellnessway4u.com) to provide access to my Adviser herein to MY following below Reports, solely at my Responsibility. I reconfirm that I have carefully read the Terms of Use for Users of this website. </strong></td>
						</tr>';
						
				
						
	$sql = "SELECT * FROM `tblusersreports` ORDER BY report_name ASC ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$i = 0;
		$j = 1;
		while ($row = mysql_fetch_assoc($result)) 
		{
			$report_name = stripslashes($row['report_name']);
			$report_id = stripslashes($row['report_id']);
			
			$sql2 = "SELECT * FROM `tbladviserplanatributes` WHERE `ref_report_id` = '".$row['report_id']."' AND `apa_status` = '1' AND `show_for_user` = '1' ORDER BY `apa_id` DESC LIMIT 1";
			//echo $sql;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$row2 = mysql_fetch_array($result2);
				$temp_apa_id = $row2['apa_id'];
				if(chkUserPlanFeaturePermission($user_id,$temp_apa_id))
				{
			
			
			
					if(chkReportTypePermissionForAdviser($ar_id,$report_id))
					{
						$selected = ' checked ';
						$selval = getPermissionTypeForAdviserReport($ar_id,$report_id);
						if($selval == '2')
						{
							$pt_selected1 = '';
							$pt_selected2 = ' selected ';
							$pt_selected3 = '';
						}	
						elseif($selval == '3')
						{
							$pt_selected1 = '';
							$pt_selected2 = '';
							$pt_selected3 = ' selected ';
						}	
						else
						{
							$pt_selected1 = ' selected ';
							$pt_selected2 = '';
							$pt_selected3 = '';
						}	
					}
					else
					{
						$selected = '';
						$pt_selected1 = ' selected ';
						$pt_selected2 = '';
						$pt_selected3 = '';
					}

	$output .= '		<tr>
							<td width="300" height="30" align="left" valign="middle"><strong><input type="checkbox" '.$selected.' name="report_id" id="report_id_'.$i.'" value="'.$row['report_id'].'" />&nbsp;<strong>'.$report_name.'</strong></td>
							<td width="200" height="30" align="left" valign="middle">
								<select name="permission_type" id="permission_type_'.$i.'">
									<option value="1" '.$pt_selected1.' >Both Set</option>
									<option value="2" '.$pt_selected2.' >Standard Set</option>
									<option value="3" '.$pt_selected3.' >Adviser Set</option>
								</select>
							</td>
							
						</tr>';
						
					$i++;	
					$j++;		
				}
			}			
		}
		
		$output .= '		<tr>
							<td height="30" align="left" valign="middle"><strong><input type="button" name="btnDoAccept" id="btnDoAccept" value="Confirm" onclick="doAcceptAdviserInvitation(\''.$ar_id.'\',\''.$pro_user_id.'\')" />&nbsp;&nbsp;<input type="button" name="btnCancelPopup" id="btnCancelPopup" value="Cancel" /></strong></td>
							
						</tr>';		
	}					
	
	
	$output .= '	</tbody>
					</table>
				</div>';
	return $output;
}

function showDeactivateAdviserInvitationPopup($ar_id,$pro_user_id)
{
	global $link;
	$output = '';
	$output .= '<div style="margin-top:15px;width:520px;height:400px;overflow:scroll;">';
	$output .= '	<table width="500" border="0" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
					<tbody>
						';
						
				
	$output .= '		<tr>
							<td colspan="2" align="left" valign="middle" height="40">&nbsp;</td>
						</tr>';					
	

	$output .= '		<tr>
							<td width="35%" align="left" valign="top"><strong><span style="font-size:14px;">Reason for Deactivation:</span></strong></td>
							<td width="65%" align="left" valign="top"><textarea id="status_reason" name="status_reason" style="width:200px;height:100px;"></textarea></td>
						</tr>';
						
	$output .= '		<tr>
							<td colspan="2" align="left" valign="middle" height="40">&nbsp;</td>
						</tr>';							
						
			
		
		$output .= '		<tr>
							<td colspan="2" height="30" align="left" valign="middle"><strong><input type="button" name="btnDoAccept" id="btnDoAccept" value="Deactivate" onclick="deactivateAdviserInvitation(\''.$ar_id.'\',\''.$pro_user_id.'\')" />&nbsp;&nbsp;<input type="button" name="btnCancelPopup" id="btnCancelPopup" value="Cancel" /></strong></td>
							
						</tr>';		
					
	
	
	$output .= '	</tbody>
					</table>
				</div>';
	return $output;
}

function showActivateAdviserInvitationPopup($ar_id,$pro_user_id)
{
	global $link;
	$output = '';
	$output .= '<div style="margin-top:15px;width:520px;height:400px;overflow:scroll;">';
	$output .= '	<table width="500" border="0" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
					<tbody>
						';
						
				
	$output .= '		<tr>
							<td colspan="2" align="left" valign="middle" height="40">&nbsp;</td>
						</tr>';					
	

	$output .= '		<tr>
							<td width="35%" align="left" valign="top"><strong><span style="font-size:14px;">Reason for Activation:</span></strong></td>
							<td width="65%" align="left" valign="top"><textarea id="status_reason" name="status_reason" style="width:200px;height:100px;"></textarea></td>
						</tr>';
						
	$output .= '		<tr>
							<td colspan="2" align="left" valign="middle" height="40">&nbsp;</td>
						</tr>';							
						
			
		
		$output .= '		<tr>
							<td colspan="2" height="30" align="left" valign="middle"><strong><input type="button" name="btnDoAccept" id="btnDoAccept" value="Activate" onclick="activateAdviserInvitation(\''.$ar_id.'\',\''.$pro_user_id.'\')" />&nbsp;&nbsp;<input type="button" name="btnCancelPopup" id="btnCancelPopup" value="Cancel" /></strong></td>
							
						</tr>';		
				
	
	
	$output .= '	</tbody>
					</table>
				</div>';
	return $output;
}


function getAllMyAdviserInvitations($user_email,$pro_user_id)
{
	global $link;
	$temp_arr = array();
	
	if($pro_user_id != '')
	{
		$str_sql_pro_user_id = " AND tar.pro_user_id = '".$pro_user_id."' ";
	}
	else
	{
		$str_sql_pro_user_id = "";
	}
    
    $sql = "SELECT * FROM `tbladviserreferrals` AS tar LEFT JOIN `tblprofusers` AS tpf ON tar.pro_user_id = tpf.pro_user_id WHERE tar.user_email = '".$user_email."'  ".$str_sql_pro_user_id." ORDER BY tar.request_sent_date DESC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_assoc($result))
		{
			$temp_arr[] = $row;
			//echo '<br><br><pre>';
			//print_r($row);
			//echo '<br></pre>';
		}
	}
	return $temp_arr;
}

function getAllAdviserUserReferrals($pro_user_id)
{
    global $link;
	$temp_arr = array();
    
    $sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."'";
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

function getNameAndEmailOfAdviserReferral($arid)
{
    global $link;
	$user_email = '';
	$user_name = '';
	
    $sql = "SELECT * FROM `tbladviserreferrals` WHERE `ar_id` = '".$arid."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$user_email = stripslashes($row['user_email']);
		$user_name = stripslashes($row['user_name']);
	}
	
	return array($user_email,$user_name);
}


function updateAdvisorsReferral($ar_id,$pro_user_id,$user_email)
{	
	global $link;
	$return = false;
	$sql = "UPDATE `tbladviserreferrals` SET `referral_accept_date` = NOW() , `referral_status` = '1' WHERE `ar_id` = '".$ar_id."' AND `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}

function addAdvisorsReferral($pro_user_id,$user_email,$user_name,$message,$new_user)
{
	global $link;
	$ar_id = 0;

	$sql = "INSERT INTO `tbladviserreferrals`(`pro_user_id`,`user_email`,`user_name`,`message`,`request_status`,`new_user`) VALUES ('".addslashes($pro_user_id)."','".addslashes($user_email)."','".addslashes($user_name)."','".addslashes($message)."','0','".addslashes($new_user)."')";
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$ar_id = mysql_insert_id($link);
	}
	
	return $ar_id;
}
function chkIfRequestAlreadySentByAdviser($pro_user_id,$user_email)
{
    global $link;
	$return = false;
	
    $sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		if($row['request_status'] != '2')
		{
			$return = true;
		}
	}
	return $return;
}

function updateSoundFile($music,$day,$credit,$credit_url,$status,$music_id,$practitioner_id,$country_id,$state_id,$city_id,$place_id,$user_id,$keywords)
{
	global $link;
	$return = false;
	$sql = "UPDATE `tblmusic` SET `music` = '".addslashes($music)."' , `credit` = '".addslashes($credit)."', `credit_url` = '".addslashes($credit_url)."', `status` = '".addslashes($status)."',`day` = '".addslashes($day)."'  ,`country_id` = '".addslashes($country_id)."'  ,`state_id` = '".addslashes($state_id)."'  ,`city_id` = '".addslashes($city_id)."'  ,`place_id` = '".addslashes($place_id)."'  ,`user_id` = '".addslashes($user_id)."'  ,`keywords` = '".addslashes($keywords)."'   WHERE `music_id` = '".$music_id."' AND `practitioner_id` = '".$practitioner_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
	}
	return $return;
}

function getSounfFileDetailsFront($music_id,$practitioner_id)
{
	global $link;
	$music = '';
	$credit = '';
	$credit_url = '';
	$day = '';
	$status = '';
	$country_id = '';
	$state_id = '';
	$city_id = '';
	$place_id = '';
	$user_id = '';
	$keywords = '';
			
	$sql = "SELECT * FROM `tblmusic` WHERE `music_id` = '".$music_id."' AND `practitioner_id` = '".$practitioner_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$music = stripslashes($row['music']);
		$credit = stripslashes($row['credit']);
		$credit_url = stripslashes($row['credit_url']);
		$status = stripslashes($row['status']);
		$day = stripslashes($row['day']);
		$country_id = stripslashes($row['country_id']);
		$state_id = stripslashes($row['state_id']);
		$city_id = stripslashes($row['city_id']);
		$place_id = stripslashes($row['place_id']);
		$user_id = stripslashes($row['user_id']);
		$keywords = stripslashes($row['keywords']);
	}
	return array($music,$day,$credit,$credit_url,$status,$country_id,$state_id,$city_id,$place_id,$user_id,$keywords);
}
?>