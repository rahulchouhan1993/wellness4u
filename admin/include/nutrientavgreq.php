<?php
require_once('config/class.mysql.php');
require_once('classes/class.dailymeals.php');
$obj = new Daily_Meals();

if(isset($_POST['btnSubmit']))
{
	$search = strip_tags(trim($_POST['search']));
}


$view_action_id = '22';
$import_action_id = '23';

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Nutrient Average Requirement  </td>
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
							 <form action="#" method="post" name="frm_dailymeal" id="frm_dailymeal" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                <table border="0" width="32%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="right">Search For - :</td>
                                        <td align="left"><input type="text" id="search" name="search"  value="<?php echo $search; ?>" /></td>
                                        <td align="left"> <input type="Submit" name="btnSubmit" value="Search" /></td>             
                                    </tr>
                                 </table>
                                
                                 </form>
							<div id="pagination_contents" align="center"> 
								<p>
                               
                                 </p>
								<table border="0" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<td colspan="8" align="left">
                                         <?php if($obj->chkValidActionPermission($admin_id,$import_action_id))
											{	 ?>
											<a href="index.php?mode=import_nutrientavgreq">Import CSV File</a>
                                            <?php } ?>
										</td>
									</tr>
									<tr class="manage-header">
										<td width="10%" class="manage-header" align="center"><strong>S.No</strong></td>
										<td width="30%" class="manage-header" align="center"><strong>Constituents</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Unit</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Symbols</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Reference</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Adults General</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Childeren General</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Edit</strong></td>
									</tr>
									<?php
									echo $obj->getAllNAR($search);
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