<?php

include('config.php');

$page_id = '78';

list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

//print_r($_SESSION);die();

if(isLoggedInPro())

{

	doUpdateOnlinePro($_SESSION['pro_user_id']);

      echo "<script>window.location.href='practitioners/my_users_queries.php'</script>";	
 //     header("Location: practitioners_hub.php");

}



if(isset($_GET['ref']))

{

	$ref = $_GET['ref'];

}

elseif(isset($_POST['ref']))

{

	$ref = $_POST['ref'];

}

else

{

	$ref = '';

}



$ref_url = base64_decode($ref);

$tr_err_msg = 'none';

$error = false;

$err_msg = '';



if(isset($_POST['btnSubmit']))

{

	$username = trim($_POST['username']);

	$password = trim($_POST['password']);



	if( ($username == '') || ($password == '') ) 

	{

		$error = true;

		$tr_err_msg = '';

		$err_msg = "Please Enter Username/Password";

	}

 //	elseif(!chkValidLoginPro($username,$password))
       elseif(!chkValidLoginProVivek($username,$password))

	{

		$error = true;

		$tr_err_msg = '';

		$err_msg = "Please Enter Valid Username/Password";

	}



	if(!$error)

	{

//		if(doLoginPro($username))
             if(doLoginProVivek($username))

		{ 
                 
			if($ref == '')

			{
                        echo "<script>window.location.href='practitioners/my_users_queries.php';</script>";


			//	header("Location: ".SITE_URL."/practitioners/practitioners_hub.php");
                                //header("Location: practitioners/practitioners_hub.php");

			}

			else

			{

//				header('location: '.SITE_URL.'/'.$ref_url);
  $redirect = SITE_URL."/".$ref_url;
                                echo "<script>window.location.href='".$redirect."'</script>";

			}	

		}

		else

		{

			$error = true;

			$tr_err_msg = '';

			$err_msg = "The username or password you entered is invalid, please try again.";

		}

	}		

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

	<link href="cwri.css" rel="stylesheet" type="text/css" />

    <link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">  

	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>

	<script type="text/JavaScript" src="js/commonfn.js"></script>



<link rel="stylesheet" href="style.css" type="text/css" />

</head>



<body class="login">



	<div class="columnsContainer">

            <div class="rightColumn">

	  		<?php include_once('analyticstracking.php'); ?>

<?php include_once('analyticstracking_ci.php'); ?>

<?php include_once('analyticstracking_y.php'); ?>

    

<div id="ad" style="width:100%">



</div>

<div class="loginbox radius">

<h4 style="color:#AA1144; text-align:center">m-Health .. An Online Guidance Platform</h4>

	<div class="loginboxinner radius">

    	<div class="loginheader">

    		

            <div class="logo"><a href="<?php echo SITE_URL;?>" target="_self"><img src="uploads/WellnessWay4ULogo-transparent.png" /></a></div>

                

    	</div><!--loginheader-->



<div class="loginform">

              	<form action="<?php echo SITE_URL.'/prof_login.php';?>" id="frmlogin" name="frmlogin" method="post">

                <input type="hidden" name="ref" id="ref" value="<?php echo $ref;?>" /> 

		<input type="hidden" name="ref_url" id="ref_url" value="<?php echo $ref_url;?>" />

                <p style="padding-top: 40px;">

                <table>

                    <tr>

                    <td height="25" colspan="2" align="center" valign="bottom" class="Header_brown"><?php echo getPageTitle($page_id);?></td>

            </tr>

            <tr id="tr_err_msg" style="display:<?php echo $tr_err_msg;?>;">

                    <td height="25" colspan="2" align="left" valign="bottom" class="err_msg"><?php echo $err_msg;?></td>

            </tr>

                </table></p>

                

            	<p>

                	<label for="username" class="bebas">User Name</label>

                    <input type="text" name="username" id="username" value="<?php echo $username;?>" />

                </p>

                <p>

                    <label for="password" class="bebas">Password &nbsp;</label>

                    <input type="password" id="password" name="password"/>

                </p>

                <p align="center"><input type="checkbox" name="remember_me" id="remember_me" />&nbsp;Remember me<br>

                        <a href="forgot_password.php" target="_self" class="footer_link">Forgot Password</a><br>

                

                	<input name="btnSubmit" type="submit" class="btn btn-primary" id="btnSubmit" value="Submit" />

                </p>

                

                <p align="center">

                     <label for="password" class="bebas" style="color: #AA1144; font-size: 14px;">New User ?</label><br>

                    <a href="<?php echo SITE_URL.'/prof_register.php';?>" target="_self"><img src="images/register_now.jpg" width="99" height="24" border="0" /></a>


                </p>

                

                

            </form>

        </div><!--loginform-->

    </div><!--loginboxinner-->

</div><!--loginbox-->

<p align="center" style="font-size:12px;">

  <center>

   <?php echo getPageContents($page_id);?>

  </center>

</p>

	  	</div>



	  	<div class="leftColumn">

                    <p><img src="uploads/Basketball-W4u-HourGl-Final-L-Orange.jpg" style="width: 100%;  height: auto;" ></img></p>	

	  	</div>



  	</div>

   

  <script src="csswell/js/jquery.min.js"></script>        

        <!--bootstrap js plugin-->

        <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       

</body>

</html>