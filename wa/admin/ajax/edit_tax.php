<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$edit_action_id = '63';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[EDIT_TAX] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$tax_id = trim($_POST['hdntax_id']);
	$tax_name = strip_tags(trim($_POST['tax_name']));
	$tax_parent_cat_id = strip_tags(trim($_POST['tax_parent_cat_id']));
	$tax_cat_id = strip_tags(trim($_POST['tax_cat_id']));
	$tax_type = strip_tags(trim($_POST['tax_type']));
	$tax_applied_on = strip_tags(trim($_POST['tax_applied_on']));
	$tax_effective_date = strip_tags(trim($_POST['tax_effective_date']));
	$tax_amount = strip_tags(trim($_POST['tax_amount']));
	$tax_percentage = strip_tags(trim($_POST['tax_percentage']));
	$tax_qty_val = strip_tags(trim($_POST['tax_qty_val']));
	$tax_qty_id = strip_tags(trim($_POST['tax_qty_id']));
	$tax_comments = strip_tags(trim($_POST['tax_comments']));
	$tax_status = strip_tags(trim($_POST['tax_status']));
	
	$country_id_str = strip_tags(trim($_POST['country_id_str']));
	$state_id_str = strip_tags(trim($_POST['state_id_str']));
	$city_id_str = strip_tags(trim($_POST['city_id_str']));
	$area_id_str = strip_tags(trim($_POST['area_id_str']));
	

	if($tax_name == '')
	{
		$error = true;
		$err_msg = 'Please enter tax name';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($tax_cat_id == '')
	{
		$error = true;
		$err_msg = 'Please select tax category';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($tax_applied_on == '')
	{
		$error = true;
		$err_msg = 'Please select tax applied on option';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($tax_type == '')
	{
		$error = true;
		$err_msg = 'Please select tax type';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($tax_effective_date == '')
	{
		$error = true;
		$err_msg = 'Please select tax effective date';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($tax_type == '0')
	{
		if($tax_amount == '')
		{
			$error = true;
			$err_msg = 'Please enter tax amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($tax_amount))
		{
			$error = true;
			$err_msg = 'Please enter valid tax amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
	}
	elseif($tax_type == '1')
	{
		if($tax_percentage == '')
		{
			$error = true;
			$err_msg = 'Please enter tax percentage';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($tax_percentage))
		{
			$error = true;
			$err_msg = 'Please enter valid tax percentage';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
	}
	elseif($tax_type == '2')
	{
		if($tax_amount == '')
		{
			$error = true;
			$err_msg = 'Please enter tax amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($tax_qty_val == '')
		{
			$error = true;
			$err_msg = 'Please enter qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($tax_qty_val))
		{
			$error = true;
			$err_msg = 'Please enter valid qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($tax_qty_id == '')
		{
			$error = true;
			$err_msg = 'Please select qty unit';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
	}
	
	if($country_id_str == '' || $country_id_str == 'null')
	{
		$error = true;
		$err_msg = 'Please select country';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($state_id_str == '' || $state_id_str == 'null')
	{
		$error = true;
		$err_msg = 'Please select state';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($city_id_str == '' || $city_id_str == 'null')
	{
		$error = true;
		$err_msg = 'Please select city';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($area_id_str == '' || $area_id_str == 'null')
	{
		$error = true;
		$err_msg = 'Please select area';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if(!$error)
	{
		if($country_id_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_country_id = explode(',',$country_id_str);
			if(in_array('-1', $arr_temp_country_id))
			{
				$country_id_str = '-1';	
			}	
		}
		
		if($state_id_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_state_id = explode(',',$state_id_str);
			if(in_array('-1', $arr_temp_state_id))
			{
				$state_id_str = '-1';	
			}	
		}
		
		if($city_id_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_city_id = explode(',',$city_id_str);
			if(in_array('-1', $arr_temp_city_id))
			{
				$city_id_str = '-1';	
			}	
		}
		
		if($area_id_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_area_id = explode(',',$area_id_str);
			if(in_array('-1', $arr_temp_area_id))
			{
				$area_id_str = '-1';	
			}	
		}
		
		if($tax_type == '0')
		{
			$tax_percentage = '';
			$tax_qty_id = '';
			$tax_qty_val = '';
		}
		elseif($tax_type == '1')
		{
			$tax_amount = '';
			$tax_qty_id = '';
			$tax_qty_val = '';
		}
		elseif($tax_type == '2')
		{
			$tax_percentage = '';
			
		}
		elseif($tax_type == '3')
		{
			$tax_amount = '';
			$tax_percentage = '';
			$tax_qty_id = '';
			$tax_qty_val = '';
		}
		
		$tax_effective_date = date('Y-m-d',strtotime($tax_effective_date));
		
		
		$tdata = array();
		$tdata['tax_id'] = $tax_id;
		$tdata['tax_name'] = $tax_name;
		$tdata['tax_parent_cat_id'] = $tax_parent_cat_id;
		$tdata['tax_cat_id'] = $tax_cat_id;
		$tdata['tax_type'] = $tax_type;
		$tdata['tax_applied_on'] = $tax_applied_on;
		$tdata['tax_effective_date'] = $tax_effective_date;
		$tdata['tax_amount'] = $tax_amount;
		$tdata['tax_percentage'] = $tax_percentage;
		$tdata['tax_qty_id'] = $tax_qty_id;
		$tdata['tax_qty_val'] = $tax_qty_val;
		$tdata['tax_country_id'] = $country_id_str;
		$tdata['tax_state_id'] = $state_id_str;
		$tdata['tax_city_id'] = $city_id_str;
		$tdata['tax_area_id'] = $area_id_str;
		$tdata['tax_comments'] = $tax_comments;
		$tdata['tax_status'] = $tax_status;
		$tdata['modified_by_admin'] = $admin_id;
		if($obj->updateTax($tdata))
		{
			$msg = 'Record Added Successfully!';
			$ref_url = "manage_taxes.php?msg=".urlencode($msg);
						
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