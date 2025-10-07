<?php
// create new page for banner of DLY by ample 30-01-20
require_once('config/class.mysql.php');
require_once('../init.php');

require_once('classes/class.contents.php'); 
$obj = new Contents();

require_once('classes/class.scheduled.php');  
$obj1 = new Schedule();


if(!$obj->isAdminLoggedIn())
{

	header("Location: index.php?mode=login");
	exit(0);
}
else
{
   $admin_id = $_SESSION['admin_id']; 
}



$back_url='index.php?';
	if($_GET['redirect']=='bannerSlider')
    {
    	$back_url.='mode=edit_banner_slider&id='.$_GET['redirect_id'];
    }elseif ($_GET['redirect']=='wsi') {
    	$back_url.='mode=edit_wellness_solution_item&id='.$_GET['redirect_id'];
    }
    elseif ($_GET['redirect']=='rss') {
    	$back_url.='mode=edit_rss_feed_item&id='.$_GET['redirect_id'];
    }
    elseif ($_GET['redirect']=='mjb') {
    	$back_url.='mode=edit_mindjumble&uid='.$_GET['redirect_id'];
    }
    elseif ($_GET['redirect']=='icon') {
    	$back_url.='mode=edit_icons&id='.$_GET['redirect_id'];
    }
    elseif ($_GET['redirect']=='dyl') {
    	$back_url.='mode=edit-design-your-life&id='.$_GET['redirect_id'];
    }
    elseif ($_GET['redirect']=='userPlans') {
    	$back_url.='mode=edit_user_plan&id='.$_GET['redirect_id'];
    }
    elseif ($_GET['redirect']=='rewardList') {
        $back_url.='mode=edit_reward_list&id='.$_GET['redirect_id'];
    }
    elseif ($_GET['redirect']=='wsi-wsi') {
        $back_url.='mode=edit_wellness_solution_item&id='.$_GET['redirect_id'];
    }
    

$publish_show_days_of_month = 'none';
$publish_show_days_of_week = 'none';
$publish_show_month_wise = 'none';
$publish_show_single_date = 'none';
$publish_show_start_date = 'none';
$publish_show_end_date = 'none';

$arr_publish_days_of_month = array();
$arr_publish_days_of_week = array();
$arr_publish_month_wise = array();


$res=$result=false;


if(isset($_POST['save']))
{

	// echo "<pre>";

	// print_r($_POST);

	// die('--');

	

	if(!empty($_POST['schedule_id']))
	{
		$obj1->DeleteScheduleData($_GET,$_POST['schedule_id']);
	}



	$data=array();
	$count_row=$_POST['count_row'];
	for ($i=0; $i <=$count_row; $i++) { 


 				//add by ample 10-04-20
                    $single_date=$start_date=$end_date=$months=$days_week=$days_of_month='';
                    $data['publish_single_date']=$data['publish_start_date']=$data['publish_end_date']=$data['publish_days_of_month']=$data['publish_days_of_week']=$data['publish_month_wise']='';
                    $data['publish_date_type'] = $_POST['publish_date_type'][$i];
                    if($data['publish_date_type']=='single_date')
                    {
                        $data['publish_single_date'] = ($_POST['publish_single_date'][$i] != "" ? date('Y-m-d', strtotime($_POST['publish_single_date'][$i])) : "");
                    }
                    elseif ($data['publish_date_type']=='date_range') {
                        $data['publish_start_date'] = ($_POST['publish_start_date'][$i] != "" ? date('Y-m-d', strtotime($_POST['publish_start_date'][$i])) : "");
                        $data['publish_end_date'] = ($_POST['publish_end_date'][$i] != "" ? date('Y-m-d', strtotime($_POST['publish_end_date'][$i])) : "");
                    }
                    elseif ($data['publish_date_type']=='days_of_month') {
                        $days_of_month = $_POST['publish_days_of_month'][$i];
                        $data['publish_days_of_month'] = implode(',', $days_of_month);
                    }
                    elseif ($data['publish_date_type']=='days_of_week') {
                        $days_of_week = $_POST['publish_days_of_week'][$i];
                        $data['publish_days_of_week'] = implode(',', $days_of_week);
                    }
                    elseif ($data['publish_date_type']=='month_wise') {
                        $months = $_POST['publish_month_wise'][$i];
                        $data['publish_month_wise'] = implode(',', $months);
                    }

                    $state_id=$_POST['state_id'][$i];
				    $city_id=$_POST['city_id'][$i];
				    $area_id=$_POST['area_id'][$i];

				    if(empty($state_id))
				    {
				        $city_id="";
				        $area_id="";
				    }
				    if(empty($city_id))
				    {
				        $area_id="";
				    }

				    $data['state_id']=$state_id;
				    $data['city_id']=$city_id;
				    $data['area_id']=$area_id;

				    $data['schedule_id']=$_POST['schedule_id'][$i];


				    if(!empty($data['schedule_id']))
				    {	
				    	
				    	$res=$obj1->updateScheduleData($admin_id,$data,$data['schedule_id']);
				    	if($res==true)
				    	{
				    		$result=true;
				    	}
				    }
				    else
				    {
				    	
				    	$res=$obj1->addScheduleData($admin_id,$data,$_GET);
				    	if($res==true)
				    	{
				    		$result=true;
				    	}
				    }

			
	}

	//die('--');

	if($result)
	{	
		$msg = "Schedule Update Successfully!";
		$_SESSION['msg'] = $msg;

	}
	else
	{
		$msg = "Try Later!";
		$_SESSION['msg'] = $msg;
	}
	
        header('location: '.$back_url.'&msg=' . urlencode($msg));
		exit(0);

}

$data=$obj1->getRedirectSchedule($_GET['redirect_id'],$_GET['redirect']);



// echo "<pre>";

// print_r($data);

// die('-----');


?>

<style type="text/css">
  .box
  {
  	border: 1px solid #eee;
    padding: 2.5%;
    margin: 2.5px 0;
    border-radius: 5px;
  }
</style>

<!-- <script type="text/javascript" src="js/jscolor.js"></script>  -->
<script type="text/javascript" src="js/jscolor-2.1.1.js"></script> 
<div id="central_part_contents">

	<div id="notification_contents">

	<?php

	if($error)

	{



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

							<td class="notification-body-e"><?php echo $err_msg; ?></td>

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
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
                    <tr>
                        <td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
                        <td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Update Scheduled</td>
                        <td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
                    </tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<br>
				<a href="<?=$back_url;?>"><button class="btn btn-default">Back</button></a>
				<table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">
				<tbody>
					<tr>
						<td class="mainbox-body">
							
							<div class="col-sm-1"></div>
							<div class="col-sm-10">
								<br>
								<form role="form" class="form-horizontal" id="add_banner_slider" name="add_banner_slider" method="post" enctype='multipart/form-data' action="">
								<div id="banner_box">
								<?php 
								if(empty($data))
								{
									?>
									<input type="hidden" name="count_row" id="count_row" value="0" />
									<div class="box" id="row0">
										<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
                                        <div class="form-group left-label">
                                            <label class="col-lg-4 control-label"><strong>Banner Location Details:</strong></label>
                                        </div>  
                                        <div class="form-group" >   
                                            <label class="col-lg-2 control-label"><strong>State:</strong></label>
                                            <div class="col-sm-2">
                                                <select name="state_id[]" id="state_id0" class="form-control" onchange="getCityOption(0)">
                                                    <option value="">All State</option>
                                                    <?php echo $obj1->getStateOption('1',''); ?>
                                                </select>
                                            </div>
                                            <label class="col-lg-2 control-label"><strong>City:</strong></label>
                                            <div class="col-sm-2">
                                                <select name="city_id[]" id="city_id0" class="form-control" onchange="getAreaOption(0)">
                                                    <option value="">All city</option>
                                                </select>
                                            </div>
                                            <label class="col-lg-2 control-label"><strong>Area:</strong></label>
                                            <div class="col-sm-2">
                                                <select name="area_id[]" id="area_id0" class="form-control">
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
                                               <select name="publish_date_type[]" id="publish0_date_type" onchange="showHideDateDropdowns('publish0')" class="form-control">        
                                                        <option value="">--select--</option>
                                                            <option value="single_date">Single Date</option>
                                                            <option value="date_range" >Date Range</option>
                                                            <option value="days_of_week">Days of Week</option>
                                                            <option value="days_of_month">Days of Month</option>
                                                            <option value="month_wise">Month Wise</option>
                                                            
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <div id="publish0_show_days_of_month" style="display:none;">
                                                    <select name="publish_days_of_month[0][]" id="publish0_days_of_month" multiple="multiple" class="form-control" >
                                                        <?php
                                                        for($i=1;$i<=31;$i++)
                                                        { ?>

                                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>

                                                        <?php

                                                        } ?>    

                                                        </select>&nbsp;*<br>
                                                        You can choose more than one option by using the ctrl key.
                                                </div>  
                                                <div id="publish0_show_days_of_week" style="display:none;">
                                                    <select name="publish_days_of_week[0][]" id="publish0_days_of_week" multiple="multiple" class="form-control" >
                                                        <?php echo $obj1->getDayOfWeekOptionsMultiple(''); ?>
                                                    </select>
                                                    &nbsp;*<br>
                                                        You can choose more than one option by using the ctrl key.
                                                </div>  
                                                <div id="publish0_show_month_wise" style="display:none;">
                                                    <select name="publish_month_wise[0][]" id="publish0_month_wise" multiple="multiple" class="form-control" >
                                                        <?php echo $obj1->getMonthsOptionsMultiple(''); ?>
                                                    </select>
                                                    &nbsp;*<br>
                                                        You can choose more than one option by using the ctrl key.
                                                </div> 
                                                <div id="publish0_show_single_date" style="display:none;">
                                                    <input type="text" name="publish_single_date[]" id="publish0_single_date"  placeholder="Select Date" class="form-control" autocomplete="off" >
                                                </div>  
                                                <div id="publish0_show_start_date" style="display:none;">
                                                    <input type="text" name="publish_start_date[]" id="publish0_start_date"  placeholder="Select Start Date" class="form-control" autocomplete="off" >  
                                                </div>  
                                            </div>
                                            <div class="col-lg-3">
                                                <div id="publish0_show_end_date" style="display:none;">
                                                    <input type="text" name="publish_end_date[]" id="publish0_end_date"  placeholder="Select End Date" class="form-control" autocomplete="off" > 
                                                </div>  
                                            </div>
                                        </div>
                                    </div> 
										<br>
										<script type="text/javascript">
                                        	$('#publish0_single_date').datepicker({ todayHighlight: true,startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy',autoclose: true});
										    $('#publish0_start_date').datepicker({ todayHighlight: true, startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy',autoclose: true});
										    $('#publish0_end_date').datepicker({ todayHighlight: true,startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy',autoclose: true});
                                        </script>
                                        <input type="hidden" name="schedule_id[]">
										<button type="button" class="btn btn-info btn-xs add_more_banner">Add More</button>
			                        </div>
									<?php
								}
								else
								{	
									?>
									<input type="hidden" name="count_row" id="count_row" value="<?=count($data)-1;?>" />
									<?php
									foreach ($data as $key => $value) {

										$publish_date_type = $value['publish_date_type'];
									    $publish_days_of_month = $value['publish_days_of_month'];
									    $publish_days_of_week = $value['publish_days_of_week'];
									    $publish_month_wise = $value['publish_month_wise'];
									    $publish_single_date = $value['publish_single_date'];
									    $publish_start_date = $value['publish_start_date'];
									    $publish_end_date = $value['publish_end_date'];
									    
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
										// $arr_publish_days_of_week = explode(',',$value['publish_days_of_week']); 
										// $arr_publish_days_of_month = explode(',',$value['publish_days_of_month']); 
										// $arr_publish_month_wise = explode(',',$value['publish_month_wise']); 
										// $publish_single_date = date('d-m-Y',strtotime($value['publish_single_date']));
										// $publish_start_date = date('d-m-Y',strtotime($value['publish_start_date']));
        		// 						$publish_end_date = date('d-m-Y',strtotime($value['publish_end_date']));
										?>
									<div class="box" id="row<?=$key;?>">
										<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
                                <div class="form-group left-label">
                                    <label class="col-lg-4 control-label"><strong>Banner Location Details:</strong></label>
                                </div>  
                                <div class="form-group" >   
                                    <label class="col-lg-2 control-label"><strong>State:</strong></label>
                                    <div class="col-sm-2">
                                        <select name="state_id[]" id="state_id<?=$key;?>" class="form-control auto-change" onchange="getCityOption(<?=$key;?>,<?=$value['city_id'];?>)">
                                            <option value="">All State</option>
                                            <?php echo $obj1->getStateOption(1,$value["state_id"]); ?>
                                        </select>
                                    </div>
                                    <label class="col-lg-2 control-label"><strong>City:</strong></label>
                                    <div class="col-sm-2">
                                        <select name="city_id[]" id="city_id<?=$key;?>" class="form-control auto-change" onchange="getAreaOption(<?=$key;?>,<?=$value['area_id'];?>)">
                                            <option value="">All city</option>
                                        </select>
                                    </div>
                                    <label class="col-lg-2 control-label"><strong>Area:</strong></label>
                                    <div class="col-sm-2">
                                        <select name="area_id[]" id="area_id<?=$key;?>" class="form-control">
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
                                       <select name="publish_date_type[]" id="publish<?=$key;?>_date_type" onchange="showHideDateDropdowns('publish<?=$key;?>')" class="form-control auto-change">        
                                                <option value="">--select--</option>
                                                    <option value="single_date" <?php if($value['publish_date_type'] == 'single_date') { ?> selected="selected" <?php } ?>>Single Date</option>
                                                    <option value="date_range" <?php if($value['publish_date_type'] == 'date_range') { ?> selected="selected" <?php } ?>>Date Range</option>
                                                    <option value="days_of_week" <?php if($value['publish_date_type'] == 'days_of_week') { ?> selected="selected" <?php } ?>>Days of Week</option>
                                                    <option value="days_of_month" <?php if($value['publish_date_type'] == 'days_of_month') { ?> selected="selected" <?php } ?>>Days of Month</option>
                                                    <option value="month_wise" <?php if($value['publish_date_type'] == 'month_wise') { ?> selected="selected" <?php } ?>>Month Wise</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="publish<?=$key;?>_show_days_of_month" style="display:<?php echo $publish_show_days_of_month;?>">
                                            <select name="publish_days_of_month[<?=$key;?>][]" id="publish<?=$key;?>_days_of_month" multiple="multiple" class="form-control" >
                                                <?php
                                                for($i=1;$i<=31;$i++)
                                                { ?>

                                                    <option value="<?php echo $i;?>" <?php if (in_array($i, $arr_publish_days_of_month)) {?> selected="selected" <?php } ?>><?php echo $i;?></option>

                                                <?php

                                                } ?>    

                                                </select>&nbsp;*<br>
                                                You can choose more than one option by using the ctrl key.
                                        </div>  
                                        <div id="publish<?=$key;?>_show_days_of_week" style="display:<?php echo $publish_show_days_of_week;?>">
                                            <select name="publish_days_of_week[<?=$key;?>][]" id="publish<?=$key;?>_days_of_week" multiple="multiple" class="form-control" >
                                                <?php echo $obj1->getDayOfWeekOptionsMultiple($arr_publish_days_of_week); ?>
                                            </select>
                                        </div>  
                                        <div id="publish<?=$key;?>_show_month_wise" style="display:<?php echo $publish_show_month_wise;?>">
                                            <select name="publish_month_wise[<?=$key;?>][]" id="publish<?=$key;?>_month_wise" multiple="multiple" class="form-control" >
                                                <?php echo $obj1->getMonthsOptionsMultiple($arr_publish_month_wise); ?>
                                            </select>
                                        </div> 
                                        <div id="publish<?=$key;?>_show_single_date" style="display:<?php echo $publish_show_single_date;?>">
                                            <input type="text" name="publish_single_date[]" id="publish<?=$key;?>_single_date" value="<?php echo $publish_single_date;?>" placeholder="Select Date" class="form-control" autocomplete="off" >
                                        </div>  
                                        <div id="publish<?=$key;?>_show_start_date" style="display:<?php echo $publish_show_start_date;?>">
                                            <input type="text" name="publish_start_date[]" id="publish<?=$key;?>_start_date" value="<?php echo $publish_start_date;?>" placeholder="Select Start Date" class="form-control" autocomplete="off" >  
                                        </div>  
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="publish<?=$key;?>_show_end_date" style="display:<?php echo $publish_show_end_date;?>">
                                            <input type="text" name="publish_end_date[]" id="publish<?=$key;?>_end_date" value="<?php echo $publish_end_date;?>" placeholder="Select End Date" class="form-control" autocomplete="off" > 
                                        </div>  
                                    </div>
                                </div>
                            </div>
										<br>
										<script type="text/javascript">
                                        	$('#publish<?=$key;?>_single_date').datepicker({ todayHighlight: true, startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy',autoclose: true,autoclose: true,autoclose: true});
										    $('#publish<?=$key;?>_start_date').datepicker({ todayHighlight: true, startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy',autoclose: true,autoclose: true,autoclose: true});
										    $('#publish<?=$key;?>_end_date').datepicker({ todayHighlight: true, startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy',autoclose: true,autoclose: true,autoclose: true});
                                        </script>
											<input type="hidden" name="schedule_id[]" value="<?=$value['schedule_id']?>">
											<?php 
		                                	if($key==0)
		                                	{
		                                		?>
		                                		<button type="button" class="btn btn-info btn-xs add_more_banner">Add More</button>
		                                		<?php
		                                	}
		                                	else
		                                	{
		                                		?>
		                                		<button type="button" class="btn btn-warning btn-xs add_field_button" onclick="remove_banner('<?=$key;?>')">Remove</button>
		                                		<?php
		                                	}
		                                	?>
										
			                        </div>
										<?php
									}
								}
								?>
								
		                    	</div>
		                    	<hr>
		                    	<div class="text-center">
		                    	<input type="Submit" name="save" class="btn btn-success text-center" value="Save" />
		                    	</div>
		                    	<br>
			                </form>
			                </div>
			                <div class="col-sm-1"></div>
			               
						</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
</tbody>
</table>
</div>

<script type="text/javascript">

	$(document).ready(function() {
	var max_fields      = 11; //maximum input boxes allowed
	var wrapper   		= $("#banner_box"); //Fields wrapper
	var add_button      = $(".add_more_banner"); //Add button ID
	


		var x = 1; //initlal text box count
		$(add_button).click(function(e){ //on add input button click
			e.preventDefault();
			if(x < max_fields){ //max input box allowed
				x++; //text box increment

				var count_row=parseInt($("#count_row").val());
				var new_row= count_row+1;
				var html="";

				var ele='publish'+new_row;

				html+='<div class="box" id="row'+new_row+'">'+
										'<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
                                        '<div class="form-group left-label">'+
                                            '<label class="col-lg-4 control-label"><strong>Banner Location Details:</strong></label>'+
                                        '</div>'+  
                                        '<div class="form-group" >'  +
                                            '<label class="col-lg-2 control-label"><strong>State:</strong></label>'+
                                            '<div class="col-sm-2">'+
                                                '<select name="state_id[]" id="state_id'+new_row+'" class="form-control" onchange="getCityOption(\''+new_row+'\')">'+
                                                    '<option value="">All State</option>'+
                                                    '<?php echo $obj1->getStateOption('1',''); ?>'+
                                                '</select>'+
                                            '</div>'+
                                            '<label class="col-lg-2 control-label"><strong>City:</strong></label>'+
                                            '<div class="col-sm-2">'+
                                                '<select name="city_id[]" id="city_id'+new_row+'" class="form-control" onchange="getAreaOption(\''+new_row+'\')">'+
                                                    '<option value="">All city</option>'+
                                                '</select>'+
                                            '</div>'+
                                            '<label class="col-lg-2 control-label"><strong>Area:</strong></label>'+
                                            '<div class="col-sm-2">'+
                                                '<select name="area_id[]" id="area_id'+new_row+'" class="form-control">'+
                                                    '<option value="">All Area</option>'+
                                                '</select>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
                                        '<div class="form-group left-label">'+
                                            '<label class="col-lg-4 control-label"><strong>Banner Publish Date Details:</strong></label>'+
                                        '</div> '+ 
                                        '<div class="form-group">'+
                                            '<label class="col-lg-2 control-label"><strong>Date of Publish</strong></label>'+
                                        
                                            '<div class="col-lg-4">'+
                                               '<select name="publish_date_type[]" id="'+ele+'_date_type" onchange="showHideDateDropdowns(\''+ele+'\')" class="form-control">'+        
                                                        '<option value="">--select--</option>'+
                                                            '<option value="single_date">Single Date</option>'+
                                                            '<option value="date_range" >Date Range</option>'+
                                                            '<option value="days_of_week">Days of Week</option>'+
                                                            '<option value="days_of_month">Days of Month</option>'+
                                                            '<option value="month_wise">Month Wise</option>'+
                                                            
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-lg-3">'+
                                                '<div id="'+ele+'_show_days_of_month" style="display:none;">'+
                                                    '<select name="publish_days_of_month['+new_row+'][]" id="'+ele+'_days_of_month" multiple="multiple" class="form-control" >'+
                                                        '<option value="">Select</option>'+
		                                                '<option value="1">1</option>'+
		                                                '<option value="2">2</option>'+
		                                                '<option value="3">3</option>'+
		                                                '<option value="4">4</option>'+
		                                                '<option value="5">5</option>'+
		                                                '<option value="6">6</option>'+
		                                                '<option value="7">7</option>'+
		                                                '<option value="8">8</option>'+
		                                                '<option value="9">9</option>'+
		                                                '<option value="10">10</option>'+
		                                                '<option value="11">11</option>'+
		                                                '<option value="11">11</option>'+
		                                                '<option value="12">12</option>'+
		                                                '<option value="13">13</option>'+
		                                                '<option value="14">14</option>'+
		                                                '<option value="15">15</option>'+
		                                                '<option value="16">16</option>'+
		                                                '<option value="17">17</option>'+
		                                                '<option value="18">18</option>'+
		                                                '<option value="19">19</option>'+
		                                                '<option value="20">20</option>'+
		                                                '<option value="21">21</option>'+
		                                                '<option value="22">22</option>'+
		                                                '<option value="23">23</option>'+
		                                                '<option value="24">24</option>'+
		                                                '<option value="25">25</option>'+
		                                                '<option value="26">26</option>'+
		                                                '<option value="27">27</option>'+
		                                                '<option value="28">28</option>'+
		                                                '<option value="29">29</option>'+
		                                                '<option value="30">30</option>'+
		                                                '<option value="31">31</option>'+
                                                        '</select>&nbsp;*<br>'+
                                                        'You can choose more than one option by using the ctrl key.'+
                                                '</div> ' +
                                                '<div id="'+ele+'_show_days_of_week" style="display:none;">'+
                                                    '<select name="publish_days_of_week['+new_row+'][]" id="'+ele+'_days_of_week" multiple="multiple" class="form-control" >'+
                                                        '<?php echo $obj1->getDayOfWeekOptionsMultiple(''); ?>'+
                                                    '</select>'+
                                                    '&nbsp;*<br>'+
                                                        'You can choose more than one option by using the ctrl key.'+
                                                '</div> ' +
                                                '<div id="'+ele+'_show_month_wise" style="display:none;">'+
                                                    '<select name="publish_month_wise['+new_row+'][]" id="'+ele+'_month_wise" multiple="multiple" class="form-control" >'+
                                                        '<?php echo $obj1->getMonthsOptionsMultiple(''); ?>'+
                                                    '</select>'+
                                                    '&nbsp;*<br>'+
                                                        'You can choose more than one option by using the ctrl key.'+
                                                '</div> '+
                                                '<div id="'+ele+'_show_single_date" style="display:none;">'+
                                                    '<input type="text" name="publish_single_date[]" id="'+ele+'_single_date"  placeholder="Select Date" class="form-control" autocomplete="off">'+
                                                '</div>'  +
                                                '<div id="'+ele+'_show_start_date" style="display:none;">'+
                                                    '<input type="text" name="publish_start_date[]" id="'+ele+'_start_date"  placeholder="Select Start Date" class="form-control" autocomplete="off">'+  
                                                '</div>' +
                                            '</div>'+
                                            '<div class="col-lg-3">'+
                                                '<div id="'+ele+'_show_end_date" style="display:none;">'+
                                                    '<input type="text" name="publish_end_date[]" id="'+ele+'_end_date"  placeholder="Select End Date" class="form-control" autocomplete="off" >' +
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div> '+
										'<br>'+
										'<input type="hidden" name="schedule_id[]">'+
										'<button type="button" class="btn btn-warning btn-xs add_field_button" onclick="remove_banner('+new_row+')">Remove</button>'+
			                        '</div>';

			                        // html+='<script>$("#'+ele+'_single_date").datepicker({ startDate: "-0d", minDate: 0 , dateFormat : "dd-mm-yy"}); $("#'+ele+'_start_date").datepicker({ startDate: "-0d", minDate: 0 , dateFormat : "dd-mm-yy"}); $("#'+ele+'_end_date").datepicker({ startDate: "-0d", minDate: 0 , dateFormat : "dd-mm-yy"});<script>';

				$(wrapper).append(html); //add input box
				$("#count_row").val(new_row);
				jscolor.init();
				//$.noConflict(); //add by ample 23-10-20
				$("#"+ele+"_single_date").datepicker({ startDate: "-0d", minDate: 0 , dateFormat : "dd-mm-yy", todayHighlight: true,Default: false,autoclose: true,autoclose: true}); 
				$("#"+ele+"_start_date").datepicker({ startDate: "-0d", minDate: 0 , dateFormat : "dd-mm-yy", todayHighlight: true,Default: false,autoclose: true,autoclose: true}); 
				$("#"+ele+"_end_date").datepicker({ startDate: "-0d", minDate: 0 , dateFormat : "dd-mm-yy", todayHighlight: true,Default: false,autoclose: true,autoclose: true});
			}
		});

	});

	function remove_banner(row) {
		$("#row"+row).remove();
			var count_row = parseInt($("#count_row").val());
            count_row = count_row - 1;
            $("#count_row").val(count_row);
	}


    
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

            //$('#'+idval+'_single_date').datepicker({ startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy'});

        }

        else if(date_type == 'date_range')

        {

            $('#'+idval+'_show_days_of_month').hide();

            $('#'+idval+'_show_days_of_week').hide();

            $('#'+idval+'_show_month_wise').hide();

            $('#'+idval+'_show_single_date').hide();

            $('#'+idval+'_show_start_date').show();

            $('#'+idval+'_show_end_date').show();

           // $('#'+idval+'_start_date').datepicker({ startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy'});
	    	// $('#'+idval+'_end_date').datepicker({ startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy'});


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

    // $('#publish_single_date').datepicker({ startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy'});
    // $('#publish_start_date').datepicker({ startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy'});
    // $('#publish_end_date').datepicker({ startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy'});

      function callDatecalender(ele)
         
          {
         
            // alert(ele);

            //$('#'+ele+'_single_date').datepicker("destroy");
         
             $('#'+ele+'_single_date').datepicker({startDate: '-0d', minDate: 0 , dateFormat : 'dd-mm-yy',autoclose: true});
         
             $('#'+ele+'_start_date').datepicker({ startDate: '-0d',minDate: 0 , dateFormat : 'dd-mm-yy',autoclose: true});
         
             $('#'+ele+'_end_date').datepicker({ startDate: '-0d',minDate: 0 , dateFormat : 'dd-mm-yy',autoclose: true});
         
         
          }

    function getCityOption(ele_id,city_id="")
    {
        var country_id = 1;
        var state_id = $('#state_id'+ele_id).val();
        var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&action=getcityoption';
        $.ajax({
            type: "POST",
            url: "include/remote.php",
            data: dataString,
            cache: false,      
            success: function(result)
            {
                $("#city_id"+ele_id).html(result);
            }
        });
    }

    function getAreaOption(ele_id,area_id="")
    {
        var country_id = 1;
        var state_id = $('#state_id'+ele_id).val();
        var city_id = $('#city_id'+ele_id).val();
        var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&action=getareaoption';
        $.ajax({
            type: "POST",
            url: "include/remote.php",
            data: dataString,
            cache: false,      
            success: function(result)
            {
                $("#area_id"+ele_id).html(result);
            }
        });
    }
</script>
