<?php 
//session_start();
class LoginSystem extends mysqlConnection
{
	/**
	 * Check if the admin is logged in
	 * 
	 * @return true or false
	 */
	function isLoggedIn()
	{
		if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] != '')
		{
			return true;
		}
		else return false;
	}
	
	/**
	 * Check username and password against DB
	 *
	 * @return true/false
	 */
	function doLogin($username, $password)
	{
		$my_DBH = new mysqlConnection();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		
		// check db for user and pass here.
		$sql = sprintf("SELECT * FROM `tbladmin` WHERE username = '%s' and password = '%s' and status = '1' ", 
											$this->clean($username), md5($this->clean($password)));
				
				
		$STH = $DBH->prepare($sql);
		$STH->execute();
		$row_count = $STH->rowCount();
		// If no user/password combo exists return false
		if($row_count > 0)
		{
                        $row =  $STH->fetch(PDO::FETCH_ASSOC);
			$_SESSION['admin_id'] = $row['admin_id'];
			$_SESSION['admin_username'] = stripslashes($row['username']);
			$_SESSION['admin_fname'] = stripslashes($row['fname']);
			$_SESSION['admin_lname'] = stripslashes($row['lname']);
			$_SESSION['admin_email'] = $row['email'];
			$_SESSION['super_admin'] = stripslashes($row['super_admin']);
			
		}
		else // matching login ok
		{
                        $this->disconnect();
			return false;	
		}
		
		$this->disconnect();
		return true;
	}
	
	function chkValidUserPass($username,$password)
	{
		$my_DBH = new mysqlConnection();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		
		// check db for user and pass here.
		$sql = sprintf("SELECT * FROM `tbladmin` WHERE username = '%s' and password = '%s' and status = '1' ", $username, md5($password));
		$STH = $DBH->prepare($sql);
		$STH->execute();
		// If no user/password combo exists return false
		if($STH->rowCount() > 0)
		{
                    //echo 'Hiiii';
                        $this->disconnect();
			return true;
		}
		else // matching login ok
		{
			$this->disconnect();
			return false;
		}
	}
	
	/**
	 * Destroy session data/Logout.
	 */
	function logout()
	{
		unset($_SESSION['admin_id']);
		unset($_SESSION['admin_username']);
		unset($_SESSION['admin_fname']);
		unset($_SESSION['admin_lname']);
		unset($_SESSION['admin_email']);
		session_destroy();
		header("Location: index.php");
	}
	
	/**
	 * Cleans a string for input into a MySQL Database.
	 * Gets rid of unwanted characters/SQL injection etc.
	 * 
	 * @return string
	 */
	function clean($str)
    {

		// Only remove slashes if it's already been slashed by PHP

		// if(get_magic_quotes_gpc())

		// {

		// 	$str = stripslashes($str);

		// }

		if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}

		// Let MySQL remove nasty characters.

		//$str = mysql_real_escape_string($str);

		

		return $str;

	}
	
	
	
		
}

?>