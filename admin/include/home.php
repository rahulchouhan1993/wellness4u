<?php 
//ob_start();
//error_reporting(0);
?>
<div id="central_part_contents">
	<div id="notification_contents"><!--notification_contents--></div>
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Welcome</td>
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
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td height="30" class="bold style1" align="center">Welcome to Chaitanya Wellness Research Institute Admin Panel</td>
								</tr>
								<tr>
									<td height="30" align="center"><p>You are currently logged in as<span class="bull"> <?php echo $_SESSION['admin_username']; ?> ( <?php echo $_SESSION['admin_fname']; ?> <?php echo $_SESSION['admin_lname']; ?> )</span></p></td>
								</tr>
								<tr>
									<td height="30" align="center"><span class="auth-subtitle">Time</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;
									<?php 
									echo date("h:i A"); ?>
									</td>
								</tr>
								<tr>
									<td height="30" align="center" ><span class="auth-subtitle">Date</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;<?php echo date("m-d-Y"); ?></td>
								</tr>
								<tr>
									<td height="30" align="center"><span class="auth-subtitle">Your IP</span>&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;<?php echo $_SERVER['REMOTE_ADDR']; ?></td>
								</tr>
							</tbody>
							</table>
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