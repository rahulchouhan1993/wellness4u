<?php
require_once('config/class.mysql.php');
require_once('classes/class.dailymeals.php');
$obj = new Daily_Meals();

$edit_action_id = '15';

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
	$page = $_POST['hdnpage'];
	$nid = strip_tags(trim($_POST['hdnnid']));
	$recommend = strip_tags(trim($_POST['recommend']));
	$guideline = strip_tags(trim($_POST['guideline']));
	$benefits = strip_tags(trim($_POST['benefits']));
		
	if(!$error)
	{
		if($obj->updateNutrients($recommend,$guideline,$benefits,$nid))
		{
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=nutrients&page='.$page.'&msg='.urlencode($msg));
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
	$nid = $_GET['id'];
	$page = $_GET['page'];
	list($recommend,$guideline,$benefits) = $obj->getNutriDetails($nid);
}	
else
{
	header('location: index.php?mode=nutrients');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Nutrients</td>
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
							<form action="#" method="post" name="frmedit_daily_meal" id="frmedit_daily_meal" enctype="multipart/form-data" >
							<input type="hidden" name="hdnnid" id="hdnnid" value="<?php echo $nid;?>" />
							<input type="hidden" name="hdnpage" id="hdnpage" value="<?php echo $page;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="30%" align="right"><strong>Food Constituent</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="65%" align="left"><?php echo $obj->getFoodConstituent($nid); ?></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right" valign="top"><strong>Recommend</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top"><textarea name="recommend" id="recommend" cols="30" rows="10" ><?php echo $recommend; ?></textarea> </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right" valign="top"><strong>Guideline</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top"><textarea name="guideline" id="guideline" cols="30" rows="10" ><?php echo $guideline; ?></textarea> </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right" valign="top"><strong>Benefits</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top"><textarea name="benefits" id="benefits" cols="30" rows="10" ><?php echo $benefits; ?></textarea> </td>
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