<?php

require_once('../classes/config.php');

require_once('../classes/admin.php');

$admin_main_menu_id = '12';

$add_action_id = '28';

$edit_action_id = '29';



$obj = new Admin();

$obj2 = new commonFunctions();

if(!$obj->isAdminLoggedIn())

{

	header("Location: login.php");

	exit(0);

}

else

{

	$admin_id = $_SESSION['admin_id'];

}



if(!$obj->chkIfAccessOfMenu($admin_id,$admin_main_menu_id))

{

	header("Location: invalid.php");

	exit(0);

}



if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))

{

	header("Location: invalid.php");

	exit(0);

}

$publish_show_days_of_month = 'none';

$publish_show_days_of_week = 'none';

$publish_show_single_date = 'none';

$publish_show_start_date = 'none';

$publish_show_end_date = 'none';



$cgst_tax_cat_id = '232';

$sgst_tax_cat_id = '233';

$cess_tax_cat_id = '234';

$gst_tax_cat_id = '231';

if(isset($_GET['event_id']) && $_GET['event_id'] != '')

{

	$event_id = base64_decode($_GET['event_id']);

	$arr_record = $obj->getEventPriceDetails($event_id);

        

//        echo '<pre>';

//        print_r($arr_record);

//        echo '</pre>';

        

	if(count($arr_record) == 0)

	{

		header("Location: manage-event-price.php");

		exit(0);

	}

	

	$event_price_id = $arr_record['event_price_id'];

	$order_cutoff_time = $arr_record['order_cutoff_time']; 

	$cancel_cutoff_time = $arr_record['cancel_cutoff_time']; 

	$cancel_cutoff_time_show = $arr_record['cancel_cutoff_time_show']; 

        $registration_cutoff_time = $arr_record['registration_cutoff_time']; 

	$registration_time_show = $arr_record['registration_time_show']; 

	

	$cgst_tax = $arr_record['cgst_tax']; 

	$sgst_tax = $arr_record['sgst_tax']; 

	$cess_tax = $arr_record['cess_tax']; 

	$gst_tax = $arr_record['gst_tax']; 

	

	

	$arr_ordering_type_id = array();

        $arr_ticket_name = array();

	$arr_ordering_size_id = array();

	$arr_ordering_size_show = array();

	$arr_max_order = array();

	$arr_min_order = array();

	$arr_cusine_qty = array();

	$arr_cusine_qty_show = array();

	$arr_sold_qty_show = array();

	$arr_currency_id = array();

	$arr_cusine_price = array();

	$arr_default_price = array();



	$arr_is_offer = array();

	$arr_offer_price = array();

	$arr_offer_date_type = array();

	$arr_offer_days_of_month = array();

	$arr_offer_days_of_month_str = array();

	$arr_offer_days_of_week = array();

	$arr_offer_days_of_week_str = array();

	$arr_offer_single_date = array();

	$arr_offer_start_date = array();

	$arr_offer_end_date = array();



	$arr_offer_show_days_of_month = array();

	$arr_offer_show_days_of_week = array();

	$arr_offer_show_single_date = array();

	$arr_offer_show_start_date = array();

	$arr_offer_show_end_date = array();

	$arr_offer_show_price_label = array();

	$arr_offer_show_price_value = array();

	$arr_offer_show_date = array();

        

        

        $arr_is_discount = array();

	$arr_discount_code = array();

	$arr_discount_date_type = array();

	$arr_discount_days_of_month = array();

	$arr_discount_days_of_month_str = array();

	$arr_discount_days_of_week = array();

	$arr_discount_days_of_week_str = array();

	$arr_discount_single_date = array();

	$arr_discount_start_date = array();

	$arr_discount_end_date = array();



	$arr_discount_show_days_of_month = array();

	$arr_discount_show_days_of_week = array();

	$arr_discount_show_single_date = array();

	$arr_discount_show_start_date = array();

	$arr_discount_show_end_date = array();

	$arr_discount_show_price_label = array();

	$arr_discount_show_price_value = array();

	$arr_discount_show_date = array();



        $arr_registration_type = array();

        $arr_registration_criteria= array();

        $arr_currency_fees = array();

        $arr_registration_fees = array();

        $arr_registration_show = array();

        $arr_bulk_booking_allowed = array();

	

	$arr_loc_record = $obj->getEventPriceAllLocation($event_price_id);

	if(count($arr_loc_record)>0)

	{

		for($i=0;$i<count($arr_loc_record);$i++)

		{

			array_push($arr_ordering_type_id , $arr_loc_record[$i]['ordering_type_id']);

                        array_push($arr_ticket_name , $arr_loc_record[$i]['ticket_name']);

			array_push($arr_ordering_size_id , $arr_loc_record[$i]['ordering_size_id']);

			array_push($arr_ordering_size_show , $arr_loc_record[$i]['ordering_size_show']);

			array_push($arr_max_order , $arr_loc_record[$i]['max_order']);

			array_push($arr_min_order , $arr_loc_record[$i]['min_order']);

			array_push($arr_cusine_qty , $arr_loc_record[$i]['cusine_qty']); 

			array_push($arr_cusine_qty_show , $arr_loc_record[$i]['cusine_qty_show']); 

			array_push($arr_sold_qty_show , $arr_loc_record[$i]['sold_qty_show']); 

			array_push($arr_currency_id , $arr_loc_record[$i]['currency_id']); 

			array_push($arr_cusine_price , $arr_loc_record[$i]['cusine_price']); 

			array_push($arr_default_price , $arr_loc_record[$i]['default_price']);

                        

                        array_push($arr_registration_type , $arr_loc_record[$i]['registration_type']);

                        array_push($arr_registration_criteria , $arr_loc_record[$i]['registration_criteria']);

                        array_push($arr_currency_fees , $arr_loc_record[$i]['currency_fees']);

                        array_push($arr_registration_fees , $arr_loc_record[$i]['registration_fees']);

                        array_push($arr_registration_show , $arr_loc_record[$i]['registration_show']);

                        array_push($arr_bulk_booking_allowed , $arr_loc_record[$i]['bulk_booking_allowed']);

                        

			

			array_push($arr_is_offer , $arr_loc_record[$i]['is_offer']); 

			if($arr_loc_record[$i]['is_offer'] == '1')

			{

				array_push($arr_offer_show_price_label , ''); 	

				array_push($arr_offer_show_price_value , ''); 	

				array_push($arr_offer_show_date , ''); 	

			}

			else

			{

				array_push($arr_offer_show_price_label , 'none'); 	

				array_push($arr_offer_show_price_value , 'none'); 	

				array_push($arr_offer_show_date , 'none'); 	

			}

			

			array_push($arr_offer_price , $arr_loc_record[$i]['offer_price']); 

			array_push($arr_offer_date_type , $arr_loc_record[$i]['offer_date_type']);

			

			

			$arr_offer_days_of_month[$i] = array();	

			$arr_offer_days_of_week[$i] = array();	

			

			if($arr_loc_record[$i]['offer_date_type'] == 'days_of_month')

			{

				if($arr_loc_record[$i]['offer_days_of_month'] == '-1' || $arr_loc_record[$i]['offer_days_of_month'] == '')

				{

					$arr_offer_days_of_month[$i] = array('-1');	

					array_push($arr_offer_days_of_month_str , '-1');

				}

				else

				{

					$arr_offer_days_of_month[$i] = explode(',',$arr_loc_record[$i]['offer_days_of_month']);	

					array_push($arr_offer_days_of_month_str , $arr_loc_record[$i]['offer_days_of_month']);

				}

				

				$arr_offer_days_of_week[$i] = array('-1');

				array_push($arr_offer_days_of_week_str , '-1');

				array_push($arr_offer_single_date , '');

				array_push($arr_offer_start_date , '');

				array_push($arr_offer_end_date , '');

				

				array_push($arr_offer_show_days_of_month , '');

				array_push($arr_offer_show_days_of_week , 'none');

				array_push($arr_offer_show_single_date , 'none');

				array_push($arr_offer_show_start_date , 'none');

				array_push($arr_offer_show_end_date , 'none');

			}

			elseif($arr_loc_record[$i]['offer_date_type'] == 'days_of_week')

			{

				//echo '<br>'.$arr_loc_record[$i]['offer_days_of_week'];

				if($arr_loc_record[$i]['offer_days_of_week'] == '-1' || $arr_loc_record[$i]['offer_days_of_week'] == '')

				{

					$arr_offer_days_of_week[$i] = array('-1');	

					array_push($arr_offer_days_of_week_str , '-1');

				}

				else

				{

					$arr_offer_days_of_week[$i] = explode(',',$arr_loc_record[$i]['offer_days_of_week']);	

					array_push($arr_offer_days_of_week_str , $arr_loc_record[$i]['offer_days_of_week']);

				}

				

				//echo'<br><pre>';

				//print_r($arr_offer_days_of_week[$i]);

				//echo'<br></pre>';

				

				$arr_offer_days_of_month[$i] = array('-1');

				array_push($arr_offer_days_of_month_str , '-1');

				array_push($arr_offer_single_date , '');

				array_push($arr_offer_start_date , '');

				array_push($arr_offer_end_date , '');

				

				array_push($arr_offer_show_days_of_month , 'none');

				array_push($arr_offer_show_days_of_week , '');

				array_push($arr_offer_show_single_date , 'none');

				array_push($arr_offer_show_start_date , 'none');

				array_push($arr_offer_show_end_date , 'none');

			}

			elseif($arr_loc_record[$i]['offer_date_type'] == 'single_date')

			{

				array_push($arr_offer_single_date , date('d-m-Y',strtotime($arr_loc_record[$i]['offer_single_date'])));

				

				$arr_offer_days_of_month[$i] = array('-1');

				array_push($arr_offer_days_of_month_str , '-1');

				$arr_offer_days_of_week[$i] = array('-1');

				array_push($arr_offer_days_of_week_str , '-1');

				array_push($arr_offer_start_date , '');

				array_push($arr_offer_end_date , '');

				

				array_push($arr_offer_show_days_of_month , 'none');

				array_push($arr_offer_show_days_of_week , 'none');

				array_push($arr_offer_show_single_date , '');

				array_push($arr_offer_show_start_date , 'none');

				array_push($arr_offer_show_end_date , 'none');

			}

			elseif($arr_loc_record[$i]['offer_date_type'] == 'date_range')

			{

				array_push($arr_offer_start_date , date('d-m-Y',strtotime($arr_loc_record[$i]['offer_start_date'])));

				array_push($arr_offer_end_date , date('d-m-Y',strtotime($arr_loc_record[$i]['offer_end_date'])));

				

				$arr_offer_days_of_month[$i] = array('-1');

				array_push($arr_offer_days_of_month_str , '-1');

				$arr_offer_days_of_week[$i] = array('-1');

				array_push($arr_offer_days_of_week_str , '-1');

				array_push($arr_offer_single_date , '');

				

				array_push($arr_offer_show_days_of_month , 'none');

				array_push($arr_offer_show_days_of_week , 'none');

				array_push($arr_offer_show_single_date , 'none');

				array_push($arr_offer_show_start_date , '');

				array_push($arr_offer_show_end_date , '');

			}

			else

			{

				$arr_offer_days_of_month[$i] = array('-1');

				array_push($arr_offer_days_of_month_str , '-1');

				$arr_offer_days_of_week[$i] = array('-1');

				array_push($arr_offer_days_of_week_str , '-1');

				array_push($arr_offer_single_date , '');

				array_push($arr_offer_start_date , '');

				array_push($arr_offer_end_date , '');

				

				array_push($arr_offer_show_days_of_month , 'none');

				array_push($arr_offer_show_days_of_week , 'none');

				array_push($arr_offer_show_single_date , 'none');

				array_push($arr_offer_show_start_date , 'none');

				array_push($arr_offer_show_end_date , 'none');

			}

                        

                        

                        array_push($arr_is_discount , $arr_loc_record[$i]['is_discount_applicable']); 

			if($arr_loc_record[$i]['is_discount_applicable'] == '1')

			{

				array_push($arr_discount_show_price_label , ''); 	

				array_push($arr_discount_show_price_value , ''); 	

				array_push($arr_discount_show_date , ''); 	

			}

			else

			{

				array_push($arr_discount_show_price_label , 'none'); 	

				array_push($arr_discount_show_price_value , 'none'); 	

				array_push($arr_discount_show_date , 'none'); 	

			}

                        

                        array_push($arr_discount_code , $arr_loc_record[$i]['discount_code']); 

			array_push($arr_discount_date_type , $arr_loc_record[$i]['discount_date_type']);

			

			

			$arr_discount_days_of_month[$i] = array();	

			$arr_discount_days_of_week[$i] = array();	

                        

                        if($arr_loc_record[$i]['discount_date_type'] == 'days_of_month')

			{

				if($arr_loc_record[$i]['discount_days_of_month'] == '-1' || $arr_loc_record[$i]['discount_days_of_month'] == '')

				{

					$arr_discount_days_of_month[$i] = array('-1');	

					array_push($arr_discount_days_of_month_str , '-1');

				}

				else

				{

					$arr_discount_days_of_month[$i] = explode(',',$arr_loc_record[$i]['discount_days_of_month']);	

					array_push($arr_discount_days_of_month_str , $arr_loc_record[$i]['discount_days_of_month']);

				}

				

				$arr_discount_days_of_week[$i] = array('-1');

				array_push($arr_discount_days_of_week_str , '-1');

				array_push($arr_discount_single_date , '');

				array_push($arr_discount_start_date , '');

				array_push($arr_discount_end_date , '');

				

				array_push($arr_discount_show_days_of_month , '');

				array_push($arr_discount_show_days_of_week , 'none');

				array_push($arr_discount_show_single_date , 'none');

				array_push($arr_discount_show_start_date , 'none');

				array_push($arr_discount_show_end_date , 'none');

			}

			elseif($arr_loc_record[$i]['discount_date_type'] == 'days_of_week')

			{

				//echo '<br>'.$arr_loc_record[$i]['offer_days_of_week'];

				if($arr_loc_record[$i]['discount_days_of_week'] == '-1' || $arr_loc_record[$i]['discount_days_of_week'] == '')

				{

					$arr_discount_days_of_week[$i] = array('-1');	

					array_push($arr_discount_days_of_week_str , '-1');

				}

				else

				{

					$arr_discount_days_of_week[$i] = explode(',',$arr_loc_record[$i]['discount_days_of_week']);	

					array_push($arr_discount_days_of_week_str , $arr_loc_record[$i]['discount_days_of_week']);

				}

				

				//echo'<br><pre>';

				//print_r($arr_offer_days_of_week[$i]);

				//echo'<br></pre>';

				

				$arr_discount_days_of_month[$i] = array('-1');

				array_push($arr_discount_days_of_month_str , '-1');

				array_push($arr_discount_single_date , '');

				array_push($arr_discount_start_date , '');

				array_push($arr_discount_end_date , '');

				

				array_push($arr_discount_show_days_of_month , 'none');

				array_push($arr_discount_show_days_of_week , '');

				array_push($arr_discount_show_single_date , 'none');

				array_push($arr_discount_show_start_date , 'none');

				array_push($arr_discount_show_end_date , 'none');

			}

			elseif($arr_loc_record[$i]['discount_date_type'] == 'single_date')

			{

				array_push($arr_discount_single_date , date('d-m-Y',strtotime($arr_loc_record[$i]['discount_single_date'])));

				

				$arr_discount_days_of_month[$i] = array('-1');

				array_push($arr_discount_days_of_month_str , '-1');

				$arr_discount_days_of_week[$i] = array('-1');

				array_push($arr_discount_days_of_week_str , '-1');

				array_push($arr_discount_start_date , '');

				array_push($arr_discount_end_date , '');

				

				array_push($arr_discount_show_days_of_month , 'none');

				array_push($arr_discount_show_days_of_week , 'none');

				array_push($arr_discount_show_single_date , '');

				array_push($arr_discount_show_start_date , 'none');

				array_push($arr_discount_show_end_date , 'none');

			}

			elseif($arr_loc_record[$i]['discount_date_type'] == 'date_range')

			{

				array_push($arr_discount_start_date , date('d-m-Y',strtotime($arr_loc_record[$i]['discount_start_date'])));

				array_push($arr_discount_end_date , date('d-m-Y',strtotime($arr_loc_record[$i]['discount_end_date'])));

				

				$arr_discount_days_of_month[$i] = array('-1');

				array_push($arr_discount_days_of_month_str , '-1');

				$arr_discount_days_of_week[$i] = array('-1');

				array_push($arr_discount_days_of_week_str , '-1');

				array_push($arr_discount_single_date , '');

				

				array_push($arr_discount_show_days_of_month , 'none');

				array_push($arr_discount_show_days_of_week , 'none');

				array_push($arr_discount_show_single_date , 'none');

				array_push($arr_discount_show_start_date , '');

				array_push($arr_discount_show_end_date , '');

			}

			else

			{

				$arr_discount_days_of_month[$i] = array('-1');

				array_push($arr_discount_days_of_month_str , '-1');

				$arr_discount_days_of_week[$i] = array('-1');

				array_push($arr_discount_days_of_week_str , '-1');

				array_push($arr_discount_single_date , '');

				array_push($arr_discount_start_date , '');

				array_push($arr_discount_end_date , '');

				

				array_push($arr_discount_show_days_of_month , 'none');

				array_push($arr_discount_show_days_of_week , 'none');

				array_push($arr_discount_show_single_date , 'none');

				array_push($arr_discount_show_start_date , 'none');

				array_push($arr_discount_show_end_date , 'none');

			}	

                        

                        

                        

		}

		$loc_total_cnt = count($arr_loc_record);

		$loc_cnt = $loc_total_cnt - 1;

		

	}

	else

	{

		$loc_cnt = 0;

		$loc_total_cnt = 1;

		$arr_vloc_id = array('');

		$arr_ordering_type_id = array('');

		$arr_ordering_size_id = array('');

		$arr_ordering_size_show = array('');

		$arr_max_order = array('');

		$arr_min_order = array('');

		$arr_cusine_qty = array('');

		$arr_cusine_qty_show = array('');

		$arr_sold_qty_show = array('');

		$arr_currency_id = array('');

		$arr_cusine_price = array('');

		$arr_default_price = array('');

		

		$arr_offer_days_of_month[$i] = array('-1');

		array_push($arr_offer_days_of_month_str , '-1');

		$arr_offer_days_of_week[$i] = array('-1');

		array_push($arr_offer_days_of_week_str , '-1');

		array_push($arr_offer_single_date , '');

		array_push($arr_offer_start_date , '');

		array_push($arr_offer_end_date , '');

		

		array_push($arr_offer_show_days_of_month , 'none');

		array_push($arr_offer_show_days_of_week , 'none');

		array_push($arr_offer_show_single_date , 'none');

		array_push($arr_offer_show_start_date , 'none');

		array_push($arr_offer_show_end_date , 'none');

	}

	

	

	

	$arr_cat_record = $obj->getEventPriceAllCategory($event_price_id);

	$arr_cucat_parent_cat_id = array();

	$arr_cucat_cat_id = array();

	$arr_cucat_show = array();

	if(count($arr_cat_record)>0)

	{

		for($i=0;$i<count($arr_cat_record);$i++)

		{

			array_push($arr_cucat_parent_cat_id, $arr_cat_record[$i]['cucat_parent_cat_id']);

			array_push($arr_cucat_cat_id, $arr_cat_record[$i]['cucat_cat_id']);

			array_push($arr_cucat_show, $arr_cat_record[$i]['cucat_show']);

		}

		$cat_total_cnt = count($arr_cat_record);

		$cat_cnt = $cat_total_cnt - 1;

		

	}

	else

	{

		$cat_cnt = 0;

		$cat_total_cnt = 1;

		$arr_cucat_parent_cat_id = array('');

		$arr_cucat_cat_id = array('');

		$arr_cucat_show = array('');	

	}

	

	

	$cusine_status = $arr_record['event_price_status'];

	$publish_date_type = $arr_record['publish_date_type'];

	$publish_days_of_month = $arr_record['publish_days_of_month'];

	$publish_days_of_week = $arr_record['publish_days_of_week'];

	$publish_single_date = $arr_record['publish_single_date'];

	$publish_start_date = $arr_record['publish_start_date'];

	$publish_end_date = $arr_record['publish_end_date'];

	

	

	$event_desc_1 = $arr_record['event_desc_1'];

	$event_desc_show_1 = $arr_record['event_desc_show_1'];

	$event_desc_2 = $arr_record['event_desc_2'];

	$event_desc_show_2 = $arr_record['event_desc_show_2'];

	

	if($publish_date_type == 'days_of_month')

	{

		if($publish_days_of_month == '-1' || $publish_days_of_month == '')

		{

			$arr_publish_days_of_month = array('-1');	

		}

		else

		{

			$arr_publish_days_of_month = explode(',',$publish_days_of_month);	

		}

		

		$arr_publish_days_of_week = array('-1');

		$publish_single_date = '';

		$publish_start_date = '';

		$publish_end_date = '';	

		

		$publish_show_days_of_month = '';

		$publish_show_days_of_week = 'none';

		$publish_show_single_date = 'none';

		$publish_show_start_date = 'none';

		$publish_show_end_date = 'none';

	}

	elseif($publish_date_type == 'days_of_week')

	{

		if($publish_days_of_week == '-1' || $publish_days_of_week == '')

		{

			$arr_publish_days_of_week = array('-1');	

		}

		else

		{

			$arr_publish_days_of_week = explode(',',$publish_days_of_week);	

		}

		

		$arr_publish_days_of_month = array('-1');

		$publish_single_date = '';

		$publish_start_date = '';

		$publish_end_date = '';	

		

		$publish_show_days_of_month = 'none';

		$publish_show_days_of_week = '';

		$publish_show_single_date = 'none';

		$publish_show_start_date = 'none';

		$publish_show_end_date = 'none';

	}

	elseif($publish_date_type == 'single_date')

	{

		$publish_single_date = date('d-m-Y',strtotime($publish_single_date));

		

		$arr_publish_days_of_month = array('-1');

		$arr_publish_days_of_week = array('-1');

		$publish_start_date = '';

		$publish_end_date = '';	

		

		$publish_show_days_of_month = 'none';

		$publish_show_days_of_week = 'none';

		$publish_show_single_date = '';

		$publish_show_start_date = 'none';

		$publish_show_end_date = 'none';

	}

	elseif($publish_date_type == 'date_range')

	{

		$publish_start_date = date('d-m-Y',strtotime($publish_start_date));

		$publish_end_date = date('d-m-Y',strtotime($publish_end_date));

		

		$arr_publish_days_of_month = array('-1');

		$arr_publish_days_of_week = array('-1');

		$publish_single_date = '';

		

		$publish_show_days_of_month = 'none';

		$publish_show_days_of_week = 'none';

		$publish_show_single_date = 'none';

		$publish_show_start_date = '';

		$publish_show_end_date = '';

	}

	else

	{

		$arr_publish_days_of_month = array('-1');

		$arr_publish_days_of_week = array('-1');

		$publish_single_date = '';

		$publish_start_date = '';

		$publish_end_date = '';	

		

		$publish_show_days_of_month = 'none';

		$publish_show_days_of_week = 'none';

		$publish_show_single_date = 'none';

		$publish_show_start_date = 'none';

		$publish_show_end_date = 'none';

	}

	

}	

else

{

	header("Location: manage-event-price.php");

	exit(0);

}





$event_data = $obj->GETEVENTDETAILSBYID(base64_decode($_GET['event_id']));



?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo SITE_NAME;?> - Admin</title>

	<?php require_once 'head.php'; ?>

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-sm-12">

			<div class="panel">

				<div class="panel-body">

					<div class="row mail-header">

						<div class="col-md-6">

							<h3><?php echo $obj->getAdminActionName($edit_action_id);?>

                                                        </h3>

						</div>

						<div class="col-md-6 text-right">
                                        <?php 
                                           if($cusine_status==1)
                                           {
                                             ?>
                                             <button class="btn btn-danger" type="button" onclick="eventPriceStatus(<?=$arr_record['event_price_id'];?>,0)">Inactivate</button>
                                             <?php
                                           }
                                           else
                                           {
                                            ?>
                                             <button class="btn btn-success" type="button" onclick="eventPriceStatus(<?=$arr_record['event_price_id'];?>,1)">Activate</button>
                                             <?php
                                           }
                                           ?>
                        </div>


                                            <div id="show_data"></div>

					</div>

					<hr>

					<center><div id="error_msg"></div></center>

					<form role="form" class="form-horizontal" id="add_event" name="add_event" method="post" > 

						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">

						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">

						<input type="hidden" name="loc_cnt" id="loc_cnt" value="<?php echo $loc_cnt;?>">

						<input type="hidden" name="loc_total_cnt" id="loc_total_cnt" value="<?php echo $loc_total_cnt;?>">

						<input type="hidden" name="cw_cnt" id="cw_cnt" value="<?php echo $cw_cnt;?>">

						<input type="hidden" name="cw_total_cnt" id="cw_total_cnt" value="<?php echo $cw_total_cnt;?>">

                                                <input type="hidden" name="hdnevent_id" id="hdnevent_id" value="<?php echo base64_decode($_GET['event_id']);?>">

                                                <input type="hidden" name="hdnevent_price_id" id="hdnevent_price_id" value="<?php echo $arr_record['event_price_id'];?>">

						<div class="form-group">

                                                        <label class="col-lg-2 control-label"><b>Event Name :</b></label>

							<label class="col-lg-2 control-label"><?php echo $event_data['event_name']; ?></label>

							<label class="col-lg-2 control-label"><b>Event Ref No :</b></label>

							<label class="col-lg-2 control-label"><?php echo $event_data['reference_number']; ?></label>

                                                        <label class="col-lg-2 control-label"><b>Organiser Name :</b></label>

							<label class="col-lg-2 control-label"><?php echo $obj->getVendorName($event_data['organiser_id']); ?></label>

						</div>

						<div class="form-group">

							<label class="col-lg-2 control-label"><b>Institution Name :</b></label>

							<label class="col-lg-2 control-label"><?php echo $event_data['institution_id']; ?></label>

							<label class="col-lg-2 control-label"><b>City  :</b></label>

							<label class="col-lg-2 control-label"><?php echo $obj->GetCityName($event_data['city_id']); ?></label>

                                                        <label class="col-lg-2 control-label"><b>Venue Details :</b></label>

							<label class="col-lg-2 control-label"><?php echo $event_data['venue_details']; ?></label>

						</div>

						<div class="form-group">

							<label class="col-lg-2 control-label"><b>Start Date/Time :</b></label>

							<label class="col-lg-2 control-label"><?php echo date("d-m-Y",strtotime($event_data['start_date'])).' '.$event_data['start_time']; ?></label>

							<label class="col-lg-2 control-label"><b>End Date/Time :</b></label>

							<label class="col-lg-2 control-label"><?php echo date("d-m-Y",strtotime($event_data['end_date'])).' '.$event_data['end_time']; ?></label>

                                                        

                                                        <label class="col-lg-2 control-label"><b>Status</b><span style="color:red">*</span></label>

							<div class="col-lg-2">

								<select name="cusine_status" id="cusine_status" class="form-control">

									<option value="1" <?php if($cusine_status == '1'){?> selected <?php } ?>>Active</option> 

									<option value="0" <?php if($cusine_status == '0'){?> selected <?php } ?>>Inactive</option> 

								</select>

							</div>



						

						</div>

						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

							<div class="form-group left-label">

								<label class="col-lg-4 control-label"><strong>Inventory and Price Details:</strong></label>

							</div>

							<a href="add_event_price_info.php?event_id=<?=$_GET['event_id'];?>" target="_blank" class="pull-right"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">ADD Pricing details</button></a>
                    <br>
                    <table class="table table-bordered" style="margin-top: 15px;">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Registration</th>
                            <th>Ticket</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(!empty($arr_loc_record))
                            {
                                foreach ($arr_loc_record as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?=$key+1;?></td>
                                        <td>Type: <?=$obj->getFavCategoryNameVivek($value['registration_type']);?> <br>
                                        	Price: <?=$value['registration_fees']?> <br>
                                        	Criteria: <?=$value['registration_criteria']?>
                                        </td>
                                        <td>
                                            Type: <?=$obj->getFavCategoryNameVivek($value['ordering_type_id']);?> <br>
                                        	Price: <?=$value['cusine_price']?> <br>
                                        	Name: <?=$value['ticket_name']?>
                                        </td>
                                         <td>
                                            <?=($value['culoc_status']==1)? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';?>
                                        </td>
                                        <td>
                                            
                                            <a href="edit_event_price_info.php?event_id=<?=$_GET['event_id'];?>&token=<?=base64_encode($value['evlocprice_id']);?>" target="_blank"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">Edit</button></a>

                                            <?php 
                                           if($value['culoc_status']==1)
                                           {
                                             ?>
                                             <button class="btn btn-danger rounded" type="button" onclick="eventPriceInfoStatus(<?=$value['evlocprice_id'];?>,0)">Inactivate</button>
                                             <?php
                                           }
                                           else
                                           {
                                            ?>
                                             <button class="btn btn-success rounded" type="button" onclick="eventPriceInfoStatus(<?=$value['evlocprice_id'];?>,1)">Activate</button>
                                             <?php
                                           }
                                           ?>

                                            
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <tr><td colspan="6" class="text-center">No vendor location found</td></tr>
                                <?php
                            }
                            ?>
                        </tbody>
                      </table>


						</div>

						

						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

							<div class="form-group left-label">

								<label class="col-lg-4 control-label"><strong>Category Details:</strong></label>

							</div>	

						<?php

						for($i=0;$i<$cat_total_cnt;$i++)

						{ ?>

							<div class="form-group" id="row_cat_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">

								<label class="col-lg-2 control-label"><?php if($i == 0) { ?><strong>Category</strong><span style="color:red">*</span><?php } ?></label>

							

								<div class="col-lg-3">

									<select name="cucat_parent_cat_id[]" id="cucat_parent_cat_id_<?php echo $i;?>" onchange="getMainCategoryOptionAddMoreCommon('cucat',<?php echo $i;?>);" class="form-control">

										<?php echo $obj->getMainProfileOption($arr_cucat_parent_cat_id[$i]); ?>

									</select>

								</div>

								<div class="col-lg-3">

									<select name="cucat_cat_id[]" id="cucat_cat_id_<?php echo $i;?>" class="form-control" >

										<?php echo $obj->getMainCategoryOption($arr_cucat_parent_cat_id[$i],$arr_cucat_cat_id[$i]); ?>

									</select>

								</div>

								<div class="col-lg-2">

									<select name="cucat_show[]" id="cucat_show_<?php echo $i;?>" class="form-control" >

										<?php echo $obj->getShowHideOption($arr_cucat_show[$i]); ?>

									</select>

								</div>

								<div class="col-lg-2">

								<?php

								if($i == 0)

								{ ?>

									<a href="javascript:void(0);" onclick="addMoreRowCategory();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>

								<?php  	

								}

								else

								{ ?>

									<a href="javascript:void(0);" onclick="removeRowCategory(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>

								<?php	

								}

								?>	

								</div>

							</div>

						<?php  	

						} ?>	

						</div>	

						

						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

							<div class="form-group left-label">

								<label class="col-lg-4 control-label"><strong>Publish and Delivery Date Details:</strong></label>

							</div>	

							<div class="form-group">

								<label class="col-lg-2 control-label"><strong>Date of Publish</strong><span style="color:red">*</span></label>

							

								<div class="col-lg-4">

									<select name="publish_date_type" id="publish_date_type" onchange="showHideDateDropdowns('publish')" class="form-control" required>

										<?php echo $obj->getDateTypeOption($publish_date_type); ?>

									</select>

								</div>

								<div class="col-lg-3">

									<div id="publish_show_days_of_month" style="display:<?php echo $publish_show_days_of_month;?>">

										<select name="publish_days_of_month" id="publish_days_of_month" multiple="multiple" class="form-control" required >

											<?php echo $obj->getDaysOfMonthOption($arr_publish_days_of_month,'2','1'); ?>

										</select>

									</div>	

									<div id="publish_show_days_of_week" style="display:<?php echo $publish_show_days_of_week;?>">

										<select name="publish_days_of_week" id="publish_days_of_week" multiple="multiple" class="form-control" required >

											<?php echo $obj->getDaysOfWeekOption($arr_publish_days_of_week,'2','1'); ?>

										</select>

									</div>	

									<div id="publish_show_single_date" style="display:<?php echo $publish_show_single_date;?>">

										<input type="text" name="publish_single_date" id="publish_single_date" placeholder="Select Date" value="<?php echo $publish_single_date;?>" class="form-control" required >

									</div>	

									<div id="publish_show_start_date" style="display:<?php echo $publish_show_start_date;?>">

										<input type="text" name="publish_start_date" id="publish_start_date" placeholder="Select Start Date" class="form-control" value="<?php echo $publish_start_date;?>"  required >  

									</div>	

								</div>

								<div class="col-lg-3">

									<div id="publish_show_end_date" style="display:<?php echo $publish_show_end_date;?>">

										<input type="text" name="publish_end_date" id="publish_end_date" placeholder="Select End Date" class="form-control" required value="<?php echo $publish_end_date;?>"> 

									</div>	

								</div>

							</div>

							<div class="form-group">	

								<label class="col-lg-2 control-label"><strong>Registration Cut Off Time</strong><span style="color:red">*</span></label>

								<div class="col-lg-4">

									<select name="registration_cutoff_time" id="registration_cutoff_time" class="form-control" required>

										<?php echo $obj->getCancellationCutOffTimeOption($registration_cutoff_time); ?>

									</select><span>Base Time:  EVENT start time</span><br>

								</div>

                                                                <label class="col-lg-2 control-label"><strong>Show Registration Time</strong></label>

								<div class="col-lg-4">

                                                                    <select name="registration_time_show" id="registration_time_show" class="form-control" required="">

										<?php echo $obj->getShowHideOption($registration_time_show); ?>

									</select>

								</div>

								

							</div>

							<div class="form-group">

								<label class="col-lg-2 control-label"><strong>Cancellation Cut Off Time</strong></label>

								<div class="col-lg-4">

									<select name="cancel_cutoff_time" id="cancel_cutoff_time" class="form-control" required>

										<?php echo $obj->getCancellationCutOffTimeOption($cancel_cutoff_time); ?>

									</select><span>Base Time:  EVENT start time </span><br>

								</div>

								

								<label class="col-lg-2 control-label"><strong>Show Cancellation Cut Off Time</strong></label>

								<div class="col-lg-4">

                                                                    <select name="cancel_cutoff_time_show" id="cancel_cutoff_time_show" class="form-control" required="">

										<?php echo $obj->getShowHideOption($cancel_cutoff_time_show); ?>

									</select>

								</div>

							</div>							

						</div>	

						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

							<div class="form-group left-label">

								<label class="col-lg-3 control-label"><strong>Tax Details(GST/CGST/SGST/CESS):</strong></label>

							</div>

							<div class="form-group">

								<label class="col-lg-2 control-label"><strong>CGST Tax</strong></label>

								<div class="col-lg-4">

									<select name="cgst_tax" id="cgst_tax" class="form-control">

										<?php echo $obj->getTaxOptionByTaxCatId($cgst_tax_cat_id,$cgst_tax); ?>

									</select>

								</div>

							</div>

							<div class="form-group">

								<label class="col-lg-2 control-label"><strong>SGST Tax</strong></label>

								<div class="col-lg-4">

									<select name="sgst_tax" id="sgst_tax" class="form-control">

										<?php echo $obj->getTaxOptionByTaxCatId($sgst_tax_cat_id,$sgst_tax); ?>

									</select>

								</div>

							</div>

							<div class="form-group">

								<label class="col-lg-2 control-label"><strong>CESS Tax</strong></label>

								<div class="col-lg-4">

									<select name="cess_tax" id="cess_tax" class="form-control">

										<?php echo $obj->getTaxOptionByTaxCatId($cess_tax_cat_id,$cess_tax); ?>

									</select>

								</div>

							</div>

							<div class="form-group">

								<label class="col-lg-2 control-label"><strong>GST Tax</strong></label>

								<div class="col-lg-4">

									<select name="gst_tax" id="gst_tax" class="form-control">

										<?php echo $obj->getTaxOptionByTaxCatId($gst_tax_cat_id,$gst_tax); ?>

									</select>

								</div>

							</div>

						</div>	

						<div style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

							<div class="form-group left-label">

								<label class="col-lg-3 control-label"><strong>Other Details:</strong></label>

							</div>

							<div class="form-group"><label class="col-lg-2 control-label"><strong>Event Description 1</strong></label>

								<div class="col-lg-8">

									<textarea id="cusine_desc_1" name="cusine_desc_1" class="form-control"><?php echo $event_desc_1; ?></textarea>

								</div>

								<div class="col-lg-2">

									<select name="cusine_desc_show_1" id="cusine_desc_show_1" class="form-control">

										<?php echo $obj->getShowHideOption($event_desc_show_1); ?>

									</select>

								</div>

							</div>

							

							<div class="form-group"><label class="col-lg-2 control-label"><strong>Event Description 2</strong></label>

								<div class="col-lg-8">

									<textarea id="cusine_desc_2" name="cusine_desc_2" class="form-control"><?php echo $event_desc_2; ?></textarea>

								</div>

								<div class="col-lg-2">

									<select name="cusine_desc_show_2" id="cusine_desc_show_2" class="form-control">

										<?php echo $obj->getShowHideOption($event_desc_show_2); ?>

									</select>

								</div>

							</div>

						</div>	

						<hr>

						<div class="form-group">

							<div class="col-lg-offset-3 col-lg-10">

								<div class="pull-left">

                                                                    

                                                                        <?php if($event_data['admin_type']!='Vendor') { ?>

                                                                    

									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>

									

                                                                        <?php } ?>

                                                                        

                                                                        <a href="manage-event-price.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>

								</div>

							</div>

						</div>

					</form>

				</div>

			</div>

		</div>

	</div>

</div>

<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>

<script type="text/javascript" src="js/jquery.validate.min.js"></script>

<script src="js/tokenize2.js"></script>

<script src="admin-js/edit_event_price.js" type="text/javascript"></script>

<script>

$(document).ready(function()

{ 

	$('.clsdatepicker').datepicker();

	

	function getVendorOptionByItemId()

	{

		var item_id = $('#item_id').val();

		var vendor_id = $('#vendor_id').val();

		

		if(item_id == null)

		{

			item_id = '';

		}

		

		if(vendor_id == null)

		{

			vendor_id = '';

		}

		

		

		var dataString ='item_id='+item_id+'&vendor_id='+vendor_id+'&type=1&multiple=0&action=getvendoroptionbyitemid';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

				//alert(result);

				$("#vendor_id").html(result);

				getVendorLocationOption();

			}

		});

	}



	$('#item_id').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter Item'

	});

	

	$('#item_id').on('tokenize:tokens:add', getVendorOptionByItemId);

	$('#item_id').on('tokenize:tokens:remove', getVendorOptionByItemId);

	

	$('#publish_single_date').datepicker();

	$('#publish_start_date').datepicker();

	$('#publish_end_date').datepicker();

	

	$('#delivery_single_date').datepicker();

	$('#delivery_start_date').datepicker();

	$('#delivery_end_date').datepicker();

	

});



function addMoreRowLocation()

{

	

	var loc_cnt = parseInt($("#loc_cnt").val());

	loc_cnt = loc_cnt + 1;

	

	var new_row = 	'<div id="row_loc_'+loc_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

						

                                                        '<div class="form-group">'+

                                                                '<label class="col-lg-2 control-label">Registration Type<span style="color:red">*</span></label>'+

                                                                '<div class="col-lg-2">'+

                                                                        '<select name="registration_type_id[]" id="registration_type_id_'+loc_cnt+'" class="form-control" required>'+

                                                                                '<?php echo $obj->getFavCategoryRamakant('67',''); ?>'+

                                                                        '</select>'+

                                                                '</div>'+



                                                                '<label class="col-lg-2 control-label">Registration Currency <span style="color:red">*</span></label>'+

                                                                '<div class="col-lg-2">'+

                                                                        '<select name="reg_currency_id[]" id="reg_currency_id_'+loc_cnt+'" class="form-control" required>'+

                                                                                '<?php echo $obj->getCurrencyOption(''); ?>'+

                                                                        '</select>'+

                                                                '</div>'+



                                                                '<label class="col-lg-2 control-label">Registration Fees<span style="color:red">*</span></label>'+

                                                                '<div class="col-lg-2">'+

                                                                        '<input type="text" name="registration_fees[]" id="registration_fees_'+loc_cnt+'" placeholder="Registration Fees" value="" class="form-control" required>'+										

                                                                '</div>'+

                                                        '</div>'+

                                                        '<div class="form-group">'+

                                                                '<label class="col-lg-2 control-label">Registration Criteria<span style="color:red">*</span></label>'+

                                                                '<div class="col-lg-6">'+

                                                                    '<textarea class="form-control" name="registration_criteria[]" id="registration_criteria_'+loc_cnt+'"></textarea>'+

                                                                '</div>'+

                                                                '<label class="col-lg-2 control-label">Show Registration<span style="color:red">*</span></label>'+

                                                                '<div class="col-lg-2">'+

                                                                        '<select name="registration_show[]" id="registration_show_'+loc_cnt+'" class="form-control" required>'+

                                                                                '<?php echo $obj->getShowHideOption(''); ?>'+

                                                                        '</select>'+

                                                                '</div>'+

                                                        '</div>'+

                                                

						'<div class="form-group">'+

							'<label class="col-lg-2 control-label">Ticket Type<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<select name="ordering_type_id[]" id="ordering_type_id_'+loc_cnt+'" class="form-control" required>'+

									'<?php echo $obj->getFavCategoryRamakant('66',''); ?>'+

								'</select>'+

							'</div>'+

						

                                                         '<label class="col-lg-2 control-label">Ticket Name<span style="color:red">*</span></label>'+

                                                                        '<div class="col-lg-2">'+

                                                                                '<input type="text" name="ticket_name[]" id="ticket_name_'+loc_cnt+'" placeholder="Registration Fees"  class="form-control">'+										

									'</div>'+

                                                

						'</div>'+

						

						'<div class="form-group">'+

                                                

                                                        '<label class="col-lg-2 control-label">Bulk booking allowed?<span style="color:red">*</span></label>'+

                                                            '<div class="col-lg-2">'+

                                                                    '<select name="is_bulk_booking[]" id="is_bulk_booking_'+loc_cnt+'" class="form-control">'+

                                                                            '<?php echo $obj->getYesNoOption(''); ?>'+

                                                                    '</select>'+

                                                            '</div>'+

                                                        

							'<label class="col-lg-2 control-label">Max Order Quantity<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<input type="text" name="max_order[]" id="max_order_'+loc_cnt+'" placeholder="Max Order Quantity" value="" class="form-control" required>'+

							'</div>'+

						

							'<label class="col-lg-2 control-label">Min Order Quantity<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<input type="text" name="min_order[]" id="min_order_'+loc_cnt+'" placeholder="Min Order Quantity" value="" class="form-control" required>'+

							'</div>'+

						'</div>'+

						

						'<div class="form-group">'+

							'<label class="col-lg-2 control-label">Total Stock Quantity<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<input type="text" name="cusine_qty[]" id="cusine_qty_'+loc_cnt+'" placeholder="Total Stock Quantity" value="" class="form-control" required>'+

							'</div>'+

						

							'<label class="col-lg-2 control-label">Show Current Stock<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<select name="cusine_qty_show[]" id="cusine_qty_show_'+loc_cnt+'" class="form-control" required>'+

									'<?php echo $obj->getShowHideOption(''); ?>'+

								'</select>'+

							'</div>'+

							

							'<label class="col-lg-2 control-label">Show Sold Quantity<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<select name="sold_qty_show[]" id="sold_qty_show_'+loc_cnt+'" class="form-control" required>'+

									'<?php echo $obj->getShowHideOption(''); ?>'+

								'</select>'+

							'</div>'+

						'</div>'+

						

						'<div class="form-group">'+

							'<label class="col-lg-2 control-label">Currency<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<select name="currency_id[]" id="currency_id_'+loc_cnt+'" class="form-control" required>'+

									'<?php echo $obj->getCurrencyOption(''); ?>'+

								'</select>'+

							'</div>'+

							

							'<label class="col-lg-2 control-label">Price<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<input type="text" name="ticket_price[]" id="ticket_price_'+loc_cnt+'" placeholder="Price" value="" class="form-control" required>'+

							'</div>'+

							

							'<label class="col-lg-2 control-label">Default Price<span style="color:red">*</span></label>'+

							'<div class="col-lg-2">'+

								'<select name="default_price[]" id="default_price_'+loc_cnt+'" class="form-control" required>'+

									'<?php echo $obj->getDefaultPriceOption(''); ?>'+

								'</select>'+

							'</div>'+

						'</div>'+

						'<div class="form-group">'+

							'<label class="col-lg-2 control-label">Is Offer Item?</label>'+

							'<div class="col-lg-2">'+

								'<select name="is_offer[]" id="is_offer_'+loc_cnt+'" class="form-control" onchange="toggleOfferDetails(\''+loc_cnt+'\')">'+

									'<?php echo $obj->getYesNoOption(''); ?>'+

								'</select>'+

							'</div>'+

							'<label class="col-lg-2 control-label" id="offer_show_price_label_'+loc_cnt+'" style="display:none;">Offer Price<span style="color:red">*</span></label>'+

							'<div class="col-lg-2" id="offer_show_price_value_'+loc_cnt+'" style="display:none;">'+

								'<input type="text" name="offer_price[]" id="offer_price_'+loc_cnt+'" placeholder="Offer Price" value="" class="form-control">'+

							'</div>'+

						'</div>'+

						'<div class="form-group" id="offer_show_date_'+loc_cnt+'" style="display:none;">'+

							'<label class="col-lg-2 control-label">Offer Date<span style="color:red">*</span></label>'+

							'<div class="col-lg-4">'+

								'<select name="offer_date_type[]" id="offer_date_type_'+loc_cnt+'" onchange="showHideDateDropdownsMulti(\'offer\',\''+loc_cnt+'\')" class="form-control">'+

									'<?php echo $obj->getDateTypeOption(''); ?>'+

								'</select>'+

							'</div>'+

							'<div class="col-lg-3">'+

								'<div id="offer_show_days_of_month_'+loc_cnt+'" style="display:none">'+

									'<input type="hidden" name="offer_days_of_month_str[]" id="offer_days_of_month_str_'+loc_cnt+'" value="">'+

									'<select name="offer_days_of_month[]" id="offer_days_of_month_'+loc_cnt+'" onchange="setDaysOfMonthStrMulti(\''+loc_cnt+'\')" multiple="multiple" class="form-control">'+

										'<?php echo $obj->getDaysOfMonthOption(array('-1'),'2','1'); ?>'+

									'</select>'+

								'</div>'+	

								'<div id="offer_show_days_of_week_'+loc_cnt+'" style="display:none;">'+

									'<input type="hidden" name="offer_days_of_week_str[]" id="offer_days_of_week_str_'+loc_cnt+'" value="">'+

									'<select name="offer_days_of_week[]" id="offer_days_of_week_'+loc_cnt+'" onchange="setDaysOfWeekStrMulti(\''+loc_cnt+'\')" multiple="multiple" class="form-control" >'+

										'<?php echo $obj->getDaysOfWeekOption(array('-1'),'2','1'); ?>'+

									'</select>'+

								'</div>	'+

								'<div id="offer_show_single_date_'+loc_cnt+'" style="display:none;">'+

									'<input type="text" name="offer_single_date[]" id="offer_single_date_'+loc_cnt+'" value="" placeholder="Select Date" class="form-control clsdatepicker" >'+

								'</div>'+	

								'<div id="offer_show_start_date_'+loc_cnt+'" style="display:none;">'+

									'<input type="text" name="offer_start_date[]" id="offer_start_date_'+loc_cnt+'" value="" placeholder="Select Start Date" class="form-control clsdatepicker">'+  

								'</div>'+	

							'</div>'+

							'<div class="col-lg-3">'+

								'<div id="offer_show_end_date_'+loc_cnt+'" style="display:none;">'+

									'<input type="text" name="offer_end_date[]" id="offer_end_date_'+loc_cnt+'" value="" placeholder="Select End Date" class="form-control clsdatepicker">'+ 

								'</div>'+	

							'</div>'+

						'</div>'+

                                                

                                                '<div class="form-group">'+

                                                        '<label class="col-lg-2 control-label">Is Discount Available?</label>'+

                                                        '<div class="col-lg-2">'+

                                                                '<select name="is_discount[]" id="is_discount_'+loc_cnt+'" class="form-control" onchange="toggleDiscountDetails(\''+loc_cnt+'\')">'+

                                                                        '<?php echo $obj->getYesNoOption(''); ?>'+

                                                                '</select>'+

                                                        '</div>'+



                                                        '<label class="col-lg-2 control-label" id="offer_show_price_label_'+loc_cnt+'" style="display:none;">Discount Code<span style="color:red">*</span></label>'+

                                                        '<div class="col-lg-4" id="discount_show_price_value_'+loc_cnt+'" style="display:none">'+



                                                                '<select name="discount_code[]" id="discount_code_'+loc_cnt+'" class="form-control" >'+

                                                                    '<option value="">Select Discount Code</option>'+   

                                                                    '<?php echo $obj->getCouponOptions(''); ?>'+

                                                                '</select>'+

                                                        '</div>'+

                                                '</div>'+

                                                

                                                

                                                '<div class="form-group" id="discount_show_date_'+loc_cnt+'" style="display:none;">'+

                                                        '<label class="col-lg-2 control-label">Discount Date<span style="color:red">*</span></label>'+

                                                        '<div class="col-lg-4">'+

                                                                '<select name="discount_date_type[]" id="discount_date_type_'+loc_cnt+'" onchange="showHideDateDropdownsMulti(\'discount\',\''+loc_cnt+'\')" class="form-control">'+

                                                                        '<?php echo $obj->getDateTypeOption(''); ?>'+

                                                                '</select>'+

                                                        '</div>'+

                                                        '<div class="col-lg-3">'+

                                                                '<div id="discount_show_days_of_month_'+loc_cnt+'" style="display:none;">'+

                                                                        '<input type="hidden" name="discount_days_of_month_str[]" id="discount_days_of_month_str_'+loc_cnt+'" >'+

                                                                        '<select name="discount_days_of_month[]" id="discount_days_of_month_'+loc_cnt+'" onchange="setDaysOfMonthStrMulti(\''+loc_cnt+'\')" multiple="multiple" class="form-control">'+

                                                                               '<?php echo $obj->getDaysOfMonthOption(array('-1'),'2','1'); ?>'+

                                                                        '</select>'+

                                                                '</div>'+

                                                                '<div id="discount_show_days_of_week_'+loc_cnt+'" style="display:none;">'+

                                                                        '<input type="hidden" name="discount_days_of_week_str[]" id="discount_days_of_week_str_'+loc_cnt+'" >'+

                                                                        '<select name="discount_days_of_week[]" id="discount_days_of_week_'+loc_cnt+'" onchange="setDaysOfWeekStrMulti(\''+loc_cnt+'\')" multiple="multiple" class="form-control" >'+

                                                                                '<?php echo $obj->getDaysOfWeekOption(array('-1'),'2','1'); ?>'+

                                                                        '</select>'+

                                                                '</div>'+

                                                                '<div id="discount_show_single_date_'+loc_cnt+'" style="display:none;">'+

                                                                        '<input type="text" name="discount_single_date[]" id="offer_single_date_'+loc_cnt+'" placeholder="Select Date" class="form-control clsdatepicker" >'+

                                                                '</div>'+	

                                                                '<div id="discount_show_start_date_'+loc_cnt+'" style="display:none;">'+

                                                                        '<input type="text" name="discount_start_date[]" id="discount_start_date_'+loc_cnt+'"  placeholder="Select Start Date" class="form-control clsdatepicker">'+ 

                                                                '</div>'+	

                                                        '</div>'+

                                                        '<div class="col-lg-3">'+

                                                                '<div id="discount_show_end_date_'+loc_cnt+'" style="display:none;">'+

                                                                        '<input type="text" name="discount_end_date[]" id="offer_end_date_'+loc_cnt+'"  placeholder="Select End Date" class="form-control clsdatepicker">'+

                                                                '</div>'+	

                                                        '</div>'+

                                                '</div>'+

                                                

                                                

						'<div class="form-group">'+

							'<div class="col-lg-2">'+

								'<a href="javascript:void(0);" onclick="removeRowLocation('+loc_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

							'</div>'+

						'</div>'+

					'</div>';	

	

	$("#row_loc_first").after(new_row);

	getVendorLocationOption('1','0','0','vloc_id_'+loc_cnt);

	

	$("#loc_cnt").val(loc_cnt);

	

	var loc_total_cnt = parseInt($("#loc_total_cnt").val());

	loc_total_cnt = loc_total_cnt + 1;

	$("#loc_total_cnt").val(loc_total_cnt);

	

	$('.clsdatepicker').datepicker();

}



function removeRowLocation(idval)

{

	$("#row_loc_"+idval).remove();



	var loc_total_cnt = parseInt($("#loc_total_cnt").val());

	loc_total_cnt = loc_total_cnt - 1;

	$("#loc_total_cnt").val(loc_total_cnt);

}



function addMoreRowCategory()

{

	var cat_cnt = parseInt($("#cat_cnt").val());

	cat_cnt = cat_cnt + 1;

	//alert("cat_cnt"+cat_cnt);

	$("#row_cat_first").after('<div class="form-group" id="row_cat_'+cat_cnt+'"><label class="col-lg-2 control-label"></label><div class="col-lg-3"><select name="cucat_parent_cat_id[]" id="cucat_parent_cat_id_'+cat_cnt+'" onchange="getMainCategoryOptionAddMoreCommon(\'cucat\','+cat_cnt+')" class="form-control" required>'+'<?php echo $obj->getMainProfileOption(''); ?>'+'</select></div><div class="col-lg-3"><select name="cucat_cat_id[]" id="cucat_cat_id_'+cat_cnt+'" class="form-control" required>'+'<?php echo $obj->getMainCategoryOption('',''); ?>'+'</select></div><div class="col-lg-2"><select name="cucat_show[]" id="cucat_show_'+cat_cnt+'" class="form-control" required>'+'<?php echo $obj->getShowHideOption('');?>'+'</select></div><div class="col-lg-2"><a href="javascript:void(0);" onclick="removeRowCategory('+cat_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a></div></div>');

	$("#cat_cnt").val(cat_cnt);

	

	var cat_total_cnt = parseInt($("#cat_total_cnt").val());

	cat_total_cnt = cat_total_cnt + 1;

	$("#cat_total_cnt").val(cat_total_cnt);

}



function removeRowCategory(idval)

{

	//alert("row_cat_"+idval);

	$("#row_cat_"+idval).remove();

	

	var cat_total_cnt = parseInt($("#cat_total_cnt").val());

	cat_total_cnt = cat_total_cnt - 1;

	$("#cat_total_cnt").val(cat_total_cnt);

}



function addMoreRowWeight()

{

	var cw_cnt = parseInt($("#cw_cnt").val());

	cw_cnt = cw_cnt + 1;

	//alert("cw_cnt"+cw_cnt);

	$("#row_cw_first").after('<?php echo $add_more_row_cw_str;?>');

	$("#cw_cnt").val(cw_cnt);

	

	var cw_total_cnt = parseInt($("#cw_total_cnt").val());

	cw_total_cnt = cw_total_cnt + 1;

	$("#cw_total_cnt").val(cw_total_cnt);

}



function removeRowWeight(idval)

{

	//alert("row_cw_"+idval);

	$("#row_cw_"+idval).remove();

	

	var cw_total_cnt = parseInt($("#cw_total_cnt").val());

	cw_total_cnt = cw_total_cnt - 1;

	$("#cw_total_cnt").val(cw_total_cnt);

}


	 function eventPriceStatus(id,status)
    {

        var action='eventPriceStatus';
        $.ajax({
           url: 'ajax/remote.php',
           type: 'POST',
           data: {id: id, status: status, action:action},
           error: function() {
              alert('Something is wrong');
           },
           success: function(res) {
                alert(res);
                location.reload();
           }
        });
    }

    function eventPriceInfoStatus(id,status)
    {

        var action='eventPriceInfoStatus';
        $.ajax({
           url: 'ajax/remote.php',
           type: 'POST',
           data: {id: id, status: status, action:action},
           error: function() {
              alert('Something is wrong');
           },
           success: function(res) {
                alert(res);
                location.reload();
           }
        });
    }

       

</script>

</body>

</html>