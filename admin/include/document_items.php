<?php
require_once('config/class.mysql.php');
require_once('classes/class.banner.php');  
require_once('classes/class.places.php');

$obj = new Banner();
$obj2 = new Places();

$add_action_id = '244';
$view_action_id = '243';

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
    $banner_cont_id = $_GET['id'];
    $search = strip_tags(trim($_POST['search']));
    $status = strip_tags(trim($_POST['status']));
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
    $search = '';
    $status = '';
    header('location: index.php?mode=document_master');	
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Document Items</td>
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
                                <p></p>
                                <form action="#" method="post" name="frm_place" id="frm_place" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                    
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="6%" height="30" align="left" valign="middle"><strong>Search:</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle">
                                            <input type="text" name="search" id="search" value="<?php echo $search;?>" style="width:200px;"  />
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Status:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                           <select name="status" id="status" style="width:200px;">
                                                <option value="">All Status</option>
                                                <option value="0" <?php if($status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                                <option value="1" <?php if($status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                            </select>
                                        </td>
                                        <td width="20%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="5%" height="30" align="left" valign="middle">&nbsp;</td>
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
                            
                                <table border="0" width="100%" cellpadding="1" cellspacing="1">
                                <tbody>
                                    <tr>
                                        <td colspan="14" align="right">
                                        <?php 
                                        if($obj->chkValidActionPermission($admin_id,$add_action_id))
                                        { ?>
                                            <a href="index.php?mode=add_document_item&id=<?php echo $banner_cont_id;?>"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
                                        <?php 
                                        } ?>
                                        </td>
                                    </tr>
                                    <tr class="manage-header">
                                        <td width="5%" class="manage-header" align="center" >S.No.</td>
                                        <td width="10%" class="manage-header" align="center">Page Name</td>
                                        <td width="10%" class="manage-header" align="center">Position</td>
                                        <td width="5%" class="manage-header" align="center">Width</td>
                                        <td width="5%" class="manage-header" align="center">Height</td>
                                        <td width="5%" class="manage-header" align="center">Banner Type</td>
                                        <td width="10%" class="manage-header" align="center">Upload(File name)</td>
                                        <td width="10%" class="manage-header" align="center">Url</td>
                                        <td width="10%" class="manage-header" align="center">Display Option</td>
                                        <td width="5%" class="manage-header" align="center">Status</td>
                                        <td width="5%" class="manage-header" align="center">Added Date</td>
                                        <td width="10%" class="manage-header" align="center">Added By Admin</td>
                                        <td width="5%" class="manage-header" align="center">Edit</td>
                                        <td width="5%" class="manage-header" align="center">Delete</td>
                                    </tr>
                                    <?php
                                    echo $obj->getAllBannerContractItems($banner_cont_id,$search,$status);
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