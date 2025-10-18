<?php

include_once("class.paging.php");

include_once("class.admin.php");

include_once("class.contents.php");
class Daily_Activity extends Admin

{

	public function getAllDailyActivities($search,$filterParam)

	{

	$my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '7';

		$delete_action_id = '9';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		$querySearch = '';
		if(!empty($filterParam['activitycode'])){
			$querySearch.=' AND activity_code="'.$filterParam['activitycode'].'"';
		}

		if(!empty($filterParam['activitylevel'])){
			$querySearch.=' AND activity_level_code="'.$filterParam['activitylevel'].'"';
		}

		if(!empty($filterParam['activitycategory'])){
			$querySearch.=' AND (FIND_IN_SET("'.$filterParam['activitycategory'].'", activity_category))';
		}

		if(!empty($filterParam['status'])){
			if($filterParam['status']=='active'){
				$statusType = '1';
			}else{
				$statusType = '0';
			}
			$querySearch.=' AND status='.$statusType.'';
		}


		$sql = "SELECT * FROM `tbldailyactivity` WHERE `activity_id`>0 $querySearch ORDER BY activity_id DESC";

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

				$logsObject = new Logs();
				$lastUpdatedData = [
					'page' => 'daily_activity',
					'reference_id' => $row['activity_id']
				];
				$firstUpdatedData = $logsObject->getFirstUpdatedLogs($lastUpdatedData); 
				$lastUpdatedData = $logsObject->getLastUpdatedLogs($lastUpdatedData); 
				if((int)$filterParam['modified']>0){
					if($lastUpdatedData['updateById']!=$filterParam['modified']){
						continue;
					}
				}
					
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
				$output .= '<td align="center">'.stripslashes($firstUpdatedData['updateOn']).'</td>';

				$output .= '<td align="center">'.stripslashes($firstUpdatedData['updateBy']).'</td>';

				$output .= '<td align="center">'.stripslashes($lastUpdatedData['updateOn']).'
				<a href="/admin/index.php?mode=logs-history&type=daily_activity&id='.$row['activity_id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';

				$output .= '<td align="center">'.stripslashes($lastUpdatedData['updateBy']).'<a href="/admin/index.php?mode=logs-history&type=daily_activity&id='.$row['activity_id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';

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
		$sql = "INSERT INTO `tbldailyactivity` (`activity_code`,`activity`,`activity_cal_kg_min`,`activity_cal_kg_hr`,`activity_cal_59_kg`,`activity_level_code`,`activity_category`,`recommendations`,`guidelines`,`precautions`,`benefits`,posted_by,status,modified_by,modified_date,deleted,deleted_date,deleted_by) VALUES ('".addslashes($activity_code)."','".addslashes($activity)."','".addslashes($activity_cal_kg_min)."','".addslashes($activity_cal_kg_hr)."','".addslashes($activity_cal_59_kg)."','".addslashes($activity_level_code)."','".addslashes($activity_category)."','".addslashes($recommendations)."','".addslashes($guidelines)."','".addslashes($precautions)."','".addslashes($benefits)."','".$posted_by."','".$status."',0,'0000-00-00',0,'0000-00-00',0)";

		$STH = $DBH->prepare($sql);

                $STH->execute();
		 //Insert lOGS
			$lastInsertedId = $DBH->lastInsertId();
			$logsObject = new Logs();
			$logsData = [
				'page' => 'daily_activity',
				'reference_id' => $lastInsertedId
			];
			$logsObject->insertLogs($logsData);
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

			 //Insert lOGS
			$logsObject = new Logs();
			$logsData = [
				'page' => 'daily_activity',
				'reference_id' => $activity_id
			];
			$logsObject->insertLogs($logsData);

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

			 //Insert lOGS
			$logsObject = new Logs();
			$logsData = [
				'page' => 'daily_activity',
				'reference_id' => $activity_id
			];
			$logsObject->insertLogs($logsData);

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

   	public function getActivityFilter(){
		$my_DBH = new mysqlConnection();
		$obj2 = new Contents();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		$data=array();
		
		$sql="SELECT * FROM `tbldailyactivity` WHERE deleted=0";
		$STH = $DBH->query($sql);
		$allOptions = [
			'activitycode' => [],
			'activitylevel' => [],
			'activitycategory' => [],
			'modifiedby' => []
		];
		
		$dataReturn = $STH->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($dataReturn)){   
			foreach ($dataReturn as $row) {
				$returnName = $obj2->getModifiedData($row['activity_id']);
				if(!empty($returnName)){
					$allOptions['modifiedby'] = $returnName;
				}
				
				$allOptions['activitycode'][$row['activity_code']] = $row['activity_code'];
				$allOptions['activitylevel'][$row['activity_level_code']] = $this->getfavcatname($row['activity_level_code']);
				$explodingData = explode(',',$row['activity_category']);
                foreach($explodingData as $dt){
                    $allOptions['activitycategory'][$dt] = $this->getfavcatname($dt);
                }
			}
		}
		
		
		
		return $allOptions;
   	}


}

?>