<?php
require_once('config/class.mysql.php');
require_once('classes/class.topbanner.php');  
$banner = new Banner();
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Top Banner </td>
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
										<td colspan="8" align="right">
											<a href="index.php?mode=add_top_banner"><img src="images/add.gif" width="10" height="8" border="0" />Add New Top Banner</a>
										</td>
									</tr>
									<tr class="manage-header">
										<td class="manage-header" align="center" width="5%" nowrap="nowrap" >S.No.</td>
										<!--<td class="manage-header" align="center" width="5%">Banner ID</td>-->
                                       <!-- <td class="manage-header" align="center" width="15%">Position</td>-->
                                        <td class="manage-header" align="center" width="10%">Width</td>
                                        <td class="manage-header" align="center" width="10%">Height</td>
                                        <td class="manage-header" align="center" width="20%">Banner</td>
										<!--<td width="5%" align="center" nowrap="nowrap" class="manage-header">Edit</td>-->
										<td width="5%" align="center" nowrap="nowrap" class="manage-header">Delete</td>
									</tr>
									<?php
									echo $banner->GetAllPages();
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