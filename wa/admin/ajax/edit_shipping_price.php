<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$edit_action_id = '59';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[EDIT_SHIPPING_PRICE] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$sp_id = trim($_POST['hdnsp_id']);
	$shipping_price = strip_tags(trim($_POST['shipping_price']));
	$min_order_amount = strip_tags(trim($_POST['min_order_amount']));
	$max_order_amount = strip_tags(trim($_POST['max_order_amount']));
	
	$sp_type = strip_tags(trim($_POST['sp_type']));
	$sp_applied_on = strip_tags(trim($_POST['sp_applied_on']));
	$sp_effective_date = strip_tags(trim($_POST['sp_effective_date']));
	$sp_percentage = strip_tags(trim($_POST['sp_percentage']));
	$sp_min_qty_val = strip_tags(trim($_POST['sp_min_qty_val']));
	$sp_min_qty_id = strip_tags(trim($_POST['sp_min_qty_id']));
	$sp_max_qty_val = strip_tags(trim($_POST['sp_max_qty_val']));
	$sp_max_qty_id = strip_tags(trim($_POST['sp_max_qty_id']));
	$sp_comments = strip_tags(trim($_POST['sp_comments']));
	
	$country_id_str = strip_tags(trim($_POST['country_id_str']));
	$state_id_str = strip_tags(trim($_POST['state_id_str']));
	$city_id_str = strip_tags(trim($_POST['city_id_str']));
	$area_id_str = strip_tags(trim($_POST['area_id_str']));
	
	$sp_status = strip_tags(trim($_POST['sp_status']));
	
	if($sp_type == '')
	{
		$error = true;
		$err_msg = 'Please select shipping type';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($sp_applied_on == '')
	{
		$error = true;
		$err_msg = 'Please select shipping applied on option';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($sp_effective_date == '')
	{
		$error = true;
		$err_msg = 'Please select shipping effective date';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($sp_type == '0')
	{
		if($shipping_price == '')
		{
			$error = true;
			$err_msg = 'Please enter shipping price';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($shipping_price))
		{
			$error = true;
			$err_msg = 'Please enter valid shipping price';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($min_order_amount == '')
		{
			$error = true;
			$err_msg = 'Please enter min order amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($min_order_amount))
		{
			$error = true;
			$err_msg = 'Please enter valid min order amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($max_order_amount == '')
		{
			$error = true;
			$err_msg = 'Please enter max order amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($max_order_amount))
		{
			$error = true;
			$err_msg = 'Please enter valid max order amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($max_order_amount < $min_order_amount)
		{
			$error = true;
			$err_msg = 'Min order amount must be lesser than Max order amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
	}
	elseif($sp_type == '1')
	{
		if($sp_percentage == '')
		{
			$error = true;
			$err_msg = 'Please enter shipping percentage';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($sp_percentage))
		{
			$error = true;
			$err_msg = 'Please enter valid shipping percentage';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($min_order_amount == '')
		{
			$error = true;
			$err_msg = 'Please enter min order amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($min_order_amount))
		{
			$error = true;
			$err_msg = 'Please enter valid min order amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($max_order_amount == '')
		{
			$error = true;
			$err_msg = 'Please enter max order amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($max_order_amount))
		{
			$error = true;
			$err_msg = 'Please enter valid max order amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($max_order_amount < $min_order_amount)
		{
			$error = true;
			$err_msg = 'Min order amount must be lesser than Max order amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
	}
	elseif($sp_type == '2')
	{
		if($shipping_price == '')
		{
			$error = true;
			$err_msg = 'Please enter shipping price';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($sp_min_qty_val == '')
		{
			$error = true;
			$err_msg = 'Please enter min qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($sp_min_qty_val))
		{
			$error = true;
			$err_msg = 'Please enter valid min qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($sp_min_qty_id == '')
		{
			$error = true;
			$err_msg = 'Please select min qty unit';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($sp_max_qty_val == '')
		{
			$error = true;
			$err_msg = 'Please enter max qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($sp_max_qty_val))
		{
			$error = true;
			$err_msg = 'Please enter valid max qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($sp_max_qty_id == '')
		{
			$error = true;
			$err_msg = 'Please select max qty unit';
			
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
		
		if($sp_type == '0')
		{
			$sp_percentage = '';
			$sp_min_qty_id = '';
			$sp_min_qty_val = '';
			$sp_max_qty_id = '';
			$sp_max_qty_val = '';
		}
		elseif($sp_type == '1')
		{
			$shipping_price = '';
			$sp_min_qty_id = '';
			$sp_min_qty_val = '';
			$sp_max_qty_id = '';
			$sp_max_qty_val = '';
		}
		elseif($sp_type == '2')
		{
			$sp_percentage = '';
			$min_order_amount = '';
			$max_order_amount = '';
			
		}
		elseif($sp_type == '3')
		{
			$shipping_price = '';
			$min_order_amount = '';
			$max_order_amount = '';
			$sp_percentage = '';
			$sp_min_qty_id = '';
			$sp_min_qty_val = '';
			$sp_max_qty_id = '';
			$sp_max_qty_val = '';
		}
		
		$sp_effective_date = date('Y-m-d',strtotime($sp_effective_date));
		
		
		$tdata = array();
		$tdata['sp_id'] = $sp_id;
		$tdata['shipping_price'] = $shipping_price;
		$tdata['min_order_amount'] = $min_order_amount;
		$tdata['max_order_amount'] = $max_order_amount;
		$tdata['sp_type'] = $sp_type;
		$tdata['sp_applied_on'] = $sp_applied_on;
		$tdata['sp_effective_date'] = $sp_effective_date;
		$tdata['sp_percentage'] = $sp_percentage;
		$tdata['sp_min_qty_id'] = $sp_min_qty_id;
		$tdata['sp_min_qty_val'] = $sp_min_qty_val;
		$tdata['sp_max_qty_id'] = $sp_max_qty_id;
		$tdata['sp_max_qty_val'] = $sp_max_qty_val;
		$tdata['sp_country_id'] = $country_id_str;
		$tdata['sp_state_id'] = $state_id_str;
		$tdata['sp_city_id'] = $city_id_str;
		$tdata['sp_area_id'] = $area_id_str;
		$tdata['sp_comments'] = $sp_comments;
		$tdata['sp_status'] = $sp_status;
		$tdata['modified_by_admin'] = $admin_id;
		if($obj->updateShippingPrice($tdata))
		{
			$msg = 'Record Added Successfully!';
			$ref_url = "manage_shipping_prices.php?msg=".urlencode($msg);
						
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