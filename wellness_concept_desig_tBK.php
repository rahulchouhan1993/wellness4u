<?php
include('config.php');
$page_id = '18';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

if(isLoggedIn())
{
	$user_id = $_SESSION['user_id'];
	doUpdateOnline($_SESSION['user_id']);
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

	<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>

    <link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
    
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

			

			$('#gallery a').lightBox();

			

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

                	

                 

					<td width="620" align="left" valign="top">

						

						<table width="580" align="center" border="0" cellspacing="0" cellpadding="0">
                            <tr>
	                            <td height="40" align="left" valign="top" class="breadcrumb">
                                	<?php echo getBreadcrumbCode($page_id);?>
                                </td>
                            </tr>
                        </table>     
                                            
                                            <table width="580" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                    <?php echo getScrollingWindowsCodeMainContent($page_id);?>
                                    <?php echo getPageContents2($page_id);?>
                                </td>
                            </tr>
                        </table>

						<div id="gallery" align="center">

							<a href="images/training_diagram_large.jpg" title="Wellness"> 

								<img src="images/training_diagram.jpg" border="0" width="550" height="405" />

							</a>

						</div>

					</td>
                                    
                                    <td width="180" align="left" valign="top">

						<?php include_once('left_sidebar.php'); ?>

					</td>

					<td width="180" align="left" valign="top">

						<?php include_once('right_sidebar.php'); ?>

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