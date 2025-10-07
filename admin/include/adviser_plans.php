<?php
require_once('config/class.mysql.php');
require_once('classes/class.subscriptions.php');  
require_once('classes/class.places.php');

$obj = new Subscriptions();
$obj2 = new Places();

$add_action_id = '181';
$view_action_id = '180';

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$view_action_id))
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}

$trlocation = 'none';

$arr_state_id = array();
$arr_city_id = array();
$arr_place_id = array();

if(isset($_POST['btnSubmit']))
{
	$search = strip_tags(trim($_POST['search']));
	$apct_id = trim($_POST['apct_id']);
	$status = strip_tags(trim($_POST['status']));
	$country_id = trim($_POST['country_id']);
	
	foreach ($_POST['state_id'] as $key => $value) 
	{
		array_push($arr_state_id,$value);
	}
	
	foreach ($_POST['city_id'] as $key => $value) 
	{
		array_push($arr_city_id,$value);
	}
	
	foreach ($_POST['place_id'] as $key => $value) 
	{
		array_push($arr_place_id,$value);
	}
	
	$start_date = trim($_POST['start_date']);
	$end_date = trim($_POST['end_date']);
	
	if($apct_id == '1')
	{
		$trlocation = '';
	}
}
else
{
	$search = '';
	$apct_id = '';
	$status = '';
	$country_id = '';
	$arr_state_id[0] = '';
	$arr_city_id[0] = '';
	$arr_place_id[0] = '';
	$start_date = '';
	$end_date = '';
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Adviser Subscriptions </td>
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
							<p class="err_msg"><?php if(isset($_GET['msg']) && $_GET['msg'] != '' ) { echo urldecode($_GET['msg']); }?></p>
							<div id="pagination_contents" align="center"> 
								<p>
                                <form action="#" method="post" name="frm_dailymeal" id="frm_dailymeal" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>Search:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="text" id="search" name="search"  value="<?php echo $search; ?>" style="width:200px;" />
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>Category:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="apct_id" id="apct_id" style="width:200px;" onchange="toggleTrLocations();">
                                                <option value="">All</option>
                                                <?php echo $obj->getAdviserPlansCategoryTypeOptions($apct_id); ?>
                                            </select>
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td width="15%" height="30" align="left" valign="middle"><strong>Status:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="status" id="status" style="width:200px;">
                                                <option value="">All Status</option>
                                                <option value="0" <?php if($status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                                <option value="1" <?php if($status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   <tr class="trlocation" style="display:<?php echo $trlocation;?>">
                                        <td height="30" align="left" valign="middle"><strong>Country:</strong></td>
                                        <td height="30" align="left" valign="middle">
                                            <select name="country_id" id="country_id" onchange="getStateOptionsMulti();" style="width:200px;">
                                                <option value="" >All Country</option>
                                                <?php echo $obj2->getCountryOptions($country_id); ?>
                                            </select>
                                        </td>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td height="30" align="left" valign="middle"><strong>State:</strong></td>
                                        <td height="30" align="left" valign="middle" id="tdstate">
                                            <select multiple="multiple" name="state_id[]" id="state_id" onchange="getCityOptionsMulti();" style="width:200px;">
                                                <option value="" <?php if (in_array('', $arr_state_id)) {?> selected="selected" <?php } ?>>All States</option>
                                                <?php echo $obj2->getStateOptionsMulti($country_id,$arr_state_id); ?>
                                            </select>
                                        </td>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td height="30" align="left" valign="middle"><strong>City:</strong></td>
                                        <td height="30" align="left" valign="middle" id="tdcity">
                                            <select multiple="multiple" name="city_id[]" id="city_id" onchange="getPlaceOptionsMulti();" style="width:200px;">
                                                <option value="" <?php if (in_array('', $arr_city_id)) {?> selected="selected" <?php } ?>>All Cities</option>
                                                <?php echo $obj2->getCityOptionsMulti($country_id,$arr_state_id,$arr_city_id); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="trlocation" style="display:<?php echo $trlocation;?>">
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    
                                    <tr class="trlocation" style="display:<?php echo $trlocation;?>">
                                        <td height="30" align="left" valign="middle"><strong>Place:</strong></td>
                                        <td height="30" align="left" valign="middle" id="tdplace">
                                             <select multiple="multiple" name="place_id[]" id="place_id" style="width:200px;">
                                                <option value="" <?php if (in_array('', $arr_place_id)) {?> selected="selected" <?php } ?>>All Places</option>
                                                <?php echo $obj2->getPlaceOptionsMulti($country_id,$arr_state_id,$arr_city_id,$arr_place_id); ?>
                                            </select>
                                        </td>
                                   		<td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td colspan="2" height="30" align="left" valign="middle">&nbsp;</td>
                                        <td colspan="2" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr class="trlocation" style="display:<?php echo $trlocation;?>">
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="30" align="left" valign="middle"><strong>Start Date:</strong></td>
                                        <td height="30" align="left" valign="middle" >
                                             <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:80px;"  />
                                        <script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                        </td>
                                   		<td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td height="30" align="left" valign="middle"><strong>End Date:</strong></td>
                                        <td colspan="2" height="30" align="left" valign="middle">
                                            <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:80px;"  />
                                        <script>$('#end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                        </td>
                                        <td colspan="2" align="center" height="30">
                                        	<input type="submit" name="btnSubmit" id="btnSubmit" value="Search" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                </tbody>
                                </table>
                                 </form>
                                </p>
								<table border="0" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<td colspan="14" align="right" nowrap="nowrap">
                                        <?php 
                                        if($obj->chkValidActionPermission($admin_id,$add_action_id))
                                        { ?>
											<a href="index.php?mode=add_adviser_plan"><img src="images/add.gif" width="10" height="8" border="0" />Add New Plan</a>
                                        <?php 
                                        } ?>     
										</td>
									</tr>
									<tr class="manage-header">
										<td class="manage-header" align="center" width="5%" nowrap="nowrap" >S.No.</td>
									    <td class="manage-header" align="center" width="20%">Plan Name</td>
                                        <td class="manage-header" align="center" width="10%">Duration</td>
                                        <td class="manage-header" align="center" width="10%">Amount</td>
                                        <td class="manage-header" align="center" width="10%">Currency</td>
                                        <td class="manage-header" align="center" width="10%">Status</td>
                                        <td class="manage-header" align="center" width="5%">Show in List</td>
                                        <td class="manage-header" align="center" width="5%">Default Plan</td>
                                        <td class="manage-header" align="center" width="5%">Added Date</td>
                                        <td class="manage-header" align="center" width="5%">Start Date</td>
                                        <td class="manage-header" align="center" width="5%">End Date</td>
                                        <td class="manage-header" align="center" width="10%">Category</td>
										<td width="5%" align="center" nowrap="nowrap" class="manage-header">Edit</td>
										<td width="5%" align="center" nowrap="nowrap" class="manage-header">Delete</td>
									</tr>
									<?php
									echo $obj->GetAllAdviserPlans($search,$apct_id,$status,$country_id,$arr_state_id,$arr_city_id,$arr_place_id,$start_date,$end_date);
									?>
								</tbody>
								</table>
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