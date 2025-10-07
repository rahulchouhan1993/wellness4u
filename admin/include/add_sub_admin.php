<?php
require_once('config/class.mysql.php');
require_once('classes/class.admin.php');
$obj = new Admin();

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->isSuperAdmin())
{
	header("Location: index.php?mode=invalid");
	exit(0);
}

$error = false;
$err_msg = "";

$arr_chk_menu = array();
$arr_chk_permission = array(); 

if(isset($_POST['btnSubmit']))
{
	$email 		= strip_tags(trim($_POST['email']));
	$username 	= strip_tags(trim($_POST['username']));
	$password 	= trim($_POST['password']);
	$cpassword 	= trim($_POST['cpassword']);
	$fname	 	= trim($_POST['fname']);
	$lname	 	= trim($_POST['lname']);
	$address 	= trim($_POST['address']);
	$day 		= trim($_POST['day']);
	$month 		= trim($_POST['month']);
	$year 		= trim($_POST['year']);
	$contact_no	= trim($_POST['contact_no']);
	$country	= trim($_POST['country']);
	$state	 	= trim($_POST['state']);
	$city	 	= trim($_POST['city']);
	
	
	if($username == '')
	{
		$error = true;
		$err_msg .= 'Please enter user name';
	}
	elseif($obj->chkUserNameExists($username))
	{
		$error = true;
		$err_msg .= '<br>This user name already registered</div>';
	}
	
	if($email == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter email';
	}
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
	//elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
	{
		$error = true;
		$err_msg .= '<br>Please enter valid email';
	}
	elseif($obj->chkSubAdminEmailExists($email))
	{
		$error = true;
		$err_msg .= '<br>This email already registered';
	}
	
	if($password == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter password';
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
	
	if($fname == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter first name';
	}
	
	if($lname == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter last name';
	}
	
		
	$dob = $year.'-'.$month.'-'.$day;

	$menu  = $_POST['menu'];
	
	if(is_array($menu) && count($menu)>0)
		{
			$menu_comma_separated = implode(",", $menu);
		}
	else
		{
			$menu_comma_separated = '';
		}
	
	$permissions  = $_POST['permissions'];
	
	if(is_array($permissions) && count($permissions)>0)
		{
			$permissions_comma_separated = implode(",", $permissions);
		}
	else
		{
			$permissions_comma_separated = '';
		}
	
	if(isset($_POST['menu'])) 
	{ 
    	foreach($_POST['menu'] as $check)
	 	{
            array_push($arr_chk_menu , $check);
    	}
	}
	
	
	if(isset($_POST['permissions'])) 
	{ 
    	foreach($_POST['permissions'] as $check_per)
	 	{
            array_push($arr_chk_permission , $check_per);
    	}
	}
	
	  if(!$error)
		 {
			if($obj->signUpSubAdmin($email,$username,$password,$fname,$lname,$address,$dob,$contact_no,$country,$state,$city,$menu_comma_separated,$permissions_comma_separated))
			{
				$msg = "Record Added Successfully!";
				
			}
			else
			{
				$error = true;
				$err_msg = "Currently there is some problem.Please try again later.";
			}
		}
		
		if(!$error)
		 {
			$name = $fname.'&nbsp;'.$lname;
						
			$to_email = $email;
			$from_email = 'info@wellnessway4u.com';
			$from_name = 'info';
			$subject = 'Welcome to Wellness Way 4 U!';
			$message = '<p><strong>Hi '.$name.',</strong><p>';
			$message .= '<p>Your account has been created <a href="'.SITE_URL.'/admin/index.php">Click here to Sign In</a>';'</p>';
			$message .= '<p>Your Username = '.$username.'</p>';
			$message .= '<p>Your Password = '.$password.'</p>';
			$message .= '<p>Best Regards</p>';
			$message .= '<p>www.wellnessway4u.com</p>';
			//echo $message;
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
			header('location: index.php?mode=manage_subadmin&msg='.urlencode($msg));
		}
		
}
else
{
	$email 		= '';
	$username 	= '';
	$password 	= '';
	$cpassword 	= '';
	$fname	 	= '';
	$lname	 	= '';
	$address 	= '';
	$day 		= '';
	$month 		= '';
	$year 		= '';
	$mobile	 	= '';
	$country	= '';
	$state	 	= '';
	$city	 	= '';
	$menu_comma_separated	= '';
	$permissions_comma_separated	= '';
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Sub Admin</td>
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
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
                                 <tr>
									<td width="20%" align="right"><strong>User Name</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<input name="username" id="username" type="text" value="<?php echo $username;?>" style="width:200px;"  />&nbsp;*
									</td>
								</tr>
                            	<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Email</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<input name="email" id="email" type="text" value="<?php echo $email;?>" style="width:200px;"  />&nbsp;*
									</td>
								</tr>
                                
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Password</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="password" id="password" type="password" value="" style="width:200px;"  />&nbsp;*
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Confirm Password</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="cpassword" id="cpassword" type="password" value="" style="width:200px;"  />&nbsp;*
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>First Name</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="fname" id="fname" type="text" value="<?php echo $fname;?>" style="width:200px;"  />&nbsp;*
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Last Name</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="lname" id="lname" type="text" value="<?php echo $lname;?>" style="width:200px;"  />&nbsp;*
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                               <tr>
									<td align="right"><strong>DOB</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<select name="day" id="day">
											<option value="">DAY</option>
										<?php
										for($i=1;$i<=31;$i++)
										{ ?>
											<option value="<?php echo $i;?>" <?php if($day == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
										<?php
										} ?>	
										</select>
										&nbsp;
										<select name="month" id="month">
											<option value="">MONTH</option>
											<?php echo $obj->getMonthOptions($month); ?>
										</select>
										&nbsp;
										<select name="year" id="year">
											<option value="">YEAR</option>
										<?php
										for($i=1970;$i<=2010;$i++)
										{ ?>
											<option value="<?php echo $i;?>" <?php if($year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
										<?php
										} ?>	
										</select>
										&nbsp;
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Address</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="address" id="address" type="text" value="<?php echo $address;?>" style="width:200px;"  />
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Mobile</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="contact_no" type="text" id="contact_no" maxlength="10" value="<?php echo $contact_no; ?>" />
									</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Country</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="country" id="country" type="text" value="<?php echo $address;?>" style="width:200px;"  />
									</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>State</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="state" id="state" type="text" value="<?php echo $state;?>" style="width:200px;"  />
									</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>City</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="city" id="city" type="text" value="<?php echo $city;?>" style="width:200px;"  />
									</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                
                                
                                <tr>
                                 <td align="right"><strong>Assign Permissions</strong></td>
								<td align="center"><strong>:</strong></td>
                                <td align="center">&nbsp;</td>
                                </tr>
                                  <?php 
								  		list($arr_admin_menu_id,$arr_menu_name,$arr_menu_href) = $obj->getMenu();
									  	$count1 = count($arr_admin_menu_id);
									    for($i1=0;$i1<$count1;$i1++)
										{  
								   ?>
                               <tr>
                               <td align="right">&nbsp;</td>
                               <td align="center">&nbsp;</td>
                                <td align="left"><input type="checkbox" name="menu[]" id="menu_<?php echo $arr_admin_menu_id[$i1]; ?>" value="<?php echo $arr_admin_menu_id[$i1]; ?>" onClick="ShowOrHideCheckBox('<?php echo $arr_admin_menu_id[$i1]; ?>');" <?php if (in_array($arr_admin_menu_id[$i1] , $arr_chk_menu)) { ?> checked="checked" <?php } ?> />&nbsp;<strong><?php echo $arr_menu_name[$i1]; ?></strong></td>
                                </tr>
                                 <?php
								  
								  list($arr_admin_action_id,$arr_action_name) = $obj->getActions($arr_admin_menu_id[$i1]);
										$count = count($arr_admin_action_id);
										for($i=0;$i<$count;$i++)
										{   
                                   ?>
                                   <tr>
									<td align="right">&nbsp;</td>
									<td align="center">&nbsp;</td>
									<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<?php 
													if (in_array($arr_admin_menu_id[$i1] , $arr_chk_menu)) 
													{	 
														$disable = '';
													}	
													else
													{ 
													 $disable = ' disabled="disabled" ';
													} 
												?>
                                                <input type="checkbox" class="group_<?php echo $arr_admin_menu_id[$i1]; ?>" onclick="HideCheckBox('<?php echo $arr_admin_menu_id[$i1]; ?>')" <?php echo $disable ?>  name="permissions[]" id="permissions_<?php echo $arr_admin_menu_id[$i1]; ?>_<?php echo $arr_admin_action_id[$i]; ?>" value="<?php echo $arr_admin_action_id[$i];?>" <?php if (in_array($arr_admin_action_id[$i] , $arr_chk_permission)) { ?> checked="checked" <?php } ?> />&nbsp;<?php echo $arr_action_name[$i]; ?>
									</td>
								
                                </tr>
                                 <?php  } ?>
                                 <?php  } ?>    
                               	<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
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
