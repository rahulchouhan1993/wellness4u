<?php

require_once('config/class.mysql.php');

require_once('classes/class.contents.php');



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

	$cs_id = $_POST['hdncs_id'];

	$cs_name = trim($_POST['message_type']);

	$cs_value = trim($_POST['cs_value']);



	$mess_action_id=trim($_POST['mess_action_id']);

	$admin_comment=$_POST['admin_comment'];

	$SMS_ID=$_POST['SMS_ID'];

     $status = $_POST['status'];

	

	if($cs_value == "")

	{

		$error = true;

		$err_msg = "Please enter message.";

	}

		

	if(!$error)

	{
		//update ample 10-07-20
		if($obj->UpdateCommonMessage($cs_id,$cs_value,$cs_name,$status,$mess_action_id,$admin_comment,$SMS_ID))

		{

			$err_msg = "Record Updateds Successfully!";

			header('location: index.php?mode=common_messages_user&msg='.urlencode($err_msg));

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

	$cs_id = $_GET['id'];

	list($cs_name,$cs_value,$cs_status,$mess_action_id,$admin_comment,$SMS_ID) = $obj->getCommonMessageDetails($cs_id);

	if($cs_name == '')

	{

		header('location: index.php?mode=common_messages_user');

	}

}

else

{

	header('location: index.php?mode=common_messages_user');

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

						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Message </td>

						<td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>

					</tr>

				</tbody>

				</table>

			</td>

		</tr>

		<tr>

			<!-- $mess_action_id -->

			<td>

				<table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">

				<tbody>

					<tr>

						<td class="mainbox-body">

							<form action="#" method="post" name="frmedit_content" id="frmedit_content" enctype="multipart/form-data" >

							<input type="hidden" name="hdncs_id" value="<?php echo $cs_id;?>" />

                            <input type="hidden" name="hdncs_name" value="<?php echo $cs_name;?>" />

							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">

							<tbody>

								 <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right"><strong>Message Action</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

										<?php //echo $mess_action_id;?>

		                            <select name="mess_action_id" id="mess_action_id" style="width:400px;">

		                                <option value="">Select Action</option>

		                                <?php echo $obj->getMessageActionsOptions($mess_action_id); ?>

		                            </select>

		                           </td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>


								<tr>

									<td width="20%" align="right"><strong>SMS SENDER ID</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

		                            <select name="SMS_ID" id="SMS_ID" style="width:400px;">

		                                <option value="">Select</option>

		                                <?php echo $obj->get_SMS_SENDER_data($SMS_ID); ?>

		                            </select>

		                           </td>

								</tr>
                                



                                       <tr>

                                           <td colspan="3" align="center">&nbsp;</td>

                                        </tr>

                                    <tr>

	                                    <td width="30%" align="right" valign="top"><strong>Admin Notes</strong></td>

	                                    <td width="5%" align="center" valign="top"><strong>:</strong></td>

	                                    <td width="65%" align="left" valign="top">

	                                        <textarea rows="5" cols="40" name="admin_comment" id="admin_comment"><?php echo $admin_comment; ?></textarea>



	                                    </td>

                                    </tr>

                                       

                                     <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>









                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right"><strong>Message Type</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                                        <input name="message_type" type="text" id="message_type" value="<?php echo $cs_name; ?>" style="width:400px;" >

                                                                        </td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right" valign="top"><strong>Message</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<textarea id="cs_value" name="cs_value" style="width: 400px; height:100px;"><?php echo stripslashes($cs_value);?></textarea>

									</td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                <tr>

									<td width="20%" align="right"><strong>Message status</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                                            <select name="status" id="status">

                                                                                <option value="">Select</option>

                                                                                 <option value="1" <?php if($cs_status == 1 ) { echo 'selected'; } ?>>Active</option>

                                                                                 <option value="0" <?php if($cs_status == 0 ) { echo 'selected'; } ?>>Inactive</option>

                                                                                

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

<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>

	<script type="text/javascript">

		tinyMCE.init({

			mode : "exact",

			theme : "advanced",

			elements : "cs_value",

			plugins : "style,advimage,advlink,emotions",

			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",

		});

	</script>



	<script type="text/javascript">

		tinyMCE.init({

			mode : "exact",

			theme : "advanced",

			elements : "admin_comment",

			plugins : "style,advimage,advlink,emotions",

			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",

		});

    </script>