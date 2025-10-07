<?php
require_once('../config.php');
$page_id = '99';
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

if(chkAdviserPlanFeaturePermission($pro_user_id,'21'))
{
	$page_access = true;
}
else
{
	$page_access = false;
}
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
     <link href="../csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">  
	<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="../js/commonfn.js"></script>
	<script type="text/javascript" src="../js/jquery.bxSlider.js"></script>
     <link href="../css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="../js/jquery.ticker.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
		
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
	<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
	<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
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
                        
                         </div>
                       </div>
                </div>
            </div>
<!--breadcrumb end --> 

<!--container-->              
<div class="container" >
<div class="row">	
<div class="col-md-12">	
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" valign="top">
									<span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br /><br />
								<?php
                                if($page_access)
                                { ?>	
                                    <table border="1" style="border-collapse:collapse;" width="100%" cellpadding="1" cellspacing="1">
                                    <tbody>
                                        <tr>
                                            <td colspan="8" align="right">
                                            	<input type="button" name="btnAddNew" id="btnAddNew" value="Add New Question" onclick="javascript:window.location='add_mr_question.php'" />
                                                
                                            </td>
                                        </tr>
                                        <tr class="manage-header" bgcolor="#CCCCCC">
                                            <td width="5%" class="manage-header" align="center" >S.No.</td>
                                            <td width="30%" class="manage-header" align="center">Question</td>
                                            <td width="15%" class="manage-header" align="center">Date Type</td>
                                            <td width="15%" class="manage-header" align="center">Date</td>
                                            <td width="10%" class="manage-header" align="center">Status</td>
                                            <td width="15%" class="manage-header" align="center">Post Date</td>
                                            <td width="5%" class="manage-header" align="center">Order</td>
                                            <td width="5%" class="manage-header" align="center">Edit</td>
                                        </tr>
                                        <?php
                                        echo getAllMRQuestionsList($pro_user_id);
                                        ?>
                                    </tbody>
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
								</td>
							</tr>
                            <tr>
                             <td> &nbsp; </td>
                            </tr>
						</table>
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
            <!--default footer end here-->

        
        <!--scripts and plugins -->
        <!--must need plugin jquery-->
        <script src="../csswell/js/jquery.min.js"></script>        
        <!--bootstrap js plugin-->
        <script src="../csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
       
    </body>

</html>			