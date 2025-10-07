<?php
include_once("class.paging.php");
include_once("class.admin.php");
class Slider_Contents extends Admin
{
	public function getAllSliderContents($slider_type)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$sql = "SELECT * FROM `tblslidercontents` WHERE `slider_type` = '".$slider_type."' ORDER BY slider_add_date DESC";
		//$this->execute_query($sql);
                $STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records = $STH->rowCount();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=ngo_sliders");
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
				$output .= '<td align="center">'.$i.'</td>';
				$output .= '<td align="center"><strong>'.stripslashes($row['slider_title']).'</strong></td>';
				$output .= '<td align="center">'.stripslashes($row['slider_link']).'</td>';
				
				if($slider_type == 1)
				{
					$output .= '<td align="center"><a href="index.php?mode=edit_nature_slider&id='.$row['slider_id'].'" ><img src = "images/edit.gif" border="0"></a></td>';
					$output .= '<td align="center"><a href=\'javascript:fn_confirmdelete("Slider","sql/delnatureslider.php?id='.$row['slider_id'].'")\' ><img src = "images/del.gif" border="0" ></a></td>';
				}
				else
				{
					$output .= '<td align="center"><a href="index.php?mode=edit_ngo_slider&id='.$row['slider_id'].'&page='.$page->page.'" ><img src = "images/edit.gif" border="0"></a></td>';
					$output .= '<td align="center"><a href=\'javascript:fn_confirmdelete("Slider","sql/delngoslider.php?id='.$row['slider_id'].'")\' ><img src = "images/del.gif" border="0" ></a></td>';
				}	
				$output .= '</tr>';
				$output .= '<tr class="manage-row" height="20"><td colspan="5" align="center">&nbsp;</td></tr>';
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
	
	public function getAllParentSliderContents($slider_type)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '56';
		$delete_action_id = '58';
		$view_action_id = '57';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		$view = $this->chkValidActionPermission($admin_id,$view_action_id);
		
		$sql = "SELECT * FROM `tblparentsliders`  ORDER BY parent_slider_add_date DESC";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records = $STH->rowCount();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=ngo_sliders");
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
				$output .= '<td align="center">'.$i.'</td>';
				$output .= '<td align="center"><strong>'.stripslashes($row['slider_name']).'</strong></td>';
				$output .= '<td align="center">';
						if($view) {
				$output .= '<a href="index.php?mode=view_sliders&uid='.$row['parents_slider_id'].'">View Sliders</a>';
							}
				$output .= '</td>';
				$output .= '<td align="center">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_slider&id='.$row['parents_slider_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td align="center">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Slider","sql/delslider.php?id='.$row['parents_slider_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
							}
				$output .= '</td>';
				$output .= '</tr>';
				$output .= '<tr class="manage-row" height="20"><td colspan="5" align="center">&nbsp;</td></tr>';
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
	
	public function getSliderContents($parents_slider_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '56';
		$delete_action_id = '58';
		
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		
		$sql = "SELECT * FROM `tblslidercontents` 
		         WHERE parents_slider_id ='".$parents_slider_id."' 
				 ORDER BY slider_add_date DESC";
				 
				
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records = $STH->rowCount();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=ngo_sliders");
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
				$output .= '<td align="center">'.$i.'</td>';
				$output .= '<td align="center"><strong>'.stripslashes($row['slider_title']).'</strong></td>';
				$output .= '<td align="center">'.stripslashes($row['slider_desc']).'</td>';
				$output .= '<td align="center">'.stripslashes($row['slider_link']).'</td>';
				$output .= '<td align="center">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_view_slider&id='.$row['slider_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td align="center">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Slider","sql/delviewslider.php?id='.$row['slider_id'].'&pid='.$parents_slider_id.'")\' ><img src = "images/del.gif" border="0" ></a>';
							}
				$output .= '</td>';
				$output .= '</tr>';
				$output .= '<tr class="manage-row" height="20"><td colspan="6" align="center">&nbsp;</td></tr>';
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
	
	
	public function getSliderDetails($slider_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                 $DBH->beginTransaction();
				
		$sql = "SELECT * FROM `tblslidercontents` WHERE `slider_id` = '".$slider_id."'";
		
		
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$slider_title = stripslashes($row['slider_title']);
			$slider_desc = stripslashes($row['slider_desc']);
			$slider_image = stripslashes($row['slider_image']);
			$parents_slider_id = stripslashes($row['parents_slider_id']);
			$slider_link = stripslashes($row['slider_link']);
		}
		return array($slider_title,$slider_desc,$slider_image,$parents_slider_id,$slider_link);
	}
	
	public function getParentsSliderDetails($parents_slider_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                 $DBH->beginTransaction();
				
		$sql = "SELECT * FROM `tblparentsliders` WHERE `parents_slider_id` = '".$parents_slider_id."'";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$slider_name = stripslashes($row['slider_name']);
		}
		return $slider_name;
	}
	
	public function addSliderContent($slider_name)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                 $DBH->beginTransaction();
		$return = false;
		
		$sql = "INSERT INTO `tblparentsliders` (`slider_name`) VALUES ('".addslashes($slider_name)."')";
		
		
	         $STH = $DBH->prepare($sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	
	public function addViewSliderContent($slider_title,$slider_desc,$slider_image,$parents_slider_id,$slider_link)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                 $DBH->beginTransaction();
		$return = false;
		$time = time();
		
		$sql = "INSERT INTO `tblslidercontents` (`slider_title`,`slider_desc`,`slider_image`,`parents_slider_id`,`slider_link`,`slider_add_date`) VALUES ('".addslashes($slider_title)."' ,'".addslashes($slider_desc)."' ,'".addslashes($slider_image)."' ,'".addslashes($parents_slider_id)."' ,'".addslashes($slider_link)."','".$time."')";
		
		$STH = $DBH->prepare($sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function chkSliderExists($slider_name)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                 $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT * FROM `tblparentsliders` WHERE `slider_name` = '".$slider_name."'";
		$STH = $DBH->prepare($sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function chkEditSliderExists($slider_name,$parents_slider_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                 $DBH->beginTransaction();
		$return = false;
		
		$sql = "SELECT * FROM `tblparentsliders` WHERE `slider_name` = '".$slider_name."' AND `parents_slider_id` != '".$parents_slider_id."'";
		$STH = $DBH->prepare($sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function updateParentsSliderContent($slider_name,$parents_slider_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                 $DBH->beginTransaction();
                 $return=false;
		$upd_sql = "UPDATE `tblparentsliders` SET `slider_name` = '".addslashes($slider_name)."'  WHERE `parents_slider_id` = '".$parents_slider_id."'";
		$STH = $DBH->prepare($upd_sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function updateSliderContent($slider_title,$slider_desc,$slider_image,$parents_slider_id,$slider_link,$slider_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                 $DBH->beginTransaction();
                 $return=false;
		$upd_sql = "UPDATE `tblslidercontents` SET `slider_title` = '".addslashes($slider_title)."' ,`slider_desc` = '".addslashes($slider_desc)."' ,`slider_image` = '".addslashes($slider_image)."' ,`parents_slider_id` = '".addslashes($parents_slider_id)."' ,`slider_link` = '".addslashes($slider_link)."'  WHERE `slider_id` = '".$slider_id."'";
		
		$STH = $DBH->prepare($upd_sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function deleteSliderContents($slider_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                 $DBH->beginTransaction();
                 $return=false;
		$del_sql1 = "DELETE FROM `tblslidercontents` WHERE `slider_id` = '".$slider_id."'"; 
		$STH = $DBH->prepare($del_sql1);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function deleteViewSliderContents($slider_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                 $DBH->beginTransaction();
                 $return=false;
		$del_sql1 = "DELETE FROM `tblslidercontents` WHERE `slider_id` = '".$slider_id."'"; 
		$STH = $DBH->prepare($del_sql1);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function deleteParentsSliderContents($parents_slider_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                 $DBH->beginTransaction();
                 $return=false;
		$del_sql1 = "DELETE FROM `tblparentsliders` WHERE `parents_slider_id` = '".$parents_slider_id."'"; 
		$STH = $DBH->prepare($del_sql1);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function createThumbNailSingle($src_name,$dst_name, $new_w )
	{
		$system = explode('.',$src_name);
		$cmp = $system[count($system)-1];
		
		if( ($cmp == 'jpg') || ($cmp == 'jpeg') || ($cmp == 'JPG') || ($cmp == 'JPEG') )
		{
			$img = imagecreatefromjpeg("$src_name");
			if($img)
			{
				$old_x = imagesx($img);
				$old_y = imagesy($img);
				
			
				$thumb_w = $new_w;
				$thumb_h = floor( $old_y * ( $new_w / $old_x ) );
		
				$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
				imagecopyresampled($dst_img,$img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
		
				imagejpeg( $dst_img, "$dst_name" );
			}	
		}
		elseif( ($cmp == 'gif') || ($cmp == 'GIF') )
		{
			$img = imagecreatefromgif( "$src_name" );
			if($img)
			{
				$old_x = imagesx($img);
				$old_y = imagesy($img);
				
				$thumb_w = $new_w;
				$thumb_h = floor( $old_y * ( $new_w / $old_x ) );
		
				$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
				imagecopyresampled($dst_img,$img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
				
				imagegif( $dst_img, "$dst_name" );
			}	
		}
		elseif( ($cmp == 'png') || ($cmp == 'PNG') )
		{
			$img = imagecreatefrompng( "$src_name" );
			if($img)
			{
				$old_x = imagesx($img);
				$old_y = imagesy($img);
				
				$thumb_w = $new_w;
				$thumb_h = floor( $old_y * ( $new_w / $old_x ) );
		
				$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
				imagecopyresampled($dst_img,$img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
				
				imagepng( $dst_img, "$dst_name" );
			}	
		}
	}
	
}
?>