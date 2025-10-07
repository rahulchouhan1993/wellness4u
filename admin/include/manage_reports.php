<?php
require_once('config/class.mysql.php');
require_once('classes/class.reports.php');

$obj = new Reports();

if(isset($_POST['btnSubmit']))
{
	$search = strip_tags(trim($_POST['search']));
   
}

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

$enable_disable_report_action = '121';
if(!$obj->chkValidActionPermission($admin_id,$enable_disable_report_action))
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}

if(isset($_GET['msg']) && $_GET['msg'] != '' ) 
{ 
	$msg =  urldecode($_GET['msg']); 
}


if(isset($_POST['btnEnable']))
{
	$user_id_row = $_POST['user_id_row'];
	$report_type = $_POST['report_type'];
	
	if(is_array($report_type) && count($report_type) > 0)
	{
		if(is_array($user_id_row) && count($user_id_row) > 0)
		{
			$value = '1';
			for($i=0;$i<count($user_id_row);$i++)
			{
				for($j=0;$j<count($report_type);$j++)
				{
					$obj->updateReportPermission($user_id_row[$i],$report_type[$j],$value);
				}
			}	
			$msg = 'Selected records updated!';
		}	
		else
		{
			$msg = 'Please select any user';
		}	
	}
	else
	{
		$msg = 'Please select any report type';
	}
		
}
elseif(isset($_POST['btnDisable']))
{
	$user_id_row = $_POST['user_id_row'];
	$report_type = $_POST['report_type'];
	
	if(is_array($report_type) && count($report_type) > 0)
	{
		if(is_array($user_id_row) && count($user_id_row) > 0)
		{
			$value = '0';
			for($i=0;$i<count($user_id_row);$i++)
			{
				for($j=0;$j<count($report_type);$j++)
				{
					$obj->updateReportPermission($user_id_row[$i],$report_type[$j],$value);
				}
			}	
			$msg = 'Selected records updated!';
		}	
		else
		{
			$msg = 'Please select any user';
		}	
	}
	else
	{
		$msg = 'Please select any report type';
	}
}
?>
<div id="central_part_contents">
	<div id="notification_contents"><!--notification_contents--></div>	  
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Users Reports </td>
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
							<p class="err_msg"><?php echo $msg; ?></p>
							<div id="pagination_contents" align="center"> 
								<form action="#" method="post" name="frm_user" id="frm_user" enctype="multipart/form-data" >
                               	<table border="0" width="1000" cellpadding="5" cellspacing="1">
                                	<tr>
                                    	<td>
                                        	<input type="submit" name="btnEnable" id="btnEnable" value="Enable" />&nbsp;
                                            <input type="submit" name="btnDisable" id="btnDisable" value="Disable" />&nbsp;
                                            <select name="report_type[]" id="report_type" multiple="multiple" style="height:50px;">
                                              <option value="food_chart">Food Chart</option>
											  <option value="each_meal_per_day_chart">Each Meal Per Day Chart</option>
                                              <option value="my_activity_calories_chart">My Activity Calories Chart</option>
                                              <option value="activity_analysis_chart">Activity Analysis Chart</option>
                                              <option value="meal_chart">Meal Chart</option>
                                              <option value="dpwd_chart">Digital Personal Wellness Diary</option>
                                              <option value="mwt_report">Monthly Wellness Tracker Report</option>
                                              <option value="datewise_emotions_report">Datewise Emotions Report</option>
                                              <option value="statementwise_emotions_report">Statementwise Emotions Report</option>
                                              <option value="angervent_intensity_report">Angervent Intensity Report</option>
                                              <option value="stressbuster_intensity_report">Stressbuster Intensity Report</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <table border="0" width="1000" cellpadding="5" cellspacing="1">
									<tr class="manage-header">
                                        <td width="3%" class="manage-header" align="center"></td>
                                        <td width="10%" class="manage-header" align="center">Unique Id</td>
                                        <td width="17%" class="manage-header" align="center">Name</td>
                                        <td width="7%" class="manage-header" align="center">Food Chart</td>
										<td width="7%" class="manage-header" align="center">Each Meal Per Day Chart</td>
                                        <td width="7%" class="manage-header" align="center">My Activity Calories Chart </td>
                                        <td width="7%" class="manage-header" align="center">Activity Analysis Chart </td>
										<td width="7%" class="manage-header" align="center">Meal Chart </td>
                                        <td width="7%" class="manage-header" align="center">Digital Personal Wellness Diary Report </td>		
                                        <td width="7%" class="manage-header" align="center">Monthly Wellness Tracker Report  </td>		
                                        <td width="7%" class="manage-header" align="center">Datewise Emotions Report  </td>		
                                        <td width="7%" class="manage-header" align="center">Statementwise Emotions Report  </td>
                                        <td width="7%" class="manage-header" align="center">Angervent Intensity Report  </td>
                                        <td width="7%" class="manage-header" align="center">Stressbuster Intensity Report  </td>
										
											
                                    </tr>
									<?php
									echo $obj->GetAllUsersReportsPermissions($search);
									?>
								</table>
								</form>
                                <p></p>
							<!--pagination_contents-->
							</div>
							<p></p>
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