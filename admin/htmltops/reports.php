<?php
require_once('config/class.mysql.php');

require_once('classes/class.reports.php');


$obj = new Reports();
$admin_id = $_SESSION['admin_id'];

$food_chart_action = '115';
$my_activity_calories_chart_action = '116';
$my_activity_calories_pichart_action = '116';
$activity_analysis_chart_action = '117';
$meal_chart_action = '118';
$digital_personal_wellness_diary_action = '119';
$monthly_wellness_tracker_report_action = '120';
$enable_disable_report_action = '121';
$datewise_emotions_report_action = '122';
$statementwise_emotions_report_action = '123';
$angervent_intensity_report_action = '124';
$stressbuster_intensity_report_action = '125';
$each_meal_report_action = '133';
$statementwise_emotions_pichart_action='123';
$rewards_chart_action='162';

$food_chart_permission = $obj->chkValidActionPermission($admin_id,$food_chart_action);
$each_meal_permission = $obj->chkValidActionPermission($admin_id,$each_meal_report_action);
$my_activity_calories_chart_permission = $obj->chkValidActionPermission($admin_id,$my_activity_calories_chart_action);
$my_activity_calories_pichart_permission = $obj->chkValidActionPermission($admin_id,$my_activity_calories_chart_action);
$activity_analysis_chart_permission = $obj->chkValidActionPermission($admin_id,$activity_analysis_chart_action);
$meal_chart_permission = $obj->chkValidActionPermission($admin_id,$meal_chart_action);
$digital_personal_wellness_diary_permission = $obj->chkValidActionPermission($admin_id,$digital_personal_wellness_diary_action);
$monthly_wellness_tracker_report_permission = $obj->chkValidActionPermission($admin_id,$monthly_wellness_tracker_report_action);
$enable_disable_report_permission = $obj->chkValidActionPermission($admin_id,$enable_disable_report_action);
$datewise_emotions_report_permission = $obj->chkValidActionPermission($admin_id,$datewise_emotions_report_action);
$statementwise_emotions_report_permission = $obj->chkValidActionPermission($admin_id,$statementwise_emotions_report_action);
$statementwise_emotions_pichart_permission = $obj->chkValidActionPermission($admin_id,$statementwise_emotions_pichart_action);
$angervent_intensity_report_permission = $obj->chkValidActionPermission($admin_id,$angervent_intensity_report_action);
$stressbuster_intensity_report_permission = $obj->chkValidActionPermission($admin_id,$stressbuster_intensity_report_action);
$rewards_chart_report_permission = $obj->chkValidActionPermission($admin_id,$rewards_chart_action);

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

$view_user_reports_action_id = '103';
if(!$obj->chkValidActionPermission($admin_id,$view_user_reports_action_id))
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}
	
$error = false;
$err_msg = "";

$show_pdf_button = false;



if(isset($_POST['btnPdfReport']))
{
	$user_id = $_POST['hdnuser_id'];
	$start_day = trim($_POST['hdnstart_day']);
	$start_month = trim($_POST['hdnstart_month']);
	$start_year = trim($_POST['hdnstart_year']);
	$end_day = trim($_POST['hdnend_day']);
	$end_month = trim($_POST['hdnend_month']);
	$end_year = trim($_POST['hdnend_year']);
	$report_type = trim($_POST['hdnreport_type']);
	$food_report = trim($_POST['hdnfood_report']);
	$activity_report = trim($_POST['hdnactivity_report']);
	$wae_report = trim($_POST['hdnwae_report']);
	$gs_report = trim($_POST['hdngs_report']);
	$sleep_report = trim($_POST['hdnsleep_report']);
	$mc_report = trim($_POST['hdnmc_report']);
	$mr_report = trim($_POST['hdnmr_report']);
	$mle_report = trim($_POST['hdnmle_report']);
	$adct_report = trim($_POST['hdnadct_report']);
	
	if($user_id == '')
	{
		$error = true;
		$err_msg = 'Please select any user';
	}
	
	if( ($start_day == '') || ($start_month == '') || ($start_year == '') )
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select start date';
		}
		else
		{
			$err_msg .= '<br>Please select start date';
		}	
	}
	elseif(!checkdate(intval($start_month),intval($start_day),intval($start_year)))
	{
		if(!$error)
		{
			$error = true;
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
			$error = true;
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
	
	if( ($end_day == '') || ($end_month == '') || ($end_year == '') )
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select end date';
		}
		else
		{
			$err_msg .= '<br>Please select end date';
		}	
	}
	elseif(!checkdate($end_month,$end_day,$end_year))
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select valid end date';
		}
		else
		{
			$err_msg .= '<br>Please select valid end date';
		}
	}
	elseif(mktime(0,0,0,$end_month,$end_day,$end_year) > time())
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select today or previous day for end date';
		}
		else
		{
			$err_msg .= '<br>Please select today or previous day for end date';
		}
	}
	else
	{
		$end_date = $end_year.'-'.$end_month.'-'.$end_day;
	}

	if($report_type == '')
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select report type';
		}
		else
		{
			$err_msg .= '<br>Please select report type';
		}
	}

	if(!$error)
	{
		if($report_type == 'Food Chart')
		{
			list($return,$arr_date,$arr_records,$total_meal_entry) = $obj->getFoodChart($user_id,$start_date,$end_date);
			ob_clean();
			$output = $obj->getFoodChartHTML($user_id,$start_date,$end_date);	
			$filename = 'food_chart_'.time();
			require_once('classes/class.htmltopsmaker.php');
			convert_to_pdf($filename,$output);
		}
		elseif($report_type == 'Each Meal Per Day Chart')
		{
			list($return,$arr_meal_time, $arr_meal_item, $arr_meal_measure, $arr_meal_ml, $arr_weight, $arr_water , $arr_calories , $arr_protein ,$arr_total_fat , $arr_saturated , $arr_monounsaturated , $arr_polyunsaturated , $arr_cholesterol , $arr_carbohydrate ,$arr_total_dietary_fiber , $arr_calcium , $arr_iron , $arr_potassium , $arr_sodium , $arr_thiamin , $arr_riboflavin , $arr_niacin ,$arr_pantothenic_acid , $arr_pyridoxine_hcl, $arr_cyanocobalamin, $arr_ascorbic_acid , $arr_calciferol, $arr_tocopherol ,$arr_phylloquinone, $arr_sugar , $arr_polyunsaturated_linoleic , $arr_polyunsaturated_alphalinoleic , $arr_total_monosaccharide ,
$arr_glucose , $arr_fructose , $arr_galactose , $arr_disaccharide , $arr_maltose , $arr_lactose , $arr_sucrose , $arr_total_polysaccharide ,$arr_starch , $arr_cellulose , $arr_glycogen , $arr_dextrins , $arr_total_vitamin , $arr_vitamin_a_acetate, $arr_vitamin_a_retinol,$arr_total_vitamin_b_complex, $arr_folic_acid , $arr_biotin , $arr_alanine , $arr_arginine , $arr_aspartic_acid , $arr_cystine , $arr_giutamic_acid ,$arr_glycine , $arr_histidine , $arr_hydroxy_glutamic_acid , $arr_hydroxy_proline , $arr_iodogorgoic_acid , $arr_isoleucine , $arr_leucine ,$arr_lysine , $arr_methionine , $arr_norleucine , $arr_phenylalanine , $arr_proline , $arr_serine , $arr_threonine , $arr_thyroxine ,$arr_tryptophane ,$arr_tyrosine , $arr_valine , $arr_total_minerals , $arr_phosphorus , $arr_sulphur , $arr_chlorine , $arr_iodine , $arr_magnesium , $arr_zinc ,$arr_copper , $arr_chromium , $arr_manganese , $arr_selenium , $arr_boron , $arr_molybdenum , $arr_caffeine,$arr_date,$arr_date) = $obj->getEachMealPerDayChart($user_id,$start_date,$end_date);
			ob_clean();
			$report_title = 'Each Meal Per Day Chart';
			$output = $obj->getEachMealPerDayChartHTML($user_id,$start_date,$end_date);	
			$filename = 'Each_Meal_Per_Day_Chart_'.time().".xls";
			$obj->convert_to_excel($filename,$output);
			exit(0);
		}
		elseif($report_type == 'My Activity Calories Chart')
		{
			list($return,$arr_date,$arr_calorie_intake,$total_calorie_intake,$arr_calorie_burned,$total_calorie_burned,$avg_workout,$arr_estimated_calorie_required,$total_estimated_calorie_required,$arr_record_row,$arr_activity_id,$total_activity_entry,$total_meal_entry) = $obj->getMyActivityCaloriesChart($user_id,$start_date,$end_date);
			ob_clean();
			$output = $obj->getMyActivityCaloriesChartHTML($user_id,$start_date,$end_date);	
			$filename = 'my_activity_calories_chart_'.time();
			require_once('classes/class.htmltopsmaker.php');
			convert_to_pdf($filename,$output);
		}		
		elseif($report_type == 'Activity Analysis Chart')
		{
			list($return,$arr_date,$arr_records,$total_activity_entry,$arr_total_records) = $obj->getActivityChart($user_id,$start_date,$end_date);
			ob_clean();
			$output = $obj->getActivityChartHTML($user_id,$start_date,$end_date);	
			$filename = 'activity_analysis_chart_'.time();
			require_once('classes/class.htmltopsmaker.php');
			convert_to_pdf($filename,$output);
		}
		elseif($report_type == 'Meal Chart')
		{
			list($return,$arr_date,$arr_breakfast_time,$arr_brunch_time,$arr_lunch_time,$arr_snacks_time,$arr_dinner_time,$total_meal_entry)= $obj->getMealTimeChart($user_id,$start_date,$end_date);
			ob_clean();
			$output = $obj->getMealChartHTML($user_id,$start_date,$end_date);	
			$filename = 'meal_time_chart_'.time();
			require_once('classes/class.htmltopsmaker.php');
			convert_to_pdf($filename,$output);
		}
		elseif($report_type == 'Digital Personal Wellness Diary')
		{
			$report_title = 'Digital Personal Wellness Diary';
			$output = $obj->getDigitalPersonalWellnessDiaryHTML($user_id,$start_date,$end_date,$food_report,$activity_report,$wae_report,$gs_report,$sleep_report,$mc_report,$mr_report,$mle_report,$adct_report,$report_title);	
			$filename ="digital_personal_wellness_diary_".time().".xls";
			$obj->convert_to_excel($filename,$output);
			exit(0);
			list($food_return,$arr_meal_date,$arr_food_records,$activity_return,$arr_activity_date,$arr_activity_records,$wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records) = $obj->getDigitalPersonalWellnessDiary($user_id,$start_date,$end_date);
			if( ($food_return) || ($activity_return) || ($wae_return) || ($gs_return) || ($sleep_return) || ($mc_return) || ($mr_return) || ($mle_return) || ($adct_return) )
			{
				$return = true;
			}
			else
			{
				$return = false;
			}
		}
		elseif($report_type == 'Monthly Wellness Tracker Report')
		{
			$start_date = date('Y-m-01',strtotime('last month'));
			$end_date = date('Y-m-t',strtotime('last month'));
			$report_title = 'Monthly Wellness Tracker Report - For Month of - '.date('M Y',strtotime('last month'));
			$output = $obj->getDigitalPersonalWellnessDiaryHTML($user_id,$start_date,$end_date,$food_report,$activity_report,$wae_report,$gs_report,$sleep_report,$mc_report,$mr_report,$mle_report,$adct_report,$report_title);	
			$tmp_month = date('M_Y',strtotime('last month'));
			$filename ="monthly_wellness_tracker_report_".$tmp_month."_".time().".xls";
			$obj->convert_to_excel($filename,$output);
			exit(0);
			list($food_return,$arr_meal_date,$arr_food_records,$activity_return,$arr_activity_date,$arr_activity_records,$wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records) = $obj->getDigitalPersonalWellnessDiary($user_id,$start_date,$end_date);
			if( ($food_return) || ($activity_return) || ($wae_return) || ($gs_return) || ($sleep_return) || ($mc_return) || ($mr_return) || ($mle_return) || ($adct_return) )
			{
				$return = true;
			}
			else
			{
				$return = false;
			}
		}
		elseif($report_type == 'Datewise Emotions Report')
		{
			list($wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records) = $obj->getDatewiseEmotionsReport($user_id,$start_date,$end_date);
			if( ($wae_return) || ($gs_return) || ($sleep_return) || ($mc_return) || ($mr_return) || ($mle_return) || ($adct_return) )
			{
				$return = true;
			}
			else
			{
				$return = false;
			}
			ob_clean();
			$output = $obj->getDatewiseEmotionsReportHTML($user_id,$start_date,$end_date,$wae_report,$gs_report,$sleep_report,$mc_report,$mr_report,$mle_report,$adct_report);	
			$filename = 'emotions_report_datewise_'.time();
			require_once('classes/class.htmltopsmaker.php');
			convert_to_pdf($filename,$output);
		}
		elseif($report_type == 'Statementwise Emotions Report')
		{
			list($wae_return,$arr_wae_records,$gs_return,$arr_gs_records,$sleep_return,$arr_sleep_records,$mc_return,$arr_mc_records,$mr_return,$arr_mr_records,$mle_return,$arr_mle_records,$adct_return,$arr_adct_records) = $obj->getStatementwiseEmotionsReport($user_id,$start_date,$end_date);
			if( ($wae_return) || ($gs_return) || ($sleep_return) || ($mc_return) || ($mr_return) || ($mle_return) || ($adct_return) )
			{
				$return = true;
			}
			else
			{
				$return = false;
			}
			ob_clean();
			$output = $obj->getStatementwiseEmotionsReportHTML($user_id,$start_date,$end_date,$wae_report,$gs_report,$sleep_report,$mc_report,$mr_report,$mle_report,$adct_report);	
			$filename = 'emotions_report_statementwise_'.time();
			require_once('classes/class.htmltopsmaker.php');
			convert_to_pdf($filename,$output);
		}
		elseif($report_type == 'Angervent Intensity Report')
		{
			list($uavb_return,$arr_uavb_date,$arr_intensity_scale_1,$arr_intensity_scale_1_image,$arr_intensity_scale_2,$arr_intensity_scale_2_image,$arr_angervent_comment_box) = $obj->getAngerVentIntensityReport($user_id,$start_date,$end_date);
			ob_clean();
			$output = $obj->getAngerVentIntensityReportHTML($user_id,$start_date,$end_date);	
			$filename = 'angervent_intensity_report_'.time().".xls";
			$obj->convert_to_excel($filename,$output);
			exit(0);
			if( ($uavb_return) )
			{
				$return = true;
			}
			else
			{
				$return = false;
			}
		}
		elseif($report_type == 'Stressbuster Intensity Report')
		{
			list($usbb_return,$arr_usbb_date,$arr_intensity_scale_1,$arr_intensity_scale_1_image,$arr_intensity_scale_2,$arr_intensity_scale_2_image,$arr_stress_comment_box) = $obj->getStressBusterIntensityReport($user_id,$start_date,$end_date);
			ob_clean();
			$output = $obj->getStressBusterIntensityReportHTML($user_id,$start_date,$end_date);	
			$filename = 'Stressbuster_intensity_report_'.time().".xls";
			$obj->convert_to_excel($filename,$output);
			exit(0);
			if( ($usbb_return) )
			{
				$return = true;
			}
			else
			{
				$return = false;
			}
		}
		if(!$return)
		{
			$msg = 'No records found for this user in given date range!';	
		}
	}
}
elseif(isset($_POST['btnSubmit']))
{
	$user_id = $_POST['user_id'];
	$start_day = trim($_POST['start_day']);
	$start_month = trim($_POST['start_month']);
	$start_year = trim($_POST['start_year']);
	$end_day = trim($_POST['end_day']);
	$end_month = trim($_POST['end_month']);
	$end_year = trim($_POST['end_year']);
	$report_type = trim($_POST['report_type']);
	$food_report = trim($_POST['food_report']);
	$activity_report = trim($_POST['activity_report']);
	$wae_report = trim($_POST['wae_report']);
	$gs_report = trim($_POST['gs_report']);
	$sleep_report = trim($_POST['sleep_report']);
	$mc_report = trim($_POST['mc_report']);
	$mr_report = trim($_POST['mr_report']);
	$mle_report = trim($_POST['mle_report']);
	$adct_report = trim($_POST['adct_report']);
	
	if($report_type == 'Rewards Chart')
	{
	
	}
	else
	{
		if($user_id == '')
		{
			$error = true;
			$err_msg = 'Please select any user';
		}
	}	
	
	if( ($start_day == '') || ($start_month == '') || ($start_year == '') )
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select start date';
		}
		else
		{
			$err_msg .= '<br>Please select start date';
		}	
	}
	elseif(!checkdate($start_month,$start_day,$start_year))
	{
		if(!$error)
		{
			$error = true;
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
			$error = true;
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

	if( ($end_day == '') || ($end_month == '') || ($end_year == '') )
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select end date';
		}
		else
		{
			$err_msg .= '<br>Please select end date';
		}	
	}
	elseif(!checkdate($end_month,$end_day,$end_year))
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select valid end date';
		}
		else
		{
			$err_msg .= '<br>Please select valid end date';
		}
	}
	elseif(mktime(0,0,0,$end_month,$end_day,$end_year) > time())
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select today or previous day for end date';
		}
		else
		{
			$err_msg .= '<br>Please select today or previous day for end date';
		}
	}
	else
	{
		$end_date = $end_year.'-'.$end_month.'-'.$end_day;
	}
	
	if($report_type == '')
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select report type';
		}
		else
		{
			$err_msg .= '<br>Please select report type';
		}
	}
	
	if(!$error)
	{
		if($report_type == 'Food Chart')
		{
			list($return,$arr_date,$arr_records,$total_meal_entry) = $obj->getFoodChart($user_id,$start_date,$end_date);
			if($return && count($arr_date) > 0)
			{
				$show_pdf_button = true;
			}
		}
		elseif($report_type == 'Each Meal Per Day Chart')
		{
			list($return,$arr_meal_time, $arr_meal_item, $arr_meal_measure, $arr_meal_ml, $arr_weight, $arr_water , $arr_calories , $arr_protein ,$arr_total_fat , $arr_saturated , $arr_monounsaturated , $arr_polyunsaturated , $arr_cholesterol , $arr_carbohydrate ,$arr_total_dietary_fiber , $arr_calcium , $arr_iron , $arr_potassium , $arr_sodium , $arr_thiamin , $arr_riboflavin , $arr_niacin ,$arr_pantothenic_acid , $arr_pyridoxine_hcl, $arr_cyanocobalamin, $arr_ascorbic_acid , $arr_calciferol, $arr_tocopherol ,$arr_phylloquinone, $arr_sugar , $arr_polyunsaturated_linoleic , $arr_polyunsaturated_alphalinoleic , $arr_total_monosaccharide ,
$arr_glucose , $arr_fructose , $arr_galactose , $arr_disaccharide , $arr_maltose , $arr_lactose , $arr_sucrose , $arr_total_polysaccharide ,$arr_starch , $arr_cellulose , $arr_glycogen , $arr_dextrins , $arr_total_vitamin , $arr_vitamin_a_acetate, $arr_vitamin_a_retinol,$arr_total_vitamin_b_complex, $arr_folic_acid , $arr_biotin , $arr_alanine , $arr_arginine , $arr_aspartic_acid , $arr_cystine , $arr_giutamic_acid ,$arr_glycine , $arr_histidine , $arr_hydroxy_glutamic_acid , $arr_hydroxy_proline , $arr_iodogorgoic_acid , $arr_isoleucine , $arr_leucine ,$arr_lysine , $arr_methionine , $arr_norleucine , $arr_phenylalanine , $arr_proline , $arr_serine , $arr_threonine , $arr_thyroxine ,$arr_tryptophane ,$arr_tyrosine , $arr_valine , $arr_total_minerals , $arr_phosphorus , $arr_sulphur , $arr_chlorine , $arr_iodine ,$arr_magnesium , $arr_zinc ,$arr_copper , $arr_chromium , $arr_manganese , $arr_selenium , $arr_boron , $arr_molybdenum , $arr_caffeine,$arr_date) = $obj->getEachMealPerDayChart($user_id,$start_date,$end_date);

			if($return && count($arr_date) > 0)
			{
				$show_pdf_button = true;
			}
		}
		elseif($report_type == 'My Activity Calories Chart')
		{
			list($return,$arr_date,$arr_calorie_intake,$total_calorie_intake,$arr_calorie_burned,$total_calorie_burned,$avg_workout,$arr_estimated_calorie_required,$total_estimated_calorie_required,$arr_record_row,$arr_activity_id,$total_activity_entry,$total_meal_entry) = $obj->getMyActivityCaloriesChart($user_id,$start_date,$end_date);
			if($return && count($arr_date) > 0)
			{
				$show_pdf_button = true;
			}
		}
		elseif($report_type == 'My Activity Calories Pi-Chart')
		{
			list($return,$arr_date,$arr_calorie_intake,$total_calorie_intake,$arr_calorie_burned,$total_calorie_burned,$avg_workout,$arr_estimated_calorie_required,$total_estimated_calorie_required,$arr_record_row,$arr_activity_id,$total_activity_entry,$total_meal_entry) = $obj->getMyActivityCaloriesChart($user_id,$start_date,$end_date);
			if($return && count($arr_date) > 0)
			{
				//$show_pdf_button = true;
			}
		}		
		elseif($report_type == 'Activity Analysis Chart')
		{
			list($return,$arr_date,$arr_records,$total_activity_entry,$arr_total_records) = $obj->getActivityChart($user_id,$start_date,$end_date);
			if($return && count($arr_date) > 0)
			{
				$show_pdf_button = true;
			}
		}
		elseif($report_type == 'Meal Chart')
		{
			list($return,$arr_date,$arr_breakfast_time,$arr_brunch_time,$arr_lunch_time,$arr_snacks_time,$arr_dinner_time,$total_meal_entry)= $obj->getMealTimeChart($user_id,$start_date,$end_date);
			if($return && count($arr_date) > 0)
			{
				$show_pdf_button = true;
			}
		}
		elseif($report_type == 'Digital Personal Wellness Diary')
		{
			list($food_return,$arr_meal_date,$arr_food_records,$activity_return,$arr_activity_date,$arr_activity_records,$wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records) = $obj->getDigitalPersonalWellnessDiary($user_id,$start_date,$end_date);
			if( ( ($food_report == '1') && ($food_return) ) || ( ($activity_report == '1') && ($activity_return) ) || ( ($wae_report == '1') && ($wae_return) ) || ( ($gs_report == '1') && ($gs_return) ) || ( ($sleep_report == '1') && ($sleep_return) ) || ( ($mc_report == '1') && ($mc_return) ) || ( ($mr_report == '1') && ($mr_return) ) || ( ($mle_report == '1') && ($mle_return) ) || ( ($adct_report == '1') && ($adct_return) ) ) 
			{
				$show_pdf_button = true;
			}

			if( ($food_return) || ($activity_return) || ($wae_return) || ($gs_return) || ($sleep_return) || ($mc_return) || ($mr_return) || ($mle_return) || ($adct_return) )
			{
				$return = true;
			}
			else
			{
				$return = false;
			}
		}
		elseif($report_type == 'Monthly Wellness Tracker Report')
		{
			$start_date = date('Y-m-01',strtotime('last month'));
			$end_date = date('Y-m-t',strtotime('last month'));
			list($food_return,$arr_meal_date,$arr_food_records,$activity_return,$arr_activity_date,$arr_activity_records,$wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records) = $obj->getDigitalPersonalWellnessDiary($user_id,$start_date,$end_date);
			if( ( ($food_report == '1') && ($food_return) ) || ( ($activity_report == '1') && ($activity_return) ) || ( ($wae_report == '1') && ($wae_return) ) || ( ($gs_report == '1') && ($gs_return) ) || ( ($sleep_report == '1') && ($sleep_return) ) || ( ($mc_report == '1') && ($mc_return) ) || ( ($mr_report == '1') && ($mr_return) ) || ( ($mle_report == '1') && ($mle_return) ) || ( ($adct_report == '1') && ($adct_return) ) ) 
			{
				$show_pdf_button = true;
			}

			if( ($food_return) || ($activity_return) || ($wae_return) || ($gs_return) || ($sleep_return) || ($mc_return) || ($mr_return) || ($mle_return) || ($adct_return) )
			{
				$return = true;
			}
			else
			{
				$return = false;
			}
		}
		elseif($report_type == 'Datewise Emotions Report')
		{
			list($wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records) = $obj->getDatewiseEmotionsReport($user_id,$start_date,$end_date);
			if( ($wae_return) || ($gs_return) || ($sleep_return) || ($mc_return) || ($mr_return) || ($mle_return) || ($adct_return) )
			{
				$return = true;
				$show_pdf_button = true;
			}
			else
			{
				$return = false;
			}
		}
		elseif($report_type == 'Statementwise Emotions Report')
		{
			list($wae_return,$arr_wae_records,$gs_return,$arr_gs_records,$sleep_return,$arr_sleep_records,$mc_return,$arr_mc_records,$mr_return,$arr_mr_records,$mle_return,$arr_mle_records,$adct_return,$arr_adct_records) = $obj->getStatementwiseEmotionsReport($user_id,$start_date,$end_date);

			if( ($wae_return) || ($gs_return) || ($sleep_return) || ($mc_return) || ($mr_return) || ($mle_return) || ($adct_return) )
			{
				$return = true;
				$show_pdf_button = true;
			}
			else
			{
				$return = false;
			}
		}
		elseif($report_type == 'Statementwise Emotions Pichart')
		{
			list($wae_return,$arr_wae_records,$gs_return,$arr_gs_records,$sleep_return,$arr_sleep_records,$mc_return,$arr_mc_records,$mr_return,$arr_mr_records,$mle_return,$arr_mle_records,$adct_return,$arr_adct_records) = $obj->getStatementwiseEmotionsReportPichart($user_id,$start_date,$end_date);
			if( ($wae_return) || ($gs_return) || ($sleep_return) || ($mc_return) || ($mr_return) || ($mle_return) || ($adct_return) )
			{
				$return = true;
				//$show_pdf_button = true;
			}
			else
			{
				$return = false;
			}
		}
		elseif($report_type == 'Angervent Intensity Report')
		{
			list($uavb_return,$arr_uavb_date,$arr_intensity_scale_1,$arr_intensity_scale_1_image,$arr_intensity_scale_2,$arr_intensity_scale_2_image,$arr_angervent_comment_box) = $obj->getAngerVentIntensityReport($user_id,$start_date,$end_date);
			if( ($uavb_return) )
			{
				$return = true;
				$show_pdf_button = true;
			}
			else
			{
				$return = false;
			}
		}
		elseif($report_type == 'Stressbuster Intensity Report')
		{
			list($usbb_return,$arr_usbb_date,$arr_intensity_scale_1,$arr_intensity_scale_1_image,$arr_intensity_scale_2,$arr_intensity_scale_2_image,$arr_stress_comment_box) = $obj->getStressBusterIntensityReport($user_id,$start_date,$end_date);
			if( ($usbb_return) )
			{
				$return = true;
				$show_pdf_button = true;
			}
			else
			{
				$return = false;
			}
		}
		elseif($report_type == 'Rewards Chart')
		{
			list($return,$arr_reward_modules,$arr_reward_summary) = $obj->getMyRewardsChart($user_id,$start_date,$end_date);
			
			/*if( ($return) )
			{
				$return = true;
				$show_pdf_button = true;
			}
			else
			{
				$return = false;
			}*/
		}		

		if(!$return)
		{
			$msg = 'No records found for this user in given date range!';	
		}
	}
}
elseif(isset($_GET['uid']))
{
	$user_id = $_GET['uid'];
	if(!$obj->chkValidUser($user_id))
	{
		header('location: index.php?mode=users');	
	}	

	$now = time();
	$end_year = date("Y",$now);
	$end_month = date("m",$now);
	$end_day = date("j",$now);

	$food_report = '1';
	$each_meal_report='1';
	$activity_report = '1';
	$wae_report = '1';
	$gs_report = '1';
	$sleep_report = '1';
	$mc_report = '1';
	$mr_report = '1';
	$mle_report = '1';
	$adct_report = '1'; 
}
else
{
	$now = time();
	$end_year = date("Y",$now);
	$end_month = date("m",$now);
	$end_day = date("j",$now); 
	
	$food_report = '1';
	$activity_report = '1';
	$wae_report = '1';
	$gs_report = '1';
	$sleep_report = '1';
	$mc_report = '1';
	$mr_report = '1';
	$mle_report = '1';
	$adct_report = '1';

	$start_day = date("j",$now);
	$start_year = date("Y",$now);
	$start_month = date("m",$now);
	$report_type = '';
	$return = false;
	$msg = '';
	
}	
?>
<div id="central_part_contents">
	<div id="notification_contents">
	<?php
	if($error)
	{?>
		<table class="notification-border-e" id="notification" align="center" border="0" width="97%" cellpadding="1" cellspacing="1">
		<tbody>
			<tr>
				<td class="notification-body-e">
					<table border="0" width="100%" cellpadding="0" cellspacing="6">
					<tbody>
						<tr>
							<td><img src="images/notification_icon_e.gif" alt="" border="0" width="12" height="10"></td>
							<td width="100%">
								<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td class="notification-title-E">Error</td>
									</tr>
								</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td class="notification-body-e"><?php echo $err_msg; ?></td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>
		</tbody>
		</table>
	<?php
	}?>
<!--notification_contents-->
	</div>	
	<table border="0" width="97%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Reports </td>
						<td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">
				<tbody>
					<tr>
						<td class="mainbox-body">
							<form action="#" method="post" name="frmreports" id="frmreports" enctype="multipart/form-data" >
                            <?php
							if($enable_disable_report_permission)
							{ ?>
                            <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td align="left"><input type="button" name="btnManageReports" id="btnManageReports" value="Manage Reports" onclick="window.location='index.php?mode=manage_reports';" /></td>
                                </tr>
                            </tbody>
                            </table>
                            <?php
							}?>
                            <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="10%" align="left"><strong>Start Date</strong></td>
									<td width="5%" align="left"><strong>:</strong></td>
									<td width="35%" align="left">
										<select name="start_day" id="start_day">
											<option value="">Day</option>
										<?php
										for($i=1;$i<=31;$i++)
										{ ?>
											<option value="<?php echo $i;?>" <?php if($start_day == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
										<?php
										} ?>	
										</select>
										<select name="start_month" id="start_month">
											<option value="">Month</option>
											<?php echo $obj->getMonthOptions($start_month); ?>
										</select>
										<select name="start_year" id="start_year">
											<option value="">Year</option>
										<?php
										for($i=2011;$i<=intval(date("Y"));$i++)
										{ ?>
											<option value="<?php echo $i;?>" <?php if($start_year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
										<?php
										} ?>	
								  		</select>									</td>
									<td width="10%" align="left"><strong>End Date</strong></td>
									<td width="5%" align="left"><strong>:</strong></td>
									<td width="35%" align="left">
										<select name="end_day" id="end_day">
											<option value="">Day</option>
										<?php
										for($i=1;$i<=31;$i++)
										{ ?>
											<option value="<?php echo $i;?>" <?php if($end_day == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
										<?php
										} ?>	
										</select>
										<select name="end_month" id="end_month">
											<option value="">Month</option>
											<?php echo $obj->getMonthOptions($end_month); ?>
										</select>
										<select name="end_year" id="end_year">
											<option value="">Year</option>
										<?php
										for($i=2011;$i<=intval(date("Y"));$i++)
										{ ?>
											<option value="<?php echo $i;?>" <?php if($end_year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
										<?php
										} ?>	
								  		</select>								  	</td>
								</tr>
								<tr>	
									<td colspan="6" align="left" height="30">&nbsp;</td>
								</tr>
								<tr>	
									<td align="left"><strong>User</strong></td>
									<td align="left"><strong>:</strong></td>
									<td align="left">
										<select name="user_id" id="user_id">
											<option value="">Select</option>
											<?php echo $obj->GetUsersOptions($user_id);?>
								 		</select>									</td>
									<td align="left"><strong>Report Type</strong></td>
									<td align="left"><strong>:</strong></td>
									<td align="left">
                                    	<select name="report_type" id="report_type">
                                            <option value="">Select</option>
										<?php   
                                        if($food_chart_permission) 
                                        {  ?>
                                      		<option value="Food Chart" <?php if($report_type == 'Food Chart') {?> selected="selected" <?php } ?>>Food Chart</option>
										<?php 
                                        } ?>

										<?php  
                                        if($each_meal_permission) 
                                        {  ?>
                                     		<option value="Each Meal Per Day Chart" <?php if($report_type == 'Each Meal Per Day Chart') {?> selected="selected" <?php } ?>>Each Meal Per Day Chart</option>
										<?php 
                                        } ?>

                                        <?php
										if($meal_chart_permission)
										{ ?>
                                      		<option value="Meal Chart" <?php if($report_type == 'Meal Chart') {?> selected="selected" <?php } ?>>Meal Time Chart</option>
                                      	<?php 
										} ?>

                                        <?php
                                        if($activity_analysis_chart_permission) 
										{ ?>
                                      		<option value="Activity Analysis Chart" <?php if($report_type == 'Activity Analysis Chart') {?> selected="selected" <?php } ?>>Activity Analysis Chart</option>
                                        <?php 
										} ?>

										<?php

                                        if($my_activity_calories_chart_permission) 

										{ ?>

                                      		<option value="My Activity Calories Chart" <?php if($report_type == 'My Activity Calories Chart') {?> selected="selected" <?php } ?>>My Activity Calories Chart</option>

                                       	<?php 

										} ?>

                                        <?php

                                        if($my_activity_calories_pichart_permission) 

										{ ?>

                                      		<option value="My Activity Calories Pi-Chart" <?php if($report_type == 'My Activity Calories Pi-Chart') {?> selected="selected" <?php } ?>>My Activity Calories Pi-Chart</option>

                                       	<?php 

										} ?>

                                        

                                        <?php 

										if($datewise_emotions_report_permission) 

										{ ?>

                                      		<option value="Datewise Emotions Report" <?php if($report_type == 'Datewise Emotions Report') {?> selected="selected" <?php } ?>>Emotions Report - Datewise</option>

                                       	<?php 

										} ?>

                                        

                                        <?php

                                        if($statementwise_emotions_report_permission) 

										{ ?>

                                      		<option value="Statementwise Emotions Report" <?php if($report_type == 'Statementwise Emotions Report') {?> selected="selected" <?php } ?>>Emotions Report - Statementwise</option>

                                        <?php

                                        } ?>  

                                        <?php

                                        if($statementwise_emotions_pichart_permission) 

										{ ?>

                                      		<option value="Statementwise Emotions Pichart" <?php if($report_type == 'Statementwise Emotions Pichart') {?> selected="selected" <?php } ?>>Emotions Bar Chart</option>

                                        <?php

                                        } ?>  

                                        <?php

                                        if($digital_personal_wellness_diary_permission) 

										{ ?>

                                      		<option value="Digital Personal Wellness Diary" <?php if($report_type == 'Digital Personal Wellness Diary') {?> selected="selected" <?php } ?>>Digital Personal Wellness Diary</option>

                                     	<?php 

										} ?>

                                        

                                        <?php

                                        if($monthly_wellness_tracker_report_permission) 

										{ ?>

                                      		<option value="Monthly Wellness Tracker Report" <?php if($report_type == 'Monthly Wellness Tracker Report') {?> selected="selected" <?php } ?>>Monthly Wellness Tracker Report</option>

                                        <?php 

										} ?>

                                        

                                        <?php

                                        if($angervent_intensity_report_permission) 

										{ ?>

                                      		<option value="Angervent Intensity Report" <?php if($report_type == 'Angervent Intensity Report') {?> selected="selected" <?php } ?>>Angervent Intensity Report</option>

                                        <?php

										} ?>

                                        

                                        <?php

                                        if($stressbuster_intensity_report_permission) 

										{ ?>

                                      		<option value="Stressbuster Intensity Report" <?php if($report_type == 'Stressbuster Intensity Report') {?> selected="selected" <?php } ?>>Stressbuster Intensity Report</option>

                                      	<?php 

									  	} ?>
                                        
                                        <?php

                                        if($rewards_chart_report_permission) 

										{ ?>

                                      		<option value="Rewards Chart" <?php if($report_type == 'Rewards Chart') {?> selected="selected" <?php } ?>>Rewards Chart</option>

                                      	<?php 

									  	} ?>
                                        
                                        

                                    	</select>

                                    </td>

							  </tr>

								<tr>	

									<td colspan="6" align="left" height="30">&nbsp;</td>

								</tr>

                              	<tr>	

									<td colspan="6" align="center"><input type="Submit" name="btnSubmit" value="View Report" /></td>

								</tr>

							</tbody>

							</table>

						 	<table width="920" border="0" cellpadding="0" cellspacing="0">

								<tr>

									<td height="30">&nbsp;</td>

									<td height="30">&nbsp;</td>

								</tr>

							</table>

							

						<?php

						//if( ($return) && ( count($arr_date) > 0 ) )

						if( ($return) )

						{ 

						?>

                      

							<table width="920" border="0" cellpadding="0" cellspacing="0">

								<tr>

									<td height="30">&nbsp;</td>

									<td height="30">&nbsp;</td>

								</tr>

							</table>

							<table width="920" border="0" cellpadding="0" cellspacing="0">

							<tbody>

								<tr>

									<td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>

									<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>

									<td width="20%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($start_date));?></td>

									<td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>

									<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>

									<td width="19%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($end_date));?></td>

									<td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

									<td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

									<td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

								</tr>

								<tr>	

									<td height="30" align="left" valign="middle"><strong>Name</strong></td>

									<td height="30" align="left" valign="middle"><strong>:</strong></td>

									<td height="30" align="left" valign="middle"><?php echo $obj->getNameOfUser($user_id);?></td>

									<td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>

									<td height="30" align="left" valign="middle"><strong>:</strong></td>

									<td height="30" align="left" valign="middle"><?php echo $obj->getUserUniqueId($user_id);?></td>

									<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

									<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

									<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

								</tr>

								<tr>	

									<td height="30" align="left" valign="middle"><strong>Age</strong></td>

									<td height="30" align="left" valign="middle"><strong>:</strong></td>

									<td height="30" align="left" valign="middle"><?php echo $obj->getAgeOfUser($user_id);?></td>

									<td height="30" align="left" valign="middle"><strong>Height</strong></td>

									<td height="30" align="left" valign="middle"><strong>:</strong></td>

									<td height="30" align="left" valign="middle"><?php echo $obj->getHeightOfUser($user_id). ' cms';?></td>

									<td height="30" align="left" valign="middle"><strong>Weight</strong></td>

									<td height="30" align="left" valign="middle"><strong>:</strong></td>

									<td height="30" align="left" valign="middle"><?php echo $obj->getWeightOfUser($user_id). ' Kgs';?></td>

								</tr>

								<tr>	

									<td height="30" align="left" valign="middle"><strong>BMI</strong></td>

									<td height="30" align="left" valign="middle"><strong>:</strong></td>

									<td height="30" align="left" valign="middle"><?php echo $obj->getBMIOfUser($user_id);?></td>

									<td height="30" align="left" valign="middle"><strong>BMI Observations</strong></td>

									<td height="30" align="left" valign="middle"><strong>:</strong></td>

									<td height="30" align="left" valign="middle"><?php echo $obj->getBMRObservationOfUser($user_id);?></td>

									<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

									<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

									<td height="30" align="left" valign="middle">&nbsp;</td>

								</tr>

                           	<?php

							if($report_type == 'Food Chart')

							{ ?>

								<tr>	

                                    <td height="30" align="left" valign="middle"><strong>No of days</strong></td>

                                    <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                    <td height="30" align="left" valign="middle"><?php echo count($arr_date);?></td>

                                    <td height="30" align="left" valign="middle"><strong>Total Meals Entry</strong></td>

                                    <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                    <td height="30" align="left" valign="middle"><?php echo $total_meal_entry;?></td>

                                    <td height="30" align="left" valign="middle">&nbsp;</td>

                                    <td height="30" align="left" valign="middle">&nbsp;</td>

                                    <td height="30" align="left" valign="middle">&nbsp;</td>

								</tr>

                            <?php

							} 

							elseif($report_type == 'My Activity Calories Chart')

							{ ?>

								<tr>	

                                    <td height="30" align="left" valign="middle"><strong>No of days</strong></td>

                                    <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                    <td height="30" align="left" valign="middle"><?php echo count($arr_date);?></td>

                                    <td height="30" align="left" valign="middle"><strong>Total Activity Entry</strong></td>

                                    <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                    <td height="30" align="left" valign="middle"><?php echo $total_activity_entry;?></td>

                                    <td height="30" align="left" valign="middle"><strong>Total Meals Entry</strong></td>

                                    <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                    <td height="30" align="left" valign="middle"><?php echo $total_meal_entry;?></td>

								</tr>

                            <?php

							}

							elseif($report_type == 'My Activity Calories Pi-Chart')

							{ ?>

								<tr>	

                                    <td height="30" align="left" valign="middle"><strong>No of days</strong></td>

                                    <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                    <td height="30" align="left" valign="middle"><?php echo count($arr_date);?></td>

                                    <td height="30" align="left" valign="middle"><strong>Total Activity Entry</strong></td>

                                    <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                    <td height="30" align="left" valign="middle"><?php echo $total_activity_entry;?></td>

                                    <td height="30" align="left" valign="middle"><strong>Total Meals Entry</strong></td>

                                    <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                    <td height="30" align="left" valign="middle"><?php echo $total_meal_entry;?></td>

								</tr>

                            <?php

							} 

							elseif($report_type == 'Activity Analysis Chart')

							{ ?>

								<tr>	

                                    <td height="30" align="left" valign="middle"><strong>No of days</strong></td>

                                    <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                    <td height="30" align="left" valign="middle"><?php echo count($arr_date);?></td>

                                    <td height="30" align="left" valign="middle"><strong>Total Activity Entry</strong></td>

                                    <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                    <td height="30" align="left" valign="middle"><?php echo $total_activity_entry;?></td>

                                    <td height="30" align="left" valign="middle">&nbsp;</td>

                                    <td height="30" align="left" valign="middle">&nbsp;</td>

                                    <td height="30" align="left" valign="middle">&nbsp;</td>

								</tr>

                            <?php

							}

							elseif($report_type == 'Meal Chart')

							{ ?>

								<tr>	

                                    <td height="30" align="left" valign="middle"><strong>No of days</strong></td>

                                    <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                    <td height="30" align="left" valign="middle"><?php echo count($arr_date);?></td>

                                    <td height="30" align="left" valign="middle"><strong>Total Meals Entry</strong></td>

                                    <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                    <td height="30" align="left" valign="middle"><?php echo $total_meal_entry;?></td>

                                    <td height="30" align="left" valign="middle">&nbsp;</td>

                                    <td height="30" align="left" valign="middle">&nbsp;</td>

                                    <td height="30" align="left" valign="middle">&nbsp;</td>

								</tr>

                            <?php

							}?>

                                <tr>	

									<td colspan="9" align="left" height="30">&nbsp;</td>

								</tr>

							</tbody>

							</table>

							<table width="920" border="0" cellpadding="0" cellspacing="0">

							<tbody>	

								<tr>	

									<td align="left"><strong>Important:</strong></td>

								</tr>

								<tr>	

									<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>

								</tr>

								<tr>	

									<td align="left" height="30">&nbsp;</td>

								</tr>

							</tbody>

							</table>

                            <?php

							if($report_type == 'Activity Analysis Chart')

							{ ?>

                            

								<?php

                                for($i=0;$i<count($arr_date);$i++)

                                { ?>

                            

                            <table width="1050" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">

								<tr>

									<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Date : <?php echo date("d M Y",strtotime($arr_date[$i]));?>(<?php echo date("l",strtotime($arr_date[$i]));?>)</td>

                              	</tr>

                                <tr>

                                    <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Sleep Time : <?php echo $obj->getUserSleepTime($user_id,$arr_date[$i]);?></td>

                                </tr>

                                 <tr>

                                    <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Wake-up Time : <?php echo $obj->getUserWakeUpTime($user_id,$arr_date[$i]);?></td>

                                </tr>

                            </table>

                            <table width="1050" border="0" cellpadding="0" cellspacing="0">

								<tr>

									<td height="20" align="left" valign="middle">&nbsp;</td>

                              	</tr>

                            </table>

                            <table width="1050" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">

								<tr>

									<td width="25" height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">SNo</td>

									<td width="350" height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Activity</td>

									<td width="50" height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>

                                    <td width="50" height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Duration</td>

                                    <td width="125" height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Sedentary Activity(SA)</td>

                                    <td width="125" height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Light Activity(LA)</td>

                                    <td width="125" height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Moderate Activity(MA)</td>

                                    <td width="125" height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Vigorous Activity(VA)</td>

                                    <td width="125" height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Super Active(SUA)</td>

                                </tr>	

									<?php

                                    $j=1;

                                    foreach($arr_records[$arr_date[$i]] as $key => $val)

                                    { ?>

								<tr>

									<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $j;?></td>

									<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getDailyActivityName($key);?></td>

									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['time'];?></td>

                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['duration'];?></td>

                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['sa_cal_burned'];?></td>

                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['la_cal_burned'];?></td>

                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['ma_cal_burned'];?></td>

                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['va_cal_burned'];?></td>

                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['sua_cal_burned'];?></td>

                                </tr>   

									<?php

                                     $j++;

                                    }?>

                                

                                <tr>

									<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;</td>

									<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Total</td>

									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">&nbsp;</td>

                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">&nbsp;</td>

                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;"><?php echo $arr_total_records[$arr_date[$i]]['total_sa_cal_burned'];?></td>

                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;"><?php echo $arr_total_records[$arr_date[$i]]['total_la_cal_burned'];?></td>

                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;"><?php echo $arr_total_records[$arr_date[$i]]['total_ma_cal_burned'];?></td>

                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;"><?php echo $arr_total_records[$arr_date[$i]]['total_va_cal_burned'];?></td>

                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;"><?php echo $arr_total_records[$arr_date[$i]]['total_sua_cal_burned'];?></td>

                                </tr>        

								

							</table>

                             <table width="1050" border="0" cellpadding="0" cellspacing="0">

								<tr>

									<td height="20" align="left" valign="middle">&nbsp;</td>

                              	</tr>

                            </table>

								<?php

                                }?>

                          	<table width="920" border="0" cellspacing="0" cellpadding="0">

								<tr>

									<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

								</tr>

							</table>

							<?php

							} 

							elseif($report_type == 'Food Chart')

							{ ?>

							<table width="1050" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">

								<tr>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">SNo</td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Food Constituents</td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Recommended Dietary Allowance Per Day</td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Average Requirement Per Day</td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Upper Limit Per Day</td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Average Quantity consumed per day for the Period</td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Deficiency / Excess of Constituents Consumed on Average basis</td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Deficiency / Excess of Constituents Consumed on Recommended values</td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Observations</td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Recommend</td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Guideline</td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Benefits</td>

								</tr>	

								<?php

								$j=1;

								foreach($arr_records as $key => $val)

								{ ?>

								<tr>

									<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $j;?></td>

									<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $key;?></td>

									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['nutrientstdreq'];?></td>

									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['nutrientavgreq'];?></td>

									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['nutrientupperlimit'];?></td>

									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['avg_qty_consumed'];?></td>

									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['def_exc_avg_consumed'];?></td>

									<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['def_exc_rec_consumed'];?></td>

									<td height="30" align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $val['observations'];?></td>

									<td height="30" align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $val['recommend'];?></td>

									<td height="30" align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $val['guideline'];?></td>

									<td height="30" align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $val['benefits'];?></td>

								<?php

									$j++;

								}?>

								</tr>

							</table>

							<table width="920" border="0" cellspacing="0" cellpadding="0">

								<tr>

									<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

								</tr>

							</table>

							<?php

							} 

							elseif($report_type == 'My Activity Calories Chart')

							{ ?>

							<table width="1050" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">

								<tr>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">SNo</td>

                                    <td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Date/day</td>

								<?php

								for($i=0;$i<count($arr_activity_id);$i++)

								{ ?>

									<td height="50" align="left" valign="middle" bgcolor="#FFFFFF" class="report_header"><?php echo $obj->getDailyActivityName($arr_activity_id[$i]);?></td>

								<?php

								}?>

									<td height="50" align="left" valign="middle" bgcolor="#FFFFFF" class="report_header">Total Calories Burnt</td>

                                    <td height="50" align="left" valign="middle" bgcolor="#FFFFFF" class="report_header">Total Calories Intake</td>

                                    <td height="50" align="left" valign="middle" bgcolor="#FFFFFF" class="report_header">Estimated Calorie Required</td>

								</tr>

                           		<?php

								for($i=0,$k=1;$i<count($arr_date);$i++,$k++)

								{ ?>

                            	<tr>

                                	<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $k;?></td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($arr_date[$i]));?><br />(<?php echo date("l",strtotime($arr_date[$i]));?>)</td>

									<?php

									for($j=0;$j<count($arr_activity_id);$j++)

									{ ?>

									<td height="50" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;"><?php echo $arr_record_row[$arr_activity_id[$j]][$arr_date[$i]];?></td>

									<?php

									}?>

									<td height="50" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;"><?php echo $arr_calorie_burned[$arr_date[$i]];?></td>

                                    <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;"><?php echo $arr_calorie_intake[$arr_date[$i]];?></td>

                                    <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;"><?php echo $arr_estimated_calorie_required[$arr_date[$i]];?></td>

								</tr>

                            	<?php

								}?>

                            	<tr>

                                	<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">&nbsp;</td>

									<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Total</td>

								<?php

								for($i=0;$i<count($arr_activity_id);$i++)

								{ ?>

									<td height="50" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;"><?php echo $arr_record_row[$arr_activity_id[$i]]['total_cal_val'];?></td>

								<?php

								}?>

									<td height="50" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;"><?php echo $total_calorie_burned;?></td>

                                    <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;"><?php echo $total_calorie_intake;?></td>

                                    <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;"><?php echo $total_estimated_calorie_required;?></td>

								</tr>

							</table>

							<table width="920" border="0" cellspacing="0" cellpadding="0">

								<tr>

									<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

								</tr>

							</table>

							<?php

							}

							elseif($report_type == 'My Activity Calories Pi-Chart')

							{ ?>

							<table width="1050" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">

                           	<tr>

									<td height="50" width="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">SNo</td>

                                    <td height="50" width="100" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Date/day</td>

									<td height="50" width="900" align="left" valign="middle" bgcolor="#FFFFFF" class="report_header">&nbsp;</td>

								</tr>

                           		<?php

								$l=0;

								for($i=0,$k=1;$i<count($arr_date);$i++,$k++)

								{ ?>

                            	<tr>

                                     <script class="code" type="text/javascript">

									$(document).ready(function(){

 									 var data = [

   									 ['Total Calories Burnt(<?php echo $arr_calorie_burned[$arr_date[$i]];?>)', <?php if ($arr_calorie_burned[$arr_date[$i]]=='NA'){echo 0;} else{ echo $arr_calorie_burned[$arr_date[$i]];};?>],['Total Calories Intake(<?php echo $arr_calorie_intake[$arr_date[$i]];?>)', <?php if ($arr_calorie_intake[$arr_date[$i]]=='NA'){echo 0;} else{ echo $arr_calorie_intake[$arr_date[$i]];};?>],['Estimated Calorie Required(<?php echo $arr_estimated_calorie_required[$arr_date[$i]];?>)', <?php if ($arr_estimated_calorie_required[$arr_date[$i]]=='NA'){echo 0;} else{ echo $arr_estimated_calorie_required[$arr_date[$i]];};?>]

 									 ];

 									 var plot1 = jQuery.jqplot ('chart1<?php print $l; ?>', [data], 

									{ 

									  seriesDefaults: {

										// Make this a pie chart.

										renderer: jQuery.jqplot.PieRenderer, 

										rendererOptions: {

										  // Put data labels on the pie slices.

										  // By default, labels show the percentage of the slice.

										  showDataLabels: true

										}

									  }, 

									  legend: { show:true, location: 'e' }

									}

								  );

								});

								</script>

                                	<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $k;?></td>

									<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($arr_date[$i]));?><br />(<?php echo date("l",strtotime($arr_date[$i]));?>)</td>

									<td height="50" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;"><div id="chart1<?php print $l; ?>" style="height:300px; width:920px;"></div></td>

								</tr>

                            	<?php

								$l++;

								}?>

                            	<tr>

                                 <script class="code" type="text/javascript">

									$(document).ready(function(){

 									 var data = [

   									 ['Total Calories Burnt(<?php echo $total_calorie_burned;?>)', <?php echo $total_calorie_burned;?>],['Total Calories Intake(<?php echo $total_calorie_intake;?>)', <?php echo $total_calorie_intake;?>],['Estimated Calorie Required(<?php echo $total_estimated_calorie_required;?>)', <?php echo $total_estimated_calorie_required;?>]

 									 ];

 									 var plot1 = jQuery.jqplot ('total', [data], 

									{ 

									  seriesDefaults: {

										// Make this a pie chart.

										renderer: jQuery.jqplot.PieRenderer, 

										rendererOptions: {

										  // Put data labels on the pie slices.

										  // By default, labels show the percentage of the slice.

										  showDataLabels: true

										}

									  }, 

									  legend: { show:true, location: 'e' }

									}

								  );

								});

								</script>

                                	<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">&nbsp;</td>

									<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Total</td>

									

									<td height="50" align="center" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;"><div id="total" style="height:300px; width:920px;"></div>

</td>

								</tr>

							</table>

							<table width="920" border="0" cellspacing="0" cellpadding="0">

								<tr>

									<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

								</tr>

							</table>

							<?php

							}

							elseif($report_type == 'Each Meal Per Day Chart')

							{

							for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	

																	<?php

																	if($arr_meal_time['breakfast'][$j] != '' )

																	{

							?>

								<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report_header">

													<tr>

														<td width="864" align="left" height="20" valign="top" class="report_header" bgcolor="#E1E1E1">&nbsp;<strong>Breakfast</strong></td>

														<td width="54" align="center" height="20" valign="top" class="report_header" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="0" class="report_header">

													<tr>

														<td width="179" align="left" valign="top">

															<table class="table_border" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Food No.</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Meal Time</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Food Description</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

															<tr>

														<td width="179" align="left" valign="middle" height="40" class="report_header" bgcolor="#E1E1E1">&nbsp;Measure of edible portion<br />&nbsp;Serving Size</td>

															  </tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;ML</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Weight(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Water(%)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calories</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Total fat(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Saturated(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Monounsaturated(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Poly-unsaturated</td>

																</tr>

															</table>

																<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated - Linoleic</td>

															  </tr>

															  </table>

															 <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated   alpha-Linoleic</td>

															  </tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cholesterol(mg)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total dietary fiber(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Carbohydrate</td>

															  </tr>

														  </table>

															  <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glucose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Fructose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Galactose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Disaccharide</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Maltose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lactose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sucrose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Polysaccharide</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Starch</td>

															  </tr>

														  </table>

															  <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cellulose</td>

															  </tr>

															  </table>

															  <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycogen</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Dextrins</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sugar</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamins</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin A (As Acetate)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin A (Retinol)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamin B Complex</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B1 (Thiamin)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B2 (Riboflavin)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />

																  &nbsp;/Nicotonic Acid)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B5 (Pantothenic Acid)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B6 (Pyridoxine HCL)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B12 (Cyanocobalamin)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Folic Acid (or Folate)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Biotin</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin C (Ascorbic acid)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin D (Calciferol)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin E (Tocopherol)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin K (Phylloquinone)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Protein / Amino Acids</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Alanine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Arginine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Aspartic acid</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cystine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Giutamic acid</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Histidine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy-glutamic acid</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy proline</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodogorgoic acid</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Isoleucine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Leucine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lysine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Methionine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Norleucine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phenylalanine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Proline</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Serine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Threonine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Thyroxine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tryptophane</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tyrosine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Valine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Minerals</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calcium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iron</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Potassium</td>

																</tr>

														  </table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sodium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phosphorus</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sulphur</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chlorine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Magnesium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Zinc</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Copper</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chromium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Manganese</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Selenium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Boron</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Molybdenum</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Caffeine</td>

																</tr>

															</table>

														</td>

														<td colspan="10" align="left" valign="middle">

															<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_time['breakfast'][$j] != '' )

																	{

																		echo $i;

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_time['breakfast'][$j] != '' )

																	{

																		echo $arr_meal_time['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp; </td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_item['breakfast'][$j] != '' )

																	{

																		echo $arr_meal_item['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="40" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_measure['breakfast'][$j] != '' )

																	{

																		echo $arr_meal_measure['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="36" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_ml['breakfast'][$j] != '' )

																	{

																		echo $arr_meal_ml['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_weight['breakfast'][$j] != '' )

																	{

																		echo $arr_weight['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_water['breakfast'][$j] != '' )

																	{

																		echo $arr_water['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $water+=$arr_water['breakfast'][$i];

																	}

																	if($water!='0')

																	echo $water;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_calories['breakfast'][$j] != '' )

																	{

																		echo $arr_calories['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $calories+=$arr_calories['breakfast'][$i];

																	}

																	if($calories!='0')

																	echo $calories;

																	else

																	echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_fat['breakfast'][$j] != '' )

																	{

																		echo $arr_total_fat['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																																		</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $fat+=$arr_total_fat['breakfast'][$i];

																	}

																	if($fat!='0')

																	echo $fat;

																	else

																	echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_saturated['breakfast'][$j] != '' )

																	{

																		echo $arr_saturated['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  	$saturated+=$arr_saturated['breakfast'][$i];

																	}

																		if($saturated!='0')

																		echo $saturated;

																		else

																		echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_monounsaturated['breakfast'][$j] != '' )

																	{

																		echo $arr_monounsaturated['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	 &nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  	$monounsaturated+=$arr_monounsaturated['breakfast'][$i];

																	}

																		if($monounsaturated!='0')

																		echo $monounsaturated;

																		else

																		echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php

																	if($arr_polyunsaturated['breakfast'][$j] != '' )

																	{

																		echo $arr_polyunsaturated['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  	$polyunsaturated+=$arr_polyunsaturated['breakfast'][$i];

																	}

																		if($polyunsaturated!='0')

																		echo $polyunsaturated;

																		else

																		echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_polyunsaturated_linoleic['breakfast'][$j] != '' )

																	{

																		echo $arr_polyunsaturated_linoleic['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $polyunsaturated+=$arr_polyunsaturated_linoleic['breakfast'][$i];

																	}

																	if($polyunsaturated!='0')

																	echo $polyunsaturated;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_polyunsaturated_alphalinoleic['breakfast'][$j] != '' )

																	{

																		echo $arr_polyunsaturated_alphalinoleic['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $alphalinoleic+=$arr_polyunsaturated_alphalinoleic['breakfast'][$i];

																	}

																	if($alphalinoleic!='0')

																	echo $alphalinoleic;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_cholesterol['breakfast'][$j] != '' )

																	{

																		echo $arr_cholesterol['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $cholesterol+=$arr_cholesterol['breakfast'][$i];

																	}

																	if($cholesterol!='0')

																	echo $cholesterol;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_total_dietary_fiber['breakfast'][$j] != '' )

																	{

																		echo $arr_total_dietary_fiber['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $dietary_fiber+=$arr_total_dietary_fiber['breakfast'][$i];

																	}

																	if($dietary_fiber!='0')

																	echo $dietary_fiber;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_carbohydrate['breakfast'][$j] != '' )

																	{

																		echo $arr_carbohydrate['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $carbohydrate+=$arr_carbohydrate['breakfast'][$i];

																	}

																	if($carbohydrate!='0')

																	echo $carbohydrate;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_glucose['breakfast'][$j] != '' )

																	{

																		echo $arr_glucose['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $glucose+=$arr_glucose['breakfast'][$i];

																	}

																	if($glucose!='0')

																	echo $glucose;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_fructose['breakfast'][$j] != '' )

																	{

																		echo $arr_fructose['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $fructose+=$arr_fructose['breakfast'][$i];

																	}

																	if($fructose!='0')

																	echo $fructose;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_galactose['breakfast'][$j] != '' )

																	{

																		echo $arr_galactose['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $galactose+=$arr_galactose['breakfast'][$i];

																	}

																	if($galactose!='0')

																	echo $galactose;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_disaccharide['breakfast'][$j] != '' )

																	{

																		echo $arr_disaccharide['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $disaccharide+=$arr_disaccharide['breakfast'][$i];

																	}

																	if($disaccharide!='0')

																	echo $disaccharide;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_maltose['breakfast'][$j] != '' )

																	{

																		echo $arr_maltose['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $maltose+=$arr_maltose['breakfast'][$i];

																	}

																	if($maltose!='0')

																	echo $maltose;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_lactose['breakfast'][$j] != '' )

																	{

																		echo $arr_lactose['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $lactose+=$arr_lactose['breakfast'][$i];

																	}

																	if($lactose!='0')

																	echo $lactose;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_sucrose['breakfast'][$j] != '' )

																	{

																		echo $arr_sucrose['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $sucrose+=$arr_sucrose['breakfast'][$i];

																	}

																	if($sucrose!='0')

																	echo $sucrose;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_total_polysaccharide['breakfast'][$j] != '' )

																	{

																		echo $arr_total_polysaccharide['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $polysaccharide+=$arr_total_polysaccharide['breakfast'][$i];

																	}

																	if($polysaccharide!='0')

																	echo $polysaccharide;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_starch['breakfast'][$j] != '' )

																	{

																		echo $arr_starch['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $starch+=$arr_starch['breakfast'][$i];

																	}

																	if($starch!='0')

																	echo $starch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cellulose['breakfast'][$j] != '' )

																	{

																		echo $arr_cellulose['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $cellulose+=$arr_cellulose['breakfast'][$i];

																	}

																	if($cellulose!='0')

																	echo $cellulose;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_glycogen['breakfast'][$j] != '' )

																	{

																		echo $arr_glycogen['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $glycogen+=$arr_glycogen['breakfast'][$i];

																	}

																	if($glycogen!='0')

																	echo $glycogen;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_dextrins['breakfast'][$j] != '' )

																	{

																		echo $arr_dextrins['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $dextrins+=$arr_dextrins['breakfast'][$i];

																	}

																	if($dextrins!='0')

																	echo $dextrins;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sugar['breakfast'][$j] != '' )

																	{

																		echo $arr_sugar['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $sugar+=$arr_sugar['breakfast'][$i];

																	}

																	if($sugar!='0')

																	echo $sugar;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_vitamin['breakfast'][$j] != '' )

																	{

																		echo $arr_total_vitamin['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $total_vitamin+=$arr_total_vitamin['breakfast'][$i];

																	}

																	if($total_vitamin!='0')

																	echo $total_vitamin;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_vitamin_a_acetate['breakfast'][$j] != '' )

																	{

																		echo $arr_vitamin_a_acetate['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $vitamin_a_acetate+=$arr_vitamin_a_acetate['breakfast'][$i];

																	}

																	if($vitamin_a_acetate!='0')

																	echo $vitamin_a_acetate;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_vitamin_a_retinol['breakfast'][$j] != '' )

																	{

																		echo $arr_vitamin_a_retinol['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $vitamin_a_retinol+=$arr_vitamin_a_retinol['breakfast'][$i];

																	}

																	if($vitamin_a_retinol!='0')

																	echo $vitamin_a_retinol;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_vitamin_b_complex['breakfast'][$j] != '' )

																	{

																		echo $arr_total_vitamin_b_complex['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $total_vitamin_b_complex+=$arr_total_vitamin_b_complex['breakfast'][$i];

																	}

																	if($total_vitamin_b_complex!='0')

																	echo $total_vitamin_b_complex;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_thiamin['breakfast'][$j] != '' )

																	{

																		echo $arr_thiamin['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $thiamin+=$arr_thiamin['breakfast'][$i];

																	}

																	if($thiamin!='0')

																	echo $thiamin;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_riboflavin['breakfast'][$j] != '' )

																	{

																		echo $arr_riboflavin['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $riboflavin+=$arr_riboflavin['breakfast'][$i];

																	}

																	if($riboflavin!='0')

																	echo $riboflavin;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr height="50px">

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_niacin['breakfast'][$j] != '' )

																	{

																		echo $arr_niacin['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $niacin+=$$arr_niacin['breakfast'][$i];

																	}

																	if($niacin!='0')

																	echo $niacin;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_pantothenic_acid['breakfast'][$j] != '' )

																	{

																		echo $arr_pantothenic_acid['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $pantothenic_acid+=$arr_pantothenic_acid['breakfast'][$i];

																	}

																	if($pantothenic_acid!='0')

																	echo $pantothenic_acid;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_pyridoxine_hcl['breakfast'][$j] != '' )

																	{

																		echo $arr_pyridoxine_hcl['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $pyridoxine_hcl+=$arr_pyridoxine_hcl['breakfast'][$i];

																	}

																	if($pyridoxine_hcl!='0')

																	echo $pyridoxine_hcl;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cyanocobalamin['breakfast'][$j] != '' )

																	{

																		echo $arr_cyanocobalamin['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $cyanocobalamin+=$arr_cyanocobalamin['breakfast'][$i];

																	}

																	if($cyanocobalamin!='0')

																	echo $cyanocobalamin;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_folic_acid['breakfast'][$j] != '' )

																	{

																		echo $arr_folic_acid['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $folic_acid+=$arr_folic_acid['breakfast'][$i];

																	}

																	if($folic_acid!='0')

																	echo $folic_acid;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_biotin['breakfast'][$j] != '' )

																	{

																		echo $arr_biotin['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $biotin+=$arr_biotin['breakfast'][$i];

																	}

																	if($biotin!='0')

																	echo $biotin;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_ascorbic_acid['breakfast'][$j] != '' )

																	{

																		echo $arr_ascorbic_acid['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $ascorbic_acid+=$arr_ascorbic_acid['breakfast'][$i];

																	}

																	if($ascorbic_acid!='0')

																	echo $ascorbic_acid;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_calciferol['breakfast'][$j] != '' )

																	{

																		echo $arr_calciferol['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $calciferol+=$arr_calciferol['breakfast'][$i];

																	}

																	if($calciferol!='0')

																	echo $calciferol;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tocopherol['breakfast'][$j] != '' )

																	{

																		echo $arr_tocopherol['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $tocopherol+=$arr_tocopherol['breakfast'][$i];

																	}

																	if($tocopherol!='0')

																	echo $tocopherol;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phylloquinone['breakfast'][$j] != '' )

																	{

																		echo $arr_phylloquinone['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $phylloquinone+=$arr_phylloquinone['breakfast'][$i];

																	}

																	if($phylloquinone!='0')

																	echo $phylloquinone;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_protein['breakfast'][$j] != '' )

																	{

																		echo $arr_protein['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $protein+=$arr_protein['breakfast'][$i];

																	}

																	if($protein!='0')

																	echo $protein;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_alanine['breakfast'][$j] != '' )

																	{

																		echo $arr_alanine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $alanine+=$arr_alanine['breakfast'][$i];

																	}

																	if($alanine!='0')

																	echo $alanine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_arginine['breakfast'][$j] != '' )

																	{

																		echo $arr_arginine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $arginine+=$arr_arginine['breakfast'][$i];

																	}

																	if($arginine!='0')

																	echo $arginine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_aspartic_acid['breakfast'][$j] != '' )

																	{

																		echo $arr_aspartic_acid['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $aspartic_acid+=$arr_aspartic_acid['breakfast'][$i];

																	}

																	if($aspartic_acid!='0')

																	echo $aspartic_acid;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cystine['breakfast'][$j] != '' )

																	{

																		echo $arr_cystine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $cystine+=$arr_cystine['breakfast'][$i];

																	}

																	if($cystine!='0')

																	echo $cystine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_giutamic_acid['breakfast'][$j] != '' )

																	{

																		echo $arr_giutamic_acid['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $giutamic_acid+=$arr_giutamic_acid['breakfast'][$i];

																	}

																	if($giutamic_acid!='0')

																	echo $giutamic_acid;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_glycine['breakfast'][$j] != '' )

																	{

																		echo $arr_glycine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $glycine+=$arr_glycine['breakfast'][$i];

																	}

																	if($glycine!='0')

																	echo $glycine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_histidine['breakfast'][$j] != '' )

																	{

																		echo $arr_histidine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $histidine+=$arr_histidine['breakfast'][$i];

																	}

																	if($histidine!='0')

																	echo $histidine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_hydroxy_glutamic_acid['breakfast'][$j] != '' )

																	{

																		echo $arr_hydroxy_glutamic_acid['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $glutamic_acid+=$arr_hydroxy_glutamic_acid['breakfast'][$i];

																	}

																	if($glutamic_acid!='0')

																	echo $glutamic_acid;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_hydroxy_proline['breakfast'][$j] != '' )

																	{

																		echo $arr_hydroxy_proline['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $hydroxy_proline+=$arr_hydroxy_proline['breakfast'][$i];

																	}

																	if($hydroxy_proline!='0')

																	echo $hydroxy_proline;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iodogorgoic_acid['breakfast'][$j] != '' )

																	{

																		echo $arr_iodogorgoic_acid['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $iodogorgoic_acid+=$arr_iodogorgoic_acid['breakfast'][$i];

																	}

																	if($iodogorgoic_acid!='0')

																	echo $iodogorgoic_acid;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_isoleucine['breakfast'][$j] != '' )

																	{

																		echo $arr_isoleucine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $isoleucine+=$arr_isoleucine['breakfast'][$i];

																	}

																	if($isoleucine!='0')

																	echo $isoleucine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_leucine['breakfast'][$j] != '' )

																	{

																		echo $arr_leucine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $leucine+=$arr_leucine['breakfast'][$i];

																	}

																	if($leucine!='0')

																	echo $leucine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_lysine['breakfast'][$j] != '' )

																	{

																		echo $arr_lysine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $lysine+=$arr_lysine['breakfast'][$i];

																	}

																	if($lysine!='0')

																	echo $lysine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_methionine['breakfast'][$j] != '' )

																	{

																		echo $arr_methionine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $methionine+=$arr_methionine['breakfast'][$i];

																	}

																	if($methionine!='0')

																	echo $methionine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr><tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_norleucine['breakfast'][$j] != '' )

																	{

																		echo $arr_norleucine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $norleucine+=$arr_norleucine['breakfast'][$i];

																	}

																	if($norleucine!='0')

																	echo $norleucine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phenylalanine['breakfast'][$j] != '' )

																	{

																		echo $arr_phenylalanine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $phenylalanine+=$arr_phenylalanine['breakfast'][$i];

																	}

																	if($phenylalanine!='0')

																	echo $phenylalanine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_proline['breakfast'][$j] != '' )

																	{

																		echo $arr_proline['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $proline+=$arr_proline['breakfast'][$i];

																	}

																	if($proline!='0')

																	echo $proline;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_serine['breakfast'][$j] != '' )

																	{

																		echo $arr_serine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $serine+=$arr_serine['breakfast'][$i];

																	}

																	if($serine!='0')

																	echo $serine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_threonine['breakfast'][$j] != '' )

																	{

																		echo $arr_threonine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $threonine+=$arr_threonine['breakfast'][$i];

																	}

																	if($threonine!='0')

																	echo $threonine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_thyroxine['breakfast'][$j] != '' )

																	{

																		echo $arr_thyroxine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $thyroxine+=$arr_thyroxine['breakfast'][$i];

																	}

																	if($thyroxine!='0')

																	echo $thyroxine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tryptophane['breakfast'][$j] != '' )

																	{

																		echo $arr_tryptophane['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $tryptophane+=$arr_tryptophane['breakfast'][$i];

																	}

																	if($tryptophane!='0')

																	echo $tryptophane;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tyrosine['breakfast'][$j] != '' )

																	{

																		echo $arr_tyrosine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $tyrosine+=$arr_tyrosine['breakfast'][$i];

																	}

																	if($tyrosine!='0')

																	echo $tyrosine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_valine['breakfast'][$j] != '' )

																	{

																		echo $arr_valine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $valine+=$arr_valine['breakfast'][$i];

																	}

																	if($valine!='0')

																	echo $valine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_minerals['breakfast'][$j] != '' )

																	{

																		echo $arr_total_minerals['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $total_minerals+=$arr_total_minerals['breakfast'][$i];

																	}

																	if($total_minerals!='0')

																	echo $total_minerals;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_calcium['breakfast'][$j] != '' )

																	{

																		echo $arr_calcium['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $calcium+=$arr_calcium['breakfast'][$i];

																	}

																	if($calcium!='0')

																	echo $calcium;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iron['breakfast'][$j] != '' )

																	{

																		echo $arr_iron['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $iron+=$arr_iron['breakfast'][$i];

																	}

																	if($iron!='0')

																	echo $iron;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_potassium['breakfast'][$j] != '' )

																	{

																		echo $arr_potassium['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $potassium+=$arr_potassium['breakfast'][$i];

																	}

																	if($potassium!='0')

																	echo $potassium;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sodium['breakfast'][$j] != '' )

																	{

																		echo $arr_sodium['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $sodium+=$arr_sodium['breakfast'][$i];

																	}

																	if($sodium!='0')

																	echo $sodium;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phosphorus['breakfast'][$j] != '' )

																	{

																		echo $arr_phosphorus['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $phosphorus+=$arr_phosphorus['breakfast'][$i];

																	}

																	if($phosphorus!='0')

																	echo $phosphorus;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sulphur['breakfast'][$j] != '' )

																	{

																		echo $arr_sulphur['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $sulphur+=$arr_sulphur['breakfast'][$i];

																	}

																	if($sulphur!='0')

																	echo $sulphur;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_chlorine['breakfast'][$j] != '' )

																	{

																		echo $arr_chlorine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $chlorine+=$arr_chlorine['breakfast'][$i];

																	}

																	if($chlorine!='0')

																	echo $chlorine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iodine['breakfast'][$j] != '' )

																	{

																		echo $arr_iodine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $iodine+=$arr_iodine['breakfast'][$i];

																	}

																	if($iodine!='0')

																	echo $iodine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_magnesium['breakfast'][$j] != '' )

																	{

																		echo $arr_magnesium['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $magnesium+=$arr_magnesium['breakfast'][$i];

																	}

																	if($magnesium!='0')

																	echo $magnesium;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_zinc['breakfast'][$j] != '' )

																	{

																		echo $arr_zinc['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $zinc+=$arr_zinc['breakfast'][$i];

																	}

																	if($zinc!='0')

																	echo $zinc;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_copper['breakfast'][$j] != '' )

																	{

																		echo $arr_copper['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $copper+=$arr_copper['breakfast'][$i];

																	}

																	if($copper!='0')

																	echo $copper;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr><tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_chromium['breakfast'][$j] != '' )

																	{

																		echo $arr_chromium['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $chromium+=$arr_chromium['breakfast'][$i];

																	}

																	if($chromium!='0')

																	echo $chromium;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_manganese['breakfast'][$j] != '' )

																	{

																		echo $arr_manganese['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $manganese+=$arr_manganese['breakfast'][$i];

																	}

																	if($manganese!='0')

																	echo $manganese;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_selenium['breakfast'][$j] != '' )

																	{

																		echo $arr_selenium['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $selenium+=$arr_selenium['breakfast'][$i];

																	}

																	if($selenium!='0')

																	echo $selenium;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_boron['breakfast'][$j] != '' )

																	{

																		echo $arr_boron['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)



																	{

																	  $boron+=$arr_boron['breakfast'][$i];

																	}

																	if($boron!='0')

																	echo $boron;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_molybdenum['breakfast'][$j] != '' )

																	{

																		echo $arr_molybdenum['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $molybdenum+=$arr_molybdenum['breakfast'][$i];

																	}

																	if($molybdenum!='0')

																	echo $molybdenum;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_caffeine['breakfast'][$j] != '' )

																	{

																		echo $arr_caffeine['breakfast'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['breakfast']);$i++)

																	{

																	  $caffeine+=$arr_caffeine['breakfast'][$i];

																	}

																	if($caffeine!='0')

																	echo $caffeine;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

														  </table>

														</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<?php 

											}

											else

											{

											echo '<td>&nbsp;</td>';

																			

											}	?>	

													<?php

											}

											

											                   for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	

																	<?php

																	if($arr_meal_time['brunch'][$j] != '' )

																	{ 

											?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">

													<tr>

														<td width="864" align="left" height="20" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;<strong>Brunch</strong></td>

														<td width="54" align="center" height="20" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;<strong>Total</strong></td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="0" class="report">

													<tr>

														<td width="179" align="left" valign="top">

															<table class="table_border" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Food No.</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Meal Time</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Food Description</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Measure of edible portion<br />&nbsp;Serving Size</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;ML</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Weight(g)30</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Water(%)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calories</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total fat(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Saturated(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Monounsaturated(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Poly-unsaturated</td>

																</tr>

															</table>

																<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated - Linoleic</td>

															  </tr>

															  </table>

															 <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Poly-unsaturated alpha-Linoleic</td>

															  </tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cholesterol(mg)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total dietary fiber(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Carbohydrate</td>

															  </tr>

														  </table>



															  <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glucose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Fructose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Galactose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Disaccharide</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Maltose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lactose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sucrose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Polysaccharide</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Starch</td>

															  </tr>

														  </table>

															  <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cellulose</td>

															  </tr>

															  </table>

															  <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycogen</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Dextrins</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sugar</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamins</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin A (As Acetate)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin A (Retinol)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Vitamin B Complex</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B1 (Thiamin)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B2 (Riboflavin)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />

																  &nbsp;/Nicotonic Acid)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B5 (Pantothenic Acid)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B6 (Pyridoxine HCL)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B12 (Cyanocobalamin)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Folic Acid (or Folate)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Biotin</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin C (Ascorbic acid)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin D (Calciferol)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin E (Tocopherol)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin K (Phylloquinone)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Protein / Amino Acids</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Alanine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Arginine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Aspartic acid</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Cystine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Giutamic acid</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Glycine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Histidine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy-glutamic acid</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Hydroxy proline</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodogorgoic acid</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Isoleucine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Leucine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Lysine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Methionine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Norleucine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phenylalanine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Proline</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Serine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Threonine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Thyroxine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tryptophane</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Tyrosine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Valine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Total Minerals</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Calcium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iron</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Potassium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sodium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Phosphorus</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sulphur</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chlorine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Iodine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Magnesium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Zinc</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Copper</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Chromium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Manganese</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Selenium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Boron</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Molybdenum</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Caffeine</td>

																</tr>

															</table>

														</td>

														<td colspan="10" align="left" valign="top">

														<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_time['brunch'][$j] != '' )

																	{

																		echo $i;

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_time['brunch'][$j] != '' )

																	{

																		echo $arr_meal_time['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp; </td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_item['brunch'][$j] != '' )

																	{

																		echo $arr_meal_item['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_measure['brunch'][$j] != '' )

																	{

																		echo $arr_meal_measure['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_ml['brunch'][$j] != '' )

																	{

																		echo $arr_meal_ml['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_weight['brunch'][$j] != '' )

																	{

																		echo $arr_weight['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_water['brunch'][$j] != '' )

																	{

																		echo $arr_water['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $waterbrunch+=$arr_water['brunch'][$i];

																	}

																	if($waterbrunch!='0')

																	echo $waterbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_calories['brunch'][$j] != '' )

																	{

																		echo $arr_calories['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $caloriesbrunch+=$arr_calories['brunch'][$i];

																	}

																	if($caloriesbrunch!='0')

																	echo $caloriesbrunch;

																	else

																	echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_fat['brunch'][$j] != '' )

																	{

																		echo $arr_total_fat['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																																		</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $fatbrunch+=$arr_total_fat['brunch'][$i];

																	}

																	if($fatbrunch!='0')

																	echo $fatbrunch;

																	else

																	echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_saturated['brunch'][$j] != '' )

																	{

																		echo $arr_saturated['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  	$saturatedbrunch+=$arr_saturated['brunch'][$i];

																	}

																		if($saturatedbrunch!='0')

																		echo $saturatedbrunch;

																		else

																		echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_monounsaturated['brunch'][$j] != '' )

																	{

																		echo $arr_monounsaturated['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	 &nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  	$monounsaturatedbrunch+=$arr_monounsaturated['brunch'][$i];

																	}

																		if($monounsaturatedbrunch!='0')

																		echo $monounsaturatedbrunch;

																		else

																		echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php

																	if($arr_polyunsaturated['brunch'][$j] != '' )

																	{

																		echo $arr_polyunsaturated['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  	$polyunsaturatedbrunch+=$arr_polyunsaturated['brunch'][$i];

																	}

																		if($polyunsaturatedbrunch!='0')

																		echo $polyunsaturatedbrunch;

																		else

																		echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_polyunsaturated_linoleic['brunch'][$j] != '' )

																	{

																		echo $arr_polyunsaturated_linoleic['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $polyunsaturatedbrunch+=$arr_polyunsaturated_linoleic['brunch'][$i];

																	}

																	if($polyunsaturatedbrunch!='0')

																	echo $polyunsaturatedbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_polyunsaturated_alphalinoleic['brunch'][$j] != '' )

																	{

																		echo $arr_polyunsaturated_alphalinoleic['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $alphalinoleicbrunch+=$arr_polyunsaturated_alphalinoleic['brunch'][$i];

																	}

																	if($alphalinoleicbrunch!='0')

																	echo $alphalinoleicbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_cholesterol['brunch'][$j] != '' )

																	{

																		echo $arr_cholesterol['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $cholesterolbrunch+=$arr_cholesterol['brunch'][$i];

																	}

																	if($cholesterolbrunch!='0')

																	echo $cholesterolbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_total_dietary_fiber['brunch'][$j] != '' )

																	{

																		echo $arr_total_dietary_fiber['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $dietary_fiberbrunch+=$arr_total_dietary_fiber['brunch'][$i];

																	}

																	if($dietary_fiberbrunch!='0')

																	echo $dietary_fiberbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_carbohydrate['brunch'][$j] != '' )

																	{

																		echo $arr_carbohydrate['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $carbohydratebrunch+=$arr_carbohydrate['brunch'][$i];

																	}

																	if($carbohydratebrunch!='0')

																	echo $carbohydratebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_glucose['brunch'][$j] != '' )

																	{

																		echo $arr_glucose['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $glucosebrunch+=$arr_glucose['brunch'][$i];

																	}

																	if($glucosebrunch!='0')

																	echo $glucosebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_fructose['brunch'][$j] != '' )

																	{

																		echo $arr_fructose['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $fructosebrunch+=$arr_fructose['brunch'][$i];

																	}

																	if($fructosebrunch!='0')

																	echo $fructosebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_galactose['brunch'][$j] != '' )

																	{

																		echo $arr_galactose['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $galactosebrunch+=$arr_galactose['brunch'][$i];

																	}

																	if($galactosebrunch!='0')

																	echo $galactosebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_disaccharide['brunch'][$j] != '' )

																	{

																		echo $arr_disaccharide['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $disaccharidebrunch+=$arr_disaccharide['brunch'][$i];

																	}

																	if($disaccharidebrunch!='0')

																	echo $disaccharidebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_maltose['brunch'][$j] != '' )

																	{

																		echo $arr_maltose['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $maltosebrunch+=$arr_maltose['brunch'][$i];

																	}

																	if($maltosebrunch!='0')

																	echo $maltosebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_lactose['brunch'][$j] != '' )

																	{

																		echo $arr_lactose['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $lactose+=$arr_lactose['brunch'][$i];

																	}

																	if($lactose!='0')

																	echo $lactose;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_sucrose['brunch'][$j] != '' )

																	{

																		echo $arr_sucrose['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $sucrosebrunch+=$arr_sucrose['brunch'][$i];

																	}

																	if($sucrosebrunch!='0')

																	echo $sucrosebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_total_polysaccharide['brunch'][$j] != '' )

																	{

																		echo $arr_total_polysaccharide['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $polysaccharidebrunch+=$arr_total_polysaccharide['brunch'][$i];

																	}

																	if($polysaccharidebrunch!='0')

																	echo $polysaccharidebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_starch['brunch'][$j] != '' )

																	{

																		echo $arr_starch['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $starchbrunch+=$arr_starch['brunch'][$i];

																	}

																	if($starchbrunch!='0')

																	echo $starchbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cellulose['brunch'][$j] != '' )

																	{

																		echo $arr_cellulose['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $cellulosebrunch+=$arr_cellulose['brunch'][$i];

																	}

																	if($cellulosebrunch!='0')

																	echo $cellulosebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_glycogen['brunch'][$j] != '' )

																	{

																		echo $arr_glycogen['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $glycogenbrunch+=$arr_glycogen['brunch'][$i];

																	}

																	if($glycogenbrunch!='0')

																	echo $glycogenbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_dextrins['brunch'][$j] != '' )

																	{

																		echo $arr_dextrins['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $dextrinsbrunch+=$arr_dextrins['brunch'][$i];



																	}

																	if($dextrinsbrunch!='0')

																	echo $dextrinsbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sugar['brunch'][$j] != '' )

																	{

																		echo $arr_sugar['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $sugarbrunch+=$arr_sugar['brunch'][$i];

																	}

																	if($sugarbrunch!='0')

																	echo $sugarbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_vitamin['brunch'][$j] != '' )

																	{

																		echo $arr_total_vitamin['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $total_vitaminbrunch+=$arr_total_vitamin['brunch'][$i];

																	}

																	if($total_vitaminbrunch!='0')

																	echo $total_vitaminbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_vitamin_a_acetate['brunch'][$j] != '' )

																	{

																		echo $arr_vitamin_a_acetate['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $vitamin_a_acetatebrunch+=$arr_vitamin_a_acetate['brunch'][$i];

																	}

																	if($vitamin_a_acetatebrunch!='0')

																	echo $vitamin_a_acetatebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_vitamin_a_retinol['brunch'][$j] != '' )

																	{

																		echo $arr_vitamin_a_retinol['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $vitamin_a_retinolbrunch+=$arr_vitamin_a_retinol['brunch'][$i];

																	}

																	if($vitamin_a_retinolbrunch!='0')

																	echo $vitamin_a_retinolbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_vitamin_b_complex['brunch'][$j] != '' )

																	{

																		echo $arr_total_vitamin_b_complex['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $total_vitamin_b_complexbrunch+=$arr_total_vitamin_b_complex['brunch'][$i];

																	}

																	if($total_vitamin_b_complexbrunch!='0')

																	echo $total_vitamin_b_complexbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_thiamin['brunch'][$j] != '' )

																	{

																		echo $arr_thiamin['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $thiaminbrunch+=$arr_thiamin['brunch'][$i];

																	}

																	if($thiaminbrunch!='0')

																	echo $thiaminbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_riboflavin['brunch'][$j] != '' )

																	{

																		echo $arr_riboflavin['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $riboflavinbrunch+=$arr_riboflavin['brunch'][$i];

																	}

																	if($riboflavinbrunch!='0')

																	echo $riboflavinbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr height="50px">

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="50" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_niacin['brunch'][$j] != '' )

																	{

																		echo $arr_niacin['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="50" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $niacinbrunch+=$$arr_niacin['brunch'][$i];

																	}

																	if($niacinbrunch!='0')

																	echo $niacinbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_pantothenic_acid['brunch'][$j] != '' )

																	{

																		echo $arr_pantothenic_acid['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $pantothenic_acidbrunch+=$arr_pantothenic_acid['brunch'][$i];

																	}

																	if($pantothenic_acidbrunch!='0')

																	echo $pantothenic_acidbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_pyridoxine_hcl['brunch'][$j] != '' )

																	{

																		echo $arr_pyridoxine_hcl['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $pyridoxine_hclbrunch+=$arr_pyridoxine_hcl['brunch'][$i];

																	}

																	if($pyridoxine_hclbrunch!='0')

																	echo $pyridoxine_hclbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cyanocobalamin['brunch'][$j] != '' )

																	{

																		echo $arr_cyanocobalamin['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $cyanocobalaminbrunch+=$arr_cyanocobalamin['brunch'][$i];

																	}

																	if($cyanocobalaminbrunch!='0')

																	echo $cyanocobalaminbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_folic_acid['brunch'][$j] != '' )

																	{

																		echo $arr_folic_acid['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $folic_acidbrunch+=$arr_folic_acid['brunch'][$i];

																	}

																	if($folic_acidbrunch!='0')

																	echo $folic_acidbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_biotin['brunch'][$j] != '' )

																	{

																		echo $arr_biotin['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $biotinbrunch+=$arr_biotin['brunch'][$i];

																	}

																	if($biotinbrunch!='0')

																	echo $biotinbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_ascorbic_acid['brunch'][$j] != '' )

																	{

																		echo $arr_ascorbic_acid['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $ascorbic_acidbrunch+=$arr_ascorbic_acid['brunch'][$i];

																	}

																	if($ascorbic_acidbrunch!='0')

																	echo $ascorbic_acidbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_calciferol['brunch'][$j] != '' )

																	{

																		echo $arr_calciferol['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $calciferolbrunch+=$arr_calciferol['brunch'][$i];

																	}

																	if($calciferolbrunch!='0')

																	echo $calciferolbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tocopherol['brunch'][$j] != '' )

																	{

																		echo $arr_tocopherol['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $tocopherolbrunch+=$arr_tocopherol['brunch'][$i];

																	}

																	if($tocopherolbrunch!='0')

																	echo $tocopherolbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phylloquinone['brunch'][$j] != '' )

																	{

																		echo $arr_phylloquinone['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $phylloquinonebrunch+=$arr_phylloquinone['brunch'][$i];

																	}

																	if($phylloquinonebrunch!='0')

																	echo $phylloquinonebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_protein['brunch'][$j] != '' )

																	{

																		echo $arr_protein['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $proteinbrunch+=$arr_protein['brunch'][$i];

																	}

																	if($proteinbrunch!='0')

																	echo $proteinbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_alanine['brunch'][$j] != '' )

																	{

																		echo $arr_alanine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $alaninebrunch+=$arr_alanine['brunch'][$i];

																	}

																	if($alaninebrunch!='0')

																	echo $alaninebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_arginine['brunch'][$j] != '' )

																	{

																		echo $arr_arginine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $argininebrunch+=$arr_arginine['brunch'][$i];

																	}

																	if($argininebrunch!='0')

																	echo $argininebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_aspartic_acid['brunch'][$j] != '' )

																	{

																		echo $arr_aspartic_acid['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $aspartic_acidbrunch+=$arr_aspartic_acid['brunch'][$i];

																	}

																	if($aspartic_acidbrunch!='0')

																	echo $aspartic_acidbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cystine['brunch'][$j] != '' )

																	{

																		echo $arr_cystine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $cystinebrunch+=$arr_cystine['brunch'][$i];

																	}

																	if($cystinebrunch!='0')

																	echo $cystinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_giutamic_acid['brunch'][$j] != '' )

																	{

																		echo $arr_giutamic_acid['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $giutamic_acidbrunch+=$arr_giutamic_acid['brunch'][$i];

																	}

																	if($giutamic_acidbrunch!='0')

																	echo $giutamic_acidbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_glycine['brunch'][$j] != '' )

																	{

																		echo $arr_glycine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $glycinebrunch+=$arr_glycine['brunch'][$i];

																	}

																	if($glycinebrunch!='0')

																	echo $glycinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_histidine['brunch'][$j] != '' )

																	{

																		echo $arr_histidine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $histidinebrunch+=$arr_histidine['brunch'][$i];

																	}

																	if($histidinebrunch!='0')

																	echo $histidinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_hydroxy_glutamic_acid['brunch'][$j] != '' )

																	{

																		echo $arr_hydroxy_glutamic_acid['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $glutamic_acidbrunch+=$arr_hydroxy_glutamic_acid['brunch'][$i];

																	}

																	if($glutamic_acidbrunch!='0')

																	echo $glutamic_acidbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_hydroxy_proline['brunch'][$j] != '' )

																	{

																		echo $arr_hydroxy_proline['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $hydroxy_prolinebrunch+=$arr_hydroxy_proline['brunch'][$i];

																	}

																	if($hydroxy_prolinebrunch!='0')

																	echo $hydroxy_prolinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iodogorgoic_acid['brunch'][$j] != '' )

																	{

																		echo $arr_iodogorgoic_acid['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $iodogorgoic_acidbrunch+=$arr_iodogorgoic_acid['brunch'][$i];

																	}

																	if($iodogorgoic_acidbrunch!='0')

																	echo $iodogorgoic_acidbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_isoleucine['brunch'][$j] != '' )

																	{

																		echo $arr_isoleucine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $isoleucinebrunch+=$arr_isoleucine['brunch'][$i];

																	}

																	if($isoleucinebrunch!='0')

																	echo $isoleucinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_leucine['brunch'][$j] != '' )

																	{

																		echo $arr_leucine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $leucinebrunch+=$arr_leucine['brunch'][$i];

																	}

																	if($leucinebrunch!='0')

																	echo $leucinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_lysine['brunch'][$j] != '' )

																	{

																		echo $arr_lysine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $lysinebrunch+=$arr_lysine['brunch'][$i];

																	}

																	if($lysinebrunch!='0')

																	echo $lysinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_methionine['brunch'][$j] != '' )

																	{

																		echo $arr_methionine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $methioninebrunch+=$arr_methionine['brunch'][$i];

																	}

																	if($methioninebrunch!='0')

																	echo $methioninebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr><tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_norleucine['brunch'][$j] != '' )

																	{

																		echo $arr_norleucine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $norleucinebrunch+=$arr_norleucine['brunch'][$i];

																	}

																	if($norleucinebrunch!='0')

																	echo $norleucinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phenylalanine['brunch'][$j] != '' )

																	{

																		echo $arr_phenylalanine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $phenylalaninebrunch+=$arr_phenylalanine['brunch'][$i];

																	}

																	if($phenylalaninebrunch!='0')

																	echo $phenylalaninebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_proline['brunch'][$j] != '' )

																	{

																		echo $arr_proline['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $prolinebrunch+=$arr_proline['brunch'][$i];

																	}

																	if($prolinebrunch!='0')

																	echo $prolinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_serine['brunch'][$j] != '' )

																	{

																		echo $arr_serine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $serinebrunch+=$arr_serine['brunch'][$i];

																	}

																	if($serinebrunch!='0')

																	echo $serinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_threonine['brunch'][$j] != '' )

																	{

																		echo $arr_threonine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $threoninebrunch+=$arr_threonine['brunch'][$i];

																	}

																	if($threoninebrunch!='0')

																	echo $threoninebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_thyroxine['brunch'][$j] != '' )

																	{

																		echo $arr_thyroxine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $thyroxinebrunch+=$arr_thyroxine['brunch'][$i];

																	}

																	if($thyroxinebrunch!='0')

																	echo $thyroxinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tryptophane['brunch'][$j] != '' )

																	{

																		echo $arr_tryptophane['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $tryptophanebrunch+=$arr_tryptophane['brunch'][$i];

																	}

																	if($tryptophanebrunch!='0')

																	echo $tryptophanebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tyrosine['brunch'][$j] != '' )

																	{

																		echo $arr_tyrosine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $tyrosinebrunch+=$arr_tyrosine['brunch'][$i];

																	}

																	if($tyrosinebrunch!='0')

																	echo $tyrosinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_valine['brunch'][$j] != '' )

																	{

																		echo $arr_valine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $valinebrunch+=$arr_valine['brunch'][$i];

																	}

																	if($valinebrunch!='0')

																	echo $valinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_minerals['brunch'][$j] != '' )

																	{

																		echo $arr_total_minerals['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $total_mineralsbrunch+=$arr_total_minerals['brunch'][$i];

																	}

																	if($total_mineralsbrunch!='0')

																	echo $total_mineralsbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_calcium['brunch'][$j] != '' )

																	{

																		echo $arr_calcium['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $calciumbrunch+=$arr_calcium['brunch'][$i];

																	}

																	if($calciumbrunch!='0')

																	echo $calciumbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iron['brunch'][$j] != '' )

																	{

																		echo $arr_iron['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $ironbrunch+=$arr_iron['brunch'][$i];

																	}

																	if($ironbrunch!='0')

																	echo $ironbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_potassium['brunch'][$j] != '' )

																	{

																		echo $arr_potassium['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $potassiumbrunch+=$arr_potassium['brunch'][$i];

																	}

																	if($potassiumbrunch!='0')

																	echo $potassiumbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sodium['brunch'][$j] != '' )

																	{

																		echo $arr_sodium['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $sodiumbrunch+=$arr_sodium['brunch'][$i];

																	}

																	if($sodiumbrunch!='0')

																	echo $sodiumbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phosphorus['brunch'][$j] != '' )

																	{

																		echo $arr_phosphorus['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $phosphorusbrunch+=$arr_phosphorus['brunch'][$i];

																	}

																	if($phosphorusbrunch!='0')

																	echo $phosphorusbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sulphur['brunch'][$j] != '' )

																	{

																		echo $arr_sulphur['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $sulphurbrunch+=$arr_sulphur['brunch'][$i];

																	}

																	if($sulphurbrunch!='0')

																	echo $sulphurbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_chlorine['brunch'][$j] != '' )

																	{

																		echo $arr_chlorine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $chlorinebrunch+=$arr_chlorine['brunch'][$i];

																	}

																	if($chlorinebrunch!='0')

																	echo $chlorinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>



																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iodine['brunch'][$j] != '' )

																	{

																		echo $arr_iodine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $iodinebrunch+=$arr_iodine['brunch'][$i];

																	}

																	if($iodinebrunch!='0')

																	echo $iodinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_magnesium['brunch'][$j] != '' )

																	{

																		echo $arr_magnesium['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $magnesiumbrunch+=$arr_magnesium['brunch'][$i];

																	}

																	if($magnesiumbrunch!='0')

																	echo $magnesiumbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_zinc['brunch'][$j] != '' )

																	{

																		echo $arr_zinc['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $zincbrunch+=$arr_zinc['brunch'][$i];

																	}

																	if($zincbrunch!='0')

																	echo $zincbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_copper['brunch'][$j] != '' )

																	{

																		echo $arr_copper['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $copperbrunch+=$arr_copper['brunch'][$i];

																	}

																	if($copperbrunch!='0')

																	echo $copperbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr><tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_chromium['brunch'][$j] != '' )

																	{

																		echo $arr_chromium['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $chromiumbrunch+=$arr_chromium['brunch'][$i];

																	}

																	if($chromiumbrunch!='0')

																	echo $chromiumbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_manganese['brunch'][$j] != '' )

																	{

																		echo $arr_manganese['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $manganesebrunch+=$arr_manganese['brunch'][$i];

																	}

																	if($manganesebrunch!='0')

																	echo $manganesebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_selenium['brunch'][$j] != '' )

																	{

																		echo $arr_selenium['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $seleniumbrunch+=$arr_selenium['brunch'][$i];

																	}

																	if($seleniumbrunch!='0')

																	echo $seleniumbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_boron['brunch'][$j] != '' )

																	{

																		echo $arr_boron['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $boronbrunch+=$arr_boron['brunch'][$i];

																	}

																	if($boronbrunch!='0')

																	echo $boronbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_molybdenum['brunch'][$j] != '' )

																	{

																		echo $arr_molybdenum['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $molybdenumbrunch+=$arr_molybdenum['brunch'][$i];

																	}

																	if($molybdenumbrunch!='0')

																	echo $molybdenumbrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_caffeine['brunch'][$j] != '' )

																	{

																		echo $arr_caffeine['brunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['brunch']);$i++)

																	{

																	  $caffeinebrunch+=$arr_caffeine['brunch'][$i];

																	}

																	if($caffeinebrunch!='0')

																	echo $caffeinebrunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

														  </table>

														</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<?php 

											}

											else

											{

											echo '<td>&nbsp;</td>';

																			

											}	?>	

													<?php

											}

											for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	

																	<?php

																	if($arr_meal_time['lunch'][$j] != '' )

																	{ 

	

															?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">

													<tr>

														<td width="864" align="left" height="20" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;<strong>Lunch</strong></td>

														<td width="54" align="center" height="20" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;<strong>Total</strong></td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="0" class="report">

													<tr>

														<td width="179" align="left" valign="top">

															<table class="table_border" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Food No.</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Meal Time</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Food Description</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Measure of edible portion<br />&nbsp;Serving Size</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;ML</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Weight(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Water(%)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Calories</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">Total fat(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">Saturated(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">Monounsaturated(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Total Poly-unsaturated</td>

																</tr>

															</table>

																<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Poly-unsaturated - Linoleic</td>

															  </tr>

															  </table>

															 <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Poly-unsaturated   alpha-Linoleic</td>

															  </tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Cholesterol(mg)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Total dietary fiber(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Total Carbohydrate</td>

															  </tr>

														  </table>

															  <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Glucose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Fructose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Galactose</td>

																</tr>



															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Total Disaccharide</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Maltose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Lactose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Sucrose</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Total Polysaccharide</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Starch</td>

															  </tr>

														  </table>

															  <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																  <td align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Cellulose</td>

															  </tr>

															  </table>

															  <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Glycogen</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Dextrins</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Sugar</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Total Vitamins</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Vitamin A (As Acetate)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Vitamin A (Retinol)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Total Vitamin B Complex</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Vitamin B1 (Thiamin)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Vitamin B2 (Riboflavin)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />

																  &nbsp;/Nicotonic Acid)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Vitamin B5 (Pantothenic Acid)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Vitamin B6 (Pyridoxine HCL)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Vitamin B12 (Cyanocobalamin)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Folic Acid (or Folate)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Biotin</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Vitamin C (Ascorbic acid)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Vitamin D (Calciferol)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Vitamin E (Tocopherol)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Vitamin K (Phylloquinone)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Total Protein / Amino Acids</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Alanine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Arginine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Aspartic acid</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Cystine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Giutamic acid</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Glycine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Histidine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Hydroxy-glutamic acid</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Hydroxy proline</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Iodogorgoic acid</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Isoleucine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Leucine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Lysine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Methionine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Norleucine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Phenylalanine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Proline</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Serine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Threonine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">Thyroxine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Tryptophane</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Tyrosine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Valine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Total Minerals</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Calcium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Iron</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Potassium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Sodium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Phosphorus</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Sulphur</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Chlorine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Iodine</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Magnesium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Zinc</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Copper</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Chromium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Manganese</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Selenium</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Boron</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Molybdenum</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Caffeine</td>

																</tr>

															</table>

														</td>

														<td colspan="10" align="left" valign="top">

															<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_time['lunch'][$j] != '' )

																	{

																		echo $i;

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_time['lunch'][$j] != '' )

																	{

																		echo $arr_meal_time['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp; </td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_item['lunch'][$j] != '' )

																	{

																		echo $arr_meal_item['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_measure['lunch'][$j] != '' )

																	{

																		echo $arr_meal_measure['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_ml['lunch'][$j] != '' )

																	{

																		echo $arr_meal_ml['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_weight['lunch'][$j] != '' )

																	{

																		echo $arr_weight['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_water['lunch'][$j] != '' )

																	{

																		echo $arr_water['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $waterlunch+=$arr_water['lunch'][$i];

																	}

																	if($waterlunch!='0')

																	echo $waterlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_calories['lunch'][$j] != '' )

																	{

																		echo $arr_calories['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $calorieslunch+=$arr_calories['lunch'][$i];

																	}

																	if($calorieslunch!='0')

																	echo $calorieslunch;

																	else

																	echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_fat['lunch'][$j] != '' )

																	{

																		echo $arr_total_fat['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																																		</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $fatlunch+=$arr_total_fat['lunch'][$i];

																	}

																	if($fatlunch!='0')

																	echo $fatlunch;

																	else

																	echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_saturated['lunch'][$j] != '' )

																	{

																		echo $arr_saturated['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  	$saturatedlunch+=$arr_saturated['lunch'][$i];

																	}

																		if($saturatedlunch!='0')

																		echo $saturatedlunch;

																		else

																		echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_monounsaturated['lunch'][$j] != '' )

																	{

																		echo $arr_monounsaturated['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	 &nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  	$monounsaturatedlunch+=$arr_monounsaturated['lunch'][$i];

																	}

																		if($monounsaturatedlunch!='0')

																		echo $monounsaturatedlunch;

																		else

																		echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php

																	if($arr_polyunsaturated['lunch'][$j] != '' )

																	{

																		echo $arr_polyunsaturated['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  	$polyunsaturatedlunch+=$arr_polyunsaturated['lunch'][$i];

																	}

																		if($polyunsaturatedlunch!='0')

																		echo $polyunsaturatedlunch;

																		else

																		echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_polyunsaturated_linoleic['lunch'][$j] != '' )

																	{

																		echo $arr_polyunsaturated_linoleic['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $polyunsaturatedlunch+=$arr_polyunsaturated_linoleic['lunch'][$i];

																	}

																	if($polyunsaturatedlunch!='0')

																	echo $polyunsaturatedlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_polyunsaturated_alphalinoleic['lunch'][$j] != '' )

																	{

																		echo $arr_polyunsaturated_alphalinoleic['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $alphalinoleiclunch+=$arr_polyunsaturated_alphalinoleic['lunch'][$i];

																	}

																	if($alphalinoleiclunch!='0')

																	echo $alphalinoleiclunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_cholesterol['lunch'][$j] != '' )

																	{

																		echo $arr_cholesterol['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $cholesterollunch+=$arr_cholesterol['lunch'][$i];

																	}

																	if($cholesterollunch!='0')

																	echo $cholesterollunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_total_dietary_fiber['lunch'][$j] != '' )

																	{

																		echo $arr_total_dietary_fiber['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $dietary_fiberlunch+=$arr_total_dietary_fiber['lunch'][$i];

																	}

																	if($dietary_fiberlunch!='0')

																	echo $dietary_fiberlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_carbohydrate['lunch'][$j] != '' )

																	{

																		echo $arr_carbohydrate['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $carbohydratelunch+=$arr_carbohydrate['lunch'][$i];

																	}

																	if($carbohydratelunch!='0')

																	echo $carbohydratelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_glucose['lunch'][$j] != '' )

																	{

																		echo $arr_glucose['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $glucoselunch+=$arr_glucose['lunch'][$i];

																	}

																	if($glucoselunch!='0')

																	echo $glucoselunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_fructose['lunch'][$j] != '' )

																	{

																		echo $arr_fructose['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $fructoselunch+=$arr_fructose['lunch'][$i];

																	}

																	if($fructoselunch!='0')

																	echo $fructoselunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_galactose['lunch'][$j] != '' )

																	{

																		echo $arr_galactose['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $galactoselunch+=$arr_galactose['lunch'][$i];

																	}

																	if($galactoselunch!='0')

																	echo $galactoselunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_disaccharide['lunch'][$j] != '' )

																	{

																		echo $arr_disaccharide['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $disaccharidelunch+=$arr_disaccharide['lunch'][$i];

																	}

																	if($disaccharidelunch!='0')

																	echo $disaccharidelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_maltose['lunch'][$j] != '' )

																	{

																		echo $arr_maltose['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $maltoselunch+=$arr_maltose['lunch'][$i];

																	}

																	if($maltoselunch!='0')

																	echo $maltoselunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_lactose['lunch'][$j] != '' )

																	{

																		echo $arr_lactose['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $lactose+=$arr_lactose['lunch'][$i];

																	}

																	if($lactose!='0')

																	echo $lactose;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_sucrose['lunch'][$j] != '' )

																	{

																		echo $arr_sucrose['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $sucroselunch+=$arr_sucrose['lunch'][$i];

																	}

																	if($sucroselunch!='0')

																	echo $sucroselunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_total_polysaccharide['lunch'][$j] != '' )

																	{

																		echo $arr_total_polysaccharide['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $polysaccharidelunch+=$arr_total_polysaccharide['lunch'][$i];

																	}

																	if($polysaccharidelunch!='0')

																	echo $polysaccharidelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_starch['lunch'][$j] != '' )

																	{

																		echo $arr_starch['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $starchlunch+=$arr_starch['lunch'][$i];

																	}

																	if($starchlunch!='0')

																	echo $starchlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cellulose['lunch'][$j] != '' )

																	{

																		echo $arr_cellulose['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $celluloselunch+=$arr_cellulose['lunch'][$i];

																	}

																	if($celluloselunch!='0')

																	echo $celluloselunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_glycogen['lunch'][$j] != '' )

																	{

																		echo $arr_glycogen['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $glycogenlunch+=$arr_glycogen['lunch'][$i];

																	}

																	if($glycogenlunch!='0')

																	echo $glycogenlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_dextrins['lunch'][$j] != '' )

																	{

																		echo $arr_dextrins['lunch'][