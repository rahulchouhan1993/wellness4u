<?php

require_once('../classes/config.php');
require_once('../classes/vendor.php');

$page_id="214";
$admin_main_menu_id = '32';
$view_action_id = '';
$add_action_id = '';
$edit_action_id = '';
$delete_action_id = '';

$obj = new Vendor();
if(!$obj->isVendorLoggedIn())
{
	header("Location: login.php");
	exit(0);
}
else
{
	$adm_vendor_id = $_SESSION['adm_vendor_id'];
}

// if(!$obj->chkIfAccessOfMenu($adm_vendor_id,$admin_main_menu_id))
// {
// 	header("Location: invalid.php");
// 	exit(0);
// }

if(isset($_GET['msg']) && $_GET['msg'] != '')
{
	$msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'.urldecode($_GET['msg']).'</strong></div>';
}
else
{
	$msg = '';
}


$start_date=$end_date=$user_id=$search_keywords="";

    if(isset($_POST['filter_submit']) && !empty($_POST))
   {  
      $start_date=$_POST['start_date'];
      $end_date=$_POST['end_date'];
      $user_id=$_POST['user_id'];
      $search_keywords=$_POST['search_keywords'];
      $data = $obj->GetAppointmentData($start_date,$end_date,$search_keywords,$user_id);
   }
   else
   {
       $data = $obj->GetAppointmentData();
   }


   if(isset($_POST['appt_decline']) && !empty($_POST))
   {

      $data = array('id'=>$_POST['appt_id'],
                  'request_status' =>'DeclineByVendor', 
                  'remark'=>$_POST['remark']
               );

      $result=$obj->appointment_status_update($data);

      if($result==true)
      {
         $_SESSION['success_msg']="Appointment Decline Successfully";
      }
      else
      {
         $_SESSION['error_msg']="Try Later!";
      }

       header("Location: appointment_list.php");
         exit(0);
   }

    if(isset($_POST['appt_accept']) && !empty($_POST))
   {

      $data = array('id'=>$_POST['appt_id'],
                  'request_status' =>'Accept', 
                  'remark'=>$_POST['remark']
               );

      $result=$obj->appointment_status_update($data);

      if($result==true)
      {
         $_SESSION['success_msg']="Appointment Accept Successfully";
      }
      else
      {
         $_SESSION['error_msg']="Try Later!";
      }

       header("Location: appointment_list.php");
         exit(0);
   }


   if(isset($_POST['appt_reschedule']) && !empty($_POST))
   {

      $data = array('id'=>$_POST['appt_id'],
                  'request_status' =>'Reschedule', 
                  'reschedule_date' =>date("Y-m-d", strtotime($_POST['appt_date'])), 
                  'reschedule_time' =>$_POST['appt_time'], 
                  'reschedule_location' =>$_POST['location'], 
                  'remark'=>$_POST['remark']
               );

      $result=$obj->appointment_reschedule_update($data);

      if($result==true)
      {
         $_SESSION['success_msg']="Appointment Reschedule Successfully";
      }
      else
      {
         $_SESSION['error_msg']="Try Later!";
      }

       header("Location: appointment_list.php");
         exit(0);
   }

?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo SITE_NAME;?> - Business Associates</title>

	<?php require_once 'head.php'; ?>

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-sm-10">

			<div class="panel">

				<div class="panel-body">

					<div class="row mail-header">

						<div class="col-md-6">

							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>

						</div>

					</div>

					<hr>  

					<div class="row ">

						<div class="col-md-12">

							<center><div id="error_msg" style="color: red;"><?php if($error) { echo $err_msg; } ?></div></center>
                                      <?php echo $obj->getPageIcon($page_id);?>
                                        <?php echo $obj->getPageContents($page_id);  ?>
						</div>

					</div>            
                                

                   <div class="row">
                     <div class="col-md-11">
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
                              echo '<div class="alert alert-danger">'.$message.'</div>';
                              unset($_SESSION['error_msg']);
                           }

                           ?>
                        <form name="frmadviserquery" method="post" action="" >
                            <table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" >
                              <tr>
                                  <td width="20%" height="50" align="left" valign="middle" bgcolor="#FFFFFF">

                                        <strong class="Header_brown">From date</strong></td><td width="25%">
                                         <input name="start_date" id="start_date" type="text" value="<?php echo $start_date; ?>" class="form-control input-half-width datepicker" style="width: 150px!important;" autocomplete="off"/>
                                        
                                        <td width="5%"></td>
                                        <td width="10%"><strong class="Header_brown">To date</strong></td><td width="25%">
                                       <input name="end_date" id="end_date" type="text" value="<?php echo $end_date; ?>" class="form-control input-half-width datepicker" style="width: 150px!important;" autocomplete="off"/>

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
                                                  $vendors=$obj->get_users_appointments(); 
                                                  if(!empty($vendors))
                                                  {
                                                     
                                                    foreach ($vendors as $key => $value) {
                                                      $sel="";
                                                         if($value==$user_id)
                                                         {
                                                           $sel="selected";
                                                         }
                                                      ?>
                                                      <option value="<?=$value;?>" <?=$sel;?> ><?=$obj->getUserFullNameById($value);?></option>
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
                        <table class="table table-bordered table-hover">
                           <tr class="info">
                              <td><strong>Sr No.</strong></td>
                              <td><strong>Appointment Date</strong></td>
                              <td><strong>Appointment Time</strong></td>
                              <td><strong>Contact Name</strong></td>
                              <td><strong>Contact Address</strong></td>
                              <td><strong>User Info</strong></td>
                              <td><strong>Request Status</strong></td>
                              <td><strong>Request Date</strong></td>
                              <td><strong>Action</strong></td>
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
                                    <td><?php echo $obj->getUserFullNameById($value['user_id']); ?></td>
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
                                       <a href="appointment_detail_view.php?appt_id=<?=$value['id'];?>" target="_blank"><button class="btn btn-default btn-sm">View</button></a>
                                       <?php 
                                          if($value['request_status']=='Pending')
                                          {
                                             ?>
                                             <button class="btn btn-default btn-sm" onclick="decline_cancel('<?=$value["id"]?>')">Decline</button>
                                             <button class="btn btn-default btn-sm" onclick="appoint_accept('<?=$value["id"]?>')">Accept</button>
                                             <button class="btn btn-default btn-sm" onclick="appoint_reschedule('<?=$value["id"]?>')">Reschedule</button>
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
                     <div class="col-md-1"></div>
                  </div>               


				</div>

			</div>

		</div>

    <div class="col-sm-2"><?php include_once('wa_right_sidebar.php'); ?></div>

	</div>

</div>

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
               <input type="hidden" name="appt_id" id="appt_id1">
              <button type="submit" name="appt_decline" class="btn btn-default">Submit</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="acceptModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Appointment Accept</h4>
        </div>
        <div class="modal-body">
            <form action="" method="post">
               <div class="form-group">
                 <label for="remark">Remark:</label>
                 <textarea class="form-control" rows="3" id="remark" name="remark"></textarea>
               </div>
               <input type="hidden" name="appt_id" id="appt_id2">
              <button type="submit" name="appt_accept" class="btn btn-default">Submit</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <!-- Modal -->
  <div class="modal fade" id="RescheduleModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Reschedule Appointment</h4>
        </div>
        <div class="modal-body">
            <form action="" method="post">
               <div class="form-group row">
                  <div class="col-md-6">
                     <label>Date:</label>
                     <input type="text" class="form-control" id="appt_date" name="appt_date" required="">
                  </div>
                  <div class="col-md-6">
                     <label>Time:</label>
                     <input type="time" class="form-control" id="appt_time" name="appt_time" required="">
                  </div>
              </div>
              <div class="form-group">
                 <label for="remark">Location:</label>
                 <textarea class="form-control" rows="3" id="location" name="location"></textarea>
               </div>
               <div class="form-group">
                 <label for="remark">Remark:</label>
                 <textarea class="form-control" rows="3" id="remark" name="remark"></textarea>
               </div>
               <input type="hidden" name="appt_id" id="appt_id3">
              <button type="submit" name="appt_reschedule" class="btn btn-default">Submit</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>



<script type="text/javascript">

  
            $(function () {

                $('#start_date').datepicker({
                  format: 'dd-mm-yyyy',
                  todayHighlight: true,
                });
                $('#end_date').datepicker({
                  format: 'dd-mm-yyyy',
                  todayHighlight: true,
                });
            });
        

   $(document).ready(function(){
        $('#appt_date').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            startDate: new Date()
        });
    })

    function decline_cancel(appt_id,appt_status)
    {
      $('#appt_id1').val(appt_id);
      $("#DeclineModal").modal();
    }
    function appoint_accept(appt_id,appt_status)
    {
      $('#appt_id2').val(appt_id);
      $("#acceptModal").modal();
    }
    function appoint_reschedule(appt_id)
    {
      $('#appt_id3').val(appt_id);
      $("#RescheduleModal").modal();
    }
</script>