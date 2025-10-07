<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');

$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$edit_action_id = '90';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[CREATE_MAILING_LABELS] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$ml_invoice_list_str = trim($_POST['hdnml_invoice_list_str']);
	$ml_layout = strip_tags(trim($_POST['ml_layout']));
	
	$arr_invoice_no = array();
	if(isset($_POST['invoice_no']))
	{
		foreach($_POST['invoice_no'] as $key => $val)
		{
			array_push($arr_invoice_no,$val);
		}		
	}
	
	$arr_invoice_no_show = array();
	if(isset($_POST['invoice_no_show']))
	{
		foreach($_POST['invoice_no_show'] as $key => $val)
		{
			array_push($arr_invoice_no_show,$val);
		}		
	}
	
	$arr_invoice_date = array();
	if(isset($_POST['invoice_date']))
	{
		foreach($_POST['invoice_date'] as $key => $val)
		{
			array_push($arr_invoice_date,$val);
		}		
	}
	
	$arr_invoice_date_show = array();
	if(isset($_POST['invoice_date_show']))
	{
		foreach($_POST['invoice_date_show'] as $key => $val)
		{
			array_push($arr_invoice_date_show,$val);
		}		
	}
	
	$arr_delivery_date = array();
	if(isset($_POST['delivery_date']))
	{
		foreach($_POST['delivery_date'] as $key => $val)
		{
			array_push($arr_delivery_date,$val);
		}		
	}
	
	$arr_delivery_date_show = array();
	if(isset($_POST['delivery_date_show']))
	{
		foreach($_POST['delivery_date_show'] as $key => $val)
		{
			array_push($arr_delivery_date_show,$val);
		}		
	}
	
	$arr_seller_type = array();
	if(isset($_POST['seller_type']))
	{
		foreach($_POST['seller_type'] as $key => $val)
		{
			array_push($arr_seller_type,$val);
		}		
	}
	
	$arr_tos_name = array();
	if(isset($_POST['tos_name']))
	{
		foreach($_POST['tos_name'] as $key => $val)
		{
			array_push($arr_tos_name,$val);
		}		
	}
	
	$arr_vendor_id = array();
	if(isset($_POST['vendor_id']))
	{
		foreach($_POST['vendor_id'] as $key => $val)
		{
			array_push($arr_vendor_id,$val);
		}		
	}
	
	$arr_seller_name_show = array();
	if(isset($_POST['seller_name_show']))
	{
		foreach($_POST['seller_name_show'] as $key => $val)
		{
			array_push($arr_seller_name_show,$val);
		}		
	}
	
	$arr_tos_address = array();
	if(isset($_POST['tos_address']))
	{
		foreach($_POST['tos_address'] as $key => $val)
		{
			array_push($arr_tos_address,$val);
		}		
	}
	
	$arr_vloc_id = array();
	if(isset($_POST['vloc_id']))
	{
		foreach($_POST['vloc_id'] as $key => $val)
		{
			array_push($arr_vloc_id,$val);
		}		
	}
	
	$arr_seller_address_show = array();
	if(isset($_POST['seller_address_show']))
	{
		foreach($_POST['seller_address_show'] as $key => $val)
		{
			array_push($arr_seller_address_show,$val);
		}		
	}
	
	$arr_pan_no = array();
	if(isset($_POST['pan_no']))
	{
		foreach($_POST['pan_no'] as $key => $val)
		{
			array_push($arr_pan_no,$val);
		}		
	}
	
	$arr_pan_no_show = array();
	if(isset($_POST['pan_no_show']))
	{
		foreach($_POST['pan_no_show'] as $key => $val)
		{
			array_push($arr_pan_no_show,$val);
		}		
	}
	
	$arr_customer_name_show = array();
	if(isset($_POST['customer_name_show']))
	{
		foreach($_POST['customer_name_show'] as $key => $val)
		{
			array_push($arr_customer_name_show,$val);
		}		
	}
	
	$arr_billing_address_show = array();
	if(isset($_POST['billing_address_show']))
	{
		foreach($_POST['billing_address_show'] as $key => $val)
		{
			array_push($arr_billing_address_show,$val);
		}		
	}
	
	$arr_delivery_address_show = array();
	if(isset($_POST['delivery_address_show']))
	{
		foreach($_POST['delivery_address_show'] as $key => $val)
		{
			array_push($arr_delivery_address_show,$val);
		}		
	}
	
	$arr_customer_email_show = array();
	if(isset($_POST['customer_email_show']))
	{
		foreach($_POST['customer_email_show'] as $key => $val)
		{
			array_push($arr_customer_email_show,$val);
		}		
	}
	
	$arr_customer_no_show = array();
	if(isset($_POST['customer_no_show']))
	{
		foreach($_POST['customer_no_show'] as $key => $val)
		{
			array_push($arr_customer_no_show,$val);
		}		
	}
	
	if($ml_layout == '')
	{
		$error = true;
		$err_msg = 'Please select layout';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	
	for($i=0,$j=1;$i<count($arr_invoice_no);$i++,$j++)
	{
		if($arr_invoice_no[$i] == '')
		{
			$error = true;
			$err_msg = 'invoice no cannot be blank - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($arr_invoice_date[$i] == '')
		{
			$error = true;
			$err_msg = 'Invoice date cannot be blank - row no '.$j;
		
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		
		if($arr_delivery_date_show[$i] == '1')
		{
			if($arr_delivery_date[$i] == '')
			{
				$error = true;
				$err_msg = 'Please select delivery date - row no '.$j;
			
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
		}
		
		if($arr_seller_name_show[$i] == '1')
		{
			if($arr_seller_type[$i] == '')
			{
				$error = true;
				$err_msg = 'Please select seller type - row no '.$j;
			
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			elseif($arr_seller_type[$i] == '0')
			{
				if($arr_tos_name[$i] == '')
				{
					$error = true;
					$err_msg = 'Please enter seller name - row no '.$j;
				
					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);
				}
			}
			elseif($arr_seller_type[$i] == '1')
			{
				if($arr_vendor_id[$i] == '')
				{
					$error = true;
					$err_msg = 'Please select vendor - row no '.$j;
				
					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);
				}
			}
		}
		
		if($arr_seller_address_show[$i] == '1')
		{
			if($arr_seller_type[$i] == '')
			{
				$error = true;
				$err_msg = 'Please select seller type - row no '.$j;
			
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			elseif($arr_seller_type[$i] == '0')
			{
				if($arr_tos_address[$i] == '')
				{
					$error = true;
					$err_msg = 'Please enter seller address - row no '.$j;
				
					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);
				}
			}
			elseif($arr_seller_type[$i] == '1')
			{
				if($arr_vloc_id[$i] == '')
				{
					$error = true;
					$err_msg = 'Please select vendor location - row no '.$j;
				
					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);
				}
			}
		}
		
		if($arr_pan_no_show[$i] == '1')
		{
			if($arr_pan_no[$i] == '')
			{
				$error = true;
				$err_msg = 'Please enter seller PAN No - row no '.$j;
			
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
		}
	}
	
	
	if(!$error)
	{
		$random_unique_no = $obj->generateRandomString(15);
		
		
		$k = 0;
		$arr_invoice_no_new = array();
		$arr_invoice_no_show_new = array();
		$arr_invoice_date_new = array();
		$arr_invoice_date_show_new = array();
		$arr_delivery_date_new = array();
		$arr_delivery_date_show_new = array();
		$arr_seller_type_new = array();
		$arr_tos_name_new = array();
		$arr_vendor_id_new = array();
		$arr_seller_name_show_new = array();
		$arr_tos_address_new = array();
		$arr_vloc_id_new = array();
		$arr_seller_address_show_new = array();
		$arr_pan_no_new = array();
		$arr_pan_no_show_new = array();
		$arr_customer_name_show_new = array();
		$arr_customer_email_show_new = array();
		$arr_customer_no_show_new = array();
		$arr_billing_address_show_new = array();
		$arr_delivery_address_show_new = array();
		for($i=0;$i<count($arr_invoice_no);$i++)
		{
			if($arr_billing_address_show[$i] == '1' && $arr_delivery_address_show[$i] == '1')
			{
				$arr_invoice_no_new[$k] = $arr_invoice_no[$i];	
				$arr_invoice_no_show_new[$k] = $arr_invoice_no_show[$i];	
				$arr_invoice_date_new[$k] = $arr_invoice_date[$i];	
				$arr_invoice_date_show_new[$k] = $arr_invoice_date_show[$i];	
				$arr_delivery_date_new[$k] = $arr_delivery_date[$i];	
				$arr_delivery_date_show_new[$k] = $arr_delivery_date_show[$i];	
				$arr_seller_type_new[$k] = $arr_seller_type[$i];	
				$arr_tos_name_new[$k] = $arr_tos_name[$i];	
				$arr_vendor_id_new[$k] = $arr_vendor_id[$i];	
				$arr_seller_name_show_new[$k] = $arr_seller_name_show[$i];	
				$arr_tos_address_new[$k] = $arr_tos_address[$i];	
				$arr_vloc_id_new[$k] = $arr_vloc_id[$i];	
				$arr_seller_address_show_new[$k] = $arr_seller_address_show[$i];	
				$arr_pan_no_new[$k] = $arr_pan_no[$i];	
				$arr_pan_no_show_new[$k] = $arr_pan_no_show[$i];	
				$arr_customer_name_show_new[$k] = $arr_customer_name_show[$i];	
				$arr_customer_email_show_new[$k] = $arr_customer_email_show[$i];	
				$arr_customer_no_show_new[$k] = $arr_customer_no_show[$i];	
				$arr_billing_address_show_new[$k] = '1';	
				$arr_delivery_address_show_new[$k] = '0';	
				
				$k = $k + 1;
				
				$arr_invoice_no_new[$k] = $arr_invoice_no[$i];	
				$arr_invoice_no_show_new[$k] = $arr_invoice_no_show[$i];	
				$arr_invoice_date_new[$k] = $arr_invoice_date[$i];	
				$arr_invoice_date_show_new[$k] = $arr_invoice_date_show[$i];	
				$arr_delivery_date_new[$k] = $arr_delivery_date[$i];	
				$arr_delivery_date_show_new[$k] = $arr_delivery_date_show[$i];	
				$arr_seller_type_new[$k] = $arr_seller_type[$i];	
				$arr_tos_name_new[$k] = $arr_tos_name[$i];	
				$arr_vendor_id_new[$k] = $arr_vendor_id[$i];	
				$arr_seller_name_show_new[$k] = $arr_seller_name_show[$i];	
				$arr_tos_address_new[$k] = $arr_tos_address[$i];	
				$arr_vloc_id_new[$k] = $arr_vloc_id[$i];	
				$arr_seller_address_show_new[$k] = $arr_seller_address_show[$i];	
				$arr_pan_no_new[$k] = $arr_pan_no[$i];	
				$arr_pan_no_show_new[$k] = $arr_pan_no_show[$i];	
				$arr_customer_name_show_new[$k] = $arr_customer_name_show[$i];	
				$arr_customer_email_show_new[$k] = $arr_customer_email_show[$i];	
				$arr_customer_no_show_new[$k] = $arr_customer_no_show[$i];	
				$arr_billing_address_show_new[$k] = '0';	
				$arr_delivery_address_show_new[$k] = '1';	
				
				$k = $k + 1;
			}
			else
			{
				$arr_invoice_no_new[$k] = $arr_invoice_no[$i];	
				$arr_invoice_no_show_new[$k] = $arr_invoice_no_show[$i];	
				$arr_invoice_date_new[$k] = $arr_invoice_date[$i];	
				$arr_invoice_date_show_new[$k] = $arr_invoice_date_show[$i];	
				$arr_delivery_date_new[$k] = $arr_delivery_date[$i];	
				$arr_delivery_date_show_new[$k] = $arr_delivery_date_show[$i];	
				$arr_seller_type_new[$k] = $arr_seller_type[$i];	
				$arr_tos_name_new[$k] = $arr_tos_name[$i];	
				$arr_vendor_id_new[$k] = $arr_vendor_id[$i];	
				$arr_seller_name_show_new[$k] = $arr_seller_name_show[$i];	
				$arr_tos_address_new[$k] = $arr_tos_address[$i];	
				$arr_vloc_id_new[$k] = $arr_vloc_id[$i];	
				$arr_seller_address_show_new[$k] = $arr_seller_address_show[$i];	
				$arr_pan_no_new[$k] = $arr_pan_no[$i];	
				$arr_pan_no_show_new[$k] = $arr_pan_no_show[$i];	
				$arr_customer_name_show_new[$k] = $arr_customer_name_show[$i];	
				$arr_customer_email_show_new[$k] = $arr_customer_email_show[$i];	
				$arr_customer_no_show_new[$k] = $arr_customer_no_show[$i];	
				$arr_billing_address_show_new[$k] = $arr_billing_address_show[$i];	
				$arr_delivery_address_show_new[$k] = $arr_delivery_address_show[$i];	
				
				$k = $k + 1;
			}
		}
		
		$tdata = array();
		$tdata['random_unique_no'] = $random_unique_no;
		$tdata['invoice_str'] = $ml_invoice_list_str;
		$tdata['mlp_layout'] = $ml_layout;
		$tdata['invoice_no'] = $arr_invoice_no_new;
		$tdata['invoice_no_show'] = $arr_invoice_no_show_new;
		$tdata['invoice_date'] = $arr_invoice_date_new;
		$tdata['invoice_date_show'] = $arr_invoice_date_show_new;
		$tdata['delivery_date'] = $arr_delivery_date_new;
		$tdata['delivery_date_show'] = $arr_delivery_date_show_new;
		$tdata['seller_type'] = $arr_seller_type_new;
		$tdata['tos_name'] = $arr_tos_name_new;
		$tdata['vendor_id'] = $arr_vendor_id_new;
		$tdata['seller_name_show'] = $arr_seller_name_show_new;
		$tdata['tos_address'] = $arr_tos_address_new;
		$tdata['vloc_id'] = $arr_vloc_id_new;
		$tdata['seller_address_show'] = $arr_seller_address_show_new;
		$tdata['pan_no'] = $arr_pan_no_new;
		$tdata['pan_no_show'] = $arr_pan_no_show_new;
		$tdata['customer_name_show'] = $arr_customer_name_show_new;
		$tdata['customer_email_show'] = $arr_customer_email_show_new;
		$tdata['customer_no_show'] = $arr_customer_no_show_new;
		$tdata['billing_address_show'] = $arr_billing_address_show_new;
		$tdata['delivery_address_show'] = $arr_delivery_address_show_new;
		$tdata['added_by_admin'] = $admin_id;
		
		$output = $obj->createMailingLabelsPdfContents($tdata);
		
		$tdata['html_contents'] = $output;
		
		if($obj->addMailingLabels($tdata))
		{
			$ref_url = "download_mailing_labels.php?runo=".$random_unique_no;
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
  