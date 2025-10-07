<?php
require_once('config/class.mysql.php');
require_once('classes/class.mindjumble.php');
require_once('../init.php');
$obj = new Mindjumble();

$edit_action_id = '92';

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
	$pdf_id = $_POST['hdnmindjumble_pdf_id'];
	$pdf = $_POST['hdn_pdf'];
	$credit = strip_tags(trim($_POST['credit']));
	$credit_url = strip_tags(trim($_POST['credit_url'])); 
	$pdf_title = strip_tags(trim($_POST['pdf_title']));  
	$status = strip_tags(trim($_POST['status'])); 
	$title_id 	= strip_tags(trim($_POST['title_id']));
	$short_narration 	= strip_tags(trim($_POST['short_narration']));
	
	if(isset ($_POST['day']) && is_array ($_POST['day']))
	{
		$day = '' ;
		foreach($_POST['day'] as $val)
		{ 
			$day .= $val.',';
		}
		$day = substr($day,0,-1);
		 $arr_day = explode(",", $day);
	}
	else 
	{
		$day = '' ;
		 $arr_day = array();
	}
	
	if($day == "")
	{
		$error = true;
		$err_msg = "Please Select Day.";
	}

	if($title_id == "")
	{
		$error = true;
		$err_msg .= "<br>Please Select Title.";
	}
	
	if($short_narration == "")
	{
		$error = true;
		$err_msg .= "<br>Please Enter Short Narration.";
	}
			
	if($pdf_title == "")
	{
		$error = true;
		$err_msg .= "<br>Please enter PDF title.";
	}
	
	if(isset($_FILES['pdf']['tmp_name']) && $_FILES['pdf']['tmp_name'] != '')
	{
	
		$pdf = basename($_FILES['pdf']['name']);
		
		$type_of_uploaded_file =substr($pdf,strrpos($pdf, '.') + 1);
		$target_size = $_FILES['pdf']['size']/1024;
			
		$max_allowed_file_size = 1000; // size in KB
		$target_type = array("PDF", "pdf");
	
		if($target_size > $max_allowed_file_size )
		{
			$error = true;
			$err_msg .=  "\n Size of file should be less than $max_allowed_file_size kb";
		}
	
		$allowed_ext = false;
		for($i=0; $i<count($target_type); $i++)
		{
			if(strcasecmp($target_type[$i],$type_of_uploaded_file) == 0)
			{
				$allowed_ext = true;
			}
		  
		}
		
		if(!$allowed_ext)
		{
			$error = true;
			
			$err_msg .= "\n The uploaded file is not supported file type. ".
					   "<br>Only the following file types are supported: ".implode(',',$target_type);
		}
	
	    if(!$error)
		{
		    
			$target_path = SITE_PATH."/uploads/";
			$pdf = time().'_'.$pdf;
			$target_path = $target_path .$pdf;
		
		  	
			if(move_uploaded_file($_FILES['pdf']['tmp_name'], $target_path))
			{		    
			
			} 
			else
			{
				$error = true;
				$err_msg .= '<br>PDF file not uploaded. Please Try again Later';
			}
		}
	}	
	else
	{
		$pdf = $_POST['hdn_pdf'];
		
	}
	
	
		if(!$error)
		{
			if($obj->Update_MindJumblePDF($pdf,$credit,$credit_url,$pdf_title,$status,$day,$title_id,$short_narration,$pdf_id))
				{
					$msg = "Record Edited Successfully!";
					header('location: index.php?mode=mindjumble_pdf&msg='.urlencode($msg));
				}
			else
				{
					$error = true;
					$err_msg = "Currently there is some problem.Please try again later.";
				}
		}	
}

	elseif(isset($_GET['uid']))
	{
		$mindjumble_pdf_id = $_GET['uid'];

		list($pdf,$credit,$credit_url,$pdf_title,$day,$status,$title_id,$short_narration) = $obj->getMindJumblePDFDetails($mindjumble_pdf_id);
	    
		 $arr_day = explode(",", $day);
        
	}
else
	{
	  header('location: index.php?mode=mindjumble_pdf');
	}	

?>
<script src="js/AC_ActiveX.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
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
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit PDF</td>
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
							<form action="#" method="post" name="frmedit_mindjumble" id="frmedit_mindjumble" enctype="multipart/form-data" >
							<input type="hidden" name="hdnmindjumble_pdf_id" value="<?php echo $mindjumble_pdf_id;?>" />
                            <input type="hidden" name="hdn_pdf" value="<?php echo $pdf;?>" />             
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								
                                <tr>
									<td width="20%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><select name="status" id="status">
                                                                    <option value="1" <?php  if($status == 1) {?> selected="selected" <?php } ?> >Active</option>
                                                                    <option value="0" <?php  if($status == 0) {?> selected="selected" <?php } ?> >Inacive</option>
                                                                    </select>
                                                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>
									<td width="20%" align="right" valign="top"><strong>Select Day</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left"><select id="day" name="day[]" multiple="multiple">
                                    								<?php
                                                                        for($i=1;$i<=31;$i++)
                                                                        { ?>
                                                                            <option value="<?php echo $i;?>" <?php if (in_array($i, $arr_day)) {?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                                                        <?php
                                                                        } ?>
                                                                    </select><br>
                                                                    You can choose more than one option by using the ctrl key.</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>
									<td width="20%" align="right"><strong>Select Box Title</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><select name="title_id" id="title_id" onchange="GetShortNarration('<?php echo $short_narration;?>')">
																	<option value="">Select Option</option>
																	<?php  echo $obj->getMindJumbleSelectTitle($title_id); ?>
																	</select>
                                    </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right" ><strong>Short Narration</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left" id="narration">
                                    					<select name="short_narration" id="short_narration">
                                                        <option value="">Select</option>
                                                      	 <?php echo $obj->getShortNarrationID($title_id,$short_narration); ?>
                                                        </select>
                                     </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right"><strong>Credit</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="credit" name="credit" value="<?php echo $credit; ?>"/>
                                     </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right"><strong>Credit URL</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="credit_url" name="credit_url" value="<?php echo $credit_url; ?>"/>
                                     </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right"><strong>PDF Title</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="pdf_title" name="pdf_title" value="<?php echo $pdf_title; ?>"/>
                                     </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                
								 <tr>
									<td align="right"></td>
									<td align="center"></td>
									<td align="left"><a href="<?php echo SITE_URL."/uploads/".$pdf ?>" target="_blank"><?php echo $pdf; ?></a>
								    </td>
								</tr>
                                <tr>
                                   <td align="right"><strong>Upload PDF</strong>
                                    <td align="center"><strong>:</strong></td>
                                    <td><input name="pdf" type="file" id="pdf" />
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
