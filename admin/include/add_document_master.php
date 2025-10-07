<?php
require_once('config/class.mysql.php');
require_once('classes/class.banner.php');  
require_once('classes/class.places.php');
require_once('classes/class.profilecustomization.php');
require_once('classes/class.contracts.php');

$obj = new Banner();
$obj2 = new Places();
$obj3 = new ProfileCustomization();
$obj4 = new Contracts();

$add_action_id = '240';

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
    $banner_client_id = strip_tags(trim($_POST['banner_client_id']));
    $banner_broker_id = strip_tags(trim($_POST['banner_broker_id']));
    $banner_contract_no = strip_tags(trim($_POST['banner_contract_no']));
    $banner_order_no = strip_tags(trim($_POST['banner_order_no']));
    $banner_contract_date = strip_tags(trim($_POST['banner_contract_date']));
    $banner_booked_date = strip_tags(trim($_POST['banner_booked_date']));
    $banner_cont_amount = strip_tags(trim($_POST['banner_cont_amount']));
    $currency = trim($_POST['currency']);
    $prct_cat_id = trim($_POST['prct_cat_id']);
    $ctt_id = trim($_POST['ctt_id']);
    $old_document_ref_no = trim($_POST['old_document_ref_no']);
    
    if($banner_client_id == '')
    {
        $error = true;
        $err_msg = 'Please select client name';
    }
    
    if($banner_order_no == '')
    {
        $error = true;
        $err_msg .= '<br>Please enter internal ref no';
    }
    
    if($ctt_id == '')
    {
        $error = true;
        $err_msg .= '<br>Please select document type';
    }
    
    if($banner_contract_no == '')
    {
        $error = true;
        $err_msg .= '<br>Please enter document no';
    }
    
    if($banner_contract_date == '')
    {
        $error = true;
        $err_msg .= '<br>Please enter document date';
    }
    
    if($banner_booked_date == '')
    {
        $error = true;
        $err_msg .= '<br>Please enter booked on date';
    }
    
    
    
    if($prct_cat_id == '')
    {
        $error = true;
        $err_msg .= '<br>Please select item category';
    }
    
    if($banner_cont_amount == "")
    {
        //$error = true;
        //$err_msg .= "<br>Please enter amount.";
        $currency = '';
    }
    else 
    {
        if(!is_numeric($banner_cont_amount))
        {
            $error = true;
            $err_msg .= "<br>Please enter valid amount.";
        }

        if($currency == "")
        {
            $error = true;
            $err_msg .= "<br>Please select currency.";
        }
    }
    
    

    if(!$error)
    {
        $banner_contract_date = date('Y-m-d',strtotime($banner_contract_date));
        $banner_booked_date = date('Y-m-d',strtotime($banner_booked_date));
        
        if($obj->addBannerContract($banner_client_id,$banner_broker_id,$banner_contract_no,$banner_order_no,$banner_contract_date,$banner_booked_date,$banner_cont_amount,$currency,$prct_cat_id,$ctt_id,$old_document_ref_no,$admin_id))
        {
            $msg = "Record Added Successfully!";
            header('location: index.php?mode=document_master&msg='.urlencode($msg));
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
    $banner_client_id = '';
    $banner_broker_id = '';
    $banner_contract_no = '';
    $banner_order_no = '';
    $banner_contract_date = '';
    $banner_booked_date = '';
    $banner_cont_amount = '';
    $currency = '';
    $prct_cat_id = '';
    $ctt_id = '';
    $old_document_ref_no = '';
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Document</td>
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
                                            <select name="banner_client_id" id="banner_client_id" style="width:200px;" onchange="getEarlierDocumentRefOptions()">
                                                <option value="">Select Client</option>
                                                <?php echo $obj->getClientsOptions($banner_client_id,'0');?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Internal Ref No</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <input type="text" name="banner_order_no" id="banner_order_no" value="<?php echo $banner_order_no;?>" style="width:200px;"  >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Document Type</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                           <select name="ctt_id" id="ctt_id" style="width:200px;">
                                                <option value="">Select Document Type</option>
                                                <?php echo $obj4->getContractsTransactionTypeOptions($ctt_id); ?>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Document No</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <input type="text" name="banner_contract_no" id="banner_contract_no" value="<?php echo $banner_contract_no;?>" style="width:200px;"  >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Document Date</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <input type="text" name="banner_contract_date" id="banner_contract_date" value="<?php echo $banner_contract_date;?>" style="width:200px;"  >
                                            <script>$('#banner_contract_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Booked on Date</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <input type="text" name="banner_booked_date" id="banner_booked_date" value="<?php echo $banner_booked_date;?>" style="width:200px;"  >
                                            <script>$('#banner_booked_date').datepick({  dateFormat : 'dd-mm-yy'}); </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="30%" align="right" valign="top"><strong>Booked Through</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="banner_broker_id" id="banner_broker_id" style="width:200px;">
                                                <option value="">Select Client</option>
                                                <?php echo $obj->getClientsOptions($banner_broker_id,'1');?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Earlier Document Ref</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top" id="tdolddocrefno">
                                           <select name="old_document_ref_no" id="old_document_ref_no" style="width:200px;">
                                                <option value="">Select Earlier Document Ref</option>
                                                <?php echo $obj->getEarlierDocumentRefOptions($banner_client_id,$old_document_ref_no); ?>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Item Category</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                           <select name="prct_cat_id" id="prct_cat_id" style="width:200px;">
                                                <option value="">Select Item Category</option>
                                                <?php echo $obj3->getPRCTCategoryOptions($prct_cat_id); ?>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Amount</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <input type="text" name="banner_cont_amount" id="banner_cont_amount" value="<?php echo $banner_cont_amount;?>" style="width:200px;"  >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Currency</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                           <select name="currency" id="currency" style="width:200px;">
                                                <option value="">Select Currency</option>
                                                <?php echo $obj->getCurrencyOptions($currency); ?>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="left">
                                            <input type="Submit" name="btnSubmit" value="Submit" />&nbsp;
                                            <input type="button" name="btnCancel" value="Cancel" onclick="window.location.href='index.php?mode=document_master'">
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