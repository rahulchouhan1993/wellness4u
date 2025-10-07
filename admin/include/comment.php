<?php
require_once('config/class.mysql.php');
require_once('classes/class.comment.php');  
$obj = new Comment();

$view_action_id = '108';

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Coments</td>
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
                                
                                </p>
								<table border="0" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr class="manage-header">
										<td class="manage-header" align="center" width="10%" nowrap="nowrap" >S.No.</td>
									     <td class="manage-header" align="center" width="20%">Comment</td>
                                        <td class="manage-header" align="center" width="15%">User</td>
                                        <td class="manage-header" align="center" width="15%">User Query</td>
                                        <td class="manage-header" align="center" width="15%">User Trigger</td>
                                        <td class="manage-header" align="center" width="15%">Topic/Subject</td>
                                        <td class="manage-header" align="center" width="15%">Narration</td>
                                         <td class="manage-header" align="center" width="10%">Date</td>
                                         <td class="manage-header" align="center" width="5%">status</td>
                                        <td width="10%" align="center" nowrap="nowrap" class="manage-header">Edit</td>
									</tr>
									<?php
									echo $obj->GetAllPages();
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