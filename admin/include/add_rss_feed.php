<?php
require_once('config/class.mysql.php');
require_once('classes/class.rssfeedparser.php');
$obj = new FeedParser();

$add_action_id = '167';

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$add_action_id))
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}

$error = false;
$err_msg = "";

// echo "<pre>";

// $exclusion = $obj->getExclusionAllNameData('Menu','42');

// // print_r($exclusion);

// // die('--sss');

if(isset($_POST['btnSubmit']))
{
	$rss_feed_url = trim($_POST['rss_feed_url']);


	// $curl = curl_init($rss_feed_url);
	// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	// $data = curl_exec($curl);

	// $xml = simplexml_load_string($data);

	// echo "<pre>";
	// print_r($xml); 

	// $content = file_get_contents($rss_feed_url); // this could be done with cURL
 //    $xml = new SimpleXmlElement($content); 

 //    echo "<pre>";

 //    // print_r($content);
    
	// print_r($xml); 

	//die('---455sss-');
	
	
	if($rss_feed_url == "")
	{
		$error = true;
		$err_msg = "Please enter rss feed url.";
	}
	
	if(!$error)
	{
			
		if($obj->AddRssFeed($rss_feed_url))
		{
			$err_msg = "Rss feed added successfully!";
			header('location: index.php?mode=rss_feeds&msg='.urlencode($err_msg));
		}
		else
		{
			$error = true;
			$err_msg = "Invalid url or rss feed not available.Please try different rss feed.";
		}
	}
}
elseif (isset($_POST['btnSave'])) {
	$rss_feed_title = trim($_POST['rss_feed_title']);
	$rss_feed_html = trim($_POST['rss_feed_html']);

	if($rss_feed_title == "")
	{
		$error = true;
		$err_msg = "Please enter rss feed title.";
	}

	if($rss_feed_html == "")
	{
		$error = true;
		$err_msg = "Please enter rss feed HTML code.";
	}

	if(!$error)
	{
			
		if($obj->AddRssFeedHTML($rss_feed_title,$rss_feed_html))
		{
			$err_msg = "Rss feed HTML code added successfully!";
			header('location: index.php?mode=rss_feeds&msg='.urlencode($err_msg));
		}
		else
		{
			$error = true;
			$err_msg = "Try Later!.";
		}
	}
}
else
{
	$rss_feed_url = '';
	$rss_feed_title = '';
	$rss_feed_html = '';
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Rss Feed</td>
						<td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
					</tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<br>
				<table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">
				<tbody>
					<tr>
						<td class="mainbox-body">
							<form action="#" method="post" name="frmadd_contents" id="frmadd_contents" enctype="multipart/form-data" >
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="20%" align="right"><strong>Url</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
                                        <input name="rss_feed_url" type="text" id="rss_feed_url" value="<?php echo $rss_feed_url; ?>" style="width:400px;" >
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
				<br>
				<hr>
				<br>
				<table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">
				<tbody>
					<tr>
						<td class="mainbox-body">
							<form action="#" method="post" name="frmadd_contents" id="frmadd_contents" enctype="multipart/form-data" >
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="20%" align="right"><strong>RSS Title</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
                                        <input name="rss_feed_title" type="text" id="rss_feed_title" value="<?php echo $rss_feed_title; ?>" style="width:400px;" >
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>HTML Code</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
                                        <textarea name="rss_feed_html" type="text" id="rss_feed_html" style="width:400px; height: 200px;" ><?php echo $rss_feed_html; ?></textarea>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td align="left"><input type="Submit" name="btnSave" value="Submit" /></td>
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