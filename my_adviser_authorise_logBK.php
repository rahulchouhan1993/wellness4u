<?php
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };
@set_time_limit(1000000);
include('config.php');
$page_id = '106';
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

if(isset($_POST['pro_user_id']))	
{
	$pro_user_id = strip_tags(trim($_POST['pro_user_id']));
}
elseif(isset($_GET['id']))	
{
	$pro_user_id = trim($_GET['id']);
}
elseif(isset($_SESSION['adviser_invitation_pro_user_id']))	
{
	$pro_user_id = $_SESSION['adviser_invitation_pro_user_id'];
}
else
{
	$pro_user_id = '';
}

if(chkUserPlanFeaturePermission($user_id,'29'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}


$user_email = getUserEmailById($user_id);
$referral_data = getAllMyAdviserInvitations($user_email,$pro_user_id);
//echo '<pre>';
//print_r($referral_data);
//echo '</pre>';
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" valign="top">
			<?php include_once('header.php'); ?>
			<table width="980" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                    <td width="800" align="left" valign="top">
                        <table width="760" align="center" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="40" align="left" valign="top" class="breadcrumb">
                                    <?php echo getBreadcrumbCode($page_id);?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td align="left" valign="top">
                    <?php
                    if(isLoggedIn())
                    { 
                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id'],'1');
                    }
                    ?>
                    </td>
                </tr>
				<tr>
                	<td width="800" align="center" valign="top">
						
                        <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                <span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br /><br />
                                <?php echo getPageContents($page_id);?>
                                </td>
                            </tr>
                        </table>
                        <?php
                        if($page_access)
                        { ?>
                        <form name="frmadviserquery" method="post" action="#" >
                        <table width="760" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                        	
                            <tr>
                            	<td width="100%" align="left" valign="middle" bgcolor="#FFFFFF">
                                	
                                    <label><strong>Show For - :</strong></label>
                                    <select name="pro_user_id" id="pro_user_id" style="width:120px;" >
                                        <option value="">All Advisers</option>
                                        <?php echo getUsersAcceptedAdviserOptions($user_id,$pro_user_id); ?>
                                    </select>    
                                    
                                    <input type="submit" name="btnSubmit" value="Search" />
                                	
                                </td>
                               
                           	</tr>
                        </table>
                        </form>
                        <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td class="footer" height="30">&nbsp;</td>
                            </tr>
                        </table>	
                        <table width="760" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="100%" align="left" valign="top">
                            <?php 
                            if(count($referral_data)>0)
                            { 
                                foreach($referral_data as $record) 
                                {
                                    $i =1;
                                    
                                    if($record['last_status_updated_by_adviser'] == '1')
                                    {
                                        $status_by = ' By Adviser';
                                    }
                                    else
                                    {
                                        $status_by = ' By Me';
                                    }
                                    
                                    if($record['invite_by_user'] == '1')
                                    {
                                        $uid = getProUserId($record['user_email']);
                                    }
                                    else
                                    {
                                        $uid = $record['pro_user_id'];
                                    }
                                    
                                    if($record['request_status'] == '1')
                                    {
                                        $temp_status = 'Accepted'.$status_by;
                                        $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Deactivate" onclick="showDeactivateAdviserInvitationPopup(\''.$record['ar_id'].'\',\''.$uid.'\')">';
                                        $action = '';
                                        $time = strtotime($record['request_accept_date']);
                                        $time = $time + 19800;
                                        $request_accept_date = date('d/m/Y h:i A',$time);
                                    }
                                    elseif($record['request_status'] == '2')
                                    {
                                        $temp_status = 'Declined'.$status_by;
                                        $action = '';
                                        $action2 = '';


                                        $time = strtotime($record['request_accept_date']);
                                        $time = $time + 19800;
                                        $request_accept_date = date('d/m/Y h:i A',$time);
                                    }
                                    elseif($record['request_status'] == '3')
                                    {
                                        $temp_status = 'Deactivated'.$status_by;
                                        $action = '';
                                        $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Activate" onclick="showActivateAdviserInvitationPopup(\''.$record['ar_id'].'\',\''.$uid.'\')">';


                                        $time = strtotime($record['request_accept_date']);
                                        $time = $time + 19800;
                                        $request_accept_date = date('d/m/Y h:i A',$time);
                                    }
                                    else 
                                    {
                                        $temp_status = 'Pending';
                                        $action = '';
                                        $action2 = '';
                                        $request_accept_date = '';
                                    } 

                                    $time2 = strtotime($record['request_sent_date']);
                                    $time2 = $time2 + 19800;
                                    $request_sent_date = date('d/m/Y h:i A',$time2);

                                    

                                    $adviser_status_records = getAdviserStatusActivationsRecords($record['ar_id'],$uid);
                                    //echo '<br><pre>';
                                    //print_r($adviser_status_records);
                                    //echo '<br></pre>';
                                    ?>
                                    <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="75%" align="left" valign="middle"><strong>Adviser Name: <?php echo $record['name'];?></strong>&nbsp;<input type="button" name="btnViewAdviser" id="btnViewAdviser" value="View Adviser Profile" onclick="viewAdviserPopup('<?php echo $uid;?>')" >&nbsp;<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Adviser's Activity" onclick="javascript:window.open('my_adviser_activity.php?id=<?php echo $uid;?>', '_blank');" ></td>
                                            <td width="25%" align="right" valign="middle"><?php echo $action;?></td>
                                        </tr>
                                    </table>
                                    <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="100%" height="30" align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                    </table>
                                    <table width="760" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                                        <tr>
                                            <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr.No.</strong></td>
                                            <td width="80%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Reports</strong></td>
                                            <td width="15%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Status Date</strong></td>
                                        </tr>
                                    <?php 
                                    $arr_report_permission = getAdviserReportsPermissions($user_id,$uid,$record['ar_id']);
                                    if(count($arr_report_permission) > 0)
                                    { ?>            
                                        <?php
                                        $j =1;
                                        foreach($arr_report_permission as $report_record) 
                                        { 
                                            $time3 = strtotime($report_record['arp_add_date']);
                                            $time3 = $time3 + 19800;
                                            $arp_add_date = date('d/m/Y h:i A',$time3);
												?>
                                            <tr>
                                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $j;?></td>
                                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo getReportTypeNameString($report_record['report_id'],$report_record['permission_type']);?>

                                                </td>
                                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $arp_add_date; ?></td>
                                            </tr>
											
                                            <?php
                                            $j++;
                                        } ?>
                                    <?php
                                    }
                                    else
                                    { ?>  
                                        <tr>
                                            <td colspan="3" height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="err_msg">No Records</td>
                                        </tr> 
                                    <?php
                                    } ?>
                                    </table>
                                    <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="100%" height="30" align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                    </table>
                                    <?php        
                                    $i++;	
                                } ?>
                            <?php
                            } 
                            else 
                            { ?>
                                    <table width="760" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="err_msg">You don't have any invitations.</td>
                                            </tr>
                                    </table>
                            <?php
                            } ?>
                                </td>
                            </tr>
                        </table>
                        <?php 
                        } 
                        else 
                        { ?>
                        <table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr align="center">
                                <td height="5" class="Header_brown"><?php echo getCommonSettingValue('3');?></td>
                            </tr>
                        </table>
                        <?php 
                        } ?>
                        <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                    <?php echo getScrollingWindowsCodeMainContent($page_id);?>
                                    <?php echo getPageContents2($page_id);?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="180" align="left" valign="top"><?php include_once('left_sidebar.php'); ?></td>
                </tr>
            </table>
            <?php include_once('footer.php'); ?>
        </td>
    </tr>
</table>
</body>
</html>