<?php
require_once('config/class.mysql.php');
require_once('classes/class.rssfeedparser.php');
$obj = new FeedParser();

$edit_action_id = '168';

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
	$rss_feed_url_id = $_POST['hdnrss_feed_url_id'];  
	$rss_feed_url = trim($_POST['hdnrss_feed_url']);
	$rss_feed_status = trim($_POST['rss_feed_status']);
	
	if(!$error)
	{
		if($obj->updateRssFeedUrl($rss_feed_url_id,$rss_feed_status))
		{
		 	$msg = "Record Updated Successfully!";
			header('location: index.php?mode=rss_feeds&msg='.urlencode($msg));
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}
}
elseif(isset($_GET['id']))
{
	$rss_feed_url_id = $_GET['id'];
	list($rss_feed_url,$rss_feed_status) = $obj->getRssFeedUrlDetails($rss_feed_url_id);
}	
else
{
	header('location: index.php?mode=invalid');
	exit(0);
}
?>
<script type="text/javascript" src="js/jscolor.js"></script>
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
	<table border="0" width="97%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Rss Feed</td>
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
							<form action="#" method="post" name="frmedit_daily_meal" id="frmedit_daily_meal" enctype="multipart/form-data" >
							<input type="hidden" name="hdnrss_feed_url_id" id="hdnrss_feed_url_id" value="<?php echo $rss_feed_url_id;?>" />
							<input type="hidden" name="hdnrss_feed_url" id="hdnrss_feed_url" value="<?php echo $rss_feed_url;?>" />
                            <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="20%" align="right"><strong>Url</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><strong><?php echo $rss_feed_url; ?></strong></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                
                                <tr>
									<td align="right"><strong>Status</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<select id="rss_feed_status" name="rss_feed_status" style="width:200px;">
											<option value="0" <?php if($rss_feed_status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
											<option value="1" <?php if($rss_feed_status == '1') { ?> selected="selected" <?php } ?>>Active</option>
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