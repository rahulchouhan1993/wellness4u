<?php
require_once('config/class.mysql.php');
require_once('classes/class.admin.php');
$myaccount = new Admin();
$oldpass = $myaccount->GetCurrentPassword();
$error = false;
$err_msg = "";
if(isset($_POST['btnSubmit']))
{
	$opass = trim($_POST['opass']);
	$cpass = trim($_POST['cpass']);
	$npass = trim($_POST['npass']);
	$cnpass = trim($_POST['cnpass']);


	if($cpass == "")
	{
		$error = true;
		$err_msg = "<br>Please Enter Current Password.";
	}
	elseif(md5($cpass) != $opass)
	{
		$error = true;
		$err_msg .= "<br>Please Enter Correct Current Password.";
	}
	
	if($npass == "")
	{
		$error = true;
		$err_msg .= "<br>Please Enter New Password.";
	}
	
	if($cnpass == "")
	{
		$error = true;
		$err_msg .= "<br>Please Enter Confirm New Password.";
	}
	elseif($cnpass != $npass)
	{
		$error = true;
		$err_msg .= "<br>Please Enter Same Confirm Password.";
	}
	
	
	if(!$error)
	{
		if($myaccount->UpdatePassword($npass))
		{
			$err_msg = "<br>Password updated Successfully!";
		}
		else
		{
			$err_msg .= "<br>There is any problem. Please try later!";
		}
	}
}	
else
{
	$cpass = "";
	$npass = "";
	$cnpass = "";
}
?>
<div id="central_part_contents">
	<div id="notification_contents">
	<?php
	if($err_msg != "")
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
										<td class="notification-title-E">Note</td>
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Change Password </td>
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
							<form action="#" method="post" name="changepassword" id="changepassword">
							<input type="hidden" name="opass" id="opass" value="<?php echo trim($oldpass['password']); ?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="243">&nbsp;</td>
									<td width="158" height="30"><div class="auth-subtitle">Current Password </div></td>
									<td width="23"><div align="center">:</div></td>
									<td width="390"><span class="auth-subtitle"><input name="cpass" type="password" id="cpass" maxlength="20" value="" /></span></td>
								</tr>
								<tr>
									<td width="243">&nbsp;</td>
									<td width="158" height="30"><div class="auth-subtitle">New Password  </div></td>
									<td width="23"><div align="center">:</div></td>
									<td width="390"><span class="auth-subtitle"><input name="npass" type="password" id="npass" maxlength="20" value="" /></span></td>
								</tr>
								<tr>
									<td width="243">&nbsp;</td>
									<td width="158" height="30"><div class="auth-subtitle">Confirm New Password </div></td>
									<td width="23"><div align="center">:</div></td>
									<td width="390"><span class="auth-subtitle"><input name="cnpass" type="password" id="cnpass" maxlength="20" value=""/></span></td>
								</tr>
								<tr>
									<td colspan="4" align="center"><p> </p>
										<input type="submit" name="btnSubmit" id="btnSubmit" value="Submit"  />
									</td>
								</tr>
								<tr>
									<td colspan="4" align="center"><p>&nbsp;</p></td>
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