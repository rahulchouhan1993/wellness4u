<?php

require_once('config/class.mysql.php');

require_once('classes/class.contents.php');

require_once('../init.php');



$obj = new Contents();



$add_action_id = '359';



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

$mess_action_id="";



if(isset($_POST['btnSubmit']))

{

	$message_type = trim($_POST['message_type']);

	$message_contents = trim($_POST['message_contents']);



	$mess_action_id=trim($_POST['mess_action_id']);

    $admin_comment = $_POST['admin_comment'];



    $admin_id = $_SESSION['admin_id'];

        
    $SMS_ID=$_POST['SMS_ID'];
	

	if($message_type == "")

	{

		$error = true;

		$err_msg = "Please Enter Message Type.";

	}

	

	if($message_contents == "")

	{

		$error = true;

		$err_msg = "Please Enter Message Contents.";

	}

	

	if(!$error)

	{

		$adviser_panel = '0';

        $vender_panel = '0';
        //update ample 10-07-20
		if($obj->AddMessageContent($message_type,$message_contents,$admin_id,$mess_action_id,$admin_comment,$SMS_ID))

		{

			$err_msg = "Message Added Successfully!";

			header('location: index.php?mode=common_messages_user&msg='.urlencode($err_msg));

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

			elements : "message_contents",

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

						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Page </td>

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



                             

                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                  <tr>

									<td align="right" valign="top"><strong>Message Name</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<?php //echo $email_function_name;?>

										<input type="text" name="message_name" id="message_name" value="" style="width:400px;" /> &nbsp;&nbsp;&nbsp;

                                      <input type="button" name="add_function" id="add_function" onclick="AddFunction();" value="submit" >

									</td>

								</tr>

                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right"><strong>Message Action</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

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

                                        <textarea rows="5" cols="40" name="admin_comment" id="admin_comment"></textarea>

                                    </td>

                                </tr>

                                <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                </tr>













                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>



								<tr>

									<td width="20%" align="right"><strong>Message Type</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left"><input name="message_type" type="text" id="message_type" value="<?php echo $message_type; ?>" style="width:400px;" ></td>

								</tr>



                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								

								<tr>

									<td align="right" valign="top"><strong>Contents</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<textarea id="message_contents" name="message_contents" style="width: 400px; height:400px;"><?php echo stripslashes($message_contents);?></textarea>

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

			elements : "admin_comment",

			plugins : "style,advimage,advlink,emotions",

			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",

		});

    </script>



  <script>

        function AddFunction()

        {

            var message_name = $("#message_name").val();

            //alert(email_action_title);

            var dataString = 'action=addMessagefunction&message_name='+message_name;

            $.ajax({

                    type: "POST",

                    url: "include/remote.php",

                    data: dataString,

                    cache: false,

                    success: function(result)

                    {

                       // alert(result);

                       // var JSONObject = JSON.parse(result);

                       // var rslt = JSONObject['status'];  

                       

                       if(result == 1)

                       {

                           location.reload();

                       }

                       else

                       {

                           alert("some error to insert in table");

                       }

                    }

            });  

        }

    </script>