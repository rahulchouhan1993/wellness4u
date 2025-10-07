<?php

include('config.php');

$page_id = '28';

list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

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

	<script>

	<!--

		function doit()

		{

			if (!window.print)

			{

				alert("You need NS4.x to use this print button!")

				return

			}

			window.print()

		}

	//--> 

	</script>

    

    <script type="text/javascript">

   $(document).ready(function() {

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

<table cellspacing="0" cellpadding="2" border="0" width="95%" align="center">

	<tbody>

		<tr>

			<td align="left" valign="top" class="Header_brown" style="padding-top:10px;">

				<a href="javascript:doit()"><img height="16" border="0" width="34" src="images/print_button.gif"></a><br /><br />

				<strong><?php echo getPageTitle($page_id);?></strong>

			</td>

		</tr>

		<tr>

			<td align="left" valign="top">

				<?php echo getPageContents($page_id);?>

			</td>

		</tr>

	</tbody>

</table>

</body>

</html>