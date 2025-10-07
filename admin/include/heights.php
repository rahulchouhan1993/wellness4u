<?php
require_once('config/class.mysql.php');
require_once('classes/class.heights.php');
$obj = new Heights();

$add_action_id = '59';
$view_action_id = '61';
$import_action_id = '106';

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Heights </td>
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
								<table border="0" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<td align="left">
                                        <?php if($obj->chkValidActionPermission($admin_id,$import_action_id))
											{	 ?>
											<a href="index.php?mode=import_heights">Import CSV File</a>
										<?php } ?>
                                        </td>
										<td colspan="5" align="right">
                                         <?php if($obj->chkValidActionPermission($admin_id,$add_action_id))
											{	 ?>
											<a href="index.php?mode=add_height"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
                                        <?php } ?>
										</td>
									</tr>
									<tr class="manage-header">
										<td width="10%" class="manage-header" align="center" >S.No.</td>
										<td width="30%" class="manage-header" align="center">Height(Feet)</td>
										<td width="20%" class="manage-header" align="center">Height(Inch)</td>
										<td width="20%" class="manage-header" align="center">Height(Cms)</td>
										<td width="10%" class="manage-header" align="center">Edit</td>
										<td width="10%" class="manage-header" align="center">Delete</td>
									</tr>
									<?php
									echo $obj->GetAllHeights();
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