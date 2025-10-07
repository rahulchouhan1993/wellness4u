<?php
include_once("class.paging.php");
include_once("class.admin.php");
class Places extends Admin
{
	public function getAllPlaces($search)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '72';
		$delete_action_id = '74';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($search == '')
			{
				$sql = "SELECT * FROM `tblplaces` as tp LEFT JOIN `tblcities` as tc ON tp.city_id = tc.city_id LEFT JOIN `tblstates` as ts on tp.state_id = ts.state_id  ORDER BY ts.state , tc.city , tp.place ASC";
			}
		else
			{
			   $sql = "select * from `tblplaces` as tp
						LEFT JOIN `tblcities` as tc ON tp.city_id = tc.city_id 
						LEFT JOIN `tblstates` as ts on tp.state_id = ts.state_id 
						 where place like '%".$search."%' order by ts.state , tc.city , tp.place DESC";
			}		
		//$this->execute_query($sql);
                $STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records = $STH->rowCount();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=places");
                
	 	//$result=$this->execute_query($page->get_limit_query($sql));
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
				$output .= '<tr class="manage-row">';
				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td align="center">'.stripslashes($row['state']).'</td>';
				$output .= '<td align="center">'.stripslashes($row['city']).'</td>';
				$output .= '<td align="center">'.stripslashes($row['place']).'</td>';
				$output .= '<td align="center">'.stripslashes($row['pincode']).'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_place&id='.$row['place_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Place","sql/delplace.php?id='.$row['place_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
							}
				$output .= '</td>';
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="7" align="center">NO RECORDS FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function getAllStates($search)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '64';
		$delete_action_id = '66';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($search == '')
			{
				$sql = "SELECT * FROM `tblstates` ORDER BY state ASC";
			}
		else
			{
			  $sql = "select * from `tblstates` where state like '%".$search."%' order by state_add_date DESC";
			}		
		//$this->execute_query($sql);
		$STH = $DBH->prepare($sql);
                $STH->execute();
                $total_records = $STH->rowCount();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=states");
	 	//$result=$this->execute_query($page->get_limit_query($sql));
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
				$output .= '<tr class="manage-row">';
				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td align="center">'.stripslashes($row['state']).'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_state&id='.$row['state_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("State","sql/delstate.php?id='.$row['state_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
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
	
	public function getAllCities($search)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '68';
		$delete_action_id = '70';
		
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($search == '')
			{
				$sql = "SELECT * FROM `tblcities` as tc LEFT JOIN `tblstates` as ts ON tc.state_id = ts.state_id ORDER BY ts.state , tc.city ASC";
			}
		else
			{
			   $sql = "select * from `tblcities` as tc LEFT JOIN `tblstates` as ts ON tc.state_id = ts.state_id
						where city like '%".$search."%' order by city_add_date DESC";
			}
		//$this->execute_query($sql);
                        
                 
                $STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records = $STH->rowCount();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=cities");
                
	 	//$result=$this->execute_query($page->get_limit_query($sql));
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
				$output .= '<tr class="manage-row">';
				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td align="center">'.stripslashes($row['state']).'</td>';
				$output .= '<td align="center">'.stripslashes($row['city']).'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
					if($edit) {
				$output .= '<a href="index.php?mode=edit_city&id='.$row['city_id'].'" ><img src = "images/edit.gif" border="0"></a>';
						}
				$output .= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
					if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("City","sql/delcity.php?id='.$row['city_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
							}
				$output .= '</td>';
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="5" align="center">NO RECORDS FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	

	public function chkStateExists($state)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT * FROM `tblstates` WHERE `state` = '".addslashes($state)."'";
		
                $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function chkStateExists_edit($state,$state_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT * FROM `tblstates` WHERE `state` = '".addslashes($state)."' AND `state_id` != '".$state_id."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function getStateId($state)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$state_id = 0;
		$sql = "SELECT * FROM `tblstates` WHERE `state` = '".addslashes($state)."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$state_id =$row['state_id'];
		}
		return $state_id;
	}
	
	public function addState($state)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		$now = time();
		
		$sql = "INSERT INTO `tblstates` (`state`,`state_add_date`) VALUES ('".addslashes($state)."','".$now."')";
		//echo"<br>Testkk STATE: ".$sql;
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
                    $return = true;
                }
                
		return $return;
	}
	
	public function chkCityExists($city,$state_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT * FROM `tblcities` WHERE `city` = '".addslashes($city)."' AND `state_id` = '".$state_id."' ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
			$return = true;
		}
		return $return;
	}
	
	public function chkCityExists_edit($city,$state_id,$city_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT * FROM `tblcities` WHERE `city` = '".addslashes($city)."' AND `state_id` = '".$state_id."' AND `city_id` != '".$city_id."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
			$return = true;
		}
		return $return;
	}
	
	public function getCityId($city,$state_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$city_id = 0;
		$sql = "SELECT * FROM `tblcities` WHERE `city` = '".addslashes($city)."' AND `state_id` = '".$state_id."' ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$city_id =$row['city_id'];
		}
		return $city_id;
	}
	
	public function addCity($city,$state_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		$now = time();
		
		$sql = "INSERT INTO `tblcities` (`state_id`,`city`,`city_add_date`) VALUES ('".$state_id."','".addslashes($city)."','".$now."')";
		//echo"<br>Testkk CITY: ".$sql;
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
                   $return = true; 
                }
                return $return;
	}
	
	
	
	public function chkPlaceExists($place,$city_id,$state_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT * FROM `tblplaces` WHERE `place` = '".addslashes($place)."' AND `city_id` = '".$city_id."' AND `state_id` = '".$state_id."' ";
		//echo "<br>City : ".$sql;
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
			$return = true;
		}
		return $return;
	}
	
	public function chkPlaceExists_edit($place,$city_id,$state_id,$place_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT * FROM `tblplaces` WHERE `place` = '".addslashes($place)."' AND `city_id` = '".$city_id."' AND `state_id` = '".$state_id."' AND `place_id` != '".$place_id."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
			$return = true;
		}
		return $return;
	}
	
	
	public function addPlace($state_id,$city_id,$place,$pincode)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		$now = time();
		
		$sql = "INSERT INTO `tblplaces` (`state_id`,`city_id`,`place`,`pincode`,`place_add_date`) VALUES ('".$state_id."','".$city_id."','".addslashes($place)."','".addslashes($pincode)."','".$now."')";
		//echo"<br>Testkk Place: ".$sql;
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
			$return = true;
		}
		return $return;
	}
	
	public function getCountryOptions($country_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblcountry` ORDER BY `country_name` ASC";
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
			{
				if($row['country_id'] == $country_id)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				$option_str .= '<option value="'.$row['country_id'].'" '.$sel.'>'.stripslashes($row['country_name']).'</option>';
			}
		}
		return $option_str;
	}
	
	public function getStateOptions($state_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblstates` ORDER BY `state` ASC";
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
			{
				if($row['state_id'] == $state_id)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				$option_str .= '<option value="'.$row['state_id'].'" '.$sel.'>'.stripslashes($row['state']).'</option>';
			}
		}
		return $option_str;
	}
        
        public function getStateOptionsNew($country_id,$state_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';		
		
		//$sql = "SELECT * FROM `tblstates` ORDER BY `state` ASC";
		$sql = "SELECT * FROM `tblstates` WHERE `country_id` = '".$country_id."' ORDER BY `state` ASC";
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
			{
				if($row['state_id'] == $state_id)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				$option_str .= '<option value="'.$row['state_id'].'" '.$sel.'>'.$row['state'].'</option>';
			}
		}
		return $option_str;
	}
	
	public function getStateOptionsMulti($country_id,$arr_state_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';		
		
		if($country_id == '' || $country_id == '0')
		{		
			$sql = "SELECT * FROM `tblstates` ORDER BY `state` ASC";
		}
		else
		{
			$sql = "SELECT * FROM `tblstates` WHERE `country_id` = '".$country_id."' ORDER BY `state` ASC";
		}	
		
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
			{
				if(in_array($row['state_id'],$arr_state_id))
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				$option_str .= '<option value="'.$row['state_id'].'" '.$sel.'>'.stripslashes($row['state']).'</option>';
			}
		}
		return $option_str;
	}
	
	public function getCityOptions($state_id,$city_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblcities` WHERE `state_id` = '".$state_id."' ORDER BY `city` ASC";
		$STH = $DBH->prepare($sql);
                $STH->execute();
                
                if($STH->rowCount() > 0)
                {
			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
			{
				if($row['city_id'] == $city_id)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				$option_str .= '<option value="'.$row['city_id'].'" '.$sel.'>'.stripslashes($row['city']).'</option>';
			}
		}
		return $option_str;
	}
	
	public function getCityOptionsMulti($country_id,$arr_state_id,$arr_city_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';		
		
		if(count($arr_state_id) > 0)
		{
			if($country_id == '' || $country_id == '0')
			{
				$str_sql_country_id = "";
			}
			else
			{
				$str_sql_country_id = " AND `country_id` = '".$country_id."' ";
			}
			
			if($arr_state_id[0] == '')
			{
				$str_sql_state_id = "";
			}
			else
			{
				$str_state_id = implode(',',$arr_state_id);
				$str_sql_state_id = " AND `state_id` IN (".$str_state_id.") ";
			}
			
			$sql = "SELECT * FROM `tblcities` WHERE 1  ".$str_sql_country_id." ".$str_sql_state_id." ORDER BY `city` ASC";	
			$STH = $DBH->prepare($sql);
                        $STH->execute();

                        if($STH->rowCount() > 0)
                        {
				while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
				{
					if(in_array($row['city_id'],$arr_city_id))
					{
						$sel = ' selected ';
					}
					else
					{
						$sel = '';
					}		
					$option_str .= '<option value="'.$row['city_id'].'" '.$sel.'>'.stripslashes($row['city']).'</option>';
				}
			}
		}	
		return $option_str;
	}
	
	public function getPlaceOptionsMulti($country_id,$arr_state_id,$arr_city_id,$arr_place_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';		
		
		if(count($arr_city_id) > 0)
		{
			if($country_id == '' || $country_id == '0')
			{
				$str_sql_country_id = "";
			}
			else
			{
				$str_sql_country_id = " AND `country_id` = '".$country_id."' ";
			}
			
			if($arr_state_id[0] == '')
			{
				$str_sql_state_id = "";
			}
			else
			{
				$str_state_id = implode(',',$arr_state_id);
				$str_sql_state_id = " AND `state_id` IN (".$str_state_id.") ";
			}
					
			if($arr_city_id[0] == '')
			{
				$str_sql_city_id = "";
			}
			else
			{
				$str_city_id = implode(',',$arr_city_id);
				$str_sql_city_id = " AND `city_id` IN (".$str_city_id.") ";
			}
			
			$sql = "SELECT * FROM `tblplaces` WHERE 1  ".$str_sql_country_id." ".$str_sql_state_id."  ".$str_sql_city_id." ORDER BY `place` ASC";	
			$STH = $DBH->prepare($sql);
                        $STH->execute();

                        if($STH->rowCount() > 0)
                        {
				while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
				{
					if(in_array($row['place_id'],$arr_place_id))
					{
						$sel = ' selected ';
					}
					else
					{
						$sel = '';
					}		
					$option_str .= '<option value="'.$row['place_id'].'" '.$sel.'>'.stripslashes($row['place']).'</option>';
				}
			}
		}	
		return $option_str;
	}
	
	public function getAdvisersUserOptionsMulti($arr_user_id,$practitioner_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';
		if($practitioner_id == '' || $practitioner_id == '0')
		{
			$sql = "SELECT * FROM `tblusers` WHERE `status` = '1' ORDER BY `name` ASC";
		}
		else
		{
			$sql = "SELECT * FROM `tbladviserreferrals` AS tar LEFT JOIN `tblusers` AS tpu ON tar.user_email = tpu.email  WHERE `pro_user_id` = '".$practitioner_id."' AND `request_status` = '1' ORDER BY tpu.name ASC";
		}
		
		
		
		$STH = $DBH->prepare($sql);
                        $STH->execute();
		 if($STH->rowCount() > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
			{
				if(in_array($row['user_id'],$arr_user_id))
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
	
	public function getProUsersOptions($pro_user_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';
				
		$sql = "SELECT * FROM `tblprofusers` ORDER BY `name` ASC";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)

		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
			{
				if($row['pro_user_id'] == $pro_user_id)
				{
					$selected = ' selected ';
				}
				else
				{
					$selected = '';
				}
				$option_str .= '<option value="'.$row['pro_user_id'].'" '.$selected.' >'.stripslashes($row['name']).'</option>';
			}
		}
		return $option_str;
	}
	
	public function getUsersOptions($user_id)
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
				if($row['user_id'] == $user_id)
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
	
	public function getPlaceOptions($state_id,$city_id,$place_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblplaces` WHERE `state_id` = '".$state_id."' AND `city_id` = '".$city_id."' ORDER BY `place` ASC";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
			{
				if($row['place_id'] == $place_id)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				$option_str .= '<option value="'.$row['place_id'].'" '.$sel.'>'.$row['place'].'</option>';
			}
		}
		return $option_str;
	}
	
	public function getPlaceDetails($place_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$sql = "SELECT * FROM `tblplaces` WHERE `place_id` = '".$place_id."' ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$state_id = $row['state_id'];
			$city_id = $row['city_id'];
			$place = stripslashes($row['place']);
			$pincode = stripslashes($row['pincode']);
		}
		return array($state_id,$city_id,$place,$pincode);
	}
	
	public function updatePlace($state_id,$city_id,$place,$pincode,$place_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$now = time();
		
		$upd_sql = "UPDATE `tblplaces` SET `state_id` = '".$state_id."' , `city_id` = '".$city_id."' , `place` = '".addslashes($place)."' , `pincode` = '".addslashes($pincode)."' WHERE `place_id` = '".$place_id."'";
		$STH = $DBH->prepare($upd_sql);
                $STH->execute();
                if($STH->rowCount() > 0)
		{
                    return true;
                }
                else
                {
                    return false;
                }
		
	}
	
	public function deletePlace($place_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$del_sql1 = "DELETE FROM `tblplaces` WHERE `place_id` = '".$place_id."'"; 
		$STH = $DBH->prepare($del_sql1);
                $STH->execute();
                if($STH->rowCount() > 0)
		{
                    return true;
                }
                else
                {
                    return false;
                }
	}
	
	
	public function getStateDetails($state_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$sql = "SELECT * FROM `tblstates` WHERE `state_id` = '".$state_id."' ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
                if($STH->rowCount() > 0){
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$state = stripslashes($row['state']);
		}
		return $state;
	}
	
	public function updateState($state,$state_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$now = time();
		
		$upd_sql = "UPDATE `tblstates` SET `state` = '".addslashes($state)."' WHERE `state_id` = '".$state_id."'";
		$STH = $DBH->prepare($upd_sql);
                $STH->execute();
                if($STH->rowCount() > 0)
		{
                    return true;
                }
                else
                {
                    return false;
                }
	}
	
	public function deleteState($state_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$del_sql1 = "DELETE FROM `tblstates` WHERE `state_id` = '".$state_id."'"; 
		$STH = $DBH->prepare($del_sql1);
                $STH->execute();
                if($STH->rowCount() > 0)
		{
                    return true;
                }
                else
                {
                    return false;
                }
	}
	
	public function getCityDetails($city_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$sql = "SELECT * FROM `tblcities` WHERE `city_id` = '".$city_id."' ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		 if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$state_id = $row['state_id'];
			$city = stripslashes($row['city']);
		}
		return array($state_id,$city);
	}
	
	public function updateCity($state_id,$city,$city_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$now = time();
		
		$upd_sql = "UPDATE `tblcities` SET `state_id` = '".$state_id."' , `city` = '".addslashes($city)."' WHERE `city_id` = '".$city_id."'";
		$STH = $DBH->prepare($upd_sql);
                $STH->execute();
                if($STH->rowCount() > 0)
		{
                    return true;
                }
                else
                {
                    return false;
                }
	}
	
	public function deleteCity($city_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                
		$del_sql1 = "DELETE FROM `tblcities` WHERE `city_id` = '".$city_id."'"; 
		$STH = $DBH->prepare($del_sql1);
                $STH->execute();
                if($STH->rowCount() > 0)
		{
                    return true;
                }
                else
                {
                    return false;
                }
	}
	
	
	
}
?>