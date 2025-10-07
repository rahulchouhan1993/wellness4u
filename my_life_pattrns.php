<?php

ini_set("memory_limit", "200M");

if (ini_get("pcre.backtrack_limit") < 1000000)
{
    ini_set("pcre.backtrack_limit", 1000000);
};

@set_time_limit(1000000);

include ('classes/config.php');

$page_id = '38';

$obj = new frontclass();

$obj2 = new commonFrontclass();

$page_data = $obj->getPageDetails($page_id);

//list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);


//update by ample 24-03-20
$ref = base64_encode('my_life_pattrns.php');
//$ref = base64_encode('digital_personal_wellness_diary.php');


if (isset($_SESSION['adm_vendor_id']) && !empty($_SESSION['adm_vendor_id']))
{
    $vendor_id = $_SESSION['adm_vendor_id'];

    $_SESSION["adm_user_id"] = $_GET['user_id'];

    $user_id = $_SESSION['adm_user_id'];

}
else
{
    if (!$obj->isLoggedIn())

    {

        //    header("Location: login.php?ref=".$ref);
        echo "<script>window.location.href='login.php?ref=$ref'</script>";

        exit(0);

    }

    else

    {

        $user_id = $_SESSION['user_id'];

        $obj->doUpdateOnline($_SESSION['user_id']);

    }

}

list($food_chart, $each_meal_per_day_chart, $my_activity_calories_chart, $my_activity_calories_pi_chart, $activity_analysis_chart, $meal_chart, $dpwd_chart, $mwt_report, $datewise_emotions_report, $statementwise_emotions_report, $statementwise_emotions_pi_report, $angervent_intensity_report, $stressbuster_intensity_report) = $obj->get_user_reports_permissions($user_id);

// if ($obj->chkUserPlanFeaturePermission($user_id, '6'))

// {

//     $dpwd_chart = 1;

// }

// else

// {

//     $dpwd_chart = 0;

// }

$dpwd_chart = 0;

$return = false;

$error = false;

$tr_err_date = 'none';

$err_date = '';

$tbldaterange = '';

$tblsingledate = 'none';

$tblmonthdate = 'none';

$div_start_scale_value = 'none';

$div_end_scale_value = 'none';

$div_start_criteria_scale_value = 'none';

$div_end_criteria_scale_value = 'none';

$div_module_key = 'none';

$idscaleshow = 'none';

$idcriteriascaleshow = 'none';

$spntriggercriteria = 'none';

$show_pdf_button = false;

if (isset($_POST['btnSubmit']))

{

    $date_type = strip_tags(trim($_POST['date_type']));

    $start_date = strip_tags(trim($_POST['start_date']));

    $end_date = strip_tags(trim($_POST['end_date']));

    $single_date = strip_tags(trim($_POST['single_date']));

    $start_month = strip_tags(trim($_POST['start_month']));

    $start_year = strip_tags(trim($_POST['start_year']));

    $report_module = trim($_POST['report_module']);

    $pro_user_id = trim($_POST['pro_user_id']);

    $module_keyword = trim($_POST['module_keyword']);

    $module_criteria = trim($_POST['module_criteria']);

    $scale_range = trim($_POST['scale_range']);

    $start_scale_value = trim($_POST['start_scale_value']);

    $end_scale_value = trim($_POST['end_scale_value']);

    $criteria_scale_range = trim($_POST['criteria_scale_range']);

    $start_criteria_scale_value = trim($_POST['start_criteria_scale_value']);

    $end_criteria_scale_value = trim($_POST['end_criteria_scale_value']);

    if ($module_criteria == '9')

    {

        $trigger_criteria = trim($_POST['trigger_criteria']);

    }

    else

    {

        $trigger_criteria = '';

    }

    if ($date_type == 'date_range')

    {

        $tbldaterange = '';

        $tblsingledate = 'none';

        $tblmonthdate = 'none';

        if ($start_date == '')

        {

            $error = true;

            $tr_err_date = '';

            $err_date = 'Please select start date';

        }

        if ($end_date == '')

        {

            $error = true;

            if ($tr_err_date == 'none')

            {

                $tr_err_date = '';

                $err_date = 'Please select end date';

            }

            else

            {

                $err_date .= '<br>Please select end date';

            }

        }

    }

    elseif ($date_type == 'single_date')

    {

        $tbldaterange = 'none';

        $tblsingledate = '';

        $tblmonthdate = 'none';

        $start_date = $single_date;

        $end_date = $single_date;

        if ($single_date == '')

        {

            $error = true;

            $tr_err_date = '';

            $err_date = 'Please select date';

        }

    }

    elseif ($date_type == 'month_wise')

    {

        $tbldaterange = 'none';

        $tblsingledate = 'none';

        $tblmonthdate = '';

        $start_date = $start_year . '-' . $start_month . '-01';

        $end_month = $start_month;

        $end_year = $start_year;

        $end_day = date('t', strtotime($start_date));

        $end_date = $end_year . '-' . $end_month . '-' . $end_day;

    }

    if ($scale_range == '')

    {

        $div_start_scale_value = 'none';

        $div_end_scale_value = 'none';

        $start_scale_value = '';

        $end_scale_value = '';

    }

    elseif ($scale_range == '6')

    {

        $div_start_scale_value = '';

        $div_end_scale_value = '';

    }

    else

    {

        $div_start_scale_value = '';

        $div_end_scale_value = 'none';

        $end_scale_value = '';

    }

    if ($criteria_scale_range == '')

    {

        $div_start_criteria_scale_value = 'none';

        $div_end_criteria_scale_value = 'none';

        $start_criteria_scale_value = '';

        $end_criteria_scale_value = '';

    }

    elseif ($criteria_scale_range == '6')

    {

        $div_start_criteria_scale_value = '';

        $div_end_criteria_scale_value = '';

    }

    else

    {

        $div_start_criteria_scale_value = '';

        $div_end_criteria_scale_value = 'none';

        $end_criteria_scale_value = '';

    }

    if ($report_module == '' || $report_module == 'food_report' || $report_module == 'activity_report' || $report_module == 'bps_report' || $report_module == 'activity_analysis_report' || $report_module == 'meal_time_report')

    {

        $idscaleshow = 'none';

    }

    else

    {

        $idscaleshow = '';

    }

    if ($module_criteria == '')

    {

        $idcriteriascaleshow = 'none';

    }

    else

    {

        $idcriteriascaleshow = '';

        if ($module_criteria == '9')

        {

            $spntriggercriteria = '';

        }

    }

    if (!$error)

    {

        if ($pro_user_id == '')

        {

            $temp_permission_type = '';

            $temp_pro_user_id = '';

        }

        elseif ($pro_user_id == '0')

        {

            $temp_permission_type = '0';

            $temp_pro_user_id = '0';

        }

        else

        {

            $temp_permission_type = '1';

            $temp_pro_user_id = $pro_user_id;

        }

        $start_date = date('Y-m-d', strtotime($start_date));

        $end_date = date('Y-m-d', strtotime($end_date));

        // echo $obj->getDigitalPersonalWellnessDiary($user_id,$start_date,$end_date,$temp_permission_type,$temp_pro_user_id,$scale_range,$start_scale_value,$end_scale_value,$report_module,$module_keyword,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value,$trigger_criteria);
        // exit;
        

        // echo "<pre>";print_r('hi');echo "</pre>";
        // exit;
        list($food_return, $arr_meal_date, $arr_food_records, $activity_return, $arr_activity_date, $arr_activity_records, $wae_return, $arr_wae_date, $arr_wae_records, $gs_return, $arr_gs_date, $arr_gs_records, $sleep_return, $arr_sleep_date, $arr_sleep_records, $mc_return, $arr_mc_date, $arr_mc_records, $mr_return, $arr_mr_date, $arr_mr_records, $mle_return, $arr_mle_date, $arr_mle_records, $adct_return, $arr_adct_date, $arr_adct_records, $bps_return, $arr_bps_date, $arr_bps_records, $bes_return, $arr_bes_date, $arr_bes_records, $aa_return, $arr_aa_records, $mt_return, $arr_mt_records, $mdt_return, $arr_mdt_date, $arr_mdt_records) = $obj->getDigitalPersonalWellnessDiary($user_id, $start_date, $end_date, $temp_permission_type, $temp_pro_user_id, $scale_range, $start_scale_value, $end_scale_value, $report_module, $module_keyword, $module_criteria, $criteria_scale_range, $start_criteria_scale_value, $end_criteria_scale_value, $trigger_criteria);

        //echo'<br><pre>';
        

        //print_r($arr_mdt_records);
        

        //echo'<br></pre>';
        

        if ($food_return || $activity_return || $wae_return || $gs_return || $sleep_return || $mc_return || $mr_return || $mle_return || $adct_return || $bps_return || $bes_return || $aa_return || $mt_return || $mdt_return)

        {

            $show_pdf_button = true;

        }

        if ((!$food_return) && (!$activity_return) && (!$wae_return) && (!$gs_return) && (!$sleep_return) && (!$mc_return) && (!$mr_return) && (!$mle_return) && (!$adct_return) && (!$bps_return) && (!$bes_return) && (!$aa_return) && (!$mt_return) && (!$mdt_return))

        {

            $error = true;

            $tr_err_date = '';

            $err_date = 'NO Data Posted by you for your above selected Query';

        }

        $start_date = date('d-m-Y', strtotime($start_date));

        $end_date = date('d-m-Y', strtotime($end_date));

    }

    if ($err_date != '')

    {

        $err_date = '<div class="err_msg_box"><span class="blink_me">' . $err_date . '</span></div>';

    }

}

elseif (isset($_POST['btnPdfReport']))

{

    $date_type = strip_tags(trim($_POST['hdndate_type']));

    $start_date = strip_tags(trim($_POST['hdnstart_date']));

    $end_date = strip_tags(trim($_POST['hdnend_date']));

    $single_date = strip_tags(trim($_POST['hdnsingle_date']));

    $start_month = strip_tags(trim($_POST['hdnstart_month']));

    $start_year = strip_tags(trim($_POST['hdnstart_year']));

    $report_module = trim($_POST['hdnreport_module']);

    $pro_user_id = trim($_POST['hdnpro_user_id']);

    $scale_range = trim($_POST['hdnscale_range']);

    $start_scale_value = trim($_POST['hdnstart_scale_value']);

    $end_scale_value = trim($_POST['hdnend_scale_value']);

    $module_keyword = trim($_POST['hdnmodule_keyword']);

    $module_criteria = trim($_POST['hdnmodule_criteria']);

    $criteria_scale_range = trim($_POST['hdncriteria_scale_range']);

    $start_criteria_scale_value = trim($_POST['hdnstart_criteria_scale_value']);

    $end_criteria_scale_value = trim($_POST['hdnend_criteria_scale_value']);

    if ($module_criteria == '9')

    {

        $trigger_criteria = trim($_POST['hdntrigger_criteria']);

    }

    else

    {

        $trigger_criteria = '';

    }

    if ($date_type == 'date_range')

    {

        $tbldaterange = '';

        $tblsingledate = 'none';

        $tblmonthdate = 'none';

        if ($start_date == '')

        {

            $error = true;

            $tr_err_date = '';

            $err_date = 'Please select start date';

        }

        if ($end_date == '')

        {

            $error = true;

            if ($tr_err_date == 'none')

            {

                $tr_err_date = '';

                $err_date = 'Please select end date';

            }

            else

            {

                $err_date .= '<br>Please select end date';

            }

        }

    }

    elseif ($date_type == 'single_date')

    {

        $tbldaterange = 'none';

        $tblsingledate = '';

        $tblmonthdate = 'none';

        $start_date = $single_date;

        $end_date = $single_date;

        if ($single_date == '')

        {

            $error = true;

            $tr_err_date = '';

            $err_date = 'Please select date';

        }

    }

    elseif ($date_type == 'month_wise')

    {

        $tbldaterange = 'none';

        $tblsingledate = 'none';

        $tblmonthdate = '';

        $start_date = $start_year . '-' . $start_month . '-01';

        $end_month = $start_month;

        $end_year = $start_year;

        $end_day = date('t', strtotime($start_date));

        $end_date = $end_year . '-' . $end_month . '-' . $end_day;

    }

    if ($scale_range == '')

    {

        $div_start_scale_value = 'none';

        $div_end_scale_value = 'none';

        $start_scale_value = '';

        $end_scale_value = '';

    }

    elseif ($scale_range == '6')

    {

        $div_start_scale_value = '';

        $div_end_scale_value = '';

    }

    else

    {

        $div_start_scale_value = '';

        $div_end_scale_value = 'none';

        $end_scale_value = '';

    }

    if ($criteria_scale_range == '')

    {

        $div_start_criteria_scale_value = 'none';

        $div_end_criteria_scale_value = 'none';

        $start_criteria_scale_value = '';

        $end_criteria_scale_value = '';

    }

    elseif ($criteria_scale_range == '6')

    {

        $div_start_criteria_scale_value = '';

        $div_end_criteria_scale_value = '';

    }

    else

    {

        $div_start_criteria_scale_value = '';

        $div_end_criteria_scale_value = 'none';

        $end_criteria_scale_value = '';

    }

    if ($report_module == '' || $report_module == 'food_report' || $report_module == 'activity_report' || $report_module == 'bps_report' || $report_module == 'activity_analysis_report' || $report_module == 'meal_time_report')

    {

        $idscaleshow = 'none';

    }

    else

    {

        $idscaleshow = '';

    }

    if ($module_criteria == '')

    {

        $idcriteriascaleshow = 'none';

    }

    else

    {

        $idcriteriascaleshow = '';

        if ($module_criteria == '9')

        {

            $spntriggercriteria = '';

        }

    }

    if (!$error)

    {

        if ($pro_user_id == '')

        {

            $temp_permission_type = '0';

            $temp_pro_user_id = '';

        }

        elseif ($pro_user_id == '0')

        {

            $temp_permission_type = '0';

            $temp_pro_user_id = '0';

        }

        else

        {

            $temp_permission_type = '1';

            $temp_pro_user_id = $pro_user_id;

        }

        $start_date = date('Y-m-d', strtotime($start_date));

        $end_date = date('Y-m-d', strtotime($end_date));

        $report_title = 'Digital Personal Wellness Diary';

        $output = getDigitalPersonalWellnessDiaryHTML($user_id, $start_date, $end_date, $food_report, $activity_report, $wae_report, $gs_report, $sleep_report, $mc_report, $mr_report, $mle_report, $adct_report, $report_title, $temp_permission_type, $temp_pro_user_id);

        $filename = "digital_personal_wellness_diary_" . time() . ".xls";

        convert_to_excel($filename, $output);

        exit(0);

        list($food_return, $arr_meal_date, $arr_food_records, $activity_return, $arr_activity_date, $arr_activity_records, $wae_return, $arr_wae_date, $arr_wae_records, $gs_return, $arr_gs_date, $arr_gs_records, $sleep_return, $arr_sleep_date, $arr_sleep_records, $mc_return, $arr_mc_date, $arr_mc_records, $mr_return, $arr_mr_date, $arr_mr_records, $mle_return, $arr_mle_date, $arr_mle_records, $adct_return, $arr_adct_date, $arr_adct_records, $bps_return, $arr_bps_date, $arr_bps_records, $bes_return, $arr_bes_date, $arr_bes_records, $aa_return, $arr_aa_records, $mt_return, $arr_mt_records, $mdt_return, $arr_mdt_date, $arr_mdt_records) = getDigitalPersonalWellnessDiary($user_id, $start_date, $end_date, $temp_permission_type, $temp_pro_user_id, $scale_range, $start_scale_value, $end_scale_value, $report_module, $module_keyword, $module_criteria, $criteria_scale_range, $start_criteria_scale_value, $end_criteria_scale_value, $trigger_criteria);

        if ((!$food_return) && (!$activity_return) && (!$wae_return) && (!$gs_return) && (!$sleep_return) && (!$mc_return) && (!$mr_return) && (!$mle_return) && (!$adct_return) && (!$bps_return) && (!$bes_return) && (!$aa_return) && (!$mt_return) && (!$mdt_return))

        {

            $error = true;

            $tr_err_date = '';

            $err_date = 'NO Data Posted by you for your above selected Query';

        }

        $start_date = date('d-m-Y', strtotime($start_date));

        $end_date = date('d-m-Y', strtotime($end_date));

    }

    if ($err_date != '')

    {

        $err_date = '<div class="err_msg_box"><span class="blink_me">' . $err_date . '</span></div>';

    }

}

else

{

    $now = time();

    $end_date = date('d-m-Y');

    $error = true;

    $date_type = 'date_range';

    $start_month = date('m');

    $start_year = date('Y');

    $report_module = '';

    $pro_user_id = '';

    $module_keyword = '';

    $module_criteria = '';

    $scale_range = '';

    $start_scale_value = '';

    $end_scale_value = '';

    $criteria_scale_range = '';

    $start_criteria_scale_value = '';

    $end_criteria_scale_value = '';

    $trigger_criteria = '';

}

$arr_days_of_week = array();

$arr_month = array();




?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<?php include_once ('head.php'); ?>
			<!-- <script src="admin/js/fastselect.standalone.js"></script> -->
			<!-- <meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="description" content="<?php echo $meta_description; ?>" />

<meta name="keywords" content="<?php echo $meta_keywords; ?>" />

<meta name="title" content="<?php echo $meta_title; ?>" />

<title><?php echo $meta_title; ?></title>

<link href="cwri.css" rel="stylesheet" type="text/css" />

<link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">       

<link href="csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />

<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>

<script type="text/JavaScript" src="js/commonfn.js"></script>

<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/ticker-style.css" rel="stylesheet" type="text/css" />

<script src="js/jquery.ticker.js" type="text/javascript"></script>	

<style type="text/css">@import "css/jquery.datepick.css";</style> 

<script type="text/javascript" src="js/jquery.datepick.js"></script>	

<script type="text/javascript">



ddsmoothmenu.init({



mainmenuid: "smoothmenu1", //menu DIV id



orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"



classname: 'ddsmoothmenu', //class added to menu's outer DIV



//customtheme: ["#1c5a80", "#18374a"],



contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]



})







$(document).ready(function() {



$('#js-news').ticker({



    controls: true,        // Whether or not to show the jQuery News Ticker controls



    htmlFeed: true, 



    titleText: '',   // To remove the title set this to an empty String



    displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'



    direction: 'ltr'       // Ticker direction - current options are 'ltr' or 'rtl'



});







$(".QTPopup").css('display','none');







$(".feedback").click(function(){



        $(".QTPopup").animate({width: 'show'}, 'slow');



});	







$(".closeBtn").click(function(){			



        $(".QTPopup").css('display', 'none');



});



});	



</script> -->
	</head>

	<body>
		<?php include_once ('analyticstracking.php'); ?>
			<?php include_once ('analyticstracking_ci.php'); ?>
				<?php include_once ('analyticstracking_y.php'); ?>
					<?php include_once ('header.php'); ?>
						<!--header End -->
						<!--breadcrumb-->
						<!-- add by ample -->
						<script type="text/javascript">
						$("input").attr("autocomplete", "off");
						$(document).ready(function() {
							$("input").attr("autocomplete", "off");
						});
						</script>
						<div class="container">
							<div class="breadcrumb">
								<div class="row">
									<div class="col-md-8">
										<?php echo $obj->getBreadcrumbCode($page_id); ?>
									</div>
									<div class="col-md-4">
										<?php

if ($obj->isLoggedIn())

{

    echo $obj->getWelcomeUserBoxCode($_SESSION['name'], $_SESSION['user_id']);

}

?>
									</div>
								</div>
							</div>
						</div>
						<!--breadcrumb end -->
						<!--container-->
						<div class="container">
							<div class="row">
								<div class="col-md-10">
									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td align="left" valign="top">
												<?php echo $obj->getPageContents($page_id); ?>
											</td>
										</tr>
									</table>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="left" valign="top">
												<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
													<tr>
														<td align="center" valign="top" bgcolor="#FFFFFF">
															<table width="100%" border="0" cellspacing="0" cellpadding="0" id="my_tbl">
																<tr>
																	<td height="200" align="center" valign="top" class="mainnav">
																		<?php

if ($dpwd_chart == 0) // keep 1



{ ?>
																			<form action="#" id="frmreports" method="post" name="frmreports">
																				<table width="100%" border="0" cellspacing="0" cellpadding="0">
																					<tr>
																						<td width="15%" height="45" align="left" valign="top" class="Header_brown">Date Selection Type:</td>
																						<td width="30%" align="left" valign="top">
																							<!-- update by ample 21-02-20 -->
																							<select name="date_type" id="date_type" class="form-control" onchange="toggleDateSelectionTypeUserNew('date_type');changeAttr()">
																								<option value="date_range" <?php if ($date_type == 'date_range')
    { ?> selected
																									<?php
    } ?> >Date Range</option>
																								<option value="single_date" <?php if ($date_type == 'single_date')
    { ?> selected
																									<?php
    } ?>>Single Date</option>
																								<option value="month_wise" <?php if ($date_type == 'month_wise')
    { ?> selected
																									<?php
    } ?>>Month wise</option>
																								<option value="days_of_week" <?php if ($date_type == 'days_of_weeks')
    { ?> selected
																									<?php
    } ?>>Days of Week</option>
																								<option value="days_of_month" <?php if ($date_type == 'days_of_months')
    { ?> selected
																									<?php
    } ?>>Days of Months</option>
																							</select>
																						</td>
																						<td width="75%" height="45" align="left" valign="top"></td>
																					</tr>
																				</table>
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbldaterange" style="display:<?php echo $tbldaterange; ?>">
																					<tr>
																						<td width="15%" height="45" align="left" valign="top" class="Header_brown">Start Date:</td>
																						<td width="30%" align="left" valign="top">
																							<input name="start_date" id="start_date" type="text" value="<?php echo $start_date; ?>" class="form-control input-half-width" onchange="changeAttr()"> </td>
																						<td width="15%" height="45" align="left" valign="top" class="Header_brown"> &nbsp; &nbsp;End Date:</td>
																						<td width="30%" align="left" valign="top">
																							<input name="end_date" id="end_date" type="text" value="<?php echo $end_date; ?>" class="form-control input-half-width" onchange="changeAttr()"> </td>
																						<td width="10%" height="45" align="left" valign="top"></td>
																					</tr>
																				</table>
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tblsingledate" style="display:<?php echo $tblsingledate; ?>">
																					<tr>
																						<td width="15%" height="45" align="left" valign="top" class="Header_brown">Date:</td>
																						<td width="30%" align="left" valign="top">
																							<input name="single_date" id="single_date" type="text" value="<?php echo $single_date; ?>" class="form-control input-half-width" onchange="changeAttr()"> </td>
																						<td></td>
																					</tr>
																				</table>
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tblmonthdate" style="display:<?php echo $tblmonthdate; ?>">
																					<tr>
																						<td width="15%" height="45" align="left" valign="top" class="Header_brown">Month:</td>
																						<td width="20%" align="left" valign="top">
																							<select class="form-control" name="start_month" id="start_month" onchange="changeAttr()">
																								<?php echo $obj->getMonthOptions($start_month); ?>
																							</select>
																						</td>
																						<td width="5%" align="left" valign="top">&nbsp;</td>
																						<td width="20%" align="left" valign="top">
																							<select class="form-control" name="start_year" id="start_year" onchange="changeAttr()">
																								<?php

    for ($i = 2011;$i <= intval(date("Y"));$i++)

    { ?>
																									<option value="<?php echo $i; ?>" <?php if ($start_year == $i)
        { ?> selected="selected"
																										<?php
        } ?>>
																											<?php echo $i; ?>
																									</option>
																									<?php
    } ?>
																							</select>
																						</td>
																						<td width="40%" align="left" valign="top">&nbsp;</td>
																					</tr>
																				</table>
																				<?php //echo $i;
     ?>
																					<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbldaysofweek" style="display:<?php echo $tblsingledate; ?>">
																						<tr>
																							<td width="15%" height="45" align="left" valign="top" class="Header_brown">Days of Week:</td>
																							<td width="20%" align="left" valign="top">
																								<select name="days_of_week" id="days_of_week" onchange="changeAttr();" multiple="multiple" class="form-control">
																									<?php echo $obj->getDayOfWeekOptionsMultiple($arr_days_of_week); ?>
																								</select>
																							</td>
																							<td width="5%" align="left" valign="top">&nbsp;</td>
																							<td width="20%" align="left" valign="top">
																								<select class="form-control" name="start_year" id="week_year" onchange="changeAttr()">
																									<?php

    for ($i = 2011;$i <= intval(date("Y"));$i++)

    { ?>
																										<option value="<?php echo $i; ?>" <?php if ($start_year == $i)
        { ?> selected="selected"
																											<?php
        } ?>>
																												<?php echo $i; ?>
																										</option>
																										<?php
    } ?>
																								</select>
																							</td>
																							<td width="40%" align="left" valign="top">&nbsp;</td>
																						</tr>
																					</table>
																					<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbldaysofmonth" style="display:<?php echo $tblsingledate; ?>">
																						<tr>
																							<td width="15%" height="45" align="left" valign="top" class="Header_brown">Days of months:</td>
																							<td width="20%" align="left" valign="top">
																								<select name="days_of_month" id="days_of_month" onchange="changeAttr();" multiple="multiple" class="form-control">
																									<?php

    //add by ample 21-03-20
    for ($i = 1;$i <= 31;$i++)

    { ?>
																										<option value="<?php echo $i; ?>">
																											<?php echo $i; ?>
																										</option>
																										<?php
    } ?> ?>
																											<!-- comment by ample 21-03-20 -->
																											<!--  <?php echo $obj->getMonthsOptionsMultiple($arr_month); ?> -->
																								</select>
																							</td>
																							<td width="5%" align="left" valign="top">&nbsp;</td>
																							<td width="20%" align="left" valign="top">
																								<select class="form-control" name="start_year" id="month_year" onchange="changeAttr()">
																									<?php

    for ($i = 2011;$i <= intval(date("Y"));$i++)

    { ?>
																										<option value="<?php echo $i; ?>" <?php if ($start_year == $i)
        { ?> selected="selected"
																											<?php
        } ?>>
																												<?php echo $i; ?>
																										</option>
																										<?php
    } ?>
																								</select>
																							</td>
																							<td width="40%" align="left" valign="top">&nbsp;</td>
																						</tr>
																					</table>
																					<!-- toggleScaleShow(),getModuleWiseKeywordsOptions(); getModuleWiseCriteriaOptions();resetReportForm(); -->
																					<table width="100%" border="0" cellspacing="0" cellpadding="0">
																						<tr>
																							<td width="15%" height="45" align="left" valign="top" class="Header_brown">Patterns:</td>
																							<td width="30%" align="left" valign="top">
																								<?php //echo $obj->show_report_name($_GET['t']);
     ?>
																									<!-- <select name= "report_name" id="report_name" onchange="getRecordNameDetails();getRecordNameDetailscriteria();getRecordNameDetails_sub_criteria();Parameters();" class="form-control"> -->
																									<select name="report_name" id="report_name" onchange="getRecordNameDetails();Parameters();" class="form-control">
																										<option value="">Select Patterns </option>
																										<?php

    if ($vendor_id)
    {
        echo $obj->show_report_vendor_access($vendor_id, $user_id);
    }
    else
    {
        echo $obj->show_report_name($_GET['t']);
    }

?>
																									</select>
																							</td>
																							<td> </td>
																						</tr>
																						<tr>
																							<td height="4" align="left" valign="top" class="Header_brown">Keyword:</td>
																							<td align="left" valign="top" id="tdkeywordresult">
																								<!-- <input type="text" title="Keywords" name="keywords" id="keywords" placeholder="Select your keywords" list="capitals" class="form-control" multiple/>





                                                  <datalist id="capitals" class="dlist"> </datalist>

                                                    <br> -->
																								<!-- id="capitals" -->
																								<select class="multipleSelect2 multipleInputDynamic input-text-box" name="keywords[]" id="capitals" onchange="getRecordNameDetailscriteria();getRecordNameDetails_sub_criteria();" placeholder="Select your keywords" multiple>
																									<?php //echo $obj->getIngredientsByIngrdientType($_GET['sub_cat_id'],'423','70');
     ?>
																								</select>
								</div>
								<!-- <script>

                                                          $('.multipleSelect2').fastselect();

                                                    </script> -->
								<br> <span style="font-size:11px;color:#0000FF;">(Options displayed are only of Data Posted by User)</span> </td>
								<!--  <td height="10" align="left" valign="top" class="Header_brown"></td>

                                                 <td align="left" valign="top"></td> -

                                                 <td></td>  -->
								</tr>
								<tr>
									<td height="30" align="left" valign="top" class="Header_brown">Criteria1:</td>
									<td align="left" valign="top" id="tdcriteriaresult">
										<input type="text" id="module_criteria" class="form-control" name="module_criteria" list="criteriamolduls" placeholder="Select your criteria1" autocomplete="off" />
										<datalist id="criteriamolduls"> </datalist> <a href="javascript:void(0);" onclick="erase_input('module_criteria')"><i class="fa fa-eraser" aria-hidden="true" style="font-size: 15px;"></i></a>
										<br> </td>
									<!-- <td></td> -->
								</tr>
								<tr>
									<td height="30" align="left" valign="top" class="Header_brown">Criteria2:</td>
									<td align="left" valign="top" id="tdsub_criteriaresult">
										<input type="text" id="module_sub_criteria" class="form-control" name="module_criteria" list="sub_criteriamolduls" placeholder="Select your criteria2" autocomplete="off" />
										<datalist id="sub_criteriamolduls"> </datalist> <a href="javascript:void(0);" onclick="erase_input('module_sub_criteria')"><i class="fa fa-eraser" aria-hidden="true" style="font-size: 15px;"></i></a>
										<br> </td>
									<!-- <td></td> -->
								</tr>
								<tr class="parameter_row" style="display: none">
									<td height="30" align="left" valign="top" class="Header_brown">Parameters:</td>
									<td align="left" valign="top" id="sub_parameter">
										<input type="text" id="last_parameter" class="form-control" name="paramiters1" list="parameter" placeholder="Select your Parameter" onchange="display_time('scale_range','div_start_scale_value','div_end_scale_value');" autocomplete="off" />
										<datalist id="parameter"> </datalist> <a href="javascript:void(0);" onclick="erase_input('last_parameter')"><i class="fa fa-eraser" aria-hidden="true" style="font-size: 15px;"></i></a>
										<br> </td>
								</tr>
								<!-- style="display:<?php echo $idscaleshow; ?>" -->
								<tr id="idscaleshow" class="parameter_row" style="display: none">
									<td height="45" align="left" valign="top" class="Header_brown">Parameter Range:</td>
									<td align="left" valign="top">
										<select class="form-control" name="scale_range" id="scale_range" onchange="toggleScaleRangeType1('scale_range','div_start_scale_value','div_end_scale_value')">
											<option value="">All</option>
											<option value="1" <?php if ($scale_range == '1')
    { ?> selected
												<?php
    } ?> >
													<(Less Than)</option>
														<option value="2" <?php if ($scale_range == '2')
    { ?> selected
															<?php
    } ?> >>(Greater Than)</option>
														<option value="3" <?php if ($scale_range == '3')
    { ?> selected
															<?php
    } ?> > &le; (Less than or Equal to)</option>
														<option value="4" <?php if ($scale_range == '4')
    { ?> selected
															<?php
    } ?> > &ge; (Greater than or Equal to)</option>
														<option value="5" <?php if ($scale_range == '5')
    { ?> selected
															<?php
    } ?> >=(Equal)</option>
														<option value="6" <?php if ($scale_range == '6')
    { ?> selected
															<?php
    } ?> >Range</option>
										</select>
									</td>
								</tr>
								<tr class="scale_row" style="display: none;">
									<td>
										<label class="Header_brown">&nbsp;&nbsp;Scale value:</label>
									</td>
									<td> <span id="div_start_scale_value" style="display:<?php echo $div_start_scale_value; ?>">

                                                        

                                                    <span>From</span>
										<select name="start_scale_value" id="start_scale_value" class="form-control">
											<?php
    for ($i = 1;$i <= 10;$i++)

    { ?>
												<option value="<?php echo $i; ?>" <?php if ($start_scale_value == $i)
        { ?> selected
													<?php
        } ?> >
														<?php echo $i; ?>
												</option>
												<?php
    } ?>
										</select>
										</span>
									</td>
									<td> <span id="div_end_scale_value" style="display:<?php echo $div_end_scale_value; ?>">

                                                        <span>To</span>
										<select name="end_scale_value" id="end_scale_value" class="form-control" style="width: 50%;">
											<?php
    for ($i = 1;$i <= 10;$i++)

    { ?>
												<option value="<?php echo $i; ?>" <?php if ($end_scale_value == $i)
        { ?> selected
													<?php
        } ?> >
														<?php echo $i; ?>
												</option>
												<?php
    } ?>
										</select>
										</span>
									</td>
								</tr>
								<tr class="time_row" style="display: none;">
									<td>
										<label class="Header_brown">&nbsp;&nbsp;Time value:</label>
									</td>
									<td> <span id="time_show_on_select_from" style="display:none;">

                                                             <span>From Time </span>
										<input type="time" name="bes_time_from" id="bes_time_from" class="form-control" value="<?php echo $bes_time; ?>"> <span class="text-danger" style="font-size: 11px;">(EX: 05:15 AM/PM)</span>
										<!-- <select class="form-control" name="bes_time_from" id="bes_time_from" title="">

                                                              <?php //echo $obj->getTimeOptionsNew('0','23',$bes_time );
    //echo $obj->get_times('00:00','23:55',$bes_time,'+5 minutes');
    
?>

                                                            </select> -->
										</span>
									</td>
									<td> <span id="time_show_on_select_to" style="display:none;">

                                                             <span>To Time</span>
										<input type="time" name="bes_time_to" id="bes_time_to" class="form-control" value="<?php echo $bes_time; ?>" style="width: 50%"> <span class="text-danger" style="font-size: 11px;">(EX: 09:30 AM/PM)</span>
										<!-- <select class="form-control" name="bes_time_to" id="bes_time_to" title="" style="width: 50%;">

                                                              <?php //echo $obj->getTimeOptionsNew('0','23',$bes_time );
    // echo $obj->get_times('00:05','23:45',$bes_time,'+5 minutes');
    
?>

                                                            </select> -->
										</span>
									</td>
								</tr>
								<tr class="duration_row" style="display: none;">
									<td>
										<label class="Header_brown">&nbsp;&nbsp;Duration:</label>
									</td>
									<td> <span id="div_start_duration_value" style="display:none">

                                                        

                                                    <span>From</span>
										<input type="text" name="start_duration_value" id="start_duration_value" class="form-control" value="<?php echo $start_duration_value; ?>"> </span>
									</td>
									<td> <span id="div_end_duration_value" style="display:none">

                                                        <span>To</span>
										<input type="text" name="end_duration_value" id="end_duration_value" class="form-control" value="<?php echo $end_duration_value; ?>" style="width: 50%"> </span>
									</td>
								</tr>
								<!-- <tr>

                                                <td>

                                                    <select class="form-control" name="bes_time" id="bes_time_<?php echo $i; ?>" style="display:block;" title="">

                                                      <?php echo $obj->getTimeOptionsNew('0', '23', $bes_time); ?>

                                                    </select>

                                                </td>



                                            </tr> -->
								<tr>
									<!--  <td height="30" align="left" valign="top" class="Header_brown">Criteria:</td>

                                    <td align="left" valign="top" id="tdcriteriaresult">

                                    

                                     <input type="text" id="module_criteria" class="form-control" name="module_criteria" list="criteriamolduls" placeholder="Select your criteria"/>

                                     <datalist id="criteriamolduls"> </datalist>    

                                    </td> -->
									<td height="30" align="left" valign="top" class="Header_brown"> <span class="spntriggercriteria" style="display:<?php echo $spntriggercriteria; ?>">Triggers:</span> </td>
									<td align="left" valign="top"> <span id="idtriggercriteria" class="spntriggercriteria" style="display:<?php echo $spntriggercriteria; ?>">

                                                        <select name="trigger_criteria" id="trigger_criteria"  class="form-control" >

                                                            <option value="" <?php if ($trigger_criteria == '')
    { ?> selected="selected" <?php
    } ?>>All</option>

                                                            <?php echo $obj->getTriggerCriteriaOptions($user_id, $trigger_criteria); ?>

                                                        </select>

                                                        <br><span style="font-size:11px;color:#0000FF;">(Options displayed are only of Data Posted by User)</span> </span>
									</td>
									<td></td>
								</tr>
								<tr id="idcriteriascaleshow" style="display:<?php echo $idcriteriascaleshow; ?>">
									<td height="45" align="left" valign="top" class="Header_brown">Criteria Scale:</td>
									<td align="left" valign="top" id="tdcriteriascalerange">
										<select name="criteria_scale_range" id="criteria_scale_range" class="form-control" onchange="getModuleWiseCriteriaScaleValues();toggleScaleRangeType('criteria_scale_range','div_start_criteria_scale_value','div_end_criteria_scale_value');">
											<option value="">All</option>
											<?php echo $obj->getModuleWiseCriteriaScaleOptions($user_id, $report_module, $pro_user_id, $module_criteria, $criteria_scale_range); ?>
										</select>
									</td>
									<td colspan="2" align="left" valign="top" id="idcriteriascalevalues">
										<?php echo $obj->getModuleWiseCriteriaScaleValues($user_id, $report_module, $pro_user_id, $module_criteria, $criteria_scale_range, $start_criteria_scale_value, $end_criteria_scale_value); ?>
									</td>
									<td></td>
								</tr>
								</table>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="45" align="left" valign="middle">
											<input type="button" name="btnSubmit" class="btn btn-primary" id="btnSubmit" value="View Diary" onclick="return view_diary();" />
											<!-- <input type="submit" name="btnSubmit" class="btn btn-primary" id="btnSubmit" value="View Diary" /> -->
											<div class="text-danger">
												<p class="date-error"></p>
												<p class="pattern-error"></p>
												<p class="other-error"></p>
											</div>
										</td>
									</tr>
								</table>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr id="tr_err_date" style="display:<?php echo $tr_err_date; ?>;" valign="top">
										<td align="left" class="err_msg" id="err_date" valign="top">
											<?php echo $err_date; ?>
										</td>
									</tr>
								</table>
								</form>

								
								<?php

}

else

{ ?>
									<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
										<tr align="center">
											<td height="5" class="Header_brown">
												<?php echo getCommonSettingValue('3'); ?>
											</td>
										</tr>
									</table>
									<?php

} ?>
										</td>
										</tr>
										</table>
										<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
											<tr>
												<td align="left" valign="top">
													<?php echo $obj->getScrollingWindowsCodeMainContent($page_id); ?>
														<?php echo $obj->getPageContents2($page_id); ?>
												</td>
											</tr>
										</table>
										</td>
										</tr>
										</table>
										</td>
										</tr>
										</table>
							</div>
                            <div class="col-md-2"> <?php include_once('left_sidebar.php'); ?><?php include_once('right_sidebar.php'); ?></div>
						</div>
						</div>
						<?php include_once ('footer.php'); ?>
							<!--  Footer-->
							<div id="page_loading_bg" class="page_loading_bg" style="display:none;">
								<div id="page_loading_img" class="page_loading_img"><img border="0" src="<?php echo SITE_URL; ?>/images/loading.gif" /></div>
							</div>
							</div>
							</div>
							<!--container-->
							<!--  Footer-->
							<!-- Bootstrap Core JavaScript -->
							<!--default footer end here-->
							<!--scripts and plugins -->
							<!--must need plugin jquery-->
							<!-- <script src="csswell/js/jquery.min.js"></script>-->
							<!--bootstrap js plugin-->
							<script src="admin/js/fastselect.standalone.js"></script>
							<script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	</body>

	</html>
	<script>
	//add by ample
	$('#capitals').fastselect();
	$("input").attr("autocomplete", "off");
	$(document).ready(function() {
		$("input").attr("autocomplete", "off");
	});
	//31-03-20
	function find_parameter(str = "") {
		var key = '';
		if(str.indexOf('Time') != -1) {
			key = 'Time';
		} else if(str.indexOf('Scale') != -1) {
			key = 'Scale';
		} else if(str.indexOf('Duration') != -1) {
			key = 'Duration';
		}
		//alert(key);
		return key;
	}

	function changeAttr() {
		$("#report_name").find('option').removeAttr("selected");
		$('#capitals').fastselect();
		$('#capitals').html('<option>No Keywords</option>').data('fastselect').destroy();
		$('#capitals').fastselect();
		$("#module_criteria").val("");
		$("#module_sub_criteria").val("");
		$("#criteriamolduls").html('<option>No data found</option>');
		$("#sub_criteriamolduls").html('<option>No data found</option>');
	}
	//update by ample 25-02-20
	function toggleScaleRangeType1(id_val, div_start_val, div_end_val) {
		var scale_type = $('#' + id_val).val();
		var last_parameter = $('#last_parameter').val();
		last_parameter = find_parameter(last_parameter);
		if(last_parameter == "Time" && scale_type == "6") {
			$('.time_row').show();
			$('.duration_row').hide();
			$('.scale_row').hide();
			$('#time_show_on_select_from').show();
			$('#time_show_on_select_to').show();
			$('#div_start_scale_value').hide();
			$('#div_end_scale_value').hide();
			$('#div_start_duration_value').hide();
			$('#div_end_duration_value').hide();
		} else if(last_parameter == "Time" && scale_type != "6") {
			$('.time_row').show();
			$('.duration_row').hide();
			$('.scale_row').hide();
			$('#time_show_on_select_from').show();
			$('#time_show_on_select_to').hide();
			$('#div_start_scale_value').hide();
			$('#div_end_scale_value').hide();
			$('#div_start_duration_value').hide();
			$('#div_end_duration_value').hide();
		} else
		if(last_parameter == "Scale" && scale_type == "6") {
			$('.scale_row').show();
			$('.time_row').hide();
			$('.duration_row').hide();
			$('#div_start_scale_value').show();
			$('#div_end_scale_value').show();
			$('#time_show_on_select_from').hide();
			$('#time_show_on_select_to').hide();
			$('#div_start_duration_value').hide();
			$('#div_end_duration_value').hide();
		} else
		if(last_parameter == "Scale" && scale_type != "6") {
			$('.scale_row').show();
			$('.time_row').hide();
			$('.duration_row').hide();
			$('#div_start_scale_value').show();
			$('#div_end_scale_value').hide();
			$('#time_show_on_select_from').hide();
			$('#time_show_on_select_to').hide();
			$('#div_start_duration_value').hide();
			$('#div_end_duration_value').hide();
		} else
		if(last_parameter == "Duration" && scale_type == "6") {
			$('.duration_row').show();
			$('.scale_row').hide();
			$('.time_row').hide();
			$('#div_start_duration_value').show();
			$('#div_end_duration_value').show();
			$('#time_show_on_select_from').hide();
			$('#time_show_on_select_to').hide();
			$('#div_start_scale_value').hide();
			$('#div_end_scale_value').hide();
		} else
		if(last_parameter == "Duration" && scale_type != "6") {
			$('.duration_row').show();
			$('.scale_row').hide();
			$('.time_row').hide();
			$('#div_start_duration_value').show();
			$('#div_end_duration_value').hide();
			$('#time_show_on_select_from').hide();
			$('#time_show_on_select_to').hide();
			$('#div_start_scale_value').hide();
			$('#div_end_scale_value').hide();
		} else {
			$('.scale_row').hide();
			$('.time_row').hide();
			$('.duration_row').hide();
			$('#time_show_on_select_from').hide();
			$('#time_show_on_select_to').hide();
			$('#div_end_scale_value').hide();
			$('#div_start_scale_value').hide();
			$('#div_start_duration_value').hide();
			$('#div_end_duration_value').hide();
		}
	}
	//update by ample 25-02-20
	function display_time(id_val, div_start_val, div_end_val) {
		var scale_type = $('#' + id_val).val();
		var last_parameter = $('#last_parameter').val();
		last_parameter = find_parameter(last_parameter);
		if(last_parameter == "Time" && scale_type == "6") {
			$('.time_row').show();
			$('.duration_row').hide();
			$('.scale_row').hide();
			$('#time_show_on_select_from').show();
			$('#time_show_on_select_to').show();
			$('#div_start_scale_value').hide();
			$('#div_end_scale_value').hide();
			$('#div_start_duration_value').hide();
			$('#div_end_duration_value').hide();
		} else if(last_parameter == "Time" && scale_type != "6") {
			$('.time_row').show();
			$('.duration_row').hide();
			$('.scale_row').hide();
			$('#time_show_on_select_from').show();
			$('#time_show_on_select_to').hide();
			$('#div_start_scale_value').hide();
			$('#div_end_scale_value').hide();
			$('#div_start_duration_value').hide();
			$('#div_end_duration_value').hide();
		} else
		if(last_parameter == "Scale" && scale_type == "6") {
			$('.scale_row').show();
			$('.time_row').hide();
			$('.duration_row').hide();
			$('#div_start_scale_value').show();
			$('#div_end_scale_value').show();
			$('#time_show_on_select_from').hide();
			$('#time_show_on_select_to').hide();
			$('#div_start_duration_value').hide();
			$('#div_end_duration_value').hide();
		} else
		if(last_parameter == "Scale" && scale_type != "6") {
			$('.scale_row').show();
			$('.time_row').hide();
			$('.duration_row').hide();
			$('#div_start_scale_value').show();
			$('#div_end_scale_value').hide();
			$('#time_show_on_select_from').hide();
			$('#time_show_on_select_to').hide();
			$('#div_start_duration_value').hide();
			$('#div_end_duration_value').hide();
		} else
		if(last_parameter == "Duration" && scale_type == "6") {
			$('.duration_row').show();
			$('.scale_row').hide();
			$('.time_row').hide();
			$('#div_start_duration_value').show();
			$('#div_end_duration_value').show();
			$('#time_show_on_select_from').hide();
			$('#time_show_on_select_to').hide();
			$('#div_start_scale_value').hide();
			$('#div_end_scale_value').hide();
		} else
		if(last_parameter == "Duration" && scale_type != "6") {
			$('.duration_row').show();
			$('.scale_row').hide();
			$('.time_row').hide();
			$('#div_start_duration_value').show();
			$('#div_end_duration_value').hide();
			$('#time_show_on_select_from').hide();
			$('#time_show_on_select_to').hide();
			$('#div_start_scale_value').hide();
			$('#div_end_scale_value').hide();
		} else {
			$('.scale_row').hide();
			$('.time_row').hide();
			$('.duration_row').hide();
			$('#time_show_on_select_from').hide();
			$('#time_show_on_select_to').hide();
			$('#div_end_scale_value').hide();
			$('#div_start_scale_value').hide();
			$('#div_start_duration_value').hide();
			$('#div_end_duration_value').hide();
		}
	}
	//old function for keywords
	// function getRecordNameDetails()
	// {
	//   	var report_name=$('#report_name').val();
	//     var spli=report_name.split(',');
	//    	// console.log(spli[0]);
	//     //alert('sssssss');
	//   	var dataString = 'action=getRecordNameDetailsKR&recored_id='+spli[0];
	//   	$.ajax({
	//     type: "POST",
	//     url: "remote2.php",
	//     data: dataString,
	//     cache: false,
	//     success: function(result)
	//     { 
	//       //console.log(result);
	//       if(result!='')
	//       {
	//       	$('#capitals').fastselect();
	//         $('#capitals').html(result).data('fastselect').destroy();
	//         $('#capitals').fastselect();
	//       }
	//       else
	//       {
	//         //alert('No details.');
	//         $("#capitals").html('<option>Select list</option>');
	//       }
	//     }
	//   }); 
	// }
	//new function for keywords (added condition with dates)
	function getRecordNameDetails() {
		var report_name = $('#report_name').val();
		var spli = report_name.split(',');
		var date_type = $('#date_type').val();
		error1 = false;
		if(date_type == 'date_range') {
			var start_date = $('#start_date').val();
			var end_date = $('#end_date').val();
			if(!(start_date) || !(end_date)) {
				error1 = true;
			}
			var arr = [start_date, end_date];
		} else if(date_type == 'single_date') {
			var single_date = $('#single_date').val();
			if(!(single_date)) {
				error1 = true;
			}
			var arr = [single_date];
		} else if(date_type == 'month_wise') {
			var start_month = $('#start_month').val();
			var start_year = $('#start_year').val();
			if(!(start_month) || !(start_year)) {
				error1 = true;
			}
			var arr = [start_month, start_year];
		} else if(date_type == 'days_of_week') {
			var days_of_week = $('#days_of_week').val();
			var start_year = $('#week_year').val();
			if(!(days_of_week) || !(start_year)) {
				error1 = true;
			}
			var arr = [days_of_week, start_year];
		} else if(date_type == 'days_of_month') {
			var days_of_month = $('#days_of_month').val();
			var start_year = $('#month_year').val();
			if(!(days_of_month) || !(start_year)) {
				error1 = true;
			}
			var arr = [days_of_month, start_year];
		}
		if(report_name != '' && error1 != true) {
			var spli = report_name.split(',');
			$.ajax({
				type: "POST",
				url: "remote2.php",
				data: {
					recored_id: spli[0],
					action: 'getRecordNameDetailsKR',
					date_type: date_type,
					arr: arr
				},
				cache: false,
				success: function(result) {
					//console.log(result);
					if(result != '') {
						$('#capitals').fastselect();
						$('#capitals').html(result).data('fastselect').destroy();
						$('#capitals').fastselect();
					} else {
						//alert('No details.');
						$("#capitals").html('<option>Select list</option>');
					}
				}
			});
		} else {
			alert('Please select date first');
			$("#report_name").find('option').removeAttr("selected");
			return false;
		}
	}
	//old function for criteria 1
	// function getRecordNameDetailscriteria()
	// {
	//     var report_name=$('#report_name').val();
	//     var spli=report_name.split(',');
	//    // console.log(spli[0]);
	//   var dataString = 'action=getRecordNameDetailscriteriakr&recored_id='+spli[0];
	//   $.ajax({
	//     type: "POST",
	//     url: "remote2.php",
	//     data: dataString,
	//     cache: false,
	//     success: function(result)
	//     {
	//       if(result!='')
	//       {
	//          $("#criteriamolduls").html(result);
	//       }
	//       else
	//       {
	//         //alert('No details.');
	//         $("#criteriamolduls").html('<option>Select list</option>');
	//       }
	//     }
	//   }); 
	// }
	//new function for criteria1
	function getRecordNameDetailscriteria() {
		var report_name = $('#report_name').val();
		var keywords = $('#capitals').val();
		var date_type = $('#date_type').val();
		error1 = false;
		if(date_type == 'date_range') {
			var start_date = $('#start_date').val();
			var end_date = $('#end_date').val();
			if(!(start_date) || !(end_date)) {
				error1 = true;
			}
			var arr = [start_date, end_date];
		} else if(date_type == 'single_date') {
			var single_date = $('#single_date').val();
			if(!(single_date)) {
				error1 = true;
			}
			var arr = [single_date];
		} else if(date_type == 'month_wise') {
			var start_month = $('#start_month').val();
			var start_year = $('#start_year').val();
			if(!(start_month) || !(start_year)) {
				error1 = true;
			}
			var arr = [start_month, start_year];
		} else if(date_type == 'days_of_week') {
			var days_of_week = $('#days_of_week').val();
			var start_year = $('#week_year').val();
			if(!(days_of_week) || !(start_year)) {
				error1 = true;
			}
			var arr = [days_of_week, start_year];
		} else if(date_type == 'days_of_month') {
			var days_of_month = $('#days_of_month').val();
			var start_year = $('#month_year').val();
			if(!(days_of_month) || !(start_year)) {
				error1 = true;
			}
			var arr = [days_of_month, start_year];
		}
		var spli = report_name.split(',');
		if(report_name != '' && keywords != '' && error1 != true) {
			$.ajax({
				type: "POST",
				url: "remote2.php",
				data: {
					recored_id: spli[0],
					action: 'getRecordNameDetailscriteriakr',
					keywords: keywords,
					date_type: date_type,
					arr: arr
				},
				cache: false,
				success: function(result) {
					if(result != '') {
						$("#criteriamolduls").html(result);
					} else {
						//alert('No details.');
						$("#criteriamolduls").html('<option>Select list</option>');
					}
				}
			});
		} else {
			alert('Please select date first');
			return false;
		}
	}
	//old function
	// function getRecordNameDetails_sub_criteria()
	// {
	//  var report_name=$('#report_name').val();
	//  var spli=report_name.split(',');
	//   var dataString = 'action=getRecordNameDetails_sub_criteriakr&recored_id='+spli[0];
	//   $.ajax({
	//     type: "POST",
	//     url: "remote2.php",
	//     data: dataString,
	//     cache: false,
	//     success: function(result)
	//     {
	//       if(result!='')
	//       {
	//          $("#sub_criteriamolduls").html(result);
	//       }
	//       else
	//       {
	//         alert('No details.');
	//         $("#sub_criteriamolduls").html('<option>Select list</option>');
	//       }
	//     }
	//   }); 
	// }
	//new function
	function getRecordNameDetails_sub_criteria() {
		var report_name = $('#report_name').val();
		var keywords = $('#capitals').val();
		var date_type = $('#date_type').val();
		error1 = false;
		if(date_type == 'date_range') {
			var start_date = $('#start_date').val();
			var end_date = $('#end_date').val();
			if(!(start_date) || !(end_date)) {
				error1 = true;
			}
			var arr = [start_date, end_date];
		} else if(date_type == 'single_date') {
			var single_date = $('#single_date').val();
			if(!(single_date)) {
				error1 = true;
			}
			var arr = [single_date];
		} else if(date_type == 'month_wise') {
			var start_month = $('#start_month').val();
			var start_year = $('#start_year').val();
			if(!(start_month) || !(start_year)) {
				error1 = true;
			}
			var arr = [start_month, start_year];
		} else if(date_type == 'days_of_week') {
			var days_of_week = $('#days_of_week').val();
			var start_year = $('#week_year').val();
			if(!(days_of_week) || !(start_year)) {
				error1 = true;
			}
			var arr = [days_of_week, start_year];
		} else if(date_type == 'days_of_month') {
			var days_of_month = $('#days_of_month').val();
			var start_year = $('#month_year').val();
			if(!(days_of_month) || !(start_year)) {
				error1 = true;
			}
			var arr = [days_of_month, start_year];
		}
		var spli = report_name.split(',');
		if(report_name != '' && keywords != '' && error1 != true) {
			$.ajax({
				type: "POST",
				url: "remote2.php",
				data: {
					recored_id: spli[0],
					action: 'getRecordNameDetails_sub_criteriakr',
					keywords: keywords,
					date_type: date_type,
					arr: arr
				},
				cache: false,
				success: function(result) {
					if(result != '') {
						$("#sub_criteriamolduls").html(result);
					} else {
						//alert('No details.');
						$("#sub_criteriamolduls").html('<option>Select list</option>');
					}
				}
			});
		} else {
			alert('Please select date first');
			return false;
		}
	}

	function Parameters() {
		var report_name = $('#report_name').val();
		var spli = report_name.split(',');
		var dataString = 'action=getRecordNameDetails_parameter_kr&recored_id=' + spli[0];
		$.ajax({
			type: "POST",
			url: "remote2.php",
			data: dataString,
			cache: false,
			success: function(result) {
				if($.trim(result)) {
					$('.parameter_row').show();
					$("#parameter").html('<option>All</option>');
					$("#parameter").append(result);
				} else {
					//alert('No details.');
					$('.parameter_row').hide();
					$("#parameter").html('<option>Select list</option>');
				}
			}
		});
	}
	// add validation by ample 28-02-20
	function view_diary() {
		var error1 = false;
		var error2 = false;
		var error3 = true;
		var date_type = $('#date_type').val();
		if(date_type == 'date_range') {
			var start_date = $('#start_date').val();
			var end_date = $('#end_date').val();
			if(!(start_date) || !(end_date)) {
				error1 = true;
			}
			var arr = [start_date, end_date];
		} else if(date_type == 'single_date') {
			var single_date = $('#single_date').val();
			if(!(single_date)) {
				error1 = true;
			}
			var arr = [single_date];
		} else if(date_type == 'month_wise') {
			var start_month = $('#start_month').val();
			var start_year = $('#start_year').val();
			if(!(start_month) || !(start_year)) {
				error1 = true;
			}
			var arr = [start_month, start_year];
		} else if(date_type == 'days_of_week') {
			var days_of_week = $('#days_of_week').val();
			var start_year = $('#week_year').val();
			if(!(days_of_week) || !(start_year)) {
				error1 = true;
			}
			var arr = [days_of_week, start_year];
		} else if(date_type == 'days_of_month') {
			var days_of_month = $('#days_of_month').val();
			var start_year = $('#month_year').val();
			if(!(days_of_month) || !(start_year)) {
				error1 = true;
			}
			var arr = [days_of_month, start_year];
		}
		var report_name = $('#report_name').val();
		if(!(report_name)) {
			error2 = true;
		}
		var col_name_input = $('#col_name_input').val();
		var keywords = $('#capitals').val();
		var scale_range = $('#scale_range').val();
		var last_parameter = $('#last_parameter').val();
		last_parameter = find_parameter(last_parameter);
		if(last_parameter == "Time" && scale_range == 6) {
			var parameter_value1 = $('#bes_time_from').val();
			var parameter_value2 = $('#bes_time_to').val();
		} else if(last_parameter == "Scale" && scale_range == 6) {
			var parameter_value1 = $('#start_scale_value').val();
			var parameter_value2 = $('#end_scale_value').val();
		}
		//add by ample
		else if(last_parameter == "Duration" && scale_range == 6) {
			var parameter_value1 = $('#start_duration_value').val();
			var parameter_value2 = $('#end_duration_value').val();
		} else if(last_parameter == "Time" && scale_range != 6) {
			var parameter_value1 = $('#bes_time_from').val();
			var parameter_value2 = "";
		} else if(last_parameter == "Scale" && scale_range != 6) {
			var parameter_value1 = $('#start_scale_value').val();
			var parameter_value2 = "";
		}
		//add by ample
		else if(last_parameter == "Duration" && scale_range != 6) {
			var parameter_value1 = $('#start_duration_value').val();
			var parameter_value2 = "";
		}
		if(last_parameter && scale_range && parameter_value1) {
			last_parameter = $('#last_parameter').val();
		} else {
			last_parameter = "";
		}
		// alert(scale_range);
		// var module_criteria=$('#module_criteria').val();
		// var criteria_name=$('#criteriamolduls[value='+module_criteria+']').data('value');
		var module_criteria = document.getElementById("module_criteria").value;
		//code by ample 27-02-20
		if(module_criteria != '') {
			var criteria_name = document.querySelector("#criteriamolduls option[value='" + module_criteria + "']").dataset.value;
			module_criteria = document.querySelector("#criteriamolduls option[value='" + module_criteria + "']").dataset.id;
			if(module_criteria == '' || module_criteria == 'NULL') {
				module_criteria = document.getElementById("module_criteria").value;
			}
		} else {
			var criteria_name = "";
		}
		var module_sub_criteria = document.getElementById("module_sub_criteria").value;
		//add  by ample 27-02-20
		if(module_sub_criteria != '') {
			var criteria_sub_name = document.querySelector("#sub_criteriamolduls option[value='" + module_sub_criteria + "']").dataset.value;
			module_sub_criteria = document.querySelector("#sub_criteriamolduls option[value='" + module_sub_criteria + "']").dataset.id;
			if(module_sub_criteria == '' || module_sub_criteria == 'NULL') {
				module_sub_criteria = document.getElementById("module_sub_criteria").value;
			}
		} else {
			var criteria_sub_name = "";
		}
		//if(module_criteria || module_sub_criteria || keywords) 
		// change by ample 30-03-20
		if(keywords) {
			error3 = false;
		} else {
			error3 = true;
		}
		if(error1 == true || error2 == true || error3 == true) {
			if(error1) {
				$('.date-error').html('Date field is required!');
			} else {
				$('.date-error').html('');
			}
			if(error2) {
				$('.pattern-error').html('Select at least one Pattern!');
			} else {
				$('.pattern-error').html('');
			}
			if(error3) {
				//$('.other-error').html('Please Choose one option Keyword/Criteria1/Criteria2'); 
				// change by ample 30-03-20
				$('.other-error').html('Please Choose Keywords');
			} else {
				$('.other-error').html('');
			}
			return false;
		}
		var arr = {
			arr, date_type, report_name, keywords, module_criteria, keywords, scale_range, criteria_name, module_sub_criteria, criteria_sub_name, last_parameter, parameter_value1, parameter_value2
		};
		//console.log(arr);
		// return false;
		$.ajax({
			type: "POST",
			dataYpe: 'JSON',
			url: "remote2.php",
			data: ({
				arr: arr,
				action: 'myLifepatternKR'
			}),
			cache: false,
			success: function(result) {
				
                var response = JSON.parse(result);

                if(response.access==1)
                {
                    document.location.href = 'report_formate.php?b=' + btoa(result);
                }
                else
                {
                    alert('Your current plan report limit exceeded now!');
                    return false;
                }
               
				
			}
		});
	}
	// function getcollname()
	// {
	//     var module_criteria=$('#module_criteria').val(); 
	//     var col_name=$('#col_name').val(); 
	//        $.ajax({
	//         type: "POST",
	//         dataYpe:'JSON',
	//         url: "remote2.php",
	//         data: ({module_criteria:module_criteria,action:'mycolumnname'}),
	//         cache: false,
	//         success: function(result)
	//         {
	//              alert(result);
	//         }
	//     });
	// }
	function getcolumns_name() {
		var capitals = $('#capitals').val();
		var col_name = $('#col_name').val();
		$.ajax({
			type: "POST",
			dataYpe: 'JSON',
			url: "remote2.php",
			data: ({
				capitals: capitals,
				action: 'getcolums_name_value'
			}),
			cache: false,
			success: function(result) {
				document.location.href = 'report_formate.php?b=' + btoa(result);
			}
		});
	}
	//add by ample 31-03-20
	function erase_input(id) {
		$("#" + id).val('');
		if(id = "last_parameter") {
			$('.scale_row').hide();
			$('.time_row').hide();
			$('.duration_row').hide();
		}
	}
	// var str1 = "STACK-OV0ER-FLOW";
	// var str2 = "OVER";
	// if(str1.indexOf(str2) != -1){
	//     alert(str2 + " found");
	// }
	// else
	// {
	// 	alert('not found');
	// }
	</script>
	<style>
	.fstElement {
		/*display: initial !important; */
		position: relative;
		border: 1px solid #D7D7D7;
		box-sizing: border-box;
		color: #232323;
		font-size: 10px;
		background-color: #fff;
		width: 100%;
	}
	
	.fstMultipleMode .fstControls {
		box-sizing: border-box;
		padding: inherit !important;
		overflow: hidden;
		width: inherit !important;
		cursor: text;
	}
	</style>
