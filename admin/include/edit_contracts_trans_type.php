<?php
require_once('config/class.mysql.php');
require_once('classes/class.contracts.php');
$obj = new Contracts();

$edit_action_id = '277';

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
    $ctt_id = $_POST['hdnctt_id'];
    $ctt_name = strip_tags(trim($_POST['ctt_name']));
    $ctt_status = strip_tags(trim($_POST['ctt_status']));

    if($ctt_name == '')
    {
        $error = true;
        $err_msg = 'Please enter document type';
    }
    elseif($obj->chkIfContractsTransactionTypeAlreadyExists_Edit($ctt_name,$ctt_id))
    {
        $error = true;
        $err_msg = 'Document type is already exist';
    }

    if(!$error)
    {
        if($obj->updateContractsTransactionType($ctt_id,$ctt_name,$ctt_status))
        {
            $msg = "Record Updated Successfully!";
            header('location: index.php?mode=contracts_trans_type&msg='.urlencode($msg));
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
    $ctt_id = $_GET['id'];
    list($ctt_name,$ctt_status) = $obj->getContractsTransactionTypeDetails($ctt_id);
    if($ctt_name == '')
    {
        header('location: index.php?mode=contracts_trans_type');	
    }	
}	
else
{
    header('location: index.php?mode=contracts_trans_type');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Document Type</td>
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
							<form action="#" method="post" name="frmedit_daily_meal" id="frmedit_daily_meal" enctype="multipart/form-data" >
							<input type="hidden" name="hdnctt_id" id="hdnctt_id" value="<?php echo $ctt_id;?>" />
                            <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								 <tr>
									<td width="30%" align="right" valign="top"><strong>Document Type</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="65%" align="left" valign="top"><input name="ctt_name" type="text" id="ctt_name" value="<?php echo $ctt_name; ?>" style="width:200px;"></td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                
                                <tr>
									<td align="right" valign="top"><strong>Status</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
										<select id="ctt_status" name="ctt_status" style="width:200px;">
											<option value="0" <?php if($ctt_status == 0) { ?> selected="selected" <?php } ?>>Inactive</option>
											<option value="1" <?php if($ctt_status == 1) { ?> selected="selected" <?php } ?>>Active</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td align="left" valign="top">
                                                                            <input type="Submit" name="btnSubmit" value="Submit" />&nbsp;
                                                                            <input type="button" name="btnCancel" value="Cancel" onclick="window.location.href='index.php?mode=contracts_trans_type'">
                                                                        </td>
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