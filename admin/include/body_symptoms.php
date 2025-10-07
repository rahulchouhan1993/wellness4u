<?php
require_once('config/class.mysql.php');
require_once('classes/class.bodyparts.php');

$obj = new BodyParts();

$add_action_id = '224';
$view_action_id = '223';

if(!$obj->isAdminLoggedIn())
{
    header("Location: index.php?mode=login");
    exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$view_action_id))
{	
    header("Location: index.php?mode=invalid");
    exit(0);
}

if(isset($_POST['btnSubmit']))
{
    $bms_id = trim($_POST['bms_id']);
    $bp_status = trim($_POST['bp_status']);
    $bp_id = trim($_POST['bp_id']);
    
}
else
{
    $bms_id = '';
    $bp_status = '';
    $bp_id = '';
}
?>
<div id="central_part_contents">
    <div id="notification_contents"><!--notification_contents--></div>	  
    <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td>
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
                        <td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Body Symptoms</td>
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
                            <p class="err_msg"><?php if(isset($_GET['msg']) && $_GET['msg'] != '' ) { echo urldecode($_GET['msg']); }?></p>
                            <div id="pagination_contents" align="center"> 
                                <form action="#" method="post" name="frm_place" id="frm_place" enctype="multipart/form-data" >
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="10%" height="30" align="left" valign="middle"><strong>Body Part:</strong></td>
                                            <td width="10%" height="30" align="left" valign="middle">
                                                <select name="bp_id" id="bp_id" style="width:200px;">
                                                    <option value="" >All Parts</option>
                                                    <?php echo $obj->getAllBodyPartsOptions($bp_id, '0');?>
                                                </select>
                                            </td>
                                            <td width="10%" height="30" align="left" valign="middle">&nbsp;</td>
                                            <td width="10%" height="30" align="left" valign="middle"><strong>Symptoms:</strong></td>
                                            <td width="15%" height="30" align="left" valign="middle">
                                                <select name="bms_id" id="bms_id" style="width:200px;">
                                                    <option value="" >All Symptoms</option>
                                                    <?php echo $obj->getMainSymptomOptions($bms_id); ?>
                                                </select>
                                            </td>
                                            <td width="20%" height="30" align="left" valign="middle">&nbsp;</td>
                                            <td width="5%" height="30" align="left" valign="middle"><strong>Status:</strong></td>
                                            <td width="15%" height="30" align="left" valign="middle">
                                                <select name="bs_status" id="bs_status" style="width:200px;">
                                                    <option value="">All Status</option>
                                                    <option value="0" <?php if($bs_status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                                    <option value="1" <?php if($bs_status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle">
                                                
                                            </td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td colspan="2" height="30" align="left" valign="middle">
                                                <input type="submit" name="btnSubmit" id="btnSubmit" value="Search" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </form>
                                <table border="0" width="100%" cellpadding="1" cellspacing="1">
                                <tbody>
                                    <tr>
                                        <td colspan="10" align="right">
                                        <?php 
                                        if($obj->chkValidActionPermission($admin_id,$add_action_id))
                                        { ?>
                                            <a href="index.php?mode=add_body_symptom"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
                                        <?php 
                                        } ?>
                                        </td>
                                    </tr>
                                    <tr class="manage-header">
                                        <td width="5%" class="manage-header" align="center" >S.No.</td>
                                        <td width="20%" class="manage-header" align="center">Symptom</td>
                                        <td width="20%" class="manage-header" align="center">Body Part</td>
                                        <td width="10%" class="manage-header" align="center">Side</td>
                                        <td width="10%" class="manage-header" align="center">Gender</td>
                                        <td width="10%" class="manage-header" align="center">Status</td>
                                        <td width="15%" class="manage-header" align="center">Image</td>
                                        <td width="10%" class="manage-header" align="center">Added Date</td>
                                        <td width="5%" class="manage-header" align="center">Edit</td>
                                        <td width="5%" class="manage-header" align="center">Delete</td>
                                    </tr>
                                    <?php
                                    echo $obj->getAllBodySymptoms($bms_id,$bs_status,$bp_id);
                                    ?>
                                </tbody>
                                </table>
                                <p></p>
                                <!--pagination_contents-->
                            </div>
                            <p></p>
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