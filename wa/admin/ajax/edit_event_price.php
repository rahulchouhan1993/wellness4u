<?php

include_once('../../classes/config.php');

include_once('../../classes/admin.php');

$obj = new Admin();

if(!$obj->isAdminLoggedIn())

{

	exit(0);

}



$admin_id = $_SESSION['admin_id'];

$edit_action_id = '29';



if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))

{

	$tdata = array();

	$response = array('msg'=>'Sorry you dont have access.','status'=>0);

	$tdata[] = $response;

	echo json_encode($tdata);

	exit(0);

}



//$obj->debuglog('[ADD_CUISINE] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>, FILES:<pre>'.print_r($_FILES,true).'</pre>');



$error = false;

$err_msg = '';



if(isset($_POST['btnSubmit']))

{



	$event_id = strip_tags(trim($_POST['hdnevent_id']));

        $event_price_id = strip_tags(trim($_POST['hdnevent_price_id']));

	$cgst_tax = strip_tags(trim($_POST['cgst_tax']));

	$sgst_tax = strip_tags(trim($_POST['sgst_tax']));

	$cess_tax = strip_tags(trim($_POST['cess_tax']));

	$gst_tax = strip_tags(trim($_POST['gst_tax']));



        

        




	


        

        

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

	

	

	$publish_date_type = strip_tags(trim($_POST['publish_date_type']));

	$publish_days_of_month_str = strip_tags(trim($_POST['publish_days_of_month_str']));

	$publish_days_of_week_str = strip_tags(trim($_POST['publish_days_of_week_str']));

	$publish_single_date = strip_tags(trim($_POST['publish_single_date']));

	$publish_start_date = strip_tags(trim($_POST['publish_start_date']));

	$publish_end_date = strip_tags(trim($_POST['publish_end_date']));

	$cancel_cutoff_time = strip_tags(trim($_POST['cancel_cutoff_time']));

	$cancel_cutoff_time_show = strip_tags(trim($_POST['cancel_cutoff_time_show']));

        $registration_cutoff_time = strip_tags(trim($_POST['registration_cutoff_time']));

        $registration_time_show = strip_tags(trim($_POST['registration_time_show']));

	$cusine_desc_1 = strip_tags(trim($_POST['cusine_desc_1']));

	$cusine_desc_show_1 = strip_tags(trim($_POST['cusine_desc_show_1']));

	$cusine_desc_2 = strip_tags(trim($_POST['cusine_desc_2']));

	$cusine_desc_show_2 = strip_tags(trim($_POST['cusine_desc_show_2']));

        $event_status = strip_tags(trim($_POST['cusine_status']));

	

	

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

	

	

	

	if(!$error)

	{

	

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

		

		if($publish_date_type == 'single_date')

		{

			$publish_single_date = date('Y-m-d',strtotime($publish_single_date));

		}

		elseif($publish_date_type == 'date_range')

		{

			$publish_start_date = date('Y-m-d',strtotime($publish_start_date));

			$publish_end_date = date('Y-m-d',strtotime($publish_end_date));

		}

		

		$tdata = array();

		$tdata['event_id'] = $event_id;

                $tdata['event_price_id'] = $event_price_id;

	
		$tdata['cucat_parent_cat_id'] = $arr_cucat_parent_cat_id;

		$tdata['cucat_cat_id'] = $arr_cucat_cat_id;

		$tdata['cucat_show'] = $arr_cucat_show;

                

		$tdata['publish_date_type'] = $publish_date_type;

		$tdata['publish_days_of_month'] = $publish_days_of_month_str;

		$tdata['publish_days_of_week'] = $publish_days_of_week_str;

		$tdata['publish_single_date'] = $publish_single_date;

		$tdata['publish_start_date'] = $publish_start_date;

		$tdata['publish_end_date'] = $publish_end_date;

		$tdata['order_cutoff_time'] = $order_cutoff_time;

		$tdata['cusine_desc_1'] = $cusine_desc_1;

		$tdata['cusine_desc_show_1'] = $cusine_desc_show_1;

		$tdata['cusine_desc_2'] = $cusine_desc_2;

		$tdata['cusine_desc_show_2'] = $cusine_desc_show_2;

		$tdata['cancel_cutoff_time'] = $cancel_cutoff_time;

		$tdata['cancel_cutoff_time_show'] = $cancel_cutoff_time_show;

                $tdata['registration_cutoff_time'] = $registration_cutoff_time;

		$tdata['registration_time_show'] =   $registration_time_show;

                

		$tdata['cgst_tax'] = $cgst_tax;

		$tdata['sgst_tax'] = $sgst_tax;

		$tdata['cess_tax'] = $cess_tax;

		$tdata['gst_tax'] = $gst_tax;

		$tdata['event_status'] = $event_status;

		$tdata['modified_by_admin'] = $admin_id;

		

		if($obj->updateEventPrice($tdata))

		{

			$msg = 'Record updated successfully!';

			$ref_url = "manage_event_price.php?msg=".urlencode($msg);

						

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