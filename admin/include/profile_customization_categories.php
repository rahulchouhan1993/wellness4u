<?php
require_once('config/class.mysql.php');
require_once('classes/class.profilecustomization.php');
$obj = new ProfileCustomization();

$view_action_id = '271';
$add_action_id = '272';

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
    $search = strip_tags(trim($_POST['search']));
    $status = trim($_POST['status']);
}
else 
{
    $search = '';
    $status = '';
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Categories</td>
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
                                <form action="#" method="post" name="frm_stressbuster" id="frm_stressbuster" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="10%" height="30" align="left" valign="middle"><strong>Status:</strong></td>
                                            <td width="10%" height="30" align="left" valign="middle">
                                                <select name="status" id="status" style="width:100px;">
                                                    <option value="">All Status</option>
                                                    <option value="0" <?php if($status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                                    <option value="1" <?php if($status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                                </select>
                                            </td>
                                            <td width="10%" height="30" align="left" valign="middle">&nbsp;</td>
                                            <td width="10%" height="30" align="left" valign="middle"><strong>Search:</strong></td>
                                            <td width="15%" height="30" align="left" valign="middle">
                                                <input type="text" id="search" name="search"  value="<?php echo $search; ?>" />
                                            </td>
                                            <td width="20%" height="30" align="left" valign="middle">&nbsp;</td>
                                            <td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                            <td width="15%" height="30" align="left" valign="middle">
                                                <input type="submit" name="btnSubmit" id="btnSubmit" value="Search" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </form>
                                <p></p>
                                <table border="1" width="100%" cellpadding="1" cellspacing="1">
                                <tbody>
                                    <tr>
                                        <td colspan="5" align="left">
                                        <?php if($obj->chkValidActionPermission($admin_id,$add_action_id)) {	 ?>
                                            <a href="index.php?mode=add_profile_customization_category"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
                                        <?php } ?>
                                        </td>
                                    </tr>
                                    <tr class="manage-header">
                                        <td width="10%" class="manage-header" align="center"><strong>S.No</strong></td>
                                        <td width="70%" class="manage-header" align="center"><strong>Category Name</strong></td>
                                        <td width="10%" class="manage-header" align="center"><strong>Status</strong></td>
                                        <td width="10%" class="manage-header" align="center"><strong>Edit</strong></td>
                                    </tr>
                                    <?php
                                    echo $obj->getAllProfileCustomizationCategories($search,$status);
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