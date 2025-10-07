<?php
require_once('config/class.mysql.php');
require_once('classes/class.feedback.php');  
require_once('../init.php');
$obj = new Feedback();

$view_action_id = '111';

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
	$feedback_id = $_POST['hdnfeedback_id'];
	$reply_old = stripslashes($_POST['reply_old']);
	$reply_new = stripslashes($_POST['reply_new']);

	$parent_id = $_POST['hdnparent_id'];

	
	//list($page_name,$feedback,$status,$email,$name,$page_id,$user_id) = $obj->getfeedback($feedback_id);

	
	if($reply_new == "")
	{
		$error = true;
		$err_msg = "Please Enter New Reply.";
	}
	 
	
		if(!$error)
		{
		
			$admin_id = $_SESSION['admin_id'];
			$fname = $_SESSION['admin_fname'];
		    $lname = $_SESSION['admin_lname'];
			$admin_name = $fname.' '.$lname;
			$admin_email = $_SESSION['admin_email'];


			
		    $dateTime = new DateTime('now', new DateTimeZone('Asia/Kolkata')); 
		    $current= $dateTime->format("d-M-y  h:i A"); 
		    $reply=$reply_old.'<br><br>'.$current. ': '.$reply_new;


		 
			$obj->feedback_update($feedback_id, $reply);
		}	
		
			if(!$error)
			{
				// $to_email = $email;
				// $from_email = 'info@wellnessway4u.com';
				// $from_name = 'Admin wellnessway4u';
				// $subject = 'Reply From Wellness Admin';
				// $message = '<p><strong>Hi '.$name.',</strong><p>';
				// $message .= '<p>You have received new reply from wellness admin.</p>';
				// $message .= '<p><a href="'.SITE_URL.'/feedback.php">Click Here To view reply</a></p>';
				// $message .= '<p>Best Regards</p>';
				// $message .= '<p>www.wellnessway4u.com</p>';
				
				// $mail = new PHPMailer();
				// $mail->IsHTML(true);
				// $mail->Host = "batmobile.websitewelcome.com"; // SMTP server
				// $mail->From = $from_email;
				// $mail->FromName = $from_name;
				// $mail->AddAddress($to_email);
				// $mail->Subject = $subject;
				// $mail->Body = $message;
				// $mail->Send();
				// $mail->ClearAddresses();
				$msg = "Reply Successfully!";
				header('location: index.php?mode=view_conversation&uid='.$parent_id.'&msg='.urlencode($msg));
				
			}
			else
			{
				$err_msg = 'There is some problem right now!Please try again later';
			}
		
		
		
		
}
	elseif(isset($_GET['uid']))
	{
		$id = $_GET['uid'];
		$pid = $_GET['pid'];
		//echo $id;
	
		list($page_name,$feedback,$status,$email,$name,$page_id,$user_id) = $obj->getfeedback($id);
	}
else
	{
		header('location: index.php?mode=feedback');
	}	

?>
<script src="js/AC_ActiveX.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
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
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Reply Feedback</td>
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
							<form action="#" method="post" name="frmedit_theam" id="frmedit_theam" enctype="multipart/form-data" >
							<input type="hidden" name="hdnfeedback_id" value="<?php echo $id;?>" />
							<input type="hidden" name="hdnparent_id" value="<?php echo $pid;?>" />
                            <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								 <tr>
									<td width="20%" align="right"><strong>Subject</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><label><?php echo $page_name; ?></label>
                                     </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>

                                <tr>
									<td width="20%" align="right"><strong>Your Reply</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><label id="feedback"><?php echo $feedback; ?></label>
                                     </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                               
                                <tr>
									<td width="20%" align="right" valign="top"><strong>Update Reply</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left">
										<textarea cols="50" rows="5" type="text"  id="reply_new" name="reply_new"></textarea>
										<textarea cols="50" rows="5" type="text"  id="reply_old" name="reply_old" style="display: none;"><?php echo $feedback; ?></textarea>
                                     </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								
								<tr>
									<td>&nbsp;</td>
                                    <td align="center"><input type="button" name="btnSubmit" value="Back" onclick="window.location.href='index.php?mode=view_conversation&uid=<?php echo $pid; ?>';"/></td>
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