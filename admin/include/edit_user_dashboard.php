<?php
require_once('config/class.mysql.php');
require_once('classes/class.contents.php');
require_once('../init.php');

$obj = new Contents();

$edit_action_id = '76';

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$edit_action_id))
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}

$error = false;
$err_msg = "";

if(isset($_POST['btnSubmit']))
{
	$page_id = $_POST['hdnpage_id'];
        $page_name = trim($_POST['page_name']);
	$dashboard_header = trim($_POST['dashboard_header']);
        $dashboard_contents = trim($_POST['dashboard_contents']);
	$position = trim($_POST['position']);
	$show_order = trim($_POST['show_order']);
        $show_in_dashboard = $_POST['show_in_dashboard'];
	$admin_id = $_SESSION['admin_id'];
	if($page_name == "")
	{
		$error = true;
		$err_msg = "Please Enter Page Name.";
	}
		
	if(!$error)
	{
		if($obj->UpdateContentUserDashboard($dashboard_contents,$page_id,$dashboard_header,$position,$show_order,$show_in_dashboard,$admin_id))
		{
			$err_msg = "Page Updateds Successfully!";
			header('location: index.php?mode=user-dashboard&msg='.urlencode($err_msg));
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}
}
elseif(isset($_GET['page_id']))
{
	$page_id = $_GET['page_id'];
	list($dashboard_contents,$page_icon,$dashboard_header,$show_order,$position,$show_in_dashboard,$menu_link,$page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$page_contents2) = $obj->getContentUserDashboard($page_id);
}
else
{
	header('location: index.php?mode=contents');
}	
?>

<div id="central_part_contents">
	<div id="notification_contents">
	<?php
	if($error)
	{
	?>
		<table class="notification-border-e" id="notification" align="center" border="0" width="97%" cellpadding="1" cellspacing="1">
		<tbody>
			<tr>
				<td class="notification-body-e">
					<table border="0" width="100%" cellpadding="0" cellspacing="6">
					<tbody>
						<tr>
							<td><img src="images/notification_icon_e.gif" alt="" border="0" width="12" height="10"></td>
							<td width="100%">
								<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<td class="notification-title-E">Error</td>
									</tr>
								</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td class="notification-body-e"><?php echo $err_msg; ?></td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>
		</tbody>
		</table>
	<?php
	}
	?>
<!--notification_contents-->
	</div>	 
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit user dashboard </td>
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
							<form action="#" method="post" name="frmedit_content" id="frmedit_content" enctype="multipart/form-data" >
							<input type="hidden" name="hdnpage_id" value="<?php echo $page_id;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
                                                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Page Name</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input name="page_name" type="text" id="page_name" value="<?php echo $page_name; ?>" style="width:400px;" ></td>
								</tr>
                                                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
                                                                    <td width="20%" align="right"><strong>Page Icon (<font color="red">From Content page</font>)</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
                                                                        <td width="75%" align="left">
                                                                            <img src="../../uploads/<?php echo $page_icon; ?>" style="width:100px; height: 100px;">
                                                                        </td>
								</tr>
                                                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Dashboard Header</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
                                                                            <textarea id="dashboard_header" name="dashboard_header" style="width: 400px; height:100px;"><?php echo stripslashes($dashboard_header);?></textarea>
                                                                        </td>
								</tr>
                                                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Dashboard Contents</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
                                                                            <textarea id="dashboard_contents" name="dashboard_contents" style="width: 400px; height:100px;"><?php echo stripslashes($dashboard_contents);?></textarea>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Page Position</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                            <select name="position" id="position" style="width:200px; height: 30px;">
                                                                                <option value="">Select position</option>
                                                                                <option value="top_1" <?php if($position == 'top_1') { echo 'selected'; } ?>>Top 1</option>
                                                                                <option value="top_2" <?php if($position == 'top_2') { echo 'selected'; } ?>>Top 2</option>
                                                                                <option value="middle_1" <?php if($position == 'middle_1') { echo 'selected'; } ?>>Middle 1</option>
                                                                                <option value="middle_2" <?php if($position == 'middle_2') { echo 'selected'; } ?>>Middle 2</option>
                                                                                <option value="middle_3" <?php if($position == 'middle_3') { echo 'selected'; } ?>>Middle 3</option>
                                                                                <option value="middle_4" <?php if($position == 'middle_4') { echo 'selected'; } ?>>Middle 4</option>
                                                                                <option value="bottom_1" <?php if($position == 'bottom_1') { echo 'selected'; } ?>>bottom 1</option>
                                                                                <option value="bottom_2" <?php if($position == 'bottom_2') { echo 'selected'; } ?>>bottom 2</option>
                                                                                <option value="bottom_3" <?php if($position == 'bottom_3') { echo 'selected'; } ?>>bottom 3</option>
                                                                                <option value="bottom_4" <?php if($position == 'bottom_4') { echo 'selected'; } ?>>bottom 4</option>
                                                                                <option value="bottom_5" <?php if($position == 'bottom_5') { echo 'selected'; } ?>>bottom 5</option>
                                                                                <option value="bottom_6" <?php if($position == 'bottom_6') { echo 'selected'; } ?>>bottom 6</option>
                                                                                <option value="bottom_7" <?php if($position == 'bottom_7') { echo 'selected'; } ?>>bottom 7</option>
                                                                                <option value="bottom_8" <?php if($position == 'bottom_8') { echo 'selected'; } ?>>bottom 8</option>
                                                                                <option value="bottom_9" <?php if($position == 'bottom_9') { echo 'selected'; } ?>>bottom 9</option>
                                                                                <option value="bottom_10" <?php if($position == 'bottom_10') { echo 'selected'; } ?>>bottom 10</option>
                                                                                <option value="left"  <?php if($position == 'left') { echo 'selected'; } ?>>Left</option>
                                                                                <option value="right" <?php if($position == 'right') { echo 'selected'; } ?>>Right</option>
                                                                            </select>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right"><strong>Display Order</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                            <select name="show_order" id="show_order" style="width:200px; height: 30px;">
                                                                                <option value="">Select Display Order</option>
                                                                                <option value="1" <?php if($show_order == '1') { echo 'selected'; } ?>>1</option>
                                                                                <option value="2" <?php if($show_order == '2') { echo 'selected'; } ?>>2</option>
                                                                                <option value="3" <?php if($show_order == '3') { echo 'selected'; } ?>>3</option>
                                                                                <option value="4" <?php if($show_order == '4') { echo 'selected'; } ?>>4</option>
                                                                                <option value="5" <?php if($show_order == '5') { echo 'selected'; } ?>>5</option>
                                                                                <option value="6" <?php if($show_order == '6') { echo 'selected'; } ?>>6</option>
                                                                                <option value="7" <?php if($show_order == '7') { echo 'selected'; } ?>>7</option>
                                                                                <option value="8" <?php if($show_order == '8') { echo 'selected'; } ?>>8</option>
                                                                                <option value="9" <?php if($show_order == '9') { echo 'selected'; } ?>>9</option>
                                                                                <option value="10" <?php if($show_order == '10') { echo 'selected'; } ?>>10</option>
                                                                                
                                                                            </select>
                                                                        </td>
								</tr>
                                                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right"><strong>Show in Dashboard</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                            <select name="show_in_dashboard" id="show_in_dashboard" style="width:200px; height: 30px;">
                                                                                <option value="">Show in Dashboard</option>
                                                                                <option value="1" <?php if($show_in_dashboard == '1') { echo 'selected'; } ?>>Yes</option>
                                                                                <option value="0" <?php if($show_in_dashboard == '0') { echo 'selected'; } ?>>NO</option>
                                                                               
                                                                            </select>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td align="left"><input type="Submit" name="btnSubmit" value="Submit" /></td>
								</tr>
							</tbody>
							</table>
							</form>
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
        <!-- TinyMCE -->
	<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			mode : "exact",
			theme : "advanced",
			elements : "dashboard_header,dashboard_contents",
			plugins : "style,advimage,advlink,emotions",
			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",
			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",
		});
	</script>
	<!-- /TinyMCE -->