<?php

include_once('../../classes/config.php');

include_once('../../classes/admin.php');

$obj = new Admin();

if(!$obj->isAdminLoggedIn())

{

	exit(0);

}

$admin_id = $_SESSION['admin_id'];

$add_action_id = '21';



if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))

{

	$tdata = array();

	$response = array('msg'=>'Sorry you dont have access.','status'=>0);

	$tdata[] = $response;

	echo json_encode($tdata);

	exit(0);

}



$error = false;

$err_msg = '';

$obj->debuglog('[ADD_EVENT] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>, FILES:<pre>'.print_r($_FILES,true).'</pre>');



if(isset($_POST['btnSubmit']))

{

    

//    echo '<pre>';

//    print_r($_POST);

//    echo '</pre>';

//    

//    die();

    

    

	$reference_number = strip_tags(trim($_POST['reference_number']));

        $healcareandwellbeing = strip_tags(trim($_POST['healcareandwellbeing']));

	$organiser_id = strip_tags(trim($_POST['organiser_id']));

	$institution_id = strip_tags(trim($_POST['institution_id']));

	$sponsor_id = strip_tags(trim($_POST['sponsor_id']));

	$event_name = strip_tags(trim($_POST['event_name']));

        $event_contents = urldecode(trim($_POST['event_contents']));

        $profile_cat_1=strip_tags(trim($_POST['profile_cat_1']));

        $profile_cat_2=strip_tags(trim($_POST['profile_cat_2']));

        $profile_cat_3=strip_tags(trim($_POST['profile_cat_3']));

        $profile_cat_4=strip_tags(trim($_POST['profile_cat_4']));

        $profile_cat_5=strip_tags(trim($_POST['profile_cat_5']));

        

        $fav_cat_1 = implode(',', $_POST['fav_cat_1']);

        $fav_cat_2 = implode(',', $_POST['fav_cat_2']);

        $fav_cat_3 = implode(',', $_POST['fav_cat_3']);

        $fav_cat_4 = implode(',', $_POST['fav_cat_4']);

        $fav_cat_5 = implode(',', $_POST['fav_cat_5']);

        $event_tags = implode(',', $_POST['event_tags']);

        

	

	$arr_cert_loop_cnt = array();

	if(isset($_POST['cert_loop_cnt']))

	{

		foreach($_POST['cert_loop_cnt'] as $key => $val)

		{

			array_push($arr_cert_loop_cnt,$val);

		}		

	}

		

	$arr_vloc_parent_cat_id = array();

	if(isset($_POST['vloc_parent_cat_id']))

	{

		foreach($_POST['vloc_parent_cat_id'] as $key => $val)

		{

			array_push($arr_vloc_parent_cat_id,$val);

		}		

	}

	

	$arr_vloc_cat_id = array();

	if(isset($_POST['vloc_cat_id']))

	{

		foreach($_POST['vloc_cat_id'] as $key => $val)

		{

			array_push($arr_vloc_cat_id,$val);

		}		

	}

	

        

        $arr_country_id = array();

	if(isset($_POST['country_id']))

	{

		foreach($_POST['country_id'] as $key => $val)

		{

			array_push($arr_country_id,$val);

		}		

	}

	

	$arr_state_id = array();

	if(isset($_POST['state_id']))

	{

		foreach($_POST['state_id'] as $key => $val)

		{

			array_push($arr_state_id,$val);

		}		

	}

        

	

	$arr_city_id = array();

	if(isset($_POST['city_id']))

	{

		foreach($_POST['city_id'] as $key => $val)

		{

			array_push($arr_city_id,$val);

		}		

	}

	

	$arr_area_id = array();

	if(isset($_POST['area_id']))

	{

		foreach($_POST['area_id'] as $key => $val)

		{

			array_push($arr_area_id,$val);

		}		

	}

        

        $arr_venue = array();

	if(isset($_POST['venue']))

	{

		foreach($_POST['venue'] as $key => $val)

		{

			array_push($arr_venue,$val);

		}		

	}

        

        $arr_start_date = array();

	if(isset($_POST['start_date']))

	{

		foreach($_POST['start_date'] as $key => $val)

		{

			array_push($arr_start_date,$val);

		}		

	}

        

        $arr_start_time = array();

	if(isset($_POST['start_time']))

	{

		foreach($_POST['start_time'] as $key => $val)

		{

			array_push($arr_start_time,$val);

		}		

	}

        

        $arr_end_date = array();

	if(isset($_POST['end_date']))

	{

		foreach($_POST['end_date'] as $key => $val)

		{

			array_push($arr_end_date,$val);

		}		

	}

        

        $arr_end_time = array();

	if(isset($_POST['end_time']))

	{

		foreach($_POST['end_time'] as $key => $val)

		{

			array_push($arr_end_time,$val);

		}		

	}

        

        $arr_time_zone = array();

	if(isset($_POST['time_zone']))

	{

		foreach($_POST['time_zone'] as $key => $val)

		{

			array_push($arr_time_zone,$val);

		}		

	}

        

        $arr_event_format = array();

        if(isset($_POST['event_format']))

	{

		foreach($_POST['event_format'] as $key => $val)

		{

			array_push($arr_event_format,$val);

		}		

	}

        

        $arr_slot1_start_time = array();

        if(isset($_POST['slot1_start_time']))

	{

		foreach($_POST['slot1_start_time'] as $key => $val)

		{

			array_push($arr_slot1_start_time,$val);

		}		

	}

        

        $arr_slot1_end_time = array();

        if(isset($_POST['slot1_end_time']))

	{

		foreach($_POST['slot1_end_time'] as $key => $val)

		{

			array_push($arr_slot1_end_time,$val);

		}		

	}

        

        $arr_slot2_start_time = array();

        if(isset($_POST['slot2_start_time']))

	{

		foreach($_POST['slot2_start_time'] as $key => $val)

		{

			array_push($arr_slot2_start_time,$val);

		}		

	}

        

        $arr_slot2_end_time = array();

        if(isset($_POST['slot2_end_time']))

	{

		foreach($_POST['slot2_end_time'] as $key => $val)

		{

			array_push($arr_slot2_end_time,$val);

		}		

	}

        

        $arr_slot3_start_time = array();

        if(isset($_POST['slot3_start_time']))

	{

		foreach($_POST['slot3_start_time'] as $key => $val)

		{

			array_push($arr_slot3_start_time,$val);

		}		

	}

        

        $arr_slot3_end_time = array();

        if(isset($_POST['slot3_end_time']))

	{

		foreach($_POST['slot3_end_time'] as $key => $val)

		{

			array_push($arr_slot3_end_time,$val);

		}		

	}

        

        $arr_slot4_start_time = array();

        if(isset($_POST['slot4_start_time']))

	{

		foreach($_POST['slot4_start_time'] as $key => $val)

		{

			array_push($arr_slot4_start_time,$val);

		}		

	}

        

        $arr_slot4_end_time = array();

        if(isset($_POST['slot4_end_time']))

	{

		foreach($_POST['slot4_end_time'] as $key => $val)

		{

			array_push($arr_slot4_end_time,$val);

		}		

	}

        

        $arr_slot5_start_time = array();

        if(isset($_POST['slot5_start_time']))

	{

		foreach($_POST['slot5_start_time'] as $key => $val)

		{

			array_push($arr_slot5_start_time,$val);

		}		

	}

        

        $arr_slot5_end_time = array();

        if(isset($_POST['slot5_end_time']))

	{

		foreach($_POST['slot5_end_time'] as $key => $val)

		{

			array_push($arr_slot5_end_time,$val);

		}		

	}

        

        $arr_slot6_start_time = array();

        if(isset($_POST['slot6_start_time']))

	{

		foreach($_POST['slot6_start_time'] as $key => $val)

		{

			array_push($arr_slot6_start_time,$val);

		}		

	}

        

        $arr_slot6_end_time = array();

        if(isset($_POST['slot6_end_time']))

	{

		foreach($_POST['slot6_end_time'] as $key => $val)

		{

			array_push($arr_slot6_end_time,$val);

		}		

	}

        

        

        $arr_no_of_groups = array();

	if(isset($_POST['no_of_groups']))

	{

		foreach($_POST['no_of_groups'] as $key => $val)

		{

			array_push($arr_no_of_groups,$val);

		}		

	}

        

        $arr_no_of_teams = array();

	if(isset($_POST['no_of_teams']))

	{

		foreach($_POST['no_of_teams'] as $key => $val)

		{

			array_push($arr_no_of_teams,$val);

		}		

	}

        

        $arr_no_of_participants = array();

	if(isset($_POST['no_of_participants']))

	{

		foreach($_POST['no_of_participants'] as $key => $val)

		{

			array_push($arr_no_of_participants,$val);

		}		

	}

        

        $arr_no_of_judges = array();

	if(isset($_POST['no_of_judges']))

	{

		foreach($_POST['no_of_judges'] as $key => $val)

		{

			array_push($arr_no_of_judges,$val);

		}		

	}

        
// comment by ample 30-12-19
	// $arr_participants_title = array();

	// if(isset($_POST['participants_title']))

	// {

	// 	foreach($_POST['participants_title'] as $key => $val)

	// 	{

	// 		array_push($arr_participants_title,$val);

	// 	}		

	// }

        

 //        $arr_parti_remarks = array();

	// if(isset($_POST['parti_remarks']))

	// {

	// 	foreach($_POST['parti_remarks'] as $key => $val)

	// 	{

	// 		array_push($arr_parti_remarks,$val);

	// 	}		

	// }

        

 //        $arr_from_age = array();

	// if(isset($_POST['from_age']))

	// {

	// 	foreach($_POST['from_age'] as $key => $val)

	// 	{

	// 		array_push($arr_from_age,$val);

	// 	}		

	// }

        

 //        $arr_to_age = array();

	// if(isset($_POST['to_age']))

	// {

	// 	foreach($_POST['to_age'] as $key => $val)

	// 	{

	// 		array_push($arr_to_age,$val);

	// 	}		

	// }

        

 //        $arr_from_height = array();

	// if(isset($_POST['from_height']))

	// {

	// 	foreach($_POST['from_height'] as $key => $val)

	// 	{

	// 		array_push($arr_from_height,$val);

	// 	}		

	// }

        

 //        $arr_to_height = array();

	// if(isset($_POST['to_height']))

	// {

	// 	foreach($_POST['to_height'] as $key => $val)

	// 	{

	// 		array_push($arr_to_height,$val);

	// 	}		

	// }

        

 //        $arr_from_weight = array();

	// if(isset($_POST['from_weight']))

	// {

	// 	foreach($_POST['from_weight'] as $key => $val)

	// 	{

	// 		array_push($arr_from_weight,$val);

	// 	}		

	// }

        

 //        $arr_to_weight = array();

	// if(isset($_POST['to_weight']))

	// {

	// 	foreach($_POST['to_weight'] as $key => $val)

	// 	{

	// 		array_push($arr_to_weight,$val);

	// 	}		

	// }

	

        $arr_judge_title = array();

	if(isset($_POST['judge_title']))

	{

		foreach($_POST['judge_title'] as $key => $val)

		{

			array_push($arr_judge_title,$val);

		}		

	}

        

        $arr_judge_remarks = array();

	if(isset($_POST['judge_remarks']))

	{

		foreach($_POST['judge_remarks'] as $key => $val)

		{

			array_push($arr_judge_remarks,$val);

		}		

	}

        

        $arr_facebook_page_link = array();

	if(isset($_POST['facebook_page_link']))

	{

		foreach($_POST['facebook_page_link'] as $key => $val)

		{

			array_push($arr_facebook_page_link,$val);

		}		

	}

        

        $arr_twitter_page_link = array();

	if(isset($_POST['twitter_page_link']))

	{

		foreach($_POST['twitter_page_link'] as $key => $val)

		{

			array_push($arr_twitter_page_link,$val);

		}		

	}

        

        

        

	$arr_instagram_page_link = array();

	if(isset($_POST['instagram_page_link']))

	{

		foreach($_POST['instagram_page_link'] as $key => $val)

		{

			array_push($arr_instagram_page_link,$val);

		}		

	}

        

        $arr_youtube_page_link = array();

	if(isset($_POST['youtube_page_link']))

	{

		foreach($_POST['youtube_page_link'] as $key => $val)

		{

			array_push($arr_youtube_page_link,$val);

		}		

	}

	

        

        $arr_contact_person_title = array();

	if(isset($_POST['contact_person_title']))

	{

		foreach($_POST['contact_person_title'] as $key => $val)

		{

			array_push($arr_contact_person_title,$val);

		}		

	}

        

        

        $arr_contact_person = array();

	if(isset($_POST['contact_person']))

	{

		foreach($_POST['contact_person'] as $key => $val)

		{

			array_push($arr_contact_person,$val);

		}		

	}

        

       

	$arr_contact_email = array();

	if(isset($_POST['contact_email']))

	{

		foreach($_POST['contact_email'] as $key => $val)

		{

			array_push($arr_contact_email,$val);

		}		

	}

	

	$arr_contact_number = array();

	if(isset($_POST['contact_number']))

	{

		foreach($_POST['contact_number'] as $key => $val)

		{

			array_push($arr_contact_number,$val);

		}		

	}

	

	$arr_contact_designation = array();

	if(isset($_POST['contact_designation']))

	{

		foreach($_POST['contact_designation'] as $key => $val)

		{

			array_push($arr_contact_designation,$val);

		}		

	}

	

	$arr_contact_remark = array();

	if(isset($_POST['contact_remark']))

	{

		foreach($_POST['contact_remark'] as $key => $val)

		{

			array_push($arr_contact_remark,$val);

		}		

	}

        

	// add by ample 30-12-19
    $arr_profile_id = array();
	$arr_gender_type = array();
	$arr_special_remark = array();
	$arr_from_age = array();
	$arr_to_age = array();
	$arr_from_height = array();
	$arr_to_height= array();
	$arr_from_weight = array();
	$arr_to_weight = array();


    for($i=0;$i<count($arr_cert_loop_cnt);$i++)
	{

		$arr_profile_id[$i] = array();
		if(isset($_POST['participants_profile_'.$arr_cert_loop_cnt[$i]]))
		{

			foreach($_POST['participants_profile_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_profile_id[$i],$val);
			}		
		}
		$arr_gender_type[$i] = array();
		if(isset($_POST['participants_title_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['participants_title_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_gender_type[$i],$val);
			}		
		}
		$arr_special_remark[$i] = array();
		if(isset($_POST['parti_remarks_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['parti_remarks_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_special_remark[$i],$val);
			}		
		}
		$arr_from_age[$i] = array();
		if(isset($_POST['from_age_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['from_age_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_from_age[$i],$val);
			}		
		}
		$arr_to_age[$i] = array();
		if(isset($_POST['to_age_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['to_age_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_to_age[$i],$val);
			}		
		}
		$arr_from_height[$i] = array();
		if(isset($_POST['from_height_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['from_height_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_from_height[$i],$val);
			}		
		}
		$arr_to_height[$i] = array();
		if(isset($_POST['to_height_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['to_height_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_to_height[$i],$val);
			}		
		}
		$arr_from_weight[$i] = array();
		if(isset($_POST['from_weight_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['from_weight_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_from_weight[$i],$val);
			}		
		}
		$arr_to_weight[$i] = array();
		if(isset($_POST['to_weight_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['to_weight_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_to_weight[$i],$val);
			}		
		}

	}    
        

	$arr_vc_cert_type_id = array();

	$arr_vc_cert_name = array();

	$arr_vc_cert_no = array();

	$arr_vc_cert_issued_by = array();

	$arr_vc_cert_reg_date = array();

	$arr_vc_cert_validity_date = array();

	

	for($i=0;$i<count($arr_cert_loop_cnt);$i++)

	{

		

		$arr_vc_cert_type_id[$i] = array();

		if(isset($_POST['vc_cert_type_id_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['vc_cert_type_id_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_vc_cert_type_id[$i],$val);

			}		

		}

		

		$arr_vc_cert_name[$i] = array();

		if(isset($_POST['vc_cert_name_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['vc_cert_name_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_vc_cert_name[$i],$val);

			}		

		}

		

		$arr_vc_cert_no[$i] = array();

		if(isset($_POST['vc_cert_no_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['vc_cert_no_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_vc_cert_no[$i],$val);

			}		

		}

		

		$arr_vc_cert_issued_by[$i] = array();

		if(isset($_POST['vc_cert_issued_by_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['vc_cert_issued_by_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_vc_cert_issued_by[$i],$val);

			}		

		}

		

		$arr_vc_cert_reg_date[$i] = array();

		if(isset($_POST['vc_cert_reg_date_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['vc_cert_reg_date_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_vc_cert_reg_date[$i],$val);

			}		

		}

		

		$arr_vc_cert_validity_date[$i] = array();

		if(isset($_POST['vc_cert_validity_date_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['vc_cert_validity_date_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_vc_cert_validity_date[$i],$val);

			}		

		}

	}	

	

        

        

        $arr_judge_cert_type_id = array();

	$arr_judge_cert_name = array();

	$arr_judge_cert_no = array();

	$arr_judge_cert_issued_by = array();

	$arr_judge_cert_reg_date = array();

	$arr_judge_cert_validity_date = array();

        

        

        for($i=0;$i<count($arr_cert_loop_cnt);$i++)

	{

		

		$arr_judge_cert_type_id[$i] = array();

		if(isset($_POST['judge_cert_type_id_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['judge_cert_type_id_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_judge_cert_type_id[$i],$val);

			}		

		}

		

		$arr_judge_cert_name[$i] = array();

		if(isset($_POST['judge_cert_name_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['judge_cert_name_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_judge_cert_name[$i],$val);

			}		

		}

		

		$arr_judge_cert_no[$i] = array();

		if(isset($_POST['judge_cert_no_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['judge_cert_no_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_judge_cert_no[$i],$val);

			}		

		}

		

		$arr_judge_cert_issued_by[$i] = array();

		if(isset($_POST['judge_cert_issued_by_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['judge_cert_issued_by_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_judge_cert_issued_by[$i],$val);

			}		

		}

		

		$arr_judge_cert_reg_date[$i] = array();

		if(isset($_POST['judge_cert_reg_date_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['judge_cert_reg_date_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_judge_cert_reg_date[$i],$val);

			}		

		}

		

		$arr_judge_cert_validity_date[$i] = array();

		if(isset($_POST['judge_cert_validity_date_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['judge_cert_validity_date_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_judge_cert_validity_date[$i],$val);

			}		

		}

	}	

        

        

        $arr_org_cert_type_id = array();

	$arr_org_cert_name = array();

	$arr_org_cert_no = array();

	$arr_org_cert_issued_by = array();

	$arr_org_cert_reg_date = array();

	$arr_org_cert_validity_date = array();

        

        

        for($i=0;$i<count($arr_cert_loop_cnt);$i++)

	{

		

		$arr_org_cert_type_id[$i] = array();

		if(isset($_POST['org_cert_type_id_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['org_cert_type_id_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_org_cert_type_id[$i],$val);

			}		

		}

		

		$arr_org_cert_name[$i] = array();

		if(isset($_POST['org_cert_name_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['org_cert_name_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_org_cert_name[$i],$val);

			}		

		}

		

		$arr_org_cert_no[$i] = array();

		if(isset($_POST['org_cert_no_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['org_cert_no_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_org_cert_no[$i],$val);

			}		

		}

		

		$arr_org_cert_issued_by[$i] = array();

		if(isset($_POST['org_cert_issued_by_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['org_cert_issued_by_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_org_cert_issued_by[$i],$val);

			}		

		}

		

		$arr_org_cert_reg_date[$i] = array();

		if(isset($_POST['org_cert_reg_date_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['org_cert_reg_date_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_org_cert_reg_date[$i],$val);

			}		

		}

		

		$arr_org_cert_validity_date[$i] = array();

		if(isset($_POST['org_cert_validity_date_'.$arr_cert_loop_cnt[$i]]))

		{

			foreach($_POST['org_cert_validity_date_'.$arr_cert_loop_cnt[$i]] as $key => $val)

			{

				array_push($arr_org_cert_validity_date[$i],$val);

			}		

		}

	}	

	

//        if($obj->chkReferenceNumberExists($reference_number))

//	{

//		$error = true;

//		$err_msg = 'Reference number already exists';

//	

//		$tdata = array();

//		$response = array('msg'=>$err_msg,'status'=>0);

//		$tdata[] = $response;

//		echo json_encode($tdata);

//		exit(0);

//	}

        

	if($event_name == '')

	{

		$error = true;

		$err_msg = 'Please enter Event name';

	

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

        

        if($event_contents == '')

	{

		$error = true;

		$err_msg = 'Please enter Event contents';

	

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

       

	

	for($i=0,$j=1;$i<count($arr_vloc_parent_cat_id);$i++,$j++)

	{

		

		

		if($arr_city_id[$i] == '')

		{

			$error = true;

			$err_msg = 'Please select city for location row: '.$j;

		

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		

		if($arr_area_id[$i] == '')

		{

			$error = true;

			$err_msg = 'Please select area for location row: '.$j;

		

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		

		if($arr_contact_person_title[$i] == '')

		{

			$error = true;

			$err_msg = 'Please select gender for location row: '.$j;

		

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		

		if($arr_contact_person[$i] == '')

		{

			$error = true;

			$err_msg = 'Please select contact person for location row: '.$j;

		

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		

		if($i == 0)

		{

			if($arr_contact_email[$i] == '')

			{

				$error = true;

				$err_msg = 'Please enter email for location row: '.$j;

			

				$tdata = array();

				$response = array('msg'=>$err_msg,'status'=>0);

				$tdata[] = $response;

				echo json_encode($tdata);

				exit(0);

			}

			elseif(filter_var($arr_contact_email[$i], FILTER_VALIDATE_EMAIL) === false)

			{

				$error = true;

				$err_msg = 'Please enter valid email for location row: '.$j;

				

				$tdata = array();

				$response = array('msg'=>$err_msg,'status'=>0);

				$tdata[] = $response;

				echo json_encode($tdata);

				exit(0);

			}

			



			if($arr_contact_number[$i] == '')

			{

				$error = true;

				$err_msg = 'Please enter contact number for location row: '.$j;

			

				$tdata = array();

				$response = array('msg'=>$err_msg,'status'=>0);

				$tdata[] = $response;

				echo json_encode($tdata);

				exit(0);

			}	

		}

		

//		for($k=0,$l=1;$k<count($arr_vc_cert_type_id[$i]);$k++,$l++)

//		{

//			if($arr_vc_cert_type_id[$i][$k] == '')

//			{

//				$error = true;

//				$err_msg = 'Please select type for location row: '.$j.' , certificate row: '.$l;

//			

//				$tdata = array();

//				$response = array('msg'=>$err_msg,'status'=>0);

//				$tdata[] = $response;

//				echo json_encode($tdata);

//				exit(0);

//			}

//			

//			if($arr_vc_cert_reg_date[$i][$k] != '' && $arr_vc_cert_validity_date[$i][$k] != '')

//			{

//				if(strtotime($arr_vc_cert_reg_date[$i][$k]) > strtotime($arr_vc_cert_validity_date[$i][$k]))

//				{

//					$error = true;

//					$err_msg = 'Issued date must be lesser than validity date for location row: '.$j.' , certificate row: '.$l;

//				

//					$tdata = array();

//					$response = array('msg'=>$err_msg,'status'=>0);

//					$tdata[] = $response;

//					echo json_encode($tdata);

//					exit(0);

//				}

//			}

//		}

	}

	

	if(!$error)

	{

		$picture_size_limit = 5120;

		$error = false;

		$err_msg = '';



		// Define a destination

                

		$targetFolder = SITE_PATH . '/uploads'; // Relative to the root



		$arr_vloc_doc_file = array();

		$arr_vloc_menu_file = array();

                $arr_venue_image_file = array();

                $arr_event_image_file = array();

                

                

		for($i=0,$j=1;$i<count($arr_vloc_parent_cat_id);$i++,$j++)

		{

			if(isset($_FILES['vloc_doc_file']['name'][$i]) && $_FILES['vloc_doc_file']['name'][$i] != '')

			{

				$tempFile = $_FILES['vloc_doc_file']['tmp_name'][$i];



				$filename = date('dmYHis') . '_' . $_FILES['vloc_doc_file']['name'][$i];

				$filename = str_replace(' ', '-', $filename);



				$targetPath = $targetFolder;

				$targetFile = rtrim($targetPath, '/') . '/' . $filename;

				$mimetype = $_FILES['vloc_doc_file']['type'][$i];



				// Validate the file type

				$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF'); // File extensions

				$fileParts = pathinfo($_FILES['vloc_doc_file']['name'][$i]);



				if (in_array($fileParts['extension'], $fileTypes))

				{

					$vloc_doc_file = $_FILES['vloc_doc_file']['name'][$i];

					$size_in_kb = $_FILES['vloc_doc_file']['size'][$i] / 1024;

					$file4 = substr($vloc_doc_file, -4, 4);

					if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF'))

					{

						$error = true;

						$err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) file for upload doc on location row: '.$j;

					}

					elseif ($size_in_kb > $picture_size_limit)

					{

						$error = true;

						$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb for upload doc on location row: '.$j;

					}



					if (!$error)

					{

						$vloc_doc_file = $filename;



						if (!move_uploaded_file($tempFile, $targetFile))

						{

							if (file_exists($targetFile))

							{

								unlink($targetFile);

							} // Remove temp file

							$error = true;

							$err_msg = 'Couldn\'t upload file for upload doc on location row: '.$j;

						}

					}

				}

				else

				{

					$error = true;

					$err_msg = 'Invalid file type for upload doc on location row: '.$j;

				}



				if($error)

				{

					$tdata = array();

					$response = array('msg'=>$err_msg,'status'=>0);

					$tdata[] = $response;

					echo json_encode($tdata);

					exit(0);

				}

				else

				{

					$arr_vloc_doc_file[$i] = $filename;

				}						

			}

			else

			{

				$arr_vloc_doc_file[$i] = '';	

			}

			

			if(isset($_FILES['vloc_menu_file']['name'][$i]) && $_FILES['vloc_menu_file']['name'][$i] != '')

			{

				$tempFile = $_FILES['vloc_menu_file']['tmp_name'][$i];



				$filename = date('dmYHis') . '_' . $_FILES['vloc_menu_file']['name'][$i];

				$filename = str_replace(' ', '-', $filename);



				$targetPath = $targetFolder;

				$targetFile = rtrim($targetPath, '/') . '/' . $filename;

				$mimetype = $_FILES['vloc_menu_file']['type'][$i];



				// Validate the file type

				$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF'); // File extensions

				$fileParts = pathinfo($_FILES['vloc_menu_file']['name'][$i]);



				if (in_array($fileParts['extension'], $fileTypes))

				{

					$vloc_menu_file = $_FILES['vloc_menu_file']['name'][$i];

					$size_in_kb = $_FILES['vloc_menu_file']['size'][$i] / 1024;

					$file4 = substr($vloc_menu_file, -4, 4);

					if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF'))

					{

						$error = true;

						$err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) file for upload menu on location row: '.$j;

					}

					elseif ($size_in_kb > $picture_size_limit)

					{

						$error = true;

						$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb for upload menu on location row: '.$j;

					}



					if (!$error)

					{

						$vloc_menu_file = $filename;



						if (!move_uploaded_file($tempFile, $targetFile))

						{

							if (file_exists($targetFile))

							{

								unlink($targetFile);

							} // Remove temp file

							$error = true;

							$err_msg = 'Couldn\'t upload file for upload menu on location row: '.$j;

						}

					}

				}

				else

				{

					$error = true;

					$err_msg = 'Invalid file type for upload menu on location row: '.$j;

				}



				if($error)

				{

					$tdata = array();

					$response = array('msg'=>$err_msg,'status'=>0);

					$tdata[] = $response;

					echo json_encode($tdata);

					exit(0);

				}

				else

				{

					$arr_vloc_menu_file[$i] = $filename;

				}						

			}

			else

			{

				$arr_vloc_menu_file[$i] = '';	

			}

                        

                        if(isset($_FILES['venue_image_file']['name'][$i]) && $_FILES['venue_image_file']['name'][$i] != '')

			{

				$tempFile = $_FILES['venue_image_file']['tmp_name'][$i];



				$filename = date('dmYHis') . '_' . $_FILES['venue_image_file']['name'][$i];

				$filename = str_replace(' ', '-', $filename);



				$targetPath = $targetFolder;

				$targetFile = rtrim($targetPath, '/') . '/' . $filename;

				$mimetype = $_FILES['venue_image_file']['type'][$i];



				// Validate the file type

				$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF'); // File extensions

				$fileParts = pathinfo($_FILES['venue_image_file']['name'][$i]);



				if (in_array($fileParts['extension'], $fileTypes))

				{

					$vloc_menu_file = $_FILES['venue_image_file']['name'][$i];

					$size_in_kb = $_FILES['venue_image_file']['size'][$i] / 1024;

					$file4 = substr($vloc_menu_file, -4, 4);

					if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF'))

					{

						$error = true;

						$err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) file for upload menu on location row: '.$j;

					}

					elseif ($size_in_kb > $picture_size_limit)

					{

						$error = true;

						$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb for upload menu on location row: '.$j;

					}



					if (!$error)

					{

						$vloc_menu_file = $filename;



						if (!move_uploaded_file($tempFile, $targetFile))

						{

							if (file_exists($targetFile))

							{

								unlink($targetFile);

							} // Remove temp file

							$error = true;

							$err_msg = 'Couldn\'t upload file for upload menu on location row: '.$j;

						}

					}

				}

				else

				{

					$error = true;

					$err_msg = 'Invalid file type for upload menu on location row: '.$j;

				}



				if($error)

				{

					$tdata = array();

					$response = array('msg'=>$err_msg,'status'=>0);

					$tdata[] = $response;

					echo json_encode($tdata);

					exit(0);

				}

				else

				{

					$arr_venue_image_file[$i] = $filename;

				}						

			}

			else

			{

				$arr_venue_image_file[$i] = '';	

			}

                        

                        if(isset($_FILES['event_image_file']['name'][$i]) && $_FILES['event_image_file']['name'][$i] != '')

			{

				$tempFile = $_FILES['event_image_file']['tmp_name'][$i];



				$filename = date('dmYHis') . '_' . $_FILES['event_image_file']['name'][$i];

				$filename = str_replace(' ', '-', $filename);



				$targetPath = $targetFolder;

				$targetFile = rtrim($targetPath, '/') . '/' . $filename;

				$mimetype = $_FILES['event_image_file']['type'][$i];



				// Validate the file type

				$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF'); // File extensions

				$fileParts = pathinfo($_FILES['event_image_file']['name'][$i]);



				if (in_array($fileParts['extension'], $fileTypes))

				{

					$vloc_menu_file = $_FILES['event_image_file']['name'][$i];

					$size_in_kb = $_FILES['event_image_file']['size'][$i] / 1024;

					$file4 = substr($vloc_menu_file, -4, 4);

					if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF'))

					{

						$error = true;

						$err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) file for upload menu on location row: '.$j;

					}

					elseif ($size_in_kb > $picture_size_limit)

					{

						$error = true;

						$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb for upload menu on location row: '.$j;

					}



					if (!$error)

					{

						$vloc_menu_file = $filename;



						if (!move_uploaded_file($tempFile, $targetFile))

						{

							if (file_exists($targetFile))

							{

								unlink($targetFile);

							} // Remove temp file

							$error = true;

							$err_msg = 'Couldn\'t upload file for upload menu on location row: '.$j;

						}

					}

				}

				else

				{

					$error = true;

					$err_msg = 'Invalid file type for upload menu on location row: '.$j;

				}



				if($error)

				{

					$tdata = array();

					$response = array('msg'=>$err_msg,'status'=>0);

					$tdata[] = $response;

					echo json_encode($tdata);

					exit(0);

				}

				else

				{

					$arr_event_image_file[$i] = $filename;

				}						

			}

			else

			{

				$arr_event_image_file[$i] = '';	

			}

                        

		}

	}

	

	if(!$error)

	{

		$picture_size_limit = 5120;

		$error = false;

		$err_msg = '';



		// Define a destination

		$targetFolder = SITE_PATH . '/uploads'; // Relative to the root



		$arr_vc_cert_scan_file = array();

		for($i=0;$i<count($arr_cert_loop_cnt);$i++)

		{

			$arr_vc_cert_scan_file[$i] = array();

			for($k=0,$l=1;$k<count($arr_vc_cert_type_id[$i]);$k++,$l++)

			{

				if(isset($_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['name'][$k]) && $_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['name'][$k] != '')

				{

					$tempFile = $_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['tmp_name'][$k];



					$filename = date('dmYHis') . '_' . $_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['name'][$k];

					$filename = str_replace(' ', '-', $filename);



					$targetPath = $targetFolder;

					$targetFile = rtrim($targetPath, '/') . '/' . $filename;

					$mimetype = $_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['type'][$k];



					// Validate the file type

					$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF'); // File extensions

					$fileParts = pathinfo($_FILES['vc_cert_scan_file_'.$i]['name'][$k]);



					if (in_array($fileParts['extension'], $fileTypes))

					{

						$vc_cert_scan_file = $_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['name'][$k];

						$size_in_kb = $_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['size'][$k] / 1024;

						$file4 = substr($vc_cert_scan_file, -4, 4);

						if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF'))

						{

							$error = true;

							$err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) file for scan file on location row: '.$j.' , certificate row: '.$l;

						}

						elseif ($size_in_kb > $picture_size_limit)

						{

							$error = true;

							$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb for scan file on location row: '.$j.' , certificate row: '.$l;

						}



						if (!$error)

						{

							$vc_cert_scan_file = $filename;



							if (!move_uploaded_file($tempFile, $targetFile))

							{

								if (file_exists($targetFile))

								{

									unlink($targetFile);

								} // Remove temp file

								$error = true;

								$err_msg = 'Couldn\'t upload file for scan file on location row: '.$j.' , certificate row: '.$l;

							}

						}

					}

					else

					{

						$error = true;

						$err_msg = 'Invalid file type for scan file on location row: '.$j.' , certificate row: '.$l;

					}



					if($error)

					{

						$tdata = array();

						$response = array('msg'=>$err_msg,'status'=>0);

						$tdata[] = $response;

						echo json_encode($tdata);

						exit(0);

					}

					else

					{

						$arr_vc_cert_scan_file[$i][$k] = $filename;

					}						

				}

				else

				{

					$arr_vc_cert_scan_file[$i][$k] = '';	

				}

			}		

		}	


		//add by ample 30-12-19
		$arr_judge_cert_scan_file = array();

		for($i=0;$i<count($arr_cert_loop_cnt);$i++)

		{

			$arr_judge_cert_scan_file[$i] = array();

			for($k=0,$l=1;$k<count($arr_judge_cert_type_id[$i]);$k++,$l++)

			{

				if(isset($_FILES['judge_cert_scan_file'.$arr_cert_loop_cnt[$i]]['name'][$k]) && $_FILES['judge_cert_scan_file'.$arr_cert_loop_cnt[$i]]['name'][$k] != '')

				{

					$tempFile = $_FILES['judge_cert_scan_file'.$arr_cert_loop_cnt[$i]]['tmp_name'][$k];



					$filename = date('dmYHis') . '_' . $_FILES['judge_cert_scan_file'.$arr_cert_loop_cnt[$i]]['name'][$k];

					$filename = str_replace(' ', '-', $filename);



					$targetPath = $targetFolder;

					$targetFile = rtrim($targetPath, '/') . '/' . $filename;

					$mimetype = $_FILES['judge_cert_scan_file'.$arr_cert_loop_cnt[$i]]['type'][$k];



					// Validate the file type

					$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF'); // File extensions

					$fileParts = pathinfo($_FILES['judge_cert_scan_file'.$i]['name'][$k]);



					if (in_array($fileParts['extension'], $fileTypes))

					{

						$judge_cert_scan_file = $_FILES['judge_cert_scan_file'.$arr_cert_loop_cnt[$i]]['name'][$k];

						$size_in_kb = $_FILES['judge_cert_scan_file'.$arr_cert_loop_cnt[$i]]['size'][$k] / 1024;

						$file4 = substr($judge_cert_scan_file, -4, 4);

						if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF'))

						{

							$error = true;

							$err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) file for scan file on location row: '.$j.' , certificate row: '.$l;

						}

						elseif ($size_in_kb > $picture_size_limit)

						{

							$error = true;

							$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb for scan file on location row: '.$j.' , certificate row: '.$l;

						}



						if (!$error)

						{

							$judge_cert_scan_file = $filename;



							if (!move_uploaded_file($tempFile, $targetFile))

							{

								if (file_exists($targetFile))

								{

									unlink($targetFile);

								} // Remove temp file

								$error = true;

								$err_msg = 'Couldn\'t upload file for scan file on location row: '.$j.' , certificate row: '.$l;

							}

						}

					}

					else

					{

						$error = true;

						$err_msg = 'Invalid file type for scan file on location row: '.$j.' , certificate row: '.$l;

					}



					if($error)

					{

						$tdata = array();

						$response = array('msg'=>$err_msg,'status'=>0);

						$tdata[] = $response;

						echo json_encode($tdata);

						exit(0);

					}

					else

					{

						$arr_judge_cert_scan_file[$i][$k] = $filename;

					}						

				}

				else

				{

					$arr_judge_cert_scan_file[$i][$k] = '';	

				}

			}		

		}



                

                $arr_org_cert_scan_file = array();

		for($i=0;$i<count($arr_cert_loop_cnt);$i++)

		{

			$arr_org_cert_scan_file[$i] = array();

			for($k=0,$l=1;$k<count($arr_org_cert_type_id[$i]);$k++,$l++)

			{

				if(isset($_FILES['org_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['name'][$k]) && $_FILES['org_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['name'][$k] != '')

				{

					$tempFile = $_FILES['org_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['tmp_name'][$k];



					$filename = date('dmYHis') . '_' . $_FILES['org_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['name'][$k];

					$filename = str_replace(' ', '-', $filename);



					$targetPath = $targetFolder;

					$targetFile = rtrim($targetPath, '/') . '/' . $filename;

					$mimetype = $_FILES['org_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['type'][$k];



					// Validate the file type

					$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF'); // File extensions

					$fileParts = pathinfo($_FILES['org_cert_scan_file_'.$i]['name'][$k]);



					if (in_array($fileParts['extension'], $fileTypes))

					{

						$org_cert_scan_file = $_FILES['org_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['name'][$k];

						$size_in_kb = $_FILES['org_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['size'][$k] / 1024;

						$file4 = substr($org_cert_scan_file, -4, 4);

						if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF'))

						{

							$error = true;

							$err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) file for scan file on location row: '.$j.' , certificate row: '.$l;

						}

						elseif ($size_in_kb > $picture_size_limit)

						{

							$error = true;

							$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb for scan file on location row: '.$j.' , certificate row: '.$l;

						}



						if (!$error)

						{

							$org_cert_scan_file = $filename;



							if (!move_uploaded_file($tempFile, $targetFile))

							{

								if (file_exists($targetFile))

								{

									unlink($targetFile);

								} // Remove temp file

								$error = true;

								$err_msg = 'Couldn\'t upload file for scan file on location row: '.$j.' , certificate row: '.$l;

							}

						}

					}

					else

					{

						$error = true;

						$err_msg = 'Invalid file type for scan file on location row: '.$j.' , certificate row: '.$l;

					}



					if($error)

					{

						$tdata = array();

						$response = array('msg'=>$err_msg,'status'=>0);

						$tdata[] = $response;

						echo json_encode($tdata);

						exit(0);

					}

					else

					{

						$arr_org_cert_scan_file[$i][$k] = $filename;

					}						

				}

				else

				{

					$arr_org_cert_scan_file[$i][$k] = '';	

				}

			}		

		}

                

	}

	

	

	if(!$error)

	{

		for($i=0,$j=1;$i<count($arr_vloc_parent_cat_id);$i++,$j++)

		{

			for($k=0,$l=1;$k<count($arr_vc_cert_reg_date[$i]);$k++,$l++)

			{

				if($arr_vc_cert_reg_date[$i][$k] != '')

				{

					$arr_vc_cert_reg_date[$i][$k] = date('Y-m-d',strtotime($arr_vc_cert_reg_date[$i][$k]));

				}

				

				if($arr_vc_cert_validity_date[$i][$k] != '')

				{

					$arr_vc_cert_validity_date[$i][$k] = date('Y-m-d',strtotime($arr_vc_cert_validity_date[$i][$k]));

				}

			}	



			$arr_vloc_speciality_offered[$i] = implode(',',$arr_vloc_speciality_offered[$i]);

		}

		

		$tdata = array();

		$tdata['admin_id'] = $admin_id;

		//$tdata['reference_number'] = $reference_number;

                $tdata['healcareandwellbeing'] = $healcareandwellbeing;

		$tdata['organiser_id'] = $organiser_id;

		$tdata['institution_id'] = $institution_id;

		$tdata['sponsor_id'] = $sponsor_id;

		$tdata['event_name'] = $event_name;

                $tdata['event_contents'] = $event_contents;

		$tdata['profile_cat_1'] = $profile_cat_1;

                $tdata['profile_cat_2'] = $profile_cat_2;

                $tdata['profile_cat_3'] = $profile_cat_3;

                $tdata['profile_cat_4'] = $profile_cat_4;

                $tdata['profile_cat_5'] = $profile_cat_5;

                $tdata['event_tags'] = $event_tags;

                

                $tdata['fav_cat_1'] = $fav_cat_1;

                $tdata['fav_cat_2'] = $fav_cat_2;

                $tdata['fav_cat_3'] = $fav_cat_3;

                $tdata['fav_cat_4'] = $fav_cat_4;

                $tdata['fav_cat_5'] = $fav_cat_5;

                

		$tdata['contact_person'] = $arr_contact_person;

		$tdata['contact_person_title'] = $arr_contact_person_title;

		$tdata['contact_email'] = $arr_contact_email;

		$tdata['contact_number'] = $arr_contact_number;

		$tdata['contact_designation'] = $arr_contact_designation;

		$tdata['contact_remark'] = $arr_contact_remark;

                $tdata['country_id'] = $arr_country_id;

		$tdata['state_id'] = $arr_state_id;

		$tdata['city_id'] = $arr_city_id;

		$tdata['area_id'] = $arr_area_id;

                $tdata['venue'] = $arr_venue;

                $tdata['start_date'] = $arr_start_date;

                $tdata['start_time'] = $arr_start_time;

                $tdata['end_date'] = $arr_end_date;

                $tdata['end_time'] = $arr_end_time;

                

                $tdata['time_zone'] = $arr_time_zone;

                $tdata['no_of_groups'] = $arr_no_of_groups;

                $tdata['no_of_teams'] = $arr_no_of_teams;

                $tdata['no_of_participants'] = $arr_no_of_participants;

                $tdata['no_of_judges'] = $arr_no_of_judges;

                

                

                // $tdata['participants_title'] = $arr_participants_title;

                // $tdata['parti_remarks'] = $arr_parti_remarks;

                // $tdata['from_age'] = $arr_from_age;

                // $tdata['to_age'] = $arr_to_age;

                // $tdata['from_height'] = $arr_from_height;

                // $tdata['from_weight'] = $arr_from_weight;

                // $tdata['to_height'] = $arr_from_height;

                // $tdata['to_weight'] = $arr_to_weight;


                  // add by ample 24-12-19
                $tdata['pp_type_id'] = $arr_profile_id;
				$tdata['pp_gender'] = $arr_gender_type;
				$tdata['pp_remark'] = $arr_special_remark;
				$tdata['pp_from_age'] = $arr_from_age;
				$tdata['pp_to_age'] = $arr_to_age;
				$tdata['pp_from_height'] = $arr_from_height;
				$tdata['pp_to_height'] = $arr_to_height;
				$tdata['pp_from_weight'] = $arr_from_weight;
				$tdata['pp_to_weight'] = $arr_to_weight;

                $tdata['judge_title'] = $arr_judge_title;

                $tdata['judge_remarks'] = $arr_judge_remarks;

                $tdata['facebook_page_link'] = $arr_facebook_page_link;

                $tdata['twitter_page_link'] = $arr_twitter_page_link;

                $tdata['instagram_page_link'] = $arr_instagram_page_link;

                $tdata['youtube_page_link'] = $arr_youtube_page_link;

                

		$tdata['vloc_parent_cat_id'] = $arr_vloc_parent_cat_id;

		$tdata['vloc_cat_id'] = $arr_vloc_cat_id;

		$tdata['vloc_doc_file'] = $arr_vloc_doc_file;

		$tdata['vloc_menu_file'] = $arr_vloc_menu_file;

                

		$tdata['vc_cert_type_id'] = $arr_vc_cert_type_id;

		$tdata['vc_cert_name'] = $arr_vc_cert_name;

		$tdata['vc_cert_no'] = $arr_vc_cert_no;

		$tdata['vc_cert_issued_by'] = $arr_vc_cert_issued_by;

		$tdata['vc_cert_reg_date'] = $arr_vc_cert_reg_date;

		$tdata['vc_cert_validity_date'] = $arr_vc_cert_validity_date;

		$tdata['vc_cert_scan_file'] = $arr_vc_cert_scan_file;

                

                $tdata['org_cert_type_id'] = $arr_org_cert_type_id;

		$tdata['org_cert_name'] = $arr_org_cert_name;

		$tdata['org_cert_no'] = $arr_org_cert_no;

		$tdata['org_cert_issued_by'] = $arr_org_cert_issued_by;

		$tdata['org_cert_reg_date'] = $arr_org_cert_reg_date;

		$tdata['org_cert_validity_date'] = $arr_org_cert_validity_date;

		$tdata['org_cert_scan_file'] = $arr_org_cert_scan_file;

                

                $tdata['judge_cert_type_id'] = $arr_judge_cert_type_id;

		$tdata['judge_cert_name'] = $arr_judge_cert_name;

		$tdata['judge_cert_no'] = $arr_judge_cert_no;

		$tdata['judge_cert_issued_by'] = $arr_judge_cert_issued_by;

		$tdata['judge_cert_reg_date'] = $arr_judge_cert_reg_date;

		$tdata['judge_cert_validity_date'] = $arr_judge_cert_validity_date;

		$tdata['judge_cert_scan_file'] = $arr_judge_cert_scan_file;

                

                $tdata['venue_image_file']=$arr_venue_image_file;

                $tdata['event_image_file']=$arr_event_image_file;

                

                $tdata['event_format']=$arr_event_format;

                $tdata['slot1_start_time']=$arr_slot1_start_time;

                $tdata['slot1_end_time']=$arr_slot1_end_time;

                $tdata['slot2_start_time']=$arr_slot2_start_time;

                $tdata['slot2_end_time']=$arr_slot2_end_time;

                $tdata['slot3_start_time']=$arr_slot3_start_time;

                $tdata['slot3_end_time']=$arr_slot3_end_time;

                $tdata['slot4_start_time']=$arr_slot4_start_time;

                $tdata['slot4_end_time']=$arr_slot4_end_time;

                $tdata['slot5_start_time']=$arr_slot5_start_time;

                $tdata['slot5_end_time']=$arr_slot5_end_time;

                $tdata['slot6_start_time']=$arr_slot6_start_time;

                $tdata['slot6_end_time']=$arr_slot6_end_time;

                

                

//                echo '<pre>';

//                print_r($tdata);

//                echo '</pre>';

//		die();

		if($obj->addEvent($tdata))

		{

			$msg = 'Record Added Successfully!';

			$ref_url = "manage_event.php?msg=".urlencode($msg);

						

			$tdata = array();

			$response = array('msg'=>'Success','status'=>1,'refurl'=> $ref_url);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		else

		{

			$error = true;

			$err_msg = "Currently there is some problem.Please try again later.";

			

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

	}

}