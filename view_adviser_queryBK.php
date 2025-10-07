<?php
include('config.php');
$page_id = '87';
$main_page_id = $page_id;
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$id = $_GET['id'];

if(!isLoggedIn())
{
	$ref = base64_encode('view_adviser_query.php?id='.$id);
	header("Location: login.php?ref=".$ref);
	exit(0);
}
else
{
	$user_id = $_SESSION['user_id'];
	doUpdateOnline($_SESSION['user_id']);
}

if(!chk_valid_user_query_id($id,$user_id))
{
	header ("Location: message.php");
	exit (0);
}
else
{
	setUserQueryRead($id,$user_id,'1');
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
			
			$(".QTPopup").css('display','none');
			$(".feedback").click(function(){
				$(".QTPopup").animate({width: 'show'}, 'slow');
			});	

			$(".btnReply").click(function(){
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
						
						<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
                            	<td height="30" align="left"><input type="button" id="btnback" name="btnback" value="Back" onclick="window.location.href = 'my_adviser_queries.php'" /></td>
                            </tr>
                            <tr>
								<td align="left" valign="top">
									<span class="Header_brown"><?php echo getPageTitle($main_page_id);?></span><br />
									<?php echo getPageContents($main_page_id);?>
								</td>
							</tr>
                            <tr>
                            	<td align="left"><strong>Subject: <?php echo getReportTypeName($query_data[0]['page_id']); ?></strong></td>
                            </tr>
                            <tr>
                            	<td align="left"><strong>Adviser Name: <?php echo getProUserFullNameById($query_data[0]['pro_user_id']); ?></strong></td>
                            </tr>
						</table><br/>
                        <form action="#" name="frmviewfeedback" id="frmviewfeedback" method="post"> 
                           <input type="hidden" name="hdn_id" id="hdn_id" value="<?php echo $id; ?>" />
                           	 <table width="760" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">	
										<tr>
                                    		<td colspan="7" align="left" valign="middle" bgcolor="#FFFFFF"><strong>Conversation</strong></td>
                               			</tr>
                                     	<tr>
                                            <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr No.</strong></td>
                                            <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Query Id.</strong></td>
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
									$from = 'You';
									$to = getProUserFullNameById($record['pro_user_id']);
								}
								else
								{
									$from = getProUserFullNameById($record['pro_user_id']);
									$to = 'You';
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
                                        <?php if($record['from_user'] == '0') { ?>
                                        <input style="width:45px; height:20px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:9px; font-weight:bold; vertical-align: text-top; color:#000000; padding-bottom:2px;" class="btnReply" type="button" name="btnReply" id="btnReply" value="Reply" onclick="showAdviserQueryPopup('<?php echo $record['aq_id']; ?>' )"/><?php }?></td>
                                    </tr>
                            <?php   
								$i++;
							} ?>
						</table>
                                                <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                    <?php echo getScrollingWindowsCodeMainContent($page_id);?>
                                    <?php echo getPageContents2($page_id);?>
                                </td>
                            </tr>
                        </table>
                      </form>
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