<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$add_action_id = '96';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[ADD_VENDORS_ACCESS_FORM] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';
//        die();
	$va_id = strip_tags(trim($_POST['hdnva_id']));
	$vafm_id = strip_tags(trim($_POST['vafm_id']));
	
	if($va_id == '')
	{
		$error = true;
		$err_msg = 'Invalid vendor access id';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($vafm_id == '')
	{
		$error = true;
		$err_msg = 'Please select form';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($obj->chkVendorAccessFormExists($va_id,$vafm_id))
	{
		$error = true;
		$err_msg = 'This form already exists for this access';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	else
	{
		if($vafm_id == '1')
		{
			$arr_vendor_parent_cat_id = array();
			if(isset($_POST['vendor_parent_cat_id']))
			{
				foreach($_POST['vendor_parent_cat_id'] as $key => $val)
				{
					array_push($arr_vendor_parent_cat_id,$val);
				}		
			}
			
			$arr_vendor_cat_id = array();
			if(isset($_POST['vendor_cat_id']))
			{
				foreach($_POST['vendor_cat_id'] as $key => $val)
				{
					array_push($arr_vendor_cat_id,$val);
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
			
			$vendor_parent_cat_id = implode(',',$arr_vendor_parent_cat_id);
			$vendor_cat_id = implode(',',$arr_vendor_cat_id);
			$vloc_parent_cat_id = implode(',',$arr_vloc_parent_cat_id);
			$vloc_cat_id = implode(',',$arr_vloc_cat_id);
			
			if($vendor_parent_cat_id == '')
			{
				$error = true;
				$err_msg = 'Please select main profile ';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			if($vendor_cat_id == '')
			{
				$error = true;
				$err_msg = 'Please select category ';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			if($vloc_parent_cat_id == '')
			{
				$error = true;
				$err_msg = 'Please select location main profile ';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			if($vloc_cat_id == '')
			{
				$error = true;
				$err_msg = 'Please select location category ';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
		}
		elseif($vafm_id == '2')
		{
//			echo '<pre>';
//                        print_r($_POST);
//                        echo '</pre>';
//			die();
			$arr_vloc_parent_cat_id = array();
			if(isset($_POST['location_category']))
			{
				foreach($_POST['location_category'] as $key => $val)
				{
					array_push($arr_vloc_parent_cat_id,$val);
				}		
			}
			
			$arr_vloc_cat_id = array();
			if(isset($_POST['location_sub_category']))
			{
				foreach($_POST['location_sub_category'] as $key => $val)
				{
					array_push($arr_vloc_cat_id,$val);
				}		
			}
			
			
			$vloc_parent_cat_id = implode(',',$arr_vloc_parent_cat_id);
			$vloc_cat_id = implode(',',$arr_vloc_cat_id);
			
			/*
			if($cusine_type_parent_id == '')
			{
				$error = true;
				$err_msg = 'Please select main profile ';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			*/
			
			if($vloc_parent_cat_id == '')
			{
				$error = true;
				$err_msg = 'Please select profile category ';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
			
			if($vloc_cat_id == '')
			{
				$error = true;
				$err_msg = 'Please select sub category ';
				
				$tdata = array();
				$response = array('msg'=>$err_msg,'status'=>0);
				$tdata[] = $response;
				echo json_encode($tdata);
				exit(0);
			}
		}
		else
		{
			$error = true;
			$err_msg = 'Invalid form ';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
	}
	
	if(!$error)
	{
//                echo '<pre>';
//                print_r($_POST);
//                echo '</pre>';
		$error = true;
		$arr_vafm = $obj->getVendorsAccessFormMasterDetails($vafm_id);
		$arr_form_field = $obj->getArrayOfVendorAccessFormFields($vafm_id);
		if(count($arr_form_field) > 0)
		{
			$tdata = array();
			$tdata['tablename'] = 'tblvendoraccessforms';
			$tdata['va_id'] = $va_id;
			$tdata['vafm_id'] = $vafm_id;
			$tdata['vaf_am_id'] = $arr_vafm['vafm_am_id'];
			$tdata['vaf_aa_id'] = $arr_vafm['vafm_aa_id'];
			$tdata['vaf_title'] = stripslashes($arr_vafm['vafm_title']);
			$tdata['vaf_status'] = '1';
			$tdata['vaf_add_date'] = date('Y-m-d H:i:s');
			$tdata['added_by_admin'] = $admin_id;
			
			if($obj->addRecordCommon($tdata))
			{
				$vaf_id = $obj->getVendorAccessFormIdFromVAID($va_id,$vafm_id);
				$error = false;
				for($i=0;$i<count($arr_form_field);$i++)
				{
					$field_show = strip_tags(trim($_POST[$arr_form_field[$i].'_show']));
                                        
//                                        echo $field_show.'<br>';
//                                        echo $arr_form_field[$i].'<br>';
//					die();
					if($vafm_id == '1')
					{
						if($arr_form_field[$i] == 'vendor_parent_cat_id')
						{
							$field_default_value = $vendor_parent_cat_id;
						}
						elseif($arr_form_field[$i] == 'vendor_cat_id')
						{
							$field_default_value = $vendor_cat_id;
						}
						elseif($arr_form_field[$i] == 'vloc_parent_cat_id')
						{
							$field_default_value = $vloc_parent_cat_id;
						}
						elseif($arr_form_field[$i] == 'vloc_cat_id')
						{
							$field_default_value = $vloc_cat_id;
						}
						else
						{
							$field_default_value = '';
						}	
					}
					elseif($vafm_id == '2')
					{
						/*if($arr_form_field[$i] == 'cusine_type_parent_id')
						{
							$field_default_value = $cusine_type_parent_id;
						}*/
						if($arr_form_field[$i] == 'location_category')
						{
							$field_default_value = $vloc_parent_cat_id;
						}
						elseif($arr_form_field[$i] == 'location_sub_category')
						{
							$field_default_value = $vloc_cat_id;
						}
						else
						{
							$field_default_value = '';
						}	
					}
					else
					{
						$field_default_value = '';
					}
					
					
					$tdata = array();
					$tdata['tablename'] = 'tblvendoraccessformfields';
					$tdata['vaf_id'] = $vaf_id;
					$tdata['field_name'] = $arr_form_field[$i];
					$tdata['field_show'] = $field_show;
					$tdata['field_default_value'] = $field_default_value;
					$tdata['vaff_status'] = '1';
					$tdata['vaff_add_date'] = date('Y-m-d H:i:s');
					$tdata['added_by_admin'] = $admin_id;
					$obj->addRecordCommon($tdata);
				}
			}
			
			if(!$error)
			{
				$msg = 'Record Added Successfully!';
				$ref_url = "manage_vendors_access_forms.php?va_id=".$va_id;
				
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
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later!!";
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}		
	}
}