<?php
function getScrollingWindowsPagesOptions($page_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_list` = '1' ORDER BY `menu_title` ASC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			if($row['page_id'] == $page_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			
			
			$option_str .= '<option value="'.$row['page_id'].'" '.$sel.'>'.stripslashes($row['menu_title']).'</option>';
		}
	}
	return $option_str;
}

function getFavCategoryOptions($fav_cat_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_type_id` IN (1,2) AND `fav_cat_status` = '1' AND `fav_cat_deleted` = '0' ORDER BY `fav_cat` ASC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			if($row['fav_cat_id'] == $fav_cat_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			
			
			$option_str .= '<option value="'.$row['fav_cat_id'].'" '.$sel.'>'.stripslashes($row['fav_cat']).'</option>';
		}
	}
	return $option_str;
}

function getMealName($meal_id)
{
	global $link;
	$meal_item = '';
			
	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$meal_item = stripslashes($row['meal_item']);
	}
	return $meal_item;
}

function getWAESituation($wae_id)
{
	global $link;
	$situation = '';
			
	$sql = "SELECT * FROM `tblworkandenvironments` WHERE `wae_id` = '".$wae_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
	}
	return $situation;
}

function getGSSituation($gs_id)
{
	global $link;
	$situation = '';
			
	$sql = "SELECT * FROM `tblgeneralstressors` WHERE `gs_id` = '".$gs_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
	}
	return $situation;
}

function getSleepSituation($sleep_id)
{
	global $link;
	$situation = '';
			
	$sql = "SELECT * FROM `tblsleeps` WHERE `sleep_id` = '".$sleep_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
	}
	return $situation;
}

function getMCSituation($mc_id)
{
	global $link;
	$situation = '';
			
	$sql = "SELECT * FROM `tblmycommunications` WHERE `mc_id` = '".$mc_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
	}
	return $situation;
}

function getMRSituation($mr_id)
{
	global $link;
	$situation = '';
			
	$sql = "SELECT * FROM `tblmyrelations` WHERE `mr_id` = '".$mr_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
	}
	return $situation;
}

function getMLESituation($mle_id)
{
	global $link;
	$situation = '';
			
	$sql = "SELECT * FROM `tblmajorlifeevents` WHERE `mle_id` = '".$mle_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
	}
	return $situation;
}

function getADCTSituation($adct_id)
{
	global $link;
	$situation = '';
			
	$sql = "SELECT * FROM `tbladdictions` WHERE `adct_id` = '".$adct_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$situation = stripslashes($row['situation']);
	}
	return $situation;
}

function getScaleValue($scale)
{
	$value = '';
	if( ($scale >= 0) && ($scale <= 2) )
	{
		$value = $scale." (Very Low)";
	}
	elseif( ($scale >= 3) && ($scale <= 4) )
	{
		$value = $scale." (Low)";
	}
	elseif( ($scale >= 5) && ($scale <= 6) )
	{
		$value = $scale." (Average)";
	}
	elseif( ($scale >= 7) && ($scale <= 8) )
	{
		$value = $scale." (High)";
	}
	else
	{
		$value = $scale." (Very High)";
	}		
	
	return $value;
}



function getInterpetationValue($scale,$id,$page)
{
	global $link;
	$value = '';
	//echo $scale.'</br>';
	if($page == 'gs')
	{
		$sql = 'SELECT * FROM `tblgeneralstressors` WHERE gs_id = "'.$id.'"';
	}
	elseif($page == 'sleep')
	{
		$sql = 'SELECT * FROM `tblsleeps` WHERE sleep_id = "'.$id.'"';
	}
	elseif($page == 'mc')
	{
		$sql = 'SELECT * FROM `tblmycommunications` WHERE mc_id = "'.$id.'"';
	}
	elseif($page == 'mr')
	{
		$sql = 'SELECT * FROM `tblmyrelations` WHERE mr_id = "'.$id.'"';
	}
	elseif($page == 'mle')
	{
		$sql = 'SELECT * FROM `tblmajorlifeevents` WHERE mle_id = "'.$id.'"';
	}
	elseif($page == 'adct')
	{
		$sql = 'SELECT * FROM `tbladdictions` WHERE adct_id = "'.$id.'"';
	}
	elseif($page == 'wae')
	{
		$sql = 'SELECT * FROM `tblworkandenvironments` WHERE wae_id = "'.$id.'"';
	}
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		if( ($scale >= 0) && ($scale <= 2) )
		{
			$value = stripslashes($row['interpretaion_0_2']);
		}
		elseif( ($scale >= 3) && ($scale <= 4) )
		{
			$value = stripslashes($row['interpretaion_3_4']);
		}
		elseif( ($scale >= 5) && ($scale <= 6) )
		{
			$value = stripslashes($row['interpretaion_5_6']);
		}
		elseif( ($scale >= 7) && ($scale <= 8) )
		{
			$value = stripslashes($row['interpretaion_7_8']);
		}
		elseif( ($scale >= 8) && ($scale <= 9) )
		{
			$value = stripslashes($row['interpretaion_8_9']);
		}
		elseif( ($scale >= 9) && ($scale <= 10) )
		{
			$value = stripslashes($row['interpretaion_9_10']);
		}
	}	
	//echo $value.'</br>';
	return $value;
}

function getScaleImage($scale)
{
	global $link;
	$value = '';
	
	if($scale == 1)
	{
		$value = 'scale_slider_1.jpg';
	}
	elseif($scale == 2)
	{
		$value = 'scale_slider_2.jpg';
	}
	elseif($scale == 3)
	{
		$value = 'scale_slider_3.jpg';
	}
	elseif($scale == 4)
	{
		$value = 'scale_slider_4.jpg';
	}
	elseif($scale == 5)
	{
		$value = 'scale_slider_5.jpg';
	}
	elseif($scale == 6)
	{
		$value = 'scale_slider_6.jpg';
	}
	elseif($scale == 7)
	{
		$value = 'scale_slider_7.jpg';
	}
	elseif($scale == 8)
	{
		$value = 'scale_slider_8.jpg';
	}
	elseif($scale == 9)
	{
		$value = 'scale_slider_9.jpg';
	}
	elseif($scale == 10)
	{
		$value = 'scale_slider_10.jpg';
	}
	else
	{
		$value = 'scale_slider_0.jpg';
	}
	
	return $value;
}

function getFoodChartHTMLAdviser($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$output = '';
	list($return,$arr_date,$arr_records,$total_meal_entry) = getFoodChart($user_id,$start_date,$end_date);
	if( ($return) && ( count($arr_date) > 0 ) )
	{
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Food Chart</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="20%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
							<td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="19%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
							<td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
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
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
		$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
							<tr>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">SNo</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Food Constituents</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Recommended Dietary Allowance Per Day</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Average Requirement Per Day</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Upper Limit Per Day</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Average Quantity consumed per day for the Period</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Deficiency / Excess of Constituents Consumed on Average basis</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Deficiency / Excess of Constituents Consumed on Recommended values</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Observations</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Recommend</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Guideline</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Benefits</td>
							</tr>';	
							$j=1;
							foreach($arr_records as $key => $val)
							{ 
		$output .= '		<tr>
								<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$j.'</td>
								<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$key.'</td>
								<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['nutrientstdreq'].'</td>
								<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['nutrientavgreq'].'</td>
								<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['nutrientupperlimit'].'</td>
								<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['avg_qty_consumed'].'</td>
								<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['def_exc_avg_consumed'].'</td>
								<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['def_exc_rec_consumed'].'</td>
								<td height="30" align="left" valign="middle" bgcolor="#FFFFFF">'.$val['observations'].'</td>
								<td height="30" align="left" valign="middle" bgcolor="#FFFFFF">'.$val['recommend'].'</td>
								<td height="30" align="left" valign="middle" bgcolor="#FFFFFF">'.$val['guideline'].'</td>
								<td height="30" align="left" valign="middle" bgcolor="#FFFFFF">'.$val['benefits'].'</td>';
							
								$j++;
							}
		$output .= '					</tr>
						</table>';
						
				
	}
	return $output;	
}

function getActivityChartHTMLAdviser($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$output = '';
	list($return,$arr_date,$arr_records,$total_activity_entry,$arr_total_records) = getActivityChart($user_id,$start_date,$end_date);
	if( ($return) && ( count($arr_date) > 0 ) )
	{
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Activity Analysis Chart</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="20%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
							<td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="19%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
							<td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
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
							<td height="30" align="left" valign="middle"><strong>Total Activities Entry</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.$total_activity_entry.'</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>	
							<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
					
		for($i=0;$i<count($arr_date);$i++)
		{			
		$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
						<tr>
							<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date : '.date("d M Y",strtotime($arr_date[$i])).'('.date("l",strtotime($arr_date[$i])).')</td>
						</tr>
						<tr>
							<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Sleep Time : '.getUserSleepTime($user_id,$arr_date[$i]).'</td>
						</tr>
						<tr>
							<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Wake-up Time : '.getUserWakeUpTime($user_id,$arr_date[$i]).'</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td height="20" align="left" valign="middle">&nbsp;</td>
						</tr>
					</table>
					<table width="920" height="30" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
						<tr>
							<td width="25" height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">SNo</td>
							<td width="250" height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Activity</td>
							<td width="50" height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Time</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Duration</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Sedentary Activity(SA)</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Light Activity(LA)</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Moderate Activity(MA)</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Vigorous Activity(VA)</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Super Active(SUA)</td>
						</tr>	';	
						$j=1;
						foreach($arr_records[$arr_date[$i]] as $key => $val)
						{
							
	$output .= '		<tr>
							<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$j.'</td>
							<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getDailyActivityName($key).'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['time'].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['duration'].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['sa_cal_burned'].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['la_cal_burned'].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['ma_cal_burned'].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['va_cal_burned'].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['sua_cal_burned'].'</td>
						</tr>';
							$j++;
						}
		$output .= '	<tr>
							<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">&nbsp;</td>
							<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Total</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="font-weight: bold;">'.$arr_total_records[$arr_date[$i]]['total_sa_cal_burned'].'</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="font-weight: bold;">'.$arr_total_records[$arr_date[$i]]['total_la_cal_burned'].'</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="font-weight: bold;">'.$arr_total_records[$arr_date[$i]]['total_ma_cal_burned'].'</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="font-weight: bold;">'.$arr_total_records[$arr_date[$i]]['total_va_cal_burned'].'</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="font-weight: bold;">'.$arr_total_records[$arr_date[$i]]['total_sua_cal_burned'].'</td>
						</tr>       
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td height="20" align="left" valign="middle">&nbsp;</td>
						</tr>
					</table>';
		}			
	}
	return $output;	
}	
function getAngerVentIntensityReportHTMLAdviser($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$output = '';
	list($uavb_return,$arr_uavb_date,$arr_intensity_scale_1,$arr_intensity_scale_1_image,$arr_intensity_scale_2,$arr_intensity_scale_2_image,$arr_comment_box)= getAngerVentIntensityReport($user_id,$start_date,$end_date);
	if( ($uavb_return) && ( count($arr_uavb_date) > 0 ) )
	{
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td colspan="9" height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Angervent Intensity Report</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
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
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left" colspan="12"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
					
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
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
	}
	return $output;	
}
function getDatewiseEmotionsReportHTMLAdviser($user_id,$start_date,$end_date,$wae_report,$gs_report,$sleep_report,$mc_report,$mr_report,$mle_report,$adct_report,$permission_type,$pro_user_id)
{
	global $link;
	$return = false;
	$output = '';
	list($wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records) = getDatewiseEmotionsReport($user_id,$start_date,$end_date,$permission_type,$pro_user_id);
		
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
				<tbody>	
					<tr>	
						<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Emotions Report - Datewise</td>
					</tr>
					<tr>	
						<td height="30" align="left" valign="middle">&nbsp;</td>
					</tr>
				</tbody>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
						<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
						<td width="20%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
						<td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
						<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
						<td width="19%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
						<td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						<td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						<td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
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
				<table width="920" border="0" cellpadding="0" cellspacing="0">
				<tbody>	
					<tr>	
						<td align="left"><strong>Important:</strong></td>
					</tr>
					<tr>	
						<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
					</tr>
				</tbody>
				</table>';
				
	if( ($wae_return) && ($wae_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Work & Environment</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_wae_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['selected_wae_id']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getWAESituation($v['selected_wae_id'][$i]).'</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';	
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($gs_return) && ($gs_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">General Stressors</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_gs_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['selected_gs_id']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getGSSituation($v['selected_gs_id'][$i]).'</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';	
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($sleep_return) && ($sleep_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Sleep</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_sleep_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
					<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Sleep Time</td>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$v['sleep_time'][0].'</td>	
					</tr>
					<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Wake Up Time</td>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$v['wakeup_time'][0].'</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['selected_sleep_id']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getSleepSituation($v['selected_sleep_id'][$i]).'</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';	
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($mc_return) && ($mc_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">My Communication</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_mc_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['selected_mc_id']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getMCSituation($v['selected_mc_id'][$i]).'</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';	
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($mr_return) && ($mr_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">My Relations</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_mr_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['selected_mr_id']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getMRSituation($v['selected_mr_id'][$i]).'</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';	
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($mle_return) && ($mle_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Major Life Events</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_mle_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['selected_mle_id']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getMLESituation($v['selected_mle_id'][$i]).'</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';	
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($adct_return) && ($adct_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Addictions</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_adct_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['selected_adct_id']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getADCTSituation($v['selected_adct_id'][$i]).'</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';	
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}							
		
	return $output;	
}
function getDigitalPersonalWellnessDiaryHTMLAdviser($user_id,$start_date,$end_date,$food_report,$activity_report,$wae_report,$gs_report,$sleep_report,$mc_report,$mr_report,$mle_report,$adct_report,$report_title,$permission_type,$pro_user_id)
{
	global $link;
	$return = false;
	$output = '';
	list($food_return,$arr_meal_date,$arr_food_records,$activity_return,$arr_activity_date,$arr_activity_records,$wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records) = getDigitalPersonalWellnessDiary($user_id,$start_date,$end_date,$permission_type,$pro_user_id);
		
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>	
						<td colspan="9" height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">'.$report_title.'</td>
					</tr>
					<tr>	
						<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
					</tr>
					<tr>
						<td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
						<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
						<td width="20%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
						<td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
						<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
						<td width="19%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
						<td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						<td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						<td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
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
						<td height="30" colspan="4" align="left" valign="middle">'.getBMRObservationOfUser($user_id).'</td>
					</tr>
					<tr>	
						<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
					</tr>
				</tbody>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
				<tbody>	
					<tr>	
						<td align="left"><strong>Important:</strong></td>
					</tr>
					<tr>	
						<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
					</tr>
					<tr>	
						<td align="left" height="30">&nbsp;</td>
					</tr>
				</tbody>
				</table>';
				
	if( ($food_return) && ($food_report == '1') )
   	{ 
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
					<tr>
						<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Food</td>
					</tr>
				</table>
				<table width="920" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
					</tr>
				</table>';
		foreach($arr_food_records as $k => $v)
		{ 
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
					<tr>	
		   
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
					</table>	
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>	
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >	
						<tr>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>
							<td width="285" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Item</td>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Quantity</td>	
							<td width="65" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Desire</td>
							<td width="270" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Item Remarks</td>	
						</tr>';	
									for($i=0;$i<count($v['meal_id']);$i++)
									{ 
	$output .= '		<tr>
							<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$v['meal_time'][$i].'</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">';
										
										if($v['meal_id'][$i] == '9999999999')
										{
	$output .= '						'.$v['meal_others'][$i];
										}
										else
										{
	$output .= '						'.getMealName($v['meal_id'][$i]);
										}
										
	$output .= '			</td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['meal_quantity'][$i].' ('.$v['meal_measure'][$i].' )</td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['meal_like'][$i].'<br />'.getMealLikeIcon($v['meal_like'][$i]).'</td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['meal_consultant_remark'][$i].'</td>	
						</tr>';	
									} 
	$output .= '	</table>	
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';
		}
	$output .= '	<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';	
	}
	
	if( ($activity_return)  && ($activity_report == '1') )
   	{ 
	$output .= '    <table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Activity</td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';
		foreach($arr_activity_records as $k => $v)
		{ 
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>
							<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
						</tr>
					</table>	
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >				
						<tr>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>
							<td width="385" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Activity</td>	
							<td width="100" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Duration</td>	
							<td width="85" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Proper guidance</td>	
							<td width="200" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Precaution</td>	
						</tr>									
						<tr>
							<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.$v['today_wakeup_time'][0].'</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">Wake Up </td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"></td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"></td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"></td>	
						</tr>	';	
									for($i=0;$i<count($v['activity_id']);$i++)
									{ 
	$output .= '		<tr>
							<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.$v['activity_time'][$i].'</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">';
										
										if($v['activity_id'][$i] == '9999999999')
										{
	$output .= '						'.$v['other_activity'][$i];
										}
										else
										{
	$output .= '						'.getDailyActivityName($v['activity_id'][$i]);
										}
										
	$output .= '			</td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['mins'][$i].' Mins</td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['proper_guidance'][$i].'</td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['precaution'][$i].'</td>	
						</tr>';	
									} 
	$output .= '	</table>	
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';
		}
	$output .= '	<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';	
	}
	
	if( ($wae_return) && ($wae_report == '1') )
	{
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Work & Environment</td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';
		 foreach($arr_wae_records as $k => $v)
		 {
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>
							<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>
							<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		
						</tr>';	
						
			for($i=0;$i<count($v['selected_wae_id']);$i++)
			{ 
	$output .= '		<tr>
							<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.getWAESituation($v['selected_wae_id'][$i]).'</td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['scale'][$i].'<br/>
							 
								<img src="'.SITE_URL.'/images/'.$v['scale_image'][$i].'" width="320" height="30" border="0" />
							</td>   
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['responce'][$i].'</td>
						</tr>';	
			} 
	$output .= '		</table>	
						<table width="920" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
							</tr>
						</table>';	
		}
	$output .= '		<table width="920" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
							</tr>
						</table>';		
	
	}
	
	if( ($gs_return) && ($gs_report == '1') )
	{
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;General Stressors</td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';
		 foreach($arr_gs_records as $k => $v)
		 {
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>
							<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>
							<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>	
						</tr>';	
						
			for($i=0;$i<count($v['selected_gs_id']);$i++)
			{ 
	$output .= '		<tr>
							<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.getGSSituation($v['selected_gs_id'][$i]).'</td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['scale'][$i].'<br/>
								<img src="'.SITE_URL."/images/".$v['scale_image'][$i].'" width="320" height="30" border="0" />
							</td>  
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['responce'][$i].'</td>
						</tr>';	
			} 
	$output .= '	</table>	
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';	
		}
	$output .= '	<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';
	}
	
	if( ($sleep_return) && ($sleep_report == '1') )
	{
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Sleep</td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';
		 foreach($arr_sleep_records as $k => $v)
		 {
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>
							<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
						</tr>
						<tr>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Sleep Time</td>
							<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.$v['sleep_time'][0].'</td>	
						</tr>
						<tr>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Wake Up Time</td>
							<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.$v['wakeup_time'][0].'</td>	
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>
							<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		
						</tr>';	
			for($i=0;$i<count($v['selected_sleep_id']);$i++)
			{ 
	$output .= '		<tr>
							<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.getSleepSituation($v['selected_sleep_id'][$i]).'</td>	 
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['scale'][$i].'<br/>
								<img src="'.SITE_URL."/images/".$v['scale_image'][$i].'" width="320" height="30" border="0" />
							</td>  
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['responce'][$i].'</td>
						</tr>';	
			} 
	$output .= '	</table>	
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';	
		}
	$output .= '	<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';	
	
	}
	
	if( ($mc_return) && ($mc_report == '1') )
	{
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;My Communication</td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';
		 foreach($arr_mc_records as $k => $v)
		 {
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>
							<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>
							<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>
						</tr>';	
						
			for($i=0;$i<count($v['selected_mc_id']);$i++)
			{ 
	$output .= '		<tr>
							<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.getMCSituation($v['selected_mc_id'][$i]).'</td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['scale'][$i].'<br/>
								<img src="'.SITE_URL."/images/".$v['scale_image'][$i].'" width="320" height="30" border="0" />
							</td>  
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['responce'][$i].'</td>
						</tr>';	
			} 
	$output .= '	</table>	
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>	';	
		}
	$output .= '	<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>	';
	
	}
	
	if( ($mr_return) && ($mr_return == '1') )
	{
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;My Relations</td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';
		 foreach($arr_mr_records as $k => $v)
		 {
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>
							<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>
							<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>	
						</tr>';	
					
			for($i=0;$i<count($v['selected_mr_id']);$i++)
			{ 
	$output .= '		<tr>
							<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.getMRSituation($v['selected_mr_id'][$i]).'</td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['scale'][$i].'<br/>
								<img src="'.SITE_URL."/images/".$v['scale_image'][$i].'" width="320" height="30" border="0" />
							</td>  
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['responce'][$i].'</td>
						</tr>';	
			} 
	$output .= '	</table>	
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';	
		}
	$output .= '	<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';	
	
	}
	
	if( ($mle_return) && ($mle_return == '1') )
	{
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Major Life Events</td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';
		 foreach($arr_mle_records as $k => $v)
		 {
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>
							<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>
							<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>	
						</tr>';	
					
			for($i=0;$i<count($v['selected_mle_id']);$i++)
			{ 
	$output .= '		<tr>
							<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.getMLESituation($v['selected_mle_id'][$i]).'</td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['scale'][$i].'<br/>
								<img src="'.SITE_URL."/images/".$v['scale_image'][$i].'" width="320" height="30" border="0" />
							</td>  
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['responce'][$i].'</td>
						</tr>';	
			} 
	$output .= '	</table>	
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';	
		}
	$output .= '	<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';	
	
	}
	
	if( ($adct_return) && ($adct_return == '1') )
	{
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Addictions</td>
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';
		 foreach($arr_adct_records as $k => $v)
		 {
	$output .= '	<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>
							<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
						</tr>
					</table>
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
						<tr>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>
							<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>
							<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>
						</tr>';	
						
			for($i=0;$i<count($v['selected_adct_id']);$i++)
			{ 
	$output .= '		<tr>
							<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">'.getADCTSituation($v['selected_adct_id'][$i]).'</td>	
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['scale'][$i].'<br/>
								<img src="'.SITE_URL."/images/".$v['scale_image'][$i].'" width="320" height="30" border="0" />
							</td>  
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">'.$v['responce'][$i].'</td>
						</tr>';	
			} 
	$output .= '	</table>	
					<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';	
		}
	$output .= '	<table width="920" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
						</tr>
					</table>';	
	
	}
								 			
	return $output;	
}
function getMealTimeChartHTMLAdviser($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$output = '';
	list($return,$arr_date,$arr_brunch_time,$arr_lunch_time,$arr_snacks_time,$arr_dinner_time,$arr_breakfast_time,$total_meal_entry)= getMealTimeChart($user_id,$start_date,$end_date);
	if( ($return) && ( count($arr_date) > 0 ) )
	{
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Meal Time Chart</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="20%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
							<td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="19%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
							<td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
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
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
					
		$output .= '<table width="920" height="30" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
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
					
					            				
	}
	return $output;	
}
function getMyActivityCaloriesChartHTMLAdviser($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$output = '';
	list($return,$arr_date,$arr_calorie_intake,$total_calorie_intake,$arr_calorie_burned,$total_calorie_burned,$avg_workout,$arr_estimated_calorie_required,$total_estimated_calorie_required,$arr_record_row,$arr_activity_id,$total_activity_entry,$total_meal_entry) = getMyActivityCaloriesChart($user_id,$start_date,$end_date);
	if( ($return) && ( count($arr_date) > 0 ) )
	{
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">My Activity Calories Report</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="20%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
							<td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="19%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
							<td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
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
							<td height="30" align="left" valign="middle"><strong>Total Activities Entry</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.$total_activity_entry.'</td>
							<td height="30" align="left" valign="middle"><strong>Total Meals Entry</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.$total_meal_entry.'</td>
						</tr>
						<tr>	
							<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
					
		$output .= '<table width="920" height="30" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
						<tr>
							<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">SNo</td>
							<td height="50" align="left" valign="middle" bgcolor="#E1E1E1">&nbsp;</td>';
							for($i=0;$i<count($arr_activity_id);$i++)
							{ 
		$output .= '		<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getDailyActivityName($arr_activity_id[$i]).'</td>';	
							}
		$output .= '		<td height="50" align="left" valign="middle" bgcolor="#FFFFFF" style="color:#0000FF;">Total Calories Burnt</td>
							<td height="50" align="left" valign="middle" bgcolor="#FFFFFF" style="color:#0000FF;">Total Calories Intake</td>
							<td height="50" align="left" valign="middle" bgcolor="#FFFFFF" style="color:#0000FF;">Estimated Calorie Required</td>
						</tr>';
					for($i=0,$k=1;$i<count($arr_date);$i++,$k++)
					{
		$output .= '	 <tr>
							<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$k.'</td>
							<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($arr_date[$i])).'<br />('.date("l",strtotime($arr_date[$i])).')</td>';
						for($j=0;$j<count($arr_activity_id);$j++)
						{
		$output .= '		<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_record_row[$arr_activity_id[$j]][$arr_date[$i]].'</td>';
						}	
						
		$output .= '		<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_calorie_burned[$arr_date[$i]].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_calorie_intake[$arr_date[$i]].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_estimated_calorie_required[$arr_date[$i]].'</td>
						</tr>';
					}
		$output .= '	<tr>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1">&nbsp;</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1">Total</td>';
						for($i=0;$i<count($arr_activity_id);$i++)
						{
		$output .= '		<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_record_row[$arr_activity_id[$i]]['total_cal_val'].'</td>';
						}	
						
		$output .= '		<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$total_calorie_burned.'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$total_calorie_intake.'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$total_estimated_calorie_required.'</td>
						</tr>                                    	
					</table>';
					
		
	}
	return $output;	
}
function getStatementwiseEmotionsReportHTMLAdviser($user_id,$start_date,$end_date,$wae_report,$gs_report,$sleep_report,$mc_report,$mr_report,$mle_report,$adct_report,$permission_type,$pro_user_id)
{
	global $link;
	$return = false;
	$output = '';
	list($wae_return,$arr_wae_records,$gs_return,$arr_gs_records,$sleep_return,$arr_sleep_records,$mc_return,$arr_mc_records,$mr_return,$arr_mr_records,$mle_return,$arr_mle_records,$adct_return,$arr_adct_records) = getStatementwiseEmotionsReport($user_id,$start_date,$end_date,$permission_type,$pro_user_id);
		
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
				<tbody>	
					<tr>	
						<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Emotions Report - Statement</td>
					</tr>
					<tr>	
						<td height="30" align="left" valign="middle">&nbsp;</td>
					</tr>
				</tbody>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
						<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
						<td width="20%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
						<td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
						<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
						<td width="19%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
						<td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						<td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						<td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
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
				<table width="920" border="0" cellpadding="0" cellspacing="0">
				<tbody>	
					<tr>	
						<td align="left"><strong>Important:</strong></td>
					</tr>
					<tr>	
						<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
					</tr>
				</tbody>
				</table>';
				
	if( ($wae_return) && ($wae_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Work & Environment</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_wae_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getWAESituation($k).'</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['date']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';	
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($gs_return) && ($gs_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">General Stressors</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_gs_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getGSSituation($k).'</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['date']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';	
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($sleep_return) && ($sleep_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Sleep</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_sleep_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getSleepSituation($k).'</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="100" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Sleep Time</td>
						<td width="100" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Wake-up Time</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['date']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')</td>	
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$v['sleep_time'][$i].'</td>	
                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$v['wakeup_time'][$i].'</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';	
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($mc_return) && ($mc_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">My Communication</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_mc_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getMCSituation($k).'</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['date']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';	
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($mr_return) && ($mr_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">My Relations</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_mr_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getMRSituation($k).'</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['date']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';		
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($mle_return) && ($mle_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Major Life Events</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_mle_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>

						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getMLESituation($k).'</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';		
						
			for($i=0;$i<count($v['date']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';		
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($adct_return) && ($adct_report == '1') )
	{
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Addictions</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_adct_records as $k => $v)
		 {
	$output .= '<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getADCTSituation($k).'</td>	
					</tr>
				</table>
				<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="920" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
					</tr>';	
						
			for($i=0;$i<count($v['date']);$i++)
			{ 
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')</td>	
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>  
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
					</tr>';	
			} 
	$output .= '</table>';
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';	
		}
	$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}							
					
			
	return $output;	
}
function getStressBusterIntensityReportHTMLAdviser($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$output = '';
	list($usbb_return,$arr_usbb_date,$arr_intensity_scale_1,$arr_intensity_scale_1_image,$arr_intensity_scale_2,$arr_intensity_scale_2_image)= getStressBusterIntensityReport($user_id,$start_date,$end_date);
	if( ($usbb_return) && ( count($arr_usbb_date) > 0 ) )
	{
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Stressbuster Intensity Report</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="20%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
							<td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="19%" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
							<td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
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
					<table width="920" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
					
		$output .= '<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
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
					
						            				
	}
	return $output;	
}

function getMyFavList($user_id)
{
	global $link;
	//echo $_SESSION['user_id'];
	$arr_ufs_id = array(); 
	$arr_page_id = array(); 
	$arr_sc_id = array(); 
	$arr_ufs_note = array();
	$arr_ufs_cat_id = array();
	$arr_ufs_priority = array();    
	$arr_ufs_add_date = array();    
	
	$sql = "SELECT * FROM `tblusersfavscrolling` AS TA
			LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
			WHERE `user_id` = '".$user_id."' AND TA.ufs_status = '1' ORDER BY TS.menu_title ASC,TA.ufs_add_date DESC";
	
	
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
		  	array_push($arr_ufs_id , $row['ufs_id']);
			array_push($arr_page_id , stripslashes($row['page_id']));
			array_push($arr_sc_id , stripslashes($row['sc_id']));
			array_push($arr_ufs_note , stripslashes($row['ufs_note']));
			array_push($arr_ufs_cat_id , stripslashes($row['ufs_cat_id']));
			array_push($arr_ufs_priority , stripslashes($row['ufs_priority']));
			array_push($arr_ufs_add_date , stripslashes($row['ufs_add_date']));
		}
	}
	return array($arr_ufs_id,$arr_page_id,$arr_sc_id,$arr_ufs_note,$arr_ufs_cat_id,$arr_ufs_priority,$arr_ufs_add_date);

}
function Delete_MyFavItem($ufs_id)
{
	global $link;
	$return = false;		
	
	$sql = "DELETE FROM `tblusersfavscrolling` WHERE `ufs_id` = '".$ufs_id."' ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
	}
	return $return;
}

function addSoundFile($music,$day,$credit,$credit_url,$practitioner_id,$country_id,$state_id,$city_id,$place_id,$user_id,$keywords)
{
	global $link;
	$return = false;
	$sql = "INSERT INTO `tblmusic`(`music`,`day`,`credit`,`credit_url`,`status`,`practitioner_id`,`country_id`,`state_id`,`city_id`,`place_id`,`user_id`,`keywords`) VALUES ('".addslashes($music)."','".addslashes($day)."','".addslashes($credit)."','".addslashes($credit_url)."','1','".addslashes($practitioner_id)."','".$country_id."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($user_id)."','".addslashes($keywords)."')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
	}
	
	return $return;
}

function getAllSoundFilessList($practitioner_id)
{
	global $link;
	$sql = "SELECT * FROM `tblmusic` WHERE `practitioner_id` = '".$practitioner_id."' ORDER BY music_add_date DESC";
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
			
			//if($row['listing_date_type'] == 'days_of_month')
			//{
				$date_type = 'Days of Month';
				$date_value = stripslashes($row['day']);
			//}
			//elseif($row['listing_date_type'] == 'single_date')
			//{
			//	$date_type = 'Single Date';
			//	$date_value = date('d-m-Y',strtotime($row['single_date']));
			//}
			//elseif($row['listing_date_type'] == 'date_range')
			//{
			//	$date_type = 'Date Range';
			//	$date_value = date('d-m-Y',strtotime($row['start_date'])).' - '.date('d-m-Y',strtotime($row['end_date']));
			//}
			
			$output .= '<tr class="manage-row">';
			$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
			$output .= '<td height="30" align="center"><strong>'.stripslashes($row['music']).'</strong></td>';
			$output .= '<td height="30" align="center">'.$date_value.'</td>';
			$output .= '<td height="30" align="center">'.$status.'</td>';
			$output .= '<td align="center" nowrap="nowrap">';
					
			$output .= '<a href="edit_sound_file.php?id='.$row['music_id'].'" ><img src = "images/edit.png" width="10" border="0"></a>';
						
			$output .= '</td>';
			$output .= '</tr>';
			$i++;
		}
	}
	else
	{
		$output = '<tr class="manage-row" height="20"><td colspan="7" align="center">NO RECORDS FOUND</td></tr>';
	}
	return $output;
}
function getTheamDetailsFront($theam_id,$practitioner_id)
{
	global $link;
	$theam_name = '';
	$color_code = '';
	$image = '';
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
			
	$sql = "SELECT * FROM `tbltheams` WHERE `theam_id` = '".$theam_id."' AND `practitioner_id` = '".$practitioner_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$theam_name = stripslashes($row['theam_name']);
		$color_code = stripslashes($row['color_code']);
		$image = stripslashes($row['image']);
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
	return array($theam_name,$color_code,$image,$credit,$credit_url,$status,$day,$country_id,$state_id,$city_id,$place_id,$user_id,$keywords);
}
?>