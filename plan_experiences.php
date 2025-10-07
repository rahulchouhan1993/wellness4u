<?php 

include('classes/config.php');

$page_id = '136';

$obj = new frontclass();

$obj2 = new frontclass2();


$page_data = $obj->getPageDetails($page_id);


$ref = base64_encode($page_data['menu_link']);



    if($obj->isLoggedIn())
     {
     
          $user_id = $_SESSION['user_id'];
     
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
  		background: #555;
    	color: #fff;
  	}
  	.btn-dark:hover
  	{
  		color: #eee;
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
          <div class="col-md-10" id="bgimage" style="background-repeat:repeat; padding:5px;">
            <div class="row">
              <div class="col-md-12" id="testdata">
                <?php echo $obj->getPageIcon($page_id);?>
                <span class="Header_brown"><?php echo $page_data['page_title'];?></span><br /><br />
                <?php echo $obj->getPageContents($page_id);?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
              			<?php
                           if(!empty($_SESSION['success_msg'])) 
                           {
                              $message = $_SESSION['success_msg'];
                              echo '<div class="alert alert-success">'.$message.'</div>';
                              unset($_SESSION['success_msg']);
                           }

                           if(!empty($_SESSION['error_msg'])) 
                           {
                              $message = $_SESSION['error_msg'];
                              echo '<div class="alert alert-error">'.$message.'</div>';
                              unset($_SESSION['error_msg']);
                           }

                           ?>
                         <hr>
                    <form role="form" class="form-horizontal" method="post" novalidate="novalidate">
                    	<div class="form-group row">
						    <div class="col-md-6">
						    	<label class="control-label col-sm-3">Your Name:<span style="color:red">*</span></label>
							    <div class="col-sm-9">
							      <input type="text" class="form-control" placeholder="Enter name" required>
							    </div>
						    </div>
						    <div class="col-md-6">
						    	<label class="control-label col-sm-3">Company:</label>
							    <div class="col-sm-9">
							      <input type="text" class="form-control" placeholder="Enter company">
							    </div>
						    </div>
						</div>
						<div class="form-group row">
						    <div class="col-md-6">
						    	<label class="control-label col-sm-3" >Email:<span style="color:red">*</span></label>
							    <div class="col-sm-9">
							      <input type="email" class="form-control"  placeholder="Enter email" required>
							    </div>
						    </div>
						    <div class="col-md-6">
						    	<label class="control-label col-sm-3">Phone:<span style="color:red">*</span></label>
							    <div class="col-sm-9">
							      <input type="number" class="form-control"  placeholder="Enter Mobile" required>
							    </div>
						    </div>
						</div>
						<div class="form-group row">
						    <div class="col-md-6">
						    	<label class="control-label col-sm-3">Event Name:<span style="color:red">*</span></label>
							    <div class="col-sm-9">
							      <input type="text" class="form-control" placeholder="Enter event" required>
							    </div>
						    </div>
						    <div class="col-md-6">
						    	<label class="control-label col-sm-3">Event Type:</label>
							    <div class="col-sm-9">
							       <select name="event_type" id="event_type" class="form-control">
                                        <option value="">Select Event Type</option>
                                        <?php echo $obj->getFavCategoryRamakant('60', $event_type); ?>
                                    </select>
							    </div>
						    </div>
						</div>

                    <div id="row_loc_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
                    	<div class="form-group left-label">
							<label class="col-lg-2 control-label Header_brown"><strong>Event Details:</strong></label>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Event Format<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="event_format[]" required="" id="event_format_<?php echo $i;?>" class="form-control" onchange="CheckTeamType(<?php echo $i;?>);">
									<option value="">Select Event Format</option>
									<?php echo $obj->getFavCategoryRamakant('74',''); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="country_id[]" id="country_id_<?php echo $i;?>" onchange="getStateOptionAddMore(<?php echo $i;?>)" class="form-control" required>
									<?php echo $obj->getCountryOption($arr_country_id[$i]); ?>
								</select>
							</div>
							<label class="col-lg-2 control-label">State<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="state_id[]" id="state_id_<?php echo $i;?>" onchange="getCityOptionAddMore(<?php echo $i;?>)" class="form-control" required>
									<?php echo $obj->getStateOption($arr_country_id[$i],$arr_state_id[$i]); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" required="" name="city_id[]" id="city_id_<?php echo $i;?>" placeholder="Select your city" list="capitals_<?php echo $i;?>" class="form-control" onchange="getlocation(<?php echo $i;?>)" />
								<datalist id="capitals_<?php echo $i;?>">
									<?php echo $obj->getCityOptions(0); ?>
								</datalist>
							</div>
							<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="area_id[]" id="area_id_<?php echo $i;?>" class="form-control" required>
									<?php echo $obj->getAreaOption($arr_country_id[$i],$arr_state_id[$i],$arr_city_id[$i],$arr_area_id[$i]); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Venue<span style="color:red">*</span></label>
							<div class="col-lg-10">
								<textarea name="venue[]" id="venue_<?php echo $i;?>" class="form-control" required=""></textarea>
							</div>
						</div>
						<div class="form-group small-title">
							<label class="col-lg-2 control-label">Start Date <span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input required="" type="text" name="start_date[]" id="start_date_<?php echo $i;?>" style="width:200px; float:left;" value="<?php echo $arr_start_date_time_[$i];?>" placeholder="Start Date" class="form-control clsdatepicker">
								<select name="start_time[]" id="start_time_<?php echo $i;?>" required="" class="form-control" style="width:120px;">
									<option value="">Select Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
							</div>
							<label class="col-lg-2 control-label">End Date <span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="end_date[]" required="" id="end_date_<?php echo $i;?>" style="width:200px; float:left;" value="<?php echo $arr_end_date_time_[$i];?>" placeholder="End Date" class="form-control clsdatepicker">
								<select name="end_time[]" id="end_time_<?php echo $i;?>" required="" class="form-control" style="width:120px;">
									<option value="">Select Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Time Zone<span style="color:red">*</span></label>
							<div class="col-lg-10">
								<select name="time_zone[]" required="" id="time_zone_<?php echo $i;?>" class="form-control">
									<option value="">Select Time Zone</option>
									<?php echo $obj->getFavCategoryRamakant('59',''); ?>
								</select>
							</div>
						</div>
						<div class="form-group left-label">
							<label class="col-lg-2 control-label Header_brown"><strong>Sessions:</strong></label>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Slot 1<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="slot1_start_time[]" id="slot1_start_time_<?php echo $i;?>" required="" style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">
									<option value="">From Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
								<select name="slot1_end_time[]" id="slot1_end_time_<?php echo $i;?>" required="" style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">
									<option value="">To Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
							</div>
							<label class="col-lg-2 control-label">Slot 2</label>
							<div class="col-lg-4">
								<select name="slot2_start_time[]" id="slot2_start_time_<?php echo $i;?>" style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">
									<option value="">From Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
								<select name="slot2_end_time[]" id="slot2_end_time_<?php echo $i;?>" style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">
									<option value="">To Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Slot 3</label>
							<div class="col-lg-4">
								<select name="slot3_start_time[]" id="slot3_start_time_<?php echo $i;?>" style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">
									<option value="">From Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
								<select name="slot3_end_time[]" id="slot3_end_time_<?php echo $i;?>" style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">
									<option value="">To Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
							</div>
							<label class="col-lg-2 control-label">Slot 4</label>
							<div class="col-lg-4">
								<select name="slot4_start_time[]" id="slot4_start_time_<?php echo $i;?>" style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">
									<option value="">From Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
								<select name="slot4_end_time[]" id="slot4_end_time_<?php echo $i;?>" style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">
									<option value="">To Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Slot 5</label>
							<div class="col-lg-4">
								<select name="slot5_start_time[]" id="slot5_start_time_<?php echo $i;?>" style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">
									<option value="">From Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
								<select name="slot5_end_time[]" id="slot5_end_time_<?php echo $i;?>" style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">
									<option value="">To Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
							</div>
							<label class="col-lg-2 control-label">Slot 6</label>
							<div class="col-lg-4">
								<select name="slot6_start_time[]" id="slot6_start_time_<?php echo $i;?>" style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">
									<option value="">From Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
								<select name="slot6_end_time[]" id="slot6_end_time_<?php echo $i;?>" style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">
									<option value="">To Time</option>
									<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Venue Image/Pdf<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="file" name="venue_image_file[]" id="venue_image_file_<?php echo $i;?>" class="form-control"> </div>
							<label class="col-lg-2 control-label">Event Image/Pdf</label>
							<div class="col-lg-4">
								<input type="file" name="event_image_file[]" id="event_image_file_<?php echo $i;?>" class="form-control"> </div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">No of Groups<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input required="" type="text" name="no_of_groups[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_groups_<?php echo $i;?>" class="form-control"> </div>
							<label class="col-lg-2 control-label" id="no_of_teams_level_<?php echo $i;?>">No of Teams</label>
							<div class="col-lg-4" id="no_of_teams_div_<?php echo $i;?>">
								<input type="text" name="no_of_teams[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_teams_<?php echo $i;?>" class="form-control"> </div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">No of Participants per team<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" required="" name="no_of_participants[]" onKeyPress="return isNumberKey(event);" maxlength="5" id="no_of_participants_<?php echo $i;?>" class="form-control"> </div>
							<label class="col-lg-2 control-label">No of Judges<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" required="" name="no_of_judges[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_judges_<?php echo $i;?>" class="form-control"> </div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Rules and regulation Image/Pdf <span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="file" required="" name="vloc_menu_file[]" id="vloc_menu_file_<?php echo $i;?>" class="form-control"> </div>
							<label class="col-lg-2 control-label">Institution Profile Pdf</label>
							<div class="col-lg-4">
								<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_<?php echo $i;?>" class="form-control"> </div>
						</div>
					</div>
						<div class="form-group">
						    <div class="col-sm-offset-5 col-sm-7">
						      <button type="submit" class="btn btn-warning">Submit Request</button>
						    </div>
					  	</div>
                    </form>
              
              </div>
            </div>
        </div>
        <div class="col-md-2">
        	<?php include_once('left_sidebar.php'); ?>
        	<?php include_once('right_sidebar.php'); ?></div>
      </div>
    </div>
  </section>




<?php include_once('footer.php');?> 

<script>

$(document).ready(function()

{ 

        $('#event_contents').summernote();

        $('.vloc_speciality_offered').tokenize2();

		$('.clsdatepicker').datepicker();

        $('.clsdatepicker2').datepicker();

        $("input[name^='vc_cert_reg_date']").attr('autocomplete', 'off');

        $("input[id^='capitals']").attr('autocomplete', 'off');

        $("input[id^='vc_cert_validity_date']").attr('autocomplete', 'off');

        $("input[id^='start_date']").attr('autocomplete', 'off');

        $("input[id^='end_date']").attr('autocomplete', 'off');

        $("input[id^='judge_cert_reg_date']").attr('autocomplete', 'off');

        $("input[id^='judge_cert_validity_date']").attr('autocomplete', 'off');

        $("input[id^='org_cert_reg_date']").attr('autocomplete', 'off');

        $("input[id^='org_cert_validity_date']").attr('autocomplete', 'off');

});

</script>

  </body>

</html>
