<?php
include_once("class.paging.php");
include_once("class.admin.php");
require_once('class.logs.php');
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
        $logsObject = new Logs();
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

                    $lastUpdatedData = [
                        'page' => 'page_dropdowns',
                        'reference_id' => $row['pd_id']
                    ];
                    $lastUpdatedData = $logsObject->getLastUpdatedLogs($lastUpdatedData);        
                   
						

                    $output .= '<tr class="manage-row">';

                    $output .= '<td height="30" align="center">'.$i.'</td>';
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
                    $output .= '<td height="30" align="center">'.$status.'</td>';

                    $output .= '<td height="30" align="center">'.stripslashes($row['pdm_name']).'</td>';

                    $output .= '<td height="30" align="center">'.stripslashes($row['admin_comment']).'</td>';

                    $output .= '<td height="30" align="center">'.$menu_name.'</td>';

                     $output .= '<td height="30" align="center">'.$page_name_str.'</td>';

                    

                    $output .= '<td height="30" align="center">'.$date_value.'</td>';

                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';

                   $output .= '<td align="center">'.stripslashes($lastUpdatedData['updateOn']).'
                    <a href="/admin/index.php?mode=logs-history&type=page_dropdowns&id='.$row['pd_id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';

                    $output .= '<td align="center">'.stripslashes($lastUpdatedData['updateBy']).'<a href="/admin/index.php?mode=logs-history&type=page_dropdowns&id='.$row['pd_id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';

                   

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

                    $logsObject = new Logs();
                    $lastUpdatedData = [
                        'page' => 'manage_page_fav_cat_dropdowns',
                        'reference_id' => $row['page_cat_id']
                    ];
                    $lastUpdatedData = $logsObject->getLastUpdatedLogs($lastUpdatedData);
						

                    $output .= '<tr class="manage-row">';

                    $output .= '<td height="30" align="center">'.$i.'</td>';

                    $output .= '<td height="30" align="center">'.$status.'</td>';

                    $output .= '<td height="30" align="center">'.$row['updated_on_date'].'</td>';

                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';

                    $output .= '<td align="center">'.stripslashes($lastUpdatedData['updateOn']).'
                    <a href="/admin/index.php?mode=logs-history&type=manage_page_fav_cat_dropdowns&id='.$row['page_cat_id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';

                    $output .= '<td align="center">'.stripslashes($lastUpdatedData['updateBy']).'<a href="/admin/index.php?mode=logs-history&type=manage_page_fav_cat_dropdowns&id='.$row['page_cat_id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';

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
        //update by ample 28-05-20
       public function getFavCategoryNameVivek($fav_cat_id)

	{

           // $this->connectDB();

                 $my_DBH = new mysqlConnection();

                 $DBH = $my_DBH->raw_handle();

                 $DBH->beginTransaction();

                $fav_cat_type = '';



            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ORDER BY `fav_cat` ASC";

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

                     $logsObject = new Logs();
                    $lastUpdatedData = [
                        'page' => 'manage_page_cat_dropdowns',
                        'reference_id' => $row['page_cat_id']
                    ];
                    $lastUpdatedData = $logsObject->getLastUpdatedLogs($lastUpdatedData);        

						

                    $output .= '<tr class="manage-row">';

                    $output .= '<td height="30" align="center">'.$i.'</td>';

                    $output .= '<td height="30" align="center">'.$status.'</td>';

                    $output .= '<td height="30" align="center">'.$row['updated_on_date'].'</td>';

                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';

                    $output .= '<td align="center">'.stripslashes($lastUpdatedData['updateOn']).'
                    <a href="/admin/index.php?mode=logs-history&type=manage_page_cat_dropdowns&id='.$row['page_cat_id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';

                    $output .= '<td align="center">'.stripslashes($lastUpdatedData['updateBy']).'<a href="/admin/index.php?mode=logs-history&type=manage_page_cat_dropdowns&id='.$row['page_cat_id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';

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


                    $arr_selected_cat_id2 = !empty($arr_selected_cat_id2) && is_array($arr_selected_cat_id2) ? $arr_selected_cat_id2 : [];
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

                    //Insert logs
                    $logsObject = new Logs();
                    $logsData = [
                        'page' => 'page_dropdowns',
                        'reference_id' => $pd_id
                    ];
                    $logsObject->insertLogs($logsData);

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

            $logsObject = new Logs();
            $logsData = [
                'page' => 'manage_page_cat_dropdowns',
                'reference_id' => $page_cat_id
            ];
            $logsObject->insertLogs($logsData);

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

          
            $logsObject = new Logs();
            $logsData = [
                'page' => 'manage_page_fav_cat_dropdowns',
                'reference_id' => $page_cat_id
            ];
            $logsObject->insertLogs($logsData);

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
                //Insert lOGS
                $lastInsertedId = $DBH->lastInsertId();
                $logsObject = new Logs();
                $logsData = [
                    'page' => 'page_dropdowns',
                    'reference_id' => $lastInsertedId
                ];
                $logsObject->insertLogs($logsData);

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

            $lastInsertedId = $DBH->lastInsertId();
            $logsObject = new Logs();
            $logsData = [
                'page' => 'manage_page_cat_dropdowns',
                'reference_id' => $lastInsertedId
            ];
            $logsObject->insertLogs($logsData);

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

                $lastInsertedId = $DBH->lastInsertId();
                $logsObject = new Logs();
                $logsData = [
                    'page' => 'manage_page_fav_cat_dropdowns',
                    'reference_id' => $lastInsertedId
                ];
                $logsObject->insertLogs($logsData);

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
            //Insert lOGS
           
            $logsObject = new Logs();
            $logsData = [
                'page' => 'page_dropdowns',
                'reference_id' => $pd_id
            ];
            $logsObject->insertLogs($logsData);

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

           
            $logsObject = new Logs();
            $logsData = [
                'page' => 'manage_page_cat_dropdowns',
                'reference_id' => $id
            ];
            $logsObject->insertLogs($logsData);

		}

		return $return;

	}





   public function getMessageName($messid)

   {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        

        $cs_name = '';

        $cs_value = '';

        

        $sql = "SELECT `mess_name` FROM `tblmessage` WHERE `mess_id` = '".$messid."' AND `mess_deleted` = '0'";

        $STH = $DBH->prepare($sql);

                $STH->execute();

        if($STH->rowCount()  > 0)

        {

            $row = $STH->fetch(PDO::FETCH_ASSOC);

            $mess_name = stripslashes($row['mess_name']);

        }

        return $mess_name;



   }



    

    

	public function GetAllCommonMessagesUser($search)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '360';

				

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		if($search == '')

		{

			$sql = "SELECT * FROM `tblcommonsettings` WHERE `cs_type` = 'MSG'  ORDER BY `cs_name` ASC ";

		}

		else

		{

			$sql = "SELECT * FROM `tblcommonsettings` WHERE `cs_type` = 'MSG'  AND cs_name LIKE '%".$search."%' ORDER BY `cs_name` ASC";

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

                                $cs_status = ($row['cs_status'] == 1 ? 'Active' : 'Inactive');

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

                $output .= '<td height="30" align="center">'.$cs_status.'</td>';

                $output .= '<td height="30" align="center" nowrap="nowrap">';

                        if($edit) {

                $output .= '<a href="index.php?mode=edit_common_message_user&id='.$row['cs_id'].'" ><img src = "images/edit.gif" border="0"></a>';

                            }

                $output .= '</td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['cs_id']).'</td>';



				$output .= '<td height="30" align="center">'.stripslashes($row['cs_name']).'</td>';

                $output .= '<td height="30" align="center">'.$this->getMessageName($row['cs_mess_name_id']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['cs_value']).'</td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['cs_admin_comm']).'</td>';



              

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

	
    //update ample 10-07-20
	public function UpdateCommonMessage($cs_id,$cs_value,$cs_name,$status,$mess_action_id,$admin_comment,$SMS_ID)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;

		$upd_sql = "UPDATE `tblcommonsettings` SET `cs_status` = '".$status."', `cs_name` = '".addslashes($cs_name)."', `cs_value` = '".addslashes($cs_value)."',`cs_mess_name_id` = '".$mess_action_id."',`cs_admin_comm` = '".$admin_comment."',`SMS_ID` = '".$SMS_ID."' WHERE `cs_id` = '".$cs_id."'";

		$STH = $DBH->prepare($upd_sql);

                $STH->execute();

                if($STH->rowCount() > 0)

                {

                         $return = true;

                 }

                return $return;

	}

	
    //update  ample 10-07-20
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

            $mess_action_id=stripslashes($row['cs_mess_name_id']);

            $cs_admin_comm=stripslashes($row['cs_admin_comm']);

            $SMS_ID=stripslashes($row['SMS_ID']); //add by ample 10-07-20

             $cs_status = stripslashes($row['cs_status']);

		}

		return array($cs_name,$cs_value,$cs_status,$mess_action_id,$cs_admin_comm,$SMS_ID);

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

            //copy by ample 22-04-20
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

                                // $output .= '<td height="30" align="center">'.$obj2->getUsenameOfAdmin($row['posted_by']).'</td>';

                                $output .= '<td height="30" align="center">'.date("d-m-Y H:i:s",strtotime($row['page_add_date'])).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['page_name']).'</td>';

                                $output .= '<td height="30" align="center">'.stripslashes($row['menu_link']).'</td>';

                                // $output .= '<td height="30" align="center"><img src="../../uploads/'.$row['page_icon'].'" style="width:100px; height:100px;"></td>';

                                $banner_name=$banner_file="";
                                        if(!empty($row['page_icon_type']))
                                        {
                                            if($row['page_icon_type']=='Image')
                                            {
                                                $banner_data=$this->get_data_from_tblicons('',$row['page_icon']);
                                                $banner_name=$banner_data[0]['icons_name'];
                                                $banner_file=$banner_data[0]['image'];
                                                $output .= '<td height="30" align="center"><img src="'.SITE_URL.'/uploads/'. $banner_file.'" style="width:50px; height:50px;"></td>';
                                            }
                                            else
                                            {
                                                $banner_data=$this->get_data_from_tblsolutionitems('',$row['page_icon']);
                                                $banner_name=$banner_data[0]['topic_subject'];
                                                $banner_file=$banner_data[0]['banner'];
                                                $output .= '<td height="30" align="center"><a href="'.SITE_URL.'/uploads/'. $banner_file.'" >'. $banner_file.'</a></td>';
                                                
                                            }
                                        }
                                        else
                                        {
                                            $output .= '<td height="30" align="center"></td>';
                                        }

                                

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="7" align="center">NO PAGES FOUND</td></tr>';

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

		// $obj2 = new Contents();

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

			//copy by ample 22-04-20
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

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['page_name']).'</td>';

                $output .= '<td height="30" align="center">'.stripslashes($row['menu_link']).'</td>';

                // $output .= '<td height="30" align="center">'.$this->getUsenameOfAdmin($row['posted_by']).'</td>';

                $output .= '<td height="30" align="center">'.date("d-m-Y H:i:s",strtotime($row['page_add_date'])).'</td>';

                $banner_name=$banner_file="";
                if(!empty($row['page_icon_type']))
                {
                    if($row['page_icon_type']=='Image')
                    {
                        $banner_data=$this->get_data_from_tblicons('',$row['page_icon']);
                        $banner_name=$banner_data[0]['icons_name'];
                        $banner_file=$banner_data[0]['image'];
                        $output .= '<td height="30" align="center"><img src="'.SITE_URL.'/uploads/'. $banner_file.'" style="width:50px; height:50px;"></td>';
                    }
                    else
                    {
                        $banner_data=$this->get_data_from_tblsolutionitems('',$row['page_icon']);
                        $banner_name=$banner_data[0]['topic_subject'];
                        $banner_file=$banner_data[0]['banner'];
                        $output .= '<td height="30" align="center"><a href="'.SITE_URL.'/uploads/'. $banner_file.'" >'. $banner_file.'</a></td>';
                        
                    }
                }
                else
                {
                    $output .= '<td height="30" align="center"></td>';
                }

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

			$output = '<tr class="manage-row" height="20"><td colspan="7" align="center">NO PAGES FOUND</td></tr>';

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

	
    // update by ample 09-12-19
	public function AddContent($page_icon,$menu_link,$page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$adviser_panel,$page_contents2,$vender_panel,$admin_id,$page_icon_type)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();
        $menu_link_enable = ($menu_link_enable == '') ? 0 : $menu_link_enable ;
                //update by ample 09-12-19 show_in_feedback
		$ins_sql = "INSERT INTO `tblpages`(`page_icon`,`page_name`,`page_title`,`page_contents`,`meta_title`,`meta_keywords`,`meta_description`,`show_in_list`,`show_in_manage_menu`,`link_enable`,`menu_title`,`adviser_panel`,`page_contents2`,`vender_panel`,`posted_by`,`page_icon_type`,`show_in_feedback`,`show_in_adviser_query`,`show_in_menu`,`parent_menu`,`menu_order`,`menu_link`,`position`,`show_order`,`dashboard_header`,`updated_by`,`dashboard_contents`) VALUES ('".addslashes($page_icon)."','".addslashes($page_name)."','".addslashes($page_title)."','".addslashes($page_contents)."','".addslashes($meta_title)."','".addslashes($meta_keywords)."','".addslashes($meta_description)."','1','1','".addslashes($menu_link_enable)."','".addslashes($menu_title)."','".addslashes($adviser_panel)."','".addslashes($page_contents2)."','".addslashes($vender_panel)."','".addslashes($admin_id)."','".addslashes($page_icon_type)."',0,0,0,0,0,0,0,0,'',0,'')";

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
                //add by ample 09-12-19
                 $page_icon_type = '';

		

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
                        //add by ample 09-12-19
                    $page_icon_type = stripslashes($row['page_icon_type']);

		}

		return array($page_icon,$menu_link,$page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$page_contents2,$page_icon_type);

	

	}

	

	
    //update by ample 09-12-19
	public function UpdateContent($page_icon,$menu_link,$page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$page_id,$page_contents2,$admin_id,$page_icon_type)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return=false;    
        $menu_link_enable = ($menu_link_enable == '') ? 0 : $menu_link_enable ;
        // update by ample 09-12-19
		$upd_sql = "UPDATE `tblpages` SET `page_icon` = '".addslashes($page_icon)."',`page_icon_type` = '".addslashes($page_icon_type)."', `show_in_manage_menu` = 1, `page_name` = '".addslashes($page_name)."' , `page_title` = '".addslashes($page_title)."' , `page_contents` = '".addslashes($page_contents)."' , `page_contents2` = '".addslashes($page_contents2)."' , `meta_title` = '".addslashes($meta_title)."' , `meta_keywords` = '".addslashes($meta_keywords)."' , `meta_description` = '".addslashes($meta_description)."' , `menu_title` = '".addslashes($menu_title)."' ,`menu_link` = '".addslashes($menu_link)."' , `link_enable` = '".addslashes($menu_link_enable)."',`updated_by`='".$admin_id."',`updated_date`='".date("Y-m-d H:i:s")."'   WHERE `page_id` = '".$page_id."'";

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

            
            $logsObject = new Logs();
            $logsData = [
                'page' => 'manage_page_fav_cat_dropdowns',
                'reference_id' => $id
            ];
            $logsObject->insertLogs($logsData);

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

                     $option_str .='<option value=" ">Select Page Name</option>';

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

                        $option_str .='<option value=" ">Select Menu Name</option>';

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

        
        //update by ample 19-05-20
        public function addDataDropdown($admin_comment,$arr_heading,$fav_cat_type_id_0,$healcareandwellbeing,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$admin_id,$time_show,$duration_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$heading,$order_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$cat_fetch_show_data,$canv_sub_cat_link,$data_source,$page_type,$location_ref_code, $ur_ref_code, $uw_ref_code,$au_ref_code,$prof_cat_heading,$prof_cat_ref_code,$level,$pop_show,$special_key)

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

            $special_key['special_key1'] = ($special_key['special_key1'] ==''? 0 : $special_key['special_key1']);

             $special_key['special_key2'] = ($special_key['special_key2'] ==''? 0 : $special_key['special_key2']);

            $special_key['special_key3'] = ($special_key['special_key3'] ==''? 0 : $special_key['special_key3']);


            
            //update SQL accroding to new prof cat heading & refer_code by ample 04-11-19 & update 16-12-19
            

            for($i=0;$i<count($healcareandwellbeing);$i++)

            {

            $sql = "INSERT INTO `tbl_data_dropdown` (`admin_comment`,`system_cat`,`healcareandwellbeing`,`page_name`,`ref_code`,`sub_cat1`,`sub_cat2`,`sub_cat3`,`sub_cat4`,`sub_cat5`,`sub_cat6`,`sub_cat7`,`sub_cat8`,`sub_cat9`,`sub_cat10`,`prof_cat1`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`prof_cat5`,`prof_cat6`,`prof_cat7`,`prof_cat8`,`prof_cat9`,`prof_cat10`,`pag_cat_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`,`time_show`,`duration_show`,`location_show`,`User_view`,`User_Interaction`,`scale_show`,`alert_show`,`heading`,`order_show`,`comment_show`,`location_fav_cat`,`user_response_fav_cat`,`user_what_fav_cat`,`alerts_fav_cat`,`canv_sub_cat1_show_fetch`, `canv_sub_cat2_show_fetch`, `canv_sub_cat3_show_fetch`, `canv_sub_cat4_show_fetch`, `canv_sub_cat5_show_fetch`, `canv_sub_cat6_show_fetch`, `canv_sub_cat7_show_fetch`, `canv_sub_cat8_show_fetch`, `canv_sub_cat9_show_fetch`, `canv_sub_cat10_show_fetch`, `canv_sub_cat1_link`, `canv_sub_cat2_link`, `canv_sub_cat3_link`, `canv_sub_cat4_link`, `canv_sub_cat5_link`, `canv_sub_cat6_link`, `canv_sub_cat7_link`, `canv_sub_cat8_link`, `canv_sub_cat9_link`, `canv_sub_cat10_link`,`data_source`,`page_type`,`time_heading`,`duration_heading`,`location_heading`,`like_dislike_heading`,`set_goals_heading`,`scale_heading`,`reminder_heading`,`comments_heading`, `location_ref_code`,`ur_ref_code`,`uw_ref_code`,`au_ref_code`,prof_cat1_heading,prof_cat2_heading,prof_cat3_heading,prof_cat4_heading,prof_cat5_heading,prof_cat6_heading,prof_cat7_heading,prof_cat8_heading,prof_cat9_heading,prof_cat10_heading,prof_cat1_ref_code,prof_cat2_ref_code,prof_cat3_ref_code,prof_cat4_ref_code,prof_cat5_ref_code,prof_cat6_ref_code,prof_cat7_ref_code,prof_cat8_ref_code,prof_cat9_ref_code,prof_cat10_ref_code,`level`, `level_title`, `level_icon`, `level_heading`, `level_title_heading`, `level_icon_heading`,`level_icon_type`,special_key1,special_key2,special_key3,special_ref_code1,special_ref_code2,special_ref_code3,pop_show,loc_cat_uid,ur_cat_uid,uwn_uid,au_cat_uid) "

                . "VALUES ('".addslashes($admin_comment)."','".addslashes($fav_cat_type_id_0)."','".addslashes($healcareandwellbeing[$i])."','".addslashes($page_name)."','".addslashes($ref_code)."','".addslashes($sub_cat1)."','".addslashes($sub_cat2)."','".addslashes($sub_cat3)."','".addslashes($sub_cat4)."','".addslashes($sub_cat5)."','".addslashes($sub_cat6)."','".addslashes($sub_cat7)."','".addslashes($sub_cat8)."','".addslashes($sub_cat9)."','".addslashes($sub_cat10)."','".addslashes($prof_cat1)."','".addslashes($prof_cat2)."','".addslashes($prof_cat3)."','".addslashes($prof_cat4)."','".addslashes($prof_cat5)."','".addslashes($prof_cat6)."','".addslashes($prof_cat7)."','".addslashes($prof_cat8)."','".addslashes($prof_cat9)."','".addslashes($prof_cat10)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."','".$time_show."','".$duration_show."','".$location_show."','".$like_dislike_show."','".$set_goals_show."','".$scale_show."','".$reminder_show."','".$heading."','".$order_show."','".$comments_show."','".addslashes($location_category)."','".addslashes($user_response_category)."','".addslashes($user_what_next_category)."','".addslashes($alerts_updates_category)."','".$canv_sub_cat1_show_fetch."', '".$canv_sub_cat2_show_fetch."', '".$canv_sub_cat3_show_fetch."','".$canv_sub_cat4_show_fetch."', '".$canv_sub_cat5_show_fetch."', '".$canv_sub_cat6_show_fetch."', '".$canv_sub_cat7_show_fetch."', '".$canv_sub_cat8_show_fetch."', '".$canv_sub_cat9_show_fetch."', '".$canv_sub_cat10_show_fetch."', '".$canv_sub_cat_link['canv_sub_cat1_link']."', '".$canv_sub_cat_link['canv_sub_cat2_link']."', '".$canv_sub_cat_link['canv_sub_cat3_link']."', '".$canv_sub_cat_link['canv_sub_cat4_link']."', '".$canv_sub_cat_link['canv_sub_cat5_link']."', '".$canv_sub_cat_link['canv_sub_cat6_link']."', '".$canv_sub_cat_link['canv_sub_cat7_link']."', '".$canv_sub_cat_link['canv_sub_cat8_link']."', '".$canv_sub_cat_link['canv_sub_cat9_link']."', '".$canv_sub_cat_link['canv_sub_cat10_link']."','".$data_source."','".$page_type."','".$arr_heading['time_heading']."','".$arr_heading['duration_heading']."','".$arr_heading['location_heading']."','".$arr_heading['like_dislike_heading']."','".$arr_heading['set_goals_heading']."','".$arr_heading['scale_heading']."','".$arr_heading['reminder_heading']."','".$arr_heading['comments_heading']."','".addslashes($location_ref_code)."','".addslashes($ur_ref_code)."','".addslashes($uw_ref_code)."','".addslashes($au_ref_code)."','".$prof_cat_heading['prof_cat1_heading']."','".$prof_cat_heading['prof_cat2_heading']."','".$prof_cat_heading['prof_cat3_heading']."','".$prof_cat_heading['prof_cat4_heading']."','".$prof_cat_heading['prof_cat5_heading']."','".$prof_cat_heading['prof_cat6_heading']."','".$prof_cat_heading['prof_cat7_heading']."','".$prof_cat_heading['prof_cat8_heading']."','".$prof_cat_heading['prof_cat9_heading']."','".$prof_cat_heading['prof_cat10_heading']."','".$prof_cat_ref_code['prof_cat1_ref_code']."','".$prof_cat_ref_code['prof_cat2_ref_code']."','".$prof_cat_ref_code['prof_cat3_ref_code']."','".$prof_cat_ref_code['prof_cat4_ref_code']."','".$prof_cat_ref_code['prof_cat5_ref_code']."','".$prof_cat_ref_code['prof_cat6_ref_code']."','".$prof_cat_ref_code['prof_cat7_ref_code']."','".$prof_cat_ref_code['prof_cat8_ref_code']."','".$prof_cat_ref_code['prof_cat9_ref_code']."','".$prof_cat_ref_code['prof_cat10_ref_code']."','".$level['level']."','". $level['level_title']."','".$level['level_icon']."','".$level['level_heading']."','".$level['level_title_heading']."','".$level['level_icon_heading']."','".$level['level_icon_type']."','".$special_key['special_key1']."','".$special_key['special_key2']."','".$special_key['special_key3']."','".$special_key['special_ref_code1']."','".$special_key['special_ref_code2']."','".$special_key['special_ref_code3']."','".$pop_show."',0,0,0,0)";

               // echo $sql;

                $STH = $DBH->prepare($sql);

                $STH->execute();

                // echo $STH ; die('fkjghjf');

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

            // $edit_action_id = '315';
            // $delete_action_id = '316';
            //update by ample 
            $edit_action_id = '335';
            $delete_action_id = '336';

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

                    $output .= '<td height="30" align="center">'.$row['pop_show'].'</td>';

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
                   
                $canv_loc_cat_link = $row['canv_loc_cat_link'];
                $canv_user_cat_link = $row['canv_user_cat_link'];
                $canv_wn_cat_link = $row['canv_wn_cat_link'];
                $canv_au_cat_link = $row['canv_au_cat_link'];
                

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
                $canv_loc_cat_show_fetch = $row['canv_loc_cat_show_fetch'];
                $canv_user_cat_show_fetch = $row['canv_user_cat_show_fetch'];
                $canv_wn_cat_show_fetch = $row['canv_wn_cat_show_fetch'];
                $canv_au_cat_show_fetch = $row['canv_au_cat_show_fetch'];

                /* code added by ample 04-11-19 */
                $prof_cat_heading=array();
                $prof_cat_heading['prof_cat1_heading'] = $row['prof_cat1_heading'];
                $prof_cat_heading['prof_cat2_heading'] = $row['prof_cat2_heading'];
                $prof_cat_heading['prof_cat3_heading'] = $row['prof_cat3_heading'];
                $prof_cat_heading['prof_cat4_heading'] = $row['prof_cat4_heading'];
                $prof_cat_heading['prof_cat5_heading'] = $row['prof_cat5_heading'];
                $prof_cat_heading['prof_cat6_heading'] = $row['prof_cat6_heading'];
                $prof_cat_heading['prof_cat7_heading'] = $row['prof_cat7_heading'];
                $prof_cat_heading['prof_cat8_heading'] = $row['prof_cat8_heading'];
                $prof_cat_heading['prof_cat9_heading'] = $row['prof_cat9_heading'];
                $prof_cat_heading['prof_cat10_heading'] = $row['prof_cat10_heading'];
                $prof_cat_ref_code=array();
                $prof_cat_ref_code['prof_cat1_ref_code'] = $row['prof_cat1_ref_code'];
                $prof_cat_ref_code['prof_cat2_ref_code'] = $row['prof_cat2_ref_code'];
                $prof_cat_ref_code['prof_cat3_ref_code'] = $row['prof_cat3_ref_code'];
                $prof_cat_ref_code['prof_cat4_ref_code'] = $row['prof_cat4_ref_code'];
                $prof_cat_ref_code['prof_cat5_ref_code'] = $row['prof_cat5_ref_code'];
                $prof_cat_ref_code['prof_cat6_ref_code'] = $row['prof_cat6_ref_code'];
                $prof_cat_ref_code['prof_cat7_ref_code'] = $row['prof_cat7_ref_code'];
                $prof_cat_ref_code['prof_cat8_ref_code'] = $row['prof_cat8_ref_code'];
                $prof_cat_ref_code['prof_cat9_ref_code'] = $row['prof_cat9_ref_code'];
                $prof_cat_ref_code['prof_cat10_ref_code'] = $row['prof_cat10_ref_code'];
                 /* code added by ample 04-11-19 */
                 
                $location_ref_code = $row['location_ref_code'];
                $ur_ref_code = $row['ur_ref_code'];
                $uw_ref_code = $row['uw_ref_code'];
                $au_ref_code = $row['au_ref_code'];
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

                
                // add by ample 21-11-19
                $cat_uniq_id=array();
                $cat_uniq_id['prof_cat1_uid'] = $row['prof_cat1_uid'];
                $cat_uniq_id['prof_cat2_uid'] = $row['prof_cat2_uid'];
                $cat_uniq_id['prof_cat3_uid'] = $row['prof_cat3_uid'];
                $cat_uniq_id['prof_cat4_uid'] = $row['prof_cat4_uid'];
                $cat_uniq_id['prof_cat5_uid'] = $row['prof_cat5_uid'];
                $cat_uniq_id['prof_cat6_uid'] = $row['prof_cat6_uid'];
                $cat_uniq_id['prof_cat7_uid'] = $row['prof_cat7_uid'];
                $cat_uniq_id['prof_cat8_uid'] = $row['prof_cat8_uid'];
                $cat_uniq_id['prof_cat9_uid'] = $row['prof_cat9_uid'];
                $cat_uniq_id['prof_cat10_uid'] = $row['prof_cat10_uid'];
                $cat_uniq_id['loc_cat_uid'] = $row['loc_cat_uid'];
                $cat_uniq_id['ur_cat_uid'] = $row['ur_cat_uid'];
                $cat_uniq_id['uwn_uid'] = $row['uwn_uid'];
                $cat_uniq_id['au_cat_uid'] = $row['au_cat_uid'];
                

                $level=array();
                $level['level']=$row['level'];
                $level['level_heading']=$row['level_heading'];
                $level['level_title']=$row['level_title'];
                $level['level_title_heading']=$row['level_title_heading'];
                $level['level_icon']=$row['level_icon'];
                $level['level_icon_heading']=$row['level_icon_heading'];
                //add by ample 16-12-19
                $level['level_icon_type']=$row['level_icon_type'];

                //add by ample 19-05-20

                $special_key=array(
                    'special_key1'=>$row['special_key1'],
                    'special_key2'=>$row['special_key2'],
                    'special_key3'=>$row['special_key3'],
                    'special_ref_code1'=>$row['special_ref_code1'],
                    'special_ref_code2'=>$row['special_ref_code2'],
                    'special_ref_code3'=>$row['special_ref_code3'],
                );

                $pop_show=$row['pop_show']; //add by ample 07-04-20
                

            }
            //update by ample 13-11-19 & 21-11-19
            return array($admin_comment,$arr_heading,$healcareandwellbeing,$page_name,$ref_code,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$pag_cat_status,$heading,$time_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$order_show,$duration_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$canv_sub_cat1_link,$canv_sub_cat2_link,$canv_sub_cat3_link,$canv_sub_cat4_link,$canv_sub_cat5_link,$canv_sub_cat6_link,$canv_sub_cat7_link,$canv_sub_cat8_link,$canv_sub_cat9_link,$canv_sub_cat10_link, $canv_loc_cat_link, $canv_user_cat_link, $canv_wn_cat_link, $canv_au_cat_link,$canv_sub_cat1_show_fetch,$canv_sub_cat2_show_fetch,$canv_sub_cat3_show_fetch,$canv_sub_cat4_show_fetch,$canv_sub_cat5_show_fetch,$canv_sub_cat6_show_fetch,$canv_sub_cat7_show_fetch,$canv_sub_cat8_show_fetch,$canv_sub_cat9_show_fetch,$canv_sub_cat10_show_fetch,$canv_loc_cat_show_fetch, $canv_user_cat_show_fetch,$canv_wn_cat_show_fetch, $canv_au_cat_show_fetch,$page_type,$location_ref_code,$ur_ref_code, $uw_ref_code, $au_ref_code,$prof_cat_heading,$prof_cat_ref_code,$cat_uniq_id,$level,$pop_show,$special_key);

	}  

    //update function by ample 04-11-19 & update 16-12-19 & 19-05-20

       public function updateDataCatDropdown($admin_comment,$arr_heading,$pag_cat_status,$admin_id,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$id,$time_show,$duration_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$heading,$order_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$cat_fetch_show_data,$canv_sub_cat_link,$data_source, $location_ref_code, $ur_ref_code, $uw_ref_code, $au_ref_code,$prof_cat_heading,$prof_cat_ref_code,$level,$pop_show,$special_key)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $updated_on_date = date('Y-m-d H:i:s');

            //update SQL by ample 04-11-19 & update 16-12-19

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
                    . "`canv_loc_cat_show_fetch` = '".addslashes($cat_fetch_show_data['canv_loc_cat_show_fetch'])."' ,"
                    . "`canv_user_cat_show_fetch` = '".addslashes($cat_fetch_show_data['canv_user_cat_show_fetch'])."' ,"
                    . "`canv_wn_cat_show_fetch` = '".addslashes($cat_fetch_show_data['canv_wn_cat_show_fetch'])."' ,"
                    . "`canv_au_cat_show_fetch` = '".addslashes($cat_fetch_show_data['canv_au_cat_show_fetch'])."' ,"

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
                    . "`canv_loc_cat_link` = '".addslashes($canv_sub_cat_link['canv_loc_cat_link'])."' ,"
                    . "`canv_user_cat_link` = '".addslashes($canv_sub_cat_link['canv_user_cat_link'])."' ,"
                    . "`canv_wn_cat_link` = '".addslashes($canv_sub_cat_link['canv_wn_cat_link'])."' ,"
                    . "`canv_au_cat_link` = '".addslashes($canv_sub_cat_link['canv_au_cat_link'])."' ,"

                    . "`prof_cat1_heading` = '".addslashes($prof_cat_heading['prof_cat1_heading'])."' ,"
                    . "`prof_cat2_heading` = '".addslashes($prof_cat_heading['prof_cat2_heading'])."' ,"
                    . "`prof_cat3_heading` = '".addslashes($prof_cat_heading['prof_cat3_heading'])."' ,"
                    . "`prof_cat4_heading` = '".addslashes($prof_cat_heading['prof_cat4_heading'])."' ,"
                    . "`prof_cat5_heading` = '".addslashes($prof_cat_heading['prof_cat5_heading'])."' ,"
                    . "`prof_cat6_heading` = '".addslashes($prof_cat_heading['prof_cat6_heading'])."' ,"
                    . "`prof_cat7_heading` = '".addslashes($prof_cat_heading['prof_cat7_heading'])."' ,"
                    . "`prof_cat8_heading` = '".addslashes($prof_cat_heading['prof_cat8_heading'])."' ,"
                    . "`prof_cat9_heading` = '".addslashes($prof_cat_heading['prof_cat9_heading'])."' ,"
                    . "`prof_cat10_heading` = '".addslashes($prof_cat_heading['prof_cat10_heading'])."' ,"

                    . "`prof_cat1_ref_code` = '".addslashes($prof_cat_ref_code['prof_cat1_ref_code'])."' ,"
                    . "`prof_cat2_ref_code` = '".addslashes($prof_cat_ref_code['prof_cat2_ref_code'])."' ,"
                    . "`prof_cat3_ref_code` = '".addslashes($prof_cat_ref_code['prof_cat3_ref_code'])."' ,"
                    . "`prof_cat4_ref_code` = '".addslashes($prof_cat_ref_code['prof_cat4_ref_code'])."' ,"
                    . "`prof_cat5_ref_code` = '".addslashes($prof_cat_ref_code['prof_cat5_ref_code'])."' ,"
                    . "`prof_cat6_ref_code` = '".addslashes($prof_cat_ref_code['prof_cat6_ref_code'])."' ,"
                    . "`prof_cat7_ref_code` = '".addslashes($prof_cat_ref_code['prof_cat7_ref_code'])."' ,"
                    . "`prof_cat8_ref_code` = '".addslashes($prof_cat_ref_code['prof_cat8_ref_code'])."' ,"
                    . "`prof_cat9_ref_code` = '".addslashes($prof_cat_ref_code['prof_cat9_ref_code'])."' ,"
                    . "`prof_cat10_ref_code` = '".addslashes($prof_cat_ref_code['prof_cat10_ref_code'])."' ,"

                    . "`time_heading` = '".addslashes($arr_heading['time_heading'])."' ,"

                    . "`duration_heading` = '".addslashes($arr_heading['duration_heading'])."' ,"

                    . "`location_heading` = '".addslashes($arr_heading['location_heading'])."' ,"

                    . "`like_dislike_heading` = '".addslashes($arr_heading['like_dislike_heading'])."' ,"

                    . "`set_goals_heading` = '".addslashes($arr_heading['set_goals_heading'])."' ,"

                    . "`scale_heading` = '".addslashes($arr_heading['scale_heading'])."' ,"

                    . "`reminder_heading` = '".addslashes($arr_heading['reminder_heading'])."' ,"

                    . "`comments_heading` = '".addslashes($arr_heading['comments_heading'])."' ,"

                    . "`updated_by_admin` = '".addslashes($admin_id)."' ,"
                    . "`location_ref_code` = '".addslashes($location_ref_code)."' ,"
                    . "`ur_ref_code` = '".addslashes($ur_ref_code)."' ,"
                    . "`uw_ref_code` = '".addslashes($uw_ref_code)."' ,"
                    . "`au_ref_code` = '".addslashes($au_ref_code)."' ,"

                    . "`level`='".$level['level']."',`level_title`='".$level['level_title']."',`level_icon`='".$level['level_icon']."',`level_heading`='".$level['level_heading']."',`level_title_heading`='".$level['level_title_heading']."',`level_icon_heading`='".$level['level_icon_heading']."',`level_icon_type`='".$level['level_icon_type']."',"

                    . "`special_key1`='".$special_key['special_key1']."',`special_key2`='".$special_key['special_key2']."',`special_key3`='".$special_key['special_key3']."',"

                    . "`special_ref_code1`='".$special_key['special_ref_code1']."',`special_ref_code2`='".$special_key['special_ref_code2']."',`special_ref_code3`='".$special_key['special_ref_code3']."',"

                    . "`pop_show` = '".addslashes($pop_show)."' ,"

                    . "`updated_on_date` = '".addslashes($updated_on_date)."' "

                    . "WHERE `page_cat_id` = '".$id."' ";

//	    echo $sql;exit;

           

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

            

            $sql = "INSERT INTO `tblpagedropdowns` (`admin_comment`,`menu_id`,`pdm_id`,`page_id_str`,`pd_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`,`plan_table`,`pd_deleted`) "

                . "VALUES ('".addslashes($admin_comment)."','".addslashes($menu_id)."','".addslashes($pdm_id)."','".addslashes($page_id_str)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."','".$table_name."',0)";

                $STH = $DBH->prepare($sql);

                $STH->execute();

            if($STH->rowCount() > 0)

                {

                     $return = true;

                    //Insert lOGS
                     $lastInsertedId = $DBH->lastInsertId();
                    $logsObject = new Logs();
                    $logsData = [
                        'page' => 'page_dropdowns',
                        'reference_id' => $lastInsertedId
                    ];
                    $logsObject->insertLogs($logsData);

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

            

            $sql = "INSERT INTO `tblpagedropdownmodules` (`pdm_name`,`pdm_status`,`pdm_add_date`,`admin_menu_id`,`pdm_deleted`) "

                . "VALUES ('".addslashes($pdm_name)."','1','".$updated_on_date."',0,0)";

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



                    if (!is_array($arr_selected_page_id)) {
                        $arr_selected_page_id = [];  // Ensure it’s an array
                    }

                    if (in_array($menu_id, $arr_selected_page_id)) {
                        $selected = ' checked ';
                    } else {
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
            //Inserting Logs
           
            $logsObject = new Logs();
            $logsData = [
                'page' => 'page_dropdowns',
                'reference_id' => $pd_id
            ];
            $logsObject->insertLogs($logsData);

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



            $option_str .="<input type='hidden' name='event_name' id='event_name' value=".$this->getFavCategoryNameVivek($row['wellbeing_id']).">";

            

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

 
//update by ample 23-01-20 & update 13-04-20 & update 07-05-20 & update 22-05-20 & 28-10-20
public function AddDesignMyLife($text_box_show,$text_box_count,$user_upload_show,$box_count,$quick_response_show,$quick_tip_icon,$quick_tip_icon_type,$quick_response_heading,$response_heading,$show_to_user,$page_cat_id,$cat_fetch_show_data,$canv_sub_cat_link,$prof_cat2,$prof_cat3,$prof_cat4,$sub_cat2,$sub_cat3,$sub_cat4,$narration_show,$comment_order_show,$reminder_order_show,$scale_order_show,$set_goals_order_show,$like_dislike_order_show,$location_order_show,$duration_order_show,$time_order_show,$user_date_order_show,$ref_code,$admin_comment,$title_id,$narration,$user_date_show,$user_date_show_heading,$time_show,$time_heading,$duration_show,$duration_heading,$location_show,$location_heading,$location_category,$like_dislike_show,$like_dislike_heading,$user_response_category,$set_goals_show,$set_goals_heading,$user_what_next_category,$scale_show,$scale_heading,$reminder_show,$reminder_heading,$alerts_updates_category,$comments_show,$comments_heading,$order_show,$fav_cat_type_id,$fav_cat_id_data,$admin_id,$group_code,$prof_cat_heading,$prof_cat_ref_code,$cat_link_data,$cat_ref_code,$level,$pop_show,$example_box,$box_data,$is_featured)

{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            //added by ample 06-11-19
            $sub_cat1_show_fetch = ($cat_fetch_show_data['sub_cat1_show_fetch'] ==''? 0 : $cat_fetch_show_data['sub_cat1_show_fetch']);

            $sub_cat2_show_fetch = ($cat_fetch_show_data['sub_cat2_show_fetch'] ==''? 0 : $cat_fetch_show_data['sub_cat2_show_fetch']);

            $sub_cat3_show_fetch = ($cat_fetch_show_data['sub_cat3_show_fetch'] ==''? 0 : $cat_fetch_show_data['sub_cat3_show_fetch']);

            $sub_cat4_show_fetch = ($cat_fetch_show_data['sub_cat4_show_fetch'] ==''? 0 : $cat_fetch_show_data['sub_cat4_show_fetch']);
            $text_box_show = ($text_box_show ==''? 0 : $text_box_show);
            $user_upload_show = ($user_upload_show ==''? 0 : $user_upload_show);
            $quick_response_show = ($quick_response_show ==''? 0 : $quick_response_show);
            $narration_show = ($narration_show ==''? 0 : $narration_show);
            $user_date_show = ($user_date_show ==''? 0 : $user_date_show);
            $time_show = ($time_show ==''? 0 : $time_show);
            $duration_show = ($duration_show ==''? 0 : $duration_show);
            $location_show = ($location_show ==''? 0 : $location_show);
            $like_dislike_show = ($like_dislike_show ==''? 0 : $like_dislike_show);
            $set_goals_show = ($set_goals_show ==''? 0 : $set_goals_show);
            $scale_show = ($scale_show ==''? 0 : $scale_show);
            $reminder_show = ($reminder_show ==''? 0 : $reminder_show);
            $comments_show = ($comments_show ==''? 0 : $comments_show);
            $fav_cat_type_id = ($fav_cat_type_id ==''? 0 : $fav_cat_type_id);
            $comment_order_show = ($comment_order_show ==''? 0 : $comment_order_show); $reminder_order_show = ($reminder_order_show ==''? 0 : $reminder_order_show);
            $scale_order_show = ($scale_order_show ==''? 0 : $scale_order_show);
            $set_goals_order_show = ($set_goals_order_show ==''? 0 : $set_goals_order_show);
            $like_dislike_order_show = ($like_dislike_order_show ==''? 0 : $like_dislike_order_show);
            $location_order_show = ($location_order_show ==''? 0 : $location_order_show);
            $duration_order_show = ($duration_order_show ==''? 0 : $duration_order_show);
            $time_order_show = ($time_order_show ==''? 0 : $time_order_show);
            $user_date_order_show = ($user_date_order_show ==''? 0 : $user_date_order_show);
            $box_data['other_box_type'] = ($box_data['other_box_type'] ==''? 0 : $box_data['other_box_type']);
            $level['level_icon'] = ($level['level_icon'] ==''? 0 : $level['level_icon']);
            $is_featured = ($is_featured ==''? 0 : $is_featured);
            $example_box = ($example_box ==''? 0 : $example_box);

            $return = false;

            // try {

            //update SQL for add prof_cat_heading & prof_cat_link & prof_cat_refer_code by ample 06-11-19 & update 23-01-20 & 22-05-20 prof_cat1_uidprof_cat_id
             $sql = "INSERT INTO `tbl_design_your_life`(`input_box_show`,`input_box_count`,`user_upload_show`,`box_count`,`quick_response_show`,`quick_tip_icon`,`quick_tip_icon_type`,`quick_response_heading`,`response_heading`,`show_to_user`,`data_category`,`narration_show`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`sub_cat2`,`sub_cat3`,`sub_cat4`,`sub_cat1_show_fetch`,`sub_cat2_show_fetch`,`sub_cat3_show_fetch`,`sub_cat4_show_fetch`,`sub_cat1_link`,`sub_cat2_link`,`sub_cat3_link`,`sub_cat4_link`,`ref_code`, `box_title`, `narration`, `admin_comment`, "

                    . "`user_date_show`, `time_show`, `duration_show`, `location_show`, `User_view`, `User_Interaction`, `scale_show`, `alert_show`, `comment_show`, `user_date_heading`, `time_heading`, "

                    . "`duration_heading`, `location_heading`, `like_dislike_heading`, `set_goals_heading`, `scale_heading`, `reminder_heading`, `comments_heading`, `location_fav_cat`, `user_response_fav_cat`, `user_what_fav_cat`, `alerts_fav_cat`, `order_show`,`added_by`,`prof_cat_id`,`sub_cat_id`,`comment_order_show`,`reminder_order_show`,`scale_order_show`,`set_goals_order_show`,`like_dislike_order_show`,`location_order_show`,`duration_order_show`,`time_order_show`,`user_date_order_show`,`group_code_id`,prof_cat1_heading,prof_cat2_heading,prof_cat3_heading,prof_cat4_heading,prof_cat1_ref_code,prof_cat2_ref_code,prof_cat3_ref_code,prof_cat4_ref_code,"

                    . "`canv_loc_cat_show_fetch`, `canv_user_cat_show_fetch`, `canv_wn_cat_show_fetch`, `canv_au_cat_show_fetch`, `canv_loc_cat_link`, `canv_user_cat_link`, `canv_wn_cat_link`, `canv_au_cat_link`, `location_ref_code`, `ur_ref_code`, `uw_ref_code`, `au_ref_code`,"

                    . "`qr_box_type`, `qr_data_source`, `qr_specifiq_text`, `other_box_type`, `other_data_source`, `other_specIfiq_text`, `icon_box1`, `icon_box_source1`, `icon_box2`, `icon_box_source2`, "

                    . "`level`, `level_title`, `level_icon`, `level_icon_type`, `level_heading`, `level_title_heading`, `level_icon_heading`,pop_show,banner_position,example_box,is_featured,updated_by,prof_cat1_uid,prof_cat2_uid,prof_cat3_uid,prof_cat4_uid,loc_cat_uid,ur_cat_uid,uwn_uid,au_cat_uid,special_font_color,fav_cat_type_id_header,special_bg_color,special_icon_code,special_font_family

                    ) "

                    . "VALUES ('".addslashes($text_box_show)."','".addslashes($text_box_count)."','".addslashes($user_upload_show)."','".addslashes($box_count)."','".addslashes($quick_response_show)."','".addslashes($quick_tip_icon)."','".addslashes($quick_tip_icon_type)."','".addslashes($quick_response_heading)."','".addslashes($response_heading)."','".addslashes($show_to_user)."','".$page_cat_id."','".$narration_show."','".$prof_cat2."','".$prof_cat3."','".$prof_cat4."','".$sub_cat2."','".$sub_cat3."','".$sub_cat4."','".$sub_cat1_show_fetch."','".$sub_cat2_show_fetch."','".$sub_cat3_show_fetch."','".$sub_cat4_show_fetch."','".$canv_sub_cat_link['sub_cat1_link']."','".$canv_sub_cat_link['sub_cat2_link']."','".$canv_sub_cat_link['sub_cat3_link']."','".$canv_sub_cat_link['sub_cat4_link']."','".addslashes($ref_code)."','".addslashes($title_id)."','".addslashes($narration)."',"

                    . "'".addslashes($admin_comment)."',"

                    . "'".$user_date_show."','".$time_show."','".$duration_show."','".$location_show."','".$like_dislike_show."','".$set_goals_show."','".$scale_show."','".$reminder_show."','".$comments_show."','".addslashes($user_date_show_heading)."','".addslashes($time_heading)."',"

                    . "'".addslashes($duration_heading)."','".addslashes($location_heading)."','".addslashes($like_dislike_heading)."','".addslashes($set_goals_heading)."','".addslashes($scale_heading)."','".addslashes($reminder_heading)."','".addslashes($comments_heading)."','".addslashes($location_category)."','".addslashes($user_response_category)."',"

                    . "'".addslashes($user_what_next_category)."','".addslashes($alerts_updates_category)."','".$order_show."','".$admin_id."','".$fav_cat_type_id."','".addslashes($fav_cat_id_data)."','".$comment_order_show."','".$reminder_order_show."','".$scale_order_show."','".$set_goals_order_show."','".$like_dislike_order_show."','".$location_order_show."','".$duration_order_show."','".$time_order_show."','".$user_date_order_show."','".$group_code."','".$prof_cat_heading['prof_cat1_heading']."','".$prof_cat_heading['prof_cat2_heading']."','".$prof_cat_heading['prof_cat3_heading']."','".$prof_cat_heading['prof_cat4_heading']."','".$prof_cat_ref_code['prof_cat1_ref_code']."','".$prof_cat_ref_code['prof_cat2_ref_code']."','".$prof_cat_ref_code['prof_cat3_ref_code']."','".$prof_cat_ref_code['prof_cat4_ref_code']."',"

                    . "'".$cat_fetch_show_data['canv_loc_cat_show_fetch']."','". $cat_fetch_show_data['canv_user_cat_show_fetch']."','".$cat_fetch_show_data['canv_wn_cat_show_fetch']."','".$cat_fetch_show_data['canv_au_cat_show_fetch']."','".$cat_link_data['canv_loc_cat_link']."','".$cat_link_data['canv_user_cat_link']."','".$cat_link_data['canv_wn_cat_link']."','".$cat_link_data['canv_au_cat_link']."','".$cat_ref_code['location_ref_code']."','".$cat_ref_code['ur_ref_code']."','".$cat_ref_code['uw_ref_code']."','".$cat_ref_code['au_ref_code']."',"

                    . "'".$box_data['qr_box_type']."','". $box_data['qr_data_source']."','".$box_data['qr_specifiq_text']."','".$box_data['other_box_type']."','".$box_data['other_data_source']."','".$box_data['other_specifiq_text']."','".$box_data['icon_box1']."','".$box_data['box_source1']."','".$box_data['icon_box2']."','".$box_data['box_source2']."',"

                       . "'".$level['level']."','". $level['level_title']."','".$level['level_icon']."','".$level['level_icon_type']."','".$level[' level_heading']."','".$level['  level_title_heading']."','".$level['level_icon_heading']."', '".$pop_show."', 'Bottom', '".$example_box."','".$is_featured."', '0', '0', '0', '0', '0', '0', '0', '0', '0','0', '', '', '',''

                )";
            
            //echo $sql; die('--');

             $STH = $DBH->query($sql);

            if($STH->rowCount()  > 0)

            {

                $return = true;
                $lastInsertedId = $DBH->lastInsertId();
                $logsObject = new Logs();
                $logsData = [
                    'page' => 'manage-design-your-life',
                    'reference_id' => $lastInsertedId
                ];
                $logsObject->insertLogs($logsData);

            }

            // } catch (Exception $e) {

            //     $stringData = '[updateRecordCommon] Catch Error:'.$e->getMessage();

            //     $this->debuglog($stringData);

        //}

      return $return;

        

}


//update by ample 23-01-20 & again update 13-04-20 & update 27-04-20 & update 07-05-20 & update 23-05-20 & 09-06-20 & 28-10-20
public function UpdateDesignMyLife($text_box_show,$text_box_count,$user_upload_show,$quick_response_show,$quick_tip_icon,$quick_tip_icon_type,$quick_response_heading,$response_heading,$box_count,$show_to_user,$page_cat_id,$fav_cat_type_id_2,$canv_sub_cat1_show_fetch,$canv_sub_cat1_link,$canv_sub_cat2_show_fetch,$canv_sub_cat2_link,$fav_cat_id_data_2,$fav_cat_type_id_3,$canv_sub_cat3_show_fetch,$canv_sub_cat3_link,$fav_cat_id_data_3,$fav_cat_type_id_4,$canv_sub_cat4_show_fetch,$canv_sub_cat4_link,$fav_cat_id_data_4,$narration_show,$comment_order_show,$reminder_order_show,$scale_order_show,$set_goals_order_show,$like_dislike_order_show,$location_order_show,$duration_order_show,$time_order_show,$user_date_order_show,$ref_code,$admin_comment,$title_id,$narration,$user_date_show,$user_date_show_heading,$time_show,$time_heading,$duration_show,$duration_heading,$location_show,$location_heading,$location_category,$like_dislike_show,$like_dislike_heading,$user_response_category,$set_goals_show,$set_goals_heading,$user_what_next_category,$scale_show,$scale_heading,$reminder_show,$reminder_heading,$alerts_updates_category,$comments_show,$comments_heading,$order_show,$fav_cat_type_id,$fav_cat_id_data,$admin_id,$updated_date,$design_id,$group_code,$prof_cat_heading,$prof_cat_ref_code,$cat_fetch_show_data,$cat_link_data,$cat_ref_code,$level,$pop_show,$banner_position,$status,$example_box,$box_data,$special_text_position,$special_data,$is_featured)

{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false;


            $sub_cat1_show_fetch = ($cat_fetch_show_data['sub_cat1_show_fetch'] ==''? 0 : $cat_fetch_show_data['sub_cat1_show_fetch']);

            $sub_cat2_show_fetch = ($cat_fetch_show_data['sub_cat2_show_fetch'] ==''? 0 : $cat_fetch_show_data['sub_cat2_show_fetch']);

            $sub_cat3_show_fetch = ($cat_fetch_show_data['sub_cat3_show_fetch'] ==''? 0 : $cat_fetch_show_data['sub_cat3_show_fetch']);

            $sub_cat4_show_fetch = ($cat_fetch_show_data['sub_cat4_show_fetch'] ==''? 0 : $cat_fetch_show_data['sub_cat4_show_fetch']);
            $text_box_show = ($text_box_show ==''? 0 : $text_box_show);
            $user_upload_show = ($user_upload_show ==''? 0 : $user_upload_show);
            $quick_response_show = ($quick_response_show ==''? 0 : $quick_response_show);
            $narration_show = ($narration_show ==''? 0 : $narration_show);
            $user_date_show = ($user_date_show ==''? 0 : $user_date_show);
            $time_show = ($time_show ==''? 0 : $time_show);
            $duration_show = ($duration_show ==''? 0 : $duration_show);
            $location_show = ($location_show ==''? 0 : $location_show);
            $like_dislike_show = ($like_dislike_show ==''? 0 : $like_dislike_show);
            $set_goals_show = ($set_goals_show ==''? 0 : $set_goals_show);
            $scale_show = ($scale_show ==''? 0 : $scale_show);
            $reminder_show = ($reminder_show ==''? 0 : $reminder_show);
            $comments_show = ($comments_show ==''? 0 : $comments_show);
            $fav_cat_type_id = ($fav_cat_type_id ==''? 0 : $fav_cat_type_id);
            $comment_order_show = ($comment_order_show ==''? 0 : $comment_order_show); $reminder_order_show = ($reminder_order_show ==''? 0 : $reminder_order_show);
            $scale_order_show = ($scale_order_show ==''? 0 : $scale_order_show);
            $set_goals_order_show = ($set_goals_order_show ==''? 0 : $set_goals_order_show);
            $like_dislike_order_show = ($like_dislike_order_show ==''? 0 : $like_dislike_order_show);
            $location_order_show = ($location_order_show ==''? 0 : $location_order_show);
            $duration_order_show = ($duration_order_show ==''? 0 : $duration_order_show);
            $time_order_show = ($time_order_show ==''? 0 : $time_order_show);
            $user_date_order_show = ($user_date_order_show ==''? 0 : $user_date_order_show);
            $box_data['other_box_type'] = ($box_data['other_box_type'] ==''? 0 : $box_data['other_box_type']);
            $level['level_icon'] = ($level['level_icon'] ==''? 0 : $level['level_icon']);
            $is_featured = ($is_featured ==''? 0 : $is_featured);
            $canv_sub_cat1_show_fetch = ($canv_sub_cat1_show_fetch ==''? 0 : $canv_sub_cat1_show_fetch);
            $canv_sub_cat2_show_fetch = ($canv_sub_cat2_show_fetch ==''? 0 : $canv_sub_cat2_show_fetch);
            $canv_sub_cat3_show_fetch = ($canv_sub_cat3_show_fetch ==''? 0 : $canv_sub_cat3_show_fetch);
            $canv_sub_cat4_show_fetch = ($canv_sub_cat4_show_fetch ==''? 0 : $canv_sub_cat4_show_fetch);
            $cat_fetch_show_data['canv_loc_cat_show_fetch'] = ($cat_fetch_show_data['canv_loc_cat_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_loc_cat_show_fetch']);
            $cat_fetch_show_data['canv_user_cat_show_fetch'] = ($cat_fetch_show_data['canv_user_cat_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_user_cat_show_fetch']);
            $cat_fetch_show_data['canv_wn_cat_show_fetch'] = ($cat_fetch_show_data['canv_wn_cat_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_wn_cat_show_fetch']);
            $cat_fetch_show_data['canv_au_cat_show_fetch'] = ($cat_fetch_show_data['canv_au_cat_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_au_cat_show_fetch']);
            $cat_fetch_show_data['special_font_size'] = ($cat_fetch_show_data['special_font_size'] ==''? 0 : $cat_fetch_show_data['special_font_size']);
            $special_data['special_font_size'] = ($special_data['special_font_size'] ==''? 0 : $special_data['special_font_size']);
             $example_box = ($example_box ==''? 0 : $example_box);
             // try {
                //update sql for link,refer_code,heading by ample 06-11-19 & update 22-06-20sub_cat1_show_fetch
             $sql = "UPDATE `tbl_design_your_life` SET `show_to_user`='".addslashes($show_to_user)."',`ref_code`='".addslashes($ref_code)."',`box_title`='".addslashes($title_id)."',"

                     . "`narration`='".addslashes($narration)."',`admin_comment`='".$admin_comment."',"

                     . "`user_date_show`='".$user_date_show."',`time_show`='".$time_show."',`duration_show`='".$duration_show."',`location_show`='".$location_show."',`User_view`='".$like_dislike_show."',"

                     . "`User_Interaction`='".$set_goals_show."',`scale_show`='".$scale_show."',`alert_show`='".$reminder_show."',`comment_show`='".$comments_show."',`user_date_heading`='".addslashes($user_date_show_heading)."',"

                     . "`time_heading`='".addslashes($time_heading)."',`duration_heading`='".addslashes($duration_heading)."',`location_heading`='".addslashes($location_heading)."',`like_dislike_heading`='".addslashes($like_dislike_heading)."',`set_goals_heading`='".addslashes($set_goals_heading)."',"

                     . "`scale_heading`='".addslashes($scale_heading)."',`reminder_heading`='".addslashes($reminder_heading)."',`comments_heading`='".addslashes($comments_heading)."',`location_fav_cat`='".addslashes($location_category)."',`user_response_fav_cat`='".addslashes($user_response_category)."',"

                     . "`user_what_fav_cat`='".addslashes($user_what_next_category)."',`alerts_fav_cat`='".addslashes($alerts_updates_category)."',`order_show`='".$order_show."',"

                     . "`prof_cat_id`='".$fav_cat_type_id."',`sub_cat_id`='".addslashes($fav_cat_id_data)."',`comment_order_show`='".$comment_order_show."',`reminder_order_show`='".$reminder_order_show."',`scale_order_show`='".$scale_order_show."',"

                     . "`set_goals_order_show`='".$set_goals_order_show."',`like_dislike_order_show`='".$like_dislike_order_show."',`location_order_show`='".$location_order_show."',`duration_order_show`='".$duration_order_show."',"

                     . "`time_order_show`='".$time_order_show."',`user_date_order_show`='".$user_date_order_show."',"

                     . "`prof_cat2`='".$fav_cat_type_id_2."',`prof_cat3`='".$fav_cat_type_id_3."',`prof_cat4`='".$fav_cat_type_id_4."',`narration_show`='".$narration_show."',"

                     . "`sub_cat2`='".addslashes($fav_cat_id_data_2)."',`sub_cat3`='".addslashes($fav_cat_id_data_3)."',`sub_cat4`='".addslashes($fav_cat_id_data_4)."',"

                     . "`sub_cat1_show_fetch`='".addslashes($canv_sub_cat1_show_fetch)."',`sub_cat2_show_fetch`='".addslashes($canv_sub_cat2_show_fetch)."',`sub_cat3_show_fetch`='".addslashes($canv_sub_cat3_show_fetch)."',`sub_cat4_show_fetch`='".addslashes($canv_sub_cat4_show_fetch)."',"

                     . "`data_category`='".$page_cat_id."',`sub_cat1_link`='".addslashes($canv_sub_cat1_link)."',`sub_cat2_link`='".addslashes($canv_sub_cat2_link)."',`sub_cat3_link`='".addslashes($canv_sub_cat3_link)."',`sub_cat4_link`='".addslashes($canv_sub_cat4_link)."',"

                     . "`prof_cat1_ref_code`='".addslashes($prof_cat_ref_code['prof_cat1_ref_code'])."',`prof_cat2_ref_code`='".addslashes($prof_cat_ref_code['prof_cat2_ref_code'])."',`prof_cat3_ref_code`='".addslashes($prof_cat_ref_code['prof_cat3_ref_code'])."',`prof_cat4_ref_code`='".addslashes($prof_cat_ref_code['prof_cat4_ref_code'])."',"

                     . "`prof_cat1_heading`='".addslashes($prof_cat_heading['prof_cat1_heading'])."',`prof_cat2_heading`='".addslashes($prof_cat_heading['prof_cat2_heading'])."',`prof_cat3_heading`='".addslashes($prof_cat_heading['prof_cat3_heading'])."',`prof_cat4_heading`='".addslashes($prof_cat_heading['prof_cat4_heading'])."',"

                     . "`canv_loc_cat_show_fetch`='".$cat_fetch_show_data['canv_loc_cat_show_fetch']."',`canv_user_cat_show_fetch`='".$cat_fetch_show_data['canv_user_cat_show_fetch']."',`canv_wn_cat_show_fetch`='".$cat_fetch_show_data['canv_wn_cat_show_fetch']."',`canv_au_cat_show_fetch`='".$cat_fetch_show_data['canv_au_cat_show_fetch']."',"

                     . "`canv_loc_cat_link`='".$cat_link_data['canv_loc_cat_link']."',`canv_user_cat_link`='".$cat_link_data['canv_user_cat_link']."',`canv_wn_cat_link`='".$cat_link_data['canv_wn_cat_link']."',`canv_au_cat_link`='".$cat_link_data['canv_au_cat_link']."',"

                     . "`location_ref_code`='".$cat_ref_code['location_ref_code']."',`ur_ref_code`='".$cat_ref_code['ur_ref_code']."',`uw_ref_code`='".$cat_ref_code['uw_ref_code']."',`au_ref_code`='".$cat_ref_code['au_ref_code']."',"

                     . "`quick_response_show`='".addslashes($quick_response_show)."',`quick_tip_icon`='".addslashes($quick_tip_icon)."',`quick_tip_icon_type`='".addslashes($quick_tip_icon_type)."',"

                     . "`quick_response_heading`='".addslashes($quick_response_heading)."',`response_heading`='".addslashes($response_heading)."',`box_count`='".addslashes($box_count)."',"

                     . "`user_upload_show`='".addslashes($user_upload_show)."', `input_box_show`='".addslashes($text_box_show)."', `input_box_count`='".addslashes($text_box_count)."',"

                     . "`level`='".$level['level']."',`level_title`='".$level['level_title']."',`level_icon`='".$level['level_icon']."',`level_icon_type`='".$level['level_icon_type']."',`level_heading`='".$level['level_heading']."',`level_title_heading`='".$level['level_title_heading']."',`level_icon_heading`='".$level['level_icon_heading']."',"

                     . "`qr_box_type`='".$box_data['qr_box_type']."',`other_box_type`='".$box_data['other_box_type']."',`qr_data_source`='".$box_data['qr_data_source']."',`other_data_source`='".$box_data['other_data_source']."',`qr_specifiq_text`='".$box_data['qr_specifiq_text']."',`other_specifiq_text`='".$box_data['other_specifiq_text']."',`icon_box1`='".$box_data['icon_box1']."',`icon_box2`='".$box_data['icon_box2']."',`icon_box_source1`='".$box_data['box_source1']."',`icon_box_source2`='".$box_data['box_source2']."',"

                     . "`pop_show`='".addslashes($pop_show)."',"
                     . "`banner_position`='".addslashes($banner_position)."',"
                     . "`status`='".addslashes($status)."',"
                     . "`example_box`='".addslashes($example_box)."',"
                     . "`special_text_position`='".addslashes($special_text_position)."',"
                     . "`special_bg_color`='".addslashes($special_data['special_bg_color'])."',"
                     . "`special_font_color`='".addslashes($special_data['special_font_color'])."',"
                     . "`special_icon_code`='".addslashes($special_data['special_icon_code'])."',"
                     . "`special_font_family`='".addslashes($special_data['special_font_family'])."',"
                     . "`special_font_size`='".addslashes($special_data['special_font_size'])."',"
                     . "`is_featured`='".addslashes($is_featured)."',"
                     . "`updated_by`='".$admin_id."', `group_code_id` = '".$group_code."' WHERE id = '".$design_id."' ";

           

            $STH = $DBH->query($sql);

            if($STH->rowCount() > 0)

            {

                $return = true;
                $logsObject = new Logs();
                $logsData = [
                    'page' => 'manage-design-your-life',
                    'reference_id' => $design_id
                ];
                $logsObject->insertLogs($logsData);

            }

        //     } catch (Exception $e) {

        //         $stringData = '[updateRecordCommon] Catch Error:'.$e->getMessage();

        //         $this->debuglog($stringData);

           

        // }

      return $return;

        

}





public function getAllDesignMyLife($search,$status,$filterData)

	{

            

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();



            $admin_id = $_SESSION['admin_id'];

            // $edit_action_id = '315';
            // $delete_action_id = '316';
            // update by ample 13-12-19
            $edit_action_id = '339';
            $delete_action_id = '340';

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

            $searchQuery = '';
            if(!empty($filterData['system_category'])){
                $searchQuery.= ' AND `data_category`='.$filterData['system_category'];
            }
            if(!empty($filterData['profile_category'])){
                $searchQuery.= ' AND `prof_cat_id`='.$filterData['profile_category'];
            }
            if(!empty($filterData['sub_category'])){
                $searchQuery.= ' AND FIND_IN_SET("'.$filterData['sub_category'].'", sub_cat_id)';
                
            }
            if(!empty($filterData['status'])){
                if($filterData['status']=='active'){
                    $searchQuery.= ' AND `status`=1';
                }elseif($filterData['status']=='inactive'){
                    $searchQuery.= ' AND `status`=0';
                }
                
            }
            if(!empty($filterData['added_by'])){
                $searchQuery.= ' AND `added_by`='.$filterData['added_by'];
            }
            if(!empty($filterData['modified_by'])){
                $searchQuery.= ' AND `added_by`='.$filterData['modified_by'];
            }
            if(!empty($filterData['user_upload'])){
                if($filterData['status']=='yes'){
                    $searchQuery.= ' AND `user_upload_show`=1';
                }elseif($filterData['status']=='no'){
                    $searchQuery.= ' AND `user_upload_show`=0';
                }
            }
            if(!empty($filterData['pop'])){
                $searchQuery.= ' AND `pop_show`="'.$filterData['pop'].'"';
            }


             $sql = "SELECT * FROM `tbl_design_your_life` WHERE is_deleted = '0' $sql_str_search $sql_str_status  $searchQuery ORDER BY id DESC";

           

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

                    
                    $logsObject = new Logs();
                     $lastUpdatedData = [
                        'page' => 'manage-design-your-life',
                        'reference_id' => $row['id']
                    ];
                    $lastUpdatedData = $logsObject->getLastUpdatedLogs($lastUpdatedData);  
                    						

                    $output .= '<tr class="manage-row" >';

                    $output .= '<td height="30" align="center">'.$i.'</td>';
                    $output .= '<td align="center">'.stripslashes($lastUpdatedData['updateOn']).'
                    <a href="/admin/index.php?mode=logs-history&type=manage-design-your-life&id='.$row['id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';

                    $output .= '<td align="center">'.stripslashes($lastUpdatedData['updateBy']).'<a href="/admin/index.php?mode=logs-history&type=manage-design-your-life&id='.$row['id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';
                   

                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';
 $output .= '<td height="30" align="center">'.$status.'</td>';
                    

                    $output .= '<td align="center" nowrap="nowrap">';

                    

                    if($edit) {

                    $output .= '<a href="index.php?mode=edit-design-your-life&id='.$row['id'].'" ><img src = "images/edit.gif" border="0"></a>';

                    }

                    $output .= '</td>';

                    $output .= '<td align="center" nowrap="nowrap">';

                    if($delete) {

                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/deldesignyourlife.php?id='.$row['page_cat_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

                    }

                    $output .= '<td height="30" align="center">'.$row['order_show'].'</td>';

                    $output .= '<td height="30" align="center">'.date("d-m-Y H:i:s",strtotime($row['add_date'])).'</td>';

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

                    
                    $output .= '<td height="30" align="center">'.$row['pop_show'].'</td>';
                    

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

   

    sort($final_array_new); //add by ample 28-05-20
 

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

            $sql = "INSERT INTO `tbladviserplanatributes` (`apa_name`,`apa_status`,`show_for_adviser`,`show_for_user`,`page_id`,`apa_code`,`ref_report_id`) "

                . "VALUES ('".addslashes($this->getPagenamebyid($page_id))."','1','1','1','".$page_id."',0,0)";

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



public function getAllTablDropdowns($search,$status)

    {

           

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

                

            $admin_id = $_SESSION['admin_id'];

            $edit_action_id = '352';

            $delete_action_id = '353';

            $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

            $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);



            $sql = "SELECT * FROM `tbltabldropdown` WHERE tabl_status=1 AND tabl_delete=0";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            $total_records = $STH->rowCount();



            if($total_records>0)

            {

                $index=0;

                while($row=$STH->fetch(PDO::FETCH_ASSOC))

                {

                  // echo "<pre>";print_r($row);echo "</pre>";





                    $index++;



                    if($row['tabl_status'] == '1')

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

                        $obj2 = new Contents();

                        $added_by_admin = $obj2->getUsenameOfAdmin($row['added_by_admin']);

                    }





                       $sql2_="SELECT `tablm_name` FROM `tbltabldropdownmodules` WHERE `tablm_id`=".$row['tablm_id']."";

                       $STH2_ = $DBH->prepare($sql2_);

                       $STH2_->execute();

                       $row2_ = $STH2_->fetch(PDO::FETCH_ASSOC);

                       $reference_name = stripslashes($row2_['tablm_name']);



// stripslashes($row['page_id'])

                    

                    $output .= '<tr class="manage-row">';

                    $output .= '<td height="30" align="center">'.$index.'</td>';

                    $output .= '<td height="30" align="center">'.stripslashes($reference_name).'</td>';


                    //chnage function by ample 04-11-19
                    // $output .= '<td height="30" align="center">'.$this->getpagename($row['page_id']).'</td>';
                     $output .= '<td height="30" align="center">'.$obj2->getPagenamebyPage_menu_id('27',$row['page_id'],$row['page_type']).'</td>';

                    $output .= '<td height="30" align="center">'.stripslashes($row['tabl_name']).'</td>';

                    $output .= '<td height="30" align="center">'.$status.'</td>';

                    $output .= '<td height="30" align="center">'.$row['tabl_add_date'].'</td>';

                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';



                    $output .= '<td align="center" nowrap="nowrap">';

                    if($edit) {

                    $output .= '<a href="index.php?mode=edit_table_dropdown&id='.$row['tabl_id'].'" ><img src = "images/edit.gif" border="0"></a>';

                    }

                    $output .= '</td>';

                    $output .= '<td align="center" nowrap="nowrap">';

                    if($delete) {

                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delTablDropdown.php?id='.$row['tabl_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

                    }

                    $output .= '</td>';

                    $output .= '</tr>';

                    

                }

            }



            else

            {

                $output = '<tr class="manage-row" height="30"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';

            }

        

            return $output;

    }





    public function getpagename($get_id)

    {

       $my_DBH = new mysqlConnection();

       $DBH = $my_DBH->raw_handle();

       $DBH->beginTransaction(); 



       if($get_id!=0 || $get_id!="")

       {

         $sql="SELECT `page_name` FROM `tblpages` WHERE `page_id`=".$get_id."";

         $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount()  > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                     $output=$row['page_name'];

                }

            }

       }

            return $output;





    }

    

    public function getTableDropdownModulesOptions($pdm_id)

         {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '';       



            $sql = "SELECT * FROM `tbltabldropdownmodules` WHERE `tablm_deleted` = '0' AND `tablm_status` = '1' ORDER BY `tablm_name` ASC";

            

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount()  > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    if($row['tablm_id'] == $pdm_id)

                    {

                        $sel = 'selected';

                    }

                    else

                    {

                        $sel = '';

                    }       

                    $option_str .= '<option value="'.$row['tablm_id'].'" '.$sel.'>'.stripslashes($row['tablm_name']).'</option>';

                }

            }

            return $option_str;

    }



    public function getTableNameOptions()

    {

        

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $output = '';      


            //update by ample 28-02-20 remove static DB name
            $sql = "SELECT table_name FROM information_schema.tables where table_schema='".$this->db."'";

            

            $STH = $DBH->prepare($sql);

             $STH->execute();

                     // exit;

            if($STH->rowCount()  > 0)

            {

              

               $output .= '<div style="clear:both;"></div>';

                $output .= '<div style="width:400px;height:350px;float:left;overflow:scroll;">';

                $output .= '    <ul style="list-style:none;padding:0px;margin:0px;">';

               

                

                         while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                        {

                            

                            $table_name = stripslashes($row['table_name']);

                            $output .= '<li style="padding:0px;width:300px;float:left;"><input type="checkbox" selected name="selected_table_name[]" id="selected_table_name" value="'.$table_name.'"  />&nbsp;<strong>'.$table_name.'</strong></li>';

                            $i++;

                        }



                         $output .= '</div>';

            }

            return $output;

    }





  public function getTableNameOptions_dropdown($get,$select_value)

    {

   

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $output = '';      


            //update by ample 
            $sql = "SELECT table_name FROM information_schema.tables where table_schema='".$this->db."'";

            

            $STH = $DBH->prepare($sql);

             $STH->execute();

                    

            if($STH->rowCount()  > 0)

            {

              

               $output.='<select  class="" id="tables_names'.$get.'" name="tables_names[]" style="width:150px;" onchange="Selectable('.$get.');">';

                       

               $output.='<option value="">-Select-</option>';

                         while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                        {

                            $table_name = stripslashes($row['table_name']);



                            if($select_value==$table_name)

                            {

                                $select="selected";

                            }

                            else

                            {

                                $select=""; 

                            }



                            $output.='<option value="'.$table_name.'"'.$select.'>'.$table_name.'</option>';

                          

                        }

                         $output .= '</select>';

            }

            return $output;

    }

//copy by ample 26-02-20
 public function getTableNameOptions_dropdown_new($get,$select_value)

    {

   

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $output = '';      


            //update by ample for remove static DB
            $sql = "SELECT table_name FROM information_schema.tables where table_schema='".$this->db."'";

            

            $STH = $DBH->prepare($sql);

             $STH->execute();

                    

            if($STH->rowCount()  > 0)

            {

              

               $output.='<select  class="" id="tables_names'.$get.'" name="tables_names[]" style="width:150px;" onchange="SelectableNew('.$get.');">';

                       

               $output.='<option value="">-Select-</option>';

                         while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                        {

                            $table_name = stripslashes($row['table_name']);



                            if($select_value==$table_name)

                            {

                                $select="selected";

                            }

                            else

                            {

                                $select=""; 

                            }



                            $output.='<option value="'.$table_name.'"'.$select.'>'.$table_name.'</option>';

                          

                        }

                         $output .= '</select>';

            }

            return $output;

    }




  

  public function chkTablDropdownModuleExists_EditKR($tablm_name)

        {

           



            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false;



            $sql = "SELECT * FROM `tbltabldropdownmodules` WHERE `tablm_name` = '".$tablm_name."'  AND `tablm_deleted` = '0' ";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

                {

                     $return = true;

                }

            return  $return;

        }   

  

  public function addTablDropdownModuleKR($tablm_name)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false;

            

           $sql = "INSERT INTO `tbltabldropdownmodules` (`tablm_name`) " . "VALUES ('".addslashes($tablm_name)."')";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            $DBH->commit();

            if($STH->rowCount() > 0)

                {

                     $return = true;

                }

            return $return;

    } 



 public function addMessageNameKR($mes_name)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false;

            

           $sql = "INSERT INTO `tblmessage` (`mess_name`) " . "VALUES ('".addslashes($mes_name)."')";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            $DBH->commit();

            if($STH->rowCount() > 0)

                {

                     $return = true;

                }

            return $return;

    } 



     public function chkMessageNameExists_EditKR($mess_name)

        {

           



            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false;



            $sql = "SELECT * FROM `tblmessage` WHERE `mess_name` = '".$mess_name."'  AND `mess_deleted` = '0' ";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

                {

                     $return = true;

                }

            return  $return;

        }

   public function getMessageActionsOptions($mess_action_id)

    {

         $my_DBH = new mysqlConnection();

         $DBH = $my_DBH->raw_handle();   

         $DBH->beginTransaction();

        $option_str = '';       

        

        $sql = "SELECT * FROM `tblmessage` WHERE `mess_deleted` = '0' AND `mess_status` = '1' ORDER BY `mess_id` ASC";

        //echo $sql;

        $STH = $DBH->prepare($sql);

                $STH->execute();

        if($STH->rowCount() > 0)

        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['mess_id'] == $mess_action_id)

                {

                    $sel = ' selected ';

                }

                else

                {

                    $sel = '';

                }       

                $option_str .= '<option value="'.$row['mess_id'].'" '.$sel.'>'.stripslashes($row['mess_name']).'</option>';

            }

        }

        return $option_str;

    }  



    //update function and query add key page_type by ample 04-11-19

    public function addTablDropdownKR($admin_comment,$tablm_id,$table_name_str,$page_id,$admin_id,$page_type)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false;

            $updated_on_date = date('Y-m-d H:i:s');

            

            $sql = "INSERT INTO `tbltabldropdown` (`admin_comment`,`tablm_id`,`tabl_name`,`tabl_status`,`updated_on_date`,`page_id`,page_type,`added_by_admin`,`tabl_delete`,`updated_by_admin`)"

                ."VALUES ('".addslashes($admin_comment)."','".addslashes($tablm_id)."','".addslashes($table_name_str)."','1','".$updated_on_date."','".$page_id."','".$page_type."','".$admin_id."',0,0)";

                $STH = $DBH->prepare($sql);

                $STH->execute();

                $DBH->commit();

            if($STH->rowCount() > 0)

                {

                     $return = true;

                }

            return $return;

    }

    

    public function getTablDropdownDetailsKR($tabl_id)

     {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $tablm_id = '';

            // $page_id_str = '';

            $tabl_status = '';

            

            $sql = "SELECT * FROM `tbltabldropdown` WHERE `tabl_id` = '".$tabl_id."' AND `tabl_delete` = '0' ";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $tablm_id = stripslashes($row['tablm_id']);

                $tabl_name = stripslashes($row['tabl_name']);

                $tabl_status = stripslashes($row['tabl_status']);

                // $menu_id = stripslashes($row['menu_id']);

                $admin_comment = $row['admin_comment'];

                $page_id = $row['page_id'];
                // add this by ample 04-11-19
                $page_type = $row['page_type'];

            }
            // update this by ample 04-11-19
            return array('admin_comment'=>$admin_comment,'tabl_name'=>$tabl_name,'tablm_id'=>$tablm_id,'tabl_status'=>$tabl_status,'page_id'=>$page_id,'page_type'=>$page_type);

    } 

    

    public function getTablFunctionNameById($fun_id)

            {

                // echo "<pre>";print_r($fun_id);echo "<pre>";

                // exit;

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tbltabldropdownmodules` WHERE `tablm_id` ='".$fun_id."' ";

                $STH = $DBH->prepare($sql);

                $STH->execute();

                if($STH->rowCount()  > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = $row['tablm_name'];

                }

                //print_r($meal_item) ;

                return $meal_item;

                

            }  



            

 public function getTableNameOptionsCheckedEdit($multitable)

    {

            //$this->connectDB();

        $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

            $output = '';      


            //update 28-02-20 ample
            $sql = "SELECT table_name FROM information_schema.tables where table_schema='".$this->db."'";

            //echo $sql;

            // $this->execute_query($sql);

            $STH = $DBH->prepare($sql);

             $STH->execute();

                     // exit;

            if($STH->rowCount()  > 0)

            {

        

               $output .= '<div style="clear:both;"></div>';

                $output .= '<div style="width:400px;height:350px;float:left;overflow:scroll;">';

                $output .= '    <ul style="list-style:none;padding:0px;margin:0px;">';

               

             

                        $getarray=explode(',',$multitable);

                         while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                        {

                            $table_name = stripslashes($row['table_name']);



                              if(in_array($table_name,$getarray))

                                {

                                    $selected = ' checked ';

                                }

                                else

                                {

                                    $selected = '';

                                }



                            $output .= '<li style="padding:0px;width:300px;float:left;"><input type="checkbox" name="selected_table_name[]" id="selected_table_name" value="'.$table_name.'" '.$selected.' />&nbsp;<strong>'.$table_name.'</strong></li>';

                            $i++;

                        }



                         $output .= '</div>';

            }

            return $output;

    }



    public function updateTablDropdownKR($admin_comment,$tabl_id,$tablm_id,$page_id_str,$ftablm_name,$tabl_status,$page_id)

    {

          



                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

                $updated_on_date = date('Y-m-d H:i:s');

            

            $sql = "UPDATE `tbltabldropdown` SET "

                    . "`admin_comment` = '".addslashes($admin_comment)."' ,"

                    . "`tablm_id` = '".addslashes($tablm_id)."' ,"

                    . "`tabl_name` = '".addslashes($page_id_str)."' ,"

                    . "`tabl_status` = '".addslashes($tabl_status)."' ,"

                    . "`updated_on_date` = '".addslashes($updated_on_date)."' ,"

                    . "`page_id` = '".addslashes($page_id)."' "

                    . "WHERE `tabl_id` = '".$tabl_id."' ";

        //echo $sql;



            



            $STH = $DBH->prepare($sql);

            $STH->execute();

            $DBH->commit();

        if($STH->rowCount() > 0)

        {

            $return = true;

        }

        return $return;

    } 



public function deleteTablDropdown($tabl_id)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return=false;

            $updated_on_date = date('Y-m-d H:i:s');

            $sql = "UPDATE `tbltabldropdown` SET "

                    . "`tabl_delete` = '1' , `updated_on_date` = '".$updated_on_date."'"

                    . "WHERE `tabl_id` = '".$tabl_id."'";

        //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            $DBH->commit();

            if($STH->rowCount()  > 0)

        {

                    $return = true;

        }

            return $return;

    } 

    

     public function getAllRecordDropdowns($search,$status)

     {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();



            $admin_id = $_SESSION['admin_id'];

            // $edit_action_id = '315';
            // $delete_action_id = '316';
            //update by ample 13-12-19
            $edit_action_id = '356';
            $delete_action_id = '357';

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



             $sql = "SELECT * FROM `tbl_recordshow_dropdown` WHERE is_deleted = '0' $sql_str_search $sql_str_status  ORDER BY page_cat_id DESC";

           

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

                    // echo "<pre>";print_r($row);echo "</pre>";



                       $sql2_="SELECT `tablm_name` FROM `tbltabldropdownmodules` WHERE `tablm_id`=".$row['reference_name']."";

                       $STH2_ = $DBH->prepare($sql2_);

                       $STH2_->execute();

                       $row2_ = $STH2_->fetch(PDO::FETCH_ASSOC);



                       $prct_id = $this->getSolItemIdkr($row['prct_id']);

                    

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

                   

                    

                    

                                            

                    $output .= '<tr class="manage-row" >';

                    $output .= '<td height="30" align="center">'.$i.'</td>';

                    $output .= '<td height="30" align="center">'.$status.'</td>';

                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';

                    $output .= '<td height="30" align="center">'.$row['updated_on_date'].'</td>';

                    $output .= '<td align="center" nowrap="nowrap">';

                    if($edit) {

                    $output .= '<a href="index.php?mode=edit_report_customisation&id='.$row['page_cat_id'].'" ><img src = "images/edit.gif" border="0"></a>';

                    }

                    $output .= '</td>';

                    $output .= '<td align="center" nowrap="nowrap">';

                    if($delete) {

                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delrecordsdropdown.php?id='.$row['page_cat_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

                    }

                    $output .='</td>';







                    // $output .='<td height="30" align="center">aaas</td>';

                    // $output .='<td height="30" align="center">ffds</td>';



                $output .= '<td height="30" align="center" nowrap="nowrap">';

                if($prct_id==0)

                    {

                        // edit_profile_customization

                       $output .= '<a href="index.php?mode=add_profile_customization&customization_id='.$row['page_cat_id'].'&name=report_customisation" ><img src = "images/sidebox_icon_pages.gif" border="0"></a>';

                       // wellness_solution_items

                       $output .= '<td height="30" align="center">';

                       $output .= '</td>';

                    }

                    else

                    {

                     $output .= '<td height="30" align="center">';

                     $output .= '<a href="index.php?mode=edit_profile_customization&id='.$prct_id.'&name=report_customisation" ><img src = "images/sidebox_icon_pages.gif" border="0"></a>';

                     $output .= '</td>';

                       

                    }

// edit_profile_customization







                    $output .='<td height="30" align="center">'.$row2_['tablm_name'].'</td>';

                    $output .='<td height="30" align="center">'.$row['table_name'].'</td>';

                    $output .='<td height="30" align="center">'.$row['report_name'].'</td>';

   

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







  public function getSolItemIdkr($sol_item_id)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

           $DBH->beginTransaction();



            $fav_cat_type = '';



            //$sql = "SELECT * FROM `tblfavcategorytypegetFavCatDropdownValueVivek` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

            $sql = "SELECT * FROM `tbl_recordshow_dropdown` WHERE `prct_id` = '".$sol_item_id."' ";

            $STH = $DBH->prepare($sql);

            $STH->execute();

           if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $fav_cat_type = stripslashes($row['prct_id']);

            }

            return $fav_cat_type;

    }







 // public function getTablColumsKR($tablm_name)

 //  {

 //    $my_DBH = new mysqlConnection();

 //    $DBH = $my_DBH->raw_handle();

 //    $DBH->beginTransaction();

 //    $option_str = ''; 



 //    $sql="SELECT column_name FROM information_schema.columns WHERE table_name='".$tablm_name."'"; 

   

 //            $STH = $DBH->prepare($sql);

 //            $STH->execute();

 //            if($STH->rowCount() > 0)

 //            {

 //                $html='';

 //                $index=0;



 //                $html.='<tr>

 //                        <td><strong>ColumsName</strong></td>

 //                        <td><strong>Checkbox</strong></td>

 //                        <td><strong>Report Label</strong></td>

 //                        <td><strong>R/C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

 //                        <td><strong>Query field&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

 //                        <td><strong>Query Order&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

 //                        <td><strong>Query Combo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

 //                        <td><strong>Report field&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

 //                        <td><strong>Report Order&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

 //                      </tr>';



 //                while($row = $STH->fetch(PDO::FETCH_ASSOC))

 //                {

                    

 //                    $index++;

 //                    $html.=' <tr>

 //                                 <td width="15%" align="left">'.$row['column_name'].'



 //                                 </td>

 //                                  <td width="10%" align="left" valign="top">

 //                                      <input type="hidden" name="checkvalue[]" id="checkvalue'.$index.'">

 //                                  <input class="chkbxapaid" type="checkbox" name="check_[]" id="check_'.$index.'" value="'.$row['column_name'].'" onclick="return selectcheck('.$index.',\''.$row['column_name'].'\');"></td>



 //                                    <td width="20%" align="left" valign="top">

 //                                        <input type="text" name="report_header[]" id="report_header'.$index.'">

 //                                    </td>

 //                                     <td align="left" valign="top">

 //                                        <select class="selapaid" name="row_col[]" id="row_col'.$index.'" style="width:60px;">

 //                                              <option value="Rows">Rows</option>

 //                                              <option value="Colums">Colums</option>

 //                                        </select>

 //                                    </td>



 //                                     <td width="10%" valign="top">

 //                                        <select class="selapaid" name="query_field_Y_N[]" id="query_field_Y_N'.$index.'" style="width:40px;">

 //                                              <option value="Yes">Yes</option>

 //                                              <option value="No">No</option>

 //                                        </select>

 //                                    </td>



 //                                     <td width="1%" valign="top">

 //                                        <select class="selapaid" name="query_order[]" id="query_order'.$index.'" style="width:40px;">';

 //                                             for($i=1;$i<11;$i++)

 //                                               {

 //                                               $html.='<option value="'.$i.'">'.$i.'</option>'; 

 //                                                }

 //                                            $html .='</select>

 //                                    </td>



 //                                     <td width="9%" valign="top">

 //                                        <select class="selapaid" name="query_combo[]" id="query_combo'.$index.'" style="width:60px;">';

 //                                             for($i=1;$i<6;$i++)

 //                                               {

 //                                               $html.='<option value="QC'.$i.'">QC'.$i.'</option>'; 

 //                                                }

 //                                            $html .='</select>

 //                                    </td>



 //                                    <td width="9%" valign="top">

 //                                        <select class="selapaid" name="report_field_Y_N[]" id="report_field_Y_N'.$index.'" style="width:40px;">

 //                                              <option value="Yes">Yes</option>

 //                                              <option value="No">No</option>

 //                                        </select>

 //                                    </td>



 //                                     <td align="left" valign="top">

 //                                        <select class="selapaid" name="report_order[]" id="report_order'.$index.'" style="width:40px;">';

 //                                            for($i=1;$i<16;$i++)

 //                                            {

 //                                             $html.='<option value="'.$i.'">'.$i.'</option>'; 

 //                                            }

 //                                        $html .='</select>

 //                                    </td>

 //                                </tr>';

 //                   // echo "<pre>";print_r($row['column_name']);echo "</pre>";  

 //                }

 //            }

 //            else

 //            {

 //              $html=0;  

 //            }

    

 //      return $html;

 //  }













     public function table_colums($tablm_name)

     {



            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            // $option_str = ''; 

            $colues=array();

            //update by ample 26-02-20 for repeat columns
            $sql="SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$this->db."' AND TABLE_NAME ='".$tablm_name."'"; 

           

                    $STH = $DBH->prepare($sql);

                    $STH->execute();

                    if($STH->rowCount() > 0)

                    {

                        // $html='';

                        //  $index=0;


                            while($row = $STH->fetch(PDO::FETCH_ASSOC))

                             {


                              $colues[]=$row;

                             }

                    }

                    return $colues;



     }















     public function getDataRecordsDropdownDetails($page_cat_id)

    {

            $obj2 = new Contents();

            $my_DBH = new mysqlConnection();

             $DBH = $my_DBH->raw_handle();

             $DBH->beginTransaction();

            $pdm_id = '';

            $page_id_str = '';

            $pd_status = '';

            

           

          $sql = "SELECT * FROM `tbl_recordshow_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' AND `is_deleted` = '0' ";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount()  > 0)

             {

                 $row = $STH->fetch(PDO::FETCH_ASSOC);



                  $sql1="SELECT * FROM `tblcolumndetails` WHERE `uniqu_m_id`='".$row['uniqu_id']."'";

                  $STH = $DBH->prepare($sql1);

                    $STH->execute();

                    if($STH->rowCount()  > 0)

                    {

                       while($row1 = $STH->fetch(PDO::FETCH_ASSOC))

                       {

                         $details_arr[]=$row1;

                       }

                    }



                    foreach($details_arr as $detail_cal)

                    {

                        $edit_col_name[]=$detail_cal['col_name'];

                    }



// exit;

          // echo "<pre>";print_r($details_arr);echo "</pre>"; 

                



                   $sql2_="SELECT `tablm_name` FROM `tbltabldropdownmodules` WHERE `tablm_id`=".$row['reference_name']."";

                   $STH2_ = $DBH->prepare($sql2_);

                   $STH2_->execute();

                   $row2_ = $STH2_->fetch(PDO::FETCH_ASSOC);



                   $reference_name = stripslashes($row2_['tablm_name']);

                   $table_name = stripslashes($row['table_name']);



                    $collect_arr=array();



                    foreach($this->table_colums($table_name) as $colum_name)

                     {

                        $col_val[]=$colum_name['column_name'];

                        if(in_array($colum_name['column_name'],$edit_col_name))

                        {



                             foreach($details_arr as $get_col_detail)

                             {

                                if($colum_name['column_name']==$get_col_detail['col_name'])

                                {

                                   array_push($collect_arr,$get_col_detail);  

                                }

                             }

 

                        }

                      else

                        {



                            $makearr=array('col_id'=>'','col_name'=>$colum_name['column_name'],'uniqu_m_id'=>'','col_report_label'=>'','col_row_col'=>'','col_query_field'=>'','col_query_order'=>'','col_query_combo'=>'','col_report_feild'=>'','col_report_order'=>'');



                            array_push($collect_arr,$makearr); 

                        }

                     }



                    



                       // foreach()

             

                       // $collect_arr=array();

                       //   foreach($details_arr as $colums_arr)

                       //   {

                       //      if(in_array($colums_arr['col_name'],$col_val))

                       //      {

                       //        array_push($collect_arr,$colums_arr);

                       //      }

                       //      else

                       //      {

                       //          array_push($collect_arr,array()); 

                       //      }

                        

                       //   }



 

                    // echo "<pre>";print_r($collect_arr);echo "</pre>"; 

                        



                    // echo "<pre>";print_r($col_val);echo "</pre>";



                  

                 



                  // $arr=array();

                  // $sql1="SELECT * FROM `tblcolumndetails` WHERE `uniqu_m_id`='".$row['uniqu_id']."'";

                  // $STH = $DBH->prepare($sql1);

                  //   $STH->execute();

                  //   if($STH->rowCount()  > 0)

                  //   {

                  //      while($row1 = $STH->fetch(PDO::FETCH_ASSOC))

                  //      {



                  //       echo $row1['col_name'];

                        

                  //       if(in_array($row1['col_name'], $col_val))

                  //       {

                  //           array_push($arr, $row1);

                  //       }

                  //       else

                  //       {

                  //          array_push($arr, array(1,3,2)) ;

                  //       }



                  //      }





                  //     echo "<pre>";print_r($arr);echo "</pre>";

                  //   }







                // exit;



    // $reference_name = stripslashes($row['reference_name']);



                     // echo "<pre>";print_r($row['wa_main_cat']);echo "</pre>";

             $report_name = stripslashes($row['report_name']);



                

                $healcareandwellbeing = $obj2->getFavCategoryNameVivek($row['healcareandwellbeing']);

                $page_name = stripslashes($row['page_name']);

                $ref_code = stripslashes($row['ref_code']);

                $prof_cat1 = stripslashes($row['prof_cat1']);

               

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

                $canv_sub_cat1_show_fetch = $row['canv_sub_cat1_show_fetch'];

                //add by ample 26-02-20
                $canv_sub_cat1_ref_code= $row['canv_sub_cat1_ref_code'];
                $cat1_uid=$row['cat1_uid'];  //add by ample 26-02-20

                $enduse= $row['enduse'];

                $wa_main_cat= $row['wa_main_cat'];

                $wa_sub_cat= $row['wa_sub_cat'];


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

                $is_action=$row['is_action']; //add by ample 04-05-20
                

            }
            //update by ample 26-02-20 & 04-05-20
            return array($admin_comment,$arr_heading,$healcareandwellbeing,$page_name,$ref_code,$prof_cat1,$pag_cat_status,$heading,$time_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$order_show,$duration_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$canv_sub_cat1_link,$canv_sub_cat1_show_fetch,$page_type,$reference_name,$table_name,$report_name,$collect_arr,$enduse,$wa_main_cat,$wa_sub_cat,$canv_sub_cat1_ref_code,$cat1_uid,$is_action);

    }  










    //update by ample 26-02-20 & update  04-05-20
    public function updateRecordsCatDropdown($admin_comment,$arr_heading,$pag_cat_status,$admin_id,$ref_code,$page_name,$sub_cat1,$prof_cat1,$id,$time_show,$duration_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$heading,$order_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$cat_fetch_show_data,$canv_sub_cat_link,$canv_sub_cat_ref_code,$data_source,$report_name,$arr,$checkvalue,$is_action)

    {



      // $array=array($admin_comment,$arr_heading,$pag_cat_status,$admin_id,$ref_code,$page_name,$sub_cat1,$prof_cat1,$id,$time_show,$duration_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$heading,$order_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$cat_fetch_show_data,$canv_sub_cat_link,$data_source);



   



            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $updated_on_date = date('Y-m-d H:i:s');



        

         foreach($checkvalue as $key=>$cols_name)

        {

           if($cols_name!="")

           {

            $get_key[]=$key;

           } 

        }



 

           foreach($get_key as $find_key_value)

           {

             $first_[] = array_column($arr,$find_key_value);

           }

      

         // for($i=0;$i<count($arr[2]);$i++)

         //   {



         //    $first_[] = array_column($arr,$i);

         //   }



            

            foreach($first_ as $getselected)

            {

                if($getselected[2]!='')

                {

                    $getselected_data[]=$getselected;

                }

            }



       // echo "<pre>";print_r($getselected_data);echo"</pre>";

          // exit;



      $getuniqu_id='ID'.time().date();

      

        foreach($getselected_data  as $upvalue)

        {



             // echo "<pre>";print_r($upvalue);echo"</pre>";

          

          if($upvalue[0]!='' && $upvalue[1]!='')

          {

              $update_qt="UPDATE `tblcolumndetails` SET 

               `uniqu_m_id`='".$getuniqu_id."',

               `col_report_label`='".$upvalue[3]."',

               `col_row_col`='".$upvalue[4]."',

               `col_query_field`='".$upvalue[5]."',

               `col_query_order`='".$upvalue[6]."',

               `col_query_combo`='".$upvalue[7]."',

               `col_report_feild`='".$upvalue[8]."',

               `col_report_order`='".$upvalue[9]."',

               `Id_table`='".$upvalue[10]."',

               `fetch_columns`='".$upvalue[11]."',

               `fetch_value`='".$upvalue[12]."' WHERE `col_id`='".$upvalue[1]."' AND `uniqu_m_id`='".$upvalue[0]."'";



                $STH = $DBH->prepare($update_qt);

                $STH->execute();

            

          }

          else

          {



             

              // $select_uni="SELECT * FROM `tbl_recordshow_dropdown` WHERE `page_cat_id`=".$id."";

              // $STH = $DBH->prepare($select_uni);

              // $STH->execute();

              //  if($STH->rowCount() > 0)

              //   {

              //     $row = $STH->fetch(PDO::FETCH_ASSOC);

              //   }

            



               $inser="INSERT INTO `tblcolumndetails`(`col_name`,`uniqu_m_id`,`col_report_label`,`col_row_col`,`col_query_field`,`col_query_order`,`col_query_combo`,`col_report_feild`,`col_report_order`,`Id_table`,`fetch_columns`,`fetch_value`) VALUES('".$upvalue[2]."','".$getuniqu_id."','".$upvalue[3]."','".$upvalue[4]."','".$upvalue[5]."','".$upvalue[6]."','".$upvalue[7]."','".$upvalue[8]."','".$upvalue[9]."','".$upvalue[10]."','".$upvalue[11]."','".$upvalue[12]."')";



               $STH = $DBH->prepare($inser);

                $STH->execute();

          }







         

        }

// exit;

            

            $sql = "UPDATE `tbl_recordshow_dropdown` SET "

                     . "`uniqu_id`='".$getuniqu_id."',"

                    . "`admin_comment` = '".addslashes($admin_comment)."' ,"

                    . "`ref_code` = '".addslashes($ref_code)."' ,"

                    . "`page_name` = '".addslashes($page_name)."' ,"

                    . "`prof_cat1` = '".addslashes($prof_cat1)."' ,"

                    . "`report_name` = '".addslashes($report_name)."' ,"

                    . "`sub_cat1` = '".addslashes($sub_cat1)."' ,"


                    . "`heading` = '".addslashes($heading)."' ,"

                    . "`order_show` = '".addslashes($order_show)."' ,"


                    ."`pag_cat_status` = '".addslashes($pag_cat_status)."' ,"

                    ."`data_source` = '".addslashes($data_source)."' ,"

                    ."`canv_sub_cat1_show_fetch` = '".addslashes($cat_fetch_show_data['canv_sub_cat1_show_fetch'])."' ,"

                    . "`canv_sub_cat1_link` = '".addslashes($canv_sub_cat_link['canv_sub_cat1_link'])."' ,"

                    . "`canv_sub_cat1_ref_code` = '".addslashes($canv_sub_cat_ref_code['canv_sub_cat1_ref_code'])."' ,"

                    . "`is_action` = '".addslashes($is_action)."' ,"

                    . "`updated_on_date` = '".addslashes($updated_on_date)."' "

                    . "WHERE `page_cat_id` = '".$id."' ";

        //echo $sql;

           

            $STH = $DBH->prepare($sql);



             $STH->execute();

             $DBH->commit();

        if($STH->rowCount()  > 0)

        {

            $return = true;

        }

        return $return;

    } 



  



   public function deleteRecordsDropdown($page_cat_id)

    {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

            $updated_on_date = date('Y-m-d H:i:s');

             $sql = "UPDATE `tbl_recordshow_dropdown` SET "

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

  

    public function getTableNamedropdown()

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            // $option_str = '';       

            

            $sql = "SELECT * FROM `tbltabldropdownmodules` WHERE `tablm_status` ='1' ";



            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

              while($row = $STH->fetch(PDO::FETCH_ASSOC))

              {

                $option_str .= '<option value="'.$row['tablm_id'].'">'.$row['tablm_name'].'</option>';

              }

               

            }

            return $option_str;

    } 



//28/02/2019  krishna



    public function getTabldropdownKR($tablm_id)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '';       

            // $sel = '';

            $sql = "SELECT * FROM `tbltabldropdown` WHERE `tablm_id` ='".$tablm_id."'AND`tabl_delete`=0";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {



               while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                   $get_array=explode(',', $row['tabl_name']); 

                   $option_str='<option>Select Data Source</option>'; 

                   foreach($get_array as $value)

                   {

                   $option_str .= '<option value="'.$value.'">'.$value.'</option>';

                   }



                }

             }

             else

             {

                $option_str=0;

             }

               return $option_str;

     }



  

  public function getTablColumsKR($tablm_name)

  {

    $my_DBH = new mysqlConnection();

    $DBH = $my_DBH->raw_handle();

    $DBH->beginTransaction();

    $option_str = ''; 


            //update by ample 28-02-20
           $sql="SELECT column_name FROM information_schema.columns WHERE table_schema = '".$this->db."' AND table_name='".$tablm_name."'"; 

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $html='';

                $index=0;



                $html.='<tr>

                        <td><strong>ColumsName</strong></td>

                        <td><strong>Checkbox</strong></td>

                        <td><strong>Report-field Label</strong></td>

                        <td><strong>Query field&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                        <td><strong>Query Order&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                        <td><strong>Query Combo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                         <td><strong>R/C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                        <td><strong>Report field&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                        <td><strong>Report Order&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                        <td><strong>ID-Tables&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                        <td><strong>Fetch ID-field&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                        <td><strong>Fetch ID-Value&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                      </tr>';

            

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                     $index++;

                        $output = '';      
                        //update by ample
                        $sql1 = "SELECT table_name FROM information_schema.tables where table_schema='".$this->db."'";

                        $STH1 = $DBH->prepare($sql1);

                         $STH1->execute();

                        if($STH1->rowCount()  > 0)

                        {

                           $output.='<select  class="" id="tables_names'.$index.'" style="width:150px;" name="tables_names[]" onchange="Selectable('.$index.');">';

                             $output.='<option value="">-Select-</option>';

                                     while($row1 = $STH1->fetch(PDO::FETCH_ASSOC)) 

                                    {

                                        $table_name = stripslashes($row1['table_name']);

                                        $output.='<option value='.$table_name.'>'.$table_name.'</option>';

                                        

                                    }

                                     $output .= '</select>';

                        }



                    $html.=' <tr>

                                 <td width="15%" align="left">'.$row['column_name'].'



                                 </td>

                                  <td width="10%" align="left" valign="top">';

                                   

                                     $html.='<input type="hidden" name="checkvalue[]" id="checkvalue'.$index.'">



                                  <input class="chkbxapaid" type="checkbox" name="check_[]" id="check_'.$index.'" value="'.$row['column_name'].'" onclick="return selectcheck('.$index.',\''.$row['column_name'].'\');"></td>



                                    <td width="20%" align="left" valign="top">

                                        <input type="text" name="report_header[]" id="report_header'.$index.'" onkeyup="return oninput_reportname('.$index.');">

                                    </td>

                                    



                                     <td width="10%" valign="top">

                                        <select class="selapaid" name="query_field_Y_N[]" id="query_field_Y_N'.$index.'" style="width:60px;" onchange="return get_query_field('.$index.');">

                                             <option value="">-Select-</option>

                                              <option value="Yes">Yes</option>

                                              <option value="No">No</option>

                                        </select>

                                    </td>



                                     <td width="1%" valign="top">

                                        <select class="selapaid" name="query_order[]" id="query_order'.$index.'" style="width:60px;" onchange="return get_query_order('.$index.');">';

                                        $html.='<option value="0">-Select-</option>';

                                             for($i=1;$i<11;$i++)

                                               {

                                                  $html.='<option value="'.$i.'">'.$i.'</option>'; 

                                                }

                                                  $html .='</select>

                                    </td>



                                     <td width="9%" valign="top">



                                        <select class="selapaid" name="query_combo[]" id="query_combo'.$index.'" style="width:60px;" onchange="return get_query_combo('.$index.');">';

                                         $html.='<option value="">-Select-</option>';

                                             for($i=1;$i<6;$i++)

                                               {

                                               $html.='<option value="QC'.$i.'">QC'.$i.'</option>'; 

                                                }

                                                $html.='<option value="query_date">query date</option>';

                                                $html.='<option value="status">status</option>';
                                                $html.='<option value="deleted">deleted</option>'; 

                                            $html .='</select>

                                    </td>



                                     <td align="left" valign="top">



                                        <select class="selapaid" name="row_col[]" id="row_col'.$index.'" style="width:60px;" onchange="return row_colums('.$index.');">

                                              <option value="">-Select-</option>

                                              <option value="Rows">Rows</option>

                                              <option value="Colums">Colums</option>

                                               <!-- add by ample 24-03-20-->
                                              <option value="MH">Main Header (MH)</option>
                                              <option value="TK">Table Key (TK)</option>

                                        </select>

                                    </td>



                                    <td width="9%" valign="top">

                                        <select class="selapaid" name="report_field_Y_N[]" id="report_field_Y_N'.$index.'" style="width:60px;" onchange="return get_report_field('.$index.');">

                                               <option value="">-Select-</option>

                                              <option value="Yes">Yes</option>

                                              <option value="No">No</option>

                                        </select>

                                    </td>



                                     <td align="left" valign="top">

                                        <select class="selapaid" name="report_order[]" id="report_order'.$index.'" style="width:60px;" onchange="return get_report_order('.$index.');">

                                        ';

                                           $html.='<option value="">-Select-</option>';

                                            for($i=1;$i<16;$i++)

                                            {

                                             $html.='<option value="'.$i.'">'.$i.'</option>'; 

                                            }

                                        $html .='</select>';



                                         

                                    $html .='</td>

                                     <td align="left" valign="top">';

                                     $html.=$output;

                                     $html.='</td>';

                                   

                                     

                                     $html .='<td align="left" valign="top">';

                                    $html .='<select id="columns_dropdown'.$index.'" style="width:100px;" name="columns_dropdown[]">';

                                    $html.='<option value="">-Select-</option>

                                    </select>';

                                     $html.='</td>';



                                    $html .='<td align="left" valign="top">';

                                    $html .='<select id="columns_dropdown_value'.$index.'" style="width:100px;" name="columns_dropdown_value[]">';

                                    $html.='<option value="">-Select-</option>

                                    </select>';

                                     $html.='</td>







                                     </tr>';

 

                }

            }

            else

            {

              $html=0;  

            }

    

      return $html;

  }





public function getcolumsNameOftable($tablm_name)

{

         $my_DBH = new mysqlConnection();

         $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $colums=array();
        //update by ample 28-02-20
        $sql="SELECT column_name FROM information_schema.columns WHERE table_schema = '".$this->db."' AND table_name='".$tablm_name."'"; 

   

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

               while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                   $colums[]=$row['column_name'];

                }

            }

            return $colums;



}



 public function getTableNameOptions_dropdown_kr2($get,$select_value)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $output = '';      


            //update by ample 28-02-20
            $sql = "SELECT table_name FROM information_schema.tables where table_schema='".$this->db."'";

            

            $STH = $DBH->prepare($sql);

             $STH->execute();

                    

            if($STH->rowCount()  > 0)

            {

              

               // $output.='<select  class="" id="tables_names2_'.$get.'" name="tables_names2" style="width:150px;" onchange="Selectable2_('.$get.');">';

                       

               $output.='<option value="">-Select-</option>';

                         while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                        {

                            $table_name = stripslashes($row['table_name']);



                            if($select_value==$table_name)

                            {

                                $select="selected";

                            }

                            else

                            {

                                $select=""; 

                            }



                            $output.='<option value="'.$table_name.'"'.$select.'>'.$table_name.'</option>';

                          

                        }

                         // $output .= '</select>';

            }

            return $output;

    } 









    //update by ample 04-05-20

    public function addRecordsDropdown($ref_code,$admin_comment,$fav_cat_type_id_0,$healcareandwellbeing,$page_type,$page_name,$heading,$table_dropdown_ref,$data_source,$report_name,$prof_cat1,$arr_selected_cat_id1,$cat_fetch_show_data,$canv_sub_cat_link,$order_show,$admin_id,$arr,$checkvalue,$show_value,$va_cat_id,$va_sub_cat_id,$is_action)

        {



               foreach($checkvalue as $key=>$cols_name)

                {

                   if($cols_name!="")

                   {

                    $get_key[]=$key;

                   } 

                }

                   // echo "<pre>";print_r($get_key);echo"</pre>";

                   // echo "<pre>";print_r($arr);echo"</pre>";

                   foreach($get_key as $find_key_value)

                   {

                     $first_[] = array_column($arr,$find_key_value);

                   }



                   // echo "<pre>";print_r($first_);echo "</pre>";

                // exit;

               // for($i=0;$i<count($arr[0]);$i++)

               // {

               //  $first_[] = array_column($arr,$i);

               // }

                

                foreach($first_ as $getselected)

                {

                    if($getselected[0]!='')

                    {

                        $getselected_data[]=$getselected;

                    }

                }







            $get_sub_cat1=implode(',',$arr_selected_cat_id1);

          

       //     $arr=array('ref_code'=>$ref_code,

       //      'admin_comment'=>$admin_comment,

       //      'fav_cat_type_id_0'=>$fav_cat_type_id_0,

       //      'healcareandwellbeing'=>$healcareandwellbeing,

       //      'page_type'=>$page_type,

       //      'page_name'=>$page_name,

       //      'heading'=>$heading,

       //      'table_dropdown_ref'=>$table_dropdown_ref,

       //      'data_source'=>$data_source,

       //      'report_name'=>$report_name,

       //      'prof_cat1'=>$prof_cat1,

       //      'sub_cat1'=>$get_sub_cat1,

       //      'cat_fetch_show_data'=>$cat_fetch_show_data,

       //      'canv_sub_cat_link'=>$canv_sub_cat_link,

       //      'order_show'=>$order_show,

       //      'admin_id'=>$admin_id

       // );

       //     echo "<pre>";print_r($arr);echo "</pre>";



            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false;

            $updated_on_date = date('Y-m-d H:i:s');

            $canv_sub_cat1_show_fetch = ($cat_fetch_show_data['canv_sub_cat1_show_fetch'] ==''? 0 : $cat_fetch_show_data['canv_sub_cat1_show_fetch']);



            $getuniqu_id='ID'.time().date();



              $healcareandwe=implode(',',$healcareandwellbeing);



              $tab_colums=$this->getcolumsNameOftable($data_source);

             if(in_array('user_id',$tab_colums))

             {

                $user_id_get='user_id';

             }

             else

             {

                $user_id_get='';

             }



            



            // for($i=0;$i<count($healcareandwellbeing);$i++)

            // {  



                   $sql = "INSERT INTO `tbl_recordshow_dropdown` (`uniqu_id`,`reference_name`,`table_name`,`username_id`,`report_name`,`admin_comment`,`system_cat`,`healcareandwellbeing`,`page_name`,`ref_code`,`sub_cat1`,`prof_cat1`,`pag_cat_status`,`added_by_admin`,`updated_on_date`,`heading`,`order_show`,`canv_sub_cat1_show_fetch`,`canv_sub_cat1_link`,`data_source`,`page_type`,`enduse`,`wa_main_cat`,`wa_sub_cat`,is_action) "

                . "VALUES (

                 '".$getuniqu_id."',

                 '".$table_dropdown_ref."',

                 '".$data_source."',

                 '".$user_id_get."',

                 '".$report_name."',

                 '".addslashes($admin_comment)."',

                 '".addslashes($fav_cat_type_id_0)."',

                 '".addslashes($healcareandwe)."', 

                 '".addslashes($page_name)."',

                 '".addslashes($ref_code)."',

                 '".addslashes($get_sub_cat1)."',

                 '".addslashes($prof_cat1)."',

                 '1',

                '".$admin_id."',

                '".$updated_on_date."',

                '".$heading."',

                '".$order_show."',

                '".$canv_sub_cat1_show_fetch."',

                '".$canv_sub_cat_link['canv_sub_cat1_link']."',

                '".$data_source."',

                '".$page_type."',

                '".$show_value."',

                '".$va_cat_id."',

                '".$va_sub_cat_id."',

                '".$is_action."')";  //add by ample

                $STH = $DBH->prepare($sql);

                $STH->execute();

             // $DBH->commit();





           





               foreach($getselected_data as $value_table)

               {

                  echo "<pre>";print_r($value_table);echo "</pre>";







                  $sql2="INSERT INTO `tblcolumndetails`(`col_name`,`uniqu_m_id`,`col_report_label`,`col_row_col`,`col_query_field`,`col_query_order`,`col_query_combo`,`col_report_feild`,`col_report_order`,`Id_table`,`fetch_columns`,`fetch_value`)"

                  ."VALUES('".$value_table[0]."','". $getuniqu_id."','".$value_table[1]."','".$value_table[2]."','".$value_table[3]."','".$value_table[4]."','".$value_table[5]."','".$value_table[6]."','".$value_table[7]."','".$value_table[8]."','".$value_table[9]."','".$value_table[10]."')";



                  $STH = $DBH->prepare($sql2);



                  $STH->execute();

                  

               }

                // exit;

            $DBH->commit();

           

     

      if($STH->rowCount() > 0)

        {

             $return = true;

        }

       return $return;

    }

 // <input type="hidden" name="column_name[]" id="column_name'.$index.'" value="'.$row['column_name'].'">



            

    

 //ramakant end 01-10-2018       

  

    public function AddEmailFunction($email_function)//05/03/2019 ramakant

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = false; 

            $sql="INSERT INTO `tblemailactions`(`email_action_title`,`email_action_status`)VALUES('".$email_function."','1')";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

               $return = true; 

            }

            $DBH->commit();

            return $return;

            

    }

   

    //ramakant added 07/03/2019  & update ample 10-07-20

    public function AddMessageContent($message_type,$message_contents,$admin_id,$mess_name_id,$admin_comment,$SMS_ID)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;

		$ins_sql = "INSERT INTO `tblcommonsettings`(`cs_name`,`cs_mess_name_id`,`cs_admin_comm`,`cs_value`,`cs_status`,`cs_type`,SMS_ID) VALUES ('".addslashes($message_type)."','".$mess_name_id."','".$admin_comment."','".addslashes($message_contents)."','1','MSG',".$SMS_ID.")";

		$STH = $DBH->prepare($ins_sql);

                $STH->execute();

		

		if($STH->rowCount()  > 0)

		{

			$return = true;

                }

                

                return $return;

   }









   public function getPagePopup($search,$status)

    {

            

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();



            $admin_id = $_SESSION['admin_id'];

            $edit_action_id = '363';

            $delete_action_id = '365';

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



             $sql = "SELECT * FROM `tbl_page_pop` WHERE is_deleted = '0' $sql_str_search $sql_str_status  ORDER BY page_cat_id DESC";

           

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

                   

                    // $cat2_imp = explode(',', $row['sub_cat2']);

                    // $cat2_imp = implode('\',\'', $cat2_imp);

                    

                    // $cat3_imp = explode(',', $row['sub_cat3']);

                    // $cat3_imp = implode('\',\'', $cat3_imp);

                    

                    // $cat4_imp = explode(',', $row['sub_cat4']);

                    // $cat4_imp = implode('\',\'', $cat4_imp);

                    

                    // $cat5_imp = explode(',', $row['sub_cat5']);

                    // $cat5_imp = implode('\',\'', $cat5_imp);

                    

                    // $cat6_imp = explode(',', $row['sub_cat6']);

                    // $cat6_imp = implode('\',\'', $cat6_imp);

                    

                    // $cat7_imp = explode(',', $row['sub_cat7']);

                    // $cat7_imp = implode('\',\'', $cat7_imp);

                    

                    // $cat8_imp = explode(',', $row['sub_cat8']);

                    // $cat8_imp = implode('\',\'', $cat8_imp);

                    

                    // $cat9_imp = explode(',', $row['sub_cat9']);

                    // $cat9_imp = implode('\',\'', $cat9_imp);

                    

                    // $cat10_imp = explode(',', $row['sub_cat10']);

                    // $cat10_imp = implode('\',\'', $cat10_imp);

                     

                    // $location_fav_cat = explode(',', $row['location_fav_cat']);

                    // $location_fav_cat = implode('\',\'', $location_fav_cat);

                    

                    // $user_response_fav_cat = explode(',', $row['user_response_fav_cat']);

                    // $user_response_fav_cat = implode('\',\'', $user_response_fav_cat);

                    

                    // $user_what_fav_cat = explode(',', $row['user_what_fav_cat']);

                    // $user_what_fav_cat = implode('\',\'', $user_what_fav_cat);

                    

                    // $alerts_fav_cat = explode(',', $row['alerts_fav_cat']);

                    // $alerts_fav_cat = implode('\',\'', $alerts_fav_cat);

                    

                    

                    // $time_show = ($row['time_show'] == 0 ? 'Hide' : 'Show');

                    // $duration_show = ($row['duration_show'] == 0 ? 'Hide' : 'Show');

                    // $location_show = ($row['location_show'] == 0 ? 'Hide' : 'Show');

                    // $like_dislike_show = ($row['User_view'] == 0 ? 'Hide' : 'Show');

                    // $set_goals_show = ($row['User_Interaction'] == 0 ? 'Hide' : 'Show');

                    // $scale_show = ($row['scale_show'] == 0 ? 'Hide' : 'Show');

                    // $reminder_show = ($row['alert_show'] == 0 ? 'Hide' : 'Show');

                    // $comments_show = ($row['comment_show'] == 0 ? 'Hide' : 'Show');

                    

                    $canv_sub_cat1_show_fetch = ($row['canv_sub_cat1_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');

                    // $canv_sub_cat2_show_fetch = ($row['canv_sub_cat2_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');

                    // $canv_sub_cat3_show_fetch = ($row['canv_sub_cat3_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');

                    // $canv_sub_cat4_show_fetch = ($row['canv_sub_cat4_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');

                    // $canv_sub_cat5_show_fetch = ($row['canv_sub_cat5_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');

                    // $canv_sub_cat6_show_fetch = ($row['canv_sub_cat6_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');

                    // $canv_sub_cat7_show_fetch = ($row['canv_sub_cat7_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');

                    // $canv_sub_cat8_show_fetch = ($row['canv_sub_cat8_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');

                    // $canv_sub_cat9_show_fetch = ($row['canv_sub_cat9_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');

                    // $canv_sub_cat10_show_fetch = ($row['canv_sub_cat10_show_fetch'] == 0 ? 'Hide' : 'Show/Fetch');

                    

                    

                                            

                    $output .= '<tr class="manage-row" >';

                    $output .= '<td height="30" align="center">'.$i.'</td>';

                    $output .= '<td height="30" align="center">'.$status.'</td>';

                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';

                    $output .= '<td height="30" align="center">'.$row['updated_on_date'].'</td>';

                    $output .= '<td align="center" nowrap="nowrap">';

                    if($edit) {

                    $output .= '<a href="index.php?mode=edit_page_pop&id='.$row['page_cat_id'].'" ><img src = "images/edit.gif" border="0"></a>';

                    }

                    $output .= '</td>';

                    $output .= '<td align="center" nowrap="nowrap">';

                    if($delete) {

                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delpagepop.php?id='.$row['page_cat_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

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

                    

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat2']).'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat2_imp).'</td>';

                    // $output .= '<td height="30" align="center">'.$canv_sub_cat2_show_fetch.'</td>';

                    // $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat2_link']).'</td>';

                    

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat3']).'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat3_imp).'</td>';

                    // $output .= '<td height="30" align="center">'.$canv_sub_cat3_show_fetch.'</td>';

                    // $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat3_link']).'</td>';

                    

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat4']).'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat4_imp).'</td>';

                    // $output .= '<td height="30" align="center">'.$canv_sub_cat4_show_fetch.'</td>';

                    // $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat4_link']).'</td>';

                    

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat5']).'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat5_imp).'</td>';

                    // $output .= '<td height="30" align="center">'.$canv_sub_cat5_show_fetch.'</td>';

                    // $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat5_link']).'</td>';

                    

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat6']).'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat6_imp).'</td>';

                    // $output .= '<td height="30" align="center">'.$canv_sub_cat6_show_fetch.'</td>';

                    // $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat6_link']).'</td>';

                    

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat7']).'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat7_imp).'</td>';

                    // $output .= '<td height="30" align="center">'.$canv_sub_cat7_show_fetch.'</td>';

                    // $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat7_link']).'</td>';

                    

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat8']).'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat8_imp).'</td>';

                    // $output .= '<td height="30" align="center">'.$canv_sub_cat8_show_fetch.'</td>';

                    // $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat8_link']).'</td>';

                    

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat9']).'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat9_imp).'</td>';

                    // $output .= '<td height="30" align="center">'.$canv_sub_cat9_show_fetch.'</td>';

                    // $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat9_link']).'</td>';

                    

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($row['prof_cat10']).'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getIdByProfileFavCategoryName($cat10_imp).'</td>';

                    // $output .= '<td height="30" align="center">'.$canv_sub_cat10_show_fetch.'</td>';

                    // $output .= '<td height="30" align="center">'.stripslashes($row['canv_sub_cat10_link']).'</td>';

                    

                    // $output .= '<td height="30" align="center">'.$time_show.'</td>';

                    // $output .= '<td height="30" align="center">'.$duration_show.'</td>';

                    // $output .= '<td height="30" align="center">'.$location_show.'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($location_fav_cat).'</td>';

                    // $output .= '<td height="30" align="center">'.$like_dislike_show.'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($user_response_fav_cat).'</td>';

                    // $output .= '<td height="30" align="center">'.$set_goals_show.'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($user_what_fav_cat).'</td>';

                    // $output .= '<td height="30" align="center">'.$scale_show.'</td>';

                    // $output .= '<td height="30" align="center">'.$reminder_show.'</td>';

                    // $output .= '<td height="30" align="center">'.$obj2->getProfileCustomCategoryName($alerts_fav_cat).'</td>';

                    // $output .= '<td height="30" align="center">'.$comments_show.'</td>';

                    $output .= '<td height="30" align="center">'.$row['order_show'].'</td>';

                     $output .= '<td height="30" align="center">'.$row['pop_show'].'</td>';

                    

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









     public function deletePagePop($page_cat_id)

    {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

            $updated_on_date = date('Y-m-d H:i:s');

             $sql = "UPDATE `tbl_page_pop` SET "

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















     public function addPagePopup($admin_comment,$arr_heading,$fav_cat_type_id_0,$healcareandwellbeing,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$admin_id,$time_show,$duration_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$heading,$order_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$cat_fetch_show_data,$canv_sub_cat_link,$data_source,$page_type,$page_show)

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

            

             

             $healcareandwellbeing_collect=implode(',', $healcareandwellbeing);

            

            // for($i=0;$i<count($healcareandwellbeing);$i++)

            // {

            $sql = "INSERT INTO `tbl_page_pop` (`admin_comment`,`system_cat`,`healcareandwellbeing`,`page_name`,`ref_code`,`sub_cat1`,`sub_cat2`,`sub_cat3`,`sub_cat4`,`sub_cat5`,`sub_cat6`,`sub_cat7`,`sub_cat8`,`sub_cat9`,`sub_cat10`,`prof_cat1`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`prof_cat5`,`prof_cat6`,`prof_cat7`,`prof_cat8`,`prof_cat9`,`prof_cat10`,`pag_cat_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`,`heading`,`order_show`,`canv_sub_cat1_show_fetch`, `canv_sub_cat2_show_fetch`, `canv_sub_cat3_show_fetch`, `canv_sub_cat4_show_fetch`, `canv_sub_cat5_show_fetch`, `canv_sub_cat6_show_fetch`, `canv_sub_cat7_show_fetch`, `canv_sub_cat8_show_fetch`, `canv_sub_cat9_show_fetch`, `canv_sub_cat10_show_fetch`,`canv_sub_cat1_link`, `canv_sub_cat2_link`, `canv_sub_cat3_link`, `canv_sub_cat4_link`, `canv_sub_cat5_link`, `canv_sub_cat6_link`, `canv_sub_cat7_link`, `canv_sub_cat8_link`, `canv_sub_cat9_link`, `canv_sub_cat10_link`,`data_source`,`page_type`,`pop_show`) "

                . "VALUES ('".addslashes($admin_comment)."','".addslashes($fav_cat_type_id_0)."','".addslashes($healcareandwellbeing_collect)."','".addslashes($page_name)."','".addslashes($ref_code)."','".addslashes($sub_cat1)."','".addslashes($sub_cat2)."','".addslashes($sub_cat3)."','".addslashes($sub_cat4)."','".addslashes($sub_cat5)."','".addslashes($sub_cat6)."','".addslashes($sub_cat7)."','".addslashes($sub_cat8)."','".addslashes($sub_cat9)."','".addslashes($sub_cat10)."','".addslashes($prof_cat1)."','".addslashes($prof_cat2)."','".addslashes($prof_cat3)."','".addslashes($prof_cat4)."','".addslashes($prof_cat5)."','".addslashes($prof_cat6)."','".addslashes($prof_cat7)."','".addslashes($prof_cat8)."','".addslashes($prof_cat9)."','".addslashes($prof_cat10)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."','".$heading."','".$order_show."','".$canv_sub_cat1_show_fetch."', '".$canv_sub_cat2_show_fetch."', '".$canv_sub_cat3_show_fetch."','".$canv_sub_cat4_show_fetch."', '".$canv_sub_cat5_show_fetch."', '".$canv_sub_cat6_show_fetch."', '".$canv_sub_cat7_show_fetch."', '".$canv_sub_cat8_show_fetch."', '".$canv_sub_cat9_show_fetch."', '".$canv_sub_cat10_show_fetch."','".$canv_sub_cat_link['canv_sub_cat1_link']."','".$canv_sub_cat_link['canv_sub_cat2_link']."', '".$canv_sub_cat_link['canv_sub_cat3_link']."', '".$canv_sub_cat_link['canv_sub_cat4_link']."', '".$canv_sub_cat_link['canv_sub_cat5_link']."', '".$canv_sub_cat_link['canv_sub_cat6_link']."', '".$canv_sub_cat_link['canv_sub_cat7_link']."', '".$canv_sub_cat_link['canv_sub_cat8_link']."', '".$canv_sub_cat_link['canv_sub_cat9_link']."', '".$canv_sub_cat_link['canv_sub_cat10_link']."','".$data_source."','".$page_type."','".$page_show."')";

                $STH = $DBH->prepare($sql);

                $STH->execute();

            // }

            if($STH->rowCount() > 0)

                {

                     $return = true;

                }

            return $return;

    }





  



     public function getPagepopDetails($page_cat_id)

    {

            $obj2 = new Contents();

            $my_DBH = new mysqlConnection();

             $DBH = $my_DBH->raw_handle();

             $DBH->beginTransaction();

            $pdm_id = '';

            $page_id_str = '';

            $pd_status = '';

            

            $sql = "SELECT * FROM `tbl_page_pop` WHERE `page_cat_id` = '".$page_cat_id."' AND `is_deleted` = '0' ";

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



                // $time_show = stripslashes($row['time_show']);

                // $location_show = stripslashes($row['location_show']);

                // $duration_show = stripslashes($row['duration_show']);

                // $like_dislike_show = stripslashes($row['User_view']);

                // $set_goals_show = stripslashes($row['User_Interaction']);

                // $comments_show = stripslashes($row['comment_show']);

                // $scale_show = stripslashes($row['scale_show']);

                // $reminder_show = stripslashes($row['alert_show']);



                $order_show = stripslashes($row['order_show']);



                // $location_category = stripslashes($row['location_fav_cat']);

                // $user_response_category = stripslashes($row['user_response_fav_cat']);

                // $user_what_next_category = stripslashes($row['user_what_fav_cat']);

                // $alerts_updates_category = stripslashes($row['alerts_fav_cat']);

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

                // $arr_heading['time_heading']=$row['time_heading'];

                // $arr_heading['duration_heading']=$row['duration_heading'];

                // $arr_heading['location_heading']=$row['location_heading'];

                // $arr_heading['like_dislike_heading']=$row['like_dislike_heading'];

                // $arr_heading['set_goals_heading']=$row['set_goals_heading'];

                // $arr_heading['scale_heading']=$row['scale_heading'];

                // $arr_heading['reminder_heading']=$row['reminder_heading'];

                // $arr_heading['comments_heading']=$row['comments_heading'];

                $admin_comment=$row['admin_comment'];

               $show_pop=$row['pop_show'];

                 

              // exit;

                

            }

            return array($admin_comment,$arr_heading,$healcareandwellbeing,$page_name,$ref_code,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$pag_cat_status,$heading,$time_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$order_show,$duration_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$canv_sub_cat1_link,$canv_sub_cat2_link,$canv_sub_cat3_link,$canv_sub_cat4_link,$canv_sub_cat5_link,$canv_sub_cat6_link,$canv_sub_cat7_link,$canv_sub_cat8_link,$canv_sub_cat9_link,$canv_sub_cat10_link, $canv_sub_cat1_show_fetch,$canv_sub_cat2_show_fetch,$canv_sub_cat3_show_fetch,$canv_sub_cat4_show_fetch,$canv_sub_cat5_show_fetch,$canv_sub_cat6_show_fetch,$canv_sub_cat7_show_fetch,$canv_sub_cat8_show_fetch,$canv_sub_cat9_show_fetch,$canv_sub_cat10_show_fetch,$page_type,$show_pop);

    }  











      public function updatePagePopup($admin_comment,$arr_heading,$pag_cat_status,$admin_id,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$id,$time_show,$duration_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$heading,$order_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$cat_fetch_show_data,$canv_sub_cat_link,$data_source,$show_pop)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $updated_on_date = date('Y-m-d H:i:s');

            

            $sql = "UPDATE `tbl_page_pop` SET "

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

                    . "`sub_cat1` = '".addslashes($sub_cat1)."',"

                    . "`sub_cat2` = '".addslashes($sub_cat2)."' ,"

                    . "`sub_cat3` = '".addslashes($sub_cat3)."' ,"

                    . "`sub_cat4` = '".addslashes($sub_cat4)."' ,"

                    . "`sub_cat5` = '".addslashes($sub_cat5)."' ,"

                    . "`sub_cat6` = '".addslashes($sub_cat6)."' ,"

                    . "`sub_cat7` = '".addslashes($sub_cat7)."' ,"

                    . "`sub_cat8` = '".addslashes($sub_cat8)."' ,"

                    . "`sub_cat9` = '".addslashes($sub_cat9)."' ,"

                    . "`sub_cat10` = '".addslashes($sub_cat10)."',"

                    . "`heading` = '".addslashes($heading)."' ,"

                    . "`order_show` = '".addslashes($order_show)."' ,"

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

                    . "`canv_sub_cat10_link`= '".addslashes($canv_sub_cat_link['canv_sub_cat10_link'])."',"

                    . "`updated_by_admin` = '".addslashes($admin_id)."' ,"

                    . "`pop_show` = '".addslashes($show_pop)."',"

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





    public function getvendoraccesdropdownmain($cat_id)

    {

        $my_DBH = new mysqlConnection();

        $output = '';

        $output .= '<option value="" >Select Category</option>';

            try {

                //$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '".$parent_cat_id."' AND `cat_deleted` = '0' ORDER BY cat_name ASC";  

                //$sql = "SELECT fav_cat_id,fav_cat FROM `tblfavcategory` WHERE 1 ORDER BY fav_cat ASC";    

                $sql = "SELECT * FROM `tblvendoraccess` "

                                     . "LEFT JOIN tblprofilecustomcategories ON tblvendoraccess.va_cat_id = tblprofilecustomcategories.prct_cat_id WHERE tblprofilecustomcategories.prct_cat_status = 1 and tblprofilecustomcategories.prct_cat_deleted = 0 and tblvendoraccess.va_deleted=0 and tblvendoraccess.va_status = 1 GROUP BY tblvendoraccess.va_cat_id ORDER BY tblprofilecustomcategories.prct_cat ASC";

                                $STH = $my_DBH->query($sql);

                if( $STH->rowCount() > 0 )

                {

                    while($r= $STH->fetch(PDO::FETCH_ASSOC))

                    {

                        

                                            if($r['prct_cat_id'] == $cat_id )

                                            {

                                                    $selected = ' selected ';   

                                            }

                                            else

                                            {

                                                    $selected = ''; 

                                            }   

                        

                        

                        $output .= '<option value="'.$r['prct_cat_id'].'" '.$selected.'>'.stripslashes($r['prct_cat']).'</option>';

                    }

                }

            } catch (Exception $e) {

                //$stringData = '[getMainCategoryOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;

                //$this->debuglog($stringData);

                return $output;

            }

                

        return $output;

    }





    public function getvendoraccesdropdownsub($va_cat_id,$va_sub_cat_id)

    {



        // echo 'hiii'.$va_cat_id;

        // exit;

        $my_DBH = new mysqlConnection();

        $output = '';

        $output .= '<option value="" >Select Category</option>';

            try {

                //$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '".$parent_cat_id."' AND `cat_deleted` = '0' ORDER BY cat_name ASC";  

                //$sql = "SELECT fav_cat_id,fav_cat FROM `tblfavcategory` WHERE 1 ORDER BY fav_cat ASC";    

                $sql = "SELECT * FROM `tblvendoraccess` "

                                     . "LEFT JOIN tblfavcategory ON tblvendoraccess.va_sub_cat_id = tblfavcategory.fav_cat_id WHERE tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblvendoraccess.va_deleted=0 and tblvendoraccess.va_status = 1 and tblvendoraccess.va_cat_id = '".$va_cat_id."' GROUP BY tblvendoraccess.va_sub_cat_id ORDER BY tblfavcategory.fav_cat ASC";

                                $STH = $my_DBH->query($sql);

                if( $STH->rowCount() > 0 )

                {

                    while($r= $STH->fetch(PDO::FETCH_ASSOC))

                    {

                        

                                            if($r['fav_cat_id'] == $va_sub_cat_id )

                                            {

                                                    $selected = ' selected ';   

                                            }

                                            else

                                            {

                                                    $selected = ''; 

                                            }   

                        

                        

                        $output .= '<option value="'.$r['fav_cat_id'].'" '.$selected.'>'.stripslashes($r['fav_cat']).'</option>';

                    }

                }

            } catch (Exception $e) {

                //$stringData = '[getMainCategoryOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;

                //$this->debuglog($stringData);

                return $output;

            }

                

        return $output;

    }





    public function getDatadropdownPage_kr($pdm_id,$page_id)

    {

            $my_DBH = new mysqlConnection();

            // $DBH = $my_DBH->raw_handle();

            // $DBH->beginTransaction();

            $option_str = '';       

            $sel = '';

            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` ='".$pdm_id."' ";

           // echo $sql;

            $STH = $my_DBH->query($sql);

            // $STH->e xecute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);



               // echo "<pre>";print_r($row);echo "</pre>";

               // exit;

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

            return $option_str;

    }

    

    public function multisponsor_name($sponsor_id,$mor_id,$select_value,$coutr)

    {

       



         $my_DBH = new mysqlConnection();

         $DBH = $my_DBH->raw_handle();

         $DBH->beginTransaction();



        if($sponsor_id=="user")

        {

         $sql="SELECT * FROM `tblusers` WHERE `status`=1";

        }

        else

        {

          $sql="SELECT * FROM `tblvendors` WHERE `vendor_status`=1 AND `vendor_deleted`=0";  

        }





            $STH = $my_DBH->query($sql);

            if($STH->rowCount() > 0)

            {

                 $html='  <div style="width: 308px;height: 126px;overflow: scroll;;">

                        <ul style="list-style:none;padding:0px;margin:0px;">';

             while($row = $STH->fetch(PDO::FETCH_ASSOC))

             {

                if($row['participant_profile']!="")

                {

                $arr=explode(',',$row['participant_profile']);

                if(in_array('475',$arr))

                { 



                    $arr=explode(',',$select_value);



                    if($sponsor_id=="user")

                    {



                     $nams=$row['name'].' '.$row['middle_name'].' '.$row['last_name'];

                     if(in_array($nams,$arr))

                     {

                        $checked="checked";

                     }

                     else

                     {

                         $checked="";

                     }



                     $html.='<li style="padding:0px;"><input type="checkbox" name="selected_user_id[]" id="selected_user_id_'.$mor_id.'" value="'.$row['name'].' '.$row['middle_name'].' '.$row['last_name'].'" onclick="getSelectedUserListIds('.$row['user_id'].');" '.$checked.'/>&nbsp;<strong>&nbsp;&nbsp;'.$row['name'].' '.$row['middle_name'].' '.$row['last_name'].'</strong></li>';

                    }

                    else

                    {



                         $nams=$row['vendor_name'];

                         if(in_array($nams,$arr))

                         {

                            $checked="checked";

                         }

                         else

                         {

                             $checked="";

                         }



                       $html.='<li style="padding:0px;"><input type="checkbox" name="selected_vendor_id[]" id="selected_user_id_'.$mor_id.'" value="'.$row['vendor_name'].'" onclick="getSelectedUserListIds('.$row['vendor_id'].');" '.$checked.'/>&nbsp;<strong>&nbsp;&nbsp;'.$row['vendor_name'].'</strong></li>'; 

                    }

                 }



                }

             }

             $html .='</ul></div>';



              if($coutr!=2)

              {

             $html .='<div class="buttonshow" style="margin-top: 2%;">

              <button type="button" class="btn btn-default" id="more_id" onclick="add_more_input('.$mor_id.')">+</button>

             </div>';

             }

                // echo $mor_id;



          }

          return $html;

    }

    
    public function getdylgroupcodeoption($fav_cat_type_id,$fav_cat_id)

	{

           $my_DBH = new mysqlConnection();
           $DBH = $my_DBH->raw_handle();
           $DBH->beginTransaction();
           $option_str = '';		

            

            $fav_cat_type_id = explode(',', $fav_cat_type_id);

            $fav_cat_type_id = implode('\',\'', $fav_cat_type_id);

            

            $sql = "SELECT * FROM `tblcustomfavcategory` "

                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('".$fav_cat_type_id."') and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";

            //echo $sql;

            $STH = $DBH->query($sql);

            if( $STH->rowCount() > 0 )

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

                    $option_str .= '<option value="'.$row['favcat_id'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';

                }

            }

            //echo $option_str;

            

            return $option_str;

	}
    //add this function by ample 05-11-19
    public function getTableNameFrom_tbltabldropdown($id="",$select_value="")
    {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $output = '';      
            $sql = "SELECT tabl_name FROM tbltabldropdown where tablm_id=".$id;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount()  > 0)
            {  

               $output.='<option value=" ">-Select-</option>';
                         while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                        {
                            $table_name = stripslashes($row['tabl_name']);
                            $table=explode(",",$table_name);
                            if(!empty($table))
                            {   
                                foreach ($table as $key => $value) 
                                {
                                    if($select_value==$value)
                                    {
                                        $select="selected";
                                    }
                                    else
                                    {
                                        $select=""; 
                                    }
                                    $output.='<option value="'.$value.'"'.$select.'>'.$value.'</option>';
                                }
                            }
                            
                        }
            }

            return $output;

    } 
     public function get_report_custom_data($columns="",$uniqu_id="")

    {

            $obj2 = new Contents();

            $my_DBH = new mysqlConnection();

             $DBH = $my_DBH->raw_handle();

             $DBH->beginTransaction();

             $details_arr=array();

             $edit_col_name=array();

             $collect_arr=array();


                  $sql1="SELECT * FROM `tblcolumndetails` WHERE `uniqu_m_id`='".$uniqu_id."'";

                  $STH = $DBH->prepare($sql1);

                    $STH->execute();

                    if($STH->rowCount()  > 0)

                    {

                       while($row1 = $STH->fetch(PDO::FETCH_ASSOC))

                       {

                         $details_arr[]=$row1;

                       }

                    }


                    if(!empty($details_arr))
                    {

                         foreach($details_arr as $detail_cal)

                        {

                            $edit_col_name[]=$detail_cal['col_name'];

                        }


                        foreach($columns as $colum_name)

                         {

                            $col_val[]=$colum_name['column_name'];

                            if(in_array($colum_name['column_name'],$edit_col_name))

                            {

                                 foreach($details_arr as $get_col_detail)

                                 {

                                    if($colum_name['column_name']==$get_col_detail['col_name'])

                                    {

                                       array_push($collect_arr,$get_col_detail);  

                                    }

                                 }
     
                            }

                          else

                            {


                                $makearr=array('col_id'=>'','col_name'=>$colum_name['column_name'],'uniqu_m_id'=>'','col_report_label'=>'','col_row_col'=>'','col_query_field'=>'','col_query_order'=>'','col_query_combo'=>'','col_report_feild'=>'','col_report_order'=>'','Id_table'=>'','fetch_columns'=>'','fetch_value'=>'');

                                array_push($collect_arr,$makearr); 

                            }

                         }
                    }
                    else
                    {
                          foreach($columns as $colum_name)

                         {
                             $makearr=array('col_id'=>'','col_name'=>$colum_name['column_name'],'uniqu_m_id'=>'','col_report_label'=>'','col_row_col'=>'','col_query_field'=>'','col_query_order'=>'','col_query_combo'=>'','col_report_feild'=>'','col_report_order'=>'','Id_table'=>'','fetch_columns'=>'','fetch_value'=>'');

                                array_push($collect_arr,$makearr); 
                         }

                    }
                
                    // echo "<pre>";

                    // print_r($collect_arr);

                    // die('dfs4f4f456');

            return $collect_arr;
    } 

    //code added by ample 22-11-19 
    public function update_report_custom_data($arr="",$checkvalue="",$page_id="",$uid_col="",$tbl_name="",$col_name="")

    {   

       //  echo "<pre>";

       //  print_r($arr);
       //  echo "<br>";
       //  print_r($checkvalue);
       //  echo "<br>";
       //  print_r($page_id);
       //  echo "<br>";
       //  print_r($uid_col);
       // die('--dsmnglkj');

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $updated_on_date = date('Y-m-d H:i:s');

            $return = false;
        

    if(!empty($arr) && !empty($checkvalue))
    {
         foreach($checkvalue as $key=>$cols_name)

        {

           if($cols_name!="")

           {

            $get_key[]=$key;

           } 

        }

           foreach($get_key as $find_key_value)

           {

             $first_[] = array_column($arr,$find_key_value);

           }

    

            foreach($first_ as $getselected)

            {

                if($getselected[2]!='')

                {

                    $getselected_data[]=$getselected;

                }

            }


      $getuniqu_id='ID'.time().date();


        foreach($getselected_data  as $upvalue)

        {

          

          if($upvalue[0]!='' && $upvalue[1]!='')

          {

              $update_qt="UPDATE `tblcolumndetails` SET 

               `uniqu_m_id`='".$getuniqu_id."',

               `Id_table`='".$upvalue[3]."',

               `fetch_columns`='".$upvalue[4]."',

               `fetch_value`='".$upvalue[5]."' WHERE `col_id`='".$upvalue[1]."' AND `uniqu_m_id`='".$upvalue[0]."'";

                $STH = $DBH->prepare($update_qt);

                $STH->execute();

          }

          else

          {

               $inser="INSERT INTO `tblcolumndetails`(`col_name`,`uniqu_m_id`,`Id_table`,`fetch_columns`,`fetch_value`) VALUES('".$upvalue[2]."','".$getuniqu_id."','".$upvalue[3]."','".$upvalue[4]."','".$upvalue[5]."')";



               $STH = $DBH->prepare($inser);

                $STH->execute();

          }

        }


            $sql = "UPDATE ".$tbl_name." SET ".$uid_col."='".$getuniqu_id."' WHERE ".$col_name." = '".$page_id."' ";

           

            $STH = $DBH->prepare($sql);



             $STH->execute();

             $DBH->commit();

        if($STH->rowCount()  > 0)

        {

            $return = true;

        }
    }

        
        return $return;

    } 
    // added by ample 09-12-19
    public function get_data_from_tblicons($type_id="",$icons_id="")
    {
        $DBH = new mysqlConnection();
        $data = array();
            if($type_id)
            {
                $sql = "SELECT * FROM  tbl_icons WHERE status='1' AND icons_type_id=".$type_id;
            }
            elseif($icons_id)
            {
                $sql = "SELECT * FROM  tbl_icons WHERE  icons_id=".$icons_id;
            }
            else{
                $sql = "SELECT * FROM  tbl_icons WHERE status='1'";
            }
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
            }
      
        return $data;
    
    }
    // added by ample 09-12-19
    public function get_data_from_tblsolutionitems($box_type="",$box_id="")
    {
        $DBH = new mysqlConnection();
        $data = array();
            if($box_type)
            {
                $sql = "SELECT * FROM  tblsolutionitems WHERE status='1' AND banner_type='".$box_type."'";
            }
            elseif($box_id)
            {
                $sql = "SELECT * FROM  tblsolutionitems WHERE sol_item_id='".$box_id."'";
            }
            else{
                $sql = "SELECT * FROM  tblsolutionitems WHERE status='1'";
            }
            $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
            }
      
        return $data;
    
    }
    // code  by ample 07-01-20
    public function get_data_from_tblcolumndetails($UID="")
    {   

            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();

            $details_arr=array();

            $sql1="SELECT * FROM `tblcolumndetails` WHERE `uniqu_m_id`='".$UID."'";


            $STH = $DBH->prepare($sql1);

                $STH->execute();

                if($STH->rowCount()  > 0)

                {

                   while($row1 = $STH->fetch(PDO::FETCH_ASSOC))

                   {

                     $details_arr[]=$row1;

                   }

                }
                                
        

        return $details_arr;
    } 
    //function added by ample 07-01-20
    public function get_custom_filter_check($report_data="",$colum_name="")
    {   
        $report_list = array();
        if(!empty($report_data))
        {
            //$filter_data=1;
            foreach ($report_data as $key => $value) {

                if($value['col_name']==$colum_name)
                {
                    //$report_list=$value;
                    $report_list['final_data_value']=$value;
                    // if($value['col_query_field']=='No')
                    // {
                    //     $filter_data=0;
                    // }
                }
                else
                {   

                    // if($value['col_query_field']=='Yes')
                    // {
                          $report_list['filter_data_value'][]=$value;
                    //}
                }
            }
            // if($filter_data==0)
            // {
            //     $report_list['filter_data_value']=array();
            // }
        }
        return $report_list;
    }
    //function added by ample 07-01-20
    public function get_custom_filter_data($filter_data="",$cat_id="",$prof_cat_tbl="",$prof_cat_col="")
    {   
        $DBH = new mysqlConnection();
        $key_col="";
        $data = array();
        if(!empty($filter_data))
        {
            foreach ($filter_data as $key => $value) {

                 $key_col=$this->get_dynamic_column_of_delete_and_status($prof_cat_tbl); //add by ample 04-05-20

                $cat_id = implode(",",$cat_id);
                //$sql = "SELECT DISTINCT ".$value['fetch_columns']." FROM ".$value['Id_table']." WHERE ".$value['fetch_value']." IN ('".$cat_id."')";
                $sql = "SELECT DISTINCT ".$prof_cat_col." FROM ".$prof_cat_tbl." WHERE ".$value['col_name']." IN (".$cat_id.")".$key_col."";
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                        //$data[] = $row[$value['fetch_columns']];
                        $data[] = $row[$prof_cat_col];
                    }
                }
               
            }
        }
        return $data;
    }
    //function added by ample 07-01-20
    public function get_custom_final_key_value($cat_data="",$match_data="")
    {   
        $DBH = new mysqlConnection();
        $data = array();
        $key_col="";
        if(!empty($cat_data))
        {
            foreach ($cat_data as $key => $value) {

                 $key_col=$this->get_dynamic_column_of_delete_and_status($match_data['Id_table']); //add by ample 04-05-20
                
                $sql = "SELECT ".$match_data['fetch_columns']." FROM ".$match_data['Id_table']." WHERE ".$match_data['fetch_value']." = '".$value."'".$key_col."";
                //print_r($sql);
                $STH = $DBH->query($sql);
                if ($STH->rowCount() > 0) {
                    while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                        $data[] = $row[$match_data['fetch_columns']];
                    }
                }
            }
        }
        return $data;
    }
    //function added by ample 07-01-20
    public function getDataFromReportCustomized($sub_cat="",$prof_cat_tbl="",$prof_cat_col="",$UID="")
    {   
        $final_data=array();
        if($sub_cat && $prof_cat_tbl && $prof_cat_col && $UID)
        {
            // echo "<pre>";
            //   print_r($sub_cat);
            // change function 22-11-19
             // $report_custom = $this->getDataRecordsDropdownDetails($prof_cat_tbl);
             $report_custom = $this->get_data_from_tblcolumndetails($UID);
              //   echo "report-custom--------";
              // print_r($report_custom);
              if(!empty($report_custom))
              {
                $report_list = $this->get_custom_filter_check($report_custom,$prof_cat_col);
              }
              // echo "report_list----------";
              // print_r($report_list);
              if(!empty($report_list['filter_data_value']))
              {
                $filter_arrray=$this->get_custom_filter_data($report_list['filter_data_value'],$sub_cat,$prof_cat_tbl,$prof_cat_col);
              //    echo "filter_array----------";
              // print_r($filter_arrray);
                if(!empty($filter_arrray) && $report_list['final_data_value'])
                {
                  $final_data=$this->get_custom_final_key_value($filter_arrray,$report_list['final_data_value']);
                }

              }
              else
              { 
                if(!empty($report_list['final_data_value']))
                {
                    $final_data=$this->get_custom_final_key_value($sub_cat,$report_list['final_data_value']);
                }
                
              }
            return $final_data; 
        }
        else
        {
         return $final_data; 
        }
         
    }
    //create new function for save or update DYL banners
    public function update_banners_DYL($id="",$data="",$count_row="")
    {
           $this->delete_banners_DYL($id);


            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;

                $query = "INSERT INTO `tbl_multiple_banners_dyl` (`ref_id`,`banner_show`,`banner_order`,`banner`,`banner_type`,`credit_line`,`credit_line_url`,`sound_clip`) VALUES ";
                $values = '';
                foreach ($data as $key => $value) {
                     $values .= "(".$id.",'".$value['banner_show']."','".$value['banner_order']."','".$value['banner']."','".$value['banner_type']."','".$value['credit_line']."','".$value['credit_line_url']."','".$value['sound_clip']."'),";
                }
                //$values = rtrim($values, ',');
                $values = substr($values, 0, strlen($values) - 1);
                $insert_query = $query . $values;
                //echo $insert_query;
            // $STH = $DBH->prepare($sql);
            //  $STH->execute();
             $STH = $DBH->query($insert_query);
            //print_r($STH);
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        return $return;
    }

    function get_banners_DYL($ref_id="")
    {
        $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $data=array();
            // $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $return=false;

            $sql="SELECT * FROM `tbl_multiple_banners_dyl` WHERE `ref_id`=".$ref_id;

            $STH = $DBH->query($sql);

            if($STH->rowCount()  > 0)

            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            }

        return $data;  
    }
    //add by ample 
    public function delete_banners_DYL($ref_id="")
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "DELETE FROM `tbl_multiple_banners_dyl` WHERE `ref_id` = ".$ref_id; 
        // $STH = $DBH->prepare($sql); 
        // $STH->execute();
        $STH = $DBH->query($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
    // add by ample 24-03-20
    public function deleteRecordDropdown($page_cat_id="")

    {

        $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;

        $del_sql1 = "UPDATE `tbl_recordshow_dropdown` SET is_deleted =1 WHERE `page_cat_id` = '".$page_cat_id."'"; 

        $STH = $DBH->prepare($del_sql1);

                $STH->execute();

        if($STH->rowCount() > 0)

        {

            $return = true;

        }

        return $return;

    }

    //create new function for save or update favcategory banners 08-04-20
    public function update_banners_favcategory($id="",$data="",$count_row="")
    {
           $this->delete_banners_favcategory($id);


            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;

                $query = "INSERT INTO `tbl_banners_favcategory` (`ref_id`,`banner_show`,`banner_order`,`banner`,`banner_type`,`credit_line`,`credit_line_url`,`sound_clip`) VALUES ";
                $values = '';
                foreach ($data as $key => $value) {
                     $values .= "(".$id.",'".$value['banner_show']."','".$value['banner_order']."','".$value['banner']."','".$value['banner_type']."','".$value['credit_line']."','".$value['credit_line_url']."','".$value['sound_clip']."'),";
                }
                //$values = rtrim($values, ',');
                $values = substr($values, 0, strlen($values) - 1);
                $insert_query = $query . $values;
                //echo $insert_query;
            // $STH = $DBH->prepare($sql);
            //  $STH->execute();
             $STH = $DBH->query($insert_query);
            //print_r($STH);
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        return $return;
    }
    //add by ample
    function get_banners_favcategory($ref_id="")
    {
        $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $data=array();
            // $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $return=false;

            $sql="SELECT * FROM `tbl_banners_favcategory` WHERE `ref_id`=".$ref_id;

            $STH = $DBH->query($sql);

            if($STH->rowCount()  > 0)

            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            }

        return $data;  
    }
    //add by ample 
    public function delete_banners_favcategory($ref_id="")
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "DELETE FROM `tbl_banners_favcategory` WHERE `ref_id` = ".$ref_id; 
        // $STH = $DBH->prepare($sql); 
        // $STH->execute();
        $STH = $DBH->query($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
    //add by ample 04-05-20
    public function get_dynamic_column_of_delete_and_status($table="")
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = false;
        $str='';
        $sql = "SELECT * FROM `tbl_recordshow_dropdown` WHERE pag_cat_status='1' AND is_deleted='0' AND is_action='1' AND table_name='".$table."'";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
                $data= $row;
        }
        if(!empty($data))
        {   
            $status=$this->get_dynamic_column($data['uniqu_id'],'status');
            if($status)
            {
                $str=$str.' AND '.$status.'=1';
            }
            $deleted=$this->get_dynamic_column($data['uniqu_id'],'deleted');
            if($deleted)
            {
                $str=$str.' AND '.$deleted.'=0';
            }
        }
        return $str;
    }
    //add by ample
    public function get_dynamic_column($uniq,$key) {
        $DBH = new mysqlConnection();
        $select_sql_col = "SELECT `col_name` FROM `tblcolumndetails` WHERE `uniqu_m_id` = '" . $uniq . "' AND `col_query_field`='Yes' AND `col_query_combo`='".$key."'";
        $STH1 = $DBH->query($select_sql_col);
        $row_col = $STH1->fetch(PDO::FETCH_ASSOC);
        $data = $row_col['col_name'];
        return $data;
    }
    //create new function for save or update  banners solution items
    public function update_banners_solutionItems($id="",$data="",$count_row="")
    {
           $this->delete_banners_solutionItems($id);


            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;

                $query = "INSERT INTO `tblsolutionitems_banners` (`ref_id`,`banner_show`,`banner_order`,`banner`,`banner_type`,`credit_line`,`credit_line_url`,`sound_clip`,`narration`) VALUES ";
                $values = '';
                foreach ($data as $key => $value) {
                     $values .= "(".$id.",'".$value['banner_show']."','".$value['banner_order']."','".$value['banner']."','".$value['banner_type']."','".$value['credit_line']."','".$value['credit_line_url']."','".$value['sound_clip']."','".$value['narration']."'),";
                }
                //$values = rtrim($values, ',');
                $values = substr($values, 0, strlen($values) - 1);
                $insert_query = $query . $values;
                //echo $insert_query;
            // $STH = $DBH->prepare($sql);
            //  $STH->execute();
             $STH = $DBH->query($insert_query);
            //print_r($STH);
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        return $return;
    }

    function get_banners_solutionItems($ref_id="")
    {
        $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $data=array();
            // $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $return=false;

            $sql="SELECT * FROM `tblsolutionitems_banners` WHERE `ref_id`=".$ref_id;

            $STH = $DBH->query($sql);

            if($STH->rowCount()  > 0)

            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            }

        return $data;  
    }
    //add by ample 
    public function delete_banners_solutionItems($ref_id="")
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "DELETE FROM `tblsolutionitems_banners` WHERE `ref_id` = ".$ref_id; 
        // $STH = $DBH->prepare($sql); 
        // $STH->execute();
        $STH = $DBH->query($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }   
    //add by ample 27-05-20     
    function get_specifiq_data_DYL($data_id="")
    {
        $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $data=array();
            // $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $return=false;

            $sql="SELECT * FROM `tbl_specifiq_text_dyl` WHERE `data_id`=".$data_id." ORDER BY text_order ASC";

            $STH = $DBH->query($sql);

            if($STH->rowCount()  > 0)

            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            }

        return $data;  
    }
    //create new function for save or update DYL specifiq text 
    public function update_specifiq_data_DYL($id="",$data="",$count_row="")
    {
           $this->delete_specifiq_data_DYL($id);


            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;

                $query = "INSERT INTO `tbl_specifiq_text_dyl` (`data_id`,`text_show`,`text_order`,`data_source`,`specifiq_text`,`icon_type`,`icon_source`,`rank_show`) VALUES ";
                $values = '';
                foreach ($data as $key => $value) {
                     $values .= "(".$id.",'".$value['text_show']."','".$value['text_order']."','".$value['data_source']."','".$value['specifiq_text']."','".$value['icon_type']."','".$value['icon_source']."','".$value['rank_show']."'),";
                }
                //$values = rtrim($values, ',');
                $values = substr($values, 0, strlen($values) - 1);
                $insert_query = $query . $values;
                //echo $insert_query;
            // $STH = $DBH->prepare($sql);
            //  $STH->execute();
             $STH = $DBH->query($insert_query);
            //print_r($STH);
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        return $return;
    }
    //add by ample 
    public function delete_specifiq_data_DYL($data_id="")
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "DELETE FROM `tbl_specifiq_text_dyl` WHERE `data_id` = ".$data_id; 
        // $STH = $DBH->prepare($sql); 
        // $STH->execute();
        $STH = $DBH->query($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }

    //add by ample 16-06-20
    public function addPageDecorData($admin_id,$data,$DYL_id="")
    {   

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql = "INSERT INTO `tbl_page_decor` (`created_by`,`ref_code`,`page_type`,`page_name`,`page_name_heading`,`data_source`,`system_cat`,`system_sub_cat`,`admin_notes`,`narration`,`order_no`) VALUES (".$admin_id.",'".$data['ref_code']."','".$data['page_type']."','".$data['page_name']."','".$data['page_name_heading']."','".$data['data_source']."','".$data['system_cat']."','".$data['system_sub_cat']."','".$data['admin_notes']."','".$data['narration']."','".$data['order_no']."')";

        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {   
            $PD_id = $DBH->lastInsertId();
            if(!empty($DYL_id))
            {
                $this->update_DYL_by_PD($DYL_id,$PD_id);
            }
            $return = true;
        }
        return $return;
    }

    //add by ample 17-06-20
    public function getPageDecorListData($search,$status) { 
        $my_DBH = new mysqlConnection(); 
        $DBH = $my_DBH->raw_handle(); 
        $DBH->beginTransaction(); 
        $admin_id = $_SESSION['admin_id']; 
        $edit_action_id = '374'; 
        $delete_action_id = '375'; 
        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id); 
        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id); 
        if($search != '') 
        { 
            $sql_str_search = " AND (admin_notes like '%".$search."%' OR narration like '%".$search."%' OR ref_code like '%".$search."%')"; 
        } 
        else 
        {
         $sql_str_search = ""; 
        } 
        if($status != '') 
        { 
            $sql_str_status = " AND status = '".$status."' "; 
        } 
        else 
        { 
            $sql_str_status = ""; 
        } 
        $sql = "SELECT * FROM `tbl_page_decor` WHERE is_deleted = '0' ".$sql_str_search." ".$sql_str_status." ORDER BY id DESC";  
        $STH = $DBH->prepare($sql); 
        $STH->execute(); 
        $total_records = $STH->rowCount(); 
        $record_per_page = 100; 
        $scroll = 5; 
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true); 
        $page->set_link_parameter("Class = paging"); 
        $page->set_qry_string($str="mode=manage-page-decor"); 
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

                        $status=($row['status'] == '1')? "Active" :"Inactive";

                        $sub_cat = explode(',', $row['system_sub_cat']);
                        $sub_cat = implode('\',\'', $sub_cat);

                       $output .= '<tr class="manage-row">'; 
                       $output .= '<td height="30" align="center">'.$i.'</td>'; 
                       $output .= '<td height="30" align="center">'.$status.'</td>'; 
                       $output .= '<td height="30" align="center">'.$this->getUsenameOfAdmin($row['created_by']).'</td>'; 
                       $output .= '<td height="30" align="center">'.date("d-m-Y H:i:s",strtotime($row['created_at'])).'</td>'; 
                       $output .= '<td align="center" nowrap="nowrap">'; 
                       if($edit) 
                        { 
                            $output .= '<a href="index.php?mode=edit-page-decor&id='.$row['id'].'"><img src="images/edit.gif" border="0"></a>'; 
                        } 
                        $output .= '</td>'; 
                        $output .= '<td align="center" nowrap="nowrap">'; 
                        if($delete) 
                            { 
                                $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delpagedecor.php?id='.$row['id'].'")\'><img src="images/del.gif" border="0"></a>'; 
                            } 
                        $output .= '<td height="30" align="center">'.stripslashes($row['ref_code']).'</td>'; 
                        $output .= '<td height="30" align="center">'.stripslashes($row['admin_notes']).'</td>';  
                        $output .= '<td height="30" align="center">'.stripslashes($row['narration']).'</td>'; 
                        $output .= '<td height="30" align="center">'.$row['page_type'].'</td>';
                        $output .= '<td height="30" align="center">'.$this->getPagenamebyPage_menu_id('30',$row['page_name'],$row['page_type']).'</td>'; 
                        $output .= '<td height="30" align="center">'.$row['page_name_heading'].'</td>'; 
                        $output .= '<td height="30" align="center">'.$this->getPagenamebyid($row['data_source']).'</td>'; 
                        $output .= '<td height="30" align="center">'.$this->getProfileCustomCategoryName($row['system_cat']).'</td>';
                        $output .= '<td height="30" align="center">'.$this->getIdByProfileFavCategoryName($sub_cat).'</td>'; 
                        $output .= '<td height="30" align="center">'.$row['order_no'].'</td>';
                        $output .= '</td>'; 
                        $output .= '</tr>'; 
                    $i++; 
                } 
            } 
            else 
            { 
                $output = '<tr class="manage-row" height="30">
                <td colspan="16" align="center">NO RECORDS FOUND</td>
                </tr>'; 
            } 
        $page->get_page_nav(); 
        return $output; 
    }
    //added by ample 17-06-20
    public function getPageDecorData($id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tbl_page_decor` WHERE id ='".$id."' ";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
        }
        return $data;     
    }
    //added by ample 17-06-20
    public function updatePageDecorData($admin_id,$data,$id)
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql="UPDATE `tbl_page_decor` SET 
            `updated_by`='".$admin_id."',`updated_at`='".date('Y-m-d H:i:s')."',`ref_code`='".$data['ref_code']."',`page_type`='".$data['page_type']."',`page_name`='".$data['page_name']."',`page_name_heading`='".$data['page_name_heading']."',`data_source`='".$data['data_source']."',`system_cat`='".$data['system_cat']."',`system_sub_cat`='".$data['system_sub_cat']."',`admin_notes`='".$data['admin_notes']."',`narration`='".$data['narration']."',`order_no`='".$data['order_no']."',`status`='".$data['status']."' WHERE `id`='".$id."'";
        $STH = $DBH->query($sql);
        //print_r($STH);
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }
    // add by ample 17-06-20
    public function deletePageDecor($id="")
    {   
        $admin_id = $_SESSION['admin_id'];  
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $del_sql1 = "UPDATE `tbl_page_decor` SET `is_deleted` =1,`deleted_by`='".$admin_id."',`deleted_at`='".date('Y-m-d H:i:s')."'  WHERE `id` = '".$id."'"; 
        $STH = $DBH->prepare($del_sql1);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
     //create new function for save or update page decor buttons 18-06-20
    public function update_page_decor_buttons($id,$data)
    {
           $this->delete_page_decor_buttons($id);


            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;

                $query = "INSERT INTO `tbl_page_decor_buttons` (`data_id`,`button_category`,`button_name`,`button_heading`,`button_show`,`button_order`,`button_position`,`link`,`ref_table`,`font_color`,`bg_color`,`icon_code`,`narration`) VALUES ";
                $values = '';
                foreach ($data as $key => $value) {
                     $values .= "(".$id.",'".$value['button_category']."','".$value['button_name']."','".$value['button_heading']."','".$value['button_show']."','".$value['button_order']."','".$value['button_position']."','".$value['link']."','".$value['ref_table']."','".$value['font_color']."','".$value['bg_color']."','".$value['icon_code']."','".$value['narration']."'),";
                }
                //$values = rtrim($values, ',');
                $values = substr($values, 0, strlen($values) - 1);
                $insert_query = $query . $values;
                // echo $insert_query;
            // $STH = $DBH->prepare($sql);
            //  $STH->execute();
             $STH = $DBH->query($insert_query);
            // print_r($STH); die('--');
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        return $return;
    }
    //add by ample 18-06-20   
    public function delete_page_decor_buttons($data_id="")
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "DELETE FROM `tbl_page_decor_buttons` WHERE `data_id` = ".$data_id; 
        $STH = $DBH->query($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
    //add by ample 18-06-20    
    function get_button_data_page_decor($data_id="")
    {
        $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $data=array();
            // $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $return=false;
            $sql="SELECT * FROM `tbl_page_decor_buttons` WHERE `data_id`=".$data_id." ORDER BY button_order ASC";
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            }
        return $data;  
    }
    //added by ample 22-06-20
    public function update_DYL_by_PD($DYL_id,$PD_id)
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql="UPDATE `tbl_design_your_life` SET 
            `page_decor_id`='".$PD_id."' WHERE `id`='".$DYL_id."'";
        $STH = $DBH->query($sql);
        //print_r($STH);
        if($STH->rowCount() > 0)
        {   
            $return = true;
                $logsObject = new Logs();
                $logsData = [
                    'page' => 'manage-design-your-life',
                    'reference_id' => $DYL_id
                ];
                $logsObject->insertLogs($logsData);
        }
        return $return;
    }
    //add by ample 10-07-20
    public function add_SMS_credential($admin_id,$data)
    {   

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql = "INSERT INTO `tbl_sms_credentials` (`ADDED_BY`,`SMS_URL`,`SMS_USERNAME`,`SMS_PASSWORD`,`SMS_SENDERID`,`STATUS`,`UPDATE_BY`,`DELETE_BY`) VALUES (".$admin_id.",'".$data['SMS_URL']."','".$data['SMS_USERNAME']."','".$data['SMS_PASSWORD']."','".$data['SMS_SENDERID']."','".$data['STATUS']."',0,0)";

        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {   
            $last_id = $DBH->lastInsertId();
            $return = true;
        }
        return $return;
    }
    //add by ample 10-07-20
    public function get_SMS_credentials() { 
        $my_DBH = new mysqlConnection(); 
        $DBH = $my_DBH->raw_handle(); 
        $DBH->beginTransaction(); 
        $admin_id = $_SESSION['admin_id']; 
        $edit_action_id = '377'; 
        $delete_action_id = '379'; 
        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id); 
        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id); 

        $sql = "SELECT * FROM `tbl_sms_credentials` WHERE DELETED = '0' ORDER BY SMS_ID DESC";  
        $STH = $DBH->prepare($sql); 
        $STH->execute(); 
        $total_records = $STH->rowCount(); 
        $record_per_page = 100; 
        $scroll = 5; 
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true); 
        $page->set_link_parameter("Class = paging"); 
        $page->set_qry_string($str="mode=manage_sms_credentials"); 
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

                        $status=($row['STATUS'] == '1')? "Active" :"Inactive";


                       $output .= '<tr class="manage-row">'; 
                       $output .= '<td height="30" align="center">'.$i.'</td>'; 
                       $output .= '<td height="30" align="center">'.$this->getUsenameOfAdmin($row['ADDED_BY']).'</td>'; 
                       $output .= '<td height="30" align="center">'.date("d-m-Y H:i:s",strtotime($row['ADD_DATE'])).'</td>'; 
                       $output .= '<td align="center" nowrap="nowrap">'; 
                       if($edit) 
                        { 
                            $output .= '<a href="index.php?mode=edit_sms_credential&id='.$row['SMS_ID'].'"><img src="images/edit.gif" border="0"></a>'; 
                        } 
                        $output .= '</td>'; 
                        $output .= '<td align="center" nowrap="nowrap">'; 
                        if($delete) 
                            { 
                                $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delsmscredential.php?id='.$row['SMS_ID'].'")\'><img src="images/del.gif" border="0"></a>'; 
                            } 
                        $output .= '<td height="30" align="center">'.stripslashes($row['SMS_URL']).'</td>'; 
                        $output .= '<td height="30" align="center">'.stripslashes($row['SMS_USERNAME']).'</td>';  
                        $output .= '<td height="30" align="center">'.stripslashes($row['SMS_PASSWORD']).'</td>'; 
                        $output .= '<td height="30" align="center">'.stripslashes($row['SMS_SENDERID']).'</td>';
                        $output .= '<td height="30" align="center">'.$status.'</td>';
                        $output .= '</td>'; 
                        $output .= '</tr>'; 
                    $i++; 
                } 
            } 
            else 
            { 
                $output = '<tr class="manage-row" height="30">
                <td colspan="10" align="center">NO RECORDS FOUND</td>
                </tr>'; 
            } 
        $page->get_page_nav(); 
        return $output; 
    }
    //added by ample 17-06-20
    public function get_SMS_Credential_data($id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tbl_sms_credentials` WHERE SMS_ID ='".$id."' ";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
        }
        return $data;     
    }
    //added by ample 17-06-20
    public function update_SMS_credential($admin_id,$data,$id)
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql="UPDATE `tbl_sms_credentials` SET 
            `UPDATE_BY`='".$admin_id."',`UPDATE_DATE`='".date('Y-m-d H:i:s')."',`SMS_URL`='".$data['SMS_URL']."',`SMS_USERNAME`='".$data['SMS_USERNAME']."',`SMS_PASSWORD`='".$data['SMS_PASSWORD']."',`SMS_SENDERID`='".$data['SMS_SENDERID']."',`STATUS`='".$data['STATUS']."' WHERE `SMS_ID`='".$id."'";
        $STH = $DBH->query($sql);
        //print_r($STH);
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }
    // add by ample 17-06-20
    public function deletesmscredential($id="")
    {   
        $admin_id = $_SESSION['admin_id'];  
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $del_sql1 = "UPDATE `tbl_sms_credentials` SET `DELETED` =1,`DELETE_BY`='".$admin_id."',`DELETE_DATE`='".date('Y-m-d H:i:s')."'  WHERE `SMS_ID` = '".$id."'"; 
        $STH = $DBH->prepare($del_sql1);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
    //add by ample 10-07-20
    public function get_SMS_SENDER_data($SMS_ID)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();   
        $DBH->beginTransaction();
        $option_str = '';       
        $sql = "SELECT * FROM `tbl_sms_credentials` WHERE `DELETED` = '0' AND `STATUS` = '1' ORDER BY `SMS_ID` ASC";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        { 
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {
                if($row['SMS_ID'] == $SMS_ID)
                {
                    $sel = ' selected ';
                }
                else
                {
                    $sel = '';
                }       
                $option_str .= '<option value="'.$row['SMS_ID'].'" '.$sel.'>'.stripslashes($row['SMS_SENDERID']).'</option>';
            }
        }
        return $option_str;
    } 
     //create new function for save or update WSI buttons 31-07-20 & update 07-08-20 & update 26-08-20
    public function update_WSI_buttons($id,$data)
    {
           $this->delete_WSI_buttons($id);

            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;

                $query = "INSERT INTO `tbl_wsi_buttons` (`data_id`,`button_category`,`button_name`,`button_heading`,`button_show`,`button_order`,`link`,`font_color`,`bg_color`,`icon_code`,`narration`,`icon_type`,`icon_source`,`rank_show`,`button_type`,`popup_type`) VALUES ";
                $values = '';
                foreach ($data as $key => $value) {
                     $values .= "(".$id.",'".$value['button_category']."','".$value['button_name']."','".$value['button_heading']."','".$value['button_show']."','".$value['button_order']."','".$value['link']."','".$value['font_color']."','".$value['bg_color']."','".$value['icon_code']."','".$value['narration']."','".$value['icon_type']."','".$value['icon_source']."','".$value['rank_show']."','".$value['button_type']."','".$value['popup_type']."'),";
                }
                $values = substr($values, 0, strlen($values) - 1);
                $insert_query = $query . $values;
             $STH = $DBH->query($insert_query);
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        return $return;
    }
    //add by ample 31-07-20   
    public function delete_WSI_buttons($data_id="")
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "DELETE FROM `tbl_wsi_buttons` WHERE `data_id` = ".$data_id; 
        $STH = $DBH->query($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
    //add by ample 31-07-20    
    function get_button_data_WSI($data_id="")
    {
        $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $data=array();
            $return=false;
            $sql="SELECT * FROM `tbl_wsi_buttons` WHERE `data_id`=".$data_id." ORDER BY button_order ASC";
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            }
        return $data;  
    }

     //add by ample 04-08-20
    public function addCommonButtonSetting($admin_id,$data,$DYL_id="")
    {   

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql = "INSERT INTO `tbl_common_button_setting` (`added_by_admin`,`ref_code`,`page_type`,`page_name`,`admin_comment`) VALUES (".$admin_id.",'".$data['ref_code']."','".$data['page_type']."','".$data['page_name']."','".$data['admin_comment']."')";

        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }
    //added by ample 04-08-20
    public function updateCommonButtonSetting($admin_id,$data,$id)
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql="UPDATE `tbl_common_button_setting` SET 
            `updated_by_admin`='".$admin_id."',`updated_on`='".date('Y-m-d H:i:s')."',`ref_code`='".$data['ref_code']."',`page_type`='".$data['page_type']."',`page_name`='".$data['page_name']."',`admin_comment`='".$data['admin_comment']."',`status`='".$data['status']."' WHERE `id`='".$id."'";
        $STH = $DBH->query($sql);
        //print_r($STH);
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }
    //added by ample 04-08-20
    public function getCommonButtonSettingData($id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tbl_common_button_setting` WHERE id ='".$id."' ";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
        }
        return $data;     
    }
     //add by ample 04-08-20
    public function geCommonButtonSettingListData($search,$status) { 
        $my_DBH = new mysqlConnection(); 
        $DBH = $my_DBH->raw_handle(); 
        $DBH->beginTransaction(); 
        $admin_id = $_SESSION['admin_id']; 
        $edit_action_id = '381'; 
        $delete_action_id = '383'; 
        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id); 
        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id); 
        if($search != '') 
        { 
            $sql_str_search = " AND (admin_comment like '%".$search."%' OR ref_code like '%".$search."%')"; 
        } 
        else 
        {
         $sql_str_search = ""; 
        } 
        if($status != '') 
        { 
            $sql_str_status = " AND status = '".$status."' "; 
        } 
        else 
        { 
            $sql_str_status = ""; 
        } 
        $sql = "SELECT * FROM `tbl_common_button_setting` WHERE is_deleted = '0' ".$sql_str_search." ".$sql_str_status." ORDER BY id DESC";  
        $STH = $DBH->prepare($sql); 
        $STH->execute(); 
        $total_records = $STH->rowCount(); 
        $record_per_page = 100; 
        $scroll = 5; 
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true); 
        $page->set_link_parameter("Class = paging"); 
        $page->set_qry_string($str="mode=common-button-setting"); 
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

                        $status=($row['status'] == '1')? "Active" :"Inactive";

                       $output .= '<tr class="manage-row">'; 
                       $output .= '<td height="30" align="center">'.$i.'</td>'; 
                       $output .= '<td height="30" align="center">'.$status.'</td>'; 
                       $output .= '<td height="30" align="center">'.$this->getUsenameOfAdmin($row['added_by_admin']).'</td>'; 
                       $output .= '<td height="30" align="center">'.date("d-m-Y H:i:s",strtotime($row['added_on'])).'</td>'; 
                       $output .= '<td align="center" nowrap="nowrap">'; 
                       if($edit) 
                        { 
                            $output .= '<a href="index.php?mode=edit-common-button-setting&id='.$row['id'].'"><img src="images/edit.gif" border="0"></a>'; 
                        } 
                        $output .= '</td>'; 
                        $output .= '<td align="center" nowrap="nowrap">'; 
                        if($delete) 
                            { 
                                $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delcommonbuttonsetting.php?id='.$row['id'].'")\'><img src="images/del.gif" border="0"></a>'; 
                            } 
                        $output .= '<td height="30" align="center">'.stripslashes($row['ref_code']).'</td>'; 
                        $output .= '<td height="30" align="center">'.stripslashes($row['admin_comment']).'</td>';  
                        $output .= '<td height="30" align="center">'.$row['page_type'].'</td>';
                        $output .= '<td height="30" align="center">'.$this->getPagenamebyPage_menu_id('30',$row['page_name'],$row['page_type']).'</td>'; 
                        $output .= '</td>'; 
                        $output .= '</tr>'; 
                    $i++; 
                } 
            } 
            else 
            { 
                $output = '<tr class="manage-row" height="30">
                <td colspan="10" align="center">NO RECORDS FOUND</td>
                </tr>'; 
            } 
        $page->get_page_nav(); 
        return $output; 
    }
    // add by ample 04-08-20
    public function delcommonbuttonsetting($id="")
    {   
        $admin_id = $_SESSION['admin_id'];  
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $del_sql1 = "UPDATE `tbl_common_button_setting` SET `is_deleted` =1,`deleted_by_admin`='".$admin_id."',`deleted_on`='".date('Y-m-d H:i:s')."'  WHERE `id` = '".$id."'"; 
        $STH = $DBH->prepare($del_sql1);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
    //create new function for save or update common buttons 31-07-20 & update 07-08-20
    public function update_common_buttons($id,$data)
    {
           $this->delete_common_buttons($id);

            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;

                $query = "INSERT INTO `tbl_common_buttons` (`data_id`,`button_category`,`button_name`,`button_heading`,`button_show`,`button_order`,`link`,`font_color`,`bg_color`,`icon_code`,`narration`,`icon_type`,`icon_source`,`rank_show`,`button_type`,`popup_type`,`banner_type`,`banner`) VALUES ";
                $values = '';
                foreach ($data as $key => $value) {
                     $values .= "(".$id.",'".$value['button_category']."','".$value['button_name']."','".$value['button_heading']."','".$value['button_show']."','".$value['button_order']."','".$value['link']."','".$value['font_color']."','".$value['bg_color']."','".$value['icon_code']."','".$value['narration']."','".$value['icon_type']."','".$value['icon_source']."','".$value['rank_show']."','".$value['button_type']."','".$value['popup_type']."','".$value['banner_type']."','".$value['banner']."'),";
                }
                $values = substr($values, 0, strlen($values) - 1);
                $insert_query = $query . $values;
             $STH = $DBH->query($insert_query);
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        return $return;
    }
    //add by ample 31-07-20   
    public function delete_common_buttons($data_id="")
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "DELETE FROM `tbl_common_buttons` WHERE `data_id` = ".$data_id; 
        $STH = $DBH->query($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
    //add by ample 31-07-20    
    function get_common_buttons_data($data_id="")
    {
        $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $data=array();
            $return=false;
            $sql="SELECT * FROM `tbl_common_buttons` WHERE `data_id`=".$data_id." ORDER BY button_order ASC";
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            }
        return $data;  
    }
    //add by ample 05-08-20
    function get_default_button_data_by_menuID($menu_id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tbl_common_button_setting` WHERE page_name ='".$menu_id."' AND page_type='Menu' AND is_deleted!=1";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            //$data=$row;
            if(!empty($row))
            {
                $data=$this->get_common_buttons_data($row['id']);
            }
        }
        return $data; 
    }
    //create new function for save or update RSS buttons 26-08-20
    public function update_RSS_buttons($id,$data)
    {
           $this->delete_RSS_buttons($id);

            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;

                $query = "INSERT INTO `tbl_rss_buttons` (`data_id`,`button_category`,`button_name`,`button_heading`,`button_show`,`button_order`,`link`,`font_color`,`bg_color`,`icon_code`,`narration`,`icon_type`,`icon_source`,`rank_show`,`button_type`,`popup_type`) VALUES ";
                $values = '';
                foreach ($data as $key => $value) {
                     $values .= "(".$id.",'".$value['button_category']."','".$value['button_name']."','".$value['button_heading']."','".$value['button_show']."','".$value['button_order']."','".$value['link']."','".$value['font_color']."','".$value['bg_color']."','".$value['icon_code']."','".$value['narration']."','".$value['icon_type']."','".$value['icon_source']."','".$value['rank_show']."','".$value['button_type']."','".$value['popup_type']."'),";
                }
                $values = substr($values, 0, strlen($values) - 1);
                $insert_query = $query . $values;
             $STH = $DBH->query($insert_query);
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        return $return;
    }
    //add by ample 26-08-20  
    public function delete_RSS_buttons($data_id="")
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "DELETE FROM `tbl_rss_buttons` WHERE `data_id` = ".$data_id; 
        $STH = $DBH->query($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
    //add by ample 26-08-20   
    function get_button_data_RSS($data_id="")
    {
        $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $data=array();
            $return=false;
            $sql="SELECT * FROM `tbl_rss_buttons` WHERE `data_id`=".$data_id." ORDER BY button_order ASC";
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            }
        return $data;  
    }

    public function getAllFilters(){
        //tbl_design_your_life

         $my_DBH = new mysqlConnection();
         $obj2 = new Contents();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data=array();
        
        $sql="SELECT * FROM `tbl_design_your_life` WHERE is_deleted = '0'";
        $STH = $DBH->query($sql);
        $allOptions = [
            'system_category' => [],
            'profile_category' => [],
            'sub_category' => [],
            'sub2_category' => [],
            'added_by' => [],
            'modified_by' => [],
            'user_upload' => [],
            'page_popup' => []
        ];
        
        $dataReturn = $STH->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($dataReturn)){   
            
            foreach ($dataReturn as $row) {
                $modifiedByData = $this->getModifiedData($row['id']);
                $allOptions['system_category'][$row['data_category']] = $obj2->getDataREFCOde($row['data_category']);
                $allOptions['profile_category'][$row['prof_cat_id']] = $obj2->getProfileCustomCategoryName($row['prof_cat_id']);
                if((int) $row['sub_cat_id']>0){
                    $dtexp = explode(',',$row['sub_cat_id']);
                    foreach($dtexp as $exp){
                         $allOptions['sub_category'][$exp] = $obj2->getIdByProfileFavCategoryName($exp);
                    }
                }
                
                $allOptions['sub2_category'][$row['sub_cat1_show_fetch']] = $row['sub_cat1_show_fetch']; //fetch,sub2,show
                $allOptions['added_by'][$row['added_by']] = $obj2->getUsenameOfAdmin($row['added_by']);
                $allOptions['modified_by'] = $modifiedByData;
                $allOptions['user_upload'][$row['user_upload_show']] = $row['user_upload_show'];
                if(!empty($row['pop_show'])){
                     $allOptions['page_popup'][$row['pop_show']] = $row['pop_show'];
                }
            }

        }
        
        return $allOptions;
    }

    public function getModifiedData($id){
         $obj2 = new Contents();
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $sql="SELECT * FROM `logs` WHERE `reference_id` = $id GROUP BY `updated_by`";
        $STH = $DBH->query($sql);
        $dataUser = [];
        $dataReturn = $STH->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($dataReturn)){   
            foreach ($dataReturn as $row) {
                $dataUser[$row['updated_by']] = $obj2->getUsenameOfAdmin($row['updated_by']);
            }
        }
        return $dataUser;
    }
}
?>