<?php
include_once('../../classes/config.php');
include_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}

$admin_id = $_SESSION['admin_id'];
$add_action_id = '2';

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
$arr_selected_am_id = array();
$arr_selected_aa_id = array();

if(isset($_POST['btn_submit']))
{
	$username = strip_tags(trim($_POST['username']));
	$password = strip_tags(trim($_POST['password']));
	$email = trim($_POST['email']);
	$fname = strip_tags(trim($_POST['fname']));
	$lname = strip_tags(trim($_POST['lname']));
	$contact_no = strip_tags(trim($_POST['contact_no']));
	
	if(isset($_POST['am_id']) && count($_POST['am_id']) > 0)
	{
		foreach($_POST['am_id'] as $key => $val)
		{
			array_push($arr_selected_am_id,$val);	
		}
	}
	
	if(isset($_POST['aa_id']) && count($_POST['aa_id']) > 0)
	{
		foreach($_POST['aa_id'] as $key => $val)
		{
			array_push($arr_selected_aa_id,$val);	
		}
	}
	
	
	if($username == '')
	{
		$error = true;
		$err_msg = 'Please Enter Username';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif(!preg_match("/^[a-zA-Z0-9\.\_]+$/",$username)  )
	{
		$error = true;
		$err_msg = 'Please Enter Valid Username[a-z,0-9,.,_]';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($obj->chkAdminUsernameExists($username))
	{
		$error = true;
		$err_msg = 'This Username Already Exists';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($password == '')
	{
		$error = true;
		$err_msg = 'Please Enter Password';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($email == '')
	{
		$error = true;
		$err_msg = 'Please Enter Email';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
	{
		$error = true;
		$err_msg = 'Please Enter Valid Email';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif($obj->chkAdminEmailExists($email))
	{
		$error = true;
		$err_msg = 'This Email Already Exists';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	
	if($fname == '')
	{
		$error = true;
		$err_msg = 'Please Enter First Name';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif(!preg_match("/^[a-zA-Z\'\ ]+$/",$fname)  )
	{
		$error = true;
		$err_msg = 'Please Enter Valid First Name';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($lname == '')
	{
		$error = true;
		$err_msg = 'Please Enter Last Name';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	elseif(!preg_match("/^[a-zA-Z\'\ ]+$/",$lname)  )
	{
		$error = true;
		$err_msg = 'Please Enter Valid Last Name';
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);
	}
	
	if($contact_no != '')
	{
		if( ( !is_numeric($contact_no) ) || ( strlen($contact_no) != 10 ) )
		{
			$error = true;
			$err_msg = 'Please Enter Valid 10 digits numbers only';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
		elseif(!preg_match("/^[0-9]+$/",$contact_no)  )
		{
			$error = true;
			$err_msg = 'Please Enter Valid 10 digits numbers only';
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
		}
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
		
		$tdata = array();
		$tdata['username'] = $username;
		$tdata['password'] = $password;
		$tdata['email'] = $email;
		$tdata['fname'] = $fname;
		$tdata['lname'] = $lname;
		$tdata['email'] = $email;
		$tdata['contact_no'] = $contact_no;
		$tdata['am_id'] = $am_id;
		$tdata['aa_id'] = $aa_id;
		if($obj->addAdminUser($tdata))
		{
			$msg = 'Record Added Successfully!';
			$ref_url = "manage_admins.php?msg=".urlencode($msg);
			//header("Location: manage_admins.php?msg=".urlencode($msg));
			//exit(0);
			
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
  