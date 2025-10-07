<?php
require_once('admin/config/class.mysql.php');
require_once('admin/classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();


$view_action_id = '160';
$add_action_id = '158';

//if(!$obj->isAdminLoggedIn())
//{
//	header("Location: index.php?mode=login");
//	exit(0);
//}

//if(!$obj->chkValidActionPermission($admin_id,$view_action_id))
//{	
//	header("Location: index.php?mode=invalid");
//	exit(0);
//}

if(isset($_POST['btnSubmit']))
{
    
    $error = false;
	$va_id = strip_tags(trim($_POST['va_id']));
	
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

    
	$vendor_parent_cat_id = strip_tags(trim($_POST['vendor_parent_cat_id']));
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

//	
	if(!$error)
	{
		$picture_size_limit = 5120;
		$error = false;
		$err_msg = '';

		// Define a destination
		$targetFolder = SITE_PATH . '/uploads'; // Relative to the root
                //$targetFolder = 'http://localhost/wellnessway4you/'. '/uploads'; // Relative to the root

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
                  //$targetFolder = 'http://localhost/wellnessway4you/'. '/uploads'; // Relative to the root
                
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
                
		$tdata['va_id'] = $va_id;
		$tdata['admin_id'] = 0;
		$tdata['vendor_parent_cat_id'] = $vendor_parent_cat_id;
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
            $ref_url = SITE_URL."/message.php?msg=12";  //id=5 is old message id

			// $ref_url = SITE_URL."/messages.php?id=5"; 
                        //$ref_url = "http://localhost/wellnessway4you/messages.php?id=5";
//			header('Location: register.php');	
//                        exit(0);
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

else 
{
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

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Tastes Of States" />
<meta name="keywords" content="Tastes Of States" />
<meta name="title" content="wellness" />
<title>Tastes Of States</title>

<!--<link rel="icon" href="http://localhost/testesofstates/images/icon.png">-->
<!-- google font -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> 
<!-- google font -->
<link rel="stylesheet" href="wa/css/bootstrap.min.css">
<link rel="stylesheet" href="css/csswell/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="wa/css/animated.css" media="all">
<link rel="stylesheet" href="wa/css/slick.css" media="all">
<link rel="stylesheet" href="wa/css/jquery-ui.css" media="all">
<link rel="stylesheet" href="wa/css/style.css?v=1508748975">
<link rel="stylesheet" href="wa/css/responsive.css">
<link rel="stylesheet" href="wa/css/tokenize2.css" />
</head>
<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<header style="border-bottom: white;">

 

    <div class="container">

    

    <div class="row" style="margin-bottom:25px;">	

    <!-- logo -->

<div class="col-md-2" style="height:100px;">

    

    <a class="navbar-brand" href="http://localhost/wellnessway4you"><img src="uploads/cwri_logo.png" width="100px" height="100px" border="0" /></a>

    </div>

   <div class="col-md-8">

                            
     </div>

</div>

</div>

      <!-- Static navbar -->

 <div class="container">

      <nav class="navbar navbar-default">

       

          <div class="navbar-header">



                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">



                        <span class="sr-only">Toggle navigation</span>



                        <span class="icon-bar"></span>



                        <span class="icon-bar"></span>



                        <span class="icon-bar"></span>



                    </button>

                    



                </div>

          <div id="navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-left">



                         


                                                        <li>



                                                            <a href="pages.php?id=164">My Dashboard</a>



                                                        


                                                        </li>



                                                    


                                                        <li>



                                                            <a href="pages.php?id=166">View Rewards</a>



                                                        


                                                        </li>



                                                    


                                                        <li>



                                                            <a href="caravan.php">Care Partners</a>



                                                        


                                                        </li>



                                                    


                                                        <li>



                                                            <a href="pages.php?id=59">Advisers Hub</a>



                                                        


                                                        </li>



                                                    


                                                


                                                    


                                                        <li><a href="login.php">Login&nbsp;&nbsp;&nbsp;&nbsp;</a></li>



                                                    


                    </ul>

            

          </div><!--/.nav-collapse -->

            </nav>

       

 </div><!--/.container-fluid -->

    

    <!-- Tips bar  -->






</header>
<!--side navigation start-->
<div id="hoeapp-wrapper" class="hoe-hide-lpanel" hoe-device-type="desktop">
	
	<div id="hoeapp-container" hoe-color-type="lpanel-bg7" hoe-lpanel-effect="shrink">
		<aside id="hoe-left-panel" hoe-position-type="absolute">
			
		</aside>
		<!--aside left menu end-->
		<!--start main content-->
		<section id="main-content">
			<div class="space-30"></div><div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="panel">
				<div class="panel-body">
					<div class="row mail-header">
						<div class="col-md-6">
							<h3>Business Associate Registration </h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="register" name="register" enctype="multipart/form-data" method="post"> 
							
						<input type="hidden" name="va_id" id="va_id" value="1">
						<input type="hidden" name="cat_cnt" id="cat_cnt" value="0">
						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="1">
						
						<div class="form-group">
													<input type="hidden" name="vendor_parent_cat_id" id="vendor_parent_cat_id" value="11">	
							<label class="col-lg-2 control-label">Category<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="vendor_cat_id" id="vendor_cat_id" class="form-control" required22>
									<option value="" >Select Category</option><option value="9" >Chefs</option><option value="13" >Home Cooks</option><option value="24" >Hotels & Restaurants</option><option value="159" >Not in List</option>								</select>
							</div>
														
							
						</div>
						
												<div class="form-group"><label class="col-lg-2 control-label">Company Name<span style="color:red">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="vendor_name" id="vendor_name" value="" placeholder="Company Name" class="form-control" required22>
							</div>
						</div>
												
						
						<div class="form-group">
							
							<label class="col-lg-2 control-label">Username<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="vendor_username" id="vendor_username" value="" placeholder="Vendor Username" class="form-control" required22>
							</div>
												
							
							<label class="col-lg-2 control-label">Password<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="password" name="vendor_password" id="vendor_password" value="" placeholder="Vendor Password" class="form-control" required22>
							</div>
							
						</div>
						
											<div id="row_loc_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
							<input type="hidden" name="cert_cnt_0" id="cert_cnt_0" value="0">
							<input type="hidden" name="cert_total_cnt_0" id="cert_total_cnt_0" value="1">
							<input type="hidden" name="cert_loop_cnt[]" id="cert_loop_cnt_0" value="0">
							<input type="hidden" name="hdnvloc_doc_file[]" id="hdnvloc_doc_file_0" value="">
							<input type="hidden" name="hdnvloc_menu_file[]" id="hdnvloc_menu_file_0" value="">
							<input type="hidden" name="vloc_id[]" id="vloc_id_0" value="0">
							<div class="form-group left-label">
								<label class="col-lg-3 control-label"><strong>Location and Contact Details:</strong></label>
							</div>
							<div class="form-group">
							 
								<input type="hidden" name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_0" value="2" >	
								<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="vloc_cat_id[]" id="vloc_cat_id_0" class="form-control" required22>
										<option value="" >Select Category</option><option value="31" >Branch Restaurant</option><option value="5" >Centralised Kitchen</option><option value="4" >Cloud Kitchen</option><option value="79" >Head Office</option><option value="30" >Main Restaurant</option>									</select>
								</div>
															</div>
							<div class="form-group" >	
									
								<label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="country_id[]" id="country_id_0" onchange="getStateOptionAddMore(0)" class="form-control" required22>
										<option value="" >Select Country</option><option value="11" >Afganistan</option><option value="12" >Albania</option><option value="13" >Algeria</option><option value="14" >American Samoa</option><option value="15" >Andorra</option><option value="16" >Angola</option><option value="17" >Anguilla</option><option value="18" >Antigua and Barbuda</option><option value="19" >Argentina</option><option value="20" >Armenia</option><option value="5" >Australia</option><option value="21" >Austria</option><option value="22" >Azerbaijan</option><option value="23" >Bahamas</option><option value="24" >Bahrain</option><option value="25" >Bangladesh</option><option value="26" >Barbados</option><option value="27" >Belarus</option><option value="28" >Belgium</option><option value="29" >Belize</option><option value="30" >Benin</option><option value="31" >Bermuda</option><option value="32" >Bhutan</option><option value="33" >Bolivia</option><option value="34" >Bosnia and Herzegovina</option><option value="35" >Botswana</option><option value="36" >Brazil</option><option value="37" >British Virgin Islands</option><option value="38" >Brunei</option><option value="40" >Bulgaria</option><option value="41" >Burkina Faso</option><option value="42" >Burundi</option><option value="43" >Cambodia</option><option value="44" >Cameroon</option><option value="6" >Canada</option><option value="45" >Canary Islands</option><option value="46" >Cape Verde</option><option value="47" >Cayman Islands</option><option value="48" >Central African Republic</option><option value="49" >Chad</option><option value="50" >Chile</option><option value="51" >China</option><option value="52" >Colombia</option><option value="53" >Comoros</option><option value="54" >Congo</option><option value="55" >Cook Islands</option><option value="56" >Costa Rica</option><option value="57" >Cote Dlvoire</option><option value="58" >Croatia</option><option value="59" >Cuba</option><option value="60" >Cyprus</option><option value="61" >Czech Republic</option><option value="62" >Denmark</option><option value="63" >Dominica</option><option value="64" >Dominican Republic</option><option value="66" >East Timor</option><option value="67" >Ecuador</option><option value="68" >Egypt</option><option value="69" >El Salvador</option><option value="70" >Equatorial Guinea</option><option value="71" >Eritrea</option><option value="72" >Estonia</option><option value="73" >Ethiopia</option><option value="75" >Falkland Islands ( Islas Malvinas )</option><option value="74" >Faroe Islands</option><option value="76" >Fiji</option><option value="77" >Finland</option><option value="78" >France</option><option value="79" >French Guiana</option><option value="80" >French Polynesia</option><option value="81" >Gambia</option><option value="82" >Georgia</option><option value="83" >Germany</option><option value="84" >Ghana</option><option value="85" >Gibraltar</option><option value="86" >Greece</option><option value="87" >Greenland</option><option value="88" >Grenada</option><option value="89" >Guadeloupe</option><option value="90" >Guam</option><option value="91" >Guatemala</option><option value="92" >Guinea</option><option value="93" >Guinea - Bissau</option><option value="94" >Guyana</option><option value="95" >Haiti</option><option value="96" >Holland</option><option value="97" >Honduras</option><option value="98" >Hong Kong</option><option value="99" >Hungary</option><option value="100" >Iceland</option><option value="1" >India</option><option value="101" >Indonesia</option><option value="102" >Iran</option><option value="103" >Iraq</option><option value="104" >Ireland</option><option value="105" >Isle of Man</option><option value="106" >Israel</option><option value="107" >Italy</option><option value="108" >Jamaica</option><option value="109" >Japan</option><option value="110" >Jordan</option><option value="111" >Kazakhstan</option><option value="112" >Kenya</option><option value="113" >Kiribati</option><option value="114" >Kuwait</option><option value="115" >Kyrgyzstan</option><option value="116" >Laos</option><option value="117" >Latvia</option><option value="118" >Lebanon</option><option value="119" >Lesotho</option><option value="120" >Liberia</option><option value="121" >Libya</option><option value="122" >Liechtenstein</option><option value="123" >Lithuania</option><option value="124" >Luxembourg</option><option value="125" >Macao</option><option value="126" >Macedonia</option><option value="127" >Madagascar</option><option value="128" >Malawi</option><option value="129" >Malaysia</option><option value="130" >Maldives</option><option value="136" >Maldova</option><option value="131" >Mali</option><option value="132" >Malta</option><option value="133" >Martinique</option><option value="134" >Mauritius</option><option value="135" >Mexico</option><option value="137" >Monaco</option><option value="138" >Mongolia</option><option value="139" >Montenegro</option><option value="140" >Montserrat</option><option value="141" >Morocco</option><option value="142" >Mozambique</option><option value="143" >Myanmar</option><option value="144" >Namibia</option><option value="145" >Nepal</option><option value="146" >Netherlands</option><option value="147" >Netherlands Antilles</option><option value="148" >New Caledonia</option><option value="149" >New Zealand</option><option value="150" >Nicaragua</option><option value="151" >Niger</option><option value="152" >Nigeria</option><option value="153" >North Korea</option><option value="154" >Norway</option><option value="155" >Oman</option><option value="219" >Others</option><option value="7" >Pakistan</option><option value="156" >Panama</option><option value="157" >Papua New Guinea</option><option value="158" >Paraguay</option><option value="159" >Peru</option><option value="160" >Philippines</option><option value="161" >Poland</option><option value="162" >Portugal</option><option value="163" >Puerto Rico</option><option value="164" >Qatar</option><option value="165" >Reunion</option><option value="166" >Romania</option><option value="167" >Russia</option><option value="168" >Rwanda</option><option value="169" >Saint Kitts and Nevis</option><option value="170" >Saint Lucia</option><option value="172" >Saint Marino</option><option value="173" >Saint Tome and Principe</option><option value="171" >Saint Vincent and the Grenadines</option><option value="174" >Saudi Arabia</option><option value="175" >Senegal</option><option value="177" >Serbia</option><option value="176" >Seychelles</option><option value="178" >Sierra Leone</option><option value="179" >Singapore</option><option value="180" >Slovakia</option><option value="181" >Slovenia</option><option value="182" >Solomon Islands</option><option value="183" >Somalia</option><option value="184" >South Africa</option><option value="185" >South Korea</option><option value="186" >Spain</option><option value="187" >Sri Lanka</option><option value="188" >Sudan</option><option value="189" >Suriname</option><option value="190" >Swaziland</option><option value="191" >Sweden</option><option value="192" >Switzerland</option><option value="193" >Syrian Arab Republic</option><option value="194" >Tahiti</option><option value="195" >Taiwan</option><option value="196" >Tajikistan</option><option value="197" >Tanzania</option><option value="198" >Thailand</option><option value="199" >Togo</option><option value="200" >Trinidad and Tobago</option><option value="201" >Tunisia</option><option value="202" >Turkey</option><option value="203" >Turkmenistan</option><option value="204" >Turks and Caicos Islands</option><option value="205" >Uganda</option><option value="206" >Ukraine</option><option value="8" >United Arab Emirates</option><option value="9" >United Kingdom</option><option value="10" >United States</option><option value="207" >United States Virgin Islands</option><option value="208" >Uruguay</option><option value="209" >Uzbekistan</option><option value="210" >Vanuatu</option><option value="211" >Vatican City State</option><option value="212" >Venezuela</option><option value="213" >Vietnam</option><option value="214" >Wallis and Futuna</option><option value="215" >Yemen</option><option value="217" >Zambia</option><option value="218" >Zimbabwe</option>									</select>
								</div>
										
								<label class="col-lg-2 control-label">State<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="state_id[]" id="state_id_0" onchange="getCityOptionAddMore(0)" class="form-control" required22>
										<option value="" >Select State</option>									</select>
								</div>
								
							</div>
							<div class="form-group">	
										
								<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="city_id[]" id="city_id_0" onchange="getAreaOptionAddMore(0)" class="form-control" required22>
										<option value="" >Select City</option>									</select>
								</div>
											
								<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="area_id[]" id="area_id_0" class="form-control" required22>
										<option value="" >Select Area</option>									</select>
								</div>
								
							</div>
							<div class="form-group">
															<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="contact_person_title[]" id="contact_person_title_0" class="form-control" required22>
										<option value="" >Select Gender</option><option value="Female" >Female</option><option value="Male" >Male</option>									</select>
								</div>
															<label class="col-lg-2 control-label">Contact Person Name<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<input type="text" name="contact_person[]" id="contact_person_0" value="" placeholder="Contact Person" class="form-control" required22>
								</div>
										
								
							</div>
							
							<div class="form-group">
															<label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<input type="text" name="contact_email[]" id="contact_email_0" value="" placeholder="Contact Email" class="form-control" required22>
								</div>
															<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<input type="text" name="contact_number[]" id="contact_number_0" value="" placeholder="Contact Number" class="form-control" required22>
								</div>
								
							</div>
						
							<div class="form-group">
															<label class="col-lg-2 control-label">Contact Designation</label>
								<div class="col-lg-4">
									<select name="contact_designation[]" id="contact_designation_0" class="form-control">
										<option value="" >Select Designation</option><option value="48" >Chef</option><option value="49" >Cook</option><option value="50" >Delivery Person</option><option value="28" >Director</option><option value="47" >Main Chef</option><option value="29" >Manager</option><option value="26" >Owner</option><option value="27" >Partner</option>									</select>
								</div>
							
								
								<label class="col-lg-2 control-label">Remark</label>
								<div class="col-lg-4">
									<input type="text" name="contact_remark[]" id="contact_remark_0" value="" placeholder="Remark" class="form-control">
								</div>
								
							</div>
							
							<div class="form-group">
								
								<label class="col-lg-2 control-label">Speciality Offered</label>
								<div class="col-lg-10">
									<select name="vloc_speciality_offered_0[]" id="vloc_speciality_offered_0" multiple="multiple" class="form-control vloc_speciality_offered" >
										<option value="" >Select Speciality</option><option value="586" >Aajker Bhajabhuji</option><option value="268" >Aam Jhor</option><option value="600" >Achari Jhinga</option><option value="732" >Adadiya Ladoo</option><option value="794" >Adadiya Pak</option><option value="297" >Adaraki Aloo Methi</option><option value="791" >Agharni Na Ladva</option><option value="387" >Agra Dalmooth</option><option value="24" >Ajwain (carram seed)</option><option value="612" >Ajwain Paratha</option><option value="39" >Akkha Masoor  dal</option><option value="571" >Aliv Ladu</option><option value="62" >Almonds</option><option value="552" >Aloo Raita</option><option value="593" >Aloo Tuk</option><option value="469" >Alu Chat Papdi</option><option value="350" >Alu Leaves</option><option value="375" >Alu Palak Sev</option><option value="482" >Aluvadi</option><option value="295" >Aluwadi</option><option value="480" >Amboli</option><option value="275" >Ambula</option><option value="380" >Amdavadi Mix</option><option value="551" >Amritsari chole</option><option value="700" >Anarsa</option><option value="687" >Angoor  Basundi</option><option value="862" >Appalu</option><option value="537" >Appe</option><option value="86" >Apple</option><option value="87" >Apricot</option><option value="597" >Arbi Tuk</option><option value="233" >Asafoetida (Hing)</option><option value="88" >Asparagus</option><option value="668" >Atta Ka Halwa</option><option value="89" >Aubergine/Purple Brinjal/Baigan</option><option value="357" >Aval</option><option value="90" >Avocado</option><option value="879" >Awadhi Cuisine</option><option value="82" >Baat Jo Seero</option><option value="762" >Babroo</option><option value="402" >Badam Kaju Poha</option><option value="405" >Badam Lachcha</option><option value="60" >Badane Kaayi</option><option value="742" >Bafla Bati</option><option value="283" >Baingan Bharta</option><option value="454" >bajra flour</option><option value="722" >Bakheer</option><option value="830" >Bal Mithai</option><option value="785" >Balushahi</option><option value="692" >Banana (plaintain) Flower</option><option value="91" >Banana/Kela</option><option value="846" >Basundi</option><option value="885" >Batata Chivda</option><option value="174" >Batatawada</option><option value="804" >Batisa Ladoo</option><option value="31" >Bay leaves</option><option value="883" >Beans</option><option value="847" >Bebinca</option><option value="92" >Beetroot</option><option value="118" >Bell pepper</option><option value="242" >Bellam Thalikalu</option><option value="259" >Besan</option><option value="764" >Besan  Ka Halwa</option><option value="626" >Besan ji Tikki</option><option value="715" >Besan ke Ladoo</option><option value="611" >Besan Paratha</option><option value="432" >Bhakarwadi</option><option value="728" >Bharlela Tameta</option><option value="59" >Bhatkali Chicken Biryani</option><option value="363" >Bhavnagari Gathiya</option><option value="595" >Bhea Chips</option><option value="737" >Bhee rolls</option><option value="609" >Bheja tawa</option><option value="508" >Bhopla Doddak</option><option value="484" >Bhoplyache Bharit</option><option value="483" >Bhoplyache Thalipeeth</option><option value="872" >Biryani</option><option value="319" >Biryani powder</option><option value="435" >Biscuit Bhakarwadi</option><option value="640" >Bisi-bela Rice</option><option value="147" >Black cardamom</option><option value="339" >Black eyed  peas</option><option value="23" >Black pepper ( kali mirchi)</option><option value="247" >Black salt</option><option value="266" >Boiled Rice</option><option value="577" >Bombay Duck</option><option value="797" >Bombay Halwa</option><option value="557" >Bombil Bhaji</option><option value="556" >Boneless Pomfret</option><option value="376" >Boondi / panipuri boondi</option><option value="735" >Bottle Guard (doodhi)</option><option value="636" >Bread Bonda</option><option value="352" >Brinjal</option><option value="93" >Broccoli</option><option value="234" >Broke Wheat Upma</option><option value="351" >Broken wheat</option><option value="853" >Brown Rosogulla</option><option value="525" >Bun Puri</option><option value="132" >Butter</option><option value="436" >Butter Bhakarwadi</option><option value="431" >Butter Masala Murukku</option><option value="430" >Butter Murukku</option><option value="359" >Butter Papdi</option><option value="141" >Buttermilk</option><option value="104" >Cabbage</option><option value="26" >Cardamom (elaichi)</option><option value="94" >Carrot</option><option value="128" >Cashew nuts</option><option value="73" >Chaap Chola</option><option value="633" >Chaap Lajawab</option><option value="829" >Chakhao Kheer</option><option value="425" >Chakli</option><option value="237" >Chalimidi</option><option value="412" >Chana Dal</option><option value="723" >Chana Dal Poori</option><option value="523" >Chana Poha</option><option value="419" >Chanajor</option><option value="43" >Channa Dal</option><option value="627" >Chavli</option><option value="562" >Chavli usal</option><option value="712" >Chawal Ki Kheer</option><option value="624" >Chawli</option><option value="36" >Chawli/Lobia</option><option value="131" >Cheese</option><option value="253" >Chenna</option><option value="252" >Chenna Malpua</option><option value="95" >Cherry</option><option value="660" >Chettinad Chicken Curry</option><option value="852" >Chhangban Leh kurtai</option><option value="825" >Chhena Poda</option><option value="334" >Chicken</option><option value="554" >Chicken Biryani</option><option value="578" >Chicken Dopyaza</option><option value="634" >Chicken Gulabo Tikka</option><option value="307" >Chicken Kolhapuri</option><option value="187" >Chicken Kundapuri</option><option value="622" >Chicken Leg Masala</option><option value="306" >Chicken Patiyala</option><option value="631" >Chicken Raja Rani</option><option value="310" >Chicken Rashida</option><option value="579" >Chicken sagwala</option><option value="517" >Chicken Sukha</option><option value="566" >Chicken Thali</option><option value="632" >Chicken Tikka Masala</option><option value="164" >Chicken/Egg/Meat powder</option><option value="188" >Chiken Malvani Tava Fry</option><option value="269" >Chilkha Roti</option><option value="160" >Chillies</option><option value="801" >Chips Farsan</option><option value="654" >Chmeen Pollichathu</option><option value="337" >Chora Ma Khariya</option><option value="819" >Chorafali</option><option value="812" >Churma</option><option value="29" >Cinnamon (dalchini)</option><option value="169" >Cloves</option><option value="155" >Coconut</option><option value="348" >coconut ada</option><option value="176" >Coconut Milk</option><option value="45" >Colacasia Leaves/Arbi patta</option><option value="14" >Coriander leaf/Dhaniya Patta</option><option value="21" >Coriander powder</option><option value="16" >Coriander seed (akkha dhaniya)</option><option value="256" >Corn flour</option><option value="736" >Crab</option><option value="543" >Crab  Masala and Rice</option><option value="421" >Crazy Nuts</option><option value="423" >Crispy Samosa</option><option value="156" >Cumin seeds</option><option value="226" >Curd</option><option value="46" >Curry  Leaves /Kadi Patta</option><option value="487" >Daanger</option><option value="273" >Dahi Ambula Khata</option><option value="532" >Dakshin Idli</option><option value="287" >Dal Bati</option><option value="288" >Dal Bati Churma</option><option value="505" >Dal Bukhara</option><option value="285" >Dal dhokli</option><option value="745" >Dal Ka Paratha</option><option value="744" >Dal Ka Seera</option><option value="721" >Dal Kachori</option><option value="515" >Dal Kolhapuri</option><option value="594" >Dal Pakwan</option><option value="272" >Dal Peethi</option><option value="497" >Dalicha Pithla</option><option value="488" >Dalimbyachi usal</option><option value="697" >Dashmi roti</option><option value="98" >Date/Kajur</option><option value="80" >Degh waara chanwaran ain Bhee patata</option><option value="83" >Dhaas meyah</option><option value="66" >Dharan Ji Kadhi</option><option value="696" >Dhodkyacha bhaat</option><option value="264" >Dhuska</option><option value="407" >Diet Chakli</option><option value="406" >Diet Chiwda</option><option value="410" >Diet Kothimir Chiwda</option><option value="408" >Diet Masala Murukku</option><option value="409" >Diet Methi Murukku</option><option value="47" >Dill /Savaa Patta</option><option value="775" >Dink Ladoo</option><option value="755" >Dodol</option><option value="199" >Doi Potol</option><option value="544" >Dried Prawns Chutney</option><option value="326" >Drumstick</option><option value="48" >Drumstick Leaves*/Sohjna</option><option value="241" >Dry Coconut</option><option value="777" >Dry Fruit Kachori</option><option value="403" >Dry Fruit Mumbai Mix</option><option value="355" >Dry Fruits</option><option value="238" >Dry ginger powder</option><option value="109" >Dry mango</option><option value="232" >Dry red chillies</option><option value="401" >Dryfruit Kachori</option><option value="716" >Dum Aloo</option><option value="314" >Dum ki Chaap</option><option value="154" >Eggs</option><option value="731" >Fafda Chutney</option><option value="444" >Farali chiwda</option><option value="451" >farali misal</option><option value="168" >Farali Missal</option><option value="293" >Farali patis</option><option value="817" >Farsi Puri</option><option value="171" >Fennel (saunf)</option><option value="49" >Fenugreek  (Methi)</option><option value="243" >Fenugreek seeds</option><option value="99" >Fig</option><option value="772" >Fish</option><option value="330" >Fish Biryani</option><option value="623" >Fish Koliwada</option><option value="183" >Fish masala powder</option><option value="657" >Fish Molee</option><option value="567" >Fish Thali</option><option value="602" >Fish Tikka Tandoori</option><option value="191" >Fish/Prawns Koliwada</option><option value="190" >Fish/Prawns/crab Malvani tava fry</option><option value="143" >Flavoured dahi</option><option value="142" >Flavoured milk</option><option value="585" >Fowl Cutlet</option><option value="145" >Fresh cream</option><option value="218" >Fresh Jalapeno</option><option value="466" >Fryms</option><option value="818" >Fulvadi</option><option value="757" >Gajak</option><option value="599" >Galouti Kebab</option><option value="175" >Garam Masala</option><option value="9" >Garlic</option><option value="373" >Garlic  Sev</option><option value="437" >Garlic Bhakarawadi</option><option value="389" >Garlic Mix</option><option value="212" >Garlic Powder</option><option value="84" >Gathri  pickle</option><option value="739" >Gatte ki sabzi</option><option value="510" >Gavthi Chicken Fry</option><option value="610" >Gawthi Chicken</option><option value="499" >Ghaavne</option><option value="498" >Ghadichi poli</option><option value="137" >Ghee</option><option value="826" >Ghevar</option><option value="281" >Ghughra</option><option value="76" >Ghyarsi dodo- bhaji</option><option value="13" >Ginger</option><option value="322" >Ginger Garlic Paste</option><option value="765" >Girda</option><option value="868" >Goan Cuisine</option><option value="458" >Goba puri</option><option value="468" >Gol Gappa</option><option value="524" >Goli Bajji</option><option value="848" >Gond Ladoo</option><option value="323" >Gota Baigan Besara</option><option value="749" >Gram Sweet ( Doce)</option><option value="100" >Grape/Angoor</option><option value="101" >Green bean</option><option value="239" >Green Cardomom</option><option value="11" >Green Chilli</option><option value="763" >Green Pea ka Kheer</option><option value="267" >Green Peas</option><option value="102" >Guava/Peru</option><option value="803" >Gud Chana</option><option value="813" >Gunder Pak</option><option value="475" >Gurda Kapoora Masala</option><option value="799" >Halwa - Made Up Of Wheat</option><option value="859" >Halwa Pulimunchi Masala</option><option value="474" >Halwa Thali</option><option value="465" >Hara Bhara  Namkeen</option><option value="676" >Holige</option><option value="42" >Horsegram</option><option value="215" >Hot Sauce</option><option value="392" >Hot Shot</option><option value="878" >Hyderabadi Cusine</option><option value="144" >Ice cream</option><option value="646" >Idiyappam</option><option value="824" >Ilayappam</option><option value="220" >Ilish (Hilsa)</option><option value="200" >Ilish Barishali</option><option value="219" >Ilish Macher Pulao</option><option value="717" >Imarti</option><option value="864" >Indian Cuisine</option><option value="57" >Jaggery</option><option value="570" >Jaifal pedhe</option><option value="743" >Jaipuri Mewa Pulao</option><option value="707" >Jawas Chutney</option><option value="18" >Jeera</option><option value="22" >Jeera powder</option><option value="835" >Jeera Puri</option><option value="159" >Jeerakam</option><option value="289" >Jodhpuri gatte</option><option value="56" >Jolada Roti</option><option value="418" >Kabuli Chana</option><option value="35" >Kabuli Channa/Chickpea</option><option value="149" >Kachri</option><option value="741" >Kachri Ki Chutney</option><option value="607" >Kadhi Mutton Soup</option><option value="689" >Kadi Idli</option><option value="786" >Kahjuri</option><option value="642" >Kai-Murukku</option><option value="698" >Kairichi Amti</option><option value="699" >Kairichi Dal(Raw Mango Dal)</option><option value="530" >Kakdi Pollo</option><option value="650" >Kakka</option><option value="34" >Kala Channa</option><option value="473" >Kaleji Gravy</option><option value="714" >Kali Masoor Dal</option><option value="588" >Kalwa Koshimbir</option><option value="590" >Kalwa Masala Fry</option><option value="302" >Kalwa salad</option><option value="489" >Kalya Vatanyacha sambar</option><option value="179" >Kanda Vada</option><option value="399" >Kande Poha (onion chiwda)</option><option value="573" >Kandi Pedhe</option><option value="659" >Kappa Phuzukku</option><option value="378" >Kara Boondi</option><option value="793" >Karanchi Jilebi</option><option value="649" >Karimeen Pollichathu</option><option value="648" >Karimeen Varuthathu</option><option value="502" >Karvanda Sharbat</option><option value="866" >Kashmiri Cuisine</option><option value="192" >Kashmiri Pulao</option><option value="769" >Kashmiri Saag</option><option value="601" >Kasundi Fish Tikka</option><option value="884" >Katachi Amti</option><option value="645" >Katti Pathiri</option><option value="838" >Kela Papdi</option><option value="705" >Kela Sheera</option><option value="637" >Kele Bajji</option><option value="540" >Kele Phodi</option><option value="486" >Kelyache Koshimbir</option><option value="748" >Ker Sangri Ki Sabzi</option><option value="863" >Kerala Cuisine</option><option value="161" >Kerala Egg Roast</option><option value="822" >Khaja</option><option value="816" >Khajali</option><option value="761" >Khajur Imli Ki Chutney</option><option value="849" >Khapse</option><option value="414" >Khara Sing</option><option value="521" >Kharvas</option><option value="724" >Khasta Mathura Aloo</option><option value="574" >Khasta Roti</option><option value="471" >Khekda Thali</option><option value="282" >Khichdi kadi</option><option value="292" >Khichia churi</option><option value="767" >Khubani Ka Meetha</option><option value="105" >Kiwi Fruit</option><option value="832" >Koat Pitha</option><option value="681" >Kobi Vada</option><option value="71" >Koki and papad</option><option value="308" >Kokum curry</option><option value="479" >Kolache Pohe</option><option value="575" >Kolambi bhaat</option><option value="591" >Kolambi Koshimbir</option><option value="592" >Kolambi Masala Fry</option><option value="516" >Kolhapuri Misal</option><option value="172" >Kolhapuri MIssal</option><option value="494" >Kolhapuri Tambda Rassa</option><option value="558" >Kolshyavarche</option><option value="581" >Kombadi Masala</option><option value="563" >Kombadi Vade</option><option value="871" >Konkani Cuisine</option><option value="576" >Kori Gassi</option><option value="518" >Kori Roti</option><option value="753" >Kormolas</option><option value="61" >Kosambari</option><option value="629" >Kothimbir  Mutton</option><option value="481" >Kothimbir vadi</option><option value="661" >Kozhi Varttiyathu</option><option value="734" >Kuler Ladoo</option><option value="750" >KulKul</option><option value="628" >Kundapura Chicken</option><option value="820" >Lakadiya</option><option value="44" >Lal Bhaji/Amarnath Leaves</option><option value="491" >Lal Math Bhaji</option><option value="338" >Lamb</option><option value="727" >Lapsi</option><option value="733" >Lasan Kadhi</option><option value="140" >Lassi</option><option value="760" >Lauki Kebab</option><option value="106" >Leek/Green onion</option><option value="103" >Lemon</option><option value="460" >Lemon Bhel</option><option value="415" >Lemon Chanadal</option><option value="50" >Lemon Grass/Gavati</option><option value="185" >Lemon juice</option><option value="840" >Lemon Miri Sev</option><option value="51" >Lettuce/Salad Patta</option><option value="390" >Lite Chanajor Mix</option><option value="768" >Lobia Ke Kebab</option><option value="507" >Loni Pollo</option><option value="720" >Lucknowi Dal</option><option value="598" >Lucknowi Seekh</option><option value="472" >Macchi Fry</option><option value="470" >Macchi Thali</option><option value="604" >Macchi Tikka Masala</option><option value="341" >Mace</option><option value="196" >Macher Chop</option><option value="542" >Mackerel Fry</option><option value="79" >Macroli Phoolpatasha</option><option value="342" >Madras curry</option><option value="680" >Madras Misal</option><option value="379" >Madrasi Mix</option><option value="784" >Magaj Ladoo</option><option value="396" >Mahalaxmi Chiwda</option><option value="869" >Maharashtrian Cuisine</option><option value="703" >Maharashtrian Kadhi</option><option value="776" >Mahim Halwa</option><option value="887" >Maize (Corn)</option><option value="568" >Maka Pattice</option><option value="814" >Makhaniya</option><option value="395" >Makka (Cornflakes) Chiwda</option><option value="477" >Makke Ki Roti and Sarson Ka Saag</option><option value="795" >Malai Mysore</option><option value="400" >Malamaal Chiwda</option><option value="789" >Malido</option><option value="718" >Malpua</option><option value="67" >Malpura</option><option value="246" >MAMIDIKAYA MENTHI PACHADI, INSTANT MANGO PICKLE RECIPE</option><option value="230" >MAMIDIKAYA PESARAPAPPU PACHADI, RAW MANGO MOONG DAL CHUTNEY</option><option value="304" >Mandeli fry</option><option value="63" >Mangalore Buns</option><option value="383" >Mangalori Mix</option><option value="108" >Mango</option><option value="277" >Mango Ginger</option><option value="362" >Mari (vanela) Gathiya</option><option value="441" >Mari banana chips</option><option value="417" >Mari Chana</option><option value="361" >Mari Fafda</option><option value="372" >Marwadi Sev</option><option value="811" >Marwari Ladoo</option><option value="443" >masala banana chips</option><option value="664" >Masala Bhaat</option><option value="377" >Masala Boondi</option><option value="360" >Masala Butter Papdi</option><option value="450" >masala sabudana khichdi</option><option value="446" >Masala salli</option><option value="371" >Masala Sev</option><option value="416" >Masala Sing</option><option value="559" >Masaledar Kale</option><option value="38" >Masoor dal</option><option value="453" >mathri puri</option><option value="719" >Mathura Peda</option><option value="420" >Mattar Jor</option><option value="139" >Mawa</option><option value="828" >Mawa bati</option><option value="787" >Mawa Boi</option><option value="738" >Mawa Kachori</option><option value="790" >Mawa Khaja</option><option value="788" >Mawa Pan Cake</option><option value="197" >Maxi Thala</option><option value="656" >Meen Manga Curry</option><option value="658" >Meen Thangapal Curry</option><option value="110" >Melon</option><option value="263" >Melon seeds</option><option value="805" >Mesub</option><option value="455" >Methi bajra puri</option><option value="438" >Methi Bhakarwadi</option><option value="771" >Methi Chaman</option><option value="368" >Methi Gathiya</option><option value="888" >Methi Ladu</option><option value="836" >Methi puri</option><option value="25" >Methi seed</option><option value="279" >methingota</option><option value="881" >Middle Eastern Cuisine</option><option value="130" >Milk</option><option value="146" >Milk powder</option><option value="265" >Minced Cilantro</option><option value="433" >Mini Bhakarwadi</option><option value="509" >Mini Dosa Platter</option><option value="839" >Mini Petha</option><option value="422" >Mini Samosa</option><option value="321" >Mint leaves</option><option value="221" >Mishti Doi</option><option value="195" >Missal Pav</option><option value="550" >Missi Roti</option><option value="85" >Mitho lolo</option><option value="393" >Mix Farsan</option><option value="800" >Mix Mithai</option><option value="198" >Mochar Ghonto</option><option value="780" >Mohanthal</option><option value="461" >Moong Bhel</option><option value="695" >Moong dahi misal</option><option value="33" >Moong dal</option><option value="746" >Moong Dal Ka Halwa</option><option value="203" >Moong Dhosa</option><option value="204" >Moong Onion Dhosa</option><option value="411" >Moongdal</option><option value="305" >Mori masala fry</option><option value="711" >Moti Pulav</option><option value="260" >Motichoor Ke Ladoo</option><option value="867" >Mughlai Cuisine</option><option value="381" >Mumbai Mix</option><option value="333" >Murg E Kalmi</option><option value="349" >murg-e-kalmi</option><option value="429" >Murukku</option><option value="111" >Mushroom</option><option value="539" >Mushti pollo with puddi chutney</option><option value="54" >Mustard Leaves</option><option value="245" >Mustard powder</option><option value="214" >Mustard Sauce</option><option value="17" >Mustard Seed (Rai)</option><option value="228" >Mustard seeds</option><option value="280" >Muthiya</option><option value="663" >Mutta Chikkiyathu</option><option value="356" >Mutton</option><option value="553" >Mutton Biryani</option><option value="545" >Mutton Brain Masala</option><option value="630" >Mutton Dahiwala</option><option value="583" >Mutton Dopyaza</option><option value="773" >Mutton Gurda kapoora</option><option value="511" >Mutton Gurda Masala</option><option value="514" >Mutton Hyderabadi</option><option value="300" >Mutton kaleji thali</option><option value="513" >Mutton Kheema Masala</option><option value="512" >Mutton Liver Masala</option><option value="189" >Mutton Malvani Tava Fry</option><option value="309" >Mutton mughlai</option><option value="584" >Mutton Sagwala</option><option value="779" >Mysore Pak</option><option value="464" >Nachni (RAGI) Sticks</option><option value="572" >Nachni Ladu</option><option value="385" >Nadiyadi Bhusa</option><option value="364" >Nailon Bhavanagri</option><option value="370" >Nailon Sev</option><option value="367" >Nailon Surti</option><option value="837" >Nam Puri</option><option value="428" >Namkeen Papad Churi</option><option value="427" >Namkeen Shakarpara</option><option value="702" >Narali Bhaat</option><option value="503" >Nargisi Kofta</option><option value="851" >Nariko ladoo</option><option value="778" >Navratna Dalmoth</option><option value="388" >Navratna Mix</option><option value="677" >Neer Dosa And Chicken Sukha</option><option value="519" >Neer Dosa with Chutney</option><option value="651" >Netholi Fish Curry</option><option value="655" >Ney Meen Curry</option><option value="691" >Neyappam</option><option value="311" >Neza kebab</option><option value="258" >Nigella seeds</option><option value="391" >Noodles Mix</option><option value="865" >North Indian Cuisine</option><option value="113" >Nut</option><option value="28" >Nutmeg</option><option value="254" >Nutmug</option><option value="527" >Nyappam</option><option value="536" >Oats Doddak</option><option value="165" >Oil</option><option value="114" >Olive</option><option value="5" >Onion</option><option value="223" >Onion paste</option><option value="8" >Onion Uttapam</option><option value="96" >Orange</option><option value="262" >Orange food color</option><option value="810" >Pakhija</option><option value="882" >Pakoda</option><option value="688" >Pakoda Lasuni Curry with Rice</option><option value="747" >Pakode Wali Kadhi</option><option value="286" >Palak dosa</option><option value="834" >Palak Puri</option><option value="52" >Palak/Spinach</option><option value="153" >Pan Cakes</option><option value="802" >Pan Mathri</option><option value="506" >Pan Pollo</option><option value="617" >Pandhara Rassa</option><option value="133" >Paneer</option><option value="194" >Paneer  Peshwari Tikka</option><option value="193" >Paneer Dobara</option><option value="842" >Paneer Jalebi</option><option value="529" >PanPoli</option><option value="462" >Papad Bhel</option><option value="730" >Papayo no sambharo</option><option value="358" >Papdi</option><option value="857" >Paplet Pulimunchi Masala</option><option value="213" >Paprica Powder</option><option value="217" >Parmesan cheese</option><option value="880" >Parsi Cuisine</option><option value="343" >Parsi Dhana</option><option value="331" >PARSI FISH WITH GREEN CHUTNEY, PATRA NI MACHHI</option><option value="564" >Parval</option><option value="315" >Patato</option><option value="495" >Patodi Rassa</option><option value="647" >Patorda</option><option value="15" >Patta Gobi</option><option value="478" >Paya Masala</option><option value="685" >Paysam</option><option value="115" >Pea/mutter</option><option value="112" >Peach</option><option value="116" >Peanut/Mungfhali</option><option value="117" >Pear</option><option value="184" >Pepper powder</option><option value="752" >Perad</option><option value="538" >Phanna Pollo</option><option value="850" >Phuklein</option><option value="206" >PHULKO LUCHI</option><option value="496" >Phunke Kadhi</option><option value="754" >Pinaca</option><option value="296" >Pindi chole</option><option value="119" >Pineapple</option><option value="346" >Pink coloured ravo</option><option value="758" >Pinni</option><option value="129" >Pistachios</option><option value="678" >Piyush</option><option value="580" >Plate Dosa</option><option value="582" >Plate Roti</option><option value="329" >POACHED EGG</option><option value="177" >Poha Samosa</option><option value="68" >Pohp batalu jo pulao</option><option value="332" >Pomfret</option><option value="690" >Pongal</option><option value="386" >Pooneri Missal Mix</option><option value="10" >Potato</option><option value="354" >Potol/Parwal</option><option value="236" >Powdered sugar</option><option value="316" >Prawn Patato Curry (Chungudi Aloo Tarakari)</option><option value="180" >Prawn Tomato Stir Fry (CHEMMEEN THAKKALI VARATTIYATHU)</option><option value="181" >Prawns</option><option value="616" >Prawns Biryani</option><option value="301" >Prawns salad</option><option value="706" >Pudachi Vadi</option><option value="531" >Puddi Idli</option><option value="53" >Pudhina /Mint leaves</option><option value="299" >Pudina paratha</option><option value="120" >Pumpkin</option><option value="325" >Punch Phutana</option><option value="274" >Punch Puran</option><option value="434" >Pune Bhakarwadi</option><option value="870" >Punjabi Cuisine</option><option value="549" >Punjabi Kofte</option><option value="665" >PuranPoli</option><option value="520" >Puri Bhaji</option><option value="679" >Puri Kurma</option><option value="150" >Puttu</option><option value="613" >Pyaaz Kachori</option><option value="257" >Pyaaz ki Kachori</option><option value="298" >Pyaazmirkchi roti</option><option value="821" >Qubani Ka Meetha</option><option value="312" >Raan sikandari</option><option value="121" >Radish</option><option value="126" >Raisins</option><option value="291" >Rajasthan dal</option><option value="876" >Rajasthani Cuisine</option><option value="740" >Rajasthani Doodhiya Kheech</option><option value="615" >Rajasthani Kabuli Biryani</option><option value="251" >Rajasthani Kanji Vada</option><option value="614" >Rajasthani Mirchi Bada</option><option value="561" >Rajasthani Thali</option><option value="796" >Rajbhog Shrikhand</option><option value="37" >Rajma (kidney beans)</option><option value="476" >Rajma Chawal</option><option value="710" >Rajma Tikki</option><option value="533" >Rasam Ambode</option><option value="639" >Rasam Wada</option><option value="501" >Ratalayache Kees</option><option value="693" >Ratalyacha kees</option><option value="374" >Ratlami Sev</option><option value="889" >Rava Ladu</option><option value="347" >Ravo</option><option value="344" >RAVO (FROM COOKBOOK)</option><option value="107" >Raw banana</option><option value="231" >Raw Mango</option><option value="7" >Rawa</option><option value="20" >Red chilli powder (lal mirch)</option><option value="340" >Red Kashmir Chillies</option><option value="211" >Red onion</option><option value="335" >refined flour</option><option value="675" >Refined wheat flour</option><option value="641" >Ribbon Pakoda</option><option value="222" >Rice</option><option value="152" >Rice Flour</option><option value="729" >Rice Flour Khichu</option><option value="151" >Rice Powder</option><option value="682" >Rice Vada</option><option value="397" >Roasted Nailon Chiwda</option><option value="770" >Roath</option><option value="313" >Rogan gosht</option><option value="823" >Rosogulla</option><option value="635" >S.K Pakoda</option><option value="449" >Sabudana</option><option value="447" >sabudana chiwda</option><option value="448" >sabudana khichdi</option><option value="492" >Sabudana Vada</option><option value="369" >Sada Sev (Mora)</option><option value="831" >Sael Roti</option><option value="148" >Saffron ( kesar)</option><option value="255" >Saffron (Starnds)</option><option value="69" >Sai bhaaji</option><option value="841" >Sai Bhaji and rice</option><option value="809" >Salam Pak (sukahdi)</option><option value="157" >Salt</option><option value="445" >Salted salli</option><option value="546" >Samosa Chole</option><option value="644" >Sanna Polo/ Pathrode Dosa</option><option value="270" >Sattu Ki Kachori</option><option value="210" >Sausage</option><option value="608" >Seafood Kulith Soup</option><option value="81" >Seero</option><option value="672" >Sesame Seeds</option><option value="202" >Set Dosa</option><option value="815" >Sev</option><option value="457" >Sev puri</option><option value="638" >Sevai Lemon / Coconut / Plain</option><option value="605" >Seven Taste Uttapam</option><option value="70" >Seyal Murg</option><option value="625" >Seyal Pav</option><option value="72" >Seyun patata</option><option value="404" >Shahi Dalmooth</option><option value="759" >Shakarkandi Chat</option><option value="426" >Shakkarpara</option><option value="589" >Shell Fish Masala Fry</option><option value="704" >Shengdanyacha Thecha</option><option value="490" >Shev Bhaji</option><option value="398" >Shev Chiwda</option><option value="135" >Shrikhand</option><option value="827" >Shufta</option><option value="442" >Silky mari banana chips</option><option value="440" >Silky yellow banana chips</option><option value="667" >Sindhi Chawli</option><option value="873" >Sindhi Cuisine</option><option value="74" >Sindhi Curry and Rice</option><option value="596" >Sindhi Koki</option><option value="413" >Singbhaji</option><option value="209" >SKINNY (BAKED) JALAPENO POPPERS WITH SPICY SAUSAGE MIX</option><option value="855" >Snack Box - Karnataka</option><option value="854" >Snack Box - Maharashtra</option><option value="782" >Snack Box - Multi States</option><option value="560" >Solkadhi</option><option value="861" >Sonte - A Healthy Sweet Potato Snack</option><option value="726" >Soya Dum Biryani</option><option value="138" >Soya milk</option><option value="318" >Soyabean</option><option value="317" >Soyabean Fried Rice</option><option value="798" >Special Aflatoon</option><option value="290" >Special Khobewali Roti</option><option value="845" >Speciality From Eight States</option><option value="843" >Speciality From Four States</option><option value="844" >Speciality From Various States</option><option value="394" >Spicy Mix</option><option value="886" >Spl. Bhajni Chakli</option><option value="424" >Spring Rolls</option><option value="170" >Star Anise</option><option value="122" >Strawberry</option><option value="555" >Stuff Pompret with prawns filling</option><option value="806" >Stuffed Gulab Jamun</option><option value="158" >Sugar</option><option value="459" >Sukha Bhel</option><option value="751" >Sukrunde</option><option value="807" >Surajmukhi</option><option value="534" >suran</option><option value="725" >Suran Chutney</option><option value="541" >Suran Fries</option><option value="528" >Surian</option><option value="858" >Surmai Pulimunchi Masala</option><option value="366" >Surti Gathiya</option><option value="792" >Surti Peda</option><option value="123" >Sweet potato</option><option value="674" >Tamarind</option><option value="666" >Tambda Rassa</option><option value="875" >Tamil Cuisine</option><option value="463" >Tangy Tamato Stick</option><option value="766" >Tao Gugji</option><option value="603" >Tariwala Jhinga</option><option value="77" >Tayri-vangan patata</option><option value="456" >Tea time puri</option><option value="535" >Teen Dalli Pollo</option><option value="713" >Tehri ( Vegetable pulav)</option><option value="673" >test 2</option><option value="58" >Thaliipeet</option><option value="493" >Thalipeeth</option><option value="294" >Thalipith</option><option value="653" >Thenga Aracha Meen Curry</option><option value="833" >Thepla</option><option value="75" >Tidali dal-Dodo</option><option value="365" >Tikha Gathiya</option><option value="384" >Tikha Kolhapuri Mix</option><option value="547" >Tikki Chole</option><option value="303" >Tikle gravy (fish)</option><option value="30" >Til seeed</option><option value="619" >Tisrya Kolambi Mix</option><option value="618" >Tisrya Masala</option><option value="134" >Tofu</option><option value="6" >Tomato</option><option value="182" >Tomato Ketchup</option><option value="41" >Toor /Arhar dal</option><option value="783" >TOS  Snack Box ( Premium)</option><option value="669" >TOS Gujarati Platter</option><option value="670" >TOS Maharashtrian  Platter</option><option value="781" >TOS Snack Box (Mini)</option><option value="774" >TOS Snack Sampler</option><option value="874" >Traditional CKP</option><option value="467" >Try-Angles</option><option value="65" >Tuk</option><option value="500" >Tup Methkut Bhaat</option><option value="327" >Turmeric</option><option value="163" >Turmeric  Powder</option><option value="19" >Turmeric powder (haldi)</option><option value="606" >Twin Dosa</option><option value="808" >Udad Ladoo</option><option value="382" >Udipi Mix</option><option value="694" >Ukad/Thakachi Ukad</option><option value="526" >Ulundhu Dosa</option><option value="205" >Ulundu Dhosa</option><option value="278" >undhiya</option><option value="686" >Undiya Kathiawadi</option><option value="522" >Upma Chana</option><option value="671" >Upvas Ka Platter</option><option value="452" >upwas sev</option><option value="40" >Urad dal</option><option value="877" >Uttar Pradesh Cuisine</option><option value="240" >VADAPAPPU PANAKAM</option><option value="249" >Vadas</option><option value="709" >Val Usal</option><option value="485" >Vangyache Bharit</option><option value="345" >vanialla or rose essence</option><option value="708" >Varanfal</option><option value="856" >Variety of  Snacks to tingle your Taste buds</option><option value="662" >Varutharacha Kozhi Curry</option><option value="652" >Varutharacha Meen Curry</option><option value="78" >Varyun wara chanwaran</option><option value="684" >Vatana Bonda</option><option value="683" >Vatana Pattice</option><option value="284" >veg handi</option><option value="565" >Veg Thali</option><option value="643" >Veg. Bonda</option><option value="548" >Veg. Patiala</option><option value="504" >Veg. Seekh Kabab</option><option value="186" >Vegetable / Paneer Malvani tava fry</option><option value="166" >Vegetable stew</option><option value="756" >Vegetable Vindaloo</option><option value="167" >Vegetables</option><option value="353" >Vermicelli</option><option value="587" >Walacha Birda</option><option value="620" >Walache Birde</option><option value="127" >Walnut</option><option value="124" >Watermelon</option><option value="271" >Wheat Flour</option><option value="860" >wheat halwa</option><option value="225" >Wheat Rava</option><option value="224" >Wheat Rava Idli</option><option value="328" >White Vinegar</option><option value="32" >Whole Moong</option><option value="125" >Yam/Suran</option><option value="439" >Yellow banana chips</option><option value="248" >Yellow Moong Dal</option><option value="136" >Yoghurt/Curd/dahi</option><option value="276" >Yogurt</option><option value="97" >Zucchini</option><option value="701" >Zunka</option><option value="569" >Zunka Bhakar</option>									</select>
								</div>
									
							</div>	
							<div class="form-group">	
								
								<label class="col-lg-2 control-label">Menu Image/Pdf</label>
								<div class="col-lg-4">
									<input type="file" name="vloc_menu_file[]" id="vloc_menu_file_0" class="form-control">
								</div>
														
								
								<label class="col-lg-2 control-label">Vendor Estt Pdf</label>
								<div class="col-lg-4">
									<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_0" class="form-control">
								</div>
								
							</div>
							
							<div class="form-group left-label">
								<label class="col-lg-6 control-label"><strong>Licences, Registration, Certification & Memberships:</strong></label>
							</div>
														<div id="row_cert_0_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
								<input type="hidden" name="vc_cert_id_0[]" id="vc_cert_id_0_0" value="0">
								<input type="hidden" name="hdnvc_cert_scan_file_0_0" id="hdnvc_cert_scan_file_0_0" value="">
								<div class="form-group small-title">
																	<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>
									<div class="col-lg-5">
										<select name="vc_cert_type_id_0[]" id="vc_cert_type_id_0_0" class="form-control" required22>
											<option value="" >Select Type</option><option value="74" >Certification</option><option value="72" >Licence</option><option value="75" >Membership</option><option value="73" >Registration</option>										</select>
									</div>
																	
									
									
									<label class="col-lg-1 control-label">Name</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_name_0[]" id="vc_cert_name_0_0" value="" placeholder="Name" class="form-control" required22>
									</div>
									
								</div>	
								<div class="form-group small-title">
																	<label class="col-lg-1 control-label">Number</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_no_0[]" id="vc_cert_no_0_0" value="" placeholder="Number" class="form-control" required22>
									</div>
								
									
									<label class="col-lg-1 control-label">Issued By</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_issued_by_0[]" id="vc_cert_issued_by_0_0" value="" placeholder="Issued By" class="form-control" required22>
									</div>
									
								</div>	
								<div class="form-group small-title">
																	<label class="col-lg-1 control-label">Issued Date</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_reg_date_0[]" id="vc_cert_reg_date_0_0" value="" placeholder="Issued Date" class="form-control clsdatepicker2" required22>
									</div>
								
									
									<label class="col-lg-1 control-label">Vaidity Date</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_validity_date_0[]" id="vc_cert_validity_date_0_0" value="" placeholder="Validity Date" class="form-control clsdatepicker" required22>
									</div>
									
								</div>
								<div class="form-group small-title">
									
									<label class="col-lg-1 control-label">Scan Image</label>
									<div class="col-lg-5">
										<input type="file" name="vc_cert_scan_file_0[]" id="vc_cert_scan_file_0_0" class="form-control" >
									</div>
										
								</div>
								<div class="form-group">
									<div class="col-lg-2">
																			<a href="javascript:void(0);" onclick="addMoreRowCertificate(0);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>
										
									</div>
								</div>
							</div>	
														<div class="form-group">
								<div class="col-lg-2">
																	<a href="javascript:void(0);" onclick="addMoreRowLocation();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>
									
								</div>
							</div>
						</div>
											
						
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
			<!--footer start-->
			
 <footer style="border-top: white;"> 

   <div class="container">

   <div class="row">

   <div class="col-md-12">	

                        

 <table width="100%" cellspacing="5" cellpadding="10" border="0" class="footerBg" id="footer" >                                                    <tbody><tr>                                                        

                        <td width="70%" valign="middle" height="" align="left">

                        <div style="background-color:#5abd46; padding-left:15px;">

                        <span id="footer_pages" class="footerN" > <a class="footer_link" href="index.php">Home</a> | <a class="footer_link" href="about_us.php">About Us</a> | <a class="footer_link" href="contact_us.php">Contact Us</a> | <a class="footer_link" href="resources.php">Resources</a> | <a class="footer_link" href="disclaimer.php" >Disclaimer</a> | <a class="footer_link" href="terms_and_conditions.php" >Terms &amp; Conditions</a> | <a class="footer_link" href="privacy_policy.php">Privacy Policy</a> | </span><a href="#" class="footer_link" target="_blank">Blog</a></div> </td>                                                        <td width="30%" rowspan="2" align="right" valign="middle"><table width="30%" border="0" cellspacing="0" cellpadding="0">



  <tr>



    <td><a href="https://www.facebook.com/WellnessWay4U" target="_blank"><img src="uploads/fb.jpg" width="32" height="32" alt="facebook" /></a></td>



    <td><a href="https://twitter.com/WellnessWay4U" target="_blank"><img src="uploads/tw.jpg" width="32" height="32" alt="Twitter" /></a></td>



    <td><a href="#" target="_blank"><img src="uploads/linkedin.jpg" width="32" height="32" alt="Linkedin" /></a></td>



    <td><a href="#" target="_blank"><img src="uploads/youtube.jpg" width="32" height="32" alt="Youtube" /></a></td>



 <td><a target="_blank" href="#"><img width="32" height="32" alt="instagram" src="uploads/instagram.jpg"></a></td>



  </tr>



</table></td>                                                    </tr>



 

</tbody>



</table>

                            

 <div style="font-size:12px;">&copy;2016 Chaitanya Wellness Research Institute, all rights reserved.</div>

<!--default footer end here-->

 

        
       
  </div>

  </div>

  </footer>
			<!--footer end-->
                        
		</section><!--end main content-->
	</div>
</div><!--end wrapper--><!--Common plugins-->
<script src="wa/assets/plugins/jquery/dist/jquery.min.js"></script>
<script src="wa/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="wa/assets/plugins/hoe-nav/hoe.js"></script>
<script src="wa/assets/plugins/pace/pace.min.js"></script>
<script src="wa/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="wa/assets/js/app.js"></script>
<script src="wa/assets/js/moment-with-locales.js"></script>
<script src="wa/assets/js/bootstrap-datepicker.js"></script>
<script src="wa/assets/js/bootstrap-datetimepicker.js"></script>
<script src="wa/assets/js/bootstrap-dialog.js"></script>
<script src="wa/assets/js/bootbox.min.js"></script>
<script src="wa/assets/plugins/summernote/summernote.min.js"></script>
<script src="wa/admin-js/commonfn.js" type="text/javascript"></script>
<script type="text/javascript" src="wa/js/jquery.validate.min.js"></script>
<script src="wa/admin-js/register-validator.js" type="text/javascript"></script>
<script src="wa/js/tokenize2.js"></script>
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
			url: "wa/ajax/remote.php",
			data: dataString,
			cache: false,      
			success: function(result)
			{
                            
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
			url: "wa/ajax/remote.php",
			data: dataString,
			cache: false,      
			success: function(result)
			{
                           // alert(result);
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
			url: "wa/ajax/remote.php",
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
							
										new_row +=			'<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>'+
								'<div class="col-lg-5">'+
									'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control" required22>'+
										'<option value="" >Select Type</option><option value="74" >Certification</option><option value="72" >Licence</option><option value="75" >Membership</option><option value="73" >Registration</option>'+
									'</select>'+
								'</div>';
															
							
										new_row +=			'<label class="col-lg-1 control-label">Name</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+
								'</div>';
								
							
			new_row +=		'</div>'+	
							'<div class="form-group small-title">';
							
										new_row +=			'<label class="col-lg-1 control-label">Number</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+
								'</div>';
								
							
										new_row +=			'<label class="col-lg-1 control-label">Issued By</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+
								'</div>';
								
							
			new_row +=		'</div>'+	
							'<div class="form-group small-title">';
							
										new_row +=			'<label class="col-lg-1 control-label">Issued Date</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+
								'</div>';
								
							
										new_row +=			'<label class="col-lg-1 control-label">Vaidity Date</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+
								'</div>';
														
			new_row +=		'</div>'+
							'<div class="form-group small-title">';
							
										new_row +=			'<label class="col-lg-1 control-label">Scan Image</label>'+
								'<div class="col-lg-5">'+
									'<input type="file" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'_'+cert_cnt+'" class="form-control" >'+
								'</div>';
								
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
							
																		new_row +=			'<input type="hidden" name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" value="2" >';
			new_row += 			'<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" class="form-control" required22>'+
										'<option value="" >Select Category</option><option value="31" >Branch Restaurant</option><option value="5" >Centralised Kitchen</option><option value="4" >Cloud Kitchen</option><option value="79" >Head Office</option><option value="30" >Main Restaurant</option>'+
									'</select>'+
								'</div>';				
																
						
			
			new_row += 		'</div>'+
							'<div class="form-group" >';
							
										
			new_row +=			'<label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="country_id[]" id="country_id_'+cat_cnt+'" onchange="getStateOptionAddMore('+cat_cnt+')" class="form-control" required22>'+
										'<option value="" >Select Country</option><option value="11" >Afganistan</option><option value="12" >Albania</option><option value="13" >Algeria</option><option value="14" >American Samoa</option><option value="15" >Andorra</option><option value="16" >Angola</option><option value="17" >Anguilla</option><option value="18" >Antigua and Barbuda</option><option value="19" >Argentina</option><option value="20" >Armenia</option><option value="5" >Australia</option><option value="21" >Austria</option><option value="22" >Azerbaijan</option><option value="23" >Bahamas</option><option value="24" >Bahrain</option><option value="25" >Bangladesh</option><option value="26" >Barbados</option><option value="27" >Belarus</option><option value="28" >Belgium</option><option value="29" >Belize</option><option value="30" >Benin</option><option value="31" >Bermuda</option><option value="32" >Bhutan</option><option value="33" >Bolivia</option><option value="34" >Bosnia and Herzegovina</option><option value="35" >Botswana</option><option value="36" >Brazil</option><option value="37" >British Virgin Islands</option><option value="38" >Brunei</option><option value="40" >Bulgaria</option><option value="41" >Burkina Faso</option><option value="42" >Burundi</option><option value="43" >Cambodia</option><option value="44" >Cameroon</option><option value="6" >Canada</option><option value="45" >Canary Islands</option><option value="46" >Cape Verde</option><option value="47" >Cayman Islands</option><option value="48" >Central African Republic</option><option value="49" >Chad</option><option value="50" >Chile</option><option value="51" >China</option><option value="52" >Colombia</option><option value="53" >Comoros</option><option value="54" >Congo</option><option value="55" >Cook Islands</option><option value="56" >Costa Rica</option><option value="57" >Cote Dlvoire</option><option value="58" >Croatia</option><option value="59" >Cuba</option><option value="60" >Cyprus</option><option value="61" >Czech Republic</option><option value="62" >Denmark</option><option value="63" >Dominica</option><option value="64" >Dominican Republic</option><option value="66" >East Timor</option><option value="67" >Ecuador</option><option value="68" >Egypt</option><option value="69" >El Salvador</option><option value="70" >Equatorial Guinea</option><option value="71" >Eritrea</option><option value="72" >Estonia</option><option value="73" >Ethiopia</option><option value="75" >Falkland Islands ( Islas Malvinas )</option><option value="74" >Faroe Islands</option><option value="76" >Fiji</option><option value="77" >Finland</option><option value="78" >France</option><option value="79" >French Guiana</option><option value="80" >French Polynesia</option><option value="81" >Gambia</option><option value="82" >Georgia</option><option value="83" >Germany</option><option value="84" >Ghana</option><option value="85" >Gibraltar</option><option value="86" >Greece</option><option value="87" >Greenland</option><option value="88" >Grenada</option><option value="89" >Guadeloupe</option><option value="90" >Guam</option><option value="91" >Guatemala</option><option value="92" >Guinea</option><option value="93" >Guinea - Bissau</option><option value="94" >Guyana</option><option value="95" >Haiti</option><option value="96" >Holland</option><option value="97" >Honduras</option><option value="98" >Hong Kong</option><option value="99" >Hungary</option><option value="100" >Iceland</option><option value="1" >India</option><option value="101" >Indonesia</option><option value="102" >Iran</option><option value="103" >Iraq</option><option value="104" >Ireland</option><option value="105" >Isle of Man</option><option value="106" >Israel</option><option value="107" >Italy</option><option value="108" >Jamaica</option><option value="109" >Japan</option><option value="110" >Jordan</option><option value="111" >Kazakhstan</option><option value="112" >Kenya</option><option value="113" >Kiribati</option><option value="114" >Kuwait</option><option value="115" >Kyrgyzstan</option><option value="116" >Laos</option><option value="117" >Latvia</option><option value="118" >Lebanon</option><option value="119" >Lesotho</option><option value="120" >Liberia</option><option value="121" >Libya</option><option value="122" >Liechtenstein</option><option value="123" >Lithuania</option><option value="124" >Luxembourg</option><option value="125" >Macao</option><option value="126" >Macedonia</option><option value="127" >Madagascar</option><option value="128" >Malawi</option><option value="129" >Malaysia</option><option value="130" >Maldives</option><option value="136" >Maldova</option><option value="131" >Mali</option><option value="132" >Malta</option><option value="133" >Martinique</option><option value="134" >Mauritius</option><option value="135" >Mexico</option><option value="137" >Monaco</option><option value="138" >Mongolia</option><option value="139" >Montenegro</option><option value="140" >Montserrat</option><option value="141" >Morocco</option><option value="142" >Mozambique</option><option value="143" >Myanmar</option><option value="144" >Namibia</option><option value="145" >Nepal</option><option value="146" >Netherlands</option><option value="147" >Netherlands Antilles</option><option value="148" >New Caledonia</option><option value="149" >New Zealand</option><option value="150" >Nicaragua</option><option value="151" >Niger</option><option value="152" >Nigeria</option><option value="153" >North Korea</option><option value="154" >Norway</option><option value="155" >Oman</option><option value="219" >Others</option><option value="7" >Pakistan</option><option value="156" >Panama</option><option value="157" >Papua New Guinea</option><option value="158" >Paraguay</option><option value="159" >Peru</option><option value="160" >Philippines</option><option value="161" >Poland</option><option value="162" >Portugal</option><option value="163" >Puerto Rico</option><option value="164" >Qatar</option><option value="165" >Reunion</option><option value="166" >Romania</option><option value="167" >Russia</option><option value="168" >Rwanda</option><option value="169" >Saint Kitts and Nevis</option><option value="170" >Saint Lucia</option><option value="172" >Saint Marino</option><option value="173" >Saint Tome and Principe</option><option value="171" >Saint Vincent and the Grenadines</option><option value="174" >Saudi Arabia</option><option value="175" >Senegal</option><option value="177" >Serbia</option><option value="176" >Seychelles</option><option value="178" >Sierra Leone</option><option value="179" >Singapore</option><option value="180" >Slovakia</option><option value="181" >Slovenia</option><option value="182" >Solomon Islands</option><option value="183" >Somalia</option><option value="184" >South Africa</option><option value="185" >South Korea</option><option value="186" >Spain</option><option value="187" >Sri Lanka</option><option value="188" >Sudan</option><option value="189" >Suriname</option><option value="190" >Swaziland</option><option value="191" >Sweden</option><option value="192" >Switzerland</option><option value="193" >Syrian Arab Republic</option><option value="194" >Tahiti</option><option value="195" >Taiwan</option><option value="196" >Tajikistan</option><option value="197" >Tanzania</option><option value="198" >Thailand</option><option value="199" >Togo</option><option value="200" >Trinidad and Tobago</option><option value="201" >Tunisia</option><option value="202" >Turkey</option><option value="203" >Turkmenistan</option><option value="204" >Turks and Caicos Islands</option><option value="205" >Uganda</option><option value="206" >Ukraine</option><option value="8" >United Arab Emirates</option><option value="9" >United Kingdom</option><option value="10" >United States</option><option value="207" >United States Virgin Islands</option><option value="208" >Uruguay</option><option value="209" >Uzbekistan</option><option value="210" >Vanuatu</option><option value="211" >Vatican City State</option><option value="212" >Venezuela</option><option value="213" >Vietnam</option><option value="214" >Wallis and Futuna</option><option value="215" >Yemen</option><option value="217" >Zambia</option><option value="218" >Zimbabwe</option>'+
									'</select>'+
								'</div>';
										
					
										
			new_row +=			'<label class="col-lg-2 control-label">State<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="state_id[]" id="state_id_'+cat_cnt+'" onchange="getCityOptionAddMore('+cat_cnt+')" class="form-control" required22>'+
										'<option value="" >Select State</option>'+
									'</select>'+
								'</div>';
											
							
			new_row +=		'</div>'+
							'<div class="form-group">';
							
										
			new_row +=			'<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="city_id[]" id="city_id_'+cat_cnt+'" onchange="getAreaOptionAddMore('+cat_cnt+')" class="form-control" required22>'+
										'<option value="" >Select City</option>'+
									'</select>'+
								'</div>';
														
											
			new_row +=			'<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="area_id[]" id="area_id_'+cat_cnt+'" class="form-control" required22>'+
										'<option value="" >Select Area</option>'+
									'</select>'+
								'</div>';
														
			new_row +=		'</div>'+
							'<div class="form-group">';
							
											
			new_row +=			'<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="contact_person_title[]" id="contact_person_title_'+cat_cnt+'" class="form-control" required22>'+
										'<option value="" >Select Gender</option><option value="Female" >Female</option><option value="Male" >Male</option>'+
									'</select>'+
								'</div>';
								
							
								
			new_row +=			'<label class="col-lg-2 control-label">Contact Person Name<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_person[]" id="contact_person_'+cat_cnt+'" value="" placeholder="Contact Person" class="form-control" required22>'+
								'</div>';
									
								
			new_row +=		'</div>'+
							'<div class="form-group">';
							
								
			new_row +=			'<label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_email[]" id="contact_email_'+cat_cnt+'" value="" placeholder="Contact Email" class="form-control" >'+
								'</div>';
										
								
									
			new_row +=			'<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_number[]" id="contact_number_'+cat_cnt+'" value="" placeholder="Contact Number" class="form-control" >'+
								'</div>';
											
								
			new_row +=		'</div>'+
							'<div class="form-group">';
							
										new_row +=			'<label class="col-lg-2 control-label">Contact Designation</label>'+
								'<div class="col-lg-4">'+
									'<select name="contact_designation[]" id="contact_designation_'+cat_cnt+'" class="form-control">'+
										'<option value="" >Select Designation</option><option value="48" >Chef</option><option value="49" >Cook</option><option value="50" >Delivery Person</option><option value="28" >Director</option><option value="47" >Main Chef</option><option value="29" >Manager</option><option value="26" >Owner</option><option value="27" >Partner</option>'+
									'</select>'+
								'</div>';
												
								
								
			new_row +=			'<label class="col-lg-2 control-label">Remark</label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_remark[]" id="contact_remark_'+cat_cnt+'" value="" placeholder="Remark" class="form-control">'+
								'</div>';
															
			new_row +=		'</div>'+
							'<div class="form-group">';
							
										new_row +=			'<label class="col-lg-2 control-label">Speciality Offered</label>'+
								'<div class="col-lg-10">'+
									'<select name="vloc_speciality_offered_'+cat_cnt+'[]" id="vloc_speciality_offered_'+cat_cnt+'" multiple="multiple" class="form-control vloc_speciality_offered" >'+
										'<option value="" >Select Speciality</option><option value="586" >Aajker Bhajabhuji</option><option value="268" >Aam Jhor</option><option value="600" >Achari Jhinga</option><option value="732" >Adadiya Ladoo</option><option value="794" >Adadiya Pak</option><option value="297" >Adaraki Aloo Methi</option><option value="791" >Agharni Na Ladva</option><option value="387" >Agra Dalmooth</option><option value="24" >Ajwain (carram seed)</option><option value="612" >Ajwain Paratha</option><option value="39" >Akkha Masoor  dal</option><option value="571" >Aliv Ladu</option><option value="62" >Almonds</option><option value="552" >Aloo Raita</option><option value="593" >Aloo Tuk</option><option value="469" >Alu Chat Papdi</option><option value="350" >Alu Leaves</option><option value="375" >Alu Palak Sev</option><option value="482" >Aluvadi</option><option value="295" >Aluwadi</option><option value="480" >Amboli</option><option value="275" >Ambula</option><option value="380" >Amdavadi Mix</option><option value="551" >Amritsari chole</option><option value="700" >Anarsa</option><option value="687" >Angoor  Basundi</option><option value="862" >Appalu</option><option value="537" >Appe</option><option value="86" >Apple</option><option value="87" >Apricot</option><option value="597" >Arbi Tuk</option><option value="233" >Asafoetida (Hing)</option><option value="88" >Asparagus</option><option value="668" >Atta Ka Halwa</option><option value="89" >Aubergine/Purple Brinjal/Baigan</option><option value="357" >Aval</option><option value="90" >Avocado</option><option value="879" >Awadhi Cuisine</option><option value="82" >Baat Jo Seero</option><option value="762" >Babroo</option><option value="402" >Badam Kaju Poha</option><option value="405" >Badam Lachcha</option><option value="60" >Badane Kaayi</option><option value="742" >Bafla Bati</option><option value="283" >Baingan Bharta</option><option value="454" >bajra flour</option><option value="722" >Bakheer</option><option value="830" >Bal Mithai</option><option value="785" >Balushahi</option><option value="692" >Banana (plaintain) Flower</option><option value="91" >Banana/Kela</option><option value="846" >Basundi</option><option value="885" >Batata Chivda</option><option value="174" >Batatawada</option><option value="804" >Batisa Ladoo</option><option value="31" >Bay leaves</option><option value="883" >Beans</option><option value="847" >Bebinca</option><option value="92" >Beetroot</option><option value="118" >Bell pepper</option><option value="242" >Bellam Thalikalu</option><option value="259" >Besan</option><option value="764" >Besan  Ka Halwa</option><option value="626" >Besan ji Tikki</option><option value="715" >Besan ke Ladoo</option><option value="611" >Besan Paratha</option><option value="432" >Bhakarwadi</option><option value="728" >Bharlela Tameta</option><option value="59" >Bhatkali Chicken Biryani</option><option value="363" >Bhavnagari Gathiya</option><option value="595" >Bhea Chips</option><option value="737" >Bhee rolls</option><option value="609" >Bheja tawa</option><option value="508" >Bhopla Doddak</option><option value="484" >Bhoplyache Bharit</option><option value="483" >Bhoplyache Thalipeeth</option><option value="872" >Biryani</option><option value="319" >Biryani powder</option><option value="435" >Biscuit Bhakarwadi</option><option value="640" >Bisi-bela Rice</option><option value="147" >Black cardamom</option><option value="339" >Black eyed  peas</option><option value="23" >Black pepper ( kali mirchi)</option><option value="247" >Black salt</option><option value="266" >Boiled Rice</option><option value="577" >Bombay Duck</option><option value="797" >Bombay Halwa</option><option value="557" >Bombil Bhaji</option><option value="556" >Boneless Pomfret</option><option value="376" >Boondi / panipuri boondi</option><option value="735" >Bottle Guard (doodhi)</option><option value="636" >Bread Bonda</option><option value="352" >Brinjal</option><option value="93" >Broccoli</option><option value="234" >Broke Wheat Upma</option><option value="351" >Broken wheat</option><option value="853" >Brown Rosogulla</option><option value="525" >Bun Puri</option><option value="132" >Butter</option><option value="436" >Butter Bhakarwadi</option><option value="431" >Butter Masala Murukku</option><option value="430" >Butter Murukku</option><option value="359" >Butter Papdi</option><option value="141" >Buttermilk</option><option value="104" >Cabbage</option><option value="26" >Cardamom (elaichi)</option><option value="94" >Carrot</option><option value="128" >Cashew nuts</option><option value="73" >Chaap Chola</option><option value="633" >Chaap Lajawab</option><option value="829" >Chakhao Kheer</option><option value="425" >Chakli</option><option value="237" >Chalimidi</option><option value="412" >Chana Dal</option><option value="723" >Chana Dal Poori</option><option value="523" >Chana Poha</option><option value="419" >Chanajor</option><option value="43" >Channa Dal</option><option value="627" >Chavli</option><option value="562" >Chavli usal</option><option value="712" >Chawal Ki Kheer</option><option value="624" >Chawli</option><option value="36" >Chawli/Lobia</option><option value="131" >Cheese</option><option value="253" >Chenna</option><option value="252" >Chenna Malpua</option><option value="95" >Cherry</option><option value="660" >Chettinad Chicken Curry</option><option value="852" >Chhangban Leh kurtai</option><option value="825" >Chhena Poda</option><option value="334" >Chicken</option><option value="554" >Chicken Biryani</option><option value="578" >Chicken Dopyaza</option><option value="634" >Chicken Gulabo Tikka</option><option value="307" >Chicken Kolhapuri</option><option value="187" >Chicken Kundapuri</option><option value="622" >Chicken Leg Masala</option><option value="306" >Chicken Patiyala</option><option value="631" >Chicken Raja Rani</option><option value="310" >Chicken Rashida</option><option value="579" >Chicken sagwala</option><option value="517" >Chicken Sukha</option><option value="566" >Chicken Thali</option><option value="632" >Chicken Tikka Masala</option><option value="164" >Chicken/Egg/Meat powder</option><option value="188" >Chiken Malvani Tava Fry</option><option value="269" >Chilkha Roti</option><option value="160" >Chillies</option><option value="801" >Chips Farsan</option><option value="654" >Chmeen Pollichathu</option><option value="337" >Chora Ma Khariya</option><option value="819" >Chorafali</option><option value="812" >Churma</option><option value="29" >Cinnamon (dalchini)</option><option value="169" >Cloves</option><option value="155" >Coconut</option><option value="348" >coconut ada</option><option value="176" >Coconut Milk</option><option value="45" >Colacasia Leaves/Arbi patta</option><option value="14" >Coriander leaf/Dhaniya Patta</option><option value="21" >Coriander powder</option><option value="16" >Coriander seed (akkha dhaniya)</option><option value="256" >Corn flour</option><option value="736" >Crab</option><option value="543" >Crab  Masala and Rice</option><option value="421" >Crazy Nuts</option><option value="423" >Crispy Samosa</option><option value="156" >Cumin seeds</option><option value="226" >Curd</option><option value="46" >Curry  Leaves /Kadi Patta</option><option value="487" >Daanger</option><option value="273" >Dahi Ambula Khata</option><option value="532" >Dakshin Idli</option><option value="287" >Dal Bati</option><option value="288" >Dal Bati Churma</option><option value="505" >Dal Bukhara</option><option value="285" >Dal dhokli</option><option value="745" >Dal Ka Paratha</option><option value="744" >Dal Ka Seera</option><option value="721" >Dal Kachori</option><option value="515" >Dal Kolhapuri</option><option value="594" >Dal Pakwan</option><option value="272" >Dal Peethi</option><option value="497" >Dalicha Pithla</option><option value="488" >Dalimbyachi usal</option><option value="697" >Dashmi roti</option><option value="98" >Date/Kajur</option><option value="80" >Degh waara chanwaran ain Bhee patata</option><option value="83" >Dhaas meyah</option><option value="66" >Dharan Ji Kadhi</option><option value="696" >Dhodkyacha bhaat</option><option value="264" >Dhuska</option><option value="407" >Diet Chakli</option><option value="406" >Diet Chiwda</option><option value="410" >Diet Kothimir Chiwda</option><option value="408" >Diet Masala Murukku</option><option value="409" >Diet Methi Murukku</option><option value="47" >Dill /Savaa Patta</option><option value="775" >Dink Ladoo</option><option value="755" >Dodol</option><option value="199" >Doi Potol</option><option value="544" >Dried Prawns Chutney</option><option value="326" >Drumstick</option><option value="48" >Drumstick Leaves*/Sohjna</option><option value="241" >Dry Coconut</option><option value="777" >Dry Fruit Kachori</option><option value="403" >Dry Fruit Mumbai Mix</option><option value="355" >Dry Fruits</option><option value="238" >Dry ginger powder</option><option value="109" >Dry mango</option><option value="232" >Dry red chillies</option><option value="401" >Dryfruit Kachori</option><option value="716" >Dum Aloo</option><option value="314" >Dum ki Chaap</option><option value="154" >Eggs</option><option value="731" >Fafda Chutney</option><option value="444" >Farali chiwda</option><option value="451" >farali misal</option><option value="168" >Farali Missal</option><option value="293" >Farali patis</option><option value="817" >Farsi Puri</option><option value="171" >Fennel (saunf)</option><option value="49" >Fenugreek  (Methi)</option><option value="243" >Fenugreek seeds</option><option value="99" >Fig</option><option value="772" >Fish</option><option value="330" >Fish Biryani</option><option value="623" >Fish Koliwada</option><option value="183" >Fish masala powder</option><option value="657" >Fish Molee</option><option value="567" >Fish Thali</option><option value="602" >Fish Tikka Tandoori</option><option value="191" >Fish/Prawns Koliwada</option><option value="190" >Fish/Prawns/crab Malvani tava fry</option><option value="143" >Flavoured dahi</option><option value="142" >Flavoured milk</option><option value="585" >Fowl Cutlet</option><option value="145" >Fresh cream</option><option value="218" >Fresh Jalapeno</option><option value="466" >Fryms</option><option value="818" >Fulvadi</option><option value="757" >Gajak</option><option value="599" >Galouti Kebab</option><option value="175" >Garam Masala</option><option value="9" >Garlic</option><option value="373" >Garlic  Sev</option><option value="437" >Garlic Bhakarawadi</option><option value="389" >Garlic Mix</option><option value="212" >Garlic Powder</option><option value="84" >Gathri  pickle</option><option value="739" >Gatte ki sabzi</option><option value="510" >Gavthi Chicken Fry</option><option value="610" >Gawthi Chicken</option><option value="499" >Ghaavne</option><option value="498" >Ghadichi poli</option><option value="137" >Ghee</option><option value="826" >Ghevar</option><option value="281" >Ghughra</option><option value="76" >Ghyarsi dodo- bhaji</option><option value="13" >Ginger</option><option value="322" >Ginger Garlic Paste</option><option value="765" >Girda</option><option value="868" >Goan Cuisine</option><option value="458" >Goba puri</option><option value="468" >Gol Gappa</option><option value="524" >Goli Bajji</option><option value="848" >Gond Ladoo</option><option value="323" >Gota Baigan Besara</option><option value="749" >Gram Sweet ( Doce)</option><option value="100" >Grape/Angoor</option><option value="101" >Green bean</option><option value="239" >Green Cardomom</option><option value="11" >Green Chilli</option><option value="763" >Green Pea ka Kheer</option><option value="267" >Green Peas</option><option value="102" >Guava/Peru</option><option value="803" >Gud Chana</option><option value="813" >Gunder Pak</option><option value="475" >Gurda Kapoora Masala</option><option value="799" >Halwa - Made Up Of Wheat</option><option value="859" >Halwa Pulimunchi Masala</option><option value="474" >Halwa Thali</option><option value="465" >Hara Bhara  Namkeen</option><option value="676" >Holige</option><option value="42" >Horsegram</option><option value="215" >Hot Sauce</option><option value="392" >Hot Shot</option><option value="878" >Hyderabadi Cusine</option><option value="144" >Ice cream</option><option value="646" >Idiyappam</option><option value="824" >Ilayappam</option><option value="220" >Ilish (Hilsa)</option><option value="200" >Ilish Barishali</option><option value="219" >Ilish Macher Pulao</option><option value="717" >Imarti</option><option value="864" >Indian Cuisine</option><option value="57" >Jaggery</option><option value="570" >Jaifal pedhe</option><option value="743" >Jaipuri Mewa Pulao</option><option value="707" >Jawas Chutney</option><option value="18" >Jeera</option><option value="22" >Jeera powder</option><option value="835" >Jeera Puri</option><option value="159" >Jeerakam</option><option value="289" >Jodhpuri gatte</option><option value="56" >Jolada Roti</option><option value="418" >Kabuli Chana</option><option value="35" >Kabuli Channa/Chickpea</option><option value="149" >Kachri</option><option value="741" >Kachri Ki Chutney</option><option value="607" >Kadhi Mutton Soup</option><option value="689" >Kadi Idli</option><option value="786" >Kahjuri</option><option value="642" >Kai-Murukku</option><option value="698" >Kairichi Amti</option><option value="699" >Kairichi Dal(Raw Mango Dal)</option><option value="530" >Kakdi Pollo</option><option value="650" >Kakka</option><option value="34" >Kala Channa</option><option value="473" >Kaleji Gravy</option><option value="714" >Kali Masoor Dal</option><option value="588" >Kalwa Koshimbir</option><option value="590" >Kalwa Masala Fry</option><option value="302" >Kalwa salad</option><option value="489" >Kalya Vatanyacha sambar</option><option value="179" >Kanda Vada</option><option value="399" >Kande Poha (onion chiwda)</option><option value="573" >Kandi Pedhe</option><option value="659" >Kappa Phuzukku</option><option value="378" >Kara Boondi</option><option value="793" >Karanchi Jilebi</option><option value="649" >Karimeen Pollichathu</option><option value="648" >Karimeen Varuthathu</option><option value="502" >Karvanda Sharbat</option><option value="866" >Kashmiri Cuisine</option><option value="192" >Kashmiri Pulao</option><option value="769" >Kashmiri Saag</option><option value="601" >Kasundi Fish Tikka</option><option value="884" >Katachi Amti</option><option value="645" >Katti Pathiri</option><option value="838" >Kela Papdi</option><option value="705" >Kela Sheera</option><option value="637" >Kele Bajji</option><option value="540" >Kele Phodi</option><option value="486" >Kelyache Koshimbir</option><option value="748" >Ker Sangri Ki Sabzi</option><option value="863" >Kerala Cuisine</option><option value="161" >Kerala Egg Roast</option><option value="822" >Khaja</option><option value="816" >Khajali</option><option value="761" >Khajur Imli Ki Chutney</option><option value="849" >Khapse</option><option value="414" >Khara Sing</option><option value="521" >Kharvas</option><option value="724" >Khasta Mathura Aloo</option><option value="574" >Khasta Roti</option><option value="471" >Khekda Thali</option><option value="282" >Khichdi kadi</option><option value="292" >Khichia churi</option><option value="767" >Khubani Ka Meetha</option><option value="105" >Kiwi Fruit</option><option value="832" >Koat Pitha</option><option value="681" >Kobi Vada</option><option value="71" >Koki and papad</option><option value="308" >Kokum curry</option><option value="479" >Kolache Pohe</option><option value="575" >Kolambi bhaat</option><option value="591" >Kolambi Koshimbir</option><option value="592" >Kolambi Masala Fry</option><option value="516" >Kolhapuri Misal</option><option value="172" >Kolhapuri MIssal</option><option value="494" >Kolhapuri Tambda Rassa</option><option value="558" >Kolshyavarche</option><option value="581" >Kombadi Masala</option><option value="563" >Kombadi Vade</option><option value="871" >Konkani Cuisine</option><option value="576" >Kori Gassi</option><option value="518" >Kori Roti</option><option value="753" >Kormolas</option><option value="61" >Kosambari</option><option value="629" >Kothimbir  Mutton</option><option value="481" >Kothimbir vadi</option><option value="661" >Kozhi Varttiyathu</option><option value="734" >Kuler Ladoo</option><option value="750" >KulKul</option><option value="628" >Kundapura Chicken</option><option value="820" >Lakadiya</option><option value="44" >Lal Bhaji/Amarnath Leaves</option><option value="491" >Lal Math Bhaji</option><option value="338" >Lamb</option><option value="727" >Lapsi</option><option value="733" >Lasan Kadhi</option><option value="140" >Lassi</option><option value="760" >Lauki Kebab</option><option value="106" >Leek/Green onion</option><option value="103" >Lemon</option><option value="460" >Lemon Bhel</option><option value="415" >Lemon Chanadal</option><option value="50" >Lemon Grass/Gavati</option><option value="185" >Lemon juice</option><option value="840" >Lemon Miri Sev</option><option value="51" >Lettuce/Salad Patta</option><option value="390" >Lite Chanajor Mix</option><option value="768" >Lobia Ke Kebab</option><option value="507" >Loni Pollo</option><option value="720" >Lucknowi Dal</option><option value="598" >Lucknowi Seekh</option><option value="472" >Macchi Fry</option><option value="470" >Macchi Thali</option><option value="604" >Macchi Tikka Masala</option><option value="341" >Mace</option><option value="196" >Macher Chop</option><option value="542" >Mackerel Fry</option><option value="79" >Macroli Phoolpatasha</option><option value="342" >Madras curry</option><option value="680" >Madras Misal</option><option value="379" >Madrasi Mix</option><option value="784" >Magaj Ladoo</option><option value="396" >Mahalaxmi Chiwda</option><option value="869" >Maharashtrian Cuisine</option><option value="703" >Maharashtrian Kadhi</option><option value="776" >Mahim Halwa</option><option value="887" >Maize (Corn)</option><option value="568" >Maka Pattice</option><option value="814" >Makhaniya</option><option value="395" >Makka (Cornflakes) Chiwda</option><option value="477" >Makke Ki Roti and Sarson Ka Saag</option><option value="795" >Malai Mysore</option><option value="400" >Malamaal Chiwda</option><option value="789" >Malido</option><option value="718" >Malpua</option><option value="67" >Malpura</option><option value="246" >MAMIDIKAYA MENTHI PACHADI, INSTANT MANGO PICKLE RECIPE</option><option value="230" >MAMIDIKAYA PESARAPAPPU PACHADI, RAW MANGO MOONG DAL CHUTNEY</option><option value="304" >Mandeli fry</option><option value="63" >Mangalore Buns</option><option value="383" >Mangalori Mix</option><option value="108" >Mango</option><option value="277" >Mango Ginger</option><option value="362" >Mari (vanela) Gathiya</option><option value="441" >Mari banana chips</option><option value="417" >Mari Chana</option><option value="361" >Mari Fafda</option><option value="372" >Marwadi Sev</option><option value="811" >Marwari Ladoo</option><option value="443" >masala banana chips</option><option value="664" >Masala Bhaat</option><option value="377" >Masala Boondi</option><option value="360" >Masala Butter Papdi</option><option value="450" >masala sabudana khichdi</option><option value="446" >Masala salli</option><option value="371" >Masala Sev</option><option value="416" >Masala Sing</option><option value="559" >Masaledar Kale</option><option value="38" >Masoor dal</option><option value="453" >mathri puri</option><option value="719" >Mathura Peda</option><option value="420" >Mattar Jor</option><option value="139" >Mawa</option><option value="828" >Mawa bati</option><option value="787" >Mawa Boi</option><option value="738" >Mawa Kachori</option><option value="790" >Mawa Khaja</option><option value="788" >Mawa Pan Cake</option><option value="197" >Maxi Thala</option><option value="656" >Meen Manga Curry</option><option value="658" >Meen Thangapal Curry</option><option value="110" >Melon</option><option value="263" >Melon seeds</option><option value="805" >Mesub</option><option value="455" >Methi bajra puri</option><option value="438" >Methi Bhakarwadi</option><option value="771" >Methi Chaman</option><option value="368" >Methi Gathiya</option><option value="888" >Methi Ladu</option><option value="836" >Methi puri</option><option value="25" >Methi seed</option><option value="279" >methingota</option><option value="881" >Middle Eastern Cuisine</option><option value="130" >Milk</option><option value="146" >Milk powder</option><option value="265" >Minced Cilantro</option><option value="433" >Mini Bhakarwadi</option><option value="509" >Mini Dosa Platter</option><option value="839" >Mini Petha</option><option value="422" >Mini Samosa</option><option value="321" >Mint leaves</option><option value="221" >Mishti Doi</option><option value="195" >Missal Pav</option><option value="550" >Missi Roti</option><option value="85" >Mitho lolo</option><option value="393" >Mix Farsan</option><option value="800" >Mix Mithai</option><option value="198" >Mochar Ghonto</option><option value="780" >Mohanthal</option><option value="461" >Moong Bhel</option><option value="695" >Moong dahi misal</option><option value="33" >Moong dal</option><option value="746" >Moong Dal Ka Halwa</option><option value="203" >Moong Dhosa</option><option value="204" >Moong Onion Dhosa</option><option value="411" >Moongdal</option><option value="305" >Mori masala fry</option><option value="711" >Moti Pulav</option><option value="260" >Motichoor Ke Ladoo</option><option value="867" >Mughlai Cuisine</option><option value="381" >Mumbai Mix</option><option value="333" >Murg E Kalmi</option><option value="349" >murg-e-kalmi</option><option value="429" >Murukku</option><option value="111" >Mushroom</option><option value="539" >Mushti pollo with puddi chutney</option><option value="54" >Mustard Leaves</option><option value="245" >Mustard powder</option><option value="214" >Mustard Sauce</option><option value="17" >Mustard Seed (Rai)</option><option value="228" >Mustard seeds</option><option value="280" >Muthiya</option><option value="663" >Mutta Chikkiyathu</option><option value="356" >Mutton</option><option value="553" >Mutton Biryani</option><option value="545" >Mutton Brain Masala</option><option value="630" >Mutton Dahiwala</option><option value="583" >Mutton Dopyaza</option><option value="773" >Mutton Gurda kapoora</option><option value="511" >Mutton Gurda Masala</option><option value="514" >Mutton Hyderabadi</option><option value="300" >Mutton kaleji thali</option><option value="513" >Mutton Kheema Masala</option><option value="512" >Mutton Liver Masala</option><option value="189" >Mutton Malvani Tava Fry</option><option value="309" >Mutton mughlai</option><option value="584" >Mutton Sagwala</option><option value="779" >Mysore Pak</option><option value="464" >Nachni (RAGI) Sticks</option><option value="572" >Nachni Ladu</option><option value="385" >Nadiyadi Bhusa</option><option value="364" >Nailon Bhavanagri</option><option value="370" >Nailon Sev</option><option value="367" >Nailon Surti</option><option value="837" >Nam Puri</option><option value="428" >Namkeen Papad Churi</option><option value="427" >Namkeen Shakarpara</option><option value="702" >Narali Bhaat</option><option value="503" >Nargisi Kofta</option><option value="851" >Nariko ladoo</option><option value="778" >Navratna Dalmoth</option><option value="388" >Navratna Mix</option><option value="677" >Neer Dosa And Chicken Sukha</option><option value="519" >Neer Dosa with Chutney</option><option value="651" >Netholi Fish Curry</option><option value="655" >Ney Meen Curry</option><option value="691" >Neyappam</option><option value="311" >Neza kebab</option><option value="258" >Nigella seeds</option><option value="391" >Noodles Mix</option><option value="865" >North Indian Cuisine</option><option value="113" >Nut</option><option value="28" >Nutmeg</option><option value="254" >Nutmug</option><option value="527" >Nyappam</option><option value="536" >Oats Doddak</option><option value="165" >Oil</option><option value="114" >Olive</option><option value="5" >Onion</option><option value="223" >Onion paste</option><option value="8" >Onion Uttapam</option><option value="96" >Orange</option><option value="262" >Orange food color</option><option value="810" >Pakhija</option><option value="882" >Pakoda</option><option value="688" >Pakoda Lasuni Curry with Rice</option><option value="747" >Pakode Wali Kadhi</option><option value="286" >Palak dosa</option><option value="834" >Palak Puri</option><option value="52" >Palak/Spinach</option><option value="153" >Pan Cakes</option><option value="802" >Pan Mathri</option><option value="506" >Pan Pollo</option><option value="617" >Pandhara Rassa</option><option value="133" >Paneer</option><option value="194" >Paneer  Peshwari Tikka</option><option value="193" >Paneer Dobara</option><option value="842" >Paneer Jalebi</option><option value="529" >PanPoli</option><option value="462" >Papad Bhel</option><option value="730" >Papayo no sambharo</option><option value="358" >Papdi</option><option value="857" >Paplet Pulimunchi Masala</option><option value="213" >Paprica Powder</option><option value="217" >Parmesan cheese</option><option value="880" >Parsi Cuisine</option><option value="343" >Parsi Dhana</option><option value="331" >PARSI FISH WITH GREEN CHUTNEY, PATRA NI MACHHI</option><option value="564" >Parval</option><option value="315" >Patato</option><option value="495" >Patodi Rassa</option><option value="647" >Patorda</option><option value="15" >Patta Gobi</option><option value="478" >Paya Masala</option><option value="685" >Paysam</option><option value="115" >Pea/mutter</option><option value="112" >Peach</option><option value="116" >Peanut/Mungfhali</option><option value="117" >Pear</option><option value="184" >Pepper powder</option><option value="752" >Perad</option><option value="538" >Phanna Pollo</option><option value="850" >Phuklein</option><option value="206" >PHULKO LUCHI</option><option value="496" >Phunke Kadhi</option><option value="754" >Pinaca</option><option value="296" >Pindi chole</option><option value="119" >Pineapple</option><option value="346" >Pink coloured ravo</option><option value="758" >Pinni</option><option value="129" >Pistachios</option><option value="678" >Piyush</option><option value="580" >Plate Dosa</option><option value="582" >Plate Roti</option><option value="329" >POACHED EGG</option><option value="177" >Poha Samosa</option><option value="68" >Pohp batalu jo pulao</option><option value="332" >Pomfret</option><option value="690" >Pongal</option><option value="386" >Pooneri Missal Mix</option><option value="10" >Potato</option><option value="354" >Potol/Parwal</option><option value="236" >Powdered sugar</option><option value="316" >Prawn Patato Curry (Chungudi Aloo Tarakari)</option><option value="180" >Prawn Tomato Stir Fry (CHEMMEEN THAKKALI VARATTIYATHU)</option><option value="181" >Prawns</option><option value="616" >Prawns Biryani</option><option value="301" >Prawns salad</option><option value="706" >Pudachi Vadi</option><option value="531" >Puddi Idli</option><option value="53" >Pudhina /Mint leaves</option><option value="299" >Pudina paratha</option><option value="120" >Pumpkin</option><option value="325" >Punch Phutana</option><option value="274" >Punch Puran</option><option value="434" >Pune Bhakarwadi</option><option value="870" >Punjabi Cuisine</option><option value="549" >Punjabi Kofte</option><option value="665" >PuranPoli</option><option value="520" >Puri Bhaji</option><option value="679" >Puri Kurma</option><option value="150" >Puttu</option><option value="613" >Pyaaz Kachori</option><option value="257" >Pyaaz ki Kachori</option><option value="298" >Pyaazmirkchi roti</option><option value="821" >Qubani Ka Meetha</option><option value="312" >Raan sikandari</option><option value="121" >Radish</option><option value="126" >Raisins</option><option value="291" >Rajasthan dal</option><option value="876" >Rajasthani Cuisine</option><option value="740" >Rajasthani Doodhiya Kheech</option><option value="615" >Rajasthani Kabuli Biryani</option><option value="251" >Rajasthani Kanji Vada</option><option value="614" >Rajasthani Mirchi Bada</option><option value="561" >Rajasthani Thali</option><option value="796" >Rajbhog Shrikhand</option><option value="37" >Rajma (kidney beans)</option><option value="476" >Rajma Chawal</option><option value="710" >Rajma Tikki</option><option value="533" >Rasam Ambode</option><option value="639" >Rasam Wada</option><option value="501" >Ratalayache Kees</option><option value="693" >Ratalyacha kees</option><option value="374" >Ratlami Sev</option><option value="889" >Rava Ladu</option><option value="347" >Ravo</option><option value="344" >RAVO (FROM COOKBOOK)</option><option value="107" >Raw banana</option><option value="231" >Raw Mango</option><option value="7" >Rawa</option><option value="20" >Red chilli powder (lal mirch)</option><option value="340" >Red Kashmir Chillies</option><option value="211" >Red onion</option><option value="335" >refined flour</option><option value="675" >Refined wheat flour</option><option value="641" >Ribbon Pakoda</option><option value="222" >Rice</option><option value="152" >Rice Flour</option><option value="729" >Rice Flour Khichu</option><option value="151" >Rice Powder</option><option value="682" >Rice Vada</option><option value="397" >Roasted Nailon Chiwda</option><option value="770" >Roath</option><option value="313" >Rogan gosht</option><option value="823" >Rosogulla</option><option value="635" >S.K Pakoda</option><option value="449" >Sabudana</option><option value="447" >sabudana chiwda</option><option value="448" >sabudana khichdi</option><option value="492" >Sabudana Vada</option><option value="369" >Sada Sev (Mora)</option><option value="831" >Sael Roti</option><option value="148" >Saffron ( kesar)</option><option value="255" >Saffron (Starnds)</option><option value="69" >Sai bhaaji</option><option value="841" >Sai Bhaji and rice</option><option value="809" >Salam Pak (sukahdi)</option><option value="157" >Salt</option><option value="445" >Salted salli</option><option value="546" >Samosa Chole</option><option value="644" >Sanna Polo/ Pathrode Dosa</option><option value="270" >Sattu Ki Kachori</option><option value="210" >Sausage</option><option value="608" >Seafood Kulith Soup</option><option value="81" >Seero</option><option value="672" >Sesame Seeds</option><option value="202" >Set Dosa</option><option value="815" >Sev</option><option value="457" >Sev puri</option><option value="638" >Sevai Lemon / Coconut / Plain</option><option value="605" >Seven Taste Uttapam</option><option value="70" >Seyal Murg</option><option value="625" >Seyal Pav</option><option value="72" >Seyun patata</option><option value="404" >Shahi Dalmooth</option><option value="759" >Shakarkandi Chat</option><option value="426" >Shakkarpara</option><option value="589" >Shell Fish Masala Fry</option><option value="704" >Shengdanyacha Thecha</option><option value="490" >Shev Bhaji</option><option value="398" >Shev Chiwda</option><option value="135" >Shrikhand</option><option value="827" >Shufta</option><option value="442" >Silky mari banana chips</option><option value="440" >Silky yellow banana chips</option><option value="667" >Sindhi Chawli</option><option value="873" >Sindhi Cuisine</option><option value="74" >Sindhi Curry and Rice</option><option value="596" >Sindhi Koki</option><option value="413" >Singbhaji</option><option value="209" >SKINNY (BAKED) JALAPENO POPPERS WITH SPICY SAUSAGE MIX</option><option value="855" >Snack Box - Karnataka</option><option value="854" >Snack Box - Maharashtra</option><option value="782" >Snack Box - Multi States</option><option value="560" >Solkadhi</option><option value="861" >Sonte - A Healthy Sweet Potato Snack</option><option value="726" >Soya Dum Biryani</option><option value="138" >Soya milk</option><option value="318" >Soyabean</option><option value="317" >Soyabean Fried Rice</option><option value="798" >Special Aflatoon</option><option value="290" >Special Khobewali Roti</option><option value="845" >Speciality From Eight States</option><option value="843" >Speciality From Four States</option><option value="844" >Speciality From Various States</option><option value="394" >Spicy Mix</option><option value="886" >Spl. Bhajni Chakli</option><option value="424" >Spring Rolls</option><option value="170" >Star Anise</option><option value="122" >Strawberry</option><option value="555" >Stuff Pompret with prawns filling</option><option value="806" >Stuffed Gulab Jamun</option><option value="158" >Sugar</option><option value="459" >Sukha Bhel</option><option value="751" >Sukrunde</option><option value="807" >Surajmukhi</option><option value="534" >suran</option><option value="725" >Suran Chutney</option><option value="541" >Suran Fries</option><option value="528" >Surian</option><option value="858" >Surmai Pulimunchi Masala</option><option value="366" >Surti Gathiya</option><option value="792" >Surti Peda</option><option value="123" >Sweet potato</option><option value="674" >Tamarind</option><option value="666" >Tambda Rassa</option><option value="875" >Tamil Cuisine</option><option value="463" >Tangy Tamato Stick</option><option value="766" >Tao Gugji</option><option value="603" >Tariwala Jhinga</option><option value="77" >Tayri-vangan patata</option><option value="456" >Tea time puri</option><option value="535" >Teen Dalli Pollo</option><option value="713" >Tehri ( Vegetable pulav)</option><option value="673" >test 2</option><option value="58" >Thaliipeet</option><option value="493" >Thalipeeth</option><option value="294" >Thalipith</option><option value="653" >Thenga Aracha Meen Curry</option><option value="833" >Thepla</option><option value="75" >Tidali dal-Dodo</option><option value="365" >Tikha Gathiya</option><option value="384" >Tikha Kolhapuri Mix</option><option value="547" >Tikki Chole</option><option value="303" >Tikle gravy (fish)</option><option value="30" >Til seeed</option><option value="619" >Tisrya Kolambi Mix</option><option value="618" >Tisrya Masala</option><option value="134" >Tofu</option><option value="6" >Tomato</option><option value="182" >Tomato Ketchup</option><option value="41" >Toor /Arhar dal</option><option value="783" >TOS  Snack Box ( Premium)</option><option value="669" >TOS Gujarati Platter</option><option value="670" >TOS Maharashtrian  Platter</option><option value="781" >TOS Snack Box (Mini)</option><option value="774" >TOS Snack Sampler</option><option value="874" >Traditional CKP</option><option value="467" >Try-Angles</option><option value="65" >Tuk</option><option value="500" >Tup Methkut Bhaat</option><option value="327" >Turmeric</option><option value="163" >Turmeric  Powder</option><option value="19" >Turmeric powder (haldi)</option><option value="606" >Twin Dosa</option><option value="808" >Udad Ladoo</option><option value="382" >Udipi Mix</option><option value="694" >Ukad/Thakachi Ukad</option><option value="526" >Ulundhu Dosa</option><option value="205" >Ulundu Dhosa</option><option value="278" >undhiya</option><option value="686" >Undiya Kathiawadi</option><option value="522" >Upma Chana</option><option value="671" >Upvas Ka Platter</option><option value="452" >upwas sev</option><option value="40" >Urad dal</option><option value="877" >Uttar Pradesh Cuisine</option><option value="240" >VADAPAPPU PANAKAM</option><option value="249" >Vadas</option><option value="709" >Val Usal</option><option value="485" >Vangyache Bharit</option><option value="345" >vanialla or rose essence</option><option value="708" >Varanfal</option><option value="856" >Variety of  Snacks to tingle your Taste buds</option><option value="662" >Varutharacha Kozhi Curry</option><option value="652" >Varutharacha Meen Curry</option><option value="78" >Varyun wara chanwaran</option><option value="684" >Vatana Bonda</option><option value="683" >Vatana Pattice</option><option value="284" >veg handi</option><option value="565" >Veg Thali</option><option value="643" >Veg. Bonda</option><option value="548" >Veg. Patiala</option><option value="504" >Veg. Seekh Kabab</option><option value="186" >Vegetable / Paneer Malvani tava fry</option><option value="166" >Vegetable stew</option><option value="756" >Vegetable Vindaloo</option><option value="167" >Vegetables</option><option value="353" >Vermicelli</option><option value="587" >Walacha Birda</option><option value="620" >Walache Birde</option><option value="127" >Walnut</option><option value="124" >Watermelon</option><option value="271" >Wheat Flour</option><option value="860" >wheat halwa</option><option value="225" >Wheat Rava</option><option value="224" >Wheat Rava Idli</option><option value="328" >White Vinegar</option><option value="32" >Whole Moong</option><option value="125" >Yam/Suran</option><option value="439" >Yellow banana chips</option><option value="248" >Yellow Moong Dal</option><option value="136" >Yoghurt/Curd/dahi</option><option value="276" >Yogurt</option><option value="97" >Zucchini</option><option value="701" >Zunka</option><option value="569" >Zunka Bhakar</option>'+
									'</select>'+
								'</div>';
														
			new_row +=		'</div>'+	
							'<div class="form-group">';
							
										new_row +=			'<label class="col-lg-2 control-label">Menu Image/Pdf</label>'+
								'<div class="col-lg-4">'+
									'<input type="file" name="vloc_menu_file[]" id="vloc_menu_file_'+cat_cnt+'" class="form-control">'+
								'</div>';
								
							
								
			new_row +=			'<label class="col-lg-2 control-label">Vendor Estt Pdf</label>'+
								'<div class="col-lg-4">'+
									'<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_'+cat_cnt+'" class="form-control">'+
								'</div>';
								
							
			new_row +=		'</div>'+
							
							'<div class="form-group left-label">'+
								'<label class="col-lg-6 control-label"><strong>Licences, Registration, Certification & Memberships:</strong></label>'+
							'</div>'+
							'<div id="row_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
								'<input type="hidden" name="vc_cert_id_'+i_val+'[]" id="vc_cert_id_'+i_val+'_'+cert_cnt+'" value="0">'+
								'<input type="hidden" name="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" id="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" value="">'+
								'<div class="form-group small-title">';
									
												new_row +=			'<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>'+
									'<div class="col-lg-5">'+
										'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control" required22>'+
											'<option value="" >Select Type</option><option value="74" >Certification</option><option value="72" >Licence</option><option value="75" >Membership</option><option value="73" >Registration</option>'+
										'</select>'+
									'</div>';
																
								
												new_row +=			'<label class="col-lg-1 control-label">Name</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+
									'</div>';
									
				
				new_row +=		'</div>'+	
								'<div class="form-group small-title">';
								
												new_row +=			'<label class="col-lg-1 control-label">Number</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+
									'</div>';
									
								
												new_row +=			'<label class="col-lg-1 control-label">Issued By</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+
									'</div>';
																
				new_row +=		'</div>'+	
								'<div class="form-group small-title">';
								
												new_row +=			'<label class="col-lg-1 control-label">Issued Date</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+
									'</div>';
												
									
												new_row +=			'<label class="col-lg-1 control-label">Vaidity Date</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+
									'</div>';
																
				new_row +=		'</div>'+
								'<div class="form-group small-title">';
								
												new_row +=			'<label class="col-lg-1 control-label">Scan Image</label>'+
									'<div class="col-lg-5">'+
										'<input type="file" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'_'+cert_cnt+'" class="form-control" >'+
									'</div>';
																
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