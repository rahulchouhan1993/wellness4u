<?php
require_once('config/class.mysql.php');
require_once('classes/class.angervent.php');  
$angervent = new Angervent();

if(isset($_POST['btnSubmit']))
{
	$search = strip_tags(trim($_POST['search']));
}

$add_action_id = '87';
$view_action_id = '89';

if(!$angervent->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$angervent->chkValidActionPermission($admin_id,$view_action_id))
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Anger Vent</td>
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
                                <form action="#" method="post" name="frm_angervent" id="frm_angervent" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="left" colspan="2">
                                        	<input type="button" name="btnSubmit" value="Anger Vent PDF" onclick="window.location.href='index.php?mode=angervent_pdf';"/>
                                       		<input type="button" name="btnSubmit" value="Manage User Uploads" onclick="window.location.href='index.php?mode=angervent_user_upload';"/>								             
                                            <input type="button" name="btnSubmit" value="Manage Background Music" onclick="window.location.href='index.php?mode=manage_anger_vent_bk_music';"/>
                                             <input type="button" name="btnSubmit" value="Manage User Area" onclick="window.location.href='index.php?mode=manage_anger_vent_user_area';"/>
                                            <!--<input type="button" name="btnSubmit" value="Manage Tooltip" onclick="window.location.href='index.php?mode=angervent_tooltip';"/>-->
                                            </td>
                                        <td align="left">&nbsp;</td>             
                                    </tr>
                                    <tr> <td>&nbsp;</td></tr>
                                 </table>
                                  <table border="0" width="30%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="right"><strong>Search For - :</strong></td>
                                        <td align="left"><input type="text" id="search" name="search"  value="<?php echo $search; ?>" /></td>
                                        <td align="left"> <input type="Submit" name="btnSubmit" value="Search" /></td>             
                                    </tr>
                                 </table>
                                
                                 </form>
                                </p>
								<table border="0" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<td colspan="10" align="right" nowrap="nowrap">
                                         <?php if($angervent->chkValidActionPermission($admin_id,$add_action_id))
												{	 ?>
											<a href="index.php?mode=add_angervent"><img src="images/add.gif" width="10" height="8" border="0" />Add New Box</a>
										<?php } ?>
                                        </td>
									</tr>
									<tr class="manage-header">
										<td class="manage-header" align="center" width="5%" nowrap="nowrap" >S.No.</td>
									    <td class="manage-header" align="center" width="5%">Step</td>
                                        <td class="manage-header" align="center" width="20%">Anger Vent Title</td>
                                        <td class="manage-header" align="center" width="5%">Anger Vent Type</td>
                                        <td class="manage-header" align="center" width="20%">Anger Vent Banner</td>
                                        <td class="manage-header" align="center" width="20%">Days</td>
                                        <td class="manage-header" align="center" width="5%">Status</td>
                                        <td class="manage-header" align="center" width="10%">Date</td>
                                       	<td width="5%" align="center" nowrap="nowrap" class="manage-header">Edit</td>
										<td width="5%" align="center" nowrap="nowrap" class="manage-header">Delete</td>
									</tr>
									<?php
									echo $angervent->GetAllPages($search);
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