<?php
require_once('config/class.mysql.php');
require_once('classes/class.topbanner.php');
require_once('../init.php');
$obj = new Banner();
$error = false;
$err_msg = "";

if(isset($_POST['btnSubmit']))
{
	$banner_id = $_POST['hdnbanner_id'];
	
	$position = trim($_POST['position']);
	$width = strip_tags(trim($_POST['width']));
	$height = strip_tags(trim($_POST['height']));
	
	
	//echo $page;

	
	if($position == "")
	{
		$error = true;
		$err_msg .= "<br>Please Select Position.";
	}
	if($width == "")
	{
		$error = true;
		$err_msg .= "<br>Please Enter Width.";
	}
	elseif(!is_numeric($width))
	{
		$error = true;
		$err_msg .= "<br>Please Enter numeric Width.";
	}
	
	if($height == "")
	{
		$error = true;
		$err_msg .= "<br>Please Enter Height.";
	}
	elseif(!is_numeric($height))
	{
		$error = true;
		$err_msg .= "<br>Please Enter numeric Hieght.";
	}	
	
	
	
	
	
}

if(isset($_GET['banner_id']))
{
	$banner_id = $_GET['banner_id'];
	
	list($position,$width,$height,$banner) = $obj->getBannerDetails($banner_id);
	 
   	
}
else
{
	//header('location: index.php?mode=banner');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Banner </td>
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
							<input type="hidden" name="hdnbanner_id" value="<?php echo $banner_id;?>" />
							<input type="hidden" name="hdnbanner" value="<?php echo stripslashes($banner);?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								
								<tr>
									<td width="20%" align="right"><strong>Position</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input name="position" readonly type="text" id="position" value="<?php echo $position; ?>" style="width:300px;" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Width</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input name="width" readonly type="text" id="width" value="<?php echo $width; ?>" style="width:300px;" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Height</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input name="height" readonly type="text" id="height" value="<?php echo $height; ?>" style="width:300px;" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
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
									{  
										?>
										<img border="0" src="<?php echo SITE_URL.'/uploads/'. $banner;?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>"  /> 
							        	
										<?php
											
									}?>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr id="trfile" style="display:<?php echo $display_trfile;?>">
									<td width="20%" align="right" valign="top">&nbsp;</td>
									<td width="5%" align="center" valign="top">&nbsp;</td>
									<td width="75%" align="left">
										<input type="file" name="banner" id="banner"  />
									</td>
								</tr>
								<tr id="trtext" style="display:<?php echo $display_trtext;?>">
									<td width="20%" align="right" valign="top">&nbsp;</td>
									<td width="5%" align="center" valign="top">&nbsp;</td>
									<td width="75%" align="left">
										<input type="text" name="banner2" id="banner2" value="<?php echo $banner;?>"  />
									</td>
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