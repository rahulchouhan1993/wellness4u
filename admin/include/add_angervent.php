<?php
require_once('config/class.mysql.php');
require_once('classes/class.angervent.php');
require_once('../init.php');
$obj = new Angervent();

$add_action_id = '87';

if(!$obj->isAdminLoggedIn())
{
	
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$add_action_id))
	{	
	  	header("Location: index.php?mode=invalid");
		exit(0);
	}

$error = false;
$err_msg = "";
$display_stressbuster = 'none';
$display_trtext = 'none';
$display_trfile = '';

if(isset($_POST['btnSubmit']))
{

	$step = trim($_POST['step']);
	$box_title = strip_tags(trim($_POST['box_title']));
	$box_desc = strip_tags(trim($_POST['box_desc']));
	$banner_type = $_POST['banner_type'];
	$url = strip_tags(trim($_POST['url']));   
	$credit_line = strip_tags(trim($_POST['credit_line'])); 
	$sound_clip_id = strip_tags(trim($_POST['sound_clip_id']));
	$credit_line_url = strip_tags(trim($_POST['credit_line_url']));
	
	
	if(isset ($_POST['day']) && is_array ($_POST['day']))
	{
		$day = '' ;
		foreach($_POST['day'] as $val)
		{ 
			$day .= $val.',';
		}
		$day = substr($day,0,-1);
		 $arr_day = explode(",", $day);
	}
	else 
	{
		$day = '' ;
		 $arr_day = array();
	}
	
	if($step == "")
	{
		$error = true;
		$err_msg = "Please Select Step.";
	}
    
	if($day == "")
	{
		$error = true;
		$err_msg .= "Please Select Days.";
	}
	
	if($box_title == "")
	{
		$error = true;
		$err_msg .= "<br>Please Enter Anger Vent Box Title.";
	}
	
		
	if($banner_type == 'Video')
	{   
		$display_trfile = 'none';
		$display_trtext = '';
		$banner = trim($_POST['banner2']);
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
						$image_size = $_FILES['banner']['size']/1024;	 
						$max_image_allowed_file_size = 2000; // size in KB
						if($image_size > $max_image_allowed_file_size )
							{
								$error = true;
								$err_msg .=  "<br>Size of image file should be less than $max_image_allowed_file_size kb";
							}
					}
					elseif($banner_type == 'Flash')
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
							$flash_size = $_FILES['banner']['size']/1024;	 
							$max_flash_allowed_file_size = 2000; // size in KB
							if($flash_size > $max_flash_allowed_file_size )
								{
									$error = true;
									$err_msg .=  "<br>Size of flash file should be less than $max_flash_allowed_file_size kb";
								}
						}
						elseif($banner_type == 'Audio')
						{   
						 if(($file4 != '.mp3')and($file4 != '.wav') and ($file4 !='.MP3') and ($file4 != '.WAV') and ($file4 !='.mid') and ($file4 != '.MID'))
							{
								$error = true;
								$err_msg .= '<br>Please Upload Only(mp3 / wav / mid) files for banner ';
							}
							$banner_size = $_FILES['banner']['size']/1024;	 
							$max_audio_allowed_file_size = 2000; // size in KB
							if($banner_size > $max_audio_allowed_file_size )
								{
									$error = true;
									$err_msg .=  "<br>Size of audio file should be less than $max_audio_allowed_file_size kb";
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
							else
							{
								$banner = '';
							}
			}  
			else
				{
				  $error = true; 
				  $err_msg .= '<br>Please Upload Banner'; 
				
				}
	}
	if(!$error)
		{   
			if($obj->Add_Angervent($step,$box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url,$day,$sound_clip_id))
				{
					$msg = "Record Added Successfully!";
					header('location: index.php?mode=angervent&msg='.urlencode($msg));
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
		$step = '';
		$box_title = '';
		$banner_type = '';
		$box_desc = '';
		$credit_line = '';
		$arr_day = array();
		$credit_line_url = 'http://';
		
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Anger Vent</td>
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
							<form action="#" method="post" name="frm_addstressBuster" id="frm_addstressBuster" enctype="multipart/form-data" >
							
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="20%" align="right"><strong>Step</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><select id="step" name="step">
                                    								<option value="1" <?php  if($step == 1) {?> selected="selected" <?php } ?> >1</option>
                                                                    <option value="2" <?php  if($step == 2) {?> selected="selected" <?php } ?> >2</option>
                                                                    <option value="3" <?php  if($step == 3) {?> selected="selected" <?php } ?> >3</option>
                                                                    </select>&nbsp;*</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right" valign="top"><strong>Select Day</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left"><select id="day" name="day[]" multiple="multiple">
                                    								<?php
                                                                        for($i=1;$i<=31;$i++)
                                                                        { ?>
                                                                            <option value="<?php echo $i;?>" <?php if (in_array($i, $arr_day)) {?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                                                        <?php
                                                                        } ?>	
                                                                    </select>&nbsp;*<br>
                                                                    You can choose more than one option by using the ctrl key.</td>
								</tr>
                                 <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Anger Vent Box Title</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="box_title" name="box_title" value="<?php echo $box_title; ?>"/>&nbsp;*</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Credit Line</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="credit_line" name="credit_line" value="<?php echo $credit_line; ?>"/></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right"><strong>Credit Line URL</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="credit_line_url" name="credit_line_url" value="<?php echo $credit_line_url; ?>"/>
                                     (Please enter link like http://www.google.com) </td>
                                   
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Anger Vent Box Banner Type</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<select name="banner_type" id="banner_type" onchange="BannerBox1()">
											<option value="Image" <?php if($banner_type == 'Image'){ ?> selected <?php } ?>>Image</option>
											<option value="Flash" <?php if($banner_type == 'Flash'){ ?> selected <?php } ?>>Flash</option>
                                            <option value="Audio" <?php if($banner_type == 'Audio'){ ?> selected <?php } ?>>Audio</option>
                                            <option value="Video" <?php if($banner_type == 'Video'){ ?> selected <?php } ?>>Video</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right" valign="top"><strong>Banner</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left">&nbsp;</td>
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
									<td width="20%" align="right" valign="top"><strong>Sound Clip</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left"><select name="sound_clip_id" id="sound_clip_id" onchange="Playsound(sound_clip_id)">
                                                                    <option value="">Select Music File </option>
                                    								<?php echo $obj->getSoundClipOptions($sound_clip_id); ?>
                                                                    </select>
                                                                    <div id="playmusic"></div></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right" valign="top"><strong>Box Description</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left"><textarea id="box_desc" rows="10" cols="50" name="box_desc" ><?php echo $box_desc; ?></textarea></td>
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