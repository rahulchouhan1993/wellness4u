<?php
require_once('config/class.mysql.php');
require_once('classes/class.stressbuster.php');
require_once('../init.php');
$obj = new Stressbuster();
$error = false;
$err_msg = "";
$msg = "";


if(isset($_POST['btnSubmit']))
{

	$contents = trim($_POST['contents']);
	$page_id = '9';
	
	if($contents == "")
	{
		$error = true;
		$err_msg = "Please enter contents.";
	}

	if(!$error)
		{   
			if($obj->Add_Tooltip($page_id,$contents))
				{
					$msg = "Tooltip Saved Successfully!";
					
				}
			else
				{
					$error = true;
					$err_msg = "Currently there is some problem.Please try again later.";
				}
		}	
}
else
    
	{
		
		$contents = $obj->getToolTipContents();
		
	}


?>
<script src="js/AC_ActiveX.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
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
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Tooltip</td>
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
							<form action="#" method="post" name="frm_contents" id="frm_contents" enctype="multipart/form-data" >
							
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
                            <tr>
								<td colspan="3" align="center" class="error-text"><?php echo $msg; ?></td>
							</tr>
							 <tr>
									<td width="20%" align="right" valign="top"><strong>Contents</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left"><textarea id="contents" rows="10" cols="50" name="contents" ><?php echo $contents; ?></textarea></td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td align="left"><input type="Submit" name="btnSubmit" value="Submit" />&nbsp;
                                    				<input type="button" name="btnSubmit" value="Back" onclick="window.location.href='index.php?mode=stressbuster';"/></td>
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