<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}
$admin_id = $_SESSION['admin_id'];
$add_action_id = '36';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[ADD_ITEM] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$item_name = strip_tags(trim($_POST['item_name']));
	$item_code = strip_tags(trim($_POST['item_code']));
	$admin_id = $_SESSION['admin_id'];
	$ingredient_name = '';
	$ingredient_type = $_POST['ingredient_type'];
	$ingredient_id = $_POST['ingredient_id'];
	if($ingredient_id == '' || $ingredient_id == 'null')
	{
		$ingredient_id_arr = array();	
	}
	else
	{
		$ingredient_id_arr = explode(',' , $ingredient_id);	
	}
	
	
	$ingredient_show = strip_tags(trim($_POST['ingredient_show']));
	
	$item_disc1 = strip_tags($_POST['item_disc1']);
	$item_disc2 = strip_tags($_POST['item_disc2']);
	$item_disc_show1 = $_POST['item_disc_show1'];
	$item_disc_show2 = $_POST['item_disc_show2'];
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
	elseif($obj->chkItemNameExists($item_name))
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
			$err_msg = 'Please select sub category';
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}	
		
		for($i=0,$j=1;$i<count($arr_parent_cat);$i++,$j++)
		{
			if($arr_parent_cat[$i] != '' )
			{
				if($arr_cat[$i] == '' )
				{
					$error = true;
					$err_msg = 'Please select sub category';
				
					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);
				}
			}
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
		$tdata['admin_id'] = $admin_id;
		$tdata['item_name'] = $item_name;
		$tdata['item_code'] = $item_code;
		$tdata['ingredient_name'] = $ingredient_name;
		$tdata['ingredient_id'] = $ingredient_id_arr;
		$tdata['ingredient_type'] = $ingredient_type;
		$tdata['parent_cat_id'] = $arr_parent_cat;
		$tdata['cat_id'] = $arr_cat;
		$tdata['cat_show'] = $arr_cat_show;
		$tdata['item_disc1'] = $item_disc1;
		$tdata['item_disc2'] = $item_disc2;
		$tdata['item_disc_show1'] = $item_disc_show1;
		$tdata['item_disc_show2'] = $item_disc_show2;
		$tdata['ingredient_show'] = $ingredient_show;
		
		if($obj->addItems($tdata))
		{
			$msg = 'Record Added Successfully!';
			$ref_url = "manage_items.php?msg=".urlencode($msg);
						
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