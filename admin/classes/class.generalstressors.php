<?php
include_once("class.paging.php");
include_once("class.admin.php");
class General_Stressors extends Admin
{
    
    public function getAllSetGoalAndQuery($practitioner_id,$search,$status,$country_id,$arr_state_id,$arr_city_id,$arr_place_id,$start_date)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '32';
		$delete_action_id = '34';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($practitioner_id == '' || $practitioner_id == '0')
		{
			$str_sql_practitioner_id = "";
		}
		else
		{
			$str_sql_practitioner_id = " AND `practitioner_id` = '".$practitioner_id."' ";
		}
		
		if($search == '')
		{
			$str_sql_search = "";
		}
		else
		{
			$str_sql_search = " AND `situation` LIKE '%".$search."%' ";
		}
		
		if($status == '')
		{
			$str_sql_status = "";
		}
		else
		{
			$str_sql_status = " AND `status` = '".$status."' ";
		}
		
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
		
		if($start_date == '')
		{
			$str_sql_date = "";
		}
		else
		{
			$start_date = date('Y-m-d',strtotime($start_date));
			$today_day = date('j',strtotime($start_date));
			$today_date = date('Y-m-d',strtotime($start_date));
			
			$str_sql_date = " AND ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) ";
		}
		
		$sql = "SELECT * FROM `tblgoals_query` WHERE 1 ".$str_sql_practitioner_id."  ".$str_sql_search."  ".$str_sql_status."  ".$str_sql_country_id."  ".$str_sql_state_id."  ".$str_sql_city_id."  ".$str_sql_place_id."  ".$str_sql_date."  ORDER BY `listing_order` ASC , `date_int` DESC";		
		  $STH = $DBH->prepare($sql); 
                  $STH->execute();
		$total_records = $STH->rowCount();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=general_stressors");
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
				if($row['status'] == '1')
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Inactive';
				}
				
//				if($row['practitioner_id'] == '0')
//				{
//					$practitioner_name = 'All';
//				}
//				else
//				{
//					$obj3 = new General_Stressors();
//					$practitioner_name = $obj3->getPractitionersName($row['practitioner_id']);
//				}
				
				if($row['listing_date_type'] == 'days_of_month')
				{
					$date_type = 'Days of Month';
					$date_value = stripslashes($row['days_of_month']);
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
				
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center"><strong>'.stripslashes($row['question']).'</strong></td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['lab']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['adviser']).'</td>';
                                $output .= '<td height="30" align="center">'.stripslashes($row['referred_by_adviser']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['referred_from_lab']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['name']).'</td>';
//				
//				$output .= '<td height="30" align="center">'.$date_type.'</td>';
//				$output .= '<td height="30" align="center">'.$date_value.'</td>';
				$output .= '<td height="30" align="center">'.$status.'</td>';
				$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['date_int'])).'</td>';
				$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_general_stressors&id='.$row['gs_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Question","sql/delgeneralstressors.php?id='.$row['gs_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
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
    
	public function getAllQuestions($practitioner_id,$search,$status,$country_id,$arr_state_id,$arr_city_id,$arr_place_id,$start_date)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '32';
		$delete_action_id = '34';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($practitioner_id == '' || $practitioner_id == '0')
		{
			$str_sql_practitioner_id = "";
		}
		else
		{
			$str_sql_practitioner_id = " AND `practitioner_id` = '".$practitioner_id."' ";
		}
		
		if($search == '')
		{
			$str_sql_search = "";
		}
		else
		{
			$str_sql_search = " AND `situation` LIKE '%".$search."%' ";
		}
		
		if($status == '')
		{
			$str_sql_status = "";
		}
		else
		{
			$str_sql_status = " AND `status` = '".$status."' ";
		}
		
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
		
		if($start_date == '')
		{
			$str_sql_date = "";
		}
		else
		{
			$start_date = date('Y-m-d',strtotime($start_date));
			$today_day = date('j',strtotime($start_date));
			$today_date = date('Y-m-d',strtotime($start_date));
			
			$str_sql_date = " AND ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) ";
		}
		
		$sql = "SELECT * FROM `tblgeneralstressors` WHERE 1 ".$str_sql_practitioner_id."  ".$str_sql_search."  ".$str_sql_status."  ".$str_sql_country_id."  ".$str_sql_state_id."  ".$str_sql_city_id."  ".$str_sql_place_id."  ".$str_sql_date."  ORDER BY `listing_order` ASC , `gs_add_date` DESC";		
		  $STH = $DBH->prepare($sql);
                  $STH->execute();
		$total_records = $STH->rowCount();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=general_stressors");
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
				if($row['status'] == '1')
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Inactive';
				}
				
				if($row['practitioner_id'] == '0')
				{
					$practitioner_name = 'All';
				}
				else
				{
					$obj3 = new General_Stressors();
					$practitioner_name = $obj3->getPractitionersName($row['practitioner_id']);
				}
				
				if($row['listing_date_type'] == 'days_of_month')
				{
					$date_type = 'Days of Month';
					$date_value = stripslashes($row['days_of_month']);
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
				
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center"><strong>'.stripslashes($row['situation']).'</strong></td>';
				$output .= '<td height="30" align="center">'.$practitioner_name.'</td>';
				$output .= '<td height="30" align="center">'.$date_type.'</td>';
				$output .= '<td height="30" align="center">'.$date_value.'</td>';
				$output .= '<td height="30" align="center">'.$status.'</td>';
				$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['gs_add_date'])).'</td>';
				$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_general_stressors&id='.$row['gs_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Question","sql/delgeneralstressors.php?id='.$row['gs_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
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
        
         
//	public function getAllInterpretation($practitioner_id,$search,$status,$country_id,$arr_state_id,$arr_city_id,$arr_place_id,$start_date)
//	{
//		$my_DBH = new mysqlConnection();$DBH = $my_DBH->raw_handle();$DBH->beginTransaction();
//		
//		$admin_id = $_SESSION['admin_id'];
//		$edit_action_id = '299';
//		$delete_action_id = '300';
//		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
//		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
//		
//		if($practitioner_id == '' || $practitioner_id == '0')
//		{
//			$str_sql_practitioner_id = "";
//		}
//		else
//		{
//			$str_sql_practitioner_id = " AND `practitioner_id` = '".$practitioner_id."' ";
//		}
//		
//		if($search == '')
//		{
//			$str_sql_search = "";
//		}
//		else
//		{
//			$str_sql_search = " AND `situation` LIKE '%".$search."%' ";
//		}
//		
//		if($status == '')
//		{
//			$str_sql_status = "";
//		}
//		else
//		{
//			$str_sql_status = " AND `status` = '".$status."' ";
//		}
//		
//		if($country_id == '' || $country_id == '0')
//		{
//			$str_sql_country_id = "";
//		}
//		else
//		{
//			$str_sql_country_id = " AND `country_id` = '".$country_id."' ";
//		}
//		
//		if(count($arr_state_id) > 0 )
//		{
//			if($arr_state_id[0] == '')
//			{
//				$str_sql_state_id = "";
//			}
//			else
//			{
//				$str_state_id = implode(',',$arr_state_id);
//				$str_sql_state_id = " AND FIND_IN_SET('".$str_state_id."', state_id) ";
//			}	
//		}
//		else
//		{
//			$str_sql_state_id = "";
//		}
//		
//		if(count($arr_city_id) > 0 )
//		{
//			if($arr_city_id[0] == '')
//			{
//				$str_sql_city_id = "";
//			}
//			else
//			{
//				$str_city_id = implode(',',$arr_city_id);
//				$str_sql_city_id = " AND FIND_IN_SET('".$str_city_id."', city_id) ";
//			}	
//		}
//		else
//		{
//			$str_sql_city_id = "";
//		}
//		
//		if(count($arr_place_id) > 0 )
//		{
//			if($arr_place_id[0] == '')
//			{
//				$str_sql_place_id = "";
//			}
//			else
//			{
//				$str_place_id = implode(',',$arr_place_id);
//				$str_sql_place_id = " AND FIND_IN_SET('".$str_place_id."', place_id) ";
//			}	
//		}
//		else
//		{
//			$str_sql_place_id = "";
//		}
//		
//		if($start_date == '')
//		{
//			$str_sql_date = "";
//		}
//		else
//		{
//			$start_date = date('Y-m-d',strtotime($start_date));
//			$today_day = date('j',strtotime($start_date));
//			$today_date = date('Y-m-d',strtotime($start_date));
//			
//			$str_sql_date = " AND ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) ";
//		}
//		
//		$sql = "SELECT * FROM `tbl_reading`  WHERE 1 ORDER BY interpretation_id ASC ";		
//		  $STH = $DBH->prepare($sql);  $STH->execute();
//		$total_records = $STH->rowCount();
//		$record_per_page = 50;
//		$scroll = 5;
//		$page = new Page(); 
//    	        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
//		$page->set_link_parameter("Class = paging");
//		$page->set_qry_string($str="mode=general_stressors");
//	 	$STH = $DBH->prepare($page->get_limit_query($sql)); $STH->execute();
//		$output = '';		
//		if($STH->rowCount() > 0)
//		{
//			if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )
//			{
//				$i = $page->start + 1;
//			}
//			else
//			{
//				$i = 1;
//			}
//			
//			while($row = $STH->fetch(PDO::FETCH_ASSOC))
//			{                           
//				if($row['status'] == '1')
//				{
//					$status = 'Active';
//				}
//				else
//				{
//					$status = 'Inactive';
//				}
//				
//				if($row['practitioner_id'] == '0')
//				{
//					$practitioner_name = 'All';
//				}
//				else
//				{
//					$obj3 = new General_Stressors();
//					$practitioner_name = $obj3->getPractitionersName($row['practitioner_id']);
//				}
//				
//				if($row['listing_date_type'] == 'days_of_month')
//				{
//					$date_type = 'Days of Month';
//					$date_value = stripslashes($row['days_of_month']);
//				}
//				elseif($row['listing_date_type'] == 'single_date')
//				{
//					$date_type = 'Single Date';
//					$date_value = date('d-m-Y',strtotime($row['single_date']));
//				}
//				elseif($row['listing_date_type'] == 'date_range')
//				{
//					$date_type = 'Date Range';
//					$date_value = date('d-m-Y',strtotime($row['start_date'])).' - '.date('d-m-Y',strtotime($row['end_date']));
//				}
//				
//                                $interpretation_criteriaexplode=explode(',',$row['interpretation_criteria']);
//                                
//                                $interpretation_criteria= implode('\',\'' ,$interpretation_criteriaexplode);
//                                
//                                
//				$output .= '<tr class="manage-row">';
//				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
//				$output .= '<td height="30" align="center"><strong>'.$obj3->getInterpretationCriteriaNameById($interpretation_criteria).'</strong></td>';
//				$output .= '<td height="30" align="center">'.$row['scale_form'].'</td>';
//				$output .= '<td height="30" align="center">'.$row['scale_to'].'</td>';
//				$output .= '<td height="30" align="center">'.$obj3->getSymptomType($row['symptom_type']).'</td>';
//				$output .= '<td height="30" align="center">'.$obj3->getSymptomName($row['symptom_name']).'</td>';
////				$output .= '<td height="30" align="center">'.$obj3->getInterpretationNameById($row['interpretation']).'</td>';
//				$output .= '<td height="30" align="center">'.$row['lab'].'</td>';
//				$output .= '<td height="30" align="center">'.$row['adviser'].'</td>';
//				$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
//				$output .= '<td height="30" align="center">'.$status.'</td>';
//				$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['date'])).'</td>';
//				$output .= '<td align="center" nowrap="nowrap">';
//						if($edit) {
//				$output .= '<a href="index.php?mode=edit_interpretation_reading&id='.$row['interpretation_id'].'" ><img src = "images/edit.gif" border="0"></a>';
//							}
//				$output .= '</td>';
//				$output .= '<td align="center" nowrap="nowrap">';
//						if($delete) {
//				$output .= '<a href=\'javascript:fn_confirmdelete("Question","sql/delinterpretation.php?id='.$row['interpretation_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
//							}
//				$output .= '</td>';
//				$output .= '</tr>';
//				$i++;
//			}
//		}
//		else
//		{
//			$output = '<tr class="manage-row" height="20"><td colspan="10" align="center">NO RECORDS FOUND</td></tr>';
//		}
//		
//		$page->get_page_nav();
//		return $output;
//	}
	
        public function getAllInterpretation($practitioner_id,$search,$status,$country_id,$arr_state_id,$arr_city_id,$arr_place_id,$start_date)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '299';
		$delete_action_id = '300';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($practitioner_id == '' || $practitioner_id == '0')
		{
			$str_sql_practitioner_id = "";
		}
		else
		{
			$str_sql_practitioner_id = " AND `practitioner_id` = '".$practitioner_id."' ";
		}
		
		if($search == '')
		{
			$str_sql_search = "";
		}
		else
		{
			$str_sql_search = " AND `situation` LIKE '%".$search."%' ";
		}
		
		if($status == '')
		{
			$str_sql_status = "";
		}
		else
		{
			$str_sql_status = " AND `status` = '".$status."' ";
		}
		
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
		
		if($start_date == '')
		{
			$str_sql_date = "";
		}
		else
		{
			$start_date = date('Y-m-d',strtotime($start_date));
			$today_day = date('j',strtotime($start_date));
			$today_date = date('Y-m-d',strtotime($start_date));
			
			$str_sql_date = " AND ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) ";
		}
		
		$sql = "SELECT * FROM `tbl_interpretation_add_more` ,`tbl_interpretation` WHERE tbl_interpretation.interpretation_id = tbl_interpretation_add_more.interpret_id  ORDER BY `date_int` DESC ";		
		
//               $sql = "SELECT * FROM `tbl_interpretation` "
//                    . "LEFT JOIN tbl_interpretation_add_more ON tbl_interpretation.interpretation_id = tbl_interpretation_add_more.interpret_id WHERE 1 ORDER BY tbl_interpretation.date_int DESC ";
                
                  $STH = $DBH->prepare($sql);
                  $STH->execute();
		$total_records = $STH->rowCount();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
    	        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=assign_interpretation");
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
				if($row['status'] == '1')
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Inactive';
				}
				
				if($row['practitioner_id'] == '0')
				{
					$practitioner_name = 'All';
				}
				else
				{
					$obj3 = new General_Stressors();
					$practitioner_name = $obj3->getPractitionersName($row['practitioner_id']);
				}
				
				if($row['listing_date_type'] == 'days_of_month')
				{
					$date_type = 'Days of Month';
					$date_value = stripslashes($row['days_of_month']);
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
				
                                $interpretation_criteriaexplode=explode(',',$row['interpretation_criteria']);
                                $interpretation_criteria= implode('\',\'' ,$interpretation_criteriaexplode);
                                
                                
				
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
                                $output .= '<td height="30" align="center">'.$row['lab'].'</td>';
                                $output .= '<td height="30" align="center">'.$row['adviser'].'</td>';
                                $output .= '<td height="30" align="center">'.$row['interpretation_code'].'</td>';
				$output .= '<td height="30" align="center"><strong>'.$obj3->getInterpretationCriteriaNameById($interpretation_criteria).'</strong></td>';
				$output .= '<td height="30" align="center">'.$row['scale_form'].'</td>';
				$output .= '<td height="30" align="center">'.$row['scale_to'].'</td>';
				$output .= '<td height="30" align="center">'.$obj3->getSymptomType($row['symptom_type']).'</td>';
				$output .= '<td height="30" align="center">'.$obj3->getSymptomName($row['symptom_name']).'</td>';
				$output .= '<td height="30" align="center">'.$obj3->getInterpretationNameById($row['interpretation']).'</td>';
				$output .= '<td height="30" align="center">'.$row['comment'].'</td>';
                                $output .= '<td height="30" align="center">'.$obj3->getShareTypeNameById($row['share_type']).'</td>';
				$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
			
//                                $output .= '<td height="30" align="center">'.$row['identity_type'].'</td>';
////                                $output .= '<td height="30" align="center">'.$row['identity_level'].'</td>';
//                                $output .= '<td height="30" align="center">'.$row['identity_id'].'</td>';
				$output .= '<td height="30" align="center">'.$status.'</td>';
                                	 $output .= '<td height="30" align="center">'.$row['date_int'].'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_interpretation&id='.$row['interpretation_add_more_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Question","sql/delinterpretation.php?id='.$row['interpretation_add_more_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
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
	
        public function getAllInterpretationReading($practitioner_id,$search,$status,$country_id,$arr_state_id,$arr_city_id,$arr_place_id,$start_date)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '299';
		$delete_action_id = '300';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($practitioner_id == '' || $practitioner_id == '0')
		{
			$str_sql_practitioner_id = "";
		}
		else
		{
			$str_sql_practitioner_id = " AND `practitioner_id` = '".$practitioner_id."' ";
		}
		
		if($search == '')
		{
			$str_sql_search = "";
		}
		else
		{
			$str_sql_search = " AND `situation` LIKE '%".$search."%' ";
		}
		
		if($status == '')
		{
			$str_sql_status = "";
		}
		else
		{
			$str_sql_status = " AND `status` = '".$status."' ";
		}
		
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
		
		if($start_date == '')
		{
			$str_sql_date = "";
		}
		else
		{
			$start_date = date('Y-m-d',strtotime($start_date));
			$today_day = date('j',strtotime($start_date));
			$today_date = date('Y-m-d',strtotime($start_date));
			
			$str_sql_date = " AND ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) ";
		}
		
		$sql = "SELECT * FROM `tbl_reading` WHERE 1  ORDER BY `interpretation_id` ASC ";		
		
//               $sql = "SELECT * FROM `tbl_interpretation` "
//                    . "LEFT JOIN tbl_interpretation_add_more ON tbl_interpretation.interpretation_id = tbl_interpretation_add_more.interpret_id WHERE 1 ORDER BY tbl_interpretation.date_int DESC ";
                
                  $STH = $DBH->prepare($sql); 
                  $STH->execute();
		$total_records = $STH->rowCount();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
    	        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=general_stressors");
	 	$STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();
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
			
			while($row = $STH2->fetch(PDO::FETCH_ASSOC))
			{                           
				if($row['status'] == '1')
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Inactive';
				}
				
				if($row['practitioner_id'] == '0')
				{
					$practitioner_name = 'All';
				}
				else
				{
					$obj3 = new General_Stressors();
					$practitioner_name = $obj3->getPractitionersName($row['practitioner_id']);
				}
				
				if($row['listing_date_type'] == 'days_of_month')
				{
					$date_type = 'Days of Month';
					$date_value = stripslashes($row['days_of_month']);
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
				
                                $interpretation_criteriaexplode=explode(',',$row['interpretation_criteria']);
                                $interpretation_criteria= implode('\',\'' ,$interpretation_criteriaexplode);
                                
                                
				
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
                                $output .= '<td height="30" align="center">'.$row['lab'].'</td>';
                                $output .= '<td height="30" align="center">'.$row['adviser'].'</td>';
                                $output .= '<td height="30" align="center">'.$row['interpretation_code'].'</td>';
				$output .= '<td height="30" align="center"><strong>'.$obj3->getInterpretationCriteriaNameById($interpretation_criteria).'</strong></td>';
				$output .= '<td height="30" align="center">'.$row['scale_form'].'</td>';
				$output .= '<td height="30" align="center">'.$row['scale_to'].'</td>';
				$output .= '<td height="30" align="center">'.$obj3->getSymptomType($row['symptom_type']).'</td>';
				$output .= '<td height="30" align="center">'.$obj3->getSymptomName($row['symptom_name']).'</td>';
//				$output .= '<td height="30" align="center">'.$obj3->getInterpretationNameById($row['interpretation']).'</td>';
//				$output .= '<td height="30" align="center">'.$row['comment'].'</td>';
                                $output .= '<td height="30" align="center">'.$obj3->getShareTypeNameById($row['share_type']).'</td>';
				$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
			
//                                $output .= '<td height="30" align="center">'.$row['identity_type'].'</td>';
////                                $output .= '<td height="30" align="center">'.$row['identity_level'].'</td>';
//                                $output .= '<td height="30" align="center">'.$row['identity_id'].'</td>';
				$output .= '<td height="30" align="center">'.$status.'</td>';
                                	 $output .= '<td height="30" align="center">'.$row['date_int'].'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_interpretation_reading&id='.$row['interpretation_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Question","sql/delinterpretation.php?id='.$row['interpretation_add_more_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
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
	
        
        public function getInterpretationCriteriaNameById($interpretation_criteria_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$name = array();
		
		$sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` IN('".$interpretation_criteria_id."')";
		  $STH = $DBH->prepare($sql);
                  $STH->execute();
		if($STH->rowCount() > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
                        {
			$name[] = stripslashes($row['fav_cat']);
                        }
		}
                $nameimplode=implode(',',$name);
                
		return $nameimplode;
	
	}
        
        public function getSymptomType($symptom_type)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$name = '';
		
		$sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$symptom_type."'";
		  $STH = $DBH->prepare($sql); 
                  $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$name = stripslashes($row['fav_cat']);
		}
		return $name;
	
	}
	
	public function getSymptomName($symptom_name)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle()
                        ;$DBH->beginTransaction();
		
		$name = '';
		
		$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$symptom_name."'";
		  $STH = $DBH->prepare($sql); 
                  $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$name = stripslashes($row['bms_name']);
		}
		return $name;
	
	}
	
	public function getInterpretationNameById($interpretation)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$name = '';
		
		$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$interpretation."'";
		  $STH = $DBH->prepare($sql); 
                  $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$name = stripslashes($row['bms_name']);
		}
		return $name;
	
	}
        
//         public function getInterpretationDetails($id)
//	{
//		$my_DBH = new mysqlConnection();$DBH = $my_DBH->raw_handle();$DBH->beginTransaction();
//				
////	old	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."'";
//                $sql = "SELECT * FROM `tbl_reading` WHERE interpretation_id ='".$id."'";
//		  $STH = $DBH->prepare($sql);  $STH->execute();
//		if($STH->rowCount() > 0)
//		{
//			$row = $STH->fetch(PDO::FETCH_ASSOC);
//                        $identity_type = $row['identity_type'];
//			$identity_id = $row['identity_id'];
//			$lab = $row['lab'];
//			$adviser = $row['adviser'];
//			$referred_by_adviser = $row['referred_by_adviser'];
//			$referred_from_lab = $row['referred_from_lab'];
//			
//                        $prof_cat1 = stripslashes($row['prof_cat1']);
//                        $sub_cat1 = stripslashes($row['sub_cat1']);
//                        $prof_cat2 = stripslashes($row['prof_cat2']);
//                        $sub_cat2 = stripslashes($row['sub_cat2']);
//                        $prof_cat3 = stripslashes($row['prof_cat3']);
//                        $sub_cat3 = stripslashes($row['sub_cat3']);
//                        $prof_cat4 = stripslashes($row['prof_cat4']);
//                        $sub_cat4 = stripslashes($row['sub_cat4']);
//                        $prof_cat5 = stripslashes($row['prof_cat5']);
//                        $sub_cat5 = stripslashes($row['sub_cat5']);
//                        $prof_cat6 = stripslashes($row['prof_cat6']);
//                        $sub_cat6 = stripslashes($row['sub_cat6']);
//                        $prof_cat7 = stripslashes($row['prof_cat7']);
//                        $sub_cat7 = stripslashes($row['sub_cat7']);
//                        $prof_cat8 = stripslashes($row['prof_cat8']);
//                        $sub_cat8 = stripslashes($row['sub_cat8']);
//                        $prof_cat9 = stripslashes($row['prof_cat9']);
//                        $sub_cat9 = stripslashes($row['sub_cat9']);
//                        $prof_cat10 = stripslashes($row['prof_cat10']);
//                        $sub_cat10 = stripslashes($row['sub_cat10']);
//                        
//                        $name = stripslashes($row['name']);
//                        $registration_id = stripslashes($row['registration_id']);
//			$gender = stripslashes($row['gender']);
//			$age = stripslashes($row['age']);
//                        $test_no = stripslashes($row['test_no']);
//			$test_date = stripslashes($row['test_date']);
//                        
//                        
//                        $interpretation_criteria = stripslashes($row['interpretation_criteria']);
//			$scale_form = stripslashes($row['scale_form']);
//			$scale_to = stripslashes($row['scale_to']);
//			$symptom_type = stripslashes($row['symptom_type']);
//			$symptom_name = stripslashes($row['symptom_name']);
//                        
//			$share_type = stripslashes($row['share_type']);
//			$listing_order = stripslashes($row['listing_order']);
//			
//                        
//                        
//			
//		}
//		return array($test_no,$identity_type,$identity_id,$lab,$adviser,$referred_by_adviser,$referred_from_lab,$name,$registration_id,$gender,$age,$test_date,$name,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$share_type,$listing_order,$prof_cat1,$sub_cat1,$prof_cat2,$sub_cat2,$prof_cat3,$sub_cat3,$prof_cat4,$sub_cat4,$prof_cat5,$sub_cat5,$prof_cat6,$sub_cat6,$prof_cat7,$sub_cat7,$prof_cat8,$sub_cat8,$prof_cat9,$sub_cat9,$prof_cat10,$sub_cat10);
//	}
        
              public function getInterpretationDetails($id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
				
//	old	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."'";
               $sql = "SELECT * FROM `tbl_interpretation`,`tbl_interpretation_add_more` WHERE tbl_interpretation.interpretation_id= tbl_interpretation_add_more.interpret_id and tbl_interpretation_add_more.interpretation_add_more_id ='".$id."'";
//               $sql = "SELECT * FROM `tbl_interpretation` "
//                    . "LEFT JOIN tbl_interpretation_add_more ON tbl_interpretation.interpretation_id = tbl_interpretation_add_more.interpret_id WHERE tbl_interpretation.interpretation_id = '".$id."'";
		  $STH = $DBH->prepare($sql);
                  $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
                        $interpretation_id = stripslashes($row['interpretation_id']);
                        $lab = stripslashes($row['lab']);
                        $adviser = stripslashes($row['adviser']);
                        $interpretation_code = stripslashes($row['interpretation_code']);
                   
                        $interpretation_no = stripslashes($row['interpretation_no']);
			$interpretation_criteria = stripslashes($row['interpretation_criteria']);
			$scale_form = stripslashes($row['scale_form']);
			$scale_to = stripslashes($row['scale_to']);
			$symptom_type = stripslashes($row['symptom_type']);
			$symptom_name = stripslashes($row['symptom_name']);
			$listing_order = stripslashes($row['listing_order']);
			$prof_cat1 = stripslashes($row['prof_cat1']);
                        $sub_cat1 = stripslashes($row['sub_cat1']);
                        $prof_cat2 = stripslashes($row['prof_cat2']);
                        $sub_cat2 = stripslashes($row['sub_cat2']);
                        $prof_cat3 = stripslashes($row['prof_cat3']);
                        $sub_cat3 = stripslashes($row['sub_cat3']);
                        $prof_cat4 = stripslashes($row['prof_cat4']);
                        $sub_cat4 = stripslashes($row['sub_cat4']);
                        $prof_cat5 = stripslashes($row['prof_cat5']);
                        $sub_cat5 = stripslashes($row['sub_cat5']);
                        $prof_cat6 = stripslashes($row['prof_cat6']);
                        $sub_cat6 = stripslashes($row['sub_cat6']);
                        $prof_cat7 = stripslashes($row['prof_cat7']);
                        $sub_cat7 = stripslashes($row['sub_cat7']);
                        $prof_cat8 = stripslashes($row['prof_cat8']);
                        $sub_cat8 = stripslashes($row['sub_cat8']);
                        $prof_cat9 = stripslashes($row['prof_cat9']);
                        $sub_cat9 = stripslashes($row['sub_cat9']);
                        $prof_cat10 = stripslashes($row['prof_cat10']);
                        $sub_cat10 = stripslashes($row['sub_cat10']);
                        $interpretation = stripslashes($row['interpretation']);
                        $comment = stripslashes($row['comment']);
                        $user_type=stripslashes($row['identity_type']);
                        $identity_id=stripslashes($row['identity_id']);
                        $share_type=stripslashes($row['share_type']);
                        $$healcareandwellbeing=stripslashes($row['healcareandwellbeing']);
			
                        
			
		}
		return array($$healcareandwellbeing,$lab,$adviser,$interpretation_id,$interpretation_code,$interpretation_no,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$listing_order,$prof_cat1,$sub_cat1,$prof_cat2,$sub_cat2,$prof_cat3,$sub_cat3,$prof_cat4,$sub_cat4,$prof_cat5,$sub_cat5,$prof_cat6,$sub_cat6,$prof_cat7,$sub_cat7,$prof_cat8,$sub_cat8,$prof_cat9,$sub_cat9,$prof_cat10,$sub_cat10,$interpretation,$comment,$identity_id,$user_type,$share_type);
	}
        
         public function getInterpretationReadingDetails($id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
				
//	old	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."'";
               $sql = "SELECT * FROM `tbl_reading` WHERE interpretation_id ='".$id."'";
//               $sql = "SELECT * FROM `tbl_interpretation` "
//                    . "LEFT JOIN tbl_interpretation_add_more ON tbl_interpretation.interpretation_id = tbl_interpretation_add_more.interpret_id WHERE tbl_interpretation.interpretation_id = '".$id."'";
		  $STH = $DBH->prepare($sql); 
                  $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
                        $interpretation_id = stripslashes($row['interpretation_id']);
                        $lab = stripslashes($row['lab']);
                        $adviser = stripslashes($row['adviser']);
                        $interpretation_code = stripslashes($row['interpretation_code']);
                   
                        $interpretation_no = stripslashes($row['interpretation_no']);
			$interpretation_criteria = stripslashes($row['interpretation_criteria']);
			$scale_form = stripslashes($row['scale_form']);
			$scale_to = stripslashes($row['scale_to']);
			$symptom_type = stripslashes($row['symptom_type']);
			$symptom_name = stripslashes($row['symptom_name']);
			$listing_order = stripslashes($row['listing_order']);
			$prof_cat1 = stripslashes($row['prof_cat1']);
                        $sub_cat1 = stripslashes($row['sub_cat1']);
                        $prof_cat2 = stripslashes($row['prof_cat2']);
                        $sub_cat2 = stripslashes($row['sub_cat2']);
                        $prof_cat3 = stripslashes($row['prof_cat3']);
                        $sub_cat3 = stripslashes($row['sub_cat3']);
                        $prof_cat4 = stripslashes($row['prof_cat4']);
                        $sub_cat4 = stripslashes($row['sub_cat4']);
                        $prof_cat5 = stripslashes($row['prof_cat5']);
                        $sub_cat5 = stripslashes($row['sub_cat5']);
                        $prof_cat6 = stripslashes($row['prof_cat6']);
                        $sub_cat6 = stripslashes($row['sub_cat6']);
                        $prof_cat7 = stripslashes($row['prof_cat7']);
                        $sub_cat7 = stripslashes($row['sub_cat7']);
                        $prof_cat8 = stripslashes($row['prof_cat8']);
                        $sub_cat8 = stripslashes($row['sub_cat8']);
                        $prof_cat9 = stripslashes($row['prof_cat9']);
                        $sub_cat9 = stripslashes($row['sub_cat9']);
                        $prof_cat10 = stripslashes($row['prof_cat10']);
                        $sub_cat10 = stripslashes($row['sub_cat10']);
                        $interpretation = stripslashes($row['interpretation']);
                        $comment = stripslashes($row['comment']);
                        $user_type=stripslashes($row['identity_type']);
                        $identity_id=stripslashes($row['identity_id']);
                        $share_type=stripslashes($row['share_type']);
                        $healcareandwellbeing=stripslashes($row['healcareandwellbeing']);
                        
                        $test_no=stripslashes($row['test_no']);
                        $referred_by_adviser=stripslashes($row['referred_by_adviser']);
                        $referred_from_lab=stripslashes($row['referred_from_lab']);
                        $name=stripslashes($row['name']);
                        $registration_id=stripslashes($row['registration_id']);
                        $gender=stripslashes($row['gender']);
			$age=stripslashes($row['age']);
                        $test_date=stripslashes($row['test_date']);
			
                        
			
		}
		return array($healcareandwellbeing,$test_no,$identity_type,$identity_id,$lab,$adviser,$referred_by_adviser,$referred_from_lab,$name,$registration_id,$gender,$age,$test_date,$name,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$share_type,$listing_order,$prof_cat1,$sub_cat1,$prof_cat2,$sub_cat2,$prof_cat3,$sub_cat3,$prof_cat4,$sub_cat4,$prof_cat5,$sub_cat5,$prof_cat6,$sub_cat6,$prof_cat7,$sub_cat7,$prof_cat8,$sub_cat8,$prof_cat9,$sub_cat9,$prof_cat10,$sub_cat10);
	}
        
	public function getPractitionersName($pro_user_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$name = '';
		
		$sql = "SELECT * FROM `tblprofusers` WHERE `pro_user_id` = '".$pro_user_id."'";
		  $STH = $DBH->prepare($sql);
                  $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$name = stripslashes($row['name']);
		}
		return $name;
	
	}
	
	public function addQuestionOld($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$state_id,$city_id,$user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$country_id,$place_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
				
		$sql = "INSERT INTO `tblgeneralstressors` (`situation`,`situation_font_family`,`situation_font_size`,`situation_font_color`,`listing_date_type`,`days_of_month`,`single_date`,`start_date`,`end_date`,`country_id`,`state_id`,`city_id`,`place_id`,`user_id`,`practitioner_id`,`keywords`,`listing_order`,`status`) VALUES ('".addslashes($situation)."','".addslashes($situation_font_family)."','".addslashes($situation_font_size)."','".addslashes($situation_font_color)."','".addslashes($listing_date_type)."','".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($user_id)."','".addslashes($practitioner_id)."','".addslashes($keywords)."','".addslashes($listing_order)."','1')";
		  $STH = $DBH->prepare($sql); 
                  $STH->execute();
		if($STH->result)
		{
			$return = true;
			$situation_id = $this->getInsertID();
			for($i=0;$i<count($arr_min_rating);$i++)
			{
				$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('generalstressors','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
				$STH = $DBH->prepare($sql2); 
                  $STH->execute();
			}	
		}
		return $return;
	}
	
	public function addGoalAndQuery($user_interaction_type,$question,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$days_of_week,$healcareandwellbeing,$identity_type,$identity_id,$lab,$adviser,$referred_by,$referred_from,$patient_name,$reg_id,$gender,$age,$test_no,$test_date,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$listing_order,$share_type)
	{  
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
			
		echo $sql = "INSERT INTO `tblgoals_query` (`days_of_week`,`user_interaction_type`,`question`,`question_font_family`,`question_font_size`,`question_font_color`,`listing_date_type`,`days_of_month`,`single_date`,`start_date`,`end_date`,`healcareandwellbeing`,`identity_type`,`identity_id`,`lab`,`adviser`,`referred_by_adviser`,`referred_from_lab`,`registration_id`,`name`,`gender`,`age`,`test_no`,`test_date`,`interpretation_criteria`,`scale_form`,`scale_to`,`symptom_type`,`symptom_name`,`listing_order`,`share_type`,`status`) VALUES ('".addslashes($days_of_week)."','".addslashes($user_interaction_type)."','".addslashes($question)."','".addslashes($situation_font_family)."','".addslashes($situation_font_size)."','".addslashes($situation_font_color)."','".addslashes($listing_date_type)."','".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."','".addslashes($healcareandwellbeing)."','".addslashes($identity_type)."','".addslashes($identity_id)."','".addslashes($lab)."','".addslashes($adviser)."','".addslashes($referred_by)."','".addslashes($referred_from)."','".addslashes($patient_name)."','".addslashes($reg_id)."','".addslashes($gender)."','".addslashes($age)."','".addslashes($test_no)."','".addslashes($test_date)."','".addslashes($interpretation_criteria)."','".addslashes($scale_form)."','".addslashes($scale_to)."','".addslashes($symptom_type)."','".addslashes($symptom_name)."','".addslashes($listing_order)."','".addslashes($share_type)."','1')";
		  $STH = $DBH->prepare($sql); 
                  $STH->execute();
		if($STH->result)
		{
			$return = true;
			$gs_id = $this->getInsertID();
			for($i=0;$i<$total_count;$i++)
			{
				$sql2 = "INSERT INTO `tbl_general_stressors_prof_cat` (`gs_id`,`prof_cat`,`sub_cat`) VALUES ('".addslashes($gs_id)."','".$prof_cat[$i]."','".$sub_cat[$i]."')";
				$STH = $DBH->prepare($sql2); 
                                $STH->execute();
			}	
		}
		return $return;
	}
        public function addQuestion($fav_cat_type_id,$symptom_type,$symptom_name,$arr_min_rating,$arr_max_rating,$prof_cat,$sub_cat,$total_count,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$state_id,$city_id,$place_id,$str_user_id,$practitioner_id,$listing_order,$gender,$flag,$user_age1,$user_age2,$user_service,$users_food_option,$users_height1,$users_height2,$users_weight1,$users_weight2,$users_bmi1,$users_bmi2,$arr_interpretaion,$treatment)
	{  
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
			
		$sql = "INSERT INTO `tbl_general_stressors` (`treatment`,`symptom_cat`,`symptom_type`,`symptom_name`,`scale_from`,`scale_to`,`listing_date_type`,`days_of_month`,`single_date`,`start_date`,`end_date`,`country_id`,`state_id`,`city_id`,`place_id`,`user_id`,`practitioner_id`,`listing_order`,`gender`,`flag`,`age1`,`age2`,`user_service`,`users_food_option`,`users_height1`,`users_height2`,`users_weight1`,`users_weight2`,`users_bmi1`,`users_bmi2`,`status`) VALUES ('".addslashes($treatment)."','".addslashes($fav_cat_type_id)."','".addslashes($symptom_type)."','".addslashes($symptom_name)."','".addslashes($arr_min_rating)."','".addslashes($arr_max_rating)."','".addslashes($listing_date_type)."','".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($str_user_id)."','".addslashes($practitioner_id)."','".addslashes($listing_order)."','".addslashes($gender)."','".addslashes($flag)."','".addslashes($user_age1)."','".addslashes($user_age2)."','".addslashes($user_service)."','".addslashes($users_food_option)."','".addslashes($users_height1)."','".addslashes($users_height2)."','".addslashes($users_weight1)."','".addslashes($users_weight2)."','".addslashes($users_bmi1)."','".addslashes($users_bmi2)."','1')";
		  $STH = $DBH->prepare($sql);
                  $STH->execute();
		if($STH->result)
		{
			$return = true;
			$gs_id = $this->getInsertID();
			for($i=0;$i<$total_count;$i++)
			{
				$sql2 = "INSERT INTO `tbl_general_stressors_prof_cat` (`gs_id`,`prof_cat`,`sub_cat`) VALUES ('".addslashes($gs_id)."','".$prof_cat[$i]."','".$sub_cat[$i]."')";
				$STH = $DBH->prepare($sql2); 
                                $STH->execute();
			}	
		}
		return $return;
	}
	
//        public function addInterpretation($prof_cat,$sub_cat,$total_count,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$listing_order,$arr_interpretaion,$comment,$row_totalRow)
//	{     
//		$my_DBH = new mysqlConnection();$DBH = $my_DBH->raw_handle();$DBH->beginTransaction();
//		$return = false;
//			
//		$sql = "INSERT INTO `tbl_interpretation` (`interpretation_criteria`,`scale_form`,`scale_to`,`symptom_type`,`symptom_name`,`listing_order`,`prof_cat1`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`prof_cat5`,`prof_cat6`,`prof_cat7`,`prof_cat8`,`prof_cat9`,`prof_cat10`,`sub_cat1`,`sub_cat2`,`sub_cat3`,`sub_cat4`,`sub_cat5`,`sub_cat6`,`sub_cat7`,`sub_cat8`,`sub_cat9`,`sub_cat10`) VALUES ('".addslashes($interpretation_criteria)."','".addslashes($scale_form)."','".addslashes($scale_to)."','".addslashes($symptom_type)."','".addslashes($symptom_name)."','".addslashes($listing_order)."','".$prof_cat[0]."','".$prof_cat[1]."','".$prof_cat[2]."','".$prof_cat[3]."','".$prof_cat[4]."','".$prof_cat[5]."','".$prof_cat[6]."','".$prof_cat[7]."','".$prof_cat[8]."','".$prof_cat[9]."','".$sub_cat[0]."','".$sub_cat[1]."','".$sub_cat[2]."','".$sub_cat[3]."','".$sub_cat[4]."','".$sub_cat[5]."','".$sub_cat[6]."','".$sub_cat[7]."','".$sub_cat[8]."','".$sub_cat[9]."')";
//		  $STH = $DBH->prepare($sql);  $STH->execute();
////		if($this->result)
////		{
////			$return = true;
////			$interpretation_id = $this->getInsertID();
////                        
////			for($i=0;$i<$total_count;$i++)
////			{
////				$sql2 = "INSERT INTO `tbl_interpretation_prof_cat` (`interpretation_id`,`prof_cat`,`sub_cat`) VALUES ('".addslashes($interpretation_id)."','".$prof_cat[$i]."','".$sub_cat[$i]."')";
////				$this->execute_query($sql2);
////			}	
////		}
//                if($this->result)
//		{      $date=date('Y-m-d h:i:s');
//			$return = true;
//                        $interpretation_id = $this->getInsertID();
//			for($j=0;$j<$row_totalRow;$j++)
//			{
//                                $interpretaion = $this->getInterpretationnaebyid($arr_interpretaion[$j]);
//				$sql3 = "INSERT INTO `tbl_interpretation_add_more` (`interpretation_id`,`interpretation`,`comment`,`date`,`status`) VALUES ('".addslashes($interpretation_id)."','".$interpretaion."','".$comment[$j]."','".$date."','1')";
//				$this->execute_query($sql3);
//			}	
//		}
//		return $return;
//	}
        
         public function addInterpretation($healcareandwellbeing,$lab,$adviser,$interpretation_code,$interpretation_no,$prof_cat,$sub_cat,$total_count,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$listing_order,$arr_interpretaion,$comment,$share_type,$row_totalRow,$admin_id,$user_type)
	{     
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
			
		$sql = "INSERT INTO `tbl_interpretation` (`healcareandwellbeing`,`lab`,`adviser`,`interpretation_code`,`interpretation_no`,`interpretation_criteria`,`scale_form`,`scale_to`,`symptom_type`,`symptom_name`,`listing_order`,`prof_cat1`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`prof_cat5`,`prof_cat6`,`prof_cat7`,`prof_cat8`,`prof_cat9`,`prof_cat10`,`sub_cat1`,`sub_cat2`,`sub_cat3`,`sub_cat4`,`sub_cat5`,`sub_cat6`,`sub_cat7`,`sub_cat8`,`sub_cat9`,`sub_cat10`,`share_type`,`identity_id`,`identity_type`) VALUES ('".addslashes($healcareandwellbeing)."','".addslashes($lab)."','".addslashes($adviser)."','".addslashes($interpretation_code)."','".addslashes($interpretation_no)."','".addslashes($interpretation_criteria)."','".addslashes($scale_form)."','".addslashes($scale_to)."','".addslashes($symptom_type)."','".addslashes($symptom_name)."','".addslashes($listing_order)."','".$prof_cat[0]."','".$prof_cat[1]."','".$prof_cat[2]."','".$prof_cat[3]."','".$prof_cat[4]."','".$prof_cat[5]."','".$prof_cat[6]."','".$prof_cat[7]."','".$prof_cat[8]."','".$prof_cat[9]."','".$sub_cat[0]."','".$sub_cat[1]."','".$sub_cat[2]."','".$sub_cat[3]."','".$sub_cat[4]."','".$sub_cat[5]."','".$sub_cat[6]."','".$sub_cat[7]."','".$sub_cat[8]."','".$sub_cat[9]."','".$share_type."','".$admin_id."','".$user_type."')";
		  $STH = $DBH->prepare($sql); 
                  $STH->execute();
//		if($this->result)
//		{
//			$return = true;
//			$interpretation_id = $this->getInsertID();
//                        
//			for($i=0;$i<$total_count;$i++)
//			{
//				$sql2 = "INSERT INTO `tbl_interpretation_prof_cat` (`interpretation_id`,`prof_cat`,`sub_cat`) VALUES ('".addslashes($interpretation_id)."','".$prof_cat[$i]."','".$sub_cat[$i]."')";
//				$this->execute_query($sql2);
//			}	
//		}
                if($STH->result)
		{      $date=date('Y-m-d h:i:s');
			$return = true;
                        $interpretation_id = $this->getInsertID();
			for($j=0;$j<$row_totalRow;$j++)
			{
                                $interpretaion = $this->getInterpretationnaebyid($arr_interpretaion[$j]);
				$sql3 = "INSERT INTO `tbl_interpretation_add_more` (`interpret_id`,`interpretation`,`comment`,`date`,`status`) VALUES ('".addslashes($interpretation_id)."','".$interpretaion."','".$comment[$j]."','".$date."','1')";
				$STH = $DBH->prepare($sql3); 
                                $STH->execute();
			}	
		}
		return $return;
	}
        
         public function getInterpretationnaebyid($interpretaionname)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = '';
            
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_name` = '".$interpretaionname."' ";
              $STH = $DBH->prepare($sql);
              $STH->execute();
            if($STH->rowCount() > 0)
            {
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                    $return = $row['bms_id'];
            }
            return $return;
	}
	
        
	public function getQuestionDetails($gs_id)
	{
		$my_DBH = new mysqlConnection();$DBH = $my_DBH->raw_handle();$DBH->beginTransaction();
		$arr_min_rating = array();
		$arr_max_rating = array();
		$arr_interpretaion = array();
		$arr_treatment = array();
		
		$sql = "SELECT * FROM `tblgeneralstressors` WHERE `gs_id` = '".$gs_id."'";
		  $STH = $DBH->prepare($sql);
                  $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$situation = stripslashes($row['situation']);
			$situation_font_family = stripslashes($row['situation_font_family']);
			$situation_font_size = stripslashes($row['situation_font_size']);
			$situation_font_color = stripslashes($row['situation_font_color']);
			$listing_date_type = stripslashes($row['listing_date_type']);
			$days_of_month = stripslashes($row['days_of_month']);
			$single_date = stripslashes($row['single_date']);
			$start_date = stripslashes($row['start_date']);
			$end_date = stripslashes($row['end_date']);
			$country_id = stripslashes($row['country_id']);
			$state_id = stripslashes($row['state_id']);
			$city_id = stripslashes($row['city_id']);
			$place_id = stripslashes($row['place_id']);
			$user_id = stripslashes($row['user_id']);
			$practitioner_id = stripslashes($row['practitioner_id']);
			$keywords = stripslashes($row['keywords']);
			$listing_order = stripslashes($row['listing_order']);
			$status = stripslashes($row['status']);
			
			$sql2 = "SELECT * FROM `tblemotionstreatments` WHERE `situation_id` = '".$gs_id."' AND `et_type` = 'generalstressors'  ORDER BY `et_id`";
			$STH = $DBH->prepare($sql2); 
                        $STH->execute();
			if($STH->rowCount() > 0)
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
		return array($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$state_id,$city_id,$place_id,$user_id,$practitioner_id,$keywords,$listing_order,$status,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment);
	}
	
	public function updateQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$state_id,$city_id,$place_id,$user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$status,$gs_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		
		$upd_sql = "UPDATE `tblgeneralstressors` SET `situation` = '".addslashes($situation)."' , `situation_font_family` = '".addslashes($situation_font_family)."' , `situation_font_size` = '".addslashes($situation_font_size)."' , `situation_font_color` = '".addslashes($situation_font_color)."' , `listing_date_type` = '".addslashes($listing_date_type)."' , `days_of_month` = '".addslashes($days_of_month)."' , `single_date` = '".addslashes($single_date)."' , `start_date` = '".addslashes($start_date)."' , `end_date` = '".addslashes($end_date)."' , `country_id` = '".addslashes($country_id)."'  , `state_id` = '".addslashes($state_id)."' , `city_id` = '".addslashes($city_id)."'  , `place_id` = '".addslashes($place_id)."' , `user_id` = '".addslashes($user_id)."' , `practitioner_id` = '".addslashes($practitioner_id)."' , `keywords` = '".addslashes($keywords)."' , `listing_order` = '".addslashes($listing_order)."' , `status` = '".addslashes($status)."'  WHERE `gs_id` = '".$gs_id."'";
		$STH = $DBH->prepare($upd_sql); 
                        $STH->execute();
		if($STH->result)
		{
			$return = true;
			$situation_id = $gs_id;
			$del_sql1 = "DELETE FROM `tblemotionstreatments` WHERE `situation_id` = '".$situation_id."' AND `et_type` = 'generalstressors' "; 
			$STH = $DBH->prepare($del_sql1); 
                        $STH->execute();
			for($i=0;$i<count($arr_min_rating);$i++)
			{
				$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('generalstressors','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
				$STH2 = $DBH->prepare($sql2); 
                                $STH2->execute();
			}	
		}
		return $return;
	}
	
	public function deleteGSQuestion($gs_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$del_sql1 = "DELETE FROM `tblgeneralstressors` WHERE `gs_id` = '".$gs_id."'"; 
		$STH = $DBH->prepare($del_sql1);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
        public function deleteAssignInterpretation($id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$del_sql1 = "DELETE FROM `tbl_interpretation_add_more` WHERE `interpretation_add_more_id` = '".$id."'"; 
		$STH = $DBH->prepare($del_sql1);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function getFontFamilyOptions($font_family)
	{
		$option_str = '';		
		
		$arr_font_family = array('Tahoma','Verdana','Arial Black','Comic Sans MS','Lucida Console','Palatino Linotype','MS Sans Serif4','System','Georgia1','Impact','Courier');
		sort($arr_font_family);
		
		for($i=0;$i<count($arr_font_family);$i++)
		{
			if($arr_font_family[$i] == $font_family)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$arr_font_family[$i].'" '.$sel.'>'.$arr_font_family[$i].'</option>';
		}
		return $option_str;
	}
	
	public function getFontSizeOptions($font_size)
	{
		$option_str = '';		
		
		$arr_font_size = array('8','9','10','11','12','13','14','16','18','20','22','24','28','30','32');
		sort($arr_font_size);
		
		for($i=0;$i<count($arr_font_size);$i++)
		{
			if($arr_font_size[$i] == $font_size)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$arr_font_size[$i].'" '.$sel.'>'.$arr_font_size[$i].'px</option>';
		}
		return $option_str;
	}
        
        public function getProUsersOptionsSearch($pro_user_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = array();
				
		$sql = "SELECT * FROM `tblprofusers` where `service_clinic_name`!='' ORDER BY `service_clinic_name` ASC";
		  $STH = $DBH->prepare($sql); 
                  $STH->execute();
		if($STH->rowCount() > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
			{
				$option_str[] = $row['service_clinic_name'];
			}
		}
		return $option_str;
	} 
       public function getPersonUsersOptionsSerch($pro_user_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';
				
		$sql = "SELECT * FROM `tblvendorlocations` where `contact_person`!='' ORDER BY `contact_person` ASC";
		  $STH = $DBH->prepare($sql); 
                  $STH->execute();
		if($STH->rowCount() > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
			{
                           $option_str[] = $row['contact_person'];
			}
		}
		return $option_str;
	} 
        public function getUsers($user_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';
				
		$sql = "SELECT * FROM `tblusers` where 1 ORDER BY `name` ASC";
		  $STH = $DBH->prepare($sql);
                  $STH->execute();
		if($STH->rowCount() > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
			{
				if($row['user_id'] == $user_id)
				{
					$selected = ' selected ';
				}
				else
				{
					$selected = '';
				}
				$option_str .= '<option value="'.$row['user_id'].'" '.$selected.' >'.stripslashes($row['name'].' '.$row['middle_name'].' '.$row['last_name']).'</option>';
			}
		}
		return $option_str;
	}
        
        public function addReading($healcareandwellbeing,$identity_type,$identity_id,$lab,$adviser,$referred_by,$referred_from,$prof_cat,$sub_cat,$patient_name,$reg_id,$gender,$age,$test_no,$test_date,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$listing_order,$share_type)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
				
		$sql = "INSERT INTO `tbl_reading` (`healcareandwellbeing`,`identity_type`,`identity_id`,`lab`,`adviser`,`referred_by_adviser`,`referred_from_lab`,`prof_cat1`,`prof_cat2`,`prof_cat3`,`prof_cat4`,`prof_cat5`,`prof_cat6`,`prof_cat7`,`prof_cat8`,`prof_cat9`,`prof_cat10`,`sub_cat1`,`sub_cat2`,`sub_cat3`,`sub_cat4`,`sub_cat5`,`sub_cat6`,`sub_cat7`,`sub_cat8`,`sub_cat9`,`sub_cat10`,`name`,`registration_id`,`gender`,`age`,`test_no`,`test_date`,`interpretation_criteria`,`scale_form`,`scale_to`,`symptom_type`,`symptom_name`,`listing_order`,`share_type`) VALUES ('".$healcareandwellbeing."','".$identity_type."','".$identity_id."','".addslashes($lab)."','".addslashes($adviser)."','".addslashes($referred_by)."','".addslashes($referred_from)."','".addslashes($prof_cat[0])."','".addslashes($prof_cat[1])."','".addslashes($prof_cat[2])."','".addslashes($prof_cat[3])."','".addslashes($prof_cat[4])."','".addslashes($prof_cat[5])."','".addslashes($prof_cat[6])."','".addslashes($prof_cat[7])."','".addslashes($prof_cat[8])."','".addslashes($prof_cat[9])."','".addslashes($sub_cat[0])."','".addslashes($sub_cat[1])."','".addslashes($sub_cat[2])."','".addslashes($sub_cat[3])."','".addslashes($sub_cat[4])."','".addslashes($sub_cat[5])."','".addslashes($sub_cat[6])."','".addslashes($sub_cat[7])."','".addslashes($sub_cat[8])."','".$sub_cat[9]."','".$patient_name."','".$reg_id."','".$gender."','".$age."','".$test_no."','".$test_date."','".$interpretation_criteria."','".$scale_form."','".$scale_to."','".$symptom_type."','".$symptom_name."','".$listing_order."','".$share_type."')";
		 $STH = $DBH->prepare($sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
         public function updateReading($healcareandwellbeing,$identity_type,$identity_id,$lab,$adviser,$referred_by,$referred_from,$prof_cat,$sub_cat,$patient_name,$reg_id,$gender,$age,$test_no,$test_date,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$listing_order,$share_type,$id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
//		$now = time();
		
		 $upd_sql = "UPDATE `tbl_reading` SET `healcareandwellbeing` = '".$healcareandwellbeing."' ,`name` = '".$patient_name."' ,`registration_id` = '".$reg_id."' , `gender` = '".$gender."' , `age` = '".$age."', `test_no` = '".$test_no."', `test_date` = '".$test_date."',`share_type` = '".$share_type."' ,`identity_type` = '".$identity_type."' , `identity_id` = '".$identity_id."' , `lab` = '".$lab."', `adviser` = '".$adviser."', `referred_by_adviser` = '".$referred_by."',`referred_from_lab` = '".$referred_from."',`interpretation_criteria` = '".$interpretation_criteria."' , `scale_form` = '".$scale_form."' , `scale_to` = '".$scale_to."', `symptom_type` = '".$symptom_type."', `symptom_name` = '".$symptom_name."',`listing_order` = '".$listing_order."',`prof_cat1` = '".$prof_cat[0]."',`prof_cat2` = '".$prof_cat[1]."',`prof_cat3` = '".$prof_cat[2]."',`prof_cat4` = '".$prof_cat[3]."',`prof_cat5` = '".$prof_cat[4]."',`prof_cat6` = '".$prof_cat[5]."',`prof_cat7` = '".$prof_cat[6]."',`prof_cat8` = '".$prof_cat[7]."',`prof_cat9` = '".$prof_cat[8]."',`prof_cat10` = '".$prof_cat[9]."',`sub_cat1` = '".$sub_cat[0]."',`sub_cat2` = '".$sub_cat[1]."',`sub_cat3` = '".$sub_cat[2]."',`sub_cat4` = '".$sub_cat[3]."',`sub_cat5` = '".$sub_cat[4]."',`sub_cat6` = '".$sub_cat[5]."',`sub_cat7` = '".$sub_cat[6]."',`sub_cat8` = '".$sub_cat[7]."',`sub_cat9` = '".$sub_cat[8]."',`sub_cat10` = '".$sub_cat[9]."'   WHERE `interpretation_id` = '".$id."'";
		 $STH = $DBH->prepare($upd_sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
        
         public function getShareTypeNameById($fav_cat_id)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = '';
            
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";
              $STH = $DBH->prepare($sql);
              $STH->execute();
            if($STH->rowCount() > 0)
            {
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                    $return = $row['fav_cat'];
            }
            return $return;
	}
	
}
?>