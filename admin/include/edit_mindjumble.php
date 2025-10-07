<?php
require_once('config/class.mysql.php');
require_once('classes/class.mindjumble.php');
require_once('../init.php');
$obj = new Mindjumble();

$edit_action_id = '92';

//add by ample 19-11-19
require_once('classes/class.scrollingwindows.php');
$obj1 = new Scrolling_Windows();
//add by ample 19-11-19
require_once('classes/class.solutions.php');
$obj2 = new Solutions();
//add by ample 19-11-19
require_once('classes/class.contents.php'); 
$obj3 = new Contents();

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
$display_trtext = '';
$display_trfile = 'none'; 
$tr_rss_content = 'none';


//add by ample 03-02-20
$arr_selected_page_id = array();

if(isset($_POST['btnSubmit']))
{
	$banner_id = $_POST['hdnbanner_id'];
	$status = strip_tags(trim($_POST['status']));
	$box_title = strip_tags(trim($_POST['box_title']));
	$box_desc = strip_tags(trim($_POST['box_desc']));
	$banner_type = $_POST['banner_type'];
	$credit_line = strip_tags(trim($_POST['credit_line']));
	$credit_line_url = strip_tags(trim($_POST['credit_line_url']));
	$sound_clip_id = strip_tags(trim($_POST['sound_clip_id']));
	// $title_id = strip_tags(trim($_POST['title_id']));
	$short_narration = strip_tags(trim($_POST['short_narration'])); 


	//added by ample 19-11-19
	$tags = $_POST['tags'];
	$str_tags=implode(',',$tags);

	//add by ample 03-02-20
	 foreach ($_POST['selected_page_id'] as $key => $value) 
        {
            array_push($arr_selected_page_id,$value);
        }
        $page_id = implode(',', $arr_selected_page_id);

	$ref_code=strip_tags(trim($_POST['ref_code'])); 
	$group_code = $_POST['group_code'];
	$take_key_title=isset($_POST['take_key_title'])?1:0;
    $take_key_narration=isset($_POST['take_key_narration'])?1:0;
    $take_key_notes =isset($_POST['take_key_notes'])?1:0;
    $order = $_POST['order'];

	$is_featured=$_POST['is_featured']; //27-10-20	

	//comment by ample 19-11-19
	// if(isset ($_POST['day']) && is_array ($_POST['day']))
	// {
	// 	$day = '' ;
	// 	foreach($_POST['day'] as $val)
	// 	{ 
	// 		$day .= $val.',';
	// 	}
	// 	$day = substr($day,0,-1);
	// 	 $arr_day = explode(",", $day);
	// }
	// else 
	// {
	// 	$day = '' ;
	// 	$arr_day = array();
	// }
	
	// if($day == "")
	// {
	// 	$error = true;
	// 	$err_msg = "Please Select Day";
	// }
	
	// if($title_id == "")
	// {
	// 	$error = true;
	// 	$err_msg .= "<br>Please Select Title.";
	// }

    // 03-02-20
	// if(count($arr_selected_page_id) == 0)
	// {
	// 	$error = true;
	// 	$err_msg .= 'Please select page';
	// }
	
	if($short_narration == "")
	{
		$error = true;
		$err_msg .= "<br>Please Enter Short Narration.";
	}
	
	if($box_title == "")
	{
		$error = true;
		$err_msg .= "<br>Please Enter Box Title.";
	}
	

	//update by ample 15-05-20
	if($banner_type == 'text')
    {
    	$display_trfile = 'none';
		$display_trtext = 'none';
		$tr_rss_content = 'none';
		$banner="";
    }
	elseif($banner_type == 'rss')
	{   
		$display_trfile = 'none';
		$display_trtext = 'none';
		$tr_rss_content = '';
		$banner = trim($_POST['rss_feed_item_id']);
	}
	elseif($banner_type == 'Video')
	{   
		$display_trfile = 'none';
		$display_trtext = '';
		$banner = trim($_POST['banner2']);
		$tr_rss_content = 'none';
	}
	else
	{  
		$display_trfile = '';
		$display_trtext = 'none';
		$tr_rss_content = 'none';

		if(isset($_FILES['banner']['tmp_name']) && $_FILES['banner']['tmp_name'] != '')
		{
				$banner = $_FILES['banner']['name'];
				$file4 = substr($banner, -4, 4);

				if($banner_type == 'Image')
				{
					if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))
					{
						$error = true;
						$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for banner';
					}	 
					elseif( $_FILES['banner']['type'] != 'image/jpeg' and $_FILES['banner']['type'] != 'image/pjpeg'  and $_FILES['banner']['type'] != 'image/gif' and $_FILES['banner']['type'] != 'image/png' )
					{
						$error = true;
						$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for banner';
					}
					
					$image_size = $_FILES['banner']['size']/1024;	 
					$max_image_allowed_file_size = 2000; // size in KB
					if($image_size > $max_image_allowed_file_size )
					{
						$error = true;
						$err_msg .=  "<br>Size of image file should be less than $max_image_allowed_file_size kb";
					}
				}
				elseif($banner_type == 'Flash')
				{
					if(($file4 != '.swf')and($file4 != '.SWF'))
					{
						$error = true;
						$err_msg .= '<br>Please Upload Only(swf) files for banner ';
					}	 
					elseif( $_FILES['banner']['type'] != 'application/x-shockwave-flash'  )
					{
						$error = true;
						$err_msg .= '<br>Please Upload Only(swf) files for banner';
					}
						
					$flash_size = $_FILES['banner']['size']/1024;
					$max_flash_allowed_file_size = 2000; // size in KB
					if($flash_size > $max_flash_allowed_file_size )
					{
						$error = true;
						$err_msg .=  "<br>Size of flash file should be less than $max_flash_allowed_file_size kb";
					}
				}
				//update by ample 07-12-19
				elseif($banner_type == 'Audio' || $banner_type == 'Sound')
				{   
					if(($file4 != '.mp3')and($file4 != '.wav') and ($file4 !='.MP3') and ($file4 != '.WAV') and ($file4 !='.mid') and ($file4 != '.MID'))
					{
						$error = true;
						$err_msg .= '<br>Please Upload Only(mp3/wav/mid) files for banner ';
					}
					
					$banner_size = $_FILES['banner']['size']/1024;	 
					$max_allowed_file_size = 2000; // size in KB
					if($banner_size > $max_allowed_file_size )
					{
						$error = true;
						$err_msg .=  "<br>Size of audio file should be less than $max_allowed_file_size kb";
					}	 
				}

				if(!$error)
				{	
					$banner = time()."_".$banner;
					$temp_dir = SITE_PATH.'/uploads/';
					$temp_file = $temp_dir.$banner;
					
					if(!move_uploaded_file($_FILES['banner']['tmp_name'], $temp_file)) 
					{
						if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
						$error = true;
						$err_msg .= '<br>Couldn\'t Upload banner 1';
						$banner = trim($_POST['hdnbanner']);
					}
				}
				else
				{
					$banner = '';
				}
			}  
			else
			{
				$banner = trim($_POST['hdnbanner']);
				$file4=substr($banner, -4, 4);
				
				if($banner_type == 'Image')
				{
					if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))
					{
						$error = true;
						$err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for banner';
					}
					
				}
				elseif($banner_type == 'Flash')
				{
					if(($file4 != '.swf')and($file4 != '.SWF'))
					{
						$error = true;
						$err_msg .= '<br>Please Upload Only(swf) files for banner ';
					}
					
				}
				//update by ample 07-12-19
				elseif($banner_type == 'Audio' || $banner_type == 'Sound')
				{
					if(($file4 != '.mp3')and($file4 != '.wav') and ($file4 !='.MP3') and ($file4 != '.WAV') and ($file4 !='.mid') and ($file4 != '.MID'))
					{
						$error = true;
						$err_msg .= '<br>Please Upload Only(mp3/wav/mid) files for banner ';
					}
					
				}	 	 

			}
		}

		if(!$error)
		{  



			if($obj->Update_Mindjumble($page_id,$status,$box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url,$sound_clip_id,$short_narration,$banner_id,$str_tags,$ref_code,$group_code,$take_key_title,$take_key_narration,$take_key_notes,$order,$is_featured))
				{
				    $user_uploads = $_GET['user_uploads'];
					if($user_uploads == '1')
						{
							$mode = 'mindjumble_user_upload';
						}
						else
						{
							$mode = 'mindjumble';
						}
					$msg = "Record Edited Successfully!";	
					header('location: index.php?mode='.$mode.'&msg='.urlencode($msg));
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
	$banner_id = $_GET['uid'];
	//update by ample 19-11-19
	list($page_id,$box_title,$banner_type,$box_desc,$banner,$status,$credit_line,$credit_line_url,$sound_clip_id,$short_narration,$order,$ref_code,$group_code,$tags,$take_key_title,$take_key_narration,$take_key_notes,$is_featured) = $obj->getmindjumbleDetails($banner_id);

	//add by ample 
	$arr_selected_page_id = explode(',', $page_id);
	$arr_tags = explode(",", $tags);
	//$arr_day = explode(",", $day);
	
	// if($step == '2')
	// {
	// 	$display_stressbuster = '';
	// }
	// else
	// {	
	// 	$display_stressbuster = 'none';
	// }

	
	if($banner_type == 'text')
	{
		$display_trfile = 'none';
		$display_trtext = 'none';
		$tr_rss_content= 'none';
	}
	elseif($banner_type == 'rss')
	{
		$display_trfile = 'none';
		$display_trtext = 'none';
		$tr_rss_content= '';
	}
	elseif($banner_type == 'Video')
	{
		$display_trfile = 'none';
		$display_trtext = '';
		$tr_rss_content= 'none';
	}
	else
	{
		$display_trfile = '';
		$display_trtext = 'none';
		$tr_rss_content= 'none';
	}
}
else
{
	$user_uploads = $_GET['user_uploads'];
	if($user_uploads == '1')
	{
		$mode = 'mindjumble_user_upload';
	}
	else
	{
		$mode = 'mindjumble';
	}
	header('location: index.php?mode='.$mode);
}	

?>
<script src="js/AC_ActiveX.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>

<!--add by ample 13-12-19 -->
<link rel="stylesheet" href="css/build.min.css">
<script src="js/build.min.js"></script>
<link rel="stylesheet" href="css/fastselect.min.css">
<script src="js/fastselect.standalone.js"></script>


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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Mind Jumble</td>
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
							<form action="#" method="post" name="frmedit_Mindjumble" id="frmedit_Mindjumble" enctype="multipart/form-data" >
							<input type="hidden" name="hdnbanner_id" value="<?php echo $banner_id;?>" />
                          <!--   <input type="hidden" name="box_title" value="<?php echo $box_title;?>" />
                            <input type="hidden" name="box_desc" value="<?php echo $box_desc;?>" />
                            <input type="hidden" name="credit_line" value="<?php echo $credit_line;?>" />
                            <input type="hidden" name="day" value="<?php echo $day;?>" /> -->
                            <input type="hidden" name="hdnbanner" value="<?php echo stripslashes($banner);?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>

								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>

								<tr>

                                    <td width="30%" align="right" valign="top"><strong>Reference Code</strong></td>

                                    <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                    <td width="65%" align="left" valign="top">

                                        <input type="text" name="ref_code" id="ref_code" style="width:250px;" value="<?=$ref_code;?>" required="">



                                    </td>

                                </tr>

                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>
                                                                
                                <tr>

                                    <td width="30%" align="right" valign="top"><strong>Group Code</strong></td>

                                    <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                    <td width="65%" align="left" valign="top">
                                        
                                        <select name="group_code" id="group_code" style="width:250px;" required="">

                                                <option value="">Select</option>
                                                
                                                <?php echo $obj3->getdylgroupcodeoption('78',$group_code); ?>
                                                 
                                            </select>
                                        
                                    </td>

                                </tr>
								<!-- <tr>
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
 -->                            <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>
									<td width="20%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><select id="status" name="status">
                                    								<option value="1" <?php if($status == '1'){ ?> selected <?php } ?>>Active</option>
                                                                    <option value="0" <?php if($status == '0'){ ?> selected <?php } ?>>Inactive</option>
                                                                    </select></td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="30%" align="right" valign="top"><strong>Page Name</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="65%" align="left" valign="top">
                                                                            <?php echo $obj3->getPageDropdownChkeckbox($arr_selected_page_id,'29','200','100');?>
                                                                            
                                                                        </td>
								</tr>
								<tr>
									<td colspan="3" align="center" valign="top">&nbsp;</td>
								</tr>
                              <!--  <tr>
									<td width="20%" align="right"><strong>Select Box Title</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><select name="title_id" id="title_id" onchange="GetShortNarration('<?php echo $short_narration;?>')">
																	<option value="">Select Option</option>
																	<?php  echo $obj->getMindJumbleSelectTitle($title_id); ?>
																	</select>
                                    </td>
								</tr> -->
                                <!-- <tr>
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
								</tr> -->
								<tr>
									<td width="20%" align="right"><strong>Mind Jumble Box Title</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="box_title" name="box_title" value="<?php echo $box_title; ?>" style="width:250px;"/>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="take_key_title" id="take_key_title" <?php if($take_key_title == 1) { echo 'checked'; } ?> > keyword Selection</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right" ><strong>Narration</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left" id="narration">
                                    					<!-- <select name="short_narration" id="short_narration">
                                                        <option value="">Select</option>
                                                      	 <?php echo $obj->getShortNarrationID($title_id,$short_narration); ?>
                                                        </select> -->
                                                        <textarea rows="5" cols="40" name="short_narration" id="short_narration"><?=$short_narration;?></textarea>
                                                        <input type="checkbox" name="take_key_narration" id="take_key_narration" <?php if($take_key_narration == 1) { echo 'checked'; } ?> > keyword Selection
                                     </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>

								<tr>
									<td width="20%" align="right"><strong>Banner Type </strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
										<select name="banner_type" id="banner_type" onChange="BannerBox1()">
											<?php echo $obj2->getSolutionItemTypeOptions($banner_type); ?>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								
								<tr>

									<td width="20%" align="right" valign="top"><strong>Banner</strong></td>

									<td width="5%" align="center" valign="top"><strong>:</strong></td>

									<td width="75%" align="left">

									<?php 

                                    if($banner_type == 'rss' || $banner_type == 'text')

                                    {

                                        

                                    }

                                    else 

                                    {

									if($banner != '')

									{  

										if($banner_type == 'Image')

										{ ?>

										<img border="0" src="<?php echo SITE_URL.'/uploads/'. $banner;?>" width="100" height="100"  /> 

							        	<?php

										}		

										elseif($banner_type == 'Flash')

										{ 

										  ?>

										<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="<?php echo $width; ?>" HEIGHT="<?php echo $height; ?>" id="myMovieName">

											<PARAM NAME=movie VALUE="<?php echo SITE_URL.'/uploads/'. $banner;?>">

											<PARAM NAME=quality VALUE=high>

											<param name="wmode" value="transparent">

											<EMBED src="<?php echo SITE_URL.'/uploads/'. $banner; ?>" quality=high WIDTH="<?php echo $width; ?>" HEIGHT="<?php echo $height; ?>" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>

										</OBJECT>

										<?php

										}

										 elseif($banner_type == 'Video')

										{   
                                                                                     //echo $banner;
                                                                                     ?>

                                                                                <iframe width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo $obj->getStressBusterBannerString($banner); ?>" frameborder="0" allowfullscreen></iframe>

										<?php

										}
										//update by ample 07-12-19
										 elseif($banner_type == 'Audio' || $banner_type == 'Sound')

										{   ?>
																				<!-- code comment by ample -->
                                                                                <!-- <embed type="application/x-shockwave-flash" flashvars="audioUrl=<?php echo SITE_URL.'/uploads/'. $banner;?>" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="300" height="27" quality="best"></embed> -->

                                                                                <!-- code add by ample 07-12-19-->

                                                                                <embed src="<?php echo SITE_URL.'/uploads/'. $banner;?>" autostart="true" loop="true" height="50" width="250"></embed>
                                                                                <!-- add by ample 09-12-19 -->
                                                                                <br>
                                                                                <a href="<?php echo SITE_URL.'/uploads/'. $banner;?>" target="_blank"><?php echo $banner;?></a> 

                                                                               <?php

										}

                                                                                elseif($banner_type == 'Pdf')

										{   ?>

                                                                                <a href="<?php echo SITE_URL.'/uploads/'. $banner;?>" target="_blank"><?php echo $banner;?></a> 

                                                                               <?php

										}

									}

                                                                        }

                                                                        ?>

									</td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr id="trfile" style="display:<?php echo $display_trfile;?>">

									<td width="20%" align="right" valign="top">&nbsp;</td>

									<td width="5%" align="center" valign="top">&nbsp;</td>

									<td width="75%" align="left">

										<input type="file" name="banner" id="banner" />

									</td>

								</tr>

								<tr id="trtext" style="display:<?php echo $display_trtext;?>">

									<td width="20%" align="right" valign="top">&nbsp;</td>

									<td width="5%" align="center" valign="top">&nbsp;</td>

									<td width="75%" align="left">

										<input type="text" name="banner2" id="banner2" value="<?php echo $banner;?>" style="width: 50%;"/>

									</td>

								</tr>

                                                                <tr id="tr_rss_content" style="display:<?php echo $tr_rss_content;?>">

                                        <td align="right"><strong>Rss Feeds</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                            <select name="rss_feed_item_id" id="rss_feed_item_id" onchange="getDescriptionDataVivek();return false;" style="width:400px;">

                                                <option value="">Select Rss Feed</option>

                                                <?php echo $obj2->getRssFeedOptions($banner); ?>

                                            </select>

                                   	</td>

                                    </tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right"><strong>Credit Line</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="credit_line" name="credit_line" value="<?php echo $credit_line; ?>"/></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" align="right"><strong>Credit Line URL</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  id="credit_line_url" name="credit_line_url" value="<?php echo $credit_line_url; ?>"/></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                 <tr>
									<td width="20%" align="right" valign="top"><strong>Sound Clip</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left"><select name="sound_clip_id" id="sound_clip_id" onChange="Playsound(sound_clip_id)">
                                                                    <option value="">Select Music File </option>
                                    								<!-- <?php echo $obj->getSoundClipOptions($sound_clip_id); ?> -->
                                    								<?php echo $obj->getSoundClipOptions_new($sound_clip_id); ?>
                                                                    </select>
                                                                    <!-- <div id="playmusic"></div> --></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%" align="right" valign="top"><strong>Admin Notes</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left"><textarea id="box_desc" rows="10" cols="50" name="box_desc" ><?php echo $box_desc; ?></textarea><input type="checkbox" name="take_key_notes" id="take_key_notes" <?php if($take_key_notes == 1) { echo 'checked'; } ?> > keyword Selection
									</td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								 <!-- add by ample 18-11-19-->
                                <tr>
                                    <td width="20%" align="right"><strong>Tags</strong></td>
                                    <td width="5%" align="center"><strong>:</strong></td>
                                    <td width="75%" align="left">
                                    	 <!-- added by ample  13-12-19 -->
                                        <select class="multipleSelect1" name="tags[]" id="tags" multiple>   

                                         <?php echo $obj->getIngredientsByIngrdientType('','423','81',$arr_tags);?>

                                           <!-- fav id,comman,page_cat_id -->

                                        </select>

                                        <script>

                                            $('.multipleSelect1').fastselect();

                                        </script>                
                                    </td>
                                </tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<!-- added by ample 19-11-19-->
								<tr>
									<td align="right" valign="top"><strong> Order</strong></td>
									<td align="center" valign="top"><strong>:</strong></td>
									<td align="left" valign="top">
                                        <select name="order" id="order" style="width:150px; height:24px;">
											<?php
											for($i=1;$i<=200;$i++)
											{ 
												if($order == $i)
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

                                <td align="right"><strong>&nbsp;</strong></td>

                                <td align="center"><strong>&nbsp;</strong></td>

                                <td align="left">

                                  <input type="checkbox" value="1" name="is_featured" id="is_featured" <?php if($is_featured == 1) { echo 'checked'; } ?> > Featured Item

                                  <br><br>

                                   <a href="index.php?mode=update_scheduled&redirect_id=<?=$_GET['uid']?>&redirect=mjb" target="_blank"><button type="button" class="btn btn-warning btn-xs">Schedule Set</button></a>

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

<!-- add by ample 19-11-19-->
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>

	<script type="text/javascript">

		tinyMCE.init({

			mode : "exact",

			theme : "advanced",

			elements : "short_narration,box_desc",

			plugins : "style,advimage,advlink,emotions",

			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",

		});
</script>


<style>



    .fstQueryInput {

         font-size: 12px !important;

         }  

         .fstChoiceItem

         {

            background-color: #505558 !important;

            font-size: 10px !important;

         }  

         .fstMultipleMode .fstControls {

                box-sizing: border-box;

                padding: 0.5em 0.5em 0em 0.5em;

                overflow: hidden;

                width: 50em !important;

                cursor: text;

            }



</style>