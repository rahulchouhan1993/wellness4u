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

$show_datedropdown = 'none';

if(isset($_POST['btnPdfReport']))
{
	$user_id = $_POST['hdnuser_id'];
	$start_date = trim($_POST['hdnstart_date']);
	$end_date = trim($_POST['hdnend_date']);
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
	
	if($start_date == '')
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
	
	if($end_date == '')
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
		$start_date = date('Y-m-d',strtotime($start_date));
		$end_date = date('Y-m-d',strtotime($end_date));		
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
			$date = strip_tags(trim($_POST['hdndate']));
			if($date == '')
			{
				$error = true;
				$err_msg = 'Please select date';
			}
			else
			{
				list($return,$arr_meal_time, $arr_meal_item, $arr_meal_measure, $arr_meal_ml, $arr_weight, $arr_water , $arr_calories , $arr_protein ,$arr_total_fat , $arr_saturated , $arr_monounsaturated , $arr_polyunsaturated , $arr_cholesterol , $arr_carbohydrate ,$arr_total_dietary_fiber , $arr_calcium , $arr_iron , $arr_potassium , $arr_sodium , $arr_thiamin , $arr_riboflavin , $arr_niacin ,$arr_pantothenic_acid , $arr_pyridoxine_hcl, $arr_cyanocobalamin, $arr_ascorbic_acid , $arr_calciferol, $arr_tocopherol ,$arr_phylloquinone, $arr_sugar , $arr_polyunsaturated_linoleic , $arr_polyunsaturated_alphalinoleic , $arr_total_monosaccharide ,
	$arr_glucose , $arr_fructose , $arr_galactose , $arr_disaccharide , $arr_maltose , $arr_lactose , $arr_sucrose , $arr_total_polysaccharide ,$arr_starch , $arr_cellulose , $arr_glycogen , $arr_dextrins , $arr_total_vitamin , $arr_vitamin_a_acetate, $arr_vitamin_a_retinol,$arr_total_vitamin_b_complex, $arr_folic_acid , $arr_biotin , $arr_alanine , $arr_arginine , $arr_aspartic_acid , $arr_cystine , $arr_giutamic_acid ,$arr_glycine , $arr_histidine , $arr_hydroxy_glutamic_acid , $arr_hydroxy_proline , $arr_iodogorgoic_acid , $arr_isoleucine , $arr_leucine ,$arr_lysine , $arr_methionine , $arr_norleucine , $arr_phenylalanine , $arr_proline , $arr_serine , $arr_threonine , $arr_thyroxine ,$arr_tryptophane ,$arr_tyrosine , $arr_valine , $arr_total_minerals , $arr_phosphorus , $arr_sulphur , $arr_chlorine , $arr_iodine , $arr_magnesium , $arr_zinc ,$arr_copper , $arr_chromium , $arr_manganese , $arr_selenium , $arr_boron , $arr_molybdenum , $arr_caffeine,$arr_date,$arr_date) = $obj->getEachMealPerDayChart($user_id,$date,$end_date);
				ob_clean();
				$report_title = 'Each Meal Per Day Chart';
				$output = $obj->getEachMealPerDayChartHTML($user_id,$date,$end_date);	
				$filename = 'Each_Meal_Per_Day_Chart_'.time().".xls";
				$obj->convert_to_excel($filename,$output);
				exit(0);
			}	
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
			
			/*
			$select_start_month = strip_tags(trim($_POST['hdnselect_start_month']));
			$select_start_year = strip_tags(trim($_POST['hdnselect_start_year']));
			$select_start_day = '01';
			
			$select_start_date = $select_start_year.'-'.$select_start_month.'-'.$select_start_day;
			
			$select_end_month = $select_start_month;	
			$select_end_year = $select_start_year;
			$select_end_day = date('t',strtotime($select_start_date));
			
			$select_end_date = $select_end_year.'-'.$select_end_month.'-'.$select_end_day;
			
			$start_date = $select_start_date;	
			$end_date = $select_end_date;	
			*/	
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
		$start_date = date('d-m-Y',strtotime($start_date));
		$end_date = date('d-m-Y',strtotime($end_date));
		
		if(!$return)
		{
			$msg = 'No records found for this user in given date range!';	
		}
	}
}
elseif(isset($_POST['btnSubmit']))
{
	$user_id = $_POST['user_id'];
	$start_date = trim($_POST['start_date']);
	$end_date = trim($_POST['end_date']);
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
	
	if($start_date == '')
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
	

	if($end_date == '')
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
		$return = true;
		$start_date = date('Y-m-d',strtotime($start_date));
		$end_date = date('Y-m-d',strtotime($end_date));		
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
			$date = strip_tags(trim($_POST['date']));
			if($date == '')
			{
				$error = true;
				$err_msg = 'Please select date';
			}
			else
			{
				list($return_record,$arr_meal_time, $arr_meal_item, $arr_meal_measure, $arr_meal_ml, $arr_weight, $arr_water , $arr_calories , $arr_protein ,$arr_total_fat , $arr_saturated , $arr_monounsaturated , $arr_polyunsaturated , $arr_cholesterol , $arr_carbohydrate ,$arr_total_dietary_fiber , $arr_calcium , $arr_iron , $arr_potassium , $arr_sodium , $arr_thiamin , $arr_riboflavin , $arr_niacin ,$arr_pantothenic_acid , $arr_pyridoxine_hcl, $arr_cyanocobalamin, $arr_ascorbic_acid , $arr_calciferol, $arr_tocopherol ,$arr_phylloquinone, $arr_sugar , $arr_polyunsaturated_linoleic , $arr_polyunsaturated_alphalinoleic , $arr_total_monosaccharide ,
	$arr_glucose , $arr_fructose , $arr_galactose , $arr_disaccharide , $arr_maltose , $arr_lactose , $arr_sucrose , $arr_total_polysaccharide ,$arr_starch , $arr_cellulose , $arr_glycogen , $arr_dextrins , $arr_total_vitamin , $arr_vitamin_a_acetate, $arr_vitamin_a_retinol,$arr_total_vitamin_b_complex, $arr_folic_acid , $arr_biotin , $arr_alanine , $arr_arginine , $arr_aspartic_acid , $arr_cystine , $arr_giutamic_acid ,$arr_glycine , $arr_histidine , $arr_hydroxy_glutamic_acid , $arr_hydroxy_proline , $arr_iodogorgoic_acid , $arr_isoleucine , $arr_leucine ,$arr_lysine , $arr_methionine , $arr_norleucine , $arr_phenylalanine , $arr_proline , $arr_serine , $arr_threonine , $arr_thyroxine ,$arr_tryptophane ,$arr_tyrosine , $arr_valine , $arr_total_minerals , $arr_phosphorus , $arr_sulphur , $arr_chlorine , $arr_iodine ,$arr_magnesium , $arr_zinc ,$arr_copper , $arr_chromium , $arr_manganese , $arr_selenium , $arr_boron , $arr_molybdenum , $arr_caffeine,$arr_date) = $obj->getEachMealPerDayChart($user_id,$date,$end_date);
	
				if($return_record && count($arr_date) > 0)
				{
					$show_pdf_button = true;
				}
				
				
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
		$start_date = date('d-m-Y',strtotime($start_date));
		$end_date = date('d-m-Y',strtotime($end_date));	

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
	//$start_date = date('Y-m-d');
	//$end_date = date('Y-m-d');
	$start_date = date('d-m-Y');
	$end_date = date('d-m-Y');
	
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
	//$start_date = date('Y-m-d');
	//$end_date = date('Y-m-d');
	
	$start_date = date('d-m-Y');
	$end_date = date('d-m-Y');
	
	$food_report = '1';
	$activity_report = '1';
	$wae_report = '1';
	$gs_report = '1';
	$sleep_report = '1';
	$mc_report = '1';
	$mr_report = '1';
	$mle_report = '1';
	$adct_report = '1';

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
							/*
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
							} */ ?>
                            <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="10%" align="left"><strong>Start Date</strong></td>
									<td width="5%" align="left"><strong>:</strong></td>
									<td width="35%" align="left">
                                    	<input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:80px;"  />
                                        <script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
																		</td>
									<td width="10%" align="left"><strong>End Date</strong></td>
									<td width="5%" align="left"><strong>:</strong></td>
									<td width="35%" align="left">
										 <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:80px;"  />
                                        <script>$('#end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>								  	</td>
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
                                        /*                        
                                        if($monthly_wellness_tracker_report_permission) 

										{ ?>

                                      		<option value="Monthly Wellness Tracker Report" <?php if($report_type == 'Monthly Wellness Tracker Report') {?> selected="selected" <?php } ?>>Monthly Wellness Tracker Report</option>

                                        <?php 

					}					
                                         *  
                                         */
                                                    ?>
                                        

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

							{ ?>
                            
                            
                            <table width="920" border="0" cellspacing="0" cellpadding="0" >
                                <tr>
                                    <td width="40" height="45" align="left" valign="middle" class="Header_brown">Date:</td>
                                    <td width="220" align="left" valign="middle">
                                        <select name="date" id="date" style="width:200px;">
                                            <option value="">Select Date</option>
                                            <?php echo $obj->getEachMealPerDayDateListOptions($user_id,$start_date,$end_date,$date); ?>
                                        </select>
                                        
                                    </td>
                                    <td width="660" height="45" align="left" valign="middle"><input type="submit" name="btnSubmit" id="btnSubmit" value="View Report" /></td>
                                </tr>
                            </table>    
                            <table width="920" border="0" cellspacing="0" cellpadding="0">    
                                <tr id="tr_err_date" style="display:<?php echo $tr_err_date;?>;" valign="top">
                                    <td align="left" colspan="3" class="err_msg" id="err_date" valign="top"><?php echo $err_date;?></td>
                                </tr>
                            </table>
                            
                            <?php

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

																		echo $arr_dextrins['lunch'][$j];

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

																	  $dextrinslunch+=$arr_dextrins['lunch'][$i];



																	}

																	if($dextrinslunch!='0')

																	echo $dextrinslunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sugar['lunch'][$j] != '' )

																	{

																		echo $arr_sugar['lunch'][$j];

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

																	  $sugarlunch+=$arr_sugar['lunch'][$i];

																	}

																	if($sugarlunch!='0')

																	echo $sugarlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_vitamin['lunch'][$j] != '' )

																	{

																		echo $arr_total_vitamin['lunch'][$j];

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

																	  $total_vitaminlunch+=$arr_total_vitamin['lunch'][$i];

																	}

																	if($total_vitaminlunch!='0')

																	echo $total_vitaminlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_vitamin_a_acetate['lunch'][$j] != '' )

																	{

																		echo $arr_vitamin_a_acetate['lunch'][$j];

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

																	  $vitamin_a_acetatelunch+=$arr_vitamin_a_acetate['lunch'][$i];

																	}

																	if($vitamin_a_acetatelunch!='0')

																	echo $vitamin_a_acetatelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_vitamin_a_retinol['lunch'][$j] != '' )

																	{

																		echo $arr_vitamin_a_retinol['lunch'][$j];

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

																	  $vitamin_a_retinollunch+=$arr_vitamin_a_retinol['lunch'][$i];

																	}

																	if($vitamin_a_retinollunch!='0')

																	echo $vitamin_a_retinollunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_vitamin_b_complex['lunch'][$j] != '' )

																	{

																		echo $arr_total_vitamin_b_complex['lunch'][$j];

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

																	  $total_vitamin_b_complexlunch+=$arr_total_vitamin_b_complex['lunch'][$i];

																	}

																	if($total_vitamin_b_complexlunch!='0')

																	echo $total_vitamin_b_complexlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_thiamin['lunch'][$j] != '' )

																	{

																		echo $arr_thiamin['lunch'][$j];

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

																	  $thiaminlunch+=$arr_thiamin['lunch'][$i];

																	}

																	if($thiaminlunch!='0')

																	echo $thiaminlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_riboflavin['lunch'][$j] != '' )

																	{

																		echo $arr_riboflavin['lunch'][$j];

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

																	  $riboflavinlunch+=$arr_riboflavin['lunch'][$i];

																	}

																	if($riboflavinlunch!='0')

																	echo $riboflavinlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr height="50px">

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="50" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_niacin['lunch'][$j] != '' )

																	{

																		echo $arr_niacin['lunch'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="50" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['lunch']);$i++)

																	{

																	  $niacinlunch+=$$arr_niacin['lunch'][$i];

																	}

																	if($niacinlunch!='0')

																	echo $niacinlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_pantothenic_acid['lunch'][$j] != '' )

																	{

																		echo $arr_pantothenic_acid['lunch'][$j];

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

																	  $pantothenic_acidlunch+=$arr_pantothenic_acid['lunch'][$i];

																	}

																	if($pantothenic_acidlunch!='0')

																	echo $pantothenic_acidlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_pyridoxine_hcl['lunch'][$j] != '' )

																	{

																		echo $arr_pyridoxine_hcl['lunch'][$j];

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

																	  $pyridoxine_hcllunch+=$arr_pyridoxine_hcl['lunch'][$i];

																	}

																	if($pyridoxine_hcllunch!='0')

																	echo $pyridoxine_hcllunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cyanocobalamin['lunch'][$j] != '' )

																	{

																		echo $arr_cyanocobalamin['lunch'][$j];

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

																	  $cyanocobalaminlunch+=$arr_cyanocobalamin['lunch'][$i];

																	}

																	if($cyanocobalaminlunch!='0')

																	echo $cyanocobalaminlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_folic_acid['lunch'][$j] != '' )

																	{

																		echo $arr_folic_acid['lunch'][$j];

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

																	  $folic_acidlunch+=$arr_folic_acid['lunch'][$i];

																	}

																	if($folic_acidlunch!='0')

																	echo $folic_acidlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_biotin['lunch'][$j] != '' )

																	{

																		echo $arr_biotin['lunch'][$j];

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

																	  $biotinlunch+=$arr_biotin['lunch'][$i];

																	}

																	if($biotinlunch!='0')

																	echo $biotinlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_ascorbic_acid['lunch'][$j] != '' )

																	{

																		echo $arr_ascorbic_acid['lunch'][$j];

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

																	  $ascorbic_acidlunch+=$arr_ascorbic_acid['lunch'][$i];

																	}

																	if($ascorbic_acidlunch!='0')

																	echo $ascorbic_acidlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_calciferol['lunch'][$j] != '' )

																	{

																		echo $arr_calciferol['lunch'][$j];

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

																	  $calciferollunch+=$arr_calciferol['lunch'][$i];

																	}

																	if($calciferollunch!='0')

																	echo $calciferollunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tocopherol['lunch'][$j] != '' )

																	{

																		echo $arr_tocopherol['lunch'][$j];

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

																	  $tocopherollunch+=$arr_tocopherol['lunch'][$i];

																	}

																	if($tocopherollunch!='0')

																	echo $tocopherollunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phylloquinone['lunch'][$j] != '' )

																	{

																		echo $arr_phylloquinone['lunch'][$j];

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

																	  $phylloquinonelunch+=$arr_phylloquinone['lunch'][$i];

																	}

																	if($phylloquinonelunch!='0')

																	echo $phylloquinonelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_protein['lunch'][$j] != '' )

																	{

																		echo $arr_protein['lunch'][$j];

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

																	  $proteinlunch+=$arr_protein['lunch'][$i];

																	}

																	if($proteinlunch!='0')

																	echo $proteinlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_alanine['lunch'][$j] != '' )

																	{

																		echo $arr_alanine['lunch'][$j];

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

																	  $alaninelunch+=$arr_alanine['lunch'][$i];

																	}

																	if($alaninelunch!='0')

																	echo $alaninelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_arginine['lunch'][$j] != '' )

																	{

																		echo $arr_arginine['lunch'][$j];

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

																	  $argininelunch+=$arr_arginine['lunch'][$i];

																	}

																	if($argininelunch!='0')

																	echo $argininelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_aspartic_acid['lunch'][$j] != '' )

																	{

																		echo $arr_aspartic_acid['lunch'][$j];

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

																	  $aspartic_acidlunch+=$arr_aspartic_acid['lunch'][$i];

																	}

																	if($aspartic_acidlunch!='0')

																	echo $aspartic_acidlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cystine['lunch'][$j] != '' )

																	{

																		echo $arr_cystine['lunch'][$j];

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

																	  $cystinelunch+=$arr_cystine['lunch'][$i];

																	}

																	if($cystinelunch!='0')

																	echo $cystinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_giutamic_acid['lunch'][$j] != '' )

																	{

																		echo $arr_giutamic_acid['lunch'][$j];

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

																	  $giutamic_acidlunch+=$arr_giutamic_acid['lunch'][$i];

																	}

																	if($giutamic_acidlunch!='0')

																	echo $giutamic_acidlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_glycine['lunch'][$j] != '' )

																	{

																		echo $arr_glycine['lunch'][$j];

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

																	  $glycinelunch+=$arr_glycine['lunch'][$i];

																	}

																	if($glycinelunch!='0')

																	echo $glycinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_histidine['lunch'][$j] != '' )

																	{

																		echo $arr_histidine['lunch'][$j];

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

																	  $histidinelunch+=$arr_histidine['lunch'][$i];

																	}

																	if($histidinelunch!='0')

																	echo $histidinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_hydroxy_glutamic_acid['lunch'][$j] != '' )

																	{

																		echo $arr_hydroxy_glutamic_acid['lunch'][$j];

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

																	  $glutamic_acidlunch+=$arr_hydroxy_glutamic_acid['lunch'][$i];

																	}

																	if($glutamic_acidlunch!='0')

																	echo $glutamic_acidlunch;



																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_hydroxy_proline['lunch'][$j] != '' )

																	{

																		echo $arr_hydroxy_proline['lunch'][$j];

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

																	  $hydroxy_prolinelunch+=$arr_hydroxy_proline['lunch'][$i];

																	}

																	if($hydroxy_prolinelunch!='0')

																	echo $hydroxy_prolinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iodogorgoic_acid['lunch'][$j] != '' )

																	{

																		echo $arr_iodogorgoic_acid['lunch'][$j];

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

																	  $iodogorgoic_acidlunch+=$arr_iodogorgoic_acid['lunch'][$i];

																	}

																	if($iodogorgoic_acidlunch!='0')

																	echo $iodogorgoic_acidlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_isoleucine['lunch'][$j] != '' )

																	{

																		echo $arr_isoleucine['lunch'][$j];

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

																	  $isoleucinelunch+=$arr_isoleucine['lunch'][$i];

																	}

																	if($isoleucinelunch!='0')

																	echo $isoleucinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_leucine['lunch'][$j] != '' )

																	{

																		echo $arr_leucine['lunch'][$j];

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

																	  $leucinelunch+=$arr_leucine['lunch'][$i];

																	}

																	if($leucinelunch!='0')

																	echo $leucinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_lysine['lunch'][$j] != '' )

																	{

																		echo $arr_lysine['lunch'][$j];

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

																	  $lysinelunch+=$arr_lysine['lunch'][$i];

																	}

																	if($lysinelunch!='0')

																	echo $lysinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_methionine['lunch'][$j] != '' )

																	{

																		echo $arr_methionine['lunch'][$j];

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

																	  $methioninelunch+=$arr_methionine['lunch'][$i];

																	}

																	if($methioninelunch!='0')

																	echo $methioninelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr><tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_norleucine['lunch'][$j] != '' )

																	{

																		echo $arr_norleucine['lunch'][$j];

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

																	  $norleucinelunch+=$arr_norleucine['lunch'][$i];

																	}

																	if($norleucinelunch!='0')

																	echo $norleucinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phenylalanine['lunch'][$j] != '' )

																	{

																		echo $arr_phenylalanine['lunch'][$j];

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

																	  $phenylalaninelunch+=$arr_phenylalanine['lunch'][$i];

																	}

																	if($phenylalaninelunch!='0')

																	echo $phenylalaninelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_proline['lunch'][$j] != '' )

																	{

																		echo $arr_proline['lunch'][$j];

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

																	  $prolinelunch+=$arr_proline['lunch'][$i];

																	}

																	if($prolinelunch!='0')

																	echo $prolinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_serine['lunch'][$j] != '' )

																	{

																		echo $arr_serine['lunch'][$j];

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

																	  $serinelunch+=$arr_serine['lunch'][$i];

																	}

																	if($serinelunch!='0')

																	echo $serinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_threonine['lunch'][$j] != '' )

																	{

																		echo $arr_threonine['lunch'][$j];

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

																	  $threoninelunch+=$arr_threonine['lunch'][$i];

																	}

																	if($threoninelunch!='0')

																	echo $threoninelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_thyroxine['lunch'][$j] != '' )

																	{

																		echo $arr_thyroxine['lunch'][$j];

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

																	  $thyroxinelunch+=$arr_thyroxine['lunch'][$i];

																	}

																	if($thyroxinelunch!='0')

																	echo $thyroxinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tryptophane['lunch'][$j] != '' )

																	{

																		echo $arr_tryptophane['lunch'][$j];

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

																	  $tryptophanelunch+=$arr_tryptophane['lunch'][$i];

																	}

																	if($tryptophanelunch!='0')

																	echo $tryptophanelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tyrosine['lunch'][$j] != '' )

																	{

																		echo $arr_tyrosine['lunch'][$j];

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

																	  $tyrosinelunch+=$arr_tyrosine['lunch'][$i];

																	}

																	if($tyrosinelunch!='0')

																	echo $tyrosinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_valine['lunch'][$j] != '' )

																	{

																		echo $arr_valine['lunch'][$j];

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

																	  $valinelunch+=$arr_valine['lunch'][$i];

																	}

																	if($valinelunch!='0')

																	echo $valinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_minerals['lunch'][$j] != '' )

																	{

																		echo $arr_total_minerals['lunch'][$j];

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

																	  $total_mineralslunch+=$arr_total_minerals['lunch'][$i];

																	}

																	if($total_mineralslunch!='0')

																	echo $total_mineralslunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_calcium['lunch'][$j] != '' )

																	{

																		echo $arr_calcium['lunch'][$j];

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

																	  $calciumlunch+=$arr_calcium['lunch'][$i];

																	}

																	if($calciumlunch!='0')

																	echo $calciumlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iron['lunch'][$j] != '' )

																	{

																		echo $arr_iron['lunch'][$j];

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

																	  $ironlunch+=$arr_iron['lunch'][$i];

																	}

																	if($ironlunch!='0')

																	echo $ironlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_potassium['lunch'][$j] != '' )

																	{

																		echo $arr_potassium['lunch'][$j];

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

																	  $potassiumlunch+=$arr_potassium['lunch'][$i];

																	}

																	if($potassiumlunch!='0')

																	echo $potassiumlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sodium['lunch'][$j] != '' )

																	{

																		echo $arr_sodium['lunch'][$j];

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

																	  $sodiumlunch+=$arr_sodium['lunch'][$i];

																	}

																	if($sodiumlunch!='0')

																	echo $sodiumlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phosphorus['lunch'][$j] != '' )

																	{

																		echo $arr_phosphorus['lunch'][$j];

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

																	  $phosphoruslunch+=$arr_phosphorus['lunch'][$i];

																	}

																	if($phosphoruslunch!='0')

																	echo $phosphoruslunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sulphur['lunch'][$j] != '' )

																	{

																		echo $arr_sulphur['lunch'][$j];

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

																	  $sulphurlunch+=$arr_sulphur['lunch'][$i];

																	}

																	if($sulphurlunch!='0')

																	echo $sulphurlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_chlorine['lunch'][$j] != '' )

																	{

																		echo $arr_chlorine['lunch'][$j];

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

																	  $chlorinelunch+=$arr_chlorine['lunch'][$i];

																	}

																	if($chlorinelunch!='0')

																	echo $chlorinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>



																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iodine['lunch'][$j] != '' )

																	{

																		echo $arr_iodine['lunch'][$j];

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

																	  $iodinelunch+=$arr_iodine['lunch'][$i];

																	}

																	if($iodinelunch!='0')

																	echo $iodinelunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_magnesium['lunch'][$j] != '' )

																	{

																		echo $arr_magnesium['lunch'][$j];

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

																	  $magnesiumlunch+=$arr_magnesium['lunch'][$i];

																	}

																	if($magnesiumlunch!='0')

																	echo $magnesiumlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_zinc['lunch'][$j] != '' )

																	{

																		echo $arr_zinc['lunch'][$j];

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

																	  $zinclunch+=$arr_zinc['lunch'][$i];

																	}

																	if($zinclunch!='0')

																	echo $zinclunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_copper['lunch'][$j] != '' )

																	{

																		echo $arr_copper['lunch'][$j];

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

																	  $copperlunch+=$arr_copper['lunch'][$i];

																	}

																	if($copperlunch!='0')

																	echo $copperlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr><tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_chromium['lunch'][$j] != '' )

																	{

																		echo $arr_chromium['lunch'][$j];

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

																	  $chromiumlunch+=$arr_chromium['lunch'][$i];

																	}

																	if($chromiumlunch!='0')

																	echo $chromiumlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_manganese['lunch'][$j] != '' )

																	{

																		echo $arr_manganese['lunch'][$j];

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

																	  $manganeselunch+=$arr_manganese['lunch'][$i];

																	}

																	if($manganeselunch!='0')

																	echo $manganeselunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_selenium['lunch'][$j] != '' )

																	{

																		echo $arr_selenium['lunch'][$j];

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

																	  $seleniumlunch+=$arr_selenium['lunch'][$i];

																	}

																	if($seleniumlunch!='0')

																	echo $seleniumlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_boron['lunch'][$j] != '' )

																	{

																		echo $arr_boron['lunch'][$j];

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

																	  $boronlunch+=$arr_boron['lunch'][$i];

																	}

																	if($boronlunch!='0')

																	echo $boronlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_molybdenum['lunch'][$j] != '' )



																	{

																		echo $arr_molybdenum['lunch'][$j];

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

																	  $molybdenumlunch+=$arr_molybdenum['lunch'][$i];

																	}

																	if($molybdenumlunch!='0')

																	echo $molybdenumlunch;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_caffeine['lunch'][$j] != '' )

																	{

																		echo $arr_caffeine['lunch'][$j];

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

																	  $caffeinelunch+=$arr_caffeine['lunch'][$i];

																	}

																	if($caffeinelunch!='0')

																	echo $caffeinelunch;

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

												for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	

																	<?php

																	if($arr_meal_time['snacks'][$j] != '' )

																	{ 

													?>	

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">

													<tr>

														<td width="864" align="left" height="20" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;<strong>Snacks</strong></td>

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

																	<td width="179" height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Measure of edible<br />&nbsp;portion Serving Size</td>

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

																<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Total fat(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Saturated(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Monounsaturated(g)</td>

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

																	<td width="179" height="50" align="left" valign="middle" bgcolor="#E1E1E1"  class="report_header">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />

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

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_time['snacks'][$j] != '' )

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

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_time['snacks'][$j] != '' )

																	{

																		echo $arr_meal_time['snacks'][$j];

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

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_item['snacks'][$j] != '' )

																	{

																		echo $arr_meal_item['snacks'][$j];

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

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_measure['snacks'][$j] != '' )

																	{

																		echo $arr_meal_measure['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="50" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_ml['snacks'][$j] != '' )

																	{

																		echo $arr_meal_ml['snacks'][$j];

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

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_weight['snacks'][$j] != '' )

																	{

																		echo $arr_weight['snacks'][$j];

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

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_water['snacks'][$j] != '' )

																	{

																		echo $arr_water['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $watersnacks+=$arr_water['snacks'][$i];

																	}

																	if($watersnacks!='0')

																	echo $watersnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_calories['snacks'][$j] != '' )

																	{

																		echo $arr_calories['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $caloriessnacks+=$arr_calories['snacks'][$i];

																	}

																	if($caloriessnacks!='0')

																	echo $caloriessnacks;

																	else

																	echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_fat['snacks'][$j] != '' )

																	{

																		echo $arr_total_fat['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																																		</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $fatsnacks+=$arr_total_fat['snacks'][$i];

																	}

																	if($fatsnacks!='0')

																	echo $fatsnacks;

																	else

																	echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_saturated['snacks'][$j] != '' )

																	{

																		echo $arr_saturated['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  	$saturatedsnacks+=$arr_saturated['snacks'][$i];

																	}

																		if($saturatedsnacks!='0')

																		echo $saturatedsnacks;

																		else

																		echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_monounsaturated['snacks'][$j] != '' )

																	{

																		echo $arr_monounsaturated['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	 &nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  	$monounsaturatedsnacks+=$arr_monounsaturated['snacks'][$i];

																	}

																		if($monounsaturatedsnacks!='0')

																		echo $monounsaturatedsnacks;

																		else

																		echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php

																	if($arr_polyunsaturated['snacks'][$j] != '' )

																	{

																		echo $arr_polyunsaturated['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  	$polyunsaturatedsnacks+=$arr_polyunsaturated['snacks'][$i];

																	}

																		if($polyunsaturatedsnacks!='0')

																		echo $polyunsaturatedsnacks;

																		else

																		echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_polyunsaturated_linoleic['snacks'][$j] != '' )

																	{

																		echo $arr_polyunsaturated_linoleic['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $polyunsaturatedsnacks+=$arr_polyunsaturated_linoleic['snacks'][$i];

																	}

																	if($polyunsaturatedsnacks!='0')

																	echo $polyunsaturatedsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_polyunsaturated_alphalinoleic['snacks'][$j] != '' )

																	{

																		echo $arr_polyunsaturated_alphalinoleic['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $alphalinoleicsnacks+=$arr_polyunsaturated_alphalinoleic['snacks'][$i];

																	}

																	if($alphalinoleicsnacks!='0')

																	echo $alphalinoleicsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_cholesterol['snacks'][$j] != '' )

																	{

																		echo $arr_cholesterol['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $cholesterolsnacks+=$arr_cholesterol['snacks'][$i];

																	}

																	if($cholesterolsnacks!='0')

																	echo $cholesterolsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_total_dietary_fiber['snacks'][$j] != '' )

																	{

																		echo $arr_total_dietary_fiber['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $dietary_fibersnacks+=$arr_total_dietary_fiber['snacks'][$i];

																	}

																	if($dietary_fibersnacks!='0')

																	echo $dietary_fibersnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_carbohydrate['snacks'][$j] != '' )

																	{

																		echo $arr_carbohydrate['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $carbohydratesnacks+=$arr_carbohydrate['snacks'][$i];

																	}

																	if($carbohydratesnacks!='0')

																	echo $carbohydratesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_glucose['snacks'][$j] != '' )

																	{

																		echo $arr_glucose['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $glucosesnacks+=$arr_glucose['snacks'][$i];

																	}

																	if($glucosesnacks!='0')

																	echo $glucosesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_fructose['snacks'][$j] != '' )

																	{

																		echo $arr_fructose['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $fructosesnacks+=$arr_fructose['snacks'][$i];

																	}

																	if($fructosesnacks!='0')

																	echo $fructosesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_galactose['snacks'][$j] != '' )

																	{

																		echo $arr_galactose['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $galactosesnacks+=$arr_galactose['snacks'][$i];

																	}

																	if($galactosesnacks!='0')

																	echo $galactosesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_disaccharide['snacks'][$j] != '' )

																	{

																		echo $arr_disaccharide['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $disaccharidesnacks+=$arr_disaccharide['snacks'][$i];

																	}

																	if($disaccharidesnacks!='0')

																	echo $disaccharidesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_maltose['snacks'][$j] != '' )

																	{

																		echo $arr_maltose['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $maltosesnacks+=$arr_maltose['snacks'][$i];

																	}

																	if($maltosesnacks!='0')

																	echo $maltosesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_lactose['snacks'][$j] != '' )

																	{

																		echo $arr_lactose['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $lactose+=$arr_lactose['snacks'][$i];

																	}

																	if($lactose!='0')

																	echo $lactose;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_sucrose['snacks'][$j] != '' )

																	{

																		echo $arr_sucrose['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $sucrosesnacks+=$arr_sucrose['snacks'][$i];

																	}

																	if($sucrosesnacks!='0')

																	echo $sucrosesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_total_polysaccharide['snacks'][$j] != '' )

																	{

																		echo $arr_total_polysaccharide['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $polysaccharidesnacks+=$arr_total_polysaccharide['snacks'][$i];

																	}

																	if($polysaccharidesnacks!='0')

																	echo $polysaccharidesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_starch['snacks'][$j] != '' )

																	{

																		echo $arr_starch['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $starchsnacks+=$arr_starch['snacks'][$i];

																	}

																	if($starchsnacks!='0')

																	echo $starchsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cellulose['snacks'][$j] != '' )

																	{

																		echo $arr_cellulose['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $cellulosesnacks+=$arr_cellulose['snacks'][$i];

																	}

																	if($cellulosesnacks!='0')

																	echo $cellulosesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_glycogen['snacks'][$j] != '' )

																	{

																		echo $arr_glycogen['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $glycogensnacks+=$arr_glycogen['snacks'][$i];

																	}

																	if($glycogensnacks!='0')

																	echo $glycogensnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_dextrins['snacks'][$j] != '' )

																	{

																		echo $arr_dextrins['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $dextrinssnacks+=$arr_dextrins['snacks'][$i];



																	}

																	if($dextrinssnacks!='0')

																	echo $dextrinssnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sugar['snacks'][$j] != '' )

																	{

																		echo $arr_sugar['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $sugarsnacks+=$arr_sugar['snacks'][$i];

																	}

																	if($sugarsnacks!='0')

																	echo $sugarsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_vitamin['snacks'][$j] != '' )

																	{

																		echo $arr_total_vitamin['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $total_vitaminsnacks+=$arr_total_vitamin['snacks'][$i];

																	}

																	if($total_vitaminsnacks!='0')

																	echo $total_vitaminsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_vitamin_a_acetate['snacks'][$j] != '' )

																	{

																		echo $arr_vitamin_a_acetate['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $vitamin_a_acetatesnacks+=$arr_vitamin_a_acetate['snacks'][$i];

																	}

																	if($vitamin_a_acetatesnacks!='0')

																	echo $vitamin_a_acetatesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_vitamin_a_retinol['snacks'][$j] != '' )

																	{

																		echo $arr_vitamin_a_retinol['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $vitamin_a_retinolsnacks+=$arr_vitamin_a_retinol['snacks'][$i];

																	}

																	if($vitamin_a_retinolsnacks!='0')

																	echo $vitamin_a_retinolsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_vitamin_b_complex['snacks'][$j] != '' )

																	{

																		echo $arr_total_vitamin_b_complex['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $total_vitamin_b_complexsnacks+=$arr_total_vitamin_b_complex['snacks'][$i];

																	}

																	if($total_vitamin_b_complexsnacks!='0')

																	echo $total_vitamin_b_complexsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_thiamin['snacks'][$j] != '' )

																	{

																		echo $arr_thiamin['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $thiaminsnacks+=$arr_thiamin['snacks'][$i];

																	}

																	if($thiaminsnacks!='0')

																	echo $thiaminsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_riboflavin['snacks'][$j] != '' )

																	{

																		echo $arr_riboflavin['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $riboflavinsnacks+=$arr_riboflavin['snacks'][$i];

																	}

																	if($riboflavinsnacks!='0')

																	echo $riboflavinsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr height="50px">

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="50" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_niacin['snacks'][$j] != '' )

																	{

																		echo $arr_niacin['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="50" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $niacinsnacks+=$$arr_niacin['snacks'][$i];

																	}

																	if($niacinsnacks!='0')

																	echo $niacinsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_pantothenic_acid['snacks'][$j] != '' )

																	{

																		echo $arr_pantothenic_acid['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $pantothenic_acidsnacks+=$arr_pantothenic_acid['snacks'][$i];

																	}

																	if($pantothenic_acidsnacks!='0')

																	echo $pantothenic_acidsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_pyridoxine_hcl['snacks'][$j] != '' )

																	{

																		echo $arr_pyridoxine_hcl['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $pyridoxine_hclsnacks+=$arr_pyridoxine_hcl['snacks'][$i];

																	}

																	if($pyridoxine_hclsnacks!='0')

																	echo $pyridoxine_hclsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cyanocobalamin['snacks'][$j] != '' )

																	{

																		echo $arr_cyanocobalamin['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $cyanocobalaminsnacks+=$arr_cyanocobalamin['snacks'][$i];

																	}

																	if($cyanocobalaminsnacks!='0')

																	echo $cyanocobalaminsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_folic_acid['snacks'][$j] != '' )

																	{

																		echo $arr_folic_acid['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $folic_acidsnacks+=$arr_folic_acid['snacks'][$i];

																	}

																	if($folic_acidsnacks!='0')

																	echo $folic_acidsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_biotin['snacks'][$j] != '' )

																	{

																		echo $arr_biotin['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $biotinsnacks+=$arr_biotin['snacks'][$i];

																	}

																	if($biotinsnacks!='0')

																	echo $biotinsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_ascorbic_acid['snacks'][$j] != '' )

																	{

																		echo $arr_ascorbic_acid['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $ascorbic_acidsnacks+=$arr_ascorbic_acid['snacks'][$i];

																	}

																	if($ascorbic_acidsnacks!='0')

																	echo $ascorbic_acidsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_calciferol['snacks'][$j] != '' )

																	{

																		echo $arr_calciferol['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $calciferolsnacks+=$arr_calciferol['snacks'][$i];

																	}

																	if($calciferolsnacks!='0')

																	echo $calciferolsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tocopherol['snacks'][$j] != '' )

																	{

																		echo $arr_tocopherol['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $tocopherolsnacks+=$arr_tocopherol['snacks'][$i];

																	}

																	if($tocopherolsnacks!='0')

																	echo $tocopherolsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phylloquinone['snacks'][$j] != '' )

																	{

																		echo $arr_phylloquinone['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $phylloquinonesnacks+=$arr_phylloquinone['snacks'][$i];

																	}

																	if($phylloquinonesnacks!='0')

																	echo $phylloquinonesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_protein['snacks'][$j] != '' )

																	{

																		echo $arr_protein['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $proteinsnacks+=$arr_protein['snacks'][$i];

																	}

																	if($proteinsnacks!='0')

																	echo $proteinsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_alanine['snacks'][$j] != '' )

																	{

																		echo $arr_alanine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $alaninesnacks+=$arr_alanine['snacks'][$i];

																	}

																	if($alaninesnacks!='0')

																	echo $alaninesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_arginine['snacks'][$j] != '' )

																	{

																		echo $arr_arginine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $argininesnacks+=$arr_arginine['snacks'][$i];

																	}

																	if($argininesnacks!='0')

																	echo $argininesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_aspartic_acid['snacks'][$j] != '' )

																	{

																		echo $arr_aspartic_acid['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $aspartic_acidsnacks+=$arr_aspartic_acid['snacks'][$i];

																	}

																	if($aspartic_acidsnacks!='0')

																	echo $aspartic_acidsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cystine['snacks'][$j] != '' )

																	{

																		echo $arr_cystine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $cystinesnacks+=$arr_cystine['snacks'][$i];

																	}

																	if($cystinesnacks!='0')

																	echo $cystinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_giutamic_acid['snacks'][$j] != '' )

																	{

																		echo $arr_giutamic_acid['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $giutamic_acidsnacks+=$arr_giutamic_acid['snacks'][$i];

																	}

																	if($giutamic_acidsnacks!='0')

																	echo $giutamic_acidsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_glycine['snacks'][$j] != '' )

																	{

																		echo $arr_glycine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $glycinesnacks+=$arr_glycine['snacks'][$i];

																	}

																	if($glycinesnacks!='0')

																	echo $glycinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_histidine['snacks'][$j] != '' )

																	{

																		echo $arr_histidine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $histidinesnacks+=$arr_histidine['snacks'][$i];

																	}

																	if($histidinesnacks!='0')

																	echo $histidinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_hydroxy_glutamic_acid['snacks'][$j] != '' )

																	{

																		echo $arr_hydroxy_glutamic_acid['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $glutamic_acidsnacks+=$arr_hydroxy_glutamic_acid['snacks'][$i];

																	}

																	if($glutamic_acidsnacks!='0')

																	echo $glutamic_acidsnacks;



																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_hydroxy_proline['snacks'][$j] != '' )

																	{

																		echo $arr_hydroxy_proline['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $hydroxy_prolinesnacks+=$arr_hydroxy_proline['snacks'][$i];

																	}

																	if($hydroxy_prolinesnacks!='0')

																	echo $hydroxy_prolinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iodogorgoic_acid['snacks'][$j] != '' )

																	{

																		echo $arr_iodogorgoic_acid['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $iodogorgoic_acidsnacks+=$arr_iodogorgoic_acid['snacks'][$i];

																	}

																	if($iodogorgoic_acidsnacks!='0')

																	echo $iodogorgoic_acidsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_isoleucine['snacks'][$j] != '' )

																	{

																		echo $arr_isoleucine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $isoleucinesnacks+=$arr_isoleucine['snacks'][$i];

																	}

																	if($isoleucinesnacks!='0')

																	echo $isoleucinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_leucine['snacks'][$j] != '' )

																	{

																		echo $arr_leucine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $leucinesnacks+=$arr_leucine['snacks'][$i];

																	}

																	if($leucinesnacks!='0')

																	echo $leucinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_lysine['snacks'][$j] != '' )

																	{

																		echo $arr_lysine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $lysinesnacks+=$arr_lysine['snacks'][$i];

																	}

																	if($lysinesnacks!='0')

																	echo $lysinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_methionine['snacks'][$j] != '' )

																	{

																		echo $arr_methionine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $methioninesnacks+=$arr_methionine['snacks'][$i];

																	}

																	if($methioninesnacks!='0')

																	echo $methioninesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr><tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_norleucine['snacks'][$j] != '' )

																	{

																		echo $arr_norleucine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $norleucinesnacks+=$arr_norleucine['snacks'][$i];

																	}

																	if($norleucinesnacks!='0')

																	echo $norleucinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phenylalanine['snacks'][$j] != '' )

																	{

																		echo $arr_phenylalanine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>



																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $phenylalaninesnacks+=$arr_phenylalanine['snacks'][$i];

																	}

																	if($phenylalaninesnacks!='0')

																	echo $phenylalaninesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_proline['snacks'][$j] != '' )

																	{

																		echo $arr_proline['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $prolinesnacks+=$arr_proline['snacks'][$i];

																	}

																	if($prolinesnacks!='0')

																	echo $prolinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_serine['snacks'][$j] != '' )

																	{

																		echo $arr_serine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $serinesnacks+=$arr_serine['snacks'][$i];

																	}

																	if($serinesnacks!='0')

																	echo $serinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_threonine['snacks'][$j] != '' )

																	{

																		echo $arr_threonine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $threoninesnacks+=$arr_threonine['snacks'][$i];

																	}

																	if($threoninesnacks!='0')

																	echo $threoninesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_thyroxine['snacks'][$j] != '' )

																	{

																		echo $arr_thyroxine['snacks'][$j];

																	}



																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $thyroxinesnacks+=$arr_thyroxine['snacks'][$i];

																	}

																	if($thyroxinesnacks!='0')

																	echo $thyroxinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tryptophane['snacks'][$j] != '' )

																	{

																		echo $arr_tryptophane['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $tryptophanesnacks+=$arr_tryptophane['snacks'][$i];

																	}

																	if($tryptophanesnacks!='0')

																	echo $tryptophanesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tyrosine['snacks'][$j] != '' )

																	{

																		echo $arr_tyrosine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $tyrosinesnacks+=$arr_tyrosine['snacks'][$i];

																	}

																	if($tyrosinesnacks!='0')

																	echo $tyrosinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_valine['snacks'][$j] != '' )

																	{

																		echo $arr_valine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $valinesnacks+=$arr_valine['snacks'][$i];

																	}

																	if($valinesnacks!='0')

																	echo $valinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_minerals['snacks'][$j] != '' )

																	{

																		echo $arr_total_minerals['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $total_mineralssnacks+=$arr_total_minerals['snacks'][$i];

																	}

																	if($total_mineralssnacks!='0')

																	echo $total_mineralssnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_calcium['snacks'][$j] != '' )

																	{

																		echo $arr_calcium['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $calciumsnacks+=$arr_calcium['snacks'][$i];

																	}

																	if($calciumsnacks!='0')

																	echo $calciumsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iron['snacks'][$j] != '' )

																	{

																		echo $arr_iron['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $ironsnacks+=$arr_iron['snacks'][$i];

																	}

																	if($ironsnacks!='0')

																	echo $ironsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_potassium['snacks'][$j] != '' )

																	{

																		echo $arr_potassium['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $potassiumsnacks+=$arr_potassium['snacks'][$i];

																	}

																	if($potassiumsnacks!='0')

																	echo $potassiumsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sodium['snacks'][$j] != '' )

																	{

																		echo $arr_sodium['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $sodiumsnacks+=$arr_sodium['snacks'][$i];

																	}

																	if($sodiumsnacks!='0')

																	echo $sodiumsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phosphorus['snacks'][$j] != '' )

																	{

																		echo $arr_phosphorus['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $phosphorussnacks+=$arr_phosphorus['snacks'][$i];

																	}

																	if($phosphorussnacks!='0')

																	echo $phosphorussnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sulphur['snacks'][$j] != '' )

																	{

																		echo $arr_sulphur['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $sulphursnacks+=$arr_sulphur['snacks'][$i];

																	}

																	if($sulphursnacks!='0')

																	echo $sulphursnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_chlorine['snacks'][$j] != '' )

																	{

																		echo $arr_chlorine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $chlorinesnacks+=$arr_chlorine['snacks'][$i];

																	}

																	if($chlorinesnacks!='0')

																	echo $chlorinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>



																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iodine['snacks'][$j] != '' )

																	{

																		echo $arr_iodine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $iodinesnacks+=$arr_iodine['snacks'][$i];

																	}

																	if($iodinesnacks!='0')

																	echo $iodinesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_magnesium['snacks'][$j] != '' )

																	{

																		echo $arr_magnesium['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $magnesiumsnacks+=$arr_magnesium['snacks'][$i];

																	}

																	if($magnesiumsnacks!='0')

																	echo $magnesiumsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_zinc['snacks'][$j] != '' )

																	{

																		echo $arr_zinc['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $zincsnacks+=$arr_zinc['snacks'][$i];

																	}

																	if($zincsnacks!='0')

																	echo $zincsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_copper['snacks'][$j] != '' )

																	{

																		echo $arr_copper['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $coppersnacks+=$arr_copper['snacks'][$i];

																	}

																	if($coppersnacks!='0')

																	echo $coppersnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr><tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_chromium['snacks'][$j] != '' )

																	{

																		echo $arr_chromium['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $chromiumsnacks+=$arr_chromium['snacks'][$i];

																	}

																	if($chromiumsnacks!='0')

																	echo $chromiumsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_manganese['snacks'][$j] != '' )

																	{

																		echo $arr_manganese['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $manganesesnacks+=$arr_manganese['snacks'][$i];

																	}

																	if($manganesesnacks!='0')

																	echo $manganesesnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_selenium['snacks'][$j] != '' )

																	{

																		echo $arr_selenium['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $seleniumsnacks+=$arr_selenium['snacks'][$i];

																	}

																	if($seleniumsnacks!='0')

																	echo $seleniumsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_boron['snacks'][$j] != '' )

																	{

																		echo $arr_boron['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $boronsnacks+=$arr_boron['snacks'][$i];

																	}

																	if($boronsnacks!='0')

																	echo $boronsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_molybdenum['snacks'][$j] != '' )

																	{

																		echo $arr_molybdenum['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $molybdenumsnacks+=$arr_molybdenum['snacks'][$i];

																	}

																	if($molybdenumsnacks!='0')

																	echo $molybdenumsnacks;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_caffeine['snacks'][$j] != '' )

																	{

																		echo $arr_caffeine['snacks'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['snacks']);$i++)

																	{

																	  $caffeinesnacks+=$arr_caffeine['snacks'][$i];

																	}

																	if($caffeinesnacks!='0')

																	echo $caffeinesnacks;

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

												for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	

																	<?php

																	if($arr_meal_time['dinner'][$j] != '' )

																	{ 											

											?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">

													<tr>

														<td width="864" align="left" height="20" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;<strong>Dinner</strong></td>

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

																<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Total fat(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Saturated(g)</td>

																</tr>

															</table>

															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">

																<tr>

																	<td width="179" align="left" valign="middle" bgcolor="#E1E1E1" height="30" class="report_header">&nbsp;Monounsaturated(g)</td>

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

																	<td width="179" height="50" align="left" valign="middle" bgcolor="#E1E1E1"  class="report_header">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />

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

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_time['dinner'][$j] != '' )

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

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_time['dinner'][$j] != '' )

																	{

																		echo $arr_meal_time['dinner'][$j];

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

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_item['dinner'][$j] != '' )

																	{

																		echo $arr_meal_item['dinner'][$j];

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

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_measure['dinner'][$j] != '' )

																	{

																		echo $arr_meal_measure['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="50" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_meal_ml['dinner'][$j] != '' )

																	{

																		echo $arr_meal_ml['dinner'][$j];

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

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_weight['dinner'][$j] != '' )

																	{

																		echo $arr_weight['dinner'][$j];

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

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_water['dinner'][$j] != '' )

																	{

																		echo $arr_water['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $waterdinner+=$arr_water['dinner'][$i];

																	}

																	if($waterdinner!='0')

																	echo $waterdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_calories['dinner'][$j] != '' )

																	{

																		echo $arr_calories['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $caloriesdinner+=$arr_calories['dinner'][$i];

																	}

																	if($caloriesdinner!='0')

																	echo $caloriesdinner;

																	else

																	echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_fat['dinner'][$j] != '' )

																	{

																		echo $arr_total_fat['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																																		</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $fatdinner+=$arr_total_fat['dinner'][$i];

																	}

																	if($fatdinner!='0')

																	echo $fatdinner;

																	else

																	echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_saturated['dinner'][$j] != '' )

																	{

																		echo $arr_saturated['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

																	<?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  	$saturateddinner+=$arr_saturated['dinner'][$i];

																	}

																		if($saturateddinner!='0')

																		echo $saturateddinner;

																		else

																		echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_monounsaturated['dinner'][$j] != '' )

																	{

																		echo $arr_monounsaturated['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	 &nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  	$monounsaturateddinner+=$arr_monounsaturated['dinner'][$i];

																	}

																		if($monounsaturateddinner!='0')

																		echo $monounsaturateddinner;

																		else

																		echo '&nbsp;';

																	?>																	</td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php

																	if($arr_polyunsaturated['dinner'][$j] != '' )

																	{

																		echo $arr_polyunsaturated['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;<?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  	$polyunsaturateddinner+=$arr_polyunsaturated['dinner'][$i];

																	}

																		if($polyunsaturateddinner!='0')

																		echo $polyunsaturateddinner;

																		else

																		echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_polyunsaturated_linoleic['dinner'][$j] != '' )

																	{

																		echo $arr_polyunsaturated_linoleic['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $polyunsaturateddinner+=$arr_polyunsaturated_linoleic['dinner'][$i];

																	}

																	if($polyunsaturateddinner!='0')

																	echo $polyunsaturateddinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_polyunsaturated_alphalinoleic['dinner'][$j] != '' )

																	{

																		echo $arr_polyunsaturated_alphalinoleic['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $alphalinoleicdinner+=$arr_polyunsaturated_alphalinoleic['dinner'][$i];

																	}

																	if($alphalinoleicdinner!='0')

																	echo $alphalinoleicdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_cholesterol['dinner'][$j] != '' )

																	{

																		echo $arr_cholesterol['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $cholesteroldinner+=$arr_cholesterol['dinner'][$i];

																	}

																	if($cholesteroldinner!='0')

																	echo $cholesteroldinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_total_dietary_fiber['dinner'][$j] != '' )

																	{

																		echo $arr_total_dietary_fiber['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $dietary_fiberdinner+=$arr_total_dietary_fiber['dinner'][$i];

																	}

																	if($dietary_fiberdinner!='0')

																	echo $dietary_fiberdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_carbohydrate['dinner'][$j] != '' )

																	{

																		echo $arr_carbohydrate['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $carbohydratedinner+=$arr_carbohydrate['dinner'][$i];

																	}

																	if($carbohydratedinner!='0')

																	echo $carbohydratedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_glucose['dinner'][$j] != '' )

																	{

																		echo $arr_glucose['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $glucosedinner+=$arr_glucose['dinner'][$i];

																	}

																	if($glucosedinner!='0')

																	echo $glucosedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30"  align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_fructose['dinner'][$j] != '' )

																	{

																		echo $arr_fructose['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $fructosedinner+=$arr_fructose['dinner'][$i];

																	}

																	if($fructosedinner!='0')

																	echo $fructosedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_galactose['dinner'][$j] != '' )

																	{

																		echo $arr_galactose['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $galactosedinner+=$arr_galactose['dinner'][$i];

																	}

																	if($galactosedinner!='0')

																	echo $galactosedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_disaccharide['dinner'][$j] != '' )

																	{

																		echo $arr_disaccharide['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $disaccharidedinner+=$arr_disaccharide['dinner'][$i];

																	}

																	if($disaccharidedinner!='0')

																	echo $disaccharidedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_maltose['dinner'][$j] != '' )

																	{

																		echo $arr_maltose['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $maltosedinner+=$arr_maltose['dinner'][$i];

																	}

																	if($maltosedinner!='0')

																	echo $maltosedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_lactose['dinner'][$j] != '' )

																	{

																		echo $arr_lactose['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $lactose+=$arr_lactose['dinner'][$i];

																	}

																	if($lactose!='0')

																	echo $lactose;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_sucrose['dinner'][$j] != '' )

																	{

																		echo $arr_sucrose['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $sucrosedinner+=$arr_sucrose['dinner'][$i];

																	}

																	if($sucrosedinner!='0')

																	echo $sucrosedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_total_polysaccharide['dinner'][$j] != '' )

																	{

																		echo $arr_total_polysaccharide['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $polysaccharidedinner+=$arr_total_polysaccharide['dinner'][$i];

																	}

																	if($polysaccharidedinner!='0')

																	echo $polysaccharidedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">

																	<?php

																	if($arr_starch['dinner'][$j] != '' )

																	{

																		echo $arr_starch['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?>																	</td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $starchdinner+=$arr_starch['dinner'][$i];

																	}

																	if($starchdinner!='0')

																	echo $starchdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cellulose['dinner'][$j] != '' )

																	{

																		echo $arr_cellulose['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $cellulosedinner+=$arr_cellulose['dinner'][$i];

																	}

																	if($cellulosedinner!='0')

																	echo $cellulosedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_glycogen['dinner'][$j] != '' )

																	{

																		echo $arr_glycogen['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $glycogendinner+=$arr_glycogen['dinner'][$i];

																	}

																	if($glycogendinner!='0')

																	echo $glycogendinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_dextrins['dinner'][$j] != '' )

																	{

																		echo $arr_dextrins['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $dextrinsdinner+=$arr_dextrins['dinner'][$i];



																	}

																	if($dextrinsdinner!='0')

																	echo $dextrinsdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sugar['dinner'][$j] != '' )

																	{

																		echo $arr_sugar['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $sugardinner+=$arr_sugar['dinner'][$i];

																	}

																	if($sugardinner!='0')

																	echo $sugardinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_vitamin['dinner'][$j] != '' )

																	{

																		echo $arr_total_vitamin['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $total_vitamindinner+=$arr_total_vitamin['dinner'][$i];

																	}

																	if($total_vitamindinner!='0')

																	echo $total_vitamindinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_vitamin_a_acetate['dinner'][$j] != '' )

																	{

																		echo $arr_vitamin_a_acetate['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $vitamin_a_acetatedinner+=$arr_vitamin_a_acetate['dinner'][$i];

																	}

																	if($vitamin_a_acetatedinner!='0')

																	echo $vitamin_a_acetatedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_vitamin_a_retinol['dinner'][$j] != '' )

																	{

																		echo $arr_vitamin_a_retinol['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $vitamin_a_retinoldinner+=$arr_vitamin_a_retinol['dinner'][$i];

																	}

																	if($vitamin_a_retinoldinner!='0')

																	echo $vitamin_a_retinoldinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_vitamin_b_complex['dinner'][$j] != '' )

																	{

																		echo $arr_total_vitamin_b_complex['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $total_vitamin_b_complexdinner+=$arr_total_vitamin_b_complex['dinner'][$i];

																	}

																	if($total_vitamin_b_complexdinner!='0')

																	echo $total_vitamin_b_complexdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_thiamin['dinner'][$j] != '' )

																	{

																		echo $arr_thiamin['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $thiamindinner+=$arr_thiamin['dinner'][$i];

																	}

																	if($thiamindinner!='0')

																	echo $thiamindinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_riboflavin['dinner'][$j] != '' )

																	{

																		echo $arr_riboflavin['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $riboflavindinner+=$arr_riboflavin['dinner'][$i];

																	}

																	if($riboflavindinner!='0')

																	echo $riboflavindinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr height="50px">

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="50" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_niacin['dinner'][$j] != '' )

																	{

																		echo $arr_niacin['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="50" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $niacindinner+=$$arr_niacin['dinner'][$i];

																	}

																	if($niacindinner!='0')

																	echo $niacindinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_pantothenic_acid['dinner'][$j] != '' )

																	{

																		echo $arr_pantothenic_acid['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $pantothenic_aciddinner+=$arr_pantothenic_acid['dinner'][$i];

																	}

																	if($pantothenic_aciddinner!='0')

																	echo $pantothenic_aciddinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_pyridoxine_hcl['dinner'][$j] != '' )

																	{

																		echo $arr_pyridoxine_hcl['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $pyridoxine_hcldinner+=$arr_pyridoxine_hcl['dinner'][$i];

																	}

																	if($pyridoxine_hcldinner!='0')

																	echo $pyridoxine_hcldinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cyanocobalamin['dinner'][$j] != '' )

																	{

																		echo $arr_cyanocobalamin['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $cyanocobalamindinner+=$arr_cyanocobalamin['dinner'][$i];

																	}

																	if($cyanocobalamindinner!='0')

																	echo $cyanocobalamindinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_folic_acid['dinner'][$j] != '' )

																	{

																		echo $arr_folic_acid['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $folic_aciddinner+=$arr_folic_acid['dinner'][$i];

																	}

																	if($folic_aciddinner!='0')

																	echo $folic_aciddinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_biotin['dinner'][$j] != '' )

																	{

																		echo $arr_biotin['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $biotindinner+=$arr_biotin['dinner'][$i];

																	}

																	if($biotindinner!='0')

																	echo $biotindinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_ascorbic_acid['dinner'][$j] != '' )

																	{

																		echo $arr_ascorbic_acid['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $ascorbic_aciddinner+=$arr_ascorbic_acid['dinner'][$i];

																	}

																	if($ascorbic_aciddinner!='0')

																	echo $ascorbic_aciddinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_calciferol['dinner'][$j] != '' )

																	{

																		echo $arr_calciferol['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $calciferoldinner+=$arr_calciferol['dinner'][$i];

																	}

																	if($calciferoldinner!='0')

																	echo $calciferoldinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tocopherol['dinner'][$j] != '' )

																	{

																		echo $arr_tocopherol['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $tocopheroldinner+=$arr_tocopherol['dinner'][$i];

																	}

																	if($tocopheroldinner!='0')

																	echo $tocopheroldinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phylloquinone['dinner'][$j] != '' )

																	{

																		echo $arr_phylloquinone['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $phylloquinonedinner+=$arr_phylloquinone['dinner'][$i];

																	}

																	if($phylloquinonedinner!='0')

																	echo $phylloquinonedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_protein['dinner'][$j] != '' )

																	{

																		echo $arr_protein['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $proteindinner+=$arr_protein['dinner'][$i];

																	}

																	if($proteindinner!='0')

																	echo $proteindinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_alanine['dinner'][$j] != '' )

																	{

																		echo $arr_alanine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $alaninedinner+=$arr_alanine['dinner'][$i];

																	}

																	if($alaninedinner!='0')

																	echo $alaninedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_arginine['dinner'][$j] != '' )

																	{

																		echo $arr_arginine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $argininedinner+=$arr_arginine['dinner'][$i];

																	}

																	if($argininedinner!='0')

																	echo $argininedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_aspartic_acid['dinner'][$j] != '' )

																	{

																		echo $arr_aspartic_acid['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $aspartic_aciddinner+=$arr_aspartic_acid['dinner'][$i];

																	}

																	if($aspartic_aciddinner!='0')

																	echo $aspartic_aciddinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_cystine['dinner'][$j] != '' )

																	{

																		echo $arr_cystine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $cystinedinner+=$arr_cystine['dinner'][$i];

																	}

																	if($cystinedinner!='0')

																	echo $cystinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_giutamic_acid['dinner'][$j] != '' )

																	{

																		echo $arr_giutamic_acid['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $giutamic_aciddinner+=$arr_giutamic_acid['dinner'][$i];

																	}

																	if($giutamic_aciddinner!='0')

																	echo $giutamic_aciddinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_glycine['dinner'][$j] != '' )

																	{

																		echo $arr_glycine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $glycinedinner+=$arr_glycine['dinner'][$i];

																	}

																	if($glycinedinner!='0')

																	echo $glycinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_histidine['dinner'][$j] != '' )

																	{

																		echo $arr_histidine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $histidinedinner+=$arr_histidine['dinner'][$i];

																	}

																	if($histidinedinner!='0')

																	echo $histidinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_hydroxy_glutamic_acid['dinner'][$j] != '' )

																	{

																		echo $arr_hydroxy_glutamic_acid['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $glutamic_aciddinner+=$arr_hydroxy_glutamic_acid['dinner'][$i];

																	}

																	if($glutamic_aciddinner!='0')

																	echo $glutamic_aciddinner;



																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_hydroxy_proline['dinner'][$j] != '' )

																	{

																		echo $arr_hydroxy_proline['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $hydroxy_prolinedinner+=$arr_hydroxy_proline['dinner'][$i];

																	}

																	if($hydroxy_prolinedinner!='0')

																	echo $hydroxy_prolinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iodogorgoic_acid['dinner'][$j] != '' )

																	{

																		echo $arr_iodogorgoic_acid['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $iodogorgoic_aciddinner+=$arr_iodogorgoic_acid['dinner'][$i];

																	}

																	if($iodogorgoic_aciddinner!='0')

																	echo $iodogorgoic_aciddinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_isoleucine['dinner'][$j] != '' )

																	{

																		echo $arr_isoleucine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $isoleucinedinner+=$arr_isoleucine['dinner'][$i];

																	}

																	if($isoleucinedinner!='0')

																	echo $isoleucinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_leucine['dinner'][$j] != '' )

																	{

																		echo $arr_leucine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $leucinedinner+=$arr_leucine['dinner'][$i];

																	}

																	if($leucinedinner!='0')

																	echo $leucinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_lysine['dinner'][$j] != '' )

																	{

																		echo $arr_lysine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $lysinedinner+=$arr_lysine['dinner'][$i];

																	}

																	if($lysinedinner!='0')

																	echo $lysinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_methionine['dinner'][$j] != '' )

																	{

																		echo $arr_methionine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $methioninedinner+=$arr_methionine['dinner'][$i];

																	}

																	if($methioninedinner!='0')

																	echo $methioninedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr><tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_norleucine['dinner'][$j] != '' )

																	{

																		echo $arr_norleucine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $norleucinedinner+=$arr_norleucine['dinner'][$i];

																	}

																	if($norleucinedinner!='0')

																	echo $norleucinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phenylalanine['dinner'][$j] != '' )

																	{

																		echo $arr_phenylalanine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>



																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $phenylalaninedinner+=$arr_phenylalanine['dinner'][$i];

																	}

																	if($phenylalaninedinner!='0')

																	echo $phenylalaninedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_proline['dinner'][$j] != '' )

																	{

																		echo $arr_proline['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $prolinedinner+=$arr_proline['dinner'][$i];

																	}

																	if($prolinedinner!='0')

																	echo $prolinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_serine['dinner'][$j] != '' )

																	{

																		echo $arr_serine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $serinedinner+=$arr_serine['dinner'][$i];

																	}

																	if($serinedinner!='0')

																	echo $serinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_threonine['dinner'][$j] != '' )

																	{

																		echo $arr_threonine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $threoninedinner+=$arr_threonine['dinner'][$i];

																	}

																	if($threoninedinner!='0')

																	echo $threoninedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_thyroxine['dinner'][$j] != '' )

																	{

																		echo $arr_thyroxine['dinner'][$j];

																	}



																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $thyroxinedinner+=$arr_thyroxine['dinner'][$i];

																	}

																	if($thyroxinedinner!='0')

																	echo $thyroxinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tryptophane['dinner'][$j] != '' )

																	{

																		echo $arr_tryptophane['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $tryptophanedinner+=$arr_tryptophane['dinner'][$i];

																	}

																	if($tryptophanedinner!='0')

																	echo $tryptophanedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_tyrosine['dinner'][$j] != '' )

																	{

																		echo $arr_tyrosine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $tyrosinedinner+=$arr_tyrosine['dinner'][$i];

																	}

																	if($tyrosinedinner!='0')

																	echo $tyrosinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_valine['dinner'][$j] != '' )

																	{

																		echo $arr_valine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $valinedinner+=$arr_valine['dinner'][$i];

																	}

																	if($valinedinner!='0')

																	echo $valinedinner;

																	else

																	echo '&nbsp;';

																	?></td>



																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_total_minerals['dinner'][$j] != '' )

																	{

																		echo $arr_total_minerals['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $total_mineralsdinner+=$arr_total_minerals['dinner'][$i];

																	}

																	if($total_mineralsdinner!='0')

																	echo $total_mineralsdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_calcium['dinner'][$j] != '' )

																	{

																		echo $arr_calcium['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $calciumdinner+=$arr_calcium['dinner'][$i];

																	}

																	if($calciumdinner!='0')

																	echo $calciumdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iron['dinner'][$j] != '' )

																	{

																		echo $arr_iron['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $irondinner+=$arr_iron['dinner'][$i];

																	}

																	if($irondinner!='0')

																	echo $irondinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_potassium['dinner'][$j] != '' )

																	{

																		echo $arr_potassium['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $potassiumdinner+=$arr_potassium['dinner'][$i];

																	}

																	if($potassiumdinner!='0')

																	echo $potassiumdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sodium['dinner'][$j] != '' )

																	{

																		echo $arr_sodium['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $sodiumdinner+=$arr_sodium['dinner'][$i];

																	}

																	if($sodiumdinner!='0')

																	echo $sodiumdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_phosphorus['dinner'][$j] != '' )

																	{

																		echo $arr_phosphorus['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $phosphorusdinner+=$arr_phosphorus['dinner'][$i];

																	}

																	if($phosphorusdinner!='0')

																	echo $phosphorusdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_sulphur['dinner'][$j] != '' )

																	{

																		echo $arr_sulphur['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $sulphurdinner+=$arr_sulphur['dinner'][$i];

																	}

																	if($sulphurdinner!='0')

																	echo $sulphurdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_chlorine['dinner'][$j] != '' )

																	{

																		echo $arr_chlorine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $chlorinedinner+=$arr_chlorine['dinner'][$i];

																	}

																	if($chlorinedinner!='0')

																	echo $chlorinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>



																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_iodine['dinner'][$j] != '' )

																	{

																		echo $arr_iodine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $iodinedinner+=$arr_iodine['dinner'][$i];

																	}

																	if($iodinedinner!='0')

																	echo $iodinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_magnesium['dinner'][$j] != '' )

																	{

																		echo $arr_magnesium['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $magnesiumdinner+=$arr_magnesium['dinner'][$i];

																	}

																	if($magnesiumdinner!='0')

																	echo $magnesiumdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_zinc['dinner'][$j] != '' )

																	{

																		echo $arr_zinc['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $zincdinner+=$arr_zinc['dinner'][$i];

																	}

																	if($zincdinner!='0')

																	echo $zincdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_copper['dinner'][$j] != '' )

																	{

																		echo $arr_copper['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $copperdinner+=$arr_copper['dinner'][$i];

																	}

																	if($copperdinner!='0')

																	echo $copperdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr><tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_chromium['dinner'][$j] != '' )

																	{

																		echo $arr_chromium['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $chromiumdinner+=$arr_chromium['dinner'][$i];

																	}

																	if($chromiumdinner!='0')

																	echo $chromiumdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_manganese['dinner'][$j] != '' )

																	{

																		echo $arr_manganese['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $manganesedinner+=$arr_manganese['dinner'][$i];

																	}

																	if($manganesedinner!='0')

																	echo $manganesedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_selenium['dinner'][$j] != '' )

																	{

																		echo $arr_selenium['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $seleniumdinner+=$arr_selenium['dinner'][$i];

																	}

																	if($seleniumdinner!='0')

																	echo $seleniumdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_boron['dinner'][$j] != '' )

																	{

																		echo $arr_boron['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $borondinner+=$arr_boron['dinner'][$i];

																	}

																	if($borondinner!='0')

																	echo $borondinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_molybdenum['dinner'][$j] != '' )

																	{

																		echo $arr_molybdenum['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $molybdenumdinner+=$arr_molybdenum['dinner'][$i];

																	}

																	if($molybdenumdinner!='0')

																	echo $molybdenumdinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

																<tr>

																<?php

																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)

																{ ?>

																	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php

																	if($arr_caffeine['dinner'][$j] != '' )

																	{

																		echo $arr_caffeine['dinner'][$j];

																	}

																	else

																	{

																		echo '&nbsp;';

																			

																	}?></td>

																<?php

																} ?>

																	<td width="54" height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;

                                                                      <?php 

																	for($i=0;$i<count($arr_meal_time['dinner']);$i++)

																	{

																	  $caffeinedinner+=$arr_caffeine['dinner'][$i];

																	}

																	if($caffeinedinner!='0')

																	echo $caffeinedinner;

																	else

																	echo '&nbsp;';

																	?></td>

																</tr>

														  </table>

														</td>

													</tr>

												</table>

												<?php 

											}

											else

											{

											echo '<td>&nbsp;</td>';

																			

											}	?>	

													<?php

											}?>

												

							<?php	

							}

							elseif($report_type == 'Meal Chart') 

							{ ?>

                            <table width="1050" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">

								<tr>

									<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">SNo</td>

                                    <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date/Days</td>

                                    <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Breakfast</td>

                                    <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Brunch</td>

                                    <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Lunch</td>

                                    <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Snacks</td>

                                    <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Dinner</td>

                                </tr>

                                <?php

								for($i=0,$j=1;$i<count($arr_date);$i++,$j++)

								{ ?>

                                <tr>

									<td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $j;?></td>

                                    <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($arr_date[$i]));?><br />(<?php echo date("l",strtotime($arr_date[$i]));?>)</td>

                                    <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php if($arr_breakfast_time[$arr_date[$i]]==''){echo 'NA';}else {echo $arr_breakfast_time[$arr_date[$i]];}?></td>

                                    <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php if($arr_brunch_time[$arr_date[$i]]==''){echo 'NA';}else {echo $arr_brunch_time[$arr_date[$i]];}?></td>

                                    <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php if($arr_lunch_time[$arr_date[$i]]==''){echo 'NA';}else {echo $arr_lunch_time[$arr_date[$i]];}?></td>

                                    <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php if($arr_snacks_time[$arr_date[$i]]==''){echo 'NA';}else {echo $arr_snacks_time[$arr_date[$i]];}?></td>

                                    <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php if($arr_dinner_time[$arr_date[$i]]==''){echo 'NA';}else {echo $arr_dinner_time[$arr_date[$i]];}?></td>

                                </tr>

                                <?php

								} ?>

                            </table>        

                            <?php 

							} 

							elseif($report_type == 'Digital Personal Wellness Diary' || $report_type == 'Monthly Wellness Tracker Report')

							{ ?>

                             <table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td align="left" valign="top" class="Header_brown">

															<input type="checkbox" name="food_report" id="food_report" value="1" <?php if($food_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Food Report

														</td>	

														<td align="left" valign="top" class="Header_brown">

															<input type="checkbox" name="activity_report" id="activity_report" value="1" <?php if($activity_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Activity Report

														</td>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="wae_report" id="wae_report" value="1" <?php if($wae_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;My Work Place Report

														</td>

													</tr>

													<tr>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="gs_report" id="gs_report" value="1" <?php if($gs_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;General Stressors Report

														</td>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="sleep_report" id="sleep_report" value="1" <?php if($sleep_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Sleep Report

														</td>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="mc_report" id="mc_report" value="1" <?php if($mc_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;My Communication Report

														</td>

													</tr>

													<tr>

														<td align="left" valign="top" class="Header_brown">			

															<input type="checkbox" name="mr_report" id="mr_report" value="1" <?php if($mr_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;My Relations Report

														</td>

														<td align="left" valign="top" class="Header_brown">		

															<input type="checkbox" name="mle_report" id="mle_report" value="1" <?php if($mle_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Major Life Events Report

														</td>

														<td align="left" valign="top" class="Header_brown">		

															<input type="checkbox" name="adct_report" id="adct_report" value="1" <?php if($adct_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Addictions Report &nbsp;&nbsp;

														

														</td>

													</tr>

													<tr id="tr_err_date" style="display:<?php echo $tr_err_date;?>;" valign="top">

														<td align="left" colspan="3" class="err_msg" id="err_date" valign="top"><?php echo $err_date;?></td>

													</tr>

												</table>

                                                

                                                <?php

											if( ($food_return) && ($food_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Food</td>

												  </tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_food_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

													</tr>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>	

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >	

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>

														<td width="285" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Item</td>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Quantity</td>	

														<td width="65" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Desire</td>

                                                        <td width="270" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Item Remarks</td>	

													</tr>	

													<?php

													for($i=0;$i<count($v['meal_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['meal_time'][$i];?></td>

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

															<?php 

															if($v['meal_id'][$i] == '9999999999')

															{

																echo $v['meal_others'][$i];

															}

															else

															{

																echo $obj->getMealName($v['meal_id'][$i]);

															}

															?>

														</td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['meal_quantity'][$i].' ('.$v['meal_measure'][$i],' )';?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['meal_like'][$i];?><br /><?php echo $obj->getMealLikeIcon($v['meal_like'][$i]); ?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['meal_consultant_remark'][$i];?></td>	

													</tr>	

													<?php

													} ?>

												</table>		

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($activity_return)  && ($activity_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Activity</td>

												  </tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<?php

												foreach($arr_activity_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                    </tr>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >	

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>

														<td width="385" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Activity</td>	

														<td width="100" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Duration</td>	

                                                        <td width="85" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Proper guidance</td>	

                                                        <td width="200" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Precaution</td>

													</tr>	

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['today_wakeup_time'][0];?></td>

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">Wake Up </td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"></td>	

													</tr>	

													<?php

													for($i=0;$i<count($v['activity_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['activity_time'][$i];?></td>

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

															<?php 

															if($v['activity_id'][$i] == '9999999999')

															{

																echo $v['other_activity'][$i];

															}

															else

															{

																echo $obj->getDailyActivityName($v['activity_id'][$i]);

															}

															?>

														</td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['mins'][$i].' Mins';?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['proper_guidance'][$i];?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['precaution'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($wae_return) && ($wae_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Work & Environment</td>

												  </tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_wae_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>

                                                   </tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_wae_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getWAESituation($v['selected_wae_id'][$i]); ?></td>	

											       <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($gs_return) && ($gs_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;General Stressors</td>

												  </tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_gs_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>

                                                     </tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>	

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_gs_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getGSSituation($v['selected_gs_id'][$i]); ?></td>	

											       <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($sleep_return) && ($sleep_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sleep</td>

												  </tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_sleep_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>

                                                     </tr>

                                                     <tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Sleep Time</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $v['sleep_time'][0];?></td>	

													</tr>

                                                    <tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Wake Up Time</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $v['wakeup_time'][0];?></td>	

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_sleep_id']);$i++)

													{ 	?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getSleepSituation($v['selected_sleep_id'][$i]); ?></td>	 

                                                   <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($mc_return) && ($mc_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;My Communication</td>

												  </tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_mc_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_mc_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getMCSituation($v['selected_mc_id'][$i]); ?></td>	

											       <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($mr_return) && ($mr_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;My Relations</td>

												  </tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_mr_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>	

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_mr_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getMRSituation($v['selected_mr_id'][$i]); ?></td>	

											       <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($mle_return) && ($mle_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Major Life Events</td>

												  </tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_mle_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>	

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_mle_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getMLESituation($v['selected_mle_id'][$i]); ?></td>	

											       <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($adct_return) && ($adct_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Addictions</td>

												  </tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_adct_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_adct_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getADCTSituation($v['selected_adct_id'][$i]); ?></td>	

											       <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

                             

                            <?php

							}

							elseif($report_type == 'Datewise Emotions Report')

							{ ?>

                             <table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td align="left" valign="top" class="Header_brown">

															<input type="checkbox" name="wae_report" id="wae_report" value="1" <?php if($wae_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;My Work Place Report

														</td>	

														<td align="left" valign="top" class="Header_brown">

															<input type="checkbox" name="gs_report" id="gs_report" value="1" <?php if($gs_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;General Stressors Report

														</td>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="sleep_report" id="sleep_report" value="1" <?php if($sleep_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Sleep Report

														</td>

													</tr>

													<tr>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="mc_report" id="mc_report" value="1" <?php if($mc_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;My Communication Report

														</td>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="mr_report" id="mr_report" value="1" <?php if($mr_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;My Relations Report

														</td>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="mle_report" id="mle_report" value="1" <?php if($mle_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Major Life Events Report

														</td>

													</tr>

													<tr>

														<td align="left" valign="top" class="Header_brown">			

															<input type="checkbox" name="adct_report" id="adct_report" value="1" <?php if($adct_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Addictions Report &nbsp;&nbsp;

														</td>

														<td align="left" valign="top" class="Header_brown">		

															

														</td>

														<td align="left" valign="top" class="Header_brown">		

															

														

														</td>

													</tr>

													<tr id="tr_err_date" style="display:<?php echo $tr_err_date;?>;" valign="top">

														<td align="left" colspan="3" class="err_msg" id="err_date" valign="top"><?php echo $err_date;?></td>

													</tr>

												</table>

                                                

                                          								

											<?php

											if( ($wae_return) && ($wae_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Work & Environment</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_wae_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                   	</tr>

                                                </table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_wae_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getWAESituation($v['selected_wae_id'][$i]); ?></td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($gs_return) && ($gs_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;General Stressors</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_gs_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>	

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_gs_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getGSSituation($v['selected_gs_id'][$i]); ?></td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($sleep_return) && ($sleep_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sleep</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_sleep_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                   	</tr>

                                                    <tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Sleep Time</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $v['sleep_time'][0];?></td>	

													</tr>

                                                    <tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Wake Up Time</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $v['wakeup_time'][0];?></td>	

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>



												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_sleep_id']);$i++)

													{ 	?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getSleepSituation($v['selected_sleep_id'][$i]); ?></td>	 

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($mc_return) && ($mc_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;My Communication</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_mc_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_mc_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getMCSituation($v['selected_mc_id'][$i]); ?></td>	

														 <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($mr_return) && ($mr_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;My Relations</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_mr_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>	

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_mr_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getMRSituation($v['selected_mr_id'][$i]); ?></td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($mle_return) && ($mle_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Major Life Events</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_mle_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>	

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_mle_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getMLESituation($v['selected_mle_id'][$i]); ?></td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($adct_return) && ($adct_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Addictions</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_adct_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>

													</tr>	

													<?php

													for($i=0;$i<count($v['selected_adct_id']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getADCTSituation($v['selected_adct_id'][$i]); ?></td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

                             

									   <?php

                                        }

                                        elseif($report_type == 'Statementwise Emotions Report')

                                        { ?>

                             					<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td align="left" valign="top" class="Header_brown">

															<input type="checkbox" name="wae_report" id="wae_report" value="1" <?php if($wae_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;My Work Place Report

														</td>	

														<td align="left" valign="top" class="Header_brown">

															<input type="checkbox" name="gs_report" id="gs_report" value="1" <?php if($gs_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;General Stressors Report

														</td>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="sleep_report" id="sleep_report" value="1" <?php if($sleep_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Sleep Report

														</td>

													</tr>

													<tr>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="mc_report" id="mc_report" value="1" <?php if($mc_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;My Communication Report

														</td>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="mr_report" id="mr_report" value="1" <?php if($mr_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;My Relations Report

														</td>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="mle_report" id="mle_report" value="1" <?php if($mle_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Major Life Events Report

														</td>

													</tr>

													<tr>

														<td align="left" valign="top" class="Header_brown">			

															<input type="checkbox" name="adct_report" id="adct_report" value="1" <?php if($adct_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Addictions Report &nbsp;&nbsp;

														</td>

														<td align="left" valign="top" class="Header_brown">		

															

														</td>

														<td align="left" valign="top" class="Header_brown">		

															

														

														</td>

													</tr>

													<tr id="tr_err_date" style="display:<?php echo $tr_err_date;?>;" valign="top">

														<td align="left" colspan="3" class="err_msg" id="err_date" valign="top"><?php echo $err_date;?></td>

													</tr>

												</table>

                                                

                                          								

											<?php

											if( ($wae_return) && ($wae_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Work & Environment</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_wae_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getWAESituation($k); ?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

													</tr>	

													<?php

													for($i=0;$i<count($v['date']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')';?></td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($gs_return) && ($gs_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;General Stressors</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_gs_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getGSSituation($k); ?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>	

													</tr>	

													<?php

													for($i=0;$i<count($v['date']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')';?></td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($sleep_return) && ($sleep_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sleep</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_sleep_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getSleepSituation($k); ?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>



												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                        <td width="100" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Sleep Time</td>

                                                        <td width="100" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Wake-up Time</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

													</tr>	

													<?php

													for($i=0;$i<count($v['date']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')';?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $v['sleep_time'][$i];?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $v['wakeup_time'][$i];?></td>		

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($mc_return) && ($mc_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;My Communication</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_mc_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getMCSituation($k); ?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>

													</tr>	

													<?php

													for($i=0;$i<count($v['date']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')';?></td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($mr_return) && ($mr_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;My Relations</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_mr_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getMRSituation($k); ?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>	

													</tr>	

													<?php

													for($i=0;$i<count($v['date']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')';?></td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($mle_return) && ($mle_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Major Life Events</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_mle_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getMLESituation($k); ?></td>	

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>	

													</tr>	

													<?php

													for($i=0;$i<count($v['date']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')';?></td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

											

											<?php

											if( ($adct_return) && ($adct_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Addictions</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												foreach($arr_adct_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getADCTSituation($k); ?></td>	

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>

													</tr>	

													<?php

													for($i=0;$i<count($v['date']);$i++)

													{ ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($v['date'][$i])). '( '.date("l",strtotime($v['date'][$i])).')';?></td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['scale'][$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

													</tr>	

													<?php

													} ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

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

											} ?>

                             

									   <?php

                                        }

										elseif($report_type == 'Statementwise Emotions Pichart')

                                        { ?>

                             					<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td align="left" valign="top" class="Header_brown">

															<input type="checkbox" name="wae_report" id="wae_report" value="1" <?php if($wae_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;My Work Place Report

														</td>	

														<td align="left" valign="top" class="Header_brown">

															<input type="checkbox" name="gs_report" id="gs_report" value="1" <?php if($gs_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;General Stressors Report

														</td>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="sleep_report" id="sleep_report" value="1" <?php if($sleep_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Sleep Report

														</td>

													</tr>

													<tr>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="mc_report" id="mc_report" value="1" <?php if($mc_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;My Communication Report

														</td>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="mr_report" id="mr_report" value="1" <?php if($mr_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;My Relations Report

														</td>

														<td align="left" valign="top" class="Header_brown">	

															<input type="checkbox" name="mle_report" id="mle_report" value="1" <?php if($mle_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Major Life Events Report

														</td>

													</tr>

													<tr>

														<td align="left" valign="top" class="Header_brown">			

															<input type="checkbox" name="adct_report" id="adct_report" value="1" <?php if($adct_report == '1'){ ?> checked="checked" <?php } ?> />&nbsp;Addictions Report &nbsp;&nbsp;

														</td>

														<td align="left" valign="top" class="Header_brown">		

															

														</td>

														<td align="left" valign="top" class="Header_brown">		

															

														

														</td>

													</tr>

													<tr id="tr_err_date" style="display:<?php echo $tr_err_date;?>;" valign="top">

														<td align="left" colspan="3" class="err_msg" id="err_date" valign="top"><?php echo $err_date;?></td>

													</tr>

												</table>

                                                

                                          								

											<?php

											if( ($wae_return) && ($wae_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Work & Environment</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<?php

												$l=0;

												foreach($arr_wae_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getWAESituation($k); ?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff">

												<tr>

                                                <td>

													 <script  language="javascript">

													  $(document).ready(function(){

															plot5 = $.jqplot('wae<?php print $l; ?>', 

															[[

															<?php

															$temp=count($v['date'])-1;

															for($i=0;$i<count($v['date']);$i++)

															{

															?>

															[<?php echo $v['scale'][$i];?>,'<?php echo date("d M y",strtotime($v['date'][$i]));?>']											

															<?php 

															if($i<$temp)

															{

															?>

															 <?php  echo ','; ?>

															<?php

															}

													  		 }

															?>

															]], 

															{

																captureRightClick: true,

																seriesDefaults:{

																	renderer:$.jqplot.BarRenderer,

																	shadowAngle: 135,

																	rendererOptions: {

																		barDirection: 'horizontal',

																		highlightMouseDown: true   

																	},

																	pointLabels: {show: true, formatString: '%d'}

																},

																axes: {

																	yaxis: {

																		renderer: $.jqplot.CategoryAxisRenderer

																	},

																	xaxis: {

																		min:0,

																		max:10,

																		tickInterval:1

																	}

																}

															});

														});

													</script>

                                                  <?php

													$temp1=count($v['date']);

													if($temp1<2)

													   {

													    $temp1=$temp1*62;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*33;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*32;

													   }

													   else

													   {

													    $temp1=$temp1*28;

													   }  

													?>

													<div id="wae<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div>

														</td>

														</tr>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>		

												

												<?php

												$l++;

												}

												?>

													

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

											

											<?php

											if( ($gs_return) && ($gs_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;General Stressors</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<?php

												$l=0;

												foreach($arr_gs_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getGSSituation($k); ?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff">

												<tr><td>

														 <script  language="javascript">

													  $(document).ready(function(){

															plot5 = $.jqplot('gss<?php print $l; ?>', 

															[[

															<?php

															$temp=count($v['date'])-1;

															for($i=0;$i<count($v['date']);$i++)

															{

															?>

															[<?php echo $v['scale'][$i];?>,'<?php echo date("d M y",strtotime($v['date'][$i]));?>']											

															<?php 

															if($i<$temp)

															{

															?>

															 <?php  echo ','; ?>

															<?php

															}

													  		 }

															?>

															]], 

															{

																captureRightClick: true,

																seriesDefaults:{

																	renderer:$.jqplot.BarRenderer,

																	shadowAngle: 135,

																	rendererOptions: {

																		barDirection: 'horizontal',

																		highlightMouseDown: true   

																	},

																	pointLabels: {show: true, formatString: '%d'}

																},

																axes: {

																	yaxis: {

																		renderer: $.jqplot.CategoryAxisRenderer

																	},

																	xaxis: {

																		min:0,

																		max:10,

																		tickInterval:1

																	}

																}

															});

														});

													</script>

													<?php

													$temp1=count($v['date']);

													if($temp1<2)

													   {

													    $temp1=$temp1*62;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*33;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*32;

													   }

													   else

													   {

													    $temp1=$temp1*28;

													   }  

													?>

													<div id="gss<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div></td>

														</tr>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>		

												

												<?php

												$l++;

												}

												?>

													

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

											

											<?php

											if( ($sleep_return) && ($sleep_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sleep</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<?php

												$l=0;

												

												foreach($arr_sleep_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getSleepSituation($k); ?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>



												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >

													<tr><td>

                                                         <script  language="javascript">

													  $(document).ready(function(){

															plot5 = $.jqplot('sleep<?php print $l; ?>', 

															[[

															<?php

															$temp=count($v['date'])-1;

															for($i=0;$i<count($v['date']);$i++)

															{

															?>

															[<?php echo $v['scale'][$i];?>,'<?php echo date("d M y",strtotime($v['date'][$i]));?>']											

															<?php 

															if($i<$temp)

															{

															?>

															 <?php  echo ','; ?>

															<?php

															}

													  		 }

															?>

															]], 

															{

																captureRightClick: true,

																seriesDefaults:{

																	renderer:$.jqplot.BarRenderer,

																	shadowAngle: 135,

																	rendererOptions: {

																		barDirection: 'horizontal',

																		highlightMouseDown: true   

																	},

																	pointLabels: {show: true, formatString: '%d'}

																},

																axes: {

																	yaxis: {

																		renderer: $.jqplot.CategoryAxisRenderer

																	},

																	xaxis: {

																		min:0,

																		max:10,

																		tickInterval:1

																	}

																}

															});

														});

													</script>

													<?php

													$temp1=count($v['date']);

													if($temp1<2)

													   {

													    $temp1=$temp1*62;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*33;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*32;

													   }

													   else

													   {

													    $temp1=$temp1*28;

													   }  

													?>

													<div id="sleep<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div></td>

													</tr>

												</table>		

												

												<?php

												$l++;

												}

												?>

													

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

											

											<?php

											if( ($mc_return) && ($mc_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;My Communication</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<?php

												$l=0;

												foreach($arr_mc_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getMCSituation($k); ?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >

													<tr>

														<td>

                                                          <script  language="javascript">

													  $(document).ready(function(){

															plot5 = $.jqplot('mc<?php print $l; ?>', 

															[[

															<?php

															$temp=count($v['date'])-1;

															for($i=0;$i<count($v['date']);$i++)

															{

															?>

															[<?php echo $v['scale'][$i];?>,'<?php echo date("d M y",strtotime($v['date'][$i]));?>']											

															<?php 

															if($i<$temp)

															{

															?>

															 <?php  echo ','; ?>

															<?php

															}

													  		 }

															?>

															]], 

															{

																captureRightClick: true,

																seriesDefaults:{

																	renderer:$.jqplot.BarRenderer,

																	shadowAngle: 135,

																	rendererOptions: {

																		barDirection: 'horizontal',

																		highlightMouseDown: true   

																	},

																	pointLabels: {show: true, formatString: '%d'}

																},

																axes: {

																	yaxis: {

																		renderer: $.jqplot.CategoryAxisRenderer

																	},

																	xaxis: {

																		min:0,

																		max:10,

																		tickInterval:1

																	}

																}

															});

														});

													</script>

													<?php

													$temp1=count($v['date']);

													if($temp1<2)

													   {

													    $temp1=$temp1*62;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*33;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*32;

													   }

													   else

													   {

													    $temp1=$temp1*28;

													   }  

													?>

													<div id="mc<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div></td></tr>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>		

												

												<?php

												$l++;

												}?>

													

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

											

											<?php

											if( ($mr_return) && ($mr_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;My Relations</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<?php

												$l=0;

												foreach($arr_mr_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getMRSituation($k); ?></td>	</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >

													<tr><td>

                                                          <script  language="javascript">

													  $(document).ready(function(){

															plot5 = $.jqplot('mr<?php print $l; ?>', 

															[[

															<?php

															$temp=count($v['date'])-1;

															for($i=0;$i<count($v['date']);$i++)

															{

															?>

															[<?php echo $v['scale'][$i];?>,'<?php echo date("d M y",strtotime($v['date'][$i]));?>']											

															<?php 

															if($i<$temp)

															{

															?>

															 <?php  echo ','; ?>

															<?php

															}

													  		 }

															?>

															]], 

															{

																captureRightClick: true,

																seriesDefaults:{

																	renderer:$.jqplot.BarRenderer,

																	shadowAngle: 135,

																	rendererOptions: {

																		barDirection: 'horizontal',

																		highlightMouseDown: true   

																	},

																	pointLabels: {show: true, formatString: '%d'}

																},

																axes: {

																	yaxis: {

																		renderer: $.jqplot.CategoryAxisRenderer

																	},

																	xaxis: {

																		min:0,

																		max:10,

																		tickInterval:1

																	}

																}

															});

														});

													</script>

													<?php

													$temp1=count($v['date']);

													if($temp1<2)

													   {

													    $temp1=$temp1*62;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*33;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*32;

													   }

													   else

													   {

													    $temp1=$temp1*28;

													   }  

													?>

													<div id="mr<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div></td></tr>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>		

												<?php

												$l++;

												}?>

													

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

											

											<?php

											if( ($mle_return) && ($mle_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Major Life Events</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												$l=0;

												foreach($arr_mle_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $obj->getMLESituation($k); ?></td>	

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >

													<tr>

														<td>

                                                          <script  language="javascript">

													  $(document).ready(function(){

															plot5 = $.jqplot('mle<?php print $l; ?>', 

															[[

															<?php

															$temp=count($v['date'])-1;

															for($i=0;$i<count($v['date']);$i++)

															{

															?>

															[<?php echo $v['scale'][$i];?>,'<?php echo date("d M y",strtotime($v['date'][$i]));?>']											

															<?php 

															if($i<$temp)

															{

															?>

															 <?php  echo ','; ?>

															<?php

															}

													  		 }

															?>

															]], 

															{

																captureRightClick: true,

																seriesDefaults:{

																	renderer:$.jqplot.BarRenderer,

																	shadowAngle: 135,

																	rendererOptions: {

																		barDirection: 'horizontal',

																		highlightMouseDown: true   

																	},

																	pointLabels: {show: true, formatString: '%d'}

																},

																axes: {

																	yaxis: {

																		renderer: $.jqplot.CategoryAxisRenderer

																	},

																	xaxis: {

																		min:0,

																		max:10,

																		tickInterval:1

																	}

																}

															});

														});

													</script>

													<?php

													$temp1=count($v['date']);

													if($temp1<2)

													   {

													    $temp1=$temp1*62;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*33;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*32;

													   }

													   else

													   {

													    $temp1=$temp1*28;

													   }  

													?>

													<div id="mle<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div></td></tr>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>		

												

												<?php

												$l++;

												}?>

													

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

											

											<?php

											if( ($adct_return) && ($adct_report == '1') )

											{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Addictions</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												$l=0;

												foreach($arr_adct_records as $k => $v)

												{ ?>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >

													<tr>

														<td>

                                                          <script  language="javascript">

													  $(document).ready(function(){

															plot5 = $.jqplot('add<?php print $l; ?>', 

															[[

															<?php

															$temp=count($v['date'])-1;

															for($i=0;$i<count($v['date']);$i++)

															{

															?>

															[<?php echo $v['scale'][$i];?>,'<?php echo date("d M y",strtotime($v['date'][$i]));?>']											

															<?php 

															if($i<$temp)

															{

															?>

															 <?php  echo ','; ?>

															<?php

															}

													  		 }

															?>

															]], 

															{

																captureRightClick: true,

																seriesDefaults:{

																	renderer:$.jqplot.BarRenderer,

																	shadowAngle: 135,

																	rendererOptions: {

																		barDirection: 'horizontal',

																		highlightMouseDown: true   

																	},

																	pointLabels: {show: true, formatString: '%d'}

																},

																axes: {

																	yaxis: {

																		renderer: $.jqplot.CategoryAxisRenderer

																	},

																	xaxis: {

																		min:0,

																		max:10,

																		tickInterval:1

																	}

																}

															});

														});

													</script>

													<?php

													$temp1=count($v['date']);

													if($temp1<2)

													   {

													    $temp1=$temp1*62;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*33;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*32;

													   }

													   else

													   {

													    $temp1=$temp1*28;

													   }  

													?>

													<div id="add<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div></td></tr>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>		

												

												<?php

												$l++;

												}?>

													

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

                             

									   <?php

                                        }

										elseif($report_type == 'Angervent Intensity Report')

                                        { ?>

                                        		<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;&nbsp;Angervent Intensity Report</td>

													</tr>

												</table>

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="120" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Entry Level - Anger Intensity Scale</td>

                                                        <td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Exit Level - Anger Intensity Scale</td>

                                                        <td width="100" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Comment</td>		

													</tr>	

													<?php

													for($i=0;$i<count($arr_uavb_date);$i++)

													{ ?>

													<tr>													

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y h:i:s",strtotime($arr_uavb_date[$i])). '<br/>( '.date("l",strtotime($arr_uavb_date[$i])).')';?></td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $arr_intensity_scale_1[$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$arr_intensity_scale_1_image[$i]; ?>" width="320" height="30" border="0" /> </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $arr_intensity_scale_2[$i];?><br/>

                                                         <img src="<?php echo SITE_URL."/images/".$arr_intensity_scale_2_image[$i]; ?>" width="320" height="30" border="0" /> </td>  

														<td height="30" align="center" valign="left" class="report_value" bgcolor="#FFFFFF"><?php echo  $arr_angervent_comment_box[$i]; ?></td>

                                                        </tr>	

													<?php

                                                    } ?>

												</table>	

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>	

                                        <?php
										}
										elseif($report_type == 'Stressbuster Intensity Report')
                                        { ?>
                                        		<table width="920" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td>&nbsp;</td>
														<td>&nbsp;</td>
													</tr>
												</table>
												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
													<tr>
														<td width="920" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;&nbsp;Stressbuster Intensity Report</td>
													</tr>
												</table>
												<table width="920" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
													</tr>
												</table>
												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >
													<tr>
														<td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>
														<td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Entry Level - Stress Buster Intensity Scale</td>
                                                        <td width="350" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Exit Level - Stress Buster Intensity Scale</td>
                                                         <td width="100" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Comment</td>				
													</tr>	
													<?php
													for($i=0;$i<count($arr_usbb_date);$i++)
													{ ?>
													<tr>													
														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y h:i:s",strtotime($arr_usbb_date[$i])). '( '.date("l",strtotime($arr_usbb_date[$i])).')';?></td>	
														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $arr_intensity_scale_1[$i];?><br/>
                                                         <img src="<?php echo SITE_URL."/images/".$arr_intensity_scale_1_image[$i]; ?>" width="320" height="30" border="0" /> </td>  
                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $arr_intensity_scale_2[$i];?><br/>
                                                         <img src="<?php echo SITE_URL."/images/".$arr_intensity_scale_2_image[$i]; ?>" width="320" height="30" border="0" /> </td>  
														<td height="30" align="center" valign="left" class="report_value" bgcolor="#FFFFFF"><?php echo  $arr_stress_comment_box[$i]; ?></td>
                                                    </tr>	
													<?php
                                                    } ?>
												</table>	
												<table width="920" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>
													</tr>
												</table>	
                                        <?php
										}
										elseif($report_type == 'Rewards Chart')
                                        { ?>

                                        		<table width="920" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                                <tbody>	
                                                    <tr>	
                                                        <td colspan="2" align="left" height="30">&nbsp;</td>
                                                    </tr>
                                                    <tr>	
                                                        <td align="left"><span style="font-size:18px;"><strong>Summary Reward Chart</strong></span></td>
                                                        <td align="right"><input type="button" name="btnShowMonthWiseChart" id="btnShowMonthWiseChart" value="Show Monthwise Chart" onclick="showMonthWiseRewardChart('idmonthwisechart')"  /></td>
                                                    </tr>
                                                   
                                                </tbody>
                                                </table>
												<table width="920" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
                                                <tbody>
                                                    <tr>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>SNo</strong></td>
                                                        <td width="20%" height="30" align="center" valign="middle"><strong>Particulars</strong></td>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Total Entries</strong></td>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Gained</strong></td>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Number of days Posted</strong></td>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Bonus Points Gained</strong></td>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise TOTAL</strong></td>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Encashed</strong></td>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Balance Points</strong></td>
                                                    </tr>
                                                    <?php
													//for($i=0,$j=1;$i<count($arr_reward_summary['records']);$i++,$j++)
													$j = 1;
													$summary_total_entries = 0;
													$total_summary_points_from_entry = 0;
													$total_summary_no_of_days_posted = 0;
													$total_summary_bonus_points = 0;
													$total_summary_total_points = 0;
													$total_summary_encashed_points = 0;
													$total_summary_balance_points = 0;
													
													foreach($arr_reward_summary as $key => $val)
													{ 
														$total_summary_total_entries += $val['summary_total_entries'];
														$total_summary_points_from_entry += $val['summary_points_from_entry'];
														$total_summary_no_of_days_posted += $val['summary_no_of_days_posted'];
														$total_summary_bonus_points += $val['summary_bonus_points'];
														$total_summary_total_points += $val['summary_total_points'];
														$total_summary_encashed_points += $val['summary_total_encashed_points'];
														$total_summary_balance_points += $val['summary_total_balance_points'];
													
													?>
                                                    <tr>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $j;?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_reward_module_title'];?></strong></td>
                                                        <td height="30" align="right" valign="middle" style="padding-right:2px;">
                                                            <strong><?php echo $val['summary_total_entries'];?></strong>
                                                        <?php 
                                                        if($val['summary_total_entries'] > 0)
                                                        { ?>
                                                            &nbsp;<input type="button" name="btnViewEntriesDetailsList" id="btnViewEntriesDetailsList" value="View" onclick="viewEntriesDetailsList('<?php echo date('Y-m-01',strtotime($start_date));?>','<?php echo date('Y-m-t',strtotime($end_date));?>','<?php echo $key;?>','<?php echo $val['summary_reward_module_title'];?>','<?php echo $user_id;?>');"  />
														<?php
														}
														else
														{ ?>
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<?php
														} ?>     
														</td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_points_from_entry'];?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_no_of_days_posted'];?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_bonus_points'];?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_total_points'];?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_total_encashed_points'];?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_total_balance_points'];?></strong></td>
                                                    </tr>
                                                 	<?php
														$j++;
													} ?>  
                                                    <tr>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong>Base Total</strong></td>
                                                        <td height="30" align="right" valign="middle" style="padding-right:2px;"><strong><?php echo $total_summary_total_entries;?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_points_from_entry;?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_no_of_days_posted;?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_bonus_points;?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_total_points;?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        
                                                    </tr> 
                                                    <tr>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong>Total Bonus Points</strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_bonus_points;?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong>Grand Total Points</strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_total_points;?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        
                                                    </tr> 
                                                    <tr>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong>Total Point Encashed</strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_encashed_points;?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong>Total Balance Points</strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_balance_points;?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        
                                                    </tr>
                                                  </tbody>
                                                  </table>
                                                  <?php $idmonthwisechart = 'none';?>
                                                <div id="idmonthwisechart" style="display:<?php echo $idmonthwisechart;?>"> 
                                                	<table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                                <tbody>	
                                                    <tr>	
                                                        <td align="left" height="30">&nbsp;</td>
                                                    </tr>
                                                    <tr>	
                                                        <td align="left"><span style="font-size:18px;"><strong>Monthwise Reward Chart</strong></span></td>
                                                        
                                                    </tr>
                                                   
                                                </tbody>
                                                </table> 
                                                <?php
												//echo '<br><pre>';
												//print_r($arr_reward_modules);
												//echo '<br></pre>';
                                                foreach($arr_reward_modules as $key => $value)
                                                { ?>
                                                <table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr align="center">
														<td height="30" class="Header_brown">&nbsp;</td>
													</tr>
												</table>
                                                <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                                <tbody>
                                                    <tr>
                                                        <td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
                                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
                                                        <td width="20%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($key));?></td>
                                                        <td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
                                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
                                                        <td width="19%" height="30" align="left" valign="middle"><?php echo date("t M Y",strtotime($key));?></td>
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
                                                </tbody>
                                                </table>
												<table width="920" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
                                                <tbody>
                                                    <tr>
                                                        <td width="5%" height="30" align="center" valign="middle"><strong>SNo</strong></td>
                                                        <td width="30%" height="30" align="center" valign="middle"><strong>Particulars</strong></td>
                                                        <td width="15%" height="30" align="center" valign="middle"><strong>Conversion value for points<br />(Entries/Module)</strong></td>
                                                        <td width="15%" height="30" align="center" valign="middle"><strong>Total Entries</strong></td>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Gained</strong></td>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Number of days Posted</strong></td>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Bonus Points Gained</strong></td>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise TOTAL Points</strong></td>
                                                        <?php /*?><td width="7%" height="30" align="center" valign="middle"><strong>Points Encashed</strong></td>
                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Rewards got from Points Enc</strong></td>
                                                        <td width="8%" height="30" align="center" valign="middle"><strong>Balance Points</strong></td><?php */?>
                                                    </tr>
                                                    <?php
													for($i=0,$j=1;$i<count($value['records']);$i++,$j++)
													{ ?>
                                                    <tr>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $j;?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['reward_module_title'];?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo ($value['records'][$i]['reward_conversion_value'] == '0' ? 'NA' : $value['records'][$i]['reward_conversion_value']);?></strong></td>
                                                        <td height="30" align="right" valign="middle" style="padding-right:2px;">
                                                            <strong><?php echo $value['records'][$i]['total_entries'];?></strong>
														<?php 
                                                        if($value['records'][$i]['total_entries'] > 0)
                                                        { ?>
                                                            &nbsp;<input type="button" name="btnViewEntriesDetailsList" id="btnViewEntriesDetailsList" value="View" onclick="viewEntriesDetailsList('<?php echo $key;?>','<?php echo date('Y-m-t',strtotime($key));?>','<?php echo $value['records'][$i]['reward_module_id'];?>','<?php echo $value['records'][$i]['reward_module_title'];?>','<?php echo $user_id;?>');"  />
														<?php
														}
														else
														{ ?>
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<?php
														} ?>   
                                                       	</td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['points_from_entry'];?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['no_of_days_posted'];?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['bonus_points'];?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['total_points'];?></strong></td>
                                                        <?php /*?><td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                                    </tr>
                                                 	<?php
													} ?>  
                                                    <tr>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong>Base Total</strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_reward_conversion_value'];?></strong></td>
                                                        <td height="30" align="right" valign="middle" style="padding-right:2px;"><strong><?php echo $value['total_total_entries'];?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_points_from_entry'];?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_no_of_days_posted'];?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_bonus_points'];?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_total_points'];?></strong></td>
                                                        <?php /*?><td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                                    </tr>
                                                    <tr>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong>Total Bonus Points</strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_bonus_points'];?></strong></td>
                                                       <?php /*?> <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong>Grand Total Points</strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_total_points'];?></strong></td>
                                                        <?php /*?><td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                                        
                                                    </tr> 
                                                     <?php /*?>
                                                    <tr>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong>Total Point Encashed</strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_encashed_points;?></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong>Total Balance Points</strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_balance_points;?></strong></td>
                                                       <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                        
                                                    </tr>  <?php */?>
                                                  </tbody>
                                                  </table>
                                                <?php
												} ?>  
                                                </div> 
                                        <?php
										
										} ?>
                         		</form>	
                             <?php
							 if($show_pdf_button)
							 { ?>   
							<table width="920" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td align="left">
										<form action="#" method="post" name="frmpdfreports" id="frmpdfreports">
											<input type="hidden" name="hdnuser_id" id="hdnhdnuser_id" value="<?php echo $user_id;?>" />
											<input type="hidden" name="hdndate" id="hdndate" value="<?php echo $date;?>" />
                                            <input type="hidden" name="hdnstart_date" id="hdnstart_date" value="<?php echo $start_date;?>" />
											<input type="hidden" name="hdnend_date" id="hdnend_date" value="<?php echo $end_date;?>" />
											<input type="hidden" name="hdnreport_type" id="hdnreport_type" value="<?php echo $report_type;?>" />
                                            <input type="hidden" name="hdnfood_report" id="hdnfood_report" value="<?php echo $food_report;?>" />
                                            <input type="hidden" name="hdnactivity_report" id="hdnactivity_report" value="<?php echo $activity_report;?>" />
                                            <input type="hidden" name="hdnwae_report" id="hdnwae_report" value="<?php echo $wae_report;?>" />
                                            <input type="hidden" name="hdngs_report" id="hdngs_report" value="<?php echo $gs_report;?>" />
                                           <input type="hidden" name="hdnsleep_report" id="hdnsleep_report" value="<?php echo $sleep_report;?>" />
                                            <input type="hidden" name="hdnmc_report" id="hdnmc_report" value="<?php echo $mc_report;?>" />
                                            <input type="hidden" name="hdnmr_report" id="hdnmr_report" value="<?php echo $mr_report;?>" />
                                            <input type="hidden" name="hdnmle_report" id="hdnmle_report" value="<?php echo $mle_report;?>" />
                                            <input type="hidden" name="hdnadct_report" id="hdnadct_report" value="<?php echo $adct_report;?>" />
											<?php
											if( ($report_type == 'Digital Personal Wellness Diary') || ($report_type == 'Monthly Wellness Tracker Report') || ($report_type == 'Each Meal Per Day Chart' ||($report_type == 'Angervent Intensity Report')||($report_type == 'Stressbuster Intensity Report')) )
											{ ?>
	                                           <input type="submit" name="btnPdfReport" id="btnPdfReport" value="Save to Excel"  />
                                            <?php
											}
											else
											{ ?>
                                            <input type="submit" name="btnPdfReport" id="btnPdfReport" value="Save to Pdf"  />
                                            <?php
											} ?>
										</form>
									</td>
								</tr>
							</table>
                            <?php
							} ?>
						<?php
						}
						else
						{ ?>
							<table width="920" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td height="30" align="center" class="err_msg"><?php echo $msg;?></td>
								</tr>
							</table>
						<?php
						} ?>
						</td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
	</tbody>
	</table>
	<br>
</div>