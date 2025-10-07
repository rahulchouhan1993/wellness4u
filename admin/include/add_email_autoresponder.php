<?php

require_once('config/class.mysql.php');

require_once('classes/class.autoresponders.php');  



$obj = new Autoresponders();



$add_action_id = '213';



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

	$email_action_id = trim($_POST['email_action_id']);

	$email_ar_subject = trim($_POST['email_ar_subject']);

	$email_ar_from_name = trim($_POST['email_ar_from_name']);

	$email_ar_from_email = trim($_POST['email_ar_from_email']);

	$email_ar_to_email = trim($_POST['email_ar_to_email']);

	$email_ar_body = trim($_POST['email_ar_body']);

	 $SMS_ID=$_POST['SMS_ID'];

	if($email_action_id == "")

	{

		$error = true;

		$err_msg = "Please select email action.";

	}

	

	if($email_ar_subject == "")

	{

		$error = true;

		$err_msg .= "<br>Please enter subject.";

	}

	

	if($email_ar_from_name == "")

	{

		$error = true;

		$err_msg .= "<br>Please enter from name.";

	}

	

	if($email_ar_from_email == "")

	{

		$error = true;

		$err_msg .= "<br>Please enter from email.";

	}

	

	if($email_ar_to_email == "")

	{

		$error = true;

		$err_msg .= "<br>Please enter to email.";

	}

	

	if($email_ar_body == "")

	{

		$error = true;

		$err_msg .= "<br>Please enter email body.";

	}

	

		

	if(!$error)

	{
		  //update ample 10-07-20
		if($obj->addEmailAutoresponder($email_action_id,$email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body,$SMS_ID))

		{

			$msg = "Record Added Successfully!";

			header('location: index.php?mode=email_autoresponders&msg='.urlencode($msg));

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

	$email_action_id = '';

	$email_ar_subject = '';

	$email_ar_from_name = 'Info';

	$email_ar_from_email = 'info@wellnessway4u.com';

	$email_ar_to_email = '';

	$email_ar_body = '';

}

?>

<!-- TinyMCE -->

	<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>

	<script type="text/javascript">

		tinyMCE.init({

			mode : "exact",

			theme : "advanced",

			elements : "email_ar_body",

			plugins : "style,advimage,advlink,emotions",

			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code",

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

						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Autoresponder</td>

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

							<form action="#" method="post" name="frmedit_banner" id="frmedit_banner" enctype="multipart/form-data" >

							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblbanner">

							<tbody>

                                                            <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                <tr>

									<td align="right" valign="top"><strong>Function Name</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<input type="text" name="email_function_name" id="email_function_name" value="<?php echo $email_function_name;?>" style="width:400px;" />

                                                                                &nbsp;&nbsp;&nbsp;

                                                                                <input type="button" name="add_function" id="add_function" onclick="AddFunction();" value="submit" >

									</td>

								</tr>

                                                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right"><strong>Email Action</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                                            <select name="email_action_id" id="email_action_id" style="width:400px;">

                                                                                <option value="">Select Action</option>

                                                                                <?php echo $obj->getEmailActionsOptions($email_action_id); ?>

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

									<td align="right" valign="top"><strong>Email Subject</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<input type="text" name="email_ar_subject" id="email_ar_subject" value="<?php echo $email_ar_subject;?>" style="width:400px;" />

									</td>

								</tr>

								

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                <tr>

									<td align="right" valign="top"><strong>Email From Name</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<input type="text" name="email_ar_from_name" id="email_ar_from_name" value="<?php echo $email_ar_from_name;?>" style="width:400px;" />

									</td>

								</tr>

								

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                <tr>

									<td align="right" valign="top"><strong>Email From Email</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<input type="text" name="email_ar_from_email" id="email_ar_from_email" value="<?php echo $email_ar_from_email;?>" style="width:400px;" />

									</td>

								</tr>

								

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                <tr>

									<td align="right" valign="top"><strong>Email To Email</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<input type="text" name="email_ar_to_email" id="email_ar_to_email" value="<?php echo $email_ar_to_email;?>" style="width:400px;" />

									</td>

								</tr>

								

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                <tr>

									<td align="right" valign="top"><strong>Email Body</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

                                    	<table border="0" cellpadding="0" cellspacing="0" width="100%">

                                        	<tr>

                                            	<td width="60%" align="left" valign="top">

													<textarea id="email_ar_body" name="email_ar_body" style="width: 400px; height:400px;"><?php echo stripslashes($email_ar_body);?></textarea>

                                                </td>    

                                                <td width="40%" align="left" valign="top" style="font-size:12px; font-weight:bold;">

                                                    <p>Guidelines for Using Dynamic Variables</p>

                                                    <p>[[USER_EMAIL]] - Email of User</p>

                                                    <p>[[USER_NAME]] - Name of User</p>

                                                    <p>[[ADVISER_EMAIL]] - Email of Adviser User</p>

                                                    <p>[[ADVISER_NAME]] - Name of Adviser User</p>

                                                    <p>[[URL]] - System genrated Url </p>

                                                    <p>[[OTP]] - OTP for verification </p>

                                                </td>    

                                            </tr>

                                        </table>        

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

    <script>

        function AddFunction()

        {

            var email_action_title = $("#email_function_name").val();

            //alert(email_action_title);

            var dataString = 'action=Add_email_function&email_action_title='+email_action_title;

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

        