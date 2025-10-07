<?php
require_once('config/class.mysql.php');
require_once('classes/class.heights.php');
$obj = new Heights();

$edit_action_id = '60';

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
	$height_id = $_POST['hdnheight_id'];
	$height_feet_inch = strip_tags(trim($_POST['height_feet_inch']));
	$height_inch = strip_tags(trim($_POST['height_inch']));
	$height_cms = strip_tags(trim($_POST['height_cms']));
	
	if($height_feet_inch == '')
	{
		$error = true;
		$err_msg = 'Please enter height in Feet!';
	}
	
	if($height_inch == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter height in Inch!';
	}
	
	if($height_cms == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter height in Cms!';
	}
	elseif( $obj->chkHeightExists_edit($height_cms,$height_id) )
	{
		$error = true;
		$err_msg .= '<br>This record is already added';
	}

	if(!$error)
	{
		if($obj->updateHeight($height_feet_inch,$height_inch,$height_cms,$height_id))
		{
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=heights&msg='.urlencode($msg));
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}
}
elseif(isset($_GET['id']))
{
	$height_id = $_GET['id'];
	list($height_feet_inch,$height_inch,$height_cms) = $obj->getHeightDetails($height_id);
	if($height_feet_inch == '')
	{
		header('location: index.php?mode=heights');	
	}	
}	
else
{
	header('location: index.php?mode=heights');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Height</td>
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
							<form action="#" method="post" name="frmedit_height" id="frmedit_height" enctype="multipart/form-data" >
							<input type="hidden" name="hdnheight_id" id="hdnheight_id" value="<?php echo $height_id;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="20%" align="right"><strong>Height(Feet)</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<input name="height_feet_inch" id="height_feet_inch" type="text" value="<?php echo $height_feet_inch;?>" style="width:200px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Height(Inch)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="height_inch" type="text" id="height_inch" value="<?php echo $height_inch; ?>" style="width:200px;" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Height(Cms)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="height_cms" type="text" id="height_cms" value="<?php echo $height_cms; ?>" style="width:200px;" ></td>
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