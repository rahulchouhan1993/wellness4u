<?php
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };
@set_time_limit(1000000);
include('config.php');
$page_id = '141';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('set_my_alert.php');
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

$return = false;
$error = false;
$tr_err_date = 'none';
$err_date = '';

$tbldaterange = '';
$tblsingledate = 'none';
$tblmonthdate = 'none';
$tbldaysofmonth = 'none';
$tbldaysofweek = 'none';

$div_start_scale_value = 'none';
$div_end_scale_value = 'none';
$div_start_criteria_scale_value = 'none';
$div_end_criteria_scale_value = 'none';
$div_module_key = 'none';
$idscaleshow = 'none';
$idcriteriascaleshow = 'none';
$spntriggercriteria = 'none';

$arr_days_of_month = array();
$arr_days_of_week = array();

$alert_msg = '';
$alert_mode = '';


if(isset($_POST['btnSubmit']))	
{
    $date_type = strip_tags(trim($_POST['date_type']));
    $start_date = strip_tags(trim($_POST['start_date']));
    $end_date = strip_tags(trim($_POST['end_date']));
    $single_date = strip_tags(trim($_POST['single_date']));
    $start_month = strip_tags(trim($_POST['start_month']));
    $start_year = strip_tags(trim($_POST['start_year']));
    $alert_msg = trim($_POST['alert_msg']);
    $alert_mode = trim($_POST['alert_mode']);
    
    foreach ($_POST['days_of_month'] as $key => $value) 
    {
        array_push($arr_days_of_month,$value);
    }
    
    foreach ($_POST['days_of_week'] as $key => $value) 
    {
        array_push($arr_days_of_week,$value);
    }
    

    $report_module = trim($_POST['report_module']);
    $pro_user_id = trim($_POST['pro_user_id']);
    $module_keyword = trim($_POST['module_keyword']);
    $module_criteria = trim($_POST['module_criteria']);
        
    $scale_range = trim($_POST['scale_range']);
    $start_scale_value= trim($_POST['start_scale_value']);
    $end_scale_value= trim($_POST['end_scale_value']);
    
    $criteria_scale_range = trim($_POST['criteria_scale_range']);
    $start_criteria_scale_value = trim($_POST['start_criteria_scale_value']);
    $end_criteria_scale_value = trim($_POST['end_criteria_scale_value']);
    
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
        $tbldaysofmonth = 'none';
        $tbldaysofweek = 'none';
        
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
        $tbldaysofmonth = 'none';
        $tbldaysofweek = 'none';
        
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
        $tbldaysofmonth = 'none';
        $tbldaysofweek = 'none';
        
        $start_date = $start_year.'-'.$start_month.'-01';

        $end_month = $start_month;	
        $end_year = $start_year;
        $end_day = date('t',strtotime($start_date));	

        $end_date = $end_year.'-'.$end_month.'-'.$end_day;
    }
    elseif($date_type == 'days_of_month')
    {
        $tbldaterange = 'none';
        $tblsingledate = 'none';
        $tblmonthdate = 'none';
        $tbldaysofmonth = '';
        $tbldaysofweek = 'none';

        if(count($arr_days_of_month) < 1)
        {
            $error = true;
            $tr_err_date = '';
            $err_date = 'Please select days of month';
        }
        else
        {
            $days_of_month = implode(',',$arr_days_of_month);
        }	
    }
    elseif($date_type == 'days_of_week')
    {
        $tbldaterange = 'none';
        $tblsingledate = 'none';
        $tblmonthdate = 'none';
        $tbldaysofmonth = 'none';
        $tbldaysofweek = '';

        if(count($arr_days_of_week) < 1)
        {
            $error = true;
            $tr_err_date = '';
            $err_date = 'Please select days of week';
        }
        else
        {
            $days_of_week = implode(',',$arr_days_of_week);
        }	
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
    
    if($report_module == '' || $report_module == 'food_report' || $report_module == 'activity_report' || $report_module == 'bps_report'|| $report_module == 'activity_analysis_report' || $report_module == 'meal_time_report' )
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
    
    if($alert_msg == '')
    {
        $error = true;
        $tr_err_date = '';
        $err_date .= '<br>Please enter your alert message';
    }
    elseif(strlen($alert_msg) > 250)
    {
        $error = true;
        $tr_err_date = '';
        $err_date .= '<br>Message limit is 250 characters';
    }

    if(!$error)
    {
        
        if($date_type == 'days_of_month')
        {
            $single_date = '';
            $start_date = '';
            $end_date = '';
            $days_of_week = '';
            
        }
        elseif($date_type == 'days_of_week')
        {
            $single_date = '';
            $start_date = '';
            $end_date = '';
            $days_of_month = '';
            
        }
        elseif($date_type == 'single_date')
        {
            $days_of_month = '';
            $start_date = '';
            $end_date = '';
            $days_of_week = '';
            $months = '';

            $single_date = date('Y-m-d',strtotime($single_date));
        }
        elseif($date_type == 'date_range')
        {
            $days_of_month = '';
            $single_date = '';
            $days_of_week = '';
           

            $start_date = date('Y-m-d',strtotime($start_date));
            $end_date = date('Y-m-d',strtotime($end_date));
        }
        elseif($date_type == 'month_wise')
        {
            $days_of_month = '';
            $single_date = '';
            $days_of_week = '';
            $start_date = '';
            $end_date = '';
            
            $start_date = date('Y-m-d',strtotime($start_date));
            $end_date = date('Y-m-d',strtotime($end_date));
        }
        else
        {
            $single_date = '';
            $start_date = '';
            $end_date = '';
            $days_of_month = '';
            $days_of_week = '';
            
        }
        
        if(setUserAlert($user_id,$alert_mode,$alert_msg,$date_type,$single_date,$start_date,$end_date,$days_of_month,$days_of_week,$report_module,$pro_user_id,$module_keyword,$scale_range,$start_scale_value,$end_scale_value,$module_criteria,$trigger_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value))
        {
            header("Location: message.php?msg=16"); 
            exit(0);
        }
        else
        {
            $error = true;
            $err_msg = 'There is some problem right now!Please try again later';
        }
    }
    
    if($err_date != '')
    {
        $err_date = '<div class="err_msg_box"><span class="blink_me">'.$err_date.'</span></div>';
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
    <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>

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
            <table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left" valign="top"><?php echo getPageContents($page_id);?></td>
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
                                                <form action="#" id="frmreports" method="post" name="frmreports">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                    <table width="920" border="0" cellspacing="0" cellpadding="0" >
                                                        <tr>
                                                            <td width="150" height="45" align="left" valign="top" class="Header_brown">Module:</td>
                                                            <td width="250" align="left" valign="top">
                                                                <select name="report_module" id="report_module" onchange="toggleScaleShow(); getModuleWiseKeywordsOptions(); getModuleWiseCriteriaOptions();resetReportForm(); ">
                                                                    <option value="">All Patterns</option>
                                                                    <option value="activity_report" <?php if($report_module == 'activity_report') {?> selected <?php } ?> >My Activity Patterns</option>
                                                                    <option value="activity_analysis_report" <?php if($report_module == 'activity_analysis_report') {?> selected <?php } ?> >My Activity Analysis Patterns</option>
                                                                    <option value="adct_report" <?php if($report_module == 'adct_report') {?> selected <?php } ?> >My Addictions Patterns</option>
                                                                    <option value="mc_report" <?php if($report_module == 'mc_report') {?> selected <?php } ?> >My Communication Patterns</option>
                                                                    <option value="mdt_report" <?php if($report_module == 'mdt_report') {?> selected <?php } ?> >My Daily Situation Patterns</option>
                                                                    <option value="food_report" <?php if($report_module == 'food_report') {?> selected <?php } ?> >My Food Patterns</option>
                                                                    <option value="gs_report" <?php if($report_module == 'gs_report') {?> selected <?php } ?> >My General Stressors Patterns</option>
                                                                    <option value="meal_time_report" <?php if($report_module == 'meal_time_report') {?> selected <?php } ?> >My Meal Time Patterns</option>
                                                                    <option value="bps_report" <?php if($report_module == 'bps_report') {?> selected <?php } ?> >My Physical State Patterns</option>
                                                                    <option value="mr_report" <?php if($report_module == 'mr_report') {?> selected <?php } ?> >My Relations Patterns</option>
                                                                    <option value="sleep_report" <?php if($report_module == 'sleep_report') {?> selected <?php } ?> >My Sleep Patterns</option>
                                                                    <option value="wae_report" <?php if($report_module == 'wae_report') {?> selected <?php } ?> >My Work Place Patterns</option>
                                                                    <?php /*
                                                                     * <option value="bes_report" <?php if($report_module == 'bes_report') {?> selected <?php } ?> >My Emotional State Patterns</option>
                                                                     * <option value="mle_report" <?php if($report_module == 'mle_report') {?> selected <?php } ?> >My Major Life Events Patterns</option>
                                                                     */ ?>
                                                                    
                                                                </select>
                                                            </td>
                                                            <td width="150" height="45" align="left" valign="top" class="Header_brown">Set:</td>
                                                            <td width="250" align="left" valign="top">
                                                                <select name="pro_user_id" id="pro_user_id" style="width:120px;" onchange="getModuleWiseKeywordsOptions(); getModuleWiseCriteriaOptions();">
                                                                    <option value="" <?php if($pro_user_id == '') {?> selected="selected" <?php } ?>>All</option>
                                                                    <option value="0" <?php if($pro_user_id == '0') {?> selected="selected" <?php } ?>>Standard Set</option>
                                                                    <?php echo getUsersAdviserOptions($user_id,$pro_user_id); ?>
                                                                </select>  
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td height="30" align="left" valign="top" class="Header_brown">Keyword:</td>
                                                            <td align="left" valign="top" id="tdkeywordresult">
                                                                <select name="module_keyword" id="module_keyword" style="width:200px;">
                                                                    <option value="" <?php if($module_keyword == '') {?> selected="selected" <?php } ?>>All</option>
                                                                    <?php echo getModuleWiseKeywordsOptions($user_id,$report_module,$pro_user_id,$module_keyword)?>
                                                                </select>
                                                                <br><span style="font-size:11px;color:#0000FF;">(Options displayed are only of Data Posted by User)</span>
                                                            </td>
                                                            <td height="30" align="left" valign="top" class="Header_brown"></td>
                                                            <td align="left" valign="top"></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr id="idscaleshow" style="display:<?php echo $idscaleshow;?>">
                                                            <td height="45" align="left" valign="top" class="Header_brown">Keyword Scale:</td>
                                                            <td align="left" valign="top">
                                                                <select name="scale_range" id="scale_range" onchange="toggleScaleRangeType('scale_range','div_start_scale_value','div_end_scale_value')">
                                                                    <option value="">All</option>
                                                                    <option value="1" <?php if($scale_range == '1') {?> selected <?php } ?> ><(Less Than)</option>
                                                                    <option value="2" <?php if($scale_range == '2') {?> selected <?php } ?> >>(Greater Than)</option>
                                                                    <option value="3" <?php if($scale_range == '3') {?> selected <?php } ?> > &le; (Less than or Equal to)</option>
                                                                    <option value="4" <?php if($scale_range == '4') {?> selected <?php } ?> > &ge; (Greater than or Equal to)</option>
                                                                    <option value="5" <?php if($scale_range == '5') {?> selected <?php } ?> >=(Equal)</option>
                                                                    <option value="6" <?php if($scale_range == '6') {?> selected <?php } ?> >Range</option>
                                                                </select>
                                                            </td>
                                                            <td height="45" align="left" valign="top" class="Header_brown">Scale value:</td>
                                                            <td align="left" valign="top">
                                                                <span id="div_start_scale_value" style="display:<?php echo $div_start_scale_value;?>">
                                                                <select name="start_scale_value" id="start_scale_value">
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
                                                                    <select name="end_scale_value" id="end_scale_value">
                                                                    <?php
                                                                    for($i=1;$i<=10;$i++)
                                                                    { ?>
                                                                    <option value="<?php echo $i;?>" <?php if($end_scale_value == $i) {?> selected <?php } ?> ><?php echo $i;?></option>
                                                                    <?php
                                                                    } ?>
                                                                </select>
                                                                </span>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td height="30" align="left" valign="top" class="Header_brown">Criteria:</td>
                                                            <td align="left" valign="top" id="tdcriteriaresult">
                                                                <select name="module_criteria" id="module_criteria" style="width:200px;" onchange="getModuleWiseCriteriaScaleOptions();getModuleWiseCriteriaScaleValues();toggleCriteriaScaleShow();">
                                                                    <option value="" <?php if($module_criteria == '') {?> selected="selected" <?php } ?>>All</option>
                                                                    <?php echo getModuleWiseCriteriaOptions($user_id,$report_module,$pro_user_id,$module_criteria)?>
                                                                </select>
                                                            </td>
                                                            <td height="30" align="left" valign="top" class="Header_brown">
                                                                <span class="spntriggercriteria" style="display:<?php echo $spntriggercriteria;?>">Triggers:</span>
                                                            </td>
                                                            <td align="left" valign="top">
                                                                <span id="idtriggercriteria" class="spntriggercriteria" style="display:<?php echo $spntriggercriteria;?>">
                                                                    <select name="trigger_criteria" id="trigger_criteria" style="width:200px;">
                                                                        <option value="" <?php if($trigger_criteria == '') {?> selected="selected" <?php } ?>>All</option>
                                                                        <?php echo getTriggerCriteriaOptions($user_id,$trigger_criteria);?>
                                                                    </select>
                                                                    <br><span style="font-size:11px;color:#0000FF;">(Options displayed are only of Data Posted by User)</span>
                                                                </span>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr id="idcriteriascaleshow" style="display:<?php echo $idcriteriascaleshow;?>">
                                                            <td height="45" align="left" valign="top" class="Header_brown">Criteria Scale:</td>
                                                            <td align="left" valign="top" id="tdcriteriascalerange">
                                                                <select name="criteria_scale_range" id="criteria_scale_range" style="width:200px;" onchange="getModuleWiseCriteriaScaleValues();toggleScaleRangeType('criteria_scale_range','div_start_criteria_scale_value','div_end_criteria_scale_value');">
                                                                    <option value="">All</option>
                                                                    <?php echo getModuleWiseCriteriaScaleOptions($user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range);?>
                                                                </select>
                                                            </td>
                                                            <td colspan="2" align="left" valign="top" id="idcriteriascalevalues">
                                                                <?php echo getModuleWiseCriteriaScaleValues($user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value);?>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                    <table width="920" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="150" height="45" align="left" valign="top" class="Header_brown">Alert Date Type:</td>
                                                            <td width="250" align="left" valign="top">
                                                                <select name="date_type" id="date_type" onchange="toggleDateSelectionTypeUserNew('date_type')">
                                                                    <option value="date_range" <?php if($date_type == 'date_range'){?> selected <?php } ?> >Date Range</option>
                                                                    <option value="single_date" <?php if($date_type == 'single_date'){?> selected <?php } ?>>Single Date</option>
                                                                    <option value="month_wise" <?php if($date_type == 'month_wise'){?> selected <?php } ?>>Month wise</option>
                                                                    <option value="days_of_month" <?php if($date_type == 'days_of_month') { ?> selected="selected" <?php } ?>>Days of Month</option>
                                                                    <option value="days_of_week" <?php if($date_type == 'days_of_week') { ?> selected="selected" <?php } ?>>Days of Week</option>
                                                                </select>
                                                            </td>
                                                            <td width="520" height="45" align="left" valign="top"></td>
                                                        </tr>
                                                    </table>
                                                    <table width="920" border="0" cellspacing="0" cellpadding="0" id="tbldaterange" style="display:<?php echo $tbldaterange;?>">
                                                        <tr>
                                                            <td width="150" height="45" align="left" valign="top" class="Header_brown">Start Date:</td>
                                                            <td width="250" align="left" valign="top">
                                                                <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:100px;" />
                                                                <script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                                            </td>
                                                            <td width="150" height="45" align="left" valign="top" class="Header_brown">End Date:</td>
                                                            <td width="250" align="left" valign="top">
                                                                <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:100px;" />
                                                                <script>$('#end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                                            </td>
                                                            <td width="120" height="45" align="left" valign="top"></td>
                                                        </tr>
                                                    </table>
                                                    <table width="920" border="0" cellspacing="0" cellpadding="0" id="tblsingledate" style="display:<?php echo $tblsingledate;?>">
                                                        <tr>
                                                            <td width="150" height="45" align="left" valign="top" class="Header_brown">Date:</td>
                                                            <td width="250" align="left" valign="top">
                                                                <input name="single_date" id="single_date" type="text" value="<?php echo $single_date;?>" style="width:100px;" />
                                                                <script>$('#single_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                    <table width="920" border="0" cellspacing="0" cellpadding="0" id="tblmonthdate" style="display:<?php echo $tblmonthdate;?>">
                                                        <tr>
                                                            <td width="150" height="45" align="left" valign="top" class="Header_brown">Month:</td>
                                                            <td width="250" align="left" valign="top">
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
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                    <table width="920" border="0" cellspacing="0" cellpadding="0" id="tbldaysofmonth" style="display:<?php echo $tbldaysofmonth;?>">
                                                        <tr>
                                                            <td width="150" height="45" align="left" valign="top" class="Header_brown">Days of Month:</td>
                                                            <td width="250" align="left" valign="top">
                                                                <select id="days_of_month" name="days_of_month[]" multiple="multiple" style="width:200px;">
                                                                <?php
                                                                for($i=1;$i<=31;$i++)
                                                                { ?>
                                                                    <option value="<?php echo $i;?>" <?php if (in_array($i, $arr_days_of_month)) {?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                                                <?php
                                                                } ?>	
                                                                </select>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" height="30">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                    <table width="920" border="0" cellspacing="0" cellpadding="0" id="tbldaysofweek" style="display:<?php echo $tbldaysofweek;?>">
                                                        <tr>
                                                            <td width="150" height="45" align="left" valign="top" class="Header_brown">Days of Week:</td>
                                                            <td width="250" align="left" valign="top">
                                                                <select id="days_of_week" name="days_of_week[]" multiple="multiple" style="width:200px;">
                                                                <?php echo getDayOfWeekOptionsMultiple($arr_days_of_week); ?>	
                                                                </select>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" height="30">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                    <table width="920" border="0" cellspacing="0" cellpadding="0" >
                                                        <tr>
                                                            <td width="150" height="45" align="left" valign="top" class="Header_brown">Alert Message:</td>
                                                            <td width="450" align="left" valign="top">
                                                                <textarea id="alert_msg" name="alert_msg" style="width: 400px; height:200px;"><?php echo stripslashes($alert_msg);?></textarea>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" height="30">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                    <table width="920" border="0" cellspacing="0" cellpadding="0" >
                                                        <tr>
                                                            <td width="150" height="45" align="left" valign="top" class="Header_brown">Alert Mode:</td>
                                                            <td width="450" align="left" valign="top">
                                                                <select id="alert_mode" name="alert_mode" style="width:200px;">
                                                                    <option value="email" <?php if($alert_mode == 'email') {?> selected="selected" <?php } ?>>Email</option>
                                                                    <option value="sms" <?php if($alert_mode == 'sms') {?> selected="selected" <?php } ?>>Sms</option>
                                                                    <option value="call" <?php if($alert_mode == 'call') {?> selected="selected" <?php } ?>>Call</option>
                                                                </select>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" height="30">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                    <table width="920" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td height="45" align="left" valign="middle"><input type="submit" name="btnSubmit" id="btnSubmit" value="Set Alert" /></td>
                                                        </tr>
                                                    </table>
                                                    <table width="920" border="0" cellspacing="0" cellpadding="0">
                                                        <tr id="tr_err_date" style="display:<?php echo $tr_err_date;?>;" valign="top">
                                                            <td align="left" class="err_msg" id="err_date" valign="top"><?php echo $err_date;?></td>
                                                        </tr>
                                                    </table>
                                                </form>
                                                
                                                <div id="divreportresults">
                                              

                                            
                                            
                                                
                                            
                                                </div>
                                        	
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="left" valign="top">
                                                <?php echo getScrollingWindowsCodeMainContent($page_id);?>
                                                <?php echo getPageContents2($page_id);?>
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