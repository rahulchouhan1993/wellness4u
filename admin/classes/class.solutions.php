<?php
include_once("class.paging.php");
include_once("class.admin.php");
require_once('class.profilecustomization.php');  

class Solutions extends Admin

{

    public function getPRCTReferenceOptions($prct_ref_no)

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $option_str = '';

        $sql = "SELECT DISTINCT prct_ref_no FROM `tblprofilecustomization` WHERE `prct_ref_no` != '' AND `deleted` = '0' AND `status` = '1' ORDER BY prct_ref_no ASC";

      //  $this->execute_query($sql);
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC))

            {

                if($row['prct_ref_no'] == $prct_ref_no)

                {

                    $selected = ' selected ';

                }

                else

                {

                    $selected = '';

                }

                $option_str .= '<option value="'.stripslashes($row['prct_ref_no']).'" '.$selected.' >'.stripslashes($row['prct_ref_no']).'</option>';

            }	 

        }



        

        return $option_str;

    }

    

    public function addSolutionOld($arr_selected_situation_id,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$arr_min_rating,$arr_max_rating,$arr_sol_cat_id,$arr_sol_item_id)

    {

      $my_DBH = new mysqlConnection();
      $DBH = $my_DBH->raw_handle();
      $DBH->beginTransaction();

        $return = false;

        

        for($i=0;$i<count($arr_selected_situation_id);$i++)

        {

            $temp_arr = explode('_', $arr_selected_situation_id[$i]);

            $sol_situation_id = $temp_arr[1];

            $sol_situation_type = $temp_arr[0];

            

            for($j=0;$j<count($arr_min_rating);$j++)

            {

                for($k=0;$k<count($arr_sol_item_id[$j]);$k++)

                {

                    $ins_sql = "INSERT INTO `tblsolutions`(`sol_situation_id`,`sol_situation_type`,`listing_date_type`,`days_of_month`,`single_date`,"

                            . "`start_date`,`end_date`,`min_rating`,`max_rating`,`sol_cat_id`,`sol_item_id`,`sol_status`) "

                            . "VALUES ('".addslashes($sol_situation_id)."','".addslashes($sol_situation_type)."','".addslashes($listing_date_type)."',"

                            . "'".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."',"

                            . "'".addslashes($arr_min_rating[$j])."','".addslashes($arr_max_rating[$j])."','".addslashes($arr_sol_cat_id[$j])."',"

                            . "'".addslashes($arr_sol_item_id[$j][$k])."','1')";

                $STH = $DBH->prepare($ins_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

                }

            }

        }

        

        return $return;

    }

    

public function getDayOfWeekOptionsMultiple($day_of_week)

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



public function getDayOfWeekCommastr($str_day_of_week)

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



public function getMonthsOptionsMultiple($arr_month)

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



    foreach($arr_record as $k => $v )

    {

            if(in_array($k ,$arr_month))

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



public function getMonthsCommastr($str_month)

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





    

    public function addSolution($arr_prct_id,$arr_sol_cat_id,$arr_sol_item_id,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$days_of_week,$months)

    {

       $my_DBH = new mysqlConnection();
       $DBH = $my_DBH->raw_handle();
       $DBH->beginTransaction();

        $return = false;

        

        $admin_id = $_SESSION['admin_id'];

        

        $obj = new ProfileCustomization();

        for($i=0;$i<count($arr_prct_id);$i++)

        {

            $arr_record = $obj->getProfileCustomizationDetails($arr_prct_id[$i]);

            

            //$listing_date_type = $arr_record[0]['listing_date_type'];

            //$days_of_month = $arr_record[0]['days_of_month'];

            //$single_date = $arr_record[0]['single_date'];

            //$start_date = $arr_record[0]['start_date'];

            //$end_date = $arr_record[0]['end_date'];

            //$days_of_week = $arr_record[0]['days_of_week'];

            //$months = $arr_record[0]['months'];

            $sol_situation_id = $arr_record[0]['keyword_id'];

            $sol_situation_type = $arr_record[0]['keyword_type'];

            $scale_range = $arr_record[0]['keyword_scale_type'];

            $start_scale_value = $arr_record[0]['keyword_scale_value1'];

            $end_scale_value = $arr_record[0]['keyword_scale_value2'];

            $module_criteria = $arr_record[0]['criteria_id'];

            $criteria_scale_range = $arr_record[0]['criteria_scale_type'];

            $start_criteria_scale_value = $arr_record[0]['criteria_scale_value1'];

            $end_criteria_scale_value = $arr_record[0]['criteria_scale_value2'];

                                 

            list($min_val,$max_val) = $obj->getMinAndMaxKeywordScaleValue($scale_range,$start_scale_value,$end_scale_value);

            

            $user_country_id = $arr_record[0]['user_country_id'];

            $user_state_id = $arr_record[0]['user_state_id'];

            $user_city_id = $arr_record[0]['user_city_id'];

            $user_place_id = $arr_record[0]['user_place_id'];

            $user_gender = $arr_record[0]['user_gender'];

            $user_food_option = $arr_record[0]['user_food_option'];

            $user_height1 = $arr_record[0]['user_height1'];

            $user_height2 = $arr_record[0]['user_height2'];

            $user_weight1 = $arr_record[0]['user_weight1'];

            $user_weight2 = $arr_record[0]['user_weight2'];

            $user_age1 = $arr_record[0]['user_age1'];

            $user_age2 = $arr_record[0]['user_age2'];

            $user_bmi1 = $arr_record[0]['user_bmi1'];

            $user_bmi2 = $arr_record[0]['user_bmi2'];

            $pro_user_country_id = $arr_record[0]['pro_user_country_id'];

            $pro_user_state_id = $arr_record[0]['pro_user_state_id'];

            $pro_user_city_id = $arr_record[0]['pro_user_city_id'];

            $pro_user_place_id = $arr_record[0]['pro_user_place_id'];

            $pro_user_gender = $arr_record[0]['pro_user_gender'];

            $pro_user_age1 = $arr_record[0]['pro_user_age1'];

            $pro_user_age2 = $arr_record[0]['pro_user_age2'];

            $pro_user_service = $arr_record[0]['pro_user_service'];

            

            for($j=0;$j<count($arr_sol_cat_id);$j++)

            {

                for($k=0;$k<count($arr_sol_item_id[$j]);$k++)

                {

                    $ins_sql = "INSERT INTO `tblsolutions`(`prct_id`,`sol_situation_id`,`sol_situation_type`,`listing_date_type`,`days_of_month`,`single_date`,"

                            . "`start_date`,`end_date`,`days_of_week`,`months`,`keyword_scale_type`,`min_rating`,`max_rating`,`criteria_id`,"

                            . "`criteria_scale_type`,`criteria_scale_value1`,`criteria_scale_value2`,`sol_cat_id`,`sol_item_id`,`sol_status`,"

                            . "`user_country_id`,`user_state_id`,`user_city_id`,`user_place_id`,`user_gender`,`user_food_option`,`user_height1`,"

                            . "`user_height2`,`user_weight1`,`user_weight2`,`user_age1`,`user_age2`,`user_bmi1`,`user_bmi2`,`pro_user_country_id`,"

                            . "`pro_user_state_id`,`pro_user_city_id`,`pro_user_place_id`,`pro_user_gender`,`pro_user_age1`,`pro_user_age2`,`pro_user_service`) "

                            . "VALUES ('".addslashes($arr_prct_id[$i])."','".addslashes($sol_situation_id)."','".addslashes($sol_situation_type)."','".addslashes($listing_date_type)."',"

                            . "'".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."','".addslashes($days_of_week)."','".addslashes($months)."','".addslashes($scale_range)."',"

                            . "'".addslashes($min_val)."','".addslashes($max_val)."','".addslashes($module_criteria)."','".addslashes($criteria_scale_range)."','".addslashes($start_criteria_scale_value)."','".addslashes($end_criteria_scale_value)."','".addslashes($arr_sol_cat_id[$j])."','".addslashes($arr_sol_item_id[$j][$k])."','1',"

                            . "'".addslashes($user_country_id)."','".addslashes($user_state_id)."','".addslashes($user_city_id)."',"

                            . "'".addslashes($user_place_id)."','".addslashes($user_gender)."','".addslashes($user_food_option)."',"

                            . "'".addslashes($user_height1)."','".addslashes($user_height2)."','".addslashes($user_weight1)."','".addslashes($user_weight2)."',"

                            . "'".addslashes($user_age1)."','".addslashes($user_age2)."','".addslashes($user_bmi1)."','".addslashes($user_bmi2)."',"

                            . "'".addslashes($pro_user_country_id)."','".addslashes($pro_user_state_id)."','".addslashes($pro_user_city_id)."',"

                            . "'".addslashes($pro_user_place_id)."','".addslashes($pro_user_gender)."','".addslashes($pro_user_age1)."',"

                            . "'".addslashes($pro_user_age2)."','".addslashes($pro_user_service)."')";

                        $STH = $DBH->prepare($ins_sql);
                        $STH->execute();
		        if($STH->rowCount()> 0)
		            {
			    $return = true;
		            }
		return $return;

                }

            }

        }

        

        return $return;

    }

    

    public function getAllProfileCustomizationSelectionStr($prct_ref_no,$arr_prct_id,$prct_cat_id)

    {

      $my_DBH = new mysqlConnection();
      $DBH = $my_DBH->raw_handle();
      $DBH->beginTransaction();

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



        $sql = "SELECT * FROM `tblprofilecustomization` WHERE `deleted` = '0' AND `status` = '1' ".$str_sql_ref_no." ".$str_sql_cat."  ORDER BY `prct_add_date` DESC";

        //echo '<br>'.$sql;

        //$this->execute_query($sql);
        $STH = $DBH->prepare($sql);
        $STH->execute();

        $output .= '<div style="width:600px;height:300px;overflow:scroll;">

                        <table border="0" width="100%" cellpadding="1" cellspacing="1">

                        <tbody>

                            <tr class="manage-header">

                                <td width="5%" class="manage-header" align="center" ></td>

                                <td width="15%" class="manage-header" align="center">Module</td>

                                <td width="20%" class="manage-header" align="center">Keywords</td>

                                <td width="15%" class="manage-header" align="center">Keywords Scale</td>

                                <td width="10%" class="manage-header" align="center">Criteria</td>

                                <td width="15%" class="manage-header" align="center">Criteria Scale</td>';

        

        /*

        $output .= '            <td width="10%" class="manage-header" align="center">Date Type</td>

                                <td width="15%" class="manage-header" align="center">Date</td>';

         * 

         */

        

        $output .= '        </tr>';

        if($STH->rowCount() > 0)

        {

            $j = 0;

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if(in_array($row['prct_id'] ,$arr_prct_id))

                {

                    $sel = ' checked ';

                }

                else

                {

                    $sel = '';

                }

                

                $obj = new ProfileCustomization();

                

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

                    $date_value = $obj->getDayOfWeekCommaStr($row['days_of_week']);

                    $date_value = str_replace(',', ' , ', $date_value);

                }

                elseif($row['listing_date_type'] == 'month_wise')

                {

                    $date_type = 'Month Wise';

                    $date_value = $obj->getMonthsCommastr($row['months']);

                    $date_value = str_replace(',', ' , ', $date_value);

                }

                elseif($row['listing_date_type'] == '')

                {

                    $date_type = 'All';

                    $date_value = '';

                }

                

                $module_id = $row['module_id'];

                $module = $obj->getModuleNamePCM($module_id);

                $keyword_id = $row['keyword_id'];

                $keyword_type = $row['keyword_type'];        

                $keywords = $obj->getKeywordName($keyword_id,$keyword_type);

                $keyword_scale_type = $row['keyword_scale_type'];

                $keyword_scale_value1 = $row['keyword_scale_value1'];

                $keyword_scale_value2 = $row['keyword_scale_value2'];

                $keyword_scale_value = $obj->getKeywordScaleValueStr($keyword_scale_type,$keyword_scale_value1,$keyword_scale_value2);

                $criteria_id = $row['criteria_id'];

                $criteria = $obj->getCriteriaName($criteria_id);

                $criteria_scale_type = $row['criteria_scale_type'];

                $criteria_scale_value1 = $row['criteria_scale_value1'];

                $criteria_scale_value2 = $row['criteria_scale_value2'];

                $criteria_scale_value = $obj->getCriteriaScaleValueStr($criteria_scale_type,$criteria_scale_value1,$criteria_scale_value2);

                

                

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

    

    public function getAllSolutionItemsSelectionStr($arr_sol_item_id,$i=0,$category_ids='')

    {

      $my_DBH = new mysqlConnection();
      $DBH = $my_DBH->raw_handle();
      $DBH->beginTransaction();

        $output = '';		

        

        if($category_ids == '')

        {

            $sql_str_cat = '';

        }

        else

        {

            $sql_str_cat = " AND `category_ids` = '".$category_ids."' ";

        }



        $sql = "SELECT * FROM `tblsolutionitems` WHERE `sol_item_deleted` = '0' AND `sol_item_status` = '1' ".$sql_str_cat."  ORDER BY `topic_subject` ASC";

        //$this->execute_query($sql);
         $STH = $DBH->prepare($sql);
         $STH->execute();

        $output .= '<div style="width:600px;height:300px;overflow:scroll;">

                        <table border="0" width="100%" cellpadding="1" cellspacing="1">

                        <tbody>

                            <tr class="manage-header">

                                <td width="5%" class="manage-header" align="center" ></td>

                                <td width="30%" class="manage-header" align="center">Title</td>

                                <td width="5%" class="manage-header" align="center">Type</td>

                                <td width="30%" class="manage-header" align="center">Item</td>

                                <td width="30%" class="manage-header" align="center">Description</td>

                            </tr>';

        if($STH->rowCount() > 0)

        {

            $j = 0;

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if(in_array($row['sol_item_id'] ,$arr_sol_item_id))

                {

                    $sel = ' checked ';

                }

                else

                {

                    $sel = '';

                }

                

                $obj = new Solutions();

                

                $banner = stripslashes($row['sol_box_banner']);

                

                if($row['banner_type'] == 'Image')

                {

                    //$str_item = '<img border="0" src="'.SITE_URL.'/uploads/'.$banner.'" width="50">';

                    $str_item = '<ul class="zoomonhoverul"><li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $banner.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $banner.'" width="50" alt="gallery thumbnail" /></a></li></ul>';

                }

                elseif($row['banner_type'] == 'Flash')

                {

                    $str_item = '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="50" HEIGHT="50" id="myMovieName"><PARAM NAME=movie VALUE="'.SITE_URL.'/uploads/'. $banner.'"><PARAM NAME=quality VALUE=high><param name="wmode" value="transparent"><EMBED src="'.SITE_URL.'/uploads/'. $banner.'" quality=high WIDTH="50" HEIGHT="50" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED></OBJECT>';

                }

                elseif($row['banner_type'] == 'Video')

                {

                    $str_item = '<iframe width="50" height="50" src="'.$obj->getStressBusterBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';

                }

                elseif($row['banner_type'] == 'rss')

                {

                    $str_item = $obj->getRssFeedItemTitle($row['rss_feed_item_id']);

                }

                elseif($row['banner_type'] == 'text')

                {

                    $str_item = stripslashes($row['sol_box_desc']);

                }

                else

                {

                    $str_item = '<a href="'.SITE_URL.'/uploads/'. $banner.'" target="_blank">'.$banner.'</a> ';

                }

                

                $output .= '<tr class="manage-row">';

                $output .= '<td height="30" align="center" nowrap="nowrap" ><input type="checkbox" '.$sel.' name="sol_item_id_'.$i.'[]" id="sol_item_id_'.$i.'_'.$j.'" value="'.$row['sol_item_id'].'"></td>';

                $output .= '<td height="30" align="center"><strong>'.stripslashes($row['topic_subject']).'</strong></td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['banner_type']).'</td>';

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

    

    public function getAllSolutionItemsSelectionStrSingle($sol_item_id,$category_ids='')

    {

      $my_DBH = new mysqlConnection();
      $DBH = $my_DBH->raw_handle();
      $DBH->beginTransaction();

        $output = '';	

        

        $output .= '<div style="width:600px;height:300px;overflow:scroll;">

                        <table border="0" width="100%" cellpadding="1" cellspacing="1">

                        <tbody>

                            <tr class="manage-header">

                                <td width="5%" class="manage-header" align="center" ></td>

                                <td width="30%" class="manage-header" align="center">Title</td>

                                <td width="5%" class="manage-header" align="center">Type</td>

                                <td width="30%" class="manage-header" align="center">Item</td>

                                <td width="30%" class="manage-header" align="center">Description</td>

                            </tr>';



        if($category_ids == '')

        {

            $sql_str_cat = '';

        }

        else

        {

            $sql_str_cat = " AND `category_ids` = '".$category_ids."' ";

        }



        $sql = "SELECT * FROM `tblsolutionitems` WHERE `sol_item_id` = '".$sol_item_id."' AND `sol_item_deleted` = '0' AND `sol_item_status` = '1' ".$sql_str_cat."  ORDER BY `topic_subject` ASC";

        //echo'<br>'.$sql;

       // $this->execute_query($sql);
      $STH = $DBH->prepare($sql);
       $STH->execute();
        if($STH->rowCount() > 0)

        {

            $j = 0;

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['sol_item_id'] == $sol_item_id)

                {

                    $sel = ' checked ';

                }

                else

                {

                    $sel = '';

                }

                

                $obj = new Solutions();

                

                $banner = stripslashes($row['sol_box_banner']);

                

                if($row['banner_type'] == 'Image')

                {

                    //$str_item = '<img border="0" src="'.SITE_URL.'/uploads/'.$banner.'" width="50">';

                    $str_item = '<ul class="zoomonhoverul"><li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $banner.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $banner.'" width="50" alt="gallery thumbnail" /></a></li></ul>';

                }

                elseif($row['banner_type'] == 'Flash')

                {

                    $str_item = '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="50" HEIGHT="50" id="myMovieName"><PARAM NAME=movie VALUE="'.SITE_URL.'/uploads/'. $banner.'"><PARAM NAME=quality VALUE=high><param name="wmode" value="transparent"><EMBED src="'.SITE_URL.'/uploads/'. $banner.'" quality=high WIDTH="50" HEIGHT="50" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED></OBJECT>';

                }

                elseif($row['banner_type'] == 'Video')

                {

                    $str_item = '<iframe width="50" height="50" src="'.$obj->getStressBusterBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';

                }

                elseif($row['banner_type'] == 'rss')

                {

                    $str_item = $obj->getRssFeedItemTitle($row['rss_feed_item_id']);

                }

                elseif($row['banner_type'] == 'text')

                {

                    $str_item = stripslashes($row['sol_box_desc']);

                }

                else

                {

                    $str_item = '<a href="'.SITE_URL.'/uploads/'. $banner.'" target="_blank">'.$banner.'</a> ';

                }

                

                $output .= '<tr class="manage-row">';

                $output .= '<td height="30" align="center" nowrap="nowrap" ><input type="radio" '.$sel.' name="sol_item_id" id="sol_item_id_'.$j.'" value="'.$row['sol_item_id'].'"></td>';

                $output .= '<td height="30" align="center"><strong>'.stripslashes($row['topic_subject']).' </strong></td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['banner_type']).'</td>';

                $output .= '<td align="center">'.$str_item.'</td>';

                $output .= '<td align="center"><strong>'.stripslashes($row['sol_box_desc']).'</strong></td>';

                $output .= '</tr>';

                

                $j++;

            }

        }

        

        $sql = "SELECT * FROM `tblsolutionitems` WHERE `sol_item_id` != '".$sol_item_id."' AND `sol_item_deleted` = '0' AND `sol_item_status` = '1' ".$sql_str_cat."  ORDER BY `topic_subject` ASC";

        //$this->execute_query($sql);
       $STH2 = $DBH->prepare($sql);
       $STH2->execute();
        if($STH2->rowCount() > 0)

        {

            $j = 0;

            while($row = $STH2->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['sol_item_id'] == $sol_item_id)

                {

                    $sel = ' checked ';

                }

                else

                {

                    $sel = '';

                }

                

                $obj = new Solutions();

                

                $banner = stripslashes($row['sol_box_banner']);

                

                if($row['banner_type'] == 'Image')

                {

                    //$str_item = '<img border="0" src="'.SITE_URL.'/uploads/'.$banner.'" width="50">';

                    $str_item = '<ul class="zoomonhoverul"><li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $banner.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $banner.'" width="50" alt="gallery thumbnail" /></a></li></ul>';

                }

                elseif($row['banner_type'] == 'Flash')

                {

                    $str_item = '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="50" HEIGHT="50" id="myMovieName"><PARAM NAME=movie VALUE="'.SITE_URL.'/uploads/'. $banner.'"><PARAM NAME=quality VALUE=high><param name="wmode" value="transparent"><EMBED src="'.SITE_URL.'/uploads/'. $banner.'" quality=high WIDTH="50" HEIGHT="50" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED></OBJECT>';

                }

                elseif($row['banner_type'] == 'Video')

                {

                    $str_item = '<iframe width="50" height="50" src="'.$obj->getStressBusterBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';

                }

                elseif($row['banner_type'] == 'rss')

                {

                    $str_item = $obj->getRssFeedItemTitle($row['rss_feed_item_id']);

                }

                elseif($row['banner_type'] == 'text')

                {

                    $str_item = stripslashes($row['sol_box_desc']);

                }

                else

                {

                    $str_item = '<a href="'.SITE_URL.'/uploads/'. $banner.'" target="_blank">'.$banner.'</a> ';

                }

                

                $output .= '<tr class="manage-row">';

                $output .= '<td height="30" align="center" nowrap="nowrap" ><input type="radio" '.$sel.' name="sol_item_id" id="sol_item_id_'.$j.'" value="'.$row['sol_item_id'].'"></td>';

                $output .= '<td height="30" align="center"><strong>'.stripslashes($row['topic_subject']).' </strong></td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['banner_type']).'</td>';

                $output .= '<td align="center">'.$str_item.'</td>';

                $output .= '<td align="center"><strong>'.stripslashes($row['sol_box_desc']).'</strong></td>';

                $output .= '</tr>';

                

                $j++;

            }

        }

        else

        {

           // $output .= '<tr class="manage-row" height="20"><td colspan="5" align="center">NO RECORDS FOUND</td></tr>';

        }

        $output .= '</tbody></table></div>';

        return $output;

    }

    

    public function getAllTriggersChkeckbox($arr_selected_situation_id,$width = '400',$height = '350')

    {

       // $this->connectDB();
     $my_DBH = new mysqlConnection();
     $DBH = $my_DBH->raw_handle();
     $DBH->beginTransaction();
        $output = '';

        

        $data = array();

        

        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY `bms_name` ASC";

       // $this->execute_query($sql);
       $STH = $DBH->prepare($sql);
      $STH->execute();
        if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['bms_'.$row['bms_id']] = stripslashes($row['bms_name']);

            }

        }

        

        $sql = "SELECT * FROM `tbladdictions` WHERE `status` = '1' ORDER BY `situation` ASC";

	//$this->execute_query($sql);
        $STH2 = $DBH->prepare($sql);
        $STH2->execute();
        if($STH2->rowCount() > 0)

        {

            while($row = $STH2->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['adct_'.$row['adct_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tblsleeps` WHERE  `status` = '1' ORDER BY `situation` ASC";

	//$this->execute_query($sql);
         $STH3 = $DBH->prepare($sql);
         $STH3->execute();
        if($STH3->rowCount() > 0)

        {

            while($row = $STH3->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['sleep_'.$row['sleep_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tblgeneralstressors` WHERE `status` = '1' ORDER BY `situation` ASC";

	//$this->execute_query($sql);
         $STH4 = $DBH->prepare($sql);
         $STH4->execute();
       if($STH4->rowCount() > 0)

        {

            while($row = $STH4->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['gs_'.$row['gs_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tblworkandenvironments` WHERE `status` = '1' ORDER BY `situation` ASC";

	 $STH5 = $DBH->prepare($sql);
         $STH5->execute();

       if($STH5->rowCount() > 0)

        {

            while($row = $STH5->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['wae_'.$row['wae_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tblmycommunications` WHERE  `status` = '1' ORDER BY `situation` ASC";

	//echo 'mc sql ='.$sql;

        $STH6 = $DBH->prepare($sql);
         $STH6->execute();

       if($STH6->rowCount() > 0)

        {

            while($row = $STH6->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['mc_'.$row['mc_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tblmyrelations` WHERE `status` = '1' ORDER BY `situation` ASC";

	 $STH7 = $DBH->prepare($sql);
         $STH7->execute();

       if($STH7->rowCount() > 0)

        {

            while($row = $STH7->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['mr_'.$row['mr_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tblmajorlifeevents` WHERE  `status` = '1' ORDER BY `situation` ASC";

	 $STH8 = $DBH->prepare($sql);
         $STH8->execute();

       if($STH8->rowCount() > 0)

        {

            while($row = $STH8->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['mle_'.$row['mle_id']] = stripslashes($row['situation']);

            }

        }

        

        natcasesort($data);

        

        

        if(count($data) > 0)

        {

            $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">

                            <input type="checkbox" name="all_selected_situation_id" id="all_selected_situation_id" value="1" onclick="toggleCheckBoxes(\'selected_situation_id\'); " />&nbsp;<strong>Select All</strong> 

                        </div>

                        <div style="clear:both;"></div>';

            $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';

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

        
     //update by ample 13-05-20
    public function getSolutionItemDetails($sol_item_id)

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $box_title = '';

        $box_type = '';

        $box_desc = '';

        $banner = '';

        $status = '';

        $sound_clip_id = '';

        $rss_feed_item_id = '';

        $category_ids = '';

        $reference_title = '';

        //add by ample 19-10-20
            $listing_date_type="";
            $single_date="";
            $start_date="";
            $end_date="";
            $days_of_month='';
            $days_of_week='';
            $months='';
            $state_id="";
            $city_id="";
            $area_id="";
            $is_featured="";

        $sql = "SELECT * FROM `tblsolutionitems` WHERE `sol_item_id` = '".$sol_item_id."' AND `sol_item_deleted` = '0' ";

       $STH = $DBH->prepare($sql);
       $STH->execute();

       if($STH->rowCount() > 0)

        {

            $row = $STH->fetch(PDO::FETCH_ASSOC);
            
            $reference_title = stripslashes($row['reference_title']);

            $status = stripslashes($row['sol_item_status']);

            $page_name = stripslashes($row['page_name']);

            $image_id = stripslashes($row['image_id']);
            
            $category=stripslashes($row['category_ids']);

            $category_header=stripslashes($row['category_header']);

            $wellbgn_ref_num = stripslashes($row['ref_code']); //change by ample 13-05-20

            $user_type = stripslashes($row['user_type']);
            
            $user_name = stripslashes($row['user_name']);
            
            $topic_subject = stripslashes($row['topic_subject']);
            
            $narration = stripslashes($row['narration']);

            $show_in_pop = stripslashes($row['show_pop']);

             //add by ample 13-05-20
            $group_code = stripslashes($row['group_code']);
            
            $tags = stripslashes($row['tags']);
            //add by ample 15-05-20
            $key_ref_title=$row['key_ref_title'];
            $key_topic=$row['key_topic'];
            $key_narration=$row['key_narration'];
            $key_tags=$row['key_tags'];

            $credit = stripslashes($row['credit']);
            $credit_url = stripslashes($row['credit_url']);

            //add by ample 18-05-20
            $design_data=array();
            $design_data['order_show']= $row['order_show'];
            $design_data['user_upload_show']= $row['user_upload_show'];
            $design_data['schedule_id']= $row['schedule_id']; //add by ample 20-10-20

            //add by ample 30-12-20
            $banner_type=$row['banner_type'];
            $banner=stripslashes($row['banner']);
            $admin_notes=stripslashes($row['admin_notes']);
            $is_featured_item=$row['is_featured_item'];
            $is_featured=$row['is_featured']; //add by ample 19-10-20
        }

        // return array($topic_subject,$narration,$wellbgn_ref_num,$user_type,$user_name,$reference_title,$image_id,$page_name,$banner_type,$banner,$status,$credit_line,$credit_line_url,$sound_clip_id,$rss_feed_item_id,$category_ids,$show_in_pop);
        //update by ample 13-05-20
        return array($topic_subject,$narration,$wellbgn_ref_num,$user_type,$user_name,$reference_title,$image_id,$page_name,$status,$show_in_pop,$group_code,$category,$category_header,$tags,$key_ref_title,$key_topic,$key_narration,$key_tags,$credit,$credit_url,$banner_type,$banner,$admin_notes,$is_featured,$is_featured_item,$design_data);

    }

    

    public function getSolutionDetails($sol_id)

    {

       $my_DBH = new mysqlConnection();
       $DBH = $my_DBH->raw_handle();
       $DBH->beginTransaction();

        $arr_records = array();

        

        $sql = "SELECT * FROM `tblsolutions` WHERE `sol_id` = '".$sol_id."' AND `sol_deleted` = '0' ";

       $STH = $DBH->prepare($sql);
      $STH->execute();

       if($STH->rowCount() > 0)

        {

            $row = $STH->fetch(PDO::FETCH_ASSOC);

            $arr_records[] = $row;

        }

        return $arr_records;

    }

    
    //update by ample 18-05-20 & update 22-10-20 && delete columns amnd add columns 30-12-20
    public function updateSolutionItem($topic_subject,$narration,$user_name,$user_id,$user_type,$wellbgn_ref_num,$sol_item_id,$status,$show_in_pop,$group_code,$category,$category_header,$tags,$key_ref_title,$key_topic,$key_narration,$key_tags,$order_show,$user_upload_show,$credit,$credit_url,$banner_type,$banner,$admin_notes,$page_id,$is_featured,$is_featured_item)

    {

       $my_DBH = new mysqlConnection();
       $DBH = $my_DBH->raw_handle();
       $DBH->beginTransaction();
       $return=false;
        $sql = "UPDATE `tblsolutionitems` SET "

                . "`sol_item_edit_date` = '".date('Y-m-d H:i:s')."' , "

                . "`topic_subject` = '".addslashes($topic_subject)."' , "

                . "`narration` = '".addslashes($narration)."' , "
                
                . "`user_name` = '".addslashes($user_name)."' , "

                . "`user_id` = '".addslashes($user_id)."' , "

                . "`user_type` = '".addslashes($user_type)."', "

                . "`ref_code` = '".addslashes($wellbgn_ref_num)."', "

                . "`sol_item_status` = '".addslashes($status)."', "

                    . "`group_code` = '".addslashes($group_code)."',"
                    . "`category_ids` = '".addslashes($category)."',"
                    . "`category_header` = '".addslashes($category_header)."',"
                    . "`tags` = '".addslashes($tags)."',"

                    . "`key_ref_title` = '".$key_ref_title."',"
                    . "`key_topic` = '".$key_topic."',"
                    . "`key_narration` = '".$key_narration."',"
                    . "`key_tags` = '".$key_tags."',"

                    //add by ample 18-05-20
                    . "`order_show` = '".$order_show."',"
                    . "`user_upload_show` = '".$user_upload_show."',"
                    . "`credit` = '".addslashes($credit)."',"
                    . "`credit_url` = '".addslashes($credit_url)."',"

                    //added by ample 30-12-20
                    . "`banner_type` = '".$banner_type."',"
                    . "`banner` = '".addslashes($banner)."',"
                    . "`admin_notes` = '".addslashes($admin_notes)."',"
                    . "`page_id` = '".addslashes($page_id)."',"

                    . "`is_featured_item` = '".$is_featured_item."',"
                    . "`is_featured` = '".$is_featured."',"

                . "`show_pop` = '".addslashes($show_in_pop)."' "

                . "WHERE `sol_item_id` = '".$sol_item_id."'";

        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
                $return = true;
        }
            
                
        return $return;
    }

    public function updateSolution($sol_id,$status,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$min_rating,$max_rating,$sol_cat_id,$sol_item_id,$days_of_week,$months,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value)

    {

       $my_DBH = new mysqlConnection();
       $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
         $return=false;
        $sql = "UPDATE `tblsolutions` SET "

                . "`listing_date_type` = '".addslashes($listing_date_type)."' , "

                . "`days_of_month` = '".addslashes($days_of_month)."', "

                . "`single_date` = '".addslashes($single_date)."', "

                . "`start_date` = '".addslashes($start_date)."', "

                . "`end_date` = '".addslashes($end_date)."', "

                . "`days_of_week` = '".addslashes($days_of_week)."', "

                . "`months` = '".addslashes($months)."', "

                . "`min_rating` = '".addslashes($min_rating)."', "

                . "`max_rating` = '".addslashes($max_rating)."', "

                . "`criteria_id` = '".addslashes($module_criteria)."', "

                . "`criteria_scale_type` = '".addslashes($criteria_scale_range)."', "

                . "`criteria_scale_value1` = '".addslashes($start_criteria_scale_value)."', "

                . "`criteria_scale_value2` = '".addslashes($end_criteria_scale_value)."', "

                . "`sol_cat_id` = '".addslashes($sol_cat_id)."', "

                . "`sol_item_id` = '".addslashes($sol_item_id)."', "

                . "`sol_status` = '".addslashes($status)."' "

                . "WHERE `sol_id` = '".$sol_id."'";

        //echo $sql;
              $STH = $DBH->prepare($sql);
              $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

    }

    

    public function getStressBusterBannerString($banner)

    {

        $search = 'v=';

        $pos = strpos($banner, $search);

        $str = strlen($banner);

        $rest = substr($banner, $pos+2, $str);

        return 'http://www.youtube.com/embed/'.$banner;

    }



    public function getSoundClipOptions($sound_clip_id)

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $option_str = '';		



        $sql = "SELECT * FROM `tblsoundclip` where `status` = 1 ORDER BY `sound_clip_add_date` ASC";

        //$this->execute_query($sql);
         $STH = $DBH->prepare($sql);
         $STH->execute();
       if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['sound_clip_id'] == $sound_clip_id)

                {

                    $sel = ' selected ';

                }

                else

                {

                    $sel = '';

                }		

                $option_str .= '<option value="'.$row['sound_clip_id'].'" '.$sel.'>'.$row['sound_clip'].'</option>';

            }

        }

        return $option_str;

    }

    

    public function getRssFeedItemTitle($rss_feed_item_id)

    {

       $my_DBH = new mysqlConnection();
       $DBH = $my_DBH->raw_handle();
       $DBH->beginTransaction();


        $rss_feed_item_title = '';



        $sql = "SELECT * FROM `tblrssfeeditems` WHERE `rss_feed_item_id` = '".$rss_feed_item_id."' ";

        $STH = $DBH->prepare($sql);
        $STH->execute();

       if($STH->rowCount() > 0)

        {

            $row = $STH->fetch(PDO::FETCH_ASSOC);

            $rss_feed_item_title = stripslashes($row['rss_feed_item_title']);

        }

        return $rss_feed_item_title;

    }

    

    public function getRssFeedOptions($rss_feed_item_id)

    {

         $my_DBH = new mysqlConnection();
         $DBH = $my_DBH->raw_handle();
          $DBH->beginTransaction();

        $option_str = '';		



        $sql = "SELECT * FROM `tblrssfeeditems` WHERE `rss_feed_item_status` = '1' ORDER BY `rss_feed_item_title` ASC";

        //echo $sql;

         $STH = $DBH->prepare($sql);
         $STH->execute();
       if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['rss_feed_item_id'] == $rss_feed_item_id)

                {

                    $sel = ' selected ';

                }

                else

                {

                    $sel = '';

                }		



                $option_str .= '<option value="'.$row['rss_feed_item_id'].'" '.$sel.'>'.stripslashes($row['rss_feed_item_title']).'</option>';

            }

        }

        return $option_str;

    }

        

   public function getTitleNameByIdVivek($image_id)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = '';
            
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$image_id."' ";
           // $this->execute_query($sql);
             $STH = $DBH->prepare($sql);
             $STH->execute();
           if($STH->rowCount() > 0)
            {
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                    $return = $row['fav_cat'];
            }
            return $return;
	}
   
     public function getTitleNameByIdFromBodymainsymptomVivek($image_id)
	{
           $my_DBH = new mysqlConnection();
           $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = '';
            
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$image_id."' ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
           if($STH->rowCount() > 0)
            {
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                    $return = $row['bms_name'];
            }
            return $return;
	}
   
    //update by ample 12-05-20 & update 18-05-20 & 27-10-20 & delete columns 30-12-20 & add columns 30-12-20
    public function addSolutionItem($topic_subject,$narration,$user_name,$user_id,$user_type,$wellbgn_ref_num,$reference_title,$image_id,$page_name,$show_in_pop,$group_code,$category,$category_header,$tags,$order_show,$user_upload_show,$credit,$credit_url,$banner_type,$banner,$admin_notes,$page_id,$is_featured,$is_featured_item)

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $return = false;



               $ins_sql = "INSERT INTO `tblsolutionitems`(`topic_subject`,`narration`,`user_name`,`user_id`,`user_type`,`ref_code`,`reference_title`,`image_id`,`page_name`,`group_code`,`tags`,`show_pop`,`sol_item_status`,`category_ids`,`category_header`,"

                . "`order_show`,`user_upload_show`,`credit`,`credit_url`,`banner_type`,`banner`,`admin_notes`,`page_id`,`is_featured`,`is_featured_item`) VALUES ('".addslashes($topic_subject)."','".addslashes($narration)."','".addslashes($user_name)."','".addslashes($user_id)."','".addslashes($user_type)."','".addslashes($wellbgn_ref_num)."','".addslashes($reference_title)."','".addslashes($image_id)."','".addslashes($page_name)."','".addslashes($group_code)."',"
                . "'".addslashes($tags)."','".$show_in_pop."','1','".addslashes($category)."','".addslashes($category_header)."',"
                . "'".$order_show."','".$user_upload_show."','".$credit."','".$credit_url."','".$banner_type."','".addslashes($banner)."','".addslashes($admin_notes)."','".addslashes($page_id)."','".$is_featured."','".$is_featured_item."')";

                $STH = $DBH->prepare($ins_sql);
                $STH->execute();
                

                $sol_item_id = $DBH->lastInsertId();

                if($sol_item_id)
                {
                     if($page_name=='fav_categories')
                        {
                        $upd_sql = "UPDATE `tblfavcategory` SET `sol_item_id` = '".$sol_item_id."'  WHERE `fav_cat_id` = '".$image_id."'";
                      $STH = $DBH->prepare($upd_sql);
                       $STH->execute();
                        }
                        
                        else if($page_name=='main_symptoms')
                        {
                            
                        $upd_sql = "UPDATE `tblbodymainsymptoms` SET `sol_item_id` = '".$sol_item_id."'  WHERE `bms_id` = '".$image_id."'";
                       $STH = $DBH->prepare($upd_sql);
                       $STH->execute();
                        }
                    //$this->addSolutionItem_others($other_data,$sol_item_id); //comment by ample 06-08-20
                }
            
        if($STH->rowCount() > 0)
		{
			$return = true;
		}

        return $return;

    }


// function getInsertID() 
//     {
//         //return mysql_insert_id($this->conID);
//          return $this->conID->lastInsertId();
//     }
    

    public function deleteSolutionItem($sol_item_id)

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $sql = "UPDATE `tblsolutionitems` SET `sol_item_deleted` = '1' WHERE `sol_item_id` = '".$sol_item_id."'";

        //$this->execute_query($sql);

       $STH = $DBH->prepare($sql);
        $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
    }

    

    public function deleteSolution($sol_id)

    {

       $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "UPDATE `tblsolutions` SET `sol_deleted` = '1' WHERE `sol_id` = '".$sol_id."'";

       $STH = $DBH->prepare($sql);
        $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

    }



    

    public function getSolutionItemTypeOptions($banner_type)

    {

      $my_DBH = new mysqlConnection();
      $DBH = $my_DBH->raw_handle();
      $DBH->beginTransaction();

        $option_str = '';		



        // $data = array('Image' => 'Image' , 'Flash' => 'Flash' , 'Video' => 'Video' , 'Audio' => 'Audio' , 'Pdf' => 'Pdf', 'rss' => 'Rss Feed', 'text' => 'Text');

        //remove some data by ample 15-11-19 as discuss by vikram sir beacue not use or another tbl
         //$data = array( 'Video' => 'Video' , 'Audio' => 'Audio' , 'Sound'=>'Sound', 'Pdf' => 'Pdf', 'rss' => 'Rss Feed', 'text' => 'Text');
        //remove text type by ample 15-05-20
        $data = array( 'Video' => 'Video' , 'Audio' => 'Audio' , 'Sound'=>'Sound', 'Pdf' => 'Pdf', 'rss' => 'Rss Feed');

        foreach($data as $key => $val)

        {

            if($key == $banner_type)

            {

                $sel = 'selected ';

            }

            else

            {

                $sel = '';

            }



            $option_str .= '<option value="'.$key.'" '.$sel.'>'.$val.'</option>';

        }

        return $option_str;

    }

    

    public function getSolutionTriggersOptions($sol_situation_id)

    {

       $my_DBH = new mysqlConnection();
      $DBH = $my_DBH->raw_handle();
      $DBH->beginTransaction();

        $data = array();

        $option_str = '';		



        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY `bms_name` ASC";

        $STH = $DBH->prepare($sql);
        $STH->execute();

       if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['bms_'.$row['bms_id']] = stripslashes($row['bms_name']);

            }

        }

        

        $sql = "SELECT * FROM `tbladdictions` WHERE `status` = '1' ORDER BY `situation` ASC";

	 $STH2 = $DBH->prepare($sql);
         $STH2->execute();

       if($STH2->rowCount() > 0)

        {

            while($row = $STH2->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['adct_'.$row['adct_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tblsleeps` WHERE `status` = '1' ORDER BY `situation` ASC";

	$STH3 = $DBH->prepare($sql);
        $STH3->execute();

       if($STH3->rowCount() > 0)

        {

            while($row = $STH3->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['sleep_'.$row['sleep_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tblgeneralstressors` WHERE `status` = '1' ORDER BY `situation` ASC";

	$STH4 = $DBH->prepare($sql);
        $STH4->execute();

       if($STH4->rowCount() > 0)

        {

            while($row = $STH4->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['gs_'.$row['gs_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tblworkandenvironments` WHERE `status` = '1' ORDER BY `situation` ASC";

	$STH5 = $DBH->prepare($sql);
        $STH5->execute();

       if($STH5->rowCount() > 0)

        {

            while($row = $STH5->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['wae_'.$row['wae_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tblmycommunications` WHERE `status` = '1' ORDER BY `situation` ASC";

	$STH6 = $DBH->prepare($sql);
        $STH6->execute();

       if($STH6->rowCount() > 0)

        {

            while($row = $STH6->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['mc_'.$row['mc_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tblmyrelations` WHERE `status` = '1' ORDER BY `situation` ASC";

	$STH7 = $DBH->prepare($sql);
        $STH7->execute();

       if($STH7->rowCount() > 0)

        {

            while($row = $STH7->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['mr_'.$row['mr_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tblmajorlifeevents` WHERE `status` = '1' ORDER BY `situation` ASC";

	$STH8 = $DBH->prepare($sql);
        $STH8->execute();  

       if($STH8->rowCount() > 0)

        {

            while($row = $STH8->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['mle_'.$row['mle_id']] = stripslashes($row['situation']);

            }

        }

        

        $sql = "SELECT * FROM `tbldailyactivity` ORDER BY `activity` ASC";

       $STH9 = $DBH->prepare($sql);
       $STH9->execute();

       if($STH9->rowCount() > 0)

        {

            while($row = $STH9->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['activity_'.$row['activity_id']] = stripslashes($row['activity']);

            }

        }

        

        $sql = "SELECT * FROM `tbldailymeals` ORDER BY `meal_item` ASC";

        $STH10 = $DBH->prepare($sql);
        $STH10->execute();

       if($STH10->rowCount() > 0)

        {

            while($row = $STH10->fetch(PDO::FETCH_ASSOC)) 

            {

                $data['meal_'.$row['meal_id']] = stripslashes($row['meal_item']);

            }

        }

        

        natcasesort($data);

        

        foreach($data as $key => $val)

        {

            if($key == $sol_situation_id)

            {

                $sel = ' selected ';

            }

            else

            {

                $sel = '';

            }

            $option_str .= '<option value="'.$key.'" '.$sel.'>'.$val.'</option>';

        }

        return $option_str;

    }

    

    public function getSolutionCategoryOptions($fav_cat_id)

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $option_str = '';		



        //$sql = "SELECT * FROM `tblsolutioncategories` WHERE `sol_cat_deleted` = '0' AND `sol_cat_status` = '1'  ORDER BY `sol_cat_title` ASC";

        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_status` = '1' AND `fav_cat_deleted` = '0' AND `fav_cat_type_id` = '2' ORDER BY `fav_cat` ASC";

        //echo $sql;

        $STH = $DBH->prepare($sql);
        $STH->execute();

       if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC))

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

     public function getFavCategoryViveks($fav_cat_type_id,$fav_cat_id,$category_ids)
	{
           $my_DBH = new mysqlConnection();
           $DBH = $my_DBH->raw_handle();
           $DBH->beginTransaction();
            $option_str = '';		
            //echo 'aaa->'.$fav_cat_type_id;
            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('".$fav_cat_type_id."') and tblcustomfavcategory.favcat_id IN('".$fav_cat_id."') and tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
          //echo $sql;
           $STH = $DBH->prepare($sql);
           $STH->execute();
            $option_str .= '<option value="">Select Category</option>';
           if($STH->rowCount() > 0)
            {
               
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {   
                    if($row['favcat_id'] == $category_ids)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }	
                    $cat_name = $row['fav_cat'];
                    $option_str .= '<option value="'.$row['favcat_id'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
                }
            }
            //echo $option_str;
            
            return $option_str;
	}
        

    public function getSolutionCategoryOptionsMultiple($arr_fav_cat_id)

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $option_str = '';		



        //$sql = "SELECT * FROM `tblsolutioncategories` WHERE `sol_cat_deleted` = '0' AND `sol_cat_status` = '1'  ORDER BY `sol_cat_title` ASC";

        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_status` = '1' AND `fav_cat_deleted` = '0' AND `fav_cat_type_id` = '2' ORDER BY `fav_cat` ASC";

        //echo $sql;

        $STH = $DBH->prepare($sql);
        $STH->execute();

       if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC))

            {

                if(in_array($row['fav_cat_id'] ,$arr_fav_cat_id) )

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

    

    public function GetAllSolutionsList($search,$sol_status,$sol_cat_id,$start_date,$sol_situation_id,$added_by_user,$sol_add_date,$banner_type)

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $admin_id = $_SESSION['admin_id'];

        $edit_action_id = '255';

        $delete_action_id = '256';

        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

        if($search == '')

        {

            $str_sql_search = '';

        }

        else

        {

            $str_sql_search = '';

        }

        

        if($sol_status == '')

        {

            $str_sql_status = '';

        }

        else

        {

            $str_sql_status = " AND `sol_status` = '".$sol_status."'";

        }

        

        if($sol_cat_id == '')

        {

            $str_sql_cat = '';

        }

        else

        {

            $str_sql_cat = " AND `sol_cat_id` = '".$sol_cat_id."'";

        }

        

        if($start_date == '')

        {

            $str_sql_date = "";

        }

        else

        {

            $start_date = date('Y-m-d',strtotime($start_date));

            $today_day = date('j',strtotime($start_date));

            $today_date = date('Y-m-d',strtotime($start_date));

            $today_weekday = date('w',strtotime($start_date));

            $today_weekday = $today_weekday + 1;

            $today_month_no = date('n',strtotime($start_date));



            $str_sql_date = " AND ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR "

                    . "(`listing_date_type` = 'days_of_week' AND FIND_IN_SET('".$today_weekday."', days_of_week) ) OR "

                    . "(`listing_date_type` = 'month_wise' AND FIND_IN_SET('".$today_month_no."', months) ) OR "

                    . "(`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR "

                    . "(`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) ";

        }

        

        if($sol_situation_id == '')

        {

            $str_sql_situation = '';

        }

        else

        {

            $temp_sol_arr = explode('_', $sol_situation_id);

            $str_sql_situation = " AND `sol_situation_id` = '".$temp_sol_arr[1]."' AND `sol_situation_type` = '".$temp_sol_arr[0]."' ";

        }

        

        if($added_by_user == '')

        {

            $str_sql_added_by_user = '';

        }   

        else 

        {

            $str_sql_added_by_user = " AND `added_by_user` = '".$added_by_user."'";

        }

        

        if($sol_add_date == '')

        {

            $str_sql_sol_add_date = '';

        }   

        else 

        {

            $sol_add_date = date('Y-m-d',strtotime($sol_add_date));

            $str_sql_sol_add_date = " AND `sol_add_date` = DATE('".$sol_add_date."')";

        }

        

        if($banner_type == '')

        {

            $str_sql_type = '';

        }

        else

        {

            $str_sql_type = " AND `sol_item_id` IN ( SELECT `sol_item_id` FROM `tblsolutionitems` WHERE `banner_type` = '".$banner_type."'  )";

        }

        

        $sql = "SELECT * FROM `tblsolutions` WHERE `sol_deleted` = '0' ".$str_sql_search." ".$str_sql_status." ".$str_sql_cat." ".$str_sql_date." ".$str_sql_situation." ".$str_sql_added_by_user." ".$str_sql_sol_add_date." ".$str_sql_type." ORDER BY sol_add_date DESC";

	//echo '<br>'.$sql;

         $STH = $DBH->prepare($sql);
         $STH->execute();

	$total_records=$STH->rowCount() ;

	$record_per_page=100;

	$scroll=5;

	$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

        $page->set_link_parameter("Class = paging");

        $page->set_qry_string($str="mode=wellness_solutions&search=".urlencode($search).'&sol_status='.$sol_status.'&start_date='.$start_date.'&sol_cat_id='.$sol_cat_id.'&sol_situation_id='.$sol_situation_id);

        //$result=$this->execute_query($page->get_limit_query($sql));
        $STH2 = $DBH->prepare($page->get_limit_query($sql));
        $STH2->execute();
        $output = '';		

       if($STH2->rowCount() > 0)

        {

            if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

            {

                $i = $page->start + 1;

            }

            else

            {

                $i = 1;

            }



            $obj = new Solutions();

            $obj2 = new ProfileCustomization();

            while($row = $STH2->fetch(PDO::FETCH_ASSOC))

            {

                

                if($row['sol_status'] == 1)

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

                    $date_value = $obj2->getDayOfWeekCommaStr($row['days_of_week']);

                    $date_value = str_replace(',', ' , ', $date_value);

                }

                elseif($row['listing_date_type'] == 'month_wise')

                {

                    $date_type = 'Month Wise';

                    $date_value = $obj2->getMonthsCommastr($row['months']);

                    $date_value = str_replace(',', ' , ', $date_value);

                }

                elseif($row['listing_date_type'] == '')

                {

                    $date_type = 'All';

                    $date_value = '';

                }

                

                $situation_id = $row['sol_situation_id'];

                $situation_type = $row['sol_situation_type'];        

                $min_rating = $row['min_rating'];

                $max_rating = $row['max_rating'];

                $situation = $obj2->getKeywordName($situation_id,$situation_type);

                $sol_cat_title = $obj->getSolutionCategoryName($row['sol_cat_id']);

                

                $criteria_id = $row['criteria_id'];

                $criteria = $obj2->getCriteriaName($criteria_id);

                $criteria_scale_type = $row['criteria_scale_type'];

                $criteria_scale_value1 = $row['criteria_scale_value1'];

                $criteria_scale_value2 = $row['criteria_scale_value2'];

                $criteria_scale_value = $obj2->getCriteriaScaleValueStr($criteria_scale_type,$criteria_scale_value1,$criteria_scale_value2);

                

                list($box_title,$banner_type,$box_desc,$banner,$status1,$credit_line,$credit_line_url,$sound_clip_id,$rss_feed_item_id) = $obj->getSolutionItemDetails($row['sol_item_id']);

                

                if($banner_type == 'Image')

                {

                    //$str_item = '<img border="0" src="'.SITE_URL.'/uploads/'.$banner.'" width="50">';

                    $str_item = '<ul class="zoomonhoverul"><li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $banner.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $banner.'" width="50" alt="gallery thumbnail" /></a></li></ul>';

                }

                elseif($banner_type == 'Flash')

                {

                    $str_item = '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="50" HEIGHT="50" id="myMovieName"><PARAM NAME=movie VALUE="'.SITE_URL.'/uploads/'. $banner.'"><PARAM NAME=quality VALUE=high><param name="wmode" value="transparent"><EMBED src="'.SITE_URL.'/uploads/'. $banner.'" quality=high WIDTH="50" HEIGHT="50" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED></OBJECT>';

                }

                elseif($banner_type == 'Video')

                {

                    $str_item = '<iframe width="50" height="50" src="'.$obj->getStressBusterBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';

                }

                elseif($banner_type == 'rss')

                {

                    $str_item = $obj->getRssFeedItemTitle($rss_feed_item_id);

                }

                elseif($banner_type == 'text')

                {

                    $str_item = $box_desc;

                }

                else

                {

                    $str_item = '<a href="'.SITE_URL.'/uploads/'. $banner.'" target="_blank">'.$banner.'</a> ';

                }

                

                $time= strtotime($row['sol_add_date']);

                $time=$time+19800;

                $date = date('d-M-Y h:i A',$time);

                

                if($row['added_by_user'] == 0)

                {

                    $add_by_user = $obj->getUsenameOfAdmin($row['user_id']);

                }

                else

                {

                    $add_by_user = 'User';

                }

                

                $output .= '<tr class="manage-row">';

                $output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

                $output .= '<td height="30" align="center">'.$situation.'</td>';

                $output .= '<td height="30" align="center">'.$sol_cat_title.'</td>';

                $output .= '<td height="30" align="center">'.$min_rating.'</td>';

                $output .= '<td height="30" align="center">'.$max_rating.'</td>';

                $output .= '<td height="30" align="center">'.$criteria.'</td>';

                $output .= '<td height="30" align="center">'.$criteria_scale_value.'</td>';

                $output .= '<td height="30" align="center">'.$date_type.'</td>';

                $output .= '<td height="30" align="center">'.$date_value.'</td>';

                $output .= '<td height="30" align="center">'.$box_title.'</td>';

                $output .= '<td height="30" align="center">'.$banner_type.'</td>';

                $output .= '<td height="30" align="center">'.$str_item.'</td>';

                $output .= '<td height="30" align="center">'.$box_desc.'</td>';

                $output .= '<td height="30" align="center">'.$status.'</td>';

                $output .= '<td height="30" align="center">'.$add_by_user.'</td>';

                $output .= '<td height="30" align="center">'.$date.'</td>';

                $output .= '<td height="30" align="center" nowrap="nowrap">';

                if($edit) {

                $output .= '<a href="index.php?mode=edit_wellness_solution&id='.$row['sol_id'].'" ><img src = "images/edit.gif" border="0"></a>';

                }

                $output .= '</td>';

                $output .= '<td height="30" align="center" nowrap="nowrap">';

                if($delete) {

                $output .= '<a href=\'javascript:fn_confirmdelete("Solution","sql/delwellnesssolution.php?id='.$row['sol_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

                }

                $output .= '</td>';

                $output .= '</tr>';

                $i++;

            }

        }

        else

        {

            $output = '<tr class="manage-row"><td height="30" colspan="18" align="center">NO RECORDS FOUND</td></tr>';

        }

	$page->get_page_nav();

	return $output;

    }

    

    public function getSolutionTriggerName($solution_id,$solution_type)

    {

      $my_DBH = new mysqlConnection();
      $DBH = $my_DBH->raw_handle();
      $DBH->beginTransaction();

        $name = '';

        

        if($solution_type == 'bms')

        {

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$solution_id."' ";

           $STH = $DBH->prepare($sql);
           $STH->execute();

           if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC); 

                $name = stripslashes($row['bms_name']);

            }

        } 

        elseif($solution_type == 'adct')

        {

            $sql = "SELECT * FROM `tbladdictions` WHERE `adct_id` = '".$solution_id."'";

            $STH2 = $DBH->prepare($sql);
            $STH2->execute();

           if($STH2->rowCount() > 0)

            {

                $row = $STH2->fetch(PDO::FETCH_ASSOC); 

                $name = stripslashes($row['situation']);

            }

        }

        elseif($solution_type == 'sleep')

        {

            $sql = "SELECT * FROM `tblsleeps` WHERE `sleep_id` = '".$solution_id."'";

            $STH3 = $DBH->prepare($sql);
            $STH3->execute();

           if($STH3->rowCount() > 0)

            {

                $row = $STH3->fetch(PDO::FETCH_ASSOC); 

                $name = stripslashes($row['situation']);

            }

        }

        elseif($solution_type == 'gs')

        {

            $sql = "SELECT * FROM `tblgeneralstressors` WHERE `gs_id` = '".$solution_id."'";

           $STH4 = $DBH->prepare($sql);
           $STH4->execute();

           if($STH4->rowCount() > 0)

            {

                $row = $STH4->fetch(PDO::FETCH_ASSOC); 

                $name = stripslashes($row['situation']);

            }

        }

        elseif($solution_type == 'wae')

        {

            $sql = "SELECT * FROM `tblworkandenvironments` WHERE `wae_id` = '".$solution_id."'";

           $STH5 = $DBH->prepare($sql);
            $STH5->execute();

           if($STH5->rowCount() > 0)

            {

                $row = $STH5->fetch(PDO::FETCH_ASSOC); 

                $name = stripslashes($row['situation']);

            }

        }

        elseif($solution_type == 'mc')

        {

            $sql = "SELECT * FROM `tblmycommunications` WHERE `mc_id` = '".$solution_id."'";

           $STH6 = $DBH->prepare($sql);
            $STH6->execute();

           if($STH6->rowCount() > 0)

            {

                $row = $STH6->fetch(PDO::FETCH_ASSOC); 

                $name = stripslashes($row['situation']);

            }

        }

        elseif($solution_type == 'mr')

        {

            $sql = "SELECT * FROM `tblmyrelations` WHERE `mr_id` = '".$solution_id."'";

           $STH7 = $DBH->prepare($sql);
           $STH7->execute();

           if($STH7->rowCount() > 0)

            {

                $row = $STH7->fetch(PDO::FETCH_ASSOC); 

                $name = stripslashes($row['situation']);

            }

        }

        elseif($solution_type == 'mle')

        {

            $sql = "SELECT * FROM `tblmajorlifeevents` WHERE `mle_id` = '".$solution_id."'";

            $STH8 = $DBH->prepare($sql);
            $STH8->execute();

           if($STH8->rowCount() > 0)

            {

                $row = $STH8->fetch(PDO::FETCH_ASSOC); 

                $name = stripslashes($row['situation']);

            }

        }

        

        return $name;

    }

    

public function getSolutionCategoryName($fav_cat_id)
{
     $my_DBH = new mysqlConnection();
     $DBH = $my_DBH->raw_handle();
     $DBH->beginTransaction();
     $name = '';
        //$sql = "SELECT * FROM `tblsolutioncategories` WHERE `sol_cat_id` = '".$sol_cat_id."' ";
     $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";

       $STH = $DBH->prepare($sql);
       $STH->execute();

       if($STH->rowCount() > 0)

        {

            $row = $STH->fetch(PDO::FETCH_ASSOC); 

            $name = stripslashes($row['fav_cat']);

        }

        return $name;

    }

    

    public function GetAllSolutionsItemsList($search,$sol_item_status,$banner_type,$user_add_banner,$category_ids,$sol_item_add_date)
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
         $DBH->beginTransaction();

        $admin_id = $_SESSION['admin_id'];

        // $edit_action_id = '255';
        // $delete_action_id = '256';
        //wrong action id so change by ample 15-05-20
        $edit_action_id = '259';
        $delete_action_id = '260';

        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

        if($search == '')

        {

            $str_sql_search = '';

        }

        else

        {

            $str_sql_search = " AND `topic_subject` LIKE '%".$search."%' ";

        }

        

        if($sol_item_status == '')

        {

            $str_sql_status = '';

        }

        else

        {

            $str_sql_status = " AND `sol_item_status` = '".$sol_item_status."'";

        }

        

        if($banner_type == '')

        {

            $str_sql_type = '';

        }

        else

        {

            $str_sql_type = " AND `banner_type` = '".$banner_type."'";

        }

        

        if($user_add_banner == '')

        {

            $str_sql_added_by = '';

        }

        else

        {

            $str_sql_added_by = " AND `user_add_banner` = '".$user_add_banner."'";

        }

        

        if($category_ids == '')

        {

            $str_cat_search = '';

        }

        else

        {

            $str_cat_search = " AND `category_ids` = '".$category_ids."' ";

        }

        

        if($sol_item_add_date == '')

        {

            $str_sql_sol_item_add_date = '';

        }   

        else 

        {

            $sol_item_add_date = date('Y-m-d',strtotime($sol_item_add_date));

            $str_sql_sol_item_add_date = " AND `sol_item_add_date` = DATE('".$sol_item_add_date."')";

        }

        

        $sql = "SELECT * FROM `tblsolutionitems` WHERE `sol_item_deleted` = '0' ".$str_sql_search." ".$str_sql_status." ".$str_sql_type." ".$str_sql_added_by." ".$str_cat_search." ".$str_sql_sol_item_add_date." ORDER BY sol_item_add_date DESC";

	//echo '<br>'.$sql;

        $STH = $DBH->prepare($sql);
        $STH->execute();

	$total_records=$STH->rowCount();

	$record_per_page=100;

	$scroll=5;

	$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

        $page->set_link_parameter("Class = paging");

        $page_mode = $_GET['page'];
//        print_r($page_mode);
                
        $page->set_qry_string($str="mode=wellness_solution_items&sol_item_status=".$sol_item_status."&sol_item_add_date=".$sol_item_add_date."&banner_type".$banner_type."&search=".urlencode($search));

       // $result=$this->execute_query($page->get_limit_query($sql));
        
        $STH2 = $DBH->prepare($page->get_limit_query($sql));
        $STH2->execute();
        $output = '';		

       if($STH2->rowCount() > 0)

        {

            if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

            {

                $i = $page->start + 1;

            }

            else

            {

                $i = 1;

            }

//print_r($i);

            $obj = new Solutions();

            while($row = $STH2->fetch(PDO::FETCH_ASSOC))

            {

                if($row['sol_item_status'] == 1)

                {

                    $status = 'Active'; 

                }

                else

                { 

                    $status = 'Inactive';

                }

                

                $time= strtotime($row['sol_item_add_date']);

                $time=$time+19800;

                $date = date('d-M-Y h:i A',$time);

                

                $banner_type = stripslashes($row['banner_type']);

                $banner = stripslashes($row['sol_box_banner']);

                

                if($banner_type == 'Image')

                {

                    //$str_item = '<img border="0" src="'.SITE_URL.'/uploads/'.$banner.'" width="50">';

                    $str_item = '<ul class="zoomonhoverul"><li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $banner.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $banner.'" width="50" alt="gallery thumbnail" /></a></li></ul>';

                }

                elseif($banner_type == 'Flash')

                {

                    $str_item = '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="50" HEIGHT="50" id="myMovieName"><PARAM NAME=movie VALUE="'.SITE_URL.'/uploads/'. $banner.'"><PARAM NAME=quality VALUE=high><param name="wmode" value="transparent"><EMBED src="'.SITE_URL.'/uploads/'. $banner.'" quality=high WIDTH="50" HEIGHT="50" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED></OBJECT>';

                }

                elseif($banner_type == 'Video')

                {

                    $str_item = '<iframe width="50" height="50" src="'.$obj->getStressBusterBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';

                }

                elseif($banner_type == 'rss')

                {

                    $str_item = $obj->getRssFeedItemTitle($row['rss_feed_item_id']);

                }

                elseif($banner_type == 'text')

                {

                    $str_item = stripslashes($row['sol_box_desc']);

                }

                else

                {

                    $str_item = '<a href="'.SITE_URL.'/uploads/'. $banner.'" target="_blank">'.$banner.'</a> ';

                }

                

                if($row['user_type'] == '1')

                {

                    $added_by = 'Admin'; 

                }
                else if($row['user_type'] == '2')

                {

                    $added_by = 'Practitioner'; 

                }

                else if($row['user_type'] == '3')

                {

                    $added_by = 'User'; 

                }
               
               // echo "<pre>";print_r($row['show_pop']);echo "</pre>";

                $sol_item_cat = array();
                $cat_ids=explode(',', $row['category_ids']);

                if(!empty($cat_ids))
                {
                    foreach ($cat_ids as $key => $value) {
                       $sol_item_cat[] = $obj->getSolutionCategoryName($value);
                    }
                }

                $output .= '<tr class="manage-row">';

                $output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

                $output .= '<td height="30" align="center">'.$row['show_pop'].'</td>';

                $output .= '<td height="30" align="center">'.implode(',', $sol_item_cat).'</td>';

                $output .= '<td height="30" align="center">'.$status.'</td>';

                $output .= '<td height="30" align="center" nowrap="nowrap">';
                
                if($prct_id==0)
                    {
                       $output .= '<a href="index.php?mode=add_profile_customization&customization_id='.$row['sol_item_id'].'&name=wellness_solution_items" ><img src = "images/sidebox_icon_pages.gif" border="0"></a>';
                       $output .= '<td height="30" align="center">';
                       $output .= '</td>';
                    }
                    else
                    {
                     $output .= '<td height="30" align="center">';
                     $output .= '<a href="index.php?mode=edit_profile_customization&id='.$prct_id.'&name=wellness_solution_items" ><img src = "images/sidebox_icon_pages.gif" border="0"></a>';
                     $output .= '</td>';
                       
                    }
                $output .= '<td height="30" align="center">';
                if($edit) {

                $output .= '<a href="index.php?mode=edit_wellness_solution_item&id='.$row['sol_item_id'].'&page='.$page_mode.'" ><img src = "images/edit.gif" border="0"></a>';

                }

                $output .= '</td>';

                $output .= '<td height="30" align="center" nowrap="nowrap">';

                if($delete) {

                $output .= '<a href=\'javascript:fn_confirmdelete("Solution Item","sql/delwellnesssolutionitem.php?id='.$row['sol_item_id'].'&page='.$page_mode.'")\' ><img src = "images/del.gif" border="0" ></a>';

                }

                $output .= '</td>';






                $output .= '<td height="30" align="center">'.stripslashes($row['wellbgn_ref_num']).'</td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['page_name']).'</td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['reference_title']).'</td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['topic_subject']).'</td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['narration']).'</td>';

                // $output .= '<td height="30" align="center">'.stripslashes($row['topic_subject']).'</td>';

                $output .= '<td height="30" align="center">'.$banner_type.'</td>';

                $output .= '<td height="30" align="center">'.$str_item.'</td>';

                $output .= '<td height="30" align="center">'.$added_by.'</td>';

                $output .= '<td height="30" align="center">'.$row['user_name'].'</td>';

                $output .= '<td height="30" align="center">'.$date.'</td>';

                // $output .= '<td height="30" align="center" >'.stripslashes($row['sol_box_desc']).'</td>';



               



                $output .= '</tr>';

                $i++;

            }

        }

        else

        {

            $output = '<tr class="manage-row"><td height="30" colspan="11" align="center">NO RECORDS FOUND</td></tr>';

        }

	$page->get_page_nav();

	return $output;

    }

    

    public function GetAllMWSUserArea()

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();



        $admin_id = $_SESSION['admin_id'];



        $edit_action_id = '263';



        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);



        $sql = "SELECT * FROM `tbluserarea` WHERE `userarea_type` = 'MWS' ORDER BY `userarea_add_date`  DESC";

       $STH = $DBH->prepare($sql);
       $STH->execute();

        $total_records=$STH->rowCount() ;

        $record_per_page=100;

        $scroll=5;

        $page=new Page(); 

        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

        $page->set_link_parameter("Class = paging");

        $page->set_qry_string($str="mode=wellness_solution_user_area");

        //$result=$this->execute_query($page->get_limit_query($sql));
      $STH2 = $DBH->prepare($page->get_limit_query($sql));
      $STH2->execute();
        $output = '';		



       if($STH2->rowCount() > 0)

        {

            if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

            {

                $i = $page->start + 1;

            }

            else

            {

                $i = 1;

            }



            while($row = $STH2->fetch(PDO::FETCH_ASSOC))

            {

                if($row['status'] == 1)

                {

                    $status = 'Active'; 

                }

                else

                { 

                    $status = 'Inactive';

                }



                $output .= '<tr class="manage-row">';

                $output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['box_title']).'</td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['box_desc']).'</td>';

                $output .= '<td height="30" align="center" nowrap="nowrap">';

                if($edit) {

                $output .= '<a href="index.php?mode=edit_wellness_solution_user_area&id='.$row['userarea_id'].'" ><img src = "images/edit.gif" border="0"></a>';

                }

                $output .= '</td>';

                $output .= '</tr>';

                $i++;

            }

        }

        else

        {

            $output = '<tr class="manage-row"><td height="30" colspan="4" align="center">NO RECORDS FOUND</td></tr>';

        }

        $page->get_page_nav();

        return $output;

    }

    

    public function updateMWSUserArea($id,$box_title,$box_desc)

    {

       $my_DBH = new mysqlConnection();
       $DBH = $my_DBH->raw_handle();
       $DBH->beginTransaction();
	$return=false;			

        $sql = "UPDATE `tbluserarea` SET `box_title` = '".addslashes($box_title)."' ,`box_desc` = '".addslashes($box_desc)."',`status` = '1'  WHERE `userarea_id` = '".$id."'";

        //echo $sql;

        
	      $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
		
		

    }

    

    public function getUserarea($id,$userarea_type)

    {

       $my_DBH = new mysqlConnection();
       $DBH = $my_DBH->raw_handle();
       $DBH->beginTransaction();

        $step = '';

        $box_title = '';

        $box_desc = '';



        $sql = "SELECT * FROM `tbluserarea` WHERE `userarea_id` = '".$id."' AND `userarea_type` = '".$userarea_type."'";

       
      $STH = $DBH->prepare($sql);
        $STH->execute();
		

       if($STH->rowCount() > 0)

        {

            $row = $STH->fetch(PDO::FETCH_ASSOC);

            $step = stripslashes($row['step']);

            $box_title = stripslashes($row['box_title']);

            $box_desc = stripslashes($row['box_desc']);

        }

        return array($step,$box_title,$box_desc);

    }

    

    public function GetAllMWSBGMusic()

    {

       $my_DBH = new mysqlConnection();
       $DBH = $my_DBH->raw_handle();
       $DBH->beginTransaction();



        $admin_id = $_SESSION['admin_id'];



        $edit_action_id = '266';

        $delete_action_id = '265';

        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);



        $sql = "SELECT * FROM `tblsolutionbgmusic` WHERE `deleted` = '0' ORDER BY `music_add_date` DESC";

        $STH = $DBH->prepare($sql);
         $STH->execute();

        $total_records=$STH->rowCount() ;

        $record_per_page=100;

        $scroll=5;

        $page=new Page(); 

        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

        $page->set_link_parameter("Class = paging");

        $page->set_qry_string($str="mode=wellness_solution_bg_music");

        //$result=$this->execute_query($page->get_limit_query($sql));
        $STH2 = $DBH->prepare($page->get_limit_query($sql));
        $STH2->execute();
        $output = '';		



       if($STH2->rowCount() > 0)

        {

            if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

            {

                $i = $page->start + 1;

            }

            else

            {

                $i = 1;

            }



            while($row = $STH2->fetch(PDO::FETCH_ASSOC))

            {

                if($row['status'] == 1)

                {

                    $status = 'Active'; 

                }

                else

                { 

                    $status = 'Inactive';

                }

                

                $time= strtotime($row['music_add_date']);

                $time=$time+19800;

                $date = date('d-M-Y h:i A',$time);



                $output .= '<tr class="manage-row">';

                $output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['music']).'</td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['day']).'</td>';

                $output .= '<td height="30" align="center">'.$status.'</td>';

                $output .= '<td height="30" align="center">'.$date.'</td>';

                $output .= '<td height="30" align="center" nowrap="nowrap">';

                if($edit) {

                $output .= '<a href="index.php?mode=edit_wellness_solution_bg_music&id='.$row['music_id'].'" ><img src = "images/edit.gif" border="0"></a>';

                }

                $output .= '</td>';

                $output .= '<td height="30" align="center" nowrap="nowrap">';

                if($delete) {

                $output .= '<a href=\'javascript:fn_confirmdelete("Music","sql/delwellnesssolutionbgmusic.php?id='.$row['music_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

                }

                $output .= '</td>';

                $output .= '</tr>';

                $i++;

            }

        }

        else

        {

            $output = '<tr class="manage-row"><td height="30" colspan="7" align="center">NO RECORDS FOUND</td></tr>';

        }

        $page->get_page_nav();

        return $output;

    }

    

    public function addMWSBGMusic($step,$music,$day,$credit,$credit_url)

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
       $DBH->beginTransaction();
        $return=false;
        $ins_sql = "INSERT INTO `tblsolutionbgmusic`(`step`,`music`,`day`,`credit`,`credit_url`,`status`) VALUES ('".addslashes($step)."','".addslashes($music)."','".addslashes($day)."','".addslashes($credit)."','".addslashes($credit_url)."','1')";

        
	$STH = $DBH->prepare($ins_sql);
        $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

    }

    

    public function deleteMWSBGMusic($music_id)

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "UPDATE `tblsolutionbgmusic` SET `deleted` = '1' WHERE `music_id` = '".$music_id."'";

       $STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

    }



    public function getMWSBGMusicDetails($music_id)

    {

         $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

		

        $step = '';

        $music = '';

        $day = '';

        $credit = '';

        $credit_url = '';

        $status = '';



        $sql = "SELECT * FROM `tblsolutionbgmusic` WHERE `music_id` = '".$music_id."'";

        $STH = $DBH->prepare($sql);
        $STH->execute();

       if($STH->rowCount() > 0)

        {

            $row = $STH->fetch(PDO::FETCH_ASSOC);

            $step = stripslashes($row['step']);

            $music = stripslashes($row['music']);

            $day= stripslashes($row['day']);

            $credit= stripslashes($row['credit']);

            $credit_url= stripslashes($row['credit_url']);

            $status = stripslashes($row['status']);

        }

        return array($step,$music,$day,$credit,$credit_url,$status);

    }



    public function updateMWSBGMusic($step,$music,$day,$credit,$credit_url,$status,$music_id) 

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "UPDATE `tblsolutionbgmusic` SET `step` = '".addslashes($step)."' , `music` = '".addslashes($music)."' ,`day` = '".addslashes($day)."' ,`credit` = '".addslashes($credit)."' ,`credit_url` = '".addslashes($credit_url)."' ,`status` = '".addslashes($status)."'    WHERE `music_id` = '".$music_id."'";

        //echo $sql;

         $STH = $DBH->prepare($sql);
        $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

    }



    public function get_user_name($user_id)

    {

         $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $user_name = '';

        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";

        $STH = $DBH->prepare($sql);
       $STH->execute();

       if($STH->rowCount() > 0)

        {

            $row = $STH->fetch(PDO::FETCH_ASSOC);

            $name = stripslashes($row['name']);

        }

        return $name;

    }    
     public function getSolItemIdVivek($sol_item_id)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
           $DBH->beginTransaction();

            $fav_cat_type = '';

            //$sql = "SELECT * FROM `tblfavcategorytypegetFavCatDropdownValueVivek` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
            $sql = "SELECT * FROM `tblsolutionitems` WHERE `prct_id` = '".$sol_item_id."' ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
           if($STH->rowCount() > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $fav_cat_type = stripslashes($row['prct_id']);
            }
            return $fav_cat_type;
	}
        
 public function getFavCatDropdownValueVivek($page_name)
	{
		 $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
               $DBH->beginTransaction();
				
//	old	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."'";
                $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE  page_name ='".$page_name."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount()  > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
                      
			$prof_cat1_value = stripslashes($row['prof_cat1']);
			$prof_cat2_value = stripslashes($row['prof_cat2']);
			$prof_cat3_value = stripslashes($row['prof_cat3']);
			$prof_cat4_value = stripslashes($row['prof_cat4']);
			$prof_cat5_value = stripslashes($row['prof_cat5']);
			$prof_cat6_value = stripslashes($row['prof_cat6']);
			$prof_cat7_value = stripslashes($row['prof_cat7']);
			$prof_cat8_value = stripslashes($row['prof_cat8']);
			$prof_cat9_value = stripslashes($row['prof_cat9']);
			$prof_cat10_value = stripslashes($row['prof_cat10']);
                        
                        $sub_cat1_value = stripslashes($row['sub_cat1']);
     
                       $sub_cat2_value = stripslashes($row['sub_cat2']);
    
                       $sub_cat3_value = stripslashes($row['sub_cat3']);
    
                       $sub_cat4_value = stripslashes($row['sub_cat4']);
     
                       $sub_cat5_value = stripslashes($row['sub_cat5']);
    
                       $sub_cat6_value = stripslashes($row['sub_cat6']);
    
                       $sub_cat7_value = stripslashes($row['sub_cat7']);
                       
                       $sub_cat8_value = stripslashes($row['sub_cat8']);
                       
                       $sub_cat9_value = stripslashes($row['sub_cat9']);
    
                       $sub_cat10_value = stripslashes($row['sub_cat10']);
			
		}
		return array($sub_cat1_value,$sub_cat2_value,$sub_cat3_value,$sub_cat4_value,$sub_cat5_value,$sub_cat6_value,$sub_cat7_value,$sub_cat8_value,$sub_cat9_value,$sub_cat10_value,$prof_cat1_value,$prof_cat2_value,$prof_cat3_value,$prof_cat4_value,$prof_cat5_value,$prof_cat6_value,$prof_cat7_value,$prof_cat8_value,$prof_cat9_value,$prof_cat10_value);
	}
        
public function getSymtumsCustomCategoryAllDataViveks($fav_cat_type_id)
	{
           $my_DBH = new mysqlConnection();
           $DBH = $my_DBH->raw_handle();
           $DBH->beginTransaction();
            $option_str = array();		
           $sql = "SELECT * FROM `tblsymtumscustomcategory` WHERE bmsid ='".$fav_cat_type_id."' ";
           $STH = $DBH->prepare($sql);
           $STH->execute();
           if($STH->rowCount() > 0)
            {
               
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {   
                   $option_str[] = $row;
                }
            }
            //echo $option_str;
            
            return $option_str;
	}
             
public function getSymptomKeywordAllDataViveks($fav_cat_type_id)
	{
            $my_DBH = new mysqlConnection();
           $DBH = $my_DBH->raw_handle();
           $DBH->beginTransaction();
            $option_str = array();		
           $sql = "SELECT * FROM `tbl_symptom_keyword` WHERE symptom_id = '".$fav_cat_type_id."'";
            $STH = $DBH->prepare($sql);
           $STH->execute();
           if($STH->rowCount() > 0)
            {
               
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {   
                   $option_str[] = $row;
                }
            }
            
            return $option_str;
	}
        
     public function getSubCatNameByProfileCatIdFromFavCatTableVivek($fav_cat_type_id,$sub_cat_id_data)
	{
           $my_DBH = new mysqlConnection();
           $DBH = $my_DBH->raw_handle();
           $DBH->beginTransaction();
            $return = array();
            
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('".$fav_cat_type_id."') and tblfavcategory.fav_cat_id IN('".$sub_cat_id_data."') ";
           $STH = $DBH->prepare($sql);
           $STH->execute();
           if($STH->rowCount() > 0)
            {
                    while($row = $STH->fetch(PDO::FETCH_ASSOC))
                    {
                    $return[] = $row['fav_cat'];
                    }
            }
            return $return;
	}
   

   public function getKeywordIdformFavCatTableVivek($fav_cat_id)
	{
           $my_DBH = new mysqlConnection();
           $DBH = $my_DBH->raw_handle();
           $DBH->beginTransaction();
            $kw_name = array();		
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` IN('".$fav_cat_id."')";
            $STH = $DBH->prepare($sql);
           $STH->execute();
           if($STH->rowCount() > 0)
            {
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                   $kw_name[] = $row['fav_cat'];
                }
            }
            return $kw_name;
            
        } 
        
     public function addWellnessSolutionKeywordData($tdata_cat)

    {
          $my_DBH = new mysqlConnection();
           $DBH = $my_DBH->raw_handle();
           $DBH->beginTransaction();
           $return=false;
        $ins_sql = "INSERT INTO `tbl_wellness_solution_item_keyword`(`page_name`,`sol_item_id`,`keyword_name`,`selected_keyword`) VALUES ('".$tdata_cat['page_name']."','".$tdata_cat['sol_item_id']."','".$tdata_cat['keyword_name']."','".$tdata_cat['selected_keyword']."')";

        $STH = $DBH->prepare($ins_sql);
           $STH->execute();
       if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

    }
    
        
public function getFavCategoryAllDataViveks($fav_cat_type_id)
	{
             $my_DBH = new mysqlConnection();
           $DBH = $my_DBH->raw_handle();
           $DBH->beginTransaction();
            $option_str = array();		
            $sql = "SELECT * FROM `tblcustomfavcategory` WHERE favcat_id ='".$fav_cat_type_id."' ";
            $STH = $DBH->prepare($sql);
           $STH->execute();
           if($STH->rowCount() > 0)
            {
               
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {   
                   $option_str[] = $row;
                }
            }
            //echo $option_str;
            
            return $option_str;
	}
             
public function getFavCatKeywordAllDataViveks($fav_cat_type_id)
	{
            $my_DBH = new mysqlConnection();
           $DBH = $my_DBH->raw_handle();
           $DBH->beginTransaction();
            $option_str = array();		
           $sql = "SELECT * FROM `tblfavcategory` WHERE fav_cat_id = '".$fav_cat_type_id."'";
            $STH = $DBH->prepare($sql);
            $STH->execute();
           if($STH->rowCount() > 0)
            {
               
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {   
                   $option_str[] = $row;
                }
            }
            
            return $option_str;
	}
        
public function getKeywordDataByPageNameAndIdDetails($sol_item_id,$page_name_data_implode)

  {
            $my_DBH = new mysqlConnection();
           $DBH = $my_DBH->raw_handle();
           $DBH->beginTransaction();
            $option_str = array();		
            $sql = "SELECT * FROM `tbl_wellness_solution_item_keyword` WHERE `sol_item_id` = '".$sol_item_id."' and `page_name` IN ('".$page_name_data_implode."')";
           $STH = $DBH->prepare($sql);
            $STH->execute();
           if($STH->rowCount() > 0)
            {
               
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {   
                   $option_str[] = $row;
                }
            }
            
            return $option_str;
	}

    //add by ample 18-05-20
     public function addSolutionItem_others($data,$sol_item_id)

    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $return = false;

               $ins_sql = "INSERT INTO `tblsolutionitems_others`(`sol_item_id`,`social_media`,`social_media_heading`,`wish_list`,`wish_list_heading`,`add_to_cart`,`add_to_cart_heading`,`add_to_fav`,`add_to_fav_heading`,`bookmark`,`bookmark_heading`,`rating`,`rating_heading`) VALUES ('".$sol_item_id."','".$data['social_media']."','".addslashes($data['social_media_heading'])."','".$data['wish_list']."','".addslashes($data['wish_list_heading'])."','".$data['add_to_cart']."','".addslashes($data['add_to_cart_heading'])."','".$data['add_to_fav']."','".addslashes($data['add_to_fav_heading'])."','".$data['bookmark']."','".addslashes($data['bookmark_heading'])."','".$data['rating']."','".addslashes($data['rating_heading'])."')";

                $STH = $DBH->prepare($ins_sql);
                $STH->execute();

                //$item_id = $DBH->lastInsertId();
            
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;

    }

    //add by ample 18-05-20
    public function getSolutionItemDetails_others($sol_item_id)

    {
        $data=array();
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $sql = "SELECT * FROM `tblsolutionitems_others` WHERE `sol_item_id` = '".$sol_item_id."' ";

       $STH = $DBH->prepare($sql);
       $STH->execute();

       if($STH->rowCount() > 0)

        {

            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data=$row;
        }
        return $data;

    }

    //add by ample 18-05-20
    public function updateSolutionItem_others($data,$sol_item_id)

    {

       $my_DBH = new mysqlConnection();
       $DBH = $my_DBH->raw_handle();
       $DBH->beginTransaction();
       $return=false;
        $sql = "UPDATE `tblsolutionitems_others` SET "

                    . "`social_media` = '".$data['social_media']."',"
                    . "`social_media_heading` = '".addslashes($data['social_media_heading'])."',"
                    . "`wish_list` = '".$data['wish_list']."',"
                    . "`wish_list_heading` = '".addslashes($data['wish_list_heading'])."',"
                    . "`add_to_cart` = '".$data['add_to_cart']."',"
                    . "`add_to_cart_heading` = '".addslashes($data['add_to_cart_heading'])."',"
                    . "`add_to_fav` = '".$data['add_to_fav']."',"
                    . "`add_to_fav_heading` = '".addslashes($data['add_to_fav_heading'])."',"
                    . "`bookmark` = '".$data['bookmark']."',"
                    . "`bookmark_heading` = '".addslashes($data['bookmark_heading'])."',"
                    . "`rating` = '".$data['rating']."',"
                    . "`rating_heading` = '".addslashes($data['rating_heading'])."'"

                . "WHERE `sol_item_id` = '".$sol_item_id."'";

        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
                $return = true;
        }
                
        return $return;
    }

    public function getManageFavCatDropdownDataOption($id="",$sel_ids="")
    {   
        $html = '';
        $data=$this->getManageFavCatDropdown($id);
        if(!empty($data))
        {
            $data['subcat']='';
            for ($i=0; $i < 10; $i++) { 
                if(!empty($data['sub_cat'.$i]))
                {

                    $data['subcat']=$data['subcat'].','.$data['sub_cat'.$i];
                }
                $data['subcat'] = trim($data['subcat'],",");
            }
            $newData=$this->GetCategoryNameByid($data['subcat']);
            if(!empty($newData))
            {   
                if(!empty($sel_ids))
                {
                    $sel_id=explode(',', $sel_ids);
                }
                $html.='<div style="width:200px;height:150px;float:left;overflow:scroll;">  <ul style="list-style:none;padding:0px;margin:0px;">';
                 foreach ($newData as $key => $value) {
                    $sel="";
                    if (is_array($sel_id) && in_array($value["activity_id"], $sel_id)) 
                      {
                        $sel="checked";
                      }

                        $html.='<li style="padding:0px;width:300px;float:left;"><input type="checkbox" name="category_id[]" value="'.$value["activity_id"].'" '.$sel.' >&nbsp;<strong>' . $value["activity_name"] .' </strong></li>';
                 }
                $html.="</ul></div>";
            }
        }
        return $html;  
    }
    //add by ample 03-03-20
    public function getManageFavCatDropdown($id="")
    {
        $DBH = new mysqlConnection();
        $data = array();
        $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '" . $id . "' LIMIT 1";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
        }
        return $data;
    }
    public function GetCategoryNameByid($symtum_cat) {
        $DBH = new mysqlConnection();
        $option_str = array();
        $sql = "SELECT * FROM `tblfavcategory` WHERE  fav_cat_id IN($symtum_cat) ORDER BY `fav_cat` ASC";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data = array();
                $data['activity_name'] = strip_tags($row['fav_cat']);
                $data['activity_id'] = $row['fav_cat_id'];
                $option_str[] = $data;
            }
        }
        return $option_str;
    }
}

?>