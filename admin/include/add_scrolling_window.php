<?php
require_once('config/class.mysql.php');
require_once('classes/class.scrollingwindows.php');
require_once('classes/class.contents.php');  
$obj = new Scrolling_Windows();
$obj2 = new Contents();

$add_action_id = '151';

if(!$obj->isAdminLoggedIn())
{
	
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$add_action_id))
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}

$error = false;
$err_msg = "";
$arr_selected_page_id = array();
if(isset($_GET['page_id']))
{
	$arr_selected_page_id[] = $_GET['page_id'];
}
$PD_id= $_GET['PD_id'];
$DYL_id= $_GET['DYL_id'];
if(isset($_POST['btnSubmit']))
{
	//$page_id = strip_tags(trim($_POST['page_id']));
        foreach ($_POST['selected_page_id'] as $key => $value) 
        {
            array_push($arr_selected_page_id,$value);
        }
        $page_id = implode(',', $arr_selected_page_id);
        
	$sw_header = strip_tags(trim($_POST['sw_header']));
	$sw_header_font_family = strip_tags(trim($_POST['sw_header_font_family']));
	$sw_header_font_size = strip_tags(trim($_POST['sw_header_font_size']));
	$sw_show_header_credit = trim($_POST['sw_show_header_credit']);
	$specialHeaderError = false;
	if (strpos($_POST['sw_header_credit_link'], 'http://') === 0 || strpos($_POST['sw_header_credit_link'], 'https://') === 0) {
		$sw_header_credit_link = strip_tags(trim($_POST['sw_header_credit_link']));
	}else{
		$sw_header_credit_link = '';
		$specialHeaderError = true;
	}
	$sw_footer = strip_tags(trim($_POST['sw_footer']));
	$sw_footer_font_family = strip_tags(trim($_POST['sw_footer_font_family']));
	$sw_footer_font_size = strip_tags(trim($_POST['sw_footer_font_size']));
	$sw_show_footer_credit = trim($_POST['sw_show_footer_credit']);
	$specialFooterError = false;
	if (strpos($_POST['sw_footer_credit_link'], 'http://') === 0 || strpos($_POST['sw_footer_credit_link'], 'https://') === 0) {
		$sw_footer_credit_link = strip_tags(trim($_POST['sw_footer_credit_link']));
	}else{
		$sw_footer_credit_link = '';
		$specialFooterError = true;
	}

	
	$sw_order = trim($_POST['sw_order']);
	
	$sw_header_font_color = trim($_POST['sw_header_font_color']);
	$sw_footer_font_color = trim($_POST['sw_footer_font_color']);
        $sw_show_in_contents = trim($_POST['sw_show_in_contents']);
        
        $sw_header_bg_color = trim($_POST['sw_header_bg_color']);
	$sw_footer_bg_color = trim($_POST['sw_footer_bg_color']);
        $sw_box_border_color = trim($_POST['sw_box_border_color']);
        $sw_header_hide = trim($_POST['sw_header_hide']);
        $sw_footer_hide = trim($_POST['sw_footer_hide']);
		
	if(count($arr_selected_page_id) == 0)
	{
		$error = true;
		$err_msg .= 'Please select page';
	}
	
	if($sw_header == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter scrolling window header';
	}
	
	if($sw_header_font_family == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter font family for header';
	}
	
	if($sw_header_font_size == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter font size for header';
	}
	
	if($sw_show_header_credit == '1')
	{
		if($sw_header_credit_link == '')
		{
			$error = true;
			$err_msg .= '<br>Please enter header credit link';
		}

		if($specialHeaderError){
			$error = true;
				$err_msg .= '<br>Please enter valid header credit link';
		}
	}
	
	if($sw_footer == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter scrolling window footer';
	}
	
	if($sw_footer_font_family == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter font family for footer';
	}
	
	if($sw_footer_font_size == '')
	{
		$error = true;
		$err_msg .= '<br>Please enter font size for footer';
	}
	
	if($sw_show_footer_credit == '1')
	{
		
		if($sw_footer_credit_link == '')
		{
			$error = true;
			$err_msg .= '<br>Please enter footer credit link';
		}

		if($specialFooterError){
			$error = true;
				$err_msg .= '<br>Please enter valid footer credit link';
		}
	}

	

	
	
	if($obj->chkIfScrollingWindowOrderAlreadyExists($sw_order,$page_id,$sw_show_in_contents))
	{
		//$error = true;
		//$err_msg .= '<br>Window Order - '.$sw_order.' is already exist';
	}
	
	if(!$error)
	{
		if(isset($_FILES['sw_header_image']['tmp_name']) && $_FILES['sw_header_image']['tmp_name'] != '')
		{
			$sw_header_image = $_FILES['sw_header_image']['name'];
			$file4 = substr($sw_header_image, -4, 4);
			
			if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))
			{
				$error = true;
				$err_msg = 'Please Upload Only(jpg/gif/jpeg/png) files for header image';
			}	 
			elseif( $_FILES['sw_header_image']['type'] != 'image/jpeg' and $_FILES['sw_header_image']['type'] != 'image/pjpeg'  and $_FILES['sw_header_image']['type'] != 'image/gif' and $_FILES['sw_header_image']['type'] != 'image/png' )
			{
				$error = true;
				$err_msg = 'Please Upload Only(jpg/gif/jpeg/png) files for header image.';
			}
			
			
			if(!$error)
			{	
				
				$sw_header_image = time()."_".$sw_header_image;
				$temp_dir = SITE_PATH.'/uploads/';
				$temp_file = $temp_dir.$sw_header_image;
		
				if(!move_uploaded_file($_FILES['sw_header_image']['tmp_name'], $temp_file)) 
				{
					if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
					$error = true;
					$err_msg = 'Couldn\'t Upload header image';
					$sw_header_image = '';
				}
			}
		}  
		else
		{
			$sw_header_image = '';
		}
		
		if(!$error)
		{
			if(isset($_FILES['sw_footer_image']['tmp_name']) && $_FILES['sw_footer_image']['tmp_name'] != '')
			{
				$sw_footer_image = $_FILES['sw_footer_image']['name'];
				$file4 = substr($sw_footer_image, -4, 4);
				
				if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))
				{
					$error = true;
					$err_msg = 'Please Upload Only(jpg/gif/jpeg/png) files for footer image';
				}	 
				elseif( $_FILES['sw_footer_image']['type'] != 'image/jpeg' and $_FILES['sw_footer_image']['type'] != 'image/pjpeg'  and $_FILES['sw_footer_image']['type'] != 'image/gif' and $_FILES['sw_footer_image']['type'] != 'image/png' )
				{
					$error = true;
					$err_msg = 'Please Upload Only(jpg/gif/jpeg/png) files for footer image.';
				}
				
				if(!$error)
				{	
					$sw_footer_image = time()."_".$sw_footer_image;
					$temp_dir = SITE_PATH.'/uploads/';
					$temp_file = $temp_dir.$sw_footer_image;
			
					if(!move_uploaded_file($_FILES['sw_footer_image']['tmp_name'], $temp_file)) 
					{
						if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
						$error = true;
						$err_msg = 'Couldn\'t Upload footer image';
						$sw_footer_image = '';
					}
				}
			}  
			else
			{
				$sw_footer_image = '';
			}
			
			if(!$error)
			{	
				//update by  20-06-20 & update 06-07-20
				if($obj->addScrollingWindow($page_id,$sw_header,$sw_header_image,$sw_show_header_credit,$sw_header_credit_link,$sw_footer,$sw_footer_image,$sw_show_footer_credit,$sw_footer_credit_link,$sw_header_font_family,$sw_header_font_size,$sw_footer_font_family,$sw_footer_font_size,$sw_order,$sw_header_font_color,$sw_footer_font_color,$sw_show_in_contents,$sw_header_bg_color,$sw_footer_bg_color,$sw_box_border_color,$sw_header_hide,$sw_footer_hide,$PD_id,$DYL_id))
				{
					$msg = "Record Added Successfully!";
					header('location: index.php?mode=scrolling_windows&msg='.urlencode($msg));
				}
				else
				{
					$error = true;
					$err_msg = "Currently there is some problem.Please try again later.";
				}
			}	
		}	
	}
}
else
{
	$page_id = '';
	$sw_header = '';
	$sw_header_font_family = '';
	$sw_header_font_size = '';
	$sw_show_header_credit = '';
	$sw_header_credit_link = '';
	$sw_footer = '';
	$sw_footer_font_family = '';
	$sw_footer_font_size = '';
	$sw_show_footer_credit = '';
	$sw_footer_credit_link = '';
	$sw_header_image = '';
	$sw_footer_image = '';
	$sw_order = '1';
	
	$sw_header_font_color = '000000';
	$sw_footer_font_color = '000000';
        $sw_show_in_contents = '0';
        $sw_header_bg_color = '000000';
	$sw_footer_bg_color = '000000';
        $sw_box_border_color = '000000';
        $sw_header_hide = '0';
        $sw_footer_hide = '0';
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Scrolling Window</td>
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
							<form action="#" method="post" name="frmadd_add_slider" id="frmadd_add_slider" enctype="multipart/form-data" >
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td width="30%" align="right" valign="top"><strong>Page Name</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="65%" align="left" valign="top">
                                                                            <?php
                                                                            /*
                                                                            <select id="page_id" name="page_id" style="width:200px;">
                                                                                <option value="">Select Page</option>
                                                                                <?php echo $obj->getScrollingWindowsPagesOptions($page_id); ?>
                                                                            </select>
                                                                             * 
                                                                             */
                                                                            ?>
                                                                            <?php echo $obj2->getPageDropdownChkeckbox($arr_selected_page_id,'1','200','100');?>
                                                                            
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Show On</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                                                        <select id="sw_show_in_contents" name="sw_show_in_contents" style="width:200px;">
                                                                            <option value="0" <?php if($sw_show_in_contents == '0'){?> selected <?php } ?>>Side Bar</option>
                                                                            <option value="1" <?php if($sw_show_in_contents == '1'){?> selected <?php } ?>>Main Content</option>
                                                                        </select>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right"><strong>Box Border Color</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                            <input type="text" class="color"  id="sw_box_border_color" name="sw_box_border_color" value="<?php echo $sw_box_border_color; ?>"/>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                 <tr>
									<td align="right"><strong>Font Color - Header</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                            <input type="text" class="color"  id="sw_header_font_color" name="sw_header_font_color" value="<?php echo $sw_header_font_color; ?>"/>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right"><strong>Background Color - Header</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                            <input type="text" class="color"  id="sw_header_bg_color" name="sw_header_bg_color" value="<?php echo $sw_header_bg_color; ?>"/>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right"><strong>Font Color - Footer/Label</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                            <input type="text" class="color"  id="sw_footer_font_color" name="sw_footer_font_color" value="<?php echo $sw_footer_font_color; ?>"/>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right"><strong>Background Color - Footer/Body</strong></td>
									<td align="center"><strong>:</strong></td>
									<td align="left">
                                                                            <input type="text" class="color"  id="sw_footer_bg_color" name="sw_footer_bg_color" value="<?php echo $sw_footer_bg_color; ?>"/>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Scrolling Window Header</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top"><input name="sw_header" type="text" id="sw_header" value="<?php echo $sw_header; ?>" style="width:200px;"><br /><p style="color:#990000; font-size:9px;">Maximum 20 characters</p></td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Font Family - Header</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                                                            <select name="sw_header_font_family" id="sw_header_font_family" style="width:200px;">
                                                                                <option value="">Select Font Family</option>
                                                                                <?php echo $obj->getFontFamilyOptions($sw_header_font_family); ?>
                                                                            </select>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Font Size - Header</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                                                            <select name="sw_header_font_size" id="sw_header_font_size" style="width:200px;">
                                                                                <option value="">Select Font Size</option>
                                                                                <?php echo $obj->getFontSizeOptions($sw_header_font_size); ?>
                                                                            </select>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                               
                                                                
                                                                <tr>
									<td align="right" valign="top"><strong>Scrolling Window Header Image</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top"><input type="file" name="sw_header_image" id="sw_header_image" /><br /><p style="color:#990000; font-size:9px;">Please upload (jpg/gif/png) files with resolution 50px X 50px</p></td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Hide Header</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                                                            <select name="sw_header_hide" id="sw_header_hide" style="width:200px;">
                                                                                <option value="1" <?php if($sw_header_hide == '1'){ ?> selected="selected" <?php }?>>Yes</option>
                                                                                <option value="0" <?php if($sw_header_hide == '0'){ ?> selected="selected" <?php }?>>No</option>
                                                                            </select>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Show Header Credit</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                                                            <select name="sw_show_header_credit" id="sw_show_header_credit" style="width:200px;">
                                                                                    <option value="1" <?php if($sw_show_header_credit == '1'){ ?> selected="selected" <?php }?>>Yes</option>
                                                                                <option value="0" <?php if($sw_show_header_credit == '0'){ ?> selected="selected" <?php }?>>No</option>
                                                                            </select>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Header Credit Link</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top"><input name="sw_header_credit_link" type="url" id="sw_header_credit_link" value="<?php echo $sw_header_credit_link; ?>" style="width:200px;" ><br /><p style="color:#990000; font-size:9px;">Please use (http://www.example.com) format for credit link </p></td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Scrolling Window Footer</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top"><input name="sw_footer" type="text" id="sw_footer" value="<?php echo $sw_footer; ?>" style="width:200px;"><br /><p style="color:#990000; font-size:9px;">Maximum 20 characters</p></td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Font Family - Footer</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                                                            <select name="sw_footer_font_family" id="sw_footer_font_family" style="width:200px;">
                                                                                    <option value="">Select Font Family</option>
                                                                                    <?php echo $obj->getFontFamilyOptions($sw_footer_font_family); ?>
                                                                            </select>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                
                                                                <tr>
									<td align="right" valign="top"><strong>Font Size - Footer</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                                                            <select name="sw_footer_font_size" id="sw_footer_font_size" style="width:200px;">
                                                                                    <option value="">Select Font Size</option>
                                                                                    <?php echo $obj->getFontSizeOptions($sw_footer_font_size); ?>
                                                                            </select>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                
                                                                <tr>
									<td align="right" valign="top"><strong>Scrolling Window Footer Image</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top"><input type="file" name="sw_footer_image" id="sw_footer_image" /><br /><p style="color:#990000; font-size:9px;">Please upload (jpg/gif/png) files with resolution 50px X 50px</p></td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Hide Footer</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                                                            <select name="sw_footer_hide" id="sw_footer_hide" style="width:200px;">
                                                                                    <option value="1" <?php if($sw_footer_hide == '1'){ ?> selected="selected" <?php }?>>Yes</option>
                                                                                <option value="0" <?php if($sw_footer_hide == '0'){ ?> selected="selected" <?php }?>>No</option>
                                                                            </select>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Show Footer Credit</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                                                            <select name="sw_show_footer_credit" id="sw_show_footer_credit" style="width:200px;">
                                                                                    <option value="1" <?php if($sw_show_footer_credit == '1'){ ?> selected="selected" <?php }?>>Yes</option>
                                                                                <option value="0" <?php if($sw_show_footer_credit == '0'){ ?> selected="selected" <?php }?>>No</option>
                                                                            </select>
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Footer Credit Link</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top"><input name="sw_footer_credit_link" type="url" id="sw_footer_credit_link" value="<?php echo $sw_footer_credit_link; ?>" style="width:200px;" ><br /><p style="color:#990000; font-size:9px;">Please use (http://www.example.com) format for credit link </p></td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td align="right" valign="top"><strong>Window Order</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                                                            <select name="sw_order" id="sw_order" style="width:200px;">
											<?php
											for($i=1;$i<=6;$i++)
											{ 
												if($sw_order == $i)
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