<?php
function getNoOfDaysBetweenTwoDates($date_1,$date_2)
{
    $value = 0;
    
    $date1 = new DateTime($date_1);
    $date2 = new DateTime($date_2);

    $value = $date2->diff($date1)->format("%a");
    
    return $value;
}
function getDigitalPersonalWellnessDiary($user_id,$start_date,$end_date,$permission_type = '0',$pro_user_id = '0',$scale_range = '',$start_scale_value = '',$end_scale_value = '',$report_module = '',$module_keyword = '',$module_criteria = '',$criteria_scale_range = '',$start_criteria_scale_value = '',$end_criteria_scale_value = '',$trigger_criteria = '')
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
        
        $bps_return = false;
	$arr_bps_date = array();
	$arr_bps_records = array();
        
        $bes_return = false;
	$arr_bes_date = array();
	$arr_bes_records = array();
        
        $aa_return = false;
	$arr_aa_records = array();
        
        $mt_return = false;
	$arr_mt_records = array();
        
        $mdt_return = false;
	$arr_mdt_date = array();
	$arr_mdt_records = array();
        
        if($report_module == '' || $report_module == 'food_report' || $report_module == '1')
        {
            if($report_module == 'food_report')
            {
                if($module_keyword != '')
                {
                    $sql_str_report_module = " AND `meal_id` = '".$module_keyword."' ";
                }
                else
                {
                    $sql_str_report_module = '';
                }
            }
            else
            {
                $sql_str_report_module = '';
            }
            
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
            elseif($module_criteria == '5')
            {
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND `meal_quantity` < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND `meal_quantity` > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND `meal_quantity` <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND `meal_quantity` >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND `meal_quantity` = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND `meal_quantity` >= '".$start_criteria_scale_value."' AND `meal_quantity` <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                }
                
            }
            elseif($module_criteria == '6')
            {
                if($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND `meal_like` = '".$start_criteria_scale_value."' ";
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
                    //echo '<br>module_criteria = '.$module_criteria;
                    //echo '<br>criteria_scale_range = '.$criteria_scale_range;
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
            
            
			
            $sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE "
                    . "`user_id` = '".$user_id."' AND "
                    . "`meal_date` >= '".$start_date."' AND "
                    . "`meal_date` <= '".$end_date."' ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY `meal_date` DESC ";
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
                    $sql2 = "SELECT * FROM `tblusersmeals` WHERE "
                            . "`user_id` = '".$user_id."' AND "
                            . "`meal_date` = '".$arr_meal_date[$i]."' ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY `user_meal_id` ASC ";
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
        }
        
        if($report_module == '' || $report_module == 'activity_report' || $report_module == '14')
        {
            if($report_module == 'activity_report')
            {
                if($module_keyword != '')
                {
                    $sql_str_report_module = " AND `activity_id` = '".$module_keyword."' ";
                    $sql_str_report_module2 = " AND tuda.activity_id = '".$module_keyword."' ";
                }
                else
                {
                    $sql_str_report_module = '';
                    $sql_str_report_module2 = '';
                }
            }
            else
            {
                $sql_str_report_module = '';
                $sql_str_report_module2 = '';
            }
            
            if($module_criteria == '4')
            {
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND `activity_time` < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND tuda.activity_time < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND `activity_time` > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND tuda.activity_time > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND `activity_time` <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND tuda.activity_time <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND `activity_time` >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND tuda.activity_time >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND `activity_time` = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND tuda.activity_time = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND `activity_time` >= '".$start_criteria_scale_value."' AND `activity_time` <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND tuda.activity_time >= '".$start_criteria_scale_value."' AND tuda.activity_time <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '3')
            {
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuda.mins AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuda.mins AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuda.mins AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuda.mins AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuda.mins AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`mins` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tuda.mins AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tuda.mins AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '7')
            {
                if($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(activity_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tuda.activity_date) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(activity_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(activity_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tuda.activity_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(tuda.activity_date) <= '".$end_criteria_scale_value."' ";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            else
            {
                $sql_str_report_module_criteria = "";
                $sql_str_report_module_criteria2 = "";
            }
	
            $sql = "SELECT DISTINCT `activity_date` FROM `tblusersdailyactivity` WHERE "
                    . "`user_id` = '".$user_id."' AND "
                    . "`activity_date` >= '".$start_date."' AND "
                    . "`activity_date` <= '".$end_date."' AND "
                    . "`activity_id` != '0' AND `activity_id` != '9999999999' ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY activity_date DESC ";
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
                            $sql2 = "SELECT * FROM `tblusersdailyactivity` WHERE "
                                    . "`user_id` = '".$user_id."' AND "
                                    . "`activity_date` = '".$arr_activity_date[$i]."' ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY `user_activity_id` ASC ";
                            
                            $sql2 = "SELECT * FROM `tblusersdailyactivity` As tuda "
                                    . "LEFT JOIN `tbldailyactivity` As tda ON tuda.activity_id = tda.activity_id "
                                    . "WHERE tuda.user_id = '".$user_id."' AND "
                                    . "tuda.activity_date = '".$arr_activity_date[$i]."' AND "
                                    . "tda.activity_id > '0' ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tuda.activity_time ASC ";
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
        }
        
        if($report_module == '' || $report_module == 'activity_analysis_report' || $report_module == '4')
        {
            list($aa_return,$arr_aa_records) = getActivityChart($user_id,$start_date,$end_date,$permission_type,$pro_user_id,$scale_range,$start_scale_value,$end_scale_value,$report_module,$module_keyword,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value);
        }
        
        if($report_module == '' || $report_module == 'meal_time_report' || $report_module == '5')
        {
            list($mt_return,$arr_mt_records) = getMealTimeChart($user_id,$start_date,$end_date,$permission_type,$pro_user_id,$scale_range,$start_scale_value,$end_scale_value,$report_module,$module_keyword,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value);
        }
        
        if($scale_range == '1')
        {
            $sql_str_scale = " AND CAST(`scale` AS SIGNED) < '".$start_scale_value."' ";
        }
        elseif($scale_range == '2')
        {
            $sql_str_scale = " AND CAST(`scale` AS SIGNED) > '".$start_scale_value."' ";
        }
        elseif($scale_range == '3')
        {
            $sql_str_scale = " AND CAST(`scale` AS SIGNED) <= '".$start_scale_value."' ";
        }
        elseif($scale_range == '4')
        {
            $sql_str_scale = " AND CAST(`scale` AS SIGNED) >= '".$start_scale_value."' ";
        }
        elseif($scale_range == '5')
        {
            $sql_str_scale = " AND CAST(`scale` AS SIGNED) = '".$start_scale_value."' ";
        }
        elseif($scale_range == '6')
        {
            $min_value = min($start_scale_value,$end_scale_value);
            $max_value = max($start_scale_value,$end_scale_value);
            $sql_str_scale = " AND CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' ";
        }
        else
        {
            $sql_str_scale = "";
        }
        
        if($report_module == '' || $report_module == 'wae_report' || $report_module == '15')
        {
            if($report_module == 'wae_report')
            {
                if($module_keyword != '')
                {
                    $sql_str_report_module = " AND `selected_wae_id` = '".$module_keyword."' ";
                    $sql_str_report_module2 = " AND tuwae.selected_wae_id = '".$module_keyword."' ";
                    $sql_str_report_module3 = " AND `bms_id` = '".$module_keyword."' ";
                }
                else
                {
                    $sql_str_report_module = '';
                    $sql_str_report_module2 = '';
                    $sql_str_report_module3 = '';
                }
            }
            else
            {
                $sql_str_report_module = '';
                $sql_str_report_module2 = '';
                $sql_str_report_module3 = '';
            }
            
            if($module_criteria == '1')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuwae.my_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuwae.my_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuwae.my_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuwae.my_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuwae.my_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`my_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tuwae.my_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tuwae.my_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '2')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuwae.adviser_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuwae.adviser_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuwae.adviser_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuwae.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuwae.adviser_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`adviser_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tuwae.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tuwae.adviser_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '7')
            {
                if($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(wae_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tuwae.wae_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(wae_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(wae_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tuwae.wae_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(tuwae.wae_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(mdt_date) <= '".$end_criteria_scale_value."' ";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                    $sql_str_report_module_criteria3 = "";
                }
            }
            else
            {
                $sql_str_report_module_criteria = "";
                $sql_str_report_module_criteria2 = "";
                $sql_str_report_module_criteria3 = "";
            }
	
            if($permission_type == '1')
            {
                /*
                $sql = "SELECT DISTINCT tuwae.wae_date FROM `tbluserswae` AS tuwae "
                        . "LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id "
                        . "WHERE tuwae.user_id = '".$user_id."' AND "
                        . "tuwae.wae_date >= '".$start_date."' AND "
                        . "tuwae.wae_date <= '".$end_date."' AND "
                        . "twae.practitioner_id = '".$pro_user_id."' AND "
                        . "tuwae.wae_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tuwae.wae_date ASC ";
                 * 
                 */

                $sql = "SELECT DISTINCT tuwae.wae_date AS wae_date FROM `tbluserswae` AS tuwae "
                        . "LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id "
                        . "WHERE tuwae.user_id = '".$user_id."' AND "
                        . "tuwae.wae_date >= '".$start_date."' AND "
                        . "tuwae.wae_date <= '".$end_date."' AND "
                        . "tuwae.wae_old_data = '0' AND "
                        . "twae.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS wae_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tblworkandenvironments` AS twae ON tumdt.bms_id = twae.wae_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'wae' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "twae.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY wae_date DESC ";
            }
            elseif($permission_type == '0')
            {
                /*
                $sql = "SELECT DISTINCT tuwae.wae_date FROM `tbluserswae` AS tuwae "
                        . "LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id "
                        . "WHERE tuwae.user_id = '".$user_id."' AND "
                        . "tuwae.wae_date >= '".$start_date."' AND "
                        . "tuwae.wae_date <= '".$end_date."' AND "
                        . "twae.practitioner_id = '0' AND "
                        . "tuwae.wae_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tuwae.wae_date ASC ";
                 * 
                 */

                $sql = "SELECT DISTINCT tuwae.wae_date AS wae_date FROM `tbluserswae` AS tuwae "
                        . "LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id "
                        . "WHERE tuwae.user_id = '".$user_id."' AND "
                        . "tuwae.wae_date >= '".$start_date."' AND "
                        . "tuwae.wae_date <= '".$end_date."' AND "
                        . "tuwae.wae_old_data = '0' AND "
                        . "twae.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS wae_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tblworkandenvironments` AS twae ON tumdt.bms_id = twae.wae_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'wae' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "twae.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY wae_date DESC ";
            }
            else
            {
                $sql = "SELECT DISTINCT `wae_date` FROM `tbluserswae` WHERE "
                        . "`user_id` = '".$user_id."' AND "
                        . "`wae_date` >= '".$start_date."' AND "
                        . "`wae_date` <= '".$end_date."' AND "
                        . "`wae_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria." ";
                
                $sql .= " UNION SELECT DISTINCT mdt_date AS wae_date FROM `tblusersmdt` "
                        . "WHERE `user_id` = '".$user_id."' AND "
                        . "`bms_entry_type` = 'trigger' AND "
                        . "`bms_type` = 'wae' AND "
                        . "`mdt_date` >= '".$start_date."' AND "
                        . "`mdt_date` <= '".$end_date."' AND "
                        . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY wae_date DESC ";
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
                        /*
                        $sql2 = "SELECT tuwae.* FROM `tbluserswae` AS tuwae "
                                . "LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id "
                                . "WHERE tuwae.user_id = '".$user_id."' AND "
                                . "tuwae.wae_date = '".$arr_wae_date[$i]."' AND "
                                . "twae.practitioner_id = '".$pro_user_id."' AND "
                                . "tuwae.wae_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tuwae.user_wae_id ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT tuwae.user_wae_id AS user_wae_id , tuwae.wae_date AS wae_date , tuwae.selected_wae_id AS selected_wae_id , "
                                . "tuwae.scale AS scale , tuwae.remarks AS remarks , tuwae.my_target AS my_target , tuwae.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tbluserswae` AS tuwae "
                                . "LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id "
                                . "WHERE tuwae.user_id = '".$user_id."' AND "
                                . "tuwae.wae_date = '".$arr_wae_date[$i]."' AND "
                                . "tuwae.wae_old_data = '0' AND "
                                . "twae.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_wae_id ,  tumdt.mdt_date AS wae_date , tumdt.bms_id AS selected_wae_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tblworkandenvironments` AS twae ON tumdt.bms_id = twae.wae_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'wae' AND "
                                . "tumdt.mdt_date = '".$arr_wae_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "twae.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_wae_id ASC ";
                    }
                    elseif($permission_type == '0')
                    {
                        /*
                        $sql2 = "SELECT tuwae.* FROM `tbluserswae` AS tuwae "
                                . "LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id "
                                . "WHERE tuwae.user_id = '".$user_id."' AND "
                                . "tuwae.wae_date = '".$arr_wae_date[$i]."' AND "
                                . "twae.practitioner_id = '0' AND " 
                                . "tuwae.wae_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tuwae.user_wae_id ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT tuwae.user_wae_id AS user_wae_id , tuwae.wae_date AS wae_date , tuwae.selected_wae_id AS selected_wae_id , "
                                . "tuwae.scale AS scale , tuwae.remarks AS remarks , tuwae.my_target AS my_target , tuwae.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tbluserswae` AS tuwae "
                                . "LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id "
                                . "WHERE tuwae.user_id = '".$user_id."' AND "
                                . "tuwae.wae_date = '".$arr_wae_date[$i]."' AND "
                                . "tuwae.wae_old_data = '0' AND "
                                . "twae.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_wae_id ,  tumdt.mdt_date AS wae_date , tumdt.bms_id AS selected_wae_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tblworkandenvironments` AS twae ON tumdt.bms_id = twae.wae_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'wae' AND "
                                . "tumdt.mdt_date = '".$arr_wae_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "twae.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_wae_id ASC ";
                    }
                    else
                    {
                        /*
                        $sql2 = "SELECT * FROM `tbluserswae` WHERE "
                                . "`user_id` = '".$user_id."' AND "
                                . "`wae_date` = '".$arr_wae_date[$i]."' AND "
                                . "`wae_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY `user_wae_id` ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT user_wae_id,wae_date,selected_wae_id,scale,remarks,my_target,adviser_target , 'emo' AS 'data_source' FROM `tbluserswae` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "wae_date = '".$arr_wae_date[$i]."' AND "
                                . "wae_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ";

                        $sql2 .= " UNION SELECT user_mdt_id AS user_wae_id , mdt_date AS wae_date , bms_id AS selected_wae_id , "
                                . "scale AS scale , remarks AS remarks , my_target AS my_target , adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "`bms_entry_type` = 'trigger' AND "
                                . "`bms_type` = 'wae' AND "
                                . "`mdt_date` = '".$arr_wae_date[$i]."' AND "
                                . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_wae_id ASC ";
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
                                $arr_wae_records[$arr_wae_date[$i]]['my_target'][$j] = stripslashes($row2['my_target']);
                                $arr_wae_records[$arr_wae_date[$i]]['adviser_target'][$j] = stripslashes($row2['adviser_target']);
                                $arr_wae_records[$arr_wae_date[$i]]['data_source'][$j] = stripslashes($row2['data_source']);
                                $j++;
                            }	
                        }
                    }
                }
            }
        }
        
        if($report_module == '' || $report_module == 'gs_report' || $report_module == '16')
        {
            if($report_module == 'gs_report')
            {
                if($module_keyword != '')
                {
                    $sql_str_report_module = " AND `selected_gs_id` = '".$module_keyword."' ";
                    $sql_str_report_module2 = " AND tugs.selected_gs_id = '".$module_keyword."' ";
                    $sql_str_report_module3 = " AND `bms_id` = '".$module_keyword."' ";
                }
                else
                {
                    $sql_str_report_module = '';
                    $sql_str_report_module2 = '';
                    $sql_str_report_module3 = '';
                }
            }
            else
            {
                $sql_str_report_module = '';
                $sql_str_report_module2 = '';
                $sql_str_report_module3 = '';
            }
            
            if($module_criteria == '1')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tugs.my_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tugs.my_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tugs.my_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tugs.my_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tugs.my_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`my_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tugs.my_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tugs.my_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '2')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tugs.adviser_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tugs.adviser_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tugs.adviser_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tugs.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tugs.adviser_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`adviser_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tugs.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tugs.adviser_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '7')
            {
                if($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(gs_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tugs.gs_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(gs_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(gs_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tugs.gs_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(tugs.gs_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(mdt_date) <= '".$end_criteria_scale_value."' ";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                    $sql_str_report_module_criteria3 = "";
                }
            }
            else
            {
                $sql_str_report_module_criteria = "";
                $sql_str_report_module_criteria2 = "";
                $sql_str_report_module_criteria3 = "";
            }
	
            if($permission_type == '1')
            {
                /*
                $sql = "SELECT DISTINCT tugs.gs_date FROM `tblusersgs` AS tugs "
                        . "LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id "
                        . "WHERE tugs.user_id = '".$user_id."' AND "
                        . "tugs.gs_date >= '".$start_date."' AND "
                        . "tugs.gs_date <= '".$end_date."' AND "
                        . "tugs.gs_old_data = '0' AND "
                        . "tgs.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tugs.gs_date ASC ";
                 * 
                 */
                
                $sql = "SELECT DISTINCT tugs.gs_date AS gs_date FROM `tblusersgs` AS tugs "
                        . "LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id "
                        . "WHERE tugs.user_id = '".$user_id."' AND "
                        . "tugs.gs_date >= '".$start_date."' AND "
                        . "tugs.gs_date <= '".$end_date."' AND "
                        . "tugs.gs_old_data = '0' AND "
                        . "tgs.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS gs_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tblgeneralstressors` AS tgs ON tumdt.bms_id = tgs.gs_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'gs' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "tgs.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY gs_date DESC ";
            }
            elseif($permission_type == '0')
            {
                /*
                $sql = "SELECT DISTINCT tugs.gs_date FROM `tblusersgs` AS tugs "
                        . "LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id "
                        . "WHERE tugs.user_id = '".$user_id."' AND "
                        . "tugs.gs_date >= '".$start_date."' AND "
                        . "tugs.gs_date <= '".$end_date."' AND "
                        . "tugs.gs_old_data = '0' AND "
                        . "tgs.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ORDER BY tugs.gs_date ASC ";
                 * 
                 */
                
                $sql = "SELECT DISTINCT tugs.gs_date AS gs_date FROM `tblusersgs` AS tugs "
                        . "LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id "
                        . "WHERE tugs.user_id = '".$user_id."' AND "
                        . "tugs.gs_date >= '".$start_date."' AND "
                        . "tugs.gs_date <= '".$end_date."' AND "
                        . "tugs.gs_old_data = '0' AND "
                        . "tgs.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS gs_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tblgeneralstressors` AS tgs ON tumdt.bms_id = tgs.gs_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'gs' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "tgs.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY gs_date DESC ";
            }
            else
            {
                $sql = "SELECT DISTINCT `gs_date` FROM `tblusersgs` WHERE "
                        . "`user_id` = '".$user_id."' AND "
                        . "`gs_date` >= '".$start_date."' AND "
                        . "`gs_date` <= '".$end_date."' AND "
                        . "`gs_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria." ";
                
                $sql .= " UNION SELECT DISTINCT mdt_date AS gs_date FROM `tblusersmdt` "
                        . "WHERE `user_id` = '".$user_id."' AND "
                        . "`bms_entry_type` = 'trigger' AND "
                        . "`bms_type` = 'gs' AND "
                        . "`mdt_date` >= '".$start_date."' AND "
                        . "`mdt_date` <= '".$end_date."' AND "
                        . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY gs_date DESC ";
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
                        /*
                        $sql2 = "SELECT tugs.* FROM `tblusersgs` AS tugs "
                                . "LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id "
                                . "WHERE tugs.user_id = '".$user_id."' AND "
                                . "tugs.gs_date = '".$arr_gs_date[$i]."' AND "
                                . "tugs.gs_old_data = '0' AND "
                                . "tgs.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tugs.user_gs_id ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT tugs.user_gs_id AS user_gs_id , tugs.gs_date AS gs_date , tugs.selected_gs_id AS selected_gs_id , "
                                . "tugs.scale AS scale , tugs.remarks AS remarks , tugs.my_target AS my_target , tugs.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tblusersgs` AS tugs "
                                . "LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id "
                                . "WHERE tugs.user_id = '".$user_id."' AND "
                                . "tugs.gs_date = '".$arr_gs_date[$i]."' AND "
                                . "tugs.gs_old_data = '0' AND "
                                . "tgs.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_gs_id ,  tumdt.mdt_date AS gs_date , tumdt.bms_id AS selected_gs_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tblgeneralstressors` AS tgs ON tumdt.bms_id = tgs.gs_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'gs' AND "
                                . "tumdt.mdt_date = '".$arr_gs_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "tgs.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_gs_id ASC ";
                    }
                    elseif($permission_type == '0')
                    {
                        /*
                        $sql2 = "SELECT tugs.* FROM `tblusersgs` AS tugs "
                                . "LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id "
                                . "WHERE tugs.user_id = '".$user_id."' AND "
                                . "tugs.gs_date = '".$arr_gs_date[$i]."' AND "
                                . "tugs.gs_old_data = '0' AND "
                                . "tgs.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tugs.user_gs_id ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT tugs.user_gs_id AS user_gs_id , tugs.gs_date AS gs_date , tugs.selected_gs_id AS selected_gs_id , "
                                . "tugs.scale AS scale , tugs.remarks AS remarks , tugs.my_target AS my_target , tugs.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tblusersgs` AS tugs "
                                . "LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id "
                                . "WHERE tugs.user_id = '".$user_id."' AND "
                                . "tugs.gs_date = '".$arr_gs_date[$i]."' AND "
                                . "tugs.gs_old_data = '0' AND "
                                . "tgs.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_gs_id ,  tumdt.mdt_date AS gs_date , tumdt.bms_id AS selected_gs_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tblgeneralstressors` AS tgs ON tumdt.bms_id = tgs.gs_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'gs' AND "
                                . "tumdt.mdt_date = '".$arr_gs_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "tgs.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_gs_id ASC ";
                    }
                    else
                    {
                        /*
                        $sql2 = "SELECT * FROM `tblusersgs` WHERE "
                                . "`user_id` = '".$user_id."' AND "
                                . "`gs_date` = '".$arr_gs_date[$i]."' AND "
                                . "`gs_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY `user_gs_id` ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT user_gs_id,gs_date,selected_gs_id,scale,remarks,my_target,adviser_target , 'emo' AS 'data_source' FROM `tblusersgs` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "gs_date = '".$arr_gs_date[$i]."' AND "
                                . "gs_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ";

                        $sql2 .= " UNION SELECT user_mdt_id AS user_gs_id , mdt_date AS gs_date , bms_id AS selected_gs_id , "
                                . "scale AS scale , remarks AS remarks , my_target AS my_target , adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "`bms_entry_type` = 'trigger' AND "
                                . "`bms_type` = 'gs' AND "
                                . "`mdt_date` = '".$arr_gs_date[$i]."' AND "
                                . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_gs_id ASC ";
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
                                $arr_gs_records[$arr_gs_date[$i]]['my_target'][$j] = stripslashes($row2['my_target']);
                                $arr_gs_records[$arr_gs_date[$i]]['adviser_target'][$j] = stripslashes($row2['adviser_target']);
                                $arr_gs_records[$arr_gs_date[$i]]['data_source'][$j] = stripslashes($row2['data_source']);
                                $j++;
                            }	
                        }
                    }
                }
            }
        }    
	
        if($report_module == '' || $report_module == 'sleep_report' || $report_module == '17')
        {
            if($report_module == 'sleep_report')
            {
                if($module_keyword != '')
                {
                    $sql_str_report_module = " AND `selected_sleep_id` = '".$module_keyword."' ";
                    $sql_str_report_module2 = " AND tusl.selected_sleep_id = '".$module_keyword."' ";
                    $sql_str_report_module3 = " AND `bms_id` = '".$module_keyword."' ";
                }
                else
                {
                    $sql_str_report_module = '';
                    $sql_str_report_module2 = '';
                    $sql_str_report_module3 = '';
                }
            }
            else
            {
                $sql_str_report_module = '';
                $sql_str_report_module2 = '';
                $sql_str_report_module3 = '';
            }
            
            if($module_criteria == '1')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tusl.my_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tusl.my_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tusl.my_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tusl.my_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tusl.my_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`my_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tusl.my_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tusl.my_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '2')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tusl.adviser_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tusl.adviser_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tusl.adviser_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tusl.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tusl.adviser_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`adviser_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tusl.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tusl.adviser_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '7')
            {
                if($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(sleep_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tusl.sleep_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(sleep_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(sleep_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tusl.sleep_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(tusl.sleep_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(mdt_date) <= '".$end_criteria_scale_value."' ";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                    $sql_str_report_module_criteria3 = "";
                }
            }
            else
            {
                $sql_str_report_module_criteria = "";
                $sql_str_report_module_criteria2 = "";
                $sql_str_report_module_criteria3 = "";
            }
            
            if($permission_type == '1')
            {
                $sql = "SELECT DISTINCT tusl.sleep_date AS sleep_date FROM `tbluserssleep` AS tusl "
                        . "LEFT JOIN `tblsleeps` AS tsl ON tusl.selected_sleep_id = tsl.sleep_id "
                        . "WHERE tusl.user_id = '".$user_id."' AND "
                        . "tusl.sleep_date >= '".$start_date."' AND "
                        . "tusl.sleep_date <= '".$end_date."' AND "
                        . "tusl.sleep_old_data = '0' AND "
                        . "tsl.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS sleep_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tblsleeps` AS tsl ON tumdt.bms_id = tsl.sleep_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'sleep' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "tsl.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY sleep_date DESC ";
            }
            elseif($permission_type == '0')
            {
                $sql = "SELECT DISTINCT tusl.sleep_date AS sleep_date FROM `tbluserssleep` AS tusl "
                        . "LEFT JOIN `tblsleeps` AS tsl ON tusl.selected_sleep_id = tsl.sleep_id "
                        . "WHERE tusl.user_id = '".$user_id."' AND "
                        . "tusl.sleep_date >= '".$start_date."' AND "
                        . "tusl.sleep_date <= '".$end_date."' AND "
                        . "tusl.sleep_old_data = '0' AND "
                        . "tsl.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ";

                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS sleep_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tblsleeps` AS tsl ON tumdt.bms_id = tsl.sleep_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'sleep' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "tsl.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY sleep_date DESC ";
            }
            else
            {
                $sql = "SELECT DISTINCT `sleep_date` FROM `tbluserssleep` "
                        . "WHERE `user_id` = '".$user_id."' AND "
                        . "`sleep_date` >= '".$start_date."' AND "
                        . "`sleep_date` <= '".$end_date."' AND "
                        . "`sleep_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria." ";

                $sql .= " UNION SELECT DISTINCT mdt_date AS sleep_date FROM `tblusersmdt` "
                        . "WHERE `user_id` = '".$user_id."' AND "
                        . "`bms_entry_type` = 'trigger' AND "
                        . "`bms_type` = 'sleep' AND "
                        . "`mdt_date` >= '".$start_date."' AND "
                        . "`mdt_date` <= '".$end_date."' AND "
                        . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY sleep_date DESC ";
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
                        /*
                        $sql2 = "SELECT tusl.* FROM `tbluserssleep` AS tusl "
                                . "LEFT JOIN `tblsleeps` AS tsl ON tusl.selected_sleep_id = tsl.sleep_id "
                                . "WHERE tusl.user_id = '".$user_id."' AND "
                                . "tusl.sleep_date = '".$arr_sleep_date[$i]."' AND "
                                . "tusl.sleep_old_data = '0' AND "
                                . "tsl.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tusl.user_sleep_id ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT tusl.user_sleep_id AS user_sleep_id , tusl.sleep_date AS sleep_date , tusl.selected_sleep_id AS selected_sleep_id , "
                                . "tusl.scale AS scale , tusl.remarks AS remarks , tusl.my_target AS my_target , tusl.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tbluserssleep` AS tusl "
                                . "LEFT JOIN `tblsleeps` AS tsl ON tusl.selected_sleep_id = tsl.sleep_id "
                                . "WHERE tusl.user_id = '".$user_id."' AND "
                                . "tusl.sleep_date = '".$arr_sleep_date[$i]."' AND "
                                . "tusl.sleep_old_data = '0' AND "
                                . "tsl.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_sleep_id ,  tumdt.mdt_date AS sleep_date , tumdt.bms_id AS selected_sleep_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tblsleeps` AS tsl ON tumdt.bms_id = tsl.sleep_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'sleep' AND "
                                . "tumdt.mdt_date = '".$arr_sleep_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "tsl.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_sleep_id ASC ";
                    }
                    elseif($permission_type == '0')
                    {
                        /*
                        $sql2 = "SELECT tusl.* FROM `tbluserssleep` AS tusl "
                                . "LEFT JOIN `tblsleeps` AS tsl ON tusl.selected_sleep_id = tsl.sleep_id "
                                . "WHERE tusl.user_id = '".$user_id."' AND "
                                . "tusl.sleep_date = '".$arr_sleep_date[$i]."' AND "
                                . "tusl.sleep_old_data = '0' AND "
                                . "tsl.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tusl.user_sleep_id ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT tusl.user_sleep_id AS user_sleep_id , tusl.sleep_date AS sleep_date , tusl.selected_sleep_id AS selected_sleep_id , "
                                . "tusl.scale AS scale , tusl.remarks AS remarks , tusl.my_target AS my_target , tusl.adviser_target AS adviser_target , 'emo' AS 'data_source' FROM `tbluserssleep` AS tusl "
                                . "LEFT JOIN `tblsleeps` AS tsl ON tusl.selected_sleep_id = tsl.sleep_id "
                                . "WHERE tusl.user_id = '".$user_id."' AND "
                                . "tusl.sleep_date = '".$arr_sleep_date[$i]."' AND "
                                . "tusl.sleep_old_data = '0' AND "
                                . "tsl.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_sleep_id ,  tumdt.mdt_date AS sleep_date , tumdt.bms_id AS selected_sleep_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tblsleeps` AS tsl ON tumdt.bms_id = tsl.sleep_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'sleep' AND "
                                . "tumdt.mdt_date = '".$arr_sleep_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "tsl.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_sleep_id ASC ";
                    }
                    else
                    {
                        /*
                        $sql2 = "SELECT * FROM `tbluserssleep` WHERE "
                                . "`user_id` = '".$user_id."' AND "
                                . "`sleep_date` = '".$arr_sleep_date[$i]."' AND "
                                . "`sleep_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `user_sleep_id` ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT user_sleep_id,sleep_date,selected_sleep_id,scale,remarks,my_target,adviser_target , 'emo' AS 'data_source' FROM `tbluserssleep` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "sleep_date = '".$arr_sleep_date[$i]."' AND "
                                . "sleep_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ";

                        $sql2 .= " UNION SELECT user_mdt_id AS user_sleep_id , mdt_date AS sleep_date , bms_id AS selected_sleep_id , "
                                . "scale AS scale , remarks AS remarks , my_target AS my_target , adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "`bms_entry_type` = 'trigger' AND "
                                . "`bms_type` = 'sleep' AND "
                                . "`mdt_date` = '".$arr_sleep_date[$i]."' AND "
                                . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_sleep_id ASC ";
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
                                $arr_sleep_records[$arr_sleep_date[$i]]['my_target'][$j] = stripslashes($row2['my_target']);
                                $arr_sleep_records[$arr_sleep_date[$i]]['adviser_target'][$j] = stripslashes($row2['adviser_target']);
                                $arr_sleep_records[$arr_sleep_date[$i]]['data_source'][$j] = stripslashes($row2['data_source']);
                                $j++;
                            }	
                        }
                    }
                }
            }
        }
        
        if($report_module == '' || $report_module == 'mc_report' || $report_module == '18')
        {
            if($report_module == 'mc_report')
            {
                if($module_keyword != '')
                {
                    $sql_str_report_module = " AND `selected_mc_id` = '".$module_keyword."' ";
                    $sql_str_report_module2 = " AND tumc.selected_mc_id = '".$module_keyword."' ";
                    $sql_str_report_module3 = " AND `bms_id` = '".$module_keyword."' ";
                }
                else
                {
                    $sql_str_report_module = '';
                    $sql_str_report_module2 = '';
                    $sql_str_report_module3 = '';
                }
            }
            else
            {
                $sql_str_report_module = '';
                $sql_str_report_module2 = '';
                $sql_str_report_module3 = '';
            }
            
            if($module_criteria == '1')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumc.my_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumc.my_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumc.my_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumc.my_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumc.my_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`my_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tumc.my_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tumc.my_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '2')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumc.adviser_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumc.adviser_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumc.adviser_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumc.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumc.adviser_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`adviser_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tumc.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tumc.adviser_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '7')
            {
                if($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(mc_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tumc.mc_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(mc_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(mc_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tumc.mc_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(tumc.mc_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(mdt_date) <= '".$end_criteria_scale_value."' ";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                    $sql_str_report_module_criteria3 = "";
                }
            }
            else
            {
                $sql_str_report_module_criteria = "";
                $sql_str_report_module_criteria2 = "";
                $sql_str_report_module_criteria3 = "";
            }
        
            if($permission_type == '1')
            {
                /*
                $sql = "SELECT DISTINCT tumc.mc_date FROM `tblusersmc` AS tumc "
                        . "LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id "
                        . "WHERE tumc.user_id = '".$user_id."' AND "
                        . "tumc.mc_date >= '".$start_date."' AND "
                        . "tumc.mc_date <= '".$end_date."' AND "
                        . "tumc.mc_old_data = '0'  AND "
                        . "tmc.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tumc.mc_date ASC ";
                 * 
                 */
                
                $sql = "SELECT DISTINCT tumc.mc_date AS mc_date FROM `tblusersmc` AS tumc "
                        . "LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id "
                        . "WHERE tumc.user_id = '".$user_id."' AND "
                        . "tumc.mc_date >= '".$start_date."' AND "
                        . "tumc.mc_date <= '".$end_date."' AND "
                        . "tumc.mc_old_data = '0' AND "
                        . "tmc.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS mc_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tblmycommunications` AS tmc ON tumdt.bms_id = tmc.mc_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'mc' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "tmc.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY mc_date DESC ";
            }
            elseif($permission_type == '0')
            {
                /*
                $sql = "SELECT DISTINCT tumc.mc_date FROM `tblusersmc` AS tumc "
                        . "LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id "
                        . "WHERE tumc.user_id = '".$user_id."' AND "
                        . "tumc.mc_date >= '".$start_date."' AND "
                        . "tumc.mc_date <= '".$end_date."' AND "
                        . "tumc.mc_old_data = '0'  AND "
                        . "tmc.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tumc.mc_date ASC ";
                 * 
                 */
                
                $sql = "SELECT DISTINCT tumc.mc_date AS mc_date FROM `tblusersmc` AS tumc "
                        . "LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id "
                        . "WHERE tumc.user_id = '".$user_id."' AND "
                        . "tumc.mc_date >= '".$start_date."' AND "
                        . "tumc.mc_date <= '".$end_date."' AND "
                        . "tumc.mc_old_data = '0' AND "
                        . "tmc.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS mc_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tblmycommunications` AS tmc ON tumdt.bms_id = tmc.mc_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'mc' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "tmc.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY mc_date DESC ";
            }
            else
            {
                $sql = "SELECT DISTINCT `mc_date` FROM `tblusersmc` WHERE "
                        . "`user_id` = '".$user_id."' AND "
                        . "`mc_date` >= '".$start_date."' AND "
                        . "`mc_date` <= '".$end_date."' AND "
                        . "`mc_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ";
                
                $sql .= " UNION SELECT DISTINCT mdt_date AS mc_date FROM `tblusersmdt` "
                        . "WHERE `user_id` = '".$user_id."' AND "
                        . "`bms_entry_type` = 'trigger' AND "
                        . "`bms_type` = 'mc' AND "
                        . "`mdt_date` >= '".$start_date."' AND "
                        . "`mdt_date` <= '".$end_date."' AND "
                        . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY mc_date DESC ";
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
                        /*
                        $sql2 = "SELECT tumc.* FROM `tblusersmc` AS tumc "
                                . "LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id "
                                . "WHERE tumc.user_id = '".$user_id."' AND "
                                . "tumc.mc_date = '".$arr_mc_date[$i]."' AND "
                                . "tumc.mc_old_data = '0'  AND "
                                . "tmc.practitioner_id = '".$pro_user_id."' ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tumc.user_mc_id ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT tumc.user_mc_id AS user_mc_id , tumc.mc_date AS mc_date , tumc.selected_mc_id AS selected_mc_id , "
                                . "tumc.scale AS scale , tumc.remarks AS remarks , tumc.my_target AS my_target , tumc.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tblusersmc` AS tumc "
                                . "LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id "
                                . "WHERE tumc.user_id = '".$user_id."' AND "
                                . "tumc.mc_date = '".$arr_mc_date[$i]."' AND "
                                . "tumc.mc_old_data = '0' AND "
                                . "tmc.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_mc_id ,  tumdt.mdt_date AS mc_date , tumdt.bms_id AS selected_mc_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tblmycommunications` AS tmc ON tumdt.bms_id = tmc.mc_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'mc' AND "
                                . "tumdt.mdt_date = '".$arr_mc_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "tmc.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_mc_id ASC ";
                    }
                    elseif($permission_type == '0')
                    {
                        /*
                        $sql2 = "SELECT tumc.* FROM `tblusersmc` AS tumc "
                                . "LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id "
                                . "WHERE tumc.user_id = '".$user_id."' AND "
                                . "tumc.mc_date = '".$arr_mc_date[$i]."' AND "
                                . "tumc.mc_old_data = '0'  AND "
                                . "tmc.practitioner_id = '0' ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tumc.user_mc_id ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT tumc.user_mc_id AS user_mc_id , tumc.mc_date AS mc_date , tumc.selected_mc_id AS selected_mc_id , "
                                . "tumc.scale AS scale , tumc.remarks AS remarks , tumc.my_target AS my_target , tumc.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tblusersmc` AS tumc "
                                . "LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id "
                                . "WHERE tumc.user_id = '".$user_id."' AND "
                                . "tumc.mc_date = '".$arr_mc_date[$i]."' AND "
                                . "tumc.mc_old_data = '0' AND "
                                . "tmc.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_mc_id ,  tumdt.mdt_date AS mc_date , tumdt.bms_id AS selected_mc_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tblmycommunications` AS tmc ON tumdt.bms_id = tmc.mc_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'mc' AND "
                                . "tumdt.mdt_date = '".$arr_mc_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "tmc.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_mc_id ASC ";
                    }
                    else
                    {
                        /*
                        $sql2 = "SELECT * FROM `tblusersmc` WHERE "
                                . "`user_id` = '".$user_id."' AND "
                                . "`mc_date` = '".$arr_mc_date[$i]."' AND "
                                . "`mc_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `user_mc_id` ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT user_mc_id,mc_date,selected_mc_id,scale,remarks,my_target,adviser_target , 'emo' AS 'data_source' FROM `tblusersmc` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "mc_date = '".$arr_mc_date[$i]."' AND "
                                . "mc_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ";

                        $sql2 .= " UNION SELECT user_mdt_id AS user_mc_id , mdt_date AS mc_date , bms_id AS selected_mc_id , "
                                . "scale AS scale , remarks AS remarks , my_target AS my_target , adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "`bms_entry_type` = 'trigger' AND "
                                . "`bms_type` = 'mc' AND "
                                . "`mdt_date` = '".$arr_mc_date[$i]."' AND "
                                . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_mc_id ASC ";
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
                                $arr_mc_records[$arr_mc_date[$i]]['my_target'][$j] = stripslashes($row2['my_target']);
                                $arr_mc_records[$arr_mc_date[$i]]['adviser_target'][$j] = stripslashes($row2['adviser_target']);
                                $arr_mc_records[$arr_mc_date[$i]]['data_source'][$j] = stripslashes($row2['data_source']);
                                $j++;
                            }	
                        }
                    }
                }
            }
        }
        
        if($report_module == '' || $report_module == 'mr_report' || $report_module == '19')
        {
            if($report_module == 'mr_report')
            {
                if($module_keyword != '')
                {
                    $sql_str_report_module = " AND `selected_mr_id` = '".$module_keyword."' ";
                    $sql_str_report_module2 = " AND tumr.selected_mr_id = '".$module_keyword."' ";
                    $sql_str_report_module3 = " AND `bms_id` = '".$module_keyword."' ";
                }
                else
                {
                    $sql_str_report_module = '';
                    $sql_str_report_module2 = '';
                    $sql_str_report_module3 = '';
                }
            }
            else
            {
                $sql_str_report_module = '';
                $sql_str_report_module2 = '';
                $sql_str_report_module3 = '';
            }
            
            if($module_criteria == '1')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumr.my_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumr.my_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumr.my_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumr.my_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumr.my_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`my_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tumr.my_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tumr.my_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '2')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumr.adviser_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumr.adviser_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumr.adviser_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumr.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumr.adviser_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`adviser_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tumr.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tumr.adviser_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '7')
            {
                if($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(mr_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tumr.mr_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(mr_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(mr_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tumr.mr_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(tumr.mr_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(mdt_date) <= '".$end_criteria_scale_value."' ";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                    $sql_str_report_module_criteria3 = "";
                }
            }
            else
            {
                $sql_str_report_module_criteria = "";
                $sql_str_report_module_criteria2 = "";
                $sql_str_report_module_criteria3 = "";
            }
	
            if($permission_type == '1')
            {
                $sql = "SELECT DISTINCT tumr.mr_date AS mr_date FROM `tblusersmr` AS tumr "
                        . "LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id "
                        . "WHERE tumr.user_id = '".$user_id."' AND "
                        . "tumr.mr_date >= '".$start_date."' AND "
                        . "tumr.mr_date <= '".$end_date."' AND "
                        . "tumr.mr_old_data = '0'  AND "
                        . "tmr.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS mr_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tblmyrelations` AS tmr ON tumdt.bms_id = tmr.mr_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'mr' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "tmr.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY mr_date DESC ";
            }
            elseif($permission_type == '0')
            {
                $sql = "SELECT DISTINCT tumr.mr_date AS mr_date FROM `tblusersmr` AS tumr "
                        . "LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id "
                        . "WHERE tumr.user_id = '".$user_id."' AND "
                        . "tumr.mr_date >= '".$start_date."' AND "
                        . "tumr.mr_date <= '".$end_date."' AND "
                        . "tumr.mr_old_data = '0'  AND "
                        . "tmr.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS mr_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tblmyrelations` AS tmr ON tumdt.bms_id = tmr.mr_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'mr' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "tmr.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY mr_date DESC ";
            }
            else
            {
                $sql = "SELECT DISTINCT `mr_date` FROM `tblusersmr` WHERE "
                        . "`user_id` = '".$user_id."' AND "
                        . "`mr_date` >= '".$start_date."' AND "
                        . "`mr_date` <= '".$end_date."' AND "
                        . "`mr_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria." ";
                
                $sql .= " UNION SELECT DISTINCT mdt_date AS mr_date FROM `tblusersmdt` "
                        . "WHERE `user_id` = '".$user_id."' AND "
                        . "`bms_entry_type` = 'trigger' AND "
                        . "`bms_type` = 'mr' AND "
                        . "`mdt_date` >= '".$start_date."' AND "
                        . "`mdt_date` <= '".$end_date."' AND "
                        . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY mr_date DESC ";
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
                        /*
                        $sql2 = "SELECT tumr.* FROM `tblusersmr` AS tumr "
                                . "LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id "
                                . "WHERE tumr.user_id = '".$user_id."' AND "
                                . "tumr.mr_date = '".$arr_mr_date[$i]."' AND "
                                . "tumr.mr_old_data = '0'  AND "
                                . "tmr.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tumr.user_mr_id ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT tumr.user_mr_id AS user_mr_id , tumr.mr_date AS mr_date , tumr.selected_mr_id AS selected_mr_id , "
                                . "tumr.scale AS scale , tumr.remarks AS remarks , tumr.my_target AS my_target , tumr.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tblusersmr` AS tumr "
                                . "LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id "
                                . "WHERE tumr.user_id = '".$user_id."' AND "
                                . "tumr.mr_date = '".$arr_mr_date[$i]."' AND "
                                . "tumr.mr_old_data = '0' AND "
                                . "tmr.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_mr_id ,  tumdt.mdt_date AS mr_date , tumdt.bms_id AS selected_mr_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tblmyrelations` AS tmr ON tumdt.bms_id = tmr.mr_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'mr' AND "
                                . "tumdt.mdt_date = '".$arr_mr_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "tmr.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_mr_id ASC ";
                    }
                    elseif($permission_type == '0')
                    {
                        /*
                        $sql2 = "SELECT tumr.* FROM `tblusersmr` AS tumr "
                                . "LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id "
                                . "WHERE tumr.user_id = '".$user_id."' AND "
                                . "tumr.mr_date = '".$arr_mr_date[$i]."' AND "
                                . "tumr.mr_old_data = '0'  AND "
                                . "tmr.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tumr.user_mr_id ASC ";
                         * 
                         * 
                         */
                        $sql2 = "SELECT tumr.user_mr_id AS user_mr_id , tumr.mr_date AS mr_date , tumr.selected_mr_id AS selected_mr_id , "
                                . "tumr.scale AS scale , tumr.remarks AS remarks , tumr.my_target AS my_target , tumr.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tblusersmr` AS tumr "
                                . "LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id "
                                . "WHERE tumr.user_id = '".$user_id."' AND "
                                . "tumr.mr_date = '".$arr_mr_date[$i]."' AND "
                                . "tumr.mr_old_data = '0' AND "
                                . "tmr.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_mr_id ,  tumdt.mdt_date AS mr_date , tumdt.bms_id AS selected_mr_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tblmyrelations` AS tmr ON tumdt.bms_id = tmr.mr_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'mr' AND "
                                . "tumdt.mdt_date = '".$arr_mr_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "tmr.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_mr_id ASC ";
                    }
                    else
                    {
                        /*
                        $sql2 = "SELECT * FROM `tblusersmr` WHERE "
                                . "`user_id` = '".$user_id."' AND "
                                . "`mr_date` = '".$arr_mr_date[$i]."' AND "
                                . "`mr_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY `user_mr_id` ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT user_mr_id,mr_date,selected_mr_id,scale,remarks,my_target,adviser_target , 'emo' AS 'data_source' FROM `tblusersmr` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "mr_date = '".$arr_mr_date[$i]."' AND "
                                . "mr_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ";

                        $sql2 .= " UNION SELECT user_mdt_id AS user_mr_id , mdt_date AS mr_date , bms_id AS selected_mr_id , "
                                . "scale AS scale , remarks AS remarks , my_target AS my_target , adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "`bms_entry_type` = 'trigger' AND "
                                . "`bms_type` = 'mr' AND "
                                . "`mdt_date` = '".$arr_mr_date[$i]."' AND "
                                . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_mr_id ASC ";
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
                                $arr_mr_records[$arr_mr_date[$i]]['my_target'][$j] = stripslashes($row2['my_target']);
                                $arr_mr_records[$arr_mr_date[$i]]['adviser_target'][$j] = stripslashes($row2['adviser_target']);
                                $arr_mr_records[$arr_mr_date[$i]]['data_source'][$j] = stripslashes($row2['data_source']);
                                $j++;
                            }	
                        }
                    }
                }
            }
        }
        
        if($report_module == '' || $report_module == 'mle_report' || $report_module == '20')
        {
            if($report_module == 'mle_report')
            {
                if($module_keyword != '')
                {
                    $sql_str_report_module = " AND `selected_mle_id` = '".$module_keyword."' ";
                    $sql_str_report_module2 = " AND tumle.selected_mle_id = '".$module_keyword."' ";
                    $sql_str_report_module3 = " AND `bms_id` = '".$module_keyword."' ";
                }
                else
                {
                    $sql_str_report_module = '';
                    $sql_str_report_module2 = '';
                    $sql_str_report_module3 = '';
                }
            }
            else
            {
                $sql_str_report_module = '';
                $sql_str_report_module2 = '';
                $sql_str_report_module3 = '';
            }
            
            if($module_criteria == '1')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumle.my_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumle.my_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumle.my_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumle.my_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumle.my_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`my_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tumle.my_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tumle.my_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '2')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumle.adviser_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumle.adviser_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumle.adviser_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumle.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tumle.adviser_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`adviser_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tumle.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tumle.adviser_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '7')
            {
                if($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(mle_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tumle.mle_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(mle_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(mle_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tumle.mle_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(tumle.mle_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(mdt_date) <= '".$end_criteria_scale_value."' ";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                    $sql_str_report_module_criteria3 = "";
                }
            }
            else
            {
                $sql_str_report_module_criteria = "";
                $sql_str_report_module_criteria2 = "";
                $sql_str_report_module_criteria3 = "";
            }
	
            if($permission_type == '1')
            {
                $sql = "SELECT DISTINCT tumle.mle_date AS mle_date FROM `tblusersmle` AS tumle "
                        . "LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id "
                        . "WHERE tumle.user_id = '".$user_id."' AND "
                        . "tumle.mle_date >= '".$start_date."' AND "
                        . "tumle.mle_date <= '".$end_date."' AND "
                        . "tumle.mle_old_data = '0'  AND "
                        . "tmle.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ";
                
                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS mle_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tblmajorlifeevents` AS tmle ON tumdt.bms_id = tmle.sleep_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'mle' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "tmle.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY mle_date DESC ";
            }
            elseif($permission_type == '0')
            {
                $sql = "SELECT DISTINCT tumle.mle_date AS mle_date FROM `tblusersmle` AS tumle "
                        . "LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id "
                        . "WHERE tumle.user_id = '".$user_id."' AND "
                        . "tumle.mle_date >= '".$start_date."' AND "
                        . "tumle.mle_date <= '".$end_date."' AND "
                        . "tumle.mle_old_data = '0'  AND "
                        . "tmle.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ";
                
                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS mle_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tblmajorlifeevents` AS tmle ON tumdt.bms_id = tmle.sleep_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'mle' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "tmle.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY mle_date DESC ";
            }
            else
            {
                $sql = "SELECT DISTINCT `mle_date` FROM `tblusersmle` WHERE "
                        . "`user_id` = '".$user_id."' AND "
                        . "`mle_date` >= '".$start_date."' AND "
                        . "`mle_date` <= '".$end_date."' AND "
                        . "`mle_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria." ";
                
                $sql .= " UNION SELECT DISTINCT mdt_date AS mle_date FROM `tblusersmdt` "
                        . "WHERE `user_id` = '".$user_id."' AND "
                        . "`bms_entry_type` = 'trigger' AND "
                        . "`bms_type` = 'mle' AND "
                        . "`mdt_date` >= '".$start_date."' AND "
                        . "`mdt_date` <= '".$end_date."' AND "
                        . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY mle_date DESC ";
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
                        /*
                        $sql2 = "SELECT tumle.* FROM `tblusersmle` AS tumle "
                                . "LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id "
                                . "WHERE tumle.user_id = '".$user_id."' AND "
                                . "tumle.mle_date = '".$arr_mle_date[$i]."' AND "
                                . "tumle.mle_old_data = '0'  AND "
                                . "tmle.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tumle.user_mle_id ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT tumle.user_mle_id AS user_mle_id , tumle.mle_date AS mle_date , tumle.selected_mle_id AS selected_mle_id , "
                                . "tumle.scale AS scale , tumle.remarks AS remarks , tumle.my_target AS my_target , tumle.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tblusersmle` AS tumle "
                                . "LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id "
                                . "WHERE tumle.user_id = '".$user_id."' AND "
                                . "tumle.mle_date = '".$arr_mle_date[$i]."' AND "
                                . "tumle.mle_old_data = '0' AND "
                                . "tmle.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_mle_id ,  tumdt.mdt_date AS mle_date , tumdt.bms_id AS selected_mle_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tblmajorlifeevents` AS tmle ON tumdt.bms_id = tmle.mle_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'mle' AND "
                                . "tumdt.mdt_date = '".$arr_mle_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "tmle.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_mle_id ASC ";
                    }
                    elseif($permission_type == '0')
                    {
                        /*
                        $sql2 = "SELECT tumle.* FROM `tblusersmle` AS tumle "
                                . "LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id "
                                . "WHERE tumle.user_id = '".$user_id."' AND "
                                . "tumle.mle_date = '".$arr_mle_date[$i]."' AND "
                                . "tumle.mle_old_data = '0'  AND "
                                . "tmle.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tumle.user_mle_id ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT tumle.user_mle_id AS user_mle_id , tumle.mle_date AS mle_date , tumle.selected_mle_id AS selected_mle_id , "
                                . "tumle.scale AS scale , tumle.remarks AS remarks , tumle.my_target AS my_target , tumle.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tblusersmle` AS tumle "
                                . "LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id "
                                . "WHERE tumle.user_id = '".$user_id."' AND "
                                . "tumle.mle_date = '".$arr_mle_date[$i]."' AND "
                                . "tumle.mle_old_data = '0' AND "
                                . "tmle.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_mle_id ,  tumdt.mdt_date AS mle_date , tumdt.bms_id AS selected_mle_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tblmajorlifeevents` AS tmle ON tumdt.bms_id = tmle.mle_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'mle' AND "
                                . "tumdt.mdt_date = '".$arr_mle_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "tmle.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_mle_id ASC ";
                    }
                    else
                    {
                        /*
                        $sql2 = "SELECT * FROM `tblusersmle` WHERE "
                                . "`user_id` = '".$user_id."' AND "
                                . "`mle_date` = '".$arr_mle_date[$i]."' AND "
                                . "`mle_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY `user_mle_id` ASC ";
                         * 
                         * 
                         */
                        
                        $sql2 = "SELECT user_mle_id,mle_date,selected_mle_id,scale,remarks,my_target,adviser_target , 'emo' AS 'data_source' FROM `tblusersmle` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "mle_date = '".$arr_mle_date[$i]."' AND "
                                . "mle_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ";

                        $sql2 .= " UNION SELECT user_mdt_id AS user_mle_id , mdt_date AS mle_date , bms_id AS selected_mle_id , "
                                . "scale AS scale , remarks AS remarks , my_target AS my_target , adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "`bms_entry_type` = 'trigger' AND "
                                . "`bms_type` = 'mle' AND "
                                . "`mdt_date` = '".$arr_mle_date[$i]."' AND "
                                . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_mle_id ASC ";
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
                                $arr_mle_records[$arr_mle_date[$i]]['my_target'][$j] = stripslashes($row2['my_target']);
                                $arr_mle_records[$arr_mle_date[$i]]['adviser_target'][$j] = stripslashes($row2['adviser_target']);
                                $arr_mle_records[$arr_mle_date[$i]]['data_source'][$j] = stripslashes($row2['data_source']);
                                $j++;
                            }	
                        }
                    }
                }
            }
        } 
        
        if($report_module == '' || $report_module == 'adct_report' || $report_module == '21')
        {
            if($report_module == 'adct_report')
            {
                if($module_keyword != '')
                {
                    $sql_str_report_module = " AND `selected_adct_id` = '".$module_keyword."' ";
                    $sql_str_report_module2 = " AND tuadc.selected_adct_id = '".$module_keyword."' ";
                    $sql_str_report_module3 = " AND `bms_id` = '".$module_keyword."' ";
                }
                else
                {
                    $sql_str_report_module = '';
                    $sql_str_report_module2 = '';
                    $sql_str_report_module3 = '';
                }
            }
            else
            {
                $sql_str_report_module = '';
                $sql_str_report_module2 = '';
                $sql_str_report_module3 = '';
            }
            
            if($module_criteria == '1')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuadc.my_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuadc.my_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuadc.my_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuadc.my_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuadc.my_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`my_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tuadc.my_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tuadc.my_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '2')
            {
                $sql_str_report_module_criteria3 = '';
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuadc.adviser_target AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuadc.adviser_target AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuadc.adviser_target AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuadc.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND CAST(tuadc.adviser_target AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`adviser_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                    $sql_str_report_module_criteria2 = " AND CAST(tuadc.adviser_target AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tuadc.adviser_target AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '7')
            {
                if($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(adct_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tuadc.adct_date) = '".$start_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(adct_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(adct_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tuadc.adct_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(tuadc.adct_date) <= '".$end_criteria_scale_value."' ";
                    $sql_str_report_module_criteria3 = " AND DAYOFWEEK(mdt_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(mdt_date) <= '".$end_criteria_scale_value."' ";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                    $sql_str_report_module_criteria3 = "";
                }
            }
            else
            {
                $sql_str_report_module_criteria = "";
                $sql_str_report_module_criteria2 = "";
                $sql_str_report_module_criteria3 = "";
            }
	
            if($permission_type == '1')
            {
                $sql = "SELECT DISTINCT tuadc.adct_date AS adct_date FROM `tblusersadct` AS tuadc "
                        . "LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id "
                        . "WHERE tuadc.user_id = '".$user_id."' AND "
                        . "tuadc.adct_date >= '".$start_date."' AND "
                        . "tuadc.adct_date <= '".$end_date."' AND "
                        . "tuadc.adct_old_data = '0'  AND "
                        . "tadc.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";
                
                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS adct_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tbladdictions` AS tadc ON tumdt.bms_id = tadc.adct_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'adct' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "tadc.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY adct_date DESC ";
            }
            elseif($permission_type == '0')
            {
                $sql = "SELECT DISTINCT tuadc.adct_date AS adct_date FROM `tblusersadct` AS tuadc "
                        . "LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id "
                        . "WHERE tuadc.user_id = '".$user_id."' AND "
                        . "tuadc.adct_date >= '".$start_date."' AND "
                        . "tuadc.adct_date <= '".$end_date."' AND "
                        . "tuadc.adct_old_data = '0'  AND "
                        . "tadc.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";
                
                $sql .= " UNION SELECT DISTINCT tumdt.mdt_date AS adct_date FROM `tblusersmdt` AS tumdt "
                        . "LEFT JOIN `tbladdictions` AS tadc ON tumdt.bms_id = tadc.adct_id "
                        . "WHERE tumdt.user_id = '".$user_id."' AND "
                        . "tumdt.bms_entry_type = 'trigger' AND "
                        . "tumdt.bms_type = 'adct' AND "
                        . "tumdt.mdt_date >= '".$start_date."' AND "
                        . "tumdt.mdt_date <= '".$end_date."' AND "
                        . "tumdt.mdt_old_data = '0' AND "
                        . "tadc.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY adct_date DESC ";
            }
            else
            {
                $sql = "SELECT DISTINCT `adct_date` FROM `tblusersadct` WHERE "
                        . "`user_id` = '".$user_id."' AND "
                        . "`adct_date` >= '".$start_date."' AND "
                        . "`adct_date` <= '".$end_date."' AND "
                        . "`adct_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ";
                
                $sql .= " UNION SELECT DISTINCT mdt_date AS adct_date FROM `tblusersmdt` "
                        . "WHERE `user_id` = '".$user_id."' AND "
                        . "`bms_entry_type` = 'trigger' AND "
                        . "`bms_type` = 'adct' AND "
                        . "`mdt_date` >= '".$start_date."' AND "
                        . "`mdt_date` <= '".$end_date."' AND "
                        . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY adct_date DESC ";
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
                        /*
                        $sql2 = "SELECT tuadc.* FROM `tblusersadct` AS tuadc "
                                . "LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id "
                                . "WHERE tuadc.user_id = '".$user_id."' AND "
                                . "tuadc.adct_date = '".$arr_adct_date[$i]."' AND "
                                . "tadc.practitioner_id = '".$pro_user_id."' AND "
                                . "tuadc.adct_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ORDER BY tuadc.user_adct_id ASC ";
                         * 
                         * 
                         */
                        
                        $sql2 = "SELECT tuadc.user_adct_id AS user_adct_id , tuadc.adct_date AS adct_date , tuadc.selected_adct_id AS selected_adct_id , "
                                . "tuadc.scale AS scale , tuadc.remarks AS remarks , tuadc.my_target AS my_target , tuadc.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tblusersadct` AS tuadc "
                                . "LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id "
                                . "WHERE tuadc.user_id = '".$user_id."' AND "
                                . "tuadc.adct_date = '".$arr_adct_date[$i]."' AND "
                                . "tuadc.adct_old_data = '0' AND "
                                . "tadc.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_adct_id ,  tumdt.mdt_date AS adct_date , tumdt.bms_id AS selected_adct_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tbladdictions` AS tadc ON tumdt.bms_id = tadc.adct_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'adct' AND "
                                . "tumdt.mdt_date = '".$arr_adct_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "tadc.practitioner_id = '".$pro_user_id."'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_adct_id ASC ";
                    }
                    elseif($permission_type == '0')
                    {
                        /*
                        $sql2 = "SELECT tuadc.* FROM `tblusersadct` AS tuadc "
                                . "LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id "
                                . "WHERE tuadc.user_id = '".$user_id."' AND "
                                . "tuadc.adct_date = '".$arr_adct_date[$i]."' AND "
                                . "tadc.practitioner_id = '0' AND "
                                . "tuadc.adct_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tuadc.user_adct_id ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT tuadc.user_adct_id AS user_adct_id , tuadc.adct_date AS adct_date , tuadc.selected_adct_id AS selected_adct_id , "
                                . "tuadc.scale AS scale , tuadc.remarks AS remarks , tuadc.my_target AS my_target , tuadc.adviser_target AS adviser_target , 'emo' AS 'data_source'  FROM `tblusersadct` AS tuadc "
                                . "LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id "
                                . "WHERE tuadc.user_id = '".$user_id."' AND "
                                . "tuadc.adct_date = '".$arr_adct_date[$i]."' AND "
                                . "tuadc.adct_old_data = '0' AND "
                                . "tadc.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2."  ";

                        $sql2 .= " UNION SELECT tumdt.user_mdt_id AS user_adct_id ,  tumdt.mdt_date AS adct_date , tumdt.bms_id AS selected_adct_id , "
                                . "tumdt.scale AS scale , tumdt.remarks AS remarks , tumdt.my_target AS my_target , tumdt.adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` AS tumdt "
                                . "LEFT JOIN `tbladdictions` AS tadc ON tumdt.bms_id = tadc.adct_id "
                                . "WHERE tumdt.user_id = '".$user_id."' AND "
                                . "tumdt.bms_entry_type = 'trigger' AND "
                                . "tumdt.bms_type = 'adct' AND "
                                . "tumdt.mdt_date = '".$arr_adct_date[$i]."' AND "
                                . "tumdt.mdt_old_data = '0' AND "
                                . "tadc.practitioner_id = '0'  ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_adct_id ASC ";
                    }
                    else
                    {
                        /*
                        $sql2 = "SELECT * FROM `tblusersadct` WHERE "
                                . "`user_id` = '".$user_id."' AND "
                                . "`adct_date` = '".$arr_adct_date[$i]."' AND "
                                . "`adct_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY `user_adct_id` ASC ";
                         * 
                         */
                        
                        $sql2 = "SELECT user_adct_id,adct_date,selected_adct_id,scale,remarks,my_target,adviser_target , 'emo' AS 'data_source' FROM `tblusersadct` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "adct_date = '".$arr_adct_date[$i]."' AND "
                                . "adct_old_data = '0' ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ";

                        $sql2 .= " UNION SELECT user_mdt_id AS user_adct_id , mdt_date AS adct_date , bms_id AS selected_adct_id , "
                                . "scale AS scale , remarks AS remarks , my_target AS my_target , adviser_target AS adviser_target , 'mdt' AS 'data_source' FROM `tblusersmdt` "
                                . "WHERE `user_id` = '".$user_id."' AND "
                                . "`bms_entry_type` = 'trigger' AND "
                                . "`bms_type` = 'adct' AND "
                                . "`mdt_date` = '".$arr_adct_date[$i]."' AND "
                                . "`mdt_old_data` = '0' ".$sql_str_scale." ".$sql_str_report_module3." ".$sql_str_report_module_criteria3." ORDER BY user_adct_id ASC ";
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
                                $arr_adct_records[$arr_adct_date[$i]]['my_target'][$j] = stripslashes($row2['my_target']);
                                $arr_adct_records[$arr_adct_date[$i]]['adviser_target'][$j] = stripslashes($row2['adviser_target']);
                                $arr_adct_records[$arr_adct_date[$i]]['data_source'][$j] = stripslashes($row2['data_source']);
                                $j++;
                            }	
                        }
                    }
                }
            }
	}
        
        if($report_module == '' || $report_module == 'bps_report' || $report_module == '22')
        {
            if($report_module == 'bps_report')
            {
                if($module_keyword != '')
                {
                    $sql_str_report_module = " AND FIND_IN_SET('".$module_keyword."', bms_id) > 0 ";
                }
                else
                {
                    $sql_str_report_module = '';
                }
            }
            else
            {
                $sql_str_report_module = '';
            }
            
            if($module_criteria == '7')
            {
                if($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(bps_date) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(bps_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(bps_date) <= '".$end_criteria_scale_value."' ";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                }
            }
	            
            $sql = "SELECT DISTINCT `bps_date` FROM `tblusersbps` WHERE "
                    . "`user_id` = '".$user_id."' AND "
                    . "`bps_date` >= '".$start_date."' AND "
                    . "`bps_date` <= '".$end_date."' AND "
                    . "`bps_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `bps_date` DESC ";
            //echo "<br>Testkk sql = ".$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                while($row = mysql_fetch_array($result))
                {
                    array_push($arr_bps_date , $row['bps_date']);
                }
            }		

            if(count($arr_bps_date) > 0)
            {		
                    for($i=0;$i<count($arr_bps_date);$i++)
                    {	
                            $sql2 = "SELECT * FROM `tblusersbps` WHERE "
                                    . "`user_id` = '".$user_id."' AND "
                                    . "`bps_date` = '".$arr_bps_date[$i]."' AND "
                                    . "`bps_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ORDER BY `user_bps_id` ASC ";
                            //echo "<br>".$sql2;
                            $result2 = mysql_query($sql2,$link);
                            if( ($result2) && (mysql_num_rows($result2) > 0) )
                            {
                                    $j=0;
                                    while($row2 = mysql_fetch_array($result2))
                                    {
                                            if($row2['bms_id'] != '')
                                            {
                                                    $bps_return = true;
                                                    $arr_bps_records[$arr_bps_date[$i]]['bp_id'][$j] = $row2['bp_id'];
                                                    $arr_bps_records[$arr_bps_date[$i]]['bms_id'][$j] = $row2['bms_id'];
                                                    $arr_bps_records[$arr_bps_date[$i]]['scale'][$j] = $row2['scale'];
                                                    $arr_bps_records[$arr_bps_date[$i]]['spotx'][$j] = $row2['spotx'];
                                                    $arr_bps_records[$arr_bps_date[$i]]['spoty'][$j] = $row2['spoty'];
                                                    $arr_bps_records[$arr_bps_date[$i]]['bps_image'][$j] = $row2['bps_image'];
                                                    $j++;
                                            }	
                                    }
                            }
                    }
            }
	}
        
        if($report_module == '' || $report_module == 'bes_report' || $report_module == '23')
        {
            if($report_module == 'bes_report')
            {
                if($module_keyword != '')
                {
                    $sql_str_report_module = " AND FIND_IN_SET('".$module_keyword."', bms_id) > 0 ";
                }
                else
                {
                    $sql_str_report_module = '';
                }
            }
            else
            {
                $sql_str_report_module = '';
            }
            
            if($module_criteria == '1')
            {
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`my_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`my_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '2')
            {
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`adviser_target` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`adviser_target` AS SIGNED) <= '".$end_criteria_scale_value."'";
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
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(bes_date) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(bes_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(bes_date) <= '".$end_criteria_scale_value."' ";
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
	
            $sql = "SELECT DISTINCT `bes_date` FROM `tblusersbes` WHERE "
                    . "`user_id` = '".$user_id."' AND "
                    . "`bes_date` >= '".$start_date."' AND "
                    . "`bes_date` <= '".$end_date."' AND "
                    . "`bes_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `bes_date` DESC ";
            //echo "<br>Testkk sql = ".$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                while($row = mysql_fetch_array($result))
                {
                    array_push($arr_bes_date , $row['bes_date']);
                }
            }		

            if(count($arr_bes_date) > 0)
            {		
                for($i=0;$i<count($arr_bes_date);$i++)
                {	
                    $sql2 = "SELECT * FROM `tblusersbes` WHERE "
                            . "`user_id` = '".$user_id."' AND "
                            . "`bes_date` = '".$arr_bes_date[$i]."' AND "
                            . "`bes_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY `user_bes_id` ASC ";
                    //echo "<br>".$sql2;
                    $result2 = mysql_query($sql2,$link);
                    if( ($result2) && (mysql_num_rows($result2) > 0) )
                    {
                        $j=0;
                        while($row2 = mysql_fetch_array($result2))
                        {
                            if($row2['bms_id'] != '0')
                            {
                                $bes_return = true;
                                $arr_bes_records[$arr_bes_date[$i]]['bms_id'][$j] = $row2['bms_id'];
                                $arr_bes_records[$arr_bes_date[$i]]['scale'][$j] = $row2['scale'];
                                $arr_bes_records[$arr_bes_date[$i]]['scale_image'][$j] = getScaleImage($row2['scale']);
                                $arr_bes_records[$arr_bes_date[$i]]['responce'][$j] = stripslashes($row2['remarks']);
                                $arr_bes_records[$arr_bes_date[$i]]['my_target'][$j] = stripslashes($row2['my_target']);
                                $arr_bes_records[$arr_bes_date[$i]]['adviser_target'][$j] = stripslashes($row2['adviser_target']);
                                $arr_bes_records[$arr_bes_date[$i]]['bes_time'][$j] = stripslashes($row2['bes_time']);
                                $arr_bes_records[$arr_bes_date[$i]]['bes_duration'][$j] = stripslashes($row2['bes_duration']);
                                $j++;
                            }	
                        }
                    }
                }
            }
	}
        
        if($report_module == '' || $report_module == 'mdt_report' || $report_module == '24')
        {
            if($module_keyword != '')
                {
                    $tmp_md_ct = explode('_',$module_keyword);
                    $module_keyword = $tmp_md_ct[1];
                }
            
            
            if($module_criteria == '9')
            {
                if($trigger_criteria != '')
                {
                    $tmp_tg_ct = explode('_',$trigger_criteria);
                    $trigger_criteria = $tmp_tg_ct[1];
                }
            }
            else
            {
                $trigger_criteria = '';
            }
            
            
            if($module_criteria == '7')
            {
                if($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(mdt_date) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND DAYOFWEEK(mdt_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(mdt_date) <= '".$end_criteria_scale_value."' ";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                }
            }
            elseif($module_criteria == '3')
            {
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND CAST(`mdt_duration` AS SIGNED) < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND CAST(`mdt_duration` AS SIGNED) > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND CAST(`mdt_duration` AS SIGNED) <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND CAST(`mdt_duration` AS SIGNED) >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND CAST(`mdt_duration` AS SIGNED) = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND CAST(`mdt_duration` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`mins` AS SIGNED) <= '".$end_criteria_scale_value."'";
                }
                else
                {
                    $sql_str_report_module_criteria = "";
                    $sql_str_report_module_criteria2 = "";
                }
            }
            elseif($module_criteria == '4')
            {
                if($criteria_scale_range == '1')
                {
                    $sql_str_report_module_criteria = " AND `mdt_time` < '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '2')
                {
                    $sql_str_report_module_criteria = " AND `mdt_time` > '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '3')
                {
                    $sql_str_report_module_criteria = " AND `mdt_time` <= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '4')
                {
                    $sql_str_report_module_criteria = " AND `mdt_time` >= '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '5')
                {
                    $sql_str_report_module_criteria = " AND `mdt_time` = '".$start_criteria_scale_value."' ";
                }
                elseif($criteria_scale_range == '6')
                {
                    $sql_str_report_module_criteria = " AND `mdt_time` >= '".$start_criteria_scale_value."' AND `mdt_time` <= '".$end_criteria_scale_value."'";
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
            
            
            
            if($module_keyword == '' && $scale_range == '' && $module_criteria == '')
            {
                $sql_str_scale = '';
                $sql_str_report_module = '';
                $sql_str_report_module_criteria = '';
                
                $sql = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE "
                    . "`user_id` = '".$user_id."' AND "
                    . "`mdt_date` >= '".$start_date."' AND "
                    . "`mdt_date` <= '".$end_date."' AND "
                    . "`mdt_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `mdt_date` DESC ";
                //echo "<br>Testkk sql = ".$sql;
                $result = mysql_query($sql,$link);
                if( ($result) && (mysql_num_rows($result) > 0) )
                {
                    while($row = mysql_fetch_array($result))
                    {
                        array_push($arr_mdt_date , $row['mdt_date']);
                    }
                }	
            }
            elseif($module_keyword == '' && $scale_range == '' && $module_criteria != '')
            {
                $sql_str_scale = '';
                $sql_str_report_module = '';
                
                if($module_criteria == '9')
                {
                    if($criteria_scale_range == '1')
                    {
                        $sql_str_report_module_criteria = " AND ( CAST(`scale` AS SIGNED) < '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                    }
                    elseif($criteria_scale_range == '2')
                    {
                        $sql_str_report_module_criteria = " AND ( CAST(`scale` AS SIGNED) > '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                    }
                    elseif($criteria_scale_range == '3')
                    {
                        $sql_str_report_module_criteria = " AND ( CAST(`scale` AS SIGNED) <= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                    }
                    elseif($criteria_scale_range == '4')
                    {
                        $sql_str_report_module_criteria = " AND ( CAST(`scale` AS SIGNED) >= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                    }
                    elseif($criteria_scale_range == '5')
                    {
                        $sql_str_report_module_criteria = " AND ( CAST(`scale` AS SIGNED) = '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                    }
                    elseif($criteria_scale_range == '6')
                    {
                        $min_value = min($start_criteria_scale_value,$end_criteria_scale_value);
                        $max_value = max($start_criteria_scale_value,$end_criteria_scale_value);
                        $sql_str_report_module_criteria = " AND ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'trigger' ) ";
                    }
                    else
                    {
                        $sql_str_report_module_criteria = "";
                    }
                    
                    if($trigger_criteria != '')
                    {
                        $sql_str_report_module = " AND `bms_id` = '".$trigger_criteria."' AND `bms_entry_type` = 'trigger' ";
                    }
                    else
                    {
                        $sql_str_report_module = '';
                    }
                }
                
                $sql = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE "
                    . "`user_id` = '".$user_id."' AND "
                    . "`mdt_date` >= '".$start_date."' AND "
                    . "`mdt_date` <= '".$end_date."' AND "
                    . "`mdt_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `mdt_date` DESC ";
                //echo "<br>Testkk sql = ".$sql;
                $result = mysql_query($sql,$link);
                if( ($result) && (mysql_num_rows($result) > 0) )
                {
                    while($row = mysql_fetch_array($result))
                    {
                        array_push($arr_mdt_date , $row['mdt_date']);
                    }
                }	
                
            }
            elseif($module_keyword == '' && $scale_range != '' && $module_criteria == '')
            {
                //echo'<br>3333333333333333333';
                $sql_str_report_module = '';
                $sql_str_report_module_criteria = '';
                if($scale_range == '1')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) < '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '2')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) > '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '3')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) <= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '4')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) >= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '5')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) = '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '6')
                {
                    $min_value = min($start_scale_value,$end_scale_value);
                    $max_value = max($start_scale_value,$end_scale_value);
                    $sql_str_scale = " AND ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'situation' ) ";
                }
                else
                {
                    $sql_str_scale = "";
                }
                
                $sql = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE "
                    . "`user_id` = '".$user_id."' AND "
                    . "`mdt_date` >= '".$start_date."' AND "
                    . "`mdt_date` <= '".$end_date."' AND "
                    . "`mdt_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `mdt_date` DESC ";
                //echo "<br>Testkk sql = ".$sql;
                $result = mysql_query($sql,$link);
                if( ($result) && (mysql_num_rows($result) > 0) )
                {
                    while($row = mysql_fetch_array($result))
                    {
                        array_push($arr_mdt_date , $row['mdt_date']);
                    }
                }
                
                
            }
            elseif($module_keyword == '' && $scale_range != '' && $module_criteria != '')
            {
                //echo'<br>444444444444444';
                $sql_str_report_module = '';
                
                if($module_criteria == '9')
                {
                    $sql_str_report_module_criteria = '';
                    
                    if($trigger_criteria != '')
                    {
                        $sql_str_report_module = " AND `bms_id` = '".$trigger_criteria."' AND `bms_entry_type` = 'trigger' ";
                        
                        if($criteria_scale_range == '1')
                        {
                            $sql_str_report_module_criteria = " ( CAST(`scale` AS SIGNED) < '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                        }
                        elseif($criteria_scale_range == '2')
                        {
                            $sql_str_report_module_criteria = " ( CAST(`scale` AS SIGNED) > '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                        }
                        elseif($criteria_scale_range == '3')
                        {
                            $sql_str_report_module_criteria = " ( CAST(`scale` AS SIGNED) <= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                        }
                        elseif($criteria_scale_range == '4')
                        {
                            $sql_str_report_module_criteria = " ( CAST(`scale` AS SIGNED) >= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                        }
                        elseif($criteria_scale_range == '5')
                        {
                            $sql_str_report_module_criteria = " ( CAST(`scale` AS SIGNED) = '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                        }
                        elseif($criteria_scale_range == '6')
                        {
                            $min_value = min($start_criteria_scale_value,$end_criteria_scale_value);
                            $max_value = max($start_criteria_scale_value,$end_criteria_scale_value);
                            $sql_str_report_module_criteria = " ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'trigger' ) ";
                        }
                        else
                        {
                            $sql_str_report_module_criteria = "";
                        }
                        
                        if($sql_str_report_module_criteria == "")
                        {

                        }
                        else
                        {
                            $sql_str_report_module_criteria = " AND ".$sql_str_report_module_criteria;

                        }
                        
                        $sql_str_scale = "";
                        
                        
                        $sql = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE "
                            . "`user_id` = '".$user_id."' AND "
                            . "`mdt_date` >= '".$start_date."' AND "
                            . "`mdt_date` <= '".$end_date."' AND "
                            . "`mdt_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `mdt_date` DESC ";
                            //echo "<br>Testkk sql = ".$sql;
                            $result = mysql_query($sql,$link);
                            if( ($result) && (mysql_num_rows($result) > 0) )
                            {
                                while($row = mysql_fetch_array($result))
                                {
                                    array_push($arr_mdt_date , $row['mdt_date']);
                                }
                            }
                        
                    }
                    else
                    {
                        $sql_str_report_module = '';
                        
                        if($scale_range == '1')
                        {
                            $sql_str_scale = " (  CAST(`scale` AS SIGNED) < '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                        }
                        elseif($scale_range == '2')
                        {
                            $sql_str_scale = " (  CAST(`scale` AS SIGNED) > '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                        }
                        elseif($scale_range == '3')
                        {
                            $sql_str_scale = " (  CAST(`scale` AS SIGNED) <= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                        }
                        elseif($scale_range == '4')
                        {
                            $sql_str_scale = " (  CAST(`scale` AS SIGNED) >= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                        }
                        elseif($scale_range == '5')
                        {
                            $sql_str_scale = " (  CAST(`scale` AS SIGNED) = '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                        }
                        elseif($scale_range == '6')
                        {
                            $min_value = min($start_scale_value,$end_scale_value);
                            $max_value = max($start_scale_value,$end_scale_value);
                            $sql_str_scale = " ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'situation' ) ";
                        }
                        else
                        {
                            $sql_str_scale = "";
                        }
                        
                        if($criteria_scale_range == '1')
                        {
                            $sql_str_report_module_criteria = " ( CAST(`scale` AS SIGNED) < '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                        }
                        elseif($criteria_scale_range == '2')
                        {
                            $sql_str_report_module_criteria = " ( CAST(`scale` AS SIGNED) > '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                        }
                        elseif($criteria_scale_range == '3')
                        {
                            $sql_str_report_module_criteria = " ( CAST(`scale` AS SIGNED) <= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                        }
                        elseif($criteria_scale_range == '4')
                        {
                            $sql_str_report_module_criteria = " ( CAST(`scale` AS SIGNED) >= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                        }
                        elseif($criteria_scale_range == '5')
                        {
                            $sql_str_report_module_criteria = " ( CAST(`scale` AS SIGNED) = '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                        }
                        elseif($criteria_scale_range == '6')
                        {
                            $min_value = min($start_criteria_scale_value,$end_criteria_scale_value);
                            $max_value = max($start_criteria_scale_value,$end_criteria_scale_value);
                            $sql_str_report_module_criteria = " ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'trigger' ) ";
                        }
                        else
                        {
                            $sql_str_report_module_criteria = "";
                        }
                        
                        if($sql_str_report_module_criteria == "")
                        {

                        }
                        else
                        {
                            $sql_str_report_module_criteria = " AND ".$sql_str_report_module_criteria;

                        }
                        
                        if($sql_str_scale == "")
                        {
                            
                        }
                        else
                        {
                            $sql_str_scale = " AND ".$sql_str_scale;
                        }
                        
                        //$sql_str_scale2 = " AND ( ".$sql_str_report_module_criteria2." OR ".$sql_str_scale2." )";
                        $arr_mdt_s_date = array();
                        $sql_s = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE "
                            . "`user_id` = '".$user_id."' AND "
                            . "`mdt_date` >= '".$start_date."' AND "
                            . "`mdt_date` <= '".$end_date."' AND "
                            . "`mdt_old_data` = '0'  ".$sql_str_scale." ORDER BY `mdt_date` DESC ";
                        //echo "<br>Testkk sql = ".$sql_s;
                        $result = mysql_query($sql_s,$link);
                        if( ($result) && (mysql_num_rows($result) > 0) )
                        {
                            while($row = mysql_fetch_array($result))
                            {
                                array_push($arr_mdt_s_date , $row['mdt_date']);
                            }
                        }
                        
                        $arr_mdt_t_date = array();
                        $sql_t = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE "
                            . "`user_id` = '".$user_id."' AND "
                            . "`mdt_date` >= '".$start_date."' AND "
                            . "`mdt_date` <= '".$end_date."' AND "
                            . "`mdt_old_data` = '0'  ".$sql_str_report_module_criteria."  ORDER BY `mdt_date` DESC ";
                        //echo "<br>Testkk sql = ".$sql_t;
                        $result = mysql_query($sql_t,$link);
                        if( ($result) && (mysql_num_rows($result) > 0) )
                        {
                            while($row = mysql_fetch_array($result))
                            {
                                array_push($arr_mdt_t_date , $row['mdt_date']);
                            }
                        }
                        
                        $sql_str_scale = '';
                        $sql_str_report_module_criteria = '';
                        
                        $arr_mdt_date = array_intersect($arr_mdt_s_date,$arr_mdt_t_date);
                        //echo'<br><pre>';
                        //print_r($arr_mdt_date);
                        //echo'<br></pre>';
                    }
                }
                else
                {
                    if($scale_range == '1')
                    {
                        $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) < '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                    }
                    elseif($scale_range == '2')
                    {
                        $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) > '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                    }
                    elseif($scale_range == '3')
                    {
                        $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) <= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                    }
                    elseif($scale_range == '4')
                    {
                        $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) >= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                    }
                    elseif($scale_range == '5')
                    {
                        $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) = '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                    }
                    elseif($scale_range == '6')
                    {
                        $min_value = min($start_scale_value,$end_scale_value);
                        $max_value = max($start_scale_value,$end_scale_value);
                        $sql_str_scale = " AND ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'situation' ) ";
                    }
                    else
                    {
                        $sql_str_scale = "";
                    }
                    
                    
                    $sql = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE "
                    . "`user_id` = '".$user_id."' AND "
                    . "`mdt_date` >= '".$start_date."' AND "
                    . "`mdt_date` <= '".$end_date."' AND "
                    . "`mdt_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `mdt_date` DESC ";
                    //echo "<br>Testkk sql = ".$sql;
                    $result = mysql_query($sql,$link);
                    if( ($result) && (mysql_num_rows($result) > 0) )
                    {
                        while($row = mysql_fetch_array($result))
                        {
                            array_push($arr_mdt_date , $row['mdt_date']);
                        }
                    }
                }
            }
            elseif($module_keyword != '' && $scale_range == '' && $module_criteria == '')
            {
                $sql_str_scale = '';
                $sql_str_report_module_criteria = '';
                $sql_str_report_module = " AND `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation' ";
                
                $sql = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE "
                    . "`user_id` = '".$user_id."' AND "
                    . "`mdt_date` >= '".$start_date."' AND "
                    . "`mdt_date` <= '".$end_date."' AND "
                    . "`mdt_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `mdt_date` DESC ";
                //echo "<br>Testkk sql = ".$sql;
                $result = mysql_query($sql,$link);
                if( ($result) && (mysql_num_rows($result) > 0) )
                {
                    while($row = mysql_fetch_array($result))
                    {
                        array_push($arr_mdt_date , $row['mdt_date']);
                    }
                }
            }
            elseif($module_keyword != '' && $scale_range == '' && $module_criteria != '')
            {
                $sql_str_scale = '';
                $sql_str_report_module = " AND `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation' ";
                                
                if($module_criteria == '9')
                {
                    $sql_str_report_module_criteria = '';
                }
                
                $sql = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE "
                    . "`user_id` = '".$user_id."' AND "
                    . "`mdt_date` >= '".$start_date."' AND "
                    . "`mdt_date` <= '".$end_date."' AND "
                    . "`mdt_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `mdt_date` DESC ";
                //echo "<br>Testkk sql = ".$sql;
                $result = mysql_query($sql,$link);
                if( ($result) && (mysql_num_rows($result) > 0) )
                {
                    while($row = mysql_fetch_array($result))
                    {
                        array_push($arr_mdt_date , $row['mdt_date']);
                    }
                }
            }
            elseif($module_keyword != '' && $scale_range != '' && $module_criteria == '')
            {
                $sql_str_report_module_criteria = '';
                $sql_str_report_module = " AND `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation' ";
                if($scale_range == '1')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) < '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '2')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) > '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '3')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) <= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '4')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) >= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '5')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) = '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '6')
                {
                    $min_value = min($start_scale_value,$end_scale_value);
                    $max_value = max($start_scale_value,$end_scale_value);
                    $sql_str_scale = " AND ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'situation' ) ";
                }
                else
                {
                    $sql_str_scale = "";
                }
                
                $sql = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE "
                    . "`user_id` = '".$user_id."' AND "
                    . "`mdt_date` >= '".$start_date."' AND "
                    . "`mdt_date` <= '".$end_date."' AND "
                    . "`mdt_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `mdt_date` DESC ";
                //echo "<br>Testkk sql = ".$sql;
                $result = mysql_query($sql,$link);
                if( ($result) && (mysql_num_rows($result) > 0) )
                {
                    while($row = mysql_fetch_array($result))
                    {
                        array_push($arr_mdt_date , $row['mdt_date']);
                    }
                }
            }
            else
            {
                $sql_str_scale = '';
                $sql_str_report_module = " AND `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation' ";
                
                if($scale_range == '1')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) < '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '2')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) > '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '3')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) <= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '4')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) >= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '5')
                {
                    $sql_str_scale = " AND (  CAST(`scale` AS SIGNED) = '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                }
                elseif($scale_range == '6')
                {
                    $min_value = min($start_scale_value,$end_scale_value);
                    $max_value = max($start_scale_value,$end_scale_value);
                    $sql_str_scale = " AND ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'situation' ) ";
                }
                else
                {
                    $sql_str_scale = "";
                }
                                
                if($module_criteria == '9')
                {
                    $sql_str_report_module_criteria = '';
                }
                
                $sql = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE "
                    . "`user_id` = '".$user_id."' AND "
                    . "`mdt_date` >= '".$start_date."' AND "
                    . "`mdt_date` <= '".$end_date."' AND "
                    . "`mdt_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria."  ORDER BY `mdt_date` DESC ";
                //echo "<br>Testkk sql = ".$sql;
                $result = mysql_query($sql,$link);
                if( ($result) && (mysql_num_rows($result) > 0) )
                {
                    while($row = mysql_fetch_array($result))
                    {
                        array_push($arr_mdt_date , $row['mdt_date']);
                    }
                }
            }
	
            	
            
            if(count($arr_mdt_date) > 0)
            {		
                for($i=0;$i<count($arr_mdt_date);$i++)
                {
                    
                    $sql3 = "SELECT DISTINCT `mdt_time`, `mdt_duration` FROM `tblusersmdt` WHERE "
                            . "`user_id` = '".$user_id."' AND "
                            . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                            . "`mdt_old_data` = '0'  ".$sql_str_scale." ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY `mdt_add_date` DESC ";
                    //echo "<br>".$sql3;
                    $result3 = mysql_query($sql3,$link);
                    if( ($result3) && (mysql_num_rows($result3) > 0) )
                    {
                        $k=0;
                        while($row3 = mysql_fetch_array($result3))
                        {
                            $mdt_time = stripslashes($row3['mdt_time']);
                            $mdt_duration = stripslashes($row3['mdt_duration']);
                            $mdt_time_duration = $mdt_time.'_'.$mdt_duration;
                            
                            $go_ahead = true;
                            if($module_keyword == '' && $scale_range == '' && $module_criteria == '')
                            {
                                $sql_str_scale2 = '';
                                $sql_str_report_module2 = '';
                                $sql_str_report_module_criteria2 = '';
                               
                            }
                            elseif($module_keyword == '' && $scale_range == '' && $module_criteria != '')
                            {
                                $sql_str_scale2 = '';
                                $sql_str_report_module2 = '';

                                if($module_criteria == '9')
                                {
                                    if($criteria_scale_range == '1')
                                    {
                                        $sql_str_report_module_criteria2 = " AND ( ( CAST(`scale` AS SIGNED) < '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) OR (`bms_entry_type` = 'situation') )";
                                    }
                                    elseif($criteria_scale_range == '2')
                                    {
                                        $sql_str_report_module_criteria2 = " AND ( ( CAST(`scale` AS SIGNED) > '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) OR (`bms_entry_type` = 'situation') )";
                                    }
                                    elseif($criteria_scale_range == '3')
                                    {
                                        $sql_str_report_module_criteria2 = " AND ( ( CAST(`scale` AS SIGNED) <= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) OR (`bms_entry_type` = 'situation') )";
                                    }
                                    elseif($criteria_scale_range == '4')
                                    {
                                        $sql_str_report_module_criteria2 = " AND ( ( CAST(`scale` AS SIGNED) >= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) OR (`bms_entry_type` = 'situation') )";
                                    }
                                    elseif($criteria_scale_range == '5')
                                    {
                                        $sql_str_report_module_criteria2 = " AND ( ( CAST(`scale` AS SIGNED) = '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) OR (`bms_entry_type` = 'situation') )";
                                    }
                                    elseif($criteria_scale_range == '6')
                                    {
                                        $min_value = min($start_criteria_scale_value,$end_criteria_scale_value);
                                        $max_value = max($start_criteria_scale_value,$end_criteria_scale_value);
                                        $sql_str_report_module_criteria2 = " AND ( ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'trigger' ) OR (`bms_entry_type` = 'situation') )";
                                    }
                                    else
                                    {
                                        $sql_str_report_module_criteria2 = "";
                                    }

                                    if($trigger_criteria != '')
                                    {
                                        $sql_str_report_module2 = " AND ( ( `bms_id` = '".$trigger_criteria."' AND `bms_entry_type` = 'trigger') OR (`bms_entry_type` = 'situation') ) ";
                                    }
                                    else
                                    {
                                        $sql_str_report_module2 = '';
                                    }
                                }
                               

                            }
                            elseif($module_keyword == '' && $scale_range != '' && $module_criteria == '')
                            {
                                $sql_str_report_module2 = '';
                                $sql_str_report_module_criteria2 = '';
                                if($scale_range == '1')
                                {
                                    $sql_str_scale2 = " AND ( (  CAST(`scale` AS SIGNED) < '".$start_scale_value."' AND `bms_entry_type` = 'situation' ) OR (`bms_entry_type` = 'trigger') ) ";
                                }
                                elseif($scale_range == '2')
                                {
                                    $sql_str_scale2 = " AND ( ( CAST(`scale` AS SIGNED) > '".$start_scale_value."' AND `bms_entry_type` = 'situation' ) OR (`bms_entry_type` = 'trigger') ) ";
                                }
                                elseif($scale_range == '3')
                                {
                                    $sql_str_scale2 = " AND ( ( CAST(`scale` AS SIGNED) <= '".$start_scale_value."' AND `bms_entry_type` = 'situation' ) OR (`bms_entry_type` = 'trigger') ) ";
                                }
                                elseif($scale_range == '4')
                                {
                                    $sql_str_scale2 = " AND ( ( CAST(`scale` AS SIGNED) >= '".$start_scale_value."' AND `bms_entry_type` = 'situation' ) OR (`bms_entry_type` = 'trigger') ) ";
                                }
                                elseif($scale_range == '5')
                                {
                                    $sql_str_scale2 = " AND ( ( CAST(`scale` AS SIGNED) = '".$start_scale_value."' AND `bms_entry_type` = 'situation' ) OR (`bms_entry_type` = 'trigger') ) ";
                                }
                                elseif($scale_range == '6')
                                {
                                    $min_value = min($start_scale_value,$end_scale_value);
                                    $max_value = max($start_scale_value,$end_scale_value);
                                    $sql_str_scale2 = " AND ( ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'situation' ) OR (`bms_entry_type` = 'trigger') ) ";
                                }
                                else
                                {
                                    $sql_str_scale2 = "";
                                }

                               


                            }
                            elseif($module_keyword == '' && $scale_range != '' && $module_criteria != '')
                            {
                                $sql_str_report_module2 = '';

                                if($module_criteria == '9')
                                {
                                    $sql_str_report_module_criteria2 = '';

                                    if($trigger_criteria != '')
                                    {
                                        $sql_str_report_module2 = " AND ( ( `bms_id` = '".$trigger_criteria."' AND `bms_entry_type` = 'trigger') OR (`bms_entry_type` = 'situation') ) ";
                                        $sql_str_report_module3 = " AND ( `bms_id` = '".$trigger_criteria."' AND `bms_entry_type` = 'trigger') ";

                                        if($criteria_scale_range == '1')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) < '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '2')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) > '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '3')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) <= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '4')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) >= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '5')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) = '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '6')
                                        {
                                            $min_value = min($start_criteria_scale_value,$end_criteria_scale_value);
                                            $max_value = max($start_criteria_scale_value,$end_criteria_scale_value);
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        else
                                        {
                                            $sql_str_report_module_criteria2 = "";
                                        }

                                        

                                        if($scale_range == '1')
                                        {
                                            $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) < '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                        }
                                        elseif($scale_range == '2')
                                        {
                                            $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) > '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                        }
                                        elseif($scale_range == '3')
                                        {
                                            $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) <= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                        }
                                        elseif($scale_range == '4')
                                        {
                                            $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) >= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                        }
                                        elseif($scale_range == '5')
                                        {
                                            $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) = '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                        }
                                        elseif($scale_range == '6')
                                        {
                                            $min_value = min($start_scale_value,$end_scale_value);
                                            $max_value = max($start_scale_value,$end_scale_value);
                                            $sql_str_scale2 = " ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'situation' ) ";
                                        }
                                        else
                                        {
                                            $sql_str_scale2 = "";
                                        }
                                        
                                        
                                        
                                        if($sql_str_report_module_criteria2 == "")
                                        {
                                            $sql_str_report_module_criteria3 = "";
                                        }
                                        else
                                        {
                                            $sql_str_report_module_criteria3 = " AND ".$sql_str_report_module_criteria2;
                                        }
                                        
                                        if($sql_str_scale2 == "")
                                        {
                                            $sql_str_scale3 = "";
                                        }
                                        else
                                        {
                                            
                                            $sql_str_scale3 = " AND ".$sql_str_scale2;
                                        }
                                        
                                        
                                        $sql2_s = "SELECT * FROM `tblusersmdt` WHERE "
                                                . "`user_id` = '".$user_id."' AND "
                                                . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                                . "`mdt_time` = '".$mdt_time."' AND "
                                                . "`mdt_duration` = '".$mdt_duration."' AND "
                                                . "`mdt_old_data` = '0'  ".$sql_str_scale3." ORDER BY `mdt_add_date` DESC ";
                                        //echo "<br>".$sql2_s;
                                        $result2_s = mysql_query($sql2_s,$link);
                                        if( ($result2_s) && (mysql_num_rows($result2_s) > 0) )
                                        {
                                            $sql2_t = "SELECT * FROM `tblusersmdt` WHERE "
                                                . "`user_id` = '".$user_id."' AND "
                                                . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                                . "`mdt_time` = '".$mdt_time."' AND "
                                                . "`mdt_duration` = '".$mdt_duration."' AND "
                                                . "`mdt_old_data` = '0'  ".$sql_str_report_module_criteria3." ".$sql_str_report_module3." ORDER BY `mdt_add_date` DESC ";
                                            //echo "<br>".$sql2_t;
                                            $result2_t = mysql_query($sql2_t,$link);
                                            if( ($result2_t) && (mysql_num_rows($result2_t) > 0) )
                                            {

                                            }
                                            else
                                            {
                                                $go_ahead = false;
                                            }
                                        }
                                        else
                                        {
                                            $go_ahead = false;
                                        }
                                        
                                        

                                        if($sql_str_scale2 == "")
                                        {
                                            if($sql_str_report_module_criteria2 == "")
                                            {

                                            }
                                            else
                                            {
                                                $sql_str_report_module_criteria2 = " AND ".$sql_str_report_module_criteria2;

                                            }
                                        }
                                        else
                                        {
                                            if($sql_str_report_module_criteria2 == "")
                                            {
                                                $sql_str_scale2 = " AND ( ".$sql_str_scale2." OR (`bms_entry_type` = 'trigger'))";

                                            }
                                            else
                                            {
                                                $sql_str_scale2 = " AND ( ".$sql_str_report_module_criteria2." OR ".$sql_str_scale2." )";
                                                $sql_str_report_module_criteria2 = "";

                                            }
                                        }

                                    }
                                    else
                                    {
                                        $sql_str_report_module2 = '';

                                        if($scale_range == '1')
                                        {
                                            $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) < '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                        }
                                        elseif($scale_range == '2')
                                        {
                                            $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) > '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                        }
                                        elseif($scale_range == '3')
                                        {
                                            $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) <= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                        }
                                        elseif($scale_range == '4')
                                        {
                                            $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) >= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                        }
                                        elseif($scale_range == '5')
                                        {
                                            $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) = '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                        }
                                        elseif($scale_range == '6')
                                        {
                                            $min_value = min($start_scale_value,$end_scale_value);
                                            $max_value = max($start_scale_value,$end_scale_value);
                                            $sql_str_scale2 = " ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'situation' ) ";
                                        }
                                        else
                                        {
                                            $sql_str_scale2 = "";
                                        }

                                        if($criteria_scale_range == '1')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) < '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '2')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) > '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '3')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) <= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '4')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) >= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '5')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) = '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '6')
                                        {
                                            $min_value = min($start_criteria_scale_value,$end_criteria_scale_value);
                                            $max_value = max($start_criteria_scale_value,$end_criteria_scale_value);
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        else
                                        {
                                            $sql_str_report_module_criteria2 = "";
                                        }
                                        
                                        if($sql_str_report_module_criteria2 == "")
                                        {
                                            $sql_str_report_module_criteria3 = "";
                                        }
                                        else
                                        {
                                            $sql_str_report_module_criteria3 = " AND ".$sql_str_report_module_criteria2;
                                        }
                                        
                                        if($sql_str_scale2 == "")
                                        {
                                            $sql_str_scale3 = "";
                                        }
                                        else
                                        {
                                            
                                            $sql_str_scale3 = " AND ".$sql_str_scale2;
                                        }
                                        
                                        
                                        $sql2_s = "SELECT * FROM `tblusersmdt` WHERE "
                                                . "`user_id` = '".$user_id."' AND "
                                                . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                                . "`mdt_time` = '".$mdt_time."' AND "
                                                . "`mdt_duration` = '".$mdt_duration."' AND "
                                                . "`mdt_old_data` = '0'  ".$sql_str_scale3." ORDER BY `mdt_add_date` DESC ";
                                        //echo "<br>".$sql2_s;
                                        $result2_s = mysql_query($sql2_s,$link);
                                        if( ($result2_s) && (mysql_num_rows($result2_s) > 0) )
                                        {
                                            $sql2_t = "SELECT * FROM `tblusersmdt` WHERE "
                                                . "`user_id` = '".$user_id."' AND "
                                                . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                                . "`mdt_time` = '".$mdt_time."' AND "
                                                . "`mdt_duration` = '".$mdt_duration."' AND "
                                                . "`mdt_old_data` = '0'  ".$sql_str_report_module_criteria3." ORDER BY `mdt_add_date` DESC ";
                                            //echo "<br>".$sql2_t;
                                            $result2_t = mysql_query($sql2_t,$link);
                                            if( ($result2_t) && (mysql_num_rows($result2_t) > 0) )
                                            {

                                            }
                                            else
                                            {
                                                $go_ahead = false;
                                            }
                                        }
                                        else
                                        {
                                            $go_ahead = false;
                                        }
                                        
                                        

                                        if($sql_str_scale2 == "")
                                        {
                                            if($sql_str_report_module_criteria2 == "")
                                            {

                                            }
                                            else
                                            {
                                                $sql_str_report_module_criteria2 = " AND ".$sql_str_report_module_criteria2;

                                            }
                                        }
                                        else
                                        {
                                            if($sql_str_report_module_criteria2 == "")
                                            {
                                                $sql_str_scale2 = " AND ( ".$sql_str_scale2." OR (`bms_entry_type` = 'trigger'))";

                                            }
                                            else
                                            {
                                                $sql_str_scale2 = " AND ( ".$sql_str_report_module_criteria2." OR ".$sql_str_scale2." )";
                                                $sql_str_report_module_criteria2 = "";

                                            }
                                        }

                                    }
                                }
                                else
                                {
                                    if($scale_range == '1')
                                    {
                                        $sql_str_scale2 = " AND (  CAST(`scale` AS SIGNED) < '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                    }
                                    elseif($scale_range == '2')
                                    {
                                        $sql_str_scale2 = " AND (  CAST(`scale` AS SIGNED) > '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                    }
                                    elseif($scale_range == '3')
                                    {
                                        $sql_str_scale2 = " AND (  CAST(`scale` AS SIGNED) <= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                    }
                                    elseif($scale_range == '4')
                                    {
                                        $sql_str_scale2 = " AND (  CAST(`scale` AS SIGNED) >= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                    }
                                    elseif($scale_range == '5')
                                    {
                                        $sql_str_scale2 = " AND ( ( CAST(`scale` AS SIGNED) = '".$start_scale_value."' AND `bms_entry_type` = 'situation' ) OR (`bms_entry_type` = 'trigger') )  ";
                                    }
                                    elseif($scale_range == '6')
                                    {
                                        $min_value = min($start_scale_value,$end_scale_value);
                                        $max_value = max($start_scale_value,$end_scale_value);
                                        $sql_str_scale2 = " AND ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'situation' ) ";
                                    }
                                    else
                                    {
                                        $sql_str_scale2 = "";
                                    }
                                }

                            }
                            elseif($module_keyword != '' && $scale_range == '' && $module_criteria == '')
                            {
                                $sql_str_scale2 = '';
                                $sql_str_report_module_criteria2 = '';
                                $sql_str_report_module2 = " AND ( ( `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation') OR (`bms_entry_type` = 'trigger') ) ";

                               
                            }
                            elseif($module_keyword != '' && $scale_range == '' && $module_criteria != '')
                            {
                                $sql_str_scale2 = '';
                                $sql_str_report_module2 = " AND ( ( `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation') OR (`bms_entry_type` = 'trigger') ) ";

                                if($module_criteria == '9')
                                {
                                    $sql_str_report_module_criteria2 = '';

                                    if($trigger_criteria != '')
                                    {
                                        //$sql_str_report_module2 = " AND ( ( `bms_id` = '".$trigger_criteria."' AND `bms_entry_type` = 'trigger') OR (`bms_entry_type` = 'situation') ) ";
                                        $sql_str_report_module3 = " AND ( `bms_id` = '".$trigger_criteria."' AND `bms_entry_type` = 'trigger') ";
                                        $sql_str_report_module3_s = " AND ( `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation') ";
                                        
                                        $sql_str_report_module2 = " AND ( ( `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation') OR (`bms_id` = '".$trigger_criteria."' AND `bms_entry_type` = 'trigger') ) ";

                                        if($criteria_scale_range == '1')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) < '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '2')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) > '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '3')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) <= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '4')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) >= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '5')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) = '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '6')
                                        {
                                            $min_value = min($start_criteria_scale_value,$end_criteria_scale_value);
                                            $max_value = max($start_criteria_scale_value,$end_criteria_scale_value);
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        else
                                        {
                                            $sql_str_report_module_criteria2 = "";
                                        }

                                        

                                        $sql_str_scale2 = "";
                                        
                                        
                                        
                                        
                                        if($sql_str_report_module_criteria2 == "")
                                        {
                                            $sql_str_report_module_criteria3 = "";
                                        }
                                        else
                                        {
                                            $sql_str_report_module_criteria3 = " AND ".$sql_str_report_module_criteria2;
                                        }
                                        
                                        if($sql_str_scale2 == "")
                                        {
                                            $sql_str_scale3 = "";
                                        }
                                        else
                                        {
                                            
                                            $sql_str_scale3 = " AND ".$sql_str_scale2;
                                        }
                                        
                                        
                                        $sql2_s = "SELECT * FROM `tblusersmdt` WHERE "
                                                . "`user_id` = '".$user_id."' AND "
                                                . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                                . "`mdt_time` = '".$mdt_time."' AND "
                                                . "`mdt_duration` = '".$mdt_duration."' AND "
                                                . "`mdt_old_data` = '0'  ".$sql_str_scale3." ".$sql_str_report_module3_s." ORDER BY `mdt_add_date` DESC ";
                                        //echo "<br>".$sql2_s;
                                        $result2_s = mysql_query($sql2_s,$link);
                                        if( ($result2_s) && (mysql_num_rows($result2_s) > 0) )
                                        {
                                            $sql2_t = "SELECT * FROM `tblusersmdt` WHERE "
                                                . "`user_id` = '".$user_id."' AND "
                                                . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                                . "`mdt_time` = '".$mdt_time."' AND "
                                                . "`mdt_duration` = '".$mdt_duration."' AND "
                                                . "`mdt_old_data` = '0'  ".$sql_str_report_module_criteria3." ".$sql_str_report_module3." ORDER BY `mdt_add_date` DESC ";
                                            //echo "<br>".$sql2_t;
                                            $result2_t = mysql_query($sql2_t,$link);
                                            if( ($result2_t) && (mysql_num_rows($result2_t) > 0) )
                                            {

                                            }
                                            else
                                            {
                                                $go_ahead = false;
                                            }
                                        }
                                        else
                                        {
                                            $go_ahead = false;
                                        }
                                        
                                        

                                        if($sql_str_scale2 == "")
                                        {
                                            if($sql_str_report_module_criteria2 == "")
                                            {

                                            }
                                            else
                                            {
                                                $sql_str_report_module_criteria2 = " AND ( ".$sql_str_report_module_criteria2." OR (`bms_entry_type` = 'situation'))";

                                            }
                                        }
                                        else
                                        {
                                            if($sql_str_report_module_criteria2 == "")
                                            {
                                                $sql_str_scale2 = " AND ( ".$sql_str_scale2." OR (`bms_entry_type` = 'trigger'))";

                                            }
                                            else
                                            {
                                                $sql_str_scale2 = " AND ( ".$sql_str_report_module_criteria2." OR ".$sql_str_scale2." )";
                                                $sql_str_report_module_criteria2 = "";

                                            }
                                        }

                                    }
                                    else
                                    {
                                        $sql_str_report_module3 = "";
                                        $sql_str_report_module3_s = " AND ( `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation') ";
                                        
                                        $sql_str_report_module2 = " AND ( ( `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation') OR (`bms_entry_type` = 'trigger') ) ";

                                        if($criteria_scale_range == '1')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) < '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '2')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) > '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '3')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) <= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '4')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) >= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '5')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) = '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '6')
                                        {
                                            $min_value = min($start_criteria_scale_value,$end_criteria_scale_value);
                                            $max_value = max($start_criteria_scale_value,$end_criteria_scale_value);
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        else
                                        {
                                            $sql_str_report_module_criteria2 = "";
                                        }

                                        

                                        $sql_str_scale2 = "";
                                        
                                        
                                        
                                        
                                        if($sql_str_report_module_criteria2 == "")
                                        {
                                            $sql_str_report_module_criteria3 = "";
                                        }
                                        else
                                        {
                                            $sql_str_report_module_criteria3 = " AND ".$sql_str_report_module_criteria2;
                                        }
                                        
                                        if($sql_str_scale2 == "")
                                        {
                                            $sql_str_scale3 = "";
                                        }
                                        else
                                        {
                                            
                                            $sql_str_scale3 = " AND ".$sql_str_scale2;
                                        }
                                        
                                        
                                        $sql2_s = "SELECT * FROM `tblusersmdt` WHERE "
                                                . "`user_id` = '".$user_id."' AND "
                                                . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                                . "`mdt_time` = '".$mdt_time."' AND "
                                                . "`mdt_duration` = '".$mdt_duration."' AND "
                                                . "`mdt_old_data` = '0'  ".$sql_str_scale3." ".$sql_str_report_module3_s." ORDER BY `mdt_add_date` DESC ";
                                        //echo "<br>".$sql2_s;
                                        $result2_s = mysql_query($sql2_s,$link);
                                        if( ($result2_s) && (mysql_num_rows($result2_s) > 0) )
                                        {
                                            $sql2_t = "SELECT * FROM `tblusersmdt` WHERE "
                                                . "`user_id` = '".$user_id."' AND "
                                                . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                                . "`mdt_time` = '".$mdt_time."' AND "
                                                . "`mdt_duration` = '".$mdt_duration."' AND "
                                                . "`mdt_old_data` = '0'  ".$sql_str_report_module_criteria3." ".$sql_str_report_module3." ORDER BY `mdt_add_date` DESC ";
                                            //echo "<br>".$sql2_t;
                                            $result2_t = mysql_query($sql2_t,$link);
                                            if( ($result2_t) && (mysql_num_rows($result2_t) > 0) )
                                            {

                                            }
                                            else
                                            {
                                                $go_ahead = false;
                                            }
                                        }
                                        else
                                        {
                                            $go_ahead = false;
                                        }
                                        
                                        

                                        if($sql_str_scale2 == "")
                                        {
                                            if($sql_str_report_module_criteria2 == "")
                                            {

                                            }
                                            else
                                            {
                                                $sql_str_report_module_criteria2 = " AND ( ".$sql_str_report_module_criteria2." OR (`bms_entry_type` = 'situation'))";

                                            }
                                        }
                                        else
                                        {
                                            if($sql_str_report_module_criteria2 == "")
                                            {
                                                $sql_str_scale2 = " AND ( ".$sql_str_scale2." OR (`bms_entry_type` = 'trigger'))";

                                            }
                                            else
                                            {
                                                $sql_str_scale2 = " AND ( ".$sql_str_report_module_criteria2." OR ".$sql_str_scale2." )";
                                                $sql_str_report_module_criteria2 = "";

                                            }
                                        }

                                    }
                                }
                                else
                                {
                                    $sql_str_report_module_criteria2 = '';
                                }

                                
                            }
                            elseif($module_keyword != '' && $scale_range != '' && $module_criteria == '')
                            {
                                $sql_str_report_module_criteria2 = '';
                                $sql_str_report_module2 = " AND ( ( `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation' ) OR (`bms_entry_type` = 'trigger') ) ";
                                if($scale_range == '1')
                                {
                                    $sql_str_scale2 = " AND ( ( CAST(`scale` AS SIGNED) < '".$start_scale_value."' AND `bms_entry_type` = 'situation' ) OR (`bms_entry_type` = 'trigger') ) ";
                                }
                                elseif($scale_range == '2')
                                {
                                    $sql_str_scale2 = " AND ( ( CAST(`scale` AS SIGNED) > '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  OR (`bms_entry_type` = 'trigger') ) ";
                                }
                                elseif($scale_range == '3')
                                {
                                    $sql_str_scale2 = " AND ( ( CAST(`scale` AS SIGNED) <= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  OR (`bms_entry_type` = 'trigger') ) ";
                                }
                                elseif($scale_range == '4')
                                {
                                    $sql_str_scale2 = " AND ( ( CAST(`scale` AS SIGNED) >= '".$start_scale_value."' AND `bms_entry_type` = 'situation' ) OR (`bms_entry_type` = 'trigger') ) ";
                                }
                                elseif($scale_range == '5')
                                {
                                    $sql_str_scale2 = " AND ( ( CAST(`scale` AS SIGNED) = '".$start_scale_value."' AND `bms_entry_type` = 'situation' ) OR (`bms_entry_type` = 'trigger') ) ";
                                }
                                elseif($scale_range == '6')
                                {
                                    $min_value = min($start_scale_value,$end_scale_value);
                                    $max_value = max($start_scale_value,$end_scale_value);
                                    $sql_str_scale2 = " AND ( ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'situation' ) OR (`bms_entry_type` = 'trigger') ) ";
                                }
                                else
                                {
                                    $sql_str_scale2 = "";
                                }

                                
                            }
                            else
                            {
                                
                                $sql_str_scale2 = '';
                                $sql_str_report_module2 = " AND ( ( `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation') OR (`bms_entry_type` = 'trigger') ) ";
                                
                                if($scale_range == '1')
                                {
                                    $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) < '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                }
                                elseif($scale_range == '2')
                                {
                                    $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) > '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                }
                                elseif($scale_range == '3')
                                {
                                    $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) <= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                }
                                elseif($scale_range == '4')
                                {
                                    $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) >= '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                }
                                elseif($scale_range == '5')
                                {
                                    $sql_str_scale2 = " (  CAST(`scale` AS SIGNED) = '".$start_scale_value."' AND `bms_entry_type` = 'situation' )  ";
                                }
                                elseif($scale_range == '6')
                                {
                                    $min_value = min($start_scale_value,$end_scale_value);
                                    $max_value = max($start_scale_value,$end_scale_value);
                                    $sql_str_scale2 = " ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'situation' ) ";
                                }
                                else
                                {
                                    $sql_str_scale2 = "";
                                }

                                if($module_criteria == '9')
                                {
                                    $sql_str_report_module_criteria2 = '';

                                    if($trigger_criteria != '')
                                    {
                                        //$sql_str_report_module2 = " AND ( ( `bms_id` = '".$trigger_criteria."' AND `bms_entry_type` = 'trigger') OR (`bms_entry_type` = 'situation') ) ";
                                        $sql_str_report_module3 = " AND ( `bms_id` = '".$trigger_criteria."' AND `bms_entry_type` = 'trigger') ";
                                        $sql_str_report_module3_s = " AND ( `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation') ";
                                        
                                        $sql_str_report_module2 = " AND ( ( `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation') OR (`bms_id` = '".$trigger_criteria."' AND `bms_entry_type` = 'trigger') ) ";

                                        if($criteria_scale_range == '1')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) < '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '2')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) > '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '3')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) <= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '4')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) >= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '5')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) = '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '6')
                                        {
                                            $min_value = min($start_criteria_scale_value,$end_criteria_scale_value);
                                            $max_value = max($start_criteria_scale_value,$end_criteria_scale_value);
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        else
                                        {
                                            $sql_str_report_module_criteria2 = "";
                                        }

                                        

                                        
                                        
                                        
                                        
                                        if($sql_str_report_module_criteria2 == "")
                                        {
                                            $sql_str_report_module_criteria3 = "";
                                        }
                                        else
                                        {
                                            $sql_str_report_module_criteria3 = " AND ".$sql_str_report_module_criteria2;
                                        }
                                        
                                        if($sql_str_scale2 == "")
                                        {
                                            $sql_str_scale3 = "";
                                        }
                                        else
                                        {
                                            
                                            $sql_str_scale3 = " AND ".$sql_str_scale2;
                                        }
                                        
                                        
                                        $sql2_s = "SELECT * FROM `tblusersmdt` WHERE "
                                                . "`user_id` = '".$user_id."' AND "
                                                . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                                . "`mdt_time` = '".$mdt_time."' AND "
                                                . "`mdt_duration` = '".$mdt_duration."' AND "
                                                . "`mdt_old_data` = '0'  ".$sql_str_scale3." ".$sql_str_report_module3_s." ORDER BY `mdt_add_date` DESC ";
                                        //echo "<br>".$sql2_s;
                                        $result2_s = mysql_query($sql2_s,$link);
                                        if( ($result2_s) && (mysql_num_rows($result2_s) > 0) )
                                        {
                                            $sql2_t = "SELECT * FROM `tblusersmdt` WHERE "
                                                . "`user_id` = '".$user_id."' AND "
                                                . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                                . "`mdt_time` = '".$mdt_time."' AND "
                                                . "`mdt_duration` = '".$mdt_duration."' AND "
                                                . "`mdt_old_data` = '0'  ".$sql_str_report_module_criteria3." ".$sql_str_report_module3." ORDER BY `mdt_add_date` DESC ";
                                            //echo "<br>".$sql2_t;
                                            $result2_t = mysql_query($sql2_t,$link);
                                            if( ($result2_t) && (mysql_num_rows($result2_t) > 0) )
                                            {

                                            }
                                            else
                                            {
                                                $go_ahead = false;
                                            }
                                        }
                                        else
                                        {
                                            $go_ahead = false;
                                        }
                                        
                                        

                                        if($sql_str_scale2 == "")
                                        {
                                            if($sql_str_report_module_criteria2 == "")
                                            {

                                            }
                                            else
                                            {
                                                $sql_str_report_module_criteria2 = " AND ".$sql_str_report_module_criteria2;

                                            }
                                        }
                                        else
                                        {
                                            if($sql_str_report_module_criteria2 == "")
                                            {
                                                $sql_str_scale2 = " AND ( ".$sql_str_scale2." OR (`bms_entry_type` = 'trigger'))";

                                            }
                                            else
                                            {
                                                $sql_str_scale2 = " AND ( ".$sql_str_report_module_criteria2." OR ".$sql_str_scale2." )";
                                                $sql_str_report_module_criteria2 = "";

                                            }
                                        }

                                    }
                                    else
                                    {
                                        $sql_str_report_module3 = "";
                                        $sql_str_report_module3_s = " AND ( `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation') ";
                                        
                                        $sql_str_report_module2 = " AND ( ( `bms_id` = '".$module_keyword."' AND `bms_entry_type` = 'situation') OR (`bms_entry_type` = 'trigger') ) ";

                                        if($criteria_scale_range == '1')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) < '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '2')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) > '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '3')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) <= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '4')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) >= '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '5')
                                        {
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) = '".$start_criteria_scale_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        elseif($criteria_scale_range == '6')
                                        {
                                            $min_value = min($start_criteria_scale_value,$end_criteria_scale_value);
                                            $max_value = max($start_criteria_scale_value,$end_criteria_scale_value);
                                            $sql_str_report_module_criteria2 = " ( CAST(`scale` AS SIGNED) BETWEEN '".$min_value."' AND '".$max_value."' AND `bms_entry_type` = 'trigger' ) ";
                                        }
                                        else
                                        {
                                            $sql_str_report_module_criteria2 = "";
                                        }

                                        

                                        if($sql_str_report_module_criteria2 == "")
                                        {
                                            $sql_str_report_module_criteria3 = "";
                                        }
                                        else
                                        {
                                            $sql_str_report_module_criteria3 = " AND ".$sql_str_report_module_criteria2;
                                        }
                                        
                                        if($sql_str_scale2 == "")
                                        {
                                            $sql_str_scale3 = "";
                                        }
                                        else
                                        {
                                            
                                            $sql_str_scale3 = " AND ".$sql_str_scale2;
                                        }
                                        
                                        
                                        $sql2_s = "SELECT * FROM `tblusersmdt` WHERE "
                                                . "`user_id` = '".$user_id."' AND "
                                                . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                                . "`mdt_time` = '".$mdt_time."' AND "
                                                . "`mdt_duration` = '".$mdt_duration."' AND "
                                                . "`mdt_old_data` = '0'  ".$sql_str_scale3." ".$sql_str_report_module3_s." ORDER BY `mdt_add_date` DESC ";
                                        //echo "<br>".$sql2_s;
                                        $result2_s = mysql_query($sql2_s,$link);
                                        if( ($result2_s) && (mysql_num_rows($result2_s) > 0) )
                                        {
                                            $sql2_t = "SELECT * FROM `tblusersmdt` WHERE "
                                                . "`user_id` = '".$user_id."' AND "
                                                . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                                . "`mdt_time` = '".$mdt_time."' AND "
                                                . "`mdt_duration` = '".$mdt_duration."' AND "
                                                . "`mdt_old_data` = '0'  ".$sql_str_report_module_criteria3." ".$sql_str_report_module3." ORDER BY `mdt_add_date` DESC ";
                                            //echo "<br>".$sql2_t;
                                            $result2_t = mysql_query($sql2_t,$link);
                                            if( ($result2_t) && (mysql_num_rows($result2_t) > 0) )
                                            {

                                            }
                                            else
                                            {
                                                $go_ahead = false;
                                            }
                                        }
                                        else
                                        {
                                            $go_ahead = false;
                                        }
                                        
                                        

                                        if($sql_str_scale2 == "")
                                        {
                                            if($sql_str_report_module_criteria2 == "")
                                            {

                                            }
                                            else
                                            {
                                                $sql_str_report_module_criteria2 = " AND ".$sql_str_report_module_criteria2;

                                            }
                                        }
                                        else
                                        {
                                            if($sql_str_report_module_criteria2 == "")
                                            {
                                                $sql_str_scale2 = " AND ( ".$sql_str_scale2." OR (`bms_entry_type` = 'trigger'))";

                                            }
                                            else
                                            {
                                                $sql_str_scale2 = " AND ( ".$sql_str_report_module_criteria2." OR ".$sql_str_scale2." )";
                                                $sql_str_report_module_criteria2 = "";

                                            }
                                        }

                                    }
                                }
                                else
                                {
                                    $sql_str_report_module_criteria2 = '';
                                }

                            }
                            
                            
                            
                            
                            
                            
                            if($go_ahead)
                            {
                            
                    
                            $sql2 = "SELECT * FROM `tblusersmdt` WHERE "
                                    . "`user_id` = '".$user_id."' AND "
                                    . "`mdt_date` = '".$arr_mdt_date[$i]."' AND "
                                    . "`mdt_time` = '".$mdt_time."' AND "
                                    . "`mdt_duration` = '".$mdt_duration."' AND "
                                    . "`mdt_old_data` = '0'  ".$sql_str_scale2." ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY `mdt_add_date` DESC ";
                            //echo "<br>".$sql2;
                            $result2 = mysql_query($sql2,$link);
                            if( ($result2) && (mysql_num_rows($result2) > 0) )
                            {
                                $j=0;
                                while($row2 = mysql_fetch_array($result2))
                                {
                                    if($row2['bms_id'] != '0')
                                    {
                                        
                                        
                                            $mdt_return = true;
                                            /*
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['bms_id'][$j] = $row2['bms_id'];
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['bms_type'][$j] = $row2['bms_type'];
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['bms_entry_type'][$j] = $row2['bms_entry_type'];
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['scale'][$j] = $row2['scale'];
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['scale_image'][$j] = getScaleImage($row2['scale']);
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['responce'][$j] = stripslashes($row2['remarks']);
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['my_target'][$j] = stripslashes($row2['my_target']);
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['adviser_target'][$j] = stripslashes($row2['adviser_target']);
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['mdt_time'][$j] = stripslashes($row2['mdt_time']);
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['mdt_duration'][$j] = stripslashes($row2['mdt_duration']);


                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration][$j]['bms_id'] = $row2['bms_id'];
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration][$j]['bms_type'] = $row2['bms_type'];
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration][$j]['bms_entry_type'] = $row2['bms_entry_type'];
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration][$j]['scale'] = $row2['scale'];
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration][$j]['scale_image'] = getScaleImage($row2['scale']);
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration][$j]['responce'] = stripslashes($row2['remarks']);
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration][$j]['my_target'] = stripslashes($row2['my_target']);
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration][$j]['adviser_target'] = stripslashes($row2['adviser_target']);
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration][$j]['mdt_time'] = stripslashes($row2['mdt_time']);
                                            $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration][$j]['mdt_duration'] = stripslashes($row2['mdt_duration']);

                                             * 
                                             */

                                            if($module_keyword != '' && $trigger_criteria == '')
                                            {
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['bms_id'] = $row2['bms_id'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['bms_type'] = $row2['bms_type'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['bms_entry_type'] = $row2['bms_entry_type'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['scale'] = $row2['scale'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['scale_image'] = getScaleImage($row2['scale']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['responce'] = stripslashes($row2['remarks']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['my_target'] = stripslashes($row2['my_target']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['adviser_target'] = stripslashes($row2['adviser_target']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['mdt_time'] = stripslashes($row2['mdt_time']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['mdt_duration'] = stripslashes($row2['mdt_duration']);
                                                $k++;
                                            }
                                            elseif($module_keyword != '' && $trigger_criteria != '')
                                            {
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['bms_id'] = $row2['bms_id'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['bms_type'] = $row2['bms_type'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['bms_entry_type'] = $row2['bms_entry_type'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['scale'] = $row2['scale'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['scale_image'] = getScaleImage($row2['scale']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['responce'] = stripslashes($row2['remarks']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['my_target'] = stripslashes($row2['my_target']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['adviser_target'] = stripslashes($row2['adviser_target']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['mdt_time'] = stripslashes($row2['mdt_time']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['mdt_duration'] = stripslashes($row2['mdt_duration']);
                                                $k++;
                                            }
                                            elseif($module_keyword == '' && $trigger_criteria != '')
                                            {
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['bms_id'] = $row2['bms_id'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['bms_type'] = $row2['bms_type'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['bms_entry_type'] = $row2['bms_entry_type'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['scale'] = $row2['scale'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['scale_image'] = getScaleImage($row2['scale']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['responce'] = stripslashes($row2['remarks']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['my_target'] = stripslashes($row2['my_target']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['adviser_target'] = stripslashes($row2['adviser_target']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['mdt_time'] = stripslashes($row2['mdt_time']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$k]['mdt_duration'] = stripslashes($row2['mdt_duration']);
                                                $k++;
                                            }
                                            else
                                            {
                                                $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['bms_id'][$j] = $row2['bms_id'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['bms_type'][$j] = $row2['bms_type'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['bms_entry_type'][$j] = $row2['bms_entry_type'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['scale'][$j] = $row2['scale'];
                                                $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['scale_image'][$j] = getScaleImage($row2['scale']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['responce'][$j] = stripslashes($row2['remarks']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['my_target'][$j] = stripslashes($row2['my_target']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['adviser_target'][$j] = stripslashes($row2['adviser_target']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['mdt_time'][$j] = stripslashes($row2['mdt_time']);
                                                $arr_mdt_records[$arr_mdt_date[$i]][$mdt_time_duration]['mdt_duration'][$j] = stripslashes($row2['mdt_duration']);
                                                 $j++;
                                            }
                                          
                                    }	
                                }
                            }
                            }
                        }
                   }     
                }
            }
	}
	return array($food_return,$arr_meal_date,$arr_food_records,$activity_return,$arr_activity_date,$arr_activity_records,$wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records,$bps_return,$arr_bps_date,$arr_bps_records,$bes_return,$arr_bes_date,$arr_bes_records,$aa_return,$arr_aa_records,$mt_return,$arr_mt_records,$mdt_return,$arr_mdt_date,$arr_mdt_records);

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
		$sql = "SELECT DISTINCT tuwae.wae_date FROM `tbluserswae` AS tuwae LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id WHERE tuwae.user_id = '".$user_id."' AND tuwae.wae_date >= '".$start_date."' AND tuwae.wae_date <= '".$end_date."' AND tuwae.wae_old_data = '0'  AND twae.practitioner_id = '".$pro_user_id."' ORDER BY tuwae.wae_date ASC ";
	}
	else

	{
		$sql = "SELECT DISTINCT `wae_date` FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_date` >= '".$start_date."' AND `wae_date` <= '".$end_date."' AND `wae_old_data` = '0'  ORDER BY `wae_date` ASC ";
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
				$sql2 = "SELECT tuwae.* FROM `tbluserswae` AS tuwae LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id WHERE tuwae.user_id = '".$user_id."' AND tuwae.wae_date = '".$arr_wae_date[$i]."' AND tuwae.wae_old_data = '0'  AND twae.practitioner_id = '".$pro_user_id."' ORDER BY tuwae.user_wae_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_date` = '".$arr_wae_date[$i]."' AND `wae_old_data` = '0'  ORDER BY `user_wae_id` ASC ";
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
		$sql = "SELECT DISTINCT tugs.gs_date FROM `tblusersgs` AS tugs LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id WHERE tugs.user_id = '".$user_id."' AND tugs.gs_date >= '".$start_date."' AND tugs.gs_date <= '".$end_date."' AND tugs.gs_old_data = '0' AND tgs.practitioner_id = '".$pro_user_id."' ORDER BY tugs.gs_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `gs_date` FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_date` >= '".$start_date."' AND `gs_date` <= '".$end_date."' AND `gs_old_data` = '0' ORDER BY `gs_date` ASC ";
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
				$sql2 = "SELECT tugs.* FROM `tblusersgs` AS tugs LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id WHERE tugs.user_id = '".$user_id."' AND tugs.gs_date = '".$arr_gs_date[$i]."' AND tugs.gs_old_data = '0' AND tgs.practitioner_id = '".$pro_user_id."' ORDER BY tugs.user_gs_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_date` = '".$arr_gs_date[$i]."' AND `gs_old_data` = '0' ORDER BY `user_gs_id` ASC ";
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
		$sql = "SELECT DISTINCT tusl.sleep_date FROM `tbluserssleep` AS tusl LEFT JOIN `tblsleeps` AS tsl ON tusl.selected_sleep_id = tsl.sleep_id WHERE tusl.user_id = '".$user_id."' AND tusl.sleep_date >= '".$start_date."' AND tusl.sleep_date <= '".$end_date."' AND tusl.sleep_old_data = '0'  AND tsl.practitioner_id = '".$pro_user_id."' ORDER BY tusl.sleep_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `sleep_date` FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_date` >= '".$start_date."' AND `sleep_date` <= '".$end_date."' AND `sleep_old_data` = '0'  ORDER BY `sleep_date` ASC ";
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
				$sql2 = "SELECT tusl.* FROM `tbluserssleep` AS tusl LEFT JOIN `tblsleeps` AS tsl ON tusl.selected_sleep_id = tsl.sleep_id WHERE tusl.user_id = '".$user_id."' AND tusl.sleep_date = '".$arr_sleep_date[$i]."' AND tusl.sleep_old_data = '0'  AND tsl.practitioner_id = '".$pro_user_id."' ORDER BY tusl.user_sleep_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_date` = '".$arr_sleep_date[$i]."' AND `sleep_old_data` = '0'  ORDER BY `user_sleep_id` ASC ";
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
		$sql = "SELECT DISTINCT tumc.mc_date FROM `tblusersmc` AS tumc LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id WHERE tumc.user_id = '".$user_id."' AND tumc.mc_date >= '".$start_date."' AND tumc.mc_date <= '".$end_date."' AND tumc.mc_old_data = '0'  AND tmc.practitioner_id = '".$pro_user_id."' ORDER BY tumc.mc_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `mc_date` FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_date` >= '".$start_date."' AND `mc_date` <= '".$end_date."' AND `mc_old_data` = '0'  ORDER BY `mc_date` ASC ";
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
				$sql2 = "SELECT tumc.* FROM `tblusersmc` AS tumc LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id WHERE tumc.user_id = '".$user_id."' AND tumc.mc_date = '".$arr_mc_date[$i]."' AND tumc.mc_old_data = '0'  AND tmc.practitioner_id = '".$pro_user_id."' ORDER BY tumc.user_mc_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_date` = '".$arr_mc_date[$i]."' AND `mc_old_data` = '0'  ORDER BY `user_mc_id` ASC ";
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
		$sql = "SELECT DISTINCT tumr.mr_date FROM `tblusersmr` AS tumr LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id WHERE tumr.user_id = '".$user_id."' AND tumr.mr_date >= '".$start_date."' AND tumr.mr_date <= '".$end_date."' AND tumr.mr_old_data = '0'  AND tmr.practitioner_id = '".$pro_user_id."' ORDER BY tumr.mr_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `mr_date` FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_date` >= '".$start_date."' AND `mr_date` <= '".$end_date."' AND `mr_old_data` = '0'  ORDER BY `mr_date` ASC ";
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
				$sql2 = "SELECT tumr.* FROM `tblusersmr` AS tumr LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id WHERE tumr.user_id = '".$user_id."' AND tumr.mr_date = '".$arr_mr_date[$i]."' AND tumr.mr_old_data = '0'  AND tmr.practitioner_id = '".$pro_user_id."' ORDER BY tumr.user_mr_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_date` = '".$arr_mr_date[$i]."' AND `mr_old_data` = '0'  ORDER BY `user_mr_id` ASC ";
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
		$sql = "SELECT DISTINCT tumle.mle_date FROM `tblusersmle` AS tumle LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id WHERE tumle.user_id = '".$user_id."' AND tumle.mle_date >= '".$start_date."' AND tumle.mle_date <= '".$end_date."' AND tumle.mle_old_data = '0'  AND tmle.practitioner_id = '".$pro_user_id."' ORDER BY tumle.mle_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `mle_date` FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_date` >= '".$start_date."' AND `mle_date` <= '".$end_date."' AND `mle_old_data` = '0'  ORDER BY `mle_date` ASC ";
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
				$sql2 = "SELECT tumle.* FROM `tblusersmle` AS tumle LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id WHERE tumle.user_id = '".$user_id."' AND tumle.mle_date = '".$arr_mle_date[$i]."' AND tu.mle_old_data = '0'  AND tmle.practitioner_id = '".$pro_user_id."' ORDER BY tumle.user_mle_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_date` = '".$arr_mle_date[$i]."' AND `mle_old_data` = '0'  ORDER BY `user_mle_id` ASC ";
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
		$sql = "SELECT DISTINCT tuadc.adct_date FROM `tblusersadct` AS tuadc LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id WHERE tuadc.user_id = '".$user_id."' AND tuadc.adct_date >= '".$start_date."' AND tuadc.adct_date <= '".$end_date."' AND tuadc.adct_old_data = '0'  AND tadc.practitioner_id = '".$pro_user_id."' ORDER BY tuadc.adct_date ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `adct_date` FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_date` >= '".$start_date."' AND `adct_date` <= '".$end_date."' AND `adct_old_data` = '0'  ORDER BY `adct_date` ASC ";
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
				$sql2 = "SELECT tuadc.* FROM `tblusersadct` AS tuadc LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id WHERE tuadc.user_id = '".$user_id."' AND tuadc.adct_date = '".$arr_adct_date[$i]."' AND tuadc.adct_old_data = '0'  AND tadc.practitioner_id = '".$pro_user_id."' ORDER BY tuadc.user_adct_id ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_date` = '".$arr_adct_date[$i]."' AND `adct_old_data` = '0'  ORDER BY `user_adct_id` ASC ";
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
		$sql = "SELECT DISTINCT tuwae.selected_wae_id FROM `tbluserswae` AS tuwae LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id WHERE tuwae.user_id = '".$user_id."' AND tuwae.wae_date >= '".$start_date."' AND tuwae.wae_date <= '".$end_date."' AND twae.practitioner_id = '".$pro_user_id."' AND tuwae.wae_old_data = '0'  ORDER BY tuwae.selected_wae_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_wae_id` FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_date` >= '".$start_date."' AND `wae_date` <= '".$end_date."' AND `wae_old_data` = '0'  ORDER BY `selected_wae_id` ASC ";
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
				$sql2 = "SELECT tuwae.* FROM `tbluserswae` AS tuwae LEFT JOIN `tblworkandenvironments` AS twae ON tuwae.selected_wae_id = twae.wae_id WHERE tuwae.user_id = '".$user_id."' AND tuwae.selected_wae_id = '".$arr_selected_wae_id[$i]."' AND tuwae.wae_date >= '".$start_date."' AND tuwae.wae_date <= '".$end_date."' AND twae.practitioner_id = '".$pro_user_id."' AND tuwae.wae_old_data = '0'  ORDER BY tuwae.wae_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `selected_wae_id` = '".$arr_selected_wae_id[$i]."' AND `wae_date` >= '".$start_date."' AND `wae_date` <= '".$end_date."' AND `wae_old_data` = '0'  ORDER BY `wae_date` ASC ";
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
		$sql = "SELECT DISTINCT tugs.selected_gs_id FROM `tblusersgs` AS tugs LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id WHERE tugs.user_id = '".$user_id."' AND tugs.gs_date >= '".$start_date."' AND tugs.gs_date <= '".$end_date."' AND tugs.gs_old_data = '0' AND tgs.practitioner_id = '".$pro_user_id."' ORDER BY tugs.selected_gs_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_gs_id` FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_date` >= '".$start_date."' AND `gs_date` <= '".$end_date."' AND `gs_old_data` = '0' ORDER BY `selected_gs_id` ASC ";
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
				$sql2 = "SELECT tugs.* FROM `tblusersgs` AS tugs LEFT JOIN `tblgeneralstressors` AS tgs ON tugs.selected_gs_id = tgs.gs_id WHERE tugs.user_id = '".$user_id."' AND tugs.selected_gs_id = '".$arr_selected_gs_id[$i]."' AND tugs.gs_date >= '".$start_date."' AND tugs.gs_date <= '".$end_date."' AND tugs.gs_old_data = '0' AND tgs.practitioner_id = '".$pro_user_id."' ORDER BY tugs.gs_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `selected_gs_id` = '".$arr_selected_gs_id[$i]."'AND `gs_date` >= '".$start_date."' AND `gs_date` <= '".$end_date."' AND `gs_old_data` = '0' ORDER BY `gs_date` ASC ";
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
		$sql = "SELECT DISTINCT tuslp.selected_sleep_id FROM `tbluserssleep` AS tuslp LEFT JOIN `tblsleeps` AS tslp ON tuslp.selected_sleep_id = tslp.sleep_id WHERE tuslp.user_id = '".$user_id."' AND tuslp.sleep_date >= '".$start_date."' AND tuslp.sleep_date <= '".$end_date."' AND tuslp.sleep_old_data = '0'  AND tslp.practitioner_id = '".$pro_user_id."' ORDER BY tuslp.selected_sleep_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_sleep_id` FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_date` >= '".$start_date."' AND `sleep_date` <= '".$end_date."' AND `sleep_old_data` = '0'  ORDER BY `selected_sleep_id` ASC ";
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
				$sql2 = "SELECT tuslp.* FROM `tbluserssleep` AS tuslp LEFT JOIN `tblsleeps` AS tslp ON tuslp.selected_sleep_id = tslp.sleep_id WHERE tuslp.user_id = '".$user_id."' AND tuslp.selected_sleep_id = '".$arr_selected_sleep_id[$i]."' AND tuslp.sleep_date >= '".$start_date."' AND tuslp.sleep_date <= '".$end_date."' AND tuslp.sleep_old_data = '0'  AND tslp.practitioner_id = '".$pro_user_id."' ORDER BY tuslp.sleep_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `selected_sleep_id` = '".$arr_selected_sleep_id[$i]."'AND `sleep_date` >= '".$start_date."' AND `sleep_date` <= '".$end_date."' AND `sleep_old_data` = '0'  ORDER BY `sleep_date` ASC ";
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
		$sql = "SELECT DISTINCT tumc.selected_mc_id FROM `tblusersmc` AS tumc LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id WHERE tumc.user_id = '".$user_id."' AND tumc.mc_date >= '".$start_date."' AND tumc.mc_date <= '".$end_date."' AND tumc.mc_old_data = '0'  AND tmc.practitioner_id = '".$pro_user_id."' ORDER BY tumc.selected_mc_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_mc_id` FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_date` >= '".$start_date."' AND `mc_date` <= '".$end_date."' AND `mc_old_data` = '0'  ORDER BY `selected_mc_id` ASC ";
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
				$sql2 = "SELECT tumc.* FROM `tblusersmc` AS tumc LEFT JOIN `tblmycommunications` AS tmc ON tumc.selected_mc_id = tmc.mc_id WHERE tumc.user_id = '".$user_id."' AND tumc.selected_mc_id = '".$arr_selected_mc_id[$i]."' AND tumc.mc_date >= '".$start_date."' AND tumc.mc_date <= '".$end_date."' AND tumc.mc_old_data = '0'  AND tmc.practitioner_id = '".$pro_user_id."' ORDER BY tumc.mc_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `selected_mc_id` = '".$arr_selected_mc_id[$i]."'AND `mc_date` >= '".$start_date."' AND `mc_date` <= '".$end_date."' AND `mc_old_data` = '0'  ORDER BY `mc_date` ASC ";
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
		$sql = "SELECT DISTINCT tumr.selected_mr_id FROM `tblusersmr` AS tumr LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id WHERE tumr.user_id = '".$user_id."' AND tumr.mr_date >= '".$start_date."' AND tumr.mr_date <= '".$end_date."' AND tumr.mr_old_data = '0'  AND tmr.practitioner_id = '".$pro_user_id."' ORDER BY tumr.selected_mr_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_mr_id` FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_date` >= '".$start_date."' AND `mr_date` <= '".$end_date."' AND `mr_old_data` = '0'  ORDER BY `selected_mr_id` ASC ";
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
				$sql2 = "SELECT tumr.* FROM `tblusersmr` AS tumr LEFT JOIN `tblmyrelations` AS tmr ON tumr.selected_mr_id = tmr.mr_id WHERE tumr.user_id = '".$user_id."' AND tumr.selected_mr_id = '".$arr_selected_mr_id[$i]."' AND tumr.mr_date >= '".$start_date."' AND tumr.mr_date <= '".$end_date."' AND tumr.mr_old_data = '0'  AND tmr.practitioner_id = '".$pro_user_id."' ORDER BY tumr.mr_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `selected_mr_id` = '".$arr_selected_mr_id[$i]."'AND `mr_date` >= '".$start_date."' AND `mr_date` <= '".$end_date."' AND `mr_old_data` = '0'  ORDER BY `mr_date` ASC ";
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
		$sql = "SELECT DISTINCT tumle.selected_mle_id FROM `tblusersmle` AS tumle LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id WHERE tumle.user_id = '".$user_id."' AND tumle.mle_date >= '".$start_date."' AND tumle.mle_date <= '".$end_date."' AND tumle.mle_old_data = '0'  AND tmle.practitioner_id = '".$pro_user_id."' ORDER BY tumle.selected_mle_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_mle_id` FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_date` >= '".$start_date."' AND `mle_date` <= '".$end_date."' AND `mle_old_data` = '0'  ORDER BY `selected_mle_id` ASC ";
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
				$sql2 = "SELECT tumle.* FROM `tblusersmle` AS tumle LEFT JOIN `tblmajorlifeevents` AS tmle ON tumle.selected_mle_id = tmle.mle_id WHERE tumle.user_id = '".$user_id."' AND tumle.selected_mle_id = '".$arr_selected_mle_id[$i]."' AND tumle.mle_date >= '".$start_date."' AND tumle.mle_date <= '".$end_date."' AND tumle.mle_old_data = '0'  AND tmle.practitioner_id = '".$pro_user_id."' ORDER BY tumle.mle_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `selected_mle_id` = '".$arr_selected_mle_id[$i]."'AND `mle_date` >= '".$start_date."' AND `mle_date` <= '".$end_date."' AND `mle_old_data` = '0'  ORDER BY `mle_date` ASC ";
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
		$sql = "SELECT DISTINCT tuadc.selected_adct_id FROM `tblusersadct` AS tuadc LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id WHERE tuadc.user_id = '".$user_id."' AND tuadc.adct_date >= '".$start_date."' AND tuadc.adct_date <= '".$end_date."' AND tuadc.adct_old_data = '0'  AND tadc.practitioner_id = '".$pro_user_id."' ORDER BY tuadc.selected_adct_id ASC ";
	}
	else
	{
		$sql = "SELECT DISTINCT `selected_adct_id` FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_date` >= '".$start_date."' AND `adct_date` <= '".$end_date."' AND `adct_old_data` = '0'  ORDER BY `selected_adct_id` ASC ";
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
				$sql2 = "SELECT tuadc.* FROM `tblusersadct` AS tuadc LEFT JOIN `tbladdictions` AS tadc ON tuadc.selected_adct_id = tadc.adct_id WHERE tuadc.user_id = '".$user_id."' AND tuadc.selected_adct_id = '".$arr_selected_adct_id[$i]."' AND tuadc.adct_date >= '".$start_date."' AND tuadc.adct_date <= '".$end_date."' AND tuadc.adct_old_data = '0'  AND tadc.practitioner_id = '".$pro_user_id."' ORDER BY tuadc.adct_date ASC ";
			}
			else
			{
				$sql2 = "SELECT * FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `selected_adct_id` = '".$arr_selected_adct_id[$i]."'AND `adct_date` >= '".$start_date."' AND `adct_date` <= '".$end_date."' AND `adct_old_data` = '0'  ORDER BY `adct_date` ASC ";
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