<?php
require_once('config/class.mysql.php');
require_once('classes/class.banner.php');  
require_once('classes/class.places.php');

$obj = new Banner();
$obj2 = new Places();

$edit_action_id = '285';

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

// Get the banner size ID to edit
$bs_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($bs_id <= 0) {
    header("Location: index.php?mode=banner_size_master");
    exit(0);
}

$error = false;
$err_msg = "";

// Initialize arrays
$arr_bs_banner_type = array();
$arr_bs_currency = array();
$arr_bs_amount = array();

$banner_cnt = 1;
$banner_totalRow = 1;

// Fetch existing data for this banner size
$banner_data = $obj->getBannerSizeById($bs_id); // create this function in Banner class
if(!$banner_data){
    $error = true;
    $err_msg = "Invalid Banner Size ID.";
}

// If form submitted
if(isset($_POST['btnSubmit']))
{
    $position_id = $_POST['position_id'];
    $bs_width = strip_tags(trim($_POST['bs_width']));
    $bs_height = strip_tags(trim($_POST['bs_height']));
    $bs_effective_date = strip_tags(trim($_POST['bs_effective_date']));
    $bs_remarks = strip_tags(trim($_POST['bs_remarks']));
    $banner_totalRow = trim($_POST['hdnbanner_totalRow']);  
    $arr_bs_banner_type = $_POST['bs_banner_type'];
    $arr_bs_currency = $_POST['bs_currency'];
    $arr_bs_amount = $_POST['bs_amount'];

    // Validate arrays
    if(count(array_unique([count($arr_bs_banner_type), count($arr_bs_currency), count($arr_bs_amount)])) > 1){
        $error = true;
        $err_msg = "Mismatched number of banner types, currencies, and amounts.";
    } else {
        $banner_cnt = count($arr_bs_banner_type);
        $_POST['hdnbanner_cnt'] = $banner_cnt;
    }

    if($position_id == "") { $error = true; $err_msg .= "<br>Please Select Position."; }
    if($bs_width == "") { $error = true; $err_msg .= "<br>Please Enter Width."; }
    if($bs_height == "") { $error = true; $err_msg .= "<br>Please Enter Height."; }

    for($i=0;$i<$banner_cnt;$i++){
        if($arr_bs_currency[$i] == ""){ $error = true; $err_msg .= "<br>Please Select Currency."; }
        if($arr_bs_amount[$i] == ""){ $error = true; $err_msg .= "<br>Please Enter Amount."; }
    }

    if(!$error){
        $bs_effective_date = date('Y-m-d', strtotime($bs_effective_date));
        if($obj->updateBannerSizeMaster($bs_id, $position_id, $bs_width, $bs_height, $arr_bs_banner_type, $arr_bs_currency, $arr_bs_amount, $bs_effective_date, $bs_remarks, $admin_id)){
            $msg = "Record Updated Successfully!";
            header('location: index.php?mode=banner_size_master&msg='.urlencode($msg));
            exit;
        } else {
            $error = true;
            $err_msg = "Currently there is some problem. Please try again later.";
        }
    }
} 
else
{
    // Load existing data for editing
    $position_id = $banner_data['position_id'];
    $bs_width = $banner_data['bs_width'];
    $bs_height = $banner_data['bs_height'];
    $bs_effective_date = date('d-m-Y', strtotime($banner_data['bs_effective_date']));
    $bs_remarks = $banner_data['bs_remarks'];

    $arr_bs_banner_type = [
        '0' => [
            'bs_banner_type' => $banner_data['bs_banner_type'],
            'bs_currency' => $banner_data['bs_currency'],
            'bs_amount' => $banner_data['bs_amount']
        ],
    ];
    $arr_bs_currency = $banner_data['currency'];       // array
    $arr_bs_amount = $banner_data['amount'];           // array
    if(is_array($arr_bs_banner_type)){
        $banner_totalRow = count($arr_bs_banner_type) ?? [];
    }else{
        $banner_totalRow = 0;
    }
    
    $banner_cnt = $banner_totalRow;
}

// HTML / JS for dynamic rows
$tr_row = '';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td width="30%" align="right"><strong>Banner Type</strong></td><td width="5%" align="center"><strong>:</strong></td><td width="65%" align="left"><select name="bs_banner_type[]" id="bs_banner_type_\'+banner_cnt+\'" onChange="BannerBox(\'+banner_cnt+\')"><option value="Image">Image</option><option value="Flash">Flash</option><option value="Video">Video</option><option value="Google Ads">Google Ads</option></select></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td align="right" valign="top"><strong>Currency</strong></td><td align="center" valign="top"><strong>:</strong></td><td align="left"><select name="bs_currency[]" id="bs_currency_\'+banner_cnt+\'" style="width:200px;"><option value="">Select Currency</option>'.$obj->getCurrencyOptions('').'</select></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td align="right" valign="top"><strong>Amount</strong></td><td align="center" valign="top"><strong>:</strong></td><td align="left"><input type="text" name="bs_amount[]" id="bs_amount_\'+banner_cnt+\'" value="" /></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td align="right"><strong></strong></td><td align="center"><strong></strong></td><td align="left"><input type="button" value="Remove Item" id="tr_banner_\'+banner_cnt+\'" name="tr_banner_\'+banner_cnt+\'" onclick="removeBannerRowMulti(\'+banner_cnt+\')" /></td></tr>';
$tr_row .= '<tr class="tr_banner_row_\'+banner_cnt+\'"><td colspan="3" align="center">&nbsp;</td></tr>';
?>

<script src="js/AC_ActiveX.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript"> 
$(document).ready(function() {
    $('#addMoreBanners').click(function() {
        var banner_cnt = parseInt($('#hdnbanner_cnt').val());
        var banner_totalRow = parseInt($('#hdnbanner_totalRow').val());
        $('#add_before_this_Banner').before('<?php echo $tr_row;?>');	
        banner_cnt++;
        $('#hdnbanner_cnt').val(banner_cnt);
        banner_totalRow++;
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
    <?php } ?>
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Banner Size Master</td>
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
                                <input type="hidden" name="hdnbanner_cnt" id="hdnbanner_cnt" value="<?php echo $banner_cnt;?>" />
                                <input type="hidden" name="hdnbanner_totalRow" id="hdnbanner_totalRow" value="<?php echo $banner_totalRow;?>" />
                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblbanner">
                                <tbody>
                                    <tr>
                                        <td width="30%" align="right"><strong>Position</strong></td>
                                        <td width="5%" align="center"><strong>:</strong></td>
                                        <td width="65%" align="left">
                                            <select id="position_id" name="position_id" onChange="getHeightAndWidthBS()">
                                                <option value="">Select Position </option>
                                                <?php echo $obj->getPositions($position_id); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr><td colspan="3">&nbsp;</td></tr>
                                    <tr>
                                        <td align="right"><strong>Width</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><input type="text" name="bs_width" id="bs_width" value="<?php echo $bs_width;?>" ></td>
                                    </tr>
                                    <tr><td colspan="3">&nbsp;</td></tr>
                                    <tr>
                                        <td align="right"><strong>Height</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><input type="text" name="bs_height" id="bs_height" value="<?php echo $bs_height; ?>" ></td>
                                    </tr>
                                    <tr><td colspan="3">&nbsp;</td></tr>

                                    <?php
                                    // Render existing banner rows
                                    for($i=0;$i<$banner_totalRow;$i++){  ?>    
                                        <tr class="tr_banner_row_<?php echo $i;?>">
                                            <td align="right"><strong>Banner Type</strong></td>
                                            <td align="center"><strong>:</strong></td>
                                            <td align="left">
                                                <select name="bs_banner_type[]" id="bs_banner_type_<?php echo $i; ?>">
                                                    <option value="Image" <?php if($arr_bs_banner_type[$i]['bs_banner_type'] == 'Image'){ echo 'selected'; } ?>>Image</option>
                                                    <option value="Flash" <?php if($arr_bs_banner_type[$i]['bs_banner_type'] == 'Flash'){ echo 'selected'; } ?>>Flash</option>
                                                    <option value="Video" <?php if($arr_bs_banner_type[$i]['bs_banner_type'] == 'Video'){ echo 'selected'; } ?>>Video</option>
                                                    <option value="Google Ads" <?php if($arr_bs_banner_type[$i]['bs_banner_type'] == 'Google Ads'){ echo 'selected'; } ?>>Google Ads</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td colspan="3">&nbsp;</td></tr>
                                        <tr class="tr_banner_row_<?php echo $i;?>">
                                            <td align="right" valign="top"><strong>Currency</strong></td>
                                            <td align="center" valign="top"><strong>:</strong></td>
                                            <td align="left">
                                                <select name="bs_currency[]" id="bs_currency_<?php echo $i; ?>" style="width:200px;">
                                                    <option value="">Select Currency</option>
                                                    <?php echo $obj->getCurrencyOptions($arr_bs_banner_type[$i]['bs_currency']); ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td colspan="3">&nbsp;</td></tr>
                                        <tr class="tr_banner_row_<?php echo $i;?>">
                                            <td align="right" valign="top"><strong>Amount</strong></td>
                                            <td align="center" valign="top"><strong>:</strong></td>
                                            <td align="left">
                                                <input type="text" name="bs_amount[]" id="bs_amount_<?php echo $i; ?>" value="<?php echo $arr_bs_banner_type[$i]['bs_amount'];?>"  >
                                            </td>
                                        </tr>
                                        <tr><td colspan="3">&nbsp;</td></tr>
                                        <?php if($i > 0){ ?>
                                        <tr class="tr_banner_row_<?php echo $i;?>">
                                            <td align="right">&nbsp;</td>
                                            <td align="center">&nbsp;</td>
                                            <td align="left">
                                                <input type="button" value="Remove Item" id="tr_banner_<?php echo $i; ?>" name="tr_banner_<?php echo $i; ?>" onclick="removeBannerRowMulti('<?php echo $i;?>')" />
                                            </td>
                                        </tr>
                                        <tr><td colspan="3">&nbsp;</td></tr>
                                        <?php } ?>
                                    <?php } ?>

                                    <!-- <tr id="add_before_this_Banner">
                                        <td align="right">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td align="left"><a href="javascript:void(0)" class="body_link" id="addMoreBanners">Add More Banner Type</a></td>
                                    </tr>	 -->
                                    <tr><td colspan="3">&nbsp;</td></tr>
                                    <tr>
                                        <td align="right"><strong>Effective Date</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <input type="text" name="bs_effective_date" id="bs_effective_date" value="<?php echo $bs_effective_date; ?>" >
                                            <script>$('#bs_effective_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                        </td>
                                    </tr>
                                    <tr><td colspan="3">&nbsp;</td></tr>
                                    <tr>
                                        <td align="right"><strong>Remarks</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><textarea name="bs_remarks" id="bs_remarks" style="width:200px;"><?php echo $bs_remarks; ?></textarea></td>
                                    </tr>
                                    <tr><td colspan="3">&nbsp;</td></tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="left">
                                            <input type="Submit" name="btnSubmit" value="Update" />&nbsp;
                                            <input type="button" name="btnPreview" value="Preview" />
                                        </td>
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
