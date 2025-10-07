<?php
require_once('config/class.mysql.php');
require_once('classes/class.subscriptions.php');
require_once('classes/class.places.php');  

$obj = new Subscriptions();
$obj2 = new Places();

$edit_action_id = '192';

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


$arr_upa_id = array();
$arr_upa_name = array();
$arr_upa_value = array();
$arr_upc_id = array();
$arr_upc_value = array();
$arr_upa_readonly = array();

if(isset($_POST['btnSubmit']))
{	


	$up_id = $_POST['hdnup_id'];
	$up_status = trim($_POST['up_status']);
	$up_name = trim($_POST['up_name']);
	$upct_id = trim($_POST['upct_id']);
	
	$up_amount = trim($_POST['up_amount']);
	$up_currency = trim($_POST['up_currency']);
	$up_default = trim($_POST['up_default']);

	$up_duration=trim($_POST['up_duration']);
	$up_points = trim($_POST['up_points']);
	$up_show = trim($_POST['up_show']);

	//add by 24/11/20
	$admin_notes=trim($_POST['admin_notes']);
	$narration=trim($_POST['narration']);

	//add by 9-12-20
	$prize_heading=trim($_POST['prize_heading']);
	$prize_ids=implode(',',$_POST['prize_ids']);
	
		
	foreach ($_POST['hdnupa_id'] as $key => $value) 
	{
		array_push($arr_upa_id,$value);
	}
	
	foreach ($_POST['hdnupa_name'] as $key => $value) 
	{
		array_push($arr_upa_name,$value);
	}
	
	foreach ($_POST['hdnupa_readonly'] as $key => $value) 
	{
		array_push($arr_upa_readonly,$value);
	}	
	
	for($i=0;$i<count($arr_upa_id);$i++)
	{
		if(isset($_POST['upa_value_'.$i]))
		{
			array_push($arr_upa_value , $_POST['upa_value_'.$i]);
		}
		else
		{
			array_push($arr_upa_value , '');
		}	
		
		if(isset($_POST['upc_id_'.$i]))
		{
			array_push($arr_upc_id , $_POST['upc_id_'.$i]);
		}
		else
		{
			array_push($arr_upc_id , '');
		}	
		
		if(isset($_POST['upc_value_'.$i]))
		{
			array_push($arr_upc_value , $_POST['upc_value_'.$i]);
		}
		else
		{
			array_push($arr_upc_value , '');
		}
	}
	
	if($upct_id == '1')
	{
		$trlocation = '';
	}
	
	if($up_name == "")
	{
		$error = true;
		$err_msg = "Please enter plan name.";
	}
	
	
	if($up_amount == "")
	{
		$error = true;
		$err_msg .= "<br>Please enter amount.";
	}
	elseif(!is_numeric($up_amount))
	{
		$error = true;
		$err_msg .= "<br>Please enter valid amount.";
	}
	
	if($up_currency == "")
	{
		$error = true;
		$err_msg .= "<br>Please select currency.";
	}

	if($up_duration == "")

	{

		$error = true;

		$err_msg .= "<br>Please enter duration.";

	}

	if(!$error)
	{
		

		//update by ample 20-11-20,23-11-20
		if($obj->updateUserPlan($up_id,$up_name,$up_amount,$up_points,$up_currency,$up_duration,$up_default,$up_status,$arr_upa_id,$arr_upa_value,$arr_upc_id,$arr_upc_value,$upct_id,$up_show,$admin_notes,$narration,$prize_heading,$prize_ids))
		{
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=user_plans&msg='.urlencode($msg));
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

	$up_id = $_GET['id'];
	//update by ample 20-11-20,23-11-20
	list($up_name,$up_amount,$up_points,$up_currency,$up_duration,$up_status,$up_default,$arr_upa_id,$arr_upa_name,$arr_upa_value,$arr_upc_id,$arr_upc_value,$upct_id,$up_show,$admin_notes,$narration,$prize_heading,$prize_list) = $obj->getUserPlanDetails($up_id);
	
	$prize_list=explode(',', $prize_list);

	if($up_name == '')
	{
		header('location: index.php?mode=user_plans');	
	}
		

}	
else
{
	header('location: index.php?mode=adviser_plans');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit User Plan</td>
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
							<form action="#" method="post" name="frmedit_sleep" id="frmedit_sleep" enctype="multipart/form-data" onsubmit=" return confirmEditUserPlan();" >
							<input type="hidden" name="hdnup_id" id="hdnup_id" value="<?php echo $up_id;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow">
							<tbody>
								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>
                            	<tr>
									<td width="30%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="65%" align="left">
                                        <select id="up_status" name="up_status">
                                            <option value="1" <?php if($up_status == '1'){ ?> selected <?php } ?>>Active</option>
                                            <option value="0" <?php if($up_status == '0'){ ?> selected <?php } ?>>Inactive</option>
                                        </select>
                                    </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Plan Name</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
                                    	<input type="text" name="up_name" id="up_name" value="<?php echo $up_name;?>" style="width:200px;" disabled>
                                    	<input type="hidden" name="up_name" id="up_name" value="<?php echo $up_name;?>" style="width:200px;" readonly>
                                                                 </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Category Type</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="upct_id" id="upct_id" style="width:200px;" disabled> 
											<option value="">All</option>
                                            <?php echo $obj->getUserPlansCategoryTypeOptions($upct_id); ?>
                                        </select>
                                        <input type="hidden" name="upct_id" value="<?=$upct_id;?>" readonly>
                                   	</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Amount</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<input type="text" name="up_amount" id="up_amount" value="<?php echo $up_amount;?>" style="width:200px;" disabled>
                                    	<input type="hidden" name="up_amount" id="up_amount" value="<?php echo $up_amount;?>" style="width:200px;" readonly>
		                           	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Currency</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="up_currency" id="up_currency" style="width:200px;" disabled>
											<option value="">Select Currency</option>
                                           <?php echo $obj->getFavCategoryRamakant('95',$up_currency); ?>
                                        </select>
                                        <input type="hidden" name="up_currency" value="<?=$up_currency;?>" readonly>
                                   	</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Duration (days)</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<input type="number" name="up_duration" id="up_duration" value="<?php echo $up_duration;?>" style="width:200px;" disabled>
                                    	<input type="hidden" name="up_duration" id="up_duration" value="<?php echo $up_duration;?>" style="width:200px;" readonly>
		                           	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Extra Points</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<input type="text" name="up_points" id="up_points" value="<?php echo $up_points;?>" style="width:200px;" disabled>
                                    	<input type="hidden" name="up_points" id="up_points" value="<?php echo $up_points;?>" style="width:200px;" readonly>
		                           	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>

									<td align="right"><strong>Default Plan</strong></td>

									<td align="center"><strong>:</strong></td>

									<td align="left"><input type="checkbox" name="up_default" id="up_default" value="1"  <?php if($up_default == '1'){?> checked="checked" <?php }?> onclick="confirmUserDefaultPlan('')"   ></td>

								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Show In List</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select id="up_show" name="up_show">
                                            <option value="1" <?php if($up_show == '1'){ ?> selected <?php } ?>>Yes</option>
                                            <option value="0" <?php if($up_show == '0'){ ?> selected <?php } ?>>No</option>
                                        </select>
                                    </td>
								</tr>
								 <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right" valign="top"><strong>Admin Notes</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<textarea id="admin_notes" name="admin_notes" style="width: 400px; height:200px;"><?php echo stripslashes($admin_notes);?></textarea>

									</td>

								</tr>
								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right" valign="top"><strong>Narration</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<textarea id="narration" name="narration" style="width: 400px; height:200px;"><?php echo stripslashes($narration);?></textarea>

									</td>

								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right" valign="top"><strong>Prize Heading</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
										<input type="text" name="prize_heading" id="prize_heading" value="<?php echo $prize_heading;?>" style="width:200px;" >
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right" valign="top"><strong>Prize List</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
										<?=$obj->getPlanPrizeListCheckbox($prize_list);?>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"></td>
									<td align="center"></td>
									<td align="left"><strong>Plan Features</strong></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <?php
								for($i=0;$i<count($arr_upa_id);$i++)
								{ 
									$arr_upa_readonly[$i] = 'readonly';
								?>
                                <tr>
									<td align="right"><strong><?php echo $arr_upa_name[$i];?></strong> &nbsp;  <a href="index.php?mode=page_setting&page_id=<?=$arr_upa_id[$i]?>&plan_id=<?=$_GET['id'];?>" target="_blank"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> </td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<input type="hidden" name="hdnupa_id[]" id="hdnupa_id_<?php echo $i;?>" value="<?php echo $arr_upa_id[$i]?>"  />
                                        <input type="hidden" name="hdnupa_name[]" id="hdnupa_name_<?php echo $i;?>" value="<?php echo $arr_upa_name[$i]?>"  />
                                        <input type="hidden" name="hdnupa_readonly[]" id="hdnupa_readonly_<?php echo $i;?>" value="<?php echo $arr_upa_readonly[$i]?>"  />
                                    	<table align="left" border="0" width="100%" cellpadding="0" cellspacing="0">
                                        	<tr>
                                            	<td width="10%" align="left"><input type="checkbox" name="upa_value_<?php echo $i;?>" id="upa_value_<?php echo $i;?>" value="1" <?php if($arr_upa_value[$i] == '1'){?> checked="checked" <?php }?> onclick="return false"    ></td>
                                                <td width="40%" align="left">
                                                	<select name="upc_id_<?php echo $i;?>" id="upc_id_<?php echo $i;?>" style="width:200px;" disabled="disabled">
                                                        <option value="">Select Criteria</option>
                                                        <?php //echo $obj->getAdviserCriteriaOptions($arr_upc_id[$i]); 

                                                        	$options=$obj->get_subcription_plan_criteria();
                                                        	if(!empty($options))
                                                        	{
                                                        		foreach ($options as $key => $value) {
                                                        			$sel='';
                                                        			if($value==$arr_upc_id[$i])
                                                        			{
                                                        				$sel='selected';
                                                        			}
                                                        			?>
                                                        			<option value="<?=$value;?>" <?=$sel;?> ><?=$obj->getFavCategoryName($value);?></option>
                                                        			<?php
                                                        		}
                                                        	}

                                                        ?>
                                                    </select>
                                                    <input type="hidden" name="upc_id_<?php echo $i;?>" id="upc_id_<?php echo $i;?>" value="<?php echo $arr_upc_id[$i]?>"  />
                                                </td>
                                                <td width="50%" align="left"><input readonly="readonly" type="text" name="upc_value_<?php echo $i;?>" id="upc_value_<?php echo $i;?>" value="<?php echo $arr_upc_value[$i]; ?>" ></td>
                                            </tr>    
                                   		</table> 
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <?php
								} ?>

								 <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>
								 <tr>

									<td align="right"></td>

									<td align="center"></td>

									<td align="left"><strong>Report Features &nbsp;  <a href="index.php?mode=page_setting&page_id=38&plan_id=<?=$_GET['id'];?>" target="_blank"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></strong></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                <?php

                                $report_data=$obj->get_report_feature($up_id);

                                if(!empty($report_data))
                                {

                                	foreach ($report_data as $key => $value) 
                                	{


                                	?>

                                		<tr>

										<td align="right"><strong><?php echo $obj->get_Report_name($value['upc_id']);?></strong></td>

										<td align="center"><strong>:</strong></td>

										<td align="left">

											<input type="hidden" name="rep_page_id[]" value="<?php echo $value['upa_id'];?>">

											<input type="hidden" name="rep_cat_id[]" value="<?php echo $value['upc_id'];?>">

	                                    	<table align="left" border="0" width="100%" cellpadding="0" cellspacing="0">

	                                        	<tr>

	                                            	<td width="10%" align="left">
	                                            		<input class="chkbxapaid" type="checkbox" name="rep_check[<?=$key;?>]" id="rep_check_<?php echo $i;?>" value="1"  <?=($value['upa_value']==1)? 'checked' : ''; ?> disabled="disabled"></td>


	                                                <td width="50%" align="left"><input type="text" name="rep_value[]" id="rep_value_<?php echo $i;?>" value="<?=$value['upc_value']?>" disabled="disabled"></td>

	                                            </tr>    

	                                   		</table> 

	                                    </td>

									</tr>

									<tr>

										<td colspan="3" align="center">&nbsp;</td>

									</tr>
									<?php
                                	
                                	}

                                }
                                ?>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong></strong></td>
									<td align="center"><strong></strong></td>
									<td align="left">
                                        <a href="index.php?mode=update_scheduled&redirect_id=<?=$_GET['id']?>&redirect=userPlans" target="_blank"><button type="button" class="btn btn-warning btn-xs">Schedule Set</button></a>
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

     <script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>

    <script type="text/javascript">

        tinyMCE.init({

            mode : "exact",

            theme : "advanced",

            elements : "narration,admin_notes",

            plugins : "style,advimage,advlink,emotions",

            theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

            theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

            theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",

        });



    </script>
