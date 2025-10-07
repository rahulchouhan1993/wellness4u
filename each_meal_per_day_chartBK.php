<?php
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };
@set_time_limit(1000000);
include('config.php');
$page_id = '55';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('each_meal_per_day_chart.php');

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

if(chkUserPlanFeaturePermission($user_id,'3'))
{
	$each_meal_per_day_chart = 1;
}
else
{
	$each_meal_per_day_chart = 0;
}

$return = false;
$error = false;
$tr_err_date = 'none';
$err_date = '';
$show_pdf_button = false;

$show_datedropdown = 'none';

if(isset($_POST['btnSubmit']))	
{
	$start_date = strip_tags(trim($_POST['start_date']));
	$end_date = strip_tags(trim($_POST['end_date']));
	$date = strip_tags(trim($_POST['date']));
	
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
		$show_datedropdown = '';
		
		if($date == '')
		{
			$error = true;
			$tr_err_date = '';
			$err_date = 'Please select record date';
		}
		
		if(!$error)
		{
			$show_pdf_button = true;
			list($return,$arr_meal_time,$arr_meal_item,$arr_meal_measure,$arr_meal_ml,$arr_weight,$arr_water,$arr_calories,$arr_protein,$arr_total_fat , $arr_saturated , $arr_monounsaturated , $arr_polyunsaturated , $arr_cholesterol , $arr_carbohydrate ,$arr_total_dietary_fiber , $arr_calcium , $arr_iron , $arr_potassium , $arr_sodium , $arr_thiamin , $arr_riboflavin , $arr_niacin ,$arr_pantothenic_acid , $arr_pyridoxine_hcl, $arr_cyanocobalamin, $arr_ascorbic_acid , $arr_calciferol, $arr_tocopherol ,$arr_phylloquinone, $arr_sugar , $arr_polyunsaturated_linoleic , $arr_polyunsaturated_alphalinoleic , $arr_total_monosaccharide ,$arr_glucose , $arr_fructose , $arr_galactose , $arr_disaccharide , $arr_maltose , $arr_lactose , $arr_sucrose , $arr_total_polysaccharide ,$arr_starch , $arr_cellulose , $arr_glycogen , $arr_dextrins , $arr_total_vitamin , $arr_vitamin_a_acetate, $arr_vitamin_a_retinol,$arr_total_vitamin_b_complex, $arr_folic_acid , $arr_biotin , $arr_alanine , $arr_arginine , $arr_aspartic_acid , $arr_cystine , $arr_giutamic_acid ,$arr_glycine , $arr_histidine , $arr_hydroxy_glutamic_acid , $arr_hydroxy_proline , $arr_iodogorgoic_acid , $arr_isoleucine , $arr_leucine ,$arr_lysine , $arr_methionine , $arr_norleucine , $arr_phenylalanine , $arr_proline , $arr_serine , $arr_threonine , $arr_thyroxine , $arr_tryptophane ,$arr_tyrosine , $arr_valine , $arr_total_minerals , $arr_phosphorus , $arr_sulphur , $arr_chlorine , $arr_iodine , $arr_magnesium , $arr_zinc ,$arr_copper , $arr_chromium , $arr_manganese , $arr_selenium , $arr_boron , $arr_molybdenum , $arr_caffeine) = getEachMealPerDayChart($user_id,$date);
	
			if(!$return)
			{
				$error = true;
				$tr_err_date = '';
				$err_date = 'No records found for selected date!';	
			}
		}
	}
}
elseif(isset($_POST['btnPdfReport']))
{
	$start_date = strip_tags(trim($_POST['hdnstart_date']));
	$end_date = strip_tags(trim($_POST['hdnend_date']));
	$date = strip_tags(trim($_POST['hdndate']));
	
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
		$show_datedropdown = '';
		$output = getEachMealPerDayChartHTML($user_id,$date);
		$filename ="each_meal_per_day_chart_".time().".xls";
		convert_to_excel($filename,$output);
		exit(0);
		list($return,$arr_meal_time, $arr_meal_item, $arr_meal_measure, $arr_meal_ml, $arr_weight, $arr_water , $arr_calories , $arr_protein ,$arr_total_fat , $arr_saturated , $arr_monounsaturated , $arr_polyunsaturated , $arr_cholesterol , $arr_carbohydrate ,$arr_total_dietary_fiber , $arr_calcium , $arr_iron , $arr_potassium , $arr_sodium , $arr_thiamin , $arr_riboflavin , $arr_niacin ,$arr_pantothenic_acid , $arr_pyridoxine_hcl, $arr_cyanocobalamin, $arr_ascorbic_acid , $arr_calciferol, $arr_tocopherol ,$arr_phylloquinone, $arr_sugar , $arr_polyunsaturated_linoleic , $arr_polyunsaturated_alphalinoleic , $arr_total_monosaccharide ,$arr_glucose , $arr_fructose , $arr_galactose , $arr_disaccharide , $arr_maltose , $arr_lactose , $arr_sucrose , $arr_total_polysaccharide ,$arr_starch , $arr_cellulose , $arr_glycogen , $arr_dextrins , $arr_total_vitamin , $arr_vitamin_a_acetate, $arr_vitamin_a_retinol,$arr_total_vitamin_b_complex, $arr_folic_acid , $arr_biotin , $arr_alanine , $arr_arginine , $arr_aspartic_acid , $arr_cystine , $arr_giutamic_acid ,$arr_glycine , $arr_histidine , $arr_hydroxy_glutamic_acid , $arr_hydroxy_proline , $arr_iodogorgoic_acid , $arr_isoleucine , $arr_leucine ,$arr_lysine , $arr_methionine , $arr_norleucine , $arr_phenylalanine , $arr_proline , $arr_serine , $arr_threonine , $arr_thyroxine ,$arr_tryptophane ,$arr_tyrosine , $arr_valine , $arr_total_minerals , $arr_phosphorus , $arr_sulphur , $arr_chlorine , $arr_iodine ,$arr_magnesium , $arr_zinc ,$arr_copper , $arr_chromium , $arr_manganese , $arr_selenium , $arr_boron , $arr_molybdenum , $arr_caffeine,$arr_date,$total_meal_entry) = getEachMealPerDayChart($user_id,$date);

		if(!$return)
		{
			$error = true;
			$tr_err_date = '';
			$err_date = 'No records found for selected date!';	
		}
	}
}
else
{
	$now = time();
	$year = date("Y",$now);
	$month = date("m",$now);
	$day = date("j",$now); 
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                                        if($each_meal_per_day_chart == 1) 
                                        { ?>
												<form action="#" id="frmreport" method="post" name="frmreport">
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
														<td width="260" height="45" align="left" valign="middle"><input type="submit" name="btnSubmit" id="btnSubmit" value="View Date List" /></td>
													</tr>
													
												</table>
                                                <table width="920" border="0" cellspacing="0" cellpadding="0" style="display:<?php echo $show_datedropdown;?>">
													<tr>
														<td width="40" height="45" align="left" valign="middle" class="Header_brown">Date:</td>
														<td width="220" align="left" valign="middle">
															<select name="date" id="date" style="width:200px;">
																<option value="">Select Date</option>
																<?php echo getEachMealPerDayDateListOptions($user_id,$start_date,$end_date,$date); ?>
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
												</form>
											<?php
                                            if( ($return)  )
                                            { 
                                                if( is_array($arr_meal_time['breakfast']) && count($arr_meal_time['breakfast']) > 0)
                                                { ?>
												<table width="920" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td>&nbsp;</td>
														<td>&nbsp;</td>
													</tr>
												</table>
												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">
													<tr>
														<td width="864" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Breakfast</strong></td>
														<td width="54" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
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
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Water(%)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calories</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Total fat(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Saturated(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Monounsaturated(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Poly-unsaturated</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
	                                                            <tr>
    		                                                        <td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated - Linoleic</td>
            	                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated   alpha-Linoleic</td>
	                                                            </tr>
                                                            </table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cholesterol(mg)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total dietary fiber(g)</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Carbohydrate</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glucose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Fructose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Galactose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Disaccharide</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Maltose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lactose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sucrose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Polysaccharide</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Starch</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cellulose</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycogen</td>
                                                                </tr>
                                                            </table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Dextrins</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sugar</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamins</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (As Acetate)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (Retinol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamin B Complex</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B1 (Thiamin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B2 (Riboflavin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />&nbsp;/Nicotonic Acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B5 (Pantothenic Acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B6 (Pyridoxine HCL)</td
																></tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B12 (Cyanocobalamin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Folic Acid (or Folate)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Biotin</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin C (Ascorbic acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin D (Calciferol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin E (Tocopherol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin K (Phylloquinone)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Protein / Amino Acids</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Alanine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Arginine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Aspartic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cystine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Giutamic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Histidine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy-glutamic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy proline</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodogorgoic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Isoleucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Leucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lysine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Methionine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Norleucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phenylalanine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Proline</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Serine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Threonine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Thyroxine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tryptophane</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tyrosine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Valine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Minerals</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calcium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iron</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Potassium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sodium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phosphorus</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sulphur</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chlorine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Magnesium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Zinc</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Copper</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chromium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Manganese</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Selenium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Boron</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Molybdenum</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Caffeine</td>
																</tr>
															</table>
														</td>
														<td colspan="10" align="left" valign="top">
															<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_time['breakfast'][$j] != '' )
																	{
																		echo $i;
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_time['breakfast'][$j] != '' )
																	{
																		echo $arr_meal_time['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp; </td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_item['breakfast'][$j] != '' )
																	{
																		echo $arr_meal_item['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_measure['breakfast'][$j] != '' )
																	{
																		echo $arr_meal_measure['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_ml['breakfast'][$j] != '' )
																	{
																		echo $arr_meal_ml['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_weight['breakfast'][$j] != '' )
																	{
																		echo $arr_weight['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																$water = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_water['breakfast'][$j] != '' )
																	{
																		echo $arr_water['breakfast'][$j];
																		$water+=$arr_water['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($water > 0)
																		echo $water;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$calories = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_calories['breakfast'][$j] != '' )
																	{
																		echo $arr_calories['breakfast'][$j];
																		$calories+=$arr_calories['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($calories > 0)
																		echo $calories;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$fat = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_fat['breakfast'][$j] != '' )
																	{
																		echo $arr_total_fat['breakfast'][$j];
																		$fat+=$arr_total_fat['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($fat > 0)
																		echo $fat;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$saturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_saturated['breakfast'][$j] != '' )
																	{
																		echo $arr_saturated['breakfast'][$j];
																		$saturated+=$arr_saturated['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($saturated > 0)
																		echo $saturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$monounsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_monounsaturated['breakfast'][$j] != '' )
																	{
																		echo $arr_monounsaturated['breakfast'][$j];
																		$monounsaturated+=$arr_monounsaturated['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($monounsaturated > 0)
																		echo $monounsaturated;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$polyunsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php
																	if($arr_polyunsaturated['breakfast'][$j] != '' )
																	{
																		echo $arr_polyunsaturated['breakfast'][$j];
																		$polyunsaturated+=$arr_polyunsaturated['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($polyunsaturated > 0)
																		echo $polyunsaturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$polyunsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_polyunsaturated_linoleic['breakfast'][$j] != '' )
																	{
																		echo $arr_polyunsaturated_linoleic['breakfast'][$j];
																		$polyunsaturated+=$arr_polyunsaturated_linoleic['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($polyunsaturated > 0)
																		echo $polyunsaturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$alphalinoleic = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_polyunsaturated_alphalinoleic['breakfast'][$j] != '' )
																	{
																		echo $arr_polyunsaturated_alphalinoleic['breakfast'][$j];
																		$alphalinoleic+=$arr_polyunsaturated_alphalinoleic['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($alphalinoleic > 0)
																		echo $alphalinoleic;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$cholesterol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_cholesterol['breakfast'][$j] != '' )
																	{
																		echo $arr_cholesterol['breakfast'][$j];
																		$cholesterol+=$arr_cholesterol['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cholesterol > 0)
																		echo $cholesterol;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$dietary_fiber = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_dietary_fiber['breakfast'][$j] != '' )
																	{
																		echo $arr_total_dietary_fiber['breakfast'][$j];
																		$dietary_fiber+=$arr_total_dietary_fiber['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($dietary_fiber > 0)
																		echo $dietary_fiber;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$carbohydrate = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_carbohydrate['breakfast'][$j] != '' )
																	{
																		echo $arr_carbohydrate['breakfast'][$j];
																		$carbohydrate+=$arr_carbohydrate['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($carbohydrate > 0)
																		echo $carbohydrate;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glucose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_glucose['breakfast'][$j] != '' )
																	{
																		echo $arr_glucose['breakfast'][$j];
																		$glucose+=$arr_glucose['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glucose > 0)
																		echo $glucose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$fructose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_fructose['breakfast'][$j] != '' )
																	{
																		echo $arr_fructose['breakfast'][$j];
																		$fructose+=$arr_fructose['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($fructose > 0)
																		echo $fructose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$galactose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_galactose['breakfast'][$j] != '' )
																	{
																		echo $arr_galactose['breakfast'][$j];
																		$galactose+=$arr_galactose['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($galactose > 0)
																		echo $galactose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$disaccharide = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_disaccharide['breakfast'][$j] != '' )
																	{
																		echo $arr_disaccharide['breakfast'][$j];
																		$disaccharide+=$arr_disaccharide['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($disaccharide > 0)
																		echo $disaccharide;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$maltose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_maltose['breakfast'][$j] != '' )
																	{
																		echo $arr_maltose['breakfast'][$j];
																		$maltose+=$arr_maltose['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($maltose > 0)
																		echo $maltose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$lactose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_lactose['breakfast'][$j] != '' )
																	{
																		echo $arr_lactose['breakfast'][$j];
																		$lactose+=$arr_lactose['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($lactose > 0)
																		echo $lactose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sucrose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_sucrose['breakfast'][$j] != '' )
																	{
																		echo $arr_sucrose['breakfast'][$j];
																		$sucrose+=$arr_sucrose['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sucrose > 0)
																		echo $sucrose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$polysaccharide = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_polysaccharide['breakfast'][$j] != '' )
																	{
																		echo $arr_total_polysaccharide['breakfast'][$j];
																		$polysaccharide+=$arr_total_polysaccharide['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($polysaccharide > 0)
																		echo $polysaccharide;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$starch = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_starch['breakfast'][$j] != '' )
																	{
																		echo $arr_starch['breakfast'][$j];
																		$starch+=$arr_starch['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($starch > 0)
																		echo $starch;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cellulose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cellulose['breakfast'][$j] != '' )
																	{
																		echo $arr_cellulose['breakfast'][$j];
																		$cellulose+=$arr_cellulose['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cellulose > 0)
																		echo $cellulose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glycogen = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_glycogen['breakfast'][$j] != '' )
																	{
																		echo $arr_glycogen['breakfast'][$j];
																		$glycogen+=$arr_glycogen['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glycogen > 0)
																		echo $glycogen;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$dextrins = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_dextrins['breakfast'][$j] != '' )
																	{
																		echo $arr_dextrins['breakfast'][$j];
																		$dextrins+=$arr_dextrins['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($dextrins > 0)
																		echo $dextrins;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sugar = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sugar['breakfast'][$j] != '' )
																	{
																		echo $arr_sugar['breakfast'][$j];
																		$sugar+=$arr_sugar['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sugar > 0)
																		echo $sugar;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_vitamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_vitamin['breakfast'][$j] != '' )
																	{
																		echo $arr_total_vitamin['breakfast'][$j];
																		$total_vitamin+=$arr_total_vitamin['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_vitamin > 0)
																		echo $total_vitamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$vitamin_a_acetate = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_vitamin_a_acetate['breakfast'][$j] != '' )
																	{
																		echo $arr_vitamin_a_acetate['breakfast'][$j];
																		$vitamin_a_acetate+=$arr_vitamin_a_acetate['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($vitamin_a_acetate > 0)
																		echo $vitamin_a_acetate;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$vitamin_a_retinol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_vitamin_a_retinol['breakfast'][$j] != '' )
																	{
																		echo $arr_vitamin_a_retinol['breakfast'][$j];
																		$vitamin_a_retinol+=$arr_vitamin_a_retinol['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($vitamin_a_retinol > 0)
																		echo $vitamin_a_retinol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_vitamin_b_complex = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_vitamin_b_complex['breakfast'][$j] != '' )
																	{
																		echo $arr_total_vitamin_b_complex['breakfast'][$j];
																		$total_vitamin_b_complex+=$arr_total_vitamin_b_complex['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_vitamin_b_complex > 0)
																		echo $total_vitamin_b_complex;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$thiamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_thiamin['breakfast'][$j] != '' )
																	{
																		echo $arr_thiamin['breakfast'][$j];
																		$thiamin+=$arr_thiamin['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($thiamin > 0)
																		echo $thiamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$riboflavin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_riboflavin['breakfast'][$j] != '' )
																	{
																		echo $arr_riboflavin['breakfast'][$j];
																		$riboflavin+=$arr_riboflavin['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($riboflavin > 0)
																		echo $riboflavin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr height="50px">
																<?php
																$niacin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td height="52" align="center" valign="middle" bgcolor="#FFFFFF"><?php
																	if($arr_niacin['breakfast'][$j] != '' )
																	{
																		echo $arr_niacin['breakfast'][$j];
																		$niacin+=$$arr_niacin['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($niacin > 0)
																		echo $niacin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$pantothenic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_pantothenic_acid['breakfast'][$j] != '' )
																	{
																		echo $arr_pantothenic_acid['breakfast'][$j];
																		$pantothenic_acid+=$arr_pantothenic_acid['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($pantothenic_acid > 0)
																		echo $pantothenic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$pyridoxine_hcl = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_pyridoxine_hcl['breakfast'][$j] != '' )
																	{
																		echo $arr_pyridoxine_hcl['breakfast'][$j];
																		$pyridoxine_hcl+=$arr_pyridoxine_hcl['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($pyridoxine_hcl > 0)
																		echo $pyridoxine_hcl;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cyanocobalamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cyanocobalamin['breakfast'][$j] != '' )
																	{
																		echo $arr_cyanocobalamin['breakfast'][$j];
																		$cyanocobalamin+=$arr_cyanocobalamin['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cyanocobalamin > 0)
																		echo $cyanocobalamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$folic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_folic_acid['breakfast'][$j] != '' )
																	{
																		echo $arr_folic_acid['breakfast'][$j];
																		$folic_acid+=$arr_folic_acid['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($folic_acid > 0)
																		echo $folic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$biotin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_biotin['breakfast'][$j] != '' )
																	{
																		echo $arr_biotin['breakfast'][$j];
																		$biotin+=$arr_biotin['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($biotin > 0)
																		echo $biotin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$ascorbic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_ascorbic_acid['breakfast'][$j] != '' )
																	{
																		echo $arr_ascorbic_acid['breakfast'][$j];
																		$ascorbic_acid+=$arr_ascorbic_acid['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($ascorbic_acid > 0)
																		echo $ascorbic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$calciferol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_calciferol['breakfast'][$j] != '' )
																	{
																		echo $arr_calciferol['breakfast'][$j];
																		$calciferol+=$arr_calciferol['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($calciferol > 0)
																		echo $calciferol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tocopherol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tocopherol['breakfast'][$j] != '' )
																	{
																		echo $arr_tocopherol['breakfast'][$j];
																		$tocopherol+=$arr_tocopherol['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tocopherol > 0)
																		echo $tocopherol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phylloquinone = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phylloquinone['breakfast'][$j] != '' )
																	{
																		echo $arr_phylloquinone['breakfast'][$j];
																		$phylloquinone+=$arr_phylloquinone['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phylloquinone > 0)
																		echo $phylloquinone;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$protein = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_protein['breakfast'][$j] != '' )
																	{
																		echo $arr_protein['breakfast'][$j];
																		$protein+=$arr_protein['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($protein > 0)
																		echo $protein;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$alanine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_alanine['breakfast'][$j] != '' )
																	{
																		echo $arr_alanine['breakfast'][$j];
																		$alanine+=$arr_alanine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($alanine > 0)
																		echo $alanine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$arginine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_arginine['breakfast'][$j] != '' )
																	{
																		echo $arr_arginine['breakfast'][$j];
																		$arginine+=$arr_arginine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($arginine > 0)
																		echo $arginine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$aspartic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_aspartic_acid['breakfast'][$j] != '' )
																	{
																		echo $arr_aspartic_acid['breakfast'][$j];
																		$aspartic_acid+=$arr_aspartic_acid['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($aspartic_acid > 0)
																		echo $aspartic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cystine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cystine['breakfast'][$j] != '' )
																	{
																		echo $arr_cystine['breakfast'][$j];
																		$cystine+=$arr_cystine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cystine > 0)
																		echo $cystine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$giutamic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_giutamic_acid['breakfast'][$j] != '' )
																	{
																		echo $arr_giutamic_acid['breakfast'][$j];
																		$giutamic_acid+=$arr_giutamic_acid['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($giutamic_acid > 0)
																		echo $giutamic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glycine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_glycine['breakfast'][$j] != '' )
																	{
																		echo $arr_glycine['breakfast'][$j];
																		$glycine+=$arr_glycine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glycine > 0)
																		echo $glycine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$histidine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_histidine['breakfast'][$j] != '' )
																	{
																		echo $arr_histidine['breakfast'][$j];
																		$histidine+=$arr_histidine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($histidine > 0)
																		echo $histidine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glutamic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_hydroxy_glutamic_acid['breakfast'][$j] != '' )
																	{
																		echo $arr_hydroxy_glutamic_acid['breakfast'][$j];
																		$glutamic_acid+=$arr_hydroxy_glutamic_acid['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glutamic_acid > 0)
																		echo $glutamic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$hydroxy_proline = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_hydroxy_proline['breakfast'][$j] != '' )
																	{
																		echo $arr_hydroxy_proline['breakfast'][$j];
																		$hydroxy_proline+=$arr_hydroxy_proline['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($hydroxy_proline > 0)
																		echo $hydroxy_proline;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iodogorgoic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iodogorgoic_acid['breakfast'][$j] != '' )
																	{
																		echo $arr_iodogorgoic_acid['breakfast'][$j];
																		$iodogorgoic_acid+=$arr_iodogorgoic_acid['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iodogorgoic_acid > 0)
																		echo $iodogorgoic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$isoleucine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_isoleucine['breakfast'][$j] != '' )
																	{
																		echo $arr_isoleucine['breakfast'][$j];
																		$isoleucine+=$arr_isoleucine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($isoleucine > 0)
																		echo $isoleucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$leucine= 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_leucine['breakfast'][$j] != '' )
																	{
																		echo $arr_leucine['breakfast'][$j];
																		$leucine+=$arr_leucine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($leucine > 0)
																		echo $leucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$lysine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_lysine['breakfast'][$j] != '' )
																	{
																		echo $arr_lysine['breakfast'][$j];
																		$lysine+=$arr_lysine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($lysine > 0)
																		echo $lysine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$methionine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_methionine['breakfast'][$j] != '' )
																	{
																		echo $arr_methionine['breakfast'][$j];
																		$methionine+=$arr_methionine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($methionine > 0)
																		echo $methionine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$norleucine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_norleucine['breakfast'][$j] != '' )
																	{
																		echo $arr_norleucine['breakfast'][$j];
																		$norleucine+=$arr_norleucine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($norleucine > 0)
																		echo $norleucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phenylalanine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phenylalanine['breakfast'][$j] != '' )
																	{
																		echo $arr_phenylalanine['breakfast'][$j];
																		$phenylalanine+=$arr_phenylalanine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phenylalanine > 0)
																		echo $phenylalanine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$proline = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_proline['breakfast'][$j] != '' )
																	{
																		echo $arr_proline['breakfast'][$j];
																		$proline+=$arr_proline['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($proline > 0)
																		echo $proline;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$serine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_serine['breakfast'][$j] != '' )
																	{
																		echo $arr_serine['breakfast'][$j];
																		$serine+=$arr_serine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($serine > 0)
																		echo $serine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$threonine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_threonine['breakfast'][$j] != '' )
																	{
																		echo $arr_threonine['breakfast'][$j];
																		$threonine+=$arr_threonine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($threonine > 0)
																		echo $threonine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$thyroxine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_thyroxine['breakfast'][$j] != '' )
																	{
																		echo $arr_thyroxine['breakfast'][$j];
																		$thyroxine+=$arr_thyroxine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($thyroxine > 0)
																		echo $thyroxine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tryptophane = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tryptophane['breakfast'][$j] != '' )
																	{
																		echo $arr_tryptophane['breakfast'][$j];
																		$tryptophane+=$arr_tryptophane['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tryptophane > 0)
																		echo $tryptophane;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tyrosine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tyrosine['breakfast'][$j] != '' )
																	{
																		echo $arr_tyrosine['breakfast'][$j];
																		$tyrosine+=$arr_tyrosine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tyrosine > 0)
																		echo $tyrosine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$valine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_valine['breakfast'][$j] != '' )
																	{
																		echo $arr_valine['breakfast'][$j];
																		$valine+=$arr_valine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($valine > 0)
																		echo $valine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_minerals = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_minerals['breakfast'][$j] != '' )
																	{
																		echo $arr_total_minerals['breakfast'][$j];
																		$total_minerals+=$arr_total_minerals['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_minerals > 0)
																		echo $total_minerals;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$calcium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_calcium['breakfast'][$j] != '' )
																	{
																		echo $arr_calcium['breakfast'][$j];
																		$calcium+=$arr_calcium['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($calcium > 0)
																		echo $calcium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iron = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iron['breakfast'][$j] != '' )
																	{
																		echo $arr_iron['breakfast'][$j];
																		$iron+=$arr_iron['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iron > 0)
																		echo $iron;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$potassium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_potassium['breakfast'][$j] != '' )
																	{
																		echo $arr_potassium['breakfast'][$j];
																		$potassium+=$arr_potassium['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($potassium > 0)
																		echo $potassium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sodium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sodium['breakfast'][$j] != '' )
																	{
																		echo $arr_sodium['breakfast'][$j];
																		$sodium+=$arr_sodium['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sodium > 0)
																		echo $sodium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phosphorus = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phosphorus['breakfast'][$j] != '' )
																	{
																		echo $arr_phosphorus['breakfast'][$j];
																		$phosphorus+=$arr_phosphorus['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phosphorus > 0)
																		echo $phosphorus;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sulphur = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sulphur['breakfast'][$j] != '' )
																	{
																		echo $arr_sulphur['breakfast'][$j];
																		$sulphur+=$arr_sulphur['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sulphur > 0)
																		echo $sulphur;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$chlorine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_chlorine['breakfast'][$j] != '' )
																	{
																		echo $arr_chlorine['breakfast'][$j];
																		$chlorine+=$arr_chlorine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($chlorine > 0)
																		echo $chlorine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iodine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iodine['breakfast'][$j] != '' )
																	{
																		echo $arr_iodine['breakfast'][$j];
																		$iodine+=$arr_iodine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iodine > 0)
																		echo $iodine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$magnesium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_magnesium['breakfast'][$j] != '' )
																	{
																		echo $arr_magnesium['breakfast'][$j];
																		$magnesium+=$arr_magnesium['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($magnesium > 0)
																		echo $magnesium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$zinc = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_zinc['breakfast'][$j] != '' )
																	{
																		echo $arr_zinc['breakfast'][$j];
																		$zinc+=$arr_zinc['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($zinc > 0)
																		echo $zinc;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$copper = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_copper['breakfast'][$j] != '' )
																	{
																		echo $arr_copper['breakfast'][$j];
																		$copper+=$arr_copper['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($copper > 0)
																		echo $copper;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$chromium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_chromium['breakfast'][$j] != '' )
																	{
																		echo $arr_chromium['breakfast'][$j];
																		$chromium+=$arr_chromium['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($chromium > 0)
																		echo $chromium;
																	else
																		echo '&nbsp;';
																	?></td>
                                                                </tr>
                                                                <tr>
																<?php
																$manganese = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_manganese['breakfast'][$j] != '' )
																	{
																		echo $arr_manganese['breakfast'][$j];
																		$manganese+=$arr_manganese['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($manganese > 0)
																		echo $manganese;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$selenium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_selenium['breakfast'][$j] != '' )
																	{
																		echo $arr_selenium['breakfast'][$j];
																		$selenium+=$arr_selenium['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($selenium > 0)
																		echo $selenium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$boron = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_boron['breakfast'][$j] != '' )
																	{
																		echo $arr_boron['breakfast'][$j];
																		$boron+=$arr_boron['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($boron > 0)
																		echo $boron;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$molybdenum = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_molybdenum['breakfast'][$j] != '' )
																	{
																		echo $arr_molybdenum['breakfast'][$j];
																		$molybdenum+=$arr_molybdenum['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($molybdenum > 0)
																		echo $molybdenum;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$caffeine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['breakfast']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_caffeine['breakfast'][$j] != '' )
																	{
																		echo $arr_caffeine['breakfast'][$j];
																		$caffeine+=$arr_caffeine['breakfast'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($caffeine > 0)
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
                                                } ?>
                                                
                                                <?php
                                                if( is_array($arr_meal_time['brunch']) && count($arr_meal_time['brunch']) > 0)
                                                { ?>
												<table width="920" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td>&nbsp;</td>
														<td>&nbsp;</td>
													</tr>
												</table>
												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">
													<tr>
														<td width="864" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Brunch</strong></td>
														<td width="54" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
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
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Water(%)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calories</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Total fat(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Saturated(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Monounsaturated(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Poly-unsaturated</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
	                                                            <tr>
    		                                                        <td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated - Linoleic</td>
            	                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated   alpha-Linoleic</td>
	                                                            </tr>
                                                            </table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cholesterol(mg)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total dietary fiber(g)</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Carbohydrate</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glucose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Fructose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Galactose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Disaccharide</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Maltose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lactose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sucrose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Polysaccharide</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Starch</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cellulose</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycogen</td>
                                                                </tr>
                                                            </table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Dextrins</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sugar</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamins</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (As Acetate)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (Retinol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamin B Complex</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B1 (Thiamin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B2 (Riboflavin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />&nbsp;/Nicotonic Acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B5 (Pantothenic Acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B6 (Pyridoxine HCL)</td
																></tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B12 (Cyanocobalamin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Folic Acid (or Folate)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Biotin</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin C (Ascorbic acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin D (Calciferol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin E (Tocopherol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin K (Phylloquinone)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Protein / Amino Acids</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Alanine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Arginine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Aspartic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cystine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Giutamic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Histidine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy-glutamic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy proline</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodogorgoic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Isoleucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Leucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lysine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Methionine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Norleucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phenylalanine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Proline</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Serine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Threonine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Thyroxine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tryptophane</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tyrosine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Valine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Minerals</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calcium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iron</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Potassium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sodium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phosphorus</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sulphur</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chlorine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Magnesium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Zinc</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Copper</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chromium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Manganese</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Selenium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Boron</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Molybdenum</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Caffeine</td>
																</tr>
															</table>
														</td>
														<td colspan="10" align="left" valign="top">
															<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_time['brunch'][$j] != '' )
																	{
																		echo $i;
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_time['brunch'][$j] != '' )
																	{
																		echo $arr_meal_time['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp; </td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_item['brunch'][$j] != '' )
																	{
																		echo $arr_meal_item['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_measure['brunch'][$j] != '' )
																	{
																		echo $arr_meal_measure['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_ml['brunch'][$j] != '' )
																	{
																		echo $arr_meal_ml['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_weight['brunch'][$j] != '' )
																	{
																		echo $arr_weight['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																$water = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_water['brunch'][$j] != '' )
																	{
																		echo $arr_water['brunch'][$j];
																		$water+=$arr_water['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($water > 0)
																		echo $water;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$calories = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_calories['brunch'][$j] != '' )
																	{
																		echo $arr_calories['brunch'][$j];
																		$calories+=$arr_calories['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($calories > 0)
																		echo $calories;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$fat = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_fat['brunch'][$j] != '' )
																	{
																		echo $arr_total_fat['brunch'][$j];
																		$fat+=$arr_total_fat['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($fat > 0)
																		echo $fat;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$saturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_saturated['brunch'][$j] != '' )
																	{
																		echo $arr_saturated['brunch'][$j];
																		$saturated+=$arr_saturated['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($saturated > 0)
																		echo $saturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$monounsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_monounsaturated['brunch'][$j] != '' )
																	{
																		echo $arr_monounsaturated['brunch'][$j];
																		$monounsaturated+=$arr_monounsaturated['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($monounsaturated > 0)
																		echo $monounsaturated;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$polyunsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php
																	if($arr_polyunsaturated['brunch'][$j] != '' )
																	{
																		echo $arr_polyunsaturated['brunch'][$j];
																		$polyunsaturated+=$arr_polyunsaturated['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($polyunsaturated > 0)
																		echo $polyunsaturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$polyunsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_polyunsaturated_linoleic['brunch'][$j] != '' )
																	{
																		echo $arr_polyunsaturated_linoleic['brunch'][$j];
																		$polyunsaturated+=$arr_polyunsaturated_linoleic['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($polyunsaturated > 0)
																		echo $polyunsaturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$alphalinoleic = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_polyunsaturated_alphalinoleic['brunch'][$j] != '' )
																	{
																		echo $arr_polyunsaturated_alphalinoleic['brunch'][$j];
																		$alphalinoleic+=$arr_polyunsaturated_alphalinoleic['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($alphalinoleic > 0)
																		echo $alphalinoleic;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$cholesterol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_cholesterol['brunch'][$j] != '' )
																	{
																		echo $arr_cholesterol['brunch'][$j];
																		$cholesterol+=$arr_cholesterol['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cholesterol > 0)
																		echo $cholesterol;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$dietary_fiber = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_dietary_fiber['brunch'][$j] != '' )
																	{
																		echo $arr_total_dietary_fiber['brunch'][$j];
																		$dietary_fiber+=$arr_total_dietary_fiber['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($dietary_fiber > 0)
																		echo $dietary_fiber;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$carbohydrate = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_carbohydrate['brunch'][$j] != '' )
																	{
																		echo $arr_carbohydrate['brunch'][$j];
																		$carbohydrate+=$arr_carbohydrate['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($carbohydrate > 0)
																		echo $carbohydrate;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glucose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_glucose['brunch'][$j] != '' )
																	{
																		echo $arr_glucose['brunch'][$j];
																		$glucose+=$arr_glucose['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glucose > 0)
																		echo $glucose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$fructose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_fructose['brunch'][$j] != '' )
																	{
																		echo $arr_fructose['brunch'][$j];
																		$fructose+=$arr_fructose['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($fructose > 0)
																		echo $fructose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$galactose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_galactose['brunch'][$j] != '' )
																	{
																		echo $arr_galactose['brunch'][$j];
																		$galactose+=$arr_galactose['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($galactose > 0)
																		echo $galactose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$disaccharide = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_disaccharide['brunch'][$j] != '' )
																	{
																		echo $arr_disaccharide['brunch'][$j];
																		$disaccharide+=$arr_disaccharide['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($disaccharide > 0)
																		echo $disaccharide;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$maltose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_maltose['brunch'][$j] != '' )
																	{
																		echo $arr_maltose['brunch'][$j];
																		$maltose+=$arr_maltose['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($maltose > 0)
																		echo $maltose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$lactose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_lactose['brunch'][$j] != '' )
																	{
																		echo $arr_lactose['brunch'][$j];
																		$lactose+=$arr_lactose['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($lactose > 0)
																		echo $lactose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sucrose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_sucrose['brunch'][$j] != '' )
																	{
																		echo $arr_sucrose['brunch'][$j];
																		$sucrose+=$arr_sucrose['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sucrose > 0)
																		echo $sucrose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$polysaccharide = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_polysaccharide['brunch'][$j] != '' )
																	{
																		echo $arr_total_polysaccharide['brunch'][$j];
																		$polysaccharide+=$arr_total_polysaccharide['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($polysaccharide > 0)
																		echo $polysaccharide;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$starch = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_starch['brunch'][$j] != '' )
																	{
																		echo $arr_starch['brunch'][$j];
																		$starch+=$arr_starch['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($starch > 0)
																		echo $starch;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cellulose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cellulose['brunch'][$j] != '' )
																	{
																		echo $arr_cellulose['brunch'][$j];
																		$cellulose+=$arr_cellulose['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cellulose > 0)
																		echo $cellulose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glycogen = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_glycogen['brunch'][$j] != '' )
																	{
																		echo $arr_glycogen['brunch'][$j];
																		$glycogen+=$arr_glycogen['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glycogen > 0)
																		echo $glycogen;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$dextrins = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_dextrins['brunch'][$j] != '' )
																	{
																		echo $arr_dextrins['brunch'][$j];
																		$dextrins+=$arr_dextrins['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($dextrins > 0)
																		echo $dextrins;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sugar = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sugar['brunch'][$j] != '' )
																	{
																		echo $arr_sugar['brunch'][$j];
																		$sugar+=$arr_sugar['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sugar > 0)
																		echo $sugar;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_vitamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_vitamin['brunch'][$j] != '' )
																	{
																		echo $arr_total_vitamin['brunch'][$j];
																		$total_vitamin+=$arr_total_vitamin['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_vitamin > 0)
																		echo $total_vitamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$vitamin_a_acetate = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_vitamin_a_acetate['brunch'][$j] != '' )
																	{
																		echo $arr_vitamin_a_acetate['brunch'][$j];
																		$vitamin_a_acetate+=$arr_vitamin_a_acetate['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($vitamin_a_acetate > 0)
																		echo $vitamin_a_acetate;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$vitamin_a_retinol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_vitamin_a_retinol['brunch'][$j] != '' )
																	{
																		echo $arr_vitamin_a_retinol['brunch'][$j];
																		$vitamin_a_retinol+=$arr_vitamin_a_retinol['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($vitamin_a_retinol > 0)
																		echo $vitamin_a_retinol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_vitamin_b_complex = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_vitamin_b_complex['brunch'][$j] != '' )
																	{
																		echo $arr_total_vitamin_b_complex['brunch'][$j];
																		$total_vitamin_b_complex+=$arr_total_vitamin_b_complex['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_vitamin_b_complex > 0)
																		echo $total_vitamin_b_complex;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$thiamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_thiamin['brunch'][$j] != '' )
																	{
																		echo $arr_thiamin['brunch'][$j];
																		$thiamin+=$arr_thiamin['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($thiamin > 0)
																		echo $thiamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$riboflavin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_riboflavin['brunch'][$j] != '' )
																	{
																		echo $arr_riboflavin['brunch'][$j];
																		$riboflavin+=$arr_riboflavin['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($riboflavin > 0)
																		echo $riboflavin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr height="50px">
																<?php
																$niacin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td height="52" align="center" valign="middle" bgcolor="#FFFFFF"><?php
																	if($arr_niacin['brunch'][$j] != '' )
																	{
																		echo $arr_niacin['brunch'][$j];
																		$niacin+=$$arr_niacin['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($niacin > 0)
																		echo $niacin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$pantothenic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_pantothenic_acid['brunch'][$j] != '' )
																	{
																		echo $arr_pantothenic_acid['brunch'][$j];
																		$pantothenic_acid+=$arr_pantothenic_acid['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($pantothenic_acid > 0)
																		echo $pantothenic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$pyridoxine_hcl = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_pyridoxine_hcl['brunch'][$j] != '' )
																	{
																		echo $arr_pyridoxine_hcl['brunch'][$j];
																		$pyridoxine_hcl+=$arr_pyridoxine_hcl['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($pyridoxine_hcl > 0)
																		echo $pyridoxine_hcl;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cyanocobalamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cyanocobalamin['brunch'][$j] != '' )
																	{
																		echo $arr_cyanocobalamin['brunch'][$j];
																		$cyanocobalamin+=$arr_cyanocobalamin['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cyanocobalamin > 0)
																		echo $cyanocobalamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$folic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_folic_acid['brunch'][$j] != '' )
																	{
																		echo $arr_folic_acid['brunch'][$j];
																		$folic_acid+=$arr_folic_acid['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($folic_acid > 0)
																		echo $folic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$biotin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_biotin['brunch'][$j] != '' )
																	{
																		echo $arr_biotin['brunch'][$j];
																		$biotin+=$arr_biotin['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($biotin > 0)
																		echo $biotin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$ascorbic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_ascorbic_acid['brunch'][$j] != '' )
																	{
																		echo $arr_ascorbic_acid['brunch'][$j];
																		$ascorbic_acid+=$arr_ascorbic_acid['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($ascorbic_acid > 0)
																		echo $ascorbic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$calciferol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_calciferol['brunch'][$j] != '' )
																	{
																		echo $arr_calciferol['brunch'][$j];
																		$calciferol+=$arr_calciferol['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($calciferol > 0)
																		echo $calciferol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tocopherol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tocopherol['brunch'][$j] != '' )
																	{
																		echo $arr_tocopherol['brunch'][$j];
																		$tocopherol+=$arr_tocopherol['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tocopherol > 0)
																		echo $tocopherol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phylloquinone = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phylloquinone['brunch'][$j] != '' )
																	{
																		echo $arr_phylloquinone['brunch'][$j];
																		$phylloquinone+=$arr_phylloquinone['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phylloquinone > 0)
																		echo $phylloquinone;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$protein = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_protein['brunch'][$j] != '' )
																	{
																		echo $arr_protein['brunch'][$j];
																		$protein+=$arr_protein['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($protein > 0)
																		echo $protein;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$alanine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_alanine['brunch'][$j] != '' )
																	{
																		echo $arr_alanine['brunch'][$j];
																		$alanine+=$arr_alanine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($alanine > 0)
																		echo $alanine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$arginine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_arginine['brunch'][$j] != '' )
																	{
																		echo $arr_arginine['brunch'][$j];
																		$arginine+=$arr_arginine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($arginine > 0)
																		echo $arginine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$aspartic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_aspartic_acid['brunch'][$j] != '' )
																	{
																		echo $arr_aspartic_acid['brunch'][$j];
																		$aspartic_acid+=$arr_aspartic_acid['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($aspartic_acid > 0)
																		echo $aspartic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cystine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cystine['brunch'][$j] != '' )
																	{
																		echo $arr_cystine['brunch'][$j];
																		$cystine+=$arr_cystine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cystine > 0)
																		echo $cystine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$giutamic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_giutamic_acid['brunch'][$j] != '' )
																	{
																		echo $arr_giutamic_acid['brunch'][$j];
																		$giutamic_acid+=$arr_giutamic_acid['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($giutamic_acid > 0)
																		echo $giutamic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glycine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_glycine['brunch'][$j] != '' )
																	{
																		echo $arr_glycine['brunch'][$j];
																		$glycine+=$arr_glycine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glycine > 0)
																		echo $glycine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$histidine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_histidine['brunch'][$j] != '' )
																	{
																		echo $arr_histidine['brunch'][$j];
																		$histidine+=$arr_histidine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($histidine > 0)
																		echo $histidine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glutamic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_hydroxy_glutamic_acid['brunch'][$j] != '' )
																	{
																		echo $arr_hydroxy_glutamic_acid['brunch'][$j];
																		$glutamic_acid+=$arr_hydroxy_glutamic_acid['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glutamic_acid > 0)
																		echo $glutamic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$hydroxy_proline = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_hydroxy_proline['brunch'][$j] != '' )
																	{
																		echo $arr_hydroxy_proline['brunch'][$j];
																		$hydroxy_proline+=$arr_hydroxy_proline['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($hydroxy_proline > 0)
																		echo $hydroxy_proline;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iodogorgoic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iodogorgoic_acid['brunch'][$j] != '' )
																	{
																		echo $arr_iodogorgoic_acid['brunch'][$j];
																		$iodogorgoic_acid+=$arr_iodogorgoic_acid['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iodogorgoic_acid > 0)
																		echo $iodogorgoic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$isoleucine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_isoleucine['brunch'][$j] != '' )
																	{
																		echo $arr_isoleucine['brunch'][$j];
																		$isoleucine+=$arr_isoleucine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($isoleucine > 0)
																		echo $isoleucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$leucine= 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_leucine['brunch'][$j] != '' )
																	{
																		echo $arr_leucine['brunch'][$j];
																		$leucine+=$arr_leucine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($leucine > 0)
																		echo $leucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$lysine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_lysine['brunch'][$j] != '' )
																	{
																		echo $arr_lysine['brunch'][$j];
																		$lysine+=$arr_lysine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($lysine > 0)
																		echo $lysine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$methionine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_methionine['brunch'][$j] != '' )
																	{
																		echo $arr_methionine['brunch'][$j];
																		$methionine+=$arr_methionine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;

                                                                    <?php 
																	if($methionine > 0)
																		echo $methionine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$norleucine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_norleucine['brunch'][$j] != '' )
																	{
																		echo $arr_norleucine['brunch'][$j];
																		$norleucine+=$arr_norleucine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($norleucine > 0)
																		echo $norleucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phenylalanine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phenylalanine['brunch'][$j] != '' )
																	{
																		echo $arr_phenylalanine['brunch'][$j];
																		$phenylalanine+=$arr_phenylalanine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phenylalanine > 0)
																		echo $phenylalanine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$proline = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_proline['brunch'][$j] != '' )
																	{
																		echo $arr_proline['brunch'][$j];
																		$proline+=$arr_proline['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($proline > 0)
																		echo $proline;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$serine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_serine['brunch'][$j] != '' )
																	{
																		echo $arr_serine['brunch'][$j];
																		$serine+=$arr_serine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($serine > 0)
																		echo $serine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$threonine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_threonine['brunch'][$j] != '' )
																	{
																		echo $arr_threonine['brunch'][$j];
																		$threonine+=$arr_threonine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($threonine > 0)
																		echo $threonine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$thyroxine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_thyroxine['brunch'][$j] != '' )
																	{
																		echo $arr_thyroxine['brunch'][$j];
																		$thyroxine+=$arr_thyroxine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($thyroxine > 0)
																		echo $thyroxine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tryptophane = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tryptophane['brunch'][$j] != '' )
																	{
																		echo $arr_tryptophane['brunch'][$j];
																		$tryptophane+=$arr_tryptophane['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tryptophane > 0)
																		echo $tryptophane;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tyrosine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tyrosine['brunch'][$j] != '' )
																	{
																		echo $arr_tyrosine['brunch'][$j];
																		$tyrosine+=$arr_tyrosine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tyrosine > 0)
																		echo $tyrosine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$valine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php

																	if($arr_valine['brunch'][$j] != '' )
																	{
																		echo $arr_valine['brunch'][$j];
																		$valine+=$arr_valine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($valine > 0)
																		echo $valine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_minerals = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_minerals['brunch'][$j] != '' )
																	{
																		echo $arr_total_minerals['brunch'][$j];
																		$total_minerals+=$arr_total_minerals['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_minerals > 0)
																		echo $total_minerals;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$calcium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_calcium['brunch'][$j] != '' )
																	{
																		echo $arr_calcium['brunch'][$j];
																		$calcium+=$arr_calcium['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($calcium > 0)
																		echo $calcium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iron = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iron['brunch'][$j] != '' )
																	{
																		echo $arr_iron['brunch'][$j];
																		$iron+=$arr_iron['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iron > 0)
																		echo $iron;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$potassium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_potassium['brunch'][$j] != '' )
																	{
																		echo $arr_potassium['brunch'][$j];
																		$potassium+=$arr_potassium['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($potassium > 0)
																		echo $potassium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sodium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sodium['brunch'][$j] != '' )
																	{
																		echo $arr_sodium['brunch'][$j];
																		$sodium+=$arr_sodium['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sodium > 0)
																		echo $sodium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phosphorus = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phosphorus['brunch'][$j] != '' )
																	{
																		echo $arr_phosphorus['brunch'][$j];
																		$phosphorus+=$arr_phosphorus['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phosphorus > 0)
																		echo $phosphorus;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sulphur = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sulphur['brunch'][$j] != '' )
																	{
																		echo $arr_sulphur['brunch'][$j];
																		$sulphur+=$arr_sulphur['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sulphur > 0)
																		echo $sulphur;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$chlorine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_chlorine['brunch'][$j] != '' )
																	{
																		echo $arr_chlorine['brunch'][$j];
																		$chlorine+=$arr_chlorine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($chlorine > 0)
																		echo $chlorine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iodine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iodine['brunch'][$j] != '' )
																	{
																		echo $arr_iodine['brunch'][$j];
																		$iodine+=$arr_iodine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iodine > 0)
																		echo $iodine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$magnesium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_magnesium['brunch'][$j] != '' )
																	{
																		echo $arr_magnesium['brunch'][$j];
																		$magnesium+=$arr_magnesium['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($magnesium > 0)
																		echo $magnesium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$zinc = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_zinc['brunch'][$j] != '' )
																	{
																		echo $arr_zinc['brunch'][$j];
																		$zinc+=$arr_zinc['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($zinc > 0)
																		echo $zinc;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$copper = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_copper['brunch'][$j] != '' )

																	{
																		echo $arr_copper['brunch'][$j];
																		$copper+=$arr_copper['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($copper > 0)
																		echo $copper;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$chromium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_chromium['brunch'][$j] != '' )
																	{
																		echo $arr_chromium['brunch'][$j];
																		$chromium+=$arr_chromium['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($chromium > 0)
																		echo $chromium;
																	else
																		echo '&nbsp;';
																	?></td>
                                                                </tr>
                                                                <tr>
																<?php
																$manganese = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_manganese['brunch'][$j] != '' )
																	{
																		echo $arr_manganese['brunch'][$j];
																		$manganese+=$arr_manganese['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($manganese > 0)
																		echo $manganese;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$selenium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_selenium['brunch'][$j] != '' )
																	{
																		echo $arr_selenium['brunch'][$j];
																		$selenium+=$arr_selenium['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($selenium > 0)
																		echo $selenium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$boron = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_boron['brunch'][$j] != '' )
																	{
																		echo $arr_boron['brunch'][$j];
																		$boron+=$arr_boron['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($boron > 0)
																		echo $boron;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$molybdenum = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_molybdenum['brunch'][$j] != '' )
																	{
																		echo $arr_molybdenum['brunch'][$j];
																		$molybdenum+=$arr_molybdenum['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($molybdenum > 0)
																		echo $molybdenum;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$caffeine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['brunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_caffeine['brunch'][$j] != '' )
																	{
																		echo $arr_caffeine['brunch'][$j];
																		$caffeine+=$arr_caffeine['brunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($caffeine > 0)
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
                                                } ?>	

												<?php
                                                if( is_array($arr_meal_time['lunch']) && count($arr_meal_time['lunch']) > 0)
                                                { ?>
												<table width="920" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td>&nbsp;</td>
														<td>&nbsp;</td>
													</tr>
												</table>
												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">
													<tr>
														<td width="864" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Lunch</strong></td>
														<td width="54" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
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
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Water(%)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calories</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Total fat(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Saturated(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Monounsaturated(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Poly-unsaturated</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
	                                                            <tr>
    		                                                        <td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated - Linoleic</td>
            	                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated   alpha-Linoleic</td>
	                                                            </tr>
                                                            </table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cholesterol(mg)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total dietary fiber(g)</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Carbohydrate</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glucose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Fructose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Galactose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Disaccharide</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Maltose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lactose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sucrose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Polysaccharide</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Starch</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cellulose</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycogen</td>
                                                                </tr>
                                                            </table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Dextrins</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sugar</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamins</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (As Acetate)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (Retinol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamin B Complex</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B1 (Thiamin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B2 (Riboflavin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />&nbsp;/Nicotonic Acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B5 (Pantothenic Acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B6 (Pyridoxine HCL)</td
																></tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B12 (Cyanocobalamin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Folic Acid (or Folate)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Biotin</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin C (Ascorbic acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin D (Calciferol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin E (Tocopherol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin K (Phylloquinone)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Protein / Amino Acids</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Alanine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Arginine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Aspartic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cystine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Giutamic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Histidine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy-glutamic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy proline</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodogorgoic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Isoleucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Leucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lysine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Methionine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Norleucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phenylalanine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Proline</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Serine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Threonine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Thyroxine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tryptophane</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tyrosine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Valine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Minerals</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calcium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iron</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Potassium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sodium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phosphorus</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sulphur</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chlorine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Magnesium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Zinc</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Copper</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chromium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Manganese</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Selenium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Boron</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Molybdenum</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Caffeine</td>
																</tr>
															</table>
														</td>
														<td colspan="10" align="left" valign="top">
															<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_time['lunch'][$j] != '' )
																	{
																		echo $i;
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_time['lunch'][$j] != '' )
																	{
																		echo $arr_meal_time['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp; </td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_item['lunch'][$j] != '' )
																	{
																		echo $arr_meal_item['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_measure['lunch'][$j] != '' )
																	{
																		echo $arr_meal_measure['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_ml['lunch'][$j] != '' )
																	{
																		echo $arr_meal_ml['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_weight['lunch'][$j] != '' )
																	{
																		echo $arr_weight['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																$water = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_water['lunch'][$j] != '' )
																	{
																		echo $arr_water['lunch'][$j];
																		$water+=$arr_water['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($water > 0)
																		echo $water;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$calories = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_calories['lunch'][$j] != '' )
																	{
																		echo $arr_calories['lunch'][$j];
																		$calories+=$arr_calories['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($calories > 0)
																		echo $calories;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$fat = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_fat['lunch'][$j] != '' )
																	{
																		echo $arr_total_fat['lunch'][$j];
																		$fat+=$arr_total_fat['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($fat > 0)
																		echo $fat;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$saturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_saturated['lunch'][$j] != '' )
																	{
																		echo $arr_saturated['lunch'][$j];
																		$saturated+=$arr_saturated['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($saturated > 0)
																		echo $saturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$monounsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_monounsaturated['lunch'][$j] != '' )
																	{
																		echo $arr_monounsaturated['lunch'][$j];
																		$monounsaturated+=$arr_monounsaturated['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($monounsaturated > 0)
																		echo $monounsaturated;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$polyunsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php
																	if($arr_polyunsaturated['lunch'][$j] != '' )
																	{

																		echo $arr_polyunsaturated['lunch'][$j];
																		$polyunsaturated+=$arr_polyunsaturated['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($polyunsaturated > 0)
																		echo $polyunsaturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$polyunsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_polyunsaturated_linoleic['lunch'][$j] != '' )
																	{
																		echo $arr_polyunsaturated_linoleic['lunch'][$j];
																		$polyunsaturated+=$arr_polyunsaturated_linoleic['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($polyunsaturated > 0)
																		echo $polyunsaturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$alphalinoleic = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_polyunsaturated_alphalinoleic['lunch'][$j] != '' )
																	{
																		echo $arr_polyunsaturated_alphalinoleic['lunch'][$j];
																		$alphalinoleic+=$arr_polyunsaturated_alphalinoleic['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($alphalinoleic > 0)
																		echo $alphalinoleic;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$cholesterol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_cholesterol['lunch'][$j] != '' )
																	{
																		echo $arr_cholesterol['lunch'][$j];
																		$cholesterol+=$arr_cholesterol['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cholesterol > 0)
																		echo $cholesterol;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$dietary_fiber = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_dietary_fiber['lunch'][$j] != '' )
																	{
																		echo $arr_total_dietary_fiber['lunch'][$j];
																		$dietary_fiber+=$arr_total_dietary_fiber['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($dietary_fiber > 0)
																		echo $dietary_fiber;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$carbohydrate = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_carbohydrate['lunch'][$j] != '' )
																	{
																		echo $arr_carbohydrate['lunch'][$j];
																		$carbohydrate+=$arr_carbohydrate['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($carbohydrate > 0)
																		echo $carbohydrate;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glucose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_glucose['lunch'][$j] != '' )
																	{
																		echo $arr_glucose['lunch'][$j];
																		$glucose+=$arr_glucose['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glucose > 0)
																		echo $glucose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$fructose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_fructose['lunch'][$j] != '' )
																	{
																		echo $arr_fructose['lunch'][$j];
																		$fructose+=$arr_fructose['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($fructose > 0)
																		echo $fructose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$galactose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_galactose['lunch'][$j] != '' )
																	{
																		echo $arr_galactose['lunch'][$j];
																		$galactose+=$arr_galactose['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($galactose > 0)
																		echo $galactose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$disaccharide = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_disaccharide['lunch'][$j] != '' )
																	{
																		echo $arr_disaccharide['lunch'][$j];
																		$disaccharide+=$arr_disaccharide['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($disaccharide > 0)
																		echo $disaccharide;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$maltose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_maltose['lunch'][$j] != '' )
																	{
																		echo $arr_maltose['lunch'][$j];
																		$maltose+=$arr_maltose['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($maltose > 0)
																		echo $maltose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$lactose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_lactose['lunch'][$j] != '' )
																	{
																		echo $arr_lactose['lunch'][$j];
																		$lactose+=$arr_lactose['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($lactose > 0)
																		echo $lactose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sucrose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_sucrose['lunch'][$j] != '' )
																	{
																		echo $arr_sucrose['lunch'][$j];
																		$sucrose+=$arr_sucrose['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sucrose > 0)
																		echo $sucrose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$polysaccharide = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_polysaccharide['lunch'][$j] != '' )
																	{
																		echo $arr_total_polysaccharide['lunch'][$j];
																		$polysaccharide+=$arr_total_polysaccharide['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($polysaccharide > 0)
																		echo $polysaccharide;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$starch = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_starch['lunch'][$j] != '' )
																	{
																		echo $arr_starch['lunch'][$j];
																		$starch+=$arr_starch['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($starch > 0)
																		echo $starch;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cellulose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cellulose['lunch'][$j] != '' )
																	{
																		echo $arr_cellulose['lunch'][$j];
																		$cellulose+=$arr_cellulose['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cellulose > 0)
																		echo $cellulose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glycogen = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_glycogen['lunch'][$j] != '' )
																	{
																		echo $arr_glycogen['lunch'][$j];
																		$glycogen+=$arr_glycogen['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glycogen > 0)
																		echo $glycogen;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$dextrins = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_dextrins['lunch'][$j] != '' )
																	{
																		echo $arr_dextrins['lunch'][$j];
																		$dextrins+=$arr_dextrins['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($dextrins > 0)
																		echo $dextrins;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sugar = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sugar['lunch'][$j] != '' )
																	{
																		echo $arr_sugar['lunch'][$j];
																		$sugar+=$arr_sugar['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sugar > 0)
																		echo $sugar;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_vitamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_vitamin['lunch'][$j] != '' )
																	{
																		echo $arr_total_vitamin['lunch'][$j];
																		$total_vitamin+=$arr_total_vitamin['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_vitamin > 0)
																		echo $total_vitamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$vitamin_a_acetate = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_vitamin_a_acetate['lunch'][$j] != '' )
																	{
																		echo $arr_vitamin_a_acetate['lunch'][$j];
																		$vitamin_a_acetate+=$arr_vitamin_a_acetate['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($vitamin_a_acetate > 0)
																		echo $vitamin_a_acetate;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$vitamin_a_retinol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_vitamin_a_retinol['lunch'][$j] != '' )
																	{
																		echo $arr_vitamin_a_retinol['lunch'][$j];
																		$vitamin_a_retinol+=$arr_vitamin_a_retinol['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($vitamin_a_retinol > 0)
																		echo $vitamin_a_retinol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_vitamin_b_complex = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_vitamin_b_complex['lunch'][$j] != '' )
																	{
																		echo $arr_total_vitamin_b_complex['lunch'][$j];
																		$total_vitamin_b_complex+=$arr_total_vitamin_b_complex['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_vitamin_b_complex > 0)
																		echo $total_vitamin_b_complex;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$thiamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_thiamin['lunch'][$j] != '' )
																	{
																		echo $arr_thiamin['lunch'][$j];
																		$thiamin+=$arr_thiamin['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($thiamin > 0)
																		echo $thiamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$riboflavin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_riboflavin['lunch'][$j] != '' )
																	{
																		echo $arr_riboflavin['lunch'][$j];
																		$riboflavin+=$arr_riboflavin['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($riboflavin > 0)
																		echo $riboflavin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr height="50px">
																<?php
																$niacin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td height="52" align="center" valign="middle" bgcolor="#FFFFFF"><?php
																	if($arr_niacin['lunch'][$j] != '' )
																	{
																		echo $arr_niacin['lunch'][$j];
																		$niacin+=$$arr_niacin['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($niacin > 0)
																		echo $niacin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$pantothenic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_pantothenic_acid['lunch'][$j] != '' )
																	{
																		echo $arr_pantothenic_acid['lunch'][$j];
																		$pantothenic_acid+=$arr_pantothenic_acid['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($pantothenic_acid > 0)
																		echo $pantothenic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$pyridoxine_hcl = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_pyridoxine_hcl['lunch'][$j] != '' )
																	{
																		echo $arr_pyridoxine_hcl['lunch'][$j];
																		$pyridoxine_hcl+=$arr_pyridoxine_hcl['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($pyridoxine_hcl > 0)
																		echo $pyridoxine_hcl;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cyanocobalamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cyanocobalamin['lunch'][$j] != '' )
																	{
																		echo $arr_cyanocobalamin['lunch'][$j];
																		$cyanocobalamin+=$arr_cyanocobalamin['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cyanocobalamin > 0)
																		echo $cyanocobalamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$folic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_folic_acid['lunch'][$j] != '' )
																	{
																		echo $arr_folic_acid['lunch'][$j];
																		$folic_acid+=$arr_folic_acid['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($folic_acid > 0)
																		echo $folic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$biotin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_biotin['lunch'][$j] != '' )
																	{
																		echo $arr_biotin['lunch'][$j];
																		$biotin+=$arr_biotin['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($biotin > 0)
																		echo $biotin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$ascorbic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_ascorbic_acid['lunch'][$j] != '' )
																	{
																		echo $arr_ascorbic_acid['lunch'][$j];
																		$ascorbic_acid+=$arr_ascorbic_acid['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($ascorbic_acid > 0)
																		echo $ascorbic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$calciferol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_calciferol['lunch'][$j] != '' )
																	{
																		echo $arr_calciferol['lunch'][$j];
																		$calciferol+=$arr_calciferol['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($calciferol > 0)
																		echo $calciferol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tocopherol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tocopherol['lunch'][$j] != '' )
																	{
																		echo $arr_tocopherol['lunch'][$j];
																		$tocopherol+=$arr_tocopherol['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tocopherol > 0)
																		echo $tocopherol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phylloquinone = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phylloquinone['lunch'][$j] != '' )
																	{
																		echo $arr_phylloquinone['lunch'][$j];
																		$phylloquinone+=$arr_phylloquinone['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phylloquinone > 0)
																		echo $phylloquinone;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$protein = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_protein['lunch'][$j] != '' )
																	{
																		echo $arr_protein['lunch'][$j];
																		$protein+=$arr_protein['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($protein > 0)
																		echo $protein;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$alanine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_alanine['lunch'][$j] != '' )
																	{
																		echo $arr_alanine['lunch'][$j];
																		$alanine+=$arr_alanine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($alanine > 0)
																		echo $alanine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$arginine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_arginine['lunch'][$j] != '' )
																	{
																		echo $arr_arginine['lunch'][$j];
																		$arginine+=$arr_arginine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($arginine > 0)
																		echo $arginine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$aspartic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_aspartic_acid['lunch'][$j] != '' )
																	{
																		echo $arr_aspartic_acid['lunch'][$j];
																		$aspartic_acid+=$arr_aspartic_acid['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($aspartic_acid > 0)
																		echo $aspartic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cystine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cystine['lunch'][$j] != '' )
																	{
																		echo $arr_cystine['lunch'][$j];
																		$cystine+=$arr_cystine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cystine > 0)
																		echo $cystine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$giutamic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_giutamic_acid['lunch'][$j] != '' )
																	{
																		echo $arr_giutamic_acid['lunch'][$j];
																		$giutamic_acid+=$arr_giutamic_acid['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($giutamic_acid > 0)
																		echo $giutamic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glycine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_glycine['lunch'][$j] != '' )
																	{
																		echo $arr_glycine['lunch'][$j];
																		$glycine+=$arr_glycine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glycine > 0)
																		echo $glycine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$histidine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_histidine['lunch'][$j] != '' )
																	{
																		echo $arr_histidine['lunch'][$j];
																		$histidine+=$arr_histidine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($histidine > 0)
																		echo $histidine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glutamic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_hydroxy_glutamic_acid['lunch'][$j] != '' )
																	{
																		echo $arr_hydroxy_glutamic_acid['lunch'][$j];
																		$glutamic_acid+=$arr_hydroxy_glutamic_acid['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glutamic_acid > 0)
																		echo $glutamic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$hydroxy_proline = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_hydroxy_proline['lunch'][$j] != '' )
																	{
																		echo $arr_hydroxy_proline['lunch'][$j];
																		$hydroxy_proline+=$arr_hydroxy_proline['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($hydroxy_proline > 0)
																		echo $hydroxy_proline;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iodogorgoic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iodogorgoic_acid['lunch'][$j] != '' )
																	{
																		echo $arr_iodogorgoic_acid['lunch'][$j];
																		$iodogorgoic_acid+=$arr_iodogorgoic_acid['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iodogorgoic_acid > 0)
																		echo $iodogorgoic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$isoleucine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_isoleucine['lunch'][$j] != '' )
																	{
																		echo $arr_isoleucine['lunch'][$j];
																		$isoleucine+=$arr_isoleucine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($isoleucine > 0)
																		echo $isoleucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$leucine= 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_leucine['lunch'][$j] != '' )
																	{
																		echo $arr_leucine['lunch'][$j];
																		$leucine+=$arr_leucine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($leucine > 0)
																		echo $leucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$lysine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_lysine['lunch'][$j] != '' )
																	{
																		echo $arr_lysine['lunch'][$j];
																		$lysine+=$arr_lysine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($lysine > 0)
																		echo $lysine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$methionine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_methionine['lunch'][$j] != '' )
																	{
																		echo $arr_methionine['lunch'][$j];
																		$methionine+=$arr_methionine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($methionine > 0)
																		echo $methionine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$norleucine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_norleucine['lunch'][$j] != '' )
																	{
																		echo $arr_norleucine['lunch'][$j];
																		$norleucine+=$arr_norleucine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($norleucine > 0)
																		echo $norleucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phenylalanine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phenylalanine['lunch'][$j] != '' )
																	{
																		echo $arr_phenylalanine['lunch'][$j];
																		$phenylalanine+=$arr_phenylalanine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phenylalanine > 0)
																		echo $phenylalanine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$proline = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_proline['lunch'][$j] != '' )
																	{
																		echo $arr_proline['lunch'][$j];
																		$proline+=$arr_proline['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($proline > 0)
																		echo $proline;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$serine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_serine['lunch'][$j] != '' )
																	{
																		echo $arr_serine['lunch'][$j];
																		$serine+=$arr_serine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($serine > 0)
																		echo $serine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$threonine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_threonine['lunch'][$j] != '' )
																	{
																		echo $arr_threonine['lunch'][$j];
																		$threonine+=$arr_threonine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($threonine > 0)
																		echo $threonine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$thyroxine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_thyroxine['lunch'][$j] != '' )
																	{
																		echo $arr_thyroxine['lunch'][$j];
																		$thyroxine+=$arr_thyroxine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($thyroxine > 0)
																		echo $thyroxine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tryptophane = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tryptophane['lunch'][$j] != '' )
																	{
																		echo $arr_tryptophane['lunch'][$j];
																		$tryptophane+=$arr_tryptophane['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tryptophane > 0)
																		echo $tryptophane;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tyrosine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tyrosine['lunch'][$j] != '' )
																	{
																		echo $arr_tyrosine['lunch'][$j];
																		$tyrosine+=$arr_tyrosine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tyrosine > 0)
																		echo $tyrosine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$valine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_valine['lunch'][$j] != '' )
																	{
																		echo $arr_valine['lunch'][$j];
																		$valine+=$arr_valine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($valine > 0)
																		echo $valine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_minerals = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_minerals['lunch'][$j] != '' )
																	{
																		echo $arr_total_minerals['lunch'][$j];
																		$total_minerals+=$arr_total_minerals['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_minerals > 0)
																		echo $total_minerals;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$calcium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_calcium['lunch'][$j] != '' )
																	{
																		echo $arr_calcium['lunch'][$j];
																		$calcium+=$arr_calcium['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($calcium > 0)
																		echo $calcium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iron = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iron['lunch'][$j] != '' )
																	{
																		echo $arr_iron['lunch'][$j];
																		$iron+=$arr_iron['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iron > 0)
																		echo $iron;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$potassium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_potassium['lunch'][$j] != '' )
																	{
																		echo $arr_potassium['lunch'][$j];
																		$potassium+=$arr_potassium['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($potassium > 0)
																		echo $potassium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sodium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sodium['lunch'][$j] != '' )
																	{
																		echo $arr_sodium['lunch'][$j];
																		$sodium+=$arr_sodium['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sodium > 0)
																		echo $sodium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phosphorus = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phosphorus['lunch'][$j] != '' )
																	{
																		echo $arr_phosphorus['lunch'][$j];
																		$phosphorus+=$arr_phosphorus['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phosphorus > 0)
																		echo $phosphorus;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sulphur = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sulphur['lunch'][$j] != '' )
																	{
																		echo $arr_sulphur['lunch'][$j];
																		$sulphur+=$arr_sulphur['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sulphur > 0)
																		echo $sulphur;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$chlorine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_chlorine['lunch'][$j] != '' )
																	{
																		echo $arr_chlorine['lunch'][$j];
																		$chlorine+=$arr_chlorine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($chlorine > 0)
																		echo $chlorine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iodine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iodine['lunch'][$j] != '' )
																	{
																		echo $arr_iodine['lunch'][$j];
																		$iodine+=$arr_iodine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iodine > 0)
																		echo $iodine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$magnesium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_magnesium['lunch'][$j] != '' )
																	{
																		echo $arr_magnesium['lunch'][$j];
																		$magnesium+=$arr_magnesium['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($magnesium > 0)
																		echo $magnesium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$zinc = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_zinc['lunch'][$j] != '' )
																	{
																		echo $arr_zinc['lunch'][$j];
																		$zinc+=$arr_zinc['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($zinc > 0)
																		echo $zinc;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$copper = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_copper['lunch'][$j] != '' )

																	{
																		echo $arr_copper['lunch'][$j];
																		$copper+=$arr_copper['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($copper > 0)
																		echo $copper;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$chromium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_chromium['lunch'][$j] != '' )
																	{
																		echo $arr_chromium['lunch'][$j];
																		$chromium+=$arr_chromium['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($chromium > 0)
																		echo $chromium;
																	else
																		echo '&nbsp;';
																	?></td>
                                                                </tr>
                                                                <tr>
																<?php
																$manganese = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_manganese['lunch'][$j] != '' )
																	{
																		echo $arr_manganese['lunch'][$j];
																		$manganese+=$arr_manganese['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($manganese > 0)
																		echo $manganese;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$selenium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_selenium['lunch'][$j] != '' )
																	{
																		echo $arr_selenium['lunch'][$j];
																		$selenium+=$arr_selenium['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($selenium > 0)
																		echo $selenium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$boron = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_boron['lunch'][$j] != '' )
																	{
																		echo $arr_boron['lunch'][$j];
																		$boron+=$arr_boron['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($boron > 0)
																		echo $boron;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$molybdenum = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_molybdenum['lunch'][$j] != '' )
																	{
																		echo $arr_molybdenum['lunch'][$j];
																		$molybdenum+=$arr_molybdenum['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($molybdenum > 0)
																		echo $molybdenum;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$caffeine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['lunch']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_caffeine['lunch'][$j] != '' )
																	{
																		echo $arr_caffeine['lunch'][$j];
																		$caffeine+=$arr_caffeine['lunch'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($caffeine > 0)
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
                                                } ?>	

                                                												<?php
                                                if( is_array($arr_meal_time['snacks']) && count($arr_meal_time['snacks']) > 0)
                                                { ?>
												<table width="920" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td>&nbsp;</td>
														<td>&nbsp;</td>
													</tr>
												</table>
												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">
													<tr>
														<td width="864" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>snacks</strong></td>
														<td width="54" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
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
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Water(%)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calories</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Total fat(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Saturated(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Monounsaturated(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Poly-unsaturated</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
	                                                            <tr>
    		                                                        <td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated - Linoleic</td>
            	                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated   alpha-Linoleic</td>
	                                                            </tr>
                                                            </table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cholesterol(mg)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total dietary fiber(g)</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Carbohydrate</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glucose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Fructose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Galactose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Disaccharide</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Maltose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lactose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sucrose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Polysaccharide</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Starch</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cellulose</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycogen</td>
                                                                </tr>
                                                            </table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Dextrins</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sugar</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamins</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (As Acetate)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (Retinol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamin B Complex</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B1 (Thiamin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B2 (Riboflavin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />&nbsp;/Nicotonic Acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B5 (Pantothenic Acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B6 (Pyridoxine HCL)</td
																></tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B12 (Cyanocobalamin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Folic Acid (or Folate)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Biotin</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin C (Ascorbic acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin D (Calciferol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin E (Tocopherol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin K (Phylloquinone)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Protein / Amino Acids</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Alanine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Arginine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Aspartic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cystine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Giutamic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Histidine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy-glutamic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy proline</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodogorgoic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Isoleucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Leucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lysine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Methionine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Norleucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phenylalanine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Proline</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Serine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Threonine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Thyroxine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tryptophane</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tyrosine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Valine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Minerals</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calcium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iron</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Potassium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sodium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phosphorus</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sulphur</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chlorine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Magnesium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Zinc</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Copper</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chromium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Manganese</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Selenium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Boron</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Molybdenum</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Caffeine</td>
																</tr>
															</table>
														</td>
														<td colspan="10" align="left" valign="top">
															<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_time['snacks'][$j] != '' )
																	{
																		echo $i;
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_time['snacks'][$j] != '' )
																	{
																		echo $arr_meal_time['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp; </td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_item['snacks'][$j] != '' )
																	{
																		echo $arr_meal_item['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_measure['snacks'][$j] != '' )
																	{
																		echo $arr_meal_measure['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_ml['snacks'][$j] != '' )
																	{
																		echo $arr_meal_ml['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_weight['snacks'][$j] != '' )
																	{
																		echo $arr_weight['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																$water = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_water['snacks'][$j] != '' )
																	{
																		echo $arr_water['snacks'][$j];
																		$water+=$arr_water['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($water > 0)
																		echo $water;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$calories = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_calories['snacks'][$j] != '' )
																	{
																		echo $arr_calories['snacks'][$j];
																		$calories+=$arr_calories['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($calories > 0)
																		echo $calories;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$fat = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_fat['snacks'][$j] != '' )
																	{
																		echo $arr_total_fat['snacks'][$j];
																		$fat+=$arr_total_fat['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($fat > 0)
																		echo $fat;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$saturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_saturated['snacks'][$j] != '' )
																	{
																		echo $arr_saturated['snacks'][$j];
																		$saturated+=$arr_saturated['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($saturated > 0)
																		echo $saturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$monounsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_monounsaturated['snacks'][$j] != '' )
																	{
																		echo $arr_monounsaturated['snacks'][$j];
																		$monounsaturated+=$arr_monounsaturated['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($monounsaturated > 0)
																		echo $monounsaturated;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$polyunsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php
																	if($arr_polyunsaturated['snacks'][$j] != '' )
																	{
																		echo $arr_polyunsaturated['snacks'][$j];
																		$polyunsaturated+=$arr_polyunsaturated['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($polyunsaturated > 0)
																		echo $polyunsaturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$polyunsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_polyunsaturated_linoleic['snacks'][$j] != '' )
																	{
																		echo $arr_polyunsaturated_linoleic['snacks'][$j];
																		$polyunsaturated+=$arr_polyunsaturated_linoleic['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($polyunsaturated > 0)
																		echo $polyunsaturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$alphalinoleic = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_polyunsaturated_alphalinoleic['snacks'][$j] != '' )
																	{
																		echo $arr_polyunsaturated_alphalinoleic['snacks'][$j];
																		$alphalinoleic+=$arr_polyunsaturated_alphalinoleic['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($alphalinoleic > 0)
																		echo $alphalinoleic;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$cholesterol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_cholesterol['snacks'][$j] != '' )
																	{
																		echo $arr_cholesterol['snacks'][$j];
																		$cholesterol+=$arr_cholesterol['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cholesterol > 0)
																		echo $cholesterol;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$dietary_fiber = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_dietary_fiber['snacks'][$j] != '' )
																	{
																		echo $arr_total_dietary_fiber['snacks'][$j];
																		$dietary_fiber+=$arr_total_dietary_fiber['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($dietary_fiber > 0)
																		echo $dietary_fiber;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$carbohydrate = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_carbohydrate['snacks'][$j] != '' )
																	{
																		echo $arr_carbohydrate['snacks'][$j];
																		$carbohydrate+=$arr_carbohydrate['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($carbohydrate > 0)
																		echo $carbohydrate;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glucose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_glucose['snacks'][$j] != '' )
																	{
																		echo $arr_glucose['snacks'][$j];
																		$glucose+=$arr_glucose['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glucose > 0)
																		echo $glucose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$fructose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_fructose['snacks'][$j] != '' )
																	{
																		echo $arr_fructose['snacks'][$j];
																		$fructose+=$arr_fructose['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($fructose > 0)
																		echo $fructose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$galactose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_galactose['snacks'][$j] != '' )
																	{
																		echo $arr_galactose['snacks'][$j];
																		$galactose+=$arr_galactose['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($galactose > 0)
																		echo $galactose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$disaccharide = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_disaccharide['snacks'][$j] != '' )
																	{
																		echo $arr_disaccharide['snacks'][$j];
																		$disaccharide+=$arr_disaccharide['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($disaccharide > 0)
																		echo $disaccharide;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$maltose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_maltose['snacks'][$j] != '' )
																	{
																		echo $arr_maltose['snacks'][$j];
																		$maltose+=$arr_maltose['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($maltose > 0)
																		echo $maltose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$lactose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_lactose['snacks'][$j] != '' )
																	{
																		echo $arr_lactose['snacks'][$j];
																		$lactose+=$arr_lactose['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($lactose > 0)
																		echo $lactose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sucrose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_sucrose['snacks'][$j] != '' )
																	{
																		echo $arr_sucrose['snacks'][$j];
																		$sucrose+=$arr_sucrose['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sucrose > 0)
																		echo $sucrose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$polysaccharide = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_polysaccharide['snacks'][$j] != '' )
																	{
																		echo $arr_total_polysaccharide['snacks'][$j];
																		$polysaccharide+=$arr_total_polysaccharide['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($polysaccharide > 0)
																		echo $polysaccharide;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$starch = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_starch['snacks'][$j] != '' )
																	{
																		echo $arr_starch['snacks'][$j];
																		$starch+=$arr_starch['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($starch > 0)
																		echo $starch;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cellulose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cellulose['snacks'][$j] != '' )
																	{
																		echo $arr_cellulose['snacks'][$j];
																		$cellulose+=$arr_cellulose['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cellulose > 0)
																		echo $cellulose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glycogen = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_glycogen['snacks'][$j] != '' )
																	{
																		echo $arr_glycogen['snacks'][$j];
																		$glycogen+=$arr_glycogen['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glycogen > 0)
																		echo $glycogen;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$dextrins = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_dextrins['snacks'][$j] != '' )
																	{
																		echo $arr_dextrins['snacks'][$j];
																		$dextrins+=$arr_dextrins['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($dextrins > 0)
																		echo $dextrins;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sugar = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sugar['snacks'][$j] != '' )
																	{
																		echo $arr_sugar['snacks'][$j];
																		$sugar+=$arr_sugar['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sugar > 0)
																		echo $sugar;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_vitamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_vitamin['snacks'][$j] != '' )
																	{
																		echo $arr_total_vitamin['snacks'][$j];
																		$total_vitamin+=$arr_total_vitamin['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_vitamin > 0)
																		echo $total_vitamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$vitamin_a_acetate = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_vitamin_a_acetate['snacks'][$j] != '' )
																	{
																		echo $arr_vitamin_a_acetate['snacks'][$j];
																		$vitamin_a_acetate+=$arr_vitamin_a_acetate['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($vitamin_a_acetate > 0)
																		echo $vitamin_a_acetate;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$vitamin_a_retinol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_vitamin_a_retinol['snacks'][$j] != '' )
																	{
																		echo $arr_vitamin_a_retinol['snacks'][$j];
																		$vitamin_a_retinol+=$arr_vitamin_a_retinol['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($vitamin_a_retinol > 0)
																		echo $vitamin_a_retinol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_vitamin_b_complex = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_vitamin_b_complex['snacks'][$j] != '' )
																	{
																		echo $arr_total_vitamin_b_complex['snacks'][$j];
																		$total_vitamin_b_complex+=$arr_total_vitamin_b_complex['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_vitamin_b_complex > 0)
																		echo $total_vitamin_b_complex;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$thiamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_thiamin['snacks'][$j] != '' )
																	{
																		echo $arr_thiamin['snacks'][$j];
																		$thiamin+=$arr_thiamin['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($thiamin > 0)
																		echo $thiamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$riboflavin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_riboflavin['snacks'][$j] != '' )

																	{
																		echo $arr_riboflavin['snacks'][$j];
																		$riboflavin+=$arr_riboflavin['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($riboflavin > 0)
																		echo $riboflavin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr height="50px">
																<?php
																$niacin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td height="52" align="center" valign="middle" bgcolor="#FFFFFF"><?php
																	if($arr_niacin['snacks'][$j] != '' )
																	{
																		echo $arr_niacin['snacks'][$j];
																		$niacin+=$$arr_niacin['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($niacin > 0)
																		echo $niacin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$pantothenic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_pantothenic_acid['snacks'][$j] != '' )
																	{
																		echo $arr_pantothenic_acid['snacks'][$j];
																		$pantothenic_acid+=$arr_pantothenic_acid['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($pantothenic_acid > 0)
																		echo $pantothenic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$pyridoxine_hcl = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_pyridoxine_hcl['snacks'][$j] != '' )
																	{
																		echo $arr_pyridoxine_hcl['snacks'][$j];
																		$pyridoxine_hcl+=$arr_pyridoxine_hcl['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($pyridoxine_hcl > 0)
																		echo $pyridoxine_hcl;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cyanocobalamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cyanocobalamin['snacks'][$j] != '' )
																	{
																		echo $arr_cyanocobalamin['snacks'][$j];
																		$cyanocobalamin+=$arr_cyanocobalamin['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cyanocobalamin > 0)
																		echo $cyanocobalamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$folic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_folic_acid['snacks'][$j] != '' )
																	{
																		echo $arr_folic_acid['snacks'][$j];
																		$folic_acid+=$arr_folic_acid['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($folic_acid > 0)
																		echo $folic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$biotin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_biotin['snacks'][$j] != '' )
																	{
																		echo $arr_biotin['snacks'][$j];
																		$biotin+=$arr_biotin['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($biotin > 0)
																		echo $biotin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$ascorbic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_ascorbic_acid['snacks'][$j] != '' )
																	{
																		echo $arr_ascorbic_acid['snacks'][$j];
																		$ascorbic_acid+=$arr_ascorbic_acid['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($ascorbic_acid > 0)
																		echo $ascorbic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$calciferol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_calciferol['snacks'][$j] != '' )
																	{
																		echo $arr_calciferol['snacks'][$j];
																		$calciferol+=$arr_calciferol['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($calciferol > 0)
																		echo $calciferol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tocopherol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tocopherol['snacks'][$j] != '' )
																	{
																		echo $arr_tocopherol['snacks'][$j];
																		$tocopherol+=$arr_tocopherol['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tocopherol > 0)
																		echo $tocopherol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phylloquinone = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phylloquinone['snacks'][$j] != '' )
																	{
																		echo $arr_phylloquinone['snacks'][$j];
																		$phylloquinone+=$arr_phylloquinone['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phylloquinone > 0)
																		echo $phylloquinone;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$protein = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_protein['snacks'][$j] != '' )
																	{
																		echo $arr_protein['snacks'][$j];
																		$protein+=$arr_protein['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($protein > 0)
																		echo $protein;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$alanine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_alanine['snacks'][$j] != '' )
																	{
																		echo $arr_alanine['snacks'][$j];
																		$alanine+=$arr_alanine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($alanine > 0)
																		echo $alanine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$arginine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_arginine['snacks'][$j] != '' )
																	{
																		echo $arr_arginine['snacks'][$j];
																		$arginine+=$arr_arginine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($arginine > 0)
																		echo $arginine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$aspartic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_aspartic_acid['snacks'][$j] != '' )
																	{
																		echo $arr_aspartic_acid['snacks'][$j];
																		$aspartic_acid+=$arr_aspartic_acid['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($aspartic_acid > 0)
																		echo $aspartic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cystine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cystine['snacks'][$j] != '' )
																	{
																		echo $arr_cystine['snacks'][$j];
																		$cystine+=$arr_cystine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cystine > 0)
																		echo $cystine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$giutamic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_giutamic_acid['snacks'][$j] != '' )
																	{
																		echo $arr_giutamic_acid['snacks'][$j];
																		$giutamic_acid+=$arr_giutamic_acid['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($giutamic_acid > 0)
																		echo $giutamic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glycine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_glycine['snacks'][$j] != '' )
																	{
																		echo $arr_glycine['snacks'][$j];
																		$glycine+=$arr_glycine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glycine > 0)
																		echo $glycine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$histidine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_histidine['snacks'][$j] != '' )
																	{
																		echo $arr_histidine['snacks'][$j];
																		$histidine+=$arr_histidine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($histidine > 0)
																		echo $histidine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glutamic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_hydroxy_glutamic_acid['snacks'][$j] != '' )
																	{
																		echo $arr_hydroxy_glutamic_acid['snacks'][$j];
																		$glutamic_acid+=$arr_hydroxy_glutamic_acid['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glutamic_acid > 0)
																		echo $glutamic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$hydroxy_proline = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_hydroxy_proline['snacks'][$j] != '' )
																	{
																		echo $arr_hydroxy_proline['snacks'][$j];
																		$hydroxy_proline+=$arr_hydroxy_proline['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($hydroxy_proline > 0)
																		echo $hydroxy_proline;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iodogorgoic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iodogorgoic_acid['snacks'][$j] != '' )
																	{
																		echo $arr_iodogorgoic_acid['snacks'][$j];
																		$iodogorgoic_acid+=$arr_iodogorgoic_acid['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iodogorgoic_acid > 0)
																		echo $iodogorgoic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$isoleucine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_isoleucine['snacks'][$j] != '' )
																	{
																		echo $arr_isoleucine['snacks'][$j];
																		$isoleucine+=$arr_isoleucine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($isoleucine > 0)
																		echo $isoleucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$leucine= 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_leucine['snacks'][$j] != '' )
																	{
																		echo $arr_leucine['snacks'][$j];
																		$leucine+=$arr_leucine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($leucine > 0)
																		echo $leucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$lysine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_lysine['snacks'][$j] != '' )
																	{
																		echo $arr_lysine['snacks'][$j];
																		$lysine+=$arr_lysine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($lysine > 0)
																		echo $lysine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$methionine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_methionine['snacks'][$j] != '' )
																	{
																		echo $arr_methionine['snacks'][$j];
																		$methionine+=$arr_methionine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($methionine > 0)
																		echo $methionine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$norleucine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_norleucine['snacks'][$j] != '' )
																	{
																		echo $arr_norleucine['snacks'][$j];
																		$norleucine+=$arr_norleucine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($norleucine > 0)
																		echo $norleucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phenylalanine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phenylalanine['snacks'][$j] != '' )
																	{
																		echo $arr_phenylalanine['snacks'][$j];
																		$phenylalanine+=$arr_phenylalanine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phenylalanine > 0)
																		echo $phenylalanine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$proline = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_proline['snacks'][$j] != '' )
																	{
																		echo $arr_proline['snacks'][$j];
																		$proline+=$arr_proline['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($proline > 0)
																		echo $proline;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$serine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_serine['snacks'][$j] != '' )
																	{
																		echo $arr_serine['snacks'][$j];
																		$serine+=$arr_serine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($serine > 0)
																		echo $serine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$threonine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_threonine['snacks'][$j] != '' )
																	{
																		echo $arr_threonine['snacks'][$j];
																		$threonine+=$arr_threonine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($threonine > 0)
																		echo $threonine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$thyroxine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_thyroxine['snacks'][$j] != '' )
																	{
																		echo $arr_thyroxine['snacks'][$j];
																		$thyroxine+=$arr_thyroxine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($thyroxine > 0)
																		echo $thyroxine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tryptophane = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tryptophane['snacks'][$j] != '' )
																	{
																		echo $arr_tryptophane['snacks'][$j];
																		$tryptophane+=$arr_tryptophane['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tryptophane > 0)
																		echo $tryptophane;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tyrosine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tyrosine['snacks'][$j] != '' )
																	{
																		echo $arr_tyrosine['snacks'][$j];
																		$tyrosine+=$arr_tyrosine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tyrosine > 0)
																		echo $tyrosine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$valine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_valine['snacks'][$j] != '' )
																	{
																		echo $arr_valine['snacks'][$j];
																		$valine+=$arr_valine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($valine > 0)
																		echo $valine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_minerals = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_minerals['snacks'][$j] != '' )
																	{
																		echo $arr_total_minerals['snacks'][$j];
																		$total_minerals+=$arr_total_minerals['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_minerals > 0)
																		echo $total_minerals;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$calcium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_calcium['snacks'][$j] != '' )
																	{
																		echo $arr_calcium['snacks'][$j];
																		$calcium+=$arr_calcium['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($calcium > 0)
																		echo $calcium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iron = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iron['snacks'][$j] != '' )
																	{
																		echo $arr_iron['snacks'][$j];
																		$iron+=$arr_iron['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iron > 0)
																		echo $iron;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$potassium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_potassium['snacks'][$j] != '' )
																	{
																		echo $arr_potassium['snacks'][$j];
																		$potassium+=$arr_potassium['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($potassium > 0)
																		echo $potassium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sodium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sodium['snacks'][$j] != '' )
																	{
																		echo $arr_sodium['snacks'][$j];
																		$sodium+=$arr_sodium['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sodium > 0)
																		echo $sodium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phosphorus = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phosphorus['snacks'][$j] != '' )
																	{
																		echo $arr_phosphorus['snacks'][$j];
																		$phosphorus+=$arr_phosphorus['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phosphorus > 0)
																		echo $phosphorus;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sulphur = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sulphur['snacks'][$j] != '' )
																	{
																		echo $arr_sulphur['snacks'][$j];
																		$sulphur+=$arr_sulphur['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sulphur > 0)
																		echo $sulphur;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$chlorine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_chlorine['snacks'][$j] != '' )
																	{
																		echo $arr_chlorine['snacks'][$j];
																		$chlorine+=$arr_chlorine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($chlorine > 0)
																		echo $chlorine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iodine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iodine['snacks'][$j] != '' )
																	{
																		echo $arr_iodine['snacks'][$j];
																		$iodine+=$arr_iodine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iodine > 0)
																		echo $iodine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$magnesium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_magnesium['snacks'][$j] != '' )
																	{
																		echo $arr_magnesium['snacks'][$j];
																		$magnesium+=$arr_magnesium['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($magnesium > 0)
																		echo $magnesium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$zinc = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_zinc['snacks'][$j] != '' )
																	{
																		echo $arr_zinc['snacks'][$j];
																		$zinc+=$arr_zinc['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($zinc > 0)
																		echo $zinc;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$copper = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_copper['snacks'][$j] != '' )

																	{
																		echo $arr_copper['snacks'][$j];
																		$copper+=$arr_copper['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($copper > 0)
																		echo $copper;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$chromium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_chromium['snacks'][$j] != '' )
																	{
																		echo $arr_chromium['snacks'][$j];
																		$chromium+=$arr_chromium['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($chromium > 0)
																		echo $chromium;
																	else
																		echo '&nbsp;';
																	?></td>
                                                                </tr>
                                                                <tr>
																<?php
																$manganese = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_manganese['snacks'][$j] != '' )
																	{
																		echo $arr_manganese['snacks'][$j];
																		$manganese+=$arr_manganese['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($manganese > 0)
																		echo $manganese;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$selenium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_selenium['snacks'][$j] != '' )
																	{
																		echo $arr_selenium['snacks'][$j];
																		$selenium+=$arr_selenium['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($selenium > 0)
																		echo $selenium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$boron = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_boron['snacks'][$j] != '' )
																	{
																		echo $arr_boron['snacks'][$j];
																		$boron+=$arr_boron['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($boron > 0)
																		echo $boron;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$molybdenum = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_molybdenum['snacks'][$j] != '' )
																	{
																		echo $arr_molybdenum['snacks'][$j];
																		$molybdenum+=$arr_molybdenum['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($molybdenum > 0)
																		echo $molybdenum;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$caffeine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['snacks']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_caffeine['snacks'][$j] != '' )
																	{
																		echo $arr_caffeine['snacks'][$j];
																		$caffeine+=$arr_caffeine['snacks'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($caffeine > 0)
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
                                                } ?>	

																								<?php
                                                if( is_array($arr_meal_time['dinner']) && count($arr_meal_time['dinner']) > 0)
                                                { ?>
												<table width="920" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td>&nbsp;</td>
														<td>&nbsp;</td>
													</tr>
												</table>
												<table width="920" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="report">
													<tr>
														<td width="864" align="left" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>dinner</strong></td>
														<td width="54" align="center" height="20" valign="top" bgcolor="#E1E1E1">&nbsp;<strong>Total</strong></td>
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
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food No.</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Meal Time</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Food Description</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Measure of edible portion Serving Size</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;ML</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Weight(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Water(%)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calories</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Total fat(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Saturated(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Monounsaturated(g)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Poly-unsaturated</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
	                                                            <tr>
    		                                                        <td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated - Linoleic</td>
            	                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Poly-unsaturated   alpha-Linoleic</td>
	                                                            </tr>
                                                            </table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cholesterol(mg)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total dietary fiber(g)</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Carbohydrate</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glucose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Fructose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Galactose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Disaccharide</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Maltose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lactose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sucrose</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Polysaccharide</td>
																</tr>
															</table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Starch</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cellulose</td>
                                                                </tr>
                                                            </table>
                                                            <table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
	                                                                <td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycogen</td>
                                                                </tr>
                                                            </table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Dextrins</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sugar</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamins</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (As Acetate)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin A (Retinol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Vitamin B Complex</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B1 (Thiamin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B2 (Riboflavin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B3 (Nicotinamide/Niacin<br />&nbsp;/Nicotonic Acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B5 (Pantothenic Acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B6 (Pyridoxine HCL)</td
																></tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin B12 (Cyanocobalamin)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Folic Acid (or Folate)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Biotin</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin C (Ascorbic acid)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin D (Calciferol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin E (Tocopherol)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Vitamin K (Phylloquinone)</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Protein / Amino Acids</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Alanine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Arginine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Aspartic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Cystine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Giutamic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Glycine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Histidine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy-glutamic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Hydroxy proline</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodogorgoic acid</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Isoleucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Leucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Lysine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Methionine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Norleucine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phenylalanine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Proline</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Serine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Threonine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">Thyroxine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tryptophane</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Tyrosine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Valine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Total Minerals</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Calcium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iron</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Potassium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sodium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Phosphorus</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Sulphur</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chlorine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Iodine</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Magnesium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Zinc</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Copper</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Chromium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Manganese</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Selenium</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Boron</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Molybdenum</td>
																</tr>
															</table>
															<table class="table_border_1" width="179" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="179" align="left" valign="top" bgcolor="#E1E1E1">&nbsp;Caffeine</td>
																</tr>
															</table>
														</td>
														<td colspan="10" align="left" valign="top">
															<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_time['dinner'][$j] != '' )
																	{
																		echo $i;
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_time['dinner'][$j] != '' )
																	{
																		echo $arr_meal_time['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp; </td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_item['dinner'][$j] != '' )
																	{
																		echo $arr_meal_item['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_measure['dinner'][$j] != '' )
																	{
																		echo $arr_meal_measure['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_meal_ml['dinner'][$j] != '' )
																	{
																		echo $arr_meal_ml['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_weight['dinner'][$j] != '' )
																	{
																		echo $arr_weight['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
																</tr>
																<tr>
																<?php
																$water = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_water['dinner'][$j] != '' )
																	{
																		echo $arr_water['dinner'][$j];
																		$water+=$arr_water['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($water > 0)
																		echo $water;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$calories = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_calories['dinner'][$j] != '' )
																	{
																		echo $arr_calories['dinner'][$j];
																		$calories+=$arr_calories['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($calories > 0)
																		echo $calories;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$fat = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_fat['dinner'][$j] != '' )
																	{
																		echo $arr_total_fat['dinner'][$j];
																		$fat+=$arr_total_fat['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($fat > 0)
																		echo $fat;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$saturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_saturated['dinner'][$j] != '' )
																	{
																		echo $arr_saturated['dinner'][$j];
																		$saturated+=$arr_saturated['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($saturated > 0)
																		echo $saturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$monounsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_monounsaturated['dinner'][$j] != '' )
																	{
																		echo $arr_monounsaturated['dinner'][$j];
																		$monounsaturated+=$arr_monounsaturated['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($monounsaturated > 0)
																		echo $monounsaturated;
																	else
																		echo '&nbsp;';
																	?>
																	</td>
																</tr>
																<tr>
																<?php
																$polyunsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php
																	if($arr_polyunsaturated['dinner'][$j] != '' )
																	{
																		echo $arr_polyunsaturated['dinner'][$j];
																		$polyunsaturated+=$arr_polyunsaturated['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
																	<?php 
																	if($polyunsaturated > 0)
																		echo $polyunsaturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$polyunsaturated = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_polyunsaturated_linoleic['dinner'][$j] != '' )
																	{
																		echo $arr_polyunsaturated_linoleic['dinner'][$j];
																		$polyunsaturated+=$arr_polyunsaturated_linoleic['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($polyunsaturated > 0)
																		echo $polyunsaturated;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$alphalinoleic = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_polyunsaturated_alphalinoleic['dinner'][$j] != '' )
																	{
																		echo $arr_polyunsaturated_alphalinoleic['dinner'][$j];
																		$alphalinoleic+=$arr_polyunsaturated_alphalinoleic['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($alphalinoleic > 0)
																		echo $alphalinoleic;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$cholesterol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_cholesterol['dinner'][$j] != '' )
																	{
																		echo $arr_cholesterol['dinner'][$j];
																		$cholesterol+=$arr_cholesterol['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cholesterol > 0)
																		echo $cholesterol;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$dietary_fiber = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_dietary_fiber['dinner'][$j] != '' )
																	{
																		echo $arr_total_dietary_fiber['dinner'][$j];
																		$dietary_fiber+=$arr_total_dietary_fiber['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($dietary_fiber > 0)
																		echo $dietary_fiber;
																	else
																		echo '&nbsp;';
																	?>
                                                                    </td>
																</tr>
																<tr>
																<?php
																$carbohydrate = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_carbohydrate['dinner'][$j] != '' )
																	{
																		echo $arr_carbohydrate['dinner'][$j];
																		$carbohydrate+=$arr_carbohydrate['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($carbohydrate > 0)
																		echo $carbohydrate;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glucose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_glucose['dinner'][$j] != '' )
																	{
																		echo $arr_glucose['dinner'][$j];
																		$glucose+=$arr_glucose['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glucose > 0)
																		echo $glucose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$fructose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td  align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_fructose['dinner'][$j] != '' )
																	{
																		echo $arr_fructose['dinner'][$j];
																		$fructose+=$arr_fructose['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	
                                                                    </td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($fructose > 0)
																		echo $fructose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$galactose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_galactose['dinner'][$j] != '' )
																	{
																		echo $arr_galactose['dinner'][$j];
																		$galactose+=$arr_galactose['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($galactose > 0)
																		echo $galactose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$disaccharide = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_disaccharide['dinner'][$j] != '' )
																	{
																		echo $arr_disaccharide['dinner'][$j];
																		$disaccharide+=$arr_disaccharide['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($disaccharide > 0)
																		echo $disaccharide;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$maltose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_maltose['dinner'][$j] != '' )
																	{
																		echo $arr_maltose['dinner'][$j];
																		$maltose+=$arr_maltose['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($maltose > 0)
																		echo $maltose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$lactose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_lactose['dinner'][$j] != '' )
																	{
																		echo $arr_lactose['dinner'][$j];
																		$lactose+=$arr_lactose['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($lactose > 0)
																		echo $lactose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sucrose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_sucrose['dinner'][$j] != '' )
																	{
																		echo $arr_sucrose['dinner'][$j];
																		$sucrose+=$arr_sucrose['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sucrose > 0)
																		echo $sucrose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$polysaccharide = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_total_polysaccharide['dinner'][$j] != '' )
																	{
																		echo $arr_total_polysaccharide['dinner'][$j];
																		$polysaccharide+=$arr_total_polysaccharide['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($polysaccharide > 0)
																		echo $polysaccharide;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$starch = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF">
																	<?php
																	if($arr_starch['dinner'][$j] != '' )
																	{
																		echo $arr_starch['dinner'][$j];
																		$starch+=$arr_starch['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?>																	</td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($starch > 0)
																		echo $starch;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cellulose = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cellulose['dinner'][$j] != '' )
																	{
																		echo $arr_cellulose['dinner'][$j];
																		$cellulose+=$arr_cellulose['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cellulose > 0)
																		echo $cellulose;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glycogen = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_glycogen['dinner'][$j] != '' )
																	{
																		echo $arr_glycogen['dinner'][$j];
																		$glycogen+=$arr_glycogen['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glycogen > 0)
																		echo $glycogen;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$dextrins = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_dextrins['dinner'][$j] != '' )
																	{
																		echo $arr_dextrins['dinner'][$j];
																		$dextrins+=$arr_dextrins['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($dextrins > 0)
																		echo $dextrins;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sugar = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sugar['dinner'][$j] != '' )
																	{
																		echo $arr_sugar['dinner'][$j];
																		$sugar+=$arr_sugar['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sugar > 0)
																		echo $sugar;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_vitamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_vitamin['dinner'][$j] != '' )
																	{
																		echo $arr_total_vitamin['dinner'][$j];
																		$total_vitamin+=$arr_total_vitamin['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_vitamin > 0)
																		echo $total_vitamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$vitamin_a_acetate = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_vitamin_a_acetate['dinner'][$j] != '' )
																	{
																		echo $arr_vitamin_a_acetate['dinner'][$j];
																		$vitamin_a_acetate+=$arr_vitamin_a_acetate['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($vitamin_a_acetate > 0)
																		echo $vitamin_a_acetate;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$vitamin_a_retinol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_vitamin_a_retinol['dinner'][$j] != '' )
																	{
																		echo $arr_vitamin_a_retinol['dinner'][$j];
																		$vitamin_a_retinol+=$arr_vitamin_a_retinol['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($vitamin_a_retinol > 0)
																		echo $vitamin_a_retinol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_vitamin_b_complex = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_vitamin_b_complex['dinner'][$j] != '' )
																	{
																		echo $arr_total_vitamin_b_complex['dinner'][$j];
																		$total_vitamin_b_complex+=$arr_total_vitamin_b_complex['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_vitamin_b_complex > 0)
																		echo $total_vitamin_b_complex;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$thiamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_thiamin['dinner'][$j] != '' )
																	{
																		echo $arr_thiamin['dinner'][$j];
																		$thiamin+=$arr_thiamin['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($thiamin > 0)
																		echo $thiamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$riboflavin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_riboflavin['dinner'][$j] != '' )

																	{
																		echo $arr_riboflavin['dinner'][$j];
																		$riboflavin+=$arr_riboflavin['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($riboflavin > 0)
																		echo $riboflavin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr height="50px">
																<?php
																$niacin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td height="52" align="center" valign="middle" bgcolor="#FFFFFF"><?php
																	if($arr_niacin['dinner'][$j] != '' )
																	{
																		echo $arr_niacin['dinner'][$j];
																		$niacin+=$$arr_niacin['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($niacin > 0)
																		echo $niacin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$pantothenic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_pantothenic_acid['dinner'][$j] != '' )
																	{
																		echo $arr_pantothenic_acid['dinner'][$j];
																		$pantothenic_acid+=$arr_pantothenic_acid['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($pantothenic_acid > 0)
																		echo $pantothenic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$pyridoxine_hcl = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_pyridoxine_hcl['dinner'][$j] != '' )
																	{
																		echo $arr_pyridoxine_hcl['dinner'][$j];
																		$pyridoxine_hcl+=$arr_pyridoxine_hcl['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($pyridoxine_hcl > 0)
																		echo $pyridoxine_hcl;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cyanocobalamin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cyanocobalamin['dinner'][$j] != '' )
																	{
																		echo $arr_cyanocobalamin['dinner'][$j];
																		$cyanocobalamin+=$arr_cyanocobalamin['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cyanocobalamin > 0)
																		echo $cyanocobalamin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$folic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_folic_acid['dinner'][$j] != '' )
																	{
																		echo $arr_folic_acid['dinner'][$j];
																		$folic_acid+=$arr_folic_acid['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($folic_acid > 0)
																		echo $folic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$biotin = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_biotin['dinner'][$j] != '' )
																	{
																		echo $arr_biotin['dinner'][$j];
																		$biotin+=$arr_biotin['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($biotin > 0)
																		echo $biotin;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$ascorbic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_ascorbic_acid['dinner'][$j] != '' )
																	{
																		echo $arr_ascorbic_acid['dinner'][$j];
																		$ascorbic_acid+=$arr_ascorbic_acid['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($ascorbic_acid > 0)
																		echo $ascorbic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$calciferol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_calciferol['dinner'][$j] != '' )
																	{
																		echo $arr_calciferol['dinner'][$j];
																		$calciferol+=$arr_calciferol['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($calciferol > 0)
																		echo $calciferol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tocopherol = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tocopherol['dinner'][$j] != '' )
																	{
																		echo $arr_tocopherol['dinner'][$j];
																		$tocopherol+=$arr_tocopherol['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tocopherol > 0)
																		echo $tocopherol;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phylloquinone = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phylloquinone['dinner'][$j] != '' )
																	{
																		echo $arr_phylloquinone['dinner'][$j];
																		$phylloquinone+=$arr_phylloquinone['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phylloquinone > 0)
																		echo $phylloquinone;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$protein = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_protein['dinner'][$j] != '' )
																	{
																		echo $arr_protein['dinner'][$j];
																		$protein+=$arr_protein['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($protein > 0)
																		echo $protein;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$alanine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_alanine['dinner'][$j] != '' )
																	{
																		echo $arr_alanine['dinner'][$j];
																		$alanine+=$arr_alanine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($alanine > 0)
																		echo $alanine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$arginine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_arginine['dinner'][$j] != '' )
																	{
																		echo $arr_arginine['dinner'][$j];
																		$arginine+=$arr_arginine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($arginine > 0)
																		echo $arginine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$aspartic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_aspartic_acid['dinner'][$j] != '' )
																	{
																		echo $arr_aspartic_acid['dinner'][$j];
																		$aspartic_acid+=$arr_aspartic_acid['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($aspartic_acid > 0)
																		echo $aspartic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$cystine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_cystine['dinner'][$j] != '' )
																	{
																		echo $arr_cystine['dinner'][$j];
																		$cystine+=$arr_cystine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($cystine > 0)
																		echo $cystine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$giutamic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_giutamic_acid['dinner'][$j] != '' )
																	{
																		echo $arr_giutamic_acid['dinner'][$j];
																		$giutamic_acid+=$arr_giutamic_acid['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($giutamic_acid > 0)
																		echo $giutamic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glycine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_glycine['dinner'][$j] != '' )
																	{
																		echo $arr_glycine['dinner'][$j];
																		$glycine+=$arr_glycine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glycine > 0)
																		echo $glycine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$histidine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_histidine['dinner'][$j] != '' )
																	{
																		echo $arr_histidine['dinner'][$j];
																		$histidine+=$arr_histidine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($histidine > 0)
																		echo $histidine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$glutamic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_hydroxy_glutamic_acid['dinner'][$j] != '' )
																	{
																		echo $arr_hydroxy_glutamic_acid['dinner'][$j];
																		$glutamic_acid+=$arr_hydroxy_glutamic_acid['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($glutamic_acid > 0)
																		echo $glutamic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$hydroxy_proline = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_hydroxy_proline['dinner'][$j] != '' )
																	{
																		echo $arr_hydroxy_proline['dinner'][$j];
																		$hydroxy_proline+=$arr_hydroxy_proline['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($hydroxy_proline > 0)
																		echo $hydroxy_proline;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iodogorgoic_acid = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iodogorgoic_acid['dinner'][$j] != '' )
																	{
																		echo $arr_iodogorgoic_acid['dinner'][$j];
																		$iodogorgoic_acid+=$arr_iodogorgoic_acid['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iodogorgoic_acid > 0)
																		echo $iodogorgoic_acid;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$isoleucine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_isoleucine['dinner'][$j] != '' )
																	{
																		echo $arr_isoleucine['dinner'][$j];
																		$isoleucine+=$arr_isoleucine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($isoleucine > 0)
																		echo $isoleucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$leucine= 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_leucine['dinner'][$j] != '' )
																	{
																		echo $arr_leucine['dinner'][$j];
																		$leucine+=$arr_leucine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($leucine > 0)
																		echo $leucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$lysine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_lysine['dinner'][$j] != '' )
																	{
																		echo $arr_lysine['dinner'][$j];
																		$lysine+=$arr_lysine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($lysine > 0)
																		echo $lysine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$methionine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_methionine['dinner'][$j] != '' )
																	{
																		echo $arr_methionine['dinner'][$j];
																		$methionine+=$arr_methionine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($methionine > 0)
																		echo $methionine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$norleucine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_norleucine['dinner'][$j] != '' )
																	{
																		echo $arr_norleucine['dinner'][$j];
																		$norleucine+=$arr_norleucine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($norleucine > 0)
																		echo $norleucine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phenylalanine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phenylalanine['dinner'][$j] != '' )
																	{
																		echo $arr_phenylalanine['dinner'][$j];
																		$phenylalanine+=$arr_phenylalanine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phenylalanine > 0)
																		echo $phenylalanine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$proline = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_proline['dinner'][$j] != '' )
																	{
																		echo $arr_proline['dinner'][$j];
																		$proline+=$arr_proline['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($proline > 0)
																		echo $proline;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$serine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_serine['dinner'][$j] != '' )
																	{
																		echo $arr_serine['dinner'][$j];
																		$serine+=$arr_serine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($serine > 0)
																		echo $serine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$threonine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_threonine['dinner'][$j] != '' )
																	{
																		echo $arr_threonine['dinner'][$j];
																		$threonine+=$arr_threonine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($threonine > 0)
																		echo $threonine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$thyroxine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_thyroxine['dinner'][$j] != '' )
																	{
																		echo $arr_thyroxine['dinner'][$j];
																		$thyroxine+=$arr_thyroxine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($thyroxine > 0)
																		echo $thyroxine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tryptophane = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tryptophane['dinner'][$j] != '' )
																	{
																		echo $arr_tryptophane['dinner'][$j];
																		$tryptophane+=$arr_tryptophane['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tryptophane > 0)
																		echo $tryptophane;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$tyrosine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_tyrosine['dinner'][$j] != '' )
																	{
																		echo $arr_tyrosine['dinner'][$j];
																		$tyrosine+=$arr_tyrosine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($tyrosine > 0)
																		echo $tyrosine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$valine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_valine['dinner'][$j] != '' )
																	{
																		echo $arr_valine['dinner'][$j];
																		$valine+=$arr_valine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($valine > 0)
																		echo $valine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$total_minerals = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_total_minerals['dinner'][$j] != '' )
																	{
																		echo $arr_total_minerals['dinner'][$j];
																		$total_minerals+=$arr_total_minerals['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($total_minerals > 0)
																		echo $total_minerals;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$calcium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_calcium['dinner'][$j] != '' )
																	{
																		echo $arr_calcium['dinner'][$j];
																		$calcium+=$arr_calcium['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($calcium > 0)
																		echo $calcium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iron = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iron['dinner'][$j] != '' )
																	{
																		echo $arr_iron['dinner'][$j];
																		$iron+=$arr_iron['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iron > 0)
																		echo $iron;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$potassium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_potassium['dinner'][$j] != '' )
																	{
																		echo $arr_potassium['dinner'][$j];
																		$potassium+=$arr_potassium['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($potassium > 0)
																		echo $potassium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sodium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sodium['dinner'][$j] != '' )
																	{
																		echo $arr_sodium['dinner'][$j];
																		$sodium+=$arr_sodium['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sodium > 0)
																		echo $sodium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$phosphorus = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_phosphorus['dinner'][$j] != '' )
																	{
																		echo $arr_phosphorus['dinner'][$j];
																		$phosphorus+=$arr_phosphorus['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($phosphorus > 0)
																		echo $phosphorus;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$sulphur = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_sulphur['dinner'][$j] != '' )
																	{
																		echo $arr_sulphur['dinner'][$j];
																		$sulphur+=$arr_sulphur['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($sulphur > 0)
																		echo $sulphur;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$chlorine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_chlorine['dinner'][$j] != '' )
																	{
																		echo $arr_chlorine['dinner'][$j];
																		$chlorine+=$arr_chlorine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($chlorine > 0)
																		echo $chlorine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$iodine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_iodine['dinner'][$j] != '' )
																	{
																		echo $arr_iodine['dinner'][$j];
																		$iodine+=$arr_iodine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($iodine > 0)
																		echo $iodine;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$magnesium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_magnesium['dinner'][$j] != '' )
																	{
																		echo $arr_magnesium['dinner'][$j];
																		$magnesium+=$arr_magnesium['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($magnesium > 0)
																		echo $magnesium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$zinc = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_zinc['dinner'][$j] != '' )
																	{
																		echo $arr_zinc['dinner'][$j];
																		$zinc+=$arr_zinc['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($zinc > 0)
																		echo $zinc;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$copper = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_copper['dinner'][$j] != '' )

																	{
																		echo $arr_copper['dinner'][$j];
																		$copper+=$arr_copper['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($copper > 0)
																		echo $copper;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
                                                                <tr>
																<?php
																$chromium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_chromium['dinner'][$j] != '' )
																	{
																		echo $arr_chromium['dinner'][$j];
																		$chromium+=$arr_chromium['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($chromium > 0)
																		echo $chromium;
																	else
																		echo '&nbsp;';
																	?></td>
                                                                </tr>
                                                                <tr>
																<?php
																$manganese = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_manganese['dinner'][$j] != '' )
																	{
																		echo $arr_manganese['dinner'][$j];
																		$manganese+=$arr_manganese['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($manganese > 0)
																		echo $manganese;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$selenium = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_selenium['dinner'][$j] != '' )
																	{
																		echo $arr_selenium['dinner'][$j];
																		$selenium+=$arr_selenium['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($selenium > 0)
																		echo $selenium;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$boron = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_boron['dinner'][$j] != '' )
																	{
																		echo $arr_boron['dinner'][$j];
																		$boron+=$arr_boron['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($boron > 0)
																		echo $boron;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$molybdenum = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_molybdenum['dinner'][$j] != '' )
																	{
																		echo $arr_molybdenum['dinner'][$j];
																		$molybdenum+=$arr_molybdenum['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($molybdenum > 0)
																		echo $molybdenum;
																	else
																		echo '&nbsp;';
																	?></td>
																</tr>
																<tr>
																<?php
																$caffeine = 0;
																for($j=0,$i=1;$j<count($arr_meal_time['dinner']);$j++,$i++)
																{ ?>
																	<td align="center" valign="top" bgcolor="#FFFFFF"><?php
																	if($arr_caffeine['dinner'][$j] != '' )
																	{
																		echo $arr_caffeine['dinner'][$j];
																		$caffeine+=$arr_caffeine['dinner'][$j];
																	}
																	else
																	{
																		echo '&nbsp;';
																	}?></td>
																<?php
																} ?>
																	<td width="54" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;
                                                                    <?php 
																	if($caffeine > 0)
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
                                                } ?>
                                                
												
                                                <?php
												if($show_pdf_button)
                                                { ?> 
                                                <table width="920" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="left">
                                                            <form action="#" method="post" name="frmpdfreports" id="frmpdfreports">
                                                                <input type="hidden" name="hdnuser_id" id="hdnhdnuser_id" value="<?php echo $user_id;?>" />
                                                                <input type="hidden" name="hdnstart_date" id="hdnstart_date" value="<?php echo $start_date;?>" />
                                                                <input type="hidden" name="hdnend_date" id="hdnend_date" value="<?php echo $end_date;?>" />
                                                                <input type="hidden" name="hdndate" id="hdndate" value="<?php echo $date;?>" />
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
											}
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
</body>
</html>