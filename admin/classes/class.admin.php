<?php

include_once("class.paging.php");
require_once('class.logs.php');

class Admin extends mysqlConnection

{

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

	

	public function getUserDetails($admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		$row = $STH->fetch(PDO::FETCH_ASSOC); 

		$username = stripslashes($row['username']);

		$email = $row['email'];

		$fname = stripslashes($row['fname']);

		$lname = stripslashes($row['lname']);

		$dob = $row['dob'];

		$country = stripslashes($row['country']);

		$state = stripslashes($row['state']);

		$city = stripslashes($row['city']);

		$contact_no = $row['contact_no'];

		$address = stripslashes($row['address']);

		

		return array($username,$email,$fname,$lname,$dob,$country,$state,$city,$contact_no,$address,$status);

	

	}

	

	public function GetAllSubAdmin($search,$status)

	{

		$my_DBH = new mysqlConnection();
		$logsObject = new Logs();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();
				$extQry = '';
		if(!empty($search)){
			$extQry.=' AND (email like '%".$search."%' OR fname like '%".$search."%' OR lname like '%".$search."%' OR username like '%".$search."%') ';
		}

		if(!empty($status)){
			if($status=='active'){
				$extQry.=' AND status = 1 ';
			}else{
				$extQry.=' AND status = 0 ';
			}
			
		}

		$sql = "SELECT * FROM `tbladmin` WHERE `super_admin` = '0' $extQry      

	ORDER BY admin_id DESC";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=manage_subadmin");

                

                $STH = $DBH->prepare($page->get_limit_query($sql));

                $STH->execute();

	 	//$result=$STH->execute_query($page->get_limit_query($sql));

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

			    if($row['status'] == 1)

					{

						 $status = 'Active'; 

					}

					else

					{ 

						$status = 'Inactive';

					}
				$lastUpdatedData = [
					'page' => 'manage_subadmin',
					'reference_id' => $row['admin_id']
				];
				$lastUpdatedData = $logsObject->getLastUpdatedLogs($lastUpdatedData);
				
				$output .= '<tr class="manage-row">';

				

				$output .= '<td align="center" nowrap="nowrap" ><input type="checkbox" id="chk_delete" name="chk_delete[]" value="'.$row['admin_id'].'" /></td>';

				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center" nowrap="nowrap"><a href="index.php?mode=edit_sub_admin&uid='.$row['admin_id'].'" ><img src = "images/edit.gif" border="0"></a></td>';
				$output .= '<td align="center" nowrap="nowrap"><a href="index.php?mode=reset_sub_admin_password&uid='.$row['admin_id'].'" >Reset Password</a></td>';
				$output .= '<td align="center">'.$status.'</td>';
				$output .= '<td align="center">'.$row['email'].'</td>';

				$output .= '<td align="center">'.stripslashes($row['username']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['fname']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['lname']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['address']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['contact_no']).'</td>';

				$output .= '<td align="center">'.stripslashes($lastUpdatedData['updateOn']).'
				<a href="/admin/index.php?mode=logs-history&type=manage_subadmin&id='.$row['admin_id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';

				$output .= '<td align="center">'.stripslashes($lastUpdatedData['updateBy']).'<a href="/admin/index.php?mode=logs-history&type=manage_subadmin&id='.$row['admin_id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';
				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="10" align="center">NO PAGES FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	

	public function isAdminLoggedIn()

	{

		$return = false;

		if( isset($_SESSION['admin_id']) && ($_SESSION['admin_id'] > 0) && ($_SESSION['admin_id'] != '') )

		{

			$return = $this->chkValidAdminId($_SESSION['admin_id']);	

		}

		return $return;

	}

	

	public	function chkSubAdminUserNameExists_edit($username,$admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `admin_id` != '".$admin_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public	function getEmailOfSubAdmin($admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$email = '';

		

		$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$email = $row['email'];

		}

		return $email;

	}

	

	

	public function resetSubAdminPassword($admin_id,$password)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "UPDATE `tbladmin` SET `password` = '".md5($password)."'  WHERE `admin_id` = '".$admin_id."'";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

                if($STH->rowCount() > 0)

		{

                    $return = true;

                }

		return $return;

	}



	public function getEmailOfSubAdminByID($admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$email = '';

		

		$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."'";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$email = $row['email'];

		}

		//echo $email;

		return $email;

	}

	

	public function getNameOfSubAdmin($admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$name = '';

		

		$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."'";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$fname = $row['fname'];

		}

		return $fname;

	}

        

        public function getUsenameOfAdmin($admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$uname = '';

		

		$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."'";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$uname = $row['username'];

		}

		return $uname;

	}



	

	public function chkValidSubAdminId($admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `super_admin` = '0'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}



	

	public function chkSubAdminEmailExists_edit($email,$admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbladmin` WHERE `email` = '".$email."' AND `admin_id` != '".$admin_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	

	public function chkValidAdminId($admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' ";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	function getSubAdminDetails($admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbladmin` WHERE `admin_id`='".$admin_id."'";

		

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$return = true;

			$username     = strip_tags($row['username']);

			$email        = strip_tags($row['email']);

			$fname        = strip_tags($row['fname']);

			$lname	      = strip_tags($row['lname']);

			$dob	      = strip_tags($row['dob']);

			$contact_no   = strip_tags($row['contact_no']);

			$address      = strip_tags($row['address']);

			$city	      = strip_tags($row['city']);

			$state		  = strip_tags($row['state']);

			$country      = strip_tags($row['country']); 

			$admin_menu_id	= strip_tags($row['admin_menu_id']);

			$admin_action_id	= strip_tags($row['admin_action_id']);

			$status		= strip_tags($row['status']);

		}

	return array($return,$username,$email,$fname,$lname,$dob,$contact_no,$address,$city,$state,$country,$admin_menu_id,$admin_action_id,$status);

	}

	

	

	public function isSuperAdmin()

		{

			$my_DBH = new mysqlConnection();

                        $DBH = $my_DBH->raw_handle();

                        $DBH->beginTransaction();

			$return = false;

			$admin_id = $_SESSION['admin_id'];

			$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `super_admin` = '1'";

			$STH = $DBH->prepare($sql);

                        $STH->execute();

			if($STH->rowCount() > 0)

			{

				$return = true;

			}

			return $return;

		}

	

	public function chkUsernameExists($username)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public	function getMenu() 

		{

			$my_DBH = new mysqlConnection();

                        $DBH = $my_DBH->raw_handle();

                        $DBH->beginTransaction();

			$return = false;

			$arr_admin_menu_id = array();

			$arr_menu_name = array();

			$arr_menu_href = array();

			

			$sql = "SELECT * FROM `tbladminmenu`";

			//echo $sql;

			$STH = $DBH->prepare($sql);

                        $STH->execute();

			if($STH->rowCount() > 0)

			{

				$return = true;

				while($row = $STH->fetch(PDO::FETCH_ASSOC))

					{

						array_push($arr_admin_menu_id , $row['menu_id']);

						array_push($arr_menu_name , $row['menu_name']);

						array_push($arr_menu_href , $row['menu_href']);

					}

			}

				

			return array($arr_admin_menu_id,$arr_menu_name,$arr_menu_href);	

		}

	

	public function updateSubAdmin($admin_id,$email,$username,$status,$fname,$lname,$address,$dob,$contact_no,$country,$state,$city,$menu_comma_separated,$permissions_comma_separated)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;
		if(empty($dob) || $dob=='--'){
			$dob = '0000-00-00';
		}
		

		$sql = "UPDATE `tbladmin` SET `email` = '".addslashes($email)."' ,`username` = '".addslashes($username)."' ,`status` = '".addslashes($status)."' , `fname` = '".addslashes($fname)."' ,`lname` = '".addslashes($lname)."' ,`address` = '".addslashes($address)."' , `dob` = '".addslashes($dob)."' ,`contact_no` = '".addslashes($contact_no)."' ,`country` = '".addslashes($country)."' , `state` = '".addslashes($state)."' ,`city` = '".addslashes($city)."' ,`admin_menu_id` = '".addslashes($menu_comma_separated)."', `admin_action_id` = '".addslashes($permissions_comma_separated)."'   WHERE `admin_id` = '".$admin_id."'";

		

		$STH = $DBH->prepare($sql);

                $STH->execute();

                if($STH->rowCount() > 0)

			{

                    $return = true;

					//Insert Logs
					$logsObject = new Logs();
					$logsData = [
						'page' => 'manage_subadmin',
						'reference_id' => $admin_id
					];
					$logsObject->insertLogs($logsData);

                }

		return $return;	

	}

	

public	function signUpSubAdmin($email,$username,$password,$fname,$lname,$address,$dob,$contact_no,$country,$state,$city,$menu_comma_separated,$permissions_comma_separated)

	{
		
		
		if(empty($dob) || $dob=='--'){
			$dob = '0000-00-00';
		}
		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "INSERT INTO `tbladmin`(`username`,`password`,`email`,`fname`,`lname`,`dob`,`contact_no`,`address`,`city`,`state`,`country`,`super_admin`,`admin_menu_id`,`admin_action_id`,`status`) VALUES ('".addslashes($username)."','".md5($password)."','".addslashes($email)."','".addslashes($fname)."','".addslashes($lname)."','".addslashes($dob)."','".addslashes($contact_no)."','".addslashes($address)."','".addslashes($city)."','".addslashes($state)."','".addslashes($country)."','0','".addslashes($menu_comma_separated)."','".addslashes($permissions_comma_separated)."','1')";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

                if($STH->rowCount() > 0)

			{
					
                    $return = true;

					//Inserting Logs
					$lastInsertedId = $DBH->lastInsertId();
					$logsObject = new Logs();
					$logsData = [
						'page' => 'manage_subadmin',
						'reference_id' => $lastInsertedId
					];
					$logsObject->insertLogs($logsData);

                }

		return $return;	

	}

	

	

	public	function getActions($arr_admin_menu_id)

		{

			$my_DBH = new mysqlConnection();

                        $DBH = $my_DBH->raw_handle();

                        $DBH->beginTransaction();

			$return = false;

			$arr_admin_action_id = array();

			$arr_action_name = array();

			

			

			$sql = "SELECT * FROM `tbladminactions` WHERE `admin_menu_id` = '".$arr_admin_menu_id."' ";

			//echo $sql;

			$STH = $DBH->prepare($sql);

                        $STH->execute();

			if($STH->rowCount() > 0)

			{

                            $return = true;

                            while($row = $STH->fetch(PDO::FETCH_ASSOC))

                                {

                                    array_push($arr_admin_action_id , $row['admin_action_id']);

                                    array_push($arr_action_name , $row['action_name']);

                                }

			}

			return array($arr_admin_action_id,$arr_action_name);	

		}

	

	

	public	function chkSubAdminEmailExists($email)

		{

			$my_DBH = new mysqlConnection();

                        $DBH = $my_DBH->raw_handle();

                        $DBH->beginTransaction();

			$return = false;

			

			$sql = "SELECT * FROM `tbladmin` WHERE `email` = '".$email."'";

			$STH = $DBH->prepare($sql);

                        $STH->execute();

			if($STH->rowCount() > 0)

			{

				$return = true;

			}

			return $return;

		}

	

	public function chkUsernameExists_edit($username,$admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `admin_id` != '".$admin_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function chkEmailExists($email)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbladmin` WHERE `email` = '".$email."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function chkEmailExists_edit($email,$admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbladmin` WHERE `email` = '".$email."' AND `admin_id` != '".$admin_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function signUpUser($username,$password,$email,$fname,$lname,$dob,$address,$city,$state,$country,$contact_no)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "INSERT INTO `tbladmin` (`username`,`password`,`email`,`fname`,`lname`,`dob`,`contact_no`,`address`,`city`,`state`,`country`) VALUES ('".addslashes($username)."','".md5($password)."','".$email."','".addslashes($fname)."','".addslashes($lname)."','".$dob."','".$contact_no."','".addslashes($address)."','".addslashes($city)."','".addslashes($state)."','".addslashes($country)."')";

		//echo"<br>Testkk: sql = ".$sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	

	public function updateUser($admin_id,$username,$email,$fname,$lname,$dob,$address,$city,$state,$country,$contact_no)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$now = time();

                $return = false;

		

		$upd_sql = "UPDATE `tbladmin` set `username` = '".addslashes($username)."' , `email` = '".$email."' , `fname` = '".addslashes($fname)."' , `lname` = '".addslashes($lname)."', `dob` = '".$dob."', `address` = '".addslashes($address)."', `city` = '".addslashes($city)."', `state` = '".addslashes($state)."', `country` = '".addslashes($country)."', `contact_no` = '".$contact_no."'  WHERE `admin_id` = '".$admin_id."'";

		

                $STH = $DBH->prepare($upd_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$_SESSION['admin_username'] = $username;

			$_SESSION['admin_fname'] = stripslashes($fname);

			$_SESSION['admin_lname'] = stripslashes($lname);

			$_SESSION['admin_email'] = $email;

                        $return = true;

		}

		return $return;	

	}

	

	public function DeleteUser($admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;

		$del_sql1 = "DELETE FROM `tbladmin` WHERE `admin_id` = '".$admin_id."'"; 

		

                $STH = $DBH->prepare($del_sql1);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

                    $return = true;

                }

                return $return;

	}

	

	public function GetCurrentPassword()

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$sql = "select password from `tbladmin` where admin_id = '".$_SESSION['admin_id']."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		$row = $STH->fetch(PDO::FETCH_ASSOC);

		return $row;

	}

	

	public function UpdatePassword($password)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$sql = "UPDATE `tbladmin` set `password`	= '".md5($password)."' where admin_id = '".$_SESSION['admin_id']."'";

		$STH = $DBH->prepare($sql);

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

	

	public	function DeleteSubAdmin($admin_id)

		{

			$my_DBH = new mysqlConnection();

                        $DBH = $my_DBH->raw_handle();

                        $DBH->beginTransaction();

			$return = false;

			$sql = "DELETE FROM `tbladmin`  WHERE `admin_id` = '".$admin_id."'"; 

			$STH = $DBH->prepare($sql);

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

		

		public function getAllMenu()

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$arr_menu_id = array(); 

		$arr_menu_name = array(); 

		$arr_menu_mode = array();

				

		$sql = "SELECT * FROM `tbladminmenu` WHERE `status` = '1' ORDER BY `menu_name` ASC";

		

		$STH = $DBH->prepare($sql);

                $STH->execute();

                if($STH->rowCount() > 0)

		{

                    while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                        {

                                array_push($arr_menu_id , stripslashes($row['menu_id']));

                                array_push($arr_menu_name , stripslashes($row['menu_name']));

                                array_push($arr_menu_mode , stripslashes($row['menu_mode']));

                        }	

		}

		return array($arr_menu_id,$arr_menu_name,$arr_menu_mode);

	}

	

	public function chkValidMenuPermission($admin_id,$admin_menu_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

                if($STH->rowCount() > 0)

			{

				$row = $STH->fetch(PDO::FETCH_ASSOC); 

				$super_admin     = 	strip_tags($row['super_admin']);

				$str_admin_menu_id   =  strip_tags($row['admin_menu_id']);

				$admin_action_id =  strip_tags($row['admin_action_id']);

			   

				if($super_admin == '1')

				{

				  $return = true;

				}

				else

				{

				   $arr_chk_menu = explode(",", $str_admin_menu_id);

				     if (in_array($admin_menu_id , $arr_chk_menu))

						{

						  $return = true;

						} 

				}

			}

		return $return;

	}

	

	public function chkValidActionPermission($admin_id,$action_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		//echo '<br>'.$action_id;

		$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."'";

		//echo '<br>'.$sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

                if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC); 

			$super_admin     = 	stripslashes($row['super_admin']);

			$str_admin_menu_id   =  stripslashes($row['admin_menu_id']);

			$str_admin_action_id =  stripslashes($row['admin_action_id']);

		   

			if($super_admin == '1')

			{

			  $return = true;

			}

			else

			{

				//echo '<br>'.$str_admin_action_id;

			   $arr_chk_permission = explode(",", $str_admin_action_id);

			  // print_r($arr_chk_permission);

				  if (in_array($action_id , $arr_chk_permission))

					{

					  $return = true;

					} 

			}

		}

		return $return;

	}
	//added by ample 24-12-20
	public function date_formate($date=''){
       if(empty($date) || $date=='0000-00-00')
       {
          return 'N/A';
       }
       else
       {
          return date("d-m-Y", strtotime($date));
       }
    }
    //add by ample 29-10-20
    public function getRedirectSchedule($redirect_id="",$redirect="")
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tbl_common_scheduled` WHERE redirect='".$redirect."' AND redirect_id =".$redirect_id;
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
        }
        return $data;     
    }
    //copy by ample 29-10-20
    public function getMonthName($no_month) {
        $option_str = '';
        $arr_record = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
        return $arr_record[$no_month];
    }
    //copy by ample 29-10-20
    public function getWeekName($no_week) {
        $option_str = '';
        $arr_day_of_week = array(1 => 'Sunday', 2 => 'Monday', 3 => 'Tuesday', 4 => 'Wednesday', 5 => 'Thursday', 6 => 'Friday', 7 => 'Saturday');
        return $arr_day_of_week[$no_week];
    }
    public function GetStateName($state_id) {
        $DBH = new mysqlConnection();
        $option_str = '';
        $sql = "SELECT `state` FROM `tblstates` WHERE `state_id` = " . $state_id . " ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $option_str = $row['state'];
        }
        return $option_str;
    }
    public function GetCityName($city_id) {
        $DBH = new mysqlConnection();
        $option_str = '';
        $sql = "SELECT `city` FROM `tblcities` WHERE `city_id` = " . $city_id . " ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $option_str = $row['city'];
        }
        return $option_str;
    }
    public function GetAreaName($area_id) {
        $DBH = new mysqlConnection();
        $option_str = '';
        $sql = "SELECT `area_name` FROM `tblarea` WHERE `area_id` = " . $area_id . " ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $option_str = $row['area_name'];
        }
        return $option_str;
    }
    public function getFavCategoryName($fav_cat_id)
	{

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $fav_cat_type = '';
        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount()  > 0)
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $fav_cat_type = stripslashes($row['fav_cat']);
        }
        return $fav_cat_type;
	}
}

?>