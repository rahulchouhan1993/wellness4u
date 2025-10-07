<?php
include_once("class.paging.php");
include_once("class.admin.php");
class Users extends Admin
{
	public function GetAllUsers($search)
	{
		$this->connectDB();
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '2';
		$delete_action_id = '4';
		$reset_user_password_action_id = '5';
		$view_user_reports_action_id = '103';
		
		$reset_pass = $this->chkValidActionPermission($admin_id,$reset_user_password_action_id);
		
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		$view_report = $this->chkValidActionPermission($admin_id,$view_user_reports_action_id);
		
		if($search == '')
			{
				$sql = "select * from `tblusers` as TA 
						LEFT JOIN `tblcities` as TS ON TA.city_id = TS.city_id 
						LEFT JOIN `tblplaces` AS TU ON TA.place_id = TU.place_id
						order by TA.user_add_date DESC";
			 }
		 else
			 {
		  		$sql = "select * from `tblusers` as TA  
						LEFT JOIN `tblcities` as TS ON TA.city_id = TS.city_id 
						LEFT JOIN `tblplaces` AS TU ON TA.place_id = TU.place_id
					    where TA.name like '%".$search."%' OR TA.email like '%".$search."%' order by TA.user_add_date DESC";
			}
		$this->execute_query($sql);
		$total_records=$this->numRows();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=users");
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
				$user_add_date = $row['user_add_date'];
			
				$date = date('d-m-y',$user_add_date);
				
				if($row['status'] == 1)
				{
					$status = "Active";
				}
				else
				{
					$status = "Inactive";
				}
				$output .= '<tr class="manage-row">';
				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td align="center">'.$row['unique_id'].'</td>';
				$output .= '<td align="center">'.$row['email'].'</td>';
				$output .= '<td align="center">'.stripslashes($row['name']).'</td>';
				$output .= '<td align="center">'.stripslashes($row['city']).'</td>';
				$output .= '<td align="center">'.stripslashes($row['place']).'</td>';
				$output .= '<td align="center">'.$status.'</td>';
				$output .= '<td align="center">'.$date.'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($view_report) {
				$output .= '<a href="index.php?mode=reports&uid='.$row['user_id'].'" >View Reoprts</a>';
						}
				$output .=	'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
							if($reset_pass)	{
				$output	.= '<a href="index.php?mode=reset_user_password&uid='.$row['user_id'].'" >Reset Password</a>';
							}
				$output	.= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
							if($edit) {
				$output .= '<a href="index.php?mode=edit_user&uid='.$row['user_id'].'" ><img src = "images/edit.gif" border="0"></a>';
								}
				$output .= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
							if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("User","sql/deluser.php?uid='.$row['user_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
							   }
				$output .='</td>';
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="11" align="center">NO USERS FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function GetAllPractitioners($search)
	{
		$this->connectDB();
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '171';
		$delete_action_id = '173';
		$reset_user_password_action_id = '174';
		
		$reset_pass = $this->chkValidActionPermission($admin_id,$reset_user_password_action_id);
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		if($search == '')
			{
				$sql = "select * from `tblprofusers` as TA 
						LEFT JOIN `tblcities` as TS ON TA.city_id = TS.city_id 
						LEFT JOIN `tblplaces` AS TU ON TA.place_id = TU.place_id
						order by TA.pro_user_add_date DESC";
			 }
		 else
			 {
		  		$sql = "select * from `tblprofusers` as TA  
						LEFT JOIN `tblcities` as TS ON TA.city_id = TS.city_id 
						LEFT JOIN `tblplaces` AS TU ON TA.place_id = TU.place_id
					    where TA.name like '%".$search."%' OR TA.email like '%".$search."%' order by TA.pro_user_add_date DESC";
			}
		$this->execute_query($sql);
		$total_records=$this->numRows();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=practitioners");
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
				$user_add_date = $row['pro_user_add_date'];
			
				$date = date('d-m-y',strtotime($user_add_date));
				
				if($row['status'] == 1)
				{
					$status = "Active";
				}
				else
				{
					$status = "Inactive";
				}
				$output .= '<tr class="manage-row">';
				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td align="center">'.$row['pro_unique_id'].'</td>';
				$output .= '<td align="center">'.$row['email'].'</td>';
				$output .= '<td align="center">'.stripslashes($row['name']).'</td>';
				$output .= '<td align="center">'.stripslashes($row['city']).'</td>';
				$output .= '<td align="center">'.stripslashes($row['place']).'</td>';
				$output .= '<td align="center">'.$status.'</td>';
				$output .= '<td align="center">'.$date.'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
							if($reset_pass)	{
				$output	.= '<a href="index.php?mode=reset_practitioner_password&uid='.$row['pro_user_id'].'" >Reset Password</a>';
							}
				$output	.= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
							if($edit) {
				$output .= '<a href="index.php?mode=edit_practitioner&uid='.$row['pro_user_id'].'" ><img src = "images/edit.gif" border="0"></a>';
								}
				$output .= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
							if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Practitioner","sql/delpractitioner.php?uid='.$row['pro_user_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
							   }
				$output .='</td>';
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="11" align="center">NO USERS FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function chkValidUser($user_id)
	{
		$this->connectDB();
		$return = false;
		
		$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$return = true;
		}
		return $return;
	}
	
	public function chkValidProUser($pro_user_id)
	{
		$this->connectDB();
		$return = false;
		
		$sql = "SELECT * FROM `tblprofusers` WHERE `pro_user_id` = '".$pro_user_id."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$return = true;
		}
		return $return;
	}
	
	public function getUserDetails($user_id)
	{
		$this->connectDB();
		$return = false;
		
		$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$return = true;
			$name = stripslashes($row['name']);
			$email = $row['email'];
			$dob = $row['dob'];
			$height = stripslashes($row['height']);
			$weight = stripslashes($row['weight']);
			$sex = $row['sex'];
			$mobile = stripslashes($row['mobile']);
			$state_id = $row['state_id'];
			$city_id = $row['city_id'];
			$place_id = $row['place_id'];
			$food_veg_nonveg = stripslashes($row['food_veg_nonveg']);
			$beef = $row['beef'];
			$pork = $row['pork'];
			$status = $row['status'];
		}
		return array($return,$name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$status);
	}
	
	public function getUserDetailsPro($pro_user_id)
	{
		$this->connectDB();
		$return = false;
		
		$sql = "SELECT * FROM `tblprofusers` WHERE `pro_user_id` = '".$pro_user_id."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$return = true;
			$name = stripslashes($row['name']);
			$email = $row['email'];
			$dob = $row['dob'];
			$sex = $row['sex'];
			$mobile = stripslashes($row['mobile']);
			$address = stripslashes($row['address']);
			$country_id = $row['country_id'];
			$state_id = $row['state_id'];
			$city_id = $row['city_id'];
			$place_id = $row['place_id'];
			$reg_no = stripslashes($row['reg_no']);
			$issued_by = stripslashes($row['issued_by']);
			$scan_image = stripslashes($row['scan_image']);
			$membership = stripslashes($row['membership']);
			$membership_no = stripslashes($row['membership_no']);
			$membership_image = stripslashes($row['membership_image']);
			$service_clinic_name = stripslashes($row['service_clinic_name']);
			$service_location = stripslashes($row['service_location']);
			$service_location_country_id = stripslashes($row['service_location_country_id']);
			$service_location_state_id = stripslashes($row['service_location_state_id']);
			$service_location_city_id = stripslashes($row['service_location_city_id']);
			$service_location_place_id = stripslashes($row['service_location_place_id']);
			$service_rendered = stripslashes($row['service_rendered']);
			$service_notes = stripslashes($row['service_notes']);
			$referred_by = stripslashes($row['referred_by']);
			$ref_name = stripslashes($row['ref_name']);
			$specify = stripslashes($row['specify']);
			$status = $row['status'];
		}
		return array($return,$name,$email,$dob,$sex,$mobile,$address,$country_id,$state_id,$city_id,$place_id,$reg_no,$issued_by,$scan_image,$membership,$membership_no,$membership_image,$service_clinic_name,$service_location,$service_location_country_id,$service_location_state_id,$service_location_city_id,$service_location_place_id,$service_rendered,$service_notes,$referred_by,$ref_name,$specify,$status);
	}
	
	public function getMonthOptions($month)
	{
		$arr_month = array (
			1 => 'January',
			2 => 'February',
			3 => 'March',
			4 => 'April',
			5 => 'May',
			6 => 'June',
			7 => 'July',
			8 => 'August',
			9 => 'September',
			10 => 'October',
			11 => 'November',
			12 => 'December'
		);
	
		
		$option_str = '';
		foreach($arr_month as $k => $v )
		{
			if($k == $month)
			{
				$selected = ' selected ';
			}
			else
			{
				$selected = '';
			}
			$option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';
		}	
		return $option_str;
	}
	
	public function getHeightOptions($height_id)
	{
		$this->connectDB();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblheights` ORDER BY `height_cms` ASC";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow()) 
			{
				if($row['height_id'] == $height_id)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				$option_str .= '<option value="'.$row['height_id'].'" '.$sel.'>'.$row['height_cms'].' cms ('.$row['height_feet_inch'].' feet)</option>';
			}
		}
		return $option_str;
	}
	
	public function getCountryOptions($country_id)
	{
		$this->connectDB();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblcountry` ORDER BY `country_name` ASC";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow()) 
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
	
	public function getStateOptions($country_id,$state_id)
	{
		$this->connectDB();
		$option_str = '';		
		
		//$sql = "SELECT * FROM `tblstates` ORDER BY `state` ASC";
		$sql = "SELECT * FROM `tblstates` WHERE `country_id` = '".$country_id."' ORDER BY `state` ASC";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow()) 
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
	
	public function getCityOptions($state_id,$city_id)
	{
		$this->connectDB();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblcities` WHERE `state_id` = '".$state_id."' ORDER BY `city` ASC";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow()) 
			{
				if($row['city_id'] == $city_id)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				$option_str .= '<option value="'.$row['city_id'].'" '.$sel.'>'.$row['city'].'</option>';
			}
		}
		return $option_str;
	}
	
	public function getPlaceOptions($state_id,$city_id,$place_id)
	{
		$this->connectDB();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblplaces` WHERE `state_id` = '".$state_id."' AND `city_id` = '".$city_id."' ORDER BY `place` ASC";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow()) 
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
	
	public function genrateUserUniqueId($user_id)
	{
		$unique_id = '';
		
		$strlen_user_id = strlen($user_id);
		
		if($strlen_user_id == 1)
		{
			$unique_id = 'CW10000000'.$user_id;
		} 
		elseif($strlen_user_id == 2)
		{
			$unique_id = 'CW1000000'.$user_id;
		}
		elseif($strlen_user_id == 3)
		{
			$unique_id = 'CW100000'.$user_id;
		}
		elseif($strlen_user_id == 4)
		{
			$unique_id = 'CW10000'.$user_id;
		}
		elseif($strlen_user_id == 5)
		{
			$unique_id = 'CW1000'.$user_id;
		}
		elseif($strlen_user_id == 6)
		{
			$unique_id = 'CW100'.$user_id;
		}
		elseif($strlen_user_id == 7)
		{
			$unique_id = 'CW10'.$user_id;
		}
		else
		{
			$unique_id = 'CW1'.$user_id;
		}
		return $unique_id;	
	}
	
	public function getNameOfUser($user_id)
	{
		$this->connectDB();
		
		$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";
		$this->execute_query($sql);
		$row = $this->fetchRow();
		$name = stripslashes($row['name']);
		
		return $name;
	}
	
	public function getNameOfProUser($pro_user_id)
	{
		$this->connectDB();
		
		$sql = "SELECT * FROM `tblprofusers` WHERE `pro_user_id` = '".$pro_user_id."'";
		$this->execute_query($sql);
		$row = $this->fetchRow();
		$name = stripslashes($row['name']);
		
		return $name;
	}
	
	public function getEmailOfUser($user_id)
	{
		$this->connectDB();
		
		$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";
		$this->execute_query($sql);
		$row = $this->fetchRow();
		$email = stripslashes($row['email']);
		
		return $email;
	}
	
	public function getEmailOfProUser($pro_user_id)
	{
		$this->connectDB();
		
		$sql = "SELECT * FROM `tblprofusers` WHERE `pro_user_id` = '".$pro_user_id."'";
		$this->execute_query($sql);
		$row = $this->fetchRow();
		$email = stripslashes($row['email']);
		
		return $email;
	}
	
	public function chkEmailExists($email)
	{
		$this->connectDB();
		$return = false;
		
		$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function chkProEmailExists($email)
	{
		$this->connectDB();
		$return = false;
		
		$sql = "SELECT * FROM `tblprofusers` WHERE `email` = '".$email."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function chkEmailExists_edit($email,$user_id)
	{
		$this->connectDB();
		$return = false;
		
		$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `user_id` != '".$user_id."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function chkProEmailExists_edit($email,$pro_user_id)
	{
		$this->connectDB();
		$return = false;
		
		$sql = "SELECT * FROM `tblprofusers` WHERE `email` = '".$email."' AND `pro_user_id` != '".$pro_user_id."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function signUpUser($name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$password)
	{
		$this->connectDB();
		$return = false;
		$now = time();
		
		$sql = "INSERT INTO `tblusers` (`name`,`email`,`password`,`dob`,`height`,`weight`,`sex`,`mobile`,`state_id`,`city_id`,`place_id`,`food_veg_nonveg`,`beef`,`pork`,`status`,`user_add_date`) VALUES ('".addslashes($name)."','".$email."','".md5($password)."','".$dob."','".$height."','".$weight."','".$sex."','".addslashes($mobile)."','".$state_id."','".$city_id."','".$place_id."','".addslashes($food_veg_nonveg)."','".addslashes($beef)."','".addslashes($pork)."','1','".$now."')";
		//echo"<br>Testkk: sql = ".$sql;
		$this->execute_query($sql);
		if($this->result)
		{
			$user_id = $this->getInsertID();
			$unique_id = $this->genrateUserUniqueId($user_id);
			
			$sql2 = "UPDATE `tblusers` SET `unique_id` = '".$unique_id."' WHERE `user_id` = '".$user_id."'";
			$this->execute_query($sql2);
			return $this->result;
		}
		else
		{
			return false;
		}
		
	}
	
	function genrateProUserUniqueId($user_id)
	{
		$unique_id = '';
		
		$strlen_user_id = strlen($user_id);
		
		if($strlen_user_id == 1)
		{
			$unique_id = 'WP10000000'.$user_id;
		} 
		elseif($strlen_user_id == 2)
		{
			$unique_id = 'WP1000000'.$user_id;
		}
		elseif($strlen_user_id == 3)
		{
			$unique_id = 'WP100000'.$user_id;
		}
		elseif($strlen_user_id == 4)
		{
			$unique_id = 'WP10000'.$user_id;
		}
		elseif($strlen_user_id == 5)
		{
			$unique_id = 'WP1000'.$user_id;
		}
		elseif($strlen_user_id == 6)
		{
			$unique_id = 'WP100'.$user_id;
		}
		elseif($strlen_user_id == 7)
		{
			$unique_id = 'WP10'.$user_id;
		}
		else
		{
			$unique_id = 'WP1'.$user_id;
		}
		 
		return $unique_id;	
	}
	
	function signUpProUser($name,$email,$password,$dob,$sex,$mobile,$address,$country_id,$state_id,$city_id,$place_id,$reg_no,$issued_by,$scan_image,$membership,$membership_no,$membership_image,$service_clinic_name,$service_location,$service_location_country_id,$service_location_state_id,$service_location_city_id,$service_location_place_id,$service_rendered,$service_notes,$referred_by,$ref_name,$specify)
	{
		$this->connectDB();
		$return = false;
		$now = time();
		
		$sql = "INSERT INTO `tblprofusers` (`name`,`email`,`password`,`dob`,`sex`,`mobile`,`address`,`country_id`,`state_id`,`city_id`,`place_id`,`reg_no`,`issued_by`,`scan_image`,`membership`,`membership_no`,`membership_image`,`service_clinic_name`,`service_location`,`service_location_country_id`,`service_location_state_id`,`service_location_city_id`,`service_location_place_id`,`service_rendered`,`service_notes`,`referred_by`,`ref_name`,`specify`,`status`) VALUES ('".addslashes($name)."','".$email."','".md5($password)."','".$dob."','".$sex."','".addslashes($mobile)."','".addslashes($address)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($reg_no)."','".addslashes($issued_by)."','".addslashes($scan_image)."','".addslashes($membership)."','".addslashes($membership_no)."','".addslashes($membership_image)."','".addslashes($service_clinic_name)."','".addslashes($service_location)."','".addslashes($service_location_country_id)."','".addslashes($service_location_state_id)."','".addslashes($service_location_city_id)."','".addslashes($service_location_place_id)."','".addslashes($service_rendered)."','".addslashes($service_notes)."','".addslashes($referred_by)."','".addslashes($ref_name)."','".addslashes($specify)."','1')";
		$this->execute_query($sql);
		if($this->result)
		{
			$pro_user_id = $this->getInsertID();
			$pro_unique_id = $this->genrateProUserUniqueId($pro_user_id);
			
			$sql2 = "UPDATE `tblprofusers` SET `pro_unique_id` = '".$pro_unique_id."' WHERE `pro_user_id` = '".$pro_user_id."'";
			$this->execute_query($sql2);
			return $this->result;
		}
		return $return;
	}
	
	public function updateUser($email,$name,$dob,$height,$weight,$sex,$mobile,$status,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$user_id)
	{
		$this->connectDB();
		$now = time();
		
		$upd_sql = "UPDATE `tblusers` SET `email` = '".$email."' , `name` = '".addslashes($name)."' , `dob` = '".$dob."' , `height` = '".addslashes($height)."' , `weight` = '".addslashes($weight)."' , `sex` = '".$sex."' , `mobile` = '".addslashes($mobile)."' , `state_id` = '".$state_id."', `city_id` = '".$city_id."', `place_id` = '".addslashes($place_id)."' , `status` = '".$status."' , `food_veg_nonveg` = '".addslashes($food_veg_nonveg)."' , `beef` = '".addslashes($beef)."' , `pork` = '".addslashes($pork)."' WHERE `user_id` = '".$user_id."'";
		$this->execute_query($upd_sql);
		return $this->result;	
	}
	
	public function updateUserPro($name,$email,$dob,$sex,$mobile,$address,$country_id,$state_id,$city_id,$place_id,$reg_no,$issued_by,$scan_image,$membership,$membership_no,$membership_image,$service_clinic_name,$service_location,$service_location_country_id,$service_location_state_id,$service_location_city_id,$service_location_place_id,$service_rendered,$service_notes,$referred_by,$ref_name,$specify,$status,$pro_user_id)
	{
		$this->connectDB();
		$now = time();
		
		$upd_sql = "UPDATE `tblprofusers` SET `email` = '".$email."' , `name` = '".addslashes($name)."' , `dob` = '".$dob."' , `sex` = '".$sex."' , `mobile` = '".addslashes($mobile)."' , `address` = '".addslashes($address)."'  , `country_id` = '".addslashes($country_id)."'  , `state_id` = '".$state_id."', `city_id` = '".$city_id."', `place_id` = '".addslashes($place_id)."', `reg_no` = '".addslashes($reg_no)."' , `issued_by` = '".addslashes($issued_by)."' , `scan_image` = '".addslashes($scan_image)."' , `membership` = '".addslashes($membership)."' , `membership_no` = '".addslashes($membership_no)."' , `membership_image` = '".addslashes($membership_image)."' , `service_clinic_name` = '".addslashes($service_clinic_name)."' , `service_location` = '".addslashes($service_location)."' , `service_location_country_id` = '".addslashes($service_location_country_id)."' , `service_location_state_id` = '".addslashes($service_location_state_id)."' , `service_location_city_id` = '".addslashes($service_location_city_id)."' , `service_location_place_id` = '".addslashes($service_location_place_id)."' , `service_rendered` = '".addslashes($service_rendered)."' , `service_notes` = '".addslashes($service_notes)."' , `referred_by` = '".addslashes($referred_by)."' , `ref_name` = '".addslashes($ref_name)."' , `specify` = '".addslashes($specify)."'  , `status` = '".$status."' WHERE `pro_user_id` = '".$pro_user_id."'";
		$this->execute_query($upd_sql);
		return $this->result;	
	}
	
	public function chkValidPassword($password) 
	{
		$r1='/[A-Z]/';  //Uppercase
		$r2='/[a-z]/';  //lowercase
		$r3='/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'
		$r4='/[0-9]/';  //numbers
		
		if(preg_match_all($r1,$password, $o)<1) return false;
		if(preg_match_all($r2,$password, $o)<1) return false;
		if(preg_match_all($r3,$password, $o)<1) return false;
		if(preg_match_all($r4,$password, $o)<1) return false;
		
		//preg_match_all($r4,$password, $o);
		//echo'<br><pre>';
		//print_r($o);
		//echo'<br></pre>'; 
		
		if(strlen($password)<6) return false;
		
		return true;
	}
	
	public function resetUserPassword($user_id,$password)
	{
		$this->connectDB();
		
		$upd_sql = "UPDATE `tblusers` set `password` = '".md5($password)."' WHERE `user_id` = '".$user_id."'";
		$this->execute_query($upd_sql);
		return $this->result;
	}
	
	public function resetProUserPassword($pro_user_id,$password)
	{
		$this->connectDB();
		
		$upd_sql = "UPDATE `tblprofusers` set `password` = '".md5($password)."' WHERE `pro_user_id` = '".$pro_user_id."'";
		$this->execute_query($upd_sql);
		return $this->result;
	}
	
	public function deleteUser($user_id)
	{
		$this->connectDB();
		$del_sql1 = "DELETE FROM `tblusers` WHERE `user_id` = '".$user_id."'"; 
		$this->execute_query($del_sql1);
		return $this->result;
	}
	
	public function deleteProUser($pro_user_id)
	{
		$this->connectDB();
		$del_sql1 = "DELETE FROM `tblprofusers` WHERE `pro_user_id` = '".$pro_user_id."'"; 
		$this->execute_query($del_sql1);
		return $this->result;
	}
	
}
?>