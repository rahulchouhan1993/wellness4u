<?php

include_once('../../classes/config.php');

include_once('../../classes/admin.php');

$obj = new Admin();

if(!$obj->isAdminLoggedIn())

{

	exit(0);

}

$admin_id = $_SESSION['admin_id'];

$add_action_id = '44';



if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))

{

	$tdata = array();

	$response = array('msg'=>'Sorry you dont have access.','status'=>0);

	$tdata[] = $response;

	echo json_encode($tdata);

	exit(0);

}



$error = false;

$err_msg = '';

$obj->debuglog('[ADD_VENDOR] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>, FILES:<pre>'.print_r($_FILES,true).'</pre>');



if(isset($_POST['btnSubmit']))

{

	// echo "<pre>";

	// print_r($_POST);

	// die('--ss');

	$vendor_parent_cat_id = strip_tags(trim($_POST['vendor_parent_cat_id']));

	$vendor_cat_id = strip_tags(trim($_POST['vendor_cat_id']));

	$vendor_name = strip_tags(trim($_POST['vendor_name']));

	$vendor_username = strip_tags(trim($_POST['vendor_username']));

	$vendor_password = strip_tags(trim($_POST['vendor_password']));

        

        $vendor_email = strip_tags(trim($_POST['vendor_email']));

        $vendor_mobile = strip_tags(trim($_POST['vendor_mobile']));

		$food_products_offered=implode(',', $_POST['food_products_offered']); // add by ample 07-09-20

        if($vendor_email == '')

        {

                $error = true;

                $err_msg = 'Please enter email';



                $tdata = array();

                $response = array('msg'=>$err_msg,'status'=>0);

                $tdata[] = $response;

                echo json_encode($tdata);

                exit(0);

        }

        elseif(filter_var($vendor_email, FILTER_VALIDATE_EMAIL) === false)

        {

                $error = true;

                $err_msg = 'Please enter valid email';



                $tdata = array();

                $response = array('msg'=>$err_msg,'status'=>0);

                $tdata[] = $response;

                echo json_encode($tdata);

                exit(0);

        }

        elseif($obj->chkVendorEmailExists($vendor_email))

        {

                $error = true;

                $err_msg = 'Vendor email already exists';



                $tdata = array();

                $response = array('msg'=>$err_msg,'status'=>0);

                $tdata[] = $response;

                echo json_encode($tdata);

                exit(0);

        }

       

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
			//update by ample 18-09-20
			array_push($arr_city_id,$obj->getCityIdbyName($val));

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

	

	

	if($vendor_name == '')

	{

		$error = true;

		$err_msg = 'Please enter company name';

	

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

	elseif($obj->chkVendorNameExists($vendor_name))

	{

		$error = true;

		$err_msg = 'Company name already exists';

	

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

	

	if($vendor_username == '')

	{

		$error = true;

		$err_msg = 'Please enter vendor username';

	

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

	elseif($obj->chkVendorUsernameExists($vendor_username))

	{

		$error = true;

		$err_msg = 'Vendor username already exists';

	

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

	

	for($i=0,$j=1;$i<count($arr_vloc_parent_cat_id);$i++,$j++)

	{

		if($arr_vloc_parent_cat_id[$i] == '')

		{

			$error = true;

			$err_msg = 'Please select main profile for location row: '.$j;

		

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		

		if($arr_vloc_cat_id[$i] == '')

		{

			$error = true;

			$err_msg = 'Please select category for location row: '.$j;

		

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		

		if($arr_country_id[$i] == '')

		{

			$error = true;

			$err_msg = 'Please select country for location row: '.$j;

		

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		

		if($arr_state_id[$i] == '')

		{

			$error = true;

			$err_msg = 'Please select state for location row: '.$j;

		

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		

		if($arr_city_id[$i] == '')

		{

			$error = true;

			$err_msg = 'Please select city for location row: '.$j;

		

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		

		if($arr_area_id[$i] == '')

		{

			$error = true;

			$err_msg = 'Please select area for location row: '.$j;

		

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		

		if($arr_contact_person_title[$i] == '')

		{

			$error = true;

			$err_msg = 'Please select gender for location row: '.$j;

		

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		

		if($arr_contact_person[$i] == '')

		{

			$error = true;

			$err_msg = 'Please select contact person for location row: '.$j;

		

			$tdata = array();

			$response = array('msg'=>$err_msg,'status'=>0);

			$tdata[] = $response;

			echo json_encode($tdata);

			exit(0);

		}

		

		if($i == 0)

		{

			if($arr_contact_email[$i] == '')

			{

				$error = true;

				$err_msg = 'Please enter email for location row: '.$j;

			

				$tdata = array();

				$response = array('msg'=>$err_msg,'status'=>0);

				$tdata[] = $response;

				echo json_encode($tdata);

				exit(0);

			}

			elseif(filter_var($arr_contact_email[$i], FILTER_VALIDATE_EMAIL) === false)

			{

				$error = true;

				$err_msg = 'Please enter valid email for location row: '.$j;

				

				$tdata = array();

				$response = array('msg'=>$err_msg,'status'=>0);

				$tdata[] = $response;

				echo json_encode($tdata);

				exit(0);

			}

//			elseif($obj->chkVendorEmailExists($arr_contact_email[$i]))

//			{

//				$error = true;

//				$err_msg = 'Vendor email already exists';

//			

//				$tdata = array();

//				$response = array('msg'=>$err_msg,'status'=>0);

//				$tdata[] = $response;

//				echo json_encode($tdata);

//				exit(0);

//			}



			if($arr_contact_number[$i] == '')

			{

				$error = true;

				$err_msg = 'Please enter contact number for location row: '.$j;

			

				$tdata = array();

				$response = array('msg'=>$err_msg,'status'=>0);

				$tdata[] = $response;

				echo json_encode($tdata);

				exit(0);

			}	

		}

		

		for($k=0,$l=1;$k<count($arr_vc_cert_type_id[$i]);$k++,$l++)

		{

			if($arr_vc_cert_type_id[$i][$k] == '')

			{

				$error = true;

				$err_msg = 'Please select type for location row: '.$j.' , certificate row: '.$l;

			

				$tdata = array();

				$response = array('msg'=>$err_msg,'status'=>0);

				$tdata[] = $response;

				echo json_encode($tdata);

				exit(0);

			}

			

			if($arr_vc_cert_reg_date[$i][$k] != '' && $arr_vc_cert_validity_date[$i][$k] != '')

			{

				if(strtotime($arr_vc_cert_reg_date[$i][$k]) > strtotime($arr_vc_cert_validity_date[$i][$k]))

				{

					$error = true;

					$err_msg = 'Issued date must be lesser than validity date for location row: '.$j.' , certificate row: '.$l;

				

					$tdata = array();

					$response = array('msg'=>$err_msg,'status'=>0);

					$tdata[] = $response;

					echo json_encode($tdata);

					exit(0);

				}

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

		$tdata['admin_id'] = $admin_id;

                $tdata['add_type'] ='Admin';

		$tdata['vendor_parent_cat_id'] = $vendor_parent_cat_id;

		$tdata['vendor_cat_id'] = $vendor_cat_id;

		$tdata['vendor_name'] = $vendor_name;

		$tdata['vendor_username'] = $vendor_username;

                $tdata['vendor_email'] = $vendor_email;

                $tdata['vendor_mobile'] = $vendor_mobile;

                $tdata['food_products_offered'] = $food_products_offered; // update by ample 07-09-20

		$tdata['vendor_password'] = $vendor_password;

		//$tdata['vendor_email'] = $arr_contact_email[0];

		$tdata['vendor_status'] = '1';

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

		

               // echo '<pre>';

               // print_r($tdata);

               // echo '</pre>';

               // die('-ssadd');

                $vendor_id = $obj->addVendor($tdata);

		if($vendor_id > 0)

		{

                        $vendor_unique_id = $obj->genrateProUserUniqueId($vendor_id);

                        $obj->updatevendoruniqueid($vendor_unique_id,$vendor_id);

			$msg = 'Record Added Successfully!';

			$ref_url = "manage_vendors.php?msg=".urlencode($msg);

						

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