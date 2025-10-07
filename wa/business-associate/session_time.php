<?php

require_once('../classes/config.php');
require_once('../classes/vendor.php');

$page_id=0;
$admin_main_menu_id = '';
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

 $id = $_GET['SID'];

   $data = $obj->get_vendor_contact_detail($id,$adm_vendor_id);

   $session_data = $obj->get_vendor_time_slots($id,$adm_vendor_id);

   $slots = array();
    foreach ($session_data as $element) {
        $slots[$element['week']][] = $element;
    }

    $holiday_data = $obj->get_vendor_holidays($id,$adm_vendor_id);

    $week_data = $obj->get_vendor_week_setting($id,$adm_vendor_id);

   //  echo "<pre>";

   // print_r($week_data);

   // die('---');


   if(empty($data))
   {
      echo "<script>window.location.href='edit_profile.php'</script>";

      exit(0);  
   }

   if(isset($_POST['save_time']) && !empty($_POST) )
   {
      // echo "<pre>";
      // print_r($_POST);
      // die('---');

        $data = array('vendor_id'=>$adm_vendor_id , 
                      'contact_id'=>$id,
                      'week'=>$_POST['week'],
                      'start_time'=>$_POST['start_time'],
                      'end_time'=>$_POST['end_time'],
                      );

        $res=$obj->save_time_slots($data);
        if($res)
        { 
          $_SESSION['success_msg'] = 'Time slot save Successfully!';
        }
        else
        {
          $_SESSION['error_msg'] = 'Try later!';
        }
         header("Location: session_time.php?SID=".$id);
         exit(0);
   }

    if(isset($_POST['save_holiday']) && !empty($_POST) )
    {
      // echo "<pre>";
      // print_r($_POST);
      // die('---');
      
      if(empty($_POST['end_date']))
      {
        $_POST['end_date']=$_POST['start_date'];
      }

        $data = array('vendor_id'=>$adm_vendor_id , 
                      'contact_id'=>$id,
                      'start_date'=>date("Y-m-d", strtotime($_POST['start_date'])),
                      'end_date'=>date("Y-m-d", strtotime($_POST['end_date'])),
                      );

        $res=$obj->save_vendor_holidays($data);
        if($res)
        { 
          $_SESSION['success_msg'] = 'Holiday save Successfully!';
        }
        else
        {
          $_SESSION['error_msg'] = 'Try later!';
        }
         header("Location: session_time.php?SID=".$id);
         exit(0);
    }

    if(isset($_POST['save_setting']) && !empty($_POST) )
    {
      // echo "<pre>";
      // print_r($_POST);
      // die('---');

       $data=array();
        $count_row=count($_POST['week']);
        for ($i=0; $i < $count_row; $i++) { 
          $data[] = array( 
                    'week' =>$_POST['week'][$i] ,
                    'status' =>$_POST['status'][$i] ,
                  );  
        }

        $res=$obj->save_week_setting_data($adm_vendor_id,$id,$data);
        if($res)
        { 
          $_SESSION['success_msg'] = 'Week setting update Successfully!';
        }
        else
        {
          $_SESSION['error_msg'] = 'Try later!';
        }
         header("Location: session_time.php?SID=".$id);
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

   <style type="text/css">
      .jumbotron.jumbotron-pro
      {
         padding-right: 35px;
         padding-left: 35px;
      }
      .jumbotron.jumbotron-pro h1
      {
            font-size: 35px;
      }
      .slot-close
      {
        position: absolute;
        background: red;
        font-size: 11px;
        padding: 2.5px;
        top: -7.5px;
        border-radius: 50%;
        cursor: pointer;
      }
      .slot-box .label
      {
        position: relative;
        margin: 10px;
      }
   </style>

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-sm-12">

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

                                        <?php echo $obj->getPageContents($page_id);  ?>
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
                        
                           <div class="jumbotron jumbotron-pro">
                                 <h1><?=$data['contact_person']?> (<?=$obj->getSubCategoryName($data['contact_designation']);?>) </h1> 
                           </div>

                           <button data-toggle="modal" data-target="#timeModal">Add Time Slot</button> &nbsp;
                            <button data-toggle="modal" data-target="#holidayModal">Add Holidays</button> &nbsp;
                            <button data-toggle="modal" data-target="#listModal">View Holidays List</button> &nbsp;
                            <button data-toggle="modal" data-target="#weekModal">Week Setting</button> &nbsp;
                            
                           <br></br>
                           <div class="slot-box">
                              <?php 

                              if(!empty($slots))
                              {
                                foreach ($slots as $index => $variable) {
                                  ?>
                                  <h2><?=$index;?></h2>
                                  <h4>
                                    <?php 
                                      foreach ($variable as $key => $value) {
                                        ?>
                                        <span class="label label-default"><?=$value['start_time'];?>-<?=$value['end_time'];?> <i class="fa fa-close slot-close" onclick="slot_delete(<?=$value['id'];?>)"></i></span>
                                        <?php
                                      }
                                    ?>
                                  </h4>
                                  <?php
                                }
                              }
                              else
                              {
                                echo 'No time slot found.';
                              }

                              ?>

                           </div>
                        
                        
                     </div>
                  </div>          
                                
			</div>

		</div>

	</div>

</div>


<!-- Time Modal -->
<div id="timeModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Time Slot</h4>
      </div>
      <div class="modal-body">
         <form method="post" action="">
           <div class="form-group">
           <label>Select Week:</label>
           <select class="form-control" name="week">
             <option value="Monday">Monday</option>
             <option value="Tuesday">Tuesday</option>
             <option value="Wednesday">Wednesday</option>
             <option value="Thursday">Thursday</option>
             <option value="Friday">Friday</option>
             <option value="Saturday">Saturday</option>
             <option value="Sunday">Sunday</option>
           </select>
         </div>
           <div class="form-group">
             <label>Start Time:</label>
             <input type="time" class="form-control" name="start_time">
           </div>
           <div class="form-group">
             <label>End Time:</label>
             <input type="time" class="form-control" name="end_time">
           </div>
           <button type="submit" name="save_time" class="btn btn-default">Save</button>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Holiday Modal -->
<div id="holidayModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Holiday</h4>
      </div>
      <div class="modal-body">
         <form method="post" action="">
           <div class="form-group">
             <label>Start Date:</label>
             <input type="text" class="form-control" name="start_date" id="start_date" required="true" autocomplete="off">
           </div>
           <div class="form-group">
             <label>End Date:</label>
             <input type="text" class="form-control" name="end_date" id="end_date" required="true" autocomplete="off">
           </div>
           <button type="submit" name="save_holiday" class="btn btn-default">Save</button>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- List Modal -->
<div id="listModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">List Holiday</h4>
      </div>
      <div class="modal-body">
          <table class="table">
            <thead>
              <tr>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                if(!empty($holiday_data))
                {
                  foreach ($holiday_data as $key => $value) {
                    ?>
                    <tr>
                      <td><?=date("d-m-Y", strtotime($value['start_date']));?></td>
                      <td><?=date("d-m-Y", strtotime($value['end_date']));?></td>
                      <td><button class="btn btn-danger btn-sm" onclick="holiday_delete(<?=$value['id'];?>)">Delete</button></td>
                    </tr>
                    <?php
                  }
                }
                else
                {
                  ?>
                  <tr>
                    <td colspan="2">No data found</td>
                  </tr>
                  <?php
                }
              ?>
            </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- Time Modal -->
<div id="weekModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Week Setting</h4>
      </div>
      <div class="modal-body">
         <form method="post" action="">
          <?php 
            if(!empty($week_data))
            {
              foreach ($week_data as $key => $value) {
                ?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="week[]" value="<?=$value['week'];?>" readonly="">
                    </div>
                    <div class="col-md-6">
                      <select class="form-control" name="status[]">
                         <option value="1" <?=($value['status']==1)? 'selected' : '' ;?> >On</option>
                         <option value="0" <?=($value['status']==0)? 'selected' : '' ;?> >Off</option>
                     </select>
                    </div>
                  </div>
                </div>
                <?php
              }
            }
            else
            {
              ?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="week[]" value="Monday" readonly="">
                    </div>
                    <div class="col-md-6">
                      <select class="form-control" name="status[]">
                         <option value="1">On</option>
                         <option value="0">Off</option>
                     </select>
                    </div>
                  </div>
                </div>
              <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="week[]" value="Tuesday" readonly="">
                    </div>
                    <div class="col-md-6">
                      <select class="form-control" name="status[]">
                         <option value="1">On</option>
                         <option value="0">Off</option>
                     </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="week[]" value="Wednesday" readonly="">
                    </div>
                    <div class="col-md-6">
                      <select class="form-control" name="status[]">
                         <option value="1">On</option>
                         <option value="0">Off</option>
                     </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="week[]" value="Thusday" readonly="">
                    </div>
                    <div class="col-md-6">
                      <select class="form-control" name="status[]">
                         <option value="1">On</option>
                         <option value="0">Off</option>
                     </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="week[]" value="Friday" readonly="">
                    </div>
                    <div class="col-md-6">
                      <select class="form-control" name="status[]">
                         <option value="1">On</option>
                         <option value="0">Off</option>
                     </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="week[]" value="Saturday" readonly="">
                    </div>
                    <div class="col-md-6">
                      <select class="form-control" name="status[]">
                         <option value="1">On</option>
                         <option value="0">Off</option>
                     </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="week[]" value="Sunday" readonly="">
                    </div>
                    <div class="col-md-6">
                      <select class="form-control" name="status[]">
                         <option value="1">On</option>
                         <option value="0">Off</option>
                     </select>
                    </div>
                  </div>
                </div>
              <?php
            }
          ?>

           

           <button type="submit" name="save_setting" class="btn btn-default">Save</button>
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

   $(document).ready(function(){
        $('#start_date').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            startDate: new Date()
        });
         $('#end_date').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            startDate: new Date()
        });
    })

  function holiday_delete(data_id)
  { 
      if (!confirm("Do you want to delete holiday?")){
      return false;
    }

     var dataString ='action=holiday_delete_data&data_id='+data_id;

      $.ajax({

         type: "POST",

         url: "ajax/remote.php",

         data: dataString,

         cache: false,

         success: function(result)

         {  
            location.reload();
            $('#listModal').modal();
            $('#listModal').modal('show');

         }

      });
  }

  function slot_delete(data_id)
  { 

    if (!confirm("Do you want to delete slot?")){
      return false;
    }

     var dataString ='action=slot_delete_data&data_id='+data_id;

      $.ajax({

         type: "POST",

         url: "ajax/remote.php",

         data: dataString,

         cache: false,

         success: function(result)

         {  
            location.reload();

         }

      });
  }

</script>