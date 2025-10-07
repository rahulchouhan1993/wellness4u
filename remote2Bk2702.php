<?php
include('classes/config.php');
$action = stripslashes($_REQUEST['action']);
$obj = new frontclass();   
//print_r($_REQUEST);

if($action == 'resendotp')
    {
    $obj2 = new Profclass();   
    $response=array();
    $email=$_REQUEST['email']!='' ? $_REQUEST['email'] : '';
    $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string_shuffled = str_shuffle($string);
    $otp = substr($string_shuffled, 1, 6);
    $data = array();
    $data['email'] = $email;
    $data['otp'] = $otp;
    
    $otp_flag = $obj2->reSendProfOTP($data);
    
    if($otp_flag)
        {
            
            $tdata_sms_otp = array();
            $tdata_sms_otp['email'] = $email;
            $tdata_sms_otp['sms_message'] = 'OTP for activating profile is: '.$otp;		
            $obj2->sendProfSMS($tdata_sms_otp);
            $response['msg'] = 'OTP send successfully on registered mobile please activate your profile using OTP ';
            $response['status'] = 1;
        }
    echo json_encode(array($response));
    exit(0);    
    }

elseif($action == 'VerifyOTP')
    {
    $obj2 = new Profclass();   
    
    $data = array();
    $data['email'] = $_REQUEST['email'];
    $data['otp'] = $_REQUEST['otp'];
    $otp_flag = $obj2->VerifyOTP($data);
    
    if($otp_flag)
        {
            $response['msg'] = 'Your account activated successfully click link and start login in your profile <a href="wa_register.php" style="color:blue;">Login</a>';
            $response['status'] = 1;
        }
    echo json_encode(array($response));
    exit(0);    
    }
    elseif($action == 'resenduserotp')
    {
    $obj = new frontclass();   
    $response=array();
    $email=$_REQUEST['email']!='' ? $_REQUEST['email'] : '';
    $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string_shuffled = str_shuffle($string);
    $otp = substr($string_shuffled, 1, 6);
    $data = array();
    $data['email'] = $email;
    $data['otp'] = $otp;
    
    $otp_flag = $obj->reSendUserOTP($data);
    
    if($otp_flag)
        {
            $user_data = $obj->getUserDetails($email);
            $tdata_sms_otp = array();
            $tdata_sms_otp['mobile_no'] = $user_data['mobile'];
            $tdata_sms_otp['sms_message'] = 'OTP for activating profile is: '.$otp;		
            $obj->sendSMS($tdata_sms_otp);
            $response['msg'] = 'OTP send successfully on registered mobile please activate your profile using OTP ';
            $response['status'] = 1;
        }
    echo json_encode(array($response));
    exit(0);    
    }
    elseif($action == 'VerifyUserOTP')
    {
    $obj = new frontclass();   
    
    $data = array();
    $data['email'] = $_REQUEST['email'];
    $data['otp'] = $_REQUEST['otp'];
    $otp_flag = $obj->VerifyOTP($data);
    
    if($otp_flag)
        {
            $response['msg'] = 'Your account activated successfully click link and start login in your profile <a href="login.php">Login</a>';
            $response['status'] = 1;
        }
    echo json_encode(array($response));
    exit(0);    
    }
elseif($action =='geteventregistrationfees')
{   
//    print_r($_REQUEST);
//    die();
    $event_id = $_REQUEST['event_id'];
    $registration_type = $_REQUEST['registration_type'];
    
//    echo $event_id;
//    echo $registration_type;
    
    if($event_id!='' && $registration_type!='')
    {
        //echo 'Hiii';
        $obj = new frontclass();   
        $registraion_fees = $obj->GetEventRegistrationfess($event_id,$registration_type);
        echo number_format($registraion_fees,2);
        exit(0);
    }
} 

elseif($action =='geteventticketfees')
{   
//    print_r($_REQUEST);
//    die();
    $event_id = $_REQUEST['event_id'];
    $ticket_type = $_REQUEST['ticket_type'];
    
//    echo $event_id;
//    echo $registration_type;
    
    if($event_id!='' && $ticket_type!='')
    {
        //echo 'Hiii';
        $obj = new frontclass();   
        $registraion_fees = $obj->GetEventTicketfess($event_id,$ticket_type);
        echo number_format($registraion_fees,2);
        exit(0);
    }
} 

elseif($action =='geteventticketqty')
{   

    $event_id = $_REQUEST['event_id'];
    $ticket_type = $_REQUEST['ticket_type'];
    
    if($event_id!='' && $ticket_type!='')
    {
        $obj = new frontclass();   
        $registraion_fees = $obj->GetEventTicketQty($event_id,$ticket_type);
        echo $registraion_fees;
        exit(0);
    }
}

elseif($action == 'addtocart')
{
        $error = 0;
	$err_msg = '';
	$event_id = '';
	if(isset($_POST['event_id']) && trim($_POST['event_id']) != '')
	{
		$event_id = trim($_POST['event_id']);
	}
	
	$qty = '';
	if(isset($_POST['qty']) && trim($_POST['qty']) != '')
	{
		$qty = trim($_POST['qty']);
	}
	
	$booking_slot = '';
	if(isset($_POST['booking_slot']) && trim($_POST['booking_slot']) != '')
	{
		$booking_slot = trim($_POST['booking_slot']);
	}
        else
        {
            $error = 1;
            $err_msg = 'Please select Session';
        }
	
	$booking_date = '';
	if(isset($_POST['booking_date']) && trim($_POST['booking_date']) != '')
	{
		$booking_date = trim($_POST['booking_date']);
	}
        
        $type = '';
	if(isset($_POST['type']) && trim($_POST['type']) != '')
	{
		$type = trim($_POST['type']);
	}
        
        $registraion_type = '';
	if(isset($_POST['registraion_type']) && trim($_POST['registraion_type']) != '')
	{
		$registraion_type = trim($_POST['registraion_type']);
	}
        
	
	
	if($event_id != '')
	{
		if($qty != '')
		{
			if($obj->chkIfTicketQtyAvailable($event_id,$qty,$type))
			{
				if($obj->addToCart($event_id,$qty,$booking_slot,$booking_date,$type,$registraion_type))
				{
					$error = 0;
					$err_msg = 'Item added successfully';
				}
				else
				{
					$error = 1;
					$err_msg = 'Something went wrong, Please try again later.';
				}	
			}
			else
			{
				$error = 1;
				$err_msg = 'Sorry currently this quantity not available';
			}	
		}
		else
		{
			$error = 1;
			$err_msg = 'Invalid quantity';
		}			
	}
	else
	{
		$error = 1;
		$err_msg = 'Please select any item';
	}
	
	$ret_str = $test.'::::'.$error.'::::'.$err_msg;
	echo $ret_str;
}

elseif($action == 'getAllDelaveyListOfItem')
	{

	$event_id = '';
        $cusine_name='';
        
        
	if(isset($_POST['event_id']) && trim($_POST['event_id']) != '')
		{
                    $event_id = trim($_POST['event_id']);
                    $cnt = 0;   // $j ==cnt ;
                    $type = trim($_POST['type']);
		}
		$item_delavery=$obj->getAllDelaveryListOfItem($event_id);  // $order_cutoff_time is a refference data;
		
//                echo '<pre>';
//                print_r($item_delavery);
//                echo '</pre>';
                
		if(is_array($item_delavery) && count($item_delavery))
		{
		$now = time();
		$next_delavery_date=array();
                
//                echo '<pre>';
//                print_r($date_data);
//                echo '</pre>';
                
                
		if($item_delavery['registration_cutoff_time']!='')
			{
                        
			$delaverydate_array=$item_delavery['delavery_date'];
                        for($k=0;$k <count($delaverydate_array) ; $k++)
				{
                                    $cusine_delivery_date=$delaverydate_array[$k];	
                                    //
                                    $date = date( 'Y-m-d', strtotime($cusine_delivery_date ) );
                                     //$one_day_before_current_showing_date = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
                                    //$current_showing_date_time = $current_showing_date. ' 23:59:59';
                                    $one_day_before_current_showing_date = $date.' '.date("H:i:s");
                                    //$current_showing_date_time = $one_day_before_current_showing_date. ' '.$date_data[0].':00';
                                   //echo '<br>';
                                    $current_showing_date_time = $one_day_before_current_showing_date;
                                    $timestamp_csdt = strtotime($current_showing_date_time);
                                    $sec_cuttoff_time = $item_delavery['registration_cutoff_time'] * 3600;
                                    //$final_compared_timestamp = $timestamp_csdt - $sec_cuttoff_time;
                                    $final_compared_timestamp = $timestamp_csdt - $sec_cuttoff_time;
                                    if($now < $final_compared_timestamp)
					{
                                            $next_delavery_date[]= $cusine_delivery_date;
					}
                                       // $next_delavery_date[]= $cusine_delivery_date;
				}				
			}			
		}
    $req='';
       
	if(is_array($next_delavery_date) && count($next_delavery_date) > 0)
		{
		$cusine_id=$item_delavery['event_id'];
		//
                $req='<div class="table-responsive">          
				<table class="table table-bordered">
					<thead>
						<tr>
                                                    <th>Dates</th>';
                                                    
                                                    if($type == 'Registraion')
                                                    {
                                                        $req .='<th>Registraion Type</th>';
                                                    }
                                                    
                                                    $req .='<th>Slots</th>
                                                    
                                                    <th>Book</th>
						</tr>
					</thead>
				<tbody>';		
		for($j=0; $j < count($next_delavery_date) ; $j++)
			{
                        $slot='';
                        $time = strtotime(date("H:i:s")) + ($item_delavery['registration_cutoff_time']* 3600);
                        $slot_capare = date("Y-m-d").' '.date("H:i:s", $time);
                        $slot_capare_final = strtotime($slot_capare);
                        
                        $slot_1_time= explode(' ', $item_delavery['time_slot']['slot1_start_time']);
                        $slot_2_time= explode(' ', $item_delavery['time_slot']['slot2_start_time']);
                        $slot_3_time= explode(' ', $item_delavery['time_slot']['slot3_start_time']);
                        $slot_4_time= explode(' ', $item_delavery['time_slot']['slot4_start_time']);
                        $slot_5_time= explode(' ', $item_delavery['time_slot']['slot5_start_time']);
                        $slot_6_time= explode(' ', $item_delavery['time_slot']['slot6_start_time']);
                            
                        
                        $slot_1 = $next_delavery_date[$j].' '.$slot_1_time[0].':00';
                        $slot_2 = $next_delavery_date[$j].' '.$slot_2_time[0].':00';
                        $slot_3 = $next_delavery_date[$j].' '.$slot_3_time[0].':00';
                        $slot_4 = $next_delavery_date[$j].' '.$slot_4_time[0].':00';
                        $slot_5 = $next_delavery_date[$j].' '.$slot_5_time[0].':00';
                        $slot_6 = $next_delavery_date[$j].' '.$slot_6_time[0].':00';
                        
                        $slot_1_campare = strtotime($slot_1);
                        $slot_2_campare = strtotime($slot_2);
                        $slot_3_campare = strtotime($slot_3);
                        $slot_4_campare = strtotime($slot_4);
                        $slot_5_campare = strtotime($slot_5);
                        $slot_6_campare = strtotime($slot_6);
                        
                    
                        if($slot_1_campare > $slot_capare_final)
                        {
                            $slot .=(($item_delavery['time_slot']['slot1_start_time'] & $item_delavery['time_slot']['slot1_end_time'])!= '' ? '<option value="1">'.$item_delavery['time_slot']['slot1_start_time'].' TO '.$item_delavery['time_slot']['slot1_end_time'].'</option>' : '');
                        }
                         if($slot_2_campare > $slot_capare_final)
                        {
                            $slot .=(($item_delavery['time_slot']['slot2_start_time'] & $item_delavery['time_slot']['slot2_end_time'])!= '' ? '<option value="2">'.$item_delavery['time_slot']['slot2_start_time'].' TO '.$item_delavery['time_slot']['slot2_end_time'].'</option>' : '');
                        }
                         if($slot_3_campare > $slot_capare_final)
                        {
                            $slot .=(($item_delavery['time_slot']['slot3_start_time'] & $item_delavery['time_slot']['slot3_end_time'])!= '' ? '<option value="3">'.$item_delavery['time_slot']['slot3_start_time'].' TO '.$item_delavery['time_slot']['slot3_end_time'].'</option>' : '');
                        }
                         if($slot_4_campare > $slot_capare_final)
                        {
                            $slot .=(($item_delavery['time_slot']['slot4_start_time'] & $item_delavery['time_slot']['slot4_end_time'])!= '' ? '<option value="4">'.$item_delavery['time_slot']['slot4_start_time'].' TO '.$item_delavery['time_slot']['slot4_end_time'].'</option>' : '');
                        }
                         if($slot_5_campare > $slot_capare_final)
                        {
                            $slot .=(($item_delavery['time_slot']['slot5_start_time'] & $item_delavery['time_slot']['slot5_end_time'])!= '' ? '<option value="5">'.$item_delavery['time_slot']['slot5_start_time'].' TO '.$item_delavery['time_slot']['slot5_end_time'].'</option>' : '');
                        }
                         if($slot_6_campare > $slot_capare_final)
                        {
                            $slot .=(($item_delavery['time_slot']['slot6_start_time'] & $item_delavery['time_slot']['slot6_end_time'])!= '' ? '<option value="6">'.$item_delavery['time_slot']['slot6_start_time'].' TO '.$item_delavery['time_slot']['slot6_end_time'].'</option>' : '');
                        }
                        $temp_showing_date = date('jS F',strtotime($next_delavery_date[$j]));
			$temp_showing_day = date(' ( l ) ',strtotime($next_delavery_date[$j]));
			$req .='<tr>
                                        <td>'.$temp_showing_date.'<span class="small_note">'.$temp_showing_day.'</td>';
                                        
                                        if($type == 'Registraion')
                                        {
                                          $registration_type = $obj->GetEventRegistrationType($event_id);
                                          $req .='<td><select name="registraion_type_'.$j.'" id="registraion_type_'.$j.'" required="" class="form-control">
                                            <option value="">Select Registration Type</option>'.$obj->GetRegistratiotypeoption($registration_type).'</select></td>';  
                                        }
                                        
					$req .='<td><select name="time_slot_'.$j.'" id="time_slot_'.$j.'" required="" class="form-control">
                                        <option value="">Select sessions</option>'.$slot.'</select></td>  
                                        <td><button type="button" class="btn btn-success btn-xs" onclick="addToCart('.$event_id.',1,\''.$type.'\',\''.$next_delavery_date[$j].'\','.$j.');">Book-Ticket</button></td>
					</tr>';
			
			}			
		}		
	$ret_str = $req;
	echo $ret_str;
	exit();
}
elseif($action == 'getstateoption')
{
	$country_id = trim($_REQUEST['country_id']);
	$state_id = trim($_REQUEST['state_id']);
	if(isset($_REQUEST['type']))
	{
		$type = trim($_REQUEST['type']);
	}
	else
	{
		$type = '';	
	}
	
	if(isset($_REQUEST['multiple']))
	{
		$multiple = trim($_REQUEST['multiple']);
	}
	else
	{
		$multiple = '';	
	}
	
	if($multiple == '1')
	{
		$arr_country_id = explode(',',$country_id);
		$arr_state_id = explode(',',$state_id);
	}
	else
	{
		$arr_country_id = $country_id;
		$arr_state_id = $state_id;
	}
	
    
	$data = $obj->getStateOption($arr_country_id,$arr_state_id,$type,$multiple);
    echo $data;
}
elseif($action == 'getcityoption')
{
	$country_id = trim($_REQUEST['country_id']);
	$state_id = trim($_REQUEST['state_id']);
	$city_id = trim($_REQUEST['city_id']);
	if(isset($_REQUEST['type']))
	{
		$type = trim($_REQUEST['type']);
	}
	else
	{
		$type = '';	
	}
	
	if(isset($_REQUEST['multiple']))
	{
		$multiple = trim($_REQUEST['multiple']);
	}
	else
	{
		$multiple = '';	
	}
	
	if($multiple == '1')
	{
		$arr_country_id = explode(',',$country_id);
		$arr_state_id = explode(',',$state_id);
		$arr_city_id = explode(',',$city_id);
	}
	else
	{
		$arr_country_id = $country_id;
		$arr_state_id = $state_id;
		$arr_city_id = $city_id;
	}
	
    
	$data = $obj->getCityOption($arr_country_id,$arr_state_id,$arr_city_id,$type,$multiple);
    echo $data;
}
elseif($action == 'getareaoption')
{
	$country_id = trim($_REQUEST['country_id']);
	$state_id = trim($_REQUEST['state_id']);
	$city_id = trim($_REQUEST['city_id']);
	$area_id = trim($_REQUEST['area_id']);
	if(isset($_REQUEST['type']))
	{
		$type = trim($_REQUEST['type']);
	}
	else
	{
		$type = '';	
	}
	
	if(isset($_REQUEST['multiple']))
	{
		$multiple = trim($_REQUEST['multiple']);
	}
	else
	{
		$multiple = '';	
	}
	
	if($multiple == '1')
	{
		$arr_country_id = explode(',',$country_id);
		$arr_state_id = explode(',',$state_id);
		$arr_city_id = explode(',',$city_id);
		$arr_area_id = explode(',',$area_id);
	}
	else
	{
		$arr_country_id = $country_id;
		$arr_state_id = $state_id;
		$arr_city_id = $city_id;
		$arr_area_id = $area_id;
	}
	
    
	$data = $obj->getAreaOption($arr_country_id,$arr_state_id,$arr_city_id,$arr_area_id,$type,$multiple);
    echo $data;
}
elseif($action == 'getlocation')
{
    
    $response=array();
    $signup_city=$_REQUEST['city']!='' ? $_REQUEST['city'] : '';
    $city_id = $obj->getCityIdbyName($signup_city);
    
    if($city_id!='')
        {
            $response['place_option'] = $obj->getPlaceOptions($city_id);
            $response['error'] = 0;
        }
    echo json_encode(array($response));
    exit(0);    
  
}
else if($action =='getbescomment')
    {        
        $besname = $_REQUEST['bms_name'];
        $table = $_REQUEST['fetch_link'];
        $sub_cat3 = $_REQUEST['sub_cat3'];
        
        $tabl2 = $_REQUEST['fetch_link_2'];
        $sub_cat4 = $_REQUEST['sub_cat4'];
        
        $final_table = $table.','.$tabl2;
        $final_cat = $sub_cat3.','.$sub_cat4;
        
        $final_table = trim($final_table,',');
        $final_cat = trim($final_cat,',');
        
        $final_table = explode(',',$final_table);
        $final_cat = explode(',',$final_cat);
        
        
        
        $comment = $obj->getCommentByBesnameDesign($besname,$final_table,$final_cat);
       
//       echo '<pre>';
//       print_r($final_table);
//       echo '</pre>';
//       
//        echo '<pre>';
//       print_r($final_cat);
//       echo '</pre>';
       
       echo $comment;
       exit(0);
    }
    if($action =='changtheammdt')
    {        
        $theam_id = stripslashes($_REQUEST['theam_id']);
        $_SESSION['mdttheam_id'] = $theam_id;
        $response = array();
        list($image,$color_code) = $obj->getTheamDetailsMDT($theam_id);
        $output = $image.'::'.$color_code;
        $response['image'] = $image;
        $response['color_code'] = $color_code;
        $response['error'] = 0;
        echo json_encode(array($response));
        exit(0);    
    }
else if($action =='ChangeTheMusic')
    {   
        $obj2 = new frontclass2();   
        $music_id1 = $_REQUEST['music_id1'];
       
        $music = $obj2->getMusicNameByid($music_id1);
       
       echo $option.='<audio autoplay loop>
        <source src="uploads/'.$music.'" /> 
        <source src="uploads/'.$music.'" /> 
        </audio>';
       exit(0);
    }
else if($action =='ChangeTheAvatar')
    {      
        $obj2 = new frontclass2();   
        $avat_id = $_REQUEST['avat_id'];
       
        $image = $obj2->getAvatarNameByid($avat_id);
       
       echo $option.='<img src="uploads/'.stripslashes($image).'" height="50px;" width="50px;" title="My Today\'s Mascot">';
       exit(0);
    }
    
    else if($action =='getmydesignlifedata')
    {  
        
        $day_month_year = date("Y-m-d");
        $sub_cat_id = $_REQUEST['sub_cat_id']; 
        $get_design_data = $obj->GETDesignData($sub_cat_id,$day_month_year);
        $outputstr='';
//        echo '<pre>';
//        print_r($get_design_data);
//        echo '<pre>';
        //echo count($get_design_data);
        if(count($get_design_data)>0)
        {
        for($j=0;$j<count($get_design_data);$j++)
        {
        
//            echo $j;
//            echo '<br>';
        //$ref_num = $obj->GetRefNumer($sub_cat_id);
        $design_my_life_data = $obj->GetDesignMyLifeDatabyRef($get_design_data[$j]['ref_code']);
        
        $profile_category = $obj->GetProfilecatname($design_my_life_data['prof_cat_id']);
        $sub_cat_option = $obj->getSubCatOptions($design_my_life_data['prof_cat_id'],$design_my_life_data['sub_cat_id']);
        $narration = $design_my_life_data['narration'];

  
        $data_dropdown =  $obj->GETDATADROPDOWNMYDAYTODAYOPTION($design_my_life_data['data_category'],'127');
        
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
                                          $fetch_cat1 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat1_link'],$data_dropdown[0]['sub_cat1']);
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
                                          $fetch_cat2 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat2_link'],$data_dropdown[0]['sub_cat2']);
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
                                          $fetch_cat3 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat3_link'],$data_dropdown[0]['sub_cat3']);
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
                                          $fetch_cat4 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat4_link'],$data_dropdown[0]['sub_cat4']);
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
                                          $fetch_cat5 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat5_link'],$data_dropdown[0]['sub_cat5']);
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
                                          $fetch_cat6 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat6_link'],$data_dropdown[0]['sub_cat6']);
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
                                          $fetch_cat7 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat7_link'],$data_dropdown[0]['sub_cat7']);
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
                                          $fetch_cat8 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat8_link'],$data_dropdown[0]['sub_cat8']);
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
                                          $fetch_cat9 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat9_link'],$data_dropdown[0]['sub_cat9']);
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
                                          $fetch_cat10 = $obj->GetFecthDataDesign($data_dropdown[0]['canv_sub_cat10_link'],$data_dropdown[0]['sub_cat10']);
                                      }
                                   }
                                   
                                   $show_cat = explode(',', $show_cat);
                                   $show_cat = array_filter($show_cat);
                                   $final_array = array_merge($fetch_cat1,$fetch_cat2,$fetch_cat3,$fetch_cat4,$fetch_cat5,$fetch_cat6,$fetch_cat7,$fetch_cat8,$fetch_cat9,$fetch_cat10);                                   
                                   $final_dropdown = $obj->CreateDesignLifeDropdownEdit($show_cat,$final_array,$design_data['box_title']);
  
  
                                    $tr_days_of_month = 'none';
                                    $tr_single_date = 'none';
                                    $tr_date_range = 'none';
                                    $tr_month_date = 'none';
                                    $tr_days_of_week = 'none'; 
                                    
                                    //$outputstr='';
                                    
                                   $outputstr .='<div class="col-md-12" style="">
                                       <form name="design_life_data" id="design_life_data" method="post">
                            <div class="col-md-12">';
                           if($narration!='' && $design_my_life_data['narration_show'] == 1) {
                            $outputstr .='<br><br><span class="">'.$narration.'</span>
                             <br><br>'; 
                           } 
                           if($design_my_life_data['show_to_user'] == '1') {  
                             $outputstr .='<span>
                                <input type="text" '.$required.' name="title_id" id="title_id" placeholder="Make your choice" list="capitals" class="input-text-box dlist" style="width:300px;" />
                               <datalist id="capitals" class="dlist" style="">
                                    '.$final_dropdown.'  
                                </datalist>
                             </span>';
                            } else { 
                                $outputstr .='<span class="">'.$design_my_life_data['box_title'].'</span>';
                             }
                            $outputstr .='<br>
                            <br>
                            ';
                            if($design_my_life_data['quick_response_show'] == 1)
                            {
                               
                                $cat_cnt = 0;
                                $cat_total_cnt=1;
                                
                                $box_cnt = 0;
                                $box_total_cnt=1;
                                
                                $count = $design_my_life_data['box_count'];
                                $input_box_count = $design_my_life_data['input_box_count'];
                                $symtum_cat = $design_my_life_data['sub_cat2'];
                                $sub_cat2_show_fetch=$design_my_life_data['sub_cat2_show_fetch'];
                                $sub_cat2_link=$design_my_life_data['sub_cat2_link'];
                                
                                $data_dropdown = $obj->GetDesignMyLifeDrop($symtum_cat,$sub_cat2_show_fetch,$sub_cat2_link);
                            
                               
                            $outputstr .='<span><strong>'.$design_my_life_data['quick_response_heading'].'</strong></span>  
                            <br>
                            <span>
                                <input type="hidden" name="fetch_link" id="fetch_link" value="'.$design_my_life_data['sub_cat3_link'].'"/>
                                <input type="hidden" name="sub_cat3" id="sub_cat3" value="'.$design_my_life_data['sub_cat3'].'"/>
                                
                                <input type="hidden" name="fetch_link_2" id="fetch_link_2" value="'.$design_my_life_data['sub_cat4_link'].'"/>
                                <input type="hidden" name="sub_cat4" id="sub_cat4" value="'.$design_my_life_data['sub_cat4'].'"/>
                                <input type="hidden" name="ref_code" id="ref_code" value="'.$design_my_life_data['ref_code'].'"/>
                                <input type="hidden" name="icon_code" id="icon_code" value="'.$design_my_life_data['quick_tip_icon'].'"/>
                            </span>'; 
                            for($i=0;$i<=$cat_cnt;$i++) { 
                            $child = ($i == 0 ? 'first' : $i);
                            $outputstr .='
                            <div id="row_loc_'.$child.'">
                                <input type="hidden" name="cat_cnt" id="cat_cnt" value="'.$cat_cnt.'">
				<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="'.$cat_total_cnt.'">    
                            <span>
                               <input type="text" '.$required.' name="fav_cat_2[]" id="fav_cat_2_'.$i.'" placeholder="Select Your inputs" list="capitals_'.$i.'" class="input-text-box dlist" style="width:300px;" onchange="Display_Solution('.$i.')"/>
                               <datalist id="capitals_'.$i.'" class="dlist" style="">
                                    '.$data_dropdown.' 
                                </datalist>
                             </span>
                                <span>';
                                      
                                        if($i == 0)
                                        { 
                                                $outputstr .='<a href="javascript:void(0);" onclick="addMoreRowLocation();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>';
                                       	
                                        }
                                        else
                                        { 
                                                $outputstr .='<a href="javascript:void(0);" onclick="removeRowLocation('.$i.');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>';
                                        	
                                        }
                                        	
                                        $outputstr .='</span>
                                <br><br>
                                <span style="margin-left:100px;" id="comment_backend_'.$i.'"></span>
                                <br></div>';
                              
                            }
                             
                            }    
                            
                            if($design_my_life_data['input_box_show'] == 1)
                             {
                                $box_cnt = 0;
                                $box_total_cnt=1;
                                
                                for($i=0;$i<=$box_cnt;$i++) { 
                                 $child = ($i == 0 ? 'first' : $i);
                                $outputstr .='
                                <div id="row_inp_'.$child.'">
                                <input type="hidden" name="box_cnt" id="box_cnt" value="'.$box_cnt.'">
				<input type="hidden" name="box_total_cnt" id="box_total_cnt" value="'.$box_total_cnt.'">
                                <span>
                                   <input type="text" name="user_input[]" id="user_input_'.$i.'" placeholder="Type Your inputs" class="input-text-box " style="width:300px;" />';
                                     
                                        if($i == 0)
                                        { 
                                                $outputstr .='<a href="javascript:void(0);" onclick="addMoreRowLoc();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>';
                                          	
                                        }
                                        else
                                        { 
                                                $outputstr .='<a href="javascript:void(0);" onclick="removeRowLoc('.$i.');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>';
                                        	
                                        }
                                        	
                                    $outputstr .='</span><br><br></div>';
                                }
                            }
                            
                            
                            for($l=1;$l<=11;$l++)
                            {
                            
                            
                            if($design_my_life_data['image1_order_show'] == $l && $design_my_life_data['image_1_show'] == 1)
                            {
                            
                            $outputstr .='<span class="">';
                                if($design_my_life_data['image_type_1'] == 'Image') { 
                                $outputstr .='<img src="uploads/'.$design_my_life_data['image_1'].'" style="width:200px; height: 200px;">';
                               }
                               if($design_my_life_data['image_type_1'] == 'Video') {
                                
                                $outputstr .='<iframe width="200" height="200" src="https://www.youtube.com/embed/'.$design_my_life_data['video_link_1'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="false"></iframe>';
                                
                               }
                                $outputstr .='<br>
                                '.$design_my_life_data['image_credit_1'].'
                                -
                                '.$design_my_life_data['image_credit_url_1'].'
                            </span>
                            <br><br>';
                            
                            }
                            if($design_my_life_data['image2_order_show'] == $l  && $design_my_life_data['image_2_show'] == 1)
                            {
                             
                            $outputstr .='<span class="">';
                               if($design_my_life_data['image_type_2'] == 'Image') { 
                                $outputstr .='<img src="uploads/'.$design_my_life_data['image_2'].'" style="width:200px; height: 200px;">';
                                 } 
                                if($design_my_life_data['image_type_2'] == 'Video') {
                                
                                $outputstr .='<iframe width="200" height="200" src="https://www.youtube.com/embed/'.$design_my_life_data['video_link_2'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="false"></iframe>';
                                
                               } 
                                $outputstr .='<br>
                                '.$design_my_life_data['image_credit_2'].'
                               -
                                '.$design_my_life_data['image_credit_url_2'].'
                            </span>
                           <br><br>';
                            
                            }
                            if($design_my_life_data['user_date_order_show'] == $l  && $design_my_life_data['user_date_show'] == 1)
                            {
                               
                                 $outputstr .='<span class="">
                                     <!--<b>Date Selection:</b>-->
                                    <select name="listing_date_type" id="listing_date_type" class="input-text-box input-quarter-width" onchange="toggleDateSelectionType(\'listing_date_type\')"  title="'.$design_my_life_data['user_date_heading'].'">
                                        <option value="">Select Date Type</option>
                                        <option value="days_of_month">Days of Month</option>
                                        <option value="single_date">Single Date</option>
                                        <option value="date_range">Date Range</option>
                                        <option value="month_wise">Month Wise</option>
                                        <option value="days_of_week">Days of Week</option>

                                    </select>
                                 </span>
                            <span>
                                <table>
                                <tr id="tr_days_of_month" style="margin-top:10px; display:'.$tr_days_of_month.'">

                                        <td align="right" valign="top"><strong>&nbsp;</strong></td>

                                        <td align="center" valign="top"><strong>&nbsp;</strong></td>

                                        <td align="left">

                                            <select id="days_of_month" name="days_of_month[]" multiple="multiple" class="input-text-box input-half-width" style="margin-top:20px;">';

                                           

                                            for($i=1;$i<=31;$i++)

                                            { 

                                                $outputstr .='<option value="'.$i.'"'; 
                                                if (in_array($i, $arr_days_of_month)) { $outputstr .='selected="selected"'; } $outputstr .='>'.$i.'</option>';

                                           
                                            } 	

                                            $outputstr .='</select>&nbsp;*<br>

                                            You can choose more than one option by using the ctrl key.

                                        </td>

                                    </tr>
                                    
                                    <tr id="tr_single_date" style="margin-top:10px; display:'.$tr_single_date.'">

                                        <td align="right" valign="top"><strong>&nbsp;</strong></td>

                                        <td align="center" valign="top"><strong>&nbsp;</strong></td>

                                        <td align="left">

                                            <input name="single_date" id="single_date" type="text" value="'.$single_date.'" class="input-text-box input-full-width" style="margin-top:20px;" placeholder="Select Date" />

                                            <script>$("#single_date").datepicker({ minDate: 0 , dateFormat : "dd-mm-yy"}); </script>

                                        </td>

                                    </tr>

                                    <tr id="tr_date_range" style="margin-top:10px; display:'.$tr_date_range.'">

                                        <td align="right" valign="top"><strong>&nbsp;</strong></td>

                                        <td align="center" valign="top"><strong>&nbsp;</strong></td>

                                        <td align="left">

                                            <input name="start_date" id="start_date" type="text" value="'.$start_date.'" class="input-text-box input-half-width" style="margin-top:20px;" placeholder="Start Date"  /> - <input name="end_date" id="end_date" type="text" value="'.$end_date.'" class="input-text-box input-half-width" style="margin-top:20px;" placeholder="End Date" />

                                            <script>$("#start_date").datepicker({ minDate: 0 , dateFormat : "dd-mm-yy"});$("#end_date").datepicker({ minDate: 0 , dateFormat : "dd-mm-yy"}); </script>

                                        </td>

                                    </tr>

                                    <tr id="tr_days_of_week" style="margin-top:10px; display:'.$tr_days_of_week.'">

                                        <td align="right" valign="top"><strong>&nbsp;</strong></td>

                                        <td align="center" valign="top"><strong>&nbsp;</strong></td>

                                        <td align="left">

                                            <select id="days_of_week" name="days_of_week[]" multiple="multiple" class="input-text-box input-half-width" style="margin-top:20px;">

                                            '.$obj->getDayOfWeekOptionsMultiple($arr_days_of_week).'

                                            </select>&nbsp;*<br>

                                            You can choose more than one option by using the ctrl key.

                                        </td>

                                    </tr>

                                    <tr id="tr_month_date" style="margin-top:10px; display:'.$tr_month_date.'">

                                        <td align="right" valign="top"><strong>&nbsp;</strong></td>

                                        <td align="center" valign="top"><strong>&nbsp;</strong></td>

                                        <td align="left">

                                            <select id="months" name="months[]" multiple="multiple" class="input-text-box input-half-width" style="margin-top:20px;">

                                            '.$obj->getMonthsOptionsMultiple($arr_month).'	

                                            </select>&nbsp;*<br>

                                            You can choose more than one option by using the ctrl key.

                                        </td>

                                    </tr>
                                    </table>
                            </span>
                            <br><br>';
                             
                            }
                            if($design_my_life_data['time_order_show'] == $l  && $design_my_life_data['time_show'] == 1)
                            {
                              
                                $outputstr .='<select  class="input-text-box input-quarter-width" name="bes_time" id="bes_time" title="'.$design_my_life_data['time_heading'].'">
                                    <option value="">'.$design_my_life_data['time_heading'].'</option>
                                    '.$obj->getTimeOptionsNew('0','23',$bes_time ).'
                                </select>
                                <br><br>';
                             
                               
                            }
                            if($design_my_life_data['duration_order_show'] == $l  && $design_my_life_data['duration_show'] == 1)
                            {
                              
                                
                                $outputstr .='<input type="text" title="'.$design_my_life_data['duration_heading'].'" name="duration" id="duration" onKeyPress="return isNumberKey(event);" placeholder="'.$design_my_life_data['duration_heading'].'" class="input-text-box input-quarter-width" autocomplete="false">
                            <br><br>';
                            
                            }
                            if($design_my_life_data['location_order_show'] == $l && $design_my_life_data['location_show'] == 1)
                            {
                              
                            
                                $outputstr .='<select  class="input-text-box input-quarter-width" name="location" id="location" title="'.$design_my_life_data['location_heading'].'">
                                    <option value="">'.$design_my_life_data['location_heading'].'</option>
                                    '.$obj->getFavCategoryRamakant($design_my_life_data['location_fav_cat'],'').'
                                </select> 
                                <br><br>';
                             
                            }
                            if($design_my_life_data['like_dislike_order_show'] == $l && $design_my_life_data['User_view'] == 1)
                            {
                             
                                $outputstr .='<select  class="input-text-box input-quarter-width" name="User_view" id="User_view" title="'.$design_my_life_data['like_dislike_heading'].'">
                                    <option value="">'.$design_my_life_data['like_dislike_heading'].'</option>
                                    '.$obj->getFavCategoryRamakant($design_my_life_data['user_response_fav_cat'],'').'
                                </select>
                                <br><br>';
                            }
                            if($design_my_life_data['set_goals_order_show'] == $l && $design_my_life_data['User_Interaction'] == 1)
                            {
                                
                                    $outputstr .='<select  class="input-text-box input-quarter-width" name="User_Interaction" id="User_Interaction" title="'.$design_my_life_data['set_goals_heading'].'">
                                        <option value="">'.$design_my_life_data['set_goals_heading'].'</option>
                                        '.$obj->getFavCategoryRamakant($design_my_life_data['user_what_fav_cat'],'').'
                                    </select>
                                    <br><br>';
                            }
                            if($design_my_life_data['scale_order_show'] == $l && $design_my_life_data['scale_show'] == 1)
                            {
                                
                                    $outputstr .='<select  class="input-text-box input-quarter-width" name="scale" id="scale" title="'.$design_my_life_data['scale_heading'].'">
                                        <option value="">'.$design_my_life_data['scale_heading'].'</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                    <br><br>';
                                
                            }
                            if($design_my_life_data['reminder_order_show'] == $l && $design_my_life_data['alert_show'] == 1)
                            {
                               
                                    $outputstr .='<select class="input-text-box input-half-width" name="alert" id="alert" title="'.$design_my_life_data['reminder_heading'].'">
                                        <option value="">'.$design_my_life_data['reminder_heading'].'</option>
                                        '.$obj->getFavCategoryRamakant($design_my_life_data['alerts_fav_cat'],'').'
                                    </select>
                                    <br><br>';
                            }
                            if($design_my_life_data['comment_order_show'] == $l && $design_my_life_data['comment_show'] == 1)
                            {
                                $outputstr .='<textarea name="comment" title="'.$design_my_life_data['comments_heading'].'" id="comment" class="input-text-box input-half-width" autocomplete="false" placeholder="'.$design_my_life_data['comments_heading'].'" ></textarea>
                                    <br><br>';
                               $outputstr .='<script> $("#comment").Editor(); </script>';
                            }
                            
                            }
                            
                            if($design_my_life_data['user_upload_show'] == 1)
                            {
                                $outputstr .=' <a href="user_uploads.php?ref_code='.$ref_num.'&box_title='.$design_my_life_data['box_title'].'&sub_cat_id='.$sub_cat_id.'" class="active" target="_blank" title="We would like to hear your innovative suggestions."><span style="background: #007fff;color: #fff; border: 2px solid #4e4e4e; border-radius: 15px; height: 50px; padding: 5px;">Share your inputs</span></a>
                                <br><br>';
                               
                            }
                            
                            
                             $outputstr .='
                                <div style="text-align:center;">
                                <button type="submit" name="btn_submit" class="active" style="background-color:orange;">Save</button>
                                </div>
                                </form>
                                </div>';
        }           
      }     
      
    echo $outputstr;
    exit(0);
        
    }
else if($action =='getmodulewisekeywordsoptions')
    {        
        $page_id = $_REQUEST['page_id'];
        $user_id = $_SESSION['user_id'];
        $page_link = $obj->getPageLinkByid($page_id);
        $keyword_option = '';
        
        if($page_link == 'design-my-life.php')
        {
           $keyword_option = $obj->GETMYDESIGNKEWORD($user_id);
        }
        if($page_link == 'mycanvas.php')
        {
            $keyword_option = $obj->GETMYCANVASKEWORD($user_id);
        }
        if($page_link == 'my_day_today.php')
        {
            $keyword_option = $obj->GETMYDAYTODAYKEWORD($user_id);
        }
        
        
       echo $keyword_option;
       exit(0);
    }
elseif($action == 'showacceptinvitationpopup')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$puid = stripslashes($_REQUEST['puid']);
	$user_id = $_SESSION['user_id'];
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$output = $obj->showAcceptInvitationPopup($user_id,$ar_id,$puid);
		
	echo $output;
}
elseif($action == 'doacceptadviserinvitation')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$report_id = stripslashes($_REQUEST['report_id']);
	$permission_type = stripslashes($_REQUEST['permission_type']);
	$user_id = $_SESSION['user_id'];
	$puid = stripslashes($_REQUEST['puid']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$obj->doAcceptAdviserInvitation($ar_id,$report_id,$user_id,$puid,$permission_type);
		
	echo $output;
}
elseif($action == 'showdeactivateadviserinvitationpopup')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$puid = stripslashes($_REQUEST['puid']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$output = $obj->showDeactivateAdviserInvitationPopup($ar_id,$puid);
		
	echo $output;
}
elseif($action == 'deactivateadviserinvitation')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$user_id = $_SESSION['user_id'];
	$puid = stripslashes($_REQUEST['puid']);
	$status_reason = stripslashes($_REQUEST['status_reason']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$obj->deactivateAdviserInvitation($ar_id,$user_id,$puid,$status_reason);
		
	echo $output;
}
elseif($action == 'showactivateadviserinvitationpopup')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$puid = stripslashes($_REQUEST['puid']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$output = $obj->showActivateAdviserInvitationPopup($ar_id,$puid);
		
	echo $output;
}
elseif($action == 'activateadviserinvitation')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$user_id = $_SESSION['user_id'];
	$puid = stripslashes($_REQUEST['puid']);
	$status_reason = stripslashes($_REQUEST['status_reason']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$obj->activateAdviserInvitation($ar_id,$user_id,$puid,$status_reason);
		
	echo $output;
}
elseif($action == 'showadviserquerypopup')
{
	$parent_aq_id = stripslashes($_REQUEST['parent_aq_id']);
        $page_id = stripslashes($_REQUEST['page_id']);
	$output = '';
	if(!$obj->isLoggedIn())
	{
		$ref = base64_encode('my_wellness_guidence.php');
		$output = '<span class="Header_brown">You must login before add query.Please <a href="login.php?ref='.$ref.'">Click here</a> to Login.</span>';
	}
	else
	{
		$user_id = $_SESSION['user_id'];
		$user_upa_id = $obj->getupaid($page_id);
                $plan_flag = $obj->Checkifplanexist($user_upa_id);
                if($plan_flag){
                    if($obj->chkUserPlanFeaturePermission($user_id,$user_upa_id))
                    {
                            $output = $obj->showAdviserQueryPopup($user_id,$parent_aq_id);
                    }
                    else
                    {
                            $output = '<span class="Header_brown">'.$obj->getCommonSettingValue('3').'</span>';
                    }
                }
                else
                {
                  $output = $obj->showAdviserQueryPopup($user_id,$parent_aq_id);  
                }
		
		
	}
		
	echo $output;
}
elseif($action == 'addadviserquery')
{
	$parent_aq_id = stripslashes($_REQUEST['parent_aq_id']);
	$temp_pro_user_id = stripslashes($_REQUEST['temp_pro_user_id']);
	$temp_page_id = stripslashes($_REQUEST['temp_page_id']);
	$name = stripslashes($_REQUEST['name']);
	$email = stripslashes($_REQUEST['email']);
	$query = stripslashes($_REQUEST['query']);
	
	if($obj->isLoggedIn())
	{
		$user_id = $_SESSION['user_id'];
	}
	else
	{
		$user_id = '0';
	}
	
	$error = '0';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	//if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
	{
		$error = '1';
		$msg = 'Please enter valid email';
		$output = $error.'::'.$msg;
	}
	else
	{	
		$from_user = '1';
		if($obj->addAdviserQuery($parent_aq_id,$temp_page_id,$user_id,$name,$email,$temp_pro_user_id,$from_user,$query))
		{
			$error = '2';
			$msg = 'Your Query has been forwarded to your Adviser ('.$obj->getProUserFullNameById($temp_pro_user_id).')\'s Message Box for his/her Guidance to you';
			$output = $error.'::'.$msg;
		}
	}
	echo $output;
}
elseif($action == 'feedback_form')
{
  $output='';
    $output .='<form id="frm_feedback" name="frm_feedback" method="post" action="#" enctype="multipart/form-data">                    
                             <input type="hidden" name="main_page_id" id="main_page_id" value="<?php echo $main_page_id; ?>" />                    
                             <input type="hidden" name="hdn_p_id" id="hdn_p_id" value="" />                    
                                 '.$temp_page_id = $obj->getTemppageId($page_id).'                  
                             <table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">                        
                                 <tr>                            
                                     <td width="60%" height="40" align="left" valign="top">Subject:</td>                            
                                     <td width="40%" height="40" align="left" valign="top">                                
                                         <select id="temp_page_id" name="temp_page_id">                                    
                                             '.$obj->getFeeadBackPages($temp_page_id).'                               
                                         </select>                            
                                     </td>                        
                                 </tr>';                       
                                     if($obj->isLoggedIn()) { 
                                         $user_id = $_SESSION['user_id'];                            
                                         $name = $obj->getUserFullNameById($user_id);                            
                                         $email = $obj->getUserEmailById($user_id);                            
                                         $readonly = ' readonly ';                        
                                         
                                     } else 
                                         { 
                                         $readonly = ''; 
                                         
                                         }                        
                                 $output .='<tr> 
                                     <td width="60%" height="40" align="left" valign="top">Name:</td>                            
                                     <td width="40%" height="40" align="left" valign="top">                                
                                         <input type="text" id="name" name="name" '.$readonly.' value="'.$name.'"/>                            
                                     </td>                        
                                 </tr>                        
                                 <tr>                            
                                     <td width="60%" height="40" align="left" valign="top">Email:</td>                            
                                     <td width="40%" height="40" align="left" valign="top">                                
                                         <input type="text" id="email" name="email" '.$readonly.' value="'.$email.'"/>                                                                         
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
                                     <td width="40%" height="40" align="left" valign="middle">                                
                                         <input name="submit" type="button" class="button" id="submit" value="Submit"  onclick="GetFeedback()"/>                            
                                     </td>                        
                                 </tr>                       
                             </table>                
                         </form>';     
    echo $output;
    
}
    

