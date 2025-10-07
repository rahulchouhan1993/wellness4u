<?php
include_once("class.paging.php");
include_once("class.admin.php");
class Angervent extends Admin

{
	public function GetAllPages($search)
	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '88';
		$delete_action_id = '90';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		if($search == '')

			{

				$sql = "SELECT * FROM `tblangervent`	WHERE user_add_banner = 0 ORDER BY step ASC, status DESC, box_add_date DESC";

			}

		else

			{

		 		$sql = "SELECT * FROM `tblangervent`	WHERE user_add_banner = 0 AND box_title like '%".$search."%' 

						ORDER BY step ASC, status DESC, box_add_date DESC";

			}

			

		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=angervent");
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

				$output .= '<a href="index.php?mode=edit_angervent&uid='.$row['anger_vent_box_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Angervent Box","sql/delangervent.php?uid='.$row['anger_vent_box_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

								}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr><td height="20" colspan="10" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row"><td  height="30" colspan="10" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function GetAllAngerVentUserUploads()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '88';
		$delete_action_id = '90';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
                $sql = "SELECT  * FROM `tblangervent` WHERE user_add_banner = 1 ORDER BY step ASC,box_add_date DESC";
		$STH = $DBH->prepare($sql);
                $STH->execute();

		$total_records = $STH->rowCount() ;

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=angervent");

	 	//$result=$this->execute_query($page->get_limit_query($sql));
                $STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();
		$output = '';		

		if($STH2->rowCount()  > 0)

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

				$output .= '<a href="index.php?mode=edit_angervent&uid='.$row['anger_vent_box_id'].'&user_uploads=1" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

					if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Anger Vent Box","sql/delangervent.php?uid='.$row['anger_vent_box_id'].'&user_uploads=1")\' ><img src = "images/del.gif" border="0" ></a>';

					}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr><td height="20" colspan="10" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row"><td  height="30" colspan="10" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}



	public function GetAllAngerVentPDF()

	{

		//$this->connectDB();

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '88';
		$delete_action_id = '90';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		$sql = "SELECT * FROM `tblangerventpdf` ORDER BY step ASC, anger_vent_pdf_add_date DESC ";
		$STH = $DBH->prepare($sql);
                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=angervent_pdf");

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

						$obj2 = new Angervent();

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

				

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['step']).'</td>';

				$output .= '<td height="30" align="center"><a href="'.SITE_URL."/uploads/".stripslashes($row['pdf']).'" target="_blank">'.stripslashes($row['pdf']).'</a></td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['day']).'</td>';

				$output .= '<td height="30" align="center">'.$uploded_by.'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';
				
				$time= strtotime($row['anger_vent_pdf_add_date']);
						$time=$time+19800;
						$date = date('d-M-Y h:i A',$time);
						
				$output .= '<td height="30" align="center">'.$date.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

							if($edit) {

				$output .= '<a href="index.php?mode=edit_angevent_pdf&uid='.$row['anger_vent_pdf_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}	

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

							if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("PDF File","sql/delangerventpdf.php?uid='.$row['anger_vent_pdf_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

								}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr><td height="20" colspan="9" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row"><td  height="30" colspan="9" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function get_user_name($user_id)

	{

	//	$this->connectDB();
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
				
		$user_name = '';

		$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";

		//$this->execute_query($sql);
		$STH = $DBH->prepare($sql);
                $STH->execute();
				
		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$name = stripslashes($row['name']);

		}

		return $name;

	}

	

	public function GetAllAngerVentmusic()

	{

		//$this->connectDB();
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '88';

		$delete_action_id = '90';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		$sql = "SELECT * FROM `tblangerventmusic` ORDER BY step ASC, music_add_date DESC";

		$STH = $DBH->prepare($sql);
                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=manage_anger_vent_bk_music");

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

				$output .= '<a href="index.php?mode=edit_anger_vent_music&uid='.$row['anger_vent_music_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Music","sql/delangerventmusic.php?uid='.$row['anger_vent_music_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

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

	

	public function GetAllAngerVentUserArea()

	{

		//$this->connectDB();
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '130';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$sql = "SELECT * FROM `tbluserarea` WHERE `userarea_type` = 'Angervent' ORDER BY step ASC, userarea_add_date  DESC";

						

		//$this->execute_query($sql);
		$STH = $DBH->prepare($sql);
                $STH->execute();
				

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=manage_anger_vent_user_area");

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

				$output .= '<a href="index.php?mode=edit_angervent_user_area&uid='.$row['userarea_id'].'" ><img src = "images/edit.gif" border="0"></a>';

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

	

	

	public function Add_Angervent($step,$box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url,$day,$sound_clip_id)

	{

		//$this->connectDB();
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
		$ins_sql = "INSERT INTO `tblangervent`(`step`,`box_title`,`box_type`,`box_banner`,`box_desc`,`day`,`credit_line`,`credit_line_url`,`sound_clip_id`,`status`,`user_add_banner`) VALUES ('".addslashes($step)."','".addslashes($box_title)."','".addslashes($banner_type)."','".addslashes($banner)."','".addslashes($box_desc)."','".addslashes($day)."' ,'".addslashes($credit_line)."','".addslashes($credit_line_url)."','".addslashes($sound_clip_id)."','1','0')";

		//$this->execute_query($ins_sql);
		$STH = $DBH->prepare($ins_sql);
                $STH->execute();

		if($STH->rowCount() > 0)
                {
                     $return = true;
                }
                return $return;

	}

	

	

	public function Add_AngerVentPDF($step,$pdf,$credit,$credit_url,$pdf_title,$day)

	{

		//$this->connectDB();
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
		$ins_sql = "INSERT INTO `tblangerventpdf`(`step`,`pdf`,`credit`,`credit_url`,`pdf_title`,`day`,`status`) VALUES ('".addslashes($step)."','".addslashes($pdf)."','".addslashes($credit)."','".addslashes($credit_url)."','".addslashes($pdf_title)."','".addslashes($day)."','1')";

		//$this->execute_query($ins_sql);
		$STH = $DBH->prepare($ins_sql);
                $STH->execute();

		if($STH->rowCount() > 0)
                {
                     $return = true;
                }
                return $return;

	}

	

	public function Add_AngerVentMusic($step,$music,$day,$credit,$credit_url)

	{

		//$this->connectDB();
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
		$ins_sql = "INSERT INTO `tblangerventmusic`(`step`,`music`,`day`,`credit`,`credit_url`,`status`) VALUES ('".addslashes($step)."','".addslashes($music)."','".addslashes($day)."','".addslashes($credit)."','".addslashes($credit_url)."','1')";

                $STH = $DBH->prepare($ins_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
                {
                     $return = true;
                }
                return $return;

	}

	

	public function Add_Angervent_user_area($step,$box_title,$box_desc,$userarea_type)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;

		$ins_sql = "INSERT INTO `tbluserarea`(`step`,`box_title`,`box_desc`,`userarea_type`,`status`) VALUES ('".addslashes($step)."','".addslashes($box_title)."','".addslashes($box_desc)."','".addslashes($userarea_type)."','1')";

		//$this->execute_query($ins_sql);
		
                $STH = $DBH->prepare($ins_sql);
                $STH->execute();
		if($STH->rowCount() > 0)
                {
                     $return = true;
                }
                return $return;

	}

	

	public function AddAngerventToolTip($page_id,$contents)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
		$sql = "UPDATE `tblangerventtooltip` set `page_id` = '".addslashes($page_id)."' ,`text` = '".addslashes($contents)."'";

		//$this->execute_query($sql);
                $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
                {
                     $return = true;
                }
                return $return;

	}

	

	

	

	public function getAngerVentBannerDetails($anger_vent_box_id)

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

		$sql = "SELECT * FROM `tblangervent` WHERE `anger_vent_box_id` = '".$anger_vent_box_id."'";

                $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount()  > 0)

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

			$stress = stripslashes($row['stress']);

			$day = stripslashes($row['day']);

			$sound_clip_id = stripslashes($row['sound_clip_id']);

		}

		return array($step,$box_title,$banner_type,$box_desc,$banner,$status,$stress,$credit_line,$credit_line_url,$day,$sound_clip_id);

	

	}

	

	public function getAngerVentUserarea($id,$userarea_type)

	{

		//$this->connectDB();
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$step = '';

		$box_title = '';

		$box_desc = '';

	 	

		$sql = "SELECT * FROM `tbluserarea` WHERE `userarea_id` = '".$id."' AND `userarea_type` = '".$userarea_type."'";

				

		//$this->execute_query($sql);
		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount()  > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$step = stripslashes($row['step']);

			$box_title = stripslashes($row['box_title']);

			$box_desc = stripslashes($row['box_desc']);

		}

		return array($step,$box_title,$box_desc);

	

	}

	

	public function getAngerventPDFDetails($angervent_pdf_id)

	{
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();$this->connectDB();

		

		$step = '';

		$pdf = '';

		$credit ='';

		$credit_url = '';

		$pdf_title ='';

		$day ='';

		$status ='';

			

		$sql = "SELECT * FROM `tblangerventpdf` WHERE `anger_vent_pdf_id` = '".$angervent_pdf_id."'";

		//$this->execute_query($sql);
                $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount()  > 0)

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

	

	public function getAngerventToolTip()

	{

                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$contents = '';

		$sql = "SELECT * FROM `tblangerventtooltip` WHERE `page_id` = '10'";

		//$this->execute_query($sql);
		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount()  > 0)

		{

                        $row = $STH->fetch(PDO::FETCH_ASSOC);

			$contents = stripslashes($row['text']);

		}

		return $contents;

	

	}

	

	public function getAngerVentMusicDetails($music_id)

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

			

		$sql = "SELECT * FROM `tblangerventmusic` WHERE `anger_vent_music_id` = '".$music_id."'";

		

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount()  > 0)

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

		//$this->execute_query($sql);
                $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount()  > 0)

		{

                        $row = $STH->fetch(PDO::FETCH_ASSOC);

			$step = stripslashes($row['step']);

			$music = stripslashes($row['sound_clip']);

			$status = stripslashes($row['status']);

		}

		return array($step,$music,$status);

	

	}

	

	public function Update_AngerVent($step,$status,$box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url,$day,$sound_clip_id,$banner_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
                $sql = "UPDATE `tblangervent` SET `step` = '".addslashes($step)."' , `box_title` = '".addslashes($box_title)."' , `box_type` = '".addslashes($banner_type)."', `box_banner` = '".addslashes($banner)."', `box_desc` = '".addslashes($box_desc)."',`credit_line` = '".addslashes($credit_line)."',`credit_line_url` = '".addslashes($credit_line_url)."',`status` = '".addslashes($status)."',`day` = '".addslashes($day)."' ,`sound_clip_id` = '".addslashes($sound_clip_id)."'  WHERE `anger_vent_box_id` = '".$banner_id."'";
                $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount()  > 0)

		{
                 $return = true;
                }
                 return $return;
	}	

	

	public function Update_Angervent_user_area($id,$box_title,$box_desc)

	{

                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
                $sql = "UPDATE `tbluserarea` SET `box_title` = '".addslashes($box_title)."' ,`box_desc` = '".addslashes($box_desc)."',`status` = '1'  WHERE `userarea_id` = '".$id."'";

                $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
                {
                     $return = true;
                }
                return $return;

	}	

	

	

	public function Update_AngerVentPDF($step,$pdf,$credit,$credit_url,$pdf_title,$status,$day,$pdf_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
                $sql = "UPDATE `tblangerventpdf` SET `step` = '".addslashes($step)."' , `pdf` = '".addslashes($pdf)."' ,`credit` = '".addslashes($credit)."' , `credit_url` = '".addslashes($credit_url)."' ,`pdf_title` = '".addslashes($pdf_title)."' , `status` = '".addslashes($status)."' ,`day` = '".addslashes($day)."'   WHERE `anger_vent_pdf_id` = '".$pdf_id."'";
	  	//$this->execute_query($sql);
                $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
                {
                     $return = true;
                }
                return $return;

	}

	

	public function Update_AngerVentMusic($step,$music,$day,$credit,$credit_url,$status,$music_id) 

	{

                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
		$sql = "UPDATE `tblangerventmusic` SET `step` = '".addslashes($step)."' , `music` = '".addslashes($music)."' ,`day` = '".addslashes($day)."' ,`credit` = '".addslashes($credit)."' ,`credit_url` = '".addslashes($credit_url)."' ,`status` = '".addslashes($status)."'    WHERE `anger_vent_music_id` = '".$music_id."'";

                $STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)
                {
                     $return = true;
                }
                return $return;

	}

	

	public function DeleteAngervent($uid)

	{
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
		$sql = "DELETE  FROM `tblangervent` WHERE `anger_vent_box_id` = '".$uid."'";
		//$this->execute_query($sql);
                $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
                {
                     $return = true;
                }
                return $return;

	}

	

	public function DeleteAngerventPDF($uid)

	{

		//$this->connectDB();
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
		$sql = "DELETE FROM `tblangerventpdf`  WHERE `anger_vent_pdf_id` = '".$uid."'";

		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
                {
                     $return = true;
                }
                return $return;

	}

	

	public function DeleteAngerVentMusic($uid)

	{

		//$this->connectDB();
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return = false;
		$sql = "DELETE FROM `tblangerventmusic` WHERE `anger_vent_music_id` = '".$uid."'";

		//$this->execute_query($sql);
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

		//$this->execute_query($sql);
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