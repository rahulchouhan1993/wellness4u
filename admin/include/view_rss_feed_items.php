<?php
require_once('config/class.mysql.php');
require_once('classes/class.rssfeedparser.php');

$obj = new FeedParser();

$view_action_id = '166';

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

$rss_feed_url_id = $_GET['id'];
list($rss_feed_url,$rss_feed_status) = $obj->getRssFeedUrlDetails($rss_feed_url_id);
if($rss_feed_url == '')
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}
//add by ample 30-07-20
if(isset($_POST['btnSubmit']))
   {
      $search = strip_tags(trim($_POST['search']));
   }
?>
<style type="text/css">
	.RSS-feed-img img
	{
		max-width: 125px;
	}
</style>
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Rss Feeds - <?php echo $rss_feed_url;?> </td>
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
                                 <form action="" method="post" name="frm_realation" id="frm_relation" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                <table border="0" width="32%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="right">Search For - :</td>
                                        <td align="left"><input type="text" id="search" name="search"  value="<?php echo $search; ?>" /></td>
                                        <td align="left"> <input type="Submit" name="btnSubmit" value="Search" /></td>             
                                    </tr>
                                 </table>
                                
                                 </form>
                                </p>
								<table border="1" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<td colspan="6" align="right" nowrap="nowrap">
                                        
										</td>
									</tr>
									<tr class="manage-header">
										<td width="5%" align="center" nowrap="nowrap" class="manage-header">S.No.</td>
										<td width="5%" align="center" nowrap="nowrap" class="manage-header">Status</td>
                                        <td width="5%" align="center" nowrap="nowrap" class="manage-header">Edit</td>
                                        <td width="5%" align="center" nowrap="nowrap" class="manage-header">Delete</td>
                                        <td class="manage-header" align="center" width="5%">Added Date</td>
										<td class="manage-header" align="center" width="20%">Title</td>
                                        <td class="manage-header" align="center" width="30%">Description</td>
                                        <td class="manage-header" align="center" width="5%">Link</td>
                                        <td class="manage-header" align="center" width="5%">Publish Date</td>
                                        <td class="manage-header" align="center" width="5%">Author</td>
                                        <td class="manage-header" align="center" width="5%">Category</td>
                                        <td class="manage-header" align="center" width="5%">Encoded Data</td>
                                       
									</tr>
                                    <?php
									echo $obj->GetAllRssFeedItemList($rss_feed_url_id,$search);
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