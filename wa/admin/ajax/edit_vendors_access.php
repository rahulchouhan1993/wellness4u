<?php

include_once('../../classes/config.php');

include_once('../../classes/admin.php');

$obj = new Admin();

if(!$obj->isAdminLoggedIn())

{

	exit(0);

}



$admin_id = $_SESSION['admin_id'];

//$edit_action_id = '93'; //comment by ample 20-07-20
$edit_action_id = '20'; //change by ample 20-07-20



if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))

{

	$tdata = array();

	$response = array('msg'=>'Sorry you dont have access.','status'=>0);

	$tdata[] = $response;

	echo json_encode($tdata);

	exit(0);

}



$obj->debuglog('[EDIT_VENDORS_ACCESS] REQUEST:<pre>'.print_r($_REQUEST,true).'</pre>');



$error = false;

$err_msg = '';



if(isset($_POST['btn_submit']))

{

//        echo '</pre>';

//        print_r($_POST);

//        echo '<pre>';

//        die();

	$va_id = trim($_POST['hdnva_id']);

	$va_cat_id = strip_tags(trim($_POST['hdn_va_cat_id']));

        $va_sub_cat_id = strip_tags(trim($_POST['hdn_va_sub_cat_id']));

	$va_name = strip_tags(trim($_POST['va_name']));

	$va_status = strip_tags(trim($_POST['va_status']));

	

	$arr_selected_am_id = array();

	if(isset($_POST['am_id']) && count($_POST['am_id']) > 0)

	{

		foreach($_POST['am_id'] as $key => $val)

		{

			array_push($arr_selected_am_id,$val);	

		}

	}

	

	$arr_selected_aa_id = array();

	if(isset($_POST['aa_id']) && count($_POST['aa_id']) > 0)

	{

		foreach($_POST['aa_id'] as $key => $val)

		{

			array_push($arr_selected_aa_id,$val);	

		}

	}

	

	

	if($va_cat_id == '')

	{

		$error = true;

		$err_msg = 'Please select category';

		

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

	elseif($obj->chkVendorAccessCategoryExists_edit($va_cat_id,$va_id,$va_sub_cat_id))

	{

		$error = true;

		$err_msg = 'This category already exists';

		

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

	

	if($va_name == '')

	{

		$error = true;

		$err_msg = 'Please enter title';

		

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}

	

	if(count($arr_selected_am_id) == 0)

	{

		$error = true;

		$err_msg = 'Please select menu to assign';

		

		$tdata = array();

		$response = array('msg'=>$err_msg,'status'=>0);

		$tdata[] = $response;

		echo json_encode($tdata);

		exit(0);

	}	

	

	if(!$error)

	{

		if(count($arr_selected_am_id) > 0)

		{

			$am_id = implode(',',$arr_selected_am_id);	

		}

		else

		{

			$am_id = '';	

		}

		

		if(count($arr_selected_aa_id) > 0)

		{

			$aa_id = implode(',',$arr_selected_aa_id);	

		}

		else

		{

			$aa_id = '';	

		}

		

		$arr_where = array();

		$arr_where['va_id'] = $va_id;

		

		$tdata = array();

		$tdata['tablename'] = 'tblvendoraccess';

		$tdata['va_cat_id'] = $va_cat_id;

                $tdata['va_sub_cat_id'] = $va_sub_cat_id;

		$tdata['va_name'] = $va_name;

		$tdata['va_status'] = $va_status;

		$tdata['va_am_id'] = $am_id;

		$tdata['va_aa_id'] = $aa_id;

		$tdata['va_modified_date'] = date('Y-m-d H:i:s');

		$tdata['modified_by_admin'] = $admin_id;

		

		if($obj->updateRecordCommon($tdata,$arr_where))

		{

			$msg = 'Record Updated Successfully!';

			$ref_url = "manage_vendors_access.php?msg=".urlencode($msg);

			

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