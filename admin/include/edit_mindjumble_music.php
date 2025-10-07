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
	$music_id = $_POST['hdnmusic_id'];
	$music = strip_tags(trim($_POST['music']));
	$status = strip_tags(trim($_POST['status']));
	$credit = strip_tags(trim($_POST['credit']));
	$credit_url = strip_tags(trim($_POST['credit_url'])); 
	
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
		$err_msg = "Please enter credit.";
	}
		
	
	if(isset($_FILES['music']['tmp_name']) && $_FILES['music']['tmp_name'] != '')
	{
	
		$music = basename($_FILES['music']['name']);
		
		$type_of_uploaded_file = strtolower(substr($music,strrpos($music, '.') + 1));
		$target_size = $_FILES['music']['size']/1024;
		$max_allowed_file_size = 10000; // size in KB
		$target_type = array("mp3","wav","mid","MP3","WAV","MID");
	     
		 if($type_of_uploaded_file =='mp3')
			{ $type = 'audio/mpeg';}
		elseif($type_of_uploaded_file =='wav')
			{ $type = 'audio/wav';}
		elseif($type_of_uploaded_file =='mid')
			{ $type = 'audio/mid';}
		 
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
			$music = time().'_'.$music;
			$target_path = $target_path .$music;
		
		  	
			if(move_uploaded_file($_FILES['music']['tmp_name'], $target_path))
			{		    
			
			} 
			else
			{
				$error = true;
				$err_msg .= '<br>Music file not uploaded. Please Try again Later';
			}
		}
	}	
	else
	{
		$music = $_POST['hndmusic'];
		$type_of_uploaded_file = substr($music,strrpos($music, '.') + 1);
		 if($type_of_uploaded_file =='mp3')
			{ $type = 'audio/mpeg';}
		elseif($type_of_uploaded_file =='wav')
			{ $type = 'audio/wav';}
		elseif($type_of_uploaded_file =='mid')
			{ $type = 'audio/mid';}
		
	}
	
		if(!$error)
		{
			if($obj->Update_MindJumbleMusic($music,$day,$credit,$credit_url,$status,$music_id))
				{
					$msg = "Record Edited Successfully!";
					header('location: index.php?mode=mindjumble_bk_music&msg='.urlencode($msg));
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
		$bk_music_id = $_GET['uid'];
		
		list($music,$day,$credit,$credit_url,$status) = $obj->getmindjumbleMusicDetails($bk_music_id);
	    $music_type = strtolower(substr($music,strrpos($music, '.') + 1));
		
		if($music_type =='mp3')
			{ $type = 'audio/mpeg';}
		elseif($music_type =='wav')
			{ $type = 'audio/wav';}
		elseif($music_type =='mid')
			{ $type = 'audio/mid';}
			
		$arr_day = explode(",", $day);
	}
else
	{
		header('location: index.php?mode=mindjumble_bk_music');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Background Music </td>
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
							<form action="#" method="post" name="frmedit_sressbuster" id="frmedit_sressbuster" enctype="multipart/form-data" >
							<input type="hidden" name="hdnmusic_id" value="<?php echo $bk_music_id;?>" />
                            <input type="hidden" name="hndmusic" id="hndmusic" value="<?php echo $music;?>" />
                           
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
								
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><select name="status" id="status">
                                                                 <option value="1" <?php  if($status == 1) {?> selected="selected" <?php } ?> >Active</option>
                                                                 <option value="0" <?php  if($status == 0) {?> selected="selected" <?php } ?>>Inactive</option>
                                                                 </select></td>
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
									<td width="75%" align="left"><input type="text"  id="credit_url" name="credit_url" value="<?php echo $credit_url; ?>"/>&nbsp;(Please enter link like http://www.google.com)
                                     </td>
								</tr>
                               <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								 <tr>
									<td align="right"></td>
									<td align="center"></td>
									<td align="left"> 
                                  
                                    <embed src="<?php echo SITE_URL.'/uploads/'. $music;?>" autostart="true" loop="true" height="20" type="<?php echo $type; ?>"></embed>
								   
                                    </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
                                   <td align="right"><strong>Upload Music</strong>
                                    <td align="center"><strong>:</strong></td>
                                    <td><input name="music" type="file" id="music" />
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