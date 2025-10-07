<?php

include_once("class.paging.php");

include_once("class.admin.php");

class Stressbuster extends Admin

{

	public function GetAllPages($search)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '84';

		$delete_action_id = '86';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		if($search == '')

			{

				$sql = "SELECT * FROM `tblstressbusterbox` WHERE user_add_banner = 0 ORDER BY step ASC, status DESC, box_add_date DESC";

			}

		else

			{

		 		$sql = "SELECT * FROM `tblstressbusterbox` WHERE user_add_banner = 0 AND box_title like '%".$search."%' 

						ORDER BY step ASC,status DESC,box_add_date DESC";

			}

			

		$STH = $DBH->prepare($sql);
                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=stressbuster");

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

			    if($row['status'] == 1)

					{

						 $status = 'Active'; 

					}

					else

					{ 

						$status = 'Inactive';

					}

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['step']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['box_title']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['box_type']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['box_banner']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['day']).'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';
				
				$time= strtotime($row['box_add_date']);
						$time=$time+19800;
						$date = date('d-M-Y h:i A',$time);

				$output .= '<td height="30" align="center">'.$date.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_stressbuster&uid='.$row['stress_buster_box_id'].'" ><img src = "images/edit.gif" border="0"></a>';

						}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Stress Buster Box","sql/delstressbusterbox.php?uid='.$row['stress_buster_box_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr><td height="20" colspan="10" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row"><td height="30" colspan="10" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function GetAllUserUploads()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '84';

		$delete_action_id = '86';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		$sql = "SELECT * FROM `tblstressbusterbox` WHERE user_add_banner = 1 ORDER BY step ASC,box_add_date DESC ";

		

		$STH = $DBH->prepare($sql);
                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=stressbuster");

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

			   if($row['status'] == 1)

					{

						 $status = 'Active'; 

					}

					else

					{ 

						$status = 'Inactive';

					}

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['step']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['box_title']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['box_type']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['box_banner']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['day']).'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';
				
				$time= strtotime($row['box_add_date']);
						$time=$time+19800;
						$date = date('d-M-Y h:i A',$time);

				$output .= '<td height="30" align="center">'.$date.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_stressbuster&uid='.$row['stress_buster_box_id'].'&user_uploads=1" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Stress Buster Box","sql/delstressbusterbox.php?uid='.$row['stress_buster_box_id'].'&user_uploads=1")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr><td height="20" colspan="10" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row"><td height="30" colspan="10" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}





	public function GetAllStressBusterUserArea()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '131';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$sql = "SELECT * FROM `tbluserarea` WHERE `userarea_type` = 'Stressbuster' ORDER BY step ASC, userarea_add_date  DESC";

						

		$STH = $DBH->prepare($sql);
                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=manage_stressbuster_user_area");

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

				if($row['status'] == 1)

					{

						 $status = 'Active'; 

					}

					else

					{ 

						$status = 'Inactive';

					}

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['step']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['box_title']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['box_desc']).'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_stressbuster_user_area&uid='.$row['userarea_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr><td height="20" colspan="8" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row"><td height="30" colspan="8" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}



	public function getUserarea($id,$userarea_type)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$step = '';

		$box_title = '';

		$box_desc = '';

	 	

		$sql = "SELECT * FROM `tbluserarea` WHERE `userarea_id` = '".$id."' AND `userarea_type` = '".$userarea_type."'";

				

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$step = stripslashes($row['step']);

			$box_title = stripslashes($row['box_title']);

			$box_desc = stripslashes($row['box_desc']);

		}

		return array($step,$box_title,$box_desc);

	

	}

	

	public function Update_user_area($id,$box_title,$box_desc)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;

	$sql = "UPDATE `tbluserarea` SET `box_title` = '".addslashes($box_title)."' ,`box_desc` = '".addslashes($box_desc)."',`status` = '1'  WHERE `userarea_id` = '".$id."'";

	 //  echo $sql;

	 $STH = $DBH->prepare($sql);
        $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}	



	public function get_user_name($user_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$user_name = '';

		$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$name = stripslashes($row['name']);

		}

		return $name;

	}



	public function GetAllStressBusterPDFPages()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '84';

		$delete_action_id = '86';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		$sql = "SELECT * FROM `tblstressbusterpdf` ORDER BY step ASC,status DESC,stress_buster_pdf_add_date DESC";

		

		$STH = $DBH->prepare($sql);
                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=manage_pdf");

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

				if($row['status'] == 1)

				{

					 $status = 'Active'; 

				}

				else

				{ 

					$status = 'Inactive';

				}

					

				if($row['user_uploads'] == '1')

				{

					if($row['user_id'] > 0)

					{

						$obj2 = new Stressbuster();

						$uploded_by = $obj2->get_user_name($row['user_id']);

					}

					else

					{

						$uploded_by = 'Anaonymous';

					}

				}

				else

				{

					$uploded_by = 'Admin';	

				}

				

				$obj2 = new Stressbuster();

					

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['step']).'</td>';

				$output .= '<td height="30" align="center"><a href="'.SITE_URL."/uploads/".stripslashes($row['pdf']).'" target="_blank">'.stripslashes($row['pdf']).'</a></td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['day']).'</td>';

				$output .= '<td height="30" align="center">'.$uploded_by.'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';
				
				$time= strtotime($row['stress_buster_pdf_add_date']);
						$time=$time+19800;
						$date = date('d-M-Y h:i A',$time);

				$output .= '<td height="30" align="center">'.$date.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_pdf&uid='.$row['stress_buster_pdf_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("PDF File","sql/delpdf.php?uid='.$row['stress_buster_pdf_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr><td height="20" colspan="9" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row"><td height="30" colspan="9" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	

	

	public function GetAllStressBusterMusic()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '84';

		$delete_action_id = '86';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		$sql = "SELECT * FROM `tblmusic` ORDER BY step ASC, music_add_date DESC";

						

		$STH = $DBH->prepare($sql);
                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=manage_background_music");

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

				if($row['status'] == 1)

					{

						 $status = 'Active'; 

					}

					else

					{ 

						$status = 'Inactive';

					}

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['step']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['music']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['day']).'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';
				
				$time= strtotime($row['music_add_date']);
						$time=$time+19800;
						$date = date('d-M-Y h:i A',$time);


				$output .= '<td height="30" align="center">'.$date.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_music&uid='.$row['music_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Music","sql/delmusic.php?uid='.$row['music_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr><td height="20" colspan="8" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row"><td height="30" colspan="8" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function GetAllSoundClip()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '96';

		$delete_action_id = '98';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		$sql = "SELECT * FROM `tblsoundclip` ORDER BY sound_clip_add_date DESC ";

						

		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=click_sound");

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

				if($row['status'] == 1)

					{

						 $status = 'Active'; 

					}

					else

					{ 

						$status = 'Inactive';

					}

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['sound_clip']).'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				       if($edit) {

				$output .= '<a href="index.php?mode=edit_sound_clip&uid='.$row['sound_clip_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Sound Clip","sql/delsound.php?uid='.$row['sound_clip_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="5" align="center">NO PAGES FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	

	

	public function Add_StressBuster($step,$box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url,$day,$sound_clip_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$return = false;

		$ins_sql = "INSERT INTO `tblstressbusterbox`(`step`,`box_title`,`box_type`,`box_banner`,`box_desc`,`day`,`credit_line`,`credit_line_url`,`sound_clip_id`,`status`,`user_add_banner`) VALUES ('".addslashes($step)."','".addslashes($box_title)."','".addslashes($banner_type)."','".addslashes($banner)."','".addslashes($box_desc)."','".addslashes($day)."' ,'".addslashes($credit_line)."','".addslashes($credit_line_url)."','".addslashes($sound_clip_id)."','1','0')";

		

		$STH = $DBH->prepare($ins_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function Add_StressBusterPDF($step,$pdf,$credit,$credit_url,$pdf_title,$day)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$ins_sql = "INSERT INTO `tblstressbusterpdf`(`step`,`pdf`,`credit`,`credit_url`,`pdf_title`,`day`,`status`) VALUES ('".addslashes($step)."','".addslashes($pdf)."','".addslashes($credit)."','".addslashes($credit_url)."','".addslashes($pdf_title)."','".addslashes($day)."','1')";

		

		$STH = $DBH->prepare($ins_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;


	}

	

	public function Add_StressBusterMusic($step,$music,$day,$credit,$credit_url)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;

		$ins_sql = "INSERT INTO `tblmusic`(`step`,`music`,`day`,`credit`,`credit_url`,`status`) VALUES ('".addslashes($step)."','".addslashes($music)."','".addslashes($day)."','".addslashes($credit)."','".addslashes($credit_url)."','1')";

		$STH = $DBH->prepare($ins_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function Add_StressBusterSoundClip($music)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;

		$ins_sql = "INSERT INTO `tblsoundclip`(`sound_clip`,`status`) VALUES ('".addslashes($music)."','1')";

		$STH = $DBH->prepare($ins_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function Add_Tooltip($page_id,$contents)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;

		$sql = "UPDATE `tbltooltip` set `page_id` = '".addslashes($page_id)."' ,`text` = '".addslashes($contents)."'";

	

		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function getSressBusterBannerDetails($stress_buster_box_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
               

		$step = '';

		$box_title = '';

		$box_type = '';

		$box_desc = '';

	    $banner = '';

		$status = '';

		$day = '';

		$sound_clip_id = '';

		

		$sql = "SELECT TA.step as step,TA.box_title as box_title,TA.box_type as box_type,TA.box_desc as box_desc,TA.box_banner as box_banner,TA.status as status,TA.day as day,

				TA.credit_line as credit_line,TA.credit_line_url as credit_line_url,TA.sound_clip_id as sound_clip_id FROM `tblstressbusterbox` AS TA

				

				 WHERE `stress_buster_box_id` = '".$stress_buster_box_id."'";

				

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$step = stripslashes($row['step']);

			$box_title = stripslashes($row['box_title']);

			$banner_type = stripslashes($row['box_type']);

			$box_desc = stripslashes($row['box_desc']);

			$banner = stripslashes($row['box_banner']);

			$status = stripslashes($row['status']);

			$credit_line = stripslashes($row['credit_line']);

			$credit_line_url = stripslashes($row['credit_line_url']);

			$day = stripslashes($row['day']);

			$sound_clip_id = stripslashes($row['sound_clip_id']);

		}

		return array($step,$box_title,$banner_type,$box_desc,$banner,$status,$credit_line,$credit_line_url,$day,$sound_clip_id);

	

	}

	

	public function getSressBusterPDFDetails($stress_buster_pdf_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		

		$step = '';

		$pdf = '';

			

		$sql = "SELECT * FROM `tblstressbusterpdf` WHERE `stress_buster_pdf_id` = '".$stress_buster_pdf_id."'";

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$step = stripslashes($row['step']);

			$pdf = stripslashes($row['pdf']);

			$credit = stripslashes($row['credit']);

			$credit_url = stripslashes($row['credit_url']);

			$pdf_title = stripslashes($row['pdf_title']);

			$day = stripslashes($row['day']);

			$status = stripslashes($row['status']);

		}

		return array($step,$pdf,$credit,$credit_url,$pdf_title,$day,$status);

	

	}

	

	public function getToolTipContents()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$contents = '';

		$sql = "SELECT * FROM `tbltooltip` WHERE `page_id` = '9'";

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$contents = stripslashes($row['text']);

		}

		return $contents;

	

	}

	

	public function getSressBusterMusicDetails($music_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$step = '';

		$music = '';

		$day = '';

		$credit = '';

		$credit_url = '';

		$status = '';

			

		$sql = "SELECT * FROM `tblmusic` WHERE `music_id` = '".$music_id."'";

		

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$step = stripslashes($row['step']);

			$music = stripslashes($row['music']);

			$day= stripslashes($row['day']);

			$credit= stripslashes($row['credit']);

			$credit_url= stripslashes($row['credit_url']);

			$status = stripslashes($row['status']);

		}

		return array($step,$music,$day,$credit,$credit_url,$status);

	

	}

	

	public function getSressBusterSoundDetails($uid)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$step = '';

		$music = '';

		$status = '';

			

		$sql = "SELECT * FROM `tblsoundclip` WHERE `sound_clip_id` = '".$uid."'";

		

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$step = stripslashes($row['step']);

			$music = stripslashes($row['sound_clip']);

			$status = stripslashes($row['status']);

		}

		return array($step,$music,$status);

	

	}

	

	public function Update_StressBusterBanner($step,$status,$box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url,$day,$sound_clip_id,$banner_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                  $return=false;
	$sql = "UPDATE `tblstressbusterbox` SET `step` = '".addslashes($step)."' , `box_title` = '".addslashes($box_title)."' , `box_type` = '".addslashes($banner_type)."', `box_banner` = '".addslashes($banner)."', `box_desc` = '".addslashes($box_desc)."',`credit_line` = '".addslashes($credit_line)."',`credit_line_url` = '".addslashes($credit_line_url)."',`status` = '".addslashes($status)."',`day` = '".addslashes($day)."' ,`sound_clip_id` = '".addslashes($sound_clip_id)."'  WHERE `stress_buster_box_id` = '".$banner_id."'";

	 //echo $sql;

	  $STH = $DBH->prepare($sql);
          $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function Update_StressBusterPDF($step,$pdf,$credit,$credit_url,$pdf_title,$status,$day,$stress_buster_pdf_id) 

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                  $return=false;

	$sql = "UPDATE `tblstressbusterpdf` SET `step` = '".addslashes($step)."' , `pdf` = '".addslashes($pdf)."' ,`credit` = '".addslashes($credit)."' , `credit_url` = '".addslashes($credit_url)."' ,`pdf_title` = '".addslashes($pdf_title)."' , `status` = '".addslashes($status)."' ,`day` = '".addslashes($day)."'   WHERE `stress_buster_pdf_id` = '".$stress_buster_pdf_id."'";

	  	 $STH = $DBH->prepare($sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function Update_StressBusterMusic($step,$music,$day,$credit,$credit_url,$status,$music_id) 

	{

		
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                  $return=false;

		$sql = "UPDATE `tblmusic` SET `step` = '".addslashes($step)."' , `music` = '".addslashes($music)."' ,`day` = '".addslashes($day)."' ,`credit` = '".addslashes($credit)."' ,`credit_url` = '".addslashes($credit_url)."' ,`status` = '".addslashes($status)."'    WHERE `music_id` = '".$music_id."'";

	  	//echo $sql;

		 $STH = $DBH->prepare($sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;


	}

	

	public function Update_StressBusterSound($music,$status,$sound_clip_id) 

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                  $return=false;

		$sql = "UPDATE `tblsoundclip` SET  `sound_clip` = '".addslashes($music)."' ,`status` = '".addslashes($status)."' WHERE `sound_clip_id` = '".$sound_clip_id."'";

	  

		$STH = $DBH->prepare($sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function DeleteStressBusterBox($uid)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;

		

		$sql = "DELETE  FROM `tblstressbusterbox` WHERE `stress_buster_box_id` = '".$uid."'";

		$STH = $DBH->prepare($sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;


	}

	

	public function DeleteSound($uid)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;

		$sql = "DELETE  FROM `tblsoundclip` WHERE `sound_clip_id` = '".$uid."'";

		$STH = $DBH->prepare($sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;


	}

	

	public function DeletePDF($uid)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;

		$sql = "DELETE FROM `tblstressbusterpdf`  WHERE `stress_buster_pdf_id` = '".$uid."'";

		$STH = $DBH->prepare($sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;


	}

	

	public function DeleteMusic($uid)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$sql = "DELETE FROM `tblmusic` WHERE `music_id` = '".$uid."'";

		

		$STH = $DBH->prepare($sql);
                 $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;


	}

	

	public function getStressBusterBannerString($banner)

	{

		$search = 'v=';

		$pos = strpos($banner, $search);

		$str = strlen($banner);

		$rest = substr($banner, $pos+2, $str);

		return 'http://www.youtube.com/embed/'.$rest;

	}

	

	public function getSoundClipOptions($sound_clip_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$option_str = '';		

		

		$sql = "SELECT * FROM `tblsoundclip` where `status` = 1 ORDER BY `sound_clip_add_date` ASC";

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['sound_clip_id'] == $sound_clip_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['sound_clip_id'].'" '.$sel.'>'.$row['sound_clip'].'</option>';

			}

		}

		return $option_str;

	}

	



}

?>