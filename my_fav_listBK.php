<?php
include('config.php');
$page_id = '72';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$ref = base64_encode('my_fav_list.php');
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

if(chkUserPlanFeaturePermission($user_id,'30'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}

$start_date = date('d-m-Y');
$end_date = date('d-m-Y');
$ufs_cat_id = '';
list($arr_ufs_id,$arr_page_id,$arr_sc_id,$arr_ufs_note,$arr_ufs_cat_id,$arr_ufs_priority,$arr_ufs_add_date) = getMyFavList($user_id);
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
                        <table width="790" border="0" align="center" cellpadding="0" cellspacing="0">
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
                        <form name="frmmyfavlist" id="frmmyfavlist" method="post" action="#">
                        <table  width="790" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                            <tr>
                                <td>
                                    <label><strong>Search For - :</strong></label>
                                    <select name="ufs_cat_id" id="ufs_cat_id" style="width:120px;">
                                        <option value="">All Category</option>
                                        <?php echo getFavCategoryOptions($ufs_cat_id); ?>
                                    </select>    
                                    &nbsp;
                                    <select name="pg_id" id="pg_id" style="width:100px;">
                                        <option value="">All Pages</option>
                                        <?php echo getScrollingWindowsPagesOptions($pg_id); ?>
                                    </select>    
                                    &nbsp;
                                    
                                    <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:80px;" />
                                    <script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                    &nbsp;
                                    <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:80px;" />
                                    <script>$('#end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                    &nbsp;
                                    <input type="button" name="btnSubmit" value="Search" onclick="Search_MyFavList()"/>
                                </td>
                            </tr>
                        </table>
                        <div id="Search_MyFavList" ><?php echo search_myfavlist($user_id,$pg_id,$start_date,$end_date,$ufs_cat_id); ?></div>
                        </form>
                        <table width="790" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                    <?php echo getScrollingWindowsCodeMainContent($page_id);?>
                                    <?php echo getPageContents2($page_id);?>
                                </td>
                            </tr>
                        </table>
                        <?php 
						} 
						else 
						{ ?>
							<table width="790" border="0" cellspacing="0" cellpadding="0" align="center">
								<tr align="center">
									<td height="5" class="Header_brown"><?php echo getCommonSettingValue('3');?></td>
								</tr>
							</table>
						<?php 
						} ?>	
                    </td>
                    <td width="180" align="left" valign="top">
                        <?php include_once('left_sidebar.php'); ?>
                    </td>
                </tr>
			</table>
			<?php include_once('footer.php'); ?>
		</td>
	</tr>
</table>
</body>
</html>