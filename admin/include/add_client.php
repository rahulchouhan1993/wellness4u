<?php
require_once('config/class.mysql.php');
require_once('classes/class.banner.php');  
require_once('classes/class.places.php');

$obj = new Banner();
$obj2 = new Places();

$add_action_id = '232';

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
    $contract_person = strip_tags(trim($_POST['contract_person']));
    $contract_person_type = trim($_POST['contract_person_type']);
    $company_name = strip_tags(trim($_POST['company_name']));
    $contract_email = strip_tags(trim($_POST['contract_email']));
    $contract_mobile = strip_tags(trim($_POST['contract_mobile']));
    $address = strip_tags(trim($_POST['address']));
    $country_id = strip_tags(trim($_POST['country_id']));
    $state_id = strip_tags(trim($_POST['state_id']));
    $city_id = strip_tags(trim($_POST['city_id']));
    $place_id = strip_tags(trim($_POST['place_id']));

    if($company_name == '')
    {
        $error = true;
        $err_msg = 'Please enter client name';
    }
    
    if($contract_person_type == '')
    {
        $error = true;
        $err_msg .= '<br>Please select client type';
    }
    
    if($contract_person == '')
    {
        $error = true;
        $err_msg .= '<br>Please enter authorise person';
    }

    if($country_id == '')
    {
        $error = true;
        $err_msg .= '<br>Please select country';
    }

    if($state_id == '')
    {
        $error = true;
        $err_msg .= '<br>Please select state';
    }

    if($city_id == '')
    {
        $error = true;
        $err_msg .= '<br>Please select city';
    }

    if(!$error)
    {
        if($obj->addContractRecord($contract_person,$contract_person_type,$company_name,$contract_email,$contract_mobile,$address,$country_id,$state_id,$city_id,$place_id,$admin_id))
        {
            $msg = "Record Added Successfully!";
            header('location: index.php?mode=clients_master&msg='.urlencode($msg));
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
    $contract_person = '';
    $contract_person_type = '';
    $company_name = '';
    $contract_email = '';
    $contract_mobile = '';
    $address = '';
    $country_id = '';
    $state_id = '';
    $city_id = '';
    $place_id = '';
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Client</td>
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
                                        <td width="30%" align="right" valign="top"><strong>Client Name</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="company_name" id="company_name" value="<?php echo $company_name;?>" style="width:200px;"  >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Client Type</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select name="contract_person_type" id="contract_person_type" style="width:200px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php if($contract_person_type == '1'){?> selected="" <?php }?>>Broker</option>
                                                <option value="0" <?php if($contract_person_type == '0'){?> selected="" <?php }?>>Client</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Authorise Person</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <input type="text" name="contract_person" id="contract_person" value="<?php echo $contract_person;?>" style="width:200px;"  >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="30%" align="right" valign="top"><strong>Email</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="contract_email" id="contract_email" value="<?php echo $contract_email;?>" style="width:200px;"  >
                                            &nbsp;<?php //<span class="small-note">(You can add multiple email id by comma separated)</span>?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="30%" align="right" valign="top"><strong>Mobile</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="contract_mobile" id="contract_mobile" value="<?php echo $contract_mobile;?>" style="width:200px;"  >
                                            &nbsp;<span class="small-note">(You can add multiple number by comma separated)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Address</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <textarea name="address" id="address" cols="30" rows="3"><?php echo $address; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Country</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select name="country_id" id="country_id" onchange="getStateOptions('<?php echo $state_id;?>')"  style="width:200px;">
                                                <option value="">Select Country</option>
                                                <?php echo $obj2->getCountryOptions($country_id);?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>State</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left" id="tdstate">
                                            <select name="state_id" id="state_id" onchange="getCityOptions('<?php echo $city_id;?>');" style="width:200px;">
                                                <option value="">Select State</option>
                                                <?php echo $obj2->getStateOptionsNew($country_id,$state_id); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>City</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left" id="tdcity">
                                            <select name="city_id" id="city_id" onchange="getPlaceOptions('<?php echo $place_id;?>');" style="width:200px;">
                                                <option value="">Select City</option>
                                                <?php echo $obj2->getCityOptions($state_id,$city_id); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Place</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left" id="tdplace">
                                            <select name="place_id" id="place_id" style="width:200px;">
                                                <option value="">Select Place</option>
                                                <?php echo $obj2->getPlaceOptions($state_id,$city_id,$place_id); ?>
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