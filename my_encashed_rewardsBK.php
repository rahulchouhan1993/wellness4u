<?php
include('config.php');
$page_id = '111';
$main_page_id = $page_id;
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('my_encashed_rewards.php');
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

if(chkUserPlanFeaturePermission($user_id,'34'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}

$error = false;
$err_msg = '';

if(isset($_POST['reward_list_module_id']))	
{
	$reward_list_module_id = strip_tags(trim($_POST['reward_list_module_id']));
}
elseif(isset($_GET['reward_list_module_id']))	
{
	$reward_list_module_id = strip_tags(trim($_GET['reward_list_module_id']));
}
else
{
	$reward_list_module_id = '';
}

if(isset($_POST['start_date']))	
{
	$start_date = strip_tags(trim($_POST['start_date']));
}
elseif(isset($_GET['start_date']))	
{
	$start_date = strip_tags(trim($_GET['start_date']));
}
else
{
	$start_date = '';
}

if(isset($_POST['end_date']))	
{
	$end_date = strip_tags(trim($_POST['end_date']));
}
elseif(isset($_GET['end_date']))	
{
	$end_date = strip_tags(trim($_GET['end_date']));
}
else
{
	$end_date = '';
}

if($start_date == '' || $end_date == '')
{
	$error = true;
	$err_msg = '<span class="Header_blue">Please select From and To date.</span>';
}
else
{
	$arr_encashed_rewards  = getUsersAllEncashedRewards($user_id,$reward_list_module_id,$start_date,$end_date);
	
	//echo '<br><pre>';
	//print_r($arr_encashed_rewards);
	//echo '<br></pre>';
	
	if(count($arr_encashed_rewards) > 0)
	{
		$error = false;
		$err_msg = '';
	}
	else
	{
		$error = true;
		$err_msg = '<span class="err_msg">No Records Found!</span>';
	}
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
                            	<td align="left" valign="top"><span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br /><br /><?php echo getPageContents($page_id);?></td>
                            </tr>
                        </table>
					<?php
                    if($page_access)
                    { ?>
                        <form name="frmadviserquery" method="post" action="#" >
                        <table width="760" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                        	<tr>
                            	<td width="100%" align="left" valign="middle" bgcolor="#FFFFFF">
                                	
                                    
                                    <strong>From date</strong>
                                    <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:80px;" />
                                    <script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                    &nbsp;<strong>To date</strong>
                                    <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:80px;" />
                                    <script>$('#end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                    &nbsp;
                                    <strong>Modules:</strong>
                                    <select id="reward_list_module_id" name="reward_list_module_id" style="width:120px;">
                                        <option value="">All</option>
                                        <?php echo getRewardModuleOptions($reward_list_module_id);?>
                                    </select>
                                	 &nbsp;
                                    <input type="submit" name="btnSubmit" value="Search" />
                                </td>
                               
                           	</tr>
                           
                        </table>
                        </form>
                         <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td class="footer" height="30">&nbsp;</td>
                            </tr>
                        </table>	
                        
                        <?php
						if(!$error)
						{ ?>
						<table width="760" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                        	<tr>
                            	<td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr No.</strong></td>
                                <td width="20%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Module</strong></td>
                                <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Encashed Type</strong></td>
                                <td width="20%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Encashed Points</strong></td>
                                <td width="40%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Reward</strong></td>
                                <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Date</strong></td>
                            </tr>
							<?php  
							$j=1;
							foreach($arr_encashed_rewards as $key => $row)
							{ 
								$time = strtotime($row['redeam_date']);
								$time = $time + 19800;
								$date = date('d-M-Y h:i A',$time);
								
								$reward_file_type = stripslashes($row['reward_list_file_type']);
								$reward_file = stripslashes($row['reward_list_file']);
								$reward_module_title = stripslashes($row['reward_module_title']);
								
								$random_all_module_no = $row['random_all_module_no'];
								if($random_all_module_no == '0')
								{
									$encashed_type = 'Module Based';
								}
								else
								{
									$encashed_type = 'Total Points/All Module';
								}
								
								
								$reward_file_str = '';
								
								if($reward_file != '')
								{  
									if($reward_file_type == 'Pdf')
									{
										$reward_file_str = '<a target="_blank" href="'.SITE_URL.'/uploads/'.$reward_file.'"><img border="0" src="images/pdf-download-icon.png" width="50" height="50"  /> </a>';
									}
									elseif($reward_file_type == 'Video')
									{   
										$video_url = getYoutubeString($reward_file);
										$reward_file_str = '<a target="_blank" href="'.$video_url.'">'.$video_url.'</a>';
									}
									else
									{ 
										$reward_file_str = '<ul class="zoomonhoverul">
											<li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $reward_file.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $reward_file.'" width="100" alt="gallery thumbnail" /></a></li>
										</ul>';
					
									}		
								}
								?>
                          	<tr>
                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $j;?></td>
                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $reward_module_title;?></td>
                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $encashed_type;?></td>
                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo stripslashes($row['encashed_points']);?></td>
                                <td height="30" align="left" valign="middle" bgcolor="#FFFFFF">
                                    <div style="width:240px;float:left;margin-left:5px;margin-right:5px;">
                                        <div style="width:135px;float:left;"><?php echo stripslashes($row['reward_list_name']);?></div>
                                        <div style="width:100px;float:left;text-align:right;margin-right:5px;"><?php echo $reward_file_str;?></div>
                                    </div>
                                </td>
                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $date;?></td>
                            </tr>
								<?php
								$j++;
							} 
							?>
                    	</table>
                        <table width="760" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                            </tr>
                        </table>
                        
						<?php
                        }	
                        else
                        {
                        ?>
                         <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td><?php echo $err_msg;?></td>
                            </tr>
                        </table>
                        <?php
						} ?>
                        
                        
					<?php 
                    } 
                    else 
                    { ?>
                        <table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr align="center">
                                <td height="5" class="Header_brown"><?php echo getCommonSettingValue('3');?></td>
                            </tr>
                        </table>
                    <?php 
                    } ?>	
                            <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
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
                </tr>
            </table>
			<?php include_once('footer.php'); ?>
		</td>
	</tr>
</table>
<script type="text/javascript">
imagePreview();
</script>
</body>
</html>