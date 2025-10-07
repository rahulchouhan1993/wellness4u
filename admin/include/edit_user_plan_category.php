<?php
require_once('config/class.mysql.php');
require_once('classes/class.subscriptions.php'); 
$obj = new Subscriptions();

$edit_action_id = '206';

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
	$apct_id = $_POST['hdnapct_id'];
	$apct_category_type = strip_tags(trim($_POST['apct_category_type']));
	$apct_status = strip_tags(trim($_POST['apct_status']));
	
	if($apct_category_type == '')
	{
		$error = true;
		$err_msg = 'Please enter category';
	}
	elseif($obj->chkIfUserPlanCategoryAlreadyExists_Edit($apct_category_type,$apct_id))
	{
		$error = true;
		$err_msg = 'Category is already exist';
	}
	
	if(!$error)
	{
		if($obj->updateAdviserPlanCategory($apct_id,$apct_category_type,$apct_status))
		{
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=user_plan_categories&msg='.urlencode($msg));
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
	$apct_id = $_GET['id'];
	list($apct_category_type,$apct_status) = $obj->getUserPlanCategoryDetails($apct_id);
	if($apct_category_type == '')
	{
		header('location: index.php?mode=user_plan_categories');	
	}	
}	
else
{
	header('location: index.php?mode=user_plan_categories');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Category</td>
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
							<input type="hidden" name="hdnapct_id" id="hdnapct_id" value="<?php echo $apct_id;?>" />
                            <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								 <tr>
									<td width="30%" align="right" valign="top"><strong>Category</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="65%" align="left" valign="top"><input name="apct_category_type" type="text" id="apct_category_type" value="<?php echo $apct_category_type; ?>" style="width:200px;"></td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Status</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
										<select id="apct_status" name="apct_status" style="width:200px;">
											<option value="0" <?php if($apct_status == 0) { ?> selected="selected" <?php } ?>>Inactive</option>
											<option value="1" <?php if($apct_status == 1) { ?> selected="selected" <?php } ?>>Active</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td align="left" valign="top"><input type="Submit" name="btnSubmit" value="Submit" /></td>
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