<?php
require_once('config/class.mysql.php');
require_once('classes/class.dailymeals.php');
$obj = new Daily_Meals();

$import_action_id = '23';

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
						if($row <= 3  && !empty($data)) 
						{
							$fields = implode(",",$data);
							//continue;
						} 
						else 
						{
							if(!empty($data) ) 
							{
								//echo "<pre>";
								//print_r($data);
								//echo "</pre>";
								if($data[0] != '')
								{
									$food_constituent = trim($data[0]);
									$units = trim($data[1]);
									$symbols = trim($data[2]);
									$reference = trim($data[3]);
									$adults_general = trim($data[4]);
									$childern_general = trim($data[5]);
									$infants_0_6_months = trim($data[6]);
									$infants_6_12_months = trim($data[7]);
									$childern_1_3_years = trim($data[8]);
									$childern_4_8_years = trim($data[9]);
									$males_9_13_years = trim($data[10]);
									$males_14_18_years = trim($data[11]);
									$males_19_30_years = trim($data[12]);
									$males_31_50_years = trim($data[13]);
									$males_51_70_years = trim($data[14]);
									$males_71_100_years = trim($data[15]);
									$female_9_13_years = trim($data[16]);
									$female_14_18_years = trim($data[17]);
									$female_19_30_years = trim($data[18]);
									$female_31_50_years = trim($data[19]);
									$female_51_70_years = trim($data[20]);
									$female_71_100_years = trim($data[21]);
									$pregnant_women_14_18_years = trim($data[22]);
									$pregnant_women_19_30_years = trim($data[23]);
									$pregnant_women_31_50_years = trim($data[24]);
									$women_lactation_stage_14_18_years = trim($data[25]);
									$women_lactation_stage_19_30_years = trim($data[26]);
									$women_lactation_stage_31_50_years = trim($data[27]);
									
									if($obj->chkFoodConstituentExists($food_constituent))
									{
										$nid = $obj->getNId($food_constituent);
										if($nid > 0)
										{
											if($obj->chkNARFoodConstituentExists($nid))
											{
												$nar_id = $obj->getNARId($nid);
												if($nar_id > 0)
												{
													if($obj->updateNAR($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years,$nar_id))
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
											else
											{
												if($obj->addNAR($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years))
												{
													$succ_cnt++;
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Import Nutrient Average Requirement </td>
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
							<form action="#" method="post" name="frmimport_places" id="frmimport_places" enctype="multipart/form-data" >
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