<?php
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };
@set_time_limit(1000000);
include("config.php" );
include_once('class.phpmailer.php');

$action = stripslashes($_REQUEST['action']);
if($action == 'getstateoptions')
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

	$ret_str .='<select name="city_id" id="city_id" onchange="getPlaceOptions(\''.$place_id.'\');">';

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

elseif($action == 'getuserswaequestiondetails')

{

	$day = stripslashes($_REQUEST['day']);

	$month = stripslashes($_REQUEST['month']);

	$year = stripslashes($_REQUEST['year']);

	$user_id = $_SESSION['user_id'];

	

	$tr_response_img = array();

	$tr_response_slider = array();

	

	list($arr_wae_id,$arr_situation,$arr_interpretaion_0_2,$arr_treatment_0_2,$arr_interpretaion_3_4,$arr_treatment_3_4,$arr_interpretaion_5_6,$arr_treatment_5_6,$arr_interpretaion_7_8,$arr_treatment_7_8,$arr_interpretaion_9_10,$arr_treatment_9_10) = getWAEQuestions();



	$cnt = count($arr_wae_id);

	for($i=0;$i<$cnt;$i++)

	{

		$tr_response_img[$i] = '';

		$tr_response_slider[$i] = 'none';

	}



	

	$wae_date = $year.'-'.$month.'-'.$day;

	

	list($old_scale_arr,$old_remarks_arr,$old_selected_wae_id_arr) = getUsersWAEQuestionDetails($user_id,$wae_date);

	

	$selected_wae_id_arr = array(); 

	$scale_arr = array(); 

	$remarks_arr = array(); 

	

	$j = 0;

	for($i=0;$i<count($arr_wae_id);$i++)

	{

		if(in_array($arr_wae_id[$i],$old_selected_wae_id_arr))

		{

			$tr_response_img[$i] = 'none';

			$tr_response_slider[$i] = '';

			$selected_wae_id_arr[$i] = $old_selected_wae_id_arr[$j];

			$scale_arr[$i] = $old_scale_arr[$j];

			$remarks_arr[$i] = $old_remarks_arr[$j];

			$j++;

		}

		else

		{

			$tr_response_img[$i] = '';

			$tr_response_slider[$i] = 'none';

			$selected_wae_id_arr[$i] = '';

			$scale_arr[$i] = 0;

			$remarks_arr[$i] = '';

		}

	}	

	

	$output = '';

	$output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tblwae">';

	if(count($arr_wae_id) > 0)

	{

		for($i=0;$i<count($arr_wae_id);$i++)

		{ 

	$output .= '	<tr style="display:none" valign="top">';

	$output .= '		<td align="left" colspan="2" class="err_msg" valign="top"></td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';

	$output .= '		<td width="430" height="35" align="left" valign="top">';

			if($arr_wae_id[$i] == $selected_wae_id_arr[$i]) 

			{ 

				$chked = ' checked="checked" ';

			}

			else

			{

				$chked = '';

			}

	$output .= '			<input type="checkbox" name="selected_wae_id_'.$i.'" id="selected_wae_id_'.$i.'" value="'.$arr_wae_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_wae_id_\',\''.$i.'\')" />&nbsp;<strong>'.$arr_situation[$i].'</strong>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr id="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'">';

	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';

	$output .= '		<td width="430" height="37" align="left" valign="top">';

	$output .= '			<img border="0" src="images/scale_slider.jpg" width="427"  />';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr id="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'">';

	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';

	$output .= '		<td width="430" height="37" align="left" valign="top" background="images/blank_slider.jpg" style="background-repeat:no-repeat;">';

	$output .= '			<select name="scale[]" id="scale_'.$i.'" style="display:none;">';

	$output .= '				<option value="0">Very Low</option>';

							for($j=1;$j<=10;$j++)

							{

								if($scale_arr[$i] == $j) 

								{

									$sel = ' selected="selected" ';

								}

								else

								{

									$sel = '';

								}

								

								if( ($j >= 0) && ($j <= 2) )

								{

									$val = " (Very Low)";

								}

								elseif( ($j >= 3) && ($j <= 4) )

								{

									$val = " (Low)";

								}

								elseif( ($j >= 5) && ($j <= 6) )

								{

									$val = " (Average)";

								}

								elseif( ($j >= 7) && ($j <= 8) )

								{

									$val = " (High)";

								}

								 elseif( ($j >= 9) && ($j <= 10) )

								{

									$val = " (Very High)";

								}

								

								

	$output .= '				<option value="'.$j.'" '.$sel.'>'.$val.'</option>';

							}	

	$output .= '			</select>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';

	$output .= '		<td width="430" align="left" valign="top">';

	$output .= '			<textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

		}

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;</td>';

	$output .= '		<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';

	$output .= '	</tr>';

	}

	$output .= '</table>';	

	echo $output.'::::'.$cnt;

}

elseif($action == 'getusersgsquestiondetails')

{

	$day = stripslashes($_REQUEST['day']);

	$month = stripslashes($_REQUEST['month']);

	$year = stripslashes($_REQUEST['year']);

	$user_id = $_SESSION['user_id'];

	

	$tr_response_img = array();

	$tr_response_slider = array();

	

	list($arr_gs_id,$arr_situation,$arr_interpretaion_0_2,$arr_treatment_0_2,$arr_interpretaion_3_4,$arr_treatment_3_4,$arr_interpretaion_5_6,$arr_treatment_5_6,$arr_interpretaion_7_8,$arr_treatment_7_8,$arr_interpretaion_9_10,$arr_treatment_9_10) = getGSQuestions();



	$cnt = count($arr_gs_id);

	for($i=0;$i<$cnt;$i++)

	{

		$tr_response_img[$i] = '';

		$tr_response_slider[$i] = 'none';

	}



	

	$gs_date = $year.'-'.$month.'-'.$day;

	

	list($old_scale_arr,$old_remarks_arr,$old_selected_gs_id_arr) = getUsersGSQuestionDetails($user_id,$gs_date);

	

	$selected_gs_id_arr = array(); 

	$scale_arr = array(); 

	$remarks_arr = array(); 

	

	$j = 0;

	for($i=0;$i<count($arr_gs_id);$i++)

	{

		if(in_array($arr_gs_id[$i],$old_selected_gs_id_arr))

		{

			$tr_response_img[$i] = 'none';

			$tr_response_slider[$i] = '';

			$selected_gs_id_arr[$i] = $old_selected_gs_id_arr[$j];

			$scale_arr[$i] = $old_scale_arr[$j];

			$remarks_arr[$i] = $old_remarks_arr[$j];

			$j++;

		}

		else

		{

			$tr_response_img[$i] = '';

			$tr_response_slider[$i] = 'none';

			$selected_gs_id_arr[$i] = '';

			$scale_arr[$i] = 0;

			$remarks_arr[$i] = '';

		}

	}		

	

	$output = '';

	$output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tblgs">';

	if(count($arr_gs_id) > 0)

	{

		for($i=0;$i<count($arr_gs_id);$i++)

		{ 

	$output .= '	<tr style="display:none" valign="top">';

	$output .= '		<td align="left" colspan="2" class="err_msg" valign="top"></td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';

	$output .= '		<td width="430" height="35" align="left" valign="top">';

			if($selected_gs_id_arr[$i] == $arr_gs_id[$i]) 

			{ 

				$chked = ' checked="checked" ';

			}

			else

			{

				$chked = '';

			}

	$output .= '			<input type="checkbox" name="selected_gs_id_'.$i.'" id="selected_gs_id_'.$i.'" value="'.$arr_gs_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_gs_id_\',\''.$i.'\')" />&nbsp;<strong>'.$arr_situation[$i].'</strong>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr id="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'">';

	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';

	$output .= '		<td width="430" height="37" align="left" valign="top">';

	$output .= '			<img border="0" src="images/scale_slider.jpg" width="427"  />';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr id="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'">';

	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';

	$output .= '		<td width="430" height="37" align="left" valign="top" background="images/blank_slider.jpg" style="background-repeat:no-repeat;">';

	$output .= '			<select name="scale[]" id="scale_'.$i.'" style="display:none;">';

	$output .= '				<option value="0">Very Low</option>';

							for($j=1;$j<=10;$j++)

							{

								if($scale_arr[$i] == $j) 

								{

									$sel = ' selected="selected" ';

								}

								else

								{

									$sel = '';

								}

								

								if( ($j >= 0) && ($j <= 2) )

								{

									$val = " (Very Low)";

								}

								elseif( ($j >= 3) && ($j <= 4) )

								{

									$val = " (Low)";

								}

								elseif( ($j >= 5) && ($j <= 6) )

								{

									$val = " (Average)";

								}

								elseif( ($j >= 7) && ($j <= 8) )

								{

									$val = " (High)";

								}

								elseif( ($j >= 9) && ($j <= 10) )

								{

									$val = " (Very High)";

								}

								

								

	$output .= '				<option value="'.$j.'" '.$sel.'>'.$val.'</option>';

							}	

	$output .= '			</select>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';

	$output .= '		<td width="430" align="left" valign="top">';

	$output .= '			<textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

		}

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;</td>';

	$output .= '		<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';

	$output .= '	</tr>';

	}

	$output .= '</table>';	

	echo $output.'::::'.$cnt;

}
elseif($action == 'getuserssleepquestiondetails')
{
	$day = stripslashes($_REQUEST['day']);
	$month = stripslashes($_REQUEST['month']);
	$year = stripslashes($_REQUEST['year']);
	$user_id = $_SESSION['user_id'];

	
	$sleep_date = $year.'-'.$month.'-'.$day;
	
	$tr_response_img = array();
	$tr_response_slider = array();

	list($arr_sleep_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getSleepQuestions($user_id,$sleep_date);
	$cnt = count($arr_sleep_id);
	for($i=0;$i<$cnt;$i++)
	{
		$tr_response_img[$i] = '';
		$tr_response_slider[$i] = 'none';
	}

	

	list($old_scale_arr,$old_remarks_arr,$old_selected_sleep_id_arr) = getUsersSleepQuestionDetails($user_id,$sleep_date);

	$selected_sleep_id_arr = array(); 
	$scale_arr = array(); 
	$remarks_arr = array(); 
	
	$j = 0;
	for($i=0;$i<count($arr_sleep_id);$i++)
	{
		if(in_array($arr_sleep_id[$i],$old_selected_sleep_id_arr))
		{
			$tr_response_img[$i] = 'none';
			$tr_response_slider[$i] = '';
			$selected_sleep_id_arr[$i] = $old_selected_sleep_id_arr[$j];
			$scale_arr[$i] = $old_scale_arr[$j];
			$remarks_arr[$i] = $old_remarks_arr[$j];
			$j++;
		}
		else
		{
			$tr_response_img[$i] = '';
			$tr_response_slider[$i] = 'none';
			$selected_sleep_id_arr[$i] = '';
			$scale_arr[$i] = 0;
			$remarks_arr[$i] = '';
		}
	}			
	$output = '';
	$output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tblsleep">';
	if(count($arr_sleep_id) > 0)
	{
		for($i=0;$i<count($arr_sleep_id);$i++)
		{ 
	$output .= '	<tr style="display:none" valign="top">';
	$output .= '		<td align="left" colspan="2" class="err_msg" valign="top"></td>';
	$output .= '	</tr>';
	$output .= '	<tr>';
	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';
	$output .= '	</tr>';
	$output .= '	<tr>';
	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';
	$output .= '		<td width="430" height="35" align="left" valign="top">';
			if($selected_sleep_id_arr[$i] == $arr_sleep_id[$i]) 
			{ 
				$chked = ' checked="checked" ';
			}
			else
			{
				$chked = '';
			}
	$output .= '			<input type="checkbox" name="selected_sleep_id_'.$i.'" id="selected_sleep_id_'.$i.'" value="'.$arr_sleep_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_sleep_id_\',\''.$i.'\')" />&nbsp;<strong><span style="font-family:'.$arr_situation_font_family[$i].';font-size:'.$arr_situation_font_size[$i].'px;color:#'.$arr_situation_font_color[$i].';">'.$arr_situation[$i].'</span></strong>';
	$output .= '		</td>';
	$output .= '	</tr>';
	$output .= '	<tr id="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'">';
	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';
	$output .= '		<td width="430" height="37" align="left" valign="top">';
	$output .= '			<img border="0" src="images/scale_slider.jpg" width="427"  />';
	$output .= '		</td>';
	$output .= '	</tr>';
	$output .= '	<tr id="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'">';
	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';
	$output .= '		<td width="430" height="37" align="left" valign="top" background="images/blank_slider.jpg" style="background-repeat:no-repeat;">';
	$output .= '			<select name="scale[]" id="scale_'.$i.'" style="display:none;">';
	$output .= '				<option value="0">Very Low</option>';
							for($j=1;$j<=10;$j++)
							{
								if($scale_arr[$i] == $j) 
								{
									$sel = ' selected="selected" ';
								}
								else
								{
									$sel = '';
								}
								
								if( ($j >= 0) && ($j <= 2) )
								{
									$val = " (Very Low)";
								}
								elseif( ($j >= 3) && ($j <= 4) )
								{
									$val = " (Low)";
								}
								elseif( ($j >= 5) && ($j <= 6) )
								{
									$val = " (Average)";
								}
								elseif( ($j >= 7) && ($j <= 8) )
								{
									$val = " (High)";
								}
								else
								{
									$val = " (Very High)";
								}
			
	$output .= '				<option value="'.$j.'" '.$sel.'>'.$val.'</option>';
							}	
	$output .= '			</select>';
	$output .= '		</td>';
	$output .= '	</tr>';
	$output .= '	<tr>';
	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';
	$output .= '	</tr>';
	$output .= '	<tr>';
	$output .= '		<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';
	$output .= '		<td width="430" align="left" valign="top">';
	$output .= '			<textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea>';
	$output .= '		</td>';
	$output .= '	</tr>';
	$output .= '	<tr>';
	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';
	$output .= '	</tr>';
		}
	$output .= '	<tr>';
	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;</td>';
	$output .= '		<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';
	$output .= '	</tr>';
	}
	$output .= '</table>';	
	echo $output.'::::'.$cnt;
}

elseif($action == 'getusersmcquestiondetails')

{

	$day = stripslashes($_REQUEST['day']);

	$month = stripslashes($_REQUEST['month']);

	$year = stripslashes($_REQUEST['year']);

	$user_id = $_SESSION['user_id'];

	

	$tr_response_img = array();

	$tr_response_slider = array();

	

	list($arr_mc_id,$arr_situation,$arr_interpretaion_0_2,$arr_treatment_0_2,$arr_interpretaion_3_4,$arr_treatment_3_4,$arr_interpretaion_5_6,$arr_treatment_5_6,$arr_interpretaion_7_8,$arr_treatment_7_8,$arr_interpretaion_9_10,$arr_treatment_9_10) = getMCQuestions();

	$cnt = count($arr_mc_id);

	for($i=0;$i<$cnt;$i++)

	{

		$tr_response_img[$i] = '';

		$tr_response_slider[$i] = 'none';

	}



	$mc_date = $year.'-'.$month.'-'.$day;

	

	list($old_scale_arr,$old_remarks_arr,$old_selected_mc_id_arr) = getUsersMCQuestionDetails($user_id,$sleep_date);

	

	$selected_mc_id_arr = array(); 

	$scale_arr = array(); 

	$remarks_arr = array(); 

	

	$j = 0;

	for($i=0;$i<count($arr_mc_id);$i++)

	{

		if(in_array($arr_mc_id[$i],$old_selected_mc_id_arr))

		{

			$tr_response_img[$i] = 'none';

			$tr_response_slider[$i] = '';

			$selected_mc_id_arr[$i] = $old_selected_mc_id_arr[$j];

			$scale_arr[$i] = $old_scale_arr[$j];

			$remarks_arr[$i] = $old_remarks_arr[$j];

			$j++;

		}

		else

		{

			$tr_response_img[$i] = '';

			$tr_response_slider[$i] = 'none';

			$selected_mc_id_arr[$i] = '';

			$scale_arr[$i] = 0;

			$remarks_arr[$i] = '';

		}

	}			

	

	$output = '';

	$output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tblmc">';

	if(count($arr_mc_id) > 0)

	{

		for($i=0;$i<count($arr_mc_id);$i++)

		{ 

	$output .= '	<tr style="display:none" valign="top">';

	$output .= '		<td align="left" colspan="2" class="err_msg" valign="top"></td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';

	$output .= '		<td width="430" height="35" align="left" valign="top">';

			if($selected_mc_id_arr[$i] == $arr_mc_id[$i]) 

			{ 

				$chked = ' checked="checked" ';

			}

			else

			{

				$chked = '';

			}

	$output .= '			<input type="checkbox" name="selected_mc_id_'.$i.'" id="selected_mc_id_'.$i.'" value="'.$arr_mc_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_mc_id_\',\''.$i.'\')" />&nbsp;<strong>'.$arr_situation[$i].'</strong>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr id="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'">';

	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';

	$output .= '		<td width="430" height="37" align="left" valign="top">';

	$output .= '			<img border="0" src="images/scale_slider.jpg" width="427"  />';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr id="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'">';

	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';

	$output .= '		<td width="430" height="37" align="left" valign="top" background="images/blank_slider.jpg" style="background-repeat:no-repeat;">';

	$output .= '			<select name="scale[]" id="scale_'.$i.'" style="display:none;">';

	$output .= '				<option value="0">Very Low</option>';

							for($j=1;$j<=10;$j++)

							{

								if($scale_arr[$i] == $j) 

								{

									$sel = ' selected="selected" ';

								}

								else

								{

									$sel = '';

								}

								

								if( ($j >= 0) && ($j <= 2) )

								{

									$val = " (Very Low)";

								}

								elseif( ($j >= 3) && ($j <= 4) )

								{

									$val = " (Low)";

								}

								elseif( ($j >= 5) && ($j <= 6) )

								{

									$val = " (Average)";

								}

								elseif( ($j >= 7) && ($j <= 8) )

								{

									$val = " (High)";

								}

								else

								{

									$val = " (Very High)";

								}

								

								

	$output .= '				<option value="'.$j.'" '.$sel.'>'.$val.'</option>';

							}	

	$output .= '			</select>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';

	$output .= '		<td width="430" align="left" valign="top">';

	$output .= '			<textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

		}

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;</td>';

	$output .= '		<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';

	$output .= '	</tr>';

	}

	$output .= '</table>';	

	echo $output.'::::'.$cnt;

}

elseif($action == 'getusersmrquestiondetails')

{

	$day = stripslashes($_REQUEST['day']);

	$month = stripslashes($_REQUEST['month']);

	$year = stripslashes($_REQUEST['year']);

	$user_id = $_SESSION['user_id'];

	

	$tr_response_img = array();

	$tr_response_slider = array();

	

	list($arr_mr_id,$arr_situation,$arr_interpretaion_0_2,$arr_treatment_0_2,$arr_interpretaion_3_4,$arr_treatment_3_4,$arr_interpretaion_5_6,$arr_treatment_5_6,$arr_interpretaion_7_8,$arr_treatment_7_8,$arr_interpretaion_9_10,$arr_treatment_9_10) = getMRQuestions();

	$cnt = count($arr_mr_id);

	for($i=0;$i<$cnt;$i++)

	{

		$tr_response_img[$i] = '';

		$tr_response_slider[$i] = 'none';

	}



	$mr_date = $year.'-'.$month.'-'.$day;

	

	list($old_scale_arr,$old_remarks_arr,$old_selected_mr_id_arr) = getUsersMRQuestionDetails($user_id,$mr_date);

	

	$selected_mr_id_arr = array(); 

	$scale_arr = array(); 

	$remarks_arr = array(); 

	

	$j = 0;

	for($i=0;$i<count($arr_mr_id);$i++)

	{

		if(in_array($arr_mr_id[$i],$old_selected_mr_id_arr))

		{

			$tr_response_img[$i] = 'none';

			$tr_response_slider[$i] = '';

			$selected_mr_id_arr[$i] = $old_selected_mr_id_arr[$j];

			$scale_arr[$i] = $old_scale_arr[$j];

			$remarks_arr[$i] = $old_remarks_arr[$j];

			$j++;

		}

		else

		{

			$tr_response_img[$i] = '';

			$tr_response_slider[$i] = 'none';

			$selected_mr_id_arr[$i] = '';

			$scale_arr[$i] = 0;

			$remarks_arr[$i] = '';

		}

	}	

	

	$output = '';

	$output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tblmr">';

	if(count($arr_mr_id) > 0)

	{

		for($i=0;$i<count($arr_mr_id);$i++)

		{ 

	$output .= '	<tr style="display:none" valign="top">';

	$output .= '		<td align="left" colspan="2" class="err_msg" valign="top"></td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';

	$output .= '		<td width="430" height="35" align="left" valign="top">';

			if($selected_mr_id_arr[$i] == $arr_mr_id[$i]) 

			{ 

				$chked = ' checked="checked" ';

			}

			else

			{

				$chked = '';

			}

	$output .= '			<input type="checkbox" name="selected_mr_id_'.$i.'" id="selected_mr_id_'.$i.'" value="'.$arr_mr_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_mr_id_\',\''.$i.'\')" />&nbsp;<strong>'.$arr_situation[$i].'</strong>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr id="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'">';

	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';

	$output .= '		<td width="430" height="37" align="left" valign="top">';

	$output .= '			<img border="0" src="images/scale_slider.jpg" width="427"  />';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr id="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'">';

	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';

	$output .= '		<td width="430" height="37" align="left" valign="top" background="images/blank_slider.jpg" style="background-repeat:no-repeat;">';

	$output .= '			<select name="scale[]" id="scale_'.$i.'" style="display:none;">';

	$output .= '				<option value="0">Very Low</option>';

							for($j=1;$j<=10;$j++)

							{

								if($scale_arr[$i] == $j) 

								{

									$sel = ' selected="selected" ';

								}

								else

								{

									$sel = '';

								}

								

								if( ($j >= 0) && ($j <= 2) )

								{

									$val = " (Very Low)";

								}

								elseif( ($j >= 3) && ($j <= 4) )

								{

									$val = " (Low)";

								}

								elseif( ($j >= 5) && ($j <= 6) )

								{

									$val = " (Average)";

								}

								elseif( ($j >= 7) && ($j <= 8) )

								{

									$val = " (High)";

								}

								else

								{

									$val = " (Very High)";

								}

								

								

	$output .= '				<option value="'.$j.'" '.$sel.'>'.$val.'</option>';

							}	

	$output .= '			</select>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';

	$output .= '		<td width="430" align="left" valign="top">';

	$output .= '			<textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

		}

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;</td>';

	$output .= '		<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';

	$output .= '	</tr>';

	}

	$output .= '</table>';	

	echo $output.'::::'.$cnt;

}

elseif($action == 'getusersmlequestiondetails')

{

	$day = stripslashes($_REQUEST['day']);

	$month = stripslashes($_REQUEST['month']);

	$year = stripslashes($_REQUEST['year']);

	$user_id = $_SESSION['user_id'];

	

	$tr_response_img = array();

	$tr_response_slider = array();

	

	list($arr_mle_id,$arr_situation,$arr_interpretaion_0_2,$arr_treatment_0_2,$arr_interpretaion_3_4,$arr_treatment_3_4,$arr_interpretaion_5_6,$arr_treatment_5_6,$arr_interpretaion_7_8,$arr_treatment_7_8,$arr_interpretaion_9_10,$arr_treatment_9_10) = getMLEQuestions();

	$cnt = count($arr_mle_id);

	for($i=0;$i<$cnt;$i++)

	{

		$tr_response_img[$i] = '';

		$tr_response_slider[$i] = 'none';

	}



	$mle_date = $year.'-'.$month.'-'.$day;

	

	list($old_scale_arr,$old_remarks_arr,$old_selected_mle_id_arr) = getUsersMLEQuestionDetails($user_id,$mle_date);

	

	$selected_mle_id_arr = array(); 

	$scale_arr = array(); 

	$remarks_arr = array(); 

	

	$j = 0;

	for($i=0;$i<count($arr_mle_id);$i++)

	{

		if(in_array($arr_mle_id[$i],$old_selected_mle_id_arr))

		{

			$tr_response_img[$i] = 'none';

			$tr_response_slider[$i] = '';

			$selected_mle_id_arr[$i] = $old_selected_mle_id_arr[$j];

			$scale_arr[$i] = $old_scale_arr[$j];

			$remarks_arr[$i] = $old_remarks_arr[$j];

			$j++;

		}

		else

		{

			$tr_response_img[$i] = '';

			$tr_response_slider[$i] = 'none';

			$selected_mle_id_arr[$i] = '';

			$scale_arr[$i] = 0;

			$remarks_arr[$i] = '';

		}

	}	

	

	$output = '';

	$output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tblmle">';

	if(count($arr_mle_id) > 0)

	{

		for($i=0;$i<count($arr_mle_id);$i++)

		{ 

	$output .= '	<tr style="display:none" valign="top">';

	$output .= '		<td align="left" colspan="2" class="err_msg" valign="top"></td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';

	$output .= '		<td width="430" height="35" align="left" valign="top">';

			if($selected_mle_id_arr[$i] == $arr_mle_id[$i]) 

			{ 

				$chked = ' checked="checked" ';

			}

			else

			{

				$chked = '';

			}

	$output .= '			<input type="checkbox" name="selected_mle_id_'.$i.'" id="selected_mle_id_'.$i.'" value="'.$arr_mle_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_mle_id_\',\''.$i.'\')" />&nbsp;<strong>'.$arr_situation[$i].'</strong>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr id="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'">';

	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';

	$output .= '		<td width="430" height="37" align="left" valign="top">';

	$output .= '			<img border="0" src="images/scale_slider.jpg" width="427"  />';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr id="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'">';

	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';

	$output .= '		<td width="430" height="37" align="left" valign="top" background="images/blank_slider.jpg" style="background-repeat:no-repeat;">';

	$output .= '			<select name="scale[]" id="scale_'.$i.'" style="display:none;">';

	$output .= '				<option value="0">Very Low</option>';

							for($j=1;$j<=10;$j++)

							{

								if($scale_arr[$i] == $j) 

								{

									$sel = ' selected="selected" ';

								}

								else

								{

									$sel = '';

								}

								

								if( ($j >= 0) && ($j <= 2) )

								{

									$val = " (Very Low)";

								}

								elseif( ($j >= 3) && ($j <= 4) )

								{

									$val = " (Low)";

								}

								elseif( ($j >= 5) && ($j <= 6) )

								{

									$val = " (Average)";

								}

								elseif( ($j >= 7) && ($j <= 8) )

								{

									$val = " (High)";

								}

								else

								{

									$val = " (Very High)";

								}

								

								

	$output .= '				<option value="'.$j.'" '.$sel.'>'.$val.'</option>';

							}	

	$output .= '			</select>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';

	$output .= '		<td width="430" align="left" valign="top">';

	$output .= '			<textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

		}

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;</td>';

	$output .= '		<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';

	$output .= '	</tr>';

	}

	$output .= '</table>';	

	echo $output.'::::'.$cnt;

}

elseif($action == 'getusersadctquestiondetails')

{

	$day = stripslashes($_REQUEST['day']);

	$month = stripslashes($_REQUEST['month']);

	$year = stripslashes($_REQUEST['year']);

	$user_id = $_SESSION['user_id'];

	

	$tr_response_img = array();

	$tr_response_slider = array();

	$adct_date = $year.'-'.$month.'-'.$day;

	list($arr_adct_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getAdctQuestions($user_id,$adct_date);

	$cnt = count($arr_adct_id);

	for($i=0;$i<$cnt;$i++)

	{

		$tr_response_img[$i] = '';

		$tr_response_slider[$i] = 'none';

	}



	

	

	list($old_scale_arr,$old_remarks_arr,$old_selected_adct_id_arr) = getUsersADCTQuestionDetails($user_id,$adct_date);

	

	$selected_adct_id_arr = array(); 

	$scale_arr = array(); 

	$remarks_arr = array(); 

	

	$j = 0;

	for($i=0;$i<count($arr_adct_id);$i++)

	{

		if(in_array($arr_adct_id[$i],$old_selected_adct_id_arr))

		{

			$tr_response_img[$i] = 'none';

			$tr_response_slider[$i] = '';

			$selected_adct_id_arr[$i] = $old_selected_adct_id_arr[$j];

			$scale_arr[$i] = $old_scale_arr[$j];

			$remarks_arr[$i] = $old_remarks_arr[$j];

			$j++;

		}

		else

		{

			$tr_response_img[$i] = '';

			$tr_response_slider[$i] = 'none';

			$selected_adct_id_arr[$i] = '';

			$scale_arr[$i] = 0;

			$remarks_arr[$i] = '';

		}

	}		

	

	$output = '';

	$output .= '<table width="560" border="0" cellspacing="0" cellpadding="0" id="tbladct">';

	if(count($arr_adct_id) > 0)

	{

		for($i=0;$i<count($arr_adct_id);$i++)

		{ 

	$output .= '	<tr style="display:none" valign="top">';

	$output .= '		<td align="left" colspan="2" class="err_msg" valign="top"></td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;&bull; Situation:</td>';

	$output .= '		<td width="430" height="35" align="left" valign="top">';

			if($selected_adct_id_arr[$i] == $arr_adct_id[$i]) 

			{ 

				$chked = ' checked="checked" ';

			}

			else

			{

				$chked = '';

			}

	$output .= '			<input type="checkbox" name="selected_adct_id_'.$i.'" id="selected_adct_id_'.$i.'" value="'.$arr_adct_id[$i].'" '.$chked.'  onclick="toggleMyResponseScale(\'selected_adct_id_\',\''.$i.'\')" />&nbsp;<strong><span style="font-family:'.$arr_situation_font_family[$i].';font-size:'.$arr_situation_font_size[$i].'px;color:#'.$arr_situation_font_color[$i].';">'.$arr_situation[$i].'</span></strong>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr id="tr_response_img_'.$i.'" style="display:'.$tr_response_img[$i].'">';

	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';

	$output .= '		<td width="430" height="37" align="left" valign="top">';

	$output .= '			<img border="0" src="images/scale_slider.jpg" width="427"  />';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr id="tr_response_slider_'.$i.'" style="display:'.$tr_response_slider[$i].'">';

	$output .= '		<td width="130" height="37" align="left" valign="top">&nbsp;&bull; My Response Scale:</td>';

	$output .= '		<td width="430" height="37" align="left" valign="top" background="images/blank_slider.jpg" style="background-repeat:no-repeat;">';

	$output .= '			<select name="scale[]" id="scale_'.$i.'" style="display:none;">';

	$output .= '				<option value="0">Very Low</option>';

							for($j=1;$j<=10;$j++)

							{

								if($scale_arr[$i] == $j) 

								{

									$sel = ' selected="selected" ';

								}

								else

								{

									$sel = '';

								}

								

								if( ($j >= 0) && ($j <= 2) )

								{

									$val = " (Very Low)";

								}

								elseif( ($j >= 3) && ($j <= 4) )

								{

									$val = " (Low)";

								}

								elseif( ($j >= 5) && ($j <= 6) )

								{

									$val = " (Average)";

								}

								elseif( ($j >= 7) && ($j <= 8) )

								{

									$val = " (High)";

								}

								else

								{

									$val = " (Very High)";

								}

								

								

	$output .= '				<option value="'.$j.'" '.$sel.'>'.$val.'</option>';

							}	

	$output .= '			</select>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td width="130" align="left" valign="top">&nbsp;&bull; My Response Details:</td>';

	$output .= '		<td width="430" align="left" valign="top">';

	$output .= '			<textarea name="remarks[]" id="remarks_'.$i.'" cols="25" rows="3">'.$remarks_arr[$i].'</textarea>';

	$output .= '		</td>';

	$output .= '	</tr>';

	$output .= '	<tr>';

	$output .= '		<td align="left" colspan="2" valign="top">&nbsp;</td>';

	$output .= '	</tr>';

		}

	$output .= '	<tr>';

	$output .= '		<td width="130" height="35" align="left" valign="top">&nbsp;</td>';

	$output .= '		<td width="430" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>';

	$output .= '	</tr>';

	}

	$output .= '</table>';	

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

?>