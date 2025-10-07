<?php
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };
@set_time_limit(1000000);
include('config.php');
$page_id = '61';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('my_rewards.php');
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

if(chkUserPlanFeaturePermission($user_id,'34'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}

$return = false;
$error = false;
$tr_err_date = 'none';
$err_date = '';

$idmonthwisechart = 'none';

$summary_cnt = 0;

if(isset($_POST['btnSubmit']))	
{
	$start_day = '1';
	$start_month = trim($_POST['start_month']);
	$start_year = trim($_POST['start_year']);
	
	$end_day = '1';
	$end_month = trim($_POST['end_month']);
	$end_year = trim($_POST['end_year']);

	
	if($start_month == '')
	{
		$error = true;
		$tr_err_date = '';
		$err_date = 'Please select start month';
	}
	elseif($start_year == '')
	{
		$error = true;
		$tr_err_date = '';
		$err_date = 'Please select start year';
	}
	elseif(!checkdate($start_month,$start_day,$start_year))
	{
		$error = true;
		$tr_err_date = '';
		$err_date = 'Please select valid start date';
	}
	elseif(mktime(0,0,0,$start_month,$start_day,$start_year) > time())
	{
		$error = true;
		$tr_err_date = '';
		$err_date = 'Please select today or previous day for start date ';
	}
	else
	{
		$start_date = $start_year.'-'.$start_month.'-'.$start_day;
	}


	if($end_month == '')
	{
		$error = true;
		if($tr_err_date == 'none')
		{
			$tr_err_date = '';
			$err_date = 'Please select end month';
		}
		else
		{
			$err_date .= '<br>Please select end month';
		}	
	}
	elseif($end_year == '')
	{
		$error = true;
		if($tr_err_date == 'none')
		{
			$tr_err_date = '';
			$err_date = 'Please select end year';
		}
		else
		{
			$err_date .= '<br>Please select end year';
		}	
	}
	else
	{
		$end_date = $end_year.'-'.$end_month.'-'.$end_day;
		$end_day = date('t',strtotime($end_date)); 
		$end_date = $end_year.'-'.$end_month.'-'.$end_day;
		
		if(strtotime($start_date) > strtotime($end_date))
		{
			$error = true;
			if($tr_err_date == 'none')
			{
				$tr_err_date = '';
				$err_date = 'Please select end month/year less than start month/year';
			}
			else
			{
				$err_date .= '<br>Please select end month/year less than start month/year';
			}	
		}	
	}	

	if(!$error)
	{
		list($return,$arr_reward_modules,$arr_reward_summary) = getMyRewardsChart($user_id,$start_date,$end_date);
	}
}
else
{
	$now = time();
	$user_add_date = getUserRegistrationTimestamp($user_id);
	$start_year = date("Y",$user_add_date);
	$start_month = date("m",$user_add_date);
	$start_day = date("d",$user_add_date);
	$end_year = date("Y",$now);
	$end_month = date("m",$now);
	$end_day = date('t',$now); 
	$error = false;
	$return = false;
	
	$start_date = $start_year.'-'.$start_month.'-'.$start_day;
	$end_date = $end_year.'-'.$end_month.'-'.$end_day;
	list($return,$arr_reward_modules,$arr_reward_summary) = getMyRewardsChart($user_id,$start_date,$end_date);
}
$summary_cnt = count($arr_reward_summary);
//echo '<br><pre>';
//print_r($arr_reward_summary);
//echo '<br></pre>';
//echo '<br>Testkk summary_cnt = '.$summary_cnt;
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
	<?php /*?><script type="text/JavaScript" src="js/jquery-1.9.1.js"></script><?php */?>
    <script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>
    
    <link rel="stylesheet" href="css/jquery-ui.css" />
	<script src="js/jquery-ui.js"></script>
	<script type="text/JavaScript" src="js/commonfn.js"></script>
	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
	<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
    
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
			
			$("ul.tabs li").click(function() {
				$("ul.tabs li").removeClass("active");
				$(this).addClass("active");
				$(".tab_content2").hide();
				var activeTab = $(this).attr("rel"); 
				$("#"+activeTab).fadeIn(); 
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
			<?php include_once('header.php'); ?>
            <table width="940" align="center" border="0" cellspacing="0" cellpadding="0">
	            <tr>
                    <td height="40" align="left" valign="top" class="breadcrumb">
                        <?php echo getBreadcrumbCode($page_id);?>
                    </td>
                </tr>
            </table>
                    <table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                            	<td align="left" valign="top"><?php echo getPageContents($page_id);?></td>
                            </tr>
                        </table>
			<table width="940" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="left" valign="top">
                                             
						<table width="940" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
							<tr>
								<td align="center" valign="top" bgcolor="#FFFFFF">
								<?php
                                if($page_access)
                                { ?>
                                    <table width="940" border="0" cellspacing="0" cellpadding="0" id="my_tbl">
										<tr>
											<td height="200" align="center" valign="top" class="mainnav">
                                                                                           
												<form action="#" id="frmactivity" method="post" name="frmactivity">
												<table width="920" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="100" height="45" align="left" valign="middle" class="Header_brown">Start Month:</td>
														<td width="232" align="left" valign="middle">
															<select name="start_month" id="start_month">
																<option value="">Month</option>
																<?php echo getMonthOptions($start_month); ?>
															</select>
															<select name="start_year" id="start_year">
																<option value="">Year</option>
															<?php
															for($i=2011;$i<=intval(date("Y"));$i++)
															{ ?>
																<option value="<?php echo $i;?>" <?php if($start_year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
															<?php
															} ?>	
															</select>
													  </td>
														<td width="81" height="45" align="left" valign="middle" class="Header_brown">End Month:</td>
														<td width="245" align="left" valign="middle">
														  <select name="end_month" id="end_month">
																<option value="">Month</option>
																<?php echo getMonthOptions($end_month); ?>
														  </select>
														  <select name="end_year" id="end_year">
																<option value="">Year</option>
															<?php
															for($i=2011;$i<=intval(date("Y"));$i++)
															{ ?>
																<option value="<?php echo $i;?>" <?php if($end_year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
															<?php
															} ?>	
														  </select>
													  </td>
														<td width="268" height="45" align="left" valign="middle"><input type="submit" name="btnSubmit" id="btnSubmit" value="View" /></td>
					   								</tr>
                                                    <tr id="tr_err_date" style="display:<?php echo $tr_err_date;?>;" valign="top">
														<td align="left" colspan="5" class="err_msg" id="err_date" valign="top"><?php echo $err_date;?></td>
													</tr>
												</table>
												</form>
                                                                                            
											<?php
                                            if($return && count($arr_reward_modules) > 0)
                                            { ?>
                                            	<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr align="center">
														<td height="30" class="Header_brown">&nbsp;</td>
													</tr>
												</table>
                                                <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                                <tbody>
                                                    <tr>
                                                        <td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
                                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
                                                        <td width="20%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($start_date));?></td>
                                                        <td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
                                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
                                                        <td width="19%" height="30" align="left" valign="middle"><?php echo date("t M Y",strtotime($end_date));?></td>
                                                        <td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                                        <td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                                        <td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                                    </tr>
                                                    <tr>	
                                                        <td height="30" align="left" valign="middle"><strong>Name</strong></td>
                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>
                                                        <td height="30" align="left" valign="middle"><?php echo getUserFullNameById($user_id);?></td>
                                                        <td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>
                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>
                                                        <td height="30" align="left" valign="middle"><?php echo getUserUniqueId($user_id);?></td>
                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                               <?php /*?> <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                                <tbody>	
                                                    <tr>	
                                                        <td align="left"><strong>Important:</strong></td>
                                                    </tr>
                                                    <tr>	
                                                        <td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
                                                    </tr>
                                                </tbody>
                                                </table><?php */?>
                                                
                                                <div id="tabs_container2" style="margin-left:10px;">
                                                    <ul class="tabs"> 
                                                        <li class="active" rel="tab1">Summary Reward Chart</li>
                                                        <li rel="tab2">Monthwise Reward Chart</li>
                                                    </ul>
                                                    <div class="tab_container2"> 
                                                        <div id="tab1" class="tab_content2" style="display:block;"> 
                                                
                                                
                                                            <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                                            <tbody>	
                                                                <tr>	
                                                                    <td colspan="2" align="left" height="30">&nbsp;</td>
                                                                </tr>
                                                                <tr>	
                                                                    <td align="left"><span style="font-size:18px;"><strong>Summary Reward Chart</strong></span></td>
                                                                    <td align="right">
                                                                    	<input type="button" name="btnShowRewardCatlog" id="btnShowRewardCatlog" value="Show Rewards Catlog" onclick="showRewardCatlog('')"  />&nbsp;
                                                                        <input type="button" name="btnViewPointEncashed" id="btnViewPointEncashed" value="View Encashed Rewards" onclick="javascript:window.open('my_encashed_rewards.php', '_blank');" >&nbsp;
                                                                        <input type="button" name="btnRedeamAllModuleWise" id="btnRedeamAllModuleWise" value="Redeem for Total Points(All Modules)" onclick="viewAllModuleRedeamPopup('<?php echo $summary_cnt;?>');"  />
																	
																	
                                                                    </td>
                                                                </tr>
                                                               
                                                            </tbody>
                                                            </table>
                                                            <table width="920" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="10%" height="30" align="center" valign="middle"><strong>SNo</strong></td>
                                                                    <td width="20%" height="30" align="center" valign="middle"><strong>Particulars</strong></td>
                                                                    <td width="10%" height="30" align="center" valign="middle"><strong>Total Entries</strong></td>
                                                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Gained</strong></td>
                                                                    <td width="10%" height="30" align="center" valign="middle"><strong>Number of days Posted</strong></td>
                                                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Bonus Points Gained</strong></td>
                                                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise TOTAL Points</strong></td>
                                                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Encashed</strong></td>
                                                                    <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Balance Points</strong></td>
                                                                </tr>
                                                                <?php
                                                                //for($i=0,$j=1;$i<count($arr_reward_summary['records']);$i++,$j++)
                                                                $i = 0;
																$j = 1;
                                                                $summary_total_entries = 0;
                                                                $total_summary_points_from_entry = 0;
                                                                $total_summary_no_of_days_posted = 0;
                                                                $total_summary_bonus_points = 0;
                                                                $total_summary_total_points = 0;
																$total_summary_encashed_points = 0;
																$total_summary_balance_points = 0;
                                                                
																foreach($arr_reward_summary as $key => $val)
                                                                { 
                                                                    $total_summary_total_entries += $val['summary_total_entries'];
                                                                    $total_summary_points_from_entry += $val['summary_points_from_entry'];
                                                                    $total_summary_no_of_days_posted += $val['summary_no_of_days_posted'];
                                                                    $total_summary_bonus_points += $val['summary_bonus_points'];
                                                                    $total_summary_total_points += $val['summary_total_points'];
																	$total_summary_encashed_points += $val['summary_total_encashed_points'];
																	$total_summary_balance_points += $val['summary_total_balance_points'];
                                                                
                                                                ?>
                                                                <tr>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $j;?></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_reward_module_title'];?></strong></td>
                                                                    <td height="30" align="right" valign="middle" style="padding-right:2px;">
                                                                        <strong><?php echo $val['summary_total_entries'];?></strong>
                                                                    <?php 
                                                                    if($val['summary_total_entries'] > 0)
                                                                    { ?>
                                                                        &nbsp;<input type="button" name="btnViewEntriesDetailsList" id="btnViewEntriesDetailsList" value="View" onclick="viewEntriesDetailsList('<?php echo $start_date;?>','<?php echo $end_date;?>','<?php echo $key;?>','<?php echo $val['summary_reward_module_title'];?>');"  />
                                                                    <?php
																	}
																	else
																	{ ?>
                                                                    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <?php
                                                                    } ?>    
                                                                    </td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_points_from_entry'];?></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_no_of_days_posted'];?></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_bonus_points'];?></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_total_points'];?></strong></td>
                                                                    <td height="30" align="center" valign="middle">
                                                                    	<strong><?php echo $val['summary_total_encashed_points'];?></strong>&nbsp;
                                                                        <input type="button" name="btnViewPointEncashed" id="btnViewPointEncashed" value="View" onclick="javascript:window.open('my_encashed_rewards.php?reward_list_module_id=<?php echo $key;?>&start_date=<?php echo date("d-m-Y",strtotime($start_date));?>&end_date=<?php echo date("d-m-Y",strtotime($end_date));?>', '_blank');" >
                                                                    </td>
                                                                    <td height="30" align="center" valign="middle">
                                                                    	<input type="hidden" name="hdnsummary_reward_module_id_<?php echo $i;?>" id="hdnsummary_reward_module_id_<?php echo $i;?>" value="<?php echo $key;?>"  />
                                                                        <input type="hidden" name="hdnsummary_reward_module_title_<?php echo $i;?>" id="hdnsummary_reward_module_title_<?php echo $i;?>" value="<?php echo $val['summary_reward_module_title'];?>"  />
                                                                        <input type="hidden" name="hdnsummary_total_balance_points_<?php echo $i;?>" id="hdnsummary_total_balance_points_<?php echo $i;?>" value="<?php echo $val['summary_total_balance_points'];?>"  />
                                                                    	<strong><?php echo $val['summary_total_balance_points'];?>&nbsp;</strong>
                                                                        <?php
																		if(chkIfUserCanRedeamGift($user_id,'',$key,$val['summary_total_balance_points']))
																		{ ?>
                                                                        
                                                                        <input type="button" name="btnRedeamModuleWise" id="btnRedeamModuleWise" value="Redeem" onclick="viewModuleWiseRedeamPopup('','<?php echo $key;?>','<?php echo $val['summary_reward_module_title'];?>','<?php echo $val['summary_total_balance_points'];?>');"  />
                                                                        <?php
																		} ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
																	$j++;
																	$i++;
                                                                } ?>  
                                                                <tr>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong>Base Total</strong></td>
                                                                    <td height="30" align="right" valign="middle" style="padding-right:2px;"><strong><?php echo $total_summary_total_entries;?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_points_from_entry;?></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_no_of_days_posted;?></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_bonus_points;?></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_total_points;?></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong>Total Bonus Points</strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_bonus_points;?></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong>Grand Total Points</strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_total_points;?></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                </tr> 
                                                                <tr>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong>Total Point Encashed</strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_encashed_points;?></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong>Total Balance Points</strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_balance_points;?></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                    
                                                                </tr> 
                                                              </tbody>
                                                              </table>
                                                          </div>
                                             				<div id="tab2" class="tab_content2" >     
                                                              
																<?php /*?><div id="idmonthwisechart" style="display:<?php echo $idmonthwisechart;?>"> <?php */?>
                                                                    <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                                                <tbody>	
                                                                    <tr>	
                                                                        <td align="left" height="30">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>	
                                                                        <td align="left"><span style="font-size:18px;"><strong>Monthwise Reward Chart</strong></span></td>
                                                                        
                                                                    </tr>
                                                                   
                                                                </tbody>
                                                                </table> 
                                                                <?php
                                                                //echo '<br><pre>';
                                                                //print_r($arr_reward_modules);
                                                                //echo '<br></pre>';
                                                                foreach($arr_reward_modules as $key => $value)
                                                                { ?>
                                                                <table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
                                                                    <tr align="center">
                                                                        <td height="30" class="Header_brown">&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                                <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
                                                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
                                                                        <td width="20%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($key));?></td>
                                                                        <td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>
                                                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>
                                                                        <td width="19%" height="30" align="left" valign="middle"><?php echo date("t M Y",strtotime($key));?></td>
                                                                        <td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                                                        <td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                                                        <td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                                                    </tr>
                                                                    <tr>	
                                                                        <td height="30" align="left" valign="middle"><strong>Name</strong></td>
                                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>
                                                                        <td height="30" align="left" valign="middle"><?php echo getUserFullNameById($user_id);?></td>
                                                                        <td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>
                                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>
                                                                        <td height="30" align="left" valign="middle"><?php echo getUserUniqueId($user_id);?></td>
                                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
                                                                    </tr>
                                                                </tbody>
                                                                </table>
                                                               <?php /*?> <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">
                                                                <tbody>	
                                                                    <tr>	
                                                                        <td align="left"><strong>Important:</strong></td>
                                                                    </tr>
                                                                    <tr>	
                                                                        <td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
                                                                    </tr>
                                                                </tbody>
                                                                </table><?php */?>
                                                                <table width="920" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="5%" height="30" align="center" valign="middle"><strong>SNo</strong></td>
                                                                        <td width="30%" height="30" align="center" valign="middle"><strong>Particulars</strong></td>
                                                                        <td width="15%" height="30" align="center" valign="middle"><strong>Conversion value for points<br />(Entries/Module)</strong></td>
                                                                        <td width="15%" height="30" align="center" valign="middle"><strong>Total Entries</strong></td>
                                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Gained</strong></td>
                                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Number of days Posted</strong></td>
                                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Bonus Points Gained</strong></td>
                                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise TOTAL Points</strong></td>
                                                                         <?php /*?><td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Points Encashed</strong></td>
                                                                       <td width="10%" height="30" align="center" valign="middle"><strong>Itemwise Rewards got from Points Enc</strong></td>
                                                                        <td width="12%" height="30" align="center" valign="middle"><strong>Itemwise Balance Points</strong></td><?php */?>
                                                                    </tr>
                                                                    <?php
                                                                    for($i=0,$j=1;$i<count($value['records']);$i++,$j++)
                                                                    { ?>
                                                                    <tr>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $j;?></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['reward_module_title'];?></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo ($value['records'][$i]['reward_conversion_value'] == '0' ? 'NA' : $value['records'][$i]['reward_conversion_value']);?></strong></td>
                                                                        <td height="30" align="right" valign="middle" style="padding-right:2px;">
                                                                            <strong><?php echo $value['records'][$i]['total_entries'];?></strong>
                                                                        <?php 
                                                                        if($value['records'][$i]['total_entries'] > 0)
                                                                        { ?>
                                                                            &nbsp;<input type="button" name="btnViewEntriesDetailsList" id="btnViewEntriesDetailsList" value="View" onclick="viewEntriesDetailsList('<?php echo $key;?>','<?php echo date('Y-m-t',strtotime($key));?>','<?php echo $value['records'][$i]['reward_module_id'];?>','<?php echo $value['records'][$i]['reward_module_title'];?>');"  />
                                                                        <?php
																		}
																		else
																		{ ?>
																			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		<?php
																		} ?>   
                                                                        </td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['points_from_entry'];?></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['no_of_days_posted'];?></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['bonus_points'];?></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['total_points'];?></strong></td>
                                                                        <?php /*?><td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['encashed_points'];?></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="right" valign="middle" style="padding-right:2px;"><strong><?php echo $value['records'][$i]['balance_points'];?>&nbsp;<input type="button" name="btnRedeamModuleWise" id="btnRedeamModuleWise" value="Redeem" onclick="viewModuleWiseRedeamPopup('<?php echo $key;?>','<?php echo $value['records'][$i]['reward_module_id'];?>','<?php echo $value['records'][$i]['reward_module_title'];?>','<?php echo $value['records'][$i]['balance_points'];?>');"  /></strong></td><?php */?>
                                                                    </tr>
                                                                    <?php
                                                                    } ?>  
                                                                    <tr>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong>Base Total</strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_reward_conversion_value'];?></strong></td>
                                                                        <td height="30" align="right" valign="middle" style="padding-right:2px;"><strong><?php echo $value['total_total_entries'];?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_points_from_entry'];?></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_no_of_days_posted'];?></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_bonus_points'];?></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_total_points'];?></strong></td>
                                                                        <?php /*?><td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong>Total Bonus Points</strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_bonus_points'];?></strong></td>
                                                                        <?php /*?><td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong>Grand Total Points</strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_total_points'];?></strong></td>
                                                                        <?php /*?><td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td><?php */?>
                                                                    </tr> 
                                                                    <?php /*?><tr>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong>Total Point Encashed</strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_encashed_points'];?></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong>Total Balance Points</strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_balance_points'];?></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>
                                                                        
                                                                    </tr>  <?php */?>
                                                                  </tbody>
                                                                  </table>
                                                <?php
												} ?>  
                                                				</div> 
                                                               </div>
                                                               </div> 
											<?php
                                            }
                                            else 
                                            { ?>
												<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr align="center">
														<td height="5" class="Header_brown">No Records Found</td>
													</tr>
												</table>	
											<?php 
                                            } ?>
                                                <table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr align="center">
														<td height="30" class="Header_brown">&nbsp;</td>
													</tr>
												</table>	
											</td>
                                        </tr>
									</table>
								<?php 
								} 
								else 
								{ ?>
									<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr align="center">
											<td height="5" class="Header_brown"><?php echo getCommonSettingValue('3');?></td>
										</tr>
									</table>
								<?php 
								} ?>
                                </td>
							</tr>
						</table>
						<table width="940" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
                                            <table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                    <?php echo getScrollingWindowsCodeMainContent($page_id);?>
                                    <?php echo getPageContents2($page_id);?>
                                </td>
                            </tr>
                        </table>
					</td>
				</tr>
			</table>
			<?php include_once('footer.php'); ?>
		</td>
	</tr>
</table>
<div id="page_loading_bg" class="page_loading_bg" style="display:none;">
	<div id="page_loading_img" class="page_loading_img"><img border="0" src="<?php echo SITE_URL;?>/images/loading.gif" /></div>
</div> 
</body>
</html>