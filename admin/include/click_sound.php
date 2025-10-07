<?php
require_once('config/class.mysql.php');
require_once('classes/class.stressbuster.php');  
$stressbuster = new Stressbuster();

if(isset($_POST['btnSubmit']))
{
	$search = strip_tags(trim($_POST['search']));
  
}

$add_action_id = '95';
$view_action_id = '97';

if(!$stressbuster->isAdminLoggedIn())
{
	
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$stressbuster->chkValidActionPermission($admin_id,$view_action_id))
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Click Sound</td>
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
									<tr>
										<td colspan="5" align="right" nowrap="nowrap">
                                         <?php if($stressbuster->chkValidActionPermission($admin_id,$add_action_id))
											{	 ?>
											<a href="index.php?mode=add_new_clip"><img src="images/add.gif" width="10" height="8" border="0" />Add New Sound Clip</a>
										<?php  } ?>
                                        </td>
									</tr>
									<tr class="manage-header">
										<td class="manage-header" align="center" width="10%" nowrap="nowrap" >S.No.</td>
									    <td class="manage-header" align="center" width="40%">Sound Clip</td>
                                       	<td class="manage-header" align="center" width="20%">Status</td>
                                       	<td class="manage-header" align="center" nowrap="nowrap" width="5%">Edit</td>
										<td class="manage-header" align="center" nowrap="nowrap" width="5%">Delete</td>
									</tr>
									<?php
									echo $stressbuster->GetAllSoundClip();
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