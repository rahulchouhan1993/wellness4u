<?php
function getDayOfWeekOptionsMultiple($day_of_week)
{
    
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
            if(in_array($k ,$day_of_week))
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

function setUserAlert($user_id,$alert_mode,$alert_msg,$date_type,$single_date,$start_date,$end_date,$days_of_month,$days_of_week,$report_module,$pro_user_id,$module_keyword,$scale_range,$start_scale_value,$end_scale_value,$module_criteria,$trigger_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value)
{
    global $link;
    $return = false;

    $sql = "INSERT INTO `tbluseralerts` (`user_id`,`alert_mode`,`alert_msg`,`date_type`,`single_date`,`start_date`,`end_date`,`days_of_month`,"
            . "`days_of_week`,`report_module`,`user_set`,`module_keyword`,`scale_range`,`start_scale_value`,`end_scale_value`,`module_criteria`,"
            . "`trigger_criteria`,`criteria_scale_range`,`start_criteria_scale_value`,`end_criteria_scale_value`,`user_alert_status`) "
            . "VALUES ('".$user_id."','".$alert_mode."','".addslashes($alert_msg)."','".$date_type."','".$single_date."','".$start_date."',"
            . "'".$end_date."','".$days_of_month."','".$days_of_week."','".$report_module."','".$pro_user_id."','".$module_keyword."',"
            . "'".$scale_range."','".$start_scale_value."','".$end_scale_value."','".$module_criteria."','".$trigger_criteria."','".$criteria_scale_range."',"
            . "'".$start_criteria_scale_value."','".$end_criteria_scale_value."','1')";
    //echo"<br>".$sql;
    $result = mysql_query($sql,$link);
    if($result)
    {
        $return = true;	
    }
    return $return;
}

?>