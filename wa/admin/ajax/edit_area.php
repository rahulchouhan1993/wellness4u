<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$edit_action_id = '33';

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
	$area_id = trim($_POST['area_id']);
	$country_id = $_POST['country_id'];
	$state_id = $_POST['state_id'];
	$city_id = $_POST['city_id'];
	$area_name = strip_tags(trim($_POST['area_name']));
	$area_pincode = $_POST['area_pincode'];
	$status = trim($_POST['area_status']);
	$admin_id = $_SESSION['admin_id'];
	
	
	
	if($area_name == '')
	{
		$error = true;
		$err_msg = 'Please Enter Area Name';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($obj->chkAreaNameExists_edit($area_name,$area_id,$country_id,$state_id,$city_id))
	{
		$error = true;
		$err_msg = 'This Area Name is Already Exists';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	
	
	if(!$error)
	{
		
		
		$tdata = array();
		$tdata['area_id'] = $area_id;
		$tdata['country_id'] = $country_id;
		$tdata['state_id'] = $state_id;
		$tdata['city_id'] = $city_id;
		$tdata['area_name'] = $area_name;
		$tdata['area_pincode'] = $area_pincode;
		$tdata['status'] = $status;
		$tdata['admin_id'] = $admin_id;
		
		 
		if($obj->updateArea($tdata))
		{
			$msg = 'Record Added Successfully!';
			$ref_url = "manage_area.php?msg=".urlencode($msg);
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
  