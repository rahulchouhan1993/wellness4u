<?php
include_once("class.paging.php");
include_once("class.admin.php");
class Heights extends Admin
{
	public function getAllHeights()
	{
      $my_DBH = new mysqlConnection();
      $DBH = $my_DBH->raw_handle();
      $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '60';
		$delete_action_id = '62';
		
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		$sql = "SELECT * FROM `tblheights` ORDER BY `height_inch` ASC";
		//$this->execute_query($sql);
                $STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records = $STH->rowCount();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=heights");
	 	//$result=$this->execute_query($page->get_limit_query($sql));
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
				$output .= '<tr class="manage-row">';
				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td align="center"><strong>'.stripslashes($row['height_feet_inch']).'</strong></td>';
				$output .= '<td align="center">'.stripslashes($row['height_inch']).'</td>';
				$output .= '<td align="center">'.stripslashes($row['height_cms']).'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_height&id='.$row['height_id'].'" ><img src = "images/edit.gif" border="0"></a>';
								}
				$output .= '</td>';
				$output .= '<td align="center" nowrap="nowrap">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Height","sql/delheight.php?id='.$row['height_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
							}
				$output .= '</td>';
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="6" align="center">NO RECORDS FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function chkHeightExists($height_cms)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT * FROM `tblheights` WHERE `height_cms` = '".addslashes($height_cms)."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function chkHeightExists_edit($height_cms,$height_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT * FROM `tblheights` WHERE `height_cms` = '".addslashes($height_cms)."' AND `height_id` != '".$height_id."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function getHeightDetails($height_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$sql = "SELECT * FROM `tblheights` WHERE `height_id` = '".$height_id."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$height_feet_inch = stripslashes($row['height_feet_inch']);
			$height_inch = stripslashes($row['height_inch']);
			$height_cms = stripslashes($row['height_cms']);
		}
		return array($height_feet_inch,$height_inch,$height_cms);
	}
	
	
	public function addHeight($height_feet_inch,$height_inch,$height_cms)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		$now = time();
		
		$sql = "INSERT INTO `tblheights` (`height_feet_inch`,`height_inch`,`height_cms`,`height_add_date`) VALUES ('".addslashes($height_feet_inch)."','".addslashes($height_inch)."','".addslashes($height_cms)."','".$now."')";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function updateHeight($height_feet_inch,$height_inch,$height_cms,$height_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		$now = time();
		
		$upd_sql = "UPDATE `tblheights` SET `height_feet_inch` = '".addslashes($height_feet_inch)."' , `height_inch` = '".addslashes($height_inch)."' , `height_cms` = '".addslashes($height_cms)."' WHERE `height_id` = '".$height_id."'";
		$STH = $DBH->prepare($upd_sql);
                $STH->execute();
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function deleteHeight($height_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;
		$del_sql1 = "DELETE FROM `tblheights` WHERE `height_id` = '".$height_id."'"; 
		$STH = $DBH->prepare($del_sql1);
                $STH->execute();
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
}
?>