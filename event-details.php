<?php 

include('classes/config.php');

$page_id = '209';

$obj = new frontclass();

$obj2 = new frontclass2();



$page_data = $obj->getPageDetails($page_id);

$ref_url = $_SERVER['PHP_SELF'].'?token='.$_GET['token'];

//echo $_SERVER['PHP_SELF'];

$error = false;

$err_msg = '';



$event_id = base64_decode($_GET['token']);



if($event_id =='')

{

    header("Location: event-listing.php");

}

else

{

    $event_details = $obj->GetEventDetailsbyID($event_id);

     // echo "<pre>";print_r($event_details);echo "<pre>";
     // exit;

    //update by ample 24-09-20
    $oregnaise_certificate = $obj->GetCertificateDetailsbyID($event_id,'Organiser');
    $judge_certificate = $obj->GetCertificateDetailsbyID($event_id,'Judge');
    $participant_criteria = $obj->GetParticipantCriteria($event_id); //add by ample 24-0-920

    // echo "<pre>";print_r($participant_criteria);echo "<pre>";
    //     exit;

    $date1=date_create($event_details['start_date']);

    $date2=date_create($event_details['end_date']);

    $diff=date_diff($date1,$date2);

    $date_loop = $diff->format("%a");

  

}



if(isset($_POST['login_btn']))



{



//        echo '<pre>';

//        print_r($_POST);

//        echo '</pre>';

//        die();

	$username = trim($_POST['username']);



	$password = trim($_POST['password']);



        $gestid = $_POST['gestid'];



        

	if( ($username == '') || ($password == '') ) 



	{



		$error = true;



		$tr_err_msg = '';



		$err_msg = "Please Enter Username/Password";



	}



	elseif(!$obj->chkValidLogin($username,$password))



	{



		$error = true;



		$tr_err_msg = '';



		$err_msg = "Please Enter Valid Username/Password";



	}







	if(!$error)

	{

		if($obj->doLogin($username))

		{

                    

                        if($gestid != '')

                        {

                            $addUsersSleepQuestion = $obj->addUsersSleepQuestionByGestVivek($_SESSION['user_id'],$_SESSION['sleep_date'],$_SESSION['selected_sleep_id_arr'],$_SESSION['scale_arr'],$_SESSION['remarks_arr'],$_SESSION['my_target_arr'],$_SESSION['adviser_target_arr'],$_SESSION['pro_user_id']);

                       

                            unset($_SESSION['sleep_date']);

                            unset($_SESSION['selected_sleep_id_arr']);

                            unset($_SESSION['scale_arr']);

                            unset($_SESSION['remarks_arr']);

                            unset($_SESSION['my_target_arr']);

                            unset($_SESSION['adviser_target_arr']);

                            unset($_SESSION['pro_user_id']);

                            unset($_SESSION['gestid']);

                            

                           

                        }

                        

			if($ref == '')



			{

                               //$ref_url = $_SERVER['PHP_SELF'];

                                header("Location:".$ref_url);

				//header("Location: user_dashboard.php");

                             //echo "<script>window.location.href='user_dashboard.php'</script>";



			}



			else



			{

                                //$ref_url = $_SERVER['PHP_SELF'];

				header('location: '.$ref_url);

                                //$redirect = SITE_URL."/".$ref_url;

                               // echo "<script>window.location.href='".$redirect."'</script>";



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


$button_data=$obj->get_common_button_setting_data('Page',209);


?>

<!DOCTYPE html>

<html lang="en">

<head>    

    <?php include_once('head.php');?>

    <link rel="stylesheet" href="w_js/datepicker/css/bootstrap-datepicker.css">

    <script type="text/javascript" src="w_js/jquery-1.12.4.min.js" charset="UTF-8"></script>

    <script type="text/javascript" src="w_js/datepicker/js/bootstrap-datepicker.js" charset="UTF-8"></script>

    <link rel="stylesheet" href="event_details.css">

    <style>

        #explore .date button:hover, #explore .date .active {

        background: #e1452b;

        color: #fff;

        margin-top: 20px;

    }

      button {

    border: 0px;

    /* width: 120px; */

    min-width: 150px;

    height: 40px;

    background: #fff;

    border-radius: 20px;

    color: #4e4e4e;

    font-weight: 400px;

    /* margin-right: 20px; */

    padding: 0 15px;

    -webkit-box-shadow: 0px 2px 9px rgba(15, 15, 15, 0.8);

    -moz-box-shadow: 0px 2px 9px rgba(15, 15, 15, 0.8);

    -sm-box-shadow: 0px 2px 9px rgba(15, 15, 15, 0.8);

    -o-box-shadow: 0px 2px 9px rgba(15, 15, 15, 0.8);

    box-shadow: 0px 2px 9px rgba(15, 15, 15, 0.8);

    -webkit-transition: all linear 0.3s;

    -o-transition: all linear 0.3s;

    -moz-transition: all linear 0.3s;

    transition: all linear 0.3s;

}

button, input, select, textarea {

    font-family: inherit;

    font-size: inherit;

    line-height: inherit;

}

 

.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {

            color: #555;

            cursor: default;

            background-color: #9EFF98;

            border: 1px solid #ddd;

            border-bottom-color: transparent;

        }

        

.btn-light-green {

    text-decoration: none;

    border: 0!important;

    display: block;

    background-color: #DFF0D8;

    -webkit-transition: all .2s cubic-bezier(.15,.69,.83,.67);

    transition: all .2s cubic-bezier(.15,.69,.83,.67);

    width: 200px;

    text-align: center;

    font-family: ProximaNova-Bold,Helvetica,Arial,sans-serif;

    font-size: 14px;

    font-weight: 700;

    color: #3D763E !important;

    padding: 5px;

    margin: 0px 5px 0px 0px;

    float: left;

}

    .icons i
      {
          padding: 2px;
          font-size: 11px;
      }
      .icons .btn
      {
        font-size: 11px;
        padding: 2px 5px;
        margin-bottom: 2.5px;
        min-width: 35px;
        height: 35px;
        box-shadow: unset;
        border-radius: 5px;
      }

</style>

</head>

<body>

<?php include_once('analyticstracking.php'); ?>



<?php include_once('analyticstracking_ci.php'); ?>



<?php include_once('analyticstracking_y.php'); ?>

<?php include_once('header.php');?>



<section id="checkout">

	<div class="container">

                <div class="breadcrumb">



               



                    <div class="row">



                    <div class="col-md-8">	



                      <?php echo $obj->getBreadcrumbCode($page_id);?> 



                       </div>



                         <div class="col-md-4">



                         <?php



                                    if($obj->isLoggedIn())



                                    { 

                                        echo $obj->getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);

                                    }



                                    ?>



                         </div>



                       </div>



                </div>

		<div class="row">

                    

                <div class="col-md-8" id="explore" style="background-repeat:repeat; padding:5px;">

                    <div class="col-md-12">

                    <?php echo $obj->getPageContents($page_id);?>

                    </div>

                    <form role="form" class="form-horizontal" id="event_details" name="event_details" enctype="multipart/form-data" method="post"> 

                        <input type="hidden" name="event_id" id="event_id" value="<?php echo base64_decode($_GET['token']); ?>" />

                        <?php if($error){ ?>

                            <span style="color:red;"><?php echo $err_msg; ?></span>

                        <?php } ?>

                         

                            <div class="container event_detail_main">

        <div class="col-sm-8 col-xs-12 header_img">



            <img src="wa/uploads/<?php echo $event_details['event_image']; ?>" style="min-height:370px;" title="" alt="">

        

        <div id="event_div" class="" style="z-index: 99;">

            <div class="row training">

                <div class="img_below_cont ">

                    <h1><?php echo $event_details['event_name']; ?></h1>

                    

                    

                            <div class="sub_links"><span class="icon-calender"></span>                       

                                            <?php echo date("l, dS M Y",strtotime($event_details['start_date'])).','.$event_details['start_time'].' to '.date("l, dS M Y",strtotime($event_details['end_date'])).','.$event_details['end_time']; ?>

                             </div>

                            

                            <div class="sub_links"> 

                                <a href="wa/uploads/<?php echo $event_details['venue_image']; ?>" style="text-decoration: none; color: #fff;" target="_blank"><span class="icon-google_map_icon"></span><span><?php echo $event_details['venue_details']; ?></a></span>

                            </div>

                                        

                </div>

                <div class="Rlist">

                    <ul>

                                                <li class="training"><a class="customAnchor" onclick="setReminder('http://www.google.com/calendar/event?action=TEMPLATE&amp;text=IMPA+National+Conference+2018&amp;dates=20181207T090000/20181207T180000&amp;location=Hotel Sea Princess,Juhu, Airport Area, Mumbai, Maharashtra, India&amp;details=Learn+from+the+industry+stalwarts%26nbsp%3B-+Judith+Rasband%2C+Rakesh+Agarwal+and+Suman+Agarwal+about+the+future+of+Image+Management+Industry.%0A%26nbsp%3B%0AAn+exchange+of+ideas+from+other+eminent+personalities+from+related+field+will+give+useful+insights+into+the%26nbsp%3Bscope+and+future+of+the+industry%26nbsp%3Bin+India.%0A%26nbsp%3B%0A%26nbsp%3B&amp;trp=false&amp;sprop=&amp;sprop=name:')" target="_blank" rel="nofollow"><span class="icon-alaram_icon"></span>Set Reminder</a></li>

<!--                                                    <li class="training">

                                <a class="customAnchor" onclick="getDirection('Hotel+Sea+Princess%2CJuhu%2C+Airport+Area%2C+Mumbai%2C+Maharashtra%2C+India');" target="_blank">

									<span class="icon-google_map_icon"></span>

									Get Directions

								</a>

							</li>-->

                                            </ul>

                </div>

            </div>



        </div>

         <?php 

      //  echo $obj->getCommaSeperatedfavcat($event_details['fav_cat_id_2']);

         ?>



        <div class="col-md-12 bd-example" style="margin-top: 25px;">   

            <h2><span style="background-color: #FFCCCC; min-height: 30px; padding: 5px;">About The Event</span></h2>

            <br>

            <p><strong>Event Format: </strong><?php echo $obj->getCommaSeperatedfavcat($event_details['event_format']); ?> 

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Event Stage: </strong><?php echo $obj->getCommaSeperatedfavcat($event_details['fav_cat_id_2']); ?> </p>


            <p><strong>No of Groups:</strong> <?php echo $event_details['no_of_groups']; ?>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <?php if($event_details['event_format'] != 504) { ?><strong>No of Teams:</strong> <?php echo $event_details['no_of_teams']; } ?>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>No of Participant per team:</strong> <?php echo $event_details['no_of_participants']; ?></p>

            <p><strong>Sponsor: </strong><?php echo $event_details['sponsor_id']; ?>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Institution: </strong><?php echo $event_details['institution_id']; ?> </p>

            <?php echo $event_details['event_contents']; ?>

            <p>

                <a href="wa/uploads/<?php echo $event_details['rules_regulation_pdf']; ?>" class="active" target="_blank"><span style="background: #007fff;color: #fff; border: 2px solid #4e4e4e; border-radius: 15px; height: 50px; padding: 5px;">View Rules and Regulation</span></a>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <a href="wa/uploads/<?php echo $event_details['institution_profile_pdf']; ?>"  class="active" target="_blank"><span style="background: #007fff;color: #fff; border: 2px solid #4e4e4e; border-radius: 15px; height: 50px; padding: 5px;">View Institution Profile</span></a>

            </p>

            

            <br>

            <h2><span style="background-color: #FFCCCC; min-height: 30px; padding: 5px;">Participant Criteria:</span></h2>

            <br>

           <?php 

            if(!empty($participant_criteria))
            {
                foreach ($participant_criteria as $key => $value) {
                    ?>
                    <p><strong>Profile :</strong> <?php echo $obj->getFavCategoryNameVivek($value['profile']); ?> (<?php echo $value['gender']; ?>)</p>
                    <?php

                     $participants_from_age_group = ( ($value['from_age_group'] & $value['to_age_group'])!= '' ? '<p><strong>Age group: </strong>'.$value['from_age_group'].' Years TO '.$value['to_age_group'].' Years</p>' : '');

                    $participants_from_height = ( ($value['from_height'] & $value['to_height'])!= '' ? '<img src="images/MeasurementScale.jpg" style="height:60px;" / >'.$obj->GetParticipantsHeight($value['to_height']).' TO '.$obj->GetParticipantsHeight($value['to_height']).'' : '');

                    $participants_from_weight = ( ($value['from_weight'] & $value['to_weight'])!= '' ? '<img src="images/WeightScale.jpg" style="height:60px;" / >'.$value['from_weight'].'kgs TO '.$value['to_weight'].'kgs' : '');

                    echo $participants_from_age_group; 

                    echo '<p>'.$participants_from_height.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$participants_from_weight.'</p>'; 

                    ?>
                    <p><?php echo $value['special_remark']; ?></p>
                    <?php
                }
            }

            ?>
 

            <br>

            <h2><span style="background-color: #FFCCCC; min-height: 30px; padding: 5px;">About Judges:</span></h2>

            <br>

            <p><strong>Gender:</strong> <?php echo $event_details['judge_gender']; ?></p>

            <p><?php echo $event_details['judge_special_remark']; ?></p>

            <h2><span style="background-color: #FFCCCC; min-height: 30px; padding: 5px;">Judges License /Certificate Details:</span></h2>

            <br>

            <?php

                for($i=0;$i<count($judge_certificate);$i++)

                {

                  ?>

                    <p><?php echo $judge_certificate[$i]['certificate_name'].'( Issued by '.$judge_certificate[$i]['certificate_issue_by'].')'; ?>

                    <?php echo 'No: '.$judge_certificate[$i]['certificate_number'].' dated '.$judge_certificate[$i]['certificate_issue_date'].' Valid Upto: '.$judge_certificate[$i]['certificate_validity_date']; ?></p>

                  <?php  

                }

            ?>

<!--            <p><strong>Profile:</strong> <?php //echo $event_details['judge_special_remark']; ?></p>-->

            <h2><span style="background-color: #FFCCCC; min-height: 30px; padding: 5px;">Organiser Details:</span></h2>

            <br>

            <p><i class="fa fa-male"></i>&nbsp;&nbsp;<?php echo $event_details['organiser_contact_person'].' ( '.$event_details['organiser_designation'].' )'; ?></p>          

            <p><i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo $event_details['organiser_contact_number'].', <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-envelope"></i></strong> '.$event_details['organiser_email']; ?></p>

           

            <p><?php echo $event_details['organiser_remarks']; ?></p>

            <p>

                <?php if($event_details['organiser_facebook_page']!='') { ?>

                <a href="<?php echo $event_details['organiser_facebook_page']; ?>" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a>

                &nbsp;&nbsp;

                <?php } ?>

                <?php if($event_details['organiser_twitter_page']!='') { ?>

                <a href="<?php echo $event_details['organiser_twitter_page']; ?>" target="_blank" title="twitter"><i class="fa fa-twitter"></i>

                &nbsp;&nbsp;

                <?php } ?>

                <?php if($event_details['organiser_instagram_page']!='') { ?>

                <a href="<?php echo $event_details['organiser_instagram_page']; ?>" target="_blank" title="instagram"><i class="fa fa-instagram"></i>

                &nbsp;&nbsp;

                 <?php } ?>

                <?php if($event_details['organiser_youtube_channel']!='') { ?>

                <a href="<?php echo $event_details['organiser_youtube_channel']; ?>" target="_blank" title="youtube"><i class="fa fa-youtube"></i>

                 <?php } ?>

            </p>

            <h2><span style="background-color: #FFCCCC; min-height: 30px; padding: 5px;">Organiser License /Certificate Details:</span></h2>

            <br>

            <?php

                for($i=0;$i<count($oregnaise_certificate);$i++)

                {

                  ?>

                    <p><?php echo $oregnaise_certificate[$i]['certificate_name'].'( Issued by '.$oregnaise_certificate[$i]['certificate_issue_by'].')'; ?>

                    <?php echo 'No: '.$oregnaise_certificate[$i]['certificate_number'].' dated '.$oregnaise_certificate[$i]['certificate_issue_date'].' Valid Upto: '.$oregnaise_certificate[$i]['certificate_validity_date']; ?></p>

                   

                  <?php  

                }

            

            ?>

            

        </div>

            

            

         <?php 

         

         $ticket_data = $obj->GetEventTicketDetails($event_id);

         $registration_type = $obj->GetEventRegistrationType($event_id);

         $ticket_type = $obj->GetEventTicketType($event_id);

         

        // echo '<pre>';

        // print_r($event_details);

        // echo '</pre>';

         

         ?>

        <div class="col-md-8">

<!--            <button type="submit" name="btn_submit" class="active">Register</button>

            <button type="submit" name="btn_submit" class="active">Book Ticket</button>-->

            <button class="btn_disabled_no_click dlvry_mg dlvry_clr" onclick="openNextDelaveryDate('<?php echo $event_details['event_name']; ?>',<?php echo $event_id; ?>,'Registraion');return false;" tabindex="0">Participate<br><span style="color:red;">(For Participants)</span></button>

            <button class="btn_disabled_no_click dlvry_mg dlvry_clr" onclick="openNextDelaveryDate('<?php echo $event_details['event_name']; ?>',<?php echo $event_id; ?>,'book_type');return false;" tabindex="0">Book Ticket<br><span style="color:red;">(For Viewer/Spectators)</span></button>



            <!-- <button type="button" id="cart-box-toggle" class="btn btn-default">click</button> -->

        </div>  

<script>

    function getDirection(address){

        if(recommendationsEnable){

            _paq.push(['trackEvent', ,'EventPage', 'Get Directions']);

        }

        window.open('https://maps.google.com/maps?saddr=&daddr='+address);    

    }

    function setReminder(location){

        if(recommendationsEnable){

            _paq.push(['trackEvent', ,'EventPage', 'Set Reminder']);

        }

        window.open(location);

    }

</script>

<style>

    .customAnchor:hover{

        cursor: pointer;

    }

    

</style>

</div>

                                     

                                    

</div>

                           

</form>

                    

 </div>

                    <div class="col-md-4" style="padding: 35px;"> 

                   

                    <h2>Event Code: <?php echo $event_details['reference_number']; ?></h2>

                    <br>

                    <h2>Share</h2>

                    <br>

                    <!-- <script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5927dde055350600125cfd8d&product=inline-share-buttons"></script> -->
                     <!-- <div class="sharethis-inline-share-buttons"> </div> -->

                     <?php 

                     if(!empty($button_data))
                       {
                         ?>
                          <div class="icons">
                            <?php 
                              foreach ($button_data as $b_key => $b_value) 
                              {
                                
                                  if(!empty($b_value['link']))
                                  {
                                      ?>
                                       <a href="<?=$b_value['link'];?>" target="_blank"><button class="btn" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button></a>
                                      <?php
                                  }
                                  else
                                  {
                                    ?>
                                     <a href="javascript:void(0);"><button class="btn" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button></a>
                                    <?php
                                  }
                              }
                            ?>
                      </div>
                  <?php
                 }

                     ?>

                    </div>

					

	</div>

           

</div>

    

</section>

<?php include_once('footer.php');?>

    

    <script>

     $(document).ready(function()

            {

                $('#from_day_month_year').attr('autocomplete', 'off');

                $('#from_day_month_year').datepicker(

                        {

                            dateFormat: 'dd-mm-yy',

                            minDate: new Date(<?php echo date("Y-m-d",strtotime($event_details['start_date'])); ?>),

                            maxDate: new Date(<?php echo date("Y-m-d",strtotime($event_details['end_date'])); ?>)

                        }        

                ); 

        

                $("ul.nav-tabs a").click(function (e) {

               e.preventDefault();  

                 $(this).tab('show');

             });

                //$( "#datepicker" ).datepicker( { minDate: -0, maxDate: new Date(2013, 1,18) });

            }

        ); 

      

     

    function isNumberKey(evt){  <!--Function to accept only numeric values-->

    //var e = evt || window.event;

	var charCode = (evt.which) ? evt.which : evt.keyCode

    if (charCode != 46 && charCode > 31 

	&& (charCode < 48 || charCode > 57))

        return false;

        return true;

	}

   

   function GetRegistrationFees(event_id)

   {

      

       var registration_type = $("#registraion_type").val();

       

        //alert(event_id);

        //alert(registration_type);

       

       var dataString ='event_id='+event_id+'&registration_type='+registration_type+'&action=geteventregistrationfees';

        $.ajax({

            type: "POST",

            url: 'remote2.php', 

            data: dataString,

            cache: false,

            success: function(result)

                 {

                  

                 if(result == '')

                 {

                    $('#registraion_fees_value').val("");

                    $('#registraion_fees').html("Rs. 0.00");

                    $('#doregistershow').hide(); 

                 }

                 else

                 {

                    $('#registraion_fees_value').val(result);

                    $('#registraion_fees').html("Rs. "+result);  

                     $('#doregistershow').show(); 

                 }

                 

                }

           });   

   }

  

  function Display_Registration_form_show()

  {

      $('#Registration_form_show').show();  

  }

  

  function GetTicketFees(event_id)

  {  

        var ticket_type = $("#ticket_type").val();

        var dataString ='event_id='+event_id+'&ticket_type='+ticket_type+'&action=geteventticketfees';

        $.ajax({

            type: "POST",

            url: 'remote2.php', 

            data: dataString,

            cache: false,

            success: function(result)

                 {

                  //alert(result);

                 if(result == '')

                 {

                    $('#ticket_fees_value').val("");

                    $('#ticket_fees').html("Rs. 0.00");

                    $('#doregistershowticket').hide(); 

                 }

                 else

                 {

                    $('#ticket_fees_value').val(result);

                    $('#ticket_fees').html("Rs. "+result);  

                     $('#doregistershowticket').show(); 

                 }

                 

                }

           });  

        

  }

  

  function ShowQuantity(event_id)

  {

        var ticket_type = $("#ticket_type").val();

       

        var dataString ='event_id='+event_id+'&ticket_type='+ticket_type+'&action=geteventticketqty';

        $.ajax({

            type: "POST",

            url: 'remote2.php', 

            data: dataString,

            cache: false,

            success: function(result)

                 {

                    // alert(result);

                 if(result == '')

                 {

                   $('#ticket_quantity').val('');

                 }

                 else

                 {

                    $('#ticket_quantity').val(result);

                 }

                 

                }

           });  

  }

  

</script>

</body>

</html>