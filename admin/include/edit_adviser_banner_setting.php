<?php
require_once('config/class.mysql.php');
require_once('classes/class.banner.php');
require_once('classes/class.places.php');
require_once('../init.php');

$obj = new Banner();
$obj2 = new Places();

$edit_action_id = '210';

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
	$ab_id = $_POST['hdnab_id'];
	$pro_user_id = trim($_POST['pro_user_id']);
	$ab_status = trim($_POST['ab_status']);

	if($pro_user_id == "")
	{
		$error = true;
		$err_msg = "Please Select Adviser.";
	}
		
	if(isset($_FILES['banner']['tmp_name']) && $_FILES['banner']['tmp_name'] != '')
	{
		$banner = $_FILES['banner']['name'];
		
		$file4 = substr($banner, -4, 4);
		
		if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))
		{
			$error = true;
			$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for banner';
		}	 
		elseif( $_FILES['banner']['type'] != 'image/jpeg' and $_FILES['banner']['type'] != 'image/pjpeg'  and $_FILES['banner']['type'] != 'image/gif' and $_FILES['banner']['type'] != 'image/png' )
		{
			$error = true;
			$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for banner';
		}
		

		if(!$error)
		{	
			
			$banner = time()."_".$banner;
			$temp_dir = SITE_PATH.'/uploads/';
			$temp_file = $temp_dir.$banner;
	
			if(!move_uploaded_file($_FILES['banner']['tmp_name'], $temp_file)) 
			{
				if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
				$error = true;
				$err_msg .= '<br>Couldn\'t Upload banner ';
				$banner = trim($_POST['hdnbanner']);
			}
		}
		else
		{
			$banner = trim($_POST['hdnbanner']);
		}	
	}  
	else
	{
		$banner = trim($_POST['hdnbanner']);
	}

	if(!$error)
	{
				
		if($obj->updateAdviserBannerSetting($ab_id,$banner,$ab_status,$pro_user_id))
		{
			$msg = "Record Edited Successfully!";
			header('location: index.php?mode=adviser_banner_settings&msg='.urlencode($msg));
			exit(0);
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}	
}
elseif(isset($_GET['ab_id']))
{
	$ab_id = $_GET['ab_id'];
	list($banner,$ab_status,$pro_user_id) = $obj->getAdviserBannerSettingDetails($ab_id);
	
	if($banner == '')
	{
		header('location: index.php?mode=adviser_banner_settings');
		exit(0);
	}	
}
else
{
	header('location: index.php?mode=adviser_banner_settings');
	exit(0);
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
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Adviser Banner </td>
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
							<form action="#" method="post" name="frmedit_banner" id="frmedit_banner" enctype="multipart/form-data" >
							<input type="hidden" name="hdnab_id" value="<?php echo $ab_id;?>" />
                            <input type="hidden" name="hdnbanner" value="<?php echo $banner;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="20%" align="right"><strong>Adviser Name</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
                                        <select name="pro_user_id" id="pro_user_id" style="width:200px;">
                                            <option value="">Select Adviser</option>
                                            <?php echo $obj2->getProUsersOptions($pro_user_id); ?>
                                        </select>
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>
									<td width="20%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><select name="ab_status" id="ab_status">
                                                                 <option value="1" <?php  if($ab_status == 1) {?> selected="selected" <?php } ?> >Active</option>
                                                                 <option value="0" <?php  if($ab_status == 0) {?> selected="selected" <?php } ?>>Inactive</option>
                                                                 </select></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right" valign="top"><strong>Banner</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left">
									<?php 
									if($banner != '')
									{ ?>
										<img border="0" src="<?php echo SITE_URL.'/uploads/'. $banner;?>" width="200" /> 
							        <?php
									} ?>
									</td>
								</tr>
								<tr>
									<td width="20%" align="right" valign="top">&nbsp;</td>
									<td width="5%" align="center" valign="top">&nbsp;</td>
									<td width="75%" align="left"><input type="file" name="banner" id="banner" />
									</td>
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