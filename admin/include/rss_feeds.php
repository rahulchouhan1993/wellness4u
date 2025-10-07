<?php
require_once('config/class.mysql.php');
require_once('classes/class.rssfeedparser.php');

$obj = new FeedParser();

$add_action_id = '167';
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
//add by ample 30-07-20
if(isset($_POST['btnSubmit']))
   {
      $search = strip_tags(trim($_POST['search']));
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Rss Feeds </td>
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
										<td colspan="12" align="right" nowrap="nowrap">
                                        <?php
										if($obj->chkValidActionPermission($admin_id,$add_action_id))
										{ ?>
											<a href="index.php?mode=add_rss_feed"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
                                        <?php
										}?>    
										</td>
									</tr>
									<tr class="manage-header">
										<td width="5%" align="center" nowrap="nowrap" class="manage-header">S.No.</td>
										<td width="5%" align="center" nowrap="nowrap" class="manage-header">Status</td>
                                        <td width="5%" align="center" nowrap="nowrap" class="manage-header">Edit</td>
                                        <td width="5%" align="center" nowrap="nowrap" class="manage-header">Delete</td>
                                        <td class="manage-header" align="center" width="10%">View Feeds</td>
                                        <td class="manage-header" align="center" width="10%">Added Date</td>
										<td class="manage-header" align="center" width="30%">Title</td>
                                        <td class="manage-header" align="center" width="5%">Url</td>
                                        <td class="manage-header" align="center" width="5%">Language</td>
                                        <td class="manage-header" align="center" width="5%">Copyright</td>
                                        <td class="manage-header" align="center" width="5%">Category</td>
                                        <td class="manage-header" align="center" width="10%">Encode Data</td>
                                    </tr>
                                    <?php
									echo $obj->GetAllRssFeedUrlList($search);
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

<!-- Modal -->
<div id="HtmlModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">RSS HTML Code</h4>
      </div>
      <div class="modal-body">
        <div id="show_data"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
	function showw_rss_html(rss_id) {
		//alert(rss_id);
		//$('#HtmlModal').modal('show');

            var dataString = 'action=rss_html_code&rss_id='+rss_id;
            $.ajax({
                    type: "POST",
                    url: "include/remote.php",
                    data: dataString,
                    cache: false,
                    success: function(result)
                    {
                       // alert(result);
                       // return false;
                       var JSONObject = JSON.parse(result);
                       var rslt = JSONObject['status'];  
                       if(rslt == 1)
                       {	
                       		var data=JSONObject['data']; 
                           $('#show_data').html(data);
                           $('#HtmlModal').modal('show');
                       }
                       else
                       {
                           alert("some errors, try later!");
                       }
                    }
            });  
	}
</script>