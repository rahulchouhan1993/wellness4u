<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$edit_action_id = '15';

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

if(isset($_POST['btn_submit']))
{
	$am_id = trim($_POST['hdnam_id']);
	$am_title = strip_tags(trim($_POST['am_title']));
	$am_link = strip_tags(trim($_POST['am_link']));
	$am_order = strip_tags(trim($_POST['am_order']));
	$am_status = trim($_POST['am_status']);
	
	if($am_title == '')
	{
		$error = true;
		$err_msg = 'Please enter menu title';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($obj->chkAdminMenuTitleExists_edit($am_title,$am_id))
	{
		$error = true;
		$err_msg = 'This menu title already exists';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($am_link == '')
	{
		$error = true;
		$err_msg = 'Please enter menu link';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if(!$error)
	{
		$tdata = array();
		$tdata['am_id'] = $am_id;
		$tdata['am_title'] = $am_title;
		$tdata['am_link'] = $am_link;
		$tdata['am_order'] = $am_order;
		$tdata['am_status'] = $am_status;
		$tdata['modified_by_admin'] = $admin_id;
		if($obj->updateAdminMenu($tdata))
		{
			$msg = 'Record Added Successfully!';
			$ref_url = "manage_admin_menus.php?msg=".urlencode($msg);
						
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
  