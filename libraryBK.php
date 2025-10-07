<?php
include('config.php');
$page_id = '49';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$ref = base64_encode('library.php');
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

if(chkUserPlanFeaturePermission($user_id,'33'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}

list($arr_library_id,$arr_pg_id,$arr_values,$arr_library_add_date,$arr_note) = getMyLibrary($user_id);
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
				Library_Feedback('<?php echo $page_id ;?>')
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
                                <td align="left" valign="top">
                                <span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br /><br />
                                <?php echo getPageContents($page_id);?>
                                </td>
                            </tr>
                        </table>
                         <?php
						if($page_access)
						{ ?>
                        <table  width="580" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                            <tr>
                                <td>
                                    <label><strong>Search For - :</strong></label>
                                    <select name="page_id" id="page_id" style="width:100px;">
                                        <option value="">Select Page</option>
                                        <option value="10">Anger Vent Box</option>
                                        <option value="9">Stress Buster Box</option>
                                        <option value="44">Mind Jumble Box</option>
                                        <option value="127">My Wellness Solutions</option>
                                    </select>    
                                    &nbsp;
                                    <select name="day" id="day">
                                        <option value="">Select Day</option>
                                    <?php
                                    for($i=1;$i<=31;$i++)
                                    { ?>
                                        <option value="<?php echo $i;?>" <?php if($day == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                    <?php
                                    } ?>	
                                    </select>
                                    &nbsp;
                                    <select name="month" id="month">
                                        <option value="">MONTH</option>
                                        <?php echo getMonthOptions($month); ?>
                                    </select>
                                    &nbsp;
                                    <select name="year" id="year">
                                        <option value="">YEAR</option>
                                    <?php
                                    for($i=2008;$i<=2050;$i++)
                                    { ?>
                                        <option value="<?php echo $i;?>" <?php if($year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                    <?php
                                    } ?>	
                                    </select>
                                    &nbsp;
                                    <input type="Submit" name="btnSubmit" value="Search" onclick="Search_Library()"/>
                                </td>
                            </tr>
                        </table>
                        <div id="Search_Library" ><?php echo search_library($user_id,$pg_id,$start_date); ?></div>
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
                    <td width="180" align="left" valign="top">
                        <?php include_once('left_sidebar.php'); ?>
                    </td>
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