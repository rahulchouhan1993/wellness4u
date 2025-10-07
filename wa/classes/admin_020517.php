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
		
		try {
			$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `status` = '1' AND `deleted` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;	
			}
		} catch (Exception $e) {
			$stringData = '[chkValidAdmin] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return false;
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

        try {
			$sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `password` = '".md5($password)."' AND `status` = '1' AND `deleted` = '0' ";
			//$this->debuglog('[chkValidAdminLogin] sql: '.$sql);	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;	
			}
		} catch (Exception $e) {
			$stringData = '[chkValidAdminLogin] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	

    public function chkValidAdminCurrentPassword($password,$admin_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

		try {
			$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."' AND `password` = '".md5($password)."' AND `deleted` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;
			}
		} catch (Exception $e) {
			$stringData = '[chkValidAdminCurrentPassword] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return false;
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

		try {
			$sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `deleted` = '0' ";
			$STH = $DBH->query($sql);
			if($STH->rowCount() > 0)
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$admin_id = $r['admin_id'];
			}
		} catch (Exception $e) {
			$stringData = '[getAdminId] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return 0;
        }		
        return $admin_id;
    }

    public function getAdminFirstName($username)
    {
        $DBH = new DatabaseHandler();
        $fname = '';

		try {
			$sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `deleted` = '0' ";
			$STH = $DBH->query($sql);
			if($STH->rowCount() > 0)
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$fname = stripslashes($r['fname']);
			}
		} catch (Exception $e) {
			$stringData = '[getAdminFirstName] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $fname;
        }		
        return $fname;
    }
	
    public function getAdminLastName($username)
    {
        $DBH = new DatabaseHandler();
        $lname = '';

		try {
			$sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `deleted` = '0' ";
			$STH = $DBH->query($sql);
			if($STH->rowCount() > 0)
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$lname = stripslashes($r['lname']);
			}
		} catch (Exception $e) {
			$stringData = '[getAdminLastName] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $lname;
        }		
        return $lname;
    }

	public function getAdminEmail($username)
    {
        $DBH = new DatabaseHandler();
        $email = '';

		try {
			$sql = "SELECT * FROM `tbladmin` WHERE `username` = '".$username."' AND `deleted` = '0' ";
			$STH = $DBH->query($sql);
			if($STH->rowCount() > 0)
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$email = stripslashes($r['email']);
			}
		} catch (Exception $e) {
			$stringData = '[getAdminEmail] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $email;
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
				if($r['am_id'] != '1')
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
		}
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
	
	public function getAllSubadmins($txtsearch='',$status='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		$sql_status_str = "";
		
		if($txtsearch != '')
		{
			$sql_search_str = " AND (`username` LIKE '%".$txtsearch."%' OR `email` LIKE '%".$txtsearch."%' OR `fname` LIKE '%".$txtsearch."%' OR `lname` LIKE '%".$txtsearch."%' )";
		}
		
		if($status != '')
		{
			$sql_status_str = " AND `status` = '".$status."' ";
		}
		
		$sql = "SELECT * FROM `tbladmin` WHERE `super_admin` = '0' AND `deleted` = '0' ".$sql_search_str." ".$sql_status_str." ORDER BY username ASC";	
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
	
	//category start
	
	public function DeleteCat($id,$admin_id)
    {
		$return= false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblcategories` SET  `cat_deleted` = '1', `cat_modified_date` = '".date('Y-m-d H:i:s')."', `deleted_by_admin` = '".$admin_id."' WHERE `cat_id`='".$id."' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
			$return=true;
		}
		return $return;   
    }
		
	public function GetAllCat($txtsearch='',$status='',$added_by_admin='',$added_date_type='',$added_days_of_month='',$added_days_of_week='',$added_single_date='',$added_start_date='',$added_end_date='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		if($txtsearch != '')
		{
			$sql_search_str = " AND `cat_name` LIKE '%".$txtsearch."%' ";
		}
		
		$sql_status_str = "";
		if($status != '')
		{
			$sql_status_str = " AND `cat_status` = '".$status."' ";
		}
		
		$sql_added_by_admin_str = "";
		if($added_by_admin != '')
		{
			$sql_added_by_admin_str = " AND added_by_admin = '".$added_by_admin."' ";
		}
		
		$sql_add_date_str = "";
		if($added_date_type != '')
		{
			if($added_date_type == 'days_of_month')
			{
				if($added_days_of_month != '' && $added_days_of_month != '-1')
				{
					$sql_add_date_str = " AND DAY(cat_add_date) = '".$added_days_of_month."' ";	
				}	
			}
			elseif($added_date_type == 'days_of_week')
			{
				if($added_days_of_week != '' && $added_days_of_week != '-1')
				{
					//In WEEKDAY()  0-Monday,6-Sunday
					$added_days_of_week = $added_days_of_week -1;
					$sql_add_date_str = " AND WEEKDAY(cat_add_date) = '".$added_days_of_week."' ";	
				}	
			}
			elseif($added_date_type == 'single_date')
			{
				if($added_single_date != '' && $added_single_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(cat_add_date) = '".date('Y-m-d',strtotime($added_single_date))."' ";	
				}	
			}
			elseif($added_date_type == 'date_range')
			{
				if($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(cat_add_date) >= '".date('Y-m-d',strtotime($added_start_date))."'  AND DATE(cat_add_date) <= '".date('Y-m-d',strtotime($added_end_date))."' ";	
				}	
			}
		}
		
		$sql = "SELECT * FROM `tblcategories` WHERE `cat_deleted` = '0' AND `parent_cat_id` = '0' ".$sql_search_str." ".$sql_status_str." ".$sql_added_by_admin_str." ".$sql_add_date_str."  ORDER BY `cat_name` ASC";	
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
			$sql = "INSERT INTO `tblcategories` (`cat_name`,`added_by_admin`,`cat_status`,`cat_add_date`) 
					VALUES (:cat_name,:added_by_admin,:cat_status,:cat_add_date)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':cat_name' => addslashes($tdata['cat_name']),
				':added_by_admin' =>$tdata['admin_id'],
				':cat_status' => '1',
				':cat_add_date' => date('Y-m-d H:i:s')
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
	
	public function GetCategory($id)
	{
		$return = array();

		$my_DBH = new DatabaseHandler();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		try 
		{
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
		catch (Exception $e) 
		{
			$stringData = '[GetCategory] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return array();
		}
	}
	
	public function getCategoryName($id)
	{
		$DBH = new DatabaseHandler();
		$return = '';
		
		try 
		{
			$sql = "SELECT cat_name FROM `tblcategories`  WHERE  `cat_id` = '".$id."' AND `cat_deleted` = '0' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{	
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$return = $r['cat_name'];
			}
			return $return;
		} 
		catch (Exception $e) 
		{
			$stringData = '[getCategoryName] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return '';
		}
	}	
		
	public function chkCategoryExistsById($cat_name,$cid)
    {
        $DBH = new DatabaseHandler();
        $return = false;

		try {
			$sql = "SELECT * FROM `tblcategories` WHERE `cat_name` = '".$cat_name."' AND `cat_deleted` = '0' AND `cat_id` != '".$cid."'";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;
			}
			return $return;
		} 
		catch (Exception $ex) 
		{
			$stringData = '[chkCategoryExistsById] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
			return false;
		}	
    }
	
	public function editCategory($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
		$return = false;
		
		try {
			$sql = "UPDATE `tblcategories` SET `cat_name` = :cat_name , `cat_status` = :cat_status , `cat_modified_date` = :mdate , `modified_by_admin` = :modified_by_admin  WHERE `cat_id` = :cat_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
                ':cat_name' => addslashes($tdata['cat_name']),
                ':cat_id' => $tdata['cat_id'],
                ':cat_status' => $tdata['cat_status'],
				':mdate' => $tdata['modify_date'],
				':modified_by_admin' => $tdata['admin_id']
            ));
            $DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[editCategory] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	//main category start
	
	public function GetAllMainCat($txtsearch='',$parent_cat_id='',$status='',$added_by_admin='',$added_date_type='',$added_days_of_month='',$added_days_of_week='',$added_single_date='',$added_start_date='',$added_end_date='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		$sql_parent_cat_id_str = "";
		$sql_status_str = "";
		
		if($txtsearch != '' )
		{
			$sql_search_str = " AND `cat_name` LIKE '%".$txtsearch."%' ";
		}
		
		if($parent_cat_id != '')
		{
			$sql_parent_cat_id_str = " AND `parent_cat_id` = '".$parent_cat_id."' ";
		}
		
		if($status != '')
		{
			$sql_status_str = " AND `cat_status` = '".$status."' ";
		}
		
		$sql_added_by_admin_str = "";
		if($added_by_admin != '')
		{
			$sql_added_by_admin_str = " AND added_by_admin = '".$added_by_admin."' ";
		}
		
		$sql_add_date_str = "";
		if($added_date_type != '')
		{
			if($added_date_type == 'days_of_month')
			{
				if($added_days_of_month != '' && $added_days_of_month != '-1')
				{
					$sql_add_date_str = " AND DAY(cat_add_date) = '".$added_days_of_month."' ";	
				}	
			}
			elseif($added_date_type == 'days_of_week')
			{
				if($added_days_of_week != '' && $added_days_of_week != '-1')
				{
					//In WEEKDAY()  0-Monday,6-Sunday
					$added_days_of_week = $added_days_of_week -1;
					$sql_add_date_str = " AND WEEKDAY(cat_add_date) = '".$added_days_of_week."' ";	
				}	
			}
			elseif($added_date_type == 'single_date')
			{
				if($added_single_date != '' && $added_single_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(cat_add_date) = '".date('Y-m-d',strtotime($added_single_date))."' ";	
				}	
			}
			elseif($added_date_type == 'date_range')
			{
				if($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(cat_add_date) >= '".date('Y-m-d',strtotime($added_start_date))."'  AND DATE(cat_add_date) <= '".date('Y-m-d',strtotime($added_end_date))."' ";	
				}	
			}
		}
		
		$sql = "SELECT * FROM `tblcategories` WHERE `cat_deleted` = '0' AND `parent_cat_id` != 0 ".$sql_search_str." ".$sql_parent_cat_id_str." ".$sql_status_str." ".$sql_added_by_admin_str." ".$sql_add_date_str."  ORDER BY `cat_name` ASC";	
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
        $sql = "UPDATE `tblcategories` SET  `cat_deleted` = '1', `cat_modified_date` = '".date('Y-m-d H:i:s')."', `deleted_by_admin` = '".$admin_id."' WHERE `cat_id`='".$id."' ";
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
        $sql = "SELECT * FROM `tblcategories` where `cat_deleted` = 0 AND `parent_cat_id` = '".$parent_cat_id."' ORDER BY cat_name ASC";
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
			$sql = "INSERT INTO `tblcategories` (`cat_name`,`added_by_admin`,`cat_status`,`parent_cat_id`,`cat_add_date`) 
					VALUES (:cat_name,:added_by_admin,:cat_status,:parent_cat_id,:cat_add_date)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':cat_name' => addslashes($tdata['cat_name']),
				':added_by_admin' =>$tdata['admin_id'],
				':cat_status' => '1',
				':parent_cat_id' =>$tdata['parent_cat_id'],
				':cat_add_date' => date('Y-m-d H:i:s')
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
			$sql = "UPDATE `tblcategories` SET `cat_name` = :cat_name , `cat_modified_date` = :mdate , `modified_by_admin` = :modified_by_admin , `parent_cat_id` = :parent_cat_id , `cat_status` = :cat_status WHERE `cat_id` = :cat_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
                ':cat_name' => addslashes($tdata['cat_name']),
                ':cat_id' => $tdata['cat_id'],
				':mdate' => $tdata['modify_date'],
				':modified_by_admin' => $tdata['admin_id'],
				':parent_cat_id' => $tdata['parent_cat_id'],
				':cat_status' => $tdata['cat_status']
            ));
            $DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[editMainCategory] Catch Error:'.$e->getMessage();
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
	
	public function getAllAdminMenusList($txtsearch='',$status='',$added_by_admin='',$added_date_type='',$added_days_of_month='',$added_days_of_week='',$added_single_date='',$added_start_date='',$added_end_date='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		$sql_status_str = "";
		
		if($txtsearch != '')
		{
			$sql_search_str = " AND `am_title` LIKE '%".$txtsearch."%' ";
		}
		
		if($status != '')
		{
			$sql_status_str = " AND `am_status` = '".$status."' ";
		}
		
		$sql_added_by_admin_str = "";
		if($added_by_admin != '')
		{
			$sql_added_by_admin_str = " AND added_by_admin = '".$added_by_admin."' ";
		}
		
		$sql_add_date_str = "";
		if($added_date_type != '')
		{
			if($added_date_type == 'days_of_month')
			{
				if($added_days_of_month != '' && $added_days_of_month != '-1')
				{
					$sql_add_date_str = " AND DAY(am_add_date) = '".$added_days_of_month."' ";	
				}	
			}
			elseif($added_date_type == 'days_of_week')
			{
				if($added_days_of_week != '' && $added_days_of_week != '-1')
				{
					//In WEEKDAY()  0-Monday,6-Sunday
					$added_days_of_week = $added_days_of_week -1;
					$sql_add_date_str = " AND WEEKDAY(am_add_date) = '".$added_days_of_week."' ";	
				}	
			}
			elseif($added_date_type == 'single_date')
			{
				if($added_single_date != '' && $added_single_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(am_add_date) = '".date('Y-m-d',strtotime($added_single_date))."' ";	
				}	
			}
			elseif($added_date_type == 'date_range')
			{
				if($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(am_add_date) >= '".date('Y-m-d',strtotime($added_start_date))."'  AND DATE(am_add_date) <= '".date('Y-m-d',strtotime($added_end_date))."' ";	
				}	
			}
		}
		
		$sql = "SELECT * FROM `tbladminmenu` WHERE `am_deleted` = '0' ".$sql_search_str." ".$sql_status_str." ".$sql_added_by_admin_str." ".$sql_add_date_str."  ORDER BY am_order ASC ";	
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
	
	public function deleteAdminMenu($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tbladminmenu` SET 
					`am_deleted` = :am_deleted,
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `am_id` = :am_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':am_deleted' => '1',
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':am_id' => $tdata['am_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteAdminMenu] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function chkAdminMenuTitleExists($am_title)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tbladminmenu` WHERE `am_title` = '".addslashes($am_title)."' AND `am_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkAdminMenuTitleExists_edit($am_title,$am_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tbladminmenu` WHERE `am_title` = '".addslashes($am_title)."' AND `am_id` != '".$am_id."' AND `am_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addAdminMenu($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tbladminmenu` (`am_title`,`am_link`,`am_icon`,`am_order`,`am_status`,`added_by_admin`) 
					VALUES (:am_title,:am_link,:am_icon,:am_order,:am_status,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':am_title' => addslashes($tdata['am_title']),
				':am_link' => addslashes($tdata['am_link']),
				':am_icon' => addslashes($tdata['am_icon']),
				':am_order' => addslashes($tdata['am_order']),
				':am_status' => addslashes($tdata['am_status']),
				':added_by_admin' =>$tdata['added_by_admin'],
			));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addAdminMenu] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getAdminMenuDetails($am_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tbladminmenu` WHERE `am_id` = '".$am_id."' AND `am_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function getAdminMenuName($am_id)
    {
        $DBH = new DatabaseHandler();
        $am_title = '';
        
        $sql = "SELECT * FROM `tbladminmenu` WHERE `am_id` = '".$am_id."' AND `am_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $am_title = $r['am_title'];
        }	

        return $am_title;
    }
	
	public function updateAdminMenu($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tbladminmenu` SET 
					`am_title` = :am_title,
					`am_link` = :am_link,
					`am_order` = :am_order,
					`am_status` = :am_status,
					`am_modified_date` = :am_modified_date,  
					`modified_by_admin` = :modified_by_admin  
					WHERE `am_id` = :am_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':am_title' => addslashes($tdata['am_title']),
				':am_link' => addslashes($tdata['am_link']),
				':am_order' => addslashes($tdata['am_order']),
				':am_status' => addslashes($tdata['am_status']),
				':am_modified_date' => date('Y-m-d H:i:s'),
				':modified_by_admin' => $tdata['modified_by_admin'],
				':am_id' => $tdata['am_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateAdminMenu] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getAllAdminActionList($am_id,$txtsearch='',$status='',$added_by_admin='',$added_date_type='',$added_days_of_month='',$added_days_of_week='',$added_single_date='',$added_start_date='',$added_end_date='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		$sql_status_str = "";
		
		if($txtsearch != '')
		{
			$sql_search_str = " AND `aa_title` LIKE '%".$txtsearch."%' ";
		}
		
		if($status != '')
		{
			$sql_status_str = " AND `aa_status` = '".$status."' ";
		}
		
		$sql_added_by_admin_str = "";
		if($added_by_admin != '')
		{
			$sql_added_by_admin_str = " AND added_by_admin = '".$added_by_admin."' ";
		}
		
		$sql_add_date_str = "";
		if($added_date_type != '')
		{
			if($added_date_type == 'days_of_month')
			{
				if($added_days_of_month != '' && $added_days_of_month != '-1')
				{
					$sql_add_date_str = " AND DAY(aa_add_date) = '".$added_days_of_month."' ";	
				}	
			}
			elseif($added_date_type == 'days_of_week')
			{
				if($added_days_of_week != '' && $added_days_of_week != '-1')
				{
					//In WEEKDAY()  0-Monday,6-Sunday
					$added_days_of_week = $added_days_of_week -1;
					$sql_add_date_str = " AND WEEKDAY(aa_add_date) = '".$added_days_of_week."' ";	
				}	
			}
			elseif($added_date_type == 'single_date')
			{
				if($added_single_date != '' && $added_single_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(aa_add_date) = '".date('Y-m-d',strtotime($added_single_date))."' ";	
				}	
			}
			elseif($added_date_type == 'date_range')
			{
				if($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(aa_add_date) >= '".date('Y-m-d',strtotime($added_start_date))."'  AND DATE(aa_add_date) <= '".date('Y-m-d',strtotime($added_end_date))."' ";	
				}	
			}
		}
		
		$sql = "SELECT * FROM `tbladminactions` WHERE `am_id` = '".$am_id."' AND `aa_deleted` = '0' ".$sql_search_str." ".$sql_status_str." ".$sql_added_by_admin_str." ".$sql_add_date_str."  ORDER BY aa_add_date ASC ";	
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
	
	public function deleteAdminAction($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tbladminactions` SET 
					`aa_deleted` = :aa_deleted,
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `aa_id` = :aa_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':aa_deleted' => '1',
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':aa_id' => $tdata['aa_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteAdminAction] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function chkAdminActionTitleExists($aa_title,$am_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tbladminactions` WHERE `aa_title` = '".addslashes($aa_title)."' AND `am_id` = '".$am_id."' AND `aa_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkAdminActionTitleExists_edit($aa_title,$am_id,$aa_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tbladminactions` WHERE `aa_title` = '".addslashes($aa_title)."' AND `am_id` = '".$am_id."'  AND `aa_id` != '".$aa_id."' AND `aa_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addAdminAction($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tbladminactions` (`am_id`,`aa_title`,`aa_link`,`aa_status`,`added_by_admin`) 
					VALUES (:am_id,:aa_title,:aa_link,:aa_status,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':am_id' => addslashes($tdata['am_id']),
				':aa_title' => addslashes($tdata['aa_title']),
				':aa_link' => addslashes($tdata['aa_link']),
				':aa_status' => addslashes($tdata['aa_status']),
				':added_by_admin' =>$tdata['added_by_admin'],
			));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addAdminAction] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getAdminActionDetails($aa_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tbladminactions` WHERE `aa_id` = '".$aa_id."' AND `aa_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function getAdminActionName($aa_id)
    {
        $DBH = new DatabaseHandler();
        $aa_title = '';
        
        $sql = "SELECT * FROM `tbladminactions` WHERE `aa_id` = '".$aa_id."' AND `aa_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $aa_title = $r['aa_title'];
        }	

        return $aa_title;
    }
	
	public function getAdminActionLink($aa_id)
    {
        $DBH = new DatabaseHandler();
        $aa_link = '';
        
        $sql = "SELECT * FROM `tbladminactions` WHERE `aa_id` = '".$aa_id."' AND `aa_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $aa_link = $r['aa_link'];
        }	

        return $aa_link;
    }
	
	public function updateAdminAction($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tbladminactions` SET 
					`aa_title` = :aa_title,
					`aa_link` = :aa_link,
					`aa_status` = :aa_status,
					`aa_modified_date` = :aa_modified_date,  
					`modified_by_admin` = :modified_by_admin  
					WHERE `aa_id` = :aa_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':aa_title' => addslashes($tdata['aa_title']),
				':aa_link' => addslashes($tdata['aa_link']),
				':aa_status' => addslashes($tdata['aa_status']),
				':aa_modified_date' => date('Y-m-d H:i:s'),
				':modified_by_admin' => $tdata['modified_by_admin'],
				':aa_id' => $tdata['aa_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[updateAdminAction] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	//country start
	
	public function GetAllCountry($txtsearch='',$status='',$added_by_admin='',$added_date_type='',$added_days_of_month='',$added_days_of_week='',$added_single_date='',$added_start_date='',$added_end_date='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		if($txtsearch != '')
		{
			$sql_search_str = " AND `country_name` LIKE '%".$txtsearch."%' ";
		}
		
		$sql_status_str = "";
		if($status != '')
		{
			$sql_status_str = " AND `country_status` = '".$status."' ";
		}
		
		$sql_added_by_admin_str = "";
		if($added_by_admin != '')
		{
			$sql_added_by_admin_str = " AND added_by_admin = '".$added_by_admin."' ";
		}
		
		$sql_add_date_str = "";
		if($added_date_type != '')
		{
			if($added_date_type == 'days_of_month')
			{
				if($added_days_of_month != '' && $added_days_of_month != '-1')
				{
					$sql_add_date_str = " AND DAY(country_add_date) = '".$added_days_of_month."' ";	
				}	
			}
			elseif($added_date_type == 'days_of_week')
			{
				if($added_days_of_week != '' && $added_days_of_week != '-1')
				{
					//In WEEKDAY()  0-Monday,6-Sunday
					$added_days_of_week = $added_days_of_week -1;
					$sql_add_date_str = " AND WEEKDAY(country_add_date) = '".$added_days_of_week."' ";	
				}	
			}
			elseif($added_date_type == 'single_date')
			{
				if($added_single_date != '' && $added_single_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(country_add_date) = '".date('Y-m-d',strtotime($added_single_date))."' ";	
				}	
			}
			elseif($added_date_type == 'date_range')
			{
				if($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(country_add_date) >= '".date('Y-m-d',strtotime($added_start_date))."'  AND DATE(country_add_date) <= '".date('Y-m-d',strtotime($added_end_date))."' ";	
				}	
			}
		}
		
		$sql = "SELECT * FROM `tblcountry` WHERE `country_deleted` = '0'  ".$sql_search_str." ".$sql_status_str." ".$sql_added_by_admin_str." ".$sql_add_date_str."  ORDER BY `country_name` ASC";	
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
	
	public function chkCountryNameExists($country_name)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblcountry` WHERE `country_name` = '".$country_name."' AND `country_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addCountry($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblcountry` (`country_name`,`country_status`,`added_by_admin`) 
					VALUES (:country_name,:country_status,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':country_name' => addslashes($tdata['country_name']),
				':country_status' => '1',
				':added_by_admin' => addslashes($tdata['admin_id']),
				
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addCountry] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function DeleteCountry($id,$admin_id)
    {
	    $return= false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblcountry` SET  `country_deleted` = '1', `country_modified_date` = '".date('Y-m-d H:i:s')."' , `deleted_by_admin` = '".$admin_id."' WHERE `country_id`='".$id."' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
			$return=true;
		}
         return $return;   
    }
	
	 public function getCountryDetails($country_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblcountry` WHERE `country_id` = '".$country_id."' AND `country_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function chkCountryNameExists_edit($country_name,$country_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblcountry` WHERE `country_name` = '".$country_name."' AND `country_id` != '".$country_id."' AND `country_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function updateCountry($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblcountry` SET 
					`country_name` = :country_name,
					`modified_by_admin` = :modified_by_admin,
					`country_status` = :status  ,
					`country_modified_date` = '".date('Y-m-d H:i:s')."' 
					WHERE `country_id` = :country_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':country_name' => addslashes($tdata['country_name']),
				':modified_by_admin' => $tdata['admin_id'],
				':status' => $tdata['status'],
				':country_id' => $tdata['country_id'],
            ));
			$DBH->commit();
			
			$return = true;
			
        } catch (Exception $e) {
			$stringData = '[updateCountry] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	//states start
	
	public function GetAllStates($txtsearch='',$status='',$country_id='',$added_by_admin='',$added_date_type='',$added_days_of_month='',$added_days_of_week='',$added_single_date='',$added_start_date='',$added_end_date='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		if($txtsearch != '')
		{
			$sql_search_str = " AND `state_name` LIKE '%".$txtsearch."%' ";
		}
		
		$sql_status_str = "";
		if($status != '')
		{
			$sql_status_str = " AND `state_status` = '".$status."' ";
		}
		
		$sql_country_str = "";
		if($country_id != '')
		{
			$sql_country_str = " AND `country_id` = '".$country_id."' ";
		}
		
		$sql_added_by_admin_str = "";
		if($added_by_admin != '')
		{
			$sql_added_by_admin_str = " AND added_by_admin = '".$added_by_admin."' ";
		}
		
		$sql_add_date_str = "";
		if($added_date_type != '')
		{
			if($added_date_type == 'days_of_month')
			{
				if($added_days_of_month != '' && $added_days_of_month != '-1')
				{
					$sql_add_date_str = " AND DAY(state_add_date) = '".$added_days_of_month."' ";	
				}	
			}
			elseif($added_date_type == 'days_of_week')
			{
				if($added_days_of_week != '' && $added_days_of_week != '-1')
				{
					//In WEEKDAY()  0-Monday,6-Sunday
					$added_days_of_week = $added_days_of_week -1;
					$sql_add_date_str = " AND WEEKDAY(state_add_date) = '".$added_days_of_week."' ";	
				}	
			}
			elseif($added_date_type == 'single_date')
			{
				if($added_single_date != '' && $added_single_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(state_add_date) = '".date('Y-m-d',strtotime($added_single_date))."' ";	
				}	
			}
			elseif($added_date_type == 'date_range')
			{
				if($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(state_add_date) >= '".date('Y-m-d',strtotime($added_start_date))."'  AND DATE(state_add_date) <= '".date('Y-m-d',strtotime($added_end_date))."' ";	
				}	
			}
		}
		
		$sql = "SELECT * FROM `tblstates` WHERE `state_deleted` = '0'  ".$sql_search_str." ".$sql_status_str." ".$sql_country_str." ".$sql_added_by_admin_str." ".$sql_add_date_str."  ORDER BY `state_name` ASC";	
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
	
	public function DeleteState($id,$admin_id)
    {
	    $return= false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblstates` SET  `state_deleted` = '1', `state_modified_date` = '".date('Y-m-d H:i:s')."' `deleted_by_admin` = '".$admin_id."' WHERE `state_id`='".$id."' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
			$return=true;
		}
         return $return;   
    }
	
	public function GetCountryName($country_id)
	{
		$return ='';
		$my_DBH = new DatabaseHandler();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		try {
				$sql = "SELECT `country_name` FROM `tblcountry` where `country_id`= '".$country_id."' ";
				$STH = $DBH->prepare($sql);
				
				$STH->execute();
				$row_count = $STH->rowCount();
				if ($row_count > 0) 
				{
					$r = $STH->fetch(PDO::FETCH_ASSOC);
					
						$return=$r['country_name']; 
						
				}
			return $return;
			} 
		catch (Exception $ex) 
		{
		echo $e->getMessage();
		}
	}
	
	 public function GetCountry($country_id) 
    {
        $DBH = new DatabaseHandler();
        $option_str = '';
        $sql = "SELECT * FROM `tblcountry` WHERE `country_deleted` = '0' ORDER BY `country_name` ASC  ";
        $STH = $DBH->query($sql);
        //$option_str .= '<option value="">Select Parent Category</option>';
        if ($STH->rowCount() > 0) {
            
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {

                if ($row['country_id'] == $country_id) {
                    $option_str .= '<option value="' . $row['country_id'] . '" selected>' . $row['country_name'] . '</option>';
                } else {
                    $option_str .= '<option value="' . $row['country_id'] . '">' . $row['country_name'] . '</option>';
                }
            }
            return $option_str;
        } else {
            return $option_str;
        }
    }
	
	public function chkStateNameExists($state_name,$country_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblstates` WHERE `state_name` = '".$state_name."' AND `country_id` = '".$country_id."' AND `state_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addState($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblstates` (`country_id`,`state_name`,`state_status`,`added_by_admin`) 
					VALUES (:country_id,:state_name,:state_status,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':country_id' => $tdata['country_id'],
				':state_name' => addslashes($tdata['state_name']),
				':state_status' => '1',
				':added_by_admin' => $tdata['admin_id'],
				
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addState] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getStateDetails($state_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblstates` WHERE `state_id` = '".$state_id."' AND `state_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function chkStateNameExists_edit($state_name,$state_id,$country_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblstates` WHERE `state_name` = '".$state_name."' AND `state_id` != '".$state_id."' AND `country_code` = '".$country_id."' `state_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function updateState($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblstates` SET 
					`country_id` = :country_id,
					`state_name` = :state_name,
					`modified_by_admin` = :modified_by_admin,
					`state_status` = :status  ,
					`state_modified_date` = '".date('Y-m-d H:i:s')."' 
					WHERE `state_id` = :state_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':country_id' => $tdata['country_id'],
				':state_name' => addslashes($tdata['state_name']),
				':modified_by_admin' => $tdata['admin_id'],
				':status' => $tdata['status'],
				':state_id' => $tdata['state_id'],
            ));
			$DBH->commit();
			
			$return = true;
			
        } catch (Exception $e) {
			$stringData = '[updateState] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function GetStateName($state_id)
	{
		$return ='';
		$my_DBH = new DatabaseHandler();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		try {
				$sql = "SELECT `state_name` FROM `tblstates` where `state_id`= '".$state_id."' ";
				$STH = $DBH->prepare($sql);
				
				$STH->execute();
				$row_count = $STH->rowCount();
				if ($row_count > 0) 
				{
					$r = $STH->fetch(PDO::FETCH_ASSOC);
					
						$return=$r['state_name']; 
						
				}
			return $return;
			} 
		catch (Exception $ex) 
		{
		echo $e->getMessage();
		}
	}
	
	//cities start
	public function GetAllCities($txtsearch='',$status='',$country_id='',$state_id='',$added_by_admin='',$added_date_type='',$added_days_of_month='',$added_days_of_week='',$added_single_date='',$added_start_date='',$added_end_date='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		if($txtsearch != '')
		{
			$sql_search_str = " AND `city_name` LIKE '%".$txtsearch."%' ";
		}
		
		$sql_status_str = "";
		if($status != '')
		{
			$sql_status_str = " AND `city_status` = '".$status."' ";
		}
		
		$sql_country_str = "";
		if($country_id != '')
		{
			$sql_country_str = " AND `country_id` = '".$country_id."' ";
		}
		
		$sql_state_str = "";
		if($state_id != '')
		{
			$sql_state_str = " AND `state_id` = '".$state_id."' ";
		}
		
		$sql_added_by_admin_str = "";
		if($added_by_admin != '')
		{
			$sql_added_by_admin_str = " AND added_by_admin = '".$added_by_admin."' ";
		}
		
		$sql_add_date_str = "";
		if($added_date_type != '')
		{
			if($added_date_type == 'days_of_month')
			{
				if($added_days_of_month != '' && $added_days_of_month != '-1')
				{
					$sql_add_date_str = " AND DAY(city_add_date) = '".$added_days_of_month."' ";	
				}	
			}
			elseif($added_date_type == 'days_of_week')
			{
				if($added_days_of_week != '' && $added_days_of_week != '-1')
				{
					//In WEEKDAY()  0-Monday,6-Sunday
					$added_days_of_week = $added_days_of_week -1;
					$sql_add_date_str = " AND WEEKDAY(city_add_date) = '".$added_days_of_week."' ";	
				}	
			}
			elseif($added_date_type == 'single_date')
			{
				if($added_single_date != '' && $added_single_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(city_add_date) = '".date('Y-m-d',strtotime($added_single_date))."' ";	
				}	
			}
			elseif($added_date_type == 'date_range')
			{
				if($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(city_add_date) >= '".date('Y-m-d',strtotime($added_start_date))."'  AND DATE(city_add_date) <= '".date('Y-m-d',strtotime($added_end_date))."' ";	
				}	
			}
		}
		
		$sql = "SELECT * FROM `tblcities` WHERE `city_deleted` = '0'  ".$sql_search_str." ".$sql_status_str." ".$sql_country_str." ".$sql_state_str." ".$sql_added_by_admin_str." ".$sql_add_date_str."  ORDER BY `city_name` ASC";	
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
	
	public function DeleteCity($id,$admin_id)
    {
	    $return= false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblcities` SET  `city_deleted` = '1', `city_modified_date` = '".date('Y-m-d H:i:s')."' ,`deleted_by_admin` = '".$admin_id."' WHERE `city_id`='".$id."' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
			$return=true;
		}
         return $return;   
    }
	
	 public function GetState($state_id,$country_id) 
	{
    
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $status = 1;
        $DBH->beginTransaction();
        try {
            $sql = "SELECT * FROM `tblstates` WHERE `country_id` =:country_id and `state_deleted` = '0' ORDER BY `state_name` ASC";
            $STH = $DBH->prepare($sql);
            $STH->bindParam('country_id', $country_id);
            $STH->execute();
            $rows_affected = $STH->rowCount(); $option='<option value="">Select State</option>';
            if ($rows_affected > 0) {
               
               while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['state_id'] == $state_id) {
                    $option .= '<option value="' . $row['state_id'] . '" selected>' . $row['state_name'] . '</option>';
                } else {
                    $option .= '<option value="' . $row['state_id'] . '">' . $row['state_name'] . '</option>';
                }
            }
            }
            return $option;
            //$DBH->commit();
        } catch (Exception $e) {
            echo $e->getMessage();
        }   
       
    }
	
	public function chkCityNameExists($city_name,$state_id,$country_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblcities` WHERE `city_name` = '".$city_name."' AND `state_id` = '".$state_id."' AND `country_id` = '".$country_id."' AND `city_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addCity($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblcities` (`country_id`,`state_id`,`city_name`,`city_status`,`added_by_admin`) 
					VALUES (:country_id,:state_id,:city_name,:city_status,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':country_id' => $tdata['country_id'],
				':state_id' => $tdata['state_id'],
				':city_name' => addslashes($tdata['city_name']),
				':city_status' => '1',
				':added_by_admin' => $tdata['admin_id'],
				
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addCity] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getCityDetails($city_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblcities` WHERE `city_id` = '".$city_id."' AND `city_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function chkCityNameExists_edit($city_name,$city_id,$country_id,$state_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblcities` WHERE `city_name` = '".$city_name."' AND `city_id` != '".$city_id."' AND `country_id` = '".$country_id."' AND `state_id` = '".$state_id."' AND `city_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function updateCity($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblcities` SET 
					`country_id` = :country_id,
					`state_id` = :state_id,
					`city_name` = :city_name,
					`modified_by_admin` = :modified_by_admin,
					`city_status` = :status  ,
					`city_modified_date` = '".date('Y-m-d H:i:s')."' 
					WHERE `city_id` = :city_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':country_id' => $tdata['country_id'],
				':state_id' => $tdata['state_id'],
				':city_name' => addslashes($tdata['city_name']),
				':modified_by_admin' => $tdata['admin_id'],
				':status' => $tdata['status'],
				':city_id' => $tdata['city_id'],
            ));
			$DBH->commit();
			
			$return = true;
			
        } catch (Exception $e) {
			$stringData = '[updateState] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	//area start
	public function GetAllArea($txtsearch='',$status='',$country_id='',$state_id='',$city_id='',$added_by_admin='',$added_date_type='',$added_days_of_month='',$added_days_of_week='',$added_single_date='',$added_start_date='',$added_end_date='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		if($txtsearch != '')
		{
			$sql_search_str = " AND ( `area_name` LIKE '%".$txtsearch."%' OR  `area_pincode` LIKE '%".$txtsearch."%' ) ";
		}
		
		$sql_status_str = "";
		if($status != '')
		{
			$sql_status_str = " AND `area_status` = '".$status."' ";
		}
		
		$sql_country_str = "";
		if($country_id != '')
		{
			$sql_country_str = " AND `country_id` = '".$country_id."' ";
		}
		
		$sql_state_str = "";
		if($state_id != '')
		{
			$sql_state_str = " AND `state_id` = '".$state_id."' ";
		}
		
		$sql_city_str = "";
		if($city_id != '')
		{
			$sql_state_str = " AND `city_id` = '".$city_id."' ";
		}
		
		$sql_added_by_admin_str = "";
		if($added_by_admin != '')
		{
			$sql_added_by_admin_str = " AND added_by_admin = '".$added_by_admin."' ";
		}
		
		$sql_add_date_str = "";
		if($added_date_type != '')
		{
			if($added_date_type == 'days_of_month')
			{
				if($added_days_of_month != '' && $added_days_of_month != '-1')
				{
					$sql_add_date_str = " AND DAY(area_add_date) = '".$added_days_of_month."' ";	
				}	
			}
			elseif($added_date_type == 'days_of_week')
			{
				if($added_days_of_week != '' && $added_days_of_week != '-1')
				{
					//In WEEKDAY()  0-Monday,6-Sunday
					$added_days_of_week = $added_days_of_week -1;
					$sql_add_date_str = " AND WEEKDAY(area_add_date) = '".$added_days_of_week."' ";	
				}	
			}
			elseif($added_date_type == 'single_date')
			{
				if($added_single_date != '' && $added_single_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(area_add_date) = '".date('Y-m-d',strtotime($added_single_date))."' ";	
				}	
			}
			elseif($added_date_type == 'date_range')
			{
				if($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(area_add_date) >= '".date('Y-m-d',strtotime($added_start_date))."'  AND DATE(area_add_date) <= '".date('Y-m-d',strtotime($added_end_date))."' ";	
				}	
			}
		}
		
		$sql = "SELECT * FROM `tblarea` WHERE `area_deleted` = '0'  ".$sql_search_str." ".$sql_status_str." ".$sql_country_str." ".$sql_state_str." ".$sql_city_str." ".$sql_added_by_admin_str." ".$sql_add_date_str."  ORDER BY `area_name` ASC";	
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
	
	public function DeleteArea($id,$admin_id)
    {
	    $return= false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblarea` SET  `area_deleted` = '1', `area_modified_date` = '".date('Y-m-d H:i:s')."' ,`deleted_by_admin` = '".$admin_id."' WHERE `area_id`='".$id."' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
			$return=true;
		}
         return $return;   
    }
	
	
	 public function GetCity($state_id,$country_id,$city_id) 
	{
    
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $status = 1;
        $DBH->beginTransaction();
        try {
            $sql = "SELECT * FROM `tblcities` WHERE `country_id` =:country_id and `state_id` = :state_id AND `city_deleted` = 0 ORDER BY `city_name` ASC ";
            $STH = $DBH->prepare($sql);
            $STH->bindParam('country_id', $country_id);
			$STH->bindParam('state_id', $state_id);
            $STH->execute();
            $rows_affected = $STH->rowCount(); $option='<option value="">Select City</option>';
            if ($rows_affected > 0) {
               
               while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                if ($row['city_id'] == $city_id) {
                    $option .= '<option value="' . $row['city_id'] . '" selected>' . $row['city_name'] . '</option>';
                } else {
                    $option .= '<option value="' . $row['city_id'] . '">' . $row['city_name'] . '</option>';
                }
            }
            }
            return $option;
            //$DBH->commit();
        } catch (Exception $e) {
            echo $e->getMessage();
        }   
       
    }
	
	public function chkAreaNameExists($area_name,$state_id,$country_id,$city_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblarea` WHERE `area_name` = '".$area_name."' AND `state_id` = '".$state_id."' AND `country_id` = '".$country_id."' AND `city_id` = '".$city_id."' AND `area_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	
	public function addArea($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblarea` (`country_id`,`state_id`,`city_id`,`area_name`,`area_pincode`,`area_status`,`added_by_admin`) 
					VALUES (:country_id,:state_id,:city_id,:area_name,:area_pincode,:area_status,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':country_id' => $tdata['country_id'],
				':state_id' => $tdata['state_id'],
				':city_id' => $tdata['city_id'],
				':area_name' => addslashes($tdata['area_name']),
				':area_pincode' => $tdata['area_pincode'],
				':area_status' => '1',
				':added_by_admin' => $tdata['admin_id'],
				
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addCity] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function GetCityName($city_id)
	{
		$return ='';
		$my_DBH = new DatabaseHandler();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		try {
				$sql = "SELECT `city_name` FROM `tblcities` where `city_id`= '".$city_id."' ";
				$STH = $DBH->prepare($sql);
				
				$STH->execute();
				$row_count = $STH->rowCount();
				if ($row_count > 0) 
				{
					$r = $STH->fetch(PDO::FETCH_ASSOC);
					
						$return=$r['city_name']; 
						
				}
			return $return;
			} 
		catch (Exception $ex) 
		{
		echo $e->getMessage();
		}
	}
	
	public function getAreaDetails($area_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblarea` WHERE `area_id` = '".$area_id."' AND `area_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function chkAreaNameExists_edit($area_name,$area_id,$country_id,$state_id,$city_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblarea` WHERE `area_name` = '".$area_name."' AND `area_id` != '".$area_id."' AND `country_id` = '".$country_id."' AND `state_id` = '".$state_id."' AND `city_id` = '".$city_id."' AND `area_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function updateArea($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblarea` SET 
					`country_id` = :country_id,
					`state_id` = :state_id,
					`city_id` = :city_id,
					`area_name` = :area_name,
					`area_pincode` = :area_pincode,
					`modified_by_admin` = :modified_by_admin,
					`area_status` = :status  ,
					`area_modified_date` = '".date('Y-m-d H:i:s')."' 
					WHERE `area_id` = :area_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':country_id' => $tdata['country_id'],
				':state_id' => $tdata['state_id'],
				':city_id' => $tdata['city_id'],
				':area_name' => addslashes($tdata['area_name']),
				':area_pincode' => $tdata['area_pincode'],
				':modified_by_admin' => $tdata['admin_id'],
				':status' => $tdata['status'],
				':area_id' => $tdata['area_id'],
            ));
			$DBH->commit();
			
			$return = true;
			
        } catch (Exception $e) {
			$stringData = '[updateArea] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	//items start
	public function GetAllItems($txtsearch='',$status='',$ingredient_id='',$parent_cat_id='',$main_cat_id='',$added_by_admin='',$added_date_type='',$added_days_of_month='',$added_days_of_week='',$added_single_date='',$added_start_date='',$added_end_date='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		if($txtsearch != '')
		{
			$sql_search_str = " AND `item_name` LIKE '%".$txtsearch."%' ";
		}
		
		$sql_status_str = "";
		if($status != '')
		{
			$sql_status_str = " AND `item_status` = '".$status."' ";
		}
		
		$sql_ingredient_id_str = "";
		if($ingredient_id != '')
		{
			$sql_ingredient_id_str = " AND `item_id` IN(SELECT `item_id` FROM `tblitemingredients` WHERE `ingredient_id` = '".$ingredient_id."' AND `iig_deleted` = '0' ) ";
		}
		
		$sql_cat_id_str = "";
		if($parent_cat_id != '' && $main_cat_id != '')
		{
			$sql_cat_id_str = " AND `item_id` IN(select `item_id` from `tblitemcategory` where `ic_cat_parent_id` = '".$parent_cat_id."' AND `ic_cat_id` = '".$main_cat_id."' AND `ic_deleted` = '0' ) ";
		}
		
		$sql_parent_cat_id_str = "";
		if($parent_cat_id != '')
		{
			$sql_parent_cat_id_str = " AND `item_id` IN(select `item_id` from `tblitemcategory` where `ic_cat_parent_id` = '".$parent_cat_id."' AND `ic_deleted` = '0' ) ";
		}
		
		$sql_main_cat_id_str = "";
		if($main_cat_id != '')
		{
			$sql_main_cat_id_str = " AND `item_id` IN(select `item_id` from `tblitemcategory` where `ic_cat_id` = '".$main_cat_id."' AND `ic_deleted` = '0' ) ";
		}
		
		$sql_added_by_admin_str = "";
		if($added_by_admin != '')
		{
			$sql_added_by_admin_str = " AND added_by_admin = '".$added_by_admin."' ";
		}
		
		$sql_add_date_str = "";
		if($added_date_type != '')
		{
			if($added_date_type == 'days_of_month')
			{
				if($added_days_of_month != '' && $added_days_of_month != '-1')
				{
					$sql_add_date_str = " AND DAY(item_add_date) = '".$added_days_of_month."' ";	
				}	
			}
			elseif($added_date_type == 'days_of_week')
			{
				if($added_days_of_week != '' && $added_days_of_week != '-1')
				{
					//In WEEKDAY()  0-Monday,6-Sunday
					$added_days_of_week = $added_days_of_week -1;
					$sql_add_date_str = " AND WEEKDAY(item_add_date) = '".$added_days_of_week."' ";	
				}	
			}
			elseif($added_date_type == 'single_date')
			{
				if($added_single_date != '' && $added_single_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(item_add_date) = '".date('Y-m-d',strtotime($added_single_date))."' ";	
				}	
			}
			elseif($added_date_type == 'date_range')
			{
				if($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(item_add_date) >= '".date('Y-m-d',strtotime($added_start_date))."'  AND DATE(item_add_date) <= '".date('Y-m-d',strtotime($added_end_date))."' ";	
				}	
			}
		}
		
		$sql = "SELECT * FROM `tblitems` WHERE `item_deleted` = '0'  ".$sql_search_str." ".$sql_status_str."  ".$sql_ingredient_id_str." ".$sql_parent_cat_id_str." ".$sql_main_cat_id_str." ".$sql_added_by_admin_str." ".$sql_add_date_str." ORDER BY `item_name` ASC";	
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
	
	public function DeleteItem($id,$admin_id)
    {
	    
		$this->DeleteItemById($id,$admin_id);
		{
			$this->DeleteIngredientsById($id,$admin_id);
			
			$this->DeleteItemCatById($id,$admin_id);
			
			return true;
		}	
		
        return false;   
    }
	
	
	public function GetCategoryID($cat_id,$parent_cat_id)
	{
		$return ='';
		$my_DBH = new DatabaseHandler();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		try {
				$sql = "SELECT * FROM `tblcategories` where `cat_id` = '".$cat_id."' AND `parent_cat_id`= '".$parent_cat_id."' ORDER BY `cat_name` ASC";
				$STH = $DBH->prepare($sql);
				
				$STH->execute();
				$row_count = $STH->rowCount();
				if ($row_count > 0) 
				{
					$r = $STH->fetch(PDO::FETCH_ASSOC);
					
						$return=  '<option value="' . $r['cat_id'] . '" selected>' . $r['cat_name'] . '</option>'; 
						
				}
			return $return;
			} 
		catch (Exception $ex) 
		{
		echo $e->getMessage();
		}
	}
	
	
	
	
	 public function GetCategories($cat_id,$parent_cat_id) 
    {
		$DBH = new DatabaseHandler();
        $option_str = '';
		if($parent_cat_id==='')
			{
			$rowcount=0; 	
			}
        else
			{
			$sql = "SELECT * FROM `tblcategories` where `parent_cat_id` = '".$parent_cat_id."' AND `cat_deleted` = 0  ORDER BY `cat_name` ASC";
			$STH = $DBH->query($sql);
			$rowcount=$STH->rowCount(); 			
			}			
        
        $option_str .= '<option value="">Select Category</option>';
        if ($rowcount> 0) {
            
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
	
	 public function GetCategoriesById($cat_id,$parent_cat_id) 
    {
		$DBH = new DatabaseHandler();
        $option_str = '';
		if($parent_cat_id==='')
			{
			$rowcount=0; 	
			}
        else
			{
			$sql = "SELECT * FROM `tblcategories` where `parent_cat_id` = '".$parent_cat_id."' AND `cat_deleted` = 0  ORDER BY `cat_name` ASC";
			$STH = $DBH->query($sql);
			$rowcount=$STH->rowCount(); 			
			}			
        
        $option_str .= '<option value="">Select Category</option>';
        if ($rowcount> 0) {
            
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
	
	public function chkItemNameExists($item_name)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblitems` WHERE `item_name` = '".$item_name."' AND `item_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addItems($tdata)
    {
		$return = false;
		
		try
		{
			$this->AddItem($tdata);
			
			$item_id = $this->GetLastItemId();
		
			$ing_id = $tdata['ingredient_id'];
			if(is_array($ing_id) && count($ing_id) > 0)
			{
				for($i = 0; $i < count($ing_id); $i++)
				{
					$this->AddIngredient($ing_id[$i],$item_id,$tdata);
				}	
			}
			
		
			$parent = $tdata['parent_cat_id'];
			$cat = $tdata['cat_id'];
			$cat_show = $tdata['cat_show'];
			
			for($c = 0; $c < count($parent); $c++)
			{
				$this->AddItemCat($item_id,$parent[$c],$cat[$c],$tdata['admin_id'],$cat_show[$c]);
			}
				
				$return = true;
		}catch (Exception $e) {
			$stringData = '[addItems] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
		
		 return $return;
		
	}
	
	public function AddItem($tdata)
    {
		
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblitems` (`item_name`,`item_status`,`added_by_admin`,`item_disc1`,`item_disc2`,`item_disc_show1`,`item_disc_show2`,`item_add_date`) 
					VALUES (:item_name,:item_status,:added_by_admin,:item_disc1,:item_disc2,:item_disc_show1,:item_disc_show2,:item_add_date)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':item_name' => $tdata['item_name'],
				':item_status' => '1',
				':added_by_admin' => $tdata['admin_id'],
				':item_disc1' => $tdata['item_disc1'],
				':item_disc2' => $tdata['item_disc2'],
				':item_disc_show1' => $tdata['item_disc_show1'],
				':item_disc_show2' => $tdata['item_disc_show2'],
				':item_add_date' => date('Y-m-d H:i:s')
				
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[AddItem] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function GetLastItemId()
	{
		$return ='';
		$my_DBH = new DatabaseHandler();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		try {
				$sql = "SELECT MAX(`item_id`) as id FROM `tblitems` where `item_deleted`= 0 ";
				$STH = $DBH->prepare($sql);
				
				$STH->execute();
				$row_count = $STH->rowCount();
				if ($row_count > 0) 
				{
					$r = $STH->fetch(PDO::FETCH_ASSOC);
					
						$return=$r['id']; 
						
				}
			return $return;
			} 
		catch (Exception $ex) 
		{
		echo $e->getMessage();
		}
	}
	
	public function AddIngredient($ing_id,$item_id,$tdata)
    {
		
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblitemingredients` (`item_id`,`ingredient_name`,`iig_status`,`added_by_admin`,`ingredient_id`,`iig_add_date`) 
					VALUES (:item_id,:ingredient_name,:iig_status,:added_by_admin,:ingredient_id,:iig_add_date)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':item_id' => $item_id,
				':ingredient_name' => $tdata['ingredient_name'],
				':iig_status' => '1',
				':added_by_admin' => $tdata['admin_id'],
				':ingredient_id' => $ing_id,
				':iig_add_date' => date('Y-m-d H:i:s')
				
            ));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[AddIngredient] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function AddItemCat($item_id,$parent_id,$cat_id,$admin_id,$cat_sh)
    {
		
				$my_DBH = new DatabaseHandler();
				$DBH = $my_DBH->raw_handle();
				$DBH->beginTransaction();
				$return = false;
		
				try {
					$sql = "INSERT INTO `tblitemcategory` (`item_id`,`ic_cat_parent_id`,`ic_cat_id`,`ic_status`,`added_by_admin`,`ic_show`,`ic_add_date`) 
					VALUES (:item_id,:ic_cat_parent_id,:ic_cat_id,:ic_status,:added_by_admin,:ic_show,:ic_add_date)";
					$STH = $DBH->prepare($sql);
					$STH->execute(array(
						':item_id' => $item_id,
						':ic_cat_parent_id' => addslashes($parent_id),
						':ic_cat_id' => addslashes($cat_id),
						':ic_status' => '1',
						':added_by_admin' => $admin_id,
						':ic_show' => $cat_sh,
						':ic_add_date' => date('Y-m-d H:i:s')
				
					));
					$DBH->commit();
					$return = true;
			
				} catch (Exception $e) {
					$stringData = '[AddItemCat] Catch Error:'.$e->getMessage();
					$this->debuglog($stringData);
					return false;
				}
				return $return;
    }
	
	public function getItemDetails($item_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblitems` WHERE `item_id` = '".$item_id."' AND `item_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function getingredientDetails($item_id)
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		
		$sql = "SELECT * FROM `tblitemingredients` WHERE `iig_deleted` = '0' AND `item_id` = '".$item_id."'  ORDER BY `iig_id` ASC";	
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
	
	public function getcategoryDetails($item_id)
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		
		$sql = "SELECT * FROM `tblitemcategory` WHERE `ic_deleted` = '0' AND `item_id` = '".$item_id."'  ORDER BY `ic_id` ASC";	
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
	
	public function chkItemNameExists_edit($item_name,$item_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblitems` WHERE `item_name` = '".$item_name."' AND `item_id` != '".$item_id."' AND `item_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function UpdateItems($tdata)
    {
        
        $return = false;
		
		try {
			
				$this->UpdateItem($tdata);
				
				$this->UpdateIngredient($tdata);
				
				
				$item_id = $tdata['item_id'];
				$ing_id = $tdata['ingredient_id'];
			
				for($i = 0; $i < count($ing_id); $i++)
				{
					$this->AddIngredient($ing_id[$i],$item_id,$tdata);
				}
			
				$this->UpdateCategories($tdata);
			
				$parent = $tdata['parent_cat_id'];
				$cat = $tdata['cat_id'];
				$cat_show = $tdata['cat_show'];
			
				for($c = 0; $c < count($parent); $c++)
				{
					$this->AddItemCat($item_id,$parent[$c],$cat[$c],$tdata['admin_id'],$cat_show[$c]);
				}
			
			$return = true;
			
        } catch (Exception $e) {
			$stringData = '[UpdateItems] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function UpdateItem($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblitems` SET 
					`item_name` = :item_name,
					`item_disc1` = :item_disc1,
					`item_disc2` = :item_disc2,
					`item_disc_show1` = :item_disc_show1,
					`item_disc_show2` = :item_disc_show2,
					`item_status` = :item_status,
					`modified_by_admin` = :modified_by_admin,
					`item_modified_date` = '".date('Y-m-d H:i:s')."' 
					WHERE `item_id` = :item_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':item_name' => addslashes($tdata['item_name']),
				':item_disc1' => $tdata['item_disc1'],
				':item_disc2' => $tdata['item_disc2'],
				':item_disc_show1' => $tdata['item_disc_show1'],
				':item_disc_show2' => $tdata['item_disc_show2'],
				':item_status' => $tdata['item_status'],
				':modified_by_admin' => $tdata['admin_id'],
				':item_id' => $tdata['item_id'],
            ));
			$DBH->commit();
			
			$return = true;
			
        } catch (Exception $e) {
			$stringData = '[UpdateItem] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function UpdateIngredient($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblitemingredients` SET 
					`iig_deleted` = :iig_deleted,
					`modified_by_admin` = :modified_by_admin,
					`iig_modified_date` = '".date('Y-m-d H:i:s')."' 
					WHERE `item_id` = :item_id";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':iig_deleted' => '1',
				':modified_by_admin' => $tdata['admin_id'],
				':item_id' => $tdata['item_id'],
            ));
			$DBH->commit();
			
			$return = true;
			
        } catch (Exception $e) {
			$stringData = '[UpdateIngredient] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function UpdateCategories($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblitemcategory` SET 
					`ic_deleted` = :ic_deleted,
					`modified_by_admin` = :modified_by_admin,
					`ic_modified_date` = '".date('Y-m-d H:i:s')."' 
					WHERE `item_id` = :item_id";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':ic_deleted' => '1',
				':modified_by_admin' => $tdata['admin_id'],
				':item_id' => $tdata['item_id'],
            ));
			$DBH->commit();
			
			$return = true;
			
        } catch (Exception $e) {
			$stringData = '[UpdateIngredient] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function DeleteItemById($id,$admin_id)
    {
	    $return= false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblitems` SET  `item_deleted` = '1', `item_modified_date` = '".date('Y-m-d H:i:s')."' ,`deleted_by_admin` = '".$admin_id."' WHERE `item_id`='".$id."' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
			$return=true;
		}
         return $return;   
    }
	
	public function DeleteIngredientsById($id,$admin_id)
    {
	    $return= false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblitemingredients` SET  `iig_deleted` = '1', `iig_modified_date` = '".date('Y-m-d H:i:s')."' ,`deleted_by_admin` = '".$admin_id."' WHERE `item_id`='".$id."' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
			$return=true;
		}
         return $return;   
    }
	
	public function DeleteItemCatById($id,$admin_id)
    {
	    $return= false;
        $DBH = new DatabaseHandler();
        $sql = "UPDATE `tblitemcategory` SET  `ic_deleted` = '1', `ic_modified_date` = '".date('Y-m-d H:i:s')."' ,`deleted_by_admin` = '".$admin_id."' WHERE `item_id`='".$id."' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
			$return=true;
		}
         return $return;   
    }
	
	
	public function GetIngredientsById($item_id) 
    {
		$it = implode(',' , $item_id);
        $DBH = new DatabaseHandler();
        $option_str = '';
		$sql = "SELECT * FROM `tblitems` WHERE item_deleted = '0' AND  `item_id` IN(select `item_id` from `tblitemcategory` where `ic_cat_id` = '54' AND ic_deleted = '0' ORDER BY ic_add_date ASC) ORDER BY item_name ASC ";
		$STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {

                if (in_array($row['item_id'] ,$item_id)) {
                    $option_str .= '<option value="' . $row['item_id'] . '" selected>' . $row['item_name'] . '</option>';
                } else {
                    $option_str .= '<option value="' . $row['item_id'] . '">' . $row['item_name'] . '</option>';
                }
            }
            return $option_str;
        } else {
            return $option_str;
        }
    }
	
	
	//Manage Cusines - Start
	public function getAllCusines($txtsearch='',$status='',$cucat_parent_cat_id='',$cucat_cat_id='',$vendor_id='',$added_by_admin='',$added_date_type='',$added_days_of_month='',$added_days_of_week='',$added_single_date='',$added_start_date='',$added_end_date='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		if($txtsearch != '')
		{
			$sql_search_str = " AND TBI.item_name LIKE '%".$txtsearch."%' ";
		}
		
		$sql_status_str = "";
		if($status != '')
		{
			$sql_status_str = " AND TBC.cusine_status = '".$status."' ";
		}
		
		$sql_leftjoin_cucat = "";
		$sql_cucat_parent_cat_id_str = "";
		$sql_cucat_cat_id_str = "";
		if($cucat_parent_cat_id != '')
		{
			$sql_leftjoin_cucat = " LEFT JOIN `tblcusinecategory` AS TCC ON TBC.cusine_id = TCL.cusine_id ";
			$sql_cucat_parent_cat_id_str = " AND TCC.cucat_parent_cat_id = '".$cucat_parent_cat_id."' AND TCC.cucat_deleted = '0' ";
			
			if($cucat_cat_id != '')
			{
				$sql_cucat_cat_id_str = " AND TCC.cucat_cat_id = '".$cucat_cat_id."' ";
			}
		}
		
		$sql_vendor_id_str = "";
		if($vendor_id != '')
		{
			$sql_vendor_id_str = " AND TBC.vendor_id = '".$vendor_id."' ";
		}
		
		$sql_added_by_admin_str = "";
		if($added_by_admin != '')
		{
			$sql_added_by_admin_str = " AND TBC.added_by_admin = '".$added_by_admin."' ";
		}
		
		$sql_add_date_str = "";
		if($added_date_type != '')
		{
			if($added_date_type == 'days_of_month')
			{
				if($added_days_of_month != '' && $added_days_of_month != '-1')
				{
					$sql_add_date_str = " AND DAY(TBC.cusine_add_date) = '".$added_days_of_month."' ";	
				}	
			}
			elseif($added_date_type == 'days_of_week')
			{
				if($added_days_of_week != '' && $added_days_of_week != '-1')
				{
					//In WEEKDAY()  0-Monday,6-Sunday
					$added_days_of_week = $added_days_of_week -1;
					$sql_add_date_str = " AND WEEKDAY(TBC.cusine_add_date) = '".$added_days_of_week."' ";	
				}	
			}
			elseif($added_date_type == 'single_date')
			{
				if($added_single_date != '' && $added_single_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(TBC.cusine_add_date) = '".date('Y-m-d',strtotime($added_single_date))."' ";	
				}	
			}
			elseif($added_date_type == 'date_range')
			{
				if($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(TBC.cusine_add_date) >= '".date('Y-m-d',strtotime($added_start_date))."'  AND DATE(TBC.cusine_add_date) <= '".date('Y-m-d',strtotime($added_end_date))."' ";	
				}	
			}
		}
		
		$sql = "SELECT TBC.*,TCL.cusine_price,TCL.cusine_qty, TBI.item_name, TBV.vendor_name 
				FROM `tblcusines` AS TBC 
				LEFT JOIN `tblcusinelocations` AS TCL ON TBC.cusine_id = TCL.cusine_id
				".$sql_leftjoin_cucat."
				LEFT JOIN `tblitems` AS TBI ON TBC.item_id = TBI.item_id
				LEFT JOIN `tblvendors` AS TBV ON TBC.vendor_id = TBV.vendor_id
				WHERE TBC.cusine_deleted = '0' AND TCL.culoc_deleted = '0' AND TCL.default_price = '1'  ".$sql_search_str." ".$sql_status_str." ".$sql_cucat_parent_cat_id_str." ".$sql_cucat_cat_id_str." ".$sql_vendor_id_str." ".$sql_added_by_admin_str." ".$sql_add_date_str."  ORDER BY TBI.item_name ASC, TBC.cusine_add_date DESC";	
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
	
	public function getCommaSeperatedIngredientsOfItem($item_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		try {
			$sql = "SELECT ingredient_id FROM `tblitemingredients` WHERE `item_id` = '".$item_id."' AND `iig_deleted` = '0' ORDER BY ingredient_id ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$output .= stripslashes($this->GetItemName($r['ingredient_id'])).',';
				}
				$output = substr($output,0,-1);
			}
		} catch (Exception $e) {
			$stringData = '[getCommaSeperatedIngredients] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }			
		return $output;
	}
	
	public function GetItemName($item_id)
	{
		$return ='';
		$my_DBH = new DatabaseHandler();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		try {
				$sql = "SELECT `item_name` FROM `tblitems` where `item_id`= '".$item_id."' ";
				$STH = $DBH->prepare($sql);
				
				$STH->execute();
				$row_count = $STH->rowCount();
				if ($row_count > 0) 
				{
					$r = $STH->fetch(PDO::FETCH_ASSOC);
					
						$return=$r['item_name']; 
						
				}
			return $return;
			} 
		catch (Exception $ex) 
		{
		echo $e->getMessage();
		}
	}
	
	public function getCategoryListingOfItem($item_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		try {
			$sql = "SELECT TC1.cat_name AS parent_cat_name, TC2.cat_name AS main_cat_name FROM `tblitemcategory` AS TIC 
					LEFT JOIN `tblcategories` AS TC1 ON TIC.ic_cat_parent_id = TC1.cat_id 
					LEFT JOIN `tblcategories` AS TC2 ON TIC.ic_cat_id = TC2.cat_id
					WHERE TIC.item_id = '".$item_id."' AND TIC.ic_deleted = '0' ORDER BY TIC.ic_add_date ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$output .= stripslashes($r['parent_cat_name']).' : '.stripslashes($r['main_cat_name']).',<br>';
				}
				$output = substr($output,0,-5);
			}
		} catch (Exception $e) {
			$stringData = '[getCategoryListingOfItem] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }			
		return $output;
	}
	
	public function getItemOption($item_id,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Items</option>';
		}
		else
		{
			$output .= '<option value="" >Select Item</option>';
		}
		
		try {
			$sql = "SELECT item_id,item_name FROM `tblitems` WHERE `item_deleted` = '0' AND `item_id` NOT IN (SELECT DISTINCT(item_id) FROM `tblitemcategory` WHERE `ic_deleted` = '0' AND `ic_cat_id` = '54' ) ORDER BY item_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['item_id'] == $item_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['item_id'].'" '.$selected.'>'.stripslashes($r['item_name']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getItemOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }			
		return $output;
	}
	
	public function getVendorOption($vendor_id,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Vendors</option>';
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
					if($r['vendor_id'] == $vendor_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
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
	
	public function getVendorLocationOption($vendor_id,$vloc_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $vloc_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Locations</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Locations</option>';
			}
			
		}
		else
		{
			$output .= '<option value="" >Select Location</option>';
		}
		
		$go_ahead = true;
		$vendor_sql_str = "";
		if($multiple == '1')
		{
			if(is_array($vendor_id) && count($vendor_id) > 0)
			{
				if(in_array('-1', $vendor_id))
				{
					
				}
				else
				{
					$vendor_str = implode(',',$vendor_id);
					$vendor_sql_str = " AND TVL.vendor_id IN (".$vendor_str.")";
				}
			}
			else
			{
				if($vendor_id != '' && $vendor_id != 0)
				{
					$vendor_sql_str = " AND TVL.vendor_id = '".$vendor_id."' ";	
				}
				else
				{
					$go_ahead = false;	
				}
			}
			
		}
		else
		{
			if($vendor_id != '' && $vendor_id != 0)
			{
				$vendor_sql_str = " AND TVL.vendor_id = '".$vendor_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
		}
		
		if($go_ahead)
		{
			try {
				$sql = "SELECT TVL.vloc_id,TAR.area_name,TCT.city_name,TST.state_name,TCN.country_name FROM `tblvendorlocations` AS TVL
						LEFT JOIN `tblcountry` AS TCN ON TVL.country_id = TCN.country_id 
						LEFT JOIN `tblstates` AS TST ON TVL.state_id = TST.state_id 
						LEFT JOIN `tblcities` AS TCT ON TVL.city_id = TCT.city_id 
						LEFT JOIN `tblarea` AS TAR ON TVL.area_id = TAR.area_id 
						WHERE TVL.vloc_deleted = '0' ".$vendor_sql_str." ORDER BY TAR.area_name ASC, TCT.city_name ASC, TST.state_name ASC, TCN.country_name ASC";	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{
						if($multiple == '1')
						{
							if(is_array($vloc_id) && in_array($r['vloc_id'], $vloc_id))
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
							if($r['vloc_id'] == $vloc_id )
							{
								$selected = ' selected ';	
							}
							else
							{
								$selected = '';	
							}
						}
						$output .= '<option value="'.$r['vloc_id'].'" '.$selected.'>'.stripslashes($r['area_name']).', '.stripslashes($r['city_name']).', '.stripslashes($r['state_name']).', '.stripslashes($r['country_name']).'</option>';
					}
				}
			} catch (Exception $e) {
				$stringData = '[getVendorLocationOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
				$this->debuglog($stringData);
				return $output;
			}	
		}	
		return $output;
	}
	
	public function getServingTypeOption($serving_type_id,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Type</option>';
		}
		else
		{
			$output .= '<option value="" >Select Type</option>';
		}
		
		try {
			$sql = "SELECT cat_id as serving_type_id, cat_name as serving_type FROM `tblcategories` WHERE `parent_cat_id` = '61' AND `cat_deleted` = '0' ORDER BY serving_type ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['serving_type_id'] == $serving_type_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['serving_type_id'].'" '.$selected.'>'.stripslashes($r['serving_type']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getServingTypeOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getServingSizeOption($serving_size_id,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Size</option>';
		}
		else
		{
			$output .= '<option value="" >Select Size</option>';
		}
		
		try {
			$sql = "SELECT cat_id as serving_size_id, cat_name as serving_size FROM `tblcategories` WHERE `parent_cat_id` = '76' AND `cat_deleted` = '0' ORDER BY serving_size ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['serving_size_id'] == $serving_size_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['serving_size_id'].'" '.$selected.'>'.stripslashes($r['serving_size']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getServingSizeOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getMainProfileOption($cat_id,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Main Profiles</option>';
		}
		else
		{
			$output .= '<option value="" >Select Main Profile</option>';
		}
		
		try {
			$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '0' AND `cat_deleted` = '0' ORDER BY cat_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['cat_id'] == $cat_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['cat_id'].'" '.$selected.'>'.stripslashes($r['cat_name']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getMainProfileOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getMainCategoryOption($parent_cat_id,$cat_id,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Categories</option>';
		}
		else
		{
			$output .= '<option value="" >Select Category</option>';
		}
		
		try {
			if($parent_cat_id != '')
			{
				$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '".$parent_cat_id."' AND `cat_deleted` = '0' ORDER BY cat_name ASC";	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{
						if($r['cat_id'] == $cat_id )
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
						$output .= '<option value="'.$r['cat_id'].'" '.$selected.'>'.stripslashes($r['cat_name']).'</option>';
					}
				}
			}
		} catch (Exception $e) {
			$stringData = '[getMainCategoryOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getShowHideOption($val,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Options</option>';
		}
		else
		{
			$output .= '<option value="" >Select Option</option>';
		}
		
		
		if($val == '1' )
		{
			$selected = ' selected ';	
		}
		else
		{
			$selected = '';	
		}
		$output .= '<option value="1" '.$selected.'>Show</option>';
		
		if($val == '0' )
		{
			$selected = ' selected ';	
		}
		else
		{
			$selected = '';	
		}
		$output .= '<option value="0" '.$selected.'>Hide</option>';
					
		return $output;
	}
	
	public function getDefaultPriceOption($val,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Options</option>';
		}
		else
		{
			$output .= '<option value="" >Select Option</option>';
		}
		
		
		if($val == '1' )
		{
			$selected = ' selected ';	
		}
		else
		{
			$selected = '';	
		}
		$output .= '<option value="1" '.$selected.'>Yes</option>';
		
		if($val == '0' )
		{
			$selected = ' selected ';	
		}
		else
		{
			$selected = '';	
		}
		$output .= '<option value="0" '.$selected.'>No</option>';
					
		return $output;
	}
	
	public function getCountryOption($country_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $country_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Countries</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Countries</option>';
			}
			
		}
		else
		{
			$output .= '<option value="" >Select Country</option>';
		}
		
		try {
			$sql = "SELECT country_id,country_name FROM `tblcountry` WHERE `country_deleted` = '0' ORDER BY country_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($multiple == '1')
					{
						if(in_array($r['country_id'], $country_id))
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
						if($r['country_id'] == $country_id )
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					
					$output .= '<option value="'.$r['country_id'].'" '.$selected.'>'.stripslashes($r['country_name']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getCountryOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getStateOption($country_id,$state_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $state_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All States</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All States</option>';
			}
		}
		else
		{
			$output .= '<option value="" >Select State</option>';
		}
		
		$go_ahead = true;
		$country_sql_str = "";
		if($multiple == '1')
		{
			if(is_array($country_id) && count($country_id) > 0)
			{
				if(in_array('-1', $country_id))
				{
					
				}
				else
				{
					$country_str = implode(',',$country_id);
					$country_sql_str = " AND country_id IN (".$country_str.")";
				}
			}
			else
			{
				$go_ahead = false;	
			}
			
		}
		else
		{
			if($country_id != '' && $country_id != 0)
			{
				$country_sql_str = " AND country_id = '".$country_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
		}
		
		if($go_ahead)
		{
			try {
				$sql = "SELECT state_id,state_name FROM `tblstates` WHERE `state_deleted` = '0' ".$country_sql_str." ORDER BY state_name ASC";	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{
						if($multiple == '1')
						{
							if(is_array($state_id) && in_array($r['state_id'], $state_id))
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
							if($r['state_id'] == $state_id )
							{
								$selected = ' selected ';	
							}
							else
							{
								$selected = '';	
							}
						}
						
						$output .= '<option value="'.$r['state_id'].'" '.$selected.'>'.stripslashes($r['state_name']).'</option>';
					}
				}
			} catch (Exception $e) {
				$stringData = '[getStateOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
				$this->debuglog($stringData);
				return $output;
			}		
		}
		
		return $output;
	}
	
	public function getCityOption($country_id,$state_id,$city_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $city_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Cities</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Cities</option>';
			}
		}
		else
		{
			$output .= '<option value="" >Select City</option>';
		}
		
		$go_ahead = true;
		$state_sql_str = "";
		$country_sql_str = "";
		if($multiple == '1')
		{
			if(is_array($country_id) && count($country_id) > 0)
			{
				if(in_array('-1', $country_id))
				{
					
				}
				else
				{
					$country_str = implode(',',$country_id);
					$country_sql_str = " AND country_id IN (".$country_str.")";
				}
				
				if(is_array($state_id) && count($state_id) > 0)
				{
					if(in_array('-1', $state_id))
					{
						
					}
					else
					{
						$state_str = implode(',',$state_id);
						$state_sql_str = " AND state_id IN (".$state_str.")";
					}
				}
				else
				{
					$go_ahead = false;	
				}
			}
			else
			{
				$go_ahead = false;
			}
		}
		else
		{
			if($country_id != '' && $country_id != 0)
			{
				$country_sql_str = " AND country_id = '".$country_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
			
			if($state_id != '' && $state_id != 0)
			{
				$state_sql_str = " AND state_id = '".$state_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
		}
		
		if($go_ahead)
		{
			try {
				$sql = "SELECT city_id,city_name FROM `tblcities` WHERE `city_deleted` = '0' ".$country_sql_str." ".$state_sql_str." ORDER BY city_name ASC";	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{
						if($multiple == '1')
						{
							if(is_array($city_id) && in_array($r['city_id'], $city_id))
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
							if($r['city_id'] == $city_id )
							{
								$selected = ' selected ';	
							}
							else
							{
								$selected = '';	
							}
						}
						
						$output .= '<option value="'.$r['city_id'].'" '.$selected.'>'.stripslashes($r['city_name']).'</option>';
					}
				}
			} catch (Exception $e) {
				$stringData = '[getCityOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
				$this->debuglog($stringData);
				return $output;
			}		
		}
		
		return $output;
	}
	
	public function getAreaOption($country_id,$state_id,$city_id,$area_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $area_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Areas</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Areas</option>';
			}
			
		}
		else
		{
			$output .= '<option value="" >Select Area</option>';
		}
		
		$go_ahead = true;
		$city_sql_str = "";
		$state_sql_str = "";
		$country_sql_str = "";
		if($multiple == '1')
		{
			if(is_array($country_id) && count($country_id) > 0)
			{
				if(in_array('-1', $country_id))
				{
					
				}
				else
				{
					$country_str = implode(',',$country_id);
					$country_sql_str = " AND country_id IN (".$country_str.")";
				}
				
				if(is_array($state_id) && count($state_id) > 0)
				{
					if(in_array('-1', $state_id))
					{
						
					}
					else
					{
						$state_str = implode(',',$state_id);
						$state_sql_str = " AND state_id IN (".$state_str.")";
					}
				}
				else
				{
					$go_ahead = false;	
				}
				
				if(is_array($city_id) && count($city_id) > 0)
				{
					if(in_array('-1', $city_id))
					{
						
					}
					else
					{
						$city_str = implode(',',$city_id);
						$city_sql_str = " AND city_id IN (".$city_str.")";
					}
				}
				else
				{
					$go_ahead = false;	
				}
			}
			else
			{
				$go_ahead = false;
			}
		}
		else
		{
			if($country_id != '' && $country_id != 0)
			{
				$country_sql_str = " AND country_id = '".$country_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
			
			if($state_id != '' && $state_id != 0)
			{
				$state_sql_str = " AND state_id = '".$state_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
			
			if($city_id != '' && $city_id != 0)
			{
				$city_sql_str = " AND city_id = '".$city_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
		}
		
		if($go_ahead)
		{
			try {
				$sql = "SELECT area_id,area_name FROM `tblarea` WHERE `area_deleted` = '0' ".$country_sql_str." ".$state_sql_str." ".$city_sql_str." ORDER BY area_name ASC";	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{
						if($multiple == '1')
						{
							if(is_array($area_id) && in_array($r['area_id'], $area_id))
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
							if($r['area_id'] == $area_id )
							{
								$selected = ' selected ';	
							}
							else
							{
								$selected = '';	
							}
						}
						
						$output .= '<option value="'.$r['area_id'].'" '.$selected.'>'.stripslashes($r['area_name']).'</option>';
					}
				}
			} catch (Exception $e) {
				$stringData = '[getAreaOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
				$this->debuglog($stringData);
				return $output;
			}		
		}
		
		return $output;
	}
	
	public function getDateTypeOption($date_type)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		$output .= '<option value="" >Select Date Type</option>';
		try {
			$sql = "SELECT date_type,date_type_title FROM `tbldatetype` WHERE `dt_deleted` = '0' ORDER BY dt_id ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['date_type'] == $date_type )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['date_type'].'" '.$selected.'>'.stripslashes($r['date_type_title']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getDateTypeOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getDaysOfMonthOption($days_of_month,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $days_of_month))
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
				$selected = '';	
			}
			$output .= '<option value="-1" '.$selected.' >All Days</option>';
		}
		else
		{
			$output .= '<option value="" >Select Day</option>';
		}
		
		
		for($i=1;$i<=31;$i++)
		{
			if($multiple == '1')
			{
				if(in_array($i, $days_of_month))
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
				if($i == $days_of_month )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
			}
			
			$output .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
		}
			
		
		return $output;
	}
	
	public function getDaysOfWeekOption($days_of_week,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $days_of_week))
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
				$selected = '';	
			}
			$output .= '<option value="-1" '.$selected.' >All Days</option>';
		}
		else
		{
			$output .= '<option value="" >Select Day</option>';
		}
		
		$arr_day = array( 	"1" => "Monday",
							"2" => "Tuesday",
							"3" => "Wednesday",
							"4" => "Thursday",
							"5" => "Friday",
							"6" => "Saturday",
							"7" => "Sunday"
						);
		foreach($arr_day as $key => $val)
		{
			if($multiple == '1')
			{
				if(in_array($key, $days_of_week))
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
				if($key == $days_of_week )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
			}
			
			$output .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
		}
			
		
		return $output;
	}
	
	public function addCusineCategory($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblcusinecategory` (`cusine_id`,`cucat_parent_cat_id`,`cucat_cat_id`,`cucat_show`,`cucat_status`,`cucat_add_date`,`added_by_admin`) 
					VALUES (:cusine_id,:cucat_parent_cat_id,:cucat_cat_id,:cucat_show,:cucat_status,:cucat_add_date,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':cusine_id' => addslashes($tdata['cusine_id']),
				':cucat_parent_cat_id' => addslashes($tdata['cucat_parent_cat_id']),
				':cucat_cat_id' => addslashes($tdata['cucat_cat_id']),
				':cucat_show' => addslashes($tdata['cucat_show']),
				':cucat_status' => addslashes($tdata['cucat_status']),
				':cucat_add_date' => date('Y-m-d H:i:s'),
				':added_by_admin' =>$tdata['added_by_admin']
			));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addCusineCategory] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function addCusineLocation($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblcusinelocations` (`cusine_id`,`vendor_id`,`vloc_id`,`ordering_type_id`,`ordering_size_id`,`max_order`,`min_order`,
					`cusine_qty`,`currency_id`,`cusine_price`,`default_price`,`culoc_status`,`culoc_add_date`,`added_by_admin`) 
					VALUES (:cusine_id,:vendor_id,:vloc_id,:ordering_type_id,:ordering_size_id,:max_order,:min_order,
					:cusine_qty,:currency_id,:cusine_price,:default_price,:culoc_status,:culoc_add_date,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':cusine_id' => addslashes($tdata['cusine_id']),
				':vendor_id' => addslashes($tdata['vendor_id']),
				':vloc_id' => addslashes($tdata['vloc_id']),
				':ordering_type_id' => addslashes($tdata['ordering_type_id']),
				':ordering_size_id' => addslashes($tdata['ordering_size_id']),
				':max_order' => addslashes($tdata['max_order']),
				':min_order' => addslashes($tdata['min_order']),
				':cusine_qty' => addslashes($tdata['cusine_qty']),
				':currency_id' => addslashes($tdata['currency_id']),
				':cusine_price' => addslashes($tdata['cusine_price']),
				':default_price' => addslashes($tdata['default_price']),
				':culoc_status' => addslashes($tdata['culoc_status']),
				':culoc_add_date' => date('Y-m-d H:i:s'),
				':added_by_admin' =>$tdata['added_by_admin']
			));
			$DBH->commit();
			$return = true;
			
		} catch (Exception $e) {
			$stringData = '[addCusineLocation] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function addCusine($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblcusines` (`item_id`,`vendor_id`,`cusine_image`,
					`cusine_country_id`,`cusine_state_id`,`cusine_city_id`,`cusine_area_id`,`publish_date_type`,`publish_days_of_month`,`publish_days_of_week`,
					`publish_single_date`,`publish_start_date`,`publish_end_date`,`delivery_date_type`,`delivery_days_of_month`,`delivery_days_of_week`,
					`delivery_single_date`,`delivery_start_date`,`delivery_end_date`,`cusine_desc_1`,`cusine_desc_show_1`,`cusine_desc_2`,`cusine_desc_show_2`,
					`cusine_status`,`cusine_add_date`,`added_by_admin`) 
					VALUES (:item_id,:vendor_id,:cusine_image,
					:cusine_country_id,:cusine_state_id,:cusine_city_id,:cusine_area_id,:publish_date_type,:publish_days_of_month,:publish_days_of_week,
					:publish_single_date,:publish_start_date,:publish_end_date,:delivery_date_type,:delivery_days_of_month,:delivery_days_of_week,
					:delivery_single_date,:delivery_start_date,:delivery_end_date,:cusine_desc_1,:cusine_desc_show_1,:cusine_desc_2,:cusine_desc_show_2,
					:cusine_status,:cusine_add_date,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':item_id' => addslashes($tdata['item_id']),
				':vendor_id' => addslashes($tdata['vendor_id']),
				':cusine_image' => addslashes($tdata['cusine_image']),
				':cusine_country_id' => addslashes($tdata['cusine_country_id']),
				':cusine_state_id' => addslashes($tdata['cusine_state_id']),
				':cusine_city_id' => addslashes($tdata['cusine_city_id']),
				':cusine_area_id' => addslashes($tdata['cusine_area_id']),
				':publish_date_type' => addslashes($tdata['publish_date_type']),
				':publish_days_of_month' => addslashes($tdata['publish_days_of_month']),
				':publish_days_of_week' => addslashes($tdata['publish_days_of_week']),
				':publish_single_date' => addslashes($tdata['publish_single_date']),
				':publish_start_date' => addslashes($tdata['publish_start_date']),
				':publish_end_date' => addslashes($tdata['publish_end_date']),
				':delivery_date_type' => addslashes($tdata['delivery_date_type']),
				':delivery_days_of_month' => addslashes($tdata['delivery_days_of_month']),
				':delivery_days_of_week' => addslashes($tdata['delivery_days_of_week']),
				':delivery_single_date' => addslashes($tdata['delivery_single_date']),
				':delivery_start_date' => addslashes($tdata['delivery_start_date']),
				':delivery_end_date' => addslashes($tdata['delivery_end_date']),
				':cusine_desc_1' => addslashes($tdata['cusine_desc_1']),
				':cusine_desc_show_1' => addslashes($tdata['cusine_desc_show_1']),
				':cusine_desc_2' => addslashes($tdata['cusine_desc_2']),
				':cusine_desc_show_2' => addslashes($tdata['cusine_desc_show_2']),
				':cusine_status' => addslashes($tdata['cusine_status']),
				':cusine_add_date' => date('Y-m-d H:i:s'),
				':added_by_admin' =>$tdata['added_by_admin']
			));
			$cusine_id = $DBH->lastInsertId();
			$DBH->commit();
			
			if($cusine_id > 0)
			{
				$return = true;
				if(count($tdata['vloc_id']) > 0)
				{
					for($i=0;$i<count($tdata['vloc_id']);$i++)
					{
						$tdata_loc = array();
						$tdata_loc['cusine_id'] = $cusine_id;
						$tdata_loc['vendor_id'] = $tdata['vendor_id'];
						$tdata_loc['vloc_id'] = $tdata['vloc_id'][$i];
						$tdata_loc['ordering_type_id'] = $tdata['ordering_type_id'][$i];
						$tdata_loc['ordering_size_id'] = $tdata['ordering_size_id'][$i];
						$tdata_loc['max_order'] = $tdata['max_order'][$i];
						$tdata_loc['min_order'] = $tdata['min_order'][$i];
						$tdata_loc['cusine_qty'] = $tdata['cusine_qty'][$i];
						$tdata_loc['currency_id'] = $tdata['currency_id'][$i];
						$tdata_loc['cusine_price'] = $tdata['cusine_price'][$i];
						$tdata_loc['default_price'] = $tdata['default_price'][$i];
						$tdata_loc['culoc_status'] = 1;
						$tdata_loc['added_by_admin'] = $tdata['added_by_admin'];
						$this->addCusineLocation($tdata_loc);		
					}
				}
				
				if(count($tdata['cucat_parent_cat_id']) > 0)
				{
					for($i=0;$i<count($tdata['cucat_parent_cat_id']);$i++)
					{
						$tdata_cat = array();
						$tdata_cat['cusine_id'] = $cusine_id;
						$tdata_cat['cucat_parent_cat_id'] = $tdata['cucat_parent_cat_id'][$i];
						$tdata_cat['cucat_cat_id'] = $tdata['cucat_cat_id'][$i];
						$tdata_cat['cucat_show'] = $tdata['cucat_show'][$i];
						$tdata_cat['cucat_status'] = 1;
						$tdata_cat['added_by_admin'] = $tdata['added_by_admin'];
						$this->addCusineCategory($tdata_cat);		
					}
				}
			}
			
		} catch (Exception $e) {
			$stringData = '[addCusine] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getCategoryListingOfCusine($cusine_id)
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		try {
			$sql = "SELECT TC1.cat_name AS parent_cat_name, TC2.cat_name AS main_cat_name FROM `tblcusinecategory` AS TIC 
					LEFT JOIN `tblcategories` AS TC1 ON TIC.cucat_parent_cat_id = TC1.cat_id 
					LEFT JOIN `tblcategories` AS TC2 ON TIC.cucat_cat_id = TC2.cat_id
					WHERE TIC.cusine_id = '".$cusine_id."' AND TIC.cucat_deleted = '0' ORDER BY TIC.cucat_add_date ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					$output .= stripslashes($r['parent_cat_name']).' : '.stripslashes($r['main_cat_name']).',<br>';
				}
				$output = substr($output,0,-5);
			}
		} catch (Exception $e) {
			$stringData = '[getCategoryListingOfCusine] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }			
		return $output;
	}
	
	public function getCusineDetails($cusine_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblcusines` WHERE `cusine_id` = '".$cusine_id."' AND `cusine_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function getCusineAllCategory($cusine_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblcusinecategory` WHERE `cusine_id` = '".$cusine_id."' AND `cucat_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            while($r = $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_record[] = $r;	
			}
            
        }	

        return $arr_record;
    }
	
	public function getCusineAllLocation($cusine_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblcusinelocations` WHERE `cusine_id` = '".$cusine_id."' AND `culoc_deleted` = '0' ORDER BY default_price DESC, culoc_add_date ASC ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            while($r = $STH->fetch(PDO::FETCH_ASSOC))
			{
				$arr_record[] = $r;	
			}
            
        }	

        return $arr_record;
    }
	
	public function deleteCusine($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblcusines` SET 
					`cusine_deleted` = :cusine_deleted,
					`cusine_modified_date` = :cusine_modified_date,  
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `cusine_id` = :cusine_id AND `cusine_deleted` != '1' ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':cusine_deleted' => '1',
				':cusine_modified_date' => date('Y-m-d H:i:s'),
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':cusine_id' => $tdata['cusine_id']
            ));
			$DBH->commit();
			$return = true;
			$this->deleteCusineCategoryByCusineId($tdata);
			$this->deleteCusineLocationByCusineId($tdata);
		} catch (Exception $e) {
			$stringData = '[deleteCusine] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function deleteCusineCategoryByCusineId($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblcusinecategory` SET 
					`cucat_deleted` = :cucat_deleted,
					`cucat_modified_date` = :cucat_modified_date,
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `cusine_id` = :cusine_id AND `cucat_deleted` != '1' ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':cucat_deleted' => '1',
				':cucat_modified_date' => date('Y-m-d H:i:s'),
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':cusine_id' => $tdata['cusine_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteCusineCategoryByCusineId] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function deleteCusineLocationByCusineId($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblcusinelocations` SET 
					`culoc_deleted` = :culoc_deleted,
					`culoc_modified_date` = :culoc_modified_date,
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `cusine_id` = :cusine_id AND `culoc_deleted` != '1' ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':culoc_deleted' => '1',
				':culoc_modified_date' => date('Y-m-d H:i:s'),
				':deleted_by_admin' => $tdata['deleted_by_admin'],
				':cusine_id' => $tdata['cusine_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteCusineLocationByCusineId] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function updateCusine($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblcusines` SET 
					`item_id` = :item_id,
					`vendor_id` = :vendor_id,
					`cusine_image` = :cusine_image,
					`cusine_country_id` = :cusine_country_id,
					`cusine_state_id` = :cusine_state_id,
					`cusine_city_id` = :cusine_city_id,
					`cusine_area_id` = :cusine_area_id,
					`publish_date_type` = :publish_date_type,
					`publish_days_of_month` = :publish_days_of_month,
					`publish_days_of_week` = :publish_days_of_week,
					`publish_single_date` = :publish_single_date,
					`publish_start_date` = :publish_start_date,
					`publish_end_date` = :publish_end_date,
					`delivery_date_type` = :delivery_date_type,
					`delivery_days_of_month` = :delivery_days_of_month,
					`delivery_days_of_week` = :delivery_days_of_week,
					`delivery_single_date` = :delivery_single_date,
					`delivery_start_date` = :delivery_start_date,
					`delivery_end_date` = :delivery_end_date,
					`cusine_desc_1` = :cusine_desc_1,
					`cusine_desc_show_1` = :cusine_desc_show_1,
					`cusine_desc_2` = :cusine_desc_2,
					`cusine_desc_show_2` = :cusine_desc_show_2,
					`cusine_status` = :cusine_status,
					`cusine_modified_date` = :cusine_modified_date,  
					`modified_by_admin` = :modified_by_admin  
					WHERE `cusine_id` = :cusine_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':item_id' => addslashes($tdata['item_id']),
				':vendor_id' => addslashes($tdata['vendor_id']),
				':cusine_image' => addslashes($tdata['cusine_image']),
				':cusine_country_id' => addslashes($tdata['cusine_country_id']),
				':cusine_state_id' => addslashes($tdata['cusine_state_id']),
				':cusine_city_id' => addslashes($tdata['cusine_city_id']),
				':cusine_area_id' => addslashes($tdata['cusine_area_id']),
				':publish_date_type' => addslashes($tdata['publish_date_type']),
				':publish_days_of_month' => addslashes($tdata['publish_days_of_month']),
				':publish_days_of_week' => addslashes($tdata['publish_days_of_week']),
				':publish_single_date' => addslashes($tdata['publish_single_date']),
				':publish_start_date' => addslashes($tdata['publish_start_date']),
				':publish_end_date' => addslashes($tdata['publish_end_date']),
				':delivery_date_type' => addslashes($tdata['delivery_date_type']),
				':delivery_days_of_month' => addslashes($tdata['delivery_days_of_month']),
				':delivery_days_of_week' => addslashes($tdata['delivery_days_of_week']),
				':delivery_single_date' => addslashes($tdata['delivery_single_date']),
				':delivery_start_date' => addslashes($tdata['delivery_start_date']),
				':delivery_end_date' => addslashes($tdata['delivery_end_date']),
				':cusine_desc_1' => addslashes($tdata['cusine_desc_1']),
				':cusine_desc_show_1' => addslashes($tdata['cusine_desc_show_1']),
				':cusine_desc_2' => addslashes($tdata['cusine_desc_2']),
				':cusine_desc_show_2' => addslashes($tdata['cusine_desc_show_2']),
				':cusine_status' => addslashes($tdata['cusine_status']),
				':cusine_modified_date' => date('Y-m-d H:i:s'),
				':modified_by_admin' => $tdata['modified_by_admin'],
				':cusine_id' => $tdata['cusine_id']
            ));
			$DBH->commit();
			$return = true;
			
			$tdata_del_cat = array();
			$tdata_del_cat['cusine_id'] = $tdata['cusine_id'];
			$tdata_del_cat['deleted_by_admin'] = $tdata['modified_by_admin'];
			$this->deleteCusineCategoryByCusineId($tdata_del_cat);		
			
			if(count($tdata['cucat_parent_cat_id']) > 0)
			{
				for($i=0;$i<count($tdata['cucat_parent_cat_id']);$i++)
				{
					$tdata_cat = array();
					$tdata_cat['cusine_id'] = $tdata['cusine_id'];
					$tdata_cat['cucat_parent_cat_id'] = $tdata['cucat_parent_cat_id'][$i];
					$tdata_cat['cucat_cat_id'] = $tdata['cucat_cat_id'][$i];
					$tdata_cat['cucat_show'] = $tdata['cucat_show'][$i];
					$tdata_cat['cucat_status'] = 1;
					$tdata_cat['added_by_admin'] = $tdata['modified_by_admin'];
					$this->addCusineCategory($tdata_cat);		
				}
			}
			
			$tdata_del_loc = array();
			$tdata_del_loc['cusine_id'] = $tdata['cusine_id'];
			$tdata_del_loc['deleted_by_admin'] = $tdata['modified_by_admin'];
			$this->deleteCusineLocationByCusineId($tdata_del_loc);		
			
			for($i=0;$i<count($tdata['vloc_id']);$i++)
			{
				$tdata_loc = array();
				$tdata_loc['cusine_id'] = $tdata['cusine_id'];
				$tdata_loc['vendor_id'] = $tdata['vendor_id'];
				$tdata_loc['vloc_id'] = $tdata['vloc_id'][$i];
				$tdata_loc['ordering_type_id'] = $tdata['ordering_type_id'][$i];
				$tdata_loc['ordering_size_id'] = $tdata['ordering_size_id'][$i];
				$tdata_loc['max_order'] = $tdata['max_order'][$i];
				$tdata_loc['min_order'] = $tdata['min_order'][$i];
				$tdata_loc['cusine_qty'] = $tdata['cusine_qty'][$i];
				$tdata_loc['currency_id'] = $tdata['currency_id'][$i];
				$tdata_loc['cusine_price'] = $tdata['cusine_price'][$i];
				$tdata_loc['default_price'] = $tdata['default_price'][$i];
				$tdata_loc['culoc_status'] = 1;
				$tdata_loc['added_by_admin'] = $tdata['modified_by_admin'];
				$this->addCusineLocation($tdata_loc);		
			}
			
		} catch (Exception $e) {
			$stringData = '[updateCusine] Catch Error:'.$e->getMessage();
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getCurrencyOption($currency_id,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Currency</option>';
		}
		else
		{
			$output .= '<option value="" >Select Currency</option>';
		}
		
		try {
			$sql = "SELECT currency_id, currency FROM `tblcurrencies` WHERE `currency_deleted` = '0' ORDER BY currency ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['currency_id'] == $currency_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['currency_id'].'" '.$selected.'>'.stripslashes($r['currency']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getCurrencyOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	//Manage Cusines - End
	
	//Manage Vendors - Start
	
	public function getPersonTitleOption($person_title,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $person_title))
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
				$selected = '';	
			}
			$output .= '<option value="-1" '.$selected.' >All Gendor</option>';
		}
		else
		{
			$output .= '<option value="" >Select Gendor</option>';
		}
		
		$arr_record = array( 	"Female" => "Female",
							"Male" => "Male"
						);
		foreach($arr_record as $key => $val)
		{
			if($multiple == '1')
			{
				if(in_array($key, $person_title))
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
				if($key == $person_title )
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
			}
			
			$output .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
		}
			
		
		return $output;
	}
	
	public function getCertficationTypeOption($vc_cert_type_id,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Type</option>';
		}
		else
		{
			$output .= '<option value="" >Select Type</option>';
		}
		
		try {
			$sql = "SELECT cat_id as vc_cert_type_id, cat_name as vc_cert_type FROM `tblcategories` WHERE `parent_cat_id` = '71' AND `cat_deleted` = '0' ORDER BY vc_cert_type ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['vc_cert_type_id'] == $vc_cert_type_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['vc_cert_type_id'].'" '.$selected.'>'.stripslashes($r['vc_cert_type']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getCertficationTypeOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getAllVendors($txtsearch='',$status='',$vendor_parent_cat_id='',$vendor_cat_id='',$country_id='',$state_id='',$city_id='',$area_id='',$added_by_admin='',$added_date_type='',$added_days_of_month='',$added_days_of_week='',$added_single_date='',$added_start_date='',$added_end_date='')
	{
		$DBH = new DatabaseHandler();
		$arr_records = array();
		
		$sql_search_str = "";
		if($txtsearch != '')
		{
			$sql_search_str = " AND TVR.vendor_name LIKE '%".$txtsearch."%' ";
		}
		
		$sql_status_str = "";
		if($status != '')
		{
			$sql_status_str = " AND TVR.vendor_status = '".$status."' ";
		}
		
		$sql_vendor_parent_cat_id_str = "";
		if($vendor_parent_cat_id != '')
		{
			$sql_vendor_parent_cat_id_str = " AND TVR.vendor_parent_cat_id = '".$vendor_parent_cat_id."' ";
		}
		
		$sql_vendor_cat_id_str = "";
		if($vendor_cat_id != '')
		{
			$sql_vendor_cat_id_str = " AND TVR.vendor_cat_id = '".$vendor_cat_id."' ";
		}
		
		$sql_country_id_str = "";
		if($country_id != '')
		{
			$sql_country_id_str = " AND TVL.country_id = '".$country_id."' ";
		}
		
		$sql_state_id_str = "";
		if($state_id != '')
		{
			$sql_state_id_str = " AND TVL.state_id = '".$state_id."' ";
		}
		
		$sql_city_id_str = "";
		if($city_id != '')
		{
			$sql_city_id_str = " AND TVL.city_id = '".$city_id."' ";
		}
		
		$sql_area_id_str = "";
		if($area_id != '')
		{
			$sql_area_id_str = " AND TVL.area_id = '".$area_id."' ";
		}
		
		$sql_added_by_admin_str = "";
		if($added_by_admin != '')
		{
			$sql_added_by_admin_str = " AND TVR.added_by_admin = '".$added_by_admin."' ";
		}
		
		$sql_add_date_str = "";
		if($added_date_type != '')
		{
			if($added_date_type == 'days_of_month')
			{
				if($added_days_of_month != '' && $added_days_of_month != '-1')
				{
					$sql_add_date_str = " AND DAY(TVR.vendor_add_date) = '".$added_days_of_month."' ";	
				}	
			}
			elseif($added_date_type == 'days_of_week')
			{
				if($added_days_of_week != '' && $added_days_of_week != '-1')
				{
					//In WEEKDAY()  0-Monday,6-Sunday
					$added_days_of_week = $added_days_of_week -1;
					$sql_add_date_str = " AND WEEKDAY(TVR.vendor_add_date) = '".$added_days_of_week."' ";	
				}	
			}
			elseif($added_date_type == 'single_date')
			{
				if($added_single_date != '' && $added_single_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(TVR.vendor_add_date) = '".date('Y-m-d',strtotime($added_single_date))."' ";	
				}	
			}
			elseif($added_date_type == 'date_range')
			{
				if($added_start_date != '' && $added_start_date != '0000-00-00' && $added_end_date != '' && $added_end_date != '0000-00-00')
				{
					$sql_add_date_str = " AND DATE(TVR.vendor_add_date) >= '".date('Y-m-d',strtotime($added_start_date))."'  AND DATE(TVR.vendor_add_date) <= '".date('Y-m-d',strtotime($added_end_date))."' ";	
				}	
			}
		}
		
		$sql = "SELECT TVR.*, TBC1.cat_id AS main_profile_id, TBC1.cat_name AS main_profile, TBC2.cat_id AS category_id, TBC2.cat_name AS category_name,
				TVL.country_id,TVL.state_id,TVL.city_id,TVL.area_id,
				(SELECT country_name FROM `tblcountry` WHERE `country_id` = TVL.country_id ) AS country_name,
				(SELECT state_name FROM `tblstates` WHERE `state_id` = TVL.state_id ) AS state_name,
				(SELECT city_name FROM `tblcities` WHERE `city_id` = TVL.city_id ) AS city_name,
				(SELECT area_name FROM `tblarea` WHERE `area_id` = TVL.area_id ) AS area_name 
				FROM `tblvendors` AS TVR 
				LEFT JOIN `tblcategories` AS TBC1 ON TVR.vendor_parent_cat_id = TBC1.cat_id   
				LEFT JOIN `tblcategories` AS TBC2 ON TVR.vendor_cat_id = TBC2.cat_id   
				LEFT JOIN `tblvendorlocations` AS TVL ON TVR.vendor_id = TVL.vendor_id   
				WHERE TVR.vendor_deleted = '0' AND TVL.vloc_default = '1' AND TVL.vloc_deleted = '0' 
				".$sql_search_str." ".$sql_status_str." ".$sql_vendor_parent_cat_id_str." ".$sql_vendor_cat_id_str." ".$sql_country_id_str." ".$sql_state_id_str." ".$sql_city_id_str." ".$sql_area_id_str." ".$sql_added_by_admin_str." ".$sql_add_date_str."   
				ORDER BY TVR.vendor_name ASC";	
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
	
	public function chkVendorNameExists($vendor_name)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_name` = '".addslashes($vendor_name)."' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkVendorNameExists_edit($vendor_name,$vendor_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_name` = '".addslashes($vendor_name)."' AND `vendor_id` != '".$vendor_id."' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkVendorUsernameExists($vendor_username)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_username` = '".addslashes($vendor_username)."' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkVendorUsernameExists_edit($vendor_username,$vendor_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_username` = '".addslashes($vendor_username)."' AND `vendor_id` != '".$vendor_id."' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkVendorEmailExists($vendor_email)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_email` = '".addslashes($vendor_email)."' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function chkVendorEmailExists_edit($vendor_email,$vendor_id)
    {
        $DBH = new DatabaseHandler();
        $return = false;

        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_email` = '".addslashes($vendor_email)."' AND `vendor_id` != '".$vendor_id."' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
		if( $STH->rowCount() > 0 )
        {
            $return = true;
        }
        return $return;
    }
	
	public function addVendorLocation($tdata)
    {
		
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = 0;
		
		try {
			$sql = "INSERT INTO `tblvendorlocations` (`vendor_id`,`contact_person`,`contact_person_title`,`contact_email`,`contact_designation`,`contact_number`,`contact_remark`,`country_id`,`state_id`,`city_id`,`area_id`,`vloc_parent_cat_id`,`vloc_cat_id`,`vloc_speciality_offered`,`vloc_doc_file`,`vloc_menu_file`,`vloc_default`,`vloc_status`,`added_by_admin`,`vloc_add_date`) 
					VALUES (:vendor_id,:contact_person,:contact_person_title,:contact_email,:contact_designation,:contact_number,:contact_remark,:country_id,:state_id,:city_id,:area_id,:vloc_parent_cat_id,:vloc_cat_id,:vloc_speciality_offered,:vloc_doc_file,:vloc_menu_file,:vloc_default,:vloc_status,:added_by_admin,:vloc_add_date)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':vendor_id' => $tdata['vendor_id'],
				':contact_person' => addslashes($tdata['contact_person']),
				':contact_person_title' => addslashes($tdata['contact_person_title']),
				':contact_email' => addslashes($tdata['contact_email']),
				':contact_designation' => addslashes($tdata['contact_designation']),
				':contact_number' => addslashes($tdata['contact_number']),
				':contact_remark' => addslashes($tdata['contact_remark']),
				':country_id' => addslashes($tdata['country_id']),
				':state_id' => addslashes($tdata['state_id']),
				':city_id' => addslashes($tdata['city_id']),
				':area_id' => addslashes($tdata['area_id']),
				':vloc_parent_cat_id' => addslashes($tdata['vloc_parent_cat_id']),
				':vloc_cat_id' => addslashes($tdata['vloc_cat_id']),
				':vloc_speciality_offered' => addslashes($tdata['vloc_speciality_offered']),
				':vloc_doc_file' => addslashes($tdata['vloc_doc_file']),
				':vloc_menu_file' => addslashes($tdata['vloc_menu_file']),
				':vloc_default' => addslashes($tdata['vloc_default']),
				':vloc_status' => '1',
				':added_by_admin' => $tdata['admin_id'],
				':vloc_add_date' => date('Y-m-d H:i:s')
				
            ));
			$return = $DBH->lastInsertId();
			$DBH->commit();
		} catch (Exception $e) {
			$stringData = '[addVendorLocation] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return 0;
        }
        return $return;
    }
	
	public function addVendorCerification($tdata)
    {
		
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = 0;
		
		try {
			$sql = "INSERT INTO `tblvendorcertifications` (`vendor_id`,`vloc_id`,`vc_cert_type_id`,`vc_cert_name`,`vc_cert_no`,`vc_cert_reg_date`,`vc_cert_validity_date`,`vc_cert_issued_by`,`vc_cert_scan_file`,`vc_cert_status`,`added_by_admin`,`vc_cert_add_date`) 
					VALUES (:vendor_id,:vloc_id,:vc_cert_type_id,:vc_cert_name,:vc_cert_no,:vc_cert_reg_date,:vc_cert_validity_date,:vc_cert_issued_by,:vc_cert_scan_file,:vc_cert_status,:added_by_admin,:vc_cert_add_date)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':vendor_id' => $tdata['vendor_id'],
				':vloc_id' => addslashes($tdata['vloc_id']),
				':vc_cert_type_id' => addslashes($tdata['vc_cert_type_id']),
				':vc_cert_name' => addslashes($tdata['vc_cert_name']),
				':vc_cert_no' => addslashes($tdata['vc_cert_no']),
				':vc_cert_reg_date' => addslashes($tdata['vc_cert_reg_date']),
				':vc_cert_validity_date' => addslashes($tdata['vc_cert_validity_date']),
				':vc_cert_issued_by' => addslashes($tdata['vc_cert_issued_by']),
				':vc_cert_scan_file' => addslashes($tdata['vc_cert_scan_file']),
				':vc_cert_status' => $tdata['vc_cert_status'],
				':added_by_admin' => $tdata['admin_id'],
				':vc_cert_add_date' => date('Y-m-d H:i:s')
				
            ));
			$return = $DBH->lastInsertId();
			$DBH->commit();
		} catch (Exception $e) {
			$stringData = '[addVendorCerification] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return 0;
        }
        return $return;
    }
	
	public function addVendor($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "INSERT INTO `tblvendors` (`vendor_username`,`vendor_password`,`vendor_email`,`vendor_name`,`vendor_parent_cat_id`,`vendor_cat_id`,`vendor_status`,`vendor_add_date`,`added_by_admin`) 
					VALUES (:vendor_username,:vendor_password,:vendor_email,:vendor_name,:vendor_parent_cat_id,:vendor_cat_id,:vendor_status,:vendor_add_date,:added_by_admin)";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':vendor_username' => addslashes($tdata['vendor_username']),
				':vendor_password' => md5($tdata['vendor_password']),
				':vendor_email' => addslashes($tdata['vendor_email']),
				':vendor_name' => addslashes($tdata['vendor_name']),
				':vendor_parent_cat_id' => addslashes($tdata['vendor_parent_cat_id']),
				':vendor_cat_id' => addslashes($tdata['vendor_cat_id']),
				':vendor_status' => addslashes($tdata['vendor_status']),
				':vendor_add_date' => date('Y-m-d H:i:s'),
				':added_by_admin' =>$tdata['admin_id']
			));
			$vendor_id = $DBH->lastInsertId();
			$DBH->commit();
			
			if($vendor_id > 0)
			{
				$return = true;
				if(count($tdata['vloc_parent_cat_id']) > 0)
				{
					for($i=0;$i<count($tdata['vloc_parent_cat_id']);$i++)
					{
						$tdata_vloc = array();
						$tdata_vloc['vendor_id'] = $vendor_id;
						$tdata_vloc['contact_person'] = $tdata['contact_person'][$i];
						$tdata_vloc['contact_person_title'] = $tdata['contact_person_title'][$i];
						$tdata_vloc['contact_email'] = $tdata['contact_email'][$i];
						$tdata_vloc['contact_designation'] = $tdata['contact_designation'][$i];
						$tdata_vloc['contact_number'] = $tdata['contact_number'][$i];
						$tdata_vloc['contact_remark'] = $tdata['contact_remark'][$i];
						$tdata_vloc['country_id'] = $tdata['country_id'][$i];
						$tdata_vloc['state_id'] = $tdata['state_id'][$i];
						$tdata_vloc['city_id'] = $tdata['city_id'][$i];
						$tdata_vloc['area_id'] = $tdata['area_id'][$i];
						$tdata_vloc['vloc_parent_cat_id'] = $tdata['vloc_parent_cat_id'][$i];
						$tdata_vloc['vloc_cat_id'] = $tdata['vloc_cat_id'][$i];
						$tdata_vloc['vloc_speciality_offered'] = $tdata['vloc_speciality_offered'][$i];
						$tdata_vloc['vloc_doc_file'] = $tdata['vloc_doc_file'][$i];
						$tdata_vloc['vloc_menu_file'] = $tdata['vloc_menu_file'][$i];
						if($i == 0)
						{
							$tdata_vloc['vloc_default'] = 1;	
						}
						else
						{
							$tdata_vloc['vloc_default'] = 0;	
						}
						$tdata_vloc['vloc_status'] = 1;
						$tdata_vloc['admin_id'] = $tdata['admin_id'];
						
						$vloc_id = $this->addVendorLocation($tdata_vloc);		
						if($vloc_id > 0)
						{
							for($k=0;$k<count($tdata['vc_cert_type_id'][$i]);$k++)
							{
								$tdata_vc = array();
								$tdata_vc['vendor_id'] = $vendor_id;
								$tdata_vc['vloc_id'] = $vloc_id;
								$tdata_vc['vc_cert_type_id'] = $tdata['vc_cert_type_id'][$i][$k];
								$tdata_vc['vc_cert_name'] = $tdata['vc_cert_name'][$i][$k];
								$tdata_vc['vc_cert_no'] = $tdata['vc_cert_no'][$i][$k];
								$tdata_vc['vc_cert_reg_date'] = $tdata['vc_cert_reg_date'][$i][$k];
								$tdata_vc['vc_cert_validity_date'] = $tdata['vc_cert_validity_date'][$i][$k];
								$tdata_vc['vc_cert_issued_by'] = $tdata['vc_cert_issued_by'][$i][$k];
								$tdata_vc['vc_cert_scan_file'] = $tdata['vc_cert_scan_file'][$i][$k];
								$tdata_vc['vc_cert_status'] = 1;
								$tdata_vc['admin_id'] = $tdata['admin_id'];
								$vc_cert_id = $this->addVendorCerification($tdata_vc);		
							}			
						}
					}
				}
			}
			
		} catch (Exception $e) {
			$stringData = '[addVendor] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getVendorSpecialityOfferedOption($vloc_speciality_offered,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $vloc_speciality_offered))
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
				$selected = '';	
			}
			$output .= '<option value="-1" '.$selected.' >All Speciality</option>';
		}
		else
		{
			$output .= '<option value="" >Select Speciality</option>';
		}
		
		try {
			$sql = "SELECT item_id,item_name FROM `tblitems` WHERE item_deleted = '0' ORDER BY item_name ASC ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($multiple == '1')
					{
						if(in_array($r['item_id'], $vloc_speciality_offered))
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
						if($r['item_id'] == $vloc_speciality_offered )
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					
					$output .= '<option value="'.$r['item_id'].'" '.$selected.'>'.stripslashes($r['item_name']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getVendorSpecialityOfferedOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	public function getVendorDetails($vendor_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '".$vendor_id."' AND `vendor_deleted` = '0' ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $arr_record = $r;
        }	

        return $arr_record;
    }
	
	public function getVendorAllLocationsAndCertifications($vendor_id)
    {
        $DBH = new DatabaseHandler();
        $arr_record = array();
        
        $sql = "SELECT * FROM `tblvendorlocations` WHERE `vendor_id` = '".$vendor_id."' AND `vloc_deleted` = '0' ORDER BY vloc_default DESC, vloc_add_date ASC ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            while($r = $STH->fetch(PDO::FETCH_ASSOC))
			{
				$r['certificate'] = array();
				$sql2 = "SELECT * FROM `tblvendorcertifications` WHERE `vendor_id` = '".$vendor_id."' AND `vloc_id` = '".$r['vloc_id']."' AND `vc_cert_deleted` = '0' ORDER BY vc_cert_add_date ASC ";
				$STH2 = $DBH->query($sql2);
				if($STH2->rowCount() > 0)
				{
					while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))
					{
						$r['certificate'][] = $r2;
					}
				}	
				
				$arr_record[] = $r;	
			}
            
        }	

        return $arr_record;
    }
	
	public function updateVendorLocation($tdata)
    {
		
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblvendorlocations` SET 
					`contact_person` = :contact_person,
					`contact_person_title` = :contact_person_title,
					`contact_email` = :contact_email,
					`contact_designation` = :contact_designation,
					`contact_number` = :contact_number,
					`contact_remark` = :contact_remark,
					`country_id` = :country_id,
					`state_id` = :state_id,
					`city_id` = :city_id,
					`area_id` = :area_id,
					`vloc_parent_cat_id` = :vloc_parent_cat_id,
					`vloc_cat_id` = :vloc_cat_id,
					`vloc_speciality_offered` = :vloc_speciality_offered,
					`vloc_doc_file` = :vloc_doc_file,
					`vloc_menu_file` = :vloc_menu_file,
					`vloc_default` = :vloc_default,
					`vloc_status` = :vloc_status,
					`modified_by_admin` = :modified_by_admin,
					`vloc_modified_date` = :vloc_modified_date 
					WHERE `vloc_id` = :vloc_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':contact_person' => addslashes($tdata['contact_person']),
				':contact_person_title' => addslashes($tdata['contact_person_title']),
				':contact_email' => addslashes($tdata['contact_email']),
				':contact_designation' => addslashes($tdata['contact_designation']),
				':contact_number' => addslashes($tdata['contact_number']),
				':contact_remark' => addslashes($tdata['contact_remark']),
				':country_id' => addslashes($tdata['country_id']),
				':state_id' => addslashes($tdata['state_id']),
				':city_id' => addslashes($tdata['city_id']),
				':area_id' => addslashes($tdata['area_id']),
				':vloc_parent_cat_id' => addslashes($tdata['vloc_parent_cat_id']),
				':vloc_cat_id' => addslashes($tdata['vloc_cat_id']),
				':vloc_speciality_offered' => addslashes($tdata['vloc_speciality_offered']),
				':vloc_doc_file' => addslashes($tdata['vloc_doc_file']),
				':vloc_menu_file' => addslashes($tdata['vloc_menu_file']),
				':vloc_default' => addslashes($tdata['vloc_default']),
				':vloc_status' => '1',
				':modified_by_admin' => $tdata['admin_id'],
				':vloc_modified_date' => date('Y-m-d H:i:s'),
				':vloc_id' => $tdata['vloc_id']
            ));
			$return = true;
			$DBH->commit();
		} catch (Exception $e) {
			$stringData = '[updateVendorLocation] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function updateVendorCerification($tdata)
    {
		
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = true;
		
		try {
			$sql = "UPDATE `tblvendorcertifications` SET 
					`vc_cert_type_id` = :vc_cert_type_id,
					`vc_cert_name` = :vc_cert_name,
					`vc_cert_no` = :vc_cert_no,
					`vc_cert_reg_date` = :vc_cert_reg_date,
					`vc_cert_validity_date` = :vc_cert_validity_date,
					`vc_cert_issued_by` = :vc_cert_issued_by,
					`vc_cert_scan_file` = :vc_cert_scan_file,
					`vc_cert_status` = :vc_cert_status,
					`modified_by_admin` = :modified_by_admin,
					`vc_cert_modified_date` = :vc_cert_modified_date 
					 WHERE `vc_cert_id` = :vc_cert_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':vc_cert_type_id' => addslashes($tdata['vc_cert_type_id']),
				':vc_cert_name' => addslashes($tdata['vc_cert_name']),
				':vc_cert_no' => addslashes($tdata['vc_cert_no']),
				':vc_cert_reg_date' => addslashes($tdata['vc_cert_reg_date']),
				':vc_cert_validity_date' => addslashes($tdata['vc_cert_validity_date']),
				':vc_cert_issued_by' => addslashes($tdata['vc_cert_issued_by']),
				':vc_cert_scan_file' => addslashes($tdata['vc_cert_scan_file']),
				':vc_cert_status' => $tdata['vc_cert_status'],
				':modified_by_admin' => $tdata['admin_id'],
				':vc_cert_modified_date' => date('Y-m-d H:i:s'),
				':vc_cert_id' => $tdata['vc_cert_id']
				
            ));
			$return = true;
			$DBH->commit();
		} catch (Exception $e) {
			$stringData = '[updateVendorCerification] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function updateVendor($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblvendors` SET 
					`vendor_username` = :vendor_username,
					`vendor_email` = :vendor_email,
					`vendor_name` = :vendor_name,
					`vendor_parent_cat_id` = :vendor_parent_cat_id,
					`vendor_cat_id` = :vendor_cat_id,
					`vendor_status` = :vendor_status,
					`vendor_modified_date` = :vendor_modified_date,
					`modified_by_admin` = :modified_by_admin
					WHERE `vendor_id` = :vendor_id";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':vendor_username' => addslashes($tdata['vendor_username']),
				':vendor_email' => addslashes($tdata['vendor_email']),
				':vendor_name' => addslashes($tdata['vendor_name']),
				':vendor_parent_cat_id' => addslashes($tdata['vendor_parent_cat_id']),
				':vendor_cat_id' => addslashes($tdata['vendor_cat_id']),
				':vendor_status' => addslashes($tdata['vendor_status']),
				':vendor_modified_date' => date('Y-m-d H:i:s'),
				':modified_by_admin' => $tdata['admin_id'],
				':vendor_id' => $tdata['vendor_id'],
			));
			$vendor_id = $tdata['vendor_id'];
			$DBH->commit();
			
			$return = true;
			if(count($tdata['vloc_parent_cat_id']) > 0)
			{
				$tdata_del_vloc = array();
				$tdata_del_vloc['vendor_id'] = $vendor_id;
				$tdata_del_vloc['vloc_id'] = $tdata['vloc_id'];
				$tdata_del_vloc['admin_id'] = $tdata['admin_id'];
				$this->deleteRemovedVendorLocationRows($tdata_del_vloc);
				
				$tdata_del_vc = array();
				$tdata_del_vc['vendor_id'] = $vendor_id;
				$tdata_del_vc['vc_cert_id'] = $tdata['vc_cert_id'];
				$tdata_del_vc['admin_id'] = $tdata['admin_id'];
				$this->deleteRemovedVendorCertificationRows($tdata_del_vc);
				
				
				for($i=0;$i<count($tdata['vloc_parent_cat_id']);$i++)
				{
					$tdata_vloc = array();
					$tdata_vloc['vendor_id'] = $vendor_id;
					$tdata_vloc['contact_person'] = $tdata['contact_person'][$i];
					$tdata_vloc['contact_person_title'] = $tdata['contact_person_title'][$i];
					$tdata_vloc['contact_email'] = $tdata['contact_email'][$i];
					$tdata_vloc['contact_designation'] = $tdata['contact_designation'][$i];
					$tdata_vloc['contact_number'] = $tdata['contact_number'][$i];
					$tdata_vloc['contact_remark'] = $tdata['contact_remark'][$i];
					$tdata_vloc['country_id'] = $tdata['country_id'][$i];
					$tdata_vloc['state_id'] = $tdata['state_id'][$i];
					$tdata_vloc['city_id'] = $tdata['city_id'][$i];
					$tdata_vloc['area_id'] = $tdata['area_id'][$i];
					$tdata_vloc['vloc_parent_cat_id'] = $tdata['vloc_parent_cat_id'][$i];
					$tdata_vloc['vloc_cat_id'] = $tdata['vloc_cat_id'][$i];
					$tdata_vloc['vloc_speciality_offered'] = $tdata['vloc_speciality_offered'][$i];
					$tdata_vloc['vloc_doc_file'] = $tdata['vloc_doc_file'][$i];
					$tdata_vloc['vloc_menu_file'] = $tdata['vloc_menu_file'][$i];
					if($i == 0)
					{
						$tdata_vloc['vloc_default'] = 1;	
					}
					else
					{
						$tdata_vloc['vloc_default'] = 0;	
					}
					$tdata_vloc['vloc_status'] = 1;
					$tdata_vloc['admin_id'] = $tdata['admin_id'];
					$tdata_vloc['vloc_id'] = $tdata['vloc_id'][$i];
					
					if($tdata_vloc['vloc_id'] > 0)
					{
						if($this->updateVendorLocation($tdata_vloc))
						{
							$vloc_id = $tdata_vloc['vloc_id'];
							for($k=0;$k<count($tdata['vc_cert_type_id'][$i]);$k++)
							{
								$tdata_vc = array();
								$tdata_vc['vendor_id'] = $vendor_id;
								$tdata_vc['vloc_id'] = $vloc_id;
								$tdata_vc['vc_cert_type_id'] = $tdata['vc_cert_type_id'][$i][$k];
								$tdata_vc['vc_cert_name'] = $tdata['vc_cert_name'][$i][$k];
								$tdata_vc['vc_cert_no'] = $tdata['vc_cert_no'][$i][$k];
								$tdata_vc['vc_cert_reg_date'] = $tdata['vc_cert_reg_date'][$i][$k];
								$tdata_vc['vc_cert_validity_date'] = $tdata['vc_cert_validity_date'][$i][$k];
								$tdata_vc['vc_cert_issued_by'] = $tdata['vc_cert_issued_by'][$i][$k];
								$tdata_vc['vc_cert_scan_file'] = $tdata['vc_cert_scan_file'][$i][$k];
								$tdata_vc['vc_cert_status'] = 1;
								$tdata_vc['admin_id'] = $tdata['admin_id'];
								$tdata_vc['vc_cert_id'] = $tdata['vc_cert_id'][$i][$k];
								
								if($tdata_vc['vc_cert_id'] > 0 )
								{
									$vc_cert_id = $this->updateVendorCerification($tdata_vc);	
								}
								else
								{
									$vc_cert_id = $this->addVendorCerification($tdata_vc);	
								}
									
							}
						}
					}
					else
					{
						$vloc_id = $this->addVendorLocation($tdata_vloc);		
						if($vloc_id > 0)
						{
							for($k=0;$k<count($tdata['vc_cert_type_id'][$i]);$k++)
							{
								$tdata_vc = array();
								$tdata_vc['vendor_id'] = $vendor_id;
								$tdata_vc['vloc_id'] = $vloc_id;
								$tdata_vc['vc_cert_type_id'] = $tdata['vc_cert_type_id'][$i][$k];
								$tdata_vc['vc_cert_name'] = $tdata['vc_cert_name'][$i][$k];
								$tdata_vc['vc_cert_no'] = $tdata['vc_cert_no'][$i][$k];
								$tdata_vc['vc_cert_reg_date'] = $tdata['vc_cert_reg_date'][$i][$k];
								$tdata_vc['vc_cert_validity_date'] = $tdata['vc_cert_validity_date'][$i][$k];
								$tdata_vc['vc_cert_issued_by'] = $tdata['vc_cert_issued_by'][$i][$k];
								$tdata_vc['vc_cert_scan_file'] = $tdata['vc_cert_scan_file'][$i][$k];
								$tdata_vc['vc_cert_status'] = 1;
								$tdata_vc['admin_id'] = $tdata['admin_id'];
								$vc_cert_id = $this->addVendorCerification($tdata_vc);		
							}			
						}	
					}
				}
			}
		} catch (Exception $e) {
			$stringData = '[updateVendor] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function deleteRemovedVendorLocationRows($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		if(is_array($tdata['vloc_id']) && count($tdata['vloc_id']) > 0)
		{
			$str_vloc_id = implode(',',$tdata['vloc_id']);
		}
		else
		{
			return $return;
		}
		
		try {
			$sql = "UPDATE `tblvendorlocations` SET 
					`vloc_deleted` = :vloc_deleted,
					`vloc_modified_date` = :vloc_modified_date,  
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `vendor_id` = :vendor_id AND `vloc_id` NOT IN (".$str_vloc_id.") AND `vloc_deleted` != '1'  ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':vloc_deleted' => '1',
				':vloc_modified_date' => date('Y-m-d H:i:s'),
				':deleted_by_admin' => $tdata['admin_id'],
				':vendor_id' => $tdata['vendor_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteRemovedVendorLocationRows] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function deleteRemovedVendorCertificationRows($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		$str_vc_cert_id = '';
		if(is_array($tdata['vc_cert_id']) && count($tdata['vc_cert_id']) > 0)
		{
			foreach($tdata['vc_cert_id'] as $key => $val)
			{
				if(is_array($val) && count($val) > 0)
				{
					$temp_str_vc_cert_id = implode(',',$val);	
					
					$str_vc_cert_id .= $temp_str_vc_cert_id.',';
				}
			}
			$str_vc_cert_id = substr($str_vc_cert_id,0,-1);
		}
		else
		{
			return $return;
		}
		
		if($str_vc_cert_id == '')
		{
			return $return;
		}
		
		try {
			$sql = "UPDATE `tblvendorcertifications` SET 
					`vc_cert_deleted` = :vc_cert_deleted,
					`vc_cert_modified_date` = :vc_cert_modified_date,  
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `vendor_id` = :vendor_id AND `vc_cert_id` NOT IN (".$str_vc_cert_id.") AND `vc_cert_deleted` != '1' ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':vc_cert_deleted' => '1',
				':vc_cert_modified_date' => date('Y-m-d H:i:s'),
				':deleted_by_admin' => $tdata['admin_id'],
				':vendor_id' => $tdata['vendor_id']
            ));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteRemovedVendorCertificationRows] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function deleteVendor($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
		
		$return = false;
		
		try {
			$sql = "UPDATE `tblvendors` SET 
					`vendor_deleted` = :vendor_deleted,
					`vendor_modified_date` = :vendor_modified_date,  
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `vendor_id` = :vendor_id ";
			$STH = $DBH->prepare($sql);
            $STH->execute(array(
				':vendor_deleted' => '1',
				':vendor_modified_date' => date('Y-m-d H:i:s'),
				':deleted_by_admin' => $tdata['admin_id'],
				':vendor_id' => $tdata['vendor_id']
            ));
			
			
			$sql2 = "UPDATE `tblvendorlocations` SET 
					`vloc_deleted` = :vloc_deleted,
					`vloc_modified_date` = :vloc_modified_date,  
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `vendor_id` = :vendor_id  AND `vloc_deleted` != '1' ";
			$STH2 = $DBH->prepare($sql2);
            $STH2->execute(array(
				':vloc_deleted' => '1',
				':vloc_modified_date' => date('Y-m-d H:i:s'),
				':deleted_by_admin' => $tdata['admin_id'],
				':vendor_id' => $tdata['vendor_id']
            ));
			
			
			$sql3 = "UPDATE `tblvendorcertifications` SET 
					`vc_cert_deleted` = :vc_cert_deleted,
					`vc_cert_modified_date` = :vc_cert_modified_date,  
					`deleted_by_admin` = :deleted_by_admin  
					WHERE `vendor_id` = :vendor_id  AND `vc_cert_deleted` != '1' ";
			$STH3 = $DBH->prepare($sql3);
            $STH3->execute(array(
				':vc_cert_deleted' => '1',
				':vc_cert_modified_date' => date('Y-m-d H:i:s'),
				':deleted_by_admin' => $tdata['admin_id'],
				':vendor_id' => $tdata['vendor_id']
            ));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			$stringData = '[deleteVendor] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return false;
        }
        return $return;
    }
	
	public function getContactDesignationOption($contact_designation,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Designation</option>';
		}
		else
		{
			$output .= '<option value="" >Select Designation</option>';
		}
		
		try {
			$sql = "SELECT cat_id as contact_designation, cat_name as contact_designation_name FROM `tblcategories` WHERE `parent_cat_id` = '8' AND `cat_deleted` = '0' ORDER BY contact_designation_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['contact_designation'] == $contact_designation )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['contact_designation'].'" '.$selected.'>'.stripslashes($r['contact_designation_name']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getContactDesignationOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
	
	//Manage Vendors - End
	
	public function getAdminsOption($admin_id,$type='1')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Admins</option>';
		}
		else
		{
			$output .= '<option value="" >Select Admin</option>';
		}
		
		try {
			$sql = "SELECT admin_id,username FROM `tbladmin` WHERE `deleted` = '0' ORDER BY username ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($r['admin_id'] == $admin_id )
					{
						$selected = ' selected ';	
					}
					else
					{
						$selected = '';	
					}
					$output .= '<option value="'.$r['admin_id'].'" '.$selected.'>'.stripslashes($r['username']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getAdminsOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}
}
?>