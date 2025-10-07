<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$edit_action_id = '7';

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
	$cat_name = strip_tags(trim($_POST['cat_name']));
	$cat_id = $_POST['cat_id'];
	$cat_status = $_POST['cat_status'];
	
	if($cat_name == '')
	{
		$error = true;
		$err_msg = 'Please enter main profile';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	elseif($obj->chkCategoryExistsById($cat_name,$cat_id))
	{
		$error = true;
		$err_msg = 'This profile already exists';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if(!$error)
	{
		$tdata = array();
		$tdata['cat_name'] = $cat_name;
		$tdata['cat_id'] = $cat_id;
		$tdata['cat_status'] = $cat_status;
		$tdata['admin_id'] = $admin_id;
		$tdata['modify_date'] = date("Y-m-d H:i:s");
		
		if($obj->editCategory($tdata))
		{
			$msg = 'Record updated successfully!';
			$ref_url = "manage_profile_customization_category.php?msg=".urlencode($msg);
						
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