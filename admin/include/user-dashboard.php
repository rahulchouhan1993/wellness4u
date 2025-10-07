<?php
require_once('config/class.mysql.php');
require_once('classes/class.contents.php');

$obj = new Contents();

$add_action_id = '75';
$view_action_id = '77';

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage User Dashboard </td>
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
                                 
                                 <form action="#" method="post" name="frm_realation" id="frm_relation" enctype="multipart/form-data" AUTOCOMPLETE="off">                               
                                <table border="0" width="32%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="right">Search For - :</td>
                                        <td align="left"><input type="text" id="search" name="search"  value="<?php echo $search; ?>" /></td>
                                        <td align="left"> <input type="Submit" name="btnSubmit" value="Search" /></td>             
                                    </tr>
                                 </table>
                                
                                 </form>
                                </p>
								<table border="1" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr class="manage-header">
										<td width="10%" align="center" nowrap="nowrap" class="manage-header">S.No.</td>
										<td class="manage-header" align="center" width="65%">Page Name</td>
                                                                                <td class="manage-header" align="center" width="65%">Added By</td>
                                                                                <td class="manage-header" align="center" width="65%">Added Date</td>
                                                                                <td class="manage-header" align="center" width="65%">Updated By</td>
                                                                                <td class="manage-header" align="center" width="65%">Updated Date</td>
										<td width="10%" align="center" nowrap="nowrap" class="manage-header">Edit</td>
                                                                                <td class="manage-header" align="center" width="10%">Page Icon</td>
                                                                                <td width="10%" align="center" nowrap="nowrap" class="manage-header">Dashboard Header</td>
                                                                                <td width="10%" align="center" nowrap="nowrap" class="manage-header">Dashboard Contents</td>
                                                                                <td width="10%" align="center" nowrap="nowrap" class="manage-header">Dashboard Position</td>
                                                                                <td width="10%" align="center" nowrap="nowrap" class="manage-header">Dashboard Show</td>
                                                                                <td width="10%" align="center" nowrap="nowrap" class="manage-header">Show Order</td>
									</tr>
									<?php
									echo $obj->GetAllUserDashboard($search);
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