<?php

include_once("class.paging.php");

include_once("class.admin.php");


class Daily_Activity extends Admin

{

	public function getAllDailyActivities($search)

	{

	$my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '7';

		$delete_action_id = '9';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		if($search == '')

			{

				$sql = "SELECT * FROM `tbldailyactivity` ORDER BY activity ASC";

			}

		else

			{

			  $sql = "select * from `tbldailyactivity` where activity like '%".$search."%' order by activity_id DESC";

			}	

		 $STH = $DBH->prepare($sql);

                 $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page = 50;

		$scroll = 5;

		$page = new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=daily_activity");

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

				// add by ample 27-11-19
				$activity_category=explode(',', $row['activity_category']);
				$activity_category_names=array();
				if(!empty($activity_category))
				{
					foreach ($activity_category as $key => $value) {
						$name=$this->getfavcatname($value);
						array_push($activity_category_names,$name);
					}
				}

				$output .= '<tr class="manage-row">';

				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td align="center" nowrap="nowrap" >';

							if($row['status']==1)
							{
								$output .='Active';
							}
							else
							{
								$output .='Inctive';
							}

				$output .= '</td>';

				$output .= '<td align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_daily_activity&id='.$row['activity_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Daily Activity","sql/deldailyactivity.php?id='.$row['activity_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '<td align="center">'.stripslashes($row['activity_code']).'</td>';

                                $output .= '<td align="center">'.stripslashes($row['activity']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['activity_cal_kg_min']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['activity_cal_kg_hr']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['activity_cal_59_kg']).'</td>';

				$output .= '<td align="center">'.$this->getfavcatname($row['activity_level_code']).'</td>';

				$output .= '<td align="center">'.implode(',',$activity_category_names).'</td>';

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="9" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function chkActivityExists($activity)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbldailyactivity` WHERE `activity` = '".addslashes($activity)."'";

		 $STH = $DBH->prepare($sql);

                 $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function chkActivityExists_edit($activity,$activity_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbldailyactivity` WHERE `activity` = '".addslashes($activity)."' AND `activity_id` != '".$activity_id."'";

		$STH = $DBH->prepare($sql);

                 $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getActivityId($activity)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$activity_id = 0;

		

		$sql = "SELECT * FROM `tbldailyactivity` WHERE `activity` = '".addslashes($activity)."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$activity_id = stripslashes($row['activity_id']);

		}

		return $activity_id;

	}

	

	public function getActivityDetails($activity_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$sql = "SELECT * FROM `tbldailyactivity` WHERE `activity_id` = '".$activity_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$activity = stripslashes($row['activity']);

                        $activity_code = stripslashes($row['activity_code']);

			$activity_cal_kg_min = stripslashes($row['activity_cal_kg_min']);

			$activity_cal_kg_hr = stripslashes($row['activity_cal_kg_hr']);

			$activity_cal_59_kg = stripslashes($row['activity_cal_59_kg']);

			$activity_level_code = stripslashes($row['activity_level_code']);

			$activity_category = stripslashes($row['activity_category']);

			$recommendations = stripslashes($row['recommendations']);

			$guidelines = stripslashes($row['guidelines']);

			$precautions = stripslashes($row['precautions']);

			$benefits = stripslashes($row['benefits']);
			//add byample 12-12-19
			$status = stripslashes($row['status']);

		}

		return array($activity_code,$activity,$activity_cal_kg_min,$activity_cal_kg_hr,$activity_cal_59_kg,$activity_level_code,$activity_category,$recommendations,$guidelines,$precautions,$benefits,$status);

	}

	

	//update by ample 12-12-19

	public function addDailyActivity($activity_code,$activity,$activity_cal_kg_min,$activity_cal_kg_hr,$activity_cal_59_kg,$activity_level_code,$activity_category,$recommendations,$guidelines,$precautions,$benefits,$status)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		// added by ample 04-12-19
		$posted_by = $_SESSION['admin_id'];
				
		//update by ample 04-12-19
		$sql = "INSERT INTO `tbldailyactivity` (`activity_code`,`activity`,`activity_cal_kg_min`,`activity_cal_kg_hr`,`activity_cal_59_kg`,`activity_level_code`,`activity_category`,`recommendations`,`guidelines`,`precautions`,`benefits`,posted_by,status) VALUES ('".addslashes($activity_code)."','".addslashes($activity)."','".addslashes($activity_cal_kg_min)."','".addslashes($activity_cal_kg_hr)."','".addslashes($activity_cal_59_kg)."','".addslashes($activity_level_code)."','".addslashes($activity_category)."','".addslashes($recommendations)."','".addslashes($guidelines)."','".addslashes($precautions)."','".addslashes($benefits)."','".$posted_by."','".$status."')";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function updateDailyActivity($activity,$activity_cal_kg_min,$activity_cal_kg_hr,$activity_cal_59_kg,$activity_level_code,$activity_category,$activity_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;

		$now = time();

		

		$upd_sql = "UPDATE `tbldailyactivity` SET `activity` = '".addslashes($activity)."' , `activity_cal_kg_min` = '".addslashes($activity_cal_kg_min)."' , `activity_cal_kg_hr` = '".addslashes($activity_cal_kg_hr)."' , `activity_cal_59_kg` = '".addslashes($activity_cal_59_kg)."' , `activity_level_code` = '".addslashes($activity_level_code)."' , `activity_category` = '".addslashes($activity_category)."'  WHERE `activity_id` = '".$activity_id."'";

		$STH = $DBH->prepare($upd_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	// update by ample 12-12-19

	public function updateDailyActivityFull($activity_code,$activity,$activity_cal_kg_min,$activity_cal_kg_hr,$activity_cal_59_kg,$activity_level_code,$activity_category,$recommendations,$guidelines,$precautions,$benefits,$activity_id,$status)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;

		$now = time();

		//added by ample
		$modified_by = $_SESSION['admin_id'];
		$date=date('Y-m-d H:i:s');
		

		$upd_sql = "UPDATE `tbldailyactivity` SET `activity_code` = '".addslashes($activity_code)."' ,`activity` = '".addslashes($activity)."' , `activity_cal_kg_min` = '".addslashes($activity_cal_kg_min)."' , `activity_cal_kg_hr` = '".addslashes($activity_cal_kg_hr)."' , `activity_cal_59_kg` = '".addslashes($activity_cal_59_kg)."' , `activity_level_code` = '".addslashes($activity_level_code)."' , `activity_category` = '".addslashes($activity_category)."' , `recommendations` = '".addslashes($recommendations)."' , `guidelines` = '".addslashes($guidelines)."' , `precautions` = '".addslashes($precautions)."' , `benefits` = '".addslashes($benefits)."', `modified_by` = '".$modified_by."', `modified_date` = '".$date."', `status` = '".$status."'  WHERE `activity_id` = '".$activity_id."'";

		$STH = $DBH->prepare($upd_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function deleteDailyActivity($activity_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;

		$del_sql1 = "DELETE FROM `tbldailyactivity` WHERE `activity_id` = '".$activity_id."'"; 

		$STH = $DBH->prepare($del_sql1);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

 public function getfavcatname($fav_cat_id)

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

}

?>