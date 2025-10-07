<?php
require_once('config/class.mysql.php');
require_once('classes/class.solutions.php');  
$obj = new Solutions();

$view_action_id = '253';
$add_action_id = '254';
$ua_action_id = '261';
$bg_action_id = '262';

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

if(isset($_POST['search']))
{
    $search = strip_tags(trim($_POST['search']));
}
elseif(isset($_GET['search']))
{
    $search = urldecode(trim($_GET['search']));
}
else
{
    $search = '';
}

if(isset($_POST['sol_status']))
{
    $sol_status = trim($_POST['sol_status']);
}
elseif(isset($_GET['sol_status']))
{
    $sol_status = urldecode($_GET['sol_status']);
}
else
{
    $sol_status = '';
}

if(isset($_POST['start_date']))
{
    $start_date = trim($_POST['start_date']);
}
elseif(isset($_GET['start_date']))
{
    $start_date = urldecode($_GET['start_date']);
}
else
{
    $start_date = '';
}

if(isset($_POST['sol_cat_id']))
{
    $sol_cat_id = trim($_POST['sol_cat_id']);
}
elseif(isset($_GET['sol_cat_id']))
{
    $sol_cat_id = urldecode($_GET['sol_cat_id']);
}
else
{
    $sol_cat_id = '';
}

if(isset($_POST['sol_situation_id']))
{
    $sol_situation_id = trim($_POST['sol_situation_id']);
}
elseif(isset($_GET['sol_situation_id']))
{
    $sol_situation_id = urldecode($_GET['sol_situation_id']);
}
else
{
    $sol_situation_id = '';
}

if(isset($_POST['sol_add_date']))
{
    $sol_add_date = trim($_POST['sol_add_date']);
}
elseif(isset($_GET['sol_add_date']))
{
    $sol_add_date = urldecode($_GET['sol_add_date']);
}
else
{
    $sol_add_date = '';
}


if(isset($_POST['added_by_user']))
{
    $added_by_user = trim($_POST['added_by_user']);
}
elseif(isset($_GET['added_by_user']))
{
    $added_by_user = urldecode($_GET['added_by_user']);
}
else
{
    $added_by_user = '';
}

if(isset($_POST['sol_box_type']))
{
    $sol_box_type = trim($_POST['sol_box_type']);
}
elseif(isset($_GET['sol_box_type']))
{
    $sol_box_type = trim($_GET['sol_box_type']);
}
else 
{
    $sol_box_type = '';
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Wellness Solutions </td>
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
                                    <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                            <td align="left">
                                            <?php if($obj->chkValidActionPermission($admin_id,$bg_action_id)) { ?>    
                                        	<input type="button" name="btnSubmit1" value="Manage Background Music" onclick="window.location.href='index.php?mode=wellness_solution_bg_music';"/>	
                                            <?php } ?>
                                            
                                            <?php if($obj->chkValidActionPermission($admin_id,$ua_action_id)) { ?>        
                                                <input type="button" name="btnSubmit2" value="Manage User Area" onclick="window.location.href='index.php?mode=wellness_solution_user_area';"/>
                                            <?php } ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="10%" height="30" align="left" valign="middle"><strong>Date:</strong></td>
                                            <td width="10%" height="30" align="left" valign="middle">
                                                <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:80px;"  />
                                                <script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                            </td>
                                            <td width="10%" height="30" align="left" valign="middle">&nbsp;</td>
                                            <td width="10%" height="30" align="left" valign="middle"><strong>Category:</strong></td>
                                            <td width="15%" height="30" align="left" valign="middle">
                                                <select name="sol_cat_id" id="sol_cat_id" style="width:200px;">
                                                    <option value="" >All Categories</option>
                                                    <?php echo $obj->getSolutionCategoryOptions($sol_cat_id); ?>
                                                </select>
                                            </td>
                                            <td width="20%" height="30" align="left" valign="middle">&nbsp;</td>
                                            <td width="5%" height="30" align="left" valign="middle"><strong>Status:</strong></td>
                                            <td width="15%" height="30" align="left" valign="middle">
                                                <select name="sol_status" id="sol_status" style="width:200px;">
                                                    <option value="">All Status</option>
                                                    <option value="0" <?php if($sol_status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                                    <option value="1" <?php if($sol_status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td height="30" align="left" valign="middle"><strong>Added By:</strong></td>
                                            <td height="30" align="left" valign="middle">
                                                <select name="added_by_user" id="added_by_user" style="width:200px;">
                                                    <option value="" >All</option>
                                                    <option value="0" <?php if($added_by_user == '0'){?> selected="selected" <?php } ?>>Admin</option>
                                                    <option value="1" <?php if($added_by_user == '1'){?> selected="selected" <?php } ?>>User</option>
                                                </select>
                                            </td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td width="10%" height="30" align="left" valign="middle"><strong>Added Date:</strong></td>
                                            <td width="15%" height="30" align="left" valign="middle">
                                                <input name="sol_add_date" id="sol_add_date" type="text" value="<?php echo $sol_add_date;?>" style="width:80px;"  />
                                                <script>$('#sol_add_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                            </td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle"><strong>Item Type:</strong></td>
                                            <td height="30" align="left" valign="middle">
                                                <select name="sol_box_type" id="sol_box_type" style="width:200px;">
                                                    <option value="" >All Type</option>
                                                    <?php echo $obj->getSolutionItemTypeOptions($sol_box_type); ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td height="30" align="left" valign="middle"><strong>Situation:</strong></td>
                                            <td height="30" align="left" valign="middle">
                                                <select name="sol_situation_id" id="sol_situation_id" style="width:200px;">
                                                    <option value="" >All Situation</option>
                                                    <?php echo $obj->getSolutionTriggersOptions($sol_situation_id); ?>
                                                </select>
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
                                        <td colspan="18" align="right" nowrap="nowrap">
                                        <?php if($obj->chkValidActionPermission($admin_id,$add_action_id)) { ?>
                                            <a href="index.php?mode=add_wellness_solution"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
                                        <?php } ?>
                                    	</td>
                                    </tr>
                                    <tr class="manage-header">
                                        <td class="manage-header" align="center" width="5%">S.No.</td>
                                        <td class="manage-header" align="center" width="10%">Situation/Trigger</td>
                                        <td class="manage-header" align="center" width="5%">Category</td>
                                        <td class="manage-header" align="center" width="5%">Min Rating</td>
                                        <td class="manage-header" align="center" width="5%">Max Rating</td>
                                        <td class="manage-header" align="center" width="5%">Criteria</td>
                                        <td class="manage-header" align="center" width="5%">Criteria Scale</td>
                                        <td class="manage-header" align="center" width="5%">Date Type</td>
                                        <td class="manage-header" align="center" width="10%">Date</td>
                                        <td class="manage-header" align="center" width="5%">Item Title</td>
                                        <td class="manage-header" align="center" width="5%">Item Type</td>
                                        <td class="manage-header" align="center" width="10%">Item</td>
                                        <td class="manage-header" align="center" width="10%">Description</td>
                                        <td class="manage-header" align="center" width="5%">Status</td>
                                        <td class="manage-header" align="center" width="5%">Added By</td>
                                        <td class="manage-header" align="center" width="5%">Add Date</td>
                                        <td width="5%" align="center" nowrap="nowrap" class="manage-header">Edit</td>
                                        <td width="5%" align="center" nowrap="nowrap" class="manage-header">Delete</td>
                                    </tr>
                                    <?php
                                    echo $obj->GetAllSolutionsList($search,$sol_status,$sol_cat_id,$start_date,$sol_situation_id,$added_by_user,$sol_add_date,$sol_box_type);
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