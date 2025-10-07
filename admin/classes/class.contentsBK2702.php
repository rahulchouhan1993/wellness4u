<?php
include_once("class.paging.php");
include_once("class.admin.php");
class Contents extends Admin
{
    
    
         public function getFavCategoryTypeOptions($fav_cat_type_id)
	{ 
           // $this->connectDB();
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $option_str = '';		
 
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_status` = '1' AND `prct_cat_deleted` = '0' ORDER BY `prct_cat` ASC";
            
            $STH = $DBH->prepare($sql);
            $STH->execute();
				
            if($STH->rowCount()  > 0)
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
                    $option_str .= '<option value="'.$row['prct_cat_id'].'" '.$sel.'>'.stripslashes($row['prct_cat']).'</option>';
                }
            }
            return $option_str;
	}
        
        public function getAllPageDropdowns($search,$status)
	{
           // $this->connectDB();
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
				
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
            //$this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $total_records = $STH->rowCount();
            $record_per_page = 100;
            $scroll = 5;
            $page = new Page(); 
            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
            $page->set_link_parameter("Class = paging");
            $page->set_qry_string($str="mode=page_dropdowns");
            //$result=$this->execute_query($page->get_limit_query($sql));
            $STH2 = $DBH->prepare($page->get_limit_query($sql));
            $STH2->execute();
            $output = '';		
            if($STH2->rowCount()  > 0)
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
                    
                    if($row['menu_id']!='')
                    {
                     $menu_name = $obj2->getCommaSeperatedAdminMenuName($row['menu_id']); 
                    }
                    else
                    {
                      $menu_name ='';  
                    }
                            
						
                    $output .= '<tr class="manage-row">';
                    $output .= '<td height="30" align="center">'.$i.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['pdm_name']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['admin_comment']).'</td>';
                    $output .= '<td height="30" align="center">'.$page_name_str.','.$menu_name.'</td>';
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
            
            //$this->connectDB();
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

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
           
           // $this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $total_records = $STH->rowCount() ;
            $record_per_page = 100;
            $scroll = 5;
            $page = new Page(); 
            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
            $page->set_link_parameter("Class = paging");
            $page->set_qry_string($str="mode=manage_page_fav_cat_dropdowns");
            //$result=$this->execute_query($page->get_limit_query($sql));
            $STH2= $DBH->prepare($page->get_limit_query($sql));
            $STH2->execute();
            $output = '';		
            if($STH2->rowCount()  > 0)
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
                    $output .= '<td height="30" align="center">'.stripslashes($row['ref_code']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['admin_comment']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getFavCategoryNameVivek($row['healcareandwellbeing']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getPagenamebyPage_menu_id('11',$row['page_name'],$row['page_type']).'</td>';
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
           // $this->connectDB();
                 $my_DBH = new mysqlConnection();
                 $DBH = $my_DBH->raw_handle();
                 $DBH->beginTransaction();
                $fav_cat_type = '';

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";
            //$this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $fav_cat_type = stripslashes($row['fav_cat']);
            }
            return $fav_cat_type;
	}
        
        public function getAllPageCatDropdowns($search,$status)
	{
           // print_r($prof_cat);
           // $this->connectDB();
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();

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
           
            //$this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $total_records = $STH->rowCount() ;
            $record_per_page = 100;
            $scroll = 5;
            $page = new Page(); 
            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
            $page->set_link_parameter("Class = paging");
            $page->set_qry_string($str="mode=manage_page_cat_dropdowns");
           // $result=$this->execute_query($page->get_limit_query($sql));
            $STH2 = $DBH->prepare($page->get_limit_query($sql));
            $STH2->execute();
            $output = '';		
            if($STH2->rowCount()  > 0)
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
                    $output .= '<td height="30" align="center">'.stripslashes($row['ref_code']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['admin_comment']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getFavCategoryNameVivek($row['healcareandwellbeing']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getPagenamebyPage_menu_id('9',$row['page_name'],$row['page_type']).'</td>';
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
               // $this->connectDB();
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $meal_item = array();

                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
                $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` IN('".$fav_cat_id."') ";
               // $this->execute_query($sql);
		$STH = $DBH->prepare($sql);
                $STH->execute();
                if($STH->rowCount()  > 0)
                {
                   
                    while($row = $STH->fetch(PDO::FETCH_ASSOC))
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
                //$this->connectDB();
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $meal_item = array();

                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
                $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` IN('".$fav_cat_id."') ";
                //$this->execute_query($sql);
		$STH = $DBH->prepare($sql);
                $STH->execute();
                if($STH->rowCount()  > 0)
                {
                   
                    while($row = $STH->fetch(PDO::FETCH_ASSOC))
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
            //$this->connectDB();
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $output = '';
            
//            if($adviser_panel == '')
//            {
//                $sql_str_search = "";
//            }
//            else 
//            {
//                $sql_str_search = " AND `adviser_panel` = '".$adviser_panel."' ";
//            }

            $sql = "SELECT * FROM `tblpages` WHERE `show_in_manage_menu` = '1' AND `show_in_list` = '1' ORDER BY `menu_title` ASC";    
            //$this->execute_query($sql);
		$STH = $DBH->prepare($sql);
                $STH->execute();
            if($STH->rowCount()  > 0)
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
                    
                    
                    if($row['adviser_panel'] == 1)
                    {
                        $flag = '(Adv)';
                    }
                    else
                    {
                        $flag='';
                    }
                    
                    
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_page_id[]" id="selected_page_id_'.$i.'" value="'.$page_id.'" />&nbsp;<strong>'.$page_name.$flag.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        
        public function getPageDropdownChkeckbox($arr_selected_page_id,$pdm_id,$width = '400',$height = '350')
        {
            //$this->connectDB();
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $output = '';
            
            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '".$pdm_id."' AND `pd_deleted` = '0' ";
            //echo $sql;
           // $this->execute_query($sql);
		$STH = $DBH->prepare($sql);
                $STH->execute();
            if($STH->rowCount()  > 0)
            {
             $row = $STH->fetch(PDO::FETCH_ASSOC);
             $page_id_str = stripslashes($row['page_id_str']);
                
                $sql = "SELECT * FROM `tblpages` WHERE `page_id` IN (".$page_id_str.") AND `show_in_manage_menu` = '1' AND `show_in_list` = '1' ORDER BY `menu_title` ASC";    
                //$this->execute_query($sql);
		$STH2 = $DBH->prepare($sql);
                $STH2->execute();
                if($STH2->rowCount()  > 0)
                {
                    $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                    <input type="checkbox" name="all_selected_page_id" id="all_selected_page_id" value="1" onclick="toggleCheckBoxes(\'selected_page_id\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                                </div>
                                <div style="clear:both;"></div>';
                    $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                    $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                    $i = 1;
                    while($row = $STH2->fetch(PDO::FETCH_ASSOC)) 
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
            //$this->connectDB();
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $output = '';
            
            $sql = "SELECT * FROM `tblpages` WHERE `show_in_manage_menu` = '1' AND `show_in_list` = '1' AND `page_id` IN (".$page_id_str.") ORDER BY `menu_title` ASC";    
           // $this->execute_query($sql);
		$STH = $DBH->prepare($sql);
                $STH->execute();
            if($STH->rowCount()  > 0)
            {
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
            //$this->connectDB();
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
            $option_str = '';		

            $sql = "SELECT * FROM `tblpagedropdownmodules` WHERE `pdm_deleted` = '0' AND `pdm_status` = '1' ORDER BY `pdm_name` ASC";
            //echo $sql;
            //$this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
           // $this->connectDB();
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
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            //$this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id1" id="all_selected_cat_id1" value="1" onclick="toggleCheckBoxes(\'selected_cat_id1\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
           // $this->connectDB();
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
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
           // $this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id2" id="all_selected_cat_id2" value="1" onclick="toggleCheckBoxes(\'selected_cat_id2\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
            //$this->connectDB();
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
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            //$this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id3" id="all_selected_cat_id3" value="1" onclick="toggleCheckBoxes(\'selected_cat_id3\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
            //$this->connectDB();
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
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            //$this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id4" id="all_selected_cat_id4" value="1" onclick="toggleCheckBoxes(\'selected_cat_id4\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
           // $this->connectDB();
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
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
           // $this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id5" id="all_selected_cat_id5" value="1" onclick="toggleCheckBoxes(\'selected_cat_id5\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
           // $this->connectDB();
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
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
           // $this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id6" id="all_selected_cat_id6" value="1" onclick="toggleCheckBoxes(\'selected_cat_id6\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
           // $this->connectDB();
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
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
           // $this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id7" id="all_selected_cat_id7" value="1" onclick="toggleCheckBoxes(\'selected_cat_id7\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
            //$this->connectDB();
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
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
           // $this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
				
            if($STH->rowCount()  > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id8" id="all_selected_cat_id8" value="1" onclick="toggleCheckBoxes(\'selected_cat_id8\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
           $STH = $DBH->prepare($sql);
           $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id9" id="all_selected_cat_id9" value="1" onclick="toggleCheckBoxes(\'selected_cat_id9\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1  ORDER BY `prct_cat` ASC";    
            $STH = $DBH->prepare($sql);
                $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id10" id="all_selected_cat_id10" value="1" onclick="toggleCheckBoxes(\'selected_cat_id10\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $option_str = '';		

            $sql = "SELECT * FROM `tbladminmenu` WHERE 1 ORDER BY `menu_name` ASC";
            //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
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
        public function deletePageDropdown($pd_id)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;
            $updated_on_date = date('Y-m-d H:i:s');
            $sql = "UPDATE `tblpagedropdowns` SET "
                    . "`pd_deleted` = '1' , `updated_on_date` = '".$updated_on_date."'"
                    . "WHERE `pd_id` = '".$pd_id."'";
	    //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
		{
                    $return = true;
		}
            return $return;
	}
         public function deletePageCatDropdown($page_cat_id)
	{
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return=false;
            $updated_on_date = date('Y-m-d H:i:s');
             $sql = "UPDATE `tbl_page_cat_dropdown` SET "
                    . "`is_deleted` = '1' , `updated_on_date` = '".$updated_on_date."'"
                    . "WHERE `page_cat_id` = '".$page_cat_id."'";
	  //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
		{
			$return = true;
		}
		return $return;
	}
	
         public function deletePageFavCatDropdown($page_cat_id)
	{
               $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return=false;
            $updated_on_date = date('Y-m-d H:i:s');
             $sql = "UPDATE `tbl_page_fav_cat_dropdown` SET "
                    . "`is_deleted` = '1' , `updated_on_date` = '".$updated_on_date."'"
                    . "WHERE `page_cat_id` = '".$page_cat_id."'";
	  //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
		{
			$return = true;
		}
		return $return;
	
	}
        
        public function chkPageDropdownModuleExists($pdm_id)
        {
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return=false;

            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '".$pdm_id."' AND `pd_deleted` = '0' ";
            //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $return = true;
            }
            return  $return;
        }
        
        public function chkPageDropdownModuleExists_Edit($pdm_id,$pd_id)
        {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
               $return = false;

            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '".$pdm_id."' AND `pd_id` != '".$pd_id."' AND `pd_deleted` = '0' ";
            //echo $sql;
           $STH = $DBH->prepare($sql);
           $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $return = true;
            }
            return  $return;
        }
        
        
        public function addPageDropdown($pdm_id,$page_id_str,$admin_id)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
              $return = false;
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "INSERT INTO `tblpagedropdowns` (`pdm_id`,`page_id_str`,`pd_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`) "
                . "VALUES ('".addslashes($pdm_id)."','".addslashes($page_id_str)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."')";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $return = true;
            }
            return $return;
	}
        
        public function addPageCatDropdown($admin_comment,$header1,$header2,$header3,$header4,$header5,$header6,$header7,$header8,$header9,$header10,$healcareandwellbeing,$ref_code,$page_name,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$admin_id,$fav_cat_type_id,$page_type)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
				
            $return = false;
            $updated_on_date = date('Y-m-d H:i:s');
            
            for($i=0;$i<count($healcareandwellbeing);$i++)
            {
            $sql = "INSERT INTO `tbl_page_cat_dropdown` (`admin_comment`,`header1`,`header2`,`header3`,`header4`,`header5`,`header6`,`header7`,`header8`,`header9`,`header10`,`healcareandwellbeing`,`page_name`,`ref_code`,`prof_cat1`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`prof_cat5`,`prof_cat6`,`prof_cat7`,`prof_cat8`,`prof_cat9`,`prof_cat10`,`pag_cat_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`,`system_cat`,`page_type`) "
                . "VALUES ('".addslashes($admin_comment)."','".addslashes($header1)."','".addslashes($header2)."','".addslashes($header3)."','".addslashes($header4)."','".addslashes($header5)."','".addslashes($header6)."','".addslashes($header7)."','".addslashes($header8)."','".addslashes($header9)."','".addslashes($header10)."','".addslashes($healcareandwellbeing[$i])."','".addslashes($page_name)."','".addslashes($ref_code)."','".addslashes($prof_cat1)."','".addslashes($prof_cat2)."','".addslashes($prof_cat3)."','".addslashes($prof_cat4)."','".addslashes($prof_cat5)."','".addslashes($prof_cat6)."','".addslashes($prof_cat7)."','".addslashes($prof_cat8)."','".addslashes($prof_cat9)."','".addslashes($prof_cat10)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."','".$fav_cat_type_id."','".$page_type."')";
           $STH = $DBH->prepare($sql);
            $STH->execute();
            }
           if($STH->rowCount()  > 0)
            {
                $return = true;
            }
            return $return;
	}
        
        public function addFavCatDropdown($admin_comment,$fav_cat_type_id_0,$healcareandwellbeing,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$admin_id,$page_type)
	{
            $my_DBH = new mysqlConnection();
             $DBH = $my_DBH->raw_handle();
             $DBH->beginTransaction();
				
            $return = false;
            $updated_on_date = date('Y-m-d H:i:s');
             for($i=0;$i<count($healcareandwellbeing);$i++)
            {
                $sql = "INSERT INTO `tbl_page_fav_cat_dropdown` (`admin_comment`,`system_cat`,`healcareandwellbeing`,`page_name`,`ref_code`,`sub_cat1`,`sub_cat2`,`sub_cat3`,`sub_cat4`,`sub_cat5`,`sub_cat6`,`sub_cat7`,`sub_cat8`,`sub_cat9`,`sub_cat10`,`prof_cat1`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`prof_cat5`,`prof_cat6`,`prof_cat7`,`prof_cat8`,`prof_cat9`,`prof_cat10`,`pag_cat_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`,`page_type`) "
                . "VALUES ('".addslashes($admin_comment)."','".addslashes($fav_cat_type_id_0)."', '".addslashes($healcareandwellbeing[$i])."','".addslashes($page_name)."','".addslashes($ref_code)."','".addslashes($sub_cat1)."','".addslashes($sub_cat2)."','".addslashes($sub_cat3)."','".addslashes($sub_cat4)."','".addslashes($sub_cat5)."','".addslashes($sub_cat6)."','".addslashes($sub_cat7)."','".addslashes($sub_cat8)."','".addslashes($sub_cat9)."','".addslashes($sub_cat10)."','".addslashes($prof_cat1)."','".addslashes($prof_cat2)."','".addslashes($prof_cat3)."','".addslashes($prof_cat4)."','".addslashes($prof_cat5)."','".addslashes($prof_cat6)."','".addslashes($prof_cat7)."','".addslashes($prof_cat8)."','".addslashes($prof_cat9)."','".addslashes($prof_cat10)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."','".$page_type."')";
               $STH = $DBH->prepare($sql);
               $STH->execute();
            }
            if($STH->rowCount()  > 0)
            {
                $return = true;
            }
            return $return;
	}
        
        public function getFunctionNameById($fun_id)
            {
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

                $meal_item = '';

                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
                $sql = "SELECT * FROM `tblpagedropdownmodules` WHERE `pdm_id` ='".$fun_id."' ";
               	$STH = $DBH->prepare($sql);
                $STH->execute();
                if($STH->rowCount()  > 0)
                {
                   
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                    $meal_item = $row['pdm_name'];
                   
                }
                //print_r($meal_item) ;
                
                
                return $meal_item;
                
            }    
        
       
       
         public function getPageCatDropdownDetails($page_cat_id)
	{
            $obj2 = new Contents();
             $my_DBH = new mysqlConnection();
             $DBH = $my_DBH->raw_handle();
             $DBH->beginTransaction();
            $pdm_id = '';
            $page_id_str = '';
            $pd_status = '';
            
            $sql = "SELECT * FROM `tbl_page_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' AND `is_deleted` = '0' ";
            //echo $sql;
           // $this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                
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
                $page_type = stripslashes($row['page_type']);
                $admin_comment = stripslashes($row['admin_comment']);
            }
            return array($admin_comment,$header1,$header2,$header3,$header4,$header5,$header6,$header7,$header8,$header9,$header10,$healcareandwellbeing,$page_name,$ref_code,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$pag_cat_status,$page_type);
	}
       
        
        public function updatePageDropdown($pd_id,$pdm_id,$page_id_str,$pd_status,$admin_id)
	{
               $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
				$return=false;
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "UPDATE `tblpagedropdowns` SET "
                    . "`pdm_id` = '".addslashes($pdm_id)."' ,"
                    . "`page_id_str` = '".addslashes($page_id_str)."' ,"
                    . "`pd_status` = '".addslashes($pd_status)."' ,"
                    . "`updated_by_admin` = '".addslashes($admin_id)."' ,"
                    . "`updated_on_date` = '".addslashes($updated_on_date)."' "
                    . "WHERE `pd_id` = '".$pd_id."' ";
	    //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
		if($STH->rowCount()  > 0)
		{
			$return = true;
		}
		return $return;
	}
    
         public function updatePageCatDropdown($admin_comment,$header1,$header2,$header3,$header4,$header5,$header6,$header7,$header8,$header9,$header10,$pag_cat_status,$admin_id,$ref_code,$page_name,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$id)
	{
                 $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
				$return=false;
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "UPDATE `tbl_page_cat_dropdown` SET "
                    . "`admin_comment` = '".addslashes($admin_comment)."' ,"
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
            $STH = $DBH->prepare($sql);
            $STH->execute();
		if($STH->rowCount()  > 0)
		{
			$return = true;
		}
		return $return;
	}
    
    
	public function GetAllCommonMessagesUser($search)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
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
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount();//if($STH->rowCount()  > 0)
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=common_messages_user");
	 	//$result=$this->execute_query($page->get_limit_query($sql));
		$STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();
		$output = '';		
		if($STH2->rowCount() > 0)
		{
			$i = 1;
			while($row = $STH2->fetch(PDO::FETCH_ASSOC))
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
		//$this->connectDB();
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
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
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=common_messages_adviser");
	 	$STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();
		$output = '';		
		if($STH2->rowCount() > 0)
		{
			$i = 1;
			while($row = $STH2->fetch(PDO::FETCH_ASSOC))
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
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
		$upd_sql = "UPDATE `tblcommonsettings` SET `cs_value` = '".addslashes($cs_value)."' WHERE `cs_id` = '".$cs_id."'";
		$STH = $DBH->prepare($upd_sql);
                $STH->execute();
                if($STH->rowCount() > 0)
                {
                         $return = true;
                 }
                return $return;
	}
	
	public function getCommonMessageDetails($cs_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$cs_name = '';
		$cs_value = '';
		
		$sql = "SELECT * FROM `tblcommonsettings` WHERE `cs_id` = '".$cs_id."' AND `cs_type` = 'MSG'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount()  > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$cs_name = stripslashes($row['cs_name']);
			$cs_value = stripslashes($row['cs_value']);
		}
		return array($cs_name,$cs_value);
	}
	
	
	public function getAllInactiveMenuItems()
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$arr_inactive_menu_items = array();
		
		$admin_id = $_SESSION['admin_id'];
				
		$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '0' ORDER BY `menu_title` ASC ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount()  > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
			{
				array_push($arr_inactive_menu_items,$row);
			}
		}
		
		return $arr_inactive_menu_items;
	}
	
	public function getAllInactiveMenuItemsAdviser()
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$arr_inactive_menu_items = array();
		
		$admin_id = $_SESSION['admin_id'];
				
		$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '0' ORDER BY `menu_title` ASC ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount()  > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
			{
				array_push($arr_inactive_menu_items,$row);
			}
		}
		
		return $arr_inactive_menu_items;
	}
        
        public function getAllInactiveMenuItemsVender()
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$arr_inactive_menu_items = array();
		
		$admin_id = $_SESSION['admin_id'];
				
		$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '1' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '0' ORDER BY `menu_title` ASC ";
                $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount()  > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
			{
				array_push($arr_inactive_menu_items,$row);
			}
		}
		
		return $arr_inactive_menu_items;
	}
	
	public function getAllActiveMenuItems($parent_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$arr_active_menu_items = array();
		
		$admin_id = $_SESSION['admin_id'];
				
		
		$obj2 = new Contents();
		//$obj2->connectDB();
		
		$sql2 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$parent_id."' ORDER BY `menu_order` ASC ";
		//echo'<br><br>sql2 = '.$sql2;
		//$obj2->execute_query($sql2);
                $STH = $DBH->prepare($sql2);
                $STH->execute();
		if($STH->rowCount() > 0)
		{	
			while($row2 = $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_active_menu_items[$row2['page_id']]['menu_details'] = $row2;
				$arr_active_menu_items[$row2['page_id']]['submenu_details'] = array();  
				$sql3 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$row2['page_id']."'  ORDER BY `menu_order` ASC ";
				//echo'<br><br>sql3 = '.$sql3;
				$obj3 = new Contents();
				//$obj3->connectDB();
				//$obj3->execute_query($sql3);
                                
                                $STH2 = $DBH->prepare($sql3);
                                $STH2->execute();
                                
				if($STH2->rowCount() > 0)
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
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                
		$arr_active_menu_items = array();
		$admin_id = $_SESSION['admin_id'];
		
		//$obj2 = new Contents();
		//$obj2->connectDB();
		
		$sql2 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$parent_id."' ORDER BY `menu_order` ASC ";
		//echo'<br><br>sql2 = '.$sql2;
		//$obj2->execute_query($sql2);
                $STH = $DBH->prepare($sql2);
                $STH->execute();
		if($STH->rowCount() > 0)
		{	
			while($row2 = $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_active_menu_items[$row2['page_id']]['menu_details'] = $row2;
				$arr_active_menu_items[$row2['page_id']]['submenu_details'] = array();  
				$sql3 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$row2['page_id']."'  ORDER BY `menu_order` ASC ";
				//echo'<br><br>sql3 = '.$sql3;
				$obj3 = new Contents();
				//$obj3->connectDB();
				//$obj3->execute_query($sql3);
				$STH2 = $DBH->prepare($sql3);
                                $STH2->execute();
                                
				if($STH2->rowCount() > 0)
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
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$arr_active_menu_items = array();
		
		$admin_id = $_SESSION['admin_id'];
				
		
		$obj2 = new Contents();
		//$obj2->connectDB();
		
		$sql2 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '1' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$parent_id."' ORDER BY `menu_order` ASC ";
		//echo'<br><br>sql2 = '.$sql2;
		//$obj2->execute_query($sql2);
		$STH = $DBH->prepare($sql3);
                $STH->execute();

                if($STH->rowCount() > 0)
		{	
			while($row2 = $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_active_menu_items[$row2['page_id']]['menu_details'] = $row2;
				$arr_active_menu_items[$row2['page_id']]['submenu_details'] = array();  
				$sql3 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '1' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$row2['page_id']."'  ORDER BY `menu_order` ASC ";
				//echo'<br><br>sql3 = '.$sql3;
				//$obj3 = new Contents();
				//$obj3->connectDB();
				//$obj3->execute_query($sql3);
				$STH2 = $DBH->prepare($sql3);
                                $STH2->execute();
				if($STH2->rowCount() > 0)
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
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
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
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount() ;
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=contents");
	 	//$result=$this->execute_query($page->get_limit_query($sql));
		$STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();
		$output = '';	
                $obj2 = new Contents();
		if($STH2->rowCount()  > 0)
		{
			$i = 1;
			while($row = $STH2->fetch(PDO::FETCH_ASSOC))
			{
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
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
                                $output .= '<td height="30" align="center">'.$obj2->getUsenameOfAdmin($row['posted_by']).'</td>';
                                $output .= '<td height="30" align="center">'.date("d-m-Y H:i:s",strtotime($row['page_add_date'])).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['page_name']).'</td>';
                                $output .= '<td height="30" align="center">'.stripslashes($row['menu_link']).'</td>';
                                $output .= '<td height="30" align="center"><img src="../../uploads/'.$row['page_icon'].'" style="width:100px; height:100px;"></td>';
                                
                                
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
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
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
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount() ;
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=contents");
	 	//$result=$this->execute_query($page->get_limit_query($sql));
		 $STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();
		$output = '';		
		if($STH2->rowCount()  > 0)
		{
			$i = 1;
			while($row = $STH2->fetch(PDO::FETCH_ASSOC))
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
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
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
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount() ;
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=vender_contents");
	 	//$result=$this->execute_query($page->get_limit_query($sql));
		$STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();
		$output = '';		
		if($STH2->rowCount()  > 0)
		{
			$i = 1;
			while($row = $STH2->fetch(PDO::FETCH_ASSOC))
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
	
	public function AddContent($image,$menu_link,$page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$adviser_panel,$page_contents2,$vender_panel,$admin_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$ins_sql = "INSERT INTO `tblpages`(`page_icon`,`page_name`,`page_title`,`page_contents`,`meta_title`,`meta_keywords`,`meta_description`,`show_in_list`,`show_in_manage_menu`,`link_enable`,`menu_title`,`adviser_panel`,`page_contents2`,`vender_panel`,`posted_by`) VALUES ('".addslashes($image)."','".addslashes($page_name)."','".addslashes($page_title)."','".addslashes($page_contents)."','".addslashes($meta_title)."','".addslashes($meta_keywords)."','".addslashes($meta_description)."','1','1','".addslashes($menu_link_enable)."','".addslashes($menu_title)."','".addslashes($adviser_panel)."','".addslashes($page_contents2)."','".addslashes($vender_panel)."','".addslashes($admin_id)."')";
		$STH = $DBH->prepare($ins_sql);
                $STH->execute();
		
		if($STH->rowCount()  > 0)
		{
			$page_id = $DBH->lastInsertId();
                        if($menu_link!='')
                        {
                            $menu_link_add = $menu_link;
                        }
                        else {
                                if($adviser_panel == '1')
                                {
                                        $menu_link_add = 'practitioners/pages.php?id='.$page_id;
                                }
                                elseif($vender_panel == '1')
                                {
                                        $menu_link_add = 'venders/pages.php?id='.$page_id;
                                }
                                else
                                {
                                        $menu_link_add = 'pages.php?id='.$page_id;
                                }
                            }
			$upd_sql = "UPDATE `tblpages` SET `menu_link` = '".addslashes($menu_link_add)."' WHERE `page_id` = '".$page_id."'";
			$STH2 = $DBH->prepare($upd_sql);
                        $STH2->execute();
                        if($STH2->rowCount()  > 0)
                        {
                                $return = true;
                        }
                        return $return;
	}
        }
	public function getContentDetails($page_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$page_name = '';
		$page_title = '';
		$page_contents = '';
		$meta_title = '';
		$meta_keywords = '';
		$meta_description = '';
		$menu_title = '';
                $menu_link = '';
		$menu_link_enable = 0;
                $page_contents2 = '';
                $page_icon = '';
		
		$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$page_name = stripslashes($row['page_name']);
			$page_title = stripslashes($row['page_title']);
			$page_contents = stripslashes($row['page_contents']);
                        $page_contents2 = stripslashes($row['page_contents2']);
			$meta_title = stripslashes($row['meta_title']);
			$meta_keywords = stripslashes($row['meta_keywords']);
			$meta_description = stripslashes($row['meta_description']);
			$menu_title = stripslashes($row['menu_title']);
                        $menu_link = stripslashes($row['menu_link']);
			$menu_link_enable = stripslashes($row['link_enable']);
                        $page_icon = stripslashes($row['page_icon']);
		}
		return array($page_icon,$menu_link,$page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$page_contents2);
	
	}
	
	
	public function UpdateContent($image,$menu_link,$page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$page_id,$page_contents2,$admin_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return=false;
		$upd_sql = "UPDATE `tblpages` SET `page_icon` = '".addslashes($image)."', `show_in_manage_menu` = 1, `page_name` = '".addslashes($page_name)."' , `page_title` = '".addslashes($page_title)."' , `page_contents` = '".addslashes($page_contents)."' , `page_contents2` = '".addslashes($page_contents2)."' , `meta_title` = '".addslashes($meta_title)."' , `meta_keywords` = '".addslashes($meta_keywords)."' , `meta_description` = '".addslashes($meta_description)."' , `menu_title` = '".addslashes($menu_title)."' ,`menu_link` = '".addslashes($menu_link)."' , `link_enable` = '".addslashes($menu_link_enable)."',`updated_by`='".$admin_id."',`updated_date`='".date("Y-m-d H:i:s")."'   WHERE `page_id` = '".$page_id."'";
		$STH = $DBH->prepare($upd_sql);
                $STH->execute();
		if($STH->rowCount()  > 0)
		{
                    $return = true;
		}
		return $return;
	}
	
	public function DeleteContent($page_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return=false;
		$del_sql1 = "UPDATE `tblpages` SET `show_in_list` = '0' , `show_in_manage_menu` = '0' , `show_in_menu` = '0' WHERE `page_id` = '".$page_id."'"; 
		$STH = $DBH->prepare($del_sql1);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
                        $return = true;
			if($this->chkIfChildPagesExists($page_id))
			{
				$sql2 = "UPDATE `tblpages` SET `show_in_menu` = '0' , `parent_menu` = '0' , `menu_order` = '0' WHERE `parent_menu` = '".$page_id."'"; 
				$STH2 = $DBH->prepare($sql2);
                                $STH2->execute();
			}	
		}
                
		return $return;
	}
	
	public function chkIfChildPagesExists($page_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT * FROM `tblpages` WHERE `show_in_manage_menu` = '1' AND `show_in_list` = '1' AND `parent_menu` = '".$page_id."' ORDER BY `menu_order` ASC ";
		//echo'<br><br>sql = '.$sql;
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{	
			$return = true;
		}
		return $return;
	}
	
//        vivek start
         public function getPageFavCatDropdownDetailsVivek($page_cat_id)
	{
              $obj2 = new Contents();
                $my_DBH = new mysqlConnection();
               $DBH = $my_DBH->raw_handle();
               $DBH->beginTransaction();
            $pdm_id = '';
            $page_id_str = '';
            $pd_status = '';
            
            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' AND `is_deleted` = '0' ";
            //echo $sql;
           $STH = $DBH->prepare($sql);
           $STH->execute();
           if($STH->rowCount() > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                
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
                $page_type = stripslashes($row['page_type']);
                $admin_comment = stripslashes($row['admin_comment']);
            }
            return array($admin_comment,$healcareandwellbeing,$page_name,$ref_code,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$pag_cat_status,$page_type);
	}
       
      public function updatePageFavCatDropdown($admin_comment,$pag_cat_status,$admin_id,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$id)
	{
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
				$return=false;
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "UPDATE `tbl_page_fav_cat_dropdown` SET "
                   . "`admin_comment` = '".addslashes($admin_comment)."' ,"
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
           $STH = $DBH->prepare($sql);
            $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
    
         public function getAllHealcareAndWellbeingPageDropdownData($fav_cat_type_id)
        {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = array();

            $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$fav_cat_type_id."' and tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           //echo $sql;
           $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
              while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                {
                   $return[] = $row['favcat_id'];
               }
            }
            return  $return;
        }
        
//        vivek end

  //Ramakant 01-10-2018
   
   public function getDatadropdownPage($pdm_id,$page_id,$page_type)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $option_str = '';		
            $sel = '';
            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` ='".$pdm_id."' ";
            //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                if($page_type == 'Page')
                {
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
                if($page_type == 'Menu')
                {
                    $str_menu = explode(',', $row['menu_id']);
                    if(!empty($row['menu_id']))
                    {
                        foreach($str_menu as $value) 
                        {
                           if($page_id == $value)
                            {
                                $sel='selected';
                            }
                            else
                            {
                                $sel = '';
                            }
                            //getAdminMenuName($menu_id)
                            $option_str .= '<option value="'.$value.'" '.$sel.' >'.stripslashes($this->getAdminMenuName($value)).'</option>';
                        }
                    }
                }
                
            }
            return $option_str;
	}     
    
        public function getPagenamebyid($page_id) {
          
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $page_name = '';		

            $sql = "SELECT * FROM `tblpages` WHERE `page_id` ='".$page_id."' ";
            //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $page_name = $row['page_name'];
                
            }
            return $page_name; 
            
        }
        
        public function addDataDropdown($admin_comment,$arr_heading,$fav_cat_type_id_0,$healcareandwellbeing,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$admin_id,$time_show,$duration_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$heading,$order_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$cat_fetch_show_data,$canv_sub_cat_link,$data_source,$page_type)
	{
            $my_DBH = new mysqlConnection();
           $DBH = $my_DBH->raw_handle();
           $DBH->beginTransaction();
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
            
            $canv_sub_cat1_show_fetch = ($cat_fetch_show_data['canv_sub_cat1_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_sub_cat1_show_fetch']);
            $canv_sub_cat2_show_fetch = ($cat_fetch_show_data['canv_sub_cat2_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_sub_cat2_show_fetch']);
            $canv_sub_cat3_show_fetch = ($cat_fetch_show_data['canv_sub_cat3_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_sub_cat3_show_fetch']);
            $canv_sub_cat4_show_fetch = ($cat_fetch_show_data['canv_sub_cat4_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_sub_cat4_show_fetch']);
            $canv_sub_cat5_show_fetch = ($cat_fetch_show_data['canv_sub_cat5_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_sub_cat5_show_fetch']);
            $canv_sub_cat6_show_fetch = ($cat_fetch_show_data['canv_sub_cat6_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_sub_cat6_show_fetch']);
            $canv_sub_cat7_show_fetch = ($cat_fetch_show_data['canv_sub_cat7_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_sub_cat7_show_fetch']);
            $canv_sub_cat8_show_fetch = ($cat_fetch_show_data['canv_sub_cat8_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_sub_cat8_show_fetch']);
            $canv_sub_cat9_show_fetch = ($cat_fetch_show_data['canv_sub_cat9_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_sub_cat9_show_fetch']);
            $canv_sub_cat10_show_fetch = ($cat_fetch_show_data['canv_sub_cat10_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_sub_cat10_show_fetch']);
            
            
            
            for($i=0;$i<count($healcareandwellbeing);$i++)
            {
            $sql = "INSERT INTO `tbl_data_dropdown` (`admin_comment`,`system_cat`,`healcareandwellbeing`,`page_name`,`ref_code`,`sub_cat1`,`sub_cat2`,`sub_cat3`,`sub_cat4`,`sub_cat5`,`sub_cat6`,`sub_cat7`,`sub_cat8`,`sub_cat9`,`sub_cat10`,`prof_cat1`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`prof_cat5`,`prof_cat6`,`prof_cat7`,`prof_cat8`,`prof_cat9`,`prof_cat10`,`pag_cat_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`,`time_show`,`duration_show`,`location_show`,`User_view`,`User_Interaction`,`scale_show`,`alert_show`,`heading`,`order_show`,`comment_show`,`location_fav_cat`,`user_response_fav_cat`,`user_what_fav_cat`,`alerts_fav_cat`,`canv_sub_cat1_show_fetch`, `canv_sub_cat2_show_fetch`, `canv_sub_cat3_show_fetch`, `canv_sub_cat4_show_fetch`, `canv_sub_cat5_show_fetch`, `canv_sub_cat6_show_fetch`, `canv_sub_cat7_show_fetch`, `canv_sub_cat8_show_fetch`, `canv_sub_cat9_show_fetch`, `canv_sub_cat10_show_fetch`, `canv_sub_cat1_link`, `canv_sub_cat2_link`, `canv_sub_cat3_link`, `canv_sub_cat4_link`, `canv_sub_cat5_link`, `canv_sub_cat6_link`, `canv_sub_cat7_link`, `canv_sub_cat8_link`, `canv_sub_cat9_link`, `canv_sub_cat10_link`,`data_source`,`page_type`,`time_heading`,`duration_heading`,`location_heading`,`like_dislike_heading`,`set_goals_heading`,`scale_heading`,`reminder_heading`,`comments_heading`) "
                . "VALUES ('".addslashes($admin_comment)."','".addslashes($fav_cat_type_id_0)."','".addslashes($healcareandwellbeing[$i])."','".addslashes($page_name)."','".addslashes($ref_code)."','".addslashes($sub_cat1)."','".addslashes($sub_cat2)."','".addslashes($sub_cat3)."','".addslashes($sub_cat4)."','".addslashes($sub_cat5)."','".addslashes($sub_cat6)."','".addslashes($sub_cat7)."','".addslashes($sub_cat8)."','".addslashes($sub_cat9)."','".addslashes($sub_cat10)."','".addslashes($prof_cat1)."','".addslashes($prof_cat2)."','".addslashes($prof_cat3)."','".addslashes($prof_cat4)."','".addslashes($prof_cat5)."','".addslashes($prof_cat6)."','".addslashes($prof_cat7)."','".addslashes($prof_cat8)."','".addslashes($prof_cat9)."','".addslashes($prof_cat10)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."','".$time_show."','".$duration_show."','".$location_show."','".$like_dislike_show."','".$set_goals_show."','".$scale_show."','".$reminder_show."','".$heading."','".$order_show."','".$comments_show."','".addslashes($location_category)."','".addslashes($user_response_category)."','".addslashes($user_what_next_category)."','".addslashes($alerts_updates_category)."','".$canv_sub_cat1_show_fetch."', '".$canv_sub_cat2_show_fetch."', '".$canv_sub_cat3_show_fetch."','".$canv_sub_cat4_show_fetch."', '".$canv_sub_cat5_show_fetch."', '".$canv_sub_cat6_show_fetch."', '".$canv_sub_cat7_show_fetch."', '".$canv_sub_cat8_show_fetch."', '".$canv_sub_cat9_show_fetch."', '".$canv_sub_cat10_show_fetch."', '".$canv_sub_cat_link['canv_sub_cat1_link']."', '".$canv_sub_cat_link['canv_sub_cat2_link']."', '".$canv_sub_cat_link['canv_sub_cat3_link']."', '".$canv_sub_cat_link['canv_sub_cat4_link']."', '".$canv_sub_cat_link['canv_sub_cat5_link']."', '".$canv_sub_cat_link['canv_sub_cat6_link']."', '".$canv_sub_cat_link['canv_sub_cat7_link']."', '".$canv_sub_cat_link['canv_sub_cat8_link']."', '".$canv_sub_cat_link['canv_sub_cat9_link']."', '".$canv_sub_cat_link['canv_sub_cat10_link']."','".$data_source."','".$page_type."','".$arr_heading['time_heading']."','".$arr_heading['duration_heading']."','".$arr_heading['location_heading']."','".$arr_heading['like_dislike_heading']."','".$arr_heading['set_goals_heading']."','".$arr_heading['scale_heading']."','".$arr_heading['reminder_heading']."','".$arr_heading['comments_heading']."')";
                $STH = $DBH->prepare($sql);
                $STH->execute();
            }
            if($STH->rowCount() > 0)
                {
                     $return = true;
                }
            return $return;
	}
        
        public function getAllDataDropdowns($search,$status)
	{
            
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();

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
           
           // $this->execute_query($sql);
		   $STH = $DBH->prepare($sql);
                $STH->execute();
            $total_records = $STH->rowCount() ;
            $record_per_page = 100;
            $scroll = 5;
            $page = new Page(); 
            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
            $page->set_link_parameter("Class = paging");
            $page->set_qry_string($str="mode=manage-data-dropdown");
           // $result=$this->execute_query($page->get_limit_query($sql));
            $STH2 = $DBH->prepare($page->get_limit_query($sql));
            $STH2->execute();
            $output = '';		
            if($STH2->rowCount()  > 0)
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
                    
                    $canv_sub_cat1_show_fetch = ($row['canv_sub_cat1_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');
                    $canv_sub_cat2_show_fetch = ($row['canv_sub_cat2_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');
                    $canv_sub_cat3_show_fetch = ($row['canv_sub_cat3_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');
                    $canv_sub_cat4_show_fetch = ($row['canv_sub_cat4_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');
                    $canv_sub_cat5_show_fetch = ($row['canv_sub_cat5_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');
                    $canv_sub_cat6_show_fetch = ($row['canv_sub_cat6_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');
                    $canv_sub_cat7_show_fetch = ($row['canv_sub_cat7_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');
                    $canv_sub_cat8_show_fetch = ($row['canv_sub_cat8_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');
                    $canv_sub_cat9_show_fetch = ($row['canv_sub_cat9_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');
                    $canv_sub_cat10_show_fetch = ($row['canv_sub_cat10_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');
                    
                    
                    						
                    $output .= '<tr class="manage-row" >';
                    $output .= '<td height="30" align="center">'.$i.'</td>';
                    $output .= '<td height="30" align="center">'.$status.'</td>';
                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';
                    $output .= '<td height="30" align="center">'.$row['updated_on_date'].'</td>';
                    $output .= '<td align="center" nowrap="nowrap">';
                    if($edit) {
                    $output .= '<a href="index.php?mode=edit-data-dropdown&id='.$row['page_cat_id'].'" ><img src = "images/edit.gif" border="0"></a>';
                    }
                    $output .= '</td>';
                    $output .= '<td align="center" nowrap="nowrap">';
                    if($delete) {
                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/deldatadropdown.php?id='.$row['page_cat_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
                    }
                   
                    $output .= '<td height="30" align="center">'.stripslashes($row['ref_code']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['admin_comment']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['heading']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getFavCategoryNameVivek($row['healcareandwellbeing']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($obj2->getPagenamebyPage_menu_id('4',$row['page_name'],$row['page_type'])).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($obj2->getPagenamebyid($row['data_source'])).'</td>';
                    //getProfileCustomCategoryName
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat1']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat1_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$canv_sub_cat1_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat1_link']).'</td>';
                    
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat2']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat2_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$canv_sub_cat2_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat2_link']).'</td>';
                    
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat3']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat3_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$canv_sub_cat3_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat3_link']).'</td>';
                    
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat4']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat4_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$canv_sub_cat4_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat4_link']).'</td>';
                    
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat5']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat5_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$canv_sub_cat5_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat5_link']).'</td>';
                    
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat6']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat6_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$canv_sub_cat6_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat6_link']).'</td>';
                    
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat7']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat7_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$canv_sub_cat7_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat7_link']).'</td>';
                    
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat8']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat8_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$canv_sub_cat8_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat8_link']).'</td>';
                    
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat9']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat9_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$canv_sub_cat9_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat9_link']).'</td>';
                    
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat10']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat10_imp).'</td>';
                    $output .= '<td height="30" align="center">'.$canv_sub_cat10_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat10_link']).'</td>';
                    
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
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
				$return=false;
            $updated_on_date = date('Y-m-d H:i:s');
             $sql = "UPDATE `tbl_data_dropdown` SET "
                    . "`is_deleted` = '1' , `updated_on_date` = '".$updated_on_date."'"
                    . "WHERE `page_cat_id` = '".$page_cat_id."'";
	  //echo $sql;
           $STH = $DBH->prepare($sql);
            $STH->execute();
		if($STH->rowCount()  > 0)
		{
			$return = true;
		}
		return $return;
	} 
   
        
      public function getDataCatDropdownDetails($page_cat_id)
	{
            $obj2 = new Contents();
            $my_DBH = new mysqlConnection();
             $DBH = $my_DBH->raw_handle();
             $DBH->beginTransaction();
            $pdm_id = '';
            $page_id_str = '';
            $pd_status = '';
            
            $sql = "SELECT * FROM `tbl_data_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' AND `is_deleted` = '0' ";
            //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                
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
                $data_source = stripslashes($row['data_source']);
                $page_type = stripslashes($row['page_type']);
                $canv_sub_cat1_link= $row['canv_sub_cat1_link'];
                $canv_sub_cat2_link= $row['canv_sub_cat2_link'];
                $canv_sub_cat3_link= $row['canv_sub_cat3_link'];
                $canv_sub_cat4_link= $row['canv_sub_cat4_link'];
                $canv_sub_cat5_link= $row['canv_sub_cat5_link'];
                $canv_sub_cat6_link= $row['canv_sub_cat6_link'];
                $canv_sub_cat7_link= $row['canv_sub_cat7_link'];
                $canv_sub_cat8_link= $row['canv_sub_cat8_link'];
                $canv_sub_cat9_link= $row['canv_sub_cat9_link'];
                $canv_sub_cat10_link= $row['canv_sub_cat10_link'];
                
                $canv_sub_cat1_show_fetch = $row['canv_sub_cat1_show_fetch'];
                $canv_sub_cat2_show_fetch = $row['canv_sub_cat2_show_fetch'];
                $canv_sub_cat3_show_fetch = $row['canv_sub_cat3_show_fetch'];
                $canv_sub_cat4_show_fetch = $row['canv_sub_cat4_show_fetch'];
                $canv_sub_cat5_show_fetch = $row['canv_sub_cat5_show_fetch'];
                $canv_sub_cat6_show_fetch = $row['canv_sub_cat6_show_fetch'];
                $canv_sub_cat7_show_fetch = $row['canv_sub_cat7_show_fetch'];
                $canv_sub_cat8_show_fetch = $row['canv_sub_cat8_show_fetch'];
                $canv_sub_cat9_show_fetch = $row['canv_sub_cat9_show_fetch'];
                $canv_sub_cat10_show_fetch = $row['canv_sub_cat10_show_fetch'];
                 
                $arr_heading = array();
                $arr_heading['time_heading']=$row['time_heading'];
                $arr_heading['duration_heading']=$row['duration_heading'];
                $arr_heading['location_heading']=$row['location_heading'];
                $arr_heading['like_dislike_heading']=$row['like_dislike_heading'];
                $arr_heading['set_goals_heading']=$row['set_goals_heading'];
                $arr_heading['scale_heading']=$row['scale_heading'];
                $arr_heading['reminder_heading']=$row['reminder_heading'];
                $arr_heading['comments_heading']=$row['comments_heading'];
                $admin_comment=$row['admin_comment'];
                
                
                
                
            }
            return array($admin_comment,$arr_heading,$healcareandwellbeing,$page_name,$ref_code,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$pag_cat_status,$heading,$time_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$order_show,$duration_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$canv_sub_cat1_link,$canv_sub_cat2_link,$canv_sub_cat3_link,$canv_sub_cat4_link,$canv_sub_cat5_link,$canv_sub_cat6_link,$canv_sub_cat7_link,$canv_sub_cat8_link,$canv_sub_cat9_link,$canv_sub_cat10_link, $canv_sub_cat1_show_fetch,$canv_sub_cat2_show_fetch,$canv_sub_cat3_show_fetch,$canv_sub_cat4_show_fetch,$canv_sub_cat5_show_fetch,$canv_sub_cat6_show_fetch,$canv_sub_cat7_show_fetch,$canv_sub_cat8_show_fetch,$canv_sub_cat9_show_fetch,$canv_sub_cat10_show_fetch,$page_type);
	}  
    
       public function updateDataCatDropdown($admin_comment,$arr_heading,$pag_cat_status,$admin_id,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$id,$time_show,$duration_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$heading,$order_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$cat_fetch_show_data,$canv_sub_cat_link,$data_source)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "UPDATE `tbl_data_dropdown` SET "
                    . "`admin_comment` = '".addslashes($admin_comment)."' ,"
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
                    . "`data_source` = '".addslashes($data_source)."' ,"
                    . "`canv_sub_cat1_show_fetch` = '".addslashes($cat_fetch_show_data['canv_sub_cat1_show_fetch'])."' ,"
                    . "`canv_sub_cat2_show_fetch` = '".addslashes($cat_fetch_show_data['canv_sub_cat2_show_fetch'])."' ,"
                    . "`canv_sub_cat3_show_fetch` = '".addslashes($cat_fetch_show_data['canv_sub_cat3_show_fetch'])."' ,"
                    . "`canv_sub_cat4_show_fetch` = '".addslashes($cat_fetch_show_data['canv_sub_cat4_show_fetch'])."' ,"
                    . "`canv_sub_cat5_show_fetch` = '".addslashes($cat_fetch_show_data['canv_sub_cat5_show_fetch'])."' ,"
                    . "`canv_sub_cat6_show_fetch` = '".addslashes($cat_fetch_show_data['canv_sub_cat6_show_fetch'])."' ,"
                    . "`canv_sub_cat7_show_fetch` = '".addslashes($cat_fetch_show_data['canv_sub_cat7_show_fetch'])."' ,"
                    . "`canv_sub_cat8_show_fetch` = '".addslashes($cat_fetch_show_data['canv_sub_cat8_show_fetch'])."' ,"
                    . "`canv_sub_cat9_show_fetch` = '".addslashes($cat_fetch_show_data['canv_sub_cat9_show_fetch'])."' ,"
                    . "`canv_sub_cat10_show_fetch` = '".addslashes($cat_fetch_show_data['canv_sub_cat10_show_fetch'])."' ,"
                    . "`canv_sub_cat1_link` = '".addslashes($canv_sub_cat_link['canv_sub_cat1_link'])."' ,"
                    . "`canv_sub_cat2_link` = '".addslashes($canv_sub_cat_link['canv_sub_cat2_link'])."' ,"
                    . "`canv_sub_cat3_link` = '".addslashes($canv_sub_cat_link['canv_sub_cat3_link'])."' ,"
                    . "`canv_sub_cat4_link` = '".addslashes($canv_sub_cat_link['canv_sub_cat4_link'])."' ,"
                    . "`canv_sub_cat5_link` = '".addslashes($canv_sub_cat_link['canv_sub_cat5_link'])."' ,"
                    . "`canv_sub_cat6_link` = '".addslashes($canv_sub_cat_link['canv_sub_cat6_link'])."' ,"
                    . "`canv_sub_cat7_link` = '".addslashes($canv_sub_cat_link['canv_sub_cat7_link'])."' ,"
                    . "`canv_sub_cat8_link` = '".addslashes($canv_sub_cat_link['canv_sub_cat8_link'])."' ,"
                    . "`canv_sub_cat9_link` = '".addslashes($canv_sub_cat_link['canv_sub_cat9_link'])."' ,"
                    . "`canv_sub_cat10_link` = '".addslashes($canv_sub_cat_link['canv_sub_cat10_link'])."' ,"
                    . "`time_heading` = '".addslashes($arr_heading['time_heading'])."' ,"
                    . "`duration_heading` = '".addslashes($arr_heading['duration_heading'])."' ,"
                    . "`location_heading` = '".addslashes($arr_heading['location_heading'])."' ,"
                    . "`like_dislike_heading` = '".addslashes($arr_heading['like_dislike_heading'])."' ,"
                    . "`set_goals_heading` = '".addslashes($arr_heading['set_goals_heading'])."' ,"
                    . "`scale_heading` = '".addslashes($arr_heading['scale_heading'])."' ,"
                    . "`reminder_heading` = '".addslashes($arr_heading['reminder_heading'])."' ,"
                    . "`comments_heading` = '".addslashes($arr_heading['comments_heading'])."' ,"
                    . "`updated_by_admin` = '".addslashes($admin_id)."' ,"
                    . "`updated_on_date` = '".addslashes($updated_on_date)."' "
                    . "WHERE `page_cat_id` = '".$id."' ";
	    //echo $sql;
           
            $STH = $DBH->prepare($sql);
            $STH->execute();
		if($STH->rowCount()  > 0)
		{
			$return = true;
		}
		return $return;
	} 
        
     public function getAllFavCatChkeckbox($name,$arr_selected_cat_id,$width = '400',$height = '350')
        {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $output = '';
           
            $arr_selected_cat_id = explode(',', $arr_selected_cat_id);
            
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_status` = '1' AND `prct_cat_deleted` = '0' ORDER BY `prct_cat` ASC"; 
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            { 
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
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
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

                $meal_item = array();

                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
                $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` IN('".$fav_cat_id."') ";
                $STH = $DBH->prepare($sql);
                $STH->execute();
                if($STH->rowCount()  > 0)
                {
                   
                    while($row = $STH->fetch(PDO::FETCH_ASSOC))
                    {
                     
                      $meal_item[] = stripslashes($row['prct_cat']);
                    }
                }
                //print_r($meal_item) ;
                
                $final_value = implode(',', $meal_item);
                return $final_value;
                
            }    
     
      public function getDataREFCOde($id)
            {
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $final_value = '';
               
                $sql = "SELECT * FROM `tbl_data_dropdown` WHERE `page_cat_id` ='".$id."' ";
                $STH = $DBH->prepare($sql);
                $STH->execute();
                if($STH->rowCount()  > 0)
                {
                   
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                }
                //print_r($meal_item) ;
                
                $final_value = $row['ref_code'];
                return $final_value;
                
            }          
            
    //vivek changes start   07-10-2018  
    // vivek changes end        
        public function addPageDropdownVivek($admin_comment,$pdm_id,$page_id_str,$admin_id,$menu_id,$table_name)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = false;
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "INSERT INTO `tblpagedropdowns` (`admin_comment`,`menu_id`,`pdm_id`,`page_id_str`,`pd_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`,`plan_table`) "
                . "VALUES ('".addslashes($admin_comment)."','".addslashes($menu_id)."','".addslashes($pdm_id)."','".addslashes($page_id_str)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."','".$table_name."')";
                $STH = $DBH->prepare($sql);
                $STH->execute();
            if($STH->rowCount() > 0)
                {
                     $return = true;
                }
            return $return;
	}
    
    public function chkPageDropdownModuleExists_EditVivek($pdm_name)
        {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = false;

            $sql = "SELECT * FROM `tblpagedropdownmodules` WHERE `pdm_name` = '".$pdm_name."'  AND `pdm_deleted` = '0' ";
            //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
                {
                     $return = true;
                }
            return  $return;
        }    
     public function addPageDropdownModuleVivek($pdm_name)
	{
               $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
            $return = false;
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "INSERT INTO `tblpagedropdownmodules` (`pdm_name`,`pdm_status`,`pdm_add_date`) "
                . "VALUES ('".addslashes($pdm_name)."','1','".$updated_on_date."')";
            $STH = $DBH->prepare($sql);
                $STH->execute();
            if($STH->rowCount() > 0)
                {
                     $return = true;
                }
            return $return;
	}    
    public function getPageDropdownDetails($pd_id)
	{
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
            $pdm_id = '';
            $page_id_str = '';
            $pd_status = '';
            
            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pd_id` = '".$pd_id."' AND `pd_deleted` = '0' ";
            //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $pdm_id = stripslashes($row['pdm_id']);
                $page_id_str = stripslashes($row['page_id_str']);
                $pd_status = stripslashes($row['pd_status']);
                $menu_id = stripslashes($row['menu_id']);
            }
            return array($pdm_id,$page_id_str,$pd_status,$menu_id);
	}        
    public function getAllAdminMenuChkeckbox($arr_selected_page_id,$adviser_panel = '',$width = '400',$height = '350')
        {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $output = '';
            
            
            $sql = "SELECT * FROM `tbladminmenu` WHERE `status` = '1'  ORDER BY `menu_name` ASC";    
            $STH = $DBH->prepare($sql);
                $STH->execute();
           if($STH->rowCount() > 0)
            {
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_admin_menu_id" id="all_admin_menu_id" value="1" onclick="toggleCheckBoxes(\'admin_menu_id\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                {

                    $menu_id = $row['menu_id'];
                    $menu_name = stripslashes($row['menu_name']);

                    if(in_array($menu_id,$arr_selected_page_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="admin_menu_id[]" id="admin_menu_id_'.$i.'" value="'.$menu_id.'" />&nbsp;<strong>'.$menu_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }    
        
        //second part
        
         public function getCommaSeperatedAdminMenuName($menu_id)
        {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $output = '';
            
            $sql = "SELECT * FROM `tbladminmenu` WHERE `status` = '1'  AND `menu_id` IN (".$menu_id.") ORDER BY `menu_name` ASC";    
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                {
                    $menu_name = stripslashes($row['menu_name']);
                    $output .= $menu_name.' ,';
                }
                $output = substr($output,0,-1);
            }
            return $output;
        }
     // third   
     public function getPageDropdownDetailsVivek($pd_id)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $pdm_id = '';
            $page_id_str = '';
            $pd_status = '';
            
            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pd_id` = '".$pd_id."' AND `pd_deleted` = '0' ";
            //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $pdm_id = stripslashes($row['pdm_id']);
                $page_id_str = stripslashes($row['page_id_str']);
                $pd_status = stripslashes($row['pd_status']);
                $menu_id = stripslashes($row['menu_id']);
                $admin_comment = $row['admin_comment'];
                $plan_table = $row['plan_table'];
            }
            return array($admin_comment,$pdm_id,$page_id_str,$pd_status,$menu_id,$plan_table);
	}    
        
       public function updatePageDropdownVivek($admin_comment,$pd_id,$pdm_id,$page_id_str,$pd_status,$admin_id,$menu_id,$table_name)
	{
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
				$return=false;
            $updated_on_date = date('Y-m-d H:i:s');
            
            $sql = "UPDATE `tblpagedropdowns` SET "
                    . "`admin_comment` = '".addslashes($admin_comment)."' ,"
                    . "`pdm_id` = '".addslashes($pdm_id)."' ,"
                    . "`menu_id` = '".addslashes($menu_id)."' ,"
                    . "`page_id_str` = '".addslashes($page_id_str)."' ,"
                    . "`pd_status` = '".addslashes($pd_status)."' ,"
                    . "`updated_by_admin` = '".addslashes($admin_id)."' ,"
                    . "`updated_on_date` = '".addslashes($updated_on_date)."' ,"
                    . "`plan_table` = '".addslashes($table_name)."' "
                    . "WHERE `pd_id` = '".$pd_id."' ";
	    //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	} 
        
        public function getAdminMenuName($menu_id)
        {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $menu_name = '';
            $sql = "SELECT * FROM `tbladminmenu` WHERE `status` = '1'  AND `menu_id` = '".$menu_id."' ";    
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                {
                    $menu_name = stripslashes($row['menu_name']);                  
                }           
            }
            return $menu_name;
        }
        
   public function getEventdatashow($event_id)
   {
     
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $date = date("Y-m-d h:i:s");
            $option_str = '';	
            
            $data = array();

            $sql = "SELECT * FROM `tbl_event_master` where `status` = '1' AND `event_master_id` = '".$event_id."' ";
            //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
            }
            
            $option_str .= "<span style='font-size:14px; text-align:left;'>Event Name: ".$row['event_name']."</span><br>";
            $option_str .= "<span style='font-size:14px; text-align:left;'>Organizer Name: ".$this->getorganizername($row['organiser_id']).", Institution Name: ".$this->getorganizername($row['institution_id']).", Sponsor Name: ".$this->getorganizername($row['sponsor_id'])."</span><br>";
            $option_str .= "<span style='font-size:14px; text-align:left;'>Main Cat:".$this->getFavCategoryNameVivek($row['wellbeing_id'])."</span>";
            
            $data['show_data'] = $option_str;
            $data['healcareandwellbeing'] = $row['wellbeing_id'];
            
            
            return $data;
       
   }
   
   public function getorganizername($vendor_id)
   {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $option_str = '';		

        $sql = "SELECT * FROM `tblvendors` where `vendor_id` = '".$vendor_id."' AND `vendor_status` = '1' ";
        //echo $sql;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $option_str =$row['vendor_name'];
        }
        return $option_str;
            
   }
   
   public function getprofcatname($prct_cat_id)
   {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $option_str = '';		

        $sql = "SELECT * FROM `tblprofilecustomcategories` where `prct_cat_id` = '".$prct_cat_id."' AND `prct_cat_status` = '1' ";
        //echo $sql;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $option_str =$row['prct_cat'];
        }
        return $option_str; 
   }
   
   public function getpfavcatname($fav_cat_id)
   {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $option_str = '';		

        $sql = "SELECT * FROM `tblfavcategory` where `fav_cat_id` = '".$fav_cat_id."' AND `fav_cat_status` = '1' ";
        //echo $sql;
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $option_str =$row['fav_cat'];
        }
        return $option_str;  
   }
   
   public function updateMenuOrders($arr_page_id,$arr_parent_id,$arr_menu_order,$arr_link_enable)

{

	$my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

	$return = false;
	$sql = "UPDATE `tblpages` SET `show_in_menu` = '0' WHERE `adviser_panel` = '0' AND `vender_panel` = '0' ";

	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)

	{

		for($i=0;$i<count($arr_page_id);$i++)

		{

			$sql = "UPDATE `tblpages` SET `show_in_menu` = '1' , `parent_menu` = '".$arr_parent_id[$i]."' , `menu_order` = '".$arr_menu_order[$i]."' WHERE `page_id` = '".$arr_page_id[$i]."' AND `adviser_panel` = '0' AND `vender_panel` = '0' ";
                        $STH2 = $DBH->prepare($sql);
			$STH2->execute();
                        if($STH2->rowCount() > 0)

			{

				$return = true;

			}

		}	

	}

return $return;

}

public function getPagenamebyPage_menu_id($cat_id,$page_id,$page_type) {
          
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $page_name = '';		

            //$type = $this->getpagetype($cat_id,$page_id);
            
            if($page_type == 'Page')
            {
                $sql = "SELECT * FROM `tblpages` WHERE `page_id` ='".$page_id."' ";
                //echo $sql;
                $STH = $DBH->prepare($sql);
                $STH->execute();
                if($STH->rowCount() > 0)
                {
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                    $page_name = $row['page_name'];

                }
            }
            
            if($page_type == 'Menu')
            {
               // $sql = "SELECT * FROM `tblpages` WHERE `page_id` ='".$page_id."' ";
                $sql = "SELECT * FROM `tbladminmenu` WHERE `status` = '1'  AND `menu_id` = '".$page_id."' ORDER BY `menu_name` ASC";    
                //echo $sql;
                $STH = $DBH->prepare($sql);
                $STH->execute();
                if($STH->rowCount() > 0)
                {
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                    $page_name = $row['menu_name'];

                }
            }
            
            
            return $page_name; 
            
        }

  public function getpagetype($cat_id,$page_id)
  {
   
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $page_name = '';
            $menu_name='';
            $type= '';

            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` ='".$cat_id."' ";
            //echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $page_name = $row['page_id_str'];
                $menu_name = $row['menu_id'];
                
            }
            $page_name_arr = explode(',', $page_name);
            $menu_name_arr = explode(',', $menu_name);
            
            
            if(in_array($page_id, $page_name_arr))
            {
              $type = 'page';  
            }
            
            if(in_array($page_id, $menu_name_arr))
            {
              $type = 'menu';  
            }
            
            
            return $type;   
      
  }
 
  public function getprofcatoption($page_name,$healcareandwellbeing,$prof_cat)
  {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $option_str = '';		
 
            $sql = "SELECT * FROM `tbl_page_cat_dropdown` WHERE `page_name` = '".$page_name."' AND `healcareandwellbeing` = '".$healcareandwellbeing."' ORDER BY `page_cat_id` ASC";
            
            $STH = $DBH->prepare($sql);
            $STH->execute();
				
            if($STH->rowCount()  > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $profcat = $row["$prof_cat"];
                //echo $profcat;
                $profcat_final = explode(',', $profcat);
                $option_str .='<option value="">Select Type</option>';
                for($i=0;$i<count($profcat_final);$i++)
                {		
                    $option_str .= '<option value="'.$profcat_final[$i].'">'.stripslashes($this->getprofcatname($profcat_final[$i])).'</option>';
                }
            }
            return $option_str;
  }
  
  public function GETDATADROPDOWNMYDAYTODAY($healcareandwellbeing,$page_name)
{
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$arr_data = array();
	$sql = "SELECT * FROM `tbl_data_dropdown` WHERE page_name = '".$page_name."' and `healcareandwellbeing` = '".$healcareandwellbeing."' and `is_deleted` = 0 ORDER BY `order_show` ASC";
	
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if( $STH->rowCount() > 0 )
        {

		while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

		{
			$arr_data[] = $row;
		}
	}
	return $arr_data;
}


public function GETDATADROPDOWNMYDAYTODAYOPTION($page_cat_id,$page_name)
{
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$arr_data = array();
	$sql = "SELECT * FROM `tbl_data_dropdown` WHERE page_name = '".$page_name."' and `page_cat_id` = '".$page_cat_id."' and `is_deleted` = 0 ORDER BY `order_show` ASC";
	
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if( $STH->rowCount() > 0 )
        {

		while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

		{
			$arr_data[] = $row;
		}
	}
	return $arr_data;
}

public function getAllMainSymptomsRamakantFront($symtum_cat)
    {       
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $symtum_cat = implode($symtum_cat, '\',\'');
        $str_sql_search = " AND `fav_parent_cat` IN ('".$symtum_cat."') ";
        $data = array();
        $sql = "SELECT DISTINCT bmsid FROM `tblsymtumscustomcategory` WHERE  symtum_deleted = '0' ".$str_sql_search." ORDER BY bmsid DESC ";		
        
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {           
                $data[] = $row['bmsid'];
            }
	}
	return $data;  
        
    }
    
    public function GetDatadropdownoption($symtum_cat)
{
        $symtum_cat = implode(',', $symtum_cat);
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$option_str = '';
	$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE bms_id IN($symtum_cat) ORDER BY `bms_name` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {			
                $option_str .= '<option value="'.$row['bms_id'].'" >'.stripslashes($row['bms_name']).'</option>';

            }
	}
	return $option_str;  
}
 
public function AddDesignMyLife($text_box_show,$text_box_count,$user_upload_show,$box_count,$quick_response_show,$quick_tip_icon,$quick_response_heading,$response_heading,$video_1,$video_2,$show_to_user,$fav_cat_type_id_header,$page_cat_id,$cat_fetch_show_data,$canv_sub_cat_link,$prof_cat2,$prof_cat3,$prof_cat4,$sub_cat2,$sub_cat3,$sub_cat4,$narration_show,$comment_order_show,$reminder_order_show,$scale_order_show,$set_goals_order_show,$like_dislike_order_show,$location_order_show,$duration_order_show,$time_order_show,$user_date_order_show,$image2_order_show,$image1_order_show,$image_1_show,$image_2_show,$ref_code,$admin_comment,$title_id,$narration,$listing_date_type,$single_date,$start_date,$end_date,$banner_type_1,$banner_1,$credit_line_1,$credit_line_url_1,$sound_clip_id_1,$banner_type_2,$banner_2,$credit_line_2,$credit_line_url_2,$sound_clip_id_2,$user_date_show,$user_date_show_heading,$time_show,$time_heading,$duration_show,$duration_heading,$location_show,$location_heading,$location_category,$like_dislike_show,$like_dislike_heading,$user_response_category,$set_goals_show,$set_goals_heading,$user_what_next_category,$scale_show,$scale_heading,$reminder_show,$reminder_heading,$alerts_updates_category,$comments_show,$comments_heading,$order_show,$fav_cat_type_id,$days_of_month_data,$days_of_week_data,$month_data,$fav_cat_id_data,$admin_id)
{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $sub_cat2_show_fetch = ($cat_fetch_show_data['sub_cat2_show_fetch'] ==''? 0 : $cat_fetch_show_data['sub_cat2_show_fetch']);
            $sub_cat3_show_fetch = ($cat_fetch_show_data['sub_cat3_show_fetch'] ==''? 0 : $cat_fetch_show_data['sub_cat3_show_fetch']);
            $sub_cat4_show_fetch = ($cat_fetch_show_data['sub_cat4_show_fetch'] ==''? 0 : $cat_fetch_show_data['sub_cat4_show_fetch']);
            
            $return = false;
             try {
             $sql = "INSERT INTO `tbl_design_your_life`(`input_box_show`,`input_box_count`,`user_upload_show`,`box_count`,`quick_response_show`,`quick_tip_icon`,`quick_response_heading`,`response_heading`,`video_link_1`,`video_link_2`,`show_to_user`,`fav_cat_type_id_header`,`data_category`,`narration_show`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`sub_cat2`,`sub_cat3`,`sub_cat4`,`sub_cat2_show_fetch`,`sub_cat3_show_fetch`,`sub_cat4_show_fetch`,`sub_cat2_link`,`sub_cat3_link`,`sub_cat4_link`,`ref_code`, `box_title`, `narration`, `image_type_1`, `image_1`, `image_1_show`, `image_2`, `image_type_2`, `image_2_show`, `sound_clip_1`, `sound_clip_2`, `image_credit_1`, `image_credit_url_1`, `image_credit_2`, `image_credit_url_2`, `admin_comment`, "
                    . "`listing_date_type`, `days_of_month`, `single_date`, `start_date`, `end_date`, `days_of_week`, `months`, `user_date_show`, `time_show`, `duration_show`, `location_show`, `User_view`, `User_Interaction`, `scale_show`, `alert_show`, `comment_show`, `user_date_heading`, `time_heading`, "
                    . "`duration_heading`, `location_heading`, `like_dislike_heading`, `set_goals_heading`, `scale_heading`, `reminder_heading`, `comments_heading`, `location_fav_cat`, `user_response_fav_cat`, `user_what_fav_cat`, `alerts_fav_cat`, `order_show`,`added_by`,`prof_cat_id`,`sub_cat_id`,`comment_order_show`,`reminder_order_show`,`scale_order_show`,`set_goals_order_show`,`like_dislike_order_show`,`location_order_show`,`duration_order_show`,`time_order_show`,`user_date_order_show`,`image2_order_show`,`image1_order_show`) "
                    . "VALUES ('".addslashes($text_box_show)."','".addslashes($text_box_count)."','".addslashes($user_upload_show)."','".addslashes($box_count)."','".addslashes($quick_response_show)."','".addslashes($quick_tip_icon)."','".addslashes($quick_response_heading)."','".addslashes($response_heading)."','".addslashes($video_1)."','".addslashes($video_2)."','".addslashes($show_to_user)."','".addslashes($fav_cat_type_id_header)."','".$page_cat_id."','".$narration_show."','".$prof_cat2."','".$prof_cat3."','".$prof_cat4."','".$sub_cat2."','".$sub_cat3."','".$sub_cat4."','".$sub_cat2_show_fetch."','".$sub_cat3_show_fetch."','".$sub_cat4_show_fetch."','".$canv_sub_cat_link['sub_cat2_link']."','".$canv_sub_cat_link['sub_cat3_link']."','".$canv_sub_cat_link['sub_cat4_link']."','".addslashes($ref_code)."','".($title_id)."','".addslashes($narration)."','".$banner_type_1."','".addslashes($banner_1)."','".$image_1_show."','".addslashes($banner_2)."','".$banner_type_2."','".$image_2_show."','".$sound_clip_id_1."','".$sound_clip_id_2."','".addslashes($credit_line_1)."',"
                    . "'".addslashes($credit_line_url_1)."','".addslashes($credit_line_2)."','".addslashes($credit_line_url_2)."','".addslashes($admin_comment)."','".addslashes($listing_date_type)."','".addslashes($days_of_month_data)."','".($single_date)."','".($start_date)."','".($end_date)."','".addslashes($days_of_week_data)."','".addslashes($month_data)."',"
                    . "'".$user_date_show."','".$time_show."','".$duration_show."','".$location_show."','".$like_dislike_show."','".$set_goals_show."','".$scale_show."','".$reminder_show."','".$comments_show."','".addslashes($user_date_show_heading)."','".addslashes($time_heading)."',"
                    . "'".addslashes($duration_heading)."','".addslashes($location_heading)."','".addslashes($like_dislike_heading)."','".addslashes($set_goals_heading)."','".addslashes($scale_heading)."','".addslashes($reminder_heading)."','".addslashes($comments_heading)."','".addslashes($location_category)."','".addslashes($user_response_category)."',"
                    . "'".addslashes($user_what_next_category)."','".addslashes($alerts_updates_category)."','".$order_show."','".$admin_id."','".$fav_cat_type_id."','".addslashes($fav_cat_id_data)."','".$comment_order_show."','".$reminder_order_show."','".$scale_order_show."','".$set_goals_order_show."','".$like_dislike_order_show."','".$location_order_show."','".$duration_order_show."','".$time_order_show."','".$user_date_order_show."','".$image2_order_show."','".$image1_order_show."')";
           
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {
                $return = true;
            }
            } catch (Exception $e) {
                $stringData = '[updateRecordCommon] Catch Error:'.$e->getMessage();
                $this->debuglog($stringData);
           
        }
      return $return;
        
}

public function UpdateDesignMyLife($text_box_show,$text_box_count,$user_upload_show,$quick_response_show,$quick_tip_icon,$quick_response_heading,$response_heading,$box_count,$video_1,$video_2,$show_to_user,$page_cat_id,$fav_cat_type_id_header,$fav_cat_type_id_2,$canv_sub_cat2_show_fetch,$canv_sub_cat2_link,$fav_cat_id_data_2,$fav_cat_type_id_3,$canv_sub_cat3_show_fetch,$canv_sub_cat3_link,$fav_cat_id_data_3,$fav_cat_type_id_4,$canv_sub_cat4_show_fetch,$canv_sub_cat4_link,$fav_cat_id_data_4,$narration_show,$comment_order_show,$reminder_order_show,$scale_order_show,$set_goals_order_show,$like_dislike_order_show,$location_order_show,$duration_order_show,$time_order_show,$user_date_order_show,$image2_order_show,$image1_order_show,$image_1_show,$image_2_show,$ref_code,$admin_comment,$title_id,$narration,$listing_date_type,$single_date,$start_date,$end_date,$banner_type_1,$banner_1,$credit_line_1,$credit_line_url_1,$sound_clip_id_1,$banner_type_2,$banner_2,$credit_line_2,$credit_line_url_2,$sound_clip_id_2,$user_date_show,$user_date_show_heading,$time_show,$time_heading,$duration_show,$duration_heading,$location_show,$location_heading,$location_category,$like_dislike_show,$like_dislike_heading,$user_response_category,$set_goals_show,$set_goals_heading,$user_what_next_category,$scale_show,$scale_heading,$reminder_show,$reminder_heading,$alerts_updates_category,$comments_show,$comments_heading,$order_show,$fav_cat_type_id,$days_of_month_data,$days_of_week_data,$month_data,$fav_cat_id_data,$admin_id,$updated_date,$design_id)
{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = false;
             try {
             $sql = "UPDATE `tbl_design_your_life` SET `show_to_user`='".addslashes($show_to_user)."',`ref_code`='".addslashes($ref_code)."',`box_title`='".addslashes($title_id)."',"
                     . "`narration`='".addslashes($narration)."',`image_type_1`='".$banner_type_1."',`image_1`='".addslashes($banner_1)."',`image_1_show`='".$image_1_show."',"
                     . "`image_2`='".addslashes($banner_2)."',`image_type_2`='".$banner_type_2."',`image_2_show`='".$image_2_show."',`sound_clip_1`='".$sound_clip_id_1."',"
                     . "`sound_clip_2`='".$sound_clip_id_2."',`image_credit_1`='".addslashes($credit_line_1)."',`image_credit_url_1`='".addslashes($credit_line_url_1)."',`image_credit_2`='".addslashes($credit_line_2)."',"
                     . "`image_credit_url_2`='".$credit_line_url_2."',`admin_comment`='".$admin_comment."',`listing_date_type`='".$listing_date_type."',`days_of_month`='".addslashes($days_of_month_data)."',"
                     . "`single_date`='".$single_date."',`start_date`='".$start_date."',`end_date`='".$end_date."',`days_of_week`='".addslashes($days_of_week_data)."',`months`='".addslashes($month_data)."',"
                     . "`user_date_show`='".$user_date_show."',`time_show`='".$time_show."',`duration_show`='".$duration_show."',`location_show`='".$location_show."',`User_view`='".$like_dislike_show."',"
                     . "`User_Interaction`='".$set_goals_show."',`scale_show`='".$scale_show."',`alert_show`='".$reminder_show."',`comment_show`='".$comments_show."',`user_date_heading`='".addslashes($user_date_show_heading)."',"
                     . "`time_heading`='".addslashes($time_heading)."',`duration_heading`='".addslashes($duration_heading)."',`location_heading`='".addslashes($location_heading)."',`like_dislike_heading`='".addslashes($like_dislike_heading)."',`set_goals_heading`='".addslashes($set_goals_heading)."',"
                     . "`scale_heading`='".addslashes($scale_heading)."',`reminder_heading`='".addslashes($reminder_heading)."',`comments_heading`='".addslashes($comments_heading)."',`location_fav_cat`='".addslashes($location_category)."',`user_response_fav_cat`='".addslashes($user_response_category)."',"
                     . "`user_what_fav_cat`='".addslashes($user_what_next_category)."',`alerts_fav_cat`='".addslashes($alerts_updates_category)."',`order_show`='".$order_show."',"
                     . "`prof_cat_id`='".$fav_cat_type_id."',`sub_cat_id`='".addslashes($fav_cat_id_data)."',`comment_order_show`='".$comment_order_show."',`reminder_order_show`='".$reminder_order_show."',`scale_order_show`='".$scale_order_show."',"
                     . "`set_goals_order_show`='".$set_goals_order_show."',`like_dislike_order_show`='".$like_dislike_order_show."',`location_order_show`='".$location_order_show."',`duration_order_show`='".$duration_order_show."',"
                     . "`time_order_show`='".$time_order_show."',`user_date_order_show`='".$user_date_order_show."',`image2_order_show`='".$image2_order_show."',`image1_order_show`='".$image1_order_show."',"
                     . "`prof_cat2`='".$fav_cat_type_id_2."',`prof_cat3`='".$fav_cat_type_id_3."',`prof_cat4`='".$fav_cat_type_id_4."',`narration_show`='".$narration_show."',"
                     . "`sub_cat2`='".addslashes($fav_cat_id_data_2)."',`sub_cat3`='".addslashes($fav_cat_id_data_3)."',`sub_cat4`='".addslashes($fav_cat_id_data_4)."',"
                     . "`sub_cat2_show_fetch`='".addslashes($canv_sub_cat2_show_fetch)."',`sub_cat3_show_fetch`='".addslashes($canv_sub_cat3_show_fetch)."',`sub_cat4_show_fetch`='".addslashes($canv_sub_cat4_show_fetch)."',"
                     . "`data_category`='".$page_cat_id."',`fav_cat_type_id_header`='".addslashes($fav_cat_type_id_header)."',`sub_cat2_link`='".addslashes($canv_sub_cat2_link)."',`sub_cat3_link`='".addslashes($canv_sub_cat3_link)."',`sub_cat4_link`='".addslashes($canv_sub_cat4_link)."',"
                     . "`video_link_1`='".addslashes($video_1)."',`video_link_2`='".addslashes($video_2)."',"
                     . "`quick_response_show`='".addslashes($quick_response_show)."',`quick_tip_icon`='".addslashes($quick_tip_icon)."',"
                     . "`quick_response_heading`='".addslashes($quick_response_heading)."',`response_heading`='".addslashes($response_heading)."',`box_count`='".addslashes($box_count)."',"
                     . "`user_upload_show`='".addslashes($user_upload_show)."', `input_box_show`='".addslashes($text_box_show)."', `input_box_count`='".addslashes($text_box_count)."',"
                     . "`updated_by`='".$admin_id."' WHERE id = '".$design_id."' ";
           
           //die();
           
            $STH = $DBH->query($sql);
            if($STH->rowCount() > 0)
            {
                $return = true;
            }
            } catch (Exception $e) {
                $stringData = '[updateRecordCommon] Catch Error:'.$e->getMessage();
                $this->debuglog($stringData);
           
        }
      return $return;
        
}


public function getAllDesignMyLife($search,$status)
	{
            
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();

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

             $sql = "SELECT * FROM `tbl_design_your_life` WHERE is_deleted = '0' $sql_str_search $sql_str_status  ORDER BY id DESC";
           
           // $this->execute_query($sql);
            $STH = $DBH->prepare($sql);
            $STH->execute();
            $total_records = $STH->rowCount() ;
            $record_per_page = 100;
            $scroll = 5;
            $page = new Page(); 
            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
            $page->set_link_parameter("Class = paging");
            $page->set_qry_string($str="mode=manage-design-your-life");
           // $result=$this->execute_query($page->get_limit_query($sql));
            $STH2 = $DBH->prepare($page->get_limit_query($sql));
            $STH2->execute();
            $output = '';		
            if($STH2->rowCount()  > 0)
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
                    
                    $obj2 = new Contents();
                    if($row['status'] == '1')
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
                        $added_by_admin = $obj2->getUsenameOfAdmin($row['added_by']);
                    }

                    $updated_on_date = date('d-m-Y',strtotime($row['add_date']));

                    $location_fav_cat = explode(',', $row['location_fav_cat']);
                    $location_fav_cat = implode('\',\'', $location_fav_cat);
                    
                    $user_response_fav_cat = explode(',', $row['user_response_fav_cat']);
                    $user_response_fav_cat = implode('\',\'', $user_response_fav_cat);
                    
                    $user_what_fav_cat = explode(',', $row['user_what_fav_cat']);
                    $user_what_fav_cat = implode('\',\'', $user_what_fav_cat);
                    
                    $alerts_fav_cat = explode(',', $row['alerts_fav_cat']);
                    $alerts_fav_cat = implode('\',\'', $alerts_fav_cat);
                    
                    
                    $sub_cat2 = explode(',', $row['sub_cat2']);
                    $sub_cat2 = implode('\',\'', $sub_cat2);
                    
                    $sub_cat3 = explode(',', $row['sub_cat3']);
                    $sub_cat3 = implode('\',\'', $sub_cat3);
                    
                    $sub_cat4 = explode(',', $row['sub_cat4']);
                    $sub_cat4 = implode('\',\'', $sub_cat4);
                    
                    $sub_cat_id = explode(',', $row['sub_cat_id']);
                    $sub_cat_id = implode('\',\'', $sub_cat_id);
                    
                    
                    $image_1_show = ($row['image_1_show'] == 0 ? 'Hide' : 'Show');
                    $image_2_show = ($row['image_2_show'] == 0 ? 'Hide' : 'Show');
                    $user_date_show = ($row['user_date_show'] == 0 ? 'Hide' : 'Show');
                    $time_show = ($row['time_show'] == 0 ? 'Hide' : 'Show');
                    $duration_show = ($row['duration_show'] == 0 ? 'Hide' : 'Show');
                    $location_show = ($row['location_show'] == 0 ? 'Hide' : 'Show');
                    $like_dislike_show = ($row['User_view'] == 0 ? 'Hide' : 'Show');
                    $set_goals_show = ($row['User_Interaction'] == 0 ? 'Hide' : 'Show');
                    $scale_show = ($row['scale_show'] == 0 ? 'Hide' : 'Show');
                    $reminder_show = ($row['alert_show'] == 0 ? 'Hide' : 'Show');
                    $comments_show = ($row['comment_show'] == 0 ? 'Hide' : 'Show');
                    $natation_show = ($row['natation_show'] == 0 ? 'Hide' : 'Show');
                    $quick_response_show = ($row['quick_response_show'] == 0 ? 'Hide' : 'Show');
                    
                    if($row['sub_cat2_show_fetch']!=0)
                    {
                        $sub_cat2_show_fetch = ($row['sub_cat2_show_fetch'] == 1 ? 'Show' : 'Fetch');
                    }
                    else
                    {
                      $sub_cat2_show_fetch='Hide';  
                    }
                    
                    if($row['sub_cat3_show_fetch']!=0)
                    {
                        $sub_cat3_show_fetch = ($row['sub_cat3_show_fetch'] == 1 ? 'Show' : 'Fetch');
                    }
                    else
                    {
                      $sub_cat3_show_fetch='Hide';  
                    }
                    
                    if($row['sub_cat4_show_fetch']!=0)
                    {
                        $sub_cat4_show_fetch = ($row['sub_cat4_show_fetch'] == 1 ? 'Show' : 'Fetch');
                    }
                    else
                    {
                      $sub_cat4_show_fetch='Hide';  
                    }
                    
                    
                    $user_show = ($row['show_to_user'] == 1 ? 'Yes' : 'No');
                    $user_uploads = ($row['user_upload_show'] == 1 ? 'yes' : 'No');
                    
                    						
                    $output .= '<tr class="manage-row" >';
                    $output .= '<td height="30" align="center">'.$i.'</td>';
                    $output .= '<td height="30" align="center">'.$status.'</td>';
                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';
                    $output .= '<td height="30" align="center">'.$row['order_show'].'</td>';
                    $output .= '<td height="30" align="center">'.date("d-m-Y H:i:s",strtotime($row['add_date'])).'</td>';
                    $output .= '<td align="center" nowrap="nowrap">';
                    
                    if($edit) {
                    $output .= '<a href="index.php?mode=edit-design-your-life&id='.$row['id'].'" ><img src = "images/edit.gif" border="0"></a>';
                    }
                    $output .= '</td>';
                    $output .= '<td align="center" nowrap="nowrap">';
                    if($delete) {
                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/deldesignyourlife.php?id='.$row['page_cat_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
                    }
                    
                    $output .= '<td height="30" align="center">'.stripslashes($row['admin_comment']).'</td>';
                    $output .= '<td height="30" align="center">'.$user_show.'</td>';
                    $output .= '<td height="30" align="center">'.$user_uploads.'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['ref_code']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($row['box_title']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($obj2->getDataREFCOde($row['data_category'])).'</td>';
                   
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat_id']).'</td>';
                    $output .= '<td height="30" align="center">'.$row['fav_cat_type_id_header'].'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($sub_cat_id).'</td>';
                     $output .= '<td height="30" align="center">'.stripslashes($row['narration']).'</td>';
                    $output .= '<td height="30" align="center">'.$natation_show.'</td>';
                    if($row['image_type_1'] == 'Image')
                    {
                        $output .= '<td height="30" align="center"><img src="../uploads/'.$row['image_1'].'" style="width:50px;height:50px;"></td>';   
                    }
                    else {
                        $output .= '<td height="30" align="center"></td>';   
                    }
                    $output .= '<td height="30" align="center">'.$image_1_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['image_credit_1'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['image_credit_url_1'].'</td>';
                    $output .= '<td height="30" align="center">'.$this->GetMusic_namebyID($row['sound_clip_1']).'</td>';
                    
                    if($row['image_type_2'] == 'Image')
                    {
                        $output .= '<td height="30" align="center"><img src="../uploads/'.$row['image_2'].'" style="width:50px;height:50px;"></td>';   
                    }
                     else {
                        $output .= '<td height="30" align="center"></td>';   
                    }
                    $output .= '<td height="30" align="center">'.$image_1_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['image_credit_2'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['image_credit_url_2'].'</td>';
                    $output .= '<td height="30" align="center">'.$this->GetMusic_namebyID($row['sound_clip_2']).'</td>';
                         
                    $output .= '<td height="30" align="center">'.$row['listing_date_type'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['days_of_month'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['single_date'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['start_date'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['end_date'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['days_of_week'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['months'].'</td>';
                    
                    $output .= '<td height="30" align="center">'.$user_date_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['user_date_heading'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['user_date_order_show'].'</td>';
                    
                    $output .= '<td height="30" align="center">'.$time_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['time_heading'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['time_order_show'].'</td>';
                    
                    $output .= '<td height="30" align="center">'.$duration_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['duration_heading'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['duration_order_show'].'</td>';
                     
                    $output .= '<td height="30" align="center">'.$location_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['location_heading'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['location_order_show'].'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($location_fav_cat).'</td>';
                    
                    
                    $output .= '<td height="30" align="center">'.$like_dislike_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['like_dislike_heading'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['like_dislike_order_show'].'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($user_response_fav_cat).'</td>';
                    
                    $output .= '<td height="30" align="center">'.$set_goals_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['set_goals_heading'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['set_goals_order_show'].'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($user_what_fav_cat).'</td>';
                    
                    $output .= '<td height="30" align="center">'.$scale_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['scale_heading'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['scale_order_show'].'</td>';
                    
                    $output .= '<td height="30" align="center">'.$reminder_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['reminder_heading'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['reminder_order_show'].'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($alerts_fav_cat).'</td>';
                    $output .= '<td height="30" align="center">'.$comments_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['comments_heading'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['comment_order_show'].'</td>';
                    
                    
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat2']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($sub_cat2).'</td>';
                    $output .= '<td height="30" align="center">'.$sub_cat2_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.$row['sub_cat2_link'].'</td>';
                    
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat3']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($sub_cat3).'</td>';
                    $output .= '<td height="30" align="center">'.$sub_cat3_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.$row['sub_cat3_link'].'</td>';
                    
                    $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat4']).'</td>';
                    $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($sub_cat4).'</td>';
                    $output .= '<td height="30" align="center">'.$sub_cat4_show_fetch.'</td>';
                    $output .= '<td height="30" align="center">'.$row['sub_cat4_link'].'</td>';
                    $output .= '<td height="30" align="center">'.$quick_response_show.'</td>';
                    $output .= '<td height="30" align="center">'.$row['quick_tip_icon'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['quick_response_heading'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['response_heading'].'</td>';
                    $output .= '<td height="30" align="center">'.$row['box_count'].'</td>';
                    
                    
                    //getIdByProfileFavCategoryName
                    
                    
                    
                    
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

public function GetTitlenamebyID($box_title)
{
    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
    $name = '';
    $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE bms_id ='".$box_title."' ORDER BY `bms_name` ASC";
    $STH = $DBH->query($sql);
    if( $STH->rowCount() > 0 )
    {
        $row = $STH->fetch(PDO::FETCH_ASSOC);
        $name = $row['bms_name'];
    }
    return $name;   
    
    
} 

public function GetMusic_namebyID($sound_clip_id)
{
    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
    $name = '';
    $sql = "SELECT * FROM `tblsoundclip` where `status` = 1 and  `sound_clip_id` ='".$sound_clip_id."'  ";
    $STH = $DBH->query($sql);
    if( $STH->rowCount() > 0 )
    {
        $row = $STH->fetch(PDO::FETCH_ASSOC);
        $name = $row['sound_clip'];
    }
    return $name;   
    
    
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

public function Getmycanvasdata($symtum_cat)
{
        $symtum_cat = implode(',', $symtum_cat);
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
	$option_str = array();
	$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE bms_id IN($symtum_cat) ORDER BY `bms_name` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {
                
                $option_str[]=$row['bms_name'];
            }
	}
	return $option_str;  
}

public function Getmycanvassolutionitems($cat_id)
{
      
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
        $option_str = array();
	$sql = "SELECT * FROM `tblsolutionitems` WHERE  sol_item_cat_id IN($cat_id) ORDER BY `sol_box_title` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {	
               
                $option_str[]= strip_tags($row['sol_box_title']);

            }
	}
	return $option_str; 
        
}


public function getAllMainSymptomsMyCanvas($symtum_cat)
    {       
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
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
    
    public function getAllDailyMealsMyCanvas($symtum_cat)
    {       
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
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
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
        
	$option_str = array();
	$sql = "SELECT * FROM `tbldailymeals` WHERE meal_id IN($symtum_cat) ORDER BY `meal_item` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {			
                
                $option_str[]=strip_tags($row['meal_item']); 
            }
	}
	return $option_str;  
        
}

public function GetmycanvasDailyActivitydata($symtum_cat)
{             
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
        
	$option_str = array();
        $sql = "SELECT * FROM `tbldailyactivity` WHERE (activity_category IN($symtum_cat) OR activity_level_code IN($symtum_cat)) ORDER BY `activity` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {
                $option_str[] = strip_tags($row['activity']);
            }
	}
	return $option_str;  
        
}

public function CreateDesignLifeDropdown($show_cat,$final_array)
{
    
    $option_str = '';
    $data = array();
    if(!empty($show_cat))
    {
        for($i=0;$i<count($show_cat);$i++)
        {
          //$option_str .='<option value="'.$this->getFavCategoryNameVivek($show_cat[$i]).'">'.$this->getFavCategoryNameVivek($show_cat[$i]).'</option>';  
        
            $data[] = $this->getFavCategoryNameVivek($show_cat[$i]);
        }
    }
    
   $final_array_new =  array_merge($data,$final_array);
   
   
   
   //$final_array_new = asort($final_array_new);
    
//   echo '<pre>';
//   print_r($final_array_new);
//   echo '</pre>';
//   die();
   
    if(!empty($final_array_new))
    {
         $option_str .='<option value="">Select Option</option>'; 
        for($j=0;$j<count($final_array_new);$j++)
        {
          $option_str .='<option value="'.$final_array_new[$j].'">'.$final_array_new[$j].'</option>';  
        }
    }
    
   
    return $option_str;
    
}
        

public function Getbsmname($bms_id)
{
        $symtum_cat = implode(',', $symtum_cat);
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
	$option_str ='';
	$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE bms_id ='".$bms_id."' ORDER BY `bms_name` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $option_str = $row['bms_name'];
	}
	return $option_str;  
}

public function GetDesignYourLifeData($design_id)
{
 
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
	$data =array();
	$sql = "SELECT * FROM `tbl_design_your_life` WHERE id ='".$design_id."' ";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
	}
	return $data;     
}

public function CreateDesignLifeDropdownEdit($show_cat,$final_array,$box_title)
{
    
    $option_str = '';
    $data = array();
    if(!empty($show_cat))
    {
        for($i=0;$i<count($show_cat);$i++)
        {
          
            $data[] = $this->getFavCategoryNameVivek($show_cat[$i]);
        }
    }
    
   $final_array_new =  array_merge($data,$final_array);
   
   $sel = '';
   
    if(!empty($final_array_new))
    {
        for($j=0;$j<count($final_array_new);$j++)
        {
         if($box_title == $final_array_new[$j])
            {
                $sel = ' selected ';
            }  
            else
            {
                $sel='';
            }
            $option_str .='<option value="'.$final_array_new[$j].'" '.$sel.'>'.$final_array_new[$j].'</option>';  
        }
    }
    
   
    return $option_str;
    
}

public function getAllSubCategoryChkeckbox($parent_cat_id,$arr_selected_cat_id,$cat_id='',$adviser_panel = '',$width = '400',$height = '350')
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
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id1" id="all_selected_cat_id1" value="1" onclick="toggleCheckBoxes(\'selected_cat_id1\'); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                {

                    $prct_cat_id = $row['favcat_id'];
                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id1[]" id="selected_cat_id1_'.$i.'" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }

        
public function GetAllUserDashboard($search)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '343';
		
		if($search == '')
                    {
                        $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '15' ";
                    }
		else
                    {
                         $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '15' ";
                    }
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount() ;
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode = user-dashboard");
	 	//$result=$this->execute_query($page->get_limit_query($sql));
		$STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();
		$output = '';		
		if($STH2->rowCount()  > 0)
		{
			$i = 1;
                        $row = $STH2->fetch(PDO::FETCH_ASSOC);
                        $page_name = $row['page_id_str'];
                        $page_name = explode(',', $page_name);
                        
//                        echo '<pre>';
//                        print_r($page_name);
//                        echo '</pre>';
                        $obj2 = new Contents();
                        
			for($i=0;$i<count($page_name);$i++)
			{
                                $data = $this->getpagedata($page_name[$i]);
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.($i+1).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($this->getPagenamebyid($page_name[$i])).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($obj2->getUsenameOfAdmin($data['posted_by'])).'</td>';
                                $output .= '<td height="30" align="center">'.date("d-m-Y H:i:s",strtotime($data['page_add_date'])).'</td>';
                                $output .= '<td height="30" align="center">'.stripslashes($obj2->getUsenameOfAdmin($data['updated_by'])).'</td>';
                                $output .= '<td height="30" align="center">'.date("d-m-Y H:i:s",strtotime($data['updated_date'])).'</td>';
                                
                                $output .= '<td height="30" align="center" nowrap="nowrap">';
				if($edit_action_id) {
				$output .= '<a href="index.php?mode=edit_user_dashboard&page_id='.$page_name[$i].'" ><img src = "images/edit.gif" border="0"></a>';
				}
				$output .= '</td>';
                                $output .= '<td height="30" align="center"><img src="../../uploads/'.$data['page_icon'].'" style="width:50px;height:50px;"></td>';
                                $output .= '<td height="30" align="center">'.$data['dashboard_header'].'</td>';
                                $output .= '<td height="30" align="center">'.$data['dashboard_contents'].'</td>';
                                $output .= '<td height="30" align="center">'.$data['position'].'</td>';
                                $output .= '<td height="30" align="center">'.($data['show_in_dashboard'] == 1 ? 'Yes' : 'No').'</td>';
                                $output .= '<td height="30" align="center">'.$data['show_order'].'</td>';
                                
				
				$output .= '</tr>';
				
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="4" align="center">NO PAGES FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}        
  
    public function getContentUserDashboard($page_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$page_name = '';
		$page_title = '';
		$page_contents = '';
		$meta_title = '';
		$meta_keywords = '';
		$meta_description = '';
		$menu_title = '';
                $menu_link = '';
		$menu_link_enable = 0;
                $page_contents2 = '';
                $show_in_dashboard=0;
                $position ='';
                $show_order='';
                $dashboard_header='';
                $page_icon = '';
                $dashboard_contents ='';
		
		$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$page_name = stripslashes($row['page_name']);
			$page_title = stripslashes($row['page_title']);
			$page_contents = stripslashes($row['page_contents']);
                        $page_contents2 = stripslashes($row['page_contents2']);
			$meta_title = stripslashes($row['meta_title']);
			$meta_keywords = stripslashes($row['meta_keywords']);
			$meta_description = stripslashes($row['meta_description']);
			$menu_title = stripslashes($row['menu_title']);
                        $menu_link = stripslashes($row['menu_link']);
			$menu_link_enable = stripslashes($row['link_enable']);
                        $show_in_dashboard= stripslashes($row['show_in_dashboard']);
                        $position = stripslashes($row['position']);
                        $show_order= stripslashes($row['show_order']);
                        $dashboard_header= stripslashes($row['dashboard_header']);
                        $page_icon = stripslashes($row['page_icon']);
                        $dashboard_contents = stripslashes($row['dashboard_contents']);
		}
		return array($dashboard_contents,$page_icon,$dashboard_header,$show_order,$position,$show_in_dashboard,$menu_link,$page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$page_contents2);
	
	}    

    public function UpdateContentUserDashboard($dashboard_contents,$page_id,$dashboard_header,$position,$show_order,$show_in_dashboard,$admin_id)
    {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $update_date = date("Y-m-d H:i:s");
            $return=false;
            $upd_sql = "UPDATE `tblpages` SET `dashboard_contents` = '".addslashes($dashboard_contents)."', `dashboard_header` = '".addslashes($dashboard_header)."', `show_order` = '".addslashes($show_order)."' , `position` = '".addslashes($position)."' , `show_in_dashboard` = '".$show_in_dashboard."', `updated_by`='".$admin_id."',`updated_date`='".$update_date."' WHERE `page_id` = '".$page_id."'";
            $STH = $DBH->prepare($upd_sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $return = true;
            }
            return $return;
    }

    public function getpagedata($page_id) {
     
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $upd_sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
            $STH = $DBH->prepare($upd_sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
               
            }
            return $row; 
        
    } 
    
    public function getDesignYourLifeOption($page_id) {
     
       
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $option_str = '';		
 
            $sql = "SELECT * FROM `tbl_data_dropdown` WHERE `page_name` = '127' AND `is_deleted` = '0' and `pag_cat_status` = '1' ";
            
            $STH = $DBH->prepare($sql);
            $STH->execute();
				
            if($STH->rowCount()  > 0)
            {
                
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    if($row['page_cat_id'] == $page_id)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['page_cat_id'].'" '.$sel.'>'.stripslashes($row['ref_code']).'</option>';
                }
            }
            return $option_str;
        
        
    }    

public function getAllSubCategoryChkeckboxDesign($parent_cat_id,$arr_selected_cat_id,$type='',$width = '400',$height = '350')
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
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id1" id="all_selected_cat_id1" value="1" onclick="toggleCheckBoxes(\'selected_cat_id1\'); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                {

                    $prct_cat_id = $row['favcat_id'];
                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="'.$type.'[]" id="'.$type.'_'.$i.'" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }    
    
public function debuglog($stringData)
    {
        $logFile = "debuglog_admin_".date("Y-m-d").".txt";
        $fh = fopen($logFile, 'a');
        fwrite($fh, "\n\n----------------------------------------------------\nDEBUG_START - time: ".date("Y-m-d H:i:s")."\n".$stringData."\nDEBUG_END - time: ".date("Y-m-d H:i:s")."\n----------------------------------------------------\n\n");
        fclose($fh);	
    }
   
  
public function getUserTypeSelectedEmailList($ult_id,$country_id,$arr_state_id,$arr_city_id,$arr_place_id,$arr_selected_user_id,$arr_selected_adviser_id,$arr_ap_id,$arr_up_id)
{
	$my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$output = '';
		
	if($ult_id == '1')
	{
		$sql = "SELECT * FROM `tblusers` WHERE `status` = '1' ORDER BY `name` ASC";
	}
	elseif($ult_id == '2')
	{
		$sql = "SELECT * FROM `tblprofusers` WHERE `status` = '1' ORDER BY `name` ASC";
	}
	elseif($ult_id == '3')
	{
		if(count($arr_up_id) > 0 && $arr_up_id[0] != '')
		{
			$str_up_id = implode(',',$arr_up_id);
			
			$sql = "SELECT tu.* FROM `tbluserplanrequests` AS tupr LEFT JOIN `tblusers` AS tu ON tupr.user_id = tu.user_id LEFT JOIN `tbluserplans` AS tup ON tupr.up_id = tup.up_id WHERE tup.up_id IN (".$str_up_id.") ORDER BY tu.name ASC";
		}
		else
		{
			$sql = "SELECT * FROM `tblusers` WHERE `status` = '1' ORDER BY `name` ASC";
		}
	}
	elseif($ult_id == '4')
	{
		if(count($arr_ap_id) > 0 && $arr_ap_id[0] != '')
		{
			$str_ap_id = implode(',',$arr_ap_id);
			
			$sql = "SELECT tpu.* FROM `tbladviserplanrequests` AS tapr LEFT JOIN `tblprofusers` AS tpu ON tapr.pro_user_id = tpu.pro_user_id LEFT JOIN `tbladviserplans` AS tap ON tapr.ap_id = tap.ap_id WHERE tap.ap_id IN (".$str_ap_id.") ORDER BY tpu.name ASC";
		}
		else
		{
			$sql = "SELECT * FROM `tblprofusers` WHERE `status` = '1' ORDER BY `name` ASC";
		}
	}
	elseif($ult_id == '5')
	{
		if($country_id == '')
		{
			$sql_str_country_id = '';
		}
		else
		{
			$sql_str_country_id = " AND `country_id` = '".$country_id."' ";
		}
		
		if(count($arr_state_id) > 0 && $arr_state_id[0] != '')
		{
			$str_state_id = implode(',',$arr_state_id);
			$sql_str_state_id = " AND `state_id` IN (".$str_state_id.") ";
		}
		else
		{
			$sql_str_state_id = '';	
		}
		
		if(count($arr_city_id) > 0  && $arr_city_id[0] != '')
		{
			if(count($arr_city_id) == 1)
			{
				$str_city_id = $arr_city_id[0];
			}
			else
			{
				$str_city_id = implode(',',$arr_city_id);
			}
			
			$sql_str_city_id = " AND `city_id` IN (".$str_city_id.") ";
		}
		else
		{
			$sql_str_city_id = '';	
		}
		
		if(count($arr_place_id) > 0 && $arr_place_id[0] != '')
		{
			$str_place_id = implode(',',$arr_place_id);
			$sql_str_place_id = " AND `place_id` IN (".$str_place_id.") ";
		}
		else
		{
			$sql_str_place_id = '';	
		}
		
		$sql = "SELECT * FROM `tblusers` WHERE `status` = '1' ".$sql_str_country_id." ".$sql_str_state_id." ".$sql_str_city_id." ".$sql_str_place_id." ORDER BY `name` ASC";
	}
	elseif($ult_id == '6')
	{
		if($country_id == '')
		{
			$sql_str_country_id = '';
		}
		else
		{
			$sql_str_country_id = " AND `country_id` = '".$country_id."' ";
		}
		
		if(count($arr_state_id) > 0 && $arr_state_id[0] != '')
		{
			$str_state_id = implode(',',$arr_state_id);
			$sql_str_state_id = " AND `state_id` IN (".$str_state_id.") ";
		}
		else
		{
			$sql_str_state_id = '';	
		}
		
		if(count($arr_city_id) > 0 && $arr_city_id[0] != '')
		{
			$str_city_id = implode(',',$arr_city_id);
			$sql_str_city_id = " AND `city_id` IN (".$str_city_id.") ";
		}
		else
		{
			$sql_str_city_id = '';	
		}
		
		if(count($arr_place_id) > 0 && $arr_place_id[0] != '')
		{
			$str_place_id = implode(',',$arr_place_id);
			$sql_str_place_id = " AND `place_id` IN (".$str_place_id.") ";
		}
		else
		{
			$sql_str_place_id = '';	
		}
	
		$sql = "SELECT * FROM `tblprofusers` WHERE `status` = '1' ".$sql_str_country_id." ".$sql_str_state_id." ".$sql_str_city_id." ".$sql_str_place_id." ORDER BY `name` ASC";
	}
	else
	{
		$sql = "";
	}
	
	//$output .= $sql;
	if($sql != "")
	{
		$STH = $DBH->prepare($sql);
                $STH->execute();
                if($STH->rowCount() > 0)
                {
			$output .= '<div style="width:400px;float:left;margin-bottom:20px;">
							<input type="checkbox" name="all_selected_user_id" id="all_selected_user_id" value="1" onclick="toggleCheckBoxes(\'selected_user_id\'); getSelectedUserListIds();" />&nbsp;<strong>Select All</strong> 
						</div>';
			$output .= '<div style="width:400px;height:350px;float:left;overflow:scroll;">';
			$output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
			$i = 1;
			while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 
			{
				if($ult_id == '2' || $ult_id == '4' || $ult_id == '6')
				{
					$record_user_id = $row['pro_user_id'];
					$record_name = stripslashes($row['name']);
					$record_email = stripslashes($row['email']);
					
					if(in_array($record_user_id,$arr_selected_adviser_id) )
					{
						$selected = ' checked ';
					}
					else
					{
						$selected = '';
					}
				}	
				else
				{
					$record_user_id = $row['user_id'];
					$record_name = stripslashes($row['name']);
					$record_email = stripslashes($row['email']);	
					
					if(in_array($record_user_id,$arr_selected_user_id))
					{
						$selected = ' checked ';
					}
					else
					{
						$selected = '';
					}
				}
				
				$output .= '<li style="padding:0px;width:380px;float:left;"><input type="checkbox" '.$selected.' name="selected_user_id" id="selected_user_id_'.$i.'" value="'.$record_user_id.'" onclick="getSelectedUserListIds();" />&nbsp;<strong>'.$record_name.'&nbsp;&nbsp;('.$record_email.')</strong></li>';
				$i++;
			}
			$output .= '</div>';
		}
	}
	return $output;
}
 


public function AddUserPlanAttributes($page_id)
{
   
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = false;
            $sql = "INSERT INTO `tbladviserplanatributes` (`apa_name`,`apa_status`,`show_for_adviser`,`show_for_user`,`page_id`) "
                . "VALUES ('".addslashes($this->getPagenamebyid($page_id))."','1','1','1','".$page_id."')";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            

            if($STH->rowCount()  > 0)
            {
                $return = true;
            }
            return $return;   
    
    
}

public function alreadyinlist($page_id)
{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = false;
            $upd_sql = "SELECT * FROM `tbladviserplanatributes` WHERE `page_id` = '".$page_id."'";
            $STH = $DBH->prepare($upd_sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $return = true;
               
            }
            return $return;    
}

public function UpdateUserPlanAttributes($page_id)
{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=true;
            $upd_sql = "UPDATE `tbladviserplanatributes` SET `apa_name` = '".addslashes($this->getPagenamebyid($page_id))."' WHERE `page_id` = '".$page_id."'";
            $STH = $DBH->prepare($upd_sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $return = true;
            }
            return $return;  
}

public function DeactivateUser($user_id)
{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=true;
            $upd_sql = "UPDATE `tblusers` SET `status` = '0' WHERE `user_id` = '".$user_id."'";
            $STH = $DBH->prepare($upd_sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $return = true;
            }
            return $return;     
}

public function activateUser($user_id)
{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=true;
            $upd_sql = "UPDATE `tblusers` SET `status` = '1' WHERE `user_id` = '".$user_id."'";
            $STH = $DBH->prepare($upd_sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {
                $return = true;
            }
            return $return;     
}
    
 //ramakant end 01-10-2018       
        
}
?>