<?php
require_once('config/class.mysql.php');
require_once('classes/class.banner.php');  
require_once('classes/class.places.php');

$obj = new Banner();
$obj2 = new Places();

$add_action_id = '244';

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
$arr_page_id = array();
$arr_position_id = array();
$arr_width = array();
$arr_height = array();
$readonly_height = array();
$readonly_height[0] = 'readonly';
$arr_bci_order = array();
$arr_bci_frequency = array();

$banner_cnt = '1';
$banner_totalRow = '1';

if(isset($_POST['btnSubmit']))
{
   // echo '<br><pre>';
    //print_r($_POST);
    //echo '<br></pre>';
    $banner_cont_id = strip_tags(trim($_POST['hdnbanner_cont_id']));
    $banner_totalRow = trim($_POST['hdnbanner_totalRow']);  
    $banner_cnt = trim($_POST['hdnbanner_cnt']);
    
    $arr_page_id = $_POST['page_id'];
    $arr_position_id = $_POST['position_id'];
    $arr_width = $_POST['hdnwidth'];
    $arr_height = $_POST['height'];
    $arr_banner_type = $_POST['banner_type'];
    $arr_url = $_POST['url'];
    $arr_banner2 = $_POST['banner2'];
    $arr_bci_order = $_POST['bci_order'];
    $arr_bci_frequency = $_POST['bci_frequency'];
    
    //echo '<br><pre>';
    //print_r($arr_height);
    //echo '<br></pre>';
    
    for($i=0;$i<$banner_cnt;$i++)
    {
        if($arr_page_id[$i] == "")
        {
            $error = true;
            $err_msg .= "<br>Please Select Page Name.";
        }
        if($arr_position_id[$i] == "")
        {
            $error = true;
            $err_msg .= "<br>Please Select Position.";
        }
        else 
        {
            if($arr_position_id[$i] == '1' || $arr_position_id[$i] == '12')
            {
                $readonly_height[$i] = 'readonly';
            }
            else
            {
                $readonly_height[$i] = '';
                if($arr_height[$i] == "")
                {
                    $error = true;
                    $err_msg .= "<br>Please enter height.";
                }
                elseif(!is_numeric ($arr_height[$i]))
                {
                    $error = true;
                    $err_msg .= "<br>Please enter valid height.";
                }
            }
        }
        
        
        if($arr_banner_type[$i] == 'Video')
        {   
            $display_trfile[$i] = 'none';
            $display_trtext[$i] = '';
            $arr_banner[$i] = $arr_banner2[$i];
        }
        elseif($arr_banner_type[$i] == 'Google Ads')
        {
            if($arr_position_id[$i] != '')
            {
                list ($position,$side,$width,$height,$arr_banner[$i])	 =  $obj->getGoogleAds_Details($arr_position_id[$i],$arr_banner_type[$i]);	
            }

            $display_trfile[$i] = 'none';
            $display_trtext[$i] = 'none';
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
                    $banner = time()."_".$banner;
                    $temp_dir = SITE_PATH.'/uploads/';
                    $temp_file = $temp_dir.$banner;

                    if(!move_uploaded_file($_FILES['banner']['tmp_name'][$i], $temp_file)) 
                    {
                        if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
                        $error = true;
                        $err_msg .= '<br>Couldn\'t Upload banner 1';
                        $banner = '';
                    }
                    $arr_banner[$i] = $banner;
                }
            }  
        }
    }

    if(!$error)
    {
        if($obj->addBannerContractItems($banner_cont_id,$arr_page_id,$arr_position_id,$arr_width,$arr_height,$arr_banner_type,$arr_banner,$arr_url,$arr_bci_order,$arr_bci_frequency,$admin_id))
        {
            $msg = "Record Added Successfully!";
            header('location: index.php?mode=document_master_items&id='.$banner_cont_id.'&msg='.urlencode($msg));
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
    $banner_cont_id = $_GET['id'];
    list($banner_client_id,$banner_broker_id,$banner_contract_no,$banner_order_no,$banner_contract_date,$banner_booked_date,$banner_cont_amount,$banner_cont_status) = $obj->getBannerContractDetails($banner_cont_id);
    if($banner_client_id == '')
    {
        header('location: index.php?mode=document_master');	
    }
}	
else
{
    header('location: index.php?mode=document_master');	
}

$tr_row = '';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td width="30%" align="right"><strong>Page Name</strong></td><td width="5%" align="center"><strong>:</strong></td><td width="65%" align="left"><select id="page_id_\'+banner_cnt+\'" name="page_id[]"><option value="">Select Page </option>'.$obj->getPageOptions('').'</select></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td align="right"><strong>Position</strong></td><td align="center"><strong>:</strong></td><td align="left"><select id="position_id_\'+banner_cnt+\'" name="position_id[]" onChange="getHeightAndWidthNew(\'+banner_cnt+\')"><option value="">Select Position </option>'.$obj->getPositions('').'</select></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td align="right"><strong>Width</strong></td><td align="center"><strong>:</strong></td><td align="left" id="width_\'+banner_cnt+\'"></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td align="right"><strong>Height</strong></td><td align="center"><strong>:</strong></td><td align="left"><input type="text" name="height[]" id="height_\'+banner_cnt+\'" value="" readonly ><input type="hidden" name="hdnheight[]" id="hdnheight_\'+banner_cnt+\'" value=""  /><input type="hidden" name="hdnwidth[]" id="hdnwidth_\'+banner_cnt+\'" value=""  /></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td align="right"><strong>Banner Type</strong></td><td align="center"><strong>:</strong></td><td align="left"><select name="banner_type[]" id="banner_type_\'+banner_cnt+\'" onChange="BannerBox(\'+banner_cnt+\')"><option value="Image">Image</option><option value="Flash">Flash</option><option value="Video">Video</option><option value="Google Ads">Google Ads</option></select></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'" id="trfile_\'+banner_cnt+\'" style="display:;"><td align="right" valign="top"><strong>Banner</strong></td><td align="center" valign="top"><strong>:</strong></td><td align="left"><input type="file" name="banner[]" id="banner_\'+banner_cnt+\'" /></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'" id="trtext_\'+banner_cnt+\'" style="display:none;"><td align="right" valign="top"><strong>Banner</strong></td><td align="center" valign="top"><strong>:</strong></td><td align="left"><input type="text" name="banner2[]" id="banner2_\'+banner_cnt+\'" value="" /></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td align="right" valign="top"><strong></strong></td><td align="center" valign="top"><strong></strong></td><td align="left" id="google_ads_\'+banner_cnt+\'"></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td align="right"><strong>URL</strong></td><td align="center"><strong>:</strong></td><td align="left"><input name="url[]" type="text" id="url_\'+banner_cnt+\'" value="" style="width:300px;" ></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td align="right"><strong></strong></td><td align="center"><strong></strong></td><td align="left"><input type="button" value="Remove Item" id="tr_banner_\'+banner_cnt+\'" name="tr_banner_\'+banner_cnt+\'" onclick="removeBannerRowMulti(\'+banner_cnt+\')" /></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td align="right"><strong>Order</strong></td><td align="center"><strong>:</strong></td><td align="left"><select name="bci_order[]" id="bci_order_\'+banner_cnt+\'" style="width:200px;">';
for($m=1;$m<=50;$m++)
{ 
$tr_row .= '<option value="'.$m.'">'.$m.'</option>';
} 
$tr_row .= '</select></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td align="right"><strong>Frequency</strong></td><td align="center"><strong>:</strong></td><td align="left"><select name="bci_frequency[]" id="bci_frequency_\'+banner_cnt+\'" style="width:200px;"><option value="" >Select</option></select></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
?>
<script src="js/AC_ActiveX.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript"> 
$(document).ready(function() {
	
					
					$('#addMoreBanners').click(function() {
					
					var banner_cnt = parseInt($('#hdnbanner_cnt').val());
					//alert(banner_cnt+'ddddddddddddddddd');
					var banner_totalRow = parseInt($('#hdnbanner_totalRow').val());
					$('#tblbanner tr:#add_before_this_Banner').before('<?php echo $tr_row;?>');	
						
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
    { ?>
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
    } ?>
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Banner Contract Item</td>
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
                            <form action="#" method="post" name="frmadd_my_relation" id="frmadd_my_relation" enctype="multipart/form-data" >
                                <input type="hidden" name="hdnbanner_cont_id" id="hdnbanner_cont_id" value="<?php echo $banner_cont_id;?>" />
                                <input type="hidden" name="hdnbanner_cnt" id="hdnbanner_cnt" value="<?php echo $banner_cnt;?>" />
                                <input type="hidden" name="hdnbanner_totalRow" id="hdnbanner_totalRow" value="<?php echo $banner_totalRow;?>" />
                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblbanner">
                                <tbody>
                                <?php
                                for($i=0;$i<$banner_totalRow;$i++)
                                {   ?>    
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td width="30%" align="right"><strong>Page Name</strong></td>
                                        <td width="5%" align="center"><strong>:</strong></td>
                                        <td width="65%" align="left">
                                            <select id="page_id_<?php echo $i?>" name="page_id[]">
                                                <option value="">Select Page </option>
                                                <?php echo $obj->getPageOptions($arr_page_id[$i]); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td align="right"><strong>Position</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select id="position_id_<?php echo $i?>" name="position_id[]" onChange="getHeightAndWidthNew('<?php echo $i?>')">
                                                <option value="">Select Position </option>
                                                <?php  echo $obj->getPositions($arr_position_id[$i]); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td align="right"><strong>Width</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left" id="width_<?php echo $i;?>"><?php echo $arr_width[$i]; ?></td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td align="right"><strong>Height</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <input type="text" name="height[]" id="height_<?php echo $i;?>" value="<?php echo $arr_height[$i]; ?>" <?php echo $readonly_height[$i]; ?> >
                                            <input type="hidden" name="hdnheight[]" id="hdnheight_<?php echo $i;?>" value="<?php echo $arr_height[$i]; ?>"  />
                                            <input type="hidden" name="hdnwidth[]" id="hdnwidth_<?php echo $i;?>" value="<?php echo $arr_width[$i]; ?>"  />
                                        </td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td align="right"><strong>Banner Type</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select name="banner_type[]" id="banner_type_<?php echo $i; ?>" onChange="BannerBox('<?php echo $i; ?>')">
                                                <option value="Image" <?php if($arr_banner_type[$i] == 'Image'){ ?> selected <?php } ?>>Image</option>
                                                <option value="Flash" <?php if($arr_banner_type[$i] == 'Flash'){ ?> selected <?php } ?>>Flash</option>
                                                <option value="Video" <?php if($arr_banner_type[$i] == 'Video'){ ?> selected <?php } ?>>Video</option>
                                                <option value="Google Ads" <?php if($arr_banner_type[$i] == 'Google Ads'){ ?> selected <?php } ?>>Google Ads</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>" id="trfile_<?php echo $i; ?>" style="display:<?php echo $display_trfile[$i];?>">
                                        <td align="right" valign="top"><strong>Banner</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left"><input type="file" name="banner[]" id="banner_<?php echo $i;?>" />
                                        </td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>" id="trtext_<?php echo $i; ?>" style="display:<?php echo $display_trtext[$i];?>">
                                        <td align="right" valign="top"><strong>Banner</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left">
                                            <input type="text" name="banner2[]" id="banner2_<?php echo $i; ?>" value="<?php echo $arr_banner[$i];?>" />
                                        </td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td align="right" valign="top"><strong></strong></td>
                                        <td align="center" valign="top"><strong></strong></td>
                                        <td align="left" id="google_ads_<?php echo $i; ?>">
                                        <?php 
                                        if($arr_banner[$i] != '')
                                        {  
                                            if($arr_banner_type[$i] == 'Image')
                                            { ?>
                                            <img border="0" src="<?php echo SITE_URL.'/uploads/'. $arr_banner[$i];?>" width="<?php echo $arr_width[$i]; ?>" height="<?php echo $arr_height[$i]; ?>"  /> 
                                            <?php
                                            }		
                                            elseif($arr_banner_type[$i] == 'Flash')
                                            { ?>
                                            <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="<?php echo $arr_width[$i]; ?>" HEIGHT="<?php echo $arr_height[$i]; ?>" id="myMovieName">
                                                <PARAM NAME=movie VALUE="<?php echo SITE_URL.'/uploads/'. $arr_banner[$i];?>">
                                                <PARAM NAME=quality VALUE=high>
                                                <param name="wmode" value="transparent">
                                                <EMBED src="<?php echo SITE_URL.'/uploads/'. $arr_banner[$i]; ?>" quality=high WIDTH="<?php echo $arr_width[$i]; ?>" HEIGHT="<?php echo $arr_height[$i]; ?>" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
                                            </OBJECT>
                                            <?php
                                            }
                                            elseif($arr_banner_type[$i] == 'Video')
                                            { ?>
                                            <iframe width="<?php echo $width; ?>" height="<?php echo $arr_height[$i]; ?>" src="<?php echo $obj->getBannerString($arr_banner[$i]); ?>" frameborder="0" allowfullscreen></iframe>
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
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                            <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td align="right"><strong>URL</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><input name="url[]" type="text" id="url_<?php echo $i; ?>" value="<?php echo $arr_url[$i]; ?>" style="width:300px;" ></td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td align="right"><strong>Order</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select name="bci_order[]" id="bci_order_<?php echo $i;?>" style="width:200px;">
                                            <?php
                                            for($m=1;$m<=50;$m++)
                                            { 
                                                if($arr_bci_order[$i] == $m)
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
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td align="right"><strong>Frequency</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select name="bci_frequency[]" id="bci_frequency_<?php echo $i;?>" style="width:200px;">
                                                <option value="" >Select</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <?php
                                    if($i > 0)
                                    { ?>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td align="right"><strong></strong></td>
                                        <td align="center"><strong></strong></td>
                                        <td align="left">
                                            <input type="button" value="Remove Item" id="tr_banner_<?php echo $i; ?>" name="tr_banner_<?php echo $i; ?>" onclick="removeBannerRowMulti('<?php echo $i;?>')" />
                                        </td>
                                    </tr>
                                    <tr class="tr_banner_row_<?php echo $i;?>">
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <?php 
                                    } ?>
                                <?php
                                } ?>
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