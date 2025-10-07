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

$obj->debuglog('[EDIT_ADMIN_ACTION] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btn_submit']))
{
	$aa_id = trim($_POST['hdnaa_id']);
	$am_id = strip_tags(trim($_POST['am_id']));
	$aa_title = strip_tags(trim($_POST['aa_title']));
	$aa_link = strip_tags(trim($_POST['aa_link']));
	$aa_vendor_menu = strip_tags(trim($_POST['aa_vendor_menu']));
	$aa_status = trim($_POST['aa_status']);
	
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
	elseif($obj->chkAdminActionTitleExists_edit($aa_title,$am_id,$aa_id))
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
	
	if($aa_vendor_menu == '')
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
		$arr_where = array();
		$arr_where['aa_id'] = $aa_id;
		
		$tdata = array();
		$tdata['tablename'] = 'tblwaadminactions';
		$tdata['aa_title'] = $aa_title;
		$tdata['aa_link'] = $aa_link;
		$tdata['aa_status'] = $aa_status;
		$tdata['aa_vendor_menu'] = $aa_vendor_menu;
		$tdata['aa_modified_date'] = date('Y-m-d H:i:s');
		$tdata['modified_by_admin'] = $admin_id;
		
		//if($obj->updateAdminAction($tdata))
		if($obj->updateRecordCommon($tdata,$arr_where))
		{
			$msg = 'Record Updated Successfully!';
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