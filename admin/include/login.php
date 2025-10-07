<?php
require_once('config/class.mysql.php');
require('classes/class.login.php');
$loginSys = new LoginSystem();

if($loginSys->isLoggedIn())
{
	header("Location: index.php?mode=home");
	exit;
}

$error = false;
$err_msg = '';
if(isset($_POST['btnSubmit']))
{
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	
	if( ($username == '') || ($password == '') ) 
	{
		$error = true;
		$err_msg = "Please Enter Username/Password";
	}
	elseif(!$loginSys->chkValidUserPass($username,$password))
	{
		$error = true;
		$err_msg = "Please Enter Valid Username/Password";
	}
	
	if(!$error)
	{
		if($loginSys->doLogin($username,$password))
		{
			header('location: index.php?mode=home');
		}
		else
		{
			$error = true;
			$err_msg = "The username or password you entered is invalid, please try again.";
		}
	}		
}
?>
<style>
    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .password-wrapper-reg {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-text-box {
        width: 100%;
        padding-right: 40px;
    }
    .toggle-password {
        position: absolute;
        right: 10px;
        cursor: pointer;
        font-size: 18px;
        color: #888;
    }
    .toggle-password-reg {
        position: absolute;
        right: 10px;
        cursor: pointer;
        font-size: 18px;
        color: #888;
    }
</style>
<div id="central_part_contents">
	<div id="notification_contents">
	<?php
 	if($error)
	{
	?>
		<table class="notification-border-e" id="notification" align="center" border="0" width="90%" cellpadding="1" cellspacing="1">
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
							<td class="notification-body-e"><?php echo $err_msg;?></td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>
		</tbody>
		</table>
		<br>
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Authentication</td>
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
							<form action="#" method="post" name="main_login_form" id="main_login_form">
							<table align="center" border="0" width="200" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td><div class="auth-subtitle">Username:</div><input name="username" id="username" size="30" value="" class="input-text-100 form-control" tabindex="1" type="text"></td>
								</tr>
								<tr>
									<td>
										<p></p>
										<div class="auth-subtitle">Password:</div>
										<!-- <input name="password" id="password" size="30" value="" class="input-text-100 form-control" tabindex="2" type="password"> -->
										<div class="password-wrapper">
										    <input type="password" name="password" id="password" placeholder="Password" class="input-text-100 form-control" autocomplete="off" required>
										    <span toggle="#password" class="toggle-password" onclick="togglePassword()">👁️</span>
										</div>
									</td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
									<td align="center">
										<input type="submit" name="btnSubmit" id="btnSubmit" value="Submit"  />
									</td>
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
<script>
    function togglePassword() {
        const input = document.getElementById("password");
        const icon = document.querySelector(".toggle-password");
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "🙈"; // Eye-off icon
        } else {
            input.type = "password";
            icon.textContent = "👁️"; // Eye icon
        }
    }
</script>