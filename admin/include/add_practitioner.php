<?php
require_once('config/class.mysql.php');
require_once('classes/class.users.php');

$obj = new Users();

$add_action_id = '170';

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

$arr_membership = array();
$arr_err_membership = array();
$arr_tr_err_membership = array();
$arr_membership_no = array();
$arr_membership_image = array();

$arr_service_clinic_name = array();
$arr_service_location = array();
$arr_service_location_country_id = array();
$arr_service_location_state_id = array();
$arr_service_location_city_id = array();
$arr_service_location_place_id = array();
$arr_service_rendered = array();
$arr_service_notes = array();

$row_cnt = '1';
$row_totalRow = '1';

$row_cnt2 = '1';
$row_totalRow2 = '1';

if(isset($_POST['btnSubmit']))
{
	$row_totalRow = trim($_POST['hdnrow_totalRow']);  
	$row_cnt = trim($_POST['hdnrow_cnt']);
	$row_totalRow2 = trim($_POST['hdnrow_totalRow2']);  
	$row_cnt2 = trim($_POST['hdnrow_cnt2']);
	$name = strip_tags(trim($_POST['name']));
	$email = strip_tags(trim($_POST['email']));
	$dob = strip_tags(trim($_POST['dob']));
	$sex = strip_tags(trim($_POST['sex']));
	$mobile = strip_tags(trim($_POST['mobile']));
	$address = strip_tags(trim($_POST['address']));
	$country_id = strip_tags(trim($_POST['country_id']));
	$state_id = strip_tags(trim($_POST['state_id']));
	$city_id = strip_tags(trim($_POST['city_id']));
	$place_id = strip_tags(trim($_POST['place_id']));
	$reg_no   = strip_tags(trim($_POST['reg_no']));
	$issued_by = strip_tags(trim($_POST['issued_by']));    
	
	foreach ($_POST['membership'] as $key => $value) 
	{
		array_push($arr_membership,$value);
		array_push($arr_tr_err_membership,'none');
		array_push($arr_err_membership,'');
	}
	
	foreach ($_POST['membership_no'] as $key => $value) 
	{
		array_push($arr_membership_no,$value);
	}
	
	foreach ($_POST['service_clinic_name'] as $key => $value) 
	{
		array_push($arr_service_clinic_name,$value);
	}
	
	foreach ($_POST['service_location'] as $key => $value) 
	{
		array_push($arr_service_location,$value);
	}
	
	foreach ($_POST['hdncountry_id_sl'] as $key => $value) 
	{
		array_push($arr_service_location_country_id,$value);
	}
	
	foreach ($_POST['hdnstate_id_sl'] as $key => $value) 
	{
		array_push($arr_service_location_state_id,$value);
	}
	
	foreach ($_POST['hdncity_id_sl'] as $key => $value) 
	{
		array_push($arr_service_location_city_id,$value);
	}
	
	foreach ($_POST['hdnplace_id_sl'] as $key => $value) 
	{
		array_push($arr_service_location_place_id,$value);
	}
	
	foreach ($_POST['service_rendered'] as $key => $value) 
	{
		array_push($arr_service_rendered,$value);
	}
	
	foreach ($_POST['service_notes'] as $key => $value) 
	{
		array_push($arr_service_notes,$value);
	}
	
	$referred_by = strip_tags(trim($_POST['referred_by']));
	$ref_name = strip_tags(trim($_POST['ref_name']));
	$specify = strip_tags(trim($_POST['specify']));
	$password = trim($_POST['password']);
	$cpassword = trim($_POST['cpassword']); 
	
	if($name == '')
	{
		$error = true;
		$err_msg = 'Please enter your name';
	}
	
	
	if($email == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter email';
	}
	elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
	{
		$error = true;
		$err_msg .= '<br>Please enter valid email';
	}
	elseif($obj->chkProEmailExists($email))
	{
		$error = true;
		$err_msg .= '<br>This email already registered';
	}
	
	if($password == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter password';
	}
	elseif(!$obj->chkValidPassword($password))
	{
		$error = true;
		$err_msg .= '<br>Please enter valid Password. Atleast 1 Upper case alphabate[A-Z], 1 Lower case alphabate[a-z] , 1 Numeric[0-9] , 1 special characters[!@#$%^&*()-_=+,<>./?]';
	}
	
	if($cpassword == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter confirm password';
	}
	elseif($cpassword != $password)
	{
		$error = true;
		$err_msg .= '<br>Please enter same confirm password';
	}
	
	if(!$error)
	{
		for($i=0;$i<count($arr_membership);$i++)
		{
			if(isset($_FILES['membership_image']['tmp_name'][$i]) && $_FILES['membership_image']['tmp_name'][$i] != '')
			{
				$membership_image = $_FILES['membership_image']['name'][$i];
				
				$file4 = substr($membership_image, -4, 4);
				 
				if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))
				{
					$error = true;
					$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for membership scan image';
				}	 
				elseif( $_FILES['membership_image']['type'][$i] != 'image/jpeg' and $_FILES['membership_image']['type'][$i] != 'image/pjpeg'  and $_FILES['membership_image']['type'][$i] != 'image/gif' and $_FILES['membership_image']['type'][$i] != 'image/png' )
				{
					$error = true;
					$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for membership scan image!';
				}
			
				if(!$error)
				{	
					$membership_image = time()."_".$membership_image;
					$temp_dir = SITE_PATH.'/uploads/';
					$temp_file = $temp_dir.$membership_image;
			
					if(!move_uploaded_file($_FILES['membership_image']['tmp_name'][$i], $temp_file)) 
					{
						if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
						$error = true;
						$err_msg .= '<br>Couldn\'t Upload membership scan image.';
						$membership_image = '';
					}
					$arr_membership_image[$i] = $membership_image;
				}
				else
				{	
					$arr_membership_image[$i] = '';
				}
			}  
			else
			{	
				$arr_membership_image[$i] = '';
			}
		}
	
		if(isset($_FILES['scan_image']['tmp_name']) && $_FILES['scan_image']['tmp_name'] != '')
		{
			$scan_image = $_FILES['scan_image']['name'];
			$file4 = substr($scan_image, -4, 4);
			
			if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))
			{
				$error = true;
				$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for scan image';
			}	 
			elseif( $_FILES['scan_image']['type'] != 'image/jpeg' and $_FILES['scan_image']['type'] != 'image/pjpeg'  and $_FILES['scan_image']['type'] != 'image/gif' and $_FILES['scan_image']['type'] != 'image/png' )
			{
				$error = true;
				$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for scan image';
			}
			
			
			if(!$error)
			{	
				
				$scan_image = time()."_".$scan_image;
				$temp_dir = SITE_PATH.'/uploads/';
				$temp_file = $temp_dir.$scan_image;
		
				if(!move_uploaded_file($_FILES['scan_image']['tmp_name'], $temp_file)) 
				{
					if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
					$error = true;
					$err_msg .= '<br>Couldn\'t Upload scan image';
					$scan_image = '';
				}
			}
		}  
		else
		{
			$scan_image = '';
		}
		
		if(!$error)
		{
		
			$dob = date('Y-m-d',strtotime($dob));
			
			$membership = implode('::',$arr_membership);
			$membership_no = implode('::',$arr_membership_no);
			$membership_image = implode('::',$arr_membership_image);
			$service_clinic_name = implode('::',$arr_service_clinic_name);
			$service_location = implode('::',$arr_service_location);
			$service_location_country_id = implode('::',$arr_service_location_country_id);
			$service_location_state_id = implode('::',$arr_service_location_state_id);
			$service_location_city_id = implode('::',$arr_service_location_city_id);
			$service_location_place_id = implode('::',$arr_service_location_place_id);
			$service_rendered = implode('::',$arr_service_rendered);
			$service_notes = implode('::',$arr_service_notes);
			
//			if($obj->signUpProUser($name,$email,$password,$dob,$sex,$mobile,$address,$country_id,$state_id,$city_id,$place_id,$reg_no,$issued_by,$scan_image,$membership,$membership_no,$membership_image,$service_clinic_name,$service_location,$service_location_country_id,$service_location_state_id,$service_location_city_id,$service_location_place_id,$service_rendered,$service_notes,$referred_by,$ref_name,$specify))
			if($obj->signUpProUserVivek($name,$email,$password,$dob,$sex,$mobile,$address,$country_id,$state_id,$city_id,$place_id,$reg_no,$issued_by,$scan_image,$membership,$membership_no,$membership_image,$service_clinic_name,$service_location,$service_location_country_id,$service_location_state_id,$service_location_city_id,$service_location_place_id,$service_rendered,$service_notes,$referred_by,$ref_name,$specify))
			{
				$msg = "User Added Successfully!";
				header('location: index.php?mode=practitioners&msg='.urlencode($msg));
			}
			else
			{
				$error = true;
				$err_msg = "Currently there is some problem.Please try again later.";
			}
		}
	}
}
else
{
	$name = '';
	$email = '';
	$dob = '';
	$sex = '';
	$mobile = '';
	$address = '';
	$country_id = '';
	$state_id = '';
	$city_id = '';
	$place_id = '';
	$reg_no = '';
	$issued_by = '';  
	$scan_image = '';  
	$arr_tr_err_membership[0] = 'none';
	$arr_err_membership[0] = '';
	$arr_membership[0] = '';
	$arr_membership_no[0] = '';
	$arr_membership_image[0] = '';
	$arr_service_clinic_name[0] = '';
	$arr_service_location[0] = '';
	$arr_service_location_country_id[0] = '';
	$arr_service_location_state_id[0] = '';
	$arr_service_location_city_id[0] = '';
	$arr_service_location_place_id[0] = '';
	$arr_service_rendered[0] = '';
	$arr_service_notes[0] = '';
	$referred_by = '';
	$ref_name = '';
	$specify = '';
	$password = '';
	$cpassword = '';
}
?>
<script type="text/javascript">
		$(document).ready(function() {
			
			
			$('#addMoreMembershipRows').click(function() {
		
				var row_cnt = parseInt($('#hdnrow_cnt').val());
				var row_totalRow = parseInt($('#hdnrow_totalRow').val());
				
				$('#tblrow tr:#add_before_this_row').before('<tr class="row_id_membership_'+row_cnt+'"><td align="right"><strong>Memberships</strong></td><td align="center"><strong>:</strong></td><td align="left"><input name="membership[]" type="text" id="membership_'+row_cnt+'" size="45" value="" /></td></tr><tr class="row_id_membership_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr class="row_id_membership_'+row_cnt+'"><td align="right"><strong>Memberships No</strong></td><td align="center"><strong>:</strong></td><td align="left"><input name="membership_no[]" type="text" id="membership_no_'+row_cnt+'" size="45" value="" /></td></tr><tr class="row_id_membership_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr><tr class="row_id_membership_'+row_cnt+'"><td align="right"><strong>Scan Copy</strong></td><td align="center"><strong>:</strong></td><td align="left"><input name="membership_image[]" type="file" id="membership_image_'+row_cnt+'" />&nbsp;&nbsp;<input type="button" value="Remove Item" id="tr_row_'+row_cnt+'" name="tr_row_'+row_cnt+'" onclick="removeMultipleRows(\'row_id_membership_'+row_cnt+'\',\'hdnrow_totalRow\')" /></td></tr><tr class="row_id_membership_'+row_cnt+'"><td colspan="3" align="center">&nbsp;</td></tr>');	
				
				row_cnt = row_cnt + 1;       
				$('#hdnrow_cnt').val(row_cnt);
				var row_cnt = $('#hdnrow_cnt').val();
				row_totalRow = row_totalRow + 1;       
				$('#hdnrow_totalRow').val(row_totalRow);
							
			});
			
			$('#addMoreServiceRows').click(function() {
		
				var row_cnt2 = parseInt($('#hdnrow_cnt2').val());
				var tempcnt = row_cnt2 + 1;
				var row_totalRow2 = parseInt($('#hdnrow_totalRow2').val());
				
				$('#tblrow2 tr:#add_before_this_row2').before('<tr class="row_id_service_'+row_cnt2+'"><td height="30" align="left" valign="top">'+tempcnt+'</td><td height="30" align="left" valign="top"><input name="service_clinic_name[]" type="text" id="service_clinic_name_'+row_cnt2+'" size="25" value="" style="width:160px;" /></td><td height="30" align="left" valign="top"><input name="service_location[]" type="text" id="service_location_sl_'+row_cnt2+'" size="25" value="" style="width:160px;" readonly="readonly" onfocus="showLocationPopup(\'sl_'+row_cnt2+'\')" /><input type="hidden" name="hdncountry_id_sl[]" id="hdncountry_id_sl_'+row_cnt2+'" value="" /><input type="hidden" name="hdnstate_id_sl[]" id="hdnstate_id_sl_'+row_cnt2+'" value="" /><input type="hidden" name="hdncity_id_sl[]" id="hdncity_id_sl_'+row_cnt2+'" value="" /><input type="hidden" name="hdnplace_id_sl[]" id="hdnplace_id_sl_'+row_cnt2+'" value="" /></td><td height="30" align="left" valign="top"><input name="service_rendered[]" type="text" id="service_rendered_'+row_cnt2+'" size="25" value="" style="width:160px;" /></td><td height="30" align="left" valign="top"><input name="service_notes[]" type="text" id="service_notes_'+row_cnt2+'" size="25" value="" style="width:160px;" /></td><td height="30" align="left" valign="top"><input type="button" value="Remove" id="tr_row2_'+row_cnt2+'" name="tr_row2_'+row_cnt2+'" onclick="removeMultipleRows(\'row_id_service_'+row_cnt2+'\',\'hdnrow_totalRow2\')" /></td></tr>');	
					
				row_cnt2 = row_cnt2 + 1;       
				$('#hdnrow_cnt2').val(row_cnt2);
				var row_cnt2 = $('#hdnrow_cnt2').val();
				row_totalRow2 = row_totalRow2 + 1;       
				$('#hdnrow_totalRow2').val(row_totalRow2);
							
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add User </td>
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
							<form action="#" method="post" name="frmadd_user" id="frmadd_user" enctype="multipart/form-data" >
                            <input type="hidden" name="hdnrow_cnt" id="hdnrow_cnt" value="<?php echo $row_cnt;?>" />
                            <input type="hidden" name="hdnrow_totalRow" id="hdnrow_totalRow" value="<?php echo $row_totalRow;?>" />
                            <input type="hidden" name="hdnrow_cnt2" id="hdnrow_cnt2" value="<?php echo $row_cnt2;?>" />
                            <input type="hidden" name="hdnrow_totalRow2" id="hdnrow_totalRow2" value="<?php echo $row_totalRow2;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow">
							<tbody>
								<tr>
									<td width="20%" align="right"><strong>Email</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<input name="email" id="email" type="text" value="<?php echo $email;?>" style="width:200px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Password</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="password" id="password" type="password" value="" style="width:200px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Confirm Password</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="cpassword" id="cpassword" type="password" value="" style="width:200px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Name</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="name" id="name" type="text" value="<?php echo $name;?>" style="width:200px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>DOB</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="dob" id="dob" type="text" value="<?php echo $dob;?>" />
                                    	<script>$('#dob').datepick({ dateFormat : 'dd-mm-yy'}); </script>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Sex</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input type="radio" name="sex" id="sex" value="Male" <?php if($sex == "Male") { ?> checked="checked" <?php } ?> />
										Male 
										<input type="radio" name="sex" id="sex" value="Female" <?php if($sex == "Female") { ?> checked="checked" <?php } ?> />
										Female
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Mobile</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="mobile" type="text" id="mobile" maxlength="10" value="<?php echo $mobile; ?>" />
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
                                            <?php echo $obj->getCountryOptions($country_id);?>
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
											<?php echo $obj->getStateOptions($country_id,$state_id); ?>
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
											<?php echo $obj->getCityOptions($state_id,$city_id); ?>
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
											<?php echo $obj->getPlaceOptions($state_id,$city_id,$place_id); ?>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Practitioner Registration Number</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="reg_no" type="text" id="reg_no" size="45" value="<?php echo $reg_no ?>" />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Issued by</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="issued_by" type="text" id="issued_by" size="45" value="<?php echo $issued_by; ?>" />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>
									<td align="right"><strong>Scan Copy</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="scan_image" type="file" id="scan_image" />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr> 
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr> 
                                <?php
								for($i=0;$i<$row_totalRow;$i++)
								{  ?>
									<tr class="row_id_membership_<?php echo $i; ?>">
                                    	<td align="right"><strong>Memberships</strong></td>
										<td align="center"><strong>:</strong></td>
										<td align="left">
											<input name="membership[]" type="text" id="membership_<?php echo $i; ?>" size="45" value="<?php echo $arr_membership[$i]; ?>" />
										</td>
									</tr>
                                    <tr class="row_id_membership_<?php echo $i; ?>">
	                                    <td colspan="3" align="center">&nbsp;</td>
                                    </tr>  
									<tr class="row_id_membership_<?php echo $i; ?>">
										<td align="right"><strong>Memberships No</strong></td>
                                        <td align="center"><strong>:</strong></td>
										<td align="left">
											<input name="membership_no[]" type="text" id="membership_no_<?php echo $i; ?>" size="45" value="<?php echo $arr_membership_no[$i]; ?>" />
										</td>
									</tr>
									<tr class="row_id_membership_<?php echo $i; ?>">
	                                    <td colspan="3" align="center">&nbsp;</td>
                                    </tr>  
                                    <tr class="row_id_membership_<?php echo $i; ?>">
										<td align="right"><strong>Scan Copy</strong></td>
                                        <td align="center"><strong>:</strong></td>
										<td align="left">
											<input name="membership_image[]" type="file" id="membership_image_<?php echo $i; ?>" />
											<?php
											if($i > 0)
											{ ?>
												&nbsp;&nbsp;<input type="button" value="Remove Item" id="tr_row_<?php echo $i; ?>" name="tr_row_<?php echo $i; ?>" onclick="removeMultipleRows('row_id_membership_<?php echo $i; ?>','hdnrow_totalRow')" />
											<?php } ?>
										</td>
									</tr>
									<tr class="row_id_membership_<?php echo $i; ?>">
	                                    <td colspan="3" align="center">&nbsp;</td>
                                    </tr>  
								<?php
								} ?>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr> 
                                <tr id="add_before_this_row">
                                    <td height="30" align="left" valign="top">&nbsp;</td>
                                    <td height="30" align="left" valign="top">&nbsp;</td>
                                    <td height="30" align="left" valign="top"><a href="javascript:void(0)" target="_self" class="body_link" id="addMoreMembershipRows">Add More Membership</a></td>
                                </tr> 
                                <tr>
									<td height="50" colspan="3" align="center">&nbsp;</td>
								</tr>  
                                <tr>
                                    <td height="40" colspan="3" align="left" valign="top"><strong>Currently providing Services at:</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="left" valign="top">
                                        <table border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow2">
                                            <tr>
                                                <td width="10%" height="30" align="left" valign="top"><strong>SrNo</strong></td>
                                                <td width="20%" height="30" align="left" valign="top"><strong>Name of Facility /Clinic</strong></td>
                                                <td width="20%" height="30" align="left" valign="top"><strong>Location</strong></td>
                                                <td width="20%" height="30" align="left" valign="top"><strong>Wellness Services rendered</strong></td>
                                                <td width="20%" height="30" align="left" valign="top"><strong>Notes</strong></td>
                                                <td width="10%" height="30" align="left" valign="top"><strong></strong></td>
                                            </tr>
                                        <?php
                                        for($i=0,$j=1;$i<$row_totalRow2;$i++,$j++)
                                        {  ?>
                                            <tr class="row_id_service_<?php echo $i; ?>">
                                                <td height="30" align="left" valign="top"><?php echo $j; ?></td>
                                                <td height="30" align="left" valign="top">
                                                    <input name="service_clinic_name[]" type="text" id="service_clinic_name_<?php echo $i; ?>" size="25" value="<?php echo $arr_service_clinic_name[$i]; ?>" style="width:160px;" />
                                                </td>
                                                <td height="30" align="left" valign="top">
                                                    <input name="service_location[]" type="text" id="service_location_sl_<?php echo $i; ?>" size="25" value="<?php echo $arr_service_location[$i]; ?>" style="width:160px;" readonly="readonly" onfocus="showLocationPopup('sl_<?php echo $i; ?>')" />
                                                    <input type="hidden" name="hdncountry_id_sl[]" id="hdncountry_id_sl_<?php echo $i; ?>" value="<?php echo $arr_service_location_country_id[$i]; ?>"  />
                                                    <input type="hidden" name="hdnstate_id_sl[]" id="hdnstate_id_sl_<?php echo $i; ?>" value="<?php echo $arr_service_location_state_id[$i]; ?>"  />
                                                    <input type="hidden" name="hdncity_id_sl[]" id="hdncity_id_sl_<?php echo $i; ?>" value="<?php echo $arr_service_location_city_id[$i]; ?>"  />
                                                    <input type="hidden" name="hdnplace_id_sl[]" id="hdnplace_id_sl_<?php echo $i; ?>" value="<?php echo $arr_service_location_place_id[$i]; ?>"  />
                                                </td>
                                                <td height="30" align="left" valign="top">
                                                    <input name="service_rendered[]" type="text" id="service_rendered_<?php echo $i; ?>" size="25" value="<?php echo $arr_service_rendered[$i]; ?>" style="width:160px;" />
                                                </td>
                                                <td height="30" align="left" valign="top">
                                                    <input name="service_notes[]" type="text" id="service_notes_<?php echo $i; ?>" size="25" value="<?php echo $arr_service_notes[$i]; ?>" style="width:160px;" />
                                                </td>
                                                <td height="30" align="left" valign="top">
                                                   <?php
                                                    if($i > 0)
                                                    { ?>
                                            <input type="button" value="Remove" id="tr_row2_<?php echo $i; ?>" name="tr_row2_<?php echo $i; ?>" onclick="removeMultipleRows('row_id_service_<?php echo $i; ?>','hdnrow_totalRow2')" />
                                        <?php } ?>
                                                </td>
                                            </tr>
                                        <?php
                                        } ?>    
                                            <tr id="add_before_this_row2">
                                                <td colspan="6" height="30" align="left" valign="top"><a href="javascript:void(0)" target="_self" class="body_link" id="addMoreServiceRows">Add More Service</a></td>
                                            </tr> 
                                            <tr>
                                                <td colspan="6" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>  
                                        
                                        </table>
                                    </td>
                                </tr>  
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr> 
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr> 
                                <tr>
                                    <td align="right"><strong>Referred by</strong></td>
                                    <td align="center"><strong>:</strong></td>
                                    <td align="left">
                                        <select name="referred_by" id="referred_by">
                                            <option value="user" <?php if($referred_by == 'user') {?> selected="selected" <?php } ?>>User</option>
                                            <option value="practitioner" <?php if($referred_by == 'practitioner') {?> selected="selected" <?php } ?>>Practitioner</option>
                                            <option value="others" <?php if($referred_by == 'others') {?> selected="selected" <?php } ?>>Other Medium</option>
                                        </select>
                                        
                                        &nbsp;&nbsp;&nbsp;&nbsp;<strong>Name:</strong><input type="text" id="ref_name"  name="ref_name" value="<?php echo $ref_name; ?>"/>
                                        &nbsp;&nbsp;&nbsp;&nbsp;<strong>Specify:</strong><input type="text" id="specify" name="specify" value="<?php echo $specify; ?>"/>
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