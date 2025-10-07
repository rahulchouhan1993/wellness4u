<?php
require_once('config/class.mysql.php');
require_once('classes/class.slidercontents.php');
$obj = new Slider_Contents();
$error = false;
$err_msg = "";
if(isset($_POST['btnSubmit']))
{
	$slider_title = strip_tags(trim($_POST['slider_title']));
	$slider_desc = trim($_POST['slider_desc']);
	$slider_type = '1';
	$slider_link = strip_tags(trim($_POST['slider_link']));
	
	if($slider_title == '')
	{
		$error = true;
		$err_msg .= 'Please enter title ';
	}
	
	if(!$error)
	{
		if(isset($_FILES['slider_image']['tmp_name']) && $_FILES['slider_image']['tmp_name'] != '')
		{
			$slider_image = $_FILES['slider_image']['name'];
			$file4 = substr($slider_image, -4, 4);
			if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF'))
			{
				$error = true;
				$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg) files';
			}	 
			elseif( $_FILES['slider_image']['type'] != 'image/jpeg' and $_FILES['slider_image']['type'] != 'image/pjpeg' and $_FILES['slider_image']['type'] != 'image/gif' )
			{
				$error = true;
				$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg) files';
			}
			
			$slider_image = time()."_".$slider_image;
			$temp_dir = SITE_PATH.'/uploads/';
			$temp_file = $temp_dir.$slider_image;
			
			if(!move_uploaded_file($_FILES['slider_image']['tmp_name'], $temp_file)) 
			{
				if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
				$error = true;
				$err_msg .= '<br>Couldn\'t Upload photo $i';
			}
			else
			{
				$obj->createThumbNailSingle(SITE_PATH."/uploads/".$slider_image,SITE_PATH."/uploads/".$slider_image,60);
			}	
		}
	
	
		if($obj->addSliderContent($slider_title,$slider_desc,$slider_image,$slider_type,$slider_link))
		{
			$msg = "Record Added Successfully!";
			header('location: index.php?mode=nature_sliders&msg='.urlencode($msg));
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
	$slider_title = '';
	$slider_desc = '';
	$slider_link = '';
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Slider</td>
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
							<form action="#" method="post" name="frmadd_ngo_slider" id="frmadd_ngo_slider" enctype="multipart/form-data" >
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="30%" align="right"><strong>Title</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="65%" align="left"><input name="slider_title" type="text" id="slider_title" value="<?php echo $slider_title; ?>"></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Description</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><textarea name="slider_desc" id="slider_desc"><?php echo $slider_desc; ?></textarea></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Image</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="slider_image" type="file" id="slider_image" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Link</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="slider_link" type="text" id="slider_link" value="<?php echo $slider_link; ?>" ></td>
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