<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}
$admin_id = $_SESSION['admin_id'];
$edit_action_id = '73';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$error = false;
$err_msg = '';
$obj->debuglog('[EDIT_USER] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

if(isset($_POST['btnSubmit']))
{
	$user_id = trim($_POST['hdnuser_id']);
	$first_name = strip_tags(trim($_POST['first_name']));
	$last_name = strip_tags(trim($_POST['last_name']));
	$email = strip_tags(trim($_POST['email']));
	$mobile_no = strip_tags(trim($_POST['mobile_no']));
	$country_id = strip_tags(trim($_POST['country_id']));
	$state_id = strip_tags(trim($_POST['state_id']));
	$city_id = strip_tags(trim($_POST['city_id']));
	$area_id = strip_tags(trim($_POST['area_id']));
	$building_name = strip_tags(trim($_POST['building_name']));
	$floor_no = strip_tags(trim($_POST['floor_no']));
	$landmark = strip_tags(trim($_POST['landmark']));
	$address = strip_tags(trim($_POST['address']));
	$user_status = strip_tags(trim($_POST['user_status']));
	$user_blocked = strip_tags(trim($_POST['user_blocked']));
	
	if($first_name == '')
	{
		$error = true;
		$err_msg = 'Please enter first name';
	
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($email == '')
	{
		$error = true;
		$err_msg = 'Please enter email';
	
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
	{
		$error = true;
		$err_msg = 'Please enter valid email';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($obj->chkEmailExists_Edit($email,$user_id))
	{
		$error = true;
		$err_msg = 'This email already exists';
	
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($mobile_no == '')
	{
		$error = true;
		$err_msg = 'Please enter mobile no';
	
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($obj->chkMobileNoExists_Edit($mobile_no,$user_id))
	{
		$error = true;
		$err_msg = 'This mobile no already exists';
	
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	
	if($country_id == '')
	{
		$error = true;
		$err_msg = 'Please select country';
	
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($state_id == '')
	{
		$error = true;
		$err_msg = 'Please select state';
	
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($city_id == '')
	{
		$error = true;
		$err_msg = 'Please select city';
	
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if(!$error)
	{
		$tdata = array();
		$tdata['user_id'] = $user_id;
		$tdata['first_name'] = $first_name;
		$tdata['last_name'] = $last_name;
		$tdata['email'] = $email;
		$tdata['mobile_no'] = $mobile_no;
		$tdata['country_id'] = $country_id;
		$tdata['state_id'] = $state_id;
		$tdata['city_id'] = $city_id;
		$tdata['area_id'] = $area_id;
		$tdata['building_name'] = $building_name;
		$tdata['floor_no'] = $floor_no;
		$tdata['landmark'] = $landmark;
		$tdata['address'] = $address;
		$tdata['user_status'] = $user_status;
		$tdata['user_blocked'] = $user_blocked;
		$tdata['admin_id'] = $admin_id;
		
		if($obj->updateUser($tdata))
		{
			$msg = 'Record Updated Successfully!';
			$ref_url = "manage_users.php?msg=".urlencode($msg);
						
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