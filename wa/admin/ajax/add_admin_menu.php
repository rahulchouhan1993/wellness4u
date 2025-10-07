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

$obj->debuglog('[ADD_ADMIN_MENU] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btn_submit']))
{
	$am_title = strip_tags(trim($_POST['am_title']));
	$am_link = strip_tags(trim($_POST['am_link']));
	$am_order = strip_tags(trim($_POST['am_order']));
	$am_vendor_menu = strip_tags(trim($_POST['am_vendor_menu']));
	
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
	elseif($obj->chkAdminMenuTitleExists($am_title))
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
	
	if($am_vendor_menu == '')
	{
		$error = true;
		$err_msg = 'Please select business associate panel option';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if(!$error)
	{
		$tdata = array();
		$tdata['tablename'] = 'tblwaadminmenu';
		$tdata['am_title'] = $am_title;
		$tdata['am_link'] = $am_link;
		$tdata['am_icon'] = 'fa-user';
		$tdata['am_order'] = $am_order;
		$tdata['am_status'] = '1';
		$tdata['am_vendor_menu'] = $am_vendor_menu;
		$tdata['am_add_date'] = date('Y-m-d H:i:s');
		$tdata['added_by_admin'] = $admin_id;
		
		//if($obj->addAdminMenu($tdata))
		if($obj->addRecordCommon($tdata))
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