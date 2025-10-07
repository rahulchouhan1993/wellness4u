<?php
require_once('config/class.mysql.php');
require_once('classes/class.dailymeals.php');
$obj = new Daily_Meals();

$import_action_id = '105';

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
						if($row == 1 && !empty($data)) 
						{
							$fields = implode(",",$data);
							//continue;
						} 
						else 
						{
							if(!empty($data) ) 
							{
								//echo "<br><pre>";
								//print_r($data);
								//echo "<br></pre>";
								if($data[1] != '')
								{
									$meal_item = $data[1];
									if(!$obj->chkMealItemAlreadyExists($meal_item))
									{
										$meal_measure = $data[2];
										$meal_ml = $data[3];
										$weight = $data[4];
										$food_type = $data[5];
										$food_veg_nonveg = $data[6];
										$water = $data[7];
										$calories = $data[8];
										$total_fat = $data[9];
										$saturated = $data[10];
										$monounsaturated = $data[11];
										$total_polyunsaturated = $data[12];
										$polyunsaturated_linoleic = $data[13];
										$polyunsaturated_alphalinoleic = $data[14];
										$cholesterol = $data[15];
										$total_dietary_fiber = $data[16];
										$total_carbohydrate = $data[17];
										$total_monosaccharide = $data[18];
										$glucose = $data[19];
										$fructose = $data[20];
										$galactose = $data[21];
										$total_disaccharide = $data[22];
										$maltose = $data[23];
										$lactose = $data[24];
										$sucrose = $data[25];
										$total_polysaccharide = $data[26];
										$starch = $data[27];
										$cellulose = $data[28];
										$glycogen = $data[29];
										$dextrins = $data[30];
										$sugar = $data[31];
										$total_vitamin = $data[32];
										$vitamin_a = $data[33];
										$re = $data[34];
										$vitamin_b_complex = $data[35];
										$thiamin = $data[36];
										$riboflavin = $data[37];
										$niacin = $data[38];
										$pantothenic_acid = $data[39];
										$pyridoxine_hcl = $data[40];
										$cyanocobalamin = $data[41];
										$folic_acid = $data[42];
										$biotin = $data[43];
										$ascorbic_acid = $data[44];
										$calciferol = $data[45];
										$tocopherol = $data[46];
										$phylloquinone = $data[47];
										$protein = $data[48];
										$alanine = $data[49];
										$arginine = $data[50];
										$aspartic_acid = $data[51];
										$cystine = $data[52];
										$giutamic_acid = $data[53];
										$glycine = $data[54];
										$histidine = $data[55];
										$hydroxy_glutamic_acid = $data[56];
										$hydroxy_proline = $data[57];
										$iodogorgoic_acid = $data[58];
										$isoleucine = $data[59];
										$leucine = $data[60];
										$lysine = $data[61];
										$methionine = $data[62];
										$norleucine = $data[63];
										$phenylalanine = $data[64];
										$proline = $data[65];
										$serine = $data[66];
										$threonine = $data[67];
										$thyroxine = $data[68];
										$tryptophane = $data[69];
										$tyrosine = $data[70];
										$valine = $data[71];
										$total_minerals = $data[72];
										$calcium = $data[73];
										$iron = $data[74];
										$potassium = $data[75];
										$sodium = $data[76];
										$phosphorus = $data[77];
										$sulphur = $data[78];
										$chlorine = $data[79];
										$iodine = $data[80];
										$magnesium = $data[81];
										$zinc = $data[82];
										$copper = $data[83];
										$chromium = $data[84];
										$manganese = $data[85];
										$selenium = $data[86];
										$boron = $data[87];
										$molybdenum = $data[88];
										
										$addDailyMeal = $obj->addDailyMeal($meal_item,$meal_measure,$meal_ml,$weight,$food_type,$food_veg_nonveg,$water,$calories,$total_fat,$saturated,$monounsaturated,$total_polyunsaturated,$polyunsaturated_linoleic,$polyunsaturated_alphalinoleic,$cholesterol,$total_dietary_fiber,$total_carbohydrate,$total_monosaccharide,$glucose,$fructose,$galactose,$total_disaccharide,$maltose,$lactose,$sucrose,$total_polysaccharide,$starch,$cellulose,$glycogen,$dextrins,$sugar,$total_vitamin,$vitamin_a,$re,$vitamin_b_complex,$thiamin,$riboflavin,$niacin,$pantothenic_acid,$pyridoxine_hcl,$cyanocobalamin,$folic_acid,$biotin,$ascorbic_acid,$calciferol,$tocopherol,$phylloquinone,$protein,$alanine,$arginine,$aspartic_acid,$cystine,$giutamic_acid,$glycine,$histidine,$hydroxy_glutamic_acid,$hydroxy_proline,$iodogorgoic_acid,$isoleucine,$leucine,$lysine,$methionine,$norleucine,$phenylalanine,$proline,$serine,$threonine,$thyroxine,$tryptophane,$tyrosine,$valine,$total_minerals,$calcium,$iron,$potassium,$sodium,$phosphorus,$sulphur,$chlorine,$iodine,$magnesium,$zinc,$copper,$chromium,$manganese,$selenium,$boron,$molybdenum);
										if($addDailyMeal)
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Import Daily Meals </td>
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
							<form action="#" method="post" name="frmimport_daily_meals" id="frmimport_daily_meals" enctype="multipart/form-data" >
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