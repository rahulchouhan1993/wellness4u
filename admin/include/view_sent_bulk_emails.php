<?php
require_once('config/class.mysql.php');
require_once('classes/class.autoresponders.php');  
require_once('classes/class.places.php');
require_once('classes/class.subscriptions.php');

$obj = new Autoresponders();
$obj2 = new Places();
$obj3 = new Subscriptions();

$view_action_id = '217';

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

if(isset($_POST['email_ar_id']))
{
	$email_ar_id = trim($_POST['email_ar_id']);
}
elseif(isset($_GET['email_ar_id']))
{
	$email_ar_id = trim($_GET['email_ar_id']);
}
elseif(isset($_GET['email_ar_id']))
{
	$email_ar_id = '';
}

if(isset($_POST['uid']))
{
	$uid = trim($_POST['uid']);
}
elseif(isset($_GET['uid']))
{
	$uid = trim($_GET['uid']);
}
elseif(isset($_GET['uid']))
{
	$uid = '';
}

if(isset($_POST['puid']))
{
	$puid = trim($_POST['puid']);
}
elseif(isset($_GET['puid']))
{
	$puid = trim($_GET['puid']);
}
elseif(isset($_GET['puid']))
{
	$puid = '';
}

if(isset($_POST['start_date']))
{
	$start_date = trim($_POST['start_date']);
}
elseif(isset($_GET['start_date']))
{
	$start_date = trim($_GET['start_date']);
}
elseif(isset($_GET['start_date']))
{
	$start_date = '';
}

if(isset($_POST['end_date']))
{
	$end_date = trim($_POST['end_date']);
}
elseif(isset($_GET['end_date']))
{
	$end_date = trim($_GET['end_date']);
}
elseif(isset($_GET['end_date']))
{
	$end_date = '';
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">View Sent Bulk Emails</td>
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
                                        <td colspan="7" height="30" align="left" valign="middle"><strong>Search Record</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>Email Campaign:</strong></td>
                                        <td width="30%" height="30" align="left" valign="middle">
                                            <select name="email_ar_id" id="email_ar_id" style="width:200px;">
											<option value="" >All Bulk Email Campaign</option>
											<?php echo $obj->getBulkEmailCampaingOptions($email_ar_id); ?>
										</select>
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Start Date:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:80px;"  />
                                       		<script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>End Date:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:80px;"  />
                                       		<script>$('#end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle">
                                            <input type="submit" name="btnSubmit" id="btnSubmit" value="Search" />
                                        </td>
                                    </tr>
                                   	<tr>
                                        <td height="30" align="left" valign="middle"><strong>User:</strong></td>
                                        <td height="30" align="left" valign="middle">
                                            <select name="uid" id="uid" style="width:200px;">
											<option value="" >All Users</option>
											<?php echo $obj2->getUsersOptions($uid); ?>
										</select>
                                        </td>
                                        <td height="30" align="left" valign="middle"><strong>Adviser:</strong></td>
                                        <td height="30" align="left" valign="middle">
                                            <select name="puid" id="puid" style="width:200px;">
											<option value="" >All Advisers</option>
											<?php echo $obj2->getProUsersOptions($puid); ?>
										</select>
                                        </td>
                                        <td height="30" align="left" valign="middle"></td>
                                        <td height="30" align="left" valign="middle"></td>
                                        <td height="30" align="left" valign="middle"></td>
                                    </tr>
                                    
                                </tbody>
                                </table>
                                </form>
                                </p>
								<table border="0" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<td colspan="8" align="right" nowrap="nowrap">
                                        
										</td>
									</tr>
									<tr class="manage-header">
										<td class="manage-header" align="center" width="5%" nowrap="nowrap" >S.No.</td>
									    <td class="manage-header" align="center" width="10%">Receiver Name</td>
                                        <td class="manage-header" align="center" width="10%">Receiver Email</td>
                                        <td class="manage-header" align="center" width="10%">Receiver Type</td>
                                        <td class="manage-header" align="center" width="15%">Email Campaign</td>
										<td class="manage-header" align="center" width="15%">Email Subject</td>
										<td class="manage-header" align="center" width="30%">Email Message</td>
                                        <td class="manage-header" align="center" width="5%">Date</td>
									</tr>
									<?php
									echo $obj->GetAllSentBulkEmails($email_ar_id,$start_date,$end_date,$uid,$puid);
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