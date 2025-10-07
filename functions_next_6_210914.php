<?php
function getDigitalPersonalWellnessDiary($user_id,$start_date,$end_date,$permission_type = '0',$pro_user_id = '0')
{
	global $link;
	
	$food_return = false;
	$arr_meal_date = array(); 
	$arr_food_records = array(); 
	
	$activity_return = false;
	$arr_activity_date = array(); 
	$arr_activity_records = array(); 
	
	$wae_return = false;
	$arr_wae_date = array();
	$arr_wae_records = array();
	
	$gs_return = false;
	$arr_gs_date = array();
	$arr_gs_records = array();
	
	$sleep_return = false;
	$arr_sleep_date = array();
	$arr_sleep_records = array();
	
	$mc_return = false;
	$arr_mc_date = array();
	$arr_mc_records = array();
	
	$mr_return = false;
	$arr_mr_date = array();
	$arr_mr_records = array();
	
	$mle_return = false;
	$arr_mle_date = array();
	$arr_mle_records = array();
	
	$adct_return = false;
	$arr_adct_date = array();
	$arr_adct_records = array();
			
	$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' ORDER BY `meal_date` ASC ";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_meal_date , $row['meal_date']);
		}
	}		
	
	if(count($arr_meal_date) > 0)
	{		
		for($i=0;$i<count($arr_meal_date);$i++)
		{	
			$sql2 = "SELECT * FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` = '".$arr_meal_date[$i]."' ORDER BY `user_meal_id` ASC ";
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					$food_return = true;
					$arr_food_records[$arr_meal_date[$i]]['meal_time'][$j] = $row2['meal_time'];
					$arr_food_records[$arr_meal_date[$i]]['meal_id'][$j] = $row2['meal_id'];
					$arr_food_records[$arr_meal_date[$i]]['meal_others'][$j] = $row2['meal_others'];
					$arr_food_records[$arr_meal_date[$i]]['meal_quantity'][$j] = $row2['meal_quantity'];
					$arr_food_records[$arr_meal_date[$i]]['meal_measure'][$j] = $row2['meal_measure'];
					$arr_food_records[$arr_meal_date[$i]]['meal_type'][$j] = $row2['meal_type'];
					$arr_food_records[$arr_meal_date[$i]]['meal_like'][$j] = $row2['meal_like'];
					$arr_food_records[$arr_meal_date[$i]]['meal_consultant_remark'][$j] = stripslashes($row2['meal_consultant_remark']);
					$j++;
				}
			}
		}
	}
	
	$sql = "SELECT DISTINCT `activity_date` FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` >= '".$start_date."' AND `activity_date` <= '".$end_date."' ORDER BY `activity_date` ASC ";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_activity_date , $row['activity_date']);
		}
	}		
	
	if(count($arr_activity_date) > 0)
	{		
		for($i=0;$i<count($arr_activity_date);$i++)
		{	
			$sql2 = "SELECT * FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` = '".$arr_activity_date[$i]."' ORDER BY `user_activity_id` ASC ";
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					$activity_return = true;
					$arr_activity_records[$arr_activity_date[$i]]['activity_time'][$j] = $row2['activity_time'];
					$arr_activity_records[$arr_activity_date[$i]]['activity_id'][$j] = $row2['activity_id'];
					$arr_activity_records[$arr_activity_date[$i]]['other_activity'][$j] = $row2['other_activity'];
					$arr_activity_records[$arr_activity_date[$i]]['mins'][$j] = $row2['mins'];
					$arr_activity_records[$arr_activity_date[$i]]['yesterday_sleep_time'][$j] = $row2['yesterday_sleep_time'];
					$arr_activity_records[$arr_activity_date[$i]]['today_wakeup_time'][$j] = $row2['today_wakeup_time'];
					$arr_activity_records[$arr_activity_date[$i]]['proper_guidance'][$j] = ($row2['proper_guidance'] == 1) ? 'Yes' : 'No';
					$arr_activity_records[$arr_activity_date[$i]]['precaution'][$j] = stripslashes($row2['precaution']);
					$j++;
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tuwae.wae_date FROM `tbluserswae` AS tuwae LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id WHERE tuwae.user_id = '".$user_id."' AND tuwae.wae_date >= '".$start_date."' AND tuwae.wae_date <= '".$end_date."' AND twae.practitioner_id = '".$pro_user_id."' ORDER BY tuwae.wae_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `wae_date` FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_date` >= '".$start_date."' AND `wae_date` <= '".$end_date."' ORDER BY `wae_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_wae_date , $row['wae_date']);
		}
	}		
	
	if(count($arr_wae_date) > 0)
	{		
		for($i=0;$i<count($arr_wae_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tuwae.* FROM `tbluserswae` AS tuwae LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id WHERE tuwae.user_id = '".$user_id."' AND tuwae.wae_date = '".$arr_wae_date[$i]."' AND twae.practitioner_id = '".$pro_user_id."' ORDER BY tuwae.user_wae_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_date` = '".$arr_wae_date[$i]."' ORDER BY `user_wae_id` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_wae_id'] != '0')
					{
						$wae_return = true;
						$arr_wae_records[$arr_wae_date[$i]]['selected_wae_id'][$j] = $row2['selected_wae_id'];
						$arr_wae_records[$arr_wae_date[$i]]['scale'][$j] = $row2['scale'];
						$arr_wae_records[$arr_wae_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_wae_records[$arr_wae_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);

						$j++;
					}	
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tugs.gs_date FROM `tblusersgs` AS tugs LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id WHERE tugs.user_id = '".$user_id."' AND tugs.gs_date >= '".$start_date."' AND tugs.gs_date <= '".$end_date."' AND tgs.practitioner_id = '".$pro_user_id."' ORDER BY tugs.gs_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `gs_date` FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_date` >= '".$start_date."' AND `gs_date` <= '".$end_date."' ORDER BY `gs_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_gs_date , $row['gs_date']);
		}
	}		
	
	if(count($arr_gs_date) > 0)
	{		
		for($i=0;$i<count($arr_gs_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tugs.* FROM `tblusersgs` AS tugs LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id WHERE tugs.user_id = '".$user_id."' AND tugs.gs_date = '".$arr_gs_date[$i]."' AND tgs.practitioner_id = '".$pro_user_id."' ORDER BY tugs.user_gs_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_date` = '".$arr_gs_date[$i]."' ORDER BY `user_gs_id` ASC ";
			}   
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_gs_id'] != '0')
					{
						$gs_return = true;
						$arr_gs_records[$arr_gs_date[$i]]['selected_gs_id'][$j] = $row2['selected_gs_id'];
						$arr_gs_records[$arr_gs_date[$i]]['scale'][$j] = $row2['scale'];
						$arr_gs_records[$arr_gs_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_gs_records[$arr_gs_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tusl.sleep_date FROM `tbluserssleep` AS tusl LEFT JOIN `tblsleeps` AS tsl ON tusl.selected_sleep_id = tsl.sleep_id WHERE tusl.user_id = '".$user_id."' AND tusl.sleep_date >= '".$start_date."' AND tusl.sleep_date <= '".$end_date."' AND tsl.practitioner_id = '".$pro_user_id."' ORDER BY tusl.sleep_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `sleep_date` FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_date` >= '".$start_date."' AND `sleep_date` <= '".$end_date."' ORDER BY `sleep_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_sleep_date , $row['sleep_date']);
		}
	}		
	
	if(count($arr_sleep_date) > 0)
	{		
		for($i=0;$i<count($arr_sleep_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tusl.* FROM `tbluserssleep` AS tusl LEFT JOIN `tblsleeps` AS tsl ON tusl.selected_sleep_id = tsl.sleep_id WHERE tusl.user_id = '".$user_id."' AND tusl.sleep_date = '".$arr_sleep_date[$i]."' AND tsl.practitioner_id = '".$pro_user_id."' ORDER BY tusl.user_sleep_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_date` = '".$arr_sleep_date[$i]."' ORDER BY `user_sleep_id` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_sleep_id'] != '0')
					{
						$sleep_return = true;
						$arr_sleep_records[$arr_sleep_date[$i]]['sleep_time'][$j] = getUserSleepTime($user_id,$row2['sleep_date']);
						$arr_sleep_records[$arr_sleep_date[$i]]['wakeup_time'][$j] = getUserWakeUpTime($user_id,$row2['sleep_date']);
						$arr_sleep_records[$arr_sleep_date[$i]]['selected_sleep_id'][$j] = $row2['selected_sleep_id'];
						$arr_sleep_records[$arr_sleep_date[$i]]['scale'][$j] = $row2['scale'];
						$arr_sleep_records[$arr_sleep_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_sleep_records[$arr_sleep_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tumc.mc_date FROM `tblusersmc` AS tumc LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id WHERE tumc.user_id = '".$user_id."' AND tumc.mc_date >= '".$start_date."' AND tumc.mc_date <= '".$end_date."' AND tmc.practitioner_id = '".$pro_user_id."' ORDER BY tumc.mc_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `mc_date` FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_date` >= '".$start_date."' AND `mc_date` <= '".$end_date."' ORDER BY `mc_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_mc_date , $row['mc_date']);
		}
	}		
	
	if(count($arr_mc_date) > 0)
	{		
		for($i=0;$i<count($arr_mc_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tumc.* FROM `tblusersmc` AS tumc LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id WHERE tumc.user_id = '".$user_id."' AND tumc.mc_date = '".$arr_mc_date[$i]."' AND tmc.practitioner_id = '".$pro_user_id."' ORDER BY tumc.user_mc_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_date` = '".$arr_mc_date[$i]."' ORDER BY `user_mc_id` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_mc_id'] != '0')
					{
						$mc_return = true;
						$arr_mc_records[$arr_mc_date[$i]]['selected_mc_id'][$j] = $row2['selected_mc_id'];
						$arr_mc_records[$arr_mc_date[$i]]['scale'][$j] = $row2['scale'];
						$arr_mc_records[$arr_mc_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_mc_records[$arr_mc_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tumr.mr_date FROM `tblusersmr` AS tumr LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id WHERE tumr.user_id = '".$user_id."' AND tumr.mr_date >= '".$start_date."' AND tumr.mr_date <= '".$end_date."' AND tmr.practitioner_id = '".$pro_user_id."' ORDER BY tumr.mr_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `mr_date` FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_date` >= '".$start_date."' AND `mr_date` <= '".$end_date."' ORDER BY `mr_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_mr_date , $row['mr_date']);
		}
	}		
	
	if(count($arr_mr_date) > 0)
	{		
		for($i=0;$i<count($arr_mr_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tumr.* FROM `tblusersmr` AS tumr LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id WHERE tumr.user_id = '".$user_id."' AND tumr.mr_date = '".$arr_mr_date[$i]."' AND tmr.practitioner_id = '".$pro_user_id."' ORDER BY tumr.user_mr_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_date` = '".$arr_mr_date[$i]."' ORDER BY `user_mr_id` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_mr_id'] != '0')
					{
						$mr_return = true;
						$arr_mr_records[$arr_mr_date[$i]]['selected_mr_id'][$j] = $row2['selected_mr_id'];
						$arr_mr_records[$arr_mr_date[$i]]['scale'][$j] = $row2['scale'];
						$arr_mr_records[$arr_mr_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_mr_records[$arr_mr_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tumle.mle_date FROM `tblusersmle` AS tumle LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id WHERE tumle.user_id = '".$user_id."' AND tumle.mle_date >= '".$start_date."' AND tumle.mle_date <= '".$end_date."' AND tmle.practitioner_id = '".$pro_user_id."' ORDER BY tumle.mle_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `mle_date` FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_date` >= '".$start_date."' AND `mle_date` <= '".$end_date."' ORDER BY `mle_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_mle_date , $row['mle_date']);
		}
	}		
	
	if(count($arr_mle_date) > 0)
	{		
		for($i=0;$i<count($arr_mle_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tumle.* FROM `tblusersmle` AS tumle LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id WHERE tumle.user_id = '".$user_id."' AND tumle.mle_date = '".$arr_mle_date[$i]."' AND tmle.practitioner_id = '".$pro_user_id."' ORDER BY tumle.user_mle_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_date` = '".$arr_mle_date[$i]."' ORDER BY `user_mle_id` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_mle_id'] != '0')
					{
						$mle_return = true;
						$arr_mle_records[$arr_mle_date[$i]]['selected_mle_id'][$j] = $row2['selected_mle_id'];
						$arr_mle_records[$arr_mle_date[$i]]['scale'][$j] = $row2['scale'];
						$arr_mle_records[$arr_mle_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_mle_records[$arr_mle_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tuadc.adct_date FROM `tblusersadct` AS tuadc LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id WHERE tuadc.user_id = '".$user_id."' AND tuadc.adct_date >= '".$start_date."' AND tuadc.adct_date <= '".$end_date."' AND tadc.practitioner_id = '".$pro_user_id."' ORDER BY tuadc.adct_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `adct_date` FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_date` >= '".$start_date."' AND `adct_date` <= '".$end_date."' ORDER BY `adct_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_adct_date , $row['adct_date']);
		}
	}		
	
	if(count($arr_adct_date) > 0)
	{		
		for($i=0;$i<count($arr_adct_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tuadc.* FROM `tblusersadct` AS tuadc LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id WHERE tuadc.user_id = '".$user_id."' AND tuadc.adct_date = '".$arr_adct_date[$i]."' AND tadc.practitioner_id = '".$pro_user_id."' ORDER BY tuadc.user_adct_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_date` = '".$arr_adct_date[$i]."' ORDER BY `user_adct_id` ASC ";
			}       
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_adct_id'] != '0')
					{
						$adct_return = true;
						$arr_adct_records[$arr_adct_date[$i]]['selected_adct_id'][$j] = $row2['selected_adct_id'];
						$arr_adct_records[$arr_adct_date[$i]]['scale'][$j] = $row2['scale'];
						$arr_adct_records[$arr_adct_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_adct_records[$arr_adct_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	
				}
			}
		}
	}
	
	return array($food_return,$arr_meal_date,$arr_food_records,$activity_return,$arr_activity_date,$arr_activity_records,$wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records);

}

function convert_to_excel($filename,$output)
{
	ob_clean();
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	echo $output;
}

function getDigitalPersonalWellnessDiaryHTML($user_id,$start_date,$end_date,$food_report,$activity_report,$wae_report,$gs_report,$sleep_report,$mc_report,$mr_report,$mle_report,$adct_report,$report_title,$permission_type,$pro_user_id)
{
	global $link;
	$return = false;
	$output = '';
	list($food_return,$arr_meal_date,$arr_food_records,$activity_return,$arr_activity_date,$arr_activity_records,$wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records) = getDigitalPersonalWellnessDiary($user_id,$start_date,$end_date,$permission_type,$pro_user_id);
		
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="0">
				<tbody>
					<tr>	
						<td colspan="9" height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">'.$report_title.'</td>
					</tr>
					<tr>	
						<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
					</tr>
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
					<tr>	
						<td colspan="9" align="left"><strong>Important:</strong></td>
					</tr>
					<tr>	
						<td colspan="9" align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
					</tr>
					<tr>	
						<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
					</tr>';
				
	if( ($food_return) && ($food_report == '1') )
   	{ 
	$output .= '    <tr>
                        <td colspan="5" height="30" align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">&nbsp;Food</td>
                    </tr>';
		foreach($arr_food_records as $k => $v)
		{ 
	$output .= '	<tr>	
                        <td colspan="9" height="30" align="left" valign="middle">
							<table width="1150" border="1" cellpadding="5" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
									<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
									<td colspan="4" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
								</tr>
								<tr>
									<td width="200" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Time</td>
									<td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Item</td>
									<td width="200" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Quantity</td>	
									<td width="200" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">My Desire</td>
									<td width="250" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Item Remarks</td>	
								</tr>';	
									for($i=0;$i<count($v['meal_id']);$i++)
									{ 
	$output .= '				<tr>
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
										
	$output .= '					</td>	
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['meal_quantity'][$i].' ('.$v['meal_measure'][$i].' )</td>	
									
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['meal_like'][$i].'<br />'.getMealLikeIcon($v['meal_like'][$i]).'</td>	
									
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['meal_consultant_remark'][$i].'</td>	
								</tr>';	
									} 
	$output .= '			</table>	
						</td>	
                    </tr>
					<tr>	
                        <td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
                    </tr>';
		}
	}
	
	if( ($activity_return)  && ($activity_report == '1') )
   	{ 
	$output .= '    <tr>
                        <td colspan="5" height="30" align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">&nbsp;Activity</td>
                    </tr>';
		foreach($arr_activity_records as $k => $v)
		{ 
	$output .= '	<tr>	
                        <td colspan="9" height="30" align="left" valign="middle">
							<table width="1150" border="1" cellpadding="5" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
									<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
									<td colspan="4" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
								</tr>
								<tr>
									<td width="200" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Time</td>
									<td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Activity</td>
									<td width="200" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Duration</td>	
									<td width="200" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Proper guidance</td>
									<td width="250" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Precaution</td>	
								</tr>
								<tr>
									<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$v['today_wakeup_time'][0].'</td>
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">Wake Up </td>	
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"></td>
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"></td>
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"></td>	
								</tr>	';	
									for($i=0;$i<count($v['activity_id']);$i++)
									{ 
	$output .= '				<tr>
									<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$v['activity_time'][$i].'</td>
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">';
										
										if($v['activity_id'][$i] == '9999999999')
										{
	$output .= '						'.$v['other_activity'][$i];
										}
										else
										{
	$output .= '						'.getDailyActivityName($v['activity_id'][$i]);
										}
										
	$output .= '					</td>	
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['mins'][$i].' Mins</td>	
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['proper_guidance'][$i].'</td>	
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['precaution'][$i].'</td>	
								</tr>';	
									} 
	$output .= '			</table>	
						</td>	
                    </tr>
					<tr>	
                        <td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
                    </tr>';
		}
	}
	
	if( ($wae_return) && ($wae_report == '1') )
	{
	$output .= '	<tr>
                        <td colspan="9" height="30" align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">&nbsp;Work & Environment</td>
                    </tr>';
		 foreach($arr_wae_records as $k => $v)
		 {
	$output .= '
					<tr>	
                        <td colspan="9" width="1150" align="left" valign="middle">
							<table width="1150" border="1" cellpadding="2" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
									<td width="420" colspan="9" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
											
								</tr>
								<tr>
									<td height="30" width="100" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
									<td height="30" width="200" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
									<td  height="30" width="400" colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
									<td height="30" colspan="2" width="250" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
								</tr>
								<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
									<td height="30"  colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Slider</td>
									<td height="30"   colspan="2" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
								</tr>';	
						
			for($i=0;$i<count($v['selected_wae_id']);$i++)
			{ 
	$output .= '				<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getWAESituation($v['selected_wae_id'][$i]).'</td>	
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td>
									 
									<td height="50" colspan="5" align="center" valign="middle" bgcolor="#FFFFFF"><img src="'.SITE_URL.'/images/'.$v['scale_image'][$i].'" width="320" height="30" border="0" /></td>   
									<td height="30" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
								</tr>';	
			} 
	$output .= '			</table>	
						</td>	
                    </tr>
					<tr>	
                        <td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
                    </tr>';	
		}
	
	}
	
	if( ($gs_return) && ($gs_report == '1') )
	{
	$output .= '	<tr>
                        <td colspan="9" height="30" align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">&nbsp;General Stressors</td>
                    </tr>';
		 foreach($arr_gs_records as $k => $v)
		 {
	$output .= '
					<tr>	
                        <td colspan="9" width="1150" align="left" valign="middle">
							<table width="1150" border="1" cellpadding="2" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
									<td width="420" colspan="9" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
											
								</tr>
								<tr>
									<td height="30" width="100" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
									<td height="30" width="200" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
									<td  height="30" width="400" colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
									<td height="30" colspan="2" width="250" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
								</tr>
								<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
									<td height="30"  colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Slider</td>
									
									<td height="30"   colspan="2" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
								</tr>';	
						
			for($i=0;$i<count($v['selected_gs_id']);$i++)
			{ 
	$output .= '				<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getGSSituation($v['selected_gs_id'][$i]).'</td>	
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td> 
									
									<td height="50" colspan="5" align="center" valign="middle" bgcolor="#FFFFFF"><img src="'.SITE_URL.'/images/'.$v['scale_image'][$i].'" width="320" height="30" border="0" /></td>  
									<td height="30" colspan="2"  align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
								</tr>';	
			} 
	$output .= '			</table>	
						</td>	
                    </tr>
					<tr>	
                        <td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
                    </tr>';	
		}
	
	}
	
	if( ($sleep_return) && ($sleep_return == '1') )
	{
	$output .= '	<tr>
                        <td colspan="9" height="30" align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">&nbsp;Sleep</td>
                    </tr>';
		 foreach($arr_sleep_records as $k => $v)
		 {
	$output .= '
					<tr>	
                        <td colspan="9" width="1150" align="left" valign="middle">
							<table width="1150" border="1" cellpadding="2" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
									<td width="420" colspan="9" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
											
								</tr>
								<tr>
									<td height="30" width="100" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
									<td height="30" width="200" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
									<td  height="30" width="400" colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
									<td height="30" colspan="2" width="250" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
								</tr>
								<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
									<td height="30"  colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Slider</td>
									
									<td height="30"   colspan="2" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
								</tr>';	
						
			for($i=0;$i<count($v['selected_sleep_id']);$i++)
			{ 
	$output .= '				<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getSleepSituation($v['selected_sleep_id'][$i]).'</td>	
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td> 
									
									<td height="50" colspan="5" align="center" valign="middle" bgcolor="#FFFFFF"><img src="'.SITE_URL.'/images/'.$v['scale_image'][$i].'" width="320" height="30" border="0" /></td>  
									<td height="30" colspan="2"  align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
								</tr>';	
			} 
	$output .= '			</table>	
						</td>	
                    </tr>
					<tr>	
                        <td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
                    </tr>';	
		}
	
	
	}
	
	if( ($mc_return) && ($mc_return == '1') )
	{
	$output .= '	<tr>
                        <td colspan="9" height="30" align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">&nbsp;Sleep</td>
                    </tr>';
		 foreach($arr_mc_records as $k => $v)
		 {
	$output .= '
					<tr>	
                        <td colspan="9" width="1150" align="left" valign="middle">
							<table width="1150" border="1" cellpadding="2" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
									<td width="420" colspan="9" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
											
								</tr>
								<tr>
									<td height="30" width="100" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
									<td height="30" width="200" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
									<td  height="30" width="400" colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
									<td height="30" colspan="2" width="250" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
								</tr>
								<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
									<td height="30"  colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Slider</td>
									
									<td height="30"   colspan="2" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
								</tr>';	
						
			for($i=0;$i<count($v['selected_mc_id']);$i++)
			{ 
	$output .= '				<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getMCSituation($v['selected_mc_id'][$i]).'</td>	
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td> 
									
									<td height="50" colspan="5" align="center" valign="middle" bgcolor="#FFFFFF"><img src="'.SITE_URL.'/images/'.$v['scale_image'][$i].'" width="320" height="30" border="0" /></td>  
									<td height="30" colspan="2"  align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
								</tr>';	
			} 
	$output .= '			</table>	
						</td>	
                    </tr>
					<tr>	
                        <td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
                    </tr>';	
		}
	
	
	}
	
	if( ($mr_return) && ($mr_return == '1') )
	{
	$output .= '	<tr>
                        <td colspan="9" height="30" align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">&nbsp;Sleep</td>
                    </tr>';
		 foreach($arr_mr_records as $k => $v)
		 {
	$output .= '
					<tr>	
                        <td colspan="9" width="1150" align="left" valign="middle">
							<table width="1150" border="1" cellpadding="2" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
									<td width="420" colspan="9" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
											
								</tr>
								<tr>
									<td height="30" width="100" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
									<td height="30" width="200" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
									<td  height="30" width="400" colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
									<td height="30" colspan="2" width="250" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
								</tr>
								<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
									<td height="30"  colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Slider</td>
									
									<td height="30"   colspan="2" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
								</tr>';	
						
			for($i=0;$i<count($v['selected_mr_id']);$i++)
			{ 
	$output .= '				<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getMRSituation($v['selected_mr_id'][$i]).'</td>	
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td> 
									
									<td height="50" colspan="5" align="center" valign="middle" bgcolor="#FFFFFF"><img src="'.SITE_URL.'/images/'.$v['scale_image'][$i].'" width="320" height="30" border="0" /></td>  
									<td height="30" colspan="2"  align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
								</tr>';	
			} 
	$output .= '			</table>	
						</td>	
                    </tr>
					<tr>	
                        <td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
                    </tr>';	
		}
	
	
	}
	
	if( ($mle_return) && ($mle_return == '1') )
	{
	$output .= '	<tr>
                        <td colspan="9" height="30" align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">&nbsp;Sleep</td>
                    </tr>';
		 foreach($arr_mle_records as $k => $v)
		 {
	$output .= '
					<tr>	
                        <td colspan="9" width="1150" align="left" valign="middle">
							<table width="1150" border="1" cellpadding="2" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
									<td width="420" colspan="9" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
											
								</tr>
								<tr>
									<td height="30" width="100" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
									<td height="30" width="200" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
									<td  height="30" width="400" colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
									<td height="30" colspan="2" width="250" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
								</tr>
								<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
									<td height="30"  colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Slider</td>
									
									<td height="30"   colspan="2" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
								</tr>';	
						
			for($i=0;$i<count($v['selected_mle_id']);$i++)
			{ 
	$output .= '				<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getMLESituation($v['selected_mle_id'][$i]).'</td>	
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td> 
									
									<td height="50" colspan="5" align="center" valign="middle" bgcolor="#FFFFFF"><img src="'.SITE_URL.'/images/'.$v['scale_image'][$i].'" width="320" height="30" border="0" /></td>  
									<td height="30" colspan="2"  align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
								</tr>';	
			} 
	$output .= '			</table>	
						</td>	
                    </tr>
					<tr>	
                        <td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
                    </tr>';	
		}
	
	
	}
	
	if( ($adct_return) && ($adct_return == '1') )
	{
	$output .= '	<tr>
                        <td colspan="9" height="30" align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">&nbsp;Sleep</td>
                    </tr>';
		 foreach($arr_adct_records as $k => $v)
		 {
	$output .= '
					<tr>	
                        <td colspan="9" width="1150" align="left" valign="middle">
							<table width="1150" border="1" cellpadding="2" cellspacing="0" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
								<tr>
									<td width="420" colspan="9" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
											
								</tr>
								<tr>
									<td height="30" width="100" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
									<td height="30" width="200" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
									<td  height="30" width="400" colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
									<td height="30" colspan="2" width="250" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"></td>
								</tr>
								<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
									<td height="30"  colspan="5" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Slider</td>
									
									<td height="30"   colspan="2" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
								</tr>';	
						
			for($i=0;$i<count($v['selected_adct_id']);$i++)
			{ 
	$output .= '				<tr>
									<td height="30"  align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getADCTSituation($v['selected_adct_id'][$i]).'</td>	
									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$v['scale'][$i].'</td> 
									
									<td height="50" colspan="5" align="center" valign="middle" bgcolor="#FFFFFF"><img src="'.SITE_URL.'/images/'.$v['scale_image'][$i].'" width="320" height="30" border="0" /></td>  
									<td height="30" colspan="2"  align="center" valign="middle" bgcolor="#FFFFFF">'.$v['responce'][$i].'</td>
								</tr>';	
			} 
	$output .= '			</table>	
						</td>	
                    </tr>
					<tr>	
                        <td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
                    </tr>';	
		}
	
	
	}
	
	$output .= '	<tr>	
						<td colspan="9" align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Users Note:</strong></td>
					</tr>
					<tr>	
						<td colspan="9" align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Things i would like to change:</strong></td>
					</tr>
					<tr>	
						<td colspan="9" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
					</tr>
					<tr>	
						<td colspan="9" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
					</tr>

					<tr>	
						<td colspan="9" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
					</tr>
					<tr>	
						<td colspan="9" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
					</tr>
					<tr>	
						<td colspan="9" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
					</tr>
					<tr>	
						<td colspan="9" align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Benefits  I noticed from the changes:</strong></td>
					</tr>
					<tr>	
						<td colspan="9" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
					</tr>
					<tr>	
						<td colspan="9" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
					</tr>

					<tr>	
						<td colspan="9" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
					</tr>
					<tr>	
						<td colspan="9" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
					</tr>
					<tr>	
						<td colspan="9" align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
					</tr>
				</tbody>
				</table>';											 			
	return $output;	
}

function getDatewiseEmotionsReport($user_id,$start_date,$end_date,$permission_type = '0',$pro_user_id = '0')
{
	global $link;
	
	$wae_return = false;
	$arr_wae_date = array();
	$arr_wae_records = array();
	
	$gs_return = false;
	$arr_gs_date = array();
	$arr_gs_records = array();
	
	$sleep_return = false;
	$arr_sleep_date = array();
	$arr_sleep_records = array();
	
	$mc_return = false;
	$arr_mc_date = array();
	$arr_mc_records = array();
	
	$mr_return = false;
	$arr_mr_date = array();
	$arr_mr_records = array();
	
	$mle_return = false;
	$arr_mle_date = array();
	$arr_mle_records = array();
	
	$adct_return = false;
	$arr_adct_date = array();
	$arr_adct_records = array();
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tuwae.wae_date FROM `tbluserswae` AS tuwae LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id WHERE tuwae.user_id = '".$user_id."' AND tuwae.wae_date >= '".$start_date."' AND tuwae.wae_date <= '".$end_date."' AND twae.practitioner_id = '".$pro_user_id."' ORDER BY tuwae.wae_date ASC ";
	}
	else

	{
		$sql = "SELECT DISTINCT `wae_date` FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_date` >= '".$start_date."' AND `wae_date` <= '".$end_date."' ORDER BY `wae_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_wae_date , $row['wae_date']);
		}
	}		
	
	if(count($arr_wae_date) > 0)
	{		
		for($i=0;$i<count($arr_wae_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tuwae.* FROM `tbluserswae` AS tuwae LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id WHERE tuwae.user_id = '".$user_id."' AND tuwae.wae_date = '".$arr_wae_date[$i]."' AND twae.practitioner_id = '".$pro_user_id."' ORDER BY tuwae.user_wae_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_date` = '".$arr_wae_date[$i]."' ORDER BY `user_wae_id` ASC ";
			}
			
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_wae_id'] != '0')
					{
						$wae_return = true;
						$arr_wae_records[$arr_wae_date[$i]]['selected_wae_id'][$j] = $row2['selected_wae_id'];
						$arr_wae_records[$arr_wae_date[$i]]['scale'][$j] = getScaleValue($row2['scale']);
						$arr_wae_records[$arr_wae_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_wae_records[$arr_wae_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tugs.gs_date FROM `tblusersgs` AS tugs LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id WHERE tugs.user_id = '".$user_id."' AND tugs.gs_date >= '".$start_date."' AND tugs.gs_date <= '".$end_date."' AND tgs.practitioner_id = '".$pro_user_id."' ORDER BY tugs.gs_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `gs_date` FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_date` >= '".$start_date."' AND `gs_date` <= '".$end_date."' ORDER BY `gs_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_gs_date , $row['gs_date']);
		}
	}		
	
	if(count($arr_gs_date) > 0)
	{		
		for($i=0;$i<count($arr_gs_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tugs.* FROM `tblusersgs` AS tugs LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id WHERE tugs.user_id = '".$user_id."' AND tugs.gs_date = '".$arr_gs_date[$i]."' AND tgs.practitioner_id = '".$pro_user_id."' ORDER BY tugs.user_gs_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_date` = '".$arr_gs_date[$i]."' ORDER BY `user_gs_id` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_gs_id'] != '0')
					{
						$gs_return = true;
						$arr_gs_records[$arr_gs_date[$i]]['selected_gs_id'][$j] = $row2['selected_gs_id'];
						$arr_gs_records[$arr_gs_date[$i]]['scale'][$j] = $row2['scale'];
						$arr_gs_records[$arr_gs_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_gs_records[$arr_gs_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	
				}
			}
		}
	}
		
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tusl.sleep_date FROM `tbluserssleep` AS tusl LEFT JOIN `tblsleeps` AS tsl ON tusl.selected_sleep_id = tsl.sleep_id WHERE tusl.user_id = '".$user_id."' AND tusl.sleep_date >= '".$start_date."' AND tusl.sleep_date <= '".$end_date."' AND tsl.practitioner_id = '".$pro_user_id."' ORDER BY tusl.sleep_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `sleep_date` FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_date` >= '".$start_date."' AND `sleep_date` <= '".$end_date."' ORDER BY `sleep_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_sleep_date , $row['sleep_date']);
		}
	}		
	
	if(count($arr_sleep_date) > 0)
	{		
		for($i=0;$i<count($arr_sleep_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tusl.* FROM `tbluserssleep` AS tusl LEFT JOIN `tblsleeps` AS tsl ON tusl.selected_sleep_id = tsl.sleep_id WHERE tusl.user_id = '".$user_id."' AND tusl.sleep_date = '".$arr_sleep_date[$i]."' AND tsl.practitioner_id = '".$pro_user_id."' ORDER BY tusl.user_sleep_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_date` = '".$arr_sleep_date[$i]."' ORDER BY `user_sleep_id` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_sleep_id'] != '0')
					{	
						$sleep_return = true;
						$arr_sleep_records[$arr_sleep_date[$i]]['sleep_time'][$j] = getUserSleepTime($user_id,$row2['sleep_date']);
						$arr_sleep_records[$arr_sleep_date[$i]]['wakeup_time'][$j] = getUserWakeUpTime($user_id,$row2['sleep_date']);
						$arr_sleep_records[$arr_sleep_date[$i]]['selected_sleep_id'][$j] = $row2['selected_sleep_id'];
						$arr_sleep_records[$arr_sleep_date[$i]]['scale'][$j] = getScaleValue($row2['scale']);
						$arr_sleep_records[$arr_sleep_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_sleep_records[$arr_sleep_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tumc.mc_date FROM `tblusersmc` AS tumc LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id WHERE tumc.user_id = '".$user_id."' AND tumc.mc_date >= '".$start_date."' AND tumc.mc_date <= '".$end_date."' AND tmc.practitioner_id = '".$pro_user_id."' ORDER BY tumc.mc_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `mc_date` FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_date` >= '".$start_date."' AND `mc_date` <= '".$end_date."' ORDER BY `mc_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_mc_date , $row['mc_date']);
		}
	}		
	
	if(count($arr_mc_date) > 0)
	{		
		for($i=0;$i<count($arr_mc_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tumc.* FROM `tblusersmc` AS tumc LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id WHERE tumc.user_id = '".$user_id."' AND tumc.mc_date = '".$arr_mc_date[$i]."' AND tmc.practitioner_id = '".$pro_user_id."' ORDER BY tumc.user_mc_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_date` = '".$arr_mc_date[$i]."' ORDER BY `user_mc_id` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_mc_id'] != '0')
					{
						$mc_return = true;
						$arr_mc_records[$arr_mc_date[$i]]['selected_mc_id'][$j] = $row2['selected_mc_id'];
						$arr_mc_records[$arr_mc_date[$i]]['scale'][$j] = getScaleValue($row2['scale']);
						$arr_mc_records[$arr_mc_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_mc_records[$arr_mc_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tumr.mr_date FROM `tblusersmr` AS tumr LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id WHERE tumr.user_id = '".$user_id."' AND tumr.mr_date >= '".$start_date."' AND tumr.mr_date <= '".$end_date."' AND tmr.practitioner_id = '".$pro_user_id."' ORDER BY tumr.mr_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `mr_date` FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_date` >= '".$start_date."' AND `mr_date` <= '".$end_date."' ORDER BY `mr_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_mr_date , $row['mr_date']);
		}
	}		
	
	if(count($arr_mr_date) > 0)
	{		
		for($i=0;$i<count($arr_mr_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tumr.* FROM `tblusersmr` AS tumr LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id WHERE tumr.user_id = '".$user_id."' AND tumr.mr_date = '".$arr_mr_date[$i]."' AND tmr.practitioner_id = '".$pro_user_id."' ORDER BY tumr.user_mr_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_date` = '".$arr_mr_date[$i]."' ORDER BY `user_mr_id` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_mr_id'] != '0')
					{
						$mr_return = true;
						$arr_mr_records[$arr_mr_date[$i]]['selected_mr_id'][$j] = $row2['selected_mr_id'];
						$arr_mr_records[$arr_mr_date[$i]]['scale'][$j] = getScaleValue($row2['scale']);
						$arr_mr_records[$arr_mr_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_mr_records[$arr_mr_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tumle.mle_date FROM `tblusersmle` AS tumle LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id WHERE tumle.user_id = '".$user_id."' AND tumle.mle_date >= '".$start_date."' AND tumle.mle_date <= '".$end_date."' AND tmle.practitioner_id = '".$pro_user_id."' ORDER BY tumle.mle_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `mle_date` FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_date` >= '".$start_date."' AND `mle_date` <= '".$end_date."' ORDER BY `mle_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_mle_date , $row['mle_date']);
		}
	}		
	
	if(count($arr_mle_date) > 0)
	{		
		for($i=0;$i<count($arr_mle_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tumle.* FROM `tblusersmle` AS tumle LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id WHERE tumle.user_id = '".$user_id."' AND tumle.mle_date = '".$arr_mle_date[$i]."' AND tmle.practitioner_id = '".$pro_user_id."' ORDER BY tumle.user_mle_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_date` = '".$arr_mle_date[$i]."' ORDER BY `user_mle_id` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_mle_id'] != '0')
					{
						$mle_return = true;
						$arr_mle_records[$arr_mle_date[$i]]['selected_mle_id'][$j] = $row2['selected_mle_id'];
						$arr_mle_records[$arr_mle_date[$i]]['scale'][$j] = getScaleValue($row2['scale']);
						$arr_mle_records[$arr_mle_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_mle_records[$arr_mle_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	

				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tuadc.adct_date FROM `tblusersadct` AS tuadc LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id WHERE tuadc.user_id = '".$user_id."' AND tuadc.adct_date >= '".$start_date."' AND tuadc.adct_date <= '".$end_date."' AND tadc.practitioner_id = '".$pro_user_id."' ORDER BY tuadc.adct_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `adct_date` FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_date` >= '".$start_date."' AND `adct_date` <= '".$end_date."' ORDER BY `adct_date` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_adct_date , $row['adct_date']);
		}
	}		
	
	if(count($arr_adct_date) > 0)
	{		
		for($i=0;$i<count($arr_adct_date);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tuadc.* FROM `tblusersadct` AS tuadc LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id WHERE tuadc.user_id = '".$user_id."' AND tuadc.adct_date = '".$arr_adct_date[$i]."' AND tadc.practitioner_id = '".$pro_user_id."' ORDER BY tuadc.user_adct_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_date` = '".$arr_adct_date[$i]."' ORDER BY `user_adct_id` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					if($row2['selected_adct_id'] != '0')
					{
						$adct_return = true;
						$arr_adct_records[$arr_adct_date[$i]]['selected_adct_id'][$j] = $row2['selected_adct_id'];
						$arr_adct_records[$arr_adct_date[$i]]['scale'][$j] = getScaleValue($row2['scale']);
						$arr_adct_records[$arr_adct_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
						$arr_adct_records[$arr_adct_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
						$j++;
					}	
				}
			}
		}
	}
	
	return array($wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records);

}

function getDatewiseEmotionsReportHTML($user_id,$start_date,$end_date,$wae_report,$gs_report,$sleep_report,$mc_report,$mr_report,$mle_report,$adct_report,$permission_type,$pro_user_id)
{
	global $link;
	$return = false;
	$output = '';
	list($wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records) = getDatewiseEmotionsReport($user_id,$start_date,$end_date,$permission_type,$pro_user_id);
		
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
				<tbody>	
					<tr>	
						<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Emotions Report - Datewise</td>
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
						<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
					</tr>
				</tbody>
				</table>';
				
	if( ($wae_return) && ($wae_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Work & Environment</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_wae_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="250" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="900" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($gs_return) && ($gs_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">General Stressors</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_gs_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="250" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="900" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($sleep_return) && ($sleep_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Sleep</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_sleep_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="250" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="900" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
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
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($mc_return) && ($mc_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">My Communication</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_mc_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="250" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="900" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($mr_return) && ($mr_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">My Relations</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_mr_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="250" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="900" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($mle_return) && ($mle_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Major Life Events</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_mle_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="250" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="900" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($adct_return) && ($adct_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Addictions</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_adct_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="250" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Date</td>
						<td width="900" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Situation</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}							
					
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
	return $output;	
}

function getUserSleepTime($user_id,$sleep_date)
{
	global $link;
	$sleep_time = 'NA';
	
	$sql = "SELECT * FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` = '".$sleep_date."' ORDER BY `activity_add_date` ASC ";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			$sleep_time = $row['yesterday_sleep_time'];
		}
	}	
	return $sleep_time;
}

function getUserWakeUpTime($user_id,$wakeup_date)
{
	global $link;
	$wakeup_time = 'NA';
	
	$sql = "SELECT * FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` = '".$wakeup_date."' ORDER BY `activity_add_date` ASC ";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			$wakeup_time = $row['today_wakeup_time'];
		}
	}	
	return $wakeup_time;
}

function getStatementwiseEmotionsReport($user_id,$start_date,$end_date,$permission_type = '0',$pro_user_id = '0')
{
	global $link;
	
	$wae_return = false;
	$arr_selected_wae_id = array();
	$arr_wae_records = array();
	
	$gs_return = false;
	$arr_selected_gs_id = array();
	$arr_gs_records = array();
	
	$sleep_return = false;
	$arr_selected_sleep_id = array();
	$arr_sleep_records = array();
	
	$mc_return = false;
	$arr_selected_mc_id = array();
	$arr_mc_records = array();
	
	$mr_return = false;
	$arr_selected_mr_id = array();
	$arr_mr_records = array();
	
	$mle_return = false;
	$arr_selected_mle_id = array();
	$arr_mle_records = array();
	
	$adct_return = false;
	$arr_selected_adct_id = array();
	$arr_adct_records = array();
			
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tuwae.selected_wae_id FROM `tbluserswae` AS tuwae LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id WHERE tuwae.user_id = '".$user_id."' AND tuwae.wae_date >= '".$start_date."' AND tuwae.wae_date <= '".$end_date."' AND twae.practitioner_id = '".$pro_user_id."' ORDER BY tuwae.selected_wae_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_wae_id` FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_date` >= '".$start_date."' AND `wae_date` <= '".$end_date."' ORDER BY `selected_wae_id` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			 array_push($arr_selected_wae_id , $row['selected_wae_id']);
		}
	}		
	
	if(count($arr_selected_wae_id) > 0)
	{		
		for($i=0;$i<count($arr_selected_wae_id);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tuwae.* FROM `tbluserswae` AS tuwae LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id WHERE tuwae.user_id = '".$user_id."' AND tuwae.selected_wae_id = '".$arr_selected_wae_id[$i]."' AND tuwae.wae_date >= '".$start_date."' AND tuwae.wae_date <= '".$end_date."' AND twae.practitioner_id = '".$pro_user_id."' ORDER BY tuwae.wae_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `selected_wae_id` = '".$arr_selected_wae_id[$i]."' AND `wae_date` >= '".$start_date."' AND `wae_date` <= '".$end_date."' ORDER BY `wae_date` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					$wae_return = true;
					$arr_wae_records[$arr_selected_wae_id[$i]]['date'][$j] = $row2['wae_date'];
					$arr_wae_records[$arr_selected_wae_id[$i]]['scale'][$j] = $row2['scale'];
					$arr_wae_records[$arr_selected_wae_id[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
					$arr_wae_records[$arr_selected_wae_id[$i]]['responce'][$j] = stripslashes($row2['remarks']);
					$j++;
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tugs.selected_gs_id FROM `tblusersgs` AS tugs LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id WHERE tugs.user_id = '".$user_id."' AND tugs.gs_date >= '".$start_date."' AND tugs.gs_date <= '".$end_date."' AND tgs.practitioner_id = '".$pro_user_id."' ORDER BY tugs.selected_gs_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_gs_id` FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_date` >= '".$start_date."' AND `gs_date` <= '".$end_date."' ORDER BY `selected_gs_id` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_selected_gs_id , $row['selected_gs_id']);
		}
	}		
	
	if(count($arr_selected_gs_id) > 0)
	{		
		for($i=0;$i<count($arr_selected_gs_id);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tugs.* FROM `tblusersgs` AS tugs LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id WHERE tugs.user_id = '".$user_id."' AND tugs.selected_gs_id = '".$arr_selected_gs_id[$i]."' AND tugs.gs_date >= '".$start_date."' AND tugs.gs_date <= '".$end_date."' AND tgs.practitioner_id = '".$pro_user_id."' ORDER BY tugs.gs_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `selected_gs_id` = '".$arr_selected_gs_id[$i]."'AND `gs_date` >= '".$start_date."' AND `gs_date` <= '".$end_date."' ORDER BY `gs_date` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					$gs_return = true;
					$arr_gs_records[$arr_selected_gs_id[$i]]['date'][$j] = $row2['gs_date'];
					$arr_gs_records[$arr_selected_gs_id[$i]]['scale'][$j] = $row2['scale'];
					$arr_gs_records[$arr_selected_gs_id[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
					$arr_gs_records[$arr_selected_gs_id[$i]]['responce'][$j] = stripslashes($row2['remarks']);
					$j++;
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tuslp.selected_sleep_id FROM `tbluserssleep` AS tuslp LEFT JOIN `tblsleeps` AS tslp ON tuslp.selected_sleep_id = tslp.sleep_id WHERE tuslp.user_id = '".$user_id."' AND tuslp.sleep_date >= '".$start_date."' AND tuslp.sleep_date <= '".$end_date."' AND tslp.practitioner_id = '".$pro_user_id."' ORDER BY tuslp.selected_sleep_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_sleep_id` FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_date` >= '".$start_date."' AND `sleep_date` <= '".$end_date."' ORDER BY `selected_sleep_id` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_selected_sleep_id , $row['selected_sleep_id']);
		}
	}		
	
	if(count($arr_selected_sleep_id) > 0)
	{		
		for($i=0;$i<count($arr_selected_sleep_id);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tuslp.* FROM `tbluserssleep` AS tuslp LEFT JOIN `tblsleeps` AS tslp ON tuslp.selected_sleep_id = tslp.sleep_id WHERE tuslp.user_id = '".$user_id."' AND tuslp.selected_sleep_id = '".$arr_selected_sleep_id[$i]."' AND tuslp.sleep_date >= '".$start_date."' AND tuslp.sleep_date <= '".$end_date."' AND tslp.practitioner_id = '".$pro_user_id."' ORDER BY tuslp.sleep_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `selected_sleep_id` = '".$arr_selected_sleep_id[$i]."'AND `sleep_date` >= '".$start_date."' AND `sleep_date` <= '".$end_date."' ORDER BY `sleep_date` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					$sleep_return = true;
					$arr_sleep_records[$arr_selected_sleep_id[$i]]['date'][$j] = $row2['sleep_date'];
					$arr_sleep_records[$arr_selected_sleep_id[$i]]['sleep_time'][$j] = getUserSleepTime($user_id,$row2['sleep_date']);
					$arr_sleep_records[$arr_selected_sleep_id[$i]]['wakeup_time'][$j] = getUserWakeUpTime($user_id,$row2['sleep_date']);
					$arr_sleep_records[$arr_selected_sleep_id[$i]]['scale'][$j] = $row2['scale'];
					$arr_sleep_records[$arr_selected_sleep_id[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
					$arr_sleep_records[$arr_selected_sleep_id[$i]]['responce'][$j] = stripslashes($row2['remarks']);
					$j++;
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tumc.selected_mc_id FROM `tblusersmc` AS tumc LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id WHERE tumc.user_id = '".$user_id."' AND tumc.mc_date >= '".$start_date."' AND tumc.mc_date <= '".$end_date."' AND tmc.practitioner_id = '".$pro_user_id."' ORDER BY tumc.selected_mc_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_mc_id` FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_date` >= '".$start_date."' AND `mc_date` <= '".$end_date."' ORDER BY `selected_mc_id` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_selected_mc_id , $row['selected_mc_id']);
		}
	}		
	
	if(count($arr_selected_mc_id) > 0)
	{		
		for($i=0;$i<count($arr_selected_mc_id);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tumc.* FROM `tblusersmc` AS tumc LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id WHERE tumc.user_id = '".$user_id."' AND tumc.selected_mc_id = '".$arr_selected_mc_id[$i]."' AND tumc.mc_date >= '".$start_date."' AND tumc.mc_date <= '".$end_date."' AND tmc.practitioner_id = '".$pro_user_id."' ORDER BY tumc.mc_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `selected_mc_id` = '".$arr_selected_mc_id[$i]."'AND `mc_date` >= '".$start_date."' AND `mc_date` <= '".$end_date."' ORDER BY `mc_date` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					$mc_return = true;
					$arr_mc_records[$arr_selected_mc_id[$i]]['date'][$j] = $row2['mc_date'];
					$arr_mc_records[$arr_selected_mc_id[$i]]['scale'][$j] = $row2['scale'];
					$arr_mc_records[$arr_selected_mc_id[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
					$arr_mc_records[$arr_selected_mc_id[$i]]['responce'][$j] = stripslashes($row2['remarks']);
					$j++;
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tumr.selected_mr_id FROM `tblusersmr` AS tumr LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id WHERE tumr.user_id = '".$user_id."' AND tumr.mr_date >= '".$start_date."' AND tumr.mr_date <= '".$end_date."' AND tmr.practitioner_id = '".$pro_user_id."' ORDER BY tumr.selected_mr_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_mr_id` FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_date` >= '".$start_date."' AND `mr_date` <= '".$end_date."' ORDER BY `selected_mr_id` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_selected_mr_id , $row['selected_mr_id']);
		}
	}		
	
	if(count($arr_selected_mr_id) > 0)
	{		
		for($i=0;$i<count($arr_selected_mr_id);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tumr.* FROM `tblusersmr` AS tumr LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id WHERE tumr.user_id = '".$user_id."' AND tumr.selected_mr_id = '".$arr_selected_mr_id[$i]."' AND tumr.mr_date >= '".$start_date."' AND tumr.mr_date <= '".$end_date."' AND tmr.practitioner_id = '".$pro_user_id."' ORDER BY tumr.mr_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `selected_mr_id` = '".$arr_selected_mr_id[$i]."'AND `mr_date` >= '".$start_date."' AND `mr_date` <= '".$end_date."' ORDER BY `mr_date` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					$mr_return = true;
					$arr_mr_records[$arr_selected_mr_id[$i]]['date'][$j] = $row2['mr_date'];
					$arr_mr_records[$arr_selected_mr_id[$i]]['scale'][$j] = $row2['scale'];
					$arr_mr_records[$arr_selected_mr_id[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
					$arr_mr_records[$arr_selected_mr_id[$i]]['responce'][$j] = stripslashes($row2['remarks']);
					$j++;
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tumle.selected_mle_id FROM `tblusersmle` AS tumle LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id WHERE tumle.user_id = '".$user_id."' AND tumle.mle_date >= '".$start_date."' AND tumle.mle_date <= '".$end_date."' AND tmle.practitioner_id = '".$pro_user_id."' ORDER BY tumle.selected_mle_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_mle_id` FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_date` >= '".$start_date."' AND `mle_date` <= '".$end_date."' ORDER BY `selected_mle_id` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_selected_mle_id , $row['selected_mle_id']);
		}
	}		
	
	if(count($arr_selected_mle_id) > 0)
	{		
		for($i=0;$i<count($arr_selected_mle_id);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tumle.* FROM `tblusersmle` AS tumle LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id WHERE tumle.user_id = '".$user_id."' AND tumle.selected_mle_id = '".$arr_selected_mle_id[$i]."' AND tumle.mle_date >= '".$start_date."' AND tumle.mle_date <= '".$end_date."' AND tmle.practitioner_id = '".$pro_user_id."' ORDER BY tumle.mle_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `selected_mle_id` = '".$arr_selected_mle_id[$i]."'AND `mle_date` >= '".$start_date."' AND `mle_date` <= '".$end_date."' ORDER BY `mle_date` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					$mle_return = true;
					$arr_mle_records[$arr_selected_mle_id[$i]]['date'][$j] = $row2['mle_date'];
					$arr_mle_records[$arr_selected_mle_id[$i]]['scale'][$j] = $row2['scale'];
					$arr_mle_records[$arr_selected_mle_id[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
					$arr_mle_records[$arr_selected_mle_id[$i]]['responce'][$j] = stripslashes($row2['remarks']);
					$j++;
				}
			}
		}
	}
	
	if($permission_type == '1')
	{
		$sql = "SELECT DISTINCT tuadc.selected_adct_id FROM `tblusersadct` AS tuadc LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id WHERE tuadc.user_id = '".$user_id."' AND tuadc.adct_date >= '".$start_date."' AND tuadc.adct_date <= '".$end_date."' AND tadc.practitioner_id = '".$pro_user_id."' ORDER BY tuadc.selected_adct_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_adct_id` FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_date` >= '".$start_date."' AND `adct_date` <= '".$end_date."' ORDER BY `selected_adct_id` ASC ";
	}
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_selected_adct_id , $row['selected_adct_id']);
		}
	}		
	
	if(count($arr_selected_adct_id) > 0)
	{		
		for($i=0;$i<count($arr_selected_adct_id);$i++)
		{	
			if($permission_type == '1')
			{
				$sql2 = "SELECT tuadc.* FROM `tblusersadct` AS tuadc LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id WHERE tuadc.user_id = '".$user_id."' AND tuadc.selected_adct_id = '".$arr_selected_adct_id[$i]."' AND tuadc.adct_date >= '".$start_date."' AND tuadc.adct_date <= '".$end_date."' AND tadc.practitioner_id = '".$pro_user_id."' ORDER BY tuadc.adct_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `selected_adct_id` = '".$arr_selected_adct_id[$i]."'AND `adct_date` >= '".$start_date."' AND `adct_date` <= '".$end_date."' ORDER BY `adct_date` ASC ";
			}
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$j=0;
				while($row2 = mysql_fetch_array($result2))
				{
					$adct_return = true;
					$arr_adct_records[$arr_selected_adct_id[$i]]['date'][$j] = $row2['adct_date'];
					$arr_adct_records[$arr_selected_adct_id[$i]]['scale'][$j] = $row2['scale'];
					$arr_adct_records[$arr_selected_adct_id[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
					$arr_adct_records[$arr_selected_adct_id[$i]]['responce'][$j] = stripslashes($row2['remarks']);
					$j++;
				}
			}
		}
	}
	
	return array($wae_return,$arr_wae_records,$gs_return,$arr_gs_records,$sleep_return,$arr_sleep_records,$mc_return,$arr_mc_records,$mr_return,$arr_mr_records,$mle_return,$arr_mle_records,$adct_return,$arr_adct_records);

}

function getStatementwiseEmotionsReportHTML($user_id,$start_date,$end_date,$wae_report,$gs_report,$sleep_report,$mc_report,$mr_report,$mle_report,$adct_report,$permission_type,$pro_user_id)
{
	global $link;
	$return = false;
	$output = '';
	list($wae_return,$arr_wae_records,$gs_return,$arr_gs_records,$sleep_return,$arr_sleep_records,$mc_return,$arr_mc_records,$mr_return,$arr_mr_records,$mle_return,$arr_mle_records,$adct_return,$arr_adct_records) = getStatementwiseEmotionsReport($user_id,$start_date,$end_date,$permission_type,$pro_user_id);
		
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
				<tbody>	
					<tr>	
						<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Emotions Report - Statement</td>
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
						<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
					</tr>
				</tbody>
				</table>';
				
	if( ($wae_return) && ($wae_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Work & Environment</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_wae_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="650" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getWAESituation($k).'</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>

						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';	
		}
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($gs_return) && ($gs_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">General Stressors</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_gs_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="650" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getGSSituation($k).'</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';	
		}
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($sleep_return) && ($sleep_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Sleep</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_sleep_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="650" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getSleepSituation($k).'</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="200" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Sleep Time</td>
						<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Wake-up Time</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';	
		}
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($mc_return) && ($mc_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">My Communication</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_mc_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="650" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getMCSituation($k).'</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';	
		}
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($mr_return) && ($mr_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">My Relations</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_mr_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="650" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getMRSituation($k).'</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';		
		}
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($mle_return) && ($mle_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Major Life Events</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_mle_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>

						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="650" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getMLESituation($k).'</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';		
		}
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}
	
	if( ($adct_return) && ($adct_report == '1') )
	{
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td align="left" valign="top" bgcolor="#E1E1E1" style="color:#0000FF;">Addictions</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
		 foreach($arr_adct_records as $k => $v)
		 {
	$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;" >
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;"> Situation</td>
						<td width="650" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getADCTSituation($k).'</td>	
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
					<tr>
						<td width="500" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date</td>
						<td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Scale</td>
						<td width="330" height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Responses</td>		
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
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';	
		}
	$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>';
	}							
					
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
	return $output;	
}
?>