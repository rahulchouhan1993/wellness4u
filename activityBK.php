<?php
include('config.php');
$page_id = '12';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$ref = base64_encode('activity.php');
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

$flagnewdate = false;
$now = time();
$today_year = date("Y",$now);
$today_month = date("m",$now);
$today_day = date("j",$now); 
$yesterday = $now - 86400;
$yesterday_year = date("Y",$yesterday);
$yesterday_month = date("m",$yesterday);
$yesterday_day = date("j",$yesterday);

$activity_start_time = '0';
$activity_end_time = '24';

$error = false;
$tr_err_activity_date = 'none';
$tr_err_activity = array();
$tr_other_activity = array();
$err_activity_date = '';
$err_activity = array();
$activity_prefill_arr = array();
$proper_guidance_arr = array();
$skip_time_arr = array();

if(isset($_POST['today_wakeup_time']))	
{
	$day = trim($_POST['day']);
	$month = trim($_POST['month']);
	$year = trim($_POST['year']);
	$yesterday_sleep_time = trim($_POST['yesterday_sleep_time']);
	$today_wakeup_time = trim($_POST['today_wakeup_time']);

	list($activity_time,$activity_time_add,$activity_time_rest,$activity_time_cnt,$activity_time_arr_rest,$activity_time_arr) = getMultipleFieldsValueByComma('activity_time');
	list($other_activity,$other_activity_add,$other_activity_rest,$other_activity_cnt,$other_activity_arr_rest,$other_activity_arr) = getMultipleFieldsValueByComma('other_activity');
	list($precaution,$precaution_add,$precaution_rest,$precaution_cnt,$precaution_arr_rest,$precaution_arr) = getMultipleFieldsValueBy('precaution');
	list($mins,$mins_add,$mins_rest,$mins_cnt,$mins_arr_rest,$mins_arr) = getMultipleFieldsValueByComma('mins');
	list($skip_time,$skip_time_add,$skip_time_rest,$skip_time_cnt,$skip_time_arr_rest,$skip_time_arr) = getMultipleFieldsValueByComma('skip_time');
	
	$cnt = $activity_time_cnt;
	$totalRow = $activity_time_cnt;
	if( ($day == '') || ($month == '') || ($year == '') )
	{
		$error = true;
		$tr_err_activity_date = '';
		$err_activity_date = 'Please select date!';
	}
	elseif(!checkdate($month,$day,$year))
	{
		$error = true;
		$tr_err_activity_date = '';
		$err_activity_date = 'Please select valid date!';
	}
	elseif(mktime(0,0,0,$month,$day,$year) > $now)
	{
		$error = true;
		$tr_err_activity_date = '';
		$err_activity_date = 'Please select today or previous date!';
	}
	else
	{
		$activity_date = $year.'-'.$month.'-'.$day;
	}
	
	if($today_wakeup_time == '')
	{
		$error = true;
		$tr_err_today_wakeup_time = '';
		$err_today_wakeup_time = 'Please select today wakeup time!';
	}
	
	//Validations for activity - START
	
	$activity_empty = true;
		
	$activity_id_arr = array();
	for($i=0;$i<$totalRow;$i++)
	{
		$activity_id = strip_tags(trim($_POST['as_values_activity_id_'.$i]));
		$activity_id = str_replace(",", "", $activity_id);
		array_push($activity_id_arr,$activity_id);
		
		list($temp_proper_guidance,$temp_proper_guidance_add,$temp_proper_guidance_rest,$temp_proper_guidance_cnt,$temp_proper_guidance_arr_rest,$temp_proper_guidance_arr) = getMultipleFieldsValueByComma('proper_guidance_'.$i);

		if($activity_id == '') 
		{
			array_push($activity_prefill_arr ,'{}');
		}
		else
		{ 
			$json = array();
			$json['value'] = $activity_id;
			$json['name'] = getDailyActivityName($activity_id);
			array_push($activity_prefill_arr ,json_encode($json));
		}	
			
		$temp_err = '';
		$temp_tr_err = 'none';
		
		if( ($mins_arr[$i] == '') || ($mins_arr[$i] == '0') )
		{
			if($activity_id == '') 
			{
				
			}
			elseif($activity_id == '9999999999')
			{
				$activity_empty = false;	
				$tr_other_activity[$i] = '';
				if($other_activity_arr[$i] == '')
				{
					$error = true;
					if($temp_tr_err == 'none')
					{
						$temp_tr_err = '';
						$temp_err = 'Please enter other activity!';
					}
					else
					{
						$temp_err .= '<br>Please enter other activity!';
					}
				}
				
				$error = true;
				if($temp_tr_err == 'none')
				{
					$temp_tr_err = '';
					$temp_err = 'Please select time duration!';
				}
				else
				{
					$temp_err .= '<br>Please select time duration!';
				}
			
			}
			elseif(!chkActivityItemExists($activity_id))
			{
				$activity_empty = false;
				$tr_other_activity[$i] = 'none';
				$error = true;
				if($temp_tr_err == 'none')
				{
					$temp_tr_err = '';
					$temp_err = 'Sorry this item is not available.Please select item from auto suggest list!';
				}
				else
				{
					$temp_err .= '<br>Sorry this item is not available.Please select item from auto suggest list!';
				}
				
				$error = true;
				if($temp_tr_err == 'none')
				{
					$temp_tr_err = '';
					$temp_err = 'Please select time duration!';
				}
				else
				{
					$temp_err .= '<br>Please select time duration!';
				}
			}
			else
			{
				$activity_empty = false;
				$error = true;
				if($temp_tr_err == 'none')
				{
					$temp_tr_err = '';
					$temp_err = 'Please select time duration!';
				}
				else
				{
					$temp_err .= '<br>Please select time duration!';
				}
			}
		}
		else
		{
			$activity_empty = false;
			if($activity_id == '') 
			{
				$tr_other_activity[$i] = 'none';
				$error = true;
				if($temp_tr_err == 'none')
				{
					$temp_tr_err = '';
					$temp_err = 'Please enter activity!';
				}
				else
				{
					$temp_err .= '<br>Please enter activity!';
				}	
			}
			elseif($activity_id == '9999999999')
			{
				$tr_other_activity[$i] = '';
				if($other_activity_arr[$i] == '')
				{
					$error = true;
					if($temp_tr_err == 'none')
					{
						$temp_tr_err = '';
						$temp_err = 'Please enter other activity!';
					}
					else
					{
						$temp_err .= '<br>Please enter other activity!';
					}
				}
			}
			elseif(!chkActivityItemExists($activity_id))
			{
				$tr_other_activity[$i] = 'none';
				$error = true;
				if($temp_tr_err == 'none')
				{
					$temp_tr_err = '';
					$temp_err = 'Sorry this item is not available.Please select item from auto suggest list!';
				}
				else
				{
					$temp_err .= '<br>Sorry this item is not available.Please select item from auto suggest list!';
				}
			}
			else
			{
				if($temp_proper_guidance_cnt == 0)
				{
					//$error = true;
					//if($temp_tr_err == 'none')
					//{
					//	$temp_tr_err = '';
					//	$temp_err = 'Please select proper guidance!';
					//}
					//else
					//{
					//	$temp_err .= '<br>Please select proper guidance!';
					//}	
					array_push($proper_guidance_arr , '');
				}
				else
				{
					array_push($proper_guidance_arr , $temp_proper_guidance_arr[0] );
				}
			}	
		}		
		array_push($tr_err_activity , $temp_tr_err);
		array_push($err_activity , $temp_err);	
	}
	//Validations for activity - END	

	if(!$error)
	{
		if($activity_empty)
		{
			$error = true;
			$err_msg = 'Please enter atleast one entry!';
		}
		else
		{
			$addUsersDailyActivity = addUsersDailyActivity($user_id,$activity_date,$activity_id_arr,$other_activity_arr,$activity_time_arr,$mins_arr,$proper_guidance_arr,$precaution_arr,$yesterday_sleep_time,$today_wakeup_time);
			if($addUsersDailyActivity)
			{
			header("Location: message.php?msg=14");	
/*
//header("Location: message.php?msg=14&gotopage=".$page_id); 
                                header("Location: my_wellness_solutions.php?mid=".$page_id."&date=".$activity_date); 
                                exit(0);
*/
			}
			else
			{
				$error = true;
				$err_msg = 'There is some problem right now!Please try again later';
			}
		}	
	}
}
else
{
	$year = $today_year;
	$month = $today_month;
	$day = $today_day;

	$activity_date = $year.'-'.$month.'-'.$day;

	list($yesterday_sleep_time,$today_wakeup_time,$mins_arr,$activity_id_arr,$other_activity_arr,$proper_guidance_arr,$precaution_arr,$activity_time_arr) = getUsersDailyActivityDetails($user_id,$activity_date);
	
	if(count($mins_arr)> 0)
	{
		$flagnewdate = true;
		$cnt = count($mins_arr);
		$totalRow = count($mins_arr);
		
		for($i=0;$i<$cnt;$i++)
		{
			$skip_time_arr[$i] = $activity_time_arr[$i];
			$tr_err_activity[$i] = 'none';
			$err_activity[$i] = '';

			if($activity_id_arr[$i] == '9999999999')
			{
				$tr_other_activity[$i] = '';
				$json = array();
				$json['value'] = $activity_id_arr[$i];
				$json['name'] = getDailyActivityName($activity_id_arr[$i]);
				array_push($activity_prefill_arr ,json_encode($json));
			}
			elseif( ($activity_id_arr[$i] == '') || ($activity_id_arr[$i] == '0') )
			{
				$tr_other_activity[$i] = 'none';
				array_push($activity_prefill_arr ,'{}');
			}
			else
			{
				$tr_other_activity[$i] = 'none';
				$json = array();
				$json['value'] = $activity_id_arr[$i];
				$json['name'] = getDailyActivityName($activity_id_arr[$i]);
				array_push($activity_prefill_arr ,json_encode($json));
			}	
		}	
		array_push($activity_id_arr ,'0');
		array_push($mins_arr ,'');
		array_push($activity_prefill_arr ,'{}');
		$cnt++;
		$totalRow++;
	}
	else
	{
		$cnt = '1';
		$totalRow = '1';
		$tr_err_activity[0] = 'none';
		$tr_other_activity[0] = 'none';
		$err_activity[0] = '';
		array_push($activity_prefill_arr ,'{}');
		$skip_time_arr[0] = $today_wakeup_time;
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
    <script type="text/JavaScript" src="js/jquery.autoSuggestActivity.js"></script>
    <link href="css/autoSuggest.css" rel="stylesheet" type="text/css" />
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
                var totalRow = parseInt($('#totalRow').val());
                var data = {items:<?php echo getActivityAutoList(); ?>};
                var activity_prefill_arr = new Array(<?php echo count($activity_prefill_arr);?>);

                <?php 
                for($m=0;$m<count($activity_prefill_arr);$m++)
                { ?>
                    activity_prefill_arr[<?php echo $m;?>] = <?php echo getPreFillList($activity_prefill_arr[$m]) ; ?>;
                <?php
                } ?>

                for(var i=0; i < cnt; i++)
                {
                    $("#activity_id_"+i).autoSuggest(data.items, {asHtmlID:"activity_id_"+i, preFill: activity_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "activity_id_"+i });
                }	

                $(".mins").live("blur",function (event) {
                    $(this).val( $(this).val().replace(/[^0-9\']/g,'') ); 
                });

                $(".mins").live("keyup",function (event) {
                    $(this).val( $(this).val().replace(/[^0-9\']/g,'') ); 
                });

                var getActivitiesRows = function() {

                        var today_wakeup_time = document.getElementById('today_wakeup_time').value;
                        var flagnewdate = document.getElementById('flagnewdate').value;

                        if(today_wakeup_time == '')
                        {
                                alert('Please select today wakeup time');
                                return false;
                        } 
                        else
                        {
                                var cnt = parseInt($('#cnt').val());
                                //alert(cnt);
                                var mins_id_arr = new Array(cnt);
                                var activity_id_arr = new Array(cnt);
                                var other_activity_arr = new Array(cnt);
                                var proper_guidance_arr = new Array(cnt);
                                var precaution_arr = new Array(cnt);
                                var skip_time_arr = new Array(cnt);

                                var tempval = '';
                                var templen = 0;
                                for(var i=0; i < cnt; i++)
                                {
                                        mins_id_arr[i] = $('#mins_'+i).val();
                                        //alert(mins_id_arr[i]);
                                        other_activity_arr[i] = $('#other_activity_'+i).val();
                                        proper_guidance_arr[i] = $('input:radio[id=proper_guidance_'+i+']:checked').val();
                                        precaution_arr[i] = $('#precaution_'+i).val();
                                        skip_time_arr[i] = $('#skip_time_'+i).val();
                                        tempval = $('#as-values-activity_id_'+i).val();
                                        if (tempval == undefined)
                                        {
                                                activity_id_arr[i] = '';
                                        }
                                        else
                                        {
                                                templen = tempval.length; 
                                                //activity_id_arr[i] = tempval.substr(0,templen - 1);
                                                activity_id_arr[i] = tempval.replace(/,/gi, " ");
                                        }	
                                        //alert(activity_id_arr[i]);
                                }

                                var tr_err_activity = new Array(<?php echo count($tr_err_activity);?>);
                                var err_activity = new Array(<?php echo count($tr_err_activity);?>);
                                <?php 
                                for($m=0;$m<count($tr_err_activity);$m++)
                                { ?>
                                        tr_err_activity[<?php echo $m;?>] = '<?php echo $tr_err_activity[$m]; ?>';
                                        err_activity[<?php echo $m;?>] = '<?php echo $err_activity[$m]; ?>';
                                <?php
                                } ?>
                                //startPageLoading();

                                link='remote.php?action=getactivitiesrows&today_wakeup_time='+today_wakeup_time+'&mins_id_arr='+mins_id_arr+'&activity_id_arr='+activity_id_arr+'&other_activity_arr='+other_activity_arr+'&proper_guidance_arr='+proper_guidance_arr+'&precaution_arr='+precaution_arr+'&tr_err_activity='+tr_err_activity+'&err_activity='+err_activity+'&skip_time_arr='+skip_time_arr;

                                var linkComp = link.split( "?");
                                var result;
                                var obj = new ajaxObject(linkComp[0], fin);
                                obj.update(linkComp[1],"GET");
                                obj.callback = function (responseTxt, responseStat) {
                                        // we'll do something to process the data here.
                                        result = responseTxt;
                                        //alert(result);
                                        temparr = result.split('::::');
                                        document.getElementById('activity_diary').innerHTML = temparr[0]; 
                                        $('#cnt').val(temparr[1]);
                                        $('#totalRow').val(temparr[1]);
                                        var cnt = parseInt($('#cnt').val());
                                        var new_activity_prefill_arr = new Array(cnt);
                                        if( (temparr[2] == '') || (temparr[2] == '{}') )
                                        {
                                                for(var i=0; i < cnt; i++)
                                                {
                                                        //new_activity_prefill_arr[i] = '{}';
                                                }	
                                        }
                                        else
                                        {
                                                new_activity_prefill_arr = temparr[2].split('***');
                                        }

                                        for(var i=0; i < new_activity_prefill_arr.length; i++)
                                        {

                                                //alert("new_activity_prefill_arr : ["+i+"] = "+new_activity_prefill_arr[i]);

                                        }

                                        for(var i=0; i < cnt; i++)
                                        {
                                                if (new_activity_prefill_arr[i] == undefined)
                                                {
                                                        new_activity_prefill_arr[i] = '{}';
                                                }	

                                                activity_prefill_arr[i] = JSON.parse(new_activity_prefill_arr[i]);

                                                $("#activity_id_"+i).autoSuggest(data.items, {asHtmlID:"activity_id_"+i, preFill: activity_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "activity_id_"+i });
                                        }
                                        //stopPageLoading();
                                        //$(".mins").change(getActivitiesRows);
                                        //$(".mins").blur(getActivitiesRows);

                                        $(".btnnew").click(getActivitiesRows);
                                        $(".skip_time").change(getActivitiesRows);
                                }
                        }
                }
                //$(".mins").change(getActivitiesRows);
                //$(".mins").blur(getActivitiesRows);

                $("#today_wakeup_time").change(getActivitiesRows);

                $(".skip_time").change(getActivitiesRows);

                var getActivitiesRowsNewDate = function() {

                        var day = document.getElementById('day').value;
                        var month = document.getElementById('month').value;
                        var year = document.getElementById('year').value;

                        if( (day == '') || (month == '') || (year == '') )
                        {
                                alert('Please select valid date');
                                return false;
                        } 
                        else
                        {
                                link='remote.php?action=getactivitiesrowsnewdate&day='+day+'&month='+month+'&year='+year;
                                var linkComp = link.split( "?");
                                var result;
                                var obj = new ajaxObject(linkComp[0], fin);
                                obj.update(linkComp[1],"GET");
                                obj.callback = function (responseTxt, responseStat) {
                                        // we'll do something to process the data here.
                                        result = responseTxt;
                                        //alert(result);
                                        temparr = result.split('::::');
                                        document.getElementById('yesterday_sleep_time').value = temparr[3];
                                        document.getElementById('today_wakeup_time').value = temparr[4];
                                        document.getElementById('activity_diary').innerHTML = temparr[0]; 
                                        $('#cnt').val(temparr[1]);
                                        $('#totalRow').val(temparr[1]);

                                        var cnt = parseInt($('#cnt').val());
                                        var new_activity_prefill_arr = new Array(cnt);
                                        //alert(cnt+" and "+temparr[2]);
                                        if( (temparr[2] == '') || (temparr[2] == '{}') )
                                        {
                                                for(var i=0; i < cnt; i++)
                                                {
                                                        //new_activity_prefill_arr[i] = '{}';
                                                }	
                                        }
                                        else
                                        {
                                                new_activity_prefill_arr = temparr[2].split('***');
                                        }

                                        for(var i=0; i < new_activity_prefill_arr.length; i++)
                                        {
                                                //alert("new_activity_prefill_arr : ["+i+"] = "+new_activity_prefill_arr[i]);
                                        }

                                        for(var i=0; i < cnt; i++)
                                        {
                                                if (new_activity_prefill_arr[i] == undefined)
                                                {
                                                        new_activity_prefill_arr[i] = '{}';
                                                }	

                                                //alert("new: "+new_activity_prefill_arr[i]);
                                                activity_prefill_arr[i] = JSON.parse(new_activity_prefill_arr[i]);

                                                $("#activity_id_"+i).autoSuggest(data.items, {asHtmlID:"activity_id_"+i, preFill: activity_prefill_arr[i], selectedItemProp: "name", searchObjProps: "name", selectedValuesProp: "value", extraParams: "activity_id_"+i });
                                        }
                                        //$(".mins").change(getActivitiesRows);
                                        //$(".mins").blur(getActivitiesRows);
                                        $(".skip_time").change(getActivitiesRows);
                                }
                        }
                }

                $("#day").change(getActivitiesRowsNewDate);
                $("#month").change(getActivitiesRowsNewDate);
                $("#year").change(getActivitiesRowsNewDate);
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
                        <table width="590" align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
                            <tr>
                                <td align="center" valign="top" bgcolor="#FFFFFF" style="background-repeat:repeat-x; padding:10px;">
                                    <form action="#" id="frmactivity" method="post" name="frmactivity" onsubmit="return validateActivityForm();">
                                        <input type="hidden" name="flagnewdate" id="flagnewdate" value="<?php echo $flagnewdate;?>" />
                                        <input type="hidden" name="cnt" id="cnt" value="<?php echo $cnt;?>" />
                                        <input type="hidden" name="totalRow" id="totalRow" value="<?php echo $totalRow;?>" />
                                        <table width="570" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="4" height="50" align="left" valign="top" class="header_title"><?php echo getPageContents($page_id);?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="left" valign="top" class="err_msg"><?php echo $err_msg;?></td>
                                            </tr>
                                            <tr>
                                                <td width="50" height="60" align="left" valign="middle"><img src="images/icon_fitness.jpg" width="40" height="40" /></td>
                                                <td width="260" height="60" align="left" valign="middle" class="Header_brown">Daily Activity</td>
                                                <td width="50" height="60" align="left" valign="middle" class="Header_brown">&nbsp;</td>
                                                <td width="210" height="60" align="left" valign="middle" class="Header_brown">&nbsp;</td>
                                            </tr>
                                        </table>
                                        <table width="570" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td height="40" align="left" valign="middle"><strong>Date:</strong></td>
                                                <td height="40" align="left" valign="middle">
                                                    <span class="Header_brown">
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
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="155" height="40" align="left" valign="middle"><strong>Yesterday's Sleep time:</strong></td>
                                                <td width="415" height="40" align="left" valign="middle">
                                                    <span class="border_bottom">
                                                        <select name="yesterday_sleep_time" id="yesterday_sleep_time">
                                                            <option value="">Select Time</option>
                                                            <?php echo getTimeOptionsNew('18','5',$yesterday_sleep_time); ?>
                                                        </select>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="40" align="left" valign="middle"><strong>Today's Wake-up time:</strong></td>
                                                <td height="40" align="left" valign="middle">
                                                    <span class="border_bottom">
                                                        <select name="today_wakeup_time" id="today_wakeup_time">
                                                            <option value="">Select Time</option>
                                                            <?php echo getTimeOptionsNew('1','13',$today_wakeup_time); ?>
                                                        </select>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                        <div id="activity_diary">
                                            <?php echo getActivitiesRows($today_wakeup_time,$mins_arr,$activity_id_arr,$other_activity_arr,$proper_guidance_arr,$precaution_arr,$tr_err_activity,$err_activity,$skip_time_arr);?>
                                        </div>
                                        <table width="570" border="0" cellspacing="0" cellpadding="0">
                                            <tr align="left">
                                                <td height="20" colspan="4" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="21" height="35" align="center" valign="middle">&nbsp;</td>
                                                <td width="62" height="35" align="center" valign="middle">&nbsp;</td>
                                                <td width="427" height="35" align="left" valign="middle"><input type="button" name="btnSubmit" id="btnSubmit" value="Submit" onclick="validateActivityForm();" /></td>
                                                <td width="80" height="35" align="center" valign="middle">&nbsp;</td>
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
            <?php include_once('footer.php');?>
        </td>
    </tr>
</table>
<div id="page_loading_bg" class="page_loading_bg" style="display:none;">
    <div id="page_loading_img" class="page_loading_img"><img border="0" src="<?php echo SITE_URL;?>/images/loading.gif" /></div>
</div> 
</body>
</html>