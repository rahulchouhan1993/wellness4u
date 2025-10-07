<?php
require_once('config/class.mysql.php');
require_once('classes/class.mindjumble.php');
require_once('../init.php');
$obj = new Mindjumble();

$edit_action_id = '92';

if(!$obj->isAdminLoggedIn())
{
	
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$edit_action_id))
	{	
	  	header("Location: index.php?mode=invalid");
		exit(0);
	}

$error = false;
$err_msg = "";
if(isset($_POST['btnSubmit']))
{
	$narration_id = $_POST['hdnnarration_id'];
	$title_id = $_POST['hdntitle_id'];
	$status = strip_tags(trim($_POST['status']));
	$narration = strip_tags(trim($_POST['narration']));
	
	//echo $title_id;

	if($narration == "")
	{
		$error = true;
		$err_msg = "Please Enter Narration.";
	}
	elseif($obj->chkEdit_narrationExists($narration,$narration_id))
	{
		$error = true;
		$err_msg .= 'This narration already exists';
	}
	
	
		if(!$error)
		{  
			if($obj->Update_Mindjumble_Narration($status,$narration,$title_id,$narration_id))
				{
				    
					$msg = "Record Edited Successfully!";	
					header('location: index.php?mode=narration&uid='.$title_id.'&msg='.urlencode($msg));
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
	$narration_id = $_GET['uid'];
	
	list($title_id,$status,$narration) = $obj->getmindjumbleNarration($narration_id);

}
else
{
	
	header('location: index.php?mode=title');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Mind Jumble Narration</td>
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
							<form action="#" method="post" name="frmedit_Mindjumble" id="frmedit_Mindjumble" enctype="multipart/form-data" >
							<input type="hidden" name="hdnnarration_id" value="<?php echo $narration_id;?>" />
                            <input type="hidden" name="hdntitle_id" value="<?php echo $title_id;?>" />
                            <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>

									<td width="20%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><select id="status" name="status">
                                    								<option value="1" <?php if($status == '1'){ ?> selected <?php } ?>>Active</option>
                                                                    <option value="0" <?php if($status == '0'){ ?> selected <?php } ?>>Inactive</option>
                                                                    </select></td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right"><strong>Mind Jumble Box Title</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><?php echo $obj->getNarrationTitle($title_id); ?></td>
								</tr>
                                 <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right"><strong>Narration</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="narration" name="narration" value="<?php echo $narration; ?>"/></td>
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