<?php

include_once("class.paging.php");
 
include_once("class.admin.php");
include_once("class.contents.php");
class Daily_Meals extends Admin

{

	public function getAllDailyMealsOld($search)

	{    

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '11';

		$delete_action_id = '13';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		if($search == '')

			{

				$sql = "SELECT * FROM `tbldailymeals` ORDER BY meal_item ASC";

			}

		else

			{

			  $sql = "select * from `tbldailymeals` where meal_item like '%".$search."%' order by meal_id DESC";

			}	

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page = 50;

		$scroll = 5;

		$page = new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=daily_meals");

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

				

			while( $row = $STH2->fetch(PDO::FETCH_ASSOC))

			{

				$output .= '<tr class="manage-row">';

				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td align="center">'.stripslashes($row['meal_item']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['meal_measure']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['weight']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['food_type']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['food_veg_nonveg']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['calories']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['total_fat']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['saturated']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['cholesterol']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['total_dietary_fiber']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['total_carbohydrate']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['sugar']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['protien']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['sodium']).'</td>';

				$output .= '<td align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_daily_meal&id='.$row['meal_id'].'&page='.$page->page.'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Daily Meal","sql/deldailymeal.php?id='.$row['meal_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr class="manage-row" height="20"><td colspan="17" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="16" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	public function getScaleDetailByScaleId($scale_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



//                $feedback_method = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tbl_scale` WHERE `scale_id` = '".$scale_id."' ";

                  $STH = $DBH->prepare($sql);

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

//                    $feedback_method = stripslashes($row['feedback_method']);

                }

                return $row;

            }

        public function getAllScaleDetail($search,$total_count)

	{    

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$obj = new Daily_Meals();

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '289';

		$delete_action_id = '290';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		if($search == '')

			{

				$sql = "SELECT * FROM `tbl_scale_add_more` ORDER BY scaleid DESC";

			}

		else

			{

			  $sql = "select * from `tbl_scale_add_more` where label_of_scale like '%".$search."%' order by scaleid DESC";

			}	

		  $STH = $DBH->prepare($sql);  

                  $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page = 50;

		$scroll = 5;

		$page = new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=daily_meals");

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

		       

			while( $row = $STH2->fetch(PDO::FETCH_ASSOC))

			{       $scale_detail = $obj->getScaleDetailByScaleId($row['scale_id']);

                        list($data) = $obj->getScalePrfoCatDetails($row['scale_id']);

                       

                       

                               

				$output .= '<tr class="manage-row">';

				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td align="center">'.stripslashes($scale_detail['scale_code']).'</td>';

                                 for($i=0;$i<$total_count;$i++) {  

				$output .= '<td align="center">'.stripslashes($obj->getIdByProfileFavCategoryName($data[$i]['prof_cat'])).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getIdByFavCategoryName($data[$i]['sub_cat'])).'</td>';

                                 }

				$output .= '<td align="center">'.stripslashes($scale_detail['from_range']).'</td>';

				$output .= '<td align="center">'.stripslashes($scale_detail['to_range']).'</td>';

				$output .= '<td align="center">'.stripslashes($scale_detail['comment']).'</td>';

                                $output .= '<td align="center">'.stripslashes($row['from_scale']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['to_scale']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['label_of_scale']).'</td>';

				

				

				$output .= '<td align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_scale&id='.$row['scaleid'].'&page='.$page->page.'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Manage Scale","sql/delscale.php?id='.$row['scaleid'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr class="manage-row" height="20"><td colspan="17" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="16" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

        

        public function getAllDailyMeals($search)

	{       $obj = new Daily_Meals();

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '11';

		$delete_action_id = '13';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

//		if($search == '')

//			{

//				$sql = "SELECT * FROM `tbldailymealsfavcategory` ORDER BY meal_id DESC";

//			}

//		else

//			{

//			  $sql = "select * from `tbldailymeals` where meal_item like '%".$search."%' order by meal_id DESC";

//			}

                        

               $sql ='SELECT TMV.*,TDM.meal_item,TDM.meal_measure,TDM.meal_ml,TDM.weight,TDM.food_type,TDM.food_veg_nonveg,TDM.benefits,TDM.daily_core,TDM.meal_add_date,TDM.posted_by from '

                           . 'tbldailymealsfavcategory as TMV LEFT JOIN  tbldailymeals as TDM ON TMV.meal_id = TDM.meal_id ORDER BY TMV.meal_id DESC ';     

                        

                 //$sql = "SELECT * FROM `tblcustomfavcategory` "

                 //   . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$fav_cat_type_id."' and tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";       

                        

                $STH = $DBH->prepare($sql);

                $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page = 50;

		$scroll = 5;

		$page = new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=daily_meals");

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

				

			while( $row = $STH2->fetch(PDO::FETCH_ASSOC))

			{

                               $MEASURE = $obj->getMEASURESNameById($row['meal_id']);

                               $FoodType = $obj->getFoodTypeNameById($row['meal_id']);

                               $Volume = $obj->getVolumeNameById($row['meal_id']);

                               $FoodVegNonVeg = $obj->getFoodVegNonVegNameById($row['meal_id']);

				$output .= '<tr class="manage-row">';

				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';

                                

                                $output .= '<td height="30" align="center">'.$obj->getAdminNameRam($row['posted_by']).'</td>';

                                $output .= '<td height="30" align="center">'.date("d-m-Y h:i:s",strtotime($row['meal_add_date'])).'</td>';

                                

                                $output .= '<td align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_daily_meal&id='.$row['id'].'&meal_id='.$row['meal_id'].'&page='.$page->page.'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Daily Meal","sql/deldailymeal.php?id='.$row['id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '<td align="center">'.stripslashes($obj->getCodeNameById($row['meal_id'])).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getMealsNameById($row['meal_id'])).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getBenefitsNameById($row['meal_id'])).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getIdByMEASURESName($MEASURE)).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getIdByMEASURESName($Volume)).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getWEIGHTNameById($row['meal_id'])).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getIdByFoodTypeName($FoodType)).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getIdByFoodVegNonVegName($FoodVegNonVeg)).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getIdByMEASURESName($row['fav_cat_id'])).'</td>';

				$output .= '<td align="center">'.stripslashes($row['content']).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getIdByMEASURESName($row['uom'])).'</td>';

				

				

				$output .= '</tr>';

				//$output .= '<tr class="manage-row" height="20"><td colspan="17" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="16" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}	

	//add by ample 29-11-19
	public function getAllDailyMealsNew($search,$filterParam)

	{       
		$obj = new Daily_Meals();
		$my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '11';
		$delete_action_id = '13';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		$querySearch = '';
		if(!empty($filterParam['foodcode'])){
			$querySearch.=' AND meal_item="'.$filterParam['foodcode'].'"';
		}

		if(!empty($filterParam['foodtype'])){
			$querySearch.=' AND food_type="'.$filterParam['foodtype'].'"';
		}

		if(!empty($filterParam['status'])){
			if($filterParam['status']=='active'){
				$statusType = '1';
			}else{
				$statusType = '0';
			}
			$querySearch.=' AND status='.$statusType.'';
		}


		$sql ="SELECT * FROM `tbldailymeals` WHERE meal_id>0 $querySearch order by meal_id DESC "; 
                                

                $STH = $DBH->prepare($sql);

                $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page = 50;

		$scroll = 5;

		$page = new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=daily_meals");

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

				

			while( $row = $STH2->fetch(PDO::FETCH_ASSOC))

			{		
							$foods=$this->compositionInfo($row['meal_id']);

                               $MEASURE = $obj->getMEASURESNameById($row['meal_id']);
                               
                               $Volume = $obj->getVolumeNameById($row['meal_id']);

                               $FoodVegNonVeg = $obj->getFoodVegNonVegNameById($row['meal_id']);


                               // add by ample 12-12-19
                               	$FoodType = $obj->getFoodTypeNameById($row['meal_id']);
								$ingredient_type=explode(',', $FoodType);
								$type_name=array();
								if(!empty($ingredient_type))
								{
									foreach ($ingredient_type as $key => $value) {
										$name=$this->getIdByFoodTypeName($value);
										array_push($type_name,$name);
									}
								}

				$logsObject = new Logs();
				$lastUpdatedData = [
					'page' => 'daily_meals',
					'reference_id' => $row['meal_id']
				];
				$lastUpdatedData = $logsObject->getLastUpdatedLogs($lastUpdatedData); 
				if((int)$filterParam['modified']>0){
					if($lastUpdatedData['updateById']!=$filterParam['modified']){
						continue;
					}
				}

				$output .= '<tr class="manage-row">';

				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';

                                

                                $output .= '<td height="30" align="center">'.$obj->getAdminNameRam($row['posted_by']).'</td>';

                                $output .= '<td height="30" align="center">'.date("d-m-Y h:i:s",strtotime($row['meal_add_date'])).'</td>';

                                

                                $output .= '<td align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_daily_meal&meal_id='.$row['meal_id'].'&page='.$page->page.'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td align="center" nowrap="nowrap">';

						if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Daily Meal","sql/deldailymeal.php?id='.$row['meal_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '<td align="center">'.stripslashes($lastUpdatedData['updateOn']).'
				<a href="/admin/index.php?mode=logs-history&type=daily_activity&id='.$row['activity_id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';

				$output .= '<td align="center">'.stripslashes($lastUpdatedData['updateBy']).'<a href="/admin/index.php?mode=logs-history&type=daily_activity&id='.$row['activity_id'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15px" height="15px"><path d="M19,21H5c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h7v2H5v14h14v-7h2v7C21,20.1,20.1,21,19,21z"/><path d="M21 10L19 10 19 5 14 5 14 3 21 3z"/><path d="M6.7 8.5H22.3V10.5H6.7z" transform="rotate(-45.001 14.5 9.5)"/></svg></a></td>';
				if($row['status']==0){
					$output .= '<td align="center">Inactive</td>';
				}else{
					$output .= '<td align="center">Active</td>';
				}
				$output .= '<td align="center">'.stripslashes($obj->getCodeNameById($row['meal_id'])).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getMealsNameById($row['meal_id'])).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getBenefitsNameById($row['meal_id'])).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getIdByMEASURESName($MEASURE)).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getIdByMEASURESName($Volume)).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getWEIGHTNameById($row['meal_id'])).'</td>';

				$output .= '<td align="center">'.implode(',',$type_name).'</td>';

				$output .= '<td align="center">'.stripslashes($obj->getIdByFoodVegNonVegName($FoodVegNonVeg)).'</td>';

				// $output .= '<td align="center">'.stripslashes($obj->getIdByMEASURESName($row['fav_cat_id'])).'</td>';

				// $output .= '<td align="center">'.stripslashes($row['content']).'</td>';

				// $output .= '<td align="center">'.stripslashes($obj->getIdByMEASURESName($row['uom'])).'</td>';

				$output .= '<td align="center">';
				if(!empty($foods))
				{	
					$output .='<table class="table table-condensed"><thead><tr><th>Composition</th><th>Content</th><th>UOM</th></tr></thead><tbody>';
					foreach ($foods as $key => $value) {
						
						$output .='<tr>';
						$output .='<td>'.$obj->getIdByMEASURESName($value['fav_cat_id']).'</td>';
						$output .='<td>'.stripslashes($value['content']).'</td>';
						$output .='<td>'.$obj->getIdByMEASURESName($value['uom']).'</td>';
						$output .='</tr>';
					}
					$output .='</tbody></thead></table>';
				}
				$output .='</td>';

				

				$output .= '</tr>';

				//$output .= '<tr class="manage-row" height="20"><td colspan="17" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="16" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}
        

         public function getMealsNameById($meals_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meals_id."' ";

                  $STH = $DBH->prepare($sql);  

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['meal_item']);

                }

                return $meal_item;

            }

        public function getBenefitsNameById($meals_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meals_id."' ";

                  $STH = $DBH->prepare($sql); 

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['benefits']);

                }

                return $meal_item;

            }

            

        public function getCodeNameById($meals_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meals_id."' ";

                  $STH = $DBH->prepare($sql); 

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['daily_core']);

                }

                return $meal_item;

            }    

        public function getMEASURESNameById($meals_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meals_id."' ";

                  $STH = $DBH->prepare($sql); 

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['meal_measure']);

                }

                return $meal_item;

            }

         public function getIdByMEASURESName($fav_cat_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";

                  $STH = $DBH->prepare($sql); 

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['fav_cat']);

                }

                return $meal_item;

            }  

         public function getMoreFavCategoryTypeOptions($fav_cat_id,$fav_cat_type_id)

	{ 

            

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '';		



            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` IN('".$fav_cat_id."') AND `prct_cat_status` = '1' AND `prct_cat_deleted` = '0' ORDER BY `prct_cat` ASC";

//            //echo $sql;

            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` IN ('".$fav_cat_id."') ";

              $STH = $DBH->prepare($sql); 

              $STH->execute();

            if($STH->rowCount() > 0)

            {

                $option_str .='<option value="">Select Type</option>';

                while( $row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                    if($row['prct_cat_id'] == $fav_cat_type_id)

                    {

                            $sel = ' selected ';

                    }

                    else

                    {

                            $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['prct_cat_id'].'" '.$sel.'>'.stripslashes($row['prct_cat']).'</option>';

                }

            }

            return $option_str;

	}

           

        

         public function getMoreFavCategoryRamakant($fav_cat_type_id,$fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '';		

            //echo 'aaa->'.$fav_cat_type_id;

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";

            $sql = "SELECT * FROM `tblcustomfavcategory` "

                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('".$fav_cat_type_id."') and tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";

           //echo $sql;

              $STH = $DBH->prepare($sql); 

              $STH->execute();

            $option_str .= '<option value="">Select Category</option>';

            if($STH->rowCount() > 0)

            {

               

                while( $row = $STH->fetch(PDO::FETCH_ASSOC))

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

        

        

        public function getMoreFavCategoryVivek($fav_cat_type_id,$fav_cat_id)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $option_str = '';		

            //echo 'aaa->'.$fav_cat_type_id;

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";

           $sql = "SELECT * FROM `tblcustomfavcategory` "

                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('".$fav_cat_type_id."') and tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";

            //echo $sql;

              $STH = $DBH->prepare($sql); 

              $STH->execute();

            $option_str .= '<option value="">Select Category</option>';

            if($STH->rowCount() > 0)

            {

               

                while( $row = $STH->fetch(PDO::FETCH_ASSOC))

                {   

                    if(in_array($row['favcat_id'],$fav_cat_id))

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

         public function getIdByProfileFavCategoryName($fav_cat_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` = '".$fav_cat_id."' ";

                  $STH = $DBH->prepare($sql);

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['prct_cat']);

                }

                return $meal_item;

            }      

         public function getIdByFavCategoryName($fav_cat_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";

                  $STH = $DBH->prepare($sql);

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['fav_cat']);

                }

                return $meal_item;

            }      

    

        public function getWEIGHTNameById($meals_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meals_id."' ";

                  $STH = $DBH->prepare($sql);

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['weight']);

                }

                return $meal_item;

            }

        public function getFoodTypeNameById($meals_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meals_id."' ";

                  $STH = $DBH->prepare($sql);

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['food_type']);

                }

                return $meal_item;

            }

          public function getVolumeNameById($meals_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meals_id."' ";

                  $STH = $DBH->prepare($sql); 

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['meal_ml']);

                }

                return $meal_item;

            }   

         public function getIdByFoodTypeName($fav_cat_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";

                  $STH = $DBH->prepare($sql);

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['fav_cat']);

                }

                return $meal_item;

            }        

        public function getFoodVegNonVegNameById($meals_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meals_id."' ";

                  $STH = $DBH->prepare($sql); 

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['food_veg_nonveg']);

                }

                return $meal_item;

            }

         public function getIdByFoodVegNonVegName($fav_cat_id)

            {

                $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();



                $meal_item = '';



                //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";

                $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";

                  $STH = $DBH->prepare($sql);

                  $STH->execute();

                if($STH->rowCount() > 0)

                {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $meal_item = stripslashes($row['fav_cat']);

                }

                return $meal_item;

            }    



	public function chkMealItemAlreadyExists($meal_item)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_item` = '".addslashes($meal_item)."'";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function chkMealItemAlreadyExists_edit($meal_item,$meal_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_item` = '".addslashes($meal_item)."' AND `meal_id` != '".$meal_id."'";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getMealDetails($id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

				

//	old	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."'";

                $sql = "SELECT * FROM `tbldailymealsfavcategory`, `tbldailymeals` WHERE tbldailymealsfavcategory.meal_id=tbldailymeals.meal_id and tbldailymealsfavcategory.id='".$id."'";

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

			$meal_item = stripslashes($row['meal_item']);

			$meal_measure = stripslashes($row['meal_measure']);

			$meal_ml = stripslashes($row['meal_ml']);

			$weight = stripslashes($row['weight']);

			$food_type = stripslashes($row['food_type']);

			$food_veg_nonveg = stripslashes($row['food_veg_nonveg']);

			$fav_cat_id = stripslashes($row['fav_cat_id']);

			$show_hide = stripslashes($row['show_hide']);

                        $uom = stripslashes($row['uom']);

                        $content = stripslashes($row['content']);

                        $id = stripslashes($row['id']);

                        $daily_core = stripslashes($row['daily_core']);

                        $benefits = stripslashes($row['benefits']);

			

		}

		return array($benefits,$daily_core,$content,$meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$fav_cat_id,$show_hide,$uom,$id);

	}

	// add function by ample 29-11-19
	public function getMealInfo($meal_id="")
	{
		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

			$sql = "SELECT m.meal_id,m.meal_item,m.meal_measure,m.meal_ml,m.weight,m.food_type,m.food_veg_nonveg,m.benefits,m.daily_core,m.status FROM `tbldailymeals` m WHERE `meal_id` = '".$meal_id."'";

            //$sql = "SELECT * FROM `tbldailymealsfavcategory`, `tbldailymeals` WHERE tbldailymealsfavcategory.meal_id=tbldailymeals.meal_id and tbldailymealsfavcategory.id='".$id."'";

		  $STH = $DBH->prepare($sql);

             $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

		}

		return $row;;
	}
	// add function by ample 29-11-19
	public function insertDailyMealFavCat($show_hide,$uom,$fav_cat_id,$content,$meal_id,$cat_total_cnt,$modified_by)
	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;


                            for($i=0; $i<$cat_total_cnt; $i++)

                            {

                                    $tdata_cat = array();

                                    $tdata_cat['meal_id'] = $meal_id;

                                    $tdata_cat['fav_cat_id'] = $fav_cat_id[$i];

                                    $tdata_cat['uom'] = $uom[$i];

                                    $tdata_cat['show_hide'] = $show_hide[$i];

                                    $tdata_cat['content'] = $content[$i];


                                $sql2 = "INSERT INTO `tbldailymealsfavcategory` (`content`,`meal_id`,`fav_cat_id`,`uom`,`show_hide`,added_by) VALUES ('".addslashes($tdata_cat['content'])."','".addslashes($tdata_cat['meal_id'])."','".addslashes($tdata_cat['fav_cat_id'])."','".addslashes($tdata_cat['uom'])."','".addslashes($tdata_cat['show_hide'])."','".$modified_by."')";


                               $STH = $DBH->prepare($sql2);  $STH->execute();

                              $return = true;

                            }


		return $return;
	}
	// add function by ample 29-11-19
	public function compositionInfo($meal_id="")
	{
		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $data=array();

            $sql = "SELECT * FROM `tbldailymealsfavcategory` c WHERE c.meal_id='".$meal_id."'";

		  $STH = $DBH->prepare($sql);

             $STH->execute();

		if($STH->rowCount() > 0)

		{

			while( $row = $STH->fetch(PDO::FETCH_ASSOC))
            {

			$data[] = $row;

            }

		}

		return $data;;
	}

	

        public function addScaleProfCatData()

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		$now = time();

		

		$sql = "INSERT INTO `tbl_scale_prof_cat` (`scale_id`,`prof_cat`,`sub_cat`) VALUES ('0','0','0')";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	public function getScalePrfoCatDetails1($scale_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

				

                $data=array();

//	old	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."'";

                $sql = "SELECT * FROM `tbl_scale_prof_cat` WHERE scale_id ='".$scale_id."'";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			while( $row = $STH->fetch(PDO::FETCH_ASSOC))

                        {

			$data[] = $row;

			

                        }

                        

			

		}

                

		return array($data);

	}

        public function getScalePrfoCatDetails($scale_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

				

                $data=array();

//	old	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."'";

                $sql = "SELECT * FROM `tbl_scale_prof_cat` WHERE scale_id ='".$scale_id."'";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			while( $row = $STH->fetch(PDO::FETCH_ASSOC))

                        {

			$data[] = $row;

			

                        }

                        

			

		}

                

		return array($data);

	}

	

        public function getScaleDetails($scale_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

				

//	old	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."'";

                $sql = "SELECT * FROM `tbl_scale`,`tbl_scale_add_more` WHERE tbl_scale.scale_id= tbl_scale_add_more.scale_id and tbl_scale_add_more.scaleid ='".$scale_id."'";

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

			$scale_code = stripslashes($row['scale_code']);

			$from_range = stripslashes($row['from_range']);

			$to_range = stripslashes($row['to_range']);

			$comment = stripslashes($row['comment']);

			$from_scale = stripslashes($row['from_scale']);

			$to_scale = stripslashes($row['to_scale']);

			$label_of_scale = stripslashes($row['label_of_scale']);

                        $scale_id = stripslashes($row['scale_id']);

			

                        

			

		}

		return array($scale_code,$from_range,$to_range,$comment,$from_scale,$to_scale,$label_of_scale,$scale_id);

	}

        

        

	

//        public function getPageCatDropdownValue($page_name)

//	{

//		$my_DBH = new mysqlConnection();$DBH = $my_DBH->raw_handle();$DBH->beginTransaction();

//				

////	old	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."'";

//                $sql = "SELECT * FROM `tbl_page_cat_dropdown` WHERE  page_name ='".$page_name."'";

//		  $STH = $DBH->prepare($sql);  $STH->execute();

//		if($STH->rowCount() > 0)

//		{

//			 $row = $STH->fetch(PDO::FETCH_ASSOC);

//			$prof_cat1_value = stripslashes($row['prof_cat1']);

//			$prof_cat2_value = stripslashes($row['prof_cat2']);

//			$prof_cat3_value = stripslashes($row['prof_cat3']);

//			$prof_cat4_value = stripslashes($row['prof_cat4']);

//			$prof_cat5_value = stripslashes($row['prof_cat5']);

//			$prof_cat6_value = stripslashes($row['prof_cat6']);

//			$prof_cat7_value = stripslashes($row['prof_cat7']);

//			$prof_cat8_value = stripslashes($row['prof_cat8']);

//			$prof_cat9_value = stripslashes($row['prof_cat9']);

//			$prof_cat10_value = stripslashes($row['prof_cat10']);

//                        

//			

//		}

//		return array($prof_cat1_value,$prof_cat2_value,$prof_cat3_value,$prof_cat4_value,$prof_cat5_value,$prof_cat6_value,$prof_cat7_value,$prof_cat8_value,$prof_cat9_value,$prof_cat10_value);

//	}

//	

        

        public function getPageCatDropdownValue($page_name)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

				

//	old	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."'";

                $sql = "SELECT * FROM `tbl_page_cat_dropdown` WHERE  page_name ='".$page_name."'";

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

                      

			$prof_cat1_value = stripslashes($row['prof_cat1']);

			$prof_cat2_value = stripslashes($row['prof_cat2']);

			$prof_cat3_value = stripslashes($row['prof_cat3']);

			$prof_cat4_value = stripslashes($row['prof_cat4']);

			$prof_cat5_value = stripslashes($row['prof_cat5']);

			$prof_cat6_value = stripslashes($row['prof_cat6']);

			$prof_cat7_value = stripslashes($row['prof_cat7']);

			$prof_cat8_value = stripslashes($row['prof_cat8']);

			$prof_cat9_value = stripslashes($row['prof_cat9']);

			$prof_cat10_value = stripslashes($row['prof_cat10']);

                        $header1 = stripslashes($row['header1']);

     

                      $header2 = stripslashes($row['header2']);

    

                      $header3 = stripslashes($row['header3']);

    

                       $header4 = stripslashes($row['header4']);

     

                       $header5 = stripslashes($row['header5']);

    

                       $header6 = stripslashes($row['header6']);

    

                       $header7 = stripslashes($row['header7']);

                       

                       $header8 = stripslashes($row['header8']);

                       

                         $header9 = stripslashes($row['header9']);

    

                       $header10 = stripslashes($row['header10']);

			

		}

		return array($header1,$header2,$header3,$header4,$header5,$header6,$header7,$header8,$header9,$header10,$prof_cat1_value,$prof_cat2_value,$prof_cat3_value,$prof_cat4_value,$prof_cat5_value,$prof_cat6_value,$prof_cat7_value,$prof_cat8_value,$prof_cat9_value,$prof_cat10_value);

	}

	public function addDailyMealOld($meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$water,$calories,$total_fat,$saturated,$monounsaturated,$total_polyunsaturated,$polyunsaturated_linoleic,$polyunsaturated_alphalinoleic,$cholesterol,$total_dietary_fiber,$total_carbohydrate,$total_monosaccharide,$glucose,$fructose,$galactose,$total_disaccharide,$maltose,$lactose,$sucrose,$total_polysaccharide,$starch,$cellulose,$glycogen,$dextrins,$sugar,$total_vitamin,$vitamin_a,$re,$vitamin_b_complex,$thiamin,$riboflavin,$niacin,$pantothenic_acid,$pyridoxine_hcl,$cyanocobalamin,$folic_acid,$biotin,$ascorbic_acid,$calciferol,$tocopherol,$phylloquinone,$protein,$alanine,$arginine,$aspartic_acid,$cystine,$giutamic_acid,$glycine,$histidine,$hydroxy_glutamic_acid,$hydroxy_proline,$iodogorgoic_acid,$isoleucine,$leucine,$lysine,$methionine,$norleucine,$phenylalanine,$proline,$serine,$threonine,$thyroxine,$tryptophane,$tyrosine,$valine,$total_minerals,$calcium,$iron,$potassium,$sodium,$phosphorus,$sulphur,$chlorine,$iodine,$magnesium,$zinc,$copper,$chromium,$manganese,$selenium,$boron,$molybdenum,$caffeine)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		$now = time();

		

		$sql = "INSERT INTO `tbldailymeals` (`meal_item`,`meal_measure`,`meal_ml`,`weight`,`food_type`,`food_veg_nonveg`,`water`,`calories`,`total_fat`,`saturated`,`monounsaturated`,`total_polyunsaturated`,`polyunsaturated_linoleic`,`polyunsaturated_alphalinoleic`,`cholesterol`,`total_dietary_fiber`,`total_carbohydrate`,`total_monosaccharide`,`glucose`,`fructose`,`galactose`,`total_disaccharide`,`maltose`,`lactose`,`sucrose`,`total_polysaccharide`,`starch`,`cellulose`,`glycogen`,`dextrins`,`sugar`,`total_vitamin`,`vitamin_a`,`re`,`vitamin_b_complex`,`thiamin`,`riboflavin`,`niacin`,`pantothenic_acid`,`pyridoxine_hcl`,`cyanocobalamin`,`folic_acid`,`biotin`,`ascorbic_acid`,`calciferol`,`tocopherol`,`phylloquinone`,`protein`,`alanine`,`arginine`,`aspartic_acid`,`cystine`,`giutamic_acid`,`glycine`,`histidine`,`hydroxy_glutamic_acid`,`hydroxy_proline`,`iodogorgoic_acid`,`isoleucine`,`leucine`,`lysine`,`methionine`,`norleucine`,`phenylalanine`,`proline`,`serine`,`threonine`,`thyroxine`,`tryptophane`,`tyrosine`,`valine`,`total_minerals`,`calcium`,`iron`,`potassium`,`sodium`,`phosphorus`,`sulphur`,`chlorine`,`iodine`,`magnesium`,`zinc`,`copper`,`chromium`,`manganese`,`selenium`,`boron`,`molybdenum`,`caffeine`,`meal_add_date`) VALUES ('".addslashes($meal_item)."','".addslashes($meal_measure)."','".addslashes($meal_ml)."','".addslashes($weight)."','".addslashes($food_type)."','".addslashes($food_veg_nonveg)."','".addslashes($water)."','".addslashes($calories)."','".addslashes($total_fat)."','".addslashes($saturated)."','".addslashes($monounsaturated)."','".addslashes($total_polyunsaturated)."','".addslashes($polyunsaturated_linoleic)."','".addslashes($polyunsaturated_alphalinoleic)."','".addslashes($cholesterol)."','".addslashes($total_dietary_fiber)."','".addslashes($total_carbohydrate)."','".addslashes($total_monosaccharide)."','".addslashes($glucose)."','".addslashes($fructose)."','".addslashes($galactose)."','".addslashes($total_disaccharide)."','".addslashes($maltose)."','".addslashes($lactose)."','".addslashes($sucrose)."','".addslashes($total_polysaccharide)."','".addslashes($starch)."','".addslashes($cellulose)."','".addslashes($glycogen)."','".addslashes($dextrins)."','".addslashes($sugar)."','".addslashes($total_vitamin)."','".addslashes($vitamin_a)."','".addslashes($re)."','".addslashes($vitamin_b_complex)."','".addslashes($thiamin)."','".addslashes($riboflavin)."','".addslashes($niacin)."','".addslashes($pantothenic_acid)."','".addslashes($pyridoxine_hcl)."','".addslashes($cyanocobalamin)."','".addslashes($folic_acid)."','".addslashes($biotin)."','".addslashes($ascorbic_acid)."','".addslashes($calciferol)."','".addslashes($tocopherol)."','".addslashes($phylloquinone)."','".addslashes($protein)."','".addslashes($alanine)."','".addslashes($arginine)."','".addslashes($aspartic_acid)."','".addslashes($cystine)."','".addslashes($giutamic_acid)."','".addslashes($glycine)."','".addslashes($histidine)."','".addslashes($hydroxy_glutamic_acid)."','".addslashes($hydroxy_proline)."','".addslashes($iodogorgoic_acid)."','".addslashes($isoleucine)."','".addslashes($leucine)."','".addslashes($lysine)."','".addslashes($methionine)."','".addslashes($norleucine)."','".addslashes($phenylalanine)."','".addslashes($proline)."','".addslashes($serine)."','".addslashes($threonine)."','".addslashes($thyroxine)."','".addslashes($tryptophane)."','".addslashes($tyrosine)."','".addslashes($valine)."','".addslashes($total_minerals)."','".addslashes($calcium)."','".addslashes($iron)."','".addslashes($potassium)."','".addslashes($sodium)."','".addslashes($phosphorus)."','".addslashes($sulphur)."','".addslashes($chlorine)."','".addslashes($iodine)."','".addslashes($magnesium)."','".addslashes($zinc)."','".addslashes($copper)."','".addslashes($chromium)."','".addslashes($manganese)."','".addslashes($selenium)."','".addslashes($boron)."','".addslashes($molybdenum)."','".addslashes($caffeine)."','".$now."')";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

			 //Insert lOGS
			$lastInsertedId = $DBH->lastInsertId();
			$logsObject = new Logs();
			$logsData = [
				'page' => 'daily_meals',
				'reference_id' => $lastInsertedId
			];
			$logsObject->insertLogs($logsData);

		}

		return $return;

	}
	//update status by ample 02-12-19
        public function addDailyMeal($posted_by,$benefits,$daily_core,$content,$meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$show_hide,$uom,$fav_cat_id,$cat_total_cnt,$status)

	{	


		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		
		//update status by ample 02-12-19
		$sql = "INSERT INTO `tbldailymeals` (`posted_by`,`benefits`,`daily_core`,`meal_item`,`meal_measure`,`meal_ml`,`weight`,`food_type`,`food_veg_nonveg`,status,`modified_by`,`deleted`,`deleted_by`) VALUES ('".$posted_by."','".addslashes($benefits)."','".addslashes($daily_core)."','".addslashes($meal_item)."','".addslashes($meal_measure)."','".addslashes($meal_ml)."','".addslashes($weight)."','".addslashes($food_type)."','".addslashes($food_veg_nonveg)."','".$status."',0,0,0)";

                $STH = $DBH->prepare($sql);

                $STH->execute();

                $meal_id = $DBH->lastInsertId();

                
				if(!is_array($cat_total_cnt)){
					$cat_total_cnt = [];
				}
                 if(count($cat_total_cnt) > 0)

                    {

                            for($i=0; $i<$cat_total_cnt; $i++)

                            {

                                    $tdata_cat = array();

                                    $tdata_cat['meal_id'] = $meal_id;

                                    $tdata_cat['fav_cat_id'] = $fav_cat_id[$i];

                                    $tdata_cat['uom'] = $uom[$i];

                                    $tdata_cat['show_hide'] = $show_hide[$i];

                                    $tdata_cat['content'] = $content[$i];

                                    

//                                    $this->addfavcategory($tdata_cat);	
                                    //update by ample 02-12-19

                                $sql2 = "INSERT INTO `tbldailymealsfavcategory` (`content`,`meal_id`,`fav_cat_id`,`uom`,`show_hide`,added_by) VALUES ('".addslashes($tdata_cat['content'])."','".addslashes($tdata_cat['meal_id'])."','".addslashes($tdata_cat['fav_cat_id'])."','".addslashes($tdata_cat['uom'])."','".addslashes($tdata_cat['show_hide'])."','".$posted_by."')";

                                

                               $STH = $DBH->prepare($sql2);  $STH->execute();

                              
									 //Insert lOGS
								$lastInsertedId = $DBH->lastInsertId();
								$logsObject = new Logs();
								$logsData = [
									'page' => 'daily_meals',
									'reference_id' => $lastInsertedId
								];
								$logsObject->insertLogs($logsData);
                            }



                    }



		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

        public function addScale($scale_code,$prof_cat,$sub_cat,$from_range,$to_range,$comment,$from_scale,$to_scale,$label_of_scale,$cat_total_cnt,$total_count)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "INSERT INTO `tbl_scale` (`scale_code`,`from_range`,`to_range`,`comment`) VALUES ('".addslashes($scale_code)."','".addslashes($from_range)."','".addslashes($to_range)."','".addslashes($comment)."')";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

                $scale_id = $this->getInsertID();

                

                 if(count($cat_total_cnt) > 0)

                    {

                            for($i=0; $i<$cat_total_cnt; $i++)

                            {

                                    $tdata_cat = array();

                                    $tdata_cat['scale_id'] = $scale_id;

                                    $tdata_cat['from_scale'] = $from_scale[$i];

                                    $tdata_cat['to_scale'] = $to_scale[$i];

                                    $tdata_cat['label_of_scale'] = $label_of_scale[$i];

                                   

                                    

//                                    $this->addfavcategory($tdata_cat);	

                                $sql2 = "INSERT INTO `tbl_scale_add_more` (`scale_id`,`from_scale`,`to_scale`,`label_of_scale`) VALUES ('".addslashes($tdata_cat['scale_id'])."','".addslashes($tdata_cat['from_scale'])."','".addslashes($tdata_cat['to_scale'])."','".addslashes($tdata_cat['label_of_scale'])."')";

                                

                               $STH = $DBH->prepare($sql2); 

                               $STH->execute();

                              

                            }



                    }

                 if(count($total_count) > 0)

                    {

                            for($i=0; $i<$total_count; $i++)

                            {

                                    $tdata_cat = array();

                                    $tdata_cat['scale_id'] = $scale_id;

                                    $tdata_cat['prof_cat'] = $prof_cat[$i];

                                    $tdata_cat['sub_cat'] = $sub_cat[$i];

                                    

                                    

//                                    $this->addfavcategory($tdata_cat);	

                                $sql3 = "INSERT INTO `tbl_scale_prof_cat` (`scale_id`,`prof_cat`,`sub_cat`) VALUES ('".addslashes($tdata_cat['scale_id'])."','".addslashes($tdata_cat['prof_cat'])."','".addslashes($tdata_cat['sub_cat'])."')";

                                

                               $STH = $DBH->prepare($sql3); 

                               $STH->execute();

                              

                            }



                    }    



		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	public function updateDailyMealOld($meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$water,$calories,$total_fat,$saturated,$monounsaturated,$total_polyunsaturated,$polyunsaturated_linoleic,$polyunsaturated_alphalinoleic,$cholesterol,$total_dietary_fiber,$total_carbohydrate,$total_monosaccharide,$glucose,$fructose,$galactose,$total_disaccharide,$maltose,$lactose,$sucrose,$total_polysaccharide,$starch,$cellulose,$glycogen,$dextrins,$sugar,$total_vitamin,$vitamin_a,$re,$vitamin_b_complex,$thiamin,$riboflavin,$niacin,$pantothenic_acid,$pyridoxine_hcl,$cyanocobalamin,$folic_acid,$biotin,$ascorbic_acid,$calciferol,$tocopherol,$phylloquinone,$protein,$alanine,$arginine,$aspartic_acid,$cystine,$giutamic_acid,$glycine,$histidine,$hydroxy_glutamic_acid,$hydroxy_proline,$iodogorgoic_acid,$isoleucine,$leucine,$lysine,$methionine,$norleucine,$phenylalanine,$proline,$serine,$threonine,$thyroxine,$tryptophane,$tyrosine,$valine,$total_minerals,$calcium,$iron,$potassium,$sodium,$phosphorus,$sulphur,$chlorine,$iodine,$magnesium,$zinc,$copper,$chromium,$manganese,$selenium,$boron,$molybdenum,$caffeine,$meal_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$now = time();

		$return=false;

		$upd_sql = "UPDATE `tbldailymeals` SET `meal_item` = '".addslashes($meal_item)."' , `meal_measure` = '".addslashes($meal_measure)."' , `meal_ml` = '".addslashes($meal_ml)."' , `weight` = '".addslashes($weight)."' , `food_type` = '".addslashes($food_type)."' , `food_veg_nonveg` = '".addslashes($food_veg_nonveg)."' , `water` = '".addslashes($water)."' , `calories` = '".addslashes($calories)."' , `total_fat` = '".addslashes($total_fat)."' , `saturated` = '".addslashes($saturated)."' , `monounsaturated` = '".addslashes($monounsaturated)."' , `total_polyunsaturated` = '".addslashes($total_polyunsaturated)."' , `polyunsaturated_linoleic` = '".addslashes($polyunsaturated_linoleic)."' , `polyunsaturated_alphalinoleic` = '".addslashes($polyunsaturated_alphalinoleic)."' , `cholesterol` = '".addslashes($cholesterol)."' , `total_dietary_fiber` = '".addslashes($total_dietary_fiber)."' , `total_carbohydrate` = '".addslashes($total_carbohydrate)."' , `total_monosaccharide` = '".addslashes($total_monosaccharide)."' , `glucose` = '".addslashes($glucose)."' , `fructose` = '".addslashes($fructose)."' , `galactose` = '".addslashes($galactose)."' , `total_disaccharide` = '".addslashes($total_disaccharide)."' , `maltose` = '".addslashes($maltose)."' , `lactose` = '".addslashes($lactose)."' , `sucrose` = '".addslashes($sucrose)."' , `total_polysaccharide` = '".addslashes($total_polysaccharide)."' , `starch` = '".addslashes($starch)."' , `cellulose` = '".addslashes($cellulose)."' , `glycogen` = '".addslashes($glycogen)."' , `dextrins` = '".addslashes($dextrins)."' , `sugar` = '".addslashes($sugar)."' , `total_vitamin` = '".addslashes($total_vitamin)."' , `vitamin_a` = '".addslashes($vitamin_a)."' , `re` = '".addslashes($re)."' , `vitamin_b_complex` = '".addslashes($vitamin_b_complex)."' , `thiamin` = '".addslashes($thiamin)."' , `riboflavin` = '".addslashes($riboflavin)."' , `niacin` = '".addslashes($niacin)."' , `pantothenic_acid` = '".addslashes($pantothenic_acid)."' , `pyridoxine_hcl` = '".addslashes($pyridoxine_hcl)."' , `cyanocobalamin` = '".addslashes($cyanocobalamin)."' , `folic_acid` = '".addslashes($folic_acid)."' , `biotin` = '".addslashes($biotin)."' , `ascorbic_acid` = '".addslashes($ascorbic_acid)."' , `calciferol` = '".addslashes($calciferol)."' , `tocopherol` = '".addslashes($tocopherol)."' , `phylloquinone` = '".addslashes($phylloquinone)."' , `protein` = '".addslashes($protein)."' , `alanine` = '".addslashes($alanine)."' , `arginine` = '".addslashes($arginine)."' , `aspartic_acid` = '".addslashes($aspartic_acid)."' , `cystine` = '".addslashes($cystine)."' , `giutamic_acid` = '".addslashes($giutamic_acid)."' , `glycine` = '".addslashes($glycine)."' , `histidine` = '".addslashes($histidine)."' , `hydroxy_glutamic_acid` = '".addslashes($hydroxy_glutamic_acid)."' , `hydroxy_proline` = '".addslashes($hydroxy_proline)."' , `iodogorgoic_acid` = '".addslashes($iodogorgoic_acid)."' , `isoleucine` = '".addslashes($isoleucine)."' , `leucine` = '".addslashes($leucine)."' , `lysine` = '".addslashes($lysine)."' , `methionine` = '".addslashes($methionine)."' , `norleucine` = '".addslashes($norleucine)."' , `phenylalanine` = '".addslashes($phenylalanine)."' , `proline` = '".addslashes($proline)."' , `serine` = '".addslashes($serine)."' , `threonine` = '".addslashes($threonine)."' , `thyroxine` = '".addslashes($thyroxine)."' , `tryptophane` = '".addslashes($tryptophane)."' , `tyrosine` = '".addslashes($tyrosine)."' , `valine` = '".addslashes($valine)."' , `total_minerals` = '".addslashes($total_minerals)."' , `calcium` = '".addslashes($calcium)."' , `iron` = '".addslashes($iron)."' , `potassium` = '".addslashes($potassium)."' , `sodium` = '".addslashes($sodium)."' , `phosphorus` = '".addslashes($phosphorus)."' , `sulphur` = '".addslashes($sulphur)."' , `chlorine` = '".addslashes($chlorine)."' , `iodine` = '".addslashes($iodine)."' , `magnesium` = '".addslashes($magnesium)."' , `zinc` = '".addslashes($zinc)."' , `copper` = '".addslashes($copper)."' , `chromium` = '".addslashes($chromium)."' , `manganese` = '".addslashes($manganese)."' , `selenium` = '".addslashes($selenium)."' , `boron` = '".addslashes($boron)."' , `molybdenum` = '".addslashes($molybdenum)."' , `caffeine` = '".addslashes($caffeine)."'  WHERE `meal_id` = '".$meal_id."'";

		  $STH = $DBH->prepare($upd_sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

			 //Insert lOGS
			
			$logsObject = new Logs();
			$logsData = [
				'page' => 'daily_meals',
				'reference_id' => $meal_id
			];
			$logsObject->insertLogs($logsData);

		}

		return $return;

	}
	//update status key by ample 02-12-19
        public function updateDailyMeal($posted_by,$benefits,$daily_core,$meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$meal_id,$status)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

                $date=date('Y-m-d H:i:s'); 

		$now = time();

			//update status key by ample 02-12-19

                  $upd_sql = "UPDATE `tbldailymeals` SET `modified_by`='".$posted_by."',`benefits` = '".addslashes($benefits)."' ,`daily_core` = '".addslashes($daily_core)."' ,`meal_item` = '".addslashes($meal_item)."' , `meal_measure` = '".addslashes($meal_measure)."' , `meal_ml` = '".addslashes($meal_ml)."' , `weight` = '".addslashes($weight)."' , `food_type` = '".addslashes($food_type)."' , `food_veg_nonveg` = '".addslashes($food_veg_nonveg)."', `status` = '".$status."',`modified_date`='".$date."'   WHERE `meal_id` = '".$meal_id."'";

		  $STH = $DBH->prepare($upd_sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;
			$logsObject = new Logs();
			$logsData = [
				'page' => 'daily_meals',
				'reference_id' => $meal_id
			];
			$logsObject->insertLogs($logsData);

		}

		return $return;

	}

        

       public function updateDailyMealFavCat($show_hide,$uom,$fav_cat_id,$content,$id,$modified_by)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

          $date=date('Y-m-d H:i:s'); 

		$now = time();

		

		$upd_sql = "UPDATE `tbldailymealsfavcategory` SET `fav_cat_id` = '".addslashes($fav_cat_id)."' , `content` = '".addslashes($content)."' , `uom` = '".addslashes($uom)."' , `show_hide` = '".addslashes($show_hide)."', `modified_by` = '".$modified_by."',`modified_date`='".$date."'     WHERE `id` = '".$id."'";

		  $STH = $DBH->prepare($upd_sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

       public function updateScale($scale_code,$from_range,$to_range,$comment,$scale_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$now = time();

		

		$upd_sql = "UPDATE `tbl_scale` SET `scale_code` = '".addslashes($scale_code)."' , `from_range` = '".addslashes($from_range)."' , `to_range` = '".addslashes($to_range)."', `comment` = '".addslashes($comment)."'   WHERE `scale_id` = '".$scale_id."'";

		  $STH = $DBH->prepare($upd_sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

         public function updateInterpretation($healcareandwellbeing,$lab,$adviser,$interpretation_code,$interpretation_no,$interpretation_id,$prof_cat,$sub_cat,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$listing_order,$admin_id,$user_type,$share_type)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$now = time();

		

		$upd_sql = "UPDATE `tbl_interpretation` SET `healcareandwellbeing` = '".$healcareandwellbeing."' ,`lab` = '".$lab."' , `adviser` = '".$adviser."' , `interpretation_code` = '".$interpretation_code."' , `interpretation_no` = '".$interpretation_no."' ,`interpretation_criteria` = '".$interpretation_criteria."' , `scale_form` = '".$scale_form."' , `scale_to` = '".$scale_to."', `symptom_type` = '".$symptom_type."', `symptom_name` = '".$symptom_name."',`listing_order` = '".$listing_order."',`prof_cat1` = '".$prof_cat[0]."',`prof_cat2` = '".$prof_cat[1]."',`prof_cat3` = '".$prof_cat[2]."',`prof_cat4` = '".$prof_cat[3]."',`prof_cat5` = '".$prof_cat[4]."',`prof_cat6` = '".$prof_cat[5]."',`prof_cat7` = '".$prof_cat[6]."',`prof_cat8` = '".$prof_cat[7]."',`prof_cat9` = '".$prof_cat[8]."',`prof_cat10` = '".$prof_cat[9]."',`sub_cat1` = '".$sub_cat[0]."',`sub_cat2` = '".$sub_cat[1]."',`sub_cat3` = '".$sub_cat[2]."',`sub_cat4` = '".$sub_cat[3]."',`sub_cat5` = '".$sub_cat[4]."',`sub_cat6` = '".$sub_cat[5]."',`sub_cat7` = '".$sub_cat[6]."',`sub_cat8` = '".$sub_cat[7]."',`sub_cat9` = '".$sub_cat[8]."',`sub_cat10` = '".$sub_cat[9]."',`identity_id` = '".$admin_id."',`identity_type` = '".$user_type."',`share_type` = '".$share_type."'   WHERE `interpretation_id` = '".$interpretation_id."'";

		  $STH = $DBH->prepare($upd_sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

//        public function updateInterpretation($interpretation_id,$prof_cat,$sub_cat,$interpretation_criteria,$scale_form,$scale_to,$symptom_type,$symptom_name,$listing_order)

//	{

//		$my_DBH = new mysqlConnection();$DBH = $my_DBH->raw_handle();$DBH->beginTransaction();

//		$now = time();

//		

//		$upd_sql = "UPDATE `tbl_interpretation` SET `interpretation_criteria` = '".$interpretation_criteria."' , `scale_form` = '".$scale_form."' , `scale_to` = '".$scale_to."', `symptom_type` = '".$symptom_type."', `symptom_name` = '".$symptom_name."',`listing_order` = '".$listing_order."',`prof_cat1` = '".$prof_cat[0]."',`prof_cat2` = '".$prof_cat[1]."',`prof_cat3` = '".$prof_cat[2]."',`prof_cat4` = '".$prof_cat[3]."',`prof_cat5` = '".$prof_cat[4]."',`prof_cat6` = '".$prof_cat[5]."',`prof_cat7` = '".$prof_cat[6]."',`prof_cat8` = '".$prof_cat[7]."',`prof_cat9` = '".$prof_cat[8]."',`prof_cat10` = '".$prof_cat[9]."',`sub_cat1` = '".$sub_cat[0]."',`sub_cat2` = '".$sub_cat[1]."',`sub_cat3` = '".$sub_cat[2]."',`sub_cat4` = '".$sub_cat[3]."',`sub_cat5` = '".$sub_cat[4]."',`sub_cat6` = '".$sub_cat[5]."',`sub_cat7` = '".$sub_cat[6]."',`sub_cat8` = '".$sub_cat[7]."',`sub_cat9` = '".$sub_cat[8]."',`sub_cat10` = '".$sub_cat[9]."'   WHERE `interpretation_id` = '".$interpretation_id."'";

//		  $STH = $DBH->prepare($upd_sql);  $STH->execute();

//		return $this->result;

//	}

       public function updateScaleProfCat($prof_cat,$sub_cat,$scale_id,$total_count)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return = false;

//		

                 if(count($total_count) > 0)

                    {

                            for($i=0; $i<$total_count; $i++)

                            {

                                    $tdata_cat = array();

                                    $tdata_cat['prof_cat'] = $prof_cat[$i];

                                    $tdata_cat['sub_cat'] = $sub_cat[$i];

                                    

                                    

//                                    $this->addfavcategory($tdata_cat);	

                                $sql = "UPDATE `tbl_scale_prof_cat` SET `prof_cat` = '".addslashes($prof_cat)."' , `sub_cat` = '".addslashes($sub_cat)."'  WHERE `scale_id` = '".$scale_id."'";

		                

                                  $STH = $DBH->prepare($sql); 

                                  $STH->execute();

                              

                            }



                    }

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

        

        public function updateInterpretationAddMore($interpretation,$comment,$id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$now = time();

		$interpretaionid = $this->getInterpretationnaebyid($interpretation);

		$upd_sql = "UPDATE `tbl_interpretation_add_more` SET `interpretation` = '".$interpretaionid."' , `comment` = '".addslashes($comment)."'  WHERE `interpretation_add_more_id` = '".$id."'";

		  $STH = $DBH->prepare($upd_sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

        

//       public function updateInterpretationAddMore($interpretaion,$comment,$id)

//	{

//		$my_DBH = new mysqlConnection();$DBH = $my_DBH->raw_handle();$DBH->beginTransaction();

//		$now = time();

//		$interpretaionid = $this->getInterpretationnaebyid($interpretaion);

//		$upd_sql = "UPDATE `tbl_interpretation_add_more` SET `interpretation` = '".$interpretaionid."' , `comment` = '".addslashes($comment)."'  WHERE `interpretation_add_more_id` = '".$id."'";

//		  $STH = $DBH->prepare($upd_sql);  $STH->execute();

//		return $this->result;

//	}

	 public function getInterpretationnaebyid($interpretaionname)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = '';

            

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_name` = '".$interpretaionname."' ";

              $STH = $DBH->prepare($sql);

              $STH->execute();

            if($STH->rowCount() > 0)

            {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $return = $row['bms_id'];

            }

            return $return;

	}

         public function getInterpretationIdbyName($interpretaionid)

	{

            $my_DBH = new mysqlConnection();

            $DBH = $my_DBH->raw_handle();

            $DBH->beginTransaction();

            $return = '';

            

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$interpretaionid."' ";

              $STH = $DBH->prepare($sql); 

              $STH->execute();

            if($STH->rowCount() > 0)

            {

                    $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $return = $row['bms_name'];

            }

            return $return;

	}

        public function updateScaleAddMore($from_scale,$to_scale,$label_of_scale,$id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$now = time();

		

		$upd_sql = "UPDATE `tbl_scale_add_more` SET `from_scale` = '".addslashes($from_scale)."' , `to_scale` = '".addslashes($to_scale)."' , `label_of_scale` = '".addslashes($label_of_scale)."'  WHERE `scaleid` = '".$id."'";

		  $STH = $DBH->prepare($upd_sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function deleteDailyMealOld($meal_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$del_sql1 = "DELETE FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."'"; 

		  $STH = $DBH->prepare($del_sql1); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

        public function deleteDailyMeal($id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$del_sql1 = "DELETE FROM `tbldailymealsfavcategory` WHERE `id` = '".$id."'"; 

		  $STH = $DBH->prepare($del_sql1); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

        

        public function deleteScale($id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$del_sql1 = "DELETE FROM `tbl_scale_add_more` WHERE `scaleid` = '".$id."'"; 

		  $STH = $DBH->prepare($del_sql1);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function chkNSRFoodConstituentExists($nid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tblnutrientstdreq` WHERE `nid` = '".$nid."'";

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getNSRId($nid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$nsr_id = 0;

		$sql = "SELECT * FROM `tblnutrientstdreq` WHERE `nid` = '".$nid."'";

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

			$nsr_id =$row['nsr_id'];

		}

		return $nsr_id;

	}

	

	public function getNSRDetails($nsr_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$sql = "SELECT * FROM `tblnutrientstdreq` WHERE `nsr_id` = '".$nsr_id."'";

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

			$nid = $row['nid'];

			$units = stripslashes($row['units']);

			$symbols = stripslashes($row['symbols']);

			$reference = stripslashes($row['reference']);

			$adults_general = stripslashes($row['adults_general']);

			$childern_general = stripslashes($row['childern_general']);

			$infants_0_6_months = stripslashes($row['infants_0_6_months']);

			$infants_6_12_months = stripslashes($row['infants_6_12_months']);

			$childern_1_3_years = stripslashes($row['childern_1_3_years']);

			$childern_4_8_years = stripslashes($row['childern_4_8_years']);

			$males_9_13_years = stripslashes($row['males_9_13_years']);

			$males_14_18_years = stripslashes($row['males_14_18_years']);

			$males_19_30_years = stripslashes($row['males_19_30_years']);

			$males_31_50_years = stripslashes($row['males_31_50_years']);

			$males_51_70_years = stripslashes($row['males_51_70_years']);

			$males_71_100_years = stripslashes($row['males_71_100_years']);

			$female_9_13_years = stripslashes($row['female_9_13_years']);

			$female_14_18_years = stripslashes($row['female_14_18_years']);

			$female_19_30_years = stripslashes($row['female_19_30_years']);

			$female_31_50_years = stripslashes($row['female_31_50_years']);

			$female_51_70_years = stripslashes($row['female_51_70_years']);

			$female_71_100_years = stripslashes($row['female_71_100_years']);

			$pregnant_women_14_18_years = stripslashes($row['pregnant_women_14_18_years']);

			$pregnant_women_19_30_years = stripslashes($row['pregnant_women_19_30_years']);

			$pregnant_women_31_50_years = stripslashes($row['pregnant_women_31_50_years']);

			$women_lactation_stage_14_18_years = stripslashes($row['women_lactation_stage_14_18_years']);

			$women_lactation_stage_19_30_years = stripslashes($row['women_lactation_stage_19_30_years']);

			$women_lactation_stage_31_50_years = stripslashes($row['women_lactation_stage_31_50_years']);

		}

		return array($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years);

	}

	

	public function updateNSR($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years,$nsr_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

	       $return=false;

		$upd_sql = "UPDATE `tblnutrientstdreq` SET nid = '".$nid."' , `units` = '".addslashes($units)."' , `symbols` = '".addslashes($symbols)."' , `reference` = '".addslashes($reference)."' , `adults_general` = '".addslashes($adults_general)."' , `childern_general` = '".addslashes($childern_general)."' , `infants_0_6_months` = '".addslashes($infants_0_6_months)."' , `infants_6_12_months` = '".addslashes($infants_6_12_months)."' , `childern_1_3_years` = '".addslashes($childern_1_3_years)."' , `childern_4_8_years` = '".addslashes($childern_4_8_years)."' , `males_9_13_years` = '".addslashes($males_9_13_years)."' , `males_14_18_years` = '".addslashes($males_14_18_years)."' , `males_19_30_years` = '".addslashes($males_19_30_years)."' , `males_31_50_years` = '".addslashes($males_31_50_years)."' , `males_51_70_years` = '".addslashes($males_51_70_years)."' , `males_71_100_years` = '".addslashes($males_71_100_years)."' , `female_9_13_years` = '".addslashes($female_9_13_years)."' , `female_14_18_years` = '".addslashes($female_14_18_years)."' , `female_19_30_years` = '".addslashes($female_19_30_years)."' , `female_31_50_years` = '".addslashes($female_31_50_years)."' , `female_51_70_years` = '".addslashes($female_51_70_years)."' , `female_71_100_years` = '".addslashes($female_71_100_years)."' , `pregnant_women_14_18_years` = '".addslashes($pregnant_women_14_18_years)."' , `pregnant_women_19_30_years` = '".addslashes($pregnant_women_19_30_years)."' , `pregnant_women_31_50_years` = '".addslashes($pregnant_women_31_50_years)."' , `women_lactation_stage_14_18_years` = '".addslashes($women_lactation_stage_14_18_years)."' , `women_lactation_stage_19_30_years` = '".addslashes($women_lactation_stage_19_30_years)."' , `women_lactation_stage_31_50_years` = '".addslashes($women_lactation_stage_31_50_years)."' WHERE `nsr_id` = '".$nsr_id."'";

		  $STH = $DBH->prepare($upd_sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function addNSR($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

				

		$sql = "INSERT INTO `tblnutrientstdreq` (`nid`,`units`,`symbols`,`reference`,`adults_general`,`childern_general`,`infants_0_6_months`,`infants_6_12_months`,`childern_1_3_years`,`childern_4_8_years`,`males_9_13_years`,`males_14_18_years`,`males_19_30_years`,`males_31_50_years`,`males_51_70_years`,`males_71_100_years`,`female_9_13_years`,`female_14_18_years`,`female_19_30_years`,`female_31_50_years`,`female_51_70_years`,`female_71_100_years`,`pregnant_women_14_18_years`,`pregnant_women_19_30_years`,`pregnant_women_31_50_years`,`women_lactation_stage_14_18_years`,`women_lactation_stage_19_30_years`,`women_lactation_stage_31_50_years`) VALUES ('".$nid."','".addslashes($units)."','".addslashes($symbols)."','".addslashes($reference)."','".addslashes($adults_general)."','".addslashes($childern_general)."','".addslashes($infants_0_6_months)."','".addslashes($infants_6_12_months)."','".addslashes($childern_1_3_years)."','".addslashes($childern_4_8_years)."','".addslashes($males_9_13_years)."','".addslashes($males_14_18_years)."','".addslashes($males_19_30_years)."','".addslashes($males_31_50_years)."','".addslashes($males_51_70_years)."','".addslashes($males_71_100_years)."','".addslashes($female_9_13_years)."','".addslashes($female_14_18_years)."','".addslashes($female_19_30_years)."','".addslashes($female_31_50_years)."','".addslashes($female_51_70_years)."','".addslashes($female_71_100_years)."','".addslashes($pregnant_women_14_18_years)."','".addslashes($pregnant_women_19_30_years)."','".addslashes($pregnant_women_31_50_years)."','".addslashes($women_lactation_stage_14_18_years)."','".addslashes($women_lactation_stage_19_30_years)."','".addslashes($women_lactation_stage_31_50_years)."')";

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getAllNSR($search)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '18';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		if($search == '')

		{

			$sql = "SELECT * FROM `tblnutrientstdreq` as tnsr LEFT JOIN `tblnutrients` as tn ON tnsr.nid = tn.nid ORDER BY tnsr.nsr_id ASC";

		}

		else

		{

			$sql = "SELECT * FROM `tblnutrientstdreq` as tnsr LEFT JOIN `tblnutrients` as tn ON tnsr.nid = tn.nid WHERE tn.food_constituent LIKE '%".$search."%' ORDER BY tnsr.nsr_id ASC";

		}	

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page = 50;

		$scroll = 5;

		$page = new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=nutrientstdreq");

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

				

			while( $row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				$output .= '<tr class="manage-row">';

				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td align="center">'.stripslashes($row['food_constituent']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['units']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['symbols']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['reference']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['adults_general']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['childern_general']).'</td>';

				$output .= '<td align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_nutrientstdreq&id='.$row['nsr_id'].'&page='.$page->page.'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr class="manage-row" height="20"><td colspan="8" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function chkNARFoodConstituentExists($nid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tblnutrientavgreq` WHERE `nid` = '".$nid."'";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getNARId($nid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$nar_id = 0;

		$sql = "SELECT * FROM `tblnutrientavgreq` WHERE `nid` = '".$nid."'";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

			$nar_id =$row['nar_id'];

		}

		return $nar_id;

	}

	

	public function getNARDetails($nar_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$sql = "SELECT * FROM `tblnutrientavgreq` WHERE `nar_id` = '".$nar_id."'";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

			$nid = $row['nid'];

			$units = stripslashes($row['units']);

			$symbols = stripslashes($row['symbols']);

			$reference = stripslashes($row['reference']);

			$adults_general = stripslashes($row['adults_general']);

			$childern_general = stripslashes($row['childern_general']);

			$infants_0_6_months = stripslashes($row['infants_0_6_months']);

			$infants_6_12_months = stripslashes($row['infants_6_12_months']);

			$childern_1_3_years = stripslashes($row['childern_1_3_years']);

			$childern_4_8_years = stripslashes($row['childern_4_8_years']);

			$males_9_13_years = stripslashes($row['males_9_13_years']);

			$males_14_18_years = stripslashes($row['males_14_18_years']);

			$males_19_30_years = stripslashes($row['males_19_30_years']);

			$males_31_50_years = stripslashes($row['males_31_50_years']);

			$males_51_70_years = stripslashes($row['males_51_70_years']);

			$males_71_100_years = stripslashes($row['males_71_100_years']);

			$female_9_13_years = stripslashes($row['female_9_13_years']);

			$female_14_18_years = stripslashes($row['female_14_18_years']);

			$female_19_30_years = stripslashes($row['female_19_30_years']);

			$female_31_50_years = stripslashes($row['female_31_50_years']);

			$female_51_70_years = stripslashes($row['female_51_70_years']);

			$female_71_100_years = stripslashes($row['female_71_100_years']);

			$pregnant_women_14_18_years = stripslashes($row['pregnant_women_14_18_years']);

			$pregnant_women_19_30_years = stripslashes($row['pregnant_women_19_30_years']);

			$pregnant_women_31_50_years = stripslashes($row['pregnant_women_31_50_years']);

			$women_lactation_stage_14_18_years = stripslashes($row['women_lactation_stage_14_18_years']);

			$women_lactation_stage_19_30_years = stripslashes($row['women_lactation_stage_19_30_years']);

			$women_lactation_stage_31_50_years = stripslashes($row['women_lactation_stage_31_50_years']);

		}

		return array($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years);

	}

	

	public function updateNAR($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years,$nar_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

	        $return=false;

		$upd_sql = "UPDATE `tblnutrientavgreq` SET nid = '".$nid."' , `units` = '".addslashes($units)."' , `symbols` = '".addslashes($symbols)."' , `reference` = '".addslashes($reference)."' , `adults_general` = '".addslashes($adults_general)."' , `childern_general` = '".addslashes($childern_general)."' , `infants_0_6_months` = '".addslashes($infants_0_6_months)."' , `infants_6_12_months` = '".addslashes($infants_6_12_months)."' , `childern_1_3_years` = '".addslashes($childern_1_3_years)."' , `childern_4_8_years` = '".addslashes($childern_4_8_years)."' , `males_9_13_years` = '".addslashes($males_9_13_years)."' , `males_14_18_years` = '".addslashes($males_14_18_years)."' , `males_19_30_years` = '".addslashes($males_19_30_years)."' , `males_31_50_years` = '".addslashes($males_31_50_years)."' , `males_51_70_years` = '".addslashes($males_51_70_years)."' , `males_71_100_years` = '".addslashes($males_71_100_years)."' , `female_9_13_years` = '".addslashes($female_9_13_years)."' , `female_14_18_years` = '".addslashes($female_14_18_years)."' , `female_19_30_years` = '".addslashes($female_19_30_years)."' , `female_31_50_years` = '".addslashes($female_31_50_years)."' , `female_51_70_years` = '".addslashes($female_51_70_years)."' , `female_71_100_years` = '".addslashes($female_71_100_years)."' , `pregnant_women_14_18_years` = '".addslashes($pregnant_women_14_18_years)."' , `pregnant_women_19_30_years` = '".addslashes($pregnant_women_19_30_years)."' , `pregnant_women_31_50_years` = '".addslashes($pregnant_women_31_50_years)."' , `women_lactation_stage_14_18_years` = '".addslashes($women_lactation_stage_14_18_years)."' , `women_lactation_stage_19_30_years` = '".addslashes($women_lactation_stage_19_30_years)."' , `women_lactation_stage_31_50_years` = '".addslashes($women_lactation_stage_31_50_years)."' WHERE `nar_id` = '".$nar_id."'";

		  $STH = $DBH->prepare($upd_sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function addNAR($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

				

		$sql = "INSERT INTO `tblnutrientavgreq` (`nid`,`units`,`symbols`,`reference`,`adults_general`,`childern_general`,`infants_0_6_months`,`infants_6_12_months`,`childern_1_3_years`,`childern_4_8_years`,`males_9_13_years`,`males_14_18_years`,`males_19_30_years`,`males_31_50_years`,`males_51_70_years`,`males_71_100_years`,`female_9_13_years`,`female_14_18_years`,`female_19_30_years`,`female_31_50_years`,`female_51_70_years`,`female_71_100_years`,`pregnant_women_14_18_years`,`pregnant_women_19_30_years`,`pregnant_women_31_50_years`,`women_lactation_stage_14_18_years`,`women_lactation_stage_19_30_years`,`women_lactation_stage_31_50_years`) VALUES ('".$nid."','".addslashes($units)."','".addslashes($symbols)."','".addslashes($reference)."','".addslashes($adults_general)."','".addslashes($childern_general)."','".addslashes($infants_0_6_months)."','".addslashes($infants_6_12_months)."','".addslashes($childern_1_3_years)."','".addslashes($childern_4_8_years)."','".addslashes($males_9_13_years)."','".addslashes($males_14_18_years)."','".addslashes($males_19_30_years)."','".addslashes($males_31_50_years)."','".addslashes($males_51_70_years)."','".addslashes($males_71_100_years)."','".addslashes($female_9_13_years)."','".addslashes($female_14_18_years)."','".addslashes($female_19_30_years)."','".addslashes($female_31_50_years)."','".addslashes($female_51_70_years)."','".addslashes($female_71_100_years)."','".addslashes($pregnant_women_14_18_years)."','".addslashes($pregnant_women_19_30_years)."','".addslashes($pregnant_women_31_50_years)."','".addslashes($women_lactation_stage_14_18_years)."','".addslashes($women_lactation_stage_19_30_years)."','".addslashes($women_lactation_stage_31_50_years)."')";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getAllNAR($search)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '21';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		if($search == '')

		{ 

			$sql = "SELECT * FROM `tblnutrientavgreq` as tnar LEFT JOIN `tblnutrients` as tn ON tnar.nid = tn.nid ORDER BY tnar.nar_id ASC";

		}

		else

		{

			$sql = "SELECT * FROM `tblnutrientavgreq` as tnar LEFT JOIN `tblnutrients` as tn ON tnar.nid = tn.nid WHERE `food_constituent` LIKE '%".$search."%' ORDER BY tnar.nar_id ASC";

		}	

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page = 50;

		$scroll = 5;

		$page = new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=nutrientavgreq");

	 	$STH2 = $DBH->prepare($page->get_limit_query($sql)); 

                $STH2->execute();

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

				

			while( $row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				$output .= '<tr class="manage-row">';

				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td align="center">'.stripslashes($row['food_constituent']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['units']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['symbols']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['reference']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['adults_general']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['childern_general']).'</td>';

				$output .= '<td align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_nutrientavgreq&id='.$row['nar_id'].'&page='.$page->page.'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr class="manage-row" height="20"><td colspan="8" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function chkNULFoodConstituentExists($nid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tblnutrientupperlimit` WHERE `nid` = '".$nid."'";

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getNULId($nid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$nul_id = 0;

		$sql = "SELECT * FROM `tblnutrientupperlimit` WHERE `nid` = '".$nid."'";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

			$nul_id =$row['nul_id'];

		}

		return $nul_id;

	}

	

	public function getNULDetails($nul_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$sql = "SELECT * FROM `tblnutrientupperlimit` WHERE `nul_id` = '".$nul_id."'";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

			$nid = $row['nid'];

			$units = stripslashes($row['units']);

			$symbols = stripslashes($row['symbols']);

			$reference = stripslashes($row['reference']);

			$adults_general = stripslashes($row['adults_general']);

			$childern_general = stripslashes($row['childern_general']);

			$infants_0_6_months = stripslashes($row['infants_0_6_months']);

			$infants_6_12_months = stripslashes($row['infants_6_12_months']);

			$childern_1_3_years = stripslashes($row['childern_1_3_years']);

			$childern_4_8_years = stripslashes($row['childern_4_8_years']);

			$males_9_13_years = stripslashes($row['males_9_13_years']);

			$males_14_18_years = stripslashes($row['males_14_18_years']);

			$males_19_30_years = stripslashes($row['males_19_30_years']);

			$males_31_50_years = stripslashes($row['males_31_50_years']);

			$males_51_70_years = stripslashes($row['males_51_70_years']);

			$males_71_100_years = stripslashes($row['males_71_100_years']);

			$female_9_13_years = stripslashes($row['female_9_13_years']);

			$female_14_18_years = stripslashes($row['female_14_18_years']);

			$female_19_30_years = stripslashes($row['female_19_30_years']);

			$female_31_50_years = stripslashes($row['female_31_50_years']);

			$female_51_70_years = stripslashes($row['female_51_70_years']);

			$female_71_100_years = stripslashes($row['female_71_100_years']);

			$pregnant_women_14_18_years = stripslashes($row['pregnant_women_14_18_years']);

			$pregnant_women_19_30_years = stripslashes($row['pregnant_women_19_30_years']);

			$pregnant_women_31_50_years = stripslashes($row['pregnant_women_31_50_years']);

			$women_lactation_stage_14_18_years = stripslashes($row['women_lactation_stage_14_18_years']);

			$women_lactation_stage_19_30_years = stripslashes($row['women_lactation_stage_19_30_years']);

			$women_lactation_stage_31_50_years = stripslashes($row['women_lactation_stage_31_50_years']);

		}

		return array($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years);

	}

	

	public function updateNUL($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years,$nul_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

	        $return=false;

		$upd_sql = "UPDATE `tblnutrientupperlimit` SET nid = '".$nid."' , `units` = '".addslashes($units)."' , `symbols` = '".addslashes($symbols)."' , `reference` = '".addslashes($reference)."' , `adults_general` = '".addslashes($adults_general)."' , `childern_general` = '".addslashes($childern_general)."' , `infants_0_6_months` = '".addslashes($infants_0_6_months)."' , `infants_6_12_months` = '".addslashes($infants_6_12_months)."' , `childern_1_3_years` = '".addslashes($childern_1_3_years)."' , `childern_4_8_years` = '".addslashes($childern_4_8_years)."' , `males_9_13_years` = '".addslashes($males_9_13_years)."' , `males_14_18_years` = '".addslashes($males_14_18_years)."' , `males_19_30_years` = '".addslashes($males_19_30_years)."' , `males_31_50_years` = '".addslashes($males_31_50_years)."' , `males_51_70_years` = '".addslashes($males_51_70_years)."' , `males_71_100_years` = '".addslashes($males_71_100_years)."' , `female_9_13_years` = '".addslashes($female_9_13_years)."' , `female_14_18_years` = '".addslashes($female_14_18_years)."' , `female_19_30_years` = '".addslashes($female_19_30_years)."' , `female_31_50_years` = '".addslashes($female_31_50_years)."' , `female_51_70_years` = '".addslashes($female_51_70_years)."' , `female_71_100_years` = '".addslashes($female_71_100_years)."' , `pregnant_women_14_18_years` = '".addslashes($pregnant_women_14_18_years)."' , `pregnant_women_19_30_years` = '".addslashes($pregnant_women_19_30_years)."' , `pregnant_women_31_50_years` = '".addslashes($pregnant_women_31_50_years)."' , `women_lactation_stage_14_18_years` = '".addslashes($women_lactation_stage_14_18_years)."' , `women_lactation_stage_19_30_years` = '".addslashes($women_lactation_stage_19_30_years)."' , `women_lactation_stage_31_50_years` = '".addslashes($women_lactation_stage_31_50_years)."' WHERE `nul_id` = '".$nul_id."'";

		  $STH = $DBH->prepare($upd_sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function addNUL($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

				

		$sql = "INSERT INTO `tblnutrientupperlimit` (`nid`,`units`,`symbols`,`reference`,`adults_general`,`childern_general`,`infants_0_6_months`,`infants_6_12_months`,`childern_1_3_years`,`childern_4_8_years`,`males_9_13_years`,`males_14_18_years`,`males_19_30_years`,`males_31_50_years`,`males_51_70_years`,`males_71_100_years`,`female_9_13_years`,`female_14_18_years`,`female_19_30_years`,`female_31_50_years`,`female_51_70_years`,`female_71_100_years`,`pregnant_women_14_18_years`,`pregnant_women_19_30_years`,`pregnant_women_31_50_years`,`women_lactation_stage_14_18_years`,`women_lactation_stage_19_30_years`,`women_lactation_stage_31_50_years`) VALUES ('".$nid."','".addslashes($units)."','".addslashes($symbols)."','".addslashes($reference)."','".addslashes($adults_general)."','".addslashes($childern_general)."','".addslashes($infants_0_6_months)."','".addslashes($infants_6_12_months)."','".addslashes($childern_1_3_years)."','".addslashes($childern_4_8_years)."','".addslashes($males_9_13_years)."','".addslashes($males_14_18_years)."','".addslashes($males_19_30_years)."','".addslashes($males_31_50_years)."','".addslashes($males_51_70_years)."','".addslashes($males_71_100_years)."','".addslashes($female_9_13_years)."','".addslashes($female_14_18_years)."','".addslashes($female_19_30_years)."','".addslashes($female_31_50_years)."','".addslashes($female_51_70_years)."','".addslashes($female_71_100_years)."','".addslashes($pregnant_women_14_18_years)."','".addslashes($pregnant_women_19_30_years)."','".addslashes($pregnant_women_31_50_years)."','".addslashes($women_lactation_stage_14_18_years)."','".addslashes($women_lactation_stage_19_30_years)."','".addslashes($women_lactation_stage_31_50_years)."')";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getAllNUL($search)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '24';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		if($search == '')

		{

			$sql = "SELECT * FROM `tblnutrientupperlimit` as tnul LEFT JOIN `tblnutrients` as tn ON tnul.nid = tn.nid ORDER BY tnul.nul_id ASC";

		}

		else

		{

			$sql = "SELECT * FROM `tblnutrientupperlimit` as tnul LEFT JOIN `tblnutrients` as tn ON tnul.nid = tn.nid WHERE tn.food_constituent LIKE '%".$search."%' ORDER BY tnul.nul_id ASC";

		}	

		  $STH = $DBH->prepare($sql);  

                  $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page = 50;

		$scroll = 5;

		$page = new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=nutrientuplim");

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

				

			while( $row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				$output .= '<tr class="manage-row">';

				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td align="center">'.stripslashes($row['food_constituent']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['units']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['symbols']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['reference']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['adults_general']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['childern_general']).'</td>';

				$output .= '<td align="center" nowrap="nowrap">';

						if($edit) {

				$output .= '<a href="index.php?mode=edit_nutrientuplim&id='.$row['nul_id'].'&page='.$page->page.'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$output .= '<tr class="manage-row" height="20"><td colspan="8" align="center">&nbsp;</td></tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="8" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

	

	public function chkFoodConstituentExists($food_constituent)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

		

		$sql = "SELECT * FROM `tblnutrients` WHERE `food_constituent` = '".addslashes($food_constituent)."'";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getNId($food_constituent)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$nid = 0;

		$sql = "SELECT * FROM `tblnutrients` WHERE `food_constituent` = '".addslashes($food_constituent)."'";

		  $STH = $DBH->prepare($sql);  $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

			$nid =$row['nid'];

		}

		return $nid;

	}

	

	public function getFoodConstituent($nid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$food_constituent = '';

		$sql = "SELECT * FROM `tblnutrients` WHERE `nid` = '".$nid."'";

		  $STH = $DBH->prepare($sql); 

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

			$food_constituent = stripslashes($row['food_constituent']);

		}

		return $food_constituent;

	}

	

	public function updateFoodConstituent($food_constituent,$nid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

				$return=false;

		$upd_sql = "UPDATE `tblnutrients` SET food_constituent = '".addslashes($food_constituent)."' WHERE `nid` = '".$nid."'";

		  $STH = $DBH->prepare($upd_sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function addFoodConstituent($food_constituent)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$return = false;

				

		$sql = "INSERT INTO `tblnutrients` (`food_constituent`) VALUES ('".addslashes($food_constituent)."')";

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getAllNutrients($search)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '15';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		if($search == '')

		{

			$sql = "SELECT * FROM `tblnutrients` ORDER BY nid ASC";

		}

		else

		{

			$sql = "SELECT * FROM `tblnutrients` WHERE food_constituent LIKE '%".$search."%' ORDER BY nid ASC";

		}	

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page = 50;

		$scroll = 5;

		$page = new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=nutrients");

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

				

			while( $row = $STH2->fetch(PDO::FETCH_ASSOC))

			{

				$output .= '<tr class="manage-row">';

				$output .= '<td align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td align="center">'.stripslashes($row['food_constituent']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['recommend']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['guideline']).'</td>';

				$output .= '<td align="center">'.stripslashes($row['benefits']).'</td>';

				$output .= '<td align="center" nowrap="nowrap">';

							if($edit) {

				$output .= '<a href="index.php?mode=edit_nutrients&id='.$row['nid'].'&page='.$page->page.'" ><img src = "images/edit.gif" border="0"></a>';

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

	

	public function getNutriDetails($nid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

						

		$sql = "SELECT * FROM `tblnutrients` WHERE `nid` = '".$nid."'";

		  $STH = $DBH->prepare($sql);

                  $STH->execute();

		if($STH->rowCount() > 0)

		{

			 $row = $STH->fetch(PDO::FETCH_ASSOC);

			$recommend = stripslashes($row['recommend']);

			$guideline = stripslashes($row['guideline']);

			$benefits = stripslashes($row['benefits']);

		}

		return array($recommend,$guideline,$benefits);

	}

	

	public function updateNutrients($recommend,$guideline,$benefits,$nid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

				$return=false;

		$upd_sql = "UPDATE `tblnutrients` SET recommend = '".addslashes($recommend)."' , guideline = '".addslashes($guideline)."' , benefits = '".addslashes($benefits)."' WHERE `nid` = '".$nid."'";

		  $STH = $DBH->prepare($upd_sql); 

                  $STH->execute();

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
	
	public function getDailyFilter(){
		
		$my_DBH = new mysqlConnection();
		$obj2 = new Contents();
		$DBH = $my_DBH->raw_handle();
		$DBH->beginTransaction();
		$data=array();
		
		$sql="SELECT * FROM `tbldailymeals` WHERE deleted=0";
		$STH = $DBH->query($sql);
		$allOptions = [
			'foodcode' => [],
			'foodtype' => [],
			'composition' => [],
			'content' => [],
			'UOM' => [],
			'modifiedby' => []
		];
		
		$dataReturn = $STH->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($dataReturn)){   
			foreach ($dataReturn as $row) {
				$returnName = $obj2->getModifiedData($row['meal_id']);
				if(!empty($returnName)){
					$allOptions['modifiedby'] = $returnName;
				}
				
				$allOptions['foodcode'][$row['meal_item']] = $row['meal_item'];
				$allOptions['foodtype'][$row['food_type']] = $row['food_type'];

				// $foods=$this->compositionInfo($row['meal_id']);
				// if(!empty($foods)){	
				// 	foreach ($foods as $key => $value) {
				// 		$allOptions['composition'][$row['meal_id']] = $this->getIdByMEASURESName($value['fav_cat_id']);
				// 		$allOptions['content'][$row['meal_id']] = $value['content'];
				// 		$allOptions['UOM'][$row['meal_id']] = $this->getIdByMEASURESName($value['uom']);
				// 	}
				// }
			}
		}
		
		
		
		return $allOptions;
	}

}

?>