<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('classes/config.php');

$obj = new frontclass();
$page_id = '42';
$page_title = 'Chaitanya Wellness Research Institute - Reset Password';
$meta_keywords = 'Chaitanya Wellness Research Institute';
$meta_description = 'Chaitanya Wellness Research Institute';
$meta_title = 'Chaitanya Wellness Research Institute - Reset Password';

if($obj->isLoggedIn()){	

	$obj->doUpdateOnline($_SESSION['user_id']);}
	$error = false;$err_msg = '';
	$tr_err_rpassword = 'none';
	$tr_err_password= 'none';
	$err_rpassword = '';
	$err_password = '';

	if(isset($_GET['sess']) && $_GET['sess'] != ''){	
		$sess = $_GET['sess'];	
		$email = base64_decode($sess);	

		if(!$obj->chkEmailExists($email))	{		
			$error = true;		
			$err_msg = 'Invalid Access!';		
			header('location:message.php');		
			exit(0);	
		}

	}

	if($_POST['btnSubmit']){	

		$password = $_POST['password'];	
		$rpassword = $_POST['rpassword'];		

		if($password == '')	{		

			$error = true;		
			$tr_err_password = '';		
			$err_password = 'Please enter your Password';	

		}	elseif(!$obj->chkValidPassword($password))	{		

			$error = true;		$tr_err_password = '';		
			$err_password = 'Please enter valid Password.<br>Atleast 1 Upper case alphabate[A-Z],<br> 1 Lower case alphabate[a-z] ,<br> 1 Numeric[0-9] ,<br>  1 special characters[!@#$%^&*()-_=+,<>./?]';	
		}	if($rpassword == '')	{		
			$error = true;		
			$tr_err_rpassword = '';		
			$err_rpassword = 'Please Conform your Password';	
		}	elseif($rpassword != $password)	{		
			$error = true;		
			$tr_err_rpassword = '';		
			$err_rpassword = 'Please enter same confirm password';	
		}	if(!$error)	{		
			$user_id = $obj->getUserIdReset($email);		
			$name = $obj->GetUserName($email);		 
			$obj->ResetPassword($password,$user_id);
		}

	}

?>
<!DOCTYPE html>
<html lang="en">

<head><?php include_once('head.php');?>
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
    $(document).ready(function() {
                $('#js-news').ticker({
                            controls: true, // Whether or not to show the jQuery News Ticker controls				 htmlFeed: true, 				titleText: '',   // To remove the title set this to an empty String				displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'				direction: 'ltr'       // Ticker direction - current options are 'ltr' or 'rtl'							});			$('#slider1').bxSlider();			$('#slider2').bxSlider();			$(".QTPopup").css('display','none')			$(".feedback").click(function(){				$(".QTPopup").animate({width: 'show'}, 'slow');			});				$(".closeBtn").click(function(){							$(".QTPopup").css('display', 'none');			});		});	
    </script>
    <link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
    <script type="text/javascript" src="js/ddsmoothmenu.js"></script>
    <script type="text/javascript">
    ddsmoothmenu.init({
                mainmenuid: "smoothmenu1", //menu DIV id		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"		classname: 'ddsmoothmenu', //class added to menu's outer DIV		//customtheme: ["#1c5a80", "#18374a"],		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]		})	
    </script>
</head>
<style>
    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .password-wrapper-reg {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-text-box {
        width: 100%;
        padding-right: 40px;
    }
    .toggle-password {
        position: absolute;
        right: 10px;
        cursor: pointer;
        font-size: 18px;
        color: #888;
    }
    .toggle-password-reg {
        position: absolute;
        right: 10px;
        cursor: pointer;
        font-size: 18px;
        color: #888;
    }
</style>
<body>
    <?php include_once('analyticstracking.php'); ?><?php include_once('analyticstracking_ci.php'); ?><?php include_once('analyticstracking_y.php'); ?><?php include_once('header.php');?>
    <div class="container">
        <div class="breadcrumb">
            <div class="row">
                <div class=" col-md-8"> <?php echo $obj->getBreadcrumbCode($page_id);?> </div>
                <div class=" col-md-4"> </div>
            </div>
        </div>
    </div>
    <!--container-->
    <div class="container">
        <div class="row">
            <div class=" col-md-8"> <br />
                <form action="#" id="frmlogin" name="frmlogin" method="post">
                    <table width="80%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="30%" height="50" align="left" valign="middle">New Password:</td>
                            <td width="70%" height="50" align="left" valign="middle">
                                <!-- <input name="password" type="password" class="form-control" id="password" size="30" /> -->
                                <div class="password-wrapper">
                                    <input type="password" name="password" id="password" placeholder="Password" class="input-text-box" autocomplete="off" required>
                                    <span toggle="#password" class="toggle-password" onclick="togglePassword()">👁️</span>
                                </div>
                            </td>
                        </tr>
                        <tr id="tr_err_password" style="display:<?php echo $tr_err_password;?>;">
                            <td align="right">&nbsp; </td>
                            <td align="left" class="err_msg" id="err_password"><?php echo $err_password;?></td>
                        </tr>
                        <tr>
                            <td height="50" align="left" valign="middle">Re enter Password:</td>
                            <td height="50" align="left" valign="middle">
                                <br>
                                <!-- <input name="rpassword" type="password" class="form-control" id="rpassword" size="30" /> -->
                                <div class="password-wrapper-reg">
                                    <input type="password" name="rpassword" id="rpassword" placeholder="Re Password" class="input-text-box" autocomplete="off" required>
                                    <span toggle="#rpassword" class="toggle-password-reg" onclick="togglePasswordReg()">👁️</span>
                                </div>
                            </td>
                        </tr>
                        <tr id="tr_err_rpassword" style="display:<?php echo $tr_err_rpassword;?>;">
                            <td align="right">&nbsp; </td>
                            <td align="left" class="err_msg" id="err_rpassword"><?php echo $err_rpassword;?></td>
                        </tr>
                        <tr>
                            <td height="50" align="left" valign="middle">&nbsp;</td>
                            <td height="50" align="left" valign="middle"><input type="submit" name="btnSubmit"
                                    id="btnSubmit" value="Reset" class="btn btn-primary" /></td>
                        </tr>
                        <tr>
                            <td height="35" align="left" valign="middle">&nbsp;</td>
                            <td height="35" align="left" valign="middle">&nbsp;</td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="col-md-2"> <?php include_once('left_sidebar.php'); ?> </div> <!-- ad left_sidebar end -->
            <!-- ad right_sidebar-->
            <div class="col-md-2"> <?php include_once('right_sidebar.php'); ?></div> <!-- ad right_sidebar end -->
        </div>
    </div>
    <!--container-->
    <!--  Footer--> <?php include_once('footer.php');?>
    <!--  Footer-->
    <!-- Bootstrap Core JavaScript -->
    <!--default footer end here-->
    <!--scripts and plugins -->
    <!--must need plugin jquery-->
    <script src="csswell/js/jquery.min.js"></script>
    <!--bootstrap js plugin-->
    <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
<script>
    function togglePassword() {
        const input = document.getElementById("password");
        const icon = document.querySelector(".toggle-password");
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "🙈"; // Eye-off icon
        } else {
            input.type = "password";
            icon.textContent = "👁️"; // Eye icon
        }
    }
</script>

<script>
    function togglePasswordReg() {
        const input = document.getElementById("rpassword");
        const icon = document.querySelector(".toggle-password-reg");
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "🙈"; // Eye-off icon
        } else {
            input.type = "password";
            icon.textContent = "👁️"; // Eye icon
        }
    }
</script>
</html>