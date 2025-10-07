<?php

include('config.php');

$page_id = '48';

list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);





/*  Top Banner  size( 940 X 150 )  */

list($position1,$width1,$height1,$url1,$banner_type1,$page1,$banner1) = gethomeImage($page_id,'Top'); 

/*  Left Banner size ( 160 X 500)   */

list($position2,$width2,$height2,$url2,$banner_type2,$page2,$banner2) = gethomeImage($page_id,'Left'); 

/*  Right Top Banner size ( 160 X 300 )*/

list($position3,$width3,$height3,$url3,$banner_type3,$page3,$banner3) = gethomeImage($page_id,'Right Top'); 

/*  Right Middle Banner size (160 X 300 ) */

list($position4,$width4,$height4,$url4,$banner_type4,$page4,$banner4) = gethomeImage($page_id,'Right Middle'); 

/*  Right Bottom Banner size ( 160 X 300 ) */

list($position5,$width5,$height5,$url5,$banner_type5,$page5,$banner5) = gethomeImage($page_id,'Right Bottom'); 

/*   Left Middle Banner size ( 160 X 300)*/

list($position6,$width6,$height6,$url6,$banner_type6,$page6,$banner6) = gethomeImage($page_id,'Left Middle'); 

/* End of Banner */





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



	

	

//list($arr_feedback_id,$arr_page_id,$arr_user_id,$arr_name,$arr_email,$arr_feedback,$arr_feedback_add_date)  = GetFeedBack($user_id);

  

//$str_feedback_id = GetAllConvarsation($id);

//echo $str_feedback_id;

//list($arr_feedback_id,$arr_feedback,$arr_name,$arr_feedback_add_date,$arr_admin,$arr_feedback_id,$arr_page_id)	= GetAllFeedBackByID($str_feedback_id);

//list($arr_feedback_id,$arr_feedback,$arr_name,$arr_feedback_add_date,$arr_admin,$arr_page_id)=	getALLCommentsONfeedback($id);

	

$error = false;

$tr_err_reply = 'none';



$err_reply = '';



if(isset($_POST['btnSubmit']))	

{

	$id = $_POST['hdn_id'];

	echo $id;

	

	$reply = strip_tags(trim($_POST['reply']));

	

	

	$feedback_page_id = get_pageid($id);

	$feedback_page_name = get_PageName($feedback_page_id);

	if($page_name == '0')

	{

	   $page_name = 'General';

	}

	else

	{

	   $page_name = $page_name;

	}	

	

	list($arr_feedback_id,$arr_feedback,$arr_name,$arr_feedback_add_date,$arr_admin,$arr_page_id)=	getALLCommentsONfeedback($id);



	

	

	if($reply == '')

	{

		$error = true;

		$tr_err_reply = '';

		$err_reply = 'Please enter reply';

	}

	

	

	if(!$error)

		{

		

			$user_id = $_SESSION['user_id'];

			$name = $_SESSION['name'];

			$email = $_SESSION['email'];

			

		

			$feedback = Insert_admin_reply($id,$feedback_page_id,$user_id,$name,$email,$reply);

				

		}	

	

}

if(isset($_GET['uid']))

	{

		$id = $_GET['uid'];

		

		$feedback_page_id = get_pageid($id);

		$feedback_page_name = get_PageName($feedback_page_id);

		if($feedback_page_name == '0')

		{

		   $feedback_page_name = 'General';

		}

		else

		{

		   $feedback_page_name = $feedback_page_name;

		}	

		

		list($parent_feedback_id,$user_id,$name,$feedback,$admin,$status)=	getDetailsOfFeedback($id);

	}

else

{

	$reply = '';

}		

	

	

	

	

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

<header> 
<?php include 'topbar.php'; ?>
<?php include_once('header.php');?> 
</header>
<div class="container">  
    <div class="breadcrumb">
                    <div class="row">
                    <div class=" col-md-8">
                      <?php echo getBreadcrumbCode($page_id);?> 
                       </div>
                       <div class=" col-md-4">
                     
                       </div>
                       
                       </div>
                </div>
            </div>
<!--container-->
 <div class="container">
       <div class="row">
            <div class=" col-md-8">

						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

							<tr>

								<td align="left" valign="top">

									<span class="Header_brown"><?php echo getPageTitle($page_id);?></span><br />

									<?php echo getPageContents($page_id);?>

								</td>

							</tr>

                            <tr>
                            <td height="10px">&nbsp;</td>
                            </tr>

						</table>

              <form action="#" name="frmviewfeedback" id="frmviewfeedback" method="post"> 

                           <input type="hidden" name="hdn_id" id="hdn_id" value="<?php echo $id; ?>" />

                           <input type="hidden" name="hdn_p_id" id="hdn_p_id" value="<?php echo $p_id; ?>" />

               	   <table width="100%" border="0" align="left" cellpadding="3" cellspacing="3">

               	 	   <tr>

                       	  <td width="23%"  align="left" valign="top"><strong>Subject :</strong></td>

						  <td width="77%" align="left"><?php echo $feedback_page_name; ?></td>

                       </tr>

                       <tr>

					      <td  align="left" valign="top"><strong>Feedback :</strong></td>

                          <td  align="left" valign="top"><?php echo $feedback; ?></td>

                        </tr>

                          <td  align="left" valign="top"><strong>Reply :</strong></td>

                            <td><textarea type="text" name="reply" id="reply" class="form-control" rows="5" ><?php echo $reply; ?></textarea></td>

                            </tr>

                       <tr>
                                      <td  align="left" valign="top">&nbsp;</td>
                                      <td  align="left" valign="top">&nbsp;</td>
                     </tr>
                       <tr>

                         <td  align="left" valign="top">&nbsp;</td>

                          <td  align="left" valign="top"><input type="button" value="Submit" id="btnSubmit" onclick="SubmitReply()" class="btn btn-primary"  /></td>

                        </tr>

                         <tr>
                                      <td  align="left" valign="top">&nbsp;</td>
                                      <td  align="left" valign="top">&nbsp;</td>
                     </tr>                           

				  </table>

                </form>
</div>
     
               
                
                <!-- ad left_sidebar-->
                <div class=" col-md-2">
                 <?php include_once('left_sidebar.php'); ?>
              </div>
               <!-- ad left_sidebar end -->
                <!-- ad right_sidebar-->
               <div class=" col-md-2">
                <?php include_once('right_sidebar.php'); ?>
              </div>
               <!-- ad right_sidebar end -->
            </div>
            </div>
            <!--container end -->
    <!--footer -->         
              <footer>
    <div class="container">
                    <div class="row">
                    <div class="col-lg-12">	
     <?php include_once('footer.php');?>
    </div></div></div>
  </footer>    
      <!--footer end -->         
          
       
<!-- Bootstrap Core JavaScript -->
 <script src="csswell/js/jquery.min.js"></script>       
<script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 


</body>
</html>