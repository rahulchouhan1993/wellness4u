<?php
include_once("class.paging.php");
include_once("class.admin.php");
class RewardPoint extends Admin
{
	public function GetUsersOptions($user_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';
		$sql = "SELECT * FROM `tblusers` ORDER BY `name` ASC";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
			{
				if($user_id == $row['user_id'])
				{
					$selected = ' selected ';
				}
				else
				{
					$selected = '';
				}
				$option_str .= '<option value="'.$row['user_id'].'" '.$selected.' >'.stripslashes($row['name']).'</option>';
			}
		}
		return $option_str;
	}

	public function GetAllRewardsModuleList($search)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '141';
		$delete_action_id = '143';
		
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($search == '')
			{
				$sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_deleted` = '0' ORDER BY `reward_module_title` ASC ";
			}
		else
			{
			    $sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_title` LIKE '%".$search."%' AND `reward_module_deleted` = '0' ORDER BY `reward_module_title` ASC";
			}
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=reward_modules");
	 	//$result=$this->execute_query($page->get_limit_query($sql));
                
                $STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();
		$output = '';		
		if($STH2->rowCount() > 0)
		{
                        $obj2 = new RewardPoint();
			$i = 1;
			while($row = $STH2->fetch(PDO::FETCH_ASSOC))
			{
				if($row['reward_module_status'] == '1')
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Inactive';
				}
				
//				if($row['page_id'] == '0')
//				{
//					$title = stripslashes($row['reward_module_title']);
//				}
//				else
//				{
//					//$obj2 = new RewardPoint();
//										
//					//$title = $obj2->getMenuTitleOfPage($row['page_id']);
//					//if($title == '')
//					//{
//						$title = stripslashes($row['reward_module_title']);
//					//}
//				}
                                
                                $title = stripslashes($row['reward_module_title']);
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center">'.$title.'</td>';
				$output .= '<td height="30" align="center">'.$status.'</td>';
                                $added_by_admin = $obj2->getUsenameOfAdmin($row['posted_by']);
                                $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';
                                $output .= '<td height="30" align="center">'.date("d-m-Y h:i:s",strtotime($row['reward_module_add_datetime'])).'</td>';
				$output .= '<td height="30" align="center" nowrap="nowrap">';
				if($edit) {
				$output .= '<a href="index.php?mode=edit_reward_module&id='.$row['reward_module_id'].'" ><img src = "images/edit.gif" border="0"></a>';
				}
				$output .= '</td>';
				//$output .= '<td height="30" align="center" nowrap="nowrap">';
						//if($delete) {
				//$output .= '<a href=\'javascript:fn_confirmdelete("Reward Module","sql/delrewardmodule.php?id='.$row['reward_module_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
				//				}
				//$output .= '</td>';
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


   public function geteventname($eventid)
   {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT `event_name` FROM `tbl_event_master` WHERE `event_master_id` = '".$eventid."' AND `is_deleted` = '0' ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{	
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$return = $row['event_name'];
		}
		return $return;

   }





	
	public function GetAllRewardsPointList($search)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		
		$edit_action_id = '252';
                $delete_action_id = '139';
		
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
                $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($search == '')
		{
			$sql = "SELECT rp.* , rm.reward_module_title , rc.reward_criteria_title AS reward_point_conversion_title , rc2.reward_criteria_title AS reward_point_cutoff_title FROM `tblrewardpoints` AS rp LEFT JOIN `tblrewardmodules` AS rm ON rp.reward_point_module_id = rm.reward_module_id LEFT JOIN `tblrewardcriteria` AS rc ON rp.reward_point_conversion_type_id = rc.reward_criteria_id  LEFT JOIN `tblrewardcriteria` AS rc2 ON rp.reward_point_cutoff_type_id = rc2.reward_criteria_id WHERE rp.reward_point_deleted = '0' AND rm.reward_module_deleted = '0' ORDER BY rp.reward_point_date DESC , rm.reward_module_title ASC ";
		}
		else
		{
			$sql = "SELECT rp.* , rm.reward_module_title , rc.reward_criteria_title AS reward_point_conversion_title , rc2.reward_criteria_title AS reward_point_cutoff_title FROM `tblrewardpoints` AS rp LEFT JOIN `tblrewardmodules` AS rm ON rp.reward_point_module_id = rm.reward_module_id LEFT JOIN `tblrewardcriteria` AS rc ON rp.reward_point_conversion_type_id = rc.reward_criteria_id  LEFT JOIN `tblrewardcriteria` AS rc2 ON rp.reward_point_cutoff_type_id = rc2.reward_criteria_id WHERE rp.reward_point_deleted = '0' AND rm.reward_module_deleted = '0' AND rm.reward_module_title LIKE '%".$search."%' ORDER BY rp.reward_point_date DESC , rm.reward_module_title ASC ";
		
		}
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=reward_points");
	 	//$result=$this->execute_query($page->get_limit_query($sql));
                $STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();
		$output = '';		
		if($STH2->rowCount() > 0)
		{
			$i = 1;
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
			{
                 
				// echo "<pre>";print_r($row);echo "</pre>";
                 $vals=$this->getrewardTypevalueKR($row['reward_type']);


				if($row['reward_point_status'] == '1')
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Inactive';
				}
				
				if($row['reward_point_cutoff_type_id'] == '0')
				{
					$reward_point_cutoff_title = 'None';
				}
				else
				{
					$reward_point_cutoff_title = stripslashes($row['reward_point_cutoff_title']);
				}
			
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center">'.$status.'</td>';
				$output .= '<td height="30" align="center">'.date('d-m-Y h:i:a',strtotime($row['reward_point_add_datetime'])).'</td>';

				 $output .= '<td height="30" align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_reward_point&id='.$row['reward_point_id'].'" ><img src = "images/edit.gif" border="0"></a>';
								}
				$output .= '</td>';
				$output .= '<td height="30" align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Reward Point","sql/delrewardpoint.php?id='.$row['reward_point_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
								}
				$output .= '</td>';

				$output .= '<td height="30" align="center">'.date('d-m-Y ',strtotime($row['reward_point_date'])).'</td>';


                $output .= '<td height="30" align="center">'.stripslashes($row['identity_id']).'</td>';
                $output .= '<td height="30" align="center">'.stripslashes($row['identity_type']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reference_number']).'</td>';
				$output .= '<td height="30" align="center">'.$this->geteventname($row['event_id']).'</td>';

				$output .= '<td height="30" align="center">'.$this->getrewardmaincat1($row['reward_main_cat_1']).'</td>';
				$output .= '<td height="30" align="center">'.$this->getrewardsubcat1($row['reward_sub_cat_1']).'</td>';            
                $output .= '<td height="30" align="center">'.$this->getrewardmaincat1($row['reward_main_cat_2']).'</td>'; 


				$output .= '<td height="30" align="center">'.stripslashes($row['reward_title_remark']).'</td>';            
                $output .= '<td height="30" align="center">'.stripslashes($row['event_close_date']).'</td>'; 

				$output .= '<td height="30" align="center">'.stripslashes($row['reward_module_title']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reward_point_conversion_title']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reward_point_conversion_value']).'</td>';
				$output .= '<td height="30" align="center">'.$reward_point_cutoff_title.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['reward_point_min_cutoff']).'</td>';
				

				$output .= '<td height="30" align="center">'.stripslashes($row['reward_point_max_cutoff']).'</td>';
				$output .= '<td height="30" align="center">'.$vals[1].'</td>';

	         
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="23" align="center">NO RECORDS FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}


   
	
	public function GetAllRewardsBonusList($search)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '251';
                $delete_action_id = '146';
		
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
                $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($search == '')
		{
			$sql = "SELECT rp.* , rm.reward_module_title , rc.reward_criteria_title AS reward_bonus_conversion_title , rc2.reward_criteria_title AS reward_bonus_cutoff_title FROM `tblrewardbonus` AS rp LEFT JOIN `tblrewardmodules` AS rm ON rp.reward_bonus_module_id = rm.reward_module_id LEFT JOIN `tblrewardcriteria` AS rc ON rp.reward_bonus_conversion_type_id = rc.reward_criteria_id  LEFT JOIN `tblrewardcriteria` AS rc2 ON rp.reward_bonus_cutoff_type_id = rc2.reward_criteria_id WHERE rp.reward_bonus_deleted = '0' AND rm.reward_module_deleted = '0' ORDER BY rp.reward_bonus_date DESC , rm.reward_module_title ASC ";
		}
		else
		{
			$sql = "SELECT rp.* , rm.reward_module_title , rc.reward_criteria_title AS reward_bonus_conversion_title , rc2.reward_criteria_title AS reward_bonus_cutoff_title FROM `tblrewardbonus` AS rp LEFT JOIN `tblrewardmodules` AS rm ON rp.reward_bonus_module_id = rm.reward_module_id LEFT JOIN `tblrewardcriteria` AS rc ON rp.reward_bonus_conversion_type_id = rc.reward_criteria_id  LEFT JOIN `tblrewardcriteria` AS rc2 ON rp.reward_bonus_cutoff_type_id = rc2.reward_criteria_id WHERE rp.reward_bonus_deleted = '0' AND rm.reward_module_deleted = '0' AND rm.reward_module_title LIKE '%".$search."%' ORDER BY rp.reward_bonus_date DESC , rm.reward_module_title ASC ";
		}
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records = $STH->rowCount();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=reward_bonus");
                
	 	//$result=$this->execute_query($page->get_limit_query($sql));
                
                $STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();
                
		$output = '';		
		if($STH->rowCount() > 0)
		{
			$i = 1;
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
			{

				// echo "<pre>";print_r($row);echo "</pre>";

                $vals=$this->getrewardTypevalueKR($row['reward_type']);

				if($row['reward_bonus_status'] == '1')
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Inactive';
				}
				
				if($row['reward_bonus_cutoff_type_id'] == '0')
				{
					$reward_bonus_cutoff_title = 'None';
				}
				else
				{
					$reward_bonus_cutoff_title = stripslashes($row['reward_bonus_cutoff_title']);
				}
				
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center">'.$status.'</td>';
				$output .= '<td height="30" align="center">'.date('d-m-y h:i:a',strtotime($row['reward_bonus_add_datetime'])).'</td>';


                $output .= '<td height="30" align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_reward_bonus&id='.$row['reward_bonus_id'].'" ><img src = "images/edit.gif" border="0"></a>';
								}
				$output .= '</td>';
                                $output .= '<td height="30" align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Reward Bonus Point","sql/delrewardbonus.php?id='.$row['reward_bonus_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
								}
				$output .= '</td>';
               $output .= '<td height="30" align="center">'.date('d-m-Y ',strtotime($row['reward_bonus_date'])).'</td>';


                   
                $output .= '<td height="30" align="center">'.stripslashes($row['identity_id']).'</td>';
                $output .= '<td height="30" align="center">'.stripslashes($row['identity_type']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reference_number']).'</td>';
				$output .= '<td height="30" align="center">'.$this->geteventname($row['event_id']).'</td>';

				$output .= '<td height="30" align="center">'.$this->getrewardmaincat1($row['reward_main_cat_1']).'</td>';
				$output .= '<td height="30" align="center">'.$this->getrewardsubcat1($row['reward_sub_cat_1']).'</td>';            
                $output .= '<td height="30" align="center">'.$this->getrewardmaincat1($row['reward_main_cat_2']).'</td>'; 

                $output .= '<td height="30" align="center">'.$this->getrewardsubcat1($row['reward_sub_cat_2']).'</td>';



				$output .= '<td height="30" align="center">'.stripslashes($row['reward_title_remark']).'</td>';            
                $output .= '<td height="30" align="center">'.stripslashes($row['event_close_date']).'</td>'; 







				$output .= '<td height="30" align="center">'.stripslashes($row['reward_module_title']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reward_bonus_conversion_title']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reward_bonus_conversion_value']).'</td>';
				$output .= '<td height="30" align="center">'.$reward_bonus_cutoff_title.'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reward_bonus_min_cutoff']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reward_bonus_max_cutoff']).'</td>';
				
                
				
                $output .= '<td height="30" align="center">'. $vals[1].'</td>';

				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="11" align="center">NO RECORDS FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function GetAllRewardsList($search)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		
		$edit_action_id = '165';
		$delete_action_id = '149';
		
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($search == '')
		{
			$sql = "SELECT rp.* , rm.reward_module_title , rc.reward_criteria_title AS reward_list_conversion_title , rc2.reward_criteria_title AS reward_list_cutoff_title FROM `tblrewardlist` AS rp LEFT JOIN `tblrewardmodules` AS rm ON rp.reward_list_module_id = rm.reward_module_id LEFT JOIN `tblrewardcriteria` AS rc ON rp.reward_list_conversion_type_id = rc.reward_criteria_id LEFT JOIN `tblrewardcriteria` AS rc2 ON rp.reward_list_cutoff_type_id = rc2.reward_criteria_id WHERE rp.reward_list_deleted = '0' AND rm.reward_module_deleted = '0' ORDER BY rp.reward_list_date DESC , rm.reward_module_title ASC ";
		}
		else
		{
			$sql = "SELECT rp.* , rm.reward_module_title , rc.reward_criteria_title AS reward_list_conversion_title , rc2.reward_criteria_title AS reward_list_cutoff_title FROM `tblrewardlist` AS rp LEFT JOIN `tblrewardmodules` AS rm ON rp.reward_list_module_id = rm.reward_module_id LEFT JOIN `tblrewardcriteria` AS rc ON rp.reward_list_conversion_type_id = rc.reward_criteria_id LEFT JOIN `tblrewardcriteria` AS rc2 ON rp.reward_list_cutoff_type_id = rc2.reward_criteria_id WHERE rp.reward_list_deleted = '0' AND rm.reward_module_deleted = '0' AND rm.reward_module_title LIKE '%".$search."%' ORDER BY rp.reward_list_date DESC , rm.reward_module_title ASC ";
		}
                
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
		$total_records=$STH->rowCount();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=reward_list");
                
	 	//$result=$this->execute_query($page->get_limit_query($sql));
                
                $STH2 = $DBH->prepare($sql);
                $STH2->execute();
                
		$output = '';		
		if($STH2->rowCount() > 0)
		{
			$i = 1;
			while($row = $STH2->fetch(PDO::FETCH_ASSOC))
			{
               $vals=$this->getrewardTypevalueKR($row['reward_type']);

				if($row['reward_list_status'] == '1')
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Inactive';
				}
				
				$reward_file_type = stripslashes($row['reward_list_file_type']);
				$reward_file = stripslashes($row['reward_list_file']);
				
				$reward_file_str = '';
				
				if($reward_file != '')
				{  
					if($reward_file_type == 'Pdf')
					{
						$reward_file_str = '<a target="_blank" href="'.SITE_URL.'/uploads/'.$reward_file.'"><img border="0" src="images/pdf-download-icon.png" width="50" height="50"  /> </a>';
					}
					elseif($reward_file_type == 'Video')
					{   
						$video_url = $this->getYoutubeString($reward_file);
						$reward_file_str = '<a target="_blank" href="'.$video_url.'">'.$video_url.'</a>';
					}
					else
					{ 
						$reward_file_str = '<img border="0" src="'.SITE_URL.'/uploads/'. $reward_file.'" height="50"  />'; 
					}		
				}
				
				if($row['reward_list_cutoff_type_id'] == '0')
				{
					$reward_list_cutoff_title = 'None';
				}
				else
				{
					$reward_list_cutoff_title = stripslashes($row['reward_list_cutoff_title']);
				}
			
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center">'.$status.'</td>';
				$output .= '<td height="30" align="center">'.date('d-m-y h:i:a',strtotime($row['reward_list_add_datetime'])).'</td>';

                
                $output .= '<td height="30" align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_reward_list&id='.$row['reward_list_id'].'" ><img src = "images/edit.gif" border="0"></a>';
								}
				$output .= '</td>';
				$output .= '<td height="30" align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Reward Item","sql/delrewardlist.php?id='.$row['reward_list_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
								}
				$output .= '</td>';


				$output .= '<td height="30" align="center">'.stripslashes($row['reference_number']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reward_module_title']).'</td>';
				$output .= '<td height="30" align="center">'.$this->geteventname($row['event_id']).'</td>';

				$output .= '<td height="30" align="center">'.$this->getrewardmaincat1($row['reward_main_cat_1']).'</td>';
				$output .= '<td height="30" align="center">'.$this->getrewardsubcat1($row['reward_sub_cat_1']).'</td>';            
                $output .= '<td height="30" align="center">'.$this->getrewardmaincat1($row['reward_main_cat_2']).'</td>'; 
                $output .= '<td height="30" align="center">'.$this->getrewardsubcat1($row['reward_sub_cat_2']).'</td>';
                $output .= '<td height="30" align="center">'.$vals[1].'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reward_title_remark']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['reward_list_name']).'</td>';
				$output .= '<td height="30" align="center">'.$reward_file_type.'</td>';
				$output .= '<td height="30" align="center">'.$reward_file_str.'</td>';
            
                $output .= '<td height="30" align="center">'.stripslashes($row['event_close_date']).'</td>'; 
                $output .= '<td height="30" align="center">'.date('d-m-Y ',strtotime($row['reward_list_date'])).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reward_list_conversion_title']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reward_list_conversion_value']).'</td>';
				$output .= '<td height="30" align="center">'.$reward_list_cutoff_title.'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reward_list_min_cutoff']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['reward_list_max_cutoff']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['identity_id']).'</td>';
                $output .= '<td height="30" align="center">'.stripslashes($row['identity_type']).'</td>';
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
	
	public function chkIfRewardModuleAlreadyExists($reward_module_title)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_title` = '".$reward_module_title."' AND `reward_module_deleted` = '0' ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{	
			$return = true;
		}
		return $return;
	}
	
	public function chkIfRewardModuleAlreadyExists_edit($reward_module_title,$reward_module_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
				
		$return = false;
		
		$sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_title` = '".$reward_module_title."' AND `reward_module_id` != '".$reward_module_id."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}

	public function getrewardTypevalueKR($rewardid)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
				
		$return = false;
		
		$sql = "SELECT `fav_cat_id`,`fav_cat` FROM `tblfavcategory` WHERE `fav_cat_id` = '".$rewardid."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);

             $return=array($row['fav_cat_id'],$row['fav_cat']);
	

		}
		return $return;
	}


	
	
	public function AddRewardPoint($reward_title_remark,$fav_cat_id_2,$fav_cat_id_1,$fav_cat_type_id_2,$fav_cat_type_id_1,$reward_point_module_id,$reward_point_conversion_type_id,$reward_point_conversion_value,$reward_point_cutoff_type_id,$reward_point_min_cutoff,$reward_point_max_cutoff,$reward_point_date,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_type,$admin_comment,$tables_names,$columns_dropdown,$tables_names2,$columns_dropdown_reword,$columns_dropdown_value_reword,$wellbeing_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
		
		$reward_point_date = date('Y-m-d',strtotime($reward_point_date));
                $reward_point_end_date = date('Y-m-d',strtotime($event_close_date));
		$ins_sql = "INSERT INTO `tblrewardpoints`(`reward_title_remark`,`reward_sub_cat_2`,`reward_main_cat_2`,`reward_sub_cat_1`,`reward_main_cat_1`,`reward_point_module_id`,`reward_point_conversion_type_id`,`reward_point_conversion_value`,`reward_point_cutoff_type_id`,`reward_point_min_cutoff`,`reward_point_max_cutoff`,`reward_point_status`,`reward_point_deleted`,`reward_point_date`,`event_id`,`wellbeing_id`,`identity_type`,`identity_id`,`reference_number`,`event_close_date`,`reward_type`,`tables_select`,`columns_id`,`tables_select2`,`columns_id2`,`columns_value2`,`admin_comment`) VALUES ('".$reward_title_remark."','".$fav_cat_id_2."','".$fav_cat_type_id_2."','".$fav_cat_id_1."','".$fav_cat_type_id_1."','".$reward_point_module_id."','".$reward_point_conversion_type_id."','".addslashes($reward_point_conversion_value)."','".$reward_point_cutoff_type_id."','".$reward_point_min_cutoff."','".$reward_point_max_cutoff."','1','0','".$reward_point_date."','".$event_id."','".$wellbeing_id."','".$identity_type."','".$identity_id."','".$reference_number."','".$reward_point_end_date."','".$reward_type."','".$tables_names."','".$columns_dropdown."','".$tables_names2."','".$columns_dropdown_reword."','".$columns_dropdown_value_reword."','".$admin_comment."')";
		$STH = $DBH->prepare($ins_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function AddRewardBonus($reward_title_remark,$fav_cat_id_2,$fav_cat_id_1,$fav_cat_type_id_2,$fav_cat_type_id_1,$reward_bonus_module_id,$reward_bonus_conversion_type_id,$reward_bonus_conversion_value,$reward_bonus_cutoff_type_id,$reward_bonus_min_cutoff,$reward_bonus_max_cutoff,$reward_bonus_date,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_type,$admin_comment,$tables_names,$columns_dropdown,$tables_names2,$columns_dropdown_reword,$columns_dropdown_value_reword)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
		
		$reward_bonus_date = date('Y-m-d',strtotime($reward_bonus_date));
                $reward_point_end_date = date('Y-m-d',strtotime($event_close_date));
		$ins_sql = "INSERT INTO `tblrewardbonus`(`reward_title_remark`,`reward_sub_cat_2`,`reward_main_cat_2`,`reward_sub_cat_1`,`reward_main_cat_1`,`reward_bonus_module_id`,`reward_bonus_conversion_type_id`,`reward_bonus_conversion_value`,`reward_bonus_cutoff_type_id`,`reward_bonus_min_cutoff`,`reward_bonus_max_cutoff`,`reward_bonus_status`,`reward_bonus_deleted`,`reward_bonus_date`,`event_id`,`identity_type`,`identity_id`,`reference_number`,`event_close_date`,`reward_type`,`tables_select`,`columns_id`,`tables_select2`,`columns_id2`,`columns_value2`,`admin_comment`) VALUES ('".$reward_title_remark."','".$fav_cat_id_2."','".$fav_cat_type_id_2."','".$fav_cat_id_1."','".$fav_cat_type_id_1."','".$reward_bonus_module_id."','".$reward_bonus_conversion_type_id."','".addslashes($reward_bonus_conversion_value)."','".$reward_bonus_cutoff_type_id."','".$reward_bonus_min_cutoff."','".$reward_bonus_max_cutoff."','1','0','".$reward_bonus_date."','".$event_id."','".$identity_type."','".$identity_id."','".$reference_number."','".$reward_point_end_date."','".$reward_type."','".$tables_names."','".$columns_dropdown."','".$tables_names2."','".$columns_dropdown_reword."','".$columns_dropdown_value_reword."','".$admin_comment."')";
		$STH = $DBH->prepare($ins_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function AddRewardList($fav_cat_type_id_1,$fav_cat_type_id_2,$fav_cat_id_1,$fav_cat_id_2,$reward_title_remark,$sponsor_type_id,$sponsor_name,$sponsor_remarks,$special_remarks,$reward_terms,$reward_list_module_id,$reward_list_conversion_type_id,$reward_list_conversion_value,$reward_list_cutoff_type_id,$reward_list_min_cutoff,$reward_list_max_cutoff,$reward_list_name,$reward_list_file_type,$reward_list_file,$reward_list_date,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_type,$admin_comment,$tables_names,$columns_dropdown,$tables_names2,$columns_dropdown_reword,$columns_dropdown_value_reword,$sponsor_list,$value_rr,$listing_date_type,$days_of_month1,$single_date,$start_date,$end_date,$days_of_week1,$months1,$shows_cat,$shows_where,$shows_gallery)
	{
      
     // ,$sponsor_list0,$sponsor_list1,$str_arr1,$str_arr2,$default_sponsor,$self_sponsor,

		// $listing_date_type,$days_of_month1,$single_date,$start_date,$end_date,$days_of_week1,$months1,$shows_cat,$shows_where,$shows_gallery

        // listing_date_type
        // days_of_month
        // single_date
        // start_date
        // end_date
        // days_of_week
        // months
        // sponsor_list1
        // sponsor_list2
        // str_sponsor_name1
        // str_sponsor_name2
        // default_sponsor
        //self_sponsor
 // echo "<pre>";print_r($sponsor_list);echo "</pre>";
// echo "<pre>";print_r($value_rr);echo "</pre>";
 // echo $count=count($sponsor_list);
          // exit;



		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;

               $get_uniqu='D'.time(); 
		$reward_list_date = date('Y-m-d',strtotime($reward_list_date));
                $reward_point_end_date = date('Y-m-d',strtotime($event_close_date));
		$ins_sql = "INSERT INTO `tblrewardlist`(`reward_main_cat_1`,`reward_sub_cat_1`,`reward_main_cat_2`,`reward_sub_cat_2`,`reward_title_remark`,`sponsor_type_id`,`sponsor_name`,`sponsor_remarks`,`special_remarks`,`reward_terms`,`reward_list_module_id`,`reward_list_conversion_type_id`,`reward_list_conversion_value`,`reward_list_cutoff_type_id`,`reward_list_min_cutoff`,`reward_list_max_cutoff`,`reward_list_name`,`reward_list_file_type`,`reward_list_file`,`reward_list_status`,`reward_list_deleted`,`reward_list_date`,`event_id`,`identity_type`,`identity_id`,`reference_number`,`event_close_date`,`reward_type`,`tables_select`,`columns_id`,`tables_select2`,`columns_id2`,`columns_value2`,`admin_comment`,`listing_date_type`,`days_of_month`,`single_date`,`start_date`,`end_date`,`days_of_week`,`months`,`sponsor_list1`,`sponsor_list2`,`str_sponsor_name1`,`str_sponsor_name2`,`default_sponsor`,`self_sponsor`,`show_cat`,`shows_where`,`shows_gallery`,`unique_id`)"
                        ."VALUES ('".$fav_cat_type_id_1."','".$fav_cat_id_1."','".$fav_cat_type_id_2."','".$fav_cat_id_2."','".addslashes($reward_title_remark)."','".$sponsor_type_id."','".addslashes($sponsor_name)."','".addslashes($sponsor_remarks)."','".addslashes($special_remarks)."','".addslashes($reward_terms)."','".$reward_list_module_id."','".$reward_list_conversion_type_id."','".addslashes($reward_list_conversion_value)."','".$reward_list_cutoff_type_id."','".$reward_list_min_cutoff."','".$reward_list_max_cutoff."','".addslashes($reward_list_name)."','".addslashes($reward_list_file_type)."','".addslashes($reward_list_file)."','1','0','".$reward_list_date."','".$event_id."','".$identity_type."','".$identity_id."','".$reference_number."','".$reward_point_end_date."','".$reward_type."','".$tables_names."','".$columns_dropdown."','".$tables_names2."','".$columns_dropdown_reword."','".$columns_dropdown_value_reword."','".$admin_comment."','".$listing_date_type."','".$days_of_month1."','".$single_date."','".$start_date."','".$end_date."','".$days_of_week1."','".$months1."','".$sponsor_list0."','".$sponsor_list1."','".$str_arr1."','".$str_arr2."','".$default_sponsor."','".$self_sponsor."','".$shows_cat."','".$shows_where."','".$shows_gallery."','".$get_uniqu."')";
		        $STH = $DBH->prepare($ins_sql);
                $STH->execute();
                $last=$DBH->lastInsertId();

		if($STH->rowCount() > 0)
		{
           
             $count=count($sponsor_list);
             for($i=0;$i<$count;$i++)
             {
             	$sql2="INSERT INTO `tbl_reward_sponsor`(`reward_list_id`,`sponsor_type`,`sponsor_name`,`unique_id`) VALUES (".$last.",'".addslashes($sponsor_list[$i])."','".addslashes($value_rr[$i])."','".$get_uniqu."')";
                    $STH1 = $DBH->prepare($sql2);
                   $STH1->execute();  
             }
             $DBH->commit();
			$return = true;
	      }
		return $return;
	}
	
	public function getRewardListDetails($reward_list_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
               
		
		$reward_list_module_id = '';
		$reward_list_conversion_type_id = '';
		$reward_list_conversion_value = '';
		$reward_list_cutoff_type_id = '';
		$reward_list_min_cutoff = '';
		$reward_list_max_cutoff = '';
		$reward_list_name = '';
		$reward_list_file_type = '';
		$reward_list_file = '';
		$reward_list_status = '';
		$reward_list_date = '';
                $fav_cat_type_id_1='';
                $fav_cat_type_id_2='';
                $fav_cat_id_1='';
                $fav_cat_id_2='';
                $reward_title_remark='';
                $sponsor_type_id='';
                $sponsor_name='';
                $sponsor_remarks='';
                $special_remarks='';
                $reward_terms='';
		
		$sql = "SELECT * FROM `tblrewardlist` WHERE `reward_list_id` = '".$reward_list_id."' AND `reward_list_deleted` = '0' ";
		//echo '<br>sql = '.$sql;
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
           
           // echo "<pre>";print_r($row);echo "<pre>";

           // echo $reward_list_id;

			$reward_list_module_id = stripslashes($row['reward_list_module_id']);
			$reward_list_conversion_type_id = stripslashes($row['reward_list_conversion_type_id']);
			$reward_list_conversion_value = stripslashes($row['reward_list_conversion_value']);
			$reward_list_cutoff_type_id = stripslashes($row['reward_list_cutoff_type_id']);
			$reward_list_min_cutoff = stripslashes($row['reward_list_min_cutoff']);
			$reward_list_max_cutoff = stripslashes($row['reward_list_max_cutoff']);
			$reward_list_name = stripslashes($row['reward_list_name']);
			$reward_list_file_type = stripslashes($row['reward_list_file_type']);
			$reward_list_file = stripslashes($row['reward_list_file']);
			$reward_list_status = stripslashes($row['reward_list_status']);
			$reward_list_date = stripslashes($row['reward_list_date']);
                        $event_id = stripslashes($row['event_id']);
                        $identity_type = stripslashes($row['identity_type']);
                        $identity_id = stripslashes($row['identity_id']);
                        $reference_number = stripslashes($row['reference_number']);
                        $event_close_date = stripslashes($row['event_close_date']);
                        $fav_cat_type_id_1=stripslashes($row['reward_main_cat_1']);
                        $fav_cat_type_id_2=stripslashes($row['reward_main_cat_2']);
                        $fav_cat_id_1=stripslashes($row['reward_sub_cat_1']);
                        $fav_cat_id_2=stripslashes($row['reward_sub_cat_2']);
                        $reward_title_remark=stripslashes($row['reward_title_remark']);
                        $sponsor_type_id=stripslashes($row['sponsor_type_id']);
                        $sponsor_name=stripslashes($row['sponsor_name']);
                        $sponsor_remarks=stripslashes($row['sponsor_remarks']);
                        $special_remarks=stripslashes($row['special_remarks']);
                        $reward_terms=stripslashes($row['reward_terms']);
                        $reward_type_id=$this->getrewardTypevalueKR($row['reward_type']); 
                        $admin_comment = $row['admin_comment'];

						$listing_date_type=$row['listing_date_type'];
						$days_of_month=$row['days_of_month'];
						$single_date=$row['single_date'];
						$start_date=$row['start_date'];
						$end_date=$row['end_date'];
						$days_of_week=$row['days_of_week'];
						$months=$row['months'];
						$sponsor_list1=$row['sponsor_list1'];
						$sponsor_list2=$row['sponsor_list2'];

						$str_sponsor_name1=$row['str_sponsor_name1'];
						$str_sponsor_name2=$row['str_sponsor_name2'];
						$default_sponsor=$row['default_sponsor'];
						$self_sponsor=$row['self_sponsor'];
						$show_cat=$row['show_cat'];

                        $shows_where=$row['shows_where'];
                        $shows_gallery=$row['shows_gallery'];
                       
                         $unique_id=$row['unique_id'];

        
                   
                  $sql1 = "SELECT * FROM `tbl_reward_sponsor` WHERE `reward_list_id` = '".$reward_list_id."' AND `status` = '1' AND `unique_id`='".$unique_id."' ";
                   	$STH1 = $DBH->prepare($sql1);
				        $STH1->execute();
                       if($STH1->rowCount() > 0)
		               {
			             while($row1 = $STH1->fetch(PDO::FETCH_ASSOC))
			             {
                            $arr_v[]=$row1;
                            
			             }
                       }

// echo "<pre>";print_r($arr_v);echo "</pre>";
// 					 exit;


		}
		return array($fav_cat_type_id_1,$fav_cat_type_id_2,$fav_cat_id_1,$fav_cat_id_2,$reward_title_remark,$sponsor_type_id,$sponsor_name,$sponsor_remarks,$special_remarks,$reward_terms,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_list_module_id,$reward_list_conversion_type_id,$reward_list_conversion_value,$reward_list_cutoff_type_id,$reward_list_min_cutoff,$reward_list_max_cutoff,$reward_list_name,$reward_list_file_type,$reward_list_file,$reward_list_status,$reward_list_date,$reward_type_id,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$days_of_week,$months,$arr_v,$show_cat,$shows_where,$shows_gallery,$admin_comment);
	}


        
        public function getRewardBonusDetails($reward_bonus_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
               
		
		$reward_bonus_module_id = '';
		$reward_bonus_conversion_type_id = '';
		$reward_bonus_conversion_value = '';
		$reward_bonus_cutoff_type_id = '';
		$reward_bonus_min_cutoff = '';
		$reward_bonus_max_cutoff = '';
		$reward_bonus_status = '';
		$reward_bonus_date = '';
                
                $reward_main_category_1 ='';
                $reward_main_category_2 ='';
                $reward_sub_category_1 ='';
                $reward_sub_category_2 ='';
                $reward_title ='';
		
		$sql = "SELECT * FROM `tblrewardbonus` WHERE `reward_bonus_id` = '".$reward_bonus_id."' AND `reward_bonus_deleted` = '0' ";
		//echo '<br>sql = '.$sql;
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$reward_bonus_module_id = stripslashes($row['reward_bonus_module_id']);
			$reward_bonus_conversion_type_id = stripslashes($row['reward_bonus_conversion_type_id']);
			$reward_bonus_conversion_value = stripslashes($row['reward_bonus_conversion_value']);
			$reward_bonus_cutoff_type_id = stripslashes($row['reward_bonus_cutoff_type_id']);
			$reward_bonus_min_cutoff = stripslashes($row['reward_bonus_min_cutoff']);
			$reward_bonus_max_cutoff = stripslashes($row['reward_bonus_max_cutoff']);
			$reward_bonus_status = stripslashes($row['reward_bonus_status']);
			$reward_bonus_date = stripslashes($row['reward_bonus_date']);
                        $event_id = stripslashes($row['event_id']);
                        $identity_type = stripslashes($row['identity_type']);
                        $identity_id = stripslashes($row['identity_id']);
                        $reference_number = stripslashes($row['reference_number']);
                        $event_close_date = stripslashes($row['event_close_date']);
                        $reward_main_category_1 = stripslashes($row['reward_main_cat_1']);
                        $reward_main_category_2 = stripslashes($row['reward_main_cat_2']);
                        $reward_sub_category_1 = stripslashes($row['reward_sub_cat_1']);
                        $reward_sub_category_2 = stripslashes($row['reward_sub_cat_2']);
                        $reward_title = stripslashes($row['reward_title_remark']);
                        // $reward_type_id = stripslashes($row['reward_type']);
                        $reward_type_id=$this->getrewardTypevalueKR($row['reward_type']); 

		}
		return array($reward_title,$reward_sub_category_2,$reward_sub_category_1,$reward_main_category_2,$reward_main_category_1,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_bonus_module_id,$reward_bonus_conversion_type_id,$reward_bonus_conversion_value,$reward_bonus_cutoff_type_id,$reward_bonus_min_cutoff,$reward_bonus_max_cutoff,$reward_bonus_status,$reward_bonus_date,$reward_type_id);
	}
        
        public function getRewardPointDetails($reward_point_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$reward_point_module_id = '';
		$reward_point_conversion_type_id = '';
		$reward_point_conversion_value = '';
		$reward_point_cutoff_type_id = '';
		$reward_point_min_cutoff = '';
		$reward_point_max_cutoff = '';
		$reward_point_status = '';
		$reward_point_date = '';
                $reward_main_category_1 ='';
                $reward_main_category_2 ='';
                $reward_sub_category_1 ='';
                $reward_sub_category_2 ='';
                $reward_title ='';
                        
		
		$sql = "SELECT * FROM `tblrewardpoints` WHERE `reward_point_id` = '".$reward_point_id."' AND `reward_point_deleted` = '0' ";
		//echo '<br>sql = '.$sql;
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                    $reward_point_module_id = stripslashes($row['reward_point_module_id']);
                    $reward_point_conversion_type_id = stripslashes($row['reward_point_conversion_type_id']);
                    $reward_point_conversion_value = stripslashes($row['reward_point_conversion_value']);
                    $reward_point_cutoff_type_id = stripslashes($row['reward_point_cutoff_type_id']);
                    $reward_point_min_cutoff = stripslashes($row['reward_point_min_cutoff']);
                    $reward_point_max_cutoff = stripslashes($row['reward_point_max_cutoff']);
                    $reward_point_status = stripslashes($row['reward_point_status']);
                    $reward_point_date = stripslashes($row['reward_point_date']);
                    $event_id = stripslashes($row['event_id']);
                    $identity_type = stripslashes($row['identity_type']);
                    $identity_id = stripslashes($row['identity_id']);
                    $reference_number = stripslashes($row['reference_number']);
                    $event_close_date = stripslashes($row['event_close_date']);
                    $reward_main_category_1 = stripslashes($row['reward_main_cat_1']);
                    $reward_main_category_2 = stripslashes($row['reward_main_cat_2']);
                    $reward_sub_category_1 = stripslashes($row['reward_sub_cat_1']);
                    $reward_sub_category_2 = stripslashes($row['reward_sub_cat_2']);
                    $reward_title = stripslashes($row['reward_title_remark']);
                    $reward_type_new = $this->getrewardTypevalueKR($row['reward_type']);

                    $tables_select = $row['tables_select'];
                    $columns_id = $row['columns_id'];
                    $tables_select2 = $row['tables_select2'];
                    $columns_id2 = $row['columns_id2'];
                    $columns_value2 = $row['columns_value2'];
                    $admin_comment = $row['admin_comment'];
                   

		}
		return array($reward_title,$reward_sub_category_2,$reward_sub_category_1,$reward_main_category_2,$reward_main_category_1,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_point_module_id,$reward_point_conversion_type_id,$reward_point_conversion_value,$reward_point_cutoff_type_id,$reward_point_min_cutoff,$reward_point_max_cutoff,$reward_point_status,$reward_point_date,$reward_type_new,$tables_select,$columns_id,$tables_select2,$columns_id2,$columns_value2,$admin_comment);
	}
	
	public function updateRewardList($special_remarks,$sponsor_remarks,$reward_terms,$reward_list_id,$reward_list_module_id,$reward_list_conversion_type_id,$reward_list_conversion_value,$reward_list_cutoff_type_id,$reward_list_min_cutoff,$reward_list_max_cutoff,$reward_list_name,$reward_list_file_type,$reward_list_file,$reward_list_status,$reward_list_date,$reward_type,$shows_cat,$listing_date_type,$days_of_month1,$single_date,$start_date,$end_date,$days_of_week1,$months1,$sponsor_list,$value_rr,$shows_where,$shows_gallery,$admin_comment)
	{

		 // echo "<pre>";print_r($admin_comment);echo "</pre>";
		// echo "<pre>";print_r($value_rr);echo "</pre>";

		// exit;

            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $get_uniqu='D'.time(); 
            $return = true;
            $upd_sql = "UPDATE `tblrewardlist` SET `reward_terms` = '".addslashes($reward_terms)."',
            `sponsor_remarks`='".addslashes($sponsor_remarks)."',
            `special_remarks`='".addslashes($special_remarks)."',
            `reward_list_file_type` = '".addslashes($reward_list_file_type)."' ,
            `reward_list_file` = '".addslashes($reward_list_file)."', 
            `reward_list_status` = '".$reward_list_status."',
            `listing_date_type`='".$listing_date_type."',
            `days_of_month`='".$days_of_month1."',
            `single_date`='".$single_date."',
            `start_date`='".$start_date."',
            `end_date`='".$end_date."',
            `days_of_week`='".$days_of_week1."',
            `months`='".$months1."',
            `shows_where`='".$shows_where."',
            `shows_gallery`='".$shows_gallery."',
            `unique_id`='".$get_uniqu."',
            `admin_comment`='".$admin_comment."' WHERE `reward_list_id` = '".$reward_list_id."'";

          $STH = $DBH->prepare($upd_sql);
          $STH->execute();
          // $DBH->commit();
		if($STH->rowCount() > 0)
		{
              


            $count=count($sponsor_list);
             for($i=0;$i<$count;$i++)
             {
               if($sponsor_list[$i]!='user' || $sponsor_list[$i]!='Wa')
               {
               
                  $sql2="INSERT INTO `tbl_reward_sponsor`(`reward_list_id`,`sponsor_type`,`sponsor_name`,`unique_id`) VALUES (".$reward_list_id.",'".addslashes($sponsor_list[$i])."','".addslashes($value_rr[$i])."','".$get_uniqu."')";
               }
               else
               {
                 $sql2="UPDATE `tbl_reward_sponsor` SET `sponsor_type`='".addslashes($sponsor_list[$i])."',`sponsor_name`='".addslashes($value_rr[$i])."',`unique_id`='".$get_uniqu."' WHERE `reward_list_id`='".$reward_list_id."' AND `sponsor_type`='".$sponsor_list[$i]."'";
               }



                   $STH1 = $DBH->prepare($sql2);
                   $STH1->execute();  
             }
             $DBH->commit();
			$return = true;
		}
		return $return;
	}
        



        public function updateRewardBonus($reward_bonus_id,$reward_bonus_status)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = true;
            $upd_sql = "UPDATE `tblrewardbonus` SET `reward_bonus_status` = '".$reward_bonus_status."' WHERE `reward_bonus_id` = '".$reward_bonus_id."'";
            $STH = $DBH->prepare($upd_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
        
        public function updateRewardPoint($reward_point_id,$reward_point_status)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = true;
            $upd_sql = "UPDATE `tblrewardpoints` SET `reward_point_status` = '".$reward_point_status."' WHERE `reward_point_id` = '".$reward_point_id."'";
            $STH = $DBH->prepare($upd_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function getRewardModuleTitle($reward_module_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$reward_module_title = '';
		$sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_id` = '".$reward_module_id."' AND `reward_module_deleted` = '0' ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$reward_module_title = stripslashes($row['reward_module_title']);
		}
		return $reward_module_title;
	}
	
	public function getRewardCriteriaTitle($reward_criteria_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$reward_criteria_title = '';
		
		$sql = "SELECT * FROM `tblrewardcriteria` WHERE `reward_criteria_id` = '".$reward_criteria_id."' ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$reward_criteria_title = stripslashes($row['reward_criteria_title']);
		}
		return $reward_criteria_title;
	}
	
	public function AddRewardModule($reward_module_title,$table_link,$page_id,$admin_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
		$now = date('Y-m-d');
		$ins_sql = "INSERT INTO `tblrewardmodules`(`page_id`,`reward_module_title`,`table_link`,`reward_module_status`,`reward_module_deleted`,`posted_by`) VALUES ('".$page_id."','".addslashes($reward_module_title)."','".addslashes($table_link)."','1','0','".$admin_id."')";
		$STH = $DBH->prepare($ins_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function getRewardModuleDetails($reward_module_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$reward_module_title = '';
		$reward_module_status = '0';
		$reward_page_id = '0';
		
		$sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_id` = '".$reward_module_id."' AND `reward_module_deleted` = '0' ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$reward_module_title = stripslashes($row['reward_module_title']);
			$reward_module_status = stripslashes($row['reward_module_status']);
			$reward_page_id = stripslashes($row['page_id']);
                        $reward_table_link = stripslashes($row['table_link']);
		}
		return array($reward_module_title,$reward_module_status,$reward_page_id,$reward_table_link);
	}
	
	
	public function UpdateRewardModule($reward_module_title,$reward_module_status,$reward_module_id,$page_id,$table_link,$admin_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return =true;
		$upd_sql = "UPDATE `tblrewardmodules` SET `page_id`='".$page_id."',`table_link`='".addslashes($table_link)."',`reward_module_title` = '".addslashes($reward_module_title)."' , `reward_module_status` = '".$reward_module_status."',`posted_by`='".$admin_id."' WHERE `reward_module_id` = '".$reward_module_id."'";
		$STH = $DBH->prepare($upd_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
                {
                    $return =true;
                }
                return $return;
	}
	
	public function DeleteRewardPoint($id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return =false;
		
		$del_sql = "UPDATE `tblrewardpoints` SET `reward_point_deleted` = '1' WHERE `reward_point_id` = '".$id."'"; 
		$STH = $DBH->prepare($del_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
                {
                    $return =true;
                }
                return $return;
	}
	
	public function DeleteRewardBonus($id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return =false;
		
		$del_sql = "UPDATE `tblrewardbonus` SET `reward_bonus_deleted` = '1' WHERE `reward_bonus_id` = '".$id."'"; 
		$STH = $DBH->prepare($del_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
                {
                    $return =true;
                }
                return $return;
	}
	
	public function DeleteRewardModule($id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return =true;
		
		$del_sql = "UPDATE `tblrewardmodules` SET `reward_module_deleted` = '1' WHERE `reward_module_id` = '".$id."'"; 
		$STH = $DBH->prepare($del_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
                {
                    $return =true;
                }
                return $return;
	}
	
	public function DeleteRewardItem($id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return =true;
		
		$del_sql = "UPDATE `tblrewardlist` SET `reward_list_deleted` = '1' WHERE `reward_list_id` = '".$id."'"; 
		$STH = $DBH->prepare($del_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
                {
                    $return =true;
                }
                return $return;
	}
	
	public function getRewardModuleOptions($reward_module_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblrewardmodules` where `reward_module_deleted` = '0' ORDER BY `reward_module_title` ASC";
		//echo $sql;
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
			{
				if($row['reward_module_id'] == $reward_module_id)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				
				if($row['page_id'] == '0')
				{
					$title = stripslashes($row['reward_module_title']);
				}
				else
				{
					$obj2 = new RewardPoint();
					
					$title = $obj2->getMenuTitleOfPage($row['page_id']);
					if($title == '')
					{
						$title = stripslashes($row['reward_module_title']);
					}
				}
				$option_str .= '<option value="'.$row['reward_module_id'].'" '.$sel.'>'.$title.'</option>';
			}
		}
		return $option_str;
	}
	
	public function getRewardCriteriaOptions($reward_criteria_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblrewardcriteria` where `reward_criteria_status` = '1' ORDER BY `reward_criteria_title` ASC";
		//echo $sql;
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
			{
				if($row['reward_criteria_id'] == $reward_criteria_id)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				$option_str .= '<option value="'.$row['reward_criteria_id'].'" '.$sel.'>'.stripslashes($row['reward_criteria_title']).'</option>';
			}
		}
		return $option_str;
	}
	
	public function getYoutubeString($banner)
	{
		$search = 'v=';
		$pos = strpos($banner, $search);
		$str = strlen($banner);
		$rest = substr($banner, $pos+2, $str);
		return 'http://www.youtube.com/embed/'.$rest;
	}
	
	public function getMenuTitleOfPage($page_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$menu_title = '';
		
		$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$menu_title = stripslashes($row['menu_title']);
		}
		return $menu_title;
	
	}
    public function getDatadropdownPage($pdm_id,$page_id)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $option_str = '';		
            $sel = '';
            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` ='".$pdm_id."' ";
           // echo $sql;
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
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


        
   public function getEventOptions($event_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $date = date("Y-m-d h:i:s");
		$option_str = '';		
		
		$sql = "SELECT * FROM `tbl_event_master` where `status` = '1' AND `is_deleted` >= '0' ORDER BY `event_name` ASC";
		//echo $sql;
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
			{
				if($row['event_master_id'] == $event_id)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				
				
				$option_str .= '<option value="'.$row['event_master_id'].'" '.$sel.'>'.$row['event_name'].'</option>';
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
                    $option_str .= '<option value="'.$row['favcat_id'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
                }
            }
            //echo $option_str;
            
            return $option_str;
	}
        
public function getEventdatashow($event_id)
   {
     
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $date = date("Y-m-d h:i:s");
            $option_str = '';		

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
            // $option_str .="<input type='text' name='event_name' id='event_name' value=".$this->getFavCategoryNameVivek($row['wellbeing_id']).">"
            
            return $option_str;
       
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
                	echo "<pre>";print_r($row);echo "</pre>";
                    if($row['prct_cat_id'] == $fav_cat_type_id)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['prct_cat_id'].'" '.$sel.'>'.stripslashes($row['prct_cat']).$row['prct_cat_id'].'</option>';
                }
            }
            return $option_str;
	}
   
  public function getEventFavCategoryRamakant($page_id,$healcareandwellbeing)
      {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $option_str = '';		
            $sql = "SELECT * FROM `tbl_page_cat_dropdown` WHERE `page_name`= '".$page_id."' and `pag_cat_status` = 1 and `is_deleted` = 0 ";
            $STH = $DBH->prepare($sql); 
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                $option_str .='<option value="">Select Type</option>';
                while( $row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    if($row['healcareandwellbeing'] == $healcareandwellbeing)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['healcareandwellbeing'].'" '.$sel.'>'.stripslashes($this->getFavCatNameById($row['healcareandwellbeing'])).'</option>';
                }
            }
            return $option_str;  
      }    
  
   public function getVendorOption($vendor_id,$type='1',$multiple='0')
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $vendor_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Vendors</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Vendors</option>';
			}
		}
		else
		{
			$output .= '<option value="" >Select Vendor</option>';
		}
		
		try {
			$sql = "SELECT vendor_id,vendor_name FROM `tblvendors` WHERE `vendor_deleted` = '0' ORDER BY vendor_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($multiple == '1')
					{
						if(is_array($vendor_id) && in_array($r['vendor_id'], $vloc_id))
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					else
					{
						if($r['vendor_id'] == $vendor_id )
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					$output .= '<option value="'.$r['vendor_id'].'" '.$selected.'>'.stripslashes($r['vendor_name']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getVendorOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}   
   
        
    public function getCommaSeperatedsponsorName($vendor_id)
        {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $output = '';
            
            $sql = "SELECT * FROM `tblvendors` WHERE `vendor_status` = '1'  AND `vendor_id` IN (".$vendor_id.") ORDER BY `vendor_name` ASC";    
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                {
                    $vendor_name = stripslashes($row['vendor_name']);
                    $output .= $vendor_name.' ,';
                }
                $output = substr($output,0,-1);
            }
            return $output;
        } 



   public function getTableNameOptions_dropdown_kr1($get,$select_value,$desble)
    {
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $output = '';      

            $sql = "SELECT table_name FROM information_schema.tables where table_schema='wellness'";
            
            $STH = $DBH->prepare($sql);
             $STH->execute();
                    
            if($STH->rowCount()  > 0)
            {
              
               if($desble=='disabled')
               {
               	$disabled="disabled";
               }
               else
               {
               	$disabled="";
               }

               $output.='<select  class="" id="tables_names'.$get.'" name="tables_names" style="width:150px;" onchange="Selectable('.$get.');" '.$disabled.'>';
                       
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


public function getRewardMaincat($comm,$page_id,$set_val,$pro)
    {

        if($pro=='prof1')
        {
        	$pro_cate='prof_cat1';
        }
        else
        {
           $pro_cate='prof_cat2';
        }


        $my_DBH = new mysqlConnection();
        $output = '';
        $output .= '<option value="" >Select Category</option>';
            try {
               
               $sql="SELECT ".$pro_cate." FROM `tbl_page_cat_dropdown` WHERE `healcareandwellbeing` = ".$comm." AND `page_name`=".$page_id." AND `is_deleted` = '0' ORDER BY page_cat_id ASC";

                 $STH = $my_DBH->query($sql);
                if( $STH->rowCount() > 0 )
                {
                    while($r= $STH->fetch(PDO::FETCH_ASSOC))
                    {
                    	 foreach($r as $value)
                    	 {
                    	 	if($value!="")
                    	 	{
                    	 	   $get_sap=explode(',',$value);
                    	 	   foreach($get_sap as $final_val)
                    	 	   {
                    	 	   	   $sql2="SELECT prct_cat FROM `tblprofilecustomcategories` WHERE `prct_cat_id` = ".$final_val." AND `prct_cat_deleted` = '0'";
                    	 	   	    $STH = $my_DBH->query($sql2);
                    	 	   	    $r2= $STH->fetch(PDO::FETCH_ASSOC);

                    	 	   	          if($r2['prct_cat'] == $set_val)
                                            {
                                                    $selected = ' selected ';   
                                            }
                                            else
                                            {
                                                    $selected = ''; 
                                            }   

                    	        $output .= '<option value="'.$final_val.'" '.$selected.'>'.stripslashes($r2['prct_cat']).'</option>';

                    	 	   }

                    	    }
                    	 }
                    }
                }
              
            } catch (Exception $e) {
                //$stringData = '[getMainCategoryOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
                //$this->debuglog($stringData);
                return $output;
            }
                
        return $output;
    }


public function getrewardmaincat1($gt_id)
{
	 $my_DBH = new mysqlConnection();
	 $sql2="SELECT prct_cat FROM `tblprofilecustomcategories` WHERE `prct_cat_id` = ".$gt_id." AND `prct_cat_deleted` = '0'";
   	    $STH = $my_DBH->query($sql2);

   	    $r2= $STH->fetch(PDO::FETCH_ASSOC);
   	    $result=$r2['prct_cat'];

   	    return $result;
}

public function getrewardsubcat1($gt_id)
{
	 $my_DBH = new mysqlConnection();
	 $sql2="SELECT fav_cat FROM `tblfavcategory` WHERE `fav_cat_id` = ".$gt_id." AND `fav_cat_deleted` = '0'";
   	    $STH = $my_DBH->query($sql2);

   	    $r2= $STH->fetch(PDO::FETCH_ASSOC);
   	    $result=$r2['fav_cat'];

   	    return $result;
}


        
}
?>