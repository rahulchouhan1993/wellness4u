<?php
include('config.php');
$page_id = '46';

$main_page_id = $page_id;

list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description) = getPageDetails($page_id);



$ref = base64_encode('feedback.php');

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

  list($arr_feedback_id,$arr_pg_id,$arr_user_id,$arr_name,$arr_email,$arr_feedback,$arr_feedback_add_date,$arr_admin)  = GetFeedBack($user_id);



	

	

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="description" content="<?php echo $meta_description;?>" />

	<meta name="keywords" content="<?php echo $meta_keywords;?>" />

	<meta name="title" content="<?php echo $meta_title;?>" />

	<title><?php echo $meta_title;?></title>

	<link href="cwri.css" rel="stylesheet" type="text/css" />
 <link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
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
<!--container-->              
<div class="container" >
<div class="row">	
<div class="col-md-8">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

							<tr>

								<td align="left" valign="top">

									<span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br /><br />

									<?php echo getPageContents($page_id);?>

								</td>

							</tr>

						</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                       		<tr><td class="footer">(Click on to subject to view conversations)<br/></td></tr> 

                        </table>	

                        <input type="hidden" name="hdn_feedback_id" id="hdn_feedback_id" value="<?php echo $arr_feedback_id[$i]; ?>" />

<table width="100%" border="1" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">

                        	 	

								<tr>

									<td width="38"  align="left" valign="middle" bgcolor="#cccccc"><strong>Sr No.</strong></td>

                                    <td width="101"  align="left" valign="middle" bgcolor="#cccccc"><strong>Subject</strong></td>

			    					<td width="300"  align="left" valign="middle" bgcolor="#cccccc"><strong>Feedback</strong></td>

               						<td width="107"  align="left" valign="middle" bgcolor="#cccccc"><strong>Date</strong></td>

                          		</tr>


							<?php 
								for($i=0,$j=1;$i<count($arr_feedback_id);$i++,$j++)

									{ 

								   		
									    $time= strtotime($arr_feedback_add_date[$i]);
										$time=$time+19800;
										$date = date('d-M-Y h:i A',$time);
										$page_name = get_PageName($arr_pg_id[$i]);

											

											if($page_name == '')

											{

												$page_name = 'General';

											}

											else

											{

												$page_name = $page_name;

											}

												

											if($arr_admin[$i] == '0')

											{

												$to = 'Admin';

											}

											

											if($arr_admin[$i] == '1')

											{

												$to = 'User';

											}	

										

								 ?>

                                <tr>

                                	<td  align="center" valign="top" bgcolor="#FFFFFF" class="footer"><?php echo $i+1; ?></td>

                                    <td  align="left" valign="top" bgcolor="#FFFFFF"><a title="click here to view conversations" class="footer_link" href="view_feedback.php?id=<?php echo $arr_feedback_id[$i]; ?>"><?php echo $page_name;  ?></a></td>

                                  <td  align="left" valign="top" bgcolor="#FFFFFF" class="footer"><?php echo $arr_feedback[$i]; ?></td>

							      <td  align="left" valign="top" bgcolor="#FFFFFF" class="footer"><?php echo $date; ?></td>

                          </tr>

                            <?php } ?>

					  </table>

</div>
 <!-- ad left_sidebar-->
 <div class="col-md-2">	
<?php include_once('left_sidebar.php'); ?>						
</div>
 
<!-- ad right_sidebar-->
<div class="col-md-2">	
<?php include_once('right_sidebar.php'); ?>
 </div> 
 <!-- ad right_sidebar end -->
                   
   </div>	
</div>
<!--container-->                     
                   
      <br/>     
       <!--  Footer-->
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
   <!--must need plugin jquery-->
        <script src="csswell/js/jquery.min.js"></script>        
        <!--bootstrap js plugin-->
        <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
</body>
</html>