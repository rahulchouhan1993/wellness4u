<?php
require_once('config/class.mysql.php');
require_once('classes/class.dailyactivity.php');
$obj = new Daily_Activity();

$import_action_id = '104';

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$import_action_id))
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}

$field_separate_char = ",";
$field_enclose_char = "\"";
//$field_escape_char = "\\";
$error = false;
$err_msg = '';

$fail_cnt = 0;
$succ_cnt = 0;
$tot_cnt = 0;
    
if(isset($_POST['btnSubmit']))
{
	if(!empty($_FILES['csv']['tmp_name'])) 
	{
		if (is_uploaded_file($_FILES['csv']['tmp_name'])) 
		{
			$ext = substr(strrchr($_FILES['csv']['name'],'.'),1);
			if(($ext != 'csv')) 
			{
				$error = true;
				$err_msg .= 'Please Upload Only csv files.';
			} 
			else 
			{
				$row = 1;
				if (($handle = fopen($_FILES['csv']['tmp_name'], "r")) !== FALSE) 
				{
					while (($data = fgetcsv($handle, 0, $field_separate_char,$field_enclose_char)) !== FALSE) 
					{
						
						if($row > 2 && !empty($data))  
						{
							if(!empty($data) ) 
							{
								//echo "<br><pre>";
								//print_r($data);
								//echo "<br></pre>";
								if($data[0] != '')
								{
									$activity = $data[1];
									$activity_cal_kg_min = $data[2];
									$activity_cal_kg_hr = $data[3];
									$activity_cal_59_kg = $data[4];
									$activity_level_code = $data[5];
									$activity_category = $data[6];
									if(!$obj->chkActivityExists($activity))
									{
										$recommendations = '';
										$guidelines = '';
										$precautions = '';
										$benefits = '';
										$addDailyActivity = $obj->addDailyActivity($activity,$activity_cal_kg_min,$activity_cal_kg_hr,$activity_cal_59_kg,$activity_level_code,$activity_category,$recommendations,$guidelines,$precautions,$benefits);
										if($addDailyActivity)
										{
											$succ_cnt++;	
										}
										else
										{
											$fail_cnt++;
										}
										
									}
									else
									{
										$activity_id = $obj->getActivityId($activity);
										if($activity_id != 0)
										{
											if($obj->updateDailyActivity($activity,$activity_cal_kg_min,$activity_cal_kg_hr,$activity_cal_59_kg,$activity_level_code,$activity_category,$activity_id))
											{
												$succ_cnt++;	
											}
											else
											{
												$fail_cnt++;
											}
										}	
										else
										{
											$fail_cnt++;
										}
									} 
								}
								else
								{
									$fail_cnt++;
								}
							}
							else
							{
								$fail_cnt++;
							}
							$tot_cnt++;
						}
						$row++;
					}
					fclose($handle);
				}
				if(!$error) 
				{
				   $msg = "Total Records = ".$tot_cnt;
				   $msg .= "<br>Successful Uploaded Records = ".$succ_cnt;
				   $msg .= "<br>Faild to Upload Records = ".$fail_cnt."<br><br>";
				}
			}
		}
	}
	else 
	{
		$error = true;
		$err_msg .= 'Please Upload csv file.';
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Import Daily Activities </td>
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
							<form action="#" method="post" name="frmimport_daily_activity" id="frmimport_daily_activity" enctype="multipart/form-data" >
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td colspan="2" height="30" align="left" valign="top" ><?php echo $msg;?></td>
									</tr>
									<tr>
										<td height="30" align="left" valign="top"><strong>Upload CSV:</strong></td>
										<td height="30" align="left" valign="top">
											<input name="csv" id="csv" type="file" />
										</td>
									</tr>
									<tr>
										<td height="40" align="left" valign="top">&nbsp;</td>
										<td height="40" align="left" valign="top">
											<input name="btnSubmit" type="submit" id="btnSubmit" value="Submit" />
										</td>
									</tr>
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