<?php
require_once('config/class.mysql.php');
require_once('classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();
$allOptions = $obj->getScrollingWindowsOption();
$pageNameOptions = $obj->getPageNameOption();
$view_action_id = '150';
$add_action_id = '151';

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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Scrolling Windows</td>
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
                                <form action="#" method="get" name="frm_place">
                                    <input type="hidden" name="mode" value="scrolling_windows">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="20%" height="30" align="left" valign="middle"><strong>Page Name:</strong></td>
                                        <td width="10%" height="30" align="left" valign="middle">
                                        <select name="page_id" class="form-control">
                                                <option value="">--Select--</option>
                                            <?php 
                                                foreach($pageNameOptions as $k =>$v)
                                                {
                                                    if($k == $_GET['page_id']){
                                                        echo '<option value="'.$k.'" selected>'.stripslashes($v).'</option>';
                                                    }else{
                                                        echo '<option value="'.$k.'">'.stripslashes($v).'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="20%" height="30" align="left" valign="middle"><strong>Updated by:</strong></td>
                                        <td width="10%" height="30" align="left" valign="middle">
                                            <select name="updated_by" class="form-control">
                                                <option value="">--Select--</option>
                                                <?php 
                                                        foreach($allOptions as $row)
                                                        {
                                                            if($row['admin_id'] == $_GET['updated_by']){
                                                                echo '<option value="'.$row['admin_id'].'" selected>'.stripslashes($row['username']).'</option>';
                                                            }else{
                                                                echo '<option value="'.$row['admin_id'].'">'.stripslashes($row['username']).'</option>';
                                                            }
                                                        }
                                                     ?>
                                            </select>
                                        </td>
                                        
                                    </tr>

                                    <tr>
                                        <td width="20%" height="30" align="left" valign="middle"><strong>Window Header:</strong></td>
                                        <td width="10%" height="30" align="left" valign="middle">
                                            <input type="text" name="window_header" class="form-control" value="<?php echo stripslashes($_GET['window_header']); ?>">
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="20%" height="30" align="left" valign="middle"><strong>Window Footer:</strong></td>
                                        <td width="10%" height="30" align="left" valign="middle">
                                            <input type="text" name="window_footer" class="form-control" value="<?php echo stripslashes($_GET['window_footer']); ?>">
                                        </td>
                                        <td width="20%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="10%" height="30" align="left" valign="middle">
                                            <input type="submit" name="btnSubmit" id="btnSubmit" value="Filter">
                                        </td>
                                    </tr>
                                    
                                </tbody>
                                </table>
                                </form>
                                <table border="0" width="100%" cellpadding="1" cellspacing="1">
                                <tbody>
                                    <tr>
                                        <td colspan="12" align="right">
                                        <?php 
                                        if($obj->chkValidActionPermission($admin_id,$add_action_id))
                                        { ?>
                                            <a href="index.php?mode=add_scrolling_window"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
                                        <?php } ?>
                                        </td>
									</tr>
									<tr class="manage-header">
                                        <td width="5%" class="manage-header" align="center"><strong>S.No</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Edit</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Delete</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Added At</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Added By</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Updated At</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Updated By</strong></td>
                                        
                                        <td width="20%" class="manage-header" align="center"><strong>Page Name</strong></td>
                                        <td width="10%" class="manage-header" align="center"><strong>Window Header</strong></td>
                                        <td width="15%" class="manage-header" align="center"><strong>Header Image</strong></td>
                                        <td width="10%" class="manage-header" align="center"><strong>Window Footer</strong></td>
                                        <td width="10%" class="manage-header" align="center"><strong>Footer Image</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Show on</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Status</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>View Sliders</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Order</strong></td>
                                        
                                        
									</tr>
									<?php
									echo $obj->getAllScrollingWindows($_GET);
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
