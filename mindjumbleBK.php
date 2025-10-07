<?php
include('config.php');
$page_id = '44';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

if(isLoggedIn())
{
    doUpdateOnline($_SESSION['user_id']);
    $user_id = $_SESSION['user_id'];
}
else
{
    $user_id = 0;
}

$toolcontents = GetAngerVentTooltip($page_id);
$day = date('j');
list($arr_box_title1,$arr_banner_type1,$arr_banner1,$arr_box_desc1,$arr_mind_jumble_box_id1,$arr_credit_line1,$arr_credit_line_url1,$arr_day1,$arr_sound_clip_id1,$arr_select_title1,$arr_short_narration1) =  getMindJumbleBoxDetails($day);
list($arr_pdf1,$arr_pdf_title1,$arr_credit1,$arr_credit_url1,$arr_status1) = getMindJumbelPDF($day);
list($user_area_box_title1,$user_area_box_desc1) = getUserarea('1','Mindjumble');
list($music1,$music_id1,$credit1,$credit_url1) = getMindJumbelBKMusic($day);
$music_type1 = strtolower(substr($music1,strrpos($music1, '.') + 1));
if($music_type1 =='mp3')
{ 
    $type1 = 'audio/mpeg';
}
elseif($music_type1 =='wav')
{ 
    $type1 = 'audio/wav';
}
elseif($music_type1 =='mid')
{ 
    $type1 = 'audio/mid';
}

$display_banner1 = 'none';
$error = false;
$tr_err_user_banner_type1 = 'none';
$tr_err_user_title1 = 'none';
$err_user_banner_type1 = '';
$err_user_title1 = '';
$step1 ='';
$step4 = 'none';
$fav1 = array();
$theam_id = $_SESSION['theam_id'];

if(isset($_POST['btnUpload1']))	
{
	$title = $_POST['title'];
	$user_stressed = $_POST['user_stressed'];
	$user_banner_type1 = $_POST['user_banner_type1'];
	$user_title1 = $_POST['user_title1'];
	$user_select1 =  $_POST['select_banner1'];
	$user_adv1 = $_POST['adv1'];
	$comment_box = strip_tags(trim($_POST['comment_box']));
	$fav1 = $_POST['favourite1'];
	$theam_id = $_SESSION['theam_id'];
	$short_narration = $_POST['short_narration'];
	$select_title = $_POST['select_title'];

        if(is_array($fav1) && count($fav1)>0)
        {
            $fav1 = array_unique($fav1);
            $fav1 = array_values($fav1);
            $fav1_comma_separated = implode(",", $fav1);
        }
        else
        {
            $fav1 = array();   
            $fav1_comma_separated = '';
	}

        if($user_select1 != '')
 	{
            $display_banner1 = '';
        }

	if($user_banner_type1 == 'Video')



	{   



		



		$user_display_trfile1 = 'none';



		$user_display_trtext1 = '';



		$user_banner1 = trim($_POST['user_video_banner1']);



	}



	else



	{  



		$user_display_trfile1 = '';



		$user_display_trtext1 = 'none';







		if(isset($_FILES['user_banner1']['tmp_name']) && $_FILES['user_banner1']['tmp_name'] != '')



			{



				$user_banner1 = $_FILES['user_banner1']['name'];



				$user_file1=substr($user_banner1, -4, 4);



				 







					if($user_banner_type1 == 'Image')



					{



					      



						if(($user_file1 != '.jpg')and($user_file1 != '.JPG') and ($user_file1 !='jpeg') and ($user_file1 != 'JPEG') and ($user_file1 !='.gif') and ($user_file1 != '.GIF') and ($user_file1 !='.png') and ($user_file1 != '.PNG'))



						{



							$error = true;



							$tr_err_user_banner_type1 = '';



							$err_user_banner_type1 = 'Please Upload Only(jpg/gif/jpeg/png) files for banner';



						}	 



						elseif( $_FILES['user_banner1']['type'] != 'image/jpeg' and $_FILES['user_banner1']['type'] != 'image/pjpeg'  and $_FILES['user_banner1']['type'] != 'image/gif' and $_FILES['user_banner1']['type'] != 'image/png' )



						{



							$error = true;



							$tr_err_user_banner_type1 = '';



							$err_user_banner_type1 .= 'Please Upload Only(jpg/gif/jpeg/png) files ';



						}



							$image_size = $_FILES['user_banner1']['size']/1024;	 



							$max_image_allowed_file_size = 2000; // size in KB



							if($image_size > $max_image_allowed_file_size )



							{



								$error = true;



								$tr_err_user_banner_type1 = '';



								$err_user_banner_type1 .= "<br>Size of image file should be less than $max_image_allowed_file_size kb";



							}



					}



					elseif($user_banner_type1 == 'Flash')



						{



						if(($user_file1 != '.swf')and($user_file2 != '.SWF'))



							{



								$error = true;



								$tr_err_user_banner_type1 = '';



								$err_user_banner_type1 .= 'Please Upload Only(swf) files  ';



							}	 



						elseif( $_FILES['user_banner1']['type'] != 'application/x-shockwave-flash'  )



							{



								$error = true;



								$tr_err_user_banner_type1 = '';



								$err_user_banner_type1 .= 'Please Upload Only(swf) files ';



							}



								$flash_size = $_FILES['user_banner1']['size']/1024;	 



								$max_flash_allowed_file_size = 2000; // size in KB



								if($flash_size > $max_flash_allowed_file_size )



								{



									$error = true;



									$tr_err_user_banner_type1 = '';



									$err_user_banner_type1 .= "<br>Size of flash file should be less than $max_flash_allowed_file_size kb";



								}



						}



						elseif($user_banner_type1 == 'Audio')



						{



						 if(($user_file1 != '.mp3')and($user_file1 != '.wav')and($user_file1 != '.MP3')and($user_file1 != '.WAV')and($user_file1 != '.mid')and($user_file1 != '.MID'))



							{



								$error = true;



								$tr_err_user_banner_type1 = '';



								$err_user_banner_type1 .= 'Please Upload Only(mp3 / wav / mid) files  ';



							}



								$audio_size = $_FILES['user_banner1']['size']/1024;	 



								$max_audio_allowed_file_size = 2000; // size in KB



								if($audio_size > $max_audio_allowed_file_size )



								{



									$error = true;



									$tr_err_user_banner_type1 = '';



									$err_user_banner_type1 .= "<br>Size of audio file should be less than $max_audio_allowed_file_size kb";



								}	 



						}



						elseif($user_banner_type1 == 'PDF')



						{



							if(($user_file1 != '.pdf')and($user_file1 != '.PDF'))



							{



								$error = true;



								$tr_err_user_banner_type1 = '';



								$err_user_banner_type1 .= 'Please Upload Only(PDF / pdf) files';



							}



							$pdf_size = $_FILES['user_banner1']['size']/1024;



							$max_pdf_allowed_file_size = 2000; // size in KB



							if($pdf_size > $max_pdf_allowed_file_size )



							{



								$error = true;



								$tr_err_user_banner_type1 = '';



								$err_user_banner_type1 .= "<br>Size of PDF file should be less than $max_pdf_allowed_file_size kb";



							}	 



						}







						if(!$error)



							{	



								$user_banner1 = time()."_".$user_banner1;



								$user_temp_dir1 = SITE_PATH.'/uploads/';



								$user_temp_file1 = $user_temp_dir1.$user_banner1;



						



								if(!move_uploaded_file($_FILES['user_banner1']['tmp_name'], $user_temp_file1)) 



								{



									if(file_exists($user_temp_file1)) { unlink($user_temp_file1); } // Remove temp file



									$error = true;



									$tr_err_user_banner_type1 = '';



									$err_user_banner_type1 .= '<br>Couldn\'t Upload banner 1';



								}



							}



							else



								{



									$user_banner1 = '';



								}



							



			}



					



	}



	



	if(!$error)



	{



		if($user_banner1 != '')



		{



			if($user_banner_type1 == 'PDF')



			{



				InsertMindjumbelPDF($user_title1,$user_banner_type1,$user_banner1,$day,$user_id,$select_title,$short_narration);



			}



			else



			{



	  			InsertMindjumbel($user_title1,$user_banner_type1,$user_banner1,$day,$user_id);



			}



		}								



	}  







}



elseif(isset($_POST['btnSubmit1']))	



{



	$title = $_POST['title'];



	$user_stressed = $_POST['user_stressed'];



	$user_banner_type1 = $_POST['user_banner_type1'];



	$user_title1 = $_POST['user_title1'];



	$user_select1 =  $_POST['select_banner1'];



	$user_adv1 = $_POST['adv1'];



	$comment_box = strip_tags(trim($_POST['comment_box']));



	$fav1 = $_POST['favourite1'];



	$theam_id = $_SESSION['theam_id'];



	$short_narration = $_POST['short_narration'];



	$select_title = $_POST['select_title'];



	



	



	 if(is_array($fav1) && count($fav1)>0)



		{



			$fav1 = array_unique($fav1);



			$fav1 = array_values($fav1);



			$fav1_comma_separated = implode(",", $fav1);



		}



	else



		{



             $fav1 = array();   



			$fav1_comma_separated = '';



		}



	



 



	 if($user_select1 != '')



	 	{



	 		$display_banner1 = '';



		}



		



	



	



	if(!$error)



	{



		$step1 = 'none';



		$step4 = '';



	}











	if(!$error)



	{



   		if($user_id > 0)



			{  



				if($user_select1 != '' )



				  {



						InsertMindJumbelAllDetails($select_title,$short_narration,$user_stressed,$user_select1,$user_adv1,$fav1_comma_separated,$user_id,$comment_box);



						$final_message = 'Your details successfully saved';



				  }



				  else



				  {



				    	$final_message = 'Thank you for visit us';



				  }



			}



			else



			{



				$ref = base64_encode('mindjumble.php');



			  	$final_message = 'If you want to save the data for next time then <a href="login.php?ref='.$ref.'"> login here. </a>';



			}



		



	}



	



}



else



{



	$select_title = $_SESSION['temp_select_title'];



	$short_narration = $_SESSION['temp_short_narration'];	



	



}



list($color_code,$image,$credit,$credit_url) = getTheam($day,$theam_id);







 $ref = base64_encode('mindjumble.php');



 /* Commom Part of Div */



 



	



		if($user_banner_type1 == 'Video')



		{



			$user_display_trfile1 = 'none';



			$user_display_trtext1 = '';



		}



		else



		{



			$user_display_trfile1 = '';



			$user_display_trtext1 = 'none';



		}



		



	



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



	<meta name="description" content="<?php echo $meta_description;?>" />



	<meta name="keywords" content="<?php echo $meta_keywords;?>" />



	<meta name="title" content="<?php echo $meta_title;?>" />



	<title><?php echo $meta_title;?></title>



	<link href="cwri.css" rel="stylesheet" type="text/css" />



    <link href='css/jquery.rating.css' type="text/css" rel="stylesheet"/>



    <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>



	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>



	<script type="text/JavaScript" src="js/commonfn.js"></script>



	<script type="text/javascript" src="js/jquery.bxSlider2.js"></script>



    <script src='js/jquery.rating.js' type="text/javascript" language="javascript"></script>



    <script type="text/JavaScript" src="js/jquery.simpletip-1.3.1.js"></script>


	<link href="css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery.ticker.js" type="text/javascript"></script>	
   



	



	<script type="text/javascript">



		$(document).ready(function(){
		
		$('#js-news').ticker({
				controls: true,        // Whether or not to show the jQuery News Ticker controls
				 htmlFeed: true, 
				titleText: '',   // To remove the title set this to an empty String
				displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'
				direction: 'ltr'       // Ticker direction - current options are 'ltr' or 'rtl'
				
			});



			$('#slider').bxSlider({



				auto : true,



				autoConrols : true



			});
                        
                        $('#slider_main1').bxSlider();
                        $('#slider_main2').bxSlider();
                        $('#slider_main3').bxSlider();
                        $('#slider_main4').bxSlider();
                        $('#slider_main5').bxSlider();
                        $('#slider_main6').bxSlider();	



			



			$("#title").keydown(function(){



   			$("#title").css("background-color","#FFFFCC");



  			});



 			 $("#title").keyup(function(){



    		$("#title").css("background-color","#D6D6FF");



 			 });



			



			$('input.wow').rating();



			



			$(".QTPopup").css('display','none')



			



			$(".feedback").click(function(){



				$(".QTPopup").animate({width: 'show'}, 'slow');



			});	



			



			$("#your_opinion").click(function(){



				$(".QTPopup").animate({width: 'show'}, 'slow');



			});



		



			$(".closeBtn").click(function(){			



				$(".QTPopup").css('display', 'none');



			});



			



		});



	</script>



	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />



	<script type="text/javascript" src="js/ddsmoothmenu.js"></script>



	<script type="text/javascript">



		ddsmoothmenu.init({



		mainmenuid: "smoothmenu1", //menu DIV id



		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"



		classname: 'ddsmoothmenu', //class added to menu's outer DIV



		//customtheme: ["#1c5a80", "#18374a"],



		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]



		})



	</script>



</head>



<body>

<?php include_once('analyticstracking.php'); ?>

<?php include_once('analyticstracking_ci.php'); ?>

<?php include_once('analyticstracking_y.php'); ?>



<div id="fb-root"></div>



<script>(function(d, s, id) {



  var js, fjs = d.getElementsByTagName(s)[0];



  if (d.getElementById(id)) return;



  js = d.createElement(s); js.id = id;



  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=427704967243377";



  fjs.parentNode.insertBefore(js, fjs);



}(document, 'script', 'facebook-jssdk'));</script>



<?php include_once('analyticstracking.php'); ?>



<table width="100%" border="0" cellspacing="0" cellpadding="0">



	<tr>



		<td align="center" valign="top">



			<?php include_once('header.php'); ?>



			<table width="980" border="0" cellspacing="0" cellpadding="0">

                                <tr>
                    <td width="620" align="left" valign="top">
                        <table width="580" align="center" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="40" align="left" valign="top" class="breadcrumb">
                                    <?php echo getBreadcrumbCode($page_id);?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="2" align="left" valign="top">
                    <?php
                    if(isLoggedIn())
                    { 
                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);
                    }
                    ?>
                    </td>
                </tr>    

				<tr>



					



                                    <td  width="620" align="left" valign="top">



						



						


						<table align="center" width="590" border="0" id="color_code" cellpadding="0" cellspacing="1" bgcolor="<?php echo $color_code; ?>">



                        	<tr>



                            	<td align="center" valign="top" id="bgimage" background="<?php echo $image; ?>" bgcolor="#FFFFFF" style="padding:10px;">



                                   	<form id="frm_StressBusterBox1" name="frm_StressBusterBox1" method="post" action="#" enctype="multipart/form-data">



                                    <input type="hidden" name="hdnref" id="hdnref" value="<?php echo $ref; ?>" />



                                    <div id="step1" style="display:<?php echo $step1; ?>">



                                        <table width="570" border="0" cellspacing="0" cellpadding="0">



                                        	<tr>



                                        		<td height="50" colspan="2" align="left" valign="top">



                                                	<table width="100%" border="0" cellspacing="0" cellpadding="0">



                                                   		<tr>



                                                        	<td width="45%" height="40" align="left" valign="top"  >



                                                            	<span class="Header_brown"><div id="tooltip"><?php echo getPageName($page_id);?></div></span>



                                                            </td>



                                                            <td width="55%" height="40" align="right" valign="top">



                                                             	<select name="theam_id" id="theam_id" onchange="ChangeTheam()">



                                                               		<option>Select Theme</option>



                                                               		<?php echo getTheamOptions($theam_id,$day); ?>



                                                               	</select>



                                                          	</td>



                                                       	</tr>



                                                        </table>



                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" >



                                                        <tr>



                                                        	<td colspan="2"><?php echo getPageContents($page_id);?></td>



                                                        </tr>



                                                    </table>                            



                                                </td>



                                        	</tr>



                                            <!--<tr>



                                            	<td colspan="2" align="left" valign="top">



                                                	<strong>Title -: </strong>



                                                    <input type="text" name="title" id="title" onkeyup="GetOnKeyUpBanner()" value="<?php // echo $title; ?>" />



                                               	</td>



                                            </tr>-->



                                            <tr>



                                            	<td colspan="2" align="left" valign="top">



                                                	 <select name="select_title" id="select_title" onchange="GetShortNarration('<?php echo $short_narration;?>'); getTitleComments(); getAllPDF(); OnChangeGetShortNarration()">



                                                        <option value="">Select Title</option>



                                                        <?php echo getMindjumbleTitle($select_title); ?>	



                                                        </select>



                                              	</td>



                                            </tr>



                                          	<tr>



                                            	<td colspan="2" align="left" valign="top">&nbsp;</td>



                                           	</tr>



                                            <tr>



                                            	<td colspan="2" align="left" valign="top" id="narration">



                                                	 <select name="short_narration" id="short_narration"  onchange="OnChangeGetShortNarration(); getAllPDF(); getTitleComments();">



                                                        <option value="">Select Narration</option>



                                                      	 <?php echo getShortNarration($select_title,$short_narration); ?>



                                                        </select>



                                                    



                                               	</td>



                                            </tr>



                                            <tr>



                                            	<td height="20" colspan="2" align="left" valign="top">&nbsp;</td>



                                            </tr>



                                           



                                            <tr>



                                            	<td colspan="2" align="center" valign="top" id="tdslider">



                                               		<?php echo  OnChangeGetShortNarration($short_narration,$select_title); ?>



                                                     



                                                </td>



                                            </tr>



                                          



                                            <tr>



                                                <td height="35" colspan="2" align="left" valign="top">&nbsp;</td>



                                            </tr>



                                            <tr>



                                            	<td colspan="2" align="center" valign="top">



                                            		<div id="disply_banner1" class="slider_main2" style="display:<?php echo $display_banner1; ?>">



                                                    <?php 



														$output = get_MindJumbleBoxCode($user_select1);



														echo $output; 



													?>



                                                    </div>



                                            	</td>



                                            </tr>



                                            <tr>



                                            	<td height="35" colspan="2" align="left" valign="top">&nbsp;</td>



                                            </tr>



										  	<?php 



										  	if(count($arr_banner1)>0)



                                            { ?>



                                            <tr>



                                            	<td height="35" colspan="2" align="left" valign="top">



                                                	<span style="float:left;"><strong>Rate it:</strong></span>



                                            		<span>



                                                    	<input name="adv1" <?php if($user_adv1 == 1) { ?> checked="checked"  <?php } ?> type="radio" class="star" value="1" onclick="HideRateIt();"/>



                                                        <input name="adv1" <?php if($user_adv1 == 2) { ?> checked="checked"  <?php } ?> type="radio" class="star" value="2" onclick="HideRateIt();"/>



                                                        <input name="adv1" <?php if($user_adv1 == 3) { ?> checked="checked"  <?php } ?> type="radio" class="star" value="3" onclick="HideRateIt();"/>



                                                        <input name="adv1" <?php if($user_adv1 == 4) { ?> checked="checked"  <?php } ?> type="radio" class="star" value="4" onclick="HideRateIt();"/>



                                                        <input name="adv1" <?php if($user_adv1 == 5) { ?> checked="checked"  <?php } ?> type="radio" class="star" value="5" onclick="HideRateIt();"/>



                                                   	</span>



                                              	</td>



                                            </tr>



                                            <?php 



											} ?>



                                            </table>



											<?php 



											 if(count($arr_pdf1)>0) { 



											 ?>



                                             <div id="pdf_result">



                                                 <?php echo get_allpdfcode($select_title,$short_narration); ?>



                                            </div>



                                             <?php  } ?> 



                                             <div id="Allcomment">



                                             <?php echo GetCommentCode($select_title,$short_narration); ?>



                                             </div>



                                            <table border="0" width="100%" cellpadding="0" cellspacing="0">



                                            <tr>



                                            	<td align="left" colspan="2" class="Header_brown">



                                                	<strong>Your Opinion:</strong>



                                                </td>



                                            </tr>



                                            <tr>



                                                <td colspan="2">



                                                    <textarea id="comment_box" name="comment_box" cols="35" rows="5" ><?php echo $comment_box; ?></textarea>



                                                </td>



                                            </tr>



                                            <tr>



                                                <td>



                                                    <input name="submit" type="button" class="button" id="submit" value="Post"  onclick="PostComment()"/>



                                                </td>



                                            </tr>



                                            <tr>



                                            	<td colspan="2">&nbsp;</td>



                                            </tr>



                                            <tr>



                                            	<td height="40" colspan="2" align="left" valign="middle" bgcolor="#FFF2C1" style="padding-left:15px;">



                                                	<strong><?php echo $user_area_box_title1; ?></strong>



                                                </td>



                                            </tr>



                                            <tr>



                                                <td height="30" colspan="2" align="left" valign="top" bgcolor="#FFF2C1" style="padding-left:15px; padding-right:15px;">



                                                	<?php echo $user_area_box_desc1; ?>



                                                </td>



                                            </tr>



                                            <tr>



                                               	<td align="left" colspan="2" bgcolor="#FFF2C1" style="padding-left:15px; padding-right:15px;">



                                                	<strong>Title:</strong>



                                                    <input type="text" size="55" name="user_title1" id="user_title1" value="<?php echo $user_title1; ?>" />



                                                </td>



                                            </tr>



                                            <tr>



                                            	<td colspan="2" bgcolor="#FFF2C1" style="padding-left:15px; padding-right:15px;">&nbsp;</td>



                                            <tr> 



                                            <tr>



                                                <td width="35%" align="left" bgcolor="#FFF2C1" style="padding-left:15px;">



                                                	<strong>Upload File Type:</strong>



                                                    <select name="user_banner_type1" id="user_banner_type1" onchange="BannerBox1('1')">



                                                        <option value="Image" <?php if($user_banner_type1 == 'Image'){ ?> selected <?php } ?>>Image</option>



                                                        <option value="Flash" <?php if($user_banner_type1 == 'Flash'){ ?> selected <?php } ?>>Flash</option>



                                                        <option value="Audio" <?php if($user_banner_type1 == 'Audio'){ ?> selected <?php } ?>>Audio</option>



                                                        <option value="Video" <?php if($user_banner_type1 == 'Video'){ ?> selected <?php } ?>>Video</option>



                                                        <option value="PDF"   <?php if($user_banner_type1 == 'PDF'){ ?> selected <?php } ?>>PDF</option>



                                                    </select>



                                                </td>



                                                <td width="65%" align="left" bgcolor="#FFF2C1" >



                                            		<div id="user_trfile1" style="display:<?php echo $user_display_trfile1;?>">



                                                    	<input type="file" name="user_banner1" id="user_banner1" />



                                                    </div>   



                                                    <div id="user_trtext1" style="display:<?php echo $user_display_trtext1;?>">  



                                                    	<input type="text" name="user_video_banner1" id="user_video_banner1" value="<?php echo $user_banner1;?>" />



                                                    &nbsp;<span class="footer">Please Enter Youtube Video URL.</span>



                                                    </div>



                                            	</td>



                                            </tr>



                                            <tr id="tr_err_user_banner_type1"  style="display:<?php echo $tr_err_user_banner_type1;?>;">



                                            	<td align="left" colspan="2" bgcolor="#FFF2C1" style="padding-left:15px; padding-right:15px;" class="err_msg">



													<?php echo $err_user_banner_type1;?>



                                                </td>



                                            </tr>



                                            <tr>



                                               	<td colspan="2" bgcolor="#FFF2C1" style="padding-left:15px; padding-right:15px;">&nbsp;</td>



                                            </tr>



                                             <tr>



                                               	<td colspan="2" bgcolor="#FFF2C1" style="padding-left:15px; padding-right:15px;">



                                               	<input name="btnUpload1" type="submit" class="button" id="btnUpload1" value="Upload" /></td>



                                            </tr>



                                             <tr>



                                               	<td colspan="2" bgcolor="#FFF2C1" style="padding-left:15px; padding-right:15px;">&nbsp;</td>



                                            </tr>



                                            </table>



                                            <table border="0" width="100%" cellpadding="0" cellspacing="0">



                                            <tr>



                                            	<td width="100%" colspan="2"  bgcolor="#FFF2C1" style="padding-left:15px; ">



                                            		<div class="fb-like" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false"></div>



                                                     <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo SITE_URL."/mindjumble.php" ;?>" data-via="your_screen_name" data-lang="en">Tweet</a>

    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>



                                                </td>



                                            </tr>



                                           



                                            <tr>



                                            	<td height="40" colspan="2"  align="left" valign="bottom">



                                                	<input name="btnSubmit1" type="submit" class="button" id="btnSubmit1" value="Continue" />



                                                </td>



                                        	</tr>



                                    	</table>



                                        </div>
                                        <div id="playmusic"></div>
                                        <?php  /* Fourth Div Start  */ ?>
                                        <div id="step4" style="display:<?php echo $step4; ?>">
                                            <table width="570" border="0" cellspacing="0" cellpadding="0">
                                        	<tr>
                                                    <td height="50" align="left" valign="top">
                                                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                        	<td width="100%" height="35" align="left" valign="top">
                                                                    <span class="Header_brown"><?php echo $final_message; ?></span>
                                                                </td>
                                                            </tr>
                                                        </table>                            
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="180" align="left" valign="top">
                        <?php include_once('left_sidebar.php'); ?>
                    </td>
                    <td width="180" align="left" valign="top">
                        <?php include_once('right_sidebar.php'); ?>
                    </td>
                </tr>
            </table>
            <?php include_once('footer.php'); ?>
        </td>
    </tr>
</table>
<?php 
if($step4 != '')
{  
    if($step1 == '')
    {  
        $music = $music1; 
        $credit = $credit1; 
        $credit_url = $credit_url1;
        $type = $type1;
    }
    
    if($music !='') 
    { ?>
    <div class="floatdiv">
        <embed src="<?php echo SITE_URL.'/uploads/'. $music;?>" autostart="true" loop="true" width="50" height="30" type=<?php echo $type; ?>></embed>
        <br><span class="footer">(Toggle BG Music)</span><br>
        <a href="<?php echo $credit_url; ?>" target="_blank"><span class="footer"><?php echo $credit; ?></span></a>
    </div>
    <?php 
    }  
} 
?>
</body>
</html>