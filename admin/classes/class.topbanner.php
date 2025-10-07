<?php
include_once("class.paging.php");
include_once("class.admin.php");
class Banner extends Admin
{
	public function GetAllPages()
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$sql = "SELECT * FROM `tbltopbanner`  ORDER BY `banner_id` ASC ";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=top_banner");
	 	$STH = $DBH->prepare($page->get_limit_query($sql));
                $STH->execute();
		$output = '';		
		if($STH->rowCount() > 0)
		{
			$i = 1;
			while($row = $STH->fetch(PDO::FETCH_ASSOC))
			{
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
				//$output .= '<td height="30" align="center">'.stripslashes($row['banner_id']).'</td>';
				//$output .= '<td height="30" align="center">'.stripslashes($row['position']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['width']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['height']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['banner']).'</td>';
				//$output .= '<td height="30" align="center" nowrap="nowrap"><a href="index.php?mode=edit_top_banner&banner_id='.$row['banner_id'].'" ><img src = "images/edit.gif" border="0"></a></td>';
				$output .= '<td height="30" align="center" nowrap="nowrap"> <a href=\'javascript:fn_confirmdelete("Banner","sql/deltopbanner.php?banner_id='.$row['banner_id'].'")\' ><img src = "images/del.gif" border="0" ></a></td>';
				$output .= '</tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="4" align="center">NO PAGES FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function Add_Banner($image)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$ins_sql = "INSERT INTO `tbltopbanner`(`position`,`width`,`height`,`banner`,`status`) VALUES ('top','960','150','".addslashes($image)."','1')";
		//echo $sql;
		$STH = $DBH->prepare($ins_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function getBannerDetails($banner_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		
		
		$pisition = '';
		$width = '';
		$height = '';
	    $banner = '';
		
		$sql = "SELECT * FROM `tbltopbanner` WHERE `banner_id` = '".$banner_id."'";
		//echo $sql;
		
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			
			$position = stripslashes($row['position']);
			$width = stripslashes($row['width']);
			$height = stripslashes($row['height']);
			$banner = stripslashes($row['banner']);
			
		}
		return array($position,$width,$height,$banner);
	
	}
	public function DeleteBanner($banner_id)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		
		$sql = "DELETE from `tbltopbanner` WHERE `banner_id` = '".$banner_id."'";
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