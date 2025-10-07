<?php
require_once 'config.php';
class Admin
{
    function __construct() 
    {
    }

    public function debuglog($stringData)
    {
        $logFile = SITE_PATH."/logs/debuglog_admin_".date("Y-m-d").".txt";
        $fh = fopen($logFile, 'a');
        fwrite($fh, "\n\n----------------------------------------------------\nDEBUG_START - time: ".date("Y-m-d H:i:s")."\n".$stringData."\nDEBUG_END - time: ".date("Y-m-d H:i:s")."\n----------------------------------------------------\n\n");
        fclose($fh);	
    }
	
	public function getErrormsgString($err_msg)
    {
        $output = '<div id="message-red">
                        <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                                <td class="red-left">Error. '.$err_msg.'</td>
                                <td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif"   alt="" /></a></td>
                        </tr>
                        </table>
					</div>';
        return $output;
    }

    public function chkValidAdmin($admin_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;
		
		$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `status` = '1' AND `deleted` = '0' ";
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;	
        }
        return $return;
    }

    public function isAdminLoggedIn()
    {
        $return = false;
        if( isset($_SESSION['admin_id']) && ($_SESSION['admin_id'] > 0) && ($_SESSION['admin_id'] != '') )
        {
            $admin_id = $_SESSION['admin_id'];
            if($this->chkValidAdmin($admin_id))
            {
                $return = true;	
            }	
        }
        return $return;
    }

    public function chkValidAdminLogin($username,$password)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `password` = '".md5($password)."' AND `status` = '1' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;	
        }
        return $return;
    }
	

    public function chkValidAdminCurrentPassword($password,$admin_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `password` = '".md5($password)."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }

    public function doAdminLogin($username)
    {
        global $link;
        $return = false;

        $admin_id = $this->getAdminId($username);
        $fname = $this->getAdminFirstName($username);
        $lname = $this->getAdminLastName($username);
        $email = $this->getAdminEmail($username);
        $admin_type = $this->getAdminType($admin_id);

        if($admin_id > 0)
        {
            $return = true;	
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_username'] = $username; 
            $_SESSION['admin_fname'] = $fname;
            $_SESSION['admin_lname'] = $lname;
            $_SESSION['admin_email'] = $email;
            $_SESSION['admin_type'] = $admin_type;
        }	
        return $return;
    }
	
    public function doAdminLogout()
    {
        global $link;
        $return = true;	

        $_SESSION['admin_id'] = '';
        $_SESSION['admin_username'] = '';
        $_SESSION['admin_fname'] = '';
        $_SESSION['admin_lname'] = '';
        $_SESSION['admin_email'] = '';
        $_SESSION['admin_type'] = '';
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_fname']);
        unset($_SESSION['admin_lname']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['admin_type']);
        session_destroy();
        session_start();
        session_regenerate_id();
        $new_sessionid = session_id();

        return $return;
    }

    public function getAdminId($username)
    {
        $DBH = new DatabaseHandler();
        $admin_id = 0;

        $sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $admin_id = $r['admin_id'];
        }
        return $admin_id;
    }

    public function getAdminFirstName($username)
    {
        $DBH = new DatabaseHandler();
        $fname = '';

        $sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $fname = stripslashes($r['fname']);
        }
        return $fname;
    }
	
    public function getAdminLastName($username)
    {
        $DBH = new DatabaseHandler();
        $lname = '';

		$sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `deleted` = '0' ";
		$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $lname = stripslashes($r['lname']);
        }
        return $lname;
    }

	public function getAdminEmail($username)
    {
        $DBH = new DatabaseHandler();
        $email = '';

        $sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $email = stripslashes($r['email']);
        }
        return $email;
    }

    public function getAdminEmailById($admin_id)
    {
        $DBH = new DatabaseHandler();
        $email = '';

        $sql = "SELECT email FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $email = stripslashes($r['email']);
        }
        return $email;
    }

    public function getAdminUsername($admin_id)
    {
        $DBH = new DatabaseHandler();
        $username = '';

        $sql = "SELECT username FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $username = stripslashes($r['username']);
        }
        return $username;
    }

    public function getAdminFullNameById($admin_id)
    {
        $DBH = new DatabaseHandler();
        $name = '';

        $sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $fname = stripslashes($r['fname']);
            $lname = stripslashes($r['lname']);
            $name = $fname.' '.$lname;
        }
        return $name;
    }
	
    public function getAdminType($admin_id)
    {
        $DBH = new DatabaseHandler();
        $admin_type = '';
        $super_admin = 0;

        $sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $super_admin = $r['super_admin'];
        }

        if($super_admin == '1')
		{
            $admin_type = 'Super Admin';
        }
        else
        {
            $admin_type = 'Sub Admin';
        }
        return $admin_type;
    }
	
	public function chkIfSuperAdmin($admin_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            if($r['super_admin'] == '1')
			{
				$return = true;
			}
		}

        return $return;
    }
	
    public function getAdminUserDetails($admin_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function getAdminCurrentPassword($admin_id)
    {
        $DBH = new DatabaseHandler();
        $password = '';
        
        $sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $password = $r['password'];
        }	

        return $password;
    }
	
	public function getAgentCurrentPassword($agent_id)
    {
        $DBH = new DatabaseHandler();
        $password = '';
        
        $sql = "SELECT * FROM `tblagents` WHERE `agent_id` = '".$agent_id."' AND `agent_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $password = $r['agent_password'];
        }	

        return $password;
    }

    public function updateAdminUser($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tbladmin` SET 
					`username` = :username,
					`email` = :email,
					`fname` = :fname,
					`lname` = :lname,
					`contact_no` = :contact_no,  
					`am_id` = :am_id,  
					`aa_id` = :aa_id,  
					`status` = :status  
					WHERE `admin_id` = :admin_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':username' => addslashes($tdata['username']),
				':email' => addslashes($tdata['email']),
				':fname' => addslashes($tdata['fname']),
				':lname' => addslashes($tdata['lname']),
				':contact_no' => addslashes($tdata['contact_no']),
				':am_id' => addslashes($tdata['am_id']),
				':aa_id' => addslashes($tdata['aa_id']),
				':status' => addslashes($tdata['status']),
				':admin_id' => $tdata['admin_id']
            ));
			$DBH->commit();
			
			$return = true;
			
			if($_SESSION['admin_id'] == $tdata['admin_id'])
			{
				$_SESSION['admin_username'] = $tdata['username'];
				$_SESSION['admin_fname'] = stripslashes($tdata['fname']);
				$_SESSION['admin_lname'] = stripslashes($tdata['lname']);
				$_SESSION['admin_email'] = $tdata['email'];	
			}
        } catch (Exception $e) {
			$stringData = '[updateAdminUser] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function addAdminUser($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tbladmin` (`username`,`password`,`email`,`fname`,`lname`,`contact_no`,`super_admin`,`am_id`,`aa_id`,`status`) 
					VALUES (:username,:password,:email,:fname,:lname,:contact_no,:super_admin,:am_id,:aa_id,:status)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':username' => addslashes($tdata['username']),
				':password' => md5($tdata['password']),
				':email' => addslashes($tdata['email']),
				':fname' => addslashes($tdata['fname']),
				':lname' => addslashes($tdata['lname']),
				':contact_no' => addslashes($tdata['contact_no']),
				':super_admin' => '0',
				':am_id' => addslashes($tdata['am_id']),
				':aa_id' => addslashes($tdata['aa_id']),
				':status' => '1'
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addAdminUser] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function deleteAdminUser($admin_id)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tbladmin` SET 
					`deleted` = :deleted
					WHERE `admin_id` = :admin_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':deleted' => '1',
				':admin_id' => $admin_id
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteAdminUser] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
    public function updateAdminPassword($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
		$return = false;
		
		try {
			$sql = "UPDATE `tbladmin` SET `password` = :password WHERE `admin_id` = :admin_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
                ':password' => md5($tdata['password']),
                ':admin_id' => $tdata['admin_id']
            ));
            $DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateAdminPassword] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function updateAgentPassword($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
		$return = false;
		
		try {
			$sql = "UPDATE `tblagents` SET `agent_password` = :agent_password WHERE `agent_id` = :agent_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
                ':agent_password' => md5($tdata['agent_password']),
                ':agent_id' => $tdata['agent_id']
            ));
            $DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateAgentPassword] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
    public function chkAdminUsernameExists($username)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkAdminUsernameExists_edit($username,$admin_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `admin_id` != '".$admin_id."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
    public function chkAdminEmailExists($email)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tbladmin` WHERE `email` = '".$email."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkAdminEmailExists_edit($email,$admin_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tbladmin` WHERE `email` = '".$email."' AND `admin_id` != '".$admin_id."' AND `deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function getAdminMenuCode($admin_id,$admin_main_menu_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$output .= '<ul class="nav panel-list">';
		
		if($admin_main_menu_id == '1' )
		{
			$li_class = ' class="active" ';
		}
		else
		{
			$li_class = '';
		}
		
		$output .= '<li '.$li_class.'>
						<a href="'.ADMIN_URL.'">
							<i class="fa fa-home"></i>
							<span class="menu-text">Dashboard</span>
							<span class="selected"></span>
						</a>
					</li>';
				
		$is_super_admin = $this->chkIfSuperAdmin($admin_id);
		
		if($is_super_admin)
		{
			$sql = "SELECT TAM.* FROM `tbladminmenu` AS TAM WHERE TAM.am_status = '1' AND TAM.am_deleted = '0' AND TAM.parent_am_id = '0' ORDER BY TAM.am_order ASC";	
		}
		else
		{
			$sql = "SELECT TAM.* FROM `tbladminmenu` AS TAM WHERE TAM.am_status = '1' AND TAM.am_deleted = '0' AND TAM.parent_am_id = '0' AND FIND_IN_SET(TAM.am_id, ( SELECT am_id FROM `tbladmin` WHERE admin_id = '".$admin_id."' AND `status` = '1' AND `deleted` = '0' )) > 0 ORDER BY TAM.am_order ASC";	
		}
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$DBH2 = new DatabaseHandler();	
				if($is_super_admin)
				{
					$sql2 = "SELECT TAM.* FROM `tbladminmenu` AS TAM WHERE TAM.am_status = '1' AND TAM.am_deleted = '0' AND TAM.parent_am_id = '".$r['am_id'] ."' ORDER BY TAM.am_order ASC";	
				}
				else
				{
					$sql2 = "SELECT TAM.* FROM `tbladminmenu` AS TAM WHERE TAM.am_status = '1' AND TAM.am_deleted = '0' AND TAM.parent_am_id = '".$r['am_id'] ."' AND FIND_IN_SET(TAM.am_id, ( SELECT am_id FROM `tbladmin` WHERE admin_id = '".$admin_id."' AND `status` = '1' AND `deleted` = '0' )) > 0 ORDER BY TAM.am_order ASC";	
				}
				$STH2 = $DBH2->query($sql2);
				if( $STH2->rowCount() > 0 )
				{
					if($admin_main_menu_id == $r['am_id'] )
					{
						$li_class = ' class="hoe-has-menu active" ';
					}
					else
					{
						$li_class = ' class="hoe-has-menu" ';
					}
					
					$output .= '<li '.$li_class.'>
									<a href="javascript:void(0)">
										<i class="fa '.$r['am_icon'].'"></i>
										<span class="menu-text">'.$r['am_title'].'</span>
										<span class="selected"></span>
									</a>
									<ul class="hoe-sub-menu">';
					while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))
					{
						$output .= '<li>
										<a href="'.ADMIN_URL.'/'.$r2['am_link'].'">
											<span class="menu-text">'.$r2['am_title'].'</span>
										<span class="selected"></span>
										</a>
									</li>';
					}
					$output .= '	</ul>
								</li>';
				}
				else
				{
					if($admin_main_menu_id == $r['am_id'] )
					{
						$li_class = ' class="active" ';
					}
					else
					{
						$li_class = '';
					}
					
					$output .= '<li '.$li_class.'>
									<a href="'.ADMIN_URL.'/'.$r['am_link'].'">
										<i class="fa '.$r['am_icon'].'"></i>
										<span class="menu-text">'.$r['am_title'].'</span>
										<span class="selected"></span>
									</a>
								</li>';
				}					
			}
		}
		$output .= '</ul>';	
		return $output;
	}
	
	public function getAgentMenuCode($admin_main_menu_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$output .= '<ul class="nav panel-list">';
		
		if($admin_main_menu_id == '1' )
		{
			$li_class = ' class="active" ';
		}
		else
		{
			$li_class = '';
		}
		
		$output .= '<li '.$li_class.'>
						<a href="'.AGENT_URL.'">
							<i class="fa fa-home"></i>
							<span class="menu-text">Dashboard</span>
							<span class="selected"></span>
						</a>
					</li>';
		
		$li_class_booking = ' class="hoe-has-menu" ';	
		$li_class_students = ' class="hoe-has-menu" ';	
		if($admin_main_menu_id == '2' )
		{
			$li_class_booking = ' class="hoe-has-menu active" ';
		}
		elseif($admin_main_menu_id == '5' )
		{
			$li_class_students = ' class="hoe-has-menu active" ';
		}
		
					
		$output .= '<li '.$li_class_booking.'>
						<a href="'.AGENT_URL.'/manage_my_bookings.php">
							<i class="fa fa-user"></i>
							<span class="menu-text">Manage My Bookings</span>
							<span class="selected"></span>
						</a>
					</li>';
					
		$output .= '<li '.$li_class_students.'>
						<a href="'.AGENT_URL.'/manage_my_students.php">
							<i class="fa fa-user"></i>
							<span class="menu-text">Manage Students</span>
							<span class="selected"></span>
						</a>
					</li>';
					
		$output .= '</ul>';	
		return $output;
	}
	
	public function chkIfAccessOfMenu($admin_id,$admin_main_menu_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;
		
		$is_super_admin = $this->chkIfSuperAdmin($admin_id);
		
		if($is_super_admin)
		{
			$return = true;
		}
		else
		{
			$sql = "SELECT TAM.* FROM `tbladminmenu` AS TAM WHERE TAM.am_status = '1' AND TAM.am_deleted = '0' AND TAM.parent_am_id = '0' AND FIND_IN_SET('".$admin_main_menu_id."', ( SELECT am_id FROM `tbladmin` WHERE admin_id = '".$admin_id."' AND `status` = '1' AND `deleted` = '0' )) > 0 ORDER BY TAM.am_order ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;
			}
		}
        return $return;
    }
	
	public function chkIfAccessOfMenuAction($admin_id,$action_id)
	{
		$DBH = new DatabaseHandler();
		$return = false;
		
		$is_super_admin = $this->chkIfSuperAdmin($admin_id);
		
		if($is_super_admin)
		{
			$return = true;
		}
		else
		{
			$sql = "SELECT TAA.* FROM `tbladminactions` AS TAA WHERE TAA.aa_status = '1' AND TAA.aa_deleted = '0' AND FIND_IN_SET('".$action_id."', ( SELECT aa_id FROM `tbladmin` WHERE admin_id = '".$admin_id."' AND `status` = '1' AND `deleted` = '0' )) > 0 ";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;
			}
		}
		
		return $return;
	}
	
	public function getAllSubadmins($txtsearch='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		if($txtsearch != '')
		{
			$sql_search_str = " AND (`username` LIKE '%".$txtsearch."%' OR `email` LIKE '%".$txtsearch."%' OR `fname` LIKE '%".$txtsearch."%' OR `lname` LIKE '%".$txtsearch."%' )";
		}
		
		$sql = "SELECT * FROM `tbladmin` WHERE `super_admin` = '0' AND `deleted` = '0' ".$sql_search_str." ORDER BY admin_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function getAllMenuAccess()
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql = "SELECT * FROM `tbladminmenu` WHERE `am_status` = '1' AND `am_deleted` = '0' ORDER BY am_order ASC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function getAllMenuActionsAccess($am_id)
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql = "SELECT * FROM `tbladminactions` WHERE `am_id` = '".$am_id."' AND `aa_status` = '1' AND `aa_deleted` = '0' ORDER BY aa_add_date ASC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function getStateOption($state_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$sql = "SELECT * FROM `tblstates` ORDER BY state ASC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				if($r['state_id'] == $state_id )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="'.$r['state_id'].'" '.$selected.'>'.$r['state'].'</option>';
			}
		}	
		return $output;
	}
	
	public function getCityOption($state_id,$city_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$sql = "SELECT * FROM `tblcities` WHERE `state_id` = '".$state_id."' ORDER BY city ASC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				if($r['city_id'] == $city_id )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="'.$r['city_id'].'" '.$selected.'>'.$r['city'].'</option>';
			}
		}	
		return $output;
	}
	
	public function getAllCourses()
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql = "SELECT * FROM `tblcourses` WHERE `course_deleted` = '0' ORDER BY `course_add_date` DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function chkCourseNameExists($course_name)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblcourses` WHERE `course_name` = '".addslashes($course_name)."' AND `course_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkCourseNameExists_edit($course_name,$course_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblcourses` WHERE `course_name` = '".addslashes($course_name)."' AND `course_id` != '".$course_id."' AND `course_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addCourse($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblcourses` (`course_name`,`course_fees`,`course_intake`,`course_type`,`course_desc`,`course_status`,`added_by_admin`,`modified_by_admin`) 
					VALUES (:course_name,:course_fees,:course_intake,:course_type,:course_desc,:course_status,:added_by_admin,:modified_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':course_name' => addslashes($tdata['course_name']),
				':course_fees' => addslashes($tdata['course_fees']),
				':course_intake' => addslashes($tdata['course_intake']),
				':course_type' => addslashes($tdata['course_type']),
				':course_desc' => addslashes($tdata['course_desc']),
				':course_status' => addslashes($tdata['course_status']),
				':added_by_admin' => addslashes($tdata['added_by_admin']),
				':modified_by_admin' => addslashes($tdata['added_by_admin'])
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addCourse] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getCourseDetails($course_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblcourses` WHERE `course_id` = '".$course_id."' AND `course_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function getCourseName($course_id)
    {
        $DBH = new DatabaseHandler();
        $course_name = '';
        
        $sql = "SELECT course_name FROM `tblcourses` WHERE `course_id` = '".$course_id."' AND `course_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $course_name = $r['course_name'];
        }	

        return $course_name;
    }
	
	public function updateCourse($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblcourses` SET 
					`course_name` = :course_name,
					`course_fees` = :course_fees,
					`course_intake` = :course_intake,
					`course_type` = :course_type,
					`course_desc` = :course_desc,  
					`course_status` = :course_status,  
					`modified_by_admin` = :modified_by_admin  
					WHERE `course_id` = :course_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':course_name' => addslashes($tdata['course_name']),
				':course_fees' => addslashes($tdata['course_fees']),
				':course_intake' => addslashes($tdata['course_intake']),
				':course_type' => addslashes($tdata['course_type']),
				':course_desc' => addslashes($tdata['course_desc']),
				':course_status' => addslashes($tdata['course_status']),
				':modified_by_admin' => $tdata['modified_by_admin'],
				':course_id' => $tdata['course_id']
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateCourse] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function deleteCourse($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblcourses` SET 
					`course_deleted` = :course_deleted,
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `course_id` = :course_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':course_deleted' => '1',
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':course_id' => $tdata['course_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteCourse] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getCourseTypeOption($course_type_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$sql = "SELECT * FROM `tblcoursetype` WHERE `course_type_status` = '1' AND `course_type_deleted` = '0' ";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				if($r['course_type_id'] == $course_type_id )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="'.$r['course_type_id'].'" '.$selected.'>'.$r['course_type'].'</option>';
			}
		}	
		return $output;
	}
	
	public function getAllBatches()
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql = "SELECT TBT.*,TBC.course_name FROM `tblbatches` AS TBT LEFT JOIN `tblcourses` AS TBC ON TBT.course_id = TBC.course_id WHERE TBT.batch_deleted = '0' ORDER BY TBT.batch_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function getCourseOption($course_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$sql = "SELECT * FROM `tblcourses` WHERE `course_deleted` = '0' ";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				if($r['course_id'] == $course_id )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="'.$r['course_id'].'" '.$selected.'>'.$r['course_name'].'</option>';
			}
		}	
		return $output;
	}
	
	public function getSeatAvailabilityOption($seat_availability)
	{
		$output = '';
		
		for($i=1;$i<=200;$i++)
		{
			if($i == $seat_availability )
			{
				$selected = ' selected ';	
			}
			else
			{
				$selected = '';	
			}
			$output .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
		}
			
		return $output;
	}
	
	public function addBatch($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblbatches` (`batch_name`,`course_id`,`start_date`,`end_date`,`register_start_date`,`register_end_date`,`seat_availability`,`batch_status`,`added_by_admin`,`modified_by_admin`,`batch_duration`,`state_id`,`city_id`) 
					VALUES (:batch_name,:course_id,:start_date,:end_date,:register_start_date,:register_end_date,:seat_availability,:batch_status,:added_by_admin,:modified_by_admin,:batch_duration,:state_id,:city_id)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':batch_name' => addslashes($tdata['batch_name']),
				':course_id' => addslashes($tdata['course_id']),
				':start_date' => addslashes($tdata['start_date']),
				':end_date' => addslashes($tdata['end_date']),
				':register_start_date' => addslashes($tdata['register_start_date']),
				':register_end_date' => addslashes($tdata['register_end_date']),
				':seat_availability' => addslashes($tdata['seat_availability']),
				':batch_status' => addslashes($tdata['batch_status']),
				':added_by_admin' => addslashes($tdata['added_by_admin']),
				':modified_by_admin' => addslashes($tdata['added_by_admin']),
				':batch_duration' => addslashes($tdata['batch_duration']),
				':state_id' => addslashes($tdata['state_id']),
				':city_id' => addslashes($tdata['city_id'])
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addBatch] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function deleteBatch($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblbatches` SET 
					`batch_deleted` = :batch_deleted,
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `batch_id` = :batch_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':batch_deleted' => '1',
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':batch_id' => $tdata['batch_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteBatch] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getBatchDetails($batch_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblbatches` WHERE `batch_id` = '".$batch_id."' AND `batch_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function getBatchName($batch_id)
    {
        $DBH = new DatabaseHandler();
        $batch_name = '';
        
        $sql = "SELECT batch_name FROM `tblbatches` WHERE `batch_id` = '".$batch_id."' AND `batch_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $batch_name = $r['batch_name'];
        }	

        return $batch_name;
    }
	
	public function updateBatch($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblbatches` SET 
					`batch_name` = :batch_name,
					`course_id` = :course_id,
					`start_date` = :start_date,
					`end_date` = :end_date,
					`register_end_date` = :register_end_date,
					`seat_availability` = :seat_availability,  
					`batch_duration` = :batch_duration,  
					`state_id` = :state_id,  
					`city_id` = :city_id,  
					`batch_status` = :batch_status,  
					`modified_by_admin` = :modified_by_admin  
					WHERE `batch_id` = :batch_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':batch_name' => addslashes($tdata['batch_name']),
				':course_id' => addslashes($tdata['course_id']),
				':start_date' => addslashes($tdata['start_date']),
				':end_date' => addslashes($tdata['end_date']),
				':register_end_date' => addslashes($tdata['register_end_date']),
				':seat_availability' => addslashes($tdata['seat_availability']),
				':batch_duration' => addslashes($tdata['batch_duration']),
				':state_id' => addslashes($tdata['state_id']),
				':city_id' => addslashes($tdata['city_id']),
				':batch_status' => addslashes($tdata['batch_status']),
				':modified_by_admin' => $tdata['modified_by_admin'],
				':batch_id' => $tdata['batch_id']
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateBatch] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getAllUsers()
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql = "SELECT TBU.*,TBS.state,TBC.city,TBR.rank_name FROM `tblusers` AS TBU 
				LEFT JOIN `tblstates` AS TBS ON TBU.state_id = TBS.state_id 
				LEFT JOIN `tblcities` AS TBC ON TBU.city_id = TBC.city_id
				LEFT JOIN `tblranks` AS TBR ON TBU.rank_id = TBR.rank_id 
				WHERE TBU.user_deleted = '0' ORDER BY TBU.user_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function getRankOption($rank_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$sql = "SELECT * FROM `tblranks` WHERE `rank_status` = '1' AND `rank_deleted` = '0' ORDER BY `rank_name` ASC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				if($r['rank_id'] == $rank_id )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="'.$r['rank_id'].'" '.$selected.'>'.$r['rank_name'].'</option>';
			}
		}	
		return $output;
	}
	
	public function chkEmailExists($email)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `user_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkEmailExists_edit($email,$user_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `user_id` != '".$user_id."' AND `user_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addUser($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblusers` (`first_name`,`last_name`,`email`,`password`,`mobile_no`,`address`,`state_id`,`city_id`,`dob`,`rank_id`,`indos_no`,`passport_no`,`user_status`,`added_by_admin`,`modified_by_admin`) 
					VALUES (:first_name,:last_name,:email,:password,:mobile_no,:address,:state_id,:city_id,:dob,:rank_id,:indos_no,:passport_no,:user_status,:added_by_admin,:modified_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':first_name' => addslashes($tdata['first_name']),
				':last_name' => addslashes($tdata['last_name']),
				':email' => addslashes($tdata['email']),
				':password' => md5($tdata['password']),
				':mobile_no' => addslashes($tdata['mobile_no']),
				':address' => addslashes($tdata['address']),
				':state_id' => addslashes($tdata['state_id']),
				':city_id' => addslashes($tdata['city_id']),
				':dob' => addslashes($tdata['dob']),
				':rank_id' => addslashes($tdata['rank_id']),
				':indos_no' => addslashes($tdata['indos_no']),
				':passport_no' => addslashes($tdata['passport_no']),
				':user_status' => addslashes($tdata['user_status']),
				':added_by_admin' => addslashes($tdata['added_by_admin']),
				':modified_by_admin' => addslashes($tdata['added_by_admin'])
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addUser] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getUserDetails($user_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' AND `user_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function getUserFullName($user_id)
    {
        $DBH = new DatabaseHandler();
        $name = '';
        
        $sql = "SELECT first_name,last_name FROM `tblusers` WHERE `user_id` = '".$user_id."' AND `user_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $name = $r['first_name'].' '.$r['last_name'];
        }	

        return $name;
    }
	
	public function updateUser($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblusers` SET 
					`first_name` = :first_name,
					`last_name` = :last_name,
					`email` = :email,
					`mobile_no` = :mobile_no,
					`address` = :address,  
					`state_id` = :state_id,  
					`city_id` = :city_id,  
					`dob` = :dob,  
					`rank_id` = :rank_id,  
					`indos_no` = :indos_no,  
					`passport_no` = :passport_no,  
					`user_status` = :user_status,  
					`modified_by_admin` = :modified_by_admin  
					WHERE `user_id` = :user_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':first_name' => addslashes($tdata['first_name']),
				':last_name' => addslashes($tdata['last_name']),
				':email' => addslashes($tdata['email']),
				':mobile_no' => addslashes($tdata['mobile_no']),
				':address' => addslashes($tdata['address']),
				':state_id' => addslashes($tdata['state_id']),
				':city_id' => addslashes($tdata['city_id']),
				':dob' => addslashes($tdata['dob']),
				':rank_id' => addslashes($tdata['rank_id']),
				':indos_no' => addslashes($tdata['indos_no']),
				':passport_no' => addslashes($tdata['passport_no']),
				':user_status' => addslashes($tdata['user_status']),
				':modified_by_admin' => $tdata['modified_by_admin'],
				':user_id' => $tdata['user_id']
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateUser] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function deleteUser($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblusers` SET 
					`user_deleted` = :user_deleted,
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `user_id` = :user_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':user_deleted' => '1',
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':user_id' => $tdata['user_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteUser] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getAPIUserName($api_user_id)
    {
        $DBH = new DatabaseHandler();
        $return = '';
        
        $sql = "SELECT api_user_username FROM `tblapiusers` WHERE `api_user_id` = '".$api_user_id."' AND `api_user_deleted` = '0' ";
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $return = $r['api_user_username'];
        }

        return $return;
    }
	
	public function getAgentUserName($agent_id)
    {
        $DBH = new DatabaseHandler();
        $return = '';
        
        $sql = "SELECT agent_username FROM `tblagents` WHERE `agent_id` = '".$agent_id."' AND `agent_deleted` = '0' ";
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $return = $r['agent_username'];
        }

        return $return;
    }
	
	public function getAllBookingsList($booking_type='',$agent_id='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		//echo'<br>booking_type:'.$booking_type.'<br>';
		$sql_str_booking_by = "";
		if($booking_type == '')
		{
			$sql_str_booking_type = "";
			
		}
		else
		{
			$sql_str_booking_type = " AND TBBK.booking_type = '".$booking_type."' ";
			if($booking_type == '2' && $agent_id != '')
			{
				$sql_str_booking_by = " AND TBBK.added_by_agent = '".$agent_id."' ";
			}
			elseif($booking_type == '3' && $agent_id != '')
			{
				$sql_str_booking_by = " AND TBBK.added_by_api = '".$agent_id."' ";
			}
			
		}
		
		$sql = "SELECT TBBK.*,TBU.first_name,TBU.last_name,TBC.course_name,TBB.batch_name FROM `tblbookings` AS TBBK 
				LEFT JOIN `tblusers` AS TBU ON TBBK.user_id = TBU.user_id 
				LEFT JOIN `tblcourses` AS TBC ON TBBK.course_id = TBC.course_id
				LEFT JOIN `tblbatches` AS TBB ON TBBK.batch_id = TBB.batch_id 
				WHERE 1 ".$sql_str_booking_type." ".$sql_str_booking_by." ORDER BY TBBK.booking_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$obj_admin = new Admin();
				if($r['booking_type'] == '3' )
				{
					$r['booking_done_by'] = $obj_admin->getAPIUserName($r['added_by_api']);	
				}
				elseif($r['booking_type'] == '2' )
				{
					$r['booking_done_by'] = $obj_admin->getAgentUserName($r['added_by_agent']);	
				}
				elseif($r['booking_type'] == '1' )
				{
					$r['booking_done_by'] = 'Self';	
				}
				else
				{
					$r['booking_done_by'] = $obj_admin->getAdminUsername($r['added_by_admin']);	
				}
				
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function getUserOption($user_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$sql = "SELECT * FROM `tblusers` WHERE `user_deleted` = '0' ORDER BY first_name ASC, last_name ASC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				if($r['user_id'] == $user_id )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="'.$r['user_id'].'" '.$selected.'>'.$r['first_name'].' '.$r['last_name'].'('.$r['mobile_no'] .')'.'</option>';
			}
		}	
		return $output;
	}
	
	public function getActiveBatchOption($course_id,$batch_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$sql = "SELECT * FROM `tblbatches` WHERE `course_id` = '".$course_id."' AND NOW() <= `end_date` AND `batch_deleted` = '0' AND `batch_status` = '1' AND `seat_availability` > 0 ORDER BY batch_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$obj_admin = new Admin();
				if($obj_admin->chkIfSeatAvilableInBatch($r['batch_id']))
				{
					if($r['batch_id'] == $batch_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['batch_id'].'" '.$selected.'>'.$r['batch_name'].'</option>';
				}
			}
		}	
		return $output;
	}
	
	public function getBookingModeOption($booking_mode)
	{
		$output = '';
		$arr_booking_mode = array('0' => 'By Cash' , '1' => 'By Cheque', '2' => 'Online Payment');
		
		foreach($arr_booking_mode as $key => $val )
		{
			if($key == $booking_mode )
			{
				$selected = ' selected ';	
			}
			else
			{
				$selected = '';	
			}
			$output .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
		}
			
		return $output;
	}
	
	public function getCourseFees($course_id)
    {
        $DBH = new DatabaseHandler();
        $course_fees = '';
        
        $sql = "SELECT * FROM `tblcourses` WHERE `course_id` = '".$course_id."' AND `course_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $course_fees = $r['course_fees'];
        }	

        return $course_fees;
    }
	
	public function chkIfStudentAlreadyBooked($user_id,$course_id,$batch_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblbookings` WHERE `user_id` = '".$user_id."' AND `course_id` = '".$course_id."' AND `batch_id` = '".$batch_id."' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function getBookingDetails($booking_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblbookings` WHERE `booking_id` = '".$booking_id."' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function getAllPages()
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql = "SELECT * FROM `tblpages` WHERE `page_deleted` = '0' AND `show_in_admin` = '1' ORDER BY page_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function addPage($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblpages` (`page_name`,`page_title`,`page_contents`,`meta_title`,`meta_desc`,`meta_keywords`,`show_in_manage_menu`,`show_in_admin`,`page_status`,`added_by_admin`,`modified_by_admin`) 
					VALUES (:page_name,:page_title,:page_contents,:meta_title,:meta_desc,:meta_keywords,:show_in_manage_menu,:show_in_admin,:page_status,:added_by_admin,:modified_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':page_name' => addslashes($tdata['page_name']),
				':page_title' => addslashes($tdata['page_title']),
				':page_contents' => addslashes($tdata['page_contents']),
				':meta_title' => addslashes($tdata['meta_title']),
				':meta_desc' => addslashes($tdata['meta_desc']),
				':meta_keywords' => addslashes($tdata['meta_keywords']),
				':show_in_manage_menu' => addslashes($tdata['show_in_manage_menu']),
				':show_in_admin' => addslashes($tdata['show_in_admin']),
				':page_status' => addslashes($tdata['page_status']),
				':added_by_admin' => addslashes($tdata['added_by_admin']),
				':modified_by_admin' => addslashes($tdata['added_by_admin'])
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addPage] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getPageDetails($page_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."' AND `page_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function updatePage($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblpages` SET 
					`page_name` = :page_name,
					`page_title` = :page_title,
					`page_contents` = :page_contents,
					`meta_title` = :meta_title,
					`meta_desc` = :meta_desc,
					`meta_keywords` = :meta_keywords,  
					`page_status` = :page_status,  
					`modified_by_admin` = :modified_by_admin  
					WHERE `page_id` = :page_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':page_name' => addslashes($tdata['page_name']),
				':page_title' => addslashes($tdata['page_title']),
				':page_contents' => addslashes($tdata['page_contents']),
				':meta_title' => addslashes($tdata['meta_title']),
				':meta_desc' => addslashes($tdata['meta_desc']),
				':meta_keywords' => addslashes($tdata['meta_keywords']),
				':page_status' => addslashes($tdata['page_status']),
				':modified_by_admin' => $tdata['modified_by_admin'],
				':page_id' => $tdata['page_id']
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updatePage] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function deletePage($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblpages` SET 
					`page_deleted` = :page_deleted,
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `page_id` = :page_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':page_deleted' => '1',
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':page_id' => $tdata['page_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deletePage] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getAllRanks()
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql = "SELECT * FROM `tblranks` WHERE `rank_deleted` = '0' ORDER BY rank_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function deleteRank($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblranks` SET 
					`rank_deleted` = :rank_deleted,
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `rank_id` = :rank_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':rank_deleted' => '1',
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':rank_id' => $tdata['rank_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteRank] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function chkRankNameExists($rank_name)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblranks` WHERE `rank_name` = '".addslashes($rank_name)."' AND `rank_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkRankNameExists_edit($rank_name,$rank_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblranks` WHERE `rank_name` = '".addslashes($rank_name)."' AND `rank_id` != '".$rank_id."' AND `rank_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addRank($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblranks` (`rank_name`,`rank_status`,`added_by_admin`,`modified_by_admin`) 
					VALUES (:rank_name,:rank_status,:added_by_admin,:modified_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':rank_name' => addslashes($tdata['rank_name']),
				':rank_status' => addslashes($tdata['rank_status']),
				':added_by_admin' => addslashes($tdata['added_by_admin']),
				':modified_by_admin' => addslashes($tdata['added_by_admin'])
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addRank] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getRankDetails($rank_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblranks` WHERE `rank_id` = '".$rank_id."' AND `rank_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function updateRank($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblranks` SET 
					`rank_name` = :rank_name,
					`rank_status` = :rank_status,  
					`modified_by_admin` = :modified_by_admin  
					WHERE `rank_id` = :rank_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':rank_name' => addslashes($tdata['rank_name']),
				':rank_status' => addslashes($tdata['rank_status']),
				':modified_by_admin' => $tdata['modified_by_admin'],
				':rank_id' => $tdata['rank_id']
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateRank] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getAllFrontMenuTypes()
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql = "SELECT * FROM `tblfrontmenutype` WHERE `fmt_deleted` = '0' ORDER BY fmt_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function getFrontMenuTypeDetails($fmt_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblfrontmenutype` WHERE `fmt_id` = '".$fmt_id."' AND `fmt_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function getAllFrontMenuItemsParentWise($fmt_id,$fm_parent_id)
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql = "SELECT * FROM `tblfrontmenu` WHERE `fmt_id` = '".$fmt_id."' AND `fm_parent_id` = '".$fm_parent_id."' AND `fm_deleted` = '0' ORDER BY fm_order ASC, fm_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function getFrontMenuParentId($fmt_id,$fm_id)
	{
		$DBH = new DatabaseHandler();
		$fm_parent_id = 0;
		
		$sql = "SELECT fm_parent_id FROM `tblfrontmenu` WHERE `fmt_id` = '".$fmt_id."' AND `fm_id` = '".$fm_id."' AND `fm_deleted` = '0' ORDER BY fm_order ASC, fm_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			$r= $STH->fetch(PDO::FETCH_ASSOC);
			$fm_parent_id = $r['fm_parent_id'] ;
		}	
		return $fm_parent_id;
	}
	
	public function getAllFrontMenuItemsOptionsParentWise($fmt_id,$fm_parent_id,$fm_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$sql = "SELECT * FROM `tblfrontmenu` WHERE `fmt_id` = '".$fmt_id."' AND `fm_parent_id` = '".$fm_parent_id."' AND `fm_deleted` = '0' ORDER BY fm_order ASC, fm_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				if($r['fm_id'] == $fm_id )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="'.$r['fm_id'].'" '.$selected.'>'.$r['fm_menu_title'].'</option>';
			}
		}	
		return $output;
	}
	
	public function getPageOption($page_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$sql = "SELECT * FROM `tblpages` WHERE `page_deleted` = '0' AND `show_in_manage_menu` = '1' AND `show_in_admin` = '1' ORDER BY page_name ASC ";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				if($r['page_id'] == $page_id )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="'.$r['page_id'].'" '.$selected.'>'.$r['page_name'].'</option>';
			}
		}	
		return $output;
	}
	
	public function addFrontMenuItem($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblfrontmenu` (`fmt_id`,`fm_parent_id`,`page_id`,`fm_menu_title`,`fm_order`,`fm_status`,`added_by_admin`,`modified_by_admin`) 
					VALUES (:fmt_id,:fm_parent_id,:page_id,:fm_menu_title,:fm_order,:fm_status,:added_by_admin,:modified_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':fmt_id' => addslashes($tdata['fmt_id']),
				':fm_parent_id' => addslashes($tdata['fm_parent_id']),
				':page_id' => addslashes($tdata['page_id']),
				':fm_menu_title' => addslashes($tdata['fm_menu_title']),
				':fm_order' => addslashes($tdata['fm_order']),
				':fm_status' => addslashes($tdata['fm_status']),
				':added_by_admin' => addslashes($tdata['added_by_admin']),
				':modified_by_admin' => addslashes($tdata['added_by_admin'])
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addFrontMenuItem] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function deleteFrontMenuItem($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblfrontmenu` SET 
					`fm_deleted` = :fm_deleted,
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `fm_id` = :fm_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':fm_deleted' => '1',
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':fm_id' => $tdata['fm_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteFrontMenuItem] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function chkIfMenuHasChildMenuItems($fm_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblfrontmenu` WHERE `fm_parent_id` = '".$fm_id."' AND `fm_deleted` = '0' ORDER BY fm_order ASC, fm_add_date DESC";	
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function getFrontMenuName($fm_id)
	{
		$DBH = new DatabaseHandler();
		$fm_menu_title = '';
		
		$sql = "SELECT fm_menu_title FROM `tblfrontmenu` WHERE `fm_id` = '".$fm_id."' AND `fm_deleted` = '0' ORDER BY fm_order ASC, fm_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			$r= $STH->fetch(PDO::FETCH_ASSOC);
			$fm_menu_title = $r['fm_menu_title'] ;
		}	
		return $fm_menu_title;
	}
	
	public function getFrontMenuItemDetails($fm_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblfrontmenu` WHERE `fm_id` = '".$fm_id."' AND `fm_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function updateFrontMenuItem($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblfrontmenu` SET 
					`fmt_id` = :fmt_id,
					`fm_parent_id` = :fm_parent_id,
					`page_id` = :page_id,
					`fm_menu_title` = :fm_menu_title,
					`fm_order` = :fm_order,
					`fm_status` = :fm_status,  
					`modified_by_admin` = :modified_by_admin  
					WHERE `fm_id` = :fm_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':fmt_id' => addslashes($tdata['fmt_id']),
				':fm_parent_id' => addslashes($tdata['fm_parent_id']),
				':page_id' => addslashes($tdata['page_id']),
				':fm_menu_title' => addslashes($tdata['fm_menu_title']),
				':fm_order' => addslashes($tdata['fm_order']),
				':fm_status' => addslashes($tdata['fm_status']),
				':modified_by_admin' => $tdata['modified_by_admin'],
				':fm_id' => $tdata['fm_id']
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateFrontMenuItem] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function chkIfFrontMenuItemAlreadyExists($fmt_id,$fm_parent_id,$page_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblfrontmenu` WHERE `fmt_id` = '".$fmt_id."' AND `page_id` = '".$page_id."' AND `fm_parent_id` = '".$fm_parent_id."' AND `fm_deleted` = '0' ORDER BY fm_order ASC, fm_add_date DESC";	
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	public function chkIfFrontMenuItemAlreadyExists_edit($fmt_id,$fm_parent_id,$page_id,$fm_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblfrontmenu` WHERE `fmt_id` = '".$fmt_id."' AND `page_id` = '".$page_id."' AND `fm_parent_id` = '".$fm_parent_id."' AND `fm_id` != '".$fm_id."' AND `fm_deleted` = '0' ORDER BY fm_order ASC, fm_add_date DESC";	
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function updateInstituteDetails($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblinstitutedetails` SET 
					`institute_name` = :institute_name,
					`institute_email` = :institute_email,
					`institute_contact_no` = :institute_contact_no,
					`institute_address` = :institute_address,  
					`state_id` = :state_id,  
					`city_id` = :city_id,  
					`modified_by_admin` = :modified_by_admin  
					WHERE `institute_id` = :institute_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':institute_name' => addslashes($tdata['institute_name']),
				':institute_email' => addslashes($tdata['institute_email']),
				':institute_contact_no' => addslashes($tdata['institute_contact_no']),
				':institute_address' => addslashes($tdata['institute_address']),
				':state_id' => addslashes($tdata['state_id']),
				':city_id' => addslashes($tdata['city_id']),
				':modified_by_admin' => $tdata['modified_by_admin'],
				':institute_id' => $tdata['institute_id']
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateInstituteDetails] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getAllAgents()
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql = "SELECT * FROM `tblagents` WHERE `agent_deleted` = '0' ORDER BY agent_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function deleteAgent($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblagents` SET 
					`agent_deleted` = :agent_deleted,
					`agent_modified_date` = :agent_modified_date, 
					`deleted_by_admin` = :deleted_by_admin
					WHERE `agent_id` = :agent_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':agent_deleted' => '1',
				':agent_modified_date' => date('Y-m-d H:i:s'),
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':agent_id' => $tdata['agent_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteAgent] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function chkAgentUsernameExists($agent_username)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblagents` WHERE `agent_username` = '".$agent_username."' AND `agent_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkAgentUsernameExists_edit($agent_username,$agent_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblagents` WHERE `agent_username` = '".$agent_username."' AND `agent_id` != '".$agent_id."' AND `agent_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkAgentEmailExists($agent_email)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblagents` WHERE `agent_email` = '".$agent_email."' AND `agent_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkAgentEmailExists_edit($agent_email,$agent_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblagents` WHERE `agent_email` = '".$agent_email."' AND `agent_id` != '".$agent_id."' AND `agent_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addAgentUser($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblagents` (`agent_username`,`agent_password`,`agent_name`,`agent_email`,`agent_mobile`,`agent_status`,`agent_modified_date`,`added_by_admin`) 
					VALUES (:agent_username,:agent_password,:agent_name,:agent_email,:agent_mobile,:agent_status,:agent_modified_date,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':agent_username' => addslashes($tdata['agent_username']),
				':agent_password' => md5($tdata['agent_password']),
				':agent_name' => addslashes($tdata['agent_name']),
				':agent_email' => addslashes($tdata['agent_email']),
				':agent_mobile' => addslashes($tdata['agent_mobile']),
				':agent_status' => '1',
				':agent_modified_date' => date('Y-m-d H:i:s'),
				':added_by_admin' => addslashes($tdata['added_by_admin'])
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addAgentUser] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getAgentUserDetails($agent_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblagents` WHERE `agent_id` = '".$agent_id."' AND `agent_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function updateAgentUser($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblagents` SET 
					`agent_username` = :agent_username,
					`agent_email` = :agent_email,
					`agent_name` = :agent_name,
					`agent_mobile` = :agent_mobile,
					`agent_status` = :agent_status,
					`agent_modified_date` = :agent_modified_date,  
					`modified_by_admin` = :modified_by_admin  	
					WHERE `agent_id` = :agent_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':agent_username' => addslashes($tdata['agent_username']),
				':agent_email' => addslashes($tdata['agent_email']),
				':agent_name' => addslashes($tdata['agent_name']),
				':agent_mobile' => addslashes($tdata['agent_mobile']),
				':agent_status' => addslashes($tdata['agent_status']),
				':agent_modified_date' => date('Y-m-d H:i:s'),
				':modified_by_admin' => addslashes($tdata['modified_by_admin']),
				':agent_id' => $tdata['agent_id']
            ));
			$DBH->commit();
			$return = true;
			
        } catch (Exception $e) {
			$stringData = '[updateAgentUser] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function updateAgentProfile($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblagents` SET 
					`agent_username` = :agent_username,
					`agent_email` = :agent_email,
					`agent_name` = :agent_name,
					`agent_mobile` = :agent_mobile,
					`agent_modified_date` = :agent_modified_date  
					WHERE `agent_id` = :agent_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':agent_username' => addslashes($tdata['agent_username']),
				':agent_email' => addslashes($tdata['agent_email']),
				':agent_name' => addslashes($tdata['agent_name']),
				':agent_mobile' => addslashes($tdata['agent_mobile']),
				':agent_modified_date' => date('Y-m-d H:i:s'),
				':agent_id' => $tdata['agent_id']
            ));
			$DBH->commit();
			$return = true;
			
        } catch (Exception $e) {
			$stringData = '[updateAgentProfile] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function chkValidAgent($agent_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;
		
		$sql = "SELECT * FROM `tblagents` WHERE `agent_id` = '".$agent_id."' AND `agent_status` = '1' AND `agent_deleted` = '0' ";
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;	
        }
        return $return;
    }
	
	public function isAgentLoggedIn()
    {
        $return = false;
        if( isset($_SESSION['adm_agent_id']) && ($_SESSION['adm_agent_id'] > 0) && ($_SESSION['adm_agent_id'] != '') )
        {
            $agent_id = $_SESSION['adm_agent_id'];
            if($this->chkValidAgent($agent_id))
            {
                $return = true;	
            }	
        }
        return $return;
    }
	
	public function chkValidAgentLogin($agent_username,$agent_password)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblagents` WHERE `agent_username` = '".$agent_username."' AND `agent_password` = '".md5($agent_password)."' AND `agent_status` = '1' AND `agent_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;	
        }
        return $return;
    }
	
	public function getAgentId($agent_username)
    {
        $DBH = new DatabaseHandler();
        $agent_id = 0;

        $sql = "SELECT * FROM `tblagents` WHERE `agent_username` = '".$agent_username."' AND `agent_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $agent_id = $r['agent_id'];
        }
        return $agent_id;
    }
	
	public function getAgentName($agent_username)
    {
        $DBH = new DatabaseHandler();
        $agent_name = '';

        $sql = "SELECT * FROM `tblagents` WHERE `agent_username` = '".$agent_username."' AND `agent_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $agent_name = $r['agent_name'];
        }
        return $agent_name;
    }
	
	public function getAgentEmail($agent_username)
    {
        $DBH = new DatabaseHandler();
        $agent_email = '';

        $sql = "SELECT * FROM `tblagents` WHERE `agent_username` = '".$agent_username."' AND `agent_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $agent_email = $r['agent_email'];
        }
        return $agent_email;
    }
	
	public function doAgentLogin($agent_username)
    {
        global $link;
        $return = false;

        $agent_id = $this->getAgentId($agent_username);
        $agent_name = $this->getAgentName($agent_username);
        $agent_email = $this->getAgentEmail($agent_username);
        
        if($agent_id > 0)
        {
            $return = true;	
            $_SESSION['adm_agent_id'] = $agent_id;
            $_SESSION['adm_agent_username'] = $agent_username; 
            $_SESSION['adm_agent_name'] = $agent_name;
            $_SESSION['adm_agent_email'] = $agent_email;
		}	
        return $return;
    }
	
    public function doAgentLogout()
    {
        global $link;
        $return = true;	

        $_SESSION['adm_agent_id'] = '';
        $_SESSION['adm_agent_username'] = '';
        $_SESSION['adm_agent_name'] = '';
        $_SESSION['adm_agent_email'] = '';
        unset($_SESSION['adm_agent_id']);
        unset($_SESSION['adm_agent_username']);
        unset($_SESSION['adm_agent_name']);
        unset($_SESSION['adm_agent_email']);
        session_destroy();
        session_start();
        session_regenerate_id();
        $new_sessionid = session_id();

        return $return;
    }
	
	public function getAllNews()
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql = "SELECT * FROM `tblnews` WHERE `news_deleted` = '0' ORDER BY news_order ASC, news_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function deleteNews($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblnews` SET 
					`news_deleted` = :news_deleted,
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `news_id` = :news_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':news_deleted' => '1',
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':news_id' => $tdata['news_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteNews] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function addNews($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblnews` (`news`,`news_order`,`news_status`,`added_by_admin`) 
					VALUES (:news,:news_order,:news_status,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':news' => addslashes($tdata['news']),
				':news_order' => addslashes($tdata['news_order']),
				':news_status' => addslashes($tdata['news_status']),
				':added_by_admin' => addslashes($tdata['added_by_admin'])
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addNews] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getNewsDetails($news_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblnews` WHERE `news_id` = '".$news_id."' AND `news_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function updateNews($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblnews` SET 
					`news` = :news,
					`news_order` = :news_order,
					`news_status` = :news_status,  
					`news_modified_date` = :news_modified_date,  
					`modified_by_admin` = :modified_by_admin  
					WHERE `news_id` = :news_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':news' => addslashes($tdata['news']),
				':news_order' => addslashes($tdata['news_order']),
				':news_status' => addslashes($tdata['news_status']),
				':news_modified_date' => date('Y-m-d H:i:s'),
				':modified_by_admin' => $tdata['modified_by_admin'],
				':news_id' => $tdata['news_id']
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateNews] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getAllAPIUsers()
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql = "SELECT * FROM `tblapiusers` WHERE `api_user_deleted` = '0' ORDER BY api_user_add_date DESC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function deleteAPIUser($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblapiusers` SET 
					`api_user_deleted` = :api_user_deleted,
					`api_user_modified_date` = :api_user_modified_date, 
					`deleted_by_admin` = :deleted_by_admin
					WHERE `api_user_id` = :api_user_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':api_user_deleted' => '1',
				':api_user_modified_date' => date('Y-m-d H:i:s'),
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':api_user_id' => $tdata['api_user_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteAPIUser] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function chkAPIUsernameExists($api_user_username)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblapiusers` WHERE `api_user_username` = '".$api_user_username."' AND `api_user_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkAPIUsernameExists_edit($api_user_username,$api_user_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblapiusers` WHERE `api_user_username` = '".$api_user_username."' AND `api_user_id` != '".$api_user_id."' AND `api_user_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkAPIEmailExists($api_user_email)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblapiusers` WHERE `api_user_email` = '".$api_user_email."' AND `api_user_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkAPIEmailExists_edit($api_user_email,$api_user_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblapiusers` WHERE `api_user_email` = '".$api_user_email."' AND `api_user_id` != '".$api_user_id."' AND `api_user_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkAPIKeyExists($api_user_key)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblapiusers` WHERE `api_user_key` = '".$api_user_key."' AND `api_user_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkAPIKeyExists_edit($api_user_key,$api_user_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblapiusers` WHERE `api_user_key` = '".$api_user_key."' AND `api_user_id` != '".$api_user_id."' AND `api_user_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addAPIUser($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblapiusers` (`api_user_username`,`api_user_password`,`api_user_name`,`api_user_email`,`api_user_contact_no`,`api_user_key`,`api_user_status`,`api_user_modified_date`,`added_by_admin`) 
					VALUES (:api_user_username,:api_user_password,:api_user_name,:api_user_email,:api_user_contact_no,:api_user_key,:api_user_status,:api_user_modified_date,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':api_user_username' => addslashes($tdata['api_user_username']),
				':api_user_password' => md5($tdata['api_user_password']),
				':api_user_name' => addslashes($tdata['api_user_name']),
				':api_user_email' => addslashes($tdata['api_user_email']),
				':api_user_contact_no' => addslashes($tdata['api_user_contact_no']),
				':api_user_key' => addslashes($tdata['api_user_key']),
				':api_user_status' => '1',
				':api_user_modified_date' => date('Y-m-d H:i:s'),
				':added_by_admin' => addslashes($tdata['added_by_admin'])
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addAPIUser] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getAPIUserDetails($api_user_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblapiusers` WHERE `api_user_id` = '".$api_user_id."' AND `api_user_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function updateAPIUser($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblapiusers` SET 
					`api_user_username` = :api_user_username,
					`api_user_email` = :api_user_email,
					`api_user_name` = :api_user_name,
					`api_user_contact_no` = :api_user_contact_no,
					`api_user_key` = :api_user_key,
					`api_user_status` = :api_user_status,
					`api_user_modified_date` = :api_user_modified_date,  
					`modified_by_admin` = :modified_by_admin  	
					WHERE `api_user_id` = :api_user_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':api_user_username' => addslashes($tdata['api_user_username']),
				':api_user_email' => addslashes($tdata['api_user_email']),
				':api_user_name' => addslashes($tdata['api_user_name']),
				':api_user_contact_no' => addslashes($tdata['api_user_contact_no']),
				':api_user_key' => addslashes($tdata['api_user_key']),
				':api_user_status' => addslashes($tdata['api_user_status']),
				':api_user_modified_date' => date('Y-m-d H:i:s'),
				':modified_by_admin' => addslashes($tdata['modified_by_admin']),
				':api_user_id' => $tdata['api_user_id']
            ));
			$DBH->commit();
			$return = true;
			
        } catch (Exception $e) {
			$stringData = '[updateAPIUser] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function chkIfSeatAvilableInBatch($batch_id)
	{
		$DBH = new DatabaseHandler();
		$return = false;
				
		$sql = "SELECT seat_availability FROM `tblbatches` WHERE batch_id = '".$batch_id."' AND batch_deleted = '0' AND batch_status = '1' AND NOW() < start_date AND seat_availability > 0 ";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			$r = $STH->fetch(PDO::FETCH_ASSOC);
            $seat_availability = $r['seat_availability'];
			
			$count_hold_seat = 0;
			$sql2 = "SELECT count(*) AS count_hold_seat FROM `tblbookinghold` WHERE batch_id = '".$batch_id."' AND NOW() < booking_hold_end_date AND booking_completed = '0' ";	
			$STH2 = $DBH->query($sql2);
			if( $STH2->rowCount() > 0 )
			{
				$r = $STH2->fetch(PDO::FETCH_ASSOC);
				$count_hold_seat = $r['count_hold_seat'];
			}
			
			$total_remain_seat = $seat_availability - $count_hold_seat;
			if($total_remain_seat > 0)
			{
				$return = true;
			}
		}
			
		return $return;
	}
	
	public function chkValidAPIAdmin($api_user_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;
		
		$sql = "SELECT * FROM `tblapiusers` WHERE `api_user_id` = '".$api_user_id."' AND `api_user_status` = '1' AND `api_user_deleted` = '0' ";
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;	
        }
        return $return;
    }
	
	public function isAPIAdminLoggedIn()
    {
        $return = false;
        if( isset($_SESSION['adm_api_id']) && ($_SESSION['adm_api_id'] > 0) && ($_SESSION['adm_api_id'] != '') )
        {
            $api_user_id = $_SESSION['adm_api_id'];
            if($this->chkValidAPIAdmin($api_user_id))
            {
                $return = true;	
            }	
        }
        return $return;
    }
	
	public function chkValidAPIAdminLogin($api_user_username,$api_user_password)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblapiusers` WHERE `api_user_username` = '".$api_user_username."' AND `api_user_password` = '".md5($api_user_password)."' AND `api_user_status` = '1' AND `api_user_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;	
        }
        return $return;
    }
	
	public function getAPIAdminId($api_user_username)
    {
        $DBH = new DatabaseHandler();
        $api_user_id = 0;

        $sql = "SELECT * FROM `tblapiusers` WHERE `api_user_username` = '".$api_user_username."' AND `api_user_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $api_user_id = $r['api_user_id'];
        }
        return $api_user_id;
    }
	
	public function getAPIAdminName($api_user_username)
    {
        $DBH = new DatabaseHandler();
        $api_user_name = '';

        $sql = "SELECT * FROM `tblapiusers` WHERE `api_user_username` = '".$api_user_username."' AND `api_user_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $api_user_name = $r['api_user_name'];
        }
        return $api_user_name;
    }
	
	public function getAPIAdminEmail($api_user_username)
    {
        $DBH = new DatabaseHandler();
        $api_user_email = '';

        $sql = "SELECT * FROM `tblapiusers` WHERE `api_user_username` = '".$api_user_username."' AND `api_user_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $api_user_email = $r['api_user_email'];
        }
        return $api_user_email;
    }
	
	public function doAPIAdminLogin($api_user_username)
    {
        global $link;
        $return = false;

        $api_user_id = $this->getAPIAdminId($api_user_username);
        $api_user_name = $this->getAPIAdminName($api_user_username);
        $api_user_email = $this->getAPIAdminEmail($api_user_username);
        
        if($api_user_id > 0)
        {
            $return = true;	
            $_SESSION['adm_api_id'] = $api_user_id;
            $_SESSION['adm_api_username'] = $api_user_username; 
            $_SESSION['adm_api_name'] = $api_user_name;
            $_SESSION['adm_api_email'] = $api_user_email;
		}	
        return $return;
    }
	
    public function doAPIAdminLogout()
    {
        global $link;
        $return = true;	

        $_SESSION['adm_api_id'] = '';
        $_SESSION['api_user_username'] = '';
        $_SESSION['api_user_name'] = '';
        $_SESSION['api_user_email'] = '';
        unset($_SESSION['adm_api_id']);
        unset($_SESSION['api_user_username']);
        unset($_SESSION['api_user_name']);
        unset($_SESSION['api_user_email']);
        session_destroy();
        session_start();
        session_regenerate_id();
        $new_sessionid = session_id();

        return $return;
    }
	
	public function getAPIAdminMenuCode($admin_main_menu_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$output .= '<ul class="nav panel-list">';
		
		if($admin_main_menu_id == '1' )
		{
			$li_class = ' class="active" ';
		}
		else
		{
			$li_class = '';
		}
		
		$output .= '<li '.$li_class.'>
						<a href="'.API_ADMIN_URL.'">
							<i class="fa fa-home"></i>
							<span class="menu-text">Dashboard</span>
							<span class="selected"></span>
						</a>
					</li>';
		
		$li_class_booking = ' class="hoe-has-menu" ';	
		$li_class_students = ' class="hoe-has-menu" ';	
		if($admin_main_menu_id == '2' )
		{
			$li_class_booking = ' class="hoe-has-menu active" ';
		}
		elseif($admin_main_menu_id == '5' )
		{
			//$li_class_students = ' class="hoe-has-menu active" ';
		}
		
					
		$output .= '<li '.$li_class_booking.'>
						<a href="'.API_ADMIN_URL.'/manage_my_bookings.php">
							<i class="fa fa-user"></i>
							<span class="menu-text">Manage My Bookings</span>
							<span class="selected"></span>
						</a>
					</li>';
		/*			
		$output .= '<li '.$li_class_students.'>
						<a href="'.API_ADMIN_URL.'/manage_my_students.php">
							<i class="fa fa-user"></i>
							<span class="menu-text">Manage Students</span>
							<span class="selected"></span>
						</a>
					</li>';
		*/			
		$output .= '</ul>';	
		return $output;
	}
	
	public function updateAPIAdminProfile($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblapiusers` SET 
					`api_user_username` = :api_user_username,
					`api_user_email` = :api_user_email,
					`api_user_name` = :api_user_name,
					`api_user_contact_no` = :api_user_contact_no
					WHERE `api_user_id` = :api_user_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':api_user_username' => addslashes($tdata['api_user_username']),
				':api_user_email' => addslashes($tdata['api_user_email']),
				':api_user_name' => addslashes($tdata['api_user_name']),
				':api_user_contact_no' => addslashes($tdata['api_user_contact_no']),
				':api_user_id' => $tdata['api_user_id']
            ));
			$DBH->commit();
			$return = true;
			
        } catch (Exception $e) {
			$stringData = '[updateAPIAdminProfile] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getAPIAdminCurrentPassword($api_user_id)
    {
        $DBH = new DatabaseHandler();
        $password = '';
        
        $sql = "SELECT * FROM `tblapiusers` WHERE `api_user_id` = '".$api_user_id."' AND `api_user_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $password = $r['api_user_password'];
        }	

        return $password;
    }
	
	public function updateAPIAdminPassword($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
		$return = false;
		
		try {
			$sql = "UPDATE `tblapiusers` SET `api_user_password` = :api_user_password WHERE `api_user_id` = :api_user_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
                ':api_user_password' => md5($tdata['api_user_password']),
                ':api_user_id' => $tdata['api_user_id']
            ));
            $DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateAPIAdminPassword] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	//category start
	
	public function DeleteCat($id,$admin_id)
    {
		
        $return= false;
        $DBH = new DatabaseHandler();
        $sql = "update `tblcategories` set  `cat_deleted` = 1, `deleted_by_admin` = '".$admin_id."' where `cat_id`='".$id."' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
            {
             $return=true;
            }
         return $return;   
    }
	 
		
		
	public function GetAllCat($txtsearch='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		if($txtsearch != '')
		{
			$sql_search_str = " AND (`cat_name` LIKE '%".$txtsearch."%')";
		}
		
		$sql = "SELECT * FROM `tblcategories` WHERE `cat_deleted` = '0' AND `parent_cat_id` = '0' ".$sql_search_str." ORDER BY `cat_id` ASC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function chkCategoryExists($cat_name)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblcategories` WHERE `cat_name` = '".$cat_name."' AND `cat_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addCategory($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblcategories` (`cat_name`,`added_by_admin`,`cat_status`) 
					VALUES (:cat_name,:added_by_admin,:cat_status)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':cat_name' => addslashes($tdata['cat_name']),
				':added_by_admin' =>$tdata['admin_id'],
				':cat_status' => '1'
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addCategory] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
		function GetCategory($id)
        {
            $return = array();

            $my_DBH = new DatabaseHandler();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            try {
                $sql = "SELECT * FROM `tblcategories`  where  `cat_id` = '".$id."' ";
                $STH = $DBH->prepare($sql);
                $STH->execute();
                $row_count = $STH->rowCount();
                if ($row_count > 0) 
                {
                    $r = $STH->fetch(PDO::FETCH_ASSOC);
                    $return = $r;
                    }
                return $return;
                } 
            catch (Exception $ex) 
                {
                echo $e->getMessage();
                }
        }
		
	public function chkCategoryExistsById($cat_name,$cid)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblcategories` WHERE `cat_name` = '".$cat_name."' AND `cat_deleted` = '0' AND `cat_id` != '".$cid."'";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function editCategory($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
		$return = false;
		
		try {
			$sql = "UPDATE `tblcategories` SET `cat_name` = :cat_name , `cat_modified_date` = :mdate , `modified_by_admin` = :modified_by_admin  WHERE `cat_id` = :cat_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
                ':cat_name' => addslashes($tdata['cat_name']),
                ':cat_id' => $tdata['cat_id'],
				':mdate' => $tdata['modify_date'],
				':modified_by_admin' => $tdata['admin_id']
            ));
            $DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[editCategory] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	//main category start
	
	public function GetAllMainCat($txtsearch='',$parent_cat_id='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		$sql_parent_cat_id_str = "";
		
		
		if($txtsearch != '' )
		{
			$sql_search_str = " AND `cat_name` LIKE '%".$txtsearch."%' ";
		}
		
		if($parent_cat_id != '')
		{
			$sql_parent_cat_id_str = " AND `parent_cat_id` = '".$parent_cat_id."' ";
		}
		
		$sql = "SELECT * FROM `tblcategories` WHERE `cat_deleted` = '0' AND `parent_cat_id` != 0 ".$sql_search_str." ".$sql_parent_cat_id_str." ORDER BY `cat_id` ASC";	
		$STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
			while($r= $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_records[] = $r;
			}
		}	
		return $arr_records;
	}
	
	public function DeleteMainCat($id,$admin_id)
    {
		
        $return= false;
        $DBH = new DatabaseHandler();
        $sql = "update `tblcategories` set  `cat_deleted` = 1, `deleted_by_admin` = '".$admin_id."' where `cat_id`='".$id."' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
            {
             $return=true;
            }
         return $return;   
    }
	
	 public function GetParentCategory($cat_id,$parent_cat_id) 
    {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $sql = "SELECT * FROM `tblcategories` where `cat_status` = 1 AND `parent_cat_id` = '".$parent_cat_id."' ";
        $STH = $DBH->query($sql);
        //$option_str .= '<option value="">Select Parent Category</option>';
        if ($STH->rowCount() > 0) {
            
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {

                if ($row['cat_id'] == $cat_id) {
                    $option_str .= '<option value="' . $row['cat_id'] . '" selected>' . $row['cat_name'] . '</option>';
                } else {
                    $option_str .= '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                }
            }
            return $option_str;
        } else {
            return $option_str;
        }
    }
	
	public function addMainCategory($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblcategories` (`cat_name`,`added_by_admin`,`cat_status`,`parent_cat_id`) 
					VALUES (:cat_name,:added_by_admin,:cat_status,:parent_cat_id)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':cat_name' => addslashes($tdata['cat_name']),
				':added_by_admin' =>$tdata['admin_id'],
				':cat_status' => '1',
				':parent_cat_id' =>$tdata['parent_cat_id'],
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addCategory] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function editMainCategory($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
		$return = false;
		
		try {
			$sql = "UPDATE `tblcategories` SET `cat_name` = :cat_name , `cat_modified_date` = :mdate , `modified_by_admin` = :modified_by_admin , `parent_cat_id` = :parent_cat_id WHERE `cat_id` = :cat_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
                ':cat_name' => addslashes($tdata['cat_name']),
                ':cat_id' => $tdata['cat_id'],
				':mdate' => $tdata['modify_date'],
				':modified_by_admin' => $tdata['admin_id'],
				':parent_cat_id' => $tdata['parent_cat_id']
            ));
            $DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[editCategory] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
		public function GetCatName($cat_id)
        {
            $return ='';
            $my_DBH = new DatabaseHandler();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            try {
                    $sql = "SELECT `cat_name` FROM `tblcategories` where `cat_id`= '".$cat_id."' ";
                    $STH = $DBH->prepare($sql);
                    
                    $STH->execute();
                    $row_count = $STH->rowCount();
                    if ($row_count > 0) 
                    {
                        $r = $STH->fetch(PDO::FETCH_ASSOC);
                        
                            $return=$r['cat_name']; 
                            
                    }
                return $return;
                } 
            catch (Exception $ex) 
            {
            echo $e->getMessage();
            }
        }
	
		
	
}
?>