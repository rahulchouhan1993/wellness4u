<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$add_action_id = '68';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[ADD_ORDER_DELIVERY] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>, FILES:<pre>'.print_r($_FILES,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$invoice = strip_tags(trim($_POST['invoice']));
	//$delivery_date = strip_tags(trim($_POST['delivery_date']));
	$logistic_partner_type_cat_id = strip_tags(trim($_POST['logistic_partner_type_cat_id']));
	$logistic_partner_id = strip_tags(trim($_POST['logistic_partner_id']));
	$delivery_person_name = strip_tags(trim($_POST['delivery_person_name']));
	$delivery_person_contact_no = strip_tags(trim($_POST['delivery_person_contact_no']));
	$reciever_name = strip_tags(trim($_POST['reciever_name']));
	$reciever_contact_no = strip_tags(trim($_POST['reciever_contact_no']));
	$other_reciever_name = strip_tags(trim($_POST['other_reciever_name']));
	$other_reciever_contact_no = strip_tags(trim($_POST['other_reciever_contact_no']));
	$delivery_status = strip_tags(trim($_POST['delivery_status']));
	$consignment_note = strip_tags(trim($_POST['consignment_note']));
	$other_comments = strip_tags(trim($_POST['other_comments']));
	$chkbox_records_str = strip_tags(trim($_POST['chkbox_records_str']));
	
	if($invoice == '')
	{
		$error = true;
		$err_msg = 'Please select invoice';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($chkbox_records_str == '')
	{
		$error = true;
		$err_msg = 'Please select delivery item';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
		
	/*
	if($delivery_date == '')
	{
		$error = true;
		$err_msg = 'Please enter delivery date';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	*/
	
	if($logistic_partner_type_cat_id == '')
	{
		$error = true;
		$err_msg = 'Please select logistic partner type';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	else
	{
		if($logistic_partner_type_cat_id != '158')
		{
			if($logistic_partner_id == '')
			{
				$error = true;
				$err_msg = 'Please select logistic partner';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}	
		}
	}
	
	if($delivery_person_name == '')
	{
		$error = true;
		$err_msg = 'Please enter delivery person name';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($delivery_status == '')
	{
		$error = true;
		$err_msg = 'Please delivery status';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	$proof_of_delivery = '';
	if(!$error)
	{
		$picture_size_limit = 5120;
		$error = false;
		$err_msg = '';

		// Define a destination
		$targetFolder = SITE_PATH . '/uploads'; // Relative to the root

		if (!empty($_FILES) && isset($_FILES['proof_of_delivery']['name']) && $_FILES['proof_of_delivery']['name'] != '')
		{
			$tempFile = $_FILES['proof_of_delivery']['tmp_name'];

			$filename = date('dmYHis') . '_' . $_FILES['proof_of_delivery']['name'];
			$filename = str_replace(' ', '-', $filename);

			$targetPath = $targetFolder;
			$targetFile = rtrim($targetPath, '/') . '/' . $filename;
			$mimetype = $_FILES['proof_of_delivery']['type'];

			// Validate the file type
			$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF'); // File extensions
			$fileParts = pathinfo($_FILES['proof_of_delivery']['name']);

			if (in_array($fileParts['extension'], $fileTypes))
			{
				$proof_of_delivery = $_FILES['proof_of_delivery']['name'];
				$size_in_kb = $_FILES['proof_of_delivery']['size'] / 1024;
				$file4 = substr($proof_of_delivery, -4, 4);
				if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF'))
				{
					$error = true;
					$err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) image ';
				}
				elseif ($size_in_kb > $picture_size_limit)
				{
					$error = true;
					$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb.';
				}

				if (!$error)
				{
					$proof_of_delivery = $filename;

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
		$added_records = false;
		$str_chkbox_pos = strpos($chkbox_records_str,',');
		if ($str_chkbox_pos === false) 
		{
			$arr_order_item_id = array($chkbox_records_str);
		}
		else
		{
			$arr_order_item_id = implode(',',$chkbox_records_str);	
		}
		
		if(count($arr_order_item_id) > 0)
		{
			for($i=0;$i<count($arr_order_item_id);$i++)
			{
				$delivery_date = $obj->getOrderCartDeliveryDateByOrderCartId($arr_order_item_id[$i]);
		
				$tdata = array();
				$tdata['invoice'] = $invoice;
				$tdata['order_item_id'] = $arr_order_item_id[$i];
				$tdata['delivery_date'] = $delivery_date;
				$tdata['logistic_partner_type'] = $logistic_partner_type_cat_id;
				$tdata['logistic_partner_id'] = $logistic_partner_id;
				$tdata['delivery_person_name'] = $delivery_person_name;
				$tdata['delivery_person_contact_no'] = $delivery_person_contact_no;
				$tdata['reciever_name'] = $reciever_name;
				$tdata['reciever_contact_no'] = $reciever_contact_no;
				$tdata['other_reciever_name'] = $other_reciever_name;
				$tdata['other_reciever_contact_no'] = $other_reciever_contact_no;
				$tdata['delivery_status'] = $delivery_status;
				$tdata['proof_of_delivery'] = $proof_of_delivery;
				$tdata['consignment_note'] = $consignment_note;
				$tdata['other_comments'] = $other_comments;	
				$tdata['added_by_admin'] = $admin_id;
				
				if($obj->addOrderDelivery($tdata))
				{
					$added_records = true;	
				}
			}				
		}
		
		if($added_records)
		{
			$msg = 'Record added successfully!';
			$ref_url = "manage_order_delivery.php?msg=".urlencode($msg);
						
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