<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$edit_action_id = '11';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[EDIT_MAIN_CATEGORY] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>, FILES:<pre>'.print_r($_FILES,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$cat_name = strip_tags(trim($_POST['cat_name']));
	$cat_id = $_POST['cat_id'];
	$parent_cat_id = $_POST['parent_cat_id'];
	$cat_status = $_POST['cat_status'];
	$hdncat_image = strip_tags(trim($_POST['hdncat_image']));
	
	if($cat_name == '')
	{
		$error = true;
		$err_msg = 'Please enter category name';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	elseif($obj->chkCategoryExistsById($cat_name,$cat_id))
	{
		$error = true;
		$err_msg = 'This category already exists';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}

	$cat_image = '';
	if(!$error)
	{
		$picture_size_limit = 5120;
		$error = false;
		$err_msg = '';

		// Define a destination
		$targetFolder = SITE_PATH . '/uploads'; // Relative to the root

		if (!empty($_FILES) && (isset($_FILES['cat_image']['name'])) && ($_FILES['cat_image']['name'] != '') )
		{
			$tempFile = $_FILES['cat_image']['tmp_name'];

			$filename = date('dmYHis') . '_' . $_FILES['cat_image']['name'];
			$filename = str_replace(' ', '-', $filename);

			$targetPath = $targetFolder;
			$targetFile = rtrim($targetPath, '/') . '/' . $filename;
			$mimetype = $_FILES['cat_image']['type'];

			// Validate the file type
			$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG'); // File extensions
			$fileParts = pathinfo($_FILES['cat_image']['name']);

			if (in_array($fileParts['extension'], $fileTypes))
			{
				$cat_image = $_FILES['cat_image']['name'];
				$size_in_kb = $_FILES['cat_image']['size'] / 1024;
				$file4 = substr($cat_image, -4, 4);
				if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG'))
				{
					$error = true;
					$err_msg = 'Please upload only(jpg/gif/jpeg/png) image ';
					$cat_image = $hdncat_image;
				}
				elseif ($size_in_kb > $picture_size_limit)
				{
					$error = true;
					$err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb.';
					$cat_image = $hdncat_image;
				}

				if (!$error)
				{
					$cat_image = $filename;

					if (!move_uploaded_file($tempFile, $targetFile))
					{
						if (file_exists($targetFile))
						{
							unlink($targetFile);
						} // Remove temp file
						$error = true;
						$err_msg = 'Couldn\'t upload image';
						$cat_image = $hdncat_image;
					}
				}
			}
			else
			{
				$error = true;
				$err_msg = 'Invalid file type';
				$cat_image = $hdncat_image;
			}
		}	
		else
		{
			$cat_image = $hdncat_image;
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
		$tdata = array();
		$tdata['cat_name'] = $cat_name;
		$tdata['cat_image'] = $cat_image;
		$tdata['cat_id'] = $cat_id;
		$tdata['admin_id'] = $admin_id;
		$tdata['parent_cat_id'] = $parent_cat_id;
		$tdata['cat_status'] = $cat_status;
		$tdata['modify_date'] = date("Y-m-d H:i:s");
		
		if($obj->editMainCategory($tdata))
		{
			$msg = 'Record updated successfully!';
			$ref_url = "manage_main_category.php?msg=".urlencode($msg);
						
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