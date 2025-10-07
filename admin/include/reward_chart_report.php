<?php
require_once('config/class.mysql.php');
require_once('classes/class.reports.php');
require_once('classes/class.users.php');

$obj = new Reports();
$admin_id = $_SESSION['admin_id'];

$obj2 = new Users();

$rewards_chart_action='162';

$rewards_chart_report_permission = $obj->chkValidActionPermission($admin_id,$rewards_chart_action);

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

$view_user_reports_action_id = '103';
if(!$obj->chkValidActionPermission($admin_id,$view_user_reports_action_id))
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}
	
$error = false;
$err_msg = "";

$country_id = '1';

if(isset($_POST['btnSubmit']))
{
	$start_day = '1';
	$start_month = trim($_POST['start_month']);
	$start_year = trim($_POST['start_year']);
	$end_day = '1';
	$end_month = trim($_POST['end_month']);
	$end_year = trim($_POST['end_year']);
	$report_user_selection = $_POST['report_user_selection'];
	$report_filter = $_POST['report_filter'];
	$state_id = trim($_POST['state_id']);
	$city_id = trim($_POST['city_id']);
	
	
	if( ($start_month == '') || ($start_year == '') )
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select start month/year';
		}
		else
		{
			$err_msg .= '<br>Please select start month/year';
		}	
	}
	elseif(!checkdate($start_month,$start_day,$start_year))
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select valid start date';
		}
		else
		{
			$err_msg .= '<br>Please select valid start date';
		}	
	}
	elseif(mktime(0,0,0,$start_month,$start_day,$start_year) > time())
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select today or previous day for start date';
		}
		else
		{
			$err_msg .= '<br>Please select today or previous day for start date';
		}	
	}
	else
	{
		$start_date = $start_year.'-'.$start_month.'-'.$start_day;
	}

	if( ($end_day == '') || ($end_month == '') || ($end_year == '') )
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select end date';
		}
		else
		{
			$err_msg .= '<br>Please select end date';
		}	
	}
	elseif(!checkdate($end_month,$end_day,$end_year))
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select valid end date';
		}
		else
		{
			$err_msg .= '<br>Please select valid end date';
		}
	}
	elseif(mktime(0,0,0,$end_month,$end_day,$end_year) > time())
	{
		if(!$error)
		{
			$error = true;
			$err_msg = 'Please select today or previous day for end date';
		}
		else
		{
			$err_msg .= '<br>Please select today or previous day for end date';
		}
	}
	else
	{
		$end_date = $end_year.'-'.$end_month.'-'.$end_day;
	}
	
	if(!$error)
	{
		list($return,$arr_reward_modules,$arr_reward_summary) = $obj->getUserRewardsChartReport($start_date,$end_date,$report_user_selection,$report_filter,$state_id,$city_id);
	}
}
else
{
	$now = time();
	$end_year = date("Y",$now);
	$end_month = date("m",$now);
	$end_day = '1'; 
	
	$start_day = '1';
	$start_year = date("Y",$now);
	$start_month = date("m",$now);
	$report_filter = '';
	$return = false;
	$msg = '';
}	
?>
<div id="central_part_contents">
	<div id="notification_contents">
	<?php
	if($error)
	{?>
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
	}?>
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Reward Chart Report</td>
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
							<form action="#" method="post" name="frmreports" id="frmreports" enctype="multipart/form-data" >
                            <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="10%" align="left"><strong>Start Month</strong></td>
									<td width="5%" align="left"><strong>:</strong></td>
									<td width="35%" align="left">
										<select name="start_month" id="start_month">
											<option value="">Month</option>
											<?php echo $obj->getMonthOptions($start_month); ?>
										</select>
										<select name="start_year" id="start_year">
											<option value="">Year</option>
										<?php
										for($i=2011;$i<=intval(date("Y"));$i++)
										{ ?>
											<option value="<?php echo $i;?>" <?php if($start_year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
										<?php
										} ?>	
								  		</select>									</td>
									<td width="10%" align="left"><strong>End Month</strong></td>
									<td width="5%" align="left"><strong>:</strong></td>
									<td width="35%" align="left">
										<select name="end_month" id="end_month">
											<option value="">Month</option>
											<?php echo $obj->getMonthOptions($end_month); ?>
										</select>
										<select name="end_year" id="end_year">
											<option value="">Year</option>
										<?php
										for($i=2011;$i<=intval(date("Y"));$i++)
										{ ?>
											<option value="<?php echo $i;?>" <?php if($end_year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
										<?php
										} ?>	
								  		</select>								  	</td>
								</tr>
								<tr>	
									<td colspan="6" align="left" height="30">&nbsp;</td>
								</tr>
								<tr>	
									<td align="left"><strong>Report Selection</strong></td>
									<td align="left"><strong>:</strong></td>
									<td align="left">
										<select name="report_user_selection" id="report_user_selection">
											<option value="">All</option>
											<option value="Person wise" <?php if($report_user_selection == 'Person wise') {?> selected="selected" <?php } ?>>Person wise</option>
								 		</select>									</td>
									<td align="left"><strong>Report Filter</strong></td>
									<td align="left"><strong>:</strong></td>
									<td align="left">
                                    	<select name="report_filter" id="report_filter">
                                            <option value="">All</option>
                                      		<option value="Entries" <?php if($report_filter == 'Entries') {?> selected="selected" <?php } ?>>Entries</option>
											<option value="Days" <?php if($report_filter == 'Days') {?> selected="selected" <?php } ?>>Days</option>
											<option value="Points" <?php if($report_filter == 'Points') {?> selected="selected" <?php } ?>>Points</option>
                                      		<option value="Rewards Redeemed" <?php if($report_filter == 'Rewards Redeemed') {?> selected="selected" <?php } ?>>Rewards Redeemed</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>	
									<td colspan="6" align="left" height="30">&nbsp;</td>
								</tr>
                                <tr>	
									<td align="left"><strong>State</strong></td>
									<td align="left"><strong>:</strong></td>
									<td align="left">
										<select name="state_id" id="state_id" onchange="getCityOptionsUser('<?php echo $city_id;?>');">
											<option value="">Select State</option>
											<?php echo $obj2->getStateOptions($country_id,$state_id); ?>
										</select>								</td>
									<td align="left"><strong>City</strong></td>
									<td align="left"><strong>:</strong></td>
									<td align="left" id="tdcity">
                                    	<select name="city_id" id="city_id">
											<option value="">Select City</option>
											<?php echo $obj2->getCityOptions($state_id,$city_id); ?>
										</select>
                                    </td>
                                </tr>
                                <tr>	
									<td colspan="6" align="left" height="30">&nbsp;</td>
								</tr>
                              	<tr>	
									<td colspan="6" align="center"><input type="Submit" name="btnSubmit" value="View Report" /></td>
								</tr>
							</tbody>
							</table>
						 	<table width="920" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td height="30">&nbsp;</td>
									<td height="30">&nbsp;</td>
								</tr>
							</table>
						<?php
						if( ($return) )
						{ ?>
                        
                        	<?php
							if( ($report_user_selection == '') )
							{ ?>
                        
                        
							<table width="920" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td height="30">&nbsp;</td>
									<td height="30">&nbsp;</td>
								</tr>
							</table>
							<table width="920" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
									<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
									<td width="20%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($start_date));?></td>
									<td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
									<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
									<td width="19%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($end_date));?></td>
									<td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
									<td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
									<td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
								</tr>
							</tbody>
							</table>
                            <table width="920" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                </tr>
                            </table>
                            <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                            <tbody>	
                                <tr>	
                                    <td colspan="2" align="left" height="30">&nbsp;</td>
                                </tr>
                                <tr>	
                                    <td align="left"><span style="font-size:18px;"><strong>Summary Reward Chart</strong></span></td>
                                    <td align="right"><input type="button" name="btnShowMonthWiseChart" id="btnShowMonthWiseChart" value="Show Monthwise Chart" onclick="showMonthWiseRewardChart('idmonthwisechart')"  /></td>
                                </tr>
                               
                            </tbody>
                            </table>
                            <table width="920" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
                            <tbody>
                                <tr>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>SNo</strong></td>
                                    <td width="20%" height="30" align="center" valign="middle"><strong>Particulars</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Total Entries</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Gained</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Number of days Posted</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Bonus Points Gained</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise TOTAL</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Encashed</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Balance Points</strong></td>
                                </tr>
                                <?php
                                //for($i=0,$j=1;$i<count($arr_reward_summary['records']);$i++,$j++)
                                $j = 1;
                                $total_summary_total_entries = 0;
								$total_summary_points_from_entry = 0;
                                $total_summary_no_of_days_posted = 0;
                                $total_summary_bonus_points = 0;
                                $total_summary_total_points = 0;
                                $total_summary_encashed_points = 0;
                                $total_summary_balance_points = 0;
                                
                                foreach($arr_reward_summary as $key => $val)
                                { 
                                    $total_summary_total_entries += $val['summary_total_entries'];
                                    $total_summary_points_from_entry += $val['summary_points_from_entry'];
                                    $total_summary_no_of_days_posted += $val['summary_no_of_days_posted'];
                                    $total_summary_bonus_points += $val['summary_bonus_points'];
                                    $total_summary_total_points += $val['summary_total_points'];
									$total_summary_encashed_points += $val['summary_total_encashed_points'];
									$total_summary_balance_points += $val['summary_total_balance_points'];
                                
                                ?>
                                <tr>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $j;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_reward_module_title'];?></strong></td>
                                    <td height="30" align="right" valign="middle" style="padding-right:2px;">
                                        <strong><?php echo $val['summary_total_entries'];?></strong>
                                    <?php 
                                    if($val['summary_total_entries'] > 0)
                                    { ?>
                                        &nbsp;<input type="button" name="btnViewEntriesDetailsList" id="btnViewEntriesDetailsList" value="View" onclick="viewEntriesDetailsList('<?php echo date('Y-m-01',strtotime($start_date));?>','<?php echo date('Y-m-t',strtotime($end_date));?>','<?php echo $key;?>','<?php echo $val['summary_reward_module_title'];?>','<?php echo $user_id;?>');"  />
                                    <?php
                                    }
                                    else
                                    { ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php
                                    } ?>     
                                    </td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_points_from_entry'];?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_no_of_days_posted'];?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_bonus_points'];?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_total_points'];?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_total_encashed_points'];?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_total_balance_points'];?></strong></td>
                                </tr>
                                <?php
                                    $j++;
                                } ?>  
                                <tr>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong>Base Total</strong></td>
                                    <td height="30" align="right" valign="middle" style="padding-right:2px;"><strong><?php echo $total_summary_total_entries;?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_points_from_entry;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_no_of_days_posted;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_bonus_points;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_total_points;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    
                                </tr> 
                                <tr>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong>Total Bonus Points</strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_bonus_points;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    
                                </tr>
                                <tr>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong>Grand Total Points</strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_total_points;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    
                                </tr> 
                                <tr>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong>Total Point Encashed</strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_encashed_points;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                </tr>
                                <tr>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong>Total Balance Points</strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_balance_points;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    
                                </tr>
                            </tbody>
                            </table>
                            <?php $idmonthwisechart = 'none';?>
                            <div id="idmonthwisechart" style="display:<?php echo $idmonthwisechart;?>"> 
                                <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                <tbody>	
                                    <tr>	
                                        <td align="left" height="30">&nbsp;</td>
                                    </tr>
                                    <tr>	
                                        <td align="left"><span style="font-size:18px;"><strong>Monthwise Reward Chart</strong></span></td>
                                        
                                    </tr>
                                   
                                </tbody>
                                </table> 
								<?php
                                //echo '<br><pre>';
                                //print_r($arr_reward_modules);
                                //echo '<br></pre>';
                                foreach($arr_reward_modules as $key => $value)
                                { ?>
                                <table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tr align="center">
                                        <td height="30" class="Header_brown">&nbsp;</td>
                                    </tr>
                                </table>
                                <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                <tbody>
                                    <tr>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
                                        <td width="20%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($key));?></td>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
                                        <td width="19%" height="30" align="left" valign="middle"><?php echo date("t M Y",strtotime($key));?></td>
                                        <td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                        <td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                    </tr>
                                </tbody>
                                </table>
                                <table width="920" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
                                <tbody>
                                    <tr>
                                        <td width="5%" height="30" align="center" valign="middle"><strong>SNo</strong></td>
                                        <td width="30%" height="30" align="center" valign="middle"><strong>Particulars</strong></td>
                                        <td width="15%" height="30" align="center" valign="middle"><strong>Conversion value for points<br />(Entries/Module)</strong></td>
                                        <td width="15%" height="30" align="center" valign="middle"><strong>Total Entries</strong></td>
                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Gained</strong></td>
                                        <td width="10%" height="30" align="center" valign="middle"><strong>Number of days Posted</strong></td>
                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Bonus Points Gained</strong></td>
                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise TOTAL Points</strong></td>
                                       <?php /*?> <td width="7%" height="30" align="center" valign="middle"><strong>Points Encashed</strong></td>
                                        <td width="10%" height="30" align="center" valign="middle"><strong>Rewards got from Points Enc</strong></td>
                                        <td width="8%" height="30" align="center" valign="middle"><strong>Balance Points</strong></td><?php */?>
                                    </tr>
                                    <?php
                                    for($i=0,$j=1;$i<count($value['records']);$i++,$j++)
                                    { ?>
                                    <tr>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $j;?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['reward_module_title'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo ($value['records'][$i]['reward_conversion_value'] == '0' ? 'NA' : $value['records'][$i]['reward_conversion_value']);?></strong></td>
                                        <td height="30" align="right" valign="middle" style="padding-right:2px;">
                                            <strong><?php echo $value['records'][$i]['total_entries'];?></strong>
                                        <?php 
                                        if($value['records'][$i]['total_entries'] > 0)
                                        { ?>
                                            &nbsp;<input type="button" name="btnViewEntriesDetailsList" id="btnViewEntriesDetailsList" value="View" onclick="viewEntriesDetailsList('<?php echo $key;?>','<?php echo date('Y-m-t',strtotime($key));?>','<?php echo $value['records'][$i]['reward_module_id'];?>','<?php echo $value['records'][$i]['reward_module_title'];?>','<?php echo $user_id;?>');"  />
                                        <?php
                                        }
                                        else
                                        { ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php
                                        } ?>   
                                        </td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['points_from_entry'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['no_of_days_posted'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['bonus_points'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['total_points'];?></strong></td>
                                       <?php /*?> <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                    </tr>
                                    <?php
                                    } ?>  
                                    <tr>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong>Base Total</strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_reward_conversion_value'];?></strong></td>
                                        <td height="30" align="right" valign="middle" style="padding-right:2px;"><strong><?php echo $value['total_total_entries'];?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_points_from_entry'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_no_of_days_posted'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_bonus_points'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_total_points'];?></strong></td>
                                        <?php /*?><td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                    </tr>
                                    <tr>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong>Total Bonus Points</strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_bonus_points'];?></strong></td>
                                        <?php /*?><td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                        
                                    </tr>
                                    <tr>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong>Grand Total Points</strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_total_points'];?></strong></td>
                                        <?php /*?><td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                        
                                    </tr> 
                                   <?php /*?> <tr>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong>Total Point Encashed</strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_encashed_points;?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        
                                    </tr>
                                    <tr>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong>Total Balance Points</strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_balance_points;?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        
                                	</tr>  <?php */?>
                                </tbody>
                                </table>
								<?php
                                } ?>  
                            </div> 
                            
                            <?php
							}
							else
							{ ?>
                            
                            
                            <?php
							foreach($arr_reward_summary as $key1 => $val1)
							{ ?>
                            
							<table width="920" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td height="30">&nbsp;</td>
									<td height="30">&nbsp;</td>
								</tr>
							</table>
							<table width="920" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
									<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
									<td width="20%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($start_date));?></td>
									<td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
									<td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
									<td width="19%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($end_date));?></td>
									<td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
									<td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
									<td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
								</tr>
								<tr>	
									<td height="30" align="left" valign="middle"><strong>Name</strong></td>
									<td height="30" align="left" valign="middle"><strong>:</strong></td>
									<td height="30" align="left" valign="middle"><?php echo $obj->getNameOfUser($key1);?></td>
									<td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>
									<td height="30" align="left" valign="middle"><strong>:</strong></td>
									<td height="30" align="left" valign="middle"><?php echo $obj->getUserUniqueId($key1);?></td>
									<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
									<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
									<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
								</tr>
								<tr>	
									<td height="30" align="left" valign="middle"><strong>Age</strong></td>
									<td height="30" align="left" valign="middle"><strong>:</strong></td>
									<td height="30" align="left" valign="middle"><?php echo $obj->getAgeOfUser($key1);?></td>
									<td height="30" align="left" valign="middle"><strong>Height</strong></td>
									<td height="30" align="left" valign="middle"><strong>:</strong></td>
									<td height="30" align="left" valign="middle"><?php echo $obj->getHeightOfUser($key1). ' cms';?></td>
									<td height="30" align="left" valign="middle"><strong>Weight</strong></td>
									<td height="30" align="left" valign="middle"><strong>:</strong></td>
									<td height="30" align="left" valign="middle"><?php echo $obj->getWeightOfUser($key1). ' Kgs';?></td>
								</tr>
							</tbody>
							</table>
                            <table width="920" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                </tr>
                            </table>
                            <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                            <tbody>	
                                <tr>	
                                    <td colspan="2" align="left" height="30">&nbsp;</td>
                                </tr>
                                <tr>	
                                    <td align="left"><span style="font-size:18px;"><strong>Summary Reward Chart</strong></span></td>
                                    <td align="right"><input type="button" name="btnShowMonthWiseChart" id="btnShowMonthWiseChart" value="Show Monthwise Chart" onclick="showMonthWiseRewardChart('idmonthwisechart_<?php echo $key1;?>')"  /></td>
                                </tr>
                               
                            </tbody>
                            </table>
                            <table width="920" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
                            <tbody>
                                <tr>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>SNo</strong></td>
                                    <td width="20%" height="30" align="center" valign="middle"><strong>Particulars</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Total Entries</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Gained</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Number of days Posted</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Bonus Points Gained</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise TOTAL</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Encashed</strong></td>
                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Balance Points</strong></td>
                                </tr>
                                <?php
                                //for($i=0,$j=1;$i<count($arr_reward_summary['records']);$i++,$j++)
                                $j = 1;
                                $total_summary_total_entries = 0;
                                $total_summary_points_from_entry = 0;
                                $total_summary_no_of_days_posted = 0;
                                $total_summary_bonus_points = 0;
                                $total_summary_total_points = 0;
                                $total_summary_encashed_points = 0;
                                $total_summary_balance_points = 0;
                                
                                foreach($val1 as $key => $val)
                                { 
                                    $total_summary_total_entries += $val['summary_total_entries'];
                                    $total_summary_points_from_entry += $val['summary_points_from_entry'];
                                    $total_summary_no_of_days_posted += $val['summary_no_of_days_posted'];
                                    $total_summary_bonus_points += $val['summary_bonus_points'];
                                    $total_summary_total_points += $val['summary_total_points'];
                                	$total_summary_encashed_points += $val['summary_total_encashed_points'];
									$total_summary_balance_points += $val['summary_total_balance_points'];
                                ?>
                                <tr>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $j;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_reward_module_title'];?></strong></td>
                                    <td height="30" align="right" valign="middle" style="padding-right:2px;">
                                        <strong><?php echo $val['summary_total_entries'];?></strong>
                                    <?php 
                                    if($val['summary_total_entries'] > 0)
                                    { ?>
                                        &nbsp;<input type="button" name="btnViewEntriesDetailsList" id="btnViewEntriesDetailsList" value="View" onclick="viewEntriesDetailsList('<?php echo date('Y-m-01',strtotime($start_date));?>','<?php echo date('Y-m-t',strtotime($end_date));?>','<?php echo $key;?>','<?php echo $val['summary_reward_module_title'];?>','<?php echo $key1;?>');"  />
                                    <?php
                                    }
                                    else
                                    { ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php
                                    } ?>     
                                    </td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_points_from_entry'];?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_no_of_days_posted'];?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_bonus_points'];?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_total_points'];?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_total_encashed_points'];?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_total_balance_points'];?></strong></td>
                                </tr>
                                <?php
                                    $j++;
                                } ?>  
                                <tr>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong>Base Total</strong></td>
                                    <td height="30" align="right" valign="middle" style="padding-right:2px;"><strong><?php echo $total_summary_total_entries;?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_points_from_entry;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_no_of_days_posted;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_bonus_points;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_total_points;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    
                                </tr> 
                                <tr>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong>Total Bonus Points</strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_bonus_points;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    
                                </tr>
                                <tr>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong>Grand Total Points</strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_total_points;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    
                                </tr> 
                                <tr>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong>Total Point Encashed</strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_encashed_points;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                </tr>
                                <tr>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong>Total Balance Points</strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_balance_points;?></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                    
                                </tr>
                            </tbody>
                            </table>
                            <?php $idmonthwisechart = 'none';?>
                            <div id="idmonthwisechart_<?php echo $key1;?>" style="display:<?php echo $idmonthwisechart;?>"> 
                                <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                <tbody>	
                                    <tr>	
                                        <td align="left" height="30">&nbsp;</td>
                                    </tr>
                                    <tr>	
                                        <td align="left"><span style="font-size:18px;"><strong>Monthwise Reward Chart</strong></span></td>
                                        
                                    </tr>
                                   
                                </tbody>
                                </table> 
								
								
								
								<?php
                                //echo '<br><pre>';
                                //print_r($arr_reward_modules);
                               // echo '<br></pre>';
                                foreach($arr_reward_modules[$key1] as $key => $value)
                                { ?>
                                <table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tr align="center">
                                        <td height="30" class="Header_brown">&nbsp;</td>
                                    </tr>
                                </table>
                                <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                <tbody>
                                    <tr>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
                                        <td width="20%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($key));?></td>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
                                        <td width="19%" height="30" align="left" valign="middle"><?php echo date("t M Y",strtotime($key));?></td>
                                        <td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                        <td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                    </tr>
                                    <tr>	
                                        <td height="30" align="left" valign="middle"><strong>Name</strong></td>
                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>
                                        <td height="30" align="left" valign="middle"><?php echo $obj->getNameOfUser($key1);?></td>
                                        <td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>
                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>
                                        <td height="30" align="left" valign="middle"><?php echo $obj->getUserUniqueId($key1);?></td>
                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                    </tr>
                                </tbody>
                                </table>
                                <table width="920" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
                                <tbody>
                                    <tr>
                                        <td width="5%" height="30" align="center" valign="middle"><strong>SNo</strong></td>
                                        <td width="30%" height="30" align="center" valign="middle"><strong>Particulars</strong></td>
                                        <td width="15%" height="30" align="center" valign="middle"><strong>Conversion value for points<br />(Entries/Module)</strong></td>
                                        <td width="15%" height="30" align="center" valign="middle"><strong>Total Entries</strong></td>
                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Gained</strong></td>
                                        <td width="10%" height="30" align="center" valign="middle"><strong>Number of days Posted</strong></td>
                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Bonus Points Gained</strong></td>
                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise TOTAL Points</strong></td>
                                       <?php /*?> <td width="7%" height="30" align="center" valign="middle"><strong>Points Encashed</strong></td>
                                        <td width="10%" height="30" align="center" valign="middle"><strong>Rewards got from Points Enc</strong></td>
                                        <td width="8%" height="30" align="center" valign="middle"><strong>Balance Points</strong></td><?php */?>
                                    </tr>
                                    <?php
                                    for($i=0,$j=1;$i<count($value['records']);$i++,$j++)
                                    { ?>
                                    <tr>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $j;?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['reward_module_title'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo ($value['records'][$i]['reward_conversion_value'] == '0' ? 'NA' : $value['records'][$i]['reward_conversion_value']);?></strong></td>
                                        <td height="30" align="right" valign="middle" style="padding-right:2px;">
                                            <strong><?php echo $value['records'][$i]['total_entries'];?></strong>
                                        <?php 
                                        if($value['records'][$i]['total_entries'] > 0)
                                        { ?>
                                            &nbsp;<input type="button" name="btnViewEntriesDetailsList" id="btnViewEntriesDetailsList" value="View" onclick="viewEntriesDetailsList('<?php echo $key;?>','<?php echo date('Y-m-t',strtotime($key));?>','<?php echo $value['records'][$i]['reward_module_id'];?>','<?php echo $value['records'][$i]['reward_module_title'];?>','<?php echo $user_id;?>');"  />
                                        <?php
                                        }
                                        else
                                        { ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php
                                        } ?>   
                                        </td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['points_from_entry'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['no_of_days_posted'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['bonus_points'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['total_points'];?></strong></td>
                                        <?php /*?><td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                    </tr>
                                    <?php
                                    } ?>  
                                    <tr>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong>Base Total</strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_reward_conversion_value'];?></strong></td>
                                        <td height="30" align="right" valign="middle" style="padding-right:2px;"><strong><?php echo $value['total_total_entries'];?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_points_from_entry'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_no_of_days_posted'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_bonus_points'];?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_total_points'];?></strong></td>
                                        <?php /*?><td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                    </tr>
                                    <tr>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong>Total Bonus Points</strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_bonus_points'];?></strong></td>
                                       <?php /*?> <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                        
                                    </tr>
                                    <tr>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong>Grand Total Points</strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_total_points'];?></strong></td>
                                       <?php /*?> <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                        
                                    </tr> 
                                    <?php /*?><tr>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong>Total Point Encashed</strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_encashed_points;?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        
                                    </tr>
                                    <tr>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong>Total Balance Points</strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_balance_points;?></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                        
                                	</tr>  <?php */?>
                                </tbody>
                                </table>
								<?php
                                } ?>  
                            </div>
							
							<?php
							}?>
							
							<?php
							}?>
                            
                            </form>	
						<?php
						}
						else
						{ ?>
							<table width="920" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td height="30" align="center" class="err_msg"><?php echo $msg;?></td>
								</tr>
							</table>
						<?php
						} ?>
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