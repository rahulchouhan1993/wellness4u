<?php
require_once('config/class.mysql.php');
require_once('classes/class.users.php');
$obj = new Users();

$edit_action_id = '2';

if(!$obj->isAdminLoggedIn())
{
	
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$edit_action_id))
	{	
	  	header("Location: index.php?mode=invalid");
		exit(0);
	}

$error = false;
$err_msg = "";

$tr_beef_pork = 'none';

if(isset($_POST['add_sponsor']))
{
	$get_usr_id=$_GET['uid'];
	$sponsor_value=$_POST['sponsor_value'];

	if($obj->addsponser($sponsor_value,$get_usr_id))
	{
      $msg = "User Sponsor Updated Successfully!";
      header('location: index.php?mode=users&msg='.urlencode($msg));
	}
	else
	{
		$error = true;
		$err_msg = "Currently there is some problem.Please try again later.";
	}
	 // echo "<pre>";print_r($sponsor_value);echo "</pre>";
}






if(isset($_POST['btnSubmit']))
{
	$user_id = $_POST['hdnuser_id'];
	$status = $_POST['status'];
	$email = strip_tags(trim($_POST['email']));
	$name = strip_tags(trim($_POST['name']));
        $middle_name = strip_tags(trim($_POST['middle_name']));
        $last_name = strip_tags(trim($_POST['last_name']));
	$day = trim($_POST['day']);
	$month = trim($_POST['month']);
	$year = trim($_POST['year']);
	$height = strip_tags(trim($_POST['height']));
	$weight = strip_tags(trim($_POST['weight']));
	$sex = strip_tags(trim($_POST['sex']));
	$mobile = strip_tags(trim($_POST['mobile']));
	$state_id = strip_tags(trim($_POST['state_id']));
	$city_id = strip_tags(trim($_POST['city_id']));
	$place_id = strip_tags(trim($_POST['place_id']));
	$food_veg_nonveg = strip_tags(trim($_POST['food_veg_nonveg']));
	$beef = strip_tags(trim($_POST['beef']));
	$pork = strip_tags(trim($_POST['pork']));
	
	if($email == '')
	{
		$error = true;
		$err_msg .= 'Please enter email';
	}
	elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
	{
		$error = true;
		$err_msg .= 'Please enter valid email';
	}
	elseif($obj->chkEmailExists_edit($email,$user_id))
	{
		$error = true;
		$err_msg .= 'This email already registered</div>';
	}
	
	if($name == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter name';
	}
	if($middle_name == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter middle name';
	}
        if($last_name == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter last name';
	}
        
	$dob = $year.'-'.$month.'-'.$day;
	
	if($food_veg_nonveg == 'NV')
	{
		$tr_beef_pork = '';
	}
	else
	{
		$beef = '0';
		$pork = '0';
		$tr_beef_pork = 'none';
	}
		
	
	if(!$error)
	{
		if($obj->updateUserVivek($email,$name,$middle_name,$last_name,$dob,$height,$weight,$sex,$mobile,$status,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$user_id))
		{
			$msg = "User Updated Successfully!";
			header('location: index.php?mode=users&msg='.urlencode($msg));
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}
}
elseif(isset($_GET['uid']))
{
	$user_id = $_GET['uid'];
	list($return,$name,$middle_name,$last_name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$status,$participant_profile) = $obj->getUserDetailsVivek($user_id);
	if(!$return)
	{
		header('location: index.php?mode=users');	
	}	
	else
	{
		$temp = explode("-",$dob);
		$year = $temp[0];
		$month = $temp[1];
		$day = $temp[2];
		
		if($food_veg_nonveg == 'NV')
		{
			$tr_beef_pork = '';
		}
		else
		{
			$tr_beef_pork = 'none';
		}
	}
}	
else
{
	header('location: index.php?mode=users');
}
?>

<script src="js/AC_ActiveX.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jscolor.js"></script>
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit User </td>
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
							<form action="#" method="post" name="frmedit_user" id="frmedit_user" enctype="multipart/form-data" >
							<input type="hidden" name="hdnuser_id" id="hdnuser_id" value="<?php echo $user_id;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
                                                             <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Email</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input name="email" type="text" id="email" value="<?php echo $email; ?>" style="width:200px;" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Status</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<select id="status" name="status" style="width:200px;">
											<option value="0" <?php if($status == 0) { ?> selected="selected" <?php } ?>>Inactive</option>
											<option value="1" <?php if($status == 1) { ?> selected="selected" <?php } ?>>Active</option>
										</select>
                                    &nbsp;&nbsp;&nbsp;
                                    <?php if($status == 1) { ?>
                                    <input type="button" name="deactivate" id="deactivate" value="Deactivate" onclick="Deactivate('<?php echo $user_id;?>')">
                                    <?php } ?>
                                    <?php if($status == 0) { ?>
                                    <input type="button" name="activate" id="activate" value="Activate" onclick="Activate('<?php echo $user_id;?>')">
                                    <?php } ?>
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
									<td align="right"><strong>Middle Name</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="middle_name" id="middle_name" type="text" value="<?php echo $middle_name;?>" style="width:200px;"  />
									</td>
								</tr>
                                 <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Last Name</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input name="last_name" id="last_name" type="text" value="<?php echo $last_name;?>" style="width:200px;"  />
									</td>
								</tr>

								 <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>

                                 <td align="right" valign="top"><strong>Participant Profile</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getusersponsor('69','0','300','150',$participant_profile);?>
                                           
                                        </td>


                                </tr>
                                <tr>
                                <td align="right" valign="top"></td>
                                   <td align="center" valign="top"></td>
                                   <td> <input type="Submit" name="add_sponsor" value="Add"></td>
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
										for($i=1940;$i<=2008;$i++)
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
									<td align="right"><strong>Height</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<select name="height" id="height">
											<option value="">Select Height</option>
											<?php echo $obj->getHeightOptions($height); ?>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Weight</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<select name="weight" id="weight">
											<option value="">Select Weight</option>
										<?php
										for($i=45;$i<=200;$i++)
										{ ?>
											<option value="<?php echo $i;?>" <?php if($weight == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?> Kgs</option>
										<?php
										} ?>	
										</select>
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
									<td align="right"><strong>State</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<select name="state_id" id="state_id" onchange="getCityOptionsUser('<?php echo $city_id;?>');">
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
										<select name="city_id" id="city_id" onchange="getPlaceOptions('<?php echo $place_id;?>');">
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
										<select name="place_id" id="place_id">
											<option value="">Select Place</option>
											<?php echo $obj->getPlaceOptions($state_id,$city_id,$place_id); ?>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Food Option</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<input type="radio" name="food_veg_nonveg" id="food_veg_nonveg[]" value="V" <?php if($food_veg_nonveg == "V") { ?> checked="checked" <?php } ?> onclick="toggleBeefAndPorkOption();" />Veg &nbsp;
										<input type="radio" name="food_veg_nonveg" id="food_veg_nonveg[]" value="VE" <?php if($food_veg_nonveg == "VE") { ?> checked="checked" <?php } ?> onclick="toggleBeefAndPorkOption();" />Veg + Egg&nbsp;
										<input type="radio" name="food_veg_nonveg" id="food_veg_nonveg[]" value="NV" <?php if($food_veg_nonveg == "NV") { ?> checked="checked" <?php } ?> onclick="toggleBeefAndPorkOption();" />All(Veg + Non Veg)&nbsp;
									</td>
								</tr>
								<tr id="tr_beef_pork" style="display:<?php echo $tr_beef_pork;?>;">
									<td align="right"><strong>&nbsp;</strong></td>
									<td align="center"><strong>&nbsp;</strong></td>
									<td align="left">
										<input type="checkbox" name="beef" id="beef" value="1" <?php if($beef == "1") { ?> checked="checked" <?php } ?> />Beef &nbsp;
										<input type="checkbox" name="pork" id="pork" value="1" <?php if($pork == "1") { ?> checked="checked" <?php } ?> />Pork &nbsp;
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<!--<td align="left"><input type="Submit" name="btnSubmit" value="Submit" /></td>-->
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
    
    function Deactivate(idval)
    {
       // alert('hi');
	var dataString = 'action=deactivateuser&user_id='+idval;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			location.reload();
		}
	});
    }
    
    function Activate(idval)
    {
       
	var dataString = 'action=activateuser&user_id='+idval;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			location.reload();
		}
	});
    }
    
</script>