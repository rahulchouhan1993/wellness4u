<?php
require_once('config/class.mysql.php');
require_once('classes/class.keywords.php');  
require_once('classes/class.places.php');

$obj = new Keywords();
$obj2 = new Places();

$add_action_id = '236';

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

$keywords_id=4;
$all_page_id=$obj->getKeywordPageNameId($keywords_id);

$explode_page_id = explode(',', $all_page_id);
$implode_page_id = implode('\',\'', $explode_page_id);

$error = false;
$err_msg = "";

if(isset($_POST['btnSubmit']))
{
    $kw_name = strip_tags(trim($_POST['kw_name']));
    $kw_module_type = trim($_POST['kw_module_type']);
    
    if($kw_name == '')
    {
        $error = true;
        $err_msg = 'Please enter keyword';
    }
    elseif($obj->chkKeywordExists($kw_name))
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
        $kw_module_id = '0';
        if($obj->addKeyword($kw_name,$kw_module_type,$kw_module_id))
        {
            $msg = "Record Added Successfully!";
            header('location: index.php?mode=keywords_master&msg='.urlencode($msg));
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
    $kw_name = '';
    $kw_module_type = '';
}	
?>
<div id="central_part_contents">
    <div id="notification_contents">
    <?php
    if($error)
    { ?>
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
    } ?>
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Keyword</td>
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
                            <form action="#" method="post" name="frmadd_my_relation" id="frmadd_my_relation" enctype="multipart/form-data" >
                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
                                <tbody>
                                    
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
                                        <td align="right" valign="top"><strong>Page Name</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <select name="page_name" id="page_name" style="width:200px; height: 24px;">
                                                <option value="">Select Page Name</option>
                                                <?php echo $obj->getPageCatDropdownModulesOptions($implode_page_id);?>
                                            </select>
                                        </td>
                                    </tr>
<!--                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                     <tr>
                                        <td align="right" valign="top"><strong>Function</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <select name="pdm_id" id="pdm_id" style="width:200px;">
                                                <option value="">Select Function</option>
                                                <?php echo $obj->getPageDropdownModulesOptions($pdm_id);?>
                                            </select>
                                        </td>
                                    </tr>-->
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