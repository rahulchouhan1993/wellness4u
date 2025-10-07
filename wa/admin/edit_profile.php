<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '1';

$obj = new Admin();
$obj2 = new commonFunctions();
if(!$obj->isAdminLoggedIn())
{
	header("Location: login.php");
	exit(0);
}
else
{
	$admin_id = $_SESSION['admin_id'];
}

$error = false;
$err_msg = "";
$msg = '';

$err_msg_start = '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><strong>';
$err_msg_end = '</strong><a class="alert-link" href="#"></a></div>';					  

if(isset($_POST['btnSubmit']))
{
	$username = strip_tags(trim($_POST['username']));
	$email = trim($_POST['email']);
	$fname = strip_tags(trim($_POST['fname']));
	$lname = strip_tags(trim($_POST['lname']));
	$contact_no = trim($_POST['contact_no']);
	$status = trim($_POST['status']);
	
	if($username == '')
	{
		$error = true;
		$err_msg = $err_msg_start.'Please Enter Username'.$err_msg_end;
	}
	elseif(!preg_match("/^[a-zA-Z0-9\.\_]+$/",$username)  )
	{
		$error = true;
		$err_msg = $err_msg_start.'Please Enter Valid Username[a-z,0-9,.,_]'.$err_msg_end;
	}
	elseif($obj->chkAdminUsernameExists_edit($username,$admin_id))
	{
		$error = true;
		$err_msg = $err_msg_start.'This Username Already Exists'.$err_msg_end;
	}
	
	if($email == '')
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter Email'.$err_msg_end;
	}
	elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter Valid Email'.$err_msg_end;
	}
	elseif($obj->chkAdminEmailExists_edit($email,$admin_id))
	{
		$error = true;
		$err_msg .= $err_msg_start.'This Email Already Exists'.$err_msg_end;
	}
	
	
	if($fname == '')
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter First Name'.$err_msg_end;
	}
	elseif(!preg_match("/^[a-zA-Z\'\ ]+$/",$fname)  )
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter Valid First Name'.$err_msg_end;
	}
	
	if($lname == '')
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter Last Name'.$err_msg_end;
	}
	elseif(!preg_match("/^[a-zA-Z\'\ ]+$/",$lname)  )
	{
		$error = true;
		$err_msg .= $err_msg_start.'Please Enter Valid Last Name'.$err_msg_end;
	}
	
	if($contact_no != '')
	{
		if( ( !is_numeric($contact_no) ) || ( strlen($contact_no) != 10 ) )
		{
			$error = true;
			$err_msg .= $err_msg_start.'Please Enter Valid 10 digits numbers only'.$err_msg_end;
		}
		elseif(!preg_match("/^[0-9]+$/",$contact_no)  )
		{
			$error = true;
			$err_msg .= $err_msg_start.'Please Enter Valid 10 digits numbers only'.$err_msg_end;
		}
	}	
	
	if(!$error)
	{
		$tdata = array();
		$tdata['admin_id'] = $admin_id;
		$tdata['username'] = $username;
		$tdata['email'] = $email;
		$tdata['fname'] = $fname;
		$tdata['lname'] = $lname;
		$tdata['contact_no'] = $contact_no;
		
		$arr_user_record = $obj->getAdminUserDetails($admin_id);
		$tdata['status'] = $arr_user_record['status'];
		$tdata['am_id'] = $arr_user_record['am_id'];
		$tdata['aa_id'] = $arr_user_record['aa_id'];
		
		if($obj->updateAdminUser($tdata))
		{
			$msg = '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Record Updated Successfully!</strong>
					</div>';
		}
		else
		{
			$error = true;
			$err_msg = $err_msg_start."Currently there is some problem.Please try again later.".$err_msg_end;
		}
	}
}
else
{
	$arr_user_record = $obj->getAdminUserDetails($admin_id);
	$username = $arr_user_record['username'];
	$email = $arr_user_record['email']; 
	$fname = $arr_user_record['fname'];
	$lname = $arr_user_record['lname'];
	$contact_no = $arr_user_record['contact_no'];
	$status = $arr_user_record['status'];
}	
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php echo SITE_NAME;?> - Admin</title>
	<?php require_once 'head.php'; ?>
</head>
<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">
<?php include_once('header.php');?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Edit Profile</h2>
				</header>
				<div class="panel-body">
				<?php
				if($msg != '')
				{ ?>
					<p class=""><?php echo $msg;?></p>
				<?php
				} ?>  
				<?php
				if($error)
				{ ?>
					<p class="err_msg"><?php echo $err_msg;?><br /><br /></p>
					<div class="clear"></div>
				<?php
				} ?>  
					<form method="post" role="form">
						<input type="hidden" name="status" id="status" value="<?php echo $status;?>" >
						<div class="form-group">
							<label>Username</label>  
							<input type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>">
						</div>
						<div class="form-group">
							<label>Email</label>  
							<input type="text" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
						</div>
						<div class="form-group">
							<label>First Name</label>  
							<input type="text" name="fname" id="fname" class="form-control" value="<?php echo $fname; ?>">
						</div>
						<div class="form-group">
							<label>Last Name</label>  
							<input type="text" name="lname" id="lname" class="form-control" value="<?php echo $lname; ?>">
						</div>
						<div class="form-group">
							<label>Contact No</label>  
							<input type="text" name="contact_no" id="contact_no" class="form-control" value="<?php echo $contact_no; ?>">
						</div>
						<div class="form-group">
							<button type="submit" name="btnSubmit" class="btn btn-success">Save</button>
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
</body>
</html>