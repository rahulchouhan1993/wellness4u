<?php
require_once('config/class.mysql.php');
require_once('classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();

$view_action_id = '196';
$add_action_id = '197';

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

$sb_bg_color = $obj->getCommonSettingValue('1');
$sb_border_color = $obj->getCommonSettingValue('2');
$search = '';
$page_id = '';
$status = '';
$start_date = '';
$end_date = '';

if(isset($_POST['btnSubmit']))
{
	$sb_bg_color = trim($_POST['sb_bg_color']);
	$sb_border_color = trim($_POST['sb_border_color']);
	
	$obj->setCommonSettingValue('1',$sb_bg_color);
	$obj->setCommonSettingValue('2',$sb_border_color);
}
elseif(isset($_POST['btnSubmit2']))
{
	$search = strip_tags(trim($_POST['search']));
	$page_id = trim($_POST['page_id']);
	$status = strip_tags(trim($_POST['status']));
	$country_id = trim($_POST['country_id']);
	$start_date = trim($_POST['start_date']);
	$end_date = trim($_POST['end_date']);
}
?>
<script type="text/javascript" src="js/jscolor.js"></script>
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Scrolling Bars</td>
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
								<form action="#" method="post" name="frm_place" id="frm_place" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="20%" height="30" align="left" valign="middle"><strong>Background Color:</strong></td>
                                        <td width="10%" height="30" align="left" valign="middle">
                                            <input type="text" class="color"  id="sb_bg_color" name="sb_bg_color" value="<?php echo $sb_bg_color; ?>"/>
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="20%" height="30" align="left" valign="middle"><strong>Border Color:</strong></td>
                                        <td width="10%" height="30" align="left" valign="middle">
                                            <input type="text" class="color"  id="sb_border_color" name="sb_border_color" value="<?php echo $sb_border_color; ?>"/>
                                        </td>
                                        <td width="20%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="10%" height="30" align="left" valign="middle">
                                            <input type="submit" name="btnSubmit" id="btnSubmit" value="Save" />
                                        </td>
                                    </tr>
                                    
                                </tbody>
                                </table>
                                </form>
                                <p></p>
                                <form action="#" method="post" name="frm_dailymeal" id="frm_dailymeal" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>Search:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="text" id="search" name="search"  value="<?php echo $search; ?>" style="width:200px;" />
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>Page:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="page_id" id="page_id" style="width:200px;">
                                                <option value="">Select Page</option>
                                                <option value="0" <?php if($page_id == '0') { ?> selected="selected" <?php }?>>All</option>
                                                <?php echo $obj->getScrollingBarPagesOptions($page_id); ?>
                                            </select>
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>Status:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="status" id="status" style="width:200px;">
                                                <option value="">All Status</option>
                                                <option value="0" <?php if($status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                                <option value="1" <?php if($status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   	<tr>
                                        <td height="30" align="left" valign="middle"><strong>Start Date:</strong></td>
                                        <td height="30" align="left" valign="middle" >
                                             <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:80px;"  />
                                        <script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                        </td>
                                   		<td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td height="30" align="left" valign="middle"><strong>End Date:</strong></td>
                                        <td colspan="2" height="30" align="left" valign="middle">
                                            <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:80px;"  />
                                        <script>$('#end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                        </td>
                                        <td colspan="2" align="center" height="30">
                                        	<input type="submit" name="btnSubmit2" id="btnSubmit2" value="Search" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                </tbody>
                                </table>
                                 </form>
								<table border="0" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<td colspan="12" align="right">
                                          <?php if($obj->chkValidActionPermission($admin_id,$add_action_id))
											{	 ?>
											<a href="index.php?mode=add_scrolling_bar"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
											<?php } ?>
                                        </td>
									</tr>
									<tr class="manage-header">
										<td width="5%" class="manage-header" align="center"><strong>S.No</strong></td>
										<td width="20%" class="manage-header" align="center"><strong>Page Name</strong></td>
                                        <td width="10%" class="manage-header" align="center"><strong>Content</strong></td>
                                        <td width="15%" class="manage-header" align="center"><strong>Image</strong></td>
                                        <td width="10%" class="manage-header" align="center"><strong>Credit Name</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Credit Link</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Date Type</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Date</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Status</strong></td>
                                        <td width="5%" class="manage-header" align="center"><strong>Order</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Edit</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Delete</strong></td>
									</tr>
									<?php
									echo $obj->getAllScrollingBars($search,$page_id,$status,$start_date,$end_date);
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
