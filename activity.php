<?php
   include('classes/config.php');
   
   $obj = new frontclass();
   $obj2 = new frontclass2();
   
   $page_id = '12';
   
   list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = $obj->getPageDetails($page_id);
   
   
    
   $ref = base64_encode('activity.php');
   
   if(!$obj->isLoggedIn())
   
   {
   
   //	header("Location: login.php?ref=".$ref);
       echo "<script>window.location.href='login.php?ref=$ref'</script>";
   
   	exit(0);
   
   }
   
   else
   
   {
   
   	$user_id = $_SESSION['user_id'];
   
   	$obj->doUpdateOnline($_SESSION['user_id']);
   
   }

   //add by ample 11-06-20
   $title=$date="";
   $redirect=0;
   $style="";
   if(isset($_GET['title']) && !empty($_GET['title']))
   {
      $title=base64_decode($_GET['title']);
      $date=date('d-m-Y');
      $redirect=1;
      $style='readonly';
   }
   


   if(isset($_POST['btnSubmit']))   
   {  

     
      $date=date("Y-m-d", strtotime($_POST['day_month_year']));
      $data=array();
      $count_row=count($_POST['activity']);
      for ($i=0; $i < $count_row; $i++) { 
         $data[] = array( 
                        'user_id' =>$user_id,
                        'activity_date' => $date,
                        'activity_id' =>$_POST['activity_id'][$i] ,
                        'other_activity' =>$_POST['other_activity'][$i] ,
                        'activity_start_time' =>$_POST['start_time'][$i] ,
                        'activity_end_time' =>$_POST['end_time'][$i] ,
                        'activity_duration' =>$_POST['duration'][$i] ,
                        'user_response_id' =>$_POST['user_response'][$i] ,
                        'location_type_id' =>$_POST['location_type'][$i] ,
                        'location_id' =>$_POST['location_id'][$i] ,
                        'proper_guidance' =>$_POST['proper_guidance_'.$i] ,
                        'precaution' =>$_POST['precaution'][$i] ,
                        'yesterday_sleep_time' =>$_POST['yesterday_sleep_time'] ,
                        'today_wakeup_time' =>$_POST['today_wakeup_time'],
                        'sleep_duration' =>$_POST['sleep_duration'],
                        'parent_id' =>$_POST['parent_id'] ?? NULL,
                        'child_id' =>$_POST['child_id'] ?? NULL,
               ); 
      }

      // echo "<pre>";
      // print_r($data);
      // die('skf');

      $res=$obj->add_user_activity($data,$count_row,$date,$redirect);

      // echo $res; echo "-----"; die('fklgjkd');
      if($res)
      {  
         $_SESSION['msg'] = 'Activities Updated Successfully!';
         echo "<script>window.location.href='message.php?msg=24'</script>";
      }


   }
   
   
   
?><!DOCTYPE html>
<html lang="en">
   <head>
      <?php include_once('head.php');?>
   </head>
   <body>
      <?php include_once('analyticstracking.php'); ?>
      <?php include_once('analyticstracking_ci.php'); ?>
      <?php include_once('analyticstracking_y.php'); ?>
      <?php include_once('header.php');?>

      <style type="text/css">
         #activity_diary .label,#activity_diary .Header_brown
         { 
            text-align: left!important;
            color: #AA1144;
            font-size: 12px;
         }
      </style>
      <!--breadcrumb-->  
      <div class="container">
         <div class="breadcrumb">
            <div class="row">
               <div class=" col-md-8">
                  <?php echo $obj->getBreadcrumbCode($page_id);?>
               </div>
               <div class=" col-md-4">
                  <?php
                     if($obj->isLoggedIn())
                     
                     { 
                     
                         echo $obj->getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);
                     
                     }
                     
                     ?>
               </div>
            </div>
         </div>
      </div>
      <!--breadcrumb end --> 
      <!--container-->
      <div class="container">
         <div class="row">
            <!--left-->
            <div class=" col-md-8">

               <?php 

               if(!empty($_SESSION['msg'])) {
                     $message = $_SESSION['msg'];
                     echo '<div class="alert alert-success">'.$message.'</div>';
                     unset($_SESSION['msg']);
                  }

               ?>

               <table width="100%" align="" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
                  <tr>
                     <td align="" valign="top" bgcolor="#FFFFFF" style="background-repeat:repeat-x; padding:10px;">
                        <form action="#" id="frmactivity" method="post" name="frmactivity">
                           <input type="hidden" name="flagnewdate" id="flagnewdate" value="" />
                           <input type="hidden" name="totalRow" id="totalRow" value="0" />
                           <!-- <input type="hidden" name="cnt" id="cnt" value="<?php echo $cnt;?>" />-->
                            <!-- update by ample 28-09-20 -->
                            <input type="hidden" name="parent_id" id="parent_id" value="<?=$_GET['parent_id']?>" />
                            <input type="hidden" name="child_id" id="child_id" value="<?=$_GET['child_id']?>" />

                           <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td colspan="4" height="50" align="left" valign="top" class="header_title"><?php echo $obj->getPageContents($page_id);?></td>
                              </tr>
                              <tr>
                                 <td colspan="4" align="left" valign="top" class="err_msg"><?php echo $err_msg;?></td>
                              </tr>
                              <tr>
                                 <td width="20%" height="60" align="left" valign="middle"><?php echo $obj->getPageIcon($page_id);?></td>
                                 <td width="60%" height="60" align="left" valign="middle" class="Header_brown"><?=($page_title)? $page_title :  '<b>Daily Activity</b>' ;?></td>
                                 <td width="20%" height="60" align="left" valign="middle" class="Header_brown">&nbsp;</td>
                                 <td width="20%" height="60" align="left" valign="middle" class="Header_brown">&nbsp;</td>
                              </tr>
                           </table>
                           <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td height="50" width="20%" align="left" valign="middle"><strong class="Header_brown">Date:</strong></td>
                                 <td height="50" width="60%" align="left" valign="middle">
                                    <span class="Header_brown">
                                       <!-- <input type="text" required="" name="day_month_year" id="day_month_year" placeholder="  Select Date" class="form-control datepicker"> -->
                                       <div class="row">
                                          <!-- <div class="col-xs-4">
                                             <select class="form-control" name="day" id="day">
                                                <option value="<?php echo $yesterday_day;?>" <?php if($day == $yesterday_day) { ?> selected="selected" <?php } ?>><?php echo $yesterday_day;?></option>
                                                <option value="<?php echo $today_day;?>" <?php if($day == $today_day) { ?> selected="selected" <?php } ?>><?php echo $today_day;?></option>
                                             </select>
                                          </div>
                                          <div class="col-xs-4">                                                   <select class="form-control" name="month" id="month">
                                             <?php echo $obj->getMonthOptions($month,$yesterday_month,$today_month); ?>
                                             </select>
                                          </div>
                                          <div class="col-xs-4">
                                             <select class="form-control" name="year" id="year">
                                                <?php
                                                   for($i=$yesterday_year;$i<=$today_year;$i++)
                                                   
                                                   { ?>
                                                <option value="<?php echo $i;?>" <?php if($year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                                <?php
                                                   } ?>	
                                             </select>
                                          </div> -->
                                          
                                          <div class="col-xs-6">
                                           <input type="text" required="" name="day_month_year" id="day_month_year" placeholder="Select Date" class="form-control datepicker" onchange="already_set_activity()" value="<?=$date;?>" <?=$style;?> required> 
                                          </div>
                                       </div>
                                    </span>
                                 </td>
                                 <td height="50" width="20%" align="left" valign="middle">&nbsp;</td>
                              </tr>
                           </table>
                           <div class="row">
                              <div class="col-md-3">
                                 <strong class="Header_brown">Yesterday's Sleep time:</strong>
                                    <span class="border_bottom">
                                       <!-- <select class="form-control" name="yesterday_sleep_time" id="yesterday_sleep_time" required>
                                          <?php 

                                             //echo $obj->getTimeOptionsNew('18','5',$yesterday_sleep_time); 
                                             echo $obj->get_times('00:00','23:45');
                                             ?>
                                       </select> -->
                                       <!-- change as per email 29-04-20 -->
                                       <input type="time" class="form-control" name="yesterday_sleep_time" id="yesterday_sleep_time" required />
                                    </span>
                              </div>
                              <div class="col-md-3">
                                  <strong class="Header_brown">Today's Wake-up time:</strong>
                                    <span class="border_bottom">
                                       <!-- <select class="form-control" name="today_wakeup_time" id="today_wakeup_time" onchange="get_activity_form()" required>
                                          <?php 
                                              //echo $obj->getTimeOptionsNew('2','1',$today_wakeup_time); 
                                             echo $obj->get_times('00:00','23.45');
                                          ?>
                                       </select> -->
                                       <!-- change as per email 29-04-20 -->
                                       <input type="time" class="form-control" name="today_wakeup_time" id="today_wakeup_time" onchange="get_activity_form()" required />
                                    </span>
                              </div>
                              <div class="col-md-6">
                                 <strong class="Header_brown">Sleep Duration:</strong>
                                    <span class="border_bottom">
                                       <input type="text" name="sleep_duration_text" id="sleep_duration_text" class="form-control" disabled="">
                                        <input type="hidden" name="sleep_duration" id="sleep_duration" class="form-control">
                                    </span>
                              </div>
                              <div class="col-md-12">
                                 <p class="text-danger" id="time_note_0" style="font-size: 11px;"><a href="images/Device-SystemTime-Format.png" target="_blank" style="color: red;    text-decoration: underline;">Displays AM/PM or 24 Hour Format as per your Device Time Setting</a></p>
                              </div>
                           </div>

                           <div id="activity_diary">

                           </div>
                           <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr align="left">
                                 <td height="50" colspan="4" valign="top"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" class="btn btn-primary" /></td>
                              </tr>
                           </table>
                           <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                 <td align="left" valign="top">
                                    <?php echo $obj->getScrollingWindowsCodeMainContent($page_id);?>
                                    <?php echo $obj->getPageContents2($page_id);?>
                                 </td>
                              </tr>
                           </table>
                        </form>
                     </td>
                  </tr>
               </table>
            </div>
            <!--right 1-->         
            <div class=" col-md-2">            
               <?php include_once('left_sidebar.php'); ?>
            </div>
            <!--right 2-->
            <div class=" col-md-2"> 
               <?php include_once('right_sidebar.php'); ?>
            </div>
         </div>
      </div>
      <!--end container-->
      <?php include_once('footer.php');?>

      <div id="page_loading_bg" class="page_loading_bg" style="display:none;">
         <div id="page_loading_img" class="page_loading_img"><img border="0" src="<?php echo SITE_URL;?>/images/loading.gif" /></div>
      </div>
  
      <!-- Bootstrap Core JavaScript -->
      <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
      <script type="text/javascript">

         //added on ample 11-06-20
         var title_set='<?=$_GET["title"];?>';
         if(title_set)
         {
            $('#day_month_year').trigger('change');
         }
         else
         {
            disable_activity_form();
         }

         

         $('.datepicker').on('focus', function(e) {
                e.preventDefault();
                $(this).attr("autocomplete", "off");  
            });
         
         $(document).ready(function(){
             //code by ample 08-01-20
               $('#day_month_year').attr('autocomplete', 'off');
               $('#day_month_year').datepicker(
                        {
                            dateFormat: 'dd-mm-yy',
                            minDate: '-1D',
                            maxDate: '+0D',
                        }        
                );

            });

         //add by ample 20-03-20

         function already_set_activity()
         {
            var date_set=$('#day_month_year').val();
            //add by ample 11-06-20
            var title_set='<?=$_GET["title"];?>';

            // alert(title_set);
            //return false;

               $.ajax({
                  type: "POST",
                  url: "remote.php?action=checkActivityData",
                  dataType: "json",
                  data: {date_set:date_set,title_set:title_set},
                  success : function(data){

                      //console.log(data);
                     //  alert(data.message);
                        if(data.status==true && data.redirect==0)
                        {
                           $('#activity_diary').html(data.html);
                           $('#totalRow').val(data.count);
                           $("#sleep_duration").val(data.sleep_duration);
                           var duration_text=timeConvert(data.sleep_duration);
                           $("#sleep_duration_text").val(duration_text);
                           $("#yesterday_sleep_time").val(data.yesterday_sleep_time);
                           $("#today_wakeup_time").val(data.today_wakeup_time);
                           $("#yesterday_sleep_time").attr( "readonly", "readonly" );
                           $("#today_wakeup_time").attr( "readonly", "readonly" );
                           $('#yesterday_sleep_time option:not(:selected)').prop('disabled', true);
                           $('#today_wakeup_time option:not(:selected)').prop('disabled', true);
                        }
                        else if(data.status==true && data.redirect==1)
                        {  
                           //$('#today_wakeup_time').removeAttr("onchange");
                           $('#activity_diary').html(data.html);
                           $('#totalRow').val(data.count);

                           if(data.have_data==1)
                           {
                              $("#sleep_duration").val(data.sleep_duration);
                              var duration_text=timeConvert(data.sleep_duration);
                              $("#sleep_duration_text").val(duration_text);
                              $("#yesterday_sleep_time").val(data.yesterday_sleep_time);
                              $("#today_wakeup_time").val(data.today_wakeup_time);
                              $("#yesterday_sleep_time").attr( "readonly", "readonly" );
                              $("#today_wakeup_time").attr( "readonly", "readonly" );
                              $('#yesterday_sleep_time option:not(:selected)').prop('disabled', true);
                              $('#today_wakeup_time option:not(:selected)').prop('disabled', true);
                           }

                        }
                        else
                        {  
                           $('#totalRow').val('0');
                           $('#activity_diary').html('');
                           $("#sleep_duration").val('');
                           $("#sleep_duration_text").val('');
                           $("#yesterday_sleep_time").val('');
                           $("#today_wakeup_time").val('');
                           $("#yesterday_sleep_time").removeAttr( "readonly", "readonly" );
                           $("#today_wakeup_time").removeAttr( "readonly", "readonly" );
                           $('#yesterday_sleep_time option:not(:selected)').prop('disabled', false);
                           $('#today_wakeup_time option:not(:selected)').prop('disabled', false);
                           disable_activity_form();
                        }
                                             
                  },
                  error: function() {
                    alert('There was some error performing the AJAX call!');
                  }
              });
         }

         //add by ample 18-03-20
         function get_activity_form()
         {     
               var date = $("#day_month_year").val();
               var sleep_time = $("#yesterday_sleep_time").val();
               var wake_up_time = $("#today_wakeup_time").val();

               var title_set='<?=$_GET["title"];?>';

               if(!$.trim(date).length) 
               { 
                  alert('Please choose date!');
                  $('#today_wakeup_time option:selected').removeAttr('selected');
                  return false;
               }
               if(!$.trim(sleep_time).length) 
               { 
                  alert('Please select sleep time!');
                  $('#today_wakeup_time option:selected').removeAttr('selected');
                  return false;
               }
            
               var total_row=parseInt($("#totalRow").val());

               var sleep_duration=calculate_sleep_duration(sleep_time,wake_up_time);
               var sleep_duration_text=timeConvert(sleep_duration);

               $("#sleep_duration_text").val(sleep_duration_text);
               $("#sleep_duration").val(sleep_duration);
               //add by ample 11-06-20
               if(!title_set)
               {
                     $.ajax({
                        type: "POST",
                        url: "remote.php?action=getActivitiesSection",
                        // dataType: "json",
                        data: {wake_up_time:wake_up_time,total_row:total_row},
                        success : function(data){
                            
                              $('#activity_diary').html(data);
                              $("#yesterday_sleep_time").attr( "readonly", "readonly" );
                              $("#today_wakeup_time").attr( "readonly", "readonly" );

                              $('#yesterday_sleep_time option:not(:selected)').prop('disabled', true);
                              $('#today_wakeup_time option:not(:selected)').prop('disabled', true);
                           
                        },
                        error: function() {
                          alert('There was some error performing the AJAX call!');
                        }
                     });
               }

               
         }
         //add by ample & update by ample 29-04-20
         function calculate_sleep_duration(sleep_time,wake_up_time) {

            // wake_up_time1='24:00';
            // var hours1 = parseInt((wake_up_time1).split(':')[0], 10) - parseInt((sleep_time).split(':')[0], 10);
            // var minutes1 = parseInt((wake_up_time1).split(':')[1], 10) - parseInt((sleep_time).split(':')[1], 10);

            // wake_up_time2=wake_up_time;
            // sleep_time1='00:00';

            // var hours2 = parseInt((wake_up_time2).split(':')[0], 10) - parseInt((sleep_time1).split(':')[0], 10);
            // var minutes2 = parseInt((wake_up_time2).split(':')[1], 10) - parseInt((sleep_time1).split(':')[1], 10);

            // hours= parseInt(hours1) + parseInt(hours2);
            // minutes= parseInt(minutes1) + parseInt(minutes2);

            //change by ample 29-04-20

            if(wake_up_time>sleep_time)
            {
               var hours = parseInt((wake_up_time).split(':')[0], 10) - parseInt((sleep_time).split(':')[0], 10);
               var minutes = parseInt((wake_up_time).split(':')[1], 10) - parseInt((sleep_time).split(':')[1], 10);
            }
            else
            {
               wake_up_time1='24:00';
               var hours1 = parseInt((wake_up_time1).split(':')[0], 10) - parseInt((sleep_time).split(':')[0], 10);
               var minutes1 = parseInt((wake_up_time1).split(':')[1], 10) - parseInt((sleep_time).split(':')[1], 10);

               wake_up_time2=wake_up_time;
               sleep_time1='00:00';

               var hours2 = parseInt((wake_up_time2).split(':')[0], 10) - parseInt((sleep_time1).split(':')[0], 10);
               var minutes2 = parseInt((wake_up_time2).split(':')[1], 10) - parseInt((sleep_time1).split(':')[1], 10);

               hours= parseInt(hours1) + parseInt(hours2);
               minutes= parseInt(minutes1) + parseInt(minutes2);
            }



            var total_minutes=hours*60+minutes;
            return total_minutes;
         }
         //add by ample
         function calculate_activity_duration(start_time,end_time) {

            var hours = parseInt((end_time).split(':')[0], 10) - parseInt((start_time).split(':')[0], 10);
            var minutes = parseInt((end_time).split(':')[1], 10) - parseInt((start_time).split(':')[1], 10);

            var total_minutes=hours*60+minutes;
            return total_minutes;
         }
         //add by ample & update by ample 29-04-20
         function calculate_time_duration(id="")
         {  
            var wakeup_time=$("#today_wakeup_time").val();
            var start_time=$("#start_time_"+id).val();

            if(wakeup_time>start_time)
            {
               alert('Time mismatch - Start Time should be after Wake Up Time!');
               $("#start_time_"+id).val('');
               return false;
            }
            
            if(!$.trim(start_time).length) 
               { 
                  alert('Select activity start time!');
                  // $("#end_time_"+id+' option:selected').removeAttr('selected');
                  $("#end_time_"+id).val('');
                  $("#duration_"+id).val('');
                  $("#duration_text_"+id).val('');
                  return false;
               }
            var end_time=$("#end_time_"+id).val();

            if(!$.trim(end_time).length) 
               { 

                  //$("#end_time_"+id+' option:selected').removeAttr('selected');
                  $("#end_time_"+id).val('');
                  $("#duration_"+id).val('');
                  $("#duration_text_"+id).val('');
                  return false;
               }

               if(start_time>end_time || start_time==end_time)
               {  
                  alert('Time mismatch - End Time should be after Start Time!');
                  //$("#end_time_"+id+' option:selected').removeAttr('selected');
                  $("#end_time_"+id).val('');
                  $("#duration_"+id).val('');
                  $("#duration_text_"+id).val('');
                  return false;
               }
               
               var duration=calculate_activity_duration(start_time,end_time);
               $("#duration_"+id).val(duration);

               var duration_text=timeConvert(duration);
               $("#duration_text_"+id).val(duration_text);
               
         }
         //add by ample
         function add_more_activity()
         {
            var wake_up_time = $("#today_wakeup_time").val();
            var total_row=parseInt($("#totalRow").val());
            var total_row= total_row+1;
            $.ajax({
                  type: "POST",
                  url: "remote.php?action=getActivitiesSection",
                  // dataType: "json",
                  data: {wake_up_time:wake_up_time,total_row:total_row},
                  success : function(data){
                      
                        $('#activity_diary').append(data);
                        $("#totalRow").val(total_row);
                     
                  },
                  error: function() {
                    alert('There was some error performing the AJAX call!');
                  }
              });
         }
         //add by ample
         function remove_activity(row) {
            $("#row"+row).remove();
               var count_row = parseInt($("#totalRow").val());
                  count_row = count_row - 1;
                  $("#totalRow").val(count_row);
         }
         //add by ample 19-03-20
         function timeConvert(n) {
            var num = n;
            var hours = (num / 60);
            var rhours = Math.floor(hours);
            var minutes = (hours - rhours) * 60;
            var rminutes = Math.round(minutes);
            return num + " minutes [ " + rhours + " hour(s) & " + rminutes + " minute(s) ]";
            }

         function erase_input(id)
         {
             $("#activity_"+id).val('');
         }

         function activity_datalist(id)
         {
            var value = $("#activity_"+id).val();
            var final_value=$('#capitals'+id+' [value="' + value + '"]').data('value');
            if(final_value=='' || value=='' || value==undefined || final_value==undefined)
            {
               alert('Please choose activity in list!');
               return false;
            }
            $('#activity_id_'+id).val(final_value);
         }

         function disable_activity_form()
         {
            $.ajax({
                  type: "POST",
                  url: "remote.php?action=disable_activity_form",
                  // dataType: "json",
                  data: {},
                  success : function(data){

                        $('#activity_diary').html(data);
                     
                  },
                  error: function() {
                    alert('There was some error performing the AJAX call!');
                  }
              });
         }

      </script>

   </body>
</html>