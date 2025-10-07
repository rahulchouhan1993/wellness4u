<?php
include('config.php');
$page_id = '3';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

if(isLoggedIn())
{
	doUpdateOnline($_SESSION['user_id']);
}

$msg = '';
if(isset($_GET['msg']) && $_GET['msg'] != '')
{
	$msg = $_GET['msg'];
}

if($msg == '1')
{
	$sess = $_GET['sess'];
	$message = '<span style="color:#5338FF;">We have sent an email to your address '. base64_decode($sess).'.<br />
				In the email message from us, click the "Activate Now" link to confirm your Registration.</span><br><br>
				<span class="Header_brown">(Incase you donot find our above confirmation email in your inbox please check your junk/spam mail.)</span>';
}
elseif($msg == '2')
{
	$message = '<span class="Header_brown">Your profile is sucessfully updated!</span> <br /><br />';
}
elseif($msg == '3')
{
	$message = '<span class="Header_brown">Thanks for your enquiry! We will get back to you shortly.</span> <br /><br />';
}
elseif($msg == '10')
{
	$sess = $_GET['sess'];
	$message = '<span class="Header_brown">(Please check your junk mail.)</span> <br /><br />
				We have sent an email to your address '. base64_decode($sess).'.<br />
				In the email message from us, click the "Activate Now" link to reset password.';
}
elseif($msg == '11')
{
	$sess = $_GET['sess'];
	$message = '<span class="Header_brown">Your password successfully changed <a href="'.SITE_URL.'/login.php">Click Here To Login </a></span> <br /><br />';
}
elseif($msg == '12')
{
	$message = '<span class="Header_brown">Your referral request has been sent to user!</span> <br /><br />';
}
elseif($msg == '13')
{
	$message = '<span class="Header_brown">Your referral request has been sent to adviser!</span> <br /><br />';
}
elseif($msg == '14')
{
    $gotopage = $_GET['gotopage'];
    /*
    $message = '<span class="Header_brown">Your profile is successfully updated!</span> <br /> '
            . '<span class="Header_brown"><a href="'.SITE_URL.'/my_wellness_solutions.php">Click Here for Wellness Fun, Tips & Guide !</a></span>'
            . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="Header_brown" style="font-size:22px;font-weight:normal;">OR</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
            . 'Proceed to :&nbsp;&nbsp;<select name="gotopage" id="gotopage">'.getGoToPageDropdownOptions('2',$gotopage).'</select>&nbsp;&nbsp;<input type="button" name="btngoto" id="btngoto" value="Go" onclick="proceedToGoPage();"> <br />';
     * 
     */
    

    $message = '<span class="Header_green" style="font-size:17px;font-weight:normal;">Congrats !!! Your Inputs has - </span><br /><br /> 

- Increased<a href="'.SITE_URL.'/my_rewards.php"> Your REWARD Points </a></span> (View / Redeem) <br />
- Increased <a href="'.SITE_URL.'/digital_personal_wellness_diary.php">Your LIFE Patterns / Performance Metrics </a></span> (Analyse & /Or)<br /><br />

Would you like to<a href="'.SITE_URL.'/my_adviser_queries.php"> Post your Query /View Guidances at your ONLINE Consultation Forum </a></span> for better analysis of what you should improve, monitor or excel <br />
OR <br />
 
Update next relevant parameter :&nbsp;&nbsp;<select name="gotopage" id="gotopage">'.getGoToPageDropdownOptions('2',$gotopage).'</select>&nbsp;&nbsp;<input type="button" name="btngoto" id="btngoto" value="Go" onclick="proceedToGoPage();"> <br /><br />';           
/*

            . '<span class="Header_brown"><a href="'.SITE_URL.'/my_wellness_solutions.php"><img border="0" src="images/mws_msg_img.jpg" ></a></span><br /><br />';
* 
     */
          
}
elseif($msg == '15')
{
	$message = '<span class="Header_brown">Your details successfully saved!</span> <br /><br />';
}
elseif($msg == '16')
{
	$message = '<span class="Header_brown">Your alert successfully saved!</span> <br /><br />';
}
elseif($msg == '17')
{
 $message = '<span class="Header_brown">Your profile is sucessfully updated!</span> <br /><br /> '
            . 'Proceed to :&nbsp;&nbsp;<select name="gotopage" id="gotopage">'.getGoToPageDropdownOptions('2',$gotopage).'</select>&nbsp;&nbsp;<input type="button" name="btngoto" id="btngoto" value="Go" onclick="proceedToGoPage();"> <br /><br />'
            . '<span class="Header_brown" style="font-size:22px;font-weight:normal;">OR</span><br /><br />'
            . '<span class="Header_brown"><a href="'.SITE_URL.'/my_wellness_solutions.php">Click Here for Wellness Fun, Tips & Guide !</a></span><br /><br />'
            . '<span class="Header_brown"><a href="'.SITE_URL.'/my_wellness_solutions.php"><img border="0" src="images/mws_msg_img.jpg" ></a></span><br /><br />';
}
else
{
	$message = 'Invalid Access!';
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
    	<!--<link href="csswell/bootstrap/css/bootstrap.css" rel="stylesheet">-->
  <link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">       <link href="csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />
	  <!--[if lt IE 9]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
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
<header> <?php include_once('header.php');?>
 
</header>
<!--header End -->    

<!--container-->
              <div class="container">
              <div class="row">
              <div class=" col-md-12">
            
                      <?php echo $message;?>

          </div>
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