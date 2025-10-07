<?php
include('config.php');
$page_id = '32';

list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$ref = base64_encode('my_communications.php');
if(!isLoggedIn())
{
    header("Location: login.php?ref=".$ref);
    exit(0);
}
else
{
    $user_id = $_SESSION['user_id'];
    doUpdateOnline($_SESSION['user_id']);
}

$now = time();
$today_year = date("Y",$now);
$today_month = date("m",$now);
$today_day = date("d",$now); 
$mc_date = $today_year.'-'.$today_month.'-'.$today_day;

$yesterday = $now - 86400;
$yesterday_year = date("Y",$yesterday);
$yesterday_month = date("m",$yesterday);
$yesterday_day = date("d",$yesterday); 

$error = false;
$tr_err_mc_date = 'none';
$tr_err_mc = array();
$err_mc_date = '';
$err_mc = array();
$tr_response_img = array();
$tr_response_slider = array();

if(isset($_POST['pro_user_id']))
{
    $pro_user_id = $_POST['pro_user_id'];
}
else
{
    $pro_user_id = '';
}

list($arr_mc_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getMCQuestions($user_id,$mc_date,$pro_user_id);

$cnt = count($arr_mc_id);
for($i=0;$i<$cnt;$i++)
{
    $tr_response_img[$i] = '';
    $tr_response_slider[$i] = 'none';
}

if(isset($_POST['btnSubmit']))	
{
    $day = trim($_POST['day']);
    $month = trim($_POST['month']);
    $year = trim($_POST['year']);
    $pro_user_id = $_POST['pro_user_id'];

    if($pro_user_id == '' || $pro_user_id == '999999999')
    {
        $bg_color_code = '#339900';
        $bg_image = '';
    }
    else
    {
        list($bg_image,$bg_color_code) = getImageAndColorCodeOfAdviserTheme($pro_user_id);
    }	

    list($scale,$scale_add,$scale_rest,$scale_cnt,$scale_arr_rest,$scale_arr) = getMultipleFieldsValueByComma('scale');
    list($remarks,$remarks_add,$remarks_rest,$remarks_cnt,$remarks_arr_rest,$remarks_arr) = getMultipleFieldsValueBy('remarks');
    list($my_target,$my_target_add,$my_target_rest,$my_target_cnt,$my_target_arr_rest,$my_target_arr) = getMultipleFieldsValueByComma('my_target');
    list($adviser_target,$adviser_target_add,$adviser_target_rest,$adviser_target_cnt,$adviser_target_arr_rest,$adviser_target_arr) = getMultipleFieldsValueByComma('adviser_target');

    $selected_mc_id_arr = array();
    $empty_selected_mc_id_arr = true;
    for($i=0;$i<$cnt;$i++)
    {
        $selected_mc_id = strip_tags(trim($_POST['selected_mc_id_'.$i]));
        if($selected_mc_id != '')
        {
            $empty_selected_mc_id_arr = false;
            $tr_response_img[$i] = 'none';
            $tr_response_slider[$i] = '';
        }
        else
        {
            $tr_response_img[$i] = '';
            $tr_response_slider[$i] = 'none';
        }
        array_push($selected_mc_id_arr,$selected_mc_id);
    }

    if( ($day == '') || ($month == '') || ($year == '') )
    {
        $error = true;
        $tr_err_mc_date = '';
        $err_mc_date = 'Please select date!';
    }
    elseif(!checkdate($month,$day,$year))
    {
        $error = true;
        $tr_err_mc_date = '';
        $err_mc_date = 'Please select valid date!';
    }
    elseif(mktime(0,0,0,$month,$day,$year) > $now)
    {
        $error = true;
        $tr_err_mc_date = '';
        $err_mc_date = 'Please select today or previous date!';
    }
    else
    {
        $mc_date = $year.'-'.$month.'-'.$day;
        list($arr_mc_id,$arr_situation,$arr_situation_font_family,$arr_situation_font_size,$arr_situation_font_color) = getMCQuestions($user_id,$mc_date,$pro_user_id);
    }

    if($empty_selected_mc_id_arr)
    {
        $error = true;
        $err_msg = 'Please tick mark atleast one situation checkbox below!';
    }
    else
    {
        for($i=0;$i<count($selected_mc_id_arr);$i++)
        {
            $temp_err = '';
            $temp_tr_err = 'none';

            if($scale_arr[$i] != '0')  
            {
                if($selected_mc_id_arr[$i] == '')  
                {
                    $error = true;
                    $temp_tr_err = '';
                    $temp_err = 'Please tick mark the situation checkbox below!';
                }	
            }			
            array_push($tr_err_mc , $temp_tr_err);
            array_push($err_mc , $temp_err);	
        }
    }
    
    if(!$error)
    {
        $addUsersMCQuestion = addUsersMCQuestion($user_id,$mc_date,$selected_mc_id_arr,$scale_arr,$remarks_arr,$my_target_arr,$adviser_target_arr,$pro_user_id);
        if($addUsersMCQuestion)
        {
          header("Location: message.php?msg=14");  
/*
//header("Location: message.php?msg=14&gotopage=".$page_id); 
            header("Location: my_wellness_solutions.php?mid=".$page_id."&date=".$mc_date); 
            exit(0);
*/
        }
        else
        {
            $error = true;
            $err_msg = 'There is some problem right now!Please try again later';
        }
    }
    
    if($err_msg != '')
    {
        $err_msg = '<div class="err_msg_box"><span class="blink_me">'.$err_msg.'</span></div>';
    }
}
else
{
    $year = $today_year;
    $month = $today_month;
    $day = $today_day;

    $bg_color_code = '#339900';
    $bg_image = '';

    $mc_date = $year.'-'.$month.'-'.$day;
    list($old_scale_arr,$old_remarks_arr,$old_selected_mc_id_arr,$old_my_target_arr,$old_adviser_target_arr) = getUsersMCQuestionDetails($user_id,$mc_date,$pro_user_id);

    $selected_mc_id_arr = array(); 
    $scale_arr = array(); 
    $remarks_arr = array(); 
    $my_target = array();
    $adviser_target = array();

    $j = 0;
    for($i=0;$i<count($arr_mc_id);$i++)
    {
        if(in_array($arr_mc_id[$i],$old_selected_mc_id_arr))
        {
            $tr_response_img[$i] = 'none';
            $tr_response_slider[$i] = '';
            $selected_mc_id_arr[$i] = $old_selected_mc_id_arr[$j];
            $scale_arr[$i] = $old_scale_arr[$j];
            $remarks_arr[$i] = $old_remarks_arr[$j];
            $my_target_arr[$i] = $old_my_target_arr[$j];
            $adviser_target_arr[$i] = $old_adviser_target_arr[$j];
            $j++;
        }
        else
        {
            $tr_response_img[$i] = '';
            $tr_response_slider[$i] = 'none';
            $selected_mc_id_arr[$i] = '';
            $scale_arr[$i] = 0;
            $remarks_arr[$i] = '';
            list($my_target_arr[$i], $adviser_target_arr[$i]) = getUsersLastMyTargetMCValue($user_id,$pro_user_id,$arr_mc_id[$i]);
        }
    }			
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="<?php echo $meta_description;?>" />
    <meta name="keywords" content="<?php echo $meta_keywords;?>" />
    <meta name="title" content="<?php echo $meta_title;?>" />
    <title><?php echo $meta_title;?></title>
    <link href="cwri.css" rel="stylesheet" type="text/css" />
    <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
    <script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/JavaScript" src="js/commonfn.js"></script>
    <script type="text/javascript" src="js/jquery.bxSlider.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
    <script type="text/javascript" src="js/selectToUISlider.jQuery.js"></script>
    <link rel="stylesheet" href="css/redmond/jquery-ui-1.7.1.custom.css" type="text/css" />
    <link rel="Stylesheet" href="css/ui.slider.extras.css" type="text/css" />
    <link href="css/ticker-style.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery.ticker.js" type="text/javascript"></script>
    <script type="text/javascript"> 
        $(document).ready(function() {
            $('#js-news').ticker({
                controls: true,        // Whether or not to show the jQuery News Ticker controls
                htmlFeed: true, 
                titleText: '',   // To remove the title set this to an empty String
                displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'
                direction: 'ltr'       // Ticker direction - current options are 'ltr' or 'rtl'
            });

            $('#slider1').bxSlider();
                        $('#slider2').bxSlider();
                        $('#slider3').bxSlider();
                        $('#slider4').bxSlider();
                        $('#slider5').bxSlider();
                        $('#slider6').bxSlider();

                        $('#slider_main1').bxSlider();
                        $('#slider_main2').bxSlider();
                        $('#slider_main3').bxSlider();
                        $('#slider_main4').bxSlider();
                        $('#slider_main5').bxSlider();
                        $('#slider_main6').bxSlider();

            $(".QTPopup").css('display','none')

            $(".feedback").click(function(){
                $(".QTPopup").animate({width: 'show'}, 'slow');
            });	

            $(".closeBtn").click(function(){			
                $(".QTPopup").css('display', 'none');
            });	

            var cnt = parseInt($('#cnt').val());
            var abc = new Array(cnt);
            for(var i=0; i < cnt; i++)
            {
                abc[i] = $('#scale_'+i).selectToUISlider().next();
            }	
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center" valign="top">
            <?php include_once('header.php');?>
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
                    <td width="620" align="left" valign="top">
                        
                        <table width="570" align="center" border="0" id="color_code" cellpadding="0" cellspacing="1" bgcolor="<?php echo $bg_color_code; ?>">
                            <tr>
                                <td align="left" valign="top" id="bgimage" background="<?php echo $bg_image; ?>" bgcolor="#FFFFFF" style="background-repeat: repeat; padding:10px;">
                                    <form action="#" id="frmmc" method="post" name="frmmc">
                                        <input type="hidden" name="cnt" id="cnt" value="<?php echo $cnt;?>" />
                                        <table width="570" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td height="50" align="left" valign="top" class="header_title"><?php echo getPageContents($page_id);?></td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="top"><?php echo $err_msg;?></td>
                                            </tr>
                                            <tr>
                                                <td height="50" align="left" valign="top">
                                                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td colspan="4" height="50" align="left" valign="top">
                                                                <table width="550" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td width="50" height="50" align="left" valign="top"><img src="images/icon_fitness.jpg" width="40" height="40" /></td>
                                                                        <td height="50" align="left" valign="middle" class="Header_brown">My Communication</td>
                                                                    </tr>
                                                                </table>       
                                                            </td>
                                                        </tr>
                                                        <tr> 
                                                            <td width="170" height="30" align="left" valign="middle" class="Header_brown">My Digital Diary Notings:</td>
                                                            <td width="150" height="30" align="left" valign="middle">
                                                                <select name="pro_user_id" id="pro_user_id" onchange="getUsersMCQuestionDetails(); updateUserFormTheme();" style="width:120px;">
                                                                    <option value="">Select Option</option>
                                                                    <option value="999999999" <?php if($pro_user_id == '999999999') {?> selected="selected" <?php } ?>>Standard Set</option>
                                                                    <?php echo getUsersAdviserOptions($user_id,$pro_user_id); ?>
                                                                </select>  
                                                            </td>   
                                                            <td width="50" height="30" align="left" valign="middle" class="Header_brown">Date:</td>
                                                            <td width="180" height="30" align="left" valign="middle">
                                                                <select name="day" id="day" onchange="getUsersMCQuestionDetails();" style="width:40px;">
                                                                        <option value="<?php echo $yesterday_day;?>" <?php if($day == $yesterday_day) { ?> selected="selected" <?php } ?>><?php echo $yesterday_day;?></option>
                                                                        <option value="<?php echo $today_day;?>" <?php if($day == $today_day) { ?> selected="selected" <?php } ?>><?php echo $today_day;?></option>
                                                                </select>
                                                                <select name="month" id="month" onchange="getUsersMCQuestionDetails();" style="width:60px;">
                                                                        <?php echo getMonthOptions($month,$yesterday_month,$today_month); ?>
                                                                </select>
                                                                <select name="year" id="year" onchange="getUsersMCQuestionDetails();" style="width:60px;">
                                                                <?php
                                                                for($i=$yesterday_year;$i<=$today_year;$i++)
                                                                { ?>
                                                                        <option value="<?php echo $i;?>" <?php if($year == $i) { ?> selected="selected" <?php } ?>><?php echo $i?></option>
                                                                <?php
                                                                } ?>	
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr id="tr_err_mc_date" style="display:<?php echo $tr_err_mc_date;?>;" valign="top">
                                                            <td align="right" valign="top">&nbsp; </td>
                                                            <td align="right" valign="top">&nbsp; </td>
                                                            <td align="left" colspan="2" class="err_msg" valign="top"><?php echo $err_mc_date;?></td>
                                                        </tr>
                                                    </table>
                                                    <div id="divmc"> 
                                                        <?php echo getUsersMCQuestionDetailsCode($day,$month,$year,$pro_user_id,$user_id,$scale_arr,$remarks_arr,$selected_mc_id_arr,$my_target_arr,$adviser_target_arr);?>                   
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="570" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
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
                        <table width="580" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                    <?php echo getScrollingWindowsCodeMainContent($page_id);?>
                                    <?php echo getPageContents2($page_id);?>
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
            <?php include_once('footer.php');?>
        </td>
    </tr>
</table>
</body>
</html>