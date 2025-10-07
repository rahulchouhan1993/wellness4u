<?php
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };
@set_time_limit(1000000);
include('config.php');
$page_id = '75';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('wellness_vacations.php');
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

$error = false;
$msg = '';

if(isset($_POST['submit']))
{
    $tdata = array();
    $tdata['email'] = strip_tags(trim($_POST['email']));
    $tdata['message'] = strip_tags(trim($_POST['message']));
    $tdata['user_name'] = strip_tags(trim($_POST['user_name']));
            
    if($tdata['email']=='')
    {
       $error = true;
       $msg = '<font color=red>Please Enter EMAIL ID of Your Friend</font><br>';
    }
    
    if($tdata['user_name']=='')
    {
       $error = true;
       $msg .='<font color=red>Please Enter Name of Your Friend</font><br>';
    }
	
	if($tdata['message']=='')
    {
       //$error = true;
       //$msg .='<font color=red>Please Enter Message For Your Friend</font><br>';
    }
	
    if(!$error)
    {
         if(is_user($tdata['email']))
         {
             $error = true;
             $msg = '<font color=red>Your Friend is Already A Member.</font>';
         }
         else
         {
            if(is_refered($tdata['email']))
            {
                $error = true;
                $msg = '<font color=red>Friend Already Refered.</font>';
            }
            else
            {
				$tdata['user_id'] = $_SESSION['user_id'];
				$id = addreferafriend($tdata);
				if($id > 0)
				{
					$user_data = getUserDetails($tdata['user_id']);
					
					$url = SITE_URL.'/register.php?refid='.base64_encode($id).'&uid='.base64_encode($tdata['user_id']).'';
					
					$to_email = $tdata['email'];
					$from_email = 'info@wellnessway4u.com';
					$from_name = $user_data[1];
					$subject = 'Your Friend Send A Link To Join Wellness';
					$message = '<p><strong>Hi '.$tdata['user_name'].', '.$from_name.' Send You Request To Join Wellness</strong><p>';
					$msssage .= '<p>'.  ucfirst(trim($tdata['message'])).'</p>';
					$message .= '<p>Just click "<a href="'.$url.'">JOIN Now</a>" to complete your registration. That\'s all there is to it. </p>';
					$message .= '<p>Or Just copy and paste this url: '.$url.'</p>';
					$message .= '<p>Best Regards</p>';
					$message .= '<p>www.wellnessway4u.com</p>';
					//$test= $message;
					$mail = new PHPMailer();
					$mail->IsHTML(true);
					$mail->Host = "batmobile.websitewelcome.com"; // SMTP server
					$mail->From = $from_email;
					$mail->FromName = $from_name;
					$mail->AddAddress($to_email);
					$mail->Subject = $subject;
					$mail->Body = $message;
					$mail->Send();
					$mail->ClearAddresses();
					$error=true;
					$msg = 'Request Send To Your Friend.';
				}
				else 
				{
					$error=true;
					$msg = '<font color=red>Somthing Went Wrong Try later.</font>';
				}
            }
    	}
	}
}
else
{
	$country_id = '1';
	$destination_id = '';
	$no_of_days = '';
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
                   
                    <td width="620" align="center" valign="top">
                    	<table width="620" align="center" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="40" align="left" valign="top" class="breadcrumb">
                                    <?php echo getBreadcrumbCode($page_id);?>
                                </td>
                            </tr>
                        </table>
                        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                <span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br /><br />
                                <?php echo getPageContents($page_id);?>
                                </td>
                            </tr>
                        </table>
                    	<table width="600" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="100%" align="left" valign="top">
                                	<p><?php echo $msg;?></p>
                                    <form action='#' method="post">
                                        <table border="0" width="600" cellpadding="0" cellspacing="0">
                                        	<tr>
                                        		<td width="200" height="30" align="left" valign="top">Designation of your choice:</td> 
                                        		<td width="400"  height="30" align="left" valign="top">
                                                	<select name="country_id" id="country_id" style="width:200px;" onchange="getDestinationOptions('<?php echo $destination_id;?>')">
                                                        <option value="">Select Country</option>
                                                        <?php echo getCountryOptions($country_id);?>
                                                    </select>
                                                    <span style="color:red;">*</span></td>
                                        	</tr>
                                        	<tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                        		<td height="30" align="left" valign="top">Available Destinations:</td> 
                                        		<td height="30" align="left" valign="top">
                                                	<span id="tddestination">
                                                    <select name="destination_id" id="destination_id" style="width:200px;">
                                                        <option value="">Select Destination</option>
                                                        <?php echo getDestinationOptions($destination_id,$country_id);?>
                                                    </select>
                                                    </span>
                                                    <span style="color:red;">*</span></td>
                                        	</tr>  
                                            <tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                        		<td height="30" align="left" valign="top">No of days :</td> 
                                        		<td height="30" align="left" valign="top"><input style="width: 200px;" type="text" name="no_of_days" id="no_of_days" value="<?php echo $no_of_days;?>"/><span style="color:red;">*</span></td>
                                            </tr>
                                            <tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                        		<td height="30" align="left" valign="top">Time period :</td> 
                                        		<td height="30" align="left" valign="top">
                                                	From&nbsp;
                                                    <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:80px;" />
				                                    <script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                                    &nbsp;To&nbsp;
                                                    <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:80px;" />
                                                    <script>$('#end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                                    <span style="color:red;">*</span></td>
                                            </tr>
                                            <tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                        		<td height="30" align="left" valign="top">If in Group, please indicate Range:</td> 
                                        		<td height="30" align="left" valign="top">
                                                	<input name="group_start" id="group_start" type="text" value="<?php echo $group_start;?>" style="width:80px;" />
				                                    &nbsp;To&nbsp;
                                                    <input name="group_end" id="group_end" type="text" value="<?php echo $group_end;?>" style="width:80px;" />
                                                    </td>
                                            </tr>
                                            <tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                        		<td height="30" align="left" valign="top">Budget Range:</td> 
                                        		<td height="30" align="left" valign="top">
                                                	<input name="budget_start" id="budget_start" type="text" value="<?php echo $budget_start;?>" style="width:80px;" />
				                                    &nbsp;To&nbsp;
                                                    <input name="budget_end" id="budget_end" type="text" value="<?php echo $budget_end;?>" style="width:80px;" />(Indian Rs)
                                                    </td>
                                            </tr>
                                            <tr>
                                        		<td colspan="2" height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                            	<td height="30" align="left" valign="top">&nbsp;</td>
                                        		<td height="30" align="left" valign="top"><input type="submit" name="submit" id="submit" value="Submit" /></td> 
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
                	<td width="180" align="left" valign="top"><?php include_once('right_sidebar.php'); ?></td>
                </tr>
            </table>
			<?php include_once('footer.php'); ?>
        </td>
    </tr>
</table>
</body>
</html>