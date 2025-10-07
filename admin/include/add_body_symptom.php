<?php
require_once('config/class.mysql.php');
require_once('classes/class.bodyparts.php');

$obj = new BodyParts();

$add_action_id = '224';

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

$arr_min_rating = array();
$arr_max_rating = array();
$arr_interpretaion = array();
$arr_treatment = array();

$row_cnt = '1';
$row_totalRow = '1';

if(isset($_POST['btnSubmit']))
{
	$row_totalRow = trim($_POST['hdnrow_totalRow']);  
	$row_cnt = trim($_POST['hdnrow_cnt']);
	$bms_id = trim($_POST['bms_id']);
	$bp_id = trim($_POST['bp_id']);
	$bs_remarks = trim($_POST['bs_remarks']);
	
	foreach ($_POST['min_rating'] as $key => $value) 
	{
            array_push($arr_min_rating,$value);
	}
	
	foreach ($_POST['max_rating'] as $key => $value) 
	{
            array_push($arr_max_rating,$value);
	}
	
	foreach ($_POST['interpretaion'] as $key => $value) 
	{
            array_push($arr_interpretaion,$value);
	}
	
	foreach ($_POST['treatment'] as $key => $value) 
	{
            array_push($arr_treatment,$value);
	}
	
	if($bms_id == '')
	{
            $error = true;
            $err_msg = 'Please select symptom';
	}
        
        if($bp_id == '')
	{
            $error = true;
            $err_msg .= '<br>Please select body part';
	}
	
	
	if(!$error)
	{
	    if($obj->addBodySymptom($bms_id,$bp_id,$bs_remarks,$arr_min_rating,$arr_max_rating,$arr_interpretaion,$arr_treatment))
            {
                    $msg = "Record Added Successfully!";
                    header('location: index.php?mode=body_symptoms&msg='.urlencode($msg));
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
	$bms_id = '';
        $bp_id = '';
        $bs_remarks = '';
	$arr_min_rating[0] = '0';
	$arr_max_rating[0] = '0';
	$arr_interpretaion[0] = '';
	$arr_treatment[0] = '';
}	
?>
<script type="text/javascript" src="js/jscolor.js"></script>
<script type="text/javascript"> 
	$(document).ready(function() {
		$('#addMoreRows').click(function() {
		
			var row_cnt = parseInt($('#hdnrow_cnt').val());
			var row_totalRow = parseInt($('#hdnrow_totalRow').val());
			
			$('#tblrow tr:#add_before_this_row').before('<tr id="row_id_1_'+row_cnt+'"><td align="right"><strong>Rating</strong></td><td align="center"><strong>:</strong></td><td align="left"><strong>From</strong>&nbsp;<select name="min_rating[]" id="min_rating_'+row_cnt+'"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select>&nbsp;&nbsp;<strong>To</strong>&nbsp;<select name="max_rating[]" id="max_rating_'+row_cnt+'"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></td></tr><tr id="row_id_2_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr id="row_id_3_'+row_cnt+'"><td align="right" valign="top"><strong>Interpretation</strong></td><td align="center" valign="top"><strong>:</strong></td><td align="left" valign="top"><textarea name="interpretaion[]" id="interpretaion_'+row_cnt+'" rows="5" cols="25"></textarea></td></tr><tr id="row_id_4_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr id="row_id_5_'+row_cnt+'"><td align="right" valign="top"><strong>Treatment</strong></td><td align="center" valign="top"><strong>:</strong></td><td align="left" valign="top"><textarea name="treatment[]" id="treatment_'+row_cnt+'" rows="5" cols="25"></textarea>&nbsp;<input type="button" value="Remove Item" id="tr_row_'+row_cnt+'" name="tr_row_'+row_cnt+'" onclick="removeRows('+row_cnt+')" /></td></tr><tr id="row_id_6_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr>');	
				
			row_cnt = row_cnt + 1;       
			$('#hdnrow_cnt').val(row_cnt);
			var row_cnt = $('#hdnrow_cnt').val();
			row_totalRow = row_totalRow + 1;       
			$('#hdnrow_totalRow').val(row_totalRow);
						
		});
	});
</script>
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Body Symptoms</td>
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
                                <input type="hidden" name="hdnrow_cnt" id="hdnrow_cnt" value="<?php echo $row_cnt;?>" />
                                <input type="hidden" name="hdnrow_totalRow" id="hdnrow_totalRow" value="<?php echo $row_totalRow;?>" />
                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
                                <tbody>
                                    <tr>
                                        <td width="30%" align="right" valign="top"><strong>Symptom</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="bms_id" id="bms_id" style="width:200px;">
                                                <option value="" >Select</option>
                                                <?php echo $obj->getMainSymptomOptions($bms_id); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td align="right" valign="top"><strong>Body Part</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllBodyPartsSelectionStr($bp_id,'0');?>
                                        </td>
                                    </tr>
                                    <tr>
                                            <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top"><strong>Remarks</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <input type="text" name="bs_remarks" id="bs_remarks" value="<?php echo $bs_remarks;?>">
                                        </td>
                                    </tr>
                                    <tr>
                                            <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <?php
                                    for($i=0;$i<$row_totalRow;$i++)
                                    {  ?>
                                    <tr id="row_id_1_<?php echo $i;?>">
                                        <td align="right"><strong>Rating</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <strong>From</strong>&nbsp;
                                            <select name="min_rating[]" id="min_rating_<?php echo $i; ?>">
                                                <?php
                                                for($j=0;$j<=10;$j++)
                                                { ?>
                                                        <option value="<?php echo $j;?>" <?php if ($arr_min_rating[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                                <?php
                                                } ?>	
                                            </select>
                                            &nbsp;&nbsp;<strong>To</strong>&nbsp;
                                            <select name="max_rating[]" id="max_rating_<?php echo $i; ?>">
                                                <?php
                                                for($j=0;$j<=10;$j++)
                                                { ?>
                                                        <option value="<?php echo $j;?>" <?php if ($arr_max_rating[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                                <?php
                                                } ?>	
                                            </select>

                                        </td>
                                    </tr>
                                    <tr id="row_id_4_<?php echo $i;?>">
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr id="row_id_5_<?php echo $i;?>">
                                        <td align="right" valign="top"><strong>Interpretation</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <textarea name="interpretaion[]" id="interpretaion_<?php echo $i; ?>" rows="5" cols="25"><?php echo $arr_interpretaion[$i]; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr id="row_id_6_<?php echo $i;?>">
                                            <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr id="row_id_7_<?php echo $i;?>">
                                        <td align="right" valign="top"><strong>Treatment</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                                <textarea name="treatment[]" id="treatment_<?php echo $i; ?>" rows="5" cols="25"><?php echo $arr_treatment[$i]; ?></textarea>
                                                &nbsp;
                                                <?php
                                                if($i > 0)
                                                { ?>
                                                        <input type="button" value="Remove Item" id="tr_row_<?php echo $i; ?>" name="tr_row_<?php echo $i; ?>" onclick="removeRows('<?php echo $i;?>')" />
                                                <?php } ?>
                                        </td>
                                    </tr>
                                    <tr id="row_id_8_<?php echo $i;?>">
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <?php
                                    } ?>
                                    <tr id="add_before_this_row">
                                        <td align="right" valign="top">&nbsp;</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="left" valign="top"><a href="javascript:void(0)" target="_self" class="body_link" id="addMoreRows">Add More Rating</a></td>
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