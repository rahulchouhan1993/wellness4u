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

    $appt_id=$_GET['appt_id'];
    $data=array();
    if(!empty($appt_id))
    {
      $data=$obj->get_appointment_detail($appt_id);

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
    .bg-box
    {
      padding: 15px;
      background: lemonchiffon;
    }
    .btn-dark
    {
      background: #555;
      color: #fff;
    }
    .btn-dark:hover
    {
      color: #eee;
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
                    <div class="col-md-1"></div>
                     <div class="col-md-10">
                        <?php 
                          if($data)
                          { 
                            ?>
                            <h4 class="Header_brown" style="text-align: center;font-size: 25px;font-weight: 600;">
                             <?php 
                                if($data['request_status']=='DeclineByVendor')
                                {
                                  echo "Decline By You";
                                }
                                elseif ($data['request_status']=='DeclineByUser') {
                                  echo "Decline By User";
                                }
                                elseif ($data['request_status']=="RescheduleCancel") {
                                  echo "Cancelled";
                                }
                                else
                                {
                                  echo $data['request_status'];
                                }
                             ?>
                           </h4>
                            <?php
                            if($data['user_id']>0)
                            {
                              ?>
                              <hr>
                              <div class="text-right">
                               <b>User Name: </b> <?=$obj->getUserFullNameById($data['user_id']);?> &nbsp;&nbsp;&nbsp;
                               <b>User Email: </b> <?=$obj->getUserEmailById($data['user_id']);?>
                             </div>
                              <?php
                            }
                            ?>
                            <hr>
                            <?php 
                              if($data['request_status']=='Reschedule' || $data['request_status']=='RescheduleCancel')
                              {
                                ?>
                                <h5><b>Rescheduled  Details :</b></h5>
                                <b>Date:</b> <?=date('d M Y',strtotime($data['reschedule_date']));?>  &nbsp;&nbsp;&nbsp;
                                <b>Time:</b> <?=date('g:i A',strtotime($data['reschedule_time']));?> <br>
                                <?php 
                                  if(!empty($data['reschedule_location'] || $data['reschedule_location']==$data['contact_address']))
                                  {
                                    ?>
                                     <b>New Location:</b> <?=$data['reschedule_location'];?> <br>
                                    <?php
                                  }
                                ?>
                               
                                <b>Remark:</b> <?=$data['remark'];?> <br><br>
                                <b>To Meet:</b> <?=$data['contact_name'];?>  &nbsp;&nbsp;&nbsp;
                                <b>Location:</b> <?=$data['contact_address'];?>
                                <br> <br>
                                <b>Important :</b> Please note the above changes to user Appointment of <?=date('d M Y',strtotime($data['appointment_date']));?>  at <?=date('g:i A',strtotime($data['appointment_time']));?> On <?=date('d M Y',strtotime($data['status_update_date']));?>.<br>
                                <?php
                              }
                              else
                              {
                                ?>
                                 <?php 
                                  if($data['request_status']!='Pending')
                                  {
                                    ?>
                                    <b>Remark:</b> <?=$data['remark'];?> <br>
                                    <?php
                                  }
                                ?>
                                <b>Appointment Date:</b> <?=date('d M Y',strtotime($data['appointment_date']));?>  &nbsp;&nbsp;&nbsp;
                                <b>Appointment Time:</b> <?=date('g:i A',strtotime($data['appointment_time']));?>  
                                <br>
                               
                                <b>To Meet:</b> <?=$data['contact_name'];?>  &nbsp;&nbsp;&nbsp;
                                <b>Location:</b> <?=$data['contact_address'];?><br><br>
                                <?php 
                                  if($data['request_status']!='Pending')
                                  {
                                    ?>
                                    <b>Appointment request status update On <?=date('d M Y',strtotime($data['status_update_date']));?>.</b>
                                    <?php
                                  }
                                ?>
                                <br>
                                <?php
                              }
                            ?>
                          
                            <br>

                            <?php
                        if(!empty($data['special']))
                       {
                        ?>
                        <hr>
                        <h4 class="text-primary"><b>Special Inputs</b></h4>
                        <br>
                        <div class="row">
                        <?php
                         foreach ($data['special'] as $key => $value) {
                          ?>
                          <div class="col-md-4">
                            <div class="bg-box">
                            <h5><b><?=$value['box_title'];?></b></h5>
                                  <br>
                                  <?php
                                    echo '<p>';
                                    if($value['listing_date_type']=="date_range")
                              {
                              ?>
                                <?=date('d M Y',strtotime($value['start_date']));?>
                                <?=date('d M Y',strtotime($value['end_date']));?>
                              <?php
                             }
                             elseif($value['listing_date_type']=="single_date")
                             {
                              ?>
                               <?=date('d M Y',strtotime($value['single_date']));?>
                              <?php
                             }
                             elseif($value['listing_date_type']=="month_wise")
                             {
                              ?>
                               <?php 
                                if(!empty($value['months']))
                                      { 
                                        $value['months']=explode(',', $value['months']);
                                        $arr=array();
                                        foreach ($value['months'] as $month) {
                                          $arr[]=$obj->getmonthname($month);
                                        }
                                        echo implode(",",$arr);
                                      }
                             }
                             elseif($value['listing_date_type']=="days_of_week")
                             {
                            ?>
                              
                                  <?php
                                      if(!empty($value['days_of_week']))
                                      { 
                                        $value['days_of_week']=explode(',', $value['days_of_week']);
                                        $arr=array();
                                        foreach ($value['days_of_week'] as $week) {
                                          $arr[]=$obj->getWeekName($week);
                                        }
                                        echo implode(",",$arr);
                                      }
                             }
                             elseif($value['listing_date_type']=="days_of_month")
                             {
                              ?>
                              
                                  <?php   
                                  if(!empty($value['days_of_month']))
                                      { 
                                        echo $value['days_of_month'];
                                      }
                             }
                             echo '</p>';
                             if($value['location_fav_cat'])
                             {
                              ?>
                               <p><?=$obj->getFavCategoryNameMultiple($value['location_fav_cat'])?></p>
                              <?php
                             }

                             if($value['user_response_fav_cat'])
                             {
                              ?>
                               <p><?=$obj->getFavCategoryNameMultiple($value['user_response_fav_cat'])?></p>
                              <?php
                             }

                             if($value['user_Interaction'])
                             {
                              ?>
                               <p><?=$obj->getFavCategoryNameMultiple($value['user_Interaction'])?></p>
                              <?php
                             }

                             if($value['alerts_fav_cat'])
                             {
                              ?>
                               <p><?=$obj->getFavCategoryNameMultiple($value['alerts_fav_cat'])?></p>
                              <?php
                             }

                             if($value['bes_time'])
                             {
                              ?>
                               <p><?=$value['bes_time'];?> hours</p>
                              <?php
                             }

                             if($value['duration'])
                             {
                              ?>
                               <p><?=$value['duration'].' '.$obj->getFavCategoryName($value['unit'])?></p>
                              <?php
                             }

                             if($value['scale'])
                             {
                              ?>
                               <p><?=$value['scale'];?></p>
                              <?php
                             }

                             if($value['comment'])
                             {
                              ?>
                               <p><?=$value['comment'];?></p>
                              <?php
                             }

                             ?>
                          </div>
                          </div>
                          <?php
                          $key++;
                            if($key % 3 == 0){  echo '</div><div class="row">';
                          }
                         }
                         ?>
                         </div>
                         <?php
                       }

                          }
                          else
                          {
                            ?>
                            <div class="alert alert-warning alert-dismissible">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      No data found
                    </div>
                            <?php
                          }
                         ?>
                      
                     </div>
                     <div class="col-md-1"></div>
                  </div>               


				</div>

			</div>

		</div>

	</div>

</div>

  



<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>


