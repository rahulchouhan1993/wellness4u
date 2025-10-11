<?php

include_once("class.paging.php");

include_once("class.admin.php");

class BodyParts extends Admin

{

    public function getAllBodyParts($search,$bp_status,$bp_side,$bp_sex,$bp_parent_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();



        $admin_id = $_SESSION['admin_id'];

        $edit_action_id = '221';

        $delete_action_id = '222';

        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);



        if($search == '')

        {

            $str_sql_search = "";

        }

        else

        {

            $str_sql_search = " AND `bp_name` LIKE '%".$search."%' ";

        }



        if($bp_status == '')

        {

            $str_sql_status = "";

        }

        else

        {

            $str_sql_status = " AND `bp_status` = '".$bp_status."' ";

        }



        if($bp_side == '')

        {

            $str_sql_bp_side = "";

        }

        else

        {

            $str_sql_bp_side = " AND `bp_side` = '".$bp_side."' ";

        }



        if($bp_sex == '')

        {

            $str_sql_bp_sex = "";

        }

        else

        {

            $str_sql_bp_sex = " AND `bp_sex` = '".$bp_sex."' ";

        }

        

        if($bp_parent_id == '')

        {

            $str_sql_bp_parent_id = "";

        }

        else

        {

            $str_sql_bp_parent_id = " AND `bp_parent_id` = '".$bp_parent_id."' ";

        }



        $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_deleted` = '0' ".$str_sql_search."  ".$str_sql_status."  ".$str_sql_bp_side."  ".$str_sql_bp_sex."  ".$str_sql_bp_parent_id."  ORDER BY `bp_name` ASC ";		

        //$this->execute_query($sql);

        

        $STH = $DBH->prepare($sql);

        $STH->execute();        

        $total_records = $STH->rowCount();

        $record_per_page = 100;

        $scroll = 5;

        $page = new Page(); 

        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

        $page->set_link_parameter("Class = paging");

        $page->set_qry_string($str="mode=body_parts");

        

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

                if($row['bp_status'] == '1')

                {

                    $list_bp_status = 'Active';

                }

                else

                {

                    $list_bp_status = 'Inactive';

                }



                if($row['bp_side'] == '1')

                {

                    $list_bp_side = 'Front Side';

                }

                else

                {

                    $list_bp_side = 'Back Side';

                }

                

                if($row['bp_sex'] == '1')

                {

                    $list_bp_sex = 'Male';

                    

                    if($row['bp_side'] == '1')

                    {

                        $body_image = 'male_body_front.png';

                    }

                    else

                    {

                        $body_image = 'male_body_back.png';

                    }

                }

                else

                {

                    $list_bp_sex = 'Female';

                    

                    if($row['bp_side'] == '1')

                    {

                        $body_image = 'female_body_front.png';

                    }

                    else

                    {

                        $body_image = 'female_body_back.png';

                    }

                }

                

                if($row['bp_parent_id'] == '0')

                {

                    $main_part_name = '';

                }

                else

                {

                    $obj3 = new BodyParts();

                    $main_part_name = $obj3->getBodyPartName($row['bp_parent_id']);

                }

                

                $arr_temp_image = explode(',',$row['bp_image']);

                

                $body_image = SITE_URL.'/uploads/'.$body_image;

                

                $list_bp_image = '<div style="display: block;position:relative;width: '.$arr_temp_image[4].'px;height: '.$arr_temp_image[5].'px; background-image: url('.$body_image.');background-repeat: no-repeat;background-position: -'.$arr_temp_image[0].'px -'.$arr_temp_image[2].'px;">&nbsp</div>';



                $output .= '<tr class="manage-row">';

                $output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

                $output .= '<td height="30" align="center"><strong>'.stripslashes($row['bp_name']).'</strong></td>';

                $output .= '<td height="30" align="center">'.$list_bp_side.'</td>';

                $output .= '<td height="30" align="center">'.$list_bp_sex.'</td>';

                //$output .= '<td height="30" align="center">'.$main_part_name.'</td>';

                $output .= '<td height="30" align="center">'.$list_bp_status.'</td>';

                $output .= '<td align="center">'.$list_bp_image.'</td>';

                $output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['bp_add_date'])).'</td>';

                $output .= '<td align="center" nowrap="nowrap">';

                        if($edit) {

                $output .= '<a href="index.php?mode=edit_body_part&id='.$row['bp_id'].'" ><img src = "images/edit.gif" border="0"></a>';

                                        }

                $output .= '</td>';

                $output .= '<td align="center" nowrap="nowrap">';

                        if($delete) {

                $output .= '<a href=\'javascript:fn_confirmdelete("Body Part","sql/delbodypart.php?id='.$row['bp_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

                                        }

                $output .= '</td>';

                $output .= '</tr>';

                $i++;

            }

        }

        else

        {

            $output = '<tr class="manage-row" height="20"><td colspan="9" align="center">NO RECORDS FOUND</td></tr>';

        }



        $page->get_page_nav();

        return $output;

    }

    

    public function getAllBodySymptoms($bms_id,$bs_status,$bp_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();



        $admin_id = $_SESSION['admin_id'];

        $edit_action_id = '225';

        $delete_action_id = '226';

        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);



        /*

        if($search == '')

        {

            $str_sql_search = "";

        }

        else

        {

            $str_sql_search = " AND TBS.bs_name LIKE '%".$search."%' ";

        }

         * 

         */

        

        if($bms_id == '')

        {

            $str_sql_bms_id = "";

        }

        else

        {

            $str_sql_bms_id = " AND TBS.bms_id = '".$bms_id."' ";

        }



        if($bs_status == '')

        {

            $str_sql_status = "";

        }

        else

        {

            $str_sql_status = " AND TBS.bs_status = '".$bs_status."' ";

        }



        

        if($bp_id == '')

        {

            $str_sql_bp_id = "";

        }

        else

        {

            $str_sql_bp_id = " AND TBS.bp_id = '".$bp_id."' ";

        }



        $sql = "SELECT TBS.*,TBP.bp_name,TBP.bp_side,TBP.bp_sex,TBP.bp_image , TMS.bms_name FROM `tblbodysymptoms` AS TBS "

                . "LEFT JOIN `tblbodyparts` AS TBP ON TBS.bp_id = TBP.bp_id "

                . "LEFT JOIN `tblbodymainsymptoms` AS TMS ON TBS.bms_id = TMS.bms_id "

                . "WHERE TBP.bp_deleted = '0' AND TBS.bs_deleted = '0' ".$str_sql_bms_id."  ".$str_sql_status."  ".$str_sql_bp_id."  ORDER BY TMS.bms_name ASC ";		

        //echo '<br>'.$sql;

        //$this->execute_query($sql);

        $STH = $DBH->prepare($sql);

        $STH->execute();

        $total_records = $STH->rowCount();

        $record_per_page = 100;

        $scroll = 5;

        $page = new Page(); 

        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

        $page->set_link_parameter("Class = paging");

        $page->set_qry_string($str="mode=body_symptoms");

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

                if($row['bs_status'] == '1')

                {

                    $list_bs_status = 'Active';

                }

                else

                {

                    $list_bs_status = 'Inactive';

                }



                if($row['bp_side'] == '1')

                {

                    $list_bp_side = 'Front Side';

                }

                else

                {

                    $list_bp_side = 'Back Side';

                }

                

                if($row['bp_sex'] == '1')

                {

                    $list_bp_sex = 'Male';

                    

                    if($row['bp_side'] == '1')

                    {

                        $body_image = 'male_body_front.png';

                    }

                    else

                    {

                        $body_image = 'male_body_back.png';

                    }

                }

                else

                {

                    $list_bp_sex = 'Female';

                    

                    if($row['bp_side'] == '1')

                    {

                        $body_image = 'female_body_front.png';

                    }

                    else

                    {

                        $body_image = 'female_body_back.png';

                    }

                }

                

                $arr_temp_image = explode(',',$row['bp_image']);

                

                $body_image = SITE_URL.'/uploads/'.$body_image;

                

                $list_bp_image = '<div style="display: block;position:relative;width: '.$arr_temp_image[4].'px;height: '.$arr_temp_image[5].'px; background-image: url('.$body_image.');background-repeat: no-repeat;background-position: -'.$arr_temp_image[0].'px -'.$arr_temp_image[2].'px;">&nbsp</div>';



                $output .= '<tr class="manage-row">';

                $output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

                $output .= '<td height="30" align="center"><strong>'.stripslashes($row['bms_name']).'</strong></td>';

                $output .= '<td height="30" align="center"><strong>'.stripslashes($row['bp_name']).'</strong></td>';

                $output .= '<td height="30" align="center">'.$list_bp_side.'</td>';

                $output .= '<td height="30" align="center">'.$list_bp_sex.'</td>';

                $output .= '<td height="30" align="center">'.$list_bs_status.'</td>';

                $output .= '<td align="center">'.$list_bp_image.'</td>';

                $output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['bs_add_date'])).'</td>';

                $output .= '<td align="center" nowrap="nowrap">';

                        if($edit) {

                $output .= '<a href="index.php?mode=edit_body_sypmtom&id='.$row['bs_id'].'" ><img src = "images/edit.gif" border="0"></a>';

                                        }

                $output .= '</td>';

                $output .= '<td align="center" nowrap="nowrap">';

                        if($delete) {

                $output .= '<a href=\'javascript:fn_confirmdelete("Body Symptom","sql/delbodysymptoms.php?id='.$row['bs_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

                                        }

                $output .= '</td>';

                $output .= '</tr>';

                $i++;

            }

        }

        else

        {

            $output = '<tr class="manage-row" height="20"><td colspan="10" align="center">NO RECORDS FOUND</td></tr>';

        }



        $page->get_page_nav();

        return $output;

    }

    

    public function getAllMainSymptoms($search,$bms_status,$bmst_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();



        $admin_id = $_SESSION['admin_id'];

        $edit_action_id = '229';

        $delete_action_id = '230';

        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

        

        

        if($search == '')

        {

            $str_sql_search = "";

        }

        else

        {

            $str_sql_search = " AND TMS.bms_name LIKE '%".$search."%' ";

        }



        if($bms_status == '')

        {

            $str_sql_status = "";

        }

        else

        {

            $str_sql_status = " AND TMS.bms_status = '".$bms_status."' ";

        }



        

        if($bmst_id == '')

        {

            $str_sql_bmst_id = "";

        }

        else

        {

            $str_sql_bmst_id = " AND TMS.bmst_id = '".$bmst_id."' ";

        }

        

        $sql = "SELECT * FROM `tblbodymainsymptoms` AS TMS LEFT JOIN `tblbodymainsymptomtype` AS TMST ON TMS.bmst_id = TMST.bmst_id "

                . "WHERE TMS.bms_deleted = '0' ".$str_sql_search." ".$str_sql_status." ".$str_sql_bmst_id." ORDER BY TMS.bms_name ASC ";		

        //$this->execute_query($sql);

        

        $STH = $DBH->prepare($sql);

        $STH->execute();

        

        $total_records = $STH->rowCount();

        $record_per_page = 100;

        $scroll = 5;

        $page = new Page(); 

        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

        $page->set_link_parameter("Class = paging");

        $page->set_qry_string($str="mode=main_symptoms");

        //$result=$this->execute_query($page->get_limit_query($sql));

        

        $STH2 = $DBH->prepare($sql);

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

                if($row['bms_status'] == '1')

                {

                    $bms_status = 'Active';

                }

                else

                {

                    $bms_status = 'Inactive';

                }



                

                $output .= '<tr class="manage-row">';

                $output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

                $output .= '<td height="30" align="center"><strong>'.stripslashes($row['bms_name']).'</strong></td>';

                $output .= '<td height="30" align="center"><strong>'.stripslashes($row['bmst_name']).'</strong></td>';

                $output .= '<td height="30" align="center">'.$bms_status.'</td>';

                $output .= '<td align="center" nowrap="nowrap">';

                        if($edit) {

                $output .= '<a href="index.php?mode=edit_main_symptom&id='.$row['bms_id'].'" ><img src = "images/edit.gif" border="0"></a>';

                                        }

                $output .= '</td>';

                $output .= '<td align="center" nowrap="nowrap">';

                        if($delete) {

                $output .= '<a href=\'javascript:fn_confirmdelete("Symptom","sql/delmainsymptoms.php?id='.$row['bms_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

                                        }

                $output .= '</td>';

                $output .= '</tr>';

                $i++;

            }

        }

        else

        {

            $output = '<tr class="manage-row" height="20"><td colspan="6" align="center">NO RECORDS FOUND</td></tr>';

        }



        $page->get_page_nav();

        return $output;

    }

    

    public function chkBMSNameExists($bms_name,$bmst_id)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false;



            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bmst_id` = '".$bmst_id."' AND `bms_name` = '".$bms_name."' AND `bms_deleted` = '0'";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                    $return = true;

            }

            return $return;

    }

    

    public function chkBMSNameExists_Edit($bms_name,$bms_id)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false;



            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` != '".$bms_id."' AND `bms_name` = '".$bms_name."' AND `bms_deleted` = '0'";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                    $return = true;

            }

            return $return;

    }



    public function addBodyPart($bp_name,$bp_side,$bp_sex,$bp_parent_id,$bp_image)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = false;



        $sql = "INSERT INTO `tblbodyparts` (`bp_name`,`bp_side`,`bp_sex`,`bp_parent_id`,`bp_image`,`bp_status`) "

                . "VALUES ('".addslashes($bp_name)."','".addslashes($bp_side)."','".addslashes($bp_sex)."','".addslashes($bp_parent_id)."','".addslashes($bp_image)."','1')";

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            $return = true;

        }

        return $return;

    }

    

    public function addBodySymptom($bms_id,$bp_id,$bs_remarks,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = false;



        $sql = "INSERT INTO `tblbodysymptoms` (`bms_id`,`bp_id`,`bs_remarks`,`bs_status`) "

                . "VALUES ('".addslashes($bms_id)."','".addslashes($bp_id)."','".addslashes($bs_remarks)."','1')";

        //echo'<br>'.$sql;

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            $return = true;

            $bs_id = $DBH->lastInsertId();

            for($i=0;$i<count($arr_min_rating);$i++)

            {

                $sql2 = "INSERT INTO `tblbodysymptomscales` (`bs_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`bss_status`) "

                        . "VALUES ('".addslashes($bs_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";

                //echo'<br>'.$sql2;

                $STH2 = $DBH->prepare($sql2);

                $STH2->execute();

            }	

        }

        return $return;

    }

    

    public function addMainSymptom($bms_name,$bmst_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = false;



        $sql = "INSERT INTO `tblbodymainsymptoms` (`bms_name`,`bmst_id`,`bms_status`) "

                . "VALUES ('".addslashes($bms_name)."','".addslashes($bmst_id)."','1')";

        //echo'<br>'.$sql;

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            $return = true;

        }

        return $return;

    }

	

	

    public function getBodyPartDetails($bp_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $bp_name = '';

        $bp_side = '';

        $bp_sex = '';

        $bp_parent_id = '';

        $bp_image = '';

        $bp_status = '';

        

        $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_id` = '".$bp_id."' AND `bp_deleted` = '0'";

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            $row = $STH->fetch(PDO::FETCH_ASSOC);

            $bp_name = stripslashes($row['bp_name']);

            $bp_side = stripslashes($row['bp_side']);

            $bp_sex = stripslashes($row['bp_sex']);

            $bp_parent_id = stripslashes($row['bp_parent_id']);

            $bp_image = stripslashes($row['bp_image']);

            $bp_status = stripslashes($row['bp_status']);

        }

        return array($bp_name,$bp_side,$bp_sex,$bp_parent_id,$bp_image,$bp_status);

    }

    

    public function getBodySymptomDetails($bs_id)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $arr_min_rating = array();

            $arr_max_rating = array();

            $arr_interpretaion = array();

            $arr_treatment = array();

            $bms_id = '';

            $bp_id = '';

            $bs_remarks = '';

            $bs_status = '';



            $sql = "SELECT * FROM `tblbodysymptoms` WHERE `bs_id` = '".$bs_id."' AND `bs_deleted` = '0' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $bms_id = stripslashes($row['bms_id']);

                    $bp_id = stripslashes($row['bp_id']);

                    $bs_remarks = stripslashes($row['bs_remarks']);

                    $bs_status = stripslashes($row['bs_status']);



                    $sql2 = "SELECT * FROM `tblbodysymptomscales` WHERE `bs_id` = '".$bs_id."' AND `bss_deleted` = '0' ORDER BY `bss_id`";

                    $STH2 = $DBH->prepare($sql2);

                    $STH2->execute();

                    if($STH2->rowCount() > 0)

                    {

                            while($row2 = $STH->fetch(PDO::FETCH_ASSOC))

                            {

                                    array_push($arr_min_rating , $row2['min_rating']);

                                    array_push($arr_max_rating , $row2['max_rating']);

                                    array_push($arr_interpretaion , stripslashes($row2['interpretaion']));

                                    array_push($arr_treatment , stripslashes($row2['treatment']));

                            }

                    }

            }

            return array($bms_id,$bp_id,$bs_remarks,$bs_status,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment);

    }

    

    public function getMainSymptomDetails($bms_id)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $bms_name = '';

            $bmst_id = '';

            $bms_status = '';



            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$bms_id."' AND `bms_deleted` = '0' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $bms_name = stripslashes($row['bms_name']);

                    $bmst_id = stripslashes($row['bmst_id']);

                    $bms_status = stripslashes($row['bms_status']);

            }

            return array($bms_name,$bmst_id,$bms_status);

    }

	

    public function updateBodyPart($bp_name,$bp_side,$bp_sex,$bp_parent_id,$bp_image,$bp_status,$bp_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = false;



        $upd_sql = "UPDATE `tblbodyparts` SET "

                . "`bp_name` = '".addslashes($bp_name)."' , "

                . "`bp_side` = '".addslashes($bp_side)."' , "

                . "`bp_sex` = '".addslashes($bp_sex)."' , "

                . "`bp_parent_id` = '".addslashes($bp_parent_id)."' , "

                . "`bp_image` = '".addslashes($bp_image)."' , "

                . "`bp_status` = '".addslashes($bp_status)."'  "

                . "WHERE `bp_id` = '".$bp_id."'";

        $STH = $DBH->prepare($upd_sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            $return = true;

        }

        return $return;

    }

    

    public function updateBodySymptom($bms_id,$bp_id,$bs_remarks,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$status,$bs_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = false;



        $upd_sql = "UPDATE `tblbodysymptoms` SET "

                . "`bms_id` = '".addslashes($bms_id)."' , "

                . "`bp_id` = '".addslashes($bp_id)."' , "

                . "`bs_remarks` = '".addslashes($bs_remarks)."' , "

                . "`bs_status` = '".addslashes($status)."'  "

                . "WHERE `bs_id` = '".$bs_id."'";

        $STH = $DBH->prepare($upd_sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            $return = true;

            $del_sql1 = "UPDATE `tblbodysymptomscales` SET `bss_deleted` = '1' WHERE `bs_id` = '".$bs_id."'"; 

            $STH2 = $DBH->prepare($del_sql1);

            $STH2->execute();

            for($i=0;$i<count($arr_min_rating);$i++)

            {

                $sql2 = "INSERT INTO `tblbodysymptomscales` (`bs_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`bss_status`) "

                        . "VALUES ('".addslashes($bs_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";

                $STH3 = $DBH->prepare($sql2);

                $STH3->execute();

            }	

        }

        return $return;

    }

    

//    public function updateMainSymptom($all_keyword_data_explode,$sol_item_id,$cat_total_cnt1,$keywords,$symptom_keyword_id,$sym_code,$id,$bms_name,$keywordsold,$total_count,$comment,$hdnbmsid,$fav_cat_type_id,$fav_cat_id_parent,$show_hide,$symtum_status)

    public function updateMainSymptom($id,$sol_item_id,$bms_name,$keywords,$sym_code,$symptom_id,$fav_cat_type_id,$fav_cat_id_parent,$comment,$show_hide,$symtum_status,$key_fav_cat_type_id,$key_fav_cat_id,$sub_cat_link,$sub_cat_code,$uid)     

    {

    //$id,$sol_item_id,$bms_name,$keywords,$sym_code,$symptom_id,$fav_cat_type_id,$fav_cat_id_parent,$comment,$show_hide,$symtum_status,$key_fav_cat_type_id,$key_fav_cat_id,$sub_cat_link

    //print_r($sol_item_id);die();

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = true;



        $upd_sql = "UPDATE `tblbodymainsymptoms` SET "

                . "`bms_name` = '".addslashes($bms_name)."' , "

                . "`comment` = '".addslashes($comment)."' , "

                . "`sym_code` = '".addslashes($sym_code)."' , "

                //. "`keywords` = '".addslashes($keywordsold)."', "

                . "`posted_by` = '".$_SESSION['admin_id']."' "

                . "WHERE `bms_id` = '".$symptom_id."'";

        

        //echo $upd_sql;

       // die();

        $STH = $DBH->prepare($upd_sql);

        $STH->execute();

        $upd_sql = "UPDATE `tblsymtumscustomcategory` SET `fav_cat_type_id` = '".addslashes($fav_cat_type_id)."', `fav_parent_cat` = '".$fav_cat_id_parent."' ,`show_hide` = '".addslashes($show_hide)."' , `symtum_status` ='".$symtum_status."' ,`updated_by` = '".$_SESSION['admin_id']."' WHERE `id` = '".$id."'";

        $STH2 = $DBH->prepare($upd_sql);

        $STH2->execute();

        

        

//        $del_sql = "DELETE FROM `tbl_wellness_solution_item_keyword` WHERE `sol_item_id` = '".$sol_item_id."' and `page_name` = 'main_symptoms'"; 

//        $STH3 = $DBH->prepare($del_sql);

//        $STH3->execute();

//        

//         if(count($all_keyword_data_explode) > 0)

//            {

//                for($m=0; $m<count($all_keyword_data_explode); $m++)

//                { 

//                      

//                        $data_keyword = array();

//                        $data_keyword['sol_item_id'] = $sol_item_id;

//                        $data_keyword['keyword_name'] = $all_keyword_data_explode[$m];

//                        $page='main_symptoms';

//                        $sqladd = "INSERT INTO `tbl_wellness_solution_item_keyword` (`sol_item_id`,`keyword_name`,`page_name`,`selected_keyword`) VALUES ('".addslashes($data_keyword['sol_item_id'])."','".$data_keyword['keyword_name']."','".$page."','active')";

//                        //$this->execute_query($sqladd);

//                        $STH4 = $DBH->prepare($sqladd);

//                        $STH4->execute();

//                }

//            }

     

        

        $del_sql = "DELETE FROM `tbl_symptom_keyword` WHERE `symptom_id` = '".$symptom_id."' "; 

        $STH3 = $DBH->prepare($del_sql);

        $STH3->execute();  

        if(count($keywords) > 0)

            {   

                for($j=0; $j<count($keywords); $j++)

                { 

                        $tdata_cat = array();

                        $tdata_cat['symptom_id'] = $symptom_id;


                        // add by ample 08-01-20
                        $arr_select_keywords = array();
                        foreach ($keywords[$j]['key'] as $key => $value) 
                        {
                            array_push($arr_select_keywords,$value);
                        }
                        //$key = implode(',',$arr_select_keywords);
                        //change by ample 12-05-20
                        $key = json_encode($arr_select_keywords);

                        $tdata_cat['keyword'] =$key;

                        $tdata_cat['key_prof_cat'] = $key_fav_cat_type_id[$j];

                        $tdata_cat['key_sub_cat'] = $key_fav_cat_id[$j];

                        $tdata_cat['fetch_link'] = $sub_cat_link[$j];
                        //update by ample 07-01-20
                        $tdata_cat['ref_code'] = $sub_cat_code[$j];
                        $tdata_cat['uid'] = $uid[$j];

                        //$keywords_data = $this->getKeywordIdformFavCatTableVivek($keywords[$j]);

                        $this->addKeywordcustomSymptom($tdata_cat);	



                }

                

                    

            }

       

        return $return;

    }

	

    public function deleteBodyPart($bp_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = false;

        $del_sql1 = "UPDATE `tblbodyparts` SET `bp_deleted` = '1' WHERE `bp_id` = '".$bp_id."'"; 

        $STH = $DBH->prepare($del_sql1);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            $return = true;

        }

        return $return;

    }

    

    public function deleteBodySymptom($bs_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = false;

        $del_sql1 = "UPDATE `tblbodysymptoms` SET `bs_deleted` = '1' WHERE `bs_id` = '".$bs_id."'"; 

        $STH = $DBH->prepare($del_sql1);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            $return = true;

        }

        return $return;

    }

    

    public function deleteMainSymptom($bms_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = false;

        $del_sql1 = "UPDATE `tblbodymainsymptoms` SET `bms_deleted` = '1' WHERE `bms_id` = '".$bms_id."'"; 

        $STH = $DBH->prepare($del_sql1);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            $return = true;

        }

        return $return;

    }

	

    public function deleteMainSymptomRamakant($id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false;

            $del_sql1 = "UPDATE `tblsymtumscustomcategory` SET `symtum_deleted` = '1' WHERE `id` = '".$id."'"; 

            $STH = $DBH->prepare($del_sql1);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $return = true;

            }

            return $return;

	}

    

    public function getMainBodyPartsOptions($bp_id,$bp_parent_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $option_str = '';		



        $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_parent_id` = '".$bp_parent_id."' AND `bp_deleted` = '0' AND `bp_status` = '1'  ORDER BY `bp_name` ASC";

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['bp_id'] == $bp_id)

                {

                    $sel = ' selected ';

                }

                else

                {

                    $sel = '';

                }

                

               

                $option_str .= '<option value="'.$row['bp_id'].'" '.$sel.'>'.stripslashes($row['bp_name']).'</option>';

            }

        }

        return $option_str;

    }

    

    public function getMainSymptomOptions($bms_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $option_str = '';		



        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_deleted` = '0' AND `bms_status` = '1'  ORDER BY `bms_name` ASC";

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['bms_id'] == $bms_id)

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

        return $option_str;

    }

    

    public function getSymptomTypeOptions($bmst_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $option_str = '';		



        $sql = "SELECT * FROM `tblbodymainsymptomtype` WHERE `bmst_deleted` = '0' AND `bmst_status` = '1'  ORDER BY `bmst_name` ASC";

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['bmst_id'] == $bmst_id)

                {

                    $sel = ' selected ';

                }

                else

                {

                    $sel = '';

                }

                

               

                $option_str .= '<option value="'.$row['bmst_id'].'" '.$sel.'>'.stripslashes($row['bmst_name']).'</option>';

            }

        }

        return $option_str;

    }

    

    public function getAllBodyPartsSelectionStr($bp_id,$bp_parent_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $output = '';		



        $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_parent_id` = '".$bp_parent_id."' AND `bp_deleted` = '0' AND `bp_status` = '1'  ORDER BY `bp_name` ASC";

        $STH = $DBH->prepare($sql);

        $STH->execute();

            

        $output .= '<div style="width:400px;height:300px;overflow:scroll;">

                        <table border="0" width="100%" cellpadding="1" cellspacing="1">

                        <tbody>

                            <tr class="manage-header">

                                <td width="5%" class="manage-header" align="center" ></td>

                                <td width="25%" class="manage-header" align="center">Body Part</td>

                                <td width="20%" class="manage-header" align="center">Side</td>

                                <td width="20%" class="manage-header" align="center">Gender</td>

                                <td width="30%" class="manage-header" align="center">Image</td>

                            </tr>';

        if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['bp_id'] == $bp_id)

                {

                    $sel = ' checked ';

                }

                else

                {

                    $sel = '';

                }

                

                if($row['bp_side'] == '1')

                {

                    $list_bp_side = 'Front Side';

                }

                else

                {

                    $list_bp_side = 'Back Side';

                }

                

                if($row['bp_sex'] == '1')

                {

                    $list_bp_sex = 'Male';

                    

                    if($row['bp_side'] == '1')

                    {

                        $body_image = 'male_body_front.png';

                    }

                    else

                    {

                        $body_image = 'male_body_back.png';

                    }

                }

                else

                {

                    $list_bp_sex = 'Female';

                    

                    if($row['bp_side'] == '1')

                    {

                        $body_image = 'female_body_front.png';

                    }

                    else

                    {

                        $body_image = 'female_body_back.png';

                    }

                }

                

                $arr_temp_image = explode(',',$row['bp_image']);

                $body_image = SITE_URL.'/uploads/'.$body_image;

                $list_bp_image = '<div style="display: block;position:relative;width: '.$arr_temp_image[4].'px;height: '.$arr_temp_image[5].'px; background-image: url('.$body_image.');background-repeat: no-repeat;background-position: -'.$arr_temp_image[0].'px -'.$arr_temp_image[2].'px;">&nbsp</div>';



                $output .= '<tr class="manage-row">';

                $output .= '<td height="30" align="center" nowrap="nowrap" ><input type="radio" '.$sel.' name="bp_id" id="bp_id_'.$i.'" value="'.$row['bp_id'].'"></td>';

                $output .= '<td height="30" align="center"><strong>'.stripslashes($row['bp_name']).'</strong></td>';

                $output .= '<td height="30" align="center">'.$list_bp_side.'</td>';

                $output .= '<td height="30" align="center">'.$list_bp_sex.'</td>';

                $output .= '<td align="center">'.$list_bp_image.'</td>';

                $output .= '</tr>';

            }

        }

        else

        {

            $output .= '<tr class="manage-row" height="20"><td colspan="5" align="center">NO RECORDS FOUND</td></tr>';

        }

        $output .= '</tbody></table></div>';

        return $output;

    }

    

    public function getAllBodyPartsOptions($bp_id,$bp_parent_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $option_str = '';		



        $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_parent_id` = '".$bp_parent_id."' AND `bp_deleted` = '0' AND `bp_status` = '1'  ORDER BY `bp_name` ASC";

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['bp_id'] == $bp_id)

                {

                    $sel = ' selected ';

                }

                else

                {

                    $sel = '';

                }

                

                if($row['bp_side'] == '0')

                {

                    $bp_side = 'Back Side';

                }

                else

                {

                    $bp_side = 'Front Side';

                }

                

                if($row['bp_sex'] == '0')

                {

                    $bp_sex = 'Female';

                }

                else

                {

                    $bp_sex = 'Male';

                }

                $temp_str = '';

                $option_str .= '<option value="'.$row['bp_id'].'" '.$sel.'>'.stripslashes($row['bp_name']).' ('.$bp_sex.' - '.$bp_side.')</option>';

            }

        }

        return $option_str;

    }

    

    public function getBodyPartName($bp_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();



        $bp_name = '';



        $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_id` = '".$bp_id."'";

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $bp_name = stripslashes($row['bp_name']);

        }

        return $bp_name;

    }

    

    //Ramakant code started

     public function getPageCatDropdownModulesOptions($pag_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '';		



            $sql = "SELECT * FROM `tbladminmenu` WHERE 1 ORDER BY `menu_name` ASC";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    if($row['menu_mode'] == $pag_id)

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['menu_mode'].'" '.$sel.'>'.stripslashes($row['menu_name']).'</option>';

                }

            }

            return $option_str;

	}

    public function getKeywordNameVivek($fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '';		

            //echo 'aaa->'.$fav_cat_type_id;

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";

           $sql = "SELECT * FROM `tblkeywords` WHERE kw_status = 1 ORDER BY kw_name ASC";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            $option_str .= '<option value="">Select Category</option>';

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                    if($row['kw_id'] == $fav_cat_id)

                    {

                            $sel = ' selected ';

                    }

                    else

                    {

                            $sel = '';

                    }	

                    $kw_name[] = $row['kw_name'];

//                    $option_str .= '<option value="'.$row['kw_id'].'" '.$sel.'>'.stripslashes($kw_name).'</option>';

                }

            }

            //echo $option_str;

            

            return $kw_name;

	}

      public function getKeywordsNamebyid($interpretaionname)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = '';

            

            $sql = "SELECT * FROM `tblkeywords` WHERE `kw_name` = '".$interpretaionname."' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $return = $row['kw_id'];

            }

            return $return;

	}

        

         public function getIdByKeywordsName($kw_name)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = '';

            

            $sql = "SELECT * FROM `tblkeywords` WHERE `kw_id` = '".$kw_name."' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $return = $row['kw_name'];

            }

            return $return;

	}

	    

    public function addMainSymptomRamakant($sub_cat_link,$key_fav_cat_id,$key_fav_cat_type_id,$keywords,$cat_total_cnt1,$daily_code,$bms_name,$comment,$show_hide,$arr_cucat_parent_cat_id,$arr_cucat_cat_id,$cat_total_cnt,$sub_cat_code)

    {

        

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = false;

        $bmsid = $this->getSymptomidbyname($bms_name);

            

            if($bmsid > 0)

            {

              $bmsid = $bmsid;  

            }

            else

            {

                $sql = "INSERT INTO `tblbodymainsymptoms` (`sym_code`,`bms_name`,`comment`,`bms_status`,`posted_by`,`bms_deleted`,`bmst_id`,`keywords`,`sol_item_id`) "

                        . "VALUES ('".addslashes($daily_code)."','".addslashes($bms_name)."','".  addslashes($comment)."','1','".$_SESSION['admin_id']."',0,0,'',0)";

                //echo'<br>'.$sql;

                $STH = $DBH->prepare($sql);

                $STH->execute();

                //$bmsid = $STH->lastInsertId();

                $bmsid = $DBH->lastInsertId();

            }

        

        

        if ($STH && $STH->rowCount() > 0) 

        {

            $return = true;

        }

        

        if (count((array)$cat_total_cnt) > 0) 

            {

                for($i=0; $i<$cat_total_cnt; $i++)

                {

                        

                        $tdata_cat = array();

                        $tdata_cat['bmsid'] = $bmsid;

                        $tdata_cat['fav_cat_type_id'] = $arr_cucat_parent_cat_id[$i];

                        $tdata_cat['fav_parent_cat'] = $arr_cucat_cat_id[$i];

                        $tdata_cat['show_hide'] = $show_hide[$i];

                        $tdata_cat['fav_cat_status'] = 1;

                        $this->addcustomSymptom($tdata_cat);	

                    //$sql2 = "INSERT INTO `tblcustomfavcategory` (`favcat_id`,`fav_cat_type_id`,`fav_parent_cat`,`show_hide`) VALUES ('".addslashes($tdata_cat['fav_cat_id'])."','".addslashes($tdata_cat['fav_cat_type_id'])."','".addslashes($tdata_cat['fav_parent_cat'])."','".addslashes($tdata_cat['show_hide'])."')";

                    //die();

                    //$this->execute_query($sql2);

                    //return $this->result;

                }

                    

            }

        if (count((array)$cat_total_cnt1) > 0)

            {

                for($j=0; $j<$cat_total_cnt1; $j++)

                { 

                        $tdata_cat = array();

                        $tdata_cat['symptom_id'] = $bmsid;

                        $tdata_cat['keyword'] = $keywords[$j];

                        $tdata_cat['key_prof_cat'] = $key_fav_cat_type_id[$j];

                        $tdata_cat['key_sub_cat'] = $key_fav_cat_id[$j];

                        $tdata_cat['fetch_link'] = $sub_cat_link[$j]; 

                        //add by ample 03-01-20
                        $tdata_cat['ref_code'] = $sub_cat_code[$j];
                        $tdata_cat['uid'] = '';
                        //$keywords_data = $this->getKeywordIdformFavCatTableVivek($keywords[$j]);

                        $this->addKeywordcustomSymptom($tdata_cat);	



                }

                

                    

            }

           

                

            

        return $return;

    }

        //update by ample 

      public function addKeywordcustomSymptom($tdata_cat)

              {

                // echo "<pre>";

                // print_r($tdata_cat);
                // die('ss');
          

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false;

            $sql = "INSERT INTO `tbl_symptom_keyword` (`symptom_id`,`keywords`,`key_prof_cat`,`key_sub_cat`,`fetch_link`,ref_code,uid) VALUES ('".addslashes($tdata_cat['symptom_id'])."','".addslashes($tdata_cat['keyword'])."','".($tdata_cat['key_prof_cat'])."','".($tdata_cat['key_sub_cat'])."','".addslashes($tdata_cat['fetch_link'])."','".addslashes($tdata_cat['ref_code'])."','".addslashes($tdata_cat['uid'])."')";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $return = true;

            }

            return $return;

        }

    public function addcustomSymptom($tdata_cat) {

          

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false;

            $sql = "INSERT INTO `tblsymtumscustomcategory` (`bmsid`,`fav_cat_type_id`,`fav_parent_cat`,`show_hide`,`updated_by`) VALUES ('".addslashes($tdata_cat['bmsid'])."','".addslashes($tdata_cat['fav_cat_type_id'])."','".addslashes($tdata_cat['fav_parent_cat'])."','".addslashes($tdata_cat['show_hide'])."','".$_SESSION['admin_id']."')";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $return = true;

            }

            return $return;

        }

        

        public function getSymptomidbyname($bms_name) {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$sw_header = '';

		$sql = "SELECT `bms_id` FROM `tblbodymainsymptoms` WHERE `bms_name` = '".$bms_name."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

                if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$sw_header = stripslashes($row['bms_id']);

		}

		return $sw_header;   

        }

        

    public function getSymCodeNameById($bmsid)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $return = '';



                $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$bmsid."' ";

                $STH = $DBH->prepare($sql);

                $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $return = $row['sym_code'];

                }

                return $return;

            }        

    public function getAllMainSymptomsRamakant($search,$bms_status,$fav_cat_type_id,$fav_cat_id,$updated_by)

    {

         $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $admin_id = $_SESSION['admin_id'];

        $edit_action_id = '229';

        $delete_action_id = '230';

        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

        

        

//        if($search == '')

//        {

//            $str_sql_search = "";

//        }

//        else

//        {

//            $str_sql_search = " AND bms_name LIKE '%".$search."%' ";

//        }

        

        if($search == '')

            {

                $str_sql_search = '';

            }

            else

            {

                

                //$str_sql_search = " AND `fav_cat` LIKE '%".$search."%' ";

                $arr_fav_cat = $this->getsymtumarrayRamakant($search);

                

                $arr_fav_cat = implode("','", $arr_fav_cat);


                

                $str_sql_search = " AND `bmsid` IN ('".$arr_fav_cat."') ";

                

            }



        if($bms_status == '')

        {

            $str_sql_status = "";

        }

        else

        {

            $str_sql_status = " AND symtum_status = '".$bms_status."' ";

        }



        

        if($fav_cat_type_id == '')

        {

            $str_sql_bmst_id = "";

        }

        else

        {

            $str_sql_bmst_id = " AND fav_cat_type_id = '".$fav_cat_type_id."' ";

        }

        

        if($fav_cat_id == '')

        {

            $str_sql_favcat_id = "";

        }

        else

        {

            $str_sql_favcat_id = " AND fav_parent_cat = '".$fav_cat_id."' ";

        }

        

        if($updated_by == '')

        {

            $str_sql_updated_by = "";

        }

        else

        {

            $str_sql_updated_by = " AND updated_by = '".$updated_by."' ";

        }

        

        //$sql = "SELECT * FROM `tblsymtumscustomcategory` AS TMS LEFT JOIN `tblbodymainsymptomtype` AS TMST ON TMS.bmst_id = TMST.bmst_id "

         //       . "WHERE TMS.bms_deleted = '0' ".$str_sql_search." ".$str_sql_status." ".$str_sql_bmst_id." ORDER BY TMS.bms_name ASC ";		

        

//        $sql = "SELECT * FROM `tblsymtumscustomcategory`,`tblbodymainsymptoms` WHERE tblsymtumscustomcategory.bmsid = tblbodymainsymptoms.bms_id and symtum_deleted = '0' ".$str_sql_search." ".$str_sql_status." ".$str_sql_bmst_id." ORDER BY tblbodymainsymptoms.bms_name ASC ";		

        $sql = "SELECT * FROM `tblsymtumscustomcategory` WHERE  symtum_deleted =  '0' ".$str_sql_search." ".$str_sql_status." ".$str_sql_bmst_id."  ".$str_sql_favcat_id."  ".$str_sql_updated_by." ORDER BY bmsid DESC ";		

        

        //$this->execute_query($sql);

        

        

        $STH = $DBH->prepare($sql);

        $STH->execute();

        $total_records = $STH->rowCount();

        $record_per_page = 100;

        $scroll = 5;

        $page = new Page(); 

        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

        $page->set_link_parameter("Class = paging");

        $page_mode = $_GET['page'];

        $page->set_qry_string($str="mode=main_symptoms");

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



            $obj = new BodyParts();

            

            while($row = $STH2->fetch(PDO::FETCH_ASSOC))

            {

                if($row['symtum_status'] == '1')

                {

                    $bms_status = 'Active';

                }

                else

                {

                    $bms_status = 'Inactive';

                }

                

                    $fav_cat_type = $obj->getFavCategoryTypeName($row['fav_cat_type_id']);

                    $fav_cat_name = $obj->getsymtumNameRamakant($row['bmsid']);

                    $sol_item_id = $obj->getSolItemIdRamakant($row['bmsid']);

                    

                    $keywords_data=$obj->getAllKeywordsNameVivek($row['bmsid']);

                    $keywords_data_implode= implode('\',\'',$keywords_data);

                    

                   

                  

                    if($row['fav_parent_cat']!='')

                    {

                        $fav_cat_parent = $obj->getFavCategoryNameRamakant($row['fav_parent_cat']);

                    }

                    else

                    {

                        $fav_cat_parent = '';

                    }

                

                $output .= '<tr class="manage-row">';

                $output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

                $output .= '<td height="30" align="center">'.$obj->getSymCodeNameById($row['bmsid']).'</td>';

                $output .= '<td height="30" align="left">'.$fav_cat_name.'</td>';

                $output .= '<td height="30" align="center">'.$fav_cat_type.'</td>';

                $output .= '<td height="30" align="center">'.$fav_cat_parent.'</td>';

                $output .= '<td height="30" align="center">'.$obj->getKeywordsbybmsid($row['bmsid']).'</td>';

                $output .= '<td height="30" align="center">'.$bms_status.'</td>';

                $output .= '<td height="30" align="center">'.$obj->getAdminNameRam($row['updated_by']).'</td>';

                $output .= '<td height="30" align="center">'.date("d-m-Y h:i:s",strtotime($row['add_date'])).'</td>';

                $output .= '<td height="30" align="center">';

                 

                if($sol_item_id==0)

                    {

                      

                       $output .= '<a href="index.php?mode=add_wellness_solution_item&image_id='.$row['bmsid'].'&name=main_symptoms" ><img src = "images/sidebox_icon_pages.gif" border="0"></a>';

                       $output .= '<td height="30" align="center">';

                       $output .= '</td>';

                       

                    }

                    else

                    {

                     $output .= '<td height="30" align="center">';

                     $output .= '<a href="index.php?mode=edit_wellness_solution_item&id='.$sol_item_id.'&name=main_symptoms" ><img src = "images/sidebox_icon_pages.gif" border="0"></a>';

                     $output .= '</td>';

                       

                    }

                $output .= '</td>';

                $output .= '<td align="center" nowrap="nowrap">';

                        if($edit) {

                $output .= '<a href="index.php?mode=edit_main_symptom&id='.$row['id'].'&page='.$page_mode.'" ><img src = "images/edit.gif" border="0"></a>';

                                        }

                $output .= '</td>';

                $output .= '<td align="center" nowrap="nowrap">';

                        if($delete) {

                $output .= '<a href=\'javascript:fn_confirmdelete("Symptom","sql/delmainsymptoms.php?id='.$row['id'].'&page='.$page_mode.'")\' ><img src = "images/del.gif" border="0" ></a>';

                                        }

                $output .= '</td>';

                $output .= '</tr>';

                $i++;

            }

        }

        else

        {

            $output = '<tr class="manage-row" height="20"><td colspan="6" align="center">NO RECORDS FOUND</td></tr>';

        }



        $page->get_page_nav();

        return $output;

    }

    

    

     public function getSolItemIdRamakant($fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();;



            $fav_cat_type = '';



            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$fav_cat_id."' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $fav_cat_type = stripslashes($row['sol_item_id']);

            }

            return $fav_cat_type;

	}

        

     public function getAllMainSymptomsRamakantOld($search,$bms_status,$bmst_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $admin_id = $_SESSION['admin_id'];

        $edit_action_id = '229';

        $delete_action_id = '230';

        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

        

        

//        if($search == '')

//        {

//            $str_sql_search = "";

//        }

//        else

//        {

//            $str_sql_search = " AND bms_name LIKE '%".$search."%' ";

//        }

        

        if($search == '')

            {

                $str_sql_search = '';

            }

            else

            {

                

                //$str_sql_search = " AND `fav_cat` LIKE '%".$search."%' ";

                $arr_fav_cat = $this->getsymtumarrayRamakant($search);

                

                $arr_fav_cat = implode($arr_fav_cat, '\',\'');

                

                $str_sql_search = " AND `bmsid` IN ('".$arr_fav_cat."') ";

                

            }



        if($bms_status == '')

        {

            $str_sql_status = "";

        }

        else

        {

            $str_sql_status = " AND symtum_status = '".$bms_status."' ";

        }



        

        if($bmst_id == '')

        {

            $str_sql_bmst_id = "";

        }

        else

        {

            $str_sql_bmst_id = " AND fav_cat_type_id = '".$bmst_id."' ";

        }

        

        //$sql = "SELECT * FROM `tblsymtumscustomcategory` AS TMS LEFT JOIN `tblbodymainsymptomtype` AS TMST ON TMS.bmst_id = TMST.bmst_id "

         //       . "WHERE TMS.bms_deleted = '0' ".$str_sql_search." ".$str_sql_status." ".$str_sql_bmst_id." ORDER BY TMS.bms_name ASC ";		

        

        $sql = "SELECT * FROM `tblsymtumscustomcategory` WHERE symtum_deleted = '0' ".$str_sql_search." ".$str_sql_status." ".$str_sql_bmst_id." ORDER BY id DESC ";		

        

        //$this->execute_query($sql);

        

        $STH = $DBH->prepare($sql);

        $STH->execute();

           

        $total_records = $STH->rowCount();

        $record_per_page = 100;

        $scroll = 5;

        $page = new Page(); 

        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

        $page->set_link_parameter("Class = paging");

        $page->set_qry_string($str="mode=main_symptoms");

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



            $obj = new BodyParts();

            

            while($row = $STH2->fetch(PDO::FETCH_ASSOC))

            {

                if($row['symtum_status'] == '1')

                {

                    $bms_status = 'Active';

                }

                else

                {

                    $bms_status = 'Inactive';

                }

                

                    $fav_cat_type = $obj->getFavCategoryTypeName($row['fav_cat_type_id']);

                    $fav_cat_name = $obj->getsymtumNameRamakant($row['bmsid']);

                    

                    if($row['fav_parent_cat']!='')

                    {

                        $fav_cat_parent = $obj->getFavCategoryNameRamakant($row['fav_parent_cat']);

                    }

                    else

                    {

                        $fav_cat_parent = '';

                    }

                

                $output .= '<tr class="manage-row">';

                $output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

                $output .= '<td height="30" align="left"><strong>'.$fav_cat_name.'</strong></td>';

                $output .= '<td height="30" align="center"><strong>'.$fav_cat_type.'</strong></td>';

                $output .= '<td height="30" align="center"><strong>'.$fav_cat_parent.'</strong></td>';

                $output .= '<td height="30" align="center"><strong>'.$obj->getAdminNameRam($row['updated_by']).'</strong></td>';

                $output .= '<td height="30" align="center">'.$bms_status.'</td>';

                $output .= '<td height="30" align="center"><strong>'.$obj->getAdminNameRam($row['updated_by']).'</strong></td>';

                $output .= '<td height="30" align="center"><strong>'.date("d-m-Y",strtotime($row['add_date'])).'</strong></td>';

                $output .= '<td align="center" nowrap="nowrap">';

                        if($edit) {

                $output .= '<a href="index.php?mode=edit_main_symptom&id='.$row['id'].'" ><img src = "images/edit.gif" border="0"></a>';

                                        }

                $output .= '</td>';

                $output .= '<td align="center" nowrap="nowrap">';

                        if($delete) {

                $output .= '<a href=\'javascript:fn_confirmdelete("Symptom","sql/delmainsymptoms.php?id='.$row['id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

                                        }

                $output .= '</td>';

                $output .= '</tr>';

                $i++;

            }

        }

        else

        {

            $output = '<tr class="manage-row" height="20"><td colspan="6" align="center">NO RECORDS FOUND</td></tr>';

        }



        $page->get_page_nav();

        return $output;

    }

      

     public function getsymtumarrayRamakant($search) {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = array();		



            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";

            $sql = "SELECT `bms_id` FROM `tblbodymainsymptoms` WHERE `bms_status` = '1' AND `bms_deleted` = '0' AND `bms_name` LIKE '%".$search."%' ORDER BY `bms_id` ASC";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                  $option_str[] =  $row['bms_id'];

                }

            }

            return $option_str;   

        }

    

        public function getFavCategoryTypeName($fav_cat_type_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();



            $fav_cat_type = '';

            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` = '".$fav_cat_type_id."' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $fav_cat_type = stripslashes($row['prct_cat']);

            }

            return $fav_cat_type;

	}

        

        public function getFavCategoryNameRamakant($fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();



            $fav_cat_type = '';



            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $fav_cat_type = stripslashes($row['fav_cat']);

            }

            return $fav_cat_type;

	}

        

        public function getsymtumNameRamakant($fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $fav_cat_type = '';

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$fav_cat_id."' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $fav_cat_type = stripslashes($row['bms_name']);

            }

            return $fav_cat_type;

	}

        

         public function getKeywordsNameRamakant($fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $fav_cat_type = '';

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$fav_cat_id."' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $fav_cat_type = stripslashes($row['keywords']);

            }

            return $fav_cat_type;

	}

        

        public function getKeywordstotalcount($fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $fav_cat_type = array();

            $sql = "SELECT * FROM `tbl_symptom_keyword` WHERE `symptom_id`IN('".$fav_cat_id."') ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                $fav_cat_type[] = stripslashes($row['keywords']);

                }

            }

            return $fav_cat_type;

	}

          public function getKeywordsIdtotalcount($fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $fav_cat_type = array();

            $sql = "SELECT * FROM `tbl_symptom_keyword` WHERE `symptom_id`IN('".$fav_cat_id."') ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                $fav_cat_type[] = stripslashes($row['symptom_keyword_id']);

                }

            }

            return $fav_cat_type;

	}

      

    public function getMainSymptomDetailsRamakant($id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $fav_cat = '';

            $fav_cat_type_id = '';

            $fav_cat_status = '';



            //$sql = "SELECT * FROM `tblcustomfavcategory` WHERE `id` = '".$id."'";

            

           $sql = "SELECT tblsymtumscustomcategory.*,tblbodymainsymptoms.sol_item_id,tblbodymainsymptoms.bms_id,tblbodymainsymptoms.comment,tblbodymainsymptoms.sym_code,tblbodymainsymptoms.keywords,tblbodymainsymptoms.bms_status from tblsymtumscustomcategory "

                    . "JOIN tblbodymainsymptoms ON tblsymtumscustomcategory.bmsid = tblbodymainsymptoms.bms_id WHERE tblsymtumscustomcategory.id = '".$id."' ";

            

           //SELECT table1.*, table2.col1, table2.col3 FROM table1 JOIN table2 USING(id)

           

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $bms_name = $this->getsymtumNameRamakant($row['bmsid']);

                $symptom_id = $row['bmsid'];

                $fav_cat_type_id = stripslashes($row['fav_cat_type_id']);

                $fav_parent_cat = stripslashes($row['fav_parent_cat']);

                $keywords = stripslashes($row['keywords']);

                $symtum_status = stripslashes($row['symtum_status']);

                $show_hide = stripslashes($row['show_hide']);

                $comment = $row['comment'];

                $sym_code = $row['sym_code'];

                $sol_item_id = $row['sol_item_id'];

            }

            return array($sol_item_id,$sym_code,$bms_name,$symptom_id,$fav_cat_type_id,$fav_parent_cat,$keywords,$symtum_status,$show_hide,$comment);

	}

        

         public function getFavCategoryTypeOptions($fav_cat_type_id)

	{ 

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '';		



            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";

            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_status` = '1' AND `prct_cat_deleted` = '0' ORDER BY `prct_cat` ASC";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $option_str .='<option value="">Select Type</option>';

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                    if($row['prct_cat_id'] == $fav_cat_type_id)

                    {

                            $sel = ' selected ';

                    }

                    else

                    {

                            $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['prct_cat_id'].'" '.$sel.'>'.stripslashes($row['prct_cat']).' ('.$row['prct_cat_id'].')</option>';

                }

            }

            return $option_str;

	}

        public function getFavCategoryRamakant($fav_cat_type_id,$fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();



            $option_str = '';		

            //echo 'aaa->'.$fav_cat_type_id;

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";

           $sql = "SELECT * FROM `tblcustomfavcategory` "

                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$fav_cat_type_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            $option_str .= '<option value="">Select Category</option>';

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                    if($row['favcat_id'] == $fav_cat_id)

                    {

                            $sel = ' selected ';

                    }

                    else

                    {

                            $sel = '';

                    }	

                    $cat_name = $row['fav_cat'];

                    $option_str .= '<option value="'.$row['favcat_id'].'" '.$sel.'>'.stripslashes($cat_name).' ('.$row['favcat_id'].')</option>';

                }

            }

            //echo $option_str;

            

            return $option_str;

	}

        public function getShowHideOption($val,$type='1')

	{	

		$output = '';

		

		if($type == '2')

		{

			$output .= '<option value="" >All Options</option>';

		}

		else

		{

			$output .= '<option value="" >Select Option</option>';

		}

		

		

		if($val == '1' )

		{

			$selected = ' selected ';	

		}

		else

		{

			$selected = '';	

		}

		$output .= '<option value="1" '.$selected.'>Show</option>';

		

		if($val == '0' )

		{

			$selected = ' selected ';	

		}

		else

		{

			$selected = '';	

		}

		$output .= '<option value="0" '.$selected.'>Hide</option>';

					

		return $output;

	}

      

        public function getAdminNameRam($id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = '';

            

            $sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$id."' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $return = $row['fname'].' '.$row['lname'];

            }

            return $return;

	}

        

    //Ramakant code ended

    

//        start vivek

        

        public function getKeywordNameformBodySymptomVivek()

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $kw_name = array();		

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE 1 ORDER BY bms_name ASC";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                   

                    $kw_name[] = $row['bms_name'];

                }

            }

            

            $sql = "SELECT * FROM `tblcustomfavcategory` "

                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '16' and tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";

            $STH2 = $DBH->prepare($sql);

            $STH2->execute();

            if($STH2->rowCount() > 0)

            {

                while($row = $STH2->fetch(PDO::FETCH_ASSOC))

                {

                   

                    $kw_name[] = $row['fav_cat'];

                }

            }

           

            

            return $kw_name;

	}

        

        public function getKeywordIdformBodySymptomVivek($keyword_name)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $kw_name = '';		

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_name`='".$keyword_name."' ORDER BY bms_name ASC";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                {

                   

                    $kw_name = $row['bms_id'];

                }

            }

            

           

           

            

            return $kw_name;

	}

         public function getKeywordIdByNameVivek($keyword_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $kw_name = '';		

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id`='".$keyword_id."' ORDER BY bms_name ASC";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                {

                   

                    $kw_name = $row['bms_name'];

                }

            }

            

           

           

            

            return $kw_name;

	}

         public function getAllKeywordsNameVivek($fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $fav_cat_type = array();

            $sql = "SELECT * FROM `tbl_symptom_keyword` WHERE `symptom_id` = '".$fav_cat_id."' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                    $fav_cat_type[] = stripslashes($row['keywords']);

                }

            }

            return $fav_cat_type;

	}

         public function getKeywordsNameVivek($fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $fav_cat_type = '';

             $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN('".$fav_cat_id."') ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                $fav_cat_type[] = stripslashes($row['bms_name']);

                }

            }

            $bms_name_data= implode(',',$fav_cat_type);

            return $bms_name_data;

	}

        

        

        

         public function getKeywordNameformFavCatVivek($fav_cat_type_id_implode)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $kw_name = array();		



            $sql = "SELECT * FROM `tblcustomfavcategory` "

                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('".$fav_cat_type_id_implode."') and tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";

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

        

        public function getKeywordsNameByFavCarVivek($fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $fav_cat_type = array();

            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` IN('".$fav_cat_id."') ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                $fav_cat_type[] = stripslashes($row['fav_cat']);

                }

            }

            $bms_name_data= implode(',',$fav_cat_type);

            return $bms_name_data;

	}

         public function getKeywordIdformFavCatTableVivek($fav_cat)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $kw_name = '';		

            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat`='".$fav_cat."'";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                {

                   

                    $kw_name = $row['fav_cat_id'];

                }

            }

            

            return $kw_name;

	}

        

      public function getKeywordIdformBodymainsymtopTableVivek()

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $kw_name = array();		

           $sql = "SELECT * from tblsymtumscustomcategory ,tblbodymainsymptoms  WHERE tblsymtumscustomcategory.bmsid = tblbodymainsymptoms.bms_id and tblsymtumscustomcategory.fav_cat_type_id = '36' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                        

                {

                   

                    $kw_name[] = $row['bms_name'];

                    

                }

            }

            

           

           

            

            return $kw_name;

	}

        

      public function getKeywordIdformBodymainsymtopTableWithIdVivek()

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();



            $kw_name = array();		

            $sql = "SELECT * from tblsymtumscustomcategory ,tblbodymainsymptoms  WHERE tblsymtumscustomcategory.bmsid = tblbodymainsymptoms.bms_id and tblsymtumscustomcategory.fav_cat_type_id = '17' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                        

                {

                   

                    $kw_name[] = $row['bms_name'];

                }

            }

            

           

           

            

            return $kw_name;

	}   

//        public function getSymtumsCustomCategoryAllDataViveks($fav_cat_type_id)

//	{

//            $this->connectDB();

//            $option_str = array();		

//           $sql = "SELECT * FROM `tblsymtumscustomcategory` WHERE id ='".$fav_cat_type_id."' ";

//            $this->execute_query($sql);

//            if($this->numRows() > 0)

//            {

//               

//                while($row = $this->fetchRow())

//                {   

//                   $option_str[] = $row;

//                }

//            }

//            //echo $option_str;

//            

//            return $option_str;

//	}

        

     public function getBmsIdFromSymtumsCustomCategoryTableViveks($fav_cat_type_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '';		

            $sql = "SELECT * FROM `tblsymtumscustomcategory` WHERE id ='".$fav_cat_type_id."' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

               

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $option_str = $row['bmsid'];

               

            }

            //echo $option_str;

            

            return $option_str;

	}

       

public function getSymtumsCustomCategoryAllDataViveks($fav_cat_type_id,$id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = array();		

            $sql = "SELECT * FROM `tblsymtumscustomcategory` WHERE `bmsid` ='".$fav_cat_type_id."' and `id` != '".$id."' ";

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

  public function GetFecthData($canv_sub_cat_link,$cat_id)

        {

            $final_data = array();

          

            if($canv_sub_cat_link=='tbl_bodymainsymptoms')

            {

                //echo 'Hiii';

               $symtum_cat = $this->getAllMainSymptomsMyCanvas($cat_id);

               if(!empty($symtum_cat))

               {

                $final_data = $this->Getmycanvasdata($symtum_cat);

               }

            }

            

            if($canv_sub_cat_link=='tblsolutionitems')

            {

               

               //$symtum_cat = $this->getAllMainSymptomsRamakantFront($cat_id);

               $final_data = $this->Getmycanvassolutionitems($cat_id);

            }

            

            if($canv_sub_cat_link=='tbldailymealsfavcategory')

            {

                // echo 'Hiii';

               $symtum_cat = $this->getAllDailyMealsMyCanvas($cat_id); 

               if(!empty($symtum_cat))

               {

                $final_data = $this->Getmycanvasmealdata($symtum_cat);

               }

            }

            

            if($canv_sub_cat_link=='tbldailyactivity')

            {

               //$symtum_cat = $this->getAllDailyActivityMyCanvas($cat_id);

               $final_data = $this->GetmycanvasDailyActivitydata($cat_id);

            }

           

            

            if(count($final_data)>0)

            {

              $final_data = $final_data ;   

            }

            else

            {

               //$final_data[]= array(); 

                return $final_data;  

            }

          

            return $final_data;   

        }      

   

public function getAllMainSymptomsMyCanvas($symtum_cat)

    {       

        $DBH = new mysqlConnection();

        //$symtum_cat = implode($symtum_cat, '\',\'');

        $str_sql_search = " AND `fav_parent_cat` IN (".$symtum_cat.") ";

        $data = array();

       $sql = "SELECT DISTINCT bmsid FROM `tblsymtumscustomcategory` WHERE  symtum_deleted = '0' ".$str_sql_search." ORDER BY bmsid DESC ";		

        

        $STH = $DBH->query($sql);

        if( $STH->rowCount() > 0 )

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {           

                $data[] = $row['bmsid'];

            }

	}

	return $data;  

        

    }        

 

public function Getmycanvasdata($symtum_cat)

{

        $symtum_cat = implode(',', $symtum_cat);

        $DBH = new mysqlConnection();

	$option_str = array();

	$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE bms_id IN($symtum_cat) ORDER BY `bms_name` ASC";

	$STH = $DBH->query($sql);

        if( $STH->rowCount() > 0 )

        {



            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 



            {

                //$data = array();

                

                $option_str[]=$row['bms_name'];

            }

	}

	return $option_str;  

}    

 

public function Getmycanvassolutionitems($cat_id)

{

       //echo 'cat_id'.$cat_id; 

        //$symtum_cat = explode(',', $cat_id);

        //$symtum_cat = implode($symtum_cat, '\',\'');

        

       // echo 'cat_id'.$symtum_cat.'<br>'; 

        

        $DBH = new mysqlConnection();

        $str_sql_search = '';

        //$

        

       

        $option_str = array();

	$sql = "SELECT * FROM `tblsolutionitems` WHERE  sol_item_cat_id IN($cat_id) ORDER BY `sol_box_title` ASC";

	$STH = $DBH->query($sql);

        if( $STH->rowCount() > 0 )

        {



            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 



            {	     

                $option_str[]= $row['sol_box_desc'];



            }

	}

	return $option_str; 

        

}



public function GetCategoryNameByid($symtum_cat)

{

        

        $DBH = new mysqlConnection();

	$option_str = array();

	$sql = "SELECT * FROM `tblfavcategory` WHERE  fav_cat_id IN($symtum_cat) ORDER BY `fav_cat` ASC";

	$STH = $DBH->query($sql);

        if( $STH->rowCount() > 0 )

        {



            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 



            {

                $data = array();

                $data['activity_name'] = strip_tags($row['fav_cat']);

                $data['activity_id'] = $row['fav_cat_id'];

                $option_str[]=$data;

                

            }

	}

	return $option_str;     

}





    public function getAllDailyMealsMyCanvas($symtum_cat)

    {       

        $DBH = new mysqlConnection();

        //$symtum_cat = implode($symtum_cat, '\',\'');

        $str_sql_search = " AND `fav_cat_id` IN (".$symtum_cat.") ";

        $data = array();

        $sql = "SELECT DISTINCT meal_id FROM `tbldailymealsfavcategory` WHERE  show_hide = '1' ".$str_sql_search." ORDER BY meal_id DESC ";		

        

        $STH = $DBH->query($sql);

        if( $STH->rowCount() > 0 )

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {           

                $data[] = strip_tags($row['meal_id']);

            }

	}

	return $data;  

        

    }

    

public function Getmycanvasmealdata($symtum_cat)

{      

        $symtum_cat = implode(',', $symtum_cat);

        $DBH = new mysqlConnection();

       

	$option_str = array();

	$sql = "SELECT * FROM `tbldailymeals` WHERE meal_id IN($symtum_cat) ORDER BY `meal_item` ASC";

	$STH = $DBH->query($sql);

        if( $STH->rowCount() > 0 )

        {



            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            { 

                $option_str[]=$row['meal_item'];

            }

	}

	return $option_str;  

        

}



public function GetmycanvasDailyActivitydata($symtum_cat)

{      

        //echo $symtum_cat = implode(',', $symtum_cat);

    //echo $symtum_cat;

        $DBH = new mysqlConnection();

        

	$option_str = array();

        $sql = "SELECT * FROM `tbldailyactivity` WHERE (activity_category IN($symtum_cat) OR activity_level_code IN($symtum_cat)) ORDER BY `activity` ASC";

	$STH = $DBH->query($sql);

        if( $STH->rowCount() > 0 )

        {



            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 



            {

                   $option_str[] = $row['activity'];

            }

	}

	return $option_str;  

        

}





public function generateAutocompleteArray($teamArray){

	$jsTeamArray = "";

	

	$teamCount = count($teamArray);

	for($i=0; $i<$teamCount; $i++){

		$jsTeamArray.= $teamArray[$i].',';

	}

	//Removes the remaining comma so you don't get a blank autocomplete option.

	$jsTeamArray = substr($jsTeamArray, 0, -1);

        

	return $jsTeamArray;

}



public function getkeyworddata($bms_id)

{

        $DBH = new mysqlConnection();

        

	$data = array();

        $sql = "SELECT * FROM `tbl_symptom_keyword` WHERE `symptom_id` = '".$bms_id."' ";

	$STH = $DBH->query($sql);

        if( $STH->rowCount() > 0 )

        {



            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 



            {

                   $data[] = $row;

            }

	}

	return $data;   

}



public function getSymptomTypeOptionsRam($bmst_id)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $option_str = '';		



        $sql = "SELECT * FROM `tblbodymainsymptomtype` WHERE `bmst_deleted` = '0' AND `bmst_status` = '1'  ORDER BY `bmst_name` ASC";

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['bmst_id'] == $bmst_id)

                {

                    $sel = ' selected ';

                }

                else

                {

                    $sel = '';

                }

                

               

                $option_str .= '<option value="'.$row['bmst_id'].'" '.$sel.'>'.stripslashes($row['bmst_name']).'</option>';

            }

        }

        return $option_str;

    }

    

    public function getAdminDropdown($updated_by)

    {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $option_str = '';		



        $sql = "SELECT * FROM `tbladmin` WHERE `status` = '1' ORDER BY `username` ASC";

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['admin_id'] == $updated_by)

                {

                    $sel = ' selected ';

                }

                else

                {

                    $sel = '';

                }

                

               

                $option_str .= '<option value="'.$row['admin_id'].'" '.$sel.'>'.stripslashes($row['fname']).' '.stripslashes($row['lname']).'</option>';

            }

        }

        return $option_str;

    }

    

    public function getKeywordsbybmsid($bmsid) {

      

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $option_str = '';		



        $sql = "SELECT * FROM `tbl_symptom_keyword` WHERE `symptom_id` = '".$bmsid."' ORDER BY `keywords` ASC";

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $option_str .= $row['keywords'].',';

            }

            

            $option_str = rtrim($option_str,",");

        }

        return $option_str;

        

    }





}

?>