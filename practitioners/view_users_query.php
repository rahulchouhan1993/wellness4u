<?php
require_once('../config.php');
$page_id = '88';
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

$id = $_GET['id'];

if(!chk_valid_adviser_query_id($id,$pro_user_id))
{
	header ("Location: message.php");
	exit (0);
}
else
{
	setAdviserQueryRead($id,$pro_user_id,'1');
}

$query_data = getAdviserQueryDetails($id);
//echo '<pre>';
//print_r($query_data);
//echo '</pre>';
$all_queries_data =	getAllAdviserQueriesByID($id);
//echo '<pre>';
//print_r($all_queries_data);
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
                            	<td height="30" align="left"><input type="button" id="btnback" name="btnback" value="Back" onclick="window.location.href = 'my_users_queries.php'" /></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top">
                                <span class="Header_brown"><?php echo getMenuTitleOfPage($page_id);?></span><br /><br />
                                <?php echo getPageContents($page_id);?>
                                </td>
                            </tr>
                            <tr>
                            	<td align="left"><strong>Subject: <?php echo getReportTypeName($query_data[0]['page_id']); ?></strong></td>
                            </tr>
                            <tr>
                            	<td align="left"><strong>User Name: <?php echo getUserFullNameById($query_data[0]['user_id']); ?></strong></td>
                            </tr>
                        </table>
                        <form action="#" name="frmviewfeedback" id="frmviewfeedback" method="post"> 
                           <input type="hidden" name="hdn_id" id="hdn_id" value="<?php echo $id; ?>" />
                           	 <table width="940" align="center" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">	
										<tr>
                                    		<td colspan="7" align="left" valign="middle" bgcolor="#FFFFFF"><strong>Conversation</strong></td>
                               			</tr>
                                     	<tr>
                                            <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr No.</strong></td>
                                            <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Query Id</strong></td>
                                            <td width="30%"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>Queries & related Guidance</strong></td>
                                            <td width="15%"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>From</strong></td>
                                            <td width="15%"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>To</strong></td>
                                            <td width="10%"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>Date</strong></td>
                                            <td width="10%"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>Reply</strong></td>
                                         </tr>
							<?php  
							//for($i=0,$j=1;$i<count($arr_feedback_id);$i++,$j++)
							$i=1;
							foreach($all_queries_data as $record)
							{ 
								//$time= strtotime($arr_feedback_add_date[$i]);
								$time= strtotime($record['aq_add_date']);
								$time=$time+19800;
								$date = date('d-M-Y h:i A',$time);
								
								if($record['from_user'] == '1')
								{
									$from = getUserFullNameById($record['user_id']);
									$to = 'You';
								}
								else
								{
									$from = 'You';
									$to = getUserFullNameById($record['user_id']);
								}

								
								 ?>
                                    <tr>
                                        <td  align="center" valign="top" bgcolor="#FFFFFF" class="footer"><?php echo $i; ?></td>
                                        <td  align="left" valign="top" bgcolor="#FFFFFF" class="footer"><?php echo $record['aq_user_unique_id']; ?></td>
                                        <td  align="left" valign="top" bgcolor="#FFFFFF" class="footer"><?php echo $record['query']; ?></td>
                                        <td  align="left" valign="top" bgcolor="#FFFFFF" class="footer"><?php echo $from; ?></td>
                                        <td  align="left" valign="top" bgcolor="#FFFFFF" class="footer"><?php echo $to; ?></td>
                                        <td  align="left" valign="top" bgcolor="#FFFFFF" class="footer"><?php echo $date; ?></td>
                                        <td  align="center" valign="top" bgcolor="#FFFFFF" class="footer">
                                        <?php if($record['from_user'] == '1') { ?>
                                        <input style="width:45px; height:20px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:9px; font-weight:bold; vertical-align: text-top; color:#000000; padding-bottom:2px;" class="btnReply" type="button" name="btnReply" id="btnReply" value="Reply" onclick="showUserQueryPopup('<?php echo $record['aq_id']; ?>' )"/></td>
                                    </tr>
                            <?php  } 
								$i++;
							} ?>
						</table>
                      </form>
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