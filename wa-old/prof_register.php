<?php
require_once('classes/config.php');
require_once('classes/vendor.php');
$admin_main_menu_id = '16';
$add_action_id = '44';

$obj = new Vendor();
$obj2 = new commonFunctions();
//if($obj->isVendorLoggedIn())
//{
//    header("Location: index.php");
//    exit(0);
//}

$error = false;
$err_msg = "";
$msg = '';




$cat_cnt = 0;
$cat_total_cnt = 1;

$vendor_parent_cat_id = '11';
$vendor_cat_id = '';
$vendor_name = '';
$vendor_username = '';
$arr_vloc_parent_cat_id = array('2');
$arr_vloc_cat_id = array('');
$arr_contact_person_title = array('');
$arr_contact_person = array('');
$arr_contact_email = array('');
$arr_contact_number = array('');
$arr_contact_designation = array('');
$arr_contact_remark = array('');
$arr_vloc_speciality_offered = array('');

$arr_cert_cnt = array(0);
$arr_cert_total_cnt = array(1);

$arr_vc_cert_type_id = array();
$arr_vc_cert_name = array();
$arr_vc_cert_no = array();
$arr_vc_cert_issued_by = array();
$arr_vc_cert_reg_date = array();
$arr_vc_cert_validity_date = array();

for($i=0;$i<count($arr_cert_total_cnt);$i++)
{
	$arr_vc_cert_type_id[$i] = array('');
	$arr_vc_cert_name[$i] = array('');
	$arr_vc_cert_no[$i] = array('');
	$arr_vc_cert_issued_by[$i] = array('');
	$arr_vc_cert_reg_date[$i] = array('');
	$arr_vc_cert_validity_date[$i] = array('');
}

$arr_country_id = array('-1');
$arr_state_id = array('-1');
$arr_city_id = array('-1');
$arr_area_id = array('-1');




if(isset($_POST['btnSubmit']))
{
//	$va_id = strip_tags(trim($_POST['va_id']));
	
//	$vaf_id = $obj->getVendorAccessFormIdFromVAIDAndVAFAMID($va_id,$admin_main_menu_id);
//	if($vaf_id > 0)
//	{
//		$arr_vaff_record = $obj->getVendorAccessFormFieldsDetails($vaf_id);
//		if(count($arr_vaff_record) == 0)
//		{
//			$tdata = array();
//			$response = array('msg'=>'Sorry service not found currently!','status'=>0);
//			$tdata[] = $response;
//			echo json_encode($tdata);
//			exit(0);
//		}
//	}
//	else
//	{
//		$tdata = array();
//		$response = array('msg'=>'Sorry service not found currently.','status'=>0);
//		$tdata[] = $response;
//		echo json_encode($tdata);
//		exit(0);
//	}

	
	$vendor_parent_cat_id = strip_tags(trim($_POST['service_cat']));
	$vendor_cat_id = strip_tags(trim($_POST['vendor_cat_id']));
        $vendor_name = strip_tags(trim($_POST['vendor_name']));
	$vendor_username = strip_tags(trim($_POST['vendor_username']));
	$vendor_password = strip_tags(trim($_POST['vendor_password']));
	
	$arr_cert_loop_cnt = array();
	if(isset($_POST['cert_loop_cnt']))
	{
		foreach($_POST['cert_loop_cnt'] as $key => $val)
		{
			array_push($arr_cert_loop_cnt,$val);
		}		
	}
		
	$arr_vloc_parent_cat_id = array();
	if(isset($_POST['vloc_parent_cat_id']))
	{
		foreach($_POST['vloc_parent_cat_id'] as $key => $val)
		{
			array_push($arr_vloc_parent_cat_id,$val);
		}		
	}
        
	$arr_vloc_cat_id = array();
	if(isset($_POST['vloc_cat_id']))
	{
		foreach($_POST['vloc_cat_id'] as $key => $val)
		{
			array_push($arr_vloc_cat_id,$val);
		}		
	}
		
	$arr_country_id = array();
	if(isset($_POST['country_id']))
	{
		foreach($_POST['country_id'] as $key => $val)
		{
			array_push($arr_country_id,$val);
		}		
	}
	
	$arr_state_id = array();
	if(isset($_POST['state_id']))
	{
		foreach($_POST['state_id'] as $key => $val)
		{
			array_push($arr_state_id,$val);
		}		
	}
	
	$arr_city_id = array();
	if(isset($_POST['city_id']))
	{
		foreach($_POST['city_id'] as $key => $val)
		{
			array_push($arr_city_id,$val);
		}		
	}
	
	$arr_area_id = array();
	if(isset($_POST['area_id']))
	{
		foreach($_POST['area_id'] as $key => $val)
		{
			array_push($arr_area_id,$val);
		}		
	}
	

	$arr_contact_person_title = array();
	if(isset($_POST['contact_person_title']))
	{
		foreach($_POST['contact_person_title'] as $key => $val)
		{
			array_push($arr_contact_person_title,$val);
		}		
	}
	
	$arr_contact_person = array();
	if(isset($_POST['contact_person']))
	{
		foreach($_POST['contact_person'] as $key => $val)
		{
			array_push($arr_contact_person,$val);
		}		
	}
	
	$arr_contact_email = array();
	if(isset($_POST['contact_email']))
	{
		foreach($_POST['contact_email'] as $key => $val)
		{
			array_push($arr_contact_email,$val);
		}		
	}
	
	$arr_contact_number = array();
	if(isset($_POST['contact_number']))
	{
		foreach($_POST['contact_number'] as $key => $val)
		{
			array_push($arr_contact_number,$val);
		}		
	}
	
	$arr_contact_designation = array();
	if(isset($_POST['contact_designation']))
	{
		foreach($_POST['contact_designation'] as $key => $val)
		{
			array_push($arr_contact_designation,$val);
		}		
	}
	
	$arr_contact_remark = array();
	if(isset($_POST['contact_remark']))
	{
		foreach($_POST['contact_remark'] as $key => $val)
		{
			array_push($arr_contact_remark,$val);
		}		
	}
	
	$arr_vloc_speciality_offered = array();
	$arr_vc_cert_type_id = array();
	$arr_vc_cert_name = array();
	$arr_vc_cert_no = array();
	$arr_vc_cert_issued_by = array();
	$arr_vc_cert_reg_date = array();
	$arr_vc_cert_validity_date = array();
	
	for($i=0;$i<count($arr_cert_loop_cnt);$i++)
	{
		$arr_vloc_speciality_offered[$i] = array();
		if(isset($_POST['vloc_speciality_offered_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['vloc_speciality_offered_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_vloc_speciality_offered[$i],$val);
			}		
		}
		
		$arr_vc_cert_type_id[$i] = array();
		if(isset($_POST['vc_cert_type_id_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['vc_cert_type_id_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_vc_cert_type_id[$i],$val);
			}		
		}
		
		$arr_vc_cert_name[$i] = array();
		if(isset($_POST['vc_cert_name_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['vc_cert_name_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_vc_cert_name[$i],$val);
			}		
		}
		
		$arr_vc_cert_no[$i] = array();
		if(isset($_POST['vc_cert_no_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['vc_cert_no_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_vc_cert_no[$i],$val);
			}		
		}
		
		$arr_vc_cert_issued_by[$i] = array();
		if(isset($_POST['vc_cert_issued_by_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['vc_cert_issued_by_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_vc_cert_issued_by[$i],$val);
			}		
		}
		
		$arr_vc_cert_reg_date[$i] = array();
		if(isset($_POST['vc_cert_reg_date_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['vc_cert_reg_date_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_vc_cert_reg_date[$i],$val);
			}		
		}
		
		$arr_vc_cert_validity_date[$i] = array();
		if(isset($_POST['vc_cert_validity_date_'.$arr_cert_loop_cnt[$i]]))
		{
			foreach($_POST['vc_cert_validity_date_'.$arr_cert_loop_cnt[$i]] as $key => $val)
			{
				array_push($arr_vc_cert_validity_date[$i],$val);
			}		
		}
	}	
	

//	if($vendor_name == '')
//	{
//		$error = true;
//		$err_msg = 'Please enter company name';
//	
//		$tdata = array();
//		$response = array('msg'=>$err_msg,'status'=>0);
//		$tdata[] = $response;
//		echo json_encode($tdata);
//		exit(0);
//	}
//	elseif($obj->chkVendorNameExists($vendor_name))
//	{
//		$error = true;
//		$err_msg = 'Company name already exists';
//	
//		$tdata = array();
//		$response = array('msg'=>$err_msg,'status'=>0);
//		$tdata[] = $response;
//		echo json_encode($tdata);
//		exit(0);
//	}
	
//	if($vendor_username == '')
//	{
//		$error = true;
//		$err_msg = 'Please enter vendor username';
//	
//		$tdata = array();
//		$response = array('msg'=>$err_msg,'status'=>0);
//		$tdata[] = $response;
//		echo json_encode($tdata);
//		exit(0);
//	}
//	elseif($obj->chkVendorUsernameExists($vendor_username))
//	{
//		$error = true;
//		$err_msg = 'Vendor username already exists';
//	
//		$tdata = array();
//		$response = array('msg'=>$err_msg,'status'=>0);
//		$tdata[] = $response;
//		echo json_encode($tdata);
//		exit(0);
//	}
//	
//	for($i=0,$j=1;$i<count($arr_vloc_parent_cat_id);$i++,$j++)
//	{
//		if($arr_vloc_parent_cat_id[$i] == '')
//		{
//			$error = true;
//			$err_msg = 'Please select main profile for location row: '.$j;
//		
//			$tdata = array();
//			$response = array('msg'=>$err_msg,'status'=>0);
//			$tdata[] = $response;
//			echo json_encode($tdata);
//			exit(0);
//		}
//		
//		if($arr_vloc_cat_id[$i] == '')
//		{
//			$error = true;
//			$err_msg = 'Please select category for location row: '.$j;
//		
//			$tdata = array();
//			$response = array('msg'=>$err_msg,'status'=>0);
//			$tdata[] = $response;
//			echo json_encode($tdata);
//			exit(0);
//		}
//		
//		if($arr_country_id[$i] == '')
//		{
//			$error = true;
//			$err_msg = 'Please select country for location row: '.$j;
//		
//			$tdata = array();
//			$response = array('msg'=>$err_msg,'status'=>0);
//			$tdata[] = $response;
//			echo json_encode($tdata);
//			exit(0);
//		}
//		
//		if($arr_state_id[$i] == '')
//		{
//			$error = true;
//			$err_msg = 'Please select state for location row: '.$j;
//		
//			$tdata = array();
//			$response = array('msg'=>$err_msg,'status'=>0);
//			$tdata[] = $response;
//			echo json_encode($tdata);
//			exit(0);
//		}
//		
//		if($arr_city_id[$i] == '')
//		{
//			$error = true;
//			$err_msg = 'Please select city for location row: '.$j;
//		
//			$tdata = array();
//			$response = array('msg'=>$err_msg,'status'=>0);
//			$tdata[] = $response;
//			echo json_encode($tdata);
//			exit(0);
//		}
//		
//		if($arr_area_id[$i] == '')
//		{
//			$error = true;
//			$err_msg = 'Please select area for location row: '.$j;
//		
//			$tdata = array();
//			$response = array('msg'=>$err_msg,'status'=>0);
//			$tdata[] = $response;
//			echo json_encode($tdata);
//			exit(0);
//		}
//		
//		if($arr_contact_person_title[$i] == '')
//		{
//			$error = true;
//			$err_msg = 'Please select gender for location row: '.$j;
//		
//			$tdata = array();
//			$response = array('msg'=>$err_msg,'status'=>0);
//			$tdata[] = $response;
//			echo json_encode($tdata);
//			exit(0);
//		}
//		
//		if($arr_contact_person[$i] == '')
//		{
//			$error = true;
//			$err_msg = 'Please select contact person name for location row: '.$j;
//		
//			$tdata = array();
//			$response = array('msg'=>$err_msg,'status'=>0);
//			$tdata[] = $response;
//			echo json_encode($tdata);
//			exit(0);
//		}
//		
////		if($i == 0)
////		{
////			if($arr_contact_email[$i] == '')
////			{
////				$error = true;
////				$err_msg = 'Please enter email for location row: '.$j;
////			
////				$tdata = array();
////				$response = array('msg'=>$err_msg,'status'=>0);
////				$tdata[] = $response;
////				echo json_encode($tdata);
////				exit(0);
////			}
////			elseif(filter_var($arr_contact_email[$i], FILTER_VALIDATE_EMAIL) === false)
////			{
////				$error = true;
////				$err_msg = 'Please enter valid email for location row: '.$j;
////				
////				$tdata = array();
////				$response = array('msg'=>$err_msg,'status'=>0);
////				$tdata[] = $response;
////				echo json_encode($tdata);
////				exit(0);
////			}
////			elseif($obj->chkVendorEmailExists($arr_contact_email[$i]))
////			{
////				$error = true;
////				$err_msg = 'Vendor email already exists';
////			
////				$tdata = array();
////				$response = array('msg'=>$err_msg,'status'=>0);
////				$tdata[] = $response;
////				echo json_encode($tdata);
////				exit(0);
////			}
////
////			if($arr_contact_number[$i] == '')
////			{
////				$error = true;
////				$err_msg = 'Please enter contact number for location row: '.$j;
////			
////				$tdata = array();
////				$response = array('msg'=>$err_msg,'status'=>0);
////				$tdata[] = $response;
////				echo json_encode($tdata);
////				exit(0);
////			}	
////		}
////		
////		for($k=0,$l=1;$k<count($arr_vc_cert_type_id[$i]);$k++,$l++)
////		{
////			if($arr_vc_cert_type_id[$i][$k] == '')
////			{
////				$error = true;
////				$err_msg = 'Please select type for location row: '.$j.' , certificate row: '.$l;
////			
////				$tdata = array();
////				$response = array('msg'=>$err_msg,'status'=>0);
////				$tdata[] = $response;
////				echo json_encode($tdata);
////				exit(0);
////			}
////			
////			if($arr_vc_cert_name[$i][$k] == '')
////			{
////				$error = true;
////				$err_msg = 'Please enter certificate name for location row: '.$j.' , certificate row: '.$l;
////			
////				$tdata = array();
////				$response = array('msg'=>$err_msg,'status'=>0);
////				$tdata[] = $response;
////				echo json_encode($tdata);
////				exit(0);
////			}
////			
////			if($arr_vc_cert_no[$i][$k] == '')
////			{
////				$error = true;
////				$err_msg = 'Please enter certificate number for location row: '.$j.' , certificate row: '.$l;
////			
////				$tdata = array();
////				$response = array('msg'=>$err_msg,'status'=>0);
////				$tdata[] = $response;
////				echo json_encode($tdata);
////				exit(0);
////			}
////			
////			if($arr_vc_cert_issued_by[$i][$k] == '')
////			{
////				$error = true;
////				$err_msg = 'Please enter certificate issued by for location row: '.$j.' , certificate row: '.$l;
////			
////				$tdata = array();
////				$response = array('msg'=>$err_msg,'status'=>0);
////				$tdata[] = $response;
////				echo json_encode($tdata);
////				exit(0);
////			}
////			
////			if($arr_vc_cert_reg_date[$i][$k] == '')
////			{
////				$error = true;
////				$err_msg = 'Please enter certificate issued date for location row: '.$j.' , certificate row: '.$l;
////			
////				$tdata = array();
////				$response = array('msg'=>$err_msg,'status'=>0);
////				$tdata[] = $response;
////				echo json_encode($tdata);
////				exit(0);
////			}
////			
////			if($arr_vc_cert_validity_date[$i][$k] == '')
////			{
////				$error = true;
////				$err_msg = 'Please enter certificate validity date for location row: '.$j.' , certificate row: '.$l;
////			
////				$tdata = array();
////				$response = array('msg'=>$err_msg,'status'=>0);
////				$tdata[] = $response;
////				echo json_encode($tdata);
////				exit(0);
////			}
////			
////			if($arr_vc_cert_reg_date[$i][$k] != '' && $arr_vc_cert_validity_date[$i][$k] != '')
////			{
////				if(strtotime($arr_vc_cert_reg_date[$i][$k]) > strtotime($arr_vc_cert_validity_date[$i][$k]))
////				{
////					$error = true;
////					$err_msg = 'Issued date must be lesser than validity date for location row: '.$j.' , certificate row: '.$l;
////				
////					$tdata = array();
////					$response = array('msg'=>$err_msg,'status'=>0);
////					$tdata[] = $response;
////					echo json_encode($tdata);
////					exit(0);
////				}
////			}
////		}
//	}
//	
	if(!$error)
	{
		$picture_size_limit = 5120;
		$error = false;
		$err_msg = '';

		// Define a destination
		$targetFolder = SITE_PATH . '/uploads'; // Relative to the root

		$arr_vloc_doc_file = array();
		$arr_vloc_menu_file = array();
		for($i=0,$j=1;$i<count($arr_vloc_parent_cat_id);$i++,$j++)
		{
			if(isset($_FILES['vloc_doc_file']['name'][$i]) && $_FILES['vloc_doc_file']['name'][$i] != '')
			{
				$tempFile = $_FILES['vloc_doc_file']['tmp_name'][$i];

				$filename = date('dmYHis') . '_' . $_FILES['vloc_doc_file']['name'][$i];
				$filename = str_replace(' ', '-', $filename);

				$targetPath = $targetFolder;
				$targetFile = rtrim($targetPath, '/') . '/' . $filename;
				$mimetype = $_FILES['vloc_doc_file']['type'][$i];

				// Validate the file type
				$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF'); // File extensions
				$fileParts = pathinfo($_FILES['vloc_doc_file']['name'][$i]);

				if (in_array($fileParts['extension'], $fileTypes))
				{
					$vloc_doc_file = $_FILES['vloc_doc_file']['name'][$i];
					$size_in_kb = $_FILES['vloc_doc_file']['size'][$i] / 1024;
					$file4 = substr($vloc_doc_file, -4, 4);
					if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF'))
					{
						$error = true;
						$err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) file for upload doc on location row: '.$j;
					}
					elseif ($size_in_kb > $picture_size_limit)
					{
						$error = true;
						$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb for upload doc on location row: '.$j;
					}

					if (!$error)
					{
						$vloc_doc_file = $filename;

						if (!move_uploaded_file($tempFile, $targetFile))
						{
							if (file_exists($targetFile))
							{
								unlink($targetFile);
							} // Remove temp file
							$error = true;
							$err_msg = 'Couldn\'t upload file for upload doc on location row: '.$j;
						}
					}
				}
				else
				{
					$error = true;
					$err_msg = 'Invalid file type for upload doc on location row: '.$j;
				}

				if($error)
				{
					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);
				}
				else
				{
					$arr_vloc_doc_file[$i] = $filename;
				}						
			}
			else
			{
				$arr_vloc_doc_file[$i] = '';	
			}
			
			if(isset($_FILES['vloc_menu_file']['name'][$i]) && $_FILES['vloc_menu_file']['name'][$i] != '')
			{
				$tempFile = $_FILES['vloc_menu_file']['tmp_name'][$i];

				$filename = date('dmYHis') . '_' . $_FILES['vloc_menu_file']['name'][$i];
				$filename = str_replace(' ', '-', $filename);

				$targetPath = $targetFolder;
				$targetFile = rtrim($targetPath, '/') . '/' . $filename;
				$mimetype = $_FILES['vloc_menu_file']['type'][$i];

				// Validate the file type
				$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF'); // File extensions
				$fileParts = pathinfo($_FILES['vloc_menu_file']['name'][$i]);

				if (in_array($fileParts['extension'], $fileTypes))
				{
					$vloc_menu_file = $_FILES['vloc_menu_file']['name'][$i];
					$size_in_kb = $_FILES['vloc_menu_file']['size'][$i] / 1024;
					$file4 = substr($vloc_menu_file, -4, 4);
					if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF'))
					{
						$error = true;
						$err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) file for upload menu on location row: '.$j;
					}
					elseif ($size_in_kb > $picture_size_limit)
					{
						$error = true;
						$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb for upload menu on location row: '.$j;
					}

					if (!$error)
					{
						$vloc_menu_file = $filename;

						if (!move_uploaded_file($tempFile, $targetFile))
						{
							if (file_exists($targetFile))
							{
								unlink($targetFile);
							} // Remove temp file
							$error = true;
							$err_msg = 'Couldn\'t upload file for upload menu on location row: '.$j;
						}
					}
				}
				else
				{
					$error = true;
					$err_msg = 'Invalid file type for upload menu on location row: '.$j;
				}

				if($error)
				{
					$tdata = array();
					$response = array('msg'=>$err_msg,'status'=>0);
					$tdata[] = $response;
					echo json_encode($tdata);
					exit(0);
				}
				else
				{
					$arr_vloc_menu_file[$i] = $filename;
				}						
			}
			else
			{
				$arr_vloc_menu_file[$i] = '';	
			}
		}
	}
	
	if(!$error)
	{
		$picture_size_limit = 5120;
		$error = false;
		$err_msg = '';

		// Define a destination
		$targetFolder = SITE_PATH . '/uploads'; // Relative to the root

		$arr_vc_cert_scan_file = array();
		for($i=0;$i<count($arr_cert_loop_cnt);$i++)
		{
			$arr_vc_cert_scan_file[$i] = array();
			for($k=0,$l=1;$k<count($arr_vc_cert_type_id[$i]);$k++,$l++)
			{
				if(isset($_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['name'][$k]) && $_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['name'][$k] != '')
				{
					$tempFile = $_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['tmp_name'][$k];

					$filename = date('dmYHis') . '_' . $_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['name'][$k];
					$filename = str_replace(' ', '-', $filename);

					$targetPath = $targetFolder;
					$targetFile = rtrim($targetPath, '/') . '/' . $filename;
					$mimetype = $_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['type'][$k];

					// Validate the file type
					$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF'); // File extensions
					$fileParts = pathinfo($_FILES['vc_cert_scan_file_'.$i]['name'][$k]);

					if (in_array($fileParts['extension'], $fileTypes))
					{
						$vc_cert_scan_file = $_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['name'][$k];
						$size_in_kb = $_FILES['vc_cert_scan_file_'.$arr_cert_loop_cnt[$i]]['size'][$k] / 1024;
						$file4 = substr($vc_cert_scan_file, -4, 4);
						if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF'))
						{
							$error = true;
							$err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) file for scan file on location row: '.$j.' , certificate row: '.$l;
						}
						elseif ($size_in_kb > $picture_size_limit)
						{
							$error = true;
							$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb for scan file on location row: '.$j.' , certificate row: '.$l;
						}

						if (!$error)
						{
							$vc_cert_scan_file = $filename;

							if (!move_uploaded_file($tempFile, $targetFile))
							{
								if (file_exists($targetFile))
								{
									unlink($targetFile);
								} // Remove temp file
								$error = true;
								$err_msg = 'Couldn\'t upload file for scan file on location row: '.$j.' , certificate row: '.$l;
							}
						}
					}
					else
					{
						$error = true;
						$err_msg = 'Invalid file type for scan file on location row: '.$j.' , certificate row: '.$l;
					}

					if($error)
					{
						$tdata = array();
						$response = array('msg'=>$err_msg,'status'=>0);
						$tdata[] = $response;
						echo json_encode($tdata);
						exit(0);
					}
					else
					{
						$arr_vc_cert_scan_file[$i][$k] = $filename;
					}						
				}
				else
				{
					$arr_vc_cert_scan_file[$i][$k] = '';	
				}
			}		
		}	
	}
	
	
	if(!$error)
	{
		for($i=0,$j=1;$i<count($arr_vloc_parent_cat_id);$i++,$j++)
		{
			for($k=0,$l=1;$k<count($arr_vc_cert_reg_date[$i]);$k++,$l++)
			{
				if($arr_vc_cert_reg_date[$i][$k] != '')
				{
					$arr_vc_cert_reg_date[$i][$k] = date('Y-m-d',strtotime($arr_vc_cert_reg_date[$i][$k]));
				}
				
				if($arr_vc_cert_validity_date[$i][$k] != '')
				{
					$arr_vc_cert_validity_date[$i][$k] = date('Y-m-d',strtotime($arr_vc_cert_validity_date[$i][$k]));
				}
			}	

			$arr_vloc_speciality_offered[$i] = implode(',',$arr_vloc_speciality_offered[$i]);
		}
		
		$tdata = array();
//		$tdata['va_id'] = $va_id;
		$tdata['admin_id'] = 0;
		$tdata['service_cat'] = $vendor_parent_cat_id;
		$tdata['vendor_cat_id'] = $vendor_cat_id;
		$tdata['vendor_name'] = $vendor_name;
		$tdata['vendor_username'] = $vendor_username;
		$tdata['vendor_password'] = $vendor_password;
		$tdata['vendor_email'] = $arr_contact_email[0];
		$tdata['vendor_status'] = '0';
		$tdata['contact_person'] = $arr_contact_person;
		$tdata['contact_person_title'] = $arr_contact_person_title;
		$tdata['contact_email'] = $arr_contact_email;
		$tdata['contact_number'] = $arr_contact_number;
		$tdata['contact_designation'] = $arr_contact_designation;
		$tdata['contact_remark'] = $arr_contact_remark;
		$tdata['country_id'] = $arr_country_id;
		$tdata['state_id'] = $arr_state_id;
		$tdata['city_id'] = $arr_city_id;
		$tdata['area_id'] = $arr_area_id;
		$tdata['vloc_parent_cat_id'] = $arr_vloc_parent_cat_id;
		$tdata['vloc_cat_id'] = $arr_vloc_cat_id;
		$tdata['vloc_speciality_offered'] = $arr_vloc_speciality_offered;
		$tdata['vloc_doc_file'] = $arr_vloc_doc_file;
		$tdata['vloc_menu_file'] = $arr_vloc_menu_file;
		$tdata['vc_cert_type_id'] = $arr_vc_cert_type_id;
		$tdata['vc_cert_name'] = $arr_vc_cert_name;
		$tdata['vc_cert_no'] = $arr_vc_cert_no;
		$tdata['vc_cert_issued_by'] = $arr_vc_cert_issued_by;
		$tdata['vc_cert_reg_date'] = $arr_vc_cert_reg_date;
		$tdata['vc_cert_validity_date'] = $arr_vc_cert_validity_date;
		$tdata['vc_cert_scan_file'] = $arr_vc_cert_scan_file;
		$tdata['new_vendor'] = 1;
		
		if($obj->addVendor($tdata))
		{
//			$obj->sendSignUpEmailToVendor($tdata['vendor_email']);
			$msg = 'Record Added Successfully!';
			$ref_url = SITE_URL."/messages.php?id=5";
			header('Location: ../validate_pro_user.php');	
                        exit(0);
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


?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo SITE_NAME;?> - Business Associates</title>
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
							<h3><?php // echo $obj->getVendorAccessFormTitle($vaf_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="register" name="register" enctype="multipart/form-data" method="post"> 
						<?php
//						$default_vendor_parent_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'vendor_parent_cat_id');
//						$vendor_parent_cat_id = $default_vendor_parent_cat_id;
//						$default_vendor_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'vendor_cat_id');
//						
//						$default_vloc_parent_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'vloc_parent_cat_id');
//						$arr_vloc_parent_cat_id[0] = $default_vloc_parent_cat_id;
//						$default_vloc_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'vloc_cat_id');
						
						
						?>	
						<input type="hidden" name="va_id" id="va_id" value="<?php echo $va_id;?>">
						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">
						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">
						
						<div class="form-group">
						<?php //
//						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vendor_parent_cat_id'))
//						{ ?>
							<?php	
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vendor_cat_id'))
//							{ ?>
<!--							<label class="col-lg-2 control-label">Category<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="vendor_parent_cat_id" id="vendor_parent_cat_id" class="form-control" onchange="getMainCategoryOptionCommon('vendor','1','<?php echo $default_vendor_cat_id;?>');" required  >
									<?php echo $obj->getMainProfileOption($vendor_parent_cat_id,'1','0',$default_vendor_parent_cat_id);?>
								</select>
							</div>	-->
<!--							<div class="col-lg-2"></div>
							<div class="col-lg-4">
								<select name="vendor_cat_id" id="vendor_cat_id" class="form-control" required>
									<?php echo $obj->getMainCategoryOption($vendor_parent_cat_id,$vendor_cat_id,'1','0',$default_vendor_cat_id); ?>
								</select>
							</div>-->
							<?php	
//							}
//							else
//							{ ?>
							<label class="col-lg-2 control-label">Service Category<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="service_cat" id="service_cat" class="form-control" >
                                                                    <option value="">Select Service Category</option>
									<?php echo $obj->getFavCategoryRamakant('53',$fav_cat);?>
								</select>
							</div>
                                                        
<!--                                                        <label class="col-lg-2 control-label">Category<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="vendor_cat_id" id="vendor_cat_id" class="form-control" >
									<?php echo $obj->getMainCategoryOption($vendor_parent_cat_id,$vendor_cat_id,'1','0',$default_vendor_cat_id); ?>
								</select>
							</div>-->
							
							<!--<input type="text" name="vendor_cat_id" id="vendor_cat_id" value="<?php echo $default_vendor_cat_id;?>">-->	
							<?php
//							}
//						}
//						else
//						{
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vendor_cat_id'))
//							{ ?>
<!--							<input type="hidden" name="vendor_parent_cat_id" id="vendor_parent_cat_id" value="<?php echo $default_vendor_parent_cat_id;?>">	
-->							<?php	
//							}
//							else
//							{ ?>
<!--							<input type="hidden" name="vendor_parent_cat_id" id="vendor_parent_cat_id" value="<?php echo $default_vendor_parent_cat_id;?>">	
							<input type="hidden" name="vendor_cat_id" id="vendor_cat_id" value="<?php echo $default_vendor_cat_id;?>">	-->
							<?php	
//							}								
//						} ?>
							
							
						</div>
						
						<?php
//						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vendor_name'))
//						{ ?>
						<div class="form-group"><label class="col-lg-2 control-label">Company Name<span style="color:red">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="vendor_name" id="vendor_name" value="<?php echo $vendor_name;?>" placeholder="Company Name" class="form-control" >
							</div>
						</div>
						<?php
//						} 
//						else
//						{ ?>
							<!--<input type="hidden" name="vendor_name" id="vendor_name" value="<?php echo $vendor_name;?>" >-->
						<?php
//						} ?>
						
						
						<div class="form-group">
						<?php
//						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vendor_username'))
//						{ ?>	
							<label class="col-lg-2 control-label">Email Id<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="email" name="vendor_username" id="vendor_username" value="<?php echo $vendor_username;?>" placeholder="Email Id" class="form-control" >
							</div>
						<?php
//						} 
//						else
//						{ ?>
							<!--<input type="hidden" name="vendor_username" id="vendor_username" value="<?php echo $vendor_username;?>" >-->
						<?php
//						} ?>
						
						<?php
//						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vendor_password'))
//						{ ?>	
							<label class="col-lg-2 control-label">Password<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="password" name="vendor_password" id="vendor_password" value="" placeholder="Vendor Password" class="form-control" >
							</div>
						<?php
//						} 
//						else
//						{ ?>
							<!--<input type="hidden" name="vendor_password" id="vendor_password" value="<?php echo $vendor_password;?>" >-->
						<?php
//						} ?>	
						</div>
						
					<?php 
					for($i=0;$i<$cat_total_cnt;$i++)
					{ ?>
						<div id="row_loc_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
							<input type="hidden" name="cert_cnt_<?php echo $i;?>" id="cert_cnt_<?php echo $i;?>" value="<?php echo $arr_cert_cnt[$i];?>">
							<input type="hidden" name="cert_total_cnt_<?php echo $i;?>" id="cert_total_cnt_<?php echo $i;?>" value="<?php echo $arr_cert_total_cnt[$i];?>">
							<input type="hidden" name="cert_loop_cnt[]" id="cert_loop_cnt_<?php echo $i;?>" value="<?php echo $i;?>">
							<input type="hidden" name="hdnvloc_doc_file[]" id="hdnvloc_doc_file_<?php echo $i;?>" value="">
							<input type="hidden" name="hdnvloc_menu_file[]" id="hdnvloc_menu_file_<?php echo $i;?>" value="">
							<input type="hidden" name="vloc_id[]" id="vloc_id_<?php echo $i;?>" value="0">
							<div class="form-group left-label">
								<label class="col-lg-3 control-label"><strong>Location and Contact Details:</strong></label>
							</div>
							<div class="form-group">
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_parent_cat_id'))
//							{ 
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_cat_id'))
//								{  ?>
								<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_<?php echo $i;?>" class="form-control"  onchange="getMainCategoryOptionAddMoreCommon('vloc',<?php echo $i;?>,'<?php echo $default_vloc_cat_id;?>');"   >
									<option value="">Select Category</option>
									<?php echo $obj->getFavCategoryRamakant('45',$fav_cat);?>
                                                                        </select>
								</div>	
<!--								<div class="col-lg-2"></div>
								<div class="col-lg-4">
									<select name="vloc_cat_id[]" id="vloc_cat_id_<?php echo $i;?>" class="form-control" required>
										<?php echo $obj->getMainCategoryOption($arr_vloc_parent_cat_id[$i],$arr_vloc_cat_id[$i],'1','0',$default_vloc_cat_id); ?>
									</select>
								</div>-->
								<?php
//								}
//								else
//								{ ?>
<!--								<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_<?php echo $i;?>" class="form-control"  required  >
										<?php echo $obj->getMainProfileOption($arr_vloc_parent_cat_id[$i],'1','0',$default_vloc_parent_cat_id);?>
									</select>
								</div>
								<input type="hidden" name="vloc_cat_id[]" id="vloc_cat_id_<?php echo $i;?>" value="<?php echo $arr_vloc_cat_id[$i];?>" >	-->
								<?php	
//								}
//							}
//							else
//							{
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_cat_id'))
//								{ ?> 
<!--								<input type="hidden" name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_<?php echo $i;?>" value="<?php echo $arr_vloc_parent_cat_id[$i];?>" >	-->
<!--								<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="vloc_cat_id[]" id="vloc_cat_id_<?php echo $i;?>" class="form-control" >
										<?php echo $obj->getMainCategoryOption($arr_vloc_parent_cat_id[$i],$arr_vloc_cat_id[$i],'1','0',$default_vloc_cat_id); ?>
									</select>
								</div>-->
								<?php
//								}
//								else
//								{ ?>
<!--								<input type="hidden" name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_<?php echo $i;?>" value="<?php echo $arr_vloc_parent_cat_id[$i];?>" >	
								<input type="hidden" name="vloc_cat_id[]" id="vloc_cat_id_<?php echo $i;?>" value="<?php echo $arr_vloc_cat_id[$i];?>" >	-->
								<?php	
//								}									
//							} ?>
							</div>
							<div class="form-group" >	
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'country_id'))
//							{ ?>		
								<label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="country_id[]" id="country_id_<?php echo $i;?>" onchange="getStateOptionAddMore(<?php echo $i;?>)" class="form-control" >
										<?php echo $obj->getCountryOption($arr_country_id[$i]); ?>
									</select>
								</div>
							<?php
//							}
//							else
//							{ ?>
								<!--<input type="hidden" name="country_id[]" id="country_id_<?php echo $i;?>" value="<?php echo $arr_country_id[$i];?>" >-->	
							<?php	
//							}
//							
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'state_id'))
//							{ ?>			
								<label class="col-lg-2 control-label">State<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="state_id[]" id="state_id_<?php echo $i;?>" onchange="getCityOptionAddMore(<?php echo $i;?>)" class="form-control" >
										<?php echo $obj->getStateOption($arr_country_id[$i],$arr_state_id[$i]); ?>
									</select>
								</div>
							<?php
//							}
//							else
//							{ ?>
								<!--<input type="hidden" name="state_id[]" id="state_id_<?php echo $i;?>" value="<?php echo $arr_state_id[$i];?>" >-->	
							<?php	
//							} ?>	
							</div>
							<div class="form-group">	
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'city_id'))
//							{ ?>			
								<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="city_id[]" id="city_id_<?php echo $i;?>" onchange="getAreaOptionAddMore(<?php echo $i;?>)" class="form-control" >
										<?php echo $obj->getCityOption($arr_country_id[$i],$arr_state_id[$i],$arr_city_id[$i]); ?>
									</select>
								</div>
							<?php
//							}
//							else
//							{ ?>
<!--								<input type="hidden" name="city_id[]" id="city_id_<?php echo $i;?>" value="<?php echo $arr_city_id[$i];?>" >	-->
							<?php	
//							}
							
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'area_id'))
//							{ ?>				
								<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="area_id[]" id="area_id_<?php echo $i;?>" class="form-control" >
										<?php echo $obj->getAreaOption($arr_country_id[$i],$arr_state_id[$i],$arr_city_id[$i],$arr_area_id[$i]); ?>
									</select>
								</div>
							<?php
//							}
//							else
//							{ ?>
								<!--<input type="hidden" name="area_id[]" id="area_id_<?php echo $i;?>" value="<?php echo $arr_area_id[$i];?>" >-->	
							<?php	
//							} ?>	
							</div>
							<div class="form-group">
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_person_title'))
//							{ ?>
								<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="contact_person_title[]" id="contact_person_title_<?php echo $i;?>" class="form-control" >
										<?php echo $obj->getPersonTitleOption($arr_contact_person_title[$i]);?>
									</select>
								</div>
							<?php
//							}
//							else
//							{ ?>
								<!--<input type="hidden" name="contact_person_title[]" id="contact_person_title_//<?php echo $i;?>" value="<?php echo $arr_contact_person_title[$i];?>" >-->	
							<?php	
//							} 
//							
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_person'))
//							{ ?>
								<label class="col-lg-2 control-label">Contact Person Name<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<input type="text" name="contact_person[]" id="contact_person_<?php echo $i;?>" value="<?php echo $arr_contact_person[$i]?>" placeholder="Contact Person" class="form-control" >
								</div>
							<?php
//							}
//							else
//							{ ?>
								<!--<input type="hidden" name="contact_person[]" id="contact_person_<?php echo $i;?>" value="<?php echo $arr_contact_person[$i];?>" >-->	
							<?php	
//							} ?>			
								
							</div>
							
							<div class="form-group">
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_email'))
//							{ ?>
								<label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<input type="text" name="contact_email[]" id="contact_email_<?php echo $i;?>" value="<?php echo $arr_contact_email[$i]?>" placeholder="Contact Email" class="form-control" >
								</div>
							<?php
//							}
//							else
//							{ ?>
								<!--<input type="hidden" name="contact_email[]" id="contact_email_<?php echo $i;?>" value="<?php echo $arr_contact_email[$i];?>" >-->	
							<?php	
//							} 
//							
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_number'))
//							{ ?>
								<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<input type="text" name="contact_number[]" id="contact_number_<?php echo $i;?>" value="<?php echo $arr_contact_number[$i]?>" placeholder="Contact Number" class="form-control" >
								</div>
							<?php
//							}
//							else
//							{ ?>
<!--								<input type="hidden" name="contact_number[]" id="contact_number_<?php echo $i;?>" value="<?php echo $arr_contact_number[$i];?>" >	-->
							<?php	
//							} ?>	
							</div>
						
							<div class="form-group">
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_designation'))
//							{ ?>
								<label class="col-lg-2 control-label">Contact Designation</label>
								<div class="col-lg-4">
									<select name="contact_designation[]" id="contact_designation_<?php echo $i;?>" class="form-control">
                                                                            <option value="">Select Designation</option>	
                                                                            <?php echo $obj->getFavCategoryRamakant('44',$fav_cat);?>
									</select>
								</div>
							<?php
//							}
//							else
//							{ ?>
<!--								<input type="hidden" name="contact_designation[]" id="contact_designation_<?php echo $i;?>" value="<?php echo $arr_contact_designation[$i];?>" >	-->
							<?php	
//							} ?>

							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_remark'))
//							{ ?>	
								<label class="col-lg-2 control-label">Remark</label>
								<div class="col-lg-4">
									<input type="text" name="contact_remark[]" id="contact_remark_<?php echo $i;?>" value="<?php echo $arr_contact_remark[$i]?>" placeholder="Remark" class="form-control">
								</div>
							<?php
//							}
//							else
//							{ ?>
								<!--<input type="hidden" name="contact_remark[]" id="contact_remark_<?php echo $i;?>" value="<?php echo $arr_contact_remark[$i];?>" >-->	
							<?php	
//							} ?>	
							</div>
							
							<div class="form-group">
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_speciality_offered'))
//							{ ?>	
								<label class="col-lg-2 control-label">Speciality Offered</label>
								<div class="col-lg-10">
									<select name="vloc_speciality_offered_<?php echo $i;?>[]" id="vloc_speciality_offered_<?php echo $i;?>" multiple="multiple" class="form-control vloc_speciality_offered" >
										<?php // echo $obj->getVendorSpecialityOfferedOption($arr_vloc_speciality_offered[$i],'1','1'); ?>
										<?php $abc= $obj->getProfSpecialityOfferedOptionVivek('44'); ?>
									</select>
								</div>
							<?php
//							}
//							else
//							{ ?>
								<!--<input type="hidden" name="vloc_speciality_offered[]" id="vloc_speciality_offered_<?php echo $i;?>" value="<?php echo $arr_vloc_speciality_offered[$i];?>" >-->	
							<?php	
//							} ?>		
							</div>	
							<div class="form-group">	
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_menu_file'))
//							{ ?>	
								<label class="col-lg-2 control-label">Menu Image/Pdf</label>
								<div class="col-lg-4">
									<input type="file" name="vloc_menu_file[]" id="vloc_menu_file_<?php echo $i;?>" class="form-control">
								</div>
							<?php
//							} ?>
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_doc_file'))
//							{ ?>	
								<label class="col-lg-2 control-label">Vendor Estt Pdf</label>
								<div class="col-lg-4">
									<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_<?php echo $i;?>" class="form-control">
								</div>
							<?php
//							} ?>	
							</div>
							
							<div class="form-group left-label">
								<label class="col-lg-6 control-label"><strong>Licences, Registration, Certification & Memberships:</strong></label>
							</div>
							<?php 
							for($k=0;$k<$arr_cert_total_cnt[$i];$k++)
							{ ?>
							<div id="row_cert_<?php if($k == 0){ echo $i.'_first';}else{ echo $i.'_'.$k;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
								<input type="hidden" name="vc_cert_id_<?php echo $i;?>[]" id="vc_cert_id_<?php echo $i;?>_<?php echo $k;?>" value="0">
								<input type="hidden" name="hdnvc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" id="hdnvc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" value="">
								<div class="form-group small-title">
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_type_id'))
//								{ ?>
									<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>
									<div class="col-lg-5">
										<select name="vc_cert_type_id_<?php echo $i;?>[]" id="vc_cert_type_id_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >
											<?php echo $obj->getCertficationTypeOption($arr_vc_cert_type_id[$i][$k]); ?>
										</select>
									</div>
								<?php
//								}
//								else
//								{ ?>
									<!--<input type="hidden" name="vc_cert_type_id_<?php echo $i;?>[]" id="vc_cert_type_id_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_type_id[$i][$k];?>" >-->
								<?php		
//								} ?>									
									
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_name'))
//								{ ?>	
									<label class="col-lg-1 control-label">Name</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_name_<?php echo $i;?>[]" id="vc_cert_name_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_name[$i][$k];?>" placeholder="Name" class="form-control" >
									</div>
								<?php
//								}
//								else
//								{ ?>
<!--									<input type="hidden" name="vc_cert_name_<?php echo $i;?>[]" id="vc_cert_name_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_name[$i][$k];?>" >-->
								<?php		
//								} ?>	
								</div>	
								<div class="form-group small-title">
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_no'))
//								{ ?>
									<label class="col-lg-1 control-label">Number</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_no_<?php echo $i;?>[]" id="vc_cert_no_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_no[$i][$k];?>" placeholder="Number" class="form-control" >
									</div>
								<?php
//								}
//								else
//								{ ?>
									<!--<input type="hidden" name="vc_cert_no_<?php echo $i;?>[]" id="vc_cert_no_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_no[$i][$k];?>" >-->
								<?php		
//								} ?>

								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_issued_by'))
//								{ ?>	
									<label class="col-lg-1 control-label">Issued By</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_issued_by_<?php echo $i;?>[]" id="vc_cert_issued_by_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_issued_by[$i][$k];?>" placeholder="Issued By" class="form-control" >
									</div>
								<?php
//								}
//								else
//								{ ?>
									<!--<input type="hidden" name="vc_cert_issued_by_<?php echo $i;?>[]" id="vc_cert_issued_by_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_issued_by[$i][$k];?>" >-->
								<?php		
//								} ?>	
								</div>	
								<div class="form-group small-title">
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_reg_date'))
//								{ ?>
									<label class="col-lg-1 control-label">Issued Date</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_reg_date_<?php echo $i;?>[]" id="vc_cert_reg_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_reg_date[$i][$k];?>" placeholder="Issued Date" class="form-control clsdatepicker2" >
									</div>
								<?php
//								}
//								else
//								{ ?>
<!--									<input type="hidden" name="vc_cert_reg_date_<?php echo $i;?>[]" id="vc_cert_reg_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_reg_date[$i][$k];?>" >-->
								<?php		
//								} ?>

								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_validity_date'))
//								{ ?>	
									<label class="col-lg-1 control-label">Vaidity Date</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_validity_date_<?php echo $i;?>[]" id="vc_cert_validity_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_validity_date[$i][$k];?>" placeholder="Validity Date" class="form-control clsdatepicker" >
									</div>
								<?php
//								}
//								else
//								{ ?>
									<!--<input type="hidden" name="vc_cert_validity_date_<?php echo $i;?>[]" id="vc_cert_validity_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_validity_date[$i][$k];?>" >-->
								<?php		
//								} ?>	
								</div>
								<div class="form-group small-title">
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_validity_date'))
//								{ ?>	
									<label class="col-lg-1 control-label">Scan Image</label>
									<div class="col-lg-5">
										<input type="file" name="vc_cert_scan_file_<?php echo $i;?>[]" id="vc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >
									</div>
								<?php		
//								} ?>		
								</div>
								<div class="form-group">
									<div class="col-lg-2">
									<?php
									if($k == 0)
									{ ?>
										<a href="javascript:void(0);" onclick="addMoreRowCertificate(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>
									<?php  	
									}
									else
									{ ?>
										<a href="javascript:void(0);" onclick="removeRowCertificate(<?php echo $i;?>,<?php echo $k;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>
									<?php	
									}
									?>	
									</div>
								</div>
							</div>	
							<?php
							} ?>
							<div class="form-group">
								<div class="col-lg-2">
								<?php
								if($i == 0)
								{ ?>
									<a href="javascript:void(0);" onclick="addMoreRowLocation();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>
								<?php  	
								}
								else
								{ ?>
									<a href="javascript:void(0);" onclick="removeRowLocation(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>
								<?php	
								}
								?>	
								</div>
							</div>
						</div>
					<?php 
					} ?>
						
						
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
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
<!--<script src="admin-js/register-validator.js" type="text/javascript"></script>-->
<script src="js/tokenize2.js"></script>
<script>
	$(document).ready(function()
	{
		$('.vloc_speciality_offered').tokenize2();
		$('.clsdatepicker').datepicker();
		$('.clsdatepicker2').datepicker({endDate: new Date});
	});	
	
	function getStateOptionAddMore(id_val)
	{
		var country_id = $('#country_id_'+id_val).val();
		var state_id = $('#state_id_'+id_val).val();
		
		if(country_id == null)
		{
			country_id = '-1';
		}
		
		if(state_id == null)
		{
			state_id = '-1';
		}
		
		
		var dataString ='country_id='+country_id+'&state_id='+state_id+'&action=getstateoption';
		$.ajax({
			type: "POST",
			url: "ajax/remote.php",
			data: dataString,
			cache: false,      
			success: function(result)
			{
                            alert(result);
				$("#state_id_"+id_val).html(result);
				getCityOptionAddMore(id_val);
			}
		});
	}
	
	function getCityOptionAddMore(id_val)
	{
		var country_id = $('#country_id_'+id_val).val();
		var state_id = $('#state_id_'+id_val).val();
		var city_id = $('#city_id_'+id_val).val();
		
		if(country_id == null)
		{
			country_id = '-1';
		}
				
		if(state_id == null)
		{
			state_id = '-1';
		}
		
		if(city_id == null)
		{
			city_id = '-1';
		}
		
		var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&action=getcityoption';
		$.ajax({
			type: "POST",
			url: "ajax/remote.php",
			data: dataString,
			cache: false,      
			success: function(result)
			{
				$("#city_id_"+id_val).html(result);
				getAreaOptionAddMore(id_val);
			}
		});
	}
	
	function getAreaOptionAddMore(id_val)
	{
		var country_id = $('#country_id_'+id_val).val();
		var state_id = $('#state_id_'+id_val).val();
		var city_id = $('#city_id_'+id_val).val();
		var area_id = $('#area_id_'+id_val).val();
		
		if(country_id == null)
		{
			country_id = '-1';
		}
				
		if(state_id == null)
		{
			state_id = '-1';
		}
		
		if(city_id == null)
		{
			state_id = '-1';
		}
		
		if(area_id == null)
		{
			area_id = '-1';
		}
		
		var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&action=getareaoption';
		$.ajax({
			type: "POST",
			url: "ajax/remote.php",
			data: dataString,
			cache: false,      
			success: function(result)
			{
				$("#area_id_"+id_val).html(result);
			}
		});
	}

	function addMoreRowCertificate(i_val)
	{
		
		var cert_cnt = parseInt($("#cert_cnt_"+i_val).val());
		
		cert_cnt = cert_cnt + 1;
		var new_row = '	<div id="row_cert_'+i_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
							'<input type="hidden" name="vc_cert_id_'+i_val+'[]" id="vc_cert_id_'+i_val+'_'+cert_cnt+'" value="0">'+
							'<input type="hidden" name="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" id="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" value="">'+
							'<div class="form-group small-title">';
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_type_id'))
//							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>'+
								'<div class="col-lg-5">'+
									'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control" >'+
										'<?php echo $obj->getCertficationTypeOption(''); ?>'+
									'</select>'+
								'</div>';
							<?php
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" value="">';
							<?php	
//							} ?>								
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_name'))
//							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Name</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+
								'</div>';
							<?php
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="">';
							<?php	
//							} ?>	
							
			new_row +=		'</div>'+	
							'<div class="form-group small-title">';
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_no'))
//							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Number</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+
								'</div>';
							<?php
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="">';
							<?php	
//							} ?>	
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_issued_by'))
//							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Issued By</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+
								'</div>';
							<?php
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="">';	
							<?php	
//							} ?>	
							
			new_row +=		'</div>'+	
							'<div class="form-group small-title">';
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_reg_date'))
//							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Issued Date</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+
								'</div>';
							<?php
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="">';	
							<?php	
//							} ?>	
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_validity_date'))
//							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Vaidity Date</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+
								'</div>';
							<?php
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="">';	
							<?php	
//							} ?>
							
			new_row +=		'</div>'+
							'<div class="form-group small-title">';
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_scan_file'))
//							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Scan Image</label>'+
								'<div class="col-lg-5">'+
									'<input type="file" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'_'+cert_cnt+'" class="form-control" >'+
								'</div>';
							<?php	
//							} ?>	
			new_row +=		'</div>'+
							'<div class="form-group">'+
								'<div class="col-lg-2">'+
									'<a href="javascript:void(0);" onclick="removeRowCertificate('+i_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+
								'</div>'+
							'</div>'+
						'</div>';
		
		$("#row_cert_"+i_val+"_first").after(new_row);
		$("#cert_cnt_"+i_val).val(cert_cnt);
		
		var cert_total_cnt = parseInt($("#cert_total_cnt_"+i_val).val());
		cert_total_cnt = cert_total_cnt + 1;
		$("#cert_total_cnt_"+i_val).val(cert_total_cnt);
		
		$('.clsdatepicker').datepicker();
		$('.clsdatepicker2').datepicker({endDate: new Date});
	}
	
	function removeRowCertificate(i_val,cert_cnt)
	{
		$("#row_cert_"+i_val+"_"+cert_cnt).remove();

		var cert_total_cnt = parseInt($("#cert_total_cnt_"+i_val).val());
		cert_total_cnt = cert_total_cnt + 1;
		$("#cert_total_cnt_"+i_val).val(cert_total_cnt);
		
	}
		
	function addMoreRowLocation()
	{
		
		var cat_cnt = parseInt($("#cat_cnt").val());
		cat_cnt = cat_cnt + 1;
		
		var i_val = cat_cnt;
		var cert_cnt = 0;
		var new_row = 	'<div id="row_loc_'+cat_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
							'<input type="hidden" name="cert_cnt_'+cat_cnt+'" id="cert_cnt_'+cat_cnt+'" value="'+cert_cnt+'">'+
							'<input type="hidden" name="cert_total_cnt_'+cat_cnt+'" id="cert_total_cnt_'+cat_cnt+'" value="1">'+
							'<input type="hidden" name="cert_loop_cnt[]" id="cert_loop_cnt_'+cat_cnt+'" value="'+cat_cnt+'">'+
							'<input type="hidden" name="hdnvloc_doc_file[]" id="hdnvloc_doc_file_'+cat_cnt+'" value="">'+
							'<input type="hidden" name="hdnvloc_menu_file[]" id="hdnvloc_menu_file_'+cat_cnt+'" value="">'+
							'<input type="hidden" name="vloc_id[]" id="vloc_id_'+cat_cnt+'" value="0">'+
							'<div class="form-group left-label">'+
								'<label class="col-lg-3 control-label"><strong>Location and Contact Details:</strong></label>'+
							'</div>'+
							'<div class="form-group">';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_parent_cat_id'))
							{ ?>
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_cat_id'))
//								{ ?>
//			new_row += 			'<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>'+
//								'<div class="col-lg-4">'+
//									'<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" class="form-control"  onchange="getMainCategoryOptionAddMoreCommon(\'vloc\','+cat_cnt+',\''+<?php echo $default_vloc_cat_id; ?>+'\');" required  >'+
//										'<?php echo $obj->getMainProfileOption($arr_vloc_parent_cat_id[0],'1','0',$default_vloc_parent_cat_id);?>'+
//									'</select>'+
//								'</div>'+
//								'<div class="col-lg-2"></div>'+
//								'<div class="col-lg-4">'+
//									'<select name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" class="form-control" required>'+
//										'<?php echo $obj->getMainCategoryOption($arr_vloc_parent_cat_id[0],'','1','0',$default_vloc_cat_id); ?>'+
//									'</select>'+
//								'</div>';				
								<?php
//								}
//								else
//								{ ?>
        
//								'<input type="hidden" name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" value="<?php echo $arr_vloc_cat_id[0];?>" >';				
								<?php	
//								} ?>
							<?php
							}
							else
                                                            
							{ ?>
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_cat_id'))
//								{ ?>
                        new_row += 			'<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" class="form-control">\n\
                                                                           <option value="">Select Category</option>'+
                                                                        
										'<?php echo $obj->getFavCategoryRamakant('45',$fav_cat);?>'+
									'</select>'+
								'</div>';
//			        
        
//			new_row +=			'<input type="text" name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" value="<?php echo $arr_vloc_parent_cat_id[0];?>" >';
//			new_row += 			'<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>'+
//								'<div class="col-lg-4">'+
//									'<select name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" class="form-control" >'+
//										'<?php echo $obj->getMainCategoryOption($arr_vloc_parent_cat_id[0],'','1','0',$default_vloc_cat_id); ?>'+
//									'</select>'+
//								'</div>';				
								<?php
//								}
//								else
//								{ ?>
//			new_row +=			'<input type="hidden" name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" value="<?php echo $arr_vloc_parent_cat_id[0];?>" >';
//			new_row +=			'<input type="hidden" name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" value="<?php echo $arr_vloc_cat_id[0];?>" >';
								<?php	
//								} ?>
							<?php	
							} ?>	
						
			
			new_row += 		'</div>'+
							'<div class="form-group" >';
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'country_id'))
//							{ ?>			
			new_row +=			'<label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="country_id[]" id="country_id_'+cat_cnt+'" onchange="getStateOptionAddMore('+cat_cnt+')" class="form-control" >'+
										'<?php echo $obj->getCountryOption(''); ?>'+
									'</select>'+
								'</div>';
							<?php	
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="country_id[]" id="country_id_'+cat_cnt+'" value="" >';					
							<?php
//							} ?>			
					
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'state_id'))
//							{ ?>			
			new_row +=			'<label class="col-lg-2 control-label">State<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="state_id[]" id="state_id_'+cat_cnt+'" onchange="getCityOptionAddMore('+cat_cnt+')" class="form-control" s>'+
										'<?php echo $obj->getStateOption('',''); ?>'+
									'</select>'+
								'</div>';
							<?php	
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="state_id[]" id="state_id_'+cat_cnt+'" value="" >';					
							<?php
//							} ?>				
							
			new_row +=		'</div>'+
							'<div class="form-group">';
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'city_id'))
//							{ ?>			
			new_row +=			'<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="city_id[]" id="city_id_'+cat_cnt+'" onchange="getAreaOptionAddMore('+cat_cnt+')" class="form-control" >'+
										'<?php echo $obj->getCityOption('','',''); ?>'+
									'</select>'+
								'</div>';
							<?php	
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="city_id[]" id="city_id_'+cat_cnt+'" value="" >';					
							<?php
//							} ?>
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'area_id'))
//							{ ?>				
			new_row +=			'<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="area_id[]" id="area_id_'+cat_cnt+'" class="form-control" >'+
										'<?php echo $obj->getAreaOption('','','',''); ?>'+
									'</select>'+
								'</div>';
							<?php	
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="area_id[]" id="area_id_'+cat_cnt+'" value="" >';					
							<?php
//							} ?>
							
			new_row +=		'</div>'+
							'<div class="form-group">';
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_person_title'))
//							{ ?>				
			new_row +=			'<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="contact_person_title[]" id="contact_person_title_'+cat_cnt+'" class="form-control" >'+
										'<?php echo $obj->getPersonTitleOption('');?>'+
									'</select>'+
								'</div>';
							<?php	
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="contact_person_title[]" id="contact_person_title_'+cat_cnt+'" value="" >';					
							<?php
//							} ?>	
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_person'))
//							{ ?>	
			new_row +=			'<label class="col-lg-2 control-label">Contact Person Name<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_person[]" id="contact_person_'+cat_cnt+'" value="" placeholder="Contact Person" class="form-control" >'+
								'</div>';
							<?php	
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="contact_person[]" id="contact_person_'+cat_cnt+'" value="" >';					
							<?php
//							} ?>		
								
			new_row +=		'</div>'+
							'<div class="form-group">';
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_email'))
//							{ ?>	
			new_row +=			'<label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_email[]" id="contact_email_'+cat_cnt+'" value="" placeholder="Contact Email" class="form-control" >'+
								'</div>';
							<?php	
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="contact_email[]" id="contact_email_'+cat_cnt+'" value="" >';					
							<?php
//							} ?>			
								
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_number'))
//							{ ?>		
			new_row +=			'<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_number[]" id="contact_number_'+cat_cnt+'" value="" placeholder="Contact Number" class="form-control" >'+
								'</div>';
							<?php	
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="contact_number[]" id="contact_number_'+cat_cnt+'" value="" >';					
							<?php
//							} ?>				
								
			new_row +=		'</div>'+
							'<div class="form-group">';
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_designation'))
//							{ ?>
			new_row +=			'<label class="col-lg-2 control-label">Contact Designation</label>'+	
                                                                           
								'<div class="col-lg-4">'+
									'<select name="contact_designation[]" id="contact_designation_'+cat_cnt+'" class="form-control">\n\
                                                                                                                        <option value="">Select Designation</option>'+
										'<?php echo $obj->getFavCategoryRamakant('44',$fav_cat);?>'+
									'</select>'+
								'</div>';
							<?php	
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="contact_designation[]" id="contact_designation_'+cat_cnt+'" value="" >';					
							<?php
//							} ?>					
								
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_remark'))
//							{ ?>	
			new_row +=			'<label class="col-lg-2 control-label">Remark</label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_remark[]" id="contact_remark_'+cat_cnt+'" value="" placeholder="Remark" class="form-control">'+
								'</div>';
							<?php	
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="contact_remark[]" id="contact_remark_'+cat_cnt+'" value="" >';					
							<?php
//							} ?>
								
			new_row +=		'</div>'+
							'<div class="form-group">';
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_speciality_offered'))
//							{ ?>
			new_row +=			'<label class="col-lg-2 control-label">Speciality Offered</label>'+
								'<div class="col-lg-10">'+
									'<select name="vloc_speciality_offered_'+cat_cnt+'[]" id="vloc_speciality_offered_'+cat_cnt+'" multiple="multiple" class="form-control vloc_speciality_offered" >'+
										'<?php echo $obj->getVendorSpecialityOfferedOption(array(''),'1','1'); ?>'+
									'</select>'+
								'</div>';
							<?php	
//							}
//							else
//							{ ?>
//			new_row +=			'<input type="hidden" name="vloc_speciality_offered_'+cat_cnt+'[]" id="vloc_speciality_offered_'+cat_cnt+'" value="" >';					
							<?php
//							} ?>
							
			new_row +=		'</div>'+	
							'<div class="form-group">';
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_menu_file'))
//							{ ?>
			new_row +=			'<label class="col-lg-2 control-label">Menu Image/Pdf</label>'+
								'<div class="col-lg-4">'+
									'<input type="file" name="vloc_menu_file[]" id="vloc_menu_file_'+cat_cnt+'" class="form-control">'+
								'</div>';
							<?php
//							} ?>	
							
							<?php
//							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_doc_file'))
//							{ ?>	
			new_row +=			'<label class="col-lg-2 control-label">Vendor Estt Pdf</label>'+
								'<div class="col-lg-4">'+
									'<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_'+cat_cnt+'" class="form-control">'+
								'</div>';
							<?php
//							} ?>	
							
			new_row +=		'</div>'+
							
							'<div class="form-group left-label">'+
								'<label class="col-lg-6 control-label"><strong>Licences, Registration, Certification & Memberships:</strong></label>'+
							'</div>'+
							'<div id="row_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
								'<input type="hidden" name="vc_cert_id_'+i_val+'[]" id="vc_cert_id_'+i_val+'_'+cert_cnt+'" value="0">'+
								'<input type="hidden" name="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" id="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" value="">'+
								'<div class="form-group small-title">';
									
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_type_id'))
//								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>'+
									'<div class="col-lg-5">'+
										'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control" >'+
											'<?php echo $obj->getCertficationTypeOption(''); ?>'+
										'</select>'+
									'</div>';
								<?php
//								}
//								else
//								{ ?>
//				new_row +=			'<input type="hidden" name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" value="">';
								<?php	
//								} ?>								
								
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_name'))
//								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Name</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+
									'</div>';
								<?php
//								}
//								else
//								{ ?>
//				new_row +=			'<input type="hidden" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="">';
								<?php	
//								} ?>	
				
				new_row +=		'</div>'+	
								'<div class="form-group small-title">';
								
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_no'))
//								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Number</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+
									'</div>';
								<?php
//								}
//								else
//								{ ?>
//				new_row +=			'<input type="hidden" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="">';
								<?php	
//								} ?>	
								
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_issued_by'))
//								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Issued By</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+
									'</div>';
								<?php
//								}
//								else
//								{ ?>
//				new_row +=			'<input type="hidden" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="">';	
								<?php	
//								} ?>
								
				new_row +=		'</div>'+	
								'<div class="form-group small-title">';
								
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_reg_date'))
//								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Issued Date</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+
									'</div>';
								<?php
//								}
//								else
//								{ ?>
//				new_row +=			'<input type="hidden" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="">';	
								<?php	
//								} ?>				
									
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_validity_date'))
//								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Vaidity Date</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+
									'</div>';
								<?php
//								}
//								else
//								{ ?>
//				new_row +=			'<input type="hidden" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="">';	
								<?php	
//								} ?>
								
				new_row +=		'</div>'+
								'<div class="form-group small-title">';
								
								<?php
//								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_scan_file'))
//								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Scan Image</label>'+
									'<div class="col-lg-5">'+
										'<input type="file" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'_'+cert_cnt+'" class="form-control" >'+
									'</div>';
								<?php	
//								} ?>
								
				new_row +=		'</div>'+
								'<div class="form-group">'+
									'<div class="col-lg-2">'+
										'<a href="javascript:void(0);" onclick="addMoreRowCertificate('+i_val+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div class="form-group">'+
								'<div class="col-lg-2">'+
									'<a href="javascript:void(0);" onclick="removeRowLocation('+cat_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+
								'</div>'+
							'</div>'+
						'</div>';	
		
		$("#row_loc_first").after(new_row);
		$("#cat_cnt").val(cat_cnt);
		
		var cat_total_cnt = parseInt($("#cat_total_cnt").val());
		cat_total_cnt = cat_total_cnt + 1;
		$("#cat_total_cnt").val(cat_total_cnt);
		
		$('.vloc_speciality_offered').tokenize2();
		$('.clsdatepicker').datepicker();
		$('.clsdatepicker2').datepicker({endDate: new Date});
	}

	function removeRowLocation(idval)
	{
		$("#row_loc_"+idval).remove();

		var cat_total_cnt = parseInt($("#cat_total_cnt").val());
		cat_total_cnt = cat_total_cnt - 1;
		$("#cat_total_cnt").val(cat_total_cnt);
		
	}
</script>
</body>
</html>