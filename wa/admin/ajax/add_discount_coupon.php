<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$add_action_id = '85';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[ADD_DISCOUNT_COUPON] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$discount_coupon = strip_tags(trim($_POST['discount_coupon']));
	$discount_price = strip_tags(trim($_POST['discount_price']));
	$min_order_amount = strip_tags(trim($_POST['min_order_amount']));
	$max_order_amount = strip_tags(trim($_POST['max_order_amount']));
	
	$dc_type = strip_tags(trim($_POST['dc_type']));
	$dc_applied_on = strip_tags(trim($_POST['dc_applied_on']));
	$dc_effective_date_type = strip_tags(trim($_POST['dc_effective_date_type']));
	$dc_effective_days_of_month_str = strip_tags(trim($_POST['dc_effective_days_of_month_str']));
	$dc_effective_days_of_week_str = strip_tags(trim($_POST['dc_effective_days_of_week_str']));
	$dc_effective_single_date = strip_tags(trim($_POST['dc_effective_single_date']));
	$dc_effective_start_date = strip_tags(trim($_POST['dc_effective_start_date']));
	$dc_effective_end_date = strip_tags(trim($_POST['dc_effective_end_date']));
	$dc_percentage = strip_tags(trim($_POST['dc_percentage']));
	$dc_min_qty_val = strip_tags(trim($_POST['dc_min_qty_val']));
	$dc_min_qty_id = strip_tags(trim($_POST['dc_min_qty_id']));
	$dc_max_qty_val = strip_tags(trim($_POST['dc_max_qty_val']));
	$dc_max_qty_id = strip_tags(trim($_POST['dc_max_qty_id']));
	$dc_comments = strip_tags(trim($_POST['dc_comments']));
	$dc_multiuser = strip_tags(trim($_POST['dc_multiuser']));
	$dc_trade_discount = strip_tags(trim($_POST['dc_trade_discount']));
	
	$country_id_str = strip_tags(trim($_POST['country_id_str']));
	$state_id_str = strip_tags(trim($_POST['state_id_str']));
	$city_id_str = strip_tags(trim($_POST['city_id_str']));
	$area_id_str = strip_tags(trim($_POST['area_id_str']));
	
	if($discount_coupon == '')
	{
		$error = true;
		$err_msg = 'Please enter discount coupon';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($obj->chkIfDiscountCouponAlreadyExists($discount_coupon))
	{
		$error = true;
		$err_msg = 'This discount coupon already exists';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($dc_type == '')
	{
		$error = true;
		$err_msg = 'Please select discount type';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($dc_applied_on == '')
	{
		$error = true;
		$err_msg = 'Please select discount applied on option';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($dc_effective_date_type == '')
	{
		$error = true;
		$err_msg = 'Please select effective date type';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	else
	{
		if($dc_effective_date_type == 'days_of_month')
		{
			if($dc_effective_days_of_month_str == '' || $dc_effective_days_of_month_str == 'null')
			{
				$error = true;
				$err_msg = 'Please select effective days of months';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			$dc_effective_days_of_week_str = '';
			$dc_effective_single_date = '';
			$dc_effective_start_date = '';
			$dc_effective_end_date = '';
		}
		elseif($dc_effective_date_type == 'days_of_week')
		{
			if($dc_effective_days_of_week_str == '' || $dc_effective_days_of_week_str == 'null')
			{
				$error = true;
				$err_msg = 'Please select effective days of week';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			$dc_effective_days_of_month_str = '';
			$dc_effective_single_date = '';
			$dc_effective_start_date = '';
			$dc_effective_end_date = '';
		}
		elseif($dc_effective_date_type == 'single_date')
		{
			if($dc_effective_single_date == '' )
			{
				$error = true;
				$err_msg = 'Please select effective date';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			$dc_effective_days_of_week_str = '';
			$dc_effective_days_of_month_str = '';
			$dc_effective_start_date = '';
			$dc_effective_end_date = '';
		}
		elseif($dc_effective_date_type == 'date_range')
		{
			if($dc_effective_start_date == '' )
			{
				$error = true;
				$err_msg = 'Please select effective start date';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			elseif($dc_effective_end_date == '' )
			{
				$error = true;
				$err_msg = 'Please select effective end date';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			elseif(strtotime($dc_effective_end_date) < strtotime($dc_effective_start_date) )
			{
				$error = true;
				$err_msg = 'Please effective end date must be greater than start date';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			$dc_effective_days_of_week_str = '';
			$dc_effective_days_of_month_str = '';
			$dc_effective_single_date = '';
		}	
	}
	
	if($dc_type == '0')
	{
		if($discount_price == '')
		{
			$error = true;
			$err_msg = 'Please enter discount price';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($discount_price))
		{
			$error = true;
			$err_msg = 'Please enter valid discount price';
			
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
	elseif($dc_type == '1')
	{
		if($dc_percentage == '')
		{
			$error = true;
			$err_msg = 'Please enter discount percentage';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($dc_percentage))
		{
			$error = true;
			$err_msg = 'Please enter valid discount percentage';
			
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
	elseif($dc_type == '2')
	{
		if($discount_price == '')
		{
			$error = true;
			$err_msg = 'Please enter discount price';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($dc_min_qty_val == '')
		{
			$error = true;
			$err_msg = 'Please enter min qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($dc_min_qty_val))
		{
			$error = true;
			$err_msg = 'Please enter valid min qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($dc_min_qty_id == '')
		{
			$error = true;
			$err_msg = 'Please select min qty unit';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($dc_max_qty_val == '')
		{
			$error = true;
			$err_msg = 'Please enter max qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($dc_max_qty_val))
		{
			$error = true;
			$err_msg = 'Please enter valid max qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($dc_max_qty_id == '')
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
		
		if($dc_type == '0')
		{
			$dc_percentage = '';
			$dc_min_qty_id = '';
			$dc_min_qty_val = '';
			$dc_max_qty_id = '';
			$dc_max_qty_val = '';
		}
		elseif($dc_type == '1')
		{
			$discount_price = '';
			$dc_min_qty_id = '';
			$dc_min_qty_val = '';
			$dc_max_qty_id = '';
			$dc_max_qty_val = '';
		}
		elseif($dc_type == '2')
		{
			$dc_percentage = '';
			$min_order_amount = '';
			$max_order_amount = '';
			
		}
		elseif($dc_type == '3')
		{
			$discount_price = '';
			$min_order_amount = '';
			$max_order_amount = '';
			$dc_percentage = '';
			$dc_min_qty_id = '';
			$dc_min_qty_val = '';
			$dc_max_qty_id = '';
			$dc_max_qty_val = '';
		}
		
		if($dc_effective_days_of_month_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_dc_effective_days_of_month = explode(',',$dc_effective_days_of_month_str);
			if(in_array('-1', $arr_temp_dc_effective_days_of_month))
			{
				$dc_effective_days_of_month_str = '-1';	
			}	
		}
		
		if($dc_effective_days_of_week_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_dc_effective_days_of_week = explode(',',$dc_effective_days_of_week_str);
			if(in_array('-1', $arr_temp_dc_effective_days_of_week))
			{
				$dc_effective_days_of_week_str = '-1';	
			}	
		}
		
		if($dc_effective_date_type == 'single_date')
		{
			$dc_effective_single_date = date('Y-m-d',strtotime($dc_effective_single_date));
		}
		elseif($dc_effective_date_type == 'date_range')
		{
			$dc_effective_start_date = date('Y-m-d',strtotime($dc_effective_start_date));
			$dc_effective_end_date = date('Y-m-d',strtotime($dc_effective_end_date));
		}
		
		$tdata = array();
		$tdata['discount_coupon'] = $discount_coupon;
		$tdata['discount_price'] = $discount_price;
		$tdata['min_order_amount'] = $min_order_amount;
		$tdata['max_order_amount'] = $max_order_amount;
		$tdata['dc_type'] = $dc_type;
		$tdata['dc_applied_on'] = $dc_applied_on;
		$tdata['dc_effective_date_type'] = $dc_effective_date_type;
		$tdata['dc_effective_days_of_month'] = $dc_effective_days_of_month_str;
		$tdata['dc_effective_days_of_week'] = $dc_effective_days_of_week_str;
		$tdata['dc_effective_single_date'] = $dc_effective_single_date;
		$tdata['dc_effective_start_date'] = $dc_effective_start_date;
		$tdata['dc_effective_end_date'] = $dc_effective_end_date;
		$tdata['dc_percentage'] = $dc_percentage;
		$tdata['dc_min_qty_id'] = $dc_min_qty_id;
		$tdata['dc_min_qty_val'] = $dc_min_qty_val;
		$tdata['dc_max_qty_id'] = $dc_max_qty_id;
		$tdata['dc_max_qty_val'] = $dc_max_qty_val;
		$tdata['dc_country_id'] = $country_id_str;
		$tdata['dc_state_id'] = $state_id_str;
		$tdata['dc_city_id'] = $city_id_str;
		$tdata['dc_area_id'] = $area_id_str;
		$tdata['dc_comments'] = $dc_comments;
		$tdata['dc_multiuser'] = $dc_multiuser;
		$tdata['dc_trade_discount'] = $dc_trade_discount;
		$tdata['dc_status'] = 1;
		$tdata['added_by_admin'] = $admin_id;
		
		if($obj->addDiscountCoupon($tdata))
		{
			$msg = 'Record added successfully!';
			$ref_url = "manage_discount_coupons.php?msg=".urlencode($msg);
						
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