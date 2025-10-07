<?php
require_once('config/class.mysql.php');
require_once('classes/class.theams.php');  
$obj = new Theams();

$add_action_id = '330';
$view_action_id = '329';

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
   $search = $_POST['search']; 
   $status = $_POST['status'];
   $updated_by = $_POST['updated_by'];
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Exclusion</td>
						<td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
					</tr>
				</tbody>
				</table>
                            <br>
                            
                                <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                    <form name="" method="post">
                                	<tr align="left">
                                    	<td align="left" width="15%">Exclusion Name- :</td>
                                        <td align="left" width="15%"><input type="text" id="search" name="search"  value="<?php echo $search; ?>" /></td>
                                         <td align="right" width="15%">status- :</td>
                                        <td width="15%" height="15" align="left" valign="middle">
                                                <select name="status" id="status" style="width:200px;">
                                                    <option value="">All Status</option>
                                                    <option value="0" <?php if($status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                                    <option value="1" <?php if($status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                                </select>
                                        </td>
                                        <td align="right" width="15%">posted By- :</td>
                                        <td align="left" width="15%">
                                            <select name="updated_by" id="updated_by" style="width:200px;">
                                                <option value="">All</option>
                                                <?php  echo $obj->getAdminDropdown($updated_by); ?>
                                            </select>
                                        </td>
                                        <td align="left" width="20%"> <input type="Submit" name="btnSubmit" value="Search" /></td>   
                                    </tr>
                                    
                                 </form>
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
										<td colspan="16" align="left" nowrap="nowrap">
                                        	 <?php if($obj->chkValidActionPermission($admin_id,$add_action_id))
												{	 ?>
											<a href="index.php?mode=add_exclusion"><img src="images/add.gif" width="10" height="8" border="0" />Add New Exclusion</a>
											<?php } ?>
                                        </td>
									</tr>
									<tr class="manage-header">
								            <td class="manage-header" align="center" width="10%" nowrap="nowrap" >S.No.</td>
									    <td class="manage-header" align="center" width="20%">Exclusion Name</td>
                                                                            <td class="manage-header" align="center" width="20%">Page Name</td>
                                                                            <td class="manage-header" align="center" width="20%">User Type</td>
                                                                            <td class="manage-header" align="center" width="20%">User Name</td>
                                                                            <td class="manage-header" align="center" width="10%">Posted Date</td>
                                                                            <td class="manage-header" align="center" width="10%">Status</td>
                                                                            <td width="5%" align="center" nowrap="nowrap" class="manage-header">Edit</td>
										<td width="5%" align="center" nowrap="nowrap" class="manage-header">Delete</td>
									</tr>
									<?php
									echo $obj->GetAllExclusionPagesData($search,$status,$updated_by);
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