<?php
require_once('../config.php');
$page_id = '11';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('practitioners/sound_files.php');

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
		

			if(updateSoundFile($music,$day,$credit,$credit_url,$status,$music_id,$pro_user_id,$country_id,$str_state_id,$str_city_id,$str_place_id,$str_user_id,$keywords))

				{

					$msg = "Record Edited Successfully!";

					header('location: sound_files.php?msg='.urlencode($msg));

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

		$music_id = $_GET['id'];

		

		list($music,$day,$credit,$credit_url,$status,$country_id,$state_id,$city_id,$place_id,$user_id,$keywords) = getSounfFileDetailsFront($music_id,$pro_user_id);

	    if($music == '')
		{
			header('location: sound_files.php');
			exit(0);
		}
		else
		{	
			 $music_type = strtolower(substr($music,strrpos($music, '.') + 1));

		

			if($music_type =='mp3')

				{ $type = 'audio/mpeg';}

			elseif($music_type =='wav')

				{ $type = 'audio/wav';}

			elseif($music_type =='mid')

				{ $type = 'audio/mid';}

		if($state_id == '')
		{
			$arr_state_id[0] = '';
		}
		else
		{
			$pos1 = strpos($state_id, ',');
			if ($pos1 !== false) 
			{
				$arr_state_id = explode(',',$state_id);
			}
			else
			{
				array_push($arr_state_id , $state_id);
			}
		}
		
		if($city_id == '')
		{
			$arr_city_id[0] = '';
		}
		else
		{
			$pos2 = strpos($city_id, ',');
			if ($pos2 !== false) 
			{
				$arr_city_id = explode(',',$city_id);
			}
			else
			{
				array_push($arr_city_id , $city_id);
			}
		}
		
		if($place_id == '')
		{
			$arr_place_id[0] = '';
		}
		else
		{
			$pos3 = strpos($place_id, ',');
			if ($pos3 !== false) 
			{
				$arr_place_id = explode(',',$place_id);
			}
			else
			{
				array_push($arr_place_id , $place_id);
			}
		}
		
		if($user_id == '')
		{
			$arr_user_id[0] = '';
		}
		else
		{
			$pos3 = strpos($user_id, ',');
			if ($pos3 !== false) 
			{
				$arr_user_id = explode(',',$user_id);
			}
			else
			{
				array_push($arr_user_id , $user_id);
			}
		}

	     $arr_day = explode(",", $day);
		}	

		

	}

else

	{

		header('location: sound_files.php');

	}	
	
?><!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $meta_description;?>" />
	<meta name="keywords" content="<?php echo $meta_keywords;?>" />
	<meta name="title" content="<?php echo $meta_title;?>" />
	<title><?php echo $meta_title;?></title>
	<link href="../cwri.css" rel="stylesheet" type="text/css" />
	 <link href="../csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="js/commonfn.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
	<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
    <script type="text/javascript" src="js/jscolor.js"></script>
    
    <style type="text/css">@import "../css/jquery.datepick.css";</style> 
	<script type="text/javascript" src="../js/jquery.datepick.js"></script>
    
     <link href="../css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="../js/jquery.ticker.js" type="text/javascript"></script>
    
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
<!--header-->
<header>
 <?php include 'topbar.php'; ?>
<?php include_once('header.php');?>
</header>
<!--header End --> 			
<!--breadcrumb--> 
  
 <div class="container"> 
    <div class="breadcrumb">
               
                    <div class="row">
                    <div class="col-md-8">	
                      <?php echo getBreadcrumbCode($page_id);?> 
                       </div>
                         <div class="col-md-4">
                       
                         </div>
                       </div>
                </div>
            </div>
<!--breadcrumb end --> 

<!--container-->              
<div class="container" >
<div class="row">	
<div class="col-md-8">	
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
							<tr>
								<td align="center" valign="middle" bgcolor="#FFFFFF" style="background-repeat:repeat-x; padding:10px;">
									<form action="#" name="frmedit_profile" id="frmedit_profile" method="post" enctype="multipart/form-data"> 
                                    	<input type="hidden" name="hdnmusic_id" value="<?php echo $music_id;?>" />
			                            <input type="hidden" name="hndmusic" id="hndmusic" value="<?php echo $music;?>" />
										
                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
                                        <tbody>
                                        	<tr>
												<td colspan="3" align="left" class="err_msg"><?php echo $err_msg;?></td>
											</tr>
                                            <tr>

									<td width="20%" ><strong>Status</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left"><select  class="form-control" style="width:200px;" name="status" id="status">

                                                                 <option value="1" <?php  if($status == 1) {?> selected="selected" <?php } ?> >Active</option>

                                                                 <option value="0" <?php  if($status == 0) {?> selected="selected" <?php } ?>>Inactive</option>

                                                                 </select></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>
                                            
                                 <tr>
									<td width="20%"  valign="top"><strong>Select Day</strong></td>
									<td width="5%" align="center" valign="top"><strong>:</strong></td>
									<td width="75%" align="left"><select  class="form-control" style="width:50px;"  id="day" name="day[]" multiple="multiple">
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
                                    <td  valign="top"><strong>User</strong></td>
                                    <td align="center" valign="top"><strong>:</strong></td>
                                    <td align="left" valign="top">
                                        <select multiple="multiple"  class="form-control" style="width:200px;"  name="user_id[]" id="user_id">
                                            <option value="" <?php if (in_array('', $arr_user_id)) {?> selected="selected" <?php } ?>>All Users</option>
                                            <?php echo getAdvisersUserOptionsMultiFront($arr_user_id,$pro_user_id); ?>
                                        </select>&nbsp;&nbsp;<a href="javascript:void(0)" target="_self" class="body_link" onclick="viewUsersSelectionPopup()" >Select Users</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td  valign="top"><strong>Keywords</strong></td>
                                    <td align="center" valign="top"><strong>:</strong></td>
                                    <td align="left" valign="top">
                                        <input  class="form-control" style="width:200px;"  type="text" name="keywords" id="keywords" value="<?php echo $keywords;?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td  valign="top"><strong>Country</strong></td>
                                    <td align="center" valign="top"><strong>:</strong></td>
                                    <td align="left" valign="top">
                                        <select name="country_id" id="country_id" onchange="getStateOptionsMulti();"  class="form-control" style="width:200px;" >
                                            <option value="" >All Country</option>
                                            <?php echo getCountryOptions($country_id); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td  valign="top"><strong>State</strong></td>
                                    <td align="center" valign="top"><strong>:</strong></td>
                                    <td align="left" valign="top" id="tdstate">
                                        <select multiple="multiple" name="state_id[]" id="state_id" onchange="getCityOptionsMulti();"  class="form-control" style="width:200px;" >
                                            <option value="" <?php if (in_array('', $arr_state_id)) {?> selected="selected" <?php } ?>>All States</option>
                                            <?php echo getStateOptionsMulti($country_id,$arr_state_id); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td  valign="top"><strong>City</strong></td>
                                    <td align="center" valign="top"><strong>:</strong></td>
                                    <td align="left" valign="top" id="tdcity">
                                        <select multiple="multiple" name="city_id[]" id="city_id" onchange="getPlaceOptionsMulti();"  class="form-control" style="width:200px;" >
                                            <option value="" <?php if (in_array('', $arr_city_id)) {?> selected="selected" <?php } ?>>All Cities</option>
                                            <?php echo getCityOptionsMulti($country_id,$arr_state_id,$arr_city_id); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td  valign="top"><strong>Place</strong></td>
                                    <td align="center" valign="top"><strong>:</strong></td>
                                    <td align="left" valign="top" id="tdplace">
                                        <select multiple="multiple" name="place_id[]" id="place_id"  class="form-control" style="width:200px;" >
                                            <option value="" <?php if (in_array('', $arr_place_id)) {?> selected="selected" <?php } ?>>All Places</option>
                                            <?php echo getPlaceOptionsMulti($country_id,$arr_state_id,$arr_city_id,$arr_place_id); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">&nbsp;</td>
                                </tr>
                                <tr>
									<td width="20%" ><strong>Credit</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input  class="form-control" style="width:200px;"  type="text"  id="credit" name="credit" value="<?php echo $credit; ?>"/>
                                     </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
									<td width="20%" ><strong>Credit URL</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left"><input type="text"  class="form-control" style="width:350px;"   id="credit_url" name="credit_url" value="<?php echo $credit_url; ?>"/>&nbsp;(Please enter link like http://www.google.com)
                                     </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>

									<td ></td>

									<td align="center"></td>

									<td align="left"> <!--<embed type="application/x-shockwave-flash" flashvars="audioUrl=<?php //echo SITE_URL.'/uploads/'. $music;?>" src="http://www.google.com/reader/ui/3523697345-audio-player.swf"  loop="true" autostart="true"></embed>-->

                                    

                                     <embed src="<?php echo SITE_URL.'/uploads/'. $music;?>" autostart="true" loop="true" height="20" type="<?php echo $type; ?>"></embed>

								    </td>

								</tr>
                                <tr>
                                   <td ><strong>Upload Music</strong>
                                    <td align="center"><strong>:</strong></td>
                                    <td><input name="music" type="file" id="music"  class="form-control" style="width:200px;"  />
                                     </td>
                                  </tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td align="left"><input type="Submit" name="btnSubmit" value="Submit" class="btn btn-primary" /></td>
								</tr>
                                        </tbody>
                                        </table>
									</form>	
								</td>
							</tr>
						</table>
</div>
 <div class="col-md-2">	  <?php include_once('left_sidebar.php'); ?></div>
  </div>
  <div class="col-md-2">  <?php include_once('right_sidebar.php'); ?></div>
  	</div>
 </div>
 </div>
<!--container-->                   <!--  Footer-->
  <footer> 
   <div class="container">
   <div class="row">
   <div class="col-md-12">	
   <?php include_once('footer.php');?>            
  </div>
  </div>
  </div>
  </footer>
  <!--  Footer-->
            <!--default footer end here-->

        
        <!--scripts and plugins -->
        <!--must need plugin jquery-->
       <!-- <script src="../csswell/js/jquery.min.js"></script>   -->     
        <!--bootstrap js plugin-->
        <script src="../csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
       
    </body>

</html>