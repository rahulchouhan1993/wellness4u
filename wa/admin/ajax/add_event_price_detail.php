<?php

include_once('../../classes/config.php');

include_once('../../classes/admin.php');

$obj = new Admin();

if(!$obj->isAdminLoggedIn())

{

	exit(0);

}



$admin_id= $_SESSION['admin_id'];

$add_action_id = '28';



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

	$event_id = strip_tags(trim($_POST['hdnevent_id']));
	$event_price_id = strip_tags(trim($_POST['hdnevent_price_id']));

	$arr_registration_type_id = array();

	if(isset($_POST['registration_type_id']))

	{

		foreach($_POST['registration_type_id'] as $key => $val)

		{

			array_push($arr_registration_type_id,$val);

		}		

	}

        

        $arr_reg_currency_id = array();

	if(isset($_POST['reg_currency_id']))

	{

		foreach($_POST['reg_currency_id'] as $key => $val)

		{

			array_push($arr_reg_currency_id,$val);

		}		

	}

        

        $arr_registration_fees = array();

	if(isset($_POST['registration_fees']))

	{

		foreach($_POST['registration_fees'] as $key => $val)

		{

			array_push($arr_registration_fees,$val);

		}		

	}

        

        $arr_registration_criteria = array();

	if(isset($_POST['registration_criteria']))

	{

		foreach($_POST['registration_criteria'] as $key => $val)

		{

			array_push($arr_registration_criteria,$val);

		}		

	}

        

        $arr_registration_show = array();

	if(isset($_POST['registration_show']))

	{

		foreach($_POST['registration_show'] as $key => $val)

		{

			array_push($arr_registration_show,$val);

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

	

        $arr_ticket_name = array();

	if(isset($_POST['ticket_name']))

	{

		foreach($_POST['ticket_name'] as $key => $val)

		{

			array_push($arr_ticket_name,$val);

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

	

	$arr_ticket_price = array();

	if(isset($_POST['ticket_price']))

	{

		foreach($_POST['ticket_price'] as $key => $val)

		{

			array_push($arr_ticket_price,$val);

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

	

        

        $arr_is_bulk_booking = array();

	if(isset($_POST['is_bulk_booking']))

	{

		foreach($_POST['is_bulk_booking'] as $key => $val)

		{

			array_push($arr_is_bulk_booking,$val);

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

	

        

        

        $arr_is_discount = array();

	if(isset($_POST['is_discount']))

	{

		foreach($_POST['is_discount'] as $key => $val)

		{

			array_push($arr_is_discount,$val);

		}		

	}

	

	$arr_discount_code = array();

	if(isset($_POST['discount_code']))

	{

		foreach($_POST['discount_code'] as $key => $val)

		{

			array_push($arr_discount_code,$val);

		}		

	}

	

	$arr_discount_date_type = array();

	if(isset($_POST['discount_date_type']))

	{

		foreach($_POST['discount_date_type'] as $key => $val)

		{

			array_push($arr_discount_date_type,$val);

		}		

	}

	

	$arr_discount_days_of_month = array();

	if(isset($_POST['discount_days_of_month_str']))

	{

		foreach($_POST['discount_days_of_month_str'] as $key => $val)

		{

			array_push($arr_discount_days_of_month,$val);

		}		

	}

	

	$arr_discount_days_of_week = array();

	if(isset($_POST['discount_days_of_week_str']))

	{

		foreach($_POST['discount_days_of_week_str'] as $key => $val)

		{

			array_push($arr_discount_days_of_week,$val);

		}		

	}

	

	$arr_discount_single_date = array();

	if(isset($_POST['discount_single_date']))

	{

		foreach($_POST['discount_single_date'] as $key => $val)

		{

			array_push($arr_discount_single_date,$val);

		}		

	}

	

	$arr_discount_start_date = array();

	if(isset($_POST['discount_start_date']))

	{

		foreach($_POST['discount_start_date'] as $key => $val)

		{

			array_push($arr_discount_start_date,$val);

		}		

	}

	

	$arr_discount_end_date = array();

	if(isset($_POST['discount_end_date']))

	{

		foreach($_POST['discount_end_date'] as $key => $val)

		{

			array_push($arr_discount_end_date,$val);

		}		

	}


	

	// if($registration_cutoff_time == '' )

	// {

	// 	$error = true;

	// 	$err_msg = 'Please select cutoff time(hrs)';

		

	// 	$tdata = array();

	// 	$response = array('msg'=>$err_msg,'status'=>0);

	// 	$tdata[] = $response;

	// 	echo json_encode($tdata);

	// 	exit(0);

	// }

	

	

	if(!$error)

	{

		

		for($i=0,$j=1;$i<count($arr_registration_type_id);$i++,$j++)

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

				

		

                for($i=0,$j=1;$i<count($arr_registration_type_id);$i++,$j++)

		{

			if($arr_is_discount[$i] == '1')

			{

				if($arr_discount_days_of_month[$i] == '')

				{

					if($arr_discount_date_type[$i] == 'days_of_month')

					{

						$arr_discount_days_of_month[$i] = '-1';	

					}

				}

				elseif($arr_discount_days_of_month[$i] == '-1')

				{

					

				}

				else

				{

					$arr_temp_discount_days_of_month = explode(',',$arr_discount_days_of_month[$i]);

					if(in_array('-1', $arr_temp_discount_days_of_month))

					{

						$arr_discount_days_of_month[$i] = '-1';

					}	

				}

				

				if($arr_discount_days_of_week[$i] == '')

				{

					if($arr_discount_date_type[$i] == 'days_of_week')

					{

						$arr_discount_days_of_week[$i] = '-1';	

					}

				}

				elseif($arr_discount_days_of_week[$i] == '-1')

				{

					

				}

				else

				{

					$arr_temp_discount_days_of_week = explode(',',$arr_discount_days_of_week[$i]);

					if(in_array('-1', $arr_temp_offer_days_of_week))

					{

						$arr_discount_days_of_week[$i] = '-1';

					}	

				}

				

				if($arr_discount_date_type[$i] == 'single_date')

				{

					$arr_discount_single_date[$i] = date('Y-m-d',strtotime($arr_discount_single_date[$i]));

				}

				elseif($arr_discount_date_type[$i] == 'date_range')

				{

					$arr_discount_start_date[$i] = date('Y-m-d',strtotime($arr_discount_start_date[$i]));

					$arr_discount_end_date[$i] = date('Y-m-d',strtotime($arr_discount_end_date[$i]));

				}

				

						

			}

			else

			{

				$arr_discount_code[$i] = '';

				$arr_discount_date_type[$i] = '';

				$arr_discount_days_of_month[$i] = '';

				$arr_discount_days_of_week[$i] = '';

				$arr_discount_single_date[$i] = '';

				$arr_discount_start_date[$i] = '';

				$arr_discount_end_date[$i] = '';

			}

		}

                

                

		$tdata = array();

		$tdata['event_id'] = $event_id;

		$tdata['event_price_id'] = $event_price_id;

		$tdata['registration_type_id'] = $arr_registration_type_id;

                

                $tdata['reg_currency_id'] =$arr_reg_currency_id;

                $tdata['registration_fees'] =$arr_registration_fees;

                $tdata['registration_criteria'] =$arr_registration_criteria;

                $tdata['registration_show'] =$arr_registration_show;

                

		$tdata['ordering_type_id'] = $arr_ordering_type_id;

                $tdata['ticket_name'] = $arr_ticket_name;

//		$tdata['ordering_size_id'] = $arr_ordering_size_id;

//		$tdata['ordering_size_show'] = $arr_ordering_size_show;

		$tdata['max_order'] = $arr_max_order;

		$tdata['min_order'] = $arr_min_order;

		$tdata['cusine_qty'] = $arr_cusine_qty;	

		$tdata['cusine_qty_show'] = $arr_cusine_qty_show;	

		$tdata['sold_qty_show'] = $arr_sold_qty_show;	

		$tdata['currency_id'] = $arr_currency_id;

		$tdata['ticket_price'] = $arr_ticket_price;

		$tdata['default_price'] = $arr_default_price;

		$tdata['is_offer'] = $arr_is_offer;

		$tdata['offer_price'] = $arr_offer_price;

		$tdata['offer_date_type'] = $arr_offer_date_type;

		$tdata['offer_days_of_month'] = $arr_offer_days_of_month;

		$tdata['offer_days_of_week'] = $arr_offer_days_of_week;

		$tdata['offer_single_date'] = $arr_offer_single_date;

		$tdata['offer_start_date'] = $arr_offer_start_date;

		$tdata['offer_end_date'] = $arr_offer_end_date;


                $tdata['is_discount'] = $arr_is_discount;

                $tdata['is_bulk_booking'] = $arr_is_bulk_booking;



		$tdata['discount_date_type'] = $arr_discount_date_type;

		$tdata['discount_days_of_month'] = $arr_discount_days_of_month;

		$tdata['discount_days_of_week'] = $arr_discount_days_of_week;

		$tdata['discount_single_date'] = $arr_discount_single_date;

		$tdata['discount_start_date'] = $arr_discount_start_date;

		$tdata['discount_end_date'] = $arr_discount_end_date;

                $tdata['discount_code'] = $arr_discount_code;

                

		$tdata['order_cutoff_time'] = $order_cutoff_time;


		$tdata['event_status'] = 1;

		$tdata['added_by_admin'] = $admin_id;


	// 		echo "<pre>";

	// print_r($tdata);

	// die('--sfasfsss13');

		

		if($obj->addEventPriceDetail($tdata))

		{

			$msg = 'Record added successfully!';

			// $ref_url = "manage_cusines.php?msg=".urlencode($msg);
			//update by ample 15-09-20
			$ref_url = "edit_event_price.php?event_id=".base64_encode($event_id)."&msg=".urlencode($msg);


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