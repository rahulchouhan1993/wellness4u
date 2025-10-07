<?php
require_once('config/class.mysql.php');
require_once('classes/class.rewardpoints.php');
$obj = new RewardPoint();

$add_action_id = '140';

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
$reward_module_title = trim($_POST['reward_module_title']);
$table_link = trim($_POST['table_link']);
$page_id = trim($_POST['page_id']);

if($reward_module_title == "")
{
$error = true;
$err_msg = "Please enter module name.";
}
elseif($obj->chkIfRewardModuleAlreadyExists($reward_module_title))
{
$error = true;
$err_msg = "Module name already exists.";
}


if(!$error)
{
if($obj->AddRewardModule($reward_module_title,$table_link,$page_id,$admin_id))
{
$err_msg = "Module Added Successfully!";
header('location: index.php?mode=reward_modules&msg='.urlencode($err_msg));
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
$reward_module_title = '';
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
<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Reward Module </td>
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
                    <td width="30%" align="right" valign="top"><strong>Module Name/Page Name</strong></td>
                    <td width="5%" align="center" valign="top"><strong>:</strong></td>
                    <td width="65%" align="left" valign="top">
                        <select name="page_id" id="page_id" style="width:200px; height: 24px;" required="" onchange="getText(this)">
                            <option value="">Select Page Name</option>
                            <?php echo $obj->getDatadropdownPage('8','');?>
                        </select>
                        <input type="hidden" name="reward_module_title" id="reward_module_title">
                        
                      <!--   &nbsp;&nbsp;&nbsp;Link 
                        <select name="table_link" id="table_link" style="width:200px; height: 24px;" >
                            <option value="">Select</option>
                            <option value="tbl_bodymainsymptoms">tbl_bodymainsymptoms</option>
                            <option value="tblsolutionitems">tblsolutionitems</option>
                            <option value="tbldailymealsfavcategory">tbldailymealsfavcategory</option>
                            <option value="tbldailyactivity">tbldailyactivity</option>
                            <option value="tbl_event_master">tbl_event_master</option>
                        </select> -->
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
function getText(element) {
var textHolder = element.options[element.selectedIndex].text
document.getElementById("reward_module_title").value = textHolder;
}
</script>