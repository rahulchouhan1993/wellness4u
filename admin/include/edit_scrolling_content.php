<?php
require_once('config/class.mysql.php');
require_once('classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();

$edit_action_id = '156';

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

$sw_id = $_GET['id'];
if($sw_id == '')
{
	header("Location: index.php?mode=invalid");
	exit(0);
}

$sw_header = $obj->getScollingWindowHeaderTitle($sw_id);
$pg_title = $obj->getScollingWindowPageTitle($sw_id);

if($sw_header == '')
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}

$error = false;
$err_msg = "";

$tr_days_of_month = 'none';
$tr_days_of_week = 'none';
$tr_single_date = 'none';
$tr_date_range = 'none';

$tr_text_content = 'none';
$tr_image_content = 'none';
$tr_video_content = 'none';
$tr_flash_content = 'none';
$tr_rss_content = 'none';

$arr_sc_days_of_month = array();
$arr_sc_days_of_week = array();
if(isset($_POST['btnSubmit']))
{
	$sc_id = $_POST['hdnsc_id'];  
	$sc_listing_date_type = trim($_POST['sc_listing_date_type']);
		
	foreach ($_POST['sc_days_of_month'] as $key => $value) 
	{
		array_push($arr_sc_days_of_month,$value);
	}

	foreach ($_POST['sc_days_of_week'] as $key => $value) 
	{
		array_push($arr_sc_days_of_week,$value);
	}
	
	$sc_single_date = trim($_POST['sc_single_date']);
	$sc_start_date = trim($_POST['sc_start_date']);
	$sc_end_date = trim($_POST['sc_end_date']);
	$sc_title = strip_tags(trim($_POST['sc_title']));
	$sc_content_type = trim($_POST['sc_content_type']);
	$sc_content = trim($_POST['sc_content']);
	$sc_video = trim($_POST['sc_video']);
	$sc_show_credit = strip_tags(trim($_POST['sc_show_credit']));
	$sc_credit_name = strip_tags(trim($_POST['sc_credit_name']));
	$sc_credit_link = strip_tags(trim($_POST['sc_credit_link']));
	$sc_status = $_POST['sc_status'];
	$sc_title_font_family = trim($_POST['sc_title_font_family']);
	$sc_title_font_size = trim($_POST['sc_title_font_size']);
	$sc_content_font_family = trim($_POST['sc_content_font_family']);
	$sc_content_font_size = trim($_POST['sc_content_font_size']);
	$sc_order = trim($_POST['sc_order']);
	
	$sc_title_font_color = trim($_POST['sc_title_font_color']);
	$sc_content_font_color = trim($_POST['sc_content_font_color']);
	
	$rss_feed_item_id = trim($_POST['rss_feed_item_id']);
        
        $sc_title_hide = trim($_POST['sc_title_hide']);
        $sc_add_fav_hide = trim($_POST['sc_add_fav_hide']);
	
	if($sc_listing_date_type == '')
	{
		$error = true;
		$err_msg = 'Please select selection date type';
	}
	elseif($sc_listing_date_type == 'days_of_month')
	{
		$tr_days_of_month = '';
		$tr_single_date = 'none';
		$tr_days_of_week = 'none';
		$tr_date_range = 'none';
		
		if(count($arr_sc_days_of_month) < 1)
		{
			$error = true;
			$err_msg = 'Please select days of month';
			$sc_days_of_month = '';
		}
		else
		{
			$sc_days_of_month = implode(',',$arr_sc_days_of_month);
		}	
	}
	elseif($sc_listing_date_type == 'days_of_week')
	{
		$tr_days_of_month = '';
		$tr_single_date = 'none';
		$tr_date_range = 'none';
		
		if(count($arr_sc_days_of_week) < 1)
		{
			$error = true;
			$err_msg = 'Please select days of week';
			$sc_days_of_week = '';
		}
		else
		{
			$sc_days_of_week = implode(',',$arr_sc_days_of_week);
		}	
	}
	elseif($sc_listing_date_type == 'single_date')
	{
		$tr_days_of_month = 'none';
		$tr_single_date = '';
		$tr_date_range = 'none';
		$tr_days_of_week = 'none';
		if($sc_single_date == '')
		{
			$error = true;
			$err_msg = 'Please select single date';
		}	
	}
	elseif($sc_listing_date_type == 'date_range')
	{
		$tr_days_of_month = 'none';
		$tr_single_date = 'none';
		$tr_date_range = '';
		$tr_days_of_week = 'none';
		if($sc_start_date == '')
		{
			$error = true;
			$err_msg = 'Please select start date';
		}
		elseif($sc_end_date == '')
		{
			$error = true;
			$err_msg = 'Please select end date';
		}
		else
		{
			if(strtotime($sc_start_date) > strtotime($sc_end_date))
			{
				$error = true;
				$err_msg = 'Please select end date greater than start date';
			}
		}	
	}
	
	if($sc_title == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter title ';
	}
	
	if($sc_title_font_family == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter font family for title';
	}
	
	if($sc_title_font_size == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter font size for title';
	}
	
	if($sc_content_type == 'text')
	{
		$tr_text_content = '';
		$tr_image_content = 'none';
		$tr_video_content = 'none';
		$tr_flash_content = 'none';
		$tr_rss_content = 'none';
	}
	elseif($sc_content_type == 'image')
	{
		$tr_text_content = 'none';
		$tr_image_content = '';
		$tr_video_content = 'none';
		$tr_flash_content = 'none';
		$tr_rss_content = 'none';
	}
	elseif($sc_content_type == 'video')
	{
		$tr_text_content = 'none';
		$tr_image_content = 'none';
		$tr_video_content = '';
		$tr_flash_content = 'none';
		$tr_rss_content = 'none';
	}
	elseif($sc_content_type == 'flash')
	{
		$tr_text_content = 'none';
		$tr_image_content = 'none';
		$tr_video_content = 'none';
		$tr_flash_content = '';
		$tr_rss_content = 'none';
	}
	elseif($sc_content_type == 'rss')
	{
		$tr_text_content = 'none';
		$tr_image_content = 'none';
		$tr_video_content = 'none';
		$tr_flash_content = 'none';
		$tr_rss_content = '';
	}
	else
	{
		$tr_text_content = '';
		$tr_image_content = '';
		$tr_video_content = 'none';
		$tr_flash_content = 'none';
		$tr_rss_content = 'none';
	}
	
	
	if($sc_content_type == 'text' || $sc_content_type == 'text_and_image')
	{
		if($sc_content == '')
		{
			$error = true;
			$err_msg .= '<br>Please enter content ';
		}
		
		if($sc_content_font_family == '')
		{
			$error = true;
			$err_msg .= '<br>Please enter font family for contents';
		}
		
		if($sc_content_font_size == '')
		{
			$error = true;
			$err_msg .= '<br>Please enter font size for contents';
		}
	}	
	elseif($sc_content_type == 'video')
	{
		if($sc_video == '')
		{
			$error = true;
			$err_msg .= '<br>Please enter video url';
		}
	}	
	elseif($sc_content_type == 'rss')
	{
		if($rss_feed_item_id == '')
		{
			$error = true;
			$err_msg .= '<br>Please select rss feed';
		}
	}	
	
	if($obj->chkIfScrollingContentOrderAlreadyExists_Edit($sc_order,$sw_id,$sc_id))
	{
		$error = true;
		$err_msg .= '<br>Slider Order - '.$sc_order.' is already exist';
	}
	
	if($sc_content_type == 'image' || $sc_content_type == 'text_and_image')
	{
		if(isset($_FILES['sc_image']['tmp_name']) && $_FILES['sc_image']['tmp_name'] != '')
		{
			$sc_image = $_FILES['sc_image']['name'];
			$file4 = substr($sc_image, -4, 4);
			if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF' and ($file4 !='.png') and ($file4 != '.PNG')))
			{
				$error = true;
				$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) image';
			}	 
			elseif( $_FILES['sc_image']['type'] != 'image/jpeg' and $_FILES['sc_image']['type'] != 'image/pjpeg' and $_FILES['sc_image']['type'] != 'image/gif' and $_FILES['sc_image']['type'] != 'image/png' && $_FILES['sc_image']['type'] != 'image/x-png' )
			{
				$error = true;
				$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) image';
			}
			
			$sc_image = time()."_".$sc_image;
			$temp_dir = SITE_PATH.'/uploads/';
			$temp_file = $temp_dir.$sc_image;
			
			if(!move_uploaded_file($_FILES['sc_image']['tmp_name'], $temp_file)) 
			{
				if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
				$error = true;
				$err_msg .= '<br>Couldn\'t Upload image';
				$sc_image = strip_tags(trim($_POST['hdnsc_image']));
			}
			else
			{
				$obj->createThumbNailSingle(SITE_PATH."/uploads/".$sc_image,SITE_PATH."/uploads/".$sc_image,60);
			}	
		}
		else
		{
			$sc_image = strip_tags(trim($_POST['hdnsc_image']));
		}
	}
	else
	{
		$sc_image = strip_tags(trim($_POST['hdnsc_image']));
	}
	
	if($sc_content_type == 'flash' )
	{
		if(isset($_FILES['sc_flash']['tmp_name']) && $_FILES['sc_flash']['tmp_name'] != '')
		{
			$sc_flash = $_FILES['sc_flash']['name'];
			$file4 = substr($sc_flash, -4, 4);
			if(($file4 != '.swf')and($file4 != '.SWF'))
			{
				$error = true;
				$err_msg .= '<br>Please Upload Only(swf) files for flash ';
			}	 
			elseif( $_FILES['sc_flash']['type'] != 'application/x-shockwave-flash'  )
			{
				$error = true;
				$err_msg .= '<br>Please Upload Only(swf) files for flash';
			}
			
			$sc_flash = time()."_".$sc_flash;
			$temp_dir = SITE_PATH.'/uploads/';
			$temp_file = $temp_dir.$sc_flash;
			
			if(!move_uploaded_file($_FILES['sc_flash']['tmp_name'], $temp_file)) 
			{
				if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
				$error = true;
				$err_msg .= '<br>Couldn\'t Upload flash';
				$sc_flash = '';
			}
		}
		else
		{
			$sc_flash = strip_tags(trim($_POST['hdnsc_flash']));
		}
	}
	else
	{
		$sc_flash = strip_tags(trim($_POST['hdnsc_flash']));
	}	

	if(!$error)
	{
		if($sc_listing_date_type == 'days_of_month')
		{
			$sc_single_date = '';
			$sc_start_date = '';
			$sc_end_date = '';
		}
		elseif($sc_listing_date_type == 'single_date')
		{
			$sc_days_of_month = '';
			$sc_start_date = '';
			$sc_end_date = '';
			
			//commneted by rahul
			//$sc_single_date = date('Y-m-d',strtotime($sc_single_date));
		}
		elseif($sc_listing_date_type == 'date_range')
		{
			$sc_days_of_month = '';
			$sc_single_date = '';
			
			//comented by rahul
			// $sc_start_date = date('Y-m-d',strtotime($sc_start_date));
			// $sc_end_date = date('Y-m-d',strtotime($sc_end_date));
		}
	
		//$sc_content = $obj->get_clean_br_string($sc_content);
		if($obj->updateScrollingContent($sc_id,$sc_title,$sc_content,$sc_image,$sc_credit_name,$sc_credit_link,$sc_status,$sc_listing_date_type,$sc_days_of_month,$sc_single_date,$sc_start_date,$sc_end_date,$sc_show_credit,$sc_title_font_family,$sc_title_font_size,$sc_content_font_family,$sc_content_font_size,$sc_order,$sc_content_type,$sc_video,$sc_flash,$sc_title_font_color,$sc_content_font_color,$rss_feed_item_id,$sc_title_hide,$sc_add_fav_hide,$sc_days_of_week))
		{
		 	$msg = "Record Updated Successfully!";
			header('location: index.php?mode=scrolling_contents&id='.$sw_id.'&msg='.urlencode($msg).'');
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
	$sc_id = $_GET['sc_id'];
	list($sc_title,$sc_content,$sc_image,$sc_credit_name,$sc_credit_link,$sc_status,$sc_listing_date_type,$sc_days_of_month,$sc_single_date,$sc_start_date,$sc_end_date,$sc_show_credit,$sc_title_font_family,$sc_title_font_size,$sc_content_font_family,$sc_content_font_size,$sc_order,$sc_content_type,$sc_video,$sc_flash,$sc_title_font_color,$sc_content_font_color,$rss_feed_item_id,$sc_title_hide,$sc_add_fav_hide,$sc_days_of_week) = $obj->getScrollingContentDetails($sc_id);
	
	if($sc_title_font_color == '')
	{
		$sc_title_font_color = '000000';
	}
	
	if($sc_content_font_color == '')
	{
		$sc_content_font_color = '000000';
	}	
	
	if($sc_content_type == 'text')
	{
		$tr_text_content = '';
		$tr_image_content = 'none';
		$tr_video_content = 'none';
		$tr_flash_content = 'none';
		$tr_rss_content = 'none';
	}
	elseif($sc_content_type == 'image')
	{
		$tr_text_content = 'none';
		$tr_image_content = '';
		$tr_video_content = 'none';
		$tr_flash_content = 'none';
		$tr_rss_content = 'none';
	}
	elseif($sc_content_type == 'video')
	{
		$tr_text_content = 'none';
		$tr_image_content = 'none';
		$tr_video_content = '';
		$tr_flash_content = 'none';
		$tr_rss_content = 'none';
	}
	elseif($sc_content_type == 'flash')
	{
		$tr_text_content = 'none';
		$tr_image_content = 'none';
		$tr_video_content = 'none';
		$tr_flash_content = '';
		$tr_rss_content = 'none';
	}
	elseif($sc_content_type == 'rss')
	{
		$tr_text_content = 'none';
		$tr_image_content = 'none';
		$tr_video_content = 'none';
		$tr_flash_content = 'none';
		$tr_rss_content = '';
	}
	else
	{
		$tr_text_content = '';
		$tr_image_content = '';
		$tr_video_content = 'none';
		$tr_flash_content = 'none';
		$tr_rss_content = 'none';
	}
	
	if($sc_listing_date_type == 'days_of_month')
	{
		$tr_days_of_month = '';
		$tr_single_date = 'none';
		$tr_date_range = 'none';
		$tr_days_of_week = 'none';
		$sc_single_date = '';
		$sc_start_date = '';
		$sc_end_date = '';
		
		$pos = strpos($sc_days_of_month, ',');
		if ($pos !== false) 
		{
			$arr_sc_days_of_month = explode(',',$sc_days_of_month);
		}
		else
		{
			array_push($arr_sc_days_of_month , $sc_days_of_month);
		}
	}
	elseif($sc_listing_date_type == 'days_of_week')
	{
		$tr_days_of_week = '';
		$tr_single_date = 'none';
		$tr_date_range = 'none';
		$tr_days_of_month = 'none';
		$sc_single_date = '';
		$sc_start_date = '';
		$sc_end_date = '';
		
		$pos = strpos($sc_days_of_week, ',');
		if ($pos !== false) 
		{
			$arr_sc_days_of_week = explode(',',$sc_days_of_week);
		}
		else
		{
			array_push($arr_sc_days_of_week , $sc_days_of_week);
		}
	}
	elseif($sc_listing_date_type == 'single_date')
	{
		$tr_days_of_month = 'none';
		$tr_single_date = '';
		$tr_date_range = 'none';
		$tr_days_of_week = 'none';
		$sc_days_of_month = '';
		$sc_start_date = '';
		$sc_end_date = '';
		//commented by rahul
		//$sc_single_date = date('d-m-Y',strtotime($sc_single_date));
	}
	elseif($sc_listing_date_type == 'date_range')
	{
		$tr_days_of_month = 'none';
		$tr_single_date = 'none';
		$tr_date_range = '';
		$tr_days_of_week = 'none';
		$sc_days_of_month = '';
		$sc_single_date = '';
		
		//commnted by rahul
		//$sc_start_date = date('d-m-Y',strtotime($sc_start_date));
		//$sc_end_date = date('d-m-Y',strtotime($sc_end_date));
	}
	
	if($sc_title == '')
	{
		header('location: index.php?mode=invalid');	
		exit(0);
	}	
}	
else
{
	header('location: index.php?mode=invalid');
	exit(0);
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Scrolling Content - <?php echo $sw_header;?> , Page - <?php echo $pg_title;?></td>
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
							<input type="hidden" name="hdnsc_id" id="hdnsc_id" value="<?php echo $sc_id;?>" />
							<input type="hidden" name="hdnsc_image" id="hdnsc_image" value="<?php echo $sc_image;?>" />
                            <input type="hidden" name="hdnsc_flash" id="hdnsc_flash" value="<?php echo $sc_flash;?>" />
                            <input type="hidden" name="hdnsw_id" id="hdnsw_id" value="<?php echo $sw_id;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="30%" align="right"><strong>Date Selection Type</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="65%" align="left">
                                    	<select name="sc_listing_date_type" id="sc_listing_date_type" onchange="toggleDateSelectionType('sc_listing_date_type')" style="width:200px;">
                                        	<option value="">Select Option</option>
                                            <option value="days_of_month" <?php if($sc_listing_date_type == 'days_of_month') { ?> selected="selected" <?php } ?>>Days of Month</option>
                                            <option value="single_date" <?php if($sc_listing_date_type == 'single_date') { ?> selected="selected" <?php } ?>>Single Date</option>
                                            <option value="date_range" <?php if($sc_listing_date_type == 'date_range') { ?> selected="selected" <?php } ?>>Date Range</option>
											<option value="days_of_week" <?php if($sc_listing_date_type == 'days_of_week') { ?> selected="selected" <?php } ?>>Days of Week</option>
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
                                    	<select id="sc_days_of_month" name="sc_days_of_month[]" multiple="multiple" style="width:200px;">
										<?php
                                        for($i=1;$i<=31;$i++)
                                        { ?>
	                                        <option value="<?php echo $i;?>" <?php if (in_array($i, $arr_sc_days_of_month)) {?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                        <?php
                                        } ?>	
                                        </select>&nbsp;*<br>
                                        You can choose more than one option by using the ctrl key.
                                    </td>
								</tr>
								<tr id="tr_days_of_week" style="display:<?php echo $tr_days_of_week;?>">
									<td align="right" valign="top"><strong>Select days of week</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                    	<select id="sc_days_of_week" name="sc_days_of_week[]" multiple="multiple" style="width:200px;">
										<?php
                                        for($i=1;$i<=7;$i++)
                                        { ?>
	                                        <option value="<?php echo $i;?>" <?php if (in_array($i, $arr_sc_days_of_week)) {?> selected="selected" <?php } ?>><?php echo $i;?></option>
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
                                    	<input name="sc_single_date" id="sc_single_date" type="date" value="<?php echo $sc_single_date;?>" style="width:200px;"  />
                                        <script>$('#sc_single_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                    </td>
								</tr>
                                <tr id="tr_date_range" style="display:<?php echo $tr_date_range;?>">
									<td align="right" valign="top"><strong>Select Date Range</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left">
                                    	<input name="sc_start_date" id="sc_start_date" type="date" value="<?php echo $sc_start_date;?>" style="width:200px;"  /> - <input name="sc_end_date" id="sc_end_date" type="date" value="<?php echo $sc_end_date;?>" style="width:200px;"  />
                                        <script>$('#sc_start_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'});$('#sc_end_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Title</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="sc_title" type="text" id="sc_title" value="<?php echo $sc_title; ?>" style="width:200px;"></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Font Family - Title/Vendor</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="sc_title_font_family" id="sc_title_font_family" style="width:200px;">
											<option value="">Select Font Family</option>
		                                   	<?php echo $obj->getFontFamilyOptions($sc_title_font_family); ?>
                                        </select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Font Size - Title/Vendor</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="sc_title_font_size" id="sc_title_font_size" style="width:200px;">
											<option value="">Select Font Size</option>
		                                   	<?php echo $obj->getFontSizeOptions($sc_title_font_size); ?>
                                        </select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Font Color - Title/Vendor</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <input type="text" class="color"  id="sc_title_font_color" name="sc_title_font_color" value="<?php echo $sc_title_font_color; ?>"/>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Content Type</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<select name="sc_content_type" id="sc_content_type" onchange="toggleContentType()" style="width:200px;">
                                        	<option value="text_and_image" <?php if($sc_content_type == 'text_and_image') { ?> selected="selected" <?php } ?>>Text + Image</option>
                                            <option value="text" <?php if($sc_content_type == 'text') { ?> selected="selected" <?php } ?>>Text</option>
                                            <option value="image" <?php if($sc_content_type == 'image') { ?> selected="selected" <?php } ?>>Image</option>
                                            <option value="video" <?php if($sc_content_type == 'video') { ?> selected="selected" <?php } ?>>Video</option>
                                            <option value="flash" <?php if($sc_content_type == 'flash') { ?> selected="selected" <?php } ?>>Flash</option>
                                            <option value="rss" <?php if($sc_content_type == 'rss') { ?> selected="selected" <?php } ?>>Rss Feed</option>
                                        </select>
                                   	</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr class="tr_text_content" style="display:<?php echo $tr_text_content;?>">
									<td align="right"><strong>Contents</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><textarea name="sc_content" id="sc_content" style="width:200px;"><?php echo $sc_content; ?></textarea></td>
								</tr>
								<tr class="tr_text_content" style="display:<?php echo $tr_text_content;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="tr_text_content" style="display:<?php echo $tr_text_content;?>">
									<td align="right"><strong>Font Family - Contents/Content Box</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="sc_content_font_family" id="sc_content_font_family" style="width:200px;">
											<option value="">Select Font Family</option>
		                                   	<?php echo $obj->getFontFamilyOptions($sc_content_font_family); ?>
                                        </select>
                                   	</td>
								</tr>
								<tr class="tr_text_content" style="display:<?php echo $tr_text_content;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="tr_text_content" style="display:<?php echo $tr_text_content;?>">
									<td align="right"><strong>Font Size - Contents/Content Box</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="sc_content_font_size" id="sc_content_font_size" style="width:200px;">
											<option value="">Select Font Size</option>
		                                   	<?php echo $obj->getFontSizeOptions($sc_content_font_size); ?>
                                        </select>
                                   	</td>
								</tr>
								<tr class="tr_text_content" style="display:<?php echo $tr_text_content;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="tr_text_content" style="display:<?php echo $tr_text_content;?>">
									<td align="right"><strong>Font Color - Contents/Content Box</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <input type="text" class="color"  id="sc_content_font_color" name="sc_content_font_color" value="<?php echo $sc_content_font_color; ?>"/>
                                   	</td>
								</tr>
								
								<tr class="tr_text_content" style="display:<?php echo $tr_text_content;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr class="tr_image_content" style="display:<?php echo $tr_image_content;?>">
									<td align="right" valign="top"><strong>Image</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
									<?php
									if($sc_image != '')
									{ ?>
										<img border="0" width="60" src="<?php echo SITE_URL.'/uploads/'.$sc_image;?>" />
									<?php
									}
									?>
									</td>
								</tr>
								<tr class="tr_image_content" style="display:<?php echo $tr_image_content;?>">
									<td align="right"></td>
									<td align="center"></td>
									<td align="left"><input name="sc_image" type="file" id="sc_image" ></td>
								</tr>
								<tr class="tr_image_content" style="display:<?php echo $tr_image_content;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="tr_video_content" style="display:<?php echo $tr_video_content;?>">
									<td align="right"><strong>Video</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><iframe width="100" height="100" src="<?php echo $obj->getBannerString($sc_video); ?>" frameborder="0" allowfullscreen></iframe></td>
								</tr>
                                <tr class="tr_video_content" style="display:<?php echo $tr_video_content;?>">
									<td align="right"></td>
									<td align="center"></td>
									<td align="left"><input name="sc_video" type="text" id="sc_video" value="<?php echo $sc_video;?>" style="width:200px;" ></td>
								</tr>
								<tr class="tr_video_content" style="display:<?php echo $tr_video_content;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="tr_flash_content" style="display:<?php echo $tr_flash_content;?>">
									<td align="right"><strong>Flash</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="100" HEIGHT="100" id="myMovieName">
											<PARAM NAME=movie VALUE="<?php echo SITE_URL.'/uploads/'. $sc_flash;?>">
											<PARAM NAME=quality VALUE=high>
											<param name="wmode" value="transparent">
											<EMBED src="<?php echo SITE_URL.'/uploads/'. $sc_flash; ?>" quality=high WIDTH="100" HEIGHT="100" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
										</OBJECT>
                                    </td>
								</tr>
                                <tr class="tr_flash_content" style="display:<?php echo $tr_flash_content;?>">
									<td align="right"></td>
									<td align="center"></td>
									<td align="left"><input name="sc_flash" type="file" id="sc_flash" ></td>
								</tr>
								<tr class="tr_flash_content" style="display:<?php echo $tr_flash_content;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr class="tr_rss_content" style="display:<?php echo $tr_rss_content;?>">
									<td align="right"><strong>Rss Feeds</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="rss_feed_item_id" id="rss_feed_item_id" style="width:400px;">
											<option value="">Select Rss Feed</option>
		                                   	<?php echo $obj->getRssFeedOptions($rss_feed_item_id); ?>
                                        </select>
                                   	</td>
								</tr>
								<tr class="tr_rss_content" style="display:<?php echo $tr_rss_content;?>">
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                
                                <tr>
									<td align="right"><strong>Show Credit</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<select name="sc_show_credit" id="sc_show_credit" style="width:200px;">
                                        	<option value="1" <?php if($sc_show_credit == '1'){ ?> selected="selected" <?php }?>>Yes</option>
                                            <option value="0" <?php if($sc_show_credit == '0'){ ?> selected="selected" <?php }?>>No</option>
                                        </select>
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><strong>Credit Name</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="sc_credit_name" type="text" id="sc_credit_name" value="<?php echo $sc_credit_name; ?>" style="width:200px;"></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Credit Link</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left"><input name="sc_credit_link" type="text" id="sc_credit_link" value="<?php echo $sc_credit_link; ?>" style="width:200px;"></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Slider Order</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                        <select name="sc_order" id="sc_order" style="width:200px;">
											<?php
											for($i=1;$i<=50;$i++)
											{ 
												if($sc_order == $i)
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
									<td align="right"><strong>Hide Title</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<select name="sc_title_hide" id="sc_title_hide" style="width:200px;">
                                        	<option value="1" <?php if($sc_title_hide == '1'){ ?> selected="selected" <?php }?>>Yes</option>
                                            <option value="0" <?php if($sc_title_hide == '0'){ ?> selected="selected" <?php }?>>No</option>
                                        </select>
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                
                                                                <tr>
									<td align="right"><strong>Hide Add to Fav</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                    	<select name="sc_add_fav_hide" id="sc_add_fav_hide" style="width:200px;">
                                        	<option value="1" <?php if($sc_add_fav_hide == '1'){ ?> selected="selected" <?php }?>>Yes</option>
                                            <option value="0" <?php if($sc_add_fav_hide == '0'){ ?> selected="selected" <?php }?>>No</option>
                                        </select>
                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td align="right"><strong>Status</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
										<select id="sc_status" name="sc_status" style="width:200px;">
											<option value="0" <?php if($sc_status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
											<option value="1" <?php if($sc_status == '1') { ?> selected="selected" <?php } ?>>Active</option>
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