<?php
require_once('config/class.mysql.php');
require_once('classes/class.theams.php');  
$obj = new Theams();

$add_action_id = '301';
$view_action_id = '303';

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Icons</td>
						<td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
					</tr>
				</tbody>
				</table>
                            <br>
                             <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="left" width="3%">Icons Id- :</td>
                                        <td align="left" width="3%"><input type="text" id="search" name="search"  value="<?php echo $search; ?>" /></td>
                                        <td align="left" width="3%">Icons Name :</td>
                                        <td align="left" width="3%"><input type="text" id="search" name="search"  value="<?php echo $search; ?>" /></td>
                                        <td align="left" width="3%">Display Name :</td>
                                        <td align="left" width="5%"><input type="text" id="search" name="search"  value="<?php echo $search; ?>" /></td>
                                        <td align="left" width="3%">posted By :</td>
                                        <td align="left" width="5%"><input type="text" id="search" name="search"  value="<?php echo $search; ?>" /></td>
                                        
                                        <td align="left" width="40%"> <input type="Submit" name="btnSubmit" value="Search" /></td>             
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
										<td colspan="27" align="left" nowrap="nowrap">
                                        	 <?php if($obj->chkValidActionPermission($admin_id,$add_action_id))
												{	 ?>
											<a href="index.php?mode=add_icons"><img src="images/add.gif" width="10" height="8" border="0" />Add New Icons</a>
											<?php } ?>
                                        </td>
									</tr>
									<tr class="manage-header">
                                        <td class="manage-header" align="center" width="10%" nowrap="nowrap" >S.No.</td>
                                        <td class="manage-header" align="center" width="10%">Status</td>
                                        <td class="manage-header" align="center" width="10%">Posted by</td>
                                        <td class="manage-header" align="center" width="10%">Date</td>
                                       	<td width="5%" align="center" nowrap="nowrap" class="manage-header">Edit</td>
                                        <td width="5%" align="center" nowrap="nowrap" class="manage-header">Delete</td>
                                        <td class="manage-header" align="center" width="20%">Icons Id</td>
                                        <td class="manage-header" align="center" width="20%">Icons Type</td>
                                        <td class="manage-header" align="center" width="20%">Admin Notes</td>
                                        <td class="manage-header" align="center" width="20%">Icons Name</td>
                                        <td class="manage-header" align="center" width="10%">Color Code</td>
                                        <td class="manage-header" align="center" width="20%">Image</td>
                                        <td class="manage-header" align="center" width="20%">Comment</td>
                                        <td class="manage-header" align="center" width="20%">Display Type</td>
                                        <td class="manage-header" align="center" width="10%">Order</td>
                                        <td class="manage-header" align="center" width="20%">Display Name</td>
                                        <td class="manage-header" align="center" width="20%">Link</td>
                                        <td class="manage-header" align="center" width="20%">Reference Table</td>
                                        <td class="manage-header" align="center" width="20%">Reference Number</td>
                                        <td class="manage-header" align="center" width="20%">Sub Cat</td>
                                        
                                        <td class="manage-header" align="center" width="20%">Listing data type</td>
                                         <td class="manage-header" align="center" width="20%">Days of month</td>
                                          <td class="manage-header" align="center" width="20%">single Date</td>
                                           <td class="manage-header" align="center" width="20%">Start Date</td>
                                            <td class="manage-header" align="center" width="20%">end Date</td>
                                            <td class="manage-header" align="center" width="20%">Days of week</td>
                                            <td class="manage-header" align="center" width="20%">Months</td>
                                        
                                        </tr>
                                        <?php
                                        echo $obj->GetAllPersonalitiesVivek();
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