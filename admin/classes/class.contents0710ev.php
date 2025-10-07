<?php
include_once("class.paging.php");
include_once("class.admin.php");
class Contents extends Admin
{
    
    
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
        
        public function getAllPageDropdowns($search,$status)
	{
            $this->connectDB();

            $admin_id = $_SESSION['admin_id'];
            $edit_action_id = '249';
            $delete_action_id = '250';
            $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
            $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

            if($search != '')
            {
                $sql_str_search = " AND tpdm.pdm_name like '%".$search."%' ";
            }
            else 
            {
                $sql_str_search = "";
            }

            if($status != '')
            {
                $sql_str_status = " AND tpd.pd_status = '".$status."' ";
            }
            else 
            {
                $sql_str_status = "";
            }

            $sql = "SELECT * FROM `tblpagedropdowns` AS tpd "
                    . "LEFT JOIN `tblpagedropdownmodules` AS tpdm ON tpd.pdm_id = tpdm.pdm_id "
                    . "WHERE tpd.pd_deleted = '0' ".$sql_str_search." ".$sql_str_status." "
                    . "ORDER BY tpd.pd_add_date DESC";
            $this->execute_query($sql);
            $total_records = $this->numRows();
            $record_per_page = 100;
            $scroll = 5;
            $page = new Page(); 
            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
            $page->set_link_parameter("Class = paging");
            $page->set_qry_string($str="mode=page_dropdowns");
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
                    $obj2 = new Contents();
                    if($row['pd_status'] == '1')
                    {
                        $status = 'Active';
                    }
                    else
                    {
                        $status = 'Inactive';
                    }
                    
                    if($row['added_by_admin'] == '0')
                    {
                        $added_by_admin = '';
                    }
                    else
                    {
                        $added_by_admin = $obj2->getUsenameOfAdmin($row['added_by_admin']);
                    }

                    $date_value = date('d-m-Y',strtotime($row['pd_add_date']));
                    $page_name_str = $obj2->getCommaSeperatedPageName($row['page_id_str']);           
                               
						
                    $output .= '<tr class="manage-row">';
                    $output .= '<td height="30" align="center">'.$i.'</td>';
                    $output .= '<td height="30" align="center"><strong>'.stripslashes($row['pdm_name']).'</strong></td>';
                    $output .= '<td height="30" align="center"><strong>'.$page_name_str.'</strong></td>';
                    $output .= '<td height="30" align="center">'.$status.'</td>';
                    $output .= '<td height="30" align="center">'.$date_value.'</td>';
                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';
                    $output .= '<td align="center" nowrap="nowrap">';
                    if($edit) {
                    $output .= '<a href="index.php?mode=edit_page_dropdown&id='.$row['pd_id'].'" ><img src = "images/edit.gif" border="0"></a>';
                    }
                    $output .= '</td>';
                    $output .= '<td align="center" nowrap="nowrap">';
                    if($delete) {
                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delpagedropdown.php?id='.$row['pd_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
                    }
                    $output .= '</td>';
                    $output .= '</tr>';
                    $i++;
                }
            }
            else
            {
                $output = '<tr class="manage-row" height="30"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';
            }
		
            $page->get_page_nav();
            return $output;
	}
        
        public function getAllPageFavCatDropdowns($search,$status)
	{
            
            $this->connectDB();

            $admin_id = $_SESSION['admin_id'];
            $edit_action_id = '315';
            $delete_action_id = '316';
            $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
            $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

            if($search != '')
            {
                $sql_str_search = " AND page_name like '%".$search."%' ";
            }
            else 
            {
                $sql_str_search = "";
            }
            
//             if($prof_cat != '')
//            {
//                $sql_str_prof_cat = " AND `prof_cat1` = '".$prof_cat."'";
//            }
//            
//            else 
//            {
//                $sql_str_prof_cat = "";
//            }

            if($status != '')
            {
                $sql_str_status = " AND pag_cat_status = '".$status."' ";
            }
            else 
            {
                $sql_str_status = "";
            }

             $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE is_deleted = '0' $sql_str_search $sql_str_status  ORDER BY page_cat_id DESC";
           
            $this->execute_query($sql);
            $total_records = $this->numRows();
            $record_per_page = 100;
            $scroll = 5;
            $page = new Page(); 
            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
            $page->set_link_parameter("Class = paging");
            $page->set_qry_string($str="mode=manage_page_fav_cat_dropdowns");
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
                    
                    $obj2 = new Contents();
                    if($row['pag_cat_status'] == '1')
                    {
                        $status = 'Active';
                    }
                    else
                    {
                        $status = 'Inactive';
                    }
                    
                    if($row['added_by_admin'] == '0')
                    {
                        $added_by_admin = '';
                    }
                    else
                    {
                        $added_by_admin = $obj2->getUsenameOfAdmin($row['added_by_admin']);
                    }

                    $updated_on_date = date('d-m-Y',strtotime($row['updated_on_date']));
//                    $page_name_str = $obj2->getIdByProfileFavCategoryName($row['page_id_str']);           
                            
                    $cat1_imp = explode(',', $row['sub_cat1']);
                    $cat1_imp = implode('\',\'', $cat1_imp);
                   
                    $cat2_imp = explode(',', $row['sub_cat2']);
                    $cat2_imp = implode('\',\'', $cat2_imp);
                    
                    $cat3_imp = explode(',', $row['sub_cat3']);
                    $cat3_imp = implode('\',\'', $cat3_imp);
                    
                    $cat4_imp = explode(',', $row['sub_cat4']);
                    $cat4_imp = implode('\',\'', $cat4_imp);
                    
                    $cat5_imp = explode(',', $row['sub_cat5']);
                    $cat5_imp = implode('\',\'', $cat5_imp);
                    
                    $cat6_imp = explode(',', $row['sub_cat6']);
                    $cat6_imp = implode('\',\'', $cat6_imp);
                    
                    $cat7_imp = explode(',', $row['sub_cat7']);
                    $cat7_imp = implode('\',\'', $cat7_imp);
                    
                    $cat8_imp = explode(',', $row['sub_cat8']);
                    $cat8_imp = implode('\',\'', $cat8_imp);
                    
                    $cat9_imp = explode(',', $row['sub_cat9']);
                    $cat9_imp = implode('\',\'', $cat9_imp);
                    
                    $cat10_imp = explode(',', $row['sub_cat10']);
                    $cat10_imp = implode('\',\'', $cat10_imp);
                     
						
                    $output .= '<tr class="manage-row">';
                    $output .= '<td height="30" align="center">'.$i.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['ref_code']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getFavCategoryNameVivek($row['healcareandwellbeing']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['page_name']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat1_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat2_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat3_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat4_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat5_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat6_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat7_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat8_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat9_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat10_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$status.'</td>';
                    $output .= '<td height="30" align="center">'.$row['updated_on_date'].'</td>';
                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';
                    $output .= '<td align="center" nowrap="nowrap">';
                    if($edit) {
                    $output .= '<a href="index.php?mode=edit_page_fav_cat_dropdown&id='.$row['page_cat_id'].'" ><img src = "images/edit.gif" border="0"></a>';
                    }
                    $output .= '</td>';
                    $output .= '<td align="center" nowrap="nowrap">';
                    if($delete) {
                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delpagefavcatdropdown.php?id='.$row['page_cat_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
                    }
                    $output .= '</td>';
                    $output .= '</tr>';
                    $i++;
                }
            }
            else
            {
                $output = '<tr class="manage-row" height="30"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';
            }
		
            $page->get_page_nav();
            return $output;
	}
       public function getFavCategoryNameVivek($fav_cat_id)
	{
            $this->connectDB();

            $fav_cat_type = '';

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $fav_cat_type = stripslashes($row['fav_cat']);
            }
            return $fav_cat_type;
	}
        
        public function getAllPageCatDropdowns($search,$status)
	{
            print_r($prof_cat);
            $this->connectDB();

            $admin_id = $_SESSION['admin_id'];
            $edit_action_id = '295';
            $delete_action_id = '296';
            $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
            $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

            if($search != '')
            {
                $sql_str_search = " AND page_name like '%".$search."%' ";
            }
            else 
            {
                $sql_str_search = "";
            }
            
//             if($prof_cat != '')
//            {
//                $sql_str_prof_cat = " AND `prof_cat1` = '".$prof_cat."'";
//            }
//            
//            else 
//            {
//                $sql_str_prof_cat = "";
//            }

            if($status != '')
            {
                $sql_str_status = " AND pag_cat_status = '".$status."' ";
            }
            else 
            {
                $sql_str_status = "";
            }

             $sql = "SELECT * FROM `tbl_page_cat_dropdown` WHERE is_deleted = '0' $sql_str_search $sql_str_status  ORDER BY page_cat_id DESC";
           
            $this->execute_query($sql);
            $total_records = $this->numRows();
            $record_per_page = 100;
            $scroll = 5;
            $page = new Page(); 
            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
            $page->set_link_parameter("Class = paging");
            $page->set_qry_string($str="mode=manage_page_cat_dropdowns");
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
                    
                    $obj2 = new Contents();
                    if($row['pag_cat_status'] == '1')
                    {
                        $status = 'Active';
                    }
                    else
                    {
                        $status = 'Inactive';
                    }
                    
                    if($row['added_by_admin'] == '0')
                    {
                        $added_by_admin = '';
                    }
                    else
                    {
                        $added_by_admin = $obj2->getUsenameOfAdmin($row['added_by_admin']);
                    }

                    $updated_on_date = date('d-m-Y',strtotime($row['updated_on_date']));
//                    $page_name_str = $obj2->getIdByProfileFavCategoryName($row['page_id_str']);           
                            
                    $cat1_imp = explode(',', $row['prof_cat1']);
                    $cat1_imp = implode('\',\'', $cat1_imp);
                    
                    $cat2_imp = explode(',', $row['prof_cat2']);
                    $cat2_imp = implode('\',\'', $cat2_imp);
                    
                    $cat3_imp = explode(',', $row['prof_cat3']);
                    $cat3_imp = implode('\',\'', $cat3_imp);
                    
                    $cat4_imp = explode(',', $row['prof_cat4']);
                    $cat4_imp = implode('\',\'', $cat4_imp);
                    
                    $cat5_imp = explode(',', $row['prof_cat5']);
                    $cat5_imp = implode('\',\'', $cat5_imp);
                    
                    $cat6_imp = explode(',', $row['prof_cat6']);
                    $cat6_imp = implode('\',\'', $cat6_imp);
                    
                    $cat7_imp = explode(',', $row['prof_cat7']);
                    $cat7_imp = implode('\',\'', $cat7_imp);
                    
                    $cat8_imp = explode(',', $row['prof_cat8']);
                    $cat8_imp = implode('\',\'', $cat8_imp);
                    
                    $cat9_imp = explode(',', $row['prof_cat9']);
                    $cat9_imp = implode('\',\'', $cat9_imp);
                    
                    $cat10_imp = explode(',', $row['prof_cat10']);
                    $cat10_imp = implode('\',\'', $cat10_imp);
                     
						
                    $output .= '<tr class="manage-row">';
                    $output .= '<td height="30" align="center">'.$i.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['ref_code']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getFavCategoryNameVivek($row['healcareandwellbeing']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['page_name']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdBySubFavCategoryName($cat1_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdBySubFavCategoryName($cat2_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdBySubFavCategoryName($cat3_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdBySubFavCategoryName($cat4_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdBySubFavCategoryName($cat5_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdBySubFavCategoryName($cat6_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdBySubFavCategoryName($cat7_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdBySubFavCategoryName($cat8_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdBySubFavCategoryName($cat9_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdBySubFavCategoryName($cat10_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$status.'</td>';
                    $output .= '<td height="30" align="center">'.$row['updated_on_date'].'</td>';
                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';
                    $output .= '<td align="center" nowrap="nowrap">';
                    if($edit) {
                    $output .= '<a href="index.php?mode=edit_page_cat_dropdown&id='.$row['page_cat_id'].'" ><img src = "images/edit.gif" border="0"></a>';
                    }
                    $output .= '</td>';
                    $output .= '<td align="center" nowrap="nowrap">';
                    if($delete) {
                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delpagecatdropdown.php?id='.$row['page_cat_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
                    }
                    $output .= '</td>';
                    $output .= '</tr>';
                    $i++;
                }
            }
            else
            {
                $output = '<tr class="manage-row" height="30"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';
            }
		
            $page->get_page_nav();
            return $output;
	}
        
         public function getIdByProfileFavCategoryName($fav_cat_id)
            {
                $this->connectDB();

                $meal_item = array();

                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
                $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` IN('".$fav_cat_id."') ";
                $this->execute_query($sql);
                if($this->numRows() > 0)
                {
                   
                    while($row = $this->fetchRow())
                    {
                     
                      $meal_item[] = stripslashes($row['fav_cat']);
                    }
                }
                //print_r($meal_item) ;
                
                $final_value = implode(',', $meal_item);
                return $final_value;
                
            }    
         public function getIdBySubFavCategoryName($fav_cat_id)
            {
                $this->connectDB();

                $meal_item = array();

                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
                $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` IN('".$fav_cat_id."') ";
                $this->execute_query($sql);
                if($this->numRows() > 0)
                {
                   
                    while($row = $this->fetchRow())
                    {
                     
                      $meal_item[] = stripslashes($row['prct_cat']);
                    }
                }
                //print_r($meal_item) ;
                
                $final_value = implode(',', $meal_item);
                return $final_value;
                
            }    
        
        public function getAllPagesChkeckbox($arr_selected_page_id,$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
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
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_page_id" id="all_selected_page_id" value="1" onclick="toggleCheckBoxes(\'selected_page_id\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
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
        
        public function getPageDropdownChkeckbox($arr_selected_page_id,$pdm_id,$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '".$pdm_id."' AND `pd_deleted` = '0' ";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $page_id_str = stripslashes($row['page_id_str']);
                
                $sql = "SELECT * FROM `tblpages` WHERE `page_id` IN (".$page_id_str.") AND `show_in_manage_menu` = '1' AND `show_in_list` = '1' ORDER BY `menu_title` ASC";    
                $this->execute_query($sql);
                if($this->numRows() > 0)
                {
                    $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                    <input type="checkbox" name="all_selected_page_id" id="all_selected_page_id" value="1" onclick="toggleCheckBoxes(\'selected_page_id\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                                </div>
                                <div style="clear:both;"></div>';
                    $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                    $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                    $i = 1;
                    while($row = $this->fetchRow()) 
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
            }
            
            
            return $output;
        }
        
        public function getCommaSeperatedPageName($page_id_str)
        {
            $this->connectDB();
            $output = '';
            
            $sql = "SELECT * FROM `tblpages` WHERE `show_in_manage_menu` = '1' AND `show_in_list` = '1' AND `page_id` IN (".$page_id_str.") ORDER BY `menu_title` ASC";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow()) 
                {
                    $page_name = stripslashes($row['menu_title']);
                    $output .= $page_name.' ,';
                }
                $output = substr($output,0,-1);
            }
            return $output;
        }
        
        public function getPageDropdownModulesOptions($pdm_id)
	{
            $this->connectDB();
            $option_str = '';		

            $sql = "SELECT * FROM `tblpagedropdownmodules` WHERE `pdm_deleted` = '0' AND `pdm_status` = '1' ORDER BY `pdm_name` ASC";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow()) 
                {
                    if($row['pdm_id'] == $pdm_id)
                    {
                        $sel = 'selected';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['pdm_id'].'" '.$sel.'>'.stripslashes($row['pdm_name']).'</option>';
                }
            }
            return $option_str;
	}
       public function getAllCategoryChkeckbox($arr_selected_cat_id1,$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id1" id="all_selected_cat_id1" value="1" onclick="toggleCheckBoxes(\'selected_cat_id1\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $cat_id = $row['prct_cat_id'];
                    $cat_name = stripslashes($row['prct_cat']);

                    if(in_array($cat_id,$arr_selected_cat_id1))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id1[]" id="selected_cat_id1_'.$i.'" value="'.$cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        
        
        public function getAllCategory2Chkeckbox($arr_selected_cat_id2,$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id2" id="all_selected_cat_id2" value="1" onclick="toggleCheckBoxes(\'selected_cat_id2\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $cat_id = $row['prct_cat_id'];
                    $cat_name = stripslashes($row['prct_cat']);

                    if(in_array($cat_id,$arr_selected_cat_id2))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id2[]" id="selected_cat_id2_'.$i.'" value="'.$cat_id.'" />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategory3Chkeckbox($arr_selected_cat_id3,$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id3" id="all_selected_cat_id3" value="1" onclick="toggleCheckBoxes(\'selected_cat_id3\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $cat_id = $row['prct_cat_id'];
                    $cat_name = stripslashes($row['prct_cat']);

                    if(in_array($cat_id,$arr_selected_cat_id3))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id3[]" id="selected_cat_id3_'.$i.'" value="'.$cat_id.'" />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategory4Chkeckbox($arr_selected_cat_id4,$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id4" id="all_selected_cat_id4" value="1" onclick="toggleCheckBoxes(\'selected_cat_id4\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $cat_id = $row['prct_cat_id'];
                    $cat_name = stripslashes($row['prct_cat']);

                    if(in_array($cat_id,$arr_selected_cat_id4))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id4[]" id="selected_cat_id4_'.$i.'" value="'.$cat_id.'" />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategory5Chkeckbox($arr_selected_cat_id5,$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id5" id="all_selected_cat_id5" value="1" onclick="toggleCheckBoxes(\'selected_cat_id5\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $cat_id = $row['prct_cat_id'];
                    $cat_name = stripslashes($row['prct_cat']);

                    if(in_array($cat_id,$arr_selected_cat_id5))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id5[]" id="selected_cat_id5_'.$i.'" value="'.$cat_id.'" />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        
        public function getAllCategory6Chkeckbox($arr_selected_cat_id6,$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id6" id="all_selected_cat_id6" value="1" onclick="toggleCheckBoxes(\'selected_cat_id6\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $cat_id = $row['prct_cat_id'];
                    $cat_name = stripslashes($row['prct_cat']);

                    if(in_array($cat_id,$arr_selected_cat_id6))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id6[]" id="selected_cat_id6_'.$i.'" value="'.$cat_id.'" />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategory7Chkeckbox($arr_selected_cat_id7,$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id7" id="all_selected_cat_id7" value="1" onclick="toggleCheckBoxes(\'selected_cat_id7\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $cat_id = $row['prct_cat_id'];
                    $cat_name = stripslashes($row['prct_cat']);

                    if(in_array($cat_id,$arr_selected_cat_id7))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id7[]" id="selected_cat_id7_'.$i.'" value="'.$cat_id.'" />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategory8Chkeckbox($arr_selected_cat_id8,$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id8" id="all_selected_cat_id8" value="1" onclick="toggleCheckBoxes(\'selected_cat_id8\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $cat_id = $row['prct_cat_id'];
                    $cat_name = stripslashes($row['prct_cat']);

                    if(in_array($cat_id,$arr_selected_cat_id8))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id8[]" id="selected_cat_id8_'.$i.'" value="'.$cat_id.'" />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategory9Chkeckbox($arr_selected_cat_id9,$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id9" id="all_selected_cat_id9" value="1" onclick="toggleCheckBoxes(\'selected_cat_id9\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $cat_id = $row['prct_cat_id'];
                    $cat_name = stripslashes($row['prct_cat']);

                    if(in_array($cat_id,$arr_selected_cat_id9))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id9[]" id="selected_cat_id9_'.$i.'" value="'.$cat_id.'" />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
         public function getAllCategory10Chkeckbox($arr_selected_cat_id10,$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id10" id="all_selected_cat_id10" value="1" onclick="toggleCheckBoxes(\'selected_cat_id10\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $cat_id = $row['prct_cat_id'];
                    $cat_name = stripslashes($row['prct_cat']);

                    if(in_array($cat_id,$arr_selected_cat_id10))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id10[]" id="selected_cat_id10_'.$i.'" value="'.$cat_id.'" />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
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
        public function deletePageDropdown($pd_id)
	{
            $this->connectDB();
            $updated_on_date = date('Y-m-d H:i:s');
            $sql = "UPDATE `tblpagedropdowns` SET "
                    . "`pd_deleted` = '1' , `updated_on_date` = '".$updated_on_date."'"
                    . "WHERE `pd_id` = '".$pd_id."'";
	    //echo $sql;
            $this->execute_query($sql);
            return $this->result;
	}
         public function deletePageCatDropdown($page_cat_id)
	{
            $this->connectDB();
            $updated_on_date = date('Y-m-d H:i:s');
             $sql = "UPDATE `tbl_page_cat_dropdown` SET "
                    . "`is_deleted` = '1' , `updated_on_date` = '".$updated_on_date."'"
                    . "WHERE `page_cat_id` = '".$page_cat_id."'";
	  //echo $sql;
            $this->execute_query($sql);
            return $this->result;
	}
         public function deletePageFavCatDropdown($page_cat_id)
	{
            $this->connectDB();
            $updated_on_date = date('Y-m-d H:i:s');
             $sql = "UPDATE `tbl_page_fav_cat_dropdown` SET "
                    . "`is_deleted` = '1' , `updated_on_date` = '".$updated_on_date."'"
                    . "WHERE `page_cat_id` = '".$page_cat_id."'";
	  //echo $sql;
            $this->execute_query($sql);
            return $this->result;
	}
        
        public function chkPageDropdownModuleExists($pdm_id)
        {
            $this->connectDB();
            $return = false;

            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '".$pdm_id."' AND `pd_deleted` = '0' ";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $return = true;
            }
            return  $return;
        }
        
        public function chkPageDropdownModuleExists_Edit($pdm_id,$pd_id)
        {
            $this->connectDB();
            $return = false;

            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '".$pdm_id."' AND `pd_id` != '".$pd_id."' AND `pd_deleted` = '0' ";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $return = true;
            }
            return  $return;
        }
        
        
        public function addPageDropdown($pdm_id,$page_id_str,$admin_id)
	{
            $this->connectDB();
            $return = false;
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "INSERT INTO `tblpagedropdowns` (`pdm_id`,`page_id_str`,`pd_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`) "
                . "VALUES ('".addslashes($pdm_id)."','".addslashes($page_id_str)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."')";
            $this->execute_query($sql);
            if($this->result)
            {
                $return = true;
            }
            return $return;
	}
        
        public function addPageCatDropdown($header1,$header2,$header3,$header4,$header5,$header6,$header7,$header8,$header9,$header10,$healcareandwellbeing,$ref_code,$page_name,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$admin_id)
	{
            $this->connectDB();
            $return = false;
            $updated_on_date = date('Y-m-d H:i:s');
            
            for($i=0;$i<count($healcareandwellbeing);$i++)
            {
            $sql = "INSERT INTO `tbl_page_cat_dropdown` (`header1`,`header2`,`header3`,`header4`,`header5`,`header6`,`header7`,`header8`,`header9`,`header10`,`healcareandwellbeing`,`page_name`,`ref_code`,`prof_cat1`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`prof_cat5`,`prof_cat6`,`prof_cat7`,`prof_cat8`,`prof_cat9`,`prof_cat10`,`pag_cat_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`) "
                . "VALUES ('".addslashes($header1)."','".addslashes($header2)."','".addslashes($header3)."','".addslashes($header4)."','".addslashes($header5)."','".addslashes($header6)."','".addslashes($header7)."','".addslashes($header8)."','".addslashes($header9)."','".addslashes($header10)."','".addslashes($healcareandwellbeing[$i])."','".addslashes($page_name)."','".addslashes($ref_code)."','".addslashes($prof_cat1)."','".addslashes($prof_cat2)."','".addslashes($prof_cat3)."','".addslashes($prof_cat4)."','".addslashes($prof_cat5)."','".addslashes($prof_cat6)."','".addslashes($prof_cat7)."','".addslashes($prof_cat8)."','".addslashes($prof_cat9)."','".addslashes($prof_cat10)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."')";
            $this->execute_query($sql);
            }
            if($this->result)
            {
                $return = true;
            }
            return $return;
	}
        
        public function addFavCatDropdown($healcareandwellbeing,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$admin_id)
	{
            $this->connectDB();
            $return = false;
            $updated_on_date = date('Y-m-d H:i:s');
             for($i=0;$i<count($healcareandwellbeing);$i++)
            {
            $sql = "INSERT INTO `tbl_page_fav_cat_dropdown` (`healcareandwellbeing`,`page_name`,`ref_code`,`sub_cat1`,`sub_cat2`,`sub_cat3`,`sub_cat4`,`sub_cat5`,`sub_cat6`,`sub_cat7`,`sub_cat8`,`sub_cat9`,`sub_cat10`,`prof_cat1`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`prof_cat5`,`prof_cat6`,`prof_cat7`,`prof_cat8`,`prof_cat9`,`prof_cat10`,`pag_cat_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`) "
                . "VALUES ('".addslashes($healcareandwellbeing[$i])."','".addslashes($page_name)."','".addslashes($ref_code)."','".addslashes($sub_cat1)."','".addslashes($sub_cat2)."','".addslashes($sub_cat3)."','".addslashes($sub_cat4)."','".addslashes($sub_cat5)."','".addslashes($sub_cat6)."','".addslashes($sub_cat7)."','".addslashes($sub_cat8)."','".addslashes($sub_cat9)."','".addslashes($sub_cat10)."','".addslashes($prof_cat1)."','".addslashes($prof_cat2)."','".addslashes($prof_cat3)."','".addslashes($prof_cat4)."','".addslashes($prof_cat5)."','".addslashes($prof_cat6)."','".addslashes($prof_cat7)."','".addslashes($prof_cat8)."','".addslashes($prof_cat9)."','".addslashes($prof_cat10)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."')";
            $this->execute_query($sql);
            }
            if($this->result)
            {
                $return = true;
            }
            return $return;
	}
        
        public function getFunctionNameById($fun_id)
            {
                $this->connectDB();

                $meal_item = '';

                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
                $sql = "SELECT * FROM `tblpagedropdownmodules` WHERE `pdm_id` ='".$fun_id."' ";
                $this->execute_query($sql);
                if($this->numRows() > 0)
                {
                   
                    $row = $this->fetchRow();
                    $meal_item = $row['pdm_name'];
                   
                }
                //print_r($meal_item) ;
                
                
                return $meal_item;
                
            }    
        
        public function getPageDropdownDetails($pd_id)
	{
            $this->connectDB();
            $pdm_id = '';
            $page_id_str = '';
            $pd_status = '';
            
            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pd_id` = '".$pd_id."' AND `pd_deleted` = '0' ";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $pdm_id = stripslashes($row['pdm_id']);
                $page_id_str = stripslashes($row['page_id_str']);
                $pd_status = stripslashes($row['pd_status']);
            }
            return array($pdm_id,$page_id_str,$pd_status);
	}
       
         public function getPageCatDropdownDetails($page_cat_id)
	{
              $obj2 = new Contents();
            $this->connectDB();
            $pdm_id = '';
            $page_id_str = '';
            $pd_status = '';
            
            $sql = "SELECT * FROM `tbl_page_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' AND `is_deleted` = '0' ";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                
                $healcareandwellbeing = $obj2->getFavCategoryNameVivek($row['healcareandwellbeing']);
                $page_name = stripslashes($row['page_name']);
                $ref_code = stripslashes($row['ref_code']);
                $prof_cat1 = stripslashes($row['prof_cat1']);
                $prof_cat2 = stripslashes($row['prof_cat2']);
                $prof_cat3 = stripslashes($row['prof_cat3']);
                $prof_cat4 = stripslashes($row['prof_cat4']);
                $prof_cat5 = stripslashes($row['prof_cat5']);
                $prof_cat6 = stripslashes($row['prof_cat6']);
                $prof_cat7 = stripslashes($row['prof_cat7']);
                $prof_cat8 = stripslashes($row['prof_cat8']);
                $prof_cat9 = stripslashes($row['prof_cat9']);
                $prof_cat10 = stripslashes($row['prof_cat10']);
                $header1 = stripslashes($row['header1']);
                $header2 = stripslashes($row['header2']);
                $header3 = stripslashes($row['header3']);
                $header4 = stripslashes($row['header4']);
                $header5 = stripslashes($row['header5']);
                $header6 = stripslashes($row['header6']);
                $header7 = stripslashes($row['header7']);
                $header8 = stripslashes($row['header8']);
                $header9 = stripslashes($row['header9']);
                $header10 = stripslashes($row['header10']);
                $pag_cat_status = stripslashes($row['pag_cat_status']);
            }
            return array($header1,$header2,$header3,$header4,$header5,$header6,$header7,$header8,$header9,$header10,$healcareandwellbeing,$page_name,$ref_code,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$pag_cat_status);
	}
       
        
        public function updatePageDropdown($pd_id,$pdm_id,$page_id_str,$pd_status,$admin_id)
	{
            $this->connectDB();
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "UPDATE `tblpagedropdowns` SET "
                    . "`pdm_id` = '".addslashes($pdm_id)."' ,"
                    . "`page_id_str` = '".addslashes($page_id_str)."' ,"
                    . "`pd_status` = '".addslashes($pd_status)."' ,"
                    . "`updated_by_admin` = '".addslashes($admin_id)."' ,"
                    . "`updated_on_date` = '".addslashes($updated_on_date)."' "
                    . "WHERE `pd_id` = '".$pd_id."' ";
	    //echo $sql;
            $this->execute_query($sql);
            return $this->result;
	}
    
         public function updatePageCatDropdown($header1,$header2,$header3,$header4,$header5,$header6,$header7,$header8,$header9,$header10,$pag_cat_status,$admin_id,$ref_code,$page_name,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$id)
	{
            $this->connectDB();
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "UPDATE `tbl_page_cat_dropdown` SET "
                    . "`ref_code` = '".addslashes($ref_code)."' ,"
                    . "`page_name` = '".addslashes($page_name)."' ,"
                    . "`prof_cat1` = '".addslashes($prof_cat1)."' ,"
                    . "`prof_cat2` = '".addslashes($prof_cat2)."' ,"
                    . "`prof_cat3` = '".addslashes($prof_cat3)."' ,"
                    . "`prof_cat4` = '".addslashes($prof_cat4)."' ,"
                    . "`prof_cat5` = '".addslashes($prof_cat5)."' ,"
                    . "`prof_cat6` = '".addslashes($prof_cat6)."' ,"
                    . "`prof_cat7` = '".addslashes($prof_cat7)."' ,"
                    . "`prof_cat8` = '".addslashes($prof_cat8)."' ,"
                    . "`prof_cat9` = '".addslashes($prof_cat9)."' ,"
                    . "`prof_cat10` = '".addslashes($prof_cat10)."' ,"
                    . "`header1` = '".addslashes($header1)."' ,"
                    . "`header2` = '".addslashes($header2)."' ,"
                    . "`header3` = '".addslashes($header3)."' ,"
                    . "`header4` = '".addslashes($header4)."' ,"
                    . "`header5` = '".addslashes($header5)."' ,"
                    . "`header6` = '".addslashes($header6)."' ,"
                    . "`header7` = '".addslashes($header7)."' ,"
                    . "`header8` = '".addslashes($header8)."' ,"
                    . "`header9` = '".addslashes($header9)."' ,"
                    . "`header10` = '".addslashes($header10)."' ,"
                    . "`pag_cat_status` = '".addslashes($pag_cat_status)."' ,"
                    . "`updated_by_admin` = '".addslashes($admin_id)."' ,"
                    . "`updated_on_date` = '".addslashes($updated_on_date)."' "
                    . "WHERE `page_cat_id` = '".$id."' ";
	    //echo $sql;
            $this->execute_query($sql);
            return $this->result;
	}
    
    
	public function GetAllCommonMessagesUser($search)
	{
		$this->connectDB();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '76';
				
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		if($search == '')
		{
			$sql = "SELECT * FROM `tblcommonsettings` WHERE `cs_type` = 'MSG' AND `cs_id` IN (3) ORDER BY `cs_name` ASC ";
		}
		else
		{
			$sql = "SELECT * FROM `tblcommonsettings` WHERE `cs_type` = 'MSG' AND `cs_id` IN (3) AND cs_name LIKE '%".$search."%' ORDER BY `cs_name` ASC";
		}
		$this->execute_query($sql);
		$total_records=$this->numRows();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=common_messages_user");
	 	$result=$this->execute_query($page->get_limit_query($sql));
		$output = '';		
		if($this->numRows() > 0)
		{
			$i = 1;
			while($row = $this->fetchRow())
			{
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['cs_name']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['cs_value']).'</td>';
				$output .= '<td height="30" align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_common_message_user&id='.$row['cs_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="4" align="center">NO RECORDS FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function GetAllCommonMessagesAdviser($search)
	{
		$this->connectDB();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '76';
				
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		if($search == '')
		{
			$sql = "SELECT * FROM `tblcommonsettings` WHERE `cs_type` = 'MSG' AND `cs_id` IN (4) ORDER BY `cs_name` ASC ";
		}
		else
		{
			$sql = "SELECT * FROM `tblcommonsettings` WHERE `cs_type` = 'MSG' AND `cs_id` IN (4) AND cs_name LIKE '%".$search."%' ORDER BY `cs_name` ASC";
		}
		$this->execute_query($sql);
		$total_records=$this->numRows();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=common_messages_adviser");
	 	$result=$this->execute_query($page->get_limit_query($sql));
		$output = '';		
		if($this->numRows() > 0)
		{
			$i = 1;
			while($row = $this->fetchRow())
			{
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['cs_name']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['cs_value']).'</td>';
				$output .= '<td height="30" align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_common_message_adviser&id='.$row['cs_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="4" align="center">NO RECORDS FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function UpdateCommonMessage($cs_id,$cs_value)
	{
		$this->connectDB();
		$upd_sql = "UPDATE `tblcommonsettings` SET `cs_value` = '".addslashes($cs_value)."' WHERE `cs_id` = '".$cs_id."'";
		$this->execute_query($upd_sql);
		return $this->result;
	}
	
	public function getCommonMessageDetails($cs_id)
	{
		$this->connectDB();
		
		$cs_name = '';
		$cs_value = '';
		
		$sql = "SELECT * FROM `tblcommonsettings` WHERE `cs_id` = '".$cs_id."' AND `cs_type` = 'MSG'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$cs_name = stripslashes($row['cs_name']);
			$cs_value = stripslashes($row['cs_value']);
		}
		return array($cs_name,$cs_value);
	}
	
	
	public function getAllInactiveMenuItems()
	{
		$this->connectDB();
		
		$arr_inactive_menu_items = array();
		
		$admin_id = $_SESSION['admin_id'];
				
		$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '0' ORDER BY `menu_title` ASC ";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow())
			{
				array_push($arr_inactive_menu_items,$row);
			}
		}
		
		return $arr_inactive_menu_items;
	}
	
	public function getAllInactiveMenuItemsAdviser()
	{
		$this->connectDB();
		
		$arr_inactive_menu_items = array();
		
		$admin_id = $_SESSION['admin_id'];
				
		$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '0' ORDER BY `menu_title` ASC ";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow())
			{
				array_push($arr_inactive_menu_items,$row);
			}
		}
		
		return $arr_inactive_menu_items;
	}
        
        public function getAllInactiveMenuItemsVender()
	{
		$this->connectDB();
		
		$arr_inactive_menu_items = array();
		
		$admin_id = $_SESSION['admin_id'];
				
		$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '1' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '0' ORDER BY `menu_title` ASC ";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow())
			{
				array_push($arr_inactive_menu_items,$row);
			}
		}
		
		return $arr_inactive_menu_items;
	}
	
	public function getAllActiveMenuItems($parent_id)
	{
		$this->connectDB();
		
		$arr_active_menu_items = array();
		
		$admin_id = $_SESSION['admin_id'];
				
		
		$obj2 = new Contents();
		$obj2->connectDB();
		
		$sql2 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$parent_id."' ORDER BY `menu_order` ASC ";
		//echo'<br><br>sql2 = '.$sql2;
		$obj2->execute_query($sql2);
		if($obj2->numRows() > 0)
		{	
			while($row2 = $obj2->fetchRow())
			{
				$arr_active_menu_items[$row2['page_id']]['menu_details'] = $row2;
				$arr_active_menu_items[$row2['page_id']]['submenu_details'] = array();  
				$sql3 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$row2['page_id']."'  ORDER BY `menu_order` ASC ";
				//echo'<br><br>sql3 = '.$sql3;
				$obj3 = new Contents();
				$obj3->connectDB();
				$obj3->execute_query($sql3);
				if($obj3->numRows() > 0)
				{	
					$obj4 = new Contents();
					array_push($arr_active_menu_items[$row2['page_id']]['submenu_details'] , $obj4->getAllActiveMenuItems($row2['page_id'])); 
				}
			}
		}
				
		return $arr_active_menu_items;
	}
	
	public function getAllActiveMenuItemsAdviser($parent_id)
	{
		$this->connectDB();
		
		$arr_active_menu_items = array();
		
		$admin_id = $_SESSION['admin_id'];
				
		
		$obj2 = new Contents();
		$obj2->connectDB();
		
		$sql2 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$parent_id."' ORDER BY `menu_order` ASC ";
		//echo'<br><br>sql2 = '.$sql2;
		$obj2->execute_query($sql2);
		if($obj2->numRows() > 0)
		{	
			while($row2 = $obj2->fetchRow())
			{
				$arr_active_menu_items[$row2['page_id']]['menu_details'] = $row2;
				$arr_active_menu_items[$row2['page_id']]['submenu_details'] = array();  
				$sql3 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$row2['page_id']."'  ORDER BY `menu_order` ASC ";
				//echo'<br><br>sql3 = '.$sql3;
				$obj3 = new Contents();
				$obj3->connectDB();
				$obj3->execute_query($sql3);
				if($obj3->numRows() > 0)
				{	
					$obj4 = new Contents();
					array_push($arr_active_menu_items[$row2['page_id']]['submenu_details'] , $obj4->getAllActiveMenuItemsAdviser($row2['page_id'])); 
				}
			}
		}
				
		return $arr_active_menu_items;
	}
        
        public function getAllActiveMenuItemsVender($parent_id)
	{
		$this->connectDB();
		
		$arr_active_menu_items = array();
		
		$admin_id = $_SESSION['admin_id'];
				
		
		$obj2 = new Contents();
		$obj2->connectDB();
		
		$sql2 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '1' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$parent_id."' ORDER BY `menu_order` ASC ";
		//echo'<br><br>sql2 = '.$sql2;
		$obj2->execute_query($sql2);
		if($obj2->numRows() > 0)
		{	
			while($row2 = $obj2->fetchRow())
			{
				$arr_active_menu_items[$row2['page_id']]['menu_details'] = $row2;
				$arr_active_menu_items[$row2['page_id']]['submenu_details'] = array();  
				$sql3 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '1' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$row2['page_id']."'  ORDER BY `menu_order` ASC ";
				//echo'<br><br>sql3 = '.$sql3;
				$obj3 = new Contents();
				$obj3->connectDB();
				$obj3->execute_query($sql3);
				if($obj3->numRows() > 0)
				{	
					$obj4 = new Contents();
					array_push($arr_active_menu_items[$row2['page_id']]['submenu_details'] , $obj4->getAllActiveMenuItemsAdviser($row2['page_id'])); 
				}
			}
		}
				
		return $arr_active_menu_items;
	}
		
	public function GetAllPages($search)
	{
		$this->connectDB();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '76';
		$delete_action_id = '78';
		
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($search == '')
			{
				$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_list` = '1' ORDER BY `page_name` ASC ";
			}
		else
			{
			    $sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND page_name LIKE '%".$search."%' AND `show_in_list` = '1' ORDER BY `page_name` ASC";
			}
		$this->execute_query($sql);
		$total_records=$this->numRows();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=contents");
	 	$result=$this->execute_query($page->get_limit_query($sql));
		$output = '';		
		if($this->numRows() > 0)
		{
			$i = 1;
			while($row = $this->fetchRow())
			{
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['page_name']).'</td>';
				$output .= '<td height="30" align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_content&page_id='.$row['page_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td height="30" align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Page","sql/delpage.php?page_id='.$row['page_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
								}
				$output .= '</td>';
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="4" align="center">NO PAGES FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function GetAllPagesAdviser($search)
	{
		$this->connectDB();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '177';
		$delete_action_id = '178';
		
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($search == '')
			{
				$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND `show_in_list` = '1' ORDER BY `page_name` ASC ";
			}
		else
			{
			    $sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND page_name LIKE '%".$search."%' AND `show_in_list` = '1' ORDER BY `page_name` ASC";
			}
		$this->execute_query($sql);
		$total_records=$this->numRows();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=contents");
	 	$result=$this->execute_query($page->get_limit_query($sql));
		$output = '';		
		if($this->numRows() > 0)
		{
			$i = 1;
			while($row = $this->fetchRow())
			{
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['page_name']).'</td>';
				$output .= '<td height="30" align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_adviser_content&page_id='.$row['page_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td height="30" align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Page","sql/deladviserpage.php?page_id='.$row['page_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
								}
				$output .= '</td>';
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="4" align="center">NO PAGES FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
        
        public function GetAllPagesVender($search)
	{
		$this->connectDB();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '281';
		$delete_action_id = '282';
		
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($search == '')
			{
				$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '1' AND `show_in_list` = '1' ORDER BY `page_name` ASC ";
			}
		else
			{
			    $sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '1' AND page_name LIKE '%".$search."%' AND `show_in_list` = '1' ORDER BY `page_name` ASC";
			}
		$this->execute_query($sql);
		$total_records=$this->numRows();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=vender_contents");
	 	$result=$this->execute_query($page->get_limit_query($sql));
		$output = '';		
		if($this->numRows() > 0)
		{
			$i = 1;
			while($row = $this->fetchRow())
			{
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['page_name']).'</td>';
				$output .= '<td height="30" align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_vender_content&page_id='.$row['page_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td height="30" align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Page","sql/delvenderpage.php?page_id='.$row['page_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
								}
				$output .= '</td>';
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="4" align="center">NO PAGES FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function AddContent($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$adviser_panel,$page_contents2,$vender_panel)
	{
		$this->connectDB();
		$ins_sql = "INSERT INTO `tblpages`(`page_name`,`page_title`,`page_contents`,`meta_title`,`meta_keywords`,`meta_description`,`show_in_list`,`show_in_manage_menu`,`link_enable`,`menu_title`,`adviser_panel`,`page_contents2`,`vender_panel`) VALUES ('".addslashes($page_name)."','".addslashes($page_title)."','".addslashes($page_contents)."','".addslashes($meta_title)."','".addslashes($meta_keywords)."','".addslashes($meta_description)."','1','1','".addslashes($menu_link_enable)."','".addslashes($menu_title)."','".addslashes($adviser_panel)."','".addslashes($page_contents2)."','".addslashes($vender_panel)."')";
		$this->execute_query($ins_sql);
		
		if($this->result)
		{
			$page_id = $this->getInsertID();
			if($adviser_panel == '1')
			{
				$menu_link = 'practitioners/pages.php?id='.$page_id;
			}
                        elseif($vender_panel == '1')
			{
				$menu_link = 'venders/pages.php?id='.$page_id;
			}
			else
			{
				$menu_link = 'pages.php?id='.$page_id;
			}
			$upd_sql = "UPDATE `tblpages` SET `menu_link` = '".addslashes($menu_link)."' WHERE `page_id` = '".$page_id."'";
			$this->execute_query($upd_sql);
		}
		return $this->result;
	}
	
	public function getContentDetails($page_id)
	{
		$this->connectDB();
		
		$page_name = '';
		$page_title = '';
		$page_contents = '';
		$meta_title = '';
		$meta_keywords = '';
		$meta_description = '';
		$menu_title = '';
		$menu_link_enable = 0;
                $page_contents2 = '';
		
		$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$page_name = stripslashes($row['page_name']);
			$page_title = stripslashes($row['page_title']);
			$page_contents = stripslashes($row['page_contents']);
                        $page_contents2 = stripslashes($row['page_contents2']);
			$meta_title = stripslashes($row['meta_title']);
			$meta_keywords = stripslashes($row['meta_keywords']);
			$meta_description = stripslashes($row['meta_description']);
			$menu_title = stripslashes($row['menu_title']);
			$menu_link_enable = stripslashes($row['link_enable']);
		}
		return array($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$page_contents2);
	
	}
	
	
	public function UpdateContent($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$page_id,$page_contents2)
	{
		$this->connectDB();
		$upd_sql = "UPDATE `tblpages` SET `page_name` = '".addslashes($page_name)."' , `page_title` = '".addslashes($page_title)."' , `page_contents` = '".addslashes($page_contents)."' , `page_contents2` = '".addslashes($page_contents2)."' , `meta_title` = '".addslashes($meta_title)."' , `meta_keywords` = '".addslashes($meta_keywords)."' , `meta_description` = '".addslashes($meta_description)."' , `menu_title` = '".addslashes($menu_title)."' , `link_enable` = '".addslashes($menu_link_enable)."'   WHERE `page_id` = '".$page_id."'";
		$this->execute_query($upd_sql);
		return $this->result;
	}
	
	public function DeleteContent($page_id)
	{
		$this->connectDB();
		
		$del_sql1 = "UPDATE `tblpages` SET `show_in_list` = '0' , `show_in_manage_menu` = '0' , `show_in_menu` = '0' WHERE `page_id` = '".$page_id."'"; 
		$this->execute_query($del_sql1);
		if($this->result)
		{
			if($this->chkIfChildPagesExists($page_id))
			{
				$sql2 = "UPDATE `tblpages` SET `show_in_menu` = '0' , `parent_menu` = '0' , `menu_order` = '0' WHERE `parent_menu` = '".$page_id."'"; 
				$this->execute_query($sql2);
			}	
		}	
		return $this->result;
	}
	
	public function chkIfChildPagesExists($page_id)
	{
		$this->connectDB();
		$return = false;
		
		$sql = "SELECT * FROM `tblpages` WHERE `show_in_manage_menu` = '1' AND `show_in_list` = '1' AND `parent_menu` = '".$page_id."' ORDER BY `menu_order` ASC ";
		//echo'<br><br>sql = '.$sql;
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{	
			$return = true;
		}
		return $return;
	}
	
//        vivek start
         public function getPageFavCatDropdownDetailsVivek($page_cat_id)
	{
              $obj2 = new Contents();
            $this->connectDB();
            $pdm_id = '';
            $page_id_str = '';
            $pd_status = '';
            
            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' AND `is_deleted` = '0' ";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                
                $healcareandwellbeing = $obj2->getFavCategoryNameVivek($row['healcareandwellbeing']);
                $page_name = stripslashes($row['page_name']);
                $ref_code = stripslashes($row['ref_code']);
                $prof_cat1 = stripslashes($row['prof_cat1']);
                $prof_cat2 = stripslashes($row['prof_cat2']);
                $prof_cat3 = stripslashes($row['prof_cat3']);
                $prof_cat4 = stripslashes($row['prof_cat4']);
                $prof_cat5 = stripslashes($row['prof_cat5']);
                $prof_cat6 = stripslashes($row['prof_cat6']);
                $prof_cat7 = stripslashes($row['prof_cat7']);
                $prof_cat8 = stripslashes($row['prof_cat8']);
                $prof_cat9 = stripslashes($row['prof_cat9']);
                $prof_cat10 = stripslashes($row['prof_cat10']);
//                $header1 = stripslashes($row['header1']);
//                $header2 = stripslashes($row['header2']);
//                $header3 = stripslashes($row['header3']);
//                $header4 = stripslashes($row['header4']);
//                $header5 = stripslashes($row['header5']);
//                $header6 = stripslashes($row['header6']);
//                $header7 = stripslashes($row['header7']);
//                $header8 = stripslashes($row['header8']);
//                $header9 = stripslashes($row['header9']);
//                $header10 = stripslashes($row['header10']);
                $pag_cat_status = stripslashes($row['pag_cat_status']);
            }
            return array($healcareandwellbeing,$page_name,$ref_code,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$pag_cat_status);
	}
       
      public function updatePageFavCatDropdown($pag_cat_status,$admin_id,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$id)
	{
            $this->connectDB();
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "UPDATE `tbl_page_fav_cat_dropdown` SET "
                    . "`ref_code` = '".addslashes($ref_code)."' ,"
                    . "`page_name` = '".addslashes($page_name)."' ,"
                    . "`prof_cat1` = '".addslashes($prof_cat1)."' ,"
                    . "`prof_cat2` = '".addslashes($prof_cat2)."' ,"
                    . "`prof_cat3` = '".addslashes($prof_cat3)."' ,"
                    . "`prof_cat4` = '".addslashes($prof_cat4)."' ,"
                    . "`prof_cat5` = '".addslashes($prof_cat5)."' ,"
                    . "`prof_cat6` = '".addslashes($prof_cat6)."' ,"
                    . "`prof_cat7` = '".addslashes($prof_cat7)."' ,"
                    . "`prof_cat8` = '".addslashes($prof_cat8)."' ,"
                    . "`prof_cat9` = '".addslashes($prof_cat9)."' ,"
                    . "`prof_cat10` = '".addslashes($prof_cat10)."' ,"
                    . "`sub_cat1` = '".addslashes($sub_cat1)."' ,"
                    . "`sub_cat2` = '".addslashes($sub_cat2)."' ,"
                    . "`sub_cat3` = '".addslashes($sub_cat3)."' ,"
                    . "`sub_cat4` = '".addslashes($sub_cat4)."' ,"
                    . "`sub_cat5` = '".addslashes($sub_cat5)."' ,"
                    . "`sub_cat6` = '".addslashes($sub_cat6)."' ,"
                    . "`sub_cat7` = '".addslashes($sub_cat7)."' ,"
                    . "`sub_cat8` = '".addslashes($sub_cat8)."' ,"
                    . "`sub_cat9` = '".addslashes($sub_cat9)."' ,"
                    . "`sub_cat10` = '".addslashes($sub_cat10)."' ,"
                    . "`pag_cat_status` = '".addslashes($pag_cat_status)."' ,"
                    . "`updated_by_admin` = '".addslashes($admin_id)."' ,"
                    . "`updated_on_date` = '".addslashes($updated_on_date)."' "
                    . "WHERE `page_cat_id` = '".$id."' ";
	    //echo $sql;
            $this->execute_query($sql);
            return $this->result;
	}
    
         public function getAllHealcareAndWellbeingPageDropdownData($fav_cat_type_id)
        {
            $this->connectDB();
            $return = array();

            $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$fav_cat_type_id."' and tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
              while($row = $this->fetchRow()) 
                {
                   $return[] = $row['favcat_id'];
               }
            }
            return  $return;
        }
        
//        vivek end

  //Ramakant 01-10-2018
   
   public function getDatadropdownPage($pdm_id,$page_id)
	{
            $this->connectDB();
            $option_str = '';		
            $sel = '';
            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` ='".$pdm_id."' ";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $str = explode(',', $row['page_id_str']);
                foreach($str as $value) 
                {
                   if($page_id == $value)
                    {
                        $sel='selected';
                    }
                    else
                    {
                        $sel = '';
                    }
                    
                    $option_str .= '<option value="'.$value.'" '.$sel.' >'.stripslashes($this->getPagenamebyid($value)).'</option>';
                }
            }
            return $option_str;
	}     
    
        public function getPagenamebyid($page_id) {
          
            $this->connectDB();
            $page_name = '';		

            $sql = "SELECT * FROM `tblpages` WHERE `page_id` ='".$page_id."' ";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $page_name = $row['page_name'];
                
            }
            return $page_name; 
            
        }
        
        public function addDataDropdown($healcareandwellbeing,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$admin_id,$time_show,$duration_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$heading,$order_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category)
	{
            $this->connectDB();
            $return = false;
            $updated_on_date = date('Y-m-d H:i:s');
            $time_show = ($time_show ==''? 1 : $time_show);
            $duration_show = ($duration_show ==''? 1 : $duration_show);
            $location_show = ($location_show ==''? 1 : $location_show);
            $like_dislike_show = ($like_dislike_show ==''? 1 : $like_dislike_show);
            $set_goals_show = ($set_goals_show ==''? 1 : $set_goals_show);
            $scale_show = ($scale_show ==''? 1 : $scale_show);
            $reminder_show = ($reminder_show ==''? 1 : $reminder_show);
            $comments_show = ($comments_show ==''? 1 : $comments_show);
            for($i=0;$i<count($healcareandwellbeing);$i++)
            {
            $sql = "INSERT INTO `tbl_data_dropdown` (`healcareandwellbeing`,`page_name`,`ref_code`,`sub_cat1`,`sub_cat2`,`sub_cat3`,`sub_cat4`,`sub_cat5`,`sub_cat6`,`sub_cat7`,`sub_cat8`,`sub_cat9`,`sub_cat10`,`prof_cat1`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`prof_cat5`,`prof_cat6`,`prof_cat7`,`prof_cat8`,`prof_cat9`,`prof_cat10`,`pag_cat_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`,`time_show`,`duration_show`,`location_show`,`User_view`,`User_Interaction`,`scale_show`,`alert_show`,`heading`,`order_show`,`comment_show`,`location_fav_cat`,`user_response_fav_cat`,`user_what_fav_cat`,`alerts_fav_cat`) "
                . "VALUES ('".addslashes($healcareandwellbeing[$i])."','".addslashes($page_name)."','".addslashes($ref_code)."','".addslashes($sub_cat1)."','".addslashes($sub_cat2)."','".addslashes($sub_cat3)."','".addslashes($sub_cat4)."','".addslashes($sub_cat5)."','".addslashes($sub_cat6)."','".addslashes($sub_cat7)."','".addslashes($sub_cat8)."','".addslashes($sub_cat9)."','".addslashes($sub_cat10)."','".addslashes($prof_cat1)."','".addslashes($prof_cat2)."','".addslashes($prof_cat3)."','".addslashes($prof_cat4)."','".addslashes($prof_cat5)."','".addslashes($prof_cat6)."','".addslashes($prof_cat7)."','".addslashes($prof_cat8)."','".addslashes($prof_cat9)."','".addslashes($prof_cat10)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."','".$time_show."','".$duration_show."','".$location_show."','".$like_dislike_show."','".$set_goals_show."','".$scale_show."','".$reminder_show."','".$heading."','".$order_show."','".$comments_show."','".addslashes($location_category)."','".addslashes($user_response_category)."','".addslashes($user_what_next_category)."','".addslashes($alerts_updates_category)."')";
            $this->execute_query($sql);
            }
            if($this->result)
            {
                $return = true;
            }
            return $return;
	}
        
        public function getAllDataDropdowns($search,$status)
	{
            
            $this->connectDB();

            $admin_id = $_SESSION['admin_id'];
            $edit_action_id = '315';
            $delete_action_id = '316';
            $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
            $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

            if($search != '')
            {
                $sql_str_search = " AND page_name like '%".$search."%' ";
            }
            else 
            {
                $sql_str_search = "";
            }
            
            if($status != '')
            {
                $sql_str_status = " AND pag_cat_status = '".$status."' ";
            }
            else 
            {
                $sql_str_status = "";
            }

             $sql = "SELECT * FROM `tbl_data_dropdown` WHERE is_deleted = '0' $sql_str_search $sql_str_status  ORDER BY page_cat_id DESC";
           
            $this->execute_query($sql);
            $total_records = $this->numRows();
            $record_per_page = 100;
            $scroll = 5;
            $page = new Page(); 
            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
            $page->set_link_parameter("Class = paging");
            $page->set_qry_string($str="mode=manage-data-dropdown");
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
                    
                    $obj2 = new Contents();
                    if($row['pag_cat_status'] == '1')
                    {
                        $status = 'Active';
                    }
                    else
                    {
                        $status = 'Inactive';
                    }
                    
                    if($row['added_by_admin'] == '0')
                    {
                        $added_by_admin = '';
                    }
                    else
                    {
                        $added_by_admin = $obj2->getUsenameOfAdmin($row['added_by_admin']);
                    }

                    $updated_on_date = date('d-m-Y',strtotime($row['updated_on_date']));
//                    $page_name_str = $obj2->getIdByProfileFavCategoryName($row['page_id_str']);           
                            
                    $cat1_imp = explode(',', $row['sub_cat1']);
                    $cat1_imp = implode('\',\'', $cat1_imp);
                   
                    $cat2_imp = explode(',', $row['sub_cat2']);
                    $cat2_imp = implode('\',\'', $cat2_imp);
                    
                    $cat3_imp = explode(',', $row['sub_cat3']);
                    $cat3_imp = implode('\',\'', $cat3_imp);
                    
                    $cat4_imp = explode(',', $row['sub_cat4']);
                    $cat4_imp = implode('\',\'', $cat4_imp);
                    
                    $cat5_imp = explode(',', $row['sub_cat5']);
                    $cat5_imp = implode('\',\'', $cat5_imp);
                    
                    $cat6_imp = explode(',', $row['sub_cat6']);
                    $cat6_imp = implode('\',\'', $cat6_imp);
                    
                    $cat7_imp = explode(',', $row['sub_cat7']);
                    $cat7_imp = implode('\',\'', $cat7_imp);
                    
                    $cat8_imp = explode(',', $row['sub_cat8']);
                    $cat8_imp = implode('\',\'', $cat8_imp);
                    
                    $cat9_imp = explode(',', $row['sub_cat9']);
                    $cat9_imp = implode('\',\'', $cat9_imp);
                    
                    $cat10_imp = explode(',', $row['sub_cat10']);
                    $cat10_imp = implode('\',\'', $cat10_imp);
                     
                    $location_fav_cat = explode(',', $row['location_fav_cat']);
                    $location_fav_cat = implode('\',\'', $location_fav_cat);
                    
                    $user_response_fav_cat = explode(',', $row['user_response_fav_cat']);
                    $user_response_fav_cat = implode('\',\'', $user_response_fav_cat);
                    
                    $user_what_fav_cat = explode(',', $row['user_what_fav_cat']);
                    $user_what_fav_cat = implode('\',\'', $user_what_fav_cat);
                    
                    $alerts_fav_cat = explode(',', $row['alerts_fav_cat']);
                    $alerts_fav_cat = implode('\',\'', $alerts_fav_cat);
                    
                    
                    $time_show = ($row['time_show'] == 0 ? 'Hide' : 'Show');
                    $duration_show = ($row['duration_show'] == 0 ? 'Hide' : 'Show');
                    $location_show = ($row['location_show'] == 0 ? 'Hide' : 'Show');
                    $like_dislike_show = ($row['User_view'] == 0 ? 'Hide' : 'Show');
                    $set_goals_show = ($row['User_Interaction'] == 0 ? 'Hide' : 'Show');
                    $scale_show = ($row['scale_show'] == 0 ? 'Hide' : 'Show');
                    $reminder_show = ($row['alert_show'] == 0 ? 'Hide' : 'Show');
                    $comments_show = ($row['comment_show'] == 0 ? 'Hide' : 'Show');
                    						
                    $output .= '<tr class="manage-row" >';
                    $output .= '<td height="30" align="center">'.$i.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['ref_code']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['heading']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getFavCategoryNameVivek($row['healcareandwellbeing']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($obj2->getPagenamebyid($row['page_name'])).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat1_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat2_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat3_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat4_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat5_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat6_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat7_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat8_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat9_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat10_imp).'</td>';
                    
                    $output .= '<td height="30" align="center">'.$time_show.'</td>';
                    $output .= '<td height="30" align="center">'.$duration_show.'</td>';
                    $output .= '<td height="30" align="center">'.$location_show.'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($location_fav_cat).'</td>';
                    $output .= '<td height="30" align="center">'.$like_dislike_show.'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($user_response_fav_cat).'</td>';
                    $output .= '<td height="30" align="center">'.$set_goals_show.'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($user_what_fav_cat).'</td>';
                    $output .= '<td height="30" align="center">'.$scale_show.'</td>';
                    $output .= '<td height="30" align="center">'.$reminder_show.'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($alerts_fav_cat).'</td>';
                    $output .= '<td height="30" align="center">'.$comments_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['order_show'].'</td>';
                    $output .= '<td height="30" align="center">'.$status.'</td>';
                    $output .= '<td height="30" align="center">'.$row['updated_on_date'].'</td>';
                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';
                    $output .= '<td align="center" nowrap="nowrap">';
                    if($edit) {
                    $output .= '<a href="index.php?mode=edit-data-dropdown&id='.$row['page_cat_id'].'" ><img src = "images/edit.gif" border="0"></a>';
                    }
                    $output .= '</td>';
                    $output .= '<td align="center" nowrap="nowrap">';
                    if($delete) {
                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/deldatadropdown.php?id='.$row['page_cat_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
                    }
                    $output .= '</td>';
                    $output .= '</tr>';
                    $i++;
                }
            }
            else
            {
                $output = '<tr class="manage-row" height="30"><td colspan="28" align="center">NO RECORDS FOUND</td></tr>';
            }
		
            $page->get_page_nav();
            return $output;
	}
       
       public function deleteDataDropdown($page_cat_id)
	{
            $this->connectDB();
            $updated_on_date = date('Y-m-d H:i:s');
             $sql = "UPDATE `tbl_data_dropdown` SET "
                    . "`is_deleted` = '1' , `updated_on_date` = '".$updated_on_date."'"
                    . "WHERE `page_cat_id` = '".$page_cat_id."'";
	  //echo $sql;
            $this->execute_query($sql);
            return $this->result;
	} 
   
        
      public function getDataCatDropdownDetails($page_cat_id)
	{
            $obj2 = new Contents();
            $this->connectDB();
            $pdm_id = '';
            $page_id_str = '';
            $pd_status = '';
            
            $sql = "SELECT * FROM `tbl_data_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' AND `is_deleted` = '0' ";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                
                $healcareandwellbeing = $obj2->getFavCategoryNameVivek($row['healcareandwellbeing']);
                $page_name = stripslashes($row['page_name']);
                $ref_code = stripslashes($row['ref_code']);
                $prof_cat1 = stripslashes($row['prof_cat1']);
                $prof_cat2 = stripslashes($row['prof_cat2']);
                $prof_cat3 = stripslashes($row['prof_cat3']);
                $prof_cat4 = stripslashes($row['prof_cat4']);
                $prof_cat5 = stripslashes($row['prof_cat5']);
                $prof_cat6 = stripslashes($row['prof_cat6']);
                $prof_cat7 = stripslashes($row['prof_cat7']);
                $prof_cat8 = stripslashes($row['prof_cat8']);
                $prof_cat9 = stripslashes($row['prof_cat9']);
                $prof_cat10 = stripslashes($row['prof_cat10']);
                $pag_cat_status = stripslashes($row['pag_cat_status']);
                $heading = stripslashes($row['heading']);
                $time_show = stripslashes($row['time_show']);
                $location_show = stripslashes($row['location_show']);
                $duration_show = stripslashes($row['duration_show']);
                $like_dislike_show = stripslashes($row['User_view']);
                $set_goals_show = stripslashes($row['User_Interaction']);
                $comments_show = stripslashes($row['comment_show']);
                $scale_show = stripslashes($row['scale_show']);
                $reminder_show = stripslashes($row['alert_show']);
                $order_show = stripslashes($row['order_show']);
                $location_category = stripslashes($row['location_fav_cat']);
                $user_response_category = stripslashes($row['user_response_fav_cat']);
                $user_what_next_category = stripslashes($row['user_what_fav_cat']);
                $alerts_updates_category = stripslashes($row['alerts_fav_cat']);
                
            }
            return array($healcareandwellbeing,$page_name,$ref_code,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$pag_cat_status,$heading,$time_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$order_show,$duration_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category);
	}  
    
       public function updateDataCatDropdown($pag_cat_status,$admin_id,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$id,$time_show,$duration_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$heading,$order_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category)
	{
            $this->connectDB();
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "UPDATE `tbl_data_dropdown` SET "
                    . "`ref_code` = '".addslashes($ref_code)."' ,"
                    . "`page_name` = '".addslashes($page_name)."' ,"
                    . "`prof_cat1` = '".addslashes($prof_cat1)."' ,"
                    . "`prof_cat2` = '".addslashes($prof_cat2)."' ,"
                    . "`prof_cat3` = '".addslashes($prof_cat3)."' ,"
                    . "`prof_cat4` = '".addslashes($prof_cat4)."' ,"
                    . "`prof_cat5` = '".addslashes($prof_cat5)."' ,"
                    . "`prof_cat6` = '".addslashes($prof_cat6)."' ,"
                    . "`prof_cat7` = '".addslashes($prof_cat7)."' ,"
                    . "`prof_cat8` = '".addslashes($prof_cat8)."' ,"
                    . "`prof_cat9` = '".addslashes($prof_cat9)."' ,"
                    . "`prof_cat10` = '".addslashes($prof_cat10)."' ,"
                    . "`sub_cat1` = '".addslashes($sub_cat1)."' ,"
                    . "`sub_cat2` = '".addslashes($sub_cat2)."' ,"
                    . "`sub_cat3` = '".addslashes($sub_cat3)."' ,"
                    . "`sub_cat4` = '".addslashes($sub_cat4)."' ,"
                    . "`sub_cat5` = '".addslashes($sub_cat5)."' ,"
                    . "`sub_cat6` = '".addslashes($sub_cat6)."' ,"
                    . "`sub_cat7` = '".addslashes($sub_cat7)."' ,"
                    . "`sub_cat8` = '".addslashes($sub_cat8)."' ,"
                    . "`sub_cat9` = '".addslashes($sub_cat9)."' ,"
                    . "`sub_cat10` = '".addslashes($sub_cat10)."' ,"
                    . "`time_show` = '".addslashes($time_show)."' ,"
                    . "`duration_show` = '".addslashes($duration_show)."' ,"
                    . "`location_show` = '".addslashes($location_show)."' ,"
                    . "`User_view` = '".addslashes($like_dislike_show)."' ,"
                    . "`User_Interaction` = '".addslashes($set_goals_show)."' ,"
                    . "`scale_show` = '".addslashes($scale_show)."' ,"
                    . "`alert_show` = '".addslashes($reminder_show)."' ,"
                    . "`heading` = '".addslashes($heading)."' ,"
                    . "`order_show` = '".addslashes($order_show)."' ,"
                    ."`comment_show` = '".addslashes($comments_show)."' ,"
                    ."`location_fav_cat` = '".addslashes($location_category)."' ,"
                    ."`user_response_fav_cat` = '".addslashes($user_response_category)."' ,"
                    ."`user_what_fav_cat` = '".addslashes($user_what_next_category)."' ,"
                    ."`alerts_fav_cat` = '".addslashes($alerts_updates_category)."' ,"
                    . "`pag_cat_status` = '".addslashes($pag_cat_status)."' ,"
                    . "`updated_by_admin` = '".addslashes($admin_id)."' ,"
                    . "`updated_on_date` = '".addslashes($updated_on_date)."' "
                    . "WHERE `page_cat_id` = '".$id."' ";
	    //echo $sql;
           
            $this->execute_query($sql);
            return $this->result;
	} 
        
     public function getAllFavCatChkeckbox($name,$arr_selected_cat_id,$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
           
            $arr_selected_cat_id = explode(',', $arr_selected_cat_id);
            
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_status` = '1' AND `prct_cat_deleted` = '0' ORDER BY `prct_cat` ASC"; 
            $this->execute_query($sql);
            if($this->numRows() > 0)
            { 
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $cat_id = $row['prct_cat_id'];
                    $cat_name = stripslashes($row['prct_cat']);

                    if(in_array($cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;
                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="'.$name.'[]" id="'.$name.'_'.$i.'" value="'.$cat_id.'" />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
      
        public function getProfileCustomCategoryName($fav_cat_id)
            {
                $this->connectDB();

                $meal_item = array();

                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
                $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` IN('".$fav_cat_id."') ";
                $this->execute_query($sql);
                if($this->numRows() > 0)
                {
                   
                    while($row = $this->fetchRow())
                    {
                     
                      $meal_item[] = stripslashes($row['prct_cat']);
                    }
                }
                //print_r($meal_item) ;
                
                $final_value = implode(',', $meal_item);
                return $final_value;
                
            }    
        
        
 //ramakant end 01-10-2018       
        
}
?>