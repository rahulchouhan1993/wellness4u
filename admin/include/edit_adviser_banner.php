<?php
require_once('config/class.mysql.php');
require_once('classes/class.banner.php');
require_once('../init.php');

$obj = new Banner();

$edit_action_id = '188';

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
	$banner_id = $_POST['hdnbanner_id'];
	$page_id = trim($_POST['page_id']);
	$position_id = trim($_POST['position_id']);
	$width = $_POST['hdnwidth'];
	$height = $_POST['hdnheight'];
	$banner_type = $_POST['banner_type'];
	$url = strip_tags(trim($_POST['url']));
	$client_name = strip_tags(trim($_POST['client_name']));
	$status = strip_tags(trim($_POST['status']));

	if($page_id == "")
	{
		$error = true;
		$err_msg = "Please Select Page Name.";
	}
	if($position_id == "")
	{
		$error = true;
		$err_msg .= "<br>Please Select Position.";
	}
	
	
	 
	if($banner_type == 'Video')
	{   
		$display_trfile = 'none';
		$display_trtext = '';
		$banner = trim($_POST['banner2']);
	}
	elseif($banner_type == 'Google Ads')
	{
		if($position_id != '')
		{
			$banner = 'Google Ads';
			list ($position,$side,$width,$height,$banner3)	 =  $obj->getGoogleAds_Details($position_id,$banner_type);	
		}
		//echo $banner;
		$display_trfile = 'none';
		$display_trtext = 'none';
	}
	else
	{  
		$display_trfile = '';
		$display_trtext = 'none';

		if(isset($_FILES['banner']['tmp_name']) && $_FILES['banner']['tmp_name'] != '')
			{
				$banner = $_FILES['banner']['name'];
				$file4=substr($banner, -4, 4);
					if($banner_type == 'Image')
					{
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
					}
					else
						{
						if(($file4 != '.swf')and($file4 != '.SWF'))
							{
								$error = true;
								$err_msg .= '<br>Please Upload Only(swf) files for banner ';
							}	 
						elseif( $_FILES['banner']['type'] != 'application/x-shockwave-flash'  )
							{
								$error = true;
								$err_msg .= '<br>Please Upload Only(swf) files for banner';
							}
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
									$err_msg .= '<br>Couldn\'t Upload banner 1';
									$banner = trim($_POST['hdnbanner']);
								}
							}
			}  
					else
					{
						$banner = trim($_POST['hdnbanner']);
						$file4=substr($banner, -4, 4);
						if($banner_type == 'Image')
							{
								if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))
								{
									$error = true;
									$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for banner';
								}	
							}
						if($banner_type == 'Flash')
							{
								if(($file4 != '.swf')and($file4 != '.SWF'))
								{
									$error = true;
									$err_msg .= '<br>Please Upload Only(swf) files for banner ';
								}
							}	 

					}
	}

		if(!$error)
		{
				$page = $obj->getPageName($page_id);
				if($banner_type == 'Google Ads')
				{
					$banner = $banner3;
				}
			if($obj->Update_Banner($admin_id,$page_id,$page,$position_id,$banner,$url,$banner_type,$client_name,$status,$banner_id))
				{
						$msg = "Record Edited Successfully!";
						header('location: index.php?mode=adviser_banners&msg='.urlencode($msg));
				}
			else
				{
					$error = true;
					$err_msg = "Currently there is some problem.Please try again later.";
				}
		}	
}
	elseif(isset($_GET['banner_id']))
	{
		$banner_id = $_GET['banner_id'];
		list($page_id,$position_id,$width,$height,$banner,$url,$banner_type,$client_name,$status) = $obj->getBannerDetails($banner_id);
		//echo $position_id;

		if($banner_type == 'Video')
		{
			$display_trfile = 'none';
			$display_trtext = '';
		}
		elseif($banner_type == 'Google Ads')
		{
			$display_trfile = 'none';
			$display_trtext = 'none';
		}
		else
		{
			$display_trfile = '';
			$display_trtext = 'none';
		}
	}
else
{
	header('location: index.php?mode=adviser_banners');
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
							<input type="hidden" name="hdnbanner_id" value="<?php echo $banner_id;?>" />
                            <input type="hidden" name="hdnheight" id="hdnheight" value="<?php echo $height ?>"  />
                            <input type="hidden" name="hdnwidth" id="hdnwidth" value="<?php echo $width ?>"  />
                            <input type="hidden" name="hdnbanner" value="<?php echo $banner;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="20%" align="right"><strong>Page Name</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><select id="page_id" name="page_id">
                                                                 <option value="">Select Page </option>
                                                                 <?php echo $obj->getPageOptionsAdviser($page_id); ?>
                                                                 </select></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>
									<td width="20%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><select name="status" id="status">
                                                                 <option value="1" <?php  if($status == 1) {?> selected="selected" <?php } ?> >Active</option>
                                                                 <option value="0" <?php  if($status == 0) {?> selected="selected" <?php } ?>>Inactive</option>
                                                                 </select></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Position</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><select id="position_id" name="position_id" onChange="getHeightAndWidth() ;BannerBox()">
                                                                 <option value="">Select Position </option>
                                                                 <?php  echo $obj->getPositions($position_id); ?>
                                                                 </select>
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Width</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left" id="width"><?php echo $width; ?></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Height</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left" id="height"><?php echo $height; ?></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Banner Type</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<select name="banner_type" id="banner_type" onchange="BannerBox()">
											<option value="Image" <?php if($banner_type == 'Image'){ ?> selected <?php } ?>>Image</option>
											<option value="Flash" <?php if($banner_type == 'Flash'){ ?> selected <?php } ?>>Flash</option>
                                            <option value="Video" <?php if($banner_type == 'Video'){ ?> selected <?php } ?>>Video</option>
                                             <option value="Google Ads" <?php if($banner_type == 'Google Ads'){ ?> selected <?php } ?>>Google Ads</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right" valign="top"><strong>Banner</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left" id="google_ads">
									<?php 
									if($banner != '')
									{
										$width1 = $width;
										$height1 = $height;
										if($width1 > 600)
										{
											$width1 = 600;
											$height1 = '';
										} 
										if($banner_type == 'Image')
										{ ?>
										<img border="0" src="<?php echo SITE_URL.'/uploads/'. $banner;?>" width="<?php echo $width1; ?>" height="<?php echo $height1; ?>"  /> 
							        	<?php
										}		
										elseif($banner_type == 'Flash')
										{ 
										  ?>
										<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="<?php echo $width1; ?>" HEIGHT="<?php echo $height; ?>" id="myMovieName">
											<PARAM NAME=movie VALUE="<?php echo SITE_URL.'/uploads/'. $banner;?>">
											<PARAM NAME=quality VALUE=high>
											<param name="wmode" value="transparent">
											<EMBED src="<?php echo SITE_URL.'/uploads/'. $banner; ?>" quality=high WIDTH="<?php echo $width1; ?>" HEIGHT="<?php echo $height; ?>" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
										</OBJECT>
										<?php
										}
										 elseif($banner_type == 'Video')
										{   ?>
                                         <iframe width="<?php echo $width1; ?>" height="<?php echo $height; ?>" src="<?php echo $obj->getBannerString($banner); ?>" frameborder="0" allowfullscreen></iframe>
										 
										 <?php
											}
											elseif($banner_type == 'Google Ads')
											{
												echo $banner;
											}
										}
									?>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr id="trfile" style="display:<?php echo $display_trfile;?>">
									<td width="20%" align="right" valign="top">&nbsp;</td>
									<td width="5%" align="center" valign="top">&nbsp;</td>
									<td width="75%" align="left">
										<input type="file" name="banner" id="banner" />
									</td>
								</tr>
								<tr id="trtext" style="display:<?php echo $display_trtext;?>">
									<td width="20%" align="right" valign="top">&nbsp;</td>
									<td width="5%" align="center" valign="top">&nbsp;</td>
									<td width="75%" align="left">
										<input type="text" name="banner2" id="banner2" value="<?php echo $banner;?>" />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>URL</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input name="url" type="text" id="url" value="<?php echo $url; ?>" style="width:300px;" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right"><strong>Client Name</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input name="client_name" type="text" id="client_name" value="<?php echo $client_name; ?>" style="width:300px;" ></td>
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