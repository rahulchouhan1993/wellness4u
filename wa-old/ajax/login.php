<?php
include_once('../../classes/config.php');
include_once('../../classes/vendor.php');
$obj = new Vendor();

$error = false;
$err_msg = '';


//$obj->debuglog('[ajax-login] POST: <pre>'.print_r($_POST,true).'</pre><br>REQUEST: <pre>'.print_r($_REQUEST,true).'</pre>');

if(isset($_POST['logBtn']))
{
	$username = strip_tags(trim($_POST['username']));
    $password = strip_tags(trim($_POST['password']));

    if( ($username == '') || ($password == '') ) 
    {
        $error = true;
        $err_msg = "Please Enter Username/Password";
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		//$obj->debuglog('[ajax-login] RESPONSE1: '.json_encode($tdata));
		echo json_encode($tdata);
		exit(0);
		
    }
    elseif(!$obj->chkValidVendorLogin($username,$password))
    {
        $error = true;
        $err_msg = "Invalid Username/Password";
		
		$tdata = array();
		$response = array('msg'=>$err_msg,'status'=>0);
		$tdata[] = $response;
		//$obj->debuglog('[ajax-login] RESPONSE2: '.json_encode($tdata));
		echo json_encode($tdata);
		exit(0);
    }

    if(!$error)
    {
		//$obj->debuglog('[ajax-login] NOT ERROR');
        if($obj->doVendorLogin($username))
        {
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>1,'refurl'=> 'index.php');
			$tdata[] = $response;
			//$obj->debuglog('[ajax-login] RESPONSE3: '.json_encode($tdata));
			echo json_encode($tdata);
			exit(0);
        }
        else
        {
            $error = true;
            $err_msg = "The username or password you entered is invalid, please try again.";
			
			$tdata = array();
			$response = array('msg'=>$err_msg,'status'=>0);
			$tdata[] = $response;
			//$obj->debuglog('[ajax-login] RESPONSE4: '.json_encode($tdata));
			echo json_encode($tdata);
			exit(0);
        }
    }		
}
else
{
	echo 'Invalid access';
}