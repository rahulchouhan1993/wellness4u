<?php
class commonFrontclass  {
    function __construct() {
    }
    //added by ample 12-08-20
    public function added_page_log_data($data)
    {   
        $DBH = new DatabaseHandler();
        $return = false;
        $sql = "INSERT INTO `tblpagelogs` (`visitor_id`,`visitor_type`,`page_id`,`ip_address`,`visit_date`,`report_id`,`pg_log_status`) VALUES (".$data['visitor_id'].",'".$data['visitor_type']."',".$data['page_id'].",'".$data['ip_address']."','".$data['visit_date']."',".$data['report_id'].",".$data['pg_log_status'].")";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    //added by ample
    public function check_user_subcription_report_status($page_id,$report_id='1')
    {
        $user_id = $_SESSION['user_id'];
        $user_data=$this->getUser_planInfo($user_id);
        $plan_id=$user_data['up_id'];
        $up_start_date=$user_data['uup_start_date'];
        $up_end_date=$user_data['uup_end_date'];
        $is_up_default=$user_data['is_up_default'];
        $count=0;
        $access=0;
        if(!empty($plan_id) && $plan_id!=0)
        {

            $plan_data=$this->get_plan_report_feature_info($plan_id,$report_id);
            $plan_tbl=$this->get_page_table_setting($page_id);


            if(!empty($plan_data) && !empty($plan_tbl))
            {

  
                    if(!empty($plan_data['upc_value']))
                    {   
                       $count=$this->getTotalEntriesOfPageModule_report($plan_tbl,$user_id,$up_start_date,$up_end_date,$is_up_default,$report_id);
                        if($count>$plan_data['upc_value'])
                        {
                            $access=0;
                        }
                        else
                        {
                            $access=1;
                        }
                    }
                    else
                    {
                        $access=1;
                    }
                   
                
            }
        }
        return $access;
    }
    public function get_plan_report_feature_info($plan_id,$report_id) {

        $DBH = new DatabaseHandler();
        $data = array();
        $sql = "SELECT * FROM `tbluserplandetails` WHERE `upd_status` = '1' AND `upd_deleted` = '0' AND `up_id` = '".$plan_id."' AND `upc_id` = '".$report_id."' AND `upa_value` = '1' AND `is_report_data`='1' LIMIT 1";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row= $STH->fetch(PDO::FETCH_ASSOC);
            $data= $row;
        }
        return $data;
    }
    public function getTotalEntriesOfPageModule_report($module,$user_id,$up_start_date,$up_end_date,$is_up_default,$report_id) {

        $DBH = new DatabaseHandler();
        $value = '0';
        $str_date="";
        if($module['table_link']=='tblpagelogs')
        {
            $str_user_id = " visitor_id = '" . $user_id . "' AND report_id = '" . $report_id . "'";
        }
        else
        {
          $str_user_id = " user_id = '" . $user_id . "' ";  
        }
        if($is_up_default==0)
        {
            $str_date=" AND (".$module['table_column']." between '".$up_start_date."' and '".$up_end_date."')";
        }

        $str_condition1='';
        $str_condition2='';
        $str_condition3='';
        
        if($module['table_link'] && $module['table_column'])
        {   

            if($module['column1'] && $module['value1'])
            {
                $str_condition1=" AND ".$module['column1']." = '" . $module['value1'] . "' ";
            }
            if($module['column2'] && $module['value2'])
            {
                $str_condition2=" AND ".$module['column2']." = '" . $module['value2'] . "' ";
            }
            if($module['column3'] && $module['value3'])
            {
                $str_condition3=" AND ".$module['column3']." = '" . $module['value3'] . "' ";
            } 

            $sql = "SELECT ".$module['table_column']." FROM ".$module['table_link']." WHERE " . $str_user_id . " " . $str_condition1 . " " . $str_condition2 . " " . $str_condition3 . " " . $str_date . " ";
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                $value = $STH->rowCount();
            }
        }
        return $value;
    }
    public function get_page_table_setting($page_id) {

        $DBH = new DatabaseHandler();
        $data = array();
        $sql = "SELECT * FROM `tblpagesetting` WHERE `page_id` = '".$page_id."' LIMIT 1";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row= $STH->fetch(PDO::FETCH_ASSOC);
            $data= $row;
        }
        return $data;
    }
    public function getUser_planInfo($user_id) {
        $DBH = new DatabaseHandler();
        $data = array();
        $sql = "SELECT up_id,is_up_default,uup_status,uup_start_date,uup_end_date FROM `tblusers` WHERE `user_id` = '" . $user_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $data = $STH->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    //update date 11/12/20
    public function getRewardPointsSchemes() {
        $DBH = new DatabaseHandler();
        $today=date('Y-m-d');
        $data = array();        
        $sql = "SELECT r.*,p.page_name FROM `tblrewardpoints` r LEFT JOIN tblrewardmodules rm ON r.reward_point_module_id=rm.reward_module_id LEFT JOIN tblpages p ON rm.page_id=p.page_id WHERE r.reward_point_deleted = '0' AND r.reward_point_status = '1'  AND ((r.reward_point_date <= '".$today."' AND r.event_close_date >= '".$today."') OR (r.reward_point_date <= '".$today."' AND r.event_close_date = '0000-00-00')) ORDER BY p.page_name ASC";
         $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
            }
      
        return $data;
    }
    //update date 11-12-20
    public function getRewardBonusSchemes() {
        $DBH = new DatabaseHandler();
        $today=date('Y-m-d');
        $data = array();        
        $sql = "SELECT r.*,p.page_name FROM `tblrewardbonus` r LEFT JOIN tblrewardmodules rm ON r.reward_bonus_module_id=rm.reward_module_id LEFT JOIN tblpages p ON rm.page_id=p.page_id WHERE r.reward_bonus_deleted = '0' AND r.reward_bonus_status = '1'  AND ((r.reward_bonus_date <= '".$today."' AND r.event_close_date >= '".$today."') OR (r.reward_bonus_date <= '".$today."' AND r.event_close_date = '0000-00-00')) ORDER BY p.page_name ASC";
         $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
            }
      
        return $data;
    }
    public function getFavCategoryName($fav_cat_id) {
        $DBH = new DatabaseHandler();
        $fav_cat_type = '';
        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '" . $fav_cat_id . "' ";
        //$this->execute_query($sql);
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $fav_cat_type = stripslashes($row['fav_cat']);
        }
        return $fav_cat_type;
    }
    //add by ample 09-11-20
    public function get_reward_module_name($reward_module_id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();

        $sql = "SELECT p.page_name FROM `tblrewardmodules` rm LEFT JOIN tblpages p  ON rm.page_id=p.page_id WHERE  rm.reward_module_id=".$reward_module_id." AND rm.reward_module_deleted=0 AND rm.reward_module_status=1";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data= $row['page_name'];
            
        }
        return $data;     
    }
    public function getUserDetails($user_id) {
        $DBH = new DatabaseHandler();
        $data = array();
        // $sql = "SELECT * FROM `tblusers` WHERE (`email` = '".$contact."' || `mobile` = '".$contact."') ";
        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '" . $user_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $data = $STH->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    //add by ample 29-12-20
    public function getThemes_resetMood($page_id="")
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $data1 =array();
        $data2 =array();

        $today=date('Y-m-d');
        $month = date('n', strtotime($today));
        $week = date('w', strtotime($today))+1;
        $day = date('j', strtotime($today));

        $sql = "SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND icons_type_id='357' AND (redirect='icon' OR redirect IS NULL) AND (publish_date_type='' OR publish_date_type IS NULL ) AND (state_id=0 OR state_id IS NULL)"; 
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND icons_type_id='357' AND redirect='icon' AND publish_date_type='single_date' AND publish_single_date = '".$today."' AND (state_id=0 OR state_id IS NULL)";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND icons_type_id='357' AND redirect='icon' AND publish_date_type='date_range' AND (publish_start_date <= '".$today."' AND publish_end_date >= '".$today."') AND (state_id=0 OR state_id IS NULL)";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id  WHERE status=1 AND deleted=0 AND icons_type_id='357' AND redirect='icon' AND publish_date_type='month_wise' AND publish_month_wise regexp '[[:<:]]".$month."[[:>:]]' AND (state_id=0 OR state_id IS NULL)";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND icons_type_id='357' AND redirect='icon' AND publish_date_type='days_of_week' AND publish_days_of_week regexp '[[:<:]]".$week."[[:>:]]' AND (state_id=0 OR state_id IS NULL)";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND icons_type_id='357' AND redirect='icon' AND publish_date_type='days_of_month' AND publish_days_of_month regexp '[[:<:]]".$day."[[:>:]]' AND (state_id=0 OR state_id IS NULL)";
        $sql.=" ORDER BY order_no ASC";
        //echo $sql; die('-ss');
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 
           {
                $data1[]= $row;
            }
            
        }

        $user_id = $_SESSION['user_id'];
        if(!empty($user_id))
        {  
            $data2=$this->getThemes_resetMood_OnLocation($user_id);
        }

        $data=array_merge($data1,$data2);
        return $data; 
    }
    //add by ample 29-12-20
    function getThemes_resetMood_OnLocation($user_id)
    {   
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();

        $user_info=$this->getUserDetails($user_id);

        $today=date('Y-m-d');
        $month = date('n', strtotime($today));
        $week = date('w', strtotime($today))+1;
        $day = date('j', strtotime($today));

        $sql = "SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND icons_type_id='357' AND redirect='icon' AND (publish_date_type='' OR publish_date_type IS NULL ) AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))"; 
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND icons_type_id='357' AND redirect='icon' AND publish_date_type='single_date' AND publish_single_date = '".$today."' AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND icons_type_id='357' AND redirect='icon' AND publish_date_type='date_range' AND (publish_start_date <= '".$today."' AND publish_end_date >= '".$today."') AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND icons_type_id='357' AND redirect='icon' AND publish_date_type='month_wise' AND publish_month_wise regexp '[[:<:]]".$month."[[:>:]]' AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND icons_type_id='357' AND redirect='icon' AND publish_date_type='days_of_week' AND publish_days_of_week regexp '[[:<:]]".$week."[[:>:]]' AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND icons_type_id='357' AND redirect='icon' AND publish_date_type='days_of_month' AND publish_days_of_month regexp '[[:<:]]".$day."[[:>:]]' AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.=" ORDER BY order_no ASC";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 
           {
                $data[]= $row;
            }
            
        }
        return $data;
    }
     //add by ample 29-12-20
    public function getMusic_resetMood($page_id="")
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $data1 =array();
        $data2 =array();

        $today=date('Y-m-d');
        $month = date('n', strtotime($today));
        $week = date('w', strtotime($today))+1;
        $day = date('j', strtotime($today));

        $sql = "SELECT DISTINCT sol_item_id,tbl.* FROM `tblsolutionitems` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.sol_item_id=tcs.redirect_id WHERE sol_item_status=1 AND sol_item_deleted=0 AND (banner_type='Audio' OR banner_type='Sound') AND (redirect='wsi-wsi' OR redirect IS NULL) AND (publish_date_type='' OR publish_date_type IS NULL ) AND (state_id=0 OR state_id IS NULL)"; 
        $sql.= " UNION SELECT DISTINCT sol_item_id,tbl.* FROM `tblsolutionitems` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.sol_item_id=tcs.redirect_id WHERE sol_item_status=1 AND sol_item_deleted=0 AND (banner_type='Audio' OR banner_type='Sound') AND redirect='wsi-wsi' AND publish_date_type='single_date' AND publish_single_date = '".$today."' AND (state_id=0 OR state_id IS NULL)";
        $sql.= " UNION SELECT DISTINCT sol_item_id,tbl.* FROM `tblsolutionitems` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.sol_item_id=tcs.redirect_id WHERE sol_item_status=1 AND sol_item_deleted=0 AND (banner_type='Audio' OR banner_type='Sound') AND redirect='wsi-wsi' AND publish_date_type='date_range' AND (publish_start_date <= '".$today."' AND publish_end_date >= '".$today."') AND (state_id=0 OR state_id IS NULL)";
        $sql.= " UNION SELECT DISTINCT sol_item_id,tbl.* FROM `tblsolutionitems` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.sol_item_id=tcs.redirect_id  WHERE sol_item_status=1 AND sol_item_deleted=0 AND (banner_type='Audio' OR banner_type='Sound') AND redirect='wsi-wsi' AND publish_date_type='month_wise' AND publish_month_wise regexp '[[:<:]]".$month."[[:>:]]' AND (state_id=0 OR state_id IS NULL)";
        $sql.= " UNION SELECT DISTINCT sol_item_id,tbl.* FROM `tblsolutionitems` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.sol_item_id=tcs.redirect_id WHERE sol_item_status=1 AND sol_item_deleted=0 AND (banner_type='Audio' OR banner_type='Sound') AND redirect='wsi-wsi' AND publish_date_type='days_of_week' AND publish_days_of_week regexp '[[:<:]]".$week."[[:>:]]' AND (state_id=0 OR state_id IS NULL)";
        $sql.= " UNION SELECT DISTINCT sol_item_id,tbl.* FROM `tblsolutionitems` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.sol_item_id=tcs.redirect_id WHERE sol_item_status=1 AND sol_item_deleted=0 AND (banner_type='Audio' OR banner_type='Sound') AND redirect='wsi-wsi' AND publish_date_type='days_of_month' AND publish_days_of_month regexp '[[:<:]]".$day."[[:>:]]' AND (state_id=0 OR state_id IS NULL)";
        $sql.=" ORDER BY order_show ASC";
        //echo $sql; die('-ss');
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 
           {
                $data1[]= $row;
            }
            
        }

        $user_id = $_SESSION['user_id'];
        if(!empty($user_id))
        {  
            $data2=$this->getThemes_resetMood_OnLocation($user_id);
        }

        $data=array_merge($data1,$data2);
        return $data; 
    }
    //add by ample 29-12-20
    function getMusic_resetMood_OnLocation($user_id)
    {   
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();

        $user_info=$this->getUserDetails($user_id);

        $today=date('Y-m-d');
        $month = date('n', strtotime($today));
        $week = date('w', strtotime($today))+1;
        $day = date('j', strtotime($today));

        $sql = "SELECT DISTINCT sol_item_id,tbl.* FROM `tblsolutionitems` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.sol_item_id=tcs.redirect_id WHERE sol_item_status=1 AND sol_item_deleted=0 AND (banner_type='Audio' OR banner_type='Sound') AND redirect='wsi-wsi' AND (publish_date_type='' OR publish_date_type IS NULL ) AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))"; 
        $sql.= " UNION SELECT DISTINCT sol_item_id,tbl.* FROM `tblsolutionitems` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.sol_item_id=tcs.redirect_id WHERE sol_item_status=1 AND sol_item_deleted=0 AND (banner_type='Audio' OR banner_type='Sound') AND redirect='wsi-wsi' AND publish_date_type='single_date' AND publish_single_date = '".$today."' AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.= " UNION SELECT DISTINCT sol_item_id,tbl.* FROM `tblsolutionitems` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.sol_item_id=tcs.redirect_id WHERE sol_item_status=1 AND sol_item_deleted=0 AND (banner_type='Audio' OR banner_type='Sound') AND redirect='wsi-wsi' AND publish_date_type='date_range' AND (publish_start_date <= '".$today."' AND publish_end_date >= '".$today."') AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.= " UNION SELECT DISTINCT sol_item_id,tbl.* FROM `tblsolutionitems` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.sol_item_id=tcs.redirect_id WHERE sol_item_status=1 AND sol_item_deleted=0 AND (banner_type='Audio' OR banner_type='Sound') AND redirect='wsi-wsi' AND publish_date_type='month_wise' AND publish_month_wise regexp '[[:<:]]".$month."[[:>:]]' AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.= " UNION SELECT DISTINCT sol_item_id,tbl.* FROM `tblsolutionitems` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.sol_item_id=tcs.redirect_id WHERE sol_item_status=1 AND sol_item_deleted=0 AND (banner_type='Audio' OR banner_type='Sound') AND redirect='wsi-wsi' AND publish_date_type='days_of_week' AND publish_days_of_week regexp '[[:<:]]".$week."[[:>:]]' AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.= " sol_item_deleted SELECT DISTINCT sol_item_id,tbl.* FROM `tblsolutionitems` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.sol_item_id=tcs.redirect_id WHERE sol_item_status=1 AND is_deleted=0 AND (banner_type='Audio' OR banner_type='Sound') AND redirect='wsi-wsi' AND publish_date_type='days_of_month' AND publish_days_of_month regexp '[[:<:]]".$day."[[:>:]]' AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.=" ORDER BY order_no ASC";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 
           {
                $data[]= $row;
            }
            
        }
        return $data;
    }
    //add by ample 29-12-20
    public function getIcons_resetMood($page_id="")
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $data1 =array();
        $data2 =array();

        $today=date('Y-m-d');
        $month = date('n', strtotime($today));
        $week = date('w', strtotime($today))+1;
        $day = date('j', strtotime($today));

        $sql = "SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND (redirect='icon' OR redirect IS NULL) AND (publish_date_type='' OR publish_date_type IS NULL ) AND (state_id=0 OR state_id IS NULL)"; 
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND redirect='icon' AND publish_date_type='single_date' AND publish_single_date = '".$today."' AND (state_id=0 OR state_id IS NULL)";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND redirect='icon' AND publish_date_type='date_range' AND (publish_start_date <= '".$today."' AND publish_end_date >= '".$today."') AND (state_id=0 OR state_id IS NULL)";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id  WHERE status=1 AND deleted=0 AND (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND redirect='icon' AND publish_date_type='month_wise' AND publish_month_wise regexp '[[:<:]]".$month."[[:>:]]' AND (state_id=0 OR state_id IS NULL)";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND redirect='icon' AND publish_date_type='days_of_week' AND publish_days_of_week regexp '[[:<:]]".$week."[[:>:]]' AND (state_id=0 OR state_id IS NULL)";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND redirect='icon' AND publish_date_type='days_of_month' AND publish_days_of_month regexp '[[:<:]]".$day."[[:>:]]' AND (state_id=0 OR state_id IS NULL)";
        $sql.=" ORDER BY order_no ASC";
        //echo $sql; die('-ss');
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 
           {
                $data1[]= $row;
            }
            
        }

        $user_id = $_SESSION['user_id'];
        if(!empty($user_id))
        {  
            $data2=$this->getThemes_resetMood_OnLocation($user_id);
        }

        $data=array_merge($data1,$data2);
        return $data; 
    }
    //add by ample 29-12-20
    function getIcons_resetMood_OnLocation($user_id)
    {   
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();

        $user_info=$this->getUserDetails($user_id);

        $today=date('Y-m-d');
        $month = date('n', strtotime($today));
        $week = date('w', strtotime($today))+1;
        $day = date('j', strtotime($today));

        $sql = "SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND redirect='icon' AND (publish_date_type='' OR publish_date_type IS NULL ) AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))"; 
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND redirect='icon' AND publish_date_type='single_date' AND publish_single_date = '".$today."' AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND redirect='icon' AND publish_date_type='date_range' AND (publish_start_date <= '".$today."' AND publish_end_date >= '".$today."') AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND redirect='icon' AND publish_date_type='month_wise' AND publish_month_wise regexp '[[:<:]]".$month."[[:>:]]' AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND redirect='icon' AND publish_date_type='days_of_week' AND publish_days_of_week regexp '[[:<:]]".$week."[[:>:]]' AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.= " UNION SELECT DISTINCT icons_id,tbl.* FROM `tbl_icons` tbl LEFT JOIN tbl_common_scheduled tcs ON tbl.icons_id=tcs.redirect_id WHERE status=1 AND deleted=0 AND (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND redirect='icon' AND publish_date_type='days_of_month' AND publish_days_of_month regexp '[[:<:]]".$day."[[:>:]]' AND ((state_id=".$user_info['state_id']." AND city_id=0 AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=0) OR (state_id=".$user_info['state_id']." AND city_id=".$user_info['city_id']." AND area_id=".$user_info['place_id']."))";
        $sql.=" ORDER BY order_no ASC";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 
           {
                $data[]= $row;
            }
            
        }
        return $data;
    }
    //add by ample 16-10-20
    public function getBandSettingData_resetMood($page_id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();

        $sql = "SELECT bs.* FROM `tbl_page_decor` pg LEFT JOIN tblbandsetting bs ON pg.band_id=bs.band_id WHERE pg.page_type='Page' AND  pg.page_name=".$page_id." AND pg.is_deleted=0 AND pg.status=1 AND bs.band_status=1 AND (band_type='theme-band' OR band_type='music-band' OR band_type='icon-band')";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data= $row;
            
        }
        return $data;     
    }
}