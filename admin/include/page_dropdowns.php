<?php
require_once('config/class.mysql.php');
require_once('classes/class.contents.php');
$obj = new Contents();
$allFilterOption = $obj->getPageDropdownFilters();
$view_action_id = '247';
$add_action_id = '248';

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
    $status = strip_tags(trim($_POST['status']));
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Page Dropdowns</td>
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
                            <form>
                                <input type="hidden" name="mode" value="page_dropdowns">
                                <label>Page:</label>
                                <select name="page">
                                    <option value="">Select</option>
                                    <?php foreach(array_filter($allFilterOption['page']) as $k =>$v){ ?>
                                        <option value="<?php echo $k ?>" <?php if($_GET['page']==$k) echo 'selected'; ?>><?php echo $v?></option>
                                    <?php } ?>
                                </select>

                                <label>Status:</label>
                                <select name="status">
                                    <option value="">Select</option>
                                    <?php foreach(array_filter($allFilterOption['status']) as $k =>$v){ ?>
                                        <option value="<?php echo $k ?>" <?php if($_GET['status']==$k) echo 'selected'; ?>><?php echo $v?></option>
                                    <?php } ?>
                                </select>

                                

                                <label>Added by:</label>
                                <select name="added">
                                    <option value="">Select</option>
                                    <?php foreach(array_filter($allFilterOption['added']) as $k =>$v){ ?>
                                        <option value="<?php echo $k ?>" <?php if($_GET['added']==$k) echo 'selected'; ?>><?php echo $v?></option>
                                    <?php } ?>
                                </select>

                                <label>Modified by:</label>
                                <select name="modified">
                                    <option value="">Select</option>
                                    <?php foreach(array_filter($allFilterOption['modified']) as $k =>$v){ ?>
                                        <option value="<?php echo $k ?>" <?php if($_GET['modified']==$k) echo 'selected'; ?>><?php echo $v?></option>
                                    <?php } ?>
                                </select>

                                <button type="submit">Filter</button>
                            </form> 
                            
                            <div id="pagination_contents" align="center"> 
                                <p></p>
                                
                            
                                <table border="1" width="100%" cellpadding="1" cellspacing="1">
                                <tbody>
                                    <tr>
                                        <td colspan="8" align="right">
                                        <?php 
                                        if($obj->chkValidActionPermission($admin_id,$add_action_id))
                                        { ?>
                                            <a href="index.php?mode=add_page_dropdown"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
                                        <?php 
                                        } ?>
                                        </td>
                                    </tr>
                                    <tr class="manage-header">
                                        <td width="5%" class="manage-header" align="center" >S.No.</td>
                                        <td width="5%" class="manage-header" align="center">Edit</td>
                                        <td width="5%" class="manage-header" align="center">Delete</td>
                                        <td width="10%" class="manage-header" align="center">Status</td>
                                        <td width="20%" class="manage-header" align="center">Function Name</td>
                                        <td width="20%" class="manage-header" align="center">Admin Notes</td>
                                        <td width="20%" class="manage-header" align="center">Admin </td>
                                         <td width="20%" class="manage-header" align="center"> Pages</td>
                                        <td width="5%" class="manage-header" align="center">Added Date</td>
                                        <td width="10%" class="manage-header" align="center">Added By Admin</td>
                                        <td width="5%" class="manage-header" align="center">Modified Date</td>
                                        <td width="10%" class="manage-header" align="center">Modified By</td>
                                        
                                    </tr>
                                    <?php
                                    echo $obj->getAllPageDropdowns($search,$status,$_GET);
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