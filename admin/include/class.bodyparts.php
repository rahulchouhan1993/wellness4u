<?php
include_once("class.paging.php");
include_once("class.admin.php");
class BodyParts extends Admin
{
    public function getAllBodyParts($search,$bp_status,$bp_side,$bp_sex,$bp_parent_id)
    {
        $this->connectDB();

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
        $this->execute_query($sql);
        $total_records = $this->numRows();
        $record_per_page = 100;
        $scroll = 5;
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
        $page->set_link_parameter("Class = paging");
        $page->set_qry_string($str="mode=body_parts");
        $result=$this->execute_query($page->get_limit_query($sql));
        $output = '';		
        if($this->numRows() > 0)
        {
            if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )
            {
                $i = $page->start + 1;
            }
            else
            {
                $i = 1;
            }

            while($row = $this->fetchRow())
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
        $this->connectDB();

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
        $this->execute_query($sql);
        $total_records = $this->numRows();
        $record_per_page = 100;
        $scroll = 5;
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
        $page->set_link_parameter("Class = paging");
        $page->set_qry_string($str="mode=body_symptoms");
        $result=$this->execute_query($page->get_limit_query($sql));
        $output = '';		
        if($this->numRows() > 0)
        {
            if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )
            {
                $i = $page->start + 1;
            }
            else
            {
                $i = 1;
            }

            while($row = $this->fetchRow())
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
        $this->connectDB();

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
        $this->execute_query($sql);
        $total_records = $this->numRows();
        $record_per_page = 100;
        $scroll = 5;
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
        $page->set_link_parameter("Class = paging");
        $page->set_qry_string($str="mode=main_symptoms");
        $result=$this->execute_query($page->get_limit_query($sql));
        $output = '';		
        if($this->numRows() > 0)
        {
            if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )
            {
                $i = $page->start + 1;
            }
            else
            {
                $i = 1;
            }

            while($row = $this->fetchRow())
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
            $this->connectDB();
            $return = false;

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bmst_id` = '".$bmst_id."' AND `bms_name` = '".$bms_name."' AND `bms_deleted` = '0'";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $return = true;
            }
            return $return;
    }
    
    public function chkBMSNameExists_Edit($bms_name,$bms_id)
    {
            $this->connectDB();
            $return = false;

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` != '".$bms_id."' AND `bms_name` = '".$bms_name."' AND `bms_deleted` = '0'";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $return = true;
            }
            return $return;
    }

    public function addBodyPart($bp_name,$bp_side,$bp_sex,$bp_parent_id,$bp_image)
    {
        $this->connectDB();
        $return = false;

        $sql = "INSERT INTO `tblbodyparts` (`bp_name`,`bp_side`,`bp_sex`,`bp_parent_id`,`bp_image`,`bp_status`) "
                . "VALUES ('".addslashes($bp_name)."','".addslashes($bp_side)."','".addslashes($bp_sex)."','".addslashes($bp_parent_id)."','".addslashes($bp_image)."','1')";
        $this->execute_query($sql);
        if($this->result)
        {
            $return = true;
        }
        return $return;
    }
    
    public function addBodySymptom($bms_id,$bp_id,$bs_remarks,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment)
    {
        $this->connectDB();
        $return = false;

        $sql = "INSERT INTO `tblbodysymptoms` (`bms_id`,`bp_id`,`bs_remarks`,`bs_status`) "
                . "VALUES ('".addslashes($bms_id)."','".addslashes($bp_id)."','".addslashes($bs_remarks)."','1')";
        //echo'<br>'.$sql;
        $this->execute_query($sql);
        if($this->result)
        {
            $return = true;
            $bs_id = $this->getInsertID();
            for($i=0;$i<count($arr_min_rating);$i++)
            {
                $sql2 = "INSERT INTO `tblbodysymptomscales` (`bs_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`bss_status`) "
                        . "VALUES ('".addslashes($bs_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
                //echo'<br>'.$sql2;
                $this->execute_query($sql2);
            }	
        }
        return $return;
    }
    
    public function addMainSymptom($bms_name,$bmst_id)
    {
        $this->connectDB();
        $return = false;

        $sql = "INSERT INTO `tblbodymainsymptoms` (`bms_name`,`bmst_id`,`bms_status`) "
                . "VALUES ('".addslashes($bms_name)."','".addslashes($bmst_id)."','1')";
        //echo'<br>'.$sql;
        $this->execute_query($sql);
        if($this->result)
        {
            $return = true;
        }
        return $return;
    }
	
	
    public function getBodyPartDetails($bp_id)
    {
        $this->connectDB();
        $bp_name = '';
        $bp_side = '';
        $bp_sex = '';
        $bp_parent_id = '';
        $bp_image = '';
        $bp_status = '';
        
        $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_id` = '".$bp_id."' AND `bp_deleted` = '0'";
        $this->execute_query($sql);
        if($this->numRows() > 0)
        {
            $row = $this->fetchRow();
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
            $this->connectDB();
            $arr_min_rating = array();
            $arr_max_rating = array();
            $arr_interpretaion = array();
            $arr_treatment = array();
            $bms_id = '';
            $bp_id = '';
            $bs_remarks = '';
            $bs_status = '';

            $sql = "SELECT * FROM `tblbodysymptoms` WHERE `bs_id` = '".$bs_id."' AND `bs_deleted` = '0' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $bms_id = stripslashes($row['bms_id']);
                    $bp_id = stripslashes($row['bp_id']);
                    $bs_remarks = stripslashes($row['bs_remarks']);
                    $bs_status = stripslashes($row['bs_status']);

                    $sql2 = "SELECT * FROM `tblbodysymptomscales` WHERE `bs_id` = '".$bs_id."' AND `bss_deleted` = '0' ORDER BY `bss_id`";
                    $this->execute_query($sql2);
                    if($this->numRows() > 0)
                    {
                            while($row2 = $this->fetchRow())
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
            $this->connectDB();
            $bms_name = '';
            $bmst_id = '';
            $bms_status = '';

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$bms_id."' AND `bms_deleted` = '0' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $bms_name = stripslashes($row['bms_name']);
                    $bmst_id = stripslashes($row['bmst_id']);
                    $bms_status = stripslashes($row['bms_status']);
            }
            return array($bms_name,$bmst_id,$bms_status);
    }
	
    public function updateBodyPart($bp_name,$bp_side,$bp_sex,$bp_parent_id,$bp_image,$bp_status,$bp_id)
    {
        $this->connectDB();
        $return = false;

        $upd_sql = "UPDATE `tblbodyparts` SET "
                . "`bp_name` = '".addslashes($bp_name)."' , "
                . "`bp_side` = '".addslashes($bp_side)."' , "
                . "`bp_sex` = '".addslashes($bp_sex)."' , "
                . "`bp_parent_id` = '".addslashes($bp_parent_id)."' , "
                . "`bp_image` = '".addslashes($bp_image)."' , "
                . "`bp_status` = '".addslashes($bp_status)."'  "
                . "WHERE `bp_id` = '".$bp_id."'";
        $this->execute_query($upd_sql);
        if($this->result)
        {
            $return = true;
        }
        return $return;
    }
    
    public function updateBodySymptom($bms_id,$bp_id,$bs_remarks,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$status,$bs_id)
    {
        $this->connectDB();
        $return = false;

        $upd_sql = "UPDATE `tblbodysymptoms` SET "
                . "`bms_id` = '".addslashes($bms_id)."' , "
                . "`bp_id` = '".addslashes($bp_id)."' , "
                . "`bs_remarks` = '".addslashes($bs_remarks)."' , "
                . "`bs_status` = '".addslashes($status)."'  "
                . "WHERE `bs_id` = '".$bs_id."'";
        $this->execute_query($upd_sql);
        if($this->result)
        {
            $return = true;
            $del_sql1 = "UPDATE `tblbodysymptomscales` SET `bss_deleted` = '1' WHERE `bs_id` = '".$bs_id."'"; 
            $this->execute_query($del_sql1);
            for($i=0;$i<count($arr_min_rating);$i++)
            {
                $sql2 = "INSERT INTO `tblbodysymptomscales` (`bs_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`bss_status`) "
                        . "VALUES ('".addslashes($bs_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
                $this->execute_query($sql2);
            }	
        }
        return $return;
    }
    
    public function updateMainSymptom($cat_total_cnt1,$keywords,$symptom_keyword_id,$sym_code,$id,$bms_name,$keywordsold,$total_count,$comment,$hdnbmsid,$fav_cat_type_id,$fav_cat_id_parent,$show_hide,$symtum_status)
    {
        $this->connectDB();
        $return = false;

        $upd_sql = "UPDATE `tblbodymainsymptoms` SET "
                . "`bms_name` = '".addslashes($bms_name)."' , "
                . "`comment` = '".addslashes($comment)."' , "
                . "`sym_code` = '".addslashes($sym_code)."' , "
                . "`keywords` = '".addslashes($keywordsold)."', "
                . "`posted_by` = '".$_SESSION['admin_id']."' "
                . "WHERE `bms_id` = '".$hdnbmsid."'";
        $this->execute_query($upd_sql);
        $upd_sql = "UPDATE `tblsymtumscustomcategory` SET `fav_cat_type_id` = '".addslashes($fav_cat_type_id)."', `fav_parent_cat` = '".$fav_cat_id_parent."' ,`show_hide` = '".addslashes($show_hide)."' , `symtum_status` ='".$symtum_status."' ,`updated_by` = '".$_SESSION['admin_id']."' WHERE `id` = '".$id."'";
        $this->execute_query($upd_sql);
        
        for($i=0;$i<$total_count;$i++)
        {
            $keywords_data = $this->getKeywordIdformFavCatTableVivek($keywordsold[$i]);	
          $upd_sql = "UPDATE `tbl_symptom_keyword` SET `keywords` = '".$keywords_data."' WHERE `symptom_keyword_id` = '".$symptom_keyword_id[$i]."'";
          $this->execute_query($upd_sql);
        }
        
        if($keywords[1]!='')
        {
         
         if(count($cat_total_cnt1) > 0)
            {
                for($j=1; $j<$cat_total_cnt1; $j++)
                { 
                      
                        $tdata_cat = array();
                        
                        $tdata_cat['symptom_id'] = $hdnbmsid;
                       
                      $keywords_data = $this->getKeywordIdformFavCatTableVivek($keywords[$j]);	
                     
                        
                        $this->addKeywordcustomSymptom($tdata_cat,$keywords_data);	

                }
                
            }
        }
            
        if($this->result)
        {
            $return = true;
        }
        return $return;
    }
	
    public function deleteBodyPart($bp_id)
    {
        $this->connectDB();
        $del_sql1 = "UPDATE `tblbodyparts` SET `bp_deleted` = '1' WHERE `bp_id` = '".$bp_id."'"; 
        $this->execute_query($del_sql1);
        return $this->result;
    }
    
    public function deleteBodySymptom($bs_id)
    {
        $this->connectDB();
        $del_sql1 = "UPDATE `tblbodysymptoms` SET `bs_deleted` = '1' WHERE `bs_id` = '".$bs_id."'"; 
        $this->execute_query($del_sql1);
        return $this->result;
    }
    
    public function deleteMainSymptom($bms_id)
    {
        $this->connectDB();
        $del_sql1 = "UPDATE `tblbodymainsymptoms` SET `bms_deleted` = '1' WHERE `bms_id` = '".$bms_id."'"; 
        $this->execute_query($del_sql1);
        return $this->result;
    }
	
    public function deleteMainSymptomRamakant($id)
	{
            $this->connectDB();
            $del_sql1 = "UPDATE `tblsymtumscustomcategory` SET `symtum_deleted` = '1' WHERE `id` = '".$id."'"; 
            $this->execute_query($del_sql1);
            return $this->result;
	}
    
    public function getMainBodyPartsOptions($bp_id,$bp_parent_id)
    {
        $this->connectDB();
        $option_str = '';		

        $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_parent_id` = '".$bp_parent_id."' AND `bp_deleted` = '0' AND `bp_status` = '1'  ORDER BY `bp_name` ASC";
        $this->execute_query($sql);
        if($this->numRows() > 0)
        {
            while($row = $this->fetchRow()) 
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
        $this->connectDB();
        $option_str = '';		

        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_deleted` = '0' AND `bms_status` = '1'  ORDER BY `bms_name` ASC";
        $this->execute_query($sql);
        if($this->numRows() > 0)
        {
            while($row = $this->fetchRow()) 
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
        $this->connectDB();
        $option_str = '';		

        $sql = "SELECT * FROM `tblbodymainsymptomtype` WHERE `bmst_deleted` = '0' AND `bmst_status` = '1'  ORDER BY `bmst_name` ASC";
        $this->execute_query($sql);
        if($this->numRows() > 0)
        {
            while($row = $this->fetchRow()) 
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
        $this->connectDB();
        $output = '';		

        $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_parent_id` = '".$bp_parent_id."' AND `bp_deleted` = '0' AND `bp_status` = '1'  ORDER BY `bp_name` ASC";
        $this->execute_query($sql);
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
        if($this->numRows() > 0)
        {
            while($row = $this->fetchRow()) 
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
        $this->connectDB();
        $option_str = '';		

        $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_parent_id` = '".$bp_parent_id."' AND `bp_deleted` = '0' AND `bp_status` = '1'  ORDER BY `bp_name` ASC";
        $this->execute_query($sql);
        if($this->numRows() > 0)
        {
            while($row = $this->fetchRow()) 
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
        $this->connectDB();

        $bp_name = '';

        $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_id` = '".$bp_id."'";
        $this->execute_query($sql);
        if($this->numRows() > 0)
        {
                $row = $this->fetchRow();
                $bp_name = stripslashes($row['bp_name']);
        }
        return $bp_name;
    }
    
    //Ramakant code started
     public function getPageCatDropdownModulesOptions($pag_id)
	{
            $this->connectDB();
            $option_str = '';		

            $sql = "SELECT * FROM `tbladminmenu` WHERE 1 ORDER BY `menu_name` ASC";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow()) 
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
            $this->connectDB();
            $option_str = '';		
            //echo 'aaa->'.$fav_cat_type_id;
            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
           $sql = "SELECT * FROM `tblkeywords` WHERE kw_status = 1 ORDER BY kw_name ASC";
            //echo $sql;
            $this->execute_query($sql);
            $option_str .= '<option value="">Select Category</option>';
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
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
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tblkeywords` WHERE `kw_name` = '".$interpretaionname."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['kw_id'];
            }
            return $return;
	}
        
         public function getIdByKeywordsName($kw_name)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tblkeywords` WHERE `kw_id` = '".$kw_name."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['kw_name'];
            }
            return $return;
	}
	    
    public function addMainSymptomRamakant($keywords,$cat_total_cnt1,$daily_code,$bms_name,$comment,$show_hide,$arr_cucat_parent_cat_id,$arr_cucat_cat_id,$cat_total_cnt)
    {
        
        $this->connectDB();
        $return = false;
        
        $bmsid = $this->getSymptomidbyname($bms_name);
            
            if($bmsid > 0)
            {
              $bmsid = $bmsid;  
            }
            else
            {
                $sql = "INSERT INTO `tblbodymainsymptoms` (`sym_code`,`bms_name`,`comment`,`bms_status`,`posted_by`) "
                        . "VALUES ('".addslashes($daily_code)."','".addslashes($bms_name)."','".  addslashes($comment)."','1','".$_SESSION['admin_id']."')";
                //echo'<br>'.$sql;
                $this->execute_query($sql);
                $bmsid = $this->getInsertID();
            }
        
        
        if($this->result)
        {
            $return = true;
        }
        
        if(count($cat_total_cnt) > 0)
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
        if(count($cat_total_cnt1) > 0)
            {
                for($j=0; $j<$cat_total_cnt1; $j++)
                { 
                       
                        $tdata_cat = array();
                        
                        $tdata_cat['symptom_id'] = $bmsid;
                        $keywords_data = $this->getKeywordIdformFavCatTableVivek($keywords[$j]);	
                         
                        
//                        $tdata_cat['fav_cat_status'] = 1;
                        $this->addKeywordcustomSymptom($tdata_cat,$keywords_data);	
//                    $sql2 = "INSERT INTO `tbl_symptom_keyword` (`symptom_id`,`keywords`) VALUES ('".addslashes($tdata_cat['symptom_id'])."','".addslashes($tdata_cat['keywords'])."')";
//                    die();
//                    $this->execute_query($sql2);
//                    return $this->result;
                }
                
                    
            }
           
                
            
        return $return;
    }
    
      public function addKeywordcustomSymptom($tdata_cat,$keywords_data)
              {
          
            $this->connectDB();
            //$return = false;
            $sql = "INSERT INTO `tbl_symptom_keyword` (`symptom_id`,`keywords`) VALUES ('".addslashes($tdata_cat['symptom_id'])."','".$keywords_data."')";
            $this->execute_query($sql); 
            return $this->result;
        }
    public function addcustomSymptom($tdata_cat) {
          
            $this->connectDB();
            //$return = false;
            $sql = "INSERT INTO `tblsymtumscustomcategory` (`bmsid`,`fav_cat_type_id`,`fav_parent_cat`,`show_hide`,`updated_by`) VALUES ('".addslashes($tdata_cat['bmsid'])."','".addslashes($tdata_cat['fav_cat_type_id'])."','".addslashes($tdata_cat['fav_parent_cat'])."','".addslashes($tdata_cat['show_hide'])."','".$_SESSION['admin_id']."')";
            $this->execute_query($sql); 
            return $this->result;
        }
        
        public function getSymptomidbyname($bms_name) {
                $this->connectDB();
		$sw_header = '';
		$sql = "SELECT `bms_id` FROM `tblbodymainsymptoms` WHERE `bms_name` = '".$bms_name."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$sw_header = stripslashes($row['bms_id']);
		}
		return $sw_header;   
        }
        
    public function getSymCodeNameById($bmsid)
            {
                $this->connectDB();

                $return = '';

                $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$bmsid."' ";
                $this->execute_query($sql);
                if($this->numRows() > 0)
                {
                    $row = $this->fetchRow();
                    $return = $row['sym_code'];
                }
                return $return;
            }        
    public function getAllMainSymptomsRamakant($search,$bms_status,$bmst_id)
    {
        $this->connectDB();
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
        
        $sql = "SELECT * FROM `tblsymtumscustomcategory`,`tblbodymainsymptoms` WHERE tblsymtumscustomcategory.bmsid = tblbodymainsymptoms.bms_id and symtum_deleted = '0' ".$str_sql_search." ".$str_sql_status." ".$str_sql_bmst_id." ORDER BY tblbodymainsymptoms.bms_name ASC ";		
        
        $this->execute_query($sql);
        $total_records = $this->numRows();
        $record_per_page = 100;
        $scroll = 5;
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
        $page->set_link_parameter("Class = paging");
        $page->set_qry_string($str="mode=main_symptoms");
        $result=$this->execute_query($page->get_limit_query($sql));
        $output = '';		
        if($this->numRows() > 0)
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
            
            while($row = $this->fetchRow())
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
                $output .= '<td height="30" align="center"><strong>'.$obj->getSymCodeNameById($row['bmsid']).'</strong></td>';
                $output .= '<td height="30" align="left"><strong>'.$fav_cat_name.'</strong></td>';
                $output .= '<td height="30" align="center"><strong>'.$fav_cat_type.'</strong></td>';
                $output .= '<td height="30" align="center"><strong>'.$fav_cat_parent.'</strong></td>';
                $output .= '<td height="30" align="center"><strong>'.$obj->getKeywordsNameByFavCarVivek($keywords_data_implode).'</strong></td>';
                $output .= '<td height="30" align="center">'.$bms_status.'</td>';
                $output .= '<td height="30" align="center"><strong>'.$obj->getAdminNameRam($row['updated_by']).'</strong></td>';
                $output .= '<td height="30" align="center"><strong>'.date("d-m-Y h:i:s",strtotime($row['add_date'])).'</strong></td>';
                $output .= '<td height="30" align="center">';
                 if($sol_item_id==0)
                    {
                      
                       $output .= '<a href="index.php?mode=add_wellness_solution_item&image_id='.$row['bms_id'].'&name=main_symptoms" ><img src = "images/sidebox_icon_pages.gif" border="0"></a>';
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
    
    
     public function getSolItemIdRamakant($fav_cat_id)
	{
            $this->connectDB();

            $fav_cat_type = '';

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$fav_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $fav_cat_type = stripslashes($row['sol_item_id']);
            }
            return $fav_cat_type;
	}
        
     public function getAllMainSymptomsRamakantOld($search,$bms_status,$bmst_id)
    {
        $this->connectDB();
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
        
        $this->execute_query($sql);
        $total_records = $this->numRows();
        $record_per_page = 100;
        $scroll = 5;
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
        $page->set_link_parameter("Class = paging");
        $page->set_qry_string($str="mode=main_symptoms");
        $result=$this->execute_query($page->get_limit_query($sql));
        $output = '';		
        if($this->numRows() > 0)
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
            
            while($row = $this->fetchRow())
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
            $this->connectDB();
            $option_str = array();		

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT `bms_id` FROM `tblbodymainsymptoms` WHERE `bms_status` = '1' AND `bms_deleted` = '0' AND `bms_name` LIKE '%".$search."%' ORDER BY `bms_id` ASC";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                  $option_str[] =  $row['bms_id'];
                }
            }
            return $option_str;   
        }
    
        public function getFavCategoryTypeName($fav_cat_type_id)
	{
            $this->connectDB();

            $fav_cat_type = '';
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` = '".$fav_cat_type_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $fav_cat_type = stripslashes($row['prct_cat']);
            }
            return $fav_cat_type;
	}
        
        public function getFavCategoryNameRamakant($fav_cat_id)
	{
            $this->connectDB();

            $fav_cat_type = '';

            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $fav_cat_type = stripslashes($row['fav_cat']);
            }
            return $fav_cat_type;
	}
        
        public function getsymtumNameRamakant($fav_cat_id)
	{
            $this->connectDB();
            $fav_cat_type = '';
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$fav_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $fav_cat_type = stripslashes($row['bms_name']);
            }
            return $fav_cat_type;
	}
        
         public function getKeywordsNameRamakant($fav_cat_id)
	{
            $this->connectDB();
            $fav_cat_type = '';
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$fav_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $fav_cat_type = stripslashes($row['keywords']);
            }
            return $fav_cat_type;
	}
        
        public function getKeywordstotalcount($fav_cat_id)
	{
            $this->connectDB();
            $fav_cat_type = array();
            $sql = "SELECT * FROM `tbl_symptom_keyword` WHERE `symptom_id`IN('".$fav_cat_id."') ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                $fav_cat_type[] = stripslashes($row['keywords']);
                }
            }
            return $fav_cat_type;
	}
          public function getKeywordsIdtotalcount($fav_cat_id)
	{
            $this->connectDB();
            $fav_cat_type = array();
            $sql = "SELECT * FROM `tbl_symptom_keyword` WHERE `symptom_id`IN('".$fav_cat_id."') ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                $fav_cat_type[] = stripslashes($row['symptom_keyword_id']);
                }
            }
            return $fav_cat_type;
	}
        
//        public function getMainSymptomDetailsRamakant($bms_id)
//    {
//            $this->connectDB();
//            $bms_name = '';
//            $bmst_id = '';
//            $bms_status = '';
//
//            $sql = "SELECT * FROM `tblsymtumscustomcategory` WHERE `id` = '".$bms_id."' AND `symtum_deleted` = '0' ";
//            $this->execute_query($sql);
//            if($this->numRows() > 0)
//            {
//                    $row = $this->fetchRow();
//                    $bms_id = stripslashes($row['bmsid']);
//                    $fav_cat_type_id = stripslashes($row['fav_cat_type_id']);
//                    $fav_parent_cat = stripslashes($row['fav_parent_cat']);
//                    $show_hide = stripslashes($row['show_hide']);
//            }
//            return array($bms_id,$fav_cat_type_id,$fav_parent_cat,$show_hide);
//    }
    
    public function getMainSymptomDetailsRamakant($id)
	{
            $this->connectDB();
            $fav_cat = '';
            $fav_cat_type_id = '';
            $fav_cat_status = '';

            //$sql = "SELECT * FROM `tblcustomfavcategory` WHERE `id` = '".$id."'";
            
           $sql = "SELECT tblsymtumscustomcategory.*,tblbodymainsymptoms.bms_id,tblbodymainsymptoms.comment,tblbodymainsymptoms.sym_code,tblbodymainsymptoms.keywords,tblbodymainsymptoms.bms_status from tblsymtumscustomcategory "
                    . "JOIN tblbodymainsymptoms ON tblsymtumscustomcategory.bmsid = tblbodymainsymptoms.bms_id WHERE tblsymtumscustomcategory.id = '".$id."' ";
            
           //SELECT table1.*, table2.col1, table2.col3 FROM table1 JOIN table2 USING(id)
           
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $bms_name = $this->getsymtumNameRamakant($row['bmsid']);
                $bmsid = $row['bmsid'];
                $fav_cat_type_id = stripslashes($row['fav_cat_type_id']);
                $fav_parent_cat = stripslashes($row['fav_parent_cat']);
                $keywords = stripslashes($row['keywords']);
                $symtum_status = stripslashes($row['symtum_status']);
                $show_hide = stripslashes($row['show_hide']);
                $comment = $row['comment'];
                $sym_code = $row['sym_code'];
            }
            return array($sym_code,$bms_name,$bmsid,$fav_cat_type_id,$fav_parent_cat,$keywords,$symtum_status,$show_hide,$comment);
	}
        
         public function getFavCategoryTypeOptions($fav_cat_type_id)
	{ 
            $this->connectDB();
            $option_str = '';		

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_status` = '1' AND `prct_cat_deleted` = '0' ORDER BY `prct_cat` ASC";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $option_str .='<option value="">Select Type</option>';
                while($row = $this->fetchRow())
                {
                    if($row['prct_cat_id'] == $fav_cat_type_id)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['prct_cat_id'].'" '.$sel.'>'.stripslashes($row['prct_cat']).'</option>';
                }
            }
            return $option_str;
	}
        public function getFavCategoryRamakant($fav_cat_type_id,$fav_cat_id)
	{
            $this->connectDB();
            $option_str = '';		
            //echo 'aaa->'.$fav_cat_type_id;
            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$fav_cat_type_id."' and tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
            //echo $sql;
            $this->execute_query($sql);
            $option_str .= '<option value="">Select Category</option>';
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
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
                    $option_str .= '<option value="'.$row['favcat_id'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
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
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['fname'].' '.$row['lname'];
            }
            return $return;
	}
        
    //Ramakant code ended
    
//        start vivek
        
        public function getKeywordNameformBodySymptomVivek()
	{
            $this->connectDB();
            $kw_name = array();		
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE 1 ORDER BY bms_name ASC";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                   
                    $kw_name[] = $row['bms_name'];
                }
            }
            
            $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '16' and tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                   
                    $kw_name[] = $row['fav_cat'];
                }
            }
           
            
            return $kw_name;
	}
        
        public function getKeywordIdformBodySymptomVivek($keyword_name)
	{
            $this->connectDB();
            $kw_name = '';		
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_name`='".$keyword_name."' ORDER BY bms_name ASC";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                {
                   
                    $kw_name = $row['bms_id'];
                }
            }
            
           
           
            
            return $kw_name;
	}
         public function getKeywordIdByNameVivek($keyword_id)
	{
            $this->connectDB();
            $kw_name = '';		
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id`='".$keyword_id."' ORDER BY bms_name ASC";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                {
                   
                    $kw_name = $row['bms_name'];
                }
            }
            
           
           
            
            return $kw_name;
	}
         public function getAllKeywordsNameVivek($fav_cat_id)
	{
            $this->connectDB();
            $fav_cat_type = '';
            $sql = "SELECT * FROM `tbl_symptom_keyword` WHERE `symptom_id` = '".$fav_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                $fav_cat_type[] = stripslashes($row['keywords']);
                }
            }
            return $fav_cat_type;
	}
         public function getKeywordsNameVivek($fav_cat_id)
	{
            $this->connectDB();
            $fav_cat_type = '';
             $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN('".$fav_cat_id."') ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                $fav_cat_type[] = stripslashes($row['bms_name']);
                }
            }
            $bms_name_data= implode(',',$fav_cat_type);
            return $bms_name_data;
	}
        
         public function getKeywordNameformFavCatVivek($fav_cat_type_id_implode)
	{
            $this->connectDB();
            $kw_name = array();		

            $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('".$fav_cat_type_id_implode."') and tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                   
                    $kw_name[] = $row['fav_cat'];
                }
            }
           
            
            return $kw_name;
	}
        
        public function getKeywordsNameByFavCarVivek($fav_cat_id)
	{
            $this->connectDB();
            $fav_cat_type = '';
             $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` IN('".$fav_cat_id."') ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                $fav_cat_type[] = stripslashes($row['fav_cat']);
                }
            }
            $bms_name_data= implode(',',$fav_cat_type);
            return $bms_name_data;
	}
         public function getKeywordIdformFavCatTableVivek($fav_cat)
	{
            $this->connectDB();
            $kw_name = '';		
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat`='".$fav_cat."'";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                {
                   
                    $kw_name = $row['fav_cat_id'];
                }
            }
            
           
           
            
            return $kw_name;
	}
        
      public function getKeywordIdformBodymainsymtopTableVivek()
	{
            $this->connectDB();
            $kw_name = '';		
          $sql = "SELECT * from tblsymtumscustomcategory ,tblbodymainsymptoms  WHERE tblsymtumscustomcategory.bmsid = tblbodymainsymptoms.bms_id and tblsymtumscustomcategory.fav_cat_type_id = '36' ";
          $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                        
                {
                   
                    $kw_name[] = $row['bms_name'];
                }
            }
            
           
           
            
            return $kw_name;
	}
        
      public function getKeywordIdformBodymainsymtopTableWithIdVivek()
	{
            $this->connectDB();
            $kw_name = '';		
          $sql = "SELECT * from tblsymtumscustomcategory ,tblbodymainsymptoms  WHERE tblsymtumscustomcategory.bmsid = tblbodymainsymptoms.bms_id and tblsymtumscustomcategory.fav_cat_type_id = '17' ";
         $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                        
                {
                   
                    $kw_name[] = $row['bms_name'];
                }
            }
            
           
           
            
            return $kw_name;
	}   
//    vivek end
}
?>