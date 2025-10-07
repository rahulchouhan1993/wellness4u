<?php
require_once('../config.php');
$page_id = '117';
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
elseif(isset($_GET['id']))	
{
	$user_id = trim($_GET['id']);
}
elseif(isset($_SESSION['user_invitation_user_id']))	
{
	$user_id = $_SESSION['user_invitation_user_id'];
}
else
{
	$user_id = '';
}

$user_email = getProUserEmailById($pro_user_id);
$referral_data = getAllMyUserInvitations($user_email,$user_id);
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
	<link href="../cwri.css" rel="stylesheet" type="text/css" />
	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="js/commonfn.js"></script>
	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
	<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
   
    <style type="text/css">@import "css/jquery.datepick.css";</style> 
	<script type="text/javascript" src="js/jquery.datepick.js"></script>
    
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
            <?php include_once('header.php');?>
            <table width="980" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="980" align="center" valign="top">
                        <table width="940" border="0" align="center" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="40" align="left" valign="top" class="breadcrumb">
                                    <?php echo getBreadcrumbCode($page_id);?>
                                </td>
                            </tr>
                        </table>
                        <table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
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
                        <table width="940" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                        	
                            <tr>
                            	<td width="100%" align="left" valign="middle" bgcolor="#FFFFFF">
                                	
                                    <label><strong>Show For - :</strong></label>
                                    <select name="user_id" id="user_id" style="width:120px;" >
                                        <option value="">All Users</option>
                                        <?php echo getAdvisersAllUserOptions($pro_user_id,$user_id); ?>
                                    </select>    
                                    
                                    <input type="submit" name="btnSubmit" value="Search" />
                                	
                                </td>
                               
                           	</tr>
                        </table>
                        </form>
                        <table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td class="footer" height="30">&nbsp;</td>
                            </tr>
                        </table>	
                        <table width="940" border="0" cellpadding="5" cellspacing="0">
                            <tr>
                                <td width="100%" align="center" valign="top">
                                <?php 
                                if(count($referral_data)>0)
                                { 
                                    foreach($referral_data as $record) 
                                    {
                                        $i =1;
											
					if($record['last_status_updated_by_adviser'] == '1')
                                        {
                                            $status_by = 'By Me';
                                        }
                                        else
                                        {
                                            $status_by = 'By User';
                                        }						
											
                                        if($record['request_status'] == '1')
                                        {
                                                $temp_status = 'Accepted'.$status_by;
                                                $main_temp_status = 'Accepted'.$status_by;
                                                $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Deactivate" onclick="showDeactivateUserInvitationPopup(\''.$record['ar_id'].'\',\''.$record['pro_user_id'].'\')">';


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
                                                $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Activate" onclick="showActivateUserInvitationPopup(\''.$record['ar_id'].'\',\''.$record['pro_user_id'].'\')">';


                                                $time = strtotime($record['request_accept_date']);
                                                $time = $time + 19800;
                                                $request_accept_date = date('d/m/Y h:i A',$time);
                                        }
                                        else 
                                        {
                                                $temp_status = 'Pending';
                                                $main_temp_status = 'Pending';
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
                                    	<table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="75%" align="left" valign="middle"><strong>User Name: <?php echo $record['name'];?></strong>&nbsp;&nbsp;&nbsp;<input type="button" name="btnViewAdviserReportLog" id="btnViewAdviserReportLog" value="View Access Log" onclick="javascript:window.open('my_user_authorise_log.php?id=<?php echo $record['pro_user_id']?>', '_blank');" ></td>
                                                <td width="25%" align="center" valign="middle"><?php echo $action2;?></td>
                                            </tr>
                                        </table>
                                        <table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="100%" height="30" align="left" valign="middle">&nbsp;</td>
                                            </tr>
                                        </table>
                                        
                                        <table width="940" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                                            <tr>
                                                <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr.No.</strong></td>
                                                <td width="40%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Invitation/Activation/Deactivation Message</strong></td>
                                                <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Invitation Sent Date</strong></td>
                                                <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Status</strong></td>
                                                <td width="15%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Status Date</strong></td>
                                                
                                                
                                            </tr>
                                            
                                            
                                            
                                            <?php
                                            if(count($adviser_status_records) > 0)
                                            { 

                                                            $temp_status = 'Accepted';
                                            ?>
                                            
                                            
                                            	<?php
                                                $l = 1;
                                                $show_modify_button = true;
                                                foreach($adviser_status_records as $record_as) 
                                                { 
                                                    //echo '<br><pre>';
                                                    //print_r($record_as);
                                                    //echo '<br></pre>';
                                                    if($record_as['aa_status_updated_by_adviser'] == '1')
                                                    {
                                                        $aa_status_by = ' By Me';
                                                    }
                                                    else
                                                    {
                                                        $aa_status_by = ' By User';
                                                    }
													
													
													
                                                        if($record_as['aa_status'] == '1')
                                                        {
                                                                $temp_status = 'Activated'.$aa_status_by;
                                                                //if($record['request_status'] == '1' && (( $l - 1) == count($adviser_status_records) ) )
                                                                if($record['request_status'] == '1' &&  $show_modify_button)
                                                                {
                                                                        $show_modify_button = false;
                                                                        $action = '';
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
                                                
                                              
                                            </tr>
											<?php
											} ?>
                                        </table>
                                        <table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
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
                                        <table width="940" border="0" cellpadding="0" cellspacing="0">
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
                        <table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr align="center">
                                <td height="5" class="Header_brown"><?php echo getCommonSettingValue('4');?></td>
                            </tr>
                        </table>
                        <?php 
                        } ?>
                    </td>
                </tr>
            </table>
            <?php include_once('footer.php'); ?>
        </td>
    </tr>
    <tr>
        <td align="center" valign="top" background="images/top_back.jpg" style="background-repeat: repeat-x;">&nbsp;</td>
    </tr>
</table>
</body>
</html>