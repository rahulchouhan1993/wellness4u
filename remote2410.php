<?php
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };
@set_time_limit(1000000);
//include("config.php" );
include('classes/config.php');
$obj = new frontclass();
$obj2 = new frontclass2();
include_once('class.phpmailer.php');
$test = '';
$action = stripslashes($_REQUEST['action']);

if($action == 'getmwsboxcode')
{
    $output = '';
    $sol_cat_id = stripslashes($_REQUEST['sol_cat_id']);
   
    $date = stripslashes($_REQUEST['date']);
    $mid = stripslashes($_REQUEST['mid']);
    $user_id = $_SESSION['user_id'];
    $user_select1 = '';
    $fav1 = array();
    $chk_pdf1 = array();
    $user_adv1 = array();
    $output = getMWSBoxCode($sol_cat_id,$date,$user_select1,$fav1,$chk_pdf1,$user_adv1,$mid,$user_id);
    echo $output;
}
else if($action == 'getmwsboxcodevivek')
{
    $output = '';
    $sol_cat_id = stripslashes($_REQUEST['sol_cat_id']);
    $mid = stripslashes($_REQUEST['mid']);
    $keyword_id = $_REQUEST['keyword_id'];
    
    $user_select1 = '';
    $fav1 = array();
    $chk_pdf1 = array();
    $user_adv1 = array();
   
    
//    $output = getMWSBoxCode($sol_cat_id,$mid);
    $output = getMWSBoxCodeVivek($sol_cat_id,$keyword_id,$mid,$user_select1,$fav1,$chk_pdf1,$user_adv1);

    echo $output;
}
elseif($action == 'proceedtogopage')
{
    $output = '';
    $gotopage = stripslashes($_REQUEST['gotopage']);
    $output = SITE_URL.'/'.getMenuLink($gotopage);
    echo $output;
}
elseif($action == 'getmodulewisecriteriascaleoptions')
{
	$output = '';
	
	$report_module = stripslashes($_REQUEST['report_module']);
        $pro_user_id = stripslashes($_REQUEST['pro_user_id']);
        $user_id = $_SESSION['user_id'];
        $module_criteria = stripslashes($_REQUEST['module_criteria']);
        $criteria_scale_range = '';
        
        $output .= '<select name="criteria_scale_range" id="criteria_scale_range" style="width:200px;" onchange="getModuleWiseCriteriaScaleValues();toggleScaleRangeType(\'criteria_scale_range\',\'div_start_criteria_scale_value\',\'div_end_criteria_scale_value\');">
                        <option value="">All</option>';
        if($module_criteria != '')
        {
            $output .= getModuleWiseCriteriaScaleOptions($user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range);
        }    
        $output .= '</select>';
        
        echo $output;
}
elseif($action == 'getmodulewisecriteriascalevalues')
{
	$output = '';
	
	$report_module = stripslashes($_REQUEST['report_module']);
        $pro_user_id = stripslashes($_REQUEST['pro_user_id']);
        $module_criteria = stripslashes($_REQUEST['module_criteria']);
        $criteria_scale_range = stripslashes($_REQUEST['criteria_scale_range']);
        $user_id = $_SESSION['user_id'];
        $start_criteria_scale_value = '';
        $end_criteria_scale_value = '';
               
        $output = getModuleWiseCriteriaScaleValues($user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value);
        
        echo $output;
}
elseif($action == 'getmodulewisecriteriaoptions')
{
	$output = '';
	
	$report_module = stripslashes($_REQUEST['report_module']);
        $pro_user_id = stripslashes($_REQUEST['pro_user_id']);
        $user_id = $_SESSION['user_id'];
        $module_criteria = '';
        
        $output .= '<select name="module_criteria" id="module_criteria" style="width:200px;" onchange="getModuleWiseCriteriaScaleOptions();getModuleWiseCriteriaScaleValues();toggleCriteriaScaleShow();">
                        <option value="">All</option>';
        if($report_module != '')
        {
            $output .= getModuleWiseCriteriaOptions($user_id,$report_module,$pro_user_id,$module_criteria);
        }    
        $output .= '</select>';
        
        echo $output;
}
elseif($action == 'getmodulewisekeywordsoptions')
{
	$output = '';
	
	$report_module = stripslashes($_REQUEST['report_module']);
        $pro_user_id = stripslashes($_REQUEST['pro_user_id']);
        $user_id = $_SESSION['user_id'];
        $module_keyword = '';
        
        $output .= '<select name="module_keyword" id="module_keyword" style="width:200px;">
                        <option value="">All</option>';
        if($report_module != '')
        {
            $output .= getModuleWiseKeywordsOptions($user_id,$report_module,$pro_user_id,$module_keyword);
        }    
        $output .= '</select><br><span style="font-size:11px;color:#0000FF;">(Options displayed are only of Data Posted by User)</span>';
        
        echo $output;
}
elseif($action == 'getuserbpsbox')
{
	$output = '';
	
	$day = stripslashes($_REQUEST['day']);
        $month = stripslashes($_REQUEST['month']);
        $year = stripslashes($_REQUEST['year']);
        
	if(isLoggedIn())
	{
            $bps_date = $year.'-'.$month.'-'.$day;
            $user_id = $_SESSION['user_id'];
            $output = getUserBPSBox($user_id,$bps_date);
            
        }            
	echo $output;
}
elseif($action == 'deleteuserbps')
{
	$output = '';
	
	$user_bps_id = stripslashes($_REQUEST['user_bps_id']);
	if(isLoggedIn())
	{
            $user_id = $_SESSION['user_id'];
            if(deleteUserBPS($user_id,$user_bps_id))
            {
                $output = 'Record Deleted';
            }
            else
            {
                $output = 'Something went wrong. Please try again later!';
            }
        }            
	echo $output;
}
elseif($action == 'getuserbodypartimagebox')
{
	$output = '';
	
	$bp_id = stripslashes($_REQUEST['bp_id']);
        $bp_id = substr($bp_id, 1);
	
	$output = getUserBodyPartImageBox($bp_id);
		
	echo $output;
}
elseif($action == 'getuserfullbodyimagebox')
{
	$output = '';
	
	$bp_side = stripslashes($_REQUEST['bp_side']);
	$user_id = $_SESSION['user_id'];
	
	$output = getUserFullBodyImageBox($user_id,$bp_side);
		
	echo $output;
}
elseif($action == 'doredeamallmodule')
{
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$reward_list_id = stripslashes($_REQUEST['reward_list_id']);
	$reward_module_id = stripslashes($_REQUEST['reward_module_id']);
	$module_total_balance_points = stripslashes($_REQUEST['module_total_balance_points']);
	$selected_encashed_point = stripslashes($_REQUEST['selected_encashed_point']);
	$user_id = $_SESSION['user_id'];
	
	$reward_module_id = substr($reward_module_id,0,-1);
	$module_total_balance_points = substr($module_total_balance_points,0,-1);
	$selected_encashed_point = substr($selected_encashed_point,0,-1);
	
	$arr_reward_module_id = explode(',',$reward_module_id);
	$arr_module_total_balance_points = explode(',',$module_total_balance_points);
	$arr_selected_encashed_point = explode(',',$selected_encashed_point);
	
	if($reward_list_id == '' || $reward_list_id == ',')
	{
		$error = '1';
		$err_msg = 'Please select any gift to redeem!';
	}
	elseif($reward_module_id == '' || $reward_module_id == ',')
	{
		$error = '1';
		$err_msg = 'Please select any module to redeem!';
	}
	else
	{
		$total_selected_encashed_points = 0;
		for($i=0;$i<count($arr_selected_encashed_point);$i++)
		{
			$total_selected_encashed_points += $arr_selected_encashed_point[$i];
		}
	
		$total_selected_gift_point = getTotalPointsOfSelectedGiftItem($reward_list_id);
		if($total_selected_gift_point < $total_selected_encashed_points)
		{
			$error = '1';
			$err_msg = 'Total selected encashed point is exceed than gift point!';
		}
		elseif($total_selected_gift_point > $total_selected_encashed_points)
		{
			$error = '1';
			$err_msg = 'Total selected encashed point is less than gift point!';
		}
		else
		{
			if(doRedeamAllModule($user_id,$arr_reward_module_id,$reward_list_id,$arr_selected_encashed_point,$arr_module_total_balance_points))
			{
				$error = '0';
				$err_msg = 'Gift Redeemed Successfully!';
			}
			else
			{
				$error = '1';
				$err_msg = 'Somthing went wrong! Please try again later';				
			}
		}	
	}	
	
	$output = $test.'::::'.$error.'::::'.$err_msg;
	echo $output;
}
elseif($action == 'doredeam')
{
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$reward_list_id = stripslashes($_REQUEST['reward_list_id']);
	$reward_module_id = stripslashes($_REQUEST['reward_module_id']);
	$balance_points = stripslashes($_REQUEST['balance_points']);
	$user_id = $_SESSION['user_id'];
	
	if($reward_list_id == '' || $reward_list_id == ',')
	{
		$error = '1';
		$err_msg = 'Please select any gift to redeem!';
	}
	else
	{
		$total_selected_point = getTotalPointsOfSelectedGiftItem($reward_list_id);
		if($total_selected_point > $balance_points)
		{
			$error = '1';
			$err_msg = 'Total selected point is exceed than balance point!';
		}
		else
		{
			$new_balance_point = $balance_points - $total_selected_point;
			$random_all_module_no = 0;
			if(doRedeam($user_id,$reward_module_id,$reward_list_id,$balance_points,$total_selected_point,$new_balance_point,$random_all_module_no))
			{
				$error = '0';
				$err_msg = 'Gift Redeemed Successfully!';
			}
			else
			{
				$error = '1';
				$err_msg = 'Somthing went wrong! Please try again later';				
			}
		}	
	}	
	
	$output = $test.'::::'.$error.'::::'.$err_msg;
	echo $output;
}
elseif($action == 'viewmodulewiseredeampopup')
{
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$start_date = stripslashes($_REQUEST['start_date']);
	$reward_module_id = stripslashes($_REQUEST['reward_module_id']);
	$reward_module_title = stripslashes($_REQUEST['reward_module_title']);
	$balance_points = stripslashes($_REQUEST['balance_points']);
	$user_id = $_SESSION['user_id'];
	
	$output = viewModuleWiseRedeamPopup($user_id,$start_date,$reward_module_id,$balance_points,$reward_module_title);
		
	echo $output;
}
elseif($action == 'viewallmoduleredeampopup')
{
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$summary_reward_module_id = stripslashes($_REQUEST['summary_reward_module_id']);
	$summary_reward_module_title = stripslashes($_REQUEST['summary_reward_module_title']);
	$summary_total_balance_points = stripslashes($_REQUEST['summary_total_balance_points']);
	$user_id = $_SESSION['user_id'];
	
	$summary_reward_module_id = substr($summary_reward_module_id,0,-1);
	$summary_reward_module_title = substr($summary_reward_module_title,0,-1);
	$summary_total_balance_points = substr($summary_total_balance_points,0,-1);
	
	$arr_summary_reward_module_id = explode(',',$summary_reward_module_id);
	$arr_summary_reward_module_title = explode(',',$summary_reward_module_title);
	$arr_summary_total_balance_points = explode(',',$summary_total_balance_points);
	
	$output = viewAllModuleRedeamPopup($user_id,$arr_summary_reward_module_id,$arr_summary_reward_module_title,$arr_summary_total_balance_points);
		
	echo $output;
}
elseif($action == 'getadviserquerypageoptions')
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
                if($puid == '')
                {
                    $show_all = '1';
                }
                else
                {
                    $show_all = '0';
                }
	}		
	$ret_str .= getAdviserQueryPageOptions($temp_page_id,$uid,$puid,$show_all);
	$ret_str .='</select>';
	echo $ret_str;
}
elseif($action == 'updateuserformtheme')
{
	$pro_user_id = stripslashes($_REQUEST['pro_user_id']);
	$user_id = $_SESSION['user_id'];
	
	if($pro_user_id == '' || $pro_user_id == '999999999')
	{
		$bg_color_code = '#339900';
		$bg_image = '';
                
		list($top_banner,$top_position,$top_height,$top_weight) = GetTopBanner();
		$top_banner = SITE_URL.'/uploads/'.$top_banner;
	}
	else
	{
            
		$adviser_top_banner = getAdviserTopBanner($pro_user_id);
                
		if($adviser_top_banner == '')
		{
			list($top_banner,$top_position,$top_height,$top_weight) = GetTopBanner();
		}
		else
		{
			$top_banner = $adviser_top_banner;
		}
		
		$top_banner = SITE_URL.'/uploads/'.$top_banner;
		
		list($bg_image,$bg_color_code) = getImageAndColorCodeOfAdviserTheme($pro_user_id);
	}	
	$output = $test.'::::'.$bg_image.'::::'.$bg_color_code.'::::'.$top_banner;
	echo $output;
}
elseif($action == 'viewuserplans')
{
	$upct_id = stripslashes($_REQUEST['upct_id']);
	$user_id = $_SESSION['user_id'];
	$output = viewUserPlans($user_id,$upct_id);
	echo $output;
}
elseif($action == 'senduserplanrequest')
{
	$up_id = stripslashes($_REQUEST['up_id']);
	$error = '0';
	if(isLoggedIn())
	{
		$user_id = $_SESSION['user_id'];
		
		if(chkIfUserPlanRequestAlreadySent($user_id))
		{
			$error = '3';
			$msg = 'You have already sent request.';
			$output = $msg;
		}
		elseif(sendUserPlanRequest($user_id,$up_id))
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
	$user_id = $_SESSION['user_id'];
	
	if($tgaction == 'read')
	{
		setUserQueryRead($aq_id,$user_id,'1');
	}
	elseif($tgaction == 'unread')
	{
		setUserQueryRead($aq_id,$user_id,'0');
	}	

	echo $output;
}
elseif($action == 'viewadviserpopup')
{
	$pro_user_id = stripslashes($_REQUEST['puid']);
	$output = '';
	
	list($return,$name,$email,$dob,$sex,$mobile,$address,$country_id,$state_id,$city_id,$place_id,$reg_no,$issued_by,$scan_image,$membership,$membership_no,$membership_image,$service_clinic_name,$service_location,$service_location_country_id,$service_location_state_id,$service_location_city_id,$service_location_place_id,$service_rendered,$service_notes,$referred_by,$ref_name,$specify) = getUserDetailsPro($pro_user_id);
	
	$arr_membership = array();
	$arr_err_membership = array();
	$arr_tr_err_membership = array();
	$arr_membership_no = array();
	$arr_membership_image = array();
	
	$arr_service_clinic_name = array();
	$arr_service_location = array();
	$arr_service_location_country_id = array();
	$arr_service_location_state_id = array();
	$arr_service_location_city_id = array();
	$arr_service_location_place_id = array();
	$arr_service_rendered = array();
	$arr_service_notes = array();
	
	$row_cnt = '1';
	$row_totalRow = '1';
	
	$row_cnt2 = '1';
	$row_totalRow2 = '1';

	
	if($membership != '')
	{
		$arr_membership = explode('::',$membership);
		$arr_membership_no = explode('::',$membership_no);
		$arr_membership_image = explode('::',$membership_image);
		
		if(count($arr_membership) > 0)
		{
			$row_cnt = count($arr_membership);
			$row_totalRow = count($arr_membership);
		}
	}		
	
	
	if($service_clinic_name != '')
	{
		$arr_service_clinic_name = explode('::',$service_clinic_name);
		$arr_service_location = explode('::',$service_location);
		$arr_service_location_country_id = explode('::',$service_location_country_id);
		$arr_service_location_state_id = explode('::',$service_location_state_id);
		$arr_service_location_city_id = explode('::',$service_location_city_id);
		$arr_service_location_place_id = explode('::',$service_location_place_id);
		$arr_service_rendered = explode('::',$service_rendered);
		$arr_service_notes = explode('::',$service_notes);
		
		if(count($arr_service_clinic_name) > 0)
		{	
			$row_cnt2 = count($arr_service_clinic_name);
			$row_totalRow2 = count($arr_service_clinic_name);
		}
	}	
	
	$output .= '<div style="width:1100px;height:600px;overflow:scroll;">
				<table cellpadding="0" cellspacing="0" width="100%" align="center" border="0">
					<tr>
						<td colspan="3" height="30" align="right" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td width="40%" height="40" align="right" valign="top"><strong>Adviser Name</strong></td>
						<td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>
						<td width="55%" height="40" align="left" valign="top">'.$name.'</td>
					</tr>
					<tr>
						<td height="40" align="right" valign="top"><strong>Country</strong></td>
						<td height="40" align="center" valign="top"><strong>:</strong></td>
						<td height="40" align="left" valign="top">'.getCountryName($country_id).'</td>
					</tr>
					<tr>
						<td height="40" align="right" valign="top"><strong>State</strong></td>
						<td height="40" align="center" valign="top"><strong>:</strong></td>
						<td height="40" align="left" valign="top">'.getStateName($state_id).'</td>
					</tr>
					<tr>
						<td height="40" align="right" valign="top"><strong>City</strong></td>
						<td height="40" align="center" valign="top"><strong>:</strong></td>
						<td height="40" align="left" valign="top">'.getCityName($city_id).'</td>
					</tr>
					<tr>
						<td height="40" align="right" valign="top"><strong>Place</strong></td>
						<td height="40" align="center" valign="top"><strong>:</strong></td>
						<td height="40" align="left" valign="top">'.getPlaceName($place_id).'</td>
					</tr>
					<tr>
						<td height="40" align="right" valign="top"><strong>Practitioner Registration Number</strong></td>
						<td height="40" align="center" valign="top"><strong>:</strong></td>
						<td height="40" align="left" valign="top">'.$reg_no.'</td>
					</tr>
					<tr>
						<td height="40" align="right" valign="top"><strong>Issued By</strong></td>
						<td height="40" align="center" valign="top"><strong>:</strong></td>
						<td height="40" align="left" valign="top">'.$issued_by.'</td>
					</tr>';
	if($scan_image != '')
	{ 	
	
		$scan_image_str = '<ul class="zoomonhoverul">
						<li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $scan_image.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $scan_image.'" width="50" alt="gallery thumbnail" /></a></li>
					</ul>';
				
	$output .= '	<tr>
						<td height="40" align="right" valign="top"><strong>Registration Copy</strong></td>
						<td height="40" align="center" valign="top"><strong>:</strong></td>
						<td height="40" align="left" valign="top">'.$scan_image_str.'<br /></td>
					</tr>';
	}	
	
	$output .= '	<tr>
						<td colspan="3" height="30" align="right" valign="top">&nbsp;</td>
					</tr>';	
	
	for($i=0;$i<$row_totalRow;$i++)
	{
	$output .= '	<tr>
						<td height="40" align="right" valign="top"><strong>Memberships</strong></td>
						<td height="40" align="center" valign="top"><strong>:</strong></td>
						<td height="40" align="left" valign="top">'.$arr_membership[$i].'</td>
					</tr>
					<tr>
						<td height="40" align="right" valign="top"><strong>Membership No</strong></td>
						<td height="40" align="center" valign="top"><strong>:</strong></td>
						<td height="40" align="left" valign="top">'.$arr_membership_no[$i].'</td>
					</tr>';
					if($arr_membership_image[$i] != '')
					{
					
					$membership_image_str = '<ul class="zoomonhoverul">
						<li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $arr_membership_image[$i].'" class="preview"><img src="'.SITE_URL.'/uploads/'. $arr_membership_image[$i].'" width="50" alt="gallery thumbnail" /></a></li>
					</ul>';
					
	$output .= '	<tr>
						<td height="40" align="right" valign="top"><strong>Membership Copy</strong></td>
						<td height="40" align="center" valign="top"><strong>:</strong></td>
						<td height="40" align="left" valign="top">'.$membership_image_str.'<br /></td>
					</tr>';		
					}
	$output .= '	<tr>
						<td colspan="3" height="30" align="right" valign="top">&nbsp;</td>
					</tr>';		
	
	}
	$output .= '	<tr>
						<td colspan="3" height="30" align="right" valign="top">&nbsp;</td>
					</tr>
					';	
	$output .= '	<tr>
						<td colspan="3" height="30" align="left" valign="top">
							<table align="center" border="0" width="1000" cellpadding="0" cellspacing="0" id="tblrow2">
								<tr>
									<td height="30" colspan="5" align="left" valign="top"><strong>Currently providing Services at:</strong></td>
								</tr>
								<tr>
									<td colspan="5" height="30" align="right" valign="top">&nbsp;</td>
								</tr>
								<tr>
									<td width="10%" height="30" align="left" valign="top"><strong>SrNo</strong></td>
									<td width="20%" height="30" align="left" valign="top"><strong>Name of Facility /Clinic</strong></td>
									<td width="30%" height="30" align="left" valign="top"><strong>Location</strong></td>
									<td width="20%" height="30" align="left" valign="top"><strong>Wellness Services rendered</strong></td>
									<td width="20%" height="30" align="left" valign="top"><strong>Notes</strong></td>
								</tr>';
	for($i=0,$j=1;$i<$row_totalRow2;$i++,$j++)
	{							
	$output .= '				<tr>
									<td height="40" align="left" valign="top">'.$j.'</td>
									<td height="40" align="left" valign="top">'.$arr_service_clinic_name[$i].'</td>
									<td height="40" align="left" valign="top">'.$arr_service_location[$i].'</td>
									<td height="40" align="left" valign="top">'.$arr_service_rendered[$i].'</td>
									<td height="40" align="left" valign="top">'.$arr_service_notes[$i].'</td>
								</tr>
								<tr>
									<td colspan="5" height="30" align="right" valign="top">&nbsp;</td>
								</tr>';					
	
	}
	$output .= '		</td>
					</tr>';					
	
	$output .= '</table><div>';
			
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
		$from_user = '1';
		if(addAdviserQuery($parent_aq_id,$temp_page_id,$user_id,$name,$email,$temp_pro_user_id,$from_user,$query))
		{
			$error = '2';
			$msg = 'Your Query has been forwarded to your Adviser ('.getProUserFullNameById($temp_pro_user_id).')\'s Message Box for his/her Guidance to you';
			$output = $error.'::'.$msg;
		}
	}
	echo $output;
}
elseif($action == 'showtriggerremarkspopup')
{
    $idval = stripslashes($_REQUEST['idval']);
    $remark = urldecode(stripslashes($_REQUEST['remark']));
    $output = '';
    $output .= '<br><br>
                <form id="frmadviserquery" name="frmadviserquery" method="post" action="#" enctype="multipart/form-data">
                    <input type="hidden" name="hdntempidval" id="hdntempidval" value="'.$idval.'" />
                    <table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">';
	
	
	$output .= '	<tr>
                            <td width="60%" height="40" align="left" valign="top">Remark/Comments:</td>
                            <td width="40%" height="40" align="left" valign="top">
                                    <textarea  cols="30" rows="5" type="text" id="temp_remark" name="temp_remark">'.$remark.'</textarea>
                            </td>
                        </tr>';
		
					
		$output .= '	
						<tr>
							<td width="60%" height="40" align="left" valign="middle">&nbsp;</td>
							<td width="40%" height="40" align="left" valign="middle">
							<input name="submit" type="button" class="button" id="submit" value="Submit"  onclick="setTriggerRemark()"/>
							</td>
						</tr>   
					</table>
				</form>';
    echo $output;
}
elseif($action == 'showadviserquerypopup')
{
	$parent_aq_id = stripslashes($_REQUEST['parent_aq_id']);
	$output = '';
	if(!isLoggedIn())
	{
		$ref = base64_encode('my_wellness_guidence.php');
		$output = '<span class="Header_brown">You must login before add query.Please <a href="login.php?ref='.$ref.'">Click here</a> to Login.</span>';
	}
	else
	{
		$user_id = $_SESSION['user_id'];
		
		if(chkUserPlanFeaturePermission($user_id,'28'))
		{
			$output = showAdviserQueryPopup($user_id,$parent_aq_id);
		}
		else
		{
			$output = '<span class="Header_brown">'.getCommonSettingValue('3').'</span>';
		}
		
		
	}
		
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
	
	doAcceptAdviserInvitation($ar_id,$report_id,$user_id,$puid,$permission_type);
		
	echo $output;
}
elseif($action == 'declineadviserinvitation')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$user_id = $_SESSION['user_id'];
	$puid = stripslashes($_REQUEST['puid']);
        $status_reason = stripslashes($_REQUEST['status_reason']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	declineAdviserInvitation($ar_id,$user_id,$puid,$status_reason);
		
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
	
	deactivateAdviserInvitation($ar_id,$user_id,$puid,$status_reason);
		
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
	
	activateAdviserInvitation($ar_id,$user_id,$puid,$status_reason);
		
	echo $output;
}
elseif($action == 'showacceptinvitationpopup')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$puid = stripslashes($_REQUEST['puid']);
	$user_id = $_SESSION['user_id'];
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$output = showAcceptInvitationPopup($user_id,$ar_id,$puid);
		
	echo $output;
}
elseif($action == 'showdeclineadviserinvitationpopup')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$puid = stripslashes($_REQUEST['puid']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$output = showDeclineAdviserInvitationPopup($ar_id,$puid);
		
	echo $output;
}
elseif($action == 'showdeactivateadviserinvitationpopup')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$puid = stripslashes($_REQUEST['puid']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$output = showDeactivateAdviserInvitationPopup($ar_id,$puid);
		
	echo $output;
}
elseif($action == 'showactivateadviserinvitationpopup')
{
	$ar_id = stripslashes($_REQUEST['ar_id']);
	$puid = stripslashes($_REQUEST['puid']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$output = showActivateAdviserInvitationPopup($ar_id,$puid);
		
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
    
	$module_id = stripslashes($_REQUEST['module_id']);
	$error = '0';
	$err_msg = '';
	$output = '';
	
	$output = showRewardCatlog($module_id);
		
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
elseif($action == 'display_bannermws')
{
    $banner_id = stripslashes($_REQUEST['banner_id']);
    $output = get_BoxSelectedItemCodeMWS($banner_id);
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

	$output = $obj->Library_Feedback($page_id);

	echo $output;

}

elseif($action == 'makenote')

{

	$library_id = stripslashes($_REQUEST['library_id']);

	$page_id = stripslashes($_REQUEST['page_id']);

	$output = $obj->Make_Note($library_id,$page_id);

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

		$output = $obj->search_library($user_id,$page_id,$start_date);	

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

elseif($action == 'getmessagedatavivek')

{

//	$page_id = stripslashes($_REQUEST['page_id']);

	$name = stripslashes($_REQUEST['name']);

	$email = stripslashes($_REQUEST['email']);

	$message = stripslashes($_REQUEST['message']);

	$sol_item_id = stripslashes($_REQUEST['sol_item_id']);

	

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

		if(InsertMessagedataVivek($name,$email,$message,$user_id,$sol_item_id))

		{

			$error = '2';

			$msg = 'Thank You For Your Comment';

			 $output = $error.'::'.$msg;

		}

		

	}

	echo $output;

}
elseif($action == 'addUploadDataVivek')

{

	$comment_box = stripslashes($_REQUEST['comment_box']);

	$bes_id = stripslashes($_REQUEST['bes_id']);

	$trigger_id = stripslashes($_REQUEST['trigger_id']);

	$user_banner_type1 = stripslashes($_REQUEST['user_banner_type1']);

	$user_title1 = stripslashes($_REQUEST['user_title1']);
        
        $select_banner1 = stripslashes($_REQUEST['select_banner1']);

	$adv1 = stripslashes($_REQUEST['adv1']);

	$favourite1 = stripslashes($_REQUEST['favourite1']);

	$theam_id = stripslashes($_REQUEST['theam_id']);

	 if(is_array($fav1) && count($fav1)>0)

        {

            $fav1 = array_unique($fav1);

            $fav1 = array_values($fav1);

            $fav1_comma_separated = implode(",", $fav1);

        }

        else

        {

            $fav1 = array();   

            $fav1_comma_separated = '';

	}



        if($user_select1 != '')

 	{

            $display_banner1 = '';

        }



	if($user_banner_type1 == 'Video')







	{   







		







		$user_display_trfile1 = 'none';







		$user_display_trtext1 = '';







		$user_banner1 = trim($_POST['user_video_banner1']);







	}







	else







	{  







		$user_display_trfile1 = '';







		$user_display_trtext1 = 'none';















		if(isset($_FILES['user_banner1']['tmp_name']) && $_FILES['user_banner1']['tmp_name'] != '')







			{







				$user_banner1 = $_FILES['user_banner1']['name'];







				$user_file1=substr($user_banner1, -4, 4);







				 















					if($user_banner_type1 == 'Image')







					{







					      







						if(($user_file1 != '.jpg')and($user_file1 != '.JPG') and ($user_file1 !='jpeg') and ($user_file1 != 'JPEG') and ($user_file1 !='.gif') and ($user_file1 != '.GIF') and ($user_file1 !='.png') and ($user_file1 != '.PNG'))







						{







							$error = true;







							$tr_err_user_banner_type1 = '';







							$err_user_banner_type1 = 'Please Upload Only(jpg/gif/jpeg/png) files for banner';







						}	 







						elseif( $_FILES['user_banner1']['type'] != 'image/jpeg' and $_FILES['user_banner1']['type'] != 'image/pjpeg'  and $_FILES['user_banner1']['type'] != 'image/gif' and $_FILES['user_banner1']['type'] != 'image/png' )







						{







							$error = true;







							$tr_err_user_banner_type1 = '';







							$err_user_banner_type1 .= 'Please Upload Only(jpg/gif/jpeg/png) files ';







						}







							$image_size = $_FILES['user_banner1']['size']/1024;	 







							$max_image_allowed_file_size = 2000; // size in KB







							if($image_size > $max_image_allowed_file_size )







							{







								$error = true;







								$tr_err_user_banner_type1 = '';







								$err_user_banner_type1 .= "<br>Size of image file should be less than $max_image_allowed_file_size kb";







							}







					}







					elseif($user_banner_type1 == 'Flash')







						{







						if(($user_file1 != '.swf')and($user_file2 != '.SWF'))







							{







								$error = true;







								$tr_err_user_banner_type1 = '';







								$err_user_banner_type1 .= 'Please Upload Only(swf) files  ';







							}	 







						elseif( $_FILES['user_banner1']['type'] != 'application/x-shockwave-flash'  )







							{







								$error = true;







								$tr_err_user_banner_type1 = '';







								$err_user_banner_type1 .= 'Please Upload Only(swf) files ';







							}







								$flash_size = $_FILES['user_banner1']['size']/1024;	 







								$max_flash_allowed_file_size = 2000; // size in KB







								if($flash_size > $max_flash_allowed_file_size )







								{







									$error = true;







									$tr_err_user_banner_type1 = '';







									$err_user_banner_type1 .= "<br>Size of flash file should be less than $max_flash_allowed_file_size kb";







								}







						}







						elseif($user_banner_type1 == 'Audio')







						{







						 if(($user_file1 != '.mp3')and($user_file1 != '.wav')and($user_file1 != '.MP3')and($user_file1 != '.WAV')and($user_file1 != '.mid')and($user_file1 != '.MID'))







							{







								$error = true;







								$tr_err_user_banner_type1 = '';







								$err_user_banner_type1 .= 'Please Upload Only(mp3 / wav / mid) files  ';







							}







								$audio_size = $_FILES['user_banner1']['size']/1024;	 







								$max_audio_allowed_file_size = 2000; // size in KB







								if($audio_size > $max_audio_allowed_file_size )







								{







									$error = true;







									$tr_err_user_banner_type1 = '';







									$err_user_banner_type1 .= "<br>Size of audio file should be less than $max_audio_allowed_file_size kb";







								}	 







						}







						elseif($user_banner_type1 == 'PDF')







						{







							if(($user_file1 != '.pdf')and($user_file1 != '.PDF'))







							{







								$error = true;







								$tr_err_user_banner_type1 = '';







								$err_user_banner_type1 .= 'Please Upload Only(PDF / pdf) files';







							}







							$pdf_size = $_FILES['user_banner1']['size']/1024;







							$max_pdf_allowed_file_size = 2000; // size in KB







							if($pdf_size > $max_pdf_allowed_file_size )







							{







								$error = true;







								$tr_err_user_banner_type1 = '';







								$err_user_banner_type1 .= "<br>Size of PDF file should be less than $max_pdf_allowed_file_size kb";







							}	 







						}















						if(!$error)







							{	







								$user_banner1 = time()."_".$user_banner1;







								$user_temp_dir1 = SITE_PATH.'/uploads/';







								$user_temp_file1 = $user_temp_dir1.$user_banner1;







						







								if(!move_uploaded_file($_FILES['user_banner1']['tmp_name'], $user_temp_file1)) 







								{







									if(file_exists($user_temp_file1)) { unlink($user_temp_file1); } // Remove temp file







									$error = true;







									$tr_err_user_banner_type1 = '';







									$err_user_banner_type1 .= '<br>Couldn\'t Upload banner 1';







								}







							}







							else







								{







									$user_banner1 = '';







								}







							







			}







					







	}







	







	if(!$error)







	{







		if($user_banner1 != '')







		{







			if($user_banner_type1 == 'PDF')







			{







//				InsertMindjumbelPDF($user_title1,$user_banner_type1,$user_banner1,$day,$user_id,$select_title,$short_narration);

	                        InsertMindjumbelVivekPDF($user_title1,$user_banner_type1,$user_banner1,$day,$user_id,$bes_id,$trigger_id);







			}







			else







			{






//print_r($user_id);die();
//	  			InsertMindjumbel($user_title1,$user_banner_type1,$user_banner1,$day,$user_id);

                                InsertMindjumbelVivek($user_title1,$user_banner_type1,$user_banner1,$day,$user_id);


echo 'Update Data Successfully';



			}







		}								







	}  






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

elseif($action == 'postcommentVivek')

{

	$comment_box = stripslashes($_REQUEST['comment_box']);

	$bes_id = stripslashes($_REQUEST['bes_id']);

	$trigger_id = stripslashes($_REQUEST['trigger_id']);

	$error = false;

	$parent_comment_id = '0';

	$code = '';

	$comment_type = 'MyWellnessSolutionItem';

	if(isLoggedIn())

	{

		$user_id = $_SESSION['user_id'];

//		$output = PostComment($comment_box,$user_id,$parent_comment_id,$comment_type,$bes_id,$trigger_id);
//
//		$code = GetCommentCode($bes_id,$trigger_id);
                
                $output = PostCommentVivek($comment_box,$user_id,$parent_comment_id,$comment_type,$bes_id,$trigger_id);

		$code = GetCommentCodeVivek($bes_id,$trigger_id);

	}else

	{

		$error = true;

		$_SESSION['temp_comment'] = $comment_box;

		$_SESSION['bes_id'] = $bes_id;

		$_SESSION['trigger_id'] = $trigger_id;

		$_SESSION['temp_parent_commnet_id'] = $parent_comment_id;

		$_SESSION['comment_type'] = $comment_type;

//		$code = base64_encode('remote.php?action=postcommentafterloginVivek');
                $code='Please Login to Post your Comments';

	}

	$ret_str = $error."::".$code;

	

	echo $ret_str;

}

elseif($action == 'postcommentAddVivek')

{

	$comment_box = stripslashes($_REQUEST['comment_box']);

	$topic_subject = stripslashes($_REQUEST['topic_subject']);

	$narration = stripslashes($_REQUEST['narration']);

	$error = false;

	$parent_comment_id = '0';

	$code = '';

	$comment_type = 'MyWellnessSolutionItemAdd';

	if(isLoggedIn())

	{

		$user_id = $_SESSION['user_id'];

//		$output = PostComment($comment_box,$user_id,$parent_comment_id,$comment_type,$bes_id,$trigger_id);
//
//		$code = GetCommentCode($bes_id,$trigger_id);
                
                $output = PostCommentAddVivek($comment_box,$user_id,$parent_comment_id,$comment_type,$topic_subject,$narration);

		$code = GetCommentCodeAddVivek($topic_subject,$narration);

	}else

	{

		$error = true;

		$_SESSION['temp_comment'] = $comment_box;

		$_SESSION['topic_subject'] = $topic_subject;

		$_SESSION['narration'] = $narration;

		$_SESSION['temp_parent_commnet_id'] = $parent_comment_id;

		$_SESSION['comment_type'] = $comment_type;

//		$code = base64_encode('remote.php?action=postcommentafterloginVivek');
                $code='Please Login to Post your Comments';

	}

	$ret_str = $error."::".$code;

	

	echo $ret_str;

}


//elseif($action == 'postcommentafterloginVivek')
//
//{
//
//	$code = '';
//
//	$error = false;
//
//	$comment_box = $_SESSION['temp_comment'];
//
//	$bes_id = $_SESSION['bes_id'];
//
//	$trigger_id = $_SESSION['trigger_id'];
//
//	$parent_comment_id = $_SESSION['temp_parent_commnet_id'];
//
//	$comment_type = $_SESSION['comment_type'];
//
//	
//
//	if(isLoggedIn())
//
//	{
//
//		$user_id = $_SESSION['user_id'];
//
//		$output = PostCommentVivek($comment_box,$user_id,$parent_comment_id,$comment_type,$bes_id,$trigger_id);
//
//		
//
//	}
//
//		header("Location: my_wellness_solutions_item.php");
//
//		exit(0);
//
//}

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

elseif($action == 'wellness_solution_item_banner_vivek')

{

	$sol_item_id = stripslashes($_REQUEST['sol_item_id']);

	$output = get_SolutionItemCodeBoxCode($sol_item_id);

	echo $output;

}
elseif($action == 'chatt_data_add_vivek')

{

	$sol_item_id = stripslashes($_REQUEST['sol_item_id']);
        if(isset($_SESSION['user_id'])!='')
        {
        $user_id = $_SESSION['user_id'];
        }
        else
        {
            $user_id = 0;
        }
        
        $output = InsertChattdataDetails($sol_item_id,$user_id);

	echo 'Like';die();

}

elseif($action == 'changtheam')
{
    $theam_id = stripslashes($_REQUEST['theam_id']);
    $_SESSION['theam_id'] = $theam_id;
    list($image,$color_code) = getTheamDetails($theam_id);
    $output = $image.'::'.$color_code;
    echo $output;
}
elseif($action == 'changtheammws')
{
    $theam_id = stripslashes($_REQUEST['theam_id']);
    $_SESSION['mwstheam_id'] = $theam_id;
    list($image,$color_code) = getTheamDetailsMDT($theam_id);
    $output = $image.'::'.$color_code;
    echo $output;
}
elseif($action == 'changtheammdt')
{
    $theam_id = stripslashes($_REQUEST['theam_id']);
    $_SESSION['mdttheam_id'] = $theam_id;
    list($image,$color_code) = getTheamDetailsMDT($theam_id);
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

elseif($action == 'getsoundclip')

{

	$sound_clip_id = stripslashes($_REQUEST['sound_clip_id']);

	$sound_clip = GetSoundClip($sound_clip_id);

	//echo $sound_clip;

	$ret_str = '';

	$ret_str .='<embed src="'.SITE_URL.'/uploads/'. $sound_clip.'" autostart="true" hidden="true" height="20"></embed>';

	echo $ret_str;

}

elseif($action == 'getangerventsoundclip')

{

	$sound_clip_id = stripslashes($_REQUEST['sound_clip_id']);

	$sound_clip = GetAngerVentSoundClip($sound_clip_id);

	//echo $sound_clip;

	$ret_str = '';

	$ret_str .='<embed src="'.SITE_URL.'/uploads/'. $sound_clip.'" autostart="true" hidden="true" height="20"></embed>';

	echo $ret_str;

}elseif($action == 'getmindjumblesoundclip')

{

	$sound_clip_id = stripslashes($_REQUEST['sound_clip_id']);

	$sound_clip = GetMindJumbleSoundClip($sound_clip_id);

	//echo $sound_clip;

	$ret_str = '';

	$ret_str .='<embed src="'.SITE_URL.'/uploads/'. $sound_clip.'" autostart="true" hidden="true" height="20"></embed>';

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
elseif($action == 'getactivitiesrows')
{
	$today_wakeup_time = stripslashes($_REQUEST['today_wakeup_time']);
	
	$mins_id_arr = stripslashes($_REQUEST['mins_id_arr']);
	$mins_arr = explode(",",$mins_id_arr);
	
	$activity_id_arr = stripslashes($_REQUEST['activity_id_arr']);
	$activity_id_arr = explode(",",$activity_id_arr);
	
	$other_activity_arr = stripslashes($_REQUEST['other_activity_arr']);
	$other_activity_arr = explode(",",$other_activity_arr);
	
	$proper_guidance_arr = stripslashes($_REQUEST['proper_guidance_arr']);
	$proper_guidance_arr = explode(",",$proper_guidance_arr);
	
	$precaution_arr = stripslashes($_REQUEST['precaution_arr']);
	$precaution_arr = explode(",",$precaution_arr);
	
	$tr_err_activity = stripslashes($_REQUEST['tr_err_activity']);
	$tr_err_activity = explode(",",$tr_err_activity);
	
	$err_activity = stripslashes($_REQUEST['err_activity']);
	$err_activity = explode(",",$err_activity);
	
	$skip_time_arr = stripslashes($_REQUEST['skip_time_arr']);
	$skip_time_arr = explode(",",$skip_time_arr);
	
	$today_end_time = '24:00 PM';

	$ret_str = getActivitiesRows($today_wakeup_time,$mins_arr,$activity_id_arr,$other_activity_arr,$proper_guidance_arr,$precaution_arr,$tr_err_activity,$err_activity,$skip_time_arr);

	$arr_activity_time = getActivityTimeList($today_wakeup_time,$today_end_time,15,$mins_arr,$skip_time_arr);
	$cnt = count($arr_activity_time);
	//debug_array($activity_id_arr);
	//debug_array($arr_activity_time);
	$activity_prefill_arr = array();
	for($i=0;$i<count($activity_id_arr);$i++)
	{
		if($activity_id_arr[$i] == '') 
		{
			$tmp_prefill_arr  = '{}';
		}
		else
		{ 
			$json = array();
			$json['value'] = $activity_id_arr[$i];
			$json['name'] = getDailyActivityName($activity_id_arr[$i]);
			$tmp_prefill_arr = json_encode($json);
		}
		
		array_push($activity_prefill_arr ,getPreFillList($tmp_prefill_arr));
	}	
	
	$activity_id_str = implode("***",$activity_prefill_arr);	
	
	//debug_array($activity_id_str);
	echo $ret_str.'::::'.$cnt.'::::'.$activity_id_str;
}

elseif($action == 'getactivitiesrowsnewdate')

{

	$day = stripslashes($_REQUEST['day']);

	$month = stripslashes($_REQUEST['month']);

	$year = stripslashes($_REQUEST['year']);

	$user_id = $_SESSION['user_id'];

	$activity_date = $year.'-'.$month.'-'.$day;

	$tr_err_activity = array();

	$tr_other_activity = array();

	$err_activity = array();

	$activity_prefill_arr = array();

	$skip_time_arr = array();

	

	list($yesterday_sleep_time,$today_wakeup_time,$mins_arr,$activity_id_arr,$other_activity_arr,$proper_guidance_arr,$precaution_arr,$activity_time_arr) = getUsersDailyActivityDetails($user_id,$activity_date);

	

	if(count($mins_arr)> 0)

	{

		$flagnewdate = true;

		$cnt = count($mins_arr);

		$totalRow = count($mins_arr);

		

		for($i=0;$i<$cnt;$i++)

		{

			$skip_time_arr[$i] = $activity_time_arr[$i];

			$tr_err_activity[$i] = 'none';

			$err_activity[$i] = '';

			

			if($activity_id_arr[$i] == '9999999999')

			{

				$tr_other_activity[$i] = '';

				$json = array();

				$json['value'] = $activity_id_arr[$i];

				$json['name'] = getDailyActivityName($activity_id_arr[$i]);

				array_push($activity_prefill_arr ,json_encode($json));

			}

			elseif( ($activity_id_arr[$i] == '') || ($activity_id_arr[$i] == '0') )

			{

				$tr_other_activity[$i] = 'none';

				array_push($activity_prefill_arr ,'{}');

			}

			else

			{

				$tr_other_activity[$i] = 'none';

				$json = array();

				$json['value'] = $activity_id_arr[$i];

				$json['name'] = getDailyActivityName($activity_id_arr[$i]);

				array_push($activity_prefill_arr ,json_encode($json));

			}	

		}	

		array_push($activity_id_arr ,'0');

		array_push($mins_arr ,'');

		array_push($skip_time_arr ,'');

		array_push($activity_prefill_arr ,'{}');

		$cnt++;

		$totalRow++;

	}

	else

	{

		$cnt = '1';

		$totalRow = '1';

		$tr_err_activity[0] = 'none';

		$tr_other_activity[0] = 'none';

		$err_activity[0] = '';

		array_push($activity_prefill_arr ,'{}');

		$skip_time_arr[0] = $today_wakeup_time;

	}



	$today_end_time = '24:00 PM';

	$ret_str = getActivitiesRows($today_wakeup_time,$mins_arr,$activity_id_arr,$other_activity_arr,$proper_guidance_arr,$precaution_arr,$tr_err_activity,$err_activity,$skip_time_arr);

	

	$arr_activity_time = getActivityTimeList($today_wakeup_time,$today_end_time,15,$mins_arr,$skip_time_arr);

	$cnt = count($arr_activity_time);

	

	$activity_prefill_arr = implode("***",$activity_prefill_arr);	

	

	echo $ret_str.'::::'.$cnt.'::::'.$activity_prefill_arr.'::::'.$yesterday_sleep_time.'::::'.$today_wakeup_time;

}

elseif($action == 'getusersdailymealsdetails')

{

	$day = stripslashes($_REQUEST['day']);

	$month = stripslashes($_REQUEST['month']);

	$year = stripslashes($_REQUEST['year']);

	$user_id = $_SESSION['user_id'];

	

	$meal_date = $year.'-'.$month.'-'.$day;

	

	$breakfast_start_time = '4';

	$breakfast_end_time = '10';

	

	$brunch_start_time = '10';

	$brunch_end_time = '12';

	

	$lunch_start_time = '12';

	$lunch_end_time = '15';

	

	$snacks_start_time = '15';

	$snacks_end_time = '19';

	

	$dinner_start_time = '19';

	$dinner_end_time = '28';

	

	$tr_err_meal_date = 'none';

	$tr_err_breakfast_time = 'none';

	$tr_err_breakfast = array();

	$tr_err_brunch_time = 'none';

	$tr_err_brunch = array();

	$tr_err_lunch_time = 'none';

	$tr_err_lunch = array();

	$tr_err_snacks_time = 'none';

	$tr_err_snacks = array();

	$tr_err_dinner_time = 'none';

	$tr_err_dinner = array();

	

	$tr_breakfast_other_item = array();

	$tr_brunch_other_item = array();

	$tr_lunch_other_item = array();

	$tr_snacks_other_item = array();

	$tr_dinner_other_item = array();

	

	$err_meal_date = '';

	$err_breakfast_time = '';

	$err_breakfast = array();

	$err_brunch_time = '';

	$err_brunch = array();

	$err_lunch_time = '';

	$err_lunch = array();

	$err_snacks_time = '';

	$err_snacks = array();

	$err_dinner_time = '';

	$err_dinner = array();



	

	$breakfast_prefill_arr = array();

	$brunch_prefill_arr = array();

	$lunch_prefill_arr = array();

	$snacks_prefill_arr = array();

	$dinner_prefill_arr = array();

	

	$prev_breakfast_record = false;

	$prev_brunch_record = false;

	$prev_lunch_record = false;

	$prev_snacks_record = false;

	$prev_dinner_record = false;

	

	list($arr_user_meal_id,$arr_meal_date,$arr_meal_time,$arr_meal_id,$arr_meal_others,$arr_meal_like,$arr_meal_quantity,$arr_meal_measure,$arr_meal_consultant_remark,$arr_meal_type) = getUsersDailyMealsDetails($user_id,$meal_date);

	

	if(count($arr_user_meal_id) > 0)

	{

		for($i=0;$i<count($arr_user_meal_id);$i++)

		{

			if($arr_meal_type[$i] == 'breakfast')

			{

				$prev_breakfast_record = true;

			}

			

			if($arr_meal_type[$i] == 'brunch')

			{

				$prev_brunch_record = true;

			}

			

			if($arr_meal_type[$i] == 'lunch')

			{

				$prev_lunch_record = true;

			}

			

			if($arr_meal_type[$i] == 'snacks')

			{

				$prev_snacks_record = true;

			}

			

			if($arr_meal_type[$i] == 'dinner')

			{

				$prev_dinner_record = true;

			}

		}

			

		if($prev_breakfast_record)

		{

			$breakfast_cnt = 0;

			$breakfast_totalRow = '0';

			$breakfast_item_id_arr = array();

			$breakfast_other_item_arr = array();

			$breakfast_quantity_arr = array();

			$breakfast_measure_arr = array();

			$breakfast_meal_like_arr = array();

			$breakfast_consultant_remark_arr = array();

			

			for($i=0;$i<count($arr_user_meal_id);$i++)

			{

				if($arr_meal_type[$i] == 'breakfast')

				{

					$breakfast_time = $arr_meal_time[$i];

					array_push($breakfast_item_id_arr,$arr_meal_id[$i]);

					array_push($breakfast_quantity_arr,$arr_meal_quantity[$i]);

					array_push($breakfast_measure_arr,$arr_meal_measure[$i]);

					array_push($breakfast_meal_like_arr,$arr_meal_like[$i]);

					array_push($breakfast_consultant_remark_arr,$arr_meal_consultant_remark[$i]);

					if($arr_meal_id[$i] == '') 

					{

						array_push($breakfast_prefill_arr ,'{}');

						array_push($breakfast_other_item_arr,'');

						array_push($tr_breakfast_other_item,'none');

					}

					elseif($arr_meal_id[$i] == '9999999999') 

					{

						$json = array();

						$json['value'] = $arr_meal_id[$i];

						$json['name'] = getDailyMealName($arr_meal_id[$i]);

						array_push($breakfast_prefill_arr ,json_encode($json));

						array_push($breakfast_other_item_arr,$arr_meal_others[$i]);

						array_push($tr_breakfast_other_item,'none');

					}

					else

					{ 

						$json = array();

						$json['value'] = $arr_meal_id[$i];

						$json['name'] = getDailyMealName($arr_meal_id[$i]);

						array_push($breakfast_prefill_arr ,json_encode($json));

						array_push($breakfast_other_item_arr,'');

						array_push($tr_breakfast_other_item,'none');

					}

					array_push($tr_err_breakfast,'none');

					array_push($err_breakfast,'');

					

					$breakfast_cnt++;

					$breakfast_totalRow++;

				}

			}

		}

		else

		{

			$breakfast_cnt = '1';

			$breakfast_totalRow = '1';

			$tr_err_breakfast[0] = 'none';

			$tr_breakfast_other_item[0] = 'none';

			$err_breakfast[0] = '';

			array_push($breakfast_prefill_arr ,'{}');

		}	

		

		if($prev_brunch_record)

		{

			$brunch_cnt = 0;

			$brunch_totalRow = '0';

			$brunch_item_id_arr = array();

			$brunch_other_item_arr = array();

			$brunch_quantity_arr = array();

			$brunch_measure_arr = array();

			$brunch_meal_like_arr = array();

			$brunch_consultant_remark_arr = array();

			

			for($i=0;$i<count($arr_user_meal_id);$i++)

			{

				if($arr_meal_type[$i] == 'brunch')

				{

					$brunch_time = $arr_meal_time[$i];

					array_push($brunch_item_id_arr,$arr_meal_id[$i]);

					array_push($brunch_quantity_arr,$arr_meal_quantity[$i]);

					array_push($brunch_measure_arr,$arr_meal_measure[$i]);

					array_push($brunch_meal_like_arr,$arr_meal_like[$i]);

					array_push($brunch_consultant_remark_arr,$arr_meal_consultant_remark[$i]);

					if($arr_meal_id[$i] == '') 

					{

						array_push($brunch_prefill_arr ,'{}');

						array_push($brunch_other_item_arr,'');

						array_push($tr_brunch_other_item,'none');

					}

					elseif($arr_meal_id[$i] == '9999999999') 

					{

						$json = array();

						$json['value'] = $arr_meal_id[$i];

						$json['name'] = getDailyMealName($arr_meal_id[$i]);

						array_push($brunch_prefill_arr ,json_encode($json));

						array_push($brunch_other_item_arr,$arr_meal_others[$i]);

						array_push($tr_brunch_other_item,'');

					}

					else

					{ 

						$json = array();

						$json['value'] = $arr_meal_id[$i];

						$json['name'] = getDailyMealName($arr_meal_id[$i]);

						array_push($brunch_prefill_arr ,json_encode($json));

						array_push($brunch_other_item_arr,'');

						array_push($tr_brunch_other_item,'none');

					}

					array_push($tr_err_brunch,'none');

					array_push($err_brunch,'');

					

					$brunch_cnt++;

					$brunch_totalRow++;

				}

			}

		}

		else

		{

			$brunch_cnt = '1';

			$brunch_totalRow = '1';

			$tr_err_brunch[0] = 'none';

			$tr_brunch_other_item[0] = 'none';

			$err_brunch[0] = '';

			array_push($brunch_prefill_arr ,'{}');

		

		}

		

		if($prev_lunch_record)

		{

			$lunch_cnt = 0;

			$lunch_totalRow = '0';

			$lunch_item_id_arr = array();

			$lunch_other_item_arr = array();

			$lunch_quantity_arr = array();

			$lunch_measure_arr = array();

			$lunch_meal_like_arr = array();

			$lunch_consultant_remark_arr = array();

			

			for($i=0;$i<count($arr_user_meal_id);$i++)

			{

				if($arr_meal_type[$i] == 'lunch')

				{

					$lunch_time = $arr_meal_time[$i];

					array_push($lunch_item_id_arr,$arr_meal_id[$i]);

					array_push($lunch_quantity_arr,$arr_meal_quantity[$i]);

					array_push($lunch_measure_arr,$arr_meal_measure[$i]);

					array_push($lunch_meal_like_arr,$arr_meal_like[$i]);

					array_push($lunch_consultant_remark_arr,$arr_meal_consultant_remark[$i]);

					if($arr_meal_id[$i] == '') 

					{

						array_push($lunch_prefill_arr ,'{}');

						array_push($lunch_other_item_arr,'');

						array_push($tr_lunch_other_item,'none');

					}

					elseif($arr_meal_id[$i] == '9999999999') 

					{

						$json = array();

						$json['value'] = $arr_meal_id[$i];

						$json['name'] = getDailyMealName($arr_meal_id[$i]);

						array_push($lunch_prefill_arr ,json_encode($json));

						array_push($lunch_other_item_arr,$arr_meal_others[$i]);

						array_push($tr_lunch_other_item,'');

					}

					else

					{ 

						$json = array();

						$json['value'] = $arr_meal_id[$i];

						$json['name'] = getDailyMealName($arr_meal_id[$i]);

						array_push($lunch_prefill_arr ,json_encode($json));

						array_push($lunch_other_item_arr,'');

						array_push($tr_lunch_other_item,'none');

					}

					array_push($tr_err_lunch,'none');

					array_push($err_lunch,'');

					

					$lunch_cnt++;

					$lunch_totalRow++;

				}

			}

		}

		else

		{

			$lunch_cnt = '1';

			$lunch_totalRow = '1';

			$tr_err_lunch[0] = 'none';

			$tr_lunch_other_item[0] = 'none';

			$err_lunch[0] = '';

			array_push($lunch_prefill_arr ,'{}');

		}

		

		if($prev_snacks_record)

		{

			$snacks_cnt = 0;

			$snacks_totalRow = '0';

			$snacks_item_id_arr = array();

			$snacks_other_item_arr = array();

			$snacks_quantity_arr = array();

			$snacks_measure_arr = array();

			$snacks_meal_like_arr = array();

			$snacks_consultant_remark_arr = array();

			

			for($i=0;$i<count($arr_user_meal_id);$i++)

			{

				if($arr_meal_type[$i] == 'snacks')

				{

					$snacks_time = $arr_meal_time[$i];

					array_push($snacks_item_id_arr,$arr_meal_id[$i]);

					array_push($snacks_quantity_arr,$arr_meal_quantity[$i]);

					array_push($snacks_measure_arr,$arr_meal_measure[$i]);

					array_push($snacks_meal_like_arr,$arr_meal_like[$i]);

					array_push($snacks_consultant_remark_arr,$arr_meal_consultant_remark[$i]);

					if($arr_meal_id[$i] == '') 

					{

						array_push($snacks_prefill_arr ,'{}');

						array_push($snacks_other_item_arr,'');

						array_push($tr_snacks_other_item,'none');

					}

					elseif($arr_meal_id[$i] == '9999999999') 

					{

						$json = array();

						$json['value'] = $arr_meal_id[$i];

						$json['name'] = getDailyMealName($arr_meal_id[$i]);

						array_push($snacks_prefill_arr ,json_encode($json));

						array_push($snacks_other_item_arr,$arr_meal_others[$i]);

						array_push($tr_snacks_other_item,'');

					}

					else

					{ 

						$json = array();

						$json['value'] = $arr_meal_id[$i];

						$json['name'] = getDailyMealName($arr_meal_id[$i]);

						array_push($snacks_prefill_arr ,json_encode($json));

						array_push($snacks_other_item_arr,'');

						array_push($tr_snacks_other_item,'none');

					}

					array_push($tr_err_snacks,'none');

					array_push($err_snacks,'');

					

					$snacks_cnt++;

					$snacks_totalRow++;

				}

			}

		}

		else

		{

			$snacks_cnt = '1';

			$snacks_totalRow = '1';

			$tr_err_snacks[0] = 'none';

			$tr_snacks_other_item[0] = 'none';

			$err_snacks[0] = '';

			array_push($snacks_prefill_arr ,'{}');

		}

		

		if($prev_dinner_record)

		{

			$dinner_cnt = 0;

			$dinner_totalRow = '0';

			$dinner_item_id_arr = array();

			$dinner_other_item_arr = array();

			$dinner_quantity_arr = array();

			$dinner_measure_arr = array();

			$dinner_meal_like_arr = array();

			$dinner_consultant_remark_arr = array();

			

			for($i=0;$i<count($arr_user_meal_id);$i++)

			{

				if($arr_meal_type[$i] == 'dinner')

				{

					$dinner_time = $arr_meal_time[$i];

					array_push($dinner_item_id_arr,$arr_meal_id[$i]);

					array_push($dinner_quantity_arr,$arr_meal_quantity[$i]);

					array_push($dinner_measure_arr,$arr_meal_measure[$i]);

					array_push($dinner_meal_like_arr,$arr_meal_like[$i]);

					array_push($dinner_consultant_remark_arr,$arr_meal_consultant_remark[$i]);

					if($arr_meal_id[$i] == '') 

					{

						array_push($dinner_prefill_arr ,'{}');

						array_push($dinner_other_item_arr,'');

						array_push($tr_dinner_other_item,'none');

					}

					elseif($arr_meal_id[$i] == '9999999999') 

					{

						$json = array();

						$json['value'] = $arr_meal_id[$i];

						$json['name'] = getDailyMealName($arr_meal_id[$i]);

						array_push($dinner_prefill_arr ,json_encode($json));

						array_push($dinner_other_item_arr,$arr_meal_others[$i]);

						array_push($tr_dinner_other_item,'');

					}

					else

					{ 

						$json = array();

						$json['value'] = $arr_meal_id[$i];

						$json['name'] = getDailyMealName($arr_meal_id[$i]);

						array_push($dinner_prefill_arr ,json_encode($json));

						array_push($dinner_other_item_arr,'');

						array_push($tr_dinner_other_item,'none');

					}

					array_push($tr_err_dinner,'none');

					array_push($err_dinner,'');

										

					$dinner_cnt++;

					$dinner_totalRow++;

				}

			}

		}

		else

		{

			$dinner_cnt = '1';

			$dinner_totalRow = '1';

			$tr_err_dinner[0] = 'none';

			$tr_dinner_other_item[0] = 'none';

			$err_dinner[0] = '';

			array_push($dinner_prefill_arr ,'{}');

		}



	}

	else

	{	

	

		$breakfast_cnt = '1';

		$breakfast_totalRow = '1';

		$brunch_cnt = '1';

		$brunch_totalRow = '1';

		$lunch_cnt = '1';

		$lunch_totalRow = '1';

		$snacks_cnt = '1';

		$snacks_totalRow = '1';

		$dinner_cnt = '1';

		$dinner_totalRow = '1';

		

		$tr_err_breakfast[0] = 'none';

		$tr_err_brunch[0] = 'none';

		$tr_err_lunch[0] = 'none';

		$tr_err_snacks[0] = 'none';

		$tr_err_dinner[0] = 'none';

		

		$tr_breakfast_other_item[0] = 'none';

		$tr_brunch_other_item[0] = 'none';

		$tr_lunch_other_item[0] = 'none';

		$tr_snacks_other_item[0] = 'none';

		$tr_dinner_other_item[0] = 'none';

		

		$err_breakfast[0] = '';

		$err_brunch[0] = '';

		$err_lunch[0] = '';

		$err_snacks[0] = '';

		$err_dinner[0] = '';

		

		array_push($breakfast_prefill_arr ,'{}');

		array_push($brunch_prefill_arr ,'{}');

		array_push($lunch_prefill_arr ,'{}');

		array_push($snacks_prefill_arr ,'{}');

		array_push($dinner_prefill_arr ,'{}');

	}

	

	$output_breakfast = '';

	$output_breakfast .= '<table width="500" border="0" cellspacing="0" cellpadding="0" id="tblbreakfast">';

	$output_breakfast .= '	<tr>';

	$output_breakfast .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td>';

	$output_breakfast .= '		<td width="400" height="35" align="left" valign="top">';

	$output_breakfast .= '			<select name="breakfast_time" id="breakfast_time">';

	$output_breakfast .= '				<option value="">Select Time</option>';

	$output_breakfast .= '				'.getTimeOptions($breakfast_start_time,$breakfast_end_time,$breakfast_time);

	$output_breakfast .= '			</select>';

	$output_breakfast .= '		</td>';

	$output_breakfast .= '	</tr>';

	$output_breakfast .= '	<tr id="tr_breakfast_time" style="display:none;" valign="top">';

	$output_breakfast .= '		<td align="left" height="30" colspan="2" class="err_msg" valign="top"><?php echo $err_breakfast_time;?></td>';

	$output_breakfast .= '	</tr>';

		

	for($i=0;$i<$breakfast_totalRow;$i++)

	{

	$output_breakfast .= '	<tr id="tr_breakfast_1_'.$i.'">';

	$output_breakfast .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td>';

	$output_breakfast .= '		<td width="400" height="35" align="left" valign="top">';

	$output_breakfast .= '			<input name="breakfast_item[]" type="text" class="input" id="breakfast_item_'.$i.'" value="'.$breakfast_item_arr[$i].'" />';

	$output_breakfast .= '		</td>';

	$output_breakfast .= '	</tr>';

	$output_breakfast .= '	<tr id="tr_breakfast_2_'.$i.'"  style="display:'.$tr_breakfast_other_item[$i].';">';

	$output_breakfast .= '		<td width="100" height="35" align="left" valign="top">&nbsp;</td>';

	$output_breakfast .= '		<td width="400" height="35" align="left" valign="top">';

	$output_breakfast .= '			<input name="breakfast_other_item[]" type="text" class="input" id="breakfast_other_item_'.$i.'" value="'.$breakfast_other_item_arr[$i].'" />';

	$output_breakfast .= '		</td>';

	$output_breakfast .= '	</tr>';

	$output_breakfast .= '	<tr id="tr_breakfast_3_'.$i.'">';

	$output_breakfast .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td>';

	$output_breakfast .= '		<td width="400" height="35" align="left" valign="top">';

	$output_breakfast .= '			<select name="breakfast_quantity[]" id="breakfast_quantity_'.$i.'">';

	$output_breakfast .= '				'.getMealQuantityOptions($breakfast_quantity_arr[$i]);

	$output_breakfast .= '			</select>';

	$output_breakfast .= '			<span id="spn_breakfast_'.$i.'"><strong>'.$breakfast_measure_arr[$i].'</strong></span>';

	$output_breakfast .= '			<input type="hidden" name="breakfast_measure[]" id="breakfast_measure_'.$i.'" value="'.$breakfast_measure_arr[$i].'" />';

	$output_breakfast .= '		</td>';

	$output_breakfast .= '	</tr>';

	$output_breakfast .= '	<tr id="tr_breakfast_4_'.$i.'">';

	$output_breakfast .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td>';

	$output_breakfast .= '		<td width="400" height="35" align="left" valign="top">';

	$output_breakfast .= '			<table width="400" border="0" cellspacing="0" cellpadding="0">';

	$output_breakfast .= '				<tr>';

	$output_breakfast .= '					<td width="50" height="35" align="left" valign="top">';

	$output_breakfast .= '						<select name="breakfast_meal_like[]" id="breakfast_meal_like_'.$i.'" onchange="toggleMealLikeIcon(\'breakfast\',\''.$i.'\');">';

	$output_breakfast .= 							getMealLikeOptions($breakfast_meal_like_arr[$i]);

	$output_breakfast .= '						</select>';

	$output_breakfast .= '					</td>';

	$output_breakfast .= '					<td width="300" height="35" align="left" valign="top" id="spn_breakfast_meal_like_icon_'.$i.'">'.getMealLikeIcon($breakfast_meal_like_arr[$i]).'</td>';

	$output_breakfast .= '			   </tr>';

	$output_breakfast .= '			</table>';

	$output_breakfast .= '		</td>';

	$output_breakfast .= '	</tr>';

	$output_breakfast .= '	<tr id="tr_breakfast_5_'.$i.'">';

	$output_breakfast .= '		<td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td>';

	$output_breakfast .= '		<td width="400" align="left" valign="top">';

	$output_breakfast .= '			<textarea name="breakfast_consultant_remark[]" id="breakfast_consultant_remark_'.$i.'" cols="25" rows="3">'.$breakfast_consultant_remark_arr[$i].'</textarea>';

	$output_breakfast .= '		</td>';

	$output_breakfast .= '	</tr>';

	$output_breakfast .= '	<tr id="tr_breakfast_6_'.$i.'" style="display:'.$tr_err_breakfast[$i].';" valign="top">';

	$output_breakfast .= '		<td align="left" colspan="2" class="err_msg" valign="top">'.$err_breakfast[$i].'</td>';

	$output_breakfast .= '	</tr>';

	$output_breakfast .= '	<tr id="tr_breakfast_7_'.$i.'">';

	$output_breakfast .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output_breakfast .= '	</tr>';

		if($i > 0)

		{ 

	$output_breakfast .= '	<tr id="tr_breakfast_8_'.$i.'">';

	$output_breakfast .= '		<td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'breakfast\',\''.$i.'\')"></td>';

	$output_breakfast .= '	</tr>';

	$output_breakfast .= '	<tr id="tr_breakfast_9_'.$i.'">';

	$output_breakfast .= '		<td align="right" colspan="2" valign="top">&nbsp;</td>';

	$output_breakfast .= '	</tr>';

		

		} 

	} 

	$output_breakfast .= '	<tr id="add_before_this_breakfast">';

	$output_breakfast .= '		<td width="100" height="30" align="left" valign="top">&nbsp;</td>';

	$output_breakfast .= '		<td width="400" height="30" align="left" valign="top"><input type="button" value="add more" id="addMoreBreakfast" name="addMoreBreakfast" /></td>';

	$output_breakfast .= '	</tr>';	

	$output_breakfast .= '</table>';	

	

	$breakfast_prefill_arr = implode("***",$breakfast_prefill_arr);	

	

	$output_brunch = '';

	$output_brunch .= '<table width="500" border="0" cellspacing="0" cellpadding="0" id="tblbrunch">';

	$output_brunch .= '	<tr>';

	$output_brunch .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td>';

	$output_brunch .= '		<td width="400" height="35" align="left" valign="top">';

	$output_brunch .= '			<select name="brunch_time" id="brunch_time">';

	$output_brunch .= '				<option value="">Select Time</option>';

	$output_brunch .= '				'.getTimeOptions($brunch_start_time,$brunch_end_time,$brunch_time);

	$output_brunch .= '			</select>';

	$output_brunch .= '		</td>';

	$output_brunch .= '	</tr>';

	$output_brunch .= '	<tr id="tr_brunch_time" style="display:none;" valign="top">';

	$output_brunch .= '		<td align="left" height="30" colspan="2" class="err_msg" valign="top"><?php echo $err_brunch_time;?></td>';

	$output_brunch .= '	</tr>';

		

	for($i=0;$i<$brunch_totalRow;$i++)

	{

	$output_brunch .= '	<tr id="tr_brunch_1_'.$i.'">';

	$output_brunch .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td>';

	$output_brunch .= '		<td width="400" height="35" align="left" valign="top">';

	$output_brunch .= '			<input name="brunch_item[]" type="text" class="input" id="brunch_item_'.$i.'" value="'.$brunch_item_arr[$i].'" />';

	$output_brunch .= '		</td>';

	$output_brunch .= '	</tr>';

	$output_brunch .= '	<tr id="tr_brunch_2_'.$i.'"  style="display:'.$tr_brunch_other_item[$i].';">';

	$output_brunch .= '		<td width="100" height="35" align="left" valign="top">&nbsp;</td>';

	$output_brunch .= '		<td width="400" height="35" align="left" valign="top">';

	$output_brunch .= '			<input name="brunch_other_item[]" type="text" class="input" id="brunch_other_item_'.$i.'" value="'.$brunch_other_item_arr[$i].'" />';

	$output_brunch .= '		</td>';

	$output_brunch .= '	</tr>';

	$output_brunch .= '	<tr id="tr_brunch_3_'.$i.'">';

	$output_brunch .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td>';

	$output_brunch .= '		<td width="400" height="35" align="left" valign="top">';

	$output_brunch .= '			<select name="brunch_quantity[]" id="brunch_quantity_'.$i.'">';

	$output_brunch .= '				'.getMealQuantityOptions($brunch_quantity_arr[$i]);

	$output_brunch .= '			</select>';

	$output_brunch .= '			<span id="spn_brunch_'.$i.'"><strong>'.$brunch_measure_arr[$i].'</strong></span>';

	$output_brunch .= '			<input type="hidden" name="brunch_measure[]" id="brunch_measure_'.$i.'" value="'.$brunch_measure_arr[$i].'" />';

	$output_brunch .= '		</td>';

	$output_brunch .= '	</tr>';

	$output_brunch .= '	<tr id="tr_brunch_4_'.$i.'">';

	$output_brunch .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td>';

	$output_brunch .= '		<td width="400" height="35" align="left" valign="top">';

	$output_brunch .= '			<table width="400" border="0" cellspacing="0" cellpadding="0">';

	$output_brunch .= '				<tr>';

	$output_brunch .= '					<td width="50" height="35" align="left" valign="top">';

	$output_brunch .= '						<select name="brunch_meal_like[]" id="brunch_meal_like_'.$i.'" onchange="toggleMealLikeIcon(\'brunch\',\''.$i.'\');">';

	$output_brunch .= 							getMealLikeOptions($brunch_meal_like_arr[$i]);

	$output_brunch .= '						</select>';

	$output_brunch .= '					</td>';

	$output_brunch .= '					<td width="300" height="35" align="left" valign="top" id="spn_brunch_meal_like_icon_'.$i.'">'.getMealLikeIcon($brunch_meal_like_arr[$i]).'</td>';

	$output_brunch .= '			   </tr>';

	$output_brunch .= '			</table>';

	$output_brunch .= '		</td>';

	$output_brunch .= '	</tr>';

	$output_brunch .= '	<tr id="tr_brunch_5_'.$i.'">';

	$output_brunch .= '		<td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td>';

	$output_brunch .= '		<td width="400" align="left" valign="top">';

	$output_brunch .= '			<textarea name="brunch_consultant_remark[]" id="brunch_consultant_remark_'.$i.'" cols="25" rows="3">'.$brunch_consultant_remark_arr[$i].'</textarea>';

	$output_brunch .= '		</td>';

	$output_brunch .= '	</tr>';

	$output_brunch .= '	<tr id="tr_brunch_6_'.$i.'" style="display:'.$tr_err_brunch[$i].';" valign="top">';

	$output_brunch .= '		<td align="left" colspan="2" class="err_msg" valign="top">'.$err_brunch[$i].'</td>';

	$output_brunch .= '	</tr>';

	$output_brunch .= '	<tr id="tr_brunch_7_'.$i.'">';

	$output_brunch .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output_brunch .= '	</tr>';

		if($i > 0)

		{ 

	$output_brunch .= '	<tr id="tr_brunch_8_'.$i.'">';

	$output_brunch .= '		<td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'brunch\',\''.$i.'\')"></td>';

	$output_brunch .= '	</tr>';

	$output_brunch .= '	<tr id="tr_brunch_9_'.$i.'">';

	$output_brunch .= '		<td align="right" colspan="2" valign="top">&nbsp;</td>';

	$output_brunch .= '	</tr>';	

		} 

	} 

	$output_brunch .= '	<tr id="add_before_this_brunch">';

	$output_brunch .= '		<td width="100" height="30" align="left" valign="top">&nbsp;</td>';

	$output_brunch .= '		<td width="400" height="30" align="left" valign="top"><input type="button" value="add more" id="addMoreBrunch" name="addMoreBrunch" /></td>';

								

	$output_brunch .= '	</tr>';	

	$output_brunch .= '</table>';	

	

	$brunch_prefill_arr = implode("***",$brunch_prefill_arr);

	

	$output_lunch = '';

	$output_lunch .= '<table width="500" border="0" cellspacing="0" cellpadding="0" id="tbllunch">';

	$output_lunch .= '	<tr>';

	$output_lunch .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td>';

	$output_lunch .= '		<td width="400" height="35" align="left" valign="top">';

	$output_lunch .= '			<select name="lunch_time" id="lunch_time">';

	$output_lunch .= '				<option value="">Select Time</option>';

	$output_lunch .= '				'.getTimeOptions($lunch_start_time,$lunch_end_time,$lunch_time);

	$output_lunch .= '			</select>';

	$output_lunch .= '		</td>';

	$output_lunch .= '	</tr>';

	$output_lunch .= '	<tr id="tr_lunch_time" style="display:none;" valign="top">';

	$output_lunch .= '		<td align="left" height="30" colspan="2" class="err_msg" valign="top"><?php echo $err_lunch_time;?></td>';

	$output_lunch .= '	</tr>';

		

	for($i=0;$i<$lunch_totalRow;$i++)

	{

	$output_lunch .= '	<tr id="tr_lunch_1_'.$i.'">';

	$output_lunch .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td>';

	$output_lunch .= '		<td width="400" height="35" align="left" valign="top">';

	$output_lunch .= '			<input name="lunch_item[]" type="text" class="input" id="lunch_item_'.$i.'" value="'.$lunch_item_arr[$i].'" />';

	$output_lunch .= '		</td>';

	$output_lunch .= '	</tr>';

	$output_lunch .= '	<tr id="tr_lunch_2_'.$i.'"  style="display:'.$tr_lunch_other_item[$i].';">';

	$output_lunch .= '		<td width="100" height="35" align="left" valign="top">&nbsp;</td>';

	$output_lunch .= '		<td width="400" height="35" align="left" valign="top">';

	$output_lunch .= '			<input name="lunch_other_item[]" type="text" class="input" id="lunch_other_item_'.$i.'" value="'.$lunch_other_item_arr[$i].'" />';

	$output_lunch .= '		</td>';

	$output_lunch .= '	</tr>';

	$output_lunch .= '	<tr id="tr_lunch_3_'.$i.'">';

	$output_lunch .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td>';

	$output_lunch .= '		<td width="400" height="35" align="left" valign="top">';

	$output_lunch .= '			<select name="lunch_quantity[]" id="lunch_quantity_'.$i.'">';

	$output_lunch .= '				'.getMealQuantityOptions($lunch_quantity_arr[$i]);

	$output_lunch .= '			</select>';

	$output_lunch .= '			<span id="spn_lunch_'.$i.'"><strong>'.$lunch_measure_arr[$i].'</strong></span>';

	$output_lunch .= '			<input type="hidden" name="lunch_measure[]" id="lunch_measure_'.$i.'" value="'.$lunch_measure_arr[$i].'" />';

	$output_lunch .= '		</td>';

	$output_lunch .= '	</tr>';

	$output_lunch .= '	<tr id="tr_lunch_4_'.$i.'">';

	$output_lunch .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td>';

	$output_lunch .= '		<td width="400" height="35" align="left" valign="top">';

	$output_lunch .= '			<table width="400" border="0" cellspacing="0" cellpadding="0">';

	$output_lunch .= '				<tr>';

	$output_lunch .= '					<td width="50" height="35" align="left" valign="top">';

	$output_lunch .= '						<select name="lunch_meal_like[]" id="lunch_meal_like_'.$i.'" onchange="toggleMealLikeIcon(\'lunch\',\''.$i.'\');">';

	$output_lunch .= 							getMealLikeOptions($lunch_meal_like_arr[$i]);

	$output_lunch .= '						</select>';

	$output_lunch .= '					</td>';

	$output_lunch .= '					<td width="300" height="35" align="left" valign="top" id="spn_lunch_meal_like_icon_'.$i.'">'.getMealLikeIcon($lunch_meal_like_arr[$i]).'</td>';

	$output_lunch .= '			   </tr>';

	$output_lunch .= '			</table>';

	$output_lunch .= '		</td>';

	$output_lunch .= '	</tr>';

	$output_lunch .= '	<tr id="tr_lunch_5_'.$i.'">';

	$output_lunch .= '		<td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td>';

	$output_lunch .= '		<td width="400" align="left" valign="top">';

	$output_lunch .= '			<textarea name="lunch_consultant_remark[]" id="lunch_consultant_remark_'.$i.'" cols="25" rows="3">'.$lunch_consultant_remark_arr[$i].'</textarea>';

	$output_lunch .= '		</td>';

	$output_lunch .= '	</tr>';

	$output_lunch .= '	<tr id="tr_lunch_6_'.$i.'" style="display:'.$tr_err_lunch[$i].';" valign="top">';

	$output_lunch .= '		<td align="left" colspan="2" class="err_msg" valign="top">'.$err_lunch[$i].'</td>';

	$output_lunch .= '	</tr>';

	$output_lunch .= '	<tr id="tr_lunch_7_'.$i.'">';

	$output_lunch .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output_lunch .= '	</tr>';

		if($i > 0)

		{ 

	$output_lunch .= '	<tr id="tr_lunch_8_'.$i.'">';

	$output_lunch .= '		<td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'lunch\',\''.$i.'\')"></td>';

	$output_lunch .= '	</tr>';

	$output_lunch .= '	<tr id="tr_lunch_9_'.$i.'">';

	$output_lunch .= '		<td align="right" colspan="2" valign="top">&nbsp;</td>';

	$output_lunch .= '	</tr>';	

		} 

	} 

	$output_lunch .= '	<tr id="add_before_this_lunch">';

	$output_lunch .= '		<td width="100" height="30" align="left" valign="top">&nbsp;</td>';

	$output_lunch .= '		<td width="400" height="30" align="left" valign="top"><input type="button" value="add more" id="addMoreLunch" name="addMoreLunch" /></td>';

	$output_lunch .= '	</tr>';	

	$output_lunch .= '</table>';	

	

	$lunch_prefill_arr = implode("***",$lunch_prefill_arr);

	

	$output_snacks = '';

	$output_snacks .= '<table width="500" border="0" cellspacing="0" cellpadding="0" id="tblsnacks">';

	$output_snacks .= '	<tr>';

	$output_snacks .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td>';

	$output_snacks .= '		<td width="400" height="35" align="left" valign="top">';

	$output_snacks .= '			<select name="snacks_time" id="snacks_time">';

	$output_snacks .= '				<option value="">Select Time</option>';

	$output_snacks .= '				'.getTimeOptions($snacks_start_time,$snacks_end_time,$snacks_time);

	$output_snacks .= '			</select>';

	$output_snacks .= '		</td>';

	$output_snacks .= '	</tr>';

	$output_snacks .= '	<tr id="tr_snacks_time" style="display:none;" valign="top">';

	$output_snacks .= '		<td align="left" height="30" colspan="2" class="err_msg" valign="top"><?php echo $err_snacks_time;?></td>';

	$output_snacks .= '	</tr>';

		

	for($i=0;$i<$snacks_totalRow;$i++)

	{

	$output_snacks .= '	<tr id="tr_snacks_1_'.$i.'">';

	$output_snacks .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td>';

	$output_snacks .= '		<td width="400" height="35" align="left" valign="top">';

	$output_snacks .= '			<input name="snacks_item[]" type="text" class="input" id="snacks_item_'.$i.'" value="'.$snacks_item_arr[$i].'" />';

	$output_snacks .= '		</td>';

	$output_snacks .= '	</tr>';

	$output_snacks .= '	<tr id="tr_snacks_2_'.$i.'"  style="display:'.$tr_snacks_other_item[$i].';">';

	$output_snacks .= '		<td width="100" height="35" align="left" valign="top">&nbsp;</td>';

	$output_snacks .= '		<td width="400" height="35" align="left" valign="top">';

	$output_snacks .= '			<input name="snacks_other_item[]" type="text" class="input" id="snacks_other_item_'.$i.'" value="'.$snacks_other_item_arr[$i].'" />';

	$output_snacks .= '		</td>';

	$output_snacks .= '	</tr>';

	$output_snacks .= '	<tr id="tr_snacks_3_'.$i.'">';

	$output_snacks .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td>';

	$output_snacks .= '		<td width="400" height="35" align="left" valign="top">';

	$output_snacks .= '			<select name="snacks_quantity[]" id="snacks_quantity_'.$i.'">';

	$output_snacks .= '				'.getMealQuantityOptions($snacks_quantity_arr[$i]);

	$output_snacks .= '			</select>';

	$output_snacks .= '			<span id="spn_snacks_'.$i.'"><strong>'.$snacks_measure_arr[$i].'</strong></span>';

	$output_snacks .= '			<input type="hidden" name="snacks_measure[]" id="snacks_measure_'.$i.'" value="'.$snacks_measure_arr[$i].'" />';

	$output_snacks .= '		</td>';

	$output_snacks .= '	</tr>';

	$output_snacks .= '	<tr id="tr_snacks_4_'.$i.'">';

	$output_snacks .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td>';

	$output_snacks .= '		<td width="400" height="35" align="left" valign="top">';

	$output_snacks .= '			<table width="400" border="0" cellspacing="0" cellpadding="0">';

	$output_snacks .= '				<tr>';

	$output_snacks .= '					<td width="50" height="35" align="left" valign="top">';

	$output_snacks .= '						<select name="snacks_meal_like[]" id="snacks_meal_like_'.$i.'" onchange="toggleMealLikeIcon(\'snacks\',\''.$i.'\');">';

	$output_snacks .= 							getMealLikeOptions($snacks_meal_like_arr[$i]);

	$output_snacks .= '						</select>';

	$output_snacks .= '					</td>';

	$output_snacks .= '					<td width="300" height="35" align="left" valign="top" id="spn_snacks_meal_like_icon_'.$i.'">'.getMealLikeIcon($snacks_meal_like_arr[$i]).'</td>';

	$output_snacks .= '			   </tr>';

	$output_snacks .= '			</table>';

	$output_snacks .= '		</td>';

	$output_snacks .= '	</tr>';

	$output_snacks .= '	<tr id="tr_snacks_5_'.$i.'">';

	$output_snacks .= '		<td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td>';

	$output_snacks .= '		<td width="400" align="left" valign="top">';

	$output_snacks .= '			<textarea name="snacks_consultant_remark[]" id="snacks_consultant_remark_'.$i.'" cols="25" rows="3">'.$snacks_consultant_remark_arr[$i].'</textarea>';

	$output_snacks .= '		</td>';

	$output_snacks .= '	</tr>';

	$output_snacks .= '	<tr id="tr_snacks_6_'.$i.'" style="display:'.$tr_err_snacks[$i].';" valign="top">';

	$output_snacks .= '		<td align="left" colspan="2" class="err_msg" valign="top">'.$err_snacks[$i].'</td>';

	$output_snacks .= '	</tr>';

	$output_snacks .= '	<tr id="tr_snacks_7_'.$i.'">';

	$output_snacks .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output_snacks .= '	</tr>';

		if($i > 0)

		{ 

	$output_snacks .= '	<tr id="tr_snacks_8_'.$i.'">';

	$output_snacks .= '		<td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'snacks\',\''.$i.'\')"></td>';

	$output_snacks .= '	</tr>';

	$output_snacks .= '	<tr id="tr_snacks_9_'.$i.'">';

	$output_snacks .= '		<td align="right" colspan="2" valign="top">&nbsp;</td>';

	$output_snacks .= '	</tr>';	

		} 

	} 

	$output_snacks .= '	<tr id="add_before_this_snacks">';

	$output_snacks .= '		<td width="100" height="30" align="left" valign="top">&nbsp;</td>';

	$output_snacks .= '		<td width="400" height="30" align="left" valign="top"><input type="button" value="add more" id="addMoreSnacks" name="addMoreSnacks" /></td>';

	$output_snacks .= '	</tr>';	

	$output_snacks .= '</table>';	

	

	$snacks_prefill_arr = implode("***",$snacks_prefill_arr);

	

	$output_dinner = '';

	$output_dinner .= '<table width="500" border="0" cellspacing="0" cellpadding="0" id="tbldinner">';

	$output_dinner .= '	<tr>';

	$output_dinner .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td>';

	$output_dinner .= '		<td width="400" height="35" align="left" valign="top">';

	$output_dinner .= '			<select name="dinner_time" id="dinner_time">';

	$output_dinner .= '				<option value="">Select Time</option>';

	$output_dinner .= '				'.getTimeOptions($dinner_start_time,$dinner_end_time,$dinner_time);

	$output_dinner .= '			</select>';

	$output_dinner .= '		</td>';

	$output_dinner .= '	</tr>';

	$output_dinner .= '	<tr id="tr_dinner_time" style="display:none;" valign="top">';

	$output_dinner .= '		<td align="left" height="30" colspan="2" class="err_msg" valign="top"><?php echo $err_dinner_time;?></td>';

	$output_dinner .= '	</tr>';

		

	for($i=0;$i<$dinner_totalRow;$i++)

	{

	$output_dinner .= '	<tr id="tr_dinner_1_'.$i.'">';

	$output_dinner .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Item:</td>';

	$output_dinner .= '		<td width="400" height="35" align="left" valign="top">';

	$output_dinner .= '			<input name="dinner_item[]" type="text" class="input" id="dinner_item_'.$i.'" value="'.$dinner_item_arr[$i].'" />';

	$output_dinner .= '		</td>';

	$output_dinner .= '	</tr>';

	$output_dinner .= '	<tr id="tr_dinner_2_'.$i.'"  style="display:'.$tr_dinner_other_item[$i].';">';

	$output_dinner .= '		<td width="100" height="35" align="left" valign="top">&nbsp;</td>';

	$output_dinner .= '		<td width="400" height="35" align="left" valign="top">';

	$output_dinner .= '			<input name="dinner_other_item[]" type="text" class="input" id="dinner_other_item_'.$i.'" value="'.$dinner_other_item_arr[$i].'" />';

	$output_dinner .= '		</td>';

	$output_dinner .= '	</tr>';

	$output_dinner .= '	<tr id="tr_dinner_3_'.$i.'">';

	$output_dinner .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Quantity:</td>';

	$output_dinner .= '		<td width="400" height="35" align="left" valign="top">';

	$output_dinner .= '			<select name="dinner_quantity[]" id="dinner_quantity_'.$i.'">';

	$output_dinner .= '				'.getMealQuantityOptions($dinner_quantity_arr[$i]);

	$output_dinner .= '			</select>';

	$output_dinner .= '			<span id="spn_dinner_'.$i.'"><strong>'.$dinner_measure_arr[$i].'</strong></span>';

	$output_dinner .= '			<input type="hidden" name="dinner_measure[]" id="dinner_measure_'.$i.'" value="'.$dinner_measure_arr[$i].'" />';

	$output_dinner .= '		</td>';

	$output_dinner .= '	</tr>';

	$output_dinner .= '	<tr id="tr_dinner_4_'.$i.'">';

	$output_dinner .= '		<td width="100" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; My Desire:</td>';

	$output_dinner .= '		<td width="400" height="35" align="left" valign="top">';

	$output_dinner .= '			<table width="400" border="0" cellspacing="0" cellpadding="0">';

	$output_dinner .= '				<tr>';

	$output_dinner .= '					<td width="50" height="35" align="left" valign="top">';

	$output_dinner .= '						<select name="dinner_meal_like[]" id="dinner_meal_like_'.$i.'" onchange="toggleMealLikeIcon(\'dinner\',\''.$i.'\');">';

	$output_dinner .= 							getMealLikeOptions($dinner_meal_like_arr[$i]);

	$output_dinner .= '						</select>';

	$output_dinner .= '					</td>';

	$output_dinner .= '					<td width="300" height="35" align="left" valign="top" id="spn_dinner_meal_like_icon_'.$i.'">'.getMealLikeIcon($dinner_meal_like_arr[$i]).'</td>';

	$output_dinner .= '			   </tr>';

	$output_dinner .= '			</table>';

	$output_dinner .= '		</td>';

	$output_dinner .= '	</tr>';

	$output_dinner .= '	<tr id="tr_dinner_5_'.$i.'">';

	$output_dinner .= '		<td width="100" align="left" valign="top">&nbsp;&nbsp;&bull; Item Remarks:</td>';

	$output_dinner .= '		<td width="400" align="left" valign="top">';

	$output_dinner .= '			<textarea name="dinner_consultant_remark[]" id="dinner_consultant_remark_'.$i.'" cols="25" rows="3">'.$dinner_consultant_remark_arr[$i].'</textarea>';

	$output_dinner .= '		</td>';

	$output_dinner .= '	</tr>';

	$output_dinner .= '	<tr id="tr_dinner_6_'.$i.'" style="display:'.$tr_err_dinner[$i].';" valign="top">';

	$output_dinner .= '		<td align="left" colspan="2" class="err_msg" valign="top">'.$err_dinner[$i].'</td>';

	$output_dinner .= '	</tr>';

	$output_dinner .= '	<tr id="tr_dinner_7_'.$i.'">';

	$output_dinner .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output_dinner .= '	</tr>';

		if($i > 0)

		{ 

	$output_dinner .= '	<tr id="tr_dinner_8_'.$i.'">';

	$output_dinner .= '		<td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMealRow(\'dinner\',\''.$i.'\')"></td>';

	$output_dinner .= '	</tr>';

	$output_dinner .= '	<tr id="tr_dinner_9_'.$i.'">';

	$output_dinner .= '		<td align="right" colspan="2" valign="top">&nbsp;</td>';

	$output_dinner .= '	</tr>';	

		} 

	} 

	$output_dinner .= '	<tr id="add_before_this_dinner">';

	$output_dinner .= '		<td width="100" height="30" align="left" valign="top">&nbsp;</td>';

	$output_dinner .= '		<td width="400" height="30" align="left" valign="top"><input type="button" value="add more" id="addMoreDinner" name="addMoreDinner" /></td>';

	$output_dinner .= '	</tr>';	

	$output_dinner .= '</table>';	

	

	$dinner_prefill_arr = implode("***",$dinner_prefill_arr);

	

	//debug_array($dinner_prefill_arr);

	

	echo $output_breakfast.'####'.$breakfast_totalRow.'####'.$breakfast_prefill_arr.'####'.$output_brunch.'####'.$brunch_totalRow.'####'.$brunch_prefill_arr.'####'.$output_lunch.'####'.$lunch_totalRow.'####'.$lunch_prefill_arr.'####'.$output_snacks.'####'.$snacks_totalRow.'####'.$snacks_prefill_arr.'####'.$output_dinner.'####'.$dinner_totalRow.'####'.$dinner_prefill_arr;

}
elseif($action == 'getaddmorebes')
{
    $cnt = stripslashes($_REQUEST['cnt']);
    
    $add_more_string = '<tr id="tr_bes_1_'.$cnt.'" class="tr_bes_'.$cnt.'"><td width="150" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td><td width="400" height="35" align="left" valign="top"><select name="bes_time[]" id="bes_time_'.$cnt.'"><option value="">Select Time</option>'.getTimeOptionsNew(0,23,'').'</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;Duration in Mins:&nbsp;&nbsp<input style="width:30px;" type="text" maxlength="3" name="bes_duration[]" id="bes_duration_'.$cnt.'" value="" class="mins"></td></tr>'
        . '<tr id="tr_bes_2_'.$cnt.'" class="tr_bes_'.$cnt.'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>'
        . '<tr id="tr_bes_3_'.$cnt.'" class="tr_bes_'.$cnt.'"><td height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Emotional State:</td><td height="35" align="left" valign="top"><input name="bes_id[]" type="text" class="input" id="bes_id_'.$cnt.'" value="" /></td></tr>'
        . '<tr id="tr_bes_4_'.$cnt.'" class="tr_bes_'.$cnt.'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>'
        . '<tr id="tr_bes_5_'.$cnt.'" class="tr_bes_'.$cnt.'"><td height="37" align="left" valign="top">&nbsp;&bull; My Scale:</td><td height="37" align="left" valign="top" background="images/blank_slider.jpg" style="background-repeat:no-repeat;">';

$add_more_string .= getScaleSliderCode($cnt,'','none','');




$add_more_string .= '</td></tr>'
        . '<tr id="tr_bes_6_'.$cnt.'" class="tr_bes_'.$cnt.'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>'
        . '<tr id="tr_bes_7_'.$cnt.'" class="tr_bes_'.$cnt.'"><td align="left" valign="top">&nbsp;&nbsp;&bull; Triggers/Reasons:</td><td align="left" valign="top">';


$add_more_string .= '<div class="tr_response_slider_'.$cnt.'" style="display:none;"><textarea name="remarks[]" id="remarks_'.$cnt.'" cols="25" rows="3"></textarea></div>';
$add_more_string .= '<div class="tr_response_img_'.$cnt.'" style="display:;"><textarea name="remarks2[]" id="remarks2_'.$cnt.'" cols="25" rows="3" disabled></textarea></div>';

        
        $add_more_string .= '        </td></tr>'
        . '<tr id="tr_bes_8_'.$cnt.'" class="tr_bes_'.$cnt.'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>'
        . '<tr id="tr_bes_9_'.$cnt.'" class="tr_bes_'.$cnt.'"><td align="left" colspan="2" valign="top"><table width="560" border="0" cellspacing="0" cellpadding="0"><tr><td width="150" align="left" valign="top">&nbsp;&bull; My Target:</td><td width="130" align="left" valign="top">';
        
$add_more_string .= '<div class="tr_response_slider_'.$cnt.'" style="display:none;"><select name="my_target[]" id="my_target_'.$cnt.'"><option value="" selected="selected" >Select</option>';

for($j=1;$j<=10;$j++) 
{ 
    $add_more_string .= '<option value="'.$j.'" >'.$j.'</option>';
    
} 
    $add_more_string .= '</select><br></div>';
    
    
$add_more_string .= '<div class="tr_response_img_'.$cnt.'" style="display:;"><select name="my_target2[]" id="my_target2_'.$cnt.'" disabled><option value="" selected="selected" >Select</option>';

for($j=1;$j<=10;$j++) 
{ 
    $add_more_string .= '<option value="'.$j.'" >'.$j.'</option>';
    
} 
    $add_more_string .= '</select><br></div>';    
    
    
    
    
    $add_more_string .= '</td><td width="130" align="left" valign="top">&nbsp;&bull; Adviser Set Target:</td><td width="150" align="left" valign="top">';
    
    
    $add_more_string .= '<div class="tr_response_slider_'.$cnt.'" style="display:none;"><select name="adviser_target[]" id="adviser_target_'.$cnt.'"><option value="" selected="selected" >Select</option>';
    
    for($j=1;$j<=10;$j++) 
    { 
        $add_more_string .= '<option value="'.$j.'" >'.$j.'</option>';
        
    } 
    $add_more_string .= '</select></div>';
    
    $add_more_string .= '<div class="tr_response_img_'.$cnt.'" style="display:;"><select name="adviser_target2[]" id="adviser_target2_'.$cnt.'" disabled><option value="" selected="selected" >Select</option>';
    
    for($j=1;$j<=10;$j++) 
    { 
        $add_more_string .= '<option value="'.$j.'" >'.$j.'</option>';
        
    } 
    $add_more_string .= '</select></div>';
    
    
    
    $add_more_string .= '</td></tr></table></td></tr>'
            . '<tr id="tr_bes_10_'.$cnt.'" class="tr_bes_'.$cnt.'"><td align="left" colspan="2" class="err_msg" valign="top"></td></tr>'
        . '<tr id="tr_bes_11_'.$cnt.'" class="tr_bes_'.$cnt.'"><td align="left" colspan="2" valign="top">&nbsp;</td></tr>'
            . '<tr id="tr_bes_12_'.$cnt.'" class="tr_bes_'.$cnt.'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMultipleRows(\'tr_bes_'.$cnt.'\',\'totalRow\')" /></td></tr><tr id="tr_bes_13_'.$cnt.'" class="tr_bes_'.$cnt.'"><td height="30" align="left" colspan="2" valign="top">&nbsp;</td></tr>';
    
    echo $add_more_string;
    
}
elseif($action == 'getaddmorebesnew')
{
   
    $cnt = stripslashes($_REQUEST['cnt']);
    $t = $cnt + 1;
    $add_more_string = '';
    $add_more_string .= '<tr class="tr_bes_'.$cnt.'"><td height="35" align="left" valign="top">('.$t.')</td><td height="35" align="left" valign="top"><input name="bes_id[]" type="text" class="input" id="bes_id_'.$cnt.'" value="" /></td><td height="35" align="left" valign="top">';
    $add_more_string .= getScaleSliderCode($cnt,'','none','');
    $add_more_string .= '</td><td height="35" align="right" valign="top"><a href="javascript:;" onclick="removeMultipleRows(\'tr_bes_'.$cnt.'\',\'totalRow\');"><img border="0" style="margin-top:5px;padding-right:5px;" src="images/delete-icon.png" height="20" alt="Remove Entry" title="Remove Entry"  ></a></td></tr>';
    $add_more_string .= '<tr class="tr_bes_'.$cnt.'"><td align="left" height="10" colspan="4" valign="top"><img src="images/spacer.gif" width="1" height="1" /></td></tr>';
    //$add_more_string .= '<tr class="tr_bes_'.$cnt.'"><td align="right" colspan="3" valign="top"><input type="button" value="Remove Entry" onclick="removeMultipleRows(\'tr_bes_'.$cnt.'\',\'totalRow\')"/></td></tr>';
    //$add_more_string .= '<tr class="tr_bes_'.$cnt.'"><td align="left" height="10" colspan="3" valign="top"><img src="images/spacer.gif" width="1" height="1" /></td></tr>';
     
    echo $add_more_string;
    
}
elseif($action == 'addmoretrigger')
{
    $cnt = stripslashes($_REQUEST['cnt']);
    $t = $cnt + 1;
    $add_more_string = '';
    $add_more_string .= '<tr class="tr_trigger_'.$cnt.'"><td height="35" align="left" valign="top">('.$t.')</td>';
    $add_more_string .= '<td height="35" align="left" valign="top"><input name="trigger_id[]" type="text" class="input" id="trigger_id_'.$cnt.'" value="" /></td>';
    $add_more_string .= '<td height="35" align="left" valign="top">';
    $add_more_string .= getScaleSliderCodeSecond($cnt,'','none','');
    $add_more_string .= '</td>';
    $add_more_string .= '<td height="35" align="left" valign="top"><input name="remarks_t[]" type="hidden" id="remarks_t_'.$cnt.'" value="" /><a href="javascript:;" onclick="showTriggerRemarksPopup(\''.$cnt.'\')"><img border="0" style="" style="" src="images/comment-bubble-icon.png" width="30" alt="Add comments for this trigger" title="Add comments for this trigger"  ></a></td>';
    $add_more_string .= '<td height="35" align="left" valign="top"><a href="javascript:;" onclick="removeMultipleRows(\'tr_trigger_'.$cnt.'\',\'totalRow_t\');"><img border="0" style="margin-top:5px;" src="images/delete-icon.png" height="20" alt="Remove Entry" title="Remove Entry"  ></a></td>';
    $add_more_string .= '</tr>';
    $add_more_string .= '<tr class="tr_trigger_'.$cnt.'"><td align="left" height="10" colspan="5" valign="top"><img src="images/spacer.gif" width="1" height="1" /></td></tr>';
    //$add_more_string .= '<tr class="tr_trigger_'.$cnt.'"><td align="right" colspan="3" valign="top"><input type="button" value="Remove Entry" onclick="removeMultipleRows(\'tr_trigger_'.$cnt.'\',\'totalRow_t\')" /></td></tr>';
    //$add_more_string .= '<tr class="tr_trigger_'.$cnt.'"><td align="left" height="10" colspan="3" valign="top"><img src="images/spacer.gif" width="1" height="1" /></td></tr>';
    
    echo $add_more_string;
    
}
elseif($action == 'addmorerowsautosuggest')
{
    $cnt = stripslashes($_REQUEST['cnt']);
    $idval = stripslashes($_REQUEST['idval']);
    $rowtype = stripslashes($_REQUEST['rowtype']);
    $t = $cnt + 1;
    
    if($rowtype == 'trigger')
    {
        $add_more_string = '';
        $add_more_string .= '<tr class="tr_trigger_'.$idval.'_'.$cnt.'"><td height="35" align="left" valign="top">('.$t.')</td>';
        $add_more_string .= '<td height="35" align="left" valign="top"><input name="trigger_id_edit[]" type="text" class="input" id="trigger_id_'.$idval.'_'.$cnt.'" value="" /></td>';
        $add_more_string .= '<td height="35" align="left" valign="top">';
        $add_more_string .= getScaleSliderCodeSecondMultiLevel($idval.'_'.$cnt,'','none','');
        $add_more_string .= '</td>';
        $add_more_string .= '<td height="35" align="left" valign="top"><input name="remarks_t_'.$idval.'_'.$cnt.'" type="hidden" id="remarks_t_'.$idval.'_'.$cnt.'" value="" /><a href="javascript:;" onclick="showTriggerRemarksPopup(\''.$idval.'_'.$cnt.'\')"><img border="0" style="" style="" src="images/comment-bubble-icon.png" width="30" alt="Add comments for this trigger" title="Add comments for this trigger"  ></a></td>';
        $add_more_string .= '<td height="35" align="left" valign="top"><a href="javascript:;" onclick="removeMultipleRows(\'tr_trigger_'.$idval.'_'.$cnt.'\',\'totalRow_t_'.$idval.'\');"><img border="0" style="margin-top:5px;" src="images/delete-icon.png" height="20" alt="Remove Entry" title="Remove Entry"  ></a></td>';
        $add_more_string .= '</tr>';
        $add_more_string .= '<tr class="tr_trigger_'.$cnt.'"><td align="left" height="10" colspan="5" valign="top"><img src="images/spacer.gif" width="1" height="1" /></td></tr>';
    }
    else
    {
        $add_more_string = '';
        $add_more_string .= '<tr class="tr_bes_'.$idval.'_'.$cnt.'"><td height="35" align="left" valign="top">('.$t.')</td>';
        $add_more_string .= '<td height="35" align="left" valign="top"><input name="bes_id_edit[]" type="text" class="input" id="bes_id_'.$idval.'_'.$cnt.'" value="" /></td>';
        $add_more_string .= '<td height="35" align="left" valign="top">';
        $add_more_string .= getScaleSliderCodeMultiLevel($idval.'_'.$cnt,'','none','');
        $add_more_string .= '</td>';
        $add_more_string .= '<td height="35" align="right" valign="top"><a href="javascript:;" onclick="removeMultipleRows(\'tr_bes_'.$idval.'_'.$cnt.'\',\'totalRow_'.$idval.'\');"><img border="0" style="margin-top:5px;padding-right:5px;" src="images/delete-icon.png" height="20" alt="Remove Entry" title="Remove Entry"  ></a></td></tr>';
        $add_more_string .= '<tr class="tr_bes_'.$idval.'_'.$cnt.'"><td align="left" height="10" colspan="4" valign="top"><img src="images/spacer.gif" width="1" height="1" /></td></tr>';
    }
    
    
    echo $add_more_string;
    
}
elseif($action == 'getallbmsautolist')
{
    $output = '{items:'.getAllBMSAutoList().'}';
    echo $output;
}
elseif($action == 'getaddmorebps')
{
    $cnt = stripslashes($_REQUEST['cnt']);
    $bms_id_arr = array(); 
    
    //$add_more_string = '<tr id="tr_bps_1_'.$cnt.'" class="tr_bps_'.$cnt.'"><td height="35" align="left" valign="top">Physical State:</td></tr>';
    $add_more_string .= '<tr id="tr_bps_1_'.$cnt.'" class="tr_bps_'.$cnt.'"><td colspan="2" height="35" align="left" valign="top">';
    $add_more_string .= '<select name="bms_id[]" id="bms_id_'.$cnt.'" style="width:180px;" onchange="toggleMyResponseScaleSelectBox(\'bms_id_\',\''.$cnt.'\');"><option value="" selected="selected" >Select</option>';
    $add_more_string .= getUserBodySymptomsOptionsMulti($bms_id_arr,'1');;
    $add_more_string .= '</select><br><span style="font-size:11px;color:#0000FF;">(Select Physical State)</span>';
    $add_more_string .= '</td></tr>';
    $add_more_string .= '<tr id="tr_bps_2_'.$cnt.'" class="tr_bps_'.$cnt.'"><td width="50" height="37" align="left" valign="top">Scale:</td>';
    $add_more_string .= '<td width="250" height="37" align="left" valign="top" background="images/blank_slider.jpg" style="background-repeat:no-repeat;">';
    $add_more_string .= getScaleSliderCode($cnt,'','none','');
    $add_more_string .= '</td></tr>';
    //$add_more_string .= '<tr id="tr_bps_5_'.$cnt.'" class="tr_bps_'.$cnt.'"><td align="left" valign="top">&nbsp;</td></tr>';
    $add_more_string .= '<tr id="tr_bps_3_'.$cnt.'" class="tr_bps_'.$cnt.'"><td colspan="2" align="right" valign="top"><input type="button" value="Remove Item" onclick="removeMultipleRows(\'tr_bps_'.$cnt.'\',\'totalRow\')" /></td></tr>';
    //$add_more_string .= '<tr id="tr_bps_7_'.$cnt.'" class="tr_bps_'.$cnt.'"><td align="left" height="30" valign="top">&nbsp;</td></tr>';
    echo $add_more_string;
    
}
elseif($action == 'getusersbesdetails')
{
	$day = stripslashes($_REQUEST['day']);
	$month = stripslashes($_REQUEST['month']);
	$year = stripslashes($_REQUEST['year']);
	$user_id = $_SESSION['user_id'];

	$bes_date = $year.'-'.$month.'-'.$day;
        
        $error = false;
        $tr_err_bes_date = 'none';
        $tr_err_bes = array();
        $err_bes_date = '';
        $err_bes = array();
        $tr_response_img = array();
        $tr_response_slider = array();

        $bes_prefill_arr = array();
        $bms_id_arr = array();

	list($bms_id_arr,$scale_arr,$remarks_arr,$bes_time_arr,$bes_duration_arr,$my_target_arr,$adviser_target_arr) = getUsersBESDetails($user_id,$bes_date);
    
        if(count($bms_id_arr)> 0)
        {
            for($i=0;$i<count($bms_id_arr);$i++)
            {
                $tr_response_img[$i] = '';
                $tr_response_slider[$i] = 'none';

                $json = array();
                $json['value'] = $bms_id_arr[$i];
                $json['name'] = getBobyMainSymptomName($bms_id_arr[$i]);
                array_push($bes_prefill_arr ,json_encode($json));
            }

            $cnt = count($bms_id_arr);
            $totalRow = count($bms_id_arr);
        }
        else
        {
            $cnt = '1';
            $totalRow = '1';
            $tr_err_bes[0] = 'none';
            $tr_other_activity[0] = 'none';
            $err_bes[0] = '';
            array_push($bes_prefill_arr ,'{}');
            $tr_response_img[0] = '';
            $tr_response_slider[0] = 'none';
        }

	$output = '';
	$output .= '<table width="550" border="0" cellspacing="0" cellpadding="0" id="tblbes">';
	
	for($i=0;$i<$totalRow;$i++)
	{
	$output .= '<tr id="tr_bes_1_'.$i.'" class="tr_bes_'.$i.'">
                        <td width="150" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td>
                        <td width="400" height="35" align="left" valign="top">
                            <select name="bes_time[]" id="bes_time_'.$i.'">
                                <option value="">Select Time</option>'.getTimeOptionsNew('0','23',$bes_time_arr[$i] ).'</select>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;Duration in Mins:&nbsp;&nbsp<input style="width:30px;" type="text" maxlength="3" name="bes_duration[]" id="bes_duration_'.$i.'" value="'.$bes_duration_arr[$i].'" class="mins">
                        </td>
                    </tr>
                    <tr id="tr_bes_2_'.$i.'" class="tr_bes_'.$i.'">
                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                    </tr>
                    <tr id="tr_bes_3_'.$i.'" class="tr_bes_'.$i.'">
                        <td height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Emotional State:</td>
                        <td height="35" align="left" valign="top">
                            <input name="bes_id[]" type="text" class="input" id="bes_id_'.$i.'" value="'.$bms_id_arr[$i].'" />
                        </td>
                    </tr>
                    <tr id="tr_bes_4_'.$i.'" class="tr_bes_'.$i.'">
                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                    </tr>
                    <tr id="tr_bes_5_'.$i.'" class="tr_bes_'.$i.'">
                        <td height="37" align="left" valign="top">&nbsp;&bull; My Scale:</td>
                        <td height="37" align="left" valign="top" background="images/blank_slider.jpg" style="background-repeat:no-repeat;">';
                            $output .= getScaleSliderCode($i,$tr_response_img[$i],$tr_response_slider[$i],$scale_arr[$i]);
        
                           
        $output .= '                    													  
                        </td>
                    </tr>
                    <tr id="tr_bes_6_'.$i.'" class="tr_bes_'.$i.'">
                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                    </tr>
                    <tr id="tr_bes_7_'.$i.'" class="tr_bes_'.$i.'">
                        <td align="left" valign="top">&nbsp;&nbsp;&bull; Remarks:</td>
                        <td align="left" valign="top">
                            <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'"><textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea></div>
                            <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'"><textarea name="remarks2[]" id="remarks2_'.$i.'" cols="25" rows="3" disabled>'.$remarks_arr[$i].'</textarea></div>
                        </td>
                    </tr>
                    <tr id="tr_bes_8_'.$i.'" class="tr_bes_'.$i.'">
                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                    </tr>
                    <tr id="tr_bes_9_'.$i.'" class="tr_bes_'.$i.'">
                        <td align="left" colspan="2" valign="top">
                            <table width="550" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="150" align="left" valign="top">&nbsp;&bull; My Target:</td>
                                    <td width="130" align="left" valign="top">';
        
        $output .= '                    <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'">
                                        <select name="my_target[]" id="my_target_'.$i.'">';
                                        if($my_target_arr[$i] == "") 
                                        { 
                                            $sel2 = ' selected="selected" ';       
                                        }
                                        else
                                        {
                                            $sel2 = '';
                                        }
        
        $output .= '                        <option value="" '.$sel2.' >Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        { 
                                             if($my_target_arr[$i] == $j) 
                                            { 
                                                $sel2 = ' selected="selected" ';       
                                            }
                                            else
                                            {
                                                $sel2 = '';
                                            }
                                        
        $output .= '                        <option value="'.$j.'" '.$sel2.'>'.$j.'</option>';
                                        }     
        $output .= '                    </select><br></div>';
        
        $output .= '                    <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'">
                                        <select name="my_target2[]" id="my_target2_'.$i.'" disabled>';
                                        if($my_target_arr[$i] == "") 
                                        { 
                                            $sel2 = ' selected="selected" ';       
                                        }
                                        else
                                        {
                                            $sel2 = '';
                                        }
        
        $output .= '                        <option value="" '.$sel2.' >Select</option>';
                                        for($j=1;$j<=10;$j++)
                                        { 
                                             if($my_target_arr[$i] == $j) 
                                            { 
                                                $sel2 = ' selected="selected" ';       
                                            }
                                            else
                                            {
                                                $sel2 = '';
                                            }
                                        
        $output .= '                        <option value="'.$j.'" '.$sel2.'>'.$j.'</option>';
                                        }     
        $output .= '                    </select><br></div>';
        
        
        $output .= '                </td>
                                    <td width="130" align="left" valign="top">&nbsp;&bull; Adviser Set Target:</td>
                                    <td width="140" align="left" valign="top">';
        
        $output .= '                <div class="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'">
                                        <select name="adviser_target[]" id="adviser_target_'.$i.'">';
                                        if($adviser_target_arr[$i] == "") 
                                        { 
                                            $sel3 = ' selected="selected" ';       
                                        }
                                        else
                                        {
                                            $sel3 = '';
                                        }    
        $output .= '                                    <option value="" '.$sel3.'>Select</option>';
                                        
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            { 
                                                $sel3 = ' selected="selected" ';       
                                            }
                                            else
                                            {
                                                $sel3 = '';
                                            }
                                         
        $output .= '                                    <option value="'.$j.'" '.$sel3.' >'.$j.'</option>';
                                        
                                        }     
        $output .= '                    </select><br></div>';
        
        $output .= '                <div class="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'">
                                        <select name="adviser_target2[]" id="adviser_target2_'.$i.'" disabled>';
                                        if($adviser_target_arr[$i] == "") 
                                        { 
                                            $sel3 = ' selected="selected" ';       
                                        }
                                        else
                                        {
                                            $sel3 = '';
                                        }    
        $output .= '                                    <option value="" '.$sel3.'>Select</option>';
                                        
                                        for($j=1;$j<=10;$j++)
                                        {
                                            if($adviser_target_arr[$i] == $j) 
                                            { 
                                                $sel3 = ' selected="selected" ';       
                                            }
                                            else
                                            {
                                                $sel3 = '';
                                            }
                                         
        $output .= '                                    <option value="'.$j.'" '.$sel3.' >'.$j.'</option>';
                                        
                                        }     
        $output .= '                    </select><br></div>';
        
        
        $output .= '                            </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr id="tr_bes_10_'.$i.'" class="tr_bes_'.$i.'">
                        <td align="left" colspan="2" class="err_msg" valign="top">'.$err_bes[$i].'</td>
                    </tr>
                    <tr id="tr_bes_11_'.$i.'" class="tr_bes_'.$i.'">
                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                    </tr>';

                    if($i > 0)
                    { 
        $output .= ' <tr id="tr_bes_12_'.$i.'" class="tr_bes_'.$i.'">
                        <td align="right" colspan="2" valign="top">
                            <input type="button" value="Remove Item" onclick="removeMultipleRows(\'tr_bes_'.$i.'\',\'totalRow\')"/>
                        </td>
                    </tr>
                    <tr id="tr_bes_13_'.$i.'" class="tr_bes_'.$i.'">
                        <td height="30" align="left" colspan="2" valign="top">&nbsp;</td>
                    </tr>';
                    } 
	} 
	$output .= '	<tr id="add_before_this_bes">
                            <td height="30" align="left" valign="top">&nbsp;</td>
                            <td height="30" align="left" valign="top">
                                <input type="button" value="add more" id="addMoreBES" name="addMoreBES" />
                            </td>
                        </tr>';	
	$output .= '</table>';	

	

	$bes_prefill_arr = implode("***",$bes_prefill_arr);	

	
	echo $output.'####'.$totalRow.'####'.$bes_prefill_arr;

}
elseif($action == 'getuserssleepquestiondetails')
{
    $day = stripslashes($_REQUEST['day']);
    $month = stripslashes($_REQUEST['month']);
    $year = stripslashes($_REQUEST['year']);
    $pro_user_id = stripslashes($_REQUEST['pro_user_id']);
    $user_id = $_SESSION['user_id'];
    
    $sleep_date = $year.'-'.$month.'-'.$day;
    
    list($arr_sleep_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getSleepQuestions($user_id,$sleep_date,$pro_user_id);
    $cnt = count($arr_sleep_id);
    //echo '<br>cnt = '.$cnt;
    
    list($old_scale_arr,$old_remarks_arr,$old_selected_sleep_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersSleepQuestionDetails($user_id,$sleep_date,$pro_user_id);
    
    $output = getUsersSleepQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_sleep_id_arr,$old_my_target_arr,$old_adviser_target_arr);
    
    echo $output.'::::'.$cnt;
}
elseif($action == 'getusersadctquestiondetails')
{
    $day = stripslashes($_REQUEST['day']);
    $month = stripslashes($_REQUEST['month']);
    $year = stripslashes($_REQUEST['year']);
    $pro_user_id = stripslashes($_REQUEST['pro_user_id']);
    $user_id = $_SESSION['user_id'];

    $adct_date = $year.'-'.$month.'-'.$day;
    
    list($arr_adct_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getAdctQuestions($user_id,$adct_date,$pro_user_id);
    $cnt = count($arr_adct_id);
    
    list($old_scale_arr,$old_remarks_arr,$old_selected_adct_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersADCTQuestionDetails($user_id,$adct_date,$pro_user_id);
    $output = getUsersADCTQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_adct_id_arr,$old_my_target_arr,$old_adviser_target_arr);
    
    echo $output.'::::'.$cnt;
}
elseif($action == 'getuserswaequestiondetails')
{
    $day = stripslashes($_REQUEST['day']);
    $month = stripslashes($_REQUEST['month']);
    $year = stripslashes($_REQUEST['year']);
    $pro_user_id = stripslashes($_REQUEST['pro_user_id']);
    $user_id = $_SESSION['user_id'];

    $wae_date = $year.'-'.$month.'-'.$day;

    list($arr_wae_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getWAEQuestions($user_id,$wae_date,$pro_user_id);
    $cnt = count($arr_wae_id);
    list($old_scale_arr,$old_remarks_arr,$old_selected_wae_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersWAEQuestionDetails($user_id,$wae_date,$pro_user_id);

    $output = getUsersWAEQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_wae_id_arr,$old_my_target_arr,$old_adviser_target_arr);
    echo $output.'::::'.$cnt;
}
elseif($action == 'getusersgsquestiondetails')
{
    $day = stripslashes($_REQUEST['day']);
    $month = stripslashes($_REQUEST['month']);
    $year = stripslashes($_REQUEST['year']);
    $pro_user_id = stripslashes($_REQUEST['pro_user_id']);
    $user_id = $_SESSION['user_id'];
    
    $gs_date = $year.'-'.$month.'-'.$day;
    
    list($arr_gs_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getGSQuestions($user_id,$gs_date,$pro_user_id);
    $cnt = count($arr_gs_id);
    list($old_scale_arr,$old_remarks_arr,$old_selected_gs_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersGSQuestionDetails($user_id,$gs_date,$pro_user_id);

    $output = getUsersGSQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_gs_id_arr,$old_my_target_arr,$old_adviser_target_arr);
    echo $output.'::::'.$cnt;
}
elseif($action == 'getusersmcquestiondetails')
{
    $day = stripslashes($_REQUEST['day']);
    $month = stripslashes($_REQUEST['month']);
    $year = stripslashes($_REQUEST['year']);
    $pro_user_id = stripslashes($_REQUEST['pro_user_id']);
    $user_id = $_SESSION['user_id'];

    $mc_date = $year.'-'.$month.'-'.$day;
    
    list($arr_mc_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getMCQuestions($user_id,$mc_date,$pro_user_id);
    $cnt = count($arr_mc_id);
    list($old_scale_arr,$old_remarks_arr,$old_selected_mc_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersMCQuestionDetails($user_id,$mc_date,$pro_user_id);
    
    $output = getUsersMCQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_mc_id_arr,$old_my_target_arr,$old_adviser_target_arr);
    echo $output.'::::'.$cnt;

}
elseif($action == 'getusersmrquestiondetails')
{
    $day = stripslashes($_REQUEST['day']);
    $month = stripslashes($_REQUEST['month']);
    $year = stripslashes($_REQUEST['year']);
    $pro_user_id = stripslashes($_REQUEST['pro_user_id']);
    $user_id = $_SESSION['user_id'];

    $mr_date = $year.'-'.$month.'-'.$day;
    
    list($arr_mr_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getMRQuestions($user_id,$mr_date,$pro_user_id);
    $cnt = count($arr_mr_id);
    list($old_scale_arr,$old_remarks_arr,$old_selected_mr_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersMRQuestionDetails($user_id,$mr_date,$pro_user_id);
    
    $output = getUsersMRQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_mr_id_arr,$old_my_target_arr,$old_adviser_target_arr);
    echo $output.'::::'.$cnt;
}
elseif($action == 'getusersmlequestiondetails')
{
    $day = stripslashes($_REQUEST['day']);
    $month = stripslashes($_REQUEST['month']);
    $year = stripslashes($_REQUEST['year']);
    $pro_user_id = stripslashes($_REQUEST['pro_user_id']);
    $user_id = $_SESSION['user_id'];

    $mle_date = $year.'-'.$month.'-'.$day;
    
    list($arr_mle_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getMLEQuestions($user_id,$mle_date,$pro_user_id);
    $cnt = count($arr_mle_id);
    list($old_scale_arr,$old_remarks_arr,$old_selected_mle_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersMLEQuestionDetails($user_id,$mle_date,$pro_user_id);
    
    $output = getUsersMLEQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$old_scale_arr,$old_remarks_arr,$old_selected_mle_id_arr,$old_my_target_arr,$old_adviser_target_arr);
    echo $output.'::::'.$cnt;
}
elseif($action == 'savetoexcel')

{

	$user_id = $_SESSION['user_id'];

	

	$start_day = stripslashes($_REQUEST['start_day']);

	$start_month = stripslashes($_REQUEST['start_month']);

	$start_year = stripslashes($_REQUEST['start_year']);

	$end_day = stripslashes($_REQUEST['end_day']);

	$end_month = stripslashes($_REQUEST['end_month']);

	$end_year = stripslashes($_REQUEST['end_year']);

	

	/*

	$food_report = stripslashes($_REQUEST['food_report']);

	$activity_report = stripslashes($_REQUEST['activity_report']);

	$wae_report = stripslashes($_REQUEST['wae_report']);

	$gs_report = stripslashes($_REQUEST['gs_report']);

	$sleep_report = stripslashes($_REQUEST['sleep_report']);

	$mc_report = stripslashes($_REQUEST['mc_report']);

	$mr_report = stripslashes($_REQUEST['mr_report']);

	$mle_report = stripslashes($_REQUEST['mle_report']);

	$adct_report = stripslashes($_REQUEST['adct_report']);

	*/

	

	$wae_report = '1';

	

	$error = false;

	$err_date = '';

	

	if( ($start_day == '') || ($start_month == '') || ($start_year == '') )

	{

		$error = true;

		$err_date = 'Please select start date';

	}

	elseif(!checkdate($start_month,$start_day,$start_year))

	{

		$error = true;

		$err_date = 'Please select valid start date';

	}

	elseif(mktime(0,0,0,$start_month,$start_day,$start_year) > time())

	{

		$error = true;

		$err_date = 'Please select today or previous day for start date ';

	}

	elseif( ($end_day == '') || ($end_month == '') || ($end_year == '') )

	{

		$error = true;

		$err_date = 'Please select end date';

	}

	elseif(!checkdate($end_month,$end_day,$end_year))

	{

		$error = true;

		$err_date = 'Please select valid end date';

	}

	elseif(mktime(0,0,0,$end_month,$end_day,$end_year) > time())

	{

		$error = true;

		$err_date = 'Please select today or previous day for end date';

	}

	elseif( ($food_report == '') && ($activity_report == '') && ($wae_report == '') && ($gs_report == '') && ($sleep_report == '') && ($mc_report == '') && ($mr_report == '') && ($mle_report == '') && ($adct_report == '') )

	{

		$error = true;

		$err_date = 'Please select atleast one report type';

	}

	else

	{

		$start_date = $start_year.'-'.$start_month.'-'.$start_day;

		$end_date = $end_year.'-'.$end_month.'-'.$end_day;

	}

	

	if(!$error)

	{

		$output = getDigitalPersonalWellnessDiaryHTML($user_id,$start_date,$end_date,$food_report,$activity_report,$wae_report,$gs_report,$sleep_report,$mc_report,$mr_report,$mle_report,$adct_report);	

		$filename ="digital_personal_wellness_diary_".time().".xls";

		ob_clean();

		header('Content-type: application/ms-excel');

		header('Content-Disposition: attachment; filename='.$filename);

		echo $output;

	}

	else

	{

		$ret_str = $error.'::::'.$err_date;

		echo $ret_str;

	}	

}

elseif($action == 'resendotp')
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
            $response['msg'] = 'OTP send successfully on registered mobile please activate your profile using otp ';
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
            $response['msg'] = 'Your account activated successfully click link and start login in your profile <a href="wa_register.php">Login</a>';
            $response['status'] = 1;
        }
    echo json_encode(array($response));
    exit(0);    
    }
    
?>