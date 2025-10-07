<?php
//require_once(SITE_PATH.'/class.paging.php');
require_once('functions_next.php');
require_once('functions_next_2.php');
require_once('functions_next_3.php');
require_once('functions_next_4.php');
require_once('functions_next_5.php');
require_once('functions_next_6.php');
require_once('functions_next_7.php');
require_once('functions_next_8.php');
require_once('functions_next_9.php');
require_once('functions_next_10.php');

function importDataOfOneTableToOther()
{
    global $link;
    $return = false;
    //Use this function once only to import data from strssbuster/angervent
    //$sql = "SELECT * FROM `tblstressbusterbox` ORDER BY `box_add_date` ASC";
    //$sql = "SELECT * FROM `tblangervent` ORDER BY `box_add_date` ASC";
    //$sql = "SELECT * FROM `tblmindjumble` ORDER BY `box_add_date` ASC";
    //$sql = "SELECT `pdf_title` AS box_title , 'Pdf' AS box_type , `pdf` AS box_banner , '' AS box_desc , `credit` AS credit_line , `credit_url` AS credit_line_url , '0' AS `sound_clip_id` , `status` , `user_uploads` AS user_add_banner , `user_id` FROM `tblstressbusterpdf` ORDER BY `stress_buster_pdf_add_date` ASC";
    //$sql = "SELECT pdf_title AS box_title , 'Pdf' AS box_type , `pdf` AS box_banner , '' AS box_desc , `credit` AS credit_line , `credit_url` AS credit_line_url , '0' AS `sound_clip_id` , `status` , `user_uploads` AS user_add_banner , `user_id` FROM `tblangerventpdf` ORDER BY `anger_vent_pdf_add_date` ASC";
    //$sql = "SELECT pdf_title AS box_title , 'Pdf' AS box_type , `pdf` AS box_banner , '' AS box_desc , `credit` AS credit_line , `credit_url` AS credit_line_url , '0' AS `sound_clip_id` , `status` , `user_uploads` AS user_add_banner , `user_id` FROM `tblmindjumblepdf` ORDER BY `mind_jumble_pdf_add_date` ASC";
    //echo $sql;			
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {	
        while($row = mysql_fetch_array($result))
        {
            $sol_box_title =  stripslashes($row['box_title']);
            $sol_box_type =  stripslashes($row['box_type']);
            $sol_box_banner =  stripslashes($row['box_banner']);
            $sol_box_desc =  stripslashes($row['box_desc']);
            $sol_credit_line =  stripslashes($row['credit_line']);
            $sol_credit_line_url =  stripslashes($row['credit_line_url']);
            $sound_clip_id =  stripslashes($row['sound_clip_id']);
            $sol_item_status =  stripslashes($row['status']);
            $user_add_banner =  stripslashes($row['user_add_banner']);
            $user_id =  stripslashes($row['user_id']);
            
            $sql2 = "INSERT INTO `tblsolutionitems`(`sol_box_title`,`sol_box_type`,`sol_box_banner`,`sol_box_desc`,`sol_credit_line`,"
                    . "`sol_credit_line_url`,`sound_clip_id`,`sol_item_status`,`user_add_banner`,`user_id`) VALUES ('".addslashes($sol_box_title)."',"
                    . "'".addslashes($sol_box_type)."','".addslashes($sol_box_banner)."','".addslashes($sol_box_desc)."','".addslashes($sol_credit_line)."',"
                    . "'".addslashes($sol_credit_line_url)."' ,'".addslashes($sound_clip_id)."','".addslashes($sol_item_status)."',"
                    . "'".addslashes($user_add_banner)."','".addslashes($user_id)."' )";
	    $result2 = mysql_query($sql2,$link);
            if($result2)
            {
                $return = true;
            }    
        }
    }
    return $return;
}

function importMusicDataOfOneTableToOther()
{
    global $link;
    $return = false;
    //Use this function once only to import data from strssbuster /angervent bg music
    //$sql = "SELECT * FROM `tblmusic` ORDER BY `music_add_date` ASC";
    //$sql = "SELECT * FROM `tblangerventmusic` ORDER BY `music_add_date` ASC";
    //$sql = "SELECT * FROM `tblmindjumblemusic` ORDER BY `music_add_date` ASC";
    //echo '<br>'.$sql;			
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {	
        while($row = mysql_fetch_array($result))
        {
            //$step =  stripslashes($row['step']);
            $step =  '1';
            $music =  stripslashes($row['music']);
            $day =  stripslashes($row['day']);
            $credit =  stripslashes($row['credit']);
            $credit_url =  stripslashes($row['credit_url']);
            $status =  stripslashes($row['status']);
            
            $sql2 = "INSERT INTO `tblsolutionbgmusic`(`step`,`music`,`day`,`credit`,`credit_url`,`status`) "
                    . "VALUES ('".addslashes($step)."','".addslashes($music)."','".addslashes($day)."','".addslashes($credit)."','".addslashes($credit_url)."','".addslashes($status)."')";
            //echo '<br>'.$sql2;	
	    $result2 = mysql_query($sql2,$link);
            if($result2)
            {
                $return = true;
            }    
        }
    }
    return $return;
}

function getAllKeywordsChkeckbox($module_id,$arr_selected_situation_id,$width = '400',$height = '350')
{
    global $link;
    $output = '';

    $data = array();
    
    //echo '<br>module_id = '.$module_id;

    if($module_id == '113')
    {
        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bmst_id` = '1' AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY `bms_name` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['bms_'.$row['bms_id']] = stripslashes($row['bms_name']);
            }
        }
    }
    elseif($module_id == '45')
    {
        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bmst_id` = '2' AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY `bms_name` ASC";
        //echo '<br>111'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['bms_'.$row['bms_id']] = stripslashes($row['bms_name']);
            }
        }

        $sql = "SELECT * FROM `tbladdictions` WHERE `status` = '1' ORDER BY `situation` ASC";
        //echo '<br>222'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['adct_'.$row['adct_id']] = stripslashes($row['situation']);
            }
        }

        $sql = "SELECT * FROM `tblsleeps` WHERE  `status` = '1' ORDER BY `situation` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result)) 
            {
                $data['sleep_'.$row['sleep_id']] = stripslashes($row['situation']);
            }
        }

        $sql = "SELECT * FROM `tblgeneralstressors` WHERE `status` = '1' ORDER BY `situation` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result)) 
            {
                $data['gs_'.$row['gs_id']] = stripslashes($row['situation']);
            }
        }

        $sql = "SELECT * FROM `tblworkandenvironments` WHERE `status` = '1' ORDER BY `situation` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['wae_'.$row['wae_id']] = stripslashes($row['situation']);
            }
        }

        $sql = "SELECT * FROM `tblmycommunications` WHERE  `status` = '1' ORDER BY `situation` ASC";
        //echo 'mc sql ='.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['mc_'.$row['mc_id']] = stripslashes($row['situation']);
            }
        }

        $sql = "SELECT * FROM `tblmyrelations` WHERE `status` = '1' ORDER BY `situation` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['mr_'.$row['mr_id']] = stripslashes($row['situation']);
            }
        }

        $sql = "SELECT * FROM `tblmajorlifeevents` WHERE  `status` = '1' ORDER BY `situation` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['mle_'.$row['mle_id']] = stripslashes($row['situation']);
            }
        }
    }
    elseif($module_id == '12')
    {
        $sql = "SELECT * FROM `tbldailyactivity` ORDER BY `activity` ASC";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['activity_'.$row['activity_id']] = stripslashes($row['activity']);
            }
        }
    }
    elseif($module_id == '13')
    {
        $sql = "SELECT * FROM `tbldailymeals` ORDER BY `meal_item` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['meal_'.$row['meal_id']] = stripslashes($row['meal_item']);
            }
        }
    }

    $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:10px;">
                        <input type="checkbox" name="all_selected_situation_id" id="all_selected_situation_id" value="1" onclick="toggleCheckBoxes(\'selected_situation_id\'); " />&nbsp;<strong>Select All</strong> 
                    </div>
                    <div style="clear:both;"></div>';

    if(count($data) > 0)
    {
        natcasesort($data);
        
        //echo '<br><pre>';
        //print_r($data);
        //echo '<br></pre>';

        $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;margin-bottom:20px;">';
        $output .= '    <ul style="list-style:none;padding:0px;margin:0px;">';
        $i = 1;
        foreach ($data as $key => $val) 
        {

            $page_id = $key;
            $page_name = $val;

            if(in_array($page_id,$arr_selected_situation_id))
            {
                $selected = ' checked ';
            }
            else
            {
                $selected = '';
            }

            //$liwidth = $width - 20;
            $liwidth = 300;

            $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_situation_id[]" id="selected_situation_id_'.$i.'" value="'.$page_id.'" />&nbsp;<strong>'.$page_name.'</strong></li>';
            $i++;
        }
        $output .= '</ul></div>';
    }
    return $output;
}

function getAllKeywordsDropdown($module_id,$selected_situation_id)
{
    global $link;
    $output = '';

    $data = array();
    
    //echo '<br>module_id = '.$module_id;

    if($module_id == '113')
    {
        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bmst_id` = '1' AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY `bms_name` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['bms_'.$row['bms_id']] = stripslashes($row['bms_name']);
            }
        }
    }
    elseif($module_id == '45')
    {
        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bmst_id` = '2' AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY `bms_name` ASC";
        //echo '<br>111'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['bms_'.$row['bms_id']] = stripslashes($row['bms_name']);
            }
        }

        $sql = "SELECT * FROM `tbladdictions` WHERE `status` = '1' ORDER BY `situation` ASC";
        //echo '<br>222'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['adct_'.$row['adct_id']] = stripslashes($row['situation']);
            }
        }

        $sql = "SELECT * FROM `tblsleeps` WHERE  `status` = '1' ORDER BY `situation` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result)) 
            {
                $data['sleep_'.$row['sleep_id']] = stripslashes($row['situation']);
            }
        }

        $sql = "SELECT * FROM `tblgeneralstressors` WHERE `status` = '1' ORDER BY `situation` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result)) 
            {
                $data['gs_'.$row['gs_id']] = stripslashes($row['situation']);
            }
        }

        $sql = "SELECT * FROM `tblworkandenvironments` WHERE `status` = '1' ORDER BY `situation` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['wae_'.$row['wae_id']] = stripslashes($row['situation']);
            }
        }

        $sql = "SELECT * FROM `tblmycommunications` WHERE  `status` = '1' ORDER BY `situation` ASC";
        //echo 'mc sql ='.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['mc_'.$row['mc_id']] = stripslashes($row['situation']);
            }
        }

        $sql = "SELECT * FROM `tblmyrelations` WHERE `status` = '1' ORDER BY `situation` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['mr_'.$row['mr_id']] = stripslashes($row['situation']);
            }
        }

        $sql = "SELECT * FROM `tblmajorlifeevents` WHERE  `status` = '1' ORDER BY `situation` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['mle_'.$row['mle_id']] = stripslashes($row['situation']);
            }
        }
    }
    elseif($module_id == '12')
    {
        $sql = "SELECT * FROM `tbldailyactivity` ORDER BY `activity` ASC";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['activity_'.$row['activity_id']] = stripslashes($row['activity']);
            }
        }
    }
    elseif($module_id == '13')
    {
        $sql = "SELECT * FROM `tbldailymeals` ORDER BY `meal_item` ASC";
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {	
            while($row = mysql_fetch_array($result))
            {
                $data['meal_'.$row['meal_id']] = stripslashes($row['meal_item']);
            }
        }
    }

    if(count($data) > 0)
    {
        natcasesort($data);
        
        foreach ($data as $key => $val) 
        {

            $page_id = $key;
            $page_name = $val;

            if($page_id == $selected_situation_id)
            {
                $selected = ' selected ';
            }
            else
            {
                $selected = '';
            }
            $output .= '<option value="'.$page_id.'" '.$selected.'>'.$page_name.'</option>';
        }
        
    }
    return $output;
}

function getDayOfWeekCommastr($str_day_of_week)
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
    
    $day_of_week = explode(',', $str_day_of_week);
    if(is_array($day_of_week) && count($day_of_week) > 0)
    {
        foreach($arr_day_of_week as $k => $v )
        {
            if(in_array($k ,$day_of_week))
            {
                $option_str .= $v.',';
            }
        }
        $option_str = substr($option_str, 0 ,-1);
    }

    
    return $option_str;
}

function getMonthsCommastr($str_month)
{
    
    $option_str = '';
    
    $arr_record = array (
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    );
    
    $arr_month = explode(',', $str_month);
    if(is_array($arr_month) && count($arr_month) > 0)
    {
        foreach($arr_record as $k => $v )
        {
            if(in_array($k ,$arr_month))
            {
                $option_str .= $v.',';
            }
        }
        $option_str = substr($option_str, 0 ,-1);
    }
   
    return $option_str;
}

function getModuleNamePCM($module_id)
{
    $return = 'All Modules';

    if($module_id == '12')
    {
        $return = 'My Activity';
    }
    elseif($module_id == '13')
    {
        $return = 'My Food Today';
    }
    elseif($module_id == '45')
    {
        $return = 'My Situation Today';
    }
    elseif($module_id == '113')
    {
        $return = 'My Current Physical State';
    }

    return $return;
}

function getKeywordName($solution_id,$solution_type)
    {
        global $link;
        $name = '';
        
        if($solution_type == 'bms')
        {
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$solution_id."' ";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $row = mysql_fetch_array($result);
                $name = stripslashes($row['bms_name']);
            }
        } 
        elseif($solution_type == 'adct')
        {
            $sql = "SELECT * FROM `tbladdictions` WHERE `adct_id` = '".$solution_id."'";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $row = mysql_fetch_array($result);
                $name = stripslashes($row['situation']);
            }
        }
        elseif($solution_type == 'sleep')
        {
            $sql = "SELECT * FROM `tblsleeps` WHERE `sleep_id` = '".$solution_id."'";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $row = mysql_fetch_array($result);
                $name = stripslashes($row['situation']);
            }
        }
        elseif($solution_type == 'gs')
        {
            $sql = "SELECT * FROM `tblgeneralstressors` WHERE `gs_id` = '".$solution_id."'";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $row = mysql_fetch_array($result);
                $name = stripslashes($row['situation']);
            }
        }
        elseif($solution_type == 'wae')
        {
            $sql = "SELECT * FROM `tblworkandenvironments` WHERE `wae_id` = '".$solution_id."'";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $row = mysql_fetch_array($result);
                $name = stripslashes($row['situation']);
            }
        }
        elseif($solution_type == 'mc')
        {
            $sql = "SELECT * FROM `tblmycommunications` WHERE `mc_id` = '".$solution_id."'";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $row = mysql_fetch_array($result);
                $name = stripslashes($row['situation']);
            }
        }
        elseif($solution_type == 'mr')
        {
            $sql = "SELECT * FROM `tblmyrelations` WHERE `mr_id` = '".$solution_id."'";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $row = mysql_fetch_array($result);
                $name = stripslashes($row['situation']);
            }
        }
        elseif($solution_type == 'mle')
        {
            $sql = "SELECT * FROM `tblmajorlifeevents` WHERE `mle_id` = '".$solution_id."'";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $row = mysql_fetch_array($result);
                $name = stripslashes($row['situation']);
            }
        }
        elseif($solution_type == 'meal')
        {
            $sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$solution_id."'";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $row = mysql_fetch_array($result);
                $name = stripslashes($row['meal_item']);
            }
        }
        elseif($solution_type == 'activity')
        {
            $sql = "SELECT * FROM `tbldailyactivity` WHERE `activity_id` = '".$solution_id."'";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $row = mysql_fetch_array($result);
                $name = stripslashes($row['activity']);
            }
        }
        
        return $name;
    }
    
    function getKeywordScaleValueStr($keyword_scale_type,$keyword_scale_value1,$keyword_scale_value2)
    {
        $output = 'All';
        
        if($keyword_scale_type == '1')
        {
            $output = '<(Less Than) '.$keyword_scale_value1;
        }
        elseif($keyword_scale_type == '2')
        {
            $output = '>(Greater Than) '.$keyword_scale_value1;
        }
        elseif($keyword_scale_type == '3')
        {
            $output = '&le; (Less than or Equal to) '.$keyword_scale_value1;
        }
        elseif($keyword_scale_type == '4')
        {
            $output = '&ge; (Greater than or Equal to) '.$keyword_scale_value1;
        }
        elseif($keyword_scale_type == '5')
        {
            $output = '=(Equal) '.$keyword_scale_value1;
        }
        elseif($keyword_scale_type == '6')
        {
            $output = '(Range) '.$keyword_scale_value1.' - '.$keyword_scale_value2;
        }
        
        return $output;
    }
    
    function getCriteriaName($module_criteria)
    {
        $option_str = 'All';

        
            if($module_criteria == '3')
            {
                $option_str = 'Duration';
            }
            elseif($module_criteria == '4')
            {
                $option_str = 'Time';
            }
            elseif($module_criteria == '5')
            {
                $option_str = 'Quantity';
            }
            elseif($module_criteria == '6')
            {
                $option_str = 'My Desire';
            }
            elseif($module_criteria == '7')
            {
                $option_str = 'Days';
            }
            elseif($module_criteria == '8')
            {
                $option_str = 'Calories Burnt';
            }
            elseif($module_criteria == '9')
            {
                $option_str = 'Triggers';
            }
        return $option_str;
    }
    
    function getCriteriaScaleValueStr($keyword_scale_type,$keyword_scale_value1,$keyword_scale_value2)
    {
        $output = 'All';
        
        if($keyword_scale_type == '1')
        {
            $output = '<(Less Than) '.$keyword_scale_value1;
        }
        elseif($keyword_scale_type == '2')
        {
            $output = '>(Greater Than) '.$keyword_scale_value1;
        }
        elseif($keyword_scale_type == '3')
        {
            $output = '&le; (Less than or Equal to) '.$keyword_scale_value1;
        }
        elseif($keyword_scale_type == '4')
        {
            $output = '&ge; (Greater than or Equal to) '.$keyword_scale_value1;
        }
        elseif($keyword_scale_type == '5')
        {
            $output = '=(Equal) '.$keyword_scale_value1;
        }
        elseif($keyword_scale_type == '6')
        {
            $output = '(Range) '.$keyword_scale_value1.' - '.$keyword_scale_value2;
        }
        
        return $output;
    }
    

function getAllProfileCustomizationSelectionStr($prct_ref_no,$arr_prct_id,$prct_cat_id)
{
    global $link;
    $output = '';
    
    if($prct_cat_id == '')
    {
        $str_sql_cat = '';
    }
    else
    {
        //$str_sql_cat = " AND `prct_cat_id` = '".$prct_cat_id."' ";
        $str_sql_cat = '';
    }

    if($prct_ref_no == '')
    {
        $str_sql_ref_no = '';
    }
    else
    {
        $str_sql_ref_no = " AND `prct_ref_no` = '".$prct_ref_no."' ";
    }

    $output .= '<div style="width:600px;height:300px;overflow:scroll;"><table border="0" width="100%" cellpadding="1" cellspacing="1"><tbody><tr class="manage-header"><td width="5%" class="manage-header" align="center" ></td><td width="15%" class="manage-header" align="center">Module</td><td width="20%" class="manage-header" align="center">Keywords</td><td width="15%" class="manage-header" align="center">Keywords Scale</td><td width="10%" class="manage-header" align="center">Criteria</td><td width="15%" class="manage-header" align="center">Criteria Scale</td>';
    //$output .= '<td width="10%" class="manage-header" align="center">Date Type</td><td width="15%" class="manage-header" align="center">Date</td>';
    $output .= '</tr>';
    
    $sql = "SELECT * FROM `tblprofilecustomization` WHERE `deleted` = '0' AND `status` = '1' ".$str_sql_ref_no." ".$str_sql_cat."  ORDER BY `prct_add_date` DESC";
    //echo $sql;
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $j = 0;
        while($row = mysql_fetch_array($result))
        {
            if(in_array($row['prct_id'] ,$arr_prct_id))
            {
                $sel = ' checked ';
            }
            else
            {
                $sel = '';
            }

            if($row['listing_date_type'] == 'days_of_month')
                {
                    $date_type = 'Days of Month';
                    $date_value = stripslashes($row['days_of_month']);
                    $date_value = str_replace(',', ' , ', $date_value);
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
                elseif($row['listing_date_type'] == 'days_of_week')
                {
                    $date_type = 'Days of Week';
                    $date_value = getDayOfWeekCommaStr($row['days_of_week']);
                    $date_value = str_replace(',', ' , ', $date_value);
                }
                elseif($row['listing_date_type'] == 'month_wise')
                {
                    $date_type = 'Month Wise';
                    $date_value = getMonthsCommastr($row['months']);
                    $date_value = str_replace(',', ' , ', $date_value);
                }
                elseif($row['listing_date_type'] == '')
                {
                    $date_type = 'All';
                    $date_value = '';
                }
                
                $module_id = $row['module_id'];
                $module = getModuleNamePCM($module_id);
                $keyword_id = $row['keyword_id'];
                $keyword_type = $row['keyword_type'];        
                $keywords = getKeywordName($keyword_id,$keyword_type);
                $keyword_scale_type = $row['keyword_scale_type'];
                $keyword_scale_value1 = $row['keyword_scale_value1'];
                $keyword_scale_value2 = $row['keyword_scale_value2'];
                $keyword_scale_value = getKeywordScaleValueStr($keyword_scale_type,$keyword_scale_value1,$keyword_scale_value2);
                $criteria_id = $row['criteria_id'];
                $criteria = getCriteriaName($criteria_id);
                $criteria_scale_type = $row['criteria_scale_type'];
                $criteria_scale_value1 = $row['criteria_scale_value1'];
                $criteria_scale_value2 = $row['criteria_scale_value2'];
                $criteria_scale_value = getCriteriaScaleValueStr($criteria_scale_type,$criteria_scale_value1,$criteria_scale_value2);
                
                
                $output .= '<tr class="manage-row">';
                $output .= '<td height="30" align="center" nowrap="nowrap" ><input type="checkbox" '.$sel.' name="prct_id[]" id="prct_id_'.$j.'" value="'.$row['prct_id'].'"></td>';
                $output .= '<td height="30" align="center">'.$module.'</td>';
                $output .= '<td height="30" align="center">'.$keywords.'</td>';
                $output .= '<td height="30" align="center">'.$keyword_scale_value.'</td>';
                $output .= '<td height="30" align="center">'.$criteria.'</td>';
                $output .= '<td height="30" align="center">'.$criteria_scale_value.'</td>';
                //$output .= '<td height="30" align="center">'.$date_type.'</td>';
                //$output .= '<td height="30" align="center">'.$date_value.'</td>';
                $output .= '</tr>';
                $j++;
        }
    }
    else
    {
        $output .= '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';
    }
    $output .= '</tbody></table></div>';
    return $output;
}

function getAllSolutionItemsSelectionStr($arr_sol_item_id,$i=0,$sol_item_cat_id='')
{
    global $link;
    $output = '';
    
    if($sol_item_cat_id == '')
    {
        $sql_str_cat = '';
    }
    else
    {
        $sql_str_cat = " AND `sol_item_cat_id` = '".$sol_item_cat_id."' ";
    }

    $sql = "SELECT * FROM `tblsolutionitems` WHERE `sol_item_deleted` = '0' AND `sol_item_status` = '1' ".$sql_str_cat."  ORDER BY `sol_box_title` ASC";
    $result = mysql_query($sql,$link);
    $output .= '<div style="width:600px;height:300px;overflow:scroll;"><table border="0" width="100%" cellpadding="1" cellspacing="1"><tbody><tr class="manage-header"><td width="5%" class="manage-header" align="center" ></td><td width="30%" class="manage-header" align="center">Title</td><td width="5%" class="manage-header" align="center">Type</td><td width="30%" class="manage-header" align="center">Item</td><td width="30%" class="manage-header" align="center">Description</td></tr>';
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $j = 0;
        while($row = mysql_fetch_array($result))
        {
            if(in_array($row['sol_item_id'] ,$arr_sol_item_id))
            {
                $sel = ' checked ';
            }
            else
            {
                $sel = '';
            }

            $banner = stripslashes($row['sol_box_banner']);

            if($row['sol_box_type'] == 'Image')
            {
                $str_item = '<img border="0" src="'.SITE_URL.'/uploads/'.$banner.'" width="50">';
                $str_item = '<ul class="zoomonhoverul"><li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $banner.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $banner.'" width="50" alt="gallery thumbnail" /></a></li></ul>';
            }
            elseif($row['sol_box_type'] == 'Flash')
            {
                $str_item = '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="50" HEIGHT="50" id="myMovieName"><PARAM NAME=movie VALUE="'.SITE_URL.'/uploads/'. $banner.'"><PARAM NAME=quality VALUE=high><param name="wmode" value="transparent"><EMBED src="'.SITE_URL.'/uploads/'. $banner.'" quality=high WIDTH="50" HEIGHT="50" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED></OBJECT>';
            }
            elseif($row['sol_box_type'] == 'Video')
            {
                $str_item = '<iframe width="50" height="50" src="'.getBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';
            }
            else
            {
                $str_item = '<a href="'.SITE_URL.'/uploads/'. $banner.'" target="_blank">'.$banner.'</a> ';
            }

            $output .= '<tr class="manage-row">';
            $output .= '<td height="30" align="center" nowrap="nowrap" ><input type="checkbox" '.$sel.' name="sol_item_id_'.$i.'[]" id="sol_item_id_'.$i.'_'.$j.'" value="'.$row['sol_item_id'].'"></td>';
            $output .= '<td height="30" align="center"><strong>'.stripslashes($row['sol_box_title']).'</strong></td>';
            $output .= '<td height="30" align="center">'.stripslashes($row['sol_box_type']).'</td>';
            $output .= '<td align="center">'.$str_item.'</td>';
            $output .= '<td align="center"><strong>'.stripslashes($row['sol_box_desc']).'</strong></td>';
            $output .= '</tr>';
            $j++;
        }
    }
    else
    {
        $output .= '<tr class="manage-row" height="20"><td colspan="5" align="center">NO RECORDS FOUND</td></tr>';
    }
    $output .= '</tbody></table></div>';
    return $output;
}

function getAllSolutionItemsSelectionStrSingle($sol_item_id,$sol_item_cat_id='')
{
    global $link;
    $output = '';
    
    if($sol_item_cat_id == '')
    {
        $sql_str_cat = '';
    }
    else
    {
        $sql_str_cat = " AND `sol_item_cat_id` = '".$sol_item_cat_id."' ";
    }

    
    $output .= '<div style="width:600px;height:300px;overflow:scroll;"><table border="0" width="100%" cellpadding="1" cellspacing="1"><tbody><tr class="manage-header"><td width="5%" class="manage-header" align="center" ></td><td width="30%" class="manage-header" align="center">Title</td><td width="5%" class="manage-header" align="center">Type</td><td width="30%" class="manage-header" align="center">Item</td><td width="30%" class="manage-header" align="center">Description</td></tr>';
    
    $sql = "SELECT * FROM `tblsolutionitems` WHERE `sol_item_id` = '".$sol_item_id."' AND `sol_item_deleted` = '0' AND `sol_item_status` = '1' ".$sql_str_cat."  ORDER BY `sol_box_title` ASC";
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $j = 0;
        while($row = mysql_fetch_array($result))
        {
            if($row['sol_item_id'] == $sol_item_id)
            {
                $sel = ' checked ';
            }
            else
            {
                $sel = '';
            }

            $banner = stripslashes($row['sol_box_banner']);

            if($row['sol_box_type'] == 'Image')
            {
                $str_item = '<img border="0" src="'.SITE_URL.'/uploads/'.$banner.'" width="50">';
                $str_item = '<ul class="zoomonhoverul"><li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $banner.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $banner.'" width="50" alt="gallery thumbnail" /></a></li></ul>';
            }
            elseif($row['sol_box_type'] == 'Flash')
            {
                $str_item = '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="50" HEIGHT="50" id="myMovieName"><PARAM NAME=movie VALUE="'.SITE_URL.'/uploads/'. $banner.'"><PARAM NAME=quality VALUE=high><param name="wmode" value="transparent"><EMBED src="'.SITE_URL.'/uploads/'. $banner.'" quality=high WIDTH="50" HEIGHT="50" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED></OBJECT>';
            }
            elseif($row['sol_box_type'] == 'Video')
            {
                $str_item = '<iframe width="50" height="50" src="'.getBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';
            }
            else
            {
                $str_item = '<a href="'.SITE_URL.'/uploads/'. $banner.'" target="_blank">'.$banner.'</a> ';
            }

            $output .= '<tr class="manage-row">';
            $output .= '<td height="30" align="center" nowrap="nowrap" ><input type="radio" '.$sel.' name="sol_item_id" id="sol_item_id_'.$j.'" value="'.$row['sol_item_id'].'"></td>';
            $output .= '<td height="30" align="center"><strong>'.stripslashes($row['sol_box_title']).' </strong></td>';
            $output .= '<td height="30" align="center">'.stripslashes($row['sol_box_type']).'</td>';
            $output .= '<td align="center">'.$str_item.'</td>';
            $output .= '<td align="center"><strong>'.stripslashes($row['sol_box_desc']).'</strong></td>';
            $output .= '</tr>';
            $j++;
        }
    }
    
    $sql = "SELECT * FROM `tblsolutionitems` WHERE `sol_item_id` != '".$sol_item_id."' AND `sol_item_deleted` = '0' AND `sol_item_status` = '1' ".$sql_str_cat."  ORDER BY `sol_box_title` ASC";
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $j = 0;
        while($row = mysql_fetch_array($result))
        {
            if($row['sol_item_id'] == $sol_item_id)
            {
                $sel = ' checked ';
            }
            else
            {
                $sel = '';
            }

            $banner = stripslashes($row['sol_box_banner']);

            if($row['sol_box_type'] == 'Image')
            {
                $str_item = '<img border="0" src="'.SITE_URL.'/uploads/'.$banner.'" width="50">';
                $str_item = '<ul class="zoomonhoverul"><li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $banner.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $banner.'" width="50" alt="gallery thumbnail" /></a></li></ul>';
            }
            elseif($row['sol_box_type'] == 'Flash')
            {
                $str_item = '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="50" HEIGHT="50" id="myMovieName"><PARAM NAME=movie VALUE="'.SITE_URL.'/uploads/'. $banner.'"><PARAM NAME=quality VALUE=high><param name="wmode" value="transparent"><EMBED src="'.SITE_URL.'/uploads/'. $banner.'" quality=high WIDTH="50" HEIGHT="50" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED></OBJECT>';
            }
            elseif($row['sol_box_type'] == 'Video')
            {
                $str_item = '<iframe width="50" height="50" src="'.getBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';
            }
            else
            {
                $str_item = '<a href="'.SITE_URL.'/uploads/'. $banner.'" target="_blank">'.$banner.'</a> ';
            }

            $output .= '<tr class="manage-row">';
            $output .= '<td height="30" align="center" nowrap="nowrap" ><input type="radio" '.$sel.' name="sol_item_id" id="sol_item_id_'.$j.'" value="'.$row['sol_item_id'].'"></td>';
            $output .= '<td height="30" align="center"><strong>'.stripslashes($row['sol_box_title']).' </strong></td>';
            $output .= '<td height="30" align="center">'.stripslashes($row['sol_box_type']).'</td>';
            $output .= '<td align="center">'.$str_item.'</td>';
            $output .= '<td align="center"><strong>'.stripslashes($row['sol_box_desc']).'</strong></td>';
            $output .= '</tr>';
            $j++;
        }
    }
    
    $output .= '</tbody></table></div>';
    return $output;
}


function getSolutionCategoryOptions($fav_cat_id)
{
    global $link;
    $option_str = '';		

    //$sql = "SELECT * FROM `tblsolutioncategories` WHERE `sol_cat_deleted` = '0' AND `sol_cat_status` = '1'  ORDER BY `sol_cat_title` ASC";
    $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_deleted` = '0' AND `fav_cat_status` = '1' AND `fav_cat_type_id` = '2'  ORDER BY `fav_cat` ASC";
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

function getAllActiveMenuItems($parent_id)
{
	global $link;
	
	$arr_active_menu_items = array();
	
	$sql2 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$parent_id."' ORDER BY `menu_order` ASC ";
	//echo'<br><br>sql2 = '.$sql2;
	$result2 = mysql_query($sql2,$link);
	if( ($result2) && (mysql_num_rows($result2) > 0) )
	{	
		while($row2 = mysql_fetch_array($result2))
		{
			$arr_active_menu_items[$row2['page_id']]['menu_details'] = $row2;
			$arr_active_menu_items[$row2['page_id']]['submenu_details'] = array();  
			
			$sql3 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$row2['page_id']."'  ORDER BY `menu_order` ASC ";
			//echo'<br><br>sql3 = '.$sql3;
			$result3 = mysql_query($sql3,$link);
			if( ($result3) && (mysql_num_rows($result3) > 0) )
			{	
				array_push($arr_active_menu_items[$row2['page_id']]['submenu_details'] , getAllActiveMenuItems($row2['page_id'])); 
			}
		}
	}
	return $arr_active_menu_items;
}

function getAllActiveMenuItemsAdviser($parent_id)
{
	global $link;
	
	$arr_active_menu_items = array();
	
	$sql2 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$parent_id."' ORDER BY `menu_order` ASC ";
	//echo'<br><br>sql2 = '.$sql2;
	$result2 = mysql_query($sql2,$link);
	if( ($result2) && (mysql_num_rows($result2) > 0) )
	{	
		while($row2 = mysql_fetch_array($result2))
		{
			$arr_active_menu_items[$row2['page_id']]['menu_details'] = $row2;
			$arr_active_menu_items[$row2['page_id']]['submenu_details'] = array();  
			
			$sql3 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$row2['page_id']."'  ORDER BY `menu_order` ASC ";
			//echo'<br><br>sql3 = '.$sql3;
			$result3 = mysql_query($sql3,$link);
			if( ($result3) && (mysql_num_rows($result3) > 0) )
			{	
				array_push($arr_active_menu_items[$row2['page_id']]['submenu_details'] , getAllActiveMenuItemsAdviser($row2['page_id'])); 
			}
		}
	}
	return $arr_active_menu_items;
}

function getAllActiveMenuItemsVender($parent_id)
{
	global $link;
	
	$arr_active_menu_items = array();
	
	$sql2 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '1' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$parent_id."' ORDER BY `menu_order` ASC ";
	//echo'<br><br>sql2 = '.$sql2;
	$result2 = mysql_query($sql2,$link);
	if( ($result2) && (mysql_num_rows($result2) > 0) )
	{	
		while($row2 = mysql_fetch_array($result2))
		{
			$arr_active_menu_items[$row2['page_id']]['menu_details'] = $row2;
			$arr_active_menu_items[$row2['page_id']]['submenu_details'] = array();  
			
			$sql3 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '1' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$row2['page_id']."'  ORDER BY `menu_order` ASC ";
			//echo'<br><br>sql3 = '.$sql3;
			$result3 = mysql_query($sql3,$link);
			if( ($result3) && (mysql_num_rows($result3) > 0) )
			{	
				array_push($arr_active_menu_items[$row2['page_id']]['submenu_details'] , getAllActiveMenuItemsAdviser($row2['page_id'])); 
			}
		}
	}
	return $arr_active_menu_items;
}

function updateMenuOrders($arr_page_id,$arr_parent_id,$arr_menu_order,$arr_link_enable)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tblpages` SET `show_in_menu` = '0' WHERE `adviser_panel` = '0' AND `vender_panel` = '0' ";
	$result = mysql_query($sql,$link);
	if($result)
	{
		for($i=0;$i<count($arr_page_id);$i++)
		{
			$sql = "UPDATE `tblpages` SET `show_in_menu` = '1' , `parent_menu` = '".$arr_parent_id[$i]."' , `menu_order` = '".$arr_menu_order[$i]."' WHERE `page_id` = '".$arr_page_id[$i]."' AND `adviser_panel` = '0' AND `vender_panel` = '0' ";
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;
			}
		}	
	}
	
	return $return;
}

function updateMenuOrdersAdviser($arr_page_id,$arr_parent_id,$arr_menu_order,$arr_link_enable)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tblpages` SET `show_in_menu` = '0' WHERE `adviser_panel` = '1' AND `vender_panel` = '0'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		for($i=0;$i<count($arr_page_id);$i++)
		{
			$sql = "UPDATE `tblpages` SET `show_in_menu` = '1' , `parent_menu` = '".$arr_parent_id[$i]."' , `menu_order` = '".$arr_menu_order[$i]."' WHERE `page_id` = '".$arr_page_id[$i]."' AND `adviser_panel` = '1' AND `vender_panel` = '0'";
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;
			}
		}	
	}
	
	return $return;
}

function updateMenuOrdersVender($arr_page_id,$arr_parent_id,$arr_menu_order,$arr_link_enable)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tblpages` SET `show_in_menu` = '0' WHERE `adviser_panel` = '0' AND `vender_panel` = '1'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		for($i=0;$i<count($arr_page_id);$i++)
		{
			$sql = "UPDATE `tblpages` SET `show_in_menu` = '1' , `parent_menu` = '".$arr_parent_id[$i]."' , `menu_order` = '".$arr_menu_order[$i]."' WHERE `page_id` = '".$arr_page_id[$i]."' AND `adviser_panel` = '0' AND `vender_panel` = '1'";
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;
			}
		}	
	}
	
	return $return;
}

function getUserarea($step,$userarea_type)
{
	global $link;
	$return = false;
	$sql = "SELECT * FROM `tbluserarea` WHERE `userarea_type` = '".$userarea_type."' AND `step` = '".$step."' AND `status` = '1'";
		
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$step = stripslashes($row['step']);
		$box_title = stripslashes($row['box_title']);
		$box_desc = stripslashes($row['box_desc']);
	}
	return array($box_title,$box_desc);
}

function backup_tables($name,$tables = '*')
{
	global $link;
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES',$link);
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table,$link);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE IF EXISTS '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table,$link));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	$tmp_date = date("dmYHis");
	$dir      = SITE_PATH."/dbbackups/"; //zelfde map
	$file = 'wellness-db-backup-'.$tmp_date.'.sql';
	
	//save file
	$handle = fopen($dir.$file,'w+');
	fwrite($handle,$return);
	fclose($handle);
	header("Content-type: application/force-download"); 
	header('Content-Disposition: inline; filename="' . $dir.$file . '"'); 
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-length: ".filesize($dir.$file)); 
	header('Content-Type: application/octet-stream'); 
	/*Note that if I comment out the line below, the behaviour is like mendix: the download is not recognized as a Worddoc but as a zip-file or unknown extension*/
	header('Content-Disposition: attachment; filename="' . $file . '"'); 
	readfile("$dir$file"); 
}

/* AMol NEW function */
/*---------------------------------------------------- */
/* amol function Start */

function Insert_admin_reply($id,$feedback_page_id,$user_id,$name,$email,$reply)
{
	global $link;
	$return = false;
	$sql = "INSERT INTO `tblfeedback`(`parent_feedback_id`,`page_id`,`user_id`,`name`,`email`,`feedback`,`admin`,`status`) VALUES ('".addslashes($id)."','".addslashes($feedback_page_id)."','".addslashes($user_id)."','".addslashes($name)."','".addslashes($email)."','".addslashes($reply)."' ,'0','1' )";
	
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}

function getGoogleAds_Details($position_id,$banner_type)
{
	global $link;
	$position = '';
	$side = '';
	$width = '';
	$height = '';
	$google_ads = '';
	
	$sql ="SELECT * FROM `tblposition` WHERE  `position_id` = '".$position_id."' ";	
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$position = stripslashes($row['position']);
		$side = stripslashes($row['side']);
		$width = stripslashes($row['width']);
		$height = stripslashes($row['height']);
		$google_ads = stripslashes($row['google_ads']);
	}	
	return array($position,$side,$width,$height,$google_ads);
}	

function getGoogleAds($position_id,$banner_type)
{

	list ($position,$side,$width,$height,$google_ads)	 =  getGoogleAds_Details($position_id,$banner_type);
	global $link;
	$output = '';
	$output .= $google_ads;
	return $output;	
}

function get_PageName($page_id)
{
	global $link;
	$page_name = '';
	
	$sql ="SELECT * FROM `tblpages` WHERE  `page_id` = '".$page_id."' ";	
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$page_name = stripslashes($row['page_name']);
	}	
	return $page_name;
}	

function  get_pageid($id)
{
		global $link;
		
		$page_id = '';
		
		$sql = "SELECT * FROM `tblfeedback` WHERE `feedback_id` = '".$id."'";
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$row = mysql_fetch_array($result);
			$page_id = stripslashes($row['page_id']);
			
		}
	return  $page_id;
}

function getALLCommentsONfeedback($id)
  {
  	global $link;
	$arr_feedback_id  = array();
	$arr_feedback  = array();
	$arr_name  = array(); 
	$arr_feedback_add_date  = array();
	$arr_admin  = array();
	$arr_feedback_id  = array();
	$arr_page_id  = array();       
	
	$sql = "SELECT * FROM `tblfeedback` WHERE  `feedback_id` = '".$id."' OR `parent_feedback_id` = '".$id."' ORDER BY `feedback_add_date` DESC";
	//echo $sql;			
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
		{	
		while($row = mysql_fetch_array($result))
			{
				array_push($arr_feedback_id , $row['feedback_id']);
				array_push($arr_feedback , $row['feedback']);
				array_push($arr_name , $row['name']);
				array_push($arr_feedback_add_date , $row['feedback_add_date']);
				array_push($arr_admin , $row['admin']);
				array_push($arr_page_id , $row['page_id']);
			}
		}
	return array($arr_feedback_id,$arr_feedback,$arr_name,$arr_feedback_add_date,$arr_admin,$arr_page_id);
}

function getLatestFeedBackID($id)
  {
  	global $link;
	
	$sql = "SELECT * FROM `tblfeedback` WHERE `parent_feedback_id` = '".$id."' ORDER BY `feedback_add_date` DESC";
    
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$row = mysql_fetch_array($result);
			$id2 = stripslashes($row['feedback_id']);
			return getLatestFeedBackID($id2);
		}
		else
		{
			return $id;
		}
	
  }

function GetAllFeedback()
{
	global $link;
	
	$arr_feedback_id  = array(); 
	$tmp_feedback_id  = array(); 
	$sql = "SELECT * FROM `tblfeedback` WHERE `admin` = '0' and `parent_feedback_id` = '0' ORDER BY `feedback_add_date` DESC";
				
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
		{	
			while($row = mysql_fetch_array($result))
			{
				array_push($tmp_feedback_id , $row['feedback_id']);
			}
			
		for($i=0;$i<count($tmp_feedback_id);$i++)
		{
			array_push($arr_feedback_id , getLatestFeedBackID($tmp_feedback_id[$i]));	
		}	
	}
	return $arr_feedback_id;
}


function getLatestConvesationID($id)
  {
  	global $link;
	
	$sql = "SELECT * FROM `tblfeedback` WHERE `feedback_id` = '".$id."' ORDER BY `feedback_add_date` DESC";
	//echo $sql.'<br/>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
		{	
			$row = mysql_fetch_array($result);
			$parent_feedback_id = $row['parent_feedback_id'];
			if($parent_feedback_id > 0)
			{
				//return $id.','.$this->getLatestConvesationID($parent_feedback_id);		
				return getLatestConvesationID($parent_feedback_id);		
			}
			else
			{
				return $id;
			}	
	   }
 }

function GetAllConvarsation($id)
{
	global $link;
	
		$sql = "SELECT * FROM `tblfeedback` WHERE `feedback_id` = '".$id."' ORDER BY `feedback_add_date` DESC";
			//echo "<br>Testkk sql = ".$sql;
			$result = mysql_query($sql,$link);
			if( ($result) && (mysql_num_rows($result) > 0) )
				{	
					$row = mysql_fetch_array($result);
					$parent_feedback_id = $row['parent_feedback_id'];
						
						$sql2 = "SELECT * FROM `tblfeedback` WHERE `parent_feedback_id` = '".$parent_feedback_id."' AND `parent_feedback_id` != '0' ORDER BY `feedback_add_date` DESC";
						//echo "<br>Testkk sql2 = ".$sql2;
						$result2 = mysql_query($sql2,$link);
						if( ($result2) && (mysql_num_rows($result2) > 0) )
							{
							while($row2 = mysql_fetch_array($result2))
							{
								$feedback_id .= $row2['feedback_id'].',';
							}	
						}
				}
			
	$str_feedback_id = $feedback_id;
	//echo "<br>Testkk str_feedback_id22222222222 = ".$str_feedback_id;
	$str_feedback_id .= getLatestConvesationID($id);
	//echo "<br>Testkk str_feedback_id = ".$str_feedback_id;
	return $str_feedback_id;
}

function  getDetailsOfFeedback($id)
	{
		global $link;
		
		$parent_feedback_id = '';
		$page_id = '';
		$user_id = '';
		$name = '';
		$email = '';
		$feedback = '';
		$admin = '';
		$status = '';
		
		$sql = "SELECT * FROM `tblfeedback` WHERE `feedback_id` = '".$id."'";
		//echo $sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$row = mysql_fetch_array($result);
			$parent_feedback_id = stripslashes($row['parent_feedback_id']);
			$page_id = stripslashes($row['page_id']);
			$user_id = stripslashes($row['user_id']);
			$name = stripslashes($row['name']);
			$feedback = stripslashes($row['feedback']);
			$admin = stripslashes($row['admin']);
			$status = stripslashes($row['status']);
		}
		return  array($parent_feedback_id,$user_id,$name,$feedback,$admin,$status);
	}


function  getHeight($position_id)
	{
		global $link;
		
		$height = '';
		
		$sql = "SELECT * FROM `tblposition` WHERE `position_id` = '".$position_id."'";
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$row = mysql_fetch_array($result);
			$height = stripslashes($row['height']);
			
		}
		return  $height;
	}
	
 function  getWidth($position_id)
	{
		global $link;
		
		$width = '';
		
		$sql = "SELECT * FROM `tblposition` WHERE `position_id` = '".$position_id."'";
		//echo $sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$row = mysql_fetch_array($result);
			$width = stripslashes($row['width']);
			
		}
		return $width;
	}

function getallcomment($select_title,$short_narration)
{
	global $link;
	
	$arr_comment_id  = array(); 
	$arr_parent_comment_id = array(); 
	$arr_comment = array();
	$arr_user_id = array(); 
	$arr_comment_type = array();
	$arr_comment_add_date = array();
	
	if($select_title != '' && $short_narration == '')
	{
		$sql = "SELECT * FROM `tblcomments` WHERE `select_title` = '".$select_title."' AND `status` = '1'  ORDER BY `comment_add_date` DESC";
	}
	elseif($select_title != '' && $short_narration != '')
	{
		$sql = "SELECT * FROM `tblcomments` WHERE `select_title` = '".$select_title."' AND `short_narration` = '".$short_narration."' AND `status` = '1' ORDER BY `comment_add_date` DESC";
	}
			
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_comment_id , stripslashes($row['comment_id']));
			array_push($arr_parent_comment_id , stripslashes($row['parent_comment_id']));
			array_push($arr_comment , stripslashes($row['comment']));
			array_push($arr_user_id , stripslashes($row['user_id']));
			array_push($arr_comment_type , stripslashes($row['comment_type']));
			array_push($arr_comment_add_date , stripslashes($row['comment_add_date']));
		}
	}
	return array($arr_comment_id,$arr_parent_comment_id,$arr_comment,$arr_user_id,$arr_comment_type,$arr_comment_add_date);

}

function timeDiff($firstTime,$lastTime){
      
   $firstTime=strtotime($firstTime);
   $lastTime=strtotime($lastTime);

    $timeDiff=$lastTime-$firstTime;
   
  	$years = abs(floor($timeDiff / 31536000));
	$days = abs(floor(($timeDiff-($years * 31536000))/86400));
	$hours = abs(floor(($timeDiff-($years * 31536000)-($days * 86400))/3600));
	$mins = abs(floor(($timeDiff-($years * 31536000)-($days * 86400)-($hours * 3600))/60));#floor($difference / 60);
	//echo "<p>Time Passed: " . $years . " Years, " . $days . " Days, " . $hours . " Hours, " . $mins . " Minutes.</p><br/>";
	
		if($years > 0)
			{
				//echo $years;
				$total =   $years . " Years ";
			}
		elseif($days > 0)
			{
				$total =   $days . " Days ".$hours . " Hours,".$mins . " Mins";
			}
		elseif($hours > 0)
			{
				$total =   $hours . " Hours,".$mins . " Mins";
			}
		elseif($mins > 0)
			{
				$total =   $mins . " Mins";
			}
		else
			{	
				$total .= ' Few Seconds';
			}
			$total .= ' before';			
   return $total;
}

function GetCommentCode($select_title,$short_narration)
  	{
		
	list($arr_comment_id,$arr_parent_comment_id,$arr_comment,$arr_user_id,$arr_comment_type,$arr_comment_add_date) = getallcomment($select_title,$short_narration);
	
	 if(count($arr_comment_id)>0)
	  { 

			$output .='<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
					<td align="left" valign="top" class="Header_brown"><strong>Recent Comments</strong></td>
					</tr>
					</table><div class="commentbox">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">';
					
					for($i=0;$i<count($arr_comment_id);$i++)
					{
					
						$name = getUserFullNameById($arr_user_id[$i]);
						//$day =	date('d-M-Y h:i A',strtotime($arr_comment_add_date[$i])); 
						
						               $time= strtotime($arr_comment_add_date[$i]);
										$time=$time+19800;
										$day = date('d-M-Y h:i A',$time);
										
						$date1 = date('d-m-y',$time); 
						$date2 = date('d-m-y');
						$diff = abs(strtotime($date2) - strtotime($date1));
						$years = floor($diff / (365*60*60*24));
						$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
						$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
						
										
						$t1 = $day; 
						$total = timeDiff($t1,date("Y-m-d H:i:s"));
									
						$len_comment =  strlen($arr_comment[$i]); 
						$first_comment = substr($arr_comment[$i], 0,60);
						$last_comment = substr($arr_comment[$i], 61,$len_comment); 
						$comment =  $first_comment.'<br/>'.$last_comment;		
										
						$output .='<tr>
							   		<td width="50%" align="left" valign="top">'.$comment.'</td>';
						$output .='	<td width="20%" align="right" valign="top" class="footer">'.$name.'</td>';		
						$output .=' <td width="30%" align="right" valign="top" class="footer">'.$day.'<br/>'.$total.'</td></tr>';
									
						$output .='<tr>
							   		<td height="25"  align="left" valign="top">&nbsp;</td></tr>';					
					} 
			$output .='</table></div>';
	  }
	return $output;
	}

function getMindJumbelAllPDF($day,$select_title,$short_narration)
{
	global $link;
	
	$arr_pdf_id = array(); 
	$arr_pdf = array(); 
	$arr_pdf_title = array(); 
	$arr_credit = array();
	$arr_credit_url = array(); 
	$arr_status = array();
	$arr_days = array();
	
	
	if($select_title != '' && $short_narration == '')
	{
		$sql = "SELECT * FROM `tblmindjumblepdf` WHERE `title_id` = '".$select_title."' AND status = '1'  ORDER BY `mind_jumble_pdf_add_date` ASC";
	}
	elseif($select_title != '' && $short_narration != '')
	{
		$sql = "SELECT * FROM `tblmindjumblepdf` WHERE `title_id` = '".$select_title."' AND `short_narration` = '".$short_narration."' AND status = '1'  ORDER BY `mind_jumble_pdf_add_date` ASC";
	}
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
		     $days = ($row['day']);
			 $arr_days = explode(",", $days);
			
				if (in_array($day,$arr_days)) 
					{	
						array_push($arr_pdf_id , $row['mind_jumble_pdf_id']);
						array_push($arr_pdf , stripslashes($row['pdf']));
						array_push($arr_pdf_title , stripslashes($row['pdf_title']));
						array_push($arr_credit , stripslashes($row['credit']));
						array_push($arr_credit_url , stripslashes($row['credit_url']));
						array_push($arr_status , stripslashes($row['status']));
					}	
		}
	}
	return array($arr_pdf_id,$arr_pdf,$arr_pdf_title,$arr_credit,$arr_credit_url,$arr_status);

}

function get_library_pdf($page_id,$values)
{
	global $link;
	$pdf = '';
	
	if($page_id == '44')
	{
		$sql ="SELECT * FROM `tblmindjumblepdf` WHERE mind_jumble_pdf_id =  '".$values."'";
	}
	elseif($page_id == '10')
	{
		$sql ="SELECT * FROM `tblangerventpdf` WHERE anger_vent_pdf_id =  '".$values."'";
	}
	elseif($page_id == '9')
	{
		$sql ="SELECT * FROM `tblstressbusterpdf` WHERE stress_buster_pdf_id = '".$values."'";
	}
        elseif($page_id == '127')
	{
		$sql ="SELECT * FROM `tblsolutionitems` WHERE sol_item_id = '".$values."'";
	}
	//echo $sql.'<br/>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
                if($page_id == '127')
                {
                    $pdf = stripslashes($row['sol_box_banner']);
                    $pdf_title = stripslashes($row['sol_box_title']); 
                }
                else
                {
                    $pdf = stripslashes($row['pdf']);
                    $pdf_title = stripslashes($row['pdf_title']);
                }    
	}
	return array($pdf,$pdf_title);
}	



function get_allpdfcode($select_title,$short_narration)
  	{
		$day = date('j');
		$page_id = '44';
	  list($arr_pdf_id,$arr_pdf1,$arr_pdf_title1,$arr_credit1,$arr_credit_url1,$arr_status1) = getMindJumbelAllPDF($day,$select_title,$short_narration);
	//print_r($arr_pdf_id);
	 if(count($arr_pdf1)>0)
	  { 
			$output .='<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
					<td align="left" valign="top"><strong>Know More:</strong></td>
					</tr>';
					
					for($i=0;$i<count($arr_pdf1);$i++)
					{
					
			$output .='<tr>
					<td height="50"  align="left" valign="top">
					<a href="'.SITE_URL."/uploads/".$arr_pdf1[$i].'" target="_blank" class="body_link">'.$arr_pdf_title1[$i].'</a>
					<input type="checkbox" class="chk_pdf" id="chk_pdf_'.$arr_pdf_id[$i].'" name="chk_pdf[]" value="'.$arr_pdf_id[$i].'" />
					<br /><a href="'.$arr_credit_url1[$i].'target="_blank"><span class="footer">'.$arr_credit1[$i].'</span></a></td></tr>';			
					} 
			$output .='<tr><td><input name="submit" type="button" id="submit" value="Add To Library"  onclick="PDF_Library(\''.$page_id.'\')"/></td></tr>';
			$output .='</table>';
	  }
	return $output;
}
	
function chk_pdf_exist($page_id,$values,$user_id)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tbllibrary` WHERE `page_id` = '".$page_id."' AND `values` = '".$values."' AND `user_id` = '".$user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}

function PDF_Library($page_id,$values,$user_id)
	{
		 global $link;
	     $return = false;
		 //print_r($values).'<br/>';
		 $temp_values = explode(",", $values);
		 //print_r($temp_values).'<br/>';
		for($i=0;$i<count($temp_values);$i++)
           	{  
				if(!chk_pdf_exist($page_id,$temp_values[$i],$user_id))
				{	
		   			$sql = "INSERT INTO `tbllibrary` (`page_id`,`values`,`user_id`,`status`) VALUES ('".addslashes($page_id)."','".addslashes($temp_values[$i])."','".addslashes($user_id)."','1')";
					$result = mysql_query($sql,$link);
				}
			}	
			if($result)
			{
				$return = true;	
			}
		return $return;	
	}

function  Delete_library($library_id)
{
	global $link;
	$return = false;
	
	$sql = "DELETE FROM `tbllibrary` WHERE `library_id` = '".$library_id."'"; 
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}


function Library_Feedback($page_id)
  	{
		$temp_page_id = getTemppageId($page_id);
		
			$output .='<form id="frm_feedback" name="frm_feedback" method="post" action="#" enctype="multipart/form-data">
                             <input type="hidden" name="main_page_id" id="main_page_id" value="'.$main_page_id.'" />
							 <input type="hidden" name="hdn_p_id" id="hdn_p_id" value="" />
							 <table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">
								<tr>
								  <td width="60%" align="left" valign="top">&nbsp;</td>
								  <td width="40%" align="left" valign="top">&nbsp;</td>
							  	</tr>
							  </table>				
                              <table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">
									<tr>
										 <td width="60%" height="40" align="left" valign="top">Subject:</td>
										 <td width="40%" height="40" align="left" valign="top">
											<select id="temp_page_id" name="temp_page_id">
											  '.getFeeadBackPages($temp_page_id).'
											 </select>
										</td>
                                   </tr>';
                                  	if(isLoggedIn())
									{
										$user_id = $_SESSION['user_id'];
										$name = getUserFullNameById($user_id);
										$email = getUserEmailById($user_id);
										$readonly = ' readonly ';
									}
									else
									{
										$readonly = '';
									}
													
             $output .='<tr>
						  <td width="60%" height="40" align="left" valign="top">Name:</td>
						  <td width="40%" height="40" align="left" valign="top">
								<input type="text" id="name" name="name"'.$readonly.'value="'.$name.'"/>
						   </td>
					  </tr>
					  <tr>
						 <td width="60%" height="40" align="left" valign="top">Email:</td>
						 <td width="40%" height="40" align="left" valign="top">
							<input type="text" id="email" name="email"'.$readonly.' value="'.$email.'"/>
						  </td>
					  </tr>
					  <tr>
						<td width="60%" height="110" align="left" valign="top">Feedback and Suggestions:</td>
						<td width="40%" height="110" align="left" valign="top">
							<textarea  cols="30" rows="5" type="text" id="feedback" name="feedback">'.$textarea.'</textarea>
						</td>
					 </tr>
					 <tr>
						<td width="60%" height="40" align="left" valign="middle">&nbsp;</td>
						<td width="40%" height="40" align="left" valign="middle"><input name="submit" type="button" class="button" id="submit" value="Submit"  onclick="GetFeedback()"/>
						</td>
					</tr>	
				  </table>
	
				</form>';
	 
	return $output;
}


function Make_Note_Details($library_id,$page_id)
{
	global $link;
	$page_name = '';
	$pdf_title = '';
	$note = '';
			
	if($page_id == '44')
	{
		$sql  ="SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				LEFT JOIN `tblmindjumblepdf` TP ON TA.values = TP.mind_jumble_pdf_id  
				WHERE `library_id` = '".$library_id."'";
	}
	elseif($page_id == '10')
	{
		$sql  ="SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				LEFT JOIN `tblangerventpdf` TP ON TA.values = TP.anger_vent_pdf_id  
				WHERE `library_id` = '".$library_id."'";
	}
	elseif($page_id == '9')
	{
		$sql  ="SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				LEFT JOIN `tblstressbusterpdf` TP ON TA.values = TP.stress_buster_pdf_id  
				WHERE `library_id` = '".$library_id."'";
	}
        elseif($page_id == '127')
	{
		$sql  ="SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				LEFT JOIN `tblsolutionitems` TP ON TA.values = TP.sol_item_id  
				WHERE `library_id` = '".$library_id."'";
	}
 
 	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$page_name = stripslashes($row['page_name']);
                if($page_id == '127')
                {
                    $pdf_title = stripslashes($row['sol_box_title']);
                }
                else
                {
                    $pdf_title = stripslashes($row['pdf_title']);
                }
                $note = stripslashes($row['note']);
		
	}	
	return array($page_name,$pdf_title,$note);
}	

function Save_Note_Details($library_id,$note)
{
	global $link;
	$return = false;
	$sql = "UPDATE `tbllibrary` SET `note` = '".$note."' , `status` = '1' where library_id = '".$library_id."'";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
	}
	return $return;	
}



function enable_report($user_id,$report_type,$flag)
{
	global $link;
	$return = false;
	if($report_type == 'Meal Chart')
	{
		$sql = "UPDATE `tblusers` SET `meal_chart` = '".$flag."' WHERE `user_id` = '".$user_id."'";
	}
	elseif($report_type == 'Food Chart')
	{
		$sql = "UPDATE `tblusers` SET `food_chart` = '".$flag."' WHERE `user_id` = '".$user_id."'";
	}
	elseif($report_type == 'Monthly Activities Calories Burnt Chart')
	{
		$sql = "UPDATE `tblusers` SET `macb_chart` = '".$flag."' WHERE `user_id` = '".$user_id."'";
	}
	elseif($report_type == 'Monthly Calories Chart')
	{
		$sql = "UPDATE `tblusers` SET `mc_chart` = '".$flag."' WHERE `user_id` = '".$user_id."'";
	}
	elseif($report_type == 'Activity Chart')
	{
		$sql = "UPDATE `tblusers` SET `activity_chart` = '".$flag."' WHERE `user_id` = '".$user_id."'";
	}
	elseif($report_type == 'Monthly Wellness Tracker Report')
	{
		$sql = "UPDATE `tblusers` SET `mwt_report` = '".$flag."' WHERE `user_id` = '".$user_id."'";
	}
	elseif($report_type == 'Digital Personal Wellness Diary')
	{
		$sql = "UPDATE `tblusers` SET `dpwd_chart` = '".$flag."' WHERE `user_id` = '".$user_id."'";
	}
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
	}
	return $return;	
}


function Make_Note($library_id,$page_id)
  	{
		list($page_name,$pdf_title,$note) = Make_Note_Details($library_id,$page_id);
	
			$output .='<table border="0" width="75%" cellpadding="0" cellspacing="0">
						<tr>
							 <td width="30%" height="40" align="right" valign="top">&nbsp;</td>
							 <td width="5%" height="40" align="center" valign="top">&nbsp;</td>
							 <td width="45%" height="40" align="left" valign="top">&nbsp;</td>
						</tr>
						<tr>
							 <td width="30%" height="40" align="right" valign="top"><strong>Page Name</strong></td>
							 <td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>
							 <td width="45%" height="40" align="left" valign="top">'.$page_name.'</td>
						</tr>
						<tr>
							 <td width="30%" height="40" align="right" valign="top"><strong>PDF:</strong></td>
							 <td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>
							 <td width="45%" height="40" align="left" valign="top">'.$pdf_title.'</td>
						</tr>';
			  $output .='<tr>
						   <td width="30%" height="40" align="right" valign="top"><strong>Note:</strong></td>
						   <td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>
						   <td width="45%" height="40" align="left" valign="top"><textarea  cols="30" rows="5" type="text" id="note" name="note">'.$note.'</textarea></td>
					   </tr>';
			  $output .='<tr>
							 <td width="30%" height="20" align="right" valign="top">&nbsp;</td>
							 <td width="5%" height="20" align="center" valign="top">&nbsp;</td>
							 <td width="45%" height="20" align="left" valign="top">&nbsp;</td>
						</tr>
						<tr>
						    <td width="30%" height="20" align="right" valign="top">&nbsp;</td>
						    <td width="5%" height="20" align="center" valign="top">&nbsp;</td>
						    <td width="45%" height="20" align="left" valign="top"><input class="btnNote" name="btnNote" id="btnNote"  type="button" value="Save" onclick="Save_Note('.$library_id.')" />
					   </tr>';
			$output .='</table>';
	 
	return $output;
}

function get_user_reports_permissions($user_id)
	{
		global $link;
		$food_chart = 0;
		$each_meal_per_day_chart=0;
		$my_activity_calories_chart = 0;
		$my_activity_calories_pi_chart = 0;		
		$activity_analysis_chart = 0;
		$meal_chart = 0;	
		$dpwd_chart = 0;	
		$mwt_report = 0;
		$datewise_emotions_report = 0;
		$statementwise_emotions_report = 0;
		$statementwise_emotions_pi_report = 0;	
		$angervent_intensity_report = 0;
		$stressbuster_intensity_report = 0;
				
		$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";
		//echo $sql;
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$row = mysql_fetch_array($result);
			$food_chart = $row['food_chart'];
			$each_meal_per_day_chart = $row['each_meal_per_day_chart'];
			$my_activity_calories_chart = $row['my_activity_calories_chart'];
			$my_activity_calories_pi_chart = $row['my_activity_calories_pi_chart'];
			$activity_analysis_chart = $row['activity_analysis_chart'];
			$meal_chart = $row['meal_chart'];
			$dpwd_chart = $row['dpwd_chart'];
			$mwt_report = $row['mwt_report'];
			$datewise_emotions_report = $row['datewise_emotions_report'];
			$statementwise_emotions_report = $row['statementwise_emotions_report'];
			$statementwise_emotions_pi_report = $row['statementwise_emotions_pi_report'];
			$angervent_intensity_report = $row['angervent_intensity_report'];
			$stressbuster_intensity_report = $row['stressbuster_intensity_report'];
		}
		return array($food_chart,$each_meal_per_day_chart,$my_activity_calories_chart,$my_activity_calories_pi_chart,$activity_analysis_chart,$meal_chart,$dpwd_chart,$mwt_report,$datewise_emotions_report,$statementwise_emotions_report,$statementwise_emotions_pi_report,$angervent_intensity_report,$stressbuster_intensity_report);
	}

function View_Library_details($user_id)
{
	global $link;
	
	$arr_page_id = array(); 
	$arr_note = array();
	$arr_pdf_title = array();
	$arr_pdf = array();
	$arr_name = array();
	$arr_page_name = array();
	$arr_library_id = array();
	$arr_status = array();
	$arr_date = array();    
	
	$sql = "SELECT * FROM `tbllibrary` 	WHERE `user_id` = '".$user_id."'  GROUP BY page_id";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
					if($row['page_id'] == '44')
					{
						$sql2  ="SELECT TA.library_id,TA.library_add_date,TA.note,TA.page_id,TS.page_name,TA.status,TP.pdf,TP.pdf_title,TU.name FROM `tbllibrary` AS TA
								LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
								LEFT JOIN `tblmindjumblepdf` TP ON TA.values = TP.mind_jumble_pdf_id
								LEFT JOIN `tblusers` TU  ON TA.user_id = TU.user_id
 								WHERE TA.user_id = '".$user_id."' AND TA.page_id = '".$row['page_id']."'
								ORDER BY TA.status desc, TS.page_name ASC,TP.pdf ASC,TA.note ASC";
					}
					elseif($row['page_id'] == '10')
					{
						$sql2  ="SELECT TA.library_id,TA.library_add_date,TA.note,TA.page_id,TS.page_name,TA.status,TP.pdf,TP.pdf_title,TU.name FROM `tbllibrary` AS TA
								LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
								LEFT JOIN `tblangerventpdf` TP ON TA.values = TP.anger_vent_pdf_id 
								LEFT JOIN `tblusers` TU  ON TA.user_id = TU.user_id 
								WHERE TA.user_id = '".$user_id."' AND TA.page_id = '".$row['page_id']."'
								ORDER BY TA.status desc,TS.page_name ASC,TP.pdf ASC,TA.note ASC";
					}
					elseif($row['page_id'] == '9')
					{
						$sql2  ="SELECT TA.library_id,TA.library_add_date,TA.note,TA.page_id,TS.page_name,TA.status,TP.pdf,TP.pdf_title,TU.name FROM `tbllibrary` AS TA
								LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
								LEFT JOIN `tblstressbusterpdf` TP ON TA.values = TP.stress_buster_pdf_id
								LEFT JOIN `tblusers` TU  ON TA.user_id = TU.user_id  
								WHERE TA.user_id = '".$user_id."' AND TA.page_id = '".$row['page_id']."'
								ORDER BY TA.status desc,TS.page_name ASC,TP.pdf ASC,TA.note ASC";
					}		
				//echo $sql2.'</br>';
					$result2 = mysql_query($sql2,$link);
					if( ($result2) && (mysql_num_rows($result2) > 0) )
					{
						while($row2 = mysql_fetch_array($result2))
						{ 
							array_push($arr_page_id , stripslashes($row['page_id']));
							array_push($arr_page_name , stripslashes($row2['page_name']));
							array_push($arr_library_id , stripslashes($row2['library_id']));
							array_push($arr_note , stripslashes($row2['note']));
							array_push($arr_pdf , stripslashes($row2['pdf']));
							array_push($arr_pdf_title , stripslashes($row2['pdf_title']));
							array_push($arr_name , stripslashes($row2['name']));
							array_push($arr_status , stripslashes($row2['status']));
						    array_push($arr_date , stripslashes($row2['library_add_date']));
							//echo'<br/>'.$row['library_add_date'];
							
						}
					}	
			
			}
	}
	return array($arr_page_id,$arr_library_id,$arr_page_name,$arr_note,$arr_pdf,$arr_pdf_title,$arr_name,$arr_status,$arr_date);

}

function getMyLibrary($user_id)
{
	global $link;
	//echo $_SESSION['user_id'];
	$arr_library_id = array(); 
	$arr_page_id = array(); 
	$arr_values = array();
	$arr_library_add_date = array();
	$arr_note = array();    
	
		$sql = "SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				 WHERE `user_id` = '".$user_id."' AND TA.status = '1' ORDER BY TA.library_add_date DESC";
	
	
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
		  	array_push($arr_library_id , $row['library_id']);
			array_push($arr_page_id , stripslashes($row['page_id']));
			array_push($arr_values , stripslashes($row['values']));
			array_push($arr_library_add_date , stripslashes($row['library_add_date']));
			array_push($arr_note , stripslashes($row['note']));
		}
	}
	return array($arr_library_id,$arr_page_id,$arr_values,$arr_library_add_date,$arr_note);

}

function GetMyLibrary_Details($user_id,$page_id,$start_date)
{
	global $link;
	$arr_library_id = array(); 
	$arr_page_id = array(); 
	$arr_values = array();
	$arr_library_add_date = array();
	$arr_note = array();    
	if($user_id != '' && $page_id == '' && $start_date == '')
	{
		$sql = "SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				 WHERE `user_id` = '".$user_id."' AND TA.status = '1' ORDER BY TA.library_add_date DESC";	
	}
	elseif($page_id != '' && $start_date == '')
	{
		$sql = "SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				 WHERE `user_id` = '".$user_id."' AND TA.page_id ='".$page_id."' AND TA.status = '1' ORDER BY TA.library_add_date DESC";	
	}
	elseif($start_date != '' && $page_id == '')
	{
		$sql = "SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				 WHERE `user_id` = '".$user_id."' AND DATE(TA.library_add_date) ='".$start_date."' AND TA.status = '1' ORDER BY TA.library_add_date DESC";	
	}
	elseif($start_date != '' && $page_id != '')
	{
		$sql = "SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				 WHERE `user_id` = '".$user_id."' AND DATE(TA.library_add_date) ='".$start_date."' AND TA.page_id ='".$page_id."' AND TA.status = '1' ORDER BY TA.library_add_date DESC";	
	}
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
		  	array_push($arr_library_id , $row['library_id']);
			array_push($arr_page_id , stripslashes($row['page_id']));
			array_push($arr_values , stripslashes($row['values']));
			array_push($arr_library_add_date , stripslashes($row['library_add_date']));
			array_push($arr_note , stripslashes($row['note']));
		}
	}
	return array($arr_library_id,$arr_page_id,$arr_values,$arr_library_add_date,$arr_note);

}

function search_library($user_id,$page_id,$start_date)
  	{	
		list($arr_library_id,$arr_pg_id,$arr_values,$arr_library_add_date,$arr_note) = GetMyLibrary_Details($user_id,$page_id,$start_date);
		
         $output .='<table width="580" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                        		<tr>
									<td width="30"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr No</strong></td>
			    					<td width="130"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Page Name</strong></td>
               						<td width="190"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>PDF</strong></td>
                                    <td width="80"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Note</strong></td>
                                    <td width="70"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Date</strong></td>
                                    <td width="50"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Make Note</strong></td>
                                    <td width="30"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Delete</strong></td>
                          		</tr>';
                        	if(count($arr_library_id) > 0)	
							{
								for($i=0,$j=1;$i<count($arr_library_id);$i++,$j++)
									{ 
								   		$page_name = get_PageName($arr_pg_id[$i]);
										
											list($pdf,$pdf_title)  = get_library_pdf($arr_pg_id[$i],$arr_values[$i]);
											
											$date = date('d-M-Y',strtotime($arr_library_add_date[$i]));
											
											if($page_name == '')
												{
												   $page_name = 'General';
												}
											else{
													$page_name = $page_name;
												}
							
			$output .='		   <tr>
                                  <td  align="center" valign="top" bgcolor="#FFFFFF">'.$j.'</td>
                                  <td  align="center" valign="top" bgcolor="#FFFFFF">'.$page_name.'</td>
                                  <td  align="left" valign="top" bgcolor="#FFFFFF" class="footer"><a href="'.SITE_URL."/uploads/".$pdf.'" target="_blank" class="body_link">'.$pdf_title.'</a></td>
                                   <td  align="center" valign="top" bgcolor="#FFFFFF">'.$arr_note[$i].'</td>
                                  <td  align="center" class="footer" valign="top" bgcolor="#FFFFFF">'. $date .'</td>
                                   <td  align="center" valign="top" bgcolor="#FFFFFF" class="footer">';
            $output .='           <input class="btnNote" name="btnNote" id="btnNote"  type="button" value="Note" onclick="MakeNote(\''.$arr_library_id[$i].'\',\''.$arr_pg_id[$i].'\')"/></td>';
			$output .='	      <td  align="center" valign="top" bgcolor="#FFFFFF" class="footer">
                                  <input  type="button" value="Delete"  onclick="Delete_libraryPDF(\''.$arr_library_id[$i].'\')"/></td>
                               </tr>';
							   }
							   }
							   else
							   {
			$output .='			<tr style="background:#FFFFFF;"><td align="center" colspan="7">No Record Found</td></tr>';	   
							   }
                           		 
			$output .='</table>';
	 
	return $output;
}

function ViewLibrary($user_id)
  	{
		list($arr_page_id,$arr_library_id,$arr_page_name,$arr_note,$arr_pdf,$arr_pdf_title,$arr_name,$arr_status,$arr_date) = View_Library_details($user_id);
		
			$output .='<table border="0" width="100%" cellpadding="7" cellspacing="1">
						<tr>
							<td><input type="submit" id="btnDelete" name="btnActive" value="Active"  />
								<input type="submit" id="btnDelete" name="btnInactive" value="Inactive" /></td>
						</tr>
						</table>	
						<table border="0" width="100%" cellpadding="7" cellspacing="1">
						<tr class="manage-header">
							<td width="10%" class="manage-header" align="center"></td>
							 <td width="5%" class="manage-header" align="center">Sno</td>
							<td width="15%" class="manage-header" align="center">Page Name</td>
							<td width="25%" class="manage-header" align="center">PDF</td>
							<td width="25%" class="manage-header" align="center">Note</td>
							<td width="10%" class="manage-header" align="center">Date</td>
							<td width="10%" class="manage-header" align="center">Status</td>
							
						</tr>';
						
					for($i=0,$j=1;$i<count($arr_library_id);$i++,$j++)
          			{   
						if($arr_status[$i] == 1)
						{
							$status = 'Active';
						}
						else
						{
							$status = 'Inactive';
						}
					
						//$date = date('d-M-Y  h:i A',strtotime($arr_date[$i]));
						 $time= strtotime($arr_date[$i]);
						 $time=$time+19800;
					     $date = date('d-M-Y h:i A',$time);
						
					
			$output .='<tr class="manage-row">
						 <td align="center"><input type="checkbox" id="chk_button_'.$i.'" name="chk_button[]" value='.$arr_library_id[$i].' /></td>
						 <td align="center">'.$j.'</td>
						 <td align="center">'.$arr_page_name[$i].'</td>
						 <td align="center"><a href="'.SITE_URL."/uploads/".$arr_pdf[$i].'" target="_blank">'.$arr_pdf_title[$i].'</a></td>
						 <td align="center">'.$arr_note[$i].'</td>
						 <td align="center">'.$date.'</td>
						 <td align="center">'.$status.'</td>';
						 }
			$output .='</tr>';
					   if(count($arr_note) == '0')
					   {
			$output .='<tr class="manage-row" height="20">
						  <td align="center" colspan="6">No Records Found</td>  
					   </tr>';
					   }		   
								
			$output .='</table>';
	 
	return $output;
}
	

function getTitleCommentsDetails($select_title)
{
	global $link;
	
	$arr_comment_id = array(); 
	$arr_comment = array(); 
	$arr_user_id = array();
	$arr_select_title = array(); 
	$arr_short_narration = array();
	
	
	$sql = "SELECT * FROM `tblcomments` WHERE `select_title` = '".$select_title."'  AND status = '1'  ORDER BY `mind_jumble_pdf_add_date` ASC";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
		 	array_push($arr_comment_id , stripslashes($row['comment_id']));
			array_push($arr_comment , stripslashes($row['comment']));
			array_push($arr_user_id , stripslashes($row['user_id']));
			array_push($arr_select_title , stripslashes($row['select_title']));
			array_push($arr_short_narration , stripslashes($row['short_narration']));
						
		}
	}
	return array($arr_comment_id,$arr_comment,$arr_user_id,$arr_select_title,$arr_short_narration);

}




function getTemppageId($page_id)
{
	global $link;
	$temp_page_id = '0';
	
	$sql ="SELECT * FROM `tblpages` WHERE show_in_feedback = '1' AND `page_id` = '".$page_id."' ORDER BY `page_add_date` DESC";	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$temp_page_id = stripslashes($row['page_id']);

	}	
	return $temp_page_id;
}	


function getFeeadBackPages($page_id)
{
    global $link;
    $option_str = '';
    
    $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '3' AND `pd_deleted` = '0' ";
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $row = mysql_fetch_array($result);
        $page_id_str = stripslashes($row['page_id_str']);

        $sql = "SELECT * FROM `tblpages` WHERE `page_id` IN (".$page_id_str.") AND `show_in_list` = '1' AND `adviser_panel` = '0' AND `vender_panel` = '0' ORDER BY `menu_title` ASC";    
        //$sql = "SELECT * FROM `tblpages` WHERE  AND `show_in_feedback` = '1' ORDER BY `page_name` ASC";
        //echo $sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            if($page_id == 0)
            {
                $sel = ' selected ';
            }
            else
            {
                $sel = '';
            }	
            $option_str .= '<option value="0" '.$sel.'>General</option>';
            while($row = mysql_fetch_array($result) ) 
            {
                if($row['page_id'] == $page_id)
                {
                    $sel = ' selected ';
                }
                else
                {
                    $sel = '';
                }		
                $option_str .= '<option value="'.$row['page_id'].'" '.$sel.'>'.stripslashes($row['page_name']).'</option>';
            }
        }
    }    
    return $option_str;
}

function GetFeedBack($user_id)
{
	global $link;
	$arr_feedback_id = array(); 
	$arr_page_id = array(); 
	$arr_user_id = array();
	$arr_name = array(); 
	$arr_email = array();
	$arr_feedback = array();
	$arr_admin = array();
	$arr_feedback_add_date = array();
	
	$sql = "SELECT * FROM `tblfeedback` WHERE  `user_id` = '".$user_id."' AND `parent_feedback_id` = '0' AND `status` = '1' ORDER BY `feedback_add_date` DESC";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			 
			array_push($arr_feedback_id , stripslashes($row['feedback_id']));
			array_push($arr_page_id , stripslashes($row['page_id']));
			array_push($arr_user_id , stripslashes($row['user_id']));
			array_push($arr_name , stripslashes($row['name']));
			array_push($arr_email , stripslashes($row['email']));
			array_push($arr_feedback , stripslashes($row['feedback']));
			array_push($arr_feedback_add_date , stripslashes($row['feedback_add_date']));
			array_push($arr_admin , stripslashes($row['admin']));
								
		}	
	}
	return array($arr_feedback_id,$arr_page_id,$arr_user_id,$arr_name,$arr_email,$arr_feedback,$arr_feedback_add_date,$arr_admin);
}

function GetAllConvarsationId($id)
{
	$main_parent_id = GetMainParantId($id);
	$str_feedback_id = getRecursiveFeedbackId($main_parent_id,$main_parent_id);
	return $str_feedback_id;
}

function GetMainParantId($id)
{
	global $link;
	
	$sql = "SELECT * FROM `tblfeedback` WHERE `feedback_id` = '".$id."' ORDER BY `feedback_add_date` DESC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{	
		$row = mysql_fetch_array($result);
		$parent_feedback_id = $row['parent_feedback_id'];
		if($parent_feedback_id == 0)
		{
			return $id;
		}
		else
		{
			return GetMainParantId($parent_feedback_id);
		}
	}
	else
	{
		return 0;
	}
}


function getRecursiveFeedbackId($main_parent_id,$return)
{
	global $link;
	$sql = "SELECT * FROM `tblfeedback` WHERE `parent_feedback_id` = '".$main_parent_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{	
		while($row = mysql_fetch_array($result) ) 
		{	
			$temp_feedback_id = $row['feedback_id'];
			if($return == '')
			{
				$return .= getRecursiveFeedbackId($temp_feedback_id,$main_parent_id).',';
			}
			else
			{
				$return .= ','.getRecursiveFeedbackId($temp_feedback_id,$main_parent_id);
			}	
		}
	}
	else
	{
		$return .= ','.$main_parent_id;
	}
	return $return;
}

function makeStringWrap($str)
{
	global $link;
	$output = '';
	if($str != '')
	{
		$tmp_arr = explode(' ',$str);
		if(is_array($tmp_arr) && count($tmp_arr) > 0)
		{
			//echo"<br><br>";
			//debug_array($tmp_arr);
			foreach($tmp_arr as $k => $v)
			{
				if(strlen($v) > 25)
				{
					$temp = $v;
					$temp1 = substr($temp,0,20);
					$temp2 = substr($temp,20,strlen($temp));
					$temp2 = '<span>'.$temp2.'</span>';
					if(strlen($temp2) > 25)
					{
						$temp = $temp2;
						$temp1 = substr($temp,0,20);
						$temp2 = substr($temp,20,strlen($temp));
						$temp2 = '<span>'.$temp2.'</span>';
						if(strlen($temp2) > 25)
						{
							$temp = $temp2;
							$temp1 = substr($temp,0,20);
							$temp2 = substr($temp,20,strlen($temp));
							$temp2 = '<span>'.$temp2.'</span>';
							$output .= $temp1.$temp2.' ';
						}
						else
						{
							$output .= $temp1.$temp2.' ';
						}	
					}
					else
					{
						$output .= $temp1.$temp2.' ';
					}	
				}
				else
				{
					$output .= $v.' ';
				}
			}
		}
		else
		{
			$output = $str;
		}	
	}
	return $output;
}


function GetAllFeedBackByID($id)
  {
  	global $link;
	$arr_feedback_id  = array();
	$arr_feedback  = array();
	$arr_name  = array(); 
	$arr_feedback_add_date  = array();
	$arr_admin  = array();
	$arr_page_id = array();
	
	$sql = "SELECT * FROM `tblfeedback` WHERE  `feedback_id` IN (".$id.") ORDER BY `feedback_add_date` DESC";
	//echo "<br>Testkk GetAllFeedBackByID sql = ".$sql;			
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{	
		while($row = mysql_fetch_array($result) ) 
			{	
				array_push($arr_feedback_id , $row['feedback_id']);
				array_push($arr_feedback , stripslashes($row['feedback']));
				array_push($arr_name , stripslashes($row['name']));
				array_push($arr_feedback_add_date , $row['feedback_add_date']);
				array_push($arr_admin , $row['admin']);
				array_push($arr_page_id , $row['page_id']);
				
			}
		}
	return array($arr_feedback_id,$arr_feedback,$arr_name,$arr_feedback_add_date,$arr_admin,$arr_page_id);
}

function getTheamOptions($theam_id,$day)
{
	global $link;
	$option_str = '';		
	$arr_days = array();
	
	$sql = "SELECT * FROM `tbltheams` WHERE status = '1' ORDER BY `theam_name` ASC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			 $days = ($row['day']);
			 $arr_days = explode(",", $days);
			
				if (in_array($day,$arr_days)) 
					{	
							if($row['theam_id'] == $theam_id)
							{
								$sel = ' selected ';
							}
							else
							{
								$sel = '';
							}		
							$option_str .= '<option value="'.$row['theam_id'].'" '.$sel.'>'.stripslashes($row['theam_name']).'</option>';
					}
			
		}
	}
	return $option_str;
}


function getMindjumbleTitle($select_title)
{
	global $link;
	$option_str = '';
	$day = date('j');		
	
	$temp_arr = array();
			
	$sql = "SELECT * FROM `tbltitle` ORDER BY `title` DESC";		
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			$temp_title_id = $row['title_id'];
			
			$sql2 = "SELECT * FROM `tblmindjumble` AS TA
					 LEFT JOIN `tbltitle` AS TC ON TA.select_title = TC.title_id
					 WHERE TA.status = '1' AND TA.select_title = '".$temp_title_id."' ORDER BY `mind_jumble_box_id` DESC";
			 
			 $result2 = mysql_query($sql2,$link);
				if( ($result2) && (mysql_num_rows($result2) > 0) )
				{
					while($row2 = mysql_fetch_array($result2) ) 
					{
		
						 $days = $row2['day'];
						 $arr_days = explode(",", $days);
						if (in_array($day,$arr_days)) 
						{
							if (!in_array($row2['title_id'],$temp_arr)) 
							{
								array_push($temp_arr,$row2['title_id']);
								if($row2['select_title'] == $select_title)
								{
									$sel = ' selected ';
								}
								else
								{
									$sel = '';
								}		
								$option_str .= '<option value="'.$row2['title_id'].'" '.$sel.'>'.stripslashes($row2['title']).'</option>';
							}	
						}
					}
				}		
		}
	}
	return $option_str;
}

function getShortNarration1($select_title,$short_narration)
{
	global $link;
	$option_str = '';		
	$day = date('j');	
		
	$sql = "SELECT * FROM `tblmindjumble` AS TA
			LEFT JOIN `tbltitle` AS TC ON TA.select_title = TC.title_id
			 WHERE `select_title` = '".$select_title."' AND TA.status = '1' ORDER BY `mind_jumble_box_id` DESC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			$days = ($row['day']);
			 $arr_days = explode(",", $days);
			if (in_array($day,$arr_days)) 
			{ 	
				if($row['short_narration'] == $short_narration)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				$option_str .= '<option value="'.$row['short_narration'].'" '.$sel.'>'.stripslashes($row['short_narration']).'</option>';
			}
		}
	}
	return $option_str;
}


function getShortNarration($select_title,$short_narration)
{
	global $link;
	$option_str = '';
	$day = date('j');		
	
	$temp_arr = array();
	
	$sql = "SELECT * FROM `tblnarration` where `title_id` = '".$select_title."' ORDER BY `narration` DESC";		
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			$temp_narration_id = $row['narration_id'];
			
			$sql2 = "SELECT * FROM `tblmindjumble` AS TA
					 LEFT JOIN `tblnarration` AS TC ON TA.short_narration = TC.narration_id
					 WHERE TA.status = '1' AND TA.short_narration = '".$temp_narration_id."' ORDER BY `mind_jumble_box_id` DESC";
			 //echo $sql2;
			 $result2 = mysql_query($sql2,$link);
				if( ($result2) && (mysql_num_rows($result2) > 0) )
				{
					while($row2 = mysql_fetch_array($result2) ) 
					{
						 $days = $row2['day'];
						 $arr_days = explode(",", $days);
						if (in_array($day,$arr_days)) 
						{
							if (!in_array($row2['narration_id'],$temp_arr)) 
							{
								array_push($temp_arr,$row2['narration_id']);
								if($row2['narration_id'] == $short_narration)
								{
									$sel = ' selected ';
								}
								else
								{
									$sel = '';
								}		
								$option_str .= '<option value="'.$row2['narration_id'].'" '.$sel.'>'.stripslashes($row2['narration']).'</option>';
							}	
						}
					}
				}		
		}
	}
	return $option_str;
}


function getShortNarrationID($title_id,$short_narration)
{
	global $link;
	$option_str = '';		
			
	$sql = "SELECT * FROM `tblnarration` WHERE `title_id` = '".$title_id."' AND status = '1' ORDER BY `narration_add_date` DESC";
    //echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			if($row['narration_id'] == $narration_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['narration_id'].'" '.$sel.'>'.stripslashes($row['narration']).'</option>';
		}
	}
	return $option_str;
}

function getOnKeyUpBannerDetails($select_title)
{
	global $link;
		
	$arr_box_title = array(); 
	$arr_banner_type = array(); 
	$arr_banner = array();
	$arr_box_desc = array(); 
	$arr_mind_jumble_box_id = array();
	$arr_credit_line = array();
	$arr_credit_line_url = array();
	$arr_day = array();
	$arr_sound_clip_id = array();
	$arr_select_title = array();
	$arr_short_narration = array();
	$day = date('j');
	
	
	   $sql = "SELECT * FROM `tblmindjumble` WHERE select_title = '".$select_title."' AND status = '1' ORDER BY `box_add_date` DESC";
	
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			 $days = ($row['day']);
			 $arr_days = explode(",", $days);
				if (in_array($day,$arr_days)) 
					{	
						array_push($arr_box_title , stripslashes($row['box_title']));
						array_push($arr_banner_type , stripslashes($row['box_type']));
						array_push($arr_banner , stripslashes($row['box_banner']));
						array_push($arr_box_desc , stripslashes($row['box_desc']));
						array_push($arr_mind_jumble_box_id , stripslashes($row['mind_jumble_box_id']));
						array_push($arr_credit_line , stripslashes($row['credit_line']));
						array_push($arr_credit_line_url , stripslashes($row['credit_line_url']));
						array_push($arr_day , stripslashes($row['day']));
						array_push($arr_sound_clip_id , stripslashes($row['sound_clip_id']));
						array_push($arr_select_title , stripslashes($row['select_title']));
						array_push($arr_short_narration , stripslashes($row['short_narration']));
					}
		}	
	}
	return array($arr_box_title,$arr_banner_type,$arr_banner,$arr_box_desc,$arr_mind_jumble_box_id,$arr_credit_line,$arr_credit_line_url,$arr_day,$arr_sound_clip_id,$arr_select_title,$arr_short_narration);
}


function OnChangeGetShortNarrationDetails($short_narration,$select_title)
{
	global $link;
	
	$arr_box_title = array(); 
	$arr_banner_type = array(); 
	$arr_banner = array();
	$arr_box_desc = array(); 
	$arr_mind_jumble_box_id = array();
	$arr_credit_line = array();
	$arr_credit_line_url = array();
	$arr_day = array();
	$arr_sound_clip_id = array();
	$arr_select_title = array();
	$arr_short_narration = array();
	$day = date('j');
	
	if($select_title != '' && $short_narration == '')
	{
		$sql = "SELECT * FROM `tblmindjumble` WHERE select_title = '".$select_title."' AND status = '1' ORDER BY `box_add_date` DESC";
	}
	elseif($select_title != '' && $short_narration != '')
	{		
		$sql = "SELECT * FROM `tblmindjumble` WHERE select_title = '".$select_title."' AND short_narration = '".$short_narration."' AND status = '1' ORDER BY `box_add_date` DESC";
	}
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			 $days = ($row['day']);
			 $arr_days = explode(",", $days);
				if (in_array($day,$arr_days)) 
					{	
						array_push($arr_box_title , stripslashes($row['box_title']));
						array_push($arr_banner_type , stripslashes($row['box_type']));
						array_push($arr_banner , stripslashes($row['box_banner']));
						array_push($arr_box_desc , stripslashes($row['box_desc']));
						array_push($arr_mind_jumble_box_id , stripslashes($row['mind_jumble_box_id']));
						array_push($arr_credit_line , stripslashes($row['credit_line']));
						array_push($arr_credit_line_url , stripslashes($row['credit_line_url']));
						array_push($arr_day , stripslashes($row['day']));
						array_push($arr_sound_clip_id , stripslashes($row['sound_clip_id']));
						array_push($arr_select_title , stripslashes($row['select_title']));
						array_push($arr_short_narration , stripslashes($row['short_narration']));
					}
		}	
	}
	return array($arr_box_title,$arr_banner_type,$arr_banner,$arr_box_desc,$arr_mind_jumble_box_id,$arr_credit_line,$arr_credit_line_url,$arr_day,$arr_sound_clip_id,$arr_select_title,$arr_short_narration);
}


function  OnChangeGetShortNarration($short_narration,$select_title)
{
   
  list($arr_box_title1,$arr_banner_type1,$arr_banner1,$arr_box_desc1,$arr_mind_jumble_box_id1,$arr_credit_line1,$arr_credit_line_url1,$arr_day1,$arr_sound_clip_id1,$arr_select_title1,$arr_short_narration1) = OnChangeGetShortNarrationDetails($short_narration,$select_title);
  
  	if(count($arr_mind_jumble_box_id1)>0)
		{
                                                        	 
$output = '<div class="slider_main" id="slider_main_bg">
           <div id="slider">';	
   for($i=0;$i<count($arr_mind_jumble_box_id1);$i++)
       {     
    $output .= '<div class="slider_inner">';
	
	$output .= '<table align="center" width="290" border="0" cellspacing="0" cellpadding="0" style="padding-left:10px; padding-right:10px;">
                   <tr>
                   	<td height="30" align="left" valign="middle">
                   		<span class="Header_brown">'.$arr_box_title1[$i].'</span>
                    </td>
                  </tr>
				  <tr>
                  	<td align="left" valign="middle">';
	
                if($arr_banner_type1[$i] == 'Flash') { 
    $output .='<script type="text/javascript">AC_FL_RunContent( "codebase","http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0","width","270","src","'.SITE_URL."/uploads/".$arr_banner1[$i].'","quality","high","pluginspage","http://www.macromedia.com/go/getflashplayer","wmode","transparent","movie","'.SITE_URL."/uploads/".$arr_banner1[$i].'" ); //end AC code
  </script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="270" ><param name="movie" value="'. SITE_URL."/uploads/".$arr_banner1[$i].'" /> <param name="wmode" value="transparent" /><param name="quality" value="high" /><embed src="'. SITE_URL."/uploads/".$arr_banner1[$i].'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="270"  wmode="transparent"></embed></object></noscript>';
      			 } elseif($arr_banner_type1[$i] == 'Image') {
    $output .='<img src="'.SITE_URL."/uploads/".$arr_banner1[$i].'" width="270" border="0" />';
     			 } elseif($arr_banner_type1[$i] == 'Video') { 
    $output .= '<iframe width="270" src="'.  getSressBusterBannerString($arr_banner1[$i]).'" frameborder="0" allowfullscreen></iframe>';
                 } elseif($arr_banner_type1[$i] == 'Audio') { 
    $output .= '<embed type="application/x-shockwave-flash" flashvars="audioUrl='. SITE_URL."/uploads/".$arr_banner1[$i].'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="270" height="27" quality="best"></embed>';
                 }  
 	 $output .= '	</td>
                  </tr>
                  <tr>
                 	<td height="25" align="right" valign="top" class="footer"><a href="'.$arr_credit_line_url1[$i].'" target="_blank">'.$arr_credit_line1[$i].'</a></td>
                  </tr>
                  <tr>
	                <td align="left" valign="top">'.$arr_box_desc1[$i].'</td>
                  </tr>
                  <tr>
                   	<td height="50" align="left" valign="middle">';
    $output .='<strong>Select: </strong><input type="radio"';
	
	$output .= 'id="select_banner_1_'.$i.'" name="select_banner1" value="'.$arr_mind_jumble_box_id1[$i].'" onclick="Display_MindJumble_Banner(\'1\')" />
					<br><span class="footer">(Please select / tick mark only one as applicable to you.)</span>
					</td>
              	</tr>';
    
	$output .='<tr>
                 <td height="50" align="left" valign="middle">
				 	<strong>Favourite: </strong><input type="checkbox" name="favourite1[]"';
	$output .=' id="favourite_1_'.$i.'" value="'. $arr_mind_jumble_box_id1[$i] .'" class="chkfav2" />';
  	$output .='<br><span class="footer">(Mark above as your favourite.)</span>
					</td></tr></table>';
	$output .='</div>';
           								} 
	$output .='</div></div>';
	} else {  
		 $output .='<img src="images/mj_main.jpg" width="290" height="384" border="0" />';
            } 								

	return $output;									
   }



function  getOnKeyUpBanner($select_title)
{
   
  list($arr_box_title1,$arr_banner_type1,$arr_banner1,$arr_box_desc1,$arr_mind_jumble_box_id1,$arr_credit_line1,$arr_credit_line_url1,$arr_day1,$arr_sound_clip_id1,$arr_select_title1,$arr_short_narration1) = getOnKeyUpBannerDetails($select_title);
  
    
   
  	if(count($arr_mind_jumble_box_id1)>0)
		{
                                                        	 
$output = '<div class="slider_main" id="slider_main_bg">
           <div id="slider">';	
   for($i=0;$i<count($arr_mind_jumble_box_id1);$i++)
       {     
    $output .= '<div class="slider_inner">';
	
	$output .= '<table align="center" width="290" border="0" cellspacing="0" cellpadding="0" style="padding-left:10px; padding-right:10px;">
                   <tr>
                   	<td height="30" align="left" valign="middle">
                   		<span class="Header_brown">'.$arr_box_title1[$i].'</span>
                    </td>
                  </tr>
				  <tr>
                  	<td align="left" valign="middle">';
	
                if($arr_banner_type1[$i] == 'Flash') { 
    $output .='<script type="text/javascript">AC_FL_RunContent( "codebase","http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0","width","270","src","'.SITE_URL."/uploads/".$arr_banner1[$i].'","quality","high","pluginspage","http://www.macromedia.com/go/getflashplayer","wmode","transparent","movie","'.SITE_URL."/uploads/".$arr_banner1[$i].'" ); //end AC code
  </script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="270" ><param name="movie" value="'. SITE_URL."/uploads/".$arr_banner1[$i].'" /> <param name="wmode" value="transparent" /><param name="quality" value="high" /><embed src="'. SITE_URL."/uploads/".$arr_banner1[$i].'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="270"  wmode="transparent"></embed></object></noscript>';
      			 } elseif($arr_banner_type1[$i] == 'Image') {
    $output .='<img src="'.SITE_URL."/uploads/".$arr_banner1[$i].'" width="270" border="0" />';
     			 } elseif($arr_banner_type1[$i] == 'Video') { 
    $output .= '<iframe width="270" src="'.  getSressBusterBannerString($arr_banner1[$i]).'" frameborder="0" allowfullscreen></iframe>';
                 } elseif($arr_banner_type1[$i] == 'Audio') { 
    $output .= '<embed type="application/x-shockwave-flash" flashvars="audioUrl='. SITE_URL."/uploads/".$arr_banner1[$i].'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="270" height="27" quality="best"></embed>';
                 }  
 	 $output .= '	</td>
                  </tr>
                  <tr>
                 	<td height="25" align="right" valign="top" class="footer"><a href="'.$arr_credit_line_url1[$i].'" target="_blank">'.$arr_credit_line1[$i].'</a></td>
                  </tr>
                  <tr>
	                <td align="left" valign="top">'.$arr_box_desc1[$i].'</td>
                  </tr>
                  <tr>
                   	<td height="35" align="left" valign="middle">';
    $output .='<strong>Select:</strong><input type="radio"';
	
	$output .= 'id="select_banner_1_'.$i.'" name="select_banner1" value="'.$arr_mind_jumble_box_id1[$i].'" onclick="Display_MindJumble_Banner(\'1\')" />
					<br> <span class="footer">(Please select / tick mark only one as applicable to you.)</span>
					</td>
              	</tr>';
    
	$output .='<tr>
                 <td height="35" align="left" valign="middle">
				 	<strong>Favourite:</strong><input type="checkbox" name="favourite1[]"';
	$output .=' id="favourite_1_'.$i.'" value="'. $arr_mind_jumble_box_id1[$i] .'" class="chkfav2" />';
  	$output .='<br><span class="footer">(Mark above as your favourite.)</span>
					</td>
				</tr>
				</table>';
	$output .='</div>';
           								} 
	$output .='</div></div>';
	} else {  
		 $output .='<img src="images/mj-main image.JPG" width="290" height="384" border="0" />';
            } 								
	return $output;									
   }


function getStressBusterBoxPDF($step,$day)
{
	global $link;
	
	$arr_pdf_id = array(); 
	$arr_pdf_step = array(); 
	$arr_pdf = array(); 
	$arr_pdf_title = array(); 
	$arr_credit = array();
	$arr_credit_url = array(); 
	$arr_status = array();
	$arr_days = array();
			
	$sql = "SELECT * FROM `tblstressbusterpdf` WHERE `step` = '".$step."' AND status = '1'  ORDER BY `stress_buster_pdf_add_date` ASC";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
		     $days = ($row['day']);
			 $arr_days = explode(",", $days);
			
				if (in_array($day,$arr_days)) 
					{	
						array_push($arr_pdf_id , $row['stress_buster_pdf_id']);
						array_push($arr_pdf_step , $row['step']);
						array_push($arr_pdf , stripslashes($row['pdf']));
						array_push($arr_pdf_title , stripslashes($row['pdf_title']));
						array_push($arr_credit , stripslashes($row['credit']));
						array_push($arr_credit_url , stripslashes($row['credit_url']));
						array_push($arr_status , stripslashes($row['status']));
					}	
		}
	}
	return array($arr_pdf_id,$arr_pdf_step,$arr_pdf,$arr_pdf_title,$arr_credit,$arr_credit_url,$arr_status);

}

function getMindJumbelPDF($day)
{
	global $link;
	
	$arr_pdf = array(); 
	$arr_pdf_title = array(); 
	$arr_credit = array();
	$arr_credit_url = array(); 
	$arr_status = array();
	$arr_days = array();
			
	$sql = "SELECT * FROM `tblmindjumblepdf` WHERE status = '1'  ORDER BY `mind_jumble_pdf_add_date` ASC";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
		     $days = ($row['day']);
			 $arr_days = explode(",", $days);
			
				if (in_array($day,$arr_days)) 
					{	
						array_push($arr_pdf , stripslashes($row['pdf']));
						array_push($arr_pdf_title , stripslashes($row['pdf_title']));
						array_push($arr_credit , stripslashes($row['credit']));
						array_push($arr_credit_url , stripslashes($row['credit_url']));
						array_push($arr_status , stripslashes($row['status']));
					}	
		}
	}
	return array($arr_pdf,$arr_pdf_title,$arr_credit,$arr_credit_url,$arr_status);

}





function getangerventpdf($step,$day)
{
	global $link;
	$arr_pdf_id = array(); 
	$arr_step = array(); 
	$arr_pdf = array(); 
	$arr_pdf_title = array(); 
	$arr_credit = array();
	$arr_credit_url = array(); 
	$arr_status = array();
	$arr_days = array();
			
	$sql = "SELECT * FROM `tblangerventpdf` WHERE `step` = '".$step."' AND status = '1'  ORDER BY `anger_vent_pdf_add_date` ASC";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
		     $days = ($row['day']);
			 $arr_days = explode(",", $days);
			
				if (in_array($day,$arr_days)) 
					{	
						array_push($arr_pdf_id , stripslashes($row['anger_vent_pdf_id']));
						array_push($arr_step , stripslashes($row['step']));
						array_push($arr_pdf , stripslashes($row['pdf']));
						array_push($arr_pdf_title , stripslashes($row['pdf_title']));
						array_push($arr_credit , stripslashes($row['credit']));
						array_push($arr_credit_url , stripslashes($row['credit_url']));
						array_push($arr_status , stripslashes($row['status']));
					}	
		}
	}
	return array($arr_pdf_id,$arr_step,$arr_pdf,$arr_pdf_title,$arr_credit,$arr_credit_url,$arr_status);

}


function getstressbusterboxdetails($step,$day)
{
	global $link;
	
	$arr_step = array(); 
	$arr_box_title = array(); 
	$arr_banner_type = array(); 
	$arr_banner = array();
	$arr_box_desc = array(); 
	$arr_stress_buster_box_id = array();
	$arr_credit_line = array();
	$arr_credit_line_url = array();
	$arr_day = array();
	$arr_sound_clip_id = array();
			
	$sql = "SELECT * FROM `tblstressbusterbox` WHERE `step` = '".$step."' AND status = '1' ORDER BY `box_add_date` DESC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			 $days = ($row['day']);
			 $arr_days = explode(",", $days);
				if (in_array($day,$arr_days)) 
					{	
						array_push($arr_step , $row['step']);
						array_push($arr_box_title , stripslashes($row['box_title']));
						array_push($arr_banner_type , stripslashes($row['box_type']));
						array_push($arr_banner , stripslashes($row['box_banner']));
						array_push($arr_box_desc , stripslashes($row['box_desc']));
						array_push($arr_stress_buster_box_id , stripslashes($row['stress_buster_box_id']));
						array_push($arr_credit_line , stripslashes($row['credit_line']));
						array_push($arr_credit_line_url , stripslashes($row['credit_line_url']));
						array_push($arr_day , stripslashes($row['day']));
						array_push($arr_sound_clip_id , stripslashes($row['sound_clip_id']));
					}
		}	
	}
	return array($arr_step,$arr_box_title,$arr_banner_type,$arr_banner,$arr_box_desc,$arr_stress_buster_box_id,$arr_credit_line,$arr_credit_line_url,$arr_day,$arr_sound_clip_id);

}

function chkIfUserInCustomizationCriteria($user_id,$sol_id)
{
    global $link;
    $return = false;
    
    list($return1,$name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$practitioner_id,$country_id) = getUserDetails($user_id);
    
    if($return1)
    {
        $sql2 = "SELECT * FROM `tblsolutions` WHERE `sol_id` = '".$sol_id."' AND `sol_status` = '1' AND `sol_deleted` = '0' ";
        //echo '<br>'.$sql2;
        $result2 = mysql_query($sql2,$link);
        if( ($result2) && (mysql_num_rows($result2) > 0) )
        {
            $row2 = mysql_fetch_array($result2);

            $user_gender =  $row2['user_gender'];
            $user_country_id =  $row2['user_country_id'];
            $user_state_id =  $row2['user_state_id'];
            $user_city_id =  $row2['user_city_id'];
            $user_place_id =  $row2['user_place_id'];
            $user_height1 =  $row2['user_height1'];
            $user_height2 =  $row2['user_height2'];
            $user_weight1 =  $row2['user_weight1'];
            $user_weight2 =  $row2['user_weight2'];
            $user_age1 =  $row2['user_age1'];
            $user_age2 =  $row2['user_age2'];
            $user_bmi1 =  $row2['user_bmi1'];
            $user_bmi2 =  $row2['user_bmi2'];
            $user_food_option =  $row2['user_food_option'];
            
            
            if($user_gender == '' || $user_gender == $sex)
            {
                $return = true;
            }
            
            if($return)
            {
                if($user_country_id == '0' || $user_country_id == $country_id)
                {
                    $return = true;
                }
                else
                {
                    $return = false;
                }
            }
            
            if($return)
            {
                if($user_state_id == '')
                {
                    $return = true;
                }
                else
                {
                    $pos = strpos($user_state_id, ',');
                    if ($pos !== false) 
                    {
                        $arr_user_state_id = explode(',',$user_state_id);
                        
                        if(in_array($state_id,$arr_user_state_id))
                        {
                            $return = true;
                        }
                        else
                        {
                            $return = false;
                        }
                    }
                    else
                    {
                        if($user_state_id == $state_id)
                        {
                            $return = true;
                        }
                        else
                        {
                            $return = false;
                        }
                    }
                }
            }
            
            if($return)
            {
                if($user_city_id == '')
                {
                    $return = true;
                }
                else
                {
                    $pos = strpos($user_city_id, ',');
                    if ($pos !== false) 
                    {
                        $arr_user_city_id = explode(',',$user_city_id);
                        
                        if(in_array($city_id,$arr_user_city_id))
                        {
                            $return = true;
                        }
                        else
                        {
                            $return = false;
                        }
                    }
                    else
                    {
                        if($user_city_id == $city_id)
                        {
                            $return = true;
                        }
                        else
                        {
                            $return = false;
                        }
                    }
                }
            }
            
            if($return)
            {
                if($user_place_id == '')
                {
                    $return = true;
                }
                else
                {
                    $pos = strpos($user_place_id, ',');
                    if ($pos !== false) 
                    {
                        $arr_user_place_id = explode(',',$user_place_id);
                        
                        if(in_array($place_id,$arr_user_place_id))
                        {
                            $return = true;
                        }
                        else
                        {
                            $return = false;
                        }
                    }
                    else
                    {
                        if($user_place_id == $place_id)
                        {
                            $return = true;
                        }
                        else
                        {
                            $return = false;
                        }
                    }
                }
            }
            
            if($return)
            {
                if($user_height1 == '0' && $user_height2 == '0')
                {
                    $return = true;
                }
                else
                {
                    $height = getHeightValueInCms($height);
                    $height1 = getHeightValueInCms($user_height1);
                    $height2 = getHeightValueInCms($user_height2);
                    
                    if($height >= $height1 && $height <= $height2)
                    {
                        $return = true;
                    }
                    else
                    {
                        $return = false;
                    }
                }
            }

            if($return)
            {
                if($user_weight1 == '' && $user_weight2 == '')
                {
                    $return = true;
                }
                else
                {
                    if($weight >= $user_weight1 && $weight <= $user_weight2)
                    {
                        $return = true;
                    }
                    else
                    {
                        $return = false;
                    }
                }
            }
            
            if($return)
            {
                if($user_age1 == '' && $user_age2 == '')
                {
                    $return = true;
                }
                else
                {
                    $age = getAgeOfUser($user_id);
                    if($age >= $user_age1 && $age <= $user_age2)
                    {
                        $return = true;
                    }
                    else
                    {
                        $return = false;
                    }
                }
            }
            
            if($return)
            {
                if($user_bmi1 == '' && $user_bmi2 == '')
                {
                    $return = true;
                }
                else
                {
                    $bmi = getBMIOfUser($user_id);
                    if($bmi >= $user_bmi1 && $bmi <= $user_bmi2)
                    {
                        $return = true;
                    }
                    else
                    {
                        $return = false;
                    }
                }
            }
            
            if($return)
            {
                if($user_food_option == '')
                {
                    $return = true;
                }
                else
                {
                    if($food_veg_nonveg == 'V')
                    {
                        if($user_food_option == 'V')
                        {
                            $return = true;
                        }
                        else
                        {
                            $return = false;
                        }
                    }
                    elseif($food_veg_nonveg == 'VE')
                    {
                        if($user_food_option == 'VE')
                        {
                            $return = true;
                        }
                        else
                        {
                            $return = false;
                        }
                    }
                    else
                    {
                        if($beef == '0' && $pork == '0')
                        {
                            if($user_food_option == 'V' || $user_food_option == 'VE' || $user_food_option == 'NV')
                            {
                                $return = true;
                            }
                            else
                            {
                                $return = false;
                            }
                        }
                        elseif($beef == '0' && $pork == '1')
                        {
                            if($user_food_option == 'V' || $user_food_option == 'VE' || $user_food_option == 'NV' || $user_food_option == 'NVP')
                            {
                                $return = true;
                            }
                            else
                            {
                                $return = false;
                            }
                        }
                        elseif($beef == '1' && $pork == '0')
                        {
                            if($user_food_option == 'V' || $user_food_option == 'VE' || $user_food_option == 'NV' || $user_food_option == 'NVB')
                            {
                                $return = true;
                            }
                            else
                            {
                                $return = false;
                            }
                        }
                        else
                        {
                            $return = true;
                        }
                    }
                }
            }

        }    
    }
    
    
    
    return $return;
}

function getMWSBoxDetails($sol_cat_id,$date,$mid,$user_id)
{
    global $link;

    $arr_step = array(); 
    $arr_box_title = array(); 
    $arr_banner_type = array(); 
    $arr_banner = array();
    $arr_box_desc = array(); 
    $arr_stress_buster_box_id = array();
    $arr_credit_line = array();
    $arr_credit_line_url = array();
    $arr_sound_clip_id = array();
    $arr_rss_feed_item_id = array();
    
    $today_day = date('j',strtotime($date));
    $today_date = date('Y-m-d',strtotime($date));
    $today_weekday = date('w',strtotime($date));
    $today_weekday = $today_weekday + 1;
    $today_month_no = date('n',strtotime($date));
    
    $str_sql_situation_id = '';
    if($mid == '45')
    {
        $arr_records = getUsersMDTDetails($user_id,$date);
        //echo'<br><pre>';
        //print_r($arr_records);
        //echo'<br></pre>';
        
        if(count($arr_records)> 0)
        {
            $arr_bes_time = array();
            $arr_bes_duration = array();
            $arr_bms_id = array();
            $arr_bms_type = array();
            $arr_bms_entry_type = array();
            $arr_scale = array();
            
            for($i=0;$i<count($arr_records);$i++)
            {
                foreach ($arr_records[$i] as $key => $value) 
                {
                    $temp_time_arr = explode('_',$key);
                   
                    for($j=0;$j<count($value);$j++)
                    {
                        array_push($arr_bes_time , $temp_time_arr[0]);
                        array_push($arr_bes_duration , $temp_time_arr[1]);
                        
                       // echo '<br> entry type = '.$value[$j]['bms_entry_type'];
                        
                        if($value[$j]['bms_entry_type'] == 'situation')
                        {
                            //$bms_type = 'bms';
                            $bms_type = $value[$j]['bms_type'];
                        }
                        else
                        {
                            $bms_type = $value[$j]['bms_type'];
                        }
                        
                       // echo '<br> type = '.$bms_type;
                        
                        array_push($arr_bms_id , $value[$j]['bms_id']);
                        array_push($arr_bms_type , $bms_type);
                        array_push($arr_bms_entry_type , $value[$j]['bms_entry_type']);
                        array_push($arr_scale , $value[$j]['scale']);
                    }
                }
            } 
            
            //echo'<br><pre>';
            //print_r($arr_bms_id);
            //echo'<br></pre>';
            $str_sql_situation_id .= " AND ( ";
            for($i=0;$i<count($arr_bms_id);$i++)
            {
               
                $str_sql_criteria = " AND ( ";
                $str_sql_criteria .= " (`criteria_id` = '0' ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '3' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '1' AND CAST(`criteria_scale_value1` AS SIGNED) > '".$arr_bes_duration[$i] ."') OR (`criteria_scale_type` = '2' AND CAST(`criteria_scale_value1` AS SIGNED) < '".$arr_bes_duration[$i] ."') OR (`criteria_scale_type` = '3' AND CAST(`criteria_scale_value1` AS SIGNED) >= '".$arr_bes_duration[$i] ."') OR (`criteria_scale_type` = '4' AND CAST(`criteria_scale_value1` AS SIGNED) <= '".$arr_bes_duration[$i] ."') OR (`criteria_scale_type` = '5' AND CAST(`criteria_scale_value1` AS SIGNED) = '".$arr_bes_duration[$i] ."') OR (`criteria_scale_type` = '6' AND CAST(`criteria_scale_value1` AS SIGNED) <= '".$arr_bes_duration[$i] ."' AND CAST(`criteria_scale_value2` AS SIGNED) >= '".$arr_bes_duration[$i] ."' ) ) ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '4' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '1' AND `criteria_scale_value1` > '".$arr_bes_time[$i] ."') OR (`criteria_scale_type` = '2' AND `criteria_scale_value1` < '".$arr_bes_time[$i] ."') OR (`criteria_scale_type` = '3' AND `criteria_scale_value1` >= '".$arr_bes_time[$i] ."') OR (`criteria_scale_type` = '4' AND `criteria_scale_value1` <= '".$arr_bes_time[$i] ."') OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$arr_bes_time[$i] ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$arr_bes_time[$i] ."' AND `criteria_scale_value2` >= '".$arr_bes_time[$i] ."' ) ) ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '7' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$today_weekday ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$today_weekday ."' AND `criteria_scale_value2` >= '".$today_weekday ."' ) ) ) "; 
                $str_sql_criteria .= " ) ";
                $str_sql_situation_id .= " (`sol_situation_id` = '".$arr_bms_id[$i]."' AND `sol_situation_type` = '".$arr_bms_type[$i]."' AND `min_rating` <= '".$arr_scale[$i]."' AND `max_rating` >= '".$arr_scale[$i]."' ".$str_sql_criteria." ) OR"; 
            }
            $str_sql_situation_id = substr($str_sql_situation_id, 0,-2);
            $str_sql_situation_id .= " ) ";
            
            
        } 
        else
        {
            $str_sql_situation_id = " AND ('1' == '2')";
        }
        
    }
    elseif($mid == '26')
    {
        list($scale_arr,$remarks_arr,$selected_sleep_id_arr,$my_target_arr,$adviser_target_arr) = getUsersWAEQuestionDetails($user_id,$date,'');
        
        if(count($selected_sleep_id_arr)> 0)
        {
            $str_sql_situation_id .= " AND ( ";
            for($i=0;$i<count($selected_sleep_id_arr);$i++)
            {
                $str_sql_criteria = " AND ( ";
                $str_sql_criteria .= " (`criteria_id` = '0' ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '7' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$today_weekday ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$today_weekday ."' AND `criteria_scale_value2` >= '".$today_weekday ."' ) ) ) "; 
                $str_sql_criteria .= " ) ";
                $str_sql_situation_id .= " (`sol_situation_id` = '".$selected_sleep_id_arr[$i]."' AND `sol_situation_type` = 'wae' AND `min_rating` <= '".$scale_arr[$i]."' AND `max_rating` >= '".$scale_arr[$i]."' ".$str_sql_criteria." ) OR"; 
            }
            $str_sql_situation_id = substr($str_sql_situation_id, 0,-2);
            $str_sql_situation_id .= " ) ";
        } 
        else
        {
            $str_sql_situation_id = " AND ('1' == '2')";
        }
        
    }
    elseif($mid == '30')
    {
        list($scale_arr,$remarks_arr,$selected_sleep_id_arr,$my_target_arr,$adviser_target_arr) = getUsersGSQuestionDetails($user_id,$date,'');
        
        if(count($selected_sleep_id_arr)> 0)
        {
            $str_sql_situation_id .= " AND ( ";
            for($i=0;$i<count($selected_sleep_id_arr);$i++)
            {
                $str_sql_criteria = " AND ( ";
                $str_sql_criteria .= " (`criteria_id` = '0' ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '7' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$today_weekday ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$today_weekday ."' AND `criteria_scale_value2` >= '".$today_weekday ."' ) ) ) "; 
                $str_sql_criteria .= " ) ";
                $str_sql_situation_id .= " (`sol_situation_id` = '".$selected_sleep_id_arr[$i]."' AND `sol_situation_type` = 'gs' AND `min_rating` <= '".$scale_arr[$i]."' AND `max_rating` >= '".$scale_arr[$i]."' ".$str_sql_criteria." ) OR"; 
            }
            $str_sql_situation_id = substr($str_sql_situation_id, 0,-2);
            $str_sql_situation_id .= " ) ";
        } 
        else
        {
            $str_sql_situation_id = " AND ('1' == '2')";
        }
        
    }
    elseif($mid == '31')
    {
        list($scale_arr,$remarks_arr,$selected_sleep_id_arr,$my_target_arr,$adviser_target_arr) = getUsersSleepQuestionDetails($user_id,$date,'');
        
        if(count($selected_sleep_id_arr)> 0)
        {
            $str_sql_situation_id .= " AND ( ";
            for($i=0;$i<count($selected_sleep_id_arr);$i++)
            {
                $str_sql_criteria = " AND ( ";
                $str_sql_criteria .= " (`criteria_id` = '0' ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '7' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$today_weekday ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$today_weekday ."' AND `criteria_scale_value2` >= '".$today_weekday ."' ) ) ) "; 
                $str_sql_criteria .= " ) ";
                $str_sql_situation_id .= " (`sol_situation_id` = '".$selected_sleep_id_arr[$i]."' AND `sol_situation_type` = 'sleep' AND `min_rating` <= '".$scale_arr[$i]."' AND `max_rating` >= '".$scale_arr[$i]."' ".$str_sql_criteria." ) OR"; 
            }
            $str_sql_situation_id = substr($str_sql_situation_id, 0,-2);
            $str_sql_situation_id .= " ) ";
        } 
        else
        {
            $str_sql_situation_id = " AND ('1' == '2')";
        }
        
    }
    elseif($mid == '32')
    {
        list($scale_arr,$remarks_arr,$selected_sleep_id_arr,$my_target_arr,$adviser_target_arr) = getUsersMCQuestionDetails($user_id,$date,'');
        
        if(count($selected_sleep_id_arr)> 0)
        {
            $str_sql_situation_id .= " AND ( ";
            for($i=0;$i<count($selected_sleep_id_arr);$i++)
            {
                $str_sql_criteria = " AND ( ";
                $str_sql_criteria .= " (`criteria_id` = '0' ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '7' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$today_weekday ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$today_weekday ."' AND `criteria_scale_value2` >= '".$today_weekday ."' ) ) ) "; 
                $str_sql_criteria .= " ) ";
                $str_sql_situation_id .= " (`sol_situation_id` = '".$selected_sleep_id_arr[$i]."' AND `sol_situation_type` = 'mc' AND `min_rating` <= '".$scale_arr[$i]."' AND `max_rating` >= '".$scale_arr[$i]."' ".$str_sql_criteria." ) OR"; 
            }
            $str_sql_situation_id = substr($str_sql_situation_id, 0,-2);
            $str_sql_situation_id .= " ) ";
        } 
        else
        {
            $str_sql_situation_id = " AND ('1' == '2')";
        }
        
    }
    elseif($mid == '33')
    {
        list($scale_arr,$remarks_arr,$selected_sleep_id_arr,$my_target_arr,$adviser_target_arr) = getUsersMRQuestionDetails($user_id,$date,'');
        
        if(count($selected_sleep_id_arr)> 0)
        {
            $str_sql_situation_id .= " AND ( ";
            for($i=0;$i<count($selected_sleep_id_arr);$i++)
            {
                $str_sql_criteria = " AND ( ";
                $str_sql_criteria .= " (`criteria_id` = '0' ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '7' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$today_weekday ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$today_weekday ."' AND `criteria_scale_value2` >= '".$today_weekday ."' ) ) ) "; 
                $str_sql_criteria .= " ) ";
                $str_sql_situation_id .= " (`sol_situation_id` = '".$selected_sleep_id_arr[$i]."' AND `sol_situation_type` = 'mr' AND `min_rating` <= '".$scale_arr[$i]."' AND `max_rating` >= '".$scale_arr[$i]."' ".$str_sql_criteria." ) OR"; 
            }
            $str_sql_situation_id = substr($str_sql_situation_id, 0,-2);
            $str_sql_situation_id .= " ) ";
        } 
        else
        {
            $str_sql_situation_id = " AND ('1' == '2')";
        }
        
    }
    elseif($mid == '34')
    {
        list($scale_arr,$remarks_arr,$selected_sleep_id_arr,$my_target_arr,$adviser_target_arr) = getUsersMLEQuestionDetails($user_id,$date,'');
        
        if(count($selected_sleep_id_arr)> 0)
        {
            $str_sql_situation_id .= " AND ( ";
            for($i=0;$i<count($selected_sleep_id_arr);$i++)
            {
                $str_sql_criteria = " AND ( ";
                $str_sql_criteria .= " (`criteria_id` = '0' ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '7' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$today_weekday ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$today_weekday ."' AND `criteria_scale_value2` >= '".$today_weekday ."' ) ) ) "; 
                $str_sql_criteria .= " ) ";
                $str_sql_situation_id .= " (`sol_situation_id` = '".$selected_sleep_id_arr[$i]."' AND `sol_situation_type` = 'mle' AND `min_rating` <= '".$scale_arr[$i]."' AND `max_rating` >= '".$scale_arr[$i]."' ".$str_sql_criteria." ) OR"; 
            }
            $str_sql_situation_id = substr($str_sql_situation_id, 0,-2);
            $str_sql_situation_id .= " ) ";
        } 
        else
        {
            $str_sql_situation_id = " AND ('1' == '2')";
        }
        
    }
    elseif($mid == '35')
    {
        list($scale_arr,$remarks_arr,$selected_sleep_id_arr,$my_target_arr,$adviser_target_arr) = getUsersADCTQuestionDetails($user_id,$date,'');
        
        if(count($selected_sleep_id_arr)> 0)
        {
            $str_sql_situation_id .= " AND ( ";
            for($i=0;$i<count($selected_sleep_id_arr);$i++)
            {
                $str_sql_criteria = " AND ( ";
                $str_sql_criteria .= " (`criteria_id` = '0' ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '7' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$today_weekday ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$today_weekday ."' AND `criteria_scale_value2` >= '".$today_weekday ."' ) ) ) "; 
                $str_sql_criteria .= " ) ";
                $str_sql_situation_id .= " (`sol_situation_id` = '".$selected_sleep_id_arr[$i]."' AND `sol_situation_type` = 'adct' AND `min_rating` <= '".$scale_arr[$i]."' AND `max_rating` >= '".$scale_arr[$i]."' ".$str_sql_criteria." ) OR"; 
            }
            $str_sql_situation_id = substr($str_sql_situation_id, 0,-2);
            $str_sql_situation_id .= " ) ";
        } 
        else
        {
            $str_sql_situation_id = " AND ('1' == '2')";
        }
        
    }
    elseif($mid == '113')
    {
        $arr_records = getUserBPSDetails($user_id,$date);
        //echo'<br><pre>';
        //print_r($arr_records);
        //echo'<br></pre>';
        
        if(count($arr_records)> 0)
        {
            $arr_bms_id = array();
            $arr_scale = array();
            
            
            for($i=0;$i<count($arr_records);$i++)
            {
                
                $temp_bms_arr = explode(',',$arr_records[$i]['bms_id']);
                $temp_scale_arr = explode(',',$arr_records[$i]['scale']);
                
                for($j=0;$j<count($temp_bms_arr);$j++)
                {
                    if(array_key_exists($j, $temp_scale_arr))
                    {
                        $scale = $temp_scale_arr[$j];
                    }
                    else
                    {
                        $scale = 0;
                    }
                    array_push($arr_bms_id , $temp_bms_arr[$j]);
                    array_push($arr_scale , $scale);
                }
            } 
            
            //echo'<br><pre>';
            //print_r($arr_bms_id);
            //echo'<br></pre>';
            
            //echo'<br><pre>';
            //print_r($arr_scale);
            //echo'<br></pre>';
            
            $str_sql_situation_id .= " AND ( ";
            for($i=0;$i<count($arr_bms_id);$i++)
            {
                $str_sql_criteria = " AND ( ";
                $str_sql_criteria .= " (`criteria_id` = '0' ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '7' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$today_weekday ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$today_weekday ."' AND `criteria_scale_value2` >= '".$today_weekday ."' ) ) ) "; 
                $str_sql_criteria .= " ) ";
                $str_sql_situation_id .= " (`sol_situation_id` = '".$arr_bms_id[$i]."' AND `sol_situation_type` = 'bms' AND `min_rating` <= '".$arr_scale[$i]."' AND `max_rating` >= '".$arr_scale[$i]."' ".$str_sql_criteria." ) OR"; 
            }
            $str_sql_situation_id = substr($str_sql_situation_id, 0,-2);
            $str_sql_situation_id .= " ) ";
            
            
        } 
        else
        {
            $str_sql_situation_id = " AND ('1' == '2')";
        }
        
    }
    elseif($mid == '13')
    {
        list($arr_user_meal_id,$arr_meal_date,$arr_meal_time,$arr_meal_id,$arr_meal_others,$arr_meal_like,$arr_meal_quantity,$arr_meal_measure,$arr_meal_consultant_remark,$arr_meal_type) = getUsersDailyMealsDetails($user_id,$date);
        //echo'<br><pre>';
        //print_r($arr_records);
        //echo'<br></pre>';
        
        if(count($arr_meal_id)> 0)
        {
            $str_sql_situation_id .= " AND ( ";
            for($i=0;$i<count($arr_meal_id);$i++)
            {
                $str_sql_criteria = " AND ( ";
                $str_sql_criteria .= " (`criteria_id` = '0' ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '4' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '1' AND `criteria_scale_value1` > '".$arr_meal_time[$i] ."') OR (`criteria_scale_type` = '2' AND `criteria_scale_value1` < '".$arr_meal_time[$i] ."') OR (`criteria_scale_type` = '3' AND `criteria_scale_value1` >= '".$arr_meal_time[$i] ."') OR (`criteria_scale_type` = '4' AND `criteria_scale_value1` <= '".$arr_meal_time[$i] ."') OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$arr_meal_time[$i] ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$arr_meal_time[$i] ."' AND `criteria_scale_value2` >= '".$arr_meal_time[$i] ."' ) ) ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '5' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '1' AND CAST(`criteria_scale_value1` AS SIGNED) > '".$arr_meal_quantity[$i] ."') OR (`criteria_scale_type` = '2' AND CAST(`criteria_scale_value1` AS SIGNED) < '".$arr_meal_quantity[$i] ."') OR (`criteria_scale_type` = '3' AND CAST(`criteria_scale_value1` AS SIGNED) >= '".$arr_meal_quantity[$i] ."') OR (`criteria_scale_type` = '4' AND CAST(`criteria_scale_value1` AS SIGNED) <= '".$arr_meal_quantity[$i] ."') OR (`criteria_scale_type` = '5' AND CAST(`criteria_scale_value1` AS SIGNED) = '".$arr_meal_quantity[$i] ."') OR (`criteria_scale_type` = '6' AND CAST(`criteria_scale_value1` AS SIGNED) <= '".$arr_meal_quantity[$i] ."' AND CAST(`criteria_scale_value2` AS SIGNED) >= '".$arr_meal_quantity[$i] ."' ) ) ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '7' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$today_weekday ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$today_weekday ."' AND `criteria_scale_value2` >= '".$today_weekday ."' ) ) ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '6' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$arr_meal_like[$i] ."') ) ) "; 
                $str_sql_criteria .= " ) ";
                $str_sql_situation_id .= " (`sol_situation_id` = '".$arr_meal_id[$i]."' AND `sol_situation_type` = 'meal' ".$str_sql_criteria." ) OR"; 
            }
            $str_sql_situation_id = substr($str_sql_situation_id, 0,-2);
            $str_sql_situation_id .= " ) ";
        } 
        else
        {
            $str_sql_situation_id = " AND ('1' == '2')";
        }
        
    }
    elseif($mid == '12')
    {
        list($yesterday_sleep_time,$today_wakeup_time,$mins_arr,$activity_id_arr,$other_activity_arr,$proper_guidance_arr,$precaution_arr,$activity_time_arr) = getUsersDailyActivityDetails($user_id,$date);
        //echo'<br><pre>';
        //print_r($activity_id_arr);
        //echo'<br></pre>';
        
        if(count($activity_id_arr)> 0)
        {
            $str_sql_situation_id .= " AND ( ";
            for($i=0;$i<count($activity_id_arr);$i++)
            {
                $cal_burnt = getConsumedCalOfActivity($user_id,$mins_arr[$i],$activity_id_arr[$i]);
                
                $str_sql_criteria = " AND ( ";
                $str_sql_criteria .= " (`criteria_id` = '0' ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '3' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '1' AND CAST(`criteria_scale_value1` AS SIGNED) > '".$mins_arr[$i] ."') OR (`criteria_scale_type` = '2' AND CAST(`criteria_scale_value1` AS SIGNED) < '".$mins_arr[$i] ."') OR (`criteria_scale_type` = '3' AND CAST(`criteria_scale_value1` AS SIGNED) >= '".$mins_arr[$i] ."') OR (`criteria_scale_type` = '4' AND CAST(`criteria_scale_value1` AS SIGNED) <= '".$mins_arr[$i] ."') OR (`criteria_scale_type` = '5' AND CAST(`criteria_scale_value1` AS SIGNED) = '".$mins_arr[$i] ."') OR (`criteria_scale_type` = '6' AND CAST(`criteria_scale_value1` AS SIGNED) <= '".$mins_arr[$i] ."' AND CAST(`criteria_scale_value2` AS SIGNED) >= '".$mins_arr[$i] ."' ) ) ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '4' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '1' AND `criteria_scale_value1` > '".$activity_time_arr[$i] ."') OR (`criteria_scale_type` = '2' AND `criteria_scale_value1` < '".$activity_time_arr[$i] ."') OR (`criteria_scale_type` = '3' AND `criteria_scale_value1` >= '".$activity_time_arr[$i] ."') OR (`criteria_scale_type` = '4' AND `criteria_scale_value1` <= '".$activity_time_arr[$i] ."') OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$activity_time_arr[$i] ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$activity_time_arr[$i] ."' AND `criteria_scale_value2` >= '".$activity_time_arr[$i] ."' ) ) ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '7' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '5' AND `criteria_scale_value1` = '".$today_weekday ."') OR (`criteria_scale_type` = '6' AND `criteria_scale_value1` <= '".$today_weekday ."' AND `criteria_scale_value2` >= '".$today_weekday ."' ) ) ) OR"; 
                $str_sql_criteria .= " (`criteria_id` = '8' AND ( (`criteria_scale_type` = '' ) OR (`criteria_scale_type` = '1' AND CAST(`criteria_scale_value1` AS SIGNED) > '".$cal_burnt."') OR (`criteria_scale_type` = '2' AND CAST(`criteria_scale_value1` AS SIGNED) < '".$cal_burnt."') OR (`criteria_scale_type` = '3' AND CAST(`criteria_scale_value1` AS SIGNED) >= '".$cal_burnt."') OR (`criteria_scale_type` = '4' AND CAST(`criteria_scale_value1` AS SIGNED) <= '".$cal_burnt ."') OR (`criteria_scale_type` = '5' AND CAST(`criteria_scale_value1` AS SIGNED) = '".$cal_burnt ."') OR (`criteria_scale_type` = '6' AND CAST(`criteria_scale_value1` AS SIGNED) <= '".$cal_burnt ."' AND CAST(`criteria_scale_value2` AS SIGNED) >= '".$cal_burnt."' ) ) ) "; 
                $str_sql_criteria .= " ) ";
                $str_sql_situation_id .= " (`sol_situation_id` = '".$activity_id_arr[$i]."' AND `sol_situation_type` = 'activity' ".$str_sql_criteria." ) OR"; 
            }
            $str_sql_situation_id = substr($str_sql_situation_id, 0,-2);
            $str_sql_situation_id .= " ) ";
        } 
        else
        {
            $str_sql_situation_id = " AND ('1' == '2')";
        }
        
    }
    else
    {
        $str_sql_situation_id = " AND ('1' == '2')";
    }
    
    
    
    
    
    $str_sol_item_id = '';
    
    if($sol_cat_id == '')
    {
        $str_sql_cat = "";
    }
    else
    {
        $str_sql_cat = " AND (`sol_cat_id` = '".$sol_cat_id."') ";
    }
    
    //$str_sql_situation_id = '';
    $arr_temp_sol_item_id = array();
    $sql2 = "SELECT * FROM `tblsolutions` "
            . "WHERE ( (`listing_date_type` = '' ) OR (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR "
            . "(`listing_date_type` = 'days_of_week' AND FIND_IN_SET('".$today_weekday."', days_of_week) ) OR "
            . "(`listing_date_type` = 'month_wise' AND FIND_IN_SET('".$today_month_no."', months) ) OR "
            . "(`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR "
            . "(`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) "
            . " ".$str_sql_cat." AND (`sol_status` = '1') AND (`sol_deleted` = '0') ".$str_sql_situation_id." ORDER BY `sol_add_date` DESC";
    //echo '<br>'.$sql2;
    $result2 = mysql_query($sql2,$link);
    if( ($result2) && (mysql_num_rows($result2) > 0) )
    {
        while($row2 = mysql_fetch_array($result2))
        {
            $sol_id =  $row2['sol_id'];
            if(chkIfUserInCustomizationCriteria($user_id,$sol_id))
            {
                if(!in_array($row2['sol_item_id'],$arr_temp_sol_item_id))
                {
                    array_push($arr_temp_sol_item_id , $row2['sol_item_id']);
                }    
            }
        }
        
    }    
    
    if(count($arr_temp_sol_item_id) > 0)
    {
        $str_sol_item_id = implode(',', $arr_temp_sol_item_id);
        /*
        $sql2 = "SELECT DISTINCT sol_item_id FROM `tblsolutions` "
                . "WHERE ( (`listing_date_type` = '' ) OR (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR "
                . "(`listing_date_type` = 'days_of_week' AND FIND_IN_SET('".$today_weekday."', days_of_week) ) OR "
                . "(`listing_date_type` = 'month_wise' AND FIND_IN_SET('".$today_month_no."', months) ) OR "
                . "(`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR "
                . "(`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) "
                . " ".$str_sql_cat." AND (`sol_status` = '1') AND (`sol_deleted` = '0') ".$str_sql_situation_id." ORDER BY `sol_add_date` DESC";
        //echo '<br>'.$sql2;
        $result2 = mysql_query($sql2,$link);
        if( ($result2) && (mysql_num_rows($result2) > 0) )
        {
            while($row2 = mysql_fetch_array($result2))
            {
                $str_sol_item_id .=  $row2['sol_item_id'].',';
            }
            $str_sol_item_id = substr($str_sol_item_id,0,-1);
        }  
         * 
         */  

        $sql = "SELECT * FROM `tblsolutionitems` WHERE `sol_item_id` IN (".$str_sol_item_id.") AND `sol_item_status` = '1' AND `sol_item_deleted` = '0' ORDER BY `sol_item_add_date` DESC";
        //echo '<br>'.$sql;
        $result = mysql_query($sql,$link);
        if( ($result) && (mysql_num_rows($result) > 0) )
        {
            while($row = mysql_fetch_array($result))
            {
                array_push($arr_step , $sol_cat_id);
                array_push($arr_box_title , stripslashes($row['sol_box_title']));
                array_push($arr_banner_type , stripslashes($row['sol_box_type']));
                array_push($arr_banner , stripslashes($row['sol_box_banner']));
                array_push($arr_box_desc , stripslashes($row['sol_box_desc']));
                array_push($arr_stress_buster_box_id , stripslashes($row['sol_item_id']));
                array_push($arr_credit_line , stripslashes($row['sol_credit_line']));
                array_push($arr_credit_line_url , stripslashes($row['sol_credit_line_url']));
                array_push($arr_sound_clip_id , stripslashes($row['sound_clip_id']));
                array_push($arr_rss_feed_item_id , stripslashes($row['rss_feed_item_id']));
            }	
        }
    }
    return array($arr_step,$arr_box_title,$arr_banner_type,$arr_banner,$arr_box_desc,$arr_stress_buster_box_id,$arr_credit_line,$arr_credit_line_url,$arr_sound_clip_id,$arr_rss_feed_item_id);

}

function getMWSBoxCode($sol_cat_id,$date,$user_select1,$fav1,$chk_pdf1,$user_adv1,$mid,$user_id)
{
    global $link;
    $output = '';

    list($arr_step1,$arr_box_title1,$arr_banner_type1,$arr_banner1,$arr_box_desc1,$arr_stress_buster_box_id1,$arr_credit_line1,$arr_credit_line_url1,$arr_sound_clip_id1,$arr_rss_feed_item_id1) = getMWSBoxDetails($sol_cat_id,$date,$mid,$user_id);
    
    if($user_select1 == '')
    {
        $display_banner1 = 'none';
    }
    else
    {
        $display_banner1 = '';
    }
    
    //echo '<br><pre>';
    //print_r($arr_stress_buster_box_id1);
    //echo '<br></pre>';
    
    //echo '<br><pre>';
    //print_r($fav1);
    //echo '<br></pre>';
    
    //echo '<br><pre>';
    //print_r($chk_pdf1);
    //echo '<br></pre>';
    $output .= '<table align="center" width="540" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="2" align="center" valign="top">
                            <div class="slider_main" id="slider_main_bg">';
    if(count($arr_step1)>0)
    { 
    $output .= '                <div id="slider">';
        for($i=0;$i<count($arr_step1);$i++)
        {     
    $output .= '                    <div class="slider_inner">
                                        <table align="center" width="290" border="0" cellspacing="0" cellpadding="0" style="padding-left:10px; padding-right:10px;">
                                            <tr>
                                                <td height="30" align="left" valign="middle"><span class="Header_brown"><a href="'.$arr_credit_line_url1[$i].'" target="_blank">'.$arr_box_title1[$i].'</a></span></td>
                                            </tr>';
                                            if($arr_banner_type1[$i] == 'text') 
                                            {   
                                            }
                                            else
                                            {
                                            
    $output .= '                            <tr>
                                                <td align="left" valign="middle">';
                                                if($arr_banner_type1[$i] == 'Flash') { 
    $output .= '                                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="270" ><param name="movie" value="'.SITE_URL."/uploads/".$arr_banner1[$i].'" /> <param name="wmode" value="transparent" /><param name="quality" value="high" /><embed src="'.SITE_URL."/uploads/".$arr_banner1[$i].'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="270"  wmode="transparent"></embed></object>';
                                                } elseif($arr_banner_type1[$i] == 'Image') { 
    $output .= '                                    <a href="'.$arr_credit_line_url1[$i].'" target="_blank"><img src="'.SITE_URL."/uploads/".$arr_banner1[$i].'" width="270" height="270" border="0" /></a>';
                                                } elseif($arr_banner_type1[$i] == 'Video') { 
    $output .= '                                    <iframe width="270" src="'.getSressBusterBannerString($arr_banner1[$i]).'" frameborder="0" allowfullscreen></iframe>';
                                                } elseif($arr_banner_type1[$i] == 'Audio') { 
    $output .= '                                    <embed type="application/x-shockwave-flash" flashvars="audioUrl='.SITE_URL."/uploads/".$arr_banner1[$i].'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="270" height="270" quality="best"  wmode="transparent"></embed>';
                                                } elseif($arr_banner_type1[$i] == 'Pdf') { 
    $output .= '                                    <a href="'.SITE_URL."/uploads/".$arr_banner1[$i].'" target="_blank">'.$arr_box_title1[$i].'</a>';   
                                                } elseif($arr_banner_type1[$i] == 'rss') { 
                                                    list($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json) = getRssFeedItemDetails($arr_rss_feed_item_id1[$i]);
    $output .= '                                    <a href="'.$rss_feed_item_link.'" target="_blank">'.$rss_feed_item_title.'</a>';   
                                                }       
    $output .= '                                </td>
                                            </tr>';
                                            }    
    $output .= '                            <tr>
                                                <td class="footer" height="25" align="right" valign="top"><a href="'.$arr_credit_line_url1[$i].'" target="_blank">'.$arr_credit_line1[$i].'</a></td>
                                            </tr>';
    $output .= '                            <tr>
                                                <td align="left" valign="top"><a href="'.$arr_credit_line_url1[$i].'" target="_blank">'.$arr_box_desc1[$i].'</a></td>
                                            </tr>';
    /*
    $output .= '                            <tr>
                                                <td height="50" align="left" valign="middle"><strong>Select:</strong>';
                                                //echo '<br>user_select = '.$user_select1.' , box_id = '.$arr_stress_buster_box_id1[$i];            
                                                if($user_select1 == $arr_stress_buster_box_id1[$i])
                                                {
                                                    $chked = ' checked="checked" ';
                                                }
                                                else
                                                {
                                                    $chked = '';
                                                }
    $output .= '                                    <input type="radio" '.$chked.' id="select_banner_1_'.$i.'" name="select_banner1" value="'.$arr_stress_buster_box_id1[$i].'" onclick="Playsound(\''.$arr_sound_clip_id1[$i].'\'); Display_BannerMWS(\'1\')" />
                                                    <br><span class="footer">(Please select / tick mark only one as applicable to you.)</span>
                                                </td>
                                            </tr>';
     * 
     */
    $output .= '                            <tr>
                                                <td height="50" align="left" valign="middle"><strong>Favourite:</strong>';
                                                if(in_array($arr_stress_buster_box_id1[$i] , $fav1))
                                                {
                                                    $chked1 = ' checked="checked" ';
                                                }
                                                else
                                                {
                                                    $chked1 = '';
                                                }        
    $output .= '                                    <input type="checkbox" name="favourite1[]" '.$chked1.' id="favourite_1_'.$i.'" value="'.$arr_stress_buster_box_id1[$i].'" onclick="PlaysoundNew(\''.$arr_sound_clip_id1[$i].'\',\'favourite_1_'.$i.'\');" />
                                                    <br><span class="footer">(Mark above as your favourite.)</span>
                                                </td>
                                            </tr>';
                                                                                    
            if($arr_banner_type1[$i] == 'Pdf')
            { 
    $output .= '                            <tr>
                                                <td height="50" align="left" valign="middle"><strong>Add to Library:</strong>';
                                                //echo '<br>pdf = '.print_r($chk_pdf1).' , box_id = '.$arr_stress_buster_box_id1[$i];            
                                                if (in_array($arr_stress_buster_box_id1[$i] , $chk_pdf1)) 
                                                {
                                                    $chked2 = ' checked="checked" ';
                                                }
                                                else
                                                {
                                                    $chked2 = '';
                                                }
    $output .= '                                    <input type="checkbox" name="chk_pdf1[]" '.$chked2.' id="chk_pdf_1_'.$i.'" value="'.$arr_stress_buster_box_id1[$i].'" />
                                                    <br><span class="footer">(Mark above add to your library.)</span>
                                                </td>
                                            </tr>';
    
    
            }
                                            if($user_adv1[$i] == '1') 
                                            { 
                                                $chk_rate1 = ' checked="checked" '; 
                                                $chk_rate2 = ''; 
                                                $chk_rate3 = ''; 
                                                $chk_rate4 = ''; 
                                                $chk_rate5 = ''; 
                                            }
                                            elseif($user_adv1[$i] == '2') 
                                            { 
                                                $chk_rate1 = ''; 
                                                $chk_rate2 = ' checked="checked" '; 
                                                $chk_rate3 = ''; 
                                                $chk_rate4 = ''; 
                                                $chk_rate5 = ''; 
                                            }
                                            elseif($user_adv1[$i] == '3') 
                                            { 
                                                $chk_rate1 = ''; 
                                                $chk_rate2 = ''; 
                                                $chk_rate3 = ' checked="checked" '; 
                                                $chk_rate4 = ''; 
                                                $chk_rate5 = ''; 
                                            }
                                            elseif($user_adv1[$i] == '4') 
                                            { 
                                                $chk_rate1 = ''; 
                                                $chk_rate2 = ''; 
                                                $chk_rate3 = ''; 
                                                $chk_rate4 = ' checked="checked" '; 
                                                $chk_rate5 = ''; 
                                            }
                                            elseif($user_adv1[$i] == '5') 
                                            { 
                                                $chk_rate1 = ''; 
                                                $chk_rate2 = ''; 
                                                $chk_rate3 = ''; 
                                                $chk_rate4 = ''; 
                                                $chk_rate5 = ' checked="checked" '; 
                                            }
                                            else
                                            { 
                                                $chk_rate1 = ''; 
                                                $chk_rate2 = ''; 
                                                $chk_rate3 = ''; 
                                                $chk_rate4 = ''; 
                                                $chk_rate5 = ''; 
                                            }
    $output .= '                            <tr>
                                                <td height="35" colspan="2" align="left" valign="top"><span style="float:left;">
                                                    <strong>Rate it:</strong></span>
                                                    <span>
                                                        <input name="adv1_'.$i.'" '.$chk_rate1.'  type="radio" class="star" value="1" onclick="HideRateIt();"/>
                                                        <input name="adv1_'.$i.'" '.$chk_rate2.' type="radio" class="star" value="2" onclick="HideRateIt();"/>
                                                        <input name="adv1_'.$i.'" '.$chk_rate3.' type="radio" class="star" value="3" onclick="HideRateIt();"/>
                                                        <input name="adv1_'.$i.'" '.$chk_rate4.' type="radio" class="star" value="4" onclick="HideRateIt();"/>
                                                        <input name="adv1_'.$i.'" '.$chk_rate5.' type="radio" class="star" value="5" onclick="HideRateIt();"/>
                                                    </span>
                                                </td>
                                            </tr>';
            
    $output .= '                        </table>
                                    </div>';
        } 
    $output .= '                </div> <!-- end Slider #1 -->';
    } 
    else 
    { 
    $output .= '                <span>Thank you for being on this page,<br /> Currently No matching Data available.  </span>';
    } 
    $output .= '            </div>
                        </td>
                    </tr>';
    
    
    
    
    $output .= '    <tr>
                        <td height="20" colspan="2" align="left" valign="top">&nbsp;</td>
                    </tr>';
    if(count($arr_step1)>0)
    { 
    $output .= '    <tr>
                        <td colspan="2" align="center" valign="top">
                            <input name="btnSubmit1" type="submit" class="button" id="btnSubmit1" value="Save" />&nbsp;
                        </td>
                    </tr>';
    }
    /*
    $output .= '                <tr>
                        <td colspan="2" align="center" valign="top">
                            <div id="disply_banner1" class="slider_main2" style="display:'.$display_banner1.'">'.get_BoxSelectedItemCodeMWS($user_select1).'</div>
                        </td>
                    </tr>
                    <tr>
                        <td height="35" colspan="2" align="left" valign="top">&nbsp;</td>
                    </tr>';
     * 
     */
    $output .= '</table>';
    
    return $output;

}

function getSolutionCategoryName($fav_cat_id)
{
	global $link;
	
	$fav_cat = ''; 
			
	//$sql = "SELECT * FROM `tblsolutioncategories` WHERE `sol_cat_id` = '".$sol_cat_id."' ";
        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while($row = mysql_fetch_array($result))
            {
                $fav_cat = stripslashes($row['fav_cat']);
            }	
	}
	return $fav_cat;

}

function getAngerVentBoxDetails($step,$day)
{
	global $link;
	
	$arr_step = array(); 
	$arr_box_title = array(); 
	$arr_banner_type = array(); 
	$arr_banner = array();
	$arr_box_desc = array(); 
	$arr_anger_vent_box_id = array();
	$arr_credit_line = array();
	$arr_credit_line_url = array();
	$arr_day = array();
	$arr_sound_clip_id = array();
			
	$sql = "SELECT * FROM `tblangervent` WHERE `step` = '".$step."' AND status = '1' ORDER BY `anger_vent_box_id` DESC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			 $days = ($row['day']);
			 $arr_days = explode(",", $days);
				if (in_array($day,$arr_days)) 
					{	
						array_push($arr_step , $row['step']);
						array_push($arr_box_title , stripslashes($row['box_title']));
						array_push($arr_banner_type , stripslashes($row['box_type']));
						array_push($arr_banner , stripslashes($row['box_banner']));
						array_push($arr_box_desc , stripslashes($row['box_desc']));
						array_push($arr_anger_vent_box_id , stripslashes($row['anger_vent_box_id']));
						array_push($arr_credit_line , stripslashes($row['credit_line']));
						array_push($arr_credit_line_url , stripslashes($row['credit_line_url']));
						array_push($arr_day , stripslashes($row['day']));
						array_push($arr_sound_clip_id , stripslashes($row['sound_clip_id']));
					}
		}	
	}
	return array($arr_step,$arr_box_title,$arr_banner_type,$arr_banner,$arr_box_desc,$arr_anger_vent_box_id,$arr_credit_line,$arr_credit_line_url,$arr_day,$arr_sound_clip_id);

}

function getMindJumbleBoxDetails($day)
{
	global $link;
	
	$arr_box_title = array(); 
	$arr_banner_type = array(); 
	$arr_banner = array();
	$arr_box_desc = array(); 
	$arr_mind_jumble_box_id = array();
	$arr_credit_line = array();
	$arr_credit_line_url = array();
	$arr_day = array();
	$arr_sound_clip_id = array();
	$arr_select_title = array();
	$arr_short_narration = array();
			
	$sql = "SELECT * FROM `tblmindjumble` WHERE  status = '1' ORDER BY `box_add_date` DESC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			 $days = ($row['day']);
			 $arr_days = explode(",", $days);
				if (in_array($day,$arr_days)) 
					{	
						array_push($arr_box_title , stripslashes($row['box_title']));
						array_push($arr_banner_type , stripslashes($row['box_type']));
						array_push($arr_banner , stripslashes($row['box_banner']));
						array_push($arr_box_desc , stripslashes($row['box_desc']));
						array_push($arr_mind_jumble_box_id , stripslashes($row['mind_jumble_box_id']));
						array_push($arr_credit_line , stripslashes($row['credit_line']));
						array_push($arr_credit_line_url , stripslashes($row['credit_line_url']));
						array_push($arr_day , stripslashes($row['day']));
						array_push($arr_sound_clip_id , stripslashes($row['sound_clip_id']));
						array_push($arr_select_title , stripslashes($row['select_title']));
						array_push($arr_short_narration , stripslashes($row['short_narration']));
					}
		}	
	}
	return array($arr_box_title,$arr_banner_type,$arr_banner,$arr_box_desc,$arr_mind_jumble_box_id,$arr_credit_line,$arr_credit_line_url,$arr_day,$arr_sound_clip_id,$arr_select_title,$arr_short_narration);

}


function PostComment($comment_box,$user_id,$parent_comment_id,$comment_type,$select_title,$short_narration)
{
	global $link;
	$return = false;
	
	$sql = "INSERT INTO `tblcomments` (`comment`,`user_id`,`parent_comment_id`,`comment_type`,`select_title`,`short_narration`,`status`) VALUES ('".addslashes($comment_box)."','".addslashes($user_id)."','".addslashes($parent_comment_id)."','".addslashes($comment_type)."','".addslashes($select_title)."','".addslashes($short_narration)."','1')";
	
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}


function InsertFeedback($parent_id,$page_id,$name,$email,$feedback,$user_id)
{
	global $link;
	$return = false;
	
	$sql = "INSERT INTO `tblfeedback` (`parent_feedback_id`,`page_id`,`user_id`,`name`,`email`,`feedback`,`admin`,`status`) VALUES ('".addslashes($parent_id)."','".addslashes($page_id)."','".addslashes($user_id)."','".addslashes($name)."','".addslashes($email)."','".addslashes($feedback)."','0','1')";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}



function InsertStressBusterStep($step,$user_title,$user_banner_type,$user_banner,$day,$user_id)
{
	global $link;
	$return = false;
	
	$sql = "INSERT INTO `tblstressbusterbox`(`step`,`box_title`,`box_type`,`box_banner`,`status`,`user_add_banner`,day,`user_id`) VALUES ('".addslashes($step)."','".addslashes($user_title)."','".addslashes($user_banner_type)."','".addslashes($user_banner)."','0','1','".addslashes($day)."','".addslashes($user_id)."')";
	
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}

function InsertMWSItem($user_title,$user_banner_type,$user_banner,$user_id)
{
	global $link;
	$return = false;
	
	$sql = "INSERT INTO `tblsolutionitems`(`sol_box_title`,`sol_box_type`,`sol_box_banner`,`sol_item_status`,`user_add_banner`,`user_id`) "
                . "VALUES ('".addslashes($user_title)."','".addslashes($user_banner_type)."','".addslashes($user_banner)."','0','1','".addslashes($user_id)."')";
	
	$result = mysql_query($sql,$link);
	if($result)
	{
            $return = true;
	}
	return $return;
}

function InsertAngerVentStep($step,$user_title,$user_banner_type,$user_banner,$day,$user_id)
{
	global $link;
	$return = false;
	
	$sql = "INSERT INTO `tblangervent`(`step`,`box_title`,`box_type`,`box_banner`,`status`,`user_add_banner`,`day`,`user_id`) VALUES ('".addslashes($step)."','".addslashes($user_title)."','".addslashes($user_banner_type)."','".addslashes($user_banner)."','0','1','".addslashes($day)."','".addslashes($user_id)."')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}

function InsertMindjumbelPDF($user_title1,$user_banner_type1,$user_banner1,$day,$user_id,$select_title,$short_narration)
{
	global $link;
	$return = false;
	$sql = "INSERT INTO `tblmindjumblepdf`(`pdf`,`pdf_title`,`day`,`title_id`,`short_narration`,`status`,`user_uploads`,`user_id`) VALUES ('".addslashes($user_banner1)."','".addslashes($user_title1)."','".addslashes($day)."','".addslashes($select_title)."','".addslashes($short_narration)."','0','1','".addslashes($user_id)."')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}



function InsertStressBusterPDF($step,$user_title1,$user_banner_type1,$user_banner1,$day,$user_id)
{
	global $link;
	$return = false;
	
	$sql = "INSERT INTO `tblstressbusterpdf`(`step`,`pdf`,`pdf_title`,`day`,`status`,`user_uploads`,`user_id`) VALUES ('".addslashes($step)."','".addslashes($user_banner1)."','".addslashes($user_title1)."','".addslashes($day)."','0','1','".addslashes($user_id)."')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}

function InsertAngerVentPDF($step,$user_title1,$user_banner_type1,$user_banner1,$day,$user_id)
{
	global $link;
	$return = false;
	
	$sql = "INSERT INTO `tblangerventpdf`(`step`,`pdf`,`pdf_title`,`day`,`status`,`user_uploads`,`user_id`) VALUES ('".addslashes($step)."','".addslashes($user_banner1)."','".addslashes($user_title1)."','".addslashes($day)."','0','1','".addslashes($user_id)."')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}

function InsertMindjumbel($user_title,$user_banner_type,$user_banner,$day,$user_id)
{
	global $link;
	$return = false;
	
	$sql = "INSERT INTO `tblmindjumble`(`box_title`,`box_type`,`box_banner`,`status`,`user_add_banner`,`day`,`user_id`) VALUES ('".addslashes($user_title)."','".addslashes($user_banner_type)."','".addslashes($user_banner)."','0','1','".addslashes($day)."','".addslashes($user_id)."')";
	
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}

function InsertAngerVentAllDetails($user_stressed1,$user_select1,$user_adv1,$fav1,$user_select2,$user_adv2,$fav2,$user_select3,$user_adv3,$fav3,$user_id)
{
	global $link;
	$return = 0;
	
	$sql = "INSERT  INTO `tbluseravb`(`user_id`,`user_stressed`,`stress_buster_box_id_1`,`fav1`,`rate1`,`stress_buster_box_id_2`,`fav2`,`rate2`,`stress_buster_box_id_3`,`fav3`,`rate3`) VALUES ('".$user_id."','".addslashes($user_stressed1)."','".addslashes($user_select1)."','".addslashes($fav1)."','".addslashes($user_adv1)."','".addslashes($user_select2)."','".addslashes($fav2)."','".addslashes($user_adv2)."','".addslashes($user_select3)."','".addslashes($fav3)."','".addslashes($user_adv3)."')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = mysql_insert_id($link);
	}
	return $return;
}

function addAngerIntensityMeter($intensity_scale_1,$intensity_scale_2,$user_id,$uavb_id)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tbluseravb` SET `intensity_scale_1` = '".$intensity_scale_1."' , `intensity_scale_2` = '".$intensity_scale_2."' WHERE `user_id` = '".$user_id."' AND `uavb_id` = '".$uavb_id."'";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}

function addStressIntensityMeter($intensity_scale_1,$intensity_scale_2,$user_id,$usbb_id)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tbluserssbb` SET `intensity_scale_1` = '".$intensity_scale_1."' , `intensity_scale_2` = '".$intensity_scale_2."' WHERE `user_id` = '".$user_id."' AND `usbb_id` = '".$usbb_id."'";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}

function InsertMindJumbelAllDetails($select_title,$short_narration,$user_stressed,$user_select1,$user_adv1,$fav1_comma_separated,$user_id,$comment_box)
{
	global $link;
	$return = false;
	
	$sql = "INSERT  INTO `tblusermjb`(`select_title`,`short_narration`,`user_stressed`,`user_id`,`stress_buster_box_id_1`,`fav1`,`rate1`,`comment_box`) VALUES ('".addslashes($select_title)."','".addslashes($short_narration)."','".addslashes($user_stressed)."','".$user_id."','".addslashes($user_select1)."','".addslashes($fav1_comma_separated)."','".addslashes($user_adv1)."','".addslashes($comment_box)."')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;
	}
	return $return;
}


function InsertStressBusterAllDetails($user_stressed1,$user_select1,$user_adv1,$fav1,$user_select2,$user_adv2,$fav2,$user_select3,$user_adv3,$fav3,$comment_box,$user_id)
{
	global $link;
	$return = 0;
	
	$sql = "INSERT  INTO `tbluserssbb`(`user_id`,`user_stressed`,`stress_buster_box_id_1`,`fav1`,`rate1`,`stress_buster_box_id_2`,`fav2`,`rate2`,`stress_buster_box_id_3`,`fav3`,`rate3`,`comment_box`) VALUES ('".$user_id."','".addslashes($user_stressed1)."','".addslashes($user_select1)."','".addslashes($fav1)."','".addslashes($user_adv1)."','".addslashes($user_select2)."','".addslashes($fav2)."','".addslashes($user_adv2)."','".addslashes($user_select3)."','".addslashes($fav3)."','".addslashes($user_adv3)."','".addslashes($comment_box)."')";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = mysql_insert_id($link);
	}
	return $return;
}

function addMWSAllDetails($user_id,$sol_item_id,$fav,$rate,$mws_date)
{
	global $link;
	$return = false;
	
        for($i=0;$i<count($sol_item_id);$i++)
        {
            if($sol_item_id[$i] != '')
            {
                $sql = "INSERT  INTO `tblusersmws`(`user_id`,`sol_item_id`,`fav`,`rate`,`mws_date`) "
                    . "VALUES ('".$user_id."','".addslashes($sol_item_id[$i])."','".addslashes($fav[$i])."','".addslashes($rate[$i])."','".addslashes($mws_date)."')";
                //echo $sql;
                $result = mysql_query($sql,$link);
                if($result)
                {
                    //$return = mysql_insert_id($link);
                    $return = true;
                }
            }
        }
	
	return $return;
}

function getPDF($stress_buster_pdf_id)
{
	global $link;
	
	$pdf = '';
		
	$sql = "SELECT * FROM `tblstressbusterpdf` WHERE stress_buster_pdf_id = '".$stress_buster_pdf_id."' ";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$pdf = stripslashes($row['pdf']);

	}	
	return $pdf;
}	

function GetSoundClip($sound_clip_id)
{
	global $link;
	
	$sound_clip = '';
	$sql = "SELECT * FROM `tblsoundclip` WHERE `sound_clip_id` = '".$sound_clip_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$sound_clip = stripslashes($row['sound_clip']);

	}	
	return $sound_clip;
}	

function GetAngerVentSoundClip($sound_clip_id)
{
	global $link;
	$sound_clip = '';
	
	$sql = "SELECT * FROM `tblsoundclip` WHERE `sound_clip_id` = '".$sound_clip_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$sound_clip = stripslashes($row['sound_clip']);

	}	
	return $sound_clip;
}	

function GetMindJumbleSoundClip($sound_clip_id)
{
	global $link;
	$sound_clip = '';
	
	$sql = "SELECT * FROM `tblsoundclip` WHERE `sound_clip_id` = '".$sound_clip_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$sound_clip = stripslashes($row['sound_clip']);

	}	
	return $sound_clip;
}	


function getMusic($step,$day)
{
	global $link;
	$music = '';
		
	$sql = "SELECT * FROM `tblmusic` WHERE step = '".$step."' AND day = '".$day."' AND status = '1' ";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$music = stripslashes($row['music']);

	}	
	return $music;
}	

function getStressBusterBoxBKMusic($step,$day)
{
	global $link;
	$music = ''; 
	$music_id = ''; 
	
	$sql = "SELECT * FROM `tblmusic` WHERE step = '".$step."' AND status = '1' ORDER BY `music_add_date` DESC";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
		     $days = ($row['day']);
			 $arr_days = explode(",", $days);
			
				if (in_array($day,$arr_days)) 
					{	
						$music = stripslashes($row['music']);
						$music_id = stripslashes($row['music_id']);
						$credit = stripslashes($row['credit']);
						$credit_url = stripslashes($row['credit_url']);
						break;
					}	
		}
	}
	return array($music,$music_id,$credit,$credit_url);

}

function getMWSBoxBGMusic($step,$day)
{
	global $link;
	$music = ''; 
	$music_id = ''; 
	
	//$sql = "SELECT * FROM `tblmusic` WHERE step = '".$step."' AND status = '1' ORDER BY `music_add_date` DESC";
	$sql = "SELECT * FROM `tblsolutionbgmusic` WHERE `deleted` = '0' AND `status` = '1' ORDER BY `music_add_date` DESC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while($row = mysql_fetch_array($result))
            {
                $days = ($row['day']);
                $arr_days = explode(",", $days);

                if (in_array($day,$arr_days)) 
                {	
                    $music = stripslashes($row['music']);
                    $music_id = stripslashes($row['music_id']);
                    $credit = stripslashes($row['credit']);
                    $credit_url = stripslashes($row['credit_url']);
                    break;
                }	
            }
	}
	return array($music,$music_id,$credit,$credit_url);

}

function getAngerVentBKMusic($step,$day)
{
	global $link;
	$music = ''; 
	$music_id = ''; 
	$credit = '';
	$credit_url = '';
	
	$sql = "SELECT * FROM `tblangerventmusic` WHERE step = '".$step."' AND status = '1' ORDER BY `music_add_date` DESC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
		     $days = ($row['day']);
			 $arr_days = explode(",", $days);
			
				if (in_array($day,$arr_days)) 
					{	
						$music = stripslashes($row['music']);
						$music_id = stripslashes($row['music_id']);
						$credit = stripslashes($row['credit']);
						$credit_url = stripslashes($row['credit_url']);
						break;
					}	
		}
	}
	return array($music,$music_id,$credit,$credit_url);

}

function getMindJumbelBKMusic($day)
{
	global $link;
	$music = ''; 
	$music_id = ''; 
	$credit = '';
	$credit_url = '';
	
	$sql = "SELECT * FROM `tblmindjumblemusic` WHERE status = '1' ORDER BY `music_add_date` DESC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
		     $days = ($row['day']);
			 $arr_days = explode(",", $days);
			
				if (in_array($day,$arr_days)) 
					{	
						$music = stripslashes($row['music']);
						$music_id = stripslashes($row['music_id']);
						$credit = stripslashes($row['credit']);
						$credit_url = stripslashes($row['credit_url']);
						break;
					}	
		}
	}
	return array($music,$music_id,$credit,$credit_url);

}


function getTheamDetails($theam_id)
{
	global $link;
	$color_code = '#339900'; 
	$image = 'images/stressbuster_back.jpg';
		
	$sql = "SELECT * FROM `tbltheams` WHERE theam_id = '".$theam_id."' ORDER BY `theam_name` ASC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$image = SITE_URL."/uploads/".stripslashes($row['image']);
		$color_code = "#".stripslashes($row['color_code']);

	}	
	return array($image,$color_code);
}

function getTheamDetailsMDT($theam_id)
{
    global $link;
    $color_code = '#339900'; 
    $image = '';

    $sql = "SELECT * FROM `tbltheams` WHERE theam_id = '".$theam_id."' ORDER BY `theam_name` ASC";
    //echo $sql;
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $row = mysql_fetch_array($result);
        $image = SITE_URL."/uploads/".stripslashes($row['image']);
        $color_code = "#".stripslashes($row['color_code']);

    }	
    return array($image,$color_code);
}	

function getTheam($day,$theam_id)
{
	global $link;
	
	$color_code = '#339900'; 
	$image = 'images/stressbuster_back.jpg';
	$credit = '';
	$credit_url = '';
			
	$sql = "SELECT * FROM `tbltheams` WHERE status = '1' AND theam_id = '".$theam_id."' ORDER BY `theam_add_date` DESC";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$color_code = stripslashes($row['color_code']);
		$image = SITE_URL."/uploads/".stripslashes($row['image']);
		$credit = stripslashes($row['credit']);
		$credit_url = stripslashes($row['credit_url']);
	}
	return array($color_code,$image,$credit,$credit_url);

}



function GetTooltip($page_id)
{
	global $link;
	
	$toolcontents = '';
		
	$sql = "SELECT * FROM `tbltooltip` WHERE page_id = '".$page_id."' ";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$toolcontents = stripslashes($row['text']);

	}	
	return $toolcontents;
}	

function GetAngerVentTooltip($page_id)
{
	global $link;
	
	$toolcontents = '';
		
	$sql = "SELECT * FROM `tblangerventtooltip` WHERE page_id = '".$page_id."' ";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$toolcontents = stripslashes($row['text']);

	}	
	return $toolcontents;
}	

function getStressBusterBannerDetails($banner_id)
{
	global $link;
	$stress_buster_box_id = '';
	$step = '';
	$box_title = '';
	$box_type = '';
	$banner = '';
	$box_type = '';
	$credit_line = '';
	$credit_line_url = '';
	
	$sql = "SELECT * FROM `tblstressbusterbox` WHERE stress_buster_box_id = '".$banner_id."' ";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$stress_buster_box_id = stripslashes($row['stress_buster_box_id']);
		$step = stripslashes($row['step']);
		$box_title = stripslashes($row['box_title']);
		$banner_type = stripslashes($row['box_type']);    
		$banner = stripslashes($row['box_banner']);
		$box_desc = stripslashes($row['box_desc']);
		$credit_line = stripslashes($row['credit_line']);
		$credit_line_url = stripslashes($row['credit_line_url']);
		
	}	
	return array($stress_buster_box_id,$step,$box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url);
}	

function getSolutionItemDetails($sol_item_id)
{
	global $link;
	$box_title = '';
	$box_type = '';
	$banner = '';
	$box_desc = '';
	$credit_line = '';
	$credit_line_url = '';
        $rss_feed_item_id = '';
	
	$sql = "SELECT * FROM `tblsolutionitems` WHERE sol_item_id = '".$sol_item_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $box_title = stripslashes($row['sol_box_title']);
            $banner_type = stripslashes($row['sol_box_type']);    
            $banner = stripslashes($row['sol_box_banner']);
            $box_desc = stripslashes($row['sol_box_desc']);
            $credit_line = stripslashes($row['sol_credit_line']);
            $credit_line_url = stripslashes($row['sol_credit_line_url']);
            $rss_feed_item_id = stripslashes($row['rss_feed_item_id']);
		
	}	
	return array($box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url,$rss_feed_item_id);
}	


function getBannerString($banner)
{
	$search = 'v=';
	$pos = strpos($banner, $search);
	$str = strlen($banner);
	$rest = substr($banner, $pos+2, $str);
	//echo $rest;
	return 'http://www.youtube.com/embed/'.$rest;
}

function getSressBusterBannerString($banner)
{
	$search = 'v=';
	$pos = strpos($banner, $search);
	$str = strlen($banner);
	$rest = substr($banner, $pos+2, $str);
	return 'http://www.youtube.com/embed/'.$rest;
}

function GetSliderCount()
{
	global $link;
	$count = '0';
	$sql = "SELECT * FROM `tblparentsliders`";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$count = mysql_num_rows($result);
		}
	return $count;
}


function getUserIdReset($email)
{
	global $link;
	$user_id = 0;
	
	$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `status` = '1'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$user_id = $row['user_id'];
	}
	return $user_id;
}	

function get_BoxSelectedItemCode($banner_id)
	{
	list($stress_buster_box_id,$step,$box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url) = getStressBusterBannerDetails($banner_id);
		$output ='<table align="center" width="290" border="0" cellspacing="0" cellpadding="0" style="padding-left:10px; padding-right:10px;">
					 <tr>
						<td height="30" align="left" valign="middle"><span class="Header_brown">'.$box_title.'</span></td>
						  </tr>
						  <tr>
							 <td align="left" valign="middle">';
	
			 if($banner_type == 'Flash') { 
       $output .='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="270" ><param name="movie" value="'. SITE_URL."/uploads/".$banner.'" /> <param name="wmode" value="transparent" /><param name="quality" value="high" /><embed src="'. SITE_URL."/uploads/".$banner.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="270"  wmode="transparent"></embed>
                                                            </object>';
         } elseif($banner_type == 'Image') { 
        $output .='<img src="'.SITE_URL."/uploads/".$banner.'" width="270" border="0" />';
         } elseif($banner_type == 'Video') { 
        $output .='<iframe width="270" src="'. getSressBusterBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';
         } elseif($banner_type == 'Audio') {
        $output .='<embed type="application/x-shockwave-flash" flashvars="audioUrl='.SITE_URL."/uploads/".$banner.'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="270" height="27" quality="best"  wmode="transparent"></embed>';
              }  
   $output .='</td>
                     </tr>
                         <tr>
                             <td height="25" align="right" valign="top" class="footer"><a href="'.$credit_line_url.'" target="_blank">'.$credit_line.'</a></td>
                          </tr>
						  <tr>
							<td align="left" valign="top">'.$box_desc.'</td>
						  </tr></table>';
	  
	return $output;
	}
        
    function get_BoxSelectedItemCodeMWS($sol_item_id)
    {
	list($box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url,$rss_feed_item_id) = getSolutionItemDetails($sol_item_id);
        $output ='  <table align="center" width="290" border="0" cellspacing="0" cellpadding="0" style="padding-left:10px; padding-right:10px;">
                        <tr>
                            <td height="30" align="left" valign="middle"><span class="Header_brown">'.$box_title.'</span></td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">';
        if($banner_type == 'Flash') { 
        $output .='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="270" ><param name="movie" value="'. SITE_URL."/uploads/".$banner.'" /> <param name="wmode" value="transparent" /><param name="quality" value="high" /><embed src="'. SITE_URL."/uploads/".$banner.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="270"  wmode="transparent"></embed></object>';
        } elseif($banner_type == 'Image') { 
        $output .='<img src="'.SITE_URL."/uploads/".$banner.'" width="270" height="270" border="0" />';
        } elseif($banner_type == 'Video') { 
        $output .='<iframe width="270" src="'. getSressBusterBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';
        } elseif($banner_type == 'Audio') {
        $output .='<embed type="application/x-shockwave-flash" flashvars="audioUrl='.SITE_URL."/uploads/".$banner.'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="270" height="27" quality="best"  wmode="transparent"></embed>';
        } elseif($banner_type == 'Pdf') { 
        $output .= '<a href="'.SITE_URL."/uploads/".$banner.'" target="_blank">'.$box_title.'</a>';   
        } elseif($sc_content_type == 'rss') { 
            list($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json) = getRssFeedItemDetails($rss_feed_item_id);
            $output .= '<a href="'.$rss_feed_item_link.'" target="_blank">'.$rss_feed_item_title.'</a>';   
        } elseif($sc_content_type == 'text') { 
            $output .= $box_desc;   
        }       
        $output .='</td>
                     </tr>
                         <tr>
                             <td height="25" align="right" valign="top" class="footer"><a href="'.$credit_line_url.'" target="_blank">'.$credit_line.'</a></td>
                          </tr>
						  <tr>
							<td align="left" valign="top">'.$box_desc.'</td>
						  </tr></table>';
	  
	return $output;
	}        
	
function getAngerventBannerDetails($banner_id)
{
	global $link;
	$anger_vent_box_id = '';
	$step = '';
	$box_title = '';
	$box_type = '';
	$banner = '';
	$box_type = '';
	$credit_line = '';
	
	$sql = "SELECT * FROM `tblangervent` WHERE anger_vent_box_id = '".$banner_id."' ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$anger_vent_box_id = stripslashes($row['anger_vent_box_id']);
		$step = stripslashes($row['step']);
		$box_title = stripslashes($row['box_title']);
		$banner_type = stripslashes($row['box_type']);    
		$banner = stripslashes($row['box_banner']);
		$box_desc = stripslashes($row['box_desc']);
		$credit_line = stripslashes($row['credit_line']);
		$credit_line_url = stripslashes($row['credit_line_url']);
		
	}	
	return array($anger_vent_box_id,$step,$box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url);
}	

	
function get_AngerventBoxCode($banner_id)
	{
	list($anger_vent_box_id,$step,$box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url) = getAngerventBannerDetails($banner_id);
		$output ='<table align="center" width="290" border="0" cellspacing="0" cellpadding="0" style="padding-left:10px; padding-right:10px;">
					 <tr>
						<td height="30" align="left" valign="middle"><span class="Header_brown">'.$box_title.'</span></td>
						  </tr>
						  <tr>
							 <td align="left" valign="middle">';
	
			 if($banner_type == 'Flash') { 
       $output .='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="270" ><param name="movie" value="'. SITE_URL."/uploads/".$banner.'" /> <param name="wmode" value="transparent" /><param name="quality" value="high" /><embed src="'. SITE_URL."/uploads/".$banner.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="270"  wmode="transparent"></embed>
                                                            </object>';
         } elseif($banner_type == 'Image') { 
        $output .='<img src="'.SITE_URL."/uploads/".$banner.'" width="270" border="0" />';
         } elseif($banner_type == 'Video') { 
        $output .='<iframe width="270" src="'. getSressBusterBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';
         } elseif($banner_type == 'Audio') {
        $output .='<embed type="application/x-shockwave-flash" flashvars="audioUrl='.SITE_URL."/uploads/".$banner.'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="270" height="27" quality="best"  wmode="transparent"></embed>';
              }  
   $output .='</td>
                     </tr>
                         <tr>
                             <td height="25" align="right" valign="top"><a href="'.$credit_line_url.'" target="_blank"><span class="footer">'.$credit_line.'</span></a></td>
                          </tr>
						  <tr>
							<td align="left" valign="top">'.$box_desc.'</td>
						  </tr></table>';
	  
	return $output;
	}
	
	function getMindJumbleDetails($banner_id)
{
	global $link;
	$mind_jumble_box_id = '';
	$box_title = '';
	$box_type = '';
	$banner = '';
	$box_type = '';
	$credit_line = '';
	
	$sql = "SELECT * FROM `tblmindjumble` WHERE mind_jumble_box_id = '".$banner_id."' ";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$mind_jumble_box_id = stripslashes($row['mind_jumble_box_id']);
		$box_title = stripslashes($row['box_title']);
		$banner_type = stripslashes($row['box_type']);    
		$banner = stripslashes($row['box_banner']);
		$box_desc = stripslashes($row['box_desc']);
		$credit_line = stripslashes($row['credit_line']);
		
	}	
	return array($mind_jumble_box_id,$box_title,$banner_type,$banner,$box_desc,$credit_line);
}	
	
	
	function get_MindJumbleBoxCode($banner_id)
	{
	list($mind_jumble_box_id,$box_title,$banner_type,$banner,$box_desc,$credit_line) = getMindJumbleDetails($banner_id);
		$output ='<table align="center" width="290" border="0" cellspacing="0" cellpadding="0" style="padding-left:10px; padding-right:10px;" >
					 <tr id="slider_main_bg">
						<td height="30" align="left" valign="middle"><span class="Header_brown">'.$box_title.'</span></td>
						  </tr>
						  <tr>
							 <td align="left" valign="middle">';
	
			 if($banner_type == 'Flash') { 
       $output .='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="270" ><param name="movie" value="'. SITE_URL."/uploads/".$banner.'" /> <param name="wmode" value="transparent" /><param name="quality" value="high" /><embed src="'. SITE_URL."/uploads/".$banner.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="270"  wmode="transparent"></embed>
                                                            </object>';
         } elseif($banner_type == 'Image') { 
        $output .='<img src="'.SITE_URL."/uploads/".$banner.'" width="270" border="0" />';
         } elseif($banner_type == 'Video') { 
        $output .='<iframe width="270" src="'. getSressBusterBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';
         } elseif($banner_type == 'Audio') {
        $output .='<embed type="application/x-shockwave-flash" flashvars="audioUrl='.SITE_URL."/uploads/".$banner.'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="270" height="27" quality="best"  wmode="transparent"></embed>';
              }  
   $output .='</td>
                     </tr>
                         <tr>
                             <td height="25" align="right" valign="top"><span class="footer">'.$credit_line.'</span></td>
                          </tr>
						  <tr>
							<td align="left" valign="top">'.$box_desc.'</td>
						  </tr></table>';
	  
	return $output;
	}
	
	


function ResetPassword($password,$user_id)
{
	global $link;
	$return = false;
	$sql = "UPDATE `tblusers` set `password` = '".md5($password)."' where user_id = '".$user_id."'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
	}
	return $return;	
}

function chkValidEmailID($email)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `status` = '1' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}

function chk_valid_user_feedback_id($id,$user_id)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tblfeedback` WHERE `feedback_id` = '".$id."' AND `user_id` = '".$user_id."' ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}

function GetUserName($email)
{
	global $link;
	$name = '';
	$sql = "select * from `tblusers` where email = '".$email."'";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$name = stripslashes($row['name']);
	}
	return $name;
}

function getMembershipsOptions($membership_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblmemberships` ORDER BY `membership_id` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			if($row['membership_id'] == $membership_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['membership_id'].'" '.$sel.'>'.$row['membership'].'</option>';
		}
	}
	return $option_str;
}
?>