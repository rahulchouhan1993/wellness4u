<?php
require_once('config/class.mysql.php');
require_once('classes/class.keywords.php');  
require_once('classes/class.places.php');

$obj = new Keywords();
$obj2 = new Places();

$edit_action_id = '237';

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
    $kw_id = $_POST['hdnkw_id'];
    $kw_name = strip_tags(trim($_POST['kw_name']));
    $kw_module_type = trim($_POST['kw_module_type']);
    $kw_status = trim($_POST['kw_status']);

    if($kw_name == '')
    {
        $error = true;
        $err_msg = 'Please enter keyword';
    }
    elseif($obj->chkKeywordExists_Edit($kw_name,$kw_id))
    {
        $error = true;
        $err_msg .= '<br>This keyword already exists';
    }
    
    if($kw_module_type == '')
    {
        $error = true;
        $err_msg .= '<br>Please select module';
    }

    if(!$error)
    {
        if($obj->updateKeyword($kw_id,$kw_name,$kw_module_type,$kw_status))
        {
            $msg = "Record Updated Successfully!";
            header('location: index.php?mode=keywords_master&msg='.urlencode($msg));
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
    $kw_id = $_GET['id'];
    $arr_records = $obj->getKeywordDetails($kw_id);
    if(is_array($arr_records) && count($arr_records) > 0)
    {
        $kw_name = $arr_records['kw_name'];
        $kw_status = $arr_records['kw_status'];
        $kw_module_type = $arr_records['kw_module_type'];
    }
    else
    {
        header('location: index.php?mode=keywords_master');	
    }
}	
else
{
    header('location: index.php?mode=keywords_master');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Keyword</td>
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
							<form action="#" method="post" name="frmedit_my_relation" id="frmedit_my_relation" enctype="multipart/form-data" >
							<input type="hidden" name="hdnkw_id" id="hdnkw_id" value="<?php echo $kw_id;?>" />
                                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow">
							<tbody>
                            	<tr>
									<td width="30%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="65%" align="left">
                                                                            <select id="kw_status" name="kw_status">
                                                                                <option value="1" <?php if($kw_status == '1'){ ?> selected <?php } ?>>Active</option>
                                                                                <option value="0" <?php if($kw_status == '0'){ ?> selected <?php } ?>>Inactive</option>
                                                                            </select>
                                                                        </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
                                        <td width="30%" align="right" valign="top"><strong>Keyword</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="kw_name" id="kw_name" value="<?php echo $kw_name;?>" style="width:200px;"  >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><strong>Module</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <select name="kw_module_type" id="kw_module_type" style="width:200px;">
                                                <option value="">Select Module</option>
                                                <?php echo $obj->getKeywordModuleTypeOptions($kw_module_type);?>
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