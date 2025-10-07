<?php

ini_set("memory_limit","200M");

if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };

@set_time_limit(1000000);

include('config.php');

$page_id = '50';

list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);



$ref = base64_encode('monthly_wellness_tracker_report.php');

if(!isLoggedIn())

{

	header("Location: login.php?ref=".$ref);

	exit(0);

}

else

{

	$user_id = $_SESSION['user_id'];

	doUpdateOnline($_SESSION['user_id']);

}



list($food_chart,$each_meal_per_day_chart,$my_activity_calories_chart,$my_activity_calories_pi_chart,$activity_analysis_chart,$meal_chart,$dpwd_chart,$mwt_report,$datewise_emotions_report,$statementwise_emotions_report,$statementwise_emotions_pi_report,$angervent_intensity_report,$stressbuster_intensity_report)= get_user_reports_permissions($user_id);  

if(chkUserPlanFeaturePermission($user_id,'8'))
{
	$mwt_report = 1;
}
else
{
	$mwt_report = 0;
}

$return = false;



$error = false;

$tr_err_date = 'none';

$err_date = '';

$start_day = '01';
$end_day = '31';
if(isset($_POST['btnSubmit']))	
{
	$start_month = strip_tags(trim($_POST['start_month']));
	$start_year = strip_tags(trim($_POST['start_year']));
}
else
{
	$start_month = date('m',strtotime('last month'));
	$start_year = date('Y',strtotime('last month'));
	$end_day = date('t',strtotime('last month'));
}

//$start_date = date('Y-m-01',strtotime('last month'));
//$end_date = date('Y-m-t',strtotime('last month'));
$start_date = $start_year.'-'.$start_month.'-'.$start_day;

$end_month = $start_month;	
$end_year = $start_year;
$end_day = date('t',strtotime($start_date));	

$end_date = $end_year.'-'.$end_month.'-'.$end_day;

$food_report = '1';
$activity_report = '1';
$wae_report = '1';
$gs_report = '1';
$sleep_report = '1';
$mc_report = '1';
$mr_report = '1';
$mle_report = '1';
$adct_report = '1';

if(isset($_POST['btnPdfReport']))	

{
	$temp_permission_type = '0';
	$temp_pro_user_id = '0';

	$report_title = 'Monthly Wellness Tracker Report - For Month of - '.date('M Y',strtotime('last month'));

	$output = getDigitalPersonalWellnessDiaryHTML($user_id,$start_date,$end_date,$food_report,$activity_report,$wae_report,$gs_report,$sleep_report,$mc_report,$mr_report,$mle_report,$adct_report,$report_title,$temp_permission_type,$temp_pro_user_id);	

	$tmp_month = date('M_Y',strtotime('last month'));

	$filename ="monthly_wellness_tracker_report_".$tmp_month."_".time().".xls";

	convert_to_excel($filename,$output);

	exit(0);

	list($food_return,$arr_meal_date,$arr_food_records,$activity_return,$arr_activity_date,$arr_activity_records,$wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records) = getDigitalPersonalWellnessDiary($user_id,$start_date,$end_date,$temp_permission_type,$temp_pro_user_id);

	if( (!$food_return) && (!$activity_return) && (!$wae_return) && (!$gs_return) && (!$sleep_return) && (!$mc_return) && (!$mr_return) && (!$mle_return) && (!$adct_return) )
	{
		$error = true;
		$tr_err_date = '';
		$err_date = 'No records found in given date range!';	
	}
}

$temp_permission_type = '0';
$temp_pro_user_id = '0';

list($food_return,$arr_meal_date,$arr_food_records,$activity_return,$arr_activity_date,$arr_activity_records,$wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records) = getDigitalPersonalWellnessDiary($user_id,$start_date,$end_date,$temp_permission_type,$temp_pro_user_id);

if( (!$food_return) && (!$activity_return) && (!$wae_return) && (!$gs_return) && (!$sleep_return) && (!$mc_return) && (!$mr_return) && (!$mle_return) && (!$adct_return) )

{
	$error = true;
	$tr_err_date = '';
	//$err_date = 'You have not entered any data for '.date('M Y',strtotime('last month')).' month!';	
	$err_date = 'You have not entered any data for '.date('M Y',strtotime($start_date)).'.';	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="description" content="<?php echo $meta_description;?>" />

	<meta name="keywords" content="<?php echo $meta_keywords;?>" />

	<meta name="title" content="<?php echo $meta_title;?>" />

	<title><?php echo $meta_title;?></title>

	<link href="cwri.css" rel="stylesheet" type="text/css" />

	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>

	<script type="text/JavaScript" src="js/commonfn.js"></script>

	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

	<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
    
     <link href="css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery.ticker.js" type="text/javascript"></script>

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

		$(".QTPopup").css('display','none')

			

			$(".feedback").click(function(){

				$(".QTPopup").animate({width: 'show'}, 'slow');

			});	

		

			$(".closeBtn").click(function(){			

				$(".QTPopup").css('display', 'none');

			});

		});	

	</script>

</head>

<body>

<?php include_once('analyticstracking.php'); ?>

<?php include_once('analyticstracking_ci.php'); ?>

<?php include_once('analyticstracking_y.php'); ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

	<tr>

		<td align="center" valign="top">

			<?php include_once('header.php'); ?>

			

			

			<table width="940" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="40" align="left" valign="top" class="breadcrumb">
                        <?php echo getBreadcrumbCode($page_id);?>
                    </td>
                </tr>
            </table>

			<table width="940" border="0" cellspacing="0" cellpadding="0">

				<tr>

					<td align="left" valign="top">

						<table width="940" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">

							<tr>

								<td align="center" valign="top" bgcolor="#FFFFFF">

									<table width="940" border="0" cellspacing="0" cellpadding="0" id="my_tbl">

										<tr>

											<td height="200" align="center" valign="top" class="mainnav">

										<?php 

										if($mwt_report == 1 ) 

										{ ?>

                                              <table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr valign="top">

														<td align="left" colspan="3" class="Header_brown" valign="top">Monthly Wellness Tracker Report</td>

													</tr>

												</table>

                                                 

                                                <form action="#" id="frmactivity" method="post" name="frmactivity">
												<table width="920" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="120" height="45" align="left" valign="middle" class="Header_brown">Select Month:</td>
														<td width="180" align="left" valign="middle">
															<select name="start_month" id="start_month">
																<?php echo getMonthOptions($start_month); ?>
															</select>
															<select name="start_year" id="start_year">
																
															<?php
															for($i=2011;$i<=intval(date("Y"));$i++)
															{ ?>
																<option value="<?php echo $i;?>" <?php if($start_year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
															<?php
															} ?>	
															</select>
															
														</td>
														<td width="620" height="45" align="left" valign="middle"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>
													</tr>
                                                </table>  
												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr id="tr_err_date" style="display:<?php echo $tr_err_date;?>;" valign="top">

														<td align="left" colspan="3" class="err_msg" id="err_date" valign="top"><?php echo $err_date;?></td>

													</tr>

												</table>

												</form>

												<?php

                                                if(!$error)

                                                {?>

                                                <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">

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

                                                        <td height="30" align="left" valign="middle"><?php echo getUserFullNameById($user_id);?></td>

                                                        <td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td height="30" align="left" valign="middle"><?php echo getUserUniqueId($user_id);?></td>

                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

                                                    </tr>

                                                    <tr>	

                                                        <td height="30" align="left" valign="middle"><strong>Age</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td height="30" align="left" valign="middle"><?php echo getAgeOfUser($user_id);?></td>

                                                        <td height="30" align="left" valign="middle"><strong>Height</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td height="30" align="left" valign="middle"><?php echo getHeightOfUser($user_id). ' cms';?></td>

                                                        <td height="30" align="left" valign="middle"><strong>Weight</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td height="30" align="left" valign="middle"><?php echo getWeightOfUser($user_id). ' Kgs';?></td>

                                                    </tr>

                                                    <tr>	

                                                        <td height="30" align="left" valign="middle"><strong>BMI</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td height="30" align="left" valign="middle"><?php echo getBMIOfUser($user_id);?></td>

                                                        <td height="30" align="left" valign="middle"><strong>BMI Observations</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td height="30" align="left" valign="middle"><?php echo getBMRObservationOfUser($user_id);?></td>

                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

                                                        <td height="30" align="left" valign="middle">&nbsp;</td>

                                                    </tr>

                                                    <tr>	

                                                        <td colspan="9" align="left" height="30">&nbsp;</td>

                                                    </tr>

                                                </tbody>

                                                </table>

                                                <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">

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

                                                }?>    

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

														<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Food</td>

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

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $v['meal_time'][$i];?></td>

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

															<?php 

															if($v['meal_id'][$i] == '9999999999')

															{

																echo $v['meal_others'][$i];

															}

															else

															{

																echo getMealName($v['meal_id'][$i]);

															}

															?>

														</td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['meal_quantity'][$i].' ('.$v['meal_measure'][$i],' )';?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['meal_like'][$i];?><br /><?php echo getMealLikeIcon($v['meal_like'][$i]); ?></td>	

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

														<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Activity</td>

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

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>

														<td width="385" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Activity</td>	

														<td width="100" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Duration</td>	

                                                        <td width="85" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Proper guidance</td>	

                                                        <td width="200" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Precaution</td>	

													</tr>	

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $v['today_wakeup_time'][0];?></td>

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">Wake Up </td>	

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF"></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"></td>	

													</tr>	

														<?php

                                                        for($i=0;$i<count($v['activity_id']);$i++)

                                                        { ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $v['activity_time'][$i];?></td>

														<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

															<?php 

															if($v['activity_id'][$i] == '9999999999')

															{

																echo $v['other_activity'][$i];

															}

															else

															{

																echo getDailyActivityName($v['activity_id'][$i]);

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

												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Work & Environment</td>

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

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getWAESituation($v['selected_wae_id'][$i]); ?></td>	

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

														<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;General Stressors</td>

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

                                                        for($i=0;$i<count($v['selected_gs_id']);$i++)

                                                        { ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getGSSituation($v['selected_gs_id'][$i]); ?></td>	

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

														<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Sleep</td>

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

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getSleepSituation($v['selected_sleep_id'][$i]); ?></td>	 

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

														<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;My Communication</td>

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

                                                        for($i=0;$i<count($v['selected_mc_id']);$i++)

                                                        { ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getMCSituation($v['selected_mc_id'][$i]); ?></td>	

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

														<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;My Relations</td>

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

                                                        for($i=0;$i<count($v['selected_mr_id']);$i++)

                                                        { ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getMRSituation($v['selected_mr_id'][$i]); ?></td>	

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

														<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Major Life Events</td>

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

                                                        for($i=0;$i<count($v['selected_mle_id']);$i++)

                                                        { ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getMLESituation($v['selected_mle_id'][$i]); ?></td>	

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

														<td width="920" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Addictions</td>

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

                                                        for($i=0;$i<count($v['selected_adct_id']);$i++)

                                                        { ?>

													<tr>

														<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getADCTSituation($v['selected_adct_id'][$i]); ?></td>	

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

                                                <table width="920" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td align="left">

                                                            <form action="#" method="post" name="frmpdfreports" id="frmpdfreports">

                                                                <input type="hidden" name="hdnuser_id" id="hdnhdnuser_id" value="<?php echo $user_id;?>" />

                                                                <input type="hidden" name="hdnstart_day" id="hdnstart_day" value="<?php echo $start_day;?>" />

                                                                <input type="hidden" name="hdnstart_month" id="hdnstart_month" value="<?php echo $start_month;?>" />

                                                                <input type="hidden" name="hdnstart_year" id="hdnstart_year" value="<?php echo $start_year;?>" />

                                                                <input type="hidden" name="hdnend_day" id="hdnend_day" value="<?php echo $end_day;?>" />

                                                                <input type="hidden" name="hdnend_month" id="hdnend_month" value="<?php echo $end_month;?>" />

                                                                <input type="hidden" name="hdnend_year" id="hdnend_year" value="<?php echo $end_year;?>" />

                                                                <input type="hidden" name="hdnfood_report" id="hdnfood_report" value="<?php echo $food_report;?>" />

                                                                <input type="hidden" name="hdnactivity_report" id="hdnactivity_report" value="<?php echo $activity_report;?>" />

                                                                <input type="hidden" name="hdnwae_report" id="hdnwae_report" value="<?php echo $wae_report;?>" />

                                                                <input type="hidden" name="hdngs_report" id="hdngs_report" value="<?php echo $gs_report;?>" />

                                                                <input type="hidden" name="hdnsleep_report" id="hdnsleep_report" value="<?php echo $sleep_report;?>" />

                                                                <input type="hidden" name="hdnmc_report" id="hdnmc_report" value="<?php echo $mc_report;?>" />

                                                                <input type="hidden" name="hdnmr_report" id="hdnmr_report" value="<?php echo $mr_report;?>" />

                                                                <input type="hidden" name="hdnmle_report" id="hdnmle_report" value="<?php echo $mle_report;?>" />

                                                                <input type="hidden" name="hdnadct_report" id="hdnadct_report" value="<?php echo $adct_report;?>" />

                                                                <input type="submit" name="btnPdfReport" id="btnPdfReport" value="Save to Excel"/>

                                                            </form>

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

											else 

											{ ?>

                                            	<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">

													<tr align="center">

														<td height="5" class="Header_brown"><?php echo getCommonSettingValue('3');?></td>

													</tr>

												</table>

											<?php 

											} ?>

											</td>

										</tr>

									</table>

								</td>

							</tr>

						</table>

						<table width="940" border="0" cellspacing="0" cellpadding="0">

							<tr>

								<td>&nbsp;</td>

							</tr>

						</table>

					</td>

				</tr>

			</table>

			<?php include_once('footer.php'); ?>

		</td>

	</tr>

</table>

<div id="page_loading_bg" class="page_loading_bg" style="display:none;">

	<div id="page_loading_img" class="page_loading_img"><img border="0" src="<?php echo SITE_URL;?>/images/loading.gif" /></div>

</div> 

</body>

</html>