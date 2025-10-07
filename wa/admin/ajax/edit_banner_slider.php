<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$edit_action_id = '49';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[EDIT_BANNER_SLIDER] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>, FILES:<pre>'.print_r($_FILES,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$banner_id = trim($_POST['hdnbanner_id']);
	$banner_title = strip_tags(trim($_POST['banner_title']));
	$banner_title_font_family = strip_tags(trim($_POST['banner_title_font_family']));
	$banner_title_font_size = strip_tags(trim($_POST['banner_title_font_size']));
	$banner_title_font_color = strip_tags(trim($_POST['banner_title_font_color']));
	$banner_text_line1 = strip_tags(trim($_POST['banner_text_line1']));
	$banner_text_line1_font_family = strip_tags(trim($_POST['banner_text_line1_font_family']));
	$banner_text_line1_font_size = strip_tags(trim($_POST['banner_text_line1_font_size']));
	$banner_text_line1_font_color = strip_tags(trim($_POST['banner_text_line1_font_color']));
	$banner_text_line2 = strip_tags(trim($_POST['banner_text_line2']));
	$banner_text_line2_font_family = strip_tags(trim($_POST['banner_text_line2_font_family']));
	$banner_text_line2_font_size = strip_tags(trim($_POST['banner_text_line2_font_size']));
	$banner_text_line2_font_color = strip_tags(trim($_POST['banner_text_line2_font_color']));
	$banner_order = strip_tags(trim($_POST['banner_order']));
	$banner_status = strip_tags(trim($_POST['banner_status']));
	$hdnbanner_image = strip_tags(trim($_POST['hdnbanner_image']));
	
	$country_id_str = strip_tags(trim($_POST['country_id_str']));
	$state_id_str = strip_tags(trim($_POST['state_id_str']));
	$city_id_str = strip_tags(trim($_POST['city_id_str']));
	$area_id_str = strip_tags(trim($_POST['area_id_str']));
	$publish_date_type = strip_tags(trim($_POST['publish_date_type']));
	$publish_days_of_month_str = strip_tags(trim($_POST['publish_days_of_month_str']));
	$publish_days_of_week_str = strip_tags(trim($_POST['publish_days_of_week_str']));
	$publish_single_date = strip_tags(trim($_POST['publish_single_date']));
	$publish_start_date = strip_tags(trim($_POST['publish_start_date']));
	$publish_end_date = strip_tags(trim($_POST['publish_end_date']));
	
	if($banner_title == '')
	{
		$error = true;
		$err_msg = 'Please enter banner title';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($country_id_str == '' || $country_id_str == 'null')
	{
		$error = true;
		$err_msg = 'Please select country';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($state_id_str == '' || $state_id_str == 'null')
	{
		$error = true;
		$err_msg = 'Please select state';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($city_id_str == '' || $city_id_str == 'null')
	{
		$error = true;
		$err_msg = 'Please select city';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($area_id_str == '' || $area_id_str == 'null')
	{
		$error = true;
		$err_msg = 'Please select area';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
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
	
	
	$banner_image = '';
	if(!$error)
	{
		$picture_size_limit = 5120;
		$error = false;
		$err_msg = '';

		// Define a destination
		$targetFolder = SITE_PATH . '/uploads'; // Relative to the root

		if (!empty($_FILES) && (isset($_FILES['banner_image']['name'])) && ($_FILES['banner_image']['name'] != '') )
		{
			$tempFile = $_FILES['banner_image']['tmp_name'];

			$filename = date('dmYHis') . '_' . $_FILES['banner_image']['name'];
			$filename = str_replace(' ', '-', $filename);

			$targetPath = $targetFolder;
			$targetFile = rtrim($targetPath, '/') . '/' . $filename;
			$mimetype = $_FILES['banner_image']['type'];

			// Validate the file type
			$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG'); // File extensions
			$fileParts = pathinfo($_FILES['banner_image']['name']);

			if (in_array($fileParts['extension'], $fileTypes))
			{
				$banner_image = $_FILES['banner_image']['name'];
				$size_in_kb = $_FILES['banner_image']['size'] / 1024;
				$file4 = substr($banner_image, -4, 4);
				if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG'))
				{
					$error = true;
					$err_msg = 'Please upload only(jpg/gif/jpeg/png) image ';
					$banner_image = $hdnbanner_image;
				}
				elseif ($size_in_kb > $picture_size_limit)
				{
					$error = true;
					$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb.';
					$banner_image = $hdnbanner_image;
				}

				if (!$error)
				{
					$banner_image = $filename;

					if (!move_uploaded_file($tempFile, $targetFile))
					{
						if (file_exists($targetFile))
						{
							unlink($targetFile);
						} // Remove temp file
						$error = true;
						$err_msg = 'Couldn\'t upload image';
						$banner_image = $hdnbanner_image;
					}
				}
			}
			else
			{
				$error = true;
				$err_msg = 'Invalid file type';
				$banner_image = $hdnbanner_image;
			}
		}	
		else
		{
			$banner_image = $hdnbanner_image;
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
		if($country_id_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_country_id = explode(',',$country_id_str);
			if(in_array('-1', $arr_temp_country_id))
			{
				$country_id_str = '-1';	
			}	
		}
		
		if($state_id_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_state_id = explode(',',$state_id_str);
			if(in_array('-1', $arr_temp_state_id))
			{
				$state_id_str = '-1';	
			}	
		}
		
		if($city_id_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_city_id = explode(',',$city_id_str);
			if(in_array('-1', $arr_temp_city_id))
			{
				$city_id_str = '-1';	
			}	
		}
		
		if($area_id_str == '-1')
		{
			
		}
		else
		{
			$arr_temp_area_id = explode(',',$area_id_str);
			if(in_array('-1', $arr_temp_area_id))
			{
				$area_id_str = '-1';	
			}	
		}
		
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
		$tdata['banner_id'] = $banner_id;
		$tdata['banner_title'] = $banner_title;
		$tdata['banner_title_font_family'] = $banner_title_font_family;
		$tdata['banner_title_font_size'] = $banner_title_font_size;
		$tdata['banner_title_font_color'] = $banner_title_font_color;
		$tdata['banner_text_line1'] = $banner_text_line1;
		$tdata['banner_text_line1_font_family'] = $banner_text_line1_font_family;
		$tdata['banner_text_line1_font_size'] = $banner_text_line1_font_size;
		$tdata['banner_text_line1_font_color'] = $banner_text_line1_font_color;
		$tdata['banner_text_line2'] = $banner_text_line2;
		$tdata['banner_text_line2_font_family'] = $banner_text_line2_font_family;
		$tdata['banner_text_line2_font_size'] = $banner_text_line2_font_size;
		$tdata['banner_text_line2_font_color'] = $banner_text_line2_font_color;
		$tdata['banner_image'] = $banner_image;
		$tdata['banner_order'] = $banner_order;
		$tdata['banner_country_id'] = $country_id_str;
		$tdata['banner_state_id'] = $state_id_str;
		$tdata['banner_city_id'] = $city_id_str;
		$tdata['banner_area_id'] = $area_id_str;
		$tdata['banner_publish_date_type'] = $publish_date_type;
		$tdata['banner_publish_days_of_month'] = $publish_days_of_month_str;
		$tdata['banner_publish_days_of_week'] = $publish_days_of_week_str;
		$tdata['banner_publish_single_date'] = $publish_single_date;
		$tdata['banner_publish_start_date'] = $publish_start_date;
		$tdata['banner_publish_end_date'] = $publish_end_date;
		$tdata['banner_status'] = $banner_status;
		$tdata['modified_by_admin'] = $admin_id;
		if($obj->updateBannerSlider($tdata))
		{
			$msg = 'Record Added Successfully!';
			$ref_url = "manage_banner_sliders.php?msg=".urlencode($msg);
						
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
  