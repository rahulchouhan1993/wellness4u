<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$edit_action_id = '52';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[EDIT_ORDER] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$invoice = trim($_POST['hdninvoice']);
	$order_status = strip_tags(trim($_POST['order_status']));
	$payment_status = strip_tags(trim($_POST['payment_status']));
	$order_note = strip_tags(trim($_POST['order_note']));
	$send_email_to_user = strip_tags(trim($_POST['send_email_to_user']));
	
	if($order_status == '')
	{
		$error = true;
		$err_msg = 'Please select order status';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($payment_status == '')
	{
		$error = true;
		$err_msg = 'Please select payment status';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($invoice == '')
	{
		$error = true;
		$err_msg = 'Invalid invoice';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	else
	{
		$arr_order_record = $obj->getOrderDetailsByInvoice($invoice);
		if(count($arr_order_record) == 0)
		{
			$error = true;
			$err_msg = 'Invalid invoice!!';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
	}
	
	if(!$error)
	{
		if($order_status == $arr_order_record['order_status'] && $payment_status == $arr_order_record['payment_status'] && $order_note == $arr_order_record['order_note'])
		{
			$msg = 'No changes!';
			$ref_url = "manage_orders.php?msg=".urlencode($msg);
						
			$tdata = array();
			$response = array('msg'=>'Success','status'=>1,'refurl'=> $ref_url);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);	
		}
		else
		{
			$tdata = array();
			$tdata['order_id'] = $arr_order_record['order_id'];
			$tdata['invoice'] = $invoice;
			$tdata['order_status'] = $order_status;
			$tdata['payment_status'] = $payment_status;
			$tdata['order_note'] = $order_note;
			$tdata['order_updated_by_admin'] = 1;
			$tdata['order_updated_by_id'] = $admin_id;
			if($obj->updateOrderStatus($tdata))
			{
				if($send_email_to_user == '1')
				{
					
				}
				$msg = 'Record Added Successfully!';
				$ref_url = "manage_orders.php?msg=".urlencode($msg);
							
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
}