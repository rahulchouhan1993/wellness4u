<?php

require_once('config/class.mysql.php');

require_once('classes/class.contents.php');


$obj = new Contents();


$edit_action_id = '377';


if (!$obj->isAdminLoggedIn()) {
    
    header("Location: index.php?mode=login");
    
    exit(0);
    
}
else

{

   $admin_id = $_SESSION['admin_id']; 

}


if (!$obj->chkValidActionPermission($admin_id, $edit_action_id)) {
    
    header("Location: index.php?mode=invalid");
    
    exit(0);
    
}

$error = false;
$err_msg = "";


if (isset($_POST['btnSubmit'])) {
    
    
    // echo '<br><pre>';
    
    // print_r($_POST);
    
    // echo '</pre>';
    
    // die();

    $id=$_GET['id'];

    $data=array(
    			'SMS_URL' =>$_POST['SMS_URL'],
    			'SMS_USERNAME' => $_POST['SMS_USERNAME'],
    			'SMS_PASSWORD' => $_POST['SMS_PASSWORD'],
    			'SMS_SENDERID'=>$_POST['SMS_SENDERID'],
    			'STATUS'=>$_POST['STATUS'],
    			);


    if ($_POST['SMS_URL'] == '') {
        
        $error = true;
        $err_msg = 'Please fill SMS URL';
    }

    if ($_POST['SMS_USERNAME'] == '') {
        
        $error = true;
        $err_msg = 'Please fill SMS USERNAME';
    }

    if ($_POST['SMS_PASSWORD'] == '') {
        
        $error = true;
        $err_msg = 'Please fill SMS PASSWORD';
    }

    if ($_POST['SMS_SENDERID'] == '') {
        
        $error = true;
        $err_msg = 'Please fill SMS SENDERID';
    }
    
 
    if (!$error) {
            

        if ($obj->update_SMS_credential($admin_id,$data,$id)) {
            
            $msg = "Record Update Successfully!";
            
             header('location: index.php?mode=manage_sms_credentials&msg=' . urlencode($msg));
        }
        
        else {
            
            $error = true;
            
            $err_msg = "Currently there is some problem.Please try again later.";
            
        }
        
    }
    
}
elseif(isset($_GET['id']))
{
    $data = $obj->get_SMS_Credential_data($_GET['id']); 

}



?>

<div id="central_part_contents">

    <div id="notification_contents">

    <?php

if ($error) {
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

                            <td class="notification-body-e"><?php
    echo $err_msg;
?></td>

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

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit SMS Credential</td>

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

                            <form action="#" method="post"  enctype="multipart/form-data" >

                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">

                                <tbody>

                                    <tr>

                                        <td colspan="3" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                     <tr>

                                        <td width="30%" align="right" valign="top"><strong>SMS URL</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <input type="text" name="SMS_URL" id="SMS_URL" value="<?php echo $data['SMS_URL']; ?>" style="width:200px;height: 24px;">

                                           

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="3" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                        <tr>

                                            <td width="30%" align="right" valign="top"><strong>SMS USERNAME</strong></td>

                                            <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                            <td width="65%" align="left" valign="top">

                                            <input type="text" name="SMS_USERNAME" id="SMS_USERNAME" value="<?php echo $data['SMS_USERNAME']; ?>" style="width:200px;height: 24px;">

                                            </td>

                                        </tr>

                                       
                                <tr>

                                    <td colspan="3" align="center">&nbsp;</td>

                                </tr>


                                <tr>

                                    <td width="30%" align="right" valign="top"><strong>SMS PASSWORD</strong></td>

                                    <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                    <td width="65%" align="left" valign="top">

                                       <input type="text" name="SMS_PASSWORD" id="SMS_PASSWORD" value="<?php echo $data['SMS_PASSWORD']; ?>" style="width:200px;height: 24px;">
                                        

                                    </td>

                                </tr>

                                <tr>

                                    <td colspan="3" align="center">&nbsp;</td>

                                </tr>

                                <tr>

                                    <td width="30%" align="right" valign="top"><strong>SMS SENDERID</strong></td>

                                    <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                    <td width="65%" align="left" valign="top">

                                       <input type="text" name="SMS_SENDERID" id="SMS_SENDERID" value="<?php echo $data['SMS_SENDERID']; ?>" style="width:200px;height: 24px;">
                                        

                                    </td>

                                </tr>

                                <tr>

                                    <td colspan="3" align="center">&nbsp;</td>

                                </tr>

                                <tr>
                                        

                                        <td width="30%" align="right" valign="top"><strong>STATUS</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="STATUS" id="STATUS" style="width:200px; height: 24px;">

                                                <option value="1" <?php if($data['STATUS'] == '1'){ ?> selected <?php } ?>>Active</option>

                                                <option value="0" <?php if($data['STATUS'] == '0'){ ?> selected <?php } ?>>Inactive</option>

                                            </select>

                                        </td>

                                    </tr>


                                      <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

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
