<?php
require_once('config/class.mysql.php');
require_once('classes/class.banner.php');
require_once('../init.php');

$obj = new Banner();

$add_action_id = '187';

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

$display_trtext = array();
$display_trtext[0] = 'none';
$display_trfile = array();
$arr_banner = array();
$arr_banner2 = array();
$arr_banner_type = array();
$arr_url = array();
$arr_client_name = array();
//$arr_display_trfile = '0';

$banner_cnt = '1';
$banner_totalRow = '1';

if(isset($_POST['btnSubmit']))
{
	$page_id = trim($_POST['page_id']);
	$position_id = trim($_POST['position_id']);
	$width = $_POST['hdnwidth'];
	$height = $_POST['hdnheight'];
	$banner_totalRow = trim($_POST['hdnbanner_totalRow']);  
	$banner_cnt = trim($_POST['hdnbanner_cnt']);
	$arr_banner_type = $_POST['banner_type'];
	$arr_url = $_POST['url'];
	$arr_banner2 = $_POST['banner2'];
	$arr_client_name = $_POST['client_name'];
	
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
	
	for($i=0;$i<$banner_cnt;$i++)
	{
		if($arr_banner_type[$i] == 'Video')
		{   
			$display_trfile[$i] = 'none';
			$display_trtext[$i] = '';
			$arr_banner[$i] = $arr_banner2[$i];
		}
		elseif($arr_banner_type[$i] == 'Google Ads')
		{
			if($position_id != '')
			{
				list ($position,$side,$width,$height,$arr_banner[$i])	 =  $obj->getGoogleAds_Details($position_id,$arr_banner_type[$i]);	
			}
			
			$display_trfile[$i] = 'none';
			$display_trtext[$i] = 'none';
		}
		else if($arr_banner_type[$i] == 'Affilite Ads'|| $arr_banner_type[$i] == 'Other Ads')

                        {

                          $arr_banner[$i] = $_POST['banner_code'][$i];

                         

                          $arr_banner_type[$i] = $arr_banner_type[$i];

                        }
		else
		{  
			$display_trfile[$i] = '';
			$display_trtext[$i] = 'none';
		
			if(isset($_FILES['banner']['tmp_name'][$i]) && $_FILES['banner']['tmp_name'][$i] != '')
			{
				$banner = $_FILES['banner']['name'][$i];
				
				$file4 = substr($banner, -4, 4);
				
				if($arr_banner_type[$i] == 'Image')
				{ 
					if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))
					{
						$error = true;
						$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for banner';
					}	 
					elseif( $_FILES['banner']['type'][$i] != 'image/jpeg' and $_FILES['banner']['type'][$i] != 'image/pjpeg'  and $_FILES['banner']['type'][$i] != 'image/gif' and $_FILES['banner']['type'][$i] != 'image/png' )
					{
						$error = true;
						$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for banner';
					}
				}
				elseif($arr_banner_type[$i] == 'FLash')
				{ 
					if(($file4 != '.swf')and($file4 != '.SWF'))
					{
						$error = true;
						$err_msg .= '<br>Please Upload Only(swf) files for banner ';
					}	 
					elseif( $_FILES['banner']['type'][$i] != 'application/x-shockwave-flash'  )
					{
						$error = true;
						$err_msg .= '<br>Please Upload Only(swf) files for banner';
					}
				}

				if(!$error)
				{	
					
					$temp_dir = '../uploads/';
					if (!is_dir($temp_dir)) {
						mkdir($temp_dir, 0777, true);
					}

					// Get original filename from $_FILES
					$origName = $_FILES['banner']['name'][$i] ?? $_FILES['banner']['name'] ?? '';

					if ($origName != '' && isset($_FILES['banner']['tmp_name'][$i])) {
						// Build final filename
						$banner = time() . "_" . basename($origName);
						$temp_file = $temp_dir . $banner;

						// Move uploaded file
						if (!move_uploaded_file($_FILES['banner']['tmp_name'][$i], $temp_file)) {
							if (file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
							$error = true;
							$err_msg .= '<br>Couldn\'t Upload banner 111';
							$banner = '';
						}
					} else {
						$banner = '';
						$error = true;
						$err_msg .= '<br>Couldn\'t Upload banner 11';
					}

					// Store in array
					$arr_banner[$i] = $banner;
				}
			}  
		}
	}

	if(!$error)
	{
		$page_name = $obj->getPageName($page_id);
		
		if($obj->Add_banner($admin_id,$page_id,$page_name,$position_id,$arr_banner,$arr_url,$arr_banner_type,$arr_client_name))
		{
			$msg = "Record Added Successfully!";
			header('location: index.php?mode=adviser_banners&msg='.urlencode($msg));
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}	
}
?>
<script src="js/AC_ActiveX.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript"> 
$(document).ready(function() {
	
					
					$('#addMoreBanners').click(function() {
					
					var banner_cnt = parseInt($('#hdnbanner_cnt').val());
					//alert(banner_cnt+'ddddddddddddddddd');
					var banner_totalRow = parseInt($('#hdnbanner_totalRow').val());
					$('#add_before_this_Banner').before('<tr id="banner_id_1_'+banner_cnt+'"><td width="20%" align="right"><strong>Banner Type</strong></td><td width="5%" align="center"><strong>:</strong></td><td width="75%" align="left"><select name="banner_type[]" id="banner_type_'+banner_cnt+'" onChange="BannerBox('+banner_cnt+')"><option value="Image">Image</option><option value="Flash">Flash</option><option value="Video">Video</option><option value="Google Ads">Google Ads</option></select></td></tr><tr id="banner_id_2_'+banner_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr id="banner_id_3_'+banner_cnt+'"><td width="20%" align="right" valign="top"><strong>Banner</strong></td><td width="5%" align="center" valign="top"><strong>:</strong></td><td width="75%" align="left" id="google_ads_'+banner_cnt+'"></td></tr><tr id="banner_id_4_'+banner_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr id="trfile_'+banner_cnt+'" style="display:"><td width="20%" align="right" valign="top">&nbsp;</td><td width="5%" align="center" valign="top">&nbsp;</td><td width="75%" align="left"><input type="file" name="banner[]" id="banner_'+banner_cnt+'" /></td></tr><tr id="trtext_'+banner_cnt+'" style="display:none"><td width="20%" align="right" valign="top">&nbsp;</td><td width="5%" align="center" valign="top">&nbsp;</td><td width="75%" align="left"><input type="text" name="banner2[]" id="banner2_'+banner_cnt+'"/></td></tr><tr id="banner_id_5_'+banner_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr id="banner_id_6_'+banner_cnt+'"><td width="20%" align="right"><strong>URL</strong></td><td width="5%" align="center"><strong>:</strong></td><td width="75%" align="left"><input name="url[]" type="text" id="url_'+banner_cnt+'" style="width:300px;" ></td></tr><tr id="banner_id_7_'+banner_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr id="banner_id_8_'+banner_cnt+'"><td width="20%" align="right"><strong>Client Name</strong></td><td width="5%" align="center"><strong>:</strong></td><td width="75%" align="left"><input name="client_name[]" type="text" id="client_name_'+banner_cnt+'" >&nbsp;<input type="button" value="Remove Item" id="tr_banner_'+banner_cnt+'" name="tr_banner_'+banner_cnt+'" onclick="removeBannerRow('+banner_cnt+')" /></td></tr><tr id="banner_id_9_'+banner_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr>');	
						
					banner_cnt = banner_cnt + 1;       
					$('#hdnbanner_cnt').val(banner_cnt);
					var banner_cnt = $('#hdnbanner_cnt').val();
					banner_totalRow = banner_totalRow + 1;       
					$('#hdnbanner_totalRow').val(banner_totalRow);
						
						});
				
				
});
</script>

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Adviser Banner</td>
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
							<input type="hidden" name="hdnheight" id="hdnheight" value="<?php echo $height; ?>"  />
                            <input type="hidden" name="hdnwidth" id="hdnwidth" value="<?php echo $width; ?>"  />
                            <input type="hidden" name="hdnbanner_cnt" id="hdnbanner_cnt" value="<?php echo $banner_cnt;?>" />
							<input type="hidden" name="hdnbanner_totalRow" id="hdnbanner_totalRow" value="<?php echo $banner_totalRow;?>" />
                            <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblbanner">
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
									<td width="20%" align="right"><strong>Position</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><select id="position_id" name="position_id" onChange="getHeightAndWidth()">
                                                                 <option value="">Select Position </option>
                                                                 <?php  echo $obj->getPositions($position_id); ?>
                                                                 </select></td>
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
                    	<?php
                            for($i=0;$i<$banner_totalRow;$i++)
                            {   ?>	
                            	 
								<tr id="banner_id_1_<?php echo $i;?>">
									<td width="20%" align="right"><strong>Banner Type</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<select name="banner_type[]" id="banner_type_<?php echo $i; ?>" onChange="BannerBox('<?php echo $i; ?>')">
											<option value="Image"  	   <?php if($arr_banner_type[$i] == 'Image'){ ?> selected <?php } ?>>Image</option>
											<option value="Flash"  	   <?php if($arr_banner_type[$i] == 'Flash'){ ?> selected <?php } ?>>Flash</option>
                                            <option value="Video" 	   <?php if($arr_banner_type[$i] == 'Video'){ ?> selected <?php } ?>>Video</option>
                                            <option value="Google Ads" <?php if($arr_banner_type[$i] == 'Google Ads'){ ?> selected <?php } ?>>Google Ads</option>
                                            <option value="Affilite Ads" <?php if($arr_banner_type[$i] == 'Affilite Ads'){ ?> selected <?php } ?>>Affilite Ads</option>
                                            <option value="Other Ads" <?php if($arr_banner_type[$i] == 'Other Ads'){ ?> selected <?php } ?>>Other Ads</option>
											</select>
									</td>
								</tr>
								<tr id="banner_id_2_<?php echo $i;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr id="banner_id_3_<?php echo $i;?>">
									<td width="20%" align="right" valign="top"><strong>Banner</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left" id="google_ads_<?php echo $i; ?>">
									<?php 
									if($arr_banner[$i] != '')
									{  
										if($arr_banner_type[$i] == 'Image')
										{ ?>
										<img border="0" src="<?php echo SITE_URL.'/uploads/'. $arr_banner[$i];?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>"  /> 
							        	<?php
										}		
										elseif($arr_banner_type[$i] == 'Flash')
										{ 
										  ?>
										<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="<?php echo $width; ?>" HEIGHT="<?php echo $height; ?>" id="myMovieName">
											<PARAM NAME=movie VALUE="<?php echo SITE_URL.'/uploads/'. $arr_banner[$i];?>">
											<PARAM NAME=quality VALUE=high>
											<param name="wmode" value="transparent">
											<EMBED src="<?php echo SITE_URL.'/uploads/'. $arr_banner[$i]; ?>" quality=high WIDTH="<?php echo $width; ?>" HEIGHT="<?php echo $height; ?>" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
										</OBJECT>
										<?php
										}
										 elseif($arr_banner_type[$i] == 'Video')
										{   ?>
                                         <iframe width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo $obj->getBannerString($arr_banner[$i]); ?>" frameborder="0" allowfullscreen></iframe>
                                      	 <?php
											}
											elseif($arr_banner_type[$i] == 'Google Ads')
											{
												echo $arr_banner[$i];
											}
										}
									?>
									</td>
								</tr>
								<tr id="banner_id_4_<?php echo $i;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr  id="trfile_<?php echo $i; ?>" style="display:<?php echo $display_trfile[$i];?>">
									<td width="20%" align="right" valign="top">&nbsp;</td>
									<td width="5%" align="center" valign="top">&nbsp;</td>
									<td width="75%" align="left"><input type="file" name="banner[]" id="banner_<?php echo $i;?>" />
									</td>
								</tr>
								 <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right"><strong>Banner Code</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                                            <!--<input name="affiliate_code[]" type="text" id="affiliate_code" value="<?php echo $arr_url[$i]; ?>" style="width:300px;" >-->

                                                                        <textarea id="banner_code_<?php echo $i;?>" name="banner_code[]" cols="60" rows="3"><?php  echo $banner_code; ?></textarea>

                                                                        </td>

								</tr>
								<tr id="trtext_<?php echo $i; ?>" style="display:<?php echo $display_trtext[$i];?>">
									<td width="20%" align="right" valign="top">&nbsp;</td>
									<td width="5%" align="center" valign="top">&nbsp;</td>
									<td width="75%" align="left"><input type="text" name="banner2[]" id="banner2_<?php echo $i; ?>" value="<?php echo $arr_banner[$i];?>" />
									</td>
								</tr>
								<tr id="banner_id_5_<?php echo $i;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr id="banner_id_6_<?php echo $i;?>">
									<td width="20%" align="right"><strong>URL</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input name="url[]" type="text" id="url_<?php echo $i; ?>" value="<?php echo $arr_url[$i]; ?>" style="width:300px;" ></td>
								</tr>
								<tr id="banner_id_7_<?php echo $i;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr id="banner_id_8_<?php echo $i;?>">
									<td width="20%" align="right"><strong>Client Name</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input name="client_name[]" type="text" id="client_name_<?php echo $i; ?>" value="<?php echo $arr_client_name[$i]; ?>">&nbsp;  
                                <?php
								if($i > 0)
								{ ?>
                                    <input type="button" value="Remove Item" id="tr_banner_<?php echo $i; ?>" name="tr_banner_<?php echo $i; ?>" onclick="removeBannerRow('<?php echo $i;?>')" />
                                <?php } ?>
                                    </td>
								</tr>
                                 <tr  id="banner_id_9_<?php echo $i;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
						<?php
							} 
							?>
                                
                                <tr id="add_before_this_Banner">
                                <td align="right" valign="top">&nbsp;</td>
                                <td align="center" valign="top">&nbsp;</td>
                                <td align="left" valign="top"><a href="javascript:void(0)" target="_self" class="body_link" id="addMoreBanners">Add More Banner</a></td>
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