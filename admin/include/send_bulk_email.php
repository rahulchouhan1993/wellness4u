<?php
require_once('config/class.mysql.php');
require_once('classes/class.autoresponders.php');  
require_once('classes/class.places.php');
require_once('classes/class.subscriptions.php');

$obj = new Autoresponders();
$obj2 = new Places();
$obj3 = new Subscriptions();

$add_action_id = '216';

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
$trlocation = 'none';
$truserplan = 'none';
$tradviserplan = 'none';
$arr_state_id = array();
$arr_city_id = array();
$arr_place_id = array();
$arr_up_id = array();
$arr_ap_id = array();
$str_selected_user_id = '';
$str_selected_adviser_id = '';

if(isset($_POST['btnSubmit']))
{
	//echo '<br><pre>';
	//print_r($_POST);
	//echo '<br></pre>';

	$ult_id = trim($_POST['ult_id']);
	$country_id = trim($_POST['country_id']);
	$email_ar_id = trim($_POST['email_ar_id']);
	$email_subject = trim($_POST['email_subject']);
	$email_from_name = trim($_POST['email_from_name']);
	$email_from_email = trim($_POST['email_from_email']);
	$email_body = trim($_POST['email_body']);
	$str_selected_user_id = trim($_POST['hdnstr_selected_user_id']);
	$str_selected_adviser_id = trim($_POST['hdnstr_selected_adviser_id']);
	
	foreach ($_POST['state_id'] as $key => $value) 
	{
		array_push($arr_state_id,$value);
	}
	
	foreach ($_POST['city_id'] as $key => $value) 
	{
		array_push($arr_city_id,$value);
	}
	
	foreach ($_POST['place_id'] as $key => $value) 
	{
		array_push($arr_place_id,$value);
	}
	
	foreach ($_POST['up_id'] as $key => $value) 
	{
		array_push($arr_up_id,$value);
	}
	
	foreach ($_POST['ap_id'] as $key => $value) 
	{
		array_push($arr_ap_id,$value);
	}
	
	if($ult_id == "")
	{
		$error = true;
		$err_msg = "Please select user list type.";
	}
	elseif($ult_id == '1' || $ult_id == '3' || $ult_id == '5')
	{
		if($str_selected_user_id == '')
		{
			$error = true;
			$err_msg = "Please select atleast one user.";
		}
	}
	elseif($ult_id == '2' || $ult_id == '4' || $ult_id == '6')
	{
		if($str_selected_adviser_id == '')
		{
			$error = true;
			$err_msg = "Please select atleast one adviser.";
		}	
	}
	
	if($ult_id == '3')
	{
		$truserplan = '';
	}
	elseif($ult_id == '4')
	{
		$tradviserplan = '';
	}
	elseif($ult_id == '5' || $ult_id == '6')
	{
		$trlocation = '';
	}
	
	if($email_ar_id == "")
	{
		$error = true;
		$err_msg .= "<br>Please select bulk email campaign.";
	}
	
	if($email_subject == "")
	{
		$error = true;
		$err_msg .= "<br>Please enter subject.";
	}
	
	if($email_from_name == "")
	{
		$error = true;
		$err_msg .= "<br>Please enter from name.";
	}
	
	if($email_from_email == "")
	{
		$error = true;
		$err_msg .= "<br>Please enter from email.";
	}
	
	if($email_body == "")
	{
		$error = true;
		$err_msg .= "<br>Please enter email body.";
	}
		
	if(!$error)
	{
		if($arr_state_id[0] == '')
		{
			$str_state_id = '';
		}
		else
		{
			$str_state_id = implode(',',$arr_state_id);
		}
		
		if($arr_city_id[0] == '')
		{
			$str_city_id = '';
		}
		else
		{
			$str_city_id = implode(',',$arr_city_id);
		}
		
		if($arr_place_id[0] == '')
		{
			$str_place_id = '';
		}
		else
		{
			$str_place_id = implode(',',$arr_place_id);
		}
		
		if($arr_up_id[0] == '')
		{
			$str_up_id = '';
		}
		else
		{
			$str_up_id = implode(',',$arr_up_id);
		}
		
		if($arr_ap_id[0] == '')
		{
			$str_ap_id = '';
		}
		else
		{
			$str_ap_id = implode(',',$arr_ap_id);
		}
	
		$arr_temp_reciever_user_id = array();
		if($ult_id == '2' || $ult_id == '4' || $ult_id == '6')
		{
			$arr_temp_reciever_user_id = explode(',',$str_selected_adviser_id);	
			$reciever_user_type = 'Adviser';
		}
		else
		{
			$arr_temp_reciever_user_id = explode(',',$str_selected_user_id);
			$reciever_user_type = 'User';	
		}
		
		$total_record = 0;
		$success_record = 0;
		$failed_record = 0;
		
		for($i=0;$i<count($arr_temp_reciever_user_id);$i++)
		{
			list($reciever_email,$reciever_name,$reciever_unique_id) = $obj->getUserSendingEmailDetails($arr_temp_reciever_user_id[$i],$reciever_user_type);
						
			$to_email = $reciever_email;
			$from_email = $email_from_email;
			$from_name = $email_from_name;
			
			$subject = $email_subject;
			$subject = str_ireplace("[[USER_NAME]]", $reciever_name, $subject);
			$subject = str_ireplace("[[ADVISER_NAME]]", $reciever_name, $subject);
			$subject = str_ireplace("[[NAME]]", $reciever_name, $subject);
			
			$message = $email_body;
			$message = str_ireplace("[[USER_NAME]]", $reciever_name, $message);
			$message = str_ireplace("[[ADVISER_NAME]]", $reciever_name, $message);
			$message = str_ireplace("[[NAME]]", $reciever_name, $message);
			$message = str_ireplace("[[USER_EMAIL]]", $reciever_email, $message);
			$message = str_ireplace("[[ADVISER_EMAIL]]", $reciever_email, $message);
			$message = str_ireplace("[[EMAIL]]", $reciever_email, $message);
			$message = str_ireplace("[[USER_UNIQUE_ID]]", $reciever_unique_id, $message);
			$message = str_ireplace("[[ADVISER_UNIQUE_ID]]", $reciever_unique_id, $message);
			$message = str_ireplace("[[UNIQUE_ID]]", $reciever_unique_id, $message);
			
			$mail = new PHPMailer();
			$mail->IsHTML(true);
			$mail->Host = "batmobile.websitewelcome.com"; // SMTP server
			$mail->From = $from_email;
			$mail->FromName = $from_name;
			$mail->AddAddress($to_email);
			$mail->Subject = $subject;
			$mail->Body = $message;
			$mail->Send();
			$mail->ClearAddresses();
			
			if($obj->addEmailCampaignDetails($ult_id,$country_id,$str_state_id,$str_city_id,$str_place_id,$str_up_id,$str_ap_id,$arr_temp_reciever_user_id[$i],$reciever_name,$reciever_email,$email_ar_id,$email_from_name,$email_from_email,$subject,$message,$reciever_user_type))
			{
				$success_record++;
			}
			else
			{
				$failed_record++;
			}
			$total_record++;
		}	
		
		$msg .= "Email sents successfuly";
		$msg .= "<br>Total Sent Records = ".$total_record;
		$msg .= "<br>Total Success = ".$success_record;
		$msg .= "<br>Total Failed = ".$failed_record;
		header('location: index.php?mode=view_sent_bulk_emails&msg='.urlencode($msg));
		exit(0);
	}	
}
else
{
	$ult_id = '';
	$email_subject = '';
	$email_from_name = 'Info';
	$email_from_email = 'info@wellnessway4u.com';
	$email_ar_to_email = '';
	$email_body = '';
	$email_ar_id = '';
	
	$country_id = '';
	$arr_state_id[0] = '';
	$arr_city_id[0] = '';
	$arr_place_id[0] = '';
	$arr_up_id[0] = '';
	$arr_ap_id[0] = '';
}
?>
<!-- TinyMCE -->
	<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
	
		tinyMCE.init({
			mode : "exact",
			theme : "advanced",
			elements : "email_body",
			plugins : "style,advimage,advlink,emotions",
			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",
			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code",
		});
	</script>
	<!-- /TinyMCE -->
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Send Bulk Email</td>
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
							<form action="#" method="post" name="frmedit_banner" id="frmedit_banner" enctype="multipart/form-data" >
                            <input type="hidden" name="hdnstr_selected_user_id" id="hdnstr_selected_user_id" value="<?php echo $str_selected_user_id;?>"  />
                            <input type="hidden" name="hdnstr_selected_adviser_id" id="hdnstr_selected_adviser_id" value="<?php echo $str_selected_adviser_id;?>"  />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblbanner">
							<tbody>
								<tr>
									<td width="20%" align="right" valign="top"><strong>User List Type</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left" valign="top">
                                        <select name="ult_id" id="ult_id" style="width:400px;" onchange="toggleUserListTypeSelection();">
                                            <option value="">Select Action</option>
                                            <?php echo $obj->getUserListTypeOptions($ult_id); ?>
                                        </select>
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="truserplan" style="display:<?php echo $truserplan;?>">
									<td align="right" valign="top"><strong>Users Subscription List</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                        <select multiple="multiple" name="up_id[]" id="up_id" onchange="getUserTypeSelectedEmailList();" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_up_id)) {?> selected="selected" <?php } ?>><?php echo $obj3->getUserDefaultPlanName(); ?></option>
											<?php echo $obj3->getAllUserPlansOptionsMulti($arr_up_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr class="truserplan" style="display:<?php echo $truserplan;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="tradviserplan" style="display:<?php echo $tradviserplan;?>">
									<td align="right" valign="top"><strong>Advisers Subscription List</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                        <select multiple="multiple" name="ap_id[]" id="ap_id" onchange="getUserTypeSelectedEmailList();" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_ap_id)) {?> selected="selected" <?php } ?>><?php echo $obj3->getAdviserDefaultPlanName(); ?></option>
											<?php echo $obj3->getAllAdviserPlansOptionsMulti($arr_ap_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr class="tradviserplan" style="display:<?php echo $tradviserplan;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td align="right" valign="top"><strong>Country</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                        <select name="country_id" id="country_id" onchange="getStateOptionsMulti(); getUserTypeSelectedEmailList();" style="width:200px;">
											<option value="" >All Country</option>
											<?php echo $obj2->getCountryOptions($country_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td align="right" valign="top"><strong>State</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top" id="tdstate">
                                        <select multiple="multiple" name="state_id[]" id="state_id" onchange="getCityOptionsMulti();" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_state_id)) {?> selected="selected" <?php } ?>>All States</option>
											<?php echo $obj2->getStateOptionsMulti($country_id,$arr_state_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td align="right" valign="top"><strong>City</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top" id="tdcity">
                                        <select multiple="multiple" name="city_id[]" id="city_id" onchange="getPlaceOptionsMulti();" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_city_id)) {?> selected="selected" <?php } ?>>All Cities</option>
											<?php echo $obj2->getCityOptionsMulti($country_id,$arr_state_id,$arr_city_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td align="right" valign="top"><strong>Place</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top" id="tdplace">
                                        <select multiple="multiple" name="place_id[]" id="place_id" style="width:200px;">
											<option value="" <?php if (in_array('', $arr_place_id)) {?> selected="selected" <?php } ?>>All Places</option>
											<?php echo $obj2->getPlaceOptionsMulti($country_id,$arr_state_id,$arr_city_id,$arr_place_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr class="trlocation" style="display:<?php echo $trlocation;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right" valign="top"><strong>Select To Email</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
										<div id="user_selection_list" style="float:left; width:400px; height:400px; border:1px solid #222222;">
                                        </div>
									</td>
								</tr>
								
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>
									<td align="right" valign="top"><strong>Email Campaign</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                        <select name="email_ar_id" id="email_ar_id" onchange="setBulkEmailCampaignValues();" style="width:400px;">
											<option value="" >Select Bulk Email Campaign</option>
											<?php echo $obj->getBulkEmailCampaingOptions($email_ar_id); ?>
										</select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Email From Name</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
										<input type="text" name="email_from_name" id="email_from_name" value="<?php echo $email_from_name;?>" style="width:400px;" />
									</td>
								</tr>
								
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Email From Email</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
										<input type="text" name="email_from_email" id="email_from_email" value="<?php echo $email_from_email;?>" style="width:400px;" />
									</td>
								</tr>
								
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Email Subject</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
										<input type="text" name="email_subject" id="email_subject" value="<?php echo $email_subject;?>" style="width:400px;" />
									</td>
								</tr>
								
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Email Body</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                    	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        	<tr>
                                            	<td width="60%" align="left" valign="top">
													<textarea id="email_body" name="email_body" style="width: 400px; height:400px;"><?php echo stripslashes($email_body);?></textarea>
                                                </td>    
                                                <td width="40%" align="left" valign="top" style="font-size:12px; font-weight:bold;">
                                                    <p>Guidelines for Using Dynamic Variables</p>
                                                    <p>[[EMAIL]] - Email of User</p>
                                                    <p>[[NAME]] - Name of User</p>
                                                    <p>[[UNIQUE_ID]] - Unique Id of User</p>
                                                </td>    
                                            </tr>
                                        </table>        
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
<script type="text/javascript">
	// $(document).ready(function(){
	// 	getUserTypeSelectedEmailList();
	// });	


	function toggleUserListTypeSelection()

{


	var ult_id = document.getElementById('ult_id').value;

	if (ult_id == "3" ) 

	{

		$('.truserplan').show();

		$('.tradviserplan').hide();	

		$('.trlocation').hide();

	}

	else if (ult_id == "4" ) 

	{

		$('.truserplan').hide();

		$('.tradviserplan').show();	

		$('.trlocation').hide();

	}

	else if (ult_id == "5" || ult_id == "6") 

	{

		$('.truserplan').hide();

		$('.tradviserplan').hide();	

		$('.trlocation').show();	

	}

	else

	{ 	

		$('.truserplan').hide();	

		$('.tradviserplan').hide();	

	  	$('.trlocation').hide();	

	}



	getUserTypeSelectedEmailList();

}




function getUserTypeSelectedEmailList()

{

	var ult_id = $('#ult_id').val();
	var country_id = $('#country_id').val();
	var str_selected_user_id = $('#hdnstr_selected_user_id').val();
	var str_selected_adviser_id = $('#hdnstr_selected_adviser_id').val();

	
	var obj_state_id = document.getElementById('state_id');
	var str_state_id = "";

	 	
	for (var x=0;x<obj_state_id.length;x++)
	{
		if (obj_state_id[x].selected)

		{

			str_state_id = str_state_id + obj_state_id[x].value;
	
		}

	}



	var obj_city_id = document.getElementById('city_id');

	var str_city_id = "";

	


	for (var x=0;x<obj_city_id.length;x++)

	{

		if (obj_city_id[x].selected)

		{

			str_city_id = str_city_id + obj_city_id[x].value ;

		}

	}

	

	var obj_place_id = document.getElementById('place_id');

	var str_place_id = "";

	

	for (var x=0;x<obj_place_id.length;x++)
	{
		if (obj_place_id[x].selected)

		{
            
			str_place_id = str_place_id + obj_place_id[x].value ;
           
		}

	}
 
	

	var obj_ap_id = document.getElementById('ap_id');

	var str_ap_id = "";

	

	for (var x=0;x<obj_ap_id.length;x++)

	{

		if (obj_ap_id[x].selected)

		{

			str_ap_id = str_ap_id + obj_ap_id[x].value;
       
		}

	}

	

	var obj_up_id = document.getElementById('up_id');

	var str_up_id = "";

	

	for (var x=0;x<obj_up_id.length;x++)

	{

		if (obj_up_id[x].selected)

		{

			str_up_id = str_up_id + obj_up_id[x].value;

		}

	}



	// startPageLoading();


    

	link='include/remote.php?action=getusertypeselectedemaillist&ult_id='+ult_id+'&country_id='+country_id+'&str_state_id='+str_state_id+'&str_city_id='+str_city_id+'&str_place_id='+str_place_id+'&str_selected_user_id='+str_selected_user_id+'&str_selected_adviser_id='+str_selected_adviser_id+'&str_ap_id='+str_ap_id+'&str_up_id='+str_up_id;



	var linkComp = link.split( "?");
	var result;
	 // console.log(linkComp);


	var obj = new ajaxObject(linkComp[0], fin);

	obj.update(linkComp[1],"GET");

	obj.callback = function (responseTxt, responseStat) {

	

		result = responseTxt;

		$('#user_selection_list').html(result);

		

		$('#state_id').change(function() { getUserTypeSelectedEmailList(); });

		$('#city_id').change(function() { getUserTypeSelectedEmailList(); });

		$('#place_id').change(function() { getUserTypeSelectedEmailList(); });

		getSelectedUserListIds();

		stopPageLoading();

	}

}

function getSelectedUserListIds()

{
        //alert('Hiii');
	var ult_id = $('#ult_id').val();	

	var checkValues = $('input:checkbox[name="selected_user_id"]:checked').map(function() {																   

			return $(this).val();

		}).get();

	

	var str_uid = String(checkValues);

	//alert(str_uid);

	

	if (ult_id == "2" || ult_id == "4" || ult_id == "6") 

	{

		$('#hdnstr_selected_adviser_id').val(str_uid);

		$('#hdnstr_selected_user_id').val(str_uid);

	}

	else

	{ 

		$('#hdnstr_selected_adviser_id').val(str_uid);

	  	$('#hdnstr_selected_user_id').val(str_uid);

	}

}

function startPageLoading()

{

	document.getElementById('page_loading_bg').style.display = ''; 	

}

</script>