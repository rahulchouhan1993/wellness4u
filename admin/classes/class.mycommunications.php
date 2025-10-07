<?php
include_once("class.paging.php");
include_once("class.admin.php");
class My_Communications extends Admin
{
	public function getAllQuestions($practitioner_id,$search,$status,$country_id,$arr_state_id,$arr_city_id,$arr_place_id,$start_date)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '40';
		$delete_action_id = '42';
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
		
		$sql = "SELECT * FROM `tblmycommunications` WHERE 1 ".$str_sql_practitioner_id."  ".$str_sql_search."  ".$str_sql_status."  ".$str_sql_country_id."  ".$str_sql_state_id."  ".$str_sql_city_id."  ".$str_sql_place_id."  ".$str_sql_date."  ORDER BY `listing_order` ASC , `mc_add_date` DESC";				
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records = $STH->rowCount();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=my_communications");
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
					$obj3 = new My_Communications();
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
				$output .= '<td height="30" align="center">'.date('d-m-Y',strtotime($row['mc_add_date'])).'</td>';
				$output .= '<td height="30" align="center">'.$row['listing_order'].'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_my_communication&id='.$row['mc_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Question","sql/delmycommunication.php?id='.$row['mc_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
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
	
	public function addQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$state_id,$city_id,$user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$country_id,$place_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
				
		$sql = "INSERT INTO `tblmycommunications` (`situation`,`situation_font_family`,`situation_font_size`,`situation_font_color`,`listing_date_type`,`days_of_month`,`single_date`,`start_date`,`end_date`,`country_id`,`state_id`,`city_id`,`place_id`,`user_id`,`practitioner_id`,`keywords`,`listing_order`,`status`) VALUES ('".addslashes($situation)."','".addslashes($situation_font_family)."','".addslashes($situation_font_size)."','".addslashes($situation_font_color)."','".addslashes($listing_date_type)."','".addslashes($days_of_month)."','".addslashes($single_date)."','".addslashes($start_date)."','".addslashes($end_date)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($user_id)."','".addslashes($practitioner_id)."','".addslashes($keywords)."','".addslashes($listing_order)."','1')";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->result)
		{
			$return = true;
			$situation_id = $this->getInsertID();
			for($i=0;$i<count($arr_min_rating);$i++)
			{
				$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('mycommunications','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
				$STH = $DBH->prepare($sql2);
                                $STH->execute();
			}	
		}
		return $return;
	}
	
	public function getQuestionDetails($mc_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$arr_min_rating = array();
		$arr_max_rating = array();
		$arr_interpretaion = array();
		$arr_treatment = array();
		
		$sql = "SELECT * FROM `tblmycommunications` WHERE `mc_id` = '".$mc_id."'";
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
			
			$sql2 = "SELECT * FROM `tblemotionstreatments` WHERE `situation_id` = '".$mc_id."'  AND `et_type` = 'mycommunications'   ORDER BY `et_id`";
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
	
	public function updateQuestion($situation,$situation_font_family,$situation_font_size,$situation_font_color,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$country_id,$state_id,$city_id,$place_id,$user_id,$practitioner_id,$keywords,$listing_order,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment,$status,$mc_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		
		$upd_sql = "UPDATE `tblmycommunications` SET `situation` = '".addslashes($situation)."' , `situation_font_family` = '".addslashes($situation_font_family)."' , `situation_font_size` = '".addslashes($situation_font_size)."' , `situation_font_color` = '".addslashes($situation_font_color)."' , `listing_date_type` = '".addslashes($listing_date_type)."' , `days_of_month` = '".addslashes($days_of_month)."' , `single_date` = '".addslashes($single_date)."' , `start_date` = '".addslashes($start_date)."' , `end_date` = '".addslashes($end_date)."' , `country_id` = '".addslashes($country_id)."'  , `state_id` = '".addslashes($state_id)."' , `city_id` = '".addslashes($city_id)."'  , `place_id` = '".addslashes($place_id)."' , `user_id` = '".addslashes($user_id)."' , `practitioner_id` = '".addslashes($practitioner_id)."' , `keywords` = '".addslashes($keywords)."' , `listing_order` = '".addslashes($listing_order)."' , `status` = '".addslashes($status)."'  WHERE `mc_id` = '".$mc_id."'";
		$STH = $DBH->prepare($upd_sql);
                 $STH->execute();
		if($STH->result)
		{
			$return = true;
			$situation_id = $mc_id;
			$del_sql1 = "DELETE FROM `tblemotionstreatments` WHERE `situation_id` = '".$situation_id."' AND `et_type` = 'mycommunications'  "; 
			$STH = $DBH->prepare($del_sql1);
                         $STH->execute();
			for($i=0;$i<count($arr_min_rating);$i++)
			{
				$sql2 = "INSERT INTO `tblemotionstreatments` (`et_type`,`situation_id`,`min_rating`,`max_rating`,`interpretaion`,`treatment`,`et_status`) VALUES ('mycommunications','".addslashes($situation_id)."','".$arr_min_rating[$i]."','".$arr_max_rating[$i]."','".addslashes($arr_interpretaion[$i])."','".addslashes($arr_treatment[$i])."','1')";
				$STH = $DBH->prepare($sql2);
                                $STH->execute();
			}	
		}
		return $return;
	}
	
	public function deleteMCQuestion($mc_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                   $return = false;
		$del_sql1 = "DELETE FROM `tblmycommunications` WHERE `mc_id` = '".$mc_id."'"; 
		$STH = $DBH->prepare($del_sql);
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
}
?>