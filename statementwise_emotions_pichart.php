<?php
ini_set("memory_limit","200M");

if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };

@set_time_limit(1000000);

include('config.php');

$page_id = '57';

list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);



$ref = base64_encode('statementwise_emotions_pichart.php');

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

if(chkUserPlanFeaturePermission($user_id,'14'))
{
	$statementwise_emotions_pi_report = 1;
}
else
{
	$statementwise_emotions_pi_report = 0;
}



$return = false;



$error = false;

$tr_err_date = 'none';

$err_date = '';



if(isset($_POST['btnSubmit']))	

{

	$start_date = strip_tags(trim($_POST['start_date']));
	$end_date = strip_tags(trim($_POST['end_date']));

	

	$wae_report = trim($_POST['wae_report']);

	$gs_report = trim($_POST['gs_report']);

	$sleep_report = trim($_POST['sleep_report']);

	$mc_report = trim($_POST['mc_report']);

	$mr_report = trim($_POST['mr_report']);

	$mle_report = trim($_POST['mle_report']);

	$adct_report = trim($_POST['adct_report']);

	

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
	

	if( ($wae_report == '') && ($gs_report == '') && ($sleep_report == '') && ($mc_report == '') && ($mr_report == '') && ($mle_report == '') && ($adct_report == '') )

	{

		$error = true;

		if($tr_err_date == 'none')

		{

			$tr_err_date = '';

			$err_date = 'Please select atleast one report type';

		}

		else

		{

			$err_date .= '<br>Please select atleast one report type';

		}

	}

	

	if(!$error)
	{

		$temp_permission_type = '0';
		$temp_pro_user_id = '0';
		
		$start_date = date('Y-m-d',strtotime($start_date));
		$end_date = date('Y-m-d',strtotime($end_date));	
		
		list($wae_return,$arr_wae_records,$gs_return,$arr_gs_records,$sleep_return,$arr_sleep_records,$mc_return,$arr_mc_records,$mr_return,$arr_mr_records,$mle_return,$arr_mle_records,$adct_return,$arr_adct_records) = getStatementwiseEmotionsReport($user_id,$start_date,$end_date,$temp_permission_type,$temp_pro_user_id);

		if( (!$wae_return) && (!$gs_return) && (!$sleep_return) && (!$mc_return) && (!$mr_return) && (!$mle_return) && (!$adct_return) )

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

	

	$wae_report = trim($_POST['hdnwae_report']);

	$gs_report = trim($_POST['hdngs_report']);

	$sleep_report = trim($_POST['hdnsleep_report']);

	$mc_report = trim($_POST['hdnmc_report']);

	$mr_report = trim($_POST['hdnmr_report']);

	$mle_report = trim($_POST['hdnmle_report']);

	$adct_report = trim($_POST['hdnadct_report']);


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

	

	if( ($wae_report == '') && ($gs_report == '') && ($sleep_report == '') && ($mc_report == '') && ($mr_report == '') && ($mle_report == '') && ($adct_report == '') )

	{

		$error = true;

		if($tr_err_date == 'none')

		{

			$tr_err_date = '';

			$err_date = 'Please select atleast one report type';

		}

		else

		{

			$err_date .= '<br>Please select atleast one report type';

		}

	}

	

	if(!$error)

	{
		$temp_permission_type = '0';
		$temp_pro_user_id = '0';
		
		$start_date = date('Y-m-d',strtotime($start_date));
		$end_date = date('Y-m-d',strtotime($end_date));

		list($wae_return,$arr_wae_records,$gs_return,$arr_gs_records,$sleep_return,$arr_sleep_records,$mc_return,$arr_mc_records,$mr_return,$arr_mr_records,$mle_return,$arr_mle_records,$adct_return,$arr_adct_records) = getStatementwiseEmotionsReport($user_id,$start_date,$end_date,$temp_permission_type,$temp_pro_user_id);

		if( (!$wae_return) && (!$gs_return) && (!$sleep_return) && (!$mc_return) && (!$mr_return) && (!$mle_return) && (!$adct_return) )

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

	$error = true;

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="description" content="<?php echo $meta_description;?>" />

	<meta name="keywords" content="<?php echo $meta_keywords;?>" />

	<meta name="title" content="<?php echo $meta_title;?>" />

	<title><?php echo $meta_title;?></title>

	<link href="cwri.css" rel="stylesheet" type="text/css" />
<link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>

	<script type="text/JavaScript" src="js/commonfn.js"></script>

	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

	<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

	

	<script type="text/javascript" src="js/jquery.min.js"></script>

    <script type="text/javascript" src="js/jquery.jqplot.min.js"></script>

    <script type="text/javascript" src="js/jquery.jqplot.min.js"></script>

    <script type="text/javascript" src="js/jqplot.barRenderer.min.js"></script>

    <script type="text/javascript" src="js/jqplot.pieRenderer.min.js"></script>

    <script type="text/javascript" src="js/jqplot.categoryAxisRenderer.min.js"></script>

    <script type="text/javascript" src="js/jqplot.pointLabels.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/jquery.jqplot.min.css" />
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

<?php //include_once('analyticstracking.php'); ?>

<?php include_once('analyticstracking_ci.php'); ?>

<?php include_once('analyticstracking_y.php'); ?>

<header> 
<?php include 'topbar.php'; ?>
<?php include_once('header.php');?> 
</header>
<div class="container">  
    <div class="breadcrumb">
                    <div class="row">
                    <div class=" col-md-8">
                      <?php echo getBreadcrumbCode($page_id);?> 
                       </div>
                       <div class=" col-md-4">
                     
                       </div>
                       
                       </div>
                </div>
            </div>
<!--container-->
 <div class="container">
       <div class="row">
            <div class=" col-md-12">

						<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">

							<tr>

								<td align="center" valign="top" bgcolor="#FFFFFF">

									<table width="100%" border="0" cellspacing="0" cellpadding="0" id="my_tbl">

										<tr>

											<td height="200" align="center" valign="top" class="mainnav">

                                            <?php 

											if($statementwise_emotions_pi_report == 1 ) 

											{ ?>

												<form action="#" id="frmactivity" method="post" name="frmactivity">

												<table width="980" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td width="80" height="45" align="left" valign="middle" class="Header_brown">Start Date:</td>

														<td width="240" align="left" valign="middle">

															<input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" class="form-control" />
                                    						<script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>

														</td>
														<td width="80" align="left" valign="middle" class="Header_brown">&nbsp;</td>

														<td width="80" height="45" align="left" valign="middle" class="Header_brown">End Date:</td>

														<td width="240" align="left" valign="middle">

															<input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" class="form-control" />
                                    						<script>$('#end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>

														</td>

														<td width="260" height="45" align="left" valign="middle"><input type="submit" name="btnSubmit" id="btnSubmit" value="View Report" /></td>

													</tr>

												</table>
                                                <br/>

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

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

												</form>

												<?php

                                                if(!$error)

                                                {?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="report">

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

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="report">

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

											if( ($wae_return) && ($wae_report == '1') )

											{ ?>

												<table width="100%" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="100%" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Work & Environment</td>

													</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<?php

												$l=0;

												foreach($arr_wae_records as $k => $v)

												{ ?>

												<table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getWAESituation($k); ?></td>	</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >

													<tr><td>

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

													    $temp1=$temp1*72;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*50;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*33;

													   }

													   else

													   {

													    $temp1=$temp1*29;

													   }  

													?>

													<div id="wae<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div>

														</td>

														</tr>



												</table>	

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>		

												

												<?php

												$l++;

												}?>

													

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

											

											<?php

											if( ($gs_return) && ($gs_report == '1') )

											{ ?>

												<table width="100%" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="100%" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;General Stressors</td>

													</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												$l=0;

												foreach($arr_gs_records as $k => $v)

												{ ?>

												<table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getGSSituation($k); ?></td>	</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

													<tr><td>

														<script  language="javascript">

													  $(document).ready(function(){

															plot5 = $.jqplot('gs<?php print $l; ?>', 

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

													    $temp1=$temp1*72;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*50;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*33;

													   }

													   else

													   {

													    $temp1=$temp1*29;

													   }  

													?>

													<div id="gs<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div>

														</td>

														</tr>

												</table>	

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>		

												<?php

												$l++;

												}?>

													

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

											

											<?php

											if( ($sleep_return) && ($sleep_report == '1') )

											{ ?>

												<table width="100%" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="100%" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Sleep</td>

													</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												$l=0;

												foreach($arr_sleep_records as $k => $v)

												{ ?>

												<table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getSleepSituation($k); ?></td>	</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>



												</table>

												<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >

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

													    $temp1=$temp1*72;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*50;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*33;

													   }

													   else

													   {

													    $temp1=$temp1*29;

													   }  

													?>

													<div id="sleep<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div>

														</td>

														</tr>

												</table>	

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>		

												

												<?php

												$l++;

												}?>

													

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

											

											<?php

											if( ($mc_return) && ($mc_report == '1') )

											{ ?>

												<table width="100%" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="100%" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;My Communication</td>

													</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												$l=0;

												foreach($arr_mc_records as $k => $v)

												{ ?>

												<table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getMCSituation($k); ?></td>	</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

													<tr><td>

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

													    $temp1=$temp1*72;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*50;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*33;

													   }

													   else

													   {

													    $temp1=$temp1*29;

													   }  

													?>

													<div id="mc<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div>

														</td>

														</tr>

												</table>	

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>


														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>		

												

												<?php

												$l++;

												}?>

													

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

											

											<?php

											if( ($mr_return) && ($mr_report == '1') )

											{ ?>

												<table width="100%" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="100%" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;My Relations</td>

													</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												$l=0;

												foreach($arr_mr_records as $k => $v)

												{ ?>

												<table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getMRSituation($k); ?></td>	</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

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

													    $temp1=$temp1*72;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*50;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*33;

													   }

													   else

													   {

													    $temp1=$temp1*29;

													   }  

													?>

													<div id="mr<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div>

														</td>

														</tr>

												</table>	

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>



												</table>		

												

												<?php

												$l++;

												}?>

													

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

											

											<?php

											if( ($mle_return) && ($mle_report == '1') )

											{ ?>

												<table width="100%" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="100%" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Major Life Events</td>

													</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												$l=0;

												foreach($arr_mle_records as $k => $v)

												{ ?>

												<table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getMLESituation($k); ?></td>	

													</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >

													<tr><td>

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

													    $temp1=$temp1*72;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*50;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*33;

													   }

													   else

													   {

													    $temp1=$temp1*29;

													   }  

													?>

													<div id="mle<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div>

														</td>

														</tr>

												</table>	

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>		

												

												<?php

												$l++;

												}?>

													

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

											<?php

											} ?>

											

											<?php

											if( ($adct_return) && ($adct_report == '1') )

											{ ?>

												<table width="100%" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td>&nbsp;</td>

														<td>&nbsp;</td>

													</tr>

												</table>

												<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="100%" height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;Addictions</td>

													</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												

												<?php

												$l=0;

												foreach($arr_adct_records as $k => $v)

												{ ?>

												<table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

													<tr>

														<td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

														<td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getADCTSituation($k); ?></td>	

													</tr>

												</table>

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

												<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ffffff">

													<tr><td>

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

													    $temp1=$temp1*72;

													   }

													   elseif($temp1>1 && $temp1<3)

													   {

													    $temp1=$temp1*50;

													   }

													   elseif($temp1>2 && $temp1<4)

													   {

													    $temp1=$temp1*45;

													   }

													   elseif($temp1>3 && $temp1<5)

													   {

													    $temp1=$temp1*40;

													   }

													   elseif($temp1>4 && $temp1<6)

													   {

													    $temp1=$temp1*36;

													   }

													   elseif($temp1>5 && $temp1<7)

													   {

													    $temp1=$temp1*34;

													   }

													   elseif($temp1>6 && $temp1<20)

													   {

													    $temp1=$temp1*33;

													   }

													   else

													   {

													    $temp1=$temp1*29;

													   }  

													?>

													<div id="add<?php print $l; ?>" style="height:<?php echo $temp1;?>px;width:920px;"></div>

														</td>

														</tr>

												</table>	

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>		

												

												<?php

												$l++;

												}?>

													

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

                                            <?php

											} ?>

														

												<table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td align="left">

                                                        </td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

													</tr>

												</table>

                                            <?php 

											} 

											else 

											{ ?>

                                            	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

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


     </div>
    </div>
 </div>
            <!--container end -->
           
           
           <!--footer -->         
              <footer>
    <div class="container">
                    <div class="row">
                    <div class="col-lg-12">	
     <?php include_once('footer.php');?>
    </div></div></div>
  </footer>    
      <!--footer end -->         
          
       
<!-- Bootstrap Core JavaScript -->
<!-- <script src="csswell/js/jquery.min.js"></script>-->       
<script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 			

 

</body>

</html>