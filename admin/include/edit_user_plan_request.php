<?php
require_once('config/class.mysql.php');
require_once('classes/class.subscriptions.php');  

$obj = new Subscriptions();

$edit_action_id = '195';

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
	$upr_id = $_POST['hdnupr_id'];
	$upr_status = trim($_POST['upr_status']);
	$uup_payment_status = trim($_POST['uup_payment_status']);
	$uup_payment_mode = trim($_POST['uup_payment_mode']);
	$uup_payment_details = trim($_POST['uup_payment_details']);
	
	
	list($pu_name,$pro_user_id,$up_id,$up_name,$up_months_duration,$up_amount,$up_currency,$upr_status2,$uup_id,$uup_amount,$uup_currency,$uup_start_date,$uup_end_date,$uup_status,$uup_payment_status2,$uup_payment_mode2,$uup_payment_details2,$upr_add_date,$upr_responce_date) = $obj->getUserPlanRequestDetails($upr_id);

	if(!$error)
	{
		if($obj->updateUserPlanRequest($upr_id,$upr_status,$uup_payment_status,$uup_payment_mode,$uup_payment_details))
		{
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=user_plan_requests&msg='.urlencode($msg));
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
	$upr_id = $_GET['id'];
	list($pu_name,$pro_user_id,$up_id,$up_name,$up_duration,$up_amount,$up_currency,$upr_status,$uup_id,$uup_amount,$uup_currency,$uup_start_date,$uup_end_date,$uup_status,$uup_payment_status,$uup_payment_mode,$uup_payment_details,$upr_add_date,$upr_responce_date) = $obj->getUserPlanRequestDetails($upr_id);
	
	if($up_name == '')
	{
		header('location: index.php?mode=user_plan_requests');	
	}
}	
else
{
	header('location: index.php?mode=user_plan_requests');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit User Plan Request</td>
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
							<input type="hidden" name="hdnupr_id" id="hdnupr_id" value="<?php echo $upr_id;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow">
							<tbody>
                            	<tr>
									<td width="30%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="65%" align="left">
                                        <select id="upr_status" name="upr_status">
                                            <option value="0" <?php if($upr_status == '0'){ ?> selected <?php } ?>>Pending</option>
                                            <option value="1" <?php if($upr_status == '1'){ ?> selected <?php } ?>>Active</option>
                                            <option value="2" <?php if($upr_status == '2'){ ?> selected <?php } ?>>Reject</option>
                                            <option value="3" <?php if($upr_status == '3'){ ?> selected <?php } ?>>Inactive</option>
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
									<td align="left"><?php echo $up_name;?>
                                    	<input type="hidden" name="up_name" id="up_name" value="<?php echo $up_name;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>
									<td align="right"><strong>Duration</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><?php echo $up_duration.' Days';?>
                                    	<input type="hidden" name="up_months_duration" id="up_months_duration" value="<?php echo $up_months_duration;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <!-- <?php
								if($uup_status == '1')
								{ ?>
                                 <tr>
									<td align="right"><strong>Plan Start Date</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><?php echo date('d-m-Y',strtotime($uup_start_date));?>
                                    	<input type="hidden" name="uup_start_date" id="uup_start_date" value="<?php echo $uup_start_date;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Plan End Date</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><?php echo date('d-m-Y',strtotime($uup_end_date));?>
                                    	<input type="hidden" name="uup_end_date" id="uup_end_date" value="<?php echo $uup_end_date;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <?php
								} ?> -->
                                <tr>
									<td align="right"><strong>Amount</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><?php echo $up_amount;?>
                                    	<input type="hidden" name="up_amount" id="up_amount" value="<?php echo $up_amount;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Currency</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><?php echo $obj->getFavCategoryName($up_currency);?>
                                    	<input type="hidden" name="up_currency" id="up_currency" value="<?php echo $up_currency;?>" style="width:200px;" >
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Payment Status</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="uup_payment_status" id="uup_payment_status" style="width:200px;">
											<option value="Unpaid" <?php if($uup_payment_status == 'Unpaid' || $uup_payment_status == ''){?> selected="selected" <?php }?>>Unpaid</option>
                                            <option value="Paid" <?php if($uup_payment_status == 'Paid'){?> selected="selected" <?php }?>>Paid</option>
                                            <option value="Free" <?php if($uup_payment_status == 'Free'){?> selected="selected" <?php }?>>Free</option>
                                            <option value="Credit" <?php if($uup_payment_status == 'Credit'){?> selected="selected" <?php }?>>Credit</option>
                                            <option value="Refund" <?php if($uup_payment_status == 'Refund'){?> selected="selected" <?php }?>>Refund</option>
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
                                        <select name="uup_payment_mode" id="uup_payment_mode" style="width:200px;">
											<option value="" <?php if($uup_payment_mode == ''){?> selected="selected" <?php }?>>Select Payment Mode</option>
											<?php
												echo $obj->getFavCategoryRamakant(96,$uup_payment_mode);
											?>
                                            <!-- <option value="Cheque" <?php if($uup_payment_mode == 'Cheque'){?> selected="selected" <?php }?>>Cheque</option>
                                            <option value="DD" <?php if($uup_payment_mode == 'DD'){?> selected="selected" <?php }?>>DD</option>
                                            <option value="Credit Card/Debit Card" <?php if($uup_payment_mode == 'Credit Card/Debit Card'){?> selected="selected" <?php }?>>Credit Card/Debit Card</option>
                                            <option value="NEFT/RTGS" <?php if($uup_payment_mode == 'NEFT/RTGS'){?> selected="selected" <?php }?>>NEFT/RTGS</option>
                                            <option value="Cash" <?php if($uup_payment_mode == 'Cash'){?> selected="selected" <?php }?>>Cash</option>
                                            <option value="Paypal" <?php if($uup_payment_mode == 'Paypal'){?> selected="selected" <?php }?>>Paypal</option> -->
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
                                        <textarea name="uup_payment_details" id="uup_payment_details" style="width:200px;" ><?php echo $uup_payment_details;?></textarea>
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