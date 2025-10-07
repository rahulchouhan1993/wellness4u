<?php
require_once('config/class.mysql.php');
require_once('classes/class.admin.php');

$obj = new Admin();

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->isSuperAdmin())
{
	header("Location: index.php?mode=invalid");
	exit(0);
}

if(isset($_POST['btnSubmit']))
{
	$search = strip_tags(trim($_POST['search']));
}

if(isset($_POST['btnDelete']))
{
	if($_POST['chk_delete'] <=0)
	{
		$err_msg = 'Please select sub admin to delete';
	}
   
    $Delete = $_POST['chk_delete'];
	$count = count($Delete);
	
	for($i=0 ; $i<$count ; $i++) 
	{ 
		$obj->DeleteSubAdmin($Delete[$i]);
	}
		  
	$msg = "User deleted successfully!";
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Sub Admin</td>
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
                               
                                 </br>
                                 <form action="#" method="post" name="frm_subadmin" id="frm_subadmin" enctype="multipart/form-data" AUTOCOMPLETE="off">  
								<table border="0" width="100%" cellpadding="5" cellspacing="1">
                                <tbody>
									<tr>
                                        <td><input type="submit" id="btnDelete" name="btnDelete" value="Delete"/>
                                            </td>
                                            <td colspan="8" align="center">
                                             
                                                <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                                    <tr align="center">
                                                        <td align="right" width="40%">Search For - :&nbsp;</td>
                                                        <td align="left" width="20%"><input type="text" id="search" name="search" value="<?php echo $search; ?>" /></td>
                                                        <td align="left" width="40%"> <input type="Submit" name="btnSubmit" value="Search" /></td>             
                                                    </tr>
                                                 </table>
                                               </td>
										<td align="right">
											<input type="button" name="addnew" id="addnew" value="Add New" onClick="window.location='index.php?mode=add_sub_admin'" />
										</td>
									</tr>
                                    <tr>
                                      <td colspan="10"> <?php echo $err_msg; ?></td>
                                      </tr>
									<tr class="manage-header">
                                    	<td width="5%" class="manage-header" align="center"></td>
										<td width="5%" class="manage-header" align="center">S.No.</td>
										<td width="15%" class="manage-header" align="center">Email</td>
                                        <td width="10%" class="manage-header" align="center">User Name</td>
                                        <td width="10%" class="manage-header" align="center">First Name</td>
                                        <td width="10%" class="manage-header" align="center">Last Name</td>
										<td width="20%" class="manage-header" align="center">Address</td>
										<td width="10%" class="manage-header" align="center">Contact No</td>
                                        <td width="5%" class="manage-header" align="center">Status</td>
										<td width="5%" class="manage-header" align="center">Reset Password</td>
										<td width="5%" class="manage-header" align="center">Edit</td>
								
									</tr>
									<?php
									echo $obj-> GetAllSubAdmin($search);
									?>
								</tbody>
								</table>
                               </form>
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
