<?php 
   include('classes/config.php');
   $obj = new frontclass();
   $page_id = '213';
   
   $page_data = $obj->getPageDetails($page_id);
   $ref = base64_encode($page_data['menu_link']);
   if($obj->isLoggedIn())
   
   {
   
    $user_id = $_SESSION['user_id'];
   
    $obj->doUpdateOnline($_SESSION['user_id']);
   
   }
   else
   {
      echo "<script>window.location.href='login.php?ref=$ref'</script>";

      exit(0);   
   }

   $start_date=$end_date=$vendor_id=$search_keywords="";

    if(isset($_POST['filter_submit']) && !empty($_POST))
   {  
      $start_date=$_POST['start_date'];
      $end_date=$_POST['end_date'];
      $vendor_id=$_POST['vendor_id'];
      $search_keywords=$_POST['search_keywords'];
      $data = $obj->GetAppointmentData($start_date,$end_date,$search_keywords,$vendor_id);
   }
   else
   {
       $data = $obj->GetAppointmentData();
   }


   // echo '<pre>';

   // print_r($data);

   // die();

   if(isset($_POST['status_save']) && !empty($_POST))
   {
      // print_r($_POST);
      // die('----');

      $data = array('id'=>$_POST['appt_id'],
                  'request_status' =>$_POST['appt_status'], 
                  'remark'=>$_POST['remark']
               );

      $result=$obj->appointment_status_update($data);

      if($result==true)
      {
         $_SESSION['success_msg']="Status Update Successfully";
      }
      else
      {
         $_SESSION['error_msg']="Try Later!";
      }

       header("Location: appointment-list.php");
         exit(0);
   }

   ?>
<!DOCTYPE html>
<html lang="en">
   <head>    
      <?php include_once('head.php');?>
   </head>
   <body>
      <?php include_once('analyticstracking.php'); ?>
      <?php include_once('analyticstracking_ci.php'); ?>
      <?php include_once('analyticstracking_y.php'); ?>
      <?php include_once('header.php');?>
      <div id='changemusic'></div>
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
               <div class="col-md-10">

                  <div class="row">
                     <div class="col-md-12"> 
                         <?php  echo $obj->getPageContents($page_id); ?>
                         <br>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-12">
                         <?php
                           if(!empty($_SESSION['success_msg'])) 
                           {
                              $message = $_SESSION['success_msg'];
                              echo '<div class="alert alert-success">'.$message.'</div>';
                              unset($_SESSION['success_msg']);
                           }

                           if(!empty($_SESSION['error_msg'])) 
                           {
                              $message = $_SESSION['error_msg'];
                              echo '<div class="alert alert-error">'.$message.'</div>';
                              unset($_SESSION['error_msg']);
                           }

                           ?>
                          <form name="frmadviserquery" method="post" action="" >
                            <table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" >
                              <tr>
                                  <td width="20%" height="50" align="left" valign="middle" bgcolor="#FFFFFF">

                                        <strong class="Header_brown">From date</strong></td><td width="25%">
                                         <input name="start_date" id="start_date" type="text" value="<?php echo $start_date; ?>" class="form-control input-half-width datepicker" style="width: 150px!important;"/>
                                        
                                        <td width="5%"></td>
                                        <td width="10%"><strong class="Header_brown">To date</strong></td><td width="25%">
                                       <input name="end_date" id="end_date" type="text" value="<?php echo $end_date; ?>" class="form-control input-half-width datepicker" style="width: 150px!important;"/>

                                       </td></tr>
                                       <tr>

                                       <td width="20%" height="50">
                                        <strong class="Header_brown">Search Keyword</strong>
                                          <td width="50%" colspan="4">                           
                                               <input name="search_keywords" id="search_keywords" type="text" value="<?php echo $search_keywords; ?>" class="form-control " />
                                    </td>
                                </tr>
                                <tr>
                                  <td width="20%" align="left" valign="middle" bgcolor="#FFFFFF" height="50">

                                        <label><strong class="Header_brown">Search For</strong></label></td><td width="25%">

                                           <select name="vendor_id" id="vendor_id" class="form-control">
                                              <option value="">Select Vendor</option>
                                             <?php 
                                                  $vendors=$obj->get_vendors_appointments(); 
                                                  if(!empty($vendors))
                                                  {
                                                     
                                                    foreach ($vendors as $key => $value) {
                                                      $sel="";
                                                         if($value==$vendor_id)
                                                         {
                                                           $sel="selected";
                                                         }
                                                      ?>
                                                      <option value="<?=$value;?>" <?=$sel;?> ><?=$obj->GetVendorName($value);?></option>
                                                      <?php
                                                    }
                                                  }
                                              ?>

                                        </select>    
                                      </td>

                                      <td width="5%"></td>

                                      <td width="10%">

                                        </td><td width="40%">

                                    </td>
                                  
                                </tr>

                                <tr>                            
                                   <td height="50">
                                </td>

                                <td colspan="4">
                                <input type="submit" name="filter_submit" class="btn btn-primary" value="Search" />
                                </td>

                                </tr>
                            </table>
                        </form>
                        <table class="table table-striped table-hover">
                           <tr class="info">
                              <td><strong>Sr No.</strong></td>
                              <td><strong>Appointment Date</strong></td>
                              <td><strong>Appointment Time</strong></td>
                              <td><strong>Contact Name</strong></td>
                              <td><strong>Contact Address</strong></td>
                              <td><strong>Vendor Info</strong></td>
                              <td><strong>Request Status</strong></td>
                              <td><strong>Request Date</strong></td>
                              <td style="min-width: 15%;width: 15%;"><strong>Action</strong></td>
                           </tr>
                           <?php 
                              if(!empty($data))
                              {
                                 foreach ($data as $key => $value) 
                                 {  ?>
                                 <tr>
                                    <td><?php echo $key+1; ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($value['appointment_date']));  ?></td>
                                    <td><?php echo date("g:i A", strtotime($value['appointment_time'])); ?></td>
                                    <td><?php echo $value['contact_name']; ?></td>
                                    <td><?php echo $value['contact_address']; ?></td>
                                    <td><?php echo $obj->GetVendorName($value['vendor_id']); ?></td>
                                    <td><?php echo $value['request_status']; ?> <br>
                                        <?php 
                                          if(!empty($value['remark']))
                                          {
                                             ?>
                                             <b>Remark:</b><?=$value['remark'];?><br>
                                             <?php
                                          }
                                          if(!empty($value['reschedule_date']))
                                          {
                                             ?>
                                             <b>Date:</b><?=date("d-m-Y", strtotime($value['reschedule_date']));?><br>
                                             <?php
                                          }
                                          if(!empty($value['reschedule_time']))
                                          {
                                             ?>
                                             <b>Time:</b><?=date("g:i A", strtotime($value['reschedule_time']));?><br>
                                             <?php
                                          }
                                          if(!empty($value['reschedule_location']))
                                          {
                                             ?>
                                             <b>Location:</b><?=$value['reschedule_location'];?><br>
                                             <?php
                                          }
                                        ?>
                                    </td>
                                    <td><?php echo date("d-m-Y", strtotime($value['request_date'])); ?></td>
                                    <td>
                                       <a href="appointment-detail-view.php?appt_id=<?=$value['id'];?>" target="_blank"><button class="btn btn-default btn-sm">View</button></a>
                                       <?php 
                                          if($value['request_status']=='Pending')
                                          {
                                             ?>
                                             <button class="btn btn-default btn-sm" onclick="decline_cancel('<?=$value["id"]?>','DeclineByUser')">Decline</button>
                                             <?php
                                          }
                                          if($value['request_status']=='Reschedule')
                                          {
                                             ?>
                                             <button class="btn btn-default btn-sm" onclick="decline_cancel('<?=$value["id"]?>','RescheduleCancel')">Cancel</button>
                                             <?php
                                          }
                                       ?>
                                    </td>
                                 </tr>
                              <?php } 
                           }
                           else
                           {
                              ?>
                                 <tr>
                                    <td colspan="9" class="text-center">No Appointment Found!</td>
                                 </tr>
                              <?php
                           }
                           ?>
                        </table>
                     </div>
                  </div>

               </div>
               <div class="col-md-2"> <?php include_once('left_sidebar.php'); ?> <?php include_once('right_sidebar.php'); ?></div>
            </div>
         </div>
         </div>
         </div>
         </div>
      </section>


  <!-- Modal -->
  <div class="modal fade" id="DeclineModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Appointment Decline/Cancel</h4>
        </div>
        <div class="modal-body">
            <form action="" method="post">
               <div class="form-group">
                 <label for="remark">Remark:</label>
                 <textarea class="form-control" rows="3" id="remark" name="remark"></textarea>
               </div>
               <input type="hidden" name="appt_id" id="appt_id">
               <input type="hidden" name="appt_status" id="appt_status">
              <button type="submit" name="status_save" class="btn btn-default">Submit</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>


      <?php include_once('footer.php');?>  

<script type="text/javascript">
    function decline_cancel(appt_id,appt_status)
    {
      jQuery.noConflict();
      $('#appt_id').val(appt_id);
      $('#appt_status').val(appt_status);
      $("#DeclineModal").modal();

    }
</script>



   </body>
</html>