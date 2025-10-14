<?php
require_once('config/class.mysql.php');
require_once('classes/class.admin.php');

$obj = new Admin();
$objectLogs = new Logs();
$allUsersOption = $objectLogs->getUsersOption($_GET);
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Activity Logs</td>
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
                                 <form method="get" >
                                    <input type="hidden" name="mode"  value="logs-history">
                                    <input type="hidden" name="type"  value="<?php echo $_GET['type']; ?>">
                                    <input type="hidden" name="id"  value="<?php echo $_GET['id']; ?>">
                                    <label>Start Date</label>
                                    <input type="date" name="start_date"  value="<?php echo $_GET['start_date']; ?>">

                                    <label>End Date</label>
                                    <input type="date" name="end_date"  value="<?php echo $_GET['end_date']; ?>">

                                    <label>User</label>
                                    <select name="user">
                                        <option vlaue="">Select</option>
                                        <?php foreach($allUsersOption as $userOption){ ?>
                                            <option value="<?php echo $userOption['admin_id'] ?>" <?php if($_GET['user'] == $userOption['admin_id']) echo 'selected'; ?>><?php echo $userOption['username'] ?></option>
                                        <?php } ?>
                                        
                                    </select>

                                    
                                    <button type="submit">Filter</button>
                                 </form>  
                                 </br>
                                
								<table border="0" width="100%" cellpadding="5" cellspacing="1">
                                <tbody>
									
                                    <tr>
                                      <td colspan="10"> <?php echo $err_msg; ?></td>
                                      </tr>
									<tr class="manage-header">
                                    	
										<td  class="manage-header" align="center">S.No.</td>
										<td  class="manage-header" align="center">Page</td>
										
                                        <td class="manage-header" align="center">Modified By</td>
										<td  class="manage-header" align="center">Modified On</td>
								
									</tr>
                                    
									<?php
									$returnData = $objectLogs->getLogsDetails($_GET) ?? [];
                                    if(!empty($returnData)){
                                        $counter = 1;
                                        foreach($returnData as $retData){ ?>
                                        <tr class="manage-row">
                                            <td align="center">
                                                <?php echo $counter ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $retData['page'] ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $retData['username'] ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $retData['updated_on'] ?>
                                            </td>
                                        </tr>
                                        
                                        

                                    <?php  $counter++; } } ?>
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
