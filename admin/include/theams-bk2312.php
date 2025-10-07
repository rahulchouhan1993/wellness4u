<?php
require_once('config/class.mysql.php');
require_once('classes/class.theams.php');  
$obj = new Theams();

$add_action_id = '99';
$view_action_id = '101';

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
    $updated_by = strip_tags(trim($_POST['updated_by']));
   
}
else 
{
    $search = '';
    $updated_by = '';
  
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Themes</td>
						<td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
					</tr>
				</tbody>
				</table>
                            <br>
                             <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="left" width="10%">Theams Name- :</td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                                <input type="text" id="search" name="search"  value="<?php echo $search; ?>" />
                                            </td>
                                         <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Posted By:</strong></td>
                                            <td width="5%" height="30" align="left" valign="middle">
                                                <select name="updated_by" id="updated_by" style="width:200px;">
                                                    <!--<option value="">All Type</option>-->
                                                   <?php echo $obj->gettheamCategoryTypetattya($updated_by)?>
                                                </select>
                                            </td>
                                    </tr>
                                    <tr>
                                            <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td colspan="2" height="30" align="left" valign="middle">
                                                <input type="submit" name="btnSubmit" id="btnSubmit" value="Search" />
                                            </td>
                                        </tr>
                                    
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
								<table border="1" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<td colspan="15" align="left" nowrap="nowrap">
                                        	 <?php if($obj->chkValidActionPermission($admin_id,$add_action_id))
												{	 ?>
											<a href="index.php?mode=add_theams"><img src="images/add.gif" width="10" height="8" border="0" />Add New Theme</a>
											<?php } ?>
                                        </td>
									</tr>
									<tr class="manage-header">
										<td class="manage-header" align="center" width="10%" nowrap="nowrap" >S.No.</td>
									     <td class="manage-header" align="center" width="20%">Theme Name</td>
                                        <td class="manage-header" align="center" width="10%">Color Code</td>
                                        <td class="manage-header" align="center" width="20%">Image</td>
                                        <td class="manage-header" align="center" width="20%">Listing data type</td>
                                         <td class="manage-header" align="center" width="20%">Days of month</td>
                                          <td class="manage-header" align="center" width="20%">single Date</td>
                                           <td class="manage-header" align="center" width="20%">Start Date</td>
                                            <td class="manage-header" align="center" width="20%">end Date</td>
                                            <td class="manage-header" align="center" width="20%">Days of week</td>
                                            <td class="manage-header" align="center" width="20%">Months</td>
                                        <td class="manage-header" align="center" width="10%">Posted By</td>
                                       	<td class="manage-header" align="center" width="10%">Status</td>
                                       	<td width="5%" align="center" nowrap="nowrap" class="manage-header">Edit</td>
										<td width="5%" align="center" nowrap="nowrap" class="manage-header">Delete</td>
									</tr>
									<?php
									echo $obj->GetAllPages($search);
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