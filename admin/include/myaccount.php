<?php
require_once('config/class.mysql.php');
require_once('classes/class.admin.php');
$users = new Admin();
$error = false;
$err_msg = "";
if(isset($_POST['btnSubmit']))
{
	$admin_id = $_POST['hdnadmin_id'];
	$username = strip_tags(trim($_POST['username']));
	$email = trim($_POST['email']);
	$fname = strip_tags(trim($_POST['fname']));
	$lname = strip_tags(trim($_POST['lname']));
	$bday = trim($_POST['bday']);
	$bmonth = trim($_POST['bmonth']);
	$byear = trim($_POST['byear']);
	$address = trim($_POST['address']);
	$city = strip_tags(trim($_POST['city']));
	$state = strip_tags(trim($_POST['state']));
	$country = strip_tags(trim($_POST['country']));
	$contact_no = trim($_POST['contact_no']);
	
	if($username == '')
	{
		$error = true;
		$err_msg = 'Please Enter Username';
	}
	elseif(!preg_match("/^[a-zA-Z0-9\.\_]+$/",$username)  )
	{
		$error = true;
		$err_msg = 'Please Enter Valid Username[a-z,0-9,.,_]';
	}
	elseif($users->chkUsernameExists_edit($username,$admin_id))
	{
		$error = true;
		$err_msg = 'This Username Already Exists';
	}
	
	if($email == '')
	{
		$error = true;
		$err_msg .= '<br>Please Enter Email';
	}
	elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
	{
		$error = true;
		$err_msg .= '<br>Please Enter Valid Email';
	}
	elseif($users->chkEmailExists_edit($email,$admin_id))
	{
		$error = true;
		$err_msg .= '<br>This Email Already Exists</div>';
	}
	
	if($fname == '')
	{
		$error = true;
		$err_msg .= '<br>Please Enter First Name';
	}
	elseif(!preg_match("/^[a-zA-Z\'\ ]+$/",$fname)  )
	{
		$error = true;
		$err_msg .= '<br>Please Enter Valid First Name';
	}
	
	if($lname == '')
	{
		$error = true;
		$err_msg .= '<br>Please Enter Last Name';
	}
	elseif(!preg_match("/^[a-zA-Z\'\ ]+$/",$lname)  )
	{
		$error = true;
		$err_msg .= '<br>Please Enter Valid Last Name';
	}
	
	if($bmonth == '' || $bday == '' || $byear == '') 
	{
		$error = true;
		$err_msg .= '<br>Please Select Valid date</div>';
	}
	elseif(!checkdate($bmonth,$bday,$byear) )
	{
		$error = true;
		$err_msg .= '<br>Please Select Valid date</div>';
	}
	else
	{
		$dob = $byear.'-'.$bmonth.'-'.$bday;
	}
	
	if($country == '')
	{
		$error = true;
		$err_msg .= '<br>Please Enter Country';
	}
	
	if($state == '')
	{
		$error = true;
		$err_msg .= '<br>Please Enter State';
	}
	
	if($city == '')
	{
		$error = true;
		$err_msg .= '<br>Please Enter City';
	}
	
	if($contact_no != '')
	{
		if( ( !is_numeric($contact_no) ) || ( strlen($contact_no) != 10 ) )
		{
			$error = true;
			$err_msg .= '<br>Please Enter Valid 10 digits numbers only';
		}
		elseif(!preg_match("/^[0-9]+$/",$contact_no)  )
		{
			$error = true;
			$err_msg .= '<br>Please Enter Valid 10 digits numbers only';
		}
	}	
	
	if($address == '')
	{
		$error = true;
		$err_msg .= '<br>Please Enter Address</div>';
	}
	
	if(!$error)
	{
		
		if($users->updateUser($admin_id,$username,$email,$fname,$lname,$dob,$address,$city,$state,$country,$contact_no))
		{
			$msg = "Member Updated Successfully!";
			header('location: index.php?mode=home');
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
	$admin_id = $_SESSION['admin_id'];
	list($username,$email,$fname,$lname,$dob,$country,$state,$city,$contact_no,$address,$status) = $users->getUserDetails($admin_id);
	if($dob != '')
	{
		$temp = explode("-",$dob);
		$bday = $temp[2];
		$bmonth = $temp[1];
		$byear = $temp[0];
	}
	
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Myaccount </td>
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
							<form action="#" method="post" name="frmeditsalesuser" id="frmeditsalesuser" enctype="multipart/form-data" >
							<input type="hidden" name="hdnadmin_id" id="hdnadmin_id" value="<?php echo $admin_id;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="20%" align="right"><strong>Usermame</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input name="username" type="text" id="username" value="<?php echo $username; ?>" style="width:200px;" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
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
									<td width="20%" align="right"><strong>First Name</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<input name="fname" id="fname" type="text" value="<?php echo $fname;?>" style="width:200px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Last Name</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<input name="lname" id="lname" type="text" value="<?php echo $lname;?>" style="width:200px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right" valign="top"><strong>DOB</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left">
										<select name="bday" id="bday">
											<option value="">Day</option>
										<?php
										for($i=1;$i<=31;$i++)
										{ ?>
											<option value="<?php echo $i;?>" <?php if($i == $bday) {?> selected="selected" <?php } ?>><?php echo $i;?></option>	
										<?php
										} ?>	
										</select>
										<select name="bmonth" id="bmonth">
											<option value="">Month</option>
											<?php echo $users->getMonthOptions($bmonth); ?>
										</select>
										<select name="byear" id="byear">
											<option value="">Year</option>
										<?php
										for($i=2000;$i>=1950;$i--)
										{ ?>
											<option value="<?php echo $i;?>" <?php if($i == $byear) {?> selected="selected" <?php } ?>><?php echo $i;?></option>	
										<?php
										} ?>	
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Country</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<input name="country" id="country" type="text" value="<?php echo $country;?>" style="width:200px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>State</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<input name="state" id="state" type="text" value="<?php echo $state;?>" style="width:200px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>City</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<input name="city" id="city" type="text" value="<?php echo $city;?>" style="width:200px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Contact No</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<input name="contact_no" id="contact_no" type="text" value="<?php echo $contact_no;?>" style="width:200px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Address</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<textarea name="address" id="address" style="width:200px;" ><?php echo $address;?></textarea>
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