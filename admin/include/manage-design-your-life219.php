<?php
require_once('config/class.mysql.php');
require_once('classes/class.mindjumble.php');  
$obj = new Mindjumble();

require_once('classes/class.contents.php');
$obj2 = new Contents();

if(isset($_POST['btnSubmit']))
{
	$search = strip_tags(trim($_POST['search']));
}

$add_action_id = '338';
$view_action_id = '337';

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Design Your Life</td>
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
                                <form action="#" method="post" name="frm_mindjumble" id="frm_mindjumble" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="left" colspan="2">
                                        	<input type="button" name="btnSubmit" value="Mind Jumble PDF" onclick="window.location.href='index.php?mode=mindjumble_pdf';"/>
                                       		<input type="button" name="btnSubmit" value="Manage User Uploads" onclick="window.location.href='index.php?mode=mindjumble_user_upload';"/>
                                            <input type="button" name="btnSubmit" value="Manage Background Music" onclick="window.location.href='index.php?mode=mindjumble_bk_music';"/>
                                             <input type="button" name="btnSubmit" value="Manage Title" onclick="window.location.href='index.php?mode=title';"/>
                                          	  <input type="button" name="btnSubmit" value="Manage User Area" onclick="window.location.href='index.php?mode=manage_mindjumble_user_area';"/>
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
                                        <table border="1" width="100%" cellpadding="2" cellspacing="2">
                                        <tbody>
                                                <tr>
                                                        <td colspan="81" align="left" nowrap="nowrap">
                                         <?php if($obj->chkValidActionPermission($admin_id,$add_action_id))
                                                        {	 ?>
                                                        <a href="index.php?mode=add-design-your-life"><img src="images/add.gif" width="10" height="8" border="0" />Add New</a>
                                                <?php } ?>
                                        </td>
                                        </tr>
                                          <tr class="manage-header">
                                        <td width="5%" class="manage-header" align="center" >S.No.</td>
                                        <td width="10%" class="manage-header" align="center">Status</td>
                                        <td width="10%" class="manage-header" align="center">Added By Admin</td>
                                        <td width="5%" class="manage-header" align="center">Listing Order</td>
                                        <td width="10%" class="manage-header" align="center">Date</td>
                                        <td width="5%" class="manage-header" align="center">Edit</td>
                                        <td width="5%" class="manage-header" align="center">Del</td>
                                        <td width="10%" class="manage-header" align="center">Admin Comment</td>
                                        <td width="10%" class="manage-header" align="center">User Show</td>
                                        <td width="10%" class="manage-header" align="center">User Uploads</td>
                                        <td width="10%" class="manage-header" align="center">Ref Code</td>
                                        <td width="10%" class="manage-header" align="center">Title</td>
                                        <td width="10%" class="manage-header" align="center">Data category</td>
                                        <td width="5%" class="manage-header" align="center">Prof Cat</td>
                                        <td width="5%" class="manage-header" align="center">Prof Heading</td>
                                        <td width="5%" class="manage-header" align="center">Sub cat</td>
                                        <td width="10%" class="manage-header" align="center">Narration</td>
                                        <td width="10%" class="manage-header" align="center">Narration Show</td>
                                        <td width="10%" class="manage-header" align="center">Image 1</td>
                                        <td width="10%" class="manage-header" align="center">image 1 show</td>
                                        <td width="10%" class="manage-header" align="center">image 1 credit</td>
                                        <td width="10%" class="manage-header" align="center">image 1 credit url</td>
                                        <td width="10%" class="manage-header" align="center">sound clip 1</td>
                                        
                                        <td width="10%" class="manage-header" align="center">Image 2</td>
                                        <td width="10%" class="manage-header" align="center">image 2 show</td>
                                        <td width="10%" class="manage-header" align="center">image 2 credit</td>
                                        <td width="10%" class="manage-header" align="center">image 2 credit url</td>
                                        <td width="10%" class="manage-header" align="center">sound clip 2</td>
                                        
                                        <td width="10%" class="manage-header" align="center">listing date type</td>
                                        <td width="10%" class="manage-header" align="center">days of month</td>
                                        <td width="10%" class="manage-header" align="center">single date</td>
                                        <td width="10%" class="manage-header" align="center">start date</td>
                                        <td width="10%" class="manage-header" align="center">end date</td>
                                        <td width="10%" class="manage-header" align="center">days of week</td>
                                        <td width="10%" class="manage-header" align="center">Months</td>
                                        
                                        <td width="5%" class="manage-header" align="center">User Date</td>
                                        <td width="5%" class="manage-header" align="center">User Date Heading</td>
                                        <td width="5%" class="manage-header" align="center">User Date Order</td>
                                        
                                        <td width="5%" class="manage-header" align="center">Time</td>
                                        <td width="5%" class="manage-header" align="center">Time Heading</td>
                                        <td width="5%" class="manage-header" align="center">Time Order</td>
                                        
                                        <td width="5%" class="manage-header" align="center">Duration</td>
                                        <td width="5%" class="manage-header" align="center">Duration Heading</td>
                                        <td width="5%" class="manage-header" align="center">Duration Order</td>
                                        
                                        <td width="5%" class="manage-header" align="center">Location</td>
                                        <td width="5%" class="manage-header" align="center">Location Heading</td>
                                        <td width="5%" class="manage-header" align="center">Location Order</td>
                                        <td width="5%" class="manage-header" align="center">Location category</td>
                                        
                                        <td width="5%" class="manage-header" align="center">User Response</td>
                                        <td width="5%" class="manage-header" align="center">Response Heading</td>
                                        <td width="5%" class="manage-header" align="center">Response Order</td>
                                         <td width="5%" class="manage-header" align="center">Response category</td>
                                        
                                        <td width="5%" class="manage-header" align="center">User What Next</td>
                                        <td width="5%" class="manage-header" align="center">What Next Heading</td>
                                        <td width="5%" class="manage-header" align="center">What Next Order</td>
                                         <td width="5%" class="manage-header" align="center">What next category</td>
                                        
                                        <td width="5%" class="manage-header" align="center">Scale</td>
                                        <td width="5%" class="manage-header" align="center">Scale Heading</td>
                                        <td width="5%" class="manage-header" align="center">Scale Order</td>
                                        
                                        <td width="5%" class="manage-header" align="center">Alerts/Updates</td>
                                        <td width="5%" class="manage-header" align="center">Alerts/Updates Heading</td>
                                        <td width="5%" class="manage-header" align="center">Alerts/Updates Order</td>
                                         <td width="5%" class="manage-header" align="center">Alerts category</td>
                                        
                                        <td width="5%" class="manage-header" align="center">Comments</td>
                                        <td width="5%" class="manage-header" align="center">Comments Heading</td>
                                        <td width="5%" class="manage-header" align="center">Comments Order</td>
                                        
                                        <td width="5%" class="manage-header" align="center">Prof Cat2</td>
                                        <td width="5%" class="manage-header" align="center">Sub cat2</td>
                                        <td width="5%" class="manage-header" align="center">Sub cat2 show/fetch</td>
                                        <td width="5%" class="manage-header" align="center">Sub cat2 link</td>
                                        
                                        <td width="5%" class="manage-header" align="center">Prof Cat3</td>
                                        <td width="5%" class="manage-header" align="center">Sub cat3</td>
                                        <td width="5%" class="manage-header" align="center">Sub cat3 show/fetch</td>
                                        <td width="5%" class="manage-header" align="center">Sub cat3 link</td>
                                        
                                        <td width="5%" class="manage-header" align="center">Prof Cat4</td>
                                        <td width="5%" class="manage-header" align="center">Sub cat4</td>
                                        <td width="5%" class="manage-header" align="center">Sub cat4 show/fetch</td>
                                        <td width="5%" class="manage-header" align="center">Sub cat4 link</td>
                                        
                                        <td width="5%" class="manage-header" align="center">quick response show</td>
                                        <td width="5%" class="manage-header" align="center">Icons Code</td>
                                        <td width="5%" class="manage-header" align="center">quick response heading</td>
                                        <td width="5%" class="manage-header" align="center">response heading</td>
                                        <td width="5%" class="manage-header" align="center">box count</td>
                                        
                                        
                                       
                                    </tr>
                                            <?php
                                                 echo $obj2->getAllDesignMyLife($search,$status);
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