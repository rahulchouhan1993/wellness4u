<?php
require_once('config/class.mysql.php');
require_once('classes/class.solutions.php');
require_once('../init.php');
$obj = new Solutions();
$obj2 = new ProfileCustomization();

$edit_action_id = '255';

if(!$obj->isAdminLoggedIn())
{
    header("Location: index.php?mode=login");
    exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$edit_action_id))
{	
    header("Location: index.php?mode=invalid");
    exit(0);
}

$error = false;
$err_msg = "";

$tr_days_of_month = 'none';
$tr_single_date = 'none';
$tr_date_range = 'none';
$tr_month_date = 'none';
$tr_days_of_week = 'none';

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
$arr_month = array();

if(isset($_POST['btnSubmit']))
{
    $sol_id = $_POST['hdnsol_id'];
    $prct_id = $_POST['hdnprct_id'];
    $module_id = trim($_POST['module_id']);
    $sol_situation_id = $_POST['hdnsol_situation_id'];
    $sol_situation_type = $_POST['hdnsol_situation_type'];
    $status = strip_tags(trim($_POST['status']));
    
    $listing_date_type = trim($_POST['listing_date_type']);
		
    foreach ($_POST['days_of_month'] as $key => $value) 
    {
        array_push($arr_days_of_month,$value);
    }
    
    foreach ($_POST['days_of_week'] as $key => $value) 
    {
        array_push($arr_days_of_week,$value);
    }
    
    foreach ($_POST['months'] as $key => $value) 
    {
        array_push($arr_month,$value);
    }

    $single_date = trim($_POST['single_date']);
    $start_date = trim($_POST['start_date']);
    $end_date = trim($_POST['end_date']); 

    $min_rating = strip_tags(trim($_POST['min_rating']));
    $max_rating = strip_tags(trim($_POST['max_rating']));
    
    $module_criteria = trim($_POST['module_criteria']);
    $criteria_scale_range = trim($_POST['criteria_scale_range']);
    $start_criteria_scale_value = trim($_POST['start_criteria_scale_value']);
    $end_criteria_scale_value = trim($_POST['end_criteria_scale_value']);
    
    $sol_cat_id = strip_tags(trim($_POST['sol_cat_id']));
    $sol_item_id = strip_tags(trim($_POST['sol_item_id']));
    
	
    if($sol_situation_id == '')
    {
        $error = true;
        $err_msg = 'Please select Situation/Trigger';
    }
    
    if($listing_date_type == '')
    {
        //$error = true;
        //$err_msg .= '<br>Please select selection date type';
    }
    elseif($listing_date_type == 'days_of_month')
    {
        $tr_days_of_week = 'none';
        $tr_days_of_month = '';
        $tr_single_date = 'none';
        $tr_date_range = 'none';
        $tr_month_date = 'none';

        if(count($arr_days_of_month) < 1)
        {
            $error = true;
            $err_msg .= '<br>Please select days of month';
        }
        else
        {
            $days_of_month = implode(',',$arr_days_of_month);
        }	
    }
    elseif($listing_date_type == 'days_of_week')
    {
        $tr_days_of_week = '';
        $tr_days_of_month = 'none';
        $tr_single_date = 'none';
        $tr_date_range = 'none';
        $tr_month_date = 'none';

        if(count($arr_days_of_week) < 1)
        {
            $error = true;
            $err_msg .= '<br>Please select days of week';
        }
        else
        {
            $days_of_week = implode(',',$arr_days_of_week);
        }	
    }
    elseif($listing_date_type == 'single_date')
    {
        $tr_days_of_week = 'none';
        $tr_days_of_month = 'none';
        $tr_single_date = '';
        $tr_date_range = 'none';
        $tr_month_date = 'none';

        if($single_date == '')
        {
            $error = true;
            $err_msg .= '<br>Please select single date';
        }	
    }
    elseif($listing_date_type == 'date_range')
    {
        $tr_days_of_week = 'none';
        $tr_days_of_month = 'none';
        $tr_single_date = 'none';
        $tr_date_range = '';
        $tr_month_date = 'none';

        if($start_date == '')
        {
            $error = true;
            $err_msg .= '<br>Please select start date';
        }
        elseif($end_date == '')
        {
            $error = true;
            $err_msg .= '<br>Please select end date';
        }
        else
        {
            if(strtotime($start_date) > strtotime($end_date))
            {
                $error = true;
                $err_msg .= '<br>Please select end date greater than start date';
            }
        }	
    }
    elseif($listing_date_type == 'month_wise')
    {
        $tr_days_of_week = 'none';
        $tr_days_of_month = 'none';
        $tr_single_date = 'none';
        $tr_date_range = 'none';
        $tr_month_date = '';
        
        //echo '<br><pre>';
        //print_r($arr_month);
        //echo '<br></pre>';
        
        if(count($arr_month) == 0)
        {
            $error = true;
            $err_msg .= '<br>Please select months';
        }
        else
        {
            $months = implode(',',$arr_month);
        }
    }
    
    if($sol_item_id == '')
    {
        $error = true;
        $err_msg .= '<br>Please select Item';
    }

    if($sol_cat_id == '')
    {
        $error = true;
        $err_msg .= '<br>Please select category';
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
    
    if($module_id == '113' || $module_id == '45')
    {
        $idscaleshow = ''; 
    }
    else
    {
        $idscaleshow = 'none'; 
    }
    
    if($module_criteria == '' || $module_criteria == '0')
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

    if(!$error)
    {
        if($listing_date_type == 'days_of_month')
        {
            $single_date = '';
            $start_date = '';
            $end_date = '';
            $days_of_week = '';
            $months = '';
        }
        elseif($listing_date_type == 'days_of_week')
        {
            $single_date = '';
            $start_date = '';
            $end_date = '';
            $days_of_month = '';
            $months = '';
        }
        elseif($listing_date_type == 'single_date')
        {
            $days_of_month = '';
            $start_date = '';
            $end_date = '';
            $days_of_week = '';
            $months = '';

            $single_date = date('Y-m-d',strtotime($single_date));
        }
        elseif($listing_date_type == 'date_range')
        {
            $days_of_month = '';
            $single_date = '';
            $days_of_week = '';
            $months = '';

            $start_date = date('Y-m-d',strtotime($start_date));
            $end_date = date('Y-m-d',strtotime($end_date));
        }
        elseif($listing_date_type == 'month_wise')
        {
            $days_of_month = '';
            $single_date = '';
            $days_of_week = '';
            $start_date = '';
            $end_date = '';
        }
        else
        {
            $single_date = '';
            $start_date = '';
            $end_date = '';
            $days_of_month = '';
            $days_of_week = '';
            $months = '';
        }
        
        
        
        
        if($obj->updateSolution($sol_id,$status,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$min_rating,$max_rating,$sol_cat_id,$sol_item_id,$days_of_week,$months,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value))
        {
            $msg = "Record Edited Successfully!";	
            header('location: index.php?mode=wellness_solutions&msg='.urlencode($msg));
            exit(0);
        }
        else
        {
            $error = true;
            $err_msg = "Currently there is some problem.Please try again later.";
        }
        
    }	
}
elseif(isset($_GET['id']))
{
    $sol_id = $_GET['id'];
    //list($sol_situation_id,$sol_situation_type,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$min_rating,$max_rating,$sol_cat_id,$sol_item_id,$status,$days_of_week,$months) = $obj->getSolutionDetails($sol_id);
    $arr_sol_records = $obj->getSolutionDetails($sol_id);

    if(count($arr_sol_records) == 0)
    {
        header('location: index.php?mode=wellness_solutions');
        exit(0);
    }
    
    $prct_id = stripslashes($arr_sol_records[0]['prct_id']);
    $sol_situation_id = stripslashes($arr_sol_records[0]['sol_situation_id']);
    $sol_situation_type = stripslashes($arr_sol_records[0]['sol_situation_type']);
    $listing_date_type = stripslashes($arr_sol_records[0]['listing_date_type']);
    $days_of_month = stripslashes($arr_sol_records[0]['days_of_month']);
    $single_date = stripslashes($arr_sol_records[0]['single_date']);
    $start_date = stripslashes($arr_sol_records[0]['start_date']);
    $end_date = stripslashes($arr_sol_records[0]['end_date']);
    $days_of_week = stripslashes($arr_sol_records[0]['days_of_week']);
    $months = stripslashes($arr_sol_records[0]['months']);
    $keyword_scale_type = stripslashes($arr_sol_records[0]['keyword_scale_type']);
    $min_rating = stripslashes($arr_sol_records[0]['min_rating']);
    $max_rating = stripslashes($arr_sol_records[0]['max_rating']);
    $module_criteria = stripslashes($arr_sol_records[0]['criteria_id']);
    $criteria_scale_range = stripslashes($arr_sol_records[0]['criteria_scale_type']);
    $start_criteria_scale_value = stripslashes($arr_sol_records[0]['criteria_scale_value1']);
    $end_criteria_scale_value = stripslashes($arr_sol_records[0]['criteria_scale_value2']);
    $sol_cat_id = stripslashes($arr_sol_records[0]['sol_cat_id']);
    $sol_item_id = stripslashes($arr_sol_records[0]['sol_item_id']);
    $status = stripslashes($arr_sol_records[0]['sol_status']);
    
    $module_id = $obj2->getModuleIdOfProfileCustomization($prct_id);

    if($listing_date_type == 'days_of_month')
    {
        $tr_days_of_week = 'none';
        $tr_days_of_month = '';
        $tr_single_date = 'none';
        $tr_date_range = 'none';
        $tr_month_date = 'none';

        $single_date = '';
        $start_date = '';
        $end_date = '';
        $days_of_week = '';

        $pos = strpos($days_of_month, ',');
        if ($pos !== false) 
        {
            $arr_days_of_month = explode(',',$days_of_month);
        }
        else
        {
            array_push($arr_days_of_month , $days_of_month);
        }
    }
    elseif($listing_date_type == 'days_of_week')
    {
        $tr_days_of_week = '';
        $tr_days_of_month = 'none';
        $tr_single_date = 'none';
        $tr_date_range = 'none';
        $tr_month_date = 'none';

        $single_date = '';
        $start_date = '';
        $end_date = '';
        $days_of_month = '';

        $pos = strpos($days_of_week, ',');
        if ($pos !== false) 
        {
            $arr_days_of_week = explode(',',$days_of_week);
        }
        else
        {
            array_push($arr_days_of_week , $days_of_week);
        }
    }
    elseif($listing_date_type == 'single_date')
    {
        $tr_days_of_week = 'none';
        $tr_days_of_month = 'none';
        $tr_single_date = '';
        $tr_date_range = 'none';
        $tr_month_date = 'none';

        $days_of_month = '';
        $start_date = '';
        $end_date = '';
        $days_of_week = '';

        $single_date = date('d-m-Y',strtotime($single_date));
    }
    elseif($listing_date_type == 'date_range')
    {
        $tr_days_of_week = 'none';
        $tr_days_of_month = 'none';
        $tr_single_date = 'none';
        $tr_date_range = '';
        $tr_month_date = 'none';

        $days_of_month = '';
        $single_date = '';
        $days_of_week = '';

        $start_date = date('d-m-Y',strtotime($start_date));
        $end_date = date('d-m-Y',strtotime($end_date));
    }
    elseif($listing_date_type == 'month_wise')
    {
        $tr_days_of_week = 'none';
        $tr_days_of_month = 'none';
        $tr_single_date = 'none';
        $tr_date_range = 'none';
        $tr_month_date = '';
        
        $single_date = '';
        $start_date = '';
        $end_date = '';
        $days_of_month = '';
        $days_of_week = '';
        
        $pos = strpos($months, ',');
        if ($pos !== false) 
        {
            $arr_month = explode(',',$months);
        }
        else
        {
            array_push($arr_month , $months);
        }
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
    
    if($module_id == '113' || $module_id == '45')
    {
        $idscaleshow = ''; 
    }
    else
    {
        $idscaleshow = 'none'; 
    }
    
    if($module_criteria == '' || $module_criteria == '0')
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
}
else
{
	
    header('location: index.php?mode=wellness_solutions');
    exit(0);
}	

?>
<script src="js/AC_ActiveX.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
<div id="central_part_contents">
    <div id="notification_contents">
    <?php
    if($error)
    { ?>
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
    } ?>
    <!--notification_contents-->
    </div>	 
    <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td>
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
                        <td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Wellness Solution </td>
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
                            <form action="#" method="post" name="frmedit_sressbuster" id="frmedit_sressbuster" enctype="multipart/form-data" >
                                <input type="hidden" name="hdnsol_id" id="hdnsol_id" value="<?php echo $sol_id;?>" />
                                <input type="hidden" name="module_id" id="module_id" value="<?php echo $module_id;?>" />
                                <input type="hidden" name="prct_id" id="prct_id" value="<?php echo $prct_id;?>" />
                                <input type="hidden" name="hdnsol_situation_id" id="hdnsol_situation_id" value="<?php echo $sol_situation_id;?>" />
                                <input type="hidden" name="hdnsol_situation_type" id="hdnsol_situation_type" value="<?php echo $sol_situation_type;?>" />
                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="20%" align="right"><strong>Status</strong></td>
                                        <td width="5%" align="center"><strong>:</strong></td>
                                        <td width="75%" align="left">
                                            <select id="status" name="status">
                                                <option value="1" <?php if($status == '1'){ ?> selected <?php } ?>>Active</option>
                                                <option value="0" <?php if($status == '0'){ ?> selected <?php } ?>>Inactive</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="20%" align="right" valign="top"><strong>Situation/Trigger</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="75%" align="left" valign="top">
                                            <strong><?php echo $obj2->getKeywordName($sol_situation_id,$sol_situation_type);?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Date Selection Type</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select name="listing_date_type" id="listing_date_type" onchange="toggleDateSelectionType('listing_date_type')" style="width:200px;">
                                        	<option value="">All</option>
                                                <option value="days_of_month" <?php if($listing_date_type == 'days_of_month') { ?> selected="selected" <?php } ?>>Days of Month</option>
                                                <option value="single_date" <?php if($listing_date_type == 'single_date') { ?> selected="selected" <?php } ?>>Single Date</option>
                                                <option value="date_range" <?php if($listing_date_type == 'date_range') { ?> selected="selected" <?php } ?>>Date Range</option>
                                                <option value="month_wise" <?php if($listing_date_type == 'month_wise') { ?> selected="selected" <?php } ?>>Month Wise</option>
                                                <option value="days_of_week" <?php if($listing_date_type == 'days_of_week') { ?> selected="selected" <?php } ?>>Days of Week</option>
                                            </select>
                                   	</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr id="tr_days_of_month" style="display:<?php echo $tr_days_of_month;?>">
                                        <td align="right" valign="top"><strong>Select days of month</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left">
                                            <select id="days_of_month" name="days_of_month[]" multiple="multiple" style="width:200px;">
                                            <?php
                                            for($i=1;$i<=31;$i++)
                                            { ?>
                                                <option value="<?php echo $i;?>" <?php if (in_array($i, $arr_days_of_month)) {?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                            <?php
                                            } ?>	
                                            </select>&nbsp;*<br>
                                            You can choose more than one option by using the ctrl key.
                                        </td>
                                    </tr>
                                    <tr id="tr_single_date" style="display:<?php echo $tr_single_date;?>">
                                        <td align="right" valign="top"><strong>Select Date</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left">
                                            <input name="single_date" id="single_date" type="text" value="<?php echo $single_date;?>" style="width:200px;"  />
                                            <script>$('#single_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                        </td>
                                    </tr>
                                    <tr id="tr_date_range" style="display:<?php echo $tr_date_range;?>">
                                        <td align="right" valign="top"><strong>Select Date Range</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left">
                                            <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:200px;"  /> - <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:200px;"  />
                                            <script>$('#start_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'});$('#end_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                        </td>
                                    </tr>
                                    <tr id="tr_days_of_week" style="display:<?php echo $tr_days_of_week;?>">
                                        <td align="right" valign="top"><strong>Select days of week</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left">
                                            <select id="days_of_week" name="days_of_week[]" multiple="multiple" style="width:200px;">
                                            <?php echo $obj2->getDayOfWeekOptionsMultiple($arr_days_of_week); ?>	
                                            </select>&nbsp;*<br>
                                            You can choose more than one option by using the ctrl key.
                                        </td>
                                    </tr>
                                    <tr id="tr_month_date" style="display:<?php echo $tr_month_date;?>">
                                        <td align="right" valign="top"><strong>Select Month</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left">
                                            <select id="months" name="months[]" multiple="multiple" style="width:200px;">
                                            <?php echo $obj2->getMonthsOptionsMultiple($arr_month); ?>	
                                            </select>&nbsp;*<br>
                                            You can choose more than one option by using the ctrl key.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Rating</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <strong>From</strong>&nbsp;
                                            <select name="min_rating" id="min_rating">
                                            <?php
                                            for($j=0;$j<=10;$j++)
                                            { ?>
                                                <option value="<?php echo $j;?>" <?php if ($min_rating == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                            <?php
                                            } ?>	
                                            </select>
                                            &nbsp;&nbsp;<strong>To</strong>&nbsp;
                                            <select name="max_rating" id="max_rating">
                                            <?php
                                            for($j=0;$j<=10;$j++)
                                            { ?>
                                                <option value="<?php echo $j;?>" <?php if ($max_rating == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                            <?php
                                            } ?>	
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Criteria:</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left" valign="top" id="tdcriteriaresult">
                                            <select name="module_criteria" id="module_criteria" style="width:200px;" onchange="getModuleWiseCriteriaScaleOptions();getModuleWiseCriteriaScaleValues();toggleCriteriaScaleShow();">
                                                <option value="" <?php if($module_criteria == '') {?> selected="selected" <?php } ?>>All</option>
                                                <?php echo $obj2->getModuleWiseCriteriaOptionsPCM($module_id,$module_criteria)?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr id="idcriteriascaleshow" style="display:<?php echo $idcriteriascaleshow;?>">
                                        <td align="right"><strong>Criteria Scale:</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <table align="left" border="0" width="100%">
                                                <tr>
                                                    <td width="40%" align="left" valign="top" id="tdcriteriascalerange">
                                                        <select name="criteria_scale_range" id="criteria_scale_range" style="width:200px;" onchange="getModuleWiseCriteriaScaleValues();toggleScaleRangeType('criteria_scale_range','div_start_criteria_scale_value','div_end_criteria_scale_value');">
                                                            <option value="">All</option>
                                                            <?php echo $obj2->getModuleWiseCriteriaScaleOptionsPCM($module_id,$module_criteria,$criteria_scale_range);?>
                                                        </select>
                                                    </td>
                                                    <td width="60%" align="left" valign="top" id="idcriteriascalevalues">
                                                        <?php echo $obj2->getModuleWiseCriteriaScaleValues($module_id,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value);?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    
                                    
                                    
                                    <tr>
                                        <td align="right" valign="top"><strong>Category</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <select name="sol_cat_id" id="sol_cat_id" style="width:200px;" onchange="getAllSolutionItemsSelectionStrCatwiseSingle('<?php echo $sol_item_id;?>')">
                                                <option value="" >All Categories</option>
                                                <?php echo $obj->getSolutionCategoryOptions($sol_cat_id); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><strong>Solution Item</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top" id="tdsolitemscatwise">
                                            <?php echo $obj->getAllSolutionItemsSelectionStrSingle($sol_item_id,$sol_cat_id);?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="left">
                                            <input type="Submit" name="btnSubmit" value="Submit" />&nbsp;
                                            <input type="button" name="btnCancel" value="Cancel" onclick="window.location.href='index.php?mode=wellness_solutions'">
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </form>
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