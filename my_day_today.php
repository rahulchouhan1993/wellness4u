<?php 

include('classes/config.php');

$page_id = '45';

$obj = new frontclass();
 
$obj2 = new frontclass2();



$page_data = $obj->getPageDetails($page_id);

$ref = base64_encode($page_data['menu_link']);



$error = false;

$err_msg = '';



if(!$obj->isLoggedIn())



{



  $obj->doUpdateOnline($_SESSION['user_id']);

        //echo "<script>window.location.href='user_dashboard.php'</script>";

  header("Location: login.php?ref=".$ref);

        exit();



}

 else {

     $date = date("Y-m-d");

     $user_id = $_SESSION['user_id'];

     $obj->doUpdateOnline($_SESSION['user_id']);

     $my_day_today_sequence = $obj->getmydaytodaysequence($date,$user_id);

     if($my_day_today_sequence > 0)

     {

         //$_SESSION[''];

         $_SESSION['sequence'] = $my_day_today_sequence+1;

     }

}



$now = time();

$today_year = date("Y",$now);

$today_month = date("m",$now);

$today_day = date("d",$now); 



$year = $today_year;

$month = $today_month;

$day = $today_day;

$day_month_year = date("Y-m-d");



if(isset($_POST['btnSubmit']))  



{

   $data = array();

   $data = $_POST;

  // echo '<pre>';

  // print_r($data);

  // echo '<pre>';

  //  die();

  if($obj->addUsersMDT($user_id,$data))

  {

     header("Location: mycanvas.php?mdt_date=".$data['day_month_year'].'&sequence='.$data['sequence']);

     exit();

  }

  else

  {

    $error = true;

    $err_msg = '<p style="color:red;">Update fail</p>'; 

  }

    

}

 if(isset($_REQUEST['action']) && $_REQUEST['action'] =='getbescomment')

    {        

        $besname = $_REQUEST['bes_name'];

        $day_month_year = $_REQUEST['day_month_year'];

       

        $comment = $obj->getCommentByBesname($besname,$day_month_year);

       

//       echo '<pre>';

//       print_r($comment);

//       echo '</pre>';

       

       echo $comment;

       exit(0);

    }

    //getsequence

    else if(isset($_REQUEST['action']) && $_REQUEST['action'] =='getsequence')

    {        

        $date = date("Y-m-d",strtotime($_REQUEST['date']));

        $user_id = $_SESSION['user_id'];

        $sequence = $obj->getmydaytodaysequenceentry($date, $user_id);

        

        if($sequence == 0)

        {

            //echo 'Byyy';

           $sequence = 1; 

        }

        else

        {

            //echo 'Hiii';

          $sequence = $sequence+1;  

        }

        

        

        echo $sequence;

        exit(0);

    }

    //getbescomment

    $data_dropdown=array();

    $data_dropdown = $obj->GETDATADROPDOWNMYDAYTODAY('423','45');

    $arr_cert_cnt = array(0);

    $arr_cert_total_cnt = array(1);



   //  $data_dropdown[]=$data_dropdowns[0];

   //  echo "<pre>";
   //  print_r($data_dropdown);
   // die('-sdfs6f46574f6sdf');

   
$access_btn=$obj->check_user_subcription_plan_status($page_id);


?>

<!DOCTYPE html>

<html lang="en">

<head>    

    <?php include_once('head.php');?>

    <link rel="stylesheet" href="w_js/datepicker/css/bootstrap-datepicker.css">

    <script type="text/javascript" src="w_js/jquery-1.12.4.min.js" charset="UTF-8"></script>

    <script type="text/javascript" src="w_js/datepicker/js/bootstrap-datepicker.js" charset="UTF-8"></script>
    <!--comment by ample 08-05-20 -->
   <!--  <style>

        .ui-datepicker-header {

        display:none!important;

      }

    </style> -->

</head>

<body>

<?php include_once('analyticstracking.php'); ?>



<?php include_once('analyticstracking_ci.php'); ?>



<?php include_once('analyticstracking_y.php'); ?>

<?php //include_once('header-new.php');?>



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

          <div class="col-md-10" id="bgimage" style="background-repeat:repeat; padding:5px;">

              <div class="row">

                <div class="col-md-12">

                <!--<h2> <span class="Header_brown"><?php //echo $obj->getPageTitle($page_id);?></span></h2>-->

                <?php echo $obj->getPageContents($page_id);?>

                </div>

              </div>

              <div class="alert alert-danger alert-dismissible fade in" id="plan_msg" style="display: none;">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   Your current plan page limit exceeded now!
              </div>

              <div class="row">

                <div class="col-md-9">

                  <form role="form" class="form-horizontal" id="frmdaily_meal" name="frmdaily_meal" enctype="multipart/form-data" method="post"> 

                            <?php if($error){ ?>

                                <span style="color:red;"><?php echo $err_msg; ?></span>

                            <?php } ?>

                            <div class='col-md-12' style="margin-bottom:20px;">

                        </div>


                        <div class='col-md-3' style="margin-bottom:20px;">

                            <span style="font-size:15px;" class="Header_brown">Build your path</span>

                            <input type="text" required="" name="day_month_year" id="day_month_year" placeholder="Select Date" class="form-control datepicker"  onchange="GETSEQUENCE();" style="width: 155px;">

                        </div>

                        <div class='col-md-3' style="margin-bottom:20px;">

                            <span style="font-size:15px; font-weight: bold; display:none;" id="sequence_label" class="Header_brown">Sequence</span>

                            <?php $sequence = ($_SESSION['sequence'] > 0 ? $_SESSION['sequence'] : 1); ?>

                            

                            <input type="text" name="sequence" id="sequence" class="form-control" style="width:50px; display:none;"  readonly="" value="<?php echo ($_SESSION['sequence'] > 0 ? $_SESSION['sequence'] : 1); ?>">                 


                        </div>

                        <div class="col-md-6" style="margin-top: 35px;text-align: right;">

                          <span style="font-size:15px; font-weight: bold; display:none;" id="sequence_label" class="Header_brown">&nbsp;</span>

                          <a href="reset_mood.php?page_id=<?=$page_id;?>" target="_blank" ><button type="button" class="btn btn-danger btn-xs" style="border-radius: 0;">Reset Mood</button></a>
                          <?php //echo base64_encode();?>

                          <a href="my_life_pattrns.php?t=<?php echo base64_encode('tblusersmdt');?>"><input class="btn btn-danger btn-xs"  type="button" name="viewpost" id="viewpost" value="My Challenges History" style="border-radius: 0;"></a>
                          
                        </div>

                        <div class="col-md-12" style="border:1px solid #CBCFD4;background-color: #FFF7F5;">                     

                               <?php 

                                  $drop_down_css ='display:none;';



                                

                                  for($i=0;$i<count($data_dropdown);$i++) {

                                   

                                    if($i == 0)

                                    {

                                      $drop_down_css = 'display:block;'; 

                                      $required= 'required=""';

                                    }

                                    else

                                    {

                                        $required= '';

                                        $drop_down_css = 'display:none;';  

                                    }





                                    if($data_dropdown[$i]['pag_cat_status']==0)

                                    {

                                       $drop_down_css1 = 'display:none;'; 

                                    }

                                    else

                                    {

                                       $drop_down_css1 = 'display:block;'; 

                                    }

                                    

                               // echo "<pre>";print_r($data_dropdown[$i]['pag_cat_status']);echo "</pre>";

                               //     echo 'count=>'.count($data_dropdown).'<br>';



                                   $symtum_cat = '';

                                   $data=array();
                                   $final_data = array();

                                  
                                   if($data_dropdown[$i]['sub_cat1']!='')

                                   {

                                      $symtum_cat .= $data_dropdown[$i]['sub_cat1'].',';
                                      //code added by ample 12-11-19
                                      $prof_cat_tbl1=$data_dropdown[$i]['canv_sub_cat1_link'];
                                      $prof_cat_col1=$data_dropdown[$i]['prof_cat1_ref_code'];
                                      $sub_cat1 = explode(',', $data_dropdown[$i]['sub_cat1']);

                                      if($data_dropdown[$i]['canv_sub_cat1_show_fetch']=='2')
                                      { 

                                        //update this 22-11-19 on all page this function
                                        $cat_data1=$obj->getDataFromReportCustomized($sub_cat1,$prof_cat_tbl1,$prof_cat_col1,$data_dropdown[$i]['prof_cat1_uid']);

                                        $final_data=array_merge($final_data,$cat_data1);



                                      }
                                      elseif($data_dropdown[$i]['canv_sub_cat1_show_fetch']=='1')
                                      {
                                          $cat_data1=$obj->getDataFromFavCategory($sub_cat1);
                                          $final_data=array_merge($final_data,$cat_data1);
                                      }

                                   }

                                   if($data_dropdown[$i]['sub_cat2']!='')

                                   {

                                      $symtum_cat .= $data_dropdown[$i]['sub_cat2'].',';
                                      //code added by ample 12-11-19
                                      $prof_cat_tbl2=$data_dropdown[$i]['canv_sub_cat2_link'];
                                      $prof_cat_col2=$data_dropdown[$i]['prof_cat2_ref_code'];
                                      $sub_cat2 = explode(',', $data_dropdown[$i]['sub_cat2']);
                                      if($data_dropdown[$i]['canv_sub_cat2_show_fetch']=='2')
                                      {
                                        $cat_data2=$obj->getDataFromReportCustomized($sub_cat2,$prof_cat_tbl2,$prof_cat_col2,$data_dropdown[$i]['prof_cat2_uid']);
                                        $final_data=array_merge($final_data,$cat_data2);
                                      }
                                      elseif($data_dropdown[$i]['canv_sub_cat2_show_fetch']=='1')
                                      {
                                          $cat_data2=$obj->getDataFromFavCategory($sub_cat2);
                                          $final_data=array_merge($final_data,$cat_data2);
                                      }
                                     
                                   }



                                   if($data_dropdown[$i]['sub_cat3']!='')

                                   {

                                      $symtum_cat .= $data_dropdown[$i]['sub_cat3'].',';
                                      //code added by ample 12-11-19
                                      $prof_cat_tbl3=$data_dropdown[$i]['canv_sub_cat3_link'];
                                      $prof_cat_col3=$data_dropdown[$i]['prof_cat3_ref_code'];
                                      $sub_cat3 = explode(',', $data_dropdown[$i]['sub_cat3']);
                                      if($data_dropdown[$i]['canv_sub_cat3_show_fetch']=='2')
                                      {
                                        $cat_data3=$obj->getDataFromReportCustomized($sub_cat3,$prof_cat_tbl3,$prof_cat_col3,$data_dropdown[$i]['prof_cat3_uid']);
                                        $final_data=array_merge($final_data,$cat_data3);
                                      }
                                      elseif($data_dropdown[$i]['canv_sub_cat3_show_fetch']=='1')
                                      {
                                          $cat_data3=$obj->getDataFromFavCategory($sub_cat3);
                                          $final_data=array_merge($final_data,$cat_data3);
                                      }
                                      
                                   }

                           

                                   if($data_dropdown[$i]['sub_cat4']!='')

                                   {

                                    $symtum_cat .= $data_dropdown[$i]['sub_cat4'].',';
                                     //code added by ample 12-11-19
                                     $prof_cat_tbl4=$data_dropdown[$i]['canv_sub_cat4_link'];
                                      $prof_cat_col4=$data_dropdown[$i]['prof_cat4_ref_code'];
                                      $sub_cat4 = explode(',', $data_dropdown[$i]['sub_cat4']);
                                     if($data_dropdown[$i]['canv_sub_cat4_show_fetch']=='2')
                                      {
                                        $cat_data4=$obj->getDataFromReportCustomized($sub_cat4,$prof_cat_tbl4,$prof_cat_col4,$data_dropdown[$i]['prof_cat4_uid']);
                                        $final_data=array_merge($final_data,$cat_data4);
                                      }
                                      elseif($data_dropdown[$i]['canv_sub_cat4_show_fetch']=='1')
                                      {
                                          $cat_data4=$obj->getDataFromFavCategory($sub_cat4);
                                          $final_data=array_merge($final_data,$cat_data4);
                                      }
                                      
                                      
                                   }



                                   if($data_dropdown[$i]['sub_cat5']!='')

                                   {

                                      $symtum_cat .= $data_dropdown[$i]['sub_cat5'].',';
                                      //code added by ample 12-11-19
                                      $prof_cat_tbl5=$data_dropdown[$i]['canv_sub_cat5_link'];
                                      $prof_cat_col5=$data_dropdown[$i]['prof_cat5_ref_code'];
                                      $sub_cat5 = explode(',', $data_dropdown[$i]['sub_cat5']);
                                      if($data_dropdown[$i]['canv_sub_cat5_show_fetch']=='2')
                                      {
                                         $cat_data5=$obj->getDataFromReportCustomized($sub_cat5,$prof_cat_tbl5,$prof_cat_col5,$data_dropdown[$i]['prof_cat5_uid']);
                                         $final_data=array_merge($final_data,$cat_data5);
                                      }
                                      elseif($data_dropdown[$i]['canv_sub_cat5_show_fetch']=='1')
                                      {
                                          $cat_data5=$obj->getDataFromFavCategory($sub_cat5);
                                          $final_data=array_merge($final_data,$cat_data5);
                                      }
                                     

                                   }


                                  


                                   if($data_dropdown[$i]['sub_cat6']!='')

                                   {

                                    $symtum_cat .= $data_dropdown[$i]['sub_cat6'].',';
                                    //code added by ample 12-11-19
                                      $prof_cat_tbl6=$data_dropdown[$i]['canv_sub_cat6_link'];
                                      $prof_cat_col6=$data_dropdown[$i]['prof_cat6_ref_code'];
                                      $sub_cat6 = explode(',', $data_dropdown[$i]['sub_cat6']);
                                      if($data_dropdown[$i]['canv_sub_cat5_show_fetch']=='2')
                                      {
                                          $cat_data6=$obj->getDataFromReportCustomized($sub_cat6,$prof_cat_tbl6,$prof_cat_col6,$data_dropdown[$i]['prof_cat6_uid']);
                                         $final_data=array_merge($final_data,$cat_data6);

                                      }
                                      elseif($data_dropdown[$i]['canv_sub_cat5_show_fetch']=='1')
                                      {
                                          $cat_data6=$obj->getDataFromFavCategory($sub_cat6);
                                          $final_data=array_merge($final_data,$cat_data6);
                                      }
                                     
                                       

                                   }

                                   //   echo "<pre>";

                                   // print_r($final_data); die('dgjf5');



                                   if($data_dropdown[$i]['sub_cat7']!='')

                                   {

                                    $symtum_cat .= $data_dropdown[$i]['sub_cat7'].',';
                                       //code added by ample 12-11-19
                                      $prof_cat_tbl7=$data_dropdown[$i]['canv_sub_cat7_link'];
                                      $prof_cat_col7=$data_dropdown[$i]['prof_cat7_ref_code'];
                                      $sub_cat7 = explode(',', $data_dropdown[$i]['sub_cat7']);
                                      if($data_dropdown[$i]['canv_sub_cat7_show_fetch']=='2')
                                      {
                                          $cat_data7=$obj->getDataFromReportCustomized($sub_cat7,$prof_cat_tbl7,$prof_cat_col7,$data_dropdown[$i]['prof_cat7_uid']);
                                         $final_data=array_merge($final_data,$cat_data7);

                                      }
                                      elseif($data_dropdown[$i]['canv_sub_cat7_show_fetch']=='1')
                                      {
                                         $cat_data7=$obj->getDataFromFavCategory($sub_cat7);
                                          $final_data=array_merge($final_data,$cat_data7);
                                      }
                                      

                                   }

                                   //  echo "<pre>";

                                   // print_r($final_data); die('sfsaf');


                                   if($data_dropdown[$i]['sub_cat8']!='')

                                   {

                                    $symtum_cat .= $data_dropdown[$i]['sub_cat8'].',';
                                      //code added by ample 12-11-19
                                     $prof_cat_tbl8=$data_dropdown[$i]['canv_sub_cat8_link'];
                                      $prof_cat_col8=$data_dropdown[$i]['prof_cat8_ref_code'];
                                      $sub_cat8 = explode(',', $data_dropdown[$i]['sub_cat8']);
                                      if($data_dropdown[$i]['canv_sub_cat8_show_fetch']=='2')
                                      {
                                         $cat_data8=$obj->getDataFromReportCustomized($sub_cat8,$prof_cat_tbl8,$prof_cat_col8,$data_dropdown[$i]['prof_cat8_uid']);
                                        $final_data=array_merge($final_data,$cat_data8);

                                      }
                                      elseif($data_dropdown[$i]['canv_sub_cat8_show_fetch']=='1')
                                      {
                                          $cat_data8=$obj->getDataFromFavCategory($sub_cat8);
                                          $final_data=array_merge($final_data,$cat_data8);
                                      }
                                      

                                   }

                                   if($data_dropdown[$i]['sub_cat9']!='')

                                   {

                                    $symtum_cat .= $data_dropdown[$i]['sub_cat9'].',';
                                      //code added by ample 12-11-19
                                      $prof_cat_tbl9=$data_dropdown[$i]['canv_sub_cat9_link'];
                                      $prof_cat_col9=$data_dropdown[$i]['prof_cat9_ref_code'];
                                      $sub_cat9 = explode(',', $data_dropdown[$i]['sub_cat9']);
                                      if($data_dropdown[$i]['canv_sub_cat9_show_fetch']=='2')
                                      {
                                          $cat_data9=$obj->getDataFromReportCustomized($sub_cat9,$prof_cat_tbl9,$prof_cat_col9,$data_dropdown[$i]['prof_cat9_uid']);
                                          $final_data=array_merge($final_data,$cat_data9);

                                      }
                                      elseif($data_dropdown[$i]['canv_sub_cat9_show_fetch']=='1')
                                      {
                                          $cat_data9=$obj->getDataFromFavCategory($sub_cat9);
                                          $final_data=array_merge($final_data,$cat_data9);
                                      }
                                      

                                   }

                                   if($data_dropdown[$i]['sub_cat10']!='')

                                   {

                                    $symtum_cat .= $data_dropdown[$i]['sub_cat10'].',';
                                     //code added by ample 12-11-19
                                      $prof_cat_tbl10=$data_dropdown[$i]['canv_sub_cat10_link'];
                                      $prof_cat_col10=$data_dropdown[$i]['prof_cat10_ref_code'];
                                      $sub_cat10 = explode(',', $data_dropdown[$i]['sub_cat10']);
                                      if($data_dropdown[$i]['canv_sub_cat10_show_fetch']=='2')
                                      {
                                          $cat_data10=$obj->getDataFromReportCustomized($sub_cat10,$prof_cat_tbl10,$prof_cat_col10,$data_dropdown[$i]['prof_cat10_uid']);
                                          $final_data=array_merge($final_data,$cat_data10);

                                      }
                                      elseif($data_dropdown[$i]['canv_sub_cat10_show_fetch']=='1')
                                      {
                                          $cat_data10=$obj->getDataFromFavCategory($sub_cat10);
                                          $final_data=array_merge($final_data,$cat_data10);
                                      }
                                     

                                   }

                                   $symtum_cat = explode(',', $symtum_cat);

                                   $symtum_cat = array_filter($symtum_cat);
                                
                                  // echo '$symtum_cat<pre>';
                                  // print_r($symtum_cat);
                                  // echo '</pre>';
                                  // die('kjfh');
                                   
                                   $final_array = $obj->getAllMainSymptomsRamakantFront($symtum_cat);
                                   
                                 // echo '<pre>';
                                 // print_r($final_array);
                                 //  print_r($final_data);
                                 //  echo '</pre>';
                                 // die('asjfsagfas');
                                  
                                  if($data_dropdown[$i]['time_show']!=0)

                                  {

                                     $time_show_icon = $obj->getMyDayTodayIcon('time_show'); 

                                  }

                                    else {

                                        $time_show_icon = '';

                                    }

                                   

                                   if($data_dropdown[$i]['duration_show']!=0)

                                    {

                                       $duration_show_icon = $obj->getMyDayTodayIcon('duration_show'); 

                                    }

                                    else {

                                        $duration_show_icon = '';

                                    }

                                    

                                    if($data_dropdown[$i]['location_show']!=0)

                                    {

                                       $location_show_icon = $obj->getMyDayTodayIcon('location_show'); 

                                    }

                                    else {

                                        $location_show_icon = '';

                                    }

                                    

                                     if($data_dropdown[$i]['User_view']!=0)

                                    {

                                       $User_view_icon = $obj->getMyDayTodayIcon('User_view'); 

                                    }

                                    else {

                                        $User_view_icon = '';

                                    }

                                    

                                     if($data_dropdown[$i]['User_Interaction']!=0)

                                    {

                                       $User_Interaction_icon = $obj->getMyDayTodayIcon('User_Interaction'); 

                                    }

                                    else {

                                        $User_Interaction_icon = '';

                                    }

                                    

                                    if($data_dropdown[$i]['scale_show']!=0)

                                    {

                                       $scale_show_icon = $obj->getMyDayTodayIcon('scale_show'); 

                                    }

                                    else {

                                        $scale_show_icon = '';

                                    }

                                    

                                    if($data_dropdown[$i]['alert_show']!=0)

                                    {

                                       $alert_show_icon = $obj->getMyDayTodayIcon('alert_show'); 

                                    }

                                    else {

                                        $alert_show_icon = '';

                                    }

                                    

                                    if($data_dropdown[$i]['comment_show']!=0)

                                    {

                                       $comment_show_icon = $obj->getMyDayTodayIcon('comments_show'); 

                                    }

                                    else {

                                        $comment_show_icon = '';

                                    }

                                    

                                   ?>

                               

                               <div class="col-md-12" style="margin-bottom:25px;">

                                   <div class="col-md-12">

                                      <!-- commented code re open by ample 11-02-20 as email -- start -->

                                       <!-- <label class="col-lg-6 dlist" style="<?php echo $drop_down_css; ?>"><?php echo $data_dropdown[$i]['heading']; ?></label>

                                       <label class="col-lg-6 dlist">Positive suggestion</label><br> -->

                                       <!-- commented code re open by ample 11-02-20 as email -- end -->

                                       <input type="hidden" name="heading[]" value="<?php echo $data_dropdown[$i]['heading']; ?>"/>

                                   </div>







                                   <div class="col-md-10" style="margin-top:25px;<?php echo $drop_down_css1;?>">

                                       <input type="text" <?php echo $required; ?> title="<?php echo $data_dropdown[$i]['heading']; ?>" name="bes_id[]" id="bes_id_<?php echo $i;?>" placeholder="Select your <?php echo $data_dropdown[$i]['heading']; ?>" list="capitals<?php echo $i; ?>" class="input-text-box dlist" style="width:300px; <?php echo $drop_down_css; ?>" onchange="icon_show(<?php echo $i; ?>)" autocomplete="off"/>

                                   <datalist id="capitals<?php echo $i; ?>" class="dlist" >

                                        <!-- <?php //echo $obj->GetDatadropdownoption($final_array); ?>   -->
                                       <!--  code added by ample 13-11-19  -->
                                        <?php 

                                        if(!empty($final_data))
                                        {
                                          sort($final_data);
                                          foreach ($final_data as $key => $value) {
                                            ?>
                                            <option value="<?=$value;?>"><?=$value;?></option>
                                            <?php
                                          }
                                        }
                                        ?>

                                    </datalist>

                                      <a href="javascript:void(0);" onclick="erase_input(<?php echo $i; ?>);"><i class="fa fa-eraser" id="erase_icon<?php echo $i; ?>" aria-hidden="true" style="font-size: 15px; <?php echo $drop_down_css; ?>"></i></a>

                                       <br>

                                       <span id="message" style="color:blue; font-size: 10px; <?php echo $drop_down_css; ?>">(Type 4 letters and select keyword option)</span>

                                   

                                   <!-- <span style="margin-left:100px;" id="comment_backend_<?php echo $i; ?>"></span> -->



                                   </div>





                                   <div class="col-md-12" style="margin-top:25px; display:none;" id="icon_show_<?php echo $i; ?>">

                                       <span style="font-size:14px; font-weight: bold;">Describe More..</span>

                                        

                                        <?php if($scale_show_icon!='') { ?>

                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $scale_show_icon; ?>" name="scale_show_icon_<?php echo $i; ?>" id="scale_show_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select <?php echo $data_dropdown[$i]['scale_heading']; ?>" onclick="ShowScale(<?php echo $i; ?>);">

                                        <?php } ?>

                                        

                                        <?php if($time_show_icon!='') { ?>

                                         &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $time_show_icon; ?>" name="time_show_icon_<?php echo $i; ?>" id="time_show_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select <?php echo $data_dropdown[$i]['time_heading']; ?>" onclick="ShowTime(<?php echo $i; ?>);">

                                        <?php } ?>

                                        <?php if($duration_show_icon!='') { ?>

                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $duration_show_icon; ?>" name="duration_show_icon_<?php echo $i; ?>" id="duration_show_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select <?php echo $data_dropdown[$i]['duration_heading']; ?>" onclick="ShowDuration(<?php echo $i; ?>);">

                                        <?php } ?>

                                        

                                            

                                        <?php if($location_show_icon!='') { ?>

                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $location_show_icon; ?>" name="location_show_icon_<?php echo $i; ?>" id="location_show_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select <?php echo $data_dropdown[$i]['location_heading']; ?>" onclick="ShowLocation(<?php echo $i; ?>);">

                                         <?php } ?>

                                        

                                         <?php if($User_view_icon!='') { ?>

                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_view_icon; ?>" name="User_view_icon_<?php echo $i; ?>" id="User_view_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select <?php echo $data_dropdown[$i]['like_dislike_heading']; ?>" onclick="ShowUserview(<?php echo $i; ?>);">

                                        <?php } ?>

                                        

                                        <?php if($User_Interaction_icon!='') { ?>

                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $User_Interaction_icon; ?>" name="User_Interaction_icon_<?php echo $i; ?>" id="User_Interaction_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select <?php echo $data_dropdown[$i]['set_goals_heading']; ?>" onclick="ShowUserInteraction(<?php echo $i; ?>);">

                                          <?php } ?>

                                        

                                         <?php if($alert_show_icon!='') { ?>

                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $alert_show_icon; ?>" name="alert_show_icon_<?php echo $i; ?>" id="alert_show_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="Select <?php echo $data_dropdown[$i]['reminder_heading']; ?>" onclick="ShowAlert(<?php echo $i; ?>);">

                                        <?php } ?>

                                        

                                        <?php if($comment_show_icon!='') { ?>

                                        &nbsp;&nbsp;&nbsp;<img src="uploads/<?php echo $comment_show_icon; ?>" name="comment_show_icon_<?php echo $i; ?>" id="comment_show_icon_<?php echo $i; ?>" style="width:25px; height: 25px;" title="<?php echo $data_dropdown[$i]['comments_heading']; ?>" onclick="ShowComment(<?php echo $i; ?>);">

                                        <?php } ?>

                                   </div>

                                        <div class="md-col-12">

                                            <!--<input  type="text" name="scale[]" id="scale_<?php //echo $i;?>"  placeholder="<?php //echo $data_dropdown[$i]['scale_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">-->

                                            <select  class="input-text-box input-quarter-width" name="scale[]" id="scale_<?php echo $i;?>" style="display:none;" title="<?php echo $data_dropdown[$i]['scale_heading']; ?>">

                                                <option value=""><?php echo $data_dropdown[$i]['scale_heading']; ?></option>

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

                                            

                                            <div>
                                            <input type="time" name="bes_time[]" id="bes_time_<?php echo $i;?>" placeholder="<?php echo $data_dropdown[$i]['time_heading']; ?>" title="<?php echo $data_dropdown[$i]['time_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;"> &nbsp;&nbsp;
                                            <span class="text-danger" id="time_note_<?php echo $i;?>" style="display:none;font-size: 11px;"><a href="images/Device-SystemTime-Format.png" target="_blank" style="color: red;">Displays AM/PM or 24 Hour Format as per your Device Time Setting</a></span> &nbsp;&nbsp; </div>
                                            <!-- update by ample 21-04-20 -->
                                            <!-- <select  class="input-text-box input-quarter-width" name="bes_time[]" id="bes_time_<?php echo $i;?>" style="display:none;" title="<?php echo $data_dropdown[$i]['time_heading']; ?>">

                                                <option value=""><?php echo $data_dropdown[$i]['time_heading']; ?></option>

                                                <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>

                                            </select>
 -->                                        <div class="row col-md-12">
                                            <input type="text" name="duration[]" id="duration_<?php echo $i;?>" onKeyPress="return isNumberKey(event);" placeholder="<?php echo $data_dropdown[$i]['duration_heading']; ?>" title="<?php echo $data_dropdown[$i]['duration_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;width: 13%!important;">

                                            <!-- add by ample 21-04-20 -->
                                            <select  class="input-text-box input-quarter-width" name="unit[]" id="unit_<?php echo $i;?>" style="display:none;" title="Duration Type">

                                                <option value="">Select Unit</option>
                                                <?php
                                                    echo $obj->getFavCategoryRamakant('82',''); 
                                                ?>
                                            </select>
                                            </div>
                                            

                                            <select  class="input-text-box input-quarter-width" name="location[]" id="location_<?php echo $i;?>" style="display:none;" title="<?php echo $data_dropdown[$i]['location_heading']; ?>">

                                                <option value=""><?php echo $data_dropdown[$i]['location_heading']; ?></option>

                                                <?php 
                                                  if($data_dropdown[$i]['canv_loc_cat_show_fetch']=='2')
                                                  { 
                                                      $location_fav_cat = explode(',', $data_dropdown[$i]['location_fav_cat']);
                                                      $loc_cat=$obj->getDataFromReportCustomized($location_fav_cat,$data_dropdown[$i]['canv_loc_cat_link'],$data_dropdown[$i]['location_ref_code'],$data_dropdown[$i]['loc_cat_uid']);
                                                      if(!empty($loc_cat))
                                                        {
                                                          foreach ($loc_cat as $key => $value) {
                                                            ?>
                                                            <option value="<?=$value;?>"><?=$value;?></option>
                                                            <?php
                                                          }
                                                        }
                                                  }
                                                  else
                                                  {
                                                    echo $obj->getFavCategoryRamakant($data_dropdown[$i]['location_fav_cat'],''); 
                                                  }
                                                ?>
                                            </select>

                                            

                                            <select  class="input-text-box input-quarter-width" name="User_view[]" id="User_view_<?php echo $i;?>" style="display:none;" title="<?php echo $data_dropdown[$i]['like_dislike_heading']; ?>">

                                                <option value=""><?php echo $data_dropdown[$i]['like_dislike_heading']; ?></option>

                                               
                                                <?php 
                                                  if($data_dropdown[$i]['canv_user_cat_show_fetch']=='2')
                                                  {   
                                                      $user_response_fav_cat = explode(',', $data_dropdown[$i]['user_response_fav_cat']);
                                                      $user_res=$obj->getDataFromReportCustomized($user_response_fav_cat,$data_dropdown[$i]['canv_user_cat_link'],$data_dropdown[$i]['ur_ref_code'],$data_dropdown[$i]['ur_cat_uid']);
                                                      if(!empty($user_res))
                                                        {
                                                          foreach ($user_res as $key => $value) {
                                                            ?>
                                                            <option value="<?=$value;?>"><?=$value;?></option>
                                                            <?php
                                                          }
                                                        }
                                                  }
                                                  else
                                                  {
                                                     echo $obj->getFavCategoryRamakant($data_dropdown[$i]['user_response_fav_cat'],'');
                                                  }
                                                ?>

                                            </select>

                                            

                                            <select  class="input-text-box input-quarter-width" name="User_Interaction[]" id="User_Interaction_<?php echo $i;?>" style="display:none;" title="<?php echo $data_dropdown[$i]['set_goals_heading']; ?>">

                                                <option value=""><?php echo $data_dropdown[$i]['set_goals_heading']; ?></option>

                                                <?php 
                                                  if($data_dropdown[$i]['canv_wn_cat_show_fetch']=='2')
                                                  { 
                                                      $user_what_fav_cat = explode(',', $data_dropdown[$i]['user_what_fav_cat']);
                                                      $user_wn=$obj->getDataFromReportCustomized($user_what_fav_cat,$data_dropdown[$i]['canv_wn_cat_link'],$data_dropdown[$i]['uw_ref_code'],$data_dropdown[$i]['uwn_uid']);
                                                      if(!empty($user_wn))
                                                        {
                                                          foreach ($user_wn as $key => $value) {
                                                            ?>
                                                            <option value="<?=$value;?>"><?=$value;?></option>
                                                            <?php
                                                          }
                                                        }
                                                  }
                                                  else
                                                  {
                                                    echo $obj->getFavCategoryRamakant($data_dropdown[$i]['user_what_fav_cat'],'');
                                                  }
                                                ?>

                                            </select>

                                            

                                            <select class="input-text-box input-quarter-width" name="alert[]" id="alert_<?php echo $i;?>" style="display:none;" title="<?php echo $data_dropdown[$i]['reminder_heading']; ?>">

                                                <option value=""><?php echo $data_dropdown[$i]['reminder_heading']; ?></option>

                        
                                                <?php 
                                                  if($data_dropdown[$i]['canv_au_cat_show_fetch']=='2')
                                                  {   
                                                      $alerts_fav_cat = explode(',', $data_dropdown[$i]['alerts_fav_cat']);
                                                      $au_cat=$obj->getDataFromReportCustomized($alerts_fav_cat,$data_dropdown[$i]['canv_au_cat_link'],$data_dropdown[$i]['au_ref_code'],$data_dropdown[$i]['au_cat_uid']);
                                                      if(!empty($au_cat))
                                                        {
                                                          foreach ($au_cat as $key => $value) {
                                                            ?>
                                                            <option value="<?=$value;?>"><?=$value;?></option>
                                                            <?php
                                                          }
                                                        }
                                                  }
                                                  else
                                                  {
                                                     echo $obj->getFavCategoryRamakant($data_dropdown[$i]['alerts_fav_cat'],'');
                                                  }
                                                ?>

                                            </select>

                                            <textarea name="comment[]" id="comment_<?php echo $i;?>" style="display:none;" class="input-text-box input-quarter-width" autocomplete="false" title="<?php echo $data_dropdown[$i]['comments_heading']; ?>" placeholder="<?php echo $data_dropdown[$i]['comments_heading']; ?>" ></textarea>





                                            <!--<input  type="text" name="comment[]" id="comment_<?php //echo $i;?>"  placeholder="<?php //echo $data_dropdown[$i]['comments_heading']; ?>" class="input-text-box input-quarter-width" autocomplete="false" style="display:none;">-->

                                            

                                        </div>

                              </div>

                               

                               <?php } ?>


                               <?php 

                               if($access_btn==1)
                               {
                                  ?>
                                  <input class="btn-red" style="text-align: center; margin-left: 250px; margin-bottom: 20px;" type="submit" name="btnSubmit" id="btnSubmit" value="Breathe In. Breathe Out.">
                                  <?php
                               }
                               else
                               {
                                  ?>
                                  <input class="btn-red" style="text-align: center; margin-left: 250px; margin-bottom: 20px;" type="button" onclick="plan_msg()" value="Breathe In. Breathe Out.">
                                  <?php
                               }

                               ?>

                               

                           

                        </div>

                       

                        </form>

                </div>

                <div class="col-md-3">


                 <div id='change_avatar' class="text-center"></div>


                  <br style="clear: both;">


                      <?php 
                        // add by ample 16-12-19  

                      foreach ($data_dropdown as $key => $value) {

                          if($value['level']==0)
                          {
                            $value['level']="";
                          }

                        ?>
                        <br>
                          <div class="pull-right col-md-12">
                              <p>
                              <?=($value['level_heading'])? $value['level_heading'].'-'.$value['level'] : '' ;?>  </p> <p>
                              <?=($value['level_title_heading'])? $value['level_title_heading'].'-'.$value['level_title'] : '' ;?> </p>
                            
                             <?php if($value['level_icon']!='') { 
                              
                              if($value['level_icon_type']=='Image')
                              {   

                                  $imgData=$obj->getImgData($value['level_icon']);
                                  if(!empty($imgData['image']))
                                  {   
                                      ?>
                                      <div class="text-center">
                                      <img src="uploads/<?php echo $imgData['image']; ?>" style="width:55px; height: 55px;" title="<?=$value['level_icon_heading'];?>">
                                      </div>
                                      <?php
                                  }
                              }
                              else
                              {   
                                  $fileData=$obj->getFileData($value['level_icon']);
                                  ?>
                                  <a href="<?php echo SITE_URL.'/uploads/'. $fileData['box_banner'];?>" target="_blank"><?php echo $fileData['box_banner'];?></a> 
                                  <?php
                              }
                          ?>
                          <?php } ?>
                           <br>
                          </div>
                          <?php
                      }


                      ?>

                </div>

              </div>


          </div>

      <div class="col-md-2">

        <?php include_once('right_sidebar.php'); ?>
        
        <?php include_once('left_sidebar.php'); ?>
      </div>

      

    </div>

  </div>

</section>

<?php include_once('footer.php');?>  

    <script>


      //new code by ample 14-11-19
       $('.datepicker').on('focus', function(e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");  
    });

       //code by ample 08-01-20
       $('.input-text-box.dlist').on('focus', function(e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");  
    });


        $(document).ready(function(){
             //code by ample 08-01-20
              $('.input-text-box.dlist').attr('autocomplete', 'off');

               $('#day_month_year').attr('autocomplete', 'off');

                $('#day_month_year').datepicker(

                        {

                            dateFormat: 'dd-mm-yy',

                            minDate: '-1D',

                            maxDate: '+0D',

                        }        

                );

               

               $('.vloc_speciality_offered').tokenize();


            });







    function ShowTime(id)

    {

      //alert(id);

      $('#bes_time_'+id).show();  
      $('#time_note_'+id).show(); 
    }

    

    function ShowDuration(id)

    {

      //alert("hiiii");

      $('#duration_'+id).show();  
      $('#unit_'+id).show(); //add by ample
    }

    

    function ShowScale(id)

    {

      //alert("hiiii");

      $('#scale_'+id).show();  

    }

    

    function ShowLocation(id)

    {

      //alert("hiiii");

      $('#location_'+id).show();  

    }

    

    function ShowAlert(id)

    {

      //alert("hiiii");

      $('#alert_'+id).show();  

    }

    

    function ShowUserInteraction(id)

    {

      //alert("hiiii");

      $('#User_Interaction_'+id).show();  

    }

    

    function ShowUserview(id)

    {

      //alert("hiiii");

      $('#User_view_'+id).show();  

    }

    

    function ShowComment(id)

    {

      //alert("hiiii");

      $('#comment_'+id).show();  

    }

    



     function erase_input(id)

     {

       $("#bes_id_"+id).val('');



     }





    function icon_show(id)

    {

       //alert('id');

        var bes_name = $("#bes_id_"+id).val();

        var day_month_year = $("#day_month_year"+id).val();

        $('.dlist').show();  

       $('#icon_show_'+id).show(); 

        $('#erase_icon'+id).show(); 

       $('#message').css("display","block"); 

       

       var dataString ='bes_name='+bes_name +'&day_month_year'+day_month_year+'&action=getbescomment';

        $.ajax({

            type: "POST",

            url: 'my_day_today.php', 

            data: dataString,

            cache: false,

            success: function(result)

                 {

                    //alert(result);

                    $('#comment_backend_'+id).html(result);

                }

           });

    }

    

    function viewpost()

    {

      // alert('hiiii'); 

      $('#sequence_show').show();  

      $('#sequence').hide();  

    }

    

    function GETSEQUENCE()

    {

        var date = $("#day_month_year").val();

        var dataString ='date='+date +'&action=getsequence';

        $.ajax({

            type: "POST",

            url: 'my_day_today.php', 

            data: dataString,

            cache: false,

            success: function(result)

                 {

                     //alert(result);

                    //$('#sequence_show').show();  

                    $('#sequence').show(); 

                    $('#sequence_label').show(); 

                    $('#sequence').val(result);  

                }

           });

    }

    

    function isNumberKey(evt){  

      //comment this 14-11-19
      //<!--Function to accept only numeric values-->

    //var e = evt || window.event;

  var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode != 46 && charCode > 31 

  && (charCode < 48 || charCode > 57))

        return false;

        return true;

  }

  //added by ample

  function plan_msg()
  {
    $('#plan_msg').fadeIn();
    $("html").animate({ scrollTop: 0 }, "slow");
  }

</script>

</body>

</html>