<?php
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };
@set_time_limit(1000000);
include('config.php');
$page_id = '84';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('my_adviser_invitations.php');
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
                    <td width="800" align="center" valign="top">
                        <table width="760" align="center" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="40" align="left" valign="top" class="breadcrumb">
                                    <?php echo getBreadcrumbCode($page_id);?>
                                </td>
                            </tr>
                        </table>
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
                                            <?php echo getUsersAllAdviserOptions($user_id,$pro_user_id); ?>
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
                                    
                                    
                                    if($record['request_status'] == '1')
                                    {
                                        $temp_status = 'Accepted'.$status_by;
                                        $main_temp_status = 'Accepted'.$status_by;
                                        $action = '<input type="button" name="btnAccept" id="btnAccept" value="Authorise/Modify Access" onclick="showAcceptInvitationPopup(\''.$record['ar_id'].'\',\''.$record['pro_user_id'].'\')" >';
                                        $main_action = '<input type="button" name="btnAccept" id="btnAccept" value="Authorise/Modify Access" onclick="showAcceptInvitationPopup(\''.$record['ar_id'].'\',\''.$record['pro_user_id'].'\')" >';
                                        $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Deactivate" onclick="showDeactivateAdviserInvitationPopup(\''.$record['ar_id'].'\',\''.$record['pro_user_id'].'\')">';


                                        $time = strtotime($record['request_accept_date']);
                                        $time = $time + 19800;
                                        $request_accept_date = date('d/m/Y h:i A',$time);
                                    }
                                    elseif($record['request_status'] == '2')
                                    {
                                        $temp_status = 'Declined'.$status_by;
                                        $main_temp_status = 'Declined'.$status_by;
                                        $action = '';
                                        $main_action = '';
                                        $action2 = '';


                                        $time = strtotime($record['request_accept_date']);
                                        $time = $time + 19800;
                                        $request_accept_date = date('d/m/Y h:i A',$time);
                                    }
                                    elseif($record['request_status'] == '3')
                                    {
                                        $temp_status = 'Deactivated'.$status_by;
                                        $main_temp_status = 'Deactivated'.$status_by;
                                        $action = '';
                                        $main_action = '';
                                        $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Activate" onclick="showActivateAdviserInvitationPopup(\''.$record['ar_id'].'\',\''.$record['pro_user_id'].'\')">';


                                        $time = strtotime($record['request_accept_date']);
                                        $time = $time + 19800;
                                        $request_accept_date = date('d/m/Y h:i A',$time);
                                    }
                                    else 
                                    {
                                        $temp_status = 'Pending';
                                        $main_temp_status = 'Pending';
                                        $action = '<input type="button" name="btnAccept" id="btnAccept" value="Accept" onclick="showAcceptInvitationPopup(\''.$record['ar_id'].'\',\''.$record['pro_user_id'].'\')" >&nbsp;<input type="button" name="btnDecline" id="btnDecline" value="Decline" onclick="showDeclineAdviserInvitation(\''.$record['ar_id'].'\',\''.$record['pro_user_id'].'\')">';
                                        $main_action = '<input type="button" name="btnAccept" id="btnAccept" value="Accept" onclick="showAcceptInvitationPopup(\''.$record['ar_id'].'\',\''.$record['pro_user_id'].'\')" >&nbsp;<input type="button" name="btnDecline" id="btnDecline" value="Decline" onclick="showDeclineAdviserInvitation(\''.$record['ar_id'].'\',\''.$record['pro_user_id'].'\')">';
                                        $action2 = '';
                                        $request_accept_date = '';
                                    } 

                                    $time2 = strtotime($record['request_sent_date']);
                                    $time2 = $time2 + 19800;
                                    $request_sent_date = date('d/m/Y h:i A',$time2);

                                    $adviser_status_records = getAdviserStatusActivationsRecords($record['ar_id'],$record['pro_user_id']);
                                    //echo '<br><pre>';
                                    //print_r($adviser_status_records);
                                    //echo '<br></pre>';
                                    ?>
                                    <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="75%" align="left" valign="middle"><strong>Adviser Name: <?php echo $record['name'];?></strong>&nbsp;<input type="button" name="btnViewAdviser" id="btnViewAdviser" value="View Adviser Profile" onclick="viewAdviserPopup('<?php echo $record['pro_user_id']?>')" >&nbsp;<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Access Log" onclick="javascript:window.open('my_adviser_authorise_log.php?id=<?php echo $record['pro_user_id']?>', '_blank');" ></td>
                                            <td width="25%" align="center" valign="middle"><?php echo $action2;?></td>
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
                                            <td width="40%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Invitation/Activation/Deactivation Message</strong></td>
                                            <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Invitation Sent Date</strong></td>
                                            <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Status</strong></td>
                                            <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Status Date</strong></td>
                                            <td width="25%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Action</strong></td>
                                        </tr>
                                    <?php
                                    if(count($adviser_status_records) > 0)
                                    { 
                                        $temp_status = 'Accepted';
                                        $l = 1;
                                        $show_modify_button = true;
                                        foreach($adviser_status_records as $record_as) 
                                        { 
                                            if($record_as['aa_status_updated_by_adviser'] == '1')
                                            {
                                                $aa_status_by = ' By Adviser';
                                            }
                                            else
                                            {
                                                $aa_status_by = ' By Me';
                                            }
                                            if($record_as['aa_status'] == '1')
                                            {
                                                $temp_status = 'Activated'.$aa_status_by;
                                                if($record['request_status'] == '1' &&  $show_modify_button)
                                                {
                                                    $show_modify_button = false;
                                                    $action = '<input type="button" name="btnAccept" id="btnAccept" value="Authorise/Modify Access" onclick="showAcceptInvitationPopup(\''.$record['ar_id'].'\',\''.$record['pro_user_id'].'\')" >';
                                                }	
                                                else
                                                {
                                                    $action = '';
                                                }

                                                $time = strtotime($record_as['aa_add_date']);
                                                $time = $time + 19800;
                                                $request_accept_date = date('d/m/Y h:i A',$time);
                                            }
                                            elseif($record_as['aa_status'] == '2')
                                            {
                                                $temp_status = 'Declined'.$aa_status_by;
                                                $action = '';
                                                $action2 = '';

                                                $time = strtotime($record_as['aa_add_date']);
                                                $time = $time + 19800;
                                                $request_accept_date = date('d/m/Y h:i A',$time);
                                            }
                                            elseif($record_as['aa_status'] == '3')
                                            {
                                                $temp_status = 'Deactivated'.$aa_status_by;
                                                $action = '';
                                                $action2 = '';


                                                $time = strtotime($record_as['aa_add_date']);
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

                                            $aa_message = $record_as['aa_status_reason'];
                                            ?>
                                        <tr>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $l; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $aa_message; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php //echo $request_sent_date; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $temp_status; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $request_accept_date; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $action; ?></td>
                                        </tr>
                                            <?php
                                            $l++;
                                        }  ?>
                                        <tr>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $l; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $record['message']; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $request_sent_date; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $main_temp_status; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $request_accept_date; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $main_action; ?></td>
                                        </tr>    
                                    <?php    
                                    } 
                                    else
                                    { ?>
                                        <tr>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $i; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $record['message']; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $request_sent_date; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $temp_status; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $request_accept_date; ?></td>
                                            <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $action; ?></td>
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
                    </td>
                    <td width="180" align="left" valign="top"><?php include_once('right_sidebar.php'); ?></td>
                </tr>
            </table>
            <?php include_once('footer.php'); ?>
        </td>
    </tr>
</table>
</body>
</html>