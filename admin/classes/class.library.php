<?php

include_once("class.paging.php");

include_once("class.admin.php");

class Library extends Admin

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

	

	

	public function GetAllPages()

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		

		$arr_feedback_id = $this->GetAllFeedback();

		

		if(count($arr_feedback_id) > 0)

		{

		

			$str_feedback_id = implode(',',$arr_feedback_id);

		

			$admin_id = $_SESSION['admin_id'];

			$reply_action_id = '111';

			$delete_action_id = '112';

			

			$reply = $this->chkValidActionPermission($admin_id,$reply_action_id);

			

			$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

			$sql = "SELECT * FROM `tblfeedback` AS TA

					LEFT JOIN tblpages AS TS ON TA.page_id = TS.page_id

					LEFT JOIN tblusers AS TU ON TA.user_id = TU.user_id	

					WHERE `parent_feedback_id` = '0' AND `admin` = '0'

					ORDER BY feedback_add_date DESC";

			//echo $sql;			

			$STH = $DBH->prepare($sql);

                        $STH->execute();

			$total_records=$STH->rowCount();

			$record_per_page=100;

			$scroll=5;

			$page=new Page(); 

			$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

			$page->set_link_parameter("Class = paging");

			$page->set_qry_string($str="mode=feedback");

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

						

					if($row['page_name'] == '')

						{

							 $page_name = 'General'; 

						}

						else

						{ 

							$page_name = $row['page_name'];

						}

						

						$day = $row['feedback_add_date']; 

						

						//$date = date('d-M-Y h:i A',strtotime($day));

						$time= strtotime($day);

						$time=$time+19800;

						$date = date('d-M-Y h:i A',$time);

						

						

					$output .= '<tr class="manage-row">';

					$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

					$output .= '<td height="30" align="center"><a href="index.php?mode=view_conversation&uid='.$row['feedback_id'].'">'.stripslashes($row['name']).'</a></td>';

					$output .= '<td height="30" align="center">'.stripslashes($row['unique_id']).'</td>';

					$output .= '<td height="30" align="center">'.$page_name.'</td>';

					$output .= '<td height="30" align="center">'.stripslashes($row['feedback']).'</td>';

					$output .= '<td height="30" align="center">'.$date.'</td>';

					$output .= '<td height="30" align="center" nowrap="nowrap">';

							if($delete) {

					$output .= '<a href=\'javascript:fn_confirmdelete("Feedback","sql/delmainfeedback.php?uid='.$row['feedback_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

								}

					$output .= '</td>';

					$output .= '</tr>';

					$i++;

				}

			}

			else

			{

				$output = '<tr class="manage-row" height="20"><td colspan="7" align="center">NO RECORDS FOUND</td></tr>';

			}

			

			$page->get_page_nav();

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="7" align="center">NO RECORDS FOUND</td></tr>';

		}	

		return $output;

	}



	public function View_Library_details($user_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$arr_user_name = array();

		$arr_priority = array();

		$arr_note = array();

		$arr_title = array();

		$arr_file = array();

		$arr_type = array();

		$arr_category = array();

		$arr_library_id = array();

		$arr_status = array();

		$arr_date = array();    	

			//$sql = "SELECT * FROM `tbllibrary` 	WHERE `user_id` = '".$user_id."'  GROUP BY page_id";
			//change by ample 01-09-20
			if($user_id)
			{
				$sql = "SELECT l.*,u.name as user_name FROM `tblfavlibrary` l LEFT JOIN tblusers u ON l.user_id=u.user_id WHERE l.user_id = ".$user_id." AND data_type='Library' ORDER BY add_date DESC";
			}
			else
			{
				$sql = "SELECT l.*,u.name as user_name FROM `tblfavlibrary` l LEFT JOIN tblusers u ON l.user_id=u.user_id WHERE data_type='Library' ORDER BY add_date DESC";
			}

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

			{

			while($row = $STH->fetch(PDO::FETCH_ASSOC))

				{
						array_push($arr_user_name , stripslashes($row['user_name']));

						array_push($arr_priority , stripslashes($row['priority']));
						
						array_push($arr_category , stripslashes($row['category']));

						array_push($arr_library_id , stripslashes($row['library_id']));

						array_push($arr_note , stripslashes($row['note']));

						array_push($arr_file , stripslashes($row['file']));

						array_push($arr_title , stripslashes($row['title']));

						array_push($arr_type , stripslashes($row['type']));

						array_push($arr_status , stripslashes($row['status']));

						array_push($arr_date , stripslashes($row['add_date']));


				}

		}

		return array($arr_user_name,$arr_priority,$arr_library_id,$arr_category,$arr_note,$arr_file,$arr_title,$arr_type,$arr_status,$arr_date);

	

	}

	public function View_FavLibrary_details($user_id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$arr_user_name = array();

		$arr_priority = array();

		$arr_note = array();

		$arr_title = array();

		$arr_file = array();

		$arr_type = array();

		$arr_category = array();

		$arr_library_id = array();

		$arr_status = array();

		$arr_date = array();    	

			//$sql = "SELECT * FROM `tbllibrary` 	WHERE `user_id` = '".$user_id."'  GROUP BY page_id";
			//change by ample 01-09-20
			if($user_id)
			{
				$sql = "SELECT l.*,u.name as user_name FROM `tblfavlibrary` l LEFT JOIN tblusers u ON l.user_id=u.user_id WHERE l.user_id = ".$user_id." AND data_type='Favourite' ORDER BY add_date DESC";
			}
			else
			{
				$sql = "SELECT l.*,u.name as user_name FROM `tblfavlibrary` l LEFT JOIN tblusers u ON l.user_id=u.user_id WHERE data_type='Favourite' ORDER BY add_date DESC";
			}

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

			{

			while($row = $STH->fetch(PDO::FETCH_ASSOC))

				{
						array_push($arr_user_name , stripslashes($row['user_name']));

						array_push($arr_priority , stripslashes($row['priority']));
						
						array_push($arr_category , stripslashes($row['category']));

						array_push($arr_library_id , stripslashes($row['library_id']));

						array_push($arr_note , stripslashes($row['note']));

						array_push($arr_file , stripslashes($row['file']));

						array_push($arr_title , stripslashes($row['title']));

						array_push($arr_type , stripslashes($row['type']));

						array_push($arr_status , stripslashes($row['status']));

						array_push($arr_date , stripslashes($row['add_date']));


				}

		}

		return array($arr_user_name,$arr_priority,$arr_library_id,$arr_category,$arr_note,$arr_file,$arr_title,$arr_type,$arr_status,$arr_date);

	

	}

	



	public function Active_library($uid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$sql = "UPDATE `tblfavlibrary` SET status = '1' WHERE `id` = '".$uid."'";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}



	public function InActive_library($uid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$sql = "UPDATE `tblfavlibrary` SET status = '0' WHERE `id` = '".$uid."'";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}



public function GetAllFeedBackByID($id)

  {

  	$my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

	$arr_feedback_id  = array();

	$arr_feedback  = array();

	$arr_name  = array(); 

	$arr_feedback_add_date  = array();

	$arr_admin  = array();

	

	$sql = "SELECT * FROM `tblfeedback` WHERE  `feedback_id` IN (".$id.") ORDER BY `feedback_add_date` DESC";

	//echo "<br>Testkk GetAllFeedBackByID sql = ".$sql;			

	$STH = $DBH->prepare($sql);

        $STH->execute();

		

	if($STH->rowCount() > 0)

		{

		while($row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				array_push($arr_feedback_id , $row['feedback_id']);

				array_push($arr_feedback , $row['feedback']);

				array_push($arr_name , $row['name']);

				array_push($arr_feedback_add_date , $row['feedback_add_date']);

				array_push($arr_admin , $row['admin']);

				

			}

		}

	return array($arr_feedback_id,$arr_feedback,$arr_name,$arr_feedback_add_date,$arr_admin);

}



	

	

 public function getLatestFeedBackID($id)

  {

  	$my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

	

	$sql = "SELECT * FROM `tblfeedback` WHERE `parent_feedback_id` = '".$id."' AND `admin` = '0' ORDER BY `feedback_add_date` DESC";

   // echo"<br>Testkk: getLatestFeedBackID sql = ".$sql;

	$STH = $DBH->prepare($sql);

        $STH->execute();

		

	if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$id2 = stripslashes($row['feedback_id']);

			return $this->getLatestFeedBackID($id2);

		}

		else

		{

			return $id;

		}

	

  }



public function get_parent_id($id)

  {

  	$my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

	$parent_id = '0';

	$sql = "SELECT * FROM `tblfeedback` WHERE `feedback_id` = '".$id."' ORDER BY `feedback_add_date` DESC";

    

	$STH = $DBH->prepare($sql);

        $STH->execute();

		

	if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$parent_id = $row['parent_feedback_id'];

		}

		if($parent_id == 0)

			{

				$parent_id = $id;

			}

		

		

	return $parent_id;

  }

  





public function getLatestConvesationID($id)

  {

  	$my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

	

	$sql = "SELECT * FROM `tblfeedback` WHERE `feedback_id` = '".$id."' ORDER BY `feedback_add_date` DESC";

	//echo "<br>Testkk sql1111 ".$sql;

	$STH = $DBH->prepare($sql);

        $STH->execute();

		

	if($STH->rowCount() > 0)

	{	

		$row = $STH->fetch(PDO::FETCH_ASSOC);

		$parent_feedback_id = $row['parent_feedback_id'];

		if($parent_feedback_id > 0)

		{

			return $id.','.$this->getLatestConvesationID($parent_feedback_id);		

		}

		else

		{

			return $id;

		}	

	}

 }



public function GetAllConvarsation($id)

{

	$my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

	

		$sql = "SELECT * FROM `tblfeedback` WHERE `feedback_id` = '".$id."' ORDER BY `feedback_add_date` DESC";

			//echo "<br>Testkk sql = ".$sql;

			$STH = $DBH->prepare($sql);

                        $STH->execute();

		

			if($STH->rowCount() > 0)

				{	

					$row = $STH->fetch(PDO::FETCH_ASSOC);

					$parent_feedback_id = $row['parent_feedback_id'];

						

						$sql2 = "SELECT * FROM `tblfeedback` WHERE `parent_feedback_id` = '".$parent_feedback_id."' AND `parent_feedback_id` != '0' ORDER BY `feedback_add_date` DESC";

						

						//echo "<br>Testkk sql2 = ".$sql2;

						$STH2 = $DBH->prepare($sql2);

                                                 $STH2->execute();

		

						if($STH2->rowCount() > 0)

						{

							while($row2 = $STH->fetch(PDO::FETCH_ASSOC))

							{

								$feedback_id .= $row2['feedback_id'].',';

							}	

							

						}

				

				}

			

				

			$str_feedback_id = $feedback_id;

	//echo "<br>Testkk str_feedback_id22222222222 = ".$str_feedback_id;

	$str_feedback_id .= $this->getLatestConvesationID($id);

	//echo "<br>Testkk str_feedback_id = ".$str_feedback_id;

	return $str_feedback_id;

}



public function GetMainParantId($id)

{

	$my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

	

	$sql = "SELECT * FROM `tblfeedback` WHERE `feedback_id` = '".$id."' ORDER BY `feedback_add_date` DESC";

	$STH = $DBH->prepare($sql);

        $STH->execute();

	if($STH->rowCount() > 0)

	{	

		$row = $STH->fetch(PDO::FETCH_ASSOC);

		$parent_feedback_id = $row['parent_feedback_id'];

		if($parent_feedback_id == 0)

		{

			return $id;

		}

		else

		{

			return $this->GetMainParantId($parent_feedback_id);

		}

	}

	else

	{

		return 0;

	}

}



public function getRecursiveFeedbackId($main_parent_id,$return)

{

	

	        $my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

	$sql = "SELECT * FROM `tblfeedback` WHERE `parent_feedback_id` = '".$main_parent_id."' ";

	$STH = $DBH->prepare($sql);

        $STH->execute();

	if($STH->rowCount() > 0)

	{

		while($row = $STH->fetch(PDO::FETCH_ASSOC))

		{	

			$temp_feedback_id = $row['feedback_id'];

			if($return == '')

			{

				$return .= $obj1->getRecursiveFeedbackId($temp_feedback_id,$main_parent_id).',';

			}

			else

			{

				$return .= ','.$obj1->getRecursiveFeedbackId($temp_feedback_id,$main_parent_id);

			}	

		}

	}

	else

	{

		$return .= ','.$main_parent_id;

	}

	return $return;

}



public function GetAllConvarsationId($id)

{

	$main_parent_id = $this->GetMainParantId($id);

	$str_feedback_id = $this->getRecursiveFeedbackId($main_parent_id,$main_parent_id);

	return $str_feedback_id;

}







public function GetAllFeedback()

{

	$my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

	

	$arr_feedback_id  = array(); 

	$tmp_feedback_id  = array(); 

	$sql = "SELECT * FROM `tblfeedback` WHERE `admin` = '0' and `parent_feedback_id` = '0' ORDER BY `feedback_add_date` DESC";

	//echo "<br>GetAllFeedback sql = ".$sql;			

	        $STH = $DBH->prepare($sql);

                $STH->execute();

	if($STH->rowCount() > 0)

		{

		while($row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				array_push($tmp_feedback_id , $row['feedback_id']);

								

			}

			

		for($i=0;$i<count($tmp_feedback_id);$i++)

		{

			array_push($arr_feedback_id , $this->getLatestFeedBackID($tmp_feedback_id[$i]));	

		}	

	}

	return $arr_feedback_id;

}





	

public function Insert_admin_reply($feedback_id,$page_id,$user_id,$name,$email,$reply)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$ins_sql = "INSERT INTO `tblfeedback`(`parent_feedback_id`,`page_id`,`user_id`,`name`,`email`,`feedback`,`admin`) VALUES ('".addslashes($feedback_id)."','".addslashes($page_id)."','".addslashes($user_id)."','".addslashes($name)."','".addslashes($email)."','".addslashes($reply)."' ,'1' )";

		//echo "<br>Testkk ins_sql = ".$ins_sql;

		$STH = $DBH->prepare($ins_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	



public function getfeedback($id)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

		$page_name = '';

		$feedback = '';

		$status = '';

		$email = '';

	    $name = '';

		$page_id = '';

		$user_id = '';

				

		$sql = "SELECT * FROM `tblfeedback` AS TA

				LEFT JOIN tblpages AS TS ON TA.page_id = TS.page_id

				WHERE `feedback_id` = '".$id."'";

		//echo $sql;		

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			

			if($row['page_name'] == '')

					{

						 $page_name = 'General'; 

					}

					else

					{ 

						$page_name = $row['page_name'];

					}

			

			$page_name = $page_name;

			$feedback = stripslashes($row['feedback']);

			$status = stripslashes($row['status']);

			$email = stripslashes($row['email']);

			$name = stripslashes($row['name']);

			$page_id = stripslashes($row['page_id']);

			$user_id = stripslashes($row['user_id']);

		}

		return array($page_name,$feedback,$status,$email,$name,$page_id,$user_id);

	}



		

	public function DeleteMainfeedback($uid)

	{

		$str_feedback_id = $this->GetAllConvarsationId($uid);

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$sql = "DELETE  FROM `tblfeedback` WHERE `feedback_id` IN (".$str_feedback_id.") ";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function Deletefeedback($uid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$sql = "DELETE  FROM `tblfeedback` WHERE `feedback_id` = '".$uid."' OR `parent_feedback_id` = '".$uid."' ";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function Deletelibrarynote($uid)

	{

		$my_DBH = new mysqlConnection();

                $DBH = $my_DBH->raw_handle();

                $DBH->beginTransaction();

                $return=false;

		$sql = "UPDATE `tbllibrary` SET status = '0' WHERE `library_id` = '".$uid."'";

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