<?php
include('config.php');
$page_id = '78';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

if(isLoggedInPro())
{
	doUpdateOnlinePro($_SESSION['pro_user_id']);
	header("Location: practitioners_hub.php");
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
	elseif(!chkValidLoginPro($username,$password))
	{
		$error = true;
		$tr_err_msg = '';
		$err_msg = "Please Enter Valid Username/Password";
	}

	if(!$error)
	{
		if(doLoginPro($username))
		{
			if($ref == '')
			{
				header("Location: ".SITE_URL."/practitioners/practitioners_hub.php");
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
</head>
<body>
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" valign="top" background="images/top_back.jpg" style="background-repeat: repeat-x;">
			<table width="980" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="25"><img src="images/spacer.gif" width="1" height="1" /></td>
				</tr>
			</table>
			<table width="980" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
				<tr>
					<td width="720" height="420" align="center" valign="middle" background="<?php echo SITE_URL."/uploads/".$banner1; ?>" style="background-repeat:repeat-x;">&nbsp;</td>
					<td width="260" height="240" align="center" valign="top" background="images/top_back.jpg" bgcolor="#FFFFFF" style="padding-left:10px; background-repeat:repeat-x;">
						<form action="<?php echo SITE_URL.'/prof_login.php';?>" id="frmlogin" name="frmlogin" method="post">
						<input type="hidden" name="ref" id="ref" value="<?php echo $ref;?>" /> 
						<input type="hidden" name="ref_url" id="ref_url" value="<?php echo $ref_url;?>" />
						<table width="250" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="250" height="100" align="center" valign="middle" class="mainnav">
									<a href="<?php echo SITE_URL;?>" target="_self"><img src="images/new_user.png" width="100" height="104" border="0" /></a>
								</td>
								<td width="250" align="center" valign="middle">
									<span class="Header_brown">New Adviser</span><br />
									<span class="mainnav"><a href="<?php echo SITE_URL.'/prof_register.php';?>" target="_self"><img src="images/register_now.jpg" width="99" height="24" border="0" /></a></span>
								</td>
							</tr>
							<tr>
								<td height="20" align="center" valign="middle" class="mainnav">&nbsp;</td>
								<td align="center" valign="middle" class="mainnav">&nbsp;</td>
							</tr>
						</table>
						<table width="250" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="25" colspan="2" align="center" valign="bottom" class="Header_brown"><?php echo getPageTitle($page_id);?></td>
							</tr>
							<tr id="tr_err_msg" style="display:<?php echo $tr_err_msg;?>;">
								<td height="25" colspan="2" align="left" valign="bottom" class="err_msg"><?php echo $err_msg;?></td>
							</tr>
							<tr>
								<td width="120" height="35" align="left" valign="bottom">Adviser Login ID:</td>
								<td width="130" height="35" align="left" valign="bottom">
									<input name="username" type="text" class="input" id="username" value="<?php echo $username;?>" size="25" style="width:100px;" />
								</td>
							</tr>
							<tr>
								<td height="35" align="left" valign="bottom">Password:</td>
								<td height="35" align="left" valign="bottom">
									<input name="password" type="password" class="input" id="password" size="25" style="width:100px;" />
								</td>
							</tr>
							<tr>
								<td height="25" align="right" valign="bottom">&nbsp;</td>
								<td height="25" align="left" valign="bottom" class="footer"><input type="checkbox" name="remember_me" id="remember_me" />&nbsp;Remember me</td>
							</tr>
							<tr>
								<td height="25" align="left" valign="bottom">&nbsp;</td>
								<td height="25" align="left" valign="bottom"><a href="forgot_password.php" target="_self" class="footer_link">Forgot Password</a></td>
							</tr>
							<tr>
								<td height="40" align="left" valign="middle">&nbsp;</td>
								<td height="40" align="left" valign="middle">
									<input name="btnSubmit" type="submit" class="button" id="btnSubmit" value="Submit" />
								</td>
							</tr>
							<tr>
								<td height="30" colspan="2" align="left" valign="middle" class="footer"><?php echo getPageContents($page_id);?></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>