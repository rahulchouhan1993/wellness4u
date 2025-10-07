<?php
require_once('config/class.mysql.php');
require_once('classes/class.admin.php');
$obj = new Admin();

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->isSuperAdmin())
{
	header("Location: index.php?mode=invalid");
	exit(0);
}

$error = false;
$err_msg = "";

if(isset($_POST['btnSubmit']))
{
	$admin_id = $_POST['hdnadmin_id'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];
	
	if($password == '')
	{
		$error = true;
		$err_msg = 'Please Enter New Password';
	}
	
	if($cpassword == '')
	{
		$error = true;
		$err_msg .= '<br>Please Enter Confirm Password';
	}
	elseif($cpassword != $password)
	{
		$error = true;
		$err_msg .= '<br>Please Enter Same Confirm Password';
	}
	
	
	if(!$error)
	{
	    if($obj->resetSubAdminPassword($admin_id,$password))
		{
			
			$from_email = 'info@wellnessway4u.com';
			$from_name 	= 'info@wellnessway4u.com';
			
			$to_email 	= $obj->getEmailOfSubAdminByID($admin_id);
			$fname 	  	= $obj->getNameOfSubAdmin($admin_id);
			
			$subject  	= 'Your new password at wellnessway4u.com';
			$message  	= '<p><strong>Dear '.$fname.',</strong><p>';
			$message .= '<p>Your password reset successfully!</p>';
			//$message   .= '<p>Your new password is <strong>'.$password.'</strong></p>';
			$message   .= '<p>Best Regards</p>';
			$message   .= '<p>www.wellnessway4u.com</p>';
			//echo $message;
			
			$mail = new PHPMailer();
			$mail->IsHTML(true);
			$mail->Host = "batmobile.websitewelcome.com"; // SMTP server
			$mail->From = $from_email;
			$mail->FromName = $from_name;
			$mail->AddAddress($to_email);
			$mail->Subject = $subject;
			$mail->Body = $message;
			$mail->Send();
			$mail->ClearAddresses();
			$msg = "Password Reset Successfully!";
			header("Location: index.php?mode=manage_subadmin");	
			
		
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}
}
elseif(isset($_GET['uid']))
{
	$admin_id = $_GET['uid'];
	
	if(!$obj->chkValidSubAdminId($admin_id))
	{
		header("Location: index.php?mode=manage_subadmin");	
	}	
}	
else
{
	header("Location: index.php?mode=manage_subadmin");	
}
?>

<div id="central_part_contents">
	<div id="notification_contents">
	<?php
	if($error)
	{
	?>
		<table class="notification-border-e" id="notification" align="center" border="0" width="97%" cellpadding="1" cellspacing="1">
		<tbody>
			<tr>
				<td class="notification-body-e">
					<table border="0" width="100%" cellpadding="0" cellspacing="6">
					<tbody>
						<tr>
							<td><img src="images/notification_icon_e.gif" alt="" border="0" width="12" height="10"></td>
							<td width="100%">
								<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td class="notification-title-E">Error</td>
									</tr>
								</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td class="notification-body-e"><?php echo $err_msg; ?></td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>
		</tbody>
		</table>
	<?php
	}
	?>
<!--notification_contents-->
	</div>	
	<table border="0" width="97%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Reset User Password </td>
						<td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">
				<tbody>
					<tr>
						<td class="mainbox-body">
							<form action="#" method="post" name="frmreset_user_password" id="frmreset_user_password" enctype="multipart/form-data" >
							<input type="hidden" name="hdnadmin_id" id="hdnadmin_id" value="<?php echo $admin_id;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="20%" align="right"><strong>Usermame</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><?php echo $obj->getEmailOfSubAdmin($admin_id);?></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>New Password</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="password" id="password" type="password" style="width:100px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Confirm Password</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="cpassword" id="cpassword" type="password" style="width:100px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td align="left"><input type="Submit" name="btnSubmit" value="Submit" /></td>
								</tr>
							</tbody>
							</table>
							</form>
						</td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
	</tbody>
	</table>
	<br>
</div>
