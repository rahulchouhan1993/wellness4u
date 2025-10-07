<?php
include('config.php');
$page_id = '129';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

if(isLoggedInVender())
{
    doUpdateOnlineVender($_SESSION['vender_user_id']);
    header("Location: ".SITE_URL."/venders/index.php");
    exit(0);
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
	elseif(!chkValidLoginVender($username,$password))
	{
		$error = true;
		$tr_err_msg = '';
		$err_msg = "Please Enter Valid Username/Password";
	}

	if(!$error)
	{
		if(doLoginVender($username))
		{
			if($ref == '')
			{
				header("Location: ".SITE_URL."/venders/index.php");
			}
			else
			{
				header('location: '.SITE_URL.'/'.$ref_url);
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
      <link rel="stylesheet" href="style.css" type="text/css" />
	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="js/commonfn.js"></script>
</head>
<body class="login">
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
<div class="columnsContainer">
            <div class="rightColumn">
            <div class="loginboxinner radius" style="width:90%;">
    	<div class="loginheader">
             <div class="logo" style="margin-bottom:25px;">
               <div align="center"><a href="<?php echo SITE_URL;?>" target="_self"><img src="uploads/WellnessWay4ULogo-transparent.png" /></a></div>
             </div>
          </div>
           <div class="loginform">
            <form action="<?php echo SITE_URL.'/vender_login.php';?>" id="frmlogin" name="frmlogin" method="post">
						<input type="hidden" name="ref" id="ref" value="<?php echo $ref;?>" /> 
						<input type="hidden" name="ref_url" id="ref_url" value="<?php echo $ref_url;?>" />
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							
							<tr>
								<td height="20" align="center" valign="middle" class="mainnav">&nbsp;</td>
								<td align="center" valign="middle" class="mainnav">&nbsp;</td>
							</tr>
						</table>
						<div align="center">
						  <table width="80%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
						      <td height="35" align="left" valign="bottom">&nbsp;</td>
						      <td height="35" align="left" valign="bottom">&nbsp;</td>
					        </tr>
						    <tr>
						      <td height="25" colspan="2" align="center" valign="bottom" class="Header_brown"><?php echo getPageTitle($page_id);?></td>
						      </tr>
						    <tr id="tr_err_msg" style="display:<?php echo $tr_err_msg;?>;">
						      <td height="25" colspan="2" align="left" valign="bottom" class="err_msg"><?php echo $err_msg;?></td>
						      </tr>
						    <tr>
						      <td height="35" align="left" valign="bottom">&nbsp;</td>
						      <td height="35" align="left" valign="bottom">&nbsp;</td>
					        </tr>
						    <tr>
						      <td width="120" height="50" align="left" >Vender Login ID:</td>
						      <td width="130" height="50" align="left" >
						        <input name="username" type="text" class="form-control" id="username" value="<?php echo $username;?>" size="25"  />
						        </td>
						      </tr>
						    <tr>
						      <td height="50" align="left" >Password:</td>
						      <td height="50" align="left" >
						        <input name="password" type="password" class="form-control" id="password" size="25"  />
						        </td>
						      </tr>
						    <tr>
						      <td height="25" align="right" valign="bottom">&nbsp;</td>
						      <td height="25" align="left" valign="bottom" class="footer">&nbsp;</td>
					        </tr>
						    <tr>
						      
						      <td height="25" colspan="2" align="center" valign="bottom" ><input type="checkbox" name="remember_me" id="remember_me" />&nbsp;Remember me</td>
						      </tr>
						    <tr>
						      <td height="25" colspan="2" align="center" valign="bottom">&nbsp;</td>
					        </tr>
						    <tr>
						      
						      <td height="25" colspan="2" align="center" valign="bottom"><a href="forgot_password.php" target="_self" class="footer_link">Forgot Password</a></td>
						      </tr>
						    <tr>
						      <td height="10" colspan="2" align="center"  valign="middle">&nbsp;</td>
					        </tr>
						    <tr>
						      <td height="40" colspan="2" align="center"  valign="middle">
						        <input name="btnSubmit" type="submit" class="btn btn-primary" id="btnSubmit" value="Submit" />
						        <br>									<span class="Header_brown">New Vender</span><br />
						        <span 

class="mainnav"><a href="<?php echo SITE_URL.'/vender_register.php';?>" 

target="_self"><img src="images/register_now.jpg" width="99" height="24" border="0" 

/></a></span>
						        </td>
						      </tr>
						    <tr>
						      <td height="30" colspan="2" align="left" valign="middle" class="footer"><?php echo getPageContents($page_id);?></td>
						      </tr>
						    </table>
			  </div>
						</form>
          </div>
          </div>
            </div>
                    <div class="leftColumn">
                    <p><img src="uploads/LoginPage-Banner-Basketball-Transparent-Green-small.png" style="width: 100%;  height: auto;" ></img></p>	
	  	</div>
</div>					

<!-- Bootstrap Core JavaScript -->

 <!--default footer end here-->
       <!--scripts and plugins -->
        <!--must need plugin jquery-->
        <script src="csswell/js/jquery.min.js"></script>        
        <!--bootstrap js plugin-->
        <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
</body>
</html>