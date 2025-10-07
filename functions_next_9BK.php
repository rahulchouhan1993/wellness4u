<?php
function getUserTotalCalIntakeOfDate($user_id,$meal_date)
{
    global $link;
    $sql = "SELECT * FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` = '".$meal_date."' ORDER BY `user_meal_id` ASC ";
    //echo "<br>".$sql;
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $temp_total_calorie_intake_one_day = 0.00;	
        while ($row = mysql_fetch_assoc($result))
        {
            $temp_total_calorie_intake_one_day += getCalorieIntakeOfMeal($row['meal_id'],$row['meal_quantity']);	
        }
        $calorie_intake = $temp_total_calorie_intake_one_day;	
    }
    else
    {
        $calorie_intake = 'NA';	
    }
    
    return $calorie_intake;
}

function getDayOfWeekOptions($day_of_week)
{
    global $link;
    $option_str = '';
    
    $arr_day_of_week = array (
        1 => 'Sunday',
        2 => 'Monday',
        3 => 'Tuesday',
        4 => 'Wednesday',
        5 => 'Thursday',
        6 => 'Friday',
        7 => 'Saturday'
    );

    foreach($arr_day_of_week as $k => $v )
    {
            if($k == $day_of_week)
            {
                $selected = ' selected ';
            }
            else
            {
                $selected = '';
            }
            $option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';
    }	
    return $option_str;
}

function getModuleWiseCriteriaScaleOptions($user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range)
{
    global $link;
    $option_str = '';
    
    //echo 'module_criteria = '.$module_criteria;
    
    if($module_criteria == '6')
    {
        $arr_scale_range = array (
            5 => '=(Equal)'
        );
    }   
    elseif($module_criteria == '7')
    {
        $arr_scale_range = array (
            5 => '=(Equal)',
            6 => 'Range'
        );
    } 
    else
    {
        $arr_scale_range = array (
            1 => '<(Less Than)',
            2 => '>(Greater Than)',
            3 => ' &le; (Less than or Equal to)',
            4 => ' &ge; (Greater than or Equal to)',
            5 => '=(Equal)',
            6 => 'Range'
        );
    }
        
    foreach($arr_scale_range as $k => $v )
    {
        if($k == $criteria_scale_range)
        {
            $selected = ' selected ';
        }
        else
        {
            $selected = '';
        }
        $option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';
    }	
    return $option_str;
}

function getModuleWiseCriteriaScaleOptionsPCM($report_module,$module_criteria,$criteria_scale_range)
{
    global $link;
    $option_str = '';
    
    //echo 'module_criteria = '.$module_criteria;
    
    if($module_criteria == '6')
    {
        $arr_scale_range = array (
            5 => '=(Equal)'
        );
    }   
    elseif($module_criteria == '7')
    {
        $arr_scale_range = array (
            5 => '=(Equal)',
            6 => 'Range'
        );
    } 
    else
    {
        $arr_scale_range = array (
            1 => '<(Less Than)',
            2 => '>(Greater Than)',
            3 => ' &le; (Less than or Equal to)',
            4 => ' &ge; (Greater than or Equal to)',
            5 => '=(Equal)',
            6 => 'Range'
        );
    }
        
    foreach($arr_scale_range as $k => $v )
    {
        if($k == $criteria_scale_range)
        {
            $selected = ' selected ';
        }
        else
        {
            $selected = '';
        }
        $option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';
    }	
    return $option_str;
}

function getTriggerCriteriaOptions($user_id,$trigger_criteria)
{
	global $link;
	$option_str = '';
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'bms'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN (".$bms_id_str.") AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'bms_'.$row['bms_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';
                }
            }
        }
        
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'adct'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tbladdictions` WHERE `adct_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'adct_'.$row['adct_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'sleep'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblsleeps` WHERE `sleep_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'sleep_'.$row['sleep_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'gs'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblgeneralstressors` WHERE `gs_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'gs_'.$row['gs_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'wae'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblworkandenvironments` WHERE `wae_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'wae_'.$row['wae_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
	$bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'mc'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblmycommunications` WHERE `mc_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'mc_'.$row['mc_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'mr'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblmyrelations` WHERE `mr_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'mr_'.$row['mr_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'mle'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblmajorlifeevents` WHERE `mle_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'mle_'.$row['mle_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
       
        
        return $option_str;
}

function getTriggerCriteriaOptionsPCM($trigger_criteria)
{
	global $link;
	$option_str = '';
        
        
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'bms_'.$row['bms_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';
                }
            }
       
        
        
        
            $sql = "SELECT * FROM `tbladdictions` WHERE `status` = '1' ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'adct_'.$row['adct_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        
        
        
            $sql = "SELECT * FROM `tblsleeps` WHERE `status` = '1' ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'sleep_'.$row['sleep_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        
        
        
            $sql = "SELECT * FROM `tblgeneralstressors` WHERE `status` = '1' ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'gs_'.$row['gs_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        
        
        
            $sql = "SELECT * FROM `tblworkandenvironments` WHERE `status` = '1' ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'wae_'.$row['wae_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        
        
	
            $sql = "SELECT * FROM `tblmycommunications` WHERE `status` = '1' ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'mc_'.$row['mc_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        
        
       
            $sql = "SELECT * FROM `tblmyrelations` WHERE `status` = '1' ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'mr_'.$row['mr_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        
        
        
            $sql = "SELECT * FROM `tblmajorlifeevents` WHERE `status` = '1' ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'mle_'.$row['mle_id'];
                    if($chk_val == $trigger_criteria )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        
        
       
        
        return $option_str;
}

function getModuleWiseCriteriaOptions($user_id,$report_module,$pro_user_id,$module_criteria)
{
    global $link;
    $option_str = '';
    
    if($report_module == 'activity_report' || $report_module == '14')
    {
        if($module_criteria == '3')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="3" '.$sel.'>Duration</option>';
        
        if($module_criteria == '4')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="4" '.$sel.'>Time</option>';
    }
    elseif($report_module == 'activity_analysis_report' || $report_module == '4')
    {
        if($module_criteria == '3')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="3" '.$sel.'>Duration</option>';
        
        if($module_criteria == '4')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="4" '.$sel.'>Time</option>';
        
        if($module_criteria == '8')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="8" '.$sel.'>Calories Burnt</option>';
    }
    elseif($report_module == 'food_report' || $report_module == '1')
    {
        if($module_criteria == '4')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="4" '.$sel.'>Time</option>';
        
        if($module_criteria == '5')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="5" '.$sel.'>Quantity</option>';
        
        if($module_criteria == '6')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="6" '.$sel.'>My Desire</option>';
    }
    elseif($report_module == 'meal_time_report' || $report_module == '5')
    {
        if($module_criteria == '4')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="4" '.$sel.'>Time</option>';
    }
    elseif($report_module == 'bps_report' || $report_module == '22')
    {
         
    }
    elseif($report_module == 'mdt_report' || $report_module == '24' )
    {
        if($module_criteria == '9')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="9" '.$sel.'>Triggers</option>';
        if($module_criteria == '3')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="3" '.$sel.'>Duration</option>';
        
        if($module_criteria == '4')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="4" '.$sel.'>Time</option>';
         
    }
    elseif($report_module == '')
    {
         
    }
    else 
    {
        /*
        if($module_criteria == '1')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="1" '.$sel.'>My Target</option>';

        if($module_criteria == '2')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="2" '.$sel.'>My Adviser Target</option>';
         * 
         */
    }
    
    if($module_criteria == '7')
    {
        $sel = ' selected ';
    }
    else
    {
        $sel = '';
    }		
    $option_str .= '<option value="7" '.$sel.'>Days</option>';
    
    return $option_str;
}

function getModuleWiseCriteriaOptionsPCM($report_module,$module_criteria)
{
    global $link;
    $option_str = '';
    
    if($report_module == '12')
    {
        if($module_criteria == '3')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="3" '.$sel.'>Duration</option>';
        
        if($module_criteria == '4')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="4" '.$sel.'>Time</option>';
        
        if($module_criteria == '8')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="8" '.$sel.'>Calories Burnt</option>';
    }
    elseif($report_module == '13')
    {
        if($module_criteria == '4')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="4" '.$sel.'>Time</option>';
        
        if($module_criteria == '5')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="5" '.$sel.'>Quantity</option>';
        
        if($module_criteria == '6')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="6" '.$sel.'>My Desire</option>';
    }
    elseif($report_module == '113')
    {
         
    }
    elseif($report_module == '45' )
    {
        /*
        if($module_criteria == '9')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="9" '.$sel.'>Triggers</option>';
         * 
         */
        if($module_criteria == '3')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="3" '.$sel.'>Duration</option>';
        
        if($module_criteria == '4')
        {
            $sel = ' selected ';
        }
        else
        {
            $sel = '';
        }		
        $option_str .= '<option value="4" '.$sel.'>Time</option>';
         
    }
    elseif($report_module == '')
    {
         
    }
    else 
    {
        
    }
    
    if($module_criteria == '7')
    {
        $sel = ' selected ';
    }
    else
    {
        $sel = '';
    }		
    $option_str .= '<option value="7" '.$sel.'>Days</option>';
    
    return $option_str;
}

function getModuleWiseCriteriaScaleValues($user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value)
{
    global $link;
    $option_str = '';
    if($criteria_scale_range == '')
    {
        $div_start_criteria_scale_value = 'none';
        $div_end_criteria_scale_value = 'none';
        $start_criteria_scale_value = '';
        $end_criteria_scale_value = '';
    }
    elseif($criteria_scale_range == '6')
    {
        $div_start_criteria_scale_value = '';
        $div_end_criteria_scale_value = '';
        $option_str .= '<span class="Header_brown"><strong>Criteria Value:</strong>&nbsp;&nbsp;&nbsp;</span>';
    }
    else
    {
        $div_start_criteria_scale_value = '';
        $div_end_criteria_scale_value = 'none';
        $end_criteria_scale_value = '';
        $option_str .= '<span class="Header_brown"><strong>Criteria Value:</strong>&nbsp;&nbsp;&nbsp;</span>';
    }
    
    //echo 'module_criteria = '.$module_criteria; 
    if($module_criteria == '1' || $module_criteria == '2' || $module_criteria == '9')
    {
        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">
                        <select name="start_criteria_scale_value" id="start_criteria_scale_value" style="width:50px;">
                        ';
        for($i=1;$i<=10;$i++)
        {
            if($i == $start_criteria_scale_value)
            {
                $sel = ' selected ';
            }
            else
            {
                $sel = '';
            }		
            $option_str .= '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
        }    
        $option_str .= '</select></span>';
        
        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">
                        &nbsp; - &nbsp;
                        <select name="end_criteria_scale_value" id="end_criteria_scale_value" style="width:50px;">
                        ';
        for($i=1;$i<=10;$i++)
        {
            if($i == $end_criteria_scale_value)
            {
                $sel = ' selected ';
            }
            else
            {
                $sel = '';
            }		
            $option_str .= '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
        }    
        $option_str .= '</select></span>';
    }
    elseif($module_criteria == '4' )
    {
        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">';
        $option_str .= '<select name="start_criteria_scale_value" id="start_criteria_scale_value" style="width:100px;">
                        ';
        $option_str .= getTimeOptions(0,24,$start_criteria_scale_value);
        $option_str .= '</select>';
        $option_str .= '</span>';
        
        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">
                        &nbsp; - &nbsp;';
        $option_str .= '<select name="end_criteria_scale_value" id="end_criteria_scale_value" style="width:100px;">
                        ';
        $option_str .= getTimeOptions(0,24,$end_criteria_scale_value);
        $option_str .= '</select>';
        $option_str .= '</span>';
    }
    elseif($module_criteria == '5' )
    {
        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">';
        $option_str .= '<select name="start_criteria_scale_value" id="start_criteria_scale_value" style="width:100px;">
                        ';
        $option_str .= getMealQuantityOptions($start_criteria_scale_value);
        $option_str .= '</select>';
        $option_str .= '</span>';
        
        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">
                        &nbsp; - &nbsp;';
        $option_str .= '<select name="end_criteria_scale_value" id="end_criteria_scale_value" style="width:100px;">
                        ';
        $option_str .= getMealQuantityOptions($end_criteria_scale_value);
        $option_str .= '</select>';
        $option_str .= '</span>';
    }
    elseif($module_criteria == '6' )
    {
        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">';
        $option_str .= '<select name="start_criteria_scale_value" id="start_criteria_scale_value" style="width:100px;">
                        ';
        $option_str .= getMealLikeOptions($start_criteria_scale_value);
        $option_str .= '</select>';
        $option_str .= '</span>';
        
        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">';
        $option_str .= '<input type="hidden" name="end_criteria_scale_value" id="end_criteria_scale_value" value="'.$end_criteria_scale_value.'">';
        $option_str .= '</span>';
    }
    elseif($module_criteria == '7' )
    {
        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">';
        $option_str .= '<select name="start_criteria_scale_value" id="start_criteria_scale_value" style="width:100px;">
                        ';
        $option_str .= getDayOfWeekOptions($start_criteria_scale_value);
        $option_str .= '</select>';
        $option_str .= '</span>';
        
        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">&nbsp; - &nbsp';
        $option_str .= '<select name="end_criteria_scale_value" id="end_criteria_scale_value" style="width:100px;">
                        ';
        $option_str .= getDayOfWeekOptions($end_criteria_scale_value);
        $option_str .= '</select>';
        $option_str .= '</span>';
    }
    elseif($module_criteria == '3')
    {
        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">
                        <input style="width:50px;" maxlength="3" type="text" name="start_criteria_scale_value" id="start_criteria_scale_value" value="'.$start_criteria_scale_value.'"> (Mins)</span>';
        
        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">&nbsp; - &nbsp;
                        <input style="width:50px;" maxlength="3" type="text" name="end_criteria_scale_value" id="end_criteria_scale_value" value="'.$end_criteria_scale_value.'"> (Mins)</span>';
    }
    elseif($module_criteria == '8')
    {
        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">
                        <input style="width:50px;" maxlength="4" type="text" name="start_criteria_scale_value" id="start_criteria_scale_value" value="'.$start_criteria_scale_value.'"></span>';
        
        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">&nbsp; - &nbsp;
                        <input style="width:50px;" maxlength="4" type="text" name="end_criteria_scale_value" id="end_criteria_scale_value" value="'.$end_criteria_scale_value.'"></span>';
    }
    else
    {
        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">
                        <input type="hidden" name="start_criteria_scale_value" id="start_criteria_scale_value" value="'.$start_criteria_scale_value.'"></span>';
        
        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">
                        <input type="hidden" name="end_criteria_scale_value" id="end_criteria_scale_value" value="'.$end_criteria_scale_value.'"></span>';
    }
    
  
    return $option_str;
}



function getModuleWiseKeywordsOptions($user_id,$report_module,$pro_user_id,$module_keyword)
{
    global $link;
    $option_str = '';
    if($pro_user_id == '')
    {
        $sql_str_pro = "";
    }
    else
    {
        $sql_str_pro = " AND `practitioner_id` = '".$pro_user_id."' ";
    }
    
    //echo '<br>user_id = '.$user_id.' , report_module = '.$report_module;
    
    if($report_module == 'wae_report' || $report_module == '15')
    {
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `selected_wae_id` FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['selected_wae_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        $sql = "SELECT * FROM `tblworkandenvironments` WHERE `wae_id` IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `wae_add_date` DESC ";
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
                
                if($pro_user_id == '' || $pro_user_id == '0')
                {
                    //echo '<br>in if';
                    $add_to_record = true;
                }
                else
                {
                    //echo '<br>in else';
                    $add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
                }
                

                if($add_to_record)
                {
                    if($row['wae_id'] == $module_keyword)
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['wae_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }	
            }
        }
    }
    elseif($report_module == 'gs_report' || $report_module == '16')
    {
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `selected_gs_id` FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['selected_gs_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        $sql = "SELECT * FROM `tblgeneralstressors` WHERE `gs_id` IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `gs_add_date` DESC ";
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

                if($pro_user_id == '' || $pro_user_id == '0')
                {
                    //echo '<br>in if';
                    $add_to_record = true;
                }
                else
                {
                    //echo '<br>in else';
                    $add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
                }

                if($add_to_record)
                {
                    if($row['gs_id'] == $module_keyword)
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['gs_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }	
            }
        }
    }
    elseif($report_module == 'sleep_report' || $report_module == '17')
    {
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `selected_sleep_id` FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['selected_sleep_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        $sql = "SELECT * FROM `tblsleeps` WHERE `sleep_id` IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `sleep_add_date` DESC ";
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

                if($pro_user_id == '' || $pro_user_id == '0')
                {
                    //echo '<br>in if';
                    $add_to_record = true;
                }
                else
                {
                    //echo '<br>in else';
                    $add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
                }

                if($add_to_record)
                {
                    if($row['sleep_id'] == $module_keyword)
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['sleep_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }	
            }
        }
    }
    elseif($report_module == 'mc_report' || $report_module == '18')
    {
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `selected_mc_id` FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['selected_mc_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        $sql = "SELECT * FROM `tblmycommunications` WHERE `mc_id` IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `mc_add_date` DESC ";
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

                if($pro_user_id == '' || $pro_user_id == '0')
                {
                    //echo '<br>in if';
                    $add_to_record = true;
                }
                else
                {
                    //echo '<br>in else';
                    $add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
                }
                
                if($add_to_record)
                {
                    if($row['mc_id'] == $module_keyword)
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['mc_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }	
            }
        }
    }
    elseif($report_module == 'mr_report' || $report_module == '19')
    {
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `selected_mr_id` FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['selected_mr_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        $sql = "SELECT * FROM `tblmyrelations` WHERE `mr_id` IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `mr_add_date` DESC ";
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

                if($pro_user_id == '' || $pro_user_id == '0')
                {
                    //echo '<br>in if';
                    $add_to_record = true;
                }
                else
                {
                    //echo '<br>in else';
                    $add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
                }

                if($add_to_record)
                {
                    if($row['mr_id'] == $module_keyword)
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['mr_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }	
            }
        }
    }
    elseif($report_module == 'mle_report' || $report_module == '20')
    {
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `selected_mle_id` FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['selected_mle_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        $sql = "SELECT * FROM `tblmajorlifeevents` WHERE mle_id IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `mle_add_date` DESC ";
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

                if($pro_user_id == '' || $pro_user_id == '0')
                {
                    //echo '<br>in if';
                    $add_to_record = true;
                }
                else
                {
                    //echo '<br>in else';
                    $add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
                }

                if($add_to_record)
                {
                    if($row['mle_id'] == $module_keyword)
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['mle_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }	
            }
        }
    }
    elseif($report_module == 'adct_report' || $report_module == '21')
    {
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `selected_adct_id` FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['selected_adct_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        $sql = "SELECT * FROM `tbladdictions` WHERE `adct_id` IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `adct_add_date` DESC ";
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

                if($pro_user_id == '' || $pro_user_id == '0')
                {
                    //echo '<br>in if';
                    $add_to_record = true;
                }
                else
                {
                    //echo '<br>in else';
                    $add_to_record = chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);
                }

                if($add_to_record)
                {
                    if($row['adct_id'] == $module_keyword)
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['adct_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }	
            }
        }
    }
    elseif($report_module == 'bps_report' || $report_module == '22')
    {
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersbps` WHERE `user_id` = '".$user_id."' AND `bps_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN (".$bms_id_str.") AND `bmst_id` = '1' AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                if($row['bms_id'] == $module_keyword)
                {
                    $sel = ' selected ';
                }
                else
                {
                    $sel = '';
                }		
                $option_str .= '<option value="'.$row['bms_id'].'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';
            }
        }
    }
    elseif($report_module == 'bes_report' || $report_module == '23')
    {
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersbes` WHERE `user_id` = '".$user_id."' AND `bes_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN (".$bms_id_str.") AND `bmst_id` = '2' `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                if($row['bms_id'] == $module_keyword)
                {
                    $sel = ' selected ';
                }
                else
                {
                    $sel = '';
                }		
                $option_str .= '<option value="'.$row['bms_id'].'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';
            }
        }
    }
    elseif($report_module == 'mdt_report' || $report_module == '24')
    {
        $bms_id_str = '';
        /*
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        
        if($bms_id_str != '')
        {
            //$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN (".$bms_id_str.") AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    if($row['bms_id'] == $module_keyword)
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['bms_id'].'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';
                }
            }
        }
         * 
         */
        
        
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'bms'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN (".$bms_id_str.") AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'bms_'.$row['bms_id'];
                    if($chk_val == $module_keyword )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';
                }
            }
        }
        
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'adct'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tbladdictions` WHERE `adct_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'adct_'.$row['adct_id'];
                    if($chk_val == $module_keyword )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'sleep'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblsleeps` WHERE `sleep_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'sleep_'.$row['sleep_id'];
                    if($chk_val == $module_keyword )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'gs'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblgeneralstressors` WHERE `gs_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'gs_'.$row['gs_id'];
                    if($chk_val == $module_keyword )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'wae'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblworkandenvironments` WHERE `wae_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'wae_'.$row['wae_id'];
                    if($chk_val == $module_keyword )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
	$bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'mc'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblmycommunications` WHERE `mc_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'mc_'.$row['mc_id'];
                    if($chk_val == $module_keyword )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'mr'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblmyrelations` WHERE `mr_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'mr_'.$row['mr_id'];
                    if($chk_val == $module_keyword )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'mle'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['bms_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        if($bms_id_str != '')
        {
            $sql = "SELECT * FROM `tblmajorlifeevents` WHERE `mle_id` IN (".$bms_id_str.") ORDER BY situation";
            //echo '<br>'.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $chk_val = 'mle_'.$row['mle_id'];
                    if($chk_val == $module_keyword )
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';
                }
            }
        }
        
        
        
        
    }
    elseif($report_module == 'food_report' || $report_module == '1')
    {
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `meal_id` FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['meal_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        $veg_str = " WHERE `meal_id` IN (".$bms_id_str.") ";
	list($food_veg_nonveg,$beef,$pork) = getFoodVegNonVegOfUser($user_id);
	if($food_veg_nonveg == 'V')
	{
            $veg_str .= " AND `food_veg_nonveg` != 'NV' AND `food_veg_nonveg` != 'E' AND `food_veg_nonveg` != 'B' AND `food_veg_nonveg` != 'P' ";
	}
	elseif($food_veg_nonveg == 'VE')
	{
            $veg_str .= " AND `food_veg_nonveg` != 'NV' AND `food_veg_nonveg` != 'B' AND `food_veg_nonveg` != 'P' ";
	}
	else
	{
            if($beef == '0')
            {
                $veg_str .= " AND `food_veg_nonveg` != 'B' ";
                if($pork == '0')
                {
                    $veg_str .= " AND `food_veg_nonveg` != 'P' ";
                }
            }
            else
            {
                if($pork == '0')
                {
                    $veg_str .= " AND `food_veg_nonveg` != 'P' ";
                }	
            }	
	}
	
	$sql = "SELECT * FROM `tbldailymeals` ".$veg_str." ORDER BY `meal_item` ASC";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                if($row['meal_id'] == $module_keyword)
                {
                    $sel = ' selected ';
                }
                else
                {
                    $sel = '';
                }		
                $option_str .= '<option value="'.$row['meal_id'].'" '.$sel.'>'.stripslashes($row['meal_item']).'</option>';
            }
        }
    }
    elseif($report_module == 'activity_report' || $report_module == 'activity_analysis_report' || $report_module == '4' || $report_module == '14')
    {
        $bms_id_str = '';
        $sql = "SELECT DISTINCT `activity_id` FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' ";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                $bms_id_str .= $row['activity_id'].',';
            }
            $bms_id_str = substr($bms_id_str, 0,-1);
        }
        
        $sql = "SELECT * FROM `tbldailyactivity` WHERE `activity_id` IN (".$bms_id_str.") ORDER BY `activity` ASC";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $return = true;
            while ($row = mysql_fetch_assoc($result)) 
            {
                if($row['activity_id'] == $module_keyword)
                {
                    $sel = ' selected ';
                }
                else
                {
                    $sel = '';
                }		
                $option_str .= '<option value="'.$row['activity_id'].'" '.$sel.'>'.stripslashes($row['activity']).'</option>';
            }
        }
    }
    return $option_str;
}

function chkIfBPSBodyPartAndSympotomAlreadyExists($user_id,$bps_date,$bp_id,$bms_id)
{
    global $link;
    $return = false;
    
    $sql = "SELECT * FROM `tblusersbps` WHERE `user_id` = '".$user_id."' AND `bps_date` = '".$bps_date."' AND `bp_id` = '".$bp_id."' AND FIND_IN_SET('".$bms_id."', bms_id) > 0 AND `bps_old_data` = '0' ";
    //echo '<br>'.$sql;
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $return = true;
    }
    
    return $return;
}

//function getScaleSliderCode($i,$tr_response_img[$i],$tr_response_slider[$i],$scale_arr[$i])
function getScaleSliderCode($i,$tr_response_img,$tr_response_slider,$scale_val)
{
    global $link;
    $output = '';
    
    $output .= '<div id="tr_response_img_'.$i.'" style="display:'.$tr_response_img.'">';
	//$output .= '        <img border="0" src="images/scale_slider.jpg" width="427"  />';
        $output .= '        <img border="0" src="images/scale_slider.jpg"  />';
	
	$output .= '</div>';
	$output .= '<div id="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider.'">';
	$output .= '        <select name="scale[]" id="scale_'.$i.'" style="display:none;">';
	$output .= '		<option value="0">Very Low</option>';
                            for($j=1;$j<=10;$j++)
                            {
                                if($scale_val == $j) 
                                {
                                    $sel = ' selected="selected" ';
                                }
                                else
                                {
                                    $sel = '';
                                }

                                if( ($j >= 0) && ($j <= 2) )
                                {
                                    $val = " (Very Low)";
                                }
                                elseif( ($j >= 3) && ($j <= 4) )
                                {
                                    $val = " (Low)";
                                }
                                elseif( ($j >= 5) && ($j <= 6) )
                                {
                                    $val = " (Average)";
                                }
                                elseif( ($j >= 7) && ($j <= 8) )
                                {
                                    $val = " (High)";
                                }
                                else
                                {
                                    $val = " (Very High)";
                                }
			
	$output .= '		<option value="'.$j.'" '.$sel.'>'.$val.'</option>';
                            }	
	$output .= '        </select>';
	$output .= '        </div>';
    
    return $output;
}

function getScaleSliderCodeMultiLevel($i,$tr_response_img,$tr_response_slider,$scale_val)
{
    global $link;
    $output = '';
    
    $output .= '<div id="tr_response_img_'.$i.'" style="display:'.$tr_response_img.'">';
	//$output .= '        <img border="0" src="images/scale_slider.jpg" width="427"  />';
        $output .= '        <img border="0" src="images/scale_slider.jpg"  />';
	
	$output .= '</div>';
	$output .= '<div id="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider.'">';
	$output .= '        <select name="scale_'.$i.'" id="scale_'.$i.'" style="display:none;">';
	$output .= '		<option value="0">Very Low</option>';
                            for($j=1;$j<=10;$j++)
                            {
                                if($scale_val == $j) 
                                {
                                    $sel = ' selected="selected" ';
                                }
                                else
                                {
                                    $sel = '';
                                }

                                if( ($j >= 0) && ($j <= 2) )
                                {
                                    $val = " (Very Low)";
                                }
                                elseif( ($j >= 3) && ($j <= 4) )
                                {
                                    $val = " (Low)";
                                }
                                elseif( ($j >= 5) && ($j <= 6) )
                                {
                                    $val = " (Average)";
                                }
                                elseif( ($j >= 7) && ($j <= 8) )
                                {
                                    $val = " (High)";
                                }
                                else
                                {
                                    $val = " (Very High)";
                                }
			
	$output .= '		<option value="'.$j.'" '.$sel.'>'.$val.'</option>';
                            }	
	$output .= '        </select>';
	$output .= '        </div>';
    
    return $output;
}

function getScaleSliderCodeSecond($i,$tr_response_img,$tr_response_slider,$scale_val)
{
    global $link;
    $output = '';
    
    $output .= '<div id="tr_response_img_t_'.$i.'" style="display:'.$tr_response_img.'">';
    $output .= '        <img border="0" src="images/scale_slider.jpg"  />';
	
	$output .= '</div>';
	$output .= '<div id="tr_response_slider_t_'.$i.'" style="display:'.$tr_response_slider.'">';
	$output .= '        <select name="scale_t[]" id="scale_t_'.$i.'" style="display:none;">';
	$output .= '		<option value="0">Very Low</option>';
                            for($j=1;$j<=10;$j++)
                            {
                                if($scale_val == $j) 
                                {
                                    $sel = ' selected="selected" ';
                                }
                                else
                                {
                                    $sel = '';
                                }

                                if( ($j >= 0) && ($j <= 2) )
                                {
                                    $val = " (Very Low)";
                                }
                                elseif( ($j >= 3) && ($j <= 4) )
                                {
                                    $val = " (Low)";
                                }
                                elseif( ($j >= 5) && ($j <= 6) )
                                {
                                    $val = " (Average)";
                                }
                                elseif( ($j >= 7) && ($j <= 8) )
                                {
                                    $val = " (High)";
                                }
                                else
                                {
                                    $val = " (Very High)";
                                }
			
	$output .= '		<option value="'.$j.'" '.$sel.'>'.$val.'</option>';
                            }	
	$output .= '        </select>';
	$output .= '        </div>';
    
    return $output;
}

function getScaleSliderCodeSecondMultiLevel($i,$tr_response_img,$tr_response_slider,$scale_val)
{
    global $link;
    $output = '';
    
    $output .= '<div id="tr_response_img_t_'.$i.'" style="display:'.$tr_response_img.'">';
    $output .= '        <img border="0" src="images/scale_slider.jpg"  />';
	
	$output .= '</div>';
	$output .= '<div id="tr_response_slider_t_'.$i.'" style="display:'.$tr_response_slider.'">';
	$output .= '        <select name="scale_t_'.$i.'" id="scale_t_'.$i.'" style="display:none;">';
	$output .= '		<option value="0">Very Low</option>';
                            for($j=1;$j<=10;$j++)
                            {
                                if($scale_val == $j) 
                                {
                                    $sel = ' selected="selected" ';
                                }
                                else
                                {
                                    $sel = '';
                                }

                                if( ($j >= 0) && ($j <= 2) )
                                {
                                    $val = " (Very Low)";
                                }
                                elseif( ($j >= 3) && ($j <= 4) )
                                {
                                    $val = " (Low)";
                                }
                                elseif( ($j >= 5) && ($j <= 6) )
                                {
                                    $val = " (Average)";
                                }
                                elseif( ($j >= 7) && ($j <= 8) )
                                {
                                    $val = " (High)";
                                }
                                else
                                {
                                    $val = " (Very High)";
                                }
			
	$output .= '		<option value="'.$j.'" '.$sel.'>'.$val.'</option>';
                            }	
	$output .= '        </select>';
	$output .= '        </div>';
    
    return $output;
}

function getUsersSleepQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_sleep_id_arr,$old_my_target_arr,$old_adviser_target_arr)
{
    global $link;
    $output = '';
    
    $sleep_date = $year.'-'.$month.'-'.$day;

    $tr_response_img = array();
    $tr_response_slider = array();

    list($arr_sleep_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getSleepQuestions($user_id,$sleep_date,$pro_user_id);
    $cnt = count($arr_sleep_id);
    for($i=0;$i<$cnt;$i++)
    {
        $tr_response_img[$i] = '';
        $tr_response_slider[$i] = 'none';
    }

    //list($old_scale_arr,$old_remarks_arr,$old_selected_sleep_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersSleepQuestionDetails($user_id,$sleep_date,$pro_user_id);

    $selected_sleep_id_arr = array(); 
    $scale_arr = array(); 
    $remarks_arr = array(); 
    $my_target = array();
    $adviser_target = array();
	
    $j = 0;
    for($i=0;$i<count($arr_sleep_id);$i++)
    {
        if(in_array($arr_sleep_id[$i],$old_selected_sleep_id_arr))
        {
            $key = array_search($arr_sleep_id[$i], $old_selected_sleep_id_arr);

            $tr_response_img[$i] = 'none';
            $tr_response_slider[$i] = '';
            $selected_sleep_id_arr[$i] = $old_selected_sleep_id_arr[$key];
            $scale_arr[$i] = $old_scale_arr[$key];
            $remarks_arr[$i] = $old_remarks_arr[$key];
            $my_target_arr[$i] = $old_my_target_arr[$key];
            $adviser_target_arr[$i] = $old_adviser_target_arr[$key];
            $j++;
        }
        else
        {
            $tr_response_img[$i] = '';
            $tr_response_slider[$i] = 'none';
            $selected_sleep_id_arr[$i] = '';
            $scale_arr[$i] = 0;
            $remarks_arr[$i] = '';
            list($my_target_arr[$i], $adviser_target_arr[$i]) = getUsersLastMyTargetSleepValue($user_id,$pro_user_id,$arr_sleep_id[$i]);
        }
    }
	
    $output = '';
    $output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tblsleep">';
    if(count($arr_sleep_id) > 0)
    {
        for($i=0;$i<count($arr_sleep_id);$i++)
        { 
	$output .= '<tr style="display:none" valign="top">';
	$output .= '	<td align="left" colspan="2" class="err_msg" valign="top"></td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '	<td align="left" colspan="2" valign="top">&nbsp;</td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '	<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';
	$output .= '	<td width="430" height="35" align="left" valign="top">';
			if($selected_sleep_id_arr[$i] == $arr_sleep_id[$i]) 
			{
                            $field_disable = '';
                            $chked = ' checked="checked" ';
			}
			else
			{
                            $field_disable = ' disabled="disabled" ';
                            $chked = '';
			}
	$output .= '        <input type="checkbox" name="selected_sleep_id_'.$i.'" id="selected_sleep_id_'.$i.'" value="'.$arr_sleep_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_sleep_id_\',\''.$i.'\')" />&nbsp;<strong><span style="font-family:'.$arr_situation_font_family[$i].';font-size:'.$arr_situation_font_size[$i].'px;color:#'.$arr_situation_font_color[$i].';">'.$arr_situation[$i].'</span></strong>';
	$output .= '	</td>';
	$output .= '</tr>';
	
        $output .= '<tr>';
	$output .= '	<td width="130" height="45" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';
	$output .= '	<td width="430" height="45" align="left" valign="top">';
	$output .= getScaleSliderCode($i,$tr_response_img[$i],$tr_response_slider[$i],$scale_arr[$i]);
	$output .= '	</td>';
	$output .= '</tr>';
        
	$output .= '<tr>';
	$output .= '	<td align="left" colspan="2" valign="top">&nbsp;</td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '	<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';
	$output .= '	<td width="430" align="left" valign="top">';
	$output .= '        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3" >'.$remarks_arr[$i].'</textarea></div>';
        $output .= '        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><textarea name="remarks2[]" id="remarks2_'.$i.'" cols="25" rows="3" disabled></textarea></div>';
	$output .= '	</td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '    <td align="left" colspan="2" valign="top">&nbsp;</td>';
	$output .= '</tr>';
        $output .= '<tr>'
                . '     <td align="left" colspan="2" valign="top">
                            <table width="560" border="0" cellspacing="0" cellpadding="0">
                                <tr>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; My Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="my_target[]" id="my_target_'.$i.'" >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetSleepDateString($user_id,$pro_user_id,$arr_sleep_id[$i]).'</div>';
    
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="my_target2[]" id="my_target2_'.$i.'" disabled>';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetSleepDateString($user_id,$pro_user_id,$arr_sleep_id[$i]).'</div>';
    
    
    $output .= '                    </td>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; Adviser Set Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="adviser_target[]" id="adviser_target_'.$i.'" >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetSleepDateString($user_id,$pro_user_id,$arr_sleep_id[$i]).'</div>';
    
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="adviser_target2[]" id="adviser_target2_'.$i.'" disabled>';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetSleepDateString($user_id,$pro_user_id,$arr_sleep_id[$i]).'</div>';
    
    
    $output .= '                    </td>';
    $output .= '                </tr>'
            . '             </table>'
            . '         </td>'
            . '     </tr>';
        }
	$output .= '<tr>';
	$output .= '	<td width="130" height="35" align="left" valign="top">&nbsp;</td>';
	$output .= '	<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';
	$output .= '</tr>';
    }
    else
    {
        if($pro_user_id == '')
        {
            $err_msg2 = '<span class="Header_blue">Please select your Diary Notings</span>';
        }
        else
        {
            $err_msg2 = '<span class="Header_blue">No Inputs available from your Adviser Mr '.getProUserFullNameById($pro_user_id).'. For Standard Set Inputs, select from Dropdown.</span>';
        }
	$output .= '<tr>';
	$output .= '	<td align="center" colspan="2" valign="top">'.$err_msg2.'</td>';
	$output .= '</tr>';	
    }
    $output .= '</table>';	
    
    return $output;
}

function getUsersADCTQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_adct_id_arr,$old_my_target_arr,$old_adviser_target_arr)
{
    global $link;
    $output = '';
    
    $adct_date = $year.'-'.$month.'-'.$day;
    
    list($arr_adct_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getAdctQuestions($user_id,$adct_date,$pro_user_id);
    $cnt = count($arr_adct_id);
    
    $tr_response_img = array();
    $tr_response_slider = array();
    for($i=0;$i<$cnt;$i++)
    {
        $tr_response_img[$i] = '';
        $tr_response_slider[$i] = 'none';
    }
    //list($old_scale_arr,$old_remarks_arr,$old_selected_adct_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersADCTQuestionDetails($user_id,$adct_date,$pro_user_id);
    $selected_adct_id_arr = array(); 
    $scale_arr = array(); 
    $remarks_arr = array(); 
    $my_target_arr = array();
    $adviser_target_arr = array();

    $j = 0;
    for($i=0;$i<count($arr_adct_id);$i++)
    {
        if(in_array($arr_adct_id[$i],$old_selected_adct_id_arr))
        {
            $key = array_search($arr_adct_id[$i], $old_selected_adct_id_arr);
            $tr_response_img[$i] = 'none';
            $tr_response_slider[$i] = '';
            $selected_adct_id_arr[$i] = $old_selected_adct_id_arr[$key];
            $scale_arr[$i] = $old_scale_arr[$key];
            $remarks_arr[$i] = $old_remarks_arr[$key];
            $my_target_arr[$i] = $old_my_target_arr[$key];
            $adviser_target_arr[$i] = $old_adviser_target_arr[$key];
            $j++;
        }
        else
        {
            $tr_response_img[$i] = '';
            $tr_response_slider[$i] = 'none';
            $selected_adct_id_arr[$i] = '';
            $scale_arr[$i] = 0;
            $remarks_arr[$i] = '';
            list($my_target_arr[$i], $adviser_target_arr[$i]) = getUsersLastMyTargetADCTValue($user_id,$pro_user_id,$arr_adct_id[$i]);
        }
    }		

    $output = '';
    $output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tbladct">';
    if(count($arr_adct_id) > 0)
    {
        for($i=0;$i<count($arr_adct_id);$i++)
        { 
	$output .= '<tr style="display:none" valign="top">';
	$output .= '	<td align="left" colspan="2" class="err_msg" valign="top"></td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '	<td align="left" colspan="2" valign="top">&nbsp;</td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '	<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';
	$output .= '	<td width="430" height="35" align="left" valign="top">';
			if($selected_adct_id_arr[$i] == $arr_adct_id[$i]) 
			{ 
                            $chked = ' checked="checked" ';
			}
			else
			{
                            $chked = '';
			}
	$output .= '        <input type="checkbox" name="selected_adct_id_'.$i.'" id="selected_adct_id_'.$i.'" value="'.$arr_adct_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_adct_id_\',\''.$i.'\')" />&nbsp;<strong><span style="font-family:'.$arr_situation_font_family[$i].';font-size:'.$arr_situation_font_size[$i].'px;color:#'.$arr_situation_font_color[$i].';">'.$arr_situation[$i].'</span></strong>';
	$output .= '	</td>';
	$output .= '</tr>';
	
        $output .= '<tr>';
	$output .= '	<td width="130" height="45" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';
	$output .= '	<td width="430" height="45" align="left" valign="top">';
	$output .= getScaleSliderCode($i,$tr_response_img[$i],$tr_response_slider[$i],$scale_arr[$i]);
	$output .= '	</td>';
	$output .= '</tr>';
        
        
	$output .= '<tr>';
	$output .= '	<td align="left" colspan="2" valign="top">&nbsp;</td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '	<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';
	$output .= '	<td width="430" align="left" valign="top">';
	$output .= '        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea></div>';
        $output .= '        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><textarea name="remarks2[]" id="remarks2_'.$i.'" cols="25" rows="3" disabled>'.$remarks_arr[$i].'</textarea></div>';
	$output .= '	</td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '	<td align="left" colspan="2" valign="top">&nbsp;</td>';
	$output .= '</tr>';
        $output .= '<tr>'
                . '     <td align="left" colspan="2" valign="top">
                            <table width="560" border="0" cellspacing="0" cellpadding="0">
                                <tr>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; My Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="my_target[]" id="my_target_'.$i.'" >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetADCTDateString($user_id,$pro_user_id,$arr_adct_id[$i]).'</div>';
    
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="my_target2[]" id="my_target2_'.$i.'" disabled>';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetADCTDateString($user_id,$pro_user_id,$arr_adct_id[$i]).'</div>';
    
    
    $output .= '                    </td>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; Adviser Set Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="adviser_target[]" id="adviser_target_'.$i.'">';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetADCTDateString($user_id,$pro_user_id,$arr_adct_id[$i]).'</div>';
    
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="adviser_target2[]" id="adviser_target2_'.$i.'" disabled>';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetADCTDateString($user_id,$pro_user_id,$arr_adct_id[$i]).'</div>';
    
    
    
    
    $output .= '                    </td>';
    $output .= '                </tr>'
            . '             </table>'
            . '         </td>'
            . '     </tr>';
    $output .= '	<tr>';
    $output .= '        <td align="left" colspan="2" valign="top">&nbsp;</td>';
    $output .= '	</tr>';
        }
	$output .= '<tr>';
	$output .= '	<td width="130" height="35" align="left" valign="top">&nbsp;</td>';
	$output .= '	<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';
	$output .= '</tr>';
    }
    else
    {
        if($pro_user_id == '')
        {
            $err_msg2 = '<span class="Header_blue">Please select your Diary Notings</span>';
        }
        else
        {
            $err_msg2 = '<span class="Header_blue">No Inputs available from your Adviser Mr '.getProUserFullNameById($pro_user_id).'. For Standard Set Inputs, select from Dropdown.</span>';
        }
	$output .= '<tr>';
	$output .= '    <td align="center" colspan="2" valign="top">'.$err_msg2.'</td>';
	$output .= '</tr>';	
    }
    $output .= '</table>';	
    
    return $output;
}

function getUsersGSQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_gs_id_arr,$old_my_target_arr,$old_adviser_target_arr)
{
    global $link;
    $output = '';
    
    $gs_date = $year.'-'.$month.'-'.$day;

    $tr_response_img = array();
    $tr_response_slider = array();

    list($arr_gs_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getGSQuestions($user_id,$gs_date,$pro_user_id);

    $cnt = count($arr_gs_id);
    for($i=0;$i<$cnt;$i++)
    {
        $tr_response_img[$i] = '';
        $tr_response_slider[$i] = 'none';
    }

    //list($old_scale_arr,$old_remarks_arr,$old_selected_gs_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersGSQuestionDetails($user_id,$gs_date,$pro_user_id);
	
    $selected_gs_id_arr = array(); 
    $scale_arr = array(); 
    $remarks_arr = array(); 
    $my_target_arr = array(); 
    $adviser_target_arr = array(); 
    $j = 0;
    for($i=0;$i<count($arr_gs_id);$i++)
    {
        if(in_array($arr_gs_id[$i],$old_selected_gs_id_arr))
        {
            $key = array_search($arr_gs_id[$i], $old_selected_gs_id_arr);

            $tr_response_img[$i] = 'none';
            $tr_response_slider[$i] = '';
            $selected_gs_id_arr[$i] = $old_selected_gs_id_arr[$key];
            $scale_arr[$i] = $old_scale_arr[$key];
            $remarks_arr[$i] = $old_remarks_arr[$key];
            $my_target_arr[$i] = $old_my_target_arr[$key];
            $adviser_target_arr[$i] = $old_adviser_target_arr[$key];
            $j++;
        }
        else
        {
            $tr_response_img[$i] = '';
            $tr_response_slider[$i] = 'none';
            $selected_gs_id_arr[$i] = '';
            $scale_arr[$i] = 0;
            $remarks_arr[$i] = '';
            list($my_target_arr[$i], $adviser_target_arr[$i]) = getUsersLastMyTargetGSValue($user_id,$pro_user_id,$arr_gs_id[$i]);
        }
    }	
	
    $output = '';
    $output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tblgs">';
    if(count($arr_gs_id) > 0)
    {
            for($i=0;$i<count($arr_gs_id);$i++)
            { 
    $output .= '	<tr style="display:none" valign="top">';
    $output .= '		<td align="left" colspan="2" class="err_msg" valign="top"></td>';
    $output .= '	</tr>';
    $output .= '	<tr>';
    $output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';
    $output .= '	</tr>';
    $output .= '	<tr>';
    $output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';
    $output .= '		<td width="430" height="35" align="left" valign="top">';
                    if($selected_gs_id_arr[$i] == $arr_gs_id[$i]) 
                    { 
                            $chked = ' checked="checked" ';
                    }
                    else
                    {
                            $chked = '';
                    }
    $output .= '			<input type="checkbox" name="selected_gs_id_'.$i.'" id="selected_gs_id_'.$i.'" value="'.$arr_gs_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_gs_id_\',\''.$i.'\')" />&nbsp;<strong><span style="font-family:'.$arr_situation_font_family[$i].';font-size:'.$arr_situation_font_size[$i].'px;color:#'.$arr_situation_font_color[$i].';">'.$arr_situation[$i].'</span></strong>';
    $output .= '		</td>';
    $output .= '	</tr>';
    
    
    $output .= '<tr>';
    $output .= '	<td width="130" height="45" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';
    $output .= '	<td width="430" height="45" align="left" valign="top">';
    $output .= getScaleSliderCode($i,$tr_response_img[$i],$tr_response_slider[$i],$scale_arr[$i]);
    $output .= '	</td>';
    $output .= '</tr>';
    
    
    $output .= '	<tr>';
    $output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';
    $output .= '	</tr>';
    $output .= '	<tr>';
    $output .= '		<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';
    $output .= '		<td width="430" align="left" valign="top">';
    $output .= '			<div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea></div>';
    $output .= '			<div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><textarea name="remarks2[]" id="remarks2_'.$i.'" cols="25" rows="3" disabled>'.$remarks_arr[$i].'</textarea></div>';
    $output .= '		</td>';
    $output .= '	</tr>';
    $output .= '	<tr>';
    $output .= '    	<td align="left" colspan="2" valign="top">&nbsp;</td>';
    $output .= '	</tr>';
    $output .= '	<tr>'
            . '         <td align="left" colspan="2" valign="top">
                            <table width="560" border="0" cellspacing="0" cellpadding="0">
                                <tr>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; My Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="my_target[]" id="my_target_'.$i.'" >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetGSDateString($user_id,$pro_user_id,$arr_gs_id[$i]).'</div>';
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="my_target2[]" id="my_target2_'.$i.'" disabled >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetGSDateString($user_id,$pro_user_id,$arr_gs_id[$i]).'</div>';
    
    
    $output .= '                    </td>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; Adviser Set Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="adviser_target[]" id="adviser_target_'.$i.'">';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetGSDateString($user_id,$pro_user_id,$arr_gs_id[$i]).'</div>';
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="adviser_target2[]" id="adviser_target2_'.$i.'" disabled>';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetGSDateString($user_id,$pro_user_id,$arr_gs_id[$i]).'</div>';
    
    
    $output .= '                    </td>';
    $output .= '                </tr>'
            . '             </table>'
            . '         </td>'
            . '     </tr>';
    $output .= '	<tr>';
    $output .= '        <td align="left" colspan="2" valign="top">&nbsp;</td>';
    $output .= '	</tr>';

            }
    $output .= '	<tr>';
    $output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;</td>';
    $output .= '		<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';
    $output .= '	</tr>';
    }
    else
    {
        if($pro_user_id == '')
        {
            $err_msg2 = '<span class="Header_blue">Please select your Diary Notings</span>';
        }
        else
        {
            $err_msg2 = '<span class="Header_blue">No Inputs available from your Adviser Mr '.getProUserFullNameById($pro_user_id).'. For Standard Set Inputs, select from Dropdown.</span>';
        }
    $output .= '	<tr>';
    $output .= '		<td align="center" colspan="2" valign="top">'.$err_msg2.'</td>';
    $output .= '	</tr>';	
    }
    $output .= '</table>';	
    
    return $output;
}

function getUsersWAEQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_wae_id_arr,$old_my_target_arr,$old_adviser_target_arr)
{
    global $link;
    $output = '';
    
    $tr_response_img = array();
    $tr_response_slider = array();

    $wae_date = $year.'-'.$month.'-'.$day;

    list($arr_wae_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getWAEQuestions($user_id,$wae_date,$pro_user_id);

    $cnt = count($arr_wae_id);
    for($i=0;$i<$cnt;$i++)
    {
            $tr_response_img[$i] = '';
            $tr_response_slider[$i] = 'none';
    }

    //list($old_scale_arr,$old_remarks_arr,$old_selected_wae_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersWAEQuestionDetails($user_id,$wae_date,$pro_user_id);
    $selected_wae_id_arr = array(); 
    $scale_arr = array(); 
    $remarks_arr = array(); 
    $my_target_arr = array();
    $adviser_target_arr = array();

    $j = 0;
    for($i=0;$i<count($arr_wae_id);$i++)
    {
            if(in_array($arr_wae_id[$i],$old_selected_wae_id_arr))
            {
                    $key = array_search($arr_wae_id[$i], $old_selected_wae_id_arr);

                    $tr_response_img[$i] = 'none';
                    $tr_response_slider[$i] = '';
                    $selected_wae_id_arr[$i] = $old_selected_wae_id_arr[$key];
                    $scale_arr[$i] = $old_scale_arr[$key];
                    $remarks_arr[$i] = $old_remarks_arr[$key];
                    $my_target_arr[$i] = $old_my_target_arr[$key];
                    $adviser_target_arr[$i] = $old_adviser_target_arr[$key];
                    $j++;
            }
            else
            {
                    $tr_response_img[$i] = '';
                    $tr_response_slider[$i] = 'none';
                    $selected_wae_id_arr[$i] = '';
                    $scale_arr[$i] = 0;
                    $remarks_arr[$i] = '';
                    list($my_target_arr[$i], $adviser_target_arr[$i]) = getUsersLastMyTargetWAEValue($user_id,$pro_user_id,$arr_wae_id[$i]);
            }

    }	

    $output = '';
    $output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tblwae">';
    if(count($arr_wae_id) > 0)
    {
            for($i=0;$i<count($arr_wae_id);$i++)
            { 
    $output .= '	<tr style="display:none" valign="top">';
    $output .= '		<td align="left" colspan="2" class="err_msg" valign="top"></td>';
    $output .= '	</tr>';
    $output .= '	<tr>';
    $output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';
    $output .= '	</tr>';
    $output .= '	<tr>';
    $output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';
    $output .= '		<td width="430" height="35" align="left" valign="top">';
                    if($arr_wae_id[$i] == $selected_wae_id_arr[$i]) 
                    { 
                            $chked = ' checked="checked" ';
                    }
                    else
                    {
                            $chked = '';
                    }
    $output .= '			<input type="checkbox" name="selected_wae_id_'.$i.'" id="selected_wae_id_'.$i.'" value="'.$arr_wae_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_wae_id_\',\''.$i.'\')" />&nbsp;<strong><span style="font-family:'.$arr_situation_font_family[$i].';font-size:'.$arr_situation_font_size[$i].'px;color:#'.$arr_situation_font_color[$i].';">'.$arr_situation[$i].'</span></strong>';
    $output .= '		</td>';
    $output .= '	</tr>';



    $output .= '<tr>';
    $output .= '	<td width="130" height="45" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';
    $output .= '	<td width="430" height="45" align="left" valign="top">';
    $output .= getScaleSliderCode($i,$tr_response_img[$i],$tr_response_slider[$i],$scale_arr[$i]);
    $output .= '	</td>';
    $output .= '</tr>';



    $output .= '	<tr>';
    $output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';
    $output .= '	</tr>';
    $output .= '	<tr>';
    $output .= '		<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';
    $output .= '		<td width="430" align="left" valign="top">';
    $output .= '			<div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea></div>';
    $output .= '			<div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><textarea name="remarks2[]" id="remarks2_'.$i.'" cols="25" rows="3" disabled>'.$remarks_arr[$i].'</textarea></div>';
    $output .= '		</td>';
    $output .= '	</tr>';
    $output .= '	<tr>';
    $output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';
    $output .= '	</tr>';
    $output .= '<tr>'
            . '     <td align="left" colspan="2" valign="top">
                        <table width="560" border="0" cellspacing="0" cellpadding="0">
                            <tr>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; My Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="my_target[]" id="my_target_'.$i.'" >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetWAEDateString($user_id,$pro_user_id,$arr_wae_id[$i]).'</div>';
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="my_target2[]" id="my_target2_'.$i.'" disabled >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetWAEDateString($user_id,$pro_user_id,$arr_wae_id[$i]).'</div>';
    
    
    $output .= '                    </td>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; Adviser Set Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="adviser_target[]" id="adviser_target_'.$i.'">';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetWAEDateString($user_id,$pro_user_id,$arr_wae_id[$i]).'</div>';
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="adviser_target2[]" id="adviser_target2_'.$i.'" disabled>';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetWAEDateString($user_id,$pro_user_id,$arr_wae_id[$i]).'</div>';
    
    
    $output .= '                    </td>';
    $output .= '                </tr>'
            . '             </table>'
            . '         </td>'
            . '     </tr>';
    $output .= '	<tr>';
    $output .= '        <td align="left" colspan="2" valign="top">&nbsp;</td>';
    $output .= '	</tr>';
		}
    $output .= '	<tr>';
    $output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;</td>';
    $output .= '		<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';
    $output .= '	</tr>';
	}
	else
	{
		if($pro_user_id == '')
		{
			$err_msg2 = '<span class="Header_blue">Please select your Diary Notings</span>';
		}
		else
		{
			$err_msg2 = '<span class="Header_blue">No Inputs available from your Adviser Mr '.getProUserFullNameById($pro_user_id).'. For Standard Set Inputs, select from Dropdown.</span>';
		}
	$output .= '	<tr>';
	$output .= '		<td align="center" colspan="2" valign="top">'.$err_msg2.'</td>';
	$output .= '	</tr>';	
	}
	$output .= '</table>';	
    
    return $output;
}

function getUsersMCQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_mc_id_arr,$old_my_target_arr,$old_adviser_target_arr)
{
    global $link;
    $output = '';
    
    $mc_date = $year.'-'.$month.'-'.$day;

    $tr_response_img = array();
    $tr_response_slider = array();

    list($arr_mc_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getMCQuestions($user_id,$mc_date,$pro_user_id);
    $cnt = count($arr_mc_id);
    for($i=0;$i<$cnt;$i++)
    {
        $tr_response_img[$i] = '';
        $tr_response_slider[$i] = 'none';
    }



	$mc_date = $year.'-'.$month.'-'.$day;

	

	//list($old_scale_arr,$old_remarks_arr,$old_selected_mc_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersMCQuestionDetails($user_id,$mc_date,$pro_user_id);

	

	$selected_mc_id_arr = array(); 

	$scale_arr = array(); 

	$remarks_arr = array(); 
        $my_target_arr = array(); 
    $adviser_target_arr = array(); 

	

	$j = 0;

	for($i=0;$i<count($arr_mc_id);$i++)

	{

		if(in_array($arr_mc_id[$i],$old_selected_mc_id_arr))

		{
			$key = array_search($arr_mc_id[$i], $old_selected_mc_id_arr);

			$tr_response_img[$i] = 'none';

			$tr_response_slider[$i] = '';

			$selected_mc_id_arr[$i] = $old_selected_mc_id_arr[$key];

			$scale_arr[$i] = $old_scale_arr[$key];

			$remarks_arr[$i] = $old_remarks_arr[$key];
                        $my_target_arr[$i] = $old_my_target_arr[$key];
                        $adviser_target_arr[$i] = $old_adviser_target_arr[$key];

			$j++;

		}

		else

		{

			$tr_response_img[$i] = '';

			$tr_response_slider[$i] = 'none';

			$selected_mc_id_arr[$i] = '';

			$scale_arr[$i] = 0;

			$remarks_arr[$i] = '';
                        
                        list($my_target_arr[$i], $adviser_target_arr[$i]) = getUsersLastMyTargetMCValue($user_id,$pro_user_id,$arr_mc_id[$i]);

		}

	}			

	$output = '';

	$output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tblmc">';

	if(count($arr_mc_id) > 0)

	{

		for($i=0;$i<count($arr_mc_id);$i++)

		{ 

	$output .= '	<tr style="display:none" valign="top">';

	$output .= '		<td align="left" colspan="2" class="err_msg" valign="top"></td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';

	$output .= '		<td width="430" height="35" align="left" valign="top">';

			if($selected_mc_id_arr[$i] == $arr_mc_id[$i]) 

			{ 

				$chked = ' checked="checked" ';

			}

			else

			{

				$chked = '';

			}

	$output .= '			<input type="checkbox" name="selected_mc_id_'.$i.'" id="selected_mc_id_'.$i.'" value="'.$arr_mc_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_mc_id_\',\''.$i.'\')" />&nbsp;<strong><span style="font-family:'.$arr_situation_font_family[$i].';font-size:'.$arr_situation_font_size[$i].'px;color:#'.$arr_situation_font_color[$i].';">'.$arr_situation[$i].'</span></strong>';

	$output .= '		</td>';

	$output .= '	</tr>';

	 $output .= '<tr>';
    $output .= '	<td width="130" height="45" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';
    $output .= '	<td width="430" height="45" align="left" valign="top">';
    $output .= getScaleSliderCode($i,$tr_response_img[$i],$tr_response_slider[$i],$scale_arr[$i]);
    $output .= '	</td>';
    $output .= '</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';

	$output .= '		<td width="430" align="left" valign="top">';

	$output .= '			<div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea></div>';
        $output .= '			<div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><textarea name="remarks2[]" id="remarks2_'.$i.'" cols="25" rows="3" disabled>'.$remarks_arr[$i].'</textarea></div>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';
        
        $output .= '<tr>'
                . '     <td align="left" colspan="2" valign="top">
                            <table width="560" border="0" cellspacing="0" cellpadding="0">
                                <tr>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; My Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="my_target[]" id="my_target_'.$i.'" >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetMCDateString($user_id,$pro_user_id,$arr_mc_id[$i]).'</div>';
    
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="my_target2[]" id="my_target2_'.$i.'" disabled >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetMCDateString($user_id,$pro_user_id,$arr_mc_id[$i]).'</div>';
    
    
    $output .= '                    </td>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; Adviser Set Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="adviser_target[]" id="adviser_target_'.$i.'">';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetMCDateString($user_id,$pro_user_id,$arr_mc_id[$i]).'</div>';
    
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="adviser_target2[]" id="adviser_target2_'.$i.'" disabled>';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetMCDateString($user_id,$pro_user_id,$arr_mc_id[$i]).'</div>';
    
    
    
    $output .= '                    </td>';
    $output .= '                </tr>'
            . '             </table>'
            . '         </td>'
            . '     </tr>';
    $output .= '	<tr>';
    $output .= '        <td align="left" colspan="2" valign="top">&nbsp;</td>';
    $output .= '	</tr>';

		}

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;</td>';

	$output .= '		<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';

	$output .= '	</tr>';

	}
	else
	{
		if($pro_user_id == '')
		{
			$err_msg2 = '<span class="Header_blue">Please select your Diary Notings</span>';
		}
		else
		{
			$err_msg2 = '<span class="Header_blue">No Inputs available from your Adviser Mr '.getProUserFullNameById($pro_user_id).'. For Standard Set Inputs, select from Dropdown.</span>';
		}
	$output .= '	<tr>';
	$output .= '		<td align="center" colspan="2" valign="top">'.$err_msg2.'</td>';
	$output .= '	</tr>';	
	}

	$output .= '</table>';	
    
    return $output;
}

function getUsersMRQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_mr_id_arr,$old_my_target_arr,$old_adviser_target_arr)
{
    global $link;
    $output = '';
    
    $mr_date = $year.'-'.$month.'-'.$day;

	$tr_response_img = array();

	$tr_response_slider = array();

	

	list($arr_mr_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getMRQuestions($user_id,$mr_date,$pro_user_id);

	$cnt = count($arr_mr_id);

	for($i=0;$i<$cnt;$i++)

	{

		$tr_response_img[$i] = '';

		$tr_response_slider[$i] = 'none';

	}



	$mr_date = $year.'-'.$month.'-'.$day;

	

	list($old_scale_arr,$old_remarks_arr,$old_selected_mr_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersMRQuestionDetails($user_id,$mr_date,$pro_user_id);

	

	$selected_mr_id_arr = array(); 

	$scale_arr = array(); 

	$remarks_arr = array(); 
        $my_target_arr = array();
        $adviser_target_arr = array();

	

	$j = 0;

	for($i=0;$i<count($arr_mr_id);$i++)

	{

		if(in_array($arr_mr_id[$i],$old_selected_mr_id_arr))

		{
			$key = array_search($arr_mr_id[$i], $old_selected_mr_id_arr);

			$tr_response_img[$i] = 'none';

			$tr_response_slider[$i] = '';

			$selected_mr_id_arr[$i] = $old_selected_mr_id_arr[$key];

			$scale_arr[$i] = $old_scale_arr[$key];

			$remarks_arr[$i] = $old_remarks_arr[$key];
                        $my_target_arr[$i] = $old_my_target_arr[$key];
                        $adviser_target_arr[$i] = $old_adviser_target_arr[$key];

			$j++;

		}

		else

		{

			$tr_response_img[$i] = '';

			$tr_response_slider[$i] = 'none';

			$selected_mr_id_arr[$i] = '';

			$scale_arr[$i] = 0;

			$remarks_arr[$i] = '';
                        list($my_target_arr[$i], $adviser_target_arr[$i]) = getUsersLastMyTargetMRValue($user_id,$pro_user_id,$arr_mr_id[$i]);

		}

	}	

	

	$output = '';

	$output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tblmr">';

	if(count($arr_mr_id) > 0)

	{

		for($i=0;$i<count($arr_mr_id);$i++)

		{ 

	$output .= '	<tr style="display:none" valign="top">';

	$output .= '		<td align="left" colspan="2" class="err_msg" valign="top"></td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';

	$output .= '		<td width="430" height="35" align="left" valign="top">';

			if($selected_mr_id_arr[$i] == $arr_mr_id[$i]) 

			{ 

				$chked = ' checked="checked" ';

			}

			else

			{

				$chked = '';

			}

	
	$output .= '			<input type="checkbox" name="selected_mr_id_'.$i.'" id="selected_mr_id_'.$i.'" value="'.$arr_mr_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_mr_id_\',\''.$i.'\')" />&nbsp;<strong><span style="font-family:'.$arr_situation_font_family[$i].';font-size:'.$arr_situation_font_size[$i].'px;color:#'.$arr_situation_font_color[$i].';">'.$arr_situation[$i].'</span></strong>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '<tr>';
    $output .= '	<td width="130" height="45" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';
    $output .= '	<td width="430" height="45" align="left" valign="top">';
    $output .= getScaleSliderCode($i,$tr_response_img[$i],$tr_response_slider[$i],$scale_arr[$i]);
    $output .= '	</td>';
    $output .= '</tr>';


	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';

	$output .= '		<td width="430" align="left" valign="top">';

	$output .= '			<div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea></div>';
        $output .= '			<div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><textarea name="remarks2[]" id="remarks2_'.$i.'" cols="25" rows="3" disabled>'.$remarks_arr[$i].'</textarea></div>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';
        
        $output .= '<tr>'
                . '     <td align="left" colspan="2" valign="top">
                            <table width="560" border="0" cellspacing="0" cellpadding="0">
                                <tr>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; My Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="my_target[]" id="my_target_'.$i.'" >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetMRDateString($user_id,$pro_user_id,$arr_mr_id[$i]).'</div>';
    
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="my_target2[]" id="my_target2_'.$i.'" disabled >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetMRDateString($user_id,$pro_user_id,$arr_mr_id[$i]).'</div>';
    
    
    $output .= '                    </td>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; Adviser Set Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="adviser_target[]" id="adviser_target_'.$i.'">';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetMRDateString($user_id,$pro_user_id,$arr_mr_id[$i]).'</div>';
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="adviser_target2[]" id="adviser_target2_'.$i.'" disabled>';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetMRDateString($user_id,$pro_user_id,$arr_mr_id[$i]).'</div>';
    
    
    $output .= '                    </td>';
    $output .= '                </tr>'
            . '             </table>'
            . '         </td>'
            . '     </tr>';
    $output .= '	<tr>';
    $output .= '        <td align="left" colspan="2" valign="top">&nbsp;</td>';
    $output .= '	</tr>';

		}

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;</td>';

	$output .= '		<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';

	$output .= '	</tr>';

	}
	else
	{
		if($pro_user_id == '')
		{
			$err_msg2 = '<span class="Header_blue">Please select your Diary Notings</span>';
		}
		else
		{
			$err_msg2 = '<span class="Header_blue">No Inputs available from your Adviser Mr '.getProUserFullNameById($pro_user_id).'. For Standard Set Inputs, select from Dropdown.</span>';
		}
	$output .= '	<tr>';
	$output .= '		<td align="center" colspan="2" valign="top">'.$err_msg2.'</td>';
	$output .= '	</tr>';	
	}

	$output .= '</table>';	
    
    return $output;
}

function getUsersMLEQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_mle_id_arr,$old_my_target_arr,$old_adviser_target_arr)
{
    global $link;
    $output = '';
    
    $mle_date = $year.'-'.$month.'-'.$day;

	$tr_response_img = array();

	$tr_response_slider = array();

	

	list($arr_mle_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getMLEQuestions($user_id,$mle_date,$pro_user_id);

	$cnt = count($arr_mle_id);

	for($i=0;$i<$cnt;$i++)

	{

		$tr_response_img[$i] = '';

		$tr_response_slider[$i] = 'none';

	}



	$mle_date = $year.'-'.$month.'-'.$day;

	

	list($old_scale_arr,$old_remarks_arr,$old_selected_mle_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersMLEQuestionDetails($user_id,$mle_date,$pro_user_id);

	

	$selected_mle_id_arr = array(); 

	$scale_arr = array(); 

	$remarks_arr = array(); 
        $my_target_arr = array();
        $adviser_target_arr = array();

	

	$j = 0;

	for($i=0;$i<count($arr_mle_id);$i++)

	{

		if(in_array($arr_mle_id[$i],$old_selected_mle_id_arr))

		{
			$key = array_search($arr_mle_id[$i], $old_selected_mle_id_arr);

			$tr_response_img[$i] = 'none';

			$tr_response_slider[$i] = '';

			$selected_mle_id_arr[$i] = $old_selected_mle_id_arr[$key];

			$scale_arr[$i] = $old_scale_arr[$key];

			$remarks_arr[$i] = $old_remarks_arr[$key];
                        
                        $my_target_arr[$i] = $old_my_target_arr[$key];
                        $adviser_target_arr[$i] = $old_adviser_target_arr[$key];

			$j++;

		}

		else

		{

			$tr_response_img[$i] = '';

			$tr_response_slider[$i] = 'none';

			$selected_mle_id_arr[$i] = '';

			$scale_arr[$i] = 0;

			$remarks_arr[$i] = '';
                        
                        list($my_target_arr[$i], $adviser_target_arr[$i]) = getUsersLastMyTargetMLEValue($user_id,$pro_user_id,$arr_mle_id[$i]);

		}

	}	

	

	$output = '';

	$output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tblmle">';

	if(count($arr_mle_id) > 0)

	{

		for($i=0;$i<count($arr_mle_id);$i++)

		{ 

	$output .= '	<tr style="display:none" valign="top">';

	$output .= '		<td align="left" colspan="2" class="err_msg" valign="top"></td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';

	$output .= '		<td width="430" height="35" align="left" valign="top">';

			if($selected_mle_id_arr[$i] == $arr_mle_id[$i]) 

			{ 

				$chked = ' checked="checked" ';

			}

			else

			{

				$chked = '';

			}

	
	$output .= '			<input type="checkbox" name="selected_mle_id_'.$i.'" id="selected_mle_id_'.$i.'" value="'.$arr_mle_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_mle_id_\',\''.$i.'\')" />&nbsp;<strong><span style="font-family:'.$arr_situation_font_family[$i].';font-size:'.$arr_situation_font_size[$i].'px;color:#'.$arr_situation_font_color[$i].';">'.$arr_situation[$i].'</span></strong>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '<tr>';
    $output .= '	<td width="130" height="45" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';
    $output .= '	<td width="430" height="45" align="left" valign="top">';
    $output .= getScaleSliderCode($i,$tr_response_img[$i],$tr_response_slider[$i],$scale_arr[$i]);
    $output .= '	</td>';
    $output .= '</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';

	$output .= '		<td width="430" align="left" valign="top">';

	$output .= '			<div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea></div>';
        $output .= '			<div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><textarea name="remarks2[]" id="remarks2_'.$i.'" cols="25" rows="3" disabled>'.$remarks_arr[$i].'</textarea></div>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';
        
        $output .= '<tr>'
                . '     <td align="left" colspan="2" valign="top">
                            <table width="560" border="0" cellspacing="0" cellpadding="0">
                                <tr>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; My Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="my_target[]" id="my_target_'.$i.'" >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetMLEDateString($user_id,$pro_user_id,$arr_mle_id[$i]).'</div>';
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="my_target2[]" id="my_target2_'.$i.'" disabled >';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($my_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }               
    $output .= '                        </select><br>'.getUsersLastMyTargetMLEDateString($user_id,$pro_user_id,$arr_mle_id[$i]).'</div>';
    
    
    
    $output .= '                    </td>';
    $output .= '                    <td width="130" align="left" valign="top">&nbsp;&bull; Adviser Set Target:</td>';
    $output .= '                    <td width="150" align="left" valign="top">';
    
    
    $output .= '                        <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><select name="adviser_target[]" id="adviser_target_'.$i.'">';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetMLEDateString($user_id,$pro_user_id,$arr_mle_id[$i]).'</div>';
    
    $output .= '                        <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><select name="adviser_target2[]" id="adviser_target2_'.$i.'" disabled>';
    $output .= '                            <option value="">Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            {
                                                $sel = ' selected="selected" ';
                                            }
                                            else
                                            {
                                                $sel = '';
                                            }
    $output .= '                            <option value="'.$j.'" '.$sel.'>'.$j.'</option>';
                                        }    
    $output .= '                        </select><br>'.getUsersLastAdviserTargetMLEDateString($user_id,$pro_user_id,$arr_mle_id[$i]).'</div>';
    
    
    
    $output .= '                    </td>';
    $output .= '                </tr>'
            . '             </table>'
            . '         </td>'
            . '     </tr>';
    $output .= '	<tr>';
    $output .= '        <td align="left" colspan="2" valign="top">&nbsp;</td>';
    $output .= '	</tr>';

		}

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;</td>';

	$output .= '		<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';

	$output .= '	</tr>';

	}
	else
	{
		if($pro_user_id == '')
		{
			$err_msg2 = '<span class="Header_blue">Please select your Diary Notings</span>';
		}
		else
		{
			$err_msg2 = '<span class="Header_blue">No Inputs available from your Adviser Mr '.getProUserFullNameById($pro_user_id).'. For Standard Set Inputs, select from Dropdown.</span>';
		}
	$output .= '	<tr>';
	$output .= '		<td align="center" colspan="2" valign="top">'.$err_msg2.'</td>';
	$output .= '	</tr>';	
	}

	$output .= '</table>';	
    
    return $output;
}

function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

function doPageVisitLog($page_id)
{
    global $link;
    if(isLoggedIn())
    {
        $uid = $_SESSION['user_id'];
        $visitor_type = 1;
    }
    elseif(!isLoggedInPro())
    {
        $uid = $_SESSION['pro_user_id'];
        $visitor_type = 2;
    }
    else
    {
        $uid = 0;
        $visitor_type = 0;
    }
    
    $page_title = getMenuTitleOfPage($page_id);
    $ip_address = getUserIP();
    
}
function getUsersAllEncashedRewards($user_id,$reward_list_module_id,$start_date,$end_date)
{
	global $link;
	$arr_records = array();
	
	if($user_id == 'All')
	{
		$str_sql_user_id = "";
	}
	else
	{
		$str_sql_user_id = " AND TRR.user_id = '".$user_id."' ";
	}
	
	if($reward_list_module_id == '')
	{
		$str_sql_reward_list_module_id = '';
	}
	elseif($reward_list_module_id == '15')
	{
		$str_sql_reward_list_module_id = " AND TRR.random_all_module_no > 0 ";
	}
	else
	{
		$str_sql_reward_list_module_id = " AND TRR.reward_module_id = '".$reward_list_module_id."'  ";
	}
	
	$sql = "SELECT TRR.* , TRL.reward_list_name , TRL.reward_list_file_type , TRL.reward_list_file , TRM.reward_module_title FROM `tblrewardredeamed` AS TRR LEFT JOIN `tblrewardlist` AS TRL ON TRR.reward_list_id = TRL.reward_list_id LEFT JOIN `tblrewardmodules` AS TRM ON TRR.reward_module_id = TRM.reward_module_id WHERE DATE(TRR.redeam_date) >= '".date('Y-m-d',strtotime($start_date))."' AND DATE(TRR.redeam_date) <= '".date('Y-m-d',strtotime($end_date))."' ".$str_sql_user_id."  ".$str_sql_reward_list_module_id." ORDER BY TRR.redeam_date DESC , TRM.reward_module_title ASC ";
	//echo '<br>'.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			$arr_records[] = $row;
		}			
	}
	
	return $arr_records;
}
function getUsersAllEncashedRewardsHtml($user_id,$reward_list_module_id,$start_date,$end_date)
{
	global $link;
	$output = '';
	
	$arr_encashed_rewards  = getUsersAllEncashedRewards($user_id,$reward_list_module_id,$start_date,$end_date);
	if(count($arr_encashed_rewards) > 0)
	{
		$error = false;
		$err_msg = '';
	}
	else
	{
		$error = true;
		$err_msg = '<span class="err_msg">No Records Found!</span>';
	}
	
	if(!$error)
	{ 
	$output .= '<table width="1000" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
					<tr>
						<td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr No.</strong></td>
						<td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>User Name</strong></td>
						<td width="20%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Module</strong></td>
						<td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Encashed Type</strong></td>
						<td width="20%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Encashed Points</strong></td>
						<td width="30%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Reward</strong></td>
						<td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Date</strong></td>
					</tr>';
		 
		$j=1;
		foreach($arr_encashed_rewards as $key => $row)
		{ 
			$time = strtotime($row['redeam_date']);
			$time = $time + 19800;
			$date = date('d-M-Y h:i A',$time);
			
			$reward_file_type = stripslashes($row['reward_list_file_type']);
			$reward_file = stripslashes($row['reward_list_file']);
			$reward_module_title = stripslashes($row['reward_module_title']);
			
			
			$random_all_module_no = $row['random_all_module_no'];
			if($random_all_module_no == '0')
			{
				$encashed_type = 'Module Based';
			}
			else
			{
				$encashed_type = 'Total Points/All Module';
			}
			
			
			$reward_file_str = '';
			
			if($reward_file != '')
			{  
				if($reward_file_type == 'Pdf')
				{
					$reward_file_str = '<a target="_blank" href="'.SITE_URL.'/uploads/'.$reward_file.'"><img border="0" src="images/pdf-download-icon.png" width="50" height="50"  /> </a>';
				}
				elseif($reward_file_type == 'Video')
				{   
					$video_url = getYoutubeString($reward_file);
					$reward_file_str = '<a target="_blank" href="'.$video_url.'">'.$video_url.'</a>';
				}
				else
				{ 
					$reward_file_str = '<a href="'.SITE_URL.'/uploads/'. $reward_file.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $reward_file.'" width="100" alt="gallery thumbnail" /></a>';

				}		
			}
			
	$output .= '	<tr>
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$j.'</td>
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.getUserFullNameById($row['user_id']).'</td>
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$reward_module_title.'</td>
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$encashed_type.'</td>
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.stripslashes($row['encashed_points']).'</td>
						<td height="30" align="left" valign="middle" bgcolor="#FFFFFF">
							<div style="width:240px;float:left;margin-left:5px;margin-right:5px;">
								<div style="width:135px;float:left;">'.stripslashes($row['reward_list_name']).'</div>
								<div style="width:100px;float:left;text-align:right;margin-right:5px;">'.$reward_file_str.'</div>
							</div>
						</td>
						<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$date.'</td>
					</tr>';
			$j++;
		} 
	$output .= '</table>
	<table width="760" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
		</tr>
	</table>';
	
	}	
	else
	{
	$output .= '<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td>'.$err_msg.'</td>
		</tr>
	</table>';
	}
	
	return $output;
}
function doRedeamAllModule($user_id,$arr_reward_module_id,$reward_list_id,$arr_selected_encashed_point,$arr_module_total_balance_points)
{
	global $link;
	$return = false;
	
	$random_all_module_no = rand(100000,99999);
	if(count($arr_reward_module_id) > 0)
	{
		for($i=0;$i<count($arr_reward_module_id);$i++)
		{
			$reward_module_id = $arr_reward_module_id[$i];
			$encashed_points = $arr_selected_encashed_point[$i];
			$points_before_redeamed = $arr_module_total_balance_points[$i];
			$points_after_redeamed = $points_before_redeamed - $encashed_points;
						
			$return = doRedeam($user_id,$reward_module_id,$reward_list_id,$points_before_redeamed,$encashed_points,$points_after_redeamed,$random_all_module_no);
		}	
	}	
	
	return $return;
}	

function doRedeam($user_id,$reward_module_id,$reward_list_id,$points_before_redeamed,$encashed_points,$points_after_redeamed,$random_all_module_no)
{
	global $link;
	$return = false;
	
	$sql = "INSERT INTO `tblrewardredeamed` (`user_id`,`reward_module_id`,`reward_list_id`,`encashed_points`,`points_before_redeamed`,`points_after_redeamed`,`random_all_module_no`) VALUES ('".$user_id."','".$reward_module_id."','".$reward_list_id."','".$encashed_points."','".$points_before_redeamed."','".$points_after_redeamed."','".$random_all_module_no."')";
	//echo"<br>".$sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
	}
	
	return $return;
}	

function getTotalPointsOfSelectedGiftItem($reward_list_id)
{
	global $link;
	$reward_list_conversion_value = 0;
	
	$sql = "SELECT * FROM `tblrewardlist` WHERE `reward_list_deleted` = '0' AND `reward_list_status` = '1'  AND `reward_list_id` IN (".$reward_list_id.")  ORDER BY `reward_list_add_datetime` DESC ";
	//echo '<br>'.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			$reward_list_conversion_value += $row['reward_list_conversion_value'] + 0;
		}			
	}
	
	return $reward_list_conversion_value;
}
function chkIfUserCanRedeamGift($user_id,$start_date,$reward_module_id,$balance_points)
{
	global $link;
	$return = false;
	
	//$sql = "SELECT * FROM `tblrewardlist` WHERE `reward_list_deleted` = '0' AND `reward_list_status` = '1'  AND `reward_list_module_id` = '".$reward_module_id."' AND EXTRACT(YEAR_MONTH FROM reward_list_date) <= '".date('Ym',strtotime($start_date))."' ORDER BY `reward_list_add_datetime` DESC ";
	$sql = "SELECT * FROM `tblrewardlist` WHERE `reward_list_deleted` = '0' AND `reward_list_status` = '1'  AND `reward_list_module_id` = '".$reward_module_id."' AND `reward_list_date` <= '".date('Y-m-d')."' ORDER BY `reward_list_add_datetime` DESC ";
	//echo '<br>'.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			$reward_list_conversion_type_id = $row['reward_list_conversion_type_id'];
			$reward_list_conversion_value = stripslashes($row['reward_list_conversion_value']);
			if($balance_points >= $reward_list_conversion_value)
			{
				$return = true;
			}
		}			
	}
	
	return $return;
}
function viewAllModuleRedeamPopup($user_id,$arr_summary_reward_module_id,$arr_summary_reward_module_title,$arr_summary_total_balance_points)
{
	global $link;
	$output = '';
	
	$total_balance_points = 0;
	for($i=0;$i<count($arr_summary_total_balance_points);$i++)
	{
		$total_balance_points += $arr_summary_total_balance_points[$i];
	}
	
	$reward_module_id = '15';
	
	//if(chkIfUserCanRedeamGift($user_id,$start_date,$reward_module_id,$total_balance_points))
	//{
		$output .= '<table width="720" border="0" cellpadding="0" cellspacing="0" >
					<tbody>
						<tr>
							<td width="100%" height="30" align="left" valign="middle"><strong>Module List:</strong></td>
						</tr>';
		$output .= '</tbody>
					</table>';
		
		$output .= '<div style="margin-top:15px;width:720px;height:200px;overflow:scroll;">';
		$output .= '	<table width="700" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
						<tbody>
							<tr>
								<td width="10%" height="30" align="center" valign="middle"><strong>Select</strong></td>
								<td width="30%" height="30" align="center" valign="middle"><strong>Module</strong></td>
								<td width="20%" height="30" align="center" valign="middle"><strong>Balance Point</strong></td>
								<td width="40%" height="30" align="center" valign="middle"><strong>Encash Point</strong></td>
							</tr>';			
		$cnt_modules = 0;
		for($i=0,$j=1;$i<count($arr_summary_reward_module_id);$i++,$j++)
		{
			if($arr_summary_total_balance_points[$i] == '' || $arr_summary_total_balance_points[$i] == '0')
			{
			
			}
			else
			{
		$output .= '		<tr>
								<td height="30" align="center" valign="middle"><strong><input type="checkbox" name="selected_reward_module_id" id="selected_reward_module_id_'.$i.'" value="'.$i.'" onclick="setTotalEncashedPoints(\''.$i.'\')" /></strong></td>
								<td height="30" align="center" valign="middle"><strong>'.$arr_summary_reward_module_title[$i].'</strong></td>
								<td height="30" align="center" valign="middle"><strong>'.$arr_summary_total_balance_points[$i].'</strong></td>
								<td height="30" align="center" valign="middle">
									<input type="text" readonly="readonly" maxlength="4" size="4" name="selected_encashed_point_'.$i.'" id="selected_encashed_point_'.$i.'" value="" onkeyup="setTotalEncashedPoints(\''.$i.'\')"   />
									<input type="hidden" name="hdnmodule_total_balance_points_'.$i.'" id="hdnmodule_total_balance_points_'.$i.'" value="'.$arr_summary_total_balance_points[$i].'"  />
									<input type="hidden" name="hdnmodule_id_'.$i.'" id="hdnmodule_id_'.$i.'" value="'.$arr_summary_reward_module_id[$i].'"  />
									<input type="hidden" name="hdnselectedmodule_title_'.$i.'" id="hdnselectedmodule_title_'.$i.'" value="'.$arr_summary_reward_module_title[$i].'"  />
								</td>
							</tr>';
				$cnt_modules++;				
			}				
		}
		$output .= '	</tbody>
						</table>
					</div>';		
					
		$output .= '<table width="720" border="0" cellpadding="0" cellspacing="0" >
					<tbody>
						<tr>
							<td width="100%" height="30" align="left" valign="middle">
								<input type="hidden" name="hdnallmoduletotal_balance_points" id="hdnallmoduletotal_balance_points" value="'.$total_balance_points.'"  />
								<strong>Total Balance Points : <span id="idallmoduletotal_balance_points">'.$total_balance_points.'</span></strong>
							</td>
						</tr>
						<tr>
							<td height="30" align="left" valign="middle">
								<input type="hidden" name="hdnallmoduletotal_encash_points" id="hdnallmoduletotal_encash_points" value="0"  />
								<strong>Total Selected Encash Points : <span id="idallmoduletotal_encash_points">0</span></strong>
							</td>
						</tr>
					</tbody>
					</table>';	
		$output .= '<table width="720" border="0" cellpadding="0" cellspacing="0" >
					<tbody>
						<tr>
							<td width="100%" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>';							
					
		$output .= '<table width="720" border="0" cellpadding="0" cellspacing="0" >
					<tbody>
						<tr>
							<td width="100%" height="30" align="left" valign="middle"><strong>Gift List:</strong></td>
						</tr>';
		$output .= '</tbody>
					</table>';								
		
		//$sql = "SELECT * FROM `tblrewardlist` WHERE `reward_list_status` = '1' AND `reward_list_deleted` = '0' AND CAST(`reward_list_conversion_value` AS SIGNED) <= '".$total_balance_points."' AND `reward_list_module_id` = '15' ORDER BY `reward_list_date` DESC ";
		$sql = "SELECT * FROM `tblrewardlist` WHERE `reward_list_status` = '1' AND `reward_list_deleted` = '0' AND `reward_list_module_id` = '15' ORDER BY `reward_list_date` DESC ";
		$result = mysql_query($sql,$link);
		
		$output .= '<div style="margin-top:15px;width:720px;height:120px;overflow:scroll;">';
			$output .= '	<table width="700" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
							<tbody>
								<tr>
									<td width="10%" height="30" align="center" valign="middle"><strong>Select</strong></td>
									<td width="20%" height="30" align="center" valign="middle"><strong>Points</strong></td>
									<td width="70%" height="30" align="center" valign="middle"><strong>Rewards</strong></td>
								</tr>';
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$i = 0;
			$j = 1;
			while ($row = mysql_fetch_assoc($result)) 
			{
				$reward_list_conversion_value = $row['reward_list_conversion_value'];
				//echo '<br>test - reward_list_conversion_value = '.$reward_list_conversion_value;
				//echo '<br>test - total_balance_points = '.$total_balance_points;
				if($reward_list_conversion_value <= $total_balance_points)
				{
					$reward_file_type = stripslashes($row['reward_list_file_type']);
					$reward_file = stripslashes($row['reward_list_file']);
					
					
					$reward_file_str = '';
					
					if($reward_file != '')
					{  
						if($reward_file_type == 'Pdf')
						{
							$reward_file_str = '<a target="_blank" href="'.SITE_URL.'/uploads/'.$reward_file.'"><img border="0" src="images/pdf-download-icon.png" width="50" height="50"  /> </a>';
						}
						elseif($reward_file_type == 'Video')
						{   
							$video_url = getYoutubeString($reward_file);
							$reward_file_str = '<a target="_blank" href="'.$video_url.'">'.$video_url.'</a>';
						}
						else
						{ 
							//$reward_file_str = '<img border="0" src="'.SITE_URL.'/uploads/'. $reward_file.'" height="50"  />'; 
							
							$reward_file_str = '<ul class="zoomonhoverul">
								<li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $reward_file.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $reward_file.'" width="100" alt="gallery thumbnail" /></a></li>
							</ul>';
		
						}		
					}
						
					
		
					$output .= '	<tr>
										<td height="30" align="center" valign="middle"><input type="radio" name="reward_list_id" id="reward_list_id_'.$i.'" value="'.$row['reward_list_id'].'" onclick="setTotalGiftPoints(\''.$i.'\')" /></td>
										<td height="30" align="center" valign="middle">
											<input type="hidden" name="hdnreward_list_conversion_value_'.$i.'" id="hdnreward_list_conversion_value_'.$i.'" value="'.$row['reward_list_conversion_value'].'"  />
											'.stripslashes($row['reward_list_conversion_value']).'
										</td>
										<td height="30" align="left" valign="middle">
											<div style="width:240px;float:left;margin-left:5px;margin-right:5px;">
												<div style="width:135px;float:left;">'.stripslashes($row['reward_list_name']).'</div>
												<div style="width:100px;float:left;text-align:right;margin-right:5px;">'.$reward_file_str.'</div>
											</div>
										</td>
									</tr>';
					$j++;			
					$i++;			
				}		
			}
			
			$cnt_gifts = $i;
			
			
		}
		else
		{
			$output .= '	<tr>
								<td colspan="3" height="30" align="center" valign="middle">No Gift is available for now.</td>
								
							</tr>';
		}
		
		$output .= '	</tbody>
							</table>';
							
		
			$output .= '</div>';
	
		$output .= '<table width="720" border="0" cellpadding="0" cellspacing="0" >
					<tbody>
						<tr>
							<td width="100%" height="30" align="left" valign="middle">
								<input type="hidden" name="hdnallmoduletotal_gift_points" id="hdnallmoduletotal_gift_points" value="0"  />
								<strong>Total Gift Points : <span id="idallmoduletotal_gift_points">0</span></strong>
							</td>
						</tr>
					</tbody>
					</table>';			
		
		$output .= '<table width="700" border="0" cellpadding="0" cellspacing="0" >
					<tbody>
						<tr>
							<td width="100%" height="30" align="left" valign="middle"><input type="button" name="btnDoRedeam" id="btnDoRedeam" value="Redeem" onclick="doRedeamAllModule(\''.$cnt_modules.'\',\''.$cnt_gifts.'\')" /></td>
						</tr>';
							
		$output .= '</tbody>
					</table>';	
	/*
	}	
	else
	{
		$output .= '<p></p><table width="400" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
					<tbody>	
						<tr>
							<td height="30" align="center" valign="middle">Currently you are not eligible for any Gift for this module! </td>
						</tr>
					</tbody>
					</table>';	
	}
	*/
	
	return $output;
}
function viewModuleWiseRedeamPopup($user_id,$start_date,$reward_module_id,$balance_points,$reward_module_title)
{
	global $link;
	$output = '';
	
	if(chkIfUserCanRedeamGift($user_id,$start_date,$reward_module_id,$balance_points))
	{
		$output .= '<table width="700" border="0" cellpadding="0" cellspacing="0" >
					<tbody>
						<tr>
							<td width="100%" height="30" align="left" valign="middle"><strong>Module: '.$reward_module_title.'</strong></td>
						</tr>
						<tr>
							<td height="30" align="left" valign="middle"><strong>Balance Points: '.$balance_points.'</strong></td>
						</tr>';
							
		$output .= '</tbody>
					</table>';					
		
		$sql = "SELECT * FROM `tblrewardlist` WHERE `reward_list_status` = '1' AND `reward_list_deleted` = '0' AND CAST(`reward_list_conversion_value` AS SIGNED) <= '".$balance_points."' AND `reward_list_module_id` = '".$reward_module_id."' ORDER BY `reward_list_date` DESC ";
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$output .= '<div style="margin-top:15px;width:720px;height:300px;overflow:scroll;">';
			$output .= '	<table width="700" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
							<tbody>
								<tr>
									<td width="10%" height="30" align="center" valign="middle"><strong>Select</strong></td>
									<td width="20%" height="30" align="center" valign="middle"><strong>Points</strong></td>
									<td width="70%" height="30" align="center" valign="middle"><strong>Rewards</strong></td>
								</tr>';
								
								
			$i = 0;
			$j = 1;
			while ($row = mysql_fetch_assoc($result)) 
			{
				$reward_file_type = stripslashes($row['reward_list_file_type']);
				$reward_file = stripslashes($row['reward_list_file']);
				
				
				$reward_file_str = '';
				
				if($reward_file != '')
				{  
					if($reward_file_type == 'Pdf')
					{
						$reward_file_str = '<a target="_blank" href="'.SITE_URL.'/uploads/'.$reward_file.'"><img border="0" src="images/pdf-download-icon.png" width="50" height="50"  /> </a>';
					}
					elseif($reward_file_type == 'Video')
					{   
						$video_url = getYoutubeString($reward_file);
						$reward_file_str = '<a target="_blank" href="'.$video_url.'">'.$video_url.'</a>';
					}
					else
					{ 
						//$reward_file_str = '<img border="0" src="'.SITE_URL.'/uploads/'. $reward_file.'" height="50"  />'; 
						
						$reward_file_str = '<ul class="zoomonhoverul">
							<li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $reward_file.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $reward_file.'" width="100" alt="gallery thumbnail" /></a></li>
						</ul>';
	
					}		
				}
					
				
	
				$output .= '	<tr>
									<td height="30" align="center" valign="middle"><input type="checkbox" name="reward_list_id" id="reward_list_id_'.$i.'" value="'.$row['reward_list_id'].'" /></td>
									<td height="30" align="center" valign="middle">'.stripslashes($row['reward_list_conversion_value']).'</td>
									<td height="30" align="left" valign="middle">
										<div style="width:240px;float:left;margin-left:5px;margin-right:5px;">
											<div style="width:135px;float:left;">'.stripslashes($row['reward_list_name']).'</div>
											<div style="width:100px;float:left;text-align:right;margin-right:5px;">'.$reward_file_str.'</div>
										</div>
									</td>
								</tr>';
				$j++;			
				$i++;			
			}
			
			$output .= '	</tbody>
							</table>';
		
			$output .= '</div>';
		}
		
		$output .= '<table width="700" border="0" cellpadding="0" cellspacing="0" >
					<tbody>
						<tr>
							<td width="100%" height="30" align="left" valign="middle"><input type="button" name="btnDoRedeam" id="btnDoRedeam" value="Redeem" onclick="doRedeam(\''.$reward_module_id.'\',\''.$balance_points.'\')" /></td>
						</tr>';
							
		$output .= '</tbody>
					</table>';	
	}	
	else
	{
		$output .= '<p></p><table width="400" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
					<tbody>	
						<tr>
							<td height="30" align="center" valign="middle">Currently you are not eligible for any Gift for this module! </td>
						</tr>
					</tbody>
					</table>';	
	}
	
	return $output;
}
function updateTheme($theam_name,$color_code,$image,$credit,$credit_url,$status,$day,$theam_id,$practitioner_id,$country_id,$state_id,$city_id,$place_id,$user_id,$keywords)
{
	global $link;
	$return = false;
	$sql = "UPDATE `tbltheams` SET `theam_name` = '".addslashes($theam_name)."' , `color_code` = '".addslashes($color_code)."' , `image` = '".addslashes($image)."' , `credit` = '".addslashes($credit)."', `credit_url` = '".addslashes($credit_url)."', `status` = '".addslashes($status)."' ,`day` = '".addslashes($day)."'  ,`country_id` = '".addslashes($country_id)."'  ,`state_id` = '".addslashes($state_id)."'  ,`city_id` = '".addslashes($city_id)."'  ,`place_id` = '".addslashes($place_id)."'  ,`user_id` = '".addslashes($user_id)."'  ,`keywords` = '".addslashes($keywords)."'  WHERE `theam_id` = '".$theam_id."' AND `practitioner_id` = '".$practitioner_id."'";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
	}
	
	return $return;
}

function addTheme($theam_name,$color_code,$image,$credit,$credit_url,$day,$practitioner_id,$country_id,$state_id,$city_id,$place_id,$user_id,$keywords)
{
	global $link;
	$return = false;
	$sql = "INSERT INTO `tbltheams`(`theam_name`,`color_code`,`image`,`credit`,`credit_url`,`day`,`status`,`practitioner_id`,`country_id`,`state_id`,`city_id`,`place_id`,`user_id`,`keywords`) VALUES ('".addslashes($theam_name)."','".addslashes($color_code)."','".addslashes($image)."','".addslashes($credit)."','".addslashes($credit_url)."','".addslashes($day)."' ,'1','".addslashes($practitioner_id)."','".$country_id."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($user_id)."','".addslashes($keywords)."')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) )
	{
		$return = true;
	}
	
	return $return;
}

function getAllThemesList($practitioner_id)
{
	global $link;
	$sql = "SELECT * FROM `tbltheams` WHERE `practitioner_id` = '".$practitioner_id."' ORDER BY status DESC, theam_add_date DESC";
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
			
			$color_div = '<div style="width:50px;height:30px;background-color:#'.stripslashes($row['color_code']).';"></div>';
			$theme_str = '<img border="0" width="100" src="'.SITE_URL.'/uploads/'.stripslashes($row['image']).'" >';
			
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
			$output .= '<td height="30" align="center"><strong>'.stripslashes($row['theam_name']).'</strong></td>';
			$output .= '<td height="30" align="center">'.$color_div.'</td>';
			$output .= '<td height="30" align="center">'.$theme_str.'</td>';
			$output .= '<td height="30" align="center">'.$date_value.'</td>';
			$output .= '<td height="30" align="center">'.$status.'</td>';
			$output .= '<td align="center" nowrap="nowrap">';
					
			$output .= '<a href="edit_theme.php?id='.$row['theam_id'].'" ><img src = "images/edit.png" width="10" border="0"></a>';
						
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
function getCatagoryOptions($catagory_id)
{
	global $link;
	$option_str = '';
	if($catagory_id == "9999999999")
		{	
			$sel = ' selected ';
		}
		else
		{
				$sel = '';
		}
	
	$option_str .= '<option value="9999999999" '.$sel.'>All</option>';
	$sql = "SELECT * FROM `tblcatagories` ORDER BY `catagory_id` ASC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			if($row['catagory_id'] == $catagory_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}
					
			$option_str .= '<option value="'.$row['catagory_id'].'" '.$sel.'>'.$row['catagory'].'</option>';
			//echo $option_str;
		}
	}
	return $option_str;
}


function getExpertiseOptions($expertise_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblexpertise` ORDER BY `expertise_id` ASC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			if($row['expertise_id'] == $expertise_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['expertise_id'].'" '.$sel.'>'.$row['expertise'].'</option>';
			//echo $option_str;
		}
	}
	return $option_str;
}

function getRewardModuleOptions($reward_module_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblrewardmodules` where `reward_module_deleted` = '0' ORDER BY `reward_module_title` ASC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{	
		while($row = mysql_fetch_array($result))
		{
			if($row['reward_module_id'] == $reward_module_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			
			if($row['page_id'] == '0')
			{
				$title = stripslashes($row['reward_module_title']);
			}
			else
			{
				$title = getMenuTitleOfPage($row['page_id']);
				if($title == '')
				{
					$title = stripslashes($row['reward_module_title']);
				}
			}
			$option_str .= '<option value="'.$row['reward_module_id'].'" '.$sel.'>'.$title.'</option>';
		}
	}
	return $option_str;
}
?>