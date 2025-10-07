<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$add_action_id = '40';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[ADD_CUISINE] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>, FILES:<pre>'.print_r($_FILES,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$item_id = strip_tags(trim($_POST['item_id']));
	$cusine_type_parent_id = strip_tags(trim($_POST['cusine_type_parent_id']));
	$cusine_type_id = strip_tags(trim($_POST['cusine_type_id']));
	$min_cart_price = strip_tags(trim($_POST['min_cart_price']));
	$vendor_id = strip_tags(trim($_POST['vendor_id']));
	$vendor_show = strip_tags(trim($_POST['vendor_show']));
	
	$arr_vloc_id = array();
	if(isset($_POST['vloc_id']))
	{
		foreach($_POST['vloc_id'] as $key => $val)
		{
			array_push($arr_vloc_id,$val);
		}		
	}
	
	$arr_ordering_type_id = array();
	if(isset($_POST['ordering_type_id']))
	{
		foreach($_POST['ordering_type_id'] as $key => $val)
		{
			array_push($arr_ordering_type_id,$val);
		}		
	}
	
	$arr_ordering_size_id = array();
	if(isset($_POST['ordering_size_id']))
	{
		foreach($_POST['ordering_size_id'] as $key => $val)
		{
			array_push($arr_ordering_size_id,$val);
		}		
	}
	
	$arr_ordering_size_show = array();
	if(isset($_POST['ordering_size_show']))
	{
		foreach($_POST['ordering_size_show'] as $key => $val)
		{
			array_push($arr_ordering_size_show,$val);
		}		
	}
	
	$arr_max_order = array();
	if(isset($_POST['max_order']))
	{
		foreach($_POST['max_order'] as $key => $val)
		{
			array_push($arr_max_order,$val);
		}		
	}
	
	$arr_min_order = array();
	if(isset($_POST['min_order']))
	{
		foreach($_POST['min_order'] as $key => $val)
		{
			array_push($arr_min_order,$val);
		}		
	}
	
	$arr_cusine_qty = array();
	if(isset($_POST['cusine_qty']))
	{
		foreach($_POST['cusine_qty'] as $key => $val)
		{
			array_push($arr_cusine_qty,$val);
		}		
	}
	
	$arr_cusine_qty_show = array();
	if(isset($_POST['cusine_qty_show']))
	{
		foreach($_POST['cusine_qty_show'] as $key => $val)
		{
			array_push($arr_cusine_qty_show,$val);
		}		
	}
	
	$arr_sold_qty_show = array();
	if(isset($_POST['sold_qty_show']))
	{
		foreach($_POST['sold_qty_show'] as $key => $val)
		{
			array_push($arr_sold_qty_show,$val);
		}		
	}
	
	$arr_currency_id = array();
	if(isset($_POST['currency_id']))
	{
		foreach($_POST['currency_id'] as $key => $val)
		{
			array_push($arr_currency_id,$val);
		}		
	}
	
	$arr_cusine_price = array();
	if(isset($_POST['cusine_price']))
	{
		foreach($_POST['cusine_price'] as $key => $val)
		{
			array_push($arr_cusine_price,$val);
		}		
	}
	
	$arr_default_price = array();
	if(isset($_POST['default_price']))
	{
		foreach($_POST['default_price'] as $key => $val)
		{
			array_push($arr_default_price,$val);
		}		
	}
	
	$arr_is_offer = array();
	if(isset($_POST['is_offer']))
	{
		foreach($_POST['is_offer'] as $key => $val)
		{
			array_push($arr_is_offer,$val);
		}		
	}
	
	$arr_offer_price = array();
	if(isset($_POST['offer_price']))
	{
		foreach($_POST['offer_price'] as $key => $val)
		{
			array_push($arr_offer_price,$val);
		}		
	}
	
	$arr_offer_date_type = array();
	if(isset($_POST['offer_date_type']))
	{
		foreach($_POST['offer_date_type'] as $key => $val)
		{
			array_push($arr_offer_date_type,$val);
		}		
	}
	
	$arr_offer_days_of_month = array();
	if(isset($_POST['offer_days_of_month_str']))
	{
		foreach($_POST['offer_days_of_month_str'] as $key => $val)
		{
			array_push($arr_offer_days_of_month,$val);
		}		
	}
	
	$arr_offer_days_of_week = array();
	if(isset($_POST['offer_days_of_week_str']))
	{
		foreach($_POST['offer_days_of_week_str'] as $key => $val)
		{
			array_push($arr_offer_days_of_week,$val);
		}		
	}
	
	$arr_offer_single_date = array();
	if(isset($_POST['offer_single_date']))
	{
		foreach($_POST['offer_single_date'] as $key => $val)
		{
			array_push($arr_offer_single_date,$val);
		}		
	}
	
	$arr_offer_start_date = array();
	if(isset($_POST['offer_start_date']))
	{
		foreach($_POST['offer_start_date'] as $key => $val)
		{
			array_push($arr_offer_start_date,$val);
		}		
	}
	
	$arr_offer_end_date = array();
	if(isset($_POST['offer_end_date']))
	{
		foreach($_POST['offer_end_date'] as $key => $val)
		{
			array_push($arr_offer_end_date,$val);
		}		
	}
	
	$arr_cucat_parent_cat_id = array();
	if(isset($_POST['cucat_parent_cat_id']))
	{
		foreach($_POST['cucat_parent_cat_id'] as $key => $val)
		{
			array_push($arr_cucat_parent_cat_id,$val);
		}		
	}

	$arr_cucat_cat_id = array();
	if(isset($_POST['cucat_cat_id']))
	{
		foreach($_POST['cucat_cat_id'] as $key => $val)
		{
			array_push($arr_cucat_cat_id,$val);
		}		
	}
	
	$arr_cucat_show = array();
	if(isset($_POST['cucat_show']))
	{
		foreach($_POST['cucat_show'] as $key => $val)
		{
			array_push($arr_cucat_show,$val);
		}		
	}
	
	$arr_cw_qt_parent_cat_id = array();
	if(isset($_POST['cw_qt_parent_cat_id']))
	{
		foreach($_POST['cw_qt_parent_cat_id'] as $key => $val)
		{
			array_push($arr_cw_qt_parent_cat_id,$val);
		}		
	}

	$arr_cw_qt_cat_id = array();
	if(isset($_POST['cw_qt_cat_id']))
	{
		foreach($_POST['cw_qt_cat_id'] as $key => $val)
		{
			array_push($arr_cw_qt_cat_id,$val);
		}		
	}
	
	$arr_cw_qu_parent_cat_id = array();
	if(isset($_POST['cw_qu_parent_cat_id']))
	{
		foreach($_POST['cw_qu_parent_cat_id'] as $key => $val)
		{
			array_push($arr_cw_qu_parent_cat_id,$val);
		}		
	}

	$arr_cw_qu_cat_id = array();
	if(isset($_POST['cw_qu_cat_id']))
	{
		foreach($_POST['cw_qu_cat_id'] as $key => $val)
		{
			array_push($arr_cw_qu_cat_id,$val);
		}		
	}
	
	$arr_cw_quantity = array();
	if(isset($_POST['cw_quantity']))
	{
		foreach($_POST['cw_quantity'] as $key => $val)
		{
			array_push($arr_cw_quantity,$val);
		}		
	}
	
	$arr_cw_show = array();
	if(isset($_POST['cw_show']))
	{
		foreach($_POST['cw_show'] as $key => $val)
		{
			array_push($arr_cw_show,$val);
		}		
	}
	
	$country_id_str = strip_tags(trim($_POST['country_id_str']));
	$state_id_str = strip_tags(trim($_POST['state_id_str']));
	$city_id_str = strip_tags(trim($_POST['city_id_str']));
	$area_id_str = strip_tags(trim($_POST['area_id_str']));
	$publish_date_type = strip_tags(trim($_POST['publish_date_type']));
	$publish_days_of_month_str = strip_tags(trim($_POST['publish_days_of_month_str']));
	$publish_days_of_week_str = strip_tags(trim($_POST['publish_days_of_week_str']));
	$publish_single_date = strip_tags(trim($_POST['publish_single_date']));
	$publish_start_date = strip_tags(trim($_POST['publish_start_date']));
	$publish_end_date = strip_tags(trim($_POST['publish_end_date']));
	$delivery_date_type = strip_tags(trim($_POST['delivery_date_type']));
	$delivery_days_of_month_str = strip_tags(trim($_POST['delivery_days_of_month_str']));
	$delivery_days_of_week_str = strip_tags(trim($_POST['delivery_days_of_week_str']));
	$delivery_single_date = strip_tags(trim($_POST['delivery_single_date']));
	$delivery_start_date = strip_tags(trim($_POST['delivery_start_date']));
	$delivery_end_date = strip_tags(trim($_POST['delivery_end_date']));
	$order_cutoff_time = strip_tags(trim($_POST['order_cutoff_time']));
	$delivery_time = strip_tags(trim($_POST['delivery_time']));
	$delivery_time_show = strip_tags(trim($_POST['delivery_time_show']));
	$delivery_date_show = strip_tags(trim($_POST['delivery_date_show']));
	$cancel_cutoff_time = strip_tags(trim($_POST['cancel_cutoff_time']));
	$cancel_cutoff_time_show = strip_tags(trim($_POST['cancel_cutoff_time_show']));
	$cusine_desc_1 = strip_tags(trim($_POST['cusine_desc_1']));
	$cusine_desc_show_1 = strip_tags(trim($_POST['cusine_desc_show_1']));
	$cusine_desc_2 = strip_tags(trim($_POST['cusine_desc_2']));
	$cusine_desc_show_2 = strip_tags(trim($_POST['cusine_desc_show_2']));
	
	if($item_id == '')
	{
		$error = true;
		$err_msg = 'Please select item';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($cusine_type_id == '')
	{
		$error = true;
		$err_msg = 'Please menu presantation';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($cusine_type_id == '122')
	{
		if($min_cart_price == '')
		{
			$error = true;
			$err_msg = 'Please enter min cart price';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);	
		}
		elseif(!is_numeric($min_cart_price))
		{
			$error = true;
			$err_msg = 'Please enter valid min cart price';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);	
		}
	}
	else
	{
		$min_cart_price = '';
	}
	
	if($vendor_id == '')
	{
		$error = true;
		$err_msg = 'Please select vendor';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($vendor_show == '')
	{
		$error = true;
		$err_msg = 'Please select show vendor details';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	for($i=0,$j=1;$i<count($arr_vloc_id);$i++,$j++)
	{
		if($arr_vloc_id[$i] == '')
		{
			$error = true;
			$err_msg = 'Please select location - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($arr_ordering_type_id[$i] == '')
		{
			$error = true;
			$err_msg = 'Please select ordering type - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($arr_ordering_size_id[$i] == '')
		{
			$error = true;
			$err_msg = 'Please select ordering size - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($arr_ordering_size_show[$i] == '')
		{
			$error = true;
			$err_msg = 'Please select show ordering size - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($arr_min_order[$i] == '')
		{
			$error = true;
			$err_msg = 'Please enter min order - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($arr_min_order[$i] == '0')
		{
			$error = true;
			$err_msg = 'Min order must greater than 0 - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($arr_min_order[$i]))
		{
			$error = true;
			$err_msg = 'Invalid min order(only numerc value allowed) - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($arr_max_order[$i] == '')
		{
			$error = true;
			$err_msg = 'Please enter max order - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($arr_max_order[$i] == '0')
		{
			$error = true;
			$err_msg = 'Max order must greater than 0 - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($arr_max_order[$i]))
		{
			$error = true;
			$err_msg = 'Invalid max order(only numeric value allowed) - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($arr_min_order[$i] > $arr_max_order[$i])
		{
			$error = true;
			$err_msg = 'Min order must be less than max order - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($arr_cusine_qty[$i] == '')
		{
			$error = true;
			$err_msg = 'Please enter current stock - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($arr_cusine_qty[$i]))
		{
			$error = true;
			$err_msg = 'Invalid current stock(only numeric value allowed) - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($arr_cusine_price[$i] == '')
		{
			$error = true;
			$err_msg = 'Please enter cusine price - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($arr_cusine_price[$i]))
		{
			$error = true;
			$err_msg = 'Invalid price(only numeric value allowed) - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($arr_is_offer[$i] == '1')
		{
			if($arr_offer_price[$i] == '')
			{
				$error = true;
				$err_msg = 'Please enter offer price - row no '.$j;
			
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			elseif(!is_numeric($arr_offer_price[$i]))
			{
				$error = true;
				$err_msg = 'Invalid offer price(only numeric value allowed) - row no '.$j;
			
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			elseif($arr_offer_price[$i] >= $arr_cusine_price[$i])
			{
				$error = true;
				$err_msg = 'Offer price must be lesser than actual price - row no '.$j;
			
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			if($arr_offer_date_type[$i] == '')
			{
				$error = true;
				$err_msg = 'Please select offer date type - row no '.$j;
			
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			else
			{
				if($arr_offer_date_type[$i] == 'days_of_month')
				{
					/*
					if($arr_offer_days_of_month[$i] == '' || $arr_offer_days_of_month[$i] == 'null')
					{
						$error = true;
						$err_msg = 'Please select offer days of months - row no '.$j;
						
						$tdata = array();
						$response = array('msg'=>$err_msg,'status'=>0);
						$tdata[] = $response;
						echo json_encode($tdata);
						exit(0);
					}
					*/
					
					$arr_offer_days_of_week[$i] = '';
					$arr_offer_single_date[$i] = '';
					$arr_offer_start_date[$i] = '';
					$arr_offer_end_date[$i] = '';
				}
				elseif($arr_offer_date_type[$i] == 'days_of_week')
				{
					/*
					if($arr_offer_days_of_week[$i] == '' || $arr_offer_days_of_week[$i] == 'null')
					{
						
						$error = true;
						$err_msg = 'Please select offer days of week - row no '.$j;
						
						$tdata = array();
						$response = array('msg'=>$err_msg,'status'=>0);
						$tdata[] = $response;
						echo json_encode($tdata);
						exit(0);
					}
					*/
					
					$arr_offer_days_of_month[$i] = '';
					$arr_offer_single_date[$i] = '';
					$arr_offer_start_date[$i] = '';
					$arr_offer_end_date[$i] = '';
				}
				elseif($arr_offer_date_type[$i] == 'single_date')
				{
					if($arr_offer_single_date[$i] == '' )
					{
						$error = true;
						$err_msg = 'Please select offer single date - row no '.$j;
						
						$tdata = array();
						$response = array('msg'=>$err_msg,'status'=>0);
						$tdata[] = $response;
						echo json_encode($tdata);
						exit(0);
					}
					
					$arr_offer_days_of_month[$i] = '';
					$arr_offer_days_of_week[$i] = '';
					$arr_offer_start_date[$i] = '';
					$arr_offer_end_date[$i] = '';
				}
				elseif($arr_offer_date_type[$i] == 'date_range')
				{
					if($arr_offer_start_date[$i] == '' )
					{
						$error = true;
						$err_msg = 'Please select offer start date - row no '.$j;
						
						$tdata = array();
						$response = array('msg'=>$err_msg,'status'=>0);
						$tdata[] = $response;
						echo json_encode($tdata);
						exit(0);
					}
					elseif($arr_offer_end_date[$i] == '' )
					{
						$error = true;
						$err_msg = 'Please select offer end date - row no '.$j;
						
						$tdata = array();
						$response = array('msg'=>$err_msg,'status'=>0);
						$tdata[] = $response;
						echo json_encode($tdata);
						exit(0);
					}
					
					$arr_offer_days_of_month[$i] = '';
					$arr_offer_days_of_week[$i] = '';
					$arr_offer_single_date[$i] = '';
				}		
			}
		}
		else
		{
			$arr_offer_price[$i] = '';	
			$arr_offer_date_type[$i] = '';
			$arr_offer_days_of_month[$i] = '';
			$arr_offer_days_of_week[$i] = '';
			$arr_offer_single_date[$i] = '';
			$arr_offer_start_date[$i] = '';
			$arr_offer_end_date[$i] = '';
		}
	}
	
	if(in_array('1',$arr_default_price))
	{
		$temp_default_price_arr = array_count_values($arr_default_price);
		if($temp_default_price_arr[1] > 1)
		{
			$error = true;
			$err_msg = 'Please select only one default price';
			
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
		$err_msg = 'Please select default price yes to anyone';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	for($i=0,$j=1;$i<count($arr_cucat_parent_cat_id);$i++,$j++)
	{
		if($arr_cucat_parent_cat_id[$i] == '')
		{
			$error = true;
			$err_msg = 'Please select main profile - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($arr_cucat_cat_id[$i] == '')
		{
			$error = true;
			$err_msg = 'Please select category - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($arr_cucat_show[$i] == '')
		{
			$error = true;
			$err_msg = 'Please select option - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
	}
	
	$arr_cucat_parent_cat_id_unique = array_unique($arr_cucat_parent_cat_id);
	if(count($arr_cucat_parent_cat_id) != count($arr_cucat_parent_cat_id_unique))
	{
		$error = true;
		$err_msg = 'No duplicate Main profile allow';
	
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	for($i=0,$j=1;$i<count($arr_cw_qt_parent_cat_id);$i++,$j++)
	{
		if($arr_cw_qt_cat_id[$i] == '')
		{
			if($arr_cw_qu_cat_id[$i] == '')
			{
				if($arr_cw_quantity[$i] == '')
				{
				}
				else
				{
					$error = true;
					$err_msg = 'Please select quantity type and quantity unit - row no '.$j;

					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);

				}
			}
			else
			{
				if($arr_cw_quantity[$i] == '')
				{
					$error = true;
					$err_msg = 'Please select quantity type and enter quantity - row no '.$j;

					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);
				}
				else
				{
					$error = true;
					$err_msg = 'Please select quantity type - row no '.$j;

					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);

				}
			}
		}
		else
		{
			if($arr_cw_qu_cat_id[$i] == '')
			{
				if($arr_cw_quantity[$i] == '')
				{
					$error = true;
					$err_msg = 'Please select quantity unit and enter quantity - row no '.$j;

					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);
				}
				else
				{
					$error = true;
					$err_msg = 'Please select quantity unit - row no '.$j;

					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);

				}
			}
			else
			{
				if($arr_cw_quantity[$i] == '')
				{
					$error = true;
					$err_msg = 'Please enter quantity - row no '.$j;

					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);
				}
				else
				{
					
				}
			}
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
	
	if($publish_date_type == '')
	{
		$error = true;
		$err_msg = 'Please select publish date type';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	else
	{
		if($publish_date_type == 'days_of_month')
		{
			if($publish_days_of_month_str == '' || $publish_days_of_month_str == 'null')
			{
				$error = true;
				$err_msg = 'Please select publish days of months';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			$publish_days_of_week_str = '';
			$publish_single_date = '';
			$publish_start_date = '';
			$publish_end_date = '';
		}
		elseif($publish_date_type == 'days_of_week')
		{
			if($publish_days_of_week_str == '' || $publish_days_of_week_str == 'null')
			{
				$error = true;
				$err_msg = 'Please select publish days of week';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			$publish_days_of_month_str = '';
			$publish_single_date = '';
			$publish_start_date = '';
			$publish_end_date = '';
		}
		elseif($publish_date_type == 'single_date')
		{
			if($publish_single_date == '' )
			{
				$error = true;
				$err_msg = 'Please select publish date';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			$publish_days_of_week_str = '';
			$publish_days_of_month_str = '';
			$publish_start_date = '';
			$publish_end_date = '';
		}
		elseif($publish_date_type == 'date_range')
		{
			if($publish_start_date == '' )
			{
				$error = true;
				$err_msg = 'Please select publish start date';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			elseif($publish_end_date == '' )
			{
				$error = true;
				$err_msg = 'Please select publish end date';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			$publish_days_of_week_str = '';
			$publish_days_of_month_str = '';
			$publish_single_date = '';
		}	
	}
	
	if($delivery_date_type == '')
	{
		$error = true;
		$err_msg = 'Please select delivery date type';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	else
	{
		if($delivery_date_type == 'days_of_month')
		{
			if($delivery_days_of_month_str == '' || $delivery_days_of_month_str == 'null')
			{
				$error = true;
				$err_msg = 'Please select delivery days of months';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			$delivery_days_of_week_str = '';
			$delivery_single_date = '';
			$delivery_start_date = '';
			$delivery_end_date = '';
		}
		elseif($delivery_date_type == 'days_of_week')
		{
			if($delivery_days_of_week_str == '' || $delivery_days_of_week_str == 'null')
			{
				$error = true;
				$err_msg = 'Please select delivery days of week';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			$delivery_days_of_month_str = '';
			$delivery_single_date = '';
			$delivery_start_date = '';
			$delivery_end_date = '';
		}
		elseif($delivery_date_type == 'single_date')
		{
			if($delivery_single_date == '' )
			{
				$error = true;
				$err_msg = 'Please select delivery date';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			$delivery_days_of_week_str = '';
			$delivery_days_of_month_str = '';
			$delivery_start_date = '';
			$delivery_end_date = '';
		}
		elseif($delivery_date_type == 'date_range')
		{
			if($delivery_start_date == '' )
			{
				$error = true;
				$err_msg = 'Please select delivery start date';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			elseif($delivery_end_date == '' )
			{
				$error = true;
				$err_msg = 'Please select delivery end date';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			$delivery_days_of_week_str = '';
			$delivery_days_of_month_str = '';
			$delivery_single_date = '';
			
		}	
	}
	
	if($order_cutoff_time == '' )
	{
		$error = true;
		$err_msg = 'Please select cutoff time(hrs)';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	$cusine_image = '';
	if(!$error)
	{
		$picture_size_limit = 5120;
		$error = false;
		$err_msg = '';

		// Define a destination
		$targetFolder = SITE_PATH . '/uploads'; // Relative to the root

		if (!empty($_FILES) )
		{
			$tempFile = $_FILES['cusine_image']['tmp_name'];

			$filename = date('dmYHis') . '_' . $_FILES['cusine_image']['name'];
			$filename = str_replace(' ', '-', $filename);

			$targetPath = $targetFolder;
			$targetFile = rtrim($targetPath, '/') . '/' . $filename;
			$mimetype = $_FILES['cusine_image']['type'];

			// Validate the file type
			$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG'); // File extensions
			$fileParts = pathinfo($_FILES['cusine_image']['name']);

			if (in_array($fileParts['extension'], $fileTypes))
			{
				$cusine_image = $_FILES['cusine_image']['name'];
				$size_in_kb = $_FILES['cusine_image']['size'] / 1024;
				$file4 = substr($cusine_image, -4, 4);
				if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG'))
				{
					$error = true;
					$err_msg = 'Please upload only(jpg/gif/jpeg/png) image ';
				}
				elseif ($size_in_kb > $picture_size_limit)
				{
					$error = true;
					$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb.';
				}

				if (!$error)
				{
					$cusine_image = $filename;

					if (!move_uploaded_file($tempFile, $targetFile))
					{
						if (file_exists($targetFile))
						{
							unlink($targetFile);
						} // Remove temp file
						$error = true;
						$err_msg = 'Couldn\'t upload image';
					}
				}
			}
			else
			{
				$error = true;
				$err_msg = 'Invalid file type';
			}
		}	
		else
		{
			$error = true;
			$err_msg = 'Please upload image';
		}
		
		if($error)
		{
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
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
		
		if($publish_days_of_month_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_publish_days_of_month = explode(',',$publish_days_of_month_str);
			if(in_array('-1', $arr_temp_publish_days_of_month))
			{
				$publish_days_of_month_str = '-1';	
			}	
		}
		
		if($publish_days_of_week_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_publish_days_of_week = explode(',',$publish_days_of_week_str);
			if(in_array('-1', $arr_temp_publish_days_of_week))
			{
				$publish_days_of_week_str = '-1';	
			}	
		}
		
		if($delivery_days_of_month_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_delivery_days_of_month = explode(',',$delivery_days_of_month_str);
			if(in_array('-1', $arr_temp_delivery_days_of_month))
			{
				$delivery_days_of_month_str = '-1';	
			}	
		}
		
		if($delivery_days_of_week_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_delivery_days_of_week = explode(',',$delivery_days_of_week_str);
			if(in_array('-1', $arr_temp_delivery_days_of_week))
			{
				$delivery_days_of_week_str = '-1';	
			}	
		}
		
		if($publish_date_type == 'single_date')
		{
			$publish_single_date = date('Y-m-d',strtotime($publish_single_date));
		}
		elseif($publish_date_type == 'date_range')
		{
			$publish_start_date = date('Y-m-d',strtotime($publish_start_date));
			$publish_end_date = date('Y-m-d',strtotime($publish_end_date));
		}
		
		if($delivery_date_type == 'single_date')
		{
			$delivery_single_date = date('Y-m-d',strtotime($delivery_single_date));
		}
		elseif($delivery_date_type == 'date_range')
		{
			$delivery_start_date = date('Y-m-d',strtotime($delivery_start_date));
			$delivery_end_date = date('Y-m-d',strtotime($delivery_end_date));
		}
		
		
		for($i=0,$j=1;$i<count($arr_vloc_id);$i++,$j++)
		{
			if($arr_is_offer[$i] == '1')
			{
				if($arr_offer_days_of_month[$i] == '')
				{
					if($arr_offer_date_type[$i] == 'days_of_month')
					{
						$arr_offer_days_of_month[$i] = '-1';	
					}
				}
				elseif($arr_offer_days_of_month[$i] == '-1')
				{
					
				}
				else
				{
					$arr_temp_offer_days_of_month = explode(',',$arr_offer_days_of_month[$i]);
					if(in_array('-1', $arr_temp_offer_days_of_month))
					{
						$arr_offer_days_of_month[$i] = '-1';
					}	
				}
				
				if($arr_offer_days_of_week[$i] == '')
				{
					if($arr_offer_date_type[$i] == 'days_of_week')
					{
						$arr_offer_days_of_week[$i] = '-1';	
					}
				}
				elseif($arr_offer_days_of_week[$i] == '-1')
				{
					
				}
				else
				{
					$arr_temp_offer_days_of_week = explode(',',$arr_offer_days_of_week[$i]);
					if(in_array('-1', $arr_temp_offer_days_of_week))
					{
						$arr_offer_days_of_week[$i] = '-1';
					}	
				}
				
				if($arr_offer_date_type[$i] == 'single_date')
				{
					$arr_offer_single_date[$i] = date('Y-m-d',strtotime($arr_offer_single_date[$i]));
				}
				elseif($arr_offer_date_type[$i] == 'date_range')
				{
					$arr_offer_start_date[$i] = date('Y-m-d',strtotime($arr_offer_start_date[$i]));
					$arr_offer_end_date[$i] = date('Y-m-d',strtotime($arr_offer_end_date[$i]));
				}
				
						
			}
			else
			{
				$arr_offer_price[$i] = '';
				$arr_offer_date_type[$i] = '';
				$arr_offer_days_of_month[$i] = '';
				$arr_offer_days_of_week[$i] = '';
				$arr_offer_single_date[$i] = '';
				$arr_offer_start_date[$i] = '';
				$arr_offer_end_date[$i] = '';
			}
		}
				
		
		$tdata = array();
		$tdata['item_id'] = $item_id;
		$tdata['cusine_image'] = $cusine_image;
		$tdata['cusine_type_parent_id'] = $cusine_type_parent_id;
		$tdata['cusine_type_id'] = $cusine_type_id;
		$tdata['min_cart_price'] = $min_cart_price;
		$tdata['vendor_id'] = $vendor_id;
		$tdata['vendor_show'] = $vendor_show;
		$tdata['vloc_id'] = $arr_vloc_id;
		$tdata['ordering_type_id'] = $arr_ordering_type_id;
		$tdata['ordering_size_id'] = $arr_ordering_size_id;
		$tdata['ordering_size_show'] = $arr_ordering_size_show;
		$tdata['max_order'] = $arr_max_order;
		$tdata['min_order'] = $arr_min_order;
		$tdata['cusine_qty'] = $arr_cusine_qty;	
		$tdata['cusine_qty_show'] = $arr_cusine_qty_show;	
		$tdata['sold_qty_show'] = $arr_sold_qty_show;	
		$tdata['currency_id'] = $arr_currency_id;
		$tdata['cusine_price'] = $arr_cusine_price;
		$tdata['default_price'] = $arr_default_price;
		$tdata['is_offer'] = $arr_is_offer;
		$tdata['offer_price'] = $arr_offer_price;
		$tdata['offer_date_type'] = $arr_offer_date_type;
		$tdata['offer_days_of_month'] = $arr_offer_days_of_month;
		$tdata['offer_days_of_week'] = $arr_offer_days_of_week;
		$tdata['offer_single_date'] = $arr_offer_single_date;
		$tdata['offer_start_date'] = $arr_offer_start_date;
		$tdata['offer_end_date'] = $arr_offer_end_date;
		$tdata['cucat_parent_cat_id'] = $arr_cucat_parent_cat_id;
		$tdata['cucat_cat_id'] = $arr_cucat_cat_id;
		$tdata['cucat_show'] = $arr_cucat_show;
		$tdata['cusine_country_id'] = $country_id_str;
		$tdata['cusine_state_id'] = $state_id_str;
		$tdata['cusine_city_id'] = $city_id_str;
		$tdata['cusine_area_id'] = $area_id_str;
		$tdata['publish_date_type'] = $publish_date_type;
		$tdata['publish_days_of_month'] = $publish_days_of_month_str;
		$tdata['publish_days_of_week'] = $publish_days_of_week_str;
		$tdata['publish_single_date'] = $publish_single_date;
		$tdata['publish_start_date'] = $publish_start_date;
		$tdata['publish_end_date'] = $publish_end_date;
		$tdata['delivery_date_type'] = $delivery_date_type;
		$tdata['delivery_days_of_month'] = $delivery_days_of_month_str;
		$tdata['delivery_days_of_week'] = $delivery_days_of_week_str;
		$tdata['delivery_single_date'] = $delivery_single_date;
		$tdata['delivery_start_date'] = $delivery_start_date;
		$tdata['delivery_end_date'] = $delivery_end_date;
		$tdata['order_cutoff_time'] = $order_cutoff_time;
		$tdata['delivery_time'] = $delivery_time;
		$tdata['delivery_time_show'] = $delivery_time_show;
		$tdata['delivery_date_show'] = $delivery_date_show;
		$tdata['cusine_desc_1'] = $cusine_desc_1;
		$tdata['cusine_desc_show_1'] = $cusine_desc_show_1;
		$tdata['cusine_desc_2'] = $cusine_desc_2;
		$tdata['cusine_desc_show_2'] = $cusine_desc_show_2;
		$tdata['cw_qt_parent_cat_id'] = $arr_cw_qt_parent_cat_id;
		$tdata['cw_qt_cat_id'] = $arr_cw_qt_cat_id;
		$tdata['cw_qu_parent_cat_id'] = $arr_cw_qu_parent_cat_id;
		$tdata['cw_qu_cat_id'] = $arr_cw_qu_cat_id;
		$tdata['cw_quantity'] = $arr_cw_quantity;
		$tdata['cw_show'] = $arr_cw_show;
		$tdata['cancel_cutoff_time'] = $cancel_cutoff_time;
		$tdata['cancel_cutoff_time_show'] = $cancel_cutoff_time_show;
		$tdata['cusine_status'] = 1;
		$tdata['added_by_admin'] = $admin_id;
		
		if($obj->addCusine($tdata))
		{
			$msg = 'Record added successfully!';
			$ref_url = "manage_cusines.php?msg=".urlencode($msg);
						
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