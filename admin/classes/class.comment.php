<?php
include_once("class.paging.php");
include_once("class.admin.php");
class Comment extends Admin
{
	public function GetAllPages()
	{
		//$this->connectDB();
	        $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
				
		$admin_id = $_SESSION['admin_id'];
		$delete_action_id = '109';
						
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
	
		$sql = "SELECT TA.comment_id,TA.narration,TA.comment,TA.bes_id,TA.trigger_id,TA.topic_subject,TA.comment_add_date,TA.status,TS.title,TN.narration,TU.name FROM `tblcomments` as TA 
				 LEFT JOIN `tbltitle` TS ON TA.select_title = TS.title_id
				 LEFT JOIN `tblnarration` AS TN ON TA.short_narration = TN.narration_id
				 LEFT JOIN `tblusers` TU ON TA.user_id = TU.user_id
				 ORDER BY comment_add_date DESC,TA.user_id DESC,TA.select_title DESC";
					
		//$this->execute_query($sql);
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=comments");
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
			    if($row['status'] == '1')
				{
					$status = 'Active';
				}else
				{
					$status = 'Inactive';
				}
				
				
				$date = $row['comment_add_date'];
				$comment_date = date('d-M-Y',strtotime($date));
				
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['comment']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['name']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['bes_id']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['trigger_id']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['topic_subject']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['narration']).'</td>';
				$output .= '<td height="30" align="center">'.$comment_date.'</td>';
				$output .= '<td height="30" align="center">'.$status.'</td>';
				$output .= '<td align="center" nowrap="nowrap">';
							//if($edit) {
				$output .= '<a href="index.php?mode=edit_comments&uid='.$row['comment_id'].'" ><img src = "images/edit.gif" border="0"></a>';
								//}
				$output .= '</td>';
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="6" align="center">NO PAGES FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	


	
	public function DeleteComment($comment_id)
	{
		//$this->connectDB();
		$my_DBH = new mysqlConnection();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		$return = false;
		$del_sql1 = "DELETE FROM `tblcomments` WHERE  `comment_id` = '".$comment_id."'"; 
		//$this->execute_query($del_sql1);
		$STH = $DBH->prepare($del_sql1);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
		
	}
	
	public function getCommentDetails($comment_id)
	{
		//$this->connectDB();
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
				
		$comment = '';
		$title = '';
		$narration = '';
		$name = '';
		$status = '';
				
		$sql = "SELECT  TA.comment_id,TA.comment,TA.comment_add_date,TA.status,TS.title,TN.narration,TU.name FROM `tblcomments` as TA 
				LEFT JOIN `tbltitle` TS ON TA.select_title = TS.title_id
				LEFT JOIN `tblnarration` AS TN ON TA.short_narration = TN.narration_id
				LEFT JOIN `tblusers` TU ON TA.user_id = TU.user_id
			 	WHERE `comment_id` = '".$comment_id."'";
				
		//$this->execute_query($sql);
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$comment = stripslashes($row['comment']);
			$title = stripslashes($row['title']);
			$narration = stripslashes($row['narration']);
			$name = stripslashes($row['name']);
			$status = stripslashes($row['status']);
		}
		return array($comment,$title,$narration,$name,$status);
		
	}
	
	public function Update_Comment($status,$comment_id)
	{
		//$this->connectDB();
		$my_DBH = new mysqlConnection();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		$return = false;
				
		$sql = "UPDATE `tblcomments` SET `status` = '".addslashes($status)."'  WHERE `comment_id` = '".$comment_id."'";
	   //echo $sql;
		$STH = $DBH->prepare($sql);
              $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}	
	
	
	

}
?>