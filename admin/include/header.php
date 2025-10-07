<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tbody>
	<tr>
		<td style="background-image: url(images/top_bg.gif);" class="top-bg">
			<table style="height: 72px;" border="0" width="100%" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<td width="10">&nbsp;</td>
					<td width="190" valign="middle"><a href="index.php"><img src="images/logo.png" alt="" border="0"></a></td>
					<td align="right" width="805">
					<?php
					if( (isset($_SESSION['admin_id'])) && ($_SESSION['admin_id'] != '' && $_GET['mode'] != 'recover_password'))
					{
					?>
						<table border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td nowrap="nowrap">
									<a href="index.php?mode=home" class="top-quick-links">Home</a>&nbsp;&nbsp;|&nbsp;
									<a href="index.php?mode=myaccount" class="top-quick-links">My Account</a>&nbsp;&nbsp;|&nbsp;
									<a href="index.php?mode=change_password" class="top-quick-links">Change Password</a>&nbsp;&nbsp;|&nbsp;
								</td>	
								<td>
									<span class="nowrap"><a href="javascript:fn_redirect('index.php?mode=logout')" class="text-button-link" onMouseOver="window.status='HREF=index.php?mode=logout '; return true;" onMouseOut="window.status=''">Log out&nbsp;<img src="images/text_but_arrow.gif" style="border: 0px none ; width: 16px; height: 14px;" alt="" align="top"></a></span>
								</td>
							</tr>
						</tbody>
						</table>						
					<?php
					}
					?>				
					</td>
					<td align="right" width="18">&nbsp;</td>
				</tr>
			</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src="images/spacer.gif" alt="" border="0" width="1" height="2"></td>
	</tr>
	<tr>
		<td style="background-image: url(images/top_bar_bg.gif);"><img src="images/spacer.gif" alt="" border="0" width="1" height="8"></td>
	</tr>
	<tr>
		<td><img src="images/spacer.gif" alt="" border="0" width="1" height="2"></td>
	</tr>
	<tr>
		<td style="background-image: url(images/top_bottom_bg.gif);"><img src="images/spacer.gif" alt="" border="0" width="1" height="10"></td>
	</tr>
</tbody>
</table>