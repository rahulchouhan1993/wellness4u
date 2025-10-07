<?php

require_once('config/class.mysql.php');

require_once('classes/class.dailyactivity.php');

require_once('classes/class.scrollingwindows.php');

$obj1 = new Scrolling_Windows();

$obj = new Daily_Activity();



$edit_action_id = '7';



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

	$activity_id = $_POST['hdnactivity_id'];

	$activity_code = strip_tags(trim($_POST['activity_code']));

        $activity = strip_tags(trim($_POST['activity']));

	$activity_cal_kg_min = strip_tags(trim($_POST['activity_cal_kg_min']));

	$activity_cal_kg_hr = strip_tags(trim($_POST['activity_cal_kg_hr']));

	$activity_cal_59_kg = strip_tags(trim($_POST['activity_cal_59_kg']));

	$activity_level_code = strip_tags(trim($_POST['activity_level_code']));

	//$activity_category = strip_tags(trim($_POST['activity_category']));
	// add by ample 27-11-19
	$arr_selected_cat_id = array();

    foreach ($_POST['selected_cat_id1'] as $key => $value) 

    {

        array_push($arr_selected_cat_id,$value);

    }

	$recommendations = strip_tags(trim($_POST['recommendations']));

	$guidelines = strip_tags(trim($_POST['guidelines']));

	$precautions = strip_tags(trim($_POST['precautions']));

	$benefits = strip_tags(trim($_POST['benefits']));

		// add by ample 12-12-19
	$status = $_POST['status'];
	
	if($activity == '')

	{

		$error = true;

		$err_msg .= 'Please enter activity';

	}

	elseif($obj->chkactivityExists_edit($activity,$activity_id))

	{

		$error = true;

		$err_msg .= 'This activity already registered</div>';

	}



	if(!$error)

	{
		$activity_category = implode(',',$arr_selected_cat_id);

		if($obj->updateDailyActivityFull($activity_code,$activity,$activity_cal_kg_min,$activity_cal_kg_hr,$activity_cal_59_kg,$activity_level_code,$activity_category,$recommendations,$guidelines,$precautions,$benefits,$activity_id,$status))

		{

			$msg = "Activity Updated Successfully!";

			header('location: index.php?mode=daily_activity&msg='.urlencode($msg));

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

	$activity_id = $_GET['id'];

	list($activity_code,$activity,$activity_cal_kg_min,$activity_cal_kg_hr,$activity_cal_59_kg,$activity_level_code,$activity_category,$recommendations,$guidelines,$precautions,$benefits,$status) = $obj->getActivityDetails($activity_id);

	if($activity == '')

	{

		header('location: index.php?mode=daily_activity');	

	}	

}	

else

{

	header('location: index.php?mode=daily_activity');

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

						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Daily Activity</td>

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

							<form action="#" method="post" name="frmedit_daily_activity" id="frmedit_daily_activity" enctype="multipart/form-data" >

							<input type="hidden" name="hdnactivity_id" id="hdnactivity_id" value="<?php echo $activity_id;?>" />

							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">

							<tbody>

                                                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                            

                                                                <tr>

									<td width="20%" align="right"><strong>Activity Code</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

										<input name="activity_code" id="activity_code" type="text" value="<?php echo $activity_code;?>" style="width:200px;"  />

									</td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right"><strong>Activity</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left"><input name="activity" type="text" id="activity" value="<?php echo $activity; ?>" style="width:200px;" ></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right"><strong>CAL/KG/MIN</strong></td>

									<td align="center"><strong>:</strong></td>

									<td align="left"><input name="activity_cal_kg_min" type="text" id="activity_cal_kg_min" value="<?php echo $activity_cal_kg_min; ?>" style="width:200px;" ></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right"><strong>CAL/KG/HR</strong></td>

									<td align="center"><strong>:</strong></td>

									<td align="left"><input name="activity_cal_kg_hr" type="text" id="activity_cal_kg_hr" value="<?php echo $activity_cal_kg_hr; ?>" style="width:200px;" ></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right"><strong>59(KG)</strong></td>

									<td align="center"><strong>:</strong></td>

									<td align="left"><input name="activity_cal_59_kg" type="text" id="activity_cal_59_kg" value="<?php echo $activity_cal_59_kg; ?>" style="width:200px;" ></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right"><strong>Activity Level Code</strong></td>

									<td align="center"><strong>:</strong></td>

									<td align="left">

<!--                                                                            <input name="activity_level_code" type="text" id="activity_level_code" value="<?php //echo $activity_level_code; ?>" style="width:200px;" >-->

                                                                            <select name="activity_level_code" id="activity_level_code" style="width:200px;">

                                                                                <?php  echo $obj1->getFavCategoryRamakant('34',$activity_level_code); ?>

                                                                            </select>

                                                                        </td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

                                                                    <td align="right"><strong>Activity Category</strong></td>

									<td align="center"><strong>:</strong></td>

									<td align="left">
																		<!-- code comment by ample 27-11-19 -->
                                                                            <!-- <select name="activity_category" id="activity_category" style="width:200px;">

                                                                                <?php  //echo $obj1->getFavCategoryRamakant('35',$activity_category)?>

                                                                            </select> -->

                                                                                    <!--code add by ample 27-11-19 -->
                                                                    <?php 

                                                                    $activity_category_explode=explode(',', $activity_category);

                                                                    echo $obj1->getAllCategoryChkeckbox('35',$activity_category_explode,'','','300','200'); ?>

                                                                        </td>

<!--									<td align="right"><strong>Activity Category</strong></td>

									<td align="center"><strong>:</strong></td>

									<td align="left"><input name="activity_category" type="text" id="activity_category" value="<?php echo $activity_category; ?>" style="width:200px;" ></td>-->

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right" valign="top"><strong>Recommendations</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left" valign="top"><textarea name="recommendations" id="recommendations" cols="30" rows="10" ><?php echo $recommendations; ?></textarea> </td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right" valign="top"><strong>Guidelines</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left" valign="top"><textarea name="guidelines" id="guidelines" cols="30" rows="10" ><?php echo $guidelines; ?></textarea> </td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right" valign="top"><strong>Precautions</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left" valign="top"><textarea name="precautions" id="precautions" cols="30" rows="10" ><?php echo $precautions; ?></textarea> </td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right" valign="top"><strong>Benefits</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left" valign="top"><textarea name="benefits" id="benefits" cols="30" rows="10" ><?php echo $benefits; ?></textarea> </td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right" valign="top"><strong>Status</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left" valign="top">
										 <select name="status" id="status" style="width:150px; height: 23px;">
                                                <option value="1" <?=($status=='1')? 'selected' : ''; ?> >Active</option>
						                        <option value="0" <?=($status=='0')? 'selected' : ''; ?> >Inactive</option>
                                            </select>

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