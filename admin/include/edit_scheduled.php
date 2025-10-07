<?php

require_once('config/class.mysql.php');
require_once('classes/class.contents.php');
$obj = new Contents();

require_once('classes/class.scheduled.php');  
$obj1 = new Schedule();


if (!$obj->isAdminLoggedIn()) {
    
    header("Location: index.php?mode=login");
    
    exit(0);
    
}
else

{

   $admin_id = $_SESSION['admin_id']; 

}



$error = false;

$err_msg = "";

$publish_show_days_of_month = 'none';
$publish_show_days_of_week = 'none';
$publish_show_month_wise = 'none';
$publish_show_single_date = 'none';
$publish_show_start_date = 'none';
$publish_show_end_date = 'none';

$id=$_GET['id'];


if (isset($_POST['btnSubmit'])) 
{
        
       //  echo "<pre>";

       // print_r($_POST);

       // die('--sss');


    $publish_date_type = strip_tags(trim($_POST['publish_date_type']));
    $publish_days_of_month = implode(',', $_POST['publish_days_of_month']);
    $publish_days_of_week = implode(',', $_POST['publish_days_of_week']); 
    $publish_month_wise =  implode(',', $_POST['publish_month_wise']);
    $publish_single_date = strip_tags(trim($_POST['publish_single_date']));
    $publish_start_date = strip_tags(trim($_POST['publish_start_date']));
    $publish_end_date = strip_tags(trim($_POST['publish_end_date']));


    if($publish_date_type == '')
    {
        // $error = true;
        // $err_msg = 'Please select publish date type';

            $publish_month_wise = '';
            $publish_days_of_month = '';
            $publish_days_of_week = '';
            $publish_single_date = '';
            $publish_start_date = '';
            $publish_end_date = '';
        
    }
    else
    {
        if($publish_date_type == 'days_of_month')
        {
            if($publish_days_of_month == '' || $publish_days_of_month == 'null')
            {
                $error = true;
                $err_msg = 'Please select publish days of months';
            }
            
            $publish_days_of_week = '';
            $publish_single_date = '';
            $publish_start_date = '';
            $publish_end_date = '';
        }
        elseif($publish_date_type == 'days_of_week')
        {
            if($publish_days_of_week == '' || $publish_days_of_week == 'null')
            {
                $error = true;
                $err_msg = 'Please select publish days of week';
            }
            
            $publish_month_wise = '';
            $publish_days_of_month = '';
            $publish_single_date = '';
            $publish_start_date = '';
            $publish_end_date = '';
        }
        elseif($publish_date_type == 'month_wise')
        {
            if($publish_month_wise == '' || $publish_month_wise == 'null')
            {
                $error = true;
                $err_msg = 'Please select publish month wise';
            }
            
            $publish_days_of_week = '';
            $publish_days_of_month = '';
            $publish_single_date = '';
            $publish_start_date = '';
            $publish_end_date = '';
        }
        elseif($publish_date_type == 'single_date')
        {
            if($publish_single_date == '' )
            {
                $error = true;
                $err_msg = 'Please select publish date';

            }

            
            $publish_single_date=date("Y-m-d", strtotime($publish_single_date));
            $publish_month_wise = '';
            $publish_days_of_week = '';
            $publish_days_of_month = '';
            $publish_start_date = '';
            $publish_end_date = '';
        }
        elseif($publish_date_type == 'date_range')
        {
            if($publish_start_date == '' )
            {
                $error = true;
                $err_msg = 'Please select publish start date';
                
            }
            elseif($publish_end_date == '' )
            {
                $error = true;
                $err_msg = 'Please select publish end date';
                
            }
            
            $publish_start_date=date("Y-m-d", strtotime($publish_start_date));
            $publish_end_date=date("Y-m-d", strtotime($publish_end_date));
            $publish_month_wise = '';
            $publish_days_of_week = '';
            $publish_days_of_month = '';
            $publish_single_date = '';
        }   
    }

    $state_id=$_POST['state_id'];
    $city_id=$_POST['city_id'];
    $area_id=$_POST['area_id'];

    if(empty($state_id))
    {
        $city_id="";
        $area_id="";
    }
    if(empty($city_id))
    {
        $area_id="";
    }

    $data=array(
                'state_id'=>$state_id,
                'city_id'=>$city_id,
                'area_id'=>$area_id,
                'publish_date_type'=>$_POST['publish_date_type'],
                'publish_single_date'=>$publish_single_date,
                'publish_start_date'=>$publish_start_date,
                'publish_end_date'=>$publish_end_date,
                'publish_month_wise'=>$publish_month_wise,
                'publish_days_of_week'=>$publish_days_of_week,
                'publish_days_of_month'=>$publish_days_of_month,
    			);

   
 
    if (!$error) {
        
        
        if ($obj1->updateScheduleData($admin_id,$data,$id)) {
            
            $msg = "Schedule Update Successfully!";

            if($_GET['redirect']=='bannerSlider')
            {
                header('location: index.php?mode=edit_banner_slider&id='.$_GET['redirect_id'].'&msg=' . urlencode($msg));
            }elseif ($_GET['redirect']=='wsi') {
                header('location: index.php?mode=edit_wellness_solution_item&id='.$_GET['redirect_id'].'&msg=' . urlencode($msg));
            }
            
        }
        
        else {
            
            $error = true;
            
            $err_msg = "Currently there is some problem.Please try again later.";
            
        }
        
    }
    
}
elseif(isset($_GET['id']))
{
    $data = $obj1->getScheduledata($_GET['id']); 

    $publish_date_type = $data['publish_date_type'];
    $publish_days_of_month = $data['publish_days_of_month'];
    $publish_days_of_week = $data['publish_days_of_week'];
    $publish_month_wise = $data['publish_month_wise'];
    $publish_single_date = $data['publish_single_date'];
    $publish_start_date = $data['publish_start_date'];
    $publish_end_date = $data['publish_end_date'];
    
    if($publish_date_type == 'days_of_month')
    {
       
        $arr_publish_days_of_month = explode(',',$publish_days_of_month);   
        
        $arr_publish_days_of_week = array();
        $arr_publish_month_wise = array();
        $publish_single_date = '';
        $publish_start_date = '';
        $publish_end_date = ''; 
        
        $publish_show_days_of_month = '';
        $publish_show_month_wise = 'none';
        $publish_show_days_of_week = 'none';
        $publish_show_single_date = 'none';
        $publish_show_start_date = 'none';
        $publish_show_end_date = 'none';
    }
    elseif($publish_date_type == 'days_of_week')
    {
        
        $arr_publish_days_of_week = explode(',',$publish_days_of_week); 
        
        $arr_publish_days_of_month = array();
        $arr_publish_month_wise = array();
        $publish_single_date = '';
        $publish_start_date = '';
        $publish_end_date = ''; 
        
        $publish_show_days_of_month = 'none';
        $publish_show_days_of_week = '';
        $publish_show_month_wise = 'none';
        $publish_show_single_date = 'none';
        $publish_show_start_date = 'none';
        $publish_show_end_date = 'none';
    }
    elseif($publish_date_type == 'month_wise')
    {
        
        $arr_publish_month_wise = explode(',',$publish_month_wise); 
        
        $arr_publish_days_of_month = array();
        $arr_publish_days_of_week = array();
        $publish_single_date = '';
        $publish_start_date = '';
        $publish_end_date = ''; 
        
        $publish_show_days_of_month = 'none';
        $publish_show_days_of_week = 'none';
        $publish_show_month_wise = '';
        $publish_show_single_date = 'none';
        $publish_show_start_date = 'none';
        $publish_show_end_date = 'none';
    }
    elseif($publish_date_type == 'single_date')
    {
        $publish_single_date = date('d-m-Y',strtotime($publish_single_date));
        
        $arr_publish_days_of_month = array();
        $arr_publish_days_of_week = array();
        $arr_publish_month_wise = array();
        $publish_start_date = '';
        $publish_end_date = ''; 
        
        $publish_show_days_of_month = 'none';
        $publish_show_days_of_week = 'none';
        $publish_show_month_wise = 'none';
        $publish_show_single_date = '';
        $publish_show_start_date = 'none';
        $publish_show_end_date = 'none';
    }
    elseif($publish_date_type == 'date_range')
    {
        $publish_start_date = date('d-m-Y',strtotime($publish_start_date));
        $publish_end_date = date('d-m-Y',strtotime($publish_end_date));
        
        $arr_publish_days_of_month = array();
        $arr_publish_days_of_week = array();
        $arr_publish_month_wise = array();
        $publish_single_date = '';
        
        $publish_show_days_of_month = 'none';
        $publish_show_days_of_week = 'none';
        $publish_show_month_wise = 'none';
        $publish_show_single_date = 'none';
        $publish_show_start_date = '';
        $publish_show_end_date = '';
    }
    else
    {
        $arr_publish_days_of_month = array();
        $arr_publish_days_of_week = array();
        $arr_publish_month_wise = array();
        $publish_single_date = '';
        $publish_start_date = '';
        $publish_end_date = ''; 
        
        $publish_show_days_of_month = 'none';
        $publish_show_days_of_week = 'none';
        $publish_show_month_wise = 'none';
        $publish_show_single_date = 'none';
        $publish_show_start_date = 'none';
        $publish_show_end_date = 'none';
    }




}



?>



<div id="central_part_contents">

    <div id="notification_contents">

    <?php


if ($error) {
?>

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

                            <td class="notification-body-e"><?php
    echo $err_msg;
?></td>

                        </tr>

                    </tbody>

                    </table>

                </td>

            </tr>

        </tbody>

        </table>

    <?php
    
}
?>

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

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Schedule</td>

                        <td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>

                    </tr>

                </tbody>

                </table>

            </td>

        </tr>

        <tr>

            <td>
                <br><br><br>
                    <center><div id="error_msg"></div></center>
                    <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-10">
                            <form role="form" class="form-horizontal" id="edit_banner_slider" name="edit_banner_slider" method="post" enctype='multipart/form-data'> 
                       
                            <div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
                                <div class="form-group left-label">
                                    <label class="col-lg-4 control-label"><strong>Banner Location Details:</strong></label>
                                </div>  
                                <div class="form-group" >   
                                    <label class="col-lg-2 control-label"><strong>State:</strong></label>
                                    <div class="col-sm-2">
                                        <select name="state_id" id="state_id" class="form-control auto-change" onchange="getCityOption(<?=$data['city_id'];?>)">
                                            <option value="">All State</option>
                                            <?php echo $obj1->getStateOption(1,$data["state_id"]); ?>
                                        </select>
                                    </div>
                                    <label class="col-lg-2 control-label"><strong>City:</strong></label>
                                    <div class="col-sm-2">
                                        <select name="city_id" id="city_id" class="form-control auto-change" onchange="getAreaOption(<?=$data['area_id'];?>)">
                                            <option value="">All city</option>
                                        </select>
                                    </div>
                                    <label class="col-lg-2 control-label"><strong>Area:</strong></label>
                                    <div class="col-sm-2">
                                        <select name="area_id" id="area_id" class="form-control">
                                            <option value="">All Area</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
                                <div class="form-group left-label">
                                    <label class="col-lg-4 control-label"><strong>Banner Publish Date Details:</strong></label>
                                </div>  
                                <div class="form-group">
                                    <label class="col-lg-2 control-label"><strong>Date of Publish</strong></label>
                                
                                    <div class="col-lg-4">
                                       <select name="publish_date_type" id="publish_date_type" onchange="showHideDateDropdowns('publish')" class="form-control">        
                                                <option value="">--select--</option>
                                                    <option value="single_date" <?php if($publish_date_type == 'single_date') { ?> selected="selected" <?php } ?>>Single Date</option>
                                                    <option value="date_range" <?php if($publish_date_type == 'date_range') { ?> selected="selected" <?php } ?>>Date Range</option>
                                                    <option value="days_of_week" <?php if($publish_date_type == 'days_of_week') { ?> selected="selected" <?php } ?>>Days of Week</option>
                                                    <option value="days_of_month" <?php if($publish_date_type == 'days_of_month') { ?> selected="selected" <?php } ?>>Days of Month</option>
                                                    <option value="month_wise" <?php if($publish_date_type == 'month_wise') { ?> selected="selected" <?php } ?>>Month Wise</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="publish_show_days_of_month" style="display:<?php echo $publish_show_days_of_month;?>">
                                            <select name="publish_days_of_month[]" id="publish_days_of_month" multiple="multiple" class="form-control" >
                                                <?php
                                                for($i=1;$i<=31;$i++)
                                                { ?>

                                                    <option value="<?php echo $i;?>" <?php if (in_array($i, $arr_publish_days_of_month)) {?> selected="selected" <?php } ?>><?php echo $i;?></option>

                                                <?php

                                                } ?>    

                                                </select>&nbsp;*<br>
                                                You can choose more than one option by using the ctrl key.
                                        </div>  
                                        <div id="publish_show_days_of_week" style="display:<?php echo $publish_show_days_of_week;?>">
                                            <select name="publish_days_of_week[]" id="publish_days_of_week" multiple="multiple" class="form-control" >
                                                <?php echo $obj1->getDayOfWeekOptionsMultiple($arr_publish_days_of_week); ?>
                                            </select>
                                        </div>  
                                        <div id="publish_show_month_wise" style="display:<?php echo $publish_show_month_wise;?>">
                                            <select name="publish_month_wise[]" id="publish_month_wise" multiple="multiple" class="form-control" >
                                                <?php echo $obj1->getMonthsOptionsMultiple($arr_publish_month_wise); ?>
                                            </select>
                                        </div> 
                                        <div id="publish_show_single_date" style="display:<?php echo $publish_show_single_date;?>">
                                            <input type="text" name="publish_single_date" id="publish_single_date" value="<?php echo $publish_single_date;?>" placeholder="Select Date" class="form-control" autocomplete="off" >
                                        </div>  
                                        <div id="publish_show_start_date" style="display:<?php echo $publish_show_start_date;?>">
                                            <input type="text" name="publish_start_date" id="publish_start_date" value="<?php echo $publish_start_date;?>" placeholder="Select Start Date" class="form-control" autocomplete="off" >  
                                        </div>  
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="publish_show_end_date" style="display:<?php echo $publish_show_end_date;?>">
                                            <input type="text" name="publish_end_date" id="publish_end_date" value="<?php echo $publish_end_date;?>" placeholder="Select End Date" class="form-control" autocomplete="off" > 
                                        </div>  
                                    </div>
                                </div>
                            </div>                    
                        <hr>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-10">
                                <div class="pull-left">
                                    <button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>

                        </div>
                        <div class="col-md-1">
                        </div>
                    </div>
                    
            </td>

        </tr>

            </tbody>

    </table>


</div>

    

    <script type="text/javascript">


        $('.auto-change').trigger('change');
        setTimeout(function()
            { 
                $('#city_id').trigger('change');
            }, 1000);

    function showHideDateDropdowns(idval)

        {

            var date_type = $('#'+idval+'_date_type').val();

                

             

            if(date_type == 'days_of_month')

            {

                $('#'+idval+'_show_days_of_month').show();

                $('#'+idval+'_show_days_of_week').hide();

                $('#'+idval+'_show_month_wise').hide();

                $('#'+idval+'_show_single_date').hide();

                $('#'+idval+'_show_start_date').hide();

                $('#'+idval+'_show_end_date').hide();

            }

            else if(date_type == 'days_of_week')

            {

                $('#'+idval+'_show_days_of_month').hide();

                $('#'+idval+'_show_days_of_week').show();

                $('#'+idval+'_show_month_wise').hide();

                $('#'+idval+'_show_single_date').hide();

                $('#'+idval+'_show_start_date').hide();

                $('#'+idval+'_show_end_date').hide();

            }

            else if(date_type == 'month_wise')

            {

                $('#'+idval+'_show_days_of_month').hide();

                $('#'+idval+'_show_days_of_week').hide();

                $('#'+idval+'_show_month_wise').show();

                $('#'+idval+'_show_single_date').hide();

                $('#'+idval+'_show_start_date').hide();

                $('#'+idval+'_show_end_date').hide();

            }

            else if(date_type == 'single_date')

            {

                $('#'+idval+'_show_days_of_month').hide();

                $('#'+idval+'_show_days_of_week').hide();

                $('#'+idval+'_show_month_wise').hide();

                $('#'+idval+'_show_single_date').show();

                $('#'+idval+'_show_start_date').hide();

                $('#'+idval+'_show_end_date').hide();

            }

            else if(date_type == 'date_range')

            {

                $('#'+idval+'_show_days_of_month').hide();

                $('#'+idval+'_show_days_of_week').hide();

                $('#'+idval+'_show_month_wise').hide();

                $('#'+idval+'_show_single_date').hide();

                $('#'+idval+'_show_start_date').show();

                $('#'+idval+'_show_end_date').show();

            }

            else

            {

                $('#'+idval+'_show_days_of_month').hide();

                $('#'+idval+'_show_days_of_week').hide();

                $('#'+idval+'_show_month_wise').hide();

                $('#'+idval+'_show_single_date').hide();

                $('#'+idval+'_show_start_date').hide();

                $('#'+idval+'_show_end_date').hide();

            }

        }

    $('#publish_single_date').datepicker({ startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy'});
    $('#publish_start_date').datepicker({ startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy'});
    $('#publish_end_date').datepicker({ startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy'});

    function getCityOption(city_id="")
    {
        var country_id = 1;
        var state_id = $('#state_id').val();
        var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&action=getcityoption';
        $.ajax({
            type: "POST",
            url: "include/remote.php",
            data: dataString,
            cache: false,      
            success: function(result)
            {
                $("#city_id").html(result);
            }
        });
    }

    function getAreaOption(area_id="")
    {
        var country_id = 1;
        var state_id = $('#state_id').val();
        var city_id = $('#city_id').val();
        var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&action=getareaoption';
        $.ajax({
            type: "POST",
            url: "include/remote.php",
            data: dataString,
            cache: false,      
            success: function(result)
            {
                $("#area_id").html(result);
            }
        });
    }

    </script>
