<?php
require_once('../config.php');
$page_id = '11';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('practitioners/add_sound_file.php');

if(!isLoggedInPro())
{
	header("Location: ".SITE_URL."/prof_login.php?ref=".$ref);
	exit(0);
}
else
{
	doUpdateOnlinePro($_SESSION['pro_user_id']);
	$pro_user_id = $_SESSION['pro_user_id'];
}

if(get_magic_quotes_gpc())
{
	foreach($_POST as $k => $v)
	{
		$_POST[$k] = stripslashes($_POST[$k]);
	}
}

$error = false;
$err_msg = "";

$arr_state_id = array();
$arr_city_id = array();
$arr_place_id = array();
$arr_user_id = array();

if(isset($_POST['btnSubmit']))
{
	$music = strip_tags(trim($_POST['music']));
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
	
	foreach ($_POST['user_id'] as $key => $value) 
	{
		array_push($arr_user_id,$value);
	}
	
	
	$keywords = trim($_POST['keywords']);
	
	if($day == "")
	{
		$error = true;
		$err_msg .= "Please Select Day.";
	}
	
	

	if(isset($_FILES['music']['tmp_name']) && $_FILES['music']['tmp_name'] != '')
	{
	
		$music = basename($_FILES['music']['name']);
		
		$type_of_uploaded_file =substr($music,strrpos($music, '.') + 1);
		$target_size = $_FILES['music']['size']/1024;
		$max_allowed_file_size = 10000; // size in KB
		$target_type = array("mp3","wav","mid","MP3","WAV","MID");
	
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
  $error = true; 
  $err_msg .= '<br>Please upload file'; 
}
		if(!$error)
			{  
			
				if($arr_state_id[0] == '')
				{
					$str_state_id = '';
				}
				else
				{
					$str_state_id = implode(',',$arr_state_id);
				}
				
				if($arr_city_id[0] == '')
				{
					$str_city_id = '';
				}
				else
				{
					$str_city_id = implode(',',$arr_city_id);
				}
				
				if($arr_place_id[0] == '')
				{
					$str_place_id = '';
				}
				else
				{
					$str_place_id = implode(',',$arr_place_id);
				}
				
				if($arr_user_id[0] == '')
				{
					$str_user_id = '';
				}
				else
				{
					$str_user_id = implode(',',$arr_user_id);
				}
			 
				if(addSoundFile($music,$day,$credit,$credit_url,$pro_user_id,$country_id,$str_state_id,$str_city_id,$str_place_id,$str_user_id,$keywords))
					{
						$msg = "Record Added Successfully!";
						header('location: sound_files.php?msg='.urlencode($msg));
					}
				else
					{
						$error = true;
						$err_msg = "Currently there is some problem.Please try again later.";
					}
			}	
}
else
	{
	$arr_day = array();
	$credit_url = 'http://';
	$country_id = '';
	$arr_state_id[0] = '';
	$arr_city_id[0] = '';
	$arr_place_id[0] = '';
	$arr_user_id[0] = '';
	$keywords = '';	
		}
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $meta_description;?>" />
	<meta name="keywords" content="<?php echo $meta_keywords;?>" />
	<meta name="title" content="<?php echo $meta_title;?>" />
	<title><?php echo $meta_title;?></title>
	<link href="../cwri.css" rel="stylesheet" type="text/css" />
	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="js/commonfn.js"></script>
	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
	<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
   
    <style type="text/css">@import "css/jquery.datepick.css";</style> 
	<script type="text/javascript" src="js/jquery.datepick.js"></script>
    
    <link href="css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery.ticker.js" type="text/javascript"></script>
    
	<script type="text/javascript">
		ddsmoothmenu.init({
		mainmenuid: "smoothmenu1", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		//customtheme: ["#1c5a80", "#18374a"],
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
		})

		$(document).ready(function() {
		
			$('#js-news').ticker({
				controls: true,        // Whether or not to show the jQuery News Ticker controls
				 htmlFeed: true, 
				titleText: '',   // To remove the title set this to an empty String
				displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'
				direction: 'ltr'       // Ticker direction - current options are 'ltr' or 'rtl'
				
			});
		
			$(".QTPopup").css('display','none')

			$(".feedback").click(function(){
				$(".QTPopup").animate({width: 'show'}, 'slow');
			});	

			$(".closeBtn").click(function(){			
				$(".QTPopup").css('display', 'none');
			});
			
			
		});			
	</script>
</head>
<body>
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" valign="top">
			<?php include_once('header.php');?>
			<table width="980" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="980" align="left" valign="top">
						<table width="960" align="center" border="0" cellspacing="0" cellpadding="0">
							<tr>
	                            <td height="40" align="left" valign="top" class="breadcrumb">
                                	<?php //echo getBreadcrumbCode($page_id);?>
                                     <a href="index.php" target="_self" class="breadcrumb_link">Home</a> &gt; <a href="#" target="_self" class="breadcrumb_link">Settings</a> &gt; <a href="sound_files.php" target="_self" class="breadcrumb_link">Background Music Settings </a> &gt; Add Background Music
                                </td>
                            </tr>
                        </table> 
						<table width="960" align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
							<tr>
								<td align="center" valign="middle" bgcolor="#FFFFFF" style="background-repeat:repeat-x; padding:10px;">
									<form action="#" name="frmedit_profile" id="frmedit_profile" method="post" enctype="multipart/form-data"> 
                                    	
										
                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
                                        <tbody>
                                        	<tr>
												<td colspan="3" align="left" class="err_msg"><?php echo $err_msg;?></td>
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
                                    <td align="right" valign="top"><strong>User</strong></td>
                                    <td align="center" valign="top"><strong>:</strong></td>
                                    <td align="left" valign="top">
                                        <select multiple="multiple" name="user_id[]" id="user_id">
                                            <option value="" <?php if (in_array('', $arr_user_id)) {?> selected="selected" <?php } ?>>All Users</option>
                                            <?php echo getAdvisersUserOptionsMultiFront($arr_user_id,$pro_user_id); ?>
                                        </select>&nbsp;&nbsp;<a href="javascript:void(0)" target="_self" class="body_link" onclick="viewUsersSelectionPopup()" >Select Users</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right" valign="top"><strong>Keywords</strong></td>
                                    <td align="center" valign="top"><strong>:</strong></td>
                                    <td align="left" valign="top">
                                        <input type="text" name="keywords" id="keywords" value="<?php echo $keywords;?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right" valign="top"><strong>Country</strong></td>
                                    <td align="center" valign="top"><strong>:</strong></td>
                                    <td align="left" valign="top">
                                        <select name="country_id" id="country_id" onchange="getStateOptionsMulti();" style="width:200px;">
                                            <option value="" >All Country</option>
                                            <?php echo getCountryOptions($country_id); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right" valign="top"><strong>State</strong></td>
                                    <td align="center" valign="top"><strong>:</strong></td>
                                    <td align="left" valign="top" id="tdstate">
                                        <select multiple="multiple" name="state_id[]" id="state_id" onchange="getCityOptionsMulti();" style="width:200px;">
                                            <option value="" <?php if (in_array('', $arr_state_id)) {?> selected="selected" <?php } ?>>All States</option>
                                            <?php echo getStateOptionsMulti($country_id,$arr_state_id); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right" valign="top"><strong>City</strong></td>
                                    <td align="center" valign="top"><strong>:</strong></td>
                                    <td align="left" valign="top" id="tdcity">
                                        <select multiple="multiple" name="city_id[]" id="city_id" onchange="getPlaceOptionsMulti();" style="width:200px;">
                                            <option value="" <?php if (in_array('', $arr_city_id)) {?> selected="selected" <?php } ?>>All Cities</option>
                                            <?php echo getCityOptionsMulti($country_id,$arr_state_id,$arr_city_id); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right" valign="top"><strong>Place</strong></td>
                                    <td align="center" valign="top"><strong>:</strong></td>
                                    <td align="left" valign="top" id="tdplace">
                                        <select multiple="multiple" name="place_id[]" id="place_id" style="width:200px;">
                                            <option value="" <?php if (in_array('', $arr_place_id)) {?> selected="selected" <?php } ?>>All Places</option>
                                            <?php echo getPlaceOptionsMulti($country_id,$arr_state_id,$arr_city_id,$arr_place_id); ?>
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
									<td width="75%" align="left"><input type="text"  id="credit_url" name="credit_url" value="<?php echo $credit_url; ?>"/>&nbsp;(Please enter link like http://www.google.com)
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
						</table>
						<table width="580" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<?php include_once('footer.php');?>
		</td>
	</tr>
</table>
</body>
</html>