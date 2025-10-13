<?php
require_once('config/class.mysql.php');
require_once('classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();

$sw_id = $_GET['id'];

$view_action_id = '154';
$add_action_id = '155';

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

$sw_header = $obj->getScollingWindowHeaderTitle($sw_id);
$pg_title = $obj->getScollingWindowPageTitle($sw_id);

if($sw_header == '')
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Scrolling Contents - <?php echo $sw_header;?> , Page - <?php echo $pg_title;?></td>
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
                                    <input type="hidden" name="mode" value="scrolling_contents">
									<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="20%" height="30" align="left" valign="middle"><strong>Title:</strong></td>
                                        <td width="10%" height="30" align="left" valign="middle">
							 <input type="text" name="window_header" class="form-control" value="<?php echo stripslashes($_GET['window_header']); ?>">
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
										<td align="left">
                                         <input type="button" name="btnBack" id="btnBack" value="Back" onclick="javascript: window.location='index.php?mode=scrolling_windows';"  />
                                        </td>
                                        <td colspan="11" align="right">
                                         <?php if($obj->chkValidActionPermission($admin_id,$add_action_id))
											{	 ?>
											<a href="index.php?mode=add_scrolling_content&id=<?php echo $sw_id ?>"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
										<?php } ?>
                                        </td>
									</tr>
									<tr class="manage-header">
										<td width="5%" class="manage-header" align="center"><strong>S.No</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Edit</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Delete</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Title</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Image</strong></td>
                                        <td width="10%" class="manage-header" align="center"><strong>Contents</strong></td>
                                        <td width="10%" class="manage-header" align="center"><strong>Credit Name</strong></td>
                                        <td width="15%" class="manage-header" align="center"><strong>Credit Link</strong></td>
                                        <td width="10%" class="manage-header" align="center"><strong>Date Type</strong></td>
                                        <td width="10%" class="manage-header" align="center"><strong>Date</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Status</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Order</strong></td>
                                        
									</tr>
									<?php
									echo $obj->getAllScrollingContents($sw_id,$_GET);
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