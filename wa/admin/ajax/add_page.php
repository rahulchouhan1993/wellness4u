<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$add_action_id = '54';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[ADD_PAGE] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>, FILES:<pre>'.print_r($_FILES,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$page_name = strip_tags(trim($_POST['page_name']));
	$page_title = strip_tags(trim($_POST['page_title']));
	$page_contents = urldecode(trim($_POST['page_contents']));
	$meta_title = strip_tags(trim($_POST['meta_title']));
	$meta_keywords = strip_tags(trim($_POST['meta_keywords']));
	$meta_desc = strip_tags(trim($_POST['meta_desc']));
	$page_link = strip_tags(trim($_POST['page_link']));
	$show_in_manage_menu = strip_tags(trim($_POST['show_in_manage_menu']));
	
	if($page_name == '')
	{
		$error = true;
		$err_msg = 'Please enter page name';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($obj->chkIfPageNameExist($page_name))
	{
		$error = true;
		$err_msg = 'This page already exist';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($page_title == '')
	{
		$error = true;
		$err_msg = 'Please enter page heading';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if(!$error)
	{
		if($page_link == '')
		{
			$link_enable = 0;
		}
		else
		{
			$link_enable = 1;
		}
		
		$tdata = array();
		$tdata['page_name'] = $page_name;
		$tdata['page_title'] = $page_title;
		$tdata['page_contents'] = $page_contents;
		$tdata['meta_title'] = $meta_title;
		$tdata['meta_keywords'] = $meta_keywords;
		$tdata['meta_desc'] = $meta_desc;
		$tdata['link_enable'] = $link_enable;
		$tdata['page_link'] = $page_link;
		$tdata['show_in_manage_menu'] = $show_in_manage_menu;
		$tdata['show_in_admin'] = 1;
		$tdata['page_status'] = 1;
		$tdata['added_by_admin'] = $admin_id;
		
		if($obj->addPage($tdata))
		{
			$msg = 'Record added successfully!';
			$ref_url = "manage_pages.php?msg=".urlencode($msg);
						
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