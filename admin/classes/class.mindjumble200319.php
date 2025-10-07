<?php

include_once("class.paging.php");

include_once("class.admin.php");

class Mindjumble extends Admin

{
	public function GetAllPages($search)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '92';

		$delete_action_id = '94';

				

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		if($search == '')

		{

			$sql = "SELECT * FROM `tblmindjumble`WHERE user_add_banner = 0 ORDER BY status DESC,box_add_date DESC";

		}

		else

		{

			$sql = "SELECT * FROM `tblmindjumble` WHERE user_add_banner = 0 AND box_title like '%".$search."%' 

					ORDER BY status DESC,box_add_date DESC";

		}

			

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=mindjumble");

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

			

			while($row = $row = $STH2->fetch(PDO::FETCH_ASSOC))

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

				$output .= '<a href="index.php?mode=edit_mindjumble&uid='.$row['mind_jumble_box_id'].'" ><img src = "images/edit.gif" border="0"></a>';

						}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Mind Jumble Box","sql/delmindjumble.php?uid='.$row['mind_jumble_box_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

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

	

	public function GetAllMindJumbleUserUploads()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '347';
		$delete_action_id = '348';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		$sql = "SELECT * FROM `tbl_user_uploads` WHERE `is_deleted` = 0 ORDER BY status DESC,add_date DESC";
		$STH = $DBH->prepare($sql);
                $STH->execute();
		$total_records=$STH->rowCount();
		$record_per_page=100;
		$scroll=5;
		$page=new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=mindjumble");
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
                        $obj2 = new Mindjumble();
			while($row = $row = $STH->fetch(PDO::FETCH_ASSOC))
			{
			   if($row['status'] == 1)
					{
						 $status = 'Active'; 
					}
					else
					{ 
						$status = 'Inactive';
					}
                                 
                                $user_data = $obj2->getUserDetails($row['user_id']);
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';
                                
                                $output .= '<td height="30" align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_user_uploads&uid='.$row['id'].'&user_uploads=1" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("USER UPLOADS DELETE","sql/delmindjumble.php?uid='.$row['id'].'&user_uploads=1")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';
				                
                                 $output .= '<td height="30" align="center">'.$row['admin_notes'].'</td>';
                                 $output .= '<td height="30" align="center">'.$row['user_tags'].'</td>';
                                 $output .= '<td height="30" align="center">'.$row['admin_tags'].'</td>';
                                
                                 $output .= '<td height="30" align="center">'.stripslashes($row['show_where']).'</td>';
                                $user_show = ($row['user_show'] == 1 ? 'Yes' : 'No');
				$output .= '<td height="30" align="center">'.$user_show.'</td>';
                                $output .= '<td height="30" align="center">'.$user_data['name'].' '.$user_data['middle_name'].' '.$user_data['last_name'].'</td>';
                                $output .= '<td height="30" align="center">'.$user_data['unique_id'].'</td>';
                                $output .= '<td height="30" align="center">'.stripslashes($row['box_title']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['sub_cat_id']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['ref_code']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['from_page']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['banner_type']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['rss_text']).'</td>';
                                
                                if($row['banner_type'] == 'image')
                                {
                                    $output .= '<td height="30" align="center"><a href="../uploads/'.$row['image_video_audio_pdf'].'" target="_blank"><img src="../uploads/'.$row['image_video_audio_pdf'].'" style="width:50px; height:50px;" /></a></td>';   
                                }
                                else if($row['banner_type'] == 'pdf')
                                {
                                    $output .= '<td height="30" align="center"><a href="../uploads/'.$row['image_video_audio_pdf'].'" target="_blank">View</a></td>';   
                                }
                                else
                                {
                                   $output .= '<td height="30" align="center">&nbsp;</td>';    
                                }
                                
                                if($row['banner_type'] == 'video')
                                {
                                    $output .= '<td height="30" align="center">'.$row['video_url'].'</td>';   
                                }
                                else if($row['banner_type'] == 'audio')
                                {
                                    $output .= '<td height="30" align="center">'.$row['video_url'].'</td>';   
                                }
                                else
                                {
                                   $output .= '<td height="30" align="center">&nbsp;</td>';    
                                }
                                
                                $output .= '<td height="30" align="center">'.stripslashes($row['image_video_audio_pdf_credit_line']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['image_video_audio_pdf_credit_url']).'</td>';
                                
                                if($row['documents']!='')
                                {
                                    $file4 = substr($row['documents'], -4, 4);
                                    if (($file4 == '.jpg') || ($file4 == '.JPG') || ($file4 == 'jpeg') || ($file4 == 'JPEG') || ($file4 == '.gif') || ($file4 == '.GIF') || ($file4 == '.png') || ($file4 == '.PNG'))
                                    {
                                        
                                       $output .= '<td height="30" align="center"><a href="../uploads/'.$row['documents'].'" target="_blank"><img src="../uploads/'.$row['documents'].'" style="width:50px; height:50px;" /></a></td>';   
                                    }
                                    else
                                    {
                                        $output .= '<td height="30" align="center"><a href="../uploads/'.$row['documents'].'" target="_blank">View</a></td>'; 
                                    }
                                }
                                else
                                {
                                   $output .= '<td height="30" align="center">&nbsp;</td>';    
                                }
                                
                                
                                $output .= '<td height="30" align="center">'.stripslashes($row['documents_credit_line']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['documents_credit_url']).'</td>';
                                
                                $output .= '<td height="30" align="center">'.$status.'</td>';
                                
                                $time= strtotime($row['add_date']);
                                $time=$time+19800;
                                $date = date('d-M-Y h:i A',$time);

				$output .= '<td height="30" align="center">'.$date.'</td>';
                                
                                if($row['approved_by']!=0)
                                {
                                $output .= '<td height="30" align="center">'.stripslashes($obj2->getAdminNameRam($row['approved_by'])).'</td>';
                                }
                                else
                                {
                                  $output .= '<td height="30" align="center"></td>';  
                                }
                                if($row['approved_date']!='0000-00-00 00:00:00')
                                {
				$output .= '<td height="30" align="center">'.stripslashes(date("d-m-Y H:i:s",strtotime($row['approved_date']))).'</td>';
                                }
                                else
                                {
                                  $output .= '<td height="30" align="center"></td>';  
                                }
				

				

				$output .= '</tr>';

				$output .= '<tr><td height="2px" colspan="27" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row"><td colspan="25" align="center">NO PAGES FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function GetAllMindjumbleUserArea()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '327';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$sql = "SELECT * FROM `tbluserarea` WHERE `userarea_type` = 'Mindjumble' ORDER BY step ASC, userarea_add_date  DESC";

						

		  $STH = $DBH->prepare($sql);
                  $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=manage_anger_vent_user_area");

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

			while($row = $row = $STH2->fetch(PDO::FETCH_ASSOC))

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

				$output .= '<a href="index.php?mode=edit_mindjumble_user_area&uid='.$row['userarea_id'].'" ><img src = "images/edit.gif" border="0"></a>';

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

			$row = $row = $STH->fetch(PDO::FETCH_ASSOC);

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
               $return=false;
	$sql = "UPDATE `tbluserarea` SET `box_title` = '".addslashes($box_title)."' ,`box_desc` = '".addslashes($box_desc)."',`status` = '1'  WHERE `userarea_id` = '".$id."'";

	   echo $sql;

	    $STH = $DBH->prepare($sql);  
            $STH->execute();

		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}	

	

	

	public function GetTitle($search)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '92';

		$delete_action_id = '94';

				

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		if($search == '')

			{

				$sql = "SELECT * FROM `tbltitle`  ORDER BY status DESC,title_add_date DESC";

		 	}

		else

			{

				$sql = "SELECT * FROM `tbltitle` WHERE `title` like '%".$search."%'   ORDER BY status DESC,title_add_date DESC";

			}

			

		  $STH = $DBH->prepare($sql);
                  $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=title");

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

			while($row = $row = $STH2->fetch(PDO::FETCH_ASSOC))

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

				$output .= '<td height="30" align="center">'.stripslashes($row['title']).'</td>';

				$output .= '<td height="30" align="center"><a href="index.php?mode=narration&uid='.$row['title_id'].'">View Narrations</a></td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';
				
				$time= strtotime($row['title_add_date']);
						$time=$time+19800;
						$date = date('d-M-Y h:i A',$time);

				$output .= '<td height="30" align="center">'.$date.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_title&uid='.$row['title_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Mind Jumble Box Title","sql/delmindjumbletitle.php?uid='.$row['title_id'].'&user_uploads=1")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr><td height="20" colspan="7" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row"><td height="30" colspan="7" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	

	public function GetNarration($search,$id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '92';

		$delete_action_id = '94';

				

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		if($search == '')

			{

				$sql = "SELECT * FROM `tblnarration` as TA

						LEFT JOIN `tbltitle` AS TS ON TA.title_id = TS.title_id

						WHERE TA.title_id = '".$id."'   ORDER BY TA.status DESC,narration_add_date DESC";

		 	}

		else

			{

				$sql = "SELECT * FROM `tblnarration`  as TA

						LEFT JOIN `tbltitle` AS TS ON TA.title_id = TS.title_id

						 WHERE TA.title_id = '".$id."' AND `narration` like '%".$search."%'   

						 ORDER BY TA.status DESC,narration_add_date DESC";

			}

			

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=narration");

	 	
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

			while($row = $row = $STH2->fetch(PDO::FETCH_ASSOC))

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

				$output .= '<td height="30" align="center">'.stripslashes($row['title']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['narration']).'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';
				
				$time= strtotime($row['narration_add_date']);
						$time=$time+19800;
						$date = date('d-M-Y h:i A',$time);


				$output .= '<td height="30" align="center">'.$date.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_narration&uid='.$row['narration_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Mind Jumble Box Narration","sql/delmindjumblenarration.php?id='.$row['narration_id'].'&uid='.$row['title_id'].'&user_uploads=1")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr><td height="20" colspan="7" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row"><td  height="30" colspan="7" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	



	public function GetAllMindJumblePDF()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '92';

		$delete_action_id = '94';

				

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		$sql = "SELECT * FROM `tblmindjumblepdf` ORDER BY status DESC, mind_jumble_pdf_add_date DESC";

		

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=mindjumble_pdf");

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

			while($row = $row = $STH->fetch(PDO::FETCH_ASSOC))

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

							$obj2 = new Mindjumble();

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

				$output .= '<td height="30" align="center"><a href="'.SITE_URL."/uploads/".stripslashes($row['pdf']).'" target="_blank">'.stripslashes($row['pdf']).'</a></td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['day']).'</td>';

				$output .= '<td height="30" align="center">'.$uploded_by.'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';
				
				$time= strtotime($row['mind_jumble_pdf_add_date']);
						$time=$time+19800;
						$date = date('d-M-Y h:i A',$time);


				$output .= '<td height="30" align="center">'.$date.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_mindjumble_pdf&uid='.$row['mind_jumble_pdf_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("PDF File","sql/delmindjumblepdf.php?uid='.$row['mind_jumble_pdf_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

						}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr><td height="20" colspan="8" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO PAGES FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

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

			$row = $row = $STH->fetch(PDO::FETCH_ASSOC);

			$name = stripslashes($row['name']);

		}

		return $name;

	}

	

	public function GetMindJumblemusic()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '323';

		$delete_action_id = '324';

				

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		$sql = "SELECT * FROM `tblmindjumblemusic` ORDER BY music_add_date DESC";

						

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=mindjumble_bk_music");

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

			while($row = $row = $STH2->fetch(PDO::FETCH_ASSOC))

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

				$output .= '<td height="30" align="center">'.stripslashes($row['music']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['day']).'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';
				
				$time= strtotime($row['music_add_date']);
						$time=$time+19800;
						$date = date('d-M-Y h:i A',$time);


				$output .= '<td height="30" align="center">'.$date.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				         if($edit) {

				$output .= '<a href="index.php?mode=edit_mindjumble_music&uid='.$row['mind_jumble_music_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Music","sql/delmindjumblemusic.php?uid='.$row['mind_jumble_music_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr><td height="20" colspan="7" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row"><td colspan="7" align="center">NO PAGES FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function Add_MindJumble($box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url,$day,$sound_clip_id,$title_id,$short_narration)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$ins_sql = "INSERT INTO `tblmindjumble`(`box_title`,`box_type`,`box_banner`,`box_desc`,`day`,`credit_line`,`credit_line_url`,`sound_clip_id`,`status`,`user_add_banner`,`select_title`,`short_narration`) VALUES ('".addslashes($box_title)."','".addslashes($banner_type)."','".addslashes($banner)."','".addslashes($box_desc)."','".addslashes($day)."' ,'".addslashes($credit_line)."','".addslashes($credit_line_url)."','".addslashes($sound_clip_id)."','1','0','".addslashes($title_id)."','".addslashes($short_narration)."')";

	$STH = $DBH->prepare($ins_sql);
        $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function Add_MindJumbleTitle($title)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$ins_sql = "INSERT INTO `tbltitle`(`title`,`status`) VALUES ('".addslashes($title)."','1')";

	$STH = $DBH->prepare($ins_sql);
        $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function Add_MindJumble_Narration($title_id,$narration)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$ins_sql = "INSERT INTO `tblnarration`(`title_id`,`narration`,`status`) VALUES ('".addslashes($title_id)."','".addslashes($narration)."','1')";

         $STH = $DBH->prepare($ins_sql);
        $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	

	public function Add_MindJumblePDF($pdf,$credit,$credit_url,$pdf_title,$day,$title_id,$short_narration)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                  $return=false;
		$ins_sql = "INSERT INTO `tblmindjumblepdf`(`pdf`,`credit`,`credit_url`,`pdf_title`,`day`,`title_id`,`short_narration`,`status`) VALUES ('".addslashes($pdf)."','".addslashes($credit)."','".addslashes($credit_url)."','".addslashes($pdf_title)."','".addslashes($day)."','".addslashes($title_id)."','".addslashes($short_narration)."','1')";

				$STH = $DBH->prepare($ins_sql);
                              $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function Add_mindJumbleMusic($music,$day,$credit,$credit_url)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$ins_sql = "INSERT INTO `tblmindjumblemusic`(`music`,`day`,`credit`,`credit_url`,`status`) VALUES ('".addslashes($music)."','".addslashes($day)."','".addslashes($credit)."','".addslashes($credit_url)."','1')";

		

		$STH = $DBH->prepare($ins_sql);
                              $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function AddMindJumbleToolTip($page_id,$contents)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                 $return=false;
		$sql = "UPDATE `tblmindjumbletooltip` set `page_id` = '".addslashes($page_id)."' ,`text` = '".addslashes($contents)."'";

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function chkTitleExists($title)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbltitle` WHERE `title` = '".$title."'";

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function chkEdit_TitleExists($title,$title_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbltitle` WHERE `title` = '".$title."' AND `title_id` != '".$title_id."'";

		//echo $sql;

		  $STH = $DBH->prepare($sql);
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function chkNarrationExists($narration)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tblnarration` WHERE `narration` = '".$narration."'";

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function chkEdit_narrationExists($narration,$narration_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tblnarration` WHERE `narration` = '".$narration."' AND `narration_id` != '".$narration_id."'";

		//echo $sql;

		  $STH = $DBH->prepare($sql);
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	

	

	public function getmindjumbleDetails($mind_jumble_box_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$box_title = '';

		$box_type = '';

		$box_desc = '';

	    $banner = '';

		$status = '';

		$day = '';

		$sound_clip_id = '';

		$select_title = '';

		$short_narration = '';

		$credit_line = '';

		$credit_line_url = '';

		

		$sql = "SELECT * FROM `tblmindjumble` WHERE `mind_jumble_box_id` = '".$mind_jumble_box_id."'";

			

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $row = $STH->fetch(PDO::FETCH_ASSOC);

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

			$select_title = stripslashes($row['select_title']);

			$short_narration = stripslashes($row['short_narration']);

		}

		return array($box_title,$banner_type,$box_desc,$banner,$status,$stress,$credit_line,$credit_line_url,$day,$sound_clip_id,$select_title,$short_narration);

	

	}

	

	

	public function getmindjumbletitle($id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$title = '';

		$status = '';

				

		$sql = "SELECT * FROM `tbltitle` WHERE `title_id` = '".$id."'";

			

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $row = $STH->fetch(PDO::FETCH_ASSOC);

			$title = stripslashes($row['title']);

			$status = stripslashes($row['status']);

		}

		return array($title,$status);

	

	}

	

	public function getmindjumbleNarration($id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$title_id = '';

		$status = '';

		$narration = '';

				

		$sql = "SELECT * FROM `tblnarration` WHERE `narration_id` = '".$id."'";

			

		  $STH = $DBH->prepare($sql);
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $row = $STH->fetch(PDO::FETCH_ASSOC);

			$title_id = stripslashes($row['title_id']);

			$status = stripslashes($row['status']);

			$narration = stripslashes($row['narration']);

		}

		return array($title_id,$status,$narration);

	

	}

	

	public function getNarrationTitle($title_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$title = '';

			

		$sql = "SELECT * FROM `tbltitle` WHERE `title_id` = '".$title_id."'";

			

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $row = $STH->fetch(PDO::FETCH_ASSOC);

			$title = stripslashes($row['title']);

		}

		return $title;

	

	}

	

	

	public function getMindJumblePDFDetails($mindjumble_pdf_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$pdf = '';

		$credit ='';

		$credit_url = '';

		$pdf_title ='';

		$day ='';

		$status ='';

		$title_id ='';

		$short_narration ='';

			

		$sql = "SELECT * FROM `tblmindjumblepdf` WHERE `mind_jumble_pdf_id` = '".$mindjumble_pdf_id."'";

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $row = $STH->fetch(PDO::FETCH_ASSOC);

			$pdf = stripslashes($row['pdf']);

			$credit = stripslashes($row['credit']);

			$credit_url = stripslashes($row['credit_url']);

			$pdf_title = stripslashes($row['pdf_title']);

			$day = stripslashes($row['day']);

			$status = stripslashes($row['status']);

			$title_id = stripslashes($row['title_id']);

			$short_narration = stripslashes($row['short_narration']);

		}

		return array($pdf,$credit,$credit_url,$pdf_title,$day,$status,$title_id,$short_narration);

	

	}

	

	public function getMindJumbleToolTip()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$contents = '';

		$sql = "SELECT * FROM `tblmindjumbletooltip` WHERE `page_id` = '44'";

		  $STH = $DBH->prepare($sql);
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $row = $STH->fetch(PDO::FETCH_ASSOC);

			$contents = stripslashes($row['text']);

		}

		return $contents;

	

	}

	

	public function getmindjumbleMusicDetails($music_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$music = '';

		$day = '';

		$credit = '';

		$credit_url = '';

		$status = '';

			

		$sql = "SELECT * FROM `tblmindjumblemusic` WHERE `mind_jumble_music_id` = '".$music_id."'";

		

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $row = $STH->fetch(PDO::FETCH_ASSOC);

			$music = stripslashes($row['music']);

			$day= stripslashes($row['day']);

			$credit= stripslashes($row['credit']);

			$credit_url= stripslashes($row['credit_url']);

			$status = stripslashes($row['status']);

		}

		return array($music,$day,$credit,$credit_url,$status);

	

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

			$row = $row = $STH->fetch(PDO::FETCH_ASSOC);

			$step = stripslashes($row['step']);

			$music = stripslashes($row['sound_clip']);

			$status = stripslashes($row['status']);

		}

		return array($step,$music,$status);

	

	}

	

	public function Update_Mindjumble($status,$box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url,$day,$sound_clip_id,$title_id,$short_narration,$banner_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                 $return=false;
	$sql = "UPDATE `tblmindjumble` SET `box_title` = '".addslashes($box_title)."' , `box_type` = '".addslashes($banner_type)."', `box_banner` = '".addslashes($banner)."', `box_desc` = '".addslashes($box_desc)."',`credit_line` = '".addslashes($credit_line)."',`credit_line_url` = '".addslashes($credit_line_url)."',`status` = '".addslashes($status)."',`day` = '".addslashes($day)."' ,`sound_clip_id` = '".addslashes($sound_clip_id)."' ,`select_title` = '".addslashes($title_id)."' ,`short_narration` = '".addslashes($short_narration)."'  WHERE `mind_jumble_box_id` = '".$banner_id."'";

	//echo $sql;

	    $STH = $DBH->prepare($sql); 
            $STH->execute();

		
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}	

	

	

	public function Update_Mindjumble_Title($status,$title,$title_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                  $return=false;
	$sql = "UPDATE `tbltitle` SET `title` = '".addslashes($title)."' , `status` = '".addslashes($status)."'  WHERE `title_id` = '".$title_id."'";

	//echo $sql;

	    $STH = $DBH->prepare($sql);  
            $STH->execute();

		
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}	

	

	public function Update_Mindjumble_Narration($status,$narration,$title_id,$narration_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
	$sql = "UPDATE `tblnarration` SET `narration` = '".addslashes($narration)."' , `status` = '".addslashes($status)."',`title_id` = '".addslashes($title_id)."'  WHERE `narration_id` = '".$narration_id."'";

	//echo $sql;

	    $STH = $DBH->prepare($sql); 
            $STH->execute();

		
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}	

	

	public function Update_MindJumblePDF($pdf,$credit,$credit_url,$pdf_title,$status,$day,$title_id,$short_narration,$pdf_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                  $return=false;
	$sql = "UPDATE `tblmindjumblepdf` SET  `pdf` = '".addslashes($pdf)."' ,`credit` = '".addslashes($credit)."' , `credit_url` = '".addslashes($credit_url)."' ,`pdf_title` = '".addslashes($pdf_title)."' , `status` = '".addslashes($status)."' ,`day` = '".addslashes($day)."' ,`title_id` = '".addslashes($title_id)."' ,`short_narration` = '".addslashes($short_narration)."' WHERE `mind_jumble_pdf_id` = '".$pdf_id."'";

	  	

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function Update_MindJumbleMusic($music,$day,$credit,$credit_url,$status,$music_id) 

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                 $return=false;
		$sql = "UPDATE `tblmindjumblemusic` SET  `music` = '".addslashes($music)."' ,`day` = '".addslashes($day)."' ,`credit` = '".addslashes($credit)."' ,`credit_url` = '".addslashes($credit_url)."' ,`status` = '".addslashes($status)."'    WHERE `mind_jumble_music_id` = '".$music_id."'";

	  	

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

public function DeleteMindjumble($uid)
	{
        
		$my_DBH = new mysqlConnection();
                $return=false;
		$sql = "UPDATE `tbl_user_uploads` SET `is_deleted`=1 WHERE `id` = '".$uid."'";
                $STH = $my_DBH->query($sql);
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

public function DeleteMindjumbleTitle($uid)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$sql = "DELETE  FROM `tbltitle` WHERE `title_id` = '".$uid."'";

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function DeleteMindjumbleNarration($uid)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$sql = "DELETE  FROM `tblnarration` WHERE `narration_id` = '".$uid."'";

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function DeleteMindjumblePDF($uid)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$sql = "DELETE FROM `tblmindjumblepdf`  WHERE `mind_jumble_pdf_id` = '".$uid."'";

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function DeleteMindjumbleMusic($uid)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$sql = "DELETE FROM `tblmindjumblemusic` WHERE `mind_jumble_music_id` = '".$uid."'";

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		if($STH->rowCount() > 0)
                    {
                    $return = true;
                    
                    }return $return;

	}

	

	public function getStressBusterBannerString($banner)

	{

		$search = 'v=';

		$pos = strpos($banner, $search);

		$str = strlen($banner);

		$rest = substr($banner, $pos+2, $str);

		return 'http://www.youtube.com/embed/'.$rest;

	}

	

	public function getMindJumbleSelectTitle($title_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$option_str = '';		

		

		$sql = "SELECT * FROM `tbltitle` ORDER BY `title_add_date` ASC";

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['title_id'] == $title_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['title_id'].'" '.$sel.'>'.$row['title'].'</option>';

			}

		}

		return $option_str;

	}

	

	public function getShortNarrationID($title_id,$short_narration)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$option_str = '';		

		

		$sql = "SELECT * FROM `tblnarration` WHERE `title_id` = '".$title_id."' ORDER BY `narration_add_date` ASC";

		//echo $sql;

		  $STH = $DBH->prepare($sql); 
                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['narration_id'] == $short_narration)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['narration_id'].'" '.$sel.'>'.$row['narration'].'</option>';

			}

		}

		return $option_str;

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

			while($row = $row = $STH->fetch(PDO::FETCH_ASSOC)) 

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
        
        public function getUserDetails($user_id) {
           
                $my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $row = array();

		$sql = "SELECT * FROM `tblusers` where `user_id` = '".$user_id."' ";
                $STH = $DBH->prepare($sql); 
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);
		}

		return $row;  
            
        }

       public function getuseruploadsDetails($id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                
		$sql = "SELECT * FROM `tbl_user_uploads` WHERE `id` = '".$id."'";
                $STH = $DBH->prepare($sql); 
                $STH->execute();

		if($STH->rowCount() > 0)
		{
			$row = $row = $STH->fetch(PDO::FETCH_ASSOC);
		}

		return $row;

	

	}
        
public function getFavCatNameById($fav_cat_id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $contact_number = '';
        
        $sql = "SELECT fav_cat FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."'  ";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
		{
            $r = $STH->fetch(PDO::FETCH_ASSOC);
            $contact_number = stripslashes($r['fav_cat']);
        }	

        return $contact_number;
    }  

    
    public function Update_UserUploads($id,$admin_id,$admin_comment,$show_where,$show_to_user,$status,$approved_date,$admin_tags)

	{
        
         $str_admin_tag=implode(',',$admin_tags);
        //   echo "<pre>";print_r($str_admin_tag);echo "</pre>";
        // exit;

           $my_DBH = new mysqlConnection();
            $return=false;
            $sql = "UPDATE `tbl_user_uploads` SET `admin_notes` = '".addslashes($admin_comment)."' , `user_show` = '".addslashes($show_to_user)."', `show_where` = '".addslashes($show_where)."', `approved_by` = '".addslashes($admin_id)."',`status` = '".addslashes($status)."', `approved_date` = '".addslashes($approved_date)."',`admin_tags`='".$str_admin_tag."' WHERE `id` = '".$id."'";
	     $STH = $my_DBH->query($sql);
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}
        
    public function getAdminNameRam($id)
	{
            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return = '';
            
            $sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$id."' ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                    $return = $row['fname'].' '.$row['lname'];
            }
            return $return;
	}



   // public function getIngredientsByIngrdientType($user_id) 
   //  {

   //          $my_DBH = new mysqlConnection();
   //          $DBH = $my_DBH->raw_handle();
   //          $DBH->beginTransaction();
   //          $return = '';

   //          $option_str='';
   //          $sql = "SELECT * FROM `tbl_data_dropdown` WHERE is_deleted = '0' AND page_cat_id='".$user_id."' ORDER BY page_cat_id DESC";
   //          $STH = $DBH->prepare($sql);
   //          $STH->execute();
   //          if($STH->rowCount() > 0)
   //          {
   //                  $row = $STH->fetch(PDO::FETCH_ASSOC);
   //                  $return = $row['sub_cat1'];
   //          }
   //         $exp=explode(',',  $return);
   //         if($exp!=0)
   //         {
   //         foreach($exp as $value)
   //         {
   //         	   $sql2 = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id`='".$value."'";
		 //        $STH2 = $DBH->prepare($sql2);
   //              $STH2->execute();
   //              if($STH2->rowCount()  > 0)
   //              {
   //              	$row2 = $STH2->fetch(PDO::FETCH_ASSOC);
   //              	$meal_item = stripslashes($row2['fav_cat']);

   //              	$option_str .= '<option value="'. $meal_item .'">' .$meal_item. '</option>';	
   //              }
   //          }
   //      }else
   //      {
   //         $option_str='';
   //      }
   //       return $option_str;
   //  }


//   public function GETDATADROPDOWNMYDAYTODAYOPTION($page_cat_id,$page_name)
//    {
//         $my_DBH = new mysqlConnection();
//         $DBH = $my_DBH->raw_handle();
//         $DBH->beginTransaction();
// 	$arr_data = array();
// 	$sql = "SELECT * FROM `tbl_data_dropdown` WHERE page_name = '".$page_name."' and `page_cat_id` = '".$page_cat_id."' and `is_deleted` = 0 ORDER BY `order_show` ASC";
	
//         $STH = $DBH->prepare($sql);
//         $STH->execute();
//         if( $STH->rowCount() > 0 )
//         {
// 		   while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
// 		   {
// 			$arr_data[] = $row;
// 		   }
// 	}
// 	return $arr_data;
// }




public function getAllMainSymptomsMyDesign($symtum_cat)
    {       
        // $DBH = new DatabaseHandler();

         $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
        $str_sql_search = " AND `fav_parent_cat` IN (".$symtum_cat.") ";
        $data = array();
       $sql = "SELECT DISTINCT bmsid FROM `tblsymtumscustomcategory` WHERE  symtum_deleted = '0' ".$str_sql_search." ORDER BY bmsid DESC ";		
        
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {           
                $data[] = $row['bmsid'];
            }
	}
	return $data;  
        
    }



public function GetmycanvasdataDesign($symtum_cat)
{
        $symtum_cat = implode(',', $symtum_cat);
        // $DBH = new DatabaseHandler();

         $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
	$option_str = array();
	$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE bms_id IN($symtum_cat) ORDER BY `bms_name` ASC";
	$STH = $DBH->prepare($sql);
	$STH->execute();
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {
                
                $option_str[]=$row['bms_name'];
            }
	}
	return $option_str;  
}

public function GetmycanvassolutionitemsDesign($cat_id)
{
      
        // $DBH = new DatabaseHandler();
	    $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
        $option_str = array();
	$sql = "SELECT * FROM `tblsolutionitems` WHERE  sol_item_cat_id IN($cat_id) ORDER BY `sol_box_title` ASC";
	$STH = $DBH->prepare($sql);
	$STH->execute();
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {	
               
                $option_str[]= strip_tags($row['sol_box_title']);

            }
	}
	return $option_str; 
        
}

 public function getAllDailyMealsMyDesign($symtum_cat)
    {       
        // $DBH = new DatabaseHandler();
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();



        $str_sql_search = " AND `fav_cat_id` IN (".$symtum_cat.") ";
        $data = array();
        $sql = "SELECT DISTINCT meal_id FROM `tbldailymealsfavcategory` WHERE  show_hide = '1' ".$str_sql_search." ORDER BY meal_id DESC ";		
        
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {           
                $data[] = strip_tags($row['meal_id']);
            }
	}


	return $data;  
        
    }

public function GetmycanvasmealdataDesign($symtum_cat)
{      
        $symtum_cat = implode(',', $symtum_cat);
        // $DBH = new DatabaseHandler();
         $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
	$option_str = array();
	$sql = "SELECT * FROM `tbldailymeals` WHERE meal_id IN($symtum_cat) ORDER BY `meal_item` ASC";
	$STH = $DBH->prepare($sql);
	 $STH->execute();
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {			
                
                $option_str[]=strip_tags($row['meal_item']); 
            }
	}


	return $option_str;  
        
}

public function GetmycanvasDailyActivitydataDesign($symtum_cat)
{             
        // $DBH = new DatabaseHandler();
	  $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
        
	$option_str = array();
        $sql = "SELECT * FROM `tbldailyactivity` WHERE (activity_category IN($symtum_cat) OR activity_level_code IN($symtum_cat)) ORDER BY `activity` ASC";
	$STH = $DBH->prepare($sql);
	$STH->execute();
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {
                $option_str[] = strip_tags($row['activity']);
            }
	}
	return $option_str;  
        
}


public function GetFecthDataDesign($canv_sub_cat_link,$cat_id)
        {




            $final_data = array();
          
            if($canv_sub_cat_link=='tbl_bodymainsymptoms')
            {
                //echo 'Hiii';
               $symtum_cat = $this->getAllMainSymptomsMyDesign($cat_id);
               if(!empty($symtum_cat))
               {
                $final_data = $this->GetmycanvasdataDesign($symtum_cat);
               }
            }



            
            if($canv_sub_cat_link=='tblsolutionitems')
            {
               
               //$symtum_cat = $this->getAllMainSymptomsRamakantFront($cat_id);
               $final_data = $this->GetmycanvassolutionitemsDesign($cat_id);
            }

            
            if($canv_sub_cat_link=='tbldailymealsfavcategory')
            {
                // echo 'Hiii';
               $symtum_cat = $this->getAllDailyMealsMyDesign($cat_id); 
               if(!empty($symtum_cat))
               {
                $final_data = $this->GetmycanvasmealdataDesign($symtum_cat);
               }
            }
              
               

            
            if($canv_sub_cat_link=='tbldailyactivity')
            {
               //$symtum_cat = $this->getAllDailyActivityMyCanvas($cat_id);
               $final_data = $this->GetmycanvasDailyActivitydataDesign($cat_id);
            }
           
            
           // echo "<pre>";print_r($final_data);echo "</pre>";
           //                         exit;

            if(count($final_data)>0)
            {
              $final_data = $final_data ;   
            }
            else
            {
               //$final_data[]= array(); 
                return $final_data;  
            }
          
            return $final_data;   
            
        }


public function CreateDesignLifeDropdown($show_cat,$final_array,$exit_tags_value)
{
 // echo "<pre>";print_r($exit_tags_value);echo "<pre>";
// exit;
    $option_str = '';
    $data = array();
    if(!empty($show_cat))
    {
        for($i=0;$i<count($show_cat);$i++)
        {
        
            $data[] = $this->getFavCategoryNameVivek($show_cat[$i]);
        }
    }


    
   $final_array_new =  array_merge($data,$final_array);
   
   
    if(!empty($final_array_new))
    {
        for($j=0;$j<count($final_array_new);$j++)
        {
            
            if(in_array($final_array_new[$j],$exit_tags_value))
            {
            	$selected="selected";
            }
            else
            {
            	$selected="";
            }


          $option_str .='<option value="'.$final_array_new[$j].'" '.$selected.'>'.$final_array_new[$j].'</option>';  
        }
    }
   // 
   
    return $option_str;
    
}




public function getFavCategoryNameVivek($fav_cat_id)
	{
          
        // $DBH = new DatabaseHandler();

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
        $fav_cat_type = '';
        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";
        //$this->execute_query($sql);
        // $STH = $DBH->query($sql);
        $STH = $DBH->prepare($sql);
	   $STH->execute();
        if($STH->rowCount()  > 0)
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $fav_cat_type = stripslashes($row['fav_cat']);
        }
        return $fav_cat_type;
	} 

	
public function GETDATADROPDOWNMYDAYTODAYOPTION($page_cat_id,$page_name)
{
        // $DBH = new DatabaseHandler();

	  $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
	$arr_data = array();
	$sql = "SELECT * FROM `tbl_data_dropdown` WHERE page_cat_id = '".$page_name."' and `healcareandwellbeing` = '".$page_cat_id."' and `is_deleted` = 0 ORDER BY `order_show` ASC";

        // $STH = $DBH->query($sql);
	     $STH = $DBH->prepare($sql);
          $STH->execute();
        if( $STH->rowCount() > 0 )
        {

		while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

		{
			$arr_data[] = $row;
		}
	}
	return $arr_data;
} 


// $vendor_details['vendor_cat_id']


public function getIngredientsByIngrdientType($fav_cat_id,$comman,$page_name,$arr_admin_tags) 
{


   

	 if($fav_cat_id==0)
	 {
	 	$fav_cat=$comman;
	 }
	 else
	 {
	 	$fav_cat=$fav_cat_id;
	 }


	$data_dropdown = $this->GETDATADROPDOWNMYDAYTODAYOPTION($fav_cat,$page_name);
	$fetch_cat1= $this->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat1_link'],$data_dropdown[0]['sub_cat1']);
                                $show_cat = '';
                                $fetch_cat1 = array();
                                $fetch_cat2 = array();
                                $fetch_cat3 = array();
                                $fetch_cat4 = array();
                                $fetch_cat5 = array();
                                $fetch_cat6 = array();
                                $fetch_cat7 = array();
                                $fetch_cat8 = array();
                                $fetch_cat9 = array();
                                $fetch_cat10 = array();
                                   
                                   if($data_dropdown[0]['sub_cat1']!='')
                                   {
                                      if($data_dropdown[0]['canv_sub_cat1_show_fetch']==1) 
                                      {
                                        $show_cat .= $data_dropdown[0]['sub_cat1'].',';
                                      }
                                      else
                                      {
                                      $fetch_cat1 = $this->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat1_link'],$data_dropdown[0]['sub_cat1']);
                                      }
                                   }
                                
                                   
                                   if($data_dropdown[0]['sub_cat2']!='')
                                   {
                                    if($data_dropdown[0]['canv_sub_cat2_show_fetch']==1) 
                                    {
                                        $show_cat .= $data_dropdown[0]['sub_cat2'].',';
                                    }
                                    else
                                      {
                                          $fetch_cat2 = $this->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat2_link'],$data_dropdown[0]['sub_cat2']);
                                      }
                                   }

                                  
 
                                 
                                   
                                   if($data_dropdown[0]['sub_cat3']!='')
                                   {
                                     if($data_dropdown[0]['canv_sub_cat3_show_fetch'] == 1) 
                                     {
                                        $show_cat .= $data_dropdown[0]['sub_cat3'].',';
                                     }
                                     else
                                      {
                                          $fetch_cat3 = $this->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat3_link'],$data_dropdown[0]['sub_cat3']);
                                      }
                                   }
                                


                                   if($data_dropdown[0]['sub_cat4']!='')
                                   {
                                       if($data_dropdown[0]['canv_sub_cat4_show_fetch']==1) 
                                       {
                                            $show_cat .= $data_dropdown[0]['sub_cat4'].',';
                                       }
                                     else
                                      {
                                          $fetch_cat4 = $this->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat4_link'],$data_dropdown[0]['sub_cat4']);
                                      }
                                   }


                                   if($data_dropdown[0]['sub_cat5']!='')
                                   {
                                       if($data_dropdown[0]['canv_sub_cat5_show_fetch']==1) 
                                       {
                                            $show_cat .= $data_dropdown[0]['sub_cat5'].',';
                                       }
                                       else
                                      {
                                          $fetch_cat5 = $this->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat5_link'],$data_dropdown[0]['sub_cat5']);
                                      }
                                   }


                                   if($data_dropdown[0]['sub_cat6']!='')
                                   {
                                       if($data_dropdown[0]['canv_sub_cat6_show_fetch']==1) 
                                       {
                                            $show_cat .= $data_dropdown[0]['sub_cat6'].',';
                                       }
                                       else
                                      {
                                          $fetch_cat6 = $this->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat6_link'],$data_dropdown[0]['sub_cat6']);
                                      }
                                   }

                                    

                                   if($data_dropdown[0]['sub_cat7']!='')
                                   {
                                     if($data_dropdown[0]['canv_sub_cat7_show_fetch']==1) 
                                     {
                                        $show_cat .= $data_dropdown[0]['sub_cat7'].',';
                                     }
                                     else
                                      {
                                          $fetch_cat7 = $this->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat7_link'],$data_dropdown[0]['sub_cat7']);
                                      }
                                   }


                                   if($data_dropdown[0]['sub_cat8']!='')
                                   {
                                       if($data_dropdown[0]['canv_sub_cat8_show_fetch']==1) 
                                       {
                                            $show_cat .= $data_dropdown[0]['sub_cat8'].',';
                                       }
                                       else
                                      {
                                          $fetch_cat8 = $this->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat8_link'],$data_dropdown[0]['sub_cat8']);
                                      }
                                   }


                                   if($data_dropdown[0]['sub_cat9']!='')
                                   {
                                    if($data_dropdown[0]['canv_sub_cat9_show_fetch']==1) 
                                    {
                                        $show_cat .= $data_dropdown[0]['sub_cat9'].',';
                                    }
                                    else
                                      {
                                          $fetch_cat9 = $this->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat9_link'],$data_dropdown[0]['sub_cat9']);
                                      }
                                   }


                                   if($data_dropdown[0]['sub_cat10']!='')
                                   {
                                    if($data_dropdown[0]['canv_sub_cat10_show_fetch']==1) 
                                    {
                                        $show_cat .= $data_dropdown[0]['sub_cat10'].',';
                                    }
                                    else
                                      {
                                          $fetch_cat10 = $this->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat10_link'],$data_dropdown[0]['sub_cat10']);
                                      }
                                   }
                                 
                                   $show_cat = explode(',', $show_cat);
                                   $show_cat = array_filter($show_cat);
                                   $final_array = array_merge($fetch_cat1,$fetch_cat2,$fetch_cat3,$fetch_cat4,$fetch_cat5,$fetch_cat6,$fetch_cat7,$fetch_cat8,$fetch_cat9,$fetch_cat10);

                                      $final_dropdown = $this->CreateDesignLifeDropdown($show_cat,$final_array,$arr_admin_tags);
                                     
                                     if($final_dropdown!='')
                                     {
                                     	 echo $final_dropdown;
                                     }
                                     else
                                     {
                                     	echo "";
                                     }
                                       
                                    

                      }


                      public function getUserTagsValue($id,$user_id)
                      {
                            $my_DBH = new mysqlConnection();
					        $DBH = $my_DBH->raw_handle();
					        $DBH->beginTransaction();
					        $option_str='';

					        $fav_cat_type = '';
					        $sql = "SELECT * FROM `tbl_user_uploads` WHERE `id`='".$id."' AND `user_id`='".$user_id."'";
					        $STH = $DBH->prepare($sql);
						    $STH->execute();
						        if($STH->rowCount()  > 0)
						        {
						            $row = $STH->fetch(PDO::FETCH_ASSOC);
						            $fav_cat_type = stripslashes($row['user_tags']);
						        }
					          $exp=explode(',', $fav_cat_type);
                              foreach($exp as $value)
                              {
                                   $option_str .='<option value="'.$value.'" selected>'.$value.'</option>'; 
                              }

                                 return $option_str;

					      
                      }





}

?>