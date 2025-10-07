<?php
include('config.php');
$page_id = '46';
$main_page_id = $page_id;
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('feedback.php');
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

if(chkUserPlanFeaturePermission($user_id,'31'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}

list($arr_feedback_id,$arr_pg_id,$arr_user_id,$arr_name,$arr_email,$arr_feedback,$arr_feedback_add_date,$arr_admin)  = GetFeedBack($user_id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
			
			$("#feedback_reply").click(function(){
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
                    	<table width="580" border="0" align="center" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td align="left" valign="top"><span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br /><br /><?php echo getPageContents($page_id);?></td>
                            </tr>
                        </table>
                        
                         <?php
						if($page_access)
						{ ?>
                        <table width="580" border="0" align="center" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td class="footer">(Click on to subject to view conversations)</td>
                            </tr>
                        </table>	
                        <input type="hidden" name="hdn_feedback_id" id="hdn_feedback_id" value="<?php echo $arr_feedback_id[$i]; ?>" />
                        <table width="580" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                        	<tr>
                            	<td width="38"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>Sr No.</strong></td>
                                <td width="101"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>Subject</strong></td>
                                <td width="300"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>Feedback</strong></td>
                                <td width="107"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>Date</strong></td>
                           	</tr>
							<?php  
							for($i=0,$j=1;$i<count($arr_feedback_id);$i++,$j++)
							{ 
								$time = strtotime($arr_feedback_add_date[$i]);
								$time = $time + 19800;
								$date = date('d-M-Y h:i A',$time);
								$page_name = get_PageName($arr_pg_id[$i]);
								
								if($page_name == '')
								{
									$page_name = 'General';
								}
								else
								{
									$page_name = $page_name;
								}
								
								if($arr_admin[$i] == '0')
								{
									$to = 'Admin';
								}
								
								if($arr_admin[$i] == '1')
								{
									$to = 'User';
								}	?>
                          	<tr>
                            	<td  align="center" valign="top" bgcolor="#FFFFFF" class="footer"><?php echo $i+1; ?></td>
                                <td  align="left" valign="top" bgcolor="#FFFFFF"><a title="click here to view conversations" class="footer_link" href="view_feedback.php?id=<?php echo $arr_feedback_id[$i]; ?>"><?php echo $page_name;  ?></a></td>
                                <td  align="left" valign="top" bgcolor="#FFFFFF" class="footer"><?php echo $arr_feedback[$i]; ?></td>
                                <td  align="left" valign="top" bgcolor="#FFFFFF" class="footer"><?php echo $date; ?></td>
                           	</tr>
							<?php } ?>
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
                    <td width="180" align="left" valign="top"><?php include_once('left_sidebar.php'); ?></td>
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