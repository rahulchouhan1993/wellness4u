<?php
include('config.php');
$page_id = '114';
$main_page_id = $page_id;
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode($menu_link);
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

/*
if(chkUserPlanFeaturePermission($user_id,'35'))
{
    $page_access = true;
}
else
{
    $page_access = false;
    $page_access = true;
}
 * 
 */
$page_access = true;

$now = time();
$today_year = date("Y",$now);
$today_month = date("m",$now);
$today_day = date("d",$now); 
$bes_date = $today_year.'-'.$today_month.'-'.$today_day;

$yesterday = $now - 86400;
$yesterday_year = date("Y",$yesterday);
$yesterday_month = date("m",$yesterday);
$yesterday_day = date("d",$yesterday); 

$error = false;
$tr_err_bes_date = 'none';
$tr_err_bes = array();
$err_bes_date = '';
$err_bes = array();
$tr_response_img = array();
$tr_response_slider = array();

$arr_bes_time = array();
$bes_prefill_arr = array();
$bms_id_arr = array();

if(isset($_POST['btnSubmit']))	
{
    $day = trim($_POST['day']);
    $month = trim($_POST['month']);
    $year = trim($_POST['year']);
    $cnt = trim($_POST['cnt']);
    $totalRow = trim($_POST['totalRow']);

    list($bes_time,$bes_time_add,$bes_time_rest,$bes_time_cnt,$bes_time_arr_rest,$bes_time_arr) = getMultipleFieldsValueByComma('bes_time');
    list($bes_duration,$bes_duration_add,$bes_duration_rest,$bes_duration_cnt,$bes_duration_arr_rest,$bes_duration_arr) = getMultipleFieldsValueByComma('bes_duration');
    list($scale,$scale_add,$scale_rest,$scale_cnt,$scale_arr_rest,$scale_arr) = getMultipleFieldsValueByComma('scale');
    list($remarks,$remarks_add,$remarks_rest,$remarks_cnt,$remarks_arr_rest,$remarks_arr) = getMultipleFieldsValueBy('remarks');
    list($my_target,$my_target_add,$my_target_rest,$my_target_cnt,$my_target_arr_rest,$my_target_arr) = getMultipleFieldsValueByComma('my_target');
    list($adviser_target,$adviser_target_add,$adviser_target_rest,$adviser_target_cnt,$adviser_target_arr_rest,$adviser_target_arr) = getMultipleFieldsValueByComma('adviser_target');

    if( ($day == '') || ($month == '') || ($year == '') )
    {
        $error = true;
        $tr_err_bes_date = '';
        $err_bes_date = 'Please select date!';
    }
    elseif(!checkdate($month,$day,$year))
    {
        $error = true;
        $tr_err_bes_date = '';
        $err_bes_date = 'Please select valid date!';
    }
    elseif(mktime(0,0,0,$month,$day,$year) > $now)
    {
        $error = true;
        $tr_err_bes_date = '';
        $err_bes_date = 'Please select today or previous date!';
    }
    else
    {
        $bes_date = $year.'-'.$month.'-'.$day;
    }
        
    //echo'<br><pre>';
    //print_r($_POST);
    //echo'<br></pre>';
    
    
    $empty_selected_bms_id_arr = true;
    for($i=0;$i<$cnt;$i++)
    {
        $selected_bes_id = strip_tags(trim($_POST['as_values_bes_id_'.$i]));
        if($selected_bes_id != '')
        {
            $empty_selected_bms_id_arr = false;
            $tr_response_img[$i] = 'none';
            $tr_response_slider[$i] = '';
        }
        else
        {
            $tr_response_img[$i] = '';
            $tr_response_slider[$i] = 'none';
        }
       
    }
    
        
    $bms_id_arr = array();
    
    if($empty_selected_bms_id_arr)
    {
            $error = true;
            $err_msg = 'Please enter atleast one emotional state!';
    }
    else
    {
        for($i=0;$i<$totalRow;$i++)
        {
            $bms_id = strip_tags(trim($_POST['as_values_bes_id_'.$i]));

            $bms_id = str_replace(",", "", $bms_id);
            array_push($bms_id_arr,$bms_id);
            //echo '<br>bms_id = '.$bms_id;
            if($bms_id == '') 
            {
                    array_push($bes_prefill_arr ,'{}');
            }
            else
            { 
                    $json = array();
                    $json['value'] = $bms_id;
                    $json['name'] = getBobyMainSymptomName($bms_id);
                    array_push($bes_prefill_arr ,json_encode($json));
            }	

            $temp_err = '';
            $temp_tr_err = 'none';


            if( ($bms_id == '') )
            {
                //$error = true;
                //$temp_tr_err = '';
                //$temp_err = 'Please enter your emotional state item!';
            }
            elseif(!chkBMSExists($bms_id))
            {
                $error = true;
                $temp_tr_err = '';
                $temp_err = 'Sorry this symptom is not available.Please select item from auto suggest list!';
            }
            
            if($temp_err != '')
            {
                $temp_err = '<div class="err_msg_box"><span class="blink_me">'.$temp_err.'</span></div>';
            }


            array_push($tr_err_bes , $temp_tr_err);
            array_push($err_bes , $temp_err);	
        }
    }    
        
    if(!$error)
    {

            $addUsersBES = addUsersBES($user_id,$bes_date,$bms_id_arr,$scale_arr,$remarks_arr,$bes_time_arr,$bes_duration_arr,$my_target_arr,$adviser_target_arr);
            if($addUsersBES)
            {
                header("Location: message.php?msg=2"); 
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

    $bes_date = $year.'-'.$month.'-'.$day;
    list($bms_id_arr,$scale_arr,$remarks_arr,$bes_time_arr,$bes_duration_arr,$my_target_arr,$adviser_target_arr) = getUsersBESDetails($user_id,$bes_date);
    
    if(count($bms_id_arr)> 0)
    {
        for($i=0;$i<count($bms_id_arr);$i++)
        {
            $tr_response_img[$i] = '';
            $tr_response_slider[$i] = 'none';
            
            $json = array();
            $json['value'] = $bms_id_arr[$i];
            $json['name'] = getBobyMainSymptomName($bms_id_arr[$i]);
            array_push($bes_prefill_arr ,json_encode($json));
        }
        
        $cnt = count($bms_id_arr);
        $totalRow = count($bms_id_arr);
    }
    else
    {
        $cnt = '1';
        $totalRow = '1';
        $tr_err_bes[0] = 'none';
        $tr_other_activity[0] = 'none';
        $err_bes[0] = '';
        array_push($bes_prefill_arr ,'{}');
        $tr_response_img[0] = '';
        $tr_response_slider[0] = 'none';
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
    
    
    
    <script type="text/JavaScript" src="js/jquery.autoSuggestBES.js"></script>
	<link href="css/autoSuggest.css" rel="stylesheet" type="text/css" />
        
        <script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
    <script type="text/javascript" src="js/selectToUISlider.jQuery.js"></script>
    <link rel="stylesheet" href="css/redmond/jquery-ui-1.7.1.custom.css" type="text/css" />
    <link rel="Stylesheet" href="css/ui.slider.extras.css" type="text/css" />
         
    <style type="text/css">@import "css/jquery.datepick.css";</style> 
    <script type="text/javascript" src="js/jquery.datepick.js"></script>
    
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
			
			$("#feedback_reply").click(function(){
				$(".QTPopup").animate({width: 'show'}, 'slow');
			});	
			
			$(".closeBtn").click(function(){
				$(".QTPopup").css('display', 'none');
			});
                        
                        $(".mins").live("blur",function (event) {
				$(this).val( $(this).val().replace(/[^0-9\']/g,'') ); 
			});
			
			$(".mins").live("keyup",function (event) {
				$(this).val( $(this).val().replace(/[^0-9\']/g,'') ); 
			});
                        
                        var cnt = parseInt($('#cnt').val());
                        var totalRow = parseInt($('#totalRow').val());
			var abc = new Array(cnt);
			for(var i=0; i < cnt; i++)
			{
				abc[i] = $('#scale_'+i).selectToUISlider().next();
			}
                        
                        var data = {items:<?php echo getBESAutoList(); ?>};
			var bes_prefill_arr = new Array(<?php echo count($bes_prefill_arr);?>);
			<?php 
			for($m=0;$m<count($bes_prefill_arr);$m++)
			{ ?>
				bes_prefill_arr[<?php echo $m;?>] = <?php echo getPreFillList($bes_prefill_arr[$m]) ; ?>;
			<?php
			} ?>
			
			for(var i=0; i < cnt; i++)
			{
                                $("#bes_id_"+i).autoSuggest(data.items, {asHtmlID:"bes_id_"+i, preFill: bes_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "bes_id_"+i });
			}	

			$('#addMoreBES').click(function() {
				var cnt = parseInt($('#cnt').val());
				var totalRow = parseInt($('#totalRow').val());
                                
                                //alert(cnt);
                                link='remote.php?action=getaddmorebes&cnt='+cnt;
                                var linkComp = link.split( "?");
                                var result;
                                var obj = new ajaxObject(linkComp[0], fin);
                                obj.update(linkComp[1],"POST");
                                obj.callback = function (responseTxt, responseStat) {
                                    // we'll do something to process the data here.
                                    result2 = responseTxt;
                                    //alert(result2);
                                    $('#tblbes tr[id="add_before_this_bes"]').before(result2);
                                    //$('#tblbes tr[id="add_before_this_bes"]').before('<?php echo $add_more_string;?>'+'<tr id="tr_bes_12_'+cnt+'" class="tr_bes_'+cnt+'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMultipleRows(\'tr_bes_'+cnt+'\',\'totalRow\')" /></td></tr><tr id="tr_bes_13_'+cnt+'" class="tr_bes_'+cnt+'"><td height="30" align="left" colspan="2" valign="top">&nbsp;</td></tr>');
                                    $("#bes_id_"+cnt).autoSuggest(data.items, {asHtmlID:"bes_id_"+cnt, preFill: {}, selectedItemProp: "name", searchObjProps: "name"  , selectedValuesProp: "value", extraParams: "bes_id_"+cnt});
                                    
                                    
                                      bcd = $('#scale_'+cnt).selectToUISlider().next();
                                       
                                    

                                    cnt = cnt + 1;       
                                    $('#cnt').val(cnt);
                                    //alert($('#cnt').val())
                                    totalRow = totalRow + 1;       
                                    $('#totalRow').val(totalRow);
                                    
                                }
				
			});
                        
                        
                        var getUsersBESDetails = function() {
                            var day = document.getElementById('day').value;
                            var month = document.getElementById('month').value;
                            var year = document.getElementById('year').value;
                            link='remote.php?action=getusersbesdetails&day='+day+'&month='+month+'&year='+year;
                            var linkComp = link.split( "?");
                            var result;
                            var obj = new ajaxObject(linkComp[0], fin);
                            obj.update(linkComp[1],"POST");
                            obj.callback = function (responseTxt, responseStat) {
                                // we'll do something to process the data here.
                                result = responseTxt;
                                //alert(result);
                                temparr = result.split("####");

                                document.getElementById('divbes').innerHTML = temparr[0];  
                                $('#cnt').val(temparr[1]);
                                $('#totalRow').val(temparr[1]);

                                var cnt = parseInt($('#cnt').val());
                                var new_bes_prefill_arr = new Array(cnt);
                                if( (temparr[2] == '') || (temparr[2] == '{}') )
                                {
                                }
                                else
                                {
                                    new_bes_prefill_arr = temparr[2].split('***');
                                }
                                
                                var abc = new Array(cnt);

                                for(var i=0; i < cnt; i++)
                                {
                                    if (new_bes_prefill_arr[i] == undefined)
                                    {
                                        new_bes_prefill_arr[i] = '{}';
                                    }	
                                    //alert("new: "+new_breakfast_prefill_arr[i]);
                                    bes_prefill_arr[i] = JSON.parse(new_bes_prefill_arr[i]);
                                    $("#bes_id_"+i).autoSuggest(data.items, {asHtmlID:"bes_id_"+i, preFill: bes_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "bes_id_"+i });
                                    abc[i] = $('#scale_'+i).selectToUISlider().next();
                                }
                                
                                $('#addMoreBES').click(function() {
                                        var cnt = parseInt($('#cnt').val());
                                        var totalRow = parseInt($('#totalRow').val());

                                        //alert(cnt);
                                        link='remote.php?action=getaddmorebes&cnt='+cnt;
                                        var linkComp = link.split( "?");
                                        var result;
                                        var obj = new ajaxObject(linkComp[0], fin);
                                        obj.update(linkComp[1],"POST");
                                        obj.callback = function (responseTxt, responseStat) {
                                            // we'll do something to process the data here.
                                            result2 = responseTxt;
                                            //alert(result2);
                                            $('#tblbes tr[id="add_before_this_bes"]').before(result2);
                                            //$('#tblbes tr[id="add_before_this_bes"]').before('<?php echo $add_more_string;?>'+'<tr id="tr_bes_12_'+cnt+'" class="tr_bes_'+cnt+'"><td align="right" colspan="2" valign="top"><input type="button" value="Remove Item" onclick="removeMultipleRows(\'tr_bes_'+cnt+'\',\'totalRow\')" /></td></tr><tr id="tr_bes_13_'+cnt+'" class="tr_bes_'+cnt+'"><td height="30" align="left" colspan="2" valign="top">&nbsp;</td></tr>');
                                            $("#bes_id_"+cnt).autoSuggest(data.items, {asHtmlID:"bes_id_"+cnt, preFill: {}, selectedItemProp: "name", searchObjProps: "name"  , selectedValuesProp: "value", extraParams: "bes_id_"+cnt});


                                              bcd = $('#scale_'+cnt).selectToUISlider().next();



                                            cnt = cnt + 1;       
                                            $('#cnt').val(cnt);
                                            //alert($('#cnt').val())
                                            totalRow = totalRow + 1;       
                                            $('#totalRow').val(totalRow);

                                        }

                                });

                                
                            }
			}

			$("#day").change(getUsersBESDetails);
			$("#month").change(getUsersBESDetails);
			$("#year").change(getUsersBESDetails);
                        
                        
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
                    <td width="620" align="center" valign="top">
                    	
                    <?php
                    
                    if($page_access)
                    { ?>
                        
                        <table width="580" border="0" align="center" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td align="left" valign="top"><span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br /><br /><?php echo getPageContents($page_id);?></td>
                            </tr>
                        </table>
                        
                        
                        <table width="580" align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
                            <tr>
                                <td align="left" valign="top" bgcolor="#FFFFFF" style="background-repeat:repeat-x; padding:10px;">
                                    <form action="#" id="frmdaily_meal" method="post" name="frmdaily_meal">
                                        <input type="hidden" name="cnt" id="cnt" value="<?php echo $cnt;?>" />
                                        <input type="hidden" name="totalRow" id="totalRow" value="<?php echo $totalRow;?>" />
                                        <table width="570" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td height="30" align="left" valign="top">
                                                    <table width="570" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="10%" height="50" align="left" valign="middle" class="Header_brown">Date:</td>
                                                            <td width="90%" height="50" align="left" valign="middle">
                                                                <select name="day" id="day">
                                                                    <option value="<?php echo $yesterday_day;?>" <?php if($day == $yesterday_day) { ?> selected="selected" <?php } ?>><?php echo $yesterday_day;?></option>
                                                                    <option value="<?php echo $today_day;?>" <?php if($day == $today_day) { ?> selected="selected" <?php } ?>><?php echo $today_day;?></option>
                                                                </select>
                                                                <select name="month" id="month">
                                                                    <?php echo getMonthOptions($month,$yesterday_month,$today_month); ?>
                                                                </select>
                                                                <select name="year" id="year">
                                                                <?php
                                                                for($i=$yesterday_year;$i<=$today_year;$i++)
                                                                { ?>
                                                                    <option value="<?php echo $i;?>" <?php if($year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                                                <?php
                                                                } ?>	
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr id="tr_err_bes_date" style="display:<?php echo $tr_err_bes_date;?>;" valign="top">
                                                            <td align="left" colspan="2" class="err_msg_blink" valign="top"><?php echo $err_bes_date;?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>   
                                            <tr>
                                                <td height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>        
                                            <tr>
                                                <td align="left" valign="top" class="err_msg_blink"><?php echo $err_msg;?></td>
                                            </tr>            
                                            <tr>
                                                <td align="left" valign="top" id="divbes">          
                                                    
                                                    <table width="550" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="left" valign="top">
                                                                <table width="550" border="0" cellspacing="0" cellpadding="0" id="tblbes">
                                                                <?php
                                                                for($i=0;$i<$totalRow;$i++)
                                                                { ?>
                                                                    <tr id="tr_bes_1_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td width="150" height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Time:</td>
                                                                        <td width="400" height="35" align="left" valign="top">
                                                                            <select name="bes_time[]" id="bes_time_<?php echo $i;?>">
                                                                                <option value="">Select Time</option>
                                                                                <?php echo getTimeOptionsNew('0','23',$bes_time_arr[$i] ); ?>
                                                                            </select>
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;Duration in Mins:&nbsp;&nbsp<input style="width:30px;" type="text" maxlength="3" name="bes_duration[]" id="bes_duration_<?php echo $i;?>" value="<?php echo $bes_duration_arr[$i];?>" class="mins">
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="tr_bes_2_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                    </tr>
                                                                    <tr id="tr_bes_3_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td height="35" align="left" valign="top">&nbsp;&nbsp;&bull; Emotional State:</td>
                                                                        <td height="35" align="left" valign="top">
                                                                            <input name="bes_id[]" type="text" class="input" id="bes_id_<?php echo $i;?>" value="<?php echo $bms_id_arr[$i];?>" />
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="tr_bes_4_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                    </tr>
                                                                    <tr id="tr_bes_5_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td height="37" align="left" valign="top">&nbsp;&bull; My Scale:</td>
                                                                        <td height="37" align="left" valign="top" background="images/blank_slider.jpg" style="background-repeat:no-repeat;">
                                                                            <?php echo getScaleSliderCode($i,$tr_response_img[$i],$tr_response_slider[$i],$scale_arr[$i]);?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="tr_bes_6_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                    </tr>
                                                                    <tr id="tr_bes_7_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td align="left" valign="top">&nbsp;&nbsp;&bull; Triggers/Reasons:</td>
                                                                        <td align="left" valign="top">
                                                                            <div class="tr_response_slider_<?php echo $i;?>" style="display:<?php echo $tr_response_slider[$i];?>">
                                                                                <textarea name="remarks[]" id="remarks_<?php echo $i; ?>" cols="25" rows="3"><?php echo $remarks_arr[$i];?></textarea>
                                                                            </div>
                                                                            <div class="tr_response_img_<?php echo $i;?>" style="display:<?php echo $tr_response_img[$i];?>">
                                                                                <textarea name="remarks2[]" id="remarks2_<?php echo $i; ?>" cols="25" rows="3" disabled><?php echo $remarks_arr[$i];?></textarea>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="tr_bes_8_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                    </tr>
                                                                    <tr id="tr_bes_9_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td align="left" colspan="2" valign="top">
                                                                            <table width="550" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td width="150" align="left" valign="top">&nbsp;&bull; My Target:</td>
                                                                                    <td width="130" align="left" valign="top">
                                                                                        <div class="tr_response_slider_<?php echo $i;?>" style="display:<?php echo $tr_response_slider[$i];?>">
                                                                                            <select name="my_target[]" id="my_target_<?php echo $i;?>">
                                                                                                <option value="" <?php if($my_target_arr[$i] == "") {?> selected="selected" <?php } ?>>Select</option>
                                                                                            <?php
                                                                                            for($j=1;$j<=10;$j++)
                                                                                            { ?>
                                                                                                <option value="<?php echo $j;?>" <?php if($my_target_arr[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                                                                            <?php
                                                                                            } ?>    
                                                                                            </select><br>
                                                                                        </div>
                                                                                        <div class="tr_response_img_<?php echo $i;?>" style="display:<?php echo $tr_response_img[$i];?>">
                                                                                            <select name="my_target2[]" id="my_target2_<?php echo $i;?>" disabled>
                                                                                                <option value="" <?php if($my_target_arr[$i] == "") {?> selected="selected" <?php } ?>>Select</option>
                                                                                            <?php
                                                                                            for($j=1;$j<=10;$j++)
                                                                                            { ?>
                                                                                                <option value="<?php echo $j;?>" <?php if($my_target_arr[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                                                                            <?php
                                                                                            } ?>    
                                                                                            </select><br>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td width="130" align="left" valign="top">&nbsp;&bull; Adviser Set Target:</td>
                                                                                    <td width="140" align="left" valign="top">
                                                                                        <div class="tr_response_slider_<?php echo $i;?>" style="display:<?php echo $tr_response_slider[$i];?>">
                                                                                            <select name="adviser_target[]" id="adviser_target_<?php echo $i;?>">
                                                                                                <option value="" <?php if($adviser_target_arr[$i] == "") {?> selected="selected" <?php } ?>>Select</option>
                                                                                            <?php
                                                                                            for($j=1;$j<=10;$j++)
                                                                                            { ?>
                                                                                                <option value="<?php echo $j;?>" <?php if($adviser_target_arr[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                                                                            <?php
                                                                                            } ?>    
                                                                                            </select><br>
                                                                                        </div>
                                                                                        <div class="tr_response_img_<?php echo $i;?>" style="display:<?php echo $tr_response_img[$i];?>">
                                                                                            <select name="adviser_target2[]" id="adviser_target2_<?php echo $i;?>" disabled>
                                                                                                <option value="" <?php if($adviser_target_arr[$i] == "") {?> selected="selected" <?php } ?>>Select</option>
                                                                                            <?php
                                                                                            for($j=1;$j<=10;$j++)
                                                                                            { ?>
                                                                                                <option value="<?php echo $j;?>" <?php if($adviser_target_arr[$i] == $j) {?> selected="selected" <?php } ?>><?php echo $j;?></option>
                                                                                            <?php
                                                                                            } ?>    
                                                                                            </select><br>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="tr_bes_10_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td align="left" colspan="2" class="err_msg" valign="top"><?php echo $err_bes[$i];?></td>
                                                                    </tr>
                                                                    <tr id="tr_bes_11_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td align="left" colspan="2" valign="top">&nbsp;</td>
                                                                    </tr>
                                                                    
                                                                    <?php
                                                                    if($i > 0)
                                                                    { ?>
                                                                    <tr id="tr_bes_12_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td align="right" colspan="2" valign="top">
                                                                            <input type="button" value="Remove Item" onclick="removeMultipleRows('tr_bes_<?php echo $i;?>','totalRow');?>')"/>
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="tr_bes_13_<?php echo $i;?>" class="tr_bes_<?php echo $i;?>">
                                                                        <td height="30" align="left" colspan="2" valign="top">&nbsp;</td>
                                                                    </tr>
                                                                    <?php
                                                                    } 
                                                                } ?>
                                                                    <tr id="add_before_this_bes">
                                                                        <td height="30" align="left" valign="top">&nbsp;</td>
                                                                        <td height="30" align="left" valign="top">
                                                                            <input type="button" value="add more" id="addMoreBES" name="addMoreBES" />
                                                                        </td>
                                                                    </tr>	
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="550" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="100" height="35" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                        </table>
                                        <table width="550" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="150" height="35" align="left" valign="top">&nbsp;</td>
                                                <td width="400" align="left" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /></td>
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
                    <?php 
                    } 
                    else 
                    { ?>
                        <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr align="center">
                                <td height="5" class="Header_brown"><?php echo getCommonSettingValue('3');?></td>
                            </tr>
                        </table>
                    <?php 
                    } ?>
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
            <?php include_once('footer.php'); ?>
	</td>
    </tr>
</table>
</body>
</html>