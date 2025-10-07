<?php
include_once("class.paging.php");
include_once("class.admin.php");
class Keywords extends Admin
{
    
   
     public function getKeywordPageNameId($keywords_id)
            {
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $meal_item = '';

                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
                $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` ='".$keywords_id."' ";
               $STH = $DBH->prepare($sql); 
               $STH->execute();
                if($STH->rowCount() > 0)
                {
                   
                   $row = $STH->fetch(PDO::FETCH_ASSOC);
                    $meal_item = $row['page_id_str'];
                   
                }
                //print_r($meal_item) ;
                
                
                return $meal_item;
                
            }    
        
        public function getAllFunction($search,$status,$kw_module_type)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $admin_id = $_SESSION['admin_id'];
        $edit_action_id = '237';
        $delete_action_id = '238';
        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

        if($search == '')
        {
            $str_sql_search = "";
        }
        else
        {
            $str_sql_search = " AND `kw_name` LIKE '%".$search."%' ";
        }

        if($status == '')
        {
            $str_sql_status = "";
        }
        else
        {
            $str_sql_status = " AND `kw_status` = '".$status."' ";
        }
        
        if($kw_module_type == '')
        {
            $str_sql_kw_module_type = "";
        }
        else
        {
            $str_sql_kw_module_type = " AND `kw_module_type` = '".$kw_module_type."' ";
        }

        $sql = "SELECT * FROM `tblkeywords` WHERE `kw_deleted` = '0' ".$str_sql_search."  ".$str_sql_status." ".$str_sql_kw_module_type."  ORDER BY `kw_name` ASC , `kw_add_date` DESC";		
        //echo '<br>'.$sql;
       $STH = $DBH->prepare($sql);
       $STH->execute();
        $total_records = $STH->rowCount();
        $record_per_page = 100;
        $scroll = 5;
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
        $page->set_link_parameter("Class = paging");
        $page->set_qry_string($str="mode=keywords_master&kw_module_type=".$kw_module_type."&status=".$status."&search=".urlencode($search));
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
                if($row['kw_status'] == '1')
                {
                    $status = 'Active';
                }
                else
                {
                    $status = 'Inactive';
                }
                
                $date_value = date('d-m-Y',strtotime($row['kw_add_date']));

                $output .= '<tr class="manage-row">';
                $output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
                $output .= '<td height="30" align="center">'.stripslashes($row['kw_name']).'</td>';
                $output .= '<td height="30" align="center">'.stripslashes($row['kw_module_type']).'</td>';
                $output .= '<td height="30" align="center">'.$status.'</td>';
                $output .= '<td align="center" nowrap="nowrap">';
                if($edit) {
                $output .= '<a href="index.php?mode=edit_function_name&id='.$row['kw_id'].'" ><img src = "images/edit.gif" border="0"></a>';
                }
                $output .= '</td>';
                $output .= '<td align="center" nowrap="nowrap">';
                if($delete) {
                $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delkeyword.php?id='.$row['kw_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
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
    public function getAllKeywords($search,$status,$kw_module_type)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $admin_id = $_SESSION['admin_id'];
        $edit_action_id = '237';
        $delete_action_id = '238';
        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

        if($search == '')
        {
            $str_sql_search = "";
        }
        else
        {
            $str_sql_search = " AND `kw_name` LIKE '%".$search."%' ";
        }

        if($status == '')
        {
            $str_sql_status = "";
        }
        else
        {
            $str_sql_status = " AND `kw_status` = '".$status."' ";
        }
        
        if($kw_module_type == '')
        {
            $str_sql_kw_module_type = "";
        }
        else
        {
            $str_sql_kw_module_type = " AND `kw_module_type` = '".$kw_module_type."' ";
        }

        $sql = "SELECT * FROM `tblkeywords` WHERE `kw_deleted` = '0' ".$str_sql_search."  ".$str_sql_status." ".$str_sql_kw_module_type."  ORDER BY `kw_name` ASC , `kw_add_date` DESC";		
        //echo '<br>'.$sql;
       $STH = $DBH->prepare($sql); 
       $STH->execute();
        $total_records = $STH->rowCount();
        $record_per_page = 100;
        $scroll = 5;
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
        $page->set_link_parameter("Class = paging");
        $page->set_qry_string($str="mode=keywords_master&kw_module_type=".$kw_module_type."&status=".$status."&search=".urlencode($search));
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
                if($row['kw_status'] == '1')
                {
                    $status = 'Active';
                }
                else
                {
                    $status = 'Inactive';
                }
                
                $date_value = date('d-m-Y',strtotime($row['kw_add_date']));

                $output .= '<tr class="manage-row">';
                $output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
                $output .= '<td height="30" align="center">'.stripslashes($row['kw_name']).'</td>';
                $output .= '<td height="30" align="center">'.stripslashes($row['kw_module_type']).'</td>';
                $output .= '<td height="30" align="center">'.$status.'</td>';
                $output .= '<td align="center" nowrap="nowrap">';
                if($edit) {
                $output .= '<a href="index.php?mode=edit_keyword&id='.$row['kw_id'].'" ><img src = "images/edit.gif" border="0"></a>';
                }
                $output .= '</td>';
                $output .= '<td align="center" nowrap="nowrap">';
                if($delete) {
                $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delkeyword.php?id='.$row['kw_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
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
        
    public function addKeyword($kw_name,$kw_module_type = '',$kw_module_id = '0')
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;

        $updated_on_date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `tblkeywords` (`kw_name`,`kw_module_id`,`kw_module_type`,`kw_status`) "
                . "VALUES ('".addslashes($kw_name)."','".$kw_module_id."','".addslashes($kw_module_type)."','1')";
       $STH = $DBH->prepare($sql); 
       $STH->execute();
        if($STH->result)
        {
            $return = true;
        }
        return $return;
    }
        
    public function updateKeyword($kw_id,$kw_name,$kw_module_type,$kw_status)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $updated_on_date = date('Y-m-d H:i:s');

        $sql = "UPDATE `tblkeywords` SET "
                . "`kw_name` = '".addslashes($kw_name)."' ,"
                . "`kw_module_type` = '".addslashes($kw_module_type)."' ,"
                . "`kw_status` = '".addslashes($kw_status)."' "
                . "WHERE `kw_id` = '".$kw_id."'";
        //echo $sql;
       $STH = $DBH->prepare($sql); 
       $STH->execute();
        if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
    }
        
    public function getKeywordDetails($kw_id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $arr_records = array();
        
        $sql = "SELECT * FROM `tblkeywords` WHERE `kw_id` = '".$kw_id."' AND `kw_deleted` = '0' ";
        //echo $sql;
       $STH = $DBH->prepare($sql); 
       $STH->execute();
        if($STH->rowCount() > 0)
        {
           $row = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_records = $row;
        }
        return $arr_records;
    }
        
       
        
    public function deleteKeyword($kw_id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "UPDATE `tblkeywords` SET "
                . "`kw_deleted` = '1' "
                . "WHERE `kw_id` = '".$kw_id."'";
        //echo $sql;
       $STH = $DBH->prepare($sql);
       $STH->execute();
        if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
    }
	
    public function getKeywordName($kw_id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $kw_name = '';

        $sql = "SELECT * FROM `tblkeywords` WHERE `kw_id` = '".$kw_id."' AND `kw_deleted` = '0' ";
        //echo $sql;
       $STH = $DBH->prepare($sql); 
       $STH->execute();
        if($STH->rowCount() > 0)
        {
           $row = $STH->fetch(PDO::FETCH_ASSOC);
            $kw_name = stripslashes($row['kw_name']);
        }
        return  $kw_name;
    }
    
    public function chkKeywordExists($kw_name)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;

        $sql = "SELECT * FROM `tblkeywords` WHERE `kw_name` = '".addslashes($kw_name)."' AND `kw_deleted` = '0' ";
        //echo $sql;
       $STH = $DBH->prepare($sql); 
       $STH->execute();
        if($STH->rowCount() > 0)
        {
           $row = $STH->fetch(PDO::FETCH_ASSOC);
            $return = true;
        }
        return  $return;
    }
    
    public function chkKeywordExists_Edit($kw_name,$kw_id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;

        $sql = "SELECT * FROM `tblkeywords` WHERE `kw_name` = '".addslashes($kw_name)."' AND `kw_id` != '".$kw_id."' AND `kw_deleted` = '0' ";
        //echo $sql;
       $STH = $DBH->prepare($sql); 
       $STH->execute();
        if($STH->rowCount() > 0)
        {
           $row = $STH->fetch(PDO::FETCH_ASSOC);
            $return = true;
        }
        return  $return;
    }
    
    public function importModuleEntriesToKeyords($module_type)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        
        if($module_type == 'Food')
        {
            $sql = "SELECT * FROM `tbldailymeals` ORDER BY `meal_item` ";
            //echo $sql;
           $STH = $DBH->prepare($sql); 
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                $obj2 = new Keywords();
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $kw_name = stripslashes($row['meal_item']);

                    if($kw_name == '')
                    {

                    }
                    elseif($obj2->chkKeywordExists($kw_name))
                    {

                    }
                    else
                    {
                        if($obj2->addKeyword($kw_name,$module_type,$row['meal_id']))
                        {
                            $return = true;
                        }
                    } 
                }
                
            }
        }
        elseif($module_type == 'Activity')
        {
            $sql = "SELECT * FROM `tbldailyactivity` ORDER BY `activity` ";
            //echo $sql;
           $STH = $DBH->prepare($sql);
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                $obj2 = new Keywords();
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $kw_name = stripslashes($row['activity']);

                    if($kw_name == '')
                    {

                    }
                    elseif($obj2->chkKeywordExists($kw_name))
                    {

                    }
                    else
                    {
                        if($obj2->addKeyword($kw_name,$module_type,$row['activity_id']))
                        {
                            $return = true;
                        }
                    } 
                }
                
            }
        }
        elseif($module_type == 'Additions')
        {
            $sql = "SELECT * FROM `tbladdictions` ORDER BY `situation` ";
            //echo $sql;
           $STH = $DBH->prepare($sql);
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                $obj2 = new Keywords();
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $kw_name = stripslashes($row['situation']);

                    if($kw_name == '')
                    {

                    }
                    elseif($obj2->chkKeywordExists($kw_name))
                    {

                    }
                    else
                    {
                        if($obj2->addKeyword($kw_name,$module_type,$row['adct_id']))
                        {
                            $return = true;
                        }
                    } 
                }
                
            }
        }
        elseif($module_type == 'Sleep')
        {
            $sql = "SELECT * FROM `tblsleeps` ORDER BY `situation` ";
            //echo $sql;
           $STH = $DBH->prepare($sql);
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                $obj2 = new Keywords();
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $kw_name = stripslashes($row['situation']);

                    if($kw_name == '')
                    {

                    }
                    elseif($obj2->chkKeywordExists($kw_name))
                    {

                    }
                    else
                    {
                        if($obj2->addKeyword($kw_name,$module_type,$row['sleep_id']))
                        {
                            $return = true;
                        }
                    } 
                }
                
            }
        }
        elseif($module_type == 'General Stressors')
        {
            $sql = "SELECT * FROM `tblgeneralstressors` ORDER BY `situation` ";
            //echo $sql;
           $STH = $DBH->prepare($sql);
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                $obj2 = new Keywords();
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $kw_name = stripslashes($row['situation']);

                    if($kw_name == '')
                    {

                    }
                    elseif($obj2->chkKeywordExists($kw_name))
                    {

                    }
                    else
                    {
                        if($obj2->addKeyword($kw_name,$module_type,$row['gs_id']))
                        {
                            $return = true;
                        }
                    } 
                }
                
            }
        }
        elseif($module_type == 'Work Place')
        {
            $sql = "SELECT * FROM `tblworkandenvironments` ORDER BY `situation` ";
            //echo $sql;
           $STH = $DBH->prepare($sql); 
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                $obj2 = new Keywords();
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $kw_name = stripslashes($row['situation']);

                    if($kw_name == '')
                    {

                    }
                    elseif($obj2->chkKeywordExists($kw_name))
                    {

                    }
                    else
                    {
                        if($obj2->addKeyword($kw_name,$module_type,$row['wae_id']))
                        {
                            $return = true;
                        }
                    } 
                }
                
            }
        }
        elseif($module_type == 'My Communication')
        {
            $sql = "SELECT * FROM `tblmycommunications` ORDER BY `situation` ";
            //echo $sql;
           $STH = $DBH->prepare($sql); 
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                $obj2 = new Keywords();
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $kw_name = stripslashes($row['situation']);

                    if($kw_name == '')
                    {

                    }
                    elseif($obj2->chkKeywordExists($kw_name))
                    {

                    }
                    else
                    {
                        if($obj2->addKeyword($kw_name,$module_type,$row['mc_id']))
                        {
                            $return = true;
                        }
                    } 
                }
                
            }
        }
        elseif($module_type == 'My Relation')
        {
            $sql = "SELECT * FROM `tblmyrelations` ORDER BY `situation` ";
            //echo $sql;
           $STH = $DBH->prepare($sql); 
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                $obj2 = new Keywords();
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $kw_name = stripslashes($row['situation']);

                    if($kw_name == '')
                    {

                    }
                    elseif($obj2->chkKeywordExists($kw_name))
                    {

                    }
                    else
                    {
                        if($obj2->addKeyword($kw_name,$module_type,$row['mr_id']))
                        {
                            $return = true;
                        }
                    } 
                }
                
            }
        }
        elseif($module_type == 'Major Life Events')
        {
            $sql = "SELECT * FROM `tblmajorlifeevents` ORDER BY `situation` ";
            //echo $sql;
           $STH = $DBH->prepare($sql); 
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                $obj2 = new Keywords();
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $kw_name = stripslashes($row['situation']);

                    if($kw_name == '')
                    {

                    }
                    elseif($obj2->chkKeywordExists($kw_name))
                    {

                    }
                    else
                    {
                        if($obj2->addKeyword($kw_name,$module_type,$row['mle_id']))
                        {
                            $return = true;
                        }
                    } 
                }
                
            }
        }
        elseif($module_type == 'Physical State Symptoms')
        {
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_deleted` = '0' AND `bmst_id` = '1' ORDER BY `bms_name` ";
            //echo $sql;
           $STH = $DBH->prepare($sql);
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                $obj2 = new Keywords();
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $kw_name = stripslashes($row['bms_name']);

                    if($kw_name == '')
                    {

                    }
                    elseif($obj2->chkKeywordExists($kw_name))
                    {

                    }
                    else
                    {
                        if($obj2->addKeyword($kw_name,$module_type,$row['bms_id']))
                        {
                            $return = true;
                        }
                    } 
                }
                
            }
        }
        elseif($module_type == 'Emotional State Symptoms')
        {
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_deleted` = '0' AND `bmst_id` = '2' ORDER BY `bms_name` ";
            //echo $sql;
           $STH = $DBH->prepare($sql);
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                $obj2 = new Keywords();
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $kw_name = stripslashes($row['bms_name']);

                    if($kw_name == '')
                    {

                    }
                    elseif($obj2->chkKeywordExists($kw_name))
                    {

                    }
                    else
                    {
                        if($obj2->addKeyword($kw_name,$module_type,$row['bms_id']))
                        {
                            $return = true;
                        }
                    } 
                }
                
            }
        }
        return  $return;
    }
    public function getAllPagesChkeckbox($arr_selected_page_id,$adviser_panel = '',$width = '400',$height = '350')
        {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

            $sql = "SELECT * FROM `tblpages` WHERE `show_in_manage_menu` = '1' AND `show_in_list` = '1' ".$sql_str_search." ORDER BY `menu_title` ASC";    
           $STH = $DBH->prepare($sql);  
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_page_id" id="all_selected_page_id" value="1" onclick="toggleCheckBoxes(\'selected_page_id\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                {

                    $page_id = $row['page_id'];
                    $page_name = stripslashes($row['menu_title']);

                    if(in_array($page_id,$arr_selected_page_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_page_id[]" id="selected_page_id_'.$i.'" value="'.$page_id.'" />&nbsp;<strong>'.$page_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        
    public function getPageCatDropdownModulesOptions($implode_page_id)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $option_str = '';		

            $sql = "SELECT * FROM `tblpages` WHERE `page_id`IN('".$implode_page_id."') ORDER BY `page_name` ASC";
            //echo $sql;
           $STH = $DBH->prepare($sql); 
           $STH->execute();
            if($STH->rowCount() > 0)
            {
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                {
                    if($row['page_id'] == $pag_id)
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
            return $option_str;
	}
    public function getKeywordModuleTypeOptions($kw_module_type)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $arr_record = array('Food','Activity','Additions','Sleep','General Stressors','Work Place','My Communication','My Relation','Major Life Events','Physical State Symptoms','Emotional State Symptoms');
        $option_str = '';		

        for($i=0;$i<count($arr_record);$i++)
        {
            if($arr_record[$i] == $kw_module_type)
            {
                $sel = ' selected ';
            }
            else
            {
                $sel = '';
            }		
            $option_str .= '<option value="'.$arr_record[$i].'" '.$sel.'>'.$arr_record[$i].'</option>';
        }
        
        return $option_str;
    }
}
?>