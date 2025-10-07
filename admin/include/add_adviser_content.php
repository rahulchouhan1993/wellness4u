<?php
require_once('config/class.mysql.php');
require_once('classes/class.contents.php');
require_once('../init.php');

$obj = new Contents();

$add_action_id = '176';

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

if(isset($_POST['btnSubmit']))
{
	$page_name = trim($_POST['page_name']);
	$page_title = trim($_POST['page_title']);
	$page_contents = trim($_POST['page_contents']);
    $page_contents2 = trim($_POST['page_contents2']);
	$meta_title = trim($_POST['meta_title']);
	$meta_keywords = trim($_POST['meta_keywords']);
	$meta_description = trim($_POST['meta_description']);
	$menu_title = trim($_POST['menu_title']);
	$menu_link_enable = trim($_POST['menu_link_enable']);

	//add by ample 21-04-20
	$menu_link = trim($_POST['menu_link']);
	$page_icon=trim($_POST['page_icon']);
	$page_icon_type=trim($_POST['page_icon_type']);
	$admin_id = $_SESSION['admin_id'];
	//add by ample 21-04-20
	
	if($page_name == "")
	{
		$error = true;
		$err_msg = "Please Enter Page Name.";
	}
	
	if($menu_title == "")
	{
		$error = true;
		$err_msg = "Please Enter Menu Name.";
	}
		
	if(!$error)
	{
		$adviser_panel = '1';
        $vender_panel = '0';
        //update by ample 21-04-20
		if($obj->AddContent($page_icon,$menu_link,$page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$adviser_panel,$page_contents2,$vender_panel,$admin_id,$page_icon_type))
		{
			$err_msg = "Page Added Successfully!";
			header('location: index.php?mode=adviser_contents&msg='.urlencode($err_msg));
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}
}
else
{
	$page_name = '';
	$page_title = '';
	$page_contents = '';
        $page_contents2 = '';
	$meta_title = 'Chaitanya Wellness Research Institute';
	$meta_keywords = 'Chaitanya Wellness Research Institute';
	$meta_description = 'Chaitanya Wellness Research Institute';
	$menu_title = '';
	$menu_link_enable = '';
}	
?>
<!-- TinyMCE -->
	<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			mode : "exact",
			theme : "advanced",
			elements : "page_contents,page_contents2",
			plugins : "style,advimage,advlink,emotions",
			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",
			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",
		});
	</script>
	<!-- /TinyMCE -->
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Adviser Panel Page </td>
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
							<form action="#" method="post" name="frmadd_contents" id="frmadd_contents" enctype="multipart/form-data" >
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<!--add by ample 21-04-20-->
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
								<!--add by ample 21-04-20-->
								<tr>
									<td width="20%" align="right"><strong>Page Icon</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
                                        <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('IMG',0,'page_icon');">Gallery 1</button>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('OT',0,'page_icon');">Gallery 2</button>
                                        <input type="hidden" name="page_icon" id="page_icon" readonly />
                                        <input type="text" name="page_icon_type" id="page_icon_type" readonly/>
                                        <input type="text"  id="page_icon_name" disabled/>
                                        <input type="text"  id="page_icon_file" disabled />
                                        <button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData('page_icon');">Reset</button>
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Page Title</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="page_title" type="text" id="page_title" value="<?php echo $page_title; ?>" style="width:400px;" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>
									<td align="right"><strong>Menu Title</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="menu_title" type="text" id="menu_title" value="<?php echo $menu_title; ?>" style="width:400px;" ></td>
								</tr>
								<!--add by ample 21-04-20 -->
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Menu Link</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="menu_link" type="text" id="menu_link" value="<?php echo $menu_link; ?>" style="width:400px;" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Enable Menu Link</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input type="checkbox" name="menu_link_enable" id="menu_link_enable" value="1" <?php if($menu_link_enable == '1'){?> checked="checked" <?php }?>   ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right" valign="top"><strong>Contents</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
										<textarea id="page_contents" name="page_contents" style="width: 400px; height:400px;"><?php echo stripslashes($page_contents);?></textarea>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Extra Contents </strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
										<textarea id="page_contents2" name="page_contents2" style="width: 400px; height:400px;"><?php echo stripslashes($page_contents2);?></textarea>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Meta Title</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input type="text" id="meta_title" name="meta_title" style="width: 400px;" value="<?php echo $meta_title;?>" />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right" valign="top"><strong>Meta Keywords</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
										<textarea id="meta_keywords" name="meta_keywords" style="width: 400px; height:100px;"><?php echo $meta_keywords;?></textarea>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right" valign="top"><strong>Meta Description</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
										<textarea id="meta_description" name="meta_description" style="width: 400px; height:100px;"><?php echo $meta_description;?></textarea>
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