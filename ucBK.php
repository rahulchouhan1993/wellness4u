<?php
include('config.php');
$page_id = '0';
$page_title = 'Chaitanya Wellness Research Institute - Page Comming Soon';
$meta_keywords = 'Chaitanya Wellness Research Institute';
$meta_description = 'Chaitanya Wellness Research Institute';
$meta_title = 'Chaitanya Wellness Research Institute - Page Comming Soon';

if(isLoggedIn())
{
	doUpdateOnline($_SESSION['user_id']);
}
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
	<script type="text/javascript">
		$(document).ready(function(){
			$('#slider1').bxSlider();
			$('#slider2').bxSlider();
			
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
                   <td width="180" align="right" valign="top">
						<?php include_once('left_sidebar.php'); ?>
					</td>
					<td width="620" align="center" valign="top" class="Header_brown">
						<br /><br /><br />Page coming soon
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