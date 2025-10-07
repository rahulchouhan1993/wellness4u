<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}
$admin_id = $_SESSION['admin_id'];
$edit_action_id = '37';

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
	$item_id = $_POST['item_id'];
	$iig_id = $_POST['ing_id'];
	$ic_id = $_POST['item_cat_id'];
	$item_status = $_POST['item_status'];
	$item_name = strip_tags(trim($_POST['item_name']));
	$admin_id = $_SESSION['admin_id'];
	$ingredient_name = $_POST['ing'];
	$parent_cat_id = $_POST['parent_cat'];
	$cat_id = $_POST['cat_id'];
	$cat_show = $_POST['show'];
	$arr_cat_show = explode(',',$cat_show);	
	
	if($item_name == '')
		{
			$error = true;
			$err_msg = 'Please Enter Item Name';
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
	
		elseif($obj->chkItemNameExists_edit($item_name,$item_id))
		{
			$error = true;
			$err_msg = 'This Item Name is Already Exists';
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
	if($parent_cat_id != '')
	{
		$arr_parent_cat = explode(',',$parent_cat_id);	
		$arr1_parent_cat = array_unique($arr_parent_cat);
		
		if(count($arr_parent_cat) != count($arr1_parent_cat))
		{
			$error = true;
			$err_msg = 'You Select Same Categories Multiple time';
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}	
	}
	else
	{
		$error = true;
		$err_msg = 'Please Select Category';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($cat_id != '')
	{
		$arr_cat = explode(',',$cat_id);
		$arr_parent_cat = explode(',',$parent_cat_id);
		
		if(count($arr_cat) != count($arr_parent_cat))
		{
			$error = true;
			$err_msg = 'You are not Select Sub Categories' ;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}	
	}
	else
	{
		$error = true;
		$err_msg = 'Please Select Sub Category';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if(!$error)
	{
		
		$tdata = array();
		
		$tdata['item_id'] = $item_id;
		$tdata['iig_id'] = $iig_id;
		$tdata['ic_id'] = $ic_id;
		$tdata['admin_id'] = $admin_id;
		$tdata['item_name'] = $item_name;
		$tdata['item_status'] = $item_status;
		$tdata['ingredient_name'] = $ingredient_name;
		$tdata['parent_cat_id'] = $arr_parent_cat;
		$tdata['cat_id'] = $arr_cat;
		$tdata['cat_show'] = $arr_cat_show;
		print_r($tdata);
		if($obj->UpdateItems($tdata))
		{
			$msg = 'Record Added Successfully!';
			$ref_url = "manage_items.php?msg=".urlencode($msg);
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
  