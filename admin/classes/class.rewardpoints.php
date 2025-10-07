<?php

include_once("class.paging.php");

include_once("class.admin.php");

class RewardPoint extends Admin

{

	public function GetUsersOptions($user_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$option_str = '';

		$sql = "SELECT * FROM `tblusers` ORDER BY `name` ASC";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				if($user_id == $row['user_id'])

				{

					$selected = ' selected ';

				}

				else

				{

					$selected = '';

				}

				$option_str .= '<option value="'.$row['user_id'].'" '.$selected.' >'.stripslashes($row['name']).'</option>';

			}

		}

		return $option_str;

	}



	public function GetAllRewardsModuleList($search)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '141';

		$delete_action_id = '143';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		// if($search == '')
		// 	{
		// 		$sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_deleted` = '0' ORDER BY `reward_module_title` ASC ";
		// 	}
		// else
		// 	{
		// 	    $sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_title` LIKE '%".$search."%' AND `reward_module_deleted` = '0' ORDER BY `reward_module_title` ASC";
		// 	}

		if($search == '')
        {
            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '8' ";
        }
		else
        {
             $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '8' ";
        }

		$STH = $DBH->prepare($sql);

                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=25;

		$scroll=5;

		$page=new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=reward_modules");

	 	//$result=$this->execute_query($page->get_limit_query($sql));

                

                $STH2 = $DBH->prepare($page->get_limit_query($sql));

                $STH2->execute();

		$output = '';		

		if($STH2->rowCount() > 0)

		{
				$i=1;
                        
			
						$row = $STH2->fetch(PDO::FETCH_ASSOC);

                        $page_name = $row['page_id_str'];

                        $page_name = explode(',', $page_name);

                        $obj2 = new RewardPoint();


            for($i=0;$i<count($page_name);$i++)

			{

				$data = $this->getpagedata_rewardmodules($page_name[$i]);

				if($data['reward_module_add_datetime'])
				{
					$date=date("d-m-Y h:i:s",strtotime($data['reward_module_add_datetime']));
				}
				else
				{
					$date="N/A";
				}
                     	           

                $title = stripslashes($data['reward_module_title']);

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30" align="center" nowrap="nowrap" >'.($i+1).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($this->getPagenamebyid($page_name[$i])).'</td>';

				$output .= '<td height="30" align="center">'.($data['reward_module_status'] == 1 ? 'Active' : 'Inactive').'</td>';

                                $added_by_admin = $obj2->getUsenameOfAdmin($data['posted_by']);

                                $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';

                                $output .= '<td height="30" align="center">'.$date.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($edit) {

				$output .= '<a href="index.php?mode=edit_reward_module&page_id='.$page_name[$i].'&id='.$data['reward_module_id'].'" ><img src = "images/edit.gif" border="0"></a>';

				}

				$output .= '</td>';

				//$output .= '<td height="30" align="center" nowrap="nowrap">';

						//if($delete) {

				//$output .= '<a href=\'javascript:fn_confirmdelete("Reward Module","sql/delrewardmodule.php?id='.$row['reward_module_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

				//				}

				//$output .= '</td>';

				$output .= '</tr>';

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="4" align="center">NO PAGES FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	//add by ample 17-08-20

	 public function getpagedata_rewardmodules($page_id) {

     

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $upd_sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_deleted` = '0' AND `page_id` = '".$page_id."' ORDER BY `reward_module_title` ASC";

            $STH = $DBH->prepare($upd_sql);

            $STH->execute();

            if($STH->rowCount()  > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

               

            }

            return $row; 

        

    } 



   public function geteventname($eventid)

   {



        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT `event_name` FROM `tbl_event_master` WHERE `event_master_id` = '".$eventid."' AND `is_deleted` = '0' ";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{	

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$return = $row['event_name'];

		}

		return $return;



   }











	

	public function GetAllRewardsPointList($search="",$module_id="",$reward_type="",$con_type="",$eqv_type="",$cut_type="")

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		

		$edit_action_id = '252';

                $delete_action_id = '139';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

                $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		$str_search="";$str_module="";$str_reward="";$str_con="";$str_eqv="";$str_cut="";
		if($search)
		{
			$str_search="AND (rp.reward_list_name LIKE '%".$search."%' OR rp.reward_title_remark LIKE '%".$search."%')";
		}
		if($module_id)
		{
			$str_module="AND rp.reward_point_module_id = ".$module_id."";
		}
		if($reward_type)
		{
			$str_reward="AND rp.reward_type = ".$reward_type."";
		}
		if($con_type)
		{
			$str_con="AND rp.reward_point_conversion_type_id = ".$con_type."";
		}
		if($eqv_type)
		{
			$str_eqv="AND rp.equivalent_type = ".$eqv_type."";
		}
		if($cut_type)
		{
			$str_cut="AND rp.reward_point_cutoff_type_id = ".$cut_type."";
		}


			//update by ample 01-09-20
			$sql = "SELECT rp.* , rm.reward_module_title, rm.page_id  FROM `tblrewardpoints` AS rp LEFT JOIN `tblrewardmodules` AS rm ON rp.reward_point_module_id = rm.reward_module_id WHERE rp.reward_point_deleted = '0' AND rm.reward_module_deleted = '0' ".$str_search." ".$str_module." ".$str_reward." ".$str_con." ".$str_eqv." ".$str_cut." ORDER BY  rp.reward_point_id DESC ";

		



		$STH = $DBH->prepare($sql);

                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=25;

		$scroll=5;

		$page=new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=reward_points");

	 	//$result=$this->execute_query($page->get_limit_query($sql));

                $STH2 = $DBH->prepare($page->get_limit_query($sql));

                $STH2->execute();

		$output = '';		

		if($STH2->rowCount() > 0)

		{

			$i = 1;

			while($row = $STH->fetch(PDO::FETCH_ASSOC))

			{

                 

				// echo "<pre>";print_r($row);echo "</pre>";

                 $vals=$this->getrewardTypevalueKR($row['reward_type']);





				if($row['reward_point_status'] == '1')

				{

					$status = 'Active';

				}

				else

				{

					$status = 'Inactive';

				}

				

				if($row['reward_point_cutoff_type_id'] == '0')

				{

					$reward_point_cutoff_title = 'None';

				}

				else

				{

					$reward_point_cutoff_title = stripslashes($row['reward_point_cutoff_title']);

				}

			

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';

				$output .= '<td height="30" align="center">'.date('d-m-Y h:i:a',strtotime($row['reward_point_add_datetime'])).'</td>';



				 $output .= '<td height="30" align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_reward_point&id='.$row['reward_point_id'].'" ><img src = "images/edit.gif" border="0"></a>';

								}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Reward Point","sql/delrewardpoint.php?id='.$row['reward_point_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

								}

				$output .= '</td>';


				$output .= '<td height="30" align="center">'.stripslashes($row['reference_number']).'</td>';

				$output .= '<td height="30" align="center">'.$this->getMenuTitleOfPage($row['page_id']).'</td>';

				$output .= '<td height="30" align="center">'.$this->geteventname($row['event_id']).'</td>';



				$output .= '<td height="30" align="center">MainCat: '.$this->getrewardmaincat1($row['reward_main_cat_1']).'<br>SubCat: '.$this->getrewardsubcat1($row['reward_sub_cat_1']).'</td>';         

                $output .= '<td height="30" align="center">MainCat: '.$this->getrewardmaincat1($row['reward_main_cat_2']).'<br>SubCat: '.$this->getrewardsubcat1($row['reward_sub_cat_2']).'</td>'; 



				$output .= '<td height="30" align="center">Type: '.$vals[1].'<br>Remark: '.stripslashes($row['reward_title_remark']).'</td>';            

                $output .= '<td height="30" align="center">EFFECTIVE: '.date('d-m-Y ',strtotime($row['reward_point_date'])).'<br>CLOSE: '.$this->date_formate($row['event_close_date']).'</td>';

				$output .= '<td height="30" align="center">Type: '.$this->getpfavcatname($row['reward_point_conversion_type_id']).'<br>Value: '.stripslashes($row['reward_point_conversion_value']).'</td>';

				$output .= '<td height="30" align="center">Type: '.$this->getpfavcatname($row['equivalent_type']).'<br>Value: '.stripslashes($row['equivalent_value']).'</td>';

				$output .= '<td height="30" align="center">Type: '.$this->getpfavcatname($row['reward_point_cutoff_type_id']).'<br>Min: '.stripslashes($row['reward_point_min_cutoff']).'<br>Max: '.stripslashes($row['reward_point_max_cutoff']).'</td>';


				$output .= '<td height="30" align="center">'.$this->getNameOfSubAdmin($row['identity_id']).' <br>('.stripslashes($row['identity_type']).')</td>';
	         

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="23" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}





   

	

	public function GetAllRewardsBonusList($search="",$module_id="",$reward_type="",$con_type="",$eqv_type="",$cut_type="")

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '251';

                $delete_action_id = '146';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

                $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);


        $str_search="";$str_module="";$str_reward="";$str_con="";$str_eqv="";$str_cut="";
		if($search)
		{
			$str_search="AND (rp.reward_list_name LIKE '%".$search."%' OR rp.reward_title_remark LIKE '%".$search."%')";
		}
		if($module_id)
		{
			$str_module="AND rp.reward_bonus_module_id = ".$module_id."";
		}
		if($reward_type)
		{
			$str_reward="AND rp.reward_type = ".$reward_type."";
		}
		if($con_type)
		{
			$str_con="AND rp.reward_bonus_conversion_type_id = ".$con_type."";
		}
		if($eqv_type)
		{
			$str_eqv="AND rp.equivalent_type = ".$eqv_type."";
		}
		if($cut_type)
		{
			$str_cut="AND rp.reward_bonus_cutoff_type_id = ".$cut_type."";
		}

		

		//update by ample 01-09-20
		$sql = "SELECT rp.* , rm.reward_module_title,rm.page_id FROM `tblrewardbonus` AS rp LEFT JOIN `tblrewardmodules` AS rm ON rp.reward_bonus_module_id = rm.reward_module_id WHERE rp.reward_bonus_deleted = '0' AND rm.reward_module_deleted = '0' ".$str_search." ".$str_module." ".$str_reward." ".$str_con." ".$str_eqv." ".$str_cut." ORDER BY  rp.reward_bonus_id DESC ";





		$STH = $DBH->prepare($sql);

                $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page=25;

		$scroll=5;

		$page=new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=reward_bonus");

                

	 	//$result=$this->execute_query($page->get_limit_query($sql));

                

                $STH2 = $DBH->prepare($page->get_limit_query($sql));

                $STH2->execute();

                

		$output = '';		

		if($STH->rowCount() > 0)

		{

			$i = 1;

			while($row = $STH->fetch(PDO::FETCH_ASSOC))

			{



				// echo "<pre>";print_r($row);echo "</pre>";

                $vals=$this->getrewardTypevalueKR($row['reward_type']);

				if($row['reward_bonus_status'] == '1')

				{

					$status = 'Active';

				}

				else

				{

					$status = 'Inactive';

				}

				

				if($row['reward_bonus_cutoff_type_id'] == '0')

				{

					$reward_bonus_cutoff_title = 'None';

				}

				else

				{

					$reward_bonus_cutoff_title = stripslashes($row['reward_bonus_cutoff_title']);

				}

				

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';

				$output .= '<td height="30" align="center">'.date('d-m-y h:i:a',strtotime($row['reward_bonus_add_datetime'])).'</td>';


                $output .= '<td height="30" align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_reward_bonus&id='.$row['reward_bonus_id'].'" ><img src = "images/edit.gif" border="0"></a>';

								}

				$output .= '</td>';

                                $output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Reward Bonus Point","sql/delrewardbonus.php?id='.$row['reward_bonus_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

								}

				$output .= '</td>';



				$output .= '<td height="30" align="center">'.stripslashes($row['reference_number']).'</td>';

				$output .= '<td height="30" align="center">'.$this->getMenuTitleOfPage($row['page_id']).'</td>';

				$output .= '<td height="30" align="center">'.$this->geteventname($row['event_id']).'</td>';


				$output .= '<td height="30" align="center">MainCat: '.$this->getrewardmaincat1($row['reward_main_cat_1']).'<br>SubCat: '.$this->getrewardsubcat1($row['reward_sub_cat_1']).'</td>';         

                $output .= '<td height="30" align="center">MainCat: '.$this->getrewardmaincat1($row['reward_main_cat_2']).'<br>SubCat: '.$this->getrewardsubcat1($row['reward_sub_cat_2']).'</td>'; 


				$output .= '<td height="30" align="center">Type: '.$vals[1].'<br>Remark: '.stripslashes($row['reward_title_remark']).'</td>';            



                 $output .= '<td height="30" align="center">EFFECTIVE: '.date('d-m-Y ',strtotime($row['reward_bonus_date'])).'<br>CLOSE: '.$this->date_formate($row['event_close_date']).'</td>';

				$output .= '<td height="30" align="center">Type: '.$this->getpfavcatname($row['reward_bonus_conversion_type_id']).'<br>Value: '.stripslashes($row['reward_bonus_conversion_value']).'</td>';

				$output .= '<td height="30" align="center">Type: '.$this->getpfavcatname($row['equivalent_type']).'<br>Value: '.stripslashes($row['equivalent_value']).'</td>';

				$output .= '<td height="30" align="center">Type: '.$this->getpfavcatname($row['reward_bonus_cutoff_type_id']).'<br>Min: '.stripslashes($row['reward_bonus_min_cutoff']).'<br>Max: '.stripslashes($row['reward_bonus_max_cutoff']).'</td>';

				$output .= '<td height="30" align="center">'.$this->getNameOfSubAdmin($row['identity_id']).' <br>('.stripslashes($row['identity_type']).')</td>';

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="11" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function GetAllRewardsList($search="",$module_id="",$reward_type="",$con_type="",$eqv_type="",$cut_type="")

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		

		$edit_action_id = '165';

		$delete_action_id = '149';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		
		$str_search="";$str_module="";$str_reward="";$str_con="";$str_eqv="";$str_cut="";
		if($search)
		{
			$str_search="AND (rp.reward_list_name LIKE '%".$search."%' OR rp.reward_title_remark LIKE '%".$search."%')";
		}
		if($module_id)
		{
			$str_module="AND rp.reward_list_module_id = ".$module_id."";
		}
		if($reward_type)
		{
			$str_reward="AND rp.reward_type = ".$reward_type."";
		}
		if($con_type)
		{
			$str_con="AND rp.reward_list_conversion_type_id = ".$con_type."";
		}
		if($eqv_type)
		{
			$str_eqv="AND rp.equivalent_type = ".$eqv_type."";
		}
		if($cut_type)
		{
			$str_cut="AND rp.reward_list_cutoff_type_id = ".$cut_type."";
		}


		//update by ample 01-09-20
		$sql = "SELECT rp.* , rm.reward_module_title,rm.page_id  FROM `tblrewardlist` AS rp LEFT JOIN `tblrewardmodules` AS rm ON rp.reward_list_module_id = rm.reward_module_id   WHERE rp.reward_list_deleted = '0' AND rm.reward_module_deleted = '0' ".$str_search." ".$str_module." ".$str_reward." ".$str_con." ".$str_eqv." ".$str_cut." ORDER BY rp.reward_list_id DESC ";



                

		$STH = $DBH->prepare($sql);

                $STH->execute();

                

		$total_records=$STH->rowCount();

		$record_per_page=25;

		$scroll=5;

		$page=new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=reward_list");

                

	 	//$result=$this->execute_query($page->get_limit_query($sql));

                

                $STH2 = $DBH->prepare($sql);

                $STH2->execute();

                

		$output = '';		

		if($STH2->rowCount() > 0)

		{

			$i = 1;

			while($row = $STH2->fetch(PDO::FETCH_ASSOC))

			{

               $vals=$this->getrewardTypevalueKR($row['reward_type']);



				if($row['reward_list_status'] == '1')

				{

					$status = 'Active';

				}

				else

				{

					$status = 'Inactive';

				}

				

				$reward_file_type = stripslashes($row['reward_list_file_type']);

				$reward_file = stripslashes($row['reward_list_file']);

				require_once('classes/class.mindjumble.php');
				$obj3 = new Mindjumble();

				$reward_file_str = '';

				
                        $banner_name=$banner_file="";
                        if(!empty($reward_file_type) && is_numeric($reward_file))
                        {
                            if($reward_file_type=='Image')
                            {
                                $banner_data=$obj3->get_data_from_tblicons('',$reward_file);
                                $banner_name=$banner_data[0]['icons_name'];
                                $banner_file=$banner_data[0]['image'];

                                if($banner_file)
                                {
                                	$reward_file_str ='<a href="'.SITE_URL.'/uploads/'. $banner_file.'" target="_blank"><img src="'.SITE_URL.'/uploads/'. $banner_file.'" height="50px"/></a> ' ;
                                }

                                 
                            }
                            else
                            {
                                $banner_data=$obj3->get_data_from_tblmindjumble('',$reward_file);
                                $banner_name=$banner_data[0]['box_title'];
                                $banner_file=$banner_data[0]['box_banner'];

                                if($banner_file)
                                {
                                	$reward_file_str ='<a href="'.SITE_URL.'/uploads/'. $banner_file.'" target="_blank">'.$banner_file.'</a> ' ;
                                }
                            }
                        }
				

				if($row['reward_list_cutoff_type_id'] == '0')

				{

					$reward_list_cutoff_title = 'None';

				}

				else

				{

					$reward_list_cutoff_title = stripslashes($row['reward_list_cutoff_title']);

				}

				$data=$this->getRedirectSchedule($row['reward_list_id'],'rewardList'); //added by ample 24-12-20

				$sponsor=$this->getSponserData($row['reward_list_id']); //added by ample 24-12-20

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';

				$output .= '<td height="30" align="center">'.date('d-m-y h:i:a',strtotime($row['reward_list_add_datetime'])).'</td>';



                

                $output .= '<td height="30" align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_reward_list&id='.$row['reward_list_id'].'" ><img src = "images/edit.gif" border="0"></a>';

								}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Reward Item","sql/delrewardlist.php?id='.$row['reward_list_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

								}

				$output .= '</td>';





				$output .= '<td height="30" align="center">'.stripslashes($row['reference_number']).'</td>';

				$output .= '<td height="30" align="center">'.$this->getMenuTitleOfPage($row['page_id']).'</td>';

				$output .= '<td height="30" align="center">'.$this->geteventname($row['event_id']).'</td>';



				$output .= '<td height="30" align="center">MainCat: '.$this->getrewardmaincat1($row['reward_main_cat_1']).'<br>SubCat: '.$this->getrewardsubcat1($row['reward_sub_cat_1']).'</td>';         

                $output .= '<td height="30" align="center">MainCat: '.$this->getrewardmaincat1($row['reward_main_cat_2']).'<br>SubCat: '.$this->getrewardsubcat1($row['reward_sub_cat_2']).'</td>'; 

                $output .= '<td height="30" align="center">Type: '.$vals[1].'<br>Name: '.stripslashes($row['reward_list_name']).'<br>Remark :'.stripslashes($row['reward_title_remark']).'</td>';


				$output .= '<td height="30" align="center">'.$reward_file_str.' <br> ('.$reward_file_type.')</td>';


                $output .= '<td height="30" align="center">EFFECTIVE: '.date('d-m-Y ',strtotime($row['reward_list_date'])).'<br>CLOSE: '.$this->date_formate($row['event_close_date']).'</td>';

				$output .= '<td height="30" align="center">Type: '.$this->getpfavcatname($row['reward_list_conversion_type_id']).'<br>Value: '.stripslashes($row['reward_list_conversion_value']).'</td>';

				$output .= '<td height="30" align="center">Type: '.$this->getpfavcatname($row['equivalent_type']).'<br>Value: '.stripslashes($row['equivalent_value']).'</td>';

				$output .= '<td height="30" align="center">Type: '.$this->getpfavcatname($row['reward_list_cutoff_type_id']).'<br>Min: '.stripslashes($row['reward_list_min_cutoff']).'<br>Max: '.stripslashes($row['reward_list_max_cutoff']).'</td>';

				 $output .= '<td height="30" align="center">';

                            if(!empty($data))
                            {
                                $output .='<table class="table table-condensed"><thead><tr><th>Schedule</th><th>Location</th></tr></thead><tbody>';
                                foreach ($data as $key => $value) {
                                    
                                    $output .='<tr>';
                                    $output .='<td>';
                                                if($value['publish_date_type']=='single_date')
                                                {
                                                   $output .=date('d-m-Y', strtotime($value['publish_single_date'])); 
                                                }
                                                elseif ($value['publish_date_type']=='date_range') {
                                                   $output .='Start:'.date('d-m-Y', strtotime($value['publish_start_date'])); 
                                                   $output .='<br>End:'.date('d-m-Y', strtotime($value['publish_end_date'])); 
                                                }
                                                elseif ($value['publish_date_type']=='month_wise') {
                                                    $month_wise=explode(',', $value['publish_month_wise']);
                                                    $publish_month_wise=array();
                                                    if(!empty($month_wise))
                                                    {
                                                        foreach ($month_wise as  $mw) {
                                                            $publish_month_wise[]=$this->getMonthName($mw);
                                                        }
                                                    }
                                                    $output .=implode(',', $publish_month_wise); 
                                                }
                                                elseif ($value['publish_date_type']=='days_of_week') {
                                                    $week_wise=explode(',', $value['publish_days_of_week']);
                                                    $publish_week_wise=array();
                                                    if(!empty($week_wise))
                                                    {
                                                        foreach ($week_wise as  $ww) {
                                                            $publish_week_wise[]=$this->getWeekName($ww);
                                                        }
                                                    }
                                                    $output .=implode(',', $publish_week_wise);
                                                }
                                                elseif ($value['publish_date_type']=='days_of_month') {
                                                    $output .=$value['publish_days_of_month']; 
                                                }
                                    $output .='</td>';
                                    $output .='<td>';
                                                 if(!empty($value['state_id']))   
                                                 {
                                                     $output .='State:' .$this->GetStateName($value['state_id']);
                                                 }
                                                 if(!empty($value['city_id']))   
                                                 {
                                                     $output .='<br>City:' .$this->GetCityName($value['city_id']);
                                                 }
                                                 if(!empty($value['area_id']))   
                                                 {
                                                     $output .='<br>Area:' .$this->GetAreaName($value['area_id']);
                                                 }
                                    $output .='</td>';
                                    $output .='</tr>';
                                }
                                $output .='</tbody></thead></table>';
                            }

                        $output .= '</td>';

                 $output .= '<td height="30" align="center">';

                            if(!empty($sponsor))
                            {
                                $output .='<table class="table table-condensed"><thead><tr><th>Type</th><th>sponsor</th><th>Name</th><th>Remark</th></tr></thead><tbody>';
                                foreach ($sponsor as $key => $value) {
                                    
                                    $output .='<tr>';
                                    $output .='<td>';
                                                $output .=$this->getFavCategoryName($value['sponsor_type']);
                                    $output .='</td>';
                                    $output .='<td>'.$value['sponsor'].'</td>';
                                    $output .='<td>'.$value['sponsor_name'].'</td>';
                                    $output .='<td>'.$value['sponsor_remark'].'</td>';
                                    $output .='</tr>';
                                }
                                $output .='</tbody></thead></table>';
                            }

                        $output .= '</td>';

				$output .= '<td height="30" align="center">'.$this->getNameOfSubAdmin($row['identity_id']).' <br>('.stripslashes($row['identity_type']).')</td>';

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="19" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function chkIfRewardModuleAlreadyExists($reward_module_title)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_title` = '".$reward_module_title."' AND `reward_module_deleted` = '0' ";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{	

			$return = true;

		}

		return $return;

	}

	

	public function chkIfRewardModuleAlreadyExists_edit($reward_module_title,$reward_module_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

				

		$return = false;

		

		$sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_title` = '".$reward_module_title."' AND `reward_module_id` != '".$reward_module_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}



	public function getrewardTypevalueKR($rewardid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

				

		$return = false;

		

		$sql = "SELECT `fav_cat_id`,`fav_cat` FROM `tblfavcategory` WHERE `fav_cat_id` = '".$rewardid."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);



             $return=array($row['fav_cat_id'],$row['fav_cat']);

	



		}

		return $return;

	}



	//update by ample 05-11-20
	public function AddRewardPoint($reward_title_remark,$fav_cat_id_2,$fav_cat_id_1,$fav_cat_type_id_2,$fav_cat_type_id_1,$reward_point_module_id,$reward_point_conversion_type_id,$reward_point_conversion_value,$reward_point_cutoff_type_id,$reward_point_min_cutoff,$reward_point_max_cutoff,$reward_point_date,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_type,$admin_comment,$tables_names,$columns_dropdown,$tables_names2,$columns_dropdown_reword,$columns_dropdown_value_reword,$wellbeing_id,$equivalent_type,$equivalent_value)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;
		

				$reward_point_date = date('Y-m-d',strtotime($reward_point_date));
				$reward_point_end_date="";
				if($event_close_date)
				{
					$reward_point_end_date = date('Y-m-d',strtotime($event_close_date));
				}


                for($i=0;$i<count($reward_point_module_id);$i++)
            	{
            		for ($j=0; $j < count($reward_type); $j++) { 

            			$ins_sql = "INSERT INTO `tblrewardpoints`(`reward_title_remark`,`reward_sub_cat_2`,`reward_main_cat_2`,`reward_sub_cat_1`,`reward_main_cat_1`,`reward_point_module_id`,`reward_point_conversion_type_id`,`reward_point_conversion_value`,`reward_point_cutoff_type_id`,`reward_point_min_cutoff`,`reward_point_max_cutoff`,`reward_point_status`,`reward_point_deleted`,`reward_point_date`,`event_id`,`wellbeing_id`,`identity_type`,`identity_id`,`reference_number`,`event_close_date`,`reward_type`,`tables_select`,`columns_id`,`tables_select2`,`columns_id2`,`columns_value2`,`admin_comment`,`equivalent_type`,`equivalent_value`) VALUES ('".$reward_title_remark."','".$fav_cat_id_2."','".$fav_cat_type_id_2."','".$fav_cat_id_1."','".$fav_cat_type_id_1."','".$reward_point_module_id[$i]."','".$reward_point_conversion_type_id."','".addslashes($reward_point_conversion_value)."','".$reward_point_cutoff_type_id."','".$reward_point_min_cutoff."','".$reward_point_max_cutoff."','1','0','".$reward_point_date."','".$event_id."','".$wellbeing_id."','".$identity_type."','".$identity_id."','".$reference_number."','".$reward_point_end_date."','".$reward_type[$j]."','".$tables_names."','".$columns_dropdown."','".$tables_names2."','".$columns_dropdown_reword."','".$columns_dropdown_value_reword."','".$admin_comment."','".addslashes($equivalent_type)."','".addslashes($equivalent_value)."')";

						$STH = $DBH->prepare($ins_sql);

				                $STH->execute();

						if($STH->rowCount() > 0)

						{

							$return = true;

						}
            		}
            	}

		return $return;

	}

	
	//update by ample 05-11-20
	public function AddRewardBonus($reward_title_remark,$fav_cat_id_2,$fav_cat_id_1,$fav_cat_type_id_2,$fav_cat_type_id_1,$reward_bonus_module_id,$reward_bonus_conversion_type_id,$reward_bonus_conversion_value,$reward_bonus_cutoff_type_id,$reward_bonus_min_cutoff,$reward_bonus_max_cutoff,$reward_bonus_date,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_type,$admin_comment,$tables_names,$columns_dropdown,$tables_names2,$columns_dropdown_reword,$columns_dropdown_value_reword,$equivalent_type,$equivalent_value)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;

		

			$reward_bonus_date = date('Y-m-d',strtotime($reward_bonus_date));
			$reward_point_end_date="";
	        if($event_close_date)
				{
					$reward_point_end_date = date('Y-m-d',strtotime($event_close_date));
				}


        for($i=0;$i<count($reward_bonus_module_id);$i++)
        	{
        		for ($j=0; $j < count($reward_type); $j++) 
        		{ 

        			$ins_sql = "INSERT INTO `tblrewardbonus`(`reward_title_remark`,`reward_sub_cat_2`,`reward_main_cat_2`,`reward_sub_cat_1`,`reward_main_cat_1`,`reward_bonus_module_id`,`reward_bonus_conversion_type_id`,`reward_bonus_conversion_value`,`reward_bonus_cutoff_type_id`,`reward_bonus_min_cutoff`,`reward_bonus_max_cutoff`,`reward_bonus_status`,`reward_bonus_deleted`,`reward_bonus_date`,`event_id`,`identity_type`,`identity_id`,`reference_number`,`event_close_date`,`reward_type`,`tables_select`,`columns_id`,`tables_select2`,`columns_id2`,`columns_value2`,`admin_comment`,`equivalent_type`,`equivalent_value`) VALUES ('".$reward_title_remark."','".$fav_cat_id_2."','".$fav_cat_type_id_2."','".$fav_cat_id_1."','".$fav_cat_type_id_1."','".$reward_bonus_module_id[$i]."','".$reward_bonus_conversion_type_id."','".addslashes($reward_bonus_conversion_value)."','".$reward_bonus_cutoff_type_id."','".$reward_bonus_min_cutoff."','".$reward_bonus_max_cutoff."','1','0','".$reward_bonus_date."','".$event_id."','".$identity_type."','".$identity_id."','".$reference_number."','".$reward_point_end_date."','".$reward_type[$j]."','".$tables_names."','".$columns_dropdown."','".$tables_names2."','".$columns_dropdown_reword."','".$columns_dropdown_value_reword."','".$admin_comment."','".addslashes($equivalent_type)."','".addslashes($equivalent_value)."')";

						$STH = $DBH->prepare($ins_sql);

				                $STH->execute();

						if($STH->rowCount() > 0)

						{

							$return = true;

						}

        		}
      		}

		

		return $return;

	}

	
	//update by ample 05-11-20
	public function AddRewardList($fav_cat_type_id_1,$fav_cat_type_id_2,$fav_cat_id_1,$fav_cat_id_2,$reward_title_remark,$special_remarks,$reward_terms,$reward_list_module_id,$reward_list_conversion_type_id,$reward_list_conversion_value,$reward_list_cutoff_type_id,$reward_list_min_cutoff,$reward_list_max_cutoff,$reward_list_name,$reward_list_file_type,$reward_list_file,$reward_list_date,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_type,$admin_comment,$tables_names,$columns_dropdown,$tables_names2,$columns_dropdown_reword,$columns_dropdown_value_reword,$shows_cat,$shows_where,$shows_gallery,$gallery_remark,$equivalent_type,$equivalent_value)

	{

      


		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;



               $get_uniqu='D'.time(); 

				$reward_list_date = date('Y-m-d',strtotime($reward_list_date));
				$reward_point_end_date="";
                if($event_close_date)
				{
					$reward_point_end_date = date('Y-m-d',strtotime($event_close_date));
				}

                for($i=0;$i<count($reward_list_module_id);$i++)
        		{
	        		for ($j=0; $j < count($reward_type); $j++) 
	        		{ 	
	        			for($x=0;$x<count($shows_cat);$x++)
		        		{
			        		for ($z=0; $z < count($shows_where); $z++) 
			        		{ 

	        					$ins_sql = "INSERT INTO `tblrewardlist`(`reward_main_cat_1`,`reward_sub_cat_1`,`reward_main_cat_2`,`reward_sub_cat_2`,`reward_title_remark`,`special_remarks`,`reward_terms`,`reward_list_module_id`,`reward_list_conversion_type_id`,`reward_list_conversion_value`,`reward_list_cutoff_type_id`,`reward_list_min_cutoff`,`reward_list_max_cutoff`,`reward_list_name`,`reward_list_file_type`,`reward_list_file`,`reward_list_status`,`reward_list_deleted`,`reward_list_date`,`event_id`,`identity_type`,`identity_id`,`reference_number`,`event_close_date`,`reward_type`,`tables_select`,`columns_id`,`tables_select2`,`columns_id2`,`columns_value2`,`admin_comment`,`show_cat`,`shows_where`,`shows_gallery`,`gallery_remark`,`unique_id`,`equivalent_type`,`equivalent_value`)"

	                        		."VALUES ('".$fav_cat_type_id_1."','".$fav_cat_id_1."','".$fav_cat_type_id_2."','".$fav_cat_id_2."','".addslashes($reward_title_remark)."','".addslashes($special_remarks)."','".addslashes($reward_terms)."','".$reward_list_module_id[$i]."','".$reward_list_conversion_type_id."','".addslashes($reward_list_conversion_value)."','".$reward_list_cutoff_type_id."','".$reward_list_min_cutoff."','".$reward_list_max_cutoff."','".addslashes($reward_list_name)."','".addslashes($reward_list_file_type)."','".addslashes($reward_list_file)."','1','0','".$reward_list_date."','".$event_id."','".$identity_type."','".$identity_id."','".$reference_number."','".$reward_point_end_date."','".$reward_type[$j]."','".$tables_names."','".$columns_dropdown."','".$tables_names2."','".$columns_dropdown_reword."','".$columns_dropdown_value_reword."','".$admin_comment."','".$shows_cat[$x]."','".$shows_where[$z]."','".$shows_gallery."','".addslashes($gallery_remark)."','".$get_uniqu."','".addslashes($equivalent_type)."','".addslashes($equivalent_value)."')";

							        $STH = $DBH->prepare($ins_sql);
					                $STH->execute();
					                

								if($STH->rowCount() > 0)
								{	
									$last=$DBH->lastInsertId();
									$return = true;

							    }
						    }
						}
        			}
        		}


		return $return;

	}

	

	public function getRewardListDetails($reward_list_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

               

		

		$reward_list_module_id = '';

		$reward_list_conversion_type_id = '';

		$reward_list_conversion_value = '';

		$reward_list_cutoff_type_id = '';

		$reward_list_min_cutoff = '';

		$reward_list_max_cutoff = '';

		$reward_list_name = '';

		$reward_list_file_type = '';

		$reward_list_file = '';

		$reward_list_status = '';

		$reward_list_date = '';

                $fav_cat_type_id_1='';

                $fav_cat_type_id_2='';

                $fav_cat_id_1='';

                $fav_cat_id_2='';

                $reward_title_remark='';

                $sponsor_type_id='';

                $sponsor_name='';

                $sponsor_remarks='';

                $special_remarks='';

                $reward_terms='';

                $gallery_remark='';

                //add by ample 11-05-20        
                $equivalent_type="";
                $equivalent_value="";
		

		$sql = "SELECT * FROM `tblrewardlist` WHERE `reward_list_id` = '".$reward_list_id."' AND `reward_list_deleted` = '0' ";

		//echo '<br>sql = '.$sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

           

           // echo "<pre>";print_r($row);echo "<pre>";



           // echo $reward_list_id;



			$reward_list_module_id = stripslashes($row['reward_list_module_id']);

			$reward_list_conversion_type_id = stripslashes($row['reward_list_conversion_type_id']);

			$reward_list_conversion_value = stripslashes($row['reward_list_conversion_value']);

			$reward_list_cutoff_type_id = stripslashes($row['reward_list_cutoff_type_id']);

			$reward_list_min_cutoff = stripslashes($row['reward_list_min_cutoff']);

			$reward_list_max_cutoff = stripslashes($row['reward_list_max_cutoff']);

			$reward_list_name = stripslashes($row['reward_list_name']);

			$reward_list_file_type = stripslashes($row['reward_list_file_type']);

			$reward_list_file = stripslashes($row['reward_list_file']);

			$reward_list_status = stripslashes($row['reward_list_status']);

			$reward_list_date = stripslashes($row['reward_list_date']);

                        $event_id = stripslashes($row['event_id']);

                        $identity_type = stripslashes($row['identity_type']);

                        $identity_id = stripslashes($row['identity_id']);

                        $reference_number = stripslashes($row['reference_number']);

                        $event_close_date = stripslashes($row['event_close_date']);

                        $fav_cat_type_id_1=stripslashes($row['reward_main_cat_1']);

                        $fav_cat_type_id_2=stripslashes($row['reward_main_cat_2']);

                        $fav_cat_id_1=stripslashes($row['reward_sub_cat_1']);

                        $fav_cat_id_2=stripslashes($row['reward_sub_cat_2']);

                        $reward_title_remark=stripslashes($row['reward_title_remark']);

                        $special_remarks=stripslashes($row['special_remarks']);

                        $reward_terms=stripslashes($row['reward_terms']);

                        $reward_type_id=$this->getrewardTypevalueKR($row['reward_type']); 

                        $admin_comment = $row['admin_comment'];


						$listing_date_type=$row['listing_date_type'];

						$days_of_month=$row['days_of_month'];

						$single_date=$row['single_date'];

						$start_date=$row['start_date'];

						$end_date=$row['end_date'];

						$days_of_week=$row['days_of_week'];

						$months=$row['months'];

						
						$show_cat=$row['show_cat'];


                        $shows_where=$row['shows_where'];

                        $shows_gallery=$row['shows_gallery'];

                         $unique_id=$row['unique_id'];
        				
        				// add by ample 07-11-19
        				$tables_select=stripslashes($row['tables_select']);
                        $tables_select2=stripslashes($row['tables_select2']);
                        $columns_id=stripslashes($row['columns_id']);
                        $columns_id2=stripslashes($row['columns_id2']);
                        $columns_value2=stripslashes($row['columns_value2']); //add by ample 20-08-20

                   		$gallery_remark=stripslashes($row['gallery_remark']);

                   		 //add by ample 11-05-20        
                	$equivalent_type=$row['equivalent_type'];
                	$equivalent_value=$row['equivalent_value'];

		}

		return array($fav_cat_type_id_1,$fav_cat_type_id_2,$fav_cat_id_1,$fav_cat_id_2,$reward_title_remark,$special_remarks,$reward_terms,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_list_module_id,$reward_list_conversion_type_id,$reward_list_conversion_value,$reward_list_cutoff_type_id,$reward_list_min_cutoff,$reward_list_max_cutoff,$reward_list_name,$reward_list_file_type,$reward_list_file,$reward_list_status,$reward_list_date,$reward_type_id,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$days_of_week,$months,$show_cat,$shows_where,$shows_gallery,$admin_comment,$tables_select,$tables_select2,$columns_id,$columns_id2,$columns_value2,$gallery_remark,$equivalent_type,$equivalent_value);

	}





        

        public function getRewardBonusDetails($reward_bonus_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

               

		

		$reward_bonus_module_id = '';

		$reward_bonus_conversion_type_id = '';

		$reward_bonus_conversion_value = '';

		$reward_bonus_cutoff_type_id = '';

		$reward_bonus_min_cutoff = '';

		$reward_bonus_max_cutoff = '';

		$reward_bonus_status = '';

		$reward_bonus_date = '';

                

                $reward_main_category_1 ='';

                $reward_main_category_2 ='';

                $reward_sub_category_1 ='';

                $reward_sub_category_2 ='';

                $reward_title ='';

                //add by ample 11-05-20        
                $equivalent_type="";
                $equivalent_value="";

		

		$sql = "SELECT * FROM `tblrewardbonus` WHERE `reward_bonus_id` = '".$reward_bonus_id."' AND `reward_bonus_deleted` = '0' ";

		//echo '<br>sql = '.$sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$reward_bonus_module_id = stripslashes($row['reward_bonus_module_id']);

			$reward_bonus_conversion_type_id = stripslashes($row['reward_bonus_conversion_type_id']);

			$reward_bonus_conversion_value = stripslashes($row['reward_bonus_conversion_value']);

			$reward_bonus_cutoff_type_id = stripslashes($row['reward_bonus_cutoff_type_id']);

			$reward_bonus_min_cutoff = stripslashes($row['reward_bonus_min_cutoff']);

			$reward_bonus_max_cutoff = stripslashes($row['reward_bonus_max_cutoff']);

			$reward_bonus_status = stripslashes($row['reward_bonus_status']);

			$reward_bonus_date = stripslashes($row['reward_bonus_date']);

                        $event_id = stripslashes($row['event_id']);

                        $identity_type = stripslashes($row['identity_type']);

                        $identity_id = stripslashes($row['identity_id']);

                        $reference_number = stripslashes($row['reference_number']);

                        $event_close_date = stripslashes($row['event_close_date']);

                        $reward_main_category_1 = stripslashes($row['reward_main_cat_1']);

                        $reward_main_category_2 = stripslashes($row['reward_main_cat_2']);

                        $reward_sub_category_1 = stripslashes($row['reward_sub_cat_1']);

                        $reward_sub_category_2 = stripslashes($row['reward_sub_cat_2']);

                        $reward_title = stripslashes($row['reward_title_remark']);

                        // $reward_type_id = stripslashes($row['reward_type']);

                        $reward_type_id=$this->getrewardTypevalueKR($row['reward_type']); 

                        //add by ample 07-11-19
                        $admin_comment=stripslashes($row['admin_comment']);
                        $tables_select=stripslashes($row['tables_select']);
                        $tables_select2=stripslashes($row['tables_select2']);
                        $columns_id=stripslashes($row['columns_id']);
                        $columns_id2=stripslashes($row['columns_id2']);
                        $columns_value2=stripslashes($row['columns_value2']); //add by ample 20-08-20

                    //add by ample 11-05-20        
                	$equivalent_type=$row['equivalent_type'];
                	$equivalent_value=$row['equivalent_value'];

		}
		//update by ample 07-11-19/20-08-20
		return array($reward_title,$reward_sub_category_2,$reward_sub_category_1,$reward_main_category_2,$reward_main_category_1,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_bonus_module_id,$reward_bonus_conversion_type_id,$reward_bonus_conversion_value,$reward_bonus_cutoff_type_id,$reward_bonus_min_cutoff,$reward_bonus_max_cutoff,$reward_bonus_status,$reward_bonus_date,$reward_type_id,$admin_comment,$tables_select,$tables_select2,$columns_id,$columns_id2,$columns_value2,$equivalent_type,$equivalent_value);

	}

        

        public function getRewardPointDetails($reward_point_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$reward_point_module_id = '';

		$reward_point_conversion_type_id = '';

		$reward_point_conversion_value = '';

		$reward_point_cutoff_type_id = '';

		$reward_point_min_cutoff = '';

		$reward_point_max_cutoff = '';

		$reward_point_status = '';

		$reward_point_date = '';

                $reward_main_category_1 ='';

                $reward_main_category_2 ='';

                $reward_sub_category_1 ='';

                $reward_sub_category_2 ='';

                $reward_title ='';

                //add by ample 11-05-20        
                $equivalent_type="";
                $equivalent_value="";
		

		$sql = "SELECT * FROM `tblrewardpoints` WHERE `reward_point_id` = '".$reward_point_id."' AND `reward_point_deleted` = '0' ";

		//echo '<br>sql = '.$sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $reward_point_module_id = stripslashes($row['reward_point_module_id']);

                    $reward_point_conversion_type_id = stripslashes($row['reward_point_conversion_type_id']);

                    $reward_point_conversion_value = stripslashes($row['reward_point_conversion_value']);

                    $reward_point_cutoff_type_id = stripslashes($row['reward_point_cutoff_type_id']);

                    $reward_point_min_cutoff = stripslashes($row['reward_point_min_cutoff']);

                    $reward_point_max_cutoff = stripslashes($row['reward_point_max_cutoff']);

                    $reward_point_status = stripslashes($row['reward_point_status']);

                    $reward_point_date = stripslashes($row['reward_point_date']);

                    $event_id = stripslashes($row['event_id']);

                    $identity_type = stripslashes($row['identity_type']);

                    $identity_id = stripslashes($row['identity_id']);

                    $reference_number = stripslashes($row['reference_number']);

                    $event_close_date = stripslashes($row['event_close_date']);

                    $reward_main_category_1 = stripslashes($row['reward_main_cat_1']);

                    $reward_main_category_2 = stripslashes($row['reward_main_cat_2']);

                    $reward_sub_category_1 = stripslashes($row['reward_sub_cat_1']);

                    $reward_sub_category_2 = stripslashes($row['reward_sub_cat_2']);

                    $reward_title = stripslashes($row['reward_title_remark']);

                    $reward_type_new = $this->getrewardTypevalueKR($row['reward_type']);



                    $tables_select = $row['tables_select'];

                    $columns_id = $row['columns_id'];

                    $tables_select2 = $row['tables_select2'];

                    $columns_id2 = $row['columns_id2'];

                    $columns_value2 = $row['columns_value2'];

                    $admin_comment = $row['admin_comment'];

                   
                    //add by ample 11-05-20        
                	$equivalent_type=$row['equivalent_type'];
                	$equivalent_value=$row['equivalent_value'];


		}

		return array($reward_title,$reward_sub_category_2,$reward_sub_category_1,$reward_main_category_2,$reward_main_category_1,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_point_module_id,$reward_point_conversion_type_id,$reward_point_conversion_value,$reward_point_cutoff_type_id,$reward_point_min_cutoff,$reward_point_max_cutoff,$reward_point_status,$reward_point_date,$reward_type_new,$tables_select,$columns_id,$tables_select2,$columns_id2,$columns_value2,$admin_comment,$equivalent_type,$equivalent_value);

	}

	

	public function updateRewardList($special_remarks,$reward_terms,$reward_list_id,$reward_list_module_id,$reward_list_conversion_type_id,$reward_list_conversion_value,$reward_list_cutoff_type_id,$reward_list_min_cutoff,$reward_list_max_cutoff,$reward_list_name,$reward_list_file_type,$reward_list_file,$reward_list_status,$reward_list_date,$reward_type,$shows_cat,$shows_where,$shows_gallery,$admin_comment,$gallery_remark,$event_close_date)

	{



            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $get_uniqu='D'.time(); 

            $return = true;

            if($event_close_date)
				{
					$reward_point_end_date = date('Y-m-d',strtotime($event_close_date));
				}

            //update by ample 24-08-20/25-08-20

            $upd_sql = "UPDATE `tblrewardlist` SET `reward_terms` = '".addslashes($reward_terms)."',

            `special_remarks`='".addslashes($special_remarks)."',

            `reward_list_file_type` = '".addslashes($reward_list_file_type)."' ,

            `reward_list_file` = '".addslashes($reward_list_file)."', 

            `reward_list_status` = '".$reward_list_status."',

            `show_cat`='".$shows_cat."', 

            `shows_where`='".$shows_where."',

            `shows_gallery`='".$shows_gallery."',

            `gallery_remark`='".addslashes($gallery_remark)."',

            `unique_id`='".$get_uniqu."',

            `reward_type`='".$reward_type."',

            `event_close_date`='".$reward_point_end_date."',

            `admin_comment`='".$admin_comment."' WHERE `reward_list_id` = '".$reward_list_id."'";


          $STH = $DBH->prepare($upd_sql);

          $STH->execute();

          // $DBH->commit();

		if($STH->rowCount() > 0)

		{

              





            $count=count($sponsor_list);

             for($i=0;$i<$count;$i++)

             {

               if($sponsor_list[$i]!='user' || $sponsor_list[$i]!='Wa')

               {

               

                  $sql2="INSERT INTO `tbl_reward_sponsor`(`reward_list_id`,`sponsor_type`,`sponsor_name`,`unique_id`) VALUES (".$reward_list_id.",'".addslashes($sponsor_list[$i])."','".addslashes($value_rr[$i])."','".$get_uniqu."')";

               }

               else

               {

                 $sql2="UPDATE `tbl_reward_sponsor` SET `sponsor_type`='".addslashes($sponsor_list[$i])."',`sponsor_name`='".addslashes($value_rr[$i])."',`unique_id`='".$get_uniqu."' WHERE `reward_list_id`='".$reward_list_id."' AND `sponsor_type`='".$sponsor_list[$i]."'";

               }







                   $STH1 = $DBH->prepare($sql2);

                   $STH1->execute();  

             }

             $DBH->commit();

			$return = true;

		}

		return $return;

	}

        






		//update by ample 01-09-20
        public function updateRewardBonus($reward_bonus_id,$reward_bonus_status,$reward_type,$admin_comment,$event_close_date)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = true;

             if($event_close_date)
				{
					$event_close_date = date('Y-m-d',strtotime($event_close_date));
				}

            $upd_sql = "UPDATE `tblrewardbonus` SET `reward_bonus_status` = '".$reward_bonus_status."',`reward_type` = '".$reward_type."',`admin_comment` = '".$admin_comment."',`event_close_date`='".$event_close_date."' WHERE `reward_bonus_id` = '".$reward_bonus_id."'";

            $STH = $DBH->prepare($upd_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

        
	//update by ample 01-09-20
        public function updateRewardPoint($reward_point_id,$reward_point_status,$reward_type,$admin_comment,$event_close_date)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = true;

             if($event_close_date)
				{
					$event_close_date = date('Y-m-d',strtotime($event_close_date));
				}

            $upd_sql = "UPDATE `tblrewardpoints` SET `reward_point_status` = '".$reward_point_status."',`reward_type` = '".$reward_type."',`admin_comment` = '".$admin_comment."',`event_close_date`='".$event_close_date."' WHERE `reward_point_id` = '".$reward_point_id."'";

            $STH = $DBH->prepare($upd_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getRewardModuleTitle($reward_module_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$reward_module_title = '';

		$sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_id` = '".$reward_module_id."' AND `reward_module_deleted` = '0' ";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			if($row['page_id'] == '0')

				{

					$reward_module_title = stripslashes($row['reward_module_title']);

				}

				else

				{

					$obj2 = new RewardPoint();

					

					$reward_module_title = $obj2->getMenuTitleOfPage($row['page_id']);

					if($reward_module_title == '')

					{

						$reward_module_title = stripslashes($row['reward_module_title']);

					}

				}

			

		}

		return $reward_module_title;

	}

	

	public function getRewardCriteriaTitle($reward_criteria_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$reward_criteria_title = '';

		

		$sql = "SELECT * FROM `tblrewardcriteria` WHERE `reward_criteria_id` = '".$reward_criteria_id."' ";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$reward_criteria_title = stripslashes($row['reward_criteria_title']);

		}

		return $reward_criteria_title;

	}

	

	public function AddRewardModule($reward_module_title,$table_link,$table_column,$column1,$column2,$value1,$value2,$page_id,$admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;

		$now = date('Y-m-d');

		$ins_sql = "INSERT INTO `tblrewardmodules`(`page_id`,`reward_module_title`,`table_link`,`table_column`,`column1`,`column2`,`value1`,`value2`,`reward_module_status`,`reward_module_deleted`,`posted_by`) VALUES ('".$page_id."','".addslashes($reward_module_title)."','".addslashes($table_link)."','".addslashes($table_column)."','".addslashes($column1)."','".addslashes($column2)."','".addslashes($value1)."','".addslashes($value2)."','1','0','".$admin_id."')";

		$STH = $DBH->prepare($ins_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getRewardModuleDetails($reward_module_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$reward_module_title = '';

		$reward_module_status = '0';

		$reward_page_id = '0';

		

		$sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_id` = '".$reward_module_id."' AND `reward_module_deleted` = '0' ";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$reward_module_title = stripslashes($row['reward_module_title']);

			$reward_module_status = stripslashes($row['reward_module_status']);

			$reward_page_id = stripslashes($row['page_id']);

            $reward_table_link = stripslashes($row['table_link']);

            $table_column = stripslashes($row['table_column']);
            $column1 = stripslashes($row['column1']);
            $column2 = stripslashes($row['column2']);
            $value1 = stripslashes($row['value1']);
            $value2 = stripslashes($row['value2']);

		}

		return array($reward_module_title,$reward_module_status,$reward_page_id,$reward_table_link,$table_column,$column1,$column2,$value1,$value2);

	}

	

	

	public function UpdateRewardModule($reward_module_title,$reward_module_status,$reward_module_id,$page_id,$table_link,$table_column,$column1,$column2,$value1,$value2,$admin_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return =true;

		$upd_sql = "UPDATE `tblrewardmodules` SET `page_id`='".$page_id."',`table_link`='".addslashes($table_link)."',`table_column`='".addslashes($table_column)."',`column1`='".addslashes($column1)."',`value1`='".addslashes($value1)."',`column2`='".addslashes($column2)."',`value2`='".addslashes($value2)."',`reward_module_title` = '".addslashes($reward_module_title)."' , `reward_module_status` = '".$reward_module_status."',`posted_by`='".$admin_id."' WHERE `reward_module_id` = '".$reward_module_id."'";

		$STH = $DBH->prepare($upd_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

                {

                    $return =true;

                }

                return $return;

	}

	

	public function DeleteRewardPoint($id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return =false;

		

		$del_sql = "UPDATE `tblrewardpoints` SET `reward_point_deleted` = '1' WHERE `reward_point_id` = '".$id."'"; 

		$STH = $DBH->prepare($del_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

                {

                    $return =true;

                }

                return $return;

	}

	

	public function DeleteRewardBonus($id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return =false;

		

		$del_sql = "UPDATE `tblrewardbonus` SET `reward_bonus_deleted` = '1' WHERE `reward_bonus_id` = '".$id."'"; 

		$STH = $DBH->prepare($del_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

                {

                    $return =true;

                }

                return $return;

	}

	

	public function DeleteRewardModule($id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return =true;

		

		$del_sql = "UPDATE `tblrewardmodules` SET `reward_module_deleted` = '1' WHERE `reward_module_id` = '".$id."'"; 

		$STH = $DBH->prepare($del_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

                {

                    $return =true;

                }

                return $return;

	}

	

	public function DeleteRewardItem($id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return =true;

		

		$del_sql = "UPDATE `tblrewardlist` SET `reward_list_deleted` = '1' WHERE `reward_list_id` = '".$id."'"; 

		$STH = $DBH->prepare($del_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

                {

                    $return =true;

                }

                return $return;

	}

	

	public function getRewardModuleOptions($reward_module_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                

		$option_str = '';		

		

		$sql = "SELECT * FROM `tblrewardmodules` where `reward_module_deleted` = '0' ORDER BY `reward_module_title` ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['reward_module_id'] == $reward_module_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				

				if($row['page_id'] == '0')

				{

					$title = stripslashes($row['reward_module_title']);

				}

				else

				{

					$obj2 = new RewardPoint();

					

					$title = $obj2->getMenuTitleOfPage($row['page_id']);

					if($title == '')

					{

						$title = stripslashes($row['reward_module_title']);

					}

				}

				$option_str .= '<option value="'.$row['reward_module_id'].'" '.$sel.'>'.$title.'</option>';

			}

		}

		return $option_str;

	}


	//add by ample 20-08-20
	public function getRewardModuleCheckbox($reward_module_id,$key_name="module",$width = '400',$height = '150')

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                

		$output = '';		

		

		$sql = "SELECT * FROM `tblrewardmodules` LEFT JOIN tblpages ON tblrewardmodules.page_id=tblpages.page_id WHERE tblrewardmodules.reward_module_deleted = '0' ORDER BY tblpages.page_name ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{


			$output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';

            $output .= '<ul style="list-style:none;padding:0px;margin:0px;">';

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				// if($row['reward_module_id'] == $reward_module_id)

				if(in_array($row['reward_module_id'],$reward_module_id))

				{

					$sel = ' checked ';

				}

				else

				{

					$sel = '';

				}		

				

				// if($row['page_id'] == '0')

				// {

				// 	$title = stripslashes($row['reward_module_title']);

				// }

				// else

				// {

				// 	$obj2 = new RewardPoint();

					

				// 	$title = $obj2->getMenuTitleOfPage($row['page_id']);

				// 	if($title == '')

				// 	{

				// 		$title = stripslashes($row['reward_module_title']);

				// 	}

				// }

				$title=$row['page_name'];

				// $option_str .= '<option value="'.$row['reward_module_id'].'" '.$sel.'>'.$title.'</option>';

				$liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="'.$key_name.'[]" value="'.$row['reward_module_id'].'"  />&nbsp;<strong>'.$title.'</strong></li>';

			}

			$output .= '</div>';
		}

		return $output;

	}

	public function getRewardCriteriaOptions($reward_criteria_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$option_str = '';		

		

		$sql = "SELECT * FROM `tblrewardcriteria` where `reward_criteria_status` = '1' ORDER BY `reward_criteria_title` ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['reward_criteria_id'] == $reward_criteria_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['reward_criteria_id'].'" '.$sel.'>'.stripslashes($row['reward_criteria_title']).'</option>';

			}

		}

		return $option_str;

	}

	

	public function getYoutubeString($banner)

	{

		$search = 'v=';

		$pos = strpos($banner, $search);

		$str = strlen($banner);

		$rest = substr($banner, $pos+2, $str);

		return 'http://www.youtube.com/embed/'.$rest;

	}

	

	public function getMenuTitleOfPage($page_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$menu_title = '';

		

		$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$menu_title = stripslashes($row['menu_title']);

		}

		return $menu_title;

	

	}

    public function getDatadropdownPage($pdm_id,$page_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '<option value="">Select</option>';		

            $sel = '';

            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` ='".$pdm_id."' ";

           // echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $str = explode(',', $row['page_id_str']);

                foreach($str as $value) 

                {

                   if($page_id == $value)

                    {

                        $sel='selected';

                    }

                    else

                    {

                        $sel = '';

                    }

                    

                    $option_str .= '<option value="'.$value.'" '.$sel.' >'.stripslashes($this->getPagenamebyid($value)).'</option>';

                }

                

                $str_menu = explode(',', $row['menu_id']);

                if(!empty($row['menu_id']))

                {

                    foreach($str_menu as $value) 

                    {

                       if($page_id == $value)

                        {

                            $sel='selected';

                        }

                        else

                        {

                            $sel = '';

                        }

                        //getAdminMenuName($menu_id)

                        $option_str .= '<option value="'.$value.'" '.$sel.' >'.stripslashes($this->getAdminMenuName($value)).'</option>';

                    }

                }

                

            }

            return $option_str;

	}

	//add by ample 20-08-20
	public function getDatadropdownPageCheckbox($pdm_id,$page_id,$key_name="page_name",$width = '400',$height = '150')

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $output = '';		

            $sel = '';

            $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` ='".$pdm_id."' ";

           // echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

            	$output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';

                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';

                $liwidth = 300;

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $str = explode(',', $row['page_id_str']);

                foreach($str as $value) 

                {

                   if($page_id == $value)

                    {

                        $sel='checked';

                    }

                    else

                    {

                        $sel = '';

                    }

                    

                    //$option_str .= '<option value="'.$value.'" '.$sel.' >'.stripslashes($this->getPagenamebyid($value)).'</option>';

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$sel.' name="'.$key_name.'[]" value="'.$value.'"  />&nbsp;<strong>'.stripslashes($this->getPagenamebyid($value)).'</strong></li>';

                }

                

                $str_menu = explode(',', $row['menu_id']);

                if(!empty($row['menu_id']))

                {

                    foreach($str_menu as $value) 

                    {

                       if($page_id == $value)

                        {

                            $sel='checked';

                        }

                        else

                        {

                            $sel = '';

                        }

                        //getAdminMenuName($menu_id)

                        // $option_str .= '<option value="'.$value.'" '.$sel.' >'.stripslashes($this->getAdminMenuName($value)).'</option>';

                        $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$sel.' name="'.$key_name.'[]" value="'.$value.'"  />&nbsp;<strong>'.stripslashes($this->getAdminMenuName($value)).'</strong></li>';

                    }

                }


                $output .= '</div>';
                

            }

            return $output;

	}

        

        public function getPagenamebyid($page_id) {

          

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $page_name = '';		



            $sql = "SELECT * FROM `tblpages` WHERE `page_id` ='".$page_id."' ";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $page_name = $row['page_name'];

                

            }

            return $page_name; 

            

        }

        

        public function getAdminMenuName($menu_id)

        {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $menu_name = '';

            $sql = "SELECT * FROM `tbladminmenu` WHERE `status` = '1'  AND `menu_id` = '".$menu_id."' ";    

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $menu_name = stripslashes($row['menu_name']);                  

                }           

            }

            return $menu_name;

        }





        

   public function getEventOptions_OLD($event_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $date = date("Y-m-d h:i:s");

		$option_str = '';		

		

		$sql = "SELECT * FROM `tbl_event_master` where `status` = '1' AND `is_deleted` >= '0' ORDER BY `event_name` ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['event_master_id'] == $event_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				

				

				$option_str .= '<option value="'.$row['event_master_id'].'" '.$sel.'>'.$row['event_name'].'</option>';

			}

		}

		return $option_str;

	}

	public function getEventOptions($event_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $date = date("Y-m-d h:i:s");

		$option_str = '';		

		

		$today=date('Y-m-d');
        $sql = "SELECT TETT.*,TED.*,TEM.* FROM tbl_event_time_table TETT " . " LEFT JOIN tbl_event_details TED ON TETT.event_id = TED.event_id" . " LEFT JOIN tbl_event_master TEM ON TETT.event_master_id = TEM.event_master_id" . " WHERE TED.event_status = 1 AND TED.event_deleted = 0 AND TEM.status = 1 AND TEM.is_deleted = 0 AND TETT.event_end_date >='".$today."'  GROUP BY TEM.event_name order by TEM.event_name ASC";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['event_master_id'] == $event_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				

				

				$option_str .= '<option value="'.$row['event_master_id'].'" '.$sel.'>'.$row['event_name'].'</option>';

			}

		}

		return $option_str;

	}



        

   public function getFavCategoryRamakant($fav_cat_type_id,$fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '';		

            //echo 'aaa->'.$fav_cat_type_id;

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";

             $sql = "SELECT * FROM `tblcustomfavcategory` "

                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$fav_cat_type_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            

            $option_str .= '<option value="">Select Category</option>';

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                    if($row['favcat_id'] == $fav_cat_id)

                    {

                            $sel = ' selected ';

                    }

                    else

                    {

                            $sel = '';

                    }	

                    $cat_name = $row['fav_cat'];

                    $option_str .= '<option value="'.$row['favcat_id'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';

                }

            }

            //echo $option_str;

            

            return $option_str;

	}

	//add by ample 20-08-20
	public function getFevCategoryCheckbox($parent_cat_id,$arr_selected_cat_id,$key_name="fav_category_id",$width = '400',$height = '150')

        {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $output = ''; 

           $sql = "SELECT * FROM `tblcustomfavcategory` "

                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {


                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';

                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';

                $i = 1;

                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $prct_cat_id = $row['favcat_id'];

                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {

                        $selected = ' checked ';

                    }
                    else

                    {

                        $selected = '';

                    }

                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="'.$key_name.'[]" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';

                    $i++;

                }

                $output .= '</div>';

            }

            return $output;

        }

public function getEventdatashow($event_id)

   {

     

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $date = date("Y-m-d h:i:s");

            $option_str = '';		



            $sql = "SELECT * FROM `tbl_event_master` where `status` = '1' AND `event_master_id` = '".$event_id."' ";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

            }

            

            $option_str .= "<span style='font-size:14px; text-align:left;'>Event Name: ".$row['event_name']."</span><br>";

            $option_str .= "<span style='font-size:14px; text-align:left;'>Organizer Name: ".$this->getorganizername($row['organiser_id']).", Institution Name: ".$this->getorganizername($row['institution_id']).", Sponsor Name: ".$this->getorganizername($row['sponsor_id'])."</span><br>";

            $option_str .= "<span style='font-size:14px; text-align:left;'>Main Cat:".$this->getFavCategoryNameVivek($row['wellbeing_id'])."</span>";

            // $option_str .="<input type='text' name='event_name' id='event_name' value=".$this->getFavCategoryNameVivek($row['wellbeing_id']).">"

            

            return $option_str;

       

   }

   

   public function getFavCategoryNameVivek($fav_cat_id)

	{

           // $this->connectDB();

                 $my_DBH = new mysqlConnection();

                 $DBH = $my_DBH->raw_handle();

                 $DBH->beginTransaction();

                $fav_cat_type = '';



            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";

            //$this->execute_query($sql);

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount()  > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $fav_cat_type = stripslashes($row['fav_cat']);

            }

            return $fav_cat_type;

	}

   

   public function getorganizername($vendor_id)

   {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $option_str = '';		



        $sql = "SELECT * FROM `tblvendors` where `vendor_id` = '".$vendor_id."' AND `vendor_status` = '1' ";

        //echo $sql;

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $option_str =$row['vendor_name'];

        }

        return $option_str;

            

   }

   

   public function getprofcatname($prct_cat_id)

   {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $option_str = '';		



       $sql = "SELECT * FROM `tblprofilecustomcategories` where `prct_cat_id` = '".$prct_cat_id."' AND `prct_cat_status` = '1' ";

        //echo $sql;

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $option_str =$row['prct_cat'];

        }

        return $option_str; 

   }

   

   public function getpfavcatname($fav_cat_id)

   {

        $my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $option_str = '';		



        $sql = "SELECT * FROM `tblfavcategory` where `fav_cat_id` = '".$fav_cat_id."' AND `fav_cat_status` = '1' ";

        //echo $sql;

        $STH = $DBH->prepare($sql);

        $STH->execute();

        if($STH->rowCount() > 0)

        {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $option_str =$row['fav_cat'];

        }

        return $option_str;  

   }

        

 public function getFavCategoryTypeOptions($fav_cat_type_id)

	{ 

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '';		



            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";

            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_status` = '1' AND `prct_cat_deleted` = '0' ORDER BY `prct_cat` ASC";

            //echo $sql;

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $option_str .='<option value="">Select Type</option>';

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                	echo "<pre>";print_r($row);echo "</pre>";

                    if($row['prct_cat_id'] == $fav_cat_type_id)

                    {

                            $sel = ' selected ';

                    }

                    else

                    {

                            $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['prct_cat_id'].'" '.$sel.'>'.stripslashes($row['prct_cat']).$row['prct_cat_id'].'</option>';

                }

            }

            return $option_str;

	}

   

  public function getEventFavCategoryRamakant($page_id,$healcareandwellbeing)

      {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '';		

            $sql = "SELECT * FROM `tbl_page_cat_dropdown` WHERE `page_name`= '".$page_id."' and `pag_cat_status` = 1 and `is_deleted` = 0 ";

            $STH = $DBH->prepare($sql); 

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $option_str .='<option value="">Select Type</option>';

                while( $row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                    if($row['healcareandwellbeing'] == $healcareandwellbeing)

                    {

                            $sel = ' selected ';

                    }

                    else

                    {

                            $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['healcareandwellbeing'].'" '.$sel.'>'.stripslashes($this->getFavCatNameById($row['healcareandwellbeing'])).'</option>';

                }

            }

            return $option_str;  

      }    

  

   public function getVendorOption($vendor_id,$type='1',$multiple='0')

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$output = '';

		

		if($type == '2')

		{

			if($multiple == '1')

			{

				if(in_array('-1', $vendor_id))

				{

					$selected = ' selected ';	

				}

				else

				{

					$selected = '';	

				}

				$output .= '<option value="-1" '.$selected.' >All Vendors</option>';	

			}

			else

			{

				$selected = '';	

				$output .= '<option value="" '.$selected.' >All Vendors</option>';

			}

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

					if($multiple == '1')

					{

						if(is_array($vendor_id) && in_array($r['vendor_id'], $vloc_id))

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

						if($r['vendor_id'] == $vendor_id )

						{

							$selected = ' selected ';	

						}

						else

						{

							$selected = '';	

						}

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

   

        

    public function getCommaSeperatedsponsorName($vendor_id)

        {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $output = '';

            

            $sql = "SELECT * FROM `tblvendors` WHERE `vendor_status` = '1'  AND `vendor_id` IN (".$vendor_id.") ORDER BY `vendor_name` ASC";    

            $STH = $DBH->prepare($sql);

            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $vendor_name = stripslashes($row['vendor_name']);

                    $output .= $vendor_name.' ,';

                }

                $output = substr($output,0,-1);

            }

            return $output;

        } 







   public function getTableNameOptions_dropdown_kr1($get,$select_value,$desble)

    {

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $output = '';      



            $sql = "SELECT table_name FROM information_schema.tables where table_schema='wellness'";

            

            $STH = $DBH->prepare($sql);

             $STH->execute();

                    

            if($STH->rowCount()  > 0)

            {

              

               if($desble=='disabled')

               {

               	$disabled="disabled";

               }

               else

               {

               	$disabled="";

               }



               $output.='<select  class="" id="tables_names'.$get.'" name="tables_names" style="width:150px;" onchange="Selectable('.$get.');" '.$disabled.'>';

                       

               $output.='<option value="">-Select-</option>';

                         while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                        {

                            $table_name = stripslashes($row['table_name']);



                            if($select_value==$table_name)

                            {

                                $select="selected";

                            }

                            else

                            {

                                $select=""; 

                            }



                            $output.='<option value="'.$table_name.'"'.$select.'>'.$table_name.'</option>';

                          

                        }

                         $output .= '</select>';

            }

            return $output;

    }   





public function getRewardMaincat($comm,$page_id,$set_val,$pro)

    {



        if($pro=='prof1')

        {

        	$pro_cate='prof_cat1';

        }

        else

        {

           $pro_cate='prof_cat2';

        }





        $my_DBH = new mysqlConnection();

        $output = '';

        $output .= '<option value="" >Select Category</option>';

            try {

               

               $sql="SELECT ".$pro_cate." FROM `tbl_page_cat_dropdown` WHERE `healcareandwellbeing` = ".$comm." AND `page_name`=".$page_id." AND `is_deleted` = '0' ORDER BY page_cat_id ASC";



                 $STH = $my_DBH->query($sql);

                if( $STH->rowCount() > 0 )

                {

                    while($r= $STH->fetch(PDO::FETCH_ASSOC))

                    {

                    	 foreach($r as $value)

                    	 {

                    	 	if($value!="")

                    	 	{

                    	 	   $get_sap=explode(',',$value);

                    	 	   foreach($get_sap as $final_val)

                    	 	   {

                    	 	   	   $sql2="SELECT prct_cat FROM `tblprofilecustomcategories` WHERE `prct_cat_id` = ".$final_val." AND `prct_cat_deleted` = '0'";

                    	 	   	    $STH = $my_DBH->query($sql2);

                    	 	   	    $r2= $STH->fetch(PDO::FETCH_ASSOC);



                    	 	   	          if($r2['prct_cat'] == $set_val)

                                            {

                                                    $selected = ' selected ';   

                                            }

                                            else

                                            {

                                                    $selected = ''; 

                                            }   



                    	        $output .= '<option value="'.$final_val.'" '.$selected.'>'.stripslashes($r2['prct_cat']).'</option>';



                    	 	   }



                    	    }

                    	 }

                    }

                }

              

            } catch (Exception $e) {

                //$stringData = '[getMainCategoryOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;

                //$this->debuglog($stringData);

                return $output;

            }

                

        return $output;

    }





public function getrewardmaincat1($gt_id)

{

	 $my_DBH = new mysqlConnection();

	 $sql2="SELECT prct_cat FROM `tblprofilecustomcategories` WHERE `prct_cat_id` = ".$gt_id." AND `prct_cat_deleted` = '0'";

   	    $STH = $my_DBH->query($sql2);



   	    $r2= $STH->fetch(PDO::FETCH_ASSOC);

   	    $result=$r2['prct_cat'];



   	    return $result;

}



public function getrewardsubcat1($gt_id)

{

	 $my_DBH = new mysqlConnection();

	 $sql2="SELECT fav_cat FROM `tblfavcategory` WHERE `fav_cat_id` = ".$gt_id." AND `fav_cat_deleted` = '0'";

   	    $STH = $my_DBH->query($sql2);



   	    $r2= $STH->fetch(PDO::FETCH_ASSOC);

   	    $result=$r2['fav_cat'];



   	    return $result;

}

	public function multisponsor_name($sponsor_id,$select_value="")
	{

         $my_DBH = new mysqlConnection();
         $DBH = $my_DBH->raw_handle();
         $DBH->beginTransaction();
         $data=array();
         $html="";
         $return=false;
        if($sponsor_id=="user")
        {
        	$html="";
        	$sql="SELECT * FROM `tblusers` WHERE `status`=1";
         	$STH = $my_DBH->query($sql);
            if($STH->rowCount() > 0)
            {
            	while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
            		$sel="";
            		if($select_value==$row['name'])
            		{
            			$sel='selected';
            		}
                    $html.='<option value="'.$row['name'].'" '.$sel.'>'.$row['name'].'</option>';
                }
          	}

        }
        elseif($sponsor_id=="wa")
        {	
        	$html="";
          	$sql="SELECT * FROM `tblvendors` WHERE `vendor_status`=1 AND `vendor_deleted`=0";  
          	$STH = $my_DBH->query($sql);
            if($STH->rowCount() > 0)
            {
            	while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
            		$sel="";
            		if($select_value==$row['name'])
            		{
            			$sel='selected';
            		}
                    $html.='<option value="'.$row['vendor_name'].'" '.$sel.' >'.$row['vendor_name'].'</option>';
                }
          	}

        }
        else
        {
        	$html='<option value="wellness">wellness</option>';
        }
            
        return $html;

    }
    //add by ample 19-08-20  
    function get_sponsor_data($data_id="")
    {
        $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $data=array();
            $return=false;
            $sql="SELECT * FROM `tbl_reward_sponsor` WHERE `reward_list_id`=".$data_id." ORDER BY sponsor_id DESC";
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            }
        return $data;  
    }
    //create new function for save or update sponsor data 19-08-20
    public function update_sponsor_data($id,$data)
    {
           $this->delete_sponsor_data($id);

            $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $return=false;

                $query = "INSERT INTO `tbl_reward_sponsor` (`reward_list_id`,`sponsor_type`,`sponsor`,`sponsor_name`,`sponsor_remark`,`status`,`unique_id`) VALUES ";
                $values = '';
                foreach ($data as $key => $value) {
                	$unique_id=uniqid();
                    $values .= "(".$id.",'".$value['sponsor_type_id']."','".$value['sponsor_list']."','".$value['sponsor_name']."','".$value['sponsor_remark']."','".$value['status']."','".$unique_id."'),";
                }
                $values = substr($values, 0, strlen($values) - 1);
                $insert_query = $query . $values;
             $STH = $DBH->query($insert_query);
            if($STH->rowCount() > 0)
            {   
                $return = true;
            }
        return $return;
    }
    //add by ample 31-07-20   
    public function delete_sponsor_data($data_id="")
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $sql = "DELETE FROM `tbl_reward_sponsor` WHERE `reward_list_id` = ".$data_id; 
        $STH = $DBH->query($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
   	//added by ample 12-12-20
   	public function update_reward_close_history($data)
   	{
   		$my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
        $admin_id = $_SESSION['admin_id']; 

        $sql = "INSERT INTO `tbl_reward_close_history` (`admin_id`,`reward_id`,`type`,`close_date`) VALUES (".$admin_id.",'".$data['reward_id']."','".$data['reward_type']."','".$data['close_date']."')";

        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
   	}
   	//add by ample 12-12-20
    function get_reward_close_history($reward_type,$reward_id)
    {
        $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $data=array();
            $return=false;
            $sql="SELECT * FROM `tbl_reward_close_history` WHERE `type`='".$reward_type."' AND `reward_id`=".$reward_id." ORDER BY id DESC";
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            }
        return $data;  
    }
    //copy by ample 12-12-20
    public function getAdminName($id)
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
	//update by AMPLE 18-04-20
	public function GetAllUserPointHistory($module_id,$user_id,$start_date,$end_date)
	{

	    $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

			$admin_id = $_SESSION['admin_id'];
			// $reply_action_id = '111';
			// $delete_action_id = '112';
			// $reply = $this->chkValidActionPermission($admin_id,$reply_action_id);
			// $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

			$str_user="";$str_module="";$str_date="";

			if($user_id)
	        {
	            $str_user.=' WHERE ur.user_id='.$user_id;
	        }
			if($module_id)
	        {	
	        	if(empty($user_id))
	        	{
	        		$str_module.=' WHERE';
	        	}
	        	else
	        	{
	        		$str_module.=' AND';
	        	}
	            $str_module.=' ur.reward_module_id='.$module_id;
	        }
	        if($start_date && $end_date)
	        {	
	        	if(empty($user_id) && empty($module_id))
	        	{
	        		$str_date.=' WHERE';
	        	}
	        	else
	        	{
	        		$str_date.=' AND';
	        	}
	            $str_date.=' ur.transaction_date between "'.date("Y-m-d", strtotime($start_date)).'"  AND "'.date('Y-m-d', strtotime('+1 day', strtotime($end_date))).'"';
	        }

			 $sql = "SELECT ur.*,u.name,p.page_name FROM tbl_user_reward_history ur LEFT JOIN tblusers u ON ur.user_id=u.user_id LEFT JOIN tblrewardmodules rm ON ur.reward_module_id=rm.reward_module_id LEFT JOIN tblpages p ON rm.page_id=p.page_id ".$str_user." ".$str_module." ".$str_date." ORDER BY ur.id DESC"; 

			$STH = $DBH->prepare($sql);
                   $STH->execute();

			$total_records=$STH->rowCount();
			$record_per_page=25;
			$scroll=5;
			$page=new Page(); 
			$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
			$page->set_link_parameter("Class = paging");
			$page->set_qry_string($str="mode=feedback");
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
					$Credit=$Debit=$prize='';
					$day = $row['transaction_date'];
					$time= strtotime($day);
					$time=$time+19800;
					$date = date('d-M-Y h:i A',$time);
					if($row['transaction_type']=='Credit')
                    {
                      $Credit=$row['points'].' Point(s)';
                    }
                    if($row['transaction_type']=='Debit')
                    {
                      $Debit=$row['points'].' Point(s)';
                    }
                    if($row['reward_scheme_type']=='reward_prize')
	                   {
	                      $prize_data=$this->get_reward_prize_data($row['reward_scheme_id']);
	                      $prize=$prize_data['reward_list_name'];
	                   }
					$output .= '<tr class="manage-row">';
					$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';
					$output .= '<td height="30" align="center">'.stripslashes($row['name']).'</td>';
					$output .= '<td height="30" align="center">'.$date.'</td>';
					$output .= '<td height="30" align="center">'.$Credit.'</td>';
					$output .= '<td height="30" align="center">'.$Debit.'</td>';
					$output .= '<td height="30" align="center">'.$row['balance'].' Point(s)'.'</td>';
					$output .= '<td height="30" align="center">'.stripslashes($row['page_name']).'</td>';
					$output .= '<td height="30" align="center">'.$row['transection_no'].'</td>';
					$output .= '<td height="30" align="center">'.$row['remark'].'</td>';
					$output .= '<td height="30" align="center">'.$prize.'</td>';
					$output .= '</tr>';
					$i++;
				}
			}
			else
			{
				$output = '<tr class="manage-row" height="20"><td colspan="11" align="center">NO RECORDS FOUND</td></tr>';
			}
			$page->get_page_nav();
		return $output;
	}
	//add by ample 19-11-20
    function get_reward_prize_data($reward_list_id) {
        $DBH = new mysqlConnection();
        $data = array();
        $sql = "SELECT * FROM `tblrewardlist` WHERE  `reward_list_id` = '" . $reward_list_id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
            
        }
        return $data;
    }
    public function redeem_common_module_data()
    {
        $DBH = new mysqlConnection();
        $data = array();        
        $sql = "SELECT DISTINCT ur.reward_module_id,p.page_name FROM `tbl_user_reward_history` ur LEFT JOIN tblrewardmodules rm ON ur.reward_module_id=rm.reward_module_id LEFT JOIN tblpages p ON rm.page_id=p.page_id ";
        $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                 while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
            }
        return $data;
    }
    public function redeem_common_user_data()
    {
        $DBH = new mysqlConnection();
        $data = array();        
        $sql = "SELECT DISTINCT ur.user_id,u.name FROM `tbl_user_reward_history` ur LEFT JOIN tblusers u ON ur.user_id=u.user_id ";
        $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                 while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
            }
        return $data;
    }
    public function new_reward_list_addons($data,$reward_terms)
    {

    	$list=$this->get_reward_prize_data($data['reward_list_id']);

    	$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;

                $get_uniqu='D'.time(); 

				$ins_sql = "INSERT INTO `tblrewardlist`(`reward_main_cat_1`,`reward_sub_cat_1`,`reward_main_cat_2`,`reward_sub_cat_2`,`reward_title_remark`,`special_remarks`,`reward_terms`,`reward_list_module_id`,`reward_list_conversion_type_id`,`reward_list_conversion_value`,`reward_list_cutoff_type_id`,`reward_list_min_cutoff`,`reward_list_max_cutoff`,`reward_list_name`,`reward_list_file_type`,`reward_list_file`,`reward_list_status`,`reward_list_deleted`,`reward_list_date`,`event_id`,`identity_type`,`identity_id`,`reference_number`,`event_close_date`,`reward_type`,`tables_select`,`columns_id`,`tables_select2`,`columns_id2`,`columns_value2`,`admin_comment`,`show_cat`,`shows_where`,`shows_gallery`,`gallery_remark`,`unique_id`,`equivalent_type`,`equivalent_value`)"

            		."VALUES ('".$list['reward_main_cat_1']."','".$list['reward_sub_cat_1']."','".$list['reward_main_cat_2']."','".$list['reward_sub_cat_2']."','".addslashes($data['reward_title_remark'])."','".$list['special_remarks']."','".addslashes($reward_terms)."','".$list['reward_list_module_id']."','".$list['reward_list_conversion_type_id']."','".$list['reward_list_conversion_value']."','".$list['reward_list_cutoff_type_id']."','".$list['reward_list_min_cutoff']."','".$list['reward_list_max_cutoff']."','".addslashes($data['reward_list_name'])."','".addslashes($data['level_icons_type'])."','".addslashes($data['level_icons'])."','1','0','".$list['reward_list_date']."','".$list['event_id']."','".$list['identity_type']."','".$list['identity_id']."','".$list['reference_number']."','".$list['event_close_date']."','".$list['reward_type']."','".$list['tables_select']."','".$list['columns_id']."','".$list['tables_select2']."','".$list['columns_id2']."','".$list['columns_value2']."','".$list['admin_comment']."','".$list['shows_cat']."','".$list['shows_where']."','".$list['shows_gallery']."','".$list['gallery_remark']."','".$get_uniqu."','".$list['equivalent_type']."','".$list['equivalent_value']."')";

			        $STH = $DBH->prepare($ins_sql);
	                $STH->execute();
	                
				if($STH->rowCount() > 0)
				{	
					$last=$DBH->lastInsertId();
					$return =$last;

			    }

		return $return;
    }
    //add by ample 29-10-20
    public function getSponserData($list_id="")
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tbl_reward_sponsor` WHERE reward_list_id =".$list_id;
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
        }
        return $data;     
    }
}

?>