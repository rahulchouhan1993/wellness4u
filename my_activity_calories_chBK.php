<?php
include('config.php');
$page_id = '21';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);



$ref = base64_encode('my_activity_calories_chart.php');

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

if(chkUserPlanFeaturePermission($user_id,'4'))
{
	$my_activity_calories_chart = 1;
}
else
{
	$my_activity_calories_chart = 0;
}

$return = false;



$error = false;

$tr_err_date = 'none';

$err_date = '';



if(isset($_POST['btnSubmit']))	

{

	$start_date = strip_tags(trim($_POST['start_date']));
	$end_date = strip_tags(trim($_POST['end_date']));

	if($start_date == '')
	{
		$error = true;
		$tr_err_date = '';
		$err_date = 'Please select start date';
	}
		
	if($end_date == '')
	{
		$error = true;
		if($tr_err_date == 'none')
		{
			$tr_err_date = '';
			$err_date = 'Please select end date';
		}
		else
		{
			$err_date .= '<br>Please select end date';
		}	
	}

	

	if(!$error)

	{
		$start_date = date('Y-m-d',strtotime($start_date));
		$end_date = date('Y-m-d',strtotime($end_date));
		list($return,$arr_date,$arr_calorie_intake,$total_calorie_intake,$arr_calorie_burned,$total_calorie_burned,$avg_workout,$arr_estimated_calorie_required,$total_estimated_calorie_required,$arr_record_row,$arr_activity_id,$total_activity_entry,$total_meal_entry) = getMyActivityCaloriesChart($user_id,$start_date,$end_date);

		if(!$return)

		{

			$error = true;

			$tr_err_date = '';

			$err_date = 'No records found in given date range!';	

		}

		$start_date = date('d-m-Y',strtotime($start_date));
		$end_date = date('d-m-Y',strtotime($end_date));

	}

}

elseif(isset($_POST['btnPdfReport']))	

{

	$start_date = strip_tags(trim($_POST['hdnstart_date']));
	$end_date = strip_tags(trim($_POST['hdnend_date']));

	if($start_date == '')
	{
		$error = true;
		$tr_err_date = '';
		$err_date = 'Please select start date';
	}
	
	
	if($end_date == '')
	{
		$error = true;
		if($tr_err_date == 'none')
		{
			$tr_err_date = '';
			$err_date = 'Please select end date';
		}
		else
		{
			$err_date .= '<br>Please select end date';
		}	
	}
	

	

	if(!$error)

	{
		$start_date = date('Y-m-d',strtotime($start_date));
		$end_date = date('Y-m-d',strtotime($end_date));
		$output = getMyActivityCaloriesChartHTML($user_id,$start_date,$end_date);	

		$filename = 'my_activity_calories_chart_'.time();

		require_once('class.htmltopsmaker.php');

		convert_to_pdf($filename,$output);

		list($return,$arr_date,$arr_calorie_intake,$total_calorie_intake,$arr_calorie_burned,$total_calorie_burned,$avg_workout,$arr_estimated_calorie_required,$total_estimated_calorie_required,$arr_record_row,$arr_activity_id,$total_activity_entry,$total_meal_entry) = getMyActivityCaloriesChart($user_id,$start_date,$end_date);

		if(!$return)

		{

			$error = true;

			$tr_err_date = '';

			$err_date = 'No records found in given date range!';	

		}

		$start_date = date('d-m-Y',strtotime($start_date));
		$end_date = date('d-m-Y',strtotime($end_date));

	}

}

else

{

	$now = time();

	$end_date = date('d-m-Y');

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

		$(document).ready(function(){

		$(".QTPopup").css('display','none')

			$('#js-news').ticker({
				controls: true,        // Whether or not to show the jQuery News Ticker controls
				 htmlFeed: true, 
				titleText: '',   // To remove the title set this to an empty String
				displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'
				direction: 'ltr'       // Ticker direction - current options are 'ltr' or 'rtl'
				
			});

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

											if($my_activity_calories_chart == 1) 

											{ ?>	

                                                <form action="#" id="frmactivity" method="post" name="frmactivity">

												<table width="920" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td width="80" height="45" align="left" valign="middle" class="Header_brown">Start Date:</td>

														<td width="240" align="left" valign="middle">

															<input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:100px;" />
                                    						<script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>

													  </td>

														<td width="80" height="45" align="left" valign="middle" class="Header_brown">End Date:</td>

														<td width="240" align="left" valign="middle">

															<input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:100px;" />
                                    						<script>$('#end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>

												  	  </td>

													  	<td width="260" height="45" align="left" valign="middle"><input type="submit" name="btnSubmit" id="btnSubmit" value="View Report" /></td>

													</tr>

													<tr id="tr_err_date" style="display:<?php echo $tr_err_date;?>;" valign="top">

														<td align="left" colspan="5" class="err_msg" id="err_date" valign="top"><?php echo $err_date;?></td>

													</tr>

												</table>

												</form>

												<?php

												if( ($return) && ( count($arr_date) > 0 ) )

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

												<table width="920" border="0" cellpadding="1" cellspacing="1" bgcolor="#999999">

                                                    <tr>

                                                        <td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#0000FF;">SNo</td>

                                                        <td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#0000FF;">Date/day</td>

                                                    <?php

                                                    for($i=0;$i<count($arr_activity_id);$i++)

                                                    { ?>

                                                        <td height="50" align="left" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#0000FF;"><?php echo getDailyActivityName($arr_activity_id[$i]);?></td>

                                                    <?php

                                                    }?>

                                                        <td height="50" align="left" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#0000FF;">Total Calories Burnt</td>

                                                        <td height="50" align="left" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#0000FF;">Total Calories Intake</td>

                                                        <td height="50" align="left" valign="middle" bgcolor="#FFFFFF" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#0000FF;">Estimated Calorie Required</td>

                                                    </tr>

                                                    <?php

                                                    for($i=0,$k=1;$i<count($arr_date);$i++,$k++)

                                                    { ?>

                                                    <tr>

                                                        <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#0000FF;"><?php echo $k;?></td>

                                                        <td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#0000FF;"><?php echo date("d M Y",strtotime($arr_date[$i]));?><br />(<?php echo date("l",strtotime($arr_date[$i]));?>)</td>

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

                                                        <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="FONT-SIZE: 11px; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: normal; color:#0000FF;">Total</td>

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

                                                 <table width="920" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td align="left">

                                                            <form action="#" method="post" name="frmpdfreports" id="frmpdfreports">

                                                                <input type="hidden" name="hdnuser_id" id="hdnhdnuser_id" value="<?php echo $user_id;?>" />

                                                                <input type="hidden" name="hdnstart_date" id="hdnstart_date" value="<?php echo $start_date;?>" />
                                                               	<input type="hidden" name="hdnend_date" id="hdnend_date" value="<?php echo $end_date;?>" />

                                                                <input type="submit" name="btnPdfReport" id="btnPdfReport" value="Save to Pdf" />

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

												} ?>

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

						<table width="540" border="0" cellspacing="0" cellpadding="0">

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