
<?php
ini_set("memory_limit","200M");
if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };
@set_time_limit(1000000);
include('classes/config.php');
$page_id = '38';
$obj = new frontclass();
$obj2 = new frontclass2();
$page_data = $obj->getPageDetails($page_id);
$ref = base64_encode('digital_personal_wellness_diary.php');
if(!$obj->isLoggedIn())
{
echo "<script>window.location.href='login.php?ref=$ref'</script>";
exit(0);
}
else
{
$user_id = $_SESSION['user_id'];
$obj->doUpdateOnline($_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once('head.php');?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $meta_description;?>" />
<meta name="keywords" content="<?php echo $meta_keywords;?>" />
<meta name="title" content="<?php echo $meta_title;?>" />
<title><?php echo $meta_title;?></title>
<link href="cwri.css" rel="stylesheet" type="text/css" />
<link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">       
<link href="csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/JavaScript" src="js/commonfn.js"></script>
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<link href="css/ticker-style.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.ticker.js" type="text/javascript"></script>  
<style type="text/css">@import "css/jquery.datepick.css";</style> 
<script type="text/javascript" src="js/jquery.datepick.js"></script>  

<link rel="stylesheet" href="css/ticket_style.css" type="text/css"> 

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

$(".QTPopup").css('display','none');
$(".feedback").click(function(){
        $(".QTPopup").animate({width: 'show'}, 'slow');
}); 

$(".closeBtn").click(function(){            
        $(".QTPopup").css('display', 'none');
});
}); 
</script>


<style>
.digitalshow
{
    text-align: center;
    font-style: 25px;
    color:red;
    padding:2%;
}
</style>
</head>
<body>

<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
<?php include_once('header.php');?>
<!--header End -->          
<!--breadcrumb--> 
<!-- <div class="container">  -->
<!-- <div class="breadcrumb"> -->


        <!-- <div class="row"> -->
        <!-- <div class="col-md-8">   -->
          <?php //echo $obj->getBreadcrumbCode($page_id);?> 
           <!-- </div> -->
             <!-- <div class="col-md-4"> -->

                    <?php
                        // if($obj->isLoggedIn())
                        // { 
                        //     echo $obj->getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);
                        // }
                        ?>
             <!-- </div> -->
           <!-- </div> -->
    <!-- </div> -->
<!-- </div> -->
            
<div class="container" >
<div class="row">   
<div class="col-md-12"> 
    <?php
       // $user=$obj->getMylifepetterns($_SESSION['user_id']);
       // $valu_b=json_decode(base64_decode($_GET['b']));
    ?>
      <div class="main1">
                        <table width="750" cellspacing="2" cellpadding="2" align="center" style="border: 1px solid #CCCCCC; ">
                            <tbody><tr>
                                <td>
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="padding:2%;">
                                        <tbody><tr>
                                            <td height="15" colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <!-- <td width="70%">
                                                <span class="bold-text">Mobeepay<br></span>
                                                42/A Lake city mall<br>
                                                Mumbai 400607<br>
                                                Phone 9819043060
                                            </td> -->
                                      <td valign="top" align="right"><img width="176" src="images/cwri_logo.png" class="logo_ticket"></td>
                                        </tr>

                                          <tr>
                                            <td height="15" colspan="2"><b class="confirmed">Your Booking is confirmed !</b></td>
                                        </tr>

                                        <tr>
                                            <td height="15" colspan="2"></td>
                                        </tr>
                                         <tr>
                                             <td height="15" colspan="2">
                                                <h5 class="headid">Booking ID <span class="idname">AGNHDE<span></h5> 
                                            </td>
                                        </tr>
                                          <tr>
                                            <td height="15" colspan="2"></td>
                                        </tr>
                                       <tr>
                                           <td>
                                              <div class="row bordershow">
                                                <div class="col-sm-3">
                                                      <!-- <div class="image_event"> -->
                                                        <img src="images/MeasurementScale.jpg" class="img_event">
                                                     <!-- </div> -->
                                                </div>
                                                <div class="col-sm-8">
                                                     <div class="contet">
                                                       <h5>Event Format <span >Individual</span></h5>
                                                       <h5>Event Stage <span>Finals ,First Round ,None ,Quarter Final</span></h5>
                                                       <h5>No of Groups <span>10</span></h4>
                                                       <h5>No of Participant per team <span>56</span></h5>
                                                     </div>
                                                </div>
                                            </div>
                                           </td>
                                       </tr>

                                        <tr>
                                            <td height="15" colspan="2"></td>
                                        </tr>

                                       <tr>
                                           <td>
                                              <div class="row participet">
                                                <div class="col-sm-3">
                                                     <div class="number_ticket">
                                                         <b class="qtymamber">2</b><br>
                                                        <b class="ttickes">Ticket</b>
                                                     </div>
                                                </div>
                                                <div class="col-sm-8">
                                                     <div class="value_ticke">
                                                       <h5>Gender <span>Male</span></h5>
                                                      <h5> Age group <span>56 Years TO 80 Years<span></h5>
                                                      <h5>Height <span>127Cms (4 feet , 2 inches ) TO 127Cms (4 feet , 2 inches )<span></h5>
                                                      <h5>weight <span>52kgs TO 53kgs<span></h5>
                                                  
                                                            <b></b>
                                                     </div>
                                                </div>
                                            </div>
                                           </td>
                                       </tr>

                                        <tr>
                                            <td height="15" colspan="2"></td>
                                        </tr>
                                      

                                        <tr>
                                           <td>
                                              <div class="row participet">
                                                <div class="col-sm-12">

                                                    <table style="width:100%;">
                                                        <tr>
                                                            <td>
                                                                <b class="ttickes">TICKET AMOUNT</b><br>
                                                                <b class="qty">Quantity</b>
                                                            </td>
                                                            <td>
                                                                  <h5 class="ticket_amout"><i class="fa fa-inr" aria-hidden="true"></i>300.00<br><b class="number_qty">2 Ticket</b></h5>   
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <b class="ttickes">INTERNET HANDLING FEES</b><br>
                                                                <b class="qty">Booking fees</b><br>
                                                                <b class="qty">Central GST(CGST) @ 9%</b><br>
                                                                <b class="qty">State GST(SGST) @ 9%</b><br>
                                                            </td>
                                                            <td>
                                                            <div class="amont_">
                                                                 <h5 class=""><i class="fa fa-inr" aria-hidden="true"></i>30.00<br></h5>
                                                                 <b class="bookfees"> <i class="fa fa-inr" aria-hidden="true"></i>45.00</b> <br>
                                                                 <b class="bookfees"> <i class="fa fa-inr" aria-hidden="true"></i>20.00</b> <br>
                                                                 <b class="bookfees"> <i class="fa fa-inr" aria-hidden="true"></i>20.00</b> <br> 
                                                             </div>
                                                            </td>
                                                        </tr>


                                                          <tr>
                                                            <td>
                                                                <b class="ttickes">AMOUNT PAID</b><br>
                                                            </td>
                                                            <td>
                                                                  <h5 class="ticket_amout"><i class="fa fa-inr" aria-hidden="true"></i>550.00</h5>   
                                                            </td>
                                                        </tr>

                                                    </table>
                                                </div>
                                            
                                            </div>
                                           </td>
                                       </tr>



<!-- 
                                        <tr>
                                            <td align="center" colspan="2">
                                                <span class="bold-text">Thank you for booking with Mobeepay. This is your E-Ticket.<br>
                                                We wish you a pleasant journey and hope to serve you again in the future.   </span><br>
                                            </td>
                                        </tr> -->





                                     <!--    <tr>
                                            <td height="15" colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <table width="100%" cellspacing="0" cellpadding="3" border="0">
                                                    <tbody><tr>
                                                        <td width="45%" height="25" bgcolor="#E4E4E4" class="border">Booked on </td>
                                                        <td width="4%" align="center" class="border">:</td>
                                                        <td width="54%" height="25" class="border2">13 May 2013 18:45</td>
                                                    </tr>
                                                    <tr>
                                                        <td height="25" bgcolor="#E4E4E4" class="border1">PNR</td>
                                                        <td align="center" class="border1">:</td>
                                                        <td height="25" class="border3">JSZZ3</td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr> -->
                                       <!--  <tr>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center" class="bold-text" colspan="2">Your E-Ticket as on 13 May 2013 18:45</td>
                                        </tr> -->
                                        <!-- <tr>
                                            <td colspan="2">To fly easy, please present the E-Ticket with a valid photo identification at the airport and check in counter. The check-in counters are open 2 hours prior to departure and close striclty 40 mins prior to departure.</td>
                                        </tr> -->
                                       <!--  <tr>
                                            <td height="15" colspan="2">&nbsp;</td>
                                        </tr> -->
                                   <!--      <tr>
                                            <td colspan="2">
                                                <table width="100%" cellspacing="0" cellpadding="4" border="0">
                                                    <tbody><tr>
                                                        <td bgcolor="#E4E4E4" align="center" class="border3" colspan="6"><strong>ITINERARY</strong></td>
                                                    </tr>
                                                    <tr class="bold-text">
                                                        <td bgcolor="#E4E4E4" align="center" class="border4">From/ To</td>
                                                        <td bgcolor="#E4E4E4" align="center" class="border4">Flight</td>
                                                        <td bgcolor="#E4E4E4" align="center" class="border4">Date</td>
                                                        <td bgcolor="#E4E4E4" align="center" class="border4">Dep.</td>
                                                        <td bgcolor="#E4E4E4" align="center" class="border4">Arr.</td>
                                                        <td bgcolor="#E4E4E4" align="center" class="border5">Stops</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border1">Goa / Mumbai</td>
                                                        <td class="border1">Air India AI-866</td>                                    <td class="border1">14 May 2013</td>
                                                        <td class="border1">0710</td>
                                                        <td class="border1">0805</td>
                                                        <td class="border3">0 Stops</td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr> -->
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>

                                   <!--      <tr>
                                            <td colspan="2">
                                                <table width="100%" cellspacing="0" cellpadding="4" border="0">
                                                    <tbody><tr class="bold-text">
                                                        <td bgcolor="#E4E4E4">
                                                        <b>Booking Date & Time</b><br>
                                                        <b>Mon,4 Mar 2019 | 12:44 PM</b>
                                                       </td>
                                                        <td bgcolor="#E4E4E4"">
                                                        <b>Payment Type</b><br>
                                                        <b>Credit/Dibet Cart</b>
                                                      </td>
                                                        <td bgcolor="#E4E4E4">
                                                         <b>Confirmation #</b><br>
                                                         <b>34445678</b>
                                                    </td>
                                                    </tr></tbody></table>
                                            </td>
                                        </tr> -->

                                        <tr>
                                            <td colspan="2" class="backgrodshow">
                                                <table width="100%" cellspacing="0" cellpadding="4" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="botton_show">
                                                                 <b>Booking Date & Time</b><br>
                                                                 <b class="numbe">Mon,4 Mar 2019 | 12:44 PM</b>
                                                               </div>
                                                            </td>
                                                            <td >
                                                                 <div class="botton_show">
                                                                   <b>Payment Type</b><br>
                                                                   <b class="numbe">Credit/Dibet Cart</b>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                 <div class="botton_show">
                                                                   <b>Confirmation #</b><br>
                                                                   <b class="numbe">34445678</b>
                                                                 </div>
                                                           </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                
                                        <tr>
                                            <td colspan="2">
                                                <ul>
                                                    <li><b>Check in begins 2 hours prior to the flight for seat assignment and closes before 45 mins.</b></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody>
                    </table>  
             </div>



<p>&nbsp;</p>


</div>
</div>
</div>           
<?php include_once('footer.php');?>
<!--  Footer-->
<div id="page_loading_bg" class="page_loading_bg" style="display:none;">
<div id="page_loading_img" class="page_loading_img"><img border="0" src="<?php echo SITE_URL;?>/images/loading.gif" /></div>
</div> 
</div>  
</div>

<script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       

</body>

</html>


