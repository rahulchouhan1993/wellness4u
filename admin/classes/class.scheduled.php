<?php

include_once("class.paging.php");
include_once("class.admin.php");

class Schedule extends Admin

{
    
    //copy by ample 
    public function getStateOption($country_id,$state_id="")
    {
        $DBH = new mysqlConnection();

        $output = '';


        $country_sql_str = "";


            if($country_id != '' && $country_id != 0)

            {

                $country_sql_str = " AND country_id = '".$country_id."' ";  

            }


      

            try {

                $sql = "SELECT state_id,state FROM `tblstates` WHERE `state_deleted` = '0' ".$country_sql_str." ORDER BY state ASC";    

                $STH = $DBH->query($sql);

                if( $STH->rowCount() > 0 )

                {

                    while($r= $STH->fetch(PDO::FETCH_ASSOC))

                    {


                            if($r['state_id'] == $state_id )

                            {

                                $selected = ' selected ';   

                            }

                            else

                            {

                                $selected = ''; 

                            }

                        

                        

                        $output .= '<option value="'.$r['state_id'].'" '.$selected.'>'.stripslashes($r['state']).'</option>';

                    }

                }

            } catch (Exception $e) {

                $stringData = '[getStateOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;

                $this->debuglog($stringData);

                return $output;

            }       

        

        return $output;

    }
    //copy by ample 13-10-20
    public function getCityOption($country_id,$state_id,$city_id="")

    {

        //echo 'hiiiiii';

        $DBH = new mysqlConnection();

        $output = '<option value="">All City</option>';

        $state_sql_str = "";

        $country_sql_str = "";

 

            if($country_id != '' && $country_id != 0)

            {

                $country_sql_str = " AND country_id = '".$country_id."' ";  

            }

    

            

            if($state_id != '' && $state_id != 0)

            {

                $state_sql_str = " AND state_id = '".$state_id."' ";    

            }


        



            try {

                $sql = "SELECT city_id,city FROM `tblcities` WHERE `city_deleted` = '0' ".$country_sql_str." ".$state_sql_str." ORDER BY city ASC"; 

                $STH = $DBH->query($sql);

                if( $STH->rowCount() > 0 )

                {

                    while($r= $STH->fetch(PDO::FETCH_ASSOC))

                    {


                            if($r['city_id'] == $city_id )

                            {

                                $selected = ' selected ';   

                            }

                            else

                            {

                                $selected = ''; 

                            }

                        
                        $output .= '<option value="'.$r['city_id'].'" '.$selected.'>'.stripslashes($r['city']).'</option>';

                    }

                }

            } catch (Exception $e) {

                $stringData = '[getCityOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;

                $this->debuglog($stringData);

                return $output;

            }       

        

        return $output;

    }
    //copy by ample 14-10-20
    public function getAreaOption($country_id,$state_id,$city_id,$area_id="")

    {

        $DBH = new mysqlConnection();

        $output = '<option value="">All Area</option>';

        $city_sql_str = "";

        $state_sql_str = "";

        $country_sql_str = "";


            if($country_id != '' && $country_id != 0)

            {

                $country_sql_str = " AND country_id = '".$country_id."' ";  

            }

            if($state_id != '' && $state_id != 0)

            {

                $state_sql_str = " AND state_id = '".$state_id."' ";    

            }


            if($city_id != '' && $city_id != 0)

            {

                $city_sql_str = " AND city_id = '".$city_id."' ";   

            }




            try {

                $sql = "SELECT area_id,area_name FROM `tblarea` WHERE `area_deleted` = '0' ".$country_sql_str." ".$state_sql_str." ".$city_sql_str." ORDER BY area_name ASC";   

                $STH = $DBH->query($sql);

                if( $STH->rowCount() > 0 )

                {

                    while($r= $STH->fetch(PDO::FETCH_ASSOC))

                    {


                            if($r['area_id'] == $area_id )

                            {

                                $selected = ' selected ';   

                            }

                            else

                            {

                                $selected = ''; 

                            }
                    

                        $output .= '<option value="'.$r['area_id'].'" '.$selected.'>'.stripslashes($r['area_name']).'</option>';

                    }

                }

            } catch (Exception $e) {

                $stringData = '[getAreaOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;

                $this->debuglog($stringData);

                return $output;

            }       


        return $output;

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
 
    //added by ample 17-06-20
    public function getScheduledata($id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tbl_common_scheduled` WHERE schedule_id =".$id;
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
        }
        return $data;     
    } 
    //added by ample 12-10-20
    public function updateScheduleData($admin_id,$data,$id)
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql="UPDATE `tbl_common_scheduled` SET 
            `updated_by`='".$admin_id."',`updated_at`='".date('Y-m-d H:i:s')."',`state_id`='".$data['state_id']."',`city_id`='".$data['city_id']."',`area_id`='".$data['area_id']."',`publish_date_type`='".$data['publish_date_type']."',`publish_single_date`='".$data['publish_single_date']."',`publish_start_date`='".$data['publish_start_date']."',`publish_end_date`='".$data['publish_end_date']."',`publish_month_wise`='".$data['publish_month_wise']."',`publish_days_of_week`='".$data['publish_days_of_week']."',`publish_days_of_month`='".$data['publish_days_of_month']."' WHERE `schedule_id`='".$id."'";
        $STH = $DBH->query($sql);
        // print_r($STH); die('--');
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }

    //add by ample 13-10-20
    public function addScheduleData($admin_id,$data,$other="")
    {   

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql = "INSERT INTO `tbl_common_scheduled` (`created_by`,`state_id`,`city_id`,`area_id`,`publish_date_type`,`publish_single_date`,`publish_start_date`,`publish_end_date`,`publish_month_wise`,`publish_days_of_week`,`publish_days_of_month`,`redirect`,`redirect_id`) VALUES (".$admin_id.",'".$data['state_id']."','".$data['city_id']."','".$data['area_id']."','".$data['publish_date_type']."','".$data['publish_single_date']."','".$data['publish_start_date']."','".$data['publish_end_date']."','".$data['publish_month_wise']."','".$data['publish_days_of_week']."','".$data['publish_days_of_month']."','".$other['redirect']."',".$other['redirect_id'].")";

        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {   
            $return = true;
            // $s_id = $DBH->lastInsertId();
            //         if(!empty($s_id))
            //         {   
                        
            //             $this->updateScheduleID($s_id,$other);
                        
            //         }
        }
        return $return;
    }  
    //added by ample 16-10-20
    public function updateScheduleID($s_id,$other)
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $tbl='';
        $column='';

        if($other['redirect']=='bannerSlider')
        {
            $tbl='tblbannerslider';
            $column='banner_id';
        }
        elseif ($other['redirect']=='wsi') {
            $tbl='tblsolutionitems';
            $column='sol_item_id';
        }

        $sql="UPDATE `".$tbl."` SET 
            `schedule_id`='".$s_id."' WHERE `".$column."`='".$other['redirect_id']."'";
        $STH = $DBH->query($sql);
        //print_r($STH);
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }
    //add by ample 22-10-20
    public function getRedirectSchedule($redirect_id="",$redirect="")
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tbl_common_scheduled` WHERE redirect='".$redirect."' AND redirect_id =".$redirect_id;
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
        }
        return $data;     
    }
    //add by ample 31-07-20   
    public function DeleteScheduleData($data,$ids)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $ids=array_filter($ids);
        $imploded_arr = implode(',', $ids);
        if(!empty($imploded_arr))
        {
            $sql = "DELETE FROM `tbl_common_scheduled` WHERE redirect='".$data['redirect']."' AND redirect_id =".$data['redirect_id']." AND `schedule_id` NOT IN (".$imploded_arr.")"; 
            // echo $sql; die('-ss');
            $STH = $DBH->query($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                $return = true;
            }
        }
        return $return;
    }

}

?>