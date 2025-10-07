<?php
require_once('config/class.mysql.php');
require_once('classes/class.banner.php');  
require_once('classes/class.places.php');

$obj = new Banner();
$obj2 = new Places();

$edit_action_id = '245';

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

$display_trtext = 'none';
$display_trfile = '';
$readonly_height = 'readonly';

if(isset($_POST['btnSubmit']))
{
    $bci_id = $_POST['hdnbci_id'];
    $banner_cont_id = strip_tags(trim($_POST['hdnbanner_cont_id']));
    
    $page_id = $_POST['page_id'];
    $position_id = $_POST['position_id'];
    $width = $_POST['hdnwidth'];
    $height = $_POST['height'];
    $banner_type = $_POST['banner_type'];
    $url = $_POST['url'];
    $banner2 = $_POST['banner2'];
    $bci_status = $_POST['bci_status'];
    $bci_order = $_POST['bci_order'];
    $bci_frequency = $_POST['bci_frequency'];
    
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
    else 
    {
        if($position_id == '1' || $position_id == '12')
        {
            $readonly_height = 'readonly';
        }
        else
        {
            $readonly_height = '';
            if($height == "")
            {
                $error = true;
                $err_msg .= "<br>Please enter height.";
            }
            elseif(!is_numeric ($height))
            {
                $error = true;
                $err_msg .= "<br>Please enter valid height.";
            }
        }
    }


    if($banner_type == 'Video')
    {   
        $display_trfile = 'none';
        $display_trtext = '';
        $banner = $banner2;
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
        if($banner_type == 'Google Ads')
        {
                $banner = $banner3;
        }
        
        
        if($obj->updateBannerContractItem($bci_id,$banner_cont_id,$page_id,$position_id,$width,$height,$banner_type,$banner,$url,$bci_order,$bci_frequency,$bci_status,$admin_id))
        {
            $msg = "Record Updated Successfully!";
            header('location: index.php?mode=banner_contract_items&id='.$banner_cont_id.'&msg='.urlencode($msg));
        }
        else
        {
            $error = true;
            $err_msg = "Currently there is some problem.Please try again later.";
        }
        
    }
}
elseif(isset($_GET['id']) && isset($_GET['bid']))
{
    $banner_cont_id = $_GET['id'];
    list($banner_client_id,$banner_broker_id,$banner_contract_no,$banner_order_no,$banner_contract_date,$banner_booked_date,$banner_cont_amount,$banner_cont_status) = $obj->getBannerContractDetails($banner_cont_id);
    if($banner_client_id == '')
    {
        header('location: index.php?mode=banner_contracts');	
    }
    
    $bci_id = $_GET['bid'];
    list($temp_banner_cont_id,$page_id,$position_id,$banner,$url,$banner_type,$width,$height,$bci_order,$bci_frequency,$bci_status) = $obj->getBannerContractItemDetails($bci_id);
    if( $temp_banner_cont_id == '' || ($temp_banner_cont_id != $banner_cont_id) )
    {
        header('location: index.php?mode=banner_contract_item&id='.$banner_cont_id);	
    }
    
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
    header('location: index.php?mode=banner_contracts');	
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
	<table border="0" width="97%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Banner Contract Item</td>
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
							<form action="#" method="post" name="frmedit_my_relation" id="frmedit_my_relation" enctype="multipart/form-data" >
							<input type="hidden" name="hdnbanner_cont_id" id="hdnbanner_cont_id" value="<?php echo $banner_cont_id;?>" />
                                                        <input type="hidden" name="hdnbci_id" id="hdnci_id" value="<?php echo $bci_id;?>" />
                                                        <input type="hidden" name="hdnbanner" value="<?php echo $banner;?>" />
                                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow">
							<tbody>
                                    <tr>
									<td width="30%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="65%" align="left">
                                                                            <select id="bci_status" name="bci_status">
                                                                                <option value="1" <?php if($bci_status == '1'){ ?> selected <?php } ?>>Active</option>
                                                                                <option value="0" <?php if($bci_status == '0'){ ?> selected <?php } ?>>Inactive</option>
                                                                            </select>
                                                                        </td>
								</tr>
                                                                <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Page Name</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select id="page_id" name="page_id">
                                                <option value="">Select Page </option>
                                                <?php echo $obj->getPageOptions($page_id); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Position</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select id="position_id_" name="position_id" onChange="getHeightAndWidthNew('')">
                                                <option value="">Select Position </option>
                                                <?php  echo $obj->getPositions($position_id); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Width</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left" id="width_"><?php echo $width; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Height</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <input type="text" name="height" id="height_" value="<?php echo $height; ?>" <?php echo $readonly_height; ?> >
                                            <input type="hidden" name="hdnheight" id="hdnheight_" value="<?php echo $height; ?>"  />
                                            <input type="hidden" name="hdnwidth" id="hdnwidth_" value="<?php echo $width; ?>"  />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Banner Type</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select name="banner_type" id="banner_type_" onChange="BannerBox('')">
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
                                    <tr id="trfile_" style="display:<?php echo $display_trfile;?>">
                                        <td align="right" valign="top"><strong>Banner</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left"><input type="file" name="banner" id="banner_" />
                                        </td>
                                    </tr>
                                    <tr id="trtext_" style="display:<?php echo $display_trtext;?>">
                                        <td align="right" valign="top"><strong>Banner</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left">
                                            <input type="text" name="banner2" id="banner2_" value="<?php echo $banner;?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"></td>
                                        <td align="center" valign="top"></td>
                                        <td align="left" id="google_ads_">
                                        <?php 
                                        if($banner != '')
                                        {  
                                            if($banner_type == 'Image')
                                            { ?>
                                            <img border="0" src="<?php echo SITE_URL.'/uploads/'. $banner;?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>"  /> 
                                            <?php
                                            }		
                                            elseif($arr_banner_type[$i] == 'Flash')
                                            { ?>
                                            <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="<?php echo $width; ?>" HEIGHT="<?php echo $height; ?>" id="myMovieName">
                                                <PARAM NAME=movie VALUE="<?php echo SITE_URL.'/uploads/'. $banner;?>">
                                                <PARAM NAME=quality VALUE=high>
                                                <param name="wmode" value="transparent">
                                                <EMBED src="<?php echo SITE_URL.'/uploads/'. $banner; ?>" quality=high WIDTH="<?php echo $width; ?>" HEIGHT="<?php echo $height; ?>" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
                                            </OBJECT>
                                            <?php
                                            }
                                            elseif($arr_banner_type[$i] == 'Video')
                                            { ?>
                                            <iframe width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo $obj->getBannerString($banner); ?>" frameborder="0" allowfullscreen></iframe>
                                            <?php
                                            }
                                            elseif($arr_banner_type[$i] == 'Google Ads')
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
                                    
                                    <tr>
                                        <td align="right"><strong>URL</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><input name="url" type="text" id="url" value="<?php echo $url; ?>" style="width:300px;" ></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Order</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select name="bci_order" id="bci_order" style="width:200px;">
                                            <?php
                                            for($m=1;$m<=50;$m++)
                                            { 
                                                if($bci_order == $m)
                                                {
                                                    $sel = ' selected ';
                                                }
                                                else
                                                {
                                                    $sel = ''; 
                                                }
                                            ?>
                                            <option value="<?php echo $m;?>" <?php echo $sel;?>><?php echo $m;?></option>
                                            <?php
                                            } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Frequency</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select name="bci_frequency" id="bci_frequency" style="width:200px;">
                                                <option value="" >Select</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
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