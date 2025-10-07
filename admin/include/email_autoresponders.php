<?php
require_once('config/class.mysql.php');
require_once('classes/class.autoresponders.php');  

$obj = new Autoresponders();

$add_action_id = '213';
$view_action_id = '212';

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
	$email_action_id = trim($_POST['email_action_id']);
	//$search = trim($_POST['search']);
	$status = strip_tags(trim($_POST['status']));
}
else
{
	$email_action_id = '';
	//$search = '';
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Autoresponders</td>
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
                                <form action="#" method="post" name="frm_place" id="frm_place" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Email Action:</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle">
                                            <select name="email_action_id" id="email_action_id" style="width:200px;">
                                                <option value="">All Actions</option>
                                                <?php echo $obj->getEmailActionsOptions($email_action_id); ?>
                                            </select>
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
                                        <td width="14%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="5%" height="30" align="left" valign="middle"><strong></strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
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
										<td colspan="8" nowrap="nowrap">
                                        <?php 
                                        if($obj->chkValidActionPermission($admin_id,$add_action_id))
                                        { ?>
											<a href="index.php?mode=add_email_autoresponder"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
                                        <?php 
                                        } ?>     
										</td>
									</tr>
									<tr class="manage-header">
										<td class="manage-header" align="center" width="5%" nowrap="nowrap" >S.No.</td>
											<td width="5%" align="center" nowrap="nowrap" class="manage-header">Edit</td>
										<td width="5%" align="center" nowrap="nowrap" class="manage-header">Delete</td>
										<td width="5%" align="center" nowrap="nowrap" class="manage-header">Email ID</td>
									    <td class="manage-header" align="center" width="25%">Action</td>
                                        <td class="manage-header" align="center" width="40%">Subject</td>
                                        <td class="manage-header" align="center" width="10%">Status</td>
                                        <td class="manage-header" align="center" width="10%">Add Date</td>
									
									</tr>
									<?php
									echo $obj->GetAllEmailAutoresponders($email_action_id,$status);
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