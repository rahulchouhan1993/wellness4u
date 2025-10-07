<?php
require_once('config/class.mysql.php');
require_once('classes/class.subscriptions.php');  

$obj = new Subscriptions();

$edit_action_id = '185';

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
	$apr_id = $_POST['hdnapr_id'];
	$apr_status = trim($_POST['apr_status']);
	$uap_payment_status = trim($_POST['uap_payment_status']);
	$uap_payment_mode = trim($_POST['uap_payment_mode']);
	$uap_payment_details = trim($_POST['uap_payment_details']);
	
	
	list($pu_name,$pro_user_id,$ap_id,$ap_name,$ap_months_duration,$ap_amount,$ap_currency,$apr_status2,$uap_id,$uap_amount,$uap_currency,$uap_start_date,$uap_end_date,$uap_status,$uap_payment_status2,$uap_payment_mode2,$uap_payment_details2,$apr_add_date,$apr_responce_date) = $obj->getAdviserPlanRequestDetails($apr_id);

	if(!$error)
	{
		if($obj->updateAdviserPlanRequest($apr_id,$apr_status,$uap_payment_status,$uap_payment_mode,$uap_payment_details))
		{
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=adviser_plan_requests&msg='.urlencode($msg));
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
	$apr_id = $_GET['id'];
	list($pu_name,$pro_user_id,$ap_id,$ap_name,$ap_months_duration,$ap_amount,$ap_currency,$apr_status,$uap_id,$uap_amount,$uap_currency,$uap_start_date,$uap_end_date,$uap_status,$uap_payment_status,$uap_payment_mode,$uap_payment_details,$apr_add_date,$apr_responce_date) = $obj->getAdviserPlanRequestDetails($apr_id);
	
	if($ap_name == '')
	{
		header('location: index.php?mode=adviser_plan_requests');	
	}
}	
else
{
	header('location: index.php?mode=adviser_plan_requests');
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
	<table border="0" width="97%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Adviser Plan</td>
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
							<form action="#" method="post" name="frmedit_sleep" id="frmedit_sleep" enctype="multipart/form-data" >
							<input type="hidden" name="hdnapr_id" id="hdnapr_id" value="<?php echo $apr_id;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow">
							<tbody>
                            	<tr>
									<td width="30%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="65%" align="left">
                                        <select id="apr_status" name="apr_status">
                                            <option value="0" <?php if($apr_status == '0'){ ?> selected <?php } ?>>Pending</option>
                                            <option value="1" <?php if($apr_status == '1'){ ?> selected <?php } ?>>Active</option>
                                            <option value="2" <?php if($apr_status == '2'){ ?> selected <?php } ?>>Reject</option>
                                            <option value="3" <?php if($apr_status == '3'){ ?> selected <?php } ?>>Inactive</option>
                                        </select>
                                    </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>User Name</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><?php echo $pu_name;?>
                                    	<input type="hidden" name="pu_name" id="pu_name" value="<?php echo $pu_name;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Plan Name</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><?php echo $ap_name;?>
                                    	<input type="hidden" name="ap_name" id="ap_name" value="<?php echo $ap_name;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>
									<td align="right"><strong>Duration</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><?php echo $ap_months_duration.' Months';?>
                                    	<input type="hidden" name="ap_months_duration" id="ap_months_duration" value="<?php echo $ap_months_duration;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <?php
								if($uap_status == '1')
								{ ?>
                                 <tr>
									<td align="right"><strong>Plan Start Date</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><?php echo date('d-m-Y',strtotime($uap_start_date));?>
                                    	<input type="hidden" name="uap_start_date" id="uap_start_date" value="<?php echo $uap_start_date;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Plan End Date</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><?php echo date('d-m-Y',strtotime($uap_end_date));?>
                                    	<input type="hidden" name="uap_end_date" id="uap_end_date" value="<?php echo $uap_end_date;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <?php
								} ?>
                                <tr>
									<td align="right"><strong>Amount</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><?php echo $ap_amount;?>
                                    	<input type="hidden" name="ap_amount" id="ap_amount" value="<?php echo $ap_amount;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Currency</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><?php echo $ap_currency;?>
                                    	<input type="hidden" name="ap_currency" id="ap_currency" value="<?php echo $ap_currency;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Payment Status</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="uap_payment_status" id="uap_payment_status" style="width:200px;">
											<option value="0" <?php if($uap_payment_status == '0' || $uap_payment_status == ''){?> selected="selected" <?php }?>>Credit</option>
                                            <option value="1" <?php if($uap_payment_status == '1'){?> selected="selected" <?php }?>>Paid</option>
                                            <option value="2" <?php if($uap_payment_status == '2'){?> selected="selected" <?php }?>>Free</option>
                                        </select>
                                   	</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Payment Mode</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="uap_payment_mode" id="uap_payment_mode" style="width:200px;">
											<option value="" <?php if($uap_payment_mode == ''){?> selected="selected" <?php }?>>Select Payment Mode</option>
                                            <option value="Cheque" <?php if($uap_payment_mode == 'Cheque'){?> selected="selected" <?php }?>>Cheque</option>
                                            <option value="DD" <?php if($uap_payment_mode == 'DD'){?> selected="selected" <?php }?>>DD</option>
                                            <option value="Credit Card/Debit Card" <?php if($uap_payment_mode == 'Credit Card/Debit Card'){?> selected="selected" <?php }?>>Credit Card/Debit Card</option>
                                            <option value="NEFT/RTGS" <?php if($uap_payment_mode == 'NEFT/RTGS'){?> selected="selected" <?php }?>>NEFT/RTGS</option>
                                            <option value="Cash" <?php if($uap_payment_mode == 'Cash'){?> selected="selected" <?php }?>>Cash</option>
                                            <option value="Paypal" <?php if($uap_payment_mode == 'Paypal'){?> selected="selected" <?php }?>>Paypal</option>
                                        </select>
                                   	</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Payment Details</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <textarea name="uap_payment_details" id="uap_payment_details" style="width:200px;" ><?php echo $uap_payment_details;?></textarea>
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