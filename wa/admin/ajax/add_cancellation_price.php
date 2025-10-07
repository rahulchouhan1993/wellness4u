<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$add_action_id = '77';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[ADD_CANCELLATION_PRICE] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$cp_title = strip_tags(trim($_POST['cp_title']));
	$cancellation_price = strip_tags(trim($_POST['cancellation_price']));
	$min_cancellation_amount = strip_tags(trim($_POST['min_cancellation_amount']));
	$max_cancellation_amount = strip_tags(trim($_POST['max_cancellation_amount']));
	
	$cp_type = strip_tags(trim($_POST['cp_type']));
	$cp_applied_on = strip_tags(trim($_POST['cp_applied_on']));
	$cp_effective_date = strip_tags(trim($_POST['cp_effective_date']));
	$cp_percentage = strip_tags(trim($_POST['cp_percentage']));
	$cp_min_qty_val = strip_tags(trim($_POST['cp_min_qty_val']));
	$cp_min_qty_id = strip_tags(trim($_POST['cp_min_qty_id']));
	$cp_max_qty_val = strip_tags(trim($_POST['cp_max_qty_val']));
	$cp_max_qty_id = strip_tags(trim($_POST['cp_max_qty_id']));
	$cp_comments = strip_tags(trim($_POST['cp_comments']));
	$cp_min_hrs = strip_tags(trim($_POST['cp_min_hrs']));
	$cp_max_hrs = strip_tags(trim($_POST['cp_max_hrs']));
	
	if($cp_title == '')
	{
		$error = true;
		$err_msg = 'Please enter title';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($cp_type == '')
	{
		$error = true;
		$err_msg = 'Please select cancellation type';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($cp_applied_on == '')
	{
		$error = true;
		$err_msg = 'Please select cancellation applied on option';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($cp_effective_date == '')
	{
		$error = true;
		$err_msg = 'Please select cancellation effective date';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($cp_min_hrs == '')
	{
		$error = true;
		$err_msg = 'Please select min cancellation hrs';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
		
	if($cp_max_hrs == '')
	{
		$error = true;
		$err_msg = 'Please select max cancellation hrs';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($cp_max_hrs < $cp_min_hrs)
	{
		$error = true;
		$err_msg = 'Min cancellation hrs must be lesser than Max cancellation hrs';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($cp_type == '0')
	{
		if($cancellation_price == '')
		{
			$error = true;
			$err_msg = 'Please enter cancellation price';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($cancellation_price))
		{
			$error = true;
			$err_msg = 'Please enter valid cancellation price';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($min_cancellation_amount == '')
		{
			$error = true;
			$err_msg = 'Please enter min cancellation amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($min_cancellation_amount))
		{
			$error = true;
			$err_msg = 'Please enter valid min cancellation amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($max_cancellation_amount == '')
		{
			$error = true;
			$err_msg = 'Please enter max cancellation amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($max_cancellation_amount))
		{
			$error = true;
			$err_msg = 'Please enter valid max cancellation amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($max_cancellation_amount < $min_cancellation_amount)
		{
			$error = true;
			$err_msg = 'Min cancellation amount must be lesser than Max cancellation amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
	}
	elseif($cp_type == '1')
	{
		if($cp_percentage == '')
		{
			$error = true;
			$err_msg = 'Please enter cancellation percentage';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($cp_percentage))
		{
			$error = true;
			$err_msg = 'Please enter valid cancellation percentage';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($min_cancellation_amount == '')
		{
			$error = true;
			$err_msg = 'Please enter min cancellation amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($min_cancellation_amount))
		{
			$error = true;
			$err_msg = 'Please enter valid min cancellation amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($max_cancellation_amount == '')
		{
			$error = true;
			$err_msg = 'Please enter max cancellation amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($max_cancellation_amount))
		{
			$error = true;
			$err_msg = 'Please enter valid max cancellation amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($max_cancellation_amount < $min_cancellation_amount)
		{
			$error = true;
			$err_msg = 'Min cancellation amount must be lesser than Max cancellation amount';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
	}
	elseif($cp_type == '2')
	{
		if($cancellation_price == '')
		{
			$error = true;
			$err_msg = 'Please enter cancellation price';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($cp_min_qty_val == '')
		{
			$error = true;
			$err_msg = 'Please enter min qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($cp_min_qty_val))
		{
			$error = true;
			$err_msg = 'Please enter valid min qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($cp_min_qty_id == '')
		{
			$error = true;
			$err_msg = 'Please select min qty unit';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($cp_max_qty_val == '')
		{
			$error = true;
			$err_msg = 'Please enter max qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!is_numeric($cp_max_qty_val))
		{
			$error = true;
			$err_msg = 'Please enter valid max qty value';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif($cp_max_qty_id == '')
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
	
	if(!$error)
	{
		if($cp_type == '0')
		{
			$cp_percentage = '';
			$cp_min_qty_id = '';
			$cp_min_qty_val = '';
			$cp_max_qty_id = '';
			$cp_max_qty_val = '';
		}
		elseif($cp_type == '1')
		{
			$cancellation_price = '';
			$cp_min_qty_id = '';
			$cp_min_qty_val = '';
			$cp_max_qty_id = '';
			$cp_max_qty_val = '';
		}
		elseif($cp_type == '2')
		{
			$cp_percentage = '';
			$min_cancellation_amount = '';
			$max_cancellation_amount = '';
			
		}
		elseif($cp_type == '3')
		{
			$cancellation_price = '';
			$min_cancellation_amount = '';
			$max_cancellation_amount = '';
			$cp_percentage = '';
			$cp_min_qty_id = '';
			$cp_min_qty_val = '';
			$cp_max_qty_id = '';
			$cp_max_qty_val = '';
		}
		
		$cp_effective_date = date('Y-m-d',strtotime($cp_effective_date));
		
		$tdata = array();
		$tdata['cp_title'] = $cp_title;
		$tdata['cancellation_price'] = $cancellation_price;
		$tdata['min_cancellation_amount'] = $min_cancellation_amount;
		$tdata['max_cancellation_amount'] = $max_cancellation_amount;
		$tdata['cp_type'] = $cp_type;
		$tdata['cp_applied_on'] = $cp_applied_on;
		$tdata['cp_effective_date'] = $cp_effective_date;
		$tdata['cp_percentage'] = $cp_percentage;
		$tdata['cp_min_qty_id'] = $cp_min_qty_id;
		$tdata['cp_min_qty_val'] = $cp_min_qty_val;
		$tdata['cp_max_qty_id'] = $cp_max_qty_id;
		$tdata['cp_max_qty_val'] = $cp_max_qty_val;
		$tdata['cp_min_hrs'] = $cp_min_hrs;
		$tdata['cp_max_hrs'] = $cp_max_hrs;
		$tdata['cp_comments'] = $cp_comments;
		$tdata['cp_status'] = 1;
		$tdata['added_by_admin'] = $admin_id;
		
		if($obj->addCancellationPrice($tdata))
		{
			$msg = 'Record added successfully!';
			$ref_url = "manage_cancellation_prices.php?msg=".urlencode($msg);
						
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