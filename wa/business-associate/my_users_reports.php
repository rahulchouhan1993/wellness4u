<?php

require_once ('../classes/config.php');

require_once ('../classes/vendor.php');

$page_id = '101';

list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);



$ref = base64_encode($menu_link);



if(!isLoggedInPro())

{

    header("Location: ".SITE_URL."/prof_login.php?ref=".$ref);

    exit(0);

}

else

{

    doUpdateOnlinePro($_SESSION['pro_user_id']);

    $pro_user_id = $_SESSION['pro_user_id'];

}



if(chkAdviserPlanFeaturePermission($pro_user_id,'26'))

{

    $page_access = true;

}

else

{

    $page_access = false;

}





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



if(isset($_POST['btnSubmit']))	

{

    $user_id = strip_tags(trim($_POST['user_id']));

    $date_type = strip_tags(trim($_POST['date_type']));

    $start_date = strip_tags(trim($_POST['start_date']));

    $end_date = strip_tags(trim($_POST['end_date']));

    $single_date = strip_tags(trim($_POST['single_date']));

    $start_month = strip_tags(trim($_POST['start_month']));

    $start_year = strip_tags(trim($_POST['start_year']));



    $report_module = trim($_POST['report_module']);

    $user_set_id = trim($_POST['user_set_id']);

    $module_keyword = trim($_POST['module_keyword']);

    $module_criteria = trim($_POST['module_criteria']);



    $scale_range = trim($_POST['scale_range']);

    $start_scale_value= trim($_POST['start_scale_value']);

    $end_scale_value= trim($_POST['end_scale_value']);



    $criteria_scale_range = trim($_POST['criteria_scale_range']);

    $start_criteria_scale_value= trim($_POST['start_criteria_scale_value']);

    $end_criteria_scale_value= trim($_POST['end_criteria_scale_value']);

    

    if($module_criteria == '9')

    {

        $trigger_criteria = trim($_POST['trigger_criteria']);

    }

    else

    {

       $trigger_criteria = ''; 

    }

    

    if($date_type == 'date_range')

    {

        $tbldaterange = '';

        $tblsingledate = 'none';

        $tblmonthdate = 'none';



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

    }

    elseif($date_type == 'single_date')

    {

        $tbldaterange = 'none';

        $tblsingledate = '';

        $tblmonthdate = 'none';



        $start_date = $single_date;

        $end_date = $single_date;



        if($single_date == '')

        {

            $error = true;

            $tr_err_date = '';

            $err_date = 'Please select date';

        }

    }

    elseif($date_type == 'month_wise')

    {

        $tbldaterange = 'none';

        $tblsingledate = 'none';

        $tblmonthdate = '';



        $start_date = $start_year.'-'.$start_month.'-01';



        $end_month = $start_month;	

        $end_year = $start_year;

        $end_day = date('t',strtotime($start_date));	



        $end_date = $end_year.'-'.$end_month.'-'.$end_day;

    }



    if($scale_range == '')

    {

        $div_start_scale_value = 'none';

        $div_end_scale_value = 'none';

        $start_scale_value = '';

        $end_scale_value = '';

    }

    elseif($scale_range == '6')

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



    if($criteria_scale_range == '')

    {

        $div_start_criteria_scale_value = 'none';

        $div_end_criteria_scale_value = 'none';

        $start_criteria_scale_value = '';

        $end_criteria_scale_value = '';

    }

    elseif($criteria_scale_range == '6')

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



    if($report_module == '' || $report_module == 'food_report' || $report_module == '1' || $report_module == 'activity_report' || $report_module == '14'  || $report_module == 'bps_report' || $report_module == '22' || $report_module == 'activity_analysis_report' || $report_module == 'meal_time_report' || $report_module == '4' )

    {

        $idscaleshow = 'none'; 

    }

    else

    {

        $idscaleshow = ''; 

    }



    if($module_criteria == '')

    {

        $idcriteriascaleshow = 'none'; 

    }

    else

    {

        $idcriteriascaleshow = ''; 

        

        if($module_criteria == '9')

        {

            $spntriggercriteria = '';

        }

    }

    

    if($user_id == '')

    {

        $error = true;

        $tr_err_date = '';

        $err_date .= '<br>Please select user';

    }

    

    if($report_module == '')

    {

        $error = true;

        $tr_err_date = '';

        $err_date .= '<br>Please select report module';

    }

    

    if($user_set_id == '')

    {

        $error = true;

        $tr_err_date = '';

        $err_date .= '<br>Please select user set';

    }



    if(!$error)

    {

        //echo '<br>111111111111111111111111111';

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

            $temp_pro_user_id = $pro_user_id;

        }

        



        $start_date = date('Y-m-d',strtotime($start_date));

        $end_date = date('Y-m-d',strtotime($end_date));	

        list($food_return,$arr_meal_date,$arr_food_records,$activity_return,$arr_activity_date,$arr_activity_records,$wae_return,$arr_wae_date,$arr_wae_records,$gs_return,$arr_gs_date,$arr_gs_records,$sleep_return,$arr_sleep_date,$arr_sleep_records,$mc_return,$arr_mc_date,$arr_mc_records,$mr_return,$arr_mr_date,$arr_mr_records,$mle_return,$arr_mle_date,$arr_mle_records,$adct_return,$arr_adct_date,$arr_adct_records,$bps_return,$arr_bps_date,$arr_bps_records,$bes_return,$arr_bes_date,$arr_bes_records,$aa_return,$arr_aa_records,$mt_return,$arr_mt_records,$mdt_return,$arr_mdt_date,$arr_mdt_records) = getDigitalPersonalWellnessDiary($user_id,$start_date,$end_date,$temp_permission_type,$temp_pro_user_id,$scale_range,$start_scale_value,$end_scale_value,$report_module,$module_keyword,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value);



        if( $food_return || $activity_return || $wae_return || $gs_return || $sleep_return || $mc_return || $mr_return || $mle_return || $adct_return || $bps_return || $bes_return || $aa_return || $mt_return || $mdt_return) 

        {

            $show_pdf_button = true;

        }



        if( (!$food_return) && (!$activity_return) && (!$wae_return) && (!$gs_return) && (!$sleep_return) && (!$mc_return) && (!$mr_return) && (!$mle_return) && (!$adct_return) && (!$bps_return) && (!$bes_return)  && (!$aa_return) && (!$mt_return) && (!$mdt_return) )

        {

            $error = true;

            $tr_err_date = '';

            $err_date = 'NO Data Posted by you for your above selected Query';	

        }



        $start_date = date('d-m-Y',strtotime($start_date));

        $end_date = date('d-m-Y',strtotime($end_date));

    }



    if($err_date != '')

    {

        $err_date = '<div class="err_msg_box"><span class="blink_me">'.$err_date.'</span></div>';

    }

}

else

{

    $user_id = '';

    $now = time();

    $end_date = date('d-m-Y');

    $error = true;

    $date_type = 'date_range';

    $start_month = date('m');

    $start_year = date('Y');

    $report_module = '';

    $user_set_id = '';

    $module_keyword = '';

    $module_criteria = '';

    $scale_range = '';

    $start_scale_value = '';

    $end_scale_value = '';

    $criteria_scale_range = '';

    $start_criteria_scale_value = '';

    $end_criteria_scale_value = '';

    $temp_permission_type = '';

    $temp_pro_user_id = '';

}

?><!DOCTYPE html>

<html lang="en">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="description" content="<?php echo $meta_description;?>" />

	<meta name="keywords" content="<?php echo $meta_keywords;?>" />

	<meta name="title" content="<?php echo $meta_title;?>" />

	<title><?php echo $meta_title;?></title>

	<link href="../cwri.css" rel="stylesheet" type="text/css" />

     <link href="../csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 

	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>

	<script type="text/JavaScript" src="js/commonfn.js"></script>

	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

	<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

   

    <style type="text/css">@import "css/jquery.datepick.css";</style> 

	<script type="text/javascript" src="js/jquery.datepick.js"></script>

    

    <link href="../css/ticker-style.css" rel="stylesheet" type="text/css" />

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

<!--header-->

<header>

 <?php include 'topbar.php'; ?>

<?php include_once('header.php');?>

</header>

<!--header End --> 			

<!--breadcrumb--> 

  

 <div class="container"> 

    <div class="breadcrumb">

               

                    <div class="row">

                    <div class="col-md-8">	

                      <?php echo getBreadcrumbCode($page_id);?> 

                       </div>

                         <div class="col-md-4">

                        

                         </div>

                       </div>

                </div>

            </div>

<!--breadcrumb end --> 



<!--container-->              

<div class="container" >

<div class="row">	

<div class="col-md-12">	

        

                       

                        <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">

                            <tr>

                                <td align="left" valign="top">

                                    <span class="Header_brown"><?php echo getMenuTitleOfPage($page_id);?></span><br /><br />

                                    <?php echo getPageContents($page_id);?>

                                </td>

                            </tr>

                        </table>

                        <?php

                        if($page_access)

                        { ?>

                    <table width="940" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">

                            <tr>

                            	<td width="100%" align="left" valign="middle" bgcolor="#FFFFFF">

                                    <form action="#" id="frmactivity" method="post" name="frmactivity">

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                            <tr>

                                                <td width="150" height="50" align="left" valign="middle" class="Header_brown">Date Selection Type:</td>

                                                <td width="250" align="left" valign="middle">

                                                    <select name="date_type" id="date_type" onChange="toggleDateSelectionTypeUser('date_type')"  class="form-control"  style="width:200px;" >

                                                        <option value="date_range" <?php if($date_type == 'date_range'){?> selected <?php } ?> >Date Range</option>

                                                        <option value="single_date" <?php if($date_type == 'single_date'){?> selected <?php } ?>>Single Date</option>

                                                        <option value="month_wise" <?php if($date_type == 'month_wise'){?> selected <?php } ?>>Month wise</option>

                                                    </select>

                                                </td>

                                                <td width="520" height="50" align="left" valign="middle"></td>

                                            </tr>

                                        </table>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbldaterange" style="display:<?php echo $tbldaterange;?>">

                                            <tr>

                                                <td width="150" height="50" align="left" valign="middle" class="Header_brown">Start Date:</td>

                                                <td width="250" align="left" valign="middle">

                                                    <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>"  class="form-control"  style="width:100px;" />

                                                    <script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>

                                                </td>

                                                <td width="150" height="50" align="left" valign="middle" class="Header_brown">End Date:</td>

                                                <td width="250" align="left" valign="middle">

                                                    <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>"  class="form-control"  style="width:100px;" />

                                                    <script>$('#end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>

                                                </td>

                                                <td width="120" height="50" align="left" valign="middle"></td>

                                            </tr>

                                        </table>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="tblsingledate" style="display:<?php echo $tblsingledate;?>">

                                            <tr>

                                                <td width="150" height="50" align="left" valign="middle" class="Header_brown">Date:</td>

                                                <td width="250" align="left" valign="middle">

                                                    <input name="single_date" id="single_date" type="text" value="<?php echo $single_date;?>"  class="form-control"  style="width:100px;" />

                                                    <script>$('#single_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>

                                                </td>

                                                <td width="520" height="50" align="left" valign="middle"></td>

                                            </tr>

                                        </table>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="tblmonthdate" style="display:<?php echo $tblmonthdate;?>">

                                            <tr>

                                                <td width="150" height="50" align="left" valign="middle" class="Header_brown">Month:</td>

                                                <td width="250" align="left" valign="middle">

                                                    <select name="start_month" id="start_month"  class="form-control" style="width:100px; display:inline;"  >

                                                        <?php echo getMonthOptions($start_month); ?>

                                                    </select>

                                                    <select name="start_year" id="start_year" class="form-control" style="width:100px; display:inline;">

                                                    <?php

                                                    for($i=2011;$i<=intval(date("Y"));$i++)

                                                    { ?>

                                                        <option value="<?php echo $i;?>" <?php if($start_year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>

                                                    <?php

                                                    } ?>	

                                                    </select>

                                                </td>

                                                <td width="520" height="50" align="left" valign="middle"></td>

                                            </tr>

                                        </table>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" >

                                            <tr>

                                                <td height="50" align="left" valign="middle" class="Header_brown">User:</td>

                                                <td align="left" valign="middle" >

                                                    <select name="user_id" id="user_id" class="form-control" style="width:200px;" onChange="getUserAcceptedReportsOptionsNew('<?php echo $pro_user_id;?>');getUserAcceptedReportsSetOptions('<?php echo $pro_user_id;?>');toggleScaleShow(); getModuleWiseKeywordsOptions(); getModuleWiseCriteriaOptions();resetReportForm();getUserTriggerCriteriaOptions();">

                                                    <option value="">Select User</option>

                                                    <?php echo getAdvisersUserOptions($user_id,$pro_user_id); ?>

                                                </select>

                                                </td>

                                                <td height="30" align="left" valign="middle" class="Header_brown"></td>

                                                <td align="left" valign="middle"></td>

                                                <td height="30" align="left" valign="middle">&nbsp;</td>

                                            </tr>

                                            <tr>

                                                <td width="150" height="50" align="left" valign="middle" class="Header_brown">Module:</td>

                                                <td width="250" align="left" valign="middle" id="idreporttype">

                                                    <select class="form-control" name="report_module" id="report_module" style="width:200px;" onChange="getUserAcceptedReportsSetOptions('<?php echo $pro_user_id;?>');toggleScaleShow(); getModuleWiseKeywordsOptions(); getModuleWiseCriteriaOptions(); resetReportForm();">

                                                        <option value="">Select Report</option>

                                                        <?php echo getUserAcceptedReportsOptionsNew($user_id,$pro_user_id,$report_module); ?>

                                                    </select>

                                                </td>

                                                <td width="150" height="50" align="left" valign="middle" class="Header_brown">Set:</td>

                                                <td width="250" align="left" valign="middle" id="iduserreportset">

                                                    <select class="form-control" name="user_set_id" id="user_set_id" style="width:200px;" onChange="getModuleWiseKeywordsOptions(); getModuleWiseCriteriaOptions(); ">

                                                        <option value="">Select Set</option>

                                                        <?php echo getUserAcceptedReportsSetOptions($user_id,$pro_user_id,$report_module,$user_set_id); ?>

                                                    </select>  

                                                </td>

                                                <td width="120" height="50" align="left" valign="middle">&nbsp;</td>

                                            </tr>

                                            <tr>

                                                <td height="50" align="left" valign="middle" class="Header_brown">Keyword:</td>

                                                <td align="left" valign="middle" id="tdkeywordresult">

                                                    <select name="module_keyword" id="module_keyword" class="form-control" style="width:200px;">

                                                        <option value="" <?php if($module_keyword == '') {?> selected="selected" <?php } ?>>All</option>

                                                        <?php echo getModuleWiseKeywordsOptions($user_id,$report_module,$temp_pro_user_id,$module_keyword)?>

                                                    </select>

                                                </td>

                                                <td height="30" align="left" valign="middle" class="Header_brown"></td>

                                                <td align="left" valign="middle"></td>

                                                <td height="30" align="left" valign="middle">&nbsp;</td>

                                            </tr>

                                            <tr id="idscaleshow" style="display:<?php echo $idscaleshow;?>">

                                                <td height="50" align="left" valign="middle" class="Header_brown">Keyword Scale:</td>

                                                <td align="left" valign="middle">

                                                    <select class="form-control" style="width:200px;" name="scale_range" id="scale_range" onChange="toggleScaleRangeType('scale_range','div_start_scale_value','div_end_scale_value')">

                                                        <option value="">All</option>

                                                        <option value="1" <?php if($scale_range == '1') {?> selected <?php } ?> ><(Less Than)</option>

                                                        <option value="2" <?php if($scale_range == '2') {?> selected <?php } ?> >>(Greater Than)</option>

                                                        <option value="3" <?php if($scale_range == '3') {?> selected <?php } ?> > &le; (Less than or Equal to)</option>

                                                        <option value="4" <?php if($scale_range == '4') {?> selected <?php } ?> > &ge; (Greater than or Equal to)</option>

                                                        <option value="5" <?php if($scale_range == '5') {?> selected <?php } ?> >=(Equal)</option>

                                                        <option value="6" <?php if($scale_range == '6') {?> selected <?php } ?> >Range</option>

                                                    </select>

                                                </td>

                                                <td height="50" align="left" valign="middle" class="Header_brown">Scale value:</td>

                                                <td align="left" valign="middle">

                                                    <span id="div_start_scale_value" style="display:<?php echo $div_start_scale_value;?>">

                                                    <select style="width:100px; display:inline;" name="start_scale_value" id="start_scale_value">

                                                        <?php

                                                        for($i=1;$i<=10;$i++)

                                                        { ?>

                                                        <option value="<?php echo $i;?>" <?php if($start_scale_value == $i) {?> selected <?php } ?> ><?php echo $i;?></option>

                                                        <?php

                                                        } ?>

                                                    </select>

                                                    </span>

                                                    <span id="div_end_scale_value" style="display:<?php echo $div_end_scale_value;?>">

                                                        &nbsp; - &nbsp;

                                                        <select style="width:100px; display:inline;" name="end_scale_value" id="end_scale_value">

                                                        <?php

                                                        for($i=1;$i<=10;$i++)

                                                        { ?>

                                                        <option value="<?php echo $i;?>" <?php if($end_scale_value == $i) {?> selected <?php } ?> ><?php echo $i;?></option>

                                                        <?php

                                                        } ?>

                                                    </select>

                                                    </span>

                                                </td>

                                                <td height="30" align="left" valign="middle">&nbsp;</td>

                                            </tr>

                                            <tr>

                                                <td height="50" align="left" valign="middle" class="Header_brown">Criteria:</td>

                                                <td align="left" valign="middle" id="tdcriteriaresult">

                                                    <select class="form-control" name="module_criteria" id="module_criteria" style="width:200px;" onChange="getModuleWiseCriteriaScaleOptions();getModuleWiseCriteriaScaleValues();toggleCriteriaScaleShow();">

                                                        <option value="" <?php if($module_criteria == '') {?> selected="selected" <?php } ?>>All</option>

                                                        <?php echo getModuleWiseCriteriaOptions($user_id,$report_module,$pro_user_id,$module_criteria)?>

                                                    </select>

                                                </td>

                                                <td height="30" align="left" valign="middle" class="Header_brown">

                                                    <span class="spntriggercriteria" style="display:<?php echo $spntriggercriteria;?>">Triggers:</span>

                                                </td>

                                                <td colspan="2" align="left" valign="middle">

                                                    <span id="idtriggercriteria" class="spntriggercriteria" style="display:<?php echo $spntriggercriteria;?>">

                                                        <select class="form-control" name="trigger_criteria" id="trigger_criteria" style="width:200px;">

                                                            <option value="" <?php if($trigger_criteria == '') {?> selected="selected" <?php } ?>>All</option>

                                                            <?php echo getTriggerCriteriaOptions($user_id,$trigger_criteria);?>

                                                        </select>

                                                        <br><span style="font-size:11px;color:#0000FF;">(Options displayed are only of Data Posted by User)</span>

                                                    </span>

                                                </td>

                                                

                                            </tr>

                                            <tr id="idcriteriascaleshow" style="display:<?php echo $idcriteriascaleshow;?>">

                                                <td height="50" align="left" valign="middle" class="Header_brown">Criteria Scale:</td>

                                                <td align="left" valign="middle" id="tdcriteriascalerange">

                                                    <select class="form-control" name="criteria_scale_range" id="criteria_scale_range" style="width:200px;" onChange="getModuleWiseCriteriaScaleValues();toggleScaleRangeType('criteria_scale_range','div_start_criteria_scale_value','div_end_criteria_scale_value');">

                                                        <option value="">All</option>

                                                        <?php echo getModuleWiseCriteriaScaleOptions($user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range);?>

                                                    </select>

                                                </td>

                                                <td colspan="2" align="left" valign="middle" id="idcriteriascalevalues">

                                                    <?php echo getModuleWiseCriteriaScaleValues($user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value);?>

                                                </td>

                                                <td height="30" align="left" valign="middle">&nbsp;</td>

                                            </tr>

                                        </table>

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                            <tr>

                                                <td height="50" align="left" valign="middle"><input type="submit" name="btnSubmit" id="btnSubmit" value="View Diary" class="btn btn-primary"/></td>

                                            </tr>

                                        </table>    



                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                            <tr id="tr_err_date" style="display:<?php echo $tr_err_date;?>;" valign="top">

                                                <td align="left" class="err_msg" id="err_date" valign="top"><?php echo $err_date;?></td>

                                            </tr>

                                        </table>

                                    </form>  

                                </td>

                            </tr>

                        </table>

                        <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">

                            <tr>

                            	<td class="footer" height="30">&nbsp;</td>

                            </tr>

                        </table>	

                        <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">

                            <tr>

                                <td width="100%" align="left" valign="top">

                                <div id="divreportresults">    

                                <?php 

                                if(!$error)

                                { ?>

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

                                                        <td height="30" align="left" valign="middle">

                                                            <?php echo getHeightOfUser($user_id). ' cms';?>

                                                        </td>

                                                        <td height="30" align="left" valign="middle"><strong>Weight</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td height="30" align="left" valign="middle">

                                                            <?php echo getWeightOfUser($user_id). ' Kgs';?>

                                                        </td>

                                                    </tr>

                                                    <tr>	

                                                        <td height="30" align="left" valign="middle"><strong>BMI</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td height="30" align="left" valign="middle"><?php echo getBMIOfUser($user_id);?></td>

                                                        <td height="30" align="left" valign="middle"><strong>BMI Observations</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td height="30" colspan="4" align="left" valign="middle"><?php echo getBMRObservationOfUser($user_id);?></td>

                                                    </tr>   

                                                <?php

                                                if($report_module != '')

                                                {

                                                    $total_days_period = getNoOfDaysBetweenTwoDates($start_date,$end_date);

                                                    $total_entries = 0;

                                                    if( ($food_return) && ($report_module == 'food_report' || $report_module == '1') )

                                                    {

                                                        $no_of_days_entry = count($arr_food_records);

                                                        

                                                        foreach($arr_food_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['meal_id']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    } 

                                                    elseif( ($activity_return) && ($report_module == 'activity_report' || $report_module == '14') )

                                                    {

                                                        $no_of_days_entry = count($arr_activity_records);

                                                        

                                                        foreach($arr_activity_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['activity_id']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    }

                                                    elseif( ($aa_return) && ($report_module == 'activity_analysis_report' || $report_module == '4') && count($arr_aa_records) > 0 )

                                                    {

                                                        //echo '<br><pre>';

                                                        //print_r($arr_aa_records);

                                                        //echo'<br></pre>';

                                                        $no_of_days_entry = count($arr_aa_records);

                                                        

                                                        foreach($arr_aa_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['records']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    }

                                                    elseif( ($mt_return) && ($report_module == 'meal_time_report' || $report_module == '5') && count($arr_mt_records) > 0 )

                                                    {

                                                        //echo '<br><pre>';

                                                        //print_r($arr_mt_records);

                                                        //echo'<br></pre>';

                                                        $no_of_days_entry = count($arr_mt_records);

                                                        

                                                        $total_entries = 0;

                                                        foreach($arr_mt_records as $k => $v)

                                                        {

                                                            $total_entries += $v['total_entry_per_day']; 

                                                        }

                                                    }

                                                    elseif( ($wae_return) && ($report_module == 'wae_report' || $report_module == '15') )

                                                    {

                                                        $no_of_days_entry = count($arr_wae_records);

                                                        

                                                        foreach($arr_wae_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['selected_wae_id']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    }

                                                    elseif( ($gs_return) && ($report_module == 'gs_report' || $report_module == '16') )

                                                    {

                                                        $no_of_days_entry = count($arr_gs_records);

                                                        

                                                        foreach($arr_gs_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['selected_gs_id']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    }

                                                    elseif( ($sleep_return) && ($report_module == 'sleep_report' || $report_module == '17') )

                                                    {

                                                        $no_of_days_entry = count($arr_sleep_records);

                                                        

                                                        foreach($arr_sleep_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['selected_sleep_id']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    }

                                                    elseif( ($mc_return) && ($report_module == 'mc_report' || $report_module == '18') )

                                                    {

                                                        $no_of_days_entry = count($arr_mc_records);

                                                        

                                                        foreach($arr_mc_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['selected_mc_id']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    }

                                                    elseif( ($mr_return) && ($report_module == 'mr_report' || $report_module == '19') )

                                                    {

                                                        $no_of_days_entry = count($arr_mr_records);

                                                        

                                                        foreach($arr_mr_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['selected_mr_id']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    }

                                                    elseif( ($mle_return) && ($report_module == 'mle_report' || $report_module == '20') )

                                                    {

                                                        $no_of_days_entry = count($arr_mle_records);

                                                        

                                                        foreach($arr_mle_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['selected_mle_id']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    }

                                                    elseif( ($adct_return) && ($report_module == 'adct_report' || $report_module == '21') )

                                                    {

                                                        $no_of_days_entry = count($arr_adct_records);

                                                        

                                                        foreach($arr_adct_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['selected_adct_id']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    }

                                                    elseif( ($bps_return) && ($report_module == 'bps_report' || $report_module == '22') )

                                                    {

                                                        $no_of_days_entry = count($arr_bps_records);

                                                        

                                                        foreach($arr_bps_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['bms_id']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    }

                                                    elseif( ($bes_return) && ($report_module == 'bes_report' || $report_module == '23') )

                                                    {

                                                        $no_of_days_entry = count($arr_bes_records);

                                                        

                                                        foreach($arr_bes_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['bms_id']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    }

                                                    elseif( ($mdt_return) && ($report_module == 'mdt_report' || $report_module == '24') )

                                                    {

                                                        $no_of_days_entry = count($arr_mdt_records);

                                                        

                                                        foreach($arr_mdt_records as $k => $v)

                                                        {

                                                            for($i=0;$i<count($v['bms_id']);$i++)

                                                            {

                                                                $total_entries++; 

                                                            }

                                                        }

                                                    }

                                                    else

                                                    {

                                                        $no_of_days_entry = 0;

                                                    }

                                                    

                                                    if($total_days_period > 0)

                                                    {

                                                        $percentage_no_of_days_entry = ($no_of_days_entry / $total_days_period) * 100;

                                                        $percentage_no_of_days_entry = round($percentage_no_of_days_entry,2);

                                                    }

                                                    else

                                                    {

                                                        $percentage_no_of_days_entry = 0;

                                                    }

                                                    ?>

                                                    <tr>

                                                        <td height="30" align="left" valign="middle"><strong>No of days(period)</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td height="30" align="left" valign="middle"><?php echo $total_days_period;?></td>

                                                        <td height="30" align="left" valign="middle"><strong>No of days(entry)</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td height="30" align="left" valign="middle"><?php echo $no_of_days_entry.' ('.$percentage_no_of_days_entry.'%)';?></td>

                                                        <td height="30" align="left" valign="middle"><strong>No of entry</strong></td>

                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td height="30" align="left" valign="middle"><?php echo $total_entries;?></td>

                                                    </tr>    

                                                <?php

                                                } ?>

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

                                                        <td align="left"><p style="color:#ff0000;">Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>

                                                    </tr>

                                                    <tr>	

                                                        <td align="left" height="30">&nbsp;</td>

                                                    </tr>

                                                </tbody>

                                                </table>

                                            <?php

                                            }?>    



                                            <?php

                                            if( ($food_return) && ($report_module == 'food_report' || $report_module == '1') )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Food</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <?php

                                                if($module_keyword == '')

                                                {

                                                    foreach($arr_food_records as $k => $v)

                                                    { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                    </tr>

                                                </table>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>	

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >	

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

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <?php

                                                    }

                                                }

                                                else

                                                {

                                                    //echo '<br><pre>';

                                                    //print_r($arr_food_records);

                                                    //echo '<br></pre>';

                                                    foreach($arr_food_records as $k => $v)

                                                    {

                                                        $first_item_key = $k;

                                                        break;

                                                    } ?>

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Item</td>

                                                            <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">

                                                            <?php 

                                                            if($arr_food_records[$first_item_key]['meal_id'][0] == '9999999999')

                                                            {

                                                                echo $v['meal_others'][$i];

                                                            }

                                                            else

                                                            {

                                                                echo getMealName($arr_food_records[$first_item_key]['meal_id'][0]);

                                                            }

                                                            ?>

                                                           

                                                            </td>	

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>

                                                            <td width="285" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                            <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Quantity</td>	

                                                            <td width="65" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Desire</td>

                                                            <td width="270" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Item Remarks</td>			

                                                        </tr>	

                                                    <?php

                                                    foreach($arr_food_records as $k => $v)

                                                    {

                                                        for($i=0;$i<count($v['meal_id']);$i++)

                                                        { 

                                                        ?>

                                                        <tr>

                                                            <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $v['meal_time'][$i];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                                <?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')'; ?>

                                                            </td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['meal_quantity'][$i].' ('.$v['meal_measure'][$i],' )';?></td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['meal_like'][$i];?><br /><?php echo getMealLikeIcon($v['meal_like'][$i]); ?></td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['meal_consultant_remark'][$i];?></td>	

                                                        </tr>	

                                                    <?php

                                                        }

                                                    } ?>

                                                    </table>	

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>		

                                                <?php

                                                }

                                                

                                                ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>



                                            <?php

                                            if( ($activity_return)  && ($report_module == 'activity_report' || $report_module == '14') )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Activity</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /> </td>

                                                    </tr>

                                                </table>

                                                <?php

                                                if($module_keyword == '')

                                                {

                                                    foreach($arr_activity_records as $k => $v)

                                                    { 

                                                        $yesterday_sleep_time = getUserSleepTime($user_id,$k);

                                                        $today_wakeup_time = getUserWakeUpTime($user_id,$k);

                                                        $total_sleep_duration = getDurationBetweenTwoTimes($yesterday_sleep_time,$today_wakeup_time);

                                                        ?>

                                                <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">

                                                    <tr>

                                                        <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Date : <?php echo date("d M Y",strtotime($k));?>(<?php echo date("l",strtotime($k));?>)</td>

                                                        <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Yesterday Sleep Time : <?php echo $yesterday_sleep_time;?></td>

                                                        <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Today Wake-up Time : <?php echo $today_wakeup_time;?></td>

                                                        <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Sleep Duration : <?php echo $total_sleep_duration;?></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >	

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>

                                                        <td width="385" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Activity</td>	

                                                        <td width="100" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Duration</td>	

                                                        <td width="85" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Proper guidance</td>	

                                                        <td width="200" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Precaution</td>	

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

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>		

                                                <?php

                                                    }

                                                }

                                                else

                                                {

                                                    //echo '<br><pre>';

                                                    //print_r($arr_activity_records);

                                                    //echo '<br></pre>';

                                                    foreach($arr_activity_records as $k => $v)

                                                    {

                                                        $first_item_key = $k;

                                                        break;

                                                    } ?>

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Activity</td>

                                                            <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">

                                                            <?php 

                                                            if($arr_activity_records[$first_item_key]['activity_id'][0] == '9999999999')

                                                            {

                                                                echo $v['other_activity'][$i];

                                                            }

                                                            else

                                                            {

                                                                echo getDailyActivityName($arr_activity_records[$first_item_key]['activity_id'][0]);

                                                            }

                                                            ?>

                                                           

                                                            </td>	

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>

                                                            <td width="385" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>	

                                                            <td width="100" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Duration</td>	

                                                            <td width="85" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Proper guidance</td>	

                                                            <td width="200" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Precaution</td>	

                                                        </tr>	

                                                    <?php

                                                    foreach($arr_activity_records as $k => $v)

                                                    {

                                                        for($i=0;$i<count($v['activity_id']);$i++)

                                                        { 

                                                        ?>

                                                        <tr>

                                                            <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $v['activity_time'][$i];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                                <?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')'; ?>

                                                            </td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['mins'][$i].' Mins';?></td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['proper_guidance'][$i];?></td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['precaution'][$i];?></td>	

                                                        </tr>	

                                                    <?php

                                                        }

                                                    } ?>

                                                    </table>	

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>		

                                                <?php

                                                }

                                                ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>

                                                

                                            <?php

                                            if( ($aa_return)  && ($report_module == 'activity_analysis_report' || $report_module == '4') && count($arr_aa_records) > 0 )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Activity Analysis Chart</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /> </td>

                                                    </tr>

                                                </table>

                                                <?php

                                                if($module_keyword == '')

                                                {

                                                    foreach($arr_aa_records as $k => $v)

                                                    {

                                                        $yesterday_sleep_time = getUserSleepTime($user_id,$k);

                                                        $today_wakeup_time = getUserWakeUpTime($user_id,$k);

                                                        $total_sleep_duration = getDurationBetweenTwoTimes($yesterday_sleep_time,$today_wakeup_time);

                                                        ?>

                                                <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">

                                                    <tr>

                                                        <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Date : <?php echo date("d M Y",strtotime($k));?>(<?php echo date("l",strtotime($k));?>)</td>

                                                        <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Yesterday Sleep Time : <?php echo $yesterday_sleep_time;?></td>

                                                        <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Today Wake-up Time : <?php echo $today_wakeup_time;?></td>

                                                        <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Sleep Duration : <?php echo $total_sleep_duration;?></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /> </td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="1" cellpadding="2" cellspacing="1" bgcolor="#999999">

                                                    <tr>

                                                        <td width="25" height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">SNo</td>

                                                        <td width="250" height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Activity</td>

                                                        <td width="75" height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>

                                                        <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Duration<br>(Mins)</td>

                                                        <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Sedentary Activity(SA)<br>(Cal)</td>

                                                        <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Light Activity(LA)<br>(Cal)</td>

                                                        <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Moderate Activity(MA)<br>(Cal)</td>

                                                        <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Vigorous Activity(VA)<br>(Cal)</td>

                                                        <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Super Active(SUA)<br>(Cal)</td>

                                                    </tr>	

                                                    <?php

                                                    $j=1;

                                                    foreach($v['records'] as $key => $val)

                                                    { ?>

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $j;?></td>

                                                        <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getDailyActivityName($val['activity_id']);?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['time'];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['duration'].'('.$val['duration_perc'].'%)';?></td>

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

                                                        <td height="5" colspan="2" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><img src="images/spacer.gif" width="1" height="1" /> </td>

                                                        <td height="5" colspan="7" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><img src="images/spacer.gif" width="1" height="1" /> </td>

                                                    </tr>

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;</td>

                                                        <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Total Calories Burnt&nbsp;&nbsp;(Cal)</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                            <?php

                                                            $grant_total_cal_burnt = $arr_aa_records[$k]['total_sa_cal_burned'] + $arr_aa_records[$k]['total_la_cal_burned'] + $arr_aa_records[$k]['total_ma_cal_burned'] + $arr_aa_records[$k]['total_va_cal_burned'] + $arr_aa_records[$k]['total_sua_cal_burned'];

                                                            echo $grant_total_cal_burnt;

                                                            ?>

                                                        </td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $arr_aa_records[$k]['total_sa_cal_burned'];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $arr_aa_records[$k]['total_la_cal_burned'];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $arr_aa_records[$k]['total_ma_cal_burned'];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $arr_aa_records[$k]['total_va_cal_burned'];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $arr_aa_records[$k]['total_sua_cal_burned'];?></td>

                                                    </tr> 

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;</td>

                                                        <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Total Calories Intake&nbsp;&nbsp;(Cal)</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo getUserTotalCalIntakeOfDate($user_id,$k);?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                    </tr> 

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;</td>

                                                        <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Estimated Calorie Required&nbsp;&nbsp;(Cal)</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo getEstimatedCalorieRequired($user_id,$k);?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                    </tr> 

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td height="20" align="left" valign="middle">&nbsp;</td>

                                                    </tr>

                                                </table>

                                                    <?php

                                                    }

                                                }

                                                else

                                                {

                                                    //echo '<br><pre>';

                                                    //print_r($arr_aa_records);

                                                    //echo '<br></pre>';

                                                    

                                                    foreach($arr_aa_records as $k => $v)

                                                    {

                                                        $first_item_key = $v['records'][0]['activity_id'];

                                                        break;

                                                        

                                                    } ?>

                                                    <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">

                                                        <tr>

                                                            <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Activity : <?php echo getDailyActivityName($first_item_key);?></td>

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /> </td>

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="1" cellpadding="2" cellspacing="1" bgcolor="#999999">

                                                        <tr>

                                                            <td width="25" height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">SNo</td>

                                                            <td width="250" height="50" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                            <td width="75" height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>

                                                            <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Duration<br>(Mins)</td>

                                                            <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Sedentary Activity(SA)<br>(Cal)</td>

                                                            <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Light Activity(LA)<br>(Cal)</td>

                                                            <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Moderate Activity(MA)<br>(Cal)</td>

                                                            <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Vigorous Activity(VA)<br>(Cal)</td>

                                                            <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Super Active(SUA)<br>(Cal)</td>

                                                        </tr>	

                                                        <?php

                                                        $j=1;

                                                        

                                                        $total_sa_cal_burned = 0;

                                                        $total_la_cal_burned = 0;

                                                        $total_ma_cal_burned = 0;

                                                        $total_va_cal_burned = 0;

                                                        $total_sua_cal_burned = 0;

                                                        

                                                        foreach($arr_aa_records as $k => $v)

                                                        {

                                                            $total_sa_cal_burned += $arr_aa_records[$k]['total_sa_cal_burned'];

                                                            $total_la_cal_burned += $arr_aa_records[$k]['total_la_cal_burned'];

                                                            $total_ma_cal_burned += $arr_aa_records[$k]['total_ma_cal_burned'];

                                                            $total_va_cal_burned += $arr_aa_records[$k]['total_va_cal_burned'];

                                                            $total_sua_cal_burned += $arr_aa_records[$k]['total_sua_cal_burned'];

                                                            foreach($v['records'] as $key => $val)

                                                            { ?>

                                                        <tr>

                                                            <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $j;?></td>

                                                            <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k));?>(<?php echo date("l",strtotime($k));?>)</td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['time'];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['duration'].'('.$val['duration_perc'].'%)';?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['sa_cal_burned'];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['la_cal_burned'];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['ma_cal_burned'];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['va_cal_burned'];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $val['sua_cal_burned'];?></td>

                                                        </tr>   

                                                            <?php

                                                            $j++;

                                                            }

                                                        }?>

                                                        <tr>

                                                            <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">&nbsp;</td>

                                                            <td height="30" align="left" valign="middle" bgcolor="#E1E1E1" class="report_header">Total Calories Burnt&nbsp;&nbsp;(Cal)</td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_header">&nbsp;</td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">&nbsp;</td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $total_sa_cal_burned;?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $total_la_cal_burned;?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $total_ma_cal_burned;?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $total_va_cal_burned;?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $total_sua_cal_burned;?></td>

                                                        </tr> 

                                                    </table>	

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>		

                                                <?php

                                                }

                                                ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>   

                                                

                                            <?php

                                            if( ($mt_return)  && ($report_module == 'meal_time_report' || $report_module == '5') && count($arr_mt_records)> 0 )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Meal Time Chart</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /> </td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="1" cellpadding="2" cellspacing="1" bgcolor="#999999">

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

                                                    $j=1;

                                                    //for($i=0,$j=1;$i<count($arr_mt_date);$i++,$j++)

                                                    foreach($arr_mt_records as $key => $val)

                                                    { ?>

                                                    <tr>

                                                        <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $j;?></td>

                                                        <td height="50" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($key));?><br />(<?php echo date("l",strtotime($key));?>)</td>

                                                        <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php if(isset($val['breakfast_time']) && $val['breakfast_time'] != ''){echo $val['breakfast_time'];}else{echo 'NA';}?></td>

                                                        <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php if(isset($val['brunch_time']) && $val['brunch_time'] != ''){echo $val['brunch_time'];}else{echo 'NA';}?></td>

                                                        <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php if(isset($val['lunch_time']) && $val['lunch_time'] != ''){echo $val['lunch_time'];}else{echo 'NA';}?></td>

                                                        <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php if(isset($val['snacks_time']) && $val['snacks_time'] != ''){echo $val['snacks_time'];}else{echo 'NA';}?></td>

                                                        <td height="50" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php if(isset($val['dinner_time']) && $val['dinner_time'] != ''){echo $val['dinner_time'];}else{echo 'NA';}?></td>

                                                    </tr>

                                                    <?php

                                                        $j++;

                                                    } ?>

                                                </table>        

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>     



                                            <?php

                                            if( ($wae_return) && ($report_module == 'wae_report' || $report_module == '15') )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Work & Environment</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <?php

                                                if($module_keyword == '')

                                                {

                                                    foreach($arr_wae_records as $k => $v)

                                                    { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>		

                                                    </tr>	

                                                        <?php

                                                        for($i=0;$i<count($v['selected_wae_id']);$i++)

                                                        { ?>

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getWAESituation($v['selected_wae_id'][$i]); ?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                            <?php echo $v['scale'][$i];?><br/>

                                                            <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="240" border="0" /> 

                                                        </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][$i];?></td>

                                                    </tr>	

                                                        <?php

                                                        } ?>

                                                </table>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>		

                                                    <?php

                                                    }

                                                }   

                                                else

                                                {

                                                    foreach($arr_wae_records as $k => $v)

                                                    {

                                                        $first_item_key = $k;

                                                        break;

                                                    } ?>

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

                                                            <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getWAESituation($arr_wae_records[$first_item_key]['selected_wae_id'][0]); //echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                            <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>		

                                                        </tr>	

                                                    <?php

                                                    foreach($arr_wae_records as $k => $v)

                                                    { ?>

                                                        <tr>

                                                            <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')'; ?></td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                                <?php echo $v['scale'][0];?><br/>

                                                                <img src="<?php echo SITE_URL."/images/".$v['scale_image'][0]; ?>" width="240" border="0" /> 

                                                            </td>  

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][0];?></td>

                                                        </tr>	

                                                    <?php

                                                    } ?>

                                                    </table>	

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>		

                                                <?php

                                                }

                                                ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>



                                            <?php

                                            if( ($gs_return) && ($report_module == 'gs_report' || $report_module == '16') )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;General Stressors</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <?php

                                                if($module_keyword == '')

                                                {

                                                    foreach($arr_gs_records as $k => $v)

                                                    { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>

                                                    </tr>	

                                                    <?php

                                                    for($i=0;$i<count($v['selected_gs_id']);$i++)

                                                    { ?>

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getGSSituation($v['selected_gs_id'][$i]); ?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                            <?php echo $v['scale'][$i];?><br/>

                                                            <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="240" border="0" /> 

                                                        </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][$i];?></td>

                                                    </tr>	

                                                    <?php

                                                    } ?>

                                                </table>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>		

                                                <?php

                                                    }

                                                }

                                                else

                                                {

                                                    foreach($arr_gs_records as $k => $v)

                                                    {

                                                        $first_item_key = $k;

                                                        break;

                                                    } ?>

                                                    <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

                                                            <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getGSSituation($arr_gs_records[$first_item_key]['selected_gs_id'][0]); ?></td>	

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                            <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>		

                                                        </tr>	

                                                    <?php

                                                    foreach($arr_gs_records as $k => $v)

                                                    { ?>

                                                        <tr>

                                                            <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')'; ?></td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                                <?php echo $v['scale'][0];?><br/>

                                                                <img src="<?php echo SITE_URL."/images/".$v['scale_image'][0]; ?>" width="240" border="0" /> 

                                                            </td>  

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][0];?></td>

                                                        </tr>	

                                                    <?php

                                                    } ?>

                                                    </table>	

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>		

                                                <?php

                                                }

                                                ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>





                                            <?php

                                            if( ($sleep_return) && ($report_module == 'sleep_report' || $report_module == '17') )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Sleep</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <?php

                                                if($module_keyword == '')

                                                {

                                                    foreach($arr_sleep_records as $k => $v)

                                                    { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

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

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>		

                                                    </tr>	

                                                    <?php

                                                    for($i=0;$i<count($v['selected_sleep_id']);$i++)

                                                    { 	?>

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getSleepSituation($v['selected_sleep_id'][$i]); ?></td>	 

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                            <?php echo $v['scale'][$i];?><br/>

                                                            <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="240" border="0" /> 

                                                        </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][$i];?></td>

                                                    </tr>	

                                                    <?php

                                                    } ?>

                                                </table>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>		

                                                    <?php

                                                    }

                                                }

                                                else

                                                {

                                                    foreach($arr_sleep_records as $k => $v)

                                                    {

                                                        $first_item_key = $k;

                                                        break;

                                                    } ?>

                                                    <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

                                                            <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getSleepSituation($arr_sleep_records[$first_item_key]['selected_sleep_id'][0]); ?></td>	

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                            <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>		

                                                        </tr>	

                                                    <?php

                                                    foreach($arr_sleep_records as $k => $v)

                                                    { ?>

                                                        <tr>

                                                            <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')'; ?></td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                                <?php echo $v['scale'][0];?><br/>

                                                                <img src="<?php echo SITE_URL."/images/".$v['scale_image'][0]; ?>" width="240" border="0" /> 

                                                            </td>  

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][0];?></td>

                                                        </tr>	

                                                    <?php

                                                    } ?>

                                                    </table>	

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>		

                                                <?php

                                                }  ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>



                                            <?php

                                            if( ($mc_return) && ($report_module == 'mc_report' || $report_module == '18') )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;My Communication</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <?php

                                                if($module_keyword == '')

                                                {

                                                    foreach($arr_mc_records as $k => $v)

                                                    { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>

                                                    </tr>	

                                                    <?php

                                                    for($i=0;$i<count($v['selected_mc_id']);$i++)

                                                    { ?>

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getMCSituation($v['selected_mc_id'][$i]); ?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                            <?php echo $v['scale'][$i];?><br/>

                                                            <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="240" border="0" /> 

                                                        </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][$i];?></td>

                                                    </tr>	

                                                    <?php

                                                    } ?>

                                                </table>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>		

                                                <?php

                                                    }

                                                }

                                                else

                                                {

                                                    foreach($arr_mc_records as $k => $v)

                                                    {

                                                        $first_item_key = $k;

                                                        break;

                                                    } ?>

                                                    <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

                                                            <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getMCSituation($arr_mc_records[$first_item_key]['selected_mc_id'][0]); ?></td>	

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                            <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>		

                                                        </tr>	

                                                    <?php

                                                    foreach($arr_mc_records as $k => $v)

                                                    { ?>

                                                        <tr>

                                                            <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')'; ?></td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                                <?php echo $v['scale'][0];?><br/>

                                                                <img src="<?php echo SITE_URL."/images/".$v['scale_image'][0]; ?>" width="240" border="0" /> 

                                                            </td>  

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][0];?></td>

                                                        </tr>	

                                                    <?php

                                                    } ?>

                                                    </table>	

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>		

                                                <?php

                                                }     

                                                ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>



                                            <?php

                                            if( ($mr_return) && ($report_module == 'mr_report' || $report_module == '19') )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;My Relations</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <?php

                                                if($module_keyword == '')

                                                {

                                                    foreach($arr_mr_records as $k => $v)

                                                    { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>

                                                    </tr>	

                                                    <?php

                                                    for($i=0;$i<count($v['selected_mr_id']);$i++)

                                                    { ?>

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getMRSituation($v['selected_mr_id'][$i]); ?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                            <?php echo $v['scale'][$i];?><br/>

                                                            <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="240" border="0" /> 

                                                        </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][$i];?></td>

                                                    </tr>	

                                                    <?php

                                                    } ?>

                                                </table>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>		

                                                <?php

                                                    }

                                                }

                                                else

                                                {

                                                    foreach($arr_mr_records as $k => $v)

                                                    {

                                                        $first_item_key = $k;

                                                        break;

                                                    } ?>

                                                    <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

                                                            <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getMRSituation($arr_mr_records[$first_item_key]['selected_mr_id'][0]); ?></td>	

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                            <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>		

                                                        </tr>	

                                                    <?php

                                                    foreach($arr_mr_records as $k => $v)

                                                    { ?>

                                                        <tr>

                                                            <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')'; ?></td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                                <?php echo $v['scale'][0];?><br/>

                                                                <img src="<?php echo SITE_URL."/images/".$v['scale_image'][0]; ?>" width="240" border="0" /> 

                                                            </td>  

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][0];?></td>

                                                        </tr>	

                                                    <?php

                                                    } ?>

                                                    </table>	

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>		

                                                <?php

                                                }

                                                ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>



                                            <?php

                                            if( ($mle_return) && ($report_module == 'mle_report' || $report_module == '20') )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Major Life Events</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <?php

                                                if($module_keyword == '')

                                                {

                                                    foreach($arr_mle_records as $k => $v)

                                                    { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>	

                                                    </tr>	

                                                    <?php

                                                    for($i=0;$i<count($v['selected_mle_id']);$i++)

                                                    { ?>

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getMLESituation($v['selected_mle_id'][$i]); ?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                            <?php echo $v['scale'][$i];?><br/>

                                                            <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="240" border="0" /> 

                                                        </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][$i];?></td>

                                                    </tr>	

                                                    <?php

                                                    } ?>

                                                </table>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>		

                                                <?php

                                                    }

                                                }

                                                else

                                                {

                                                    foreach($arr_mle_records as $k => $v)

                                                    {

                                                        $first_item_key = $k;

                                                        break;

                                                    } ?>

                                                    <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

                                                            <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getMLESituation($arr_mle_records[$first_item_key]['selected_mle_id'][0]); ?></td>	

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                            <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>		

                                                        </tr>	

                                                    <?php

                                                    foreach($arr_mle_records as $k => $v)

                                                    { ?>

                                                        <tr>

                                                            <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')'; ?></td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                                <?php echo $v['scale'][0];?><br/>

                                                                <img src="<?php echo SITE_URL."/images/".$v['scale_image'][0]; ?>" width="240" border="0" /> 

                                                            </td>  

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][0];?></td>

                                                        </tr>	

                                                    <?php

                                                    } ?>

                                                    </table>	

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>		

                                                <?php

                                                }    

                                                ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>



                                            <?php

                                            if( ($adct_return) && ($report_module == 'adct_report' || $report_module == '21') )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Addictions</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>



                                                <?php

                                                if($module_keyword == '')

                                                {

                                                    foreach($arr_adct_records as $k => $v)

                                                    { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                    </tr>

                                                </table>



                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>

                                                    </tr>	



                                                    <?php

                                                    for($i=0;$i<count($v['selected_adct_id']);$i++)

                                                    { ?>

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getADCTSituation($v['selected_adct_id'][$i]); ?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                            <?php echo $v['scale'][$i];?><br/>

                                                            <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="240" border="0" /> 

                                                        </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][$i];?></td>

                                                    </tr>	

                                                    <?php

                                                    } ?>

                                                </table>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>		

                                                    <?php

                                                    }

                                                }

                                                else

                                                {

                                                    foreach($arr_adct_records as $k => $v)

                                                    {

                                                        $first_item_key = $k;

                                                        break;

                                                    } ?>

                                                    <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Situation</td>

                                                            <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getADCTSituation($arr_adct_records[$first_item_key]['selected_adct_id'][0]); ?></td>	

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>

                                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                        <tr>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                            <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                            <td width="220" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                            <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>		

                                                        </tr>	

                                                    <?php

                                                    foreach($arr_adct_records as $k => $v)

                                                    { ?>

                                                        <tr>

                                                            <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')'; ?></td>	

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                                <?php echo $v['scale'][0];?><br/>

                                                                <img src="<?php echo SITE_URL."/images/".$v['scale_image'][0]; ?>" width="240" border="0" /> 

                                                            </td>  

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][0];?></td>

                                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][0];?></td>

                                                        </tr>	

                                                    <?php

                                                    } ?>

                                                    </table>	

                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                        <tr>

                                                            <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                        </tr>

                                                    </table>		

                                                <?php

                                                }    

                                                ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>

                                                

                                            <?php

                                            if( ($bps_return) && ($report_module == 'bps_report' || $report_module == '22') )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Physical State Report</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>



                                                <?php

                                                foreach($arr_bps_records as $k => $v)

                                                { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                    </tr>

                                                </table>



                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Symptoms</td>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Body Part</td>

                                                        <td width="320" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>		

                                                    </tr>	



                                                    <?php

                                                    for($i=0;$i<count($v['bms_id']);$i++)

                                                    { ?>

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getCommaSepratedBMS($v['bms_id'][$i]);?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo getUserBodyPartImageBoxSaved($v['bp_id'][$i],$v['spotx'][$i],$v['spoty'][$i],$v['bps_image'][$i]); ?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo getCommaSepratedBMSScaleImage($v['scale'][$i]);?></td>

                                                    </tr>	

                                                    <?php

                                                    } ?>

                                                </table>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>		

                                                <?php

                                                }?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>    



                                            <?php

                                            if( ($bes_return) && ($report_module == 'bes_report' || $report_module == '23') )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="left" valign="top" bgcolor="#E1E1E1" class="report_header">&nbsp;Emotional State Report</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>



                                                <?php

                                                if($module_keyword == '')

                                                {

                                                    foreach($arr_bes_records as $k => $v)

                                                    { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                    </tr>

                                                </table>



                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="250" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Symptoms</td>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Duration</td>

                                                        <td width="170" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>

                                                    </tr>	



                                                    <?php

                                                    for($i=0;$i<count($v['bms_id']);$i++)

                                                    { ?>

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getBobyMainSymptomName($v['bms_id'][$i]); ?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                            <?php echo $v['scale'][$i];?><br/>

                                                            <img src="<?php echo SITE_URL."/images/".$v['scale_image'][$i]; ?>" width="240" border="0" /> 

                                                        </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['bes_time'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['bes_duration'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][$i];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][$i];?></td>

                                                    </tr>	

                                                    <?php

                                                    } ?>

                                                </table>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>		

                                                <?php

                                                    }

                                                }

                                                else

                                                {

                                                    foreach($arr_bes_records as $k => $v)

                                                    { 

                                                        $first_item_key = $k;

                                                        break; 

                                                    }

                                                    ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Symptoms</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getBobyMainSymptomName($arr_bes_records[$first_item_key]['bms_id'][0]); ?></td>	

                                                    </tr>

                                                </table>



                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="250" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                        <td width="300" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Scale</td>

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Time</td>

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Duration</td>

                                                        <td width="170" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Responses</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">My Target</td>		

                                                        <td width="50" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Adviser Target</td>

                                                    </tr>	



                                                    <?php

                                                    foreach($arr_bes_records as $k => $v)

                                                    { ?>

                                                    <tr>

                                                        <td height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($k)). '( '.date("l",strtotime($k)).')';?></td>	

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value">

                                                            <?php echo $v['scale'][0];?><br/>

                                                            <img src="<?php echo SITE_URL."/images/".$v['scale_image'][0]; ?>" width="240" border="0" /> 

                                                        </td>  

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['bes_time'][0];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['bes_duration'][0];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['responce'][0];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['my_target'][0];?></td>

                                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="report_value"><?php echo $v['adviser_target'][0];?></td>

                                                    </tr>	

                                                    <?php

                                                    } ?>

                                                </table>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>		

                                                <?php

                                                }

                                                ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>

                                            <?php

                                            if( ($mdt_return) && ($report_module == 'mdt_report' || $report_module == '24') )

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="1" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="100%" align="center" valign="top" bgcolor="#E1E1E1" class="Header_brown">&nbsp;My Daily Situation Patterns</td>

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>



                                                <?php

                                                if($module_keyword == '' && $trigger_criteria == '')

                                                {

                                                    //echo '<br><pre>';

                                                    //print_r($arr_mdt_records);

                                                    //echo '<br></pre>';

                                                    foreach($arr_mdt_records as $key => $val)

                                                    { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Date</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($key)). '( '.date("l",strtotime($key)).')';?></td>	

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                    <?php

                                                    foreach($val as $k => $v)

                                                    {

                                                        $temp_time_arr = explode('_',$k);

                                                        $time = $temp_time_arr[0];

                                                        if($temp_time_arr[1] != '')

                                                        {

                                                            $duration = $temp_time_arr[1].' Mins';

                                                        }

                                                        else

                                                        {

                                                            $duration = '';

                                                        }

                                                        ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Time</td>

                                                        <td width="310" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $time;?></td>	

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"> Duration</td>

                                                        <td width="310" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $duration;?></td>	

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

                                                    <tr>

                                                        <td width="100%" height="30" align="left" valign="top" bgcolor="#FFFFFF">

                                                            <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >

                                                                <tr>

                                                                    <td width="200" height="30" align="center" valign="middle" style="border: 1px solid #999999;" bgcolor="#E1E1E1" class="report_header">Situation</td>

                                                                    <td width="225" height="30" align="center" valign="middle" style="border: 1px solid #999999; border-left:0px none #E1E1E1;border-right:0px none #E1E1E1;" bgcolor="#E1E1E1" class="report_header" style="border-right:0px;">Situation Scale</td>

                                                                </tr>	

                                                                <?php

                                                                for($i=0;$i<count($v['bms_id']);$i++)

                                                                {

                                                                    if($v['bms_entry_type'][$i] == 'situation')

                                                                    {

                                                                        $situation =  getBobyMainSymptomName($v['bms_id'][$i]);

                                                                        $scale_img_str = $v['scale'][$i].'<br/><img src="'.SITE_URL.'/images/'.$v['scale_image'][$i].'" width="200" border="0" /> ';

                                                                    ?>

                                                                <tr>

                                                                    <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $situation; ?></td>	

                                                                    <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #E1E1E1; border-left:0px none #E1E1E1;border-right:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $scale_img_str;?></td>  

                                                                </tr>	

                                                                <?php

                                                                    }

                                                                } ?>

                                                            </table>

                                                        </td>

                                                        <td width="495" height="30" align="left" valign="top" bgcolor="#FFFFFF">

                                                            <table width="495" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >

                                                                <tr>

                                                                    <td width="200" height="30" align="center" valign="middle" style="border: 1px solid #999999;" bgcolor="#E1E1E1" class="report_header">Trigger</td>

                                                                    <td width="225" height="30" align="center" valign="middle" style="border: 1px solid #999999; border-left:0px none #E1E1E1;" bgcolor="#E1E1E1" class="report_header">Trigger Scale</td>

                                                                    <td width="70" height="30" align="center" valign="middle" style="border: 1px solid #999999; border-left:0px none #E1E1E1;" bgcolor="#E1E1E1" class="report_header">Comments</td>		

                                                                </tr>	



                                                                <?php

                                                                for($i=0;$i<count($v['bms_id']);$i++)

                                                                {

                                                                    if($v['bms_entry_type'][$i] == 'trigger')

                                                                    {

                                                                        if($v['bms_type'][$i] == 'adct')

                                                                        {

                                                                            $trigger = getADCTSituation($v['bms_id'][$i]);

                                                                        }

                                                                        elseif($v['bms_type'][$i] == 'sleep')

                                                                        {

                                                                            $trigger = getSleepSituation($v['bms_id'][$i]);

                                                                        }

                                                                        elseif($v['bms_type'][$i] == 'gs')

                                                                        {

                                                                            $trigger = getGSSituation($v['bms_id'][$i]);

                                                                        }

                                                                        elseif($v['bms_type'][$i] == 'wae')

                                                                        {

                                                                            $trigger = getWAESituation($v['bms_id'][$i]);

                                                                        }

                                                                        elseif($v['bms_type'][$i] == 'mc')

                                                                        {

                                                                            $trigger = getMCSituation($v['bms_id'][$i]);

                                                                        }

                                                                        elseif($v['bms_type'][$i] == 'mr')

                                                                        {

                                                                            $trigger = getMRSituation($v['bms_id'][$i]);

                                                                        }

                                                                        elseif($v['bms_type'][$i] == 'mle')

                                                                        {

                                                                            $trigger = getMLESituation($v['bms_id'][$i]);

                                                                        }

                                                                        else 

                                                                        {

                                                                            $trigger = getBobyMainSymptomName($v['bms_id'][$i]);    

                                                                        }

                                                                        $trigger_scale_img_str = $v['scale'][$i].'<br/><img src="'.SITE_URL.'/images/'.$v['scale_image'][$i].'" width="200" border="0" /> ';

                                                                        $trigger_comments =  urldecode($v['responce'][$i]);

                                                                ?>

                                                                <tr>

                                                                    <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #FFFFFF;" bgcolor="#FFFFFF" class="report_value"><?php echo $trigger; ?></td>	

                                                                    <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #FFFFFF;border-left:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $trigger_scale_img_str;?></td>  

                                                                    <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #FFFFFF;border-left:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $trigger_comments;?></td>

                                                                </tr>	

                                                                <?php

                                                                    }

                                                                } ?>

                                                            </table>

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

                                                    }

                                                }

                                                elseif($module_keyword == '' && $trigger_criteria != '')

                                                {

                                                    //echo '<br><pre>';

                                                    //print_r($arr_mdt_records);

                                                    //echo '<br></pre>';

                                                    foreach($arr_mdt_records as $key => $val)

                                                    {

                                                        $first_item_key1 = $key;

                                                        foreach($val as $k => $v)

                                                        {

                                                            if($v['bms_entry_type'] == 'trigger')

                                                            {

                                                                $first_item_key2 = $k;

                                                                break;  

                                                            }

                                                        }    

                                                        break; 

                                                    }

                                                    $bms_type = $arr_mdt_records[$first_item_key1][$first_item_key2]['bms_type'];

                                                    $bms_id = $arr_mdt_records[$first_item_key1][$first_item_key2]['bms_id'];

                                                    

                                                    if($bms_type == 'adct')

                                                    {

                                                        $trigger = getADCTSituation($bms_id);

                                                    }

                                                    elseif($bms_type == 'sleep')

                                                    {

                                                        $trigger = getSleepSituation($bms_id);

                                                    }

                                                    elseif($bms_type == 'gs')

                                                    {

                                                        $trigger = getGSSituation($bms_id);

                                                    }

                                                    elseif($bms_type == 'wae')

                                                    {

                                                        $trigger = getWAESituation($bms_id);

                                                    }

                                                    elseif($bms_type == 'mc')

                                                    {

                                                        $trigger = getMCSituation($bms_id);

                                                    }

                                                    elseif($bms_type == 'mr')

                                                    {

                                                        $trigger = getMRSituation($bms_id);

                                                    }

                                                    elseif($bms_type == 'mle')

                                                    {

                                                        $trigger = getMLESituation($bms_id);

                                                    }

                                                    else 

                                                    {

                                                        $trigger = getBobyMainSymptomName($bms_id);    

                                                    }

                                                    

                                                    ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Trigger</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo $trigger; ?></td>	

                                                    </tr>

                                                </table>



                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <?php

                                                    foreach($arr_mdt_records as $key => $val)

                                                    { 

                                                        ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($key)). '( '.date("l",strtotime($key)).')'; ?></td>	

                                                        

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

                                                    <tr>

                                                        <td width="495" height="30" align="left" valign="top" bgcolor="#FFFFFF">

                                                            <table width="495" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >

                                                            <tr>

                                                                <td width="100" height="30" align="center" valign="middle" style="border: 1px solid #999999;" bgcolor="#E1E1E1" class="report_header">Time</td>

                                                                <td width="100" height="30" align="center" valign="middle" style="border: 1px solid #999999;" bgcolor="#E1E1E1" class="report_header">Duration</td>

                                                                <td width="225" height="30" align="center" valign="middle" style="border: 1px solid #999999; border-left:0px none #E1E1E1;" bgcolor="#E1E1E1" class="report_header" style="border-right:0px;">Trigger Scale</td>

                                                                <td width="70" height="30" align="center" valign="middle" style="border: 1px solid #999999; border-left:0px none #E1E1E1;border-right:0px none #E1E1E1;" bgcolor="#E1E1E1" class="report_header">Comments</td>		

                                                            </tr>	



                                                            <?php

                                                            $arr_temp_mdt_time = array();

                                                            $arr_temp_mdt_duration = array();

                                                            foreach($val as $k => $v)

                                                            {

                                                                if($v['bms_entry_type'] == 'trigger')

                                                                {

                                                                    

                                                                    $trigger_scale_img_str = $v['scale'].'<br/><img src="'.SITE_URL.'/images/'.$v['scale_image'].'" width="200" border="0" /> ';

                                                                    $trigger_comments =  urldecode($v['responce']);

                                                                    

                                                                    $time = $v['mdt_time'];

                                                                    array_push($arr_temp_mdt_time, $time);

                                                                    array_push($arr_temp_mdt_duration, $v['mdt_duration']);

                                                                    if($v['mdt_duration'] != '')

                                                                    {

                                                                      $duration = $v['mdt_duration'].' Mins';

                                                                    }

                                                                    else

                                                                    {

                                                                        $duration = '';

                                                                    }



                                                                ?>

                                                            <tr>

                                                                <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $time; ?></td>	

                                                                <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $duration; ?></td>	

                                                                <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #E1E1E1; border-left:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $trigger_scale_img_str;?></td>  

                                                                <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #FFFFFF;border-left:0px none #E1E1E1;border-right:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $trigger_comments;?></td>

                                                            </tr>	

                                                            <?php

                                                                }

                                                            } ?>

                                                        </table>

                                                            

                                                        </td>

                                                        <td width="100%" height="30" align="left" valign="top" bgcolor="#FFFFFF">

                                                            

                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >

                                                            <tr>

                                                                <td width="200" height="30" align="center" valign="middle" style="border: 1px solid #999999;" bgcolor="#E1E1E1" class="report_header">Situation</td>

                                                                <td width="225" height="30" align="center" valign="middle" style="border: 1px solid #999999; border-left:0px none #E1E1E1;" bgcolor="#E1E1E1" class="report_header">Situation Scale</td>

                                                                

                                                            </tr>	



                                                            <?php

                                                            //echo '<br><pre>';

                                                            //print_r($arr_temp_mdt_time);

                                                            //echo '<br></pre>';

                                                            foreach($val as $k => $v)

                                                            {

                                                                if( ($v['bms_entry_type'] == 'situation' ) && (in_array($v['mdt_time'],$arr_temp_mdt_time)) && ( in_array($v['mdt_duration'],$arr_temp_mdt_duration) ) )

                                                                {

                                                                    $situation = getBobyMainSymptomName($v['bms_id']);    

                                                                    $scale_img_str = $v['scale'].'<br/><img src="'.SITE_URL.'/images/'.$v['scale_image'].'" width="200" border="0" /> ';

                                                                   

                                                                



                                                                ?>

                                                            <tr>

                                                                <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #FFFFFF;" bgcolor="#FFFFFF" class="report_value"><?php echo $situation; ?></td>	

                                                                <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #FFFFFF;border-left:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $scale_img_str;?></td>  

                                                                

                                                            </tr>	

                                                            <?php

                                                                }

                                                            } ?>

                                                        </table>

                                                        </td>

                                                        

                                                    </tr>



                                                </table>

                                                <?php

                                                    

                                                    }

                                                ?>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>	

                                                    

                                             <?php       

                                                    

                                                    

                                                    

                                                    

                                                }

                                                

                                                else

                                                {

                                                    //echo '<br><pre>';

                                                    //print_r($arr_mdt_records);

                                                    //echo '<br></pre>';

                                                    

                                                    foreach($arr_mdt_records as $key => $val)

                                                    {

                                                        $first_item_key1 = $key;

                                                        foreach($val as $k => $v)

                                                        {

                                                            if($v['bms_entry_type'] == 'situation')

                                                            {

                                                                $first_item_key2 = $k;

                                                                break;  

                                                            }

                                                            

                                                        }    

                                                        break; 

                                                    }

                                                    

                                                    ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Situation</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo getBobyMainSymptomName($arr_mdt_records[$first_item_key1][$first_item_key2]['bms_id']); ?></td>	

                                                    </tr>

                                                </table>



                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                <?php

                                                    foreach($arr_mdt_records as $key => $val)

                                                    { 

                                                        ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" >

                                                    <tr>

                                                        <td width="150" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header">Date</td>

                                                        <td width="770" height="30" align="center" valign="middle" bgcolor="#E1E1E1" class="report_header"><?php echo date("d M Y",strtotime($key)). '( '.date("l",strtotime($key)).')'; ?></td>	

                                                        

                                                    </tr>

                                                </table>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                                

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

                                                    <tr>

                                                        <td width="100%" height="30" align="left" valign="top" bgcolor="#FFFFFF">

                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >

                                                            <tr>

                                                                <td width="100" height="30" align="center" valign="middle" style="border: 1px solid #999999;" bgcolor="#E1E1E1" class="report_header">Time</td>

                                                                <td width="100" height="30" align="center" valign="middle" style="border: 1px solid #999999;" bgcolor="#E1E1E1" class="report_header">Duration</td>

                                                                <td width="225" height="30" align="center" valign="middle" style="border: 1px solid #999999; border-left:0px none #E1E1E1;border-right:0px none #E1E1E1; border-right:0px;" bgcolor="#E1E1E1" class="report_header" >Situation Scale</td>

                                                            </tr>	



                                                            <?php

                                                            //for($i=0;$i<count($v['bms_id']);$i++)

                                                            $arr_temp_mdt_time = array();

                                                            $arr_temp_mdt_duration = array();

                                                            foreach($val as $k => $v)

                                                            {

                                                                if($v['bms_entry_type'] == 'situation')

                                                                {

                                                                    $scale_img_str = $v['scale'].'<br/><img src="'.SITE_URL.'/images/'.$v['scale_image'].'" width="200" border="0" /> ';

                                                                    $time = $v['mdt_time'];

                                                                    array_push($arr_temp_mdt_time, $time);

                                                                    array_push($arr_temp_mdt_duration, $v['mdt_duration']);

                                                                    if($v['mdt_duration'] != '')

                                                                    {

                                                                      $duration = $v['mdt_duration'].' Mins';

                                                                    }

                                                                    else

                                                                    {

                                                                        $duration = '';

                                                                    }



                                                                ?>

                                                            <tr>

                                                                <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $time; ?></td>	

                                                                <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $duration; ?></td>	

                                                                <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #E1E1E1; border-left:0px none #E1E1E1;border-right:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $scale_img_str;?></td>  

                                                            </tr>	

                                                            <?php

                                                                }

                                                            } ?>

                                                        </table>

                                                            

                                                        </td>

                                                        <td width="495" height="30" align="left" valign="top" bgcolor="#FFFFFF">

                                                            

                                                            <table width="495" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >

                                                            <tr>

                                                                <td width="200" height="30" align="center" valign="middle" style="border: 1px solid #999999;" bgcolor="#E1E1E1" class="report_header">Trigger</td>

                                                                <td width="225" height="30" align="center" valign="middle" style="border: 1px solid #999999; border-left:0px none #E1E1E1;" bgcolor="#E1E1E1" class="report_header">Trigger Scale</td>

                                                                <td width="70" height="30" align="center" valign="middle" style="border: 1px solid #999999; border-left:0px none #E1E1E1;" bgcolor="#E1E1E1" class="report_header">Comments</td>		

                                                            </tr>	



                                                            <?php

                                                            //echo '<br><pre>';

                                                            //print_r($arr_temp_mdt_time);

                                                            //echo '<br></pre>';

                                                            //for($i=0;$i<count($v['bms_id']);$i++)

                                                            foreach($val as $k => $v)

                                                            {

                                                                if( ($v['bms_entry_type'] == 'trigger' ) && (in_array($v['mdt_time'],$arr_temp_mdt_time)) && ( in_array($v['mdt_duration'],$arr_temp_mdt_duration) ) )

                                                                {

                                                                    $scale_img_str = '';

                                                                    if($v['bms_type'] == 'adct')

                                                                    {

                                                                        $trigger = getADCTSituation($v['bms_id']);

                                                                    }

                                                                    elseif($v['bms_type'] == 'sleep')

                                                                    {

                                                                        $trigger = getSleepSituation($v['bms_id']);

                                                                    }

                                                                    elseif($v['bms_type'] == 'gs')

                                                                    {

                                                                        $trigger = getGSSituation($v['bms_id']);

                                                                    }

                                                                    elseif($v['bms_type'] == 'wae')

                                                                    {

                                                                        $trigger = getWAESituation($v['bms_id']);

                                                                    }

                                                                    elseif($v['bms_type'] == 'mc')

                                                                    {

                                                                        $trigger = getMCSituation($v['bms_id']);

                                                                    }

                                                                    elseif($v['bms_type'] == 'mr')

                                                                    {

                                                                        $trigger = getMRSituation($v['bms_id']);

                                                                    }

                                                                    elseif($v['bms_type'] == 'mle')

                                                                    {

                                                                        $trigger = getMLESituation($v['bms_id']);

                                                                    }

                                                                    else 

                                                                    {

                                                                        $trigger = getBobyMainSymptomName($v['bms_id']);    

                                                                    }

                                                                    $trigger_scale_img_str = $v['scale'].'<br/><img src="'.SITE_URL.'/images/'.$v['scale_image'].'" width="200" border="0" /> ';

                                                                    $trigger_comments =  urldecode($v['responce']);

                                                                

                                                                



                                                                ?>

                                                            <tr>

                                                                <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #FFFFFF;" bgcolor="#FFFFFF" class="report_value"><?php echo $trigger; ?></td>	

                                                                <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #FFFFFF;border-left:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $trigger_scale_img_str;?></td>  

                                                                <td height="30" align="center" valign="middle" style="border: 1px solid #999999; border-top:0px none #FFFFFF;border-left:0px none #E1E1E1;" bgcolor="#FFFFFF" class="report_value"><?php echo $trigger_comments;?></td>

                                                            </tr>	

                                                            <?php

                                                                }

                                                            } ?>

                                                        </table>

                                                        </td>

                                                        

                                                    </tr>



                                                </table>

                                                <?php

                                                    //}

                                                    }

                                                ?>	

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>		

                                                <?php

                                                    }

                                                ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                    <tr>

                                                        <td height="5"><img src="images/spacer.gif" width="1" height="1" /></td>

                                                    </tr>

                                                </table>

                                            <?php

                                            } ?>

                                    

                                </div>           

                                

                                </td>

                            </tr>

                        </table>

                        <?php 

                        } 

                        else 

                        { ?>

                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                            <tr align="center">

                                <td height="5" class="Header_brown"><?php echo getCommonSettingValue('4');?></td>

                            </tr>

                        </table>

                        <?php 

                        } ?>

         

          

       



 </div>

</div>

 </div>

<!--container-->                   <!--  Footer-->

  <footer> 

   <div class="container">

   <div class="row">

   <div class="col-md-12">	

   <?php include_once('footer.php');?>            

  </div>

  </div>

  </div>

  </footer>

  <!--  Footer-->

            <!--default footer end here-->



        

        <!--scripts and plugins -->

        <!--must need plugin jquery-->

       <!-- <script src="../csswell/js/jquery.min.js"></script> -->       

        <!--bootstrap js plugin-->

      <script src="../csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>   

       <div id="page_loading_bg" class="page_loading_bg" style="display:none;">

    <div id="page_loading_img" class="page_loading_img"><img border="0" src="<?php echo SITE_URL;?>/images/loading.gif" /></div>

</div>

    </body>



</html>		