<?php
require_once('../config.php');
$page_id = '86';
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

if(chkAdviserPlanFeaturePermission($pro_user_id,'24'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}

if(isset($_POST['btnSubmit']))	
{
	$user_id = strip_tags(trim($_POST['user_id']));
	$pg_id = strip_tags(trim($_POST['pg_id']));
	$start_date = strip_tags(trim($_POST['start_date']));
	$end_date = strip_tags(trim($_POST['end_date']));
	$search_keywords = strip_tags(trim($_POST['search_keywords']));
}
else
{
	$user_id = '';
	$pg_id = '';
	//$start_date = date('d-m-Y');
	//$end_date = date('d-m-Y');
	$start_date = '';
	$end_date = '';
	$search_keywords = '';
}

if(isset($_POST['user_id']))	
{
	$user_id = strip_tags(trim($_POST['user_id']));
}
elseif(isset($_SESSION['user_query_user_id']))	
{
	$user_id = $_SESSION['user_query_user_id'];
}
else
{
	$user_id = '';
}

if(isset($_POST['pg_id']))	
{
	$pg_id = strip_tags(trim($_POST['pg_id']));
}
elseif(isset($_SESSION['user_query_pg_id']))	
{
	$pg_id = $_SESSION['user_query_pg_id'];
}
else
{
	$pg_id = '';
}

if(isset($_POST['start_date']))	
{
	$start_date = strip_tags(trim($_POST['start_date']));
}
elseif(isset($_SESSION['user_query_start_date']))	
{
	$start_date = $_SESSION['user_query_start_date'];
}
else
{
	$start_date = '';
}

if(isset($_POST['end_date']))	
{
	$end_date = strip_tags(trim($_POST['end_date']));
}
elseif(isset($_SESSION['user_query_end_date']))	
{
	$end_date = $_SESSION['user_query_end_date'];
}
else
{
	$end_date = '';
}

if(isset($_POST['search_keywords']))	
{
	$search_keywords = strip_tags(trim($_POST['search_keywords']));
}
elseif(isset($_SESSION['user_query_search_keywords']))	
{
	$search_keywords = $_SESSION['user_query_search_keywords'];
}
else
{
	$search_keywords = '';
}

$_SESSION['user_query_user_id'] = $user_id;
$_SESSION['user_query_pg_id'] = $pg_id;
$_SESSION['user_query_start_date'] = $start_date;
$_SESSION['user_query_end_date'] = $end_date;
$_SESSION['user_query_search_keywords'] = $search_keywords;

if($start_date == '' || $end_date == '')
{
	$error = true;
	$err_msg = '<span class="Header_blue">Please select From and To date.</span>';
}
else
{
	$referral_data = getAllAdviserUserQueries($pro_user_id,$user_id,$pg_id,$start_date,$end_date,$search_keywords);
	
	if(count($referral_data) > 0)
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


//echo '<pre>';
//print_r($referral_data);
//echo '</pre>';
?><!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $meta_description;?>" />
	<meta name="keywords" content="<?php echo $meta_keywords;?>" />
	<meta name="title" content="<?php echo $meta_title;?>" />
	<title><?php echo $meta_title;?></title>
	<link href="../cwri.css" rel="stylesheet" type="text/css" />
    <link href="../csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">       <link href="../csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />
	<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="../js/commonfn.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
	<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
   
    <style type="text/css">@import "css/jquery.datepick.css";</style> 
	<script type="text/javascript" src="../js/jquery.datepick.js"></script>
    
    <link href="../css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="../js/jquery.ticker.js" type="text/javascript"></script>
    
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
<body id="boxed">
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>

<div class="boxed-wrapper">
<!--header-->
<header>
 <?php include 'topbar.php'; ?>
<?php include_once('header.php');?>
</header>
<!--header End --> 			
<!--breadcrumb--> 
  
 <div class="container"> 
    <div class="breadcrumb">
               
                    <div class="row">
                    <div class="col-md-8">	
                      <?php echo getBreadcrumbCode($page_id);?> 
                       </div>
                         <div class="col-md-4">
                         <?php

                    if(isLoggedIn())

                    { 

                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);

                    }

                    ?>
                         </div>
                       </div>
                </div>
 </div>          
<!--breadcrumb end --> 
<div class="container" >
<div class="row">	
<div class="col-md-12">	
	
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                <span class="Header_brown"><?php echo getMenuTitleOfPage($page_id);?></span><br /><br />
                                <?php echo getPageContents($page_id);?>
                                </td>
                            </tr>
                        </table>
                        <?php
						if($page_access)
						{ ?>
                        <form name="frmadviserquery" method="post" action="#" >
                        <table width="80%" border="0" align="left" cellpadding="5" cellspacing="1" >
                        	<tr>
                            	<td width="20%" height="50" align="left" valign="middle" bgcolor="#FFFFFF">
                                	
                                    <strong>From date</strong></td><td width="25%">
                                    <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" class="form-control" />
                                    <script>$('#start_date').datepick({ dateFormat : 'dd-mm-yy'}); </script></td>
                                    <td width="5%"></td>
                                    <td width="15%"><strong>To date</strong></td><td width="30%">
                                    <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" class="form-control" />
                                    <script>$('#end_date').datepick({ dateFormat : 'dd-mm-yy'}); </script>
                                   </td></tr>
                                   <tr>
                                   <td width="20%" height="50">
                                    <strong>Search Keyword</strong>
     <td  >                               <input name="search_keywords" id="search_keywords" type="text" value="<?php echo $search_keywords;?>" class="form-control" />
                                	
                                </td>
                               <td width="5%"></td>
                                    <td >
                                    </td>
                                    <td width="5%"></td>
                           	</tr>
                            <tr>
                            	<td width="20%" align="left" valign="middle" bgcolor="#FFFFFF" height="50">
                                	
                                    <label><strong>Search For</strong></label></td><td width="25%">
                                    <select name="user_id" id="user_id" class="form-control" onchange="getUserQueryPageOptions('<?php echo $pro_user_id;?>','','user_id','pg_id');">
                                        <option value="">All Users</option>
                                        <?php echo getAdvisersUserOptions($user_id,$pro_user_id); ?>
                                    </select>    
                                  </td>
                                  <td width="5%"></td>
                                  <td width="15%">
                                    <label><strong>Reference </strong></label></td><td width="30%">
                                    <span id="idreference">
                                    <select name="pg_id" id="pg_id" class="form-control">
                                        <option value="">All References</option>
                                        <?php echo getUserQueryPageOptions($pg_id,$user_id,$pro_user_id); ?>
                                    </select>  
                                    </span>    
                                    &nbsp;
                                   
                                	
                                </td>
                               
                           	</tr>
                            <tr>                             <td height="50">
                           

                            </td>
                            
                            <td colspan="4">
                             <input type="submit" name="btnSubmit" value="Search" class="btn btn-primary" />
                            </td>
                           
                            </tr>
                        </table>
                        </form>
                         <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td class="footer" height="30">&nbsp;</td>
                            </tr>
                        </table>	
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="100%" align="left" valign="top">
                            		
									<?php 
									if(!$error)
									{
										$arr_temp_user_id = array();
										foreach($referral_data as $record) 
                                        {
									 		array_push($arr_temp_user_id,$record['user_id']);
									 	}
										$arr_temp_user = array_unique($arr_temp_user_id);
										$arr_temp_user = array_values($arr_temp_user);
										
										for($k=0;$k<count($arr_temp_user);$k++)
										{
										
											$request_status = chkIfUserIsAdvisersReferrals($pro_user_id,$arr_temp_user[$k]);
											if($request_status)
											{
												$adviser_status = '<span class="Header_blue">Activated By User</span>';
											}
											else
											{
												$adviser_status = '<span class="Header_red">Deactivated By User</span>';
											}	
									
									?>
                                    	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="20%" align="left" valign="middle"><strong>User Name: <?php echo getUserFullNameById($arr_temp_user[$k]);?></strong></td>
                                                <td width="20%" align="left" valign="middle"><strong>Status: <?php echo $adviser_status;?></strong></td>
                                                
                                            </tr>
                                            
                                        </table>
                                        
                                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td height="30">&nbsp;</td>
                                            </tr>
                                        </table>
                                    
                                        <table width="100%" border="1" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                                            <tr bgcolor="#CCCCCC">
                                                <td width="5%"  align="left" valign="middle" ><strong>Sr No.</strong></td>
                                                <td width="10%"  align="left" valign="middle" ><strong>Query / Guidance ID</strong></td>
                                                <td width="20%"  align="left" valign="middle" ><strong>Reference</strong></td>
                                                <td width="45%"  align="left" valign="middle" ><strong>Queries & related Guidance</strong></td>
                                                <td width="10%"  align="left" valign="middle" ><strong>Date</strong></td>
                                                <td width="10%"  align="left" valign="middle" ><strong>&nbsp;</strong></td>
                                            </tr>
										<?php 
                                        $i=1;
                                        foreach($referral_data as $record) 
                                        {
											 if($record['user_id'] == $arr_temp_user[$k])
											 {
											 	$time = strtotime($record['aq_add_date']);
												$time = $time + 19800;
												$date = date('d-M-Y h:i A',$time);
												$pg_name = getReportTypeName($record['page_id']);
												
												if($record['page_id'] > 0)
												{
													if($record['permission_type'] == '1')
													{
														$pg_name .= ' (Adviser Set)';	
													}
													else
													{
														$pg_name .= ' (Standard Set)';
													}
												}
												
												if($record['pro_user_read'] == '1')
												{
													$td_class = 'qryread';
													$td_title = 'Make Unread';
													$toggle_action = 'unread';
												}
												else
												{
													$td_class = 'qryunread';
													$td_title = 'Make Read';
													$toggle_action = 'read';
												}
											 
												?>
                                            <tr onmouseover="showRoundIcon('<?php echo $record['aq_id'];?>')" onmouseout="hideRoundIcon('<?php echo $record['aq_id'];?>')">
                                                <td id="td1id_<?php echo $record['aq_id'];?>" height="30" align="center" valign="middle" class="<?php echo $td_class;?>">
                                                	<div style="float:left;width:70px;">
                                                        <div style="float:left;width:5px;">
                                                        	<input type="hidden" name="hdntoggle_action" id="hdntoggle_action_<?php echo $record['aq_id'];?>" value="<?php echo $toggle_action;?>"  />
                                                            <div style="display:none;" id="roundicon_<?php echo $record['aq_id'];?>" class="roundicon" title="<?php echo $td_title;?>" onclick="toggleReadUnreadQuery('<?php echo $record['aq_id'];?>')" ></div>
                                                        </div>    
                                                        <div style="float:right;width:60px;"><?php echo $i; ?></div>
                                                    </div>
                                                </td>
                                                <td id="td2id_<?php echo $record['aq_id'];?>" height="30" align="left" valign="middle" class="<?php echo $td_class;?>"><?php echo $record['aq_user_unique_id'];  ?></td>
                                                <td id="td3id_<?php echo $record['aq_id'];?>" height="30" align="left" valign="middle" class="<?php echo $td_class;?>"><?php echo $pg_name;  ?></td>
                                                <td id="td4id_<?php echo $record['aq_id'];?>" height="30" align="left" valign="middle" class="<?php echo $td_class;?>"><?php echo $record['query']; ?></td>
                                                <td id="td5id_<?php echo $record['aq_id'];?>" height="30" align="left" valign="middle" class="<?php echo $td_class;?>"><?php echo $date; ?></td>
                                                <td id="td6id_<?php echo $record['aq_id'];?>" height="30" align="left" valign="middle" class="<?php echo $td_class;?>"><?php if($record['from_user'] == '1'  && $request_status) { ?>
												<input style="width:45px; height:20px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:9px; font-weight:bold; vertical-align: text-top; color:#000000; padding-bottom:2px;" class="btnReply" type="button" name="btnReply" id="btnReply" value="Reply" onclick="showUserQueryPopup('<?php echo $record['aq_id']; ?>' )"/><?php }?></td>
                                            </tr>
										<?php
										$all_queries_data =	getAllAdviserQueriesByID($record['aq_id']);
										
										if(count($all_queries_data) > 0)
										{ 
											$l=1;
											foreach($all_queries_data as $record2)
											{ 
											
												if($record2['aq_id'] != $record['aq_id'])
												{	
												
												
													$time = strtotime($record2['aq_add_date']);
													$time = $time + 19800;
													$date = date('d-M-Y h:i A',$time);
													
													
													$pg_name = getReportTypeName($record2['page_id']);
													if($record2['page_id'] > 0)
													{
														if($record2['permission_type'] == '1')
														{
															$pg_name .= ' (Adviser Set)';	
														}
														else
														{
															$pg_name .= ' (Standard Set)';
														}
													}
													if($record2['user_read'] == '1')
													{
														$td_class = 'qryread';
														$td_title = 'Make Unread';
														$toggle_action = 'unread';
													}
													else
													{
														$td_class = 'qryunread';
														$td_title = 'Make Read';
														$toggle_action = 'read';
													}
												
										
										?>
									
									
									
									<tr onmouseover="showRoundIcon('<?php echo $record2['aq_id'];?>')" onmouseout="hideRoundIcon('<?php echo $record2['aq_id'];?>')"> 
										<td id="td1id_<?php echo $record2['aq_id'];?>"  align="center" valign="top" class="<?php echo $td_class;?>">
											<div style="float:left;width:70px;">
												<div style="float:left;width:5px;">
													<input type="hidden" name="hdntoggle_action" id="hdntoggle_action_<?php echo $record2['aq_id'];?>" value="<?php echo $toggle_action;?>"  />
													<div style="display:none;" id="roundicon_<?php echo $record2['aq_id'];?>" class="roundicon" title="<?php echo $td_title;?>" onclick="toggleReadUnreadQuery('<?php echo $record2['aq_id'];?>')" ></div>
												</div>    
												<div style="float:right;width:60px;">&nbsp;</div>
											</div>
										</td>
										<td id="td2id_<?php echo $record2['aq_id'];?>" align="left" valign="top" class="<?php echo $td_class;?>"><?php echo $record2['aq_user_unique_id'];  ?></td>
										<td id="td3id_<?php echo $record2['aq_id'];?>" align="left" valign="top" class="<?php echo $td_class;?>"><?php echo $pg_name;  ?></td>
										<td id="td4id_<?php echo $record2['aq_id'];?>" align="left" valign="top" class="<?php echo $td_class;?>"><?php echo $record2['query']; ?></td>
										<td id="td5id_<?php echo $record2['aq_id'];?>" align="left" valign="top" class="<?php echo $td_class;?>"><?php echo $date; ?></td>
										
										<td id="td6id_<?php echo $record2['aq_id'];?>" align="left" valign="top" class="<?php echo $td_class;?>"><?php if($record2['from_user'] == '1'  && $request_status) { ?>
												<input style="width:45px; height:20px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:9px; font-weight:bold; vertical-align: text-top; color:#000000; padding-bottom:2px;" class="btnReply" type="button" name="btnReply" id="btnReply" value="Reply" onclick="showUserQueryPopup('<?php echo $record2['aq_id']; ?>' )"/><?php }?></td>
									</tr>
										
										
										
										
										<?php
												}
											}
											$l++;
										} 
											
											
											
											
											
											
											
											
											
											
											
											$i++;  
											}	
										} ?>
                                        </table>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        	<tr>
                                        		<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                                        	</tr>
                                        </table>
									<?php
										}	
                                    } 
                                    else 
                                    { ?>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        	<tr>
                                        		<td height="30" align="left" valign="middle" bgcolor="#FFFFFF" class="err_msg"><?php echo $err_msg;?></td>
                                        	</tr>
                                        </table>
									<?php
                                    } ?>
                                </td>
                            </tr>
                        </table>
						<?php 
						} 
						else 
						{ ?>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
								<tr align="center">
									<td height="5" class="Header_brown"><?php echo getCommonSettingValue('4');?></td>
								</tr>
							</table>
						<?php 
						} ?>	             
          
 </div>	
</div>
</div>
<!--container-->                   <!--  Footer-->
  <footer> 
   <div class="container">
   <div class="row">
   <div class="col-md-12">	
   <?php include_once('footer.php');?>            
  </div>
  </div>
  </div>
  </footer>
  <!--  Footer-->
</div>
<!-- Bootstrap Core JavaScript -->

 <!--default footer end here-->
       <!--scripts and plugins -->
        <!--must need plugin jquery-->
<!--        <script src="../csswell/js/jquery.min.js"></script>  -->      
        <!--bootstrap js plugin-->
        <script src="../csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
</body>
</html>