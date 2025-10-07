<?php

require_once('../classes/config.php');

require_once('../classes/vendor.php');

$admin_main_menu_id = '11';

$add_action_id = '21';

$edit_action_id = '22';



$obj = new Vendor();

$obj2 = new commonFunctions();

if(!$obj->isVendorLoggedIn())

{

	header("Location: login.php");

	exit(0);

}

else

{

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

}



$vendor_details = $obj->getVendorUserDetails($adm_vendor_id);



if(!$obj->chkIfAccessOfMenu($adm_vendor_id,$admin_main_menu_id))

{

        

	header("Location: invalid.php");

	exit(0);

}



if(!$obj->chkIfAccessOfMenuAction($adm_vendor_id,$add_action_id))

{

        

	header("Location: invalid.php");

	exit(0);

}



$va_id = $obj->getVendorVAID($adm_vendor_id);

$vaf_id = $obj->getVendorAccessFormIdFromVAIDAndVAFAMID($va_id,$admin_main_menu_id);


if($vaf_id > 0)

{

	$arr_vaff_record = $obj->getVendorAccessFormFieldsDetails($vaf_id);

	if(count($arr_vaff_record) == 0)

	{

		//echo '111111111111111111';

                //echo 'hii';die();

		header("Location: invalid.php");

		exit(0);

	}

}

else

{

	//echo '222222222222';

    //echo 'bbb';die();

	header("Location: invalid.php");

	exit(0);

}

$error = false;

$err_msg = "";

$msg = '';



if(isset($_GET['token']) && $_GET['token'] != '')

{

    

    $event_master_id = base64_decode($_GET['token']);

    $arr_record = $obj->GetEventDetails($event_master_id);

    $profile_data = $obj->getPageCatDropdownValue('151',$arr_record['wellbeing_id']);



    if(count($arr_record) == 0)

    {

            header("Location: manage_event.php");

            exit(0);

    }

    

    if(!empty($arr_record['fav_cat_id_1']))

    {

    $sub_cat_id1_explode = explode(',', $arr_record['fav_cat_id_1']);

    }

    else

    {

       $sub_cat_id1_explode = array(); 

    }

    

    if(!empty($arr_record['fav_cat_id_2']))

    {

    $sub_cat_id2_explode = explode(',', $arr_record['fav_cat_id_2']);

    }

    else

    {

       $sub_cat_id2_explode = array(); 

    }

    

    if(!empty($arr_record['fav_cat_id_3']))

    {

        $sub_cat_id3_explode = explode(',', $arr_record['fav_cat_id_3']);

    }

    else

    {

       $sub_cat_id3_explode = array(); 

    }

    

    if(!empty($arr_record['fav_cat_id_4']))

    {

        $sub_cat_id4_explode = explode(',', $arr_record['fav_cat_id_4']);

    }

    else

    {

       $sub_cat_id4_explode = array(); 

    }

    

    if(!empty($arr_record['fav_cat_id_5']))

    {

        $sub_cat_id5_explode = explode(',', $arr_record['fav_cat_id_5']);

    }

    else

    {

       $sub_cat_id5_explode = array(); 

    }


    $arr_event_tags = explode(',',$arr_record['event_tags']);

   //  $data_dropdown = $obj->GETDATADROPDOWNMYDAYTODAYOPTION($vendor_details['vendor_cat_id'],'151');

   //  // custom function write by ample 27-12-19
   // $final_dropdown=$obj->FilterDataDropdown($data_dropdown);

    //add by ample 09-10-20
    $tags=$obj->GETDATADROPDOWNMYDAYTODAYOPTION_ForEventTags($vendor_details['vendor_cat_id'],211);

    

    $cat_cnt = 0;

    $cat_total_cnt = 1;


    //add by ample 11-09-20
    $event_loc_data = $obj->getAllEventLocationbyEventMaster($event_master_id);

    // print_r( $event_loc_data);
}
else
{
    header("Location: manage_event.php");

            exit(0);

}




?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo SITE_NAME;?> - Admin</title>

	<?php require_once 'head.php'; ?>

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

    <div id="datashow"></div>

	<div class="row">

		<div class="col-sm-10">

			<div class="panel">

				<div class="panel-body">

					<div class="row mail-header">

						<div class="col-md-6">

							<h3><?php echo $obj->getAdminActionName($edit_action_id);?></h3>

						</div>

                        <div class="col-md-6 text-right">
                                        <?php 
                                           if($arr_record['status']==1)
                                           {
                                             ?>
                                             <button class="btn btn-danger" type="button" onclick="eventMasterStatus(<?=$event_master_id;?>,0)">Inactivate</button>
                                             <?php
                                           }
                                           else
                                           {
                                            ?>
                                             <button class="btn btn-success" type="button" onclick="eventMasterStatus(<?=$event_master_id;?>,1)">Activate</button>
                                             <?php
                                           }
                                           ?>
                        </div>

					</div>

					<hr>

					<center><div id="error_msg"></div></center>

					<form role="form" class="form-horizontal" id="add_event" name="add_event" enctype="multipart/form-data" method="post"> 

						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">

						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">

                                                <input type="hidden" name="hdn_master_event_id" id="hdn_master_event_id" value="<?php echo base64_decode($_GET['token']);?>">

						<div class="form-group">


              <?php


            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'reference_number'))

            { ?>

                                                        <label class="col-lg-2 control-label">Reference Number</label>

                                                        <div class="col-lg-2">

                                                            <input type="text" name="reference_number" readonly="" id="reference_number" value="<?php echo $arr_record['reference_number']; ?>" >

                                                            

                                                        </div>
            <?php

            }
            ?>

            <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'wellbeing_id'))

            { ?>


                                                        <label class="col-lg-2 control-label">System Category<span style="color:red">*</span></label>

                                                        <div class="col-lg-2">

                                                            <?php echo $obj->getFavCatNameById($arr_record['wellbeing_id']) ?>

                                                            

                                                        </div>

              <?php

            }
            ?>

            <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'institution_id'))

            { ?>

                                                        <label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>

							<div class="col-lg-2">

								<select name="event_status" id="event_status" class="form-control">

									<option value="1" <?php if($arr_record['event_status'] == '1'){?> selected <?php } ?>>Active</option> 

									<option value="0" <?php if($arr_record['event_status'] == '0'){?> selected <?php } ?>>Inactive</option> 

								</select>

							</div>

              <?php

            } ?>

                                                </div>

                                                <div class="form-group">

<!--							<label class="col-lg-2 control-label">Organizer<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<select name="organiser_id" id="organiser_id" class="form-control" required>

									<?php //echo $obj->getVendorOption($arr_record['organiser_id'],$type='1',$multiple='0');?>

								</select>

							</div>-->

              <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'institution_id'))

            { ?>

                                                        <label class="col-lg-2 control-label">Institution<span style="color:red">*</span></label>

							<div class="col-lg-10">

<!--								<select name="institution_id" id="institution_id" class="form-control" required>

									<?php //echo $obj->getVendorOption($arr_record['institution_id'],$type='1',$multiple='0');?>

								</select>-->

                                                            

                                                            <input type="text" name="institution_id" id="institution_id" value="<?php echo $arr_record['institution_id']; ?>" class="form-control" required>

                                                            

							</div>

              
              <?php

            } ?>

						</div>

                                                

                                                <div class="form-group">


            <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'sponsor_id'))

            { ?>



                                                    <label class="col-lg-2 control-label">Sponsor Name</label>

							<div class="col-lg-4">

<!--                                                            <select name="sponsor_id" id="sponsor_id" class="form-control">

									<?php //echo $obj->getVendorOption($arr_record['sponsor_id'],$type='1',$multiple='0');?>

                                                            </select>-->

                                                            <input type="text" name="sponsor_id" id="sponsor_id" value="<?php echo $arr_record['sponsor_id']; ?>" class="form-control" required>

							</div>

              <?php

            } ?>

            <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'event_name'))

            { ?>

                                                    <label class="col-lg-2 control-label">Event Name<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<input type="text" name="event_name" id="event_name" value="<?php echo $arr_record['event_name'];?>" placeholder="Event Name" class="form-control" required>

							</div>

						</div>

            <?php

            } ?>

                                                <div class="form-group">

                                                        <label class="col-lg-2 control-label"><?=($tags['tag_heading'])? $tags['tag_heading'] : 'Event Tags';?></label>

                                                        <div class="col-lg-10">

                                                                <select name="event_tags[]" id="event_tags" multiple="multiple" class="form-control vloc_speciality_offered" >

                                                                        <!--  <?php echo $final_dropdown; ?> -->

                                                                        <?php 

                                                                         if(!empty($tags['tag_data']))
                                                                         {
                                                                            foreach ($tags['tag_data'] as $key => $value) {
                                                                                $sel="";
                                                                                if (in_array($value, $arr_event_tags))
                                                                                  {
                                                                                    $sel="selected";
                                                                                  }
                                                                                ?>
                                                                                <option value="<?=$value;?>" <?=$sel?> ><?=$value;?></option>
                                                                                <?php
                                                                            }
                                                                         }

                                                                        ?>

                                                                   ?>

                                                                </select>

                                                        </div>

						</div>  

            <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'event_contents'))

            { ?>

                                                <div class="form-group">



                                                  <label class="col-lg-2 control-label">Events Contents<span style="color:red">*</span></label>

							<div class="col-lg-8">

								<div class="summernote-theme-1">

									<div class="event_contents" name="event_contents" id="event_contents"><?php echo $arr_record['event_contents'];?></div>

								</div>

							</div>

						</div>

              <?php

            } ?>

                                                

                                                <div class="form-group">

                                                  <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'prof_cat_id_1'))

            { ?>

                                                        <label class="col-lg-2 control-label" id="prof_header1"><?php echo $profile_data['header1']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_1" class="form-control" id="profile_cat_1"  onchange="getMainCategoryOptionAddMoreSingle('1')">

                                                            <!--<option value="">All Type</option>-->	

                                                            <?php //echo $obj->getFavCategoryTypeOptions($arr_record['prof_cat_id_1']);

                                                                     echo  $obj->GetPfileCatEdit($arr_record['wellbeing_id'],'151','prof_cat_id_1',$arr_record['prof_cat_id_1']);

                                                            ?>

                                                            </select>

                                                        </div>

                                                        <?php

            } ?>  

              <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'fav_cat_id_1'))

            { ?>

							<label class="col-lg-2 control-label">Fav Category</label>

                                                        <div class="col-lg-4" id="">

                                                            

                                                            <select name="fav_cat_1[]" class="form-control" id="fav_cat_1" >

                                                                <option value="">Select Sub Cat</option>

                                                                <?php echo $obj->getAllCategoryOptionEventEdit($arr_record['prof_cat_id_1'],$arr_record['fav_cat_id_1']); ?>

                                                            </select>

                                                            

                                                        </div>

                                  <?php

            } ?>  


						</div>

                                                

                                                <div class="form-group">

                                                  <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'prof_cat_id_2'))

            { ?>

                                                        <label class="col-lg-2 control-label" id="prof_header2"><?php echo $profile_data['header2']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_2" class="form-control" id="profile_cat_2"  onchange="getMainCategoryOptionAddMore('2')">

                                                            <!--<option value="">All Type</option>-->	

                                                            <?php // echo $obj->getFavCategoryTypeOptions($arr_record['prof_cat_id_2']);

                                                            

                                                            echo  $obj->GetPfileCatEdit($arr_record['wellbeing_id'],'151','prof_cat_id_2',$arr_record['prof_cat_id_2']);

                                                            ?>

                                                            </select>

                                                        </div>

                      <?php

            } ?>  


            <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'fav_cat_id_2'))

            { ?>

							<label class="col-lg-2 control-label">Fav Category</label>

                                                        <div class="col-lg-4" id="fav_cat_2">

                                                             <?php if(empty($sub_cat_id2_explode)) { ?>

                                                            <select name="fav_cat_2" class="form-control" id="fav_cat_2" >

                                                                <option value="">Select Sub Cat</option>

                                                                

                                                            </select>

                                                            <?php } else {

                                                                echo $obj->getAllCategoryChkeckboxEvent('2',$arr_record['prof_cat_id_2'],$sub_cat_id2_explode,'0','300','200');

                                                            } ?>

                                                        </div>

                        <?php

            } ?>  

						</div>

                                                

                                                <div class="form-group">




            <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'prof_cat_id_3'))

            { ?>

                                                        <label class="col-lg-2 control-label" id="prof_header3"><?php echo $profile_data['header3']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_3" class="form-control" id="profile_cat_3"  onchange="getMainCategoryOptionAddMore('3')">

                                                            <option value="">All Type</option>	

                                                            <?php echo $obj->getFavCategoryTypeOptions($arr_record['prof_cat_id_3']);?>

                                                            </select>

                                                        </div>

            <?php

            } ?>  

            <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'fav_cat_id_3'))

            { ?>

							<label class="col-lg-2 control-label">Fav Category</label>

                                                        <div class="col-lg-4" id="fav_cat_3">

                                                            

                                                            <?php if(empty($sub_cat_id3_explode)) { ?>

                                                            

                                                            <select name="fav_cat_3" class="form-control" id="fav_cat_3" >

                                                                <option value="">Select Sub Cat</option>

                                                            </select>

                                                            <?php } else {

                                                                echo $obj->getAllCategoryChkeckboxEvent('3',$arr_record['prof_cat_id_3'],$sub_cat_id3_explode,'0','300','200');

                                                            } ?>

                                                        </div>
                <?php

            } ?>  

						</div>

                                                

                                                <div class="form-group">


                  <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'prof_cat_id_4'))

            { ?>

                                                        <label class="col-lg-2 control-label" id="prof_header4"><?php echo $profile_data['header4']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_4" class="form-control" id="profile_cat_4"  onchange="getMainCategoryOptionAddMore('4')">

                                                            <option value="">All Type</option>	

                                                            <?php echo $obj->getFavCategoryTypeOptions($arr_record['prof_cat_id_4']);?>

                                                            </select>

                                                        </div>
            <?php

            } ?>  

            <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'fav_cat_id_4'))

            { ?>

							<label class="col-lg-2 control-label">Fav Category</label>

                                                        <div class="col-lg-4" id="fav_cat_4">

                                                             <?php if(empty($sub_cat_id4_explode)) { ?>

                                                            <select name="fav_cat_4" class="form-control" id="fav_cat_4" >

                                                                <option value="">Select Sub Cat</option>

                                                                

                                                            </select>

                                                            <?php } else {

                                                                echo $obj->getAllCategoryChkeckboxEvent('4',$arr_record['prof_cat_id_4'],$sub_cat_id4_explode,'0','300','200');

                                                            } ?>

                                                        </div>

                        <?php

            } ?>  

						</div>

              <div class="form-group">

                  <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'prof_cat_id_5'))

            { ?>
                                                

                                              

                                                        <label class="col-lg-2 control-label" id="prof_header5"><?php echo $profile_data['header5']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_5" class="form-control" id="profile_cat_5"  onchange="getMainCategoryOptionAddMore('5')">

                                                            <option value="">All Type</option>	

                                                            <?php echo $obj->getFavCategoryTypeOptions($arr_record['prof_cat_id_5']);?>

                                                            </select>

                                                        </div>

                        <?php

            } ?>              



            <?php

            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'fav_cat_id_5'))

            { ?>

							<label class="col-lg-2 control-label">Fav Category</label>

                                                        <div class="col-lg-4" id="fav_cat_5">

                                                           <?php if(empty($sub_cat_id5_explode)) { ?>

                                                            <select name="fav_cat_5" class="form-control" id="fav_cat_5" >

                                                                <option value="">Select Sub Cat</option>

                                                                

                                                            </select>

                                                            <?php } else { 

                                                                

                                                                echo $obj->getAllCategoryChkeckboxEvent('5',$arr_record['prof_cat_id_5'],$sub_cat_id5_explode,'0','300','200'); 

                                                            } ?>

                                                        </div>
                    <?php

            } ?>

						</div>

						

						<hr>

                    <a href="add_event_info.php?token=<?=$_GET['token']?>" target="_blank" class="pull-right"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">ADD Event-Location details</button></a>
                    <br>
                    <table class="table table-bordered" style="margin-top: 15px;">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Event Format</th>
                            <th>Venue</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(!empty($event_loc_data))
                            {
                                foreach ($event_loc_data as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?=$key+1;?></td>
                                        <td><?=$obj->getFavCategoryNameVivek($value['event_format']);?></td>
                                        <td>
                                            <?=$value['venue_details'];?>
                                            <br>
                                            <b>Area: </b> <?=$obj->getAreaName($value['area_id']);?> &nbsp;
                                            <b>City: </b> <?=$obj->GetCityName($value['city_id']);?> &nbsp;
                                            <br>
                                            <b>State: </b> <?=$obj->GetStateName($value['state_id']);?> &nbsp;
                                            <b>Country: </b> <?=$obj->GetCountryName($value['country_id']);?> &nbsp;
                                        </td>
                                         <td>
                                            <b>Start: </b><?=date("d-m-Y", strtotime($value['start_date']));?>
                                            <?=$value['start_time'];?> <br>
                                            <b>End: </b> <?=date("d-m-Y", strtotime($value['end_date']));?>
                                            <?=$value['end_time'];?>
                                        </td>
                                        <td>
                                            <?=($value['event_status']==1)? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';?>
                                        </td>
                                        <td>
                                            <?php 
                                                $today=date('Y-m-d');
                                                if($today<=$value['end_date'])
                                                {
                                                    ?>
                                                    <a href="edit_event_info.php?token=<?=base64_encode($value['event_master_id']);?>&event=<?=base64_encode($value['event_id']);?>" target="_blank"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">Edit</button></a>
                                                    <?php
                                                }
                                                else
                                                {
                                                     ?>
                                                    <a href="edit_event_info.php?token=<?=base64_encode($value['event_master_id']);?>&event=<?=base64_encode($value['event_id']);?>" target="_blank"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">View</button></a>
                                                    <?php
                                                }
                                            ?>

                                             <?php 
                                           if($value['event_status']==1)
                                           {
                                             ?>
                                             <button class="btn btn-danger rounded" type="button" onclick="eventLocationStatus(<?=$value['event_id'];?>,0)">Inactivate</button>
                                             <?php
                                           }
                                           else
                                           {
                                            ?>
                                             <button class="btn btn-success rounded" type="button" onclick="eventLocationStatus(<?=$value['event_id'];?>,1)">Activate</button>
                                             <?php
                                           }
                                           ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <tr><td colspan="6" class="text-center">No Event location found</td></tr>
                                <?php
                            }
                            ?>
                        </tbody>
                      </table>
                      <hr>
						<div class="form-group">

							<div class="col-lg-offset-3 col-lg-10">

								<div class="pull-left">

									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>

									<a href="manage_event.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>



                   <img border="0" class="image_load" src="<?php echo SITE_URL.'/images/loading.gif'?>" style=" width: 6%; display: none; float: right; margin-right:75%;">

								</div>

							</div>

						</div>

					</form>

				</div>

			</div>

		</div>

        <div class="col-sm-2"><?php include_once('wa_right_sidebar.php'); ?></div>

	</div>

</div>

<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>

<script type="text/javascript" src="js/jquery.validate.min.js"></script>

<script src="admin-js/edit-event-validator.js" type="text/javascript"></script>

<script src="js/tokenize2.js"></script>

<script>

	$(document).ready(function()

	{

		$('.vloc_speciality_offered').tokenize2();

		$('.clsdatepicker').datepicker();

		$('.clsdatepicker2').datepicker({endDate: new Date});

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

	

	function getStateOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		

		if(country_id == null)

		{

			country_id = '-1';

		}

		

		if(state_id == null)

		{

			state_id = '-1';

		}

		

		

		var dataString ='country_id='+country_id+'&state_id='+state_id+'&action=getstateoption';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

				$("#state_id_"+id_val).html(result);

                                $('#city_id_'+id_val).val('');

				getCityOptionAddMore(id_val);

			}

		});

	}

	

	function getCityOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		var city_id = $('#city_id_'+id_val).val();

		

		if(country_id == null)

		{

			country_id = '-1';

		}

				

		if(state_id == null)

		{

			state_id = '-1';

		}

		

		if(city_id == null)

		{

			city_id = '-1';

		}

		

		var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&action=getcityoption';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

				//$("#city_id_"+id_val).html(result);

                                $("#capitals_"+id_val).html(result);

				getAreaOptionAddMore(id_val);

			}

		});

	}

	

	function getAreaOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		var city_id = $('#city_id_'+id_val).val();

		var area_id = $('#area_id_'+id_val).val();

		

		if(country_id == null)

		{

			country_id = '-1';

		}

				

		if(state_id == null)

		{

			state_id = '-1';

		}

		

		if(city_id == null)

		{

			state_id = '-1';

		}

		

		if(area_id == null)

		{

			area_id = '-1';

		}

		

		var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&action=getareaoption';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

				$("#area_id_"+id_val).html(result);

			}

		});

	}

        

</script>

<script>

    $(document).ready(function()

    { 

            $('#event_contents').summernote();

    });

    function getMainCategoryOptionAddMore(id)

    {

           // alert(id);

            var parent_cat_id = $("#profile_cat_"+id).val();

            //var sub_cat = $("#fav_cat_id_"+idval).val();

            //alert(parent_cat_id);

             var dataString = 'action=FavcategoryByprofCatEvent&parent_cat_id='+parent_cat_id+'&id_no='+id;

            

           $.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

                         //alert(result);  

			$("#fav_cat_"+id).html(result);

			

		}

	});

    }

    

    function getlocation(id_val)

       {

            

           var city = $("#city_id_"+id_val).val();

            //alert(city);

            var dataString ='city='+city+'&action=getlocation';

            $.ajax({

                   type: "POST",

                    url: 'ajax/remote.php', 

                   data: dataString,

                   cache: false,

                   success: function(result)

                        {

                            //alert(result);

                         var JSONObject = JSON.parse(result);

                         //var rslt=JSONObject[0]['status'];   

                        $('#area_id_'+id_val).html(JSONObject[0]['place_option']);

                       }

              }); 

       }

       

       function isNumberKey(evt){  <!--Function to accept only numeric values-->

    //var e = evt || window.event;

	var charCode = (evt.which) ? evt.which : evt.keyCode

    if (charCode != 46 && charCode > 31 

	&& (charCode < 48 || charCode > 57))

        return false;

        return true;

	}

    

    function changedate(idval)

    {

     

    }

    

    function GetAllProfileCategory()

    {

        var healcareandwellbeing = $("#healcareandwellbeing").val();

        var dataString ='healcareandwellbeing='+healcareandwellbeing+'&action=getallprofilecategory';

            $.ajax({

                   type: "POST",

                    url: 'ajax/remote.php', 

                   data: dataString,

                   cache: false,

                   success: function(result)

                        {

                         //alert(result);

                         var JSONObject = JSON.parse(result);

                         var rslt=JSONObject[0]['status'];

                        $('#profile_cat_1').html(JSONObject[0]['prof_cat1']);

                        $('#profile_cat_2').html(JSONObject[0]['prof_cat2']);

                        $('#profile_cat_3').html(JSONObject[0]['prof_cat3']);

                        $('#profile_cat_4').html(JSONObject[0]['prof_cat4']);

                        $('#profile_cat_5').html(JSONObject[0]['prof_cat5']);

                        

                        

                        $('#prof_header1').html(JSONObject[0]['header1']);

                        $('#prof_header2').html(JSONObject[0]['header2']);

                        $('#prof_header3').html(JSONObject[0]['header3']);

                        $('#prof_header4').html(JSONObject[0]['header4']);

                        $('#prof_header5').html(JSONObject[0]['header5']);

                      

                       }

              }); 

    }

    

    function getMainCategoryOptionAddMoreSingle(id)

    {

           // alert(id);

            var parent_cat_id = $("#profile_cat_"+id).val();

            //var sub_cat = $("#fav_cat_id_"+idval).val();

            //alert(parent_cat_id);

             var dataString = 'action=FavcategoryByprofCatEventSingle&parent_cat_id='+parent_cat_id+'&id_no='+id;

            

           $.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

                         //alert(result);  

			$("#fav_cat_"+id).html(result);

			

		}

	});

    }

    

    function removeFileOfRow(idval)

	{

		$("#divid_"+idval).remove();

		$("#hdn"+idval).val('');

		

	}

        

   function CheckTeamType(idval)

    {

      

      var event_format = $("#event_format_"+idval).val();

      if(event_format == '504')

      {

        $('#no_of_teams_level_'+idval).hide();  

        $('#no_of_teams_div_'+idval).hide();  

      }

      else

      {

         $('#no_of_teams_level_'+idval).show();  

         $('#no_of_teams_div_'+idval).show();   

      }

      

    } 


    
    function eventLocationStatus(loc_id,status)
    {

        var action='eventLocationStatus';
        $.ajax({
           url: 'ajax/remote.php',
           type: 'POST',
           data: {loc_id: loc_id, status: status, action:action},
           error: function() {
              alert('Something is wrong');
           },
           success: function(res) {
                alert(res);
                location.reload();
           }
        });
    }

    function eventMasterStatus(id,status)
    {

        var action='eventMasterStatus';
        $.ajax({
           url: 'ajax/remote.php',
           type: 'POST',
           data: {id: id, status: status, action:action},
           error: function() {
              alert('Something is wrong');
           },
           success: function(res) {
                alert(res);
                location.reload();
           }
        });
    }

</script>

</body>

</html>