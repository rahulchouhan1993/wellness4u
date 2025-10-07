<?php

include_once("class.paging.php");

include_once("class.admin.php");

class Autoresponders extends Admin

{

	public function GetAllEmailAutoresponders($email_action_id,$status)

	{

		 $my_DBH = new mysqlConnection();

		 $DBH = $my_DBH->raw_handle();               

		 $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '214';

		$delete_action_id = '215';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		if($email_action_id == '' || $email_action_id == '0')

		{

			$str_sql_email_action_id = "";

		}

		else

		{

			$str_sql_email_action_id = " AND TAR.email_action_id = '".$email_action_id."' ";

		}

		

		if($status == '')

		{

			$str_sql_status = "";

		}

		else

		{

			$str_sql_status = " AND TAR.email_ar_status = '".$status."' ";

		}

		

		

		$sql = "SELECT TAR.* , TEA.email_action_title FROM `tblautoresponders` AS TAR

					LEFT JOIN `tblemailactions` AS TEA ON TAR.email_action_id = TEA.email_action_id

					WHERE TAR.email_ar_deleted = '0' ".$str_sql_email_action_id." ".$str_sql_status." 

					ORDER BY TEA.email_action_title ASC , TAR.email_ar_add_date DESC ";

		$STH = $DBH->prepare($sql);

		$STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=email_autoresponders");

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

				if($row['email_ar_status'] == 1)

				{

					 $status = 'Active'; 

				}

				else

				{ 

					$status = 'Inactive';

				}

				

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($edit) 

				{

					$output .= '<a href="index.php?mode=edit_email_autoresponder&id='.$row['email_ar_id'].'" ><img src = "images/edit.gif" border="0"></a>';

				}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($delete) 

				{

					$output .= '<a href=\'javascript:fn_confirmdelete("Email","sql/delemail_autoresponder.php?id='.$row['email_ar_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

				}

				$output .= '</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['email_ar_id']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['email_action_title']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['email_ar_subject']).'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';

				$output .= '<td height="30" align="center">'.date('d/m/Y',strtotime($row['email_ar_add_date'])).'</td>';

				

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="7" align="center">NO RECORDS FOUND</td></tr>';

		}

		$page->get_page_nav();

		return $output;

	}

	

	public function GetAllSentBulkEmails($email_ar_id,$start_date,$end_date,$uid,$puid)

	{

		 $my_DBH = new mysqlConnection();

		 $DBH = $my_DBH->raw_handle(); 

		 $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		

		

		if($email_ar_id == '' || $email_ar_id == '0')

		{

			$str_sql_email_ar_id = "";

		}

		else

		{

			$str_sql_email_ar_id = " AND TBC.email_ar_id = '".$email_ar_id."' ";

		}

		

		if($start_date == '' && $end_date == '' )

		{

			$str_sql_date = "";

		}

		elseif($start_date == '' && $end_date != '' )

		{

			$str_sql_date = " AND DATE(TBC.bec_add_date) <= '".date('Y-m-d',strtotime($end_date))."' ";

		}

		elseif($start_date != '' && $end_date == '' )

		{

			$str_sql_date = " AND DATE(TBC.bec_add_date) >= '".date('Y-m-d',strtotime($start_date))."' ";

		}

		else

		{

			$str_sql_date = " AND DATE(TBC.bec_add_date) >= '".date('Y-m-d',strtotime($start_date))."' AND DATE(TBC.bec_add_date) <= '".date('Y-m-d',strtotime($end_date))."' ";

		}

		

		

		if($uid == '' && $puid == '' )

		{

			$str_sql_user = "";

		}

		elseif($uid == '' && $puid != '' )

		{

			$str_sql_user = " AND TBC.user_id = '".$puid."' AND TBC.reciever_user_type LIKE 'Adviser' ";

		}

		elseif($uid != '' && $puid == '' )

		{

			$str_sql_user = " AND TBC.user_id = '".$uid."' AND TBC.reciever_user_type LIKE 'User' ";

		}

		else

		{

			$str_sql_user = " AND ( (TBC.user_id = '".$uid."' AND TBC.reciever_user_type LIKE 'User') OR (TBC.user_id = '".$puid."' AND TBC.reciever_user_type LIKE 'Adviser') ) ";

		}

		

		$sql = "SELECT TBC.* , TAR.email_ar_subject FROM `tblbulkemailcampaigns` AS TBC LEFT JOIN `tblautoresponders` TAR ON TBC.email_ar_id = TAR.email_ar_id WHERE TBC.user_id > 0 ".$str_sql_email_ar_id." ".$str_sql_date." ".$str_sql_user." ORDER BY TBC.bec_add_date DESC ";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=view_sent_bulk_emails&email_ar_id=".$email_ar_id.'&start_date='.$start_date.'&end_date='.$end_date.'&uid='.$uid.'&puid='.$puid);

	 	//$result=$this->execute_query($page->get_limit_query($sql));

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

			while($row = $STH2->fetch(PDO::FETCH_ASSOC))

			{

				$obj2 = new Autoresponders();

				

				$reciever_user_id = $row['user_id'];

				if($row['reciever_user_type'] == 'Adviser')

				{

					 $reciever_user_type = 'Adviser'; 

				}

				else

				{ 

					$reciever_user_type = 'User'; 

				}

				list($reciever_email,$reciever_name,$reciever_unique_id) = $obj2->getUserSendingEmailDetails($reciever_user_id,$reciever_user_type);

				

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.$reciever_name.'</td>';

				$output .= '<td height="30" align="center">'.$reciever_email.'</td>';

				$output .= '<td height="30" align="center">'.$reciever_user_type.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['email_ar_subject']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['email_subject']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['email_body']).'</td>';

				$output .= '<td height="30" align="center">'.date('d/m/Y',strtotime($row['bec_add_date'])).'</td>';

				$output .= '</tr>';

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

	

	public function getEmailActionsOptions($email_action_id)

	{

		 $my_DBH = new mysqlConnection();

		 $DBH = $my_DBH->raw_handle();   

		 $DBH->beginTransaction();

		$option_str = '';		

		

		$sql = "SELECT * FROM `tblemailactions` WHERE `email_action_deleted` = '0' AND `email_action_status` = '1' ORDER BY `email_action_title` ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['email_action_id'] == $email_action_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['email_action_id'].'" '.$sel.'>'.stripslashes($row['email_action_title']).'</option>';

			}

		}

		return $option_str;

	}

	

	public function getBulkEmailCampaingOptions($email_ar_id)

	{

		 $my_DBH = new mysqlConnection();

		 $DBH = $my_DBH->raw_handle();   

		 $DBH->beginTransaction();

		$option_str = '';		

		

		$sql = "SELECT * FROM `tblautoresponders` WHERE `email_ar_deleted` = '0' AND `email_ar_status` = '1' AND `email_action_id` = '10' ORDER BY `email_ar_subject` ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['email_ar_id'] == $email_ar_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['email_ar_id'].'" '.$sel.'>'.stripslashes($row['email_ar_subject']).'</option>';

			}

		}

		return $option_str;

	}

	//update ample 10-07-20

	public function addEmailAutoresponder($email_action_id,$email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body,$SMS_ID)

	{

		 $my_DBH = new mysqlConnection();

                 $DBH = $my_DBH->raw_handle();  

                 $DBH->beginTransaction();

                 $return=false;

		$ins_sql = "INSERT INTO `tblautoresponders`(`email_action_id`,`email_ar_subject`,`email_ar_from_name`,`email_ar_from_email`,`email_ar_to_email`,`email_ar_body`,`email_ar_status`,SMS_ID) VALUES ('".addslashes($email_action_id)."','".addslashes($email_ar_subject)."','".addslashes($email_ar_from_name)."','".addslashes($email_ar_from_email)."','".addslashes($email_ar_to_email)."','".addslashes($email_ar_body)."','1',".$SMS_ID.")";

		//echo $ins_sql;

		//$this->execute_query($ins_sql);

		$STH = $DBH->prepare($ins_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getEmailAutoresponderDetails($email_ar_id)

	{

		 $my_DBH = new mysqlConnection();

		 $DBH = $my_DBH->raw_handle();    

		 $DBH->beginTransaction();

		

		$email_action_id = '';

		$email_ar_subject = '';

		$email_ar_from_name = '';

		$email_ar_from_email = '';

		$email_ar_to_email = '';

		$email_ar_body = '';

		$email_ar_status = '';

		

		$sql = "SELECT * FROM `tblautoresponders` WHERE `email_ar_id` = '".$email_ar_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$email_action_id = stripslashes($row['email_action_id']);

			$email_ar_subject = stripslashes($row['email_ar_subject']);

			$email_ar_from_name = stripslashes($row['email_ar_from_name']);

			$email_ar_from_email = stripslashes($row['email_ar_from_email']);

			$email_ar_to_email = stripslashes($row['email_ar_to_email']);

			$email_ar_body = stripslashes($row['email_ar_body']);

			$email_ar_status = stripslashes($row['email_ar_status']);

            $SMS_ID=stripslashes($row['SMS_ID']); //add by ample 10-07-20

		}

		return array($email_action_id,$email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body,$email_ar_status,$SMS_ID);

	

	}

	   //update ample 10-07-20

	public function updateEmailAutoresponder($email_ar_id,$email_action_id,$email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body,$email_ar_status,$SMS_ID)

	{

		 $my_DBH = new mysqlConnection();

		 $DBH = $my_DBH->raw_handle();   

		 $DBH->beginTransaction();

                 $return=false;

		$sql = "UPDATE `tblautoresponders` SET `email_action_id` = '".addslashes($email_action_id)."' ,`email_ar_subject` = '".addslashes($email_ar_subject)."' , `email_ar_from_name` = '".addslashes($email_ar_from_name)."' , `email_ar_from_email` = '".addslashes($email_ar_from_email)."', `email_ar_to_email` = '".addslashes($email_ar_to_email)."', `email_ar_body` = '".addslashes($email_ar_body)."' ,`email_ar_status` = '".addslashes($email_ar_status)."',`SMS_ID` = '".$SMS_ID."' WHERE `email_ar_id` = '".$email_ar_id."'";

	    //echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function DeleteEmailAutoresponder($email_ar_id)

	{

		 $my_DBH = new mysqlConnection();

		 $DBH = $my_DBH->raw_handle();    

		 $DBH->beginTransaction();

		$return=false;

		$sql = "UPDATE `tblautoresponders` SET `email_ar_deleted` = '1' WHERE `email_ar_id` = '".$email_ar_id."'";

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	

	public function getUserListTypeOptions($ult_id)

	{

		 $my_DBH = new mysqlConnection();

		 $DBH = $my_DBH->raw_handle();    

		 $DBH->beginTransaction();

		$option_str = '';		

		

		$sql = "SELECT * FROM `tbluserlisttype` WHERE `ult_deleted` = '0' AND `ult_status` = '1' ORDER BY `ult_name` ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['ult_id'] == $ult_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['ult_id'].'" '.$sel.'>'.stripslashes($row['ult_name']).'</option>';

			}

		}

		return $option_str;

	}

	

	public function getUserSendingEmailDetails($user_id,$reciever_user_type)

	{

		 $my_DBH = new mysqlConnection();

		 $DBH = $my_DBH->raw_handle();   

		 $DBH->beginTransaction();

		

		$reciever_email = '';

		$reciever_name = '';

		$reciever_unique_id = '';

		

		if($reciever_user_type == 'Adviser')

		{

			$sql = "SELECT * FROM `tblprofusers` WHERE `pro_user_id` = '".$user_id."'";

			$STH = $DBH->prepare($sql);

                        $STH->execute();

			if($STH->rowCount() > 0)

			{

				$row = $STH->fetch(PDO::FETCH_ASSOC);

				$reciever_email = stripslashes($row['email']);

				$reciever_name = stripslashes($row['name']);

				$reciever_unique_id = stripslashes($row['pro_unique_id']);

			}

		}

		else

		{

			$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";

			$STH = $DBH->prepare($sql);

                        $STH->execute();

			if($STH->rowCount() > 0)

			{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

				$reciever_email = stripslashes($row['email']);

				$reciever_name = stripslashes($row['name']);

				$reciever_unique_id = stripslashes($row['unique_id']);

			}

		}

		

		return array($reciever_email,$reciever_name,$reciever_unique_id);

	

	}

	

	public function addEmailCampaignDetails($ult_id,$country_id,$state_id,$city_id,$place_id,$up_id,$ap_id,$user_id,$reciever_name,$reciever_email,$email_ar_id,$email_from_name,$email_from_email,$email_subject,$email_body,$reciever_user_type)

	{

		 $my_DBH = new mysqlConnection();

		 $DBH = $my_DBH->raw_handle();    

		 $DBH->beginTransaction();

                 $return=false;

		$ins_sql = "INSERT INTO `tblbulkemailcampaigns`(`ult_id`,`user_id`,`reciever_name`,`reciever_email`,`reciever_user_type`,`country_id`,`state_id`,`city_id`,`place_id`,`up_id`,`ap_id`,`email_ar_id`,`email_from_name`,`email_from_email`,`email_subject`,`email_body`) VALUES ('".addslashes($ult_id)."','".addslashes($user_id)."','".addslashes($reciever_name)."','".addslashes($reciever_email)."','".addslashes($reciever_user_type)."','".addslashes($country_id)."','".addslashes($state_id)."','".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($up_id)."','".addslashes($ap_id)."','".addslashes($email_ar_id)."','".addslashes($email_from_name)."','".addslashes($email_from_email)."','".addslashes($email_subject)."','".addslashes($email_body)."')";

		//echo $ins_sql;

		//$this->execute_query($ins_sql);

		$STH = $DBH->prepare($ins_sql);

                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$return = true;

		}

		return $return;

	}

	 //add by ample 10-07-20
    public function get_SMS_SENDER_data($SMS_ID)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();   
        $DBH->beginTransaction();
        $option_str = '';       
        $sql = "SELECT * FROM `tbl_sms_credentials` WHERE `DELETED` = '0' AND `STATUS` = '1' ORDER BY `SMS_ID` ASC";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        { 
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {
                if($row['SMS_ID'] == $SMS_ID)
                {
                    $sel = ' selected ';
                }
                else
                {
                    $sel = '';
                }       
                $option_str .= '<option value="'.$row['SMS_ID'].'" '.$sel.'>'.stripslashes($row['SMS_SENDERID']).'</option>';
            }
        }
        return $option_str;
    }

}

?>