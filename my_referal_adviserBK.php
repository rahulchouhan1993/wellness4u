<?php
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };
@set_time_limit(1000000);
include('config.php');
$page_id = '116';
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

if(chkUserPlanFeaturePermission($user_id,'29'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}

if(isset($_POST['pro_user_id']))	
{
	$pro_user_id = strip_tags(trim($_POST['pro_user_id']));
}
elseif(isset($_SESSION['adviser_ref_pro_user_id']))	
{
	$pro_user_id = $_SESSION['adviser_ref_pro_user_id'];
}
else
{
	$pro_user_id = '';
}

if(isset($_POST['status']))	
{
	$status = strip_tags(trim($_POST['status']));
}
elseif(isset($_SESSION['adviser_ref_status']))	
{
	$status = $_SESSION['adviser_ref_status'];
}
else
{
	$status = '';
}

if(isset($_POST['invite_start_date']))	
{
	$invite_start_date = strip_tags(trim($_POST['invite_start_date']));
}
elseif(isset($_SESSION['adviser_ref_invite_start_date']))	
{
	$invite_start_date = $_SESSION['adviser_ref_invite_start_date'];
}
else
{
	$invite_start_date = '';
}

if(isset($_POST['invite_end_date']))	
{
	$invite_end_date = strip_tags(trim($_POST['invite_end_date']));
}
elseif(isset($_SESSION['adviser_ref_invite_end_date']))	
{
	$invite_end_date = $_SESSION['adviser_ref_invite_end_date'];
}
else
{
	$invite_end_date = '';
}

if(isset($_POST['status_start_date']))	
{
	$status_start_date = strip_tags(trim($_POST['status_start_date']));
}
elseif(isset($_SESSION['adviser_ref_status_start_date']))	
{
	$status_start_date = $_SESSION['adviser_ref_status_start_date'];
}
else
{
	$status_start_date = '';
}

if(isset($_POST['status_end_date']))	
{
	$status_end_date = strip_tags(trim($_POST['status_end_date']));
}
elseif(isset($_SESSION['adviser_ref_status_end_date']))	
{
	$status_end_date = $_SESSION['adviser_ref_status_end_date'];
}
else
{
	$status_end_date = '';
}

$_SESSION['adviser_ref_pro_user_id'] = $pro_user_id;
$_SESSION['adviser_ref_status'] = $status;
$_SESSION['adviser_ref_invite_start_date'] = $invite_start_date;
$_SESSION['adviser_ref_invite_end_date'] = $invite_end_date;
$_SESSION['adviser_ref_status_start_date'] = $status_start_date;
$_SESSION['adviser_ref_status_end_date'] = $status_end_date;

$referral_data = array();
//if($invite_start_date == '' || $invite_end_date == '')
//{
//	$error = true;
//	$err_msg = '<span class="Header_blue">Please select From and To date.</span>';
//}
//else
//{
    $referral_data = getAllUserAdviserReferrals($user_id,$pro_user_id,$status,$invite_start_date,$invite_end_date,$status_start_date,$status_end_date);
    //echo '<pre>';
    //print_r($referral_data);
    //echo '</pre>';
//}




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
                    <td width="800" align="left" valign="top">
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
                                        <label><strong>Invitation Sent Date - :</strong></label>
                                        &nbsp;&nbsp;
                                        <strong>From date</strong>
                                        <input name="invite_start_date" id="invite_start_date" type="text" value="<?php echo $invite_start_date;?>" style="width:80px;" />
                                        <script>$('#invite_start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                        &nbsp;<strong>To date</strong>
                                        <input name="invite_end_date" id="invite_end_date" type="text" value="<?php echo $invite_end_date;?>" style="width:80px;" />
                                        <script>$('#invite_end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" align="left" valign="middle" bgcolor="#FFFFFF">
                                        <label><strong>Status Date - :</strong></label>
                                        &nbsp;&nbsp;
                                        <strong>From date</strong>
                                        <input name="status_start_date" id="status_start_date" type="text" value="<?php echo $status_start_date;?>" style="width:80px;" />
                                        <script>$('#status_start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                        &nbsp;<strong>To date</strong>
                                        <input name="status_end_date" id="status_end_date" type="text" value="<?php echo $status_end_date;?>" style="width:80px;" />
                                        <script>$('#status_end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" align="left" valign="middle" bgcolor="#FFFFFF">
                                        <label><strong>Search For - :</strong></label>
                                        <select name="pro_user_id" id="pro_user_id" style="width:120px;" >
                                            <option value="">All Advisers</option>
                                            <?php echo getUsersAdviserOptions($user_id,$pro_user_id); ?>
                                        </select>    
                                        &nbsp;&nbsp;
                                        <label><strong>Status :</strong></label>
                                        &nbsp;&nbsp;
                                        <select name="status" id="status" style="width:150px;">
                                            <option value="">All Status</option>
                                            <option value="0" <?php if($status == '0'){?> selected <?php }?>>Pending</option>
                                            <option value="1" <?php if($status == '1'){?> selected <?php }?>>Accepted</option>
                                            <option value="2" <?php if($status == '2'){?> selected <?php }?>>Declined</option>
                                            <option value="3" <?php if($status == '3'){?> selected <?php }?>>Deactivated</option>
                                        </select>    

                                        &nbsp;
                                        <input type="submit" name="btnSubmit" value="Search" />
                                    </td>
                                </tr>
                            </table>
                            <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="footer" height="30">&nbsp;</td>
                                </tr>
                            </table>
                            <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="100%" align="left" valign="top">
                                <?php 
                                if(count($referral_data)>0)
                                { ?>
                                        <table width="760" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                                            <tr>
                                                <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr.No.</strong></td>
                                                <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Email id</strong></td>
                                                <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Name</strong></td>
                                                <td width="15%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Message</strong></td>
                                                <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Invitation Sent By</strong></td>
                                                <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Invitation Sent Date</strong></td>
                                                <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Accepted Date</strong></td>
                                                <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Status</strong></td>
                                                <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Action</strong></td>
                                            </tr>
                                    <?php 
                                    $i=1;
                                    foreach($referral_data as $record) 
                                    {
                                        $action_btn = '';
                                        if($record['invite_by_user'] == '1')
                                        {
                                            $invite_str = 'Sent By Me';
                                            $email = $record['user_email'];
                                            $name = $record['user_name'];
                                            $uid = getProUserId($email);
                                            
                                        }
                                        else
                                        {
                                            $invite_str = 'Sent By Adviser';
                                            $email = getproUserEmailById($record['pro_user_id']);
                                            $name = getProUserFullNameById($record['pro_user_id']);
                                            $uid = $record['pro_user_id'];
                                        }
                                        
                                        if($record['last_status_updated_by_adviser'] == '1')
                                        {
                                            $status_by = 'By Adviser';
                                        }
                                        else
                                        {
                                            $status_by = 'By Me';
                                        }
                                        if($record['new_user'] == '1')
                                        {
                                            if($record['referral_status'] == '1')
                                            {
                                                if($record['request_status'] == '1')
                                                {
                                                    //$temp_status = 'Registered and Accepted';
                                                    $temp_status = 'Accepted'.$status_by;
                                                    $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_adviser_activity.php?id='.$uid.'\', \'_blank\');" >';
                                                }
                                                elseif($record['request_status'] == '2')
                                                {
                                                    //$temp_status = 'Registered and Declined';
                                                    $temp_status = 'Declined'.$status_by;
                                                    $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_adviser_activity.php?id='.$uid.'\', \'_blank\');" >';
                                                }
                                                elseif($record['request_status'] == '3')
                                                {
                                                    //$temp_status = 'Registered and Deactivated';
                                                    $temp_status = 'Deactivated'.$status_by;
                                                    $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_adviser_activity.php?id='.$uid.'\', \'_blank\');" >';
                                                }
                                                else 
                                                {
                                                    //$temp_status = 'Registered and Pending';
                                                    $temp_status = 'Pending (Adviser Registered)';
                                                    if($record['invite_by_user'] == '0')
                                                    {
                                                        $action_btn = '<input type="button" name="btnAccept" id="btnAccept" value="Accept" onclick="showAcceptInvitationPopup(\''.$record['ar_id'].'\',\''.$uid.'\')" >';
                                                        $action_btn .= '&nbsp;<input type="button" name="btnDecline" id="btnDecline" value="Decline" onclick="showDeclineAdviserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';
                                                    }
                                                }

                                                $accept_date = getUserRegistrationDateByEmail($record['user_email']);
                                            }
                                            else 
                                            {
                                                $temp_status = 'Pending (Adviser not Registered)';
                                                $accept_date = '';
                                                
                                                if($record['invite_by_user'] == '0')
                                                {
                                                    $action_btn = '<input type="button" name="btnAccept" id="btnAccept" value="Accept" onclick="showAcceptInvitationPopup(\''.$record['ar_id'].'\',\''.$uid.'\')" >';
                                                    $action_btn .= '&nbsp;<input type="button" name="btnDecline" id="btnDecline" value="Decline" onclick="showDeclineAdviserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';
                                                }
                                            }
                                        }
                                        else
                                        {
                                            if($record['request_status'] == '1')
                                            {
                                                $temp_status = 'Accepted'.$status_by;
                                                $time = strtotime($record['request_accept_date']);
                                                $time = $time + 19800;
                                                $accept_date = date('d/m/Y h:i A',$time);
                                                
                                                $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_adviser_activity.php?id='.$uid.'\', \'_blank\');" >';
                                            }
                                            elseif($record['request_status'] == '2')
                                            {
                                                $temp_status = 'Declined'.$status_by;
                                                $time = strtotime($record['request_accept_date']);
                                                $time = $time + 19800;
                                                $accept_date = date('d/m/Y h:i A',$time);
                                                
                                                $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_adviser_activity.php?id='.$uid.'\', \'_blank\');" >';
                                            }
                                            elseif($record['request_status'] == '3')
                                            {
                                                $temp_status = 'Deactivated'.$status_by;
                                                $time = strtotime($record['request_accept_date']);
                                                $time = $time + 19800;
                                                $accept_date = date('d/m/Y h:i A',$time);
                                                
                                                $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_adviser_activity.php?id='.$uid.'\', \'_blank\');" >';
                                            }
                                            else 
                                            {
                                                $temp_status = 'Pending';
                                                $accept_date = '';
                                                
                                                if($record['invite_by_user'] == '0')
                                                {
                                                    $action_btn = '<input type="button" name="btnAccept" id="btnAccept" value="Accept" onclick="showAcceptInvitationPopup(\''.$record['ar_id'].'\',\''.$uid.'\')" >';
                                                    $action_btn .= '&nbsp;<input type="button" name="btnDecline" id="btnDecline" value="Decline" onclick="showDeclineAdviserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';
                                                }
                                            }
                                        } ?>
                                        <tr>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $i; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $email; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $name; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $record['message']; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $invite_str; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo date('d/m/Y h:i:s A',strtotime($record['request_sent_date'])); ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $accept_date; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $temp_status; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $action_btn; ?></td>

                                        </tr>
                                        <?php 
                                        $i++;  
                                    } ?>
                                    </table>
                                <?php
                                } 
                                else 
                                { ?>
                                    <table width="760" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF" class="err_msg">You don't have any referrals.</td>
                                        </tr>
                                    </table>
                                <?php
                                } ?>
                                </td>
                            </tr>
                        </table>
                            </form>
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