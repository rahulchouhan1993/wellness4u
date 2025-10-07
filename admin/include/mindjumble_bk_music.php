<?php
require_once('config/class.mysql.php');
require_once('classes/class.mindjumble.php');  
$obj = new Mindjumble();

$add_action_id = '91';
$view_action_id = '93';

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Background Music</td>
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
                                 <form action="#" method="post" name="frm_music" id="frm_music" enctype="multipart/form-data" >
                                   <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="left" colspan="2">
                                        	<input type="button" name="btnSubmit" value="Back" onclick="window.location.href='index.php?mode=mindjumble';"/>
                                       		</td>
                                        <td align="left">&nbsp;</td>             
                                    </tr>
                                 </table>
                                 </form>
                               </p>
								<table border="0" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<td colspan="7" align="right" nowrap="nowrap">
                                         <?php if($obj->chkValidActionPermission($admin_id,$add_action_id))
											{	 ?>
											<a href="index.php?mode=add_mindjumble_music"><img src="images/add.gif" width="10" height="8" border="0" />Add Music</a>
										<?php } ?>
                                        </td>
									</tr>
									<tr class="manage-header">
										<td class="manage-header" align="center" width="5%" nowrap="nowrap" >S.No.</td>
									    <td class="manage-header" align="center" width="30%">Background Music</td>
                                        <td class="manage-header" align="center" width="35%">Day</td>
                                        <td class="manage-header" align="center" width="10%">Status</td>
                                        <td class="manage-header" align="center" width="10%">Date</td>
                            			<td class="manage-header" align="center" width="5%" nowrap="nowrap" >Edit</td>
										<td class="manage-header" align="center" width="5%" nowrap="nowrap" >Delete</td>
									</tr>
									<?php
									echo $obj->GetMindJumblemusic();
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