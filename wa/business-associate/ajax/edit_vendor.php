<?php

include_once('../../classes/config.php');

include_once('../../classes/admin.php');

include_once('../../classes/vendor.php');



$obj = new Admin();

$obj3 = new Vendor();





$admin_id ="";

$edit_action_id = '45';



//echo '<pre>';

//print_r($_POST);

//echo '</pre>';





// echo "<pre>";print_r($obj);echo "</pre>";





// if(!$obj->isAdminLoggedIn())

// {

// 	exit(0);

// }



// echo $obj3->isVendorLoggedIn();



if(!$obj3->isVendorLoggedIn())

{

	// header("Location: login.php");

	exit(0);

}

else

{

	$vendor_id = $_SESSION['adm_vendor_id'];

	// echo $obj3->chkIfAccessOfMenu3($vendor_id,$edit_action_id);

}



if(!$obj3->chkIfAccessOfMenu5($vendor_id,$edit_action_id))

{

	// header("Location: invalid.php");

	// exit(0);

	$tdata = array();

	$response = array('msg'=>'Sorry you dont have access.','status'=>0);

	$tdata[] = $response;

	echo json_encode($tdata);

	exit(0);

}



// echo "<pre>";print_r('hiii');echo "</pre>";

// exit;

// if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))

// {

// 	$tdata = array();

// 	$response = array('msg'=>'Sorry you dont have access.','status'=>0);

// 	$tdata[] = $response;

// 	echo json_encode($tdata);

// 	exit(0);

// }







$error = false;

$err_msg = '';

$obj->debuglog('[EDIT_VENDOR] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>, FILES:<pre>'.print_r($_FILES,true).'</pre>');



if(isset($_POST['btnSubmit']))

{

	$vendor_id = trim($_POST['hdnvendor_id']);

	$vendor_parent_cat_id = strip_tags(trim($_POST['vendor_parent_cat_id']));

	$vendor_cat_id = strip_tags(trim($_POST['vendor_cat_id']));

	$vendor_name = strip_tags(trim($_POST['vendor_name']));

	$vendor_username = strip_tags(trim($_POST['vendor_username']));

	$vendor_status = strip_tags(trim($_POST['vendor_status']));	

	$vendor_email = strip_tags(trim($_POST['vendor_email'])); // add by ample 25-07-20

	$food_products_offered=implode(',', $_POST['food_products_offered']); // add by ample 03-09-20

	
	

	if($vendor_name == '')

	{

		$error = true;

		$err_msg = 'Please enter company name';

	

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

	elseif($obj->chkVendorNameExists_edit($vendor_name,$vendor_id))

	{

		$error = true;

		$err_msg = 'Company name already exists';

	

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

	

	if($vendor_username == '')

	{

		$error = true;

		$err_msg = 'Please enter vendor username';

	

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

	elseif($obj->chkVendorUsernameExists_edit($vendor_username,$vendor_id))

	{

		$error = true;

		$err_msg = 'Vendor username already exists';

	

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

	

	

	if(!$error)

	{

	
		

		$tdata = array();

		$tdata['vendor_id'] = $vendor_id;

		$tdata['admin_id'] = $admin_id;

		$tdata['vendor_parent_cat_id'] = $vendor_parent_cat_id;

		$tdata['vendor_cat_id'] = $vendor_cat_id;

		$tdata['vendor_name'] = $vendor_name;

		$tdata['vendor_username'] = $vendor_username;

		$tdata['vendor_status'] = $vendor_status;

		//$tdata['vendor_email'] = $arr_contact_email[0]; //comment by ample

		$tdata['vendor_email'] = $vendor_email; // update by ample 25-07-20

		$tdata['food_products_offered'] = $food_products_offered; // update by ample 03-09-20

		$tdata['vendor_status'] = '1';

		
		if($obj3->updateVendor($tdata))

		{

			$msg = 'Record Updated Successfully!';

			$ref_url = "index.php?msg=".urlencode($msg);

						

			$tdata = array();

			$response = array('msg'=>'Success','status'=>1,'refurl'=> $ref_url);

			$tdata[] = $response;

			// echo "<pre>";print_r();echo "<pre>";

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