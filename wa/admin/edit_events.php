<?php

require_once('../classes/config.php');

require_once('../classes/admin.php');

$admin_main_menu_id = '11';

$add_action_id = '21';

$edit_action_id = '22';



$obj = new Admin();

$obj2 = new commonFunctions();





//echo 'Hiiii';

//die();





if(!$obj->isAdminLoggedIn())

{

    header("Location: login.php");

    exit(0);

}

else

{

    $admin_id = $_SESSION['admin_id'];

}





if(!$obj->chkIfAccessOfMenu($admin_id,$admin_main_menu_id))

{

   

    header("Location: invalid.php");

    exit(0);

}



if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))

{     

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

    

   // echo '<pre>';

   // print_r($arr_record);

   // echo '</pre>';



    // $get_time_slot=$obj->getTimeslot($arr_record['event_master_id']);



    

    

    

    $vendor_details = $obj->getVendorUserDetails($arr_record['organiser_id']);

    $va_id = $obj->getVendorVAID($arr_record['organiser_id']);

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

   //      // custom function write by ample 28-12-19
   // $final_dropdown=$obj->FilterDataDropdown($data_dropdown);

     //add by ample 09-10-20
    $tags=$obj->GETDATADROPDOWNMYDAYTODAYOPTION_ForEventTags($vendor_details['vendor_cat_id'],211);


    

    $arr_event_foramt = array();

    $arr_vloc_parent_cat_id = array();

    $arr_vloc_cat_id = array();

    $arr_country_id = array();

    $arr_state_id = array();

    $arr_city_id = array();

    $arr_area_id = array();

    $arr_venue = array();

    $arr_start_date = array();

    $arr_start_time = array();

    $arr_end_date = array();

    $arr_end_time = array();

    $arr_time_zone = array();

    $arr_no_of_groups = array();

    $arr_no_of_teams = array();

    $arr_no_of_participants = array();

    $arr_no_of_judges = array();

    $arr_participants_title = array();

    $arr_parti_remarks = array();

    $arr_from_age = array();

    $arr_to_age = array();

    $arr_from_height =array();

    $arr_to_height =array();

    $arr_from_weight =array();

    $arr_to_weight =array();

    $arr_judge_title = array();

    $arr_judge_remarks = array();

    $arr_facebook_page_link = array();

    $arr_twitter_page_link = array();

    $arr_instagram_page_link = array();

    $arr_youtube_page_link = array();

    $arr_contact_person_title = array();

    $arr_contact_person = array();

    $arr_contact_email = array();

    $arr_contact_number = array();

    $arr_contact_designation = array();

    $arr_contact_remark = array();

    $arr_venue_image =array();

    $arr_event_image =array();

    $arr_rules_regulation_pdf = array();

    $arr_institution_profile_pdf = array();

    

    $arr_org_cert_type_id = array();

    $arr_org_cert_name = array();

    $arr_org_cert_no = array();

    $arr_org_cert_issued_by = array();

    $arr_org_cert_reg_date = array();

    $arr_org_cert_validity_date = array();

    $arr_certificate_scan_copy = array();

    

    $arr_cert_cnt = array();

    $arr_cert_total_cnt = array();

    $arr_org_cert_cnt = array();

    $arr_org_cert_total_cnt = array();

    $arr_vc_cert_id = array();

    $arr_vc_cert_type_id = array();

    $arr_vc_cert_name = array();

    $arr_vc_cert_no = array();

    $arr_vc_cert_issued_by = array();

    $arr_vc_cert_reg_date = array();

    $arr_vc_cert_validity_date = array();

    $arr_vc_cert_scan_file = array();



    $slot1_start_time_arr=array();

    $slot1_end_time_arr=array();



    $slot2_start_time_arr=array();

    $slot2_end_time_arr=array();



    $slot3_start_time_arr=array();

    $slot3_end_time_arr=array();



    $slot4_start_time_arr=array();

    $slot4_end_time_arr=array();



    $slot5_start_time_arr=array();

    $slot5_end_time_arr=array();



    $slot6_start_time_arr=array();

    $slot6_end_time_arr=array();



    $arr_loc_record = $obj->getEventAllLocationsAndCertifications($event_master_id,$arr_record['organiser_id']);



    // echo "<pre>";print_r($arr_loc_record[$i]['slot1_start_time'] );echo "</pre>";

         
    // echo "<pre>";

    // print_r($arr_loc_record);

    // die('jkshfjksa');




    

    if(count($arr_loc_record)>0)

    {

            $cat_total_cnt = count($arr_loc_record);

            $cat_cnt = $cat_total_cnt - 1;

            for($i=0;$i<count($arr_loc_record);$i++)

            {

                array_push($arr_event_foramt,$arr_loc_record[$i]['event_format']);

                array_push($arr_vloc_parent_cat_id , $arr_loc_record[$i]['location_category']);

                array_push($arr_vloc_cat_id , $arr_loc_record[$i]['location_sub_category']);

                array_push($arr_country_id , $arr_loc_record[$i]['country_id']);

                array_push($arr_state_id , $arr_loc_record[$i]['state_id']);

                array_push($arr_city_id , $arr_loc_record[$i]['city_id']);

                array_push($arr_area_id , $arr_loc_record[$i]['area_id']);

                array_push($arr_venue , $arr_loc_record[$i]['venue_details']);

                array_push($arr_start_date , $arr_loc_record[$i]['start_date']);

                array_push($arr_start_time , $arr_loc_record[$i]['start_time']);

                array_push($arr_end_date , $arr_loc_record[$i]['end_date']);

                array_push($arr_end_time , $arr_loc_record[$i]['end_time']);

                array_push($arr_time_zone , $arr_loc_record[$i]['time_zone_id']);

                array_push($arr_venue_image , $arr_loc_record[$i]['venue_image']);

                array_push($arr_event_image , $arr_loc_record[$i]['event_image']);

                array_push($arr_no_of_groups , $arr_loc_record[$i]['no_of_groups']);

                array_push($arr_no_of_teams , $arr_loc_record[$i]['no_of_teams']);

                array_push($arr_no_of_participants , $arr_loc_record[$i]['no_of_participants']);

                array_push($arr_no_of_judges , $arr_loc_record[$i]['no_of_judges']);

                array_push($arr_rules_regulation_pdf , $arr_loc_record[$i]['rules_regulation_pdf']);

                array_push($arr_institution_profile_pdf , $arr_loc_record[$i]['institution_profile_pdf']);

                array_push($arr_participants_title , $arr_loc_record[$i]['participants_gender']);

                array_push($arr_parti_remarks , $arr_loc_record[$i]['participants_special_remark']);

                array_push($arr_from_age , $arr_loc_record[$i]['participants_from_age_group']);

                array_push($arr_to_age , $arr_loc_record[$i]['participants_to_age_group']);

                array_push($arr_from_height , $arr_loc_record[$i]['participants_from_height']);

                array_push($arr_to_height , $arr_loc_record[$i]['participants_to_height']);

                array_push($arr_from_weight , $arr_loc_record[$i]['participants_from_weight']);

                array_push($arr_to_weight , $arr_loc_record[$i]['participants_to_weight']);

                array_push($arr_judge_title , $arr_loc_record[$i]['judge_gender']);

                array_push($arr_judge_remarks , $arr_loc_record[$i]['judge_special_remark']);

                array_push($arr_facebook_page_link , $arr_loc_record[$i]['organiser_facebook_page']);

                array_push($arr_twitter_page_link , $arr_loc_record[$i]['organiser_twitter_page']);

                array_push($arr_instagram_page_link , $arr_loc_record[$i]['organiser_instagram_page']);

                array_push($arr_youtube_page_link , $arr_loc_record[$i]['organiser_youtube_channel']);

                array_push($arr_contact_person_title , $arr_loc_record[$i]['organiser_gender']);

                array_push($arr_contact_person , $arr_loc_record[$i]['organiser_contact_person']);

                array_push($arr_contact_email , $arr_loc_record[$i]['organiser_email']);

                array_push($arr_contact_number , $arr_loc_record[$i]['organiser_contact_number']);

                array_push($arr_contact_designation , $arr_loc_record[$i]['organiser_designation']);

                array_push($arr_contact_remark , $arr_loc_record[$i]['organiser_remarks']);





                array_push($slot1_start_time_arr,$arr_loc_record[$i]['slot1_start_time']);

                array_push($slot1_end_time_arr,$arr_loc_record[$i]['slot1_end_time']);



                array_push($slot2_start_time_arr,$arr_loc_record[$i]['slot2_start_time']);

                array_push($slot2_end_time_arr,$arr_loc_record[$i]['slot2_end_time']);



                array_push($slot3_start_time_arr,$arr_loc_record[$i]['slot3_start_time']);

                array_push($slot3_end_time_arr,$arr_loc_record[$i]['slot3_end_time']);



                 array_push($slot4_start_time_arr,$arr_loc_record[$i]['slot4_start_time']);

                array_push($slot4_end_time_arr,$arr_loc_record[$i]['slot4_end_time']);



                array_push($slot5_start_time_arr,$arr_loc_record[$i]['slot5_start_time']);

                array_push($slot5_end_time_arr,$arr_loc_record[$i]['slot5_end_time']);



                array_push($slot6_start_time_arr,$arr_loc_record[$i]['slot6_start_time']);

                array_push($slot6_end_time_arr,$arr_loc_record[$i]['slot6_end_time']);



                 // add by ample  30-12-19
                $arr_pp_criteria_id[$i] = array();
                $arr_pp_profile[$i] = array();
                $arr_pp_gender[$i] = array();
                $arr_pp_special_remark[$i] = array();
                $arr_pp_from_age_group[$i] = array();
                $arr_pp_to_age_group[$i] = array();
                $arr_pp_from_height[$i] = array();
                $arr_pp_to_height[$i] = array();
                $arr_pp_from_weight[$i] = array();
                $arr_pp_to_weight[$i] = array();

                $arr_pp_data_total_cnt[$i] = count($arr_loc_record[$i]['participant_profile']);
                $arr_pp_data_cnt[$i] = $arr_pp_data_total_cnt[$i] - 1;

                for($k=0;$k<count($arr_loc_record[$i]['participant_profile']);$k++)
                {
                  array_push($arr_pp_criteria_id[$i], $arr_loc_record[$i]['participant_profile'][$k]['criteria_id']);
                  array_push($arr_pp_profile[$i], $arr_loc_record[$i]['participant_profile'][$k]['profile']);
                  array_push($arr_pp_gender[$i], $arr_loc_record[$i]['participant_profile'][$k]['gender']);
                  array_push($arr_pp_special_remark[$i], $arr_loc_record[$i]['participant_profile'][$k]['special_remark']);
                  array_push($arr_pp_from_age_group[$i], $arr_loc_record[$i]['participant_profile'][$k]['from_age_group']);
                  array_push($arr_pp_to_age_group[$i], $arr_loc_record[$i]['participant_profile'][$k]['to_age_group']);
                  array_push($arr_pp_from_height[$i], $arr_loc_record[$i]['participant_profile'][$k]['from_height']);
                  array_push($arr_pp_to_height[$i], $arr_loc_record[$i]['participant_profile'][$k]['to_height']);
                  array_push($arr_pp_from_weight[$i], $arr_loc_record[$i]['participant_profile'][$k]['from_weight']);
                  array_push($arr_pp_to_weight[$i], $arr_loc_record[$i]['participant_profile'][$k]['to_weight']);
                } 


               //$arr_part_certificate = $obj->getAllEventOrgCertificate($event_price_id); 

                

                $arr_vc_cert_id[$i] = array();

                $arr_vc_cert_type_id[$i] = array();

                $arr_vc_cert_name[$i] = array();

                $arr_vc_cert_no[$i] = array();

                $arr_vc_cert_issued_by[$i] = array();

                $arr_vc_cert_reg_date[$i] = array();

                $arr_vc_cert_validity_date[$i] = array();

                $arr_vc_cert_scan_file[$i] = array();

                

               $arr_cert_total_cnt[$i] = 1;

               $arr_cert_cnt[$i] = $arr_cert_total_cnt[$i] - 1;

                



               $arr_org_cert_id[$i] = array();

               $arr_org_cert_type_id[$i] = array();

               $arr_org_cert_name[$i] = array();

               $arr_org_cert_no[$i] = array();

               $arr_org_cert_issued_by[$i] = array();

               $arr_org_cert_reg_date[$i] = array();

               $arr_org_cert_validity_date[$i] = array();

               $arr_org_cert_scan_file[$i] = array();

               



               //$arr_cert_total_cnt[$i] = count($arr_loc_record[$i]['certificate']);

              // $arr_cert_cnt[$i] = $arr_cert_total_cnt[$i] - 1;

               

                 $arr_org_cert_total_cnt[$i] = count($arr_loc_record[$i]['organiser_certificate']);

                 $arr_org_cert_cnt[$i] = $arr_org_cert_total_cnt[$i] - 1;

              

               

                

      for($k=0;$k<count($arr_loc_record[$i]['organiser_certificate']);$k++)

            {

                array_push($arr_org_cert_id[$i], $arr_loc_record[$i]['organiser_certificate'][$k]['certificate_type']);

                array_push($arr_org_cert_type_id[$i], $arr_loc_record[$i]['organiser_certificate'][$k]['certificate_type']);

                array_push($arr_org_cert_name[$i], $arr_loc_record[$i]['organiser_certificate'][$k]['certificate_name']);

                array_push($arr_org_cert_no[$i], $arr_loc_record[$i]['organiser_certificate'][$k]['certificate_number']);

                array_push($arr_org_cert_issued_by[$i], $arr_loc_record[$i]['organiser_certificate'][$k]['certificate_issue_by']);

                

                if($arr_loc_record[$i]['organiser_certificate'][$k]['certificate_issue_date'] != '' && $arr_loc_record[$i]['organiser_certificate'][$k]['certificate_issue_date'] != '0000-00-00')

                {

                    $arr_org_cert_reg_date[$i][$k] = date('d-m-Y',strtotime($arr_loc_record[$i]['organiser_certificate'][$k]['certificate_issue_date']));

                }

                else

                {

                    $arr_org_cert_reg_date[$i][$k] = '';

                }

                

                if($arr_loc_record[$i]['organiser_certificate'][$k]['certificate_validity_date'] != '' && $arr_loc_record[$i]['organiser_certificate'][$k]['certificate_validity_date'] != '0000-00-00')

                {

                    $arr_org_cert_validity_date[$i][$k] = date('d-m-Y',strtotime($arr_loc_record[$i]['organiser_certificate'][$k]['certificate_validity_date']));

                }

                else

                {

                    $arr_org_cert_validity_date[$i][$k] = '';

                }

                

                array_push($arr_org_cert_scan_file[$i], $arr_loc_record[$i]['organiser_certificate'][$k]['certificate_scan_copy']);

            }

                

               // add by ample 30-12-19

                $arr_jc_cert_id[$i] = array();

                $arr_jc_cert_type_id[$i] = array();

                $arr_jc_cert_name[$i] = array();

                $arr_jc_cert_no[$i] = array();

                $arr_jc_cert_issued_by[$i] = array();

                $arr_jc_cert_reg_date[$i] = array();

                $arr_jc_cert_validity_date[$i] = array();

                $arr_jc_cert_scan_file[$i] = array();


                 $arr_jc_cert_total_cnt[$i] = count($arr_loc_record[$i]['judge_certificate']);

                 $arr_jc_cert_cnt[$i] = $arr_jc_cert_total_cnt[$i] - 1;

              

                for($k=0;$k<count($arr_loc_record[$i]['judge_certificate']);$k++)

                {

                  array_push($arr_jc_cert_id[$i], $arr_loc_record[$i]['judge_certificate'][$k]['certificate_type']);

                  array_push($arr_jc_cert_type_id[$i], $arr_loc_record[$i]['judge_certificate'][$k]['certificate_type']);

                  array_push($arr_jc_cert_name[$i], $arr_loc_record[$i]['judge_certificate'][$k]['certificate_name']);

                  array_push($arr_jc_cert_no[$i], $arr_loc_record[$i]['judge_certificate'][$k]['certificate_number']);

                  array_push($arr_jc_cert_issued_by[$i], $arr_loc_record[$i]['judge_certificate'][$k]['certificate_issue_by']);

                  

                  if($arr_loc_record[$i]['judge_certificate'][$k]['certificate_issue_date'] != '' && $arr_loc_record[$i]['judge_certificate'][$k]['certificate_issue_date'] != '0000-00-00')

                  {

                    $arr_jc_cert_reg_date[$i][$k] = date('d-m-Y',strtotime($arr_loc_record[$i]['judge_certificate'][$k]['certificate_issue_date']));

                  }

                  else

                  {

                    $arr_jc_cert_reg_date[$i][$k] = '';

                  }

                  

                  if($arr_loc_record[$i]['judge_certificate'][$k]['certificate_validity_date'] != '' && $arr_loc_record[$i]['judge_certificate'][$k]['certificate_validity_date'] != '0000-00-00')

                  {

                    $arr_jc_cert_validity_date[$i][$k] = date('d-m-Y',strtotime($arr_loc_record[$i]['judge_certificate'][$k]['certificate_validity_date']));

                  }

                  else

                  {

                    $arr_jc_cert_validity_date[$i][$k] = '';

                  }

                  

                  array_push($arr_jc_cert_scan_file[$i], $arr_loc_record[$i]['judge_certificate'][$k]['certificate_scan_copy']);

                }
                

                

            }

           

           

        }

        else {

               $cat_cnt = 0;

               $cat_total_cnt = 1;

        }

        

        

        

        

        

    // echo "<pre>";print_r($slot3_end_time_arr);echo "</pre>";

    

    

//    echo '<pre>';

//    print_r($arr_org_cert_type_id);

//    echo '</pre>';

    

}

else

{

    $cat_cnt = 0;

        $cat_total_cnt = 1;

        $arr_vloc_parent_cat_id = array('2');

        $arr_vloc_cat_id = array('');

        $arr_contact_person_title = array('');

        $arr_contact_person = array('');

        $arr_contact_email = array('');

        $arr_contact_number = array('');

        $arr_contact_designation = array('');

        $arr_contact_remark = array('');

        $arr_vloc_speciality_offered = array('');



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

        <div class="col-sm-12">

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

                        <?php 

                                                    $default_vloc_parent_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'location_category');

                                                    $vloc_parent_cat_id = $default_vloc_parent_cat_id;

                                                    $default_vloc_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'location_sub_category');

                                                ?>

                                                <div class="form-group">

                                                        <label class="col-lg-2 control-label">Reference Number</label>

                                                        <div class="col-lg-2">

                                                            <input type="text" name="reference_number" readonly="" id="reference_number" value="<?php echo $arr_record['reference_number']; ?>" >

                                                            

                                                        </div>

                                                        <label class="col-lg-2 control-label">System Category<span style="color:red">*</span></label>

                                                        <div class="col-lg-2">

                                                            <?php echo $obj->getFavCatNameById($arr_record['wellbeing_id']) ?>

                                                            

                                                        </div>

                                                        <label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>

                            <div class="col-lg-2">

                                <select name="event_status" id="event_status" class="form-control">

                                    <option value="1" <?php if($arr_record['status'] == '1'){?> selected <?php } ?>>Active</option> 

                                    <option value="0" <?php if($arr_record['status'] == '0'){?> selected <?php } ?>>Inactive</option> 

                                </select>

                            </div>

                                                </div>

                                                <div class="form-group">

                            <label class="col-lg-2 control-label">Organizer<span style="color:red">*</span></label>

                            <div class="col-lg-4">

<!--                                <select name="organiser_id" id="organiser_id" class="form-control" required>

                                    <?php //echo $obj->getVendorOption($arr_record['organiser_id'],$type='1',$multiple='0');?>

                                </select>-->

                                                            <?php echo $vendor_details['vendor_name']; ?>

                                                            <input type="hidden" name="organiser_id" id="organiser_id" value="<?php echo $arr_record['organiser_id']; ?>" >

                            </div>

                                                        <label class="col-lg-2 control-label">Institution<span style="color:red">*</span></label>

                            <div class="col-lg-4">

<!--                                <select name="institution_id" id="institution_id" class="form-control" required>

                                    <?php //echo $obj->getVendorOption($arr_record['institution_id'],$type='1',$multiple='0');?>

                                </select>-->

                                                            

                                                            <input type="text" name="institution_id" id="institution_id" value="<?php echo $arr_record['institution_id']; ?>" class="form-control">

                                                            

                            </div>

                        </div>

                                                

                                                <div class="form-group">

                                                    <label class="col-lg-2 control-label">Sponsor Name</label>

                            <div class="col-lg-4">

<!--                                                            <select name="sponsor_id" id="sponsor_id" class="form-control">

                                    <?php //echo $obj->getVendorOption($arr_record['sponsor_id'],$type='1',$multiple='0');?>

                                                            </select>-->

                                                            <input type="text" name="sponsor_id" id="sponsor_id" value="<?php echo $arr_record['sponsor_id']; ?>" class="form-control" >

                            </div>

                                                    <label class="col-lg-2 control-label">Event Name<span style="color:red">*</span></label>

                            <div class="col-lg-4">

                                <input type="text" name="event_name" id="event_name" value="<?php echo $arr_record['event_name'];?>" placeholder="Event Name" class="form-control" required>

                            </div>

                        </div>

                                                <div class="form-group">

                                                         <label class="col-lg-2 control-label"><?=($tags['tag_heading'])? $tags['tag_heading'] : 'Event Tags';?></label>

                                                        <div class="col-lg-10">

                                                                <select name="event_tags[]" id="event_tags" multiple="multiple" class="form-control vloc_speciality_offered" >

                                                                         <!-- <?php echo $final_dropdown; ?> -->

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

                                                <div class="form-group"><label class="col-lg-2 control-label">Events Contents<span style="color:red">*</span></label>

                            <div class="col-lg-8">

                                <div class="summernote-theme-1">

                                    <div class="event_contents" name="event_contents" id="event_contents"><?php echo $arr_record['event_contents'];?></div>

                                </div>

                            </div>

                        </div>

                                                

                                                <div class="form-group">

                                                        <label class="col-lg-2 control-label" id="prof_header1"><?php echo $profile_data['header1']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_1" class="form-control" id="profile_cat_1"  onchange="getMainCategoryOptionAddMoreSingle('1')">

                                                            <!--<option value="">All Type</option>-->   

                                                            <?php //echo $obj->getFavCategoryTypeOptions($arr_record['prof_cat_id_1']);

                                                                     echo  $obj->GetPfileCatEdit($arr_record['wellbeing_id'],'151','prof_cat_id_1',$arr_record['prof_cat_id_1']);

                                                            ?>

                                                            </select>

                                                        </div>

                            <label class="col-lg-2 control-label">Fav Category</label>

                                                        <div class="col-lg-4" id="">

                                                            

                                                            <select name="fav_cat_1[]" class="form-control" id="fav_cat_1" >

                                                                <option value="">Select Sub Cat</option>

                                                                <?php echo $obj->getAllCategoryOptionEventEdit($arr_record['prof_cat_id_1'],$arr_record['fav_cat_id_1']); ?>

                                                            </select>

                                                            

                                                        </div>

                        </div>

                                                

                                                <div class="form-group">

                                                        <label class="col-lg-2 control-label" id="prof_header2"><?php echo $profile_data['header2']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_2" class="form-control" id="profile_cat_2"  onchange="getMainCategoryOptionAddMore('2')">

                                                            <!--<option value="">All Type</option>-->   

                                                            <?php // echo $obj->getFavCategoryTypeOptions($arr_record['prof_cat_id_2']);

                                                            

                                                            echo  $obj->GetPfileCatEdit($arr_record['wellbeing_id'],'151','prof_cat_id_2',$arr_record['prof_cat_id_2']);

                                                            ?>

                                                            </select>

                                                        </div>

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

                        </div>

                                                

                                                <div class="form-group">

                                                        <label class="col-lg-2 control-label" id="prof_header3"><?php echo $profile_data['header3']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_3" class="form-control" id="profile_cat_3"  onchange="getMainCategoryOptionAddMore('3')">

                                                            <option value="">All Type</option>  

                                                            <?php echo $obj->getFavCategoryTypeOptions($arr_record['prof_cat_id_3']);?>

                                                            </select>

                                                        </div>

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

                        </div>

                                                

                                                <div class="form-group">

                                                        <label class="col-lg-2 control-label" id="prof_header4"><?php echo $profile_data['header4']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_4" class="form-control" id="profile_cat_4"  onchange="getMainCategoryOptionAddMore('4')">

                                                            <option value="">All Type</option>  

                                                            <?php echo $obj->getFavCategoryTypeOptions($arr_record['prof_cat_id_4']);?>

                                                            </select>

                                                        </div>

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

                        </div>

                                                

                                                <div class="form-group">

                                                        <label class="col-lg-2 control-label" id="prof_header5"><?php echo $profile_data['header5']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_5" class="form-control" id="profile_cat_5"  onchange="getMainCategoryOptionAddMore('5')">

                                                            <option value="">All Type</option>  

                                                            <?php echo $obj->getFavCategoryTypeOptions($arr_record['prof_cat_id_5']);?>

                                                            </select>

                                                        </div>

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

                        </div>

                        <hr>

                        <?php if($arr_record['admin_type'] != 'Vendor' ) { ?> 

                        <a href="add_event_location.php?token=<?=$_GET['token']?>" target="_blank" class="pull-right"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">ADD Event-Location details</button></a>

                         <?php } ?> 
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
                            if(!empty($arr_loc_record))
                            {
                                foreach ($arr_loc_record as $key => $value) {
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

                                            <?php if($arr_record['admin_type'] != 'Vendor' ) { ?> 
                                                
                                                    <a href="edit_event_location.php?token=<?=base64_encode($value['event_master_id']);?>&event=<?=base64_encode($value['event_id']);?>" target="_blank"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">Edit</button></a>
                                                

                                            <?php } 
                                            else
                                            {
                                                ?>
                                                 <a href="edit_event_location.php?token=<?=base64_encode($value['event_master_id']);?>&event=<?=base64_encode($value['event_id']);?>" target="_blank"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">View</button></a>
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

                                    <?php if($arr_record['admin_type'] != 'Vendor' ) { ?> 
                             
                                    <button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>                   
                                                <?php } ?> 

                                                                        <a href="manage_event.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

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



    function addMoreRowCertificate(i_val)

    {

        

        var cert_cnt = parseInt($("#cert_cnt_"+i_val).val());

        

        cert_cnt = cert_cnt + 1;

        var new_row = ' <div id="row_cert_'+i_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

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

                                    '<a href="javascript:void(0);" onclick="removeRowCertificate('+i_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

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

        var new_row = ' <div id="row_judge_cert_'+j_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

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

                                    '<a href="javascript:void(0);" onclick="removeRowCertificateJudge('+j_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

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

        var new_row = ' <div id="row_org_cert_'+k_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

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

                                    '<a href="javascript:void(0);" onclick="removeRowCertificateOrg('+k_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

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

    

    function removeRowCertificate(i_val,cert_cnt)

    {

        $("#row_cert_"+i_val+"_"+cert_cnt).remove();



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

        

        

    function addMoreRowLocation()

    {

        

        var cat_cnt = parseInt($("#cat_cnt").val());

        cat_cnt = cat_cnt + 1;

        

        var i_val = cat_cnt;

                var j_val = cat_cnt;

                var k_val = cat_cnt;

        var cert_cnt = 0;

        var new_row =   '<div id="row_loc_'+cat_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

                            '<input type="hidden" name="cert_cnt_'+cat_cnt+'" id="cert_cnt_'+cat_cnt+'" value="'+cert_cnt+'">'+

                            '<input type="hidden" name="cert_total_cnt_'+cat_cnt+'" id="cert_total_cnt_'+cat_cnt+'" value="1">'+

                            '<input type="hidden" name="cert_loop_cnt[]" id="cert_loop_cnt_'+cat_cnt+'" value="'+cat_cnt+'">'+

                            '<input type="hidden" name="hdnvloc_doc_file[]" id="hdnvloc_doc_file_'+cat_cnt+'" value="">'+

                            '<input type="hidden" name="hdnvloc_menu_file[]" id="hdnvloc_menu_file_'+cat_cnt+'" value="">'+

                            '<input type="hidden" name="vloc_id[]" id="vloc_id_'+cat_cnt+'" value="0">'+

                                                        '<input type="hidden" name="hdn_default_cat_id" id="hdn_default_cat_id_'+cat_cnt+'" value="<?php echo $default_vloc_cat_id; ?>">'+

                            '<div class="form-group left-label">'+

                                '<label class="col-lg-3 control-label"><strong>Event Details:</strong></label>'+

                            '</div>'+

                                                        '<div class="form-group">'+

                                                                    '<label class="col-lg-2 control-label">Event Format<span style="color:red">*</span></label>'+

                                                                    '<div class="col-lg-4">'+

                                                                        '<select name="event_format[]" required="" id="event_format_'+cat_cnt+'" class="form-control" onchange="CheckTeamType('+cat_cnt+');">'+

                                                                            '<option value="">Select Event Format</option>'+

                                                                            '<?php echo $obj->getFavCategoryRamakant('74',''); ?>'+

                                                                        '</select>'+

                                                                    '</div>'+

                                                            '</div>'+

                            '<div class="form-group">'+

                                '<label class="col-lg-2 control-label">Location Category</label>'+

                                '<div class="col-lg-4">'+

                                    '<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" class="form-control"  onchange="getMainCategoryOptionAddMoreCommonLOCPlus(\'vloc\','+cat_cnt+');"  >'+

                                        '<?php //echo $obj->getMainProfileOption($arr_vloc_parent_cat_id[0]);?>'+

                                                                                '<?php echo $obj->getMainProfileOption($arr_vloc_parent_cat_id[$i],'1','0',$default_vloc_parent_cat_id);?>'+

                                    '</select>'+

                                '</div>'+

                                '<div class="col-lg-2"></div>'+

                                '<div class="col-lg-4">'+

                                    '<select name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" class="form-control">'+

                                        '<?php echo $obj->getMainCategoryOption($arr_vloc_parent_cat_id[0],''); ?>'+

                                    '</select>'+

                                '</div>'+

                            '</div>'+

                            '<div class="form-group">'+ 

                                '<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                                                        '<input type="text" required="" name="city_id[]" id="city_id_'+cat_cnt+'" placeholder="Select your city" list="capitals_'+cat_cnt+'" class="form-control" onchange="getlocation('+cat_cnt+')" />'+

                                    '<datalist id="capitals_'+cat_cnt+'">'+

                                                                        '<?php echo $obj->getCityOptions(); ?>'+

                                                                    '</datalist>'+

                                '</div>'+

                                '<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                    '<select name="area_id[]" id="area_id_'+cat_cnt+'" class="form-control" required>'+

                                        '<?php echo $obj->getAreaOption('','','',''); ?>'+

                                    '</select>'+

                                '</div>'+

                            '</div>'+

                                                        '<div class="form-group">'+

                                '<label class="col-lg-2 control-label">Venue <span style="color:red">*</span></label>'+

                                '<div class="col-lg-10">'+

                                                                    '<textarea name="venue[]" id="venue_'+cat_cnt+'" class="form-control" required></textarea>'+

                                '</div>'+

                            '</div>'+

                                                        

                                                        '<div class="form-group small-title">'+

                                    '<label class="col-lg-2 control-label">Start Date <span style="color:red">*</span></label>'+

                                    '<div class="col-lg-4">'+

                                        '<input type="text" required name="start_date[]" id="start_date_'+cat_cnt+'" style="width:200px; float:left;"  placeholder="Start Date" class="form-control clsdatepicker">'+

                                                                                '<select name="start_time[]" id="start_time_'+cat_cnt+'" class="form-control" style="width:120px;" required>'+

                                                                                   '<option value="">Select Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                                '</select>'+

                                                                        '</div>'+

                                    '<label class="col-lg-2 control-label">End Date<span style="color:red">*</span></label>'+

                                    '<div class="col-lg-4">'+

                                        '<input required type="text" name="end_date[]" id="end_date_'+cat_cnt+'" style="width:200px; float:left;  placeholder="End Date" class="form-control clsdatepicker">'+

                                                                                '<select required name="end_time[]" id="end_time_'+cat_cnt+'" class="form-control" style="width:100px;">'+

                                                                                   '<option value="">Select Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                                '</select>'+

                                                                        '</div>'+

                                '</div>'+

                                                        

                                                                '<div class="form-group">'+

                                                                    '<label class="col-lg-2 control-label">Time Zone<span style="color:red">*</span></label>'+

                                                                    '<div class="col-lg-10">'+

                                                                        '<select required name="time_zone[]" required="" id="time_zone_'+cat_cnt+'" class="form-control">'+

                                                                            '<option value="">Select Time Zone</option>'+

                                                                            '<?php echo $obj->getFavCategoryRamakant('59',''); ?>'+

                                                                        '</select>'+

                                                                    '</div>'+

                                                            '</div>'+

                                                            

                                                            '<div class="form-group">'+ 

                                '<label class="col-lg-2 control-label">Venue Image/Pdf <span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                    '<input required type="file" name="venue_image_file[]" id="venue_image_file_'+cat_cnt+'" class="form-control">'+

                                '</div>'+

                                

                                '<label class="col-lg-2 control-label">Event Image/Pdf</label>'+

                                '<div class="col-lg-4">'+

                                    '<input type="file" name="event_image_file[]" id="event_image_file_'+cat_cnt+'" class="form-control">'+

                                '</div>'+

                            '</div>'+

                                                        

                                                         '<div class="form-group">'+

                                '<label class="col-lg-2 control-label">No of Groups <span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                                                    '<input type="text" name="no_of_groups[]" required onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_groups_'+cat_cnt+'" class="form-control">'+

                                '</div>'+

                                                                '<label class="col-lg-2 control-label" id="no_of_teams_level_'+cat_cnt+'">No of Teams <span style="color:red">*</span></label>'+

                                '<div class="col-lg-4" id="no_of_teams_div_'+cat_cnt+'">'+

                                                                    '<input type="text" name="no_of_teams[]" required onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_teams_'+cat_cnt+'" class="form-control">'+

                                '</div>'+

                            '</div>'+

                                                       

                                                       '<div class="form-group">'+

                                '<label class="col-lg-2 control-label">No of participants per team <span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                                                    '<input type="text" required name="no_of_participants[]" onKeyPress="return isNumberKey(event);" maxlength="5" id="no_of_participants_'+cat_cnt+'" class="form-control">'+

                                '</div>'+

                                                                

                                                                '<label class="col-lg-2 control-label">No of judges <span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                                                    '<input type="text" required name="no_of_judges[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_judges_'+cat_cnt+'" class="form-control">'+

                                '</div>'+

                                                                

                            '</div>'+

                                                        

                                                        '<div class="form-group">'+ 

                                '<label class="col-lg-2 control-label">Rules and regulation Image/Pdf <span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                    '<input type="file" required name="vloc_menu_file[]" id="vloc_menu_file_'+cat_cnt+'" class="form-control">'+

                                '</div>'+

                                

                                '<label class="col-lg-2 control-label">Institution Profile Pdf</label>'+

                                '<div class="col-lg-4">'+

                                    '<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_'+cat_cnt+'" class="form-control">'+

                                '</div>'+

                            '</div>'+

                                                       

       //                                                  '<div class="form-group left-label">'+

                            //  '<label class="col-lg-3 control-label"><strong>Participants Criteria:</strong></label>'+

                            // '</div>'+

                                                        

       //                                                  '<div class="form-group">'+

                            //  '<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+

                            //  '<div class="col-lg-4">'+

                            //      '<select name="participants_title[]" id="participants_title_'+cat_cnt+'" class="form-control" required>'+                                                                            

       //                                                                          '<?php echo $obj->getPersonTitleOption('');?>'+

       //                                                                          '<option value="All">All</option>'+

                            //      '</select>'+

                            //  '</div>'+

                            //  '<label class="col-lg-2 control-label">Special Remarks<span style="color:red">*</span></label>'+

                            //  '<div class="col-lg-4">'+

       //                                                                  '<textarea required class="form-control" name="parti_remarks[]" id="parti_remarks_'+cat_cnt+'"></textarea>'+

       //                                                          '</div>'+

                            // '</div>'+

                                                       

       //                                                  '<div class="form-group">'+

                            //  '<label class="col-lg-2 control-label">From Age Group</label>'+

                            //  '<div class="col-lg-4">'+

                            //       '<input  type="text" name="from_age[]" id="from_age_'+cat_cnt+'"  placeholder="From age" class="form-control" >'+

                            //  '</div>'+

                                

                            //  '<label class="col-lg-2 control-label">To Age Group</label>'+

                            //  '<div class="col-lg-4">'+

       //                                                                 '<input  type="text" name="to_age[]" id="to_age_'+cat_cnt+'"  placeholder="To age" class="form-control" >'+

       //                                                          '</div>'+

                            // '</div>'+

                                                       

       //                                                 '<div class="form-group">'+

       //                                                 '<label class="col-lg-2 control-label">Height</label>'+

                            //  '<div class="col-lg-4">'+

                            //      '<select name="height[]" id="height_'+cat_cnt+'" class="form-control" >'+

       //                                                                      '<option value="">Select Height</option>'+

                            //          '<?php echo $obj->getHeightOptions(0);?>'+  

       //                                                                  '</select>'+

                            //  '</div>'+

       //                                                          '<label class="col-lg-2 control-label">Weight</label>'+

                            //  '<div class="col-lg-4">'+

       //                                                              '<select name="weight[]" id="weight_'+cat_cnt+'" class="form-control" >'+

       //                                                                      '<option value="">Select Weight</option>'+

                            //          '<?php

                            //          for($we=45;$we<=200;$we++)

                            //          { ?>'+

                            //              '<option value="<?php echo $we;?>" <?php if($weight == $we) { ?> selected="selected" <?php } ?>><?php echo $we;?> Kgs</option>'+

                            //          '<?php

                            //          } ?>'+  

       //                                                                  '</select>'+

                            //  '</div>'+

       //                                                 '</div>'+

                                                       

       //                                                 '<div class="form-group left-label">'+

                            //  '<label class="col-lg-6 control-label"><strong>Participants Registration, Certification & Memberships:(As applicable)</strong></label>'+

                            // '</div>'+

                                                       

                            // '<div id="row_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

                            //  '<input type="hidden" name="vc_cert_id_'+i_val+'[]" id="vc_cert_id_'+i_val+'_'+cert_cnt+'" value="0">'+

                            //  '<input type="hidden" name="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" id="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" value="">'+

                            //  '<div class="form-group small-title">'+

                            //      '<label class="col-lg-1 control-label">Type</label>'+

                            //      '<div class="col-lg-5">'+

                            //          '<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control" >'+

                            //              '<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

                            //          '</select>'+

                            //      '</div>'+

                                    

                            //      '<label class="col-lg-1 control-label">Name</label>'+

                            //      '<div class="col-lg-5">'+

                            //          '<input type="text" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

                            //      '</div>'+

                            //  '</div>'+   

                            //  '<div class="form-group small-title">'+

                            //      '<label class="col-lg-1 control-label">Number</label>'+

                            //      '<div class="col-lg-5">'+

                            //          '<input type="text" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

                            //      '</div>'+

                                    

                            //      '<label class="col-lg-1 control-label">Issued By</label>'+

                            //      '<div class="col-lg-5">'+

                            //          '<input type="text" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

                            //      '</div>'+

                            //  '</div>'+   

                            //  '<div class="form-group small-title">'+

                            //      '<label class="col-lg-1 control-label">Issued Date</label>'+

                            //      '<div class="col-lg-5">'+

                            //          '<input type="text" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

                            //      '</div>'+

                                    

                            //      '<label class="col-lg-1 control-label">Vaidity Date</label>'+

                            //      '<div class="col-lg-5">'+

                            //          '<input type="text" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

                            //      '</div>'+

                            //  '</div>'+

                            //  '<div class="form-group small-title">'+

                            //          '<label class="col-lg-1 control-label">Scan Image</label>'+

                            //          '<div class="col-lg-5">'+

                            //              '<input type="file" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'_'+cert_cnt+'" class="form-control" >'+

                            //          '</div>'+

                            //      '</div>'+

                            //  '<div class="form-group">'+

                            //      '<div class="col-lg-2">'+

                            //          '<a href="javascript:void(0);" onclick="addMoreRowCertificate('+i_val+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>'+

                            //      '</div>'+

                            //  '</div>'+

                            // '</div>'+

                            
                    ' <div id="row_profile_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

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

                  '<a href="javascript:void(0);" onclick="addMoreRowProfile('+j_val+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>'+

                '</div>'+

              '</div>'+

            '</div>'+

                                                        

                                                         '<div class="form-group left-label">'+

                                '<label class="col-lg-3 control-label"><strong>Judge Criteria:</strong></label>'+

                            '</div>'+

                                                        

                                                        '<div class="form-group">'+

                                '<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                    '<select name="judge_title[]" id="judge_title_'+cat_cnt+'" class="form-control" required>'+                                                                           

                                                                                '<?php echo $obj->getPersonTitleOption('');?>'+

                                                                                '<option value="All">All</option>'+

                                    '</select>'+

                                '</div>'+

                                '<label class="col-lg-2 control-label">Special Remarks<span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                    

                                                                        '<textarea class="form-control" name="judge_remarks[]" id="judge_remarks_'+cat_cnt+'" required></textarea>'+

                                                                '</div>'+

                                

                            '</div>'+

                                                        '<div class="form-group left-label">'+

                                '<label class="col-lg-6 control-label"><strong>Judge Registration, Certification & Memberships:(As applicable)</strong></label>'+

                            '</div>'+

                                                        

                                                        '<div id="row_judge_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

                                '<input type="hidden" name="judge_cert_id_'+j_val+'[]" id="judge_cert_id_'+j_val+'_'+cert_cnt+'" value="0">'+

                                '<input type="hidden" name="hdnjudge_cert_scan_file_'+j_val+'_'+cert_cnt+'" id="hdnjudge_cert_scan_file_'+j_val+'_'+cert_cnt+'" value="">'+

                                '<div class="form-group small-title">'+

                                    '<label class="col-lg-1 control-label">Type</label>'+

                                    '<div class="col-lg-5">'+

                                        '<select name="judge_cert_type_id_'+j_val+'[]" id="judge_cert_type_id_'+j_val+'_'+cert_cnt+'" class="form-control">'+

                                            '<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

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

                                        '<a href="javascript:void(0);" onclick="addMoreRowCertificateJudge('+j_val+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>'+

                                    '</div>'+

                                '</div>'+

                            '</div>'+

                                                        

                                                        '<div class="form-group left-label">'+

                                '<label class="col-lg-3 control-label"><strong>Organiser Social Media Details:</strong></label>'+

                            '</div>'+



                                                       '<div class="form-group">'+

                                '<label class="col-lg-2 control-label">Facebook</label>'+

                                '<div class="col-lg-4">'+

                                    '<input type="text" name="facebook_page_link[]" id="facebook_page_link_'+cat_cnt+'"  placeholder="Facebook Page Link" class="form-control" >'+

                                '</div>'+

                                

                                '<label class="col-lg-2 control-label">Twitter</label>'+

                                '<div class="col-lg-4">'+

                                    '<input type="text" name="twitter_page_link[]" id="twitter_page_link_'+cat_cnt+'" placeholder="Twitter Page Link" class="form-control" >'+

                                '</div>'+

                            '</div>'+

                                                        

                                                        '<div class="form-group">'+

                                '<label class="col-lg-2 control-label">Instagram</label>'+

                                '<div class="col-lg-4">'+

                                    '<input type="text" name="instagram_page_link[]" id="instagram_page_link_'+cat_cnt+'" placeholder="Instgram Page Link" class="form-control" >'+

                                '</div>'+

                                

                                '<label class="col-lg-2 control-label">Youtube</label>'+

                                '<div class="col-lg-4">'+

                                    '<input type="text" name="youtube_page_link[]" id="youtube_page_link_'+cat_cnt+'"  placeholder="Youtube Channel Link" class="form-control" >'+

                                '</div>'+

                            '</div>'+

                                                        

                                                        

                                                        '<div class="form-group left-label">'+

                                '<label class="col-lg-3 control-label"><strong>Organiser Contact Details:</strong></label>'+

                            '</div>'+

                                                        '<div class="form-group">'+

                                '<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                    '<select name="contact_person_title[]" id="contact_person_title_'+cat_cnt+'" class="form-control" required>'+

                                        '<?php echo $obj->getPersonTitleOption('');?>'+

                                    '</select>'+

                                '</div>'+

                                

                                '<label class="col-lg-2 control-label">Contact Person<span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                    '<input type="text" name="contact_person[]" id="contact_person_'+cat_cnt+'"  placeholder="Contact Person" class="form-control" required>'+

                                '</div>'+

                            '</div>'+

                            

                            '<div class="form-group">'+

                                '<label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                    '<input type="text" name="contact_email[]" id="contact_email_'+cat_cnt+'"  placeholder="Contact Email" class="form-control" required>'+

                                '</div>'+

                                

                                '<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                    '<input type="text" name="contact_number[]" id="contact_number_'+cat_cnt+'"  placeholder="Contact Number" class="form-control" required>'+

                                '</div>'+

                            '</div>'+

                        

                            '<div class="form-group">'+

                                '<label class="col-lg-2 control-label">Contact Designation<span style="color:red">*</span></label>'+

                                '<div class="col-lg-4">'+

                                    '<select required name="contact_designation[]" id="contact_designation_'+cat_cnt+'" class="form-control">'+

                                        '<option value="">Select</option>'+

                                                                                '<?php echo $obj->getFavCategoryRamakant('44',''); ?>'+

                                    '</select>'+

                                '</div>'+

                                

                                '<label class="col-lg-2 control-label">Remark</label>'+

                                '<div class="col-lg-4">'+

                                    '<input type="text" name="contact_remark[]" id="contact_remark_'+cat_cnt+'"  placeholder="Remark" class="form-control">'+

                                '</div>'+

                            '</div>'+

                                                        '<div class="form-group left-label">'+

                                '<label class="col-lg-6 control-label"><strong>Organisers Licences, Registration, Certification & Memberships:</strong></label>'+

                            '</div>'+

                                                        '<div id="row_org_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

                                '<input type="hidden" name="org_cert_id_'+k_val+'[]" id="org_cert_id_'+k_val+'_'+cert_cnt+'" value="0">'+

                                '<input type="hidden" name="hdnorg_cert_scan_file_'+k_val+'_'+cert_cnt+'" id="hdnjorg_cert_scan_file_'+k_val+'_'+cert_cnt+'" value="">'+

                                '<div class="form-group small-title">'+

                                    '<label class="col-lg-1 control-label">Type</label>'+

                                    '<div class="col-lg-5">'+

                                        '<select name="org_cert_type_id_'+k_val+'[]" id="org_cert_type_id_'+k_val+'_'+cert_cnt+'" class="form-control" >'+

                                            '<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

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

                                        '<a href="javascript:void(0);" onclick="addMoreRowCertificateOrg('+k_val+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>'+

                                    '</div>'+

                                '</div>'+

                            '</div>'+

                                                        

                            '<div class="form-group">'+

                                '<div class="col-lg-2">'+

                                    '<a href="javascript:void(0);" onclick="removeRowLocation('+cat_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

                                '</div>'+

                            '</div>'+

                        '</div>';   

        

        $("#row_loc_first").after(new_row);

        $("#cat_cnt").val(cat_cnt);

        

        var cat_total_cnt = parseInt($("#cat_total_cnt").val());

        cat_total_cnt = cat_total_cnt + 1;

        $("#cat_total_cnt").val(cat_total_cnt);

        

        $('.vloc_speciality_offered').tokenize2();

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

                  '<a href="javascript:void(0);" onclick="removeRowProfile('+j_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

                '</div>'+

              '</div>'+

            '</div>';
    
                //alert(new_row);

    $("#row_profile_"+j_val+"_first").after(new_row);

    $("#cert_cnt_"+j_val).val(cert_cnt);


    var cert_total_cnt = parseInt($("#cert_total_cnt_"+j_val).val());

    cert_total_cnt = cert_total_cnt + 1;

    $("#cert_total_cnt_"+j_val).val(cert_total_cnt);

  }

  function removeRowProfile(i_val,cert_cnt)

  {

    $("#row_profile_"+i_val+"_"+cert_cnt).remove();


    var cert_total_cnt = parseInt($("#cert_total_cnt_"+i_val).val());

    cert_total_cnt = cert_total_cnt + 1;

    $("#cert_total_cnt_"+i_val).val(cert_total_cnt);

    
  }

    function removeRowLocation(idval)

    {

        $("#row_loc_"+idval).remove();



        var cat_total_cnt = parseInt($("#cat_total_cnt").val());

        cat_total_cnt = cat_total_cnt - 1;

        $("#cat_total_cnt").val(cat_total_cnt);

        

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