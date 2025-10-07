<?php

include('config.php');  

$page_id = '127';

list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$ref = base64_encode($menu_link);

//if(!isLoggedIn())
//
//{
//
//    header("Location: login.php?ref=".$ref);
//
//    exit(0);
//
//}
//
//else
//
//{
//
//    $user_id = $_SESSION['user_id'];
//
//    doUpdateOnline($_SESSION['user_id']);
//    
//

$day = date('j');

list($arr_pdf_id1,$arr_pdf_step1,$arr_pdf1,$arr_pdf_title1,$arr_credit1,$arr_credit_url1,$arr_status1) = getAngerVentPDF(1,$day);

list($arr_pdf_id2,$arr_pdf_step1,$arr_pdf2,$arr_pdf_title2,$arr_credit2,$arr_credit_url2,$arr_status2) = getAngerVentPDF(2,$day);

list($arr_pdf_id3,$arr_pdf_step1,$arr_pdf3,$arr_pdf_title3,$arr_credit3,$arr_credit_url3,$arr_status3) = getAngerVentPDF(3,$day);




if(isset($_GET['date']) && $_GET['date'] != '')

{

    $date = $_GET['date'];

    $day = date('j',  strtotime($date));

    $date = date('Y-m-d',  strtotime($date));

}

else 

{

    $day = date('j');

    $date = date('Y-m-d');

}



if(isset($_GET['bms_id']) && $_GET['bms_id'] != '')

{

    $bms_id = $_GET['bms_id'];

}

else 

{

    $mid = '';

}



if(isset($_POST['sol_cat_id']))

{

    $sol_cat_id = trim($_POST['sol_cat_id']);

}

else

{

    $sol_cat_id = '';

}



list($arr_step1,$arr_box_title1,$arr_banner_type1,$arr_banner1,$arr_box_desc1,$arr_stress_buster_box_id1,$arr_credit_line1,$arr_credit_line_url1,$arr_sound_clip_id1,$arr_rss_feed_item_id1) =  getMWSBoxDetails('',$date,$mid,$user_id);

//echo '<br><pre>';

//print_r($arr_stress_buster_box_id1);

//echo '<br></pre>';

list($user_area_box_title1,$user_area_box_desc1) = getUserarea('1','MWS');

list($music1,$music_id1,$credit1,$credit_url1) = getMWSBoxBGMusic(1,$day);



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

$err_msg = '';

$tr_user_upload_form = 'none';

$btn_show_user_upload_form = '';

$btn_user_upload = 'none';



$tr_err_msg = 'none';

$tr_err_user_banner_type1 = 'none';

$tr_err_user_title1 = 'none';

$err_user_banner_type1 = '';

$err_user_title1 = '';



$step1 ='';

$fav1 = array();

$chk_pdf1 = array();

$user_adv1 = array();

$add_sol_item_id = array();

$add_fav1 = array();

$theam_id = $_SESSION['mws_theam_id'];

$theam_id1 = $theam_id;



//echo'<br><pre>';

//print_r($_POST);

//echo'<br></pre>';



if(isset($_POST['btnUpload1']))	

{

    $tr_user_upload_form = '';

    $btn_show_user_upload_form = 'none';

    $btn_user_upload = '';

    

    $user_select1 =  $_POST['select_banner1'];

    $user_title1 = $_POST['user_title1'];

    $user_banner_type1 = $_POST['user_banner_type1'];

    

    foreach ($_POST['chk_pdf1'] as $key => $value) 

    {

        array_push($chk_pdf1,$value);

    }

    

    $chk_pdf1 = array_unique($chk_pdf1);

    $chk_pdf1 = array_values($chk_pdf1);

    

    foreach ($_POST['favourite1'] as $key => $value) 

    {

        array_push($fav1,$value);

    }

    

    $fav1 = array_unique($fav1);

    $fav1 = array_values($fav1);

    

    for($i=0;$i<count($arr_step1);$i++)

    {

        if(isset($_POST['adv1_'.$i])) 

        {

            $user_adv1[$i] = $_POST['adv1_'.$i];

        }

        else

        {

            $user_adv1[$i] = '';

        }

        

        if(in_array($arr_stress_buster_box_id1[$i], $fav1))

        {

            $add_fav1[$i] = '1';

        }

        else 

        {

            $add_fav1[$i] = '0';

        }

        

        if($user_adv1[$i] == '' && $add_fav1[$i] == '0')

        {

            $add_sol_item_id[$i] = '';

        }

        else 

        {

            $add_sol_item_id[$i] = $arr_stress_buster_box_id1[$i];

        }

    }



    if($user_banner_type1 == 'Image')

    {

	$user_file_type_msg1 = 'Please upload jpg/gif image';

    }

    elseif($user_banner_type1 == 'Flash')

    {

	$user_file_type_msg1 = 'Please upload swf file';

    }

    elseif($user_banner_type1 == 'Audio')

    {

        $user_file_type_msg1 = 'Please upload mp3/wav/mid file';

    }

    elseif($user_banner_type1 == 'PDF')

    {

        $user_file_type_msg1 = 'Please upload pdf file';

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



        if($user_banner1 == '')

        {

            $error = true;

            $tr_err_user_banner_type1 = '';

            $err_user_banner_type1 .= 'Please enter youtube video url.';

        }

    }

    else

    {  

        $user_display_trfile1 = '';

        $user_display_trtext1 = 'none';



        if(isset($_FILES['user_banner1']['tmp_name']) && $_FILES['user_banner1']['tmp_name'] != '')

        {

            $user_banner1 = $_FILES['user_banner1']['name'];

            $user_file1 = substr($user_banner1, -4, 4);





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

                    $err_user_banner_type1 .= 'Please Upload Only(PDF / pdf) files  ';

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

                    $err_user_banner_type1 .= '<br>Couldn\'t Upload banner';

                }

            }

            else

            {

                $user_banner1 = '';

            }

        }

        else

        {

            $error = true;

            $tr_err_user_banner_type1 = '';

            $err_user_banner_type1 = "Please upload any Image/Flash/Audio file";

        }	

    }

    

    if($err_user_banner_type1 != '')

    {

        $err_user_banner_type1 = '<div class="err_msg_box"><span class="blink_me">'.$err_user_banner_type1.'</span></div>';

    }



    if(!$error)

    {

        if($user_banner1 != '')

        {

            InsertMWSItem($user_title1,$user_banner_type1,$user_banner1,$user_id);

        }									

    }

}

elseif(isset($_POST['btnSubmit1']))	

{

    $user_select1 =  $_POST['select_banner1'];

    $user_title1 = $_POST['user_title1'];

    $user_banner_type1 = $_POST['user_banner_type1'];

    

    foreach ($_POST['chk_pdf1'] as $key => $value) 

    {

        array_push($chk_pdf1,$value);

    }

    

    $chk_pdf1 = array_unique($chk_pdf1);

    $chk_pdf1 = array_values($chk_pdf1);

    

    foreach ($_POST['favourite1'] as $key => $value) 

    {

        array_push($fav1,$value);

    }

    

    $fav1 = array_unique($fav1);

    $fav1 = array_values($fav1);

    

    $error_blank = true;

    for($i=0;$i<count($arr_step1);$i++)

    {

        if(isset($_POST['adv1_'.$i])) 

        {

            $user_adv1[$i] = $_POST['adv1_'.$i];

        }

        else

        {

            $user_adv1[$i] = '';

        }

        

        if(in_array($arr_stress_buster_box_id1[$i], $fav1))

        {

            $add_fav1[$i] = '1';

        }

        else 

        {

            $add_fav1[$i] = '0';

        }

        

        if($user_adv1[$i] == '' && $add_fav1[$i] == '0')

        {

            $add_sol_item_id[$i] = '';

        }

        else 

        {

            $add_sol_item_id[$i] = $arr_stress_buster_box_id1[$i];

            $error_blank = false;

        }

    }

    

    

    $user_file_type_msg2 = 'Please upload jpg/gif image';

    

    if($user_select1 == '')

    {

        //$error = true;

        //$tr_err_msg = '';

        //$err_msg = 'Please select any item';

    }

    

    if($error_blank)

    {

        $error = true;

        $tr_err_msg = '';

        $err_msg = 'Please select any item';

    }

    

    //if(count($add_fav1) == 0 && count())

    

    if(!$error)

    {

        $fav1_comma_separated = implode(',',$fav1);

        $chk_pdf1_comma_separated = implode(',',$chk_pdf1);

        if(addMWSAllDetails($user_id,$add_sol_item_id,$add_fav1,$user_adv1,$date))

        {

            if(count($fav1) > 0)

            {

                addScrollingContentToFav($user_id,$page_id,$fav1_comma_separated,'1');

            }            

            if(count($chk_pdf1) > 0)

            {

                PDF_Library($page_id,$chk_pdf1_comma_separated,$user_id);

            }

            

            header("Location: message.php?msg=6");  //15 is old message id

            exit(0);

        }

        else

        {

            $error = true;

            $tr_err_msg = '';

            $err_msg = 'Something went wrong Please try again later.';

        }

        //$final_message = 'Your details successfully saved';

    }

}



if($err_msg != '')

{

    $err_msg = '<div class="err_msg_box"><span class="blink_me">'.$err_msg.'</span></div>';

}

/*

echo'<br><pre>';

print_r($add_sol_item_id);

echo'<br></pre>';



echo'<br><pre>';

print_r($add_fav1);

echo'<br></pre>';



echo'<br><pre>';

print_r($user_adv1);

echo'<br></pre>';

 * 

 */



/* Commom Part of Div */

list($color_code,$image,$credit,$credit_url) = getTheam($day,$theam_id);



/* For Div One   */

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

?><!DOCTYPE html>

<html lang="en">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="description" content="<?php echo $meta_description;?>" />

    <meta name="keywords" content="<?php echo $meta_keywords;?>" />

    <meta name="title" content="<?php echo $meta_title;?>" />

    <title><?php echo $meta_title;?></title>



    <link href="cwri.css" rel="stylesheet" type="text/css" />

     <link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 

    <link href='css/jquery.rating.css' type="text/css" rel="stylesheet"/>

    <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

    <script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>

    <script type="text/JavaScript" src="js/commonfn.js"></script>

    <script type="text/javascript" src="js/jquery.bxSlider2.js"></script>

    <script src='js/jquery.rating.js' type="text/javascript" language="javascript"></script>

    <script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>

    <script type="text/javascript" src="js/selectToUISlider.jQuery.js"></script>

    <link rel="stylesheet" href="css/redmond/jquery-ui-1.7.1.custom.css" type="text/css" />

    <link rel="Stylesheet" href="css/ui.slider.extras.css" type="text/css" />

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

            

            $("ul.tabs li").click(function() {

                $("ul.tabs li").removeClass("active");

                $(this).addClass("active");

                $(".tab_content3").hide();

                var activeTab = $(this).attr("rel"); 

                $("#"+activeTab).fadeIn(); 

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



            $('input.star').rating();



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

            

            $("#btnShowUpload").click(function(){			

                $("#tr_user_upload_form").show();

                $("#btn_show_user_upload_form").hide();

                $("#btn_user_upload").show();

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

<?php include_once('analyticstracking'); ?>

<?php include_once('analyticstracking_ci.php'); ?>

<?php include_once('analyticstracking_y.php'); ?>

<header> 

<?php include 'topbar.php'; ?>

<?php include_once('header.php');?> 

</header>

<div class="container">  

    <div class="breadcrumb">

                    <div class="row">

                    <div class=" col-md-8">

                      <?php // echo getBreadcrumbCode($page_id);?> 

                       </div>

                       <div class=" col-md-4">

                        <?php

//                                    if(isLoggedIn())
//
//                                    { 
//
//                                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);
//
//                                    }

                                    ?>

                       </div>

                       

                       </div>

                </div>

            </div>

<!--container-->

 <div class="container">

       <div class="row">

            <div class=" col-md-8">





                    

                        <table align="center" width="100%" border="0" id="color_code" cellpadding="0" cellspacing="1" bgcolor="<?php echo $color_code; ?>">

                            <tr>

                            	<td align="center" valign="top" id="bgimage" background="<?php  echo $image; ?>" bgcolor="#FFFFFF" style=" padding:10px;">

                                    <form id="frm_StressBusterBox1" name="frm_StressBusterBox1" method="post" action="#" enctype="multipart/form-data">

                                    	<input type="hidden" name="hdndate" id="hdndate" value="<?php echo $date;?>"  />

                                        <input type="hidden" name="hdnmid" id="hdnmid" value="<?php echo $bms_id;?>"  />

                                        <div id="step1" style="display:<?php echo $step1; ?>">

                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                <tr>

                                                    <td height="50" colspan="2" align="left" valign="top">

                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                            <tr>

                                                                <!--<td width="25%" height="35" align="left" valign="top" ><span class="Header_brown"><div id="tooltip"><?php echo getPageName($page_id);?></div></span></td>-->          

<!--                                                                <td width="75%" height="35" align="right" valign="top">

                                                                    <select name="theam_id1" id="theam_id" onchange="ChangeTheamMWS()" class="form-control">

                                                                        <option>Select Theme</option>

                                                                        <?php echo getTheamOptions($theam_id,$day); ?>

                                                                    </select>

                                                                </td>      -->

                                                            </tr>

                                                        </table>    

                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                            <tr>

                                                                <td><?php echo getPageContents($page_id);?></td>

                                                            </tr>

                                                        </table>

                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td colspan="2" align="left" valign="top">&nbsp;</td>

                                                </tr>

                                                <tr>

                                                    <td height="35"  align="left"  valign="top" width="25%">

                                                        <span class="Header_brown">Related Info On-- :</span>&nbsp;

       </td>
                                                <input type="hidden" name="fav_cat_id" id="fav_cat_id" value="<?php echo $_GET[fav_cat_id]; ?>">

       <td width="75%">                                                 
           <!--<select name="sol_cat_id" id="sol_cat_id" onchange="getMWSBoxCode()" class="form-control">-->
          
<!--           <select name="sol_cat_id" id="sol_cat_id" onchange="getMWSBoxCodeVivek()" class="form-control">

                                                            <option value="">All</option>

                                                            <?php echo getSolutionCategoryOptions($sol_cat_id); ?>

                                                        </select>-->

                                                    </td>
                                          </tr>  
                                          
                                               

                                                <tr>

                                                    <td colspan="2" align="left" valign="top">&nbsp;</td>

                                                </tr>

                                                <tr id="tr_err_msg"  style="display:<?php echo $tr_err_msg;?>;">

                                                    <td align="left" colspan="2" class="err_msg" id="tr_err_msg1"><?php echo $err_msg;?></td>

                                                </tr>

                                                <tr>

                                                    <td colspan="2" align="left" valign="top" id="idmwscoderesult">

                                                        <?php echo getMWSBoxCode($sol_cat_id,$date,$user_select1,$fav1,$chk_pdf1,$user_adv1,$mid,$user_id);?>

                                                    </td>

                                                </tr>

                                                <tr id="tr_user_upload_form" style="display:<?php echo $tr_user_upload_form;?>;">

                                                    <td colspan="2" align="left" valign="top" >

                                                        <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">

                                                            <tr>

                                                                <td height="40" colspan="2" align="left" valign="middle" bgcolor="#FFF2C1" style="padding-left:15px;"><strong><?php echo $user_area_box_title1; ?></strong></td>

                                                            </tr>

                                                            <tr>

                                                                <td height="30" colspan="2" align="left" valign="top" bgcolor="#FFF2C1" style="padding-left:15px; padding-right:15px;">

                                                                    <?php echo $user_area_box_desc1; ?> 

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td align="left" bgcolor="#FFF2C1" style="padding-left:15px; padding-right:15px;"><strong>Title: </strong></td>

                                                                <td>

                                                                      <input type="text" class="form-control" name="user_title1" id="user_title1" value="<?php echo $user_title1; ?>" />

                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td colspan="2" bgcolor="#FFF2C1" style="padding-left:15px; padding-right:15px;">&nbsp;</td>

                                                            <tr> 

                                                            <tr>

                                                                <td width="32%" align="left" bgcolor="#FFF2C1" style="padding-left:15px;">

                                                                    <strong>Upload File Type:</strong>

                                                                    <select name="user_banner_type1" id="user_banner_type1" onchange="BannerBox1('1')">

                                                                        <option value="Image" <?php if($user_banner_type1 == 'Image'){ ?> selected <?php } ?>>Image</option>

                                                                        <option value="Flash" <?php if($user_banner_type1 == 'Flash'){ ?> selected <?php } ?>>Flash</option>

                                                                        <option value="Audio" <?php if($user_banner_type1 == 'Audio'){ ?> selected <?php } ?>>Audio</option>

                                                                        <option value="Video" <?php if($user_banner_type1 == 'Video'){ ?> selected <?php } ?>>Video</option>

                                                                        <option value="PDF"   <?php if($user_banner_type1 == 'PDF'){ ?> selected <?php } ?>>PDF</option>

                                                                    </select>

                                                                </td>

                                                                <td width="68%" align="left" bgcolor="#FFF2C1" >

                                                                    <div id="user_trfile1" style="display:<?php echo $user_display_trfile1;?>">

                                                                        <input type="file" name="user_banner1" id="user_banner1" />&nbsp;<span id="user_file_type_msg1" class="footer"><?php echo $user_file_type_msg1;?></span>

                                                                    </div>   

                                                                    <div id="user_trtext1" style="display:<?php echo $user_display_trtext1;?>">  

                                                                        <input type="text" name="user_video_banner1" id="user_video_banner1" value="<?php echo $user_banner1;?>" />

                                                                        &nbsp;<span class="footer">Please Enter Youtube Video URL.</span>

                                                                    </div>

                                                                </td>

                                                            </tr>

                                                            <tr id="tr_err_user_banner_type1"  style="display:<?php echo $tr_err_user_banner_type1;?>;">

                                                                <td align="left" colspan="2" bgcolor="#FFF2C1" style="padding-left:15px; padding-right:15px;" class="err_msg" id="user_err_banner_type1"><?php echo $err_user_banner_type1;?></td>

                                                            </tr>

                                                            <tr>

                                                                <td colspan="2" bgcolor="#FFF2C1" style="padding-left:15px; padding-right:15px;">&nbsp;</td>

                                                            </tr>

                                                        </table>

                                                    </td>

                                                </tr>
                                                


                                               <?php if(count($arr_step2)>0)







                                                            {







                                                                 ?>







                                                <tr>







                                                    <td height="35" colspan="2" align="left" valign="top"><span style="float:left;"><strong>Rate it:</strong></span>







                                                  <span><input name="adv2" <?php if($user_adv2 == 1) { ?> checked="checked"  <?php } ?> type="radio" class="star" value="1" onclick="HideRateIt();"/>







                                                        <input name="adv2" <?php if($user_adv2 == 2) { ?> checked="checked"  <?php } ?> type="radio" class="star" value="2" onclick="HideRateIt();"/>







                                                        <input name="adv2" <?php if($user_adv2 == 3) { ?> checked="checked"  <?php } ?> type="radio" class="star" value="3" onclick="HideRateIt();"/>







                                                        <input name="adv2" <?php if($user_adv2 == 4) { ?> checked="checked"  <?php } ?> type="radio" class="star" value="4" onclick="HideRateIt();"/>







                                                        <input name="adv2" <?php if($user_adv2 == 5) { ?> checked="checked"  <?php } ?> type="radio" class="star" value="5" onclick="HideRateIt();"/></span></td>







                                                    







                                                </tr>







                                               <?php } ?>



<!--                                     <?php //  if(count($arr_pdf2)>0) { ?>


-->

  <tr>

                                                    <td colspan="2" height="30"  align="left" valign="bottom">

                                                        

                                                        <span id="btn_show_user_upload_form" style="display:<?php echo $btn_show_user_upload_form;?>">

                                                            <input class="btn btn-primary" name="btnShowUpload" type="button"  id="btnShowUpload" value="Show User Upload Area" />

                                                        </span>

                                                        <span id="btn_user_upload" style="display:<?php echo $btn_user_upload;?>">

                                                            <input name="btnUpload1" type="submit" class="btn btn-primary" id="btnUpload1" value="Upload"  />

                                                        </span>

                                                    </td>

                                                </tr>


                                                 <tr>







                                                    <td colspan="2" align="left" valign="top"><strong>Know More:</strong></td>







                                                 </tr>







                                                 <?php //  } ?>







                                                <?php  for($i=0;$i<count($arr_pdf1);$i++)

                                                            {     ?>


                                                <tr>







                                                    <td height="50" colspan="2" align="left" valign="top">







                                                    <a href="<?php echo SITE_URL."uploads/".$arr_pdf1[$i]; ?>" target="_blank" class="body_link"><?php echo $arr_pdf_title1[$i]; ?></a>







                                                    <input type="checkbox" class="chk_pdf" id="chk_pdf_<?php echo $arr_pdf_id1[$i]; ?>" name="chk_pdf[]" value="<?php echo $arr_pdf_id1[$i]; ?>" />







                                                     <br /><a href="<?php echo $arr_credit_url1[$i]; ?>" target="_blank"><span class="footer"><?php echo $arr_credit1[$i];  ?></span></a></td>







                                                            </tr>







                                                <?php } ?>

<!--                                                 <?php  for($i=0;$i<count($arr_pdf2);$i++)







                                                            {     ?>







                                                <tr>







                                                    <td height="50" colspan="2" align="left" valign="top">







                                                    <a href="<?php echo SITE_URL."uploads/".$arr_pdf2[$i]; ?>" target="_blank" class="body_link"><?php echo $arr_pdf_title2[$i]; ?></a>







                                                    <input type="checkbox" class="chk_pdf" id="chk_pdf_<?php echo $arr_pdf_id2[$i]; ?>" name="chk_pdf[]" value="<?php echo $arr_pdf_id2[$i]; ?>" />







                                                     <br /><a href="<?php echo $arr_credit_url2[$i]; ?>" target="_blank"><span class="footer"><?php echo $arr_credit2[$i];  ?></span></a></td>







                                                            </tr>







                                                <?php } ?>
 
                                                            -->
                                                            
<!--                                                <tr>

                                                    <td colspan="2" height="30"  align="left" valign="bottom">

                                                        

                                                        <span id="btn_show_user_upload_form" style="display:<?php echo $btn_show_user_upload_form;?>">

                                                            <input class="btn btn-primary" name="btnShowUpload" type="button"  id="btnShowUpload" value="Show User Upload Area" />

                                                        </span>

                                                        <span id="btn_user_upload" style="display:<?php echo $btn_user_upload;?>">

                                                            <input name="btnUpload1" type="submit" class="btn btn-primary" id="btnUpload1" value="Upload"  />

                                                        </span>

                                                    </td>

                                                </tr>-->

                                            </table>

                                        </div>

                                        <div id="playmusic"></div>

                                    </form>

                                </td>

                            </tr>

                        </table>

           

                   

</div>

         

                <!-- ad left_sidebar-->

                <div class=" col-md-2">

                 <?php include_once('left_sidebar.php'); ?>

              </div>

               <!-- ad left_sidebar end -->

                <!-- ad right_sidebar-->

               <div class=" col-md-2">

                <?php include_once('right_sidebar.php'); ?>

              </div>

               <!-- ad right_sidebar end -->

            </div>

 </div>

            <!--container end -->

           

           

           <!--footer -->         

              <footer>

    <div class="container">

                    <div class="row">

                    <div class="col-lg-12">	

     <?php include_once('footer.php');?>

    </div></div></div>

  </footer>    

      <!--footer end -->         

          

       

<!-- Bootstrap Core JavaScript -->

 <script src="csswell/js/jquery.min.js"></script>   

<script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 





</body>

</html>               

                   

<?php 

$music = $music1; 

$credit = $credit1; 

$credit_url = $credit_url1;

$type =  $type1;



if($music !='') 

{ ?>

<div class="floatdiv">

    <embed src="<?php echo SITE_URL.'uploads/'. $music;?>" autostart="true" loop="true" width="50" height="30" type="<?php echo $type; ?>"></embed>

    <br><span class="footer">(Toggle BG Music)</span><br>

    <a href="<?php echo $credit_url; ?>" target="_blank"><span class="footer"><?php echo $credit; ?></span></a>

</div>

<?php 

} ?>

<script>

$(document).ready(function()
    {
       
         var sol_cat_id = document.getElementById('fav_cat_id').value;

//    var date = document.getElementById('hdndate').value;

    var mid = document.getElementById('hdnmid').value;

    
    link='remote.php?action=getmwsboxcodevivek&sol_cat_id='+sol_cat_id+'&mid='+mid;

    var linkComp = link.split( "?");

    var result;

    var obj = new ajaxObject(linkComp[0], fin);

    obj.update(linkComp[1],"GET");

    obj.callback = function (responseTxt, responseStat) {

        // we'll do something to process the data here.

        result = responseTxt;

        $('#idmwscoderesult').html(result);

        $('input.star').rating();

        $('#slider').bxSlider({

                auto : true,

                autoConrols : true

            });

            

    }

    });   
   

   
//function getMWSBoxCodeVivek()
//
//{
//
//    var sol_cat_id = document.getElementById('sol_cat_id').value;
//alert(sol_cat_id);
////    var date = document.getElementById('hdndate').value;
//
//    var mid = document.getElementById('hdnmid').value;
//
//    
//    link='remote.php?action=getmwsboxcodevivek&sol_cat_id='+sol_cat_id+'&mid='+mid;
//
//    var linkComp = link.split( "?");
//
//    var result;
//
//    var obj = new ajaxObject(linkComp[0], fin);
//
//    obj.update(linkComp[1],"GET");
//
//    obj.callback = function (responseTxt, responseStat) {
//
//        // we'll do something to process the data here.
//
//        result = responseTxt;
//
//        $('#idmwscoderesult').html(result);
//
//        $('input.star').rating();
//
//        $('#slider').bxSlider({
//
//                auto : true,
//
//                autoConrols : true
//
//            });
//
//            
//
//    }
//
//}


</script>
</body>

</html>