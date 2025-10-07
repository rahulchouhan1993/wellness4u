<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$edit_action_id = '97';

if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
{
	$tdata = array();
	$response = array('msg'=>'Sorry you dont have access.','status'=>0);
	$tdata[] = $response;
	echo json_encode($tdata);
	exit(0);
}

$obj->debuglog('[EDIT_VENDORS_ACCESS_FORM] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');

$error = false;
$err_msg = '';

if(isset($_POST['btnSubmit']))
{
	$vaf_id = trim($_POST['hdnvaf_id']);
	$va_id = strip_tags(trim($_POST['hdnva_id']));
	$vafm_id = strip_tags(trim($_POST['vafm_id']));
	$vaf_status = strip_tags(trim($_POST['vaf_status']));
	
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
	elseif($obj->chkVendorAccessFormExists_edit($va_id,$vafm_id,$vaf_id))
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
                        
			if($vloc_parent_cat_id == '')
			{
				$error = true;
				$err_msg = 'Please select location category ';
				
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
		$error = true;
		$arr_vafm = $obj->getVendorsAccessFormMasterDetails($vafm_id);
		$arr_form_field = $obj->getArrayOfVendorAccessFormFields($vafm_id);
		if(count($arr_form_field) > 0)
		{
			$arr_where = array();
			$arr_where['vaf_id'] = $vaf_id;
			
			$tdata = array();
			$tdata['tablename'] = 'tblvendoraccessforms';
			$tdata['vafm_id'] = $vafm_id;
			$tdata['vaf_am_id'] = $arr_vafm['vafm_am_id'];
			$tdata['vaf_aa_id'] = $arr_vafm['vafm_aa_id'];
			$tdata['vaf_title'] = stripslashes($arr_vafm['vafm_title']);
			$tdata['vaf_status'] = $vaf_status;
			$tdata['vaf_modified_date'] = date('Y-m-d H:i:s');
			$tdata['modified_by_admin'] = $admin_id;
			
			if($obj->updateRecordCommon($tdata,$arr_where))
			{
				$error = false;
				for($i=0;$i<count($arr_form_field);$i++)
				{
					$field_show = strip_tags(trim($_POST[$arr_form_field[$i].'_show']));	
					
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
					
					$arr_where_del = array();
					$arr_where_del['vaf_id'] = $vaf_id;
					$arr_where_del['field_name'] = $arr_form_field[$i];
					//$arr_where_del['vaff_deleted'] = '0';
					
					$tdata_del = array();
					$tdata_del['tablename'] = 'tblvendoraccessformfields';
					$tdata_del['vaff_deleted'] = '1';
					$tdata_del['vaff_modified_date'] = date('Y-m-d H:i:s');
					$tdata_del['deleted_by_admin'] = $admin_id;
					
					$obj->updateRecordCommon($tdata_del,$arr_where_del);
					
					$tdata_add = array();
					$tdata_add['tablename'] = 'tblvendoraccessformfields';
					$tdata_add['vaf_id'] = $vaf_id;
					$tdata_add['field_name'] = $arr_form_field[$i];
					$tdata_add['field_show'] = $field_show;
					$tdata_add['field_default_value'] = $field_default_value;
					$tdata_add['vaff_status'] = '1';
					$tdata_add['vaff_add_date'] = date('Y-m-d H:i:s');
					$tdata_add['added_by_admin'] = $admin_id;
					$obj->addRecordCommon($tdata_add);	
					
				}
			}
	
			
			if(!$error)
			{
				$msg = 'Record Updated Successfully!';
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