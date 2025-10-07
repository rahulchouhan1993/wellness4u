<?php 

include('classes/config.php');

$page_id = '999';

$obj = new frontclass();

$obj2 = new frontclass2();


$page_data = $obj->getPageDetails($page_id);


$ref = base64_encode($page_data['menu_link']);



        if($obj->isLoggedIn())
         {
         
              $user_id = $_SESSION['user_id'];
         
         }
         else
         {
               header("Location: login.php?ref=".$ref);
               exit();
         }

    

    $appt_id=$_GET['appt_id'];
    $data=array();
    if(!empty($appt_id))
    {
    	$data=$obj->get_appointment_detail($appt_id);

    }

  // echo '<pre>';
  //   print_r($data);
  // die('---');

?>

<!DOCTYPE html>

<html lang="en">

  <head>    
  <?php include_once('head.php');?>
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
    b
    {
        color: #AA1144;
    }
  </style>
  </head>

  <body>

  <?php include_once('header.php');?>


    <section id="checkout">
      <div class="container">
        <div class="breadcrumb">
          <div class="row">
            <div class="col-md-8">  
              <?php echo $obj->getBreadcrumbCode($page_id);?> 
            </div>
            <div class="col-md-4">
            </div>
          </div>
        </div>
        <div class="">
          <span id="response_msg"></span>
          <span id="error_msg"></span>
          <div class="col-md-10" id="bgimage" style="background-repeat:repeat; padding:5px;">
            <div class="row">
              <div class="col-md-12" id="testdata">
                <?php echo $obj->getPageIcon($page_id);?>
                <span class="Header_brown"><?php echo $page_data['page_title'];?></span><br /><br />
                <?php echo $obj->getPageContents($page_id);?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
              	 <?php 
              	 	if($data)
              	 	{	
                    ?>
                     <h4 class="Header_brown" style="text-align: center;font-size: 25px;font-weight: 600;">
                       <?php 
                          if($data['request_status']=='DeclineByVendor')
                          {
                            echo "Decline By Vendor";
                          }
                          elseif ($data['request_status']=='DeclineByUser') {
                            echo "Decline By You";
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
              	 		if($data['vendor_id']>0)
              	 		{
              	 			?>
              	 			<hr>
                        <div class="text-right">
              	 			 <b>Vendor Name: </b> <?=$obj->getProUserFullNameById($data['vendor_id']);?> &nbsp;&nbsp;&nbsp;
              	 			 <b>Vendor Email: </b> <?=$obj->getProUserEmailById($data['vendor_id']);?>
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
                          <br><br>
                          <b>Important :</b> Please note the above changes to your Appointment of <?=date('d M Y',strtotime($data['appointment_date']));?>  at <?=date('g:i A',strtotime($data['appointment_time']));?> On <?=date('d M Y',strtotime($data['status_update_date']));?>.
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
                          <b>Location:</b> <?=$data['contact_address'];?> <br><br>
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
    						   	<h4 class="text-primary">Special Inputs</h4>
    					   		<br>
    					   		<div class="row">
    						   	<?php
    						   	 foreach ($data['special'] as $key => $value) {
    						   	 	?>
    						   	 	<div class="col-md-4">
    						   	 		<div class="bg-box">
    						   	 		<h5 style="font-weight: 600;"><?=$value['box_title'];?></h5>
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
            </div>
        </div>
        <div class="col-md-2"><?php include_once('right_sidebar.php'); ?></div>
      </div>
    </div>
  </section>
<?php include_once('footer.php');?> 


<script type="text/javascript">


$(".formData").submit(function(e) {

   e.preventDefault();
   var formData = $(this).serialize();

   $.ajax({
           type: "POST",
           url: 'remote.php',
           data: formData,    
           dataType: "json",       
           success: function(response)
           {
               //alert(response); // show response from the php script.
               //console.log(response.status);
               if(response.status==true)
               {
                  window.open(response.url, '_blank');
               }
               else
               {
                  alert('SORRY No matching Data Now')
               }
           }
         });

});

</script>

  </body>

</html>