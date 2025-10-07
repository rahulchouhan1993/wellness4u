<?php
require_once('config/class.mysql.php');
require_once('classes/class.places.php');
$obj = new Places();

$edit_action_id = '68';

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
	$city_id = trim($_POST['hdncity_id']);
	$state_id = trim($_POST['state_id']);
	$city = strip_tags(trim($_POST['city']));
	
	if($state_id == '')
	{
		$error = true;
		$err_msg = 'Please select state!';
	}
	
	if($city == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter city!';
	}
	elseif( $obj->chkCityExists_edit($city,$state_id,$city_id) )
	{
		$error = true;
		$err_msg .= '<br>This city is already added';
	}

	if(!$error)
	{
		if($obj->updateCity($state_id,$city,$city_id))
		{
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=cities&msg='.urlencode($msg));
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
	$city_id = $_GET['id'];
	list($state_id,$city) = $obj->getCityDetails($city_id);
	if($city == '')
	{
		header('location: index.php?mode=cities');	
	}	
}	
else
{
	header('location: index.php?mode=cities');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit City</td>
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
							<form action="#" method="post" name="frmedit_city" id="frmedit_city" enctype="multipart/form-data" >
							<input type="hidden" name="hdncity_id" id="hdncity_id" value="<?php echo $city_id;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="20%" align="right"><strong>State</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<select name="state_id" id="state_id">
											<option value="">Select State</option>
											<?php echo $obj->getStateOptions($state_id);?>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>City</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="city" type="text" id="city" value="<?php echo $city; ?>" ></td>
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