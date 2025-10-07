<?php 

include('classes/config.php');

$page_id = '162';

$obj = new frontclass();

$obj2 = new frontclass2();


$page_data = $obj->getPageDetails($page_id);


$ref = base64_encode($page_data['menu_link']);


if(isset($_SESSION['adm_vendor_id']) && !empty($_SESSION['adm_vendor_id']))
    {
        $vendor_id=$_SESSION['adm_vendor_id'];

    }
    else
    {
        if($obj->isLoggedIn())
         {
         
              $user_id = $_SESSION['user_id'];
         
         }
         else
         {
               header("Location: login.php");
               exit();
         }

    }

    $data_id=$_GET['data_id'];

    $token=base64_decode($_GET['token']);
    $data=array();
    if(!empty($data_id))
    {
    	$data=$obj->get_design_my_life_data($data_id);

    }
    else
    {
    	$redirect=$_GET['redirect'];
	    $redirect_page=$_GET['redirect_page'];
	    $redirect_id=$_GET['redirect_id'];

	  $data=$obj->get_design_my_life_redirect_data($redirect,$redirect_id);

    }

    $hilighter="";
 	if($data['box_title']==$token)
 	{
 		$hilighter="animate-box";
 	}
   
//add by amle 10-06-20
  if(!empty($data))
  {	
  	  $data['activity']=$obj->set_today_activity_process($data);

  	  if(!empty($data['user_inputs']))
  	  {
  	  	 foreach ($data['user_inputs'] as $key => $value) {
  	  	 	$data['user_inputs'][$key]['activity']=$obj->set_today_activity_process($value);
  	  	 }
  	  }

  	  if(!empty($data['user_special']))
  	  {
  	  	 foreach ($data['user_special'] as $key => $value) {
  	  	 	$data['user_special'][$key]['activity']=$obj->set_today_activity_process($value);
  	  	 }
  	  }

  }
  // echo '<pre>';
  //   print_r($data);
  // die('---');

  if(isset($_POST['action_save']) && !empty($_POST))
  {
  // 		  echo '<pre>';
  //   print_r($_POST);
  // die('---');

  	$result=$obj->Post_user_action_data($_POST);

  	if($result==true)
      {
         $favCat=$obj->getFavCategoryID_by_favname($_POST['action_title']);

         $data=$obj->getFavCategoryData($favCat);

         if(!empty($data) && !empty($data['link']))
          {
              $url=$data['link'].'?';
              if(!empty($data['ref_num']))
              {
                  $url=$url.'&ref_num='.$data['ref_num'];
              }
              if(!empty($data['group_code_id']))
              {
                  $url=$url.'&group_id='.$data['group_code_id'];
              }
              if(!empty($data['ref_num']) || !empty($data['group_code_id']))
              {
                  $url=$url.'&fav_cat_id='.$data['fav_cat_id'];
              }
              if(!empty($_POST['action_title']))
              {
                  $title=base64_encode($_POST['action_title']);
                  $url=$url.'&title='.$title;
              }
              header("Location:".$url);
              exit(0);
          }
          else
          {
            header("Location: design-my-life-data-view.php?data_id=".$_GET['data_id']);
            exit(0);
          }

         $_SESSION['success_msg']="Your Action Post Successfully";

      }
      else
      {
         $_SESSION['error_msg']="Try Later!";
         header("Location: design-my-life-data-view.php?data_id=".$_GET['data_id']);
         exit(0);
      }

       

  }

 if(isset($_POST['new_task']) && !empty($_POST))
  {
  //      echo '<pre>';
  //   print_r($_POST);
  // die('---');
  $title=$_POST['title'];
  $date_type=$_POST['dateradio'];
  $date=$_POST['date'];
  $start_date=$_POST['start_date'];
  $end_date=$_POST['end_date'];
   $error=0;

  if($date_type=='single_date')
  {
     if(empty($date))
     {
        $_SESSION['error_msg']="Please date select!";
        $error=1;
     }
     $start_date=addslashes('0000-00-00');
     $end_date=addslashes('0000-00-00');
     $date=addslashes(date("Y-m-d", strtotime($date)));
  }
  else
  {
      if(empty($start_date) || empty($end_date))
     {
        $_SESSION['error_msg']="Please date select!";
         $error=1;
     }
     elseif($end_date<$start_date)
     {
        $_SESSION['error_msg']="Please right date select!";
         $error=1;
     }
     $date=addslashes('0000-00-00');
     $start_date=addslashes(date("Y-m-d", strtotime($start_date)));
     $end_date=addslashes(date("Y-m-d", strtotime($end_date)));
  }

  if($error==0)
  {

      $new_data=array(
                    'box_title'=>addslashes($title),
                    'listing_date_type'=>addslashes($date_type),
                    'single_date'=>$date,
                    'start_date'=>$start_date,
                    'end_date'=>$end_date,
                  );

      $result=$obj->post_new_user_task($new_data);

      if($result==true)
      {
         $_SESSION['success_msg']="Your Task reapet post Successfully, check your calander!";
      }
      else
      {
         $_SESSION['error_msg']="Try Later!";
      }

       header("Location: design-my-life-data-view.php?data_id=".$_GET['data_id']);
         exit(0);
  }
  else
  {
        header("Location: design-my-life-data-view.php?data_id=".$_GET['data_id']);
        exit(0);
  }

  }


  $DLY=$obj->GetDesignYourLifeData('16');

  $final_dropdown=$obj->getBoxtitleDYL($DLY['data_category']);


  //           echo '<pre>';
  //   print_r($final_dropdown);
  // die('---');

            // $show_cat = '';
            // $fetch_cat1 = array();
            // $fetch_cat2 = array();
            // $fetch_cat3 = array();
            // $fetch_cat4 = array();

            // if ($DLY['sub_cat_id'] != '') {
            //     if ($DLY['sub_cat1_show_fetch'] == 1) {
            //         $show_cat.= $DLY['sub_cat_id'] . ',';
            //     } else {

            //         $sub_cat1 = explode(',', $DLY['sub_cat_id']);
            //         $fetch_cat1=$obj->getDataFromReportCustomized($sub_cat1,$DLY['sub_cat1_link'],$DLY['prof_cat1_ref_code'],$DLY['prof_cat1_uid']);
            //     }
            // }

            // if ($DLY['sub_cat2'] != '') {
            //     if ($DLY['sub_cat2_show_fetch'] == 1) {
            //         $show_cat.= $DLY['sub_cat2'] . ',';
            //     } else {
            //             $sub_cat2 = explode(',', $DLY['sub_cat2']);
            //             $fetch_cat2=$obj->getDataFromReportCustomized($sub_cat2,$DLY['sub_cat2_link'],$DLY['prof_cat2_ref_code'],$DLY['prof_cat2_uid']);
            //     }
            // }
            // if ($DLY['sub_cat3'] != '') {
            //     if ($DLY['sub_cat3_show_fetch'] == 1) {
            //         $show_cat.= $DLY['sub_cat3'] . ',';
            //     } else {
            //             $sub_cat3 = explode(',', $DLY['sub_cat3']);
            //             $fetch_cat3=$obj->getDataFromReportCustomized($sub_cat3,$DLY['sub_cat3_link'],$DLY['prof_cat3_ref_code'],$DLY['prof_cat3_uid']);
            //     }
            // }
            // if ($DLY['sub_cat4'] != '') {
            //     if ($DLY['sub_cat4_show_fetch'] == 1) {
            //         $show_cat.= $DLY['sub_cat4'] . ',';
            //     } else {
            //             $sub_cat4 = explode(',', $DLY['sub_cat4']);
            //             $fetch_cat4=$obj->getDataFromReportCustomized($sub_cat4,$DLY['sub_cat4_link'],$DLY['prof_cat4_ref_code'],$DLY['prof_cat4_uid']);

            //     }
            // }
            
            // $show_cat = explode(',', $show_cat);
            // $show_cat = array_filter($show_cat);
            // $final_array = array_merge($fetch_cat1, $fetch_cat2, $fetch_cat3, $fetch_cat4);
            // $final_dropdown = $obj->CreateDesignLifeDropdownEdit($show_cat, $final_array, '');



?>

<!DOCTYPE html>

<html lang="en">

  <head>    
  <?php include_once('head.php');?>
  <style type="text/css">
  	.bg-box
  	{
  		padding: 15px;
      overflow-wrap: break-word;
      word-wrap: break-word;
      margin: 2.5px;
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
    
  	/* animation css by ample (ss) */
   .animate-box {
        animation-name: colorChange;
        animation-duration: 10s;
        animation-iteration-count: infinite;
    }
    @keyframes colorChange {
        0% {
            background: #001fff4f;    
        }
        25% {
            background: #ff001861;    
        }
        50% {
            background: #00ff374f;    
        }
        75% {
            background: #efff004f;    
        }
        100% {
            background: #001fff4f;    
        }
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
              	 <?php 
              	 	if($data)
              	 	{	
                    ?>
                    <button class="journey-button btn btn-warning" onclick="journey_box()">Your journey</button>
                    <div class="journey-box" style="display: none;">
                    <?php
              	 		if($data['user_id']>0)
              	 		{
              	 			?>
                       <hr>
              	 			 <b><?=($data['post_by']=='User')? 'Posted By' : 'Name';?>: </b> <?=$obj->getUserFullNameById($data['user_id']);?> &nbsp;&nbsp;&nbsp;
              	 			 <b>Email: </b> <?=$obj->getUserEmailById($data['user_id']);?> &nbsp;&nbsp;&nbsp;
              	 			 <b>Posted Date: </b> <?=date("d-m-Y", strtotime($data['add_date']));?>
              	 			<?php
              	 		}
              	 		if($data['vendor_id']>0)
              	 		{
              	 			?>
                       <hr>
              	 			 <b><?=($data['post_by']=='Vendor')? 'Posted By' : 'Name';?>: </b> <?=$obj->getProUserFullNameById($data['vendor_id']);?> &nbsp;&nbsp;&nbsp;
              	 			 <b>Email: </b> <?=$obj->getProUserEmailById($data['vendor_id']);?>
              	 			 <b>Posted Date: </b> <?=date("d-m-Y", strtotime($data['add_date']));?>
              	 			<?php
              	 		}
              	 		?>
                    <?php 
                      if(!empty($data['redirect_page']))
                      {
                        $url=$obj->get_journey_url($data);
                        ?>
                        <br>
                        <p>
                          <br>
                        <i style="color: red;">Your journey began from : <a href="<?=$url;?>" target="_blank"><?=$obj->getPagenamebyid($data['redirect_page']);?></a></i>
                        </p>
                        <?php
                      }
                    ?>
              	 		</div>
                    <hr>
              	 		<div class="<?=$hilighter;?>" style="padding: 5px;">
              	 		<h4><?=$data['box_title'];?></h4>
              	 		<br>
              	 		<?php
              	 			echo '<p>';
              	 		 	if($data['listing_date_type']=="date_range")
						    {
						  	?>
						     <b>For the period from :</b> <?=date('d M Y',strtotime($data['start_date']));?>
						     <b>To :</b> <?=date('d M Y',strtotime($data['end_date']));?>
						    <?php
						   }
						   elseif($data['listing_date_type']=="single_date")
						   {
						    ?>
						    <b>Date:</b> <?=date('d M Y',strtotime($data['single_date']));?>
						    <?php
						   }
						   elseif($data['listing_date_type']=="month_wise")
						   {
						    ?>
						    <b>Months :</b> 
						    <?php 
					    		if(!empty($data['months']))
				                { 
				                  $data['months']=explode(',', $data['months']);
				                  $arr=array();
				                  foreach ($data['months'] as $month) {
				                    $arr[]=$obj->getmonthname($month);
				                  }
				                  echo implode(",",$arr);
				                }
						   }
						   elseif($data['listing_date_type']=="days_of_week")
						   {
						  ?>
						  	<b>Week days :</b>
						        <?php
				                if(!empty($data['days_of_week']))
				                { 
				                  $data['days_of_week']=explode(',', $data['days_of_week']);
				                  $arr=array();
				                  foreach ($data['days_of_week'] as $week) {
				                    $arr[]=$obj->getWeekName($week);
				                  }
				                  echo implode(",",$arr);
				                }
						   }
						   elseif($data['listing_date_type']=="days_of_month")
						   {
						    ?>
						    <b>Days of Month :</b>
						        <?php   
						        if(!empty($data['days_of_month']))
				                { 
				                  echo $data['days_of_month'];
				                }
						   }
						   echo '</p>';
						   if($data['location_fav_cat'])
						   {
						   	?>
						   	 <p><b>Location: </b><?=$obj->getFavCategoryName($data['location_fav_cat'])?></p>
						   	<?php
						   }

						   if($data['user_response_fav_cat'])
						   {
						   	?>
						   	 <p><b>User Response: </b><?=$obj->getFavCategoryName($data['user_response_fav_cat'])?></p>
						   	<?php
						   }

						   if($data['user_what_fav_cat'])
						   {
						   	?>
						   	 <p><b>User InterACTION: </b><?=$obj->getFavCategoryName($data['user_what_fav_cat'])?></p>
						   	<?php
						   }

						   if($data['alerts_fav_cat'])
						   {
						   	?>
						   	 <p><b>Alert: </b><?=$obj->getFavCategoryName($data['alerts_fav_cat'])?></p>
						   	<?php
						   }

						   if($data['bes_time'])
						   {
						   	?>
						   	 <p><b>Time: </b><?=$data['bes_time'];?></p>
						   	<?php
						   }

						   if($data['duration'])
						   {
						   	?>
						   	 <p><b>Duration: </b><?=$data['duration'].' '.$obj->getFavCategoryName($data['unit'])?></p>
						   	<?php
						   }

						   if($data['scale'])
						   {
						   	?>
						   	 <p><b>Scale: </b><?=$data['scale'];?></p>
						   	<?php
						   }

						   if($data['comment'])
						   {
						   	?>
						   	 <p><b>Comment: </b><?=$data['comment'];?></p>
						   	<?php
						   }

						   if($data['activity']==1 && !empty($user_id))
						   {	
						   	  $title=base64_encode($data['box_title']);
						   	  ?>
						   	  <a href="activity.php?parent_id=<?=$data['id'];?>&title=<?=$title;?>" target="_blank"><button class="btn btn-defult btn-sm btn-dark">DO IT</button></a>
						   	  <a href="javascript:void(0)" onclick="action_popup('<?=$data['id']?>',0)"><button class="btn btn-defult btn-sm btn-dark">MODIFY</button></a>
						   	  <?php
						   }
						   ?>
               <button class="btn btn-defult btn-sm btn-dark" onclick="check_do_it('parent','<?=$data['id']?>','<?=$data['box_title']?>')" title="History"><i class="fa fa-history" aria-hidden="true"></i></button>
						   </div>
						   <?php
						   if(!empty($data['user_inputs']))
						   {
						   	?>
						   	<hr>
						   	<h3 class="text-primary">My Steps</h3>
					   		<br>
					   		<div class="row">
						   	<?php
						   	 foreach ($data['user_inputs'] as $key => $value) {
						   	 	$hilighter="";
						   	 	if($value['user_input']==$token)
						   	 	{
						   	 		$hilighter="animate-box";
						   	 	}
						   	 	?>
						   	 	<div class="col-md-4">
						   	 		<div class="bg-info bg-box <?=$hilighter;?>">
						   	 		<h4><?=$value['user_input'];?></h4>
			              	 		<br>
			              	 		<?php
			              	 			echo '<p>';
			              	 		 	if($value['listing_date_type']=="date_range")
									    {
									  	?>
									     <b>From :</b> <?=date('d M Y',strtotime($value['start_date']));?>
									     <b>To :</b> <?=date('d M Y',strtotime($value['end_date']));?>
									    <?php
									   }
									   elseif($value['listing_date_type']=="single_date")
									   {
									    ?>
									    <b>Date:</b> <?=date('d M Y',strtotime($value['single_date']));?>
									    <?php
									   }
									   elseif($value['listing_date_type']=="month_wise")
									   {
									    ?>
									    <b>Months :</b> 
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
									  	<b>Week days :</b>
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
									    <b>Days of Month :</b>
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
									   	 <p><b>Location: </b><?=$obj->getFavCategoryNameMultiple($value['location_fav_cat'])?></p>
									   	<?php
									   }

									   if($value['user_response_fav_cat'])
									   {
									   	?>
									   	 <p><b>User Response: </b><?=$obj->getFavCategoryNameMultiple($value['user_response_fav_cat'])?></p>
									   	<?php
									   }

									   if($value['user_InterACTION'])
									   {
									   	?>
									   	 <p><b>User InterACTION: </b><?=$obj->getFavCategoryNameMultiple($value['user_InterACTION'])?></p>
									   	<?php
									   }

									   if($value['alerts_fav_cat'])
									   {
									   	?>
									   	 <p><b>Alert: </b><?=$obj->getFavCategoryNameMultiple($value['alerts_fav_cat'])?></p>
									   	<?php
									   }

									   if($value['bes_time'])
									   {
									   	?>
									   	 <p><b>Time: </b><?=$value['bes_time'];?></p>
									   	<?php
									   }

									   if($value['duration'])
									   {
									   	?>
									   	 <p><b>Duration: </b><?=$value['duration'].' '.$obj->getFavCategoryName($value['unit'])?></p>
									   	<?php
									   }

									   if($value['scale'])
									   {
									   	?>
									   	 <p><b>Scale: </b><?=$value['scale'];?></p>
									   	<?php
									   }

									   if($value['comment'])
									   {
									   	?>
									   	 <p><b>Comment: </b><?=$value['comment'];?></p>
									   	<?php
									   }

									   if($value['activity']==1 && !empty($user_id))
									   {	
									   	  $title=base64_encode($value['user_input']);
									   	  ?>
									   	  <a href="activity.php?child_id=<?=$value['id'];?>&title=<?=$title;?>" target="_blank"><button class="btn btn-defult btn-sm btn-dark">DO IT</button></a>
									   	  <a href="javascript:void(0)" onclick="action_popup('<?=$value['design_data_id']?>','<?=$value['id']?>')"><button class="btn btn-defult btn-sm btn-dark">MODIFY</button></a>
									   	  <?php
									   }
									   ?>
                     <button class="btn btn-defult btn-sm btn-dark" onclick="check_do_it('child','<?=$value['id']?>','<?=$value['user_input']?>')" title="History"><i class="fa fa-history" aria-hidden="true"></i></button>
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

						    if(!empty($data['user_special']))
						   {
						   	?>
						   	<hr>
						   	<!-- <h3 class="text-primary">Special Inputs</h3>
					   		<br> -->
					   		<div class="row">
						   	<?php
						   	 foreach ($data['user_special'] as $key => $value) {
                  $hilighter="";
                  if($value['user_input']==$token)
                  {
                    $hilighter="animate-box";
                  }
						   	 	?>
						   	 	<div class="col-md-4">
						   	 		<div class="bg-danger bg-box <?=$hilighter;?>">
						   	 		<h4><?=$value['user_input'];?></h4>
			              	 		<br>
			              	 		<?php
			              	 			echo '<p>';
			              	 		 	if($value['listing_date_type']=="date_range")
									    {
									  	?>
									     <b>From :</b> <?=date('d M Y',strtotime($value['start_date']));?>
									     <b>To :</b> <?=date('d M Y',strtotime($value['end_date']));?>
									    <?php
									   }
									   elseif($value['listing_date_type']=="single_date")
									   {
									    ?>
									    <b>Date:</b> <?=date('d M Y',strtotime($value['single_date']));?>
									    <?php
									   }
									   elseif($value['listing_date_type']=="month_wise")
									   {
									    ?>
									    <b>Months :</b> 
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
									  	<b>Week days :</b>
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
									    <b>Days of Month :</b>
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
									   	 <p><b>Location: </b><?=$obj->getFavCategoryNameMultiple($value['location_fav_cat'])?></p>
									   	<?php
									   }

									   if($value['user_response_fav_cat'])
									   {
									   	?>
									   	 <p><b>User Response: </b><?=$obj->getFavCategoryNameMultiple($value['user_response_fav_cat'])?></p>
									   	<?php
									   }

									   if($value['user_InterACTION'])
									   {
									   	?>
									   	 <p><b>User InterACTION: </b><?=$obj->getFavCategoryNameMultiple($value['user_InterACTION'])?></p>
									   	<?php
									   }

									   if($value['alerts_fav_cat'])
									   {
									   	?>
									   	 <p><b>Alert: </b><?=$obj->getFavCategoryNameMultiple($value['alerts_fav_cat'])?></p>
									   	<?php
									   }

									   if($value['bes_time'])
									   {
									   	?>
									   	 <p><b>Time: </b><?=$value['bes_time'];?></p>
									   	<?php
									   }

									   if($value['duration'])
									   {
									   	?>
									   	 <p><b>Duration: </b><?=$value['duration'].' '.$obj->getFavCategoryName($value['unit'])?></p>
									   	<?php
									   }

									   if($value['scale'])
									   {
									   	?>
									   	 <p><b>Scale: </b><?=$value['scale'];?></p>
									   	<?php
									   }

									   if($value['comment'])
									   {
									   	?>
									   	 <p><b>Comment: </b><?=$value['comment'];?></p>
									   	<?php
									   }

									   if($value['activity']==1 && !empty($user_id))
									   {	
									   	  $title=base64_encode($value['user_input']);
									   	  ?>
									   	  <a href="activity.php?child_id=<?=$value['id'];?>&title=<?=$title;?>" target="_blank"><button class="btn btn-defult btn-sm btn-dark">DO IT</button></a>
									   	  <a href="javascript:void(0)" onclick="action_popup('<?=$value['design_data_id']?>','<?=$value['id']?>')"><button class="btn btn-defult btn-sm btn-dark">MODIFY</button></a>
									   	  <?php
									   }
									   ?>
                     <button class="btn btn-defult btn-sm btn-dark" onclick="check_do_it('child','<?=$value['id']?>','<?=$value['user_input']?>')" title="History"><i class="fa fa-history" aria-hidden="true"></i></button>
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
        <div class="col-md-2">
        	<?php include_once('left_sidebar.php'); ?>
        	<?php include_once('right_sidebar.php'); ?>
        </div>
      </div>
    </div>
  </section>


<!-- Modal -->
<div id="actionModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?=empty($DLY['level_title'])? 'My Action' : $DLY['level_title']; ?></h4>
      </div>
      <div class="modal-body">
        	<!-- <?php 
        		echo '<pre>';
			    print_r($DLY);
			    echo '</pre>';
        	?> -->
        	<form action="" method="post">
			  <div class="form-group">
			  	<label ><?=$DLY['level_title_heading'];?></label> <br>
				  <select class="input-text-box input-half-width" name="action_title" required="true">
				  		<option value="">Select</option>
				    	<!-- <?=$final_dropdown;?> -->
				    	<?php 
				    		if(!empty($final_dropdown))
				    		{
				    			foreach ($final_dropdown as $key => $value) {
				    				?>
				    				<option value="<?=$value;?>"><?=$value;?></option>
				    				<?php
				    			}
				    		}
				    	?>
				  </select>
			  </div>
			  <?php 
			  	$outputstr = '';
			    $tr_days_of_month = 'none';
			    $tr_single_date = 'none';
			    $tr_date_range = 'none';
			    $tr_month_date = 'none';
			    $tr_days_of_week = 'none';
			  	for ($l = 1;$l <= 11;$l++) {

                    //update by ample 10-01-20 in ramakant code (common/both)
                if ($DLY['location_order_show'] == $l && ($DLY['location_show'] !=0)) {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="location_main" id="location_main" title="' . $DLY['location_heading'] . '">

                                     <option value="">' . $DLY['location_heading'] . '</option>

                                     ' . $obj->getFavCategoryRamakant($DLY['location_fav_cat'], '') . '

                                 </select> 

                                 <br><br>';
                }
                if ($DLY['user_date_order_show'] == $l && ($DLY['user_date_show'] !=0)) {
                    $outputstr.= '<span class="">

                                      <!--<b>Date Selection:</b>-->

                                     <select name="listing_date_type" id="listing_date_type" class="input-text-box input-quarter-width" onchange="toggleDateSelectionType(\'listing_date_type\')"  title="' . $DLY['user_date_heading'] . '">

                                        <option value="">Select Date Type</option>

                                         <option value="days_of_month">Days of Month</option>

                                         <option value="single_date">Single Date</option>

                                         <option value="date_range">Date Range</option>

                                         <option value="month_wise">Month Wise</option>

                                         <option value="days_of_week">Days of Week</option>



                                     </select>

                                  </span>

                             <span>

                                 <table style="margin-top:5px;">

                                 <tr id="tr_days_of_month" style="margin-top:10px; display:' . $tr_days_of_month . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <select id="days_of_month_main" name="days_of_month_main[]" multiple="multiple" class="input-text-box input-half-width" style="margin-top:20px;">';
                    foreach (range(1, 31) as $i) {
                        $outputstr .= '<option value="' . $i . '"';
                        if (in_array($i, $arr_days_of_month ?? [])) {
                            $outputstr .= ' selected="selected"';
                        }
                        $outputstr .= '>' . $i . '</option>';
                    }
                    $outputstr.= '</select>&nbsp;*<br>



                                             You can choose more than one option by using the ctrl key.



                                         </td>



                                     </tr>

                                    

                                     <tr id="tr_single_date" style="margin-top:10px; display:' . $tr_single_date . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <input name="single_date_main" id="single_date_main" type="text" value="' . $single_date . '" class="input-text-box input-full-width" style="margin-top:20px;" placeholder="Select Date" />



                                             <script>$("#single_date_main").datepicker({ minDate: 0 , dateFormat : "dd-mm-yy"}); </script>



                                         </td>



                                     </tr>



                                     <tr id="tr_date_range" style="margin-top:10px; display:' . $tr_date_range . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <input name="start_date_main" id="start_date_main" type="text" value="' . $start_date . '" class="input-text-box input-half-width" style="margin-top:20px;" placeholder="Start Date"  /> - <input name="end_date_main" id="end_date_main" type="text" value="' . $end_date . '" class="input-text-box input-half-width" style="margin-top:20px;" placeholder="End Date" />



                                             <script>$("#start_date_main").datepicker({ minDate: 0 , dateFormat : "dd-mm-yy"});$("#end_date_main").datepicker({ minDate: 0 , dateFormat : "dd-mm-yy"}); </script>



                                         </td>



                                     </tr>



                                     <tr id="tr_days_of_week" style="margin-top:10px; display:' . $tr_days_of_week . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <select id="days_of_week_main" name="days_of_week_main[]" multiple="multiple" class="input-text-box input-half-width" style="margin-top:20px;">



                                             ' . $obj->getDayOfWeekOptionsMultiple($arr_days_of_week) . '



                                             </select>&nbsp;*<br>



                                             You can choose more than one option by using the ctrl key.



                                         </td>



                                     </tr>



                                     <tr id="tr_month_date" style="margin-top:10px; display:' . $tr_month_date . '">



                                         <td align="right" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="center" valign="top"><strong>&nbsp;</strong></td>



                                         <td align="left">



                                             <select id="months_main" name="months_main[]" multiple="multiple" class="input-text-box input-half-width" style="margin-top:20px;">



                                             ' . $obj->getMonthsOptionsMultiple($arr_month) . ' 



                                             </select>&nbsp;*<br>



                                             You can choose more than one option by using the ctrl key.



                                         </td>



                                     </tr>

                                    </table>

                             </span>

                             <br><br>';
                }
                if ($DLY['time_order_show'] == $l && ($DLY['time_show'] !=0)) {

                        $outputstr.= '<input type="time" class="input-text-box input-quarter-width" name="bes_time_main"  id="bes_time_main"  placeholder="' . $DLY['time_heading'] . '" title="' . $DLY['time_heading'] . '" />
                        <span class="text-danger" id="time_note_main" style="font-size: 11px;"><a href="images/Device-SystemTime-Format.png" target="_blank" style="color: red; text-decoration: underline;">Displays AM/PM or 24 Hour Format as per your Device Time Setting</a></span>
                        <br><br>';
                }
                if ($DLY['duration_order_show'] == $l && ($DLY['duration_show'] !=0)) {
                    $outputstr.= '<input type="text" title="' . $DLY['duration_heading'] . '" name="duration_main" id="duration_main" onKeyPress="return isNumberKey(event);" placeholder="' . $DLY['duration_heading'] . '" class="input-text-box input-sml-width" autocomplete="false">
                        <select  class="input-text-box input-quarter-width" name="unit_main" id="unit_main" title="Duration Type">
                                                <option value="">Select Unit</option>
                                                    '.$obj->getFavCategoryRamakant('82','').'
                                                </select>
                             <br><br>';
                }
                if ($DLY['like_dislike_order_show'] == $l && ($DLY['User_view'] !=0)) {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="User_view_main" id="User_view_main" title="' . $DLY['like_dislike_heading'] . '">

                                     <option value="">' . $DLY['like_dislike_heading'] . '</option>

                                     ' . $obj->getFavCategoryRamakant($DLY['user_response_fav_cat'], '') . '

                                 </select>

                                 <br><br>';
                }
                if ($DLY['set_goals_order_show'] == $l && ($DLY['User_Interaction'] !=0)) {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="User_Interaction_main" id="User_Interaction_main" title="' . $DLY['set_goals_heading'] . '">

                                         <option value="">' . $DLY['set_goals_heading'] . '</option>

                                         ' . $obj->getFavCategoryRamakant($DLY['user_what_fav_cat'], '') . '

                                     </select>

                                     <br><br>';
                }
                if ($DLY['scale_order_show'] == $l && ($DLY['scale_show'] !=0)) {
                    $outputstr.= '<select  class="input-text-box input-quarter-width" name="scale_main" id="scale_main" title="' . $DLY['scale_heading'] . '">

                                         <option value="">' . $DLY['scale_heading'] . '</option>

                                         <option value="1">1</option>

                                         <option value="2">2</option>

                                         <option value="3">3</option>

                                         <option value="4">4</option>

                                         <option value="5">5</option>

                                         <option value="6">6</option>

                                         <option value="7">7</option>

                                         <option value="8">8</option>

                                         <option value="9">9</option>

                                         <option value="10">10</option>

                                     </select>

                                     <br><br>';
                }
                if ($DLY['reminder_order_show'] == $l && ($DLY['alert_show'] !=0)) {
                    $outputstr.= '<select class="input-text-box input-half-width" name="alert_main" id="alert_main" title="' . $DLY['reminder_heading'] . '">

                                         <option value="">' . $DLY['reminder_heading'] . '</option>

                                         ' . $obj->getFavCategoryRamakant($DLY['alerts_fav_cat'], '') . '

                                     </select>

                                     <br><br>';
                }
                if ($DLY['comment_order_show'] == $l && ($DLY['comment_show'] !=0)) {
                    $outputstr.= '<textarea name="comment_main" title="' . $DLY['comments_heading'] . '" id="comment_main" rowspan="3" class="input-text-box input-half-width" autocomplete="false" placeholder="' . $DLY['comments_heading'] . '" ></textarea>

                                     <br><br>';
                                 }
            }
            echo $outputstr;
			  ?>
			  <input type="hidden" name="design_id" id="design_id">
			  <input type="hidden" name="design_input_id" id="design_input_id">
			  <input type="hidden" name="user_id" id="user_id" value="<?=$user_id;?>">
			  <button type="submit" name="action_save" class="btn btn-default">Submit</button>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<?php include_once('footer.php');?> 


<script type="text/javascript">


	$('#single_date_main').datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
         
    $('#start_date_main').datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
 
    $('#end_date_main').datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'}); 

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

//add by ample 23-07-20
function action_popup(design_id,design_input_id)
{	
	$('#design_id').val(design_id);
	$('#design_input_id').val(design_input_id);
	jQuery.noConflict();
	$('#actionModal').modal('show');
}

  //add by ample 28-09-20

  function check_do_it(type,id,title)
  {
    var dataString ='type='+type+'&id='+id+'&title='+title+'&action=check_do_it_history';

      $.ajax({

              type: "POST",

              url: 'remote.php', 

              data: dataString,

              cache: false,

              success: function(result)

                  {

                    //alert(result);
                    BootstrapDialog.show({

                            title: 'DO IT - Activity History',

                            message:result

                    }); 
                   
                  }

             });
  }

  //add by ample 29-09-20

  function repeat_task(title="")
  {
    var dataString ='title='+title+'&action=repeat_task_form';

      $.ajax({

              type: "POST",

              url: 'remote.php', 

              data: dataString,

              cache: false,

              success: function(result)

                  {

                    //alert(result);
                    BootstrapDialog.show({

                            title: 'Repeat Task Creation',

                            message:result

                    });
                   
                  }

             });
  }

         function toggleDateSelectionType(id_val)
         
         
         
         {
         
         // alert(id_val);
         
         // console.log(id_val);
         
            var sc_listing_date_type = document.getElementById(id_val).value;
         
            if (sc_listing_date_type == "days_of_month") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = '';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "single_date") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = '';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "date_range") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = '';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "days_of_week") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = '';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "month_wise") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = '';
         
            }
         
            else
         
            {   
         
         
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
         
         
         }

   //add by ample 30-09-20

   function journey_box()
   {  
     $('.journey-box').slideToggle();
   }


</script>

  </body>

</html>