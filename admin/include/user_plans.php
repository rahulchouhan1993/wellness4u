<?php
require_once('config/class.mysql.php');
require_once('classes/class.subscriptions.php');  
require_once('classes/class.places.php');

$obj = new Subscriptions();
$obj2 = new Places();

$add_action_id = '191';
$view_action_id = '190';

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

$trlocation = 'none';

$arr_state_id = array();
$arr_city_id = array();
$arr_place_id = array();

if(isset($_POST['btnSubmit']))
{
    $search = strip_tags(trim($_POST['search']));
    $upct_id = trim($_POST['upct_id']);
    $status = strip_tags(trim($_POST['status']));
    

}
else
{
    $search = '';
    $upct_id = '';
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage User Subscriptions </td>
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
                                <p>
                                <form action="#" method="post" name="frm_dailymeal" id="frm_dailymeal" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>Search:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="text" id="search" name="search"  value="<?php echo $search; ?>" style="width:200px;" />
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>Category:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="upct_id" id="upct_id" style="width:200px;">
                                                <option value="">All</option>
                                                <?php echo $obj->getUserPlansCategoryTypeOptions($upct_id); ?>
                                            </select>
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>Status:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="status" id="status" style="width:200px;">
                                                <option value="">All Status</option>
                                                <option value="0" <?php if($status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                                <option value="1" <?php if($status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center" height="30">
                                            <input type="submit" name="btnSubmit" id="btnSubmit" value="Search" />
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                                 </form>
                                </p>
                                <table border="1" width="100%" cellpadding="1" cellspacing="1">
                                <tbody>
                                    <tr>
                                        <td colspan="16" align="right" nowrap="nowrap">
                                        <?php 
                                        if($obj->chkValidActionPermission($admin_id,$add_action_id))
                                        { ?>
                                            <a href="index.php?mode=add_user_plan"><img src="images/add.gif" width="10" height="8" border="0" />Add New Plan</a>
                                        <?php 
                                        } ?>     
                                        </td>
                                    </tr>
                                    <tr class="manage-header">
                                        <td class="manage-header" align="center" nowrap="nowrap" >S.No.</td>
                                        <td  align="center" nowrap="nowrap" class="manage-header">Delete</td>
                                        <td align="center" nowrap="nowrap" class="manage-header">Edit</td>
                                        <td class="manage-header" align="center">Added Date</td>
                                        <td class="manage-header" align="center" >Added By</td>
                                        <td class="manage-header" align="center" >Status</td>
                                        <td class="manage-header" align="center" >Plan Name</td>
                                        <td class="manage-header" align="center" >Amount</td>
                                        <td class="manage-header" align="center" >Currency</td>
                                        <td class="manage-header" align="center">Duration</td>
                                        <td class="manage-header" align="center">Show in List</td>
                                        <td class="manage-header" align="center" >Default Plan</td>
                                        <td class="manage-header" align="center" >Category</td>
                                        <td class="manage-header" align="center" >Admin Notes</td>
                                        <td class="manage-header" align="center" >Narration</td>
                                        <td class="manage-header" align="center">Schedule</td>
                                        
                                    </tr>
                                    <?php
                                    echo $obj->GetAllUserPlans($search,$upct_id,$status);
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