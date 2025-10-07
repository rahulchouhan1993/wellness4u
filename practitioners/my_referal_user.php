<?php
require_once('../config.php');
$page_id = '83';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$ref = base64_encode($menu_link);

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

if(chkAdviserPlanFeaturePermission($pro_user_id,'25'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}

if(isset($_POST['user_id']))	
{
	$user_id = strip_tags(trim($_POST['user_id']));
}
elseif(isset($_SESSION['user_ref_user_id']))	
{
	$user_id = $_SESSION['user_ref_user_id'];
}
else
{
	$user_id = '';
}

if(isset($_POST['status']))	
{
	$status = strip_tags(trim($_POST['status']));
}
elseif(isset($_SESSION['user_ref_status']))	
{
	$status = $_SESSION['user_ref_status'];
}
else
{
	$status = '';
}

if(isset($_POST['invite_start_date']))	
{
	$invite_start_date = strip_tags(trim($_POST['invite_start_date']));
}
elseif(isset($_SESSION['user_ref_invite_start_date']))	
{
	$invite_start_date = $_SESSION['user_ref_invite_start_date'];
}
else
{
	$invite_start_date = '';
}

if(isset($_POST['invite_end_date']))	
{
	$invite_end_date = strip_tags(trim($_POST['invite_end_date']));
}
elseif(isset($_SESSION['user_ref_invite_end_date']))	
{
	$invite_end_date = $_SESSION['user_ref_invite_end_date'];
}
else
{
	$invite_end_date = '';
}

if(isset($_POST['status_start_date']))	
{
	$status_start_date = strip_tags(trim($_POST['status_start_date']));
}
elseif(isset($_SESSION['user_ref_status_start_date']))	
{
	$status_start_date = $_SESSION['user_ref_status_start_date'];
}
else
{
	$status_start_date = '';
}

if(isset($_POST['status_end_date']))	
{
	$status_end_date = strip_tags(trim($_POST['status_end_date']));
}
elseif(isset($_SESSION['user_ref_status_end_date']))	
{
	$status_end_date = $_SESSION['user_ref_status_end_date'];
}
else
{
	$status_end_date = '';
}

$_SESSION['user_ref_pro_user_id'] = $user_id;
$_SESSION['user_ref_status'] = $status;
$_SESSION['user_ref_invite_start_date'] = $invite_start_date;
$_SESSION['user_ref_invite_end_date'] = $invite_end_date;
$_SESSION['user_ref_status_start_date'] = $status_start_date;
$_SESSION['user_ref_status_end_date'] = $status_end_date;

$referral_data = array();

$referral_data = getAllAdviserUserReferrals($pro_user_id,$user_id,$status,$invite_start_date,$invite_end_date,$status_start_date,$status_end_date);
//echo '<br><pre>';
//print_r($referral_data);
//echo '<br></pre>';
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
	<script type="text/JavaScript" src="../js/commonfn.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
	<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
   
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
<div class="col-md-10">	
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
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
                          <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                          <tr>
                            <td  align="left" valign="middle" bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                              <tr>
                                <td height="50" align="left" valign="middle" bgcolor="#FFFFFF" width="19%"><strong>Invitation Sent Date From </strong></td>
                                <td width="25%"><input name="invite_start_date" id="invite_start_date" type="text" value="<?php echo $invite_start_date;?>" class="form-control col-xs-4"  />
                                  <script>$('#invite_start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script></td>
                                <td width="6%">&nbsp;</td>
                                <td width="15%"><strong>To date</strong></td>
                                <td width="25%"><input name="invite_end_date" id="invite_end_date" type="text" value="<?php echo $invite_end_date;?>"  class="form-control col-xs-4"  />
                                  <script>$('#invite_end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script></td>
                              </tr>
                              <tr>
                                <td height="50" align="left" valign="middle" bgcolor="#FFFFFF"><strong>Status Date From </strong></td>
                                <td><input name="status_start_date" id="status_start_date" type="text" value="<?php echo $status_start_date;?>" class="form-control col-xs-4"  />
                                  <script>$('#status_start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script></td>
                                <td>&nbsp;</td>
                                <td><strong>To date</strong></td>
                                <td><input name="status_end_date" id="status_end_date" type="text" value="<?php echo $status_end_date;?>"  class="form-control col-xs-4" />
                                  <script>$('#status_end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script></td>
                              </tr>
                              <tr>
                                <td  height="50" align="left" valign="middle" bgcolor="#FFFFFF"><label><strong>Search For:</strong></label></td>
                                <td><select name="user_id" id="user_id"  class="form-control col-xs-4"  >
                                  <option value="">All Users</option>
                                  <?php echo getAdvisersAllUserOptions($pro_user_id,$user_id); ?>
                                </select></td>
                                <td>&nbsp;</td>
                                <td><label><strong>Status </strong></label></td>
                                <td><select name="status" id="status"  class="form-control col-xs-4" >
                                  <option value="">All Status</option>
                                  <option value="0" <?php if($status == '0'){?> selected <?php }?>>Pending</option>
                                  <option value="1" <?php if($status == '1'){?> selected <?php }?>>Accepted</option>
                                  <option value="2" <?php if($status == '2'){?> selected <?php }?>>Declined</option>
                                  <option value="3" <?php if($status == '3'){?> selected <?php }?>>Deactivated</option>
                                </select></td>
                              </tr>
                              <tr>
  <td height="50" >&nbsp;</td>
    <td>
      <input type="submit" name="btnSubmit" value="Search" class="btn btn-primary"/></td>
  </tr>
                            </table>                              <strong></strong></td>
                          </tr>
                          </table>
                          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td class="footer" height="30">&nbsp;</td>
                            </tr>
                        </table>
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="100%" align="left" valign="top">
                                <?php 
                                if(count($referral_data)>0)
                                { ?>
                                    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                                        <tr bgcolor="#CCCCCC">
                                            <td width="10%" height="30" align="center" valign="middle" ><strong>Sr.No.</strong></td>
                                            <td width="10%" height="30" align="center" valign="middle" ><strong>Email id</strong></td>
                                            <td width="10%" height="30" align="center" valign="middle" ><strong>Name</strong></td>
                                            <td width="20%" height="30" align="center" valign="middle" ><strong>Message</strong></td>
                                            <td width="10%" height="30" align="center" valign="middle" ><strong>Invitation Sent By</strong></td>
                                            <td width="10%" height="30" align="center" valign="middle" ><strong>Invitation Sent Date</strong></td>
                                            <td width="10%" height="30" align="center" valign="middle" ><strong>Accepted Date</strong></td>
                                            <td width="10%" height="30" align="center" valign="middle" ><strong>Status</strong></td>
                                            <td width="10%" height="30" align="center" valign="middle" ><strong>Action</strong></td>
                                        </tr>
                                    <?php 
                                    $i=1;
                                    foreach($referral_data as $record) 
                                    {
                                        if($record['last_status_updated_by_adviser'] == '1')
                                        {
                                            $status_by = ' By Me';
                                        }
                                        else
                                        {
                                            $status_by = ' By User';
                                        }
                                        
                                        $action_btn = '';
                                        if($record['invite_by_user'] == '1')
                                        {
                                            $invite_str = 'Sent By User';
                                            $email = getUserEmailById($record['pro_user_id']);
                                            $name = getUserFullNameById($record['pro_user_id']);
                                            $uid = $record['pro_user_id'];
                                        }
                                        else
                                        {
                                            $invite_str = 'Sent By Me';
                                            $email = $record['user_email'];
                                            $name = $record['user_name'];
                                            $uid = getUserId($email);
                                        }
                                        
                                        
                                        if($record['new_user'] == '1')
                                        {
                                            if($record['referral_status'] == '1')
                                            {
                                                if($record['request_status'] == '1')
                                                {
                                                    $temp_status = 'Accepted'.$status_by;
                                                    $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" >';
                                                }
                                                elseif($record['request_status'] == '2')
                                                {
                                                    $temp_status = 'Declined'.$status_by;
                                                    $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" >';
                                                }
                                                elseif($record['request_status'] == '3')
                                                {
                                                    $temp_status = 'Deactivated'.$status_by;
                                                    $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" >';
                                                }
                                                else 
                                                {
                                                    $temp_status = 'Pending (User Registered)';
                                                    if($record['invite_by_user'] == '1')
                                                    {
                                                        $action_btn = '<input type="button" name="btnAccept" id="btnAccept" value="Accept" onclick="doAcceptUserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';
                                                        $action_btn .= '&nbsp;<input type="button" name="btnDecline" id="btnDecline" value="Decline" onclick="showDeclineUserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';
                                                    }
                                                }

                                                $accept_date = getUserRegistrationDateByEmail($record['user_email']);
                                            }
                                            else 
                                            {
                                                $temp_status = 'Pending (User not Registered)';
                                                $accept_date = '';
                                                
                                                if($record['invite_by_user'] == '1')
                                                {
                                                    $action_btn = '<input type="button" name="btnAccept" id="btnAccept" value="Accept" onclick="doAcceptUserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';
                                                    $action_btn .= '&nbsp;<input type="button" name="btnDecline" id="btnDecline" value="Decline" onclick="showDeclineUserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';
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
                                                
                                                $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" >';
                                            }
                                            elseif($record['request_status'] == '2')
                                            {
                                                $temp_status = 'Declined'.$status_by;
                                                $time = strtotime($record['request_accept_date']);
                                                $time = $time + 19800;
                                                $accept_date = date('d/m/Y h:i A',$time);
                                                
                                                $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" >';
                                            }
                                            elseif($record['request_status'] == '3')
                                            {
                                                $temp_status = 'Deactivated'.$status_by;
                                                $time = strtotime($record['request_accept_date']);
                                                $time = $time + 19800;
                                                $accept_date = date('d/m/Y h:i A',$time);
                                                
                                                $action_btn = '<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Activity Log" onclick="javascript:window.open(\'my_user_activity.php?id='.$uid.'\', \'_blank\');" >';
                                            }
                                            else 
                                            {
                                                $temp_status = 'Pending';
                                                $accept_date = '';
                                                
                                                if($record['invite_by_user'] == '1')
                                                {
                                                    $action_btn = '<input type="button" name="btnAccept" id="btnAccept" value="Accept" onclick="doAcceptUserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';
                                                    $action_btn .= '&nbsp;<input type="button" name="btnDecline" id="btnDecline" value="Decline" onclick="showDeclineUserInvitation(\''.$record['ar_id'].'\',\''.$uid.'\')" >';
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
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
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
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr align="center">
                                <td height="5" class="Header_brown"><?php echo getCommonSettingValue('4');?></td>
                            </tr>
                        </table>
                        <?php 
                        } ?>
 </div>
<div class="col-md-2">  <?php include_once('right_sidebar.php'); ?></div>

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
<!--        <script src="../csswell/js/jquery.min.js"></script> -->       
        <!--bootstrap js plugin-->
        <script src="../csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
       
    </body>

</html>