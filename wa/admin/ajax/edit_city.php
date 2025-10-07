<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$edit_action_id = '29';

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

if(isset($_POST['btnSubmit']))
{
	$city_id = trim($_POST['city_id']);
	$state_id = trim($_POST['state_id']);
	$country_id = $_POST['country_id'];
	$city_name = strip_tags(trim($_POST['city_name']));
	$status = trim($_POST['city_status']);
	$admin_id = $_SESSION['admin_id'];
	
	
	
	if($city_name == '')
	{
		$error = true;
		$err_msg = 'Please Enter City Name';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($obj->chkCityNameExists_edit($city_name,$city_id,$country_id,$state_id))
	{
		$error = true;
		$err_msg = 'This City Name is Already Exists';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	
	
	if(!$error)
	{
		
		
		$tdata = array();
		$tdata['city_id'] = $city_id;
		$tdata['state_id'] = $state_id;
		$tdata['country_id'] = $country_id;
		$tdata['city_name'] = $city_name;
		$tdata['status'] = $status;
		$tdata['admin_id'] = $admin_id;
		
		if($obj->updateCity($tdata))
		{
			$msg = 'Record Added Successfully!';
			$ref_url = "manage_cities.php?msg=".urlencode($msg);
			//header("Location: manage_admins.php?msg=".urlencode($msg));
			//exit(0);
			
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
  