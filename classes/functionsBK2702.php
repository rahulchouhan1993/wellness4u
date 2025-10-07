<?php
class frontclass
{
  
    function __construct() 
    {
    }
 
public function debuglog($stringData)
    {
        $logFile = SITE_PATH."/logs/debuglog_commonfunctions_".date("Y-m-d").".txt";
        $fh = fopen($logFile, 'a');
        fwrite($fh, "\n\n----------------------------------------------------\nDEBUG_START - time: ".date("Y-m-d H:i:s")."\n".$stringData."\nDEBUG_END - time: ".date("Y-m-d H:i:s")."\n----------------------------------------------------\n\n");
        fclose($fh);	
    }    
    
public function getPageDetails($page_id)

{

	$DBH = new DatabaseHandler();
        $arr_record = array();        
        $sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
            {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                foreach($r as $key => $val)
                {
                    $arr_record[$key] = stripslashes($val);	
                }
            }	

        return $arr_record;

} 


public function isLoggedIn()

{

	$return = false;
	if( isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0) && ($_SESSION['user_id'] != '') )

	{
		$return = $this->chkValidUserId($_SESSION['user_id']);	
	}

	return $return;

}

public function chkValidUserId($user_id)

{

	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' AND `status` = '1'";

	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
            {
                $return = true;
            }

	return $return;

}

public function doUpdateOnline($user_id)

{

	$DBH = new DatabaseHandler();
	$now = time();
	$return = false;
	if($user_id > 0)

	{

		$sql = "UPDATE `tblusers` SET `online_timestamp` = '".$now."' WHERE `user_id` = '".$user_id."'";
		$STH = $DBH->query($sql);
		if($STH->rowCount() > 0)
                {
                    $return = true;
                }
                return $return;
	}	

	return $return;

}


public function chkValidLogin($email,$password)

{
	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "SELECT * FROM `tblusers` WHERE (`email` = '".$email."' || `mobile` = '".$email."') AND `password` = '".md5($password)."' AND `status` = '1' ";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
        {
            $return = true;
        }

	return $return;

}

public function doLogin($email)

{

	$return = false;
	$user_id = $this->getUserId($email);
	$name = $this->getUserFullNameById($user_id);
	$email = $this->getUserEmailById($user_id);
	if($user_id > 0)

	{
		$return = true;	
		$_SESSION['user_id'] = $user_id;
		$_SESSION['name'] = $name;
		$_SESSION['email'] = $email;
	}	
	return $return;

}

public function getUserId($email)

{

	$DBH = new DatabaseHandler();
	$user_id = 0;
	$sql = "SELECT * FROM `tblusers` WHERE (`email` = '".$email."' || `mobile` = '".$email."') AND `status` = '1'";

	$STH = $DBH->query($sql);

        if($STH->rowCount() > 0)
            {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $user_id = $r['user_id'];
            }
        
	return $user_id;

}

public function getUserFullNameById($user_id)

{

	$DBH = new DatabaseHandler();
	$name = '';
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";

	$STH = $DBH->query($sql);

         if($STH->rowCount() > 0)
            {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $name = stripslashes($r['name']);
            }
        
	return $name;

}
    
public function getUserEmailById($user_id)

{

	$DBH = new DatabaseHandler();
	$email = '';
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";

	$STH = $DBH->query($sql);

         if($STH->rowCount() > 0)
            {
                $r = $STH->fetch(PDO::FETCH_ASSOC);
                $email = $r['email'];
            }
        
	return $email;

}

public function addUsersSleepQuestionByGestVivek($user_id,$sleep_date,$selected_sleep_id_arr,$scale_arr,$remarks_arr,$my_target_arr,$adviser_target_arr,$sleep_set_id)

{

	$DBH = new DatabaseHandler();

	$return = false;

        if($sleep_set_id == '' || $sleep_set_id == '999999999')

        {

           $sleep_set_id = '0'; 

        }


	for($i=0;$i<count($selected_sleep_id_arr);$i++)

	{

		if($selected_sleep_id_arr[$i] > 0)

		{

			$sql = "INSERT INTO `tbluserssleep` (`user_id`,`sleep_date`,`selected_sleep_id`,`scale`,`remarks`,`my_target`,`adviser_target`,`sleep_set_id`) VALUES ('".$user_id."','".$sleep_date."','".$selected_sleep_id_arr[$i]."','".$scale_arr[$i]."','".$remarks_arr[$i]."','".$my_target_arr[$i]."','".$adviser_target_arr[$i]."','".$sleep_set_id."')";
			$STH = $DBH->query($sql);
                        
			if($STH->rowCount() > 0)
                        {
                           $return = true;
                        }

		}	

	}	

	return $return;

}

public function chkEmailExists($email)

{

	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."'";
	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)
        {
           $return = true;
        }

	return $return;

}

public function chkMobileExists($mobile)

{

	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "SELECT * FROM `tblusers` WHERE `mobile` = '".$mobile."'";
	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)
        {
           $return = true;
        }

	return $return;

}

public function chkValidPassword($password) 

{

	$r1='/[A-Z]/';  //Uppercase

	$r2='/[a-z]/';  //lowercase

	$r3='/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'

	$r4='/[0-9]/';  //numbers

	if(preg_match_all($r1,$password, $o)<1) return false;

	if(preg_match_all($r2,$password, $o)<1) return false;

	if(preg_match_all($r3,$password, $o)<1) return false;

	if(preg_match_all($r4,$password, $o)<1) return false;

	if(strlen($password)<6) return false;


	return true;

}

public function updatesSignUpUserVivek($user_id,$name,$middle_name,$last_name,$sex,$email,$mobile,$city_id,$place_id,$password,$otp)

{

	$DBH = new DatabaseHandler();
	$return = 0;
	$now = time();

                $addUsersSleepQuestion = $this->addUsersSleepQuestionByGestVivek($_SESSION['user_id'],$_SESSION['sleep_date'],$_SESSION['selected_sleep_id_arr'],$_SESSION['scale_arr'],$_SESSION['remarks_arr'],$_SESSION['my_target_arr'],$_SESSION['adviser_target_arr'],$_SESSION['pro_user_id']);
                       
                unset($_SESSION['sleep_date']);
                unset($_SESSION['selected_sleep_id_arr']);
                unset($_SESSION['scale_arr']);
                unset($_SESSION['remarks_arr']);
                unset($_SESSION['my_target_arr']);
                unset($_SESSION['adviser_target_arr']);
                unset($_SESSION['pro_user_id']);
                unset($_SESSION['gestid']);

		$unique_id = $this->genrateUserUniqueId($user_id);
                
		$sql = "UPDATE `tblusers` SET `unique_id` = '".$unique_id."',`name` = '".addslashes($name)."' ,`middle_name` = '".addslashes($middle_name)."' ,`last_name` = '".addslashes($last_name)."' , `email` = '".$email."' , `sex` = '".$sex."' , `mobile` = '".addslashes($mobile)."' , `city_id` = '".$city_id."', `place_id` = '".$place_id."' , `password` = '".md5($password)."',`status`='0',`user_add_date`='".$now."',food_chart='1',`my_activity_calories_chart`='1',`my_activity_calories_pi_chart`='1',`activity_analysis_chart`='1',`meal_chart`='1',`dpwd_chart`='1',`mwt_report`='1',`datewise_emotions_report`='1',`statementwise_emotions_report`='1',`statementwise_emotions_pi_report`='1',`angervent_intensity_report`='1',`stressbuster_intensity_report`='1',`each_meal_per_day_chart`='1',`user_otp`='".$otp."' WHERE `user_id` = '".$user_id."'";

		$STH = $DBH->query($sql);
                    if($STH->rowCount() > 0)
                    {
                       $return = true;
                    }

	

	return $return;

}

public function genrateUserUniqueId($user_id)

{

	$unique_id = '';

	

	$strlen_user_id = strlen($user_id);

	

	if($strlen_user_id == 1)

	{

		$unique_id = 'CW10000000'.$user_id;

	} 

	elseif($strlen_user_id == 2)

	{

		$unique_id = 'CW1000000'.$user_id;

	}

	elseif($strlen_user_id == 3)

	{

		$unique_id = 'CW100000'.$user_id;

	}

	elseif($strlen_user_id == 4)

	{

		$unique_id = 'CW10000'.$user_id;

	}

	elseif($strlen_user_id == 5)

	{

		$unique_id = 'CW1000'.$user_id;

	}

	elseif($strlen_user_id == 6)

	{

		$unique_id = 'CW100'.$user_id;

	}

	elseif($strlen_user_id == 7)

	{

		$unique_id = 'CW10'.$user_id;

	}

	else

	{

		$unique_id = 'CW1'.$user_id;

	}

	 

	return $unique_id;	

}


public function signUpUser($name,$middle_name,$last_name,$gender,$email,$mobile,$city_id,$place_id,$password,$otp)

{
	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$return = 0;
	$now = time();
        $default_plan = $this->GetDefaultUserPlan();
	$sql = "INSERT INTO `tblusers` (`name`,`middle_name`,`last_name`,`sex`,`email`,`password`,`mobile`,`city_id`,`place_id`,`status`,`user_add_date`,`user_otp`,`up_id`) "
                . "VALUES (:name,:middle_name,:last_name,:sex,:email,:password,:mobile,:city_id,:place_id,:status,:user_add_date,:user_otp,:up_id)";
	
       $STH = $DBH->prepare($sql);
       $STH->execute(array(
            ':name' => addslashes($name),
            ':middle_name' => addslashes($middle_name),
            ':last_name' => addslashes($last_name),
            ':sex' => addslashes($gender),
            ':email' => addslashes($email),
            ':password' => md5($password),
            ':mobile' => addslashes($mobile),
            ':city_id' => addslashes($city_id),
            ':place_id' => addslashes($place_id),
            ':status' => 0,
            ':user_add_date' => $now,
            ':user_otp' =>$otp,
            ':up_id' =>$default_plan
            ));
	 if($STH->rowCount() > 0)
	{
		$user_id = $DBH->lastInsertId();
		$unique_id = $this->genrateUserUniqueId($user_id);
		$sql2 = "UPDATE `tblusers` SET `unique_id` = '".$unique_id."' WHERE `user_id` = '".$user_id."'";
		$STH2 = $DBH->query($sql2);
                if($STH2->rowCount() > 0)

                {	
			$return = true;
		}

	}

	return $return;

}

public function GetDefaultUserPlan()
{
        $DBH = new DatabaseHandler();
        $plan_id = '';
	$sql = "SELECT * FROM `tbluserplans` WHERE `up_default` = 1 AND `up_status` = '1' ";
	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)
	{
		$r = $STH->fetch(PDO::FETCH_ASSOC);
                $plan_id = $r['up_id'];

	}

	return $plan_id;   
}


public function updatereferafriend($tdata,$email)
{	
	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "UPDATE `tblreferal` set `status` = '1' WHERE id = '".$tdata['id']."' AND `user_id` = '".$tdata['uid']."' AND `email_id` = '".$email."'";
	//die();
        $STH = $DBH->query($sql);
	if($STH->rowCount() > 0)

        {
		$return = true;
	}
	return $return;
	 
}

public function updateAdvisorsReferral($ar_id,$pro_user_id,$user_email)

{	
	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "UPDATE `tbladviserreferrals` SET `referral_accept_date` = NOW() , `referral_status` = '1' WHERE `ar_id` = '".$ar_id."' AND `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."'";
	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)

	{
		$return = true;
	}
	return $return;
}

public function getEmailAutoresponderDetails($email_action_id)

{
	$DBH = new DatabaseHandler();
        $data = array();
	$sql = "SELECT * FROM `tblautoresponders` WHERE `email_action_id` = '".$email_action_id."' AND `email_ar_status` = '1' AND `email_ar_deleted` = '0' ORDER BY `email_ar_add_date` DESC LIMIT 1 ";
	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)
	{
		$r = $STH->fetch(PDO::FETCH_ASSOC);
                $data = $r;

	}

	return $data;

}

public function getCityOptions()

{

	$DBH = new DatabaseHandler();
	$option_str = '';		
	$sql = "SELECT * FROM `tblcities` WHERE 1 ORDER BY `city` ASC";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{

		while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 

		{	
                        //<option value="Paris">Paris</option>
			$option_str .= '<option value="'.$row['city'].'" >'.stripslashes($row['city']).'</option>';

		}

	}

	return $option_str;

}

public function getPlaceOptions($city_id)

{
	$DBH = new DatabaseHandler();
	$option_str = '';		
	$sql = "SELECT * FROM `tblplaces` WHERE `city_id` = '".$city_id."' ORDER BY `place` ASC";
	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)
	{
            while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 
            {
                    $option_str .= '<option value="'.$row['place_id'].'" >'.stripslashes($row['place']).'</option>';
            }
	}
	return $option_str;

}


public function getCityIdbyName($city_name)

{
	$DBH = new DatabaseHandler();
	$city_id = 0;
	$sql = "SELECT * FROM `tblcities` WHERE `city` = '".$city_name."' ";
	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
                $city_id = $row['city_id']; 
	}
	return $city_id;

}

public function getAllActiveMenuItems($parent_id)

{

	$DBH = new DatabaseHandler();

	$arr_active_menu_items = array();

	

	$sql2 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$parent_id."' ORDER BY `menu_order` ASC ";

	//echo'<br><br>sql2 = '.$sql2;

	$STH = $DBH->query($sql2);

	if($STH->rowCount() > 0)
	{	

		while($row2 = $STH->fetch(PDO::FETCH_ASSOC))

		{

			$arr_active_menu_items[$row2['page_id']]['menu_details'] = $row2;

			$arr_active_menu_items[$row2['page_id']]['submenu_details'] = array();  

			

			$sql3 = "SELECT page_id , page_name , page_title , show_in_manage_menu , show_in_menu , link_enable , parent_menu , menu_order , menu_title , menu_link FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_menu` = '1' AND `parent_menu` = '".$row2['page_id']."'  ORDER BY `menu_order` ASC ";

			//echo'<br><br>sql3 = '.$sql3;

			//$result3 = mysql_query($sql3,$link);
                        $STH2 = $DBH->query($sql3);

			if($STH2->rowCount() > 0)
                       {	

				array_push($arr_active_menu_items[$row2['page_id']]['submenu_details'] , $this->getAllActiveMenuItems($row2['page_id'])); 

			}

		}

	}

	return $arr_active_menu_items;

}


public function GetTopBanner()

{
	$DBH = new DatabaseHandler();
	$banner = '';
	$position = '';
	$height = '';
	$width = '';
	$sql = "SELECT * FROM `tbltopbanner` ORDER BY RAND() limit 1";
	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$banner = stripslashes($row['banner']);
		$position = stripslashes($row['position']);
		$height = stripslashes($row['height']);
		$width = stripslashes($row['width']);
	}	

	return array($banner,$position,$height,$width);

}


public function getbanners($page_id,$side)

{

	$DBH = new DatabaseHandler();
	$arr_banner_id = array(); 
	$arr_page_id = array(); 
	$arr_page = array(); 
	$arr_position_id = array();
	$arr_banner = array();
	$arr_url  = array(); 
	$arr_banner_type = array(); 
	$arr_position = array(); 
	$arr_side = array();
	$arr_width = array();
	$arr_height = array();
	$arr_sequence_banner_id = array();

	 $sql = "SELECT * FROM `tblposition` WHERE `side` = '".($side)."' ORDER BY `position` ";

	//echo $sql;

	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)
	{

		while($row = $STH->fetch(PDO::FETCH_ASSOC))

		{
			$position_id = $row['position_id'];
			$max_banner_id =  $this->get_max_banner_id($position_id,$page_id);
			$min_banner_id = $this->get_min_banner_id($position_id,$page_id);

			
			if( ($_SESSION['ref_banner_id_'.$position_id.'_'.$page_id] == '' ) || ($_SESSION['ref_banner_id_'.$position_id.'_'.$page_id] == $max_banner_id))

			{

				$sql2 =  "SELECT * FROM `tblbanners` AS TA

						  LEFT JOIN `tblposition` AS TS ON TA.position_id = TS.position_id

						  WHERE TA.position_id = '".$position_id."' AND TA.page_id = '".$page_id."' AND TA.status = '1' ORDER BY  `banner_id` LIMIT 1";

			}

			else

			{	

				$sql2 =  "SELECT * FROM `tblbanners` AS TA

						  LEFT JOIN `tblposition` AS TS ON TA.position_id = TS.position_id

						  WHERE TA.position_id = '".$position_id."' AND TA.page_id = '".$page_id."' AND TA.status = '1'  AND TA.banner_id > '".$_SESSION['ref_banner_id_'.$position_id.'_'.$page_id]."' ORDER BY TA.banner_id LIMIT 1";

			}

			
			$STH2 = $DBH->query($sql2);

			if($STH2->rowCount() > 0)
                        {
				while($row2 = $STH2->fetch(PDO::FETCH_ASSOC))

				{
					$_SESSION['ref_banner_id_'.$position_id.'_'.$page_id] = $row2['banner_id'];
					array_push($arr_banner_id , $row2['banner_id']);
					array_push($arr_page_id , stripslashes($row2['page_id']));
					array_push($arr_page , stripslashes($row2['page']));
					array_push($arr_position_id , $row2['position_id']);
					array_push($arr_banner , stripslashes($row2['banner']));
					array_push($arr_url , stripslashes($row2['url']));
					array_push($arr_banner_type , stripslashes($row2['banner_type']));
					array_push($arr_position , $row2['position']);
					array_push($arr_side , stripslashes($row2['side']));
					array_push($arr_width , stripslashes($row2['width']));
					array_push($arr_height , $row2['height']);

				}

			}

		}	

	}

	return array($arr_banner_id,$arr_page_id,$arr_page,$arr_position_id,$arr_banner,$arr_url,$arr_banner_type,$arr_position,$arr_side,$arr_width,$arr_height);

}

public function get_max_banner_id($position_id,$page_id)

{

	$DBH = new DatabaseHandler();
	$max_banner_id = '';
	$sql = "SELECT * FROM `tblbanners` WHERE  `position_id` = '".$position_id."' AND `page_id` = '".$page_id."' AND status = '1' ORDER BY banner_id DESC limit 1";
	//echo $sql.'</br>';
	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$max_banner_id = $row['banner_id'];
	}
	return $max_banner_id;

}



public function get_min_banner_id($position_id,$page_id)

{

	$DBH = new DatabaseHandler();
	$min_banner_id = '';

	$sql = "SELECT * FROM `tblbanners` WHERE  `position_id` = '".$position_id."' AND `page_id` = '".$page_id."' AND status = '1' ORDER BY banner_id ASC limit 1";
	//echo $sql;

	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$min_banner_id = $row['banner_id'];
	}
	return $min_banner_id;

}


public function isLoggedInPro()
{
	
	$return = false;
	if( isset($_SESSION['pro_user_id']) && ($_SESSION['pro_user_id'] > 0) && ($_SESSION['pro_user_id'] != '') )
	{
		$return = $this->chkValidProUserId($_SESSION['pro_user_id']);	
	}
	return $return;
}

public function chkValidProUserId($pro_user_id)
{
	$DBH = new DatabaseHandler();
	$return = false;
	
	$sql = "SELECT * FROM `tbl_profusers` WHERE `pro_user_id` = '".$pro_user_id."' AND `status` = '1'";
	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)
	{
		$return = true;
	}
	return $return;
}

public function doLogout()

{

	$DBH = new DatabaseHandler();
	$return = true;	
	$sql = "UPDATE `tblusers` SET `online_timestamp` = '0' WHERE `user_id` = '".$_SESSION['user_id']."'";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{

		$return = true;	

		$_SESSION['user_id'] = '';

		$_SESSION['name'] = '';

		$_SESSION['email'] = '';

		unset($_SESSION['user_id']);

		unset($_SESSION['name']);

		unset($_SESSION['email']);

		session_destroy();

	}	

	return $return;

}

public function chkValidEmailID($email)

{
	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `status` = '1' ";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{

		$return = true;

	}

	return $return;

}

public function GetUserName($email)

{

	$DBH = new DatabaseHandler();
	$name = '';
	$sql = "select * from `tblusers` where email = '".$email."'";

	$STH = $DBH->query($sql);
	if($STH->rowCount() > 0)
	{

		$row = $STH->fetch(PDO::FETCH_ASSOC);

		$name = stripslashes($row['name']);

	}

	return $name;

}

public function chkIfScrollingWindowActivateForPage($page_id)

{

	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."' AND `show_in_manage_menu` = '1' AND `show_in_list` = '1' AND `adviser_panel` = '0' AND `vender_panel` = '0'";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{	

		$return = true;
	}
	return $return;

}


public function getScrollingWindowsCode($page_id)

{

	$DBH = new DatabaseHandler();
	$output = '';
	$user_id = $_SESSION['user_id'];

        $sql1 = "SELECT * FROM `tblscrollingwindows` WHERE FIND_IN_SET('".$page_id."', page_id) AND `sw_status` = '1' AND `sw_show_in_contents` = '0' ORDER BY `sw_order` ASC , `sw_add_date` DESC ";
        $STH = $DBH->query($sql1);

    if($STH->rowCount() > 0)
	{
        $return = true;
        $i = 1;
        while ($row1 = $STH->fetch(PDO::FETCH_ASSOC)) 

        {

            $sw_header = stripslashes($row1['sw_header']);
            $sw_header_hide = stripslashes($row1['sw_header_hide']);
            $sw_footer_hide = stripslashes($row1['sw_footer_hide']);
            $sw_header_font_family = stripslashes($row1['sw_header_font_family']);
            $sw_header_font_size = stripslashes($row1['sw_header_font_size']);
            $sw_header_font_color = stripslashes($row1['sw_header_font_color']);
            $sw_header_bg_color = stripslashes($row1['sw_header_bg_color']);
            if($sw_header_bg_color == '')
            {
                $sw_header_bg_color = '666666';
            }
            $sw_box_border_color = stripslashes($row1['sw_box_border_color']);
            if($sw_box_border_color == '')
            {
                $sw_box_border_color = '666666';
            }
            $header_style = '';
            if($sw_header_font_family != '')
            {
                $header_style = 'font-family:'.$sw_header_font_family.';';
            }
            if($sw_header_font_size != '')

            {
                $header_style .= 'font-size:'.$sw_header_font_size.'px;';

            }
            else
            {
                $header_style .= 'font-size:11px';
            }

            if($sw_header_font_color != '')
            {
                    $header_style .= 'color:#'.$sw_header_font_color.';';
            }

            if($row1['sw_show_header_credit'] == '1')

            {
                $sw_header = '<a href="'.stripslashes($row1['sw_header_credit_link']).'" target="_blank" style="color:#ffffff;'.$header_style.'">'.$sw_header.'</a>';			

            }

            if($row1['sw_header_image'] != '')
            {
                    $sw_header_image = '<img border="0" width="30" height="30" src="'.SITE_URL.'/uploads/'.stripslashes($row1['sw_header_image']).'">';
            }

            else

            {

                    $sw_header_image = '';

            }

            $sw_footer = stripslashes($row1['sw_footer']);
            $sw_footer_font_family = stripslashes($row1['sw_footer_font_family']);
            $sw_footer_font_size = stripslashes($row1['sw_footer_font_size']);
            $sw_footer_font_color = stripslashes($row1['sw_footer_font_color']);
            $sw_footer_bg_color = stripslashes($row1['sw_footer_bg_color']);
            if($sw_footer_bg_color == '')

            {
                $sw_footer_bg_color = '666666';
            }

            $footer_style = '';

            if($sw_footer_font_family != '')

            {
                    $footer_style = 'font-family:'.$sw_footer_font_family.';';

            }

            if($sw_footer_font_size != '')

            {

                    $footer_style .= 'font-size:'.$sw_footer_font_size.'px;';

            }
            else
            {

                    $footer_style .= 'font-size:11px';

            }



            if($sw_footer_font_color != '')

            {

                    $footer_style .= 'color:#'.$sw_footer_font_color.';';

            }

            

            if($row1['sw_show_footer_credit'] == '1')

            {

                    $sw_footer = '<a href="'.stripslashes($row1['sw_footer_credit_link']).'" target="_blank" style="color:#ffffff;'.$footer_style.'">'.$sw_footer.'</a>';			

            }



            if($row1['sw_footer_image'] != '')

            {

                    $sw_footer_image = '<img border="0" width="30" height="30" src="'.SITE_URL.'/uploads/'.stripslashes($row1['sw_footer_image']).'">';
            }

            else

            {

                    $sw_footer_image = '';

            }

            $today_day = date('j');
            $today_date = date('Y-m-d');

            $sql = "SELECT * FROM `tblscrollingcontents` WHERE ( (`sc_listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', sc_days_of_month) ) OR (`sc_listing_date_type` = 'single_date' AND `sc_single_date` = '".$today_date."') OR (`sc_listing_date_type` = 'date_range' AND `sc_start_date` <= '".$today_date."' AND `sc_end_date` >= '".$today_date."') ) AND ( `sw_id` = '".$row1['sw_id']."' ) AND ( `sc_status` = '1' ) ORDER BY `sc_order` ASC , `sc_add_date` DESC ";
            $STH2 = $DBH->query($sql);
           if($STH2->rowCount() > 0)
	
            {

                $output .= '<form name="frmScrollingWindows" id="frmScrollingWindows" action="#" method="post" >';
                $output .= '	<input type="hidden" name="hdnpage_id" id="hdnpage_id" value="'.$page_id.'">';
                $output .= '<table width="160" border="0" cellpadding="0" cellspacing="1" bgcolor="#'.$sw_box_border_color.'">';

                if($sw_header_hide == '0')

                {

                $output .= '	<tr>';

                $output .= '        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF">'; 

                $output .= '            <table width="160" border="0" cellpadding="0" cellspacing="0" bgcolor="#'.$sw_header_bg_color.'">';    

                $output .= '                <tr>';

                if($sw_header_image == '')

                {

                $output .= '                    <td width="160" bgcolor="#'.$sw_header_bg_color.'" height="30" align="center" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$header_style.'" >'.$sw_header.'</td>';

                }

                else

                {

                $output .= '                    <td width="125" bgcolor="#'.$sw_header_bg_color.'" height="30" align="left" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$header_style.'" >'.$sw_header.'</td>';

                $output .= '                    <td width="35" bgcolor="#'.$sw_header_bg_color.'" height="30" align="right" valign="middle" >'.$sw_header_image.'</td>';   

                }

                $output .= '                </tr>';

                $output .= '            </table>';    

                $output .= '        </td>';

                $output .= '	</tr>';

                }

                $output .= '	<tr>';

                $output .= '        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF" class="slider">';    

                

                $output .= '            <div style="" id="slider'.$i.'" >';



                $j = 0;

                while ($row = $STH2->fetch(PDO::FETCH_ASSOC)) 

                {

                    $sc_id = $row['sc_id'];
                    $sc_title = stripslashes($row['sc_title']);
                    $sc_title_font_family = stripslashes($row['sc_title_font_family']);
                    $sc_title_font_size = stripslashes($row['sc_title_font_size']);
                    $sc_content = $this->get_clean_br_string(stripslashes($row['sc_content']));
                    $sc_content_font_family = stripslashes($row['sc_content_font_family']);
                    $sc_content_font_size = stripslashes($row['sc_content_font_size']);
                    $sc_content_type = stripslashes($row['sc_content_type']);
                    $sc_title_font_color = stripslashes($row['sc_title_font_color']);
                    $sc_content_font_color = stripslashes($row['sc_content_font_color']);
                    $sc_title_hide = stripslashes($row['sc_title_hide']);
                    $sc_add_fav_hide = stripslashes($row['sc_add_fav_hide']);
                    $sc_credit_link = stripslashes($row['sc_credit_link']);
                    $sc_title_style = '';

                    if($sc_title_font_family != '')

                    {
                            $sc_title_style = 'font-family:'.$sc_title_font_family.';';

                    }

                    if($sc_title_font_size != '')

                    {
                            $sc_title_style .= 'font-size:'.$sc_title_font_size.'px;';

                    }

                    if($sc_title_font_color != '')
                    {
                            $sc_title_style .= 'color:#'.$sc_title_font_color.';';

                    }

                    $output .= '<div style="min-height:100px;">';
                    $output .= '<table width="150" border="0" cellspacing="0" cellpadding="0">';
                    if($sc_title_hide == '0')

                    {

                    $output .= '<tr>';

                    $output .= '<td height="30" colspan="2" align="center" valign="top" style="'.$sc_title_style.'" >';

                    if($sc_credit_link == '')

                    {

                        $output .= ''.$sc_title.'';

                    }

                    else

                    {

                        $output .= '<a href="'.$sc_credit_link.'" style="'.$sc_title_style.'" target="_blank">'.$sc_title.'</a>';

                    }

                    

                    $output .= '</td>';

                    $output .= '				</tr>';

                    }



                    if($sc_content_type == 'text')

                    {

                            $sc_content_style = '';

                            if($sc_content_font_family != '')

                            {

                                    $sc_content_style = 'font-family:'.$sc_content_font_family.';';

                            }



                            if($sc_content_font_size != '')

                            {

                                    $sc_content_style .= 'font-size:'.$sc_content_font_size.'px;';

                            }



                            if($sc_content_font_color != '')

                            {

                                    $sc_content_style .= 'color:#'.$sc_content_font_color.';';

                            }



                            $output .= '<tr>';

                            $output .= '<td colspan="2" height="60" align="left" valign="top" style="padding-left:3px;'.$sc_content_style.'">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$sc_content.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_content.'</a>';

                            }

                            $output .= '</td>';

                            $output .= '</tr>';



                    }

                    elseif($sc_content_type == 'text_and_image')

                    {

                            $sc_content_style = '';

                            if($sc_content_font_family != '')

                            {

                                    $sc_content_style = 'font-family:'.$sc_content_font_family.';';

                            }



                            if($sc_content_font_size != '')

                            {

                                    $sc_content_style .= 'font-size:'.$sc_content_font_size.'px;';

                            }



                            if($sc_content_font_color != '')

                            {

                                    $sc_content_style .= 'color:#'.$sc_content_font_color.';';

                            }



                            if($row['sc_image'] != '')

                            {

                                    $sc_image = '<img border="0" width="50" src="'.SITE_URL.'/uploads/'.stripslashes($row['sc_image']).'" />';

                            }

                            else

                            {

                                    $sc_image = '';	

                            }





                            $output .= '				<tr>';

                            $output .= '					<td width="60" height="60" align="left" valign="top">';

                            $output .= '						<table width="50" border="0" cellspacing="0" cellpadding="0">';

                            $output .= '							<tr>';

                            $output .= '								<td align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:10px;">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$sc_image.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_image.'</a>';

                            }

                            $output .= '</td>';

                            $output .= '							</tr>';

                            $output .= '						</table>';

                            $output .= '					</td>';

                            $output .= '					<td width="90" height="60" align="left" valign="top" style="padding-left:3px;'.$sc_content_style.'">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$sc_content.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_content.'</a>';

                            }

                            $output .= '</td>';

                            $output .= '				</tr>';	



                    }

                    elseif($sc_content_type == 'image')

                    {

                            if($row['sc_image'] != '')

                            {

                                    $sc_image = '<img border="0" width="150" src="'.SITE_URL.'/uploads/'.stripslashes($row['sc_image']).'" />';

                            }

                            else

                            {

                                    $sc_image = '';	

                            }



                            $output .= '				<tr>';

                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$sc_image.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_image.'</a>';

                            }

                            $output .= '</td>';

                            $output .= '				</tr>';	

                    }	

                    elseif($sc_content_type == 'video')

                    {

                            if($row['sc_video'] != '')

                            {

                                    $sc_video = '<iframe width="150" height="150" src="'.getBannerString($row['sc_video']).'" frameborder="0" allowfullscreen></iframe>';

                            }

                            else

                            {

                                    $sc_video = '';	

                            }



                            $output .= '				<tr>';

                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$sc_video.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_video.'</a>';

                            }

                            $output .= '       </td>';

                            $output .= '				</tr>';	

                    }	

                    elseif($sc_content_type == 'flash')

                    {

                            if($row['sc_flash'] != '')

                            {

                                    $sc_flash = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="100"><param name="movie" value="'.SITE_URL."/uploads/".$row['sc_flash'].'" /><param name="quality" value="high" /><embed src="'.SITE_URL."/uploads/".$row['sc_flash'].'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="100"></embed></object>';

                            }

                            else

                            {

                                    $sc_flash = '';	

                            }



                            $output .= '				<tr>';

                            $output .= '					<td colspan="2" height="60" align="left" valign="top">'.$sc_flash.'</td>';

                            $output .= '				</tr>';	

                    }	

                    elseif($sc_content_type == 'rss')

                    {

                            $rss_feed_item_id = $row['rss_feed_item_id'];

                            list($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json) = $this->getRssFeedItemDetails($rss_feed_item_id);



                            $output .= '				<tr>';

                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$rss_feed_item_title.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$rss_feed_item_title.'</a>';

                            }

                            $output .= '        </td>';

                            $output .= '				</tr>';	

                            $output .= '				<tr>';

                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$rss_feed_item_desc.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$rss_feed_item_desc.'</a>';

                            }

                            $output .= '        </td>';

                            $output .= '				</tr>';	

                    }	







                    if(stripslashes($row['sc_show_credit']) == '1')

                    {

                            if(stripslashes($row['sc_credit_name']) != '')

                            {

                                    $sc_show_credit = '1';

                                    $sc_credit_name = stripslashes($row['sc_credit_name']);

                                    if(stripslashes($row['sc_credit_link']) != '')

                                    {

                                            $sc_credit_link = stripslashes($row['sc_credit_link']);

                                    }

                                    else

                                    {

                                            $sc_credit_link = '';	

                                    }	

                            }

                            else

                            {

                                    $sc_show_credit = '0';	

                                    $sc_credit_name = '';	

                                    $sc_credit_link = '';	

                            }	

                    }	

                    else

                    {

                            $sc_show_credit = '0';	

                            $sc_credit_name = '';	

                            $sc_credit_link = '';	

                    }

                    

                    if($sc_add_fav_hide == '0')

                    { 

                    $output .= '<tr>
                     <td height="30" align="left" valign="middle" style="padding-left:2px;">';
                    if(!$this->chkIfOptionAlreadyAddedToFav($user_id,$page_id,$sc_id,'0'))
                    {								
                    $output .= '<input type="button" name="select_scrolloing_content_'.$i.'_'.$j.'" id="select_scrolloing_content_'.$i.'_'.$j.'" value="Add to Fav" onclick="addScrollingContentToFav(\''.$sc_id.'\')" style="width:60px;font-size:9px;">';

                    }

                    $output .= '</td>

												<td height="30" align="right" valign="middle">';

                    if($sc_show_credit == '1')

                    {

                    $output .= '<a href="'.$sc_credit_link.'" target="_blank">'.$sc_credit_name.'</a>';

                    }

                    $output .= '                    </td>

                                                                            </tr>';

                    }

                    else

                    {

                    

                    

                    

                        if($sc_show_credit == '1')

                        {

                            $output .= '				<tr>

                                        <td colspan="2" height="30" align="center" valign="middle" style="padding-left:2px;">';

                        $output .= '					<a href="'.$sc_credit_link.'" target="_blank">'.$sc_credit_name.'</a>';

                        $output .= '                    </td>

                                                                                </tr>';  

                        }

                      

                    }



                    $output .= '			</table>';



                    $output .= '</div>';





                    $j = $j+1;

                }

				

                $output .= '			</div>';





                $output .= '		</td>';

                $output .= '	</tr>';

                if($sw_footer_hide == '0')

                {

                $output .= '	<tr>';

                $output .= '        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF">'; 

                $output .= '            <table width="160" border="0" cellpadding="0" cellspacing="0" bgcolor="#'.$sw_footer_bg_color.'">';    

                $output .= '                <tr>';

                if($sw_footer_image == '')

                {

                $output .= '                    <td width="160" bgcolor="#'.$sw_footer_bg_color.'" height="30" align="center" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$footer_style.'" >'.$sw_footer.'</td>';

                }

                else

                {

                $output .= '                    <td width="125" bgcolor="#'.$sw_footer_bg_color.'" height="30" align="left" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$footer_style.'" >'.$sw_footer.'</td>';

                $output .= '                    <td width="35" bgcolor="#'.$sw_footer_bg_color.'" height="30" align="right" valign="middle" >'.$sw_footer_image.'</td>';    

                }

                $output .= '                </tr>';

                $output .= '            </table>';    

                $output .= '        </td>';

                $output .= '	</tr>';    

                

                }

                $output .= '</table>

                            <table width="160" border="0" cellspacing="0" cellpadding="0">

                                <tr>

                                    <td height="10"><img src="images/spacer.gif" width="1" height="1" /></td>

                                </tr>

                            </table>';

                $output .= '	</form>';

                //$output .= '</div>';

                $i = $i+1;

            }

        }

        //$output .= '</div>';

    }

	return $output;	

}

public function chkIfOptionAlreadyAddedToFav($user_id,$page_id,$sc_id,$ufs_type)

{

	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "SELECT * FROM `tblusersfavscrolling` WHERE `page_id` = '".$page_id."' AND `user_id` = '".$user_id."'  AND `sc_id` = '".$sc_id."' AND `ufs_type` = '".$ufs_type."' ";
        $STH = $DBH->query($sql);
	if( $STH->rowCount() > 0 )
	{	
		$return = true;
	}
	return $return;

}


public function get_clean_br_string($string)

{ 

	$output = '';
	$string = trim($string);
	if($string != '')

	{

		$pos = strpos($string, ' ');

		if($pos !== FALSE)

		{	

			$temp_arr = explode(' ',$string);
			foreach($temp_arr as $key => $val)
			{

				$temp_len = strlen($val);
				if($temp_len > 20)
				{

					$str = substr($val, 0, 10) . ' ' ;
					$temp_str2 =  substr($val, 10);
					if( strlen($temp_str2)> 10)
					{

						$temp_str2 = $this->get_clean_br_string($temp_str2);

					}

					$str .= $temp_str2;	
				}

				else
				{
					$str = $val;

				}

				$output .= $str. ' ';
			}
		}

		else

		{

			$temp_len = strlen($string);

			if($temp_len > 15)

			{

				$str = substr($string, 0, 15) . ' ' ;
				$temp_str2 =  substr($string, 15);
				if( strlen($temp_str2)> 15)

				{
					$temp_str2 = $this->get_clean_br_string($temp_str2);
				}

				$str .= $temp_str2;	

			}

			else

			{
				$str = $string;
			}
			$output .= $str. ' ';

		}		

	}	

	

	return $output;

}

public function getBannerString($banner)

{

	$search = 'v=';

	$pos = strpos($banner, $search);

	$str = strlen($banner);

	$rest = substr($banner, $pos+2, $str);

	//echo $rest;

	return 'http://www.youtube.com/embed/'.$rest;

}

public function reSendOTP($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblusers` SET 
					`user_otp` = :user_otp
					WHERE `mobile` = :mobile_no  ";
			$STH = $DBH->prepare($sql);
			$STH->execute(array(
				':user_otp' => addslashes($tdata['user_otp']),
				':mobile_no' => addslashes($tdata['mobile_no'])
			));
			$DBH->commit();
			
			$return = true;
		} catch (Exception $e) {
			
			return false;
		}	
		
        return $return;
    }
    
   public function getOTPSmsText($tdata)
    {
        $return = $tdata['user_otp']." is your otp";
        return $return;
    }
    
    public function sendSMS($tdata)
    {
        $return = false;
        
        $sendurl = SMS_URL."sendsms/sendsms.php?username=".SMS_USERNAME."&password=".SMS_PASSWORD."&type=TEXT&sender=".SMS_SENDERID."&mobile=".$tdata['mobile_no']."&message=".urlencode($tdata['sms_message']);
        $this->debuglogsms('[sendSMS] sendurl:'.$sendurl);
        try {
			
			$ch = curl_init($sendurl);
			curl_setopt($ch,CURLOPT_FRESH_CONNECT,TRUE);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
			curl_setopt($ch,CURLOPT_HEADER, 0);
			curl_setopt ($ch, CURLOPT_URL, $sendurl);
			curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);  
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			if ( ! $response = curl_exec($ch) )
			{
				$stringData = '[sendSMS] Error:'.curl_error($ch).' , sendurl:'.$sendurl.', response:'.$response;
				//$this->debuglogsms($stringData);
			}
			curl_close ($ch);
			
			
			//$response = file_get_contents($sendurl);		
			//$this->debuglogsms('[sendSMS] sendurl:'.$sendurl.', response:'.$response);
			return true;
		} catch (Exception $e) {
			$stringData = '[sendSMS] Catch Error:'.$e->getMessage().' , sendurl:'.$sendurl.', response:'.$response;
			//$this->debuglogsms($stringData);
            return $return;
        }
		
        return $return;
    }

   public function debuglogsms($stringData)
    {
        $logFile = SITE_PATH."/logs/debuglog_sms_".date("Y-m-d").".txt";
        $fh = fopen($logFile, 'a');
        fwrite($fh, "\n\n----------------------------------------------------\nDEBUG_START - time: ".date("Y-m-d H:i:s")."\n".$stringData."\nDEBUG_END - time: ".date("Y-m-d H:i:s")."\n----------------------------------------------------\n\n");
        fclose($fh);	
    } 
    
    public function chkMobileNoExists($mobile_no)
    {
        $DBH = new DatabaseHandler();
        $return = false;

		try {
			$sql = "SELECT * FROM `tblusers` WHERE `mobile` = '".$mobile_no."' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;
			}
		} catch (Exception $e) {
			
			return false;
		}	
        return $return;
    }
    
    public function doVerifyOTPForgotPassword($tdata)
    {
        $DBH = new DatabaseHandler();
        $return = false;
		try {
			$sql = "SELECT * FROM `tblusers` WHERE `mobile` = '".$tdata['mobile_no']."' AND `user_otp` = '".$tdata['user_otp']."' ";
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$return = true;
			}
		} catch (Exception $e) {
			return false;
		}	
        return $return;
    }
    
    public function resetUserPasswordByMobile($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        try {
			$sql = "UPDATE `tblusers` SET  
					`password` = :password,  
					`status` = :user_status  
					WHERE `mobile` = :mobile_no";
			$STH = $DBH->prepare($sql);
                        $STH->execute(array(
				':password' => md5($tdata['password']),
				':user_status' => '1',
				':mobile_no' => $tdata['mobile_no']
			));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			
            return false;
        }
        return $return;
    }
    
public function getBreadcrumbCode($page_id)

{

	
	$output = '';
	$str_page_id = $this->getBreadcrumbPages($page_id);
	$arr_page_id = explode(',',$str_page_id);

	if($page_id != '1')

	{

		array_push($arr_page_id , '1');

	}

	$arr_page_id = array_reverse($arr_page_id);

	for($i=0;$i<count($arr_page_id);$i++)

	{

		$page_data =  $this->getPageDetails($arr_page_id[$i]);

		

		if($page_data['link_enable'] == '1')

		{

			if($page_data['menu_link'] != '')

			{

				$page_data['menu_link'] = SITE_URL.'/'.$page_data['menu_link'];

			}

			else

			{

				$page_data['menu_link'] = '#';

			}		

		}

		else

		{

			$page_data['menu_link'] = '#';

		}

		

		if($arr_page_id[$i] == $page_id)

		{

			$output .= ' '.$page_data['menu_title'].'&gt;'; 

		}

		else

		{

			$output .= ' <a href="'.$page_data['menu_link'].'" target="_self" class="breadcrumb_link">'.$page_data['menu_title'].'</a> &gt;'; 

		}

	}

	

	$output = substr($output,0,-4);

	

	return $output;

}
  
public function getBreadcrumbPages($page_id)

{

	$str_page_id = '';
	$parent_id = $this->getParentPages($page_id);

	if($parent_id  == '0')

	{

		$str_page_id = $page_id;	

	}

	else

	{

		$str_page_id .= $page_id.','.$this->getBreadcrumbPages($parent_id);	

		

	}

	

	return $str_page_id;

}

public function getParentPages($page_id)

{

	$DBH = new DatabaseHandler();

	$parent_id = 0;

	

	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."' AND `show_in_manage_menu` = '1' ";

	//echo'<br><br>sql = '.$sql;

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {	

                $row = $STH->fetch(PDO::FETCH_ASSOC);
		$parent_id = $row['parent_menu'];

	}

	return $parent_id;

}


public function getWelcomeUserBoxCode($name,$user_id,$col='2',$show_custid ='')

{

	$DBH = new DatabaseHandler();
        if($col == '1')

        {

            $width = '80';

        }

        else

        {

            $width = '120';

        }

        

	$output = '';

	$output .= '            <table width="'.$width.'" border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">';

	$output .= '                <tr>';

	$output .= '                    <td >';

	$output .= '                        <table width="'.$width.'" border="0" cellspacing="0" cellpadding="0">';

	$output .= '                            <tr>';

	if($show_custid == '1')

        {

        $output .= '                                <td >Welcome '.$name.'</td>';    

        $output .= '                                <td >Cust Id: '.$this->getUserUniqueId($user_id).'</td>';

	}

        else

        {

        $output .= '                                <td >Welcome '.$name.'</td>';    

        }

        $output .= '				</tr>';

	$output .= '                        </table>';

	$output .= '			</td>';

	$output .= '                </tr>';

	$output .= '		</table>';

	return $output;	

}


public function getUserUniqueId($user_id)

{

	$DBH = new DatabaseHandler();
	$unique_id = '';

	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

		$row = $STH->fetch(PDO::FETCH_ASSOC);

		$unique_id = stripslashes($row['unique_id']);

	}

	return $unique_id;

}

public function getPageTitle($page_id)

{
	$DBH = new DatabaseHandler();
	$page_title = '';
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$page_title = stripslashes($row['page_title']);

	}
	return $page_title;

}

function getPageContents($page_id)

{

	$DBH = new DatabaseHandler();
	$page_contents = '';
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$temp = stripslashes($row['page_contents']);
		$temp = str_replace('&nbsp;',' ',$temp);
		$page_contents = html_entity_decode ($temp);
	}

	return $page_contents;

}


public function getTheamOptions($theam_id,$day_month_year)

{

	$DBH = new DatabaseHandler();
	$option_str = '';		
	$arr_days = array();
        
        $single_date = date("Y-m-d",strtotime($day_month_year));
        //echo '<br>';
        $all = date("d",strtotime($day_month_year));
        //echo '<br>';
        $month_wise = date("m",strtotime($day_month_year));
        //echo '<br>';
        $days_of_week = date('w', strtotime($day_month_year));
        
        
	$sql = "SELECT * FROM `tbltheams` WHERE status = '1' ORDER BY `theam_name` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

		while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

		{
                    
                            if($row['listing_date_type'] == 'single_date')
                             {

                                if($single_date == $row['single_date']) 
                                {
                                    if($row['theam_id'] == $theam_id)
                                    {
                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		

                                    $option_str .= '<option value="'.$row['theam_id'].'" '.$sel.'>'.stripslashes($row['theam_name']).'</option>';
                                }

                             }
                             elseif($row['listing_date_type'] == 'all')
                             {
                                $all_arr = explode(',', $row['days_of_month']);
                                if(in_array($all, $all_arr))
                                {
                                    if($row['theam_id'] == $theam_id)
                                    {
                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		

                                    $option_str .= '<option value="'.$row['theam_id'].'" '.$sel.'>'.stripslashes($row['theam_name']).'</option>';
                                } 
                             }
                             elseif($row['listing_date_type'] == 'days_of_month')
                             {
                                $all_arr = explode(',', $row['days_of_month']);
                                if(in_array($all, $all_arr))
                                {
                                    if($row['theam_id'] == $theam_id)
                                    {
                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		

                                    $option_str .= '<option value="'.$row['theam_id'].'" '.$sel.'>'.stripslashes($row['theam_name']).'</option>';
                                }  
                             }
                             elseif($row['listing_date_type'] == 'date_range')
                             {
                               if(($row['start_date'] >=$single_date) && ($single_date<= $row['end_date']) ) 
                                {
                                    if($row['theam_id'] == $theam_id)
                                    {
                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		

                                    $option_str .= '<option value="'.$row['theam_id'].'" '.$sel.'>'.stripslashes($row['theam_name']).'</option>';
                                }  
                             }
                             elseif($row['listing_date_type'] == 'month_wise')
                             {
                                $all_arr = explode(',', $row['months']);
                                if(in_array($month_wise, $all_arr))
                                {
                                    if($row['theam_id'] == $theam_id)
                                    {
                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		

                                    $option_str .= '<option value="'.$row['theam_id'].'" '.$sel.'>'.stripslashes($row['theam_name']).'</option>';
                                }    
                             }
                             elseif($row['listing_date_type'] == 'days_of_week')
                             {
                                $all_arr = explode(',', $row['days_of_week']);
                                if(in_array($days_of_week, $all_arr))
                                {
                                    if($row['theam_id'] == $theam_id)
                                    {
                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		

                                    $option_str .= '<option value="'.$row['theam_id'].'" '.$sel.'>'.stripslashes($row['theam_name']).'</option>';
                                }    
                             }
                    
			
		}
	}
	return $option_str;

}

public function getTheamDetailsMDT($theam_id)

{

    $DBH = new DatabaseHandler();
    $color_code = '#339900'; 
    $image = '';
    $sql = "SELECT * FROM `tbltheams` WHERE theam_id = '".$theam_id."' ORDER BY `theam_name` ASC";

    //echo $sql;

    $STH = $DBH->query($sql);
    if( $STH->rowCount() > 0 )
    {

        $row = $STH->fetch(PDO::FETCH_ASSOC);

        $image = SITE_URL."/uploads/".stripslashes($row['image']);

        $color_code = "#".stripslashes($row['color_code']);

    }	

    return array($image,$color_code);

}

public function GETDATADROPDOWNMYDAYTODAY($healcareandwellbeing,$page_name)
{
        $DBH = new DatabaseHandler();
	$arr_data = array();
	$sql = "SELECT * FROM `tbl_data_dropdown` WHERE page_name = '".$page_name."' and `healcareandwellbeing` = '".$healcareandwellbeing."' and `is_deleted` = 0 ORDER BY `order_show` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

		while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

		{
			$arr_data[] = $row;
		}
	}
	return $arr_data;
}

public function GetDatadropdownoption($symtum_cat)
{
        $symtum_cat = implode(',', $symtum_cat);
        $DBH = new DatabaseHandler();
	$option_str = '';
	$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE bms_id IN($symtum_cat) ORDER BY `bms_name` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {			
                $option_str .= '<option value="'.$row['bms_name'].'" >'.stripslashes($row['bms_name']).'</option>';

            }
	}
	return $option_str;  
}


public function getMyDayTodayIcon($icon_id)
{
        $DBH = new DatabaseHandler();
	$icon = '';
	$sql = "SELECT * FROM `tbl_icons` WHERE icons_front_id = '".$icon_id."' and `status` = 1 ";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $icon = $row['image'];
	}
	return $icon;  
}


public function getMyDayTodayIconComment($icon_id,$day_month_year)
{
        $DBH = new DatabaseHandler();
	$sql = "SELECT * FROM `tbl_icons` WHERE icons_front_id = '".$icon_id."' and `status` = 1 ";
	$STH = $DBH->query($sql);
        $data = array();
        
        $single_date = date("Y-m-d",strtotime($day_month_year));
        $all = date("d",strtotime($day_month_year));
        $month_wise = date("m",strtotime($day_month_year));
        $days_of_week = date('D', strtotime($day_month_year));
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {
              //$data =  $row;
                
//              echo '<pre>';
//              print($row);
//              echo '</pre>';
                
              if($row['listing_date_type'] == 'single_date')
              {
                 
                 if($single_date == $row['single_date']) 
                 {
                     return $row;
                 }
                  
              }
              
              elseif($row['listing_date_type'] == 'all')
              {
                 $all_arr = explode(',', $row['days_of_month']);
                 if(in_array($all, $all_arr))
                 {
                     return $row;
                 } 
              }
              
              elseif($row['listing_date_type'] == 'days_of_month')
              {
                 $all_arr = explode(',', $row['days_of_month']);
                 if(in_array($all, $all_arr))
                 {
                     return $row;
                 }  
              }
              
              elseif($row['listing_date_type'] == 'date_range')
              {
                if(($row['start_date'] >=$single_date) && ($single_date<= $row['end_date']) ) 
                 {
                     return $row;
                 }  
              }
              
              elseif($row['listing_date_type'] == 'month_wise')
              {
                $all_arr = explode(',', $row['months']);
                 if(in_array($month_wise, $all_arr))
                 {
                     return $row;
                 }    
              }
              
              elseif($row['listing_date_type'] == 'days_of_week')
              {
                $all_arr = explode(',', $row['months']);
                 if(in_array($days_of_week, $all_arr))
                 {
                     return $row;
                 }    
              }
              
            }
           // $row = $STH->fetch(PDO::FETCH_ASSOC);
            
	}
	return $data;  
}


public function getAllMainSymptomsRamakantFront($symtum_cat)
    {       
        $DBH = new DatabaseHandler();
        $symtum_cat = implode($symtum_cat, '\',\'');
        $str_sql_search = " AND `fav_parent_cat` IN ('".$symtum_cat."') ";
        $data = array();
        $sql = "SELECT DISTINCT bmsid FROM `tblsymtumscustomcategory` WHERE  symtum_deleted = '0' ".$str_sql_search." ORDER BY bmsid DESC ";		
        
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {           
                $data[] = $row['bmsid'];
            }
	}
	return $data;  
        
    }
    
public function getTimeOptionsNew($start_time,$end_time,$time)

{

	if($end_time == $start_time)

	{

		

	}

	elseif($end_time < $start_time)

	{

		$end_time = 24 + $end_time;

		$start = $start_time *60 + 0;

		$end = $end_time * 60+0;

		

		$i = $start;

		while($i<$end)

		{

			$minute = $i % 60;

			$hour = ($i - $minute)/60;

			

			if($hour > 23)

			{

				$hour = $hour - 24;

			}

			

			

			if( ($hour >= 0) && ($hour < 12)  )

			{

				$str = 'AM';

			}

			else

			{

				$str = 'PM';

			} 

					

			$val = sprintf('%02d:%02d', $hour, $minute);

			

			$val = $val.' '.$str;

			if($time == $val)

			{

				$selected = ' selected ';

			}

			else

			{

				$selected = '';

			}

			$option_str .= '<option value="'.$val.'" '.$selected.' >'.$val.'</option>';

			$i = $i + 15;

		} 

	}

	else

	{

		$start = $start_time *60 + 0;

		$end = $end_time * 60+0;

		

		for($i = $start; $i<$end; $i += 15)

		{

			

			$minute = $i % 60;

			$hour = ($i - $minute)/60;

			

			

			if( ($hour >=24) && ($hour <= 36) )

			{

				$hour = $hour - 24;

			}

			

			

			if( ($hour >= 0) && ($hour < 12)  )

			{

				$str = 'AM';

			}

			else

			{

				$str = 'PM';

			} 

					

			$val = sprintf('%02d:%02d', $hour, $minute);

			

			$val = $val.' '.$str;

			if($time == $val)

			{

				$selected = ' selected ';

			}

			else

			{

				$selected = '';

			}

			$option_str .= '<option value="'.$val.'" '.$selected.' >'.$val.'</option>';

		} 

	}	

	return $option_str;

}


public function getFavCategoryRamakant($fav_cat_type_id,$fav_cat_id)
	{
            $DBH = new DatabaseHandler();
            $option_str = '';		
            
            $fav_cat_type_id = explode(',', $fav_cat_type_id);
            $fav_cat_type_id = implode('\',\'', $fav_cat_type_id);
            
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('".$fav_cat_type_id."') and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
            //echo $sql;
            $STH = $DBH->query($sql);
            if( $STH->rowCount() > 0 )
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
        
 
public function getScrollingBarCode($page_id)

{

	$DBH = new DatabaseHandler();
	$output = '';
	$arr_records = array();
	$today_day = date('j');
	$today_date = date('Y-m-d');

	if($this->chkIfPageEnableForScrollingBar($page_id))

	{

	

		$sql = "SELECT * FROM `tblscrollingbars` WHERE ( (`sb_listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', sb_days_of_month) ) OR (`sb_listing_date_type` = 'single_date' AND `sb_single_date` = '".$today_date."') OR (`sb_listing_date_type` = 'date_range' AND `sb_start_date` <= '".$today_date."' AND `sb_end_date` >= '".$today_date."') ) AND ( `sb_status` = '1' ) AND ( `sb_deleted` = '0' ) ORDER BY `sb_order` ASC , `sb_add_date` DESC ";

		//echo '<br>sql = '.$sql;

		$STH = $DBH->query($sql);
                if( $STH->rowCount() > 0 )
		{
			while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 
			{
				$show = false;
				$temp_page_id = stripslashes($row['page_id']);
				if($temp_page_id == '')
				{
					$show = true;
				}
				else
				{

					$arr_temp_pg_id = explode(',',$temp_page_id);
					if(in_array($page_id,$arr_temp_pg_id))
					{
						$show = true;
					}
				}
				if($show)
				{
					$arr_records[] = $row;
				}
			}
			if(count($arr_records) > 0)
			{

				$sb_bg_color = $this->getCommonSettingValue('1');
				$sb_border_color = $this->getCommonSettingValue('2');

				$output .= '<style>.ticker-wrapper.has-js {background-color: #'.$sb_bg_color.'; border:1px solid #'.$sb_border_color.'} .ticker {background-color: #'.$sb_bg_color.';} .ticker-swipe {background-color: #'.$sb_bg_color.';}</style>';

				

				

				$output .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">

						<tr>

							<td width="100%" align="left" valign="top">';

							

				$output .= ' 	<ul id="js-news" class="js-hidden">';

				

				

				//while ($row = mysql_fetch_assoc($result)) 

				foreach($arr_records as $key => $row )

				{

					$sb_id = $row['sb_id'];

					$sb_content = stripslashes($row['sb_content']);

					$sb_content_font_family = stripslashes($row['sb_content_font_family']);

					$sb_content_font_size = stripslashes($row['sb_content_font_size']);

					$sb_content_font_color = stripslashes($row['sb_content_font_color']);

					$sb_show_content_credit = stripslashes($row['sb_show_content_credit']);

					$sb_content_credit_link = stripslashes($row['sb_content_credit_link']);

					$sb_content_credit_name = stripslashes($row['sb_content_credit_name']);

					

					$sb_content_style = '';

					if($sb_content_font_family != '')

					{

						$sb_content_style = 'font-family:'.$sb_content_font_family.';';

					}

					

					if($sb_content_font_size != '')

					{

						$sb_content_style .= 'font-size:'.$sb_content_font_size.'px;';

					}

					

					if($sb_content_font_color != '')

					{

						$sb_content_style .= 'color:#'.$sb_content_font_color.';';

					}

		

					if($row['sb_content_image'] != '')

					{

						$sb_content_image = '<img border="0" height="30" src="'.SITE_URL.'/uploads/'.stripslashes($row['sb_content_image']).'" />';

						$sb_content_image = '';		

					}

					else

					{

						$sb_content_image = '';	

					}

					

					

					if($sb_show_content_credit == '1' )

					{

						if($sb_content_credit_name != '')

						{

							$sb_content_credit = '&nbsp;&nbsp;---&nbsp;&nbsp;<a href="'.$sb_content_credit_link.'" target="_blank">'.$sb_content_credit_name.'</a>&nbsp;&nbsp;&nbsp;&nbsp;';

						}

						else

						{

							$sb_content_credit = '';

						}	

					}

					else

					{

						$sb_content_credit = '';

					}	

						

					$output .= '<li class="news-item"><a href="#" style="'.$sb_content_style.'">'.$sb_content.' &nbsp;&nbsp;'.$sb_content_image.'</a> &nbsp;&nbsp;<span>'.$sb_content_credit.'</span></li>';

				}

				

				$output .= '</ul>';

				$output .= ' </td>

						</tr>

					</table>   

					<table width="100%" border="0" cellspacing="0" cellpadding="0">

						<tr>

							<td height="10"><img src="images/spacer.gif" width="1" height="1" /></td>

						</tr>

					</table>   ';

			}

		}

	}

	return $output;	

}


public function chkIfPageEnableForScrollingBar($page_id)

{

	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."' AND `show_in_manage_menu` = '1' AND `show_in_list` = '1' ORDER BY `menu_title` ASC";
	 $STH = $DBH->query($sql);
         if( $STH->rowCount() > 0 )
	{

		$return = true;

	}

	return $return;

}


public function getCommonSettingValue($cs_id)

{

	$DBH = new DatabaseHandler();
	$cs_value = '';
	$sql = "SELECT * FROM `tblcommonsettings` WHERE `cs_id` = '".$cs_id."' ";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
	{

		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$cs_value = stripslashes($row['cs_value']);

	}

	return $cs_value;

}


public function getAllIconsDisplayTypeDetailsVivek()

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$data = array();
	$sql = "SELECT * FROM `tbl_icons` WHERE `display_type`='382' and `status`='1' ORDER BY `order_no` ASC";
	//echo '<br>Testkk: sql = '.$sql;
	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $data[] = $row;
                }
		
	}
        
        return $data;

}


public function getFavCategoryNameRamakant($fav_cat_id)
	{
            $my_DBH = new DatabaseHandler();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();

            $fav_cat_type = '';

            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $fav_cat_type = stripslashes($row['fav_cat']);
            }
            return $fav_cat_type;
	}
        
public function getPageContents2($page_id)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$page_contents = '';
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";

	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$temp = stripslashes($row['page_contents2']);
		$temp = str_replace('&nbsp;',' ',$temp);
		$page_contents = html_entity_decode ($temp);
	}

	return $page_contents;

}

public function getScrollingWindowsCodeMainContent($page_id)

{

    $my_DBH = new DatabaseHandler();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
    $return = false;
    $output = '';

    $user_id = $_SESSION['user_id'];
    
    $sql1 = "SELECT * FROM `tblscrollingwindows` WHERE FIND_IN_SET('".$page_id."', page_id) AND `sw_status` = '1' AND `sw_show_in_contents` = '1' ORDER BY `sw_order` ASC , `sw_add_date` DESC ";
    $STH = $DBH->prepare($sql1);
    $STH->execute();
    if($STH->rowCount() > 0)
    {

        $return = true;
        $i = 1;
        $output .= '<div class="divcenterouter">';
        $output .= '<div class="divcenterinner">';
        //$output .= '<div style="float:left;max-width:580px;">';
        while ($row1 = $STH->fetch(PDO::FETCH_ASSOC)) 

        {

            $sw_header = stripslashes($row1['sw_header']);

            $sw_header_hide = stripslashes($row1['sw_header_hide']);

            $sw_footer_hide = stripslashes($row1['sw_footer_hide']);

            $sw_header_font_family = stripslashes($row1['sw_header_font_family']);

            $sw_header_font_size = stripslashes($row1['sw_header_font_size']);

            $sw_header_font_color = stripslashes($row1['sw_header_font_color']);

            

            $sw_header_bg_color = stripslashes($row1['sw_header_bg_color']);

            if($sw_header_bg_color == '')

            {

                $sw_header_bg_color = '666666';

            }

            $sw_box_border_color = stripslashes($row1['sw_box_border_color']);

            if($sw_box_border_color == '')

            {

                $sw_box_border_color = '666666';

            }



            $header_style = '';

            

            if($sw_header_font_family != '')

            {

                $header_style = 'font-family:'.$sw_header_font_family.';';

            }



            if($sw_header_font_size != '')

            {

                $header_style .= 'font-size:'.$sw_header_font_size.'px;';

            }

            else

            {

                $header_style .= 'font-size:11px';

            }



            if($sw_header_font_color != '')

            {

                    $header_style .= 'color:#'.$sw_header_font_color.';';

            }

            

            if($row1['sw_show_header_credit'] == '1')

            {

                $sw_header = '<a href="'.stripslashes($row1['sw_header_credit_link']).'" target="_blank" style="color:#ffffff;'.$header_style.'">'.$sw_header.'</a>';			

            }



            if($row1['sw_header_image'] != '')

            {

                    $sw_header_image = '<img border="0" width="30" height="30" src="'.SITE_URL.'/uploads/'.stripslashes($row1['sw_header_image']).'">';

            }

            else

            {

                    $sw_header_image = '';

            }



            $sw_footer = stripslashes($row1['sw_footer']);

            



            $sw_footer_font_family = stripslashes($row1['sw_footer_font_family']);

            $sw_footer_font_size = stripslashes($row1['sw_footer_font_size']);



            $sw_footer_font_color = stripslashes($row1['sw_footer_font_color']);

            $sw_footer_bg_color = stripslashes($row1['sw_footer_bg_color']);

            if($sw_footer_bg_color == '')

            {

                $sw_footer_bg_color = '666666';

            }





            $footer_style = '';

            

            if($sw_footer_font_family != '')

            {

                    $footer_style = 'font-family:'.$sw_footer_font_family.';';

            }



            if($sw_footer_font_size != '')

            {

                    $footer_style .= 'font-size:'.$sw_footer_font_size.'px;';

            }

            else

            {

                    $footer_style .= 'font-size:11px';

            }



            if($sw_footer_font_color != '')

            {

                    $footer_style .= 'color:#'.$sw_footer_font_color.';';

            }

            

            if($row1['sw_show_footer_credit'] == '1')

            {

                    $sw_footer = '<a href="'.stripslashes($row1['sw_footer_credit_link']).'" target="_blank" style="color:#ffffff;'.$footer_style.'">'.$sw_footer.'</a>';			

            }



            if($row1['sw_footer_image'] != '')

            {

                    $sw_footer_image = '<img border="0" width="30" height="30" src="'.SITE_URL.'/uploads/'.stripslashes($row1['sw_footer_image']).'">';

            }

            else

            {

                    $sw_footer_image = '';

            }



            $today_day = date('j');

            $today_date = date('Y-m-d');

	

            $sql2 = "SELECT * FROM `tblscrollingcontents` WHERE ( (`sc_listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', sc_days_of_month) ) OR (`sc_listing_date_type` = 'single_date' AND `sc_single_date` = '".$today_date."') OR (`sc_listing_date_type` = 'date_range' AND `sc_start_date` <= '".$today_date."' AND `sc_end_date` >= '".$today_date."') ) AND ( `sw_id` = '".$row1['sw_id']."' ) AND ( `sc_status` = '1' ) ORDER BY `sc_order` ASC , `sc_add_date` DESC ";

            //echo '<br>sql = '.$sql;

            $STH2 = $DBH->prepare($sql2);
            $STH2->execute();
            if($STH2->rowCount() > 0)

            {
                $output .= '<div style="float:left;width:160px; margin-left:20px; ">';
                $output .= '<form name="frmScrollingWindows" id="frmScrollingWindows" action="#" method="post" >';
                $output .= '	<input type="hidden" name="hdnpage_id" id="hdnpage_id" value="'.$page_id.'">';
                $output .= '<table width="160" border="0" cellpadding="0" cellspacing="1" bgcolor="#'.$sw_box_border_color.'">';

                if($sw_header_hide == '0')

                {

                $output .= '	<tr>';

                $output .= '        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF">'; 

                $output .= '            <table width="160" border="0" cellpadding="0" cellspacing="0" bgcolor="#'.$sw_header_bg_color.'">';    

                $output .= '                <tr>';

                if($sw_header_image == '')

                {

                $output .= '                    <td width="160" bgcolor="#'.$sw_header_bg_color.'" height="30" align="center" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$header_style.'" >'.$sw_header.'</td>';

                }

                else

                {

                $output .= '                    <td width="125" bgcolor="#'.$sw_header_bg_color.'" height="30" align="left" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$header_style.'" >'.$sw_header.'</td>';

                $output .= '                    <td width="35" bgcolor="#'.$sw_header_bg_color.'" height="30" align="right" valign="middle" >'.$sw_header_image.'</td>';    

                }

                $output .= '                </tr>';

                $output .= '            </table>';    

                $output .= '        </td>';

                $output .= '	</tr>';

                }

                

                $output .= '	<tr>';

                $output .= '        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF" class="slider">';    

                

                $output .= '            <div style="" id="slider_main'.$i.'" >';



                $j = 0;

                while ($row = $STH2->fetch(PDO::FETCH_ASSOC)) 

                {

                    $sc_id = $row['sc_id'];
                    $sc_title = stripslashes($row['sc_title']);
                    $sc_title_font_family = stripslashes($row['sc_title_font_family']);
                    $sc_title_font_size = stripslashes($row['sc_title_font_size']);
                    $sc_content = get_clean_br_string(stripslashes($row['sc_content']));
                    $sc_content_font_family = stripslashes($row['sc_content_font_family']);
                    $sc_content_font_size = stripslashes($row['sc_content_font_size']);
                    $sc_content_type = stripslashes($row['sc_content_type']);
                    $sc_title_font_color = stripslashes($row['sc_title_font_color']);
                    $sc_content_font_color = stripslashes($row['sc_content_font_color']);
                    $sc_title_hide = stripslashes($row['sc_title_hide']);
                    $sc_add_fav_hide = stripslashes($row['sc_add_fav_hide']);
                    $sc_credit_link = stripslashes($row['sc_credit_link']);
                    $sc_title_style = '';
                    if($sc_title_font_family != '')
                    {

                            $sc_title_style = 'font-family:'.$sc_title_font_family.';';

                    }



                    if($sc_title_font_size != '')

                    {

                            $sc_title_style .= 'font-size:'.$sc_title_font_size.'px;';

                    }



                    if($sc_title_font_color != '')

                    {

                            $sc_title_style .= 'color:#'.$sc_title_font_color.';';

                    }



                    $output .= '<div style="min-height:100px;">';

                    $output .= '			<table width="150" border="0" cellspacing="0" cellpadding="0">';

                    

                    if($sc_title_hide == '0')

                    {

                    $output .= '				<tr>';

                    $output .= '					<td height="30" colspan="2" align="center" valign="top" style="'.$sc_title_style.'" >';

                    if($sc_credit_link == '')

                    {

                        $output .= ''.$sc_title.'';

                    }

                    else

                    {

                        $output .= '<a href="'.$sc_credit_link.'" style="'.$sc_title_style.'" target="_blank">'.$sc_title.'</a>';

                    }

                    

                    $output .= '</td>';

                    $output .= '				</tr>';

                    }



                    if($sc_content_type == 'text')

                    {

                            $sc_content_style = '';

                            if($sc_content_font_family != '')

                            {

                                    $sc_content_style = 'font-family:'.$sc_content_font_family.';';

                            }



                            if($sc_content_font_size != '')

                            {

                                    $sc_content_style .= 'font-size:'.$sc_content_font_size.'px;';

                            }



                            if($sc_content_font_color != '')

                            {

                                    $sc_content_style .= 'color:#'.$sc_content_font_color.';';

                            }



                            $output .= '<tr>';

                            $output .= '<td colspan="2" height="60" align="left" valign="top" style="padding-left:3px;'.$sc_content_style.'">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$sc_content.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_content.'</a>';

                            }

                            $output .= '</td>';

                            $output .= '</tr>';



                    }

                    elseif($sc_content_type == 'text_and_image')

                    {

                            $sc_content_style = '';

                            if($sc_content_font_family != '')

                            {

                                    $sc_content_style = 'font-family:'.$sc_content_font_family.';';

                            }



                            if($sc_content_font_size != '')

                            {

                                    $sc_content_style .= 'font-size:'.$sc_content_font_size.'px;';

                            }



                            if($sc_content_font_color != '')

                            {

                                    $sc_content_style .= 'color:#'.$sc_content_font_color.';';

                            }



                            if($row['sc_image'] != '')

                            {

                                    $sc_image = '<img border="0" width="50" src="'.SITE_URL.'/uploads/'.stripslashes($row['sc_image']).'" />';

                            }

                            else

                            {

                                    $sc_image = '';	

                            }





                            $output .= '				<tr>';

                            $output .= '					<td width="60" height="60" align="left" valign="top">';

                            $output .= '						<table width="50" border="0" cellspacing="0" cellpadding="0">';

                            $output .= '							<tr>';

                            $output .= '								<td align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:10px;">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$sc_image.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_image.'</a>';

                            }

                            $output .= '</td>';

                            $output .= '							</tr>';

                            $output .= '						</table>';

                            $output .= '					</td>';

                            $output .= '					<td width="90" height="60" align="left" valign="top" style="padding-left:3px;'.$sc_content_style.'">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$sc_content.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_content.'</a>';

                            }

                            $output .= '</td>';

                            $output .= '				</tr>';	



                    }

                    elseif($sc_content_type == 'image')

                    {

                            if($row['sc_image'] != '')

                            {

                                    $sc_image = '<img border="0" width="150" src="'.SITE_URL.'/uploads/'.stripslashes($row['sc_image']).'" />';

                            }

                            else

                            {

                                    $sc_image = '';	

                            }



                            $output .= '				<tr>';

                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$sc_image.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_image.'</a>';

                            }

                            $output .= '</td>';

                            $output .= '				</tr>';	

                    }	

                    elseif($sc_content_type == 'video')

                    {

                            if($row['sc_video'] != '')

                            {

                                    $sc_video = '<iframe width="150" height="150" src="'.$this->getBannerString($row['sc_video']).'" frameborder="0" allowfullscreen></iframe>';

                            }

                            else

                            {

                                    $sc_video = '';	

                            }



                            $output .= '				<tr>';

                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$sc_video.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_video.'</a>';

                            }

                            $output .= '       </td>';

                            $output .= '				</tr>';	

                    }	

                    elseif($sc_content_type == 'flash')

                    {

                            if($row['sc_flash'] != '')

                            {

                                    $sc_flash = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="100"><param name="movie" value="'.SITE_URL."/uploads/".$row['sc_flash'].'" /><param name="quality" value="high" /><embed src="'.SITE_URL."/uploads/".$row['sc_flash'].'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="100"></embed></object>';

                            }

                            else

                            {

                                    $sc_flash = '';	

                            }



                            $output .= '				<tr>';

                            $output .= '					<td colspan="2" height="60" align="left" valign="top">'.$sc_flash.'</td>';

                            $output .= '				</tr>';	

                    }	

                    elseif($sc_content_type == 'rss')

                    {

                            $rss_feed_item_id = $row['rss_feed_item_id'];

                            list($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json) = $this->getRssFeedItemDetails($rss_feed_item_id);



                            $output .= '				<tr>';

                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$rss_feed_item_title.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$rss_feed_item_title.'</a>';

                            }

                            $output .= '        </td>';

                            $output .= '				</tr>';	

                            $output .= '				<tr>';

                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';

                            if($sc_credit_link == '')

                            {

                                $output .= ''.$rss_feed_item_desc.'';

                            }

                            else

                            {

                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$rss_feed_item_desc.'</a>';

                            }

                            $output .= '        </td>';

                            $output .= '				</tr>';	

                    }	







                    if(stripslashes($row['sc_show_credit']) == '1')

                    {



                            if(stripslashes($row['sc_credit_name']) != '')

                            {

                                    $sc_show_credit = '1';

                                    $sc_credit_name = stripslashes($row['sc_credit_name']);

                                    if(stripslashes($row['sc_credit_link']) != '')

                                    {

                                            $sc_credit_link = stripslashes($row['sc_credit_link']);

                                    }

                                    else

                                    {

                                            $sc_credit_link = '';	

                                    }	

                            }

                            else

                            {

                                    $sc_show_credit = '0';	

                                    $sc_credit_name = '';	

                                    $sc_credit_link = '';	

                            }	

                    }	

                    else

                    {

                            $sc_show_credit = '0';	

                            $sc_credit_name = '';	

                            $sc_credit_link = '';	

                    }

                    

                    if($sc_add_fav_hide == '0')

                    { 

				

                    $output .= '				<tr>

                                    <td height="30" align="left" valign="middle" style="padding-left:2px;">';

                    if(!$this->chkIfOptionAlreadyAddedToFav($user_id,$page_id,$sc_id,'0'))

                    {								

                    $output .= '					<input type="button" name="select_scrolloing_content_'.$i.'_'.$j.'" id="select_scrolloing_content_'.$i.'_'.$j.'" value="Add to Fav" onclick="addScrollingContentToFav(\''.$sc_id.'\')" style="width:60px;font-size:9px;">';

                    }

                    $output .= '                    </td>

												<td height="30" align="right" valign="middle">';

                    if($sc_show_credit == '1')

                    {

                    $output .= '					<a href="'.$sc_credit_link.'" target="_blank">'.$sc_credit_name.'</a>';

                    }

                    $output .= '                    </td>

                                                                            </tr>';

                    }

                    else

                    {

                    

                    

                    

                        if($sc_show_credit == '1')

                        {

                            $output .= '				<tr>

                                        <td colspan="2" height="30" align="center" valign="middle" style="padding-left:2px;">';

                        $output .= '					<a href="'.$sc_credit_link.'" target="_blank">'.$sc_credit_name.'</a>';

                        $output .= '                    </td>

                                                                                </tr>';  

                        }

                      

                    }



                    $output .= '			</table>';



                    $output .= '</div>';





                    $j = $j+1;

                }

				

                $output .= '			</div>';





                $output .= '		</td>';

                $output .= '	</tr>';

                if($sw_footer_hide == '0')

                {

                $output .= '	<tr>';

                $output .= '        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF">'; 

                $output .= '            <table width="160" border="0" cellpadding="0" cellspacing="0" bgcolor="#'.$sw_footer_bg_color.'">';    

                $output .= '                <tr>';

                if($sw_footer_image == '')

                {

                $output .= '                    <td width="160" bgcolor="#'.$sw_footer_bg_color.'" height="30" align="center" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$footer_style.'" >'.$sw_footer.'</td>';

                }

                else

                {

                $output .= '                    <td width="125" bgcolor="#'.$sw_footer_bg_color.'" height="30" align="left" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$footer_style.'" >'.$sw_footer.'</td>';

                $output .= '                    <td width="35" bgcolor="#'.$sw_footer_bg_color.'" height="30" align="right" valign="middle" >'.$sw_footer_image.'</td>';    

                }

                $output .= '                </tr>';

                $output .= '            </table>';    

                $output .= '        </td>';

                $output .= '	</tr>';    

                

                }

                $output .= '</table>

                            <table width="160" border="0" cellspacing="0" cellpadding="0">

                                <tr>

                                    <td height="10"><img src="images/spacer.gif" width="1" height="1" /></td>

                                </tr>

                            </table>';

                $output .= '	</form>';

                $output .= '</div>';

                

                if($i % 3 == 0)

                {

                $output .= '<div style="clear:both;height:5px;"></div>';        

                }

                

                $i = $i+1;

                

                

            }

        }

        $output .= '</div></div><div style="clear:both;height:5px;"></div>';

    }

    return $output;	

}

public function getRssFeedItemDetails($rss_feed_item_id)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

	$rss_feed_item_title = '';
	$rss_feed_item_desc = '';
	$rss_feed_item_link = '';
	$rss_feed_item_json = '';

	$sql = "SELECT * FROM `tblrssfeeditems` WHERE `rss_feed_item_id` = '".$rss_feed_item_id."' AND `rss_feed_item_status` = '1' ";

	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)

	{

		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$rss_feed_item_title = stripslashes($row['rss_feed_item_title']);
		$rss_feed_item_desc = stripslashes($row['rss_feed_item_desc']);
		$rss_feed_item_link = stripslashes($row['rss_feed_item_link']);
		$rss_feed_item_json = stripslashes($row['rss_feed_item_json']);
	}
	return array($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json);

}


public function getTemppageId($page_id)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$temp_page_id = '0';

	$sql ="SELECT * FROM `tblpages` WHERE show_in_feedback = '1' AND `page_id` = '".$page_id."' ORDER BY `page_add_date` DESC";	

	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$temp_page_id = stripslashes($row['page_id']);
	}	
	return $temp_page_id;

}

public function getFeeadBackPages($page_id)

{

    $my_DBH = new DatabaseHandler();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();

    $option_str = '';

    $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '3' AND `pd_deleted` = '0' ";

    $STH = $DBH->prepare($sql);
    $STH->execute();
    if($STH->rowCount() > 0)

    {

        $row = $STH->fetch(PDO::FETCH_ASSOC);

        $page_id_str = stripslashes($row['page_id_str']);

        $sql2 = "SELECT * FROM `tblpages` WHERE `page_id` IN (".$page_id_str.") AND `show_in_list` = '1' AND `adviser_panel` = '0' AND `vender_panel` = '0' ORDER BY `menu_title` ASC";    

        //$sql = "SELECT * FROM `tblpages` WHERE  AND `show_in_feedback` = '1' ORDER BY `page_name` ASC";

        //echo $sql;

        $STH2 = $DBH->prepare($sql2);
        $STH2->execute();
        if($STH2->rowCount() > 0)

        {

            if($page_id == 0)

            {

                $sel = ' selected ';

            }

            else

            {

                $sel = '';

            }	

            $option_str .= '<option value="0" '.$sel.'>General</option>';

            while($row = $STH2->fetch(PDO::FETCH_ASSOC) ) 
            {
                if($row['page_id'] == $page_id)
                {
                    $sel = ' selected ';
                }
                else
                {
                    $sel = '';
                }		
                $option_str .= '<option value="'.$row['page_id'].'" '.$sel.'>'.stripslashes($row['page_name']).'</option>';
            }
        }
    }    
    return $option_str;

}


public function getCommentByBesname($besname,$day_month_year)
{
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$comment = array(); 
        $sql ="SELECT * FROM `tblbodymainsymptoms` WHERE `bms_name` = '".$besname."' ";	
	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		//$comment = stripslashes($row['comment']);
                $comment = $this->GetSymtumKeywordList($row['bms_id'],$day_month_year);
	}	
	return $comment;
}

public function GetSymtumKeywordList($symptom_id,$day_month_year)
{
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$comment = array();  
        $key_sub_cat = array();
        $option_str = "";
        $sql ="SELECT `keywords` FROM `tbl_symptom_keyword` WHERE `symptom_id` = '".$symptom_id."' and `key_sub_cat` = '506' ";	
	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                   $comment[] = $row['keywords']; 
                   //$key_sub_cat[]=$row['key_sub_cat']; 
                }
                $icon = $this->getMyDayTodayIconComment('QuickTip_show',$day_month_year); 
                //print_r($icon);
                //title="'.$icon['icons_name'].'" alt="'.$icon['icons_name'].'"
               
                
                if(count($comment) > 0)
                {
                    //echo $comment;
                     $option_str .='<div class="tooltipN">
                                <a href="#" target="_blank">
                                <img src="uploads/'.$icon['image'].'" title="'.$icon['icons_name'].'" alt="'.$icon['icons_name'].'" style="width:50px; height:50px;">
                                <span class="tooltiptext">';
                    $option_str .='<p style="color:#000;"><b>Quick Tips</b></p>';   
                    for($i=0;$i<count($comment);$i++)
                    {
                        $option_str .='<p>'.$comment[$i].'</p>';   
                    }
                    
                        $option_str .='</span></a></div>';
                }
                
                
		//$comment = stripslashes($row['comment']);
                
	}	
	return $option_str;  
}

public function addUsersMDT($user_id,$data)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
	$return = false;
	for($i=0;$i<count($data['bes_id']);$i++)
	{

            if($data['bes_id'][$i] !='')
            {

                $sql = "INSERT INTO `tblusersmdt`(`mdt_date`, `user_id`, `bms_name`, `bms_entry_type`, `scale`, `remarks`, `mdt_time`, `mdt_duration`,`user_location`, `user_view`, `user_Interaction`, `user_alert`,`sequence_show`)"

                        . "VALUES ('".date("Y-m-d",strtotime($data['day_month_year']))."','".$user_id."','".$data['bes_id'][$i]."','".$data['heading'][$i]."','".$data['scale'][$i]."','".$data['comment'][$i]."','".$data['bes_time'][$i]."','".$data['duration'][$i]."','".$data['location'][$i]."','".$data['User_view'][$i]."','".$data['User_Interaction'][$i]."','".$data['alert'][$i]."','".$data['sequence']."')";

                $STH = $DBH->prepare($sql);
                $STH->execute();
                if($STH->rowCount() > 0)
                {
                   $return = true; 
                }
                

            }	

	}	
        
        $_SESSION['sequence'] = $data['sequence']+1;
	return $return;

}


public function getMyDayTodayData($user_id,$mdtdate,$sequence)
{
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$data = array();  
        $sql ="SELECT * FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' and `mdt_date` = '".$mdtdate."' and sequence_show = '".$sequence."' ";	
	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                  $data[] = $row;
                }
		
	}	
	return $data;
}

public function GetHeaderDatabyPage($page_name)
{
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$data = array();  
        $sql ="SELECT * FROM `tbl_data_dropdown` WHERE `page_name` = '".$page_name."' and `is_deleted` = 0 and `pag_cat_status` = 1 order by `order_show` ASC ";	
	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                  $data[] = $row;
                }
		
	}	
	return $data; 
}

public function getExclusionAllName()
	{
            $my_DBH = new DatabaseHandler();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $cs_value = array();

            $sql = "SELECT * FROM `tbl_exclusion` where 1 ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                    while($row = $STH->fetch(PDO::FETCH_ASSOC))
                    {
                        $cs_value[] = strtolower($row['exl_name']);
                    }
            }
            return $cs_value;
	}
        
        public function GetFecthData($keyworddata_implode_data,$canv_sub_cat_link,$cat_id)
        {
            $final_data = array();
          
            if($canv_sub_cat_link=='tbl_bodymainsymptoms')
            {
                //echo 'Hiii';
               $symtum_cat = $this->getAllMainSymptomsMyCanvas($cat_id);
               if(!empty($symtum_cat))
               {
                    $final_data = $this->Getmycanvasdata($symtum_cat,$keyworddata_implode_data);
               }
            }
            
            if($canv_sub_cat_link=='tblsolutionitems')
            {
               
               //$symtum_cat = $this->getAllMainSymptomsRamakantFront($cat_id);
               $final_data = $this->Getmycanvassolutionitems($cat_id,$keyworddata_implode_data);
            }
            
            if($canv_sub_cat_link=='tbldailymealsfavcategory')
            {
                // echo 'Hiii';
               $symtum_cat = $this->getAllDailyMealsMyCanvas($cat_id); 
               if(!empty($symtum_cat))
               {
                $final_data = $this->Getmycanvasmealdata($symtum_cat,$keyworddata_implode_data);
               }
            }
            
            if($canv_sub_cat_link=='tbldailyactivity')
            {
               //$symtum_cat = $this->getAllDailyActivityMyCanvas($cat_id);
               $final_data = $this->GetmycanvasDailyActivitydata($cat_id,$keyworddata_implode_data);
            }
           
            if($canv_sub_cat_link=='tbl_event_master')
            {
                
             $final_data = $this->GetEventDataMyCanvas($keyworddata_implode_data);   
                
            }
            
            
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
        
public function Getmycanvasdata($symtum_cat,$keyworddata_implode_data)
{
        $symtum_cat = implode(',', $symtum_cat);
        $DBH = new DatabaseHandler();
        $str_sql_search = '';
        //$
        
        for($i=0;$i<count($keyworddata_implode_data);$i++)
        {
          if($i==0)
          {
            $str_sql_search .= " `bms_name` LIKE '%".$keyworddata_implode_data[$i]."%' "; 
          }
          else
          {
            $str_sql_search .= " OR `bms_name` LIKE '%".$keyworddata_implode_data[$i]."%' ";   
          }
        }
        
	$option_str = array();
        $option_str2 = array();
	$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE bms_id IN($symtum_cat) AND ($str_sql_search) ORDER BY `bms_name` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {
                $data = array();
                if($row['comment']!='')
                {
                    $data['activity_name'] = strip_tags($row['bms_name']).'<span class="tooltiptext">'.strip_tags($row['comment']).'</span>';
                    $data['activity_id'] = $row['bms_id'];
                }
                else
                {
                    $data['activity_name'] = strip_tags($row['bms_name']);  
                    $data['activity_id'] = $row['bms_id'];
                }
                
                
                $option_str[]=$data;
            }
            
            
            for($i=0;$i<count($option_str);$i++)
            {
                array_push($option_str2, $this->GETsymtumKeyword($option_str[$i]['activity_id']));  
            }
            
           $option_str2 = array_values(array_filter($option_str2));
           
           
            
            for($i=0;$i<count($option_str2);$i++)
            {
                for($j=0;$j<count($option_str2[$i]);$j++)
                {
                    array_push($option_str, $option_str2[$i][$j]);
                }
            }
         
            
	}
	return $option_str;  
}


public function GETsymtumKeyword($symptom_id)
{
        $DBH = new DatabaseHandler();
	$option_str = array();
	$sql = "SELECT * FROM `tbl_symptom_keyword` WHERE  symptom_id ='".$symptom_id."' and `keywords`!='' ORDER BY `add_date` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {
                $data = array();
                $data['activity_name'] = $row['keywords'];
                $data['activity_id'] = $row['symptom_id'];
                $option_str[]=$data;
                
            }
            
//            echo '<pre>';
//            print_r($option_str);
//            echo '</pre>';
            
	}
	return $option_str;     
}

public function Getmycanvassolutionitems($cat_id,$keyworddata_implode_data)
{
       //echo 'cat_id'.$cat_id; 
        //$symtum_cat = explode(',', $cat_id);
        //$symtum_cat = implode($symtum_cat, '\',\'');
        
       // echo 'cat_id'.$symtum_cat.'<br>'; 
        
        $DBH = new DatabaseHandler();
        $str_sql_search = '';
        //$
        
        for($i=0;$i<count($keyworddata_implode_data);$i++)
        {
          if($i==0)
          {
            $str_sql_search .= " `sol_box_title` LIKE '%".$keyworddata_implode_data[$i]."%' OR `sol_box_desc` LIKE '%".$keyworddata_implode_data[$i]."%' "; 
          }
          else
          {
            $str_sql_search .= " OR `sol_box_title` LIKE '%".$keyworddata_implode_data[$i]."%' OR `sol_box_desc` LIKE '%".$keyworddata_implode_data[$i]."%' "; 
          }
        } 
        
        $option_str = array();
	$sql = "SELECT * FROM `tblsolutionitems` WHERE  $str_sql_search AND sol_item_cat_id IN($cat_id) ORDER BY `sol_box_title` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {	
                $data = array();
                if($row['sol_box_desc']!='')
                {
                    $data['activity_name'] = strip_tags($row['sol_box_title']).'<span class="tooltiptext">'.strip_tags($row['sol_box_desc']).'</span>';
                    
                    $data['activity_id'] = $row['sol_item_cat_id'];
                    
                }
                else {
                    $data['activity_name'] = strip_tags($row['sol_box_title']);
                    $data['activity_id'] = $row['sol_item_cat_id'];
                }
                
                $option_str[]= $data;

            }
	}
	return $option_str; 
        
}


public function GetCategoryNameByid($symtum_cat)
{
        
        $DBH = new DatabaseHandler();
	$option_str = array();
	$sql = "SELECT * FROM `tblfavcategory` WHERE  fav_cat_id IN($symtum_cat) ORDER BY `fav_cat` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {
                $data = array();
                $data['activity_name'] = strip_tags($row['fav_cat']);
                $data['activity_id'] = $row['fav_cat_id'];
                $option_str[]=$data;
                
            }
	}
	return $option_str;     
}

public function getAllMainSymptomsMyCanvas($symtum_cat)
    {       
        $DBH = new DatabaseHandler();
        //$symtum_cat = implode($symtum_cat, '\',\'');
        $str_sql_search = " AND `fav_parent_cat` IN (".$symtum_cat.") ";
        $data = array();
        $sql = "SELECT DISTINCT bmsid FROM `tblsymtumscustomcategory` WHERE  symtum_deleted = '0' ".$str_sql_search." ORDER BY bmsid DESC ";		
        
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {           
                $data[] = $row['bmsid'];
            }
	}
	return $data;  
        
    }
    
    public function getAllDailyMealsMyCanvas($symtum_cat)
    {       
        $DBH = new DatabaseHandler();
        //$symtum_cat = implode($symtum_cat, '\',\'');
        $str_sql_search = " AND `fav_cat_id` IN (".$symtum_cat.") ";
        $data = array();
        $sql = "SELECT DISTINCT meal_id FROM `tbldailymealsfavcategory` WHERE  show_hide = '1' ".$str_sql_search." ORDER BY meal_id DESC ";		
        
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {           
                $data[] = strip_tags($row['meal_id']);
            }
	}
	return $data;  
        
    }
    
public function Getmycanvasmealdata($symtum_cat,$keyworddata_implode_data)
{      
        $symtum_cat = implode(',', $symtum_cat);
        $DBH = new DatabaseHandler();
        $str_sql_search = '';
        //$
        
        for($i=0;$i<count($keyworddata_implode_data);$i++)
        {
          if($i==0)
          {
            $str_sql_search .= " `benefits` LIKE '%".$keyworddata_implode_data[$i]."%' "; 
          }
          else
          {
            $str_sql_search .= " OR `benefits` LIKE '%".$keyworddata_implode_data[$i]."%' ";   
          }
        }
        
	$option_str = array();
	$sql = "SELECT * FROM `tbldailymeals` WHERE meal_id IN($symtum_cat) AND ($str_sql_search) ORDER BY `meal_item` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {			
                $data = array();
                if($row['benefits']!='')
                {
                    $data['activity_name'] = strip_tags($row['meal_item']).'<span class="tooltiptext">'.strip_tags($row['benefits']).'</span>';
                   
                    $data['activity_id'] = $row['meal_id'];
                 }
                else
                {
                   $data['activity_name'] = strip_tags($row['meal_item']); 
                   $data['activity_id'] = $row['meal_id'];
                }
                $option_str[]=$data;
            }
	}
	return $option_str;  
        
}

public function GetmycanvasDailyActivitydata($symtum_cat,$keyworddata_implode_data)
{      
        //echo $symtum_cat = implode(',', $symtum_cat);
    //echo $symtum_cat;
        $DBH = new DatabaseHandler();
        $str_sql_search = '';
        //$
        
        for($i=0;$i<count($keyworddata_implode_data);$i++)
        {
          if($i==0)
          {
            $str_sql_search .= " `recommendations` LIKE '%".$keyworddata_implode_data[$i]."%' OR `guidelines` LIKE '%".$keyworddata_implode_data[$i]."%' OR `precautions` LIKE '%".$keyworddata_implode_data[$i]."%'  OR `benefits` LIKE '%".$keyworddata_implode_data[$i]."%' "; 
          }
          else
          {
            $str_sql_search .= " OR `recommendations` LIKE '%".$keyworddata_implode_data[$i]."%' OR `guidelines` LIKE '%".$keyworddata_implode_data[$i]."%' OR `precautions` LIKE '%".$keyworddata_implode_data[$i]."%'  OR `benefits` LIKE '%".$keyworddata_implode_data[$i]."%' "; 
          }
        }
        
	$option_str = array();
        $sql = "SELECT * FROM `tbldailyactivity` WHERE (activity_category IN($symtum_cat) OR activity_level_code IN($symtum_cat)) AND ($str_sql_search) ORDER BY `activity` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {
                $data = array();
                if($row['benefits']!='')
                {
                $data['activity_name'] = strip_tags($row['activity']).'<span class="tooltiptext">'.strip_tags($row['benefits']).'</span>';
                
                $data['activity_id'] = $row['activity_id'];
                
                }
                else
                {
                   $data['activity_name']= strip_tags($row['activity']); 
                   $data['activity_id'] = $row['activity_id'];
                }
                   $option_str[] = $data;
            }
	}
	return $option_str;  
        
}

public function getmydaytodaysequence($mdtdate,$user_id)
{
    $DBH = new DatabaseHandler();
    $start_date = $mdtdate.' 00:00:00';
    $end_date = $mdtdate.' 59:59:59';
    $sequence = 0;
    $sql = "SELECT sequence_show FROM `tblusersmdt` WHERE  user_id = '$user_id' and `mdt_add_date` >= '".$start_date."' and `mdt_add_date` <= '".$end_date."' ORDER BY mdt_add_date DESC LIMIT 1 ";		
    $STH = $DBH->query($sql);
    if( $STH->rowCount() > 0 )
    {
        $row = $STH->fetch(PDO::FETCH_ASSOC);
        $sequence = $row['sequence_show'];
    }
    return $sequence;   
    
    
}

public function AddmyCanvas($comment,$location,$User_view,$User_Interaction,$alert,$activity_text,$activity_id,$canv_sub_cat_link,$canv_show_fetch,$prof_cat,$sub_cat,$maintab,$subtab,$mdt_date,$sequence,$user_id)
{
 
    $DBH = new DatabaseHandler();
    $return = false;
    $sql = "INSERT INTO `tbl_mycanvas`(`user_id`, `mdt_entry_date`, `sequence_show`, `main_tab`, `sub_tab`, `profile_cat`, `sub_cat`, `show_fetch_link`,`canv_show_fetch`,`activity_id`, `activity_text`, `comment`, `location`, `user_response`, `what_for_next`, `user_updates`) "
            . "VALUES ('".$user_id."','".date("Y-m-d",strtotime($mdt_date))."','".$sequence."','".$maintab."','".$subtab."','".$prof_cat."','".$sub_cat."','".$canv_sub_cat_link."','".$canv_show_fetch."','".$activity_id."','".addslashes($activity_text)."','".addslashes($comment)."','".$location."','".$User_view."','".$User_Interaction."','".$alert."')";
   // die();
    $STH = $DBH->query($sql);
    if($STH->rowCount() > 0)
    {
       $return = true;
    }
    
    return $return;
    
}



public function getSelectedSolIdByChkSolidAndFavCatVivek($sol_item_id_implode_value,$fav_cat_id)

{

	$DBH = new DatabaseHandler();
	$data = '';
	$sql = "SELECT * FROM `tblsolutionitems` WHERE `sol_item_id` IN(".$sol_item_id_implode_value.") and `sol_item_cat_id`='".$fav_cat_id."' and `sol_item_status` = '1' and `sol_item_deleted` = '0'";
	//echo '<br>Testkk: sql = '.$sql;
	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)

	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $data[] = $row['sol_item_id'];
                }
		
	}

	return $data;

}

public function getWSIAllDataByWSISolIDAndFavCatVivek($sol_id_implode,$fav_cat_id)

{

	$DBH = new DatabaseHandler();

	$data = '';
	$sql = "SELECT * FROM `tblsolutionitems` WHERE sol_item_cat_id = '".$fav_cat_id."' AND sol_item_id IN(".$sol_id_implode.")  and `sol_item_status` = '1' and `sol_item_deleted` = '0' ORDER BY `sol_item_id` DESC";

	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $data[] = $row;
                }
		
	}

	return $data;

}

public function GetAngerVentTooltip($page_id)

{

	$DBH = new DatabaseHandler();
	$toolcontents = '';
	$sql = "SELECT * FROM `tblangerventtooltip` WHERE page_id = '".$page_id."' ";
	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$toolcontents = stripslashes($row['text']);
	}	
	return $toolcontents;

}

public function getMindJumbleBoxDetails($day)

{

	$DBH = new DatabaseHandler();
	$arr_box_title = array(); 
	$arr_banner_type = array(); 
	$arr_banner = array();
	$arr_box_desc = array(); 
	$arr_mind_jumble_box_id = array();
	$arr_credit_line = array();
	$arr_credit_line_url = array();
	$arr_day = array();
	$arr_sound_clip_id = array();
	$arr_select_title = array();
	$arr_short_narration = array();


	$sql = "SELECT * FROM `tblmindjumble` WHERE  status = '1' ORDER BY `box_add_date` DESC";

	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
	{

		while($row = $STH->fetch(PDO::FETCH_ASSOC))

		{
			 $days = ($row['day']);
			 $arr_days = explode(",", $days);
				if (in_array($day,$arr_days)) 
					{	
						array_push($arr_box_title , stripslashes($row['box_title']));
						array_push($arr_banner_type , stripslashes($row['box_type']));
						array_push($arr_banner , stripslashes($row['box_banner']));
						array_push($arr_box_desc , stripslashes($row['box_desc']));
						array_push($arr_mind_jumble_box_id , stripslashes($row['mind_jumble_box_id']));
						array_push($arr_credit_line , stripslashes($row['credit_line']));
						array_push($arr_credit_line_url , stripslashes($row['credit_line_url']));
						array_push($arr_day , stripslashes($row['day']));
						array_push($arr_sound_clip_id , stripslashes($row['sound_clip_id']));
						array_push($arr_select_title , stripslashes($row['select_title']));
						array_push($arr_short_narration , stripslashes($row['short_narration']));
					}
		}	
	}
        
        return array($arr_box_title,$arr_banner_type,$arr_banner,$arr_box_desc,$arr_mind_jumble_box_id,$arr_credit_line,$arr_credit_line_url,$arr_day,$arr_sound_clip_id,$arr_select_title,$arr_short_narration);



}


public function getMindJumbelPDF($day)

{

	$DBH = new DatabaseHandler();


	$arr_pdf = array(); 
	$arr_pdf_title = array(); 
	$arr_credit = array();
	$arr_credit_url = array(); 
	$arr_status = array();
	$arr_days = array();
        
	$sql = "SELECT * FROM `tblmindjumblepdf` WHERE status = '1'  ORDER BY `mind_jumble_pdf_add_date` ASC";
	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
	{

		while($row = $STH->fetch(PDO::FETCH_ASSOC))

		{

		     $days = ($row['day']);
			 $arr_days = explode(",", $days);

				if (in_array($day,$arr_days)) 

					{	
						array_push($arr_pdf , stripslashes($row['pdf']));
						array_push($arr_pdf_title , stripslashes($row['pdf_title']));
						array_push($arr_credit , stripslashes($row['credit']));
						array_push($arr_credit_url , stripslashes($row['credit_url']));
						array_push($arr_status , stripslashes($row['status']));
					}	
		}

	}

	return array($arr_pdf,$arr_pdf_title,$arr_credit,$arr_credit_url,$arr_status);

}

public function getUserarea($step,$userarea_type)

{

	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "SELECT * FROM `tbluserarea` WHERE `userarea_type` = '".$userarea_type."' AND `step` = '".$step."' AND `status` = '1'";
	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$step = stripslashes($row['step']);
		$box_title = stripslashes($row['box_title']);
		$box_desc = stripslashes($row['box_desc']);
	}

	return array($box_title,$box_desc);

}

public function getMindJumbelBKMusic($day)
{

	$DBH = new DatabaseHandler();
	$music = ''; 
	$music_id = ''; 
	$credit = '';
	$credit_url = '';
	
	$sql = "SELECT * FROM `tblmindjumblemusic` WHERE status = '1' ORDER BY `music_add_date` DESC";

	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
	{

		while($row = $STH->fetch(PDO::FETCH_ASSOC))

		{

		     $days = ($row['day']);
			 $arr_days = explode(",", $days);
				if (in_array($day,$arr_days)) 
					{	

                                            $music = stripslashes($row['music']);
                                            $music_id = stripslashes($row['music_id']);
                                            $credit = stripslashes($row['credit']);
                                            $credit_url = stripslashes($row['credit_url']);
                                            break;

					}	
		}
	}
	return array($music,$music_id,$credit,$credit_url);


}


public function InsertMindjumbelVivekPDF($bes_id,$trigger_id,$user_title1,$user_banner_type1,$user_banner1,$user_id)

{

	$DBH = new DatabaseHandler();
	$return = false;
	 $sql = "INSERT INTO `tblsolutionitems`(`bes_id`,`trigger_id`,`sol_box_banner`,`sol_box_title`,`sol_box_type`,`sol_item_status`,`user_type`,`user_id`) VALUES ('".addslashes($bes_id)."','".addslashes($trigger_id)."','".addslashes($user_banner1)."','".addslashes($user_title1)."','".addslashes($user_banner_type1)."','0','3','".addslashes($user_id)."')";

	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
	{

		$return = true;

	}

	return $return;

}

public function InsertMindjumbelVivek($bes_id,$trigger_id,$user_title,$user_banner_type,$user_banner,$user_id)

{

	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "INSERT INTO `tblsolutionitems`(`bes_id`,`trigger_id`,`sol_box_title`,`sol_box_type`,`sol_box_banner`,`sol_item_status`,`user_type`,`user_id`) VALUES ('".addslashes($bes_id)."','".addslashes($trigger_id)."','".addslashes($user_title)."','".addslashes($user_banner_type)."','".addslashes($user_banner)."','0','3','".addslashes($user_id)."')";
        
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
	{

		$return = true;

	}

	return $return;

}

public function InsertMindJumbelAllDetailsVivek($bes_id,$trigger_id,$user_select1,$user_adv1,$fav1_comma_separated,$user_id,$comment_box)

{

	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "INSERT  INTO `tblusermjb`(`bes_id`,`trigger_id`,`user_id`,`stress_buster_box_id_1`,`fav1`,`rate1`,`comment_box`) VALUES ('".addslashes($bes_id)."','".addslashes($trigger_id)."','".$user_id."','".addslashes($user_select1)."','".addslashes($fav1_comma_separated)."','".addslashes($user_adv1)."','".addslashes($comment_box)."')";

	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
	{

		$return = true;

	}

	return $return;

}

function getTheam($day,$theam_id)

{
	$DBH = new DatabaseHandler();
	$color_code = '#339900'; 
	$image = 'images/stressbuster_back.jpg';
	$credit = '';
	$credit_url = '';
	$sql = "SELECT * FROM `tbltheams` WHERE status = '1' AND theam_id = '".$theam_id."' ORDER BY `theam_add_date` DESC";

	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$color_code = stripslashes($row['color_code']);
		$image = SITE_URL."/uploads/".stripslashes($row['image']);
		$credit = stripslashes($row['credit']);
		$credit_url = stripslashes($row['credit_url']);
	}

	return array($color_code,$image,$credit,$credit_url);



}


public function sendSignUpEmailToUser($email)
	{
            $user_data = $this->getUserDetails($email);
            if(!empty($user_data))
            {
		   
			$tdata_sms = array();
			$tdata_sms['mobile_no'] = $user_data['mobile'];
			$tdata_sms['sms_message'] = 'Dear '.$user_data['name'].', Your profile is successfully created at Wellnessway4you.com.';		
                        $this->sendSMS($tdata_sms);
                        
                        
                        $tdata_sms_otp = array();
			$tdata_sms_otp['mobile_no'] = $user_data['mobile'];
                        $otp =  $user_data['user_otp'];
			$tdata_sms_otp['sms_message'] = 'Dear '.$user_data['name'].', Your profile is successfully created at Wellnessway4you.com activate your profile using OTP: '.$otp;		
                        $this->sendSMS($tdata_sms_otp);
                        
			// SENDSMS TO VENDOR - VENDOR SIGNUP - END
			
			
			// SENDSMS TO ADMIN - VENDOR SIGNUP - START
			$tdata_sms_admin = array();
			$tdata_sms_admin['mobile_no'] = '8655018341';
			$tdata_sms_admin['sms_message'] = "Dear Admin,New Business user profile is registered with name:".$user_data['name'];
			$this->sendSMS($tdata_sms_admin);
			// SENDSMS TO ADMIN - VENDOR SIGNUP - END
                        
                        return true;
		}
	}
       
public function getUserDetails($email)
{
	$DBH = new DatabaseHandler();
	$data = array();
	$sql = "SELECT * FROM `tblusers` WHERE (`email` = '".$email."' || `mobile` = '".$email."') ";
	$STH = $DBH->query($sql);
        
        if($STH->rowCount() > 0)
            {
                $data = $STH->fetch(PDO::FETCH_ASSOC);  
            }
            
	return $data;

}


public function getUserDetailsByid($id)
{
	$DBH = new DatabaseHandler();
	$data = array();
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$id."' ";
	$STH = $DBH->query($sql);
        
        if($STH->rowCount() > 0)
            {
                $data = $STH->fetch(PDO::FETCH_ASSOC);  
            }
            
	return $data;

}

public function reSendUserOTP($tdata)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblusers` SET 
					`user_otp` = :user_otp
					 WHERE `email` = :email";
			$STH = $DBH->prepare($sql);
			$STH->execute(array(
				':user_otp' => addslashes($tdata['otp']),
				':email' => addslashes($tdata['email'])
			));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			
			return false;
		}	
		
        return $return;
    }

 public function VerifyOTP($data)
    {
        
        $DBH = new DatabaseHandler();
        $return = false;

		try {
			$sql = "SELECT * FROM `tblusers` WHERE `email` = '".addslashes($data['email'])."' AND `user_otp` = '".$data['otp']."' ";
			$STH = $DBH->query($sql);
			if($STH->rowCount() > 0)
			{
                                $this->ActivateUser($data);
				$return = true;
			}
		} catch (Exception $e) {
			$stringData = '[getVendorId] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			//$this->debuglog($stringData);
            $return = false;
        }		
        return $return;  
        
    }
    
    public function ActivateUser($data)
    {
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
		
		try {
			$sql = "UPDATE `tblusers` SET 
					`status` = :status
					 WHERE `email` = :email  ";
			$STH = $DBH->prepare($sql);
			$STH->execute(array(
				':status' => '1',
				':email' => addslashes($data['email'])
			));
			$DBH->commit();
			$return = true;
		} catch (Exception $e) {
			
			return false;
		}	
		
        return $return; 
    }
    
    public function SelectEventCountry($country_id)
    {
        $DBH = new DatabaseHandler();
        $date = Date("Y-m-d");
	$option_str = '';		
	$sql = "SELECT DISTINCT (`country_id`) FROM `tbl_event_details` WHERE `end_date` >= ".$date."  ORDER BY `country_id` ASC";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{

		while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 

		{
                        if($row['country_id'] == $country_id)
                        {
                            $sel ='selected';
                        }
                        else
                        {
                            $sel = '';
                        }
                        //<option value="Paris">Paris</option>
			$option_str .= '<option value="'.$row['country_id'].'" '.$sel.' >'.$this->GetCountryName($row['country_id']).'</option>';

		}

	}

	return $option_str;  
    }
    
    public function GetCountryName($country_id)
    {
        $DBH = new DatabaseHandler();
	$option_str = '';		
	$sql = "SELECT `country_name` FROM `tblcountry` WHERE `country_id` = ".$country_id." ";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $option_str = $row['country_name'];
		
	}

	return $option_str;  
    }
   
    public function GetEventSateOption($country_id,$state_id)
    {
     
        $DBH = new DatabaseHandler();
        $date = Date("Y-m-d");
	$option_str = '';		
	$sql = "SELECT DISTINCT (`state_id`) FROM `tbl_event_details` WHERE `country_id` = '".$country_id."'  AND `end_date` >= ".$date."  ORDER BY `state_id` ASC";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{
               $option_str .='<option value="">Select State</option>';
		while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 

		{
                    if($row['state_id'] == $state_id)
                        {
                            $sel ='selected';
                        }
                        else
                        {
                            $sel = '';
                        }
                        //<option value="Paris">Paris</option>
			$option_str .= '<option value="'.$row['state_id'].'" '.$sel.' >'.$this->GetStateName($row['state_id']).'</option>';

		}

	}

	return $option_str;   
        
    }
   
    
    public function GetStateName($state_id)
    {
        $DBH = new DatabaseHandler();
	$option_str = '';		
	$sql = "SELECT `state` FROM `tblstates` WHERE `state_id` = ".$state_id." ";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $option_str = $row['state'];
		
	}

	return $option_str;  
    }
   
    public function GetEventCityOption($country_id,$state_id,$city_id)
    {
        $DBH = new DatabaseHandler();
        $date = Date("Y-m-d");
	$option_str = '';		
	$sql = "SELECT DISTINCT (`city_id`) FROM `tbl_event_details` WHERE `country_id` = '".$country_id."' AND `state_id` = '".$state_id."'  AND `end_date` >= ".$date."  ORDER BY `city_id` ASC";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{
               $option_str .='<option value="">Select City</option>';
		while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 

		{
                        if($row['city_id'] == $city_id)
                        {
                            $sel ='selected';
                        }
                        else
                        {
                            $sel = '';
                        }
                        //<option value="Paris">Paris</option>
			$option_str .= '<option value="'.$row['city_id'].'" '.$sel.' >'.$this->GetCityName($row['city_id']).'</option>';

		}

	}

	return $option_str;     
    }
    
    public function GetCityName($city_id)
    {
        $DBH = new DatabaseHandler();
	$option_str = '';		
	$sql = "SELECT `city` FROM `tblcities` WHERE `city_id` = ".$city_id." ";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $option_str = $row['city'];
		
	}

	return $option_str; 
    }
    
    public function GetEventAreaOption($country_id,$state_id,$city_id,$area_id)
    {
        $DBH = new DatabaseHandler();
        $date = Date("Y-m-d");
	$option_str = '';		
	$sql = "SELECT DISTINCT (`area_id`) FROM `tbl_event_details` WHERE `country_id` = '".$country_id."' AND `state_id` = '".$state_id."' AND `city_id` = '".$city_id."'  AND `end_date` >= ".$date."  ORDER BY `area_id` ASC";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{
               $option_str .='<option value="">Select Area</option>';
		while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 

		{
                        if($row['area_id'] == $area_id)
                        {
                            $sel ='selected';
                        }
                        else
                        {
                            $sel = '';
                        }
                        //<option value="Paris">Paris</option>
			$option_str .= '<option value="'.$row['area_id'].'" '.$sel.' >'.$this->GetAreaName($row['area_id']).'</option>';

		}

	}

	return $option_str;    
    }
    
    public function GetAreaName($area_id)
    {
        $DBH = new DatabaseHandler();
	$option_str = '';		
	$sql = "SELECT `area_name` FROM `tblarea` WHERE `area_id` = ".$area_id." ";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $option_str = $row['area_name'];
		
	}

	return $option_str; 
    }
    
    public function GetEventDataFront($tdata)
    {
        
        $DBH = new DatabaseHandler();
        $arr_records = array();
        $tags = array();
        
        $sql_event_type = "";
        
        if($tdata['event_type'] != '')
        {
                $sql_event_type = " AND TEM.fav_cat_id_1 = '".$tdata['event_type']."' ";
        }
        
//	$sql = "SELECT TED.*,TEM.* from tbl_event_details TED "
//                        . " LEFT JOIN tbl_event_master TEM ON TED.event_master_id = TEM.event_master_id WHERE TED.event_status = 1 AND TED.event_deleted = 0 AND TED.country_id = '".$tdata['country_id']."' AND TED.state_id = '".$tdata['state_id']."' AND TED.city_id = '".$tdata['city_id']."' AND TED.area_id = '".$tdata['area_id']."' ".$sql_event_type." AND TED.end_date BETWEEN '".date("Y-m-d",strtotime($tdata['from_day_month_year']))."' AND '".date("Y-m-d",strtotime($tdata['to_day_month_year']))."' order by TED.event_id ASC";		

        
//       $sql = "SELECT TED.*,TEM.* from tbl_event_details TED "
//                        . " LEFT JOIN tbl_event_master TEM ON TED.event_master_id = TEM.event_master_id WHERE TED.event_status = 1 AND TED.event_deleted = 0 AND TED.country_id = '".$tdata['country_id']."' AND TED.state_id = '".$tdata['state_id']."' AND TED.city_id = '".$tdata['city_id']."' AND TED.area_id = '".$tdata['area_id']."' ".$sql_event_type." AND TED.end_date >= '".date("Y-m-d",strtotime($tdata['from_day_month_year']))."' AND TED.end_date <= '".date("Y-m-d",strtotime($tdata['to_day_month_year']))."'  order by TED.event_id ASC";		

//        if($tdata['upcoming_current']==2)
//        {
//        $sql = "SELECT TED.*,TEM.* from tbl_event_details TED "
//                        . " LEFT JOIN tbl_event_master TEM ON TED.event_master_id = TEM.event_master_id WHERE TED.event_status = 1 AND TED.event_deleted = 0 AND TED.country_id = '".$tdata['country_id']."' AND TED.state_id = '".$tdata['state_id']."' AND TED.city_id = '".$tdata['city_id']."' AND TED.area_id = '".$tdata['area_id']."' ".$sql_event_type." AND TED.end_date >= '".date("Y-m-d")."' AND TED.end_date <= '".date("Y-m-d",strtotime($tdata['to_day_month_year']))."'  order by TED.event_id ASC";		
//        }
//        else
//        {
//          $sql = "SELECT TED.*,TEM.* from tbl_event_details TED "
//                        . " LEFT JOIN tbl_event_master TEM ON TED.event_master_id = TEM.event_master_id WHERE TED.event_status = 1 AND TED.event_deleted = 0 AND TED.country_id = '".$tdata['country_id']."' AND TED.state_id = '".$tdata['state_id']."' AND TED.city_id = '".$tdata['city_id']."' AND TED.area_id = '".$tdata['area_id']."' ".$sql_event_type." AND '".date("Y-m-d")."' BETWEEN TED.start_date AND TED.end_date  order by TED.event_id ASC";		  
//        }
        
//        echo $sql = "SELECT TED.*,TETT.* from tbl_event_details TED "
//                        ." LEFT JOIN tbl_event_time_table TETT ON TED.event_master_id = TETT.event_master_id"
//                        ." WHERE TED.event_status = 1 AND TED.event_deleted = 0 AND TED.country_id = '".$tdata['country_id']."' AND TED.state_id = '".$tdata['state_id']."' AND TED.city_id = '".$tdata['city_id']."' AND TED.area_id = '".$tdata['area_id']."' ".$sql_event_type." AND TETT.event_start_date BETWEEN '".date("Y-m-d",strtotime($tdata['from_day_month_year']))."' AND '".date("Y-m-d",strtotime($tdata['to_day_month_year']))."' order by TETT.event_id ASC";		  
//        
        
        $sql = "SELECT TETT.*,TED.*,TEM.* from tbl_event_time_table TETT "
                        ." LEFT JOIN tbl_event_details TED ON TETT.event_id = TED.event_id"
                        ." LEFT JOIN tbl_event_master TEM ON TETT.event_master_id = TEM.event_master_id"
                        ." WHERE TED.event_status = 1 AND TED.event_deleted = 0 AND TED.country_id = '".$tdata['country_id']."' AND TED.state_id = '".$tdata['state_id']."' AND TED.city_id = '".$tdata['city_id']."' AND TED.area_id = '".$tdata['area_id']."' ".$sql_event_type." AND TETT.event_start_date BETWEEN '".date("Y-m-d",strtotime($tdata['from_day_month_year']))."' AND '".date("Y-m-d",strtotime($tdata['to_day_month_year']))."' GROUP BY TETT.event_id order by TETT.event_id ASC";		  
        
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            while($r= $STH->fetch(PDO::FETCH_ASSOC))
            {
                    $arr_records[] = $r;
                   // $tags[]=$r['event_tags'];
            }
        }	
        //$arr_records['fianl_tags'] = $tags;
        return $arr_records;  
        
    }
    
    public function getEventType($fav_cat_type_id)
	{
            $DBH = new DatabaseHandler();
            $data = array();		
            
            $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$fav_cat_type_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
            //echo $sql;
            $STH = $DBH->query($sql);
            if( $STH->rowCount() > 0 )
            {
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                   $data[] = $row;
                   
                }
            }
            //echo $option_str;
           
            
            return $data;
	}
        
        public function getEventTypebyid($fav_cat_type_id,$event_type)
	{
            $DBH = new DatabaseHandler();
            $data = array();		
            
            $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$fav_cat_type_id."' AND tblfavcategory.fav_cat_id = '".$event_type."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
            //echo $sql;
            $STH = $DBH->query($sql);
            if( $STH->rowCount() > 0 )
            {
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                   $data[] = $row;
                }
            }
            //echo $option_str;
            
            return $data;
	}
    
      public function GetEventDetailsbyID($event_id)
      {
        $DBH = new DatabaseHandler();
        $arr_records = array();
        
	$sql = "SELECT TED.*,TEM.* from tbl_event_details TED "
                        ." LEFT JOIN tbl_event_master TEM ON TED.event_master_id = TEM.event_master_id WHERE TED.event_status = 1 AND TED.event_deleted = 0 AND TED.event_id = '".$event_id."' order by TED.event_id ASC";		

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $r= $STH->fetch(PDO::FETCH_ASSOC);
            $arr_records = $r;
        }	
       
        return $arr_records;   
      }
      
      public function GetEventTicketDetails($event_id)
      {
            $DBH = new DatabaseHandler();
            $arr_records = array();

            $sql = "SELECT EP.*,ELP.* from tbl_event_price EP "
                        ." LEFT JOIN tbl_event_loc_price ELP ON EP.event_price_id = ELP.event_price_id WHERE EP.event_id = ".$event_id." AND EP.event_deleted = 0 AND EP.event_price_status = '1' order by ELP.evlocprice_id ASC";		
           
            $STH = $DBH->query($sql);
            if( $STH->rowCount() > 0 )
            {
                 while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                   $arr_records[] = $row;
                }
            }	

            return $arr_records;    
      }
      
      public function GetEventRegistrationType($event_id)
      {
            $DBH = new DatabaseHandler();
            $arr_records = array();

           $sql = "SELECT EP.*,ELP.* from tbl_event_price EP "
                        ." LEFT JOIN tbl_event_loc_price ELP ON EP.event_price_id = ELP.event_price_id WHERE EP.event_id = ".$event_id." AND EP.event_deleted = 0 AND EP.event_price_status = '1' order by ELP.evlocprice_id ASC";		
           
            $STH = $DBH->query($sql);
            if( $STH->rowCount() > 0 )
            {
                 while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                   $arr_records[] = $row['registration_type'];
                }
            }	

            return $arr_records;     
      }
      
      public function GetEventTicketType($event_id)
      {
            $DBH = new DatabaseHandler();
            $arr_records = array();

           $sql = "SELECT EP.*,ELP.* from tbl_event_price EP "
                        ." LEFT JOIN tbl_event_loc_price ELP ON EP.event_price_id = ELP.event_price_id WHERE EP.event_id = ".$event_id." AND EP.event_deleted = 0 AND EP.event_price_status = '1' order by ELP.evlocprice_id ASC";		
           
            $STH = $DBH->query($sql);
            if( $STH->rowCount() > 0 )
            {
                 while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                   $arr_records[] = $row['ordering_type_id'];
                }
            }	

            return $arr_records;     
      }
      
      public function GetCertificateDetailsbyID($event_id)
      {
            $DBH = new DatabaseHandler();
            $arr_records = array();

            $sql = "SELECT * from `tbl_event_certificates` where `event_id` = '".$event_id."' ";		
           
            $STH = $DBH->query($sql);
            if( $STH->rowCount() > 0 )
            {
                 while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                   $arr_records[] = $row;
                }
            }	

            return $arr_records;    
      }
      
      public function getCommaSeperatedfavcat($fav_id_str)
        {
            //$this->connectDB();
            $DBH = new DatabaseHandler();
            $output = '';
            
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_status` = '1' AND `fav_cat_deleted` = '0' AND `fav_cat_id` IN (".$fav_id_str.") ORDER BY `fav_cat` ASC";    
           // $this->execute_query($sql);
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {
                while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                {
                    $page_name = stripslashes($row['fav_cat']);
                    $output .= $page_name.' ,';
                }
                $output = substr($output,0,-1);
            }
            return $output;
        }
        
        public function GetRegistratiotypeoption($registration_type) {
         
        $symtum_cat = implode(',', $registration_type);
        $DBH = new DatabaseHandler();
	$option_str = '';
	$sql = "SELECT * FROM `tblfavcategory` WHERE fav_cat_id IN($symtum_cat) ORDER BY `fav_cat` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {			
                $option_str .= '<option value="'.$row['fav_cat_id'].'" >'.stripslashes($row['fav_cat']).'</option>';

            }
	}
	return $option_str;    
            
        }
        
        public function GetEventRegistrationfess($event_id,$registration_type)
        {           
            $DBH = new DatabaseHandler();
            $option_str = '';
            $sql = "SELECT * FROM `tbl_event_loc_price` WHERE `event_id` = '".$event_id."' and `registration_type` ='".$registration_type."' ORDER BY `evlocprice_id` ASC";
            $STH = $DBH->query($sql);
            if( $STH->rowCount() > 0 )
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $option_str = $row['registration_fees'];
            }
            return $option_str; 
        }
        
        public function GetEventTicketfess($event_id,$ticket_type)
        {           
            $DBH = new DatabaseHandler();
            $option_str = '';
            $sql = "SELECT * FROM `tbl_event_loc_price` WHERE `event_id` = '".$event_id."' and `ordering_type_id` ='".$ticket_type."' ORDER BY `evlocprice_id` ASC";
            $STH = $DBH->query($sql);
            if( $STH->rowCount() > 0 )
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $option_str = $row['cusine_price'];
            }
            return $option_str; 
        }
        
        public function GetParticipantsHeight($height_id)
        {           
            $DBH = new DatabaseHandler();
            $option_str = '';
            $sql = "SELECT * FROM `tblheights` WHERE `height_id` = '".$height_id."' ";
            $STH = $DBH->query($sql);
            if( $STH->rowCount() > 0 )
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $option_str = $row['height_cms'].'Cms ('.$row['height_feet_inch'].')';
            }
            return $option_str; 
        }
        
        public function GetEventTicketQty($event_id,$ticket_type)
        {           
            $DBH = new DatabaseHandler();
            $option_str = '';
            $sql = "SELECT * FROM `tbl_event_loc_price` WHERE `event_id` = '".$event_id."' and `ordering_type_id` ='".$ticket_type."' ORDER BY `evlocprice_id` ASC";
            $STH = $DBH->query($sql);
            if( $STH->rowCount() > 0 )
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $option_str .='<select name="ticket_qty" id="ticket_qty">';
                for($i=$row['min_order'];$i<=$row['max_order'];$i++)
                {
                  $option_str .= '<option value="'.$i.'" >'.$i.'</option>';  
                }
                $option_str .='</select>';
            }
            return $option_str; 
        }

public function getAllDelaveryListOfItem($event_id)
		{
		$DBH = new DatabaseHandler();
		$output = array();
		
		try {
			//echo $sql ="SELECT * FROM `tbl_event_details` WHERE 1 AND event_deleted = '0' AND event_status = '1' AND event_id='".$event_id."' ";			
			$sql ="SELECT ED.*,EP.* FROM tbl_event_details ED "
                                . "LEFT JOIN tbl_event_price EP ON ED.event_id = EP.event_id WHERE ED.event_id = '".$event_id."' AND ED.event_deleted = '0' AND ED.event_status = '1' ";			
			// $sql = "SELECT EP.*,ELP.* from tbl_event_price EP "
                       // ." LEFT JOIN tbl_event_loc_price ELP ON EP.event_price_id = ELP.event_price_id WHERE EP.event_id = ".$event_id." AND EP.event_deleted = 0 AND EP.event_price_status = '1' order by ELP.evlocprice_id ASC";		

                        
                        //$this->debuglog('[getLatestDeliveryDatesOfLocation] sql:'.$sql);
			//echo '<br><br>sql:'.$sql.'<br>';
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
				{
                                
				$r= $STH->fetch(PDO::FETCH_ASSOC);
				//
				$order_cutoff_time=$r['registration_cutoff_time'];	
				//
				$event_id=$r['event_id'];	
				//
			        $temp_date = date('Y-m-d');
				
                                $date1=date_create($r['start_date']);
                                $date2=date_create($r['end_date']);
                                $diff=date_diff($date1,$date2);
                                $date_loop = $diff->format("%a");
                                $show_date = array();
                                for($i=0;$i<=$date_loop;$i++)
                                {
                                    $show_date[] = date("Y-m-d",strtotime($r['start_date'].' + '.$i.' days'));
                                  
                                }
                                
                                $time_slot = array();
                                $time_slot['slot1_start_time'] = $r['slot1_start_time'];
                                $time_slot['slot1_end_time'] = $r['slot1_end_time'];
                                $time_slot['slot2_start_time'] = $r['slot2_start_time'];
                                $time_slot['slot2_end_time'] = $r['slot2_end_time'];
                                $time_slot['slot3_start_time'] = $r['slot3_start_time'];
                                $time_slot['slot3_end_time'] = $r['slot3_end_time'];
                                $time_slot['slot4_start_time'] = $r['slot4_start_time'];
                                $time_slot['slot4_end_time'] = $r['slot4_end_time'];
                                $time_slot['slot5_start_time'] = $r['slot5_start_time'];
                                $time_slot['slot5_end_time'] = $r['slot5_end_time'];
                                $time_slot['slot6_start_time'] = $r['slot6_start_time'];
                                $time_slot['slot6_end_time'] = $r['slot6_end_time'];
			}
			
			
			$output['delavery_date'] = $show_date;
                        $output['start_time'] = $r['start_time'];
                        $output['end_time'] =   $r['end_time'];
                        $output['time_slot'] =  $time_slot;
			$output['registration_cutoff_time']=$order_cutoff_time;
			$output['event_id']=$event_id;
			//
//			echo '<br><pre>';
//			print_r($output);
//			echo '<br></pre>';
			return $output;	
		} catch (Exception $e) {
			$stringData = '[getLatestDeliveryDatesOfLocation] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	
		
	}        
        
public function chkIfTicketQtyAvailable($event_id,$qty,$type='')
    {
        $DBH = new DatabaseHandler();
        $return = false;

                if($type == 'Registraion')
                {
                    $return = true;
                }
                else
                {
                    try {
                           echo $sql = "SELECT * FROM `tbl_event_loc_price` WHERE `event_id` = '".$event_id."' AND `culoc_status` = '1' AND `culoc_deleted` = '0' ";
                            $STH = $DBH->query($sql);
                            if( $STH->rowCount() > 0 )
                            {
                                    $r = $STH->fetch(PDO::FETCH_ASSOC);
                                    $cusine_qty = $r['available_qty'];

                                    if($cusine_qty > 0 && $qty > 0 && $cusine_qty >= $qty)
                                    {
                                            $return = true;
                                    }
                            }
                    } catch (Exception $e) {
                            $stringData = '[chkIfCusineQtyAvailable] Catch Error:'.$e->getMessage().', sql:'.$sql;
                            $this->debuglog($stringData);
                            return false;
                    }
                }
        return $return;
    }
    
    public function chkIfValidDate($date)
	{
		$d = DateTime::createFromFormat('Y-m-d', $date);
		return $d && $d->format('Y-m-d') === $date;
	}
        
        public function getWeekDayName($day_of_week)
	{
		$output = '';
		
		$arr_day = array( 	"1" => "Monday",
							"2" => "Tuesday",
							"3" => "Wednesday",
							"4" => "Thursday",
							"5" => "Friday",
							"6" => "Saturday",
							"7" => "Sunday"
						);
		if($day_of_week != '')
		{
			$output = $arr_day[$day_of_week];	
		}			
		
		return $output;
	}
        
public function addToCart($event_id,$qty,$booking_slot,$booking_date,$booking_type,$ticket_type)
    {
		$my_DBH = new DatabaseHandler();
                $return = false;
		$cart_session_id = session_id();
		
                
                echo '$event_id=>'.$event_id;
                echo '<br>';
                echo '$qty=>'.$qty;
                echo '<br>';
                echo '$booking_slot=>'.$booking_slot;
                echo '<br>';
                echo '$booking_date=>'.$booking_date;
                echo '<br>';
                echo '$booking_type=>'.$booking_type;
                echo '<br>';
                echo '$ticket_type=>'.$ticket_type;
                
                
		
		if($this->isLoggedIn())
		{
			$user_id = $_SESSION['user_id'];
		}
		else
		{
			$user_id = 0;
		}

		if($this->chkIfTicketQtyAvailable($event_id,$qty,$booking_type))
		{
			if(isset($_SESSION['current_showing_date']) && $_SESSION['current_showing_date'] != '')
			{
				$current_showing_date = $_SESSION['current_showing_date'];
			}
			else
			{
				$current_showing_date = '';
			}
			
                        
                        
                        if($booking_type == 'Registraion')
                        {
                          $arr_event_details = $this->GetEventDetailsRegistrationCart($event_id,$ticket_type);  
                        }
                        else
                        {
                            $arr_event_details = $this->GetEventDetailsTicketCart($event_id,$ticket_type);  
                        }
                        
                        
			
			
			if($this->chkIfOfferEvent($event_id))
			{
				$is_offer = 1;
				$offer_price = $arr_event_details['offer_price'];
			}
			else
			{
				$is_offer = 0;
				$offer_price = '';
			}
			
			 $sql = "SELECT * FROM `tblcart` WHERE 
					`cart_session_id` = '".$cart_session_id."' AND 
					`cusine_id` = '".$event_id."' AND 
					`cart_delivery_date` = '".$booking_date."' AND 
					`booking_slot` = '".$booking_slot."' AND 
					`cart_status` = '0' AND 
                                        `booking_type` = '".$booking_type."' AND
                                        `ticket_type` = '".$ticket_type."' AND
					`cart_deleted` = '0' ";
                        
                        //die();
			$STH = $my_DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				$r = $STH->fetch(PDO::FETCH_ASSOC);
				$old_qty = $r['qty'];
				$qty = $qty + $old_qty;
		
				if($this->chkIfTicketQtyAvailable($event_id,$qty,$booking_type))
				{
					$DBH = $my_DBH->raw_handle();
					$DBH->beginTransaction();	
					if($booking_type == 'Registraion')
                                        {
                                           $price = $arr_event_details['registration_fees']; 
                                        }
                                        else
                                        {
                                            $price = $arr_event_details['cusine_price'];
                                        }
                                        
					if($is_offer == '1')
					{
						$subtotal = $offer_price * $qty;
					}
					else
					{
						$subtotal = $price * $qty;	
					}
					
					
					try {
						$sql = "UPDATE `tblcart` SET 
								`qty` = :qty,
								`price` = :price,
								`subtotal` = :subtotal,
								`is_offer` = :is_offer,
								`offer_price` = :offer_price,
								`cart_add_date` = :cart_add_date
								WHERE 		
								`cart_session_id` = :cart_session_id AND 
								`cart_delivery_date` = :cart_delivery_date AND 
								`booking_slot` = :booking_slot AND
                                                                `booking_type` = :booking_type AND 
                                                                `ticket_type` = :ticket_type AND 
								`cusine_id` = :cusine_id ";
						$STH = $DBH->prepare($sql);
						$STH->execute(array(
							':qty' => addslashes($qty),
							':price' => addslashes($price),
							':subtotal' => addslashes($subtotal),
							':is_offer' => addslashes($is_offer),
							':offer_price' => addslashes($offer_price),
							':cart_add_date' => date('Y-m-d H:i:s'),
							':cart_session_id' => addslashes($cart_session_id),
							':cart_delivery_date' => addslashes($booking_date),
							':booking_slot' => addslashes($booking_slot),
                                                        ':booking_type' => addslashes($booking_type),
                                                        ':ticket_type' => addslashes($ticket_type),
							':cusine_id' => addslashes($event_id)
							
						));
						$DBH->commit();
						$return = true;
					} catch (Exception $e) {
						$stringData = '[addToCart] Catch Error:'.$e->getMessage().', sql:'.$sql;
						$this->debuglog($stringData);
						return false;
					}
				}	
			}
			else
			{
				$DBH = $my_DBH->raw_handle();
				$DBH->beginTransaction();	
				
				if($booking_type == 'Registraion')
                                    {
                                       $price = $arr_event_details['registration_fees']; 
                                       $qty = '1';
                                    }
                                    else
                                    {
                                        $price = $arr_event_details['cusine_price'];
                                        
                                        if($qty < $arr_event_details['min_order'])
                                            {
                                                    $qty = $arr_event_details['min_order'];
                                            }
                                            elseif($qty > $arr_event_details['max_order'])
                                            {
                                                    $qty = $arr_event_details['max_order'];
                                            }
                                        
                                    }
				
				
				
				if($this->chkIfTicketQtyAvailable($event_id,$qty,$booking_type))
				{
					if($is_offer == '1')
					{
						$subtotal = $offer_price * $qty;
					}
					else
					{
						$subtotal = $price * $qty;	
					}
					
					try {
						$sql = "INSERT INTO `tblcart` (`cart_session_id`,`cusine_id`,`user_id`,`qty`,`price`,`subtotal`,`currency_id`,
								`cart_status`,`cart_add_date`,`cart_delivery_date`,`booking_slot`,`booking_type`,`is_offer`,`offer_price`,`ticket_type`) 
								VALUES (:cart_session_id,:cusine_id,:user_id,:qty,:price,:subtotal,:currency_id,
								:cart_status,:cart_add_date,:cart_delivery_date,:booking_slot,:booking_type,:is_offer,:offer_price,:ticket_type)";
						//$sql;
                                                $STH = $DBH->prepare($sql);
						$STH->execute(array(
							':cart_session_id' => addslashes($cart_session_id),
							':cusine_id' => addslashes($event_id),
							':user_id' => addslashes($user_id),
							':qty' => addslashes($qty),
							':price' => addslashes($price),
							':subtotal' => addslashes($subtotal),
							':currency_id' => addslashes($arr_event_details['currency_id']),
							':cart_status' => 0,
							':cart_add_date' => date('Y-m-d H:i:s'),
							':cart_delivery_date' => addslashes($booking_date),
							':booking_slot' => addslashes($booking_slot),
							':booking_type' => addslashes($booking_type),
                                                        ':ticket_type' => addslashes($ticket_type),
							':is_offer' => addslashes($is_offer),
							':offer_price' => addslashes($offer_price)
						));
						$cart_id = $DBH->lastInsertId();
						$this->debuglog('[addToCart] lastInsertId'.$cart_id);
						$DBH->commit();
						
						//if($cart_id > 0)
						//{
							$return = true;
						//}
						
					} catch (Exception $e) {
						$stringData = '[addToCart] Catch Error:'.$e->getMessage().', sql:'.$sql;
						$this->debuglog($stringData);
						return false;
					}
				}	
			}	
		}
        
        return $return;
    }
  
  public function chkIfOfferEvent($event_id)
    {
        $arr_event_records = $this->GetEventDetailsbyID($event_id);

		$offer_item_flag = false;
		$today_day_of_month = date('j');
		$today_day_of_week = date('N');
		$today_single_date = date('Y-m-d');
		if($arr_event_records['is_offer'] == '1')
		{
			if($arr_event_records['offer_date_type'] == 'days_of_month')
			{
				if($arr_event_records['offer_days_of_month'] == '-1')
				{
					$offer_item_flag = true;	
				}	
				else
				{
					$temp_ofr_dom = explode(',',$arr_event_records['offer_days_of_month']);
					if(in_array($today_day_of_month,$temp_ofr_dom))
					{
						$offer_item_flag = true;		
					}
				}
			}
			elseif($arr_event_records['offer_date_type'] == 'days_of_week')
			{
				if($arr_event_records['offer_days_of_week'] == '-1')
				{
					$offer_item_flag = true;	
				}	
				else
				{
					$temp_ofr_dow = explode(',',$arr_event_records['offer_days_of_week']);
					if(in_array($today_day_of_week,$temp_ofr_dow))
					{
						$offer_item_flag = true;		
					}
				}
			}
			elseif($arr_event_records['offer_date_type'] == 'single_date')
			{
				if($arr_event_records['offer_single_date'] == $today_single_date)
				{
					$offer_item_flag = true;	
				}	
			}
			elseif($arr_event_records['offer_date_type'] == 'date_range')
			{
				$temp_ts_today = strtotime($today_single_date);
				$temp_ts_start = strtotime($arr_event_records['offer_single_date']);
				$temp_ts_end = strtotime($arr_event_records['offer_end_date']);
				if($temp_ts_start <= $temp_ts_today && $temp_ts_end >= $temp_ts_today)
				{
					$offer_item_flag = true;	
				}	
			}
		}
        return $offer_item_flag;
    }
    
    public function GetEventDetailsRegistrationCart($event_id,$ticket_type)
    {
     
        $DBH = new DatabaseHandler();
		$output = array();
		
		try {
			//echo $sql ="SELECT * FROM `tbl_event_details` WHERE 1 AND event_deleted = '0' AND event_status = '1' AND event_id='".$event_id."' ";			
                         $sql ="SELECT * FROM tbl_event_loc_price"
                                . " WHERE event_id = '".$event_id."' and `registration_type` = '".$ticket_type."' and `culoc_status` = 1 and `culoc_deleted` = 0 ";			
			
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
				{
                                
				$r= $STH->fetch(PDO::FETCH_ASSOC);
				$output = $r;
			}
			
			return $output;	
		} catch (Exception $e) {
			$stringData = '[getLatestDeliveryDatesOfLocation] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	   
        
        
    }
    
    public function GetEventDetailsTicketCart($event_id,$ticket_type)
    {
     
        $DBH = new DatabaseHandler();
		$output = array();
		
		try {
			//echo $sql ="SELECT * FROM `tbl_event_details` WHERE 1 AND event_deleted = '0' AND event_status = '1' AND event_id='".$event_id."' ";			
			$sql ="SELECT * FROM tbl_event_loc_price"
                                . "WHERE event_id = '".$event_id."' and `ordering_type_id` = '".$ticket_type."' and `culoc_status` = 1 and `culoc_deleted` = 0 ";			
			
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
				{
                                
				$r= $STH->fetch(PDO::FETCH_ASSOC);
				$output = $r;
			}
			
			return $output;	
		} catch (Exception $e) {
			$stringData = '[getLatestDeliveryDatesOfLocation] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
			return $output;
		}	   
        
        
    }
    
public function getmydaytodaysequenceentry($mdtdate,$user_id)
{
    $DBH = new DatabaseHandler();
    //$start_date = $mdtdate.' 00:00:00';
   // $end_date = $mdtdate.' 59:59:59';
    $sequence = 0;
    $sql = "SELECT sequence_show FROM `tblusersmdt` WHERE  user_id = '$user_id' and `mdt_date` = '".$mdtdate."' ORDER BY mdt_add_date DESC LIMIT 1 ";		
    $STH = $DBH->query($sql);
    if( $STH->rowCount() > 0 )
    {
        $row = $STH->fetch(PDO::FETCH_ASSOC);
        $sequence = $row['sequence_show'];
    }
    return $sequence;   
    
    
}

public function GetDesignMyLifeDatabyRef($ref_num) {
    
    $DBH = new DatabaseHandler();
    $data = array();
    $sql = "SELECT * FROM `tbl_design_your_life` WHERE  ref_code = '$ref_num' and `status` = '1' ";		
    $STH = $DBH->query($sql);
    if( $STH->rowCount() > 0 )
    {
        $row = $STH->fetch(PDO::FETCH_ASSOC);
        $data = $row;
    }
    return $data;    
    
}

public function GetTitlenamebyID($box_title)
{
    $DBH = new DatabaseHandler();
    $name = '';
    $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE bms_id ='".$box_title."' ORDER BY `bms_name` ASC";
    $STH = $DBH->query($sql);
    if( $STH->rowCount() > 0 )
    {
        $row = $STH->fetch(PDO::FETCH_ASSOC);
        $name = $row['bms_name'];
    }
    return $name;   
    
    
}

public function GetProfilecatname($prct_cat_id)
{
    $DBH = new DatabaseHandler();
    $name = '';
    $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_status` = '1' AND `prct_cat_deleted` = '0' and `prct_cat_id` = '".$prct_cat_id."' ORDER BY `prct_cat` ASC";
    $STH = $DBH->query($sql);
    if( $STH->rowCount() > 0 )
    {
        $row = $STH->fetch(PDO::FETCH_ASSOC);
        $name = $row['prct_cat'];
    }
    return $name;   
    
    
}

public function getSubCatOptions($prof_cat,$sub_cat)

{

	$DBH = new DatabaseHandler();
	$option_str = '';		
        $sql = "SELECT * FROM `tblcustomfavcategory` "
                ."LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$prof_cat."' and tblfavcategory.fav_cat_id IN(".$sub_cat.") and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{

		while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 

		{	
                        
			$option_str .= '<option value="'.$row['fav_cat_id'].'" >'.stripslashes($row['fav_cat']).'</option>';

		}

	}

	return $option_str;

}

public function getDayOfWeekOptionsMultiple($day_of_week)

{

    $option_str = '';
    $arr_day_of_week = array (

        1 => 'Sunday',

        2 => 'Monday',

        3 => 'Tuesday',

        4 => 'Wednesday',

        5 => 'Thursday',

        6 => 'Friday',

        7 => 'Saturday'

    );

    foreach($arr_day_of_week as $k => $v )

    {

            if(in_array($k ,$day_of_week))

            {

                $selected = ' selected ';

            }

            else

            {

                $selected = '';

            }

            $option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';

    }	

    return $option_str;

}


public function getMonthsOptionsMultiple($arr_month)

{

    

    $option_str = '';

    

    $arr_record = array (

        1 => 'January',

        2 => 'February',

        3 => 'March',

        4 => 'April',

        5 => 'May',

        6 => 'June',

        7 => 'July',

        8 => 'August',

        9 => 'September',

        10 => 'October',

        11 => 'November',

        12 => 'December'

    );



    foreach($arr_record as $k => $v )

    {

            if(in_array($k ,$arr_month))

            {

                $selected = ' selected ';

            }

            else

            {

                $selected = '';

            }

            $option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';

    }	

    return $option_str;

}
 
public function GetSliderCount()

{

	$DBH = new DatabaseHandler();
	$count = '0';
	$sql = "SELECT * FROM `tblparentsliders`";
	
        $STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{

		//$row = $STH->fetch(PDO::FETCH_ASSOC);
               $count=  $STH->rowCount();

	}
        
	

	return $count;

}

public function getSlidersCode()

{

	$DBH = new DatabaseHandler();

	$output = '';
	$arr_parents_slider_id = array();
	$arr_slider_name = array();
	$arr_output = array();
	$sql1 = "SELECT * FROM `tblparentsliders` ORDER BY `parent_slider_add_date` ASC ";
	$STH = $DBH->query($sql1);
	if($STH->rowCount() > 0)
	{
		$return = true;
		$i = 1;
		while ($row1 = $STH->fetch(PDO::FETCH_ASSOC)) 

		{

			array_push($arr_parents_slider_id , $row['parents_slider_id']);

			array_push($arr_slider_name , $row['slider_name']);

	

	    	$sql = "SELECT * FROM `tblslidercontents` WHERE `parents_slider_id` = '".$row1['parents_slider_id']."' ORDER BY `slider_add_date` DESC ";

			

			$STH = $DBH->query($sql);
                        if($STH->rowCount() > 0)
                        {

				$output = '<table width="160" border="0" cellpadding="0" cellspacing="1" bgcolor="#666666">';

				$output .= '	<tr>';

				$output .= '		<td height="30" align="left" valign="middle" class="Header_white" style="background-image:url(images/back2.jpg); padding-left:10px;">'.$row1['slider_name'].'</td>';

				$output .= '	</tr>';

				$output .= '	<tr>';

				$output .= '		<td align="left" valign="top" bgcolor="#FFFFFF" class="slider">';

				$output .= '			<div id="slider'.$i.'" >';

				$i = $i+1;

				

				while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

				{

					$slider_desc = stripslashes($row['slider_desc']);

					if(strlen($slider_desc) > 50)

					{

						$slider_desc = substr($slider_desc,0,47);

						$slider_desc = $slider_desc.'...<a class="slider_title" target="_blank" href="'.stripslashes($row['slider_link']).'">More</a>';

					}

				

				$output .= '<div style="height:100px;">';

				

				$output .= '			<table width="150" border="0" cellspacing="0" cellpadding="0">';

				$output .= '				<tr>';

				$output .= '					<td height="30" colspan="2" align="left" valign="top" style="padding-left:10px;"><a target="_blank" class="slider_title" href="'.stripslashes($row['slider_link']).'"><strong>'.stripslashes($row['slider_title']).'</strong></a></td>';

				$output .= '				</tr>';

				$output .= '				<tr>';

				$output .= '					<td width="60" height="60" align="left" valign="top">';

				$output .= '						<table width="50" border="0" cellspacing="0" cellpadding="0">';

				$output .= '							<tr>';

				$output .= '								<td align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:10px;"><a target="_blank" href="'.stripslashes($row['slider_link']).'"><img border="0" width="50" src="'.SITE_URL.'/uploads/'.stripslashes($row['slider_image']).'" /></a></td>';

				$output .= '							</tr>';

				$output .= '						</table>';

				$output .= '					</td>';

				$output .= '					<td width="90" height="60" align="left" valign="top" style="padding-left:3px;">'.$slider_desc.'</td>';

				$output .= '				</tr>';

				//$output .= '				<tr>';

				//$output .= '					<td colspan="2">&nbsp;</td>';

				//$output .= '				</tr>';

				$output .= '			</table>';

				

				$output .= '</div>';

				

				}

				

				$output .= '			</div>';

				

				

				$output .= '		</td>';

				$output .= '	</tr>';

				$output .= '</table>';

				

			    array_push($arr_output , $output);

				

				

			}

 		 }

		 

							$cols = 3;

							$count = count($arr_output);

							

							if($count%$cols > 0){

							for($i=0;$i<($cols-$count%$cols);$i++){

							$arr_output[] = '&nbsp;';

							}

							}

			$new_output = '<table width="100%" cellpadding="5" cellspacing="0" border="0">';

							

							foreach($arr_output as $key => $td){

							if($key%$cols == 0) 

			$new_output .=	'<tr>';

			$new_output .= 		'<td valign="top" align="left">'.$td.'</td>';

							if($key%$cols == ($cols - 1)) 

			$new_output .=	'</tr>';

							}

			$new_output .= '</table>'; 

  }

	return $new_output;	

}

function getUserDetailsVivek($user_id)

{

	$DBH = new DatabaseHandler();

	$return = false;

	$name = '';
        
        $middle_name = '';
        
        $last_name = '';

	$email = '';

	$dob = '';

	$height = '';

	$weight = '';

	$sex = '';

	$mobile = '';

	$state_id = '';

	$city_id = '';

	$place_id = '';

	$food_veg_nonveg = '';

	$beef = '';

	$pork = '';

	$practitioner_id = '';

	$country_id = '';

		

	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' ";

	//echo'<br>'.$sql;

	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

		//$row = mysql_fetch_array($result);
                
                
                $row = $STH->fetch(PDO::FETCH_ASSOC);

		$return = true;
		$name = stripslashes($row['name']);
                $middle_name = stripslashes($row['middle_name']);
                $last_name = stripslashes($row['last_name']);
		$email = $row['email'];
		$dob = $row['dob'];
		$height = stripslashes($row['height']);
		$weight = stripslashes($row['weight']);
		$sex = $row['sex'];
		$mobile = stripslashes($row['mobile']);
		$state_id = $row['state_id'];
		$city_id = $row['city_id'];
		$place_id = $row['place_id'];
		$food_veg_nonveg = stripslashes($row['food_veg_nonveg']);
		$beef = $row['beef'];
		$pork = $row['pork'];
		$practitioner_id = stripslashes($row['practitioner_id']);
		$country_id = $row['country_id'];

	}

	return array($return,$name,$middle_name,$last_name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$practitioner_id,$country_id);

}


public function getMonthOptions($month,$start_month='1',$end_month='12')

{

	$arr_month = array (

		1 => 'January',

		2 => 'February',

		3 => 'March',

		4 => 'April',

		5 => 'May',

		6 => 'June',

		7 => 'July',

		8 => 'August',

		9 => 'September',

		10 => 'October',

		11 => 'November',

		12 => 'December'

	);

	

	$start_month = intval($start_month);

	$end_month = intval($end_month);

	$month = intval($month);



	$option_str = '';

	//echo '<br>start_month = '.$start_month.' , end_month = '.$end_month.' , month = '.$month;

	if($start_month == 12 && $end_month == 1)

	{

		if($month == 12)

		{

			$selected = ' selected ';

		}

		else

		{

			$selected = '';

		}

		$option_str .= '<option value="12" '.$selected.' >December</option>';

		

		if($month == 1)

		{

			$selected = ' selected ';

		}

		else

		{

			$selected = '';

		}

		$option_str .= '<option value="1" '.$selected.' >January</option>';

	}

	else

	{

		foreach($arr_month as $k => $v )

		{

			//echo '<br>k = '.$k.' , start_month = '.$start_month.' , end_month = '.$end_month.' , month = '.$month;

			if( ( $k >= $start_month ) && ( $k <= $end_month ) )

			{

				if($k == $month)

				{

					$selected = ' selected ';

				}

				else

				{

					$selected = '';

				}

				$option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';

			}	

		}	

	}	

	return $option_str;

}

public function getHeightOptions($height_id)

{

	$DBH = new DatabaseHandler();
	$option_str = '';		
	$sql = "SELECT * FROM `tblheights` ORDER BY `height_cms` ASC";
	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

		while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 
		{
			if($row['height_id'] == $height_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['height_id'].'" '.$sel.'>'.$row['height_cms'].' cms ('.$row['height_feet_inch'].' feet)</option>';
		}
	}
	return $option_str;

}

public function getCountryOptions($country_id)
{
	$DBH = new DatabaseHandler();
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblcountry` ORDER BY `country_name` ASC";
	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

		while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 
		{
			if($row['country_id'] == $country_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['country_id'].'" '.$sel.'>'.stripslashes($row['country_name']).'</option>';
		}
	}
	return $option_str;
}

public function getStateOptions($country_id,$state_id)
{
	$DBH = new DatabaseHandler();
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblstates` WHERE `country_id` = '".$country_id."' ORDER BY `state` ASC";
	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

		while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 
		{
			if($row['state_id'] == $state_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['state_id'].'" '.$sel.'>'.stripslashes($row['state']).'</option>';
		}
	}
	return $option_str;
}

public function getCountryOption($country_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $country_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Countries</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Countries</option>';
			}
			
		}
		else
		{
			$output .= '<option value="" >Select Country</option>';
		}
		
		try {
			$sql = "SELECT country_id,country_name FROM `tblcountry` WHERE `country_deleted` = '0' ORDER BY country_name ASC";	
			$STH = $DBH->query($sql);
			if( $STH->rowCount() > 0 )
			{
				while($r= $STH->fetch(PDO::FETCH_ASSOC))
				{
					if($multiple == '1')
					{
						if(in_array($r['country_id'], $country_id))
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
						if($r['country_id'] == $country_id )
						{
							$selected = ' selected ';	
						}
						else
						{
							$selected = '';	
						}
					}
					
					$output .= '<option value="'.$r['country_id'].'" '.$selected.'>'.stripslashes($r['country_name']).'</option>';
				}
			}
		} catch (Exception $e) {
			$stringData = '[getCountryOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
			$this->debuglog($stringData);
            return $output;
        }		
		return $output;
	}

public function getStateOption($country_id,$state_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $state_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All States</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All States</option>';
			}
		}
		else
		{
			$output .= '<option value="" >Select State</option>';
		}
		
		$go_ahead = true;
		$country_sql_str = "";
		if($multiple == '1')
		{
			if(is_array($country_id) && count($country_id) > 0)
			{
				if(in_array('-1', $country_id))
				{
					
				}
				else
				{
					$country_str = implode(',',$country_id);
					$country_sql_str = " AND country_id IN (".$country_str.")";
				}
			}
			else
			{
				$go_ahead = false;	
			}
			
		}
		else
		{
			if($country_id != '' && $country_id != 0)
			{
				$country_sql_str = " AND country_id = '".$country_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
		}
		
		if($go_ahead)
		{
			try {
				$sql = "SELECT state_id,state FROM `tblstates` WHERE `state_deleted` = '0' ".$country_sql_str." ORDER BY state ASC";	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{
						if($multiple == '1')
						{
							if(is_array($state_id) && in_array($r['state_id'], $state_id))
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
							if($r['state_id'] == $state_id )
							{
								$selected = ' selected ';	
							}
							else
							{
								$selected = '';	
							}
						}
						
						$output .= '<option value="'.$r['state_id'].'" '.$selected.'>'.stripslashes($r['state']).'</option>';
					}
				}
			} catch (Exception $e) {
				$stringData = '[getStateOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
				$this->debuglog($stringData);
				return $output;
			}		
		}
		
		return $output;
	}

    public function getAreaOption($country_id,$state_id,$city_id,$area_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $area_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Areas</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Areas</option>';
			}
			
		}
		else
		{
			$output .= '<option value="" >Select Area</option>';
		}
		
		$go_ahead = true;
		$city_sql_str = "";
		$state_sql_str = "";
		$country_sql_str = "";
		if($multiple == '1')
		{
			if(is_array($country_id) && count($country_id) > 0)
			{
				if(in_array('-1', $country_id))
				{
					
				}
				else
				{
					$country_str = implode(',',$country_id);
					$country_sql_str = " AND country_id IN (".$country_str.")";
				}
				
				if(is_array($state_id) && count($state_id) > 0)
				{
					if(in_array('-1', $state_id))
					{
						
					}
					else
					{
						$state_str = implode(',',$state_id);
						$state_sql_str = " AND state_id IN (".$state_str.")";
					}
				}
				else
				{
					$go_ahead = false;	
				}
				
				if(is_array($city_id) && count($city_id) > 0)
				{
					if(in_array('-1', $city_id))
					{
						
					}
					else
					{
						$city_str = implode(',',$city_id);
						$city_sql_str = " AND city_id IN (".$city_str.")";
					}
				}
				else
				{
					$go_ahead = false;	
				}
			}
			else
			{
				$go_ahead = false;
			}
		}
		else
		{
			if($country_id != '' && $country_id != 0)
			{
				$country_sql_str = " AND country_id = '".$country_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
			
			if($state_id != '' && $state_id != 0)
			{
				$state_sql_str = " AND state_id = '".$state_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
			
			if($city_id != '' && $city_id != 0)
			{
				$city_sql_str = " AND city_id = '".$city_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
		}
		
		if($go_ahead)
		{
			try {
				echo $sql = "SELECT area_id,area_name FROM `tblarea` WHERE `area_deleted` = '0' ".$country_sql_str." ".$state_sql_str." ".$city_sql_str." ORDER BY area_name ASC";	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{
						if($multiple == '1')
						{
							if(is_array($area_id) && in_array($r['area_id'], $area_id))
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
							if($r['area_id'] == $area_id )
							{
								$selected = ' selected ';	
							}
							else
							{
								$selected = '';	
							}
						}
						
						$output .= '<option value="'.$r['area_id'].'" '.$selected.'>'.stripslashes($r['area_name']).'</option>';
					}
				}
			} catch (Exception $e) {
				$stringData = '[getAreaOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
				$this->debuglog($stringData);
				return $output;
			}		
		}
		
		return $output;
	}    
  
        
public function getCityOption($country_id,$state_id,$city_id,$type='1',$multiple='')
	{
		$DBH = new DatabaseHandler();
		$output = '';
		
		if($type == '2')
		{
			if($multiple == '1')
			{
				if(in_array('-1', $city_id))
				{
					$selected = ' selected ';	
				}
				else
				{
					$selected = '';	
				}
				$output .= '<option value="-1" '.$selected.' >All Cities</option>';	
			}
			else
			{
				$selected = '';	
				$output .= '<option value="" '.$selected.' >All Cities</option>';
			}
		}
		else
		{
			$output .= '<option value="" >Select City</option>';
		}
		
		$go_ahead = true;
		$state_sql_str = "";
		$country_sql_str = "";
		if($multiple == '1')
		{
			if(is_array($country_id) && count($country_id) > 0)
			{
				if(in_array('-1', $country_id))
				{
					
				}
				else
				{
					$country_str = implode(',',$country_id);
					$country_sql_str = " AND country_id IN (".$country_str.")";
				}
				
				if(is_array($state_id) && count($state_id) > 0)
				{
					if(in_array('-1', $state_id))
					{
						
					}
					else
					{
						$state_str = implode(',',$state_id);
						$state_sql_str = " AND state_id IN (".$state_str.")";
					}
				}
				else
				{
					$go_ahead = false;	
				}
			}
			else
			{
				$go_ahead = false;
			}
		}
		else
		{
			if($country_id != '' && $country_id != 0)
			{
				$country_sql_str = " AND country_id = '".$country_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
			
			if($state_id != '' && $state_id != 0)
			{
				$state_sql_str = " AND state_id = '".$state_id."' ";	
			}
			else
			{
				$go_ahead = false;	
			}
		}
		
		if($go_ahead)
		{
			try {
				$sql = "SELECT city_id,city FROM `tblcities` WHERE `city_deleted` = '0' ".$country_sql_str." ".$state_sql_str." ORDER BY city ASC";	
				$STH = $DBH->query($sql);
				if( $STH->rowCount() > 0 )
				{
					while($r= $STH->fetch(PDO::FETCH_ASSOC))
					{
						if($multiple == '1')
						{
							if(is_array($city_id) && in_array($r['city_id'], $city_id))
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
							if($r['city_id'] == $city_id )
							{
								$selected = ' selected ';	
							}
							else
							{
								$selected = '';	
							}
						}
						
						$output .= '<option value="'.$r['city'].'" '.$selected.'>'.stripslashes($r['city']).'</option>';
					}
				}
			} catch (Exception $e) {
				$stringData = '[getCityOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;
				$this->debuglog($stringData);
				return $output;
			}		
		}
		
		return $output;
	}        
        
  
  public function updateUserVivek($name,$middle_name,$last_name,$dob,$height,$weight,$sex,$mobile,$country_id,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$user_id)

{

	$DBH = new DatabaseHandler();
	$return = true;
	echo $sql = "UPDATE `tblusers` SET `name` = '".addslashes($name)."' ,`middle_name` = '".addslashes($middle_name)."' ,`last_name` = '".addslashes($last_name)."' , `dob` = '".$dob."' , `height` = '".addslashes($height)."' , `weight` = '".addslashes($weight)."' , `sex` = '".$sex."' , `mobile` = '".addslashes($mobile)."' , `country_id` = '".$country_id."' , `state_id` = '".$state_id."', `city_id` = '".$city_id."', `place_id` = '".$place_id."' , `food_veg_nonveg` = '".addslashes($food_veg_nonveg)."' , `beef` = '".addslashes($beef)."' , `pork` = '".addslashes($pork)."' WHERE `user_id` = '".$user_id."'";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$return = true;	
	}
	return $return;

}      
 
public function chkUserPlanFeaturePermission($user_id,$upa_id)

{

	$DBH = new DatabaseHandler();
	$return = false;

	$default_up_id = $this->getUserDefaultPlanId();

	$sql = "SELECT * FROM `tbluserplandetails` AS tupd LEFT JOIN `tbluserplans` AS tup ON tupd.up_id = tup.up_id WHERE tupd.up_id = '".$default_up_id."' AND tup.up_default = '1' AND tup.up_status = '1' AND tup.up_deleted = '0' AND tupd.upa_id = '".$upa_id."' AND tupd.upd_status = '1'  AND tupd.upd_deleted = '0' AND tupd.upa_value = '1' ";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $return = true;
	}
	else
	{
                
		$user_up_id = $this->getUserCurrentActivatedPlanId($user_id);
		if($user_up_id > 0)
		{
			$sql2 = "SELECT * FROM `tbluserplandetails` AS tupd LEFT JOIN `tbluserplans` AS tup ON tupd.up_id = tup.up_id WHERE tupd.up_id = '".$user_up_id."' AND tup.up_status = '1' AND tup.up_deleted = '0' AND tupd.upa_id = '".$upa_id."' AND tupd.upd_status = '1'  AND tupd.upd_deleted = '0' AND tupd.upa_value = '1' ";
			$STH2 = $DBH->query($sql2);
                        if($STH2->rowCount() > 0 )
                        {
				$return = true;
			}
		}
	}	
	return $return;

}


public function getUserDefaultPlanId()

{

	$DBH = new DatabaseHandler();
	$up_id = 0; 
	$sql = "SELECT * FROM `tbluserplans` WHERE `up_default` = '1' AND `up_status` = '1' AND `up_deleted` = '0' ORDER BY `up_add_date` DESC LIMIT 1";

	//echo '<br>'.$sql.'<br>';

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$up_id = $row['up_id'];

	}

    return $up_id;

}


public function getUserCurrentActivatedPlanId($user_id)

{

	$DBH = new DatabaseHandler();

	$up_id = 0; 
	$sql = "SELECT * FROM `tbluserplanrequests` WHERE `user_id` = '".$user_id."' AND `upr_status` = '1' ORDER BY `upr_add_date` DESC LIMIT 1";
	//echo '<br>'.$sql.'<br>';
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$up_id = $row['up_id'];
	}

	else
	{
		$up_id = $this->getUserDefaultPlanId();
	}

	return $up_id;

}

public function getMyRewardsChart($user_id,$start_date,$end_date)

{

	$DBH = new DatabaseHandler();
	$return = false;
	$arr_reward_modules = array();
	$arr_reward_summary = array();

	list($arr_start_month_day,$arr_end_month_day) = $this->getMonthsListBetweenTwoDates($start_date,$end_date);

	

	if(count($arr_start_month_day) > 0)

	{

		for($k=0;$k<count($arr_start_month_day);$k++)

		{

			$sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_deleted` = '0' AND `reward_module_status` = '1'  AND `show_in_report` = '1' ORDER BY `listing_order` ASC ";

			$STH = $DBH->query($sql);
                        if( $STH->rowCount() > 0 )
                        {

				$return = true;

				$i = 0;

				$arr_reward_modules[$arr_start_month_day[$k]]['total_reward_conversion_value'] = 0;

				$arr_reward_modules[$arr_start_month_day[$k]]['total_total_entries'] = 0;

				$arr_reward_modules[$arr_start_month_day[$k]]['total_points_from_entry'] = 0;

				$arr_reward_modules[$arr_start_month_day[$k]]['total_no_of_days_posted'] = 0;

				$arr_reward_modules[$arr_start_month_day[$k]]['total_bonus_points'] = 0;

				$arr_reward_modules[$arr_start_month_day[$k]]['total_total_points'] = 0;

				$arr_reward_modules[$arr_start_month_day[$k]]['total_encashed_points'] = 0;

				$arr_reward_modules[$arr_start_month_day[$k]]['total_balance_points'] = 0;

				

				while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

				{

					if($row['page_id'] == '0')

					{

						$title = stripslashes($row['reward_module_title']);

					}

					else

					{

						$title = $this->getMenuTitleOfPage($row['page_id']);

						if($title == '')

						{

							$title = stripslashes($row['reward_module_title']);

						}

					}

					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_module_id'] = $row['reward_module_id'];

					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_module_title'] = $title;	

					$arr_reward_summary[$row['reward_module_id']]['summary_reward_module_title'] = $title;

					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_conversion_value'] = $this->getRewardConversionValue($row['reward_module_id'],$arr_start_month_day[$k],$arr_end_month_day[$k]);

					$arr_reward_modules[$arr_start_month_day[$k]]['total_reward_conversion_value'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_conversion_value'];

					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_entries'] = $this->getTotalEntriesOfModule($row['reward_module_id'],$arr_start_month_day[$k],$arr_end_month_day[$k],$user_id);

					$arr_reward_modules[$arr_start_month_day[$k]]['total_total_entries'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_entries'];

					$arr_reward_summary[$row['reward_module_id']]['summary_total_entries'] +=  $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_entries'];

					
					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_module_id'] = $row['reward_module_id'];	

					if($arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_conversion_value'] == '' || $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_conversion_value'] == '0')

					{

						$points_from_entry = '0';

					}

					else

					{

						$points_from_entry = round($arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_entries'] / $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_conversion_value'],2);

					}

					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['points_from_entry'] = $points_from_entry;

					$arr_reward_modules[$arr_start_month_day[$k]]['total_points_from_entry'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['points_from_entry'];

					

					$arr_reward_summary[$row['reward_module_id']]['summary_points_from_entry'] +=  $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['points_from_entry'];

					

					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['no_of_days_posted'] = $this->getTotalNoOfDaysOfEntries($row['reward_module_id'],$arr_start_month_day[$k],$arr_end_month_day[$k],$user_id);

					$arr_reward_modules[$arr_start_month_day[$k]]['total_no_of_days_posted'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['no_of_days_posted'];

					

					$arr_reward_summary[$row['reward_module_id']]['summary_no_of_days_posted'] +=  $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['no_of_days_posted'];

					

					

					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['bonus_points'] = $this->getTotalBonusPointsOfEntries($row['reward_module_id'],$arr_start_month_day[$k],$arr_end_month_day[$k],$user_id);

					$arr_reward_modules[$arr_start_month_day[$k]]['total_bonus_points'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['bonus_points'];

					

					$arr_reward_summary[$row['reward_module_id']]['summary_bonus_points'] +=  $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['bonus_points'];

					

					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_points'] = $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['points_from_entry'] + $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['bonus_points'];

					$arr_reward_modules[$arr_start_month_day[$k]]['total_total_points'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_points'];

					

					$arr_reward_summary[$row['reward_module_id']]['summary_total_points'] +=  $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_points'];

					

					$encashed_points = $this->getTotalEncashedPointsOfModule($row['reward_module_id'],$arr_start_month_day[$k],$arr_end_month_day[$k],$user_id);

					

					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['encashed_points'] = $encashed_points;

					$arr_reward_modules[$arr_start_month_day[$k]]['total_encashed_points'] += $encashed_points;

					

					$arr_reward_summary[$row['reward_module_id']]['summary_total_encashed_points'] +=  $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['encashed_points'];

					

					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['balance_points'] = $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_points'] - $encashed_points;

					$arr_reward_modules[$arr_start_month_day[$k]]['total_balance_points'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['balance_points'];

					

					$arr_reward_summary[$row['reward_module_id']]['summary_total_balance_points'] =  $arr_reward_summary[$row['reward_module_id']]['summary_total_points'] - $arr_reward_summary[$row['reward_module_id']]['summary_total_encashed_points'];

					

					$i++;

					

					

				}

			}

		}	

	}	

	return array($return,$arr_reward_modules,$arr_reward_summary);

}


public function getMonthsListBetweenTwoDates($start_date,$end_date)

{

	$arr_start_month_day = array();
	$arr_end_month_day = array();

	if($start_date != '' && $end_date != '')

	{

		$start    = new DateTime($start_date);
		$start->modify('first day of this month');
		$end      = new DateTime($end_date);
		$end->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);
		foreach ($period as $dt)
		{
                        array_push($arr_start_month_day , $dt->format("Y-m-01"));
			array_push($arr_end_month_day , $dt->format("Y-m-t"));
		}

		$arr_start_month_day = array_reverse($arr_start_month_day);
		$arr_end_month_day = array_reverse($arr_end_month_day);

	}	

	return array($arr_start_month_day,$arr_end_month_day);

}

public function getMenuTitleOfPage($page_id)

{

	$DBH = new DatabaseHandler();
	$menu_title = '';
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$menu_title = stripslashes($row['menu_title']);

	}

	return $menu_title;



}

public function getRewardConversionValue($reward_module_id,$start_date,$end_date)

{

	$DBH = new DatabaseHandler();

	$value = '0';
	$sql = "SELECT * FROM `tblrewardpoints` WHERE `reward_point_deleted` = '0' AND `reward_point_status` = '1'  AND `reward_point_module_id` = '".$reward_module_id."' AND EXTRACT(YEAR_MONTH FROM reward_point_date) <= '".date('Ym',strtotime($start_date))."' ORDER BY `reward_point_date` DESC LIMIT 1";

	//echo '<br>'.$sql;

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

		$row = $STH->fetch(PDO::FETCH_ASSOC); 
		$reward_point_cutoff_type_id = $row['reward_point_cutoff_type_id'];
		$value = stripslashes($row['reward_point_conversion_value']);
		if($reward_point_cutoff_type_id > 0)

		{

		}		

	}

	return $value;	

}

public function getTotalEntriesOfModule($reward_module_id,$start_date,$end_date,$user_id)

{

	$DBH = new DatabaseHandler();
	$value = '0';
	if($user_id != '')

	{

		$str_user_id = " AND user_id = '".$user_id."' ";	

	}

	else

	{

		$str_user_id = "";	

	}

	

	//echo '<br>Testkk: reward_module_id = '.$reward_module_id;

	if($reward_module_id == '1')

	{

		$sql = "SELECT * FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'breakfast' ".$str_user_id." ORDER BY `meal_date` ASC ";

	}

	elseif($reward_module_id == '2')

	{

		$sql = "SELECT * FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'brunch' ".$str_user_id." ORDER BY `meal_date` ASC ";

	}

	elseif($reward_module_id == '3')

	{

		$sql = "SELECT * FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'lunch' ".$str_user_id." ORDER BY `meal_date` ASC ";

	}

	elseif($reward_module_id == '4')

	{

		$sql = "SELECT * FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'snacks' ".$str_user_id." ORDER BY `meal_date` ASC ";

	}

	elseif($reward_module_id == '5')

	{

		$sql = "SELECT * FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'dinner' ".$str_user_id." ORDER BY `meal_date` ASC ";

	}

	elseif($reward_module_id == '6')

	{

		$sql = "SELECT * FROM `tblusersdailyactivity` WHERE `activity_date` >= '".$start_date."' AND `activity_date` <= '".$end_date."' ".$str_user_id." ORDER BY `activity_date` ASC ";

	}

	elseif($reward_module_id == '7')

	{

		$sql = "SELECT * FROM `tbluserswae` WHERE `wae_date` >= '".$start_date."' AND `wae_date` <= '".$end_date."' ".$str_user_id." AND `wae_old_data` = '0'  ORDER BY `wae_date` ASC ";

	}

	elseif($reward_module_id == '8')

	{

		$sql = "SELECT * FROM `tblusersgs` WHERE `gs_date` >= '".$start_date."' AND `gs_date` <= '".$end_date."' ".$str_user_id." AND `gs_old_data` = '0' ORDER BY `gs_date` ASC ";

	}

	elseif($reward_module_id == '9')

	{

		$sql = "SELECT * FROM `tbluserssleep` WHERE `sleep_date` >= '".$start_date."' AND `sleep_date` <= '".$end_date."' ".$str_user_id." AND `sleep_old_data` = '0'  ORDER BY `sleep_date` ASC ";

	}

	elseif($reward_module_id == '10')

	{

		$sql = "SELECT * FROM `tblusersmc` WHERE `mc_date` >= '".$start_date."' AND `mc_date` <= '".$end_date."' ".$str_user_id." AND `mc_old_data` = '0'  ORDER BY `mc_date` ASC ";

	}

	elseif($reward_module_id == '11')

	{

		$sql = "SELECT * FROM `tblusersmr` WHERE `mr_date` >= '".$start_date."' AND `mr_date` <= '".$end_date."' ".$str_user_id." AND `mr_old_data` = '0'  ORDER BY `mr_date` ASC ";

	}

	elseif($reward_module_id == '12')

	{

		$sql = "SELECT * FROM `tblusersmle` WHERE `mle_date` >= '".$start_date."' AND `mle_date` <= '".$end_date."' ".$str_user_id." AND `mle_old_data` = '0'  ORDER BY `mle_date` ASC ";

	}

	elseif($reward_module_id == '13')

	{

		$sql = "SELECT * FROM `tblusersadct` WHERE `adct_date` >= '".$start_date."' AND `adct_date` <= '".$end_date."' ".$str_user_id." AND `adct_old_data` = '0'  ORDER BY `adct_date` ASC ";

	}

	elseif($reward_module_id == '14')

	{

		$sql = "SELECT * FROM `tblfeedback` WHERE DATE(feedback_add_date) >= '".$start_date."' AND DATE(feedback_add_date) <= '".$end_date."' ".$str_user_id." ORDER BY `feedback_add_date` ASC ";

	}

	elseif($reward_module_id == '16')

	{

		$sql = "SELECT * FROM `tblreferal` WHERE DATE(add_date) >= '".$start_date."' AND DATE(add_date) <= '".$end_date."' ".$str_user_id." ORDER BY `add_date` ASC ";

	}

        elseif($reward_module_id == '17')

	{

		$sql = "SELECT * FROM `tblusersbps` WHERE `bps_date` >= '".$start_date."' AND `bps_date` <= '".$end_date."' ".$str_user_id." AND `bps_old_data` = '0'   ORDER BY `bps_date` ASC ";

	}

        elseif($reward_module_id == '18')

        {

                $sql = "SELECT * FROM `tblusersmdt` WHERE `mdt_date` >= '".$start_date."' AND `mdt_date` <= '".$end_date."' ".$str_user_id." AND `mdt_old_data` = '0' AND `bms_entry_type` = 'situation'  ORDER BY `mdt_date` ASC ";

        }

	else

	{

		$sql = '';

	}

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$value = $STH->rowCount();
	}

	return $value;

}

public function getTotalNoOfDaysOfEntries($reward_module_id,$start_date,$end_date,$user_id)

{

	$DBH = new DatabaseHandler();
	$value = '0';

	if($user_id != '')
	{
		$str_user_id = " AND user_id = '".$user_id."' ";	
	}
	else
	{
		$str_user_id = "";	
	}

	if($reward_module_id == '1')
	{
		$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'breakfast' ".$str_user_id." ORDER BY `meal_date` ASC ";
	}

	elseif($reward_module_id == '2')

	{

		$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'brunch' ".$str_user_id." ORDER BY `meal_date` ASC ";

	}

	elseif($reward_module_id == '3')

	{

		$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'lunch' ".$str_user_id." ORDER BY `meal_date` ASC ";

	}

	elseif($reward_module_id == '4')

	{

		$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'snacks' ".$str_user_id." ORDER BY `meal_date` ASC ";

	}

	elseif($reward_module_id == '5')

	{

		$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'dinner' ".$str_user_id." ORDER BY `meal_date` ASC ";

	}

	elseif($reward_module_id == '6')

	{

		$sql = "SELECT DISTINCT `activity_date` FROM `tblusersdailyactivity` WHERE `activity_date` >= '".$start_date."' AND `activity_date` <= '".$end_date."' ".$str_user_id." ORDER BY `activity_date` ASC ";

	}

	elseif($reward_module_id == '7')

	{

		$sql = "SELECT DISTINCT `wae_date` FROM `tbluserswae` WHERE `wae_date` >= '".$start_date."' AND `wae_date` <= '".$end_date."' ".$str_user_id."  AND `wae_old_data` = '0'  ORDER BY `wae_date` ASC ";

	}

	elseif($reward_module_id == '8')

	{

		$sql = "SELECT DISTINCT `gs_date` FROM `tblusersgs` WHERE `gs_date` >= '".$start_date."' AND `gs_date` <= '".$end_date."' ".$str_user_id." AND `gs_old_data` = '0' ORDER BY `gs_date` ASC ";

	}

	elseif($reward_module_id == '9')

	{

		$sql = "SELECT DISTINCT `sleep_date` FROM `tbluserssleep` WHERE `sleep_date` >= '".$start_date."' AND `sleep_date` <= '".$end_date."' ".$str_user_id." AND `sleep_old_data` = '0'  ORDER BY `sleep_date` ASC ";

	}

	elseif($reward_module_id == '10')

	{

		$sql = "SELECT DISTINCT `mc_date` FROM `tblusersmc` WHERE `mc_date` >= '".$start_date."' AND `mc_date` <= '".$end_date."' ".$str_user_id." AND `mc_old_data` = '0'  ORDER BY `mc_date` ASC ";

	}

	elseif($reward_module_id == '11')

	{

		$sql = "SELECT DISTINCT `mr_date` FROM `tblusersmr` WHERE `mr_date` >= '".$start_date."' AND `mr_date` <= '".$end_date."' ".$str_user_id." AND `mr_old_data` = '0'  ORDER BY `mr_date` ASC ";

	}

	elseif($reward_module_id == '12')

	{

		$sql = "SELECT DISTINCT `mle_date` FROM `tblusersmle` WHERE `mle_date` >= '".$start_date."' AND `mle_date` <= '".$end_date."' ".$str_user_id." AND `mle_old_data` = '0'  ORDER BY `mle_date` ASC ";

	}

	elseif($reward_module_id == '13')

	{

		$sql = "SELECT DISTINCT `adct_date` FROM `tblusersadct` WHERE `adct_date` >= '".$start_date."' AND `adct_date` <= '".$end_date."' ".$str_user_id." AND `adct_old_data` = '0'  ORDER BY `adct_date` ASC ";

	}

	elseif($reward_module_id == '14')

	{

		$sql = "SELECT DISTINCT DATE(feedback_add_date) FROM `tblfeedback` WHERE DATE(feedback_add_date) >= '".$start_date."' AND DATE(feedback_add_date) <= '".$end_date."' ".$str_user_id." ORDER BY `feedback_add_date` ASC ";

	}

	elseif($reward_module_id == '16')

	{

		$sql = "SELECT DISTINCT DATE(add_date) FROM `tblreferal` WHERE DATE(add_date) >= '".$start_date."' AND DATE(add_date) <= '".$end_date."' ".$str_user_id." ORDER BY `add_date` ASC ";

	}

        elseif($reward_module_id == '17')

	{

		$sql = "SELECT DISTINCT `bps_date` FROM `tblusersbps` WHERE `bps_date` >= '".$start_date."' AND `bps_date` <= '".$end_date."' ".$str_user_id." AND `bps_old_data` = '0' ORDER BY `bps_date` ASC ";

	}

        elseif($reward_module_id == '18')

        {

                $sql = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE `mdt_date` >= '".$start_date."' AND `mdt_date` <= '".$end_date."' ".$str_user_id." AND `mdt_old_data` = '0' AND `bms_entry_type` = 'situation'  ORDER BY `mdt_date` ASC ";

        }

	else

	{

		$sql = '';

	}

	//echo'<br>Testkk: sql = '.$sql;

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$value = $STH->rowCount();
	}

	return $value;

}

public function getTotalBonusPointsOfEntries($reward_module_id,$start_date,$end_date,$user_id)

{

	$DBH = new DatabaseHandler();
	$value = '0';
	return $value;

}


public function getTotalEncashedPointsOfModule($reward_module_id,$start_date,$end_date,$user_id)

{

	$DBH = new DatabaseHandler();
	$value = 0;

	$sql = "SELECT * FROM `tblrewardredeamed` WHERE DATE(redeam_date) >= '".$start_date."' AND DATE(redeam_date) <= '".$end_date."' AND `reward_module_id` = '".$reward_module_id."' AND `user_id` = '".$user_id."' ORDER BY `redeam_date` DESC ";

	//echo'<br>Testkk: sql = '.$sql;

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 
		{

			$value += $row['encashed_points'];
		}	
	}

	return $value;

}

public function getUserRegistrationTimestamp($user_id)

{
	$DBH = new DatabaseHandler();
	$user_add_date = '';
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$user_add_date = stripslashes($row['user_add_date']);
	}

	return $user_add_date;

}


public function getMyFoodCountByDate($date, $user_id) {

	$DBH = new DatabaseHandler();
	$date = !empty($date) ? $date : date("Y-m-d");
	$user_id = !empty($user_id) ? $user_id : $_SESSION['user_id'];

	$count = '0';

	$sql = "SELECT * FROM tblusersmeals where user_id = ".$user_id." and meal_date = '".$date."'";	

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$count = $STH->rowCount();
	}

	return $count;

}

public function getMyActivityCountByDate($date, $user_id) {

	$DBH = new DatabaseHandler();

	$date = !empty($date) ? $date : date("Y-m-d");

	$user_id = !empty($user_id) ? $user_id : $_SESSION['user_id'];

	$count = '0';

	$sql = "SELECT * FROM tblusersdailyactivity where user_id = ".$user_id." and activity_date = '".$date."'";	

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

		$count = $STH->rowCount();

	}

	return $count;

}

function getMySleepCountByDate($date, $user_id) {

 $DBH = new DatabaseHandler();

 $date = !empty($date) ? $date : date("Y-m-d");

 $user_id = !empty($user_id) ? $user_id : $_SESSION['user_id'];

 $count = '0';

 $sql = "SELECT * FROM tbluserssleep where user_id = ".$user_id." and sleep_date = '".$date."'"; 

        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $count = $STH->rowCount();
        
 }

 return $count;

}

public function getMySituationByDate($date, $user_id) {

 $DBH = new DatabaseHandler();

 $date = !empty($date) ? $date : date("Y-m-d");

 $user_id = !empty($user_id) ? $user_id : $_SESSION['user_id'];

 $count = '0';

 $sql = "SELECT * FROM tblusersmdt where user_id = ".$user_id." and mdt_date = '".$date."'"; 

 $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $count = $STH->rowCount();
        
 }

 return $count;

}

public function getMyCommunicationsByDate($date, $user_id) {

 $DBH = new DatabaseHandler();

 $date = !empty($date) ? $date : date("Y-m-d");

 $user_id = !empty($user_id) ? $user_id : $_SESSION['user_id'];

 $count = '0';

 $sql = "SELECT * FROM tblusersmc where user_id = ".$user_id." and mc_date = '".$date."'"; 

 $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $count = $STH->rowCount();
        
 }

 return $count;

}

public function getMyWorkplaceByDate($date, $user_id) {

 $DBH = new DatabaseHandler();

 $date = !empty($date) ? $date : date("Y-m-d");

 $user_id = !empty($user_id) ? $user_id : $_SESSION['user_id'];

 $count = '0';

 $sql = "SELECT * FROM tbluserswae where user_id = ".$user_id." and wae_date = '".$date."'"; 

 $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $count = $STH->rowCount();
        
 }

 return $count;

}

public function GETUSERLEFTMENU($type)
{
        $DBH = new DatabaseHandler();
	$sql = "SELECT * FROM `tblpages` where `position` = '".$type."' and `show_in_dashboard` = 1 order by show_order ASC";
        $data = array();
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 
		{
			$data[] = $row;
		}	
	}

	return $data;   
}

public function GETUSERDASHBOARDHEADER($position)
{
        $DBH = new DatabaseHandler();
	$sql = "SELECT * FROM `tblpages` where `position` = '".$position."' and `dashboard_header`!='' order by show_order ASC limit 1";
        $header = '';
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$row = $STH->fetch(PDO::FETCH_ASSOC);
                $header= $row['dashboard_header'];
	}

	return $header;     
}

public function GETDATADROPDOWNMYDAYTODAYOPTION($page_cat_id,$page_name)
{
        $DBH = new DatabaseHandler();
        
	$arr_data = array();
	$sql = "SELECT * FROM `tbl_data_dropdown` WHERE page_name = '".$page_name."' and `page_cat_id` = '".$page_cat_id."' and `is_deleted` = 0 ORDER BY `order_show` ASC";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

		while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

		{
			$arr_data[] = $row;
		}
	}
	return $arr_data;
}

public function CreateDesignLifeDropdownEdit($show_cat,$final_array,$box_title)
{
    
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
   
   $sel = '';
   
    if(!empty($final_array_new))
    {
        for($j=0;$j<count($final_array_new);$j++)
        {
         if($box_title == $final_array_new[$j])
            {
                $sel = ' selected ';
            }  
            else
            {
                $sel='';
            }
            $option_str .='<option value="'.$final_array_new[$j].'" '.$sel.'>'.$final_array_new[$j].'</option>';  
        }
    }
    
   
    return $option_str;
    
}


public function getFavCategoryNameVivek($fav_cat_id)
	{
          
            $DBH = new DatabaseHandler();
            $fav_cat_type = '';
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";
            //$this->execute_query($sql);
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $fav_cat_type = stripslashes($row['fav_cat']);
            }
            return $fav_cat_type;
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
        
        public function GetmycanvasdataDesign($symtum_cat)
{
        $symtum_cat = implode(',', $symtum_cat);
        $DBH = new DatabaseHandler();
        
	$option_str = array();
	$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE bms_id IN($symtum_cat) ORDER BY `bms_name` ASC";
	$STH = $DBH->query($sql);
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
      
        $DBH = new DatabaseHandler();
        $option_str = array();
	$sql = "SELECT * FROM `tblsolutionitems` WHERE  sol_item_cat_id IN($cat_id) ORDER BY `sol_box_title` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {	
                $option_str[]= strip_tags($row['sol_box_title']);
            }
	}
	return $option_str; 
}


public function getAllMainSymptomsMyDesign($symtum_cat)
    {       
        $DBH = new DatabaseHandler();
        
        $str_sql_search = " AND `fav_parent_cat` IN (".$symtum_cat.") ";
        $data = array();
       $sql = "SELECT DISTINCT bmsid FROM `tblsymtumscustomcategory` WHERE  symtum_deleted = '0' ".$str_sql_search." ORDER BY bmsid DESC ";		
        
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {           
                $data[] = $row['bmsid'];
            }
	}
	return $data;  
        
    }
    
    public function getAllDailyMealsMyDesign($symtum_cat)
    {       
        $DBH = new DatabaseHandler();
        $str_sql_search = " AND `fav_cat_id` IN (".$symtum_cat.") ";
        $data = array();
        $sql = "SELECT DISTINCT meal_id FROM `tbldailymealsfavcategory` WHERE  show_hide = '1' ".$str_sql_search." ORDER BY meal_id DESC ";		
        
        $STH = $DBH->query($sql);
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
        $DBH = new DatabaseHandler();
        
        
	$option_str = array();
	$sql = "SELECT * FROM `tbldailymeals` WHERE meal_id IN($symtum_cat) ORDER BY `meal_item` ASC";
	$STH = $DBH->query($sql);
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
        $DBH = new DatabaseHandler();
        
        
	$option_str = array();
        $sql = "SELECT * FROM `tbldailyactivity` WHERE (activity_category IN($symtum_cat) OR activity_level_code IN($symtum_cat)) ORDER BY `activity` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {
                $option_str[] = strip_tags($row['activity']);
            }
	}
	return $option_str;  
        
}

public function CreateDesignLifeDropdown($show_cat,$final_array)
{
    
    $option_str = '';
    $data = array();
    if(!empty($show_cat))
    {
        for($i=0;$i<count($show_cat);$i++)
        {
          //$option_str .='<option value="'.$this->getFavCategoryNameVivek($show_cat[$i]).'">'.$this->getFavCategoryNameVivek($show_cat[$i]).'</option>';  
        
            $data[] = $this->getFavCategoryNameVivek($show_cat[$i]);
        }
    }
    
   $final_array_new =  array_merge($data,$final_array);
   
   
   
   //$final_array_new = asort($final_array_new);
    
//   echo '<pre>';
//   print_r($final_array_new);
//   echo '</pre>';
//   die();
   
    if(!empty($final_array_new))
    {
        for($j=0;$j<count($final_array_new);$j++)
        {
          $option_str .='<option value="'.$final_array_new[$j].'">'.$final_array_new[$j].'</option>';  
        }
    }
    
   
    return $option_str;
    
}
 

public function GetEventDataFrontSearch($tdata)
    {
        
        $DBH = new DatabaseHandler();
        $arr_records = array();
        
        $sql_event_type = "";
        
        if($tdata['event_type'] != '')
        {
                $sql_event_type = " AND TEM.fav_cat_id_1 = '".$tdata['event_type']."' ";
        }
        
//	$sql = "SELECT TED.*,TEM.* from tbl_event_details TED "
//                        . " LEFT JOIN tbl_event_master TEM ON TED.event_master_id = TEM.event_master_id WHERE TED.event_status = 1 AND TED.event_deleted = 0 AND TED.country_id = '".$tdata['country_id']."' AND TED.state_id = '".$tdata['state_id']."' AND TED.city_id = '".$tdata['city_id']."' AND TED.area_id = '".$tdata['area_id']."' ".$sql_event_type." AND TED.end_date BETWEEN '".date("Y-m-d",strtotime($tdata['from_day_month_year']))."' AND '".date("Y-m-d",strtotime($tdata['to_day_month_year']))."' order by TED.event_id ASC";		

        
       $sql = "SELECT TED.*,TEM.* from tbl_event_details TED "
                        . " LEFT JOIN tbl_event_master TEM ON TED.event_master_id = TEM.event_master_id WHERE TED.event_status = 1 AND TED.event_deleted = 0 AND TED.country_id = '".$tdata['country_id']."' AND TED.state_id = '".$tdata['state_id']."' AND TED.city_id = '".$tdata['city_id']."' AND TED.area_id = '".$tdata['area_id']."' ".$sql_event_type." AND TED.end_date >= '".date("Y-m-d",strtotime($tdata['from_day_month_year']))."' AND TED.end_date <= '".date("Y-m-d",strtotime($tdata['to_day_month_year']))."' AND TEM.event_tags LIKE '%".$tdata['tags']."%'  order by TED.event_id ASC";		

         
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            while($r= $STH->fetch(PDO::FETCH_ASSOC))
            {
                    $arr_records[] = $r;
                   // $tags[]=$r['event_tags'];
            }
        }	
        //$arr_records['fianl_tags'] = $tags;
        return $arr_records;  
        
    }
    
    
    
public function GetEventDataMyCanvas($tags)
    {
        
        $DBH = new DatabaseHandler();
        $arr_records = array();
        
        $tags = implode(',', $tags);
        
        $sql = "SELECT TED.*,TEM.* from tbl_event_details TED "
                        . " LEFT JOIN tbl_event_master TEM ON TED.event_master_id = TEM.event_master_id WHERE TED.event_status = 1 AND TED.event_deleted = 0 AND TED.end_date >= '".date("Y-m-d")."'  AND TEM.event_tags LIKE '%".$tags."%'  order by TED.event_id ASC";		

         
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            while($r= $STH->fetch(PDO::FETCH_ASSOC))
            {
                    $data = array();
                    $data['activity_name'] = "<a href='event-details.php?token=".base64_encode($r['event_id'])."' target='_blank' >".$r['event_name']."</a>";  
                    $data['activity_id'] = $r['event_id'];
                    $arr_records[] = $data;
                   // $tags[]=$r['event_tags'];
            }
        }	
        //$arr_records['fianl_tags'] = $tags;
        return $arr_records;  
        
    }    
  
    public function GetDesignMyLifeDrop($symtum_cat,$sub_cat2_show_fetch,$sub_cat2_link)
    {
        $option_str ='';
        if($sub_cat2_show_fetch == 1)
        {
            $data = explode(',', $symtum_cat);
            
            for($i=0;$i<count($data);$i++)
            {
              $option_str .= '<option value="'.$this->getFavCategoryNameRamakant($data[$i]).'" >'.$this->getFavCategoryNameRamakant($data[$i]).'</option>';  
            }
        }
        else
        {
          if($sub_cat2_link == 'tbl_bodymainsymptoms')
          {
             $symtum_cat = explode(',', $symtum_cat);
             $data = $this->getAllMainSymptomsRamakantFront($symtum_cat); 
             $option_str = $this->GetDatadropdownoption($data);

          }
          
          if($sub_cat2_link == 'tblsolutionitems')
          {
             //$symtum_cat = explode(',', $symtum_cat);
             $data = $this->GetmycanvassolutionitemsDesign($symtum_cat);
             $data = array_values(array_filter($data));
             for($i=0;$i<count($data);$i++)
                {
                  $option_str .= '<option value="'.$data[$i].'" >'.$data[$i].'</option>';  
                }
             
          }
          
          if($sub_cat2_link == 'tbldailymealsfavcategory')
          {
               $symtum_cat = $this->getAllDailyMealsMyCanvas($symtum_cat); 
               if(!empty($symtum_cat))
               {
                $data = $this->GetmyDesignLifedata($symtum_cat,'');
               } 
               for($i=0;$i<count($data);$i++)
                {
                  $option_str .= '<option value="'.$data[$i].'" >'.$data[$i].'</option>';  
                }
          }
          
          if($sub_cat2_link == 'tbldailyactivity')
          {
              $data = $this->GetDesignMylifeDailyActivitydata($symtum_cat);
              $data = array_values(array_filter($data));
              for($i=0;$i<count($data);$i++)
                {
                  $option_str .= '<option value="'.$data[$i].'" >'.$data[$i].'</option>';  
                }
              
          }
          
        }
        return $option_str;
    }

    
public function GetmyDesignLifedata($symtum_cat)
{      
        $symtum_cat = implode(',', $symtum_cat);
        $DBH = new DatabaseHandler();
        
	$option_str = array();
	$sql = "SELECT * FROM `tbldailymeals` WHERE meal_id IN($symtum_cat) ORDER BY `meal_item` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {	
                $option_str[]=$row['meal_item'];
            }
	}
	return $option_str; 
}

public function GetDesignMylifeDailyActivitydata($symtum_cat)
{      
       
        $DBH = new DatabaseHandler();
        
	$option_str = array();
        $sql = "SELECT * FROM `tbldailyactivity` WHERE (activity_category IN($symtum_cat) OR activity_level_code IN($symtum_cat)) ORDER BY `activity` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {
                $option_str[] = $row['activity'];
            }
	}
	return $option_str;  
        
}

public function getCommentByBesnameDesign($besname,$table,$sub_cat3)
{
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$comment = array(); 
        
        $table = implode('\',\'',$table);
        $sub_cat3 = implode('\',\'',$sub_cat3);
        
        $sql ="SELECT * FROM `tblbodymainsymptoms` WHERE `bms_name` = '".$besname."' ";	
	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		//$comment = stripslashes($row['comment']);
                $comment = $this->GetSymtumKeywordListDesign($row['bms_id'],$table,$sub_cat3);
	}	
	return $comment;  
}

public function GetSymtumKeywordListDesign($symptom_id,$table,$sub_cat3)
{
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$comment = array();  
        $key_sub_cat = array();
        $option_str = "";
        $sql ="SELECT `keywords` FROM `tbl_symptom_keyword` WHERE `symptom_id` = '".$symptom_id."' and `fetch_link` IN('".$table."') and key_sub_cat IN('".$sub_cat3."') ";	
	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                   $comment[] = $row['keywords']; 
                   //$key_sub_cat[]=$row['key_sub_cat']; 
                }
                
                $icon = $this->getMyDayTodayIconComment('QuickTip_show',date("Y-m-d")); 
                
                
                if(count($comment) > 0)
                {
                       
                    for($i=0;$i<count($comment);$i++)
                    {
                        $option_str .='<p style="background-color: #FFF7F5; margin-left:100px;">'.$comment[$i].'</p>';   
                    }
                    
                     
                }
                
                
	}	
	return $option_str;  
}

public function  OnChangeGetWellnessSolutionitem($fav_cat_id,$sol_id_data)

{

   

  list($arr_box_title1,$arr_banner_type1,$arr_banner1,$arr_box_desc1,$arr_mind_jumble_box_id1,$arr_credit_line1,$arr_credit_line_url1,$arr_sound_clip_id1) = $this->OnChangeGetSolutionTableItemDetails($fav_cat_id,$sol_id_data);

  
  
//print_r($arr_mind_jumble_box_id1);
  	if(count($arr_mind_jumble_box_id1)>0)

		{

                                                        	 

$output = '<div class="slider_main" id="slider_main_bg">

           <div id="slider">';	

   for($i=0;$i<count($arr_mind_jumble_box_id1);$i++)

       {     

    $output .= '<div class="slider_inner">';

	

	$output .= '<table align="center" width="290" border="0" cellspacing="0" cellpadding="0" style="padding-left:10px; padding-right:10px;">

                   <tr>

                   	<td height="30" align="left" valign="middle">

                   		<span class="Header_brown">'.$arr_box_title1[$i].'</span>

                    </td>

                  </tr>

				  <tr>

                  	<td align="left" valign="middle">';

	

                if($arr_banner_type1[$i] == 'Flash') { 

    $output .='<script type="text/javascript">AC_FL_RunContent( "codebase","http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0","width","270","src","'.SITE_URL."/uploads/".$arr_banner1[$i].'","quality","high","pluginspage","http://www.macromedia.com/go/getflashplayer","wmode","transparent","movie","'.SITE_URL."/uploads/".$arr_banner1[$i].'" ); //end AC code

  </script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="270" ><param name="movie" value="'. SITE_URL."/uploads/".$arr_banner1[$i].'" /> <param name="wmode" value="transparent" /><param name="quality" value="high" /><embed src="'. SITE_URL."/uploads/".$arr_banner1[$i].'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="270"  wmode="transparent"></embed></object></noscript>';

      			 } elseif($arr_banner_type1[$i] == 'Image') {

    $output .='<img src="'.SITE_URL."/uploads/".$arr_banner1[$i].'" width="270" border="0" />';

     			 } elseif($arr_banner_type1[$i] == 'Video') { 

    $output .= '<iframe width="270" src="'.  $this->getSressBusterBannerString($arr_banner1[$i]).'" frameborder="0" allowfullscreen></iframe>';

                 } elseif($arr_banner_type1[$i] == 'Audio') { 

    $output .= '<embed type="application/x-shockwave-flash" flashvars="audioUrl='. SITE_URL."/uploads/".$arr_banner1[$i].'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="270" height="27" quality="best"></embed>';

                 }  

 	 $output .= '	</td>

                  </tr>

                  <tr>

                 	<td height="25" align="right" valign="top" class="footer"><a href="'.$arr_credit_line_url1[$i].'" target="_blank">'.$arr_credit_line1[$i].'</a></td>

                  </tr>

                  <tr>

	                <td align="left" valign="top">'.$arr_box_desc1[$i].'</td>

                  </tr>';

//               <tr>
//
//                   	<td height="50" align="left" valign="middle">';
////
////    $output .='<strong>Select: </strong><input type="radio"';
//
//	
//
//	$output .= 'id="select_banner_1_'.$i.'" name="select_banner1" value="'.$arr_mind_jumble_box_id1[$i].'" onclick="Display_MindJumble_Banner(\'1\')" />
//
//					<br><span class="footer">(Please select / tick mark only one as applicable to you.)</span>
//
//					</td>
//
//              	</tr>';

    

         $favourite1=explode(',',$_SESSION['favourite1']);
//        print_r($favourite1);die();
        
        if(in_array($arr_mind_jumble_box_id1[$i], $favourite1))
        {
             $checked='checked';
        }
        else
        {
            $checked='';
        }
//	$output .='<tr>
//
//                 <td height="50" align="left" valign="middle">
//
//		      <strong>Favourite: </strong><input type="checkbox" name="favourite1[]"';
//                          $output .=' id="favourite_1_'.$i.'" value="'. $arr_mind_jumble_box_id1[$i] .'" class="chkfav2" '.$checked.' onchange="destroyfavourite1data('.$i.');" />';
//   
//  	                   $output .='<br><span class="footer">(Mark above as your favourite.)</span>
//
//		</td>
//                </tr>';
     $output .='</table>';

	$output .='</div>';

           								} 

	$output .='</div></div>';

	} else {  

		 $output .='<img src="images/mj_main.jpg" width="290" height="384" border="0" />';

            } 								



	return $output;									

   }

 
public function OnChangeGetSolutionTableItemDetails($fav_cat_id,$solitemid)

{

$my_DBH = new DatabaseHandler();
$DBH = $my_DBH->raw_handle();
$DBH->beginTransaction();
   
foreach($solitemid as $rec)
{
$sol_id[]=$rec;
}     
$sol_id_implode=implode('\',\'',$sol_id);
//print_r($sol_id_implode);die();
	$arr_box_title = array(); 
	$arr_banner_type = array(); 
	$arr_banner = array();
	$arr_box_desc = array(); 
	$arr_mind_jumble_box_id = array();
	$arr_credit_line = array();
	$arr_credit_line_url = array();
	$arr_day = array();
	$arr_sound_clip_id = array();
	$arr_select_title = array();
	$arr_short_narration = array();
	$day = date('j');

	$sql = "SELECT * FROM `tblsolutionitems` WHERE sol_item_cat_id = '".$fav_cat_id."' AND sol_item_id IN('".$sol_id_implode."') ORDER BY `sol_item_id` DESC";

	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
		{
			$days = ($row['day']);
			$arr_days = explode(",", $days);
                        array_push($arr_box_title , stripslashes($row['sol_box_title']));
                        array_push($arr_banner_type , stripslashes($row['sol_box_type']));
                        array_push($arr_banner , stripslashes($row['sol_box_banner']));
                        array_push($arr_box_desc , stripslashes($row['sol_box_desc']));
                        array_push($arr_mind_jumble_box_id , stripslashes($row['sol_item_id']));
                        array_push($arr_credit_line , stripslashes($row['sol_credit_line']));
                        array_push($arr_credit_line_url , stripslashes($row['sol_credit_line_url']));
                        array_push($arr_sound_clip_id , stripslashes($row['sound_clip_id']));

		}	

	}

	return array($arr_box_title,$arr_banner_type,$arr_banner,$arr_box_desc,$arr_mind_jumble_box_id,$arr_credit_line,$arr_credit_line_url,$arr_sound_clip_id);

}   
   

public function getSressBusterBannerString($banner)

{

	$search = 'v=';

	$pos = strpos($banner, $search);

	$str = strlen($banner);

	$rest = substr($banner, $pos+2, $str);

	return 'http://www.youtube.com/embed/'.$rest;

}

public function get_MindJumbleBoxCode($banner_id)
	{
    
            list($mind_jumble_box_id,$box_title,$banner_type,$banner,$box_desc,$credit_line) = $this->getMindJumbleDetails($banner_id);

		$output ='<table align="center" width="290" border="0" cellspacing="0" cellpadding="0" style="padding-left:10px; padding-right:10px;" >

					 <tr id="slider_main_bg">

						<td height="30" align="left" valign="middle"><span class="Header_brown">'.$box_title.'</span></td>

						  </tr>

						  <tr>

							 <td align="left" valign="middle">';

	

			 if($banner_type == 'Flash') { 

       $output .='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="270" ><param name="movie" value="'. SITE_URL."/uploads/".$banner.'" /> <param name="wmode" value="transparent" /><param name="quality" value="high" /><embed src="'. SITE_URL."/uploads/".$banner.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="270"  wmode="transparent"></embed>

                                                            </object>';
         } elseif($banner_type == 'Image') { 
        $output .='<img src="'.SITE_URL."/uploads/".$banner.'" width="270" border="0" />';
         } elseif($banner_type == 'Video') { 
        $output .='<iframe width="270" src="'. $this->getSressBusterBannerString($banner).'" frameborder="0" allowfullscreen></iframe>';
         } elseif($banner_type == 'Audio') {
        $output .='<embed type="application/x-shockwave-flash" flashvars="audioUrl='.SITE_URL."/uploads/".$banner.'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="270" height="27" quality="best"  wmode="transparent"></embed>';

              }  
   $output .='</td>
                     </tr>
                         <tr>
                             <td height="25" align="right" valign="top"><span class="footer">'.$credit_line.'</span></td>
                          </tr>
                        <tr>
                              <td align="left" valign="top">'.$box_desc.'</td>

                        </tr></table>';

	return $output;

	}

public function getMindJumbleDetails($banner_id)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
	$mind_jumble_box_id = '';
	$box_title = '';
	$box_type = '';
	$banner = '';
	$box_type = '';
	$credit_line = '';

	$sql = "SELECT * FROM `tblmindjumble` WHERE mind_jumble_box_id = '".$banner_id."' ";
	$STH = $DBH->prepare($sql);
        $STH->execute();

	 if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$mind_jumble_box_id = stripslashes($row['mind_jumble_box_id']);
		$box_title = stripslashes($row['box_title']);
		$banner_type = stripslashes($row['box_type']); 
		$banner = stripslashes($row['box_banner']);
		$box_desc = stripslashes($row['box_desc']);
		$credit_line = stripslashes($row['credit_line']);
	}	

	return array($mind_jumble_box_id,$box_title,$banner_type,$banner,$box_desc,$credit_line);

}	


function get_allpdfcode($select_title,$short_narration)

  	{

		$day = date('j');

		$page_id = '44';

	  list($arr_pdf_id,$arr_pdf1,$arr_pdf_title1,$arr_credit1,$arr_credit_url1,$arr_status1) = $this->getMindJumbelAllPDF($day,$select_title,$short_narration);

	//print_r($arr_pdf_id);

	 if(count($arr_pdf1)>0)

	  { 

			$output .='<table border="0" width="100%" cellpadding="0" cellspacing="0">

					<tr>

					<td align="left" valign="top"><strong>Know More:</strong></td>

					</tr>';

					

					for($i=0;$i<count($arr_pdf1);$i++)

					{

					

			$output .='<tr>

					<td height="50"  align="left" valign="top">

					<a href="'.SITE_URL."/uploads/".$arr_pdf1[$i].'" target="_blank" class="body_link">'.$arr_pdf_title1[$i].'</a>

					<input type="checkbox" class="chk_pdf" id="chk_pdf_'.$arr_pdf_id[$i].'" name="chk_pdf[]" value="'.$arr_pdf_id[$i].'" />

					<br /><a href="'.$arr_credit_url1[$i].'target="_blank"><span class="footer">'.$arr_credit1[$i].'</span></a></td></tr>';			

					} 

			$output .='<tr><td><input name="submit" type="button" id="submit" value="Add To Library"  onclick="PDF_Library(\''.$page_id.'\')"/></td></tr>';

			$output .='</table>';

	  }

	return $output;

}


function getMindJumbelAllPDF($day,$select_title,$short_narration)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

	$arr_pdf_id = array(); 
	$arr_pdf = array(); 
	$arr_pdf_title = array(); 
	$arr_credit = array();
	$arr_credit_url = array(); 
	$arr_status = array();
	$arr_days = array();

	if($select_title != '' && $short_narration == '')

	{

		$sql = "SELECT * FROM `tblmindjumblepdf` WHERE `title_id` = '".$select_title."' AND status = '1'  ORDER BY `mind_jumble_pdf_add_date` ASC";

	}

	elseif($select_title != '' && $short_narration != '')

	{

		$sql = "SELECT * FROM `tblmindjumblepdf` WHERE `title_id` = '".$select_title."' AND `short_narration` = '".$short_narration."' AND status = '1'  ORDER BY `mind_jumble_pdf_add_date` ASC";

	}

	

	$STH = $DBH->prepare($sql);
        $STH->execute();

	if($STH->rowCount() > 0)

	{

		while($row = $STH->fetch(PDO::FETCH_ASSOC))
		{
		    $days = ($row['day']);
                    $arr_days = explode(",", $days);
                    if (in_array($day,$arr_days)) 

                            {	
                                    array_push($arr_pdf_id , $row['mind_jumble_pdf_id']);
                                    array_push($arr_pdf , stripslashes($row['pdf']));
                                    array_push($arr_pdf_title , stripslashes($row['pdf_title']));
                                    array_push($arr_credit , stripslashes($row['credit']));
                                    array_push($arr_credit_url , stripslashes($row['credit_url']));
                                    array_push($arr_status , stripslashes($row['status']));
                            }	

		}

	}

	return array($arr_pdf_id,$arr_pdf,$arr_pdf_title,$arr_credit,$arr_credit_url,$arr_status);

}

public function GetCommentCode($select_title,$short_narration)

  	{

	 list($arr_comment_id,$arr_parent_comment_id,$arr_comment,$arr_user_id,$arr_comment_type,$arr_comment_add_date) = $this->getallcomment($select_title,$short_narration);
	 if(count($arr_comment_id)>0)

	  { 
			$output .='<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
					<td align="left" valign="top" class="Header_brown"><strong>Recent Comments</strong></td>
					</tr>
					</table><div class="commentbox">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">';
					for($i=0;$i<count($arr_comment_id);$i++)
					{
						$name = $this->getUserFullNameById($arr_user_id[$i]);
						$time= strtotime($arr_comment_add_date[$i]);
                                                $time=$time+19800;
                                                $day = date('d-M-Y h:i A',$time);
						$date1 = date('d-m-y',$time); 
						$date2 = date('d-m-y');
						$diff = abs(strtotime($date2) - strtotime($date1));
						$years = floor($diff / (365*60*60*24));
						$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
						$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
						$t1 = $day; 
						$total = timeDiff($t1,date("Y-m-d H:i:s"));
						$len_comment =  strlen($arr_comment[$i]); 
						$first_comment = substr($arr_comment[$i], 0,60);
						$last_comment = substr($arr_comment[$i], 61,$len_comment); 
						$comment =  $first_comment.'<br/>'.$last_comment;		
						$output .='<tr>
							   		<td width="50%" align="left" valign="top">'.$comment.'</td>';
						$output .='	<td width="20%" align="right" valign="top" class="footer">'.$name.'</td>';		
						$output .=' <td width="30%" align="right" valign="top" class="footer">'.$day.'<br/>'.$total.'</td></tr>';

						$output .='<tr>
						<td height="25"  align="left" valign="top">&nbsp;</td></tr>';					

					} 

			$output .='</table></div>';

	  }

	return $output;

	}


function getallcomment($select_title,$short_narration)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

	$arr_comment_id  = array(); 
	$arr_parent_comment_id = array(); 
	$arr_comment = array();
	$arr_user_id = array(); 
	$arr_comment_type = array();
	$arr_comment_add_date = array();

	if($select_title != '' && $short_narration == '')
	{
		$sql = "SELECT * FROM `tblcomments` WHERE `select_title` = '".$select_title."' AND `status` = '1'  ORDER BY `comment_add_date` DESC";
	}
	elseif($select_title != '' && $short_narration != '')
	{
		$sql = "SELECT * FROM `tblcomments` WHERE `select_title` = '".$select_title."' AND `short_narration` = '".$short_narration."' AND `status` = '1' ORDER BY `comment_add_date` DESC";
	}

	$STH = $DBH->prepare($sql);
        $STH->execute();

	if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
		{
			array_push($arr_comment_id , stripslashes($row['comment_id']));
			array_push($arr_parent_comment_id , stripslashes($row['parent_comment_id']));
			array_push($arr_comment , stripslashes($row['comment']));
			array_push($arr_user_id , stripslashes($row['user_id']));
			array_push($arr_comment_type , stripslashes($row['comment_type']));
			array_push($arr_comment_add_date , stripslashes($row['comment_add_date']));
		}
	}
        
	return array($arr_comment_id,$arr_parent_comment_id,$arr_comment,$arr_user_id,$arr_comment_type,$arr_comment_add_date);



}        

public function is_user($email)
{
    $my_DBH = new DatabaseHandler();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
    $temp_arr=array();
    $sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."'";
	//echo "<br>Testkk sql = ".$sql;
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		 return true;
	}
        else
        {
           return false; 
        }       
}

public function is_refered($email)
{
    $my_DBH = new DatabaseHandler();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
    $sql = "SELECT * FROM `tblreferal` WHERE `email_id` = '".$email."'";
	 
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
            return true;
	}
        else
        {
            return false;
        }
      
}

public function addreferafriend($tdata)
{	
	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$id = 0;
	  
	$sql = "INSERT INTO `tblreferal` (`email_id` ,`user_id`, `name` ,`message`,`status`) 
			VALUES ('".addslashes($tdata['email'])."','".addslashes($tdata['user_id'])."','".addslashes($tdata['user_name'])."','".addslashes($tdata['message'])."','0')";
	
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		$id = $DBH->lastInsertId();
	}
		
	return $id;  	
   
}

public function chkIfRequestAlreadySentByUser($pro_user_id,$user_email)

{

        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$return = false;
        $sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `invite_by_user` = '1' ";

	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		if($row['request_status'] != '2')
		{
			$return = true;
		}

	}

	return $return;

}

public function chkProEmailExists($email)
{
	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$return = false;
	
	$sql = "SELECT * FROM `tblprofusers` WHERE `email` = '".$email."'";
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		$return = true;
	}
	return $return;
}

public function chkIfUserIsAdvisersReferralsChkByProEmail($pro_user_email,$user_id)
{
	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
	$return = false;
	
        $pro_user_id = $this->getProUserId($pro_user_email);
	$user_email = $this->getUserEmailById($user_id);
	$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `request_status` = '1'";
	//echo '<br>'.$sql;
        $STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		$return = true;
	}

	return $return;
}

public function getProUserId($email)
{
	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
	$pro_user_id = 0;
	
	$sql = "SELECT * FROM `tblvendors` WHERE `vendor_email` = '".$email."' AND `vendor_status` = '1'";
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$pro_user_id = $row['vendor_id'];
	}
	return $pro_user_id;
}

public function addUsersReferral($pro_user_id,$user_email,$user_name,$message,$new_user,$invite_by_user)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$ar_id = 0;
	$sql = "INSERT INTO `tbladviserreferrals`(`pro_user_id`,`user_email`,`user_name`,`message`,`request_status`,`new_user`,`invite_by_user`) VALUES ('".addslashes($pro_user_id)."','".addslashes($user_email)."','".addslashes($user_name)."','".addslashes($message)."','0','".addslashes($new_user)."','".addslashes($invite_by_user)."')";
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		$ar_id = $DBH->lastInsertId();
	}

	return $ar_id;

}

public function get_all_refered($user_id)
{
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        
	$temp_arr = array();
    
        $sql = "SELECT * FROM `tblreferal` WHERE `user_id` = '".$user_id."'";
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
        {
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
		{
			$temp_arr[] = $row;
		}
	}
	return $temp_arr;
}

public function getUserRegistrationDateByEmail($email)
{
	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$user_add_date = '';
		
       $sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."'";
	//echo "<br>Testkk sql = ".$sql;
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$user_add_date = date('d/m/Y h:i:s A',stripslashes($row['user_add_date']));
		
	}
       
	return $user_add_date;
}

public function getAllUserAdviserReferrals($user_id,$pro_user_id,$status,$invite_start_date,$invite_end_date,$status_start_date,$status_end_date)

{

        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$temp_arr = array();
        $user_email = $this->getUserEmailById($user_id);
        
        if($pro_user_id != '')
        {
            $puemail = $this->getProUserEmailById($pro_user_id);
            $str_sql_pro_user_id1 = " AND `user_email` = '".$puemail."' ";
            $str_sql_pro_user_id2 = " AND `pro_user_id` = '".$pro_user_id."' ";
        }
        else
        {
            $str_sql_pro_user_id1 = "";
            $str_sql_pro_user_id2 = "";
        }
        
        if($status!= '')
        {
            if($status == '1')
            {
                $str_sql_status1 = " AND `request_status` = '1' ";
                $str_sql_status2 = " AND `request_status` = '1' ";
            }
            elseif($status == '2')
            {

                $str_sql_status1 = " AND `request_status` = '2' ";
                $str_sql_status2 = " AND `request_status` = '2' ";
            }

            elseif($status == '3')
            {
                $str_sql_status1 = " AND `request_status` = '3' ";
                $str_sql_status2 = " AND `request_status` = '3' ";
            }
            else
            {
                $str_sql_status1 = " AND `request_status` = '0' ";
                $str_sql_status2 = " AND `request_status` = '0' ";
            }
        }

        else

        {
            $str_sql_status1 = "";
            $str_sql_status2 = "";
        }

        if($invite_start_date == '' && $invite_end_date == '')
        {
            $str_sql_invite_date1 = "";
            $str_sql_invite_date2 = "";
        }
        else
        {

            if($invite_start_date != '' && $invite_end_date == '')
            {
                $str_sql_invite_date1 = " AND `request_sent_date` = '".date('Y-m-d',strtotime($invite_start_date))."' ";
                $str_sql_invite_date2 = " AND `request_sent_date` = '".date('Y-m-d',strtotime($invite_start_date))."' ";
            }

            elseif($invite_start_date == '' && $invite_end_date != '')
            {

                $str_sql_invite_date1 = " AND `request_sent_date` = '".date('Y-m-d',strtotime($invite_end_date))."' ";
                $str_sql_invite_date2 = " AND `request_sent_date` = '".date('Y-m-d',strtotime($invite_end_date))."' ";
            }

            else
            {

                $str_sql_invite_date1 = " AND `request_sent_date` >= '".date('Y-m-d',strtotime($invite_start_date))."' AND `request_sent_date` <= '".date('Y-m-d',strtotime($invite_end_date))."' ";
                $str_sql_invite_date2 = " AND `request_sent_date` >= '".date('Y-m-d',strtotime($invite_start_date))."' AND `request_sent_date` <= '".date('Y-m-d',strtotime($invite_end_date))."' ";

            }

        }

        if($status_start_date == '' && $status_end_date == '')
        {

            $str_sql_status_date1 = "";
            $str_sql_status_date2 = "";
        }
        else
        {

            if($status_start_date != '' && $status_end_date == '')
            {
                $str_sql_status_date1 = " AND `request_sent_date` = '".date('Y-m-d',strtotime($status_start_date))."' ";
                $str_sql_status_date2 = " AND `request_sent_date` = '".date('Y-m-d',strtotime($status_start_date))."' ";
            }

            elseif($invite_start_date == '' && $invite_end_date != '')
            {
                $str_sql_status_date1 = " AND `request_sent_date` = '".date('Y-m-d',strtotime($status_end_date))."' ";
                $str_sql_status_date2 = " AND `request_sent_date` = '".date('Y-m-d',strtotime($status_end_date))."' ";
            }

            else

            {
                $str_sql_status_date1 = " AND `request_sent_date` >= '".date('Y-m-d',strtotime($status_start_date))."' AND `request_sent_date` <= '".date('Y-m-d',strtotime($status_end_date))."' ";
                $str_sql_status_date2 = " AND `request_sent_date` >= '".date('Y-m-d',strtotime($status_start_date))."' AND `request_sent_date` <= '".date('Y-m-d',strtotime($status_end_date))."' ";
            }

        }
    $sql = "SELECT * FROM `tbladviserreferrals` WHERE "
            . "(`pro_user_id` = '".$user_id."' ".$str_sql_pro_user_id1." ".$str_sql_status1." ".$str_sql_invite_date1." ".$str_sql_status_date1." AND `invite_by_user` = '1') "
            . "OR (`user_email` = '".$user_email."'  ".$str_sql_pro_user_id2." ".$str_sql_status2." ".$str_sql_invite_date2." ".$str_sql_status_date2." AND `invite_by_user` = '0') "
            . " ORDER BY request_sent_date";
    //echo '<br>'.$sql;
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
		{
			$temp_arr[] = $row;
		}
	}
	return $temp_arr;

}
 

public function getProUserEmailById($pro_user_id)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$email = '';
	$sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '".$pro_user_id."'";

	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)

	{

		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$email = $row['vendor_email'];

	}

	return $email;

}

public function getUsersAdviserOptions($user_id,$pro_user_id)
{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$option_str = '';
        
	$email = $this->getUserEmailById($user_id);
        $sql = "SELECT tar.* , tpu.vendor_name as name FROM `tbladviserreferrals` AS tar "
                . "LEFT JOIN `tblvendors` AS tpu ON tar.user_email = tpu.vendor_email "
                . "WHERE (tar.user_email = '".$email."' OR tar.pro_user_id = '".$user_id."' ) AND tar.invite_by_user = '0' AND tar.request_status = '1'  "
                . "ORDER BY tpu.vendor_name ASC";
	
        //echo $sql;
        //echo '<br>';

	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 
		{
			if($row['pro_user_id'] == $pro_user_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['vendor_id'].'" '.$sel.'>'.stripslashes($row['name']).'</option>';

		}
	}

//        $sql = "SELECT tar.*, tpu.vendor_name as name, tpu.vendor_id AS puser_id FROM `tbladviserreferrals` AS tar "
//
//                . "LEFT JOIN `tblvendors` AS tpu ON tar.user_email = tpu.vendor_email  "
//
//                . "WHERE (tar.user_email = '".$email."' OR tar.pro_user_id = '".$user_id."' ) AND tar.invite_by_user = '1' AND tar.request_status = '1' "
//
//                . "ORDER BY tpu.vendor_name ASC";

	//echo $sql;

//        $STH2 = $DBH->prepare($sql);
//        $STH2->execute();
//	if($STH2->rowCount() > 0)
//	{
//
//		while($row = $STH2->fetch(PDO::FETCH_ASSOC) ) 
//
//		{
//			if($row['puser_id'] == $pro_user_id)
//			{
//				$sel = ' selected ';
//			}
//			else
//			{
//				$sel = '';
//			}		
//			$option_str .= '<option value="'.$row['puser_id'].'" '.$sel.'>'.stripslashes($row['name']).'</option>';
//		}
//	}

	return $option_str;
}

public function getProUserFullNameById($pro_user_id)
{
	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$return = false;
	$name = '';
	
	$sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '".$pro_user_id."'";
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$return = true;
		$name = stripslashes($row['vendor_name']);
	}
	return $name;
}

public function getMyFavList($user_id)
{
	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	//echo $_SESSION['user_id'];
	$arr_ufs_id = array(); 
	$arr_page_id = array(); 
	$arr_sc_id = array(); 
	$arr_ufs_note = array();
	$arr_ufs_cat_id = array();
	$arr_ufs_priority = array();    
	$arr_ufs_add_date = array();    
	
	$sql = "SELECT * FROM `tblusersfavscrolling` AS TA
			LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
			WHERE `user_id` = '".$user_id."' AND TA.ufs_status = '1' ORDER BY TS.menu_title ASC,TA.ufs_add_date DESC";
	
	
	//echo $sql;
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
		{
		  	array_push($arr_ufs_id , $row['ufs_id']);
			array_push($arr_page_id , stripslashes($row['page_id']));
			array_push($arr_sc_id , stripslashes($row['sc_id']));
			array_push($arr_ufs_note , stripslashes($row['ufs_note']));
			array_push($arr_ufs_cat_id , stripslashes($row['ufs_cat_id']));
			array_push($arr_ufs_priority , stripslashes($row['ufs_priority']));
			array_push($arr_ufs_add_date , stripslashes($row['ufs_add_date']));
		}
	}
	return array($arr_ufs_id,$arr_page_id,$arr_sc_id,$arr_ufs_note,$arr_ufs_cat_id,$arr_ufs_priority,$arr_ufs_add_date);

}


public function search_myfavlist($user_id,$page_id,$start_date,$end_date,$ufs_cat_id)

{	

    list($arr_ufs_id,$arr_page_id,$arr_menu_title,$arr_sc_id,$arr_ufs_note,$arr_ufs_cat_id,$arr_ufs_cat,$arr_ufs_priority,$arr_ufs_add_date,$arr_user_name,$arr_ufs_type) = $this->GetMyFavListDetails($user_id,$page_id,$start_date,$end_date,$ufs_cat_id);

    $output .='<table width="790" border="1" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">

                    <tr>

                        <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr No</strong></td>

                        <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Page Name</strong></td>

                        <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Window Title</strong></td>

                        <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Slider Title</strong></td>

                        <td width="15%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Content</strong></td>

                        <td width="15%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Note</strong></td>

                        <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Category</strong></td>

                        <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Priority</strong></td>

                        <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Date</strong></td>

                        <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Make Note</strong></td>

                        <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Delete</strong></td>

                    </tr>';

    if(count($arr_ufs_id) > 0)	

    {

        for($i=0,$j=1;$i<count($arr_ufs_id);$i++,$j++)

        {

            if($arr_ufs_type[$i] == '1')

            {

                $sw_header = '';

                list($sc_title,$sc_content_type,$sc_content,$box_desc,$credit_line,$credit_line_url,$rss_feed_item_id)  = $this->getSolutionItemDetails($arr_sc_id[$i]);

                if($sc_content_type == 'Flash') { 

                    $str_content = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="50" ><param name="movie" value="'.SITE_URL."/uploads/".$sc_content.'" /> <param name="wmode" value="transparent" /><param name="quality" value="high" /><embed src="'.SITE_URL."/uploads/".$sc_content.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="50"  wmode="transparent"></embed></object>';

                } elseif($sc_content_type == 'Image') { 

                    $str_content = '<img src="'.SITE_URL."/uploads/".$sc_content.'" width="50" height="50" border="0" />';

                } elseif($sc_content_type == 'Video') { 

                    $str_content = '<iframe width="50" src="'.$this->getSressBusterBannerString($sc_content).'" frameborder="0" allowfullscreen></iframe>';

                } elseif($sc_content_type == 'Audio') { 

                    $str_content = '<embed type="application/x-shockwave-flash" flashvars="audioUrl='.SITE_URL."/uploads/".$sc_content.'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="50" height="50" quality="best"  wmode="transparent"></embed>';

                } elseif($sc_content_type == 'Pdf') { 

                    $str_content = '<a href="'.SITE_URL."/uploads/".$sc_content.'" target="_blank">'.$sc_title.'</a>';   

                } elseif($sc_content_type == 'rss') { 

                    list($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json) = getRssFeedItemDetails($rss_feed_item_id);

                    $str_content .= '<a href="'.$rss_feed_item_link.'" target="_blank">'.$rss_feed_item_title.'</a>';   

                } elseif($sc_content_type == 'text') { 

                    $str_content .= $box_desc;   

                }         

            }

            else

            {

                list($sw_header,$sc_title,$sc_content_type,$sc_content,$sc_image,$sc_video,$sc_flash,$rss_feed_item_id)  = getScrollingContentDetailsForFavList($arr_sc_id[$i]);

                if($sc_content_type == 'image' )

                {

                    $str_content = '<img border="0" width="50" src="'.SITE_URL.'/uploads/'.$sc_image.'" >';

                }

                elseif($sc_content_type == 'video' )

                {

                    $str_content = '<iframe width="50" height="50" src="'.getBannerString($sc_video).'" frameborder="0" allowfullscreen></iframe>';

                }

                elseif($sc_content_type == 'flash' )

                {

                    $str_content = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="50" height="50"><param name="movie" value="'.SITE_URL."/uploads/".$sc_flash.'" /><param name="quality" value="high" /><embed src="'.SITE_URL."/uploads/".$sc_flash.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="50" height="50"></embed></object>';

                }

                elseif($sc_content_type == 'rss' )

                {

                    list($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json) = $this->getRssFeedItemDetails($rss_feed_item_id);

                    $str_content = $rss_feed_item_title;

                }

                else

                {

                    $str_content = $sc_content;

                }

            }

						

            $date = date('d-M-Y',strtotime($arr_ufs_add_date[$i]));



            if($arr_ufs_priority[$i] == '1' )

            {

                    $priority = 'Yes';

            }

            else

            {

                    $priority = 'No';

            }



            //if($arr_ufs_cat_id[$i] > 0)

            //{

                    $ufs_cat = $arr_ufs_cat[$i];

            //}

            //else

            //{

                    //$ufs_cat = '';

            //}					

											

							

		$output .= '	<tr>

                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$j.'</td>

                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$arr_menu_title[$i].'</td>

                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$sw_header.'</td>

                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$sc_title.'</td>

                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$str_content.'</td>

                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$arr_ufs_note[$i].'</td>

                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$ufs_cat.'</td>

                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$priority.'</td>

                                    <td  align="center" class="footer" valign="top" bgcolor="#FFFFFF">'. $date .'</td>

                                    <td  align="center" valign="top" bgcolor="#FFFFFF" class="footer">';

		$output .= '            <input class="btnNote" name="btnNote" id="btnNote"  type="button" value="Note" onclick="MakeNoteForFavList(\''.$arr_ufs_id[$i].'\',\''.$arr_page_id[$i].'\')"/></td>';

		$output .= '        <td  align="center" valign="top" bgcolor="#FFFFFF" class="footer">

					<input  type="button" value="Delete"  onclick="Delete_MyFavItem(\''.$arr_ufs_id[$i].'\')"/>

                                    </td>

				</tr>';

        }

    }

    else

    {

    $output .= '	<tr style="background:#FFFFFF;"><td align="center" colspan="11">No Record Found</td></tr>';	   

    }

    $output .= '</table>';

    return $output;

}

public function GetMyFavListDetails($user_id,$page_id,$start_date,$end_date,$ufs_cat_id)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$arr_ufs_id = array(); 
	$arr_page_id = array(); 
	$arr_menu_title = array(); 
	$arr_sc_id = array(); 
	$arr_ufs_note = array();
	$arr_ufs_cat_id = array();
	$arr_ufs_cat = array();
	$arr_ufs_priority = array();    
	$arr_ufs_add_date = array();   
	$arr_user_name = array(); 
        $arr_ufs_type = array(); 

	if($page_id != '')
	{
		$str_page_id = " AND TA.page_id = '".$page_id."' ";	
	}
	else
	{
		$str_page_id = "";	
	}

	if($ufs_cat_id != '')

	{
		$str_ufs_cat_id = " AND TA.ufs_cat_id = '".$ufs_cat_id."' ";	
	}
	else
	{
		$str_ufs_cat_id = "";	
	}

	if($user_id != '')

	{

		$str_user_id = " AND TA.user_id = '".$user_id."' ";	

	}

	else

	{

		$str_user_id = "";	

	}

	

	$sql = "SELECT TA.* , TS.menu_title , TFC.fav_cat , TU.name FROM `tblusersfavscrolling` AS TA

			LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id

			LEFT JOIN `tblfavcategory` TFC ON TA.ufs_cat_id = TFC.fav_cat_id

			LEFT JOIN `tblusers` TU ON TA.user_id = TU.user_id

			WHERE DATE(TA.ufs_add_date) >= '".date('Y-m-d',strtotime($start_date))."' AND DATE(TA.ufs_add_date) <= '".date('Y-m-d',strtotime($end_date))."' ".$str_user_id." ".$str_page_id." ".$str_ufs_cat_id." AND TA.ufs_status = '1' ORDER BY TS.menu_title ASC,TA.ufs_add_date DESC";			

	

	//echo $sql;

	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{

		while($row = $STH->fetch(PDO::FETCH_ASSOC))

		{

		  	array_push($arr_ufs_id , $row['ufs_id']);

			array_push($arr_page_id , stripslashes($row['page_id']));

			array_push($arr_menu_title , stripslashes($row['menu_title']));

			array_push($arr_sc_id , stripslashes($row['sc_id']));

			array_push($arr_ufs_note , stripslashes($row['ufs_note']));

			array_push($arr_ufs_cat_id , stripslashes($row['ufs_cat_id']));

			array_push($arr_ufs_cat , stripslashes($row['fav_cat']));

			array_push($arr_ufs_priority , stripslashes($row['ufs_priority']));

			array_push($arr_ufs_add_date , stripslashes($row['ufs_add_date']));

			array_push($arr_user_name , stripslashes($row['name']));

                        array_push($arr_ufs_type , stripslashes($row['ufs_type']));

		}

	}

	return array($arr_ufs_id,$arr_page_id,$arr_menu_title,$arr_sc_id,$arr_ufs_note,$arr_ufs_cat_id,$arr_ufs_cat,$arr_ufs_priority,$arr_ufs_add_date,$arr_user_name,$arr_ufs_type);



}


public function getSolutionItemDetails($sol_item_id)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

	$box_title = '';
	$box_type = '';
	$banner = '';
	$box_desc = '';
	$credit_line = '';
	$credit_line_url = '';
        $rss_feed_item_id = '';

	$sql = "SELECT * FROM `tblsolutionitems` WHERE sol_item_id = '".$sol_item_id."' ";

	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{

            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $box_title = stripslashes($row['sol_box_title']);
            $banner_type = stripslashes($row['sol_box_type']);    
            $banner = stripslashes($row['sol_box_banner']);
            $box_desc = stripslashes($row['sol_box_desc']);
            $credit_line = stripslashes($row['sol_credit_line']);
            $credit_line_url = stripslashes($row['sol_credit_line_url']);
            $rss_feed_item_id = stripslashes($row['rss_feed_item_id']);

	}	

	return array($box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url,$rss_feed_item_id);

}	


public function getFavCategoryOptions($fav_cat_id)
{
	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_type_id` IN (1,2) AND `fav_cat_status` = '1' AND `fav_cat_deleted` = '0' ORDER BY `fav_cat` ASC";
	//echo $sql;
	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
		{
			if($row['fav_cat_id'] == $fav_cat_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			
			
			$option_str .= '<option value="'.$row['fav_cat_id'].'" '.$sel.'>'.stripslashes($row['fav_cat']).'</option>';
		}
	}
	return $option_str;
}


public function getScrollingWindowsPagesOptions($page_id)
{
	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_list` = '1' ORDER BY `menu_title` ASC";
	//echo $sql;
	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
		{
			if($row['page_id'] == $page_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			
			
			$option_str .= '<option value="'.$row['page_id'].'" '.$sel.'>'.stripslashes($row['menu_title']).'</option>';
		}
	}
	return $option_str;
}


public function getMyLibrary($user_id)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$arr_library_id = array(); 
	$arr_page_id = array(); 
	$arr_values = array();
	$arr_library_add_date = array();
	$arr_note = array();    

		$sql = "SELECT * FROM `tbllibrary` AS TA

				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id

				 WHERE `user_id` = '".$user_id."' AND TA.status = '1' ORDER BY TA.library_add_date DESC";

	

	

	//echo $sql;

	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))

		{

		  	array_push($arr_library_id , $row['library_id']);
			array_push($arr_page_id , stripslashes($row['page_id']));
			array_push($arr_values , stripslashes($row['values']));
			array_push($arr_library_add_date , stripslashes($row['library_add_date']));
			array_push($arr_note , stripslashes($row['note']));
		}

	}

	return array($arr_library_id,$arr_page_id,$arr_values,$arr_library_add_date,$arr_note);

}




public function GetMyLibrary_Details($user_id,$page_id,$start_date)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$arr_library_id = array(); 
	$arr_page_id = array(); 
	$arr_values = array();
	$arr_library_add_date = array();
	$arr_note = array();    
	if($user_id != '' && $page_id == '' && $start_date == '')

	{

		$sql = "SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				 WHERE `user_id` = '".$user_id."' AND TA.status = '1' ORDER BY TA.library_add_date DESC";	
	}

	elseif($page_id != '' && $start_date == '')

	{

		$sql = "SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				 WHERE `user_id` = '".$user_id."' AND TA.page_id ='".$page_id."' AND TA.status = '1' ORDER BY TA.library_add_date DESC";	

	}

	elseif($start_date != '' && $page_id == '')

	{

		$sql = "SELECT * FROM `tbllibrary` AS TA
                        LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
                        WHERE `user_id` = '".$user_id."' AND DATE(TA.library_add_date) ='".$start_date."' AND TA.status = '1' ORDER BY TA.library_add_date DESC";	

	}

	elseif($start_date != '' && $page_id != '')
	{
		$sql = "SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				WHERE `user_id` = '".$user_id."' AND DATE(TA.library_add_date) ='".$start_date."' AND TA.page_id ='".$page_id."' AND TA.status = '1' ORDER BY TA.library_add_date DESC";	

	}
	//echo $sql;

	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		while($row = $STH->fetch(PDO::FETCH_ASSOC))
		{
		  	array_push($arr_library_id , $row['library_id']);
			array_push($arr_page_id , stripslashes($row['page_id']));
			array_push($arr_values , stripslashes($row['values']));
			array_push($arr_library_add_date , stripslashes($row['library_add_date']));
			array_push($arr_note , stripslashes($row['note']));
		}
	}
	return array($arr_library_id,$arr_page_id,$arr_values,$arr_library_add_date,$arr_note);



}


public function get_PageName($page_id)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$page_name = '';
	$sql ="SELECT * FROM `tblpages` WHERE  `page_id` = '".$page_id."' ";	

	//echo $sql;

	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{

		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$page_name = stripslashes($row['page_name']);

	}	

	return $page_name;

}

public function get_library_pdf($page_id,$values)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

	$pdf = '';
	
	if($page_id == '44')

	{

		$sql ="SELECT * FROM `tblmindjumblepdf` WHERE mind_jumble_pdf_id =  '".$values."'";

	}

	elseif($page_id == '10')

	{

		$sql ="SELECT * FROM `tblangerventpdf` WHERE anger_vent_pdf_id =  '".$values."'";

	}

	elseif($page_id == '9')

	{

		$sql ="SELECT * FROM `tblstressbusterpdf` WHERE stress_buster_pdf_id = '".$values."'";

	}

        elseif($page_id == '127')

	{

		$sql ="SELECT * FROM `tblsolutionitems` WHERE sol_item_id = '".$values."'";

	}

	//echo $sql.'<br/>';

	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{
		$row = $STH->fetch(PDO::FETCH_ASSOC);
                if($page_id == '127')

                {
                    $pdf = stripslashes($row['sol_box_banner']);
                    $pdf_title = stripslashes($row['sol_box_title']); 

                }
                else
                {
                    $pdf = stripslashes($row['pdf']);
                    $pdf_title = stripslashes($row['pdf_title']);
                }    

	}
	return array($pdf,$pdf_title);

}	


public function Library_Feedback($page_id)

  	{

		$temp_page_id = $this->getTemppageId($page_id);

		

			$output .='<form id="frm_feedback" name="frm_feedback" method="post" action="#" enctype="multipart/form-data">

                             <input type="hidden" name="main_page_id" id="main_page_id" value="'.$main_page_id.'" />

							 <input type="hidden" name="hdn_p_id" id="hdn_p_id" value="" />

							 <table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">

								<tr>

								  <td width="60%" align="left" valign="top">&nbsp;</td>

								  <td width="40%" align="left" valign="top">&nbsp;</td>

							  	</tr>

							  </table>				

                              <table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">

									<tr>

										 <td width="60%" height="40" align="left" valign="top">Subject:</td>

										 <td width="40%" height="40" align="left" valign="top">

											<select id="temp_page_id" name="temp_page_id">

											  '.getFeeadBackPages($temp_page_id).'

											 </select>

										</td>

                                   </tr>';

                                  	if($this->isLoggedIn())

									{

										$user_id = $_SESSION['user_id'];

										$name = $this->getUserFullNameById($user_id);

										$email = $this->getUserEmailById($user_id);

										$readonly = ' readonly ';

									}

									else

									{

										$readonly = '';

									}

													

             $output .='<tr>

						  <td width="60%" height="40" align="left" valign="top">Name:</td>

						  <td width="40%" height="40" align="left" valign="top">

								<input type="text" id="name" name="name"'.$readonly.'value="'.$name.'"/>

						   </td>

					  </tr>

					  <tr>

						 <td width="60%" height="40" align="left" valign="top">Email:</td>

						 <td width="40%" height="40" align="left" valign="top">

							<input type="text" id="email" name="email"'.$readonly.' value="'.$email.'"/>

						  </td>

					  </tr>

					  <tr>

						<td width="60%" height="110" align="left" valign="top">Feedback and Suggestions:</td>

						<td width="40%" height="110" align="left" valign="top">

							<textarea  cols="30" rows="5" type="text" id="feedback" name="feedback">'.$textarea.'</textarea>

						</td>

					 </tr>

					 <tr>

						<td width="60%" height="40" align="left" valign="middle">&nbsp;</td>

						<td width="40%" height="40" align="left" valign="middle"><input name="submit" type="button" class="button" id="submit" value="Submit"  onclick="GetFeedback()"/>

						</td>

					</tr>	

				  </table>

	

				</form>';

	 

	return $output;

}


public function Make_Note($library_id,$page_id)

  	{

		list($page_name,$pdf_title,$note) = $this->Make_Note_Details($library_id,$page_id);

	

			$output .='<table border="0" width="75%" cellpadding="0" cellspacing="0">

						<tr>

							 <td width="30%" height="40" align="right" valign="top">&nbsp;</td>

							 <td width="5%" height="40" align="center" valign="top">&nbsp;</td>

							 <td width="45%" height="40" align="left" valign="top">&nbsp;</td>

						</tr>

						<tr>

							 <td width="30%" height="40" align="right" valign="top"><strong>Page Name</strong></td>

							 <td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>

							 <td width="45%" height="40" align="left" valign="top">'.$page_name.'</td>

						</tr>

						<tr>

							 <td width="30%" height="40" align="right" valign="top"><strong>PDF:</strong></td>

							 <td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>

							 <td width="45%" height="40" align="left" valign="top">'.$pdf_title.'</td>

						</tr>';

			  $output .='<tr>

						   <td width="30%" height="40" align="right" valign="top"><strong>Note:</strong></td>

						   <td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>

						   <td width="45%" height="40" align="left" valign="top"><textarea  cols="30" rows="5" type="text" id="note" name="note">'.$note.'</textarea></td>

					   </tr>';

			  $output .='<tr>

							 <td width="30%" height="20" align="right" valign="top">&nbsp;</td>

							 <td width="5%" height="20" align="center" valign="top">&nbsp;</td>

							 <td width="45%" height="20" align="left" valign="top">&nbsp;</td>

						</tr>

						<tr>

						    <td width="30%" height="20" align="right" valign="top">&nbsp;</td>

						    <td width="5%" height="20" align="center" valign="top">&nbsp;</td>

						    <td width="45%" height="20" align="left" valign="top"><input class="btnNote" name="btnNote" id="btnNote"  type="button" value="Save" onclick="Save_Note('.$library_id.')" />

					   </tr>';

			$output .='</table>';

	 

	return $output;

}

public function Make_Note_Details($library_id,$page_id)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$page_name = '';
	$pdf_title = '';
	$note = '';

	if($page_id == '44')

	{
		$sql  ="SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				LEFT JOIN `tblmindjumblepdf` TP ON TA.values = TP.mind_jumble_pdf_id  
				WHERE `library_id` = '".$library_id."'";
	}
	elseif($page_id == '10')
	{

		$sql  ="SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				LEFT JOIN `tblangerventpdf` TP ON TA.values = TP.anger_vent_pdf_id  
				WHERE `library_id` = '".$library_id."'";

	}

	elseif($page_id == '9')

	{
		$sql  ="SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				LEFT JOIN `tblstressbusterpdf` TP ON TA.values = TP.stress_buster_pdf_id  
				WHERE `library_id` = '".$library_id."'";

	}

        elseif($page_id == '127')

	{

		$sql  ="SELECT * FROM `tbllibrary` AS TA
				LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
				LEFT JOIN `tblsolutionitems` TP ON TA.values = TP.sol_item_id  
				WHERE `library_id` = '".$library_id."'";

	}

 

 	$STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
	{

		$row = $STH->fetch(PDO::FETCH_ASSOC);

		$page_name = stripslashes($row['page_name']);

                if($page_id == '127')

                {

                    $pdf_title = stripslashes($row['sol_box_title']);

                }

                else

                {

                    $pdf_title = stripslashes($row['pdf_title']);

                }

                $note = stripslashes($row['note']);

		

	}	

	return array($page_name,$pdf_title,$note);

}


public function search_library($user_id,$page_id,$start_date)

  	{	

		list($arr_library_id,$arr_pg_id,$arr_values,$arr_library_add_date,$arr_note) = $this->GetMyLibrary_Details($user_id,$page_id,$start_date);

		

         $output .='<table width="100%" border="1" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">

                        		<tr>

									<td width="30"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr No</strong></td>

			    					<td width="130"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Page Name</strong></td>

               						<td width="190"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>PDF</strong></td>

                                    <td width="80"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Note</strong></td>

                                    <td width="70"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Date</strong></td>

                                    <td width="50"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Make Note</strong></td>

                                    <td width="30"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Delete</strong></td>

                          		</tr>';

                        	if(count($arr_library_id) > 0)	

							{

								for($i=0,$j=1;$i<count($arr_library_id);$i++,$j++)

									{ 

								   		$page_name = $this->get_PageName($arr_pg_id[$i]);

										

											list($pdf,$pdf_title)  = $this->get_library_pdf($arr_pg_id[$i],$arr_values[$i]);

											

											$date = date('d-M-Y',strtotime($arr_library_add_date[$i]));

											

											if($page_name == '')

												{

												   $page_name = 'General';

												}

											else{

													$page_name = $page_name;

												}

							

			$output .='		   <tr>

                                  <td  align="center" valign="top" bgcolor="#FFFFFF">'.$j.'</td>

                                  <td  align="center" valign="top" bgcolor="#FFFFFF">'.$page_name.'</td>

                                  <td  align="left" valign="top" bgcolor="#FFFFFF" class="footer"><a href="'.SITE_URL."/uploads/".$pdf.'" target="_blank" class="body_link">'.$pdf_title.'</a></td>

                                   <td  align="center" valign="top" bgcolor="#FFFFFF">'.$arr_note[$i].'</td>

                                  <td  align="center" class="footer" valign="top" bgcolor="#FFFFFF">'. $date .'</td>

                                   <td  align="center" valign="top" bgcolor="#FFFFFF" class="footer">';

            $output .='           <input class="btnNote" name="btnNote" id="btnNote"  type="button" value="Note" onclick="MakeNote(\''.$arr_library_id[$i].'\',\''.$arr_pg_id[$i].'\')"/></td>';

			$output .='	      <td  align="center" valign="top" bgcolor="#FFFFFF" class="footer">

                                  <input  type="button" value="Delete"  onclick="Delete_libraryPDF(\''.$arr_library_id[$i].'\')"/></td>

                               </tr>';

							   }

							   }

							   else

							   {

			$output .='			<tr style="background:#FFFFFF;"><td align="center" colspan="7">No Record Found</td></tr>';	   

							   }

                           		 

			$output .='</table>';

	 

	return $output;

}

public function getUserIdReset($email)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$user_id = 0;
	$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `status` = '1'";

	$STH = $DBH->prepare($sql);
        $STH->execute();

	if($STH->rowCount() > 0)
        {

		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$user_id = $row['user_id'];

	}

	return $user_id;

}

public function ResetPassword($password,$user_id)

{

	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

	$return = false;

	$sql = "UPDATE `tblusers` set `password` = '".md5($password)."' where user_id = '".$user_id."'";

	$STH = $DBH->prepare($sql);
        $STH->execute();

	if($STH->rowCount() > 0)
        {

		$return = true;	

	}

	return $return;	

}

public function chkVendorEmailExists($email)
{
	$my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$return = false;
	
	$sql = "SELECT * FROM `tblvendors` WHERE `vendor_email` = '".$email."'";
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
		$return = true;
	}
	return $return;
}

public function AddUserUploads($data)
{
        $DBH = new DatabaseHandler();
	$return = false;
        $sql = "INSERT INTO `tbl_user_uploads`(`user_id`, `banner_type`, `rss_text`, `video_url`, `image_video_audio_pdf_credit_line`, `image_video_audio_pdf_credit_url`, `documents_credit_line`, `documents_credit_url`, `image_video_audio_pdf`, `documents`, `from_page`,`ref_code`,`box_title`,`sub_cat_id`) "
                . "VALUES ('".$data['user_id']."','".addslashes($data['banner_type'])."','".addslashes($data['rss_text'])."','".addslashes($data['video_url'])."','".addslashes($data['image_video_audio_pdf_credit_line'])."','".addslashes($data['image_video_audio_pdf_credit_url'])."','".addslashes($data['documents_credit_line'])."','".addslashes($data['documents_credit_url'])."','".addslashes($data['image_video_audio_pdf'])."','".addslashes($data['documents'])."','".addslashes($data['from_page'])."','".addslashes($data['ref_code'])."','".addslashes($data['box_title'])."','".addslashes($data['sub_cat_id'])."')";
        $STH = $DBH->query($sql);
        
        if($STH->rowCount() > 0)
        {
           $return = true;
        }
	return $return;   
}

public function getDesignIconByProfCat($profile_cat,$day_month_year)
{
 
        $DBH = new DatabaseHandler();
	$sql = "SELECT * FROM `tbl_icons` WHERE `fav_cat_type_id` = '".$profile_cat."' and status = 1 ORDER BY `icons_id` ASC";
	$STH = $DBH->query($sql);
        $data = array();
        
       $single_date = date("Y-m-d",strtotime($day_month_year));
       //echo '<br>';
       $all = date("d",strtotime($day_month_year));
       //echo '<br>';
       $month_wise = date("m",strtotime($day_month_year));
       //echo '<br>';
       $days_of_week = date('w', strtotime($day_month_year));
        
        
        
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {
              //$data =  $row;
                
//              echo '<pre>';
//              print($row);
//              echo '</pre>';
                
                //echo $row['listing_date_type'];
                //echo '<br>';
                
              if($row['listing_date_type'] == 'single_date')
              {
                 
                 if($single_date == $row['single_date']) 
                 {
                     $data[]= $row;
                 }
                  
              }
              elseif($row['listing_date_type'] == 'all')
              {
                 $all_arr = explode(',', $row['days_of_month']);
                 if(in_array($all, $all_arr))
                 {
                     $data[]= $row;
                 } 
              }
              elseif($row['listing_date_type'] == 'days_of_month')
              {
                 $all_arr = explode(',', $row['days_of_month']);
                 if(in_array($all, $all_arr))
                 {
                     $data[]= $row;
                 }  
              }
              elseif($row['listing_date_type'] == 'date_range')
              {
                if(($row['start_date'] >=$single_date) && ($single_date<= $row['end_date']) ) 
                 {
                     $data[]= $row;
                 }  
              }
              elseif($row['listing_date_type'] == 'month_wise')
              {
                 $all_arr = explode(',', $row['months']);
                 if(in_array($month_wise, $all_arr))
                 {
                     $data[]= $row;
                 }    
              }
              elseif($row['listing_date_type'] == 'days_of_week')
              {
                 $all_arr = explode(',', $row['days_of_week']);
                 if(in_array($days_of_week, $all_arr))
                 {
                     $data[] = $row;
                 }    
              }
              
            }
           // $row = $STH->fetch(PDO::FETCH_ASSOC);
            
	}
	return $data;  
    
}

public function GetRefNumer($sub_cat_id)
{
 
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$refcode = '';
	
	$sql = "SELECT * FROM `tbl_design_your_life` WHERE `sub_cat_id` = '".$sub_cat_id."' and `show_to_user` = 1  ";
	$STH = $DBH->prepare($sql);
        $STH->execute();
	if($STH->rowCount() > 0)
	{
                $row = $STH->fetch(PDO::FETCH_ASSOC);
		$refcode = $row['ref_code'];
	}
	return $refcode;  
    
}


public function Post_user_design_data($data)
{
        $my_DBH = new DatabaseHandler();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
	$return = false;
        
        echo $sql = "INSERT INTO `tbl_user_design_your_data`(`user_id`, `box_title`,`ref_code`,`listing_date_type`, `days_of_month`, `single_date`, `start_date`, `end_date`, `days_of_week`, `months`, `location_fav_cat`, `user_response_fav_cat`,`user_what_fav_cat`,`alerts_fav_cat`,`bes_time`,`duration`,`scale`,`comment`,`sub_cat3_link`,`sub_cat4_link`,`sub_cat3`,`sub_cat4`) "
                . "VALUES ('".$data['user_id']."','".addslashes($data['title_id'])."','".addslashes($data['ref_code'])."','".addslashes($data['listing_date_type'])."','".addslashes(implode(',', $data['days_of_month']))."','".addslashes(date("Y-m-d",strtotime($data['single_date'])))."','".addslashes(date("Y-m-d",strtotime($data['start_date'])))."','".addslashes(date("Y-m-d",strtotime($data['end_date'])))."','".addslashes(implode(',', $data['days_of_week']))."','".addslashes(implode(',', $data['months']))."','".addslashes($data['location'])."','".addslashes($data['User_view'])."','".addslashes($data['User_Interaction'])."','".addslashes($data['alert'])."','".addslashes($data['bes_time'])."','".addslashes($data['duration'])."','".addslashes($data['scale'])."','".addslashes($data['comment'])."','".addslashes($data['fetch_link'])."','".addslashes($data['fetch_link_2'])."','".addslashes($data['sub_cat3'])."','".addslashes($data['sub_cat4'])."')";
        //die();
        $STH = $DBH->prepare($sql);
        $STH->execute();
        
        if($STH->rowCount() > 0)
        {
            
            $id = $DBH->lastInsertId(); 
            $data['design_data_id'] = $id;
            
            if(!empty($data['fav_cat_2']))
            {
              $data_arr = array_values(array_filter($data['fav_cat_2']));
              
//              echo '<pre>';
//              print_r($data_arr);
//              echo '</pre>';
//              die();
//              
              
              for($i=0;$i<count($data_arr);$i++)
              {
                $final = array();
                $final['fav_cat_2']=$data_arr[$i];
                $final['user_id']=$data['user_id'];
                $final['design_data_id']=$data['design_data_id'];
                $this->userdata_fav_cat_2($final);  
              }
            }
            
            if(!empty($data['user_input']))
            {
              $data_arr = array_values(array_filter($data['user_input']));
              
              for($i=0;$i<count($data_arr);$i++)
              {
                $final = array();
                $final['user_input']=$data_arr[$i];
                $final['user_id']=$data['user_id'];
                $final['design_data_id']=$data['design_data_id'];
                $this->userdata_inputs($final);
              }
            }
            
            $DBH->commit();
            $return = true;
        }
	return $return;    
    
}


public function userdata_fav_cat_2($data)
{
        $DBH = new DatabaseHandler();
	$return = false;
        $sql = "INSERT INTO `tbl_user_design_favcat_data`(`user_id`, `fav_cat_2`,`design_data_id`) "
                . "VALUES ('".$data['user_id']."','".addslashes($data['fav_cat_2'])."','".addslashes($data['design_data_id'])."')";
        $STH = $DBH->query($sql);
        
        if($STH->rowCount() > 0)
        {
           $return = true;
        }
	return $return;       
}

public function userdata_inputs($data)
{
        $DBH = new DatabaseHandler();
	$return = false;
        $sql = "INSERT INTO `tbl_design_user_inputs`(`user_id`, `user_input`,`design_data_id`) "
                . "VALUES ('".$data['user_id']."','".addslashes($data['user_input'])."','".addslashes($data['design_data_id'])."')";
        $STH = $DBH->query($sql);
        
        if($STH->rowCount() > 0)
        {
           $return = true;
        }
	return $return;   
}

public function getDesignIconByFavCat($fav_cat)
{
 
        $DBH = new DatabaseHandler();
	$icon = '';		
	$sql = "SELECT * FROM `tbl_icons` WHERE `fav_cat_id` = '".$fav_cat."' ORDER BY `icons_add_date` DESC LIMIT 1";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)
	{
                $row = $STH->fetch(PDO::FETCH_ASSOC);
		$icon = $row['image'];

	}

	return $icon; 
    
}

public function get_user_reports_permissions($user_id)

	{

		$DBH = new DatabaseHandler();

		$food_chart = 0;

		$each_meal_per_day_chart=0;

		$my_activity_calories_chart = 0;

		$my_activity_calories_pi_chart = 0;		

		$activity_analysis_chart = 0;

		$meal_chart = 0;	

		$dpwd_chart = 0;	

		$mwt_report = 0;

		$datewise_emotions_report = 0;

		$statementwise_emotions_report = 0;

		$statementwise_emotions_pi_report = 0;	

		$angervent_intensity_report = 0;

		$stressbuster_intensity_report = 0;

				

		$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";

		//echo $sql;

		$STH = $DBH->query($sql);
                if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$food_chart = $row['food_chart'];
			$each_meal_per_day_chart = $row['each_meal_per_day_chart'];
			$my_activity_calories_chart = $row['my_activity_calories_chart'];
			$my_activity_calories_pi_chart = $row['my_activity_calories_pi_chart'];
			$activity_analysis_chart = $row['activity_analysis_chart'];
			$meal_chart = $row['meal_chart'];
			$dpwd_chart = $row['dpwd_chart'];
			$mwt_report = $row['mwt_report'];
			$datewise_emotions_report = $row['datewise_emotions_report'];
			$statementwise_emotions_report = $row['statementwise_emotions_report'];
			$statementwise_emotions_pi_report = $row['statementwise_emotions_pi_report'];
			$angervent_intensity_report = $row['angervent_intensity_report'];
			$stressbuster_intensity_report = $row['stressbuster_intensity_report'];
		}

		return array($food_chart,$each_meal_per_day_chart,$my_activity_calories_chart,$my_activity_calories_pi_chart,$activity_analysis_chart,$meal_chart,$dpwd_chart,$mwt_report,$datewise_emotions_report,$statementwise_emotions_report,$statementwise_emotions_pi_report,$angervent_intensity_report,$stressbuster_intensity_report);

	}

function getModuleWiseKeywordsOptions($user_id,$report_module,$pro_user_id,$module_keyword)

{

    $DBH = new DatabaseHandler();

    $option_str = '';

    if($pro_user_id == '')

    {

        $sql_str_pro = "";

    }

    else

    {

        $sql_str_pro = " AND `practitioner_id` = '".$pro_user_id."' ";

    }

    

    //echo '<br>user_id = '.$user_id.' , report_module = '.$report_module;

    

    if($report_module == 'wae_report' || $report_module == '15')

    {

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `selected_wae_id` FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {
            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['selected_wae_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        $sql = "SELECT * FROM `tblworkandenvironments` WHERE `wae_id` IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `wae_add_date` DESC ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {
        

            $return = true;
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $practitioner_id = $row['practitioner_id'];

                $str_user_id = $row['user_id'];

                $country_id = $row['country_id'];

                $str_state_id = $row['state_id'];

                $str_city_id = $row['city_id'];

                $str_place_id = $row['place_id'];

                

                if($pro_user_id == '' || $pro_user_id == '0')

                {

                    //echo '<br>in if';

                    $add_to_record = true;

                }

                else

                {

                    //echo '<br>in else';

                    $add_to_record = $this->chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);

                }

                



                if($add_to_record)

                {

                    if($row['wae_id'] == $module_keyword)

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['wae_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }	

            }

        }

    }

    elseif($report_module == 'gs_report' || $report_module == '16')

    {

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `selected_gs_id` FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['selected_gs_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        $sql = "SELECT * FROM `tblgeneralstressors` WHERE `gs_id` IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `gs_add_date` DESC ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $practitioner_id = $row['practitioner_id'];

                $str_user_id = $row['user_id'];

                $country_id = $row['country_id'];

                $str_state_id = $row['state_id'];

                $str_city_id = $row['city_id'];

                $str_place_id = $row['place_id'];



                if($pro_user_id == '' || $pro_user_id == '0')

                {

                    //echo '<br>in if';

                    $add_to_record = true;

                }

                else

                {

                    //echo '<br>in else';

                    $add_to_record = $this->chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);

                }



                if($add_to_record)

                {

                    if($row['gs_id'] == $module_keyword)

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['gs_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }	

            }

        }

    }

    elseif($report_module == 'sleep_report' || $report_module == '17')

    {

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `selected_sleep_id` FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['selected_sleep_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        $sql = "SELECT * FROM `tblsleeps` WHERE `sleep_id` IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `sleep_add_date` DESC ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $practitioner_id = $row['practitioner_id'];

                $str_user_id = $row['user_id'];

                $country_id = $row['country_id'];

                $str_state_id = $row['state_id'];

                $str_city_id = $row['city_id'];

                $str_place_id = $row['place_id'];



                if($pro_user_id == '' || $pro_user_id == '0')

                {

                    //echo '<br>in if';

                    $add_to_record = true;

                }

                else

                {

                    //echo '<br>in else';

                    $add_to_record = $this->chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);

                }



                if($add_to_record)

                {

                    if($row['sleep_id'] == $module_keyword)

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['sleep_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }	

            }

        }

    }

    elseif($report_module == 'mc_report' || $report_module == '18')

    {

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `selected_mc_id` FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_old_data` = '0' ";

        //echo '<br>'.$sql;

       $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['selected_mc_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        $sql = "SELECT * FROM `tblmycommunications` WHERE `mc_id` IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `mc_add_date` DESC ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $practitioner_id = $row['practitioner_id'];

                $str_user_id = $row['user_id'];

                $country_id = $row['country_id'];

                $str_state_id = $row['state_id'];

                $str_city_id = $row['city_id'];

                $str_place_id = $row['place_id'];



                if($pro_user_id == '' || $pro_user_id == '0')

                {

                    //echo '<br>in if';

                    $add_to_record = true;

                }

                else

                {

                    //echo '<br>in else';

                    $add_to_record = $this->chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);

                }

                

                if($add_to_record)

                {

                    if($row['mc_id'] == $module_keyword)

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['mc_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }	

            }

        }

    }

    elseif($report_module == 'mr_report' || $report_module == '19')

    {

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `selected_mr_id` FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['selected_mr_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        $sql = "SELECT * FROM `tblmyrelations` WHERE `mr_id` IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `mr_add_date` DESC ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $practitioner_id = $row['practitioner_id'];

                $str_user_id = $row['user_id'];

                $country_id = $row['country_id'];

                $str_state_id = $row['state_id'];

                $str_city_id = $row['city_id'];

                $str_place_id = $row['place_id'];



                if($pro_user_id == '' || $pro_user_id == '0')

                {

                    //echo '<br>in if';

                    $add_to_record = true;

                }

                else

                {

                    //echo '<br>in else';

                    $add_to_record = $this->chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);

                }



                if($add_to_record)

                {

                    if($row['mr_id'] == $module_keyword)

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['mr_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }	

            }

        }

    }

    elseif($report_module == 'mle_report' || $report_module == '20')

    {

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `selected_mle_id` FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['selected_mle_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        $sql = "SELECT * FROM `tblmajorlifeevents` WHERE mle_id IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `mle_add_date` DESC ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

             while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $practitioner_id = $row['practitioner_id'];

                $str_user_id = $row['user_id'];

                $country_id = $row['country_id'];

                $str_state_id = $row['state_id'];

                $str_city_id = $row['city_id'];

                $str_place_id = $row['place_id'];



                if($pro_user_id == '' || $pro_user_id == '0')

                {

                    //echo '<br>in if';

                    $add_to_record = true;

                }

                else

                {

                    //echo '<br>in else';

                    $add_to_record = $this->chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);

                }



                if($add_to_record)

                {

                    if($row['mle_id'] == $module_keyword)

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['mle_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }	

            }

        }

    }

    elseif($report_module == 'adct_report' || $report_module == '21')

    {

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `selected_adct_id` FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['selected_adct_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        $sql = "SELECT * FROM `tbladdictions` WHERE `adct_id` IN (".$bms_id_str.") AND `status` = '1' ".$sql_str_pro." ORDER BY `listing_order` ASC , `adct_add_date` DESC ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {

                $practitioner_id = $row['practitioner_id'];

                $str_user_id = $row['user_id'];

                $country_id = $row['country_id'];

                $str_state_id = $row['state_id'];

                $str_city_id = $row['city_id'];

                $str_place_id = $row['place_id'];



                if($pro_user_id == '' || $pro_user_id == '0')

                {

                    //echo '<br>in if';

                    $add_to_record = true;

                }

                else

                {

                    //echo '<br>in else';

                    $add_to_record = $this->chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id);

                }



                if($add_to_record)

                {

                    if($row['adct_id'] == $module_keyword)

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['adct_id'].'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }	

            }

        }

    }

    elseif($report_module == 'bps_report' || $report_module == '22')

    {

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersbps` WHERE `user_id` = '".$user_id."' AND `bps_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN (".$bms_id_str.") AND `bmst_id` = '1' AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {
        

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['bms_id'] == $module_keyword)

                {

                    $sel = ' selected ';

                }

                else

                {

                    $sel = '';

                }		

                $option_str .= '<option value="'.$row['bms_id'].'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';

            }

        }

    }

    elseif($report_module == 'bes_report' || $report_module == '23')

    {

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersbes` WHERE `user_id` = '".$user_id."' AND `bes_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN (".$bms_id_str.") AND `bmst_id` = '2' `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['bms_id'] == $module_keyword)

                {

                    $sel = ' selected ';

                }

                else

                {

                    $sel = '';

                }		

                $option_str .= '<option value="'.$row['bms_id'].'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';

            }

        }

    }

    elseif($report_module == 'mdt_report' || $report_module == '24')

    {

        $bms_id_str = '';

        /*

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $result = mysql_query($sql,$link);

        if( ($result) && (mysql_num_rows($result) > 0) )

        {

            $return = true;

            while ($row = mysql_fetch_assoc($result)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        

        if($bms_id_str != '')

        {

            //$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN (".$bms_id_str.") AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";

            //echo '<br>'.$sql;

            $result = mysql_query($sql,$link);

            if( ($result) && (mysql_num_rows($result) > 0) )

            {

                $return = true;

                while ($row = mysql_fetch_assoc($result)) 

                {

                    if($row['bms_id'] == $module_keyword)

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['bms_id'].'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';

                }

            }

        }

         * 

         */

        

        

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'bms'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN (".$bms_id_str.") AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
            if($STH->rowCount() > 0)
            {

                $return = true;

               while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'bms_'.$row['bms_id'];

                    if($chk_val == $module_keyword )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';

                }

            }

        }

        

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'adct'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tbladdictions` WHERE `adct_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
            if($STH->rowCount() > 0)
            {

                $return = true;

                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'adct_'.$row['adct_id'];

                    if($chk_val == $module_keyword )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'sleep'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblsleeps` WHERE `sleep_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
            if($STH->rowCount() > 0)
            {

                $return = true;

                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'sleep_'.$row['sleep_id'];

                    if($chk_val == $module_keyword )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'gs'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblgeneralstressors` WHERE `gs_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
            if($STH->rowCount() > 0)
            {

                $return = true;

               while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'gs_'.$row['gs_id'];

                    if($chk_val == $module_keyword )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';





                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'wae'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblworkandenvironments` WHERE `wae_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
            if($STH->rowCount() > 0)
            {

                $return = true;

                 while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'wae_'.$row['wae_id'];

                    if($chk_val == $module_keyword )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

	$bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'mc'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblmycommunications` WHERE `mc_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

                $return = true;

                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'mc_'.$row['mc_id'];

                    if($chk_val == $module_keyword )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'mr'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblmyrelations` WHERE `mr_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

                $return = true;

                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'mr_'.$row['mr_id'];

                    if($chk_val == $module_keyword )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'situation' AND `bms_type` = 'mle'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

             while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblmajorlifeevents` WHERE `mle_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

                $return = true;

                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'mle_'.$row['mle_id'];

                    if($chk_val == $module_keyword )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

        

        

        

    }

    elseif($report_module == 'food_report' || $report_module == '1')

    {

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `meal_id` FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['meal_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        $veg_str = " WHERE `meal_id` IN (".$bms_id_str.") ";

	list($food_veg_nonveg,$beef,$pork) = $this->getFoodVegNonVegOfUser($user_id);

	if($food_veg_nonveg == 'V')

	{

            $veg_str .= " AND `food_veg_nonveg` != 'NV' AND `food_veg_nonveg` != 'E' AND `food_veg_nonveg` != 'B' AND `food_veg_nonveg` != 'P' ";

	}

	elseif($food_veg_nonveg == 'VE')

	{

            $veg_str .= " AND `food_veg_nonveg` != 'NV' AND `food_veg_nonveg` != 'B' AND `food_veg_nonveg` != 'P' ";

	}

	else

	{

            if($beef == '0')

            {

                $veg_str .= " AND `food_veg_nonveg` != 'B' ";

                if($pork == '0')

                {

                    $veg_str .= " AND `food_veg_nonveg` != 'P' ";

                }

            }

            else

            {

                if($pork == '0')

                {

                    $veg_str .= " AND `food_veg_nonveg` != 'P' ";

                }	

            }	

	}

	

	$sql = "SELECT * FROM `tbldailymeals` ".$veg_str." ORDER BY `meal_item` ASC";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['meal_id'] == $module_keyword)

                {

                    $sel = ' selected ';

                }

                else

                {

                    $sel = '';

                }		

                $option_str .= '<option value="'.$row['meal_id'].'" '.$sel.'>'.stripslashes($row['meal_item']).'</option>';

            }

        }

    }

    elseif($report_module == 'activity_report' || $report_module == 'activity_analysis_report' || $report_module == '4' || $report_module == '14')

    {

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `activity_id` FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['activity_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        $sql = "SELECT * FROM `tbldailyactivity` WHERE `activity_id` IN (".$bms_id_str.") ORDER BY `activity` ASC";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                if($row['activity_id'] == $module_keyword)

                {

                    $sel = ' selected ';

                }

                else

                {

                    $sel = '';

                }		

                $option_str .= '<option value="'.$row['activity_id'].'" '.$sel.'>'.stripslashes($row['activity']).'</option>';

            }

        }

    }

    return $option_str;

}


public function chkIfQuestionInUserCriteria($practitioner_id,$str_user_id,$user_id,$country_id,$str_state_id,$str_city_id,$str_place_id)
{
	$add_to_record = false;
	$chk_next = false;
	//echo '<br>33333333333333333';
	list($return,$name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$user_practitioner_id,$user_country_id) = getUserDetails($user_id);
	
	if($return)
	{
            
		if($practitioner_id == '' || $practitioner_id == '0')
		{
			$chk_next = true;
		}
		else
		{
                    //echo '<br>else222222222';
			if($str_user_id == '')
			{
				if($this->chkIfUserIsAdvisersReferrals($practitioner_id,$user_id))
				{
					$chk_next = true;
				}
			}
			else
			{
                            
				$arr_user_id = array();
				$pos4 = strpos($str_user_id, ',');
				if ($pos4 !== false) 
				{
					$arr_user_id = explode(',',$str_user_id);
				}
				else
				{
					array_push($arr_user_id , $str_user_id);
				}
				
				if(in_array($user_id,$arr_user_id) || $arr_user_id[0] == '')
				{
					if($this->chkIfUserIsAdvisersReferrals($practitioner_id,$user_id))
					{
						$chk_next = true;
					}
				}
			}		
		}
		
		if($chk_next)
		{
			if($country_id == '0')
			{
				$chk_next = true;
			}
			elseif($country_id == $user_country_id)
			{
				$chk_next = true;
			}
			else
			{
				$chk_next = false;
			}
		}
		
		if($chk_next)
		{
			if($str_state_id == '')
			{
				$chk_next = true;
			}
			else
			{
				$arr_state_id = array();
				$pos1 = strpos($str_state_id, ',');
				if ($pos1 !== false) 
				{
					$arr_state_id = explode(',',$str_state_id);
				}
				else
				{
					array_push($arr_state_id , $str_state_id);
				}
				
				if(in_array($state_id,$arr_state_id) || $arr_state_id[0] == '')
				{
					$chk_next = true;
				}
				else
				{
					$chk_next = false;
				}	
			}
		}	
			
		if($chk_next)
		{
			if($str_city_id == '')
			{
				$chk_next = true;
			}
			else
			{
				$arr_city_id = array();
				$pos2 = strpos($str_city_id, ',');
				if ($pos2 !== false) 
				{
					$arr_city_id = explode(',',$str_city_id);
				}
				else
				{
					array_push($arr_city_id , $str_city_id);
				}
				
				if(in_array($city_id,$arr_city_id) || $arr_city_id[0] == '')
				{
					$chk_next = true;
				}
				else
				{
					$chk_next = false;
				}	
			}
		}	
		
		if($chk_next)
		{
			if($str_place_id == '')
			{
				$chk_next = true;
			}
			else
			{
				$arr_place_id = array();
				$pos3 = strpos($str_place_id, ',');
				if ($pos3 !== false) 
				{
					$arr_place_id = explode(',',$str_place_id);
				}
				else
				{
					array_push($arr_place_id , $str_place_id);
				}
				
				if(in_array($place_id,$arr_place_id) || $arr_place_id[0] == '')
				{
					$chk_next = true;
				}
				else
				{
					$chk_next = false;
				}	
			}
		}		
			
		if($chk_next)
		{
			$add_to_record = true;
		}
	}		
	return $add_to_record;
}


public function getFoodVegNonVegOfUser($user_id)

{

	$DBH = new DatabaseHandler();
	$food_veg_nonveg = '';
	$beef = '0';
	$pork = '0';


	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' ";

	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

		$row = $STH->fetch(PDO::FETCH_ASSOC);

		$food_veg_nonveg = stripslashes($row['food_veg_nonveg']);

		$beef = stripslashes($row['beef']);

		$pork = stripslashes($row['pork']);

	}

	return array($food_veg_nonveg,$beef,$pork);

}

public function chkIfUserIsAdvisersReferrals($pro_user_id,$user_id)
{
	$DBH = new DatabaseHandler();
	$return = false;
	
	$user_email = $this->getUserEmailById($user_id);
        $pro_user_email = $this->getProUserEmailById($pro_user_id);
	//$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `request_status` = '1'";
        $sql = "SELECT * FROM `tbladviserreferrals` WHERE (`pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `request_status` = '1' AND `invite_by_user` = '0') OR (`pro_user_id` = '".$user_id."' AND `user_email` = '".$pro_user_email."' AND `request_status` = '1' AND `invite_by_user` = '1')";
	//echo '<br>'.$sql;
        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {
		$return = true;
	}

	return $return;
}


public function getModuleWiseCriteriaOptions($user_id,$report_module,$pro_user_id,$module_criteria)

{

    

    $option_str = '';

    

    if($report_module == 'activity_report' || $report_module == '14')

    {

        if($module_criteria == '3')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="3" '.$sel.'>Duration</option>';

        

        if($module_criteria == '4')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="4" '.$sel.'>Time</option>';

    }

    elseif($report_module == 'activity_analysis_report' || $report_module == '4')

    {

        if($module_criteria == '3')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="3" '.$sel.'>Duration</option>';

        

        if($module_criteria == '4')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="4" '.$sel.'>Time</option>';

        

        if($module_criteria == '8')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="8" '.$sel.'>Calories Burnt</option>';

    }

    elseif($report_module == 'food_report' || $report_module == '1')

    {

        if($module_criteria == '4')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="4" '.$sel.'>Time</option>';

        

        if($module_criteria == '5')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="5" '.$sel.'>Quantity</option>';

        

        if($module_criteria == '6')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="6" '.$sel.'>My Desire</option>';

    }

    elseif($report_module == 'meal_time_report' || $report_module == '5')

    {

        if($module_criteria == '4')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="4" '.$sel.'>Time</option>';

    }

    elseif($report_module == 'bps_report' || $report_module == '22')

    {

         

    }

    elseif($report_module == 'mdt_report' || $report_module == '24' )

    {

        if($module_criteria == '9')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="9" '.$sel.'>Triggers</option>';

        if($module_criteria == '3')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="3" '.$sel.'>Duration</option>';

        

        if($module_criteria == '4')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="4" '.$sel.'>Time</option>';

         

    }

    elseif($report_module == '')

    {

         

    }

    else 

    {

        /*

        if($module_criteria == '1')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="1" '.$sel.'>My Target</option>';



        if($module_criteria == '2')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="2" '.$sel.'>My Adviser Target</option>';

         * 

         */

    }

    

    if($module_criteria == '7')

    {

        $sel = ' selected ';

    }

    else

    {

        $sel = '';

    }		

    $option_str .= '<option value="7" '.$sel.'>Days</option>';

    

    return $option_str;

}

public function getTriggerCriteriaOptions($user_id,$trigger_criteria)

{

	$DBH = new DatabaseHandler();

	$option_str = '';

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'bms'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN (".$bms_id_str.") AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
            if($STH->rowCount() > 0)
            {

                $return = true;

                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'bms_'.$row['bms_id'];

                    if($chk_val == $trigger_criteria )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';

                }

            }

        }

        

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'adct'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tbladdictions` WHERE `adct_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

                $return = true;

               while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'adct_'.$row['adct_id'];

                    if($chk_val == $trigger_criteria )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'sleep'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblsleeps` WHERE `sleep_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
            if($STH->rowCount() > 0)
            {

                $return = true;

                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'sleep_'.$row['sleep_id'];

                    if($chk_val == $trigger_criteria )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'gs'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblgeneralstressors` WHERE `gs_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
            if($STH->rowCount() > 0)
            {

                $return = true;

                while ($row = $STH->fetch(PDO::FETCH_ASSOC))  

                {

                    $chk_val = 'gs_'.$row['gs_id'];

                    if($chk_val == $trigger_criteria )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'wae'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblworkandenvironments` WHERE `wae_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
            if($STH->rowCount() > 0)
            {

                $return = true;

               while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'wae_'.$row['wae_id'];

                    if($chk_val == $trigger_criteria )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

	$bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'mc'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblmycommunications` WHERE `mc_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
            if($STH->rowCount() > 0)
            {

                $return = true;

                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'mc_'.$row['mc_id'];

                    if($chk_val == $trigger_criteria )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'mr'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblmyrelations` WHERE `mr_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

                $return = true;

                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'mr_'.$row['mr_id'];

                    if($chk_val == $trigger_criteria )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

        $bms_id_str = '';

        $sql = "SELECT DISTINCT `bms_id` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `bms_entry_type` = 'trigger' AND `bms_type` = 'mle'  AND `bms_id` > '0' AND `mdt_old_data` = '0' ";

        //echo '<br>'.$sql;

        $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

            $return = true;

            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

            {

                $bms_id_str .= $row['bms_id'].',';

            }

            $bms_id_str = substr($bms_id_str, 0,-1);

        }

        

        if($bms_id_str != '')

        {

            $sql = "SELECT * FROM `tblmajorlifeevents` WHERE `mle_id` IN (".$bms_id_str.") ORDER BY situation";

            //echo '<br>'.$sql;

            $STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

                $return = true;

                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 

                {

                    $chk_val = 'mle_'.$row['mle_id'];

                    if($chk_val == $trigger_criteria )

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$chk_val.'" '.$sel.'>'.stripslashes($row['situation']).'</option>';

                }

            }

        }

        

       

        

        return $option_str;

}


public function getModuleWiseCriteriaScaleOptions($user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range)

{

    

    $option_str = '';

    

    //echo 'module_criteria = '.$module_criteria;

    

    if($module_criteria == '6')

    {

        $arr_scale_range = array (

            5 => '=(Equal)'

        );

    }   

    elseif($module_criteria == '7')

    {

        $arr_scale_range = array (

            5 => '=(Equal)',

            6 => 'Range'

        );

    } 

    else

    {

        $arr_scale_range = array (

            1 => '<(Less Than)',

            2 => '>(Greater Than)',

            3 => ' &le; (Less than or Equal to)',

            4 => ' &ge; (Greater than or Equal to)',

            5 => '=(Equal)',

            6 => 'Range'

        );

    }

        

    foreach($arr_scale_range as $k => $v )

    {

        if($k == $criteria_scale_range)

        {

            $selected = ' selected ';

        }

        else

        {

            $selected = '';

        }

        $option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';

    }	

    return $option_str;

}

public function getModuleWiseCriteriaScaleValues($user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value)

{
    $option_str = '';
    if($criteria_scale_range == '')

    {

        $div_start_criteria_scale_value = 'none';

        $div_end_criteria_scale_value = 'none';

        $start_criteria_scale_value = '';

        $end_criteria_scale_value = '';

    }

    elseif($criteria_scale_range == '6')

    {

        $div_start_criteria_scale_value = '';

        $div_end_criteria_scale_value = '';

        $option_str .= '<span class="Header_brown"><strong>Criteria Value:</strong>&nbsp;&nbsp;&nbsp;</span>';

    }

    else

    {

        $div_start_criteria_scale_value = '';

        $div_end_criteria_scale_value = 'none';

        $end_criteria_scale_value = '';

        $option_str .= '<span class="Header_brown"><strong>Criteria Value:</strong>&nbsp;&nbsp;&nbsp;</span>';

    }

    

    //echo 'module_criteria = '.$module_criteria; 

    if($module_criteria == '1' || $module_criteria == '2' || $module_criteria == '9')

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">

                        <select name="start_criteria_scale_value" id="start_criteria_scale_value" style="width:50px;">

                        ';

        for($i=1;$i<=10;$i++)

        {

            if($i == $start_criteria_scale_value)

            {

                $sel = ' selected ';

            }

            else

            {

                $sel = '';

            }		

            $option_str .= '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';

        }    

        $option_str .= '</select></span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">

                        &nbsp; - &nbsp;

                        <select name="end_criteria_scale_value" id="end_criteria_scale_value" style="width:50px;">

                        ';

        for($i=1;$i<=10;$i++)

        {

            if($i == $end_criteria_scale_value)

            {

                $sel = ' selected ';

            }

            else

            {

                $sel = '';

            }		

            $option_str .= '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';

        }    

        $option_str .= '</select></span>';

    }

    elseif($module_criteria == '4' )

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">';

        $option_str .= '<select name="start_criteria_scale_value" id="start_criteria_scale_value" style="width:100px;">

                        ';

        $option_str .= $this->getTimeOptions(0,24,$start_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">

                        &nbsp; - &nbsp;';

        $option_str .= '<select name="end_criteria_scale_value" id="end_criteria_scale_value" style="width:100px;">

                        ';

        $option_str .= $this->getTimeOptions(0,24,$end_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

    }

    elseif($module_criteria == '5' )

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">';

        $option_str .= '<select name="start_criteria_scale_value" id="start_criteria_scale_value" style="width:100px;">

                        ';

        $option_str .= $this->getMealQuantityOptions($start_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">

                        &nbsp; - &nbsp;';

        $option_str .= '<select name="end_criteria_scale_value" id="end_criteria_scale_value" style="width:100px;">

                        ';

        $option_str .= $this->getMealQuantityOptions($end_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

    }

    elseif($module_criteria == '6' )

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">';

        $option_str .= '<select name="start_criteria_scale_value" id="start_criteria_scale_value" style="width:100px;">

                        ';

        $option_str .= $this->getMealLikeOptions($start_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">';

        $option_str .= '<input type="hidden" name="end_criteria_scale_value" id="end_criteria_scale_value" value="'.$end_criteria_scale_value.'">';

        $option_str .= '</span>';

    }

    elseif($module_criteria == '7' )

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">';

        $option_str .= '<select name="start_criteria_scale_value" id="start_criteria_scale_value" style="width:100px;">

                        ';

        $option_str .= $this->getDayOfWeekOptions($start_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">&nbsp; - &nbsp';

        $option_str .= '<select name="end_criteria_scale_value" id="end_criteria_scale_value" style="width:100px;">

                        ';

        $option_str .= $this->getDayOfWeekOptions($end_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

    }

    elseif($module_criteria == '3')

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">

                        <input style="width:50px;" maxlength="3" type="text" name="start_criteria_scale_value" id="start_criteria_scale_value" value="'.$start_criteria_scale_value.'"> (Mins)</span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">&nbsp; - &nbsp;

                        <input style="width:50px;" maxlength="3" type="text" name="end_criteria_scale_value" id="end_criteria_scale_value" value="'.$end_criteria_scale_value.'"> (Mins)</span>';

    }

    elseif($module_criteria == '8')

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">

                        <input style="width:50px;" maxlength="4" type="text" name="start_criteria_scale_value" id="start_criteria_scale_value" value="'.$start_criteria_scale_value.'"></span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">&nbsp; - &nbsp;

                        <input style="width:50px;" maxlength="4" type="text" name="end_criteria_scale_value" id="end_criteria_scale_value" value="'.$end_criteria_scale_value.'"></span>';

    }

    else

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">

                        <input type="hidden" name="start_criteria_scale_value" id="start_criteria_scale_value" value="'.$start_criteria_scale_value.'"></span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">

                        <input type="hidden" name="end_criteria_scale_value" id="end_criteria_scale_value" value="'.$end_criteria_scale_value.'"></span>';

    }

    

  

    return $option_str;

}


public function getTimeOptions($start_time,$end_time,$time)

{

	$start = $start_time *60 + 0;

	$end = $end_time * 60+0;

	

	for($i = $start; $i<$end; $i += 15)

	{

		

		$minute = $i % 60;

		$hour = ($i - $minute)/60;

		

		

		if( ($hour >=24) && ($hour <= 36) )

		{

			$hour = $hour - 24;

		}

		

		

		if( ($hour >= 0) && ($hour < 12)  )

		{

			$str = 'AM';

		}

		else

		{

			$str = 'PM';

		} 

				

		$val = sprintf('%02d:%02d', $hour, $minute);

		

		$val = $val.' '.$str;

		if($time == $val)

		{

			$selected = ' selected ';

		}

		else

		{

			$selected = '';

		}

		$option_str .= '<option value="'.$val.'" '.$selected.' >'.$val.'</option>';

	} 

	return $option_str;

}

public function getMealQuantityOptions($breakfast_quantity)

{

	

	$option_str = '';		

	

	if($breakfast_quantity == '1')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}	

	$option_str .= '<option value="1" '.$sel.'>1</option>';

	

	

	if($breakfast_quantity == '1/4')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}

	$option_str .= '<option value="1/4" '.$sel.'>1/4</option>';

	

	if($breakfast_quantity == '1/3')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}

	$option_str .= '<option value="1/3" '.$sel.'>1/3</option>';

	

	if($breakfast_quantity == '1/2')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}

	$option_str .= '<option value="1/2" '.$sel.'>1/2</option>';													

	

	if($breakfast_quantity == '2')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}

	$option_str .= '<option value="2" '.$sel.'>2</option>';

	

	if($breakfast_quantity == '2/3')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}

	$option_str .= '<option value="2/3" '.$sel.'>2/3</option>';

														

													

	for($j=3;$j<=1000;$j++) 

	{

		if($breakfast_quantity == $j)

		{

			$sel = ' selected ';

		}

		else

		{

			$sel = '';

		}		

		$option_str .= '<option value="'.$j.'" '.$sel.'>'.$j.'</option>';

	}

	return $option_str;

}

public function getMealLikeOptions($breakfast_meal_like)

{

	

	$arr_food_like = array('Like','Dislike','Favourite','Allergic');

	$option_str = '';		

		

	for($i=0;$i<count($arr_food_like);$i++)

	{

		if($breakfast_meal_like == $arr_food_like[$i])

		{

			$sel = ' selected ';

		}

		else

		{

			$sel = '';

		}		

		$option_str .= '<option value="'.$arr_food_like[$i].'" '.$sel.'>'.$arr_food_like[$i].'</option>';

	}



	if($breakfast_meal_like == '')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}

	$option_str .= '<option value="" '.$sel.'>None</option>';

	return $option_str;

}


public function getDayOfWeekOptions($day_of_week)

{

    

    $option_str = '';

    

    $arr_day_of_week = array (

        1 => 'Sunday',

        2 => 'Monday',

        3 => 'Tuesday',

        4 => 'Wednesday',

        5 => 'Thursday',

        6 => 'Friday',

        7 => 'Saturday'

    );



    foreach($arr_day_of_week as $k => $v )

    {

            if($k == $day_of_week)

            {

                $selected = ' selected ';

            }

            else

            {

                $selected = '';

            }

            $option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';

    }	

    return $option_str;

}

public function getAgeOfUser($user_id)

{

	$dob = getDOBOfUser($user_id);

	$age = convertDobToAge($dob);

	return $age;

}

public function getDOBOfUser($user_id)
{
	$DBH = new DatabaseHandler();
	$dob = '0000-00-00';
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' ";
	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$dob = stripslashes($row['dob']);
	}
	return $dob;

}

public function convertDobToAge($dob)

{

    // See http://php.net/date for what the first arguments mean.

    $iDiffYear  = date('Y') - date('Y', strtotime($dob));

    $iDiffMonth = date('n') - date('n', strtotime($dob));

    $iDiffDay   = date('j') - date('j', strtotime($dob));

    

    // If birthday has not happen yet for this year, subtract 1.

    if ($iDiffMonth < 0 || ($iDiffMonth == 0 && $iDiffDay < 0))

    {

        $iDiffYear--;

    }

        

    return $iDiffYear;

}  


public function getHeightOfUser($user_id)

{

	$DBH = new DatabaseHandler();

	$height = 0;

	$height_id = $this->getHeightIdOfUser($user_id);

		

	$sql = "SELECT * FROM `tblheights` WHERE `height_id` = '".$height_id."' ";

	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$height = stripslashes($row['height_cms']);

	}

	return $height;

}

public function getHeightIdOfUser($user_id)

{

	$DBH = new DatabaseHandler();
	$height = 0;
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' ";
	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

		$row = $row = $STH->fetch(PDO::FETCH_ASSOC);
		$height = stripslashes($row['height']);

	}

	return $height;

}

public function getWeightOfUser($user_id)

{

	$DBH = new DatabaseHandler();

	$weight = 0;

		

	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' ";

	$STH = $DBH->query($sql);
        if($STH->rowCount() > 0)
        {

		$row = $STH->fetch(PDO::FETCH_ASSOC);

		$weight = stripslashes($row['weight']);

	}

	return $weight;

}

public function Get_Digital_Life_drop($page_id)

{

    $my_DBH = new DatabaseHandler();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();

    $option_str = '';

    $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '18' AND `pd_deleted` = '0' ";

    $STH = $DBH->prepare($sql);
    $STH->execute();
    if($STH->rowCount() > 0)

    {

        $row = $STH->fetch(PDO::FETCH_ASSOC);

        $page_id_str = stripslashes($row['page_id_str']);

        $sql2 = "SELECT * FROM `tblpages` WHERE `page_id` IN (".$page_id_str.") AND `show_in_list` = '1' AND `adviser_panel` = '0' AND `vender_panel` = '0' ORDER BY `menu_title` ASC";    

        //$sql = "SELECT * FROM `tblpages` WHERE  AND `show_in_feedback` = '1' ORDER BY `page_name` ASC";

        //echo $sql;

        $STH2 = $DBH->prepare($sql2);
        $STH2->execute();
        if($STH2->rowCount() > 0)

        {

            if($page_id == 0)

            {

                $sel = ' selected ';

            }

            else

            {

                $sel = '';

            }	

            $option_str .= '<option value="0" '.$sel.'>Select</option>';

            while($row = $STH2->fetch(PDO::FETCH_ASSOC) ) 
            {
                if($row['page_id'] == $page_id)
                {
                    $sel = ' selected ';
                }
                else
                {
                    $sel = '';
                }		
                $option_str .= '<option value="'.$row['page_id'].'" '.$sel.'>'.stripslashes($row['page_name']).'</option>';
            }
        }
    }    
    return $option_str;

}

public function getPageLinkByid($page_id)
{
    $my_DBH = new DatabaseHandler();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();  
    $menu_link='';
        $sql = "SELECT * FROM `tblpages` WHERE `page_id` ='".$page_id."' AND `adviser_panel` = '0' AND `vender_panel` = '0' ORDER BY `menu_title` ASC";    
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)

        {
           $row = $STH->fetch(PDO::FETCH_ASSOC);
           $menu_link = $row['menu_link'];
       
        }
        return $menu_link;
    
}

public function GETMYDAYTODAYKEWORD($user_id)
{
    $my_DBH = new DatabaseHandler();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();

    $option_str = '';

    $sql = "SELECT DISTINCT(bms_name) FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' ";

    $STH = $DBH->prepare($sql);
    $STH->execute();
    if($STH->rowCount() > 0)

    {

            if($page_id == 0)

            {

                $sel = ' selected ';

            }

            else

            {

                $sel = '';

            }	

            while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 
            {
                if($row['bms_name'] == $page_id)
                {
                    $sel = ' selected ';
                }
                else
                {
                    $sel = '';
                }		
                $option_str .= '<option value="'.$row['bms_name'].'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';
            }
        
    }    
    return $option_str;  
}


public function GETMYCANVASKEWORD($user_id)
{
    $my_DBH = new DatabaseHandler();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();

    $option_str = '';

    $sql = "SELECT DISTINCT(main_tab) FROM `tbl_mycanvas` WHERE `user_id` = '".$user_id."' ";

    $STH = $DBH->prepare($sql);
    $STH->execute();
    if($STH->rowCount() > 0)

    {

            if($page_id == 0)

            {

                $sel = ' selected ';

            }

            else

            {

                $sel = '';

            }	

            while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 
            {
                if($row['main_tab'] == $page_id)
                {
                    $sel = ' selected ';
                }
                else
                {
                    $sel = '';
                }		
                $option_str .= '<option value="'.$row['main_tab'].'" '.$sel.'>'.stripslashes($row['main_tab']).'</option>';
            }
        
    }    
    return $option_str;  
}

public function GETMYDESIGNKEWORD($user_id)
{
    $my_DBH = new DatabaseHandler();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();

    $option_str = '';

    $sql = "SELECT DISTINCT(box_title) FROM `tbl_user_design_your_data` WHERE `user_id` = '".$user_id."' ";

    $STH = $DBH->prepare($sql);
    $STH->execute();
    if($STH->rowCount() > 0)

    {

            if($page_id == 0)

            {

                $sel = ' selected ';

            }

            else

            {

                $sel = '';

            }	

            while($row = $STH->fetch(PDO::FETCH_ASSOC) ) 
            {
                if($row['box_title'] == $page_id)
                {
                    $sel = ' selected ';
                }
                else
                {
                    $sel = '';
                }		
                $option_str .= '<option value="'.$row['box_title'].'" '.$sel.'>'.stripslashes($row['box_title']).'</option>';
            }
        
    }    
    return $option_str;  
}

public function GETDesignData($sub_cat_id,$day_month_year)
{
    $DBH = new DatabaseHandler();
    $data = array();
    $sql = "SELECT * FROM `tbl_design_your_life` WHERE  sub_cat_id = '".$sub_cat_id."' and `status` = '1' ";		
    $STH = $DBH->query($sql);
    $single_date = date("Y-m-d",strtotime($day_month_year));
    //echo '<br>';
    $all = date("d",strtotime($day_month_year));
    //echo '<br>';
    $month_wise = date("m",strtotime($day_month_year));
    //echo '<br>';
    $days_of_week = date('w', strtotime($day_month_year));
     
        if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {
            
              if($row['listing_date_type'] == 'single_date')
              {
                 
                 if($single_date == $row['single_date']) 
                 {
                     $data[]= $row;
                 }
                  
              }
              elseif($row['listing_date_type'] == 'all')
              {
                 $all_arr = explode(',', $row['days_of_month']);
                 if(in_array($all, $all_arr))
                 {
                     $data[]= $row;
                 } 
              }
              elseif($row['listing_date_type'] == 'days_of_month')
              {
                 $all_arr = explode(',', $row['days_of_month']);
                 if(in_array($all, $all_arr))
                 {
                     $data[]= $row;
                 }  
              }
              elseif($row['listing_date_type'] == 'date_range')
              {
                if(($row['start_date'] <= $single_date) && ($row['end_date'] >= $single_date) ) 
                 {
                     $data[]= $row;
                 }  
              }
              elseif($row['listing_date_type'] == 'month_wise')
              {
                 $all_arr = explode(',', $row['months']);
                 if(in_array($month_wise, $all_arr))
                 {
                     $data[]= $row;
                 }    
              }
              elseif($row['listing_date_type'] == 'days_of_week')
              {
                 $all_arr = explode(',', $row['days_of_week']);
                 if(in_array($days_of_week, $all_arr))
                 {
                     $data[] = $row;
                 }    
              }
              
            }
        }    
    return $data;     
}

public function getAllMyAdviserInvitations($user_email,$pro_user_id)

{

	$DBH = new DatabaseHandler();
	$temp_arr = array();
	if($pro_user_id != '')
	{
		$str_sql_pro_user_id = " AND tar.pro_user_id = '".$pro_user_id."' ";
	}
	else
	{
		$str_sql_pro_user_id = "";
	}

       $user_id = $_SESSION['user_id'];

        $sql = "SELECT * FROM `tbladviserreferrals` AS tar "

            . "LEFT JOIN `tblvendors` AS tpf ON tar.user_email = tpf.vendor_email "

            . "WHERE (tar.user_email = '".$user_email."' OR tar.pro_user_id = '".$user_id."') AND tar.invite_by_user = '0' AND (tar.request_status = '1' OR tar.request_status = '3') ".$str_sql_pro_user_id." "

            . "ORDER BY tar.request_sent_date DESC";

	$STH = $DBH->query($sql);

	if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {

			$temp_arr[] = $row;


		}

	}

        

//    $puid = $this->getUserId($user_email);  
//
//    
//
//    if($pro_user_id != '')
//
//	{
//
//		$str_sql_pro_user_email = " AND tpf.vendor_id = '".$pro_user_id."' ";
//
//	}
//
//	else
//
//	{
//
//		$str_sql_pro_user_email = "";
//
//	}
//
//    
//
//     $sql = "SELECT * FROM `tbladviserreferrals` AS tar "
//
//            . "LEFT JOIN `tblvendors` AS tpf ON tar.user_email = tpf.vendor_email "
//
//            . "WHERE tar.pro_user_id = '".$puid."' AND tar.invite_by_user = '0' AND (tar.request_status = '1' OR tar.request_status = '3') ".$str_sql_pro_user_email." "
//
//            . "ORDER BY tar.request_sent_date DESC";
//
//	$STH = $DBH->query($sql);
//
//	if( $STH->rowCount() > 0 )
//        {
//            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
//            {
//
//			$temp_arr[] = $row;
//
//			//echo '<br><br><pre>';
//
//			//print_r($row);
//
//			//echo '<br></pre>';
//
//		}
//
//	}    

	return $temp_arr;

}

public function getAdviserStatusActivationsRecords($ar_id,$pro_user_id)

{

	$DBH = new DatabaseHandler();

	$arr_record = array();

	

	//$sql = "SELECT * FROM `tbladviseractivation` WHERE `ar_id` = '".$ar_id."' AND `pro_user_id` = '".$pro_user_id."' ORDER BY aa_add_date DESC";

        $sql = "SELECT * FROM `tbladviseractivation` WHERE `ar_id` = '".$ar_id."' ORDER BY aa_add_date DESC";

	
	$STH = $DBH->query($sql);

	if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {

			$arr_record[] = $row;

		}

	}	

	return $arr_record;

}	

public function getUsersAllAdviserOptions($user_id,$pro_user_id)

{

	$DBH = new DatabaseHandler();

	$option_str = '';	

	$email = $this->getUserEmailById($user_id);	

		

	$sql = "SELECT tar.* , tpu.name FROM `tbladviserreferrals` AS tar "

                . "LEFT JOIN `tblprofusers` AS tpu ON tar.pro_user_id = tpu.pro_user_id  "

                . "WHERE tar.user_email = '".$email."' AND tar.invite_by_user = '0'"

                . "ORDER BY tpu.name ASC";

	//echo $sql;

	$STH = $DBH->query($sql);

	if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {

			 

			if($row['pro_user_id'] == $pro_user_id)

			{

				$sel = ' selected ';

			}

			else

			{

				$sel = '';

			}		

			$option_str .= '<option value="'.$row['pro_user_id'].'" '.$sel.'>'.stripslashes($row['name']).'</option>';

			

		}

	}

        

         $sql = "SELECT tar.*, tpu.name , tpu.pro_user_id AS puser_id FROM `tbladviserreferrals` AS tar "

                . "LEFT JOIN `tblprofusers` AS tpu ON tar.user_email = tpu.email  "

                . "WHERE tar.pro_user_id = '".$user_id."' AND tar.invite_by_user = '1' "

                . "ORDER BY tpu.name ASC";

	//echo $sql;

	$STH = $DBH->query($sql);

	if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {

			 

			if($row['puser_id'] == $pro_user_id)

			{

				$sel = ' selected ';

			}

			else

			{

				$sel = '';

			}		

			$option_str .= '<option value="'.$row['puser_id'].'" '.$sel.'>'.stripslashes($row['name']).'</option>';

			

		}

	}

        

	return $option_str;

}


public function getUsersAcceptedAdviserOptions($user_id,$pro_user_id)

{

	$DBH = new DatabaseHandler();
	$option_str = '';	
	$email = $this->getUserEmailById($user_id);	
	//$sql = "SELECT * FROM `tbladviserreferrals` AS tar LEFT JOIN `tblprofusers` AS tpu ON tar.pro_user_id = tpu.pro_user_id  WHERE tar.user_email = '".$email."' AND tar.request_status = '1' ORDER BY tpu.name ASC";
        $sql = "SELECT tar.* , tpu.vendor_name FROM `tbladviserreferrals` AS tar "
                . "LEFT JOIN `tblvendors` AS tpu ON tar.pro_user_id = tpu.vendor_id  "
                . "WHERE tar.user_email = '".$email."' AND tar.invite_by_user = '0' AND ( tar.request_status = '1' OR tar.request_status = '3')  "
                . "ORDER BY tpu.vendor_name ASC";
	//echo $sql;

	$STH = $DBH->query($sql);

	if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {

			 

			if($row['pro_user_id'] == $pro_user_id)

			{

				$sel = ' selected ';

			}

			else

			{

				$sel = '';

			}		

			$option_str .= '<option value="'.$row['pro_user_id'].'" '.$sel.'>'.stripslashes($row['vendor_name']).'</option>';

			

		}

	}

        

        $sql = "SELECT tar.*, tpu.vendor_name , tpu.vendor_id AS puser_id FROM `tbladviserreferrals` AS tar "

                . "LEFT JOIN `tblvendors` AS tpu ON tar.user_email = tpu.vendor_email  "

                . "WHERE tar.pro_user_id = '".$user_id."' AND tar.invite_by_user = '1' AND ( tar.request_status = '1' OR tar.request_status = '3') "

                . "ORDER BY tpu.vendor_name ASC";

	//echo $sql;

       $STH = $DBH->query($sql);

	if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {

			 

			if($row['puser_id'] == $pro_user_id)

			{

				$sel = ' selected ';

			}

			else

			{

				$sel = '';

			}		

			$option_str .= '<option value="'.$row['puser_id'].'" '.$sel.'>'.stripslashes($row['vendor_name']).'</option>';

			

		}

	}

        

	return $option_str;

}

public function getAdviserReportsPermissions($user_id,$pro_user_id,$ar_id)

{

	$DBH = new DatabaseHandler();

	$temp_arr = array();

    

    //$sql = "SELECT * FROM `tbladviserreportpermission` WHERE `user_id` = '".$user_id."' AND `pro_user_id` = '".$pro_user_id."' AND `ar_id` = '".$ar_id."' ORDER BY `arp_add_date` DESC";

        $sql = "SELECT * FROM `tbladviserreportpermission` WHERE `ar_id` = '".$ar_id."' ORDER BY `arp_add_date` DESC";

	$STH = $DBH->query($sql);

	if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {


			$temp_arr[] = $row;

			//echo '<br><br><pre>';

			//print_r($row);

			//echo '<br></pre>';

		}

	}

	return $temp_arr;

}


public function getReportTypeNameString($str_report_id,$str_permission_type)

{

	$DBH = new DatabaseHandler();

	$output = '';

	

	if($str_report_id != '')

	{

	

		$arr_temp_report_id = explode(',',$str_report_id);

		$arr_temp_permission_type = explode(',',$str_permission_type);

		

		for($i=0;$i<count($arr_temp_report_id);$i++)

		{

			//$sql = "SELECT * FROM `tblusersreports` WHERE `report_id`  = '".$arr_temp_report_id[$i]."'";
                        $sql = "SELECT * FROM `tblpages` WHERE `page_id`  = '".$arr_temp_report_id[$i]."'";
			$STH = $DBH->query($sql);

                        if( $STH->rowCount() > 0 )
                        {

				$row = $STH->fetch(PDO::FETCH_ASSOC);

				if($arr_temp_permission_type[$i] == '2')

				{

					$temp_permission_type = 'Standard Set';

				}

				elseif($arr_temp_permission_type[$i] == '3')

				{

					$temp_permission_type = 'Adviser Set';

				}	

				else

				{

					$temp_permission_type = 'Both Set';

				}

				$output .= $row['page_name'].'('.$temp_permission_type.'), '; 

			}

			

		}	

		$output = substr($output,0,-2);

	}	

	return $output;

}


public function getUsersAllAdviserQueries($user_id,$pro_user_id,$pg_id,$start_date,$end_date,$search_keywords)

{

	$DBH = new DatabaseHandler();

	$arr_aq_id = array(); 

	$arr_aq_user_unique_id = array(); 

	$arr_page_id = array(); 

	$arr_permission_type = array(); 

	$arr_user_id = array();

	$arr_name = array(); 

	$arr_email = array();

	$arr_feedback = array();

	$arr_pro_user_id = array();

	$arr_feedback_add_date = array();

	$arr_user_read = array();

	$arr_pro_user_read = array();

	

	if($pro_user_id != '')

	{

		$str_sql_pro_user_id = " AND `pro_user_id` = '".$pro_user_id."' ";

	}

	else

	{

		$str_sql_pro_user_id = '';

	}

	

	if($pg_id != '')

	{

		$arr_temp = explode('_',$pg_id);

		$temp_page_id = $arr_temp[0];

		$temp_permission_type = $arr_temp[1];

		

		$str_sql_pg_id = " AND `page_id` = '".$temp_page_id."' AND `permission_type` = '".$temp_permission_type."' ";

	}

	else

	{

		$str_sql_pg_id = '';

	}

	

	if($search_keywords != '')

	{

		$str_sql_search_keywords = " AND ( `query` LIKE '%".$search_keywords."%' OR `aq_user_unique_id` LIKE '%".$search_keywords."%' )";

	}

	else

	{

		$str_sql_search_keywords = '';

	}

	

	

	$sql = "SELECT * FROM `tbladviserqueries` WHERE  `user_id` = '".$user_id."' AND `parent_aq_id` = '0' AND `from_user` = '1' AND DATE(aq_add_date) >= '".date('Y-m-d',strtotime($start_date))."' AND DATE(aq_add_date) <= '".date('Y-m-d',strtotime($end_date))."' ".$str_sql_pro_user_id." ".$str_sql_pg_id." ".$str_sql_search_keywords."  ORDER BY `aq_add_date` DESC";

	

	$STH = $DBH->query($sql);

	if( $STH->rowCount() > 0 )
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
            {

			 

			array_push($arr_aq_id , stripslashes($row['aq_id']));

			array_push($arr_aq_user_unique_id , stripslashes($row['aq_user_unique_id']));

			array_push($arr_page_id , stripslashes($row['page_id']));

			array_push($arr_permission_type , stripslashes($row['permission_type']));

			array_push($arr_user_id , stripslashes($row['user_id']));

			array_push($arr_name , stripslashes($row['user_name']));

			array_push($arr_email , stripslashes($row['user_email']));

			array_push($arr_feedback , stripslashes($row['query']));

			array_push($arr_feedback_add_date , stripslashes($row['aq_add_date']));

			array_push($arr_pro_user_id , stripslashes($row['pro_user_id']));

			array_push($arr_user_read , stripslashes($row['user_read']));

			array_push($arr_pro_user_read , stripslashes($row['pro_user_read']));

								

		}	

	}

	return array($arr_aq_id,$arr_aq_user_unique_id,$arr_page_id,$arr_permission_type,$arr_user_id,$arr_name,$arr_email,$arr_feedback,$arr_feedback_add_date,$arr_pro_user_id,$arr_user_read,$arr_pro_user_read);

}


public function getAdviserQueryPageOptions($page_id,$user_id,$pro_user_id,$show_all)

{

        
	$DBH = new DatabaseHandler();

	$option_str = '';

	
	if($page_id == '0_0')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}		

	//$option_str .= '<option value="0_0" '.$sel.'>My Query</option>';	

	

	list($str_report_id,$str_permission_type) = $this->getUserAcceptedReportId($user_id,$pro_user_id);

	if($str_report_id != '')

	{	

		$arr_report_id = explode(',',$str_report_id); 

		$arr_permission_type = explode(',',$str_permission_type);

		

		for($i=0;$i<count($arr_report_id);$i++)

		{ 

			//$sql = "SELECT * FROM `tblusersreports` WHERE report_id = '".$arr_report_id[$i]."' ORDER BY `report_name` ASC";
                        $sql = "SELECT * FROM `tblpagedropdowns` WHERE pd_id = '20' and  `pd_status` = 1 ";
			//echo $sql;

			$STH = $DBH->query($sql);
                        if( $STH->rowCount() > 0 )
                        {
                            $row = $STH->fetch(PDO::FETCH_ASSOC);
                            $page_id_arr = explode(',', $row['page_id_str']);
                            
//                            echo '<pre>';
//                            print_r($page_id_arr);
//                            echo '</pre>';
                            
                            for($i=0;$i<count($page_id_arr);$i++)
                            //while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                            {

					if($page_id == $page_id_arr[$i].'_1')

					{

						$sel1 = '';
						$sel2 = ' selected ';

					}

					elseif($page_id == $page_id_arr[$i].'_0')

					{

						$sel1 = ' selected ';
						$sel2 = '';

					}	

					else

					{

						$sel1 = '';
						$sel2 = '';

					}	

					

					if($arr_permission_type[$i] == '2')

					{	

						$option_str .= '<option value="'.$page_id_arr[$i].'_0" '.$sel1.'>'.$this->get_PageName($page_id_arr[$i]).' (Standard Set)</option>';

					}

					elseif($arr_permission_type[$i] == '3')

					{	

						$option_str .= '<option value="'.$page_id_arr[$i].'_1" '.$sel2.'>'.$this->get_PageName($page_id_arr[$i]).' (Adviser Set)</option>';

					}	

					else

					{	

						$option_str .= '<option value="'.$page_id_arr[$i].'_0" '.$sel1.'>'.$this->get_PageName($page_id_arr[$i]).' (Standard Set)</option>';

						$option_str .= '<option value="'.$page_id_arr[$i].'_1" '.$sel2.'>'.$this->get_PageName($page_id_arr[$i]).' (Adviser Set)</option>';

					}

				}

			}

		}

	}

	elseif($show_all == '1')

	{

		//$sql = "SELECT * FROM `tblusersreports` ORDER BY `report_name` ASC";
                $sql = "SELECT * FROM `tblpagedropdowns` WHERE pd_id = '20' and  `pd_status` = 1 ";
		//echo $sql;

		$STH = $DBH->query($sql);

                if( $STH->rowCount() > 0 )
                {
                    
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
//                    echo $row['page_id_str'];
//                    die();
                    $page_id_arr = explode(',', $row['page_id_str']);
                    
//                    echo '<pre>';
//                            print_r($page_id_arr);
//                            echo '</pre>';
                    
                    for($i=0;$i<count($page_id_arr);$i++)
                    //while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                    {

				$sql2 = "SELECT * FROM `tbladviserplanatributes` WHERE `page_id` = '".$page_id_arr[$i]."' AND `apa_status` = '1' AND `show_for_user` = '1' ORDER BY `apa_id` DESC LIMIT 1";

				//echo $sql;

				$STH2 = $DBH->query($sql2);

                                if( $STH2->rowCount() > 0 )
                                {

					$row2 = $STH2->fetch(PDO::FETCH_ASSOC);

					$temp_apa_id = $row2['apa_id'];
                                       
					if($this->chkUserPlanFeaturePermission($user_id,$temp_apa_id))

					{

						if($page_id == $page_id_arr[$i].'_1')

						{

							$sel1 = '';

							$sel2 = ' selected ';

						}

						elseif($page_id == $page_id_arr[$i].'_0')

						{

							$sel1 = ' selected ';

							$sel2 = '';

						}

						else

						{

							$sel1 = '';

							$sel2 = '';

						}	

						

						$option_str .= '<option value="'.$page_id_arr[$i].'_0" '.$sel1.'>'.$this->get_PageName($page_id_arr[$i]).' (Standard Set)</option>';

						$option_str .= '<option value="'.$page_id_arr[$i].'_1" '.$sel2.'>'.$this->get_PageName($page_id_arr[$i]).' (Adviser Set)</option>';
                                                //die();
					}

				}

			}

		}

	}		

		

		

	return $option_str;

}


public function getUserAcceptedReportId($user_id,$pro_user_id)

{

	$DBH = new DatabaseHandler();

	$str_report_id = '';	

	$str_permission_type = '';	

	

	$user_email = $this->getUserEmailById($user_id);

        $pro_user_email = $this->getProUserEmailById($pro_user_id);

	//$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `request_status` = '1' ORDER BY `ar_id` DESC LIMIT 1";

        if($pro_user_id!='')
        {
        $sql = "SELECT * FROM `tbladviserreferrals` "

                . "WHERE ( (`pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `invite_by_user` = '0') "

                . "OR (`pro_user_id` = '".$user_id."' AND `user_email` = '".$pro_user_email."' AND `invite_by_user` = '1') ) "

                . "AND ( `request_status` = '1' ) ORDER BY `ar_id` DESC LIMIT 1";
        }
        else
        {
           $sql = "SELECT * FROM `tbladviserreferrals` "

                . "WHERE ( (`user_email` = '".$user_email."' AND `invite_by_user` = '0') "

                . "OR (`pro_user_id` = '".$user_id."' AND `invite_by_user` = '0') ) "

                . "AND ( `request_status` = '1' ) ORDER BY `ar_id`"; 
        }
	//echo $sql;

	$STH = $DBH->query($sql);

	if( $STH->rowCount() > 0 )
        {
                $str_report_id = array();
                while($row = $STH->fetch(PDO::FETCH_ASSOC))
                {
                    $str_report_id[]=$row['report_id'];
                }
		//$str_report_id = $row['report_id'];
		//$str_permission_type = $row['permission_type'];
		//list($str_report_id,$str_permission_type) = $this->getUserPlanRefinedReportsIds($user_id,$str_report_id,$str_permission_type);

	}

	$str_report_id = implode(',', $str_report_id);

	return $str_report_id;

}

public function getUserPlanRefinedReportsIds($user_id,$str_report_id,$str_permission_type)

{

	$DBH = new DatabaseHandler();

	$return_str_report_id = '';	

	$return_permission_type = '';

	

	if($str_report_id != '')

	{	

		$arr_report_id = explode(',',$str_report_id); 

		$arr_permission_type = explode(',',$str_permission_type);	

		

		for($i=0;$i<count($arr_report_id);$i++)

		{

			$sql = "SELECT * FROM `tbladviserplanatributes` WHERE `ref_report_id` = '".$arr_report_id[$i]."' AND `apa_status` = '1' AND `show_for_user` = '1' ORDER BY `apa_id` DESC LIMIT 1";

			//echo $sql;

			$STH = $DBH->query($sql);
                        if( $STH->rowCount() > 0 )
                        {
                                $row = $STH->fetch(PDO::FETCH_ASSOC);
				$temp_apa_id = $row['apa_id'];
				if($this->chkUserPlanFeaturePermission($user_id,$temp_apa_id))
				{
					$return_str_report_id .= $arr_report_id[$i].',';	
					$return_permission_type .= $arr_permission_type[$i].',';
				}
			}
		}

		$return_str_report_id = substr($return_str_report_id,0,-1);	
		$return_permission_type = substr($return_permission_type,0,-1);	

	}

	return array($return_str_report_id,$return_permission_type);

}

public function getAdviserRequestStatusAndArId($pro_user_id,$user_id)

{

	$DBH = new DatabaseHandler();

	$request_status = $this->chkIfUserIsAdvisersReferrals($pro_user_id,$user_id);

	$ar_id = '';	

	

	$user_email = $this->getUserEmailById($user_id);

	$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND ( `request_status` = '1' || `request_status` = '3' ) ORDER BY `ar_id` DESC LIMIT 1";

	//echo $sql;

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
                $row = $STH->fetch(PDO::FETCH_ASSOC);

		$ar_id = $row['ar_id'];

	}

	

	return array($ar_id,$request_status);

}


public function getReportTypeName($report_id)

{

	$DBH = new DatabaseHandler();

	$output = 'My Query';

	

	

	$sql = "SELECT * FROM `tblusersreports` WHERE `report_id`  = '".$report_id."'";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
                $row = $STH->fetch(PDO::FETCH_ASSOC);

		$output = stripslashes($row['report_name']); 

	}	

	return $output;

}


public function getAllAdviserQueriesByID($id)

{

  	$DBH = new DatabaseHandler();

	$temp_arr = array();

	

	$str_feedback_id = $this->getAllConvarsationIdAdviserQuery($id);

	

	$sql = "SELECT * FROM `tbladviserqueries` WHERE  `aq_id` IN (".$str_feedback_id.") ORDER BY `aq_add_date` DESC";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {	

		while( $row = $STH->fetch(PDO::FETCH_ASSOC) ) 

		{	

			$temp_arr[] = $row;

		}

	}

	return $temp_arr;

}


public function getAllConvarsationIdAdviserQuery($id)

{

	$main_parent_id = $this->getMainParantIdAdviserQuery($id);

	$str_feedback_id = $this->getRecursiveAdviserQueryId($main_parent_id,$main_parent_id);

	return $str_feedback_id;

}

public function getMainParantIdAdviserQuery($id)

{

	$DBH = new DatabaseHandler();
        
	$sql = "SELECT * FROM `tbladviserqueries` WHERE `aq_id` = '".$id."' ORDER BY `aq_add_date` DESC";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
                $row = $STH->fetch(PDO::FETCH_ASSOC);

		$parent_feedback_id = $row['parent_aq_id'];

		if($parent_feedback_id == 0)

		{

			return $id;

		}

		else

		{

			return $this->getMainParantIdAdviserQuery($parent_feedback_id);

		}

	}

	else

	{

		return 0;

	}

}


public function getRecursiveAdviserQueryId($main_parent_id,$return)

{

	$DBH = new DatabaseHandler();

	$sql = "SELECT * FROM `tbladviserqueries` WHERE `parent_aq_id` = '".$main_parent_id."' ";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {	

		while( $row = $STH->fetch(PDO::FETCH_ASSOC) ) 

		{	

			$temp_feedback_id = $row['aq_id'];

			if($return == '')

			{

				$return .= $this->getRecursiveAdviserQueryId($temp_feedback_id,$main_parent_id).',';

			}

			else

			{

				$return .= ','.$this->getRecursiveAdviserQueryId($temp_feedback_id,$main_parent_id);

			}	

		}

	}

	else

	{

		$return .= ','.$main_parent_id;

	}

	return $return;

}

public function chk_valid_user_query_id($id,$user_id)

{

	$DBH = new DatabaseHandler();

	$return = false;

	

	$sql = "SELECT * FROM `tbladviserqueries` WHERE `aq_id` = '".$id."' AND `user_id` = '".$user_id."' ";

	//echo $sql;

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

		$return = true;

	}

	return $return;

}

public function setUserQueryRead($aq_id,$user_id,$user_read)

{

	$DBH = new DatabaseHandler();

	$return = false;

	$sql = "UPDATE `tbladviserqueries` SET `user_read` = '".$user_read."' WHERE `aq_id` = '".$aq_id."' AND `user_id` = '".$user_id."'";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

		$return = true;

	}

	return $return;

}


public function getAdviserQueryDetails($aq_id)

{

	$DBH = new DatabaseHandler();
	$temp_arr = array();
	$sql = "SELECT * FROM `tbladviserqueries` WHERE `aq_id` = '".$aq_id."' ";
	//echo $sql;
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {	
		$row = $STH->fetch(PDO::FETCH_ASSOC);
		$temp_arr[] = $row;
	}
	return $temp_arr;

}

public function showAcceptInvitationPopup($user_id,$ar_id,$pro_user_id)
{
	$DBH = new DatabaseHandler();
      
	$output = '';
	$output .= '<div style="margin-top:15px;width:520px;height:400px;overflow:scroll;">';
	$output .= '	<table width="500" border="0" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
                            <tbody>
                                    <tr>
                                            <td height="30" colspan="2" align="left" valign="middle"><strong>I authorise Chaitanya Wellness (www.wellnessway4u.com) to provide access to my Adviser herein to MY following below Reports, solely at my Responsibility. I reconfirm that I have carefully read the Terms of Use for Users of this website. </strong></td>
                                    </tr>';
						
				
						
	//$sql = "SELECT * FROM `tblusersreports` WHERE `report_status` = '1' ORDER BY report_name ASC ";
        
        $sql = "SELECT * FROM `tblpagedropdowns` WHERE pd_id = '20' and  `pd_status` = 1 ";
        
        
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$i = 0;
		$j = 1;
                $row = $STH->fetch(PDO::FETCH_ASSOC);
                $page_id_arr = explode(',', $row['page_id_str']);
                for($l=0;$l<count($page_id_arr);$l++)
		//while ($row = $STH->fetch(PDO::FETCH_ASSOC)) 
		{
			$report_name = stripslashes($this->get_PageName($page_id_arr[$l]));
			$report_id = stripslashes($page_id_arr[$l]);
			$sql2 = "SELECT * FROM `tbladviserplanatributes` WHERE `page_id` = '".$page_id_arr[$l]."' AND `apa_status` = '1' AND `show_for_user` = '1' ORDER BY `apa_id` DESC LIMIT 1";			
                        $STH2 = $DBH->query($sql2);
			if( $STH2->rowCount() > 0 )
                        {
				$row2 = $STH2->fetch(PDO::FETCH_ASSOC);
				$temp_apa_id = $row2['apa_id'];
                                
                                $flag = $this->Checkifplanexist($page_id_arr[$i]);
                                if($flag)
                                {
				if($this->chkUserPlanFeaturePermission($user_id,$temp_apa_id))
				{
					if($this->chkReportTypePermissionForAdviser($ar_id,$report_id))
					{
						$selected = ' checked ';
						$selval = $this->getPermissionTypeForAdviserReport($ar_id,$report_id);
						if($selval == '2')
						{
							$pt_selected1 = '';
							$pt_selected2 = ' selected ';
							$pt_selected3 = '';
						}	
						elseif($selval == '3')
						{
							$pt_selected1 = '';
							$pt_selected2 = '';
							$pt_selected3 = ' selected ';
						}	
						else
						{
							$pt_selected1 = ' selected ';
							$pt_selected2 = '';
							$pt_selected3 = '';
						}	
					}
					else
					{
						$selected = '';
						$pt_selected1 = ' selected ';
						$pt_selected2 = '';
						$pt_selected3 = '';
					}

                                        $output .= '<tr>
							<td width="300" height="30" align="left" valign="middle"><strong><input type="checkbox" '.$selected.' name="report_id" id="report_id_'.$i.'" value="'.$page_id_arr[$l].'" />&nbsp;<strong>'.$report_name.'</strong></td>
							<td width="200" height="30" align="left" valign="middle">
								<select name="permission_type" id="permission_type_'.$i.'">
									<option value="1" '.$pt_selected1.' >Both Set</option>
									<option value="2" '.$pt_selected2.' >Standard Set</option>
									<option value="3" '.$pt_selected3.' >Adviser Set</option>
								</select>
							</td>
							
						</tr>';
						
					$i++;	
					$j++;		
				}
                                }
                                else
                                {
                                  //echo 'hiiii';
                                  if($this->chkReportTypePermissionForAdviser($ar_id,$report_id))
					{
						$selected = ' checked ';
						$selval = $this->getPermissionTypeForAdviserReport($ar_id,$report_id);
						if($selval == '2')
						{
							$pt_selected1 = '';
							$pt_selected2 = ' selected ';
							$pt_selected3 = '';
						}	
						elseif($selval == '3')
						{
							$pt_selected1 = '';
							$pt_selected2 = '';
							$pt_selected3 = ' selected ';
						}	
						else
						{
							$pt_selected1 = ' selected ';
							$pt_selected2 = '';
							$pt_selected3 = '';
						}	
					}
					else
					{
						$selected = '';
						$pt_selected1 = ' selected ';
						$pt_selected2 = '';
						$pt_selected3 = '';
					}

                                        $output .= '<tr>
							<td width="300" height="30" align="left" valign="middle"><strong><input type="checkbox" '.$selected.' name="report_id" id="report_id_'.$i.'" value="'.$page_id_arr[$l].'" />&nbsp;<strong>'.$report_name.'</strong></td>
							<td width="200" height="30" align="left" valign="middle">
								<select name="permission_type" id="permission_type_'.$i.'">
									<option value="1" '.$pt_selected1.' >Both Set</option>
									<option value="2" '.$pt_selected2.' >Standard Set</option>
									<option value="3" '.$pt_selected3.' >Adviser Set</option>
								</select>
							</td>
							
						</tr>';
						
					$i++;	
					$j++;	  
                                }
                                
                                
			}
                        else
                        {
                          if($this->chkReportTypePermissionForAdviser($ar_id,$report_id))
					{
						$selected = ' checked ';
						$selval = $this->getPermissionTypeForAdviserReport($ar_id,$report_id);
						if($selval == '2')
						{
							$pt_selected1 = '';
							$pt_selected2 = ' selected ';
							$pt_selected3 = '';
						}	
						elseif($selval == '3')
						{
							$pt_selected1 = '';
							$pt_selected2 = '';
							$pt_selected3 = ' selected ';
						}	
						else
						{
							$pt_selected1 = ' selected ';
							$pt_selected2 = '';
							$pt_selected3 = '';
						}	
					}
					else
					{
						$selected = '';
						$pt_selected1 = ' selected ';
						$pt_selected2 = '';
						$pt_selected3 = '';
					}

                                        $output .= '<tr>
							<td width="300" height="30" align="left" valign="middle"><strong><input type="checkbox" '.$selected.' name="report_id" id="report_id_'.$i.'" value="'.$page_id_arr[$l].'" />&nbsp;<strong>'.$report_name.'</strong></td>
							<td width="200" height="30" align="left" valign="middle">
								<select name="permission_type" id="permission_type_'.$i.'">
									<option value="1" '.$pt_selected1.' >Both Set</option>
									<option value="2" '.$pt_selected2.' >Standard Set</option>
									<option value="3" '.$pt_selected3.' >Adviser Set</option>
								</select>
							</td>
							
						</tr>';
						
					$i++;	
					$j++;  
                        }
		}
		
		$output .='<tr>
							<td height="30" align="left" valign="middle"><strong><input type="button" name="btnDoAccept" id="btnDoAccept" value="Confirm" onclick="doAcceptAdviserInvitation(\''.$ar_id.'\',\''.$pro_user_id.'\')" />&nbsp;&nbsp;<input type="button" name="btnCancelPopup" id="btnCancelPopup" value="Cancel" /></strong></td>
							
						</tr>';		
	}					
	
	
	$output .='</tbody>
					</table>
				</div>';
	return $output;
}

public function chkReportTypePermissionForAdviser($ar_id,$report_id)
{
	$DBH = new DatabaseHandler();
	$return = false;
	
	$sql = "SELECT * FROM `tbladviserreferrals` WHERE `ar_id` = '".$ar_id."' AND `report_id` != '' AND FIND_IN_SET('".$report_id."', report_id)";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$return = true;
	}
	
	return $return;
}


public function getPermissionTypeForAdviserReport($ar_id,$report_id)
{
	$DBH = new DatabaseHandler();
	$return = '1';
	
	if($this->chkReportTypePermissionForAdviser($ar_id,$report_id))
	{
		$sql = "SELECT * FROM `tbladviserreferrals` WHERE `ar_id` = '".$ar_id."' ";
		$STH = $DBH->query($sql);
                if( $STH->rowCount() > 0 )
                {
			$row = $STH->fetch(PDO::FETCH_ASSOC);
			$str_report_id = stripslashes($row['report_id']);
			$str_permission_type = stripslashes($row['permission_type']);
			
			if($str_permission_type != '')
			{
				$arr_ri = explode(',',$str_report_id);
				$arr_pt = explode(',',$str_permission_type);
				
				$key = array_search($report_id, $arr_ri);
				if($key !== FALSE )
				{
					if(isset($arr_pt[$key]))
					{
						$return = $arr_pt[$key];
					}
				} 
			}
			
		}
	}
		
	return $return;
}

public function doAcceptAdviserInvitation($ar_id,$report_id,$user_id,$pro_user_id,$permission_type)

{

	$DBH = new DatabaseHandler();
	$return = false;
	if($this->chkIfAdviserRequestDateisUpdated($pro_user_id,$user_id))

	{
		echo $sql = "UPDATE `tbladviserreferrals` SET "
                        . "`request_status` = '1' , `report_id` = '".$report_id."' , `permission_type` = '".$permission_type."'  , `last_status_updated_by_adviser` = '0' "
                        . "WHERE `ar_id` = '".$ar_id."'";
	}
	else
	{

		echo $sql = "UPDATE `tbladviserreferrals` SET "
                        . "`request_accept_date` = NOW() , `request_status` = '1' , `report_id` = '".$report_id."' , `permission_type` = '".$permission_type."'  , `last_status_updated_by_adviser` = '0' "
                        . "WHERE `ar_id` = '".$ar_id."'";

	}

                $STH = $DBH->query($sql);
                if( $STH->rowCount() > 0 )
                {

		$sql2 = "INSERT INTO `tbladviserreportpermission`(`ar_id`,`user_id`,`pro_user_id`,`report_id`,`permission_type`) VALUES('".$ar_id."','".$user_id."','".$pro_user_id."','".$report_id."','".$permission_type."')";
		$STH2 = $DBH->query($sql2);
                if( $STH2->rowCount() > 0 )
                {

			$return = true;

		}

	}

	return $return;

	 

}


public function chkIfAdviserRequestDateisUpdated($pro_user_id,$user_id)

{

	$DBH = new DatabaseHandler();
	$return = true;

	$user_email = $this->getUserEmailById($user_id);

	$sql = "SELECT * FROM `tbladviserreferrals` WHERE `pro_user_id` = '".$pro_user_id."' AND `user_email` = '".$user_email."' AND `request_accept_date` = '0000-00-00 00:00:00'";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$return = false;

	}

	return $return;

}

function showDeactivateAdviserInvitationPopup($ar_id,$pro_user_id)

{


	$output = '';

	$output .= '<div style="margin-top:15px;width:520px;height:400px;overflow:scroll;">';

	$output .= '	<table width="500" border="0" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">

					<tbody>

						';

						

				

	$output .= '		<tr>

							<td colspan="2" align="left" valign="middle" height="40">&nbsp;</td>

						</tr>';					

	



	$output .= '		<tr>

							<td width="35%" align="left" valign="top"><strong><span style="font-size:14px;">Reason for Deactivation:</span></strong></td>

							<td width="65%" align="left" valign="top"><textarea id="status_reason" name="status_reason" style="width:200px;height:100px;"></textarea></td>

						</tr>';

						

	$output .= '		<tr>

							<td colspan="2" align="left" valign="middle" height="40">&nbsp;</td>

						</tr>';							

						

			

		

		$output .= '		<tr>

							<td colspan="2" height="30" align="left" valign="middle"><strong><input type="button" name="btnDoAccept" id="btnDoAccept" value="Deactivate" onclick="deactivateAdviserInvitation(\''.$ar_id.'\',\''.$pro_user_id.'\')" />&nbsp;&nbsp;<input type="button" name="btnCancelPopup" id="btnCancelPopup" value="Cancel" /></strong></td>

							

						</tr>';		

					

	

	

	$output .= '	</tbody>

					</table>

				</div>';

	return $output;

}


public function deactivateAdviserInvitation($ar_id,$user_id,$pro_user_id,$status_reason)
{
	$DBH = new DatabaseHandler();
	$return = false;
	$sql = "UPDATE `tbladviserreferrals` SET "
                . "`request_status` = '3' , `last_status_updated_by_adviser` = '0' "
                . "WHERE `ar_id` = '".$ar_id."' ";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$sql2 = "INSERT INTO `tbladviseractivation`(`ar_id`,`user_id`,`pro_user_id`,`aa_status`,`aa_status_reason`,`aa_status_updated_by_adviser`) VALUES('".$ar_id."','".$user_id."','".$pro_user_id."','3','".addslashes($status_reason)."','0')";

		$STH2 = $DBH->query($sql2);
                if( $STH2->rowCount() > 0 )
                {
			$return = true;
		}
	}

	return $return;

}

public function showActivateAdviserInvitationPopup($ar_id,$pro_user_id)

{

	$output = '';

	$output .= '<div style="margin-top:15px;width:520px;height:400px;overflow:scroll;">';

	$output .= '	<table width="500" border="0" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">

					<tbody>

						';

						

				

	$output .= '		<tr>

							<td colspan="2" align="left" valign="middle" height="40">&nbsp;</td>

						</tr>';					

	



	$output .= '		<tr>

							<td width="35%" align="left" valign="top"><strong><span style="font-size:14px;">Reason for Activation:</span></strong></td>

							<td width="65%" align="left" valign="top"><textarea id="status_reason" name="status_reason" style="width:200px;height:100px;"></textarea></td>

						</tr>';

						

	$output .= '		<tr>

							<td colspan="2" align="left" valign="middle" height="40">&nbsp;</td>

						</tr>';							

						

			

		

		$output .= '		<tr>

							<td colspan="2" height="30" align="left" valign="middle"><strong><input type="button" name="btnDoAccept" id="btnDoAccept" value="Activate" onclick="activateAdviserInvitation(\''.$ar_id.'\',\''.$pro_user_id.'\')" />&nbsp;&nbsp;<input type="button" name="btnCancelPopup" id="btnCancelPopup" value="Cancel" /></strong></td>

							

						</tr>';		

				

	

	

	$output .= '	</tbody>

					</table>

				</div>';

	return $output;

}

public function activateAdviserInvitation($ar_id,$user_id,$pro_user_id,$status_reason)

{

	$DBH = new DatabaseHandler();

	$return = false;

	

	$sql = "UPDATE `tbladviserreferrals` SET "

                . "`request_status` = '1' , `last_status_updated_by_adviser` = '0' "

                . "WHERE `ar_id` = '".$ar_id."' ";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {

		$sql2 = "INSERT INTO `tbladviseractivation`(`ar_id`,`user_id`,`pro_user_id`,`aa_status`,`aa_status_reason`,`aa_status_updated_by_adviser`) VALUES('".$ar_id."','".$user_id."','".$pro_user_id."','1','".addslashes($status_reason)."','0')";

		$STH2 = $DBH->query($sql2);
                if( $STH2->rowCount() > 0 )
                {

			

			$return = true;

		}

	}

	return $return;

}


public function showAdviserQueryPopup($user_id,$parent_aq_id)

{


	$output = '';
	$name = $this->getUserFullNameById($user_id);
	$email = $this->getUserEmailById($user_id);
	$readonly = ' readonly ';
	$temp_pro_user_id = '';
	if($parent_aq_id == '' || $parent_aq_id == '0'  || $parent_aq_id == 0)
	{

		$readonly2 = '';
		$parent_aq_id = '0';
		$temp_page_id = '';
	}
	else
	{

		$query_data = $this->getAdviserQueryDetails($parent_aq_id);
		$temp_pro_user_id = $query_data[0]['pro_user_id'];
		$temp_page_id = $query_data[0]['page_id'].'_'.$query_data[0]['permission_type'];
		$readonly2 = ' readonly ';
	}

	$output .= '<br><br>

				<form id="frmadviserquery" name="frmadviserquery" method="post" action="#" enctype="multipart/form-data">

					<input type="hidden" name="hdnparent_aq_id" id="hdnparent_aq_id" value="'.$parent_aq_id.'" />

					<input type="hidden" name="hdnname" id="hdnname" value="'.$name.'" />

					<input type="hidden" name="hdnemail" id="hdnemail" value="'.$email.'" />

					<table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">';

	

	if($parent_aq_id == '0')

	{

	$output .= '		<tr>

							<td width="60%" height="40" align="left" valign="top">Adviser:</td>

							<td width="40%" height="40" align="left" valign="top">

								<select id="temp_pro_user_id" name="temp_pro_user_id" '.$readonly2.' onchange="getAdviserQueryPageOptions('.$user_id.',\''.$readonly2.'\',\'temp_pro_user_id\',\'temp_page_id\')" style="width:150px;">

									<option value="">Select Adviser</option>

									'.$this->getUsersAdviserOptions($user_id,$temp_pro_user_id).'

								</select>

							</td>

						</tr>

						<tr>

							<td width="60%" height="40" align="left" valign="top">Reference:</td>
							<td width="40%" height="40" align="left" valign="top" id="idreference2">
								<select id="temp_page_id" name="temp_page_id" '.$readonly2.' style="width:150px;">
									<option value="">Select Reference</option>
									'.$this->getAdviserQueryPageOptions($temp_page_id,$user_id,$temp_pro_user_id,'0').'
								</select>
							</td>
						</tr>';

		}

		else

		{

			$output .= '<tr>

							<td width="60%" height="40" align="left" valign="top">Adviser:</td>
							<td width="40%" height="40" align="left" valign="top">'.$this->getProUserFullNameById($temp_pro_user_id).'
								<input type="hidden" id="temp_pro_user_id" name="temp_pro_user_id" value="'.$temp_pro_user_id.'" >
							</td>
						</tr>
						<tr>

							<td width="60%" height="40" align="left" valign="top">Reference:</td>
							<td width="40%" height="40" align="left" valign="top" id="idreference">'.$this->getReportTypeName($temp_page_id).'
								<input type="hidden" id="temp_page_id" name="temp_page_id" value="'.$temp_page_id.'">
							</td>
						</tr>';

		

		}				

		$output .= '	<tr>

							<td width="60%" height="110" align="left" valign="top">Query:</td>
							<td width="40%" height="110" align="left" valign="top">
							<textarea id="feedback_text" name="feedback_text" style="width:200px;height:100px;"></textarea>
                                                        </td>
						</tr>
						<tr>
							<td width="60%" height="40" align="left" valign="middle">&nbsp;</td>
							<td width="40%" height="40" align="left" valign="middle">
							<input name="submit" type="button" class="button" id="submit" value="Submit"  onclick="addAdviserQuery()"/>
							</td>
						</tr>   
					</table>
				</form>';

	

	return $output;

}

public function addAdviserQuery($parent_aq_id,$page_id,$user_id,$name,$email,$pro_user_id,$from_user,$query)

{

	$DBH = new DatabaseHandler();
	$return = false;
	if($page_id == '')
	{
		$temp_page_id = '0';
		$temp_permission_type = '0';
	}	
	else
	{
		$arr_temp = explode('_',$page_id);
		$temp_page_id = $arr_temp[0];
		$temp_permission_type = $arr_temp[1];
	}

	

	if($from_user == '1')

	{

		$aq_user_unique_id = $this->getUserAqUniqueId($user_id);

	}

	else

	{

		$aq_user_unique_id = $this->getProUserAqUniqueId($pro_user_id);	

	}	

	$sql = "INSERT INTO `tbladviserqueries`(`parent_aq_id`,`aq_user_unique_id`,`page_id`,`permission_type`,`user_id`,`user_name`,`user_email`,`pro_user_id`,`query`,`from_user`,`aq_status`) VALUES ('".addslashes($parent_aq_id)."','".addslashes($aq_user_unique_id)."','".addslashes($temp_page_id)."','".addslashes($temp_permission_type)."','".addslashes($user_id)."','".addslashes($name)."','".addslashes($email)."','".addslashes($pro_user_id)."','".addslashes($query)."','".addslashes($from_user)."','1')";
	//echo $sql;

	$STH = $DBH->query($sql);
            if( $STH->rowCount() > 0 )
            {
            $return = true;

	}

	

	return $return;

}	

public function getUserAqUniqueId($user_id)

{

	$DBH = new DatabaseHandler();
	$return = '';

	$name = $this->getUserFullNameById($user_id);

	if($name != '')

	{

		$str_name = strtoupper(substr($name,0,4));

		

		$sql = "SELECT * FROM `tbladviserqueries` WHERE `user_id` = '".$user_id."' AND `from_user` = '1' ";

		//echo $sql;

		$STH = $DBH->query($sql);
                if( $STH->rowCount() > 0 )
                {

			$num_rows = $STH->rowCount() + 1;

			

			if(strlen($num_rows) == 1)

			{

				$num_rows = '0000'.$num_rows;

			}

			elseif(strlen($num_rows) == 2)

			{

				$num_rows = '000'.$num_rows;

			}

			elseif(strlen($num_rows) == 3)

			{

				$num_rows = '00'.$num_rows;

			}

			elseif(strlen($num_rows) == 4)

			{

				$num_rows = '0'.$num_rows;

			}

			else

			{

				$num_rows = $num_rows;

			}

			$return = $str_name.$num_rows;

		}

	}

	return $return;

}


public function getProUserAqUniqueId($pro_user_id)

{

	$DBH = new DatabaseHandler();
	$return = '';

	

	$name = $this->getProUserFullNameById($pro_user_id);

	if($name != '')

	{

		$str_name = strtoupper(substr($name,0,4));

		

		$sql = "SELECT * FROM `tbladviserqueries` WHERE `pro_user_id` = '".$pro_user_id."' AND `from_user` = '0' ";

		//echo $sql;

		$STH = $DBH->query($sql);
                if( $STH->rowCount() > 0 )
                {

			$num_rows = $STH->rowCount() + 1;

			

			if(strlen($num_rows) == 1)

			{

				$num_rows = '0000'.$num_rows;

			}

			elseif(strlen($num_rows) == 2)

			{

				$num_rows = '000'.$num_rows;

			}

			elseif(strlen($num_rows) == 3)

			{

				$num_rows = '00'.$num_rows;

			}

			elseif(strlen($num_rows) == 4)

			{

				$num_rows = '0'.$num_rows;

			}

			else

			{

				$num_rows = $num_rows;

			}

			$return = $str_name.$num_rows;

		}

	}

	return $return;

}

public function getupaid($page_id)
{
        $DBH = new DatabaseHandler();
	$user_upa_id = '';
	$sql = "SELECT * FROM `tbladviserplanatributes` WHERE `page_id` = '".$page_id."' AND `apa_status` = '1' ";

	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
                $row = $STH->fetch(PDO::FETCH_ASSOC);
		$user_upa_id = $row['apa_id'];
	}
	return $user_upa_id;   
}


public function Checkifplanexist($user_upa_id)
{
        $DBH = new DatabaseHandler();
	$flag = false;
	$sql = "SELECT * FROM `tbladviserplanatributes` WHERE `page_id` = '".$user_upa_id."' AND `apa_status` = '1' ";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
		$flag = true;
	}
	return $flag;    
}

public function getAdviserQueryPageOptionsnew($page_id,$user_id,$pro_user_id,$show_all)

{

	$DBH = new DatabaseHandler();
	$option_str = '';
	if($page_id == '0_0')

	{
		$sel = ' selected ';
	}

	else

	{

		$sel = '';

	}		

	//$option_str .= '<option value="0_0" '.$sel.'>My Query</option>';	

	

	$str_report_id = $this->getUserAcceptedReportId($user_id,$pro_user_id);

	if($str_report_id != '')

	{	

		$arr_report_id = explode(',',$str_report_id); 
		for($i=0;$i<count($arr_report_id);$i++)
		{ 
			$option_str .= '<option value="'.$arr_report_id[$i].'_0">'.$this->get_PageName($arr_report_id[$i]).' (Standard Set)</option>';

			$option_str .= '<option value="'.$arr_report_id[$i].'_1">'.$this->get_PageName($arr_report_id[$i]).' (Adviser Set)</option>';

		}

	}

	elseif($show_all == '1')

	{

		//$sql = "SELECT * FROM `tblusersreports` ORDER BY `report_name` ASC";
                $sql = "SELECT * FROM `tblpagedropdowns` WHERE pd_id = '20' and  `pd_status` = 1 ";
		//echo $sql;

		$STH = $DBH->query($sql);

                if( $STH->rowCount() > 0 )
                {
                    
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
//                    echo $row['page_id_str'];
//                    die();
                    $page_id_arr = explode(',', $row['page_id_str']);
                    
//                    echo '<pre>';
//                            print_r($page_id_arr);
//                            echo '</pre>';
                    
                    for($i=0;$i<count($page_id_arr);$i++)
                    //while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
                    {

				$sql2 = "SELECT * FROM `tbladviserplanatributes` WHERE `page_id` = '".$page_id_arr[$i]."' AND `apa_status` = '1' AND `show_for_user` = '1' ORDER BY `apa_id` DESC LIMIT 1";

				//echo $sql;

				$STH2 = $DBH->query($sql2);

                                if( $STH2->rowCount() > 0 )
                                {

					$row2 = $STH2->fetch(PDO::FETCH_ASSOC);

					$temp_apa_id = $row2['apa_id'];
                                       
					if($this->chkUserPlanFeaturePermission($user_id,$temp_apa_id))

					{

						if($page_id == $page_id_arr[$i].'_1')

						{

							$sel1 = '';

							$sel2 = ' selected ';

						}

						elseif($page_id == $page_id_arr[$i].'_0')

						{

							$sel1 = ' selected ';

							$sel2 = '';

						}

						else

						{

							$sel1 = '';

							$sel2 = '';

						}	

						

						$option_str .= '<option value="'.$page_id_arr[$i].'_0" '.$sel1.'>'.$this->get_PageName($page_id_arr[$i]).' (Standard Set)</option>';

						$option_str .= '<option value="'.$page_id_arr[$i].'_1" '.$sel2.'>'.$this->get_PageName($page_id_arr[$i]).' (Adviser Set)</option>';
                                                //die();
					}

				}

			}

		}

	}		

		

		

	return $option_str;

}


}


?>