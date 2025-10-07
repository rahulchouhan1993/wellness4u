<?php
require_once('../config.php');
$page_id = '94';
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

if(chkAdviserPlanFeaturePermission($pro_user_id,'23'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}
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
			<?php include_once('header.php');?>
			<table width="980" border="0" cellspacing="0" cellpadding="0">
				<tr>
                    <td width="980" align="left" valign="top">
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
								<?php
                                if($page_access)
                                { ?>		
                                    <table border="1" style="border-collapse:collapse;" width="100%" cellpadding="1" cellspacing="1">
                                    <tbody>
                                        <tr>
                                            <td colspan="8" align="right">
                                            	<input type="button" name="btnAddNew" id="btnAddNew" value="Add New Question" onclick="javascript:window.location='add_sleep_question.php'" />
                                                
                                            </td>
                                        </tr>
                                        <tr class="manage-header">
                                            <td width="5%" class="manage-header" align="center" >S.No.</td>
                                            <td width="30%" class="manage-header" align="center">Question</td>
                                            <td width="15%" class="manage-header" align="center">Date Type</td>
                                            <td width="15%" class="manage-header" align="center">Date</td>
                                            <td width="10%" class="manage-header" align="center">Status</td>
                                            <td width="15%" class="manage-header" align="center">Post Date</td>
                                            <td width="5%" class="manage-header" align="center">Order</td>
                                            <td width="5%" class="manage-header" align="center">Edit</td>
                                        </tr>
                                        <?php
                                        echo getAllSleepQuestionsList($pro_user_id);
                                        ?>
                                    </tbody>
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
					</td>
					
				</tr>
			</table>            
			<?php include_once('footer.php');?>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top" background="images/top_back.jpg" style="background-repeat: repeat-x;">&nbsp;</td>
	</tr>
</table>
</body>
</html>