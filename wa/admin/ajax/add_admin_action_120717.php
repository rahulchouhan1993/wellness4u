<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$add_action_id = '14';

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

if(isset($_POST['btn_submit']))
{
	$am_id = strip_tags(trim($_POST['am_id']));
	$aa_title = strip_tags(trim($_POST['aa_title']));
	$aa_link = strip_tags(trim($_POST['aa_link']));
		
	if($aa_title == '')
	{
		$error = true;
		$err_msg = 'Please enter action title';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($obj->chkAdminActionTitleExists($aa_title,$am_id))
	{
		$error = true;
		$err_msg = 'This action title already exists';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($aa_link == '')
	{
		$error = true;
		$err_msg = 'Please enter action page link';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if(!$error)
	{
		$tdata = array();
		$tdata['aa_title'] = $aa_title;
		$tdata['aa_link'] = $aa_link;
		$tdata['am_id'] = $am_id;
		$tdata['aa_status'] = '1';
		$tdata['added_by_admin'] = $admin_id;
		
		if($obj->addAdminAction($tdata))
		{
			$msg = 'Record Added Successfully!';
			$ref_url = "manage_admin_actions.php?am_id=".$am_id."msg=".urlencode($msg);
			
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
  