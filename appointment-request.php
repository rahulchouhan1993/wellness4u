<?php 

include('classes/config.php');

$page_id = '205';

$obj = new frontclass();

$obj2 = new frontclass2();


$page_data = $obj->getPageDetails($page_id);

$setting=$obj->getScrollingWindowsPageSetting($page_id);


$ref = base64_encode($page_data['menu_link']);


if(isset($_SESSION['adm_vendor_id']) && !empty($_SESSION['adm_vendor_id']))
    {
        $vendor_id=$_SESSION['adm_vendor_id'];

    }
    else
    {
        if($obj->isLoggedIn())
         {
         
              $user_id = $_SESSION['user_id'];
         
         }
         else
         {
               header("Location: login.php?ref=".$ref);
               exit();
         }
 
    }

    $vendor_id=$_GET['vendor_id'];
    $ref_code=$_GET['ref_code'];
    $group_id=$_GET['group_id'];
    $user_data=$obj->getUserDetails($user_id);
    $vendor_data=$obj->getVendorDetails($vendor_id);

    if($vendor_data)
    {
    	$vendor_data['persons']=$obj->getVendorContactPersons($vendor_id);
    }

    $design_data_id="";
    $design_data=$obj->get_DYL_data($ref_code,$group_id);
    if($design_data)
    {
    	$design_data_id=$design_data['id'];
    }
    $design_data['special_data']=$obj->GetDesignMyLifeSpecialData($design_data['id']);

    // echo "<pre>";

    // print_r($vendor_data['persons']);

    // die('--');


    if(isset($_POST) && !empty($_POST))
    {	
    	// echo "<pre>";
    	// print_r($_POST);
    	// die();

    	$data = array(
    				'user_id' => $_POST['user_id'] ,
    				'vendor_id'=> $_POST['vendor_id'] ,
    				'contact_id'=> $_POST['contact_id'] ,
    				'appointment_date'=>  date('Y-m-d', strtotime($_POST['date'])) ,
    				'appointment_time'=> $_POST['time'] ,
    				'contact_name'=>$_POST['contact_name'] ,
    				'contact_address'=>$_POST['contact_address'] ,
    				'ref_code'=>$_POST['ref_code'] ,
    				'group_code_id'=>$_POST['group_id'] ,
    				'DYL_id'=>$_POST['design_data_id'],
    				);

    	$last_id=$obj->add_appointment_data($data);

    	if($last_id)
    	{
    		//special text save 01-06-20 by ample
            if (!empty($_POST['special_text'])) 
            {
                //$data_arr = array_values(array_fitler($data['special_text']));
                $data_arr = $_POST['special_text'];
                for ($i = 0;$i < count($data_arr);$i++) {
                    $final = array();
                    $final['box_title'] = $data_arr[$i];
                    $final['comment_lo'] = $_POST['comment_SP'][$i];
                    if($_POST['SP_icon_type'][$i]==2)
                    {
                        $final['location_lo'] = implode(',', $_POST['location_SP'][$i]);
                        $final['User_view_lo'] = implode(',', $_POST['User_view_SP'][$i]);
                        $final['User_Interaction_lo'] = implode(',', $_POST['User_Interaction_SP'][$i]);
                        $final['alert_lo'] =  implode(',', $_POST['alert_SP'][$i]);
                    }
                    else
                    {
                        $final['location_lo'] = $_POST['location_SP'][$i];
                        $final['User_view_lo'] = $_POST['User_view_SP'][$i];
                        $final['User_Interaction_lo'] = $_POST['User_Interaction_SP'][$i];
                        $final['alert_lo'] =  $_POST['alert_SP'][$i];
                    }
                    $final['scale_lo'] = $_POST['scale_SP'][$i];
                    $final['bes_time_lo'] = $_POST['bes_time_SP'][$i];
                    $final['duration_lo'] = $_POST['duration_SP'][$i];
                    $final['unit_lo'] = $_POST['unit_SP'][$i]; //update  by ample 22-04-20
                    $final['rank'] = $_POST['rank_SP'][$i]; //add  by ample  08-06-20

                    //add by ample 10-04-20
                    $single_date_lo=$start_date_lo=$end_date_lo=$months_lo=$days_week_lo=$days_of_month_lo='';
                    $final['single_date_lo']=$final['start_date_lo']=$final['end_date_lo']=$final['days_of_month_lo']=$final['days_of_week_lo']=$final['months_lo']='';
                    $final['userdate_lo'] = $_POST['userdate_SP'][$i];
                    if($final['userdate_lo']=='single_date')
                    {
                        $final['single_date_lo'] = ($_POST['single_date_SP'][$i] != "" ? date('Y-m-d', strtotime($_POST['single_date_SP'][$i])) : "");
                    }
                    elseif ($final['userdate_lo']=='date_range') {
                        $final['start_date_lo'] = ($_POST['start_date_SP'][$i] != "" ? date('Y-m-d', strtotime($_POST['start_date_SP'][$i])) : "");
                        $final['end_date_lo'] = ($_POST['end_date_SP'][$i] != "" ? date('Y-m-d', strtotime($_POST['end_date_SP'][$i])) : "");
                    }
                    elseif ($final['userdate_lo']=='days_of_month') {
                        $days_of_month_lo = $_POST['days_of_month_SP'][$i];
                        $final['days_of_month_lo'] = implode(',', $days_of_month_lo);
                    }
                    elseif ($final['userdate_lo']=='days_of_week') {
                        $days_of_week_lo = $_POST['days_of_week_SP'][$i];
                        $final['days_of_week_lo'] = implode(',', $days_of_week_lo);
                    }
                    elseif ($final['userdate_lo']=='month_wise') {
                        $months_lo = $_POST['months_SP'][$i];
                        $final['months_lo'] = implode(',', $months_lo);
                    }
                    // echo '<pre>';
                    // print_r($final);
                    // echo '</pre>';

                    $final['appointment_id'] = $last_id;
                    $obj->appointment_other_data_save($final);
                }
            }

            // $response_msg='<div class="alert alert-success">
            //           <strong>Success!</strong> Appointment request send Successfully.
            //         </div>';
            echo 'Appointment request send Successfully!';
            die();
    	}
    	else
    	{
    		// $response_msg='<div class="alert alert-danger">
      //                 <strong>Error!</strong> Something wrong, try later!.
      //               </div>';
    		 echo 'Something wrong, try later!';
    		 die();
    	}

    }


?>

<!DOCTYPE html>

<html lang="en">

  <head>    
  <?php include_once('head.php');?>
  <style type="text/css">
  	.bg-box
  	{
  		padding: 15px;
  	}
  	.btn-dark
  	{
  		background: #777;
    	color: #fff;
  	}
  	.btn-dark:hover
  	{
  		color: #eee;
  	}
  	.appoint-head
  	{
  		text-align: center;
	    background: #555;
	    color: #fff;
	    padding: 15px;
	    border-radius: 6px;
	    margin-bottom: 25px;
  	}
  	.appoint-heading
  	{
	    background: #777;
	    color: #fff;
	    padding: 10px;
	    border-radius: 10px 10px 0 0;
  	}
  	.jumbotron.bg-danger
  	{
  		border-radius: 0 0 10px 10px;
  		padding: 25px;
  	}
  	.appointmentSlot 
  	{
	    align-items: center;
	    justify-content: center;
	    border: 1px solid #111;
	    background-color: #fff;
	    color: #111;
	    border-radius: 5px;
	    text-align: center;
	    margin: 5px;
	    transition: 0.3s;
	    cursor: pointer;
	    padding: 5px;
	    display: inline-block;
	}
	.appointmentSlot.active {
    	animation: indicate 0.2s linear forwards;
	}
  </style>
  </head>

  <body>

  <?php include_once('header.php');?>


    <section id="checkout">
      <div class="container">
        <div class="breadcrumb">
          <div class="row">
            <div class="col-md-8">  
              <?php echo $obj->getBreadcrumbCode($page_id);?> 
            </div>
            <div class="col-md-4">
            </div>
          </div>
        </div>
        <div class="">
          <span id="response_msg"></span>
          <span id="error_msg"></span>
          <div class="col-md-8" id="bgimage" style="background-repeat:repeat; padding:5px;">
            <div class="row">
              <div class="col-md-12" id="testdata">
                <?php echo $obj->getPageIcon($page_id);?>
                <span class="Header_brown"><?php echo $page_data['page_title'];?></span><br /><br />
                <?php echo $obj->getPageContents($page_id);?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
              	
              		<div class="appoint-heading" style="background: #<?=$setting['sw_header_bg_color']?>; color: #<?=$setting['sw_header_font_color']?>; font-family: <?=$setting['sw_header_font_family']?>; font-size: <?=$setting['sw_header_font_size']?>px;">
				  		<h4 style="font-size: <?=$setting['sw_header_font_size']?>px;"><?=$design_data['level_heading']?></h4>
				  		<span><?=$design_data['level_title_heading']?></span>
				  	</div>
				  <div class="jumbotron bg-danger" style="background: #<?=$setting['sw_footer_bg_color']?>;">
				  	<div class="row">
				  		<div class="col-md-6">
				  			<div style="font-size: 15px;">
						  		Name: <?=$user_data['name'];?> <?=$user_data['middle_name'];?> <?=$user_data['last_name'];?> <br>
						  		Mobile: <?=$user_data['mobile'];?>  <br>
						  		Email: <?=$user_data['email'];?> 
						  	</div>
						  	<hr>
				  		</div>
				  		<div class="col-md-6">
				  			<div style="color: #<?=$setting['sc_title_font_color']?>; font-family: <?=$setting['sc_title_font_family']?>; font-size: <?=$setting['sc_title_font_size']?>px;">
						  		<b>To</b> Name: <?=$vendor_data['vendor_name'];?> <br>
						  		Mobile: <?=$vendor_data['vendor_mobile'];?>  <br>
						  		 Email: <?=$vendor_data['vendor_email'];?> 
						  	</div>
						  	<hr>
				  		</div>
				  		
				  	</div>
				  	
				    <form action="" style="color: #<?=$setting['sw_footer_font_color']?>; font-family: <?=$setting['sw_footer_font_family']?>; font-size: <?=$setting['sw_footer_font_size']?>px;" method="post" onsubmit="appointment_save()" id="appointment_form">
				    	<div class="row form-group">
						  	<div class="col-md-6">
						  		<label>To Meet</label>
	  							<input type="text" class="form-control" id="meet_person" name="contact_name" readonly="" required=""> 
						  	</div>
						  	<div class="col-md-1">
						  		<label>&nbsp;</label>
						  		<input type="button" class="form-control" title="References" value="?" style="background: #eee;font-weight: 900;" data-toggle="modal" data-target="#myModal">
						  	</div>
						</div>
						<div class="row form-group">
						  	<div class="col-md-6">
						  		<label>Location</label>
	  							<input type="text" class="form-control" id="meet_location" name="contact_address" readonly="" required="">
						  	</div>
						  	<div class="col-md-6">
						  	</div>
						</div>
				    	<!-- <?php 
				    		if($design_data['user_date_show']!=0)
				    		{
				    			?> -->
				    			<div class="row form-group">
								  	<div class="col-md-6">
								  		<label><?=$design_data['user_date_heading'];?></label>
			  							<input type="text" class="form-control" id="appt_date" name="date" required="true" onchange="get_slot();">
								  	</div>
								  	<div class="col-md-6">
								  	</div>
								</div>
				    			<!-- <?php
				    		}
				    	?> -->
				    	<!-- <?php 
				    		if($design_data['time_show']!=0)
				    		{
				    			?>
				    			<div class="row form-group">
								  	<div class="col-md-6">
								  		<label><?=$design_data['time_heading'];?></label>
								    	<input type="time" class="form-control" id="appt_time">
								  	</div>
								  	<div class="col-md-6">
								  	</div>
								</div>
				    			<?php
				    		}
				    	?> -->
				    	<div class="row form-group">
				    		<div class="col-md-6">
				    			<label><?=$design_data['time_heading'];?></label>
				    			<div id="slot_data"></div>
							</div>
							<div class="col-md-6">
							</div>
						</div>
						<br>
					  	<!-- <div class="form-group">
						  <label>Additional Information:</label>
						  <textarea class="form-control" rows="3"></textarea>
						</div>
						<div class="checkbox">
						    <label><input type="checkbox">I agree to terms & conditions</label>
						</div> -->
						<?php
						$special_html="";
						$tr_days_of_month = 'none';
			            $tr_single_date = 'none';
			            $tr_date_range = 'none';
			            $tr_month_date = 'none';
			            $tr_days_of_week = 'none';
						if(!empty($design_data['special_data']))
			            {   
			                $special_html.= '<div class="special-data" style="color: #'.$setting["sc_content_font_color"].'; font-family: '.$setting["sc_content_font_family"].'; font-size: '.$setting["sc_content_font_size"].'px;">';
			                foreach ($design_data['special_data'] as $key => $value) 
			                {
			                    
			                    $special_html.= '<span>';
			                        $special_html.= '<h6 class="special-title" style="background:#'.$design_data['special_bg_color'].';color:#'.$design_data['special_font_color'].';font-family: '.$design_data["special_font_family"].'; font-size: '.$design_data["special_font_size"].'px;"><i class="fa '.$design_data['special_icon_code'].'"></i> '.$value['specifiq_text'].'</h6>';
			                        $special_html.= '<input type="hidden" name="special_text[]" id="special_text' . $key . '" value="'.$value['specifiq_text'].'"  class="input-text-box " style="width:550px;margin: 10px 0;" autocomplete="off" readonly/>';
			                       
			                     $special_html.= '</span>';

			                      //add by ample 29-05-20
			                               $special_html.='<input type="hidden" name="SP_icon_type[]"  value="' . $value['icon_type'] . '">';

			                     //new condition icon type 26-05-20
			                        if($value['icon_type']==1) 
			                        {

			                                $special_html.= '<br>&nbsp;<a href="javascript:void(0);" onclick="ShowloopSP(' . $key . ');"><i class="fa fa-eye" style="cursor: pointer;" id="eyeSP' . $key . '" title="Click here for user action"></i></a><p>';

			                                    
			                                    for ($x = 1;$x <= 11;$x++)
			                                    {
			                                    	$icon_source=explode(',', $value['icon_source']);

			                                        if ($design_data['location_order_show'] == $x && ($design_data['location_show']  == 1 || $design_data['location_show'] == 3) && in_array('Location', $icon_source)) {
			                                            $location_show_icon = $obj->getMyDayTodayIcon('location_show');
			                                        } else {
			                                            $location_show_icon = '';
			                                        }
			                                        if ($design_data['like_dislike_order_show'] == $x && ($design_data['User_view']  == 1 || $design_data['User_view'] == 3) && in_array('User_Response', $icon_source)) {
			                                            $User_view_icon = $obj->getMyDayTodayIcon('User_view');
			                                        } else {
			                                            $User_view_icon = '';
			                                        }
			                                        if ($design_data['set_goals_order_show'] == $x && ($design_data['User_Interaction']  == 1 || $design_data['User_Interaction'] == 3) && in_array('User_What_Next', $icon_source)) {
			                                            $User_Interaction_icon = $obj->getMyDayTodayIcon('User_Interaction');
			                                        } else {
			                                            $User_Interaction_icon = '';
			                                        }
			                                        if ($design_data['reminder_order_show'] == $x && ($design_data['alert_show']  == 1 || $design_data['alert_show'] == 3) && in_array('Alert_Update', $icon_source)) {
			                                            $alert_show_icon = $obj->getMyDayTodayIcon('alert_show');
			                                        } else {
			                                            $alert_show_icon = '';
			                                        }
			                                        if ($design_data['comment_order_show'] == $x && ($design_data['comment_show']  == 1 || $design_data['comment_show'] == 3) && in_array('Comment', $icon_source)) {
			                                            $comment_show_icon = $obj->getMyDayTodayIcon('comments_show');
			                                        } else {
			                                            $comment_show_icon = '';
			                                        }
			                                        if ($design_data['user_date_order_show'] == $x &&($design_data['user_date_show']  == 1 || $design_data['user_date_show'] == 3) && in_array('Date', $icon_source)) {
			                                            $user_date_icon = $obj->getMyDayTodayIcon('date_show');
			                                        } else {
			                                            $user_date_icon = '';
			                                        }
			                                        if ($design_data['scale_order_show'] == $x && ($design_data['scale_show']  == 1 || $design_data['scale_show'] == 3) && in_array('Scale', $icon_source)) {
			                                            $scale_show_icon = $obj->getMyDayTodayIcon('scale_show');
			                                        } else {
			                                            $scale_show_icon = '';
			                                        }
			                                        if ($design_data['time_order_show'] == $x && ($design_data['time_show']  == 1 || $design_data['time_show'] == 3) && in_array('Time', $icon_source)) {
			                                            $time_show_icon = $obj->getMyDayTodayIcon('time_show');
			                                        } else {
			                                            $time_show_icon = '';
			                                        }
			                                        if ($design_data['duration_order_show'] == $x && ($design_data['duration_show']  == 1 || $design_data['duration_show'] == 3) && in_array('Duration', $icon_source)) {
			                                            $duration_show_icon = $obj->getMyDayTodayIcon('duration_show');
			                                        } else {
			                                            $duration_show_icon = '';
			                                        }

			                                        if ($comment_show_icon != '') {
			                                            $special_html.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $comment_show_icon . '"  id="comment_show_icon_SP'.$key.'" style="width:25px; height: 25px; display:none;" title="' . $design_data['comments_heading'] . '" onclick="ShowComment_SP(' . $key . ');">';
			                                        }
			                                        if ($location_show_icon != '') {
			                                            $special_html.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $location_show_icon . '"  id="location_show_icon_SP'.$key.'" style="width:25px; height: 25px; display:none;" title="' . $design_data['location_heading'] . '" onclick="ShowLocation_SP(' . $key . ');">';
			                                        }
			                                        if ($User_view_icon != '') {
			                                            $special_html.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $User_view_icon . '"  id="User_view_icon_SP'.$key.'" style="width:25px; height: 25px; display:none;" title="' . $design_data['like_dislike_heading'] . '" onclick="ShowUserview_SP(' . $key . ');">';
			                                        }
			                                        if ($User_Interaction_icon != '') {
			                                            $special_html.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $User_Interaction_icon . '"  id="User_Interaction_icon_SP'.$key.'" style="width:25px; height: 25px; display:none;" title="' . $design_data['set_goals_heading'] . '" onclick="ShowUserInteraction_SP(' . $key . ');">';
			                                        }
			                                        if ($alert_show_icon != '') {
			                                            $special_html.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $alert_show_icon . '" id="alert_show_icon_SP'.$key.'" style="width:25px; height: 25px; display:none;" title="' . $design_data['reminder_heading'] . '" onclick="ShowAlert_SP(' . $key . ');">';
			                                        }
			                                        if ($scale_show_icon != '') {
			                                            $special_html.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $scale_show_icon . '" id="scale_show_icon_SP'.$key.'" style="width:25px; height: 25px; display:none;" title="' . $design_data['scale_heading'] . '" onclick="ShowScale_SP(' . $key . ');">';
			                                        }
			                                        if ($time_show_icon != '') {
			                                            $special_html.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $time_show_icon . '" id="time_show_icon_SP'.$key.'" style="width:25px; height: 25px; display:none;" title="Select ' . $design_data['time_heading'] . '" onclick="Showtime_SP(' . $key . ');">';
			                                        }
			                                        if ($duration_show_icon != '') {
			                                            $special_html.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $duration_show_icon . '"  id="duration_show_icon_SP'.$key.'" style="width:25px; height: 25px; display:none;" title="' . $design_data['duration_heading'] . '" onclick="DurationShow_SP(' . $key . ');">';
			                                        }
			                                        if ($user_date_icon != '') {
			                                            $special_html.= '&nbsp;&nbsp;&nbsp;<img src="uploads/' . $user_date_icon . '"  id="user_date_show_icon_SP'.$key.'" style="width:25px; height: 25px; display:none;" title="' . $design_data['user_date_heading'] . '" onclick="ShowUserDate_SP(' . $key . ');">';
			                                        }

			                                        
			                                    }
			                                    $special_html.= '</p>';
			                                        $special_html.= '<div class="md-col-12">';
			                                        for ($x = 1;$x <= 11;$x++)
			                                        {

			                                            if ($design_data['location_order_show'] == $x && ($design_data['location_show']  == 1 || $design_data['location_show'] == 3) && in_array('Location', $icon_source)) {
			                                                $special_html.= '<select  class="input-text-box input-quarter-width" name="location_SP['.$key.']" id="location_SP' . $key . '" style="display:none;" title="' . $design_data['location_heading'] . '">

			                                                                  <option value="">' . $design_data['location_heading'] . '</option>

			                                                                  ' . $obj->getFavCategoryRamakant($design_data['location_fav_cat'], '') . '

			                                                              </select>';
			                                            }
			                                            if ($design_data['like_dislike_order_show'] == $x && ($design_data['User_view']  == 1 || $design_data['User_view'] == 3) && in_array('User_Response', $icon_source)) {
			                                                $special_html.= '<select  class="input-text-box input-quarter-width" name="User_view_SP['.$key.']" id="User_view_SP' . $key . '" style="display:none;" title="' . $design_data['like_dislike_heading'] . '">

			                                                                  <option value="">' . $design_data['like_dislike_heading'] . '</option>

			                                                                  ' . $obj->getFavCategoryRamakant($design_data['user_response_fav_cat'], '') . '

			                                                              </select>';
			                                            }
			                                            if ($design_data['set_goals_order_show'] == $x && ($design_data['User_Interaction']  == 1 || $design_data['User_Interaction'] == 3) && in_array('User_What_Next', $icon_source)) {
			                                                $special_html.= '<select  class="input-text-box input-quarter-width" name="User_Interaction_SP['.$key.']" id="User_Interaction_SP'.$key.'" style="display:none;" title="' . $design_data['set_goals_heading'] . '">

			                                                                  <option value="">' . $design_data['set_goals_heading'] . '</option>

			                                                                  ' . $obj->getFavCategoryRamakant($design_data['user_what_fav_cat'], '') . '

			                                                              </select>';
			                                            }
			                                            if ($design_data['reminder_order_show'] == $x && ($design_data['alert_show']  == 1 || $design_data['alert_show'] == 3) && in_array('Alert_Update', $icon_source)) {
			                                               $special_html.= '<select class="input-text-box input-quarter-width" name="alert_SP['.$key.']" id="alert_SP'.$key.'" style="display:none;" title="' . $design_data['reminder_heading'] . '">

			                                                                  <option value="">' . $design_data['reminder_heading'] . '</option>

			                                                                  ' . $obj->getFavCategoryRamakant($design_data['alerts_fav_cat'], '') . '

			                                                              </select>';
			                                            }
			                                            if ($design_data['comment_order_show'] == $x && ($design_data['comment_show']  == 1 || $design_data['comment_show'] == 3) && in_array('Comment', $icon_source)) {
			                                                $special_html.= '<textarea  name="comment_SP['.$key.']" id="comment_SP'.$key.'"  placeholder="' . $design_data['comments_heading'] . '" title="' . $design_data['comments_heading'] . '" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"></textarea>';
			                                            }
			                                            if ($design_data['scale_order_show'] == $x && ($design_data['scale_show']  == 1 || $design_data['scale_show'] == 3) && in_array('Scale', $icon_source)) {
			                                               $special_html.= '<select  class="input-text-box input-quarter-width" name="scale_SP['.$key.']" id="scale_SP'.$key.'" style="display:none;" title="' . $design_data['scale_heading'] . '">
			                                                        <option value="">' . $design_data['scale_heading'] . '</option>
			                                                        <option value="1">1</option>
			                                                        <option value="2">2</option>
			                                                        <option value="3">3</option>
			                                                        <option value="4">4</option>
			                                                        <option value="5">5</option>
			                                                        <option value="6">6</option>
			                                                        <option value="7">7</option>
			                                                        <option value="8">8</option>
			                                                        <option value="9">9</option>
			                                                        <option value="10">10</option>
			                                                    </select>';
			                                            }
			                                            if ($design_data['time_order_show'] == $x && ($design_data['time_show']  == 1 || $design_data['time_show'] == 3) && in_array('Time', $icon_source)) {
			                                                $special_html.= '<input type="time" class="input-text-box input-quarter-width" name="bes_time_SP['.$key.']"  id="bes_time_SP'.$key.'" style="display: none;" placeholder="' . $design_data['time_heading'] . '" title="' . $design_data['time_heading'] . '" />';
			                                                 $special_html.= '<p class="text-danger" id="time_note_SP'.$key.'" style="display:none;font-size: 11px;"><a href="images/Device-SystemTime-Format.png" target="_blank" style="color: red;    text-decoration: underline;">Displays AM/PM or 24 Hour Format as per your Device Time Setting</a></p>';

			                                            }
			                                            if ($design_data['duration_order_show'] == $x && ($design_data['duration_show']  == 1 || $design_data['duration_show'] == 3) && in_array('Duration', $icon_source)) {
			                                                 $special_html.= '<input type="text" name="duration_SP['.$key.']" id="duration_SP'.$key.'" onKeyPress="return isNumberKey(event);" placeholder="' . $design_data['duration_heading'] . '" class="input-text-box input-sml-width" autocomplete="false" style="display:none;">';
			                                                $special_html.= '<select  class="input-text-box input-quarter-width" name="unit_SP[]" id="unit_SP'.$key.'" title="Duration Type" style="display:none;">
			                                                        <option value="">Select Unit</option>
			                                                            '.$obj->getFavCategoryRamakant('82','').'
			                                                        </select>';
			                                            }
			                                            if ($design_data['user_date_order_show'] == $x &&($design_data['user_date_show']  == 1 || $design_data['user_date_show'] == 3) && in_array('Date', $icon_source)) {
			                                                $special_html.= '<span class="">

			                                                  <select name="userdate_SP['.$key.']" id="userdate_SP'.$key.'" onchange="toggleDateSelectionType_multiple_SP(\'userdate_SP\','.$key.')" style="width:200px;display:none;" class="input-text-box input-quarter-width">

			                                                      <option value="">Select Date Type</option>

			                                                      <option value="days_of_month"';
			                                                if ($listing_date_type == 'days_of_month') {
			                                                    $special_html.= 'selected="selected"';
			                                                }
			                                                $special_html.= '>Days of Month</option><option value="single_date"';
			                                                if ($listing_date_type == 'single_date') {
			                                                    $special_html.= 'selected="selected"';
			                                                }
			                                                $special_html.= '>Single Date</option><option value="date_range"';
			                                                if ($listing_date_type == 'date_range') {
			                                                    $special_html.= 'selected="selected"';
			                                                }
			                                                $special_html.= '>Date Range</option> <option value="month_wise"';
			                                                if ($listing_date_type == 'month_wise') {
			                                                    $special_html.= 'selected="selected"';
			                                                }
			                                                $special_html.= '>Month Wise</option><option value="days_of_week"';
			                                                if ($listing_date_type == 'days_of_week') {
			                                                    $special_html.= 'selected="selected"';
			                                                }
			                                                $special_html.= '>Days of Week</option>

			                                                             </select>

			                                                             </span>';

			                                                 $special_html.='<span>

			                                                    <table style="margin-top:5px;">

			                                                    <tr id="tr_days_of_month_SP'.$key.'" style="display:' . $tr_days_of_month . '">

			                                                            <td align="right" valign="top"><strong>Select days of month</strong></td>

			                                                            <td align="center" valign="top"><strong>:</strong></td>

			                                                            <td align="left">

			                                                                <select id="days_of_month_SP'.$key.'" name="days_of_month_SP['.$key.'][]" multiple="multiple" style="width:500px;" class="input-text-box input-quarter-width">';
			                                        // for ($i = 1;$i <= 31;$i++) {
			                                        //     $special_html.= '<option value="' . $i . '"';
			                                        //     if (in_array($i, $arr_days_of_month)) {
			                                        //         $special_html.= 'selected="selected"';
			                                        //     }
			                                        //     $special_html.= '>' . $i . '</option>';
			                                        // }
													$arr_days_of_month = $arr_days_of_month ?? [];

													foreach (range(1, 31) as $i) {
														$selected = in_array($i, $arr_days_of_month) ? ' selected' : '';
														$special_html .= "<option value='{$i}'{$selected}>{$i}</option>";
													}
			                                        $special_html.= '</select>&nbsp;*<br>

			                                                           You can choose more than one option by using the ctrl key.

			                                                          </td>

			                                                         </tr>';
			                                        $special_html.= '<tr id="tr_single_date_SP'.$key.'" style="display:' . $tr_single_date . '">

			                                                            <td align="right" valign="top"><strong>Select Date</strong></td>

			                                                            <td align="center" valign="top"><strong>:</strong></td>

			                                                            <td align="left">

			                                                                <input name="single_date_SP['.$key.']" id="single_date_SP'.$key.'" type="text" value="' . $single_date . '" class="input-text-box" onmouseover="callDatecalender('.$key.')">';
			                                        $special_html.= '</td>

			                                                        </tr>



			                                                        <tr id="tr_date_range_SP'.$key.'" style="display:' . $tr_date_range . '">

			                                                            <td align="right" valign="top"><strong>Select Date Range</strong></td>

			                                                            <td align="center" valign="top"><strong>:</strong></td>

			                                                            <td align="left">

			                                                                <input name="start_date_SP['.$key.']" id="start_date_SP'.$key.'" type="text" value="' . $start_date . '" style="width:200px;" class="input-text-box" onmouseover="callDatecalender('.$key.')"/> - <input name="end_date_SP['.$key.']" id="end_date_SP'.$key.'" type="text" value="' . $end_date . '" style="width:200px;" class="input-text-box" onmouseover="callDatecalender('.$key.')"/>';
			                                        $special_html.= '</td>

			                                                        </tr>



			                                                        <tr id="tr_days_of_week_SP'.$key.'" style="display:' . $tr_days_of_week . '">

			                                                            <td align="right" valign="top"><strong>Select days of week</strong></td>

			                                                            <td align="center" valign="top"><strong>:</strong></td>

			                                                            <td align="left">

			                                                                <select id="days_of_week_SP'.$key.'" name="days_of_week_SP['.$key.'][]" multiple="multiple" class="input-text-box">';
			                                        $special_html.= $obj->getDayOfWeekOptionsMultiple($arr_days_of_week);
			                                        $special_html.= '</select>&nbsp;*<br>

			                                                                You can choose more than one option by using the ctrl key.

			                                                            </td>

			                                                        </tr>';
			                                        $special_html.= '<tr id="tr_month_date_SP'.$key.'" style="display:' . $tr_month_date . '">

			                                                            <td align="right" valign="top"><strong>Select Month</strong></td>

			                                                            <td align="center" valign="top"><strong>:</strong></td>

			                                                            <td align="left">

			                                                                <select id="months_SP'.$key.'" name="months_SP['.$key.'][]" multiple="multiple" class="input-text-box">';
			                                        $special_html.= $obj->getMonthsOptionsMultiple($arr_month);
			                                        $special_html.= '</select>&nbsp;*<br>

			                                                                You can choose more than one option by using the ctrl key.

			                                                            </td>

			                                                        </tr>

			                                                        </table>

			                                                    </div><br>';
			                                            }

			                                        }

			                                      // if($design_data['scale_show']  == 0)
			                                      //       { 
			                                      //           $special_html.= '<input type="hidden" name="scale_SP[]">'; 
			                                      //       }
			                                      //       if($design_data['comments_show']  == 0)
			                                      //       {
			                                      //           $special_html.= '<input type="hidden" name="comment_SP[]">'; 
			                                      //       }
			                                   
			                            $special_html.= '</span><br>';
			                            
			                        } //icon type end
			                        elseif($value['icon_type']==2 || $value['icon_type']==3)
			                        {   
			                            $icon_source=explode(',', $value['icon_source']);
			                            //$icon_data_dropdown="";
			                                        for ($x = 1;$x <= 11;$x++) 
			                                        {   
			                                            
			                                            if (in_array('Location', $icon_source) && $design_data['location_order_show'] == $x && ($design_data['location_show']  == 1 || $design_data['location_show'] == 3)) {
			                                                
			                                                $icon_data_dropdown1=$obj->getFavCategoryShortData($design_data['location_fav_cat'], '');

			                                                if(!empty($icon_data_dropdown1))
			                                                {
			                                                    $special_html.= '<h6 class="Header_brown">'.$design_data['location_heading'].'</h6>';
			                                                    $special_html.= '<div class="checkbox-style">';
			                                                        if($value['icon_type']==2)
			                                                        {
			                                                            foreach ($icon_data_dropdown1 as $fev_key => $fev_value) {
			                                                                $special_html.= '<label class="checkbox-inline"><input type="checkbox" name="location_SP['.$key.'][]" value="'.$fev_value['favcat_id'].'">'.stripslashes($fev_value['fav_cat']).'</label>';
			                                                            }
			                                                        }
			                                                        elseif($value['icon_type']==3)
			                                                        {
			                                                            foreach ($icon_data_dropdown1 as $fev_key => $fev_value) {
			                                                                $special_html.= '<label class="radio-inline"><input type="radio" name="location_SP['.$key.']" value="'.$fev_value['favcat_id'].'">'.stripslashes($fev_value['fav_cat']).'</label>';
			                                                            }
			                                                        }
			                                                    $special_html.= '</div>';
			                                                }
			                                                
			                                            }
			                                            if (in_array('User_Response', $icon_source) && $design_data['like_dislike_order_show'] == $x && ($design_data['User_view']  == 1 || $design_data['User_view'] == 3)) {
			                    
			                                                 $icon_data_dropdown2=$obj->getFavCategoryShortData($design_data['user_response_fav_cat']);

			                                                if(!empty($icon_data_dropdown2))
			                                                {
			                                                    $special_html.= '<h6 class="Header_brown">'.$design_data['like_dislike_heading'].'</h6>';
			                                                    $special_html.= '<div class="checkbox-style">';
			                                                    if($value['icon_type']==2)
			                                                    {
			                                                        foreach ($icon_data_dropdown2 as $fev_key => $fev_value) {
			                                                                $special_html.= '<label class="checkbox-inline"><input type="checkbox" name="User_view_SP['.$key.'][]" value="'.$fev_value['favcat_id'].'">'.stripslashes($fev_value['fav_cat']).'</label>';
			                                                            }
			                                                    }
			                                                    elseif($value['icon_type']==3)
			                                                    {
			                                                        foreach ($icon_data_dropdown2 as $fev_key => $fev_value) {
			                                                                $special_html.= '<label class="radio-inline"><input type="radio" name="User_view_SP['.$key.']" value="'.$fev_value['favcat_id'].'">'.stripslashes($fev_value['fav_cat']).'</label>';
			                                                            }
			                                                    }

			                                                            
			                                                    $special_html.= '</div>';
			                                                }
			                                            }
			                                            if (in_array('User_What_Next', $icon_source) && $design_data['set_goals_order_show'] == $x && ($design_data['User_Interaction']  == 1 || $design_data['User_Interaction'] == 3)) {
			                                                 
			                                                $icon_data_dropdown3=$obj->getFavCategoryShortData($design_data['user_what_fav_cat']);

			                                                if(!empty($icon_data_dropdown3))
			                                                {
			                                                    $special_html.= '<h6 class="Header_brown">'.$design_data['set_goals_heading'].'</h6>';
			                                                    $special_html.= '<div class="checkbox-style">';
			                                                    if($value['icon_type']==2)
			                                                    {
			                                                        foreach ($icon_data_dropdown3 as $fev_key => $fev_value) {
			                                                                $special_html.= '<label class="checkbox-inline"><input type="checkbox" name="User_Interaction_SP['.$key.'][]" value="'.$fev_value['favcat_id'].'">'.stripslashes($fev_value['fav_cat']).'</label>';
			                                                            }
			                                                    }
			                                                    elseif($value['icon_type']==3)
			                                                    {
			                                                        foreach ($icon_data_dropdown3 as $fev_key => $fev_value) {
			                                                                $special_html.= '<label class="radio-inline"><input type="radio" name="User_Interaction_SP['.$key.']" value="'.$fev_value['favcat_id'].'">'.stripslashes($fev_value['fav_cat']).'</label>';
			                                                            }
			                                                    }
			                                                            
			                                                    $special_html.= '</div>';
			                                                }
			                                            }
			                                            if (in_array('Alert_Update', $icon_source) && $design_data['reminder_order_show'] == $x && ($design_data['alert_show']  == 1 || $design_data['alert_show'] == 3)) {

			                                                $icon_data_dropdown4=$obj->getFavCategoryShortData($design_data['alerts_fav_cat']);

			                                                if(!empty($icon_data_dropdown4))
			                                                {
			                                                    $special_html.= '<h6 class="Header_brown">'.$design_data['reminder_heading'].'</h6>';
			                                                    $special_html.= '<div class="checkbox-style">';
			                                                    if($value['icon_type']==2)
			                                                    {
			                                                        foreach ($icon_data_dropdown4 as $fev_key => $fev_value) {
			                                                                $special_html.= '<label class="checkbox-inline"><input type="checkbox" name="alert_SP['.$key.'][]" value="'.$fev_value['favcat_id'].'">'.stripslashes($fev_value['fav_cat']).'</label>';
			                                                            }
			                                                    }
			                                                    elseif($value['icon_type']==3)
			                                                    {
			                                                        foreach ($icon_data_dropdown4 as $fev_key => $fev_value) {
			                                                                $special_html.= '<label class="radio-inline"><input type="radio" name="alert_SP['.$key.']" value="'.$fev_value['favcat_id'].'">'.stripslashes($fev_value['fav_cat']).'</label>';
			                                                            }
			                                                    }
			                                                            
			                                                    $special_html.= '</div>';
			                                                }
			                                            }
			                                            
			                                        }
			                                        $special_html.='<p style="clear: both;"><br></p>';
			                                        for ($x = 1;$x <= 11;$x++) 
			                                        {
			                                            if (in_array('Comment', $icon_source) && $design_data['comment_order_show'] == $x && ($design_data['comment_show']  == 1 || $design_data['comment_show'] == 3)) {
			                                                $special_html.= '<p><textarea  name="comment_SP['.$key.']" id="comment_SP'.$key.'"  placeholder="' . $design_data['comments_heading'] . '" title="' . $design_data['comments_heading'] . '" class="input-text-box input-quarter-width" autocomplete="false"></textarea></p>';
			                                            }
			                                            if (in_array('Scale', $icon_source) && $design_data['scale_order_show'] == $x && ($design_data['scale_show']  == 1 || $design_data['scale_show'] == 3)) {
			                                               $special_html.= '<p><select  class="input-text-box input-quarter-width" name="scale_SP['.$key.']" id="scale_SP'.$key.'"  title="' . $design_data['scale_heading'] . '">
			                                                        <option value="">' . $design_data['scale_heading'] . '</option>
			                                                        <option value="1">1</option>
			                                                        <option value="2">2</option>
			                                                        <option value="3">3</option>
			                                                        <option value="4">4</option>
			                                                        <option value="5">5</option>
			                                                        <option value="6">6</option>
			                                                        <option value="7">7</option>
			                                                        <option value="8">8</option>
			                                                        <option value="9">9</option>
			                                                        <option value="10">10</option>
			                                                    </select></p>';
			                                            }
			                                            if (in_array('Time', $icon_source) && $design_data['time_order_show'] == $x && ($design_data['time_show']  == 1 || $design_data['time_show'] == 3)) {
			                                                $special_html.= '<p><input type="time" class="input-text-box input-quarter-width" name="bes_time_SP['.$key.']"  id="bes_time_SP'.$key.'" placeholder="' . $design_data['time_heading'] . '" title="' . $design_data['time_heading'] . '" />';
			                                                 $special_html.= '<span class="text-danger" id="time_note_SP'.$key.'" style="font-size: 11px;"><a href="images/Device-SystemTime-Format.png" target="_blank" style="color: red;    text-decoration: underline;">Displays AM/PM or 24 Hour Format as per your Device Time Setting</a></sapn></p>';

			                                            }
			                                            if (in_array('Duration', $icon_source) && $design_data['duration_order_show'] == $x && ($design_data['duration_show']  == 1 || $design_data['duration_show'] == 3)) {
			                                                 $special_html.= '<p><input type="text" name="duration_SP['.$key.']" id="duration_SP'.$key.'" onKeyPress="return isNumberKey(event);" placeholder="' . $design_data['duration_heading'] . '" class="input-text-box input-sml-width" autocomplete="false">';
			                                                $special_html.= '<select  class="input-text-box input-quarter-width" name="unit_SP[]" id="unit_SP'.$key.'" title="Duration Type">
			                                                        <option value="">Select Unit</option>
			                                                            '.$obj->getFavCategoryRamakant('82','').'
			                                                        </select></p>';
			                                            }
			                                        }
			                                        // if($design_data['scale_show']  == 0)
			                                        //     { 
			                                        //         $special_html.= '<input type="hidden" name="scale_SP[]">'; 
			                                        //     }
			                                        //     if($design_data['comments_show']  == 0)
			                                        //     {
			                                        //         $special_html.= '<input type="hidden" name="comment_SP[]">'; 
			                                        //     }
			                                        // $special_html.= '<input type="hidden" name="userdate_SP[]" />
			                                        //               <input type="hidden" name="single_date_SP[]" />
			                                        //               <input type="hidden" name="start_date_SP[]" />
			                                        //               <input type="hidden" name="end_date_SP[]" />
			                                        //                 ';
			                        }
			                        else
			                        {
			                            $special_html.= '
			                                          <input type="hidden" name="location_SP['.$key.']" />
			                                          <input type="hidden" name="alert_SP['.$key.']" />
			                                          <input type="hidden" name="User_view_SP['.$key.']" />
			                                          <input type="hidden" name="User_Interaction_SP['.$key.']" />
			                                          <input type="hidden" name="comment_SP['.$key.']" />
			                                          <input type="hidden" name="duration_SP['.$key.']" />
			                                          <input type="hidden" name="unit_SP['.$key.']" />
			                                          <input type="hidden" name="scale_SP['.$key.']" />
			                                          <input type="hidden" name="bes_time_SP['.$key.']" />
			                                          <input type="hidden" name="userdate_SP['.$key.']" />
			                                            <br>';
			                        }
			                    if($value['rank_show']==1) 
			                    {
			                        $special_html.= '<p><select  class="input-text-box input-quarter-width" name="rank_SP['.$key.']" id="rank_SP'.$key.'"  title="Ranking">';
			                                        $special_html.= '<option value="">Choose Rank</option>';
			                            for ($z=1; $z < 21; $z++) 
			                                { 
			                                     $special_html.= '<option value="'.$z.'">'.$z.'</option>';
			                                }                     
			                         $special_html.= '</select></p>';
			                    }
			                }
			                $special_html.= '</div>';
			            }
			            echo $special_html;
			            ?>
					  	<div class="form-group" style="margin-top: 25px;">
					  		<input type="hidden" name="user_id" id="user_id" value="<?=$user_id;?>">
					  		<input type="hidden" name="vendor_id" id="vendor_id" value="<?=$_GET['vendor_id'];?>">
					  		<input type="hidden" id="contact_id" name="contact_id" value="">
					  		<input type="hidden" id="ref_code" name="ref_code" value="<?=$_GET['ref_code'];?>">
					  		<input type="hidden" id="group_id" name="group_id" value="<?=$_GET['group_id'];?>">
					  		<input type="hidden" id="design_data_id" name="design_data_id" value="<?=$design_data_id;?>">
					  		<?php 
					  			if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
					  			{
					  				?>
					  				<button type="submit" class="btn btn-default" id="btnSave" disabled>Submit</button>
					  				<?php
					  			}
					  		?>
					  		
						</div>
					</form>
				  </div>


              </div>
            </div>
        </div>
        <div class="col-md-2"><?php include_once('left_sidebar.php'); ?></div>
        <div class="col-md-2"><?php include_once('right_sidebar.php'); ?></div>
      </div>
    </div>
  </section>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Contact Persons</h4>
        </div>
        <div class="modal-body">

        	<table class="table">
		    <thead>
		      <tr>
		        	<th>#</th>
			        <th>Name</th>
			        <th>Location</th>
			        <th>Action</th>
		      </tr>
		    </thead>
		    <tbody>
        	<?php
        		if(!empty($vendor_data['persons']))
        		{	
        			foreach ($vendor_data['persons'] as $key => $value) {
        				?>
        				<tr>
	        				<td><?=$key+1;?></td>
					        <td><?=$value['contact_person'];?></td>
					        <td><?=$value['area_name'];?>,<?=$value['city'];?>,<?=$value['state'];?>,<?=$value['country_name'];?></td>
					        <td><button onclick="setContactPerson('<?=$value['contact_id'];?>','<?=$value['contact_person'];?>','<?=$value['area_name'];?>','<?=$value['city'];?>','<?=$value['state'];?>','<?=$value['country_name'];?>')">Select</button></td>
					    </tr>
        				<?php
        			}
        		}
        		else
        		{
        			?>
        			<tr>
				        <td colspan="4">No Rcords Found</td>
				    </tr>
        			<?php
        		}
        	?>
		    </tbody>
		  </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include_once('footer.php');?> 

<script type="text/javascript">

	// $(document).ready(function(){
 //    	$("#appt_time").mouseleave(function(){
	// 	  alert('-s-');
	// 	});
	// });


	$('#appt_date').datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});

    //write by ample 22-06-20

    function setContactPerson(contact_id,person,area,city,state,country)
    {
    	var location=area+','+city+','+state+','+country;

    	$('#contact_id').val(contact_id);
    	$('#meet_person').val(person);
    	$('#meet_location').val(location);
    	$("#myModal button.close").trigger('click');
    	//$("#myModal").modal("hide");
    	$('#appt_date').val('');
    	$('#slot_data').html('');
    	$("#btnSave").attr("disabled", true);

    }

    //add by ample 09-07-20
    function get_slot()
    {
    	var date=$('#appt_date').val();
    	var contact_id=$('#contact_id').val();
    	var user_id=$('#user_id').val();
    	var vendor_id=$('#vendor_id').val();

    	if(contact_id=='')
    	{	
    		$('#appt_date').val('');
    		alert('Please select contact person');
    		return false;
    	}

          var dataString ='action=get_session_slots&date='+date+'&contact_id='+contact_id+'&vendor_id='+vendor_id+'&user_id='+user_id;
          $.ajax({
            type: "POST",
            url: "remote.php",
            data: dataString,
            cache: false,
            success: function(result)
            {
               //alert(result);
               var obj = jQuery.parseJSON(result);
               $('#slot_data').html(obj.html);
               if(obj.error==0)
               {
               		$("#btnSave").attr("disabled", false);
               		$('#btnSave').removeAttr("disabled");
               }
               else
               {
               	 	$("#btnSave").attr("disabled", true);
               }
            }

          });
    }

  	function appointment_save()
  	{	
  		event.preventDefault();

  		var date = $('#appt_date').val();

  		var time=$('#appt_time').val();

  		var contact_id = $('#appt_time').attr("data-id");


  		if(time=='')
  		{
  			alert('Time is requried');
  			return false;
  		}

  		if(date=='')
  		{
  			alert('Time is requried');
  			return false;
  		}

  		if(contact_id=="")
  		{
  			appointment_form_submit();
  		}
  		else
  		{
  			 var dataString ='action=check_time_slot&time='+time+'&date='+date+'&contact_id='+contact_id;
          	$.ajax({
            type: "POST",
            url: "remote.php",
            data: dataString,
            cache: false,
            success: function(result)
	            {
	               //alert(result);
	               if(result==1)
	               {
	               		appointment_form_submit();
	               }
	               else
	               {
	               	 	alert('Entered time not match with slot time!')
	               }
	            }
         	});
  		}

  	}

  	function appointment_form_submit()
  	{
  		
		var form_data = $('#appointment_form').serialize(); //Encode form elements for submission
		
		$.ajax({
			url : 'appointment-request.php',
			type: 'post',
			data : form_data
		}).done(function(response){ //
			alert(response);
      window.location = "appointment-list.php";
			//location.reload();
			//$("#server-results").html(response);
		});
  	}
         
          function callDatecalender(num)
         
          {
         

            $('#single_date_SP'+num).datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
         
            $('#start_date_SP'+num).datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
         
            $('#end_date_SP'+num).datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'}); 

         
          }

           //special case icone copy by ample 28-05-20
         function ShowloopSP(id)
         
         {
         
         // alert(id);
         
         $("#comment_show_icon_SP"+id).show(); 
         
         $("#location_show_icon_SP"+id).show(); 
         
         $("#User_view_icon_SP"+id).show(); 
         
         $("#User_Interaction_icon_SP"+id).show(); 
         
         $("#alert_show_icon_SP"+id).show(); 
         
         $("#user_date_show_icon_SP"+id).show();
         
         $("#scale_show_icon_SP"+id).show();
         
         $("#time_show_icon_SP"+id).show();
         
         $("#duration_show_icon_SP"+id).show();
         
         }



            function ShowComment_SP(id)
         
            {
         
              // alert(id);
         
              $('#comment_SP'+id).show();  
         
            }
         
         
         
         
         
         function ShowLocation_SP(id)
         
            {
         
              // alert("hiiii");
         
              $('#location_SP'+id).show();  
         
            }
         
         
         
              function ShowUserview_SP(id)
         
            {
         
              //alert("hiiii");
         
              $('#User_view_SP'+id).show();  
         
            }
         
         
         
            function ShowUserInteraction_SP(id)
         
            {
         
              //alert("hiiii");
         
              $('#User_Interaction_SP'+id).show();  
         
            }
         
         
         
          function ShowAlert_SP(id)
         
            {
         
              //alert("hiiii");
         
              $('#alert_SP'+id).show();  
         
            }
         
         
         
            function ShowUserDate_SP(id)
         
            {
         
              //alert("hiiii");
         
              $('#userdate_SP'+id).show();  
         
            }
         
         
         
         
         
           function ShowScale_SP(id)
         
            {
         
              // alert("hiiii");
         
              $('#scale_SP'+id).show();  
         
            }
         
         
         
            
         
          function Showtime_SP(id)
         
            {
         
              // alert(id);
         
              $('#bes_time_SP'+id).show();  
              $('#time_note_SP'+id).show(); // add by ample 22-04-20
         
            }
         
            
         
            function DurationShow_SP(id)
         
            {
         
              //alert("hiiii");
         
              $('#duration_SP'+id).show();  
              $('#unit_SP'+id).show(); //add by ample 22-04-20
         
            }


          //specail case date type copy by ample 18-07-20

        function toggleDateSelectionType_multiple_SP(id_val,num)
         
         
         
         {
         
         // alert(num);
         
         // console.log(id_val+'_'+num);
         
            var sc_listing_date_type = document.getElementById(id_val+num).value;

         
         $('.tab_show'+num).show();
         
            if (sc_listing_date_type == "days_of_month") 
         
            {   
         
                document.getElementById('tr_days_of_month_SP'+num).style.display = '';
         
                document.getElementById('tr_single_date_SP'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_SP'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_SP'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_SP'+num).style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "single_date") 
         
            {   
         
                document.getElementById('tr_days_of_month_SP'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_SP'+num).style.display = '';
         
                document.getElementById('tr_date_range_SP'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_SP'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_SP'+num).style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "date_range") 
         
            {   
         
                document.getElementById('tr_days_of_month_SP'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_SP'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_SP'+num).style.display = '';
         
                document.getElementById('tr_days_of_week_SP'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_SP'+num).style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "days_of_week") 
         
            {   
         
                document.getElementById('tr_days_of_month_SP'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_SP'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_SP'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_SP'+num).style.display = '';
         
                document.getElementById('tr_month_date_SP'+num).style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "month_wise") 
         
            {   
         
                document.getElementById('tr_days_of_month_SP'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_SP'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_SP'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_SP'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_SP'+num).style.display = '';
         
            }
         
            else
         
            {   
         
         
         
                document.getElementById('tr_days_of_month_SP'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_SP'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_SP'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_SP'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_SP'+num).style.display = 'none';
         
            }
         
         
         
         }
</script>

  </body>

</html>