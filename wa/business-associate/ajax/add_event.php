<?php

include_once('../../classes/config.php');

include_once('../../classes/vendor.php');

$obj = new Vendor();

if(!$obj->isVendorLoggedIn())

{

	exit(0);

}



$adm_vendor_id = $_SESSION['adm_vendor_id'];

$add_action_id = '21';



if(!$obj->chkIfAccessOfMenuAction($adm_vendor_id,$add_action_id))

{

	$tdata = array();

	$response = array('msg'=>'Sorry you dont have access.','status'=>0);

	$tdata[] = $response;

	echo json_encode($tdata);

	exit(0);

}



$obj->debuglog('[ADD_CUISINE] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>, FILES:<pre>'.print_r($_FILES,true).'</pre>');



$error = false;

$err_msg = '';



if(isset($_POST['btnSubmit']))

{

    

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


     if($obj->chkReferenceNumberExists($reference_number))

	{

		$error = true;

		$err_msg = 'Reference number already exists';

	

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

               

                die();

		echo json_encode($tdata);

		exit(0);

	}

        

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



	if($institution_id == '')

	{

		$error = true;

		$err_msg = 'Please enter Institution name';

	

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

   


	if(!$error)

	{

                

		$tdata = array();

               

		$tdata['admin_id'] = $_SESSION['adm_vendor_id'];

		$tdata['reference_number'] =$reference_number;

                

                $tdata['healcareandwellbeing'] =$healcareandwellbeing;

		$tdata['organiser_id'] =$adm_vendor_id;

		$tdata['institution_id'] =$institution_id;

		$tdata['sponsor_id'] =$sponsor_id;

		$tdata['event_name'] =$event_name;

                $tdata['event_contents'] =$event_contents;

		$tdata['profile_cat_1'] =$profile_cat_1;

                $tdata['profile_cat_2'] =$profile_cat_2;

                $tdata['profile_cat_3'] =$profile_cat_3;

                $tdata['profile_cat_4'] =$profile_cat_4;

                $tdata['profile_cat_5'] =$profile_cat_5;

                $tdata['event_tags'] =$event_tags;

                

                $tdata['fav_cat_1'] =$fav_cat_1;

                $tdata['fav_cat_2'] =$fav_cat_2;

                $tdata['fav_cat_3'] =$fav_cat_3;

                $tdata['fav_cat_4'] =$fav_cat_4;

                $tdata['fav_cat_5'] =$fav_cat_5;

                
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

                