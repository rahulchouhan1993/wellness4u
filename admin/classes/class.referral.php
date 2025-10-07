<?php

include_once("class.paging.php");

include_once("class.admin.php");

class user_referral extends Admin

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

			while($row =$STH->fetch(PDO::FETCH_ASSOC))

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

	
	//added by ample
	public function refferal_common_user_data()
    {
        $DBH = new mysqlConnection();
        $data = array();        
        $sql = "SELECT DISTINCT ur.user_id,u.name,u.unique_id FROM `tblreferal` ur LEFT JOIN tblusers u ON ur.user_id=u.user_id ORDER BY u.name ASC";
        $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                 while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
            }
        return $data;
    }

    public function advice_refferal_common_user_data()
    {
        $DBH = new mysqlConnection();
        $data = array();        
        $sql = "SELECT DISTINCT ur.user_id,u.name,u.unique_id FROM `tbladviserreferrals` ur LEFT JOIN tblusers u ON ur.user_id=u.user_id WHERE ur.invite_by_user=1 ORDER BY u.name ASC";
        $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                 while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
            }
        return $data;
    }

    public function advice_refferal_common_vendor_data()
    {
        $DBH = new mysqlConnection();
        $data = array();        
        $sql = "SELECT DISTINCT ur.vendor_id,v.vendor_name,v.vendor_unique_id FROM `tbladviserreferrals` ur LEFT JOIN tblvendors v ON ur.vendor_id=v.vendor_id WHERE ur.invite_by_user=0 ORDER BY v.vendor_unique_id ASC";
        $STH = $DBH->query($sql);
            if ($STH->rowCount() > 0) {
                 while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
            }
        return $data;
    }

    //update by AMPLE 18-04-20
	public function GetAllUserReferal($user_id="",$start_date="",$end_date="",$status="")
	{

	    $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

			$admin_id = $_SESSION['admin_id'];
			// $reply_action_id = '111';
			// $delete_action_id = '112';
			// $reply = $this->chkValidActionPermission($admin_id,$reply_action_id);
			// $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

			$str_user="";$str_date="";$str_status="";

			if($user_id)
	        {
	            $str_user.=' WHERE ur.user_id='.$user_id;
	        }
	        if($status!=='')
	        {	
	        	if(empty($user_id))
	        	{
	        		$str_status.=' WHERE';
	        	}
	        	else
	        	{
	        		$str_status.=' AND';
	        	}
	            $str_status.=' ur.status='.$status;
	        }
	        if($start_date && $end_date)
	        {	
	        	if(empty($user_id) && $status=='')
	        	{
	        		$str_date.=' WHERE';
	        	}
	        	else
	        	{
	        		$str_date.=' AND';
	        	}
	            $str_date.=' ur.add_date between "'.date("Y-m-d", strtotime($start_date)).'"  AND "'.date('Y-m-d', strtotime('+1 day', strtotime($end_date))).'"';
	        }

			 $sql = "SELECT ur.*,u.name as user_name,u.unique_id FROM tblreferal ur LEFT JOIN tblusers u ON ur.user_id=u.user_id  ".$str_user." ".$str_status." ".$str_module." ".$str_date." ORDER BY ur.id DESC"; 

			$STH = $DBH->prepare($sql);
                   $STH->execute();

			$total_records=$STH->rowCount();
			$record_per_page=100;
			$scroll=5;
			$page=new Page(); 
			$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
			$page->set_link_parameter("Class = paging");
			$page->set_qry_string($str="mode=view_user_referal");
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
					
					$day = $row['add_date'];
					$time= strtotime($day);
					$time=$time+19800;
					$date = date('d-M-Y h:i A',$time);
					
					$output .= '<tr class="manage-row">';
					$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';
					$output .= '<td height="30" align="center">'.stripslashes($row['user_name']).' ('.$row['unique_id'].')</td>';
					$output .= '<td height="30" align="center">'.$row['name'].' ('.$row['email_id'].') </td>';
					$output .= '<td height="30" align="center">'.stripslashes($row['message']).'</td>';
					$output .= '<td height="30" align="center">'.$date.'</td>';
					$output .= '<td height="30" align="center">';
								if($row['status']==1)
								{
									$output .='Accept On';
									$output .='<br>'.$this->get_user_referral_accept_date($row['email_id'],$row['unique_id']);
								}
								else
								{
									$output .='Pending';
								}
					$output .='</td>';
					$output .= '</tr>';
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
	//update by AMPLE 18-04-20
	public function GetAllVendorReferal($user_id="",$vendor_id="",$start_date="",$end_date="",$request="",$referral="")
	{

	    $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

			$admin_id = $_SESSION['admin_id'];
			// $reply_action_id = '111';
			// $delete_action_id = '112';
			// $reply = $this->chkValidActionPermission($admin_id,$reply_action_id);
			// $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

			$str_user="";$str_date="";$str_vendor="";$str_request="";$str_referral="";

			if($user_id)
	        {
	            $str_user.=' WHERE ur.user_id='.$user_id;
	        }
	        if($vendor_id)
	        {	
	        	if(empty($user_id))
	        	{
	        		$str_vendor.=' WHERE';
	        	}
	        	else
	        	{
	        		$str_vendor.=' AND';
	        	}
	            $str_vendor.=' ur.vendor_id='.$vendor_id;
	        }
	        if($request!=='')
	        {	
	        	if(empty($user_id) && empty($vendor_id))
	        	{
	        		$str_request.=' WHERE';
	        	}
	        	else
	        	{
	        		$str_request.=' AND';
	        	}
	            $str_request.=' ur.request_status='.$request;
	        }
	        if($referral!=='')
	        {	
	        	if(empty($user_id) && empty($vendor_id) && $request=='')
	        	{
	        		$str_referral.=' WHERE';
	        	}
	        	else
	        	{	
	        		$str_referral.=' AND';
	        	}
	            $str_referral.=' ur.referral_status='.$referral;
	        }
	        if($start_date && $end_date)
	        {	
	        	if(empty($user_id) && empty($vendor_id) && $request=='' && $referral=='')
	        	{
	        		$str_date.=' WHERE';
	        	}
	        	else
	        	{
	        		$str_date.=' AND';
	        	}
	            $str_date.=' ur.request_sent_date between "'.date("Y-m-d", strtotime($start_date)).'"  AND "'.date('Y-m-d', strtotime('+1 day', strtotime($end_date))).'"';
	        }

			$sql = "SELECT ur.*,u.name,u.unique_id,v.vendor_name,v.vendor_unique_id FROM tbladviserreferrals ur LEFT JOIN tblusers u ON ur.user_id=u.user_id LEFT JOIN tblvendors v ON ur.vendor_id=v.vendor_id ".$str_user." ".$str_vendor." ".$str_module." ".$str_date." ".$str_request." ".$str_referral." ORDER BY ur.request_sent_date DESC"; 

			$STH = $DBH->prepare($sql);
                   $STH->execute();

			$total_records=$STH->rowCount();
			$record_per_page=100;
			$scroll=5;
			$page=new Page(); 
			$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
			$page->set_link_parameter("Class = paging");
			$page->set_qry_string($str="mode=view_vendor_referal");
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
					
					$day = $row['request_sent_date'];
					$time= strtotime($day);
					$time=$time+19800;
					$date = date('d-M-Y h:i A',$time);
					
					$output .= '<tr class="manage-row">';
					$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';
					$output .= '<td height="30" align="center">';
								if($row['invite_by_user']==1)
								{
									$output .=$row['name'].' (User)';
									$output .='<br><b>'.$row['unique_id'].'</b>';
								}
								else
								{
									$output .=$row['vendor_name'].' (vendor)';
									$output .='<br><b>'.$row['vendor_unique_id'].'</b>';
								}

					$output .='</td>';
					$output .= '<td height="30" align="center">'.$row['user_name'].' ('.$row['user_email'].') </td>';
					$output .= '<td height="30" align="center" style="max-width: 200px;">'.stripslashes($row['message']).'</td>';
					$output .= '<td height="30" align="center">'.$date.'</td>';
					$output .= '<td height="30" align="center">';
								if($row['request_status']==1)
								{
									$output .='Accepted on';
									$output .='<br>'.date("d-m-Y H:i", strtotime($row['request_accept_date']));
								}
								else
								{
									$output .='Pending';
								}
					$output .='</td>';
					$output .= '<td height="30" align="center">';
								if($row['referral_status']==1)
								{
									$output .='Accepted';
									$output .='<br>'.date("d-m-Y H:i", strtotime($row['referral_accept_date']));
								}
								else
								{
									$output .='Pending';
								}
					$output .='</td>';
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
	//add by ample 19-11-20
    function get_user_referral_accept_date($email_id,$ref_id="") {
        $DBH = new mysqlConnection();
        $data = array();
        $sql = "SELECT user_add_date FROM `tblusers` WHERE  `email` = '" . $email_id . "' AND `reference_id`='" . $ref_id . "' ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = date("d-m-Y H:i", strtotime($row['user_add_date']));
        }
        return $data;
    }
}

?>