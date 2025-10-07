<?php
require_once('config/class.mysql.php');
require_once('classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();

$edit_action_id = '198';

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

$tr_days_of_month = 'none';
$tr_single_date = 'none';
$tr_date_range = 'none';

$arr_page_id = array();
$arr_sb_days_of_month = array();

if(isset($_POST['btnSubmit']))
{
	$sb_id = $_POST['hdnsb_id'];
	foreach ($_POST['page_id'] as $key => $value) 
	{
		array_push($arr_page_id,$value);
	}
	
	if($arr_page_id[0] == '')
	{
		$page_id = '';
	}
	else
	{
		$page_id = implode(',',$arr_page_id);
	}
	
	$sb_listing_date_type = trim($_POST['sb_listing_date_type']);
		
	foreach ($_POST['sb_days_of_month'] as $key => $value) 
	{
		array_push($arr_sb_days_of_month,$value);
	}
	
	$sb_single_date = trim($_POST['sb_single_date']);
	$sb_start_date = trim($_POST['sb_start_date']);
	$sb_end_date = trim($_POST['sb_end_date']);
	$sb_content = trim($_POST['sb_content']);
	$sb_content_font_family = trim($_POST['sb_content_font_family']);
	$sb_content_font_size = trim($_POST['sb_content_font_size']);
	$sb_content_font_color = trim($_POST['sb_content_font_color']);
	$sb_show_content_credit = trim($_POST['sb_show_content_credit']);
	$sb_content_credit_name = strip_tags(trim($_POST['sb_content_credit_name']));
	$sb_content_credit_link = strip_tags(trim($_POST['sb_content_credit_link']));
	$sb_order = trim($_POST['sb_order']);
	$sb_status = strip_tags(trim($_POST['sb_status']));
	
	
	if($sb_listing_date_type == '')
	{
		$error = true;
		$err_msg = 'Please select selection date type';
	}
	elseif($sb_listing_date_type == 'days_of_month')
	{
		$tr_days_of_month = '';
		$tr_single_date = 'none';
		$tr_date_range = 'none';
		
		if(count($arr_sb_days_of_month) < 1)
		{
			$error = true;
			$err_msg = 'Please select days of month';
		}
		else
		{
			$sb_days_of_month = implode(',',$arr_sb_days_of_month);
		}	
	}
	elseif($sb_listing_date_type == 'single_date')
	{
		$tr_days_of_month = 'none';
		$tr_single_date = '';
		$tr_date_range = 'none';
		
		if($sb_single_date == '')
		{
			$error = true;
			$err_msg = 'Please select single date';
		}	
	}
	elseif($sb_listing_date_type == 'date_range')
	{
		$tr_days_of_month = 'none';
		$tr_single_date = 'none';
		$tr_date_range = '';
		
		if($sb_start_date == '')
		{
			$error = true;
			$err_msg = 'Please select start date';
		}
		elseif($sb_end_date == '')
		{
			$error = true;
			$err_msg = 'Please select end date';
		}
		else
		{
			if(strtotime($sb_start_date) > strtotime($sb_end_date))
			{
				$error = true;
				$err_msg = 'Please select end date greater than start date';
			}
		}	
	}
	
	if($sb_content == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter content ';
	}
	
	if($sb_content_font_family == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter font family for contents';
	}
	
	if($sb_content_font_size == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter font size for contents';
	}
	
	if($obj->chkIfScrollingBarOrderAlreadyExists_edit($sb_order,$page_id,$sb_id))
	{
		$error = true;
		$err_msg .= '<br>Slider Order - '.$sb_order.' is already exist';
	}
	
	
	if(isset($_FILES['sb_content_image']['tmp_name']) && $_FILES['sb_content_image']['tmp_name'] != '')
	{
		$sb_content_image = $_FILES['sb_content_image']['name'];
		$file4 = substr($sb_content_image, -4, 4);
		if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF'))
		{
			$error = true;
			$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg) image';
		}	 
		elseif( $_FILES['sb_content_image']['type'] != 'image/jpeg' and $_FILES['sb_content_image']['type'] != 'image/pjpeg' and $_FILES['sb_content_image']['type'] != 'image/gif' )
		{
			$error = true;
			$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg) image';
		}
		
		$sb_content_image = time()."_".$sb_content_image;
		$temp_dir = SITE_PATH.'/uploads/';
		$temp_file = $temp_dir.$sb_content_image;
		
		if(!move_uploaded_file($_FILES['sb_content_image']['tmp_name'], $temp_file)) 
		{
			if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
			$error = true;
			$err_msg .= '<br>Couldn\'t Upload image';
			$sb_content_image = strip_tags(trim($_POST['hdnsb_content_image']));
		}
		else
		{
			$obj->createThumbNailSingle(SITE_PATH."/uploads/".$sb_content_image,SITE_PATH."/uploads/".$sb_content_image,60);
		}	
	}
	else
	{
		$sb_content_image = strip_tags(trim($_POST['hdnsb_content_image']));
	}
	
	if(!$error)
	{
		if($sb_listing_date_type == 'days_of_month')
		{
			$sb_single_date = '';
			$sb_start_date = '';
			$sb_end_date = '';
		}
		elseif($sb_listing_date_type == 'single_date')
		{
			$sb_days_of_month = '';
			$sb_start_date = '';
			$sb_end_date = '';
			
			$sb_single_date = date('Y-m-d',strtotime($sb_single_date));
		}
		elseif($sb_listing_date_type == 'date_range')
		{
			$sb_days_of_month = '';
			$sb_single_date = '';
			
			$sb_start_date = date('Y-m-d',strtotime($sb_start_date));
			$sb_end_date = date('Y-m-d',strtotime($sb_end_date));
		}
		
		if($obj->updateScrollingBar($sb_id,$page_id,$sb_listing_date_type,$sb_days_of_month,$sb_single_date,$sb_start_date,$sb_end_date,$sb_content,$sb_content_font_family,$sb_content_font_size,$sb_content_font_color,$sb_content_image,$sb_show_content_credit,$sb_content_credit_name,$sb_content_credit_link,$sb_order,$sb_status))
		{
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=scrolling_bars&msg='.urlencode($msg));
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
	$sb_id = $_GET['id'];
	list($return,$page_id,$sb_content,$sb_content_font_family,$sb_content_font_size,$sb_content_font_color,$sb_content_image,$sb_content_show_credit,$sb_content_credit_name,$sb_content_credit_link,$sb_status,$sb_listing_date_type,$sb_days_of_month,$sb_single_date,$sb_start_date,$sb_end_date,$sb_order) = $obj->getScrollingBarDetails($sb_id);
	if(!$return)
	{
		header('location: index.php?mode=scrolling_bars');	
	}	
	
	if($page_id == '')
	{
		$arr_page_id[0] = '';
	}
	else
	{
		$pos1 = strpos($page_id, ',');
		if ($pos1 !== false) 
		{
			$arr_page_id = explode(',',$page_id);
		}
		else
		{
			array_push($arr_page_id , $page_id);
		}
	}
	
	if($sb_content_font_color == '')
	{
		$sb_content_font_color = '000000';
	}	
	
	if($sb_listing_date_type == 'days_of_month')
	{
		$tr_days_of_month = '';
		$tr_single_date = 'none';
		$tr_date_range = 'none';
		
		$sb_single_date = '';
		$sb_start_date = '';
		$sb_end_date = '';
		
		$pos = strpos($sb_days_of_month, ',');
		if ($pos !== false) 
		{
			$arr_sb_days_of_month = explode(',',$sb_days_of_month);
		}
		else
		{
			array_push($arr_sb_days_of_month , $sb_days_of_month);
		}
	}
	elseif($sb_listing_date_type == 'single_date')
	{
		$tr_days_of_month = 'none';
		$tr_single_date = '';
		$tr_date_range = 'none';
		
		$sb_days_of_month = '';
		$sb_start_date = '';
		$sb_end_date = '';
		
		$sb_single_date = date('d-m-Y',strtotime($sb_single_date));
	}
	elseif($sb_listing_date_type == 'date_range')
	{
		$tr_days_of_month = 'none';
		$tr_single_date = 'none';
		$tr_date_range = '';
		
		$sb_days_of_month = '';
		$sb_single_date = '';
		
		$sb_start_date = date('d-m-Y',strtotime($sb_start_date));
		$sb_end_date = date('d-m-Y',strtotime($sb_end_date));
	}
}	
else
{
	header('location: index.php?mode=scrolling_bars');
}
?>
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Scrolling Window</td>
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
							<input type="hidden" name="hdnsb_id" id="hdnsb_id" value="<?php echo $sb_id;?>" />
                            <input type="hidden" name="hdnsb_content_image" id="hdnsb_content_image" value="<?php echo $sb_content_image;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="30%" align="right" valign="top"><strong>Page Name</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="65%" align="left" valign="top">
                                    	<select id="page_id" name="page_id[]" multiple="multiple" style="width:200px;">
                                            <option value="" <?php if (in_array('', $arr_page_id)) {?> selected="selected" <?php } ?>>All Page</option>
                                            <?php echo $obj->getScrollingBarPagesOptionsMulti($arr_page_id); ?>
                                        </select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                <tr>
									<td width="30%" align="right"><strong>Date Selection Type</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="65%" align="left">
                                    	<select name="sb_listing_date_type" id="sb_listing_date_type" onchange="toggleDateSelectionType('sb_listing_date_type')" style="width:200px;">
                                        	<option value="">Select Option</option>
                                            <option value="days_of_month" <?php if($sb_listing_date_type == 'days_of_month') { ?> selected="selected" <?php } ?>>Days of Month</option>
                                            <option value="single_date" <?php if($sb_listing_date_type == 'single_date') { ?> selected="selected" <?php } ?>>Single Date</option>
                                            <option value="date_range" <?php if($sb_listing_date_type == 'date_range') { ?> selected="selected" <?php } ?>>Date Range</option>
                                        </select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr id="tr_days_of_month" style="display:<?php echo $tr_days_of_month;?>">
									<td align="right" valign="top"><strong>Select days of month</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                    	<select id="sb_days_of_month" name="sb_days_of_month[]" multiple="multiple" style="width:200px;">
										<?php
                                        for($i=1;$i<=31;$i++)
                                        { ?>
	                                        <option value="<?php echo $i;?>" <?php if (in_array($i, $arr_sb_days_of_month)) {?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                        <?php
                                        } ?>	
                                        </select>&nbsp;*<br>
                                        You can choose more than one option by using the ctrl key.
                                    </td>
								</tr>
                                <tr id="tr_single_date" style="display:<?php echo $tr_single_date;?>">
									<td align="right" valign="top"><strong>Select Date</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                    	<input name="sb_single_date" id="sb_single_date" type="text" value="<?php echo $sb_single_date;?>" style="width:200px;"  />
                                        <script>$('#sb_single_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                    </td>
								</tr>
                                <tr id="tr_date_range" style="display:<?php echo $tr_date_range;?>">
									<td align="right" valign="top"><strong>Select Date Range</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                    	<input name="sb_start_date" id="sb_start_date" type="text" value="<?php echo $sb_start_date;?>" style="width:200px;"  /> - <input name="sb_end_date" id="sb_end_date" type="text" value="<?php echo $sb_end_date;?>" style="width:200px;"  />
                                        <script>$('#sb_start_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'});$('#sb_end_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Contents</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><textarea name="sb_content" id="sb_content" style="width:200px;"><?php echo $sb_content; ?></textarea></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Font Family - Contents</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="sb_content_font_family" id="sb_content_font_family" style="width:200px;">
											<option value="">Select Font Family</option>
		                                   	<?php echo $obj->getFontFamilyOptions($sb_content_font_family); ?>
                                        </select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Font Size - Contents</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="sb_content_font_size" id="sb_content_font_size" style="width:200px;">
											<option value="">Select Font Size</option>
		                                   	<?php echo $obj->getFontSizeOptions($sb_content_font_size); ?>
                                        </select>
                                   	</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Font Color - Contents</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <input type="text" class="color"  id="sb_content_font_color" name="sb_content_font_color" value="<?php echo $sb_content_font_color; ?>"/>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right" valign="top"><strong>Image</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
									<?php
									if($sb_content_image != '')
									{ ?>
										<img border="0" width="60" src="<?php echo SITE_URL.'/uploads/'.$sb_content_image;?>" />
									<?php
									}
									?>
									</td>
								</tr>
								<tr>
									<td align="right"></td>
									<td align="center"></td>
									<td align="left"><input name="sb_content_image" type="file" id="sb_content_image" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Show Credit</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<select name="sb_show_content_credit" id="sb_show_content_credit" style="width:200px;">
                                        	<option value="1" <?php if($sb_show_content_credit == '1'){ ?> selected="selected" <?php }?>>Yes</option>
                                            <option value="0" <?php if($sb_show_content_credit == '0'){ ?> selected="selected" <?php }?>>No</option>
                                        </select>
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Credit Name</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="sb_content_credit_name" type="text" id="sb_content_credit_name" value="<?php echo $sb_content_credit_name; ?>" style="width:200px;" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Credit Link</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="sb_content_credit_link" type="text" id="sb_content_credit_link" value="<?php echo $sb_content_credit_link; ?>" style="width:200px;" ></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>
									<td align="right"><strong>Order</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="sb_order" id="sb_order" style="width:200px;">
											<?php
											for($i=1;$i<=50;$i++)
											{ 
												if($sb_order == $i)
												{
													$sel = ' selected ';
												}
												else
												{
													$sel = ''; 
												}
											?>
                                            <option value="<?php echo $i;?>" <?php echo $sel;?>><?php echo $i;?></option>
                                            <?php
											} ?>
                                        </select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right" valign="top"><strong>Status</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
										<select id="sb_status" name="sb_status" style="width:200px;">
											<option value="0" <?php if($sb_status == 0) { ?> selected="selected" <?php } ?>>Inactive</option>
											<option value="1" <?php if($sb_status == 1) { ?> selected="selected" <?php } ?>>Active</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td align="left" valign="top"><input type="Submit" name="btnSubmit" value="Submit" /></td>
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