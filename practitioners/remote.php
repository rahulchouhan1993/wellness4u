<?php
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };
@set_time_limit(1000000);
include("../config.php" );
include_once('../class.phpmailer.php');

$action = stripslashes($_REQUEST['action']);
if($action == 'getusertriggercriteriaoptions')
{
	$uid = stripslashes($_REQUEST['uid']);
	$trigger_criteria = '';
	$output = '';
	
        $output .= '<select name="trigger_criteria" id="trigger_criteria" style="width:200px;">';
        $output .= '<option value="" selected="selected" >All</option>';
	$output .= getTriggerCriteriaOptions($uid,$trigger_criteria);
	$output .= '</select>';	
	echo $output;
}
elseif($action == 'showdeactivateuserinvitationpopup')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$puid = stripslashes($_REQUEST['puid']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$output = showDeactivateUserInvitationPopup($ar_id,$puid);
		
	echo $output;
}
elseif($action == 'showactivateuserinvitationpopup')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$puid = stripslashes($_REQUEST['puid']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$output = showActivateUserInvitationPopup($ar_id,$puid);
		
	echo $output;
}
elseif($action == 'showdeclineuserinvitationpopup')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$puid = stripslashes($_REQUEST['puid']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$output = showDeclineUserInvitationPopup($ar_id,$puid);
		
	echo $output;
}
elseif($action == 'deactivateuserinvitation')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$user_id = $_SESSION['pro_user_id'];
	$puid = stripslashes($_REQUEST['puid']);
	$status_reason = stripslashes($_REQUEST['status_reason']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	deactivateUserInvitation($ar_id,$user_id,$puid,$status_reason);
		
	echo $output;
}
elseif($action == 'activateuserinvitation')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$user_id = $_SESSION['pro_user_id'];
	$puid = stripslashes($_REQUEST['puid']);
	$status_reason = stripslashes($_REQUEST['status_reason']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	activateUserInvitation($ar_id,$user_id,$puid,$status_reason);
		
	echo $output;
}
elseif($action == 'doacceptuserinvitation')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$user_id = $_SESSION['pro_user_id'];
	$puid = stripslashes($_REQUEST['puid']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	doAcceptUserInvitation($ar_id,$user_id,$puid);
		
	echo $output;
}
elseif($action == 'declineuserinvitation')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$user_id = $_SESSION['user_id'];
	$puid = stripslashes($_REQUEST['puid']);
        $status_reason = stripslashes($_REQUEST['status_reason']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	declineUserInvitation($ar_id,$user_id,$puid,$status_reason);
		
	echo $output;
}
elseif($action == 'getuserquerypageoptions')
{
	$uid = stripslashes($_REQUEST['uid']);
	$puid = stripslashes($_REQUEST['puid']);
	$readonly = stripslashes($_REQUEST['valreadonly']);
	$pgidval = stripslashes($_REQUEST['pgidval']);
	
	$temp_page_id = '';
	$ret_str = '';
	$ret_str .='<select id="'.$pgidval.'" name="'.$pgidval.'" '.$readonly.' style="width:150px;">';
	if($pgidval == 'temp_page_id')
	{
		$ret_str .='<option value="">Select Reference</option>';
                $show_all = '0';
	}
	else
	{
		$ret_str .='<option value="">All Reference</option>';
                if($uid == '')
                {
                    $show_all = '1';
                }
                else
                {
                    $show_all = '0';
                }
	}		
	$ret_str .= getUserQueryPageOptions($temp_page_id,$uid,$puid,$show_all);
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'viewadviserplans')
{
	$apct_id = stripslashes($_REQUEST['apct_id']);
	$pro_user_id = $_SESSION['pro_user_id'];
	$output = viewAdviserPlans($pro_user_id,$apct_id);
	echo $output;
}
elseif($action == 'sendadviserplanrequest')
{
	$ap_id = stripslashes($_REQUEST['ap_id']);
	$error = '0';
	if(isLoggedInPro())
	{
		$pro_user_id = $_SESSION['pro_user_id'];
		
		if(chkIfAdviserPlanRequestAlreadySent($pro_user_id))
		{
			$error = '3';
			$msg = 'You have already sent request.';
			$output = $msg;
		}
		elseif(sendAdviserPlanRequest($pro_user_id,$ap_id))
		{
			$error = '2';
			$msg = 'Your Request has been sent';
			$output = $msg;
		}
		else
		{
			$error = '1';
			$msg = 'somthing went wrong';
			$output = $msg;
		}
	}
	else
	{
		$error = '1';
		$msg = 'somthing went wrong!';
		$output = $msg;
	}
	echo $output;
}
elseif($action == 'getuseracceptedreportsoptions')
{
	$uid = stripslashes($_REQUEST['uid']);
	$puid = stripslashes($_REQUEST['puid']);
	$report_id = '';
	$ret_str = '';
	$ret_str .='<select name="report_id" id="report_id" style="width:150px;">';
	$ret_str .='<option value="">Select Report</option>';
	$ret_str .= getUserAcceptedReportsOptions($uid,$puid,$report_id);
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'getuseracceptedreportsoptionsnew')
{
	$uid = stripslashes($_REQUEST['uid']);
	$puid = stripslashes($_REQUEST['puid']);
	$report_id = '';
	$ret_str = '';
	$ret_str .='<select name="report_module" id="report_module" style="width:200px;" onchange="getUserAcceptedReportsSetOptions('.$puid.');toggleScaleShow(); getModuleWiseKeywordsOptions(); getModuleWiseCriteriaOptions(); resetReportForm();">';
	$ret_str .='<option value="">Select Report</option>';
	$ret_str .= getUserAcceptedReportsOptionsNew($uid,$puid,$report_id);
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'getuseracceptedreportssetoptions')
{
	$uid = stripslashes($_REQUEST['uid']);
	$puid = stripslashes($_REQUEST['puid']);
        $report_module = stripslashes($_REQUEST['report_module']);
	$user_set_id = '';
	$ret_str = '';
	$ret_str .='<select name="user_set_id" id="user_set_id" style="width:200px;" onchange="getModuleWiseKeywordsOptions(); getModuleWiseCriteriaOptions();">';
	$ret_str .='<option value="">Select Set</option>';
	$ret_str .= getUserAcceptedReportsSetOptions($uid,$puid,$report_module,$user_set_id);
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'getmodulewisekeywordsoptions')
{
	$output = '';
	
	$report_module = stripslashes($_REQUEST['report_module']);
        $uid = stripslashes($_REQUEST['uid']);
        $user_set_id = stripslashes($_REQUEST['user_set_id']);
        $puid = $_SESSION['pro_user_id'];
        $module_keyword = '';
        
        if($user_set_id == '1')
        {
            $temp_permission_type = '';
            $temp_pro_user_id = '';
        }
        elseif($user_set_id == '2')
        {
            $temp_permission_type = '0';
            $temp_pro_user_id = '0';
        }
        elseif($user_set_id == '3')
        {
            $temp_permission_type = '1';
            $temp_pro_user_id = $puid;
        }
        else 
        {
            $temp_permission_type = '';
            $temp_pro_user_id = '';
        }
        
        $output .= '<select name="module_keyword" id="module_keyword" style="width:200px;">
                        <option value="">All</option>';
        if($report_module != '')
        {
            $output .= getModuleWiseKeywordsOptions($uid,$report_module,$temp_pro_user_id,$module_keyword);
        }    
        $output .= '</select>';
        
        echo $output;
}
elseif($action == 'getmodulewisecriteriaoptions')
{
	$output = '';
	
	$report_module = stripslashes($_REQUEST['report_module']);
        $user_set_id = stripslashes($_REQUEST['user_set_id']);
        $user_id = $_SESSION['user_id'];
        $module_criteria = '';
        
        $output .= '<select name="module_criteria" id="module_criteria" style="width:200px;" onchange="getModuleWiseCriteriaScaleOptions();getModuleWiseCriteriaScaleValues();toggleCriteriaScaleShow();">
                        <option value="">All</option>';
        if($report_module != '')
        {
            $output .= getModuleWiseCriteriaOptions($user_id,$report_module,$user_set_id,$module_criteria);
        }    
        $output .= '</select>';
        
        echo $output;
}
elseif($action == 'getmodulewisecriteriascaleoptions')
{
	$output = '';
	
	$report_module = stripslashes($_REQUEST['report_module']);
        $user_set_id = stripslashes($_REQUEST['user_set_id']);
        $user_id = stripslashes($_REQUEST['uid']);
        $module_criteria = stripslashes($_REQUEST['module_criteria']);
        $criteria_scale_range = '';
        
        $output .= '<select name="criteria_scale_range" id="criteria_scale_range" style="width:200px;" onchange="getModuleWiseCriteriaScaleValues();toggleScaleRangeType(\'criteria_scale_range\',\'div_start_criteria_scale_value\',\'div_end_criteria_scale_value\');">
                        <option value="">All</option>';
        if($module_criteria != '')
        {
            $output .= getModuleWiseCriteriaScaleOptions($user_id,$report_module,$user_set_id,$module_criteria,$criteria_scale_range);
        }    
        $output .= '</select>';
        
        echo $output;
}
elseif($action == 'getmodulewisecriteriascalevalues')
{
	$output = '';
	
	$report_module = stripslashes($_REQUEST['report_module']);
        $user_set_id = stripslashes($_REQUEST['user_set_id']);
        $module_criteria = stripslashes($_REQUEST['module_criteria']);
        $criteria_scale_range = stripslashes($_REQUEST['criteria_scale_range']);
        $user_id = stripslashes($_REQUEST['uid']);
        $start_criteria_scale_value = '';
        $end_criteria_scale_value = '';
               
        $output = getModuleWiseCriteriaScaleValues($user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value);
        
        echo $output;
}
elseif($action == 'selectpopuplocation')
{
	$country_id = stripslashes($_REQUEST['country_id']);
	$state_id = stripslashes($_REQUEST['state_id']);
	$city_id = stripslashes($_REQUEST['city_id']);
	$place_id = stripslashes($_REQUEST['place_id']);
	$idval = stripslashes($_REQUEST['idval']);
	$output = '';
	
	$country_name = getCountryName($country_id);
	$state_name = getStateName($state_id);
	$city_name = getCityName($city_id);
	$place_name = getPlaceName($place_id);
	
	$output = $country_name.' / '.$state_name.' / '.$city_name.' / '.$place_name;
		
	echo $output;
}
elseif($action == 'showlocationpopup')
{
	$country_id = stripslashes($_REQUEST['country_id']);
	$state_id = stripslashes($_REQUEST['state_id']);
	$city_id = stripslashes($_REQUEST['city_id']);
	$place_id = stripslashes($_REQUEST['place_id']);
	$idval = stripslashes($_REQUEST['idval']);
	$output = '';
	$output = showLocationPopup($country_id,$state_id,$city_id,$place_id,$idval);
		
	echo $output;
}
elseif($action == 'togglereadunreadquery')
{
	$tgaction = stripslashes($_REQUEST['tgaction']);
	$aq_id = stripslashes($_REQUEST['idval']);
	$pro_user_id = $_SESSION['pro_user_id'];
	
	if($tgaction == 'read')
	{
		setAdviserQueryRead($aq_id,$pro_user_id,'1');
	}
	elseif($tgaction == 'unread')
	{
		setAdviserQueryRead($aq_id,$pro_user_id,'0');
	}	

	echo $output;
}
elseif($action == 'replyuserquery')
{
	$parent_aq_id = stripslashes($_REQUEST['parent_aq_id']);
	$temp_user_id = stripslashes($_REQUEST['temp_user_id']);
	$temp_page_id = stripslashes($_REQUEST['temp_page_id']);
	$name = stripslashes($_REQUEST['name']);
	$email = stripslashes($_REQUEST['email']);
	$query = stripslashes($_REQUEST['query']);
	
	$error = '0';
	if(isLoggedInPro())
	{
		$pro_user_id = $_SESSION['pro_user_id'];
		$from_user = '0';
		if(addAdviserQuery($parent_aq_id,$temp_page_id,$temp_user_id,$name,$email,$pro_user_id,$from_user,$query))
		{
			$error = '2';
			$msg = 'Thank You For Your Query';
			$msg = 'Your Guidance has been forwarded to your Consult ('.getUserFullNameById($temp_user_id).')\'s Message Box.';
			$output = $error.'::'.$msg;
		}
		else
		{
			$error = '1';
			$msg = 'somthing went wrong';
			$output = $error.'::'.$msg;
		}
	}
	else
	{
		$error = '1';
		$msg = 'somthing went wrong!';
		$output = $error.'::'.$msg;
	}
	
	
	
	echo $output;
}
elseif($action == 'showuserquerypopup')
{
	$parent_aq_id = stripslashes($_REQUEST['parent_aq_id']);
	$output = '';
	if(!isLoggedInPro())
	{
		$ref = base64_encode('practitioners/my_users_queries.php');
		$output = '<span class="Header_brown">You must login before add query.Please <a href="'.SITE_URL.'/prof_login.php?ref='.$ref.'">Click here</a> to Login.</span>';
	}
	else
	{
		$pro_user_id = $_SESSION['pro_user_id'];
		$output = showUserQueryPopup($pro_user_id,$parent_aq_id);
	}
		
	echo $output;
}
elseif($action == 'getstateoptionsmulti')
{
	$country_id = stripslashes($_REQUEST['country_id']);
	
	$ret_str = '';
	$ret_str .='<select multiple="multiple" name="state_id[]" id="state_id" onchange="getCityOptionsMulti();" style="width:200px;">';
	$ret_str .='<option value="" selected>All States</option>';
	$arr_state_id = array();
	$ret_str .= getStateOptionsMulti($country_id,$arr_state_id);
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'getcityoptionsmulti')
{
	$country_id = stripslashes($_REQUEST['country_id']);
	$state_id = stripslashes($_REQUEST['state_id']);
	$state_id = substr($state_id,0,-1);
	
	$ret_str = '';
	$ret_str .='<select multiple="multiple" name="city_id[]" id="city_id" onchange="getPlaceOptionsMulti();" style="width:200px;">';
	$ret_str .='<option value="" selected>All Cities</option>';
	//if($state_id != '')
	//{
		$arr_state_id = explode(',',$state_id);
		$arr_city_id = array();
		$ret_str .= getCityOptionsMulti($country_id,$arr_state_id,$arr_city_id);
	//}	
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'getplaceoptionsmulti')
{
	$country_id = stripslashes($_REQUEST['country_id']);
	$state_id = stripslashes($_REQUEST['state_id']);
	$state_id = substr($state_id,0,-1);
	$city_id = stripslashes($_REQUEST['city_id']);
	$city_id = substr($city_id,0,-1);
	
	$ret_str = '';
	$ret_str .='<select multiple="multiple" name="place_id[]" id="place_id" style="width:200px;">';
	$ret_str .='<option value="" selected>All Places</option>';
	//if($city_id != '')
	//{
		$arr_state_id = explode(',',$state_id);
		$arr_city_id = explode(',',$city_id);
		$arr_place_id = array();
		$ret_str .= getPlaceOptionsMulti($country_id,$arr_state_id,$arr_city_id,$arr_place_id);
	//}	
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'viewusersselectionpopup')
{
	$output = '';
	
	$practitioner_id = $_SESSION['pro_user_id'];
	$str_user_id = substr(stripslashes($_REQUEST['str_user_id']),0,-1);
	$arr_user_id = explode(',',$str_user_id);
		
	$output = viewUsersSelectionPopup($practitioner_id,$arr_user_id);
		
	echo $output;
}
elseif($action == 'getstateoptions')
{
	$country_id = stripslashes($_REQUEST['country_id']);
	$state_id = stripslashes($_REQUEST['state_id']);
	$ret_str = '';
	$ret_str .='<select name="state_id" id="state_id" onchange="getCityOptions(\'\');">';
	$ret_str .='<option value="">Select State</option>';
	if($country_id != '')
	{
		$ret_str .= getStateOptions($country_id,$state_id);
	}	
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'getstateoptionspopup')
{
	$country_id = stripslashes($_REQUEST['country_id']);
	$state_id = stripslashes($_REQUEST['state_id']);
	$ret_str = '';
	$ret_str .='<select name="popup_state_id" id="popup_state_id" onchange="getCityOptionsPopup(\'\');" style="width:200px;">';
	$ret_str .='<option value="">Select State</option>';
	if($country_id != '')
	{
		$ret_str .= getStateOptions($country_id,$state_id);
	}	
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'getdestinationoptions')
{
	$country_id = stripslashes($_REQUEST['country_id']);
	$destination_id = stripslashes($_REQUEST['destination_id']);
	$ret_str = '';
	$ret_str .='<select name="destination_id" id="destination_id" style="width:200px;">';
	$ret_str .='<option value="">Select Destination</option>';
	if($country_id != '')
	{
		$ret_str .= getDestinationOptions($destination_id,$country_id);
	}	
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'viewentriesdetailslist')
{
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$start_date = stripslashes($_REQUEST['start_date']);
	$end_date = stripslashes($_REQUEST['end_date']);
	$reward_module_id = stripslashes($_REQUEST['reward_module_id']);
	
	$user_id = $_SESSION['user_id'];
	//$end_date = date('Y-m-t',strtotime($start_date));
	$output = viewEntriesDetailsList($user_id,$start_date,$end_date,$reward_module_id);
		
	echo $output;
}
elseif($action == 'showrewardcatlog')
{
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$output = showRewardCatlog();
		
	echo $output;
}
elseif($action == 'search_myfavlist')
{
	$error = '0';
	$err_msg = '';
	$output = '';
	$pg_id = stripslashes($_REQUEST['pg_id']);
	$start_date = stripslashes($_REQUEST['start_date']);
	$end_date = stripslashes($_REQUEST['end_date']);
	$ufs_cat_id = stripslashes($_REQUEST['ufs_cat_id']);

	if($start_date == '' || $end_date == '')
	{
		$error = '1';
		$err_msg = 'Please select page or date';
	}
	else
	{
		$user_id = $_SESSION['user_id'];
		$output = search_myfavlist($user_id,$pg_id,$start_date,$end_date,$ufs_cat_id);
	}	
	echo $test.'::'.$error.'::'.$err_msg.'::'.$output;
}
elseif($action == 'delete_myfavitem')
{
	$ufs_id = stripslashes($_REQUEST['ufs_id']);
	$output = Delete_MyFavItem($ufs_id);
	echo $output;
}
elseif($action == 'makenoteforfavlist')
{
	$ufs_id = stripslashes($_REQUEST['ufs_id']);
	$page_id = stripslashes($_REQUEST['page_id']);
	$output = Make_Note_FavList($ufs_id,$page_id);
	echo $output;
}
elseif($action == 'save_note_favlist')
{
	$ufs_id = stripslashes($_REQUEST['ufs_id']);
	$ufs_note = stripslashes($_REQUEST['note']);
	$ufs_cat_id = stripslashes($_REQUEST['ufs_cat_id']);
	$ufs_priority = stripslashes($_REQUEST['ufs_priority']);
	if(Save_Note_FavList($ufs_id,$ufs_note,$ufs_cat_id,$ufs_priority))
	{
		$output = '1';
	}
	else
	{
		$output = '0';
	}	
	echo $output;
}
elseif($action == 'addscrollingcontenttofav')
{
	$page_id = stripslashes($_REQUEST['page_id']);
	$str_sc_id = stripslashes($_REQUEST['str_sc_id']);
	
	if(!isLoggedIn())
	{
		$err_msg = 'To add as fav please do login first.';
	}
	else
	{
		$user_id = $_SESSION['user_id'];
		
		if(addScrollingContentToFav($user_id,$page_id,$str_sc_id))
		{
			$err_msg = 'Options added to fav succussfully';
		}	
		else
		{
			$err_msg = 'Somthing went wrong.Please try again later.';
		}
	}	
	$ret_str = $test.'::::'.$err_msg;
	echo $ret_str;
}
elseif($action == 'getmealmeasure')
{

	$meal_id = stripslashes($_REQUEST['meal_id']);

	$ret_str = '';

	

	$meal_measure = getMealMeasure($meal_id);

	$ret_str = $meal_measure."::<strong>".$meal_measure."<strong>";

	echo $ret_str;

}

elseif($action == 'display_banner')

{

	$banner_id = stripslashes($_REQUEST['banner_id']);

	$output = get_BoxSelectedItemCode($banner_id);

	echo $output;

}

elseif($action == 'gettitlecomments')

{

	$select_title = stripslashes($_REQUEST['select_title']);

	$short_narration = stripslashes($_REQUEST['short_narration']);

	$output = GetCommentCode($select_title,$short_narration);

	echo $output;

}

elseif($action == 'library_feedback')

{

	$page_id = stripslashes($_REQUEST['page_id']);

	$output = Library_Feedback($page_id);

	echo $output;

}

elseif($action == 'makenote')

{

	$library_id = stripslashes($_REQUEST['library_id']);

	$page_id = stripslashes($_REQUEST['page_id']);

	$output = Make_Note($library_id,$page_id);

	echo $output;

}

elseif($action == 'save_note')

{

	$library_id = stripslashes($_REQUEST['library_id']);

	$note = stripslashes($_REQUEST['note']);

	$output = Save_Note_Details($library_id,$note);

	echo $output;

}

elseif($action == 'delete_librarypdf')

{

	$library_id = stripslashes($_REQUEST['library_id']);

	$output = Delete_library($library_id);

	echo $output;

}

elseif($action == 'pdflibrary')

{

	if(!isLoggedIn())

		{

			$error = '1';

		}

	else

		{  

		   	$error = '0';

			$user_id = $_SESSION['user_id'];

			$page_id = stripslashes($_REQUEST['page_id']);

			$values = stripslashes($_REQUEST['values']);

			$output = PDF_Library($page_id,$values,$user_id);

		}

	echo $output.'::'.$error;

}

elseif($action == 'search_library')

{

	$error = '0';

	$page_id = stripslashes($_REQUEST['page_id']);

	$start_day = stripslashes($_REQUEST['day']);

	$start_month = stripslashes($_REQUEST['month']);

	$start_year = stripslashes($_REQUEST['year']);

	

	if($page_id == '' && $start_day == '' && $start_month == '' && $start_year == '')

	{

		$error = '1';

		$err_msg = 'Please select page or date';

	}

	else

	{

		if($page_id != '')

		{

			$flag_page = 1;

		}

		else

		{

			$flag_page = 0;

		}

		

		

		

		if( ($start_day == '') && ($start_month == '') && ($start_year == '') )

		{

			$flag_date = 1;

		}

		else

		{

			$flag_date = 0;

		}

		

		if($flag_page == 0 && $flag_date == 1 )

		{

			if($page_id == '')

			{

				$error = '1';

				$err_msg = 'Please select page';

			}

		}

		

		if($flag_date == 0)

		{

			if( ($start_day == '') || ($start_month == '') || ($start_year == '') )

				{

					$error = '1';

					$err_msg = 'Please select Valid date';

				}

				elseif(!checkdate($start_month,$start_day,$start_year))

				{

					if(!$error)

					{

						$error = '1';

						$err_msg = 'Please select valid start date';

					}

					else

					{

						$err_msg .= '<br>Please select valid start date';

					}	

				}

				elseif(mktime(0,0,0,$start_month,$start_day,$start_year) > time())

				{

					if(!$error)

					{

						$error = '1';

						$err_msg = 'Please select today or previous day for start date';

					}

					else

					{

						$err_msg .= '<br>Please select today or previous day for start date';

					}	

				}

				else

				{

					$start_date = $start_year.'-'.$start_month.'-'.$start_day;

				}

		}

		 

		$user_id = $_SESSION['user_id'];

		$output = search_library($user_id,$page_id,$start_date);	

	}	

	//echo $start_date;

	

	echo $error.'::'.$err_msg.'::'.$output;

}

elseif($action == 'getfeedback')

{

	$page_id = stripslashes($_REQUEST['page_id']);

	$name = stripslashes($_REQUEST['name']);

	$email = stripslashes($_REQUEST['email']);

	$feedback = stripslashes($_REQUEST['feedback']);

	$parent_id = stripslashes($_REQUEST['parent_id']);

	

		if(isLoggedIn())

			{

				$user_id = $_SESSION['user_id'];

			}

			else

			{

				$user_id = '0';

			}

		

	$error = '0';

	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))

	{

		$error = '1';

		$msg = 'Please enter valid email';

		$output = $error.'::'.$msg;

	}

	else

	{	

		if(InsertFeedback($parent_id,$page_id,$name,$email,$feedback,$user_id))

		{

			$error = '2';

			$msg = 'Thank You For Your Feedback/Suggestion';

			 $output = $error.'::'.$msg;

		}

		

	}

	echo $output;

}

/*elseif($action == 'getnarrationcomments')

{

	$select_title = stripslashes($_REQUEST['select_title']);

	$short_narration = stripslashes($_REQUEST['short_narration']);

	$output = GetCommentCode($select_title,$short_narration);

	echo $output;

}*/

elseif($action == 'postcomment')

{

	$comment_box = stripslashes($_REQUEST['comment_box']);

	$select_title = stripslashes($_REQUEST['select_title']);

	$short_narration = stripslashes($_REQUEST['short_narration']);

	$error = false;

	$parent_comment_id = '0';

	$code = '';

	$comment_type = 'MindJumble';

	if(isLoggedIn())

	{

		$user_id = $_SESSION['user_id'];

		$output = PostComment($comment_box,$user_id,$parent_comment_id,$comment_type,$select_title,$short_narration);

		$code = GetCommentCode($select_title,$short_narration);

	}else

	{

		$error = true;

		$_SESSION['temp_comment'] = $comment_box;

		$_SESSION['temp_select_title'] = $select_title;

		$_SESSION['temp_short_narration'] = $short_narration;

		$_SESSION['temp_parent_commnet_id'] = $parent_comment_id;

		$_SESSION['comment_type'] = $comment_type;

		$code = base64_encode('remote.php?action=postcommentafterlogin');

	}

	$ret_str = $error."::".$code;

	

	echo $ret_str;

}

elseif($action == 'postcommentafterlogin')

{

	$code = '';

	$error = false;

	$comment_box = $_SESSION['temp_comment'];

	$select_title = $_SESSION['temp_select_title'];

	$short_narration = $_SESSION['temp_short_narration'];

	$parent_comment_id = $_SESSION['temp_parent_commnet_id'];

	$comment_type = $_SESSION['comment_type'];

	

	if(isLoggedIn())

	{

		$user_id = $_SESSION['user_id'];

		$output = PostComment($comment_box,$user_id,$parent_comment_id,$comment_type,$select_title,$short_narration);

		

	}

		header("Location: mindjumble.php");

		exit(0);

}

elseif($action == 'display_angervent_banner')

{

	$banner_id = stripslashes($_REQUEST['banner_id']);

	$output = get_AngerventBoxCode($banner_id);

	echo $output;

}

elseif($action == 'getallpdf')

{

	$select_title = stripslashes($_REQUEST['select_title']);

	$short_narration = stripslashes($_REQUEST['short_narration']);

	$output = get_allpdfcode($select_title,$short_narration);

	echo $output;

}

elseif($action == 'display_mindjumble_banner')

{

	$banner_id = stripslashes($_REQUEST['banner_id']);

	$output = get_MindJumbleBoxCode($banner_id);

	echo $output;

}

elseif($action == 'changtheam')

{

	$theam_id = stripslashes($_REQUEST['theam_id']);

	$_SESSION['theam_id'] = $theam_id;

	

	list($image,$color_code) = getTheamDetails($theam_id);

	$output = $image.'::'.$color_code;

	echo $output;

}

elseif($action == 'getonkeyupbanner')

{

	$select_title = stripslashes($_REQUEST['select_title']);

	$output = getOnKeyUpBanner($select_title);

	echo $output;

}

elseif($action == 'onchangegetshortnarration')

{

	$short_narration = stripslashes($_REQUEST['short_narration']);

	$select_title = stripslashes($_REQUEST['select_title']);

	$output = OnChangeGetShortNarration($short_narration,$select_title);

	echo $output;

}
elseif($action == 'getshortnarration')
{
	$select_title = stripslashes($_REQUEST['select_title']);
	//echo $select_title;
	$short_narration = stripslashes($_REQUEST['short_narration']);
	$ret_str = '';
	$ret_str .= '<select name="short_narration" id="short_narration" onchange="OnChangeGetShortNarration(); getAllPDF(); getTitleComments();">';
	$ret_str .='<option value="">Select Narration</option>';
	if($select_title != '')
	{
		$ret_str .= getShortNarration($select_title,$short_narration);
	}	
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'getcityoptions')
{
	$state_id = stripslashes($_REQUEST['state_id']);
	$city_id = stripslashes($_REQUEST['city_id']);
	$ret_str = '';
	$ret_str .='<select name="city_id" id="city_id" onchange="getPlaceOptions(\'\');">';
	$ret_str .='<option value="">Select City</option>';
	if($state_id != '')
	{
		$ret_str .= getCityOptions($state_id,$city_id);
	}	
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'getcityoptionspopup')
{
	$state_id = stripslashes($_REQUEST['state_id']);
	$city_id = stripslashes($_REQUEST['city_id']);
	$ret_str = '';
	$ret_str .='<select name="popup_city_id" id="popup_city_id" onchange="getPlaceOptionsPopup(\'\');" style="width:200px;">';
	$ret_str .='<option value="">Select City</option>';
	if($state_id != '')
	{
		$ret_str .= getCityOptions($state_id,$city_id);
	}	
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'getplaceoptions')
{
	$state_id = stripslashes($_REQUEST['state_id']);
	$city_id = stripslashes($_REQUEST['city_id']);
	$place_id = stripslashes($_REQUEST['place_id']);
	$ret_str = '';
	$ret_str .='<select name="place_id" id="place_id">';
	$ret_str .='<option value="">Select Place</option>';
	if( ($state_id == '') || ($city_id == '') )
	{
	}
	else
	{
		$ret_str .= getPlaceOptions($state_id,$city_id,$place_id);
	}	
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'getplaceoptionspopup')
{
	$state_id = stripslashes($_REQUEST['state_id']);
	$city_id = stripslashes($_REQUEST['city_id']);
	$place_id = stripslashes($_REQUEST['place_id']);
	$ret_str = '';
	$ret_str .='<select name="popup_place_id" id="popup_place_id" style="width:200px;">';
	$ret_str .='<option value="">Select Place</option>';
	if( ($state_id == '') || ($city_id == '') )
	{
	}
	else
	{
		$ret_str .= getPlaceOptions($state_id,$city_id,$place_id);
	}	
	$ret_str .='</select>';
	echo $ret_str;
}
?>