<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}
$admin_id = $_SESSION['admin_id'];
$add_action_id = '28';

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

if(isset($_POST['btnSubmit']))
{
	$country_id = $_POST['country_id'];
	$state_id = $_POST['state_id'];
	$city_name = strip_tags(trim($_POST['city_name']));
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
	
	elseif($obj->chkCityNameExists($city_name,$state_id,$country_id))
	{
		$error = true;
		$err_msg = 'This City Name is Already Exists';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($country_id == '')
	{
		$error = true;
		$err_msg = 'Please Select Country';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($state_id == '')
	{
		$error = true;
		$err_msg = 'Please Select State';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	
	
	
	if(!$error)
	{
		
		$tdata = array();
		$tdata['country_id'] = $country_id;
		$tdata['state_id'] = $state_id;
		$tdata['city_name'] = $city_name;
		$tdata['admin_id'] = $admin_id;
		
		if($obj->addCity($tdata))
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
  