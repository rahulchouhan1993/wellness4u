<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$edit_action_id = '88';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[CANCEL_ORDER] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$invoice = trim($_POST['hdninvoice']);
	$ocid = strip_tags(trim($_POST['hdnocid']));
	$cancel_cat_id = strip_tags(trim($_POST['cancel_cat_id']));
	$cancel_cat_other = strip_tags(trim($_POST['cancel_cat_other']));
	$cancel_comments = strip_tags(trim($_POST['cancel_comments']));
	
	if($invoice == '')
	{
		$error = true;
		$err_msg = 'Please enter invoice';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($ocid == '')
	{
		$error = true;
		$err_msg = 'Please enter item';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($cancel_cat_id == '')
	{
		$error = true;
		$err_msg = 'Please select cancel reason';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($cancel_cat_id == '221')
	{
		if($cancel_cat_other == '')
		{
			$error = true;
			$err_msg = 'Please enter other cancel reason';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
	}	
	
	if(!$error)
	{
		$arr_order_record = $obj->getOrderDetailsByInvoice($invoice);
		if(count($arr_order_record) == 0)
		{
			$error = true;
			$err_msg = 'Invalid Invoice';
		}	
		else
		{
			$arr_order_cart_record = $obj->getOrderCartDetailsByInvoiceAndOrderCartId($invoice,$ocid);
			if(count($arr_order_cart_record) == 0)
			{
				$error = true;
				$err_msg = 'Invalid Invoice Item';
			}
			else
			{
				if($arr_order_cart_record['cancel_request_sent'] == '1')
				{
					$error = true;
					$err_msg = 'Cancel request already sent for this item';
				}
				else
				{
					/*
					if(!$obj_comm->chkIfItemCaneBeCancelled($arr_order_cart_record['invoice'],$arr_order_cart_record['prod_id'],$arr_order_cart_record['order_cart_delivery_date']))
					{
						$error = true;
						$err_msg = 'This item cannot be cancelled now.';
					}
					*/
				}
			}
		}
	}
	
	if(!$error)
	{
		$tdata = array();
		$tdata['invoice'] = $invoice;
		$tdata['order_cart_id'] = $ocid;
		$tdata['cancel_cat_id'] = $cancel_cat_id;
		$tdata['cancel_cat_other'] = $cancel_cat_other;
		$tdata['cancel_comments'] = $cancel_comments;
		$tdata['cancel_request_sent'] = 1;
		$tdata['cancel_request_by_admin'] = 1;
		$tdata['cancel_request_by_admin_id'] = $admin_id;
		if($obj->doCancelItem($tdata))
		{
			$msg = 'Request sent Successfully!';
			$ref_url = "view_order.php?invoice=".$invoice;
						
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