<?php
require_once('config/class.mysql.php');
require_once('classes/class.contents.php');  
require_once('classes/class.places.php');

$obj = new Contents();
$obj2 = new Places();

$edit_action_id = '249';

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

$arr_selected_page_id = array();

if(isset($_POST['btnSubmit']))
{
    $pd_id = $_POST['hdnpd_id'];
    $pdm_id = strip_tags(trim($_POST['pdm_id']));
    $menu_id = '';
    if (isset($_POST['admin_menu_id']) && is_array($_POST['admin_menu_id'])) {
        $menu_id = implode(',', $_POST['admin_menu_id']);
    }
    $admin_comment = $_POST['admin_comment'];
    $table_name = $_POST['table_name'];
    foreach ($_POST['selected_page_id'] as $key => $value) 
    {
        array_push($arr_selected_page_id,$value);
    }
    
    $pd_status = $_POST['pd_status'];

    if($pdm_id == '')
    {
        $error = true;
        $err_msg = 'Please select function';
    }
    elseif($obj->chkPageDropdownModuleExists_Edit($pdm_id,$pd_id))
    {
        $error = true;
        $err_msg .= '<br>This function already added';
    }
    
    
    if(count($arr_selected_page_id) == 0)
    {
        $error = true;
        $err_msg .= '<br>Please select pages';
    }

    if(!$error)
    {
        $page_id_str = implode(',',$arr_selected_page_id);
        if($obj->updatePageDropdownVivek($admin_comment,$pd_id,$pdm_id,$page_id_str,$pd_status,$admin_id,$menu_id,$table_name))
        {
            
            if(!empty($table_name))
            {
                for($i=0;$i<count($arr_selected_page_id);$i++)
                {
                    if($obj->alreadyinlist($arr_selected_page_id[$i]))
                    {
                        $obj->UpdateUserPlanAttributes($arr_selected_page_id[$i]);
                    }
                    else
                    {
                      $obj->AddUserPlanAttributes($arr_selected_page_id[$i]);  
                    }
                }
            }
            
            $msg = "Record Updated Successfully!";
            header('location: index.php?mode=page_dropdowns&msg='.urlencode($msg));
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
    $pd_id = $_GET['id'];
    list($admin_comment,$pdm_id,$page_id_str,$pd_status,$menu_id,$plan_table) = $obj->getPageDropdownDetailsVivek($pd_id);
    $function_name=$obj->getFunctionNameById($pdm_id);
    
    if($pdm_id == '')
    {
        header('location: index.php?mode=page_dropdowns');	
        exit(0);
    }
    $arr_selected_page_id = explode(',',$page_id_str); 
    $arr_selected_menu_id = explode(',',$menu_id); 
}	
else
{
    header('location: index.php?mode=page_dropdowns');
    exit(0);
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Page Dropdown</td>
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
							<input type="hidden" name="hdnpd_id" id="hdnpd_id" value="<?php echo $pd_id;?>" />
                                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow">
							<tbody>
                            	<tr>
									<td width="30%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="65%" align="left">
                                                                            <select id="pd_status" name="pd_status">
                                                                                <option value="1" <?php if($pd_status == '1'){ ?> selected <?php } ?>>Active</option>
                                                                                <option value="0" <?php if($pd_status == '0'){ ?> selected <?php } ?>>Inactive</option>
                                                                            </select>
                                                                        </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                         
                                        <tr>
                                        <td width="30%" align="right" valign="top"><strong>Table Name</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="table_name" id="table_name" style="width:200px;">
                                                <option value="">Select Page</option>
                                                <option value="tbladviserplanatributes" <?php if($plan_table == 'tbladviserplanatributes') { echo 'selected'; } ?>>tbladviserplanatributes</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
								<tr>
                                        <td width="30%" align="right" valign="top"><strong>Function Name</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="hidden" name="pdm_id" id="pdm_id" style="width:200px;" value="<?php echo $pdm_id;?>">
                                            <input type="text" name="pdm_name" id="pdm_name" style="width:200px;" value="<?php echo $function_name;?>" readonly>
<!--                                            <select name="pdm_id" id="pdm_id" style="width:200px;" >
                                                <option value="">Select Function</option>
                                                <?php echo $obj->getPageDropdownModulesOptions($pdm_id);?>
                                            </select>-->
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
                                                <td colspan="3" align="center">&nbsp;</td>
                                        </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Pages</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllPagesChkeckbox($arr_selected_page_id,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Admin Menu</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllAdminMenuChkeckbox($arr_selected_menu_id,'0','300','200');?>
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