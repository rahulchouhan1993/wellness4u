<?php
require_once('config/class.mysql.php');
require_once('classes/class.dailymeals.php');
$obj = new Daily_Meals();

$edit_action_id = '21';

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
if(isset($_POST['btnSubmit']))
{
	$nar_id = $_POST['hdnnar_id'];
	$page = $_POST['hdnpage'];
	$nid = strip_tags(trim($_POST['hdnnid']));
	$units = strip_tags(trim($_POST['units']));
	$symbols = strip_tags(trim($_POST['symbols']));
	$reference = strip_tags(trim($_POST['reference']));
	$adults_general = strip_tags(trim($_POST['adults_general']));
	$childern_general = strip_tags(trim($_POST['childern_general']));
	$infants_0_6_months = strip_tags(trim($_POST['infants_0_6_months']));
	$infants_6_12_months = strip_tags(trim($_POST['infants_6_12_months']));
	$childern_1_3_years = strip_tags(trim($_POST['childern_1_3_years']));
	$childern_4_8_years = strip_tags(trim($_POST['childern_4_8_years']));
	$males_9_13_years = strip_tags(trim($_POST['males_9_13_years']));
	$males_14_18_years = strip_tags(trim($_POST['males_14_18_years']));
	$males_19_30_years = strip_tags(trim($_POST['males_19_30_years']));
	$males_31_50_years = strip_tags(trim($_POST['males_31_50_years']));
	$males_51_70_years = strip_tags(trim($_POST['males_51_70_years']));
	$males_71_100_years = strip_tags(trim($_POST['males_71_100_years']));
	$female_9_13_years = strip_tags(trim($_POST['female_9_13_years']));
	$female_14_18_years = strip_tags(trim($_POST['female_14_18_years']));
	$female_19_30_years = strip_tags(trim($_POST['female_19_30_years']));
	$female_31_50_years = strip_tags(trim($_POST['female_31_50_years']));
	$female_51_70_years = strip_tags(trim($_POST['female_51_70_years']));
	$female_71_100_years = strip_tags(trim($_POST['female_71_100_years']));
	$pregnant_women_14_18_years = strip_tags(trim($_POST['pregnant_women_14_18_years']));
	$pregnant_women_19_30_years = strip_tags(trim($_POST['pregnant_women_19_30_years']));
	$pregnant_women_31_50_years = strip_tags(trim($_POST['pregnant_women_31_50_years']));
	$women_lactation_stage_14_18_years = strip_tags(trim($_POST['women_lactation_stage_14_18_years']));
	$women_lactation_stage_19_30_years = strip_tags(trim($_POST['women_lactation_stage_19_30_years']));
	$women_lactation_stage_31_50_years = strip_tags(trim($_POST['women_lactation_stage_31_50_years']));
	
	if(!$error)
	{
		if($obj->updateNAR($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years,$nar_id))
		{
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=nutrientavgreq&page='.$page.'&msg='.urlencode($msg));
		}
		else
		{
			$error = true;
			$err_msg = "Currently there is some problem.Please try again later.";
		}
	}
}
elseif(isset($_GET['id']))
{
	$nar_id = $_GET['id'];
	$page = $_GET['page'];
	list($nid,$units,$symbols,$reference,$adults_general,$childern_general,$infants_0_6_months,$infants_6_12_months,$childern_1_3_years,$childern_4_8_years,$males_9_13_years,$males_14_18_years,$males_19_30_years,$males_31_50_years,$males_51_70_years,$males_71_100_years,$female_9_13_years,$female_14_18_years,$female_19_30_years,$female_31_50_years,$female_51_70_years,$female_71_100_years,$pregnant_women_14_18_years,$pregnant_women_19_30_years,$pregnant_women_31_50_years,$women_lactation_stage_14_18_years,$women_lactation_stage_19_30_years,$women_lactation_stage_31_50_years) = $obj->getNARDetails($nar_id);
	if( ($nid == '') || ($nid == '0') )
	{
		header('location: index.php?mode=nutrientavgreq');	
	}	
}	
else
{
	header('location: index.php?mode=nutrientavgreq');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Nutrient Average Requirement</td>
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
							<form action="#" method="post" name="frmedit_daily_meal" id="frmedit_daily_meal" enctype="multipart/form-data" >
							<input type="hidden" name="hdnnar_id" id="hdnnar_id" value="<?php echo $nar_id;?>" />
							<input type="hidden" name="hdnnid" id="hdnnid" value="<?php echo $nid;?>" />
							<input type="hidden" name="hdnpage" id="hdnpage" value="<?php echo $page;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="30%" align="right"><strong>Food Constituent</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="65%" align="left"><?php echo $obj->getFoodConstituent($nid); ?></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Unit</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="units" type="text" id="units" value="<?php echo $units; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Symbols</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="symbols" type="text" id="symbols" value="<?php echo $symbols; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Reference</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="reference" type="text" id="reference" value="<?php echo $reference; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Adults General</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="adults_general" type="text" id="adults_general" value="<?php echo $adults_general; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Childern General</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="childern_general" type="text" id="childern_general" value="<?php echo $childern_general; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Infants(0-6 Months)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="infants_0_6_months" type="text" id="infants_0_6_months" value="<?php echo $infants_0_6_months; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Infants(6-12 Months)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="infants_6_12_months" type="text" id="infants_6_12_months" value="<?php echo $infants_6_12_months; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Childern(1-3 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="childern_1_3_years" type="text" id="childern_1_3_years" value="<?php echo $childern_1_3_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Childern(4-8 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="childern_4_8_years" type="text" id="childern_4_8_years" value="<?php echo $childern_4_8_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Males(9-13 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="males_9_13_years" type="text" id="males_9_13_years" value="<?php echo $males_9_13_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Males(14-18 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="males_14_18_years" type="text" id="males_14_18_years" value="<?php echo $males_14_18_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Males(19-30 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="males_19_30_years" type="text" id="males_19_30_years" value="<?php echo $males_19_30_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Males(31-50 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="males_31_50_years" type="text" id="males_31_50_years" value="<?php echo $males_31_50_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Males(51-70 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="males_51_70_years" type="text" id="males_51_70_years" value="<?php echo $males_51_70_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Males(71-100 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="males_71_100_years" type="text" id="males_71_100_years" value="<?php echo $males_71_100_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Female(9-13 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="female_9_13_years" type="text" id="female_9_13_years" value="<?php echo $female_9_13_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Female(14-18 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="female_14_18_years" type="text" id="female_14_18_years" value="<?php echo $female_14_18_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Female(19-30 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="female_19_30_years" type="text" id="female_19_30_years" value="<?php echo $female_19_30_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Female(31-50 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="female_31_50_years" type="text" id="female_31_50_years" value="<?php echo $female_31_50_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Female(51-70 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="female_51_70_years" type="text" id="female_51_70_years" value="<?php echo $female_51_70_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Female(71-100 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="female_71_100_years" type="text" id="female_71_100_years" value="<?php echo $female_71_100_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Pregnant Women(14-18 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="pregnant_women_14_18_years" type="text" id="pregnant_women_14_18_years" value="<?php echo $pregnant_women_14_18_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Pregnant Women(19-30 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="pregnant_women_19_30_years" type="text" id="pregnant_women_19_30_years" value="<?php echo $pregnant_women_19_30_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Pregnant Women(31-50 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="pregnant_women_31_50_years" type="text" id="pregnant_women_31_50_years" value="<?php echo $pregnant_women_31_50_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Women Lactation Stage(14-18 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="women_lactation_stage_14_18_years" type="text" id="women_lactation_stage_14_18_years" value="<?php echo $women_lactation_stage_14_18_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Women Lactation Stage(19-30 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="women_lactation_stage_19_30_years" type="text" id="women_lactation_stage_19_30_years" value="<?php echo $women_lactation_stage_19_30_years; ?>" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Women Lactation Stage(31-50 Years)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="women_lactation_stage_31_50_years" type="text" id="women_lactation_stage_31_50_years" value="<?php echo $women_lactation_stage_31_50_years; ?>" ></td>
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