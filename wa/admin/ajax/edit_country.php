<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$error = false;
$err_msg = '';
$arr_selected_am_id = array();
$arr_selected_aa_id = array();

if(isset($_POST['btnSubmit']))
{
	$country_id = trim($_POST['country_id']);
	$country_name = strip_tags(trim($_POST['country_name']));
	$status = trim($_POST['country_status']);
	$admin_id = $_SESSION['admin_id'];
	
	
	
	if($country_name == '')
	{
		$error = true;
		$err_msg = 'Please Enter Country Name';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($obj->chkCountryNameExists_edit($country_name,$country_id))
	{
		$error = true;
		$err_msg = 'This Countery Name is Already Exists';
		
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
		$tdata['country_name'] = $country_name;
		$tdata['status'] = $status;
		$tdata['admin_id'] = $admin_id;
		if($obj->updateCountry($tdata))
		{
			$msg = 'Record Added Successfully!';
			$ref_url = "manage_country.php?msg=".urlencode($msg);
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
  