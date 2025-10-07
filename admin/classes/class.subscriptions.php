<?php

include_once("class.paging.php");

include_once("class.admin.php");

include_once("class.banner.php");

class Subscriptions extends Admin

{

	public function GetAllAdviserPlans($search,$apct_id,$status,$country_id,$arr_state_id,$arr_city_id,$arr_place_id,$start_date,$end_date)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '182';

		$delete_action_id = '183';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		$sql = "SELECT * FROM `tbladviserplans` WHERE `ap_deleted` = '0' ";

		

		if($search != '')

		{

			$sql .= " AND `ap_name` like '%".$search."%' ";

		}

		

		if($status != '')

		{

			$sql .= " AND `ap_status` = '".$status."' ";

		}

		

		if(strtotime($start_date) != '' && strtotime($end_date) != '')

		{

			$chk_start_date = date('Y-m-d',strtotime($start_date));

			$chk_end_date = date('Y-m-d',strtotime($end_date));

			

			$sql .= " AND `ap_start_date` <= '".$chk_start_date."' AND `ap_end_date` >= '".$chk_end_date."' ";

		}

		

		if($apct_id != '')

		{

			if($apct_id == '1')

			{

				if($country_id == '' || $country_id == '0')

				{

					$str_sql_country_id = "";

				}

				else

				{

					$str_sql_country_id = " AND `country_id` = '".$country_id."' ";

				}

				

				if(count($arr_state_id) > 0 )

				{

					if($arr_state_id[0] == '')

					{

						$str_sql_state_id = "";

					}

					else

					{

						$str_state_id = implode(',',$arr_state_id);

						$str_sql_state_id = " AND FIND_IN_SET('".$str_state_id."', state_id) ";

					}	

				}

				else

				{

					$str_sql_state_id = "";

				}

				

				if(count($arr_city_id) > 0 )

				{

					if($arr_city_id[0] == '')

					{

						$str_sql_city_id = "";

					}

					else

					{

						$str_city_id = implode(',',$arr_city_id);

						$str_sql_city_id = " AND FIND_IN_SET('".$str_city_id."', city_id) ";

					}	

				}

				else

				{

					$str_sql_city_id = "";

				}

				

				if(count($arr_place_id) > 0 )

				{

					if($arr_place_id[0] == '')

					{

						$str_sql_place_id = "";

					}

					else

					{

						$str_place_id = implode(',',$arr_place_id);

						$str_sql_place_id = " AND FIND_IN_SET('".$str_place_id."', place_id) ";

					}	

				}

				else

				{

					$str_sql_place_id = "";

				}

				

				$sql .= "  ".$str_sql_country_id."  ".$str_sql_state_id."  ".$str_sql_city_id."  ".$str_sql_place_id."  "; 

			}

			else

			{

				$sql = " AND `apct_id` = '".$apct_id."' ";

			}		

		}

		

		$sql .= " ORDER BY ap_add_date DESC";	

		$STH = $DBH->prepare($sql);

                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=adviser_plans");

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

				if($row['ap_status'] == 1)

				{

					 $status = 'Active'; 

				}

				else

				{ 

					$status = 'Inactive';

				}

				

				if($row['ap_show'] == 1)

				{

					 $ap_show = 'Yes'; 

				}

				else

				{ 

					$ap_show = 'No';

				}

				

				if($row['ap_default'] == 1)

				{

					 $ap_default = 'Yes'; 

				}

				else

				{ 

					$ap_default = 'No';

				}

				

				

				if($row['apct_id'] == 0)

				{

					 $apct = 'All';

				}

				else

				{ 

					$obj = new Subscriptions();

					list($apct,$apct_status) = $obj->getAdviserPlanCategoryDetails($row['apct_id']);

				}

				

				if($ap_default == 'Yes')

				{

					$temp_bold_text = 'style="font-weight:bold;" ';

				}

				else

				{ 

					$temp_bold_text = 'style="font-weight:normal;" ';

				}

				

				$output .= '<tr class="manage-row" '.$temp_bold_text.'>';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['ap_name']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['ap_months_duration']).' Months</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['ap_amount']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['ap_currency']).'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';

				$output .= '<td height="30" align="center">'.$ap_show.'</td>';

				$output .= '<td height="30" align="center">'.$ap_default.'</td>';

				$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['ap_add_date'])).'</td>';

				$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['ap_start_date'])).'</td>';

				$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['ap_end_date'])).'</td>';

				$output .= '<td height="30" align="center">'.$apct.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($edit) 

				{

					$output .= '<a href="index.php?mode=edit_adviser_plan&id='.$row['ap_id'].'" ><img src = "images/edit.gif" border="0"></a>';

				}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($delete) 

				{

					$output .= '<a href=\'javascript:fn_confirmdelete("Plans","sql/deladviser_plan.php?id='.$row['ap_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

				}

				$output .= '</td>';

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="14" align="center">NO RECORDS FOUND</td></tr>';

		}

		$page->get_page_nav();

		return $output;

	}

	
	//update 23-11-20
	public function GetAllUserPlans($search,$upct_id,$status)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '192';

		$delete_action_id = '193';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		$sql = "SELECT * FROM `tbluserplans` WHERE `up_deleted` = '0' ";

		

		if($search != '')

		{

			$sql .= " AND `up_name` like '%".$search."%' ";

		}

		

		if($status != '')

		{

			$sql .= " AND `up_status` = '".$status."' ";

		}

		if($upct_id != '')

		{

			$sql .= " AND `upct_id` = '".$upct_id."' ";

		}

		

		$sql .= " ORDER BY up_add_date DESC";		

		$STH = $DBH->prepare($sql);

                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=user_plans");

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

				if($row['up_status'] == 1)

				{

					 $status = 'Active'; 

				}

				else

				{ 

					$status = 'Inactive';

				}

				

				if($row['up_show'] == 1)

				{

					 $up_show = 'Yes'; 

				}

				else

				{ 

					$up_show = 'No';

				}

				

				if($row['up_default'] == 1)

				{

					 $up_default = 'Yes'; 

				}

				else

				{ 

					$up_default = 'No';

				}

				

				if($row['upct_id'] == '0')

				{

					 $upct = 'All';

				}

				else

				{ 

					$obj = new Subscriptions();

					list($upct,$upct_status) = $obj->getUserPlanCategoryDetails($row['upct_id']);

				}

				

				if($up_default == 'Yes')

				{

					$temp_bold_text = 'style="font-weight:bold;" ';

				}

				else

				{ 

					$temp_bold_text = 'style="font-weight:normal;" ';

				}

				$obj2 = new Banner();

				$data=$obj2->getRedirectSchedule($row['up_id'],'userPlans');
				

				$output .= '<tr class="manage-row" '.$temp_bold_text.'>';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($delete) 

				{

					$output .= '<a href=\'javascript:fn_confirmdelete("Plans","sql/deluser_plan.php?id='.$row['up_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

				}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($edit) 

				{

					$output .= '<a href="index.php?mode=edit_user_plan&id='.$row['up_id'].'" ><img src = "images/edit.gif" border="0"></a>';

				}

				$output .= '</td>';


				 $output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['up_add_date'])).'</td>';

				$output .= '<td height="30" align="center">'.$obj2->getUsenameOfAdmin($row['admin_id']).'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';
				

				$output .= '<td height="30" align="center">'.stripslashes($row['up_name']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['up_amount']).'</td>';

				$output .= '<td height="30" align="center">'.$this->getFavCategoryName($row['up_currency']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['up_duration']).' Days</td>';

				

				$output .= '<td height="30" align="center">'.$up_show.'</td>';

				$output .= '<td height="30" align="center">'.$up_default.'</td>';

				$output .= '<td height="30" align="center">'.$upct.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['admin_notes']).' Days</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['narration']).' Days</td>';

				$output .= '<td height="30" align="center">';

                            if(!empty($data))
                            {
                                $output .='<table class="table table-condensed"><thead><tr><th>Schedule</th><th>Location</th></tr></thead><tbody>';
                                foreach ($data as $key => $value) {
                                    
                                    $output .='<tr>';
                                    $output .='<td>';
                                                if($value['publish_date_type']=='single_date')
                                                {
                                                   $output .=date('d-m-Y', strtotime($value['publish_single_date'])); 
                                                }
                                                elseif ($value['publish_date_type']=='date_range') {
                                                   $output .='Start:'.date('d-m-Y', strtotime($value['publish_start_date'])); 
                                                   $output .='<br>End:'.date('d-m-Y', strtotime($value['publish_end_date'])); 
                                                }
                                                elseif ($value['publish_date_type']=='month_wise') {
                                                    $month_wise=explode(',', $value['publish_month_wise']);
                                                    $publish_month_wise=array();
                                                    if(!empty($month_wise))
                                                    {
                                                        foreach ($month_wise as  $mw) {
                                                            $publish_month_wise[]=$obj2->getMonthName($mw);
                                                        }
                                                    }
                                                    $output .=implode(',', $publish_month_wise); 
                                                }
                                                elseif ($value['publish_date_type']=='days_of_week') {
                                                    $week_wise=explode(',', $value['publish_days_of_week']);
                                                    $publish_week_wise=array();
                                                    if(!empty($week_wise))
                                                    {
                                                        foreach ($week_wise as  $ww) {
                                                            $publish_week_wise[]=$obj2->getWeekName($ww);
                                                        }
                                                    }
                                                    $output .=implode(',', $publish_week_wise);
                                                }
                                                elseif ($value['publish_date_type']=='days_of_month') {
                                                    $output .=$value['publish_days_of_month']; 
                                                }
                                    $output .='</td>';
                                    $output .='<td>';
                                                 if(!empty($value['state_id']))   
                                                 {
                                                     $output .='State:' .$obj2->GetStateName($value['state_id']);
                                                 }
                                                 if(!empty($value['city_id']))   
                                                 {
                                                     $output .='<br>City:' .$obj2->GetCityName($value['city_id']);
                                                 }
                                                 if(!empty($value['area_id']))   
                                                 {
                                                     $output .='<br>Area:' .$obj2->GetAreaName($value['area_id']);
                                                 }
                                    $output .='</td>';
                                    $output .='</tr>';
                                }
                                $output .='</tbody></thead></table>';
                            }

                    $output .= '</td>';


				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="16" align="center">NO RECORDS FOUND</td></tr>';

		}

		$page->get_page_nav();

		return $output;

	}

	

	public function getAllUserPlansOptionsMulti($arr_up_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$option_str = '';

		

		$sql = "SELECT * FROM `tbluserplans` WHERE `up_deleted` = '0' AND `up_default` = '0' ORDER BY up_default DESC , up_name ASC";		

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				if(in_array($row['up_id'],$arr_up_id))

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['up_id'].'" '.$sel.'>'.stripslashes($row['up_name']).'</option>';

			}

		}

		return $option_str;

	}

	

	public function getAllAdviserPlansOptionsMulti($arr_ap_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$option_str = '';

		

		$sql = "SELECT * FROM `tbladviserplans` WHERE `ap_deleted` = '0' AND `ap_default` = '0' ORDER BY ap_default DESC , ap_name ASC";		

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				if(in_array($row['ap_id'],$arr_ap_id))

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['ap_id'].'" '.$sel.'>'.stripslashes($row['ap_name']).'</option>';

			}

		}

		return $option_str;

	}

	

	public function GetAllAdviserPlanRequests($search)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '185';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		if($search == '')

		{

			$sql = "SELECT tapr.* , tpu.name , tpu.pro_unique_id, tap.ap_name  FROM `tbladviserplanrequests` AS tapr LEFT JOIN `tblprofusers` AS tpu ON tapr.pro_user_id = tpu.pro_user_id LEFT JOIN `tbladviserplans` AS tap ON tapr.ap_id = tap.ap_id ORDER BY tapr.apr_add_date DESC";

		}

		else

		{

			$sql = "SELECT tapr.* , tpu.name , tpu.pro_unique_id, tap.ap_name  FROM `tbladviserplanrequests` AS tapr LEFT JOIN `tblprofusers` AS tpu ON tapr.pro_user_id = tpu.pro_user_id LEFT JOIN `tbladviserplans` AS tap ON tapr.ap_id = tap.ap_id WHERE tap.ap_name like '%".$search."%' ORDER BY tapr.apr_add_date DESC";

		}		

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=adviser_plan_requests");

	 	$STH = $DBH->prepare($page->get_limit_query($sql));

                $STH->execute();

		$output = '';		

		if($STH->rowCount() > 0)

		{

			if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

			{

				$i = $page->start + 1;

			}

			else

			{

				$i = 1;

			}

			while($row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				if($row['apr_status'] == 1)

				{

					 $status = 'Active'; 

				}

				elseif($row['apr_status'] == 2)

				{

					 $status = 'Rejected'; 

				}

				elseif($row['apr_status'] == 3)

				{

					 $status = 'Inactive'; 

				}

				else

				{ 

					$status = 'Pending';

				}

				

				if($row['apr_responce_date'] == '' || $row['apr_responce_date'] == '0000-00-00 00:00:00')

				{

					$apr_responce_date = ''; 

				}

				else

				{ 

					$apr_responce_date = date('d-m-Y ',strtotime($row['apr_responce_date'])); 

				}

				

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['name']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['pro_unique_id']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['ap_name']).'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';

				$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['apr_add_date'])).'</td>';

				$output .= '<td height="30" align="center">'.$apr_responce_date.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($edit) 

				{

					$output .= '<a href="index.php?mode=edit_adviser_plan_request&id='.$row['apr_id'].'" ><img src = "images/edit.gif" border="0"></a>';

				}

				$output .= '</td>';

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';

		}

		$page->get_page_nav();

		return $output;

	}

	

	public function GetAllUserPlanRequests($search)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '195';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		if($search == '')

		{

			$sql = "SELECT tupr.* , tu.name , tu.unique_id, tup.up_name  FROM `tbluserplanrequests` AS tupr LEFT JOIN `tblusers` AS tu ON tupr.user_id = tu.user_id LEFT JOIN `tbluserplans` AS tup ON tupr.up_id = tup.up_id ORDER BY tupr.upr_add_date DESC";

		}

		else

		{

			$sql = "SELECT tupr.* , tu.name , tu.unique_id, tup.up_name  FROM `tbluserplanrequests` AS tupr LEFT JOIN `tblusers` AS tu ON tupr.user_id = tu.user_id LEFT JOIN `tbluserplans` AS tup ON tupr.up_id = tup.up_id WHERE tup.up_name like '%".$search."%' ORDER BY tupr.upr_add_date DESC";

		}		

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=user_plan_requests");

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

				if($row['upr_status'] == 1)

				{

					 $status = 'Active'; 

				}

				elseif($row['upr_status'] == 2)

				{

					 $status = 'Rejected'; 

				}

				elseif($row['upr_status'] == 3)

				{

					 $status = 'Inactive'; 

				}

				else

				{ 

					$status = 'Pending';

				}

				

				if($row['upr_responce_date'] == '' || $row['upr_responce_date'] == '0000-00-00 00:00:00')

				{

					$upr_responce_date = ''; 

				}

				else

				{ 

					$upr_responce_date = date('d-m-Y ',strtotime($row['upr_responce_date'])); 

				}

				

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['name']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['unique_id']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['up_name']).'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';

				$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['upr_add_date'])).'</td>';

				$output .= '<td height="30" align="center">'.$upr_responce_date.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($edit) 

				{

					$output .= '<a href="index.php?mode=edit_user_plan_request&id='.$row['upr_id'].'" ><img src = "images/edit.gif" border="0"></a>';

				}

				$output .= '</td>';

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';

		}

		$page->get_page_nav();

		return $output;

	}



	public function addAdviserPlan($ap_name,$ap_months_duration,$ap_amount,$ap_currency,$ap_default,$arr_apa_id,$arr_apa_value,$arr_apc_id,$arr_apc_value,$ap_start_date,$ap_end_date,$apct_id,$country_id,$str_state_id,$str_city_id,$str_place_id,$ap_criteria_from,$ap_criteria_to,$ap_show)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "INSERT INTO `tbladviserplans`(`ap_name`,`ap_months_duration`,`ap_amount`,`ap_currency`,`ap_status`,`ap_default`,`ap_start_date`,`ap_end_date`,`apct_id`,`country_id`,`state_id`,`city_id`,`place_id`,`ap_criteria_from`,`ap_criteria_to`,`ap_show`) VALUES ('".addslashes($ap_name)."','".addslashes($ap_months_duration)."','".addslashes($ap_amount)."','".addslashes($ap_currency)."','1','".addslashes($ap_default)."','".addslashes($ap_start_date)."','".addslashes($ap_end_date)."','".addslashes($apct_id)."','".addslashes($country_id)."','".addslashes($str_state_id)."','".addslashes($str_city_id)."','".addslashes($str_place_id)."','".addslashes($ap_criteria_from)."','".addslashes($ap_criteria_to)."','".addslashes($ap_show)."')";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

			$ap_id = $DBH->lastInsertId();

			if($ap_default == '1')

			{

				$upd_sql = "UPDATE `tbladviserplans` SET `ap_default` = '0' , `ap_status` = '0' , `ap_status_reason` = 'Inactivated due to new default plan' WHERE `ap_id` != '".$ap_id."' AND `ap_default` = '1'";

				$STH = $DBH->prepare($upd_sql);

                                $STH->execute();

				

				$upd_sql = "UPDATE `tbladviserplans` SET `ap_default` = '0' WHERE `ap_id` != '".$ap_id."'";

				$STH1 = $DBH->prepare($upd_sql);

                                $STH1->execute();

			}

			

			for($i=0;$i<count($arr_apa_id);$i++)

			{

				$sql2 = "INSERT INTO `tbladviserplandetails` (`ap_id`,`apa_id`,`apa_value`,`apc_id`,`apc_value`,`apd_status`) VALUES ('".$ap_id."','".$arr_apa_id[$i]."','".addslashes($arr_apa_value[$i])."','".addslashes($arr_apc_id[$i])."','".addslashes($arr_apc_value[$i])."','1')";

				$STH2 = $DBH->prepare($sql2);

                                $STH2->execute();

			}	

			

			for($i=0;$i<count($arr_apa_id);$i++)

			{

				if($arr_apa_value[$i] == '1' && $ap_default == '1')

				{

					$sql3 = "UPDATE `tbladviserplandetails` SET `apa_value` = '".addslashes($arr_apa_value[$i])."' ";

					if($arr_apc_id[$i] != '')

					{

						$sql3 .= ",`apc_id` = '".addslashes($arr_apc_id[$i])."' ";

					}	

					$sql3 .= " WHERE `apa_id` = '".$arr_apa_id[$i]."' AND `apd_status` = '1' AND `apd_deleted` = '0' ";

					$STH3 = $DBH->prepare($sql3);

                                        $STH3->execute();

				}	

			}	

		}

		

		return $return;

	}

	
	//update by ample 20-11-20,23-11-20
	public function addUserPlan($up_name,$up_amount,$up_points,$up_currency,$up_duration,$up_default,$arr_upa_id,$arr_upa_value,$arr_upc_id,$arr_upc_value,$upct_id,$up_show,$admin_notes,$narration,$prize_heading,$prize_list,$reports)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		$admin_id = $_SESSION['admin_id']; 

		$sql = "INSERT INTO `tbluserplans`(`admin_id`,`up_name`,`up_amount`,`up_points`,`up_currency`,`up_duration`,`up_status`,`up_default`,`upct_id`,`up_show`,`admin_notes`,`narration`,`prize_heading`,`prize_list`) VALUES (".$admin_id.",'".addslashes($up_name)."','".addslashes($up_amount)."','".addslashes($up_points)."','".addslashes($up_currency)."','".addslashes($up_duration)."','1','".addslashes($up_default)."','".addslashes($upct_id)."','".addslashes($up_show)."','".addslashes($admin_notes)."','".addslashes($narration)."','".addslashes($prize_heading)."','".addslashes($prize_list)."')";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

		

			$return = true;

			$up_id = $DBH->lastInsertId();

			if($up_default == '1')

			{

				$upd_sql = "UPDATE `tbluserplans` SET `up_default` = '0' , `up_status` = '0' , `up_status_reason` = 'Inactivated due to new default plan' WHERE `up_id` != '".$up_id."' AND `up_default` = '1'";

				$STH = $DBH->prepare($upd_sql);

                                $STH->execute();

				

				$upd_sql = "UPDATE `tbluserplans` SET `up_default` = '0' WHERE `up_id` != '".$up_id."'";

				$STH1 = $DBH->prepare($upd_sql);

                                $STH1->execute();

                                

                                $upd_user_sql = "UPDATE `tblusers` SET `up_id` = '".$up_id."' WHERE `is_up_default` != '0' ";

				$STH5 = $DBH->prepare($upd_user_sql);

                                $STH5->execute();

			}

			

			for($i=0;$i<count($arr_upa_id);$i++)

			{

				$sql2 = "INSERT INTO `tbluserplandetails` (`up_id`,`upa_id`,`upa_value`,`upc_id`,`upc_value`,`upd_status`) VALUES ('".$up_id."','".$arr_upa_id[$i]."','".addslashes($arr_upa_value[$i])."','".addslashes($arr_upc_id[$i])."','".addslashes($arr_upc_value[$i])."','1')";

				$STH2 = $DBH->prepare($sql2);

                                $STH2->execute();

			}

			for($i=0;$i<count($reports['rep_cat_id']);$i++)

			{

				$sql3 = "INSERT INTO `tbluserplandetails` (`up_id`,`upa_id`,`upa_value`,`upc_id`,`upc_value`,`upd_status`,`is_report_data`) VALUES ('".$up_id."','".$reports['rep_page_id'][$i]."','".$reports['rep_check'][$i]."','".$reports['rep_cat_id'][$i]."','".trim($reports['rep_value'][$i])."','1','1')";

				$STH3 = $DBH->prepare($sql3);

                                $STH3->execute();

			}


			

//			for($i=0;$i<count($arr_upa_id);$i++)

//			{

//				if($arr_upa_value[$i] == '1' && $up_default == '1')

//				{

//					$sql3 = "UPDATE `tbluserplandetails` SET `upa_value` = '".addslashes($arr_upa_value[$i])."' ";

//					if($arr_upc_id[$i] != '')

//					{

//						$sql3 .= ",`upc_id` = '".addslashes($arr_upc_id[$i])."' ";

//					}	

//					$sql3 .= " WHERE `upa_id` = '".$arr_upa_id[$i]."' AND `upd_status` = '1' AND `upd_deleted` = '0' ";

//					$STH3 = $DBH->prepare($sql3);

//                                        $STH3->execute();

//				}	

//			}	

		}

		

		return $return;

	}

	

	public function updateAdviserPlan($ap_id,$ap_name,$ap_months_duration,$ap_amount,$ap_currency,$ap_default,$ap_status,$arr_apa_id,$arr_apa_value,$arr_apc_id,$arr_apc_value,$ap_start_date,$ap_end_date,$apct_id,$country_id,$str_state_id,$str_city_id,$str_place_id,$ap_criteria_from,$ap_criteria_to,$ap_show)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "UPDATE `tbladviserplans` SET `ap_name` = '".addslashes($ap_name)."' ,`ap_months_duration` = '".addslashes($ap_months_duration)."' ,`ap_amount` = '".addslashes($ap_amount)."' ,`ap_currency` = '".addslashes($ap_currency)."' , `ap_status` = '".addslashes($ap_status)."' , `ap_start_date` = '".addslashes($ap_start_date)."' , `ap_end_date` = '".addslashes($ap_end_date)."' , `apct_id` = '".addslashes($apct_id)."' , `country_id` = '".addslashes($country_id)."' , `state_id` = '".addslashes($str_state_id)."' , `city_id` = '".addslashes($str_city_id)."' , `place_id` = '".addslashes($str_place_id)."' , `ap_criteria_from` = '".addslashes($ap_criteria_from)."' , `ap_criteria_to` = '".addslashes($ap_criteria_to)."', `ap_show` = '".addslashes($ap_show)."' WHERE `ap_id` = '".$ap_id."'";

	    //echo '<br>'.$sql;

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->result)

		{

			$return = true;

			

			/*if($ap_default == '1')

			{

				$upd_sql = "UPDATE `tbladviserplans` SET `ap_default` = '0' WHERE `ap_id` != '".$ap_id."'";

				//echo '<br>'.$upd_sql;

				$this->execute_query($upd_sql);

			}

			

			

			$del_sql1 = "UPDATE `tbladviserplandetails` SET  `apd_status` = '0' WHERE `ap_id` = '".$ap_id."' "; 

			//echo '<br>'.$del_sql1;

			$this->execute_query($del_sql1);

						

			for($i=0;$i<count($arr_apa_id);$i++)

			{

				$sql2 = "INSERT INTO `tbladviserplandetails` (`ap_id`,`apa_id`,`apa_value`,`apc_id`,`apc_value`,`apd_status`) VALUES ('".$ap_id."','".$arr_apa_id[$i]."','".addslashes($arr_apa_value[$i])."','".addslashes($arr_apc_id[$i])."','".addslashes($arr_apc_value[$i])."','1')";

				$STH = $DBH->prepare($sql2);  $STH->execute();

			}	*/

		}

		return $return;

	}

	
	//update by ample 20-11-20,23-11-20
	public function updateUserPlan($up_id,$up_name,$up_amount,$up_points,$up_currency,$up_duration,$up_default,$up_status,$arr_upa_id,$arr_upa_value,$arr_upc_id,$arr_upc_value,$upct_id,$up_show,$admin_notes,$narration,$prize_heading,$prize_list)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "UPDATE `tbluserplans` SET `up_name` = '".addslashes($up_name)."' ,`up_amount` = '".addslashes($up_amount)."' ,`up_points` = '".addslashes($up_points)."', `up_currency` = '".addslashes($up_currency)."',`up_duration` = '".addslashes($up_duration)."',`up_default` = '".addslashes($up_default)."'  , `up_status` = '".addslashes($up_status)."' , `upct_id` = '".addslashes($upct_id)."'  , `up_show` = '".addslashes($up_show)."' , `admin_notes` = '".addslashes($admin_notes)."' , `narration` = '".addslashes($narration)."' , `prize_heading` = '".addslashes($prize_heading)."' , `prize_list` = '".addslashes($prize_list)."' , `up_edit_date` = '".date('Y-m-d H:i:s')."' WHERE `up_id` = '".$up_id."'";

	    //echo '<br>'.$sql;

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)
		{

			$return = true;


			if($up_default == '1')

			{

				$upd_sql = "UPDATE `tbluserplans` SET `up_default` = '0' , `up_status` = '0' , `up_status_reason` = 'Inactivated due to new default plan' WHERE `up_id` != '".$up_id."' AND `up_default` = '1'";

				$STH = $DBH->prepare($upd_sql);

                                $STH->execute();

				

				$upd_sql = "UPDATE `tbluserplans` SET `up_default` = '0' WHERE `up_id` != '".$up_id."'";

				$STH1 = $DBH->prepare($upd_sql);

                                $STH1->execute();

                                

                                $upd_user_sql = "UPDATE `tblusers` SET `up_id` = '".$up_id."' WHERE `is_up_default` != '0' ";

				$STH5 = $DBH->prepare($upd_user_sql);

                                $STH5->execute();

			}

			
			/*if($up_default == '1')

			{

				$upd_sql = "UPDATE `tbluserplans` SET `up_default` = '0' WHERE `up_id` != '".$up_id."'";

				//echo '<br>'.$upd_sql;

				$this->execute_query($upd_sql);

			}

			

			

			$del_sql1 = "UPDATE `tbluserplandetails` SET  `upd_status` = '0' WHERE `up_id` = '".$up_id."' "; 

			//echo '<br>'.$del_sql1;

			$this->execute_query($del_sql1);

						

			for($i=0;$i<count($arr_upa_id);$i++)

			{

				$sql2 = "INSERT INTO `tbluserplandetails` (`up_id`,`upa_id`,`upa_value`,`upc_id`,`upc_value`,`upd_status`) VALUES ('".$up_id."','".$arr_upa_id[$i]."','".addslashes($arr_upa_value[$i])."','".addslashes($arr_upc_id[$i])."','".addslashes($arr_upc_value[$i])."','1')";

				$STH = $DBH->prepare($sql2);  $STH->execute();

			}	*/

		}

		return $return;

	}

	

	public function updateAdviserPlanRequest($apr_id,$apr_status,$uap_payment_status,$uap_payment_mode,$uap_payment_details)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = true;

		

		list($pu_name,$pro_user_id,$ap_id,$ap_name,$ap_months_duration,$ap_amount,$ap_currency,$apr_status2,$uap_id,$uap_amount,$uap_currency,$uap_start_date,$uap_end_date,$uap_status,$uap_payment_status2,$uap_payment_mode2,$uap_payment_details2,$apr_add_date,$apr_responce_date) = $this->getAdviserPlanRequestDetails($apr_id);

		

		if($apr_status2 == '0' && $apr_responce_date == '0000-00-00 00:00:00')

		{

			$uap_start_date = date('Y-m-d H:i:s');

			$uap_end_date = date('Y-m-d H:i:s' ,strtotime('+'.$ap_months_duration.' months'));

		

			$sql = "UPDATE `tblprofusers` SET `ap_id` = '".addslashes($ap_id)."' ,`uap_amount` = '".addslashes($ap_amount)."' ,`uap_currency` = '".addslashes($ap_currency)."' , `uap_start_date` = '".addslashes($uap_start_date)."' , `uap_end_date` = '".addslashes($uap_end_date)."' WHERE `pro_user_id` = '".$pro_user_id."'";

			//echo '<br>'.$sql;

			$STH = $DBH->prepare($sql);

                        $STH->execute();

			

			$sql2 = "UPDATE `tbladviserplanrequests` SET `apr_status` = '".addslashes($apr_status)."', `apr_responce_date` = '".addslashes($uap_start_date)."',`uap_amount` = '".addslashes($ap_amount)."' ,`uap_currency` = '".addslashes($ap_currency)."' , `uap_start_date` = '".addslashes($uap_start_date)."' , `uap_end_date` = '".addslashes($uap_end_date)."',`uap_payment_status` = '".addslashes($uap_payment_status)."' ,`uap_payment_mode` = '".addslashes($uap_payment_mode)."' , `uap_payment_details` = '".addslashes($uap_payment_details)."' WHERE `apr_id` = '".$apr_id."'";

			//echo '<br>'.$sql;

			$STH1 = $DBH->prepare($sql2);

                        $STH1->execute();

		

		}

		

		$sql2 = "UPDATE `tblprofusers` SET `uap_status` = '".addslashes($apr_status)."' ,`uap_payment_status` = '".addslashes($uap_payment_status)."' ,`uap_payment_mode` = '".addslashes($uap_payment_mode)."' , `uap_payment_details` = '".addslashes($uap_payment_details)."' WHERE `pro_user_id` = '".$pro_user_id."'";

		//echo '<br>'.$sql;

		$STH2 = $DBH->prepare($sql2);

                $STH2->execute();

		

		$sql3 = "UPDATE `tbladviserplanrequests` SET `apr_status` = '".addslashes($apr_status)."' WHERE `apr_id` = '".$apr_id."'";

		//echo '<br>'.$sql;

		$STH3 = $DBH->prepare($sql3);

                $STH3->execute();

		

		return $return;

	}

	

	public function updateUserPlanRequest($upr_id,$upr_status,$uup_payment_status,$uup_payment_mode,$uup_payment_details)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = true;

		

		list($pu_name,$user_id,$up_id,$up_name,$up_duration,$up_amount,$up_currency,$upr_status2,$uup_id,$uup_amount,$uup_currency,$uup_start_date,$uup_end_date,$uup_status,$uup_payment_status2,$uup_payment_mode2,$uup_payment_details2,$upr_add_date,$upr_responce_date,$uup_points,$plan_prize_id) = $this->getUserPlanRequestDetails($upr_id);


			$upr_responce_date=date('Y-m-d H:i:s');
			$uup_start_date = date('Y-m-d H:i:s');
			$uup_end_date = date('Y-m-d H:i:s' ,strtotime('+'.$up_duration.' day'));

			if($upr_status==1)
			{

				$sql = "UPDATE `tblusers` SET `up_id` = '".addslashes($up_id)."' , `uup_start_date` = '".addslashes($uup_start_date)."' , `uup_end_date` = '".addslashes($uup_end_date)."', `is_up_default`='0',`uup_status`='1' WHERE `user_id` = '".$user_id."'";
				$STH = $DBH->prepare($sql);
	            $STH->execute();

	            $sql2 = "UPDATE `tbluserplanrequests` SET `upr_status` = '".addslashes($upr_status)."', `upr_responce_date` = '".addslashes($upr_responce_date)."',`uup_amount` = '".addslashes($up_amount)."' ,`uup_currency` = '".addslashes($up_currency)."' , `uup_start_date` = '".addslashes($uup_start_date)."' , `uup_end_date` = '".addslashes($uup_end_date)."',`uup_payment_status` = '".addslashes($uup_payment_status)."' ,`uup_payment_mode` = '".addslashes($uup_payment_mode)."' , `uup_payment_details` = '".addslashes($uup_payment_details)."' WHERE `upr_id` = '".$upr_id."'";
					$STH1 = $DBH->prepare($sql2);
                    $STH1->execute();

               
               	$uniqu_id=uniqid();
                if(!empty($uup_points))
                {	
                	$plan_data=$this->get_user_plan_data($up_id);

                	$user_points=$this->get_user_points($user_id);
                    $user_points=$user_points+$uup_points;
                	
                    $new_data = array( 'user_id' => $user_id,
                                        'reward_module_id'=>'40', //subcription plan module
                                        'points'=>$uup_points,
                                        'transaction_type'=>'Credit',
                                        'reward_scheme_type'=>'reward_plan',
                                        'reward_scheme_id'=>$up_id,
                                        'remark'=>'Plan Point ('.$plan_data['up_name'].')',
                                        'transection_no'=>$uniqu_id,
                                        'balance'=>$user_points
                                     );

                    $res=$this->added_reward_history($new_data);
                    if($res==true)
                    {
                        $this->update_user_points($user_id,$user_points);
                    }
                }

                if(!empty($plan_prize_id))
                {	
                	$prize_data=$this->get_reward_prize_data($plan_prize_id);
                	$plan_data=$this->get_user_plan_data($up_id);
                	$user_points=$this->get_user_points($user_id);
                    $new_data = array( 'user_id' => $user_id,
                                        'reward_module_id'=>'40', //subcription plan module
                                        'points'=>'0',
                                        'transaction_type'=>'Credit',
                                        'reward_scheme_type'=>'reward_prize',
                                        'reward_scheme_id'=>$plan_prize_id,
                                        'remark'=>'Plan Prize ('.$plan_data['up_name'].')',
                                        'transection_no'=>$uniqu_id,
                                        'balance'=>$user_points
                                     );

                    $res=$this->added_reward_history($new_data);
                }

			}
			else
			{
				$sql = "UPDATE `tblusers` SET `uup_status`='0' WHERE `user_id` = '".$user_id."' AND `up_id` = '".$up_id."'";
				$STH = $DBH->prepare($sql);
	            $STH->execute();

	            $sql2 = "UPDATE `tbluserplanrequests` SET `upr_status` = '".addslashes($upr_status)."', `upr_responce_date` = '".addslashes($upr_responce_date)."',`uup_amount` = '".addslashes($up_amount)."' ,`uup_currency` = '".addslashes($up_currency)."' ,`uup_payment_status` = '".addslashes($uup_payment_status)."' ,`uup_payment_mode` = '".addslashes($uup_payment_mode)."' , `uup_payment_details` = '".addslashes($uup_payment_details)."' WHERE `upr_id` = '".$upr_id."'";
				$STH1 = $DBH->prepare($sql2);
                $STH1->execute();
			}

		return $return;

	}

	

	public function getAdviserPlanDetails($ap_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$ap_name = '';

		$ap_months_duration = '';

		$ap_amount = '';

		$ap_currency = '';

		$ap_status = '';

		$ap_default = '';

		$ap_start_date = '';

		$ap_end_date = '';

		$apct_id = '';

		$country_id = '';

		$state_id = '';

		$city_id = '';

		$place_id = '';

		$ap_criteria_from = '';

		$ap_criteria_to = '';

		$ap_show = '';

		

		$arr_apa_id = array();

		$arr_apa_name = array();

		$arr_apa_value = array();

		$arr_apc_id = array();

		$arr_apc_value = array();

				

		$sql = "SELECT * FROM `tbladviserplans` WHERE `ap_id` = '".$ap_id."' AND `ap_deleted` = '0'";

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$ap_name = stripslashes($row['ap_name']);

			$ap_months_duration = stripslashes($row['ap_months_duration']);

			$ap_amount = stripslashes($row['ap_amount']);

			$ap_currency = stripslashes($row['ap_currency']);

			$ap_status = stripslashes($row['ap_status']);

			$ap_default = stripslashes($row['ap_default']);

			$ap_start_date = stripslashes($row['ap_start_date']);

			$ap_end_date = stripslashes($row['ap_end_date']);

			$apct_id = stripslashes($row['apct_id']);

			$country_id = stripslashes($row['country_id']);

			$state_id = stripslashes($row['state_id']);

			$city_id = stripslashes($row['city_id']);

			$place_id = stripslashes($row['place_id']);

			$ap_criteria_from = stripslashes($row['ap_criteria_from']);

			$ap_criteria_to = stripslashes($row['ap_criteria_to']);

			$ap_show = stripslashes($row['ap_show']);

			

			$sql2 = "SELECT tapd.* , tapa.apa_name FROM `tbladviserplandetails` AS tapd LEFT JOIN `tbladviserplanatributes` AS tapa ON tapd.apa_id = tapa.apa_id WHERE tapd.ap_id = '".$ap_id."' AND tapd.apd_status = '1' AND tapd.apd_deleted = '0' ORDER BY tapa.apa_name";

			$STH = $DBH->prepare($sql2); 

                        $STH->execute();

			if($STH->rowCount() > 0)

			{

				while($row2= $STH->fetch(PDO::FETCH_ASSOC))

				{

					array_push($arr_apa_id , $row2['apa_id']);

					array_push($arr_apa_name , stripslashes($row2['apa_name']));

					array_push($arr_apa_value , stripslashes($row2['apa_value']));

					array_push($arr_apc_id , $row2['apc_id']);

					array_push($arr_apc_value , stripslashes($row2['apc_value']));

				}

			}

			else

			{

				$sql2 = "SELECT * FROM `tbladviserplanatributes` WHERE `apa_status` = '1' AND `show_for_adviser` = '1' ORDER BY `apa_name`";

				$STH = $DBH->prepare($sql2);

                                $STH->execute();

				if($STH->rowCount() > 0)

				{

					while($row2= $STH->fetch(PDO::FETCH_ASSOC))

					{

						array_push($arr_apa_id , $row2['apa_id']);

						array_push($arr_apa_name , stripslashes($row2['apa_name']));

						array_push($arr_apa_value , '');

						array_push($arr_apc_id , '0');

						array_push($arr_apc_value , '');

					}

				}

			}

		}

		return array($ap_name,$ap_months_duration,$ap_amount,$ap_currency,$ap_status,$ap_default,$arr_apa_id,$arr_apa_name,$arr_apa_value,$arr_apc_id,$arr_apc_value,$ap_start_date,$ap_end_date,$apct_id,$country_id,$state_id,$city_id,$place_id,$ap_criteria_from,$ap_criteria_to,$ap_show);

	}

	
	//update by ample 20-11-20,23-11-20,09-12-20
	public function getUserPlanDetails($up_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$up_name = '';

		$up_amount = '';
		$up_points = '';
		$up_currency = '';

		$up_duration='';

		$up_status = '';

		$up_default = '';

		$upct_id = '';

		$up_show = '';

		$admin_notes='';
		$narration='';

		$prize_heading="";
		$prize_list='';

		$arr_upa_id = array();

		$arr_upa_name = array();

		$arr_upa_value = array();

		$arr_upc_id = array();

		$arr_upc_value = array();

				

		$sql = "SELECT * FROM `tbluserplans` WHERE `up_id` = '".$up_id."' AND `up_deleted` = '0'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$up_name = stripslashes($row['up_name']);

			$up_amount = stripslashes($row['up_amount']); 

			$up_points = stripslashes($row['up_points']);

			$up_currency = stripslashes($row['up_currency']);

			$up_duration = stripslashes($row['up_duration']);

			$up_status = stripslashes($row['up_status']);

			$up_default = stripslashes($row['up_default']);

			$upct_id = stripslashes($row['upct_id']);

			$up_show = stripslashes($row['up_show']);

			//add by ample 24/11/20
			$admin_notes=stripslashes($row['admin_notes']);
			$narration=stripslashes($row['narration']);

			$prize_heading=stripslashes($row['prize_heading']);
			$prize_list=stripslashes($row['prize_list']);

			$sql2 = "SELECT * FROM `tbluserplandetails` AS tupd  WHERE tupd.up_id = '".$up_id."' AND tupd.upd_status = '1' AND tupd.upd_deleted = '0' AND is_report_data='0' ORDER BY tupd.upd_id";

			$STH = $DBH->prepare($sql2);

                        $STH->execute();

			if($STH->rowCount() > 0)

			{

				while($row2= $STH->fetch(PDO::FETCH_ASSOC))

				{

					array_push($arr_upa_id , $row2['upa_id']);

					array_push($arr_upa_name , $this->get_PageName($row2['upa_id']));

					array_push($arr_upa_value , stripslashes($row2['upa_value']));

					array_push($arr_upc_id , $row2['upc_id']);

					array_push($arr_upc_value , stripslashes($row2['upc_value']));

				}

			}

			else

			{

				//$sql2 = "SELECT * FROM `tbladviserplanatributes` WHERE `apa_status` = '1' AND `show_for_user` = '1' ORDER BY `apa_name`";

				$sql2 = "SELECT * FROM `tblpagedropdowns` WHERE `pd_status` = '1' AND `pd_deleted`='0' AND pd_id=21";

				$STH = $DBH->prepare($sql2);

                                $STH->execute();

				if($STH->rowCount() > 0)

				{


					$row2 = $STH->fetch(PDO::FETCH_ASSOC);


					if(!empty($row2['page_id_str']))
					{
						$page_ids=explode(',', $row2['page_id_str']);

						foreach ($page_ids as $key => $value) {

							array_push($arr_apa_id , $value);

							array_push($arr_apa_name , $this->get_PageName($value));

							array_push($arr_upa_value , '');

							array_push($arr_upc_id , '0');

							array_push($arr_upc_value , '');

							
						}

					}

				}

			}

		}

		return array($up_name,$up_amount,$up_points,$up_currency,$up_duration,$up_status,$up_default,$arr_upa_id,$arr_upa_name,$arr_upa_value,$arr_upc_id,$arr_upc_value,$upct_id,$up_show,$admin_notes,$narration,$prize_heading,$prize_list);

	}

	

	public function getAdviserPlanRequestDetails($apr_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$pu_name = '';

		$pro_user_id = '';

		$ap_id = '';

		$ap_name = '';

		$ap_months_duration = '';

		$ap_amount = '';

		$ap_currency = '';

		$apr_status = '';

		$uap_id = '';

		$uap_amount = '';

		$uap_currency = '';

		$uap_start_date = '';

		$uap_end_date = '';

		$uap_status = '';

		$uap_payment_status = '0';

		$uap_payment_mode = '';

		$uap_payment_details = '';

		$apr_add_date = '';

		$apr_responce_date = '0000-00-00 00:00:00';

				

		//$sql = "SELECT tapr.* , tpu.* , tpu.pro_unique_id, tap.*  FROM `tbladviserplanrequests` AS tapr LEFT JOIN `tblprofusers` AS tpu ON tapr.pro_user_id = tpu.pro_user_id LEFT JOIN `tbladviserplans` AS tap ON tapr.ap_id = tap.ap_id WHERE tapr.apr_id = '".$apr_id."' ";

		$sql = "SELECT tapr.* , tpu.name, tpu.pro_unique_id, tap.*  FROM `tbladviserplanrequests` AS tapr LEFT JOIN `tblprofusers` AS tpu ON tapr.pro_user_id = tpu.pro_user_id LEFT JOIN `tbladviserplans` AS tap ON tapr.ap_id = tap.ap_id WHERE tapr.apr_id = '".$apr_id."' ";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$pu_name = stripslashes($row['name']);

			$pro_user_id = stripslashes($row['pro_user_id']);

			$ap_id = stripslashes($row['ap_id']);

			$ap_name = stripslashes($row['ap_name']);

			$ap_months_duration = stripslashes($row['ap_months_duration']);

			$ap_amount = stripslashes($row['ap_amount']);

			$ap_currency = stripslashes($row['ap_currency']);

			$apr_status = stripslashes($row['apr_status']);

			$uap_id = stripslashes($row['ap_id']);

			$uap_amount = stripslashes($row['uap_amount']);

			$uap_currency = stripslashes($row['uap_currency']);

			$uap_start_date = stripslashes($row['uap_start_date']);

			$uap_end_date = stripslashes($row['uap_end_date']);

			$uap_status = stripslashes($row['uap_status']);

			$uap_payment_status = stripslashes($row['uap_payment_status']);

			$uap_payment_mode = stripslashes($row['uap_payment_mode']);

			$uap_payment_details = stripslashes($row['uap_payment_details']);

			$apr_add_date = stripslashes($row['apr_add_date']);

			$apr_responce_date = stripslashes($row['apr_responce_date']);

			

		}

		return array($pu_name,$pro_user_id,$ap_id,$ap_name,$ap_months_duration,$ap_amount,$ap_currency,$apr_status,$uap_id,$uap_amount,$uap_currency,$uap_start_date,$uap_end_date,$uap_status,$uap_payment_status,$uap_payment_mode,$uap_payment_details,$apr_add_date,$apr_responce_date);

	}

	

	public function getUserPlanRequestDetails($upr_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$name = '';

		$user_id = '';

		$up_id = '';

		$up_name = '';

		$up_duration = '';

		$up_amount = '';

		$up_currency = '';

		$upr_status = '';

		$uup_id = '';

		$uup_amount = '';

		$uup_currency = '';

		$uup_start_date = '';

		$uup_end_date = '';

		$uup_status = '';

		$uup_payment_status = '0';

		$uup_payment_mode = '';

		$uup_payment_details = '';

		$upr_add_date = '';

		$upr_responce_date = '0000-00-00 00:00:00';

		//add date 11-12-20
		$uup_points = '';
		$plan_prize_id = '';

				

		$sql = "SELECT tupr.* , tu.name, tu.unique_id, tup.*  FROM `tbluserplanrequests` AS tupr LEFT JOIN `tblusers` AS tu ON tupr.user_id = tu.user_id LEFT JOIN `tbluserplans` AS tup ON tupr.up_id = tup.up_id WHERE tupr.upr_id = '".$upr_id."' ";

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$name = stripslashes($row['name']);

			$user_id = stripslashes($row['user_id']);

			$up_id = stripslashes($row['up_id']);

			$up_name = stripslashes($row['up_name']);

			$up_duration = stripslashes($row['up_duration']);

			$up_amount = stripslashes($row['up_amount']);

			$up_currency = stripslashes($row['up_currency']);

			$upr_status = stripslashes($row['upr_status']);

			$uup_id = stripslashes($row['up_id']);

			$uup_amount = stripslashes($row['uup_amount']);

			$uup_currency = stripslashes($row['uup_currency']);

			$uup_start_date = stripslashes($row['uup_start_date']);

			$uup_end_date = stripslashes($row['uup_end_date']);

			$uup_status = stripslashes($row['uup_status']);

			$uup_payment_status = stripslashes($row['uup_payment_status']);

			$uup_payment_mode = stripslashes($row['uup_payment_mode']);

			$uup_payment_details = stripslashes($row['uup_payment_details']);

			$upr_add_date = stripslashes($row['upr_add_date']);

			$upr_responce_date = stripslashes($row['upr_responce_date']);

			//add date 11-12-20
			$uup_points = stripslashes($row['uup_points']);
			$plan_prize_id = stripslashes($row['plan_prize_id']);

		}

		return array($name,$user_id,$up_id,$up_name,$up_duration,$up_amount,$up_currency,$upr_status,$uup_id,$uup_amount,$uup_currency,$uup_start_date,$uup_end_date,$uup_status,$uup_payment_status,$uup_payment_mode,$uup_payment_details,$upr_add_date,$upr_responce_date,$uup_points,$plan_prize_id);

	}

	

	public function getAdviserDefaultPlanAttributeDetails($ap_id,$apa_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$apa_value = '';

		$apa_readonly = '';

		$apc_id = '';

		$apc_value = '';

				

		$sql = "SELECT * FROM `tbladviserplandetails` WHERE `apd_status` = '1' AND `apd_deleted` = '0' AND `ap_id` = '".$ap_id."' AND `apa_id` = '".$apa_id."'  ORDER BY `apd_add_date` DESC LIMIT 1";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$apa_value = $row['apa_value'];

			if($apa_value == '1')

			{

				$apa_readonly = 'readonly';

			}

			$apc_id = $row['apc_id'];

			$apc_value = $row['apc_value'];

		}



		return array($apa_value,$apa_readonly,$apc_id,$apc_value);

	}

	

	public function getUserDefaultPlanAttributeDetails($ap_id,$apa_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$apa_value = '';

		$apa_readonly = '';

		$apc_id = '';

		$apc_value = '';

				

		$sql = "SELECT * FROM `tbluserplandetails` WHERE `upd_status` = '1' AND `upd_deleted` = '0' AND `up_id` = '".$ap_id."' AND `upa_id` = '".$apa_id."'  ORDER BY `upd_add_date` DESC LIMIT 1";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$apa_value = $row['upa_value'];

			if($apa_value == '1')

			{

				$apa_readonly = 'readonly';

			}

			$apc_id = $row['upc_id'];

			$apc_value = $row['upc_value'];

		}



		return array($apa_value,$apa_readonly,$apc_id,$apc_value);

	}

	

	public function getAdviserPlanAttributesNames()

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$arr_apa_id = array();

		$arr_apa_name = array();

		$arr_apa_value = array();

		$arr_apa_readonly = array();

		$arr_apc_id = array();

		$arr_apc_value = array();

		

		$default_ap_id = $this->getAdviserDefaultPlanId();

				

		$sql = "SELECT * FROM `tbladviserplanatributes` WHERE `apa_status` = '1' AND `show_for_adviser` = '1' ORDER BY `apa_name`";

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				array_push($arr_apa_id , $row['apa_id']);

				array_push($arr_apa_name , stripslashes($row['apa_name']));

				

				$obj = new Subscriptions();

				list($apa_value,$apa_readonly,$apc_id,$apc_value) = $obj->getAdviserDefaultPlanAttributeDetails($default_ap_id,$row['apa_id']);

				

				array_push($arr_apa_value , $apa_value);

				array_push($arr_apa_readonly , $apa_readonly);

				array_push($arr_apc_id , $apc_id);

				array_push($arr_apc_value , $apc_value);

			}

		}



		return array($arr_apa_id,$arr_apa_name,$arr_apa_value,$arr_apa_readonly,$arr_apc_id,$arr_apc_value);

	}

	

	public function getUserPlanAttributesNames()

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$arr_apa_id = array();

		$arr_apa_name = array();

		$arr_apa_value = array();

		$arr_apa_readonly = array();

		$arr_apc_id = array();

		$arr_apc_value = array();

		

		$default_ap_id = $this->getUserDefaultPlanId();

				

		//$sql = "SELECT * FROM `tbladviserplanatributes` WHERE `apa_status` = '1' AND `show_for_user` = '1' ORDER BY `apa_name`";

		$sql = "SELECT * FROM `tblpagedropdowns` WHERE `pd_status` = '1' AND `pd_deleted`='0' AND pd_id=21";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);


				if(!empty($row['page_id_str']))
				{
					$page_ids=explode(',', $row['page_id_str']);

					foreach ($page_ids as $key => $value) {

						array_push($arr_apa_id , $value);

						array_push($arr_apa_name , $this->get_PageName($value));

						

						$obj = new Subscriptions();

						list($apa_value,$apa_readonly,$apc_id,$apc_value) = $obj->getUserDefaultPlanAttributeDetails($default_ap_id,$row['apa_id']);

						

						array_push($arr_apa_value , $apa_value);

						array_push($arr_apa_readonly , $apa_readonly);

						array_push($arr_apc_id , $apc_id);

						array_push($arr_apc_value , $apc_value);

						
					}

				}

		}



		return array($arr_apa_id,$arr_apa_name,$arr_apa_value,$arr_apa_readonly,$arr_apc_id,$arr_apc_value);

	}

	

	

	

	public function deleteAdviserPlan($ap_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return=false;

		$sql = "UPDATE `tbladviserplans` SET `ap_deleted` = '1' WHERE `ap_id` = '".$ap_id."'";

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		

		$del_sql1 = "UPDATE `tbladviserplandetails` SET `apd_deleted` = '1' WHERE `ap_id` = '".$ap_id."' "; 

		//echo '<br>'.$del_sql1;

		$STH = $DBH->prepare($del_sql1);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function deleteUserPlan($up_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return=false;

		$sql = "UPDATE `tbluserplans` SET `up_deleted` = '1' WHERE `up_id` = '".$up_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		

		$del_sql1 = "UPDATE `tbluserplandetails` SET `upd_deleted` = '1' WHERE `up_id` = '".$up_id."' "; 

		//echo '<br>'.$del_sql1;

		$STH = $DBH->prepare($del_sql1);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getCurrencyOptions($currency)

	{

		$option_str = '';		

		

		$arr_currency = array('INR','USD','GBP','EUR');

		sort($arr_currency);

		

		for($i=0;$i<count($arr_currency);$i++)

		{

			if($arr_currency[$i] == $currency)

			{

				$sel = ' selected ';

			}

			else

			{

				$sel = '';

			}		

			$option_str .= '<option value="'.$arr_currency[$i].'" '.$sel.'>'.$arr_currency[$i].'</option>';

		}

		return $option_str;

	}

	

	public function getAdviserCriteriaOptions($apc_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$option_str = '';		

		

		$sql = "SELECT * FROM `tbladviserplancriteria` WHERE `apc_status` = '1' ORDER BY `apc_criteria` ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['apc_id'] == $apc_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['apc_id'].'" '.$sel.'>'.$row['apc_criteria'].'</option>';

			}

		}

		return $option_str;

	}

	

	public function getAdviserPlansCategoryTypeOptions($apct_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$option_str = '';		

		

		$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_status` = '1' AND `apct_deleted` = '0' AND `show_for_adviser` = '1' ORDER BY `apct_category_type` ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['apct_id'] == $apct_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['apct_id'].'" '.$sel.'>'.$row['apct_category_type'].'</option>';

			}

		}

		return $option_str;

	}



	public function getUserPlansCategoryTypeOptions($apct_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$option_str = '';		

		

		$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_status` = '1' AND `apct_deleted` = '0' AND `show_for_user` = '1' ORDER BY `apct_category_type` ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['apct_id'] == $apct_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['apct_id'].'" '.$sel.'>'.$row['apct_category_type'].'</option>';

			}

		}

		return $option_str;

	}



	

	public function getAllAdviserPlanCategories()

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '202';

		$delete_action_id = '203';

		$view_action_id = '200';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		$view = $this->chkValidActionPermission($admin_id,$view_action_id);

		

		$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_deleted` = '0' AND `show_for_adviser` = '1' ORDER BY apct_category_type ASC ";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page = 50;

		$scroll = 5;

		$page = new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=adviser_plan_categories");

	 	$STH = $DBH->prepare($page->get_limit_query($sql));

                $STH->execute();

		$output = '';		

		if($STH->rowCount() > 0)

		{

			if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

			{

				$i = $page->start + 1;

			}

			else

			{

				$i = 1;

			}

				

			while($row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				if($row['apct_status'] == '1')

				{

					$apct_status = 'Active';

				}

				else

				{

					$apct_status = 'Inactive';

				}

						

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30" align="center">'.$i.'</td>';

				$output .= '<td height="30" align="center"><strong>'.stripslashes($row['apct_category_type']).'</strong></td>';

				$output .= '<td height="30" align="center"><strong>'.$apct_status.'</strong></td>';

				$output .= '<td height="30" align="center">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_adviser_plan_category&id='.$row['apct_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Adviser Plan Category","sql/deladviserplancategory.php?id='.$row['apct_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				//$output .= '<tr class="manage-row" height="30"><td colspan="5" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="30"><td colspan="5" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function getAllUserPlanCategories()

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '206';

		$delete_action_id = '207';

		$view_action_id = '204';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		$view = $this->chkValidActionPermission($admin_id,$view_action_id);

		

		$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_deleted` = '0' AND `show_for_user` = '1' ORDER BY apct_category_type ASC ";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page = 50;

		$scroll = 5;

		$page = new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=user_plan_categories");

	 	$STH = $DBH->prepare($page->get_limit_query($sql));

                $STH->execute();

		$output = '';		

		if($STH->rowCount() > 0)

		{

			if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

			{

				$i = $page->start + 1;

			}

			else

			{

				$i = 1;

			}

				

			while($row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				if($row['apct_status'] == '1')

				{

					$apct_status = 'Active';

				}

				else

				{

					$apct_status = 'Inactive';

				}

						

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30" align="center">'.$i.'</td>';

				$output .= '<td height="30" align="center"><strong>'.stripslashes($row['apct_category_type']).'</strong></td>';

				$output .= '<td height="30" align="center"><strong>'.$apct_status.'</strong></td>';

				$output .= '<td height="30" align="center">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_user_plan_category&id='.$row['apct_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("User Plan Category","sql/deluserplancategory.php?id='.$row['apct_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				//$output .= '<tr class="manage-row" height="30"><td colspan="5" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="30"><td colspan="5" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function deleteAdviserPlanCategory($apct_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$upd_sql = "UPDATE `tbladviserplancategorytype` SET `apct_deleted` = '1' WHERE `apct_id` = '".$apct_id."'";

		

		$STH = $DBH->prepare($upd_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function chkIfAdviserPlanCategoryAlreadyExists($apct_category_type)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

				

		$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_category_type` = '".addslashes($apct_category_type)."' AND `apct_deleted` = '0'  AND `show_for_adviser` = '1' ";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function chkIfUserPlanCategoryAlreadyExists($apct_category_type)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

				

		$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_category_type` = '".addslashes($apct_category_type)."' AND `apct_deleted` = '0'  AND `show_for_user` = '1' ";

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function chkIfAdviserPlanCategoryAlreadyExists_Edit($apct_category_type,$apct_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

				

		$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_category_type` = '".addslashes($apct_category_type)."'  AND `apct_id` != '".$apct_id."'  AND `apct_deleted` = '0'  AND `show_for_adviser` = '1' ";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function chkIfUserPlanCategoryAlreadyExists_Edit($apct_category_type,$apct_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

				

		$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_category_type` = '".addslashes($apct_category_type)."'  AND `apct_id` != '".$apct_id."'  AND `apct_deleted` = '0'  AND `show_for_user` = '1' ";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function addAdviserPlanCategory($apct_category_type)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "INSERT INTO `tbladviserplancategorytype` (`apct_category_type`,`apct_status`,`show_for_adviser`,`show_for_user`,`apct_deleted`) VALUES ('".addslashes($apct_category_type)."','1','1','0','0')";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function addUserPlanCategory($apct_category_type)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "INSERT INTO `tbladviserplancategorytype` (`apct_category_type`,`apct_status`,`show_for_adviser`,`show_for_user`,`apct_deleted`) VALUES ('".addslashes($apct_category_type)."','1','0','1','0')";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getAdviserPlanCategoryDetails($apct_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$apct_category_type = '';

		$apct_status = '';

						

		$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_id` = '".$apct_id."' AND `apct_deleted` = '0'  AND `show_for_adviser` = '1' ";

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$apct_category_type = stripslashes($row['apct_category_type']);

			$apct_status = stripslashes($row['apct_status']);

		}

		return array($apct_category_type,$apct_status);

	}

	

	public function getUserPlanCategoryDetails($apct_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$apct_category_type = '';

		$apct_status = '';

						

		$sql = "SELECT * FROM `tbladviserplancategorytype` WHERE `apct_id` = '".$apct_id."' AND `apct_deleted` = '0'  AND `show_for_user` = '1' ";

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$apct_category_type = stripslashes($row['apct_category_type']);

			$apct_status = stripslashes($row['apct_status']);

		}

		return array($apct_category_type,$apct_status);

	}

	

	public function updateAdviserPlanCategory($apct_id,$apct_category_type,$apct_status)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$upd_sql = "UPDATE `tbladviserplancategorytype` SET `apct_category_type` = '".addslashes($apct_category_type)."' , `apct_status` = '".addslashes($apct_status)."' WHERE `apct_id` = '".$apct_id."'";

		

		$STH = $DBH->prepare($upd_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getAdviserDefaultPlanId()

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$ap_id = 0; 

		

		$sql = "SELECT * FROM `tbladviserplans` WHERE `ap_default` = '1' AND `ap_status` = '1' AND `ap_deleted` = '0' ORDER BY `ap_add_date` DESC LIMIT 1";

		//echo '<br>'.$sql.'<br>';

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$ap_id = $row['ap_id'];

		}

			

		return $ap_id;

	}

	

	public function getUserDefaultPlanId()

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$up_id = 0; 

		

		$sql = "SELECT * FROM `tbluserplans` WHERE `up_default` = '1' AND `up_status` = '1' AND `up_deleted` = '0' ORDER BY `up_add_date` DESC LIMIT 1";

		//echo '<br>'.$sql.'<br>';

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$up_id = $row['up_id'];

		}

			

		return $up_id;

	}

	

	public function getUserDefaultPlanName()

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$up_name = 'Default Plan'; 

		

		$sql = "SELECT * FROM `tbluserplans` WHERE `up_default` = '1' AND `up_status` = '1' AND `up_deleted` = '0' ORDER BY `up_add_date` DESC LIMIT 1";

		//echo '<br>'.$sql.'<br>';

		$STH = $DBH->prepare($sql); 

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$up_name = stripslashes($row['up_name']);

		}

			

		return $up_name;

	}

	

	public function getAdviserDefaultPlanName()

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$ap_name = 'Default Plan'; 

		

		$sql = "SELECT * FROM `tbladviserplans` WHERE `ap_default` = '1' AND `ap_status` = '1' AND `ap_deleted` = '0' ORDER BY `ap_add_date` DESC LIMIT 1";

		//echo '<br>'.$sql.'<br>';

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$ap_name = stripslashes($row['ap_name']);

		}

			

		return $ap_name;

	}

        

        public function GetUserPlanPageDropDown()

        {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

                $page_id_str='';

                

		$sql = "SELECT * FROM `tblpagedropdowns` WHERE `pd_id` = '20' AND `pd_status` = '1' ";

		

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$page_id_str = stripslashes($row['page_id_str']);

		}

			

		return $page_id_str;  

        }

        
	public function get_PageName($page_id)

	{

		$my_DBH = new mysqlConnection();

	        $DBH = $my_DBH->raw_handle();

	        $DBH->beginTransaction();

		$page_name = '';

		$sql ="SELECT * FROM `tblpages` WHERE  `page_id` = '".$page_id."' ";	


		$STH = $DBH->prepare($sql);

	        $STH->execute();

	        if($STH->rowCount() > 0)

		{



			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$page_name = stripslashes($row['page_name']);

		}	

		return $page_name;

	}

        
	public function getFavCategoryRamakant($fav_cat_type_id, $fav_cat_id) {
        $DBH = new mysqlConnection();
        $option_str = '';
        $fav_cat_type_id = explode(',', $fav_cat_type_id);
        $fav_cat_type_id = implode('\',\'', $fav_cat_type_id);
        $sql = "SELECT * FROM `tblcustomfavcategory` " . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('" . $fav_cat_type_id . "') and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
        //echo $sql;
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['favcat_id'] == $fav_cat_id) {
                    $sel = ' selected ';
                } else {
                    $sel = '';
                }
                $cat_name = $row['fav_cat'];
                $option_str.= '<option value="' . $row['favcat_id'] . '" ' . $sel . '>' . stripslashes($cat_name) . '</option>';
            }
        }
        //echo $option_str;
        return $option_str;
    }
    //copy by ample 23-11-20
	public function getFavCategoryName($fav_cat_id)
	{


        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $fav_cat_type = '';


            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ORDER BY `fav_cat` ASC";
            
            $STH = $DBH->prepare($sql);
            $STH->execute();

            if($STH->rowCount()  > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $fav_cat_type = stripslashes($row['fav_cat']);
            }
            return $fav_cat_type;

	}
	public function get_subcription_plan_criteria()
	{
		$data_dropdown=$this->get_data_dropdown_by_id(91);
		$final_dropdown=$this->get_text_from_data_dropdown($data_dropdown);
		return $final_dropdown;
	}
	//copy & update by ample 23-11-20
    public function get_data_dropdown_by_id($page_cat_id) {
        $DBH = new mysqlConnection();
        $arr_data = array();
        $sql = "SELECT * FROM `tbl_data_dropdown` WHERE `page_cat_id` = '" . $page_cat_id . "' and `is_deleted` = 0 ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $arr_data= $row;
        }
        return $arr_data;
    }
    public function get_text_from_data_dropdown($data_dropdown)
    {
        $show_cat = '';
          $fetch_cat1 = array();
          $fetch_cat2 = array();
          $fetch_cat3 = array();

          if ($data_dropdown['sub_cat1'] != '')
          {
            if ($data_dropdown['canv_sub_cat1_show_fetch'] == 1)
            {
              $show_cat.= $data_dropdown['sub_cat1'].',';
            }
          }
          if ($data_dropdown['sub_cat2'] != '')
          {
            if ($data_dropdown['canv_sub_cat2_show_fetch'] == 1)
            {
              $show_cat.= $data_dropdown['sub_cat2'].',';
            } 
          }
          if ($data_dropdown['sub_cat3'] != '')
          {
            if ($data_dropdown['canv_sub_cat2_show_fetch'] == 1)
            {
              $show_cat.= $data_dropdown['sub_cat2'].',';
            } 
          }
         
          $show_cat = explode(',', $show_cat);
          $show_cat = array_filter($show_cat);
          $final_dropdown = $show_cat;

          return $final_dropdown;
    }
    //add by ample 02-12-20
    public function added_page_setting($data)
    {   

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $admin_id = $_SESSION['admin_id'];

        $sql = "INSERT INTO `tblpagesetting` (`created_by`,`page_id`,`table_link`,`table_column`,`column1`,`value1`,`column2`,`value2`,`column3`,`value3`) VALUES (".$admin_id.",'".$data['page_id']."','".$data['table_link']."','".$data['table_column']."','".$data['column1']."','".trim($data['value1'])."','".$data['column2']."','".trim($data['value2'])."','".$data['column3']."','".trim($data['value3'])."')";

        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    } 
    //add by ample 02-12-20
    public function get_page_setting($page_id)
    {
    	$DBH = new mysqlConnection();
        $arr_data = array();
        $sql = "SELECT * FROM `tblpagesetting` WHERE `page_id` = '" . $page_id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $arr_data= $row;
        }
        return $arr_data;
    }
     //added by ample 02-12-20
    public function updated_page_setting($data)
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $admin_id = $_SESSION['admin_id'];

        $sql="UPDATE `tblpagesetting` SET 
            `updated_by`='".$admin_id."',`updated_at`='".date('Y-m-d H:i:s')."',`table_link`='".$data['table_link']."',`table_column`='".$data['table_column']."',`column1`='".$data['column1']."',`value1`='".trim($data['value1'])."',`column2`='".$data['column2']."',`value2`='".trim($data['value2'])."',`column3`='".$data['column3']."',`value3`='".trim($data['value3'])."' WHERE `page_id`='".$data['page_id']."' AND `setting_id`='".$data['setting_id']."'";
        $STH = $DBH->query($sql);
        // print_r($STH); die('--');
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }
    public function get_UserReportname($user) {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = array();
        $sql = "SELECT `report_name`,`page_cat_id`,`page_name` FROM `tbl_recordshow_dropdown` WHERE  `enduse` = '" . $user . "' AND pag_cat_status=1 AND is_deleted=0 AND is_action=2";
        //update sql by ample 13-04-20 (status & delete)
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data[]=$row;
            }
        }
        return $data;
    }
    public function get_report_feature($plan_id) {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = array();
        $sql = "SELECT * FROM `tbluserplandetails` AS tupd  WHERE tupd.up_id = '".$plan_id."' AND tupd.upd_status = '1' AND tupd.upd_deleted = '0' AND is_report_data='1' ORDER BY tupd.upd_id";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $data[]=$row;
            }
        }
        return $data;
    }
    public function get_Report_name($page_cat_id) {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data = '';
        $sql = "SELECT `report_name` FROM `tbl_recordshow_dropdown` WHERE  `page_cat_id` = '" . $page_cat_id . "'";
        //update sql by ample 13-04-20 (status & delete)
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            	$row = $STH->fetch(PDO::FETCH_ASSOC);
                $data=$row['report_name'];
            
        }
        return $data;
    }
    //copy by ample 09-12-20
    public function get_user_plan_data($up_id) {
        $DBH = new mysqlConnection();
        $data = array();
        $sql = "SELECT * FROM `tbluserplans` WHERE `up_id` = " . $up_id . "";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $data= $r;
        }
        return $data;
    }
    //copy by ample 09-12-20
    public function added_reward_history($data) {
        $DBH = new mysqlConnection();
        $return = false;
        $sql = "INSERT INTO `tbl_user_reward_history`(`user_id`, `reward_module_id`,`points`,`transaction_type`,`remark`,`reward_scheme_type`,`reward_scheme_id`,`transection_no`,`balance`) " . "VALUES ('".$data['user_id']."','".$data['reward_module_id']."','".$data['points']."','".$data['transaction_type']."','" . addslashes($data['remark']) . "','".$data['reward_scheme_type']."','".$data['reward_scheme_id']."','".$data['transection_no']."','".$data['balance']."')";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
    public function get_user_points($user_id) {
        $DBH = new mysqlConnection();
        $point = 0;
        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '" . $user_id . "'";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $point= stripslashes($r['points']);
        }
        return $point;
    }
    public function update_user_points($user_id, $user_points) {
        $DBH = new mysqlConnection();
        $return = false;
        $sql = "UPDATE `tblusers` SET `points` = ".$user_points."  WHERE  `user_id` = '" . $user_id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $return = true;
        }
        return $return;
    }
     //copy by ample 20-08-20
	public function getPlanPrizeListCheckbox($arr_selected_id="")
    {
    	$width="400"; $height="150";
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $output = ''; 
        $sql = "SELECT * FROM `tblrewardlist` WHERE `reward_list_module_id`=40 AND `show_cat`=803 AND `shows_where`=143 AND reward_list_status=1 AND reward_list_deleted=0";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {

            $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
            $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
            $i = 1;
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {

                $list_id = $row['reward_list_id'];
                $list_name = stripslashes($row['reward_list_name']);
                if(in_array($list_id,$arr_selected_id))
                {
                    $selected = ' checked ';
                }
                else
                {
                    $selected = '';
                }
                $liwidth = 300;
                $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="prize_ids[]" value="'.$list_id.'"  />&nbsp;<strong>'.$list_name.'</strong></li>';
                $i++;
            }
            $output .= '</div>';
        }
        return $output;
    }
    //add by ample 19-11-20
    function get_reward_prize_data($reward_list_id) {
        $DBH = new mysqlConnection();
        $data = array();
        $sql = "SELECT * FROM `tblrewardlist` WHERE  `reward_list_id` = '" . $reward_list_id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
            
        }
        return $data;
    }
}

?>