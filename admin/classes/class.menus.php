<?php
include_once("class.paging.php");
include_once("class.admin.php");
class Menus extends Admin
{

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
			while($row =  $STH->fetch(PDO::FETCH_ASSOC)) 
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
		
		$sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$admin_id."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
			if($STH->rowCount() > 0)
				{
				$row = $STH->fetch(PDO::FETCH_ASSOC); 
				$super_admin     = 	strip_tags($row['super_admin']);
				$str_admin_menu_id   =  strip_tags($row['admin_menu_id']);
				$str_admin_action_id =  strip_tags($row['admin_action_id']);
			   
				if($super_admin == '1')
				{
				  $return = true;
				}
				else
				{
				   $arr_chk_permission = explode(",", $str_admin_action_id);
				   
					  if (in_array($action_id , $arr_chk_permission))
						{
						  $return = true;
						} 
				}
			}
		return $return;
	}

}

?>