<?php
require_once('config/class.mysql.php');
require_once('classes/class.mindjumble.php');  
$obj = new Mindjumble();

$view_action_id = '131';

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

$error = false;
$err_msg = "";

if(isset($_POST['btnSubmit']))
{
	$id 	= $_POST['hdnuserarea_id'];
	$box_title = strip_tags(trim($_POST['box_title']));
	$box_desc = strip_tags(trim($_POST['box_desc']));
	
	if($box_title == "")
	{
		$error = true;
		$err_msg .= "<br>Please Enter User Area Box Title.";
	}
	
	if($box_desc == "")
	{
		$error = true;
		$err_msg .= "<br>Please Enter User Area Box Description.";
	}
    
	if(!$error)
		{   
			if($obj->Update_user_area($id,$box_title,$box_desc))
				{
					$msg = "Record Updated Successfully!";
					header('location: index.php?mode=manage_mindjumble_user_area&msg='.urlencode($msg));
				}
			else
				{
					$error = true;
					$err_msg = "Currently there is some problem.Please try again later.";
				}
		}	
	
}
elseif(isset($_GET['uid']))
{
	$userarea_id = $_GET['uid'];
	
	list($step,$box_title,$box_desc) = $obj->getUserarea($userarea_id,'Mindjumble');
}
?>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			mode : "exact",
			theme : "advanced",
			elements : "box_desc",
			plugins : "style,advimage,advlink,emotions",
			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",
			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",
		});
	</script>
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit User Area</td>
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
                                 <form action="#" method="post" name="frm_music" id="frm_music" enctype="multipart/form-data" >
                                   <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="left" colspan="2">
                                        	<input type="button" name="btnSubmit" value="Back" onclick="window.location.href='index.php?mode=manage_mindjumble_user_area';"/>
                                       		</td>
                                        <td align="left">&nbsp;</td>             
                                    </tr>
                                 </table>
                                 </form>
                               </p>
								<table border="0" width="100%" cellpadding="1" cellspacing="1">
									<tbody>
                                        <tr>
                                            <td class="mainbox-body">
                                                <form action="#" method="post" name="frm_angervent_userarea" id="frm_angervent_userarea" enctype="multipart/form-data" >
                                                <input type="hidden" name="hdnuserarea_id" value="<?php echo $userarea_id;?>" />
                                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="20%" align="right"><strong>Step</strong></td>
                                                        <td width="5%" align="center"><strong>:</strong></td>
                                                        <td width="75%" align="left"><label><strong><?php echo $step; ?></strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" align="center">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%" align="right"><strong>Anger Vent User Area Title</strong></td>
                                                        <td width="5%" align="center"><strong>:</strong></td>
                                                        <td width="75%" align="left"><input type="text" size="66"  id="box_title" name="box_title" value="<?php echo $box_title; ?>"/>&nbsp;*</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" align="center">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%" align="right" valign="top"><strong>User Area Description</strong></td>
                                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                                        <td width="75%" align="left" valign="top"><textarea type="text" cols="50" rows="5"  id="box_desc" name="box_desc"/><?php echo $box_desc; ?></textarea></td>
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