<?php

require_once('../classes/config.php');

require_once('../classes/vendor.php');

$admin_main_menu_id = '11';

$add_action_id = '21';



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

if(isset($_GET['token']) && $_GET['token'] != '')

{

    

    $event_master_id = base64_decode($_GET['token']);

    $arr_record = $obj->GetEventDetails($event_master_id);


    if(count($arr_record) == 0)

    {

            header("Location: manage_event.php");

            exit(0);

    }
}


//$data_dropdown = $obj->GETDATADROPDOWNMYDAYTODAYOPTION($vendor_details['vendor_cat_id'],'151');
// custom function write by ample 27-12-19
//$final_dropdown=$obj->FilterDataDropdown($data_dropdown);

//add by ample 09-10-20
    $tags=$obj->GETDATADROPDOWNMYDAYTODAYOPTION_ForEventTags($vendor_details['vendor_cat_id'],211);

$error = false;

$err_msg = "";

$msg = '';



$cat_cnt = 0;

$cat_total_cnt = 1;



$vendor_parent_cat_id = '11';

$vendor_cat_id = '';

$vendor_name = '';

$vendor_username = '';

$arr_vloc_parent_cat_id = array();

$arr_vloc_cat_id = array('');

$arr_contact_person_title = array('');

$arr_contact_person = array('');

$arr_contact_email = array('');

$arr_contact_number = array('');

$arr_contact_designation = array('');

$arr_contact_remark = array('');

$arr_event_tags = array('');



$arr_cert_cnt = array(0);

$arr_cert_total_cnt = array(1);



$arr_vc_cert_type_id = array();

$arr_vc_cert_name = array();

$arr_vc_cert_no = array();

$arr_vc_cert_issued_by = array();

$arr_vc_cert_reg_date = array();

$arr_vc_cert_validity_date = array();



for($i=0;$i<count($arr_cert_total_cnt);$i++)

{

	$arr_vc_cert_type_id[$i] = array('');

	$arr_vc_cert_name[$i] = array('');

	$arr_vc_cert_no[$i] = array('');

	$arr_vc_cert_issued_by[$i] = array('');

	$arr_vc_cert_reg_date[$i] = array('');

	$arr_vc_cert_validity_date[$i] = array('');

}



$arr_country_id = array('-1');

$arr_state_id = array('-1');

$arr_city_id = array('-1');

$arr_area_id = array('-1');




$default_cucat_parent_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'cucat_parent_cat_id');

$default_cucat_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'cucat_cat_id');	









$add_more_row_cat_str = '<div class="form-group" id="row_cat_\'+cat_cnt+\'"><label class="col-lg-2 control-label"></label>';

if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'cucat_parent_cat_id'))

{

	$add_more_row_cat_str .= '<div class="col-lg-3"><select name="cucat_parent_cat_id[]" id="cucat_parent_cat_id_\'+cat_cnt+\'" onchange="getMainCategoryOptionAddMore(\'+cat_cnt+\');" class="form-control" required>'.$obj->getMainProfileOption('','1','0',$default_cucat_parent_cat_id).'</select></div>';	

}

else

{

	$add_more_row_cat_str .= '<input type="hidden" name="cucat_parent_cat_id[]" id="cucat_parent_cat_id_\'+cat_cnt+\'" value="'.$default_cucat_parent_cat_id.'">';		

}



if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'cucat_cat_id'))

{ 

	$add_more_row_cat_str .= '<div class="col-lg-3"><select name="cucat_cat_id[]" id="cucat_cat_id_\'+cat_cnt+\'" class="form-control" required>'.$obj->getMainCategoryOption('','','1','0',$default_cucat_cat_id).'</select></div>';	

}

else

{ 

	$add_more_row_cat_str .= '<input type="hidden" name="cucat_cat_id[]" id="cucat_cat_id_\'+cat_cnt+\'" value="'.$default_cucat_cat_id.'">';			

}



if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'cucat_show'))

{

	$add_more_row_cat_str .= '<div class="col-lg-2"><select name="cucat_show[]" id="cucat_show_\'+cat_cnt+\'" class="form-control" required>'.$obj->getShowHideOption('').'</select></div>';

}

else

{

	$add_more_row_cat_str .= '<input type="hidden" name="cucat_show[]" id="cucat_show_\'+cat_cnt+\'" value="">';			

}



$add_more_row_cat_str .= '<div class="col-lg-2"><a href="javascript:void(0);" onclick="removeRowCategory(\'+cat_cnt+\');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a></div></div>';











$add_more_row_cw_str = '<div class="form-group" id="row_cw_\'+cw_cnt+\'"><div class="col-lg-3"><input type="hidden" name="cw_qt_parent_cat_id[]" id="cw_qt_parent_cat_id_\'+cw_cnt+\'" value="'.$cw_qt_parent_cat_id.'"><select name="cw_qt_cat_id[]" id="cw_qt_cat_id_\'+cw_cnt+\'" class="form-control">'.$obj->getMainCategoryOption($cw_qt_parent_cat_id,'').'</select></div><div class="col-lg-3"><input type="hidden" name="cw_qu_parent_cat_id[]" id="cw_qu_parent_cat_id_\'+cw_cnt+\'" value="'.$cw_qu_parent_cat_id.'"><select name="cw_qu_cat_id[]" id="cw_qu_cat_id_\'+cw_cnt+\'" class="form-control">'.$obj->getMainCategoryOption($cw_qu_parent_cat_id,'').'</select></div><div class="col-lg-2"><input type="text" name="cw_quantity[]" id="cw_quantity_\'+cw_cnt+\'" class="form-control" value=""></div><div class="col-lg-2"><select name="cw_show[]" id="cw_show_\'+cw_cnt+\'" class="form-control">'.$obj->getShowHideOption('').'</select></div><div class="col-lg-2"><a href="javascript:void(0);" onclick="removeRowWeight(\'+cw_cnt+\');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a></div></div>';





$data = $obj->getPageCatDropdownValue('151',$vendor_details['vendor_cat_id']);



if(!empty($data))

{

        $profile_cat1 = '';

        $profile_cat2 ='';

        $profile_cat3 ='';

        $profile_cat4 ='';

        $profile_cat5 ='';

        

        $fav_cat_id1_val = explode(',', $data['prof_cat1']);

        $fav_cat_id2_val = explode(',', $data['prof_cat2']);

        $fav_cat_id3_val = explode(',', $data['prof_cat3']);

        $fav_cat_id4_val = explode(',', $data['prof_cat4']);

        $fav_cat_id5_val = explode(',', $data['prof_cat5']);

        

        $fav_cat_id1 = implode('\',\'', $fav_cat_id1_val);

        $fav_cat_id2 = implode('\',\'', $fav_cat_id2_val);

        $fav_cat_id3 = implode('\',\'', $fav_cat_id3_val);

        $fav_cat_id4 = implode('\',\'', $fav_cat_id4_val);

        $fav_cat_id5 = implode('\',\'', $fav_cat_id5_val);

 

        

        if($data['prof_cat1']!=''){

                $profile_cat1 = $obj->getMoreFavCategoryTypeOptions($fav_cat_id1,'');

        }

        if($data['prof_cat2']!=''){

               $profile_cat2 =$obj->getMoreFavCategoryTypeOptions($fav_cat_id2,'');

        }

        if($data['prof_cat3']!=''){

              $profile_cat3 =$obj->getMoreFavCategoryTypeOptions($fav_cat_id3,'');

        }

        if($data['prof_cat4']!=''){

             $profile_cat4 =$obj->getMoreFavCategoryTypeOptions($fav_cat_id4,'');

        }

        if($data['prof_cat5']!=''){

            $profile_cat5 =$obj->getMoreFavCategoryTypeOptions($fav_cat_id5,'');

        }

}



?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo SITE_NAME;?> - Business Associates</title>

	<?php require_once 'head.php'; ?>

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-sm-10">

			<div class="panel">

				<div class="panel-body">

					<div class="row mail-header">

						<div class="col-md-6">

							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>

						</div>

					</div>

					<hr>

					<center><div id="error_msg"></div></center>

					<form role="form" class="form-horizontal" id="add_event_info" name="add_event_info" method="post" > 

						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">

						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">

                        <input type="hidden" name="hdn_master_event_id" id="hdn_master_event_id" value="<?php echo base64_decode($_GET['token']);?>">
                        
					<?php 

					for($i=0;$i<$cat_total_cnt;$i++)

					{ ?>

						<div id="row_loc_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

							<input type="hidden" name="cert_cnt_<?php echo $i;?>" id="cert_cnt_<?php echo $i;?>" value="<?php echo $arr_cert_cnt[$i];?>">

							<input type="hidden" name="cert_total_cnt_<?php echo $i;?>" id="cert_total_cnt_<?php echo $i;?>" value="<?php echo $arr_cert_total_cnt[$i];?>">

							<input type="hidden" name="cert_loop_cnt[]" id="cert_loop_cnt_<?php echo $i;?>" value="<?php echo $i;?>">

							<input type="hidden" name="hdnvloc_doc_file[]" id="hdnvloc_doc_file_<?php echo $i;?>" value="">

							<input type="hidden" name="hdnvloc_menu_file[]" id="hdnvloc_menu_file_<?php echo $i;?>" value="">

							<input type="hidden" name="vloc_id[]" id="vloc_id_<?php echo $i;?>" value="0">

							<div class="form-group left-label">

								<label class="col-lg-3 control-label"><strong>Event Details:</strong></label>
								<input type="hidden" name="event_master_id" value="<?=base64_decode($_GET['token'])?>" />
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

                                                            <?php

                                                                if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'location_category'))

                                                                { ?>

								<label class="col-lg-2 control-label">Location Category</label>

								<div class="col-lg-4">

									<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_<?php echo $i;?>" class="form-control"  onchange="getMainCategoryOptionAddMoreCommonLOC('vloc',<?php echo $i;?>,'<?php echo $default_vloc_cat_id;?>');" >

                                                                            

                                                                            <?php echo $obj->getMainProfileOption($arr_vloc_parent_cat_id[$i],'1','0',$default_vloc_parent_cat_id);?>

									</select>

								</div>

                                                                <?php

                                                                }

                                                                else

                                                                { ?>

                                                                        <input type="hidden" name="vloc_parent_cat_id" id="vloc_parent_cat_id" value="<?php echo $vloc_parent_cat_id;?>">	

                                                                <?php

                                                                } ?>

								<div class="col-lg-2"></div>

                                                                <?php

                                                                if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'location_sub_category'))

                                                                { ?>

								<div class="col-lg-4">

									<select name="vloc_cat_id[]" id="vloc_cat_id_<?php echo $i;?>" class="form-control" >

										<?php echo $obj->getMainCategoryOption($arr_vloc_parent_cat_id[$i],$arr_vloc_cat_id[$i]); ?>

									</select>

								</div>

                                                                <?php

                                                                }

                                                                else

                                                                { ?>

                                                                        <input type="hidden" name="vloc_cat_id" id="vloc_cat_id" value="<?php echo $vloc_cat_id;?>">	

                                                                <?php

                                                                } ?>

							</div>

                                                        

                                                        

                                                        <div class="form-group" >

                                                             <?php

                                                                if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'country_id'))

                                                                { ?>

								<label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<select name="country_id[]" id="country_id_<?php echo $i;?>" onchange="getStateOptionAddMore(<?php echo $i;?>)" class="form-control" required>

										<?php echo $obj->getCountryOption($arr_country_id[$i]); ?>

									</select>

								</div>

                                                                <?php

                                                                }

                                                                else

                                                                { ?>

                                                                        <input type="hidden" name="country_id" id="country_id" value="<?php echo $country_id;?>">	

                                                                <?php

                                                                } ?>

                                                                <?php

                                                                if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'state_id'))

                                                                { ?>

								<label class="col-lg-2 control-label">State<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<select name="state_id[]" id="state_id_<?php echo $i;?>" onchange="getCityOptionAddMore(<?php echo $i;?>)" class="form-control" required>

										<?php echo $obj->getStateOption($arr_country_id[$i],$arr_state_id[$i]); ?>

									</select>

								</div>

                                                                <?php

                                                                }

                                                                else

                                                                { ?>

                                                                        <input type="hidden" name="state_id" id="state_id" value="<?php echo $state_id;?>">	

                                                                <?php

                                                                } ?>

                                                                

							</div>

							<div class="form-group">

                                                            <?php

                                                                if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'city_id'))

                                                                { ?>

								<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>

								<div class="col-lg-4">

                                                                    <input type="text" required="" name="city_id[]" id="city_id_<?php echo $i;?>" placeholder="Select your city" list="capitals_<?php echo $i;?>" class="form-control" onchange="getlocation(<?php echo $i;?>)" />

                                                               

                                                                     <datalist id="capitals_<?php echo $i;?>">

                                                                        <?php echo $obj->getCityOptions(0); ?>

                                                                    </datalist>



								</div>

                                                                <?php

                                                                }

                                                                else

                                                                { ?>

                                                                        <input type="hidden" name="city_id" id="city_id" value="<?php echo $city_id;?>">	

                                                                <?php

                                                                } ?>

                                                                 <?php

                                                                if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'area_id'))

                                                                { ?>

								<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<select name="area_id[]" id="area_id_<?php echo $i;?>" class="form-control" required>

										<?php echo $obj->getAreaOption($arr_country_id[$i],$arr_state_id[$i],$arr_city_id[$i],$arr_area_id[$i]); ?>

									</select>

								</div>

                                                                <?php

                                                                }

                                                                else

                                                                { ?>

                                                                        <input type="hidden" name="area_id" id="area_id" value="<?php echo $area_id;?>">	

                                                                <?php

                                                                } ?>

							</div>

							

							<div class="form-group">

                                                            <?php

                                                                if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'venue_details'))

                                                                { ?>

								<label class="col-lg-2 control-label">Venue<span style="color:red">*</span></label>

								<div class="col-lg-10">

                                                                    <textarea name="venue[]" id="venue_<?php echo $i;?>" class="form-control" required=""></textarea>

								</div>

                                                                <?php

                                                                }

                                                                else

                                                                { ?>

                                                                        <input type="hidden" name="venue_details" id="venue_details" value="<?php echo $venue_details;?>">	

                                                                <?php

                                                                } ?>

							</div>



                                                            <div class="form-group small-title">

                                                                        <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'start_date'))

                                                                    { ?>

									<label class="col-lg-2 control-label">Start Date <span style="color:red">*</span></label>

									<div class="col-lg-4">

                                                                            <input required="" type="text" name="start_date[]" id="start_date_<?php echo $i;?>" style="width:200px; float:left;" value="<?php echo $arr_start_date_time_[$i];?>" placeholder="Start Date" class="form-control clsdatepicker">

                                                                                

                                                                            <select name="start_time[]" id="start_time_<?php echo $i;?>" required="" class="form-control" style="width:120px;">

                                                                                   <option value="">Select Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                                </select>

                                                                        </div>

                                                                    <?php

                                                                }

                                                                else

                                                                { ?>

                                                                        <input type="hidden" name="start_date" id="start_date" value="<?php echo $start_date;?>">

                                                                        <input type="hidden" name="start_time" id="start_time" value="<?php echo $start_time;?>">	

                                                                <?php

                                                                } ?>

									 <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'end_date'))

                                                                    { ?>

									<label class="col-lg-2 control-label">End Date <span style="color:red">*</span></label>

									<div class="col-lg-4">

                                                                            <input type="text" name="end_date[]" required="" id="end_date_<?php echo $i;?>" style="width:200px; float:left;" value="<?php echo $arr_end_date_time_[$i];?>" placeholder="End Date" class="form-control clsdatepicker">

                                                                                

                                                                            <select name="end_time[]" id="end_time_<?php echo $i;?>"  required="" class="form-control" style="width:120px;">

                                                                                   <option value="">Select Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                                </select>

                                                                        </div>

                                                                        <?php

                                                                }

                                                                else

                                                                { ?>

                                                                        <input type="hidden" name="end_date" id="end_date" value="<?php echo $end_date;?>">

                                                                        <input type="hidden" name="end_time" id="end_date" value="<?php echo $end_time;?>">

                                                                <?php

                                                                } ?>

								</div>



                                                            <div class="form-group">

                                                                 <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'time_zone_id'))

                                                                    { ?>

                                                                    <label class="col-lg-2 control-label">Time Zone<span style="color:red">*</span></label>

                                                                    <div class="col-lg-10">

                                                                        <select name="time_zone[]" required="" id="time_zone_<?php echo $i;?>" class="form-control">

                                                                            <option value="">Select Time Zone</option>

                                                                            <?php echo $obj->getFavCategoryRamakant('59',''); ?>

                                                                        </select>

                                                                    </div>

                                                                    <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="time_zone" id="time_zone" value="<?php echo $end_date;?>">

                                                                            

                                                                    <?php

                                                                    } ?>



                                                                    

                                                            </div>


                               <div class="form-group">

                                <label class="col-lg-2 control-label">Online Registration Link</label>

                                <div class="col-lg-4">

                                <input  value="" type="text" name="online_registration_link[]" class="form-control">

                                </div>
                                                               

                                <label class="col-lg-2 control-label">Online Registration ID</label>

                                <div class="col-lg-4">

                                <input value="" type="text" name="online_registration_id[]"  class="form-control">

                                </div>
                                       

                            </div>

                                                        <div class="form-group left-label">

                                                                    <label class="col-lg-3 control-label"><strong>Sessions:</strong></label>

                                                            </div>

                                                            <div class="form-group">

									<label class="col-lg-2 control-label">Slot 1<span style="color:red">*</span></label>

									<div class="col-lg-4">

                                                                            <select name="slot1_start_time[]" id="slot1_start_time_<?php echo $i;?>" required=""  style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">

                                                                                   <option value="">From Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                             </select>

                                                                            <select name="slot1_end_time[]" id="slot1_end_time_<?php echo $i;?>" required=""  style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">

                                                                                   <option value="">To Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                             </select>

                                                                        </div>

									

									<label class="col-lg-2 control-label">Slot 2</label>

									<div class="col-lg-4">

                                                                            <select name="slot2_start_time[]" id="slot2_start_time_<?php echo $i;?>"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">

                                                                                   <option value="">From Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                             </select>

                                                                            <select name="slot2_end_time[]" id="slot2_end_time_<?php echo $i;?>"  style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">

                                                                                   <option value="">To Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                             </select>

                                                                        </div>

                                                            </div>

                                                        <div class="form-group">

									<label class="col-lg-2 control-label">Slot 3</label>

									<div class="col-lg-4">

                                                                            <select name="slot3_start_time[]" id="slot3_start_time_<?php echo $i;?>"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">

                                                                                   <option value="">From Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                             </select>

                                                                            <select name="slot3_end_time[]" id="slot3_end_time_<?php echo $i;?>"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">

                                                                                   <option value="">To Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                             </select>

                                                                        </div>

									

									<label class="col-lg-2 control-label">Slot 4</label>

									<div class="col-lg-4">

                                                                            <select name="slot4_start_time[]" id="slot4_start_time_<?php echo $i;?>"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">

                                                                                   <option value="">From Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                             </select>

                                                                            <select name="slot4_end_time[]" id="slot4_end_time_<?php echo $i;?>"  style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">

                                                                                   <option value="">To Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                             </select>

                                                                        </div>

                                                            </div>

                                                            <div class="form-group">

									<label class="col-lg-2 control-label">Slot 5</label>

									<div class="col-lg-4">

                                                                            <select name="slot5_start_time[]" id="slot5_start_time_<?php echo $i;?>"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">

                                                                                   <option value="">From Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                             </select>

                                                                            <select name="slot5_end_time[]" id="slot5_end_time_<?php echo $i;?>"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">

                                                                                   <option value="">To Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                             </select>

                                                                        </div>

									

									<label class="col-lg-2 control-label">Slot 6</label>

									<div class="col-lg-4">

                                                                            <select name="slot6_start_time[]" id="slot6_start_time_<?php echo $i;?>"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">

                                                                                   <option value="">From Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                             </select>

                                                                            <select name="slot6_end_time[]" id="slot6_end_time_<?php echo $i;?>"  style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">

                                                                                   <option value="">To Time</option>

                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                                                             </select>

                                                                        </div>

                                                            </div>

                                                        

                                                        <div class="form-group">	

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'venue_image'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Venue Image/Pdf<span style="color:red">*</span></label>

								<div class="col-lg-4">

                                                                    <input  type="file" name="venue_image_file[]" id="venue_image_file_<?php echo $i;?>" class="form-control">

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="venue_image" id="venue_image" value="<?php echo $venue_image;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

								<?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'event_image'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Event Image/Pdf</label>

								<div class="col-lg-4">

									<input type="file" name="event_image_file[]" id="event_image_file_<?php echo $i;?>" class="form-control">

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="event_image" id="event_image" value="<?php echo $venue_image;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

							</div>



                                                        



                                                        <div class="form-group">

                                                            <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'no_of_groups'))

                                                                    { ?>

								<label class="col-lg-2 control-label">No of Groups<span style="color:red">*</span></label>

								<div class="col-lg-4">

                                                                    <input required="" type="text" name="no_of_groups[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_groups_<?php echo $i;?>" class="form-control">

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="no_of_groups" id="no_of_groups" value="<?php echo $no_of_groups;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'no_of_teams'))

                                                                    { ?>

                                                                <label class="col-lg-2 control-label" id="no_of_teams_level_<?php echo $i;?>">No of Teams</label>

								<div class="col-lg-4" id="no_of_teams_div_<?php echo $i;?>">

                                                                    <input  type="text" name="no_of_teams[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_teams_<?php echo $i;?>" class="form-control">

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="no_of_teams" id="no_of_teams" value="<?php echo $no_of_teams;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

							</div>

                                                        <div class="form-group">

                                                            <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'no_of_participants'))

                                                                    { ?>

								<label class="col-lg-2 control-label">No of Participants per team<span style="color:red">*</span></label>

								<div class="col-lg-4">

                                                                    <input type="text" required="" name="no_of_participants[]" onKeyPress="return isNumberKey(event);" maxlength="5" id="no_of_participants_<?php echo $i;?>" class="form-control">

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="no_of_participants" id="no_of_participants" value="<?php echo $no_of_participants;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'no_of_judges'))

                                                                    { ?>

                                                                <label class="col-lg-2 control-label">No of Judges<span style="color:red">*</span></label>

								<div class="col-lg-4">

                                                                    <input type="text" required="" name="no_of_judges[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_judges_<?php echo $i;?>" class="form-control">

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="no_of_judges" id="no_of_judges" value="<?php echo $no_of_judges;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                

							</div>



							<div class="form-group">

                                                            <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'rules_regulation_pdf'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Rules and regulation Image/Pdf <span style="color:red">*</span></label>

								<div class="col-lg-4">

                                                                    <input type="file" required="" name="vloc_menu_file[]" id="vloc_menu_file_<?php echo $i;?>" class="form-control">

								</div>

								<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="rules_regulation_pdf" id="rules_regulation_pdf" value="<?php echo $rules_regulation_pdf;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'institution_profile_pdf'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Institution Profile Pdf</label>

								<div class="col-lg-4">

									<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_<?php echo $i;?>" class="form-control">

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="institution_profile_pdf" id="institution_profile_pdf" value="<?php echo $institution_profile_pdf;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

							</div>

                                                        

                                                        <div class="form-group left-label">

								<label class="col-lg-3 control-label"><strong>Participants Criteria:</strong></label>

							</div>
              <!--add by ample 24-12-19 -->

              <?php 

              for($k=0;$k<$arr_cert_total_cnt[$i];$k++)

              { ?>

              <div id="row_profile_<?php if($k == 0){ echo $i.'_first';}else{ echo $i.'_'.$k;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">


                       <!-- add by ample 20-12-19-->
                        <div class="form-group">
                                                                     
                          <label class="col-lg-2 control-label">Participants Profile<span style="color:red">*</span></label>

                          <div class="col-lg-4">

                            <select  name="participants_profile_<?php echo $i;?>[]" id="participants_profile_<?php echo $i;?>_<?php echo $k;?>" class="form-control" required>        
                               <option value="">Select Profile</option>                                                                     
                              <?php echo $participants_profile=$obj->getFavCategoryRamakant('69','');?>

                            </select>

                          </div>
                        </div>

                                                        <div class="form-group">

                                                            <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_gender'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<select  name="participants_title_<?php echo $i;?>[]" id="participants_title_<?php echo $i;?>_<?php echo $k;?>" class="form-control" required>                                                                              

                                                                                <?php echo $obj->getPersonTitleOption($arr_participants_title[$i]);?>

                                                                                <option value="All">All</option>

									</select>

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="participants_gender_<?php echo $i;?>" id="participants_gender_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $participants_gender;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_special_remark'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Special Remarks<span style="color:red">*</span></label>

								<div class="col-lg-4">

									

                                                                    <textarea required="" class="form-control" name="parti_remarks_<?php echo $i;?>[]" id="parti_remarks_<?php echo $i;?>_<?php echo $k;?>"><?php echo $arr_parti_remarks[$i];?></textarea>

                                                                </div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="participants_special_remark_<?php echo $i;?>" id="participants_special_remark_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $participants_special_remark;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

								

							</div>

                                                         <div class="form-group">

                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_from_age_group'))

                                                                    { ?>

								<label class="col-lg-2 control-label">From Age Group</label>

								<div class="col-lg-4">

									 <input  type="text" name="from_age_<?php echo $i;?>[]" id="from_age_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_from_age[$i]?>" placeholder="From age" class="form-control" >

								</div>

								<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="from_age_<?php echo $i;?>" id="from_age_<?php echo $i;?>_<?php echo $j;?>" value="<?php echo $participants_from_age_group;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_to_age_group'))

                                                                    { ?>

								<label class="col-lg-2 control-label">To Age Group</label>

								<div class="col-lg-4">

                                                                        <input  type="text" name="to_age_<?php echo $i;?>[]" id="to_age_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_to_age[$i]?>" placeholder="To age" class="form-control" >

                                                                </div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="to_age_<?php echo $i;?>" id="to_age_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $participants_to_age_group;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

							</div>

                                                        <div class="form-group">

                                                            <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_from_height'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Height From</label>

								<div class="col-lg-4">

									<select name="from_height_<?php echo $i;?>[]" id="from_height_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >

                                                                            <option value="">Select Height</option>

										<?php   echo $obj->getHeightOptions($arr_from_height[$i]);?>	

                                                                        </select>

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="from_height_<?php echo $i;?>" id="from_height_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $from_height;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

								<?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_to_height'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Height To</label>

								<div class="col-lg-4">

                                                                    <select name="to_height_<?php echo $i;?>[]" id="to_height_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >

                                                                            <option value="">Select Height</option>

										<?php   echo $obj->getHeightOptions($arr_to_height[$i]);?>

                                                                        </select>

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="to_height_<?php echo $i;?>" id="to_height_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $to_height;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

							</div>

                                                         <div class="form-group">

                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_from_weight'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Weight From</label>

								<div class="col-lg-4">

									<select name="from_weight_<?php echo $i;?>[]" id="from_weight_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >

                                                                            <option value="">Select Weight</option>

										<?php

										for($we=45;$we<=200;$we++)

										{ ?>

											<option value="<?php echo $we;?>" <?php if($arr_from_weight[$i] == $we) { ?> selected="selected" <?php } ?>><?php echo $we;?> Kgs</option>

										<?php

										} ?>	

                                                                        </select>

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="from_weight_<?php echo $i;?>" id="from_weight_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $from_weight;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

								<?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_to_weight'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Weight To</label>

								<div class="col-lg-4">

                                                                    <select name="to_weight_<?php echo $i;?>[]" id="to_weight_<?php echo $i;?>_<?php echo $j;?>" class="form-control" >

                                                                            <option value="">Select Weight</option>

										<?php

										for($we=45;$we<=200;$we++)

										{ ?>

											<option value="<?php echo $we;?>" <?php if($arr_to_weight[$i] == $we) { ?> selected="selected" <?php } ?>><?php echo $we;?> Kgs</option>

										<?php

										} ?>	

                                                                        </select>

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="to_weight_<?php echo $i;?>" id="to_weight_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $to_weight;?>">

                                                                            

                                                                    <?php

                                                                    } ?>

							</div>


              <div class="form-group">

                  <div class="col-lg-2">

                  <?php

                  if($k == 0)

                  { ?>

                    <a href="javascript:void(0);" onclick="addMoreRowProfile(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>

                  <?php   

                  }

                  else

                  { ?>

                    <a href="javascript:void(0);" onclick="removeRowProfile(<?php echo $i;?>,<?php echo $k;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>

                  <?php 

                  }

                  ?>  

                  </div>

                </div>



              </div>

              <?php 

              }

              ?>

              

             
                                    <!-- comment by ample 23-12-19 -->                     

                                                        <!-- <div class="form-group left-label">

								<label class="col-lg-6 control-label"><strong>Participants Registration, Certification & Memberships:(As applicable)</strong></label>

							</div> -->

							<!-- <?php 

							for($k=0;$k<$arr_cert_total_cnt[$i];$k++)

							{ ?>

							<div id="row_cert_<?php if($k == 0){ echo $i.'_first';}else{ echo $i.'_'.$k;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

								<input type="hidden" name="vc_cert_id_<?php echo $i;?>[]" id="vc_cert_id_<?php echo $i;?>_<?php echo $k;?>" value="0">

								<input type="hidden" name="hdnvc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" id="hdnvc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" value="">

								<div class="form-group small-title">

                                                                    <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_type'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Type</label>

									<div class="col-lg-5">

										<select name="vc_cert_type_id_<?php echo $i;?>[]" id="vc_cert_type_id_<?php echo $i;?>_<?php echo $k;?>" class="form-control">

                                                                                    <option value="">Select</option>

                                                                                    <?php echo $obj->getFavCategoryRamakant('47',''); ?>

										</select>

									</div>

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_type_id_<?php echo $i;?>" id="vc_cert_type_id_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                    <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_name'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Name</label>

									<div class="col-lg-5">

										<input type="text" name="vc_cert_name_<?php echo $i;?>[]" id="vc_cert_name_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_name[$i][$k];?>" placeholder="Name" class="form-control">

									</div>

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

								</div>	

								<div class="form-group small-title">

                                                                    <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_number'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Number</label>

									<div class="col-lg-5">

										<input type="text" name="vc_cert_no_<?php echo $i;?>[]" id="vc_cert_no_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_no[$i][$k];?>" placeholder="Number" class="form-control">

									</div>

                                                                     <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                            

                                                                       <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_issue_by'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Issued By</label>

									<div class="col-lg-5">

										<input type="text" name="vc_cert_issued_by_<?php echo $i;?>[]" id="vc_cert_issued_by_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_issued_by[$i][$k];?>" placeholder="Issued By" class="form-control">

									</div>

                                                                     <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>  

                                                                      

								</div>	

								<div class="form-group small-title">

                                                                     <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_issue_date'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Issued Date</label>

									<div class="col-lg-5">

										<input type="text" name="vc_cert_reg_date_<?php echo $i;?>[]" id="vc_cert_reg_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_reg_date[$i][$k];?>" placeholder="Issued Date" class="form-control clsdatepicker2">

									</div>

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>  

									 <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_validity_date'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Vaidity Date</label>

									<div class="col-lg-5">

										<input type="text" name="vc_cert_validity_date_<?php echo $i;?>[]" id="vc_cert_validity_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_validity_date[$i][$k];?>" placeholder="Validity Date" class="form-control clsdatepicker">

									</div>

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>  

								</div>

								<div class="form-group small-title">

                                                                     <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_scan_copy'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Scan Image</label>

									<div class="col-lg-5">

										<input type="file" name="vc_cert_scan_file_<?php echo $i;?>[]" id="vc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >

									</div>

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>  

								</div>

								<div class="form-group">

									<div class="col-lg-2">

									<?php

									if($k == 0)

									{ ?>

										<a href="javascript:void(0);" onclick="addMoreRowCertificate(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>

									<?php  	

									}

									else

									{ ?>

										<a href="javascript:void(0);" onclick="removeRowCertificate(<?php echo $i;?>,<?php echo $k;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>

									<?php	

									}

									?>	

									</div>

								</div>

							</div>	

							<?php

							} ?> -->

                                                     

                                                        <div class="form-group left-label">

								<label class="col-lg-3 control-label"><strong>Judge:</strong></label>

							</div>

                                                        <div class="form-group">

                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_gender'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Gender</label>

								<div class="col-lg-4">

									<select name="judge_title[]" id="judge_title_<?php echo $i;?>" class="form-control">                                                                              

                                                                                <?php echo $obj->getPersonTitleOption($arr_judge_title[$i]);?>

                                                                                <option value="All">All</option>

									</select>

                                                                  

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="judge_title<?php echo $i;?>" id="arr_judge_title_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>  

                                                                            <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_special_remark'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Special Remarks</label>

								<div class="col-lg-4">

									

                                                                    <textarea  class="form-control" name="judge_remarks[]" id="judge_remarks_<?php echo $i;?>"><?php echo $arr_judge_remarks[$i];?></textarea>

                                                                </div>

								<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="judge_remarks<?php echo $i;?>" id="arr_judge_remarks_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

							</div>

                                                        <div class="form-group left-label">

								<label class="col-lg-6 control-label"><strong>Judge Registration, Certification & Memberships:(As applicable)</strong></label>

							</div>

							<?php 

							for($k=0;$k<$arr_cert_total_cnt[$i];$k++)

							{ ?>

							<div id="row_judge_cert_<?php if($k == 0){ echo $i.'_first';}else{ echo $i.'_'.$k;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

								<input type="hidden" name="judge_cert_id_<?php echo $i;?>[]" id="judge_cert_id_<?php echo $i;?>_<?php echo $k;?>" value="0">

								<input type="hidden" name="hdnjudge_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" id="hdnjudge_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" value="">

								<div class="form-group small-title">

                                                                     <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_type'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Type</label>

									<div class="col-lg-5">

										<select name="judge_cert_type_id_<?php echo $i;?>[]" id="judge_cert_type_id_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >

											<option value="">Select</option>

                                                                                    <?php echo $obj->getFavCategoryRamakant('47',''); ?>

										</select>

									</div>

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="judge_cert_type_id_<?php echo $i;?>" id="judge_cert_type_id_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_name'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Name</label>

									<div class="col-lg-5">

										<input type="text" name="judge_cert_name_<?php echo $i;?>[]" id="judge_cert_name_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_name[$i][$k];?>" placeholder="Name" class="form-control">

									</div>

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="judge_cert_name_<?php echo $i;?>" id="judge_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

								</div>	

								<div class="form-group small-title">

                                                                     <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_number'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Number</label>

									<div class="col-lg-5">

										<input type="text" name="judge_cert_no_<?php echo $i;?>[]" id="judge_cert_no_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_no[$i][$k];?>" placeholder="Number" class="form-control">

									</div>

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="judge_cert_no_<?php echo $i;?>" id="judge_cert_no_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_issue_by'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Issued By</label>

									<div class="col-lg-5">

										<input type="text" name="judge_cert_issued_by_<?php echo $i;?>[]" id="judge_cert_issued_by_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_issued_by[$i][$k];?>" placeholder="Issued By" class="form-control">

									</div>

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="judge_cert_issued_by_<?php echo $i;?>" id="judge_cert_issued_by_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

								</div>	

								<div class="form-group small-title">

                                                                     <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_issue_date'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Issued Date</label>

									<div class="col-lg-5">

										<input type="text" name="judge_cert_reg_date_<?php echo $i;?>[]" id="judge_cert_reg_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_reg_date[$i][$k];?>" placeholder="Issued Date" class="form-control clsdatepicker2">

									</div>

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="judge_cert_reg_date_<?php echo $i;?>" id="judge_cert_reg_date_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                    <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_validity_date'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Vaidity Date</label>

									<div class="col-lg-5">

										<input type="text" name="judge_cert_validity_date_<?php echo $i;?>[]" id="judge_cert_validity_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_validity_date[$i][$k];?>" placeholder="Validity Date" class="form-control clsdatepicker">

									</div>

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="judge_cert_validity_date_<?php echo $i;?>" id="judge_cert_validity_date_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

								</div>

								<div class="form-group small-title">

                                                                    <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_scan_copy'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Scan Image</label>

									<div class="col-lg-5">

										<input type="file" name="judge_cert_scan_file_<?php echo $i;?>[]" id="judge_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >

									</div>

                                                                     <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="judge_cert_scan_file_<?php echo $i;?>" id="judge_cert_scan_file_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

								</div>

								<div class="form-group">

									<div class="col-lg-2">

									<?php

									if($k == 0)

									{ ?>

										<a href="javascript:void(0);" onclick="addMoreRowCertificateJudge(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>

									<?php  	

									}

									else

									{ ?>

										<a href="javascript:void(0);" onclick="removeRowCertificateJudge(<?php echo $i;?>,<?php echo $k;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>

									<?php	

									}

									?>	

									</div>

								</div>

							</div>	

							<?php

							} ?>

                                                        <div class="form-group left-label">

								<label class="col-lg-3 control-label"><strong>Organiser Social Media Details:</strong></label>

							</div>



                                                        <div class="form-group">

                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_facebook_page'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Facebook</label>

								<div class="col-lg-4">

									<input type="text" name="facebook_page_link[]" id="facebook_page_link_<?php echo $i;?>" value="<?php echo $arr_facebook_page_link[$i]?>" placeholder="Facebook Page Link" class="form-control">

								</div>

								<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_twitter_page'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Twitter</label>

								<div class="col-lg-4">

									<input type="text" name="twitter_page_link[]" id="twitter_page_link_<?php echo $i;?>" value="<?php echo $arr_twitter_page_link[$i]?>" placeholder="Twitter Page Link" class="form-control">

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

							</div>



                                                        <div class="form-group">

                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_instagram_page'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Instagram</label>

								<div class="col-lg-4">

									<input type="text" name="instagram_page_link[]" id="instagram_page_link_<?php echo $i;?>" value="<?php echo $arr_instagram_page_link[$i]?>" placeholder="Instgram Page Link" class="form-control">

								</div>

								<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_youtube_channel'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Youtube</label>

								<div class="col-lg-4">

									<input type="text" name="youtube_page_link[]" id="youtube_page_link_<?php echo $i;?>" value="<?php echo $arr_youtube_page_link[$i]?>" placeholder="Youtube Channel Link" class="form-control">

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

							</div>

                                                        

                                                        <div class="form-group left-label">

								<label class="col-lg-3 control-label"><strong>Organiser Contact Details:</strong></label>

							</div>

                                                        <div class="form-group">

                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_gender'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<select name="contact_person_title[]" id="contact_person_title_<?php echo $i;?>" class="form-control" required>

										<?php echo $obj->getPersonTitleOption($arr_contact_person_title[$i]);?>

									</select>

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                   <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_contact_person'))

                                                                    { ?>

								

								<label class="col-lg-2 control-label">Contact Person<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<input type="text" name="contact_person[]" id="contact_person_<?php echo $i;?>" value="<?php echo $arr_contact_person[$i]?>" placeholder="Contact Person" class="form-control" required>

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

							</div>

							

							<div class="form-group">

                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_email'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<input type="text" name="contact_email[]" id="contact_email_<?php echo $i;?>" value="<?php echo $arr_contact_email[$i]?>" placeholder="Contact Email" class="form-control" required>

								</div>

								<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                   <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_contact_number'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<input type="text" name="contact_number[]" id="contact_number_<?php echo $i;?>" value="<?php echo $arr_contact_number[$i]?>" placeholder="Contact Number" class="form-control" required>

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

							</div>

						

							<div class="form-group">

                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_designation'))

                                                                    { ?>

								<label class="col-lg-2 control-label">Contact Designation<span style="color:red">*</span></label>

								<div class="col-lg-4">

                                                                    <select name="contact_designation[]" id="contact_designation_<?php echo $i;?>" class="form-control" required="">

                                                                            <option value="">Select</option>

                                                                                <?php echo $obj->getFavCategoryRamakant('44',''); ?>

									</select>

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_remarks'))

                                                                    { ?>

								

								<label class="col-lg-2 control-label">Remark</label>

								<div class="col-lg-4">

									<input type="text" name="contact_remark[]" id="contact_remark_<?php echo $i;?>" value="<?php echo $arr_contact_remark[$i]?>" placeholder="Remark" class="form-control">

								</div>

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

							</div>

							

							<div class="form-group left-label">

								<label class="col-lg-6 control-label"><strong>Organisers Licences, Registration, Certification & Memberships:</strong></label>

							</div>

							<?php 

							for($k=0;$k<$arr_cert_total_cnt[$i];$k++)

							{ ?>

							<div id="row_org_cert_<?php if($k == 0){ echo $i.'_first';}else{ echo $i.'_'.$k;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

								<input type="hidden" name="org_cert_id_<?php echo $i;?>[]" id="org_cert_id_<?php echo $i;?>_<?php echo $k;?>" value="0">

								<input type="hidden" name="hdnorg_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" id="hdnorg_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" value="">

								<div class="form-group small-title">

                                                                     <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_type'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Type</label>

									<div class="col-lg-5">

										<select name="org_cert_type_id_<?php echo $i;?>[]" id="org_cert_type_id_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >

                                                                                    <option value="">Select</option>

                                                                                    <?php echo $obj->getFavCategoryRamakant('47',''); ?>

										</select>

									</div>

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_name'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Name</label>

									<div class="col-lg-5">

										<input type="text" name="org_cert_name_<?php echo $i;?>[]" id="org_cert_name_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_name[$i][$k];?>" placeholder="Name" class="form-control">

									</div>

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

								</div>	

								<div class="form-group small-title">

                                                                     <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_number'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Number</label>

									<div class="col-lg-5">

										<input type="text" name="org_cert_no_<?php echo $i;?>[]" id="org_cert_no_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_no[$i][$k];?>" placeholder="Number" class="form-control">

									</div>

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                    <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_issue_by'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Issued By</label>

									<div class="col-lg-5">

										<input type="text" name="org_cert_issued_by_<?php echo $i;?>[]" id="org_cert_issued_by_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_issued_by[$i][$k];?>" placeholder="Issued By" class="form-control">

									</div>

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

								</div>	

								<div class="form-group small-title">

                                                                     <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_issue_date'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Issued Date</label>

									<div class="col-lg-5">

										<input type="text" name="org_cert_reg_date_<?php echo $i;?>[]" id="org_cert_reg_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_reg_date[$i][$k];?>" placeholder="Issued Date" class="form-control clsdatepicker2">

									</div>

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_validity_date'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Vaidity Date</label>

									<div class="col-lg-5">

										<input type="text" name="org_cert_validity_date_<?php echo $i;?>[]" id="org_cert_validity_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_validity_date[$i][$k];?>" placeholder="Validity Date" class="form-control clsdatepicker">

									</div>

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

								</div>

								<div class="form-group small-title">

                                                                     <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_scan_copy'))

                                                                    { ?>

									<label class="col-lg-1 control-label">Scan Image</label>

									<div class="col-lg-5">

										<input type="file" name="org_cert_scan_file_<?php echo $i;?>[]" id="org_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >

									</div>

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            <input type="hidden" name="vc_cert_name_<?php echo $i;?>" id="vc_cert_name_<?php echo $i;?>" value="">

                                                                            

                                                                    <?php

                                                                    } ?>

								</div>

								<div class="form-group">

									<div class="col-lg-2">

									<?php

									if($k == 0)

									{ ?>

										<a href="javascript:void(0);" onclick="addMoreRowCertificateOrg(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>

									<?php  	

									}

									else

									{ ?>

										<a href="javascript:void(0);" onclick="removeRowCertificateOrg(<?php echo $i;?>,<?php echo $k;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>

									<?php	

									}

									?>	

									</div>

								</div>

							</div>	

							<?php

							} ?>

						</div>

					<?php 

					} ?>

						

						

						<hr>

						<div class="form-group">

							<div class="col-lg-offset-3 col-lg-10">

								<div class="pull-left">

									<button class="btn btn-primary rounded" type="sumit" name="btnSubmit" id="btnSubmit">Submit</button>

                       <!-- <button class="btn btn-success rounded" type="button" style="display: block" id="loader"><img src="assets/img/fancybox_loading.gif" > processing..</button> -->

									<a href="edit_events.php?token=<?=base64_encode($_GET['token']);?>"><button type="button" class="btn btn-danger rounded">Cancel</button></a>



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

<script src="js/tokenize2.js"></script>

<script src="admin-js/add-event-loc-validator.js" type="text/javascript"></script>

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





function getStateOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		

                //alert(country_id);

                

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

                               // alert(result);

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

                                //alert(result);

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



	function addMoreRowCertificate(i_val)

	{

		

		var cert_cnt = parseInt($("#cert_cnt_"+i_val).val());

		

		cert_cnt = cert_cnt + 1;

		var new_row = '	<div id="row_cert_'+i_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

							'<input type="hidden" name="vc_cert_id_'+i_val+'[]" id="vc_cert_id_'+i_val+'_'+cert_cnt+'" value="0">'+

							'<input type="hidden" name="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" id="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" value="">'+

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Type</label>'+

								'<div class="col-lg-5">'+

									'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control">'+

										'<option value="">Select</option>'+

                                                                                ' <?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

									'</select>'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Name</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Number</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Issued By</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Issued Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Vaidity Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

								'</div>'+

							'</div>'+

							'<div class="form-group small-title">'+

									'<label class="col-lg-1 control-label">Scan Image</label>'+

									'<div class="col-lg-5">'+

										'<input type="file" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'_'+cert_cnt+'" class="form-control" >'+

									'</div>'+

								'</div>'+

							'<div class="form-group">'+

								'<div class="col-lg-2">'+

									'<a href="javascript:void(0);" onclick="removeRowCertificate('+i_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

								'</div>'+

							'</div>'+

						'</div>';

		

		$("#row_cert_"+i_val+"_first").after(new_row);

		$("#cert_cnt_"+i_val).val(cert_cnt);

		

		var cert_total_cnt = parseInt($("#cert_total_cnt_"+i_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+i_val).val(cert_total_cnt);

		

		$('.clsdatepicker').datepicker();

		$('.clsdatepicker2').datepicker({endDate: new Date});

	}

        

        function addMoreRowCertificateJudge(j_val)

	{

		//alert(j_val);

                //j_val = j_val+1;

		var cert_cnt = parseInt($("#cert_cnt_"+j_val).val());

		cert_cnt = cert_cnt + 1;

		var new_row = '	<div id="row_judge_cert_'+j_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

							'<input type="hidden" name="judge_cert_id_'+j_val+'[]" id="judge_cert_id_'+j_val+'_'+cert_cnt+'" value="0">'+

							'<input type="hidden" name="hdnjudge_cert_scan_file_'+j_val+'_'+cert_cnt+'" id="hdnjudge_cert_scan_file_'+j_val+'_'+cert_cnt+'" value="">'+

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Type</label>'+

								'<div class="col-lg-5">'+

									'<select name="judge_cert_type_id_'+j_val+'[]" id="judge_cert_type_id_'+j_val+'_'+cert_cnt+'" class="form-control">'+

										'<option value="">Select</option>'+

                                                                                ' <?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

									'</select>'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Name</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="judge_cert_name_'+j_val+'[]" id="judge_cert_name_'+j_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Number</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="judge_cert_no_'+j_val+'[]" id="judge_cert_no_'+j_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Issued By</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="judge_cert_issued_by_'+j_val+'[]" id="judge_cert_issued_by_'+j_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Issued Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="judge_cert_reg_date_'+j_val+'[]" id="judge_cert_reg_date_'+j_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Vaidity Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="judge_cert_validity_date_'+j_val+'[]" id="judge_cert_validity_date_'+j_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

								'</div>'+

							'</div>'+

							'<div class="form-group small-title">'+

									'<label class="col-lg-1 control-label">Scan Image</label>'+

									'<div class="col-lg-5">'+

										'<input type="file" name="judge_cert_scan_file_'+j_val+'[]" id="judge_cert_scan_file_'+j_val+'_'+cert_cnt+'" class="form-control" >'+

									'</div>'+

								'</div>'+

							'<div class="form-group">'+

								'<div class="col-lg-2">'+

									'<a href="javascript:void(0);" onclick="removeRowCertificateJudge('+j_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

								'</div>'+

							'</div>'+

						'</div>';

		

                //alert(new_row);

		$("#row_judge_cert_"+j_val+"_first").after(new_row);

		$("#cert_cnt_"+j_val).val(cert_cnt);

		

		var cert_total_cnt = parseInt($("#cert_total_cnt_"+j_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+j_val).val(cert_total_cnt);

		

		$('.clsdatepicker').datepicker();

		$('.clsdatepicker2').datepicker({endDate: new Date});

	}

        

        function addMoreRowCertificateOrg(k_val)

	{

		

		var cert_cnt = parseInt($("#cert_cnt_"+k_val).val());

		cert_cnt = cert_cnt + 1;

		var new_row = '	<div id="row_org_cert_'+k_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

							'<input type="hidden" name="org_cert_id_'+k_val+'[]" id="org_cert_id_'+k_val+'_'+cert_cnt+'" value="0">'+

							'<input type="hidden" name="hdnorg_cert_scan_file_'+k_val+'_'+cert_cnt+'" id="hdnorg_cert_scan_file_'+k_val+'_'+cert_cnt+'" value="">'+

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Type</label>'+

								'<div class="col-lg-5">'+

									'<select name="org_cert_type_id_'+k_val+'[]" id="org_cert_type_id_'+k_val+'_'+cert_cnt+'" class="form-control">'+

										'<option value="">Select</option>'+

                                                                                ' <?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

									'</select>'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Name</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="org_cert_name_'+k_val+'[]" id="org_cert_name_'+k_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Number</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="org_cert_no_'+k_val+'[]" id="org_cert_no_'+k_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Issued By</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="org_cert_issued_by_'+k_val+'[]" id="org_cert_issued_by_'+k_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Issued Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="org_cert_reg_date_'+k_val+'[]" id="org_cert_reg_date_'+k_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Vaidity Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="org_cert_validity_date_'+k_val+'[]" id="org_cert_validity_date_'+k_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

								'</div>'+

							'</div>'+

							'<div class="form-group small-title">'+

									'<label class="col-lg-1 control-label">Scan Image</label>'+

									'<div class="col-lg-5">'+

										'<input type="file" name="org_cert_scan_file_'+k_val+'[]" id="org_cert_scan_file_'+k_val+'_'+cert_cnt+'" class="form-control" >'+

									'</div>'+

								'</div>'+

							'<div class="form-group">'+

								'<div class="col-lg-2">'+

									'<a href="javascript:void(0);" onclick="removeRowCertificateOrg('+k_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

								'</div>'+

							'</div>'+

						'</div>';

		

		$("#row_org_cert_"+k_val+"_first").after(new_row);

		$("#cert_cnt_"+k_val).val(cert_cnt);

		

		var cert_total_cnt = parseInt($("#cert_total_cnt_"+k_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+k_val).val(cert_total_cnt);

		

		$('.clsdatepicker').datepicker();

		$('.clsdatepicker2').datepicker({endDate: new Date});

	}

  function addMoreRowProfile(j_val)

  {


    var cert_cnt = parseInt($("#cert_cnt_"+j_val).val());

    cert_cnt = cert_cnt + 1;

    var new_row = ' <div id="row_profile_'+j_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

                  ' <div class="form-group">'+
                          '<label class="col-lg-2 control-label">Participants Profile<span style="color:red">*</span></label>'+
                          '<div class="col-lg-4">'+
                            '<select  name="participants_profile_'+j_val+'[]" id="participants_profile_'+j_val+'_'+cert_cnt+'" class="form-control" required>'+'<option value="">Select Profile</option> '+                                                                    
                              '<?php echo $participants_profile=$obj->getFavCategoryRamakant('69','');?>'+
                            '</select>'+
                          '</div>'+
                        '</div>'+
                  '<div class="form-group">'+
                    '<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+
                    '<div class="col-lg-4">'+
                      '<select  name="participants_title_'+j_val+'[]" id="participants_title_'+j_val+'_'+cert_cnt+'" class="form-control" required>'+
                              '<?php echo $obj->getPersonTitleOption($arr_participants_title[$i]);?>'+
                              '<option value="Other">Other</option>'+
                     '</select>'+
                    '</div>'+
                    '<label class="col-lg-2 control-label">Special Remarks<span style="color:red">*</span></label>'+
                    '<div class="col-lg-4">'+
                          '<textarea required="" class="form-control" name="parti_remarks_'+j_val+'[]" id="parti_remarks_'+j_val+'_'+cert_cnt+'"></textarea>'+

                      '</div>'+
                  '</div>'+
                  '<div class="form-group">'+
                    '<label class="col-lg-2 control-label">From Age Group</label>'+
                    '<div class="col-lg-4">'+
                       '<input  type="text" name="from_age_'+j_val+'[]" id="from_age_'+j_val+'_'+cert_cnt+'" value="" placeholder="From age" class="form-control" >'+
                    '</div>'+
                    '<label class="col-lg-2 control-label">To Age Group</label>'+
                    '<div class="col-lg-4">'+
                          '<input  type="text" name="to_age_'+j_val+'[]" id="to_age_'+j_val+'_'+cert_cnt+'" value="" placeholder="To age" class="form-control" >'+
                      '</div>'+
                  '</div>'+
                  '<div class="form-group">'+
                    '<label class="col-lg-2 control-label">Height From</label>'+
                    '<div class="col-lg-4">'+
                      '<select name="from_height_'+j_val+'[]" id="from_height_'+j_val+'_'+cert_cnt+'" class="form-control" >'+
                              '<option value="">Select Height</option>'+
                        '<?php   echo $obj->getHeightOptions($arr_from_height[$i]);?> '+ 
                          '</select>'+
                    '</div>'+
                    '<label class="col-lg-2 control-label">Height To</label>'+
                    '<div class="col-lg-4">'+
                          '<select name="to_height_'+j_val+'[]" id="to_height_'+j_val+'_'+cert_cnt+'" class="form-control" >'+
                              '<option value="">Select Height</option>'+
                        '<?php   echo $obj->getHeightOptions($arr_to_height[$i]);?>'+
                          '</select>'+
                    '</div>'+
                  '</div>'+
                  '<div class="form-group">'+
                    '<label class="col-lg-2 control-label">Weight From</label>'+
                    '<div class="col-lg-4">'+
                      '<select name="from_weight_'+j_val+'[]" id="from_weight_'+j_val+'_<?php echo $k;?>" class="form-control" >'+
                              '<option value="">Select Weight</option>'+
                        <?php
                        for($we=45;$we<=200;$we++)
                        { ?>
                          '<option value="<?php echo $we;?>" ><?php echo $we;?> Kgs</option>'+
                        <?php
                        } ?>  
                          '</select>'+
                    '</div>'+
                    '<label class="col-lg-2 control-label">Weight To</label>'+
                    '<div class="col-lg-4">'+
                          '<select name="to_weight_'+j_val+'[]" id="to_weight_'+j_val+'_<?php echo $j;?>" class="form-control" >'+
                              '<option value="">Select Weight</option>'+
                        <?php
                        for($we=45;$we<=200;$we++)
                        { ?>
                          '<option value="<?php echo $we;?>" ><?php echo $we;?> Kgs</option>'+
                        <?php
                        } ?>  
                              '</select>'+
                    '</div>'+
                  '</div> '+             
                  '<div class="form-group">'+

                '<div class="col-lg-2">'+

                  '<a href="javascript:void(0);" onclick="removeRowProfile('+j_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

                '</div>'+

              '</div>'+

            '</div>';
    

    $("#row_profile_"+j_val+"_first").after(new_row);

    $("#cert_cnt_"+j_val).val(cert_cnt);


    var cert_total_cnt = parseInt($("#cert_total_cnt_"+j_val).val());

    cert_total_cnt = cert_total_cnt + 1;

    $("#cert_total_cnt_"+j_val).val(cert_total_cnt);

  }

	

	function removeRowCertificate(i_val,cert_cnt)

	{

		$("#row_cert_"+i_val+"_"+cert_cnt).remove();



		var cert_total_cnt = parseInt($("#cert_total_cnt_"+i_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+i_val).val(cert_total_cnt);

		

	}


function removeRowProfile(i_val,cert_cnt)

  {

    $("#row_profile_"+i_val+"_"+cert_cnt).remove();


    var cert_total_cnt = parseInt($("#cert_total_cnt_"+i_val).val());

    cert_total_cnt = cert_total_cnt + 1;

    $("#cert_total_cnt_"+i_val).val(cert_total_cnt);

    
  }

	

        function removeRowCertificateJudge(j_val,cert_cnt)

	{

		$("#row_judge_cert_"+j_val+"_"+cert_cnt).remove();



		var cert_total_cnt = parseInt($("#cert_total_cnt_"+j_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+j_val).val(cert_total_cnt);

		

	}

        

        function removeRowCertificateOrg(k_val,cert_cnt)

	{

		$("#row_org_cert_"+k_val+"_"+cert_cnt).remove();



		var cert_total_cnt = parseInt($("#cert_total_cnt_"+k_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+k_val).val(cert_total_cnt);

		

	}


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

    

</script>

</body>

</html>