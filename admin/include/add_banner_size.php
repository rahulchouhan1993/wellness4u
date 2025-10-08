<?php
require_once('config/class.mysql.php');
require_once('classes/class.banner.php');  
require_once('classes/class.places.php');

$obj = new Banner();
$obj2 = new Places();

$add_action_id = '285';

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

$banner_cnt = '1';
$banner_totalRow = '1';

if(isset($_POST['btnSubmit'])){   
    
    $bs_width = $_POST['bs_width'];
    $bs_height = $_POST['bs_height'];
    $bs_remarks = $_POST['bs_remarks'];
    $bs_status = $_POST['bs_status'] ?? 0;
    $banner_totalRow = trim($_POST['hdnbanner_totalRow']);  
    $banner_cnt = count($_POST['bs_width']);
    $_POST['hdnbanner_cnt'] = $banner_cnt;
    $arr_bs_banner_type = $_POST['bs_width'];
    if($bs_width == ""){
        $error = true;
        $err_msg .= "<br>Please Enter Width.";
    }
    
    if($bs_height == ""){
        $error = true;
        $err_msg .= "<br>Please Enter Height.";
    }

    if(!$error){
        if($obj->addBannerSizeMaster('',$bs_width,$bs_height,$arr_bs_banner_type,'','','',$bs_remarks,$admin_id,$bs_status)){
            $msg = "Record Added Successfully!";
            header('location: index.php?mode=banner_size_master&msg='.urlencode($msg));
            exit;
        }else{
            $error = true;
            $err_msg = "Currently there is some problem.Please try again later.";
        }
    }
}else{
    $bs_width = '';
    $bs_height = '';
    $bs_remarks = '';
}
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8" />
    <title>Add Banner Size Master</title>


<!-- jQuery + datepick (same plugin you used previously) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/AC_ActiveX.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="js/jquery.datepick.js" type="text/javascript"></script>
<link rel="stylesheet" href="js/jquery.datepick.css" type="text/css" />

<style>
    /* keep minimal styling similar to original layout */
    .spacer { height:12px; }
</style>


</head>
<body>

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
                            <td><img src="images/notification_icon_e.gif" alt="" width="12" height="10"></td>
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
                    <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Banner Size Master</td>
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
                        <!-- MAIN FORM: keep names and IDs exactly as original -->
                        <form action="#" method="post" name="frmadd_my_relation" id="frmadd_my_relation" enctype="multipart/form-data" >
                            <input type="hidden" name="hdnbanner_cnt" id="hdnbanner_cnt" value="<?php echo $banner_cnt;?>" />
                            <input type="hidden" name="hdnbanner_totalRow" id="hdnbanner_totalRow" value="<?php echo $banner_totalRow;?>" />
                            <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblbanner">
                            <tbody>
                               
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right"><strong>Width</strong></td>
                                    <td align="center"><strong>:</strong></td>
                                    <td align="left"><input type="text" name="bs_width[]" id="bs_width" value="<?php echo $bs_width[$i];?>" required ></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td align="right"><strong>Height</strong></td>
                                    <td align="center"><strong>:</strong></td>
                                    <td align="left"><input type="text" name="bs_height[]" id="bs_height" value="<?php echo $bs_height[$i]; ?>" required></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>

                            
                                
                                <tr>
                                    <td align="right"><strong>Remarks</strong></td>
                                    <td align="center"><strong>:</strong></td>
                                    <td align="left"><textarea required name="bs_remarks[]" id="bs_remarks" style="width:200px;"><?php echo $bs_remarks; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right"><strong>Status</strong></td>
                                    <td align="center"><strong>:</strong></td>
                                    <td align="left">
                                        <select name="bs_status[]" id="status<?php echo $i; ?>">
                                            <option value="0" <?php if($bs_status == '0'){ ?> selected <?php } ?>>Inactive</option>
                                            <option value="1" <?php if($bs_status == '1'){ ?> selected <?php } ?>>Active</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr id="add_before_this_Banner">
                                    <td align="right" valign="top">&nbsp;</td>
                                    <td align="center" valign="top">&nbsp;</td>
                                    <td align="left" valign="top"><a href="javascript:void(0)" target="_self" class="body_link" id="addMoreBanners">Add More Banner Type</a></td>
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
                                    <td align="left">
                                        <input type="Submit" name="btnSubmit" value="Submit" />&nbsp;
                                        <input type="button" name="btnPreview" value="Preview" />
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                        </form>

                       
                        <div id="banner_template" style="display:none;">
                            <table>
                                
                                <tr class="tr_banner_row___INDEX__"><td colspan="3" align="center">&nbsp;</td></tr>

                                <tr class="tr_banner_row___INDEX__">
                                    <td align="right"><strong>Width</strong></td>
                                    <td align="center"><strong>:</strong></td>
                                    <td align="left"><input type="text" name="bs_width[]" id="bs_width___INDEX__" value="" ></td>
                                </tr>
                                <tr class="tr_banner_row___INDEX__"><td colspan="3" align="center">&nbsp;</td></tr>

                                <tr class="tr_banner_row___INDEX__">
                                    <td align="right"><strong>Height</strong></td>
                                    <td align="center"><strong>:</strong></td>
                                    <td align="left"><input type="text" name="bs_height[]" id="bs_height___INDEX__" value="" ></td>
                                </tr>
                                <tr class="tr_banner_row___INDEX__"><td colspan="3" align="center">&nbsp;</td></tr>

                               

                                <tr class="tr_banner_row___INDEX__">
                                    <td align="right"><strong>Remarks</strong></td>
                                    <td align="center"><strong>:</strong></td>
                                    <td align="left"><textarea name="bs_remarks[]" id="bs_remarks___INDEX__" style="width:200px;"></textarea></td>
                                </tr>
                                <tr class="tr_banner_row___INDEX__"><td colspan="3" align="center">&nbsp;</td></tr>

                                <tr class="tr_banner_row___INDEX__">
                                    <td align="right"><strong>Status</strong></td>
                                    <td align="center"><strong>:</strong></td>
                                    <td align="left">
                                        <select name="bs_status[]" id="bs_status___INDEX__" style="width:200px;">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="tr_banner_row___INDEX__"><td colspan="3" align="center">&nbsp;</td></tr>

                                <tr class="tr_banner_row___INDEX__">
                                    <td align="right">&nbsp;</td>
                                    <td align="center">&nbsp;</td>
                                    <td align="left"><input type="button" value="Remove Item" onclick="removeBannerRowMulti(__INDEX__)" /></td>
                                </tr>
                                <tr class="tr_banner_row___INDEX__"><td colspan="3" align="center">&nbsp;</td></tr>
                            </table>
                        </div>
                        <!-- end template -->

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

<script type="text/javascript">
/*
 Behavior:
 - Clicking "Add More Banner Type" clones a full block (Position → Remarks).
 - Cloned elements keep the same 'name' attributes as originals (so server-side PHP remains unchanged).
 - IDs of cloned elements get a numeric suffix so they are unique in DOM.
 - After insertion, the script copies the current main values (position, width, height, banner-type[0], currency[0], amount[0], effective date, remarks)
   into the newly added block so it behaves like a "clone" of current values.
 - Datepicker is initialized on new effective-date inputs if the plugin is available.
*/

function removeBannerRowMulti(index) {
    $('.tr_banner_row_' + index).remove();
}

$(document).ready(function() {

    // initialize datepicker on the main effective date field (if plugin available)
    if (typeof $.fn.datepick === 'function') {
        $('#bs_effective_date').datepick({ dateFormat : 'dd-mm-yy' });
    }

    $('#addMoreBanners').click(function() {
        var banner_cnt = parseInt($('#hdnbanner_cnt').val(), 10);
        var banner_totalRow = parseInt($('#hdnbanner_totalRow').val(), 10);

        // get template HTML and replace placeholder __INDEX__ with banner_cnt
        var tpl = '<tr><td colspan="100%"><div style="margin: 10px 0; height: 2px; background-color: #ccc;"></div></td></tr>';
        tpl += $('#banner_template').html();

        // Remove <table> and <tbody> tags
        tpl = tpl.replace(/<\/?table[^>]*>/gi, '').replace(/<\/?tbody[^>]*>/gi, '');

        // Replace index placeholders
        var html = tpl.replace(/__INDEX__/g, banner_cnt);

        // Convert string to jQuery object
        var $html = $('<tbody>').html(html);

        // Clear all text inputs and textareas
        $html.find('input[type="text"], textarea').val('');

        // Reset all selects
        $html.find('select').prop('selectedIndex', 0);

        // OPTIONAL: remove IDs to prevent duplicates
        $html.find('[id]').each(function() {
            $(this).removeAttr('id');
        });

        // Append cleaned HTML
        $('#add_before_this_Banner').before($html.html());

        // Copy values from main inputs if needed (optional)
        // ... your existing try/catch copy logic can go here

        // Update counters
        banner_cnt++;
        $('#hdnbanner_cnt').val(banner_cnt);
        banner_totalRow++;
        $('#hdnbanner_totalRow').val(banner_totalRow);
    });

});
</script>

</body>
</html>
