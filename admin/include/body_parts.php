<?php
require_once('config/class.mysql.php');
require_once('classes/class.bodyparts.php');

$obj = new BodyParts();

$add_action_id = '219';
$view_action_id = '220';

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
    $bp_side = trim($_POST['bp_side']);
    $search = strip_tags(trim($_POST['search']));
    $bp_status = strip_tags(trim($_POST['bp_status']));
    $bp_sex = trim($_POST['bp_sex']);
    //$bp_parent_id = trim($_POST['bp_parent_id']);
    $bp_parent_id = '';
}
else
{
    $bp_side = '';
    $search = '';
    $bp_status = '';
    $bp_sex = '';
    $bp_parent_id = '';
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Body Parts</td>
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
                                <form action="#" method="post" name="frm_place" id="frm_place" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="6%" height="30" align="left" valign="middle"><strong>Side:</strong></td>
                                            <td width="14%" height="30" align="left" valign="middle">
                                                <select name="bp_side" id="bp_side" style="width:200px;">
                                                    <option value="" <?php if($bp_side == ''){?> selected <?php } ?>>All Sides</option>
                                                    <option value="1" <?php if($bp_side == '1'){?> selected <?php } ?>>Front Side</option>
                                                    <option value="0" <?php if($bp_side == '0'){?> selected <?php } ?>>Back Side</option>
                                                </select>
                                            </td>
                                            <td width="10%" height="30" align="left" valign="middle">&nbsp;</td>
                                            <td width="10%" height="30" align="left" valign="middle"><strong>Body Name:</strong></td>
                                            <td width="15%" height="30" align="left" valign="middle">
                                                <input type="text" name="search" id="search" value="<?php echo $search;?>" style="width:200px;"  />
                                            </td>
                                            <td width="20%" height="30" align="left" valign="middle">&nbsp;</td>
                                            <td width="5%" height="30" align="left" valign="middle"><strong>Status:</strong></td>
                                            <td width="15%" height="30" align="left" valign="middle">
                                                <select name="bp_status" id="bp_status" style="width:200px;">
                                                    <option value="">All Status</option>
                                                    <option value="0" <?php if($bp_status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                                    <option value="1" <?php if($bp_status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td height="30" align="left" valign="middle"><strong>Gender:</strong></td>
                                            <td height="30" align="left" valign="middle">
                                                <select name="bp_sex" id="bp_sex" style="width:200px;">
                                                    <option value="" <?php if($bp_sex == ''){?> selected <?php } ?>>All Gender</option>
                                                    <option value="1" <?php if($bp_sex == '1'){?> selected <?php } ?>>Male</option>
                                                    <option value="0" <?php if($bp_sex == '0'){?> selected <?php } ?>>Female</option>
                                                </select>
                                            </td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <?php
                                            /*
                                            <td height="30" align="left" valign="middle"><strong>Main Body Part:</strong></td>
                                            <td height="30" align="left" valign="middle">
                                                <select name="bp_parent_id" id="bp_parent_id" style="width:200px;">
                                                    <option value="" >All Parts</option>
                                                    <?php echo $obj->getMainBodyPartsOptions($bp_parent_id,'0'); ?>
                                                </select>
                                            </td>
                                             * 
                                             */
                                            ?>
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
                                            <a href="index.php?mode=add_body_part"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
                                        <?php 
                                        } ?>
                                        </td>
                                    </tr>
                                    <tr class="manage-header">
                                        <td width="5%" class="manage-header" align="center" >S.No.</td>
                                        <td width="20%" class="manage-header" align="center">Body Part</td>
                                        <td width="10%" class="manage-header" align="center">Side</td>
                                        <td width="10%" class="manage-header" align="center">Gender</td>
                                        <?php //<td width="10%" class="manage-header" align="center">Main Part</td> ?>
                                        <td width="10%" class="manage-header" align="center">Status</td>
                                        <td width="15%" class="manage-header" align="center">Image</td>
                                        <td width="10%" class="manage-header" align="center">Added Date</td>
                                        <td width="5%" class="manage-header" align="center">Edit</td>
                                        <td width="5%" class="manage-header" align="center">Delete</td>
                                    </tr>
                                    <?php
                                    echo $obj->getAllBodyParts($search,$bp_status,$bp_side,$bp_sex,$bp_parent_id);
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