<?php

require_once('../config.php');

$page_id = '103';

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



if(!chkIfAdviserCanAddMoreBanner($pro_user_id))

{

	header('location: banners.php');

	exit(0);

}



if(get_magic_quotes_gpc())

{

	foreach($_POST as $k => $v)

	{

		$_POST[$k] = stripslashes($_POST[$k]);

	}

}



$error = false;

$err_msg = "";



if(isset($_POST['btnSubmit']))

{

	$image 		= strip_tags(trim($_POST['image']));

	

	if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != '')

	{

		$image = basename($_FILES['image']['name']);

		

		$type_of_uploaded_file =substr($image,strrpos($image, '.') + 1);

		$target_size = $_FILES['image']['size']/1024;

			

		$max_allowed_file_size = 1000; // size in KB

		$target_type = array("jpg","JPG","jpeg","JPEG","gif","GIF","png","PNG");

			

		if($target_size > $max_allowed_file_size )

		{

			$error = true;

			$err_msg .=  "\n Size of file should be less than $max_allowed_file_size kb";

		}

		

		$allowed_ext = false;

		for($i=0; $i<count($target_type); $i++)

		{

			if(strcasecmp($target_type[$i],$type_of_uploaded_file) == 0)

			{

				$allowed_ext = true;

			}

		  

		}

			

		if(!$allowed_ext)

		{

			$error = true;

			

			$err_msg .= "\n The uploaded file is not supported file type. ".

					   "<br>Only the following file types are supported: ".implode(',',$target_type);

		}

		

		if(!$error)

		{

			

			$target_path = SITE_PATH."/uploads/";

			$image = time().'_'.$image;

			$target_path = $target_path .$image;

		

			

			if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path))

				{		    

			

				} 

			else

				{

					$error = true;

					$err_msg .= '<br>File Not Uploaded. Please Try Again Later';

				}

		

		}

		

	}	

	else

	{

		$error = true; 

		$err_msg .= '<br>Please upload Image'; 

	}

	

	if(!$error)

	{

		if(addAdviserBanner($pro_user_id,$image))

		{

			$msg = "Record Added Successfully!";

			//header('location: banners.php?msg='.urlencode($msg));

			header('location: message.php?msg=5'); //13 is old message id

		}

		else

		{

			$error = true;

			$err_msg = "Currently there is some problem.Please try again later.";

		}

	}

}

else

{

	

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

	<script type="text/JavaScript" src="js/commonfn.js"></script>

	<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />

	<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>

    

    

    <style type="text/css">@import "css/jquery.datepick.css";</style> 

	<script type="text/javascript" src="../js/jquery.datepick.js"></script>

    

    <script type="text/javascript" src="../js/jscolor.js"></script>

    

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



<form action="#" name="frmedit_profile" id="frmedit_profile" method="post" enctype="multipart/form-data"> 

                                    	

										

                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">

                                        <tbody>

                                        	<tr>

												<td colspan="3" align="left" class="err_msg"><?php echo $err_msg;?></td>

											</tr>

                                           

                                 <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                <tr>

                                   <td width="10%"  valign="top"><strong>Upload Image</strong>

                                    <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                    <td width="85%">

                                    <div class="col-xs-4">

                                    	<input name="image" type="file" id="image"  class="form-control" placeholder=".col-xs-4" /></div>

                                        <br /> <br /><span class="footer">Please upload banner of resolution (960X150)</span>

                                        <br /><span class="footer">Allowed Image type (jpg/gif/png)</span>

                                     </td>

                                  </tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								

								

                                            

                                            <tr>

                                                <td>&nbsp;</td>

                                                <td>&nbsp;</td>

                                                <td align="left"><input type="Submit" name="btnSubmit" value="Submit" class="btn btn-primary" /></td>

                                            </tr>

                                            <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                        </tbody>

                                        </table>

									</form>	



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