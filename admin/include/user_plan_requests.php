<?php
require_once('config/class.mysql.php');
require_once('classes/class.subscriptions.php');  

$obj = new Subscriptions();

$view_action_id = '194';

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
}
else
{
	$search = '';
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
                                <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="right" width="40%">Search For - :</td>
                                        <td align="left" width="15%"><input type="text" id="search" name="search"  value="<?php echo $search; ?>" /></td>
                                        <td align="left" width="40%"> <input type="Submit" name="btnSubmit" value="Search" /></td>             
                                    </tr>
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
									    <td class="manage-header" align="center" width="20%">User Name</td>
                                        <td class="manage-header" align="center" width="10%">User Id</td>
                                        <td class="manage-header" align="center" width="20%">Plan Name</td>
                                        <td class="manage-header" align="center" width="10%">Status</td>
                                        <td class="manage-header" align="center" width="15%">Request Date</td>
										<td class="manage-header" align="center" width="15%">Response Date</td>
                                        <td width="5%" align="center" nowrap="nowrap" class="manage-header">Edit</td>
									</tr>
									<?php
									echo $obj->GetAllUserPlanRequests($search);
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